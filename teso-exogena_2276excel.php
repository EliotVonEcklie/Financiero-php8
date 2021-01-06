<?php
	ini_set('max_execution_time', 3600);
	require_once '/PHPExcel/Classes/PHPExcel.php';//Incluir la libreria PHPExcel 
	include '/PHPExcel/Classes/PHPExcel/IOFactory.php';// PHPExcel_IOFactory
	require "comun.inc";
	require "funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	$objPHPExcel = new PHPExcel();// Crea un nuevo objeto PHPExcel
	$objReader = PHPExcel_IOFactory::createReader('Excel2007');// Leemos un archivo Excel 2007
	$objPHPExcel = $objReader->load("formatos/Formato 2276.xlsx");
	$borders = array(
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN,
          'color' => array('argb' => 'FF000000'),
        )
      ),
    );
	// Agregar Informacion
	$sqlr="select distinct concepto,tercero,sum(valor),id_cxp from exogena_det_2276 where id_exo='$_POST[idexo]' group by concepto,tercero order by concepto,tercero";
	$res=mysql_query($sqlr,$linkbd);
	$xy=4;
	while ($row = mysql_fetch_row($res))
	{
		$_POST[nomina][]=$row[3];
		if($row[0] == '5001')
		{
			$_POST[salarios][]=$row[2];
			$_POST[viaticos][]=0;
			$_POST[cesantias][]=0;
			$_POST[prestaciones][]=0;
			$_POST[otrospagos][]=0;
			$_POST[terceros1][] = $row[1];
		}
		if($row[0] == '5055')
		{
			$_POST[salarios][]=0;
			$_POST[viaticos][]=$row[2];
			$_POST[cesantias][]=0;
			$_POST[prestaciones][]=0;
			$_POST[otrospagos][]=0;
			$_POST[terceros1][] = $row[1];
		}
		if($row[0] == '5090')
		{
			$_POST[salarios][]=0;
			$_POST[viaticos][]=0;
			$_POST[cesantias][]=$row[2];
			$_POST[prestaciones][]=0;
			$_POST[otrospagos][]=0;
			$_POST[terceros1][] = $row[1];
		}
		if($row[0] == '5091')
		{
			$_POST[salarios][]=0;
			$_POST[viaticos][]=0;
			$_POST[cesantias][]=0;
			$_POST[prestaciones][]=$row[2];
			$_POST[otrospagos][]=0;
			$_POST[terceros1][] = $row[1];
		}
		if($row[0] == '5092')
		{
			$_POST[salarios][]=0;
			$_POST[viaticos][]=0;
			$_POST[cesantias][]=0;
			$_POST[prestaciones][]=0;
			$_POST[otrosPagos][]=$row[2];
			$_POST[terceros1][] = $row[1];
		}
	}
	$max = MAX($_POST[nomina]);
	$min = MIN($_POST[nomina]);
	$sqlr="create  temporary table exogena2276 (id int(11),tercero varchar(20),salarios double,viaticos double,cesantias double,prestaciones double,otrospagos double,nomina int(11))";
	mysql_query($sqlr,$linkbd);
    for($x = 0 ; $x < count($_POST[salarios]) ; $x++)
    {

		$sqlr="insert into exogena2276 (id,tercero,salarios,viaticos,cesantias,prestaciones,otrospagos,nomina) values($x,'".$_POST[terceros1][$x]."','".$_POST[salarios][$x]."','".$_POST[viaticos][$x]."','".$_POST[cesantias][$x]."','".$_POST[prestaciones][$x]."','".$_POST[otrosPagos][$x]."','".$_POST[nomina][$x]."')";
		//echo "hola".$_POST[terceros1][$x];
		mysql_query($sqlr,$linkbd);
	}
	$sqlrExogena = "select tercero,sum(salarios),sum(viaticos),sum(cesantias),sum(prestaciones),sum(otrospagos),nomina from exogena2276 group by tercero order by tercero";
	$resExogena=mysql_query($sqlrExogena,$linkbd);
	//echo "hola".$sqlrExogena;
	while($row=mysql_fetch_row($resExogena))
  	{
		$sqlrNomina = "select tipo,valor from humnomina_saludpension where id_nom>='$min' and id_nom<=$max and empleado='$row[0]'";
		//echo $sqlrNomina."<br>";
		$restNomina = mysql_query($sqlrNomina,$linkbd);
		$salud = 0;
		$pension = 0;
		while($rowtNomina = mysql_fetch_row($restNomina))
		{
			if($rowtNomina[0]=='SE')
			{
				$salud = $salud + $rowtNomina[1];
			}
			if ($rowtNomina[0]=='PE' || $rowtNomina[0]=='FS')
			{
				$pension = $pension + $rowtNomina[1];
			}
		}
		$sqlrt="select * from terceros where cedulanit='$row[0]'";
		//echo $sqlrt." - ".$_POST[terceros1][$x];
		$rest=mysql_query($sqlrt,$linkbd);
		$rowt=mysql_fetch_row($rest);
		$filbor="A".$xy.":AB".$xy;
		$objPHPExcel-> getActiveSheet ()
				-> getStyle ($filbor)
		-> getFont ()
		-> setBold ( false ) 
				-> setName ('Arial') 
				-> setSize ( 10 ) 
		-> getColor ()
		-> setRGB ('000000');
		$objPHPExcel->getActiveSheet()->getStyle($filbor)->applyFromArray($borders);
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValueExplicit ("A".$xy, utf8_encode($rowt[11]), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("B".$xy, utf8_encode($rowt[12]), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("C".$xy, utf8_encode($rowt[3]), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("D".$xy, utf8_encode($rowt[4]), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("E".$xy, utf8_encode($rowt[1]), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("F".$xy, utf8_encode($rowt[2]), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("G".$xy, utf8_encode($rowt[6]), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("H".$xy, utf8_encode($rowt[14]), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("I".$xy, utf8_encode($rowt[15]), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("J".$xy, "169", PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("K".$xy, utf8_encode(round($row[1])), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("L".$xy, "0", PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("M".$xy, "0", PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("N".$xy, "0", PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("O".$xy, "0", PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("P".$xy, utf8_encode(round($row[4])), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("Q".$xy, utf8_encode(round($row[2])), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("R".$xy, "0", PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("S".$xy, "0", PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("T".$xy, utf8_encode(round($row[5])), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("U".$xy, "0", PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("V".$xy, utf8_encode(round($row[3])), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("W".$xy, "0", PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("X".$xy, round($salud), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("Y".$xy, round($pension), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("Z".$xy, "0", PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("AA".$xy, "0", PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("AB".$xy, "0", PHPExcel_Cell_DataType :: TYPE_STRING);
		$xy++;
	}
	
	// Renombrar Hoja
	//$objPHPExcel->getActiveSheet()->setTitle('Listado Asistencia');
	// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
	$objPHPExcel->setActiveSheetIndex(0);
	// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="fmt1001_'.$_POST[vigencias].'.xlsx"');
	header('Cache-Control: max-age=0');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
	exit;
?>