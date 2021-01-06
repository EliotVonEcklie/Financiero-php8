<?php
//V 1000 12/12/16 
require('fpdf.php');
require('comun.inc');
session_start();
date_default_timezone_set("America/Bogota");
$linkbd=conectar_bd();
//*****las variables con los contenidos***********
//**********pdf*******
//$pdf=new FPDF('P','mm','Letter'); 
class PDF extends FPDF{
	//Cabecera de página
	function Header(){	
		$sqlr="select *from configbasica where estado='S'";
		$res=mysql_query($sqlr,$linkbd);
		while($row=mysql_fetch_row($res)){
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
    	$this->Cell(200,21,'INFORME SALDO INVENTARIO',0,1,'C'); 
    	$this->SetFont('Arial','B',10);
		$this->SetY(31);
    	$this->Cell(54);
		$this->Cell(200,5,'Fecha: '.date('d-m-Y'),0,0,'C');
//********************************************************************************************************************************
		$this->line(10.1,42,269,42);
		$this->RoundedRect(10,43, 260, 9, 1.2,'' );	
		$this->SetFont('Arial','B',9);
		$this->SetY(43);
    	$this->Cell(0.1);
    	$this->Cell(15,5,'UNSPSC ',0,0,'C'); 
		$this->SetY(43);
   		$this->Cell(10);
		$this->Cell(55,5,'Codigo Articulo',0,0,'C');
		$this->SetY(43);
   		$this->Cell(75.1);
		$this->Cell(41,5,'Nombre del Articulo',0,0,'C');
		$this->SetY(43);
   		$this->Cell(101.1);
		$this->Cell(75,5,'Unidad de Medida',0,0,'C');			
		$this->SetY(43);
   		$this->Cell(150.1);
		$this->Cell(31,5,'Bodega',0,0,'C');
		$this->SetY(43);
       	$this->Cell(177.1);
		$this->Cell(62,5,'Existencia',0,0,'C');
		$this->line(10.1,53,269,53);
		$this->ln(4);
//********************************************************************************************************************************
	}
//Pie de página
	function Footer(){
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
$sql="SELECT almarticulos.codunspsc, almarticulos.codigo, almarticulos.grupoinven, almarticulos.nombre, almarticulos.medida, almgrupoinv.nombre, almarticulos.existencia FROM almarticulos INNER JOIN almgrupoinv ON almarticulos.grupoinven=almgrupoinv.codigo WHERE almarticulos.estado='S' ORDER BY almarticulos.codunspsc";
$res=mysql_query($sql, $linkbd);
while($row=mysql_fetch_array($res)){
	if ($con%2==0){
		$pdf->SetFillColor(255,255,255);
	}
    else{
		$pdf->SetFillColor(245,245,245);
	}
    $pdf->Cell(30,4,$row[0],0,0,'L',1);//descrip
    $pdf->Cell(40,4,$row[2].$row[1],0,0,'L',1);//descrip
	$pdf->Cell(63,4,$row[3],0,0,'L',1);//descrip
	$pdf->Cell(24,4,$row[4],0,0,'L',1);//descrip
    $pdf->Cell(31,4,$row[5],0,0,'L',1);//descrip
    $pdf->Cell(30,4,number_format($row[6]),0,0,'R',1);//descrip
	$pdf->ln(4);	
$con=$con+1;
}
$pdf->ln(6);	
$pdf->Output();
?> 


