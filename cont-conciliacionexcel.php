<?php
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=utf8");
	require_once 'PHPExcel/Classes/PHPExcel.php';
	ini_set('max_execution_time',36000);
	$objPHPExcel = new PHPExcel();
	//----Propiedades----
	$objPHPExcel->getProperties()
		->setCreator("SPID")
		->setLastModifiedBy("SPID")
		->setTitle("Conciliacion Bancaria")
		->setSubject("Contabilidad")
		->setDescription("Contabilidad")
		->setKeywords("Contabilidad")
		->setCategory("Conciliacion");
	//----Cuerpo de Documento----
	$objPHPExcel->getActiveSheet()->mergeCells('A1:I1');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'CONCILIACION BANCARIA');
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
			->setCellValue('A2', 'No')
			->setCellValue('B2', 'CUENTA CONTABLE')
			->setCellValue('C2', 'CUENTA BANCARIA')
			->setCellValue('D2', 'BANCO')
			->setCellValue('E2', 'SALDO EXTRACTO')
			->setCellValue('F2', 'SALDO EXTRACTO CALC')
			->setCellValue('G2', 'DIFERENCIA')
			->setCellValue('H2', 'SALDO LIBROS')
			->setCellValue('I2', 'ESTADO');
	$i=3;
	for($ii=0;$ii<count ($_POST['cuentaContable']);$ii++)
	{
		$val=$ii+1;
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValueExplicit ("A$i", $$val, PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("B$i", $_POST['cuentaContable'][$ii], PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("C$i", $_POST['cuentaBancaria'][$ii], PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("D$i", $_POST['nombrebanco'][$ii], PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("E$i", round ($_POST['saldoExtracto'][$ii],0,PHP_ROUND_HALF_UP), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("F$i", round ($_POST['saldoExtractoCalc'][$ii],0,PHP_ROUND_HALF_UP), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("G$i", round ($_POST['diferencia'][$ii],0,PHP_ROUND_HALF_UP), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("H$i", round ($_POST['saldoLibros'][$ii],0,PHP_ROUND_HALF_UP), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("I$i", $_POST['vestados'][$ii], PHPExcel_Cell_DataType :: TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getStyle("A$i:I$i")->applyFromArray($borders);
		$i++;
	}
	//----Propiedades de la hoja 1
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->setTitle('Detallado');
	$objPHPExcel->setActiveSheetIndex(0);

//----Guardar documento----
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="conciliacion bancaria.xlsx"');
header('Cache-Control: max-age=0');
 
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
$objWriter->save('php://output');
exit;

?>