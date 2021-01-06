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
        ->setSubject("Reporte Gestion de Inventario")
        ->setDescription("Reporte Gestion de Inventario")
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
if($_POST[tip]=='1')
    $titulo=" - Entrada";
else
    $titulo=" - Salida";
$objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Reporte Gestion de Inventario'.$titulo);

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
$objPHPExcel-> getActiveSheet()->getColumnDimension('C')->setWidth(50);
$objPHPExcel-> getActiveSheet()->getColumnDimension('D')->setWidth(15);
$objPHPExcel-> getActiveSheet()-> getStyle('D')->getAlignment()-> applyFromArray (array ( 'horizontal'  =>  PHPExcel_Style_Alignment :: VERTICAL_JUSTIFY ,) );
$objPHPExcel-> getActiveSheet()->getColumnDimension('E')->setWidth(20);
$objPHPExcel-> getActiveSheet()->getColumnDimension('F')->setWidth(20);
$objPHPExcel-> getActiveSheet()->getColumnDimension('G')->setWidth(20);
$objWorksheet = $objPHPExcel->getActiveSheet();
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A2', 'Codigo UNSPSC')
            ->setCellValue('B2', 'Codigo Articulo')
            ->setCellValue('C2', 'Nombre del Articulo')
            ->setCellValue('D2','Cantidad')
            ->setCellValue('E2', 'U. Medida')
            ->setCellValue('F2', 'Vr.Unitario')
            ->setCellValue('G2', 'Vr.Total');


$i=3;
$tot=0;
for($x=0;$x<count($_POST[codunsd]);$x++)
{               
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$i,$_POST[codunsd][$x]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,$_POST[codinard][$x]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$i,iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[nomartd][$x]));
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$i,$_POST[cantidadd][$x]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$i,$_POST[unidadd][$x]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$i,$_POST[valunit][$x]);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$i,$_POST[valtotal][$x]);
    
    //$objPHPExcel->getActiveSheet()->getStyle("A$i:P$i")->applyFromArray($borders);
    $objPHPExcel->getActiveSheet()->getStyle("A$i:G$i")->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,));
    $objPHPExcel->getActiveSheet()->getStyle("F$i")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
    $i+=1;
    $tot=$tot+$_POST[valtotal][$x];
}
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$i,'Total: ');
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$i,$tot);
$objPHPExcel->getActiveSheet()->getStyle("F$i")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
$objPHPExcel-> getActiveSheet ()
        -> getStyle ("F$i")
        -> getFill ()
        -> setFillType (PHPExcel_Style_Fill :: FILL_SOLID)
        -> getStartColor ()
        -> setRGB ('C8C8C8');


    
              
            
//----Propiedades de la hoja

//$objPHPExcel->getActiveSheet()->getStyle("A$i:P$i")->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,));
$objPHPExcel->getActiveSheet()->getStyle('A2:G2')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
$objPHPExcel->getActiveSheet()->setTitle('Gestion de inventario');
$objPHPExcel->setActiveSheetIndex(0);

//----Guardar documento----
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Gestion-invetario.xls"');
header('Cache-Control: max-age=0');
 
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
$objWriter->save('php://output');
exit;

?>