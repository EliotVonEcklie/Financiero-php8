<?php
//V 1001 26/12/16  
	require_once '/PHPExcel/Classes/PHPExcel.php';// Incluir la libreria PHPExcel
	include '/PHPExcel/Classes/PHPExcel/IOFactory.php';// PHPExcel_IOFactory
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	if ($_POST[fechaini]!="" && $_POST[fechafin]!=""){$titulo3="Fecha Inicial: $_POST[fechaini] - Fecha Final: $_POST[fechafin]";}
	else{$titulo3="Sin Rango Definido";}
	$objPHPExcel = new PHPExcel();// Crea un nuevo objeto PHPExcel
	$objPHPExcel->getProperties()->setCreator("G&C Tecnoinversiones SAS")
	   ->setLastModifiedBy("HAFR")
	   ->setTitle("Lista de Contratos")
	   ->setSubject("Informes Contratacion")
	   ->setDescription("Contratacion")
	   ->setKeywords("Contratacion")
	   ->setCategory("Contratacion");
	$objPHPExcel->setActiveSheetIndex(0)
		->mergeCells('A1:V1')
		->mergeCells('A2:V2')
  		->setCellValue('A1', 'LISTADO DE CONTRATOS')
     	->setCellValue('A2', "Vigencia: $_POST[vigencias] - $titulo3");
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
		-> getStyle ('A3:V3')
		-> getAlignment ()
		-> applyFromArray (array ( 'horizontal'  =>  PHPExcel_Style_Alignment :: HORIZONTAL_CENTER ,) )
		-> applyFromArray (array ( 'vertical'  =>  PHPExcel_Style_Alignment :: VERTICAL_JUSTIFY ,) );  
	$objPHPExcel-> getActiveSheet ()
		-> getStyle ("A2")
        -> getFill ()
        -> setFillType (PHPExcel_Style_Fill :: FILL_SOLID)
        -> getStartColor ()
        -> setRGB ('A6E5F3');
	$objPHPExcel-> getActiveSheet ()
		-> getStyle ("A3:V3")
        -> getFill ()
        -> setFillType (PHPExcel_Style_Fill :: FILL_SOLID)
        -> getStartColor ()
        -> setRGB ('2335FF');
	$borders = array(
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN,
          'color' => array('argb' => 'FF000000'),
        )
      ),
    );
	$objPHPExcel->getActiveSheet()->getStyle('A1:V1')->applyFromArray($borders);
	$objPHPExcel->getActiveSheet()->getStyle('A2:V2')->applyFromArray($borders);
	$objPHPExcel->getActiveSheet()->getStyle('A3:V3')->applyFromArray($borders);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('A')->setWidth(12); 
	$objPHPExcel-> getActiveSheet()->getColumnDimension('B')->setWidth(40);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('C')->setWidth(30);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('D')->setWidth(16);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('E')->setWidth(16);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('F')->setWidth(30);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('G')->setWidth(20);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('H')->setWidth(30);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('I')->setWidth(40);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('J')->setWidth(30);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('K')->setWidth(20);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('L')->setWidth(20);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('M')->setWidth(10);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('N')->setWidth(10);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('O')->setWidth(10);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('P')->setWidth(14);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('Q')->setWidth(14);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('R')->setWidth(10);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('S')->setWidth(12);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('T')->setWidth(12);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('U')->setWidth(12);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('V')->setWidth(12);
	$objWorksheet = $objPHPExcel->getActiveSheet();
	$objWorksheet->fromArray(array(utf8_encode("N° Contrato"),"Objeto","Nombre Contratista",utf8_encode('Identificación'),"Rubro presupuestal","Tipo rubro","",utf8_encode('Modalidad de Selección'),"Procedimiento","Fecha de Suscripcion","Fecha de inicio",utf8_encode('Fecha Finalización'),utf8_encode('Tiempo Ejecución (dias)'),"Valor",utf8_encode("N° CDP"),"Fecha CDP","Valor CDP",utf8_encode("N° RP"),"Fecha RP","Valor RP","Prorrogas","Adiciones"),NULL,'A3');
	$cont=4;
	if ($_POST[fechaini]!="" && $_POST[fechafin]!="")
	{$cond1=" AND TB1.fecha_registro BETWEEN CAST('$_POST[fechaini]' AS DATE) AND CAST('$_POST[fechafin]' AS DATE)";}
	$sqlr="SELECT TB1.numcontrato,TB1.objeto,TB1.contratista,TB1.plazo_ejecu,TB1.modalidad,TB1.tipo_contrato,TB2.codcdp,TB1.rp,TB1.fecha_registro, TB1.fecha_inicio,TB1.fecha_terminacion,TB1.codsolicitud,TB1.valor_contrato  FROM contracontrato TB1, contrasoladquisiciones TB2 WHERE TB1.vigencia='$_POST[vigencias]' AND TB1.activo='1' AND TB1.codsolicitud=TB2.codsolicitud $cond1 ORDER BY TB1.numcontrato";
	$resp = mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($resp)) 
	{	
		$contratista=buscatercero($row[2]);
		$plazodias=calculaPlazoDias($row[0]);
		/*$duraciones=explode('/', $row[3]);
		if ($duraciones[0]==""){$plazdi=0;}
		else{$plazdi=$duraciones[0];}
		if ($duraciones[1]==""){$plazme=0;}
		else{$plazme=$duraciones[1];}
		$plazo="";
		if($plazdi==0)
		{
			if($plazme==1){$plazo="$plazme Mes";}
			else {$plazo="$plazme Meses";}
		}
		elseif($plazme==0)
		{
			if($plazdi==1){$plazo="$plazdi día";}
			else {$plazo="$plazdi días";}
		}
		else
		{
			if($plazdi==1){$plazo="$plazdi día";}
			else {$plazo="$plazdi días";}
			if($plazme==1){$plazo="$plazo y $plazme Mes";}
			else {$plazo="$plazo y $plazme Meses";}
		}*/
		$sqlrm = "SELECT descripcion_valor FROM dominios WHERE valor_inicial='$row[4]' AND nombre_dominio='MODALIDAD_SELECCION' AND (valor_final is NULL or valor_final='')";
		$resm = mysql_query($sqlrm,$linkbd);
		$rowm = mysql_fetch_row($resm);
		$sqlrcl = "SELECT nombre FROM contraclasecontratos WHERE id='$row[5]'";
		$rescl = mysql_query($sqlrcl,$linkbd);
		$rowcl = mysql_fetch_row($rescl);
		$sqlrn = "SELECT rubro FROM contrasoladquisicionesgastos WHERE codsolicitud='$row[11]'";
		$resn = mysql_query($sqlrn,$linkbd);
		$rown = mysql_fetch_row($resn);
		$sqlrs = "SELECT nombre,clasificacion,tipo FROM pptocuentas WHERE cuenta='$rown[0]'";
		$res = mysql_query($sqlrs,$linkbd);
		$rowi = mysql_fetch_row($res);
		$sqlrcdp="select distinct * from pptocdp where pptocdp.vigencia='".$_POST[vigencias]."' and pptocdp.consvigencia='".$row[6]."' ";
		$rowcdp=mysql_fetch_row(mysql_query($sqlrcdp,$linkbd));
		$modfecha1=date("d-m-Y",strtotime($rowcdp[3]));
		$sqlrrp="select distinct * from pptorp where pptorp.vigencia='".$_POST[vigencias]."' and pptorp.consvigencia='".$row[7]."' ";
		$rowrp=mysql_fetch_row(mysql_query($sqlrrp,$linkbd));
		$rpfecha1=date("d-m-Y",strtotime($rowrp[4]));
		$rubropresupuestal="$rown[0]";
		$nomrubropresupuestal="$rowi[1]";
		$tiporubro="$rowi[2]";
		$filbor="A$cont:V$cont";
		$objPHPExcel-> getActiveSheet ()
        -> getStyle ($filbor)
		-> getFont ()
		-> setBold ( false ) 
      	-> setName ('Arial') 
      	-> setSize ( 10 ) 
		-> getColor ()
		-> setRGB ('000000');
		$objPHPExcel->getActiveSheet()->getStyle($filbor)->applyFromArray($borders);
		$objPHPExcel->getActiveSheet ()->getStyle("B$cont:C$cont")->getAlignment()->setWrapText(true);
		$objPHPExcel->getActiveSheet ()->getStyle("F$cont:G$cont")->getAlignment()->setWrapText(true);
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValueExplicit ("A$cont", "$row[0]", PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("B$cont", utf8_encode($row[1]), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("C$cont", utf8_encode($contratista), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("D$cont", "$row[2]", PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("E$cont", "$rubropresupuestal", PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("F$cont", "$nomrubropresupuestal", PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("G$cont", "$tiporubro", PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("H$cont", utf8_encode($rowm[0]), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("I$cont", utf8_encode($rowcl[0]), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("J$cont", date('d-m-Y',strtotime($row[8])), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("K$cont", date('d-m-Y',strtotime($row[9])), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("L$cont", date('d-m-Y',strtotime($row[10])), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("M$cont", "$plazodias", PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("N$cont", "$row[12]", PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("O$cont", "$row[6]", PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("P$cont", "$modfecha1", PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("Q$cont", "$rowcdp[4]", PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("R$cont", "$row[7]", PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("S$cont", "$rpfecha1", PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("T$cont", "$rowrp[6]", PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("U$cont", "", PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("V$cont", "", PHPExcel_Cell_DataType :: TYPE_STRING);
		$objPHPExcel-> getActiveSheet ()	
		-> getStyle ($filbor)
		-> getAlignment ()
		-> applyFromArray (array ( 'vertical'  =>  PHPExcel_Style_Alignment :: VERTICAL_TOP ,) );  
		$cont=$cont+1;					
	}
	$objPHPExcel->getActiveSheet()->setTitle('Listado 1');// Renombrar Hoja
	$objPHPExcel->setActiveSheetIndex(0);// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
	// --------Cerrar--------
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="Listado de Contratos.xlsx"');
	header('Cache-Control: max-age=0');
	header ('Expires: Mon, 15 Dic 2015 09:31:00 GMT'); // Date in the past
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header ('Pragma: public'); // HTTP/1.0
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
	exit;
?>
