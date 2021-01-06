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
	   ->setTitle("Lista Kardex")
	   ->setSubject("Kardex")
	   ->setDescription("Listado de Kardex")
	   ->setKeywords("Kardex")
	   ->setCategory("Almacen");
	$objPHPExcel->setActiveSheetIndex(0)
		->mergeCells('A1:S1')
		->mergeCells('A2:S2')
  		->setCellValue('A1', 'KARDEX')
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
		-> getStyle ('A3:S3')
		-> getAlignment ()
		-> applyFromArray (array ( 'horizontal'  =>  PHPExcel_Style_Alignment :: VERTICAL_JUSTIFY ,) ); 
	$objPHPExcel-> getActiveSheet ()
		-> getStyle ("A2")
        -> getFill ()
        -> setFillType (PHPExcel_Style_Fill :: FILL_SOLID)
        -> getStartColor ()
        -> setRGB ('A6E5F3');
	$objPHPExcel-> getActiveSheet ()
		-> getStyle ("A3:S3")
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
	$objPHPExcel->getActiveSheet()->getStyle('A1:S1')->applyFromArray($borders);
	$objPHPExcel->getActiveSheet()->getStyle('A2:S2')->applyFromArray($borders);
	$objPHPExcel->getActiveSheet()->getStyle('A3:S3')->applyFromArray($borders);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('A')->setWidth(30); 
	$objPHPExcel-> getActiveSheet()->getColumnDimension('B')->setWidth(11);
	$objPHPExcel-> getActiveSheet ()	
		-> getStyle ('B:C')
		-> getAlignment ()
		-> applyFromArray (array ( 'horizontal'  =>  PHPExcel_Style_Alignment :: VERTICAL_JUSTIFY ,) ); 
	$objPHPExcel-> getActiveSheet()->getColumnDimension('C')->setWidth(12);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('D')->setWidth(12);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('E')->setWidth(35);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('F')->setWidth(15);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('G')->setWidth(15);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('H')->setWidth(15);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('I')->setWidth(12);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('J')->setWidth(15);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('K')->setWidth(15);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('L')->setWidth(15);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('M')->setWidth(12);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('N')->setWidth(15);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('O')->setWidth(15);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('P')->setWidth(15);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('Q')->setWidth(12);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('R')->setWidth(12);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('S')->setWidth(15);
	$objWorksheet = $objPHPExcel->getActiveSheet();
	$objWorksheet->fromArray(array(utf8_encode('Articulo'),utf8_encode('Codigo'),utf8_encode('Fecha Entrada'),utf8_encode('Documento Soporte Entrada'),utf8_encode('Movimiento'),utf8_encode('Cantidad Entrada'),'Unidad de Medida','Valor Unitario',"Costo Total",utf8_encode('Cantidad Salida'),'Unidad de Medida','Valor Unitario',"Costo Total",utf8_encode('Cantidad Saldo'),'Unidad de Medida','Valor Unitario',"Costo Total","Cantidad en Bodega","Saldo Total"),NULL,'A3');
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_GET[fecha1],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_GET[fecha2],$fecha);
	$fechaf2=$fecha[3]."-".$fecha[2]."-".$fecha[1];	
	//**************************************************************************************************************************************
	
	$crit1="";
	$crit2="";
	$_POST[fechain]=$_GET[fecha1];
	$_POST[fechafi]=$_GET[fecha2];
	$_POST[narticulo]=$_GET[narticulo];
	$_POST[articulo]=$_GET[articulo];
	$fecha1=explode("-",date('d-m-Y',strtotime($_POST[fechain])));
	$fecha2=explode("-",date('d-m-Y',strtotime($_POST[fechafi])));
	$fecha1g=gregoriantojd($fecha1[1],$fecha1[0],$fecha1[2]);
	$fecha2g=gregoriantojd($fecha2[1],$fecha2[0],$fecha2[2]);
	$_POST[bodega]=$_GET[bodega];
	$cont=4;
	if(($_POST[fechain]!="")&&($_POST[fechafi]!=""))
	{
		if($_POST[narticulo]!=""){$crit1=" and CONCAT(almarticulos.grupoinven,almarticulos.codigo) = '$_POST[articulo]'";}
		if($_POST[bodega]!="-1")
		{
			if($_POST[narticulo]!=""){$crit2=" and  almginventario_det.bodega = '$_POST[bodega]' ";}
			else {$crit2="and almginventario_det.bodega = '$_POST[bodega]' ";}
		}
		$sqlr="SELECT almarticulos.grupoinven, almarticulos.codigo, almarticulos.nombre FROM almarticulos INNER JOIN (almginventario_det INNER JOIN almginventario ON CONCAT(almginventario_det.codigo,almginventario_det.tipomov)=CONCAT(almginventario.consec,almginventario.tipomov)) ON CONCAT(almarticulos.grupoinven,almarticulos.codigo)=almginventario_det.codart where almginventario.estado='S' $crit1 $crit2 GROUP BY almarticulos.grupoinven, almarticulos.codigo, almarticulos.nombre ORDER BY grupoinven ASC, codigo ASC ";
		$resp = mysql_query($sqlr,$linkbd);
		while($row =mysql_fetch_row($resp))
		{
			$sqls="SELECT SUM(almginventario_det.cantidad_entrada) FROM almginventario INNER JOIN almginventario_det ON CONCAT(almginventario.consec,almginventario.tipomov,almginventario.tiporeg)=CONCAT(almginventario_det.codigo,almginventario_det.tipomov,almginventario_det.tiporeg) WHERE almginventario.estado='S' and almginventario_det.codart='$row[0]$row[1]' AND almginventario.fecha<'$_POST[fechain]' AND almginventario.tipomov='1' $crit2";	
			$ress=mysql_query($sqls,$linkbd);
			$went=mysql_fetch_array($ress);
			//SALIDAS
			$sqls="SELECT SUM(almginventario_det.cantidad_salida) FROM almginventario INNER JOIN almginventario_det ON CONCAT(almginventario.consec,almginventario.tipomov)=CONCAT(almginventario_det.codigo,almginventario_det.tipomov) WHERE almginventario.estado='S' and almginventario_det.codart='$row[0]$row[1]' AND almginventario.fecha<'$_POST[fechain]' AND almginventario.tipomov='2' $crit2";	
			$ress=mysql_query($sqls,$linkbd);
			$wsal=mysql_fetch_array($ress);
			//REVERSIONES ENTRADAS
			$sqls="SELECT SUM(almginventario_det.cantidad_entrada) FROM almginventario INNER JOIN almginventario_det ON CONCAT(almginventario.consec,almginventario.tipomov,almginventario.tiporeg)=CONCAT(almginventario_det.codigo,almginventario_det.tipomov,almginventario_det.tiporeg) WHERE  almginventario_det.codart='$row[0]$row[1]' AND almginventario.fecha<'$_POST[fechain]' AND almginventario.tipomov='3' $crit2";	
			$ress=mysql_query($sqls,$linkbd);
			$wrent=mysql_fetch_array($ress);
			//REVERSIONES SALIDAS
			$sqls="SELECT SUM(almginventario_det.cantidad_salida) FROM almginventario INNER JOIN almginventario_det ON CONCAT(almginventario.consec,almginventario.tipomov)=CONCAT(almginventario_det.codigo,almginventario_det.tipomov) WHERE almginventario_det.codart='$row[0]$row[1]' AND almginventario.fecha<'$_POST[fechain]' AND almginventario.tipomov='4' $crit2";	
			$ress=mysql_query($sqls,$linkbd);
			$wrsal=mysql_fetch_array($ress);
			if($went[0]=="")$went[0]=0;
			if($wsal[0]=="")$wsal[0]=0;
			if($wrent[0]=="")$wrent[0]=0;
			if($wrsal[0]=="")$wrsal[0]=0;
			$saldos=$went[0]+$wrsal[0]-($wsal[0]+$wrent[0]);
			//BUSCAR KARDEX
			$sqld="SELECT almginventario.fecha, almginventario.consec, almginventario.nombre, almginventario.tipomov, almginventario.tiporeg, almginventario_det.cantidad_entrada, almginventario_det.unidad, almginventario_det.codart, almginventario.tipomov, almginventario_det.valorunit, almginventario_det.valortotal,almginventario_det.cantidad_salida FROM almginventario INNER JOIN almginventario_det ON CONCAT(almginventario.consec,almginventario.tipomov,almginventario.tiporeg)=CONCAT(almginventario_det.codigo,almginventario_det.tipomov,almginventario_det.tiporeg) WHERE almginventario_det.codart='$row[0]$row[1]' $crit2 ORDER BY almginventario.codigo";	
			$rkar=mysql_query($sqld,$linkbd);
			$sumarent=0;
			$sumarsal=0;
			$canbod=0;
			$cansal=0;
			$iter1='saludo1c';
			$iter2='saludo2c';
			while($wkar=mysql_fetch_array($rkar)){
				//HALLAR PRECIO PROMEDIO
				$sqlp="SELECT SUM(almginventario_det.valortotal), SUM(almginventario_det.cantidad_entrada),SUM(almginventario_det.cantidad_salida) FROM almginventario INNER JOIN almginventario_det ON CONCAT(almginventario.consec,almginventario.tipomov)=CONCAT(almginventario_det.codigo,almginventario_det.tipomov) WHERE almginventario_det.codart='$wkar[7]' AND almginventario.tipomov='1' ";
				$rpre=mysql_query($sqlp,$linkbd);
				$wpre=mysql_fetch_array($rpre);
				$promedio=$wpre[0]/$wpre[1];
				$fecha3=explode("-",date('d-m-Y',strtotime($wkar[0])));
				$fecha3g=gregoriantojd($fecha3[1],$fecha3[0],$fecha3[2]);
				if($wkar[8]=='1')
				{
					$subtotala=$wkar[5]*$promedio;
					$sumarent+=$subtotala;
					$saldos+=$wkar[5];
					$subtotalb=$saldos*$promedio;
					if(($fecha1g <= $fecha3g) && ($fecha3g <= $fecha2g))
					{
						if($fecha3g <= $fecha2g)
						{
							$canbod=$saldos;
							$cansal=$saldos*$promedio;
						}
						$sqlrtmv="SELECT nombre FROM almtipomov WHERE concat_ws('', tipom,codigo)='$wkar[3]$wkar[4]'";
						$rowtmv =mysql_fetch_row(mysql_query($sqlrtmv,$linkbd));
													
						$objWorksheet = $objPHPExcel->getActiveSheet();
						$objWorksheet->fromArray(array(utf8_decode($row[2]),"$row[0]$row[1]",date('d-m-Y',strtotime($wkar[0])),$wkar[1],$rowtmv[0],$wkar[5],$wkar[6],number_format($promedio,2,',','.'),number_format($subtotala,2,',','.'),0,0,0,0,$saldos,$wkar[6],number_format($promedio,2,',','.'),number_format($subtotalb,2,',','.'),$canbod,number_format($cansal,2,',','.')),NULL,"A$cont");
						
						$objPHPExcel->getActiveSheet()->getStyle("A$cont:S$cont")->applyFromArray($borders);
						$objPHPExcel->getActiveSheet()->getStyle("H$cont:I$cont")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
						$objPHPExcel->getActiveSheet()->getStyle("P$cont:Q$cont")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
						$objPHPExcel->getActiveSheet()->getStyle("S$cont")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
						
						$objPHPExcel->getActiveSheet()->getStyle('A3:S3')->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,));
						$objPHPExcel->getActiveSheet()->getStyle('A4:S4')->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,));
						$objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
						$objPHPExcel->getActiveSheet()->getStyle('J:K')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
						$objPHPExcel->getActiveSheet()->getStyle('F3:H3')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
						$objPHPExcel->getActiveSheet()->getStyle('C3')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
						$objPHPExcel->getActiveSheet()->getStyle('A:S')->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,));
						$objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
						$objPHPExcel->getActiveSheet()-> getStyle ("A3:S3")-> getFont ()-> setBold ( true );
						
						$cont=$cont+1;	
						
					}
				}
				elseif($wkar[8]=='2')
				{
					$subtotala=$wkar[11]*$promedio;
					$sumarsal+=$subtotala;
					$saldos-=$wkar[11];
					$subtotalb=$saldos*$promedio;
					if(($fecha1g <= $fecha3g)&&($fecha3g <= $fecha2g))
					{
						if($fecha3g <= $fecha2g)
						{
							$canbod=$saldos;
							$cansal=$saldos*$promedio;
						}
						$sqlrtmv="SELECT nombre FROM almtipomov WHERE concat_ws('', tipom,codigo)='$wkar[3]$wkar[4]'";
						$rowtmv =mysql_fetch_row(mysql_query($sqlrtmv,$linkbd));
						
						$objWorksheet = $objPHPExcel->getActiveSheet();
						$objWorksheet->fromArray(array(utf8_decode($row[2]),"$row[0]$row[1]",date('d-m-Y',strtotime($wkar[0])),$wkar[1],$rowtmv[0],0,0,0,0,$wkar[11],$wkar[6],number_format($promedio,2,',','.'),number_format($subtotala,2,',','.'),$saldos,$wkar[6],number_format($promedio,2,',','.'),number_format($subtotalb,2,',','.'),$canbod,number_format($cansal,2,',','.')),NULL,"A$cont");
						
						$objPHPExcel->getActiveSheet()->getStyle("A$cont:S$cont")->applyFromArray($borders);
						$objPHPExcel->getActiveSheet()->getStyle("H$cont:I$cont")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
						$objPHPExcel->getActiveSheet()->getStyle("P$cont:Q$cont")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
						$objPHPExcel->getActiveSheet()->getStyle("S$cont")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
						
						$objPHPExcel->getActiveSheet()->getStyle('A3:S3')->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,));
						$objPHPExcel->getActiveSheet()->getStyle('A4:S4')->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,));
						$objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
						$objPHPExcel->getActiveSheet()->getStyle('J:K')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
						$objPHPExcel->getActiveSheet()->getStyle('F3:H3')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
						$objPHPExcel->getActiveSheet()->getStyle('C3')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
						$objPHPExcel->getActiveSheet()->getStyle('A:S')->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,));
						$objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
						$objPHPExcel->getActiveSheet()-> getStyle ("A3:S3")-> getFont ()-> setBold ( true );
						
						$cont=$cont+1;
					}
				}				
			}
		}
	}

	//***************************************************************************************************************/
	$objPHPExcel->getActiveSheet()->setTitle('Lista Kardex');// Renombrar Hoja
	$objPHPExcel->setActiveSheetIndex(0);// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
	// --------Cerrar--------
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="Reporte Kardex.xlsx"');
	header('Cache-Control: max-age=0');
	header ('Expires: Mon, 15 Dic 2015 09:31:00 GMT'); // Date in the past
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header ('Pragma: public'); // HTTP/1.0
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
	exit;
?>
