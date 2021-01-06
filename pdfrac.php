<?php
//V 1000 12/12/16 
require('fpdf.php');
   date_default_timezone_set("America/Bogota");
//*****las variables con los contenidos***********
//**********pdf*******
//$pdf=new FPDF('P','mm','Letter'); 
class PDF extends FPDF
{
//Cabecera de página
function Header()
{
    //Logo
   $this->Image('imagenes/petrominerales.jpg',21,12,58,18);
//	    $this->Image('anulado.jpg',60,75,100,100);
	    //******************		
				$this->SetFont('Arial','B',10);
	$this->SetY(10);
    $this->Cell(10);
    $this->Cell(60,21,' ',1,0,'L'); //CUADRO LOGO
    //*****************************************************************************************************************************************
	$this->SetFont('Arial','B',11);
	$this->SetY(10);
    $this->Cell(70);
    $this->Cell(90,21,'REPORTE DIARIO DE ACTIVIDADES EN CAMPO',1,1,'C'); 
	//************************************
	$this->SetFont('Arial','',9);
	$this->SetY(10);
    $this->Cell(160);
    $this->Cell(35,5,'Codigo: FRM-001',1,1,'L'); 
	$this->SetFont('Arial','',9);
	$this->SetY(15);
    $this->Cell(160);
    $this->Cell(35,5,'Version: 01',1,1,'L'); 
	$this->SetFont('Arial','',9);
	$this->SetY(20);
    $this->Cell(160);
    $this->Cell(35,5,'Fecha: 08/04/2012',1,1,'L'); 
	$this->SetFont('Arial','',9);
	$this->SetY(25);
    $this->Cell(160);
    $this->Cell(35,6,'Pagina: 1 de 1',1,1,'L'); 		
//*****************************************************************************************************************************************
	$this->SetFont('Arial','B',11);
	$this->SetY(32);
    $this->Cell(10);
    $this->Cell(185,5,'INFORMACION GENERAL ',1,1,'C','L'); 
//*****************************************************************************************************************************************
	$this->SetFont('Arial','',10);
	$this->SetY(37);
    $this->Cell(10);
    $this->Cell(145,5,'Contratista: '.$_POST[contratista],1,1,'L'); 
	$this->SetFont('Arial','',10);
	$this->SetY(37);
    $this->Cell(155);
    $this->Cell(40,5,'Orden: '.$_POST[orden],1,1,'L'); 
	//*************************************************************
    $this->SetFont('Arial','',10);
	$this->SetY(42);
    $this->Cell(10);
	$this->Cell(185,5,'Proyecto: '.$_POST[proyecto],1,0,'L');
//*****************************************************************************************************************************************
	$this->SetFont('Arial','',10);
	$this->SetY(47);
    $this->Cell(10);
    $this->Cell(95,5,'Bloque: '.$_POST[bloque],1,1,'L'); 
	$this->SetFont('Arial','',10);
	$this->SetY(47);
    $this->Cell(105);
    $this->Cell(90,5,'Locacion: '.$_POST[locacion],1,1,'L'); 
//*************************************************************
	$this->SetFont('Arial','',10);
	$this->SetY(52);
    $this->Cell(10);
    $this->Cell(95,5,'Especialidad: '.$_POST[especialidad],1,1,'L'); 
	$this->SetFont('Arial','',10);
	$this->SetY(52);
    $this->Cell(105);
    $this->Cell(90,5,'Supervisor: '.$_POST[supervisor],1,1,'L'); 
//*************************************************************
	$this->SetFont('Arial','',10);
	$this->SetY(57);
    $this->Cell(10);
    $this->Cell(95,5,'Fecha Inicial: '.$_POST[fechaini],1,1,'L'); 
	$this->SetFont('Arial','',10);
	$this->SetY(57);
    $this->Cell(105);
    $this->Cell(90,5,'Fecha Final: '.$_POST[fechafin],1,1,'L'); 
//*************************************************************
	$this->SetFont('Arial','',10);
	$this->SetY(62);
    $this->Cell(10);
    $this->Cell(95,5,'Fecha Reporte: '.$_POST[fecharep],1,1,'L'); 
	$this->SetFont('Arial','',10);
	$this->SetY(62);
    $this->Cell(105);
    $this->Cell(90,5,'% Avance: '.$_POST[avance],1,1,'L'); 
//*************************************************************
	$this->SetFont('Arial','',10);
	$this->SetY(67);
    $this->Cell(10);
    $this->Cell(95,5,'Permisos Relacionados: '.$_POST[otrel],1,1,'L'); 
	$this->SetFont('Arial','',10);
	$this->SetY(67);
    $this->Cell(105);
    $this->Cell(90,5,'OT Relacionados: '.$_POST[permrel],1,1,'L'); 
//*************** actividades**********************************************
	$this->SetFont('Arial','B',10);
	$this->SetY(73);
    $this->Cell(10);
	$this->Cell(15,5,'ITEM',1,0,'C','L');
	//************************************
 	$this->SetY(73);
    $this->Cell(25);
	$this->Cell(155,5,'DESCRIPCION DE ACTIVIDADES',1,0,'C','L');
		//************************************
	$this->SetY(73);
    $this->Cell(180);
	$this->Cell(15,5,'HORAS',1,0,'C','L');
	//************************************
	//**********************************************************************************************************
}
//Pie de página
	function Footer()
	{
   		//****************************
//	    	$this->Image('slogan-aso.jpg',75,265,80,10);
	    	$this->Image('hue1.jpg',9,100,5,5);
	    	$this->Image('hue1.jpg',9,180,5,5);
	}
}
//Creación del objeto de la clase heredada
//$pdf=new PDF();
$pdf=new PDF('P','mm','Letter'); 
//$pdf->AliasNbPages();
$pdf->AddPage();
		$pdf->SetFont('Arial','',10);
	for ($x=0;$x<=count($_SESSION[acts]);$x++)
	{
	if ($_SESSION[acts][$x-1]!='')
	{
    $pdf->SetY(73+($x*5));
    $pdf->Cell(10);
    $pdf->Cell(15,5,$x,1,1,'C');//v/u
    $pdf->SetY(73+($x*5));
    $pdf->Cell(25);
    $pdf->Cell(155,5,$_SESSION[acts][$x-1],1,1,'L');//codigo
    $pdf->SetY(73+($x*5));
    $pdf->Cell(180);
    $pdf->Cell(15,5,ucwords(strtolower($_SESSION[horacts][$x-1])),1,1,'C');//descrip
		}
		}
//*************** personal **************
$posiciony=(74+($x*5));
	$pdf->SetFont('Arial','B',11);
	$pdf->SetY($posiciony);
    $pdf->Cell(10);
	$pdf->Cell(15,5,'ITEM',1,0,'C','L');
	//************************************
 	$pdf->SetY($posiciony);
    $pdf->Cell(25);
	$pdf->Cell(110,5,'RELACION DEL PERSONAL (NOMBRE)',1,0,'C','L');
		//************************************
	$pdf->SetY($posiciony);
    $pdf->Cell(135);
	$pdf->Cell(45,5,'CARGOS',1,0,'C','L');
	//************************************
	$pdf->SetY($posiciony);
    $pdf->Cell(180);
	$pdf->Cell(15,5,'HORAS',1,0,'C','L');
	//************************************
			$pdf->SetFont('Arial','',10);
	for ($x=0;$x<=count($_SESSION[personal]);$x++)
	{
	if ($_SESSION[personal][$x-1]!='')
	{
    $pdf->SetY($posiciony+($x*5));
    $pdf->Cell(10);
    $pdf->Cell(15,5,$x,1,1,'C');//v/u
    $pdf->SetY($posiciony+($x*5));
    $pdf->Cell(25);
    $pdf->Cell(155,5,$_SESSION[personal][$x-1],1,1,'L');//codigo
    $pdf->SetY($posiciony+($x*5));
    $pdf->Cell(135);
    $pdf->Cell(45,5,ucwords(strtolower($_SESSION[cargos][$x-1])),1,1,'C');//descrip
    $pdf->SetY($posiciony+($x*5));
    $pdf->Cell(180);
    $pdf->Cell(15,5,ucwords(strtolower($_SESSION[horapers][$x-1])),1,1,'C');//descrip
		}
		}
$posiciony=($posiciony+1+($x*5));
	$pdf->SetFont('Arial','B',11);
	$pdf->SetY($posiciony);
    $pdf->Cell(10);
	$pdf->Cell(15,5,'ITEM',1,0,'C','L');
	//************************************
 	$pdf->SetY($posiciony);
    $pdf->Cell(25);
	$pdf->Cell(130,5,'RELACION DE MATERIALES',1,0,'C','L');
		//************************************
	$pdf->SetY($posiciony);
    $pdf->Cell(155);
	$pdf->Cell(25,5,'UNIDADES',1,0,'C','L');
	//************************************
	$pdf->SetY($posiciony);
    $pdf->Cell(180);
	$pdf->Cell(15,5,'CANT',1,0,'C','L');
	//************************************
			$pdf->SetFont('Arial','',10);
	for ($x=0;$x<=count($_SESSION[materiales]);$x++)
	{
	if ($_SESSION[materiales][$x-1]!='')
	{
    $pdf->SetY($posiciony+($x*5));
    $pdf->Cell(10);
    $pdf->Cell(15,5,$x,1,1,'C');//v/u
    $pdf->SetY($posiciony+($x*5));
    $pdf->Cell(25);
    $pdf->Cell(155,5,$_SESSION[materiales][$x-1],1,1,'L');//codigo
    $pdf->SetY($posiciony+($x*5));
    $pdf->Cell(155);
    $pdf->Cell(25,5,ucwords(strtolower($_SESSION[unidades][$x-1])),1,1,'C');//descrip
    $pdf->SetY($posiciony+($x*5));
    $pdf->Cell(180);
    $pdf->Cell(15,5,ucwords(strtolower($_SESSION[cants][$x-1])),1,1,'C');//descrip
		}
		}
$posiciony=($posiciony+1+($x*5));
	$pdf->SetFont('Arial','B',11);
	$pdf->SetY($posiciony);
    $pdf->Cell(10);
    $pdf->Cell(185,5,'NOTIFICACIONES ',1,1,'C','L'); 
$posiciony=($posiciony+5);
	$pdf->SetFont('Arial','',9);
	$pdf->SetY($posiciony);
    $pdf->Cell(10);
    $pdf->Cell(185,10,$_POST[notificaciones],1,1,'C','L'); 
$posiciony=($posiciony+11);
	$pdf->SetFont('Arial','B',11);
	$pdf->SetY($posiciony);
    $pdf->Cell(10);
    $pdf->Cell(95,5,'CONTRATISTA',1,1,'C','L'); 
	$pdf->SetFont('Arial','B',11);
	$pdf->SetY($posiciony);
    $pdf->Cell(105);
    $pdf->Cell(90,5,'MANTENIMIENTO',1,1,'C','L'); 
//*****************************************************************************************************************************************
$posiciony=($posiciony+5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetY($posiciony);
    $pdf->Cell(10);
    $pdf->Cell(95,5,'Nombre: '.$_POST[nomcontra],1,1,'L','L'); 
	$pdf->SetFont('Arial','',10);
	$pdf->SetY($posiciony);
    $pdf->Cell(105);
    $pdf->Cell(90,5,'Nombre: '.$_POST[nombmante],1,1,'L','L'); 
$posiciony=($posiciony+5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetY($posiciony);
    $pdf->Cell(10);
    $pdf->Cell(95,5,'Firma: ',1,1,'L','L'); 
	$pdf->SetFont('Arial','',10);
	$pdf->SetY($posiciony);
    $pdf->Cell(105);
    $pdf->Cell(90,5,'Firma: ',1,1,'L','L'); 
$posiciony=($posiciony+5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetY($posiciony);
    $pdf->Cell(10);
    $pdf->Cell(95,5,'Cargo: '.$_POST[cargocontra],1,1,'L','L'); 
	$pdf->SetFont('Arial','',10);
	$pdf->SetY($posiciony);
    $pdf->Cell(105);
    $pdf->Cell(90,5,'Cargo: '.$_POST[cargomante],1,1,'L','L'); 
	//*************************************************************
$pdf->Output();
?> 