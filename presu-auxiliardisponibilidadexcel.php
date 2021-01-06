<?php  
	require_once 'PHPExcel/Classes/PHPExcel.php';
	require "comun.inc";
	require "funciones.inc";
	session_start();
	$linkbd=conectar_bd();  
	$objPHPExcel = new PHPExcel();
	//----Propiedades----
	$objPHPExcel->getProperties()
        ->setCreator("SPID")
        ->setLastModifiedBy("SPID")
        ->setTitle("Auxiliar de disponibilidades")
        ->setSubject("Presupuesto")
        ->setDescription("Presupuesto")
        ->setKeywords("Presupuesto")
        ->setCategory("Presupuesto");
    //----Cuerpo de Documento----
    $conexion = conectar_v7();
    $sqlr="select *from configbasica where estado='S'";
    $res=mysqli_query($conexion,$sqlr);
    while($row=mysqli_fetch_row($res))
    {
        $nit=$row[0];
        $rs=$row[1];
    }

	$objPHPExcel->getActiveSheet()->mergeCells('A1:L1');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $rs." - ".$nit);
    
    $objPHPExcel->getActiveSheet()->mergeCells('A2:L2');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', 'AUXILIAR DE DISPONIBILIDADES - Periodo: '.$_POST[fechaini].' - '.$_POST[fechafin]);

	$objFont=$objPHPExcel->getActiveSheet()->getStyle('A1:A2')->getFont();
	$objFont->setName('Courier New'); 
	$objFont->setSize(15); 
	$objFont->setBold(true); 
	$objFont->setUnderline(PHPExcel_Style_Font::UNDERLINE_SINGLE);
    $objFont->getColor()->setARGB( PHPExcel_Style_Color::COLOR_BLACK);
    


	$objAlign=$objPHPExcel->getActiveSheet()->getStyle('A1:A2')->getAlignment(); 
	$objAlign->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
	$objAlign->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
	$objPHPExcel-> getActiveSheet ()
		-> getStyle ("A3:L3")	
        -> getFill ()
        -> setFillType (PHPExcel_Style_Fill :: FILL_SOLID)
        -> getStartColor ()
        -> setRGB ('A6E5F3');
	$objPHPExcel-> getActiveSheet ()
		-> getStyle ("A1:A2")	
        -> getFill ()
        -> setFillType (PHPExcel_Style_Fill :: FILL_SOLID)
        -> getStartColor ()
        -> setRGB ('A6E5F3');
	$borders = array(
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN,
          'color' => array('argb' => 'FF000000'),
        )
      ),
    );
	$objPHPExcel->getActiveSheet()->getStyle('A3:L3')->applyFromArray($borders);
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A3', 'FECHA')
	->setCellValue('B3', 'TIPO COMPROBANTE')
	->setCellValue('C3', 'NO COMPROBANTE')
	->setCellValue('D3', 'VIGENCIA')
	->setCellValue('E3', 'RUBRO')
	->setCellValue('F3', 'NOMBRE RUBRO')
	->setCellValue('G3', 'FUENTE')
	->setCellValue('H3', 'NOMBRE FUENTE')
	->setCellValue('I3', 'DETALLE')
	->setCellValue('J3', 'VALOR')
	->setCellValue('K3', 'ESTADO')
	->setCellValue('L3', 'TIPO MOVIMIENTO');
	
    $i=4;
    $sqlr = "SELECT pptocdp.consvigencia, pptocdp.fecha, pptocdp.objeto, pptocdp.vigencia, pptocdp.estado, pptocdp.tipo_mov FROM pptocdp WHERE pptocdp.fecha BETWEEN '$_POST[fechaini]' AND '$_POST[fechafin]' ORDER BY pptocdp.fecha, pptocdp.consvigencia";
	$resp = mysqli_query($conexion, $sqlr);
    while ($row = mysqli_fetch_row($resp))
    {
        $sqld = "SELECT cuenta, fuente, valor FROM pptocdp_detalle WHERE vigencia='$row[3]' AND consvigencia='$row[0]' AND tipo_mov='$row[5]'";
		$resd=mysqli_query($conexion, $sqld);
		$estado = '';
		if($row[4] == 'N')
		{
			$estado = 'ANULADO';
		}
		else if($row[4] == 'R')
		{
			$estado = 'REVERSADO';
		}
		else
		{
			$estado = 'ACTIVO';
		}

        while($rowd = mysqli_fetch_row($resd))
        {
            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValueExplicit ("A$i", $row[1], PHPExcel_Cell_DataType :: TYPE_STRING)
            ->setCellValueExplicit ("B$i", 'DISPONIBILIDAD', PHPExcel_Cell_DataType :: TYPE_STRING)
            ->setCellValueExplicit ("C$i", $row[0], PHPExcel_Cell_DataType :: TYPE_STRING)
            ->setCellValueExplicit ("D$i", $row[3], PHPExcel_Cell_DataType :: TYPE_STRING)
            ->setCellValueExplicit ("E$i", $rowd[0], PHPExcel_Cell_DataType :: TYPE_STRING)
            ->setCellValueExplicit ("F$i", iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",buscacuentapres($rowd[0])), PHPExcel_Cell_DataType :: TYPE_STRING)
            ->setCellValueExplicit ("G$i", $rowd[1], PHPExcel_Cell_DataType :: TYPE_NUMERIC)
            ->setCellValueExplicit ("H$i", iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",buscafuenteppto($rowd[0], $row[3])), PHPExcel_Cell_DataType :: TYPE_STRING)
            ->setCellValueExplicit ("I$i", iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$row[2]), PHPExcel_Cell_DataType :: TYPE_STRING)
            ->setCellValueExplicit ("J$i", $rowd[2], PHPExcel_Cell_DataType :: TYPE_NUMERIC)
            ->setCellValueExplicit ("K$i", $estado, PHPExcel_Cell_DataType :: TYPE_STRING)
            ->setCellValueExplicit ("L$i", $row[5], PHPExcel_Cell_DataType :: TYPE_NUMERIC);
            $objPHPExcel->getActiveSheet()->getStyle("A$i:L$i")->applyFromArray($borders);
            $i++;
        }
    }
		
	//----Propiedades de la hoja 1
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth('60');
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth('60');
	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth('60');
	$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->setTitle('DISPONIBILIDADES');
	$objPHPExcel->setActiveSheetIndex(0);

//----Guardar documento----
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="auxiliardisponibilidad.xls"');
header('Cache-Control: max-age=0');
 
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
$objWriter->save('php://output');
exit;

?>