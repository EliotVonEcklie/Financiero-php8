<?php
	require_once("tcpdf/tcpdf_include.php");
	require('comun.inc');
	require"funciones.inc";
	date_default_timezone_set("America/Bogota");
	session_start();
	class MYPDF extends TCPDF 
	{
		public function Header() 
		{
			$linkbd=conectar_bd();
			$sqlr="select *from configbasica where estado='S'";
			$res=mysql_query($sqlr,$linkbd);
			while($row=mysql_fetch_row($res))
			{
				$nit=$row[0];
				$rs=$row[1];
				$nalca=$row[6];
			}
			//Parte Izquierda
			$this->Image('imagenes/escudo.jpg', 22, 12, 25, 23.9, 'JPG', '', 'T', true, 300, '', false, false, 0, false, false, false);// Logo
			$this->SetFont('helvetica','B',8);
			$this->SetY(10);
			$this->RoundedRect(10, 10, 199, 31, 1,'' );
			$this->Cell(0.1);
			$this->Cell(50,31,'','R',0,'L'); 
			$this->SetY(11);
			$this->SetX(60);
			$this->SetFont('helvetica','B',12);
			$this->Cell(149,12,strtoupper(iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT","$rs")),0,0,'C'); 
			$this->SetFont('helvetica','B',8);
			$this->SetY(18);
			$this->SetX(60);
			$this->SetFont('helvetica','B',11);
			$this->Cell(149,10,"$nit",0,0,'C');
			//*****************************************************************************************************************************
			$this->SetFont('helvetica','B',14);
			$this->SetY(10);
			$this->Cell(50.1);
			$this->Cell(149,31,'',0,1,'C'); 
			$this->SetY(27);
			$this->SetX(60);
			$this->Cell(111,14,"COMPROBANTE CONSIGNACIONES",0,0,'C'); 
			$mov='';
			if(isset($_POST[movimiento]))
			{
				if(!empty($_POST[movimiento]))
				{
					if($_POST[movimiento]=='401'){$mov="DOCUMENTO DE REVERSION";}
				}
			}
			$this->SetFont('helvetica','B',10);
			$this->SetY(15);
			$this->Cell(50.1);
			$this->Cell(149,20,$mov,0,0,'C'); 
			//************************************
			$this->SetFont('helvetica','I',7);
			$this->SetY(27);
			$this->Cell(50.2);
			$this->Cell(110.7,3,'','T',0,'L');
			$this->SetFont('helvetica','B',10);
			$this->SetY(27);
			$this->Cell(161.1);
			$this->Cell(37.8,14,'','TL',0,'L');
			$this->SetY(27);
			$this->Cell(162);
			$this->Cell(35,5,'NUMERO : '.$_POST[idcomp],0,0,'L');
			$this->SetY(31);
			$this->Cell(162);
			$this->Cell(35,5,'FECHA: '.$_POST[fecha],0,0,'L');
			$this->SetY(35);
			$this->Cell(162);
			$this->Cell(35,5,'VIGENCIA: '.$_POST[vigencia],0,0,'L');
			$this->SetY(27);
			$this->Cell(50.2);
			$this->MultiCell(105.7,4,'',0,'L');		
			//*******************************************
			$this->SetFont('helvetica','B',9);
			$this->RoundedRect(10, 42, 199, 15, 1,'' );
			$this->SetY(42);
			$this->cell(18,5,' DETALLE:',0,0,'L',0);
			$this->multiCell(181,7,''.iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[concepto]),0,'L',false,0,'','',true,0,false,true,0,'L',false);
		
			$this->line(10.1,58,209,58);
			$this->RoundedRect(10,59, 199, 5, 1.2,'' );
			$this->line(10.1,65,209,65);
			$this->SetY(59);
			$this->Cell(0.1);
			$this->SetFont('helvetica','B',10);
			$this->Cell(6,5,'CC',1,0,'C'); 
			$this->Cell(46,5,'CONSIGNACION',1,0,'C');
			$this->Cell(48,5,'CUENTA BANCARIA',1,0,'C');
			$this->Cell(59,5,'BANCO',1,0,'C');
			$this->Cell(40,5,'VALOR',1,1,'C');
		}
		public function Footer() 
		{
			$linkbd=conectar_bd();
			$sqlr="SELECT direccion,telefono,web,email FROM configbasica WHERE estado='S'";
			$resp=mysql_query($sqlr,$linkbd);
			while($row=mysql_fetch_row($resp))
			{
				$direcc=iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",strtoupper($row[0]));
				$telefonos=$row[1];
				$dirweb=iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",strtoupper($row[3]));
				$coemail=iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",strtoupper($row[2]));
			}
			if($direcc!=''){$vardirec="Dirección: $direcc, ";}
			else {$vardirec="";}
			if($telefonos!=''){$vartelef="Telefonos: $telefonos";}
			else{$vartelef="";}
			if($dirweb!=''){$varemail="Email: $dirweb, ";}
			else {$varemail="";}
			if($coemail!=''){$varpagiw="Pagina Web: $coemail";}
			else{$varpagiw="";}
			$this->SetFont('helvetica', 'I', 8);
			$txt = <<<EOD
$vardirec $vartelef
$varemail $varpagiw
EOD;
			$this->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);
			$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
			
		}
	}
	$pdf = new MYPDF('P','mm','Letter', true, 'iso-8859-1', false);// create new PDF document
	$pdf->SetDocInfoUnicode (true); 
	// set document information
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('G&CSAS');
	$pdf->SetTitle('Certificados');
	$pdf->SetSubject('Certificado de Disponibilidad');
	$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
	$pdf->SetMargins(10, 66, 10);// set margins
	$pdf->SetHeaderMargin(66);// set margins
	$pdf->SetFooterMargin(20);// set margins
	$pdf->SetAutoPageBreak(TRUE, 20);// set auto page breaks
	// set some language-dependent strings (optional)
	if (@file_exists(dirname(__FILE__).'/lang/spa.php')) 
	{
		require_once(dirname(__FILE__).'/lang/spa.php');
		$pdf->setLanguageArray($l);
	}
	$pdf->AddPage();
	$con=0;
	while ($con<count($_POST[dccs]))
	{	
		if ($con%2==0) {$pdf->SetFillColor(245,245,245);}
		else {$pdf->SetFillColor(255,255,255);}
		$pdf->Cell(6,4,''.$_POST[dccs][$con],0,0,'C',1);
		$pdf->Cell(46,4,$_POST[dconsig][$con],0,0,'L',1);
		$pdf->Cell(48,4,$_POST[dcbs][$con],0,0,'L',1);
		$pdf->Cell(59,4,substr(''.$_POST[dnbancos][$con],0,28),0,0,'L',1);
		$pdf->Cell(40,4,''.$_POST[dvalores][$con],0,0,'R',1);
		$pdf->ln(4);	
		$con=$con+1;
	}
	$pdf->SetFont('helvetica','B',10);
	$pdf->ln(4);
	$pdf->SetLineWidth(0.5);
	$pdf->cell(108,5,'','T',0,'R');
	$pdf->cell(51,5,'Total','T',0,'R');
	$pdf->cell(40,5,''.$_POST[totalcf],'T',0,'R');
	$pdf->ln(10);
	$pdf->SetLineWidth(0.2);
	$v=$pdf->gety();
	$pdf->RoundedRect(10, $v-1, 199, 10, 1.2,'' );
	$pdf->MultiCell(199,4,'SON: '.$_POST[letras],0,'L');
	$pdf->ln(20);
	$pdf->cell(60);
	$pdf->Cell(80,5,'ELABORO: '.$_SESSION[usuario],'T',0,'C');
	$pdf->Output();
?> 


