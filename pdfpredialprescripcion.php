<?php
// V 1001 21/12/16 
require('fpdf.php');
require('comun.inc');
session_start();
   date_default_timezone_set("America/Bogota");
//*****las variables con los contenidos***********
//**********pdf*******
//$pdf=new FPDF('P','mm','Letter'); 
class PDF extends FPDF
{

//Cabecera de página
function Header()
{	
$linkbd=conectar_bd();
$sqlr="select *from configbasica where estado='S'";
//echo $sqlr;
$res=mysql_query($sqlr,$linkbd);
while($row=mysql_fetch_row($res))
 {
  $nit=$row[0];
  $rs=$row[1];
 }
     //Parte Izquierda
    $this->Image('imagenes/eng.jpg',23,10,25,25);
	$this->SetFont('Arial','B',10);
	$this->SetY(10);
	$this->RoundedRect(10, 10, 199, 31, 2.5,'' );
	$this->Cell(0.1);
    $this->Cell(50,31,'','R',0,'L'); 
	$this->SetY(31);
    $this->Cell(0.1);
    $this->Cell(50,5,''.$rs,0,0,'C'); 
	$this->SetFont('Arial','B',8);
	$this->SetY(35);
    $this->Cell(0.1);
    $this->Cell(50,5,''.$nit,0,0,'C'); //Cuadro Izquierda
	

	
    //*****************************************************************************************************************************
	$this->SetFont('Arial','B',14);
	$this->SetY(10);
    $this->Cell(50.1);
    $this->Cell(149,31,'',0,1,'C'); 


	$this->SetY(8);
    $this->Cell(50.1);
    $this->Cell(149,20,'PRESCRIPCIONES IMPUESTO PREDIAL',0,0,'C'); 
	//************************************
    $this->SetFont('Arial','B',10);
	
	$this->SetY(27);
	$this->Cell(50.2);
	$this->multiCell(110.7,7,'PRESCRIPCION PREDIO: '.$_POST[codcat],'T','L');
	
	$this->SetY(27);
    $this->Cell(161.1);
	$this->Cell(37.8,14,'','TL',0,'L');
	
	$this->SetY(28.5);
    $this->Cell(161);
	$this->Cell(38,5,'NUMERO','B',0,'C');
	
	$this->SetY(34.5);
    $this->Cell(161);
	$this->Cell(38,5,''.$_POST[idpres],'0',0,'C');
	
	//$this->SetY(35.5);
    //$this->Cell(162);
	//$this->Cell(35,5,'FECHA: '.$_POST[fecha],0,0,'L');

	$this->SetY(27);
	$this->Cell(50.2);

	$this->MultiCell(105.7,4,'',0,'L');		
//********************************************************************************************************************************
//	$this->line(10.1,42,209,42);
//	$this->RoundedRect(10,42.7, 199, 4, 1.2,'' );
	$this->SetFont('times','B',10);
				$this->ln(2);
			
//************************	***********************************************************************************************************
}
//Pie de página
function Footer()
{


    $this->SetY(-15);
	$this->SetFont('Arial','I',10);
	$this->Cell(0,10,'Pagina '.$this->PageNo().' de {nb}',0,0,'R'); // el parametro {nb} 
	
	
}
}

//Creación del objeto de la clase heredada
//$pdf=new PDF('P','mm',array(210,140));
$pdf=new PDF('P','mm','Letter'); 
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Times','',10);


$pdf->SetAutoPageBreak(true,20);

	$pdf->SetFont('times','B',9);
	$pdf->SetY(43.7);
    $pdf->Cell(0.1);
	$pdf->Cell(33,4,'FECHA IMPRESION:','B',1,'L'); 
	
	$pdf->SetFont('times','',9);
	$pdf->SetY(43.7);
    $pdf->Cell(33.1);
	$pdf->Cell(67,4,''.$_POST[fecha],'B',1,'L'); 

	$pdf->SetFont('times','B',9);
	$pdf->SetY(43.7);
   	$pdf->Cell(100.1);
	$pdf->Cell(27,4,'No RESOLUCION: ','LB',1,'L');

	$pdf->SetFont('times','',9);
	$pdf->SetY(43.7);
    $pdf->Cell(127.1);
	$pdf->Cell(72,4,' '.$_POST[nresol],'B',1,'L'); 
	
	$pdf->SetFont('times','B',9);
	$pdf->SetY(47.7);
    $pdf->Cell(0.1);
	$pdf->Cell(33,4,'PROPIETARIO:','B',1,'L'); 
	
	$pdf->SetFont('times','',9);
	$pdf->SetY(47.7);
    $pdf->Cell(27.1);
	$pdf->Cell(73,4,''.substr(strtoupper($_POST[propietario]),0,80),'B',1,'L'); 

	$pdf->SetFont('times','B',9);
	$pdf->SetY(47.7);
   	$pdf->Cell(100.1);
	$pdf->Cell(27,4,'DIRECCION:','LB',1,'L');

	$pdf->SetFont('times','',9);
	$pdf->SetY(47.7);
    $pdf->Cell(122.1);
	$pdf->Cell(77,4,''.substr(strtoupper($_POST[direccion]),0,80),'B',1,'L'); 
		
	$pdf->SetFont('times','B',9);
	$pdf->SetY(51.7);
    $pdf->Cell(0.1);
	$pdf->Cell(38,4,'CEDULA CIUDADANIA:','B',1,'L'); 
	
	$pdf->SetFont('times','',9);
	$pdf->SetY(51.7);
    $pdf->Cell(38.1);
	$pdf->Cell(62,4,''.$_POST[documento],'B',1,'L'); 

	$pdf->SetFont('times','B',9);
	$pdf->SetY(51.7);
   	$pdf->Cell(100.1);
	$pdf->Cell(27,4,'VEREDA:','LB',1,'L');

	$pdf->SetFont('times','',9);
	$pdf->SetY(51.7);
    $pdf->Cell(117.1);
	$pdf->Cell(82,4,''.$_POST[vereda],'B',1,'L'); 
	
	$pdf->SetFont('times','B',9);
	$pdf->SetY(55.7);
    $pdf->Cell(0.1);
	$pdf->Cell(36.7,4,'CEDULA CATASTRAL:','B',1,'L'); 
	
	$pdf->SetFont('times','',9);
	$pdf->SetY(55.7);
    $pdf->Cell(37.1);
	$pdf->Cell(63,4,''.$_POST[catastral],'B',1,'L'); 

	$pdf->SetFont('times','B',9);
	$pdf->SetY(55.7);
   	$pdf->Cell(100.1);
	$pdf->Cell(12,4,'HA:','LB',1,'L');

	$pdf->SetFont('times','',9);
	$pdf->SetY(55.7);
    $pdf->Cell(112.1);
	$pdf->Cell(20,4,''.$_POST[ha],'B',1,'L'); 
	
	$pdf->SetFont('times','B',9);
	$pdf->SetY(55.7);
   	$pdf->Cell(132.1);
	$pdf->Cell(8,4,'M2:','LB',1,'L');

	$pdf->SetFont('times','',9);
	$pdf->SetY(55.7);
    $pdf->Cell(140.1);
	$pdf->Cell(15,4,''.$_POST[mt2],'B',1,'L'); 
	
	$pdf->SetFont('times','B',9);
	$pdf->SetY(55.7);
   	$pdf->Cell(155.1);
	$pdf->Cell(8,4,'AC:','LB',1,'L');

	$pdf->SetFont('times','',9);
	$pdf->SetY(55.7);
    $pdf->Cell(163.1);
	$pdf->Cell(36,4,''.$_POST[areac],'B',1,'L'); 
	
		$pdf->SetFont('times','B',9);
	$pdf->SetY(59.7);
   	$pdf->Cell(100.1);
	$pdf->Cell(8,4,'Tipo:','L',0,'L');
if($_POST[tipop]=='urbano')
 {
  $_POST[nestrato]=$_POST[nestrato];
 }
if($_POST[tipop]=='rural')
 {
   $_POST[nestrato]=$_POST[nrango];
 }

	$pdf->SetFont('times','',9);
	$pdf->SetY(59.7);
    $pdf->Cell(108.1);
	$pdf->Cell(24,4,''.$_POST[tipop],'',0,'L'); 
	
	$pdf->SetFont('times','B',9);
	$pdf->SetY(59.7);
   	$pdf->Cell(132.1);
	$pdf->Cell(8,4,'Estrato:','L',0,'L');

	$pdf->SetFont('times','',9);
	$pdf->SetY(59.7);
    $pdf->Cell(145.1);
	$pdf->Cell(75,4,''.substr($_POST[nestrato],0,40),'',0,'L'); 
	
	$pdf->SetFont('times','B',9);
	$pdf->SetY(69.7);
	$pdf->SetFillColor(220,220,220);
	$pdf->Cell(199,4,'LIQUIDACION IMPUESTO PREDIAL','B',0,'C',1);	
	$pdf->SetY(73.7); 	
	$pdf->Cell(20,4,'A'.utf8_decode('Ñ').'O','BR',0,'C');
	$pdf->Cell(35,4,'AVALUO','LBR',0,'C');
	$pdf->Cell(144,4,'DESCRIPCION','LBR',0,'C');
	$pdf->SetY(77.7);
	for($x=0;$x<count($_POST[pvigencias]);$x++)
	 {	
	//$interes=$_POST[dinteres1][$cont]+$_POST[dipredial][$cont];
	$pdf->Cell(20,4,''.$_POST[pvigencias][$x],'BR',0,'C');
	$pdf->Cell(35,4,''.number_format($_POST[pavaluo][$x],2),'LBR',0,'C');
	$pdf->Cell(144,4,'VIGENCIA PRESCRITA','LB',1,'C');
	}
	 	$cont=0;
while($cont<(6-count($_POST[pvigencias])))
 {
	$pdf->Cell(20,4,'---','BR',0,'C');
	 $pdf->Cell(35,4,'---','LBR',0,'C');
	 $pdf->Cell(144,4,'---','LB',1,'C');	 
		   	$cont=$cont +1;
 }
			
	$pdf->ln(6);
			
	$y=$pdf->GetY();		
		
	$pdf->RoundedRect(10, 43, 199, $y-87, 1.2,'' );
	$y=$pdf->GetY();	
	$pdf->RoundedRect(10, 69, 199, $y-69, 1.2,'' );
$pdf->SetFont('times','B',9);
	$pdf->ln(20);
	$pdf->SetFont('times','B',9);
	$pdf->Cell(50);
	$pdf->Cell(80,4,''.strtoupper($_POST[tesorero]),'T',1,'C');
	$pdf->Cell(50);
	$pdf->Cell(80,4,'JEFE TESORERIA','',1,'C');

$pdf->ln(20);
	$pdf->Cell(50);
	$pdf->SetFont('times','B',9);
	$pdf->Cell(80,4,''.strtoupper($_SESSION[usuario]),'T',1,'C');
	$pdf->Cell(50);
	$pdf->SetFont('times','B',9);
	$pdf->Cell(80,4,'ELABORO','',1,'C');
$pdf->Output();
?> 


