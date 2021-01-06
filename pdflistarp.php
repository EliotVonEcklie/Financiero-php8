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
    $this->Cell(149,20,'LISTADO REGISTROS PRESUPUESTALES',0,0,'C'); 
	//************************************
    $this->SetFont('Arial','B',10);
	
	$this->SetY(27);
	$this->Cell(50.2);
	$this->multiCell(110.7,7,'PERIODO: '.$_POST[fechaini].' al '.$_POST[fechafin],'T','L');
	
	$this->SetY(27);
    $this->Cell(161.1);
	$this->Cell(37.8,14,'','TL',0,'L');
	
	$this->SetY(28.5);
    $this->Cell(161);
	$this->Cell(38,5,'VIGENCIA','B',0,'C');
	
	$this->SetY(34.5);
    $this->Cell(161);
	$this->Cell(38,5,''.$_POST[vigencia],'0',0,'C');
	
	//$this->SetY(35.5);
    //$this->Cell(162);
	//$this->Cell(35,5,'FECHA: '.$_POST[fecha],0,0,'L');

	$this->SetY(27);
	$this->Cell(50.2);

	$this->MultiCell(105.7,4,'',0,'L');		
	

	
//********************************************************************************************************************************
//	$this->line(10.1,42,209,42);
//	$this->RoundedRect(10,42.7, 199, 4, 1.2,'' );
	$this->SetFont('times','B',10);
//	$this->SetY(42.5);
 //   $this->Cell(0.1);
//	$this->Cell(199,5,'IDENTIFICACION DEL PREDIO',0,1,'C');
    
	
			
			
	//		$this->SetY(48);
     //   	$this->Cell(101);
///			$this->Cell(36,5,'DETALLE',0,1,'C');
//			$this->SetY(48);
//        	$this->Cell(96.5);
//			$this->Cell(5,5,'C.C.',0,1,'C');
//			$this->SetY(48);
 //       	$this->Cell(137);
			
//			$this->Cell(31,5,'DEBITO',0,1,'C');
//			$this->SetY(48);
 //       	$this->Cell(168);
//			$this->Cell(31,5,'CREDITO',0,1,'C');
			//$this->line(10.1,49,209,49);
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
	$pdf->ln(4);
	$pdf->SetFont('arial','B',14);
	$pdf->Cell(199,4,'LISTADO RP',0,0,'C');
 $pdf->ln(8); 
	 $y=$pdf->GetY();	
	$pdf->SetFillColor(222,222,222);
	$pdf->SetFont('Arial','B',8);
	$pdf->SetY($y);
    $pdf->Cell(0.1);
    $pdf->Cell(8,5,'VIG.',0,0,'C',1); 
	$pdf->SetY($y);
    	$pdf->Cell(8.6);
		$pdf->Cell(10,5,'RP',0,0,'C',1);	
		$pdf->SetY($y);
    	$pdf->Cell(18.9);
		$pdf->Cell(10,5,'CDP',0,0,'C',1);
		$pdf->SetY($y);
    	$pdf->Cell(29.1);
		$pdf->Cell(60,5,'OBJETO',0,0,'C',1);
		$pdf->SetY($y);
    	$pdf->Cell(89.7);
		$pdf->Cell(45,5,'TERCERO',0,0,'C',1);
		$pdf->SetY($y);
    	$pdf->Cell(135.0);
		$pdf->Cell(22.3,5,'VALOR',0,0,'C',1);
		$pdf->SetY($y);
       	$pdf->Cell(157.8);
		$pdf->Cell(12,5,'FECHA',0,0,'C',1);
		$pdf->SetY($y);
    	$pdf->Cell(170.2);
		$pdf->Cell(16,5,'CONTRATO',0,0,'C',1);		
		$pdf->SetY($y);
    	$pdf->Cell(186.7);
		$pdf->Cell(12,5,'ESTADO',0,0,'C',1);		
$pdf->SetFont('Arial','',8);
	 	$cont=0;
			 $pdf->ln(5); 
			 $suming=0;
			 	$pdf->SetFont('Arial','',7);
 for($x=0;$x<count($_POST[vigencias]);$x++)
	 {	
	  if ($con%2==0)
	  {$pdf->SetFillColor(255,255,255);
	  }
      else
	  {$pdf->SetFillColor(245,245,245);
	  }
		$pdf->Cell(10,4,''.$_POST[vigencias][$x],'',0,'C',1);
		$pdf->Cell(8,4,''.$_POST[rps][$x],'',0,'C',1);
		$pdf->Cell(10,4,''.$_POST[cdps][$x],'',0,'C',1);
		$pdf->Cell(61.4,4,''.substr($_POST[objetos][$x],0,40),'',0,'L',1);
		$pdf->Cell(45,4,''.substr($_POST[terceros][$x],0,60),'',0,'L',1);
		$pdf->Cell(23,4,''.number_format($_POST[valores][$x],2,",","."),'',0,'R',1);
		$pdf->Cell(13,4,''.$_POST[fechas][$x],'',0,'C',1);
		$pdf->Cell(12,4,''.$_POST[contratos][$x],'',0,'C',1);		
		$pdf->Cell(14,4,''.$_POST[estados][$x],'',1,'C',1);		
		$con=$con+1;
	}
	 $pdf->SetFillColor(245,245,245);

$pdf->Output();
?> 


