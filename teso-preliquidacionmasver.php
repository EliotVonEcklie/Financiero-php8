<?php
	require('comun.inc');
	require_once('barras/tcpdf_include.php');
	date_default_timezone_set("America/Bogota");
	class MYPDF extends TCPDF 
	{
		public function Header() {
			$linkbd=conectar_bd();
			$sqlr="select *from configbasica where estado='S'";
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
			$this->Cell(205,5,''.$rs,0,0,'C'); 
			//*****************************************************************************************************************************
			$this->SetFont('dejavusans','B',12);
			$this->SetY(10);
			$this->Cell(205,20,utf8_encode('SECRETARÍA DE HACIENDA MUNICIPAL'),0,0,'C'); 
			$this->SetFont('dejavusans','B',10);
			$this->SetY(15);
			$this->Cell(205,20,utf8_encode('DIRECCIÓN DE IMPUESTOS MUNICIPALES'),0,0,'C'); 
			$this->SetY(20);
			$this->Cell(205,20,utf8_encode('PRELIQUIDACION'),0,0,'C'); 
			$this->SetY(25);
			$this->Cell(205,20,utf8_encode('IMPUESTO PREDIAL UNIFICADO'),0,0,'C'); 
			//************************************
		}
		public function Footer() {}
	}
	$pdf = new MYPDF('P','mm','Letter', true, 'iso-8859-1', false);
	$pdf->SetDocInfoUnicode (true); 
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('G&CSAS');
	$pdf->SetTitle('Preliquidacion');
	$pdf->SetSubject('Preliquidacion');
	$pdf->SetKeywords('');
	$pdf->SetMargins(10, 0, 0);// set margins
	$pdf->SetHeaderMargin(0);// set margins
	$pdf->SetFooterMargin(0);// set margins
	$pdf->SetAutoPageBreak(TRUE, 0);// set auto page breaks
	// set some language-dependent strings (optional)
	if (@file_exists(dirname(__FILE__).'/lang/spa.php')) 
	{
		require_once(dirname(__FILE__).'/lang/spa.php');
		$pdf->setLanguageArray($l);
	}
	$pdf->setBarcode(date('Y-m-d H:i:s'));
	$linkbd=conectar_bd();
	$codigopre=$_GET[codimpre];
	$sqlr1="SELECT numinicial,numfinal,fecha,fechades FROM tesopreliquidacion_gen WHERE codpregen='$codigopre'";
	$resp1 = mysql_query($sqlr1,$linkbd);
	$row1 =mysql_fetch_row($resp1);
	$codpreini=	$row1[0];
	$codprefin=	$row1[1];
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
		'stretchtext' => 1);
	$cod01="7709998803862";	//codigo GS1 Asignado
	$cod02="01"; //codigo tipo recaudo
	$cod04=""; 
	$cod05=str_pad("11100501",9,"0", STR_PAD_LEFT);//codigo cuenta bancaria
	$fecdi=explode('-', $row1[3]);
	$cod07="$fecdi[0]$fecdi[1]$fecdi[2]";//fecha limite
	for($yx=$codpreini;$yx<=$codprefin;$yx++)
	{
		$codpreli=str_pad($yx,7,"0", STR_PAD_LEFT);
		$sqlr2="SELECT * FROM tesopreliquidacion WHERE codpreli='$yx'";
		$resp2 = mysql_query($sqlr2,$linkbd);
		$row2 =mysql_fetch_row($resp2);
		$pdf->AddPage();
		$pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
		$pdf->SetY(28);
		$pdf->SetFont('dejavusans','B',10);
		$pdf->Cell(190,20,utf8_encode('No. ').$codpreli,0,0,'R'); 
		$cod03=str_pad($yx,7,"0", STR_PAD_LEFT);//Numero Liquidacion
		$cod06=str_pad($row2[17],10,"0", STR_PAD_LEFT);//total a pagar
		$codtotn="(450)$cod01(8020)$cod02$cod03$cod04$cod05(3900)$cod06(96)$cod07";
		$codtot="450".$cod01."8020"."$cod02$cod03$cod04$cod05"."3900".$cod06."96".$cod07;
		$pdf->ln(5);
		$pdf->RoundedRect(10, 41, 190, 24, 1.2, '1111', '');
		$pdf->SetFont('dejavusans','',8);
		$pdf->SetY(42);
		$pdf->Cell(50,4,utf8_encode('CÉDULA CATASTRAL'),0,0,'L');
		$pdf->Line(58,41,58,53);
		$pdf->Cell(90,4,utf8_encode('DIRECCIÓN'),0,0,'L');
		$pdf->Line(148,41,148,53);
		$pdf->Cell(50,4,utf8_encode('VEREDA'),0,0,'L');
		$pdf->SetY(47);
		$pdf->Cell(50,4,$row2[2],0,0,'L');
		$pdf->Cell(90,4,substr(strtoupper($row2[6]),0,80),0,0,'L');
		$pdf->Cell(50,4,$_POST[vereda],0,0,'L');
		$pdf->Line(10,53,200,53);
		$pdf->SetY(54);
		$pdf->Cell(80,4,utf8_encode('NOMBRE'),0,0,'L');
		$pdf->Line(88,53,88,65);
		$pdf->Cell(30,4,utf8_encode('CÉDULA / NIT'),0,0,'L');
		$pdf->Line(118,53,118,65);
		$pdf->Cell(10,4,utf8_encode('HA'),0,0,'L');
		$pdf->Line(128,53,128,65);
		$pdf->Cell(10,4,utf8_encode('M2'),0,0,'L');
		$pdf->Line(138,53,138,65);
		$pdf->Cell(10,4,utf8_encode('AC'),0,0,'L');
		$pdf->Line(148,53,148,65);
		$pdf->Cell(50,4,utf8_encode('FECHA DE LIQUIDACIÓN'),0,0,'L');
		$pdf->SetY(59);
		$pdf->Cell(80,4,substr(strtoupper($row2[5]),0,50),0,0,'L');
		$pdf->Cell(30,4,$row2[4],0,0,'L');
		$pdf->Cell(10,4,$row2[7],0,0,'L');
		$pdf->Cell(10,4,$row2[8],0,0,'L');
		$pdf->Cell(10,4,$row2[9],0,0,'L');
		$pdf->Cell(50,4,date('d-m-Y',strtotime($row1[2])),0,0,'L');
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
		$pdf->Line(20,73,20,127);
		$pdf->Line(35,73,35,127);
		$pdf->Line(60,73,60,127);
		$pdf->Line(70,73,70,127);
		$pdf->Line(95,73,95,127);
		$pdf->Line(111,73,111,127);
		$pdf->Line(127,73,127,127);
		$pdf->Line(143,73,143,127);
		$pdf->Line(159,73,159,127);
		$pdf->Line(175,73,175,127);
		$pdf->SetY(68);
		$pdf->Cell(10,4,utf8_encode('AÑO'),0,0,'C');
		$pdf->Cell(15,4,utf8_encode('CONCEPTO'),0,0,'C');
		$pdf->Cell(25,4,utf8_encode('AVALÚO'),0,0,'C');
		$pdf->Cell(10,4,utf8_encode('TASA'),0,0,'C');
		$pdf->Cell(25,4,utf8_encode('IMPUESTO'),0,0,'C');
		$pdf->Cell(16,4,utf8_encode('INTERESES'),0,0,'C');
		$pdf->Cell(16,4,utf8_encode('SOBRETASA'),0,0,'C');
		$pdf->Cell(16,4,utf8_encode('INT/SOBRET'),0,0,'C');
		$pdf->Cell(16,4,utf8_encode('BOMBEROS'),0,0,'C');
		$pdf->Cell(16,4,utf8_encode('DESCUENTO'),0,0,'C');
		$pdf->Cell(25,4,utf8_encode('VALOR TOTAL'),0,0,'C');
		$pdf->SetTextColor(0,0,0);
		$pdf->SetY(74);
		$interes=0;
		$pdf->Cell(10,4,$row2[3],0,0,'C');
		$pdf->Cell(15,4,utf8_encode('PREDIAL'),0,0,'L');
		$pdf->Cell(23,4,number_format($row2[11],2,',','.'),0,0,'R');
		$pdf->Cell(2,4,'',0,0,'R');
		$pdf->Cell(10,4,''.$row2[10].' xmil',0,0,'C');
		$pdf->Cell(23,4,''.number_format($row2[12],2,',','.'),0,0,'R');
		$pdf->Cell(2,4,'',0,0,'R');
		$pdf->Cell(15,4,''.number_format($interes,2,',','.'),0,0,'R');
		$pdf->Cell(1,4,'',0,0,'R');
		$pdf->Cell(15,4,''.number_format($row2[14],2,',','.'),0,0,'R');
		$pdf->Cell(1,4,'',0,0,'R');
		$pdf->Cell(15,4,''.number_format(0,2,',','.'),0,0,'R');
		$pdf->Cell(1,4,'',0,0,'R');
		$pdf->Cell(15,4,''.number_format($row2[13],2,',','.'),0,0,'R');
		$pdf->Cell(1,4,'',0,0,'R');
		$pdf->Cell(15,4,''.number_format($row2[15],2,',','.'),0,0,'R');
		$pdf->Cell(1,4,'',0,0,'R');
		$pdf->Cell(23,4,''.number_format($row2[17],2,',','.'),0,0,'R');
		$pdf->Cell(2,4,'',0,1,'R');
		$pdf->RoundedRect(130, 129, 70, 15, 1.2, '1111', '');
		$pdf->SetY(129.5);
		$pdf->SetX(130.6);
		$pdf->SetFillColor(150,150,150);
		$pdf->Cell(25,14,'',0,0,'C',1);
		$pdf->SetY(130);
		$pdf->SetX(160);
		$pdf->SetFont('dejavusans','',6);
		$pdf->Cell(15,4,utf8_encode('FECHA'),0,0,'C');
		$pdf->Cell(25,4,utf8_encode('VALOR'),0,0,'C');
		$pdf->SetY(136);
		$pdf->SetX(160);
		$pdf->SetFont('dejavusans','',7);
		$pdf->Cell(15,4,date('d-m-Y',strtotime($row1[3])),0,0,'C');
		$pdf->Cell(25,4,number_format($row2[17],2,',','.'),0,0,'R');
		$pdf->SetY(132);
		$pdf->SetX(135);
		$pdf->SetFont('dejavusans','B',10);
		$pdf->SetTextColor(255,255,255);
		$pdf->Cell(15,4,utf8_encode('PÁGUESE'),0,0,'C');
		$pdf->SetY(137);
		$pdf->SetX(135);
		$pdf->Cell(15,4,utf8_encode('HASTA'),0,0,'C');
		$pdf->ln(8);
		$pdf->SetTextColor(0,0,0);
		$pdf->SetFont('dejavusans','',7);
		$pdf->multicell(190,4,'Contra la presente Preliquidaci'.utf8_encode(ó).'n procede el recurso de reconsideraci'.utf8_encode(ó).'n dentro de los dos (2) meses siguientes a su notificaci'.utf8_encode(ó).'n',0);
		$pdf->ln(3);
		$pdf->Cell(190,4,utf8_encode('Copia Contribuyente'),0,1,'C');
		//*****************************************************************************************************************************
		$pdf->SetFont('dejavusans','',6);
		$pdf->SetY(162);
		$pdf->Cell(190,5,$rs,0,0,'C'); 
		$pdf->SetY(165);
		$pdf->Cell(190,5,utf8_encode('DIRECCIÓN DE IMPUESTOS MUNICIPALES'),0,0,'C'); 
		$pdf->SetY(168);
		$pdf->Cell(190,5,utf8_encode('TESORERÍA MUNICIPAL'),0,0,'C'); 
		$pdf->RoundedRect(10, 172, 190, 8, 1.2, '1111', '');
		$pdf->SetFont('dejavusans','',6);
		$pdf->SetY(173);
		$pdf->Cell(70,4,utf8_encode('CÉDULA CATASTRAL'),0,0,'L');
		$pdf->Line(78,172,78,180);
		$pdf->Cell(60,4,utf8_encode('PERÍODO FACTURADO'),0,0,'L');
		$pdf->Line(138,172,138,180);
		$pdf->Cell(60,4,utf8_encode('PRELIQUIDACION No.'),0,0,'L');
		$pdf->SetY(176);
		$pdf->Cell(70,4,$row2[2],0,0,'L');
		$pdf->Cell(60,4,$row2[3],0,0,'L');
		$pdf->Cell(60,4,$codpreli,0,0,'L');
		$pdf->RoundedRect(80, 181, 120, 8, 1.2, '1111', '');
		$pdf->SetFont('dejavusans','',6);
		$pdf->SetY(182);
		$pdf->SetX(81);
		$pdf->Cell(40,4,utf8_encode('PÁGUESE'),0,0,'C');
		$pdf->Line(118,181,118,189);
		$pdf->Cell(40,4,utf8_encode('FECHA'),0,0,'C');
		$pdf->Line(158,181,158,189);
		$pdf->Cell(40,4,utf8_encode('VALOR'),0,0,'C');
		$pdf->SetY(185);
		$pdf->SetX(81);
		$pdf->Cell(40,4,'HASTA',0,0,'C');
		$pdf->Cell(40,4,date('d-m-Y',strtotime($row1[3])),0,0,'C');
		$pdf->Cell(40,4,number_format($row2[17],2,',','.'),0,0,'C');
		//*****************************************************************************************************************************
		$pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 4, 'color' => array(0, 0, 0)));
		$pdf->ln(4);
		$posy=$pdf->GetY();
		$pdf->write1DBarcode($codtot, 'C128', '', '', 110, 18, 0.4, $style, 'N');
		$pdf->Cell(190,2,$codtotn,0,1,'C',FALSE);
		$pdf->SetFont('dejavusans','',6);
		$pdf->Cell(190,2,utf8_encode('Señor Cajero: Por favor no colocar el sello en el código de barras'),0,1,'C');
		$pdf->Cell(190,2,utf8_encode('Copia Banco'),0,1,'C');
		$pdf->Line(10,160,200,160);
		//*****************************************************************************************************************************
		$pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
		$pdf->SetFont('dejavusans','',6);
		$pdf->SetY(218);
		$pdf->Cell(190,5,$rs,0,0,'C'); 
		$pdf->SetY(221);
		$pdf->Cell(190,5,utf8_encode('DIRECCIÓN DE IMPUESTOS MUNICIPALES'),0,0,'C'); 
		$pdf->SetY(223);
		$pdf->Cell(190,5,utf8_encode('TESORERÍA MUNICIPAL'),0,0,'C'); 
		$pdf->RoundedRect(10, 228, 190, 8, 1.2, '1111', '');
		$pdf->SetFont('dejavusans','',6);
		$pdf->SetY(229);
		$pdf->Cell(70,4,utf8_encode('CÉDULA CATASTRAL'),0,0,'L');
		$pdf->Line(78,228,78,236);
		$pdf->Cell(60,4,utf8_encode('PERÍODO FACTURADO'),0,0,'L');
		$pdf->Line(138,228,138,236);
		$pdf->Cell(60,4,utf8_encode('LIQUIDACION No.'),0,0,'L');
		$pdf->SetY(232);
		$pdf->Cell(70,4,$row2[2],0,0,'L');
		$pdf->Cell(60,4,$row2[3],0,0,'L');
		$pdf->Cell(60,4,$codpreli,0,0,'L');
		$pdf->RoundedRect(80, 238, 120, 8, 1.2, '1111', '');
		$pdf->SetFont('dejavusans','',6);
		$pdf->SetY(239);
		$pdf->SetX(81);
		$pdf->Cell(40,4,utf8_encode('PÁGUESE'),0,0,'C');
		$pdf->Line(118,238,118,246);
		$pdf->Cell(40,4,utf8_encode('FECHA'),0,0,'C');
		$pdf->Line(158,238,158,246);
		$pdf->Cell(40,4,utf8_encode('VALOR'),0,0,'C');
		$pdf->SetY(242);
		$pdf->SetX(81);
		$pdf->Cell(40,4,'HASTA',0,0,'C');
		$pdf->Cell(40,4,date('d-m-Y',strtotime($row1[3])),0,0,'C');
		$pdf->Cell(40,4,number_format($row2[17],2,',','.'),0,0,'C');
		//*****************************************************************************************************************************
		$pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 4, 'color' => array(0, 0, 0)));
		$pdf->Line(10,215,200,215);
		$pdf->ln(5);
		$pdf->write1DBarcode($codtot,'C128', '', '', 110, 18, 0.4, $style, 'N');
		$pdf->Cell(190,2,$codtotn,0,1,'C',FALSE);
		$pdf->SetFont('dejavusans','',6);
		$pdf->Cell(190,2,utf8_encode('Señor Cajero: Por favor no colocar el sello en el código de barras'),0,1,'C');
		$pdf->Cell(190,2,utf8_encode('Copia Tesorería'),0,1,'C');
	}
	$pdf->Output('Preliquidaciones.pdf', 'I');
?> 