<?php
//V 1000 12/12/16 
require('fpdf.php');
require('comun.inc');

//require('jpdf.php');

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
    $this->Image('imagenes/eng.jpg',25,10,25,25);
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
    $this->Cell(149,25,'COMPROBANTE TRASLADOS',0,0,'C'); 
	$this->SetFont('Arial','B',10);
	$this->SetY(29);
    $this->Cell(161.1);
	$this->Cell(37.8,12,'','TL',0,'L');
	$this->SetY(30);
    $this->Cell(162);
	$this->Cell(35,5,'NUMERO : '.$_POST[idcomp],0,0,'L');
	$this->SetY(34);
    $this->Cell(162);
	$this->Cell(35,5,'FECHA:  '.$_POST[fecha],0,0,'L');
	$this->SetY(29);
	$this->Cell(50.2);
	$this->MultiCell(110.7,4,''.$_POST[concepto],'T','L');		



//***************************************************************************************
//*
	$this->line(10.1,42,209,42);
	$this->RoundedRect(10,43, 199, 5, 1.2,'' );
	$this->SetFont('times','B',9);
	$this->SetY(43);
    $this->Cell(0.1);
    $this->Cell(40,5,'BANCO',0,1,'C'); 
		$this->SetY(43);
    	$this->Cell(40.1);
		$this->Cell(28,5,'No TRANS.',0,1,'C');
			$this->SetY(43);
        	$this->Cell(68.1);
			$this->Cell(8,5,'CC-O',0,1,'C');
			$this->SetY(43);
        	$this->Cell(76.1);
			$this->Cell(41,5,'CTA BANCO ORIGEN',0,1,'C');
			$this->SetY(43);
        	$this->Cell(117.1);
			$this->Cell(8,5,'CC-D',0,1,'C');
			$this->SetY(43);
        	$this->Cell(125.1);
			$this->Cell(42,5,'CTA BANCO DESTINO',0,1,'C');
			$this->SetY(43);
        	$this->Cell(167.1);
			$this->Cell(32,5,'VALOR',0,1,'C');
			$this->line(10.1,49,209,49);
			$this->ln(2);
}


//Pie de página
function Footer()
{

    $this->SetY(-15);
	$this->SetFont('Arial','I',10);
	$this->Cell(0,10,'Pagina '.$this->PageNo().' de {nb}',0,0,'R'); // el parametro {nb} 
	
	
}
}

// cuerpo del pdf
$pdf=new PDF('P','mm','Letter'); 
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',10);
$pdf->SetAutoPageBreak(true,20);
$pdf->SetY(50);   
$con=0;

while ($con<count($_POST[dnbancos]))
{	if ($con%2==0)
	{$pdf->SetFillColor(245,245,245);
	}
    else
	{$pdf->SetFillColor(255,255,255);
	}
	

    $pdf->Cell(40,4,''.$_POST[dnbancos][$con],0,0,'L',1);
    $pdf->Cell(28,4,''.$_POST[dconsig][$con],0,0,'C',1);
    $pdf->Cell(8,4,''.$_POST[dccs][$con],0,0,'C',1);
    $pdf->Cell(41,4,''.$_POST[dcbs][$con],0,0,'R',1);
    $pdf->Cell(8,4,''.$_POST[dccs2][$con],0,0,'C',1);
    $pdf->Cell(42,4,''.$_POST[dcbs2][$con],0,0,'R',1);
    $pdf->Cell(32,4,''.$_POST[dvalores][$con],0,0,'R',1);
	$pdf->ln(4);	
	$con=$con+1;
}
	
	$pdf->SetFont('Arial','B',10);
	$pdf->ln(4);
	$pdf->SetLineWidth(0.5);
	$pdf->cell(125,5,'','T',0,'R');
	$pdf->cell(42,5,'Total','T',0,'R');
	$pdf->cell(32,5,''.$_POST[totalcf],'T',0,'R');
	$pdf->ln(11);
	$pdf->SetLineWidth(0.2);
	$v=$pdf->gety();
	$pdf->RoundedRect(10, $v-1, 199, 10, 1.2,'' );
	$pdf->MultiCell(199,4,'SON: '.$_POST[letras],0,'L');
	$pdf->ln(20);
		$pdf->SetFont('times','B',9);
	$pdf->Cell(60);
	$pdf->Cell(80,4,''.$_SESSION[usuario],'T',1,'C');
	$pdf->cell(60);
	$pdf->Cell(80,5,'ELABORO','',0,'C');
	
$pdf->Output();
?> 

