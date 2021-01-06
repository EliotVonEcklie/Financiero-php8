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
$objPHPExcel->getActiveSheet()->mergeCells('A1:F1');
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Archivos Maestros - Chequeras');

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
            ->setCellValue('A2', 'Cuenta Bancaria')
            ->setCellValue('B2', 'Nombre Banco')
            ->setCellValue('C2', 'Inicial')
            ->setCellValue('D2', 'Final')
            ->setCellValue('E2', 'Consecutivo')
            ->setCellValue('F2', 'Estado');

$i=3;
$estado="";
$sqlr="select *from tesochequeras,terceros,tesobancosctas where tesochequeras.banco=tesobancosctas.tercero and tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.ncuentaban = tesochequeras.cuentabancaria and tesobancosctas.estado='S' order by tesochequeras.banco";
$resp = mysql_query($sqlr,$linkbd);
while ($row =mysql_fetch_row($resp)) 
 {
    
    if($row[7]=='S')
    {
        $estado="ACTIVO";
    }else
    {
        $estado="INACTIVO";
    }
    
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$i,$row[2]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,$row[13]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$i,$row[4]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$i,$row[5]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$i,$row[6]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$i,$estado);
    $i+=1;
 }

//----Propiedades de la hoja
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true); 
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true); 
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true); 
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true); 
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true); 
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setTitle('Chequeras');
$objPHPExcel->setActiveSheetIndex(0);

//----Guardar documento----
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Teso-Arch-M-Chequeras.xls"');
header('Cache-Control: max-age=0');
 
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
$objWriter->save('php://output');
exit;

?>