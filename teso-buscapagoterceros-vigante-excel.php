<?php 
	require_once '/PHPExcel/Classes/PHPExcel.php';// Incluir la libreria PHPExcel
	include '/PHPExcel/Classes/PHPExcel/IOFactory.php';// PHPExcel_IOFactory
	require"comun.inc";
	require"funciones.inc";
	session_start();

	$objPHPExcel = new PHPExcel();// Crea un nuevo objeto PHPExcel
	$objPHPExcel->getProperties()->setCreator("G&C Tecnoinversiones SAS")
	   ->setLastModifiedBy("Usuario")
	   ->setTitle("Otros Egresos")
	   ->setSubject("Otros Egresos")
	   ->setDescription("Otros Egresos")
	   ->setKeywords("Otros Egresos")
	   ->setCategory("Otros Egresos");
	$objPHPExcel->setActiveSheetIndex(0)
		->mergeCells('A1:E1')
		->setCellValue('A1', 'OTROS EGRESOS');
	$objPHPExcel-> getActiveSheet ()
        -> getStyle ("A1")
        -> getFill ()
        -> setFillType (PHPExcel_Style_Fill :: FILL_SOLID)
        -> getStartColor ()
        -> setRGB ('C8C8C8');
	$objPHPExcel-> getActiveSheet ()
        -> getStyle ("A1")
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
		-> getStyle ('A3:D3')
		-> getAlignment ()
		-> applyFromArray (array ( 'horizontal'  =>  PHPExcel_Style_Alignment :: VERTICAL_JUSTIFY ,) ); 
	$objPHPExcel-> getActiveSheet ()
		-> getStyle ("A2")
        -> getFill ()
        -> setFillType (PHPExcel_Style_Fill :: FILL_SOLID)
        -> getStartColor ()
        -> setRGB ('A6E5F3');
	$objPHPExcel-> getActiveSheet ()
		-> getStyle ("A2:E3")
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
	$objPHPExcel->getActiveSheet()->getStyle('A1:E1')->applyFromArray($borders);
	$objPHPExcel->getActiveSheet()->getStyle('A2:E2')->applyFromArray($borders);
	$objPHPExcel->getActiveSheet()->getStyle('A3:E3')->applyFromArray($borders);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('A')->setWidth(9); 
	$objPHPExcel-> getActiveSheet()->getColumnDimension('B')->setWidth(136);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('C')->setWidth(10);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('D')->setWidth(54);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('E')->setWidth(27);


	

	$objWorksheet = $objPHPExcel->getActiveSheet();
	$objWorksheet->fromArray(array(utf8_encode('Codigo'),utf8_encode('Concepto'),'Fecha',utf8_encode('Beneficiario'),utf8_encode('Valor')),NULL,'A3');


	if (count($_POST[code])>0) {
		for ($i=0; $i < count($_POST[code]); $i++) { 
			$x=$i+4;
			
			$objWorksheet->fromArray(array($_POST[code][$i],$_POST[cont][$i],$_POST[fecha][$i],$_POST[ben][$i],$_POST[num][$i]),NULL,'A'.$x);
			$objPHPExcel->getActiveSheet()->getStyle("A$x:E$x")->applyFromArray($borders);			
			$objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
			$objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_JUSTIFY,));
		}

	}
	$objPHPExcel-> getActiveSheet()-> getStyle ("A2:E3")-> getFont ()-> setBold ( true );


	$objPHPExcel->getActiveSheet()->setTitle('Listado 1');// Renombrar Hoja
	$objPHPExcel->setActiveSheetIndex(0);// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
	// --------Cerrar--------
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="Otros Egresos.xlsx"');
	header('Cache-Control: max-age=0');
	header ('Expires: Mon, 15 Dic 2015 09:31:00 GMT'); // Date in the past
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header ('Pragma: public'); // HTTP/1.0
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
	exit;
?>