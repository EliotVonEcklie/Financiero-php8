<?php 
	require_once '/PHPExcel/Classes/PHPExcel.php';// Incluir la libreria PHPExcel
	include '/PHPExcel/Classes/PHPExcel/IOFactory.php';// PHPExcel_IOFactory
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
	$sqlr="select *from configbasica where estado='S'";
	$res=mysql_query($sqlr,$linkbd);
	while($row=mysql_fetch_row($res)){$nit=$row[0];$rs=$row[1];}
	$objPHPExcel = new PHPExcel();// Crea un nuevo objeto PHPExcel
	$objPHPExcel->getProperties()->setCreator("G&C Tecnoinversiones SAS")
	   ->setLastModifiedBy("HAFR")
	   ->setTitle("Auxiliar Por Tercero y Cuenta")
	   ->setSubject("Informes Contratacion")
	   ->setDescription("Informe")
	   ->setKeywords("Informe Auxiliar por tercero y cuenta")
	   ->setCategory("Contratacion");
	$objPHPExcel->setActiveSheetIndex(0)
		->mergeCells('A1:L1')
		->mergeCells('A2:L2')
  		->setCellValue('A1', "$rs - $nit")
     	->setCellValue('A2', "AUXILIAR CONTABILIDAD  TERCERO CUENTA- Periodo: $_POST[fecha] - $_POST[fecha2]");
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
        -> setRGB ('2335FF');
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
	$objPHPExcel-> getActiveSheet()->getColumnDimension('B')->setWidth(12);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('C')->setWidth(12);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('D')->setWidth(12);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('E')->setWidth(12);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('F')->setWidth(11);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('G')->setWidth(42);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('H')->setWidth(12);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('I')->setWidth(11);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('J')->setWidth(27);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('K')->setWidth(38);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('L')->setWidth(21);
	$objWorksheet = $objPHPExcel->getActiveSheet();
	$objWorksheet->fromArray(array("FECHA","TIPO COMP","No COMP","CC","CUENTA","CONCEPTO","TERCERO","NOMBRE TERCERO","SALDO INICIAL","DEBITOS","CREDITOS","SALDO"),NULL,'A3');
	$cont=3;
	$namearch="archivos/".$_SESSION[usuario]."tercerocuenta$_POST[nivel].csv";
	if (($gestor = fopen($namearch, "r")) !== FALSE) 
	{
    	while (($datos = fgetcsv($gestor, 1000, ";")) !== FALSE) 
		{
			if($cont!=3)
			{
				$nc=buscatercero($datos[6]);
				$objWorksheet->fromArray(array($datos[0],$datos[1],$datos[2],$datos[3],$datos[4],utf8_encode($datos[5]),$datos[6],utf8_encode($nc),$datos[8],$datos[9],$datos[10],$datos[11]),NULL,"A$cont");
				$objPHPExcel->getActiveSheet()->getStyle("A$cont:L$cont")->applyFromArray($borders);
				$objPHPExcel->getActiveSheet()->getStyle("I$cont:L$cont")->getNumberFormat()
				->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			}
			$cont=$cont+1;	
       	 	
    }
    fclose($gestor);
		
		
	}
	$objPHPExcel->getActiveSheet()->setTitle('Listado 1');// Renombrar Hoja
	$objPHPExcel->setActiveSheetIndex(0);// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
	// --------Cerrar--------
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="contabilidadtercerocuenta.xlsx"');
	header('Cache-Control: max-age=0');
	header ('Expires: Mon, 15 Dic 2015 09:31:00 GMT'); // Date in the past
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header ('Pragma: public'); // HTTP/1.0
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
	exit;
?>
