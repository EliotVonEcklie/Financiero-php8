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
 		}
	  	//Parte Izquierda
		$this->Image('imagenes/eng.jpg',23,10,25,25);
		$this->SetFont('Arial','B',10);
		$this->SetY(10);
		$this->RoundedRect(10, 10, 260, 31, 2.5,'' );
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
		$this->Cell(54.1);
		$this->Cell(200,21,'AUXILIAR CUENTA CONTABLE',0,1,'C'); 
		$this->SetFont('Arial','B',10);
		$this->SetY(25);
		$this->Cell(54);
		$this->Cell(200,5,'Cuenta: '.$_POST[cuenta].' '.$_POST[ncuenta],0,0,'C');
		$this->SetY(31);
		$this->Cell(54);
		$this->Cell(200,5,'Desde: '.$_POST[fecha].' Hasta:'.$_POST[fecha2],0,0,'C');
	
	
		//********************************************************************************************************************************
		$this->line(10.1,42,269,42);
		$this->RoundedRect(10,43, 260, 9, 1.2,'' );	
		$this->SetFont('Arial','B',9);
		$this->SetY(43);
		$this->Cell(0.1);
		$this->Cell(15,5,'Fecha ',0,0,'C'); 
		$this->SetY(43);
    	$this->Cell(10);
		$this->Cell(55,5,'Tipo Comp - No Comp',0,0,'C');
		$this->SetY(43);
		$this->Cell(75.1);
		$this->Cell(41,5,'Tercero',0,0,'C');
		$this->SetY(43);
		$this->Cell(101.1);
		$this->Cell(75,5,'CC',0,0,'C');			
		$this->SetY(43);
		$this->Cell(150.1);
		$this->Cell(31,5,'Saldo Anterior',0,0,'C');
		$this->SetY(43);
		$this->Cell(177.1);
		$this->Cell(62,5,'Movimiento Periodo',0,0,'C');
		$this->SetY(43);
		$this->Cell(233.1);
		$this->Cell(31,5,'Saldo Final',0,0,'C');
		$this->SetY(47);
		$this->Cell(180.1);
		$this->Cell(31,5,'Debitos',0,1,'C');
		$this->SetY(47);
		$this->Cell(205.1);
		$this->Cell(31,5,'Creditos',0,1,'C');
		$this->line(10.1,53,269,53);
		$this->ln(4);
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
$pdf=new PDF('L','mm','Letter'); 
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',8);
$pdf->SetAutoPageBreak(true,20);
$pdf->SetY(54);   
$con=0;

//while ($con<15)
while ($con<count($_POST[tipocomps]))
{	
	if ($con%2==0)
	{
		$pdf->SetFillColor(255,255,255);
	}
    else
	{
		$pdf->SetFillColor(245,245,245);
	}
    $pdf->Cell(15,4,''.$_POST[fechas][$con],0,0,'L',1);//descrip
    $pdf->Cell(55,4,substr(''.$_POST[tipocomps][$con].'-'.$_POST[ncomps][$con],0,50),0,0,'L',1);//descrip
	$pdf->Cell(63,4,''.$_POST[terceros][$con].' - '.substr($_POST[nterceros][$con],0,40),0,0,'L',1);//descrip
	$pdf->Cell(8,4,''.$_POST[ccs][$con],0,0,'R',1);//descrip
    $pdf->Cell(31,4,''.number_format($_POST[saldanteriores][$con],2),0,0,'R',1);//descrip
    $pdf->Cell(30,4,''.number_format($_POST[debitos][$con],2),0,0,'R',1);//descrip
    $pdf->Cell(25,4,''.number_format($_POST[creditos][$con],2),0,0,'R',1);//descrip
  	$pdf->Cell(31,4,''.number_format($_POST[nuevosaldos][$con],2),0,0,'R',1);
	$pdf->ln(4);	
	$con=$con+1;
}
	$pdf->ln(6);	
	$pdf->SetFont('Times','B',10);

	$pdf->Cell(141,5,'Total','T',0,'R');
	$pdf->Cell(30,5,''.number_format($_POST[totiniciales],2,".",","),'T',0,'R');
	$pdf->Cell(31,5,''.number_format($_POST[sumadebitos],2,".",","),'T',0,'R');
	$pdf->Cell(25,5,''.number_format($_POST[sumacreditos],2,".",","),'T',0,'R');
	$pdf->Cell(31,5,''.number_format($_POST[totnuevosaldos],2,".",","),'T',0,'R');

$pdf->Output();
?> 


