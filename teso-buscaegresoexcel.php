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
        ->setTitle("Exportar Excel con PHP")
        ->setSubject("Documento de prueba")
        ->setDescription("Documento generado con PHPExcel")
        ->setKeywords("usuarios phpexcel")
        ->setCategory("reportes");

//----Cuerpo de Documento----
$objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Cuentas por pagar');

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A2', 'Item')
            ->setCellValue('B2', 'Vigencia')
            ->setCellValue('C2', 'N RP')
            ->setCellValue('D2', 'Detalle')
            ->setCellValue('E2', 'Valor')
            ->setCellValue('F2', 'Fecha')
            ->setCellValue('G2', 'Estado');

            $fech1=split("/",$_POST[fecha]);
            $fech2=split("/",$_POST[fecha2]);
            $f1=$fech1[2]."-".$fech1[1]."-".$fech1[0];
            $f2=$fech2[2]."-".$fech2[1]."-".$fech2[0];
            if ($_POST[nombre]!="")
            $crit1="and concat_ws(' ', id_orden, conceptorden) LIKE '%$_POST[nombre]%'";
            if($_POST[fecha]!='')
                $crit=" and tesoordenpago.fecha BETWEEN '$f1' AND '$f2'";
            $sqlr="select * from tesoordenpago where tesoordenpago.id_orden>-1 ".$crit." ".$crit1." order by tesoordenpago.id_orden desc";
            $resp = mysql_query($sqlr,$linkbd);
$i=3;
while ($row =mysql_fetch_row($resp))
{
    if($row[13]=='S')
        $est="ACTIVO";
    elseif($row[13]=='N')
        $est="ANULADO";
    elseif($row[13]=='R')
        $est="REVERSADO";
    elseif($row[13]=='P')
        $est="PAGO";
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$i,$row[0]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,$row[3]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$i,$row[4]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$i,iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$row[7]));
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$i,$row[10]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$i,$row[2]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$i,$est);
        /*echo "<input name='iteme[]'  type='hidden'  value='$row[0]' >
                <input name='vigenciae[]'  type='hidden'  value='$row[3]' >
                <input name='nrpe[]'  type='hidden'  value='$row[4]' >
                <input name='detalee[]'  type='hidden'  value='$row[7]' >
                <input name='evalor[]'  type='hidden'  value='$row[10]' >
                <input name='efecha[]'  type='hidden'  value='$row[2]' >
                <input name='eestado[]'  type='hidden'  value='$row[13]' >";
        }*/
    $i+=1;
}
            
/*for( $i=0;$i<count($_POST[iteme]);$i++){
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$i+3,$_POST[iteme][$i]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i+3,$_POST[vigenciae][$i]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$i+3,$_POST[nrpe][$i]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$i+3,$_POST[detalee][$i]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$i+3,$_POST[evalor][$i]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$i+3,$_POST[efecha][$i]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$i+3,$_POST[eestado][$i]);

}*/
//----Propiedades de la hoja
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true); 
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true); 
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true); 
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true); 
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true); 
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);  
$objPHPExcel->getActiveSheet()->setTitle('Teso-Predial');
$objPHPExcel->setActiveSheetIndex(0);

//----Guardar documento----
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Teso-Cuentas-por-Pagar.xls"');
header('Cache-Control: max-age=0');
 
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
$objWriter->save('php://output');
exit;

?>