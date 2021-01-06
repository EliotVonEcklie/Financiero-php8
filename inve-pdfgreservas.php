<?php
//V 1000 12/12/16
require('comun.inc');
require"funciones.inc";
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
		$this->Cell(190,20,utf8_encode('SECRETARÍA DE HACIENDA MUNICIPAL'),0,0,'C');
		$this->SetFont('dejavusans','B',10);
		$this->SetY(15);
		$this->Cell(190,20,utf8_encode('DIRECCIÓN DE IMPUESTOS MUNICIPALES'),0,0,'C'); 
		$this->SetY(20);
		$this->Cell(190,20,utf8_encode('COMPROBANTE DE RESERVA'),0,0,'C'); 
		//************************************
		$this->SetY(28);
		$this->Cell(180,20,utf8_encode('Reserva No. ').$_POST[codigo],0,0,'R'); 
		
//************************	***********************************************************************************************************
	}
//Pie de página
	public function Footer() {
		$this->SetY(-10);
		$this->SetFont('dejavusans','I',10);
		$this->Cell(220, 10, 'Pagina '.$this->getAliasNumPage().' de '.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
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

$sql="select * from almreservas where codigo='".$_POST[codigo]."'";
$re=mysql_query($sql,$linkbd);
$r=mysql_fetch_row($re);

$tam=strlen($_POST[idpredial]);
$ceros='';
for($i=$tam;$i<9;$i++){
	$ceros.='0';
}
$ean=$ceros.$_POST[idpredial].'001';

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
	'stretchtext' => 1
);
$pdf->AddPage();

//********************************************************************************************************************************
$fecdi=explode('/', $_POST[fecha]);
$cod01="7709998803862";	//codigo GS1 Asignado
$cod02="01"; //codigo tipo recaudo
$cod03=str_pad($_POST[idpredial],7,"0", STR_PAD_LEFT);//Numero Liquidacion
//$cod04="$fecdi[0]$fecdi[1]".substr($fecdi[2],-2);//fecha de Liquidacion
$cod04=""; 
$cod05=str_pad("11100501",9,"0", STR_PAD_LEFT);//codigo cuenta bancaria
//$cod05="";
$cod06=str_pad($_POST[totliquida],10,"0", STR_PAD_LEFT);//total a pagar
$cod07="$fecdi[2]$fecdi[1]$fecdi[0]";//fecha limite
$codtotn="(450)$cod01(8020)$cod02$cod03$cod04$cod05(3900)$cod06(96)$cod07";
$codtot="450".$cod01."8020"."$cod02$cod03$cod04$cod05"."3900".$cod06."96".$cod07;

$pdf->ln(5);
$pdf->RoundedRect(10, 41, 190, 19, 1.2, '1111', '');
$pdf->SetFont('dejavusans','',8);
$pdf->SetY(42);
$pdf->Cell(140,4,utf8_encode('NOMBRE'),0,0,'L');
$tercero= buscatercero($r[2]);
$pdf->Line(10,51,200,51);
$pdf->Cell(30,4,utf8_encode('CÉDULA / NIT'),0,1,'L');
$pdf->Cell(140,4,utf8_encode(substr(strtoupper($tercero),0,50)),0,0,'L');
$pdf->Cell(30,4,$r[2],0,1,'L');
$pdf->ln(1);
$pdf->Cell(140,4,utf8_encode('DEPENDENCIA'),0,0,'L');
$pdf->Line(148,41,148,60);
$pdf->Cell(30,4,utf8_encode('FECHA DE LIQUIDACIÓN'),0,1,'L');
$dependencia= buscarareatrabajo($r[3]);
$pdf->Cell(140,4,$dependencia,0,0,'L');
$pdf->Cell(50,4,$_POST[fecha],0,1,'L');

//detalle
$pdf->SetFont('dejavusans','',6);
$pdf->ln(8.5);
$pdf->SetFillColor(150,150,150);
$pdf->Cell(190,5,'',0,0,'C',1);
$pdf->SetTextColor(255,255,255);
$pdf->SetY(68);
$pdf->Cell(25,4,utf8_encode('COD. ARTICULO'),0,0,'C');
$pdf->Cell(45,4,utf8_encode('NOMBRE ARTICULO'),0,0,'C');
$pdf->Cell(20,4,utf8_encode('CANT. BODEGA'),0,0,'C');
$pdf->Cell(20,4,utf8_encode('CANT. RESERVA'),0,0,'C');
$pdf->Cell(15,4,utf8_encode('UNIDAD'),0,0,'C');
$pdf->Cell(25,4,utf8_encode('COD. CUENTA'),0,0,'C');
$pdf->Cell(40,4,utf8_encode('NOMBRE CUENTA'),0,0,'C');
$pdf->SetTextColor(0,0,0);
$pdf->SetY(74);
$cont=0;
$val=1;
while($cont<count($_POST[agcodi]))
{
	$altura=4;
	$ancini=41;
	$altini=4;
	$coti=0;
	$sql="SELECT nombre FROM conceptoscontables WHERE almacen='S' and tipo='C' and modulo='3' and codigo='".$_POST[agcuen][$cont]."'";
	$re=mysql_query($sql,$linkbd);
	$ra=mysql_fetch_row($re);

	$sql2="SELECT unidad FROM almreservas_det WHERE articulo='".$_POST[agcodi][$cont]."' and codreserva='".$_POST[codigo]."'";
	$re2=mysql_query($sql2,$linkbd);
	$ra2=mysql_fetch_row($re2);

	$colst01=strlen($_POST[agarti][$cont]);
	$colst02=strlen(utf8_decode($ra[0]));
	if($colst01>$colst02){$cantidad_lineas= $colst01;}
	else{$cantidad_lineas= $colst02;}
	$altaux=4;
	if($cantidad_lineas > $ancini)
	{
		$coti++;
		$cant_espacios = $cantidad_lineas/$ancini;
		$rendondear=ceil($cant_espacios);
		$altaux=$altini*$rendondear;
	}
	$pdf->Cell(24,$altaux,''.$_POST[agcodi][$cont],0,0,'C');
	$pdf->Cell(2,$altaux,'',0,0,'R');
	$pdf->MultiCell(43,$altaux,$_POST[agarti][$cont],0,'C',0,0, '', '', true, 0, false, true, $altaux, 'M');
	$pdf->Cell(2,$altaux,'',0,0,'R');
	$pdf->Cell(18,$altaux,''.$_POST[agnbod][$cont],0,0,'C');
	$pdf->Cell(2,$altaux,'',0,0,'R');
	$pdf->Cell(18,$altaux,''.$_POST[agnres][$cont],0,0,'C');
	$pdf->Cell(2,$altaux,'',0,0,'R');
	$pdf->Cell(13,$altaux,''.$ra2[0],0,0,'C');
	$pdf->Cell(2,$altaux,'',0,0,'R');
	$pdf->Cell(23,$altaux,''.$_POST[agcuen][$cont],0,0,'C');
	$pdf->Cell(2,$altaux,'',0,0,'R');
	$pdf->MultiCell(39,$altaux,''.utf8_decode($ra[0]),0,'C',0,0, '', '', true, 0, false, true, $altaux, 'M');
	$pdf->Cell(2,$altaux,'',0,1,'R');
	$cont=$cont +1;
}
$a=$pdf->GetY();
$pdf->RoundedRect(10, 67, 190, $a-67, 1.2, '1111', '');
$pdf->SetY(67.5);
$pdf->SetX(10.6);
//HORIZONTAL
$pdf->Line(10,73,200,73);
//VERTICAL
$pdf->Line(35,73,35,$a);
$pdf->Line(80,73,80,$a);
$pdf->Line(100,73,100,$a);
$pdf->Line(120,73,120,$a);
$pdf->Line(135,73,135,$a);
$pdf->Line(160,73,160,$a);

$pdf->ln(30);
$pdf->cell(50);
$pdf->Cell(80,5,'','T',0,'C');

$pdf->Output();
?> 