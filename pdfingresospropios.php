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
    $this->Cell(149,20,'RETENCIONES INGRESOS PROPIOS DETALLADO',0,0,'C'); 
	//************************************
    $this->SetFont('Arial','I',10);
	
	$this->SetY(27);
	$this->Cell(50.2);
	$this->multiCell(110.7,7,''.strtoupper($_POST[concepto]),'T','L');
	    $this->SetFont('Arial','B',10);
	$this->SetY(27);
    $this->Cell(161.1);
	$this->Cell(37.8,14,'','TL',0,'L');
	
	$this->SetY(27);
    $this->Cell(162);
	$this->Cell(35,5,'NUMERO : '.$_POST[idcomp],0,0,'L');
	$this->SetY(31);
    $this->Cell(162);
	$this->Cell(35,5,'FECHA: '.$_POST[fecha],0,0,'L');
	$this->SetY(35);
    $this->Cell(162);
	$this->Cell(35,5,'VIGENCIA: '.$_POST[vigencias],0,0,'L');

	$this->SetY(27);
	$this->Cell(50.2);

	$this->MultiCell(105.7,4,'',0,'L');		
	

	
//********************************************************************************************************************************
//	$this->line(10.1,42,209,42);
//	$this->RoundedRect(10,42.7, 199, 4, 1.2,'' );
	$this->SetFont('times','B',10);
				$this->ln(12);
			
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

$pdf->SetFont('Arial','B',12);
//$pdf->SetFillColor(255,255,153);				
$pdf->SetY(46);   
$pdf->cell(125);
$pdf->cell(27,8,'NETO A PAGAR: ',0,0,'R');
$pdf->RoundedRect(161, 46 ,48 , 8, 2,'');
$pdf->cell(45,8,'$'.number_format($_POST[valorpagar],2),0,'C');

$pdf->ln(10);

 $meses=array('','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->cell(0.2);
$pdf->cell(35,5,'MES:',0,0,'L',1);
$pdf->SetFont('Arial','',10);
$pdf->cell(40,5,''.$meses[$_POST[mes]],0,0,'L',1);
$pdf->SetFont('Arial','B',10);
$pdf->cell(35,5,'',0,0,'L',1);
$pdf->SetFont('Arial','',10);
$pdf->cell(40,5,'',0,1,'L',1);

$pdf->SetFillColor(250,250,250);
$pdf->SetFont('Arial','B',10);
$pdf->cell(0.2);
$pdf->cell(35,5,'Valor Pago:',0,0,'L',1);
$pdf->SetFont('Arial','',10);
$pdf->cell(40,5,'$'.number_format($_POST[valorpagar],2),0,0,'L',1);
$pdf->SetFont('Arial','B',10);
$pdf->cell(25,5,'Retenciones: ',0,0,'L',1);
$pdf->SetFont('Arial','',10);
$pdf->cell(35,5,'$'.number_format($_POST[retenciones],2),0,0,'L',1);
$pdf->SetFont('Arial','B',10);
$pdf->cell(25,5,'Neto a Pagar:',0,0,'L',1);
$pdf->SetFont('Arial','',10);
$pdf->cell(38,5,'$'.number_format($_POST[valorpagar],2),0,1,'L',1);

$pdf->RoundedRect(10, 54 ,199 , 13, 2,'');

$pdf->ln(6);	
$y=$pdf->GetY();	
	$pdf->SetY($y);
$pdf->SetFillColor(222,222,222);
$pdf->SetFont('Arial','B',10);
    $pdf->Cell(0.1);
    $pdf->Cell(199,5,'DETALLE',0,0,'C',1); 
 $pdf->ln(6); 

	 $y=$pdf->GetY();	
	$pdf->SetFillColor(222,222,222);
	$pdf->SetFont('Arial','B',10);
	$pdf->SetY($y);
    $pdf->Cell(0.1);
   	$pdf->Cell(70,5,'Nombre',0,0,'C',1);
	$pdf->SetY($y);
    $pdf->Cell(71);
   	$pdf->Cell(55,5,'Banco',0,0,'C',1);	
	$pdf->SetY($y);
    $pdf->Cell(127);
   	$pdf->Cell(30,5,'Cta Bancaria',0,0,'C',1);	
		$pdf->SetY($y);
       	$pdf->Cell(158);
		$pdf->Cell(41,5,'Valor',0,0,'C',1);

$pdf->SetFont('Arial','',8);
	 	$cont=0;
			 $pdf->ln(5); 
 for($x=0;$x<count($_POST[mddescuentos]);$x++)
			  {		 
	  if ($con%2==0)
	  {$pdf->SetFillColor(255,255,255);
	  }
      else
	  {$pdf->SetFillColor(245,245,245);
	  }
		$pdf->Cell(70,4,''.$_POST[mddescuentos][$x].' '.$_POST[mdndescuentos][$x],'',0,'L',1);
		$pdf->Cell(56,4,''.$_POST[mnbancos][$x],'',0,'L',1);				
		$pdf->Cell(31,4,''.$_POST[mctanbancos][$x],'',0,'L',1);						
		$pdf->Cell(41,4,'$'.$_POST[mddesvalores2][$x],'',1,'R',1);				
		$con=$con+1;
   }
$pdf->ln(8);
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

$pdf->ln(29);
	$pdf->SetFont('times','B',9);
	$pdf->Cell(50);
	$pdf->Cell(80,4,''.strtoupper($_SESSION[usuario]),'T',1,'C');
	$pdf->Cell(50);
	$pdf->Cell(80,4,'ELABORO','',1,'C');


	$pdf->SetFont('times','',10);
		$pdf->cell(25);
	$pdf->Cell(55,4,'',0,1,'L'); 

$pdf->Output();
?> 


