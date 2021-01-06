<?php
//V 1000 12/12/16 
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
  $nalca=$row[6];
 }

 
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
    $this->Cell(149,20,'COMPROBANTE DE TRASLADO',0,1,'C'); 
	//************************************
    $this->SetFont('Arial','I',8);
	
	$this->SetY(27);
	$this->Cell(50.2); 
	$this->multiCell(110.7,4,'','T','C');
	$this->SetFont('Arial','B',10);
	$this->SetY(27);
	if($_POST[estado][0]=='R')
	{
		$this->Cell(230,15,'DOCUMENTO DE REVERSO',0,0,'C');
	}
	else
	{
		$this->Cell(230,15,'ACTIVO',0,0,'C');
	}
	$this->SetY(27);
	$this->SetX(171);
	$this->Cell(37.8,14,'','TL',0,'R');
	$this->SetY(27);
    $this->Cell(162);
	$this->Cell(35,5,"NUMERO : $_POST[idcomp]",0,0,'L');
	$this->SetY(31);
    $this->Cell(162);
	$this->Cell(35,5,"FECHA: $_POST[fecha]",0,0,'L');
	$this->SetY(35);
    $this->Cell(162);
	$this->Cell(35,5,"VIGENCIA: $_POST[vigencia]",0,0,'L');

	$this->SetY(27);
	$this->Cell(50.2);

	$this->MultiCell(105.7,4,'',0,'L');		
	

	
//********************************************************************************************************************************


	$this->SetFont('times','B',10);
				$this->ln(12);
			
//************************	***********************************************************************************************************
}
//Pie de página
function Footer()
{
    $this->SetY(-15);
	$this->SetFont('Arial','I',10);
	$this->Cell(0,10,'Impreso por: Software SPID - G&C Tecnoinversiones SAS. - Pagina '.$this->PageNo().' de {nb}',0,0,'R'); // el parametro {nb} 	
}
}

$pdf=new PDF('P','mm','Letter'); 
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',10);
$pdf->SetAutoPageBreak(true,20);

$pdf->ln(8);

$pdf->cell(0.2);
$pdf->SetFillColor(220, 220, 220);
$pdf->SetFont('Arial','B',10);
$pdf->cell(199,5,'DETALLE',0,1,'C',1);
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->cell(55.2,5,'Concepto de traslado general: ','T',0,'L',1);
$pdf->SetFont('Arial','',10);
$pdf->cell(143.5,5,''.substr(ucwords(strtolower($_POST[conceptogral])),0,100),'TL',1,'L',1);
$pdf->cell(0.2);  
$pdf->SetFont('Arial','B',10);
$pdf->cell(55,5,'Tipo Traslado:','T',0,'L',1);
$pdf->SetFont('Arial','',10);
$pdf->cell(143.5,5,$_POST[tipotras],'TL',1,'L',1);
$pdf->SetFont('Arial','B',10);
$pdf->cell(55.2,5,'Placa Activo:','T',0,'L',1);
$pdf->SetFont('Arial','',10);
$pdf->cell(143.5,5,$_POST[numero],'TL',1,'L',1);
$pdf->cell(0.2);
$pdf->SetFont('Arial','B',10);
$pdf->cell(55,5,'Descripcion Activo:','T',0,'L',1);
$pdf->SetFont('Arial','',10);
$pdf->cell(143.5,5,$_POST[nactivo],'TL',1,'L',1);
$pdf->RoundedRect(10, 51 ,199 , 25, 2,'' );

$pdf->ln(2);
$pdf->SetFillColor(220, 220, 220);
$pdf->SetFont('Arial','B',10);
$pdf->cell(199,5,'ORIGEN',0,1,'C',1);
$pdf->SetFillColor(255, 255, 255);
$pdf->SetFont('Arial','B',10);
$pdf->cell(55.2,5,'Centro Costos Origen:','T',0,'L',1);
$pdf->SetFont('Arial','',10);
$pdf->cell(143.5,5,$_POST[cc],'TL',1,'L',1);
$pdf->SetFont('Arial','B',10);
$pdf->cell(55.2,5,'Dependencia Origen:','T',0,'L',1);
$pdf->SetFont('Arial','',10);
$pdf->cell(143.5,5,$_POST[area],'TL',1,'L',1);
$pdf->SetFont('Arial','B',10);
$pdf->cell(55.2,5,'Ubicacion Origen:','T',0,'L',1);
$pdf->SetFont('Arial','',10);
$pdf->cell(143.5,5,$_POST[ubicacion],'TL',1,'L',1);
$pdf->SetFont('Arial','B',10);
$pdf->cell(55.2,5,'Prototipo Origen:','T',0,'L',1);
$pdf->SetFont('Arial','',10);
$pdf->cell(143.5,5,$_POST[prototipo],'TL',1,'L',1);
$pdf->SetFont('Arial','B',10);
$pdf->cell(55.2,5,'Disposicion Origen:','T',0,'L',1);
$pdf->SetFont('Arial','',10);
$pdf->cell(143.5,5,$_POST[dispoactivo],'TL',1,'L',1);
$pdf->RoundedRect(10, 78 ,199 , 30, 2,'' );

$pdf->ln(2);
$pdf->SetFillColor(220, 220, 220);
$pdf->SetFont('Arial','B',10);
$pdf->cell(199,5,'DESTINO',0,1,'C',1);
$pdf->SetFillColor(255, 255, 255);
$pdf->SetFont('Arial','B',10);
$pdf->cell(55.2,5,'Centro Costos Destino:','T',0,'L',1);
$pdf->SetFont('Arial','',10);
$pdf->cell(143.5,5,$_POST[cc2],'TL',1,'L',1);
$pdf->SetFont('Arial','B',10);
$pdf->cell(55.2,5,'Dependencia Destino:','T',0,'L',1);
$pdf->SetFont('Arial','',10);
$pdf->cell(143.5,5,$_POST[area2],'TL',1,'L',1);
$pdf->SetFont('Arial','B',10);
$pdf->cell(55.2,5,'Ubicacion Destino:','T',0,'L',1);
$pdf->SetFont('Arial','',10);
$pdf->cell(143.5,5,$_POST[ubicacion2],'TL',1,'L',1);
$pdf->SetFont('Arial','B',10);
$pdf->cell(55.2,5,'Prototipo Destino:','T',0,'L',1);
$pdf->SetFont('Arial','',10);
$pdf->cell(143.5,5,$_POST[prototipo2],'TL',1,'L',1);
$pdf->SetFont('Arial','B',10);
$pdf->cell(55.2,5,'Disposicion Destino:','T',0,'L',1);
$pdf->SetFont('Arial','',10);
$pdf->cell(143.5,5,$_POST[dispoactivo2],'TL',1,'L',1);
$pdf->RoundedRect(10, 110 ,199 , 30, 2,'' );

$pdf->ln(2);
$pdf->SetFillColor(220, 220, 220);
$pdf->SetFont('Arial','B',10);
$pdf->cell(199,5,'CONCEPTO DE TRASLADO ACTIVO',0,1,'C',1);
$pdf->SetFillColor(255, 255, 255);
$pdf->SetFont('Arial','',10);
$pdf->cell(199,5,$_POST[concepto],'T',1,'L',1);
$pdf->RoundedRect(10, 142 ,199 , 15, 2,'' );

$pdf->ln(32);
$pdf->SetFont('times','B',9);
$pdf->Cell(60);	
$pdf->Cell(80,4,'','T',1,'C');
$pdf->Cell(60);
$pdf->Cell(80,4,'ENCARGADDO DE ACTIVOS FIJOS','',1,'C');
$pdf->SetFont('times','',10);
$pdf->cell(25);
$pdf->Cell(55,4,'',0,1,'L'); 

$pdf->Output();
?> 


