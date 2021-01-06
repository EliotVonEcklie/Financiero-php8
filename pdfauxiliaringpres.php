<?php
//V 1000 12/12/16 
require_once('tcpdf/tcpdf.php');
require('comun.inc');
require('funciones.inc');
session_start();
date_default_timezone_set("America/Bogota");

//*****las variables con los contenidos***********
//**********pdf*******
class MYPDF extends TCPDF {
	//Cabecera de página
	public function Header() {
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
		$this->Image('imagenes/eng.jpg',15,10,25,25);
		$this->SetFont('dejavusans','B',18);
		$this->SetY(10);
		$this->Cell(270,5,''.$rs,0,0,'C'); 
		//*****************************************************************************************************************************
		$this->SetFont('dejavusans','B',12);
		$this->SetY(10);
		$this->Cell(270,20,'SECRETARÍA DE HACIENDA MUNICIPAL',0,0,'C'); 
		$this->SetFont('dejavusans','B',10);
		$this->SetY(15);
		ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
		$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
		ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
		$fechaf2=$fecha[3]."-".$fecha[2]."-".$fecha[1];	
		$this->Cell(270,20,'AUXILIAR CUENTA PRESUPUESTAL DEL '.$fechaf.' AL '.$fechaf2,0,0,'C'); 
		$this->SetY(20);
		$this->Cell(270,20,$_POST[cuenta].' - '.trim($_POST[ncuenta]),0,0,'C'); 
		//encabezado ppto
		$this->SetFont('dejavusans','',6);
		$this->RoundedRect(10, 36, 280, 8, 1.2, '1111', '');
		$this->SetY(36.5);
		$this->SetX(10.6);
		$this->SetFillColor(150,150,150);
		$this->SetTextColor(255,255,255);
		$this->Cell(279,6.8,'',0,0,'C',1);
		$this->SetY(38);
		$this->SetFont('dejavusans','',7);
		$this->Cell(30,4,'FECHA',0,0,'C');
		$this->Cell(50,4,'TIPO DE COMPROBANTE',0,0,'C');
		$this->Cell(20,4,'No. DE COMPROBANTE',0,0,'C');
		$this->Cell(40,4,'No. DE LIQUIDACION',0,0,'C');
		$this->Cell(100,4,'DETALLE',0,0,'C');
		$this->Cell(40,4,'VALOR',0,0,'C');
	//************************	***********************************************************************************************************
	}
//Pie de página
	public function Footer() {
		$this->SetY(-15);
		$this->SetFont('dejavusans','I',10);
		$this->Cell(0, 10, 'Pagina '.$this->getAliasNumPage().' de '.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
	}
}
//Creación del objeto de la clase heredada
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetMargins('11', '45', PDF_MARGIN_RIGHT);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->AddPage('L');
$pdf->SetFont('dejavusans','',8);
$pdf->SetY(50);   
$con=0;
$control=52;
$ct=1;	
$tipor=array('','Predial','Industria y Comercio','Otros Recaudos');
$total=0;
while ($con<count($_POST[nrec]))
{	if ($con%2==0)
	{$pdf->SetFillColor(255,255,255);
	}
    else
	{$pdf->SetFillColor(245,245,245);
	}
	if($_POST[nrec][$con]=="**"){
		$pdf->Cell(30,4,'',0,0,'C',1);//descrip
		$pdf->Cell(50,4,utf8_decode(substr(''.$_POST[tiporec][$con],0,50)),0,0,'C',1);//descrip
		$pdf->Cell(20,4,'',0,0,'C',1);//descrip
		$pdf->Cell(40,4,'',0,0,'C',1);//descrip
		$pdf->Cell(100,4,'',0,0,'L',1);//descrip
		$pdf->Cell(40,4,''.number_format($_POST[entrada][ $con],2),0,0,'R',1);//descrip
		$pdf->ln(4);
		
	}else{
		if(($_POST[tliq][$con]!="")&&($_POST[nliq][$con]!=""))
		$tpliq=$_POST[tliq][$con].' - '.$_POST[nliq][$con];
		else
			$tpliq='';
		$pdf->Cell(30,4,''.$_POST[fecrec][$con],0,0,'C',1);//descrip
		$pdf->Cell(50,4,utf8_decode(substr(''.$_POST[tiporec][$con],0,50)),0,0,'C',1);//descrip
		$pdf->Cell(20,4,''.$_POST[nrec][$con],0,0,'C',1);//descrip
		$pdf->Cell(40,4,''.$_POST[nliq][$con],0,0,'C',1);//descrip
		$pdf->Cell(100,4,''.$_POST[tliq][$con],0,0,'L',1);//descrip
		$pdf->Cell(40,4,''.number_format($_POST[entrada][$con],2),0,0,'R',1);//descrip
		$pdf->ln(4);
		$total+=$_POST[entrada][$con];
	}
	
		
$con=$con+1;
$ct=$ct+1;
if ($ct%$control==0)
		{		
		$pdf->line(10.1,258.3,209,258.3);
		}
}
$pdf->ln(6);	
$pdf->SetFont('Times','B',10);
$pdf->Cell(180,5,'TOTAL INGRESOS:','T',0,'R');
$pdf->Cell(80,5,' $'.number_format($total,2,".",","),'T',0,'R');
$pdf->Output();
?> 


