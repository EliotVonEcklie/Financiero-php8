<?php //V 1000 12/12/16 ?> 
<?php
	require_once("tcpdf/tcpdf_include.php");
	require('comun.inc');
	require"funciones.inc";
	session_start();
	class MYPDF extends TCPDF 
	{
		public function Header() 
		{
			$linkbd=conectar_bd();
			$sqlr="SELECT nit, razonsocial FROM configbasica WHERE estado='S'";
			$resp=mysql_query($sqlr,$linkbd);
			while($row=mysql_fetch_row($resp)){$nit=$row[0];$rs=utf8_encode(strtoupper($row[1]));}
			$this->Image('imagenes/eng.jpg', 25, 10, 25, 23.9, 'JPG', '', 'T', true, 300, '', false, false, 0, false, false, false);// Logo
			$this->SetFont('helvetica','B',8);
			$this->SetY(10);
			$this->RoundedRect(10, 10, 280, 31, 2.5,''); //Borde del encabezado
			$this->Cell(52,31,'','R',0,'L'); //Linea que separa el encabazado verticalmente
			$this->SetY(32.5);
			$this->Cell(52,5,''.$rs,0,0,'C',false,0,1,false,'T','B'); //Nombre Municipio
			$this->SetFont('helvetica','B',8);
			$this->SetY(36.5);
			$this->Cell(52,5,''.$nit,0,0,'C',false,0,1,false,'T','C'); //Nit
			$this->SetFont('helvetica','B',14);
			$this->SetY(10);
			$this->SetX(62);
			$this->Cell(190,17,'Registros Presupuestales Reversados Parcialmente',0,0,'C'); 
			$this->SetFont('helvetica','I',10);
			$this->SetY(27);
			$this->SetX(62);
			$this->Cell(190,7,"",'T',0,'L',false,0,1); 
			$this->SetY(31.2);
			$this->SetX(62);
			$this->Cell(190,7,"",0,0,'L',false,0,1);
			$this->SetFont('helvetica','B',9);
			$this->SetY(10);
			$this->SetX(252);
			$this->Cell(37.8,30.7,'','L',0,'L');
			$this->SetY(29);
			$this->SetX(252.5);
			$this->Cell(35,5," FECHA: ".date("d-m-Y"),0,0,'L');
			$this->SetY(34);
			$this->SetX(252.5);
			$this->Cell(35,5," HORA: ".date('h:i:s a'),0,0,'L');
			//-----------------------------------------------------
			$this->SetY(44);
			$this->Cell(20,5,'Vigencia',1,0,'C',false,0,0,false,'T','C');
			$this->Cell(20,5,'No RP',1,0,'C',false,0,0,false,'T','C');
			$this->Cell(35,5,'Valor RP',1,0,'C',false,0,0,false,'T','C');
			$this->Cell(35,5,'Valor Reintegrado',1,0,'C',false,0,0,false,'T','C');
			$this->Cell(70,5,'Reintegrado Por',1,0,'C',false,0,0,false,'T','C');
			$this->Cell(70,5,'Detalle',1,0,'C',false,0,0,false,'T','C');
			$this->Cell(30,5,'Fecha',1,0,'C',false,0,0,false,'T','C');
		}
		public function Footer() 
		{
			$linkbd=conectar_bd();
			$sqlr="SELECT direccion,telefono,web,email FROM configbasica WHERE estado='S'";
			$resp=mysql_query($sqlr,$linkbd);
			while($row=mysql_fetch_row($resp))
			{
				$direcc=utf8_encode(strtoupper($row[0]));
				$telefonos=$row[1];
				$dirweb=utf8_encode(strtoupper($row[3]));
				$coemail=utf8_encode(strtoupper($row[2]));
			}
			if($direcc!=''){$vardirec="Dirección: $direcc, ";}
			else {$vardirec="";}
			if($telefonos!=''){$vartelef="Telefonos: $telefonos";}
			else{$vartelef="";}
			if($dirweb!=''){$varemail="Email: $dirweb, ";}
			else {$varemail="";}
			if($coemail!=''){$varpagiw="Pagina Web: $coemail";}
			else{$varpagiw="";}
			$this->SetY(-16);
			$this->SetFont('helvetica', 'BI', 8);
			$txt = <<<EOD
$vardirec $vartelef
$varemail $varpagiw
EOD;
			$this->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);
			$this->SetY(-13);
			$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
			$this->Line(10, 190, 288, 190,$styleline);
		}
	}
	$pdf = new MYPDF('L','mm','Letter', true, 'iso-8859-1', false);// create new PDF document
	$pdf->SetDocInfoUnicode (true); 
	// set document information
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('G&CSAS');
	$pdf->SetTitle('RP Reversion Parcial');
	$pdf->SetSubject('RP Reversion Parcial');
	$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
	$pdf->SetMargins(10, 49, 10);// set margins
	$pdf->SetHeaderMargin(49);// set margins
	$pdf->SetFooterMargin(20);// set margins
	$pdf->SetAutoPageBreak(TRUE, 20);// set auto page breaks
	// set some language-dependent strings (optional)
	if (@file_exists(dirname(__FILE__).'/lang/spa.php')) 
	{
		require_once(dirname(__FILE__).'/lang/spa.php');
		$pdf->setLanguageArray($l);
	}
	// ---------------------------------------------------------
	$pdf->AddPage();
	$pdf->SetFont('helvetica','I',9);
	$linkbd=conectar_bd();
	$crit1=" ";
	$crit2=" ";
	$crit3=" ";
	$vig=vigencia_usuarios($_SESSION[cedulausu]);
	if ($_POST[vigencia]!=""){$crit1=" AND TB1.vigencia ='$_POST[vigencia]' ";}
	else {$crit1=" AND TB1.vigencia ='$vig' ";}
	if ($_POST[numero]!=""){$crit2=" AND TB1.consvigencia like '%$_POST[numero]%' ";}
	if ($_POST[fechaini]!="" and $_POST[fechafin]!="" )
	{	
		ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechaini],$fecha);
		$fechai=$fecha[3]."-".$fecha[2]."-".$fecha[1];
		ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechafin],$fecha);
		$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
		$crit3=" AND TB1.fecha between '$fechai' and '$fechaf'  ";
	}
	$sqlr="SELECT TB1.*,TB2.user,TB2.detalle FROM pptorp TB1, pptorp_cab_r TB2 WHERE TB1.estado='R' AND TB1.vigencia=TB2.vigencia AND TB1.consvigencia=TB2.consvigencia AND TB2.tipo_mov='03' $crit1 $crit2 $crit3 ORDER BY TB1.consvigencia";
	$resp = mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($resp))
	{
		
		$sqlr1="SELECT sum(saldo) from pptorp_det_r where consvigencia='$row[1]' and vigencia='$row[0]'";
		$resp1 = mysql_query($sqlr1,$linkbd);
		$row1 =mysql_fetch_row($resp1);
		$altura=6;
		$altini=6;
		$ancini=50;
		$altaux=0;
		$colst01=strlen(utf8_encode($row[9]));
		$colst02=strlen(utf8_encode($row[10]));
		if($colst01>$colst02){$cantidad_lineas= $colst01;}
		else{$cantidad_lineas= $colst02;}
		if($cantidad_lineas > $ancini)
		{
			$cant_espacios = $cantidad_lineas/$ancini;
			$rendondear=ceil($cant_espacios);
			$altaux=$altini*$rendondear;
		}
		if($altaux>$altura){$altura=$altaux;}
		if ($concolor==0){$pdf->SetFillColor(200,200,200);$concolor=1;}
		else {$pdf->SetFillColor(255,255,255);$concolor=0;}
		
		$pdf->Cell(20,$altura,$row[0],1,0,'C',true,0,0,false,'T','C');
		$pdf->Cell(20,$altura,$row[1],1,0,'C',true,0,0,false,'T','C');
		$pdf->Cell(35,$altura,"$ ".number_format((float)$row[6],2,",",".")." ",1,0,'R',true,0,0,false,'T','C');
		$pdf->Cell(35,$altura,"$ ".number_format((float)$row1[0],2,",",".")." ",1,0,'R',true,0,0,false,'T','C');
		$pdf->MultiCell(70,$altura,utf8_encode($row[9]),1,'L',true,0,'','',true,0,false,true,$altura,'M',false);
		$pdf->MultiCell(70,$altura,utf8_encode($row[10]),1,'L',true,0,'','',true,0,false,true,$altura,'M',false);
		$pdf->Cell(30,$altura,date('d-m-Y',strtotime($row[3])),1,1,'C',true,0,0,false,'T','C');
	}
	// ---------------------------------------------------------
	$pdf->Output('reporterprp.pdf', 'I');//Close and output PDF document
?>