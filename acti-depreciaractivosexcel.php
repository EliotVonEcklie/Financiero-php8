<?php  
	require_once 'PHPExcel/Classes/PHPExcel.php';
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();  
	$objPHPExcel = new PHPExcel();
	//----Propiedades----
	$objPHPExcel->getProperties()
        ->setCreator("SPID")
        ->setLastModifiedBy("SPID")
        ->setTitle("Listado Activos Depreciacion")
        ->setSubject("Activos")
        ->setDescription("Activos")
        ->setKeywords("Activos")
        ->setCategory("Activos Fijos");
	//----Cuerpo de Documento----
	$objPHPExcel->getActiveSheet()->mergeCells('A1:K1');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "Gestion de Activos - Depreciar Listado No: $_POST[codigo]");

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
		-> getStyle ("A2:K2")	
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
	$objPHPExcel->getActiveSheet()->getStyle('A2:AD2')->applyFromArray($borders);
	$objPHPExcel->setActiveSheetIndex(0)
           // ->setCellValue('A2', iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",'N°'))
		   ->setCellValue('B2', 'No')
			->setCellValue('B2', 'Placa')
            ->setCellValue('C2', 'Fecha Activacion')
			->setCellValue('D2', 'Nombre')
            ->setCellValue('E2', 'Clase')
            ->setCellValue('F2', 'Grupo')
            ->setCellValue('G2', 'Tipo')
			->setCellValue('H2', 'Valor')
			->setCellValue('I2', 'Valor Depreciado')
			->setCellValue('J2', 'Valor por Depreciar')
			->setCellValue('K2', 'Valor Depreciacion Mensual');
	$i=3;
	$cont=1;
	$sqlr="SELECT placa,fechact,nombre,clase,grupo,tipo,valor,valord,valorad,valdep FROM actidepactivo_det WHERE id_dep='$_POST[codigo]' ORDER BY placa";
	$resp=mysql_query($sqlr,$linkbd);
	$row =mysql_fetch_row($resp);
	while ($row =mysql_fetch_row($resp)) 
	{
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValueExplicit ("A$i", $cont, PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("B$i", $row[0], PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("C$i", $row[1], PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("D$i", $row[2], PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("E$i", $row[3], PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("F$i", $row[4], PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("G$i", $row[5], PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("H$i", $row[6], PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("I$i", $row[7], PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("J$i", $row[8], PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("K$i", $row[9], PHPExcel_Cell_DataType :: TYPE_NUMERIC);
		$objPHPExcel->getActiveSheet()->getStyle("A$i:K$i")->applyFromArray($borders);
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
	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true); 
	$objPHPExcel->getActiveSheet()->setTitle("Listado $_POST[codigo]");
	$objPHPExcel->setActiveSheetIndex(0);

//----Guardar documento----
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Listado Depreciacion.xls"');
header('Cache-Control: max-age=0');
 
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
$objWriter->save('php://output');
exit;

?>