<?php
require('fpdf.php');
require('comun.inc');
session_start();
date_default_timezone_set("America/Bogota");
//**********pdf*******
class PDF extends FPDF
{
	function Header()//Cabecera de página
	{
		$linkbd=conectar_bd();
		$sqlr="select *from configbasica where estado='S'";
		$res=mysql_query($sqlr,$linkbd);
		while($row=mysql_fetch_row($res))
		{
			$nit=$row[0];
			$rs=$row[1];
		}
		$this->Image('imagenes/eng.jpg',23,11,25,25);
		$this->SetFont('Arial','B',8);
		$this->SetY(10);
		$this->RoundedRect(10, 10, 199, 31, 2.5,'' );
		$this->Cell(0.1);
		$this->Cell(50,31,'','R',0,'L'); 
		
		//TRIMESTRE Y VIGENCIA CHIP
		$arrper=array('','Ene-Mar','Abr-Jun','Jul-Sep','Oct-Dic');
		if($_POST[nperiodo]<4)
		{
			$trimchip=$_POST[nperiodo]-1;
			$vigchip=$_POST[vigencias];
		}
		else
		{
			$trimchip=4;
			$vigchip=$_POST[vigencias]-1;
		}
		//FIN CHIP
		//*******************************************************************
		$this->SetFont('Arial','B',14);
		$this->SetY(10);
		$this->Cell(50.1);
		$this->Cell(149,10,$rs,0,1,'C'); 
		$this->SetFont('Arial','B',12);
		$this->SetY(15);
		$this->Cell(50.1);
		$this->Cell(149,10,$nit,0,1,'C'); 
		$this->SetFont('Arial','B',13);
		$this->SetY(26);
		$this->Cell(50.1);
		$this->Cell(149,10,'VALIDAR SALDOS CHIP','T',1,'C'); 
		$this->SetFont('Arial','B',10);
		$this->SetY(34);
		$this->Cell(50);
		$this->Cell(149,5,'Trimestre: '.$arrper[$_POST[nperiodo]].' - Vigencia: '.$_POST[vigencias],0,0,'C');
		//********************************************************************
		$this->line(10.1,42,209,42);
		$this->RoundedRect(10,43, 199, 9, 1.2,'' );	
		$this->SetFont('Arial','B',10);
		$this->SetY(43);
		$this->Cell(0.1);
		$this->Cell(22,5,'Cuenta ',0,0,'C'); 
		$this->SetY(43);
		$this->Cell(22.1);
		$this->Cell(58,5,'Nombre de la Cuenta',0,0,'C');
		$this->SetY(43);
		$this->Cell(80);
		$this->MultiCell(40,5,'Saldo Inicial Balance '.$arrper[$_POST[nperiodo]].' '.$_POST[vigencias],0,'C',false);
		$this->SetY(43);
		$this->Cell(120);
		$this->MultiCell(40,5,'Saldo Final CHIP '.$_POST[nomperi].' '.$_POST[vigeperi],0,'C',false);
		$this->SetY(43);
		$this->Cell(160);
		$this->Cell(40,5,'Diferencia',0,0,'C');
		$this->line(10.1,53,209,53);
		$this->ln(12);
		//*******************************************************************
	}
	function Footer()//Pie de página
	{
		$this->SetY(-15);
		$this->SetFont('Arial','I',10);
		$this->Cell(0,10,'Pagina '.$this->PageNo().' de {nb}',0,0,'R'); // el parametro {nb} 
	}
}
$pdf=new PDF('P','mm','Letter'); 
$pdf->AliasNbPages();
$pdf->AddPage();
//TRIMESTRE Y VIGENCIA CHIP
$arrper=array('','Ene-Mar','Abr-Jun','Jul-Sep','Oct-Dic');
if($_POST[nperiodo]<4)
{
	$trimchip=$_POST[nperiodo]-1;
	$vigchip=$_POST[vigencias];
}
else
{
	$trimchip=4;
	$vigchip=$_POST[vigencias]-1;
}
//FIN CHIP
$pdf->SetFont('Times','',10);
$pdf->SetAutoPageBreak(true,20);
$pdf->SetY(54);
$con=0;
while ($con<count($_POST[dcuentas]))
{
	$miles=$_POST[dsaldoant][$con];
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(22,4,''.$_POST[dcuentas][$con],0,0,'L',1);
	$pdf->Cell(58,4,substr(''.$_POST[dncuentas][$con],0,25),0,0,'L',1);
	$pdf->Cell(40,4,''.number_format($miles,0,',','.'),0,0,'R',1);
	$pdf->Cell(40,4,''.number_format($_POST[dsaldochip][$con],0,',','.'),0,0,'R',1);
	$pdf->Cell(40,4,''.number_format($_POST[dsaldif][$con],0,',','.'),0,1,'R',1);
	$con=$con+1;
}
$pdf->ln(6);
$pdf->Output();
?>