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
            ->setCellValue('A1', 'Registros Presupuestales');

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
            ->setCellValue('A2', 'VIGENCIA')
            ->setCellValue('B2', 'RP')
            ->setCellValue('C2', 'CDP')
			->setCellValue('D2', 'OBJETO')
			->setCellValue('E2', 'DOCUMENTO')
			->setCellValue('F2', 'TERCERO')
            ->setCellValue('G2', 'VALOR')
            ->setCellValue('H2', 'FECHA')
            ->setCellValue('I2', 'ESTADO')
			->setCellValue('J2', 'SALDO A PAGAR')
			->setCellValue('K2', 'CONTRATO');

$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
$i=3;
$crit1='';
$crit2='';
$crit3='';
$crit4='';
$crit5='';
if ($_POST[vigencia]!=""){$crit1=" and pptorp.vigencia ='$_POST[vigencia]' ";}
if ($_POST[numero]!=""){$crit2=" and pptorp.consvigencia like '%$_POST[numero]%' ";}
if ($_POST[fechaini]!="" and $_POST[fechafin]!="" )
{	
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechaini],$fecha);
	$fechai=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechafin],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	$crit3=" and pptorp.fecha between '$fechai' and '$fechaf'  ";
}
$sqlr="select *from pptorp  where pptorp.estado<>'' $crit1 $crit2 $crit3 and pptorp.vigencia='$vigusu' order by pptorp.consvigencia";
$resp = mysql_query($sqlr,$linkbd);
$ntr = mysql_num_rows($resp);
while ($row =mysql_fetch_row($resp)) 
{
	$sqlr2="select pptocdp.objeto from pptocdp where pptocdp.consvigencia=$row[2] and pptocdp.vigencia=$row[0]";
	$resp2 = mysql_query($sqlr2,$linkbd);
	$r2 =mysql_fetch_row($resp2);
	$nrub=existecuentain($row[12]);
	$tercero=buscatercero($row[5]);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$i,$row[0]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,$row[1]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$i,$row[2]);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$i,utf8_encode($r2[0]));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$i,$row[5]);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$i,utf8_encode($tercero));
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$i,$row[6]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$i,$row[4]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$i,$row[3]);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$i,$row[7]);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10,$i,$row[8]);
	 $i+=1;
 }
//----Propiedades de la hoja
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true); 
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true); 
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true); 
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true); 
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);  
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);   
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);  
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);   
$objPHPExcel->getActiveSheet()->setTitle('Registros');
$objPHPExcel->setActiveSheetIndex(0);
//----Guardar documento----
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Registros Presupuestales.xlsx"');
header('Cache-Control: max-age=0');
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
$objWriter->save('php://output');
exit;

?>