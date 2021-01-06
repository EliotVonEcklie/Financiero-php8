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
$objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Archivos Maestros - Terceros');

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
            ->setCellValue('B2', 'Razon Social')
            ->setCellValue('C2', 'Primer Apellido')
            ->setCellValue('D2', 'Segundo Apellido')
            ->setCellValue('E2', 'Primer Nombre')
            ->setCellValue('F2', 'Segundo Nombre')
            ->setCellValue('G2', 'Documento');

$sqlr="select *from terceros where terceros.estado='S' order by terceros.apellido1, terceros.apellido2, terceros.nombre1, terceros.nombre2, terceros.razonsocial";
$resp = mysql_query($sqlr,$linkbd);
$i=3;
while ($row =mysql_fetch_row($resp)){
    
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$i,$i-2);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,utf8_encode($row[5]));
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$i,utf8_encode($row[3]));
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$i,utf8_encode($row[4]));
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$i,utf8_encode($row[1]));
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$i,utf8_encode($row[2]));
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$i,$row[12]);
    
    $i+=1;
                
}
            

//----Propiedades de la hoja
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true); 
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true); 
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true); 
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true); 
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true); 
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true); 
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setTitle('Terceros');
$objPHPExcel->setActiveSheetIndex(0);

//----Guardar documento----
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Teso-ArchM-Terceros.xls"');
header('Cache-Control: max-age=0');
 
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
$objWriter->save('php://output');
exit;

?>