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
        ->setTitle("Reporte industria y comercio")
        ->setSubject("Tesoreria")
        ->setDescription("Tesoreria")
        ->setKeywords("Tesoreria")
        ->setCategory("Tesoreria");
	//----Cuerpo de Documento----
	$objPHPExcel->getActiveSheet()->mergeCells('A1:E1');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Industria y Comercio');

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
		-> getStyle ("A2:E2")	
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
	$objPHPExcel->getActiveSheet()->getStyle('A2:E2')->applyFromArray($borders);
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A2', 'ID')
	->setCellValue('B2', 'CEDULA/NIT')
	->setCellValue('C2', 'NOMBRE')
	->setCellValue('D2', 'FECHA')
	->setCellValue('E2', 'ESTADO');
	
	$i=3;
    for($xx=0; $xx<count($_POST[id]); $xx++)
    {
        if($_POST[estado][$xx]=='N' || $_POST[estado][$xx]=='R' || $_POST[estado][$xx]=='')
            $estadoContrato = 'ANULADO';
        else
            $estadoContrato = 'ACTIVO';
		
        $objPHPExcel->setActiveSheetIndex(0)
		->setCellValueExplicit ("A$i", $_POST[id][$xx], PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("B$i", $_POST[cedulaNit][$xx], PHPExcel_Cell_DataType :: TYPE_STRING)
        ->setCellValueExplicit ("C$i", iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[nombre][$xx]), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("D$i", $_POST[fecha][$xx], PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("E$i", $_POST[estado][$xx], PHPExcel_Cell_DataType :: TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getStyle("A$i:E$i")->applyFromArray($borders);
		$i++;
    }
		
	//----Propiedades de la hoja 1
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth('60');
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
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