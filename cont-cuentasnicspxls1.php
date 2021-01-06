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
        ->setTitle("Catalogo de Cuentas NICSP")
        ->setSubject("Contabilidad")
        ->setDescription("Contabilidad")
        ->setKeywords("Contabilidad")
        ->setCategory("Contabilidad");
	//----Cuerpo de Documento----
	$objPHPExcel->getActiveSheet()->mergeCells('A1:F1');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'NICSP');

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
		-> getStyle ("A2:F2")	
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
	$objPHPExcel->getActiveSheet()->getStyle('A2:F2')->applyFromArray($borders);
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A2', 'Item')
	->setCellValue('B2', 'CUENTA')
	->setCellValue('C2', 'DESCRIPCION')
	->setCellValue('D2', 'TIPO')
	->setCellValue('E2', 'ESTADO')
	->setCellValue('F2', 'NATURALEZA');
	
	$xx=3;
    for($i=0; $i<count($_POST[item]); $i++)
    {
		$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValueExplicit ("A$xx", $_POST[item][$i], PHPExcel_Cell_DataType :: TYPE_STRING)
        ->setCellValueExplicit ("B$xx", $_POST[cuenta][$i], PHPExcel_Cell_DataType :: TYPE_STRING)
        ->setCellValueExplicit ("C$xx", iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[descripcion][$i]), PHPExcel_Cell_DataType :: TYPE_STRING)
        ->setCellValueExplicit ("D$xx", iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[tipo][$i]), PHPExcel_Cell_DataType :: TYPE_STRING)
        ->setCellValueExplicit ("E$xx", iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[estado][$i]), PHPExcel_Cell_DataType :: TYPE_STRING)
        ->setCellValueExplicit ("F$xx", $_POST[naturaleza][$i], PHPExcel_Cell_DataType :: TYPE_STRING);
        $objPHPExcel->getActiveSheet()->getStyle("A$xx:F$xx")->applyFromArray($borders);
            
		$xx++;
    }
		
	//----Propiedades de la hoja 1
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth('60');
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->setTitle('CUENTAS NICPS');
	$objPHPExcel->setActiveSheetIndex(0);

//----Guardar documento----
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="REPORTE CUENTAS NICSP.xls"');
header('Cache-Control: max-age=0');
 
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
$objWriter->save('php://output');
exit;

?>