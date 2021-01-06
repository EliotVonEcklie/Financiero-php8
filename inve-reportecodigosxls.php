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
        ->setSubject("Reporte de Codigos almacen")
        ->setDescription("Reporte de Codigos almacen")
        ->setKeywords("Reporte")
        ->setCategory("reportes");
$objPHPExcel-> getActiveSheet ()
        -> getStyle ("A1")
        -> getFill ()
        -> setFillType (PHPExcel_Style_Fill :: FILL_SOLID)
        -> getStartColor ()
        -> setRGB ('C8C8C8');
$objPHPExcel-> getActiveSheet ()
        -> getStyle ("A2:E2")
        -> getFill ()
        -> setFillType (PHPExcel_Style_Fill :: FILL_SOLID)
        -> getStartColor ()
        -> setRGB ('A6E5F3');
//----Cuerpo de Documento----
$objPHPExcel->getActiveSheet()->mergeCells('A1:E1');
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Reporte de Codigos de Almacen');

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
    $objPHPExcel->getActiveSheet()->getStyle('A2:E2')->applyFromArray($borders);

$objAlign=$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment(); 
$objAlign->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
$objAlign->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel-> getActiveSheet()->getColumnDimension('A')->setWidth(15);
$objPHPExcel-> getActiveSheet()->getColumnDimension('B')->setWidth(15);
$objPHPExcel-> getActiveSheet()->getColumnDimension('C')->setWidth(25);
$objPHPExcel-> getActiveSheet()->getColumnDimension('D')->setWidth(50);
$objPHPExcel-> getActiveSheet()->getColumnDimension('E')->setWidth(20);
$objWorksheet = $objPHPExcel->getActiveSheet();
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A2', 'Codigo')
            ->setCellValue('B2', 'Nombre')
            ->setCellValue('C2', 'Codigo UNSP')
            ->setCellValue('D2','Grupo de inventario')
            ->setCellValue('E2', 'Estado');


$i=3;

for($x=0;$x<count($_POST[codigo]);$x++)
{               
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$i,$_POST[codigo][$x]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[nombre][$x]));
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$i,iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[codigounsp][$x]));
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$i,iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[grupo][$x]));
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$i,$_POST[estado][$x]);
    
    //$objPHPExcel->getActiveSheet()->getStyle("A$i:P$i")->applyFromArray($borders);
    $objPHPExcel->getActiveSheet()->getStyle("A$i:E$i")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,));
    $objPHPExcel->getActiveSheet()->getStyle("F$i")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
    $i+=1;
}

            
//----Propiedades de la hoja

//$objPHPExcel->getActiveSheet()->getStyle("A$i:P$i")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,));
$objPHPExcel->getActiveSheet()->getStyle('A2:E2')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
$objPHPExcel->getActiveSheet()->setTitle('Teso-Reporte-Codigos');
$objPHPExcel->setActiveSheetIndex(0);

//----Guardar documento----
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Reporte-Cod-Codigos.xls"');
header('Cache-Control: max-age=0');
 
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
$objWriter->save('php://output');
exit;

?>