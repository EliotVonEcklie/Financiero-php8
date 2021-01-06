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
	   ->setTitle("Lista Plan Anual de Adquisiciones")
	   ->setSubject("Plan Anual de Adquisiciones")
	   ->setDescription("Lista todas las Adquisiciones")
	   ->setKeywords("Plan Anual de Adquisiciones")
	   ->setCategory("Contratacion");
	$objPHPExcel->setActiveSheetIndex(0)
		->mergeCells('A1:L1')
		->mergeCells('A2:L2')
  		->setCellValue('A1', 'PLAN ANUAL DE ADQUISICIONES')
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
		-> getStyle ('A3:L3')
		-> getAlignment ()
		-> applyFromArray (array ( 'horizontal'  =>  PHPExcel_Style_Alignment :: VERTICAL_JUSTIFY ,) ); 
	$objPHPExcel-> getActiveSheet ()
		-> getStyle ("A2")
        -> getFill ()
        -> setFillType (PHPExcel_Style_Fill :: FILL_SOLID)
        -> getStartColor ()
        -> setRGB ('A6E5F3');
	$objPHPExcel-> getActiveSheet ()
		-> getStyle ("A3:L3")
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
	$objPHPExcel->getActiveSheet()->getStyle('A1:L1')->applyFromArray($borders);
	$objPHPExcel->getActiveSheet()->getStyle('A2:L2')->applyFromArray($borders);
	$objPHPExcel->getActiveSheet()->getStyle('A3:L3')->applyFromArray($borders);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('A')->setWidth(12); 
	$objPHPExcel-> getActiveSheet()->getColumnDimension('B')->setWidth(11);
	$objPHPExcel-> getActiveSheet ()	
		-> getStyle ('B:C')
		-> getAlignment ()
		-> applyFromArray (array ( 'horizontal'  =>  PHPExcel_Style_Alignment :: VERTICAL_JUSTIFY ,) ); 
	$objPHPExcel-> getActiveSheet()->getColumnDimension('C')->setWidth(55);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('D')->setWidth(12);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('E')->setWidth(11);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('F')->setWidth(25);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('G')->setWidth(28);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('H')->setWidth(21);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('I')->setWidth(21);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('J')->setWidth(19);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('K')->setWidth(19);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('L')->setWidth(50);
	$objWorksheet = $objPHPExcel->getActiveSheet();
	$objWorksheet->fromArray(array(utf8_encode('Código adquisición'),utf8_encode('Códigos UNSPSC'),utf8_encode('Descripción'),utf8_encode('Fecha estimada inicial'),utf8_encode('Duración estimada del contrato'),utf8_encode('Modalidad Selección'),'Fuente de los recursos','Valor total Estimado',"Valor Estimado \nVigencia Actual",utf8_encode('¿Se requieren vigencias futuras?'),utf8_encode('Estado de solicitud vigencias futuras'),'Datos del contacto responsable'),NULL,'A3');
	$cont=4;
	$sqlr="SELECT * FROM contraplancompras WHERE vigencia='$_POST[vigenciactual]' $crit1 $crit2 ORDER BY length(codplan),codplan ASC";
	$resp = mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($resp)) 
	{
		$comcodigo=str_replace("-"," ",$row[4]);
		$sqlr2="SELECT descripcion_valor FROM dominios  WHERE nombre_dominio='MODALIDAD_SELECCION' AND (valor_final IS NULL or valor_final ='') AND valor_inicial='$row[8]'";
		$row2 =mysql_fetch_row(mysql_query($sqlr2,$linkbd));
		$sqlr3="SELECT nombre FROM (SELECT codigo,nombre FROM pptofutfuentefunc UNION SELECT codigo,nombre FROM pptofutfuentefunc) AS tabla WHERE codigo='$row[9]'";
		$row3 =mysql_fetch_row(mysql_query($sqlr3,$linkbd));
		$sqlr4="SELECT descripcion_Valor FROM dominios WHERE nombre_dominio='VIGENCIASF' AND valor_inicial='$row[12]'";
		$row4=mysql_fetch_row(mysql_query($sqlr4,$linkbd));
		switch($row[14])
		{
			case 'S':	$estados='Activo';break;
			case 'A':	$estados='Ligado a un solicitud';break;
			case 'N':	$estados='Inactivo';
		}
		$duramostrar="";
		$duraciones=explode('/', $row[7]);
		if($duraciones[0]>1 ){$duramostrar ="$duraciones[0] Dias ";}
		elseif($duraciones[0]==1){$duramostrar ="$duraciones[0] Dia ";}
		if($duraciones[0]>1 && $duraciones[1]>1){$duramostrar ="$duramostrar y ";}
		if($duraciones[1]>1 ){$duramostrar = "$duraciones[1] Meses";}
		elseif($duraciones[1]==1){$duramostrar ="$duraciones[1] Mes";}
		$objWorksheet->fromArray(array($row[0],$comcodigo,utf8_encode($row[5]),date('d-m-Y',strtotime($row[6])),$duramostrar,utf8_encode($row2[0]),utf8_encode($row3[0]),$row[10],$row[11],$row4[0],$estados,$row[15]),NULL,"A$cont");
		$objPHPExcel->getActiveSheet()->getStyle("A$cont:L$cont")->applyFromArray($borders);
		$objPHPExcel->getActiveSheet()->getStyle("H$cont:I$cont")->getNumberFormat()
		->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
		
		$objPHPExcel->getActiveSheet()->getStyle('A3:L3')->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,));
		$objPHPExcel->getActiveSheet()->getStyle('A4:L4')->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,));
		$objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
		$objPHPExcel->getActiveSheet()->getStyle('J:K')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
		$objPHPExcel->getActiveSheet()->getStyle('F3:H3')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
		$objPHPExcel->getActiveSheet()->getStyle('C3')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
		$objPHPExcel->getActiveSheet()->getStyle('A:L')->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,));
		$objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
		$objPHPExcel-> getActiveSheet()-> getStyle ("A3:L3")-> getFont ()-> setBold ( true );
		
		$cont=$cont+1;	
	}
	$objPHPExcel->getActiveSheet()->setTitle('Listado 1');// Renombrar Hoja
	$objPHPExcel->setActiveSheetIndex(0);// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
	// --------Cerrar--------
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="Listado Plan Anual de Adquisiciones.xlsx"');
	header('Cache-Control: max-age=0');
	header ('Expires: Mon, 15 Dic 2015 09:31:00 GMT'); // Date in the past
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header ('Pragma: public'); // HTTP/1.0
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
	exit;
?>
