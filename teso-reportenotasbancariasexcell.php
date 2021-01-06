<?php 
	require_once '/PHPExcel/Classes/PHPExcel.php';// Incluir la libreria PHPExcel
	include '/PHPExcel/Classes/PHPExcel/IOFactory.php';// PHPExcel_IOFactory
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	$objPHPExcel = new PHPExcel();// Crea un nuevo objeto PHPExcel
	$objPHPExcel->getProperties()->setCreator("G&C Tecnoinversiones SAS")
	   ->setLastModifiedBy("HAFR")
	   ->setTitle("Lista Notas Bancarias")
	   ->setSubject("Notas Bancarias")
	   ->setDescription("Liastado de Notas Bancarias")
	   ->setKeywords("N. Bancarias")
	   ->setCategory("Tesoreria");
	$objPHPExcel->setActiveSheetIndex(0)
		->mergeCells('A1:G1')
		->mergeCells('A2:G2')
  		->setCellValue('A1', 'Notas Bancarias')
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
		-> getStyle ('A3:G3')
		-> getAlignment ()
		-> applyFromArray (array ( 'horizontal'  =>  PHPExcel_Style_Alignment :: VERTICAL_JUSTIFY ,) ); 
	$objPHPExcel-> getActiveSheet ()
		-> getStyle ("A2")
        -> getFill ()
        -> setFillType (PHPExcel_Style_Fill :: FILL_SOLID)
        -> getStartColor ()
        -> setRGB ('A6E5F3');
	$objPHPExcel-> getActiveSheet ()
		-> getStyle ("A3:G3")
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
	$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->applyFromArray($borders);
	$objPHPExcel->getActiveSheet()->getStyle('A2:G2')->applyFromArray($borders);
	$objPHPExcel->getActiveSheet()->getStyle('A3:G3')->applyFromArray($borders);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('A')->setWidth(12); 
	$objPHPExcel-> getActiveSheet()->getColumnDimension('B')->setWidth(11);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('C')->setWidth(55);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('D')->setWidth(12);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('E')->setWidth(11);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('F')->setWidth(55);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('G')->setWidth(11);
	$objWorksheet = $objPHPExcel->getActiveSheet();
	$objWorksheet->fromArray(array(utf8_encode('Nota bancaria'),utf8_encode('Fecha'),utf8_encode('Concepto Nota Bancaria'),utf8_encode('Valor'),'Cuenta','Nombre Cuenta',utf8_encode('Estado')),NULL,'A3');
	if($_GET[fecha1]!='')
	{
		ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_GET[fecha1],$fecha);
		$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	}
	if($_GET[fecha1]!='')
	{
		ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_GET[fecha2],$fecha);
		$fechaf2=$fecha[3]."-".$fecha[2]."-".$fecha[1];	
	}
	if($_GET[notaban]!='')
		$crit1=" and tesonotasbancarias_det.gastoban like '%".$_GET[notaban]."%' ";
	if($_GET[fecha1]!="" && $_GET[fecha2]!="")
	{
		$crit2=" and tesonotasbancarias_cab.fecha between '$fechaf' AND '$fechaf2'";
	}
	$cont=4;
	$sqlr="select *from tesonotasbancarias_cab,tesonotasbancarias_det where tesonotasbancarias_cab.id_notaban=tesonotasbancarias_det.id_notabancab and tesonotasbancarias_cab.estado<>'' ".$crit1.$crit2." order by tesonotasbancarias_cab.id_notaban DESC";
//	echo "hola".$_POST[idnota];
	$resp = mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($resp)) 
	{
		if($row[4]=='S')
			$imgsem="ACTIVO"; 	 				  
		if($row[4]=='N')
			$imgsem="ANULADO";
		$sqlr="Select sum(valor),ncuentaban from tesonotasbancarias_det where id_notabancab=$row[0]";
		$resn=mysql_query($sqlr,$linkbd);
		$rn=mysql_fetch_row($resn);
		$sqlr1="select *from tesobancosctas tb1,cuentas tb2 where tb1.cuenta=tb2.cuenta and tb1.ncuentaban='$rn[1]'";
		$res1=mysql_query($sqlr1,$linkbd);
		$rn1=mysql_fetch_assoc($res1);
		$objWorksheet->fromArray(array($row[0],date('d-m-Y',strtotime($row[2])),$row[5],$rn[0],$rn1["ncuentaban"],$rn1["nombre"],$imgsem),NULL,"A$cont");
		$objPHPExcel->getActiveSheet()->getStyle("A$cont:G$cont")->applyFromArray($borders);
		$objPHPExcel->getActiveSheet()->getStyle("D$cont:D$cont")->getNumberFormat()
		->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
		
		$objPHPExcel->getActiveSheet()->getStyle('A3:G3')->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,));
		$objPHPExcel->getActiveSheet()->getStyle('A4:G4')->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,));
		$objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
		$objPHPExcel->getActiveSheet()->getStyle('C3')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
		$objPHPExcel->getActiveSheet()->getStyle('A:G')->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,));
		$objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
		$objPHPExcel-> getActiveSheet()-> getStyle ("A3:G3")-> getFont ()-> setBold ( true );
		
		$cont=$cont+1;	
	}
	$objPHPExcel->getActiveSheet()->setTitle('Listado 1');// Renombrar Hoja
	$objPHPExcel->setActiveSheetIndex(0);// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
	// --------Cerrar--------
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="Listado Egresos.xlsx"');
	header('Cache-Control: max-age=0');
	header ('Expires: Mon, 15 Dic 2015 09:31:00 GMT'); // Date in the past
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header ('Pragma: public'); // HTTP/1.0
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
	exit;
?>
