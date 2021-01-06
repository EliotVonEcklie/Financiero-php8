<?php 
	
	require_once '/PHPExcel/Classes/PHPExcel.php';//Incluir la libreria PHPExcel 
	include '/PHPExcel/Classes/PHPExcel/IOFactory.php';// PHPExcel_IOFactory
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	$objPHPExcel = new PHPExcel();// Crea un nuevo objeto PHPExcel
	$objReader = PHPExcel_IOFactory::createReader('Excel2007');// Leemos un archivo Excel 2007
	$objPHPExcel = $objReader->load("formatos/FORMATOS ALCALDIA.xlsx");
	$borders = array(
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN,
          'color' => array('argb' => 'FF000000'),
        )
      ),
    );
	// Agregar Informacion
	$sqlr="SELECT TB1.documento,TB1.direccion,TB2.avaluo,TB1.tipopredio,TB1.estratos,TB1.cedulacatastral,TB1.tot FROM tesopredios TB1, tesoprediosavaluos TB2 WHERE TB1.cedulacatastral=TB2.codigocatastral AND TB2.vigencia='$_POST[vigencias]'  GROUP BY TB2.codigocatastral";  
	$res=mysql_query($sqlr,$linkbd);
	$xy=3;
	ini_set('max_execution_time', 7200);
	while ($row = mysql_fetch_row($res)) 
	{
		$sqlrt="SELECT tipodoc,apellido1,apellido2,nombre1,nombre2,razonsocial,direccion,depto,mnpio FROM terceros WHERE cedulanit='$row[0]'";
		$rest=mysql_query($sqlrt,$linkbd);
		$rowt = mysql_fetch_row($rest);
		$sqlrf="SELECT depto,mnpio FROM configbasica ";
		$resf=mysql_query($sqlrf,$linkbd);
		$rowf = mysql_fetch_row($resf);
		$sqlrtp="SELECT tasapredial FROM tesoliquidapredial WHERE vigencia='$_POST[vigencias]' AND codigocatastral='$row[5]' ";
		$restp=mysql_query($sqlrtp,$linkbd);
		$rowtp = mysql_fetch_row($restp);
		if($rowtp[0] == '')
		{
			$sqlrtp12="SELECT tasa FROM tesoprediosavaluos WHERE vigencia='$_POST[vigencias]' AND codigocatastral='$row[5]' ";
			$restp12=mysql_query($sqlrtp12,$linkbd);
			$rowtp = mysql_fetch_row($restp12);
		}
		$valimp=$row[2]*($rowtp[0]/1000);
		if ("$row[3]"=="urbano"){$tipre=2;}
		if ("$row[3]"=="rural"){$tipre=1;}
		$filbor="A".$xy.":U".$xy;
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
		->setCellValueExplicit ("A".$xy,  "1", PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("B".$xy, utf8_encode($rowt[0]), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("C".$xy, utf8_encode($row[0]), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("D".$xy, utf8_encode($rowt[1]), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("E".$xy, utf8_encode($rowt[2]), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("F".$xy, utf8_encode($rowt[3]), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("G".$xy, utf8_encode($rowt[4]), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("H".$xy, utf8_encode($rowt[5]), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("I".$xy, utf8_encode($row[1]), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("J".$xy, utf8_encode($rowf[0]), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("K".$xy, utf8_encode($rowf[1]), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("L".$xy, utf8_encode($row[2]), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("M".$xy, "0", PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("N".$xy, utf8_encode($valimp), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("O".$xy, "0", PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("P".$xy, utf8_encode($row[5]), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("Q".$xy, "0", PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("R".$xy, "0", PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("S".$xy, utf8_encode($tipre), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("T".$xy, "0", PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("U".$xy, $row[6], PHPExcel_Cell_DataType :: TYPE_STRING);
		$xy++;
	}
	// Renombrar Hoja
	//$objPHPExcel->getActiveSheet()->setTitle('Listado Asistencia');
	// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
	$objPHPExcel->setActiveSheetIndex(0);
	// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="Formato Exogena 1476.xlsx"');
	header('Cache-Control: max-age=0');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
	exit;
?>