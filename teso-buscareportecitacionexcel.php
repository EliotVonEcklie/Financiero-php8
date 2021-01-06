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
$objPHPExcel->getActiveSheet()->mergeCells('A1:E1');
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Liquidacion Predial');

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
            ->setCellValue('A2', 'Vigencia')
            ->setCellValue('B2', 'Codigo Catastral')
            ->setCellValue('C2', 'Predial')
            //->setCellValue('D2', 'intereses')
            //->setCellValue('E2', 'Sobretasa bombe')
			//->setCellValue('F2', 'Intereses')
            //->setCellValue('G2', 'Sobretasa Amb')
            //->setCellValue('H2', 'Intereses')
            //->setCellValue('I2', 'Descuentos')
            ->setCellValue('D2', 'Valor total')
			->setCellValue('E2', 'Dias mora');
			
$linkbd=conectar_bd();
$dvigencias=array();
$dcodcatas=array();
$dpredial=array();
$dipredial=array();
$dimpuesto1=array();
$dinteres1=array();
$dimpuesto2=array();
$dinteres2=array();
$ddescuentos=array();
$dtasavig=array();
$dvaloravaluo=array();

if ($_POST[nombre]!="")
			$crit1="and codcatastral LIKE '%$_POST[nombre]%'";
	if($_POST[liquidacionn]!=""){
			$crit2="and idconsulta='$_POST[liquidacionn]'";
		}
$sql="SELECT *FROM tesoreportecitacion";
$result = mysql_query($sql,$linkbd);
$i=3;
while($row=mysql_fetch_array($result)){
	$sqlr1="select sum(valortotal) from tesocobroreporte where numresolucion='$row[1]'";
	$resp1 = mysql_query($sqlr1,$linkbd);
	$row1=mysql_fetch_row($resp1);
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValueExplicit ("A".$i, $row[0]."-".$row[1], PHPExcel_Cell_DataType :: TYPE_STRING)
	->setCellValueExplicit ("B".$i, $row[2], PHPExcel_Cell_DataType :: TYPE_STRING)
	->setCellValueExplicit ("C".$i, $row[3], PHPExcel_Cell_DataType :: TYPE_STRING)
	//->setCellValueExplicit ("D".$i, $row[5], PHPExcel_Cell_DataType :: TYPE_STRING)
	//->setCellValueExplicit ("E".$i, $row[6], PHPExcel_Cell_DataType :: TYPE_STRING)
	//->setCellValueExplicit ("F".$i, $row[7], PHPExcel_Cell_DataType :: TYPE_STRING)
	//->setCellValueExplicit ("G".$i, $row[8], PHPExcel_Cell_DataType :: TYPE_STRING)
	//->setCellValueExplicit ("H".$i, $row[9], PHPExcel_Cell_DataType :: TYPE_STRING)
	//->setCellValueExplicit ("I".$i, $row[10], PHPExcel_Cell_DataType :: TYPE_STRING)
	->setCellValueExplicit ("D".$i, $row[4], PHPExcel_Cell_DataType :: TYPE_STRING)
	->setCellValueExplicit ("E".$i, $row[5], PHPExcel_Cell_DataType :: TYPE_STRING);
	
$i++;
}
//----Propiedades de la hoja

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true); 
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true); 
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true); 
//$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true); 
//$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true); 
//$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true); 
//$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true); 
//$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true); 
//$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true); 
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true); 
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true); 
$objPHPExcel->getActiveSheet()->setTitle('Teso-Predial');
$objPHPExcel->setActiveSheetIndex(0);


//----Guardar documento----
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Teso-Predial.xls"');
header('Cache-Control: max-age=0');
 
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
$objWriter->save('php://output');
exit;

?>