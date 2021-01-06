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
$objPHPExcel->getActiveSheet()->mergeCells('A1:E1');
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Archivos Maestros - Ingresos');

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
            ->setCellValue('A2', 'Codigo')
            ->setCellValue('B2', 'Nombre')
            ->setCellValue('C2', 'Presupuesto')
            ->setCellValue('D2', 'Concepto')
            ->setCellValue('E2', 'Estado');

$sqlr="select * from tesoingresos where tesoingresos.estado<>'' order by tesoingresos.codigo ";
$resp = mysql_query($sqlr,$linkbd);
$i=3;
while ($row =mysql_fetch_row($resp)){
    $sqlr2="select *from tesoingresos_det where tesoingresos_det.estado='S' and tesoingresos_det.codigo='$row[0]' and tesoingresos_det.modulo=4";
    $resp2 = mysql_query($sqlr2,$linkbd);
    $row2 =mysql_fetch_row($resp2);
    $concep=$row2[2];
    $cp=$row2[6];
    $nter=buscatercero($row[4]);
    if($row[3]=="S"){
        $estado="ACTIVO";
    }else if($row[3]=="N"){
        $estado="ANULADO";
    }
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$i,$row[0]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,$row[1]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$i,$cp);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$i,$concep);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$i,$estado);
               /* echo "<input name='nliquidacion[]'  type='hidden'  value='$row[0]'>
                        <input name='ccatastral[]'  type='hidden'  value='$row[1]'>
                        <input name='efecha[]'  type='hidden'  value='$row[2]'>
                        <input name='econtribuyente[]'  type='hidden'  value='$row[4]-$nter'>
                        <input name='evalor[]'  type='hidden'  value='$r2[0]'>";*/
    $i+=1;
                //echo $i;
}
            
/*for( $i=0;$i<count($_POST[nliquidacion]);$i++){
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$i+3,$_POST[nliquidacion][$i]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i+3,$_POST[ccatastral][$i]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$i+3,$_POST[efecha][$i]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$i+3,$_POST[econtribuyente][$i]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$i+3,$_POST[evalor][$i]);
}*/

//----Propiedades de la hoja
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true); 
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true); 
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true); 
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true); 
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true); 
$objPHPExcel->getActiveSheet()->setTitle('Teso-ArchM-Ingresos');
$objPHPExcel->setActiveSheetIndex(0);

//----Guardar documento----
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Teso-ArchM-Ingresos.xls"');
header('Cache-Control: max-age=0');
 
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
$objWriter->save('php://output');
exit;

?>