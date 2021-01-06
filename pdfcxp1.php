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
if ($_POST[estadoc]=='N'){
		    $this->Image('imagenes/anulado.jpg',30,15,150,80);
	}
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
  /*$rs="Municipio de Cubarral";
 $nit="892000812-0";
 $nalca="RIVERA RINCON JAIRO ";*/
     //Parte Izquierda
    $this->Image('imagenes/eng.jpg',23,10,25,25);
	$this->SetFont('Arial','B',8);
	$this->SetY(10);
	$this->RoundedRect(10, 10, 199, 31, 1,'' );
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
    $this->Cell(149,20,'LIQUIDACION CUENTA X PAGAR',0,0,'C'); 
	//************************************
    $this->SetFont('Arial','I',7);
	
	$this->SetY(27);
	$this->Cell(50.2);
	$this->multiCell(110.7,3,''.strtoupper($_POST[detallegreso]),'T','L');
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
	$this->Cell(35,5,'VIGENCIA: '.$_POST[vigencia],0,0,'L');

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

$pdf->SetFont('Arial','B',12);
//$pdf->SetFillColor(255,255,153);				
$pdf->SetY(46);   
$pdf->cell(125);
$pdf->cell(27,8,'NETO A PAGAR: ',0,0,'R');
$pdf->RoundedRect(161, 46 ,48, 8, 1,'');
$pdf->cell(45,8,'$'.number_format($_POST[valorcheque],2),0,'C');

$pdf->ln(10);

$pdf->SetFillColor(255,255,255);
$pdf->cell(0.2);
$pdf->SetFont('Arial','B',10);
$pdf->cell(35,5,'Beneficiario: ',0,0,'L',0);
$pdf->SetFont('Arial','',10);
$pdf->cell(165,5,''.substr(ucwords(strtolower($_POST[ntercero])),0,100),0,1,'L',0);

$pdf->cell(0.2);  
$pdf->SetFillColor(245,245,245);
$pdf->SetFont('Arial','B',10);
$pdf->cell(35,5,'C.C. o NIT: ',0,0,'L',0);
$pdf->SetFont('Arial','',10);
$pdf->cell(163,5,''.$_POST[tercero],0,1,'L',0);

$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->cell(0.2);
$pdf->cell(35,5,'Registro:',0,0,'L',0);
$pdf->SetFont('Arial','',10);
$pdf->cell(40,5,''.$_POST[rp],0,0,'L',0);
$pdf->SetFont('Arial','B',10);
$pdf->cell(15,5,'Detalle: ',0,0,'L',0);
$pdf->SetFont('Arial','',10);
$pdf->cell(20,5,''.substr(ucwords(strtolower($_POST[detallecdp])),0,60),0,1,'L',0);

$pdf->SetFillColor(245,245,245);
$pdf->SetFont('Arial','B',10);
$pdf->cell(0.2);
$pdf->cell(20,5,'Valor Pago:',0,0,'L',0);
$pdf->SetFont('Arial','',10);
$pdf->cell(35,5,'$'.number_format($_POST[valor],2),0,0,'L',0);
$pdf->SetFont('Arial','B',10);
$pdf->cell(22,5,'Retenciones: ',0,0,'L',0);
$pdf->SetFont('Arial','',10);
$pdf->cell(35,5,'$'.number_format($_POST[valorretencion],2),0,0,'L',0);
$pdf->SetFont('Arial','B',10);
$pdf->cell(16,5,'Base Ret:',0,0,'L',0);
$pdf->SetFont('Arial','',10);
$pdf->cell(38,5,'$'.number_format($_POST[base],2),0,0,'L',0);
$pdf->SetFont('Arial','B',10);
$pdf->cell(6,5,'Iva:',0,0,'L',0);
$pdf->SetFont('Arial','',10);
$pdf->cell(38,5,'$'.number_format($_POST[iva],2),0,1,'L',0);
$pdf->RoundedRect(10, 54 ,199 , 23, 1,'' );
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
    $pdf->Cell(22,5,'Cuenta',0,0,'C',1); 
		$pdf->SetY($y);
    	$pdf->Cell(23.1);
		$pdf->Cell(80,5,'Nombre',0,0,'C',1);
		$pdf->SetY($y);
       	$pdf->Cell(104.1);
		$pdf->Cell(50,5,'Recurso',0,0,'C',1);
		$pdf->SetY($y);
       	$pdf->Cell(155);
		$pdf->Cell(44,5,'Valor',0,0,'C',1);

$pdf->SetFont('Arial','',8);
	 	$cont=0;
			 $pdf->ln(5); 
			 
			 for($x=0;$x<count($_POST[dcuentas]);$x++)
	 {	
	 
		  if($_POST[dvalores][$x]>0)
		   {
	  if ($con%2==0)
	  {$pdf->SetFillColor(255,255,255);
	  }
      else
	  {$pdf->SetFillColor(245,245,245);
	  }
		$pdf->Cell(22,4,''.$_POST[dcuentas][$x],'',0,'C',1);
		$pdf->Cell(82,4,''.$_POST[dncuentas][$x],'',0,'L',1);
		$pdf->Cell(51,4,''.substr($_POST[dnrecursos][$x],0,29).'','',0,'L',1);		
		$pdf->Cell(44,4,'$'.number_format($_POST[dvalores][$x],2),'',1,'R',1);				
		$con=$con+1;
		   }
	 }
	 /*
 for($y=0;$y<count($_POST[rubros]);$y++)
	 {	 
	 }*/
$pdf->ln(8);

$y=$pdf->GetY();	
	$pdf->SetY($y);
$pdf->SetFillColor(222,222,222);
$pdf->SetFont('Arial','B',10);
    $pdf->Cell(0.1);
    $pdf->Cell(199,5,'RETENCIONES',0,0,'C',1); 
 $pdf->ln(6); 

	 $y=$pdf->GetY();	
	$pdf->SetFillColor(222,222,222);
	$pdf->SetFont('Arial','B',10);
	$pdf->SetY($y);
    $pdf->Cell(0.1);
    $pdf->Cell(22,5,'Codigo ',0,0,'C',1); 
		$pdf->SetY($y);
    	$pdf->Cell(23.1);
		$pdf->Cell(110,5,'Retencion',0,0,'C',1);
		$pdf->SetY($y);
       	$pdf->Cell(134.1);
		$pdf->Cell(20,5,'Porcentaje',0,0,'C',1);
		$pdf->SetY($y);
       	$pdf->Cell(155);
		$pdf->Cell(44,5,'Valor',0,0,'C',1);

$pdf->SetFont('Arial','',8);
	 	$cont=0;
			 $pdf->ln(5); 
 for($x=0;$x<count($_POST[ddescuentos]);$x++)
	 {	
	  if ($con%2==0)
	  {$pdf->SetFillColor(255,255,255);
	  }
      else
	  {$pdf->SetFillColor(245,245,245);
	  }
		$pdf->Cell(22,4,''.$_POST[ddescuentos][$x],'',0,'C',1);
		$pdf->Cell(110,4,''.$_POST[dndescuentos][$x],'',0,'L',1);
		$pdf->Cell(20,4,''.$_POST[dporcentajes][$x].'%','',0,'R',1);		
		$pdf->Cell(47,4,'$'.number_format($_POST[ddesvalores][$x],2),'',1,'R',1);				
		$con=$con+1;
	 }

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
$sqlr="select *from  tesoparametros where estado='S'";
//echo $sqlr;
$res=mysql_query($sqlr,$linkbd);
while($row=mysql_fetch_row($res))
 {
  //$ppto=$row[0];
  $teso=$row[4];
 }
/* $rs="Municipio de Cubarral";
 $nit="892000812-0";
 $nalca="RIVERA RINCON JAIRO ";*/
$pdf->ln(28);
	$pdf->SetFont('times','B',9);
	$pdf->Cell(50);	
	$pdf->Cell(80,4,strtoupper($nalca),'T',1,'C');
	$pdf->Cell(50);
	$pdf->Cell(80,4,'ALCALDE '.strtoupper($rs),'',1,'C');

$pdf->ln(18);
	$pdf->SetFont('times','B',9);
	$pdf->Cell(50);
	$pdf->Cell(80,4,''.strtoupper($teso),'T',1,'C');
	$pdf->Cell(50);
	$pdf->Cell(80,4,'JEFE TESORERIA','',1,'C');

	$sqlrt="SELECT impbeneficiario FROM tesoparametros";
	$rowt=mysql_fetch_row(mysql_query($sqlrt,$linkbd));
	if ($rowt[0]=="S")
	{
		$pdf->ln(18);
		$pdf->Cell(50);
		$pdf->SetFont('times','B',9);
		$pdf->Cell(80,4,''.strtoupper($_POST[ntercero]).' CC/NIT '.$_POST[tercero],'T',1,'C');
		$pdf->Cell(50);
		$pdf->SetFont('times','B',9);
		$pdf->Cell(80,4,'BENEFICIARIO','',1,'C');
	}

$pdf->Output();
?> 


