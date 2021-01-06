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
        ->setTitle("Reporte Contratos")
        ->setSubject("Presupuesto")
        ->setDescription("Presupuesto")
        ->setKeywords("Presupuesto")
        ->setCategory("Presupuesto");
	//----Cuerpo de Documento----
	$objPHPExcel->getActiveSheet()->mergeCells('A1:M1');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'CONTRATOS');

	$objFont=$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont();
	$objFont->setName('Courier New'); 
	$objFont->setSize(15); 
	$objFont->setBold(true); 
	$objFont->setUnderline(PHPExcel_Style_Font::UNDERLINE_SINGLE);
	$objFont->getColor()->setARGB( PHPExcel_Style_Color::COLOR_BLACK);

	$objAlign=$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment(); 
	$objAlign->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
	$objAlign->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
	$objPHPExcel-> getActiveSheet ()
		-> getStyle ("A2:M2")	
        -> getFill ()
        -> setFillType (PHPExcel_Style_Fill :: FILL_SOLID)
        -> getStartColor ()
        -> setRGB ('A6E5F3');
	$objPHPExcel-> getActiveSheet ()
		-> getStyle ("A1")	
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
	$objPHPExcel->getActiveSheet()->getStyle('A2:M2')->applyFromArray($borders);
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A2', 'CONTRATO')
	->setCellValue('B2', 'RP')
	->setCellValue('C2', 'CDP')
	->setCellValue('D2', 'CONCEPTO')
	->setCellValue('E2', 'FUENTE')
	->setCellValue('F2', 'TERCERO')
	->setCellValue('G2', 'NOMBRE TERCERO')
	->setCellValue('H2', 'RUBRO')
	->setCellValue('I2', 'NOMBRE RUBRO')
	->setCellValue('J2', 'FECHA')
	->setCellValue('K2', 'VALOR')
	->setCellValue('L2', 'ESTADO')
	->setCellValue('M2', 'CLASIFICACION');
	
	$i=3;
    for($xx=0; $xx<count($_POST[contrato]); $xx++)
    {
		$estadoContrato='';
		$terceroB = '';
		$rubro = '';
		$fuenteRp ='';
		$clasificacion = '';
        if($_POST[estado][$xx]=='N' || $_POST[estado][$xx]=='R' || $_POST[estado][$xx]=='')
            $estadoContrato = 'REVERSADO';
        else
            $estadoContrato = 'ACTIVO';
		$fuenteRp = buscafuenteppto($_POST[cuenta][$xx],$_POST[vigencia][$xx]);
		$terceroB = buscatercero($_POST[terceroT][$xx]);
		$rubro = buscacuentapres($_POST[cuenta][$xx]);
		$clasificacion = buscaClasificacion($_POST[cuenta][$xx],$_POST[vigencia][$xx]);
        $objPHPExcel->setActiveSheetIndex(0)
		->setCellValueExplicit ("A$i", $_POST[contrato][$xx], PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("B$i", $_POST[consvigencia][$xx], PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("C$i", $_POST[idcdp][$xx], PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("D$i", iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[detalle][$xx]), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("E$i", iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$fuenteRp), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("F$i", $_POST[terceroT][$xx], PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("G$i", iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$terceroB), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("H$i", $_POST[cuenta][$xx], PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("I$i", iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$rubro), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("J$i", $_POST[fecha][$xx], PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("K$i", $_POST[valor][$xx], PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("L$i", $estadoContrato, PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("M$i", $clasificacion, PHPExcel_Cell_DataType :: TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getStyle("A$i:M$i")->applyFromArray($borders);
		$i++;
    }
		
	//----Propiedades de la hoja 1
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth('60');
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth('60');
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth('60');
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth('60');
	$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->setTitle('DESCUENTOS');
	$objPHPExcel->setActiveSheetIndex(0);

//----Guardar documento----
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="REPORTE CONTRATOS.xls"');
header('Cache-Control: max-age=0');
 
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
$objWriter->save('php://output');
exit;

?>