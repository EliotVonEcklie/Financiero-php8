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
	   ->setTitle("Activos Fijos")
	   ->setSubject("Activos Fijos")
	   ->setDescription("Listado de Activo Fijos")
	   ->setKeywords("Activo Fijo")
	   ->setCategory("Activos Fijos");
	$objPHPExcel->setActiveSheetIndex(0)
		->mergeCells('A1:U1')
		->mergeCells('A2:U2')
  		->setCellValue('A1', 'ACTIVO FIJO'.$_POST[orden])
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
		-> getStyle ('A3:U3')
		-> getAlignment ()
		-> applyFromArray (array ( 'horizontal'  =>  PHPExcel_Style_Alignment :: VERTICAL_JUSTIFY ,) ); 
	$objPHPExcel-> getActiveSheet ()
		-> getStyle ("A2")
        -> getFill ()
        -> setFillType (PHPExcel_Style_Fill :: FILL_SOLID)
        -> getStartColor ()
        -> setRGB ('A6E5F3');
	$objPHPExcel-> getActiveSheet ()
		-> getStyle ("A3:U3")
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
	$objPHPExcel->getActiveSheet()->getStyle('A1:U1')->applyFromArray($borders);
	$objPHPExcel->getActiveSheet()->getStyle('A2:U2')->applyFromArray($borders);
	$objPHPExcel->getActiveSheet()->getStyle('A3:U3')->applyFromArray($borders);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('A')->setWidth(30); 
	$objPHPExcel-> getActiveSheet()->getColumnDimension('B')->setWidth(40);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('C')->setWidth(40);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('D')->setWidth(40);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('E')->setWidth(40);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('F')->setWidth(40);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('G')->setWidth(40);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('H')->setWidth(40);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('I')->setWidth(20);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('J')->setWidth(15);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('K')->setWidth(40);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('L')->setWidth(20);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('M')->setWidth(20);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('N')->setWidth(20);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('O')->setWidth(12);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('P')->setWidth(15);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('Q')->setWidth(15);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('R')->setWidth(15);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('S')->setWidth(30);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('T')->setWidth(30);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('U')->setWidth(20);
	
	$objWorksheet = $objPHPExcel->getActiveSheet();
	$objWorksheet->fromArray(array(utf8_encode('Placa'),utf8_encode('Clase'),utf8_encode('Grupo'),utf8_encode('Tipo'),utf8_encode('Prototipo'),utf8_encode('Area'),'Ubicacion',utf8_encode('Centro Costos'),utf8_encode('Disposicion'),utf8_encode('Fecha Activacion'),'Nombre','Referencia','Modelo',utf8_encode('Serial'),'Unidad de Medida','Fecha Compra','Depreciacion','Estado','Foto','Ficha','Valor'),NULL,'A3');
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_GET[fecha1],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_GET[fecha2],$fecha);
	$fechaf2=$fecha[3]."-".$fecha[2]."-".$fecha[1];	
	//**************************************************************************************************************************************
	$cont=4;
	for ($x=0;$x< count($_POST[dclase]);$x++)
	{
		
		$link=conectar_bd();
		$sqlr="SELECT * from acti_clase where estado='S' and id='".$_POST[dclase][$x]."'";
		$resp = mysql_query($sqlr,$link);
		$row =mysql_fetch_row($resp);

		$sqlr="SELECT * from acti_grupo where estado='S' and id_clase='".$_POST[dclase][$x]."' and id='".$_POST[dgrupo][$x]."'";
		$resp = mysql_query($sqlr,$link);
		$row1 =mysql_fetch_row($resp);

		$sqlr="SELECT * from acti_tipo_cab where estado='S' and id='".$_POST[dtipo][$x]."'";
		$resp = mysql_query($sqlr,$link);
		$row2 =mysql_fetch_row($resp);

		$sqlr="SELECT * from acti_prototipo where estado='S' and id='".$_POST[dproto][$x]."'";
		$resp = mysql_query($sqlr,$link);
		$row3 =mysql_fetch_row($resp);

		$sqlr="Select * from planacareas where planacareas.estado='S' and codarea='".$_POST[darea][$x]."'";
		$resp = mysql_query($sqlr,$link);
		$row4 =mysql_fetch_row($resp);

		$sqlr="Select * from actiubicacion where estado='S' and id_cc='".$_POST[dubi][$x]."'";
		$resp = mysql_query($sqlr,$link);
		$row5 =mysql_fetch_row($resp);

		$sqlr="select *from centrocosto where estado='S' and id_cc='".$_POST[dccs][$x]."'";
		$resp = mysql_query($sqlr,$link);
		$row6 =mysql_fetch_row($resp);

		$sqlr="select estadoactivo from acticrearact_det where codigo='".$_POST[orden]."' and tipo_mov='101'";
		$resp = mysql_query($sqlr,$link);
		$row7 =mysql_fetch_row($resp);

		$objWorksheet = $objPHPExcel->getActiveSheet();
		$objWorksheet->fromArray(array($_POST[dplaca][$x],$_POST[dclase][$x].' - '.$row[1],$_POST[dgrupo][$x].' - '.$row1[2],$_POST[dtipo][$x].' - '.$row2[1],$_POST[dproto][$x].' - '.$row3[1],$_POST[darea][$x].' - '.$row4[1],$_POST[dubi][$x].' - '.$row5[1],$_POST[dccs][$x]." - ".$row6[1],$_POST[ddispo][$x],$_POST[dfecact][$x],$_POST[dnombre][$x],$_POST[dref][$x],$_POST[dmodelo][$x],$_POST[dserial][$x],$_POST[dumed][$x],$_POST[dfecom][$x],$_POST[danio][$x],$_POST[destado][$x],$_POST[dfoto][$x],$_POST[dficha][$x],$_POST[dvalor][$x]),NULL,"A$cont");
		
		$objPHPExcel->getActiveSheet()->getStyle("A$cont:U$cont")->applyFromArray($borders);
		$objPHPExcel->getActiveSheet()->getStyle("H$cont:I$cont")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
		$objPHPExcel->getActiveSheet()->getStyle("P$cont:Q$cont")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
		$objPHPExcel->getActiveSheet()->getStyle("S$cont")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
		
		$objPHPExcel->getActiveSheet()->getStyle('A3:U3')->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,));
		$objPHPExcel->getActiveSheet()->getStyle('A4:U4')->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,));
		$objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
		$objPHPExcel->getActiveSheet()->getStyle('F3:H3')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
		$objPHPExcel->getActiveSheet()->getStyle('C3')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
		$objPHPExcel->getActiveSheet()->getStyle('A:U')->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,));
		$objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
		$objPHPExcel->getActiveSheet()-> getStyle ("A3:U3")-> getFont ()-> setBold ( true );
		
		$cont=$cont+1;
		$valact=str_replace(',','.',str_replace('.','',$_POST[dvalor][$x]));
		$gtotal+=$valact;
	}
	$objPHPExcel-> getActiveSheet ()
		-> getStyle ("T$cont:U$cont")
        -> getFill ()
        -> setFillType (PHPExcel_Style_Fill :: FILL_SOLID)
        -> getStartColor ()
        -> setRGB ('22C6CB');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue("T$cont", "VALOR TOTAL");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue("U$cont", "$gtotal");
	$objPHPExcel->getActiveSheet()->getStyle("T$cont:U$cont")->applyFromArray($borders);
	

	//***************************************************************************************************************/
	$objPHPExcel->getActiveSheet()->setTitle('Gestion De Activos');// Renombrar Hoja
	$objPHPExcel->setActiveSheetIndex(0);// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
	// --------Cerrar--------
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="Activo '.$cont.'".xlsx');
	header('Cache-Control: max-age=0');
	header ('Expires: Mon, 15 Dic 2015 09:31:00 GMT'); // Date in the past
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header ('Pragma: public'); // HTTP/1.0
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
	exit;
?>