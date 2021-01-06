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
		->setTitle("Reporte Activos")
		->setSubject("Activos")
		->setDescription("Reporte de Activos")
		->setKeywords("Activos")
		->setCategory("Reportes");
	$objPHPExcel->setActiveSheetIndex(0)
		->mergeCells('A1:R1')
		->mergeCells('A2:R2')
		->setCellValue('A1', 'ACTIVOS')
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
		-> getStyle ('A3:R3')
		-> getAlignment ()
		-> applyFromArray (array ( 'horizontal'  =>  PHPExcel_Style_Alignment :: VERTICAL_JUSTIFY ,) ); 
	$objPHPExcel-> getActiveSheet ()
		-> getStyle ("A2")
		-> getFill ()
		-> setFillType (PHPExcel_Style_Fill :: FILL_SOLID)
		-> getStartColor ()
		-> setRGB ('A6E5F3');
	$objPHPExcel-> getActiveSheet ()
		-> getStyle ("A3:R3")
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
	$objPHPExcel->getActiveSheet()->getStyle('A1:R1')->applyFromArray($borders);
	$objPHPExcel->getActiveSheet()->getStyle('A2:R2')->applyFromArray($borders);
	$objPHPExcel->getActiveSheet()->getStyle('A3:R3')->applyFromArray($borders);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('A')->setWidth(7); 
	$objPHPExcel-> getActiveSheet()->getColumnDimension('B')->setWidth(11);
	$objPHPExcel-> getActiveSheet ()	
		-> getStyle ('B:C')
		-> getAlignment ()
		-> applyFromArray (array ( 'horizontal'  =>  PHPExcel_Style_Alignment :: VERTICAL_JUSTIFY ,) ); 
	$objPHPExcel-> getActiveSheet()->getColumnDimension('C')->setWidth(15);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('D')->setWidth(15);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('E')->setWidth(55);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('F')->setWidth(40);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('G')->setWidth(40);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('H')->setWidth(21);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('I')->setWidth(21);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('J')->setWidth(19);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('K')->setWidth(19);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('L')->setWidth(30);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('M')->setWidth(19);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('N')->setWidth(19);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('O')->setWidth(19);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('P')->setWidth(19);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('Q')->setWidth(15);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('R')->setWidth(40);
	$objWorksheet = $objPHPExcel->getActiveSheet();
	$objWorksheet->fromArray(array(utf8_encode('No'),utf8_encode('Placa'),utf8_encode('Fecha Activacion'),utf8_encode('Fecha Compra'),utf8_encode('Nombre'),utf8_encode('Clasificacion'),utf8_encode('Grupo'),utf8_encode('Tipo'),utf8_encode('Ref.'),utf8_encode('Mod.'),utf8_encode('Serial'),utf8_encode('Origen'),'Valor','Valor Depreciado','Valor de Correccion','Valor por Depreciar',utf8_encode('Fecha Ultima Depreciacion'),utf8_encode('Ubicacion')),NULL,'A3');


	$vigencia=date(Y);
	$fec=date("d/m/Y");
	$_POST['fecha']=$fec;
	$_POST['vigencia']=$vigencia;
	$_POST['vigdep']=$vigencia;
	$_POST['valor']=0;

	$fechadep=$_POST['vigdep'].'-'.$_POST['periodo'].'-01';

	if ($_GET['clasificacion']!='N')
	{
		if($_GET['clasificacion']!=''){$criterio=" and clasificacion='".$_GET['clasificacion']."'";}
		if($_GET['tipo']!=''){$criterio2=" and tipo='".$_GET['tipo']."'";}
		if($_GET['grupo']!=''){$criterio3=" and grupo='".$_GET['grupo']."'";}
		if($_GET['fecha1']!='') 
		{
			$fech1=split("/",$_GET['fecha1']);
			$f1=$fech1[2]."-".$fech1[1]."-".$fech1[0];
			if($_GET[fecha2]!='')
			{
				$fech2=split("/",$_GET['fecha2']);
				$f2=$fech2[2]."-".$fech2[1]."-".$fech2[0];
				$criterio4=" AND fechacom between '$f1' AND '$f2'";
			}
			else{$criterio4=" AND fechacom >= '$f1'";}
		}
		else if($_GET['fecha2']!='') 
		{
			$fech2=split("/",$_GET['fecha2']);
			$f2=$fech2[2]."-".$fech2[1]."-".$fech2[0];
			$criterio4=" AND fechacom <= '$f2'";
		}
		else{$criterio4="";}
		if($_GET['placa1']!='')
		{
			if($_GET['placa2']!='')
			{
				$criterio5=" AND placa between '".$_GET['placa1']."' AND '".$_GET['placa2']."'";
			}
			else{$criterio5="AND placa = '".$_GET['placa1']."'";}
		}
		else{$criterio5='';}
		$sqlr="select *from acticrearact_det where estado='S' $criterio $criterio2 $criterio3 $criterio4 $criterio5 order by placa";
		$resp = mysql_query($sqlr,$linkbd);

		$linkbd=conectar_bd();
		$sqlr="select *from acticrearact_det where estado='S' $criterio $criterio2 $criterio3 $criterio4 $criterio5 order by placa";
		$row = view($sqlr);
		$resp = mysql_query($sqlr,$linkbd);
		$tama=count($row);
		$i = 4;
		$con=1;
		$co="zebra1";
		$co2='zebra2';
		$cuentas[]=array();
		$sumavalor=0;
		$sumavalordep=0;
		$sumaxvalordep=0;
		$sumavalordepmen=0;
		$vector_origen = consultar_origen();
		$sumsubtotal1=0;
		$sumsubtotal2=0;
		$sumsubtotal3=0;
		$sumsubtotal4=0;
		$sumsubtotal5=0;
		while($con<=$tama) 
		{	
			$cuentas[$row[$con-1]['clasificacion']][0]=$row[$con-1]['clasificacion'];
			$cuentas[$row[$con-1]['clasificacion']][1]+=$row[$con-1]['valdepmen'];	
			$cuentas[$row[$con-1]['clasificacion']][2]=$row[$con-1]['cc'];
			$sqlr = "Select id_cc,nombre from actiubicacion where id_cc='".$row[$con-1]['ubicacion']."' and estado='S'";
			$resp = mysql_query($sqlr,$linkbd);
			$ubi = mysql_fetch_row($resp);
			
			$sqlr = "Select nombre from actipo where tipo='1' and codigo='".$row[$con-1]['clasificacion']."' and estado='S'";
			$resp = mysql_query($sqlr,$linkbd);
			$cla = mysql_fetch_row($resp);

			$sqlr = "Select nombre from actipo where tipo='2' and niveluno='".$row[$con-1]['clasificacion']."' and codigo='".$row[$con-1][grupo]."' and estado='S'";
			$resp = mysql_query($sqlr,$linkbd);
			$gru = mysql_fetch_row($resp);
		 
			$sqlr = "Select nombre from actipo where tipo='3' and niveluno='".$row[$con-1]['grupo']."' and niveldos='".$row[$con-1][clasificacion]."' and codigo='".$row[$con-1]['tipo']."' and estado='S'";
			$resp = mysql_query($sqlr,$linkbd);
			$tip = mysql_fetch_row($resp);
		 
			$agesdep=$row[$con-1]['nummesesdep'];
			$fechacorte='2013-09-30';
			$fechareg=$row[$con-1]['fechact'];
			$meses=diferenciamesesfechas($fechareg,$fechacorte);
			$valordep=0;
			$sqlrDep = "SELECT SUM(valdep) FROM actidepactivo_det WHERE placa='".$row[$con-1]['placa']."'";
			$rowDep = view($sqlrDep);
			//var_dump($rowDep);
			$valordep = $rowDep[0]["SUM(valdep)"];
			$valorcorrec=$row[$con-1]['valorcorrec'];
			$valoract=$row[$con-1]['valor'];
			$valdepmen=$row[$con-1]['valdepmen'];
			if($meses<$agesdep)
			{
				$mesesdep=$row[$con-1]['mesesdepacum'];
				$fechadep=sumamesesfecha($row[$con-1]['fechact'],$mesesdep);	
				//$valordep=$row[$con-1]['valdepact'];
			}
			else
			{
				$mesesdep=$row[$con-1]['mesesdepacum']	;  
				$fechadep=sumamesesfecha($row[$con-1]['fechact'],$mesesdep);
				//$valordep=$row[$con-1]['valdepact'];
			}
			$valxdep=round($valoract-$valordep,2);
			if($con==1)
			{
				$sumsubtotal1=1;
				$sumsubtotal2=$valoract;
				$sumsubtotal3=$valordep;
				$sumsubtotal4=$valorcorrec;
				$sumsubtotal5=$valxdep;
				$codtipo=$tip[0];
			}
			else if($codtipo==$tip[0])
			{
				$sumsubtotal1++;
				$sumsubtotal2+=$valoract;
				$sumsubtotal3+=$valordep;
				$sumsubtotal4+=$valorcorrec;
				$sumsubtotal5+=$valxdep;
			}
			else
			{
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$i, "Subtotales ($sumsubtotal1) :")
				->setCellValue('M'.$i, number_format($sumsubtotal2,2,',','.'))
				->setCellValue('N'.$i, number_format($sumsubtotal3,2,',','.'))
				->setCellValue('O'.$i, number_format($sumsubtotal4,2,',','.'))
				->setCellValue('P'.$i, number_format($sumsubtotal5,2,',','.'));
				$objPHPExcel->getActiveSheet()->getStyle("A$i:R$i")->applyFromArray($borders);
				$objPHPExcel->getActiveSheet()->getStyle("M$i:P$i")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
				$sumsubtotal1=1;
				$sumsubtotal2=$valoract;
				$sumsubtotal3=$valordep;
				$sumsubtotal4=$valorcorrec;
				$sumsubtotal5=$valxdep;
				$codtipo=$tip[0];
				$i++;
			}
			$objWorksheet->fromArray(array(($i-3),$row[$con-1]['placa'],date('d-m-Y',strtotime($row[$con-1]['fechacom'])),date('d-m-Y',strtotime($row[$con-1]['fechacom'])),$row[$con-1]['nombre'],$cla[0],$gru[0],$tip[0],$row[$con-1]['referencia'],$row[$con-1]['modelo'],$row[$con-1]['serial'],$vector_origen['0'.$row[$con-1]['origen']],$valoract,$valordep,$valorcorrec,$valxdep,date('d-m-Y',strtotime($fechadep)),$ubi[0]." - ".$ubi[1]),NULL,'A'.$i);
			$objPHPExcel->getActiveSheet()->getStyle("A$i:R$i")->applyFromArray($borders);
			$objPHPExcel->getActiveSheet()->getStyle("M$i:P$i")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
			$objPHPExcel-> getActiveSheet()-> getStyle ("A3:R3")-> getFont ()-> setBold ( true );
			
			$i++;
			$con++;
			$sumavalor+=$valoract;
			$sumavalordep+=$valordep;
			$sumavalorcorrec+=$valorcorrec;
			$sumaxvalordep+=$valxdep;
			$sumavalordepmen+=$valdepmen;
		}
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$i, "Subtotales ($sumsubtotal1) :")
		->setCellValue('M'.$i, number_format($sumsubtotal2,2,',','.'))
		->setCellValue('N'.$i, number_format($sumsubtotal3,2,',','.'))
		->setCellValue('O'.$i, number_format($sumsubtotal4,2,',','.'))
		->setCellValue('P'.$i, number_format($sumsubtotal5,2,',','.'));
		$objPHPExcel->getActiveSheet()->getStyle("A$i:R$i")->applyFromArray($borders);
		$objPHPExcel->getActiveSheet()->getStyle("M$i:P$i")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
		$i++;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$i, "TOTALES  (".($i-4).") :")
		->setCellValue('M'.$i, number_format($sumavalor,2,',','.'))
		->setCellValue('N'.$i, number_format($sumavalordep,2,',','.'))
		->setCellValue('O'.$i, number_format($sumavalorcorrec,2,',','.'))
		->setCellValue('P'.$i, number_format($sumaxvalordep,2,',','.'));
		$objPHPExcel->getActiveSheet()->getStyle("L$i:P$i")->applyFromArray($borders);
		$objPHPExcel-> getActiveSheet ()
			-> getStyle ("L$i")
	        -> getFill ()
	        -> setFillType (PHPExcel_Style_Fill :: FILL_SOLID)
	        -> getStartColor ()
	        -> setRGB ('22C6CB');

    }
	//----------------------------------------------------------------------
	$objPHPExcel->getActiveSheet()->setTitle('Listado 1');// Renombrar Hoja
	$objPHPExcel->setActiveSheetIndex(0);// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
	// --------Cerrar--------
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="Reporte Activos.xlsx"');
	header('Cache-Control: max-age=0');
	header ('Expires: Mon, 15 Dic 2015 09:31:00 GMT'); // Date in the past
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header ('Pragma: public'); // HTTP/1.0
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
	exit;
?>