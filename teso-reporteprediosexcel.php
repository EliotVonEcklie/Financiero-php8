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
        ->setTitle("Reporte Predial")
        ->setSubject("Tesoreria")
        ->setDescription("Tesoreria")
        ->setKeywords("Tesoreria")
        ->setCategory("Tesoreria");
	//----Cuerpo de Documento----
	$objPHPExcel->getActiveSheet()->mergeCells('A1:O1');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'PREDIAL');

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
		-> getStyle ("A2:O2")	
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
	$objPHPExcel->getActiveSheet()->getStyle('A2:O2')->applyFromArray($borders);
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A2', 'CODIGO CATASTRAL')
	->setCellValue('B2', 'AVALUO')
	->setCellValue('C2', 'VIGENCIA')
	->setCellValue('D2', 'CC/NIT')
	->setCellValue('E2', 'TERCERO')
	->setCellValue('F2', 'PREDIAL')
	->setCellValue('G2', 'INTERESES PREDIAL')
	->setCellValue('H2', 'DESCUENTO INTERESES')
	->setCellValue('I2', 'SOBRETASA BOMBERIL')
	->setCellValue('J2', 'INTERES BOMBERIL')
	->setCellValue('K2', 'SOBRETASA AMBIENTAL')
	->setCellValue('L2', 'INTERES AMBIENTAL')
	->setCellValue('M2', 'DESCUENTO')
    ->setCellValue('N2', 'TOTAL A PAGAR')
    ->setCellValue('O2', 'ESTADO');
	
	$i=3;
    for($xx=0; $xx<count($_POST[codCatastral]); $xx++)
    {
        $objPHPExcel->setActiveSheetIndex(0)
		->setCellValueExplicit ("A$i", $_POST[codCatastral][$xx], PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("B$i", $_POST[avaluo][$xx], PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("C$i", $_POST[vigencia][$xx], PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("D$i", $_POST[tercero][$xx], PHPExcel_Cell_DataType :: TYPE_STRING)
        ->setCellValueExplicit ("E$i", iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[nomTercero][$xx]), PHPExcel_Cell_DataType :: TYPE_STRING)
        ->setCellValueExplicit ("F$i", $_POST[predial][$xx], PHPExcel_Cell_DataType :: TYPE_STRING)
        ->setCellValueExplicit ("G$i", $_POST[intPredial][$xx], PHPExcel_Cell_DataType :: TYPE_STRING)
        ->setCellValueExplicit ("H$i", $_POST[descInteresPredial][$xx], PHPExcel_Cell_DataType :: TYPE_STRING)
        ->setCellValueExplicit ("I$i", $_POST[bomberil][$xx], PHPExcel_Cell_DataType :: TYPE_STRING)
        ->setCellValueExplicit ("J$i", $_POST[intBomberil][$xx], PHPExcel_Cell_DataType :: TYPE_STRING)
        ->setCellValueExplicit ("K$i", $_POST[ambiental][$xx], PHPExcel_Cell_DataType :: TYPE_STRING)
        ->setCellValueExplicit ("L$i", $_POST[intAmbiental][$xx], PHPExcel_Cell_DataType :: TYPE_STRING)
        ->setCellValueExplicit ("M$i", $_POST[descuento][$xx], PHPExcel_Cell_DataType :: TYPE_STRING)
        ->setCellValueExplicit ("N$i", $_POST[totalAPagar][$xx], PHPExcel_Cell_DataType :: TYPE_STRING)
        ->setCellValueExplicit ("O$i", $_POST[estado][$xx], PHPExcel_Cell_DataType :: TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getStyle("A$i:O$i")->applyFromArray($borders);
		$i++;
    }
		
	//----Propiedades de la hoja 1
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth('30');
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->setTitle('PREDIAL');
	$objPHPExcel->setActiveSheetIndex(0);

//----Guardar documento----
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="REPORTE PREDIAL.xls"');
header('Cache-Control: max-age=0');
 
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
$objWriter->save('php://output');
exit;

?>