<?php //V 1000 12/12/16 ?> 
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
	$objPHPExcel->getActiveSheet()->mergeCells('A1:H1');
	$objPHPExcel->setActiveSheetIndex(0)
            	->setCellValue('A1', 'Listado Facturas');
	$objFont=$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont();
	$objFont->setName('Courier New'); 
	$objFont->setSize(15); 
	$objFont->setBold(true); 
	$objFont->setUnderline(PHPExcel_Style_Font::UNDERLINE_SINGLE);
	$objFont->getColor()->setARGB( PHPExcel_Style_Color::COLOR_BLACK);
	$objAlign=$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment(); 
	$objAlign->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
	$objAlign->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
	$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A2', 'FACTURA')
            ->setCellValue('B2', 'CORTE')
            ->setCellValue('C2', 'VIGENCIA')
            ->setCellValue('D2', 'CODIGO USUARIO')
			->setCellValue('E2', 'PROPIETARIO')
            ->setCellValue('F2', 'DIRECCION')
            ->setCellValue('G2', 'VALOR')
			->setCellValue('H2', 'ABONOS');
	$linkbd=conectar_bd();
	$crit1=$crit2=$crit3=$crit4="";
	if ($_POST[nfactura]!=""){$crit1="WHERE T1.id_liquidacion LIKE '$_POST[nfactura]' ";}
	if ($_POST[codusu]!="")
	{
		if ($_POST[nfactura]!=""){$crit2="AND T1.codusuario LIKE '%$_POST[codusu]%' ";}
		else {$crit2="WHERE T1.codusuario LIKE '%$_POST[codusu]%' ";}
	}
	if ($_POST[docusu]!="")
	{
		if ($_POST[nfactura]!="" || $_POST[codusu]!=""){$crit3="AND T1.tercero LIKE '".str_pad($_POST[docusu],10,"0", STR_PAD_LEFT)."' ";}
		else{$crit3="WHERE T1.tercero LIKE '".str_pad($_POST[docusu],10,"0", STR_PAD_LEFT)."' ";}
	}
	$sqlr="SELECT T1.id_liquidacion,T1.liquidaciongen,T1.vigencia,T1.codusuario,T1.estado,(SELECT  concat_ws('<->', T2.nombretercero,T2.direccion) FROM servclientes T2 WHERE T2.codigo=T1.codusuario),(SELECT concat_ws('<->',SUM(T3.valorliquidacion),SUM(T3.abono)) FROM servliquidaciones_det T3 WHERE T3.id_liquidacion=T1.id_liquidacion) FROM servliquidaciones T1 $crit1 $crit2 $crit3 ORDER BY T1.id_liquidacion DESC ";
	$resp = mysql_query($sqlr,$linkbd);
	$i=3;
	while ($row =mysql_fetch_row($resp))
	{
		$datuser = explode('<->', $row[5]);
		$divvalores=explode('<->', $row[6]);
		if($row[4]=='P'){$abonos=$divvalores[0];}
		else {$abonos=$divvalores[1];}
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValueExplicit ("A".$i, str_pad($row[0],10,"0", STR_PAD_LEFT), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("D".$i,$row[3], PHPExcel_Cell_DataType :: TYPE_STRING);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,$row[1]);
    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$i,$row[2]);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$i,$datuser[0]);
    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$i,$datuser[1]);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$i,$divvalores[0]);
    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$i,$abonos);
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
	$objPHPExcel->getActiveSheet()->setTitle('Listado Facturas');
	//----Guardar documento----
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="Listado Facturas.xls"');
	header('Cache-Control: max-age=0');
	$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
	$objWriter->save('php://output');
	exit;
?>