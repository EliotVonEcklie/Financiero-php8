<?php
//V 1000 12/12/16 
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
			$this->RoundedRect(10, 10, 270, 31, 2.5,''); //Borde del encabezado
			$this->Cell(52,31,'','R',0,'L'); //Linea que separa el encabazado verticalmente
			$this->SetY(32.5);
			$this->Cell(52,5,''.$rs,0,0,'C',false,0,1,false,'T','B'); //Nombre Municipio
			$this->SetFont('helvetica','B',8);
			$this->SetY(36.5);
			$this->Cell(52,5,''.$nit,0,0,'C',false,0,1,false,'T','C'); //Nit
			$this->SetFont('helvetica','B',14);
			$this->SetY(10);
			$this->SetX(62);
			$this->Cell(100,17,'INFORME DE INDICADORES',0,0,'C'); 
			$this->SetFont('helvetica','I',10);
			$this->SetY(27);
			$this->SetX(62);
			$this->Cell(100,17,'Vigencia '.$_POST[vigenciai].' - '.$_POST[vigenciaf],0,0,'C'); 

			$this->SetFont('helvetica','B',9);
			$this->SetY(10);
			$this->SetX(152);
			$this->Cell(37.8,30.7,'','L',0,'L');
			$this->SetY(29);
			$this->SetX(152.5);
			$this->Cell(35,5," FECHA: ".date("d-m-Y"),0,0,'L');
			$this->SetY(34);
			$this->SetX(152.5);
			$this->Cell(35,5," HORA: ".date('h:i:s a'),0,0,'L');
			//-----------------------------------------------------
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
			
			$this->SetY(-16);
			$this->SetFont('helvetica', 'BI', 8);
			$txt = <<<EOD
Dirección: $direcc, Telefonos: $telefonos
Email:$dirweb, Pagina Web: $coemail
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
	$pdf->SetTitle('Comprobante Radicación');
	$pdf->SetSubject('Radicación de Documentos');
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
	$linkbd=conectar_bd();
	$cond1="";
	$cond2="";
	$cond3="";
	$cond4="";
	$cond5="";
	if($_POST[orden]>1){
		for($i=1;$i<$_POST[orden];$i++)
		{
			$sqln="SELECT nombre FROM plannivelespd WHERE orden='$i' AND inicial='$_POST[vigenciai]' AND final='$_POST[vigenciaf]'";
			$resn=mysql_query($sqln,$linkbd);
			$wres=mysql_fetch_array($resn);
			if($i==1) $buspad='';
			elseif($_POST[arrpad][($i-1)]!="")
				$buspad=$_POST[arrpad][($i-1)];
			else
				$buspad='0';
			$pdf->SetFont('helvetica','B',9);
			$pdf->Cell(20,5,strtoupper($wres[0]).':',0,1,'L');
			$sqlr="SELECT * FROM presuplandesarrollo WHERE padre='$buspad' AND vigencia='$_POST[vigenciai]' AND vigenciaf='$_POST[vigenciaf]' ORDER BY codigo";
			$res=mysql_query($sqlr,$linkbd);
			$row =mysql_fetch_row($res);
			$pdf->SetFont('helvetica','I',9);
			$pdf->Cell(20,5,$row[0].' - '.$row[1],0,1,'L');
		}
	}
	$pdf->Ln(3);
	$pdf->RoundedRect(10, 95, 20, 20, 2.5,''); 
	$pdf->SetY(100);
	$pdf->SetX(10);
	$pdf->Cell(20,5,'Tipo',0,0,'C');
	$pdf->RoundedRect(30, 95, 40, 10, 2.5,''); 
	$pdf->RoundedRect(70, 95, 40, 10, 2.5,''); 
	$pdf->RoundedRect(110, 95, 40, 10, 2.5,''); 
	$pdf->RoundedRect(150, 95, 40, 10, 2.5,'');
	$f=30;
	for($x=$_POST[vigenciai]; $x<=$_POST[vigenciaf];$x++){
		$pdf->SetY(100);
		$pdf->SetX($f);
		$pdf->Cell(40,5,$x,0,0,'C');
		$f+=40;
	}
	$pdf->RoundedRect(30, 105, 20, 10, 2.5,''); 
	$pdf->RoundedRect(50, 105, 20, 10, 2.5,''); 
	$pdf->RoundedRect(70, 105, 20, 10, 2.5,''); 
	$pdf->RoundedRect(90, 105, 20, 10, 2.5,''); 
	$pdf->RoundedRect(110, 105, 20, 10, 2.5,''); 
	$pdf->RoundedRect(130, 105, 20, 10, 2.5,''); 
	$pdf->RoundedRect(150, 105, 20, 10, 2.5,'');
	$pdf->RoundedRect(170, 105, 20, 10, 2.5,''); 
	$f=20;
	for($x=$_POST[vigenciai]; $x<=$_POST[vigenciaf];$x++){
		$pdf->SetY(110);
		$pdf->SetX($f);
		$pdf->Cell(40,5,'Programado',0,0,'C');
		$f+=20;
		$pdf->SetY(110);
		$pdf->SetX($f);
		$pdf->Cell(40,5,'Ejecutado',0,0,'C');
		$f+=20;
	}
	//medibles
	$pdf->RoundedRect(10, 115, 20, 10, 2.5,''); 
	$pdf->RoundedRect(30, 115, 20, 10, 2.5,''); 
	$pdf->RoundedRect(50, 115, 20, 10, 2.5,''); 
	$pdf->RoundedRect(70, 115, 20, 10, 2.5,''); 
	$pdf->RoundedRect(90, 115, 20, 10, 2.5,''); 
	$pdf->RoundedRect(110, 115, 20, 10, 2.5,''); 
	$pdf->RoundedRect(130, 115, 20, 10, 2.5,''); 
	$pdf->RoundedRect(150, 115, 20, 10, 2.5,'');
	$pdf->RoundedRect(170, 115, 20, 10, 2.5,''); 
	$pdf->SetY(120);
	$pdf->SetX(10);
	$pdf->Cell(20,5,'Medibles',0,0,'C');

	//cuantificables
	$pdf->RoundedRect(10, 125, 20, 10, 2.5,''); 
	$pdf->RoundedRect(30, 125, 20, 10, 2.5,''); 
	$pdf->RoundedRect(50, 125, 20, 10, 2.5,''); 
	$pdf->RoundedRect(70, 125, 20, 10, 2.5,''); 
	$pdf->RoundedRect(90, 125, 20, 10, 2.5,''); 
	$pdf->RoundedRect(110, 125, 20, 10, 2.5,''); 
	$pdf->RoundedRect(130, 125, 20, 10, 2.5,''); 
	$pdf->RoundedRect(150, 125, 20, 10, 2.5,'');
	$pdf->RoundedRect(170, 125, 20, 10, 2.5,''); 
	$pdf->SetY(130);
	$pdf->SetX(10);
	$pdf->Cell(20,5,'Cuantificables',0,0,'C');
	// ---------------------------------------------------------
	$pdf->Output('reportetareas.pdf', 'I');//Close and output PDF document
?>