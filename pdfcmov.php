<?php
//V 1000 12/12/16 
require('fpdf.php');
require"comun.inc";
require"funciones.inc";
session_start();
$linkbd=conectar_bd();	
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
if ($_POST[estado]=='0'){
		    $this->Image('imagenes/anulado.jpg',60,75,100,100);
	}
     //Parte Izquierda
    $this->Image('imagenes/eng.jpg',18,12,38,20);
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
	$sql="Select nombre from tipo_comprobante WHERE codigo='".$_POST[tipocomprobante]."' AND estado='S' ";
	$res=mysql_query($sql,$linkbd);
	$fila=mysql_fetch_row($res);
    $this->Cell(149,15,''.$fila[0],0,0,'C'); 


	$this->SetY(1);
    $this->Cell(50.1);
    $this->Cell(149,20,''.$_POST[ntipocomp],0,0,'L'); 
	//************************************
    $this->SetFont('Arial','B',10);
	
	$this->SetY(27);
	$this->Cell(50.2);
	$this->multiCell(110.7,4,''.$_POST[concepto],'T','L');
	
	$this->SetY(27);
    $this->Cell(161.1);
	$this->Cell(37.8,14,'','TL',0,'L');
	
	$this->SetY(27.5);
    $this->Cell(162);
	$this->Cell(35,5,'NUMERO : '.$_POST[ncomp],0,0,'L');
	
	$this->SetY(35.5);
    $this->Cell(162);
	$this->Cell(35,5,'FECHA: '.date('d-m-Y',strtotime($_POST[fecha])),0,0,'L');

	$this->SetY(27);
	$this->Cell(50.2);

	$this->MultiCell(110.7,4,'',0,'L');		
	

	
//********************************************************************************************************************************
	$this->line(10.1,42,209,42);
	$this->RoundedRect(10,43, 199, 5, 1.2,'' );
	$this->SetFont('Arial','B',10);
	$this->SetY(43);
    $this->Cell(0.1);
    $this->Cell(19,5,'CODIGO',0,1,'C'); 
		$this->SetY(43);
    	$this->Cell(19.1);
		$this->Cell(54,5,'CUENTA',0,1,'C');
			$this->SetY(43);
        	$this->Cell(73.1);
			$this->Cell(23,5,'TERCERO',0,1,'C');
			$this->SetY(43);
        	$this->Cell(101);
			$this->Cell(36,5,'DETALLE',0,1,'C');
			$this->SetY(43);
        	$this->Cell(96.5);
			$this->Cell(5,5,'C.C.',0,1,'C');
			$this->SetY(43);
        	$this->Cell(137);
			
			$this->Cell(31,5,'DEBITO',0,1,'C');
			$this->SetY(43);
        	$this->Cell(168);
			$this->Cell(31,5,'CREDITO',0,1,'C');
			$this->line(10.1,49,209,49);
			$this->line(10.1,50,209,50);
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
$pdf=new PDF('P','mm','Letter'); 
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',10);
$pdf->SetAutoPageBreak(true,20);
$pdf->SetY(50);   
$con=0;
$control=52;
$ct=1;	

while ($con<count($_POST[dcuentas]))
{	if ($con%2==0)
	{$pdf->SetFillColor(245,245,245);
	}
    else
	{$pdf->SetFillColor(255,255,255);
	}
	
	$pdf->Cell(0.1);
    $pdf->Cell(19,4,''.$_POST[dcuentas][$con],'LR',0,'L',1);//descrip
	$pdf->Cell(53,4,''.substr(ucfirst(strtolower($_POST[dncuentas][$con])),0,33),'LR',0,'L',1);//descrip
	$pdf->Cell(23,4,''.substr(ucfirst(strtolower($_POST[dterceros][$con])),0,25),'LR',0,'R',1);//descrip
	$pdf->Cell(5,4,''.$_POST[dccs][$con],'LR',0,'R',1);//descrip
	$pdf->Cell(37,4,''.substr(ucfirst(strtolower($_POST[ddetalles][$con])),0,25),'LR',0,'L',1);//descrip

	$pdf->Cell(31,4,''.number_format($_POST[ddebitos][$con],2,".",","),'LR',0,'R',1);
	$pdf->Cell(31,4,''.number_format($_POST[dcreditos][$con],2,".","."),'LR',0,'R',1);
	$pdf->ln(4);	
$con=$con+1;	
$ct=$ct+1;




if ($ct%$control==0)
		{
		
		$pdf->line(10.1,258.3,209,258.3);
		}
	
	
	
}
	$niy=$pdf->Gety();
	
	$pdf->line(10.1,$niy,209,$niy);
	
	$pdf->ln(-8);
	$pdf->SetFont('Arial','B',10);
		
	$pdf->ln(10);
	
	//$pdf->SetLineWidth(0.2);	
	$pdf->cell(105.1);
	$v=$pdf->gety();
	$pdf->cell(32,5,'Total',0,0,'R');
	$x=$pdf->getx();
	$pdf->RoundedRect($x, $v, 62, 10, 1.2,'' );

	$pdf->cell(31,5,''.$_POST[cuentadeb],'R',0,'R');

	$pdf->cell(31,5,''.$_POST[cuentacred],0,0,'R');

	$pdf->ln(5);
	$pdf->cell(105.1,5,'',0,0,'R');
	$pdf->Cell(32,5,'Diferencia: '.$_POST[diferencia],0,0,'R');
	$pdf->cell(62,5,'','T',0,'C');


	$pdf->ln(10);
	$v=$pdf->gety();
	$x=$pdf->getx();
	$pdf->RoundedRect($x, $v, 66, 15, 1.2,'' );
	$pdf->RoundedRect($x+66.5, $v, 65.5, 15, 1.2,'' );
	$pdf->RoundedRect($x+132.5, $v, 66.5, 15, 1.2,'' );

	$pdf->Cell(66,5,'ELABORO: '.$_POST[elaboro],0,0,'L');
	
	$pdf->Cell(66,5,'REVISO: ',0,0,'L');
	
	$pdf->Cell(67,5,'APROBO: ',0,1,'L');
	
	
	
	$pdf->SetLineWidth(0.4);	
	$pdf->ln(2);
	$pdf->cell(6);
	$pdf->Cell(54,5,'SOFTWARE SPID','B',0,'C');
	$pdf->cell(12);
	$pdf->Cell(54,5,''.iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_SESSION[usuario]),'B',0,'C');
	$pdf->cell(12);
	$pdf->Cell(54,5,'','B',1,'L');
	
	
	//$pdf->SetLineWidth(0.2);	
	//$ny=$niy-50;
	//$pdf->sety(50);
	//$pdf->cell(199,$niy-50,'',1,0);




$pdf->Output();
?> 


