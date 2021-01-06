<?php
	header("Content-Type: text/html;charset=utf-8");
	require_once 'PHPExcel/Classes/PHPExcel.php';
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();
	$objPHPExcel = new PHPExcel();
	//----Propiedades----
	$objPHPExcel->getProperties()
		->setCreator("SPID")
		->setLastModifiedBy("SPID")
		->setTitle("Listado Base Industria y comercio")
		->setSubject("Tesoreria")
		->setDescription("Tesoreria")
		->setKeywords("Tesoreria")
		->setCategory("Tesoreria");
	//----Cuerpo de Documento----
	$objPHPExcel->getActiveSheet()->mergeCells('A1:I1');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'MATRICULAS ACTIVAS');
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
			->setCellValue('B2', 'MATRICULA')
			->setCellValue('C2', 'FECHA REGISTRO')
			->setCellValue('D2', 'DOCUMENTO')
			->setCellValue('E2', 'NOMBRE')
			->setCellValue('F2', 'DIRECCION')
			->setCellValue('G2', 'TELEFONO')
			->setCellValue('H2', 'CELULAR')
			->setCellValue('I2', 'EMAIL');
	$cont=1;
	$sqlr = "SELECT id,fecha,cedulanit FROM tesorepresentantelegal WHERE estado='S' ORDER BY id ASC";
	$res = mysql_query($sqlr,$linkbd);
	while($row=mysql_fetch_row($res))
	{
		$sqlt="SELECT persona,nombre1,nombre2,apellido1,apellido2,razonsocial,direccion,telefono,celular,email FROM terceros WHERE cedulanit='$row[2]'";
		$rest=mysql_query($sqlt,$linkbd);
		while($rowt=mysql_fetch_row($rest))
		{
			if ($rowt[0]=='1'){$ntercero=$rowt[5];}
			else {$ntercero="$rowt[3] $rowt[4] $rowt[1] $rowt[2]";}
			$direcc=utf8_decode($rowt[6]);
			$telef=$rowt[7];
			$celu=$rowt[8];
			$email=$rowt[9];
		}
		//$nombre=iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$ntercero);
		$nombre=utf8_decode($ntercero);
		$posi=$cont+2;
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValueExplicit ("A$posi", $cont, PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("B$posi", $row[0] , PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("C$posi", $row[1], PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("D$posi", $row[2], PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("E$posi", $nombre, PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("F$posi", $direcc, PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("G$posi", $telef, PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("H$posi", $celu, PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("I$posi", $email, PHPExcel_Cell_DataType :: TYPE_STRING);
		$cont++;
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
	$objPHPExcel->getActiveSheet()->setTitle('Matriculas Activas');
	// hoja 2
	$objPHPExcel->createSheet(1);
	$objPHPExcel->setActiveSheetIndex(1);
	$objPHPExcel->getActiveSheet()->mergeCells('A1:I1');
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue('A1', 'MATRICULAS CANCELADAS');
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
	$objPHPExcel->setActiveSheetIndex(1)
			->setCellValue('A2', 'No')
			->setCellValue('B2', 'MATRICULA')
			->setCellValue('C2', 'FECHA REGISTRO')
			->setCellValue('D2', 'DOCUMENTO')
			->setCellValue('E2', 'NOMBRE')
			->setCellValue('F2', 'DIRECCION')
			->setCellValue('G2', 'TELEFONO')
			->setCellValue('H2', 'CELULAR')
			->setCellValue('I2', 'EMAIL');
	$cont=1;
	$sqlr = "SELECT id,fecha,cedulanit FROM tesorepresentantelegal WHERE estado='N' ORDER BY id ASC";
	$res = mysql_query($sqlr,$linkbd);
	while($row=mysql_fetch_row($res))
	{
		$sqlt="SELECT persona,nombre1,nombre2,apellido1,apellido2,razonsocial,direccion,telefono,celular,email FROM terceros WHERE cedulanit='$row[2]'";
		$rest=mysql_query($sqlt,$linkbd);
		while($rowt=mysql_fetch_row($rest))
		{
			if ($rowt[0]=='1'){$ntercero=$rowt[5];}
			else {$ntercero="$rowt[3] $rowt[4] $rowt[1] $rowt[2]";}
			$direcc=utf8_decode($rowt[6]);
			$telef=$rowt[7];
			$celu=$rowt[8];
			$email=$rowt[9];
		}
		//$nombre=iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$ntercero);
		$nombre=utf8_decode($ntercero);
		$posi=$cont+2;
		$objPHPExcel->setActiveSheetIndex(1)
		->setCellValueExplicit ("A$posi", $cont, PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("B$posi", $row[0] , PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("C$posi", $row[1], PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("D$posi", $row[2], PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("E$posi", $nombre, PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("F$posi", $direcc, PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("G$posi", $telef, PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("H$posi", $celu, PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("I$posi", $email, PHPExcel_Cell_DataType :: TYPE_STRING);
		$cont++;
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
	$objPHPExcel->getActiveSheet()->setTitle('Matriculas Canceladas');



	$objPHPExcel->setActiveSheetIndex(0);

//----Guardar documento----
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="ListaBaseIndustria.xls"');
header('Cache-Control: max-age=0');
 
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
$objWriter->save('php://output');
exit;

?>