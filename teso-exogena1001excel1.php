<?php //V 1000 12/12/16 ?> 
<?php 
	
	require_once '/PHPExcel/Classes/PHPExcel.php';//Incluir la libreria PHPExcel 
	include '/PHPExcel/Classes/PHPExcel/IOFactory.php';// PHPExcel_IOFactory
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	$objPHPExcel = new PHPExcel();// Crea un nuevo objeto PHPExcel
	$objReader = PHPExcel_IOFactory::createReader('Excel2007');// Leemos un archivo Excel 2007
	$objPHPExcel = $objReader->load("formatos/Formato 1001 1.xlsx");
	$borders = array(
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN,
          'color' => array('argb' => 'FF000000'),
        )
      ),
    );
	// Agregar Informacion
    $xy=4;
    
    for ($x=0 ; $x < count($_POST[conexogena]) ; $x++)
	{
			
			$filbor="A".$xy.":J".$xy;
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
			->setCellValueExplicit ("A".$xy, utf8_encode($_POST[conexogena][$x]), PHPExcel_Cell_DataType :: TYPE_STRING)
			->setCellValueExplicit ("B".$xy, utf8_encode($_POST[egresos][$x]), PHPExcel_Cell_DataType :: TYPE_STRING)
			->setCellValueExplicit ("C".$xy, utf8_encode($_POST[ordenes][$x]), PHPExcel_Cell_DataType :: TYPE_STRING)
			->setCellValueExplicit ("D".$xy, utf8_encode($_POST[fechas][$x]), PHPExcel_Cell_DataType :: TYPE_STRING)
			->setCellValueExplicit ("E".$xy, utf8_encode($_POST[terceros][$x]), PHPExcel_Cell_DataType :: TYPE_STRING)
			->setCellValueExplicit ("F".$xy, utf8_encode($_POST[conceptos][$x]), PHPExcel_Cell_DataType :: TYPE_STRING)
			->setCellValueExplicit ("G".$xy, utf8_encode($_POST[valoresb][$x]), PHPExcel_Cell_DataType :: TYPE_STRING)
			->setCellValueExplicit ("H".$xy, utf8_encode($_POST[valores][$x]), PHPExcel_Cell_DataType :: TYPE_STRING)
			->setCellValueExplicit ("I".$xy, utf8_encode($_POST[valoresiv][$x]), PHPExcel_Cell_DataType :: TYPE_STRING)
			->setCellValueExplicit ("J".$xy, utf8_encode($_POST[estados][$x]), PHPExcel_Cell_DataType :: TYPE_STRING);
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