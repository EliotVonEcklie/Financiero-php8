<?php
	require_once("tcpdf/tcpdf_include.php");
	require('comun.inc');
	require"funciones.inc";
	session_start();
	class MYPDF extends TCPDF 
	{
		public function Header() 
		{
			$linkbd=conectar_v7();
			$sqlr="SELECT * FROM configbasica WHERE estado='S'";
			$res=mysqli_query($linkbd,$sqlr);
			while($row=mysqli_fetch_row($res))
			{
				$nit=$row[0];
				$rs=$row[1];
			}
			$sqlr="SELECT codnovedad FROM hum_prenomina WHERE num_liq ='".$_POST['idcomp']."'";
			$res=mysqli_query($linkbd,$sqlr);
			$row=mysqli_fetch_row($res);
			$sqlr2="SELECT descripcion FROM hum_novedadespagos WHERE codigo ='$row[0]'";
			$res2=mysqli_query($linkbd,$sqlr2);
			while($row2=mysqli_fetch_row($res2))
			{
				if($row2[0]!=''){$descrip=utf8_decode($row2[0]);}
			}
			$this->Image('imagenes/escudo.jpg', 22, 12, 25, 23.9, 'JPG', '', 'T', true, 300, '', false, false, 0, false, false, false);// 
			$this->SetFont('helvetica','B',7);
			$this->SetY(10);
			$this->RoundedRect(10, 10, 199, 31, 2,'' );
			$this->Cell(0.1);
			$this->Cell(50,31,'','R',0,'L'); 
			$this->SetY(10);
			$this->SetX(58);
			$this->SetFont('helvetica','B',12);
			$this->Cell(142,15,"$rs",0,0,'C'); 
			$this->SetY(16);
			$this->SetX(58);
			$this->SetFont('helvetica','B',11);
			$this->Cell(142,10,"$nit",0,0,'C');
			
			//*****************************************************************************************************************************
			$this->SetFont('helvetica','B',14);
			$this->SetY(10);
			$this->Cell(50.1);
			$this->Cell(149,31,'',0,1,'C'); 
			$this->SetY(8);
			$this->Cell(50.1);
			//************************************
			$this->SetFont('helvetica','B',10);
			$this->SetY(27);
			$this->Cell(161.1);
			$this->Cell(37.8,14,'','TL',0,'L');
			$this->SetY(27.5);
			$this->Cell(162);
			$this->Cell(35,5,'NUMERO : '.$_POST['idcomp'],0,0,'L');
			$this->SetY(31.5);
			$this->Cell(162);
			$this->Cell(35,5,'VIGENCIA F.: '.$_POST['vigencia'],0,0,'L');
			$this->SetY(35.5);
			$this->Cell(162);
			$this->Cell(35,5,'FECHA: '.$_POST['fecha'],0,0,'L');
			$ncc=buscacentro($_POST['cc']);
			if($ncc=='')
			$ncc='TODOS';
			$this->SetY(27);
			$this->Cell(50.2);
			$this->Cell(111,7,'SOLICITUD DE DISPONIBILIDAD PRESUPUESTAL','T',0,'C'); 
			$this->SetFont('helvetica','B',12);
			$this->SetY(46);
			$this->ln(1);
			$this->SetFont('helvetica','B',10);
			$this->cell(0.1);
			$mesle=mesletras($_POST['periodo']);
			$this->Cell(199,4,"OBJETO: $descrip",0,1,'L',false,0,0,false,'T','C');
			$this->Cell(199,4,"CENTRO DE COSTO: ".$_POST['cc']." $ncc.",0,0,'L',false,0,0,false,'T','C');
			$this->line(10,60,209,60);
			$this->RoundedRect(10,61, 199, 5, 1,'' );
			//************************************************************************************************************
			$this->SetFont('helvetica','B',9);
			$this->SetY(61);
			$this->Cell(0.1);
			$this->Cell(24,5,'CODIGO ',0,1,'C'); 
			$this->SetY(61);
			$this->Cell(24.1);
			$this->Cell(78,5,'RUBRO',0,1,'C');		
			$this->SetY(61);
			$this->Cell(165);
			$this->Cell(34,5,'VALOR',0,1,'C');
			$this->line(10,67,209,67);
			$this->ln(2);
			//********************************************************************************************************************
		}
		public function Footer() 
		{
			$linkbd=conectar_v7();
			$sqlr="SELECT direccion,telefono,web,email FROM configbasica WHERE estado='S'";
			$resp=mysqli_query($linkbd,$sqlr);
			while($row=mysqli_fetch_row($resp))
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
			//$this->SetY(-16);
			$this->SetFont('helvetica', 'I', 8);
			$txt = <<<EOD
$vardirec $vartelef
$varemail $varpagiw
EOD;
			$this->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);
			//$this->SetY(-13);
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
	$pdf->SetMargins(10, 101, 10);// set margins
	$pdf->SetHeaderMargin(101);// set margins
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
	$pdf->SetFont('Times','',8);
	$pdf->SetY(68);   
	$con=0;
	while ($con<count($_POST['rubrosp']))
	{	
		if ($con%2==0){$pdf->SetFillColor(245,245,245);}
		else {$pdf->SetFillColor(255,255,255);}
		$desrubro=utf8_decode($_POST['nrubrosp'][$con]);
		$pdf->Cell(30,4,''.$_POST['rubrosp'][$con],0,0,'L',1);
		$pdf->Cell(135,4,substr(''.$desrubro,0,80),0,0,'L',1);
		$pdf->Cell(34,4,''.number_format($_POST['vrubrosp'][$con],2),0,0,'R',1);
		$pdf->ln(4);	
		$con=$con+1;
	}
	$pdf->SetFont('helvetica','B',10);
	$pdf->ln(4);
	$pdf->SetLineWidth(0.5);
	$pdf->cell(110,5,'','T',0,'R');
	$pdf->cell(54,5,'Total','T',0,'R');
	$pdf->cell(35,5,'$ '.number_format(array_sum($_POST['vrubrosp']),2),'T',0,'R');
	$pdf->SetLineWidth(0.2);
	
	$pdf->ln(10);
	$linkbd=conectar_v7();
	$sqlr="SELECT funcionario,nomcargo FROM firmaspdf_det WHERE idfirmas='1' AND estado ='S' AND fecha < '".$_POST['fecha']."' ORDER BY orden";
	$res=mysqli_query($linkbd,$sqlr);
	while($row=mysqli_fetch_row($res))
	{
		$_POST['ppto'][]=$row[0];
		$_POST['nomcargo'][]=$row[1];
	}
	for($x=0;$x<count($_POST['ppto']);$x++)
	{
		$pdf->ln(14);
		$v=$pdf->gety();
		if($v>=251){ 
			$pdf->AddPage();
			$pdf->ln(20);
			$v=$pdf->gety();
		}
		$pdf->setFont('times','B',8);
		if (($x%2)==0) 
		{
			if(isset($_POST['ppto'][$x+1]))
			{
				$pdf->Line(17,$v,107,$v);
				$pdf->Line(112,$v,202,$v);
				$v2=$pdf->gety();
				$pdf->Cell(104,4,''.iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST['ppto'][$x]),0,1,'C',false,0,0,false,'T','C');
				$pdf->Cell(104,4,''.iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST['nomcargo'][$x]),0,1,'C',false,0,0,false,'T','C');
				$pdf->SetY($v2);
				$pdf->Cell(295,4,''.iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST['ppto'][$x+1]),0,1,'C',false,0,0,false,'T','C');
				$pdf->Cell(295,4,''.iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST['nomcargo'][$x+1]),0,1,'C',false,0,0,false,'T','C');
			}
			else
			{
				$pdf->Line(50,$v,160,$v);
				$pdf->Cell(190,4,''.iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST['ppto'][$x]),0,1,'C',false,0,0,false,'T','C');
				$pdf->Cell(190,4,''.iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST['nomcargo'][$x]),0,0,'C',false,0,0,false,'T','C');
			}
			$v3=$pdf->gety();
		}
		$pdf->SetY($v3);
		$pdf->SetFont('helvetica','',7);
	}
	$pdf->Output('solicitudcdp.pdf', 'I');
?>


