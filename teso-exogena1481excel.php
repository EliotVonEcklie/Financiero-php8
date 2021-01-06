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
	$vigenciaAnt = $_POST[vigencias]-1;
	$sqlr="SELECT TB1.tercero,TB2.codigociiu,TB2.ingreso,TB3.industria FROM tesoindustria TB1, tesoindustria_ciiu TB2, tesoindustria_det TB3 WHERE TB1.estado='P' AND TB1.ageliquidado='$vigenciaAnt' AND year(TB1.fecha)='$_POST[vigencias]' AND TB1.id_industria=TB2.id_industria AND TB1.id_industria=TB3.id_industria GROUP BY TB1.tercero";
	$res=mysql_query($sqlr,$linkbd);
	$xy=3;
	while ($row = mysql_fetch_row($res)) 
	{
		$sqlrt="SELECT tipodoc,apellido1,apellido2,nombre1,nombre2,razonsocial,direccion,depto,mnpio FROM terceros WHERE cedulanit='$row[0]'";
		$rest=mysql_query($sqlrt,$linkbd);
		$rowt = mysql_fetch_row($rest);
		$sqlrf="SELECT depto,mnpio FROM configbasica ";
		$resf=mysql_query($sqlrf,$linkbd);
		$rowf = mysql_fetch_row($resf);
		$filbor="A".$xy.":R".$xy;
		$objPHPExcel-> getActiveSheet ()
        -> getStyle ($filbor)
		-> getFont ()
		-> setBold ( false ) 
      	-> setName ('Arial') 
      	-> setSize ( 10 ) 
		-> getColor ()
		-> setRGB ('000000');
		$objPHPExcel->getActiveSheet()->getStyle($filbor)->applyFromArray($borders);
		$objPHPExcel->setActiveSheetIndex(1)
		->setCellValueExplicit ("A".$xy, "$rowt[0]", PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("B".$xy, "$row[0]", PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("C".$xy, utf8_encode($rowt[1]), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("D".$xy, utf8_encode($rowt[2]), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("E".$xy, utf8_encode($rowt[3]), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("F".$xy, utf8_encode($rowt[4]), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("G".$xy, utf8_encode($rowt[5]), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("H".$xy, utf8_encode($rowt[6]), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("I".$xy, "$rowf[0]", PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("J".$xy, "$rowf[1]", PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("K".$xy, "$row[1]", PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("L".$xy, "1", PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("M".$xy, "$row[2]", PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("N".$xy, "0", PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("O".$xy, "0", PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("P".$xy, "$row[2]", PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("Q".$xy, "$row[3]", PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("R".$xy, "$row[3]", PHPExcel_Cell_DataType :: TYPE_STRING);
		$xy++;
	}
	// Renombrar Hoja
	//$objPHPExcel->getActiveSheet()->setTitle('Listado Asistencia');
	// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
	$objPHPExcel->setActiveSheetIndex(1);
	// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="Formato Exogena 1481.xlsx"');
	header('Cache-Control: max-age=0');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
	exit;
?>
