<?php 
	require_once '/PHPExcel/Classes/PHPExcel.php';// Incluir la libreria PHPExcel
	include '/PHPExcel/Classes/PHPExcel/IOFactory.php';// PHPExcel_IOFactory
	require"comun.inc";
	require"funciones.inc";
	session_start();

	$objPHPExcel = new PHPExcel();// Crea un nuevo objeto PHPExcel
	$objPHPExcel->getProperties()->setCreator("G&C Tecnoinversiones SAS")
	   ->setLastModifiedBy("Usuario")
	   ->setTitle("Cuentas Bancarias")
	   ->setSubject("Cuentas Bancarias")
	   ->setDescription("Cuentas Bancarias")
	   ->setKeywords("Cuentas Bancarias")
	   ->setCategory("Catalogo");
	$objPHPExcel->setActiveSheetIndex(0)
		->mergeCells('A1:G1')
		->mergeCells('A2:G2')
  		->setCellValue('A1', 'TERCEROS')
     	->setCellValue('A2', 'BUSCAR TERCEROS ');
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
	$objPHPExcel-> getActiveSheet()->getColumnDimension('A')->setWidth(6); 
	$objPHPExcel-> getActiveSheet()->getColumnDimension('B')->setWidth(70);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('C')->setWidth(18);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('D')->setWidth(20);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('E')->setWidth(17);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('F')->setWidth(17);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('G')->setWidth(15);

	

	$objWorksheet = $objPHPExcel->getActiveSheet();
	$objWorksheet->fromArray(array(utf8_encode('Item'),utf8_encode('Razon Social'),'Primer apellido',utf8_encode('Segundo apellido'),utf8_encode('Primer nombre'),utf8_encode('Segundo nombre'),utf8_encode('Documento')),NULL,'A3');


	if (count($_POST[item])>0) {
		for ($i=0; $i < count($_POST[item]); $i++) { 
			$x=$i+4;
			
			$objWorksheet->fromArray(array($_POST[item][$i],$_POST[ra][$i],$_POST[nom][$i],$_POST[ap][$i],$_POST[nom1][$i],$_POST[ap1][$i],$_POST[doc][$i]),NULL,'A'.$x);
			$objPHPExcel->getActiveSheet()->getStyle("A$x:G$x")->applyFromArray($borders);			
			$objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
			$objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_JUSTIFY,));
		}

	}
	$objPHPExcel-> getActiveSheet()-> getStyle ("A3:G3")-> getFont ()-> setBold ( true );


	$objPHPExcel->getActiveSheet()->setTitle('Listado 1');// Renombrar Hoja
	$objPHPExcel->setActiveSheetIndex(0);// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
	// --------Cerrar--------
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="Terceros.xlsx"');
	header('Cache-Control: max-age=0');
	header ('Expires: Mon, 15 Dic 2015 09:31:00 GMT'); // Date in the past
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header ('Pragma: public'); // HTTP/1.0
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
	exit;
?>