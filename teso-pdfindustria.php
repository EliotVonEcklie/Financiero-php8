<?php
//V 1000 12/12/16
require('comun.inc');
require_once('barras/tcpdf_include.php');
//session_start();
//****2016-03-01 jair castañeda cobro recibo
   date_default_timezone_set("America/Bogota");
//*****las variables con los contenidos***********
//**********pdf*******
//$pdf=new FPDF('P','mm','Letter'); 

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
		$this->Cell(190,5,''.$rs,0,0,'C'); 
		//*****************************************************************************************************************************
		$this->SetFont('dejavusans','B',12);
		$this->SetY(10);
		$this->Cell(190,20,'SECRETARÍA DE HACIENDA MUNICIPAL',0,0,'C'); 
		$this->SetFont('dejavusans','B',10);
		$this->SetY(15);
		$this->Cell(190,20,'DIRECCIÓN DE IMPUESTOS MUNICIPALES',0,0,'C'); 
		$this->SetY(20);
		$this->Cell(190,20,'RECIBO DE COBRO',0,0,'C'); 
		$this->SetY(25);
		$this->Cell(190,20,'INDUSTRIA Y COMERCIO PERIODO '.$_POST[ageliquida],0,0,'C'); 
		//************************************
		$this->SetY(28);
		$this->Cell(180,20,'Liquidación No. '.$_POST[idcomp],0,0,'R'); 
		
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
//$pdf=new PDF('P','mm',array(210,140));
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

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
	'stretchtext' => 4
);


$pdf->AddPage();

$linkbd=conectar_bd();
$sqlr="select *from configbasica where estado='S'";
$res=mysql_query($sqlr,$linkbd);
while($row=mysql_fetch_row($res))
{
	$nit=$row[0];
	$rs=$row[1];
}

$tam=strlen($_POST[idcomp]);
$ceros='';
for($i=$tam;$i<9;$i++){
	$ceros.='0';
}
$ean=$ceros.$_POST[idcomp].'002';

//********************************************************************************************************************************
$pdf->ln(5);

$pdf->RoundedRect(10, 41, 190, 24, 1.2, '1111', '');
$pdf->Line(10,53,200,53);
$pdf->SetFont('dejavusans','',8);
$pdf->SetY(42);
$pdf->Cell(100,4,'CONTRIBUYENTE',0,0,'L');
$pdf->Line(108,41,108,53);
$pdf->Cell(40,4,'CÉDULA / NIT',0,0,'L');
$pdf->Line(148,41,148,53);
$pdf->Cell(50,4,'FECHA DE LIQUIDACIÓN',0,0,'L');
$pdf->SetY(48);
$pdf->Cell(100,4,iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[ntercero]),0,0,'L');
$pdf->Cell(40,4,$_POST[tercero],0,0,'L');
$pdf->Cell(50,4,$_POST[fecha],0,0,'L');
$pdf->SetY(57);
$pdf->Cell(150,4,'LA SUMA DE: '.$_POST[letras],0,0,'L');

$sqlr="select valor_inicial,valor_final, tipo from dominios where nombre_dominio='COBRO_RECIBOS' AND descripcion_valor='$_POST[vigencia]' and  tipo='S'";
$res=mysql_query($sqlr,$linkbd);
while ($row =mysql_fetch_row($res)) 
{
	$cobrorecibo=$row[0];
	$vcobrorecibo=$row[1];
	$tcobrorecibo=$row[2];	 
}
//detalle
$pdf->SetFont('dejavusans','',6);
$pdf->RoundedRect(10, 67, 190, 60, 1.2, '1111', '');
$pdf->SetY(67.5);
$pdf->SetX(10.6);
$pdf->SetFillColor(150,150,150);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(189,5,'',0,0,'C',1);
//HORIZONTAL
$pdf->Line(10,73,200,73);
//VERTICAL
$pdf->Line(155,73,155,127);
$pdf->SetY(68);
$pdf->Cell(155,4,('DESCRIPCION'),0,0,'C');
$pdf->Cell(35,4,('VALOR TOTAL'),0,0,'C');
$pdf->SetTextColor(0,0,0);
$pdf->SetY(74);

$pdf->SetFont('dejavusans','',8);
$pdf->Cell(155,4,'Industria y Comercio',0,0,'L');//descrip
$pdf->Cell(32,4,''.$_POST[industria],0,1,'R');
$pdf->Cell(155,4,'Intereses',0,0,'L');//descrip
$pdf->Cell(32,4,''.$_POST[intereses],0,1,'R');
$pdf->Cell(155,4,'Avisos y Tableros',0,0,'L');//descrip
$pdf->Cell(32,4,''.$_POST[avisos],0,1,'R');
$pdf->Cell(155,4,'Sobretasa Bomberil',0,0,'L');//descrip
$pdf->Cell(32,4,''.$_POST[bomberil],0,1,'R');
$pdf->Cell(155,4,'Sanciones',0,0,'L');//descrip
$pdf->Cell(32,4,''.$_POST[sanciones],0,1,'R');
$pdf->Cell(155,4,'Retenciones',0,0,'L');//descrip
$pdf->Cell(32,4,'-'.$_POST[retenciones],0,1,'R');
$pdf->Cell(155,4,'Descuentos',0,0,'L');//descrip
$pdf->Cell(32,4,'-'.$_POST[id36],0,1,'R');
if ($_POST[id26]>0)
{
	$pdf->Cell(155,4,'Menos valor de exención o exoneración sobre el impuesto y no sobre los ingresos ',0,0,'L');//descrip
	$pdf->Cell(32,4,'-'.$_POST[id26],0,1,'R');
}
if ($_POST[id28]>0)
{
	$pdf->Cell(155,4,'Menos Autorretenciones ',0,0,'L');//descrip
	$pdf->Cell(32,4,'-'.$_POST[id28],0,1,'R');
}
//$pdf->Cell(155,4,'Ajuste a miles',0,0,'L');//descrip
//$pdf->Cell(32,4,$_POST[saldopagar],0,1,'R');
if($vcobrorecibo>0)
{
	$pdf->Cell(155,4,'COBRO PAPELERIA ',0,0,'L');//descrip
	$pdf->Cell(32,4,''.number_format($vcobrorecibo,2,',','.'),0,1,'R');
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
$pdf->Cell(15,4,'FECHA',0,0,'C');
$pdf->Cell(25,4,'VALOR',0,0,'C');
$pdf->SetY(136);
$pdf->SetX(160);
$pdf->SetFont('dejavusans','',7);
$pdf->Cell(15,4,$_POST[fecha],0,0,'C');
$pdf->Cell(25,4,number_format(($_POST[saldopagar]+$vcobrorecibo),2,',','.'),0,0,'R');

$linkbd=conectar_bd();
$sqlr="SELECT codigo FROM codigosbarras WHERE estado='S' AND tipo='02'";
$res=mysql_query($sqlr,$linkbd);
$row=mysql_fetch_row($res);
$fecdi=explode('/', $_POST[fecha]);
$cod01=$row[0];//codigo GS1 Asignado
$cod02="02"; //codigo tipo recaudo
$cod03=str_pad($_POST[idcomp],7,"0", STR_PAD_LEFT);//Numero Liquidacion
//$cod04="$fecdi[0]$fecdi[1]".substr($fecdi[2],-2);//fecha de Liquidacion
$cod04=""; 
$cod05=str_pad("11100501",9,"0", STR_PAD_LEFT);//codigo cuenta bancaria
$cod06=str_pad(($_POST[saldopagar]+$vcobrorecibo),10,"0", STR_PAD_LEFT);//total a pagar
$cod07="$fecdi[2]$fecdi[1]$fecdi[0]";//fecha limite
$codtotn="(450)$cod01(8020)$cod02$cod03$cod04$cod05(3900)$cod06(96)$cod07";
$codtot=chr(241)."415".$cod01."8020"."$cod02$cod03$cod04$cod05".chr(241)."3900".$cod06.chr(241)."96".$cod07;


$pdf->SetY(132);
$pdf->SetX(135);
$pdf->SetFont('dejavusans','B',10);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(15,4,'PÁGUESE',0,0,'C');
$pdf->SetY(137);
$pdf->SetX(135);
$pdf->Cell(15,4,'HASTA',0,0,'C');
	
$pdf->ln(8);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('dejavusans','',7);
$pdf->multicell(190,4,'Contra la presente liquidación procede el recurso de reconsideración dentro de los dos (2) meses siguientes a su notificación',0);
$pdf->ln(3);
$pdf->Cell(190,4,'Copia Contribuyente',0,1,'C');


//*****************************************************************************************************************************
$pdf->SetFont('dejavusans','',6);
$pdf->SetY(162);
$pdf->Cell(190,5,$rs,0,0,'C'); 
$pdf->SetY(165);
$pdf->Cell(190,5,('DIRECCIÓN DE IMPUESTOS MUNICIPALES'),0,0,'C'); 
$pdf->SetY(168);
$pdf->Cell(190,5,('TESORERÍA MUNICIPAL'),0,0,'C'); 
$pdf->RoundedRect(10, 172, 190, 8, 1.2, '1111', '');
$pdf->SetFont('dejavusans','',6);
$pdf->SetY(173);
$pdf->Cell(70,4,('CÉDULA / NIT'),0,0,'L');
$pdf->Line(78,172,78,180);
$pdf->Cell(60,4,('FECHA LIQUIDACIÓN'),0,0,'L');
$pdf->Line(138,172,138,180);
$pdf->Cell(60,4,('LIQUIDACION No.'),0,0,'L');
$pdf->SetY(176);
$pdf->Cell(70,4,$_POST[tercero],0,0,'L');
$pdf->Cell(60,4,$_POST[fecha],0,0,'L');
$pdf->Cell(60,4,$_POST[idcomp],0,0,'L');
$pdf->RoundedRect(80, 181, 120, 8, 1.2, '1111', '');
$pdf->SetFont('dejavusans','',6);
$pdf->SetY(182);
$pdf->SetX(81);
$pdf->Cell(40,4,('PÁGUESE'),0,0,'C');
$pdf->Line(118,181,118,189);
$pdf->Cell(40,4,('FECHA'),0,0,'C');
$pdf->Line(158,181,158,189);
$pdf->Cell(40,4,('VALOR'),0,0,'C');
$pdf->SetY(185);
$pdf->SetX(81);
$pdf->Cell(40,4,'HASTA',0,0,'C');
$pdf->Cell(40,4,$_POST[fecha],0,0,'C');
$pdf->Cell(40,4,number_format(($_POST[saldopagar]+$vcobrorecibo),2,',','.'),0,0,'C');
//*****************************************************************************************************************************
$pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 4, 'color' => array(0, 0, 0)));
// EAN 13
$pdf->ln(4);
//$pdf->Cell(0, 0, 'EAN 13', 0, 1);
$pdf->write1DBarcode($codtot, 'C128', '', '', 110, 16, 0.25, $style, 'N');
$pdf->Cell(190,2,$codtotn,0,1,'C',FALSE);
$pdf->SetFont('dejavusans','',6);
$pdf->Cell(190,2,('Señor Cajero: Por favor no colocar el sello en el código de barras'),0,1,'C');
$pdf->Cell(190,2,('Copia Banco'),0,1,'C');

$pdf->Line(10,160,200,160);
//*****************************************************************************************************************************
$pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
$pdf->SetFont('dejavusans','',6);
$pdf->SetY(218);
$pdf->Cell(190,5,$rs,0,0,'C'); 
$pdf->SetY(221);
$pdf->Cell(190,5,('DIRECCIÓN DE IMPUESTOS MUNICIPALES'),0,0,'C'); 
$pdf->SetY(223);
$pdf->Cell(190,5,('TESORERÍA MUNICIPAL'),0,0,'C'); 
$pdf->RoundedRect(10, 228, 190, 8, 1.2, '1111', '');
$pdf->SetFont('dejavusans','',6);
$pdf->SetY(229);
$pdf->Cell(70,4,('CÉDULA / NIT'),0,0,'L');
$pdf->Line(78,228,78,236);
$pdf->Cell(60,4,('FECHA LIQUIDACIÓN'),0,0,'L');
$pdf->Line(138,228,138,236);
$pdf->Cell(60,4,('LIQUIDACION No.'),0,0,'L');
$pdf->SetY(232);
$pdf->Cell(70,4,$_POST[tercero],0,0,'L');
$pdf->Cell(60,4,$_POST[fecha],0,0,'L');
$pdf->Cell(60,4,$_POST[idcomp],0,0,'L');
$pdf->RoundedRect(80, 238, 120, 8, 1.2, '1111', '');
$pdf->SetFont('dejavusans','',6);
$pdf->SetY(239);
$pdf->SetX(81);
$pdf->Cell(40,4,('PÁGUESE'),0,0,'C');
$pdf->Line(118,238,118,246);
$pdf->Cell(40,4,('FECHA'),0,0,'C');
$pdf->Line(158,238,158,246);
$pdf->Cell(40,4,('VALOR'),0,0,'C');
$pdf->SetY(242);
$pdf->SetX(81);
$pdf->Cell(40,4,'HASTA',0,0,'C');
$pdf->Cell(40,4,$_POST[fecha],0,0,'C');
$pdf->Cell(40,4,number_format(($_POST[saldopagar]+$vcobrorecibo),2,',','.'),0,0,'C');
//*****************************************************************************************************************************
// EAN 13
$pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 4, 'color' => array(0, 0, 0)));
$pdf->Line(10,215,200,215);
$pdf->ln(5);
//$pdf->Cell(0, 0, 'EAN 13', 0, 1);
$pdf->write1DBarcode($codtot, 'C128', '', '', 110, 16, 0.25, $style, 'N');
$pdf->Cell(190,2,$codtotn,0,1,'C',FALSE);
$pdf->SetFont('dejavusans','',6);
$pdf->Cell(190,2,('Señor Cajero: Por favor no colocar el sello en el código de barras'),0,1,'C');
$pdf->Cell(190,2,('Copia Tesorería'),0,1,'C');

//***********************************************************************************************************/
$pdf->Output();
?>