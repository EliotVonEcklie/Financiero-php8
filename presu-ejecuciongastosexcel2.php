<?php  
require_once 'PHPExcel/Classes/PHPExcel.php';
include '/PHPExcel/Classes/PHPExcel/IOFactory.php';// PHPExcel_IOFactory
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
$objPHPExcel-> getActiveSheet ()
        -> getStyle ("A1")
        -> getFill ()
        -> setFillType (PHPExcel_Style_Fill :: FILL_SOLID)
        -> getStartColor ()
        -> setRGB ('C8C8C8');
$objPHPExcel-> getActiveSheet ()
		-> getStyle ("A2:P2")
        -> getFill ()
        -> setFillType (PHPExcel_Style_Fill :: FILL_SOLID)
        -> getStartColor ()
        -> setRGB ('A6E5F3');
//----Cuerpo de Documento----
$objPHPExcel->getActiveSheet()->mergeCells('A1:P1');
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Ejecucion Presupuestal de Gastos');

$objFont=$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont();
$objFont->setName('Courier New'); 
$objFont->setSize(15); 
$objFont->setBold(true); 
$objFont->setUnderline(PHPExcel_Style_Font::UNDERLINE_SINGLE);
$objFont->getColor()->setARGB( PHPExcel_Style_Color::COLOR_BLACK);
$borders = array(
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN,
          'color' => array('argb' => 'FF000000'),
        )
      ),
    );
	$objPHPExcel->getActiveSheet()->getStyle('A2:P2')->applyFromArray($borders);

$objAlign=$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment(); 
$objAlign->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
$objAlign->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel-> getActiveSheet()->getColumnDimension('A')->setWidth(15);
$objPHPExcel-> getActiveSheet()->getColumnDimension('B')->setWidth(35);
$objPHPExcel-> getActiveSheet()->getColumnDimension('C')->setWidth(50);
$objPHPExcel-> getActiveSheet()-> getStyle('B:C')->getAlignment()-> applyFromArray (array ( 'horizontal'  =>  PHPExcel_Style_Alignment :: VERTICAL_JUSTIFY ,) ); 
	$objPHPExcel-> getActiveSheet()->getColumnDimension('D')->setWidth(20);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('E')->setWidth(20);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('F')->setWidth(20);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('G')->setWidth(20);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('H')->setWidth(20);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('I')->setWidth(20);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('J')->setWidth(20);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('K')->setWidth(20);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('L')->setWidth(20);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('M')->setWidth(20);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('N')->setWidth(20);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('O')->setWidth(20);
	$objPHPExcel-> getActiveSheet()->getColumnDimension('P')->setWidth(20);
	$objWorksheet = $objPHPExcel->getActiveSheet();
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A2', 'Rubro')
            ->setCellValue('B2', 'Concepto')
			->setCellValue('C2','Fuente')
            ->setCellValue('D2', 'Presupuesto Inicial')
			->setCellValue('E2', 'Adiciones')
            ->setCellValue('F2', 'Reducciones')
			->setCellValue('G2','Creditos')
			->setCellValue('H2','Contra Creditos')
			->setCellValue('I2','Presupuesto Definitivo')
			->setCellValue('J2', 'Disponibilidad')
			->setCellValue('K2', 'Compromisos')
			->setCellValue('L2', 'Obligaciones')
			->setCellValue('M2','Compromisos en Ejecucion')
			->setCellValue('N2', 'Pagos')
			->setCellValue('O2','Cuentas por Pagar')
			->setCellValue('P2', 'Saldo');


$i=3;

for($x=0;$x<count($_POST[cuenta]);$x++)
{		 		
	
	if($_POST[tipo][$x]=='Mayor'){
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$i,$_POST[cuenta][$x]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,utf8_encode($_POST[nombre][$x]));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$i,$_POST[fuente][$x]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$i,$_POST[pid][$x]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$i,$_POST[adc][$x]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$i,$_POST[red][$x]);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$i,$_POST[cred][$x]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$i,$_POST[contra][$x]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$i,$_POST[ppto][$x]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$i,$_POST[cdpd][$x]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10,$i,$_POST[rpd][$x]);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11,$i,$_POST[cxpd][$x]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12,$i,$_POST[rpd][$x]-$_POST[cxpd][$x]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13,$i,$_POST[egd][$x]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14,$i,$_POST[cxpd][$x]-$_POST[egd][$x]);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15,$i,$_POST[ppto][$x]-$_POST[cdpd][$x]);
	
	//$objPHPExcel->getActiveSheet()->getStyle("A$i:P$i")->applyFromArray($borders);
	$objPHPExcel->getActiveSheet()->getStyle("A$i:P$i")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,));
	$objPHPExcel->getActiveSheet()->getStyle("D$i:P$i")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
	$objPHPExcel-> getActiveSheet ()-> getStyle ("A$i:L$i")-> getFont()-> setBold ( true );
	}else{
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$i,$_POST[cuenta][$x]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,utf8_encode($_POST[nombre][$x]));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$i,utf8_encode($_POST[fuente][$x]));
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$i,$_POST[pid][$x]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$i,$_POST[adc][$x]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$i,$_POST[red][$x]);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$i,$_POST[cred][$x]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$i,$_POST[contra][$x]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$i,$_POST[ppto][$x]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$i,$_POST[cdpd][$x]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10,$i,$_POST[rpd][$x]);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11,$i,$_POST[cxpd][$x]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12,$i,$_POST[rpd][$x]-$_POST[cxpd][$x]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13,$i,$_POST[egd][$x]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14,$i,$_POST[cxpd][$x]-$_POST[egd][$x]);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15,$i,$_POST[ppto][$x]-$_POST[cdpd][$x]);
	
	//$objPHPExcel->getActiveSheet()->getStyle("A$i:P$i")->applyFromArray($borders);
	$objPHPExcel->getActiveSheet()->getStyle("A$i:P$i")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,));
	$objPHPExcel->getActiveSheet()->getStyle("D$i:P$i")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
	}
	$i+=1;
}


    
              
            
//----Propiedades de la hoja

//$objPHPExcel->getActiveSheet()->getStyle("A$i:P$i")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,));
$objPHPExcel->getActiveSheet()->getStyle('A2:P2')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
$objPHPExcel->getActiveSheet()->setTitle('Teso-ArchM-Ingresos');
$objPHPExcel->setActiveSheetIndex(0);

//----Guardar documento----
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Ejecucionpresupuestal.xls"');
header('Cache-Control: max-age=0');
 
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
$objWriter->save('php://output');
exit;

?>