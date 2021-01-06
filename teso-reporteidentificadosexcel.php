<?php  
	require_once 'PHPExcel/Classes/PHPExcel.php';
	require "comun.inc";
	require "funciones.inc";
	session_start();
	$linkbd=conectar_bd();  
	$objPHPExcel = new PHPExcel();
	//----Propiedades----
	$objPHPExcel->getProperties()
        ->setCreator("SPID")
        ->setLastModifiedBy("SPID")
        ->setTitle("Reporte Identificados")
        ->setSubject("Tesoreria")
        ->setDescription("Tesoreria")
        ->setKeywords("Tesoreria")
        ->setCategory("Tesoreria");
	//----Cuerpo de Documento----
	$objPHPExcel->getActiveSheet()->mergeCells('A1:F1');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'IDENTIFICADOS');

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
		-> getStyle ("A2:F2")	
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
	$objPHPExcel->getActiveSheet()->getStyle('A2:F2')->applyFromArray($borders);
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A2', 'COMPROBANTE')
	->setCellValue('B2', 'CONCEPTO')
	->setCellValue('C2', 'TERCERO')
	->setCellValue('D2', 'FECHA')
	->setCellValue('E2', 'VALOR')
	->setCellValue('F2', 'ESTADO');
	
    $i=3;
    for($xx=0; $xx<count($_POST[id_recaudo]); $xx++)
    {
        if($_POST[estadoComp][$xx]=='POR IDENTIFICAR')
        {
            $objPHPExcel-> getActiveSheet ()
            -> getStyle ("F$i")
            -> getFill ()
            -> setFillType (PHPExcel_Style_Fill :: FILL_SOLID)
            -> getStartColor ()
            -> setRGB ('F85D3C');
        }
        else
        {
            $objPHPExcel-> getActiveSheet ()
            -> getStyle ("F$i")
            -> getFill ()
            -> setFillType (PHPExcel_Style_Fill :: FILL_SOLID)
            -> getStartColor ()
            -> setRGB ('45F93D');
        }
        $terceroI = "";
        $terceroI = buscatercero($_POST[tercero][$xx]);
        //echo $fuenteRp." <br>";
        $objPHPExcel->setActiveSheetIndex(0)
		->setCellValueExplicit ("A$i", $_POST[id_recaudo][$xx], PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("B$i", iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[concepto][$xx]), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("C$i", iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[tercero][$xx]." - ".$terceroI), PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("D$i", $_POST[fecha][$xx], PHPExcel_Cell_DataType :: TYPE_STRING)
		->setCellValueExplicit ("E$i", $_POST[valor][$xx], PHPExcel_Cell_DataType :: TYPE_NUMERIC)
		->setCellValueExplicit ("F$i", $_POST[estadoComp][$xx], PHPExcel_Cell_DataType :: TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getStyle("A$i:F$i")->applyFromArray($borders);
		$i++;
    }
		
	//----Propiedades de la hoja 1
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth('60');
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth('60');
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->setTitle('IDENTIFICADOS');
	$objPHPExcel->setActiveSheetIndex(0);

//----Guardar documento----
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="REPORTE IDENTIFICADOS.xls"');
header('Cache-Control: max-age=0');
 
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
$objWriter->save('php://output');
exit;

?>