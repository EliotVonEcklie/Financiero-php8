<?php 
	require_once '/PHPExcel/Classes/PHPExcel.php';// Incluir la libreria PHPExcel
	include '/PHPExcel/Classes/PHPExcel/IOFactory.php';// PHPExcel_IOFactory
	require"comun.inc";
	require"funciones.inc";
	session_start();
    $linkbd=conectar_bd();	
    $conexion = conectar_v7();
    $sqlr="select *from configbasica where estado='S'";
    $res=mysqli_query($conexion,$sqlr);
    while($row=mysqli_fetch_row($res))
    {
        $nit=$row[0];
        $rs=$row[1];
    }

	$objPHPExcel = new PHPExcel();// Crea un nuevo objeto PHPExcel
	$objPHPExcel->getProperties()->setCreator("IDEAL 10 SAS")
	   ->setLastModifiedBy("HAFR")
	   ->setTitle("Lista Egresos")
	   ->setSubject("Egresos")
	   ->setDescription("Liastado de Egresos")
	   ->setKeywords("Egresos")
	   ->setCategory("Tesoreria");
	$objPHPExcel->setActiveSheetIndex(0)
		->mergeCells('A1:K1')
		->mergeCells('A2:K2')
  		->setCellValue('A1', $rs." - ".$nit)
     	->setCellValue('A2', 'AUXILIAR DE EGRESOS - Periodo: '.$_GET[fecha1].' - '.$_GET[fecha2]);
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
		-> getStyle ('A3:K3')
		-> getAlignment ()
		-> applyFromArray (array ( 'horizontal'  =>  PHPExcel_Style_Alignment :: VERTICAL_JUSTIFY ,) ); 
	$objPHPExcel-> getActiveSheet ()
		-> getStyle ("A2")
        -> getFill ()
        -> setFillType (PHPExcel_Style_Fill :: FILL_SOLID)
        -> getStartColor ()
        -> setRGB ('A6E5F3');
	$objPHPExcel-> getActiveSheet ()
		-> getStyle ("A3:K3")
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
	$objPHPExcel->getActiveSheet()->getStyle('A1:K1')->applyFromArray($borders);
	$objPHPExcel->getActiveSheet()->getStyle('A2:K2')->applyFromArray($borders);
	$objPHPExcel->getActiveSheet()->getStyle('A3:K3')->applyFromArray($borders);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('A')->setWidth(12); 
	$objPHPExcel-> getActiveSheet()->getColumnDimension('B')->setWidth(11);
	$objPHPExcel-> getActiveSheet ()	
		-> getStyle ('B:C')
		-> getAlignment ()
		-> applyFromArray (array ( 'horizontal'  =>  PHPExcel_Style_Alignment :: VERTICAL_JUSTIFY ,) ); 
	$objPHPExcel-> getActiveSheet()->getColumnDimension('C')->setWidth(12);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('D')->setWidth(55);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('E')->setWidth(11);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('F')->setWidth(25);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('G')->setWidth(28);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('H')->setWidth(21);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('I')->setWidth(21);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('J')->setWidth(19);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('K')->setWidth(19);
	$objWorksheet = $objPHPExcel->getActiveSheet();
	$objWorksheet->fromArray(array(utf8_encode('Egreso'),utf8_encode('Orden de pago'),utf8_encode('Doc Tercero'),utf8_encode('Tercero'),utf8_encode('Fecha'),utf8_encode('Cheque/Transferencia'),'Valor','Valor Pago',"Retencion",utf8_encode('Concepto'),utf8_encode('Estado')),NULL,'A3');
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_GET[fecha1],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_GET[fecha2],$fecha);
	$fechaf2=$fecha[3]."-".$fecha[2]."-".$fecha[1];	
	if($_GET[tercero]!='')
		$crit1=" and tesoegresos.id_egreso like '%".$_GET[tercero]."%' ";
	$cont=4;
    $sqlr="select *from tesoegresos where tesoegresos.id_egreso>-1 ".$crit1." AND FECHA BETWEEN '$fechaf' AND '$fechaf2' order by tesoegresos.id_egreso DESC";
    
	
	$resp = mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($resp)) 
	{
		$ntr=buscatercero($row[11]);
		$objWorksheet->fromArray(array($row[0],$row[2],$row[11],utf8_encode($ntr),date('d-m-Y',strtotime($row[3])),$row[10],number_format($row[5],2),number_format($row[7],2),number_format($row[6],2),strtoupper("EGRESOS ".$row[8]),$row[13]),NULL,"A$cont");
		$objPHPExcel->getActiveSheet()->getStyle("A$cont:K$cont")->applyFromArray($borders);
		$objPHPExcel->getActiveSheet()->getStyle("H$cont:I$cont")->getNumberFormat()
		->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
		
		$objPHPExcel->getActiveSheet()->getStyle('A3:K3')->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,));
		$objPHPExcel->getActiveSheet()->getStyle('A4:K4')->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,));
		$objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
		$objPHPExcel->getActiveSheet()->getStyle('J:K')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
		$objPHPExcel->getActiveSheet()->getStyle('F3:H3')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
		$objPHPExcel->getActiveSheet()->getStyle('C3')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
		$objPHPExcel->getActiveSheet()->getStyle('A:K')->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,));
		$objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
		$objPHPExcel-> getActiveSheet()-> getStyle ("A3:K3")-> getFont ()-> setBold ( true );
		
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
