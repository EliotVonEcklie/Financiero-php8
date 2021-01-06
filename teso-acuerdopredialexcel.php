<?php  
require_once 'PHPExcel/Classes/PHPExcel.php';
require"comun.inc";
require"funciones.inc";
session_start();
$linkbd=conectar_bd();  
$objPHPExcel = new PHPExcel();
$vig=vigencia_usuarios($_SESSION[cedulausu]);
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
$objPHPExcel->getActiveSheet()->mergeCells('A1:I1');
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'ACUERDO PAGO PREDIAL POR CUOTAS');

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
		-> getStyle ("A2:I2")	
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
$objPHPExcel->getActiveSheet()->getStyle('A2:I2')->applyFromArray($borders);
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A2', 'Acuerdo')
            ->setCellValue('B2', 'Fecha acuerdo')
            ->setCellValue('C2', 'Fecha maxima')
            ->setCellValue('D2', 'Codigo catastral')
            ->setCellValue('E2', 'Propietario')
            ->setCellValue('F2', 'Cuotas pagas')
            ->setCellValue('G2', 'Cuotas')
			->setCellValue('H2', 'Valor')
			->setCellValue('I2', 'Estado');

$i=3;
for($j=0;$j<count($_POST[acuerdop]);$j++)
{
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$i,$_POST[acuerdop][$j]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,$_POST[fechap][$j]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$i,$_POST[fechap1][$j]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$i,"cod: ".$_POST[codcatastral][$j]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$i,$_POST[propietariop][$j]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$i,$_POST[cuotaspagas][$j]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$i,$_POST[cuotas][$j]);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$i,$_POST[valorp][$j]);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$i,$_POST[estadop][$j]);
	$objPHPExcel->getActiveSheet()->getStyle("A$i:I$i")->applyFromArray($borders);
    $i=$i+1;
}

//----Propiedades de la hoja
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true); 
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true); 
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true); 
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true); 
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true); 
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true); 
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true); 
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true); 
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true); 
$objPHPExcel->getActiveSheet()->setTitle('Acuerdo');
$objPHPExcel->setActiveSheetIndex(0);

//----Guardar documento----
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="teso-acuerdo.xls"');
header('Cache-Control: max-age=0');
 
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
$objWriter->save('php://output');
exit;

?>