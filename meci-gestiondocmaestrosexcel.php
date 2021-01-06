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
		->setTitle("Informe Listado Maestro")
		->setSubject("Listado Maestro")
		->setDescription("Listado Maestro")
		->setKeywords("Listadp Maestro")
		->setCategory("Meci Calidad");
	//----Cuerpo de Documento----
	$objPHPExcel->getActiveSheet()->mergeCells('A1:E1');
	$ncc=$_POST[listado];
	if($ncc==0){
		$ncc='TODOS';
	}else {
		$linkbd=conectar_bd();
		if ($_POST[tinforme]==1) {
			$sqlr="SELECT nombre FROM calprocesos where id=$ncc";
			$res=mysql_query($sqlr,$linkbd);
			$ncc=mysql_fetch_row($res);
			$ncc=$ncc[0];
		}else{
			$sqlr="SELECT nombre FROM caldocumentos where id=$ncc";
			$res=mysql_query($sqlr,$linkbd);
			$ncc=mysql_fetch_row($res);
			$ncc=$ncc[0];
		}
	}
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1',$ncc);
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
	if ($_POST[tinforme]==2) {
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A2', 'ITEM')
			->setCellValue('B2', 'DOCUMENTO')
			->setCellValue('C2', 'CODIGO')
			->setCellValue('D2', 'TITULO')
			->setCellValue('E2', 'PROCESO');
	}else {
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A2', 'ITEM')
			->setCellValue('B2', 'PROCESOS')
			->setCellValue('C2', 'CODIGO')
			->setCellValue('D2', 'TITULO')
			->setCellValue('E2', 'DOCUMENTOS');
	}
	$i=3;
	if($_POST[tinforme]==2){
		
		$linkbd=conectar_bd();
		$crit1=" ";
		$crit2=" ";
		$namearch="informacion/temp/documentos_en_mejora.csv";
		if ($_POST[listado]!="0"){$crit1=" AND documento='$_POST[listado]'";}
		if ($_POST[documento]!=""){$crit2=" AND cgd.codigospid LIKE '%$_POST[documento]%' ";}
		$sqlr="SELECT distinct documento FROM calgestiondoc WHERE estado='S' ".$crit1.$crit2." ORDER BY documento, id";
		$resp = mysql_query($sqlr,$linkbd);
		$ntr = mysql_num_rows($resp);
		$con=1;
		
		$iter='saludo1';
		$iter2='saludo2';
		while ($row =mysql_fetch_row($resp)) 
		{	$linkbd=conectar_bd();
			$sqlr2="SELECT cgd.*, cld.* FROM calgestiondoc cgd, callistadoc cld WHERE cgd.idarchivo=cld.id AND cgd.estado='S' AND cgd.documento=".$row[0]." ".$crit1.$crit2." ORDER BY cgd.documento, cgd.id";
			$resp2=mysql_query($sqlr2,$linkbd);
			$row2 =mysql_fetch_row($resp2);
			$ntr2 = mysql_num_rows($resp2);
			$sqlr3="SELECT nombre FROM caldocumentos WHERE id='".$row[0]."'";
			$res3=mysql_query($sqlr3,$linkbd);
			$row3 = mysql_fetch_row($res3);
			$documentos=$row3[0];
			$sqlr3="SELECT nombre FROM calprocesos WHERE id='".$row2[1]."'";
			$res3=mysql_query($sqlr3,$linkbd);
			$row3 = mysql_fetch_row($res3);
			$procesos=$row3[0];
			$sqlr3="SELECT descripcion_valor FROM dominios WHERE nombre_dominio='TIPOS_DE_POLITICAS' AND valor_inicial='".$row2[3]."'";
			$res3=mysql_query($sqlr3,$linkbd);
			$row3 = mysql_fetch_row($res3);
			$politicas=$row3[0];
			$nombredel=strtoupper($documentos);
			$nresul=buscaresponsable($row2[14]);

			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValueExplicit ("A$i", $con, PHPExcel_Cell_DataType :: TYPE_NUMERIC)
			->setCellValueExplicit ("B$i", strtoupper($nombredel), PHPExcel_Cell_DataType :: TYPE_STRING)
			->setCellValueExplicit ("C$i", $row2[4], PHPExcel_Cell_DataType :: TYPE_STRING)
			->setCellValueExplicit ("D$i", iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$row2[6]), PHPExcel_Cell_DataType :: TYPE_STRING)
			->setCellValueExplicit ("E$i", iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$procesos), PHPExcel_Cell_DataType :: TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getStyle("A$i:E$i")->applyFromArray($borders);
			$i++;
			if($ntr2!=1)
			{
				
				while ($row2 =mysql_fetch_row($resp2))
				{	
					$sqlr3="SELECT nombre FROM calprocesos WHERE id='".$row2[1]."'";
					$res3=mysql_query($sqlr3,$linkbd);
					$row3 = mysql_fetch_row($res3);
					$procesos=$row3[0];
					$sqlr3="SELECT descripcion_valor FROM dominios WHERE nombre_dominio='TIPOS_DE_POLITICAS' AND valor_inicial='".$row2[3]."'";
					$res3=mysql_query($sqlr3,$linkbd);
					$row3 = mysql_fetch_row($res3);
					$politicas=$row3[0];
					$nombredel=strtoupper($documentos);
					$nresul=buscaresponsable($row2[14]);

					$objPHPExcel->setActiveSheetIndex(0)
					->setCellValueExplicit ("A$i", '', PHPExcel_Cell_DataType :: TYPE_STRING)
					->setCellValueExplicit ("B$i", '', PHPExcel_Cell_DataType :: TYPE_STRING)
					->setCellValueExplicit ("C$i", $row2[4], PHPExcel_Cell_DataType :: TYPE_STRING)
					->setCellValueExplicit ("D$i", iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$row2[6]), PHPExcel_Cell_DataType :: TYPE_STRING)
					->setCellValueExplicit ("E$i", iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$procesos), PHPExcel_Cell_DataType :: TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyle("A$i:E$i")->applyFromArray($borders);
					$i++;
				}
			}
			
			$con+=1;
			$aux=$iter;
			$iter=$iter2;
			$iter2=$aux;
		}
	}else if($_POST[tinforme]==1) {
	
		$linkbd=conectar_bd();
		$crit1=" ";
		$crit2=" ";
		$namearch="informacion/temp/documentos_en_mejora.csv";
		if ($_POST[listado]!="0"){$crit1=" AND proceso='$_POST[listado]'";}
		if ($_POST[documento]!=""){$crit2=" AND codigospid LIKE '%$_POST[documento]%' ";}
		$sqlr="SELECT distinct proceso FROM calgestiondoc WHERE estado='S' ".$crit1.$crit2." ORDER BY proceso, id";
		$resp = mysql_query($sqlr,$linkbd);
		$ntr = mysql_num_rows($resp);
		$con=1;
		$iter='saludo1';
		$iter2='saludo2';
		while ($row =mysql_fetch_row($resp)) 
		{	
			$sqlr2="SELECT cgd.*, cld.* FROM calgestiondoc cgd, callistadoc cld WHERE cgd.idarchivo=cld.id AND cgd.estado='S' AND cgd.proceso='".$row[0]."' ".$crit1.$crit2." ORDER BY cgd.proceso, cgd.id";
			$resp2 = mysql_query($sqlr2,$linkbd);
			$row2 =mysql_fetch_row($resp2);
			$ntr2 = mysql_num_rows($resp2);
			$sqlr3="SELECT nombre FROM calprocesos WHERE id='".$row[0]."'";
			$res3=mysql_query($sqlr3,$linkbd);
			$row3 = mysql_fetch_row($res3);
			$procesos=$row3[0];
			$sqlr3="SELECT nombre FROM caldocumentos WHERE id='".$row2[2]."'";
			$res3=mysql_query($sqlr3,$linkbd);
			$row3 = mysql_fetch_row($res3);
			$documentos=$row3[0];
			$sqlr3="SELECT descripcion_valor FROM dominios WHERE nombre_dominio='TIPOS_DE_POLITICAS' AND valor_inicial='".$row2[3]."'";
			$res3=mysql_query($sqlr3,$linkbd);
			$row3 = mysql_fetch_row($res3);
			$politicas=$row3[0];
			if($politicas==""){
				$nombredel=strtoupper($documentos);
			}
			else{
				$nombredel=strtoupper($politicas);
			}
			$nresul=buscaresponsable($row2[14]);
			
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValueExplicit ("A$i", $con, PHPExcel_Cell_DataType :: TYPE_NUMERIC)
			->setCellValueExplicit ("B$i", strtoupper($procesos), PHPExcel_Cell_DataType :: TYPE_STRING)
			->setCellValueExplicit ("C$i", $row2[4], PHPExcel_Cell_DataType :: TYPE_STRING)
			->setCellValueExplicit ("D$i", iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$row2[6]), PHPExcel_Cell_DataType :: TYPE_STRING)
			->setCellValueExplicit ("E$i", iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$nombredel), PHPExcel_Cell_DataType :: TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getStyle("A$i:E$i")->applyFromArray($borders);
			$i++;

			if($ntr2!=1)
			{
				while ($row2 =mysql_fetch_row($resp2))
				{	
					$sqlr3="SELECT nombre FROM caldocumentos WHERE id='".$row2[2]."'";
					$res3=mysql_query($sqlr3,$linkbd);
					$row3 = mysql_fetch_row($res3);
					$documentos=$row3[0];
					$sqlr3="SELECT descripcion_valor FROM dominios WHERE nombre_dominio='TIPOS_DE_POLITICAS' AND valor_inicial='".$row2[3]."'";
					$res3=mysql_query($sqlr3,$linkbd);
					$row3 = mysql_fetch_row($res3);
					$politicas=$row3[0];
					if($politicas==""){$nombredel=strtoupper($documentos);}
					else{$nombredel=strtoupper($politicas);}
					$bdescargar='<a href="informacion/calidad_documental/documentos/'.$row2[15].'" target="_blank" ><img src="imagenes/descargar.png" title=\'(Descargar)\' title="(Descargar)" ></a>';
					$nresul=buscaresponsable($row2[14]);

					$objPHPExcel->setActiveSheetIndex(0)
					->setCellValueExplicit ("A$i", '', PHPExcel_Cell_DataType :: TYPE_STRING)
					->setCellValueExplicit ("B$i", '', PHPExcel_Cell_DataType :: TYPE_STRING)
					->setCellValueExplicit ("C$i", $row2[4], PHPExcel_Cell_DataType :: TYPE_STRING)
					->setCellValueExplicit ("D$i", iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$row2[6]), PHPExcel_Cell_DataType :: TYPE_STRING)
					->setCellValueExplicit ("E$i", iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$nombredel), PHPExcel_Cell_DataType :: TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyle("A$i:E$i")->applyFromArray($borders);
					$i++;
				}
			}
			$con+=1;
			$aux=$iter;
			$iter=$iter2;
			$iter2=$aux;
		}

	}
	
	//----Propiedades de la hoja 1
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true); 

	$objPHPExcel->getActiveSheet()->setTitle('DOCUMENTO MAESTRO');

	$objPHPExcel->setActiveSheetIndex(0);

//----Guardar documento----
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="informe_documento_maestro.xls"');
header('Cache-Control: max-age=0');
 
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
$objWriter->save('php://output');
exit;

?>