<?php //V 1000 12/12/16 ?> 
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
$objPHPExcel->getActiveSheet()->mergeCells('A1:K1');
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Estratificación');

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
            ->setCellValue('A2', 'Item')
            ->setCellValue('B2', 'Codigo Catastral')
            ->setCellValue('C2', 'Avaluo')
			->setCellValue('D2', 'Documento')
            ->setCellValue('E2', 'Propietario')
            ->setCellValue('F2', 'Direccion')
			->setCellValue('G2', 'Ha')
            ->setCellValue('H2', 'Mt2')
            ->setCellValue('I2', 'Area Cons')
            ->setCellValue('J2', 'Tipo')
            ->setCellValue('K2', 'Estratos o Rangos Avaluo');

$con=4;
while ($con<count($_POST[codcath])+4) 
{
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue("A".$con, $con-3)
	->setCellValueExplicit("B".$con, $_POST[codcath][$con-4], PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValue("C".$con, $_POST[avaluoh][$con-4])
	->setCellValue("D".$con, $_POST[documeh][$con-4])
	->setCellValue("E".$con, $_POST[propieh][$con-4])
	->setCellValue("F".$con, $_POST[direcch][$con-4])
	->setCellValue("G".$con, $_POST[hah][$con-4])
	->setCellValue("H".$con, $_POST[mt2h][$con-4])
	->setCellValue("I".$con, $_POST[areconh][$con-4])
	->setCellValue("J".$con, $_POST[tipoh][$con-4])
	->setCellValue("K".$con, $_POST[estrath][$con-4]);
	$objPHPExcel->getActiveSheet()->getStyle('E'.$con)->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,));
	$con=$con+1;
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
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true); 
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true); 
$objPHPExcel->getActiveSheet()->setTitle('Teso-Estratificacion');
$objPHPExcel->setActiveSheetIndex(0);



//----Guardar documento----
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Teso-Estratificacion.xls"');
header('Cache-Control: max-age=0');
 
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
$objWriter->save('php://output');
exit;

?>