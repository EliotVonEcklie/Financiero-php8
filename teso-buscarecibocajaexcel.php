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
$objPHPExcel->getActiveSheet()->mergeCells('A1:I1');
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Recaudo - Otros Recaudos');

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
            ->setCellValue('A2', 'No Recibo')
            ->setCellValue('B2', 'Concepto')
            ->setCellValue('C2', 'Fecha')
			->setCellValue('D2', 'Doc. Contribuyente')
			->setCellValue('E2', 'Contribuyente')
			->setCellValue('F2', 'Valor')
            ->setCellValue('G2', 'No Liquidación')
            ->setCellValue('H2', 'Tipo')
            ->setCellValue('I2', 'Estado');

$i=3;
$estado="";
$tipos=array('Predial','Industria y Comercio','Otros Recaudos');
$sqlr="select *from tesorecaudos where tesorecaudos.id_recaudo>-1 order by tesorecaudos.id_recaudo DESC";
$resp = mysql_query($sqlr,$linkbd);
while ($row =mysql_fetch_row($resp)) 
 {
    if($row[10]==1){$sqlrt="select tercero from tesoliquidapredial where tesoliquidapredial.idpredial=$row[4]";}
    if($row[10]==2){$sqlrt="select tercero from tesoindustria where $row[4]=tesoindustria.id_industria";}
    if($row[10]==3){$sqlrt="select tercero from tesorecaudos where tesorecaudos.id_recaudo=$row[4]";}
    $rest=mysql_query($sqlrt,$linkbd);
    $rowt=mysql_fetch_row($rest);       
    if($row[9]=="P"){
        $estado="PAGO";
    }else if($row[9]=="S"){
        $estado="ACTIVO";
    }else if($row[9]=="N"){
        $estado="ANULADO";
    }
    $ntercero=buscatercero($rowt[0]);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$i,$row[0]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,utf8_encode($row[11]));
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$i,$row[2]);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$i,$row[0]);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$i,utf8_encode($ntercero));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$i,$row[8]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$i,$row[4]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$i,$tipos[$row[10]-1]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$i,$estado);
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
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);  
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);    
$objPHPExcel->getActiveSheet()->setTitle('Recibo Caja');
$objPHPExcel->setActiveSheetIndex(0);

//----Guardar documento----
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Teso-Recaudo-Recibo-Caja.xls"');
header('Cache-Control: max-age=0');
 
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
$objWriter->save('php://output');
exit;

?>