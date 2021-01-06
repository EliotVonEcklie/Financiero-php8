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
    $this->Cell(149,21,'LIBRO AUXILIAR',0,1,'C'); 
    $this->SetFont('Arial','B',10);
	$this->SetY(25);
    $this->Cell(54);
	$this->Cell(135,5,'Cuenta: '.$_POST[cuenta1].' - Cuenta: '.$_POST[cuenta2],0,0,'C');
	$this->SetY(31);
    $this->Cell(54);
	$this->Cell(135,5,'Desde: '.$_POST[fecha].' Hasta:'.$_POST[fecha2],0,0,'C');
	
	
//********************************************************************************************************************************
	$this->line(10.1,42,209,42);
	$this->RoundedRect(10,43, 199, 9, 1.2,'' );	
	$this->SetFont('Arial','B',10);
	$this->SetY(43);
    $this->Cell(0.1);
    $this->Cell(22,5,'Cod. Cuenta ',0,0,'C'); 
		$this->SetY(43);
    	$this->Cell(22.1);
		$this->Cell(53,5,'Nombre de la Cuenta',0,0,'C');
			$this->SetY(43);
        	$this->Cell(75.1);
			$this->Cell(31,5,'Saldo Anterior',0,0,'C');
			$this->SetY(43);
        	$this->Cell(106.1);
			$this->Cell(62,5,'Movimiento Mes',0,0,'C');
			$this->SetY(43);
        	$this->Cell(168.1);
			$this->Cell(31,5,'Saldo Final',0,0,'C');
			$this->SetY(47);
        	$this->Cell(106.1);
			$this->Cell(31,5,'Debitos',0,1,'C');
			$this->SetY(47);
        	$this->Cell(137.1);
			$this->Cell(31,5,'Creditos',0,1,'C');
			$this->line(10.1,53,209,53);
			$this->ln(4);
//***********************************************************************************************************************************
}
//Pie de página
function Footer()
{

    $this->SetY(-15);
	$this->SetFont('Arial','I',10);
	$this->Cell(0,10,'Impreso por: Software SPID - G&C Tecnoinversiones SAS. - Pagina '.$this->PageNo().' de {nb}',0,0,'R'); // el parametro {nb} 
}
}

//Creación del objeto de la clase heredada
//$pdf=new PDF('P','mm',array(210,140));
$pdf=new PDF('P','mm','Letter'); 
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Times','',10);


$pdf->SetAutoPageBreak(true,20);



$pdf->SetY(54);   
$con=0;


//while ($con<15)
while ($con<count($_POST[dcuentas]))
{	if ($con%2==0)
	{$pdf->SetFillColor(255,255,255);
	}
    else
	{$pdf->SetFillColor(245,245,245);
	}
	

    $pdf->Cell(22,4,''.$_POST[dcuentas][$con],0,0,'L',1);//descrip

    $pdf->Cell(53,4,substr(''.$_POST[dncuentas][$con],0,25),0,0,'L',1);//descrip

$pdf->Cell(31,4,''.number_format($_POST[dsaldoant][$con],2),0,0,'R',1);//descrip

    $pdf->Cell(31,4,''.number_format($_POST[ddebitos][$con],2),0,0,'R',1);//descrip

    $pdf->Cell(31,4,''.number_format($_POST[dcreditos][$con],2),0,0,'R',1);//descrip

  $pdf->Cell(31,4,''.number_format($_POST[dsaldo][$con],2),0,0,'R',1);
	$pdf->ln(4);	

$con=$con+1;
}
	$pdf->ln(6);	
$pdf->SetFont('Times','B',10);

$pdf->Cell(75,5,'Total','T',0,'R');
$pdf->Cell(31,5,''.number_format($_POST[tsaldoant],2,".",","),'T',0,'R');
$pdf->Cell(31,5,''.number_format($_POST[tdebito],2,".",","),'T',0,'R');
$pdf->Cell(31,5,''.number_format($_POST[tcredito],2,".",","),'T',0,'R');
$pdf->Cell(31,5,''.number_format($_POST[tsaldofinal],2,".",","),'T',0,'R');

$pdf->Output();
?> 


