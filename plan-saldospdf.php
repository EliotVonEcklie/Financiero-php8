<?php //V 1001 20/12/16 Modificado implementacion de Reversion?> 
<?php //V 1000 12/12/16 ?> 
<?php
require('comun.inc');
require_once('tcpdf/tcpdf.php');
//session_start();
//****2016-03-01 jair castañeda cobro recibo
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
		$this->Cell(200,5,''.$rs,0,0,'C'); 
		//*****************************************************************************************************************************
		$this->SetFont('dejavusans','B',12);
		$this->SetY(10);
		$this->Cell(200,20,'SECRETARÍA DE HACIENDA MUNICIPAL',0,0,'C'); 
		$this->SetFont('dejavusans','B',10);
		$this->SetY(15);
		$this->Cell(200,20,'PRESUPUESTO',0,0,'C'); 
		$this->SetY(20);
		ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
		$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
		ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
		$fechaf2=$fecha[3]."-".$fecha[2]."-".$fecha[1];	
		$this->Cell(200,20,'SALDOS PRESUPUESTALES DEL '.$fechaf.' AL '.$fechaf2,0,0,'C'); 
		//encabezado ppto
		$this->SetFont('dejavusans','',6);
		$this->RoundedRect(10, 36, 180, 8, 1.2, '1111', '');
		$this->SetY(36.5);
		$this->SetX(10.6);
		$this->SetFillColor(150,150,150);
		$this->SetTextColor(255,255,255);
		$this->Cell(179,6.8,'',0,0,'C',1);
		$this->SetY(38);
		$this->SetFont('dejavusans','',7);
		$this->Cell(20,4,'CUENTA',0,0,'C');
		$this->Cell(50,4,'NOMBRE',0,0,'C');
		$this->Cell(65,4,'FUENTES',0,0,'C');
		$this->Cell(40,4,'SALDO',0,0,'C');
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

$pdf->AddPage();						
$pdf->SetFont('dejavusans','',8);
for($x=0;$x<count($_POST[cuenta]);$x++)
{		 		
	$sumasaldo+=$_POST[saldos][$x];

	$pdf->Cell(37,4,utf8_decode($_POST[cuenta][$x]),0,0,'L');
	$pdf->Cell(35,4,utf8_decode(substr($_POST[nombre][$x],0,20)),0,0,'L');
	$pdf->Cell(65,4,substr($_POST[fuente][$x],0,20),0,0,'C');
	$pdf->Cell(40,4,'$ '.number_format($_POST[saldos][$x],2,',','.'),0,0,'R');
	$pdf->Ln();
}

$pdf->Ln(2);

$pdf->SetFont('dejavusans','',7);
$pdf->SetFillColor(150,150,150);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(50,4,'TOTAL',0,0,'C',1);
$pdf->Cell(20,4,number_format($sumasaldo,2,",","."),0,0,'R',1);

$pdf->Output();

?> 


	