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
        ->setTitle("Exportar Excel con PHP")
        ->setSubject("Documento de prueba")
        ->setDescription("Documento generado con PHPExcel")
        ->setKeywords("usuarios phpexcel")
        ->setCategory("reportes");

//----Cuerpo de Documento----
$objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Formato - Plan de Cuentas');

$objPHPExcel->getActiveSheet()
    ->getStyle('A1:G1')
    ->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()
    ->setARGB('22C6CB');


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

$objFont=$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont();
$objFont->setName('Courier New');
$objFont->setSize(15);
$objFont->setBold(true);
$objFont->setUnderline(PHPExcel_Style_Font::UNDERLINE_SINGLE);
$objFont->getColor()->setARGB( PHPExcel_Style_Color::COLOR_BLACK);

$objAlign=$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment();
$objAlign->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objAlign->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A2', 'Cuenta')
            ->setCellValue('B2', 'Nombre de la cuenta')
            ->setCellValue('C2', 'Tipo')
			->setCellValue('D2', 'Clasificacion')
			->setCellValue('E2', 'Regalias (S/N)')
			->setCellValue('F2', 'Causacion Contable (S/N)')
			->setCellValue('G2', 'Fuente');

//----Propiedades de la hoja
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setTitle('Adicion-Reduccion');
$objPHPExcel->setActiveSheetIndex(0);

//----Guardar documento----
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Presu-pptocuentas-import.xls"');
header('Cache-Control: max-age=0');

$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
$objWriter->save('php://output');
exit;

?>
