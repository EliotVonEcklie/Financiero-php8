<?php 
	require_once '/PHPExcel/Classes/PHPExcel.php';// Incluir la libreria PHPExcel
	include '/PHPExcel/Classes/PHPExcel/IOFactory.php';// PHPExcel_IOFactory
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	if($_POST[nomdep]!=''){$titulos="$_POST[nomdep]";}
	else{$titulos="INFORMACION GENERAL";}
	$objPHPExcel = new PHPExcel();// Crea un nuevo objeto PHPExcel
	$objPHPExcel->getProperties()->setCreator("G&C Tecnoinversiones SAS")
	   ->setLastModifiedBy("HAFR")
	   ->setTitle("Lista Documentos Radicados")
	   ->setSubject("Planeacion Extrategica")
	   ->setDescription("Planeacion Extrategica")
	   ->setKeywords("Planeacion Extrategica")
	   ->setCategory("Planeacion Extrategica");
	$objPHPExcel->setActiveSheetIndex(0)
		->mergeCells('A1:H1')
		->mergeCells('A2:H2')
  		->setCellValue('A1', 'LISTA DE DOCUMENTOS RADICADOS')
     	->setCellValue('A2', $titulos);
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
		-> getStyle ('A3:H3')
		-> getAlignment ()
		-> applyFromArray (array ( 'horizontal'  =>  PHPExcel_Style_Alignment :: VERTICAL_JUSTIFY ,) ); 
	$objPHPExcel-> getActiveSheet ()
		-> getStyle ("A2")
        -> getFill ()
        -> setFillType (PHPExcel_Style_Fill :: FILL_SOLID)
        -> getStartColor ()
        -> setRGB ('A6E5F3');
	$objPHPExcel-> getActiveSheet ()
		-> getStyle ("A3:H3")
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
	$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->applyFromArray($borders);
	$objPHPExcel->getActiveSheet()->getStyle('A2:H2')->applyFromArray($borders);
	$objPHPExcel->getActiveSheet()->getStyle('A3:H3')->applyFromArray($borders);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('A')->setWidth(12); 
	$objPHPExcel-> getActiveSheet()->getColumnDimension('B')->setWidth(14);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('C')->setWidth(14);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('D')->setWidth(14);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('E')->setWidth(40);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('F')->setWidth(45);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('G')->setWidth(15);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('H')->setWidth(11);
	$objWorksheet = $objPHPExcel->getActiveSheet();
	$objWorksheet->fromArray(array(utf8_encode('Radicación'),"Fecha \nRadicado","Fecha \nVencimiento",'Fecha Respuesta','Tercero',utf8_encode('Descripción'),'Estado','Concluida'),NULL,'A3');
	$cont=4;
	for ($x=0;$x<count($_POST[vradica]);$x++)
	{
		$objWorksheet->fromArray(array($_POST[vradica][$x],$_POST[vfecharad][$x],$_POST[vfechaven][$x],$_POST[vfechares][$x], iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[vtercero][$x]),iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[vdescrip][$x]),$_POST[vestado][$x],$_POST[vconclu][$x]),NULL,"A$cont");
		$objPHPExcel->getActiveSheet()->getStyle("A$cont:H$cont")->applyFromArray($borders);
		$objPHPExcel->getActiveSheet ()->getStyle("E$cont:F$cont")->getAlignment()->setWrapText(true);
		$objPHPExcel-> getActiveSheet ()	
		-> getStyle ("A$cont:H$cont")
		-> getAlignment ()
		-> applyFromArray (array ( 'vertical'  =>  PHPExcel_Style_Alignment :: VERTICAL_TOP ,) );  
		$cont=$cont+1;	
	}
	$objPHPExcel->getActiveSheet()->setTitle('Listado 1');// Renombrar Hoja
	$objPHPExcel->setActiveSheetIndex(0);// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
	// --------Cerrar--------
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="Listado Documentos Radicados.xlsx"');
	header('Cache-Control: max-age=0');
	header ('Expires: Mon, 15 Dic 2015 09:31:00 GMT'); // Date in the past
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header ('Pragma: public'); // HTTP/1.0
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
	exit;
?>
