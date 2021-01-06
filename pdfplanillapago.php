<?php
//V 1000 12/12/16 
require('fpdf.php');
require('comun.inc');
require"funciones.inc";
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
    $this->Image('imagenes/eng.jpg',18,12,30,20);
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
    $this->Cell(149,25,'PLANILLA DE PAGO NOMINA',0,0,'C'); 
	//************************************
    $this->SetFont('Arial','B',10);
	
	$this->SetY(27);
    $this->Cell(161.1);
	$this->Cell(37.8,14,'','TL',0,'L');
	$this->SetY(27.5);
    $this->Cell(162);
	$this->Cell(35,5,'NUMERO : '.$_POST[idcomp],0,0,'L');
	$this->SetY(31.5);
    $this->Cell(162);
	$this->Cell(35,5,'VIGENCIA F.: '.$_SESSION[vigencia],0,0,'L');
	$this->SetY(35.5);
    $this->Cell(162);
	$this->Cell(35,5,'FECHA: '.$_POST[fecha],0,0,'L');

	$this->SetY(27);
	$this->Cell(50.2);
	$this->MultiCell(110.7,5,'PLANILLA DE NOMINA MES '.$_POST[periodo].' Vigencia '.$_SESSION[vigencia],'T','C');			
	$this->SetFont('Arial','B',12);
	$this->SetY(46);
	$this->ln(4);
	$this->line(10,60,209,60);
	$this->RoundedRect(10,61, 199, 5, 1,'' );
//********************************************************************************************************************************	
	$this->SetFont('Arial','B',10);
	$this->SetY(61);
    $this->Cell(0.1);
    $this->Cell(10,5,'No. ',0,1,'C'); 
		$this->SetY(61);
    	$this->Cell(11.1);
    $this->Cell(24,5,'DOC. ',0,1,'C'); 
		$this->SetY(61);
    	$this->Cell(24.1);
		$this->Cell(78,5,'EMPLEADO',0,1,'C');	
		$this->SetY(61);
    	$this->Cell(102.1);
		$this->Cell(24,5,'SAL BAS',0,1,'C');				
		$this->SetY(61);
    	$this->Cell(124.1);
		$this->Cell(24,5,'DIAS LIQ',0,1,'C');	
		$this->SetY(61);
    	$this->Cell(148.1);
		$this->Cell(40,5,'DEVENGADO',0,1,'C');	
			$this->SetY(61);
        	$this->Cell(165);
			$this->Cell(34,5,'VALOR',0,1,'C');
			
			$this->line(10,67,209,67);
				$this->ln(2);
			
//***********************************************************************************************************************************
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
$pdf=new PDF('L','mm','Legal'); 
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Times','',10);


$pdf->SetAutoPageBreak(true,20);



$pdf->SetY(68);   
$con=0;


while ($con<count($_POST[rubrosp]))
{	if ($con%2==0)
	{$pdf->SetFillColor(245,245,245);
	}
    else
	{$pdf->SetFillColor(255,255,255);
	}
	$pdf->Cell(30,4,''.$_POST[rubrosp][$con],0,0,'L',1);
    $pdf->Cell(135,4,substr(''.$_POST[nrubrosp][$con],0,80),0,0,'L',1);
    $pdf->Cell(34,4,''.number_format($_POST[vrubrosp][$con],2),0,0,'R',1);
	$pdf->ln(4);	
	$con=$con+1;
}
	$pdf->SetFont('Arial','B',10);
	$pdf->ln(4);
	$pdf->SetLineWidth(0.5);

	$pdf->cell(110,5,'','T',0,'R');
	$pdf->cell(54,5,'Total','T',0,'R');

	$pdf->cell(35,5,'$ '.number_format(array_sum($_POST[vrubrosp]),2),'T',0,'R');


	$pdf->SetLineWidth(0.2);
	
	$pdf->ln(10);

	$v=$pdf->gety();
	$pdf->ln(15);
	$pdf->cell(60);
	$pdf->Cell(80,5,''.strtoupper($_SESSION[usuario]),'T',0,'C');
	$pdf->ln(6);
	$pdf->cell(60);
	$pdf->Cell(80,5,'NOMINA','',0,'C');		
	
	



//********************************************************************************************************************************
	//$pdf->SetY(77); //**********CUADRO
    //$pdf->Cell(5);
   // $pdf->Cell(185,44,'',1,0,'R');

//***********************************************************************************************************************************************
//************************************************************************************************************************************************
	
//**********************************************************************************************************
$pdf->Output();
?> 


