<?php
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
	->setTitle("Exportar Excel con PHP")
	->setSubject("Documento de prueba")
	->setDescription("Documento generado con PHPExcel")
	->setKeywords("usuarios phpexcel")
	->setCategory("reportes");
	//----Cuerpo de Documento----
	$objPHPExcel->setActiveSheetIndex(0)
	->mergeCells('A1:I1')
	->mergeCells('A2:I2')
	->setCellValue('A1', 'LIQUIDACION PREDIAL')
	->setCellValue('A2', 'INFORMACION GENERAL');
	$objPHPExcel-> getActiveSheet ()
	-> getStyle ("A1")
	-> getFill ()
	-> setFillType (PHPExcel_Style_Fill :: FILL_SOLID)
	-> getStartColor ()
	-> setRGB ('C8C8C8');
	$objPHPExcel-> getActiveSheet ()
	-> getStyle ("A1:A2")
	-> getFont ()
	-> setBold ( true ) 
	-> setName ( 'Verdana' ) 
	-> setSize ( 10 ) 
	-> getColor ()
	-> setRGB ('000000');
	$objPHPExcel-> getActiveSheet ()
	-> getStyle ('A1:A2')
	-> getAlignment ()
	-> applyFromArray (array ( 'horizontal'  =>  PHPExcel_Style_Alignment :: HORIZONTAL_CENTER ,) );
	$objPHPExcel-> getActiveSheet ()
	-> getStyle ('A3:I3')
	-> getAlignment ()
	-> applyFromArray (array ( 'horizontal'  =>  PHPExcel_Style_Alignment :: VERTICAL_JUSTIFY ,) ); 
	$objPHPExcel-> getActiveSheet ()
	-> getStyle ("A2")
	-> getFill ()
	-> setFillType (PHPExcel_Style_Fill :: FILL_SOLID)
	-> getStartColor ()
	-> setRGB ('A6E5F3');
	$objPHPExcel-> getActiveSheet ()
	-> getStyle ("A3:I3")
	-> getFill ()
	-> setFillType (PHPExcel_Style_Fill :: FILL_SOLID)
	-> getStartColor ()
	-> setRGB ('22C6CB');
	$borders = array(
		'borders' => array(
			'allborders' => array(
				'style' => PHPExcel_Style_Border::BORDER_THIN,
			'color' => array('argb' => 'FF000000'),
			)
		),
	);
	$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->applyFromArray($borders);
	$objPHPExcel->getActiveSheet()->getStyle('A2:I2')->applyFromArray($borders);
	$objPHPExcel->getActiveSheet()->getStyle('A3:I3')->applyFromArray($borders);
	$objWorksheet = $objPHPExcel->getActiveSheet();
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A3', 'Vigencia')
	->setCellValue('B3', 'Codigo Catastral')
	->setCellValue('C3', 'Predial')
	->setCellValue('D3', 'Documento')
	->setCellValue('E3', 'Nombre Propietario')
	->setCellValue('F3', 'Valor total')
	->setCellValue('G3', 'Dias mora')
	->setCellValue('H3', 'Direccion')
	->setCellValue('I3', 'Num. Resolucion');
	if (@ $_POST['nombre']!=""){$crit1="and codcatastral LIKE '%".$_POST['nombre']."%'";}
	if(@ $_POST['liquidacionn']!=""){$crit2="and idconsulta='".$_POST['liquidacionn']."'";}
	$sql="SELECT MIN(vigencia),MAX(vigencia),codcatastral,predial,SUM(REPLACE(valortotal,',','')),diasmora,numresolucion FROM  tesocobroreporte where idtesoreporte>-1 $crit1 $crit2 GROUP BY codcatastral";
	$result = mysql_query($sql,$linkbd);
	$i=4;
	while($row=mysql_fetch_array($result))
	{
		$sqlr="SELECT documento,nombrepropietario,direccion FROM tesopredios WHERE cedulacatastral='$row[2]'";
		$res=mysql_query($sqlr,$linkbd);
		$row1=mysql_fetch_row($res);
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A".$i, $row[0]."-".$row[1])
		->setCellValue("B".$i, $row[2].' ')
		->setCellValue("C".$i, $row[3])
		->setCellValue("D".$i, $row1[0])
		->setCellValue("E".$i, $row1[1])
		->setCellValue("F".$i, $row[4])
		->setCellValue("G".$i, $row[5])
		->setCellValue("H".$i, $row1[2])
		->setCellValue("I".$i, $row[6]);
		$i++;
	}
//----Propiedades de la hoja
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->setTitle('Teso-Predial');
	$objPHPExcel->setActiveSheetIndex(0);
//----Guardar documento----
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Teso-Predial.xlsx"');
header('Cache-Control: max-age=0');
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
$objWriter->save('php://output');
exit;
?>