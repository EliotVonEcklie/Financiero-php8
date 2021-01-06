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
        ->setTitle("Cuentas por pagar")
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

	$objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $rs." - ".$nit);
    
    $objPHPExcel->getActiveSheet()->mergeCells('A2:G2');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', 'AUXILIAR DE OBLIGACIONES - Periodo: '.$_POST[fecha].' - '.$_POST[fecha2]);

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
		-> getStyle ("A3:G3")	
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
	$objPHPExcel->getActiveSheet()->getStyle('A3:G3')->applyFromArray($borders);
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A3', 'CXP')
	->setCellValue('B3', 'VIGENCIA')
	->setCellValue('C3', 'NO RP')
	->setCellValue('D3', 'DETALLE')
	->setCellValue('E3', 'VALOR')
	->setCellValue('F3', 'FECHA')
	->setCellValue('G3', 'ESTADO');
	
    $i=4;
    //$sqlr = "SELECT pptocdp.consvigencia, pptocdp.fecha, pptocdp.objeto, pptocdp.vigencia, pptocdp.estado, pptocdp.tipo_mov FROM pptocdp WHERE pptocdp.fecha BETWEEN '$_POST[fechaini]' AND '$_POST[fechafin]' ORDER BY pptocdp.fecha, pptocdp.consvigencia";
    //$resp = mysqli_query($conexion, $sqlr);
    
    $fech1=split("/",$_POST[fecha]);
    $fech2=split("/",$_POST[fecha2]);
    $f1=$fech1[2]."-".$fech1[1]."-".$fech1[0];
    $f2=$fech2[2]."-".$fech2[1]."-".$fech2[0];
    if ($_POST[nombre]!="")
    $crit1="and concat_ws(' ', id_orden, conceptorden) LIKE '%$_POST[nombre]%'";
    if($_POST[fecha]!='')
        $crit=" and tesoordenpago.fecha BETWEEN '$f1' AND '$f2'";
    $sqlr="select * from tesoordenpago where tesoordenpago.id_orden>-1 ".$crit." ".$crit1." order by tesoordenpago.id_orden desc";
    $resp = mysqli_query($conexion, $sqlr);

    while ($row = mysqli_fetch_row($resp))
    {

        if($row[13]=='S')
            $est="ACTIVO";
        elseif($row[13]=='N')
            $est="ANULADO";
        elseif($row[13]=='R')
            $est="REVERSADO";
        elseif($row[13]=='P')
            $est="PAGO";

        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValueExplicit ("A$i", $row[0], PHPExcel_Cell_DataType :: TYPE_STRING)
        ->setCellValueExplicit ("B$i", $row[3], PHPExcel_Cell_DataType :: TYPE_STRING)
        ->setCellValueExplicit ("C$i", $row[4], PHPExcel_Cell_DataType :: TYPE_STRING)
        ->setCellValueExplicit ("D$i", iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$row[7]), PHPExcel_Cell_DataType :: TYPE_STRING)
        ->setCellValueExplicit ("E$i", $row[10], PHPExcel_Cell_DataType :: TYPE_NUMERIC)
        ->setCellValueExplicit ("F$i", $row[2], PHPExcel_Cell_DataType :: TYPE_STRING)
        ->setCellValueExplicit ("G$i", $est, PHPExcel_Cell_DataType :: TYPE_STRING);
        $objPHPExcel->getActiveSheet()->getStyle("A$i:G$i")->applyFromArray($borders);
        $i++;
        
    }
		
	//----Propiedades de la hoja 1
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth('60');
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->setTitle('OBLIGACIONES');
	$objPHPExcel->setActiveSheetIndex(0);

//----Guardar documento----
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="AUXILIAR_COMPROMISOS.xls"');
header('Cache-Control: max-age=0');
 
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
$objWriter->save('php://output');
exit;

?>