<?php
	require_once 'PHPExcel/Classes/PHPExcel.php';
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$objPHPExcel = new PHPExcel();
	//----Propiedades----
	$objPHPExcel->getProperties()
		->setCreator("SPID")
		->setLastModifiedBy("SPID")
		->setTitle("Liquidacion de Nomina")
		->setSubject("Nomina")
		->setDescription("Nomina")
		->setKeywords("Nomina")
		->setCategory("Gestion Humana");
	//----Cuerpo de Documento----
	$objPHPExcel->getActiveSheet()->mergeCells('A1:R1');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'REPORTE NOMINA No. '.$_POST['nnomina']);
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
		-> getStyle ("A2:R2")
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
	$objPHPExcel->getActiveSheet()->getStyle('A2:R2')->applyFromArray($borders);
	$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A2', 'No')
			->setCellValue('B2', 'EMPLEADO')
			->setCellValue('C2', 'DOCUMENTO')
			->setCellValue('D2', 'SALARIO BASICO')
			->setCellValue('E2', 'DIAS LIQUIDADOS')
			->setCellValue('F2', 'DIAS NOVEDAD')
			->setCellValue('G2', 'DEVENGADO')
			->setCellValue('H2', 'AUX ALIMENTACION')
			->setCellValue('I2', 'AUX TRANSPORTE')
			->setCellValue('J2', 'OTROS PAGOS')
			->setCellValue('K2', 'TOTAL DEVENGADO')
			->setCellValue('L2', 'SALUD EMPLEADO')
			->setCellValue('M2', 'PENSION EMPLEADO')
			->setCellValue('N2', 'FONDO SOLIDARIDAD')
			->setCellValue('O2', 'RETEFUENTE')
			->setCellValue('P2', 'OTRAS DEDUCCIONES')
			->setCellValue('Q2', 'TOTAL DEDUCCIONES')
			->setCellValue('R2', 'NETO A PAGAR');
	$i=3;
	for($ii=0;$ii<count ($_POST['cont']);$ii++)
	{
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValueExplicit ("A$i", $_POST['cont'][$ii], PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("B$i", utf8_encode($_POST['empleados'][$ii]), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("C$i", $_POST['docempleados'][$ii], PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("D$i", round($_POST['basico'][$ii]), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("E$i", $_POST['dias'][$ii], PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("F$i", $_POST['diasn'][$ii], PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("G$i", round($_POST['deveng'][$ii]), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("H$i", round($_POST['auxali'][$ii]), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("I$i", round($_POST['auxtrans'][$ii]), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("J$i", round($_POST['horas_ex'][$ii]), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("K$i", round($_POST['totaldev'][$ii]), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("L$i", round($_POST['salud'][$ii]), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("M$i", round($_POST['pension'][$ii]), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("N$i", round($_POST['fsoli'][$ii]), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("O$i", round($_POST['retefuen'][$ii]), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("P$i", round($_POST['otrasded'][$ii]), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("Q$i", round($_POST['totalded'][$ii]), PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("R$i", round($_POST['netopag'][$ii]), PHPExcel_Cell_DataType :: TYPE_NUMERIC);
		$objPHPExcel->getActiveSheet()->getStyle("A$i:R$i")->applyFromArray($borders);
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
	$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true); 

	$objPHPExcel->getActiveSheet()->setTitle('Reporte');
	
	
	$objPHPExcel->setActiveSheetIndex(0);

//----Guardar documento----
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Reporte de Nomina.xlsx"');
header('Cache-Control: max-age=0');
 
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
$objWriter->save('php://output');
exit;

?>