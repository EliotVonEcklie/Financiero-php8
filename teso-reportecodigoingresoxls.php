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
        ->setSubject("Reporte de Codigos Ingresos")
        ->setDescription("Reporte de Codigos Ingresos")
        ->setKeywords("Reporte")
        ->setCategory("reportes");
$objPHPExcel-> getActiveSheet ()
        -> getStyle ("A1")
        -> getFill ()
        -> setFillType (PHPExcel_Style_Fill :: FILL_SOLID)
        -> getStartColor ()
        -> setRGB ('C8C8C8');
$objPHPExcel-> getActiveSheet ()
        -> getStyle ("A2:G2")
        -> getFill ()
        -> setFillType (PHPExcel_Style_Fill :: FILL_SOLID)
        -> getStartColor ()
        -> setRGB ('A6E5F3');
//----Cuerpo de Documento----
$objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Reporte de Codigos Ingresos');

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
    $objPHPExcel->getActiveSheet()->getStyle('A2:G2')->applyFromArray($borders);

$objAlign=$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment(); 
$objAlign->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
$objAlign->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel-> getActiveSheet()->getColumnDimension('A')->setWidth(15);
$objPHPExcel-> getActiveSheet()->getColumnDimension('B')->setWidth(15);
$objPHPExcel-> getActiveSheet()->getColumnDimension('C')->setWidth(25);
$objPHPExcel-> getActiveSheet()->getColumnDimension('D')->setWidth(50);
$objPHPExcel-> getActiveSheet()-> getStyle('D')->getAlignment()-> applyFromArray (array ( 'horizontal'  =>  PHPExcel_Style_Alignment :: VERTICAL_JUSTIFY ,) );
$objPHPExcel-> getActiveSheet()->getColumnDimension('E')->setWidth(20);
$objPHPExcel-> getActiveSheet()->getColumnDimension('F')->setWidth(20);
$objPHPExcel-> getActiveSheet()->getColumnDimension('G')->setWidth(20);
$objWorksheet = $objPHPExcel->getActiveSheet();
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A2', 'Item')
            ->setCellValue('B2', 'N° Recibo')
            ->setCellValue('C2', 'Fecha')
            ->setCellValue('D2','Descripcion')
            ->setCellValue('E2', 'N° Liquidacion')
            ->setCellValue('F2', 'Valor')
            ->setCellValue('G2', 'Estado');


$i=3;

for($x=0;$x<count($_POST[item]);$x++)
{               
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$i,$_POST[item][$x]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,$_POST[id_recibos][$x]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$i,$_POST[fecha][$x]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$i,iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[descripcion][$x]));
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$i,$_POST[liquidacion][$x]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$i,$_POST[valor][$x]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$i,$_POST[estado][$x]);
    
    //$objPHPExcel->getActiveSheet()->getStyle("A$i:P$i")->applyFromArray($borders);
    $objPHPExcel->getActiveSheet()->getStyle("A$i:G$i")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,));
    $objPHPExcel->getActiveSheet()->getStyle("F$i")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
    $i+=1;
}
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$i,'Total: ');
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$i,$_POST[valtotal]);
$objPHPExcel->getActiveSheet()->getStyle("F$i")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
$objPHPExcel-> getActiveSheet ()
        -> getStyle ("E$i")
        -> getFill ()
        -> setFillType (PHPExcel_Style_Fill :: FILL_SOLID)
        -> getStartColor ()
        -> setRGB ('C8C8C8');


    
              
            
//----Propiedades de la hoja

//$objPHPExcel->getActiveSheet()->getStyle("A$i:P$i")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,));
$objPHPExcel->getActiveSheet()->getStyle('A2:G2')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
$objPHPExcel->getActiveSheet()->setTitle('Teso-Reporte-Ingresos');
$objPHPExcel->setActiveSheetIndex(0);

//----Guardar documento----
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Reporte-Cod-Ingresos.xls"');
header('Cache-Control: max-age=0');
 
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
$objWriter->save('php://output');
exit;

?>