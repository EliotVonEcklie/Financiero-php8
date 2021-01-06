<?php  
require_once 'PHPExcel/Classes/PHPExcel.php';
require"comun.inc";
require"funciones.inc";
session_start();
$linkbd=conectar_bd();  
$objPHPExcel = new PHPExcel();
$borders = array(
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN,
          'color' => array('argb' => 'FF000000'),
        )
      ),
    );

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
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Detalle Registro Presupuestal');
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
            ->setCellValue('B2', 'Nombre Cuenta')
            ->setCellValue('C2', 'Recurso')
            ->setCellValue('D2', 'Valor')
			->setCellValue('E2', 'Saldo');
$objPHPExcel->getActiveSheet()->getStyle("A2:E2")->applyFromArray($borders);
$i=3;
$sumauno=$sumados=0;
for ($x=0;$x<count($_POST[drcuentas]);$x++)
{		
	$filbor="A".$i.":E".$i;
	$objPHPExcel-> getActiveSheet ()
	-> getStyle ($filbor)
	-> getFont ()
	-> setBold ( false ) 
	-> setName ('Arial') 
	-> setSize ( 10 ) 
	-> getColor ()
	-> setRGB ('000000');
	$objPHPExcel->getActiveSheet()->getStyle($filbor)->applyFromArray($borders);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$i,$_POST[drcuentas][$x]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,utf8_encode($_POST[drncuentas][$x]));
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$i,$_POST[drrecursos][$x]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$i,$_POST[drvalores][$x]);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$i,$_POST[drsaldos][$x]);
	$sumauno=$sumauno+$_POST[drvalores][$x];
	$sumados=$sumados+$_POST[drsaldos][$x];
    $i+=1;	
}
$objPHPExcel->getActiveSheet()->getStyle($filbor)->applyFromArray($borders);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$i,"TOTAL");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$i,$sumauno);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$i,$sumados);
//----Propiedades de la hoja
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true); 
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true); 
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true); 
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true); 
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true); 
$objPHPExcel->getActiveSheet()->setTitle('Detalle Registro Presupuestal');
$objPHPExcel->createSheet(1);
$objPHPExcel->setActiveSheetIndex(1);
$objPHPExcel->getActiveSheet()->mergeCells('A1:H1');
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Detalle Orden de Pago');
$objFont=$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont();
$objFont->setName('Courier New'); 
$objFont->setSize(15); 
$objFont->setBold(true); 
$objFont->setUnderline(PHPExcel_Style_Font::UNDERLINE_SINGLE);
$objFont->getColor()->setARGB( PHPExcel_Style_Color::COLOR_BLACK);
$objAlign=$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment(); 
$objAlign->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
$objAlign->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
$objPHPExcel->getActiveSheet()
            ->setCellValue('A2', 'No - Tipo')
            ->setCellValue('B2', 'Nit')
            ->setCellValue('C2', 'Tercero')
            ->setCellValue('D2', 'CC')
			->setCellValue('E2', 'Item')
			->setCellValue('F2', 'Cuenta Presupuestal')
			->setCellValue('G2', 'Valor')
			->setCellValue('H2', 'Estado');
	
$objPHPExcel->getActiveSheet()->getStyle("A2:H2")->applyFromArray($borders);
$i=3;
for ($x=0;$x<count($_POST[tdet]);$x++)
{		
	if($_POST[pagodetalle][$x]=="P"){$estapago="PAGO";}
	else{$estapago="ACTIVO";}
	$filbor="A".$i.":H".$i;
	$objPHPExcel-> getActiveSheet ()
	-> getStyle ($filbor)
	-> getFont ()
	-> setBold ( false ) 
	-> setName ('Arial') 
	-> setSize ( 10 ) 
	-> getColor ()
	-> setRGB ('000000');
	$objPHPExcel->getActiveSheet()->getStyle($filbor)->applyFromArray($borders);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$i,($x+1)." ".$_POST[tdet][$x]);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,$_POST[dcuentas][$x]);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$i,utf8_encode($_POST[dncuentas][$x]));
	$objPHPExcel->getActiveSheet()->setCellValueExplicit ("D".$i, $_POST[dccs][$x], PHPExcel_Cell_DataType :: TYPE_STRING);
   	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$i,utf8_encode($_POST[nomdetalle][$x]));
	$objPHPExcel->getActiveSheet()->setCellValueExplicit ("F".$i, $_POST[drecursos][$x], PHPExcel_Cell_DataType :: TYPE_STRING);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$i,$_POST[dvalores][$x]);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$i,$estapago);
    $i+=1;	
}		
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true); 
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true); 
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true); 
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true); 
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true); 
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setTitle('Detalle Orden de Pago');		
$objPHPExcel->setActiveSheetIndex(0);

//----Guardar documento----
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="PagoNomina.xls"');
header('Cache-Control: max-age=0');
 
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
$objWriter->save('php://output');
exit;

?>