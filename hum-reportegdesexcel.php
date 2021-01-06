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
        ->setTitle("Reporte General de Descuentos")
        ->setSubject("Nomina")
        ->setDescription("Nomina")
        ->setKeywords("Nomina")
        ->setCategory("Gestion Humana");
	//----Cuerpo de Documento----
	$objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
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
		-> getStyle ("A2:G2")	
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
	$objPHPExcel->getActiveSheet()->getStyle('A2:G2')->applyFromArray($borders);
	$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A2', iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",'N° NOMINA'))
            ->setCellValue('B2', 'FECHA')
			->setCellValue('C2', iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",'DESCRIPCIÓN'))
            ->setCellValue('D2', iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",'CÓDIGO'))
            ->setCellValue('E2', 'FUNCIONARIO')
            ->setCellValue('F2', 'VALOR')
            ->setCellValue('G2', iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",'N° CUOTA'));
	if($_POST[nomifill]!=""){$crit1="AND id_nom='$_POST[nomifill]'";}
	else{$crit1="";}
	if($_POST[descfill]!=""){$crit2="AND descripcion LIKE '%$_POST[descfill]%'";}
	else{$crit2="";}
	if($_POST[funcfill]!=""){$crit3="AND nombrefun LIKE '%$_POST[funcfill]%'";}
	else{$crit3="";}
	if($_POST[cel01]==0){$ord01="";}
	else 
	{
		if($_POST[cel01]==1){$ord01="ORDER BY id_nom ASC";}
		else {$ord01="ORDER BY id_nom DESC";}
	}
	if($_POST[cel02]==0){$ord02="";}
	else 
	{
		if($_POST[cel02]==1){$ord02="ORDER BY fecha ASC";}
		else {$ord02="ORDER BY fecha DESC";}
	}
	if($_POST[cel03]==0){$ord03="";}
	else 
	{
		if($_POST[cel03]==1){$ord03="ORDER BY descripcion ASC";}
		else {$ord03="ORDER BY descripcion DESC";}
	}
	if($_POST[cel04]==0){$ord04="";}
	else 
	{
		if($_POST[cel04]==1){$ord04="ORDER BY id ASC";}
		else {$ord04="ORDER BY id DESC";}
	}
	if($_POST[cel05]==0){$ord05="";}
	else 
	{
		if($_POST[cel05]==1){$ord05=" ORDER BY nombrefun ASC";}
		else {$ord05=" ORDER BY nombrefun DESC";}
	}
	if($_POST[cel05]!=0 || $crit3!="")
	$sqlr="SELECT * FROM vistadescuentosempleados WHERE tipo_des='DS' $crit1 $crit2 $crit3 $ord01 $ord02 $ord03 $ord04 $ord05";
	$resp = mysql_query($sqlr,$linkbd);
	$i=3;
	while ($row =mysql_fetch_row($resp)) 
 	{
		$nomdescr=iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$row[4]);
		$nomfunci=iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$row[10]);
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValueExplicit ("A$i", $row[0], PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("B$i", $row[3], PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("C$i", $nomdescr, PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("D$i", $row[1], PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("E$i", $nomfunci, PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("F$i", $row[5], PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("G$i", $row[6], PHPExcel_Cell_DataType :: TYPE_NUMERIC);
		$objPHPExcel->getActiveSheet()->getStyle("A$i:G$i")->applyFromArray($borders);
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