<?php  
	require_once 'PHPExcel/Classes/PHPExcel.php';
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$listanomina=unserialize($_POST['lista_nominas']);
	$listames=unserialize($_POST['lista_meses']);
	$listavigencia=unserialize($_POST['lista_vigencias']);	
	$listadocumento=unserialize($_POST['lista_documentos']);
	$listafuncionario=unserialize($_POST['lista_funcionarios']);
	$listanomdescuento=unserialize($_POST['lista_nomdescuentos']);
	$listavaldescuento=unserialize($_POST['lista_valdescuentos']);
	$linkbd=conectar_bd();  
	$objPHPExcel = new PHPExcel();
	//----Propiedades----
	$objPHPExcel->getProperties()
        ->setCreator("SPID")
        ->setLastModifiedBy("SPID")
        ->setTitle("Reporte Descuentos")
        ->setSubject("Descuentos")
        ->setDescription("Descuentos")
        ->setKeywords("Descuentos")
        ->setCategory("Gestion Humana");
	//----Cuerpo de Documento----
	$objPHPExcel->getActiveSheet()->mergeCells('A1:H1');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'REPORTE GENERAL DESCUENTOS DE NOMINA');

	$objFont=$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont();
	$objFont->setName('Courier New'); 
	$objFont->setSize(15); 
	$objFont->setBold(true); 
	$objFont->setUnderline(PHPExcel_Style_Font::UNDERLINE_SINGLE);
	$objFont->getColor()->setARGB( PHPExcel_Style_Color::COLOR_BLACK);

	$objAlign=$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment(); 
	$objAlign->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
	$objAlign->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
	$objPHPExcel-> getActiveSheet ()
		-> getStyle ("A2:H2")	
        -> getFill ()
        -> setFillType (PHPExcel_Style_Fill :: FILL_SOLID)
        -> getStartColor ()
        -> setRGB ('A6E5F3');
	$objPHPExcel-> getActiveSheet ()
		-> getStyle ("A1")	
        -> getFill ()
        -> setFillType (PHPExcel_Style_Fill :: FILL_SOLID)
        -> getStartColor ()
        -> setRGB ('A6E5F3');
	$borders = array(
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN,
          'color' => array('argb' => 'FF000000'),
        )
      ),
    );
	$objPHPExcel->getActiveSheet()->getStyle('A2:H2')->applyFromArray($borders);
	$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A2', 'N°')
            ->setCellValue('B2', 'N° NOMINA')
			->setCellValue('C2', 'MES')
            ->setCellValue('D2', 'VIGENCIA')
            ->setCellValue('E2', 'DOCUMENTO')
            ->setCellValue('F2', 'FUNCIONARIO')
            ->setCellValue('G2', 'DESCUENTO')
			->setCellValue('H2', 'VALOR');
	$i=3;
	for($ii=0;$ii<count ($listanomina);$ii++)
	{
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValueExplicit ("A$i", $ii+1, PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("B$i", $listanomina[$ii], PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("C$i", $listames[$ii], PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("D$i", $listavigencia[$ii], PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("E$i", $listadocumento[$ii], PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("F$i", utf8_encode($listafuncionario[$ii]), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("G$i", utf8_encode($listanomdescuento[$ii]), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("H$i", round ($listavaldescuento[$ii],0,PHP_ROUND_HALF_UP), PHPExcel_Cell_DataType :: TYPE_NUMERIC);
		$objPHPExcel->getActiveSheet()->getStyle("A$i:H$i")->applyFromArray($borders);
		$i++;
	}
	//----Propiedades de la hoja 1
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->setTitle('Reporte');
	$objPHPExcel->setActiveSheetIndex(0);

//----Guardar documento----
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Reporte.xls"');
header('Cache-Control: max-age=0');
 
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
$objWriter->save('php://output');
exit;

?>