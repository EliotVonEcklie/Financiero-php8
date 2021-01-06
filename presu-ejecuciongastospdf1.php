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
		$this->Cell(270,5,''.$rs,0,0,'C'); 
		//*****************************************************************************************************************************
		$this->SetFont('dejavusans','B',12);
		$this->SetY(10);
		$this->Cell(270,20,'SECRETARÍA DE HACIENDA MUNICIPAL',0,0,'C'); 
		$this->SetFont('dejavusans','B',10);
		$this->SetY(15);
		$this->Cell(270,20,'PRESUPUESTO',0,0,'C'); 
		$this->SetY(20);
		ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
		$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
		ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
		$fechaf2=$fecha[3]."-".$fecha[2]."-".$fecha[1];	
		$this->Cell(270,20,'EJECUCION DE GASTOS DEL '.$fechaf.' AL '.$fechaf2,0,0,'C'); 
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
		$this->Cell(20,4,'CUENTA',0,0,'C');
		$this->Cell(25,4,'NOMBRE',0,0,'C');
		$this->Cell(20,4,'PRES.INI DEB',0,0,'C');
		$this->Cell(20,4,'PRES.INI CRED',0,0,'C');
		$this->Cell(20,4,'ADICION',0,0,'C');
		$this->Cell(20,4,'REDUC.',0,0,'C');
		$this->Cell(20,4,'CDP DEB',0,0,'C');
		$this->Cell(20,4,'CDP CRED',0,0,'C');
		$this->Cell(20,4,'COMPR. DEB',0,0,'C');
		$this->Cell(20,4,'COMPR. CRED',0,0,'C');
		$this->Cell(20,4,'OBLIG. DEB',0,0,'C');
		$this->Cell(20,4,'OBLIG. CRE',0,0,'C');
		$this->Cell(20,4,'PAGOS DEB',0,0,'C');
		$this->Cell(20,4,'PAGOS CRED',0,0,'C');
		$this->Cell(10,4,'%',0,0,'C');
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
$sumacdp=0;
$sumarp=0;	
$sumaop=0;	
$sumap=0;			
$sumai=0;
$sumapi=0;				
$sumapad=0;	
$sumapred=0;	
$sumapcr=0;	
$sumapccr=0;						
$pdf->SetFont('dejavusans','',5);
for($x=0;$x<count($_POST[cuenta]);$x++)
{		 		
	// $sumapcr+=$_POST[pcrcuenta][$x];
	// $sumapccr+=$_POST[pccrcuenta][$x];
	// $sumapred+=$_POST[predcuenta][$x];
	// $sumapad+=$_POST[padcuenta][$x];
	// $sumapi+=$_POST[picuenta][$x];
	// $sumai+=$_POST[pdefcuenta][$x]; 
	// $sumacdp+=$_POST[cdpcuenta][$x];
	// $sumarp+=$_POST[rpcuenta][$x];
	// $sumaop+=$_POST[opcuenta][$x];
	// $sumap+=$_POST[pgcuenta][$x];
	// $sumasaldo+=$_POST[saldocuenta][$x];

	$pdf->Cell(20,4,$_POST[cuenta][$x],0,0,'L');
	$pdf->Cell(25,4,substr($_POST[nombre][$x],0,17),0,0,'L');
	$pdf->Cell(20,4,number_format($_POST[pid][$x],2,',','.'),0,0,'R');
	$pdf->Cell(20,4,number_format($_POST[pic][$x],2,',','.'),0,0,'R');
	$pdf->Cell(20,4,number_format($_POST[adc][$x],2,',','.'),0,0,'R');
	$pdf->Cell(20,4,number_format($_POST[red][$x],2,',','.'),0,0,'R');
	$pdf->Cell(20,4,number_format($_POST[cdpd][$x],2,',','.'),0,0,'R');
	$pdf->Cell(20,4,number_format($_POST[cdpc][$x],2,',','.'),0,0,'R');
	$pdf->Cell(20,4,number_format($_POST[rpd][$x],2,',','.'),0,0,'R');
	$pdf->Cell(20,4,number_format($_POST[rpc][$x],2,',','.'),0,0,'R');
	$pdf->Cell(20,4,number_format($_POST[cxpd][$x],2,',','.'),0,0,'R');
	$pdf->Cell(20,4,number_format($_POST[cxpc][$x],2,',','.'),0,0,'R');
	$pdf->Cell(20,4,number_format($_POST[egd][$x],2,',','.'),0,0,'R');
	$pdf->Cell(20,4,number_format($_POST[egc][$x],2,',','.'),0,0,'R');
	$pdf->Cell(10,4,$_POST[psaldocuenta][$x],0,1,'C');

}

$pdf->Ln(2);

$pdf->SetFont('dejavusans','',5);
$psumasaldo=round(($sumacdp/$sumai)*100,2);
$pdf->SetFillColor(150,150,150);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(50,4,'TOTALES',0,0,'C',1);
$pdf->Cell(20,4,number_format($sumapi,2,",","."),0,0,'R',1);
$pdf->Cell(20,4,number_format($sumapad,2,",","."),0,0,'R',1);
$pdf->Cell(20,4,number_format($sumapred,2,",","."),0,0,'R',1);
$pdf->Cell(20,4,number_format($sumapcr,2,",","."),0,0,'R',1);
$pdf->Cell(20,4,number_format($sumapccr,2,",","."),0,0,'R',1);
$pdf->Cell(20,4,number_format($sumai,2,",","."),0,0,'R',1);
$pdf->Cell(20,4,number_format($sumacdp,2,",","."),0,0,'R',1);
$pdf->Cell(20,4,number_format($sumarp,2,",","."),0,0,'R',1);
$pdf->Cell(20,4,number_format($sumaop,2,",","."),0,0,'R',1);
$pdf->Cell(20,4,number_format($sumap,2,",","."),0,0,'R',1);
$pdf->Cell(20,4,number_format($sumasaldo,2,",","."),0,0,'R',1);
$pdf->Cell(10,4,$psumasaldo,0,0,'C',1);
 
//printf($ftn,'','TOTALES',number_format($sumapi,2,",",""),number_format($sumapad,2,",",""),number_format($sumapred,2,",",""),number_format($sumapcr,2,",",""),number_format($sumapccr,2,",",""),number_format($sumai,2,",",""),number_format($sumacdp,2,",",""),number_format($sumarp,2,",",""),number_format($sumaop,2,",",""),number_format($compeje,2,",",""),number_format($sumap,2,",",""),number_format($cxxp,2,",",""),'');






$pdf->Output();

?> 


	