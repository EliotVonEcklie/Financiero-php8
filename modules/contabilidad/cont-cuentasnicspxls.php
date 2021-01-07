<?php 
	require_once '/PHPExcel/Classes/PHPExcel.php';// Incluir la libreria PHPExcel
	include '/PHPExcel/Classes/PHPExcel/IOFactory.php';// PHPExcel_IOFactory
	require"comun.inc";
	require"funciones.inc";
	session_start();

	$objPHPExcel = new PHPExcel();// Crea un nuevo objeto PHPExcel
	$objPHPExcel->getProperties()->setCreator("G&C Tecnoinversiones SAS")
	   ->setLastModifiedBy("Usuario")
	   ->setTitle("Catalogo de Cuentas NICSP")
	   ->setSubject("Catalogo de Cuentas NICSP")
	   ->setDescription("Catalogo de Cuentas NICSP")
	   ->setKeywords("Catalogo de Cuentas NICSP")
	   ->setCategory("Catalogo");
	$objPHPExcel->setActiveSheetIndex(0)
		->mergeCells('A1:F1')
		->mergeCells('A2:F2')
  		->setCellValue('A1', 'CUENTAS')
     	->setCellValue('A2', 'INFORMACION CUENTAS NICSP');
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
		-> getStyle ('A3:F3')
		-> getAlignment ()
		-> applyFromArray (array ( 'horizontal'  =>  PHPExcel_Style_Alignment :: VERTICAL_JUSTIFY ,) ); 
	$objPHPExcel-> getActiveSheet ()
		-> getStyle ("A2")
        -> getFill ()
        -> setFillType (PHPExcel_Style_Fill :: FILL_SOLID)
        -> getStartColor ()
        -> setRGB ('A6E5F3');
	$objPHPExcel-> getActiveSheet ()
		-> getStyle ("A3:F3")
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
	$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->applyFromArray($borders);
	$objPHPExcel->getActiveSheet()->getStyle('A2:F2')->applyFromArray($borders);
	$objPHPExcel->getActiveSheet()->getStyle('A3:F3')->applyFromArray($borders);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('A')->setWidth(7); 
	$objPHPExcel-> getActiveSheet()->getColumnDimension('B')->setWidth(18);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('C')->setWidth(70);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('D')->setWidth(15);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('E')->setWidth(7);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('F')->setWidth(15);
	$objWorksheet = $objPHPExcel->getActiveSheet();
	$objWorksheet->fromArray(array(utf8_encode('Item'),utf8_encode('Cuenta'),'Descripción',utf8_encode('Tipo'),utf8_encode('Estado'),utf8_encode('Naturaleza')),NULL,'A3');

	$x=3;
	if (count($_POST[item])>0) {
		for ($i=0; $i < count($_POST[item]); $i++) { 

			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValueExplicit ("A$xx", $_POST[item][$i], PHPExcel_Cell_DataType :: TYPE_STRING)
			->setCellValueExplicit ("B$xx", $_POST[cuenta][$i], PHPExcel_Cell_DataType :: TYPE_STRING)
			->setCellValueExplicit ("C$xx", iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[descripcion][$i]), PHPExcel_Cell_DataType :: TYPE_STRING)
			->setCellValueExplicit ("D$xx", iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[tipo][$i]), PHPExcel_Cell_DataType :: TYPE_STRING)
			->setCellValueExplicit ("E$xx", iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[estado][$i]), PHPExcel_Cell_DataType :: TYPE_STRING)
			->setCellValueExplicit ("F$xx", $_POST[naturaleza][$i], PHPExcel_Cell_DataType :: TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getStyle("A$x:F$x")->applyFromArray($borders);

		}

	}
	$objPHPExcel-> getActiveSheet()-> getStyle ("A3:F3")-> getFont ()-> setBold ( true );


	$objPHPExcel->getActiveSheet()->setTitle('Listado 1');// Renombrar Hoja
	$objPHPExcel->setActiveSheetIndex(0);// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
	// --------Cerrar--------
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="Catalogo de Cuentas NICSP.xlsx"');
	header('Cache-Control: max-age=0');
	header ('Expires: Mon, 15 Dic 2015 09:31:00 GMT'); // Date in the past
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header ('Pragma: public'); // HTTP/1.0
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
	exit;
?>