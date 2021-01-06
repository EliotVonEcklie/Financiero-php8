<?php  
	require_once 'PHPExcel/Classes/PHPExcel.php';
	require 'comun.inc';
	require 'funciones.inc';
	session_start();
	$linkbd=conectar_v7();
	error_reporting(E_ALL);
ini_set('display_errors', '1');
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getProperties()
		->setCreator("SPID")
		->setLastModifiedBy("SPID")
		->setTitle("Reporte General de Descuentos")
		->setSubject("Nomina")
		->setDescription("Nomina")
		->setKeywords("Nomina")
		->setCategory("Gestion Humana");
	$objPHPExcel->getActiveSheet()->mergeCells('A1:J1');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'DESCUENTOS');
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
		-> getStyle ("A2:J2")
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
	$objPHPExcel->getActiveSheet()->getStyle('A2:J2')->applyFromArray($borders);
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A2', iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",'CÓDIGO'))
		->setCellValue('B2', iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",'DESCRIPCIÓN'))
		->setCellValue('C2', 'DOCUMENTO')
		->setCellValue('D2', 'FUNCIONARIO')
		->setCellValue('E2', 'FECHA')
		->setCellValue('F2', 'VALOR')
		->setCellValue('G2', 'VALOR CUOTA')
		->setCellValue('H2', 'CUOTAS FALTANTES')
		->setCellValue('I2', 'TOTAL CUOTAS')
		->setCellValue('J2', 'ESTADO');
	if (@$_POST['numero']!=""){$crit1=" AND empleado LIKE '%".$_POST['numero']."%'";}
	else {$crit1="";}
	if (@$_POST['nombre']!=""){$crit2=" AND nombrefun LIKE '%".$_POST['nombre']."%'";}
	else {$crit2="";}
	if (@$_POST['descrip']!=""){$crit3=" AND descripcion LIKE '%".$_POST['descrip']."%'";}
	else {$crit3="";}
	if(@$_POST['cel01']==0){$cl01='titulos3';$ord01="";}
	else 
	{
		if(@$_POST['cel01']==1){$ord01="ORDER BY id ASC";}
		else {$ord01="ORDER BY id DESC";}
	}
	if(@$_POST['cel02']==0){$cl02='titulos3';$ord02="";}
	else 
	{
		if(@$_POST['cel02']==1){$ord02="ORDER BY descripcion ASC";}
		else {$ord02="ORDER BY descripcion DESC";}
	}
	if(@$_POST['cel03']==0){$cl03='titulos3';$ord03="";}
	else 
	{
		if($_POST['cel03']==1) {$ord03="ORDER BY empleado ASC";}
		else {$ord03="ORDER BY empleado DESC";}
	}
	if($_POST['cel04']==0){$cl04='titulos3';$ord04="";}
	else 
	{
		if($_POST['cel04']==1){$ord04="ORDER BY nombrefun ASC";}
		else {$ord04="ORDER BY nombrefun DESC";}
	}
	if($_POST['cel05']==0){$cl05='titulos3';$ord05="";}
	else 
	{
		if($_POST['cel05']==1){$ord05=" ORDER BY fecha ASC";}
		else {$ord05=" ORDER BY fecha DESC";}
	}
	$sqlr="SELECT * FROM humvistadescuentos WHERE estado<>'' $crit1 $crit2 $crit3 $ord01 $ord02 $ord03 $ord04 $ord05";
	$resp = mysqli_query($linkbd,$sqlr);
	$i=3;
	while ($row =mysqli_fetch_row($resp)) 
 	{
		//$con2=$con+ $_POST['numpos'];
		$sqlrct="SELECT COUNT(1) FROM humnominaretenemp WHERE id='$row[0]' AND estado='P' AND tipo_des='DS'";
		$resct=mysqli_query($linkbd,$sqlrct);
		$rowct=mysqli_fetch_row($resct);
		$cuotaf=$row[6]-$rowct[0];
		if($cuotaf==0 && $row[10]=='H')
		{
			$sqlrct="UPDATE humretenempleados SET estado='P', habilitado='D' WHERE id='$row[0]'";
			mysqli_query($linkbd,$sqlrct);
			$varestado='D';
		}
		else{$varestado=$row[10];}
		$nomdesc=iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$row[1]);
		$nemp=iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$row[11]);
		$fechar=date('d-m-Y',strtotime($row[3]));
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValueExplicit ("A$i", $row[0], PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("B$i", $nomdesc, PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("C$i", $row[4], PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("D$i", $nemp, PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("E$i", $fechar, PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("F$i", $row[5], PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("G$i", $row[8], PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("H$i", $cuotaf, PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("I$i", $row[6], PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("J$i", $varestado, PHPExcel_Cell_DataType :: TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getStyle("A$i:J$i")->applyFromArray($borders);
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
	$objPHPExcel->getActiveSheet()->setTitle('DESCUENTOS');
	$objPHPExcel->setActiveSheetIndex(0);

//----Guardar documento----
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="REPORTE GENERAL DESCUENTOS.xls"');
header('Cache-Control: max-age=0');
 
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
$objWriter->save('php://output');
exit;

?>