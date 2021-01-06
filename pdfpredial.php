<?php
//V 1000 12/12/16
require('comun.inc');
require_once('barras/tcpdf_include.php');
//session_start();
//****2016-03-01 jair casta�eda cobro recibo
   date_default_timezone_set("America/Bogota");
//*****las variables con los contenidos***********
//**********pdf*******
//$pdf=new FPDF('P','mm','Letter'); 

class MYPDF extends TCPDF 
{
	//Cabecera de p�gina
	public function Header() 
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
		$this->Image('imagenes/eng.jpg',15,10,25,25);
		$this->SetFont('dejavusans','B',18);
		$this->SetY(10);
		$this->Cell(190,5,''.$rs,0,0,'C'); 
		//*****************************************************************************************************************************
		$this->SetFont('dejavusans','B',12);
		$this->SetY(10);
		$this->Cell(190,20,utf8_encode('SECRETAR�A DE HACIENDA MUNICIPAL'),0,0,'C'); 
		$this->SetFont('dejavusans','B',10);
		$this->SetY(15);
		$this->Cell(190,20,utf8_encode('DIRECCI�N DE IMPUESTOS MUNICIPALES'),0,0,'C'); 
		$this->SetY(20);
		$this->Cell(190,20,utf8_encode('RECIBO DE COBRO'),0,0,'C'); 
		$this->SetY(25);
		$this->Cell(190,20,utf8_encode('IMPUESTO PREDIAL UNIFICADO'),0,0,'C'); 
		//************************************
		$this->SetY(28);
		$this->Cell(180,20,utf8_encode('Liquidaci�n No. ').$_POST[idpredial],0,0,'R'); 
		
//************************	***********************************************************************************************************
	}
//Pie de p�gina
	public function Footer() {
		$this->SetY(-10);
		$this->SetFont('dejavusans','I',10);
		$this->Cell(0, 10, 'Pagina '.$this->getAliasNumPage().' de '.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
	}
}

$linkbd=conectar_bd();
$sqlr="select *from configbasica where estado='S'";
$res=mysql_query($sqlr,$linkbd);
while($row=mysql_fetch_row($res))
{
	$nit=$row[0];
	$rs=$row[1];
}

$tam=strlen($_POST[idpredial]);
$ceros='';
for($i=$tam;$i<9;$i++){
	$ceros.='0';
}
$ean=$ceros.$_POST[idpredial].'001';

//Creaci�n del objeto de la clase heredada
//$pdf=new PDF('P','mm',array(210,140));
$pdf = new MYPDF('P', 'mm', 'A4', true, 'UTF-8', false);
//$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
//$pdf = new MYPDF('P','mm','Letter', true, 'iso-8859-1', false);// create new PDF document
$pdf->SetFooterMargin(10);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 10);

// set a barcode on the page footer
$pdf->setBarcode(date('Y-m-d H:i:s'));

// define barcode style
$style = array(
	'position' => 'C',
	'align' => 'C',
	'stretch' => false,
	'fitwidth' => true,
	'cellfitalign' => '',
	'border' => false,
	'hpadding' => 'auto',
	'vpadding' => 'auto',
	'fgcolor' => array(0,0,0),
	'bgcolor' => false, //array(255,255,255),
	'text' => false,
	'font' => 'helvetica',
	'fontsize' => 8,
	'stretchtext' => 1
);
$pdf->AddPage();

//********************************************************************************************************************************
$linkbd=conectar_bd();
$sqlr="SELECT codigo FROM codigosbarras WHERE estado='S' AND tipo='01'";
$res=mysql_query($sqlr,$linkbd);
$row=mysql_fetch_row($res);

$fecdi=explode('/', $_POST[fecha]);
//$cod01="7709998803862";	//codigo GS1 Asignado
$cod01=$row[0];//codigo GS1 Asignado
$cod02="01"; //codigo tipo recaudo
$cod03=str_pad($_POST[idpredial],7,"0", STR_PAD_LEFT);//Numero Liquidacion
//$cod04="$fecdi[0]$fecdi[1]".substr($fecdi[2],-2);//fecha de Liquidacion
$cod04=""; 
$cod05=str_pad("11100501",9,"0", STR_PAD_LEFT);//codigo cuenta bancaria
//$cod05="";
$cod06=str_pad($_POST[totliquida],10,"0", STR_PAD_LEFT);//total a pagar
$cod07="$fecdi[2]$fecdi[1]$fecdi[0]";//fecha limite
$codtotn="(415)$cod01(8020)$cod02$cod03$cod04$cod05(3900)$cod06(96)$cod07";
$codtot=chr(241)."415".$cod01."8020"."$cod02$cod03$cod04$cod05".chr(241)."3900".$cod06.chr(241)."96".$cod07;

$pdf->ln(5);
$pdf->RoundedRect(10, 41, 190, 24, 1.2, '1111', '');
$pdf->SetFont('dejavusans','',8);
$pdf->SetY(42);
$pdf->Cell(50,4,utf8_encode('C�DULA CATASTRAL'),0,0,'L');
$pdf->Line(58,41,58,53);
$pdf->Cell(90,4,utf8_encode('DIRECCI�N'),0,0,'L');
$pdf->Line(148,41,148,53);
$pdf->Cell(50,4,utf8_encode('VEREDA'),0,0,'L');
$pdf->SetY(47);
$pdf->Cell(50,4,$_POST[catastral],0,0,'L');
$pdf->Cell(90,4,substr(strtoupper($_POST[direccion]),0,80),0,0,'L');
$pdf->Cell(50,4,$_POST[vereda],0,0,'L');
$pdf->Line(10,53,200,53);
$pdf->SetY(54);
$pdf->Cell(80,4,utf8_encode('NOMBRE'),0,0,'L');
$pdf->Line(88,53,88,65);
$pdf->Cell(30,4,utf8_encode('C�DULA / NIT'),0,0,'L');
$pdf->Line(118,53,118,65);
$pdf->Cell(10,4,utf8_encode('HA'),0,0,'L');
$pdf->Line(128,53,128,65);
$pdf->Cell(10,4,utf8_encode('M2'),0,0,'L');
$pdf->Line(138,53,138,65);
$pdf->Cell(10,4,utf8_encode('AC'),0,0,'L');
$pdf->Line(148,53,148,65);
$pdf->Cell(50,4,utf8_encode('FECHA DE LIQUIDACI�N'),0,0,'L');
$pdf->SetY(59);
$pdf->Cell(80,4,utf8_encode(substr(strtoupper($_POST[ntercero]),0,50)),0,0,'L');
$pdf->Cell(30,4,$_POST[tercero],0,0,'L');
$pdf->Cell(10,4,$_POST[ha],0,0,'L');
$pdf->Cell(10,4,$_POST[mt2],0,0,'L');
$pdf->Cell(10,4,$_POST[areac],0,0,'L');

$pdf->Cell(50,4,$_POST[fecha],0,0,'L');

//detalle
$pdf->SetFont('dejavusans','',6);
$pdf->RoundedRect(10, 67, 190, 60, 1.2, '1111', '');
$pdf->SetY(67.5);
$pdf->SetX(10.6);
$pdf->SetFillColor(150,150,150);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(189,5,'',0,0,'C',1);
$avaluoi=0;
$tasai=0;
$impuestoi=0;
//HORIZONTAL
$pdf->Line(10,73,200,73);
if(count($_POST[dvalorAlumbrado])>0)
{
	//VERTICAL
	$pdf->Line(20,73,20,127);
	$pdf->Line(35,73,35,127);
	$pdf->Line(60,73,60,127);
	$avaluoi=21;
	$pdf->Line(70,73,70,127);
	$tasai=18;
	$pdf->Line(90,73,90,127);
	$impuestoi=12;
	$pdf->Line(105,73,105,127);
	$interesi = 10;
	$pdf->Line(122,73,122,127);
	$impuestoAmbi=20;
	$pdf->Line(135,73,135,127);
	$interesesAmbi=10;
	$pdf->Line(150,73,150,127);
	$bombei=17;
	$pdf->Line(166,73,166,127);
	$descuentoi=14;
	$pdf->Line(180,73,180,127);
	$totali=15;
	$pdf->SetY(68);
	$pdf->Cell(10,4,utf8_encode('A�O'),0,0,'C');
	$pdf->Cell(15,4,utf8_encode('CONCEPTO'),0,0,'C');
	$pdf->Cell(25,4,utf8_encode('AVAL�O'),0,0,'C');
	$pdf->Cell(10,4,utf8_encode('TASA'),0,0,'C');
	$pdf->Cell(20,4,utf8_encode('IMPUESTO'),0,0,'C');
	$pdf->Cell(15,4,utf8_encode('INTERESES'),0,0,'C');
	$pdf->Cell(15,4,utf8_encode('SOBRETASA'),0,0,'C');
	$pdf->Cell(15,4,utf8_encode('INT/SOBRET'),0,0,'C');
	$pdf->Cell(15,4,utf8_encode('BOMBEROS'),0,0,'C');
	$pdf->Cell(20,4,utf8_encode('ALUMBRADO PUB.'),0,0,'C');
	$pdf->Cell(14,4,utf8_encode('DESCUENTO'),0,0,'C');
	$pdf->Cell(20,4,utf8_encode('VALOR TOTAL'),0,0,'C');
}
else
{
	$pdf->Line(20,73,20,127);
	$pdf->Line(35,73,35,127);
	$pdf->Line(60,73,60,127);
	$avaluoi=23;
	$pdf->Line(70,73,70,127);
	$tasai=10;
	$pdf->Line(95,73,95,127);
	$impuestoi=23;
	$pdf->Line(111,73,111,127);
	$interesi = 15;
	$pdf->Line(127,73,127,127);
	$impuestoAmbi = 15;
	$pdf->Line(143,73,143,127);
	$interesesAmbi=15;
	$pdf->Line(159,73,159,127);
	$bombei=15;
	$pdf->Line(175,73,175,127);
	$descuentoi=15;
	$totali=23;
	$pdf->SetY(68);
	$pdf->Cell(10,4,utf8_encode('A�O'),0,0,'C');
	$pdf->Cell(15,4,utf8_encode('CONCEPTO'),0,0,'C');
	$pdf->Cell(25,4,utf8_encode('AVAL�O'),0,0,'C');
	$pdf->Cell(10,4,utf8_encode('TASA'),0,0,'C');
	$pdf->Cell(25,4,utf8_encode('IMPUESTO'),0,0,'C');
	$pdf->Cell(16,4,utf8_encode('INTERESES'),0,0,'C');
	$pdf->Cell(16,4,utf8_encode('SOBRETASA'),0,0,'C');
	$pdf->Cell(16,4,utf8_encode('INT/SOBRET'),0,0,'C');
	$pdf->Cell(16,4,utf8_encode('BOMBEROS'),0,0,'C');
	$pdf->Cell(16,4,utf8_encode('DESCUENTO'),0,0,'C');
	$pdf->Cell(25,4,utf8_encode('VALOR TOTAL'),0,0,'C');
}
$pdf->SetTextColor(0,0,0);
$pdf->SetY(74);
for($x=0;$x<count($_POST[dselvigencias]);$x++)
{	
 	$cont=0;
	while($cont<count($_POST[dvigencias]))
	{
		if($_POST[dvigencias][$cont]==$_POST[dselvigencias][$x])
		{
			$interes=$_POST[dinteres1][$cont]+$_POST[dipredial][$cont];
			$pdf->Cell(10,4,$_POST[dvigencias][$cont],0,0,'C');
			$pdf->Cell(15,4,utf8_encode('PREDIAL'),0,0,'L');
			$pdf->Cell($avaluoi,4,number_format($_POST[dvaloravaluo][$cont],2,',','.'),0,0,'R');
			$pdf->Cell(2,4,'',0,0,'R');
			$pdf->Cell($tasai,4,''.$_POST[dtasavig][$cont].' xmil',0,0,'C');
			$pdf->Cell($impuestoi,4,''.number_format($_POST[dpredial][$cont],2,',','.'),0,0,'R');
			$pdf->Cell(2,4,'',0,0,'R');
			$pdf->Cell($interesi,4,''.number_format($interes,2,',','.'),0,0,'R');
			$pdf->Cell(1,4,'',0,0,'R');
			$pdf->Cell($impuestoAmbi,4,''.number_format($_POST[dimpuesto2][$cont],2,',','.'),0,0,'R');
			$pdf->Cell(1,4,'',0,0,'R');
			$pdf->Cell($interesesAmbi,4,''.number_format($_POST[dinteres2][$cont],2,',','.'),0,0,'R');
			$pdf->Cell(1,4,'',0,0,'R');
			$pdf->Cell($bombei,4,''.number_format($_POST[dimpuesto1][$cont],2,',','.'),0,0,'R');
			$pdf->Cell(1,4,'',0,0,'R');
			if(count($_POST[dvalorAlumbrado])>0)
			{
				$pdf->Cell(15,4,''.number_format($_POST[dvalorAlumbrado][$cont],2,',','.'),0,0,'R');
				$pdf->Cell(1,4,'',0,0,'R');
			}
			$pdf->Cell($descuentoi,4,''.number_format($_POST[ddescipredial][$cont],2,',','.'),0,0,'R');
			$pdf->Cell(1,4,'',0,0,'R');
			$pdf->Cell($totali,4,''.number_format($_POST[dhavaluos][$x],2,',','.'),0,0,'R');
			$pdf->Cell(2,4,'',0,1,'R');
		}
	   	$cont=$cont +1;
	}
}
$pdf->RoundedRect(130, 129, 70, 15, 1.2, '1111', '');
$pdf->SetY(129.5);
$pdf->SetX(130.6);
$pdf->SetFillColor(150,150,150);
//$pdf->SetTextColor(255,255,255);
$pdf->Cell(25,14,'',0,0,'C',1);

$pdf->SetY(130);
$pdf->SetX(160);
$pdf->SetFont('dejavusans','',6);
$pdf->Cell(15,4,utf8_encode('FECHA'),0,0,'C');
$pdf->Cell(25,4,utf8_encode('VALOR'),0,0,'C');
$pdf->SetY(136);
$pdf->SetX(160);
$pdf->SetFont('dejavusans','',7);
$pdf->Cell(15,4,$_POST[fecha],0,0,'C');
$pdf->Cell(25,4,number_format($_POST[totliquida],2,',','.'),0,0,'R');

$pdf->SetY(132);
$pdf->SetX(135);
$pdf->SetFont('dejavusans','B',10);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(15,4,utf8_encode('P�GUESE'),0,0,'C');
$pdf->SetY(137);
$pdf->SetX(135);
$pdf->Cell(15,4,utf8_encode('HASTA'),0,0,'C');
$pdf->ln(8);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('dejavusans','',7);
$pdf->multicell(190,4,'Contra la presente liquidaci'.utf8_encode(�).'n procede el recurso de reconsideraci'.utf8_encode(�).'n dentro de los dos (2) meses siguientes a su notificaci'.utf8_encode(�).'n',0);
$pdf->ln(3);
$pdf->Cell(190,4,utf8_encode('Copia Contribuyente'),0,1,'C');

if(count($_POST[dvigencias])>1)
	$periodo=$_POST[dvigencias][0].' - '.$_POST[dvigencias][(count($_POST[dvigencias])-1)];
else
	$periodo=$_POST[dvigencias][0];
//*****************************************************************************************************************************
$pdf->SetFont('dejavusans','',6);
$pdf->SetY(162);
$pdf->Cell(190,5,$rs,0,0,'C'); 
$pdf->SetY(165);
$pdf->Cell(190,5,utf8_encode('DIRECCI�N DE IMPUESTOS MUNICIPALES'),0,0,'C'); 
$pdf->SetY(168);
$pdf->Cell(190,5,utf8_encode('TESORER�A MUNICIPAL'),0,0,'C'); 
$pdf->RoundedRect(10, 172, 190, 8, 1.2, '1111', '');
$pdf->SetFont('dejavusans','',6);
$pdf->SetY(173);
$pdf->Cell(70,4,utf8_encode('C�DULA CATASTRAL'),0,0,'L');
$pdf->Line(78,172,78,180);
$pdf->Cell(60,4,utf8_encode('PER�ODO FACTURADO'),0,0,'L');
$pdf->Line(138,172,138,180);
$pdf->Cell(60,4,utf8_encode('LIQUIDACION No.'),0,0,'L');
$pdf->SetY(176);
$pdf->Cell(70,4,$_POST[catastral],0,0,'L');
$pdf->Cell(60,4,$periodo,0,0,'L');
$pdf->Cell(60,4,$_POST[idpredial],0,0,'L');
$pdf->RoundedRect(80, 181, 120, 8, 1.2, '1111', '');
$pdf->SetFont('dejavusans','',6);
$pdf->SetY(182);
$pdf->SetX(81);
$pdf->Cell(40,4,utf8_encode('P�GUESE'),0,0,'C');
$pdf->Line(118,181,118,189);
$pdf->Cell(40,4,utf8_encode('FECHA'),0,0,'C');
$pdf->Line(158,181,158,189);
$pdf->Cell(40,4,utf8_encode('VALOR'),0,0,'C');
$pdf->SetY(185);
$pdf->SetX(81);
$pdf->Cell(40,4,'HASTA',0,0,'C');
$pdf->Cell(40,4,$_POST[fecha],0,0,'C');
$pdf->Cell(40,4,number_format($_POST[totliquida],2,',','.'),0,0,'C');
//*****************************************************************************************************************************
$pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 4, 'color' => array(0, 0, 0)));
$pdf->ln(4);
$posy=$pdf->GetY();
$pdf->write1DBarcode($codtot, 'C128', '', '', 160, 18, 0.25, $style, 'N');
$pdf->Cell(190,2,$codtotn,0,1,'C',FALSE);
$pdf->SetFont('dejavusans','',6);
$pdf->Cell(190,2,utf8_encode('Se�or Cajero: Por favor no colocar el sello en el c�digo de barras'),0,1,'C');
$pdf->Cell(190,2,utf8_encode('Copia Banco'),0,1,'C');
$pdf->Line(10,160,200,160);
//*****************************************************************************************************************************
$pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
$pdf->SetFont('dejavusans','',6);
$pdf->SetY(218);
$pdf->Cell(190,5,$rs,0,0,'C'); 
$pdf->SetY(221);
$pdf->Cell(190,5,utf8_encode('DIRECCI�N DE IMPUESTOS MUNICIPALES'),0,0,'C'); 
$pdf->SetY(223);
$pdf->Cell(190,5,utf8_encode('TESORER�A MUNICIPAL'),0,0,'C'); 
$pdf->RoundedRect(10, 228, 190, 8, 1.2, '1111', '');
$pdf->SetFont('dejavusans','',6);
$pdf->SetY(229);
$pdf->Cell(70,4,utf8_encode('C�DULA CATASTRAL'),0,0,'L');
$pdf->Line(78,228,78,236);
$pdf->Cell(60,4,utf8_encode('PER�ODO FACTURADO'),0,0,'L');
$pdf->Line(138,228,138,236);
$pdf->Cell(60,4,utf8_encode('LIQUIDACION No.'),0,0,'L');
$pdf->SetY(232);
$pdf->Cell(70,4,$_POST[catastral],0,0,'L');
$pdf->Cell(60,4,$periodo,0,0,'L');
$pdf->Cell(60,4,$_POST[idpredial],0,0,'L');
$pdf->RoundedRect(80, 238, 120, 8, 1.2, '1111', '');
$pdf->SetFont('dejavusans','',6);
$pdf->SetY(239);
$pdf->SetX(81);
$pdf->Cell(40,4,utf8_encode('P�GUESE'),0,0,'C');
$pdf->Line(118,238,118,246);
$pdf->Cell(40,4,utf8_encode('FECHA'),0,0,'C');
$pdf->Line(158,238,158,246);
$pdf->Cell(40,4,utf8_encode('VALOR'),0,0,'C');
$pdf->SetY(242);
$pdf->SetX(81);
$pdf->Cell(40,4,'HASTA',0,0,'C');
$pdf->Cell(40,4,$_POST[fecha],0,0,'C');
$pdf->Cell(40,4,number_format($_POST[totliquida],2,',','.'),0,0,'C');
//*****************************************************************************************************************************
$pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 4, 'color' => array(0, 0, 0)));
$pdf->Line(10,215,200,215);
$pdf->ln(5);
$pdf->write1DBarcode($codtot,'C128', '', '', 160, 18, 0.25, $style, 'N');
$pdf->Cell(190,2,$codtotn,0,1,'C',FALSE);
$pdf->SetFont('dejavusans','',6);
$pdf->Cell(190,2,utf8_encode('Se�or Cajero: Por favor no colocar el sello en el c�digo de barras'),0,1,'C');
$pdf->Cell(190,2,utf8_encode('Copia Tesorer�a'),0,1,'C');
$pdf->Output();
?> 