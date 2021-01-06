<?php
require_once 'PHPExcel/Classes/PHPExcel.php';
require"comun.inc";
require"funciones.inc";
require"validaciones.inc";
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
$objPHPExcel->getActiveSheet()->mergeCells('A1:H1');
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
$objPHPExcel-> getActiveSheet ()
		-> getStyle ("A2:H2")	
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
$objPHPExcel->getActiveSheet()->getStyle('A2:H2')->applyFromArray($borders);
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A2', 'Vigencia')
            ->setCellValue('B2', 'No RP')
			->setCellValue('C2', 'No CDP')
            ->setCellValue('D2', 'Objeto')
            ->setCellValue('E2', 'Valor')
            ->setCellValue('F2', 'Fecha')
            ->setCellValue('G2', 'Estado')
            ->setCellValue('H2', 'Saldo');
$crit1=" ";
$crit2=" ";
$crit3=" ";
$vig=vigencia_usuarios($_SESSION[cedulausu]);
if ($_POST[vigencia]!=""){$crit1=" AND TB1.vigencia ='$_POST[vigencia]' ";}
else {$crit1=" AND TB1.vigencia ='$vig' ";}
if ($_POST[numero]!=""){$crit2=" AND TB1.consvigencia like '%$_POST[numero]%' ";}
if ($_POST[fechaini]!="" and $_POST[fechafin]!="" )
{	
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechaini],$fecha);
	$fechai=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechafin],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	$crit3=" AND TB1.fecha between '$fechai' and '$fechaf'  ";
}
$sqlr="SELECT TB1.* FROM pptorp TB1 WHERE TB1.estado<>'' $crit1 $crit2 $crit3 ORDER BY TB1.consvigencia";
$resp = mysql_query($sqlr,$linkbd);
$i=3;
while ($row =mysql_fetch_row($resp))
{
	switch ($row[3]) 
	{
		case "S":	$estado="Activo";break;
		case "N":	$estado="Activo";break;
		case "C":	$estado="Completo";break;
		case "R":	$estado="Reversado";break;
		case "PR":	$estado="Reversado Parcial";break;
    }
    $saldo = generaSaldoRP($row[1],$row[0]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$i,$row[0]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,$row[1]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$i,$row[2]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$i,utf8_encode($row[11]));
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$i,(float)$row[6]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$i,date('d-m-Y',strtotime($row[4])));
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$i,$estado);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$i,$saldo);
	$objPHPExcel->getActiveSheet()->getStyle("A$i:H$i")->applyFromArray($borders);
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
$objPHPExcel->getActiveSheet()->setTitle('RP');
$objPHPExcel->setActiveSheetIndex(0);

//----Guardar documento----
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="presu-rp.xls"');
header('Cache-Control: max-age=0');
 
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
$objWriter->save('php://output');
exit;

?>