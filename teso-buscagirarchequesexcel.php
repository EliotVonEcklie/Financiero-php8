<?php  
	require_once 'PHPExcel/Classes/PHPExcel.php';
	require "comun.inc";
	require "funciones.inc";
    session_start();
?>
<?php

    $objPHPExcel = new PHPExcel();
    
	//----Propiedades----
	$objPHPExcel->getProperties()
        ->setCreator("SPID")
        ->setLastModifiedBy("SPID")
        ->setTitle("Reporte Pagos")
        ->setSubject("Tesoreria")
        ->setDescription("Tesoreria")
        ->setKeywords("Tesoreria")
        ->setCategory("Tesoreria");

	//----Cuerpo de Documento----
	$objPHPExcel->getActiveSheet()->mergeCells('A1:I1');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Pagos');

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
		-> getStyle ("A2:I2")	
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

    $objPHPExcel->getActiveSheet()->getStyle('A2:I2')->applyFromArray($borders);
    
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A2', 'Egreso')
    ->setCellValue('B2', 'Orden de Pago')
    ->setCellValue('C2', 'Tercero')
	->setCellValue('D2', 'Nombre')
	->setCellValue('E2', 'Fecha')
	->setCellValue('F2', 'Valor')
	->setCellValue('G2', 'Concepto')
	->setCellValue('H2', 'Estado')
	->setCellValue('I2', 'Medio de Pago');
	
    $i=3;
    for($xx=0; $xx<count($_POST[egreso]); $xx++)
    {
		$estadoContrato='';

        if($_POST[estado][$xx]=='N' || $_POST[estado][$xx]=='R' || $_POST[estado][$xx]=='')
            $estadoContrato = 'Reversado';
        else
            $estadoContrato = 'Activo';
        
        $objPHPExcel->setActiveSheetIndex(0)
		    ->setCellValueExplicit ("A$i", $_POST[egreso][$xx], PHPExcel_Cell_DataType :: TYPE_NUMERIC)
            ->setCellValueExplicit ("B$i", $_POST[ordenpago][$xx], PHPExcel_Cell_DataType :: TYPE_NUMERIC)
            ->setCellValueExplicit ("C$i", $_POST[tercero][$xx], PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		    ->setCellValueExplicit ("D$i", iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[nombre][$xx]), PHPExcel_Cell_DataType :: TYPE_STRING)
		    ->setCellValueExplicit ("E$i", $_POST[fecha][$xx], PHPExcel_Cell_DataType :: TYPE_STRING)
		    ->setCellValueExplicit ("F$i", $_POST[valor][$xx], PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		    ->setCellValueExplicit ("G$i", iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[concepto][$xx]), PHPExcel_Cell_DataType :: TYPE_STRING)
		    ->setCellValueExplicit ("H$i", $estadoContrato, PHPExcel_Cell_DataType :: TYPE_STRING)
		    ->setCellValueExplicit ("I$i", $_POST[mediopago][$xx], PHPExcel_Cell_DataType :: TYPE_STRING);
        
            $objPHPExcel->getActiveSheet()->getStyle("A$i:I$i")->applyFromArray($borders);
		$i++;
    }
		
	//----Propiedades de la hoja 1
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth('60');
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth('60');
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->setTitle('Pagos');
	$objPHPExcel->setActiveSheetIndex(0);

//----Guardar documento----
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Reporte Pagos.xls"');
header('Cache-Control: max-age=0');
 
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
$objWriter->save('php://output');
exit;

?>