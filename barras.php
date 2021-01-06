<?php //V 1000 12/12/16 ?> 
<?php  
#incluimos el fichero con las rutas y los include de las clases necesarias 
include 'tcpdf/config/lang/eng.php';
include 'tcpdf/tcpdf.php';
include 'tcpdf/barcode/barcode.php';
/* creamos un nuevo objeto y desactivamos la visualización de encabezados y pies de pagina 
activamos fullpage para que al abrir la pagina en el navegador si visualice entera */ 
$MiPDF = new TCPDF(); 
$MiPDF->setPrintHeader(false); 
$MiPDF->setPrintFooter(false); 
$MiPDF->SetDisplayMode('fullpage'); 
$MiPDF->SetFont('vera','',7); 
$estilo = array( 
    'border' => true, //colocará un borde 
    'padding'=>'auto',  //distancia entre borde y texto automatica 
    'hpadding' => 'auto', //distancia entre borde y texto automatica 
    'vpadding' => 'auto', //distancia entre borde y texto automatica 
    'fgcolor' => array(255,0,0), ///color de barras y texto 
    'bgcolor' =>array(255,255,0),  //color de fondo admitiria false para no asignar color 
    'text' => true, // incluye texto debajo de los codigod de barras 
    'font' => 'vera', 
    'fontsize' => 6, 
    'label'=>'', //etiqueta que reemplazará los textos  salvo que vaya vacio 
    'stretchtext'=>false, 
    'position'=>'N', //podria ser centrado, izquierda o derecha 
    'align' => 'R', //alinea respecto al rectangulo contenedor 
    'stretch' => false, 
    'fitwidth' => true, 
    'cellfitalign' => '', 
    'stretchtext' =>1 
); 
/* definimos un array con los diferentes tipos de codigos de barras */ 
$tipos=array('C39','C39+','C39E','C39E+','C93','S25','S25+','I25','I25+','C128A','C128B','EAN2','EAN5','EAN8','EAN13','UPCA','UPCE','MSI','MSI+','POSTNET','PLANET','RMS4CC','KIX','IMB','CODABAR','CODE11','PHARMA','PHARMA2T');
/* definimos un array con descripciones de los tipos anteriores */ 
$descripcion=array('CODE 39 - ANSI MH10.8M-1983 - USD-3','CODE 39 + checksum','CODE 39 EXTENDED', 'CODE 39 EXTENDED + checksum', 'CODE 93 - USS-93','Standard 2 of 5','Standard 2 of 5 + checksum','Interleaved 2 of 5','Interleaved 2 of 5 + checksum','CODE 128 A','CODE 128 B','2-Digits UPC-Based Extention','5-Digits UPC-Based Extention','EAN8','EAN13','UPC-A','UPC-E','MSI (Variation of Plessey code)', 'MSI (Variation of Plessey code)   checksum','POSTNET','PLANET','RMS4CC (Royal Mail 4-state Customer Code)','KIX (Klant index - Customer index)','IMB - Intelligent Mail Barcode - USPS-B-3200','CODABAR','CODE 11','PHARMACODE','PHARMACODE TWO-TRACKS'); 
/* definimos un array con valores adaptados a los diferentes tipos de codigo. De esta forma puede comprobarse si admiten solo numeros, numeros y letras, una dimensión limitada, etc */ 

$valores=array('A33EC003482+','A33EC003482-','A33EC003482%','ANTONIO ALONSO','Alejandro 32 + Ramon 17','0123456789','0123456789','0123456789','0123456789','234560123456789','234560123456789','12','12345','1234567','123456789012','123456789012','123456789012','123456789012345','330061234','3300612345','123456789012345','123456789012345','KIXCODE123456','Codigo INTEL.IGENTE 1234 5678','0123456789-.:/$+','0123456789-123','578945','12345678901234'); 

$MiPDF->AddPage(); 
/* establecemos un bucle para que escriba y posicione cada uno de los tipos de código de barras */ 
for ($i=0;$i<sizeof($tipos);$i++){ 
  $MiPDF->SetXY(55*($i % 3)+15,(int)($i/3)*24 +15); 
   $MiPDF->Cell(45, 5,$descripcion[$i] ,0,0,'C'); 
    $MiPDF->write1DBarcode($valores[$i],$tipos[$i],55*($i % 3)+18,(int)($i/3)*24 +20,50,14,'',$estilo); 
  //  $MiPDF->writeBarcode($valores[$i],$tipos[$i],55*($i % 3)+18,(int)($i/3)*24 +20,50,14,'',$estilo); 
	//$MiPDF->writeBarcode($MiPDF->GetX(), $MiPDF->GetY(), 100, 15, "I25", $barcode_style, false, 2, $valores[$i]);
  } 
$MiPDF->Output();
?>