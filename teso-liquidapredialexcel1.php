<?php 
	ini_set('max_execution_time',3600);
	require_once '/PHPExcel/Classes/PHPExcel.php';// Incluir la libreria PHPExcel
	include '/PHPExcel/Classes/PHPExcel/IOFactory.php';// PHPExcel_IOFactory
	require"comun.inc";
	require"funciones.inc"; //guardar
	session_start();
	$linkbd=conectar_bd();	
	$objPHPExcel = new PHPExcel();// Crea un nuevo objeto PHPExcel
	$objPHPExcel->getProperties()->setCreator("G&C Tecnoinversiones SAS")
	   ->setLastModifiedBy("HAFR")
	   ->setTitle("Lista Liquidacion Predial")
	   ->setSubject("Liquidacion")
	   ->setDescription("Liastado de Liquidaciones")
	   ->setKeywords("Liquidacion")
	   ->setCategory("Tesoreria");
	$objPHPExcel->setActiveSheetIndex(0)
		->mergeCells('A1:P1')
		->mergeCells('A2:P2')
  		->setCellValue('A1', 'LIQUIDACION')
     	->setCellValue('A2', 'INFORMACION GENERAL');
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
		-> getStyle ('A3:P3')
		-> getAlignment ()
		-> applyFromArray (array ( 'horizontal'  =>  PHPExcel_Style_Alignment :: VERTICAL_JUSTIFY ,) ); 
	$objPHPExcel-> getActiveSheet ()
		-> getStyle ("A2")
        -> getFill ()
        -> setFillType (PHPExcel_Style_Fill :: FILL_SOLID)
        -> getStartColor ()
        -> setRGB ('A6E5F3');
	$objPHPExcel-> getActiveSheet ()
		-> getStyle ("A3:P3")
        -> getFill ()
        -> setFillType (PHPExcel_Style_Fill :: FILL_SOLID)
        -> getStartColor ()
        -> setRGB ('22C6CB');
	$borders = array(
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN,
          'color' => array('argb' => 'FF000000'),
        )
      ),
    );
	$objPHPExcel->getActiveSheet()->getStyle('A1:P1')->applyFromArray($borders);
	$objPHPExcel->getActiveSheet()->getStyle('A2:P2')->applyFromArray($borders);
	$objPHPExcel->getActiveSheet()->getStyle('A3:P3')->applyFromArray($borders);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('A')->setWidth(12); 
	$objPHPExcel-> getActiveSheet()->getColumnDimension('B')->setWidth(11);
	$objPHPExcel-> getActiveSheet ()	
		-> getStyle ('B:C')
		-> getAlignment ()
		-> applyFromArray (array ( 'horizontal'  =>  PHPExcel_Style_Alignment :: VERTICAL_JUSTIFY ,) ); 
	$objPHPExcel-> getActiveSheet()->getColumnDimension('C')->setWidth(10);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('D')->setWidth(20);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('E')->setWidth(55);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('F')->setWidth(15);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('G')->setWidth(15);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('H')->setWidth(5);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('I')->setWidth(15);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('J')->setWidth(15);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('K')->setWidth(15);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('L')->setWidth(15);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('M')->setWidth(15);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('N')->setWidth(15);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('O')->setWidth(15);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('P')->setWidth(15);
	$objWorksheet = $objPHPExcel->getActiveSheet();
	$objWorksheet->fromArray(array(utf8_encode('No liquidacion'),utf8_encode('No Recibo caja'),utf8_encode('Vigencia'),utf8_encode('Codigo catastral'),utf8_encode('Tercero'),utf8_encode('Fecha'),utf8_encode('Avaluo'),utf8_encode('Tasa'),utf8_encode('Predial'),utf8_encode('Interes Predial'),utf8_encode('Bomberil'),utf8_encode('Interes Bomberil'),utf8_encode('Medio Ambiente'),utf8_encode('Interes M. Amb.'),utf8_encode('Descuentos'),utf8_encode('Total')),NULL,'A3');
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_GET[fecha1],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_GET[fecha2],$fecha);
	$fechaf2=$fecha[3]."-".$fecha[2]."-".$fecha[1];	
	$cont=4;
	$sqlr="select *from tesoliquidapredial,tesoliquidapredial_det where tesoliquidapredial.estado<>'' and tesoliquidapredial.fecha BETWEEN '$fechaf' AND '$fechaf2' and tesoliquidapredial.idpredial=tesoliquidapredial_det.idpredial order by tesoliquidapredial.idpredial ASC";
	$resp = mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_assoc($resp)) 
	{
		$sq="select id_recibos from tesoreciboscaja where tipo='1' and id_recaudo='".$row['idpredial']."'";
		$re = mysql_query($sq,$linkbd);
		$row1 =mysql_fetch_array($re);
		$tercero=buscatercero($row['tercero']);
		$objWorksheet->fromArray(array($row['idpredial'],$row1[0],$row['vigliquidada'],utf8_encode("COD:".$row['codigocatastral']),$row['tercero']." - ".$tercero,$row['fecha'],$row['avaluo'],$row['tasav'],$row['predial'],$row['intpredial'],$row['bomberil'],$row['intbomb'],$row['medioambiente'],$row['intmedioambiente'],$row['descuentos'],$row['totaliquidavig']),NULL,"A$cont");
		$objPHPExcel->getActiveSheet()->getStyle("A$cont:P$cont")->applyFromArray($borders);
		$objPHPExcel->getActiveSheet()->getStyle("H$cont:I$cont")->getNumberFormat()
		->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
		
		$objPHPExcel->getActiveSheet()->getStyle('A3:P3')->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,));
		$objPHPExcel->getActiveSheet()->getStyle('A4:P4')->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,));
		$objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
		$objPHPExcel->getActiveSheet()->getStyle('J:K')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
		$objPHPExcel->getActiveSheet()->getStyle('F3:H3')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
		$objPHPExcel->getActiveSheet()->getStyle('C3')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
		$objPHPExcel->getActiveSheet()->getStyle('A:P')->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,));
		$objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
		$objPHPExcel-> getActiveSheet()-> getStyle ("A3:P3")-> getFont ()-> setBold ( true );
		
		$cont=$cont+1;	
	}
	$objPHPExcel->getActiveSheet()->setTitle('Listado 1');// Renombrar Hoja
	$objPHPExcel->setActiveSheetIndex(0);// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
	// --------Cerrar--------
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="Listado Liquidacion predial.xlsx"');
	header('Cache-Control: max-age=0');
	header ('Expires: Mon, 15 Dic 2015 09:31:00 GMT'); // Date in the past
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header ('Pragma: public'); // HTTP/1.0
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
	exit;
?>
