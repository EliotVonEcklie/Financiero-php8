<?php
//V 1000 12/12/16 
//include 'comun.inc';
//ob_end_clean();
require('fpdf.php');
require 'comun.inc';
//session_start();
//date_default_timezone_set("America/Bogota");
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
    $this->Cell(149,21,'CONCILIACION BANCARIA',0,1,'C'); 
    $this->SetFont('Arial','B',10);
	$this->SetY(25);
    $this->Cell(54);
	$this->Cell(135,5,'Cuenta: '.$_POST[cuenta].' - '.$_POST[nbanco].' '.$_POST[cb],0,0,'C');
	$this->SetY(31);
    $this->Cell(54);
	$this->Cell(135,5,'Desde: '.$_POST[fecha].' Hasta:'.$_POST[fecha2],0,0,'C');
	$this->SetFillColor(245,245,245);
	$this->SetY(45);
	
	$this->SetFont('Arial','B',9);
    $this->Cell(0.1);
	$this->Cell(24,5,'Saldo Inicial:',0,0,'L',1);
    $this->SetFont('Arial','',8);
	$this->Cell(45,6,'$ '.number_format($_POST[saldoini],2),0,0,'L',0);
	$this->SetFont('Arial','B',9);
	$this->Cell(24,5,'(-)Debitos C:',0,0,'L',1);
    $this->SetFont('Arial','',8);
	$this->Cell(35,6,'$ '.number_format($_POST[cdebitos],2,".",","),0,0,'L',0);
    $this->SetFont('Arial','B',9);
	$this->Cell(24,5,'(+)Creditos C:',0,0,'L',1);
    $this->SetFont('Arial','',8);	
	$this->Cell(35,6,'$ '.number_format($_POST[ccreditos],2,".",","),0,1,'L',0);
	
	
	$this->SetFont('Arial','B',9);
	$this->Cell(24,5,'Saldo Final:',0,0,'L',1);
    $this->SetFont('Arial','',8);
	 $this->Cell(0.1);
	$this->Cell(45,6,'$ '.number_format($_POST[saldofin],2),0,0,'L',0);
	$this->SetFont('Arial','B',9);
	$this->Cell(24,5,'(-)Debitos NC:',0,0,'L',1);
    $this->SetFont('Arial','',8);
	$this->Cell(35,6,'$ '.number_format($_POST[debnc],2,".",","),0,0,'L',0);
    $this->SetFont('Arial','B',9);
	$this->Cell(24,5,'(+)Creditos NC:',0,0,'L',1);
    $this->SetFont('Arial','',8);	
	$this->Cell(35,6,'$ '.number_format($_POST[crednc],2,".",","),0,1,'L',0);

	$this->SetFont('Arial','B',9);
	$this->Cell(30,5,'Extracto digitado:',0,0,'L',1);
    $this->SetFont('Arial','',8);
	 $this->Cell(0.1);
	$this->Cell(39,6,'$ '.number_format($_POST[extractofis],2),0,0,'L',0);
	$this->SetFont('Arial','B',9);
	$this->Cell(32,5,'Extracto Calculado:',0,0,'L',1);
    $this->SetFont('Arial','',8);
	$this->Cell(35,6,'$ '.number_format($_POST[extracto],2,".",","),0,0,'L',0);

	$this->ln(10);	
//********************************************************************************************************************************
	$this->line(10.1,69,209,69);
	$this->RoundedRect(10,70, 199, 5, 1.2,'' );	
	$this->SetFont('Arial','B',10);
	$this->SetY(70);
    $this->Cell(0.1);
    $this->Cell(12,5,'Id',0,0,'C'); 
	$this->SetY(70);
    $this->Cell(15.1);
    $this->Cell(10,5,'Fecha',0,0,'C'); 
		$this->SetY(70);
    	$this->Cell(28.1);
		$this->Cell(50,5,'Documento',0,0,'C');
	$this->SetY(70);
    	$this->Cell(72.1);
		$this->Cell(50,5,'Tercero',0,0,'C');		
			$this->SetY(70);
        	$this->Cell(125.1);
			$this->Cell(20,5,'Cheque',0,0,'C');
			$this->SetY(70);
        	$this->Cell(146.1);
			$this->Cell(31,5,'Debitos',0,1,'C');
			$this->SetY(70);
        	$this->Cell(175.1);
			$this->Cell(31,5,'Creditos',0,1,'C');
			$this->line(10.1,76,209,76);
			$this->ln(8);
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
//require('comun.inc');
$pdf->SetFont('Times','',8);


$pdf->SetAutoPageBreak(true,20);

$pdf->SetY(78);   
$con=0;
//while ($con<15)
for($y=0;$y<count($_POST[detalles]);$y++)
	 {	
  $ch=esta_en_array($_POST[conciliados], $_POST[detalles][$y]);
	 if($ch!=1)
	  {
	if ($con%2==0)
	{$pdf->SetFillColor(255,255,255);
	}
    else
	{$pdf->SetFillColor(245,245,245);
	}	
    $pdf->Cell(12,4,''.$_POST[detalles][$con],0,0,'L',1);//descrip
    $pdf->Cell(18,4,''.$_POST[dfechas][$con],0,0,'L',1);//descrip
    $pdf->Cell(55,4,''.substr($_POST[ncompro][$con],0,30).' '.$_POST[compro2][$con],0,0,'L',1);//descrip
    $pdf->Cell(45,4,substr(''.$_POST[dterceros][$con],0,20),0,0,'L',1);//descrip
	$pdf->Cell(10,4,''.$_POST[dcheques][$con],0,0,'R',1);//descrip
    $pdf->Cell(30,4,''.number_format($_POST[debitos][$con],2),0,0,'R',1);//descrip
    $pdf->Cell(30,4,''.number_format($_POST[creditos][$con],2),0,0,'R',1);//descrip
	$pdf->ln(4);	
  }
$con=$con+1;
}
	$pdf->ln(4);	
$pdf->SetFont('Times','B',10);

$pdf->Cell(138,5,'Total','T',0,'R');
$pdf->Cell(32,5,''.number_format($_POST[debnc],2,".",","),'T',0,'R');
$pdf->Cell(30,5,''.number_format($_POST[crednc],2,".",","),'T',0,'R');
$pdf->ln(10);
	$v=$pdf->gety();
	$x=$pdf->getx();
	$pdf->cell(1);
	$pdf->Cell(54,8,''.iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_SESSION[usuario]),'B',0,'L');	
	$pdf->cell(46.5);
	$pdf->Cell(58,8,'','B',0,'L');
	$pdf->ln(8);
	$pdf->Cell(100,5,'ELABORO ',0,0,'L');
	$pdf->Cell(66,5,'REVISO ',0,0,'L');
	$pdf->SetLineWidth(0.4);	
	
		
$pdf->Output();
?>