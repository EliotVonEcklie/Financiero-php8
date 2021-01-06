<?php 	
	require_once '/PHPExcel/Classes/PHPExcel.php';//Incluir la libreria PHPExcel 
	include '/PHPExcel/Classes/PHPExcel/IOFactory.php';// PHPExcel_IOFactory
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	$objPHPExcel = new PHPExcel();// Crea un nuevo objeto PHPExcel
	$objReader = PHPExcel_IOFactory::createReader('Excel2007');// Leemos un archivo Excel 2007
	$objPHPExcel = $objReader->load("formatos/Formato 1009.xlsx");
	$borders = array(
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN,
          'color' => array('argb' => 'FF000000'),
        )
      ),
    );
	// Agregar Informacion
	$sqlr="select distinct concepto,tercero,sum(valor),sum(retefte),sum(reteiva) from exogena_det_1009 where id_exo='$_POST[idexo]' group by concepto,tercero order by concepto,tercero";
	$res=mysql_query($sqlr,$linkbd);
	$xy=4;
	while ($row = mysql_fetch_row($res)) 
	{
		$sqlrCodigo = "SELECT codigo FROM contcodigosinternos WHERE codigo='$row[0]'";
		$resCodigo=mysql_query($sqlrCodigo,$linkbd);
		$rowCodigo = mysql_fetch_row($resCodigo);
		if($rowCodigo[0]=='')
		{
			$sqlrt="select * from terceros where cedulanit='$row[1]'";
			$rest=mysql_query($sqlrt,$linkbd);
			$rowt=mysql_fetch_row($rest);
			$filbor="A".$xy.":N".$xy;
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
			->setCellValueExplicit ("A".$xy, utf8_encode($row[0]), PHPExcel_Cell_DataType :: TYPE_STRING)
			->setCellValueExplicit ("B".$xy, utf8_encode($rowt[11]), PHPExcel_Cell_DataType :: TYPE_STRING)
            ->setCellValueExplicit ("C".$xy, utf8_encode($rowt[12]), PHPExcel_Cell_DataType :: TYPE_STRING)
            ->setCellValueExplicit ("D".$xy, utf8_encode($rowt[13]), PHPExcel_Cell_DataType :: TYPE_STRING)
			->setCellValueExplicit ("E".$xy, utf8_encode($rowt[3]), PHPExcel_Cell_DataType :: TYPE_STRING)
			->setCellValueExplicit ("F".$xy, utf8_encode($rowt[4]), PHPExcel_Cell_DataType :: TYPE_STRING)
			->setCellValueExplicit ("G".$xy, utf8_encode($rowt[1]), PHPExcel_Cell_DataType :: TYPE_STRING)
			->setCellValueExplicit ("H".$xy, utf8_encode($rowt[2]), PHPExcel_Cell_DataType :: TYPE_STRING)
			->setCellValueExplicit ("I".$xy, utf8_encode($rowt[5]), PHPExcel_Cell_DataType :: TYPE_STRING)
			->setCellValueExplicit ("J".$xy, utf8_encode($rowt[6]), PHPExcel_Cell_DataType :: TYPE_STRING)
			->setCellValueExplicit ("K".$xy, utf8_encode($rowt[14]), PHPExcel_Cell_DataType :: TYPE_STRING)
			->setCellValueExplicit ("L".$xy, utf8_encode($rowt[15]), PHPExcel_Cell_DataType :: TYPE_STRING)
			->setCellValueExplicit ("M".$xy, "169", PHPExcel_Cell_DataType :: TYPE_STRING)
			->setCellValueExplicit ("N".$xy, utf8_encode(round($row[2])), PHPExcel_Cell_DataType :: TYPE_NUMERIC);
			$xy++;
		}
		
			
	}
	// Renombrar Hoja
	//$objPHPExcel->getActiveSheet()->setTitle('Listado Asistencia');
	// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
	$objPHPExcel->setActiveSheetIndex(0);
	// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="fmt1009_'.$_POST[vigencias].'.xlsx"');
	header('Cache-Control: max-age=0');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
	exit;
?>