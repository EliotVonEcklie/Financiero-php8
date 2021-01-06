<?php
//V 1000 12/12/16 
require('fpdf.php');
require('comun.inc');
require ('funciones.inc');
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
if ($_POST[estadoc]=='ANULADO'){
		   $this->Image('imagenes/anulado.jpg',50,15,100,40);
	}
   //Parte Izquierda
    $this->Image('imagenes/eng.jpg',18,12,30,30);
	$this->SetFont('Arial','B',10);
	$this->SetY(10);
	$this->RoundedRect(10, 10, 195, 31, 2,'' );
	$this->Cell(0.1);
    $this->Cell(50,31,'','R',0,'L'); 
	$this->SetY(31);
    $this->Cell(0.1);
    $this->Cell(50,5,''.$rs,0,0,'C'); 
	$this->SetFont('Arial','B',8);
	$this->SetY(35);
    $this->Cell(0.1);
    $this->Cell(50,5,''.$nit,0,0,'C'); //Cuadro Izquierdawsx
	

	
    //*****************************************************************************************************************************
	$this->SetFont('Arial','B',14);
	$this->SetY(10);
    $this->Cell(50.1);
    $this->Cell(145,31,'',0,1,'C'); 


	$this->SetY(10);
    $this->Cell(50.1);
    $this->Cell(107,25,'RECIBO DE ABONO, ACUERDO PREDIAL',0,0,'C'); 
	//************************************
    $this->SetFont('Arial','B',10);
	
	$this->SetY(26);
    $this->Cell(157.1);
	$this->Cell(38,15,'','LT',0,'L');
	
	 $this->SetFont('Arial','B',10);
	
	$this->SetY(26);
	$this->Cell(50.2);
	$this->multiCell(110.7,7,''.$_POST[concepto],'T','L');
	
	$this->SetY(27);
    $this->Cell(158);
	$this->Cell(35,5,'NUMERO : '.$_POST[idcomp],0,0,'L');
	$this->SetY(35);
    $this->Cell(158);
	$this->Cell(35,5,'FECHA: '.$_POST[fecha],0,0,'L');
	

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

$pdf->SetAutoPageBreak(true,20);

$pdf->SetFont('Arial','B',12);
//$pdf->SetFillColor(255,255,153);				
$pdf->SetY(46);   
$pdf->cell(120);
$pdf->cell(27,8,'VALOR: ',0,0,'R');
$pdf->RoundedRect(157, 46 ,48 , 8, 2,'' );
$pdf->cell(48,8,'$'.$_POST[valorecaudo],0,0,'R');



$pdf->SetFont('Arial','B',10);


$pdf->SetY(54);   

//cuadro

//$pdf->cell(195,22,'',1,0);
$pdf->SetFillColor(255,255,255);
$pdf->SetY(55);
$pdf->cell(0.2);
$pdf->cell(35,5,'CONTRIBUYENTE: ',0,0,'L',1);
$pdf->SetFont('Arial','',10);
$pdf->cell(165,5,''.substr(ucwords(strtolower($_POST[ntercero])),0,100),0,0,'L',1);


$pdf->SetY(60); 
$pdf->cell(0.2);  
$pdf->SetFillColor(245,245,245);
$pdf->SetFont('Arial','B',10);
$pdf->cell(29,5,'C.C. o NIT: ',0,0,'L',1);
$pdf->SetFont('Arial','',10);
$pdf->cell(165.5,5,''.$_POST[tercero],0,0,'L',1);

$pdf->SetY(65); 
$pdf->cell(0.2);  
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->cell(29,5,'LA SUMA DE: ',0,0,'L',1);
$pdf->SetFont('Arial','',8);
$pdf->cell(165,5,''.$_POST[letras],0,0,'L',1);

$pdf->SetY(70);
$pdf->cell(0.2);   
$pdf->SetFillColor(245,245,245);
$pdf->cell(0.01);
$pdf->SetFont('Arial','B',10);

$pdf->RoundedRect(10, 54 ,195 , 18, 2,'' );

$pdf->ln(4);	
$pdf->cell(156,5,'DESCRIPCION ','B',0,'C',0);
$pdf->cell(39,5,'VALOR ','LB',1,'C',0);
$pdf->ln(1);
$pdf->cell(0.1);
$pdf->SetFont('Arial','I',10);
$con=0;
//while ($con<<count($_POST[balan]))

$pdf->SetFillColor(245,245,245);
if(!$_POST[codcatastral])
{
	$_POST[codcatastral] = buscarCodigoCatastralAbono($_POST[compcont]);
}
$pdf->Cell(156,4,'ACUERDO DE PAGO NUMERO '.$_POST[compcont]." - CODIGO CATASTRAL, ".$_POST[codcatastral],0,0,'L',1);//descrip
$pdf->Cell(39,4,''.number_format($_POST[valorecaudo],2),0,0,'R',1);
    
$pdf->ln(8);  
$niy=$pdf->Gety();
$pdf->RoundedRect(10, 73 ,195 ,$niy-73 , 2,'' );
$pdf->SetFont('Arial','B',7);
	$pdf->ln(30);
	$pdf->cell(60);
	$pdf->Cell(80,5,'RECIBIDO Y SELLO','T',0,'C');


$pdf->sety(78);

$ny=$niy-78;
$pdf->cell(156,$niy-78,'',0,0);
$pdf->cell(39,$niy-78,'','L',0);



//********************************************************************************************************************************
	//$pdf->SetY(77); //**********CUADRO
    //$pdf->Cell(5);
   // $pdf->Cell(185,44,'',1,0,'R');

//***********************************************************************************************************************************************
//************************************************************************************************************************************************
	
//**********************************************************************************************************
$pdf->Output();
?> 


