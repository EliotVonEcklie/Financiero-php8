<?php
ini_set('max_execution_time',3600);
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
        ->setTitle("Exportar Excel con PHP")
        ->setSubject("Documento de prueba")
        ->setDescription("Documento generado con PHPExcel")
        ->setKeywords("usuarios phpexcel")
        ->setCategory("reportes");

//----Cuerpo de Documento----
$objPHPExcel->getActiveSheet()->mergeCells('A1:E1');
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Formato - Plan Conceptos Contables');

			
$objPHPExcel->getActiveSheet()
    ->getStyle('A1:E1')
    ->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()
    ->setARGB('33FF77');
	
$objPHPExcel->getActiveSheet()
    ->getStyle('G1:H1')
    ->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()
    ->setARGB('33FF77');
	
$objPHPExcel->getActiveSheet()
    ->getStyle('J1:K1')
    ->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()
    ->setARGB('33FF77');
	
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
$objPHPExcel->getActiveSheet()->getStyle('G1:H1')->applyFromArray($borders);
$objPHPExcel->getActiveSheet()->getStyle('J1:K1')->applyFromArray($borders);

$objFont=$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont();
$objFont->setName('Courier New'); 
$objFont->setSize(15); 
$objFont->setBold(true); 
$objFont->setUnderline(PHPExcel_Style_Font::UNDERLINE_SINGLE);
$objFont->getColor()->setARGB( PHPExcel_Style_Color::COLOR_BLACK);

$objAlign=$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment(); 
$objAlign->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
$objAlign->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 

$objAlign=$objPHPExcel->getActiveSheet()->getStyle('G1')->getAlignment(); 
$objAlign->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
$objAlign->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 

$objAlign=$objPHPExcel->getActiveSheet()->getStyle('J1')->getAlignment(); 
$objAlign->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
$objAlign->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 


$objPHPExcel->getActiveSheet()->mergeCells('G1:H1');
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('G1', 'Programacion de pago');	


$objPHPExcel->getActiveSheet()->mergeCells('J1:K1');
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('J1', 'Programacion reconocimiento CXP');



$objAlign=$objPHPExcel->getActiveSheet()->getStyle('G2:H2')->getAlignment(); 
$objAlign->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
$objAlign->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);


$objAlign=$objPHPExcel->getActiveSheet()->getStyle('J2:K2')->getAlignment(); 
$objAlign->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
$objAlign->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);


$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A2', 'Rubro')
			->setCellValue('B2', 'Nombre')
            ->setCellValue('C2', 'Vigencia')
			->setCellValue('D2', 'Programacion de pago')
			->setCellValue('E2', 'Programacion reconocimiento CXP');
					
$objFont=$objPHPExcel->getActiveSheet()->getStyle('A2:E2')->getFont();
$objFont->setName('Courier New'); 
$objFont->setSize(9); 
$objFont->setBold(true); 


$objPHPExcel->getActiveSheet()->getStyle('J1')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('K1')->getAlignment()->setWrapText(true);
//**** Cabeza de celda
$objPHPExcel->getActiveSheet()->getStyle('J2')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('K2')->getAlignment()->setWrapText(true);
//**Subtitulos de celda
$objPHPExcel->getActiveSheet()->setCellValue('J2', 'Codigo');
$objPHPExcel->getActiveSheet()->setCellValue('K2', 'Concepto');

$sql="Select * from conceptoscontables  where modulo='3' and (tipo='C') order by codigo DESC";
$res=mysql_query($sql,$linkbd);
$numtotmod=mysql_num_rows($res);
$numtotmod=$numtotmod+2;

$i=2;
while($row = mysql_fetch_array($res)){
	$objPHPExcel->getActiveSheet()->setCellValue('J'.($i+1), $row[0]);
	$objPHPExcel->getActiveSheet()->setCellValue('K'.($i+1), $row[0]."-".$row[1]);
	$objPHPExcel->getActiveSheet()->getStyle('J'.$i.':K'.$i)->applyFromArray($borders);
	$objPHPExcel->getActiveSheet()->getStyle('J'.$i)->getAlignment()->setWrapText(true);
	$objPHPExcel->getActiveSheet()->getStyle('K'.$i)->getAlignment()->setWrapText(true);
	$i++;
}
$objPHPExcel->getActiveSheet()->getStyle('J'.$i.':K'.$i)->applyFromArray($borders);

$sql="Select * from conceptoscontables  where modulo='3' and (tipo='N' or tipo='P') order by codigo DESC";
$rest=mysql_query($sql,$linkbd);
$numtot=mysql_num_rows($rest);
$numtot=$numtot+3;
$i=2;
$objPHPExcel->getActiveSheet()->setCellValue('G2', 'Codigo');
$objPHPExcel->getActiveSheet()->setCellValue('H2', 'Concepto');
$objPHPExcel->getActiveSheet()
    ->getProtection()->setSheet(true);
while($row = mysql_fetch_array($rest)){
	$objPHPExcel->getActiveSheet()->setCellValue('G'.($i+1), $row[0]);
	$objPHPExcel->getActiveSheet()->setCellValue('H'.($i+1), $row[0]."-".$row[1]);
    $objPHPExcel->getActiveSheet()->getStyle('G'.$i.':H'.$i)->applyFromArray($borders);
	$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getAlignment()->setWrapText(true);
    $objPHPExcel->getActiveSheet()->getStyle('H'.$i)->getAlignment()->setWrapText(true);
    $i++;
}
$objPHPExcel->getActiveSheet()->getStyle('G'.$i.':H'.$i)->applyFromArray($borders);

$i=2;
$sqlr = "SELECT cuenta,nombre,vigencia FROM pptocuentas WHERE vigencia='$_POST[vigencia]' AND clasificacion!='ingresos' AND tipo='Auxiliar'";
$rest=mysql_query($sqlr,$linkbd);
while($row = mysql_fetch_array($rest))
{
    $objPHPExcel->getActiveSheet()->setCellValue('A'.($i+1), $row[0]);
    $objPHPExcel->getActiveSheet()->setCellValue('B'.($i+1), $row[1]);
    $objPHPExcel->getActiveSheet()->setCellValue('C'.($i+1), $row[2]);
	$objPHPExcel->getActiveSheet()->getStyle('A'.($i+1).':E'.($i+1))->applyFromArray($borders);
	$objPHPExcel->getActiveSheet()->getStyle('A'.($i+1).':E'.($i+1))
    ->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
	$objPHPExcel->getActiveSheet()->getStyle('A'.($i+1).':E'.($i+1))->getAlignment()->setWrapText(true);
	//------data validation Fuentes
	$objValidation = $objPHPExcel->getActiveSheet()->getCell('D'.($i+1))->getDataValidation();

	$objValidation->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );

	$objValidation->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );

	$objValidation->setAllowBlank(false);

	$objValidation->setShowInputMessage(true);

	$objValidation->setShowErrorMessage(true);

	$objValidation->setShowDropDown(true);

	$objValidation->setErrorTitle('Input error');

	$objValidation->setError('El valor no esta en la lista');

	$objValidation->setPromptTitle('Presiona la lista');

	$objValidation->setPrompt('Por favor, seleccionar un valor de la lista');

	$objValidation->setFormula1("'Parametrizacion Conceptos'!E$3:E$$numtot");
	
	//------data validation Modalidad
	$objValidation = $objPHPExcel->getActiveSheet()->getCell('E'.($i+1))->getDataValidation();

	$objValidation->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );

	$objValidation->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );

	$objValidation->setAllowBlank(false);

	$objValidation->setShowInputMessage(true);

	$objValidation->setShowErrorMessage(true);

	$objValidation->setShowDropDown(true);

	$objValidation->setErrorTitle('Input error');

	$objValidation->setError('El valor no esta en la lista');

	$objValidation->setPromptTitle('Presiona la lista');

	$objValidation->setPrompt('Por favor, seleccionar un valor de la lista');

	$objValidation->setFormula1("'Parametrizacion Conceptos'!G$3:G$$numtotmod");
	//--Formato tipo texto de fecha
	$objPHPExcel->getActiveSheet()
    ->getStyle('C'.$i)
    ->getNumberFormat()
    ->setFormatCode(
        PHPExcel_Style_NumberFormat::FORMAT_TEXT
    );
    $i++;
}
//----Propiedades de la hoja
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(32);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12); 
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(60); 
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(12); 
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(60);  
$objPHPExcel->getActiveSheet()->setTitle('Parametrizacion Conceptos');
$objPHPExcel->setActiveSheetIndex(0);

//----Guardar documento----
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="conceptos-contables-import.xls"');
header('Cache-Control: max-age=0');
 
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
$objWriter->save('php://output');
exit;

?>