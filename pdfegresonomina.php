<?php
	require_once("tcpdf/tcpdf_include.php");
	require('comun.inc');
	require('funciones.inc');
	require('conversor.php');
	date_default_timezone_set("America/Bogota");
	sesion();
	class MYPDF extends TCPDF 
	{
		public function Header()//Cabecera de página
		{
			$linkbd=conectar_v7();
			$sqlr="SELECT * FROM configbasica WHERE estado='S'";
			$res=mysqli_query($linkbd,$sqlr);
			while($row=mysqli_fetch_row($res))
			{
				$nit=$row[0];
				$rs=$row[1];
				$nalca=$row[6];
			}
			$this->Image('imagenes/escudo.jpg', 22, 12, 25, 23.9, 'JPG', '', 'T', true, 300, '', false, false, 0, false, false, false);// Logo
			$this->SetY(10);
			$this->RoundedRect(10, 10, 199, 31, 2.5,'' );
			$this->Cell(0.1);
			$this->Cell(50,31,'','R',0,'L'); 
			$this->SetY(10);
			$this->Cell(50.1);
			$this->Cell(149,31,'',0,1,'C'); 
			$this->SetFont('helvetica','B',12);
			$this->SetY(10);
			$this->Cell(50.1);
			$this->Cell(149,12,strtoupper(iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT","$rs")),0,0,'C'); 
			$this->SetFont('helvetica','B',8);
			$this->SetY(18);
			$this->SetX(60);
			$this->SetFont('helvetica','B',11);
			$this->Cell(149,10,"$nit",0,0,'C');
			$this->SetFont('helvetica','B',12);
			$this->SetY(10);
			$this->Cell(50.1);
			$this->Cell(149,31,'',0,1,'C'); 
			$this->SetY(27);
			$this->SetX(60);
			$this->Cell(111,14,"COMPROBANTE EGRESO DE NOMINA",1,0,'C'); 
			$this->SetFont('helvetica','B',10);
			$this->SetY(27);
			$this->Cell(161.1);
			$this->Cell(37.8,14,'','TL',0,'L');
			$this->SetY(27);
			$this->Cell(162);
			$this->Cell(35,5,"NUMERO : ".$_POST['egreso'],0,0,'L');
			$this->SetY(31);
			$this->Cell(162);
			$this->Cell(35,5,"FECHA: ".$_POST['fecha'],0,0,'L');
			$this->SetY(35);
			$this->Cell(162);
			$fechavig=explode('/',$_POST['fecha']);
			$this->Cell(35,5,"VIGENCIA: ".$fechavig[2],0,0,'L');
			$this->SetY(27);
			$this->Cell(50.2);
			$this->MultiCell(105.7,4,'',0,'L');
			$this->SetFont('times','B',10);
			//***************************************************************************************************
		}
		public function Footer() //Pie de página
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
	$pdf->SetMargins(10, 48, 10);// set margins
	$pdf->SetHeaderMargin(48);// set margins
	$pdf->SetFooterMargin(20);// set margins
	$pdf->SetAutoPageBreak(TRUE, 20);// set auto page breaks
	// set some language-dependent strings (optional)
	if (@file_exists(dirname(__FILE__).'/lang/spa.php')) 
	{
		require_once(dirname(__FILE__).'/lang/spa.php');
		$pdf->setLanguageArray($l);
	}
	$pdf->AddPage();
	$pdf->SetFont('Times','',10);
	$pdf->SetAutoPageBreak(true,20);
	$pdf->SetFont('helvetica','B',12);
	$pdf->SetY(46);   
	$pdf->cell(125);
	$pdf->cell(27,8,'NETO A PAGAR: ',0,0,'R');
	$pdf->RoundedRect(161, 46 ,48 , 8, 2,'');
	$pdf->cell(45,8,'$'.number_format($_POST['valorpagar'],2),0,0,'R');
	$pdf->ln(10);
	$pdf->cell(0.2);
	$pdf->SetFillColor(245,245,245);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(35,5,'Detalle: ','LT',0,'L',1);
	$detallegreso = iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST['concepto']);
	$pdf->SetFont('helvetica','',10);
	$pdf->MultiCell(164,5,"$detallegreso",'TR','L',true,1,'','',true,0,false,true,0,'T',false);
	$pdf->SetFillColor(255,255,255);
	$pdf->cell(0.2);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(35,5,'Beneficiario: ','L',0,'L',1);
	$pdf->SetFont('helvetica','',10);
	$beneficiariot=iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST['ntercero']);
	$pdf->cell(164,5,''.strtoupper($beneficiariot),'R',1,'L',1);
	$pdf->cell(0.2);  
	$pdf->SetFillColor(245,245,245);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(35,5,'C.C. o NIT: ','L',0,'L',1);
	$pdf->SetFont('helvetica','',10);
	$pdf->cell(164,5,''.$_POST['tercero'],'R',1,'L',1);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(0.2);
	$pdf->cell(35,5,'No CxP:','L',0,'L',1);
	$pdf->SetFont('helvetica','',10);
	$pdf->cell(40,5,''.$_POST['orden'],0,0,'L',1);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(35,5,'FORMA PAGO:',0,0,'L',1);
	$pdf->SetFont('helvetica','',9);
	$pdf->cell(89,5,''.strtoupper($_POST['tipop']),'R',1,'L',1);
	$pdf->SetFillColor(245,245,245);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(0.2);
	$pdf->cell(35,5,'Banco: ','L',0,'L',1);
	$pdf->SetFont('helvetica','',9);
	$pdf->cell(91,5,''.substr(strtoupper($_POST['nbanco']),0,80),0,0,'L',1);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(15,5,'N Cta.:',0,0,'L',1);
	$pdf->SetFont('helvetica','',10);
	$pdf->cell(58,5,''.$_POST['tcta'].' '.$_POST['cb'],'R',1,'L',1);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(0.2);
	$pdf->cell(35,5,'CHEQUE/TRANSF.:','L',0,'L',1);
	$pdf->SetFont('helvetica','',10);
	$pdf->cell(164,5,''.$_POST['ntransfe'].$_POST['ncheque'],'R',1,'L',1);
	$pdf->SetFillColor(245,245,245);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(0.2);
	$pdf->cell(35,5,'Valor Pago:','L',0,'L',1);
	$pdf->SetFont('helvetica','',10);
	$pdf->cell(40,5,'$'.number_format($_POST['valororden'],2),0,0,'L',1);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(25,5,'Retenciones: ',0,0,'L',1);
	$pdf->SetFont('helvetica','',10);
	$pdf->cell(35,5,'$'.number_format($_POST['retenciones'],2),0,0,'L',1);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(25,5,'Neto a Pagar:',0,0,'L',1);
	$pdf->SetFont('helvetica','',10);
	$pdf->cell(39,5,'$'.number_format($_POST['valorpagar'],2),'R',1,'L',1);
	$pdf->SetFillColor(255,255,255);
	$pdf->cell(0.2);
	$pdf->SetFont('helvetica','B',10);
	$resultado = convertir($_POST['valorpagar']);
	$valletras=$resultado." PESOS M/CTE";
	$pdf->MultiCell(199,5,'Son: '.strtoupper($valletras),'LBR','L',true,1,'','',true,0,false,true,0,'T',false);
	$pdf->ln(8);
	$y=$pdf->GetY();
	$pdf->SetY($y);
	$pdf->SetFillColor(222,222,222);
	$pdf->SetFont('helvetica','B',10);
	$pdf->Cell(0.1);
	$pdf->Cell(199,5,'DETALLE EGRESO',0,0,'C',1); 
	$pdf->ln(6); 
	$y=$pdf->GetY();	
	$pdf->SetFillColor(222,222,222);
	$pdf->SetFont('helvetica','B',10);
	$pdf->SetY($y);
	$pdf->Cell(0.1);
	$pdf->Cell(22,5,'Codigo ',0,0,'C',1); 
	$pdf->SetY($y);
	$pdf->Cell(23.1);
	$pdf->Cell(110,5,'Concepto',0,0,'C',1);
	$pdf->SetY($y);
	$pdf->Cell(134.1);
	$pdf->Cell(20,5,'CC',0,0,'C',1);
	$pdf->SetY($y);
	$pdf->Cell(155);
	$pdf->Cell(44,5,'Valor',0,0,'C',1);
	$pdf->SetFont('helvetica','',8);
	$cont=0;
	$pdf->ln(5);
	for($x=0;$x<count($_POST['decuentas']);$x++)
	{
		if ($con%2==0){$pdf->SetFillColor(255,255,255);}
		else {$pdf->SetFillColor(245,245,245);}
		$pdf->Cell(22,4,''.$_POST['decuentas'][$x],'',0,'C',1);
		$pdf->Cell(110,4,''.iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST['dencuentas'][$x]),'',0,'L',1);
		$pdf->Cell(20,4,''.$_POST['deccs'][$x].'','',0,'R',1);
		$pdf->Cell(47,4,'$'.number_format($_POST['devalores'][$x],2),'',1,'R',1);
		$con=$con+1;
	}
	$pdf->ln(10);
	preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $_POST['fecha'],$fecha);
	$fechaf="$fecha[3]-$fecha[2]-$fecha[1]";
	$firmas=buscarfirmaspdf('2',$fechaf,$_POST['ntercero'],$_POST['tercero']);
	for($x=0;$x<count($firmas[0]);$x++)
	{
		$pdf->ln(14);
		$v=$pdf->gety();
		if($v>=251)
		{ 
			$pdf->AddPage();
			$pdf->ln(20);
			$v=$pdf->gety();
		}
		$pdf->setFont('times','B',8);
		if (($x%2)==0) 
		{
			if(isset($firmas[0][$x+1]))
			{
				$pdf->Line(17,$v,107,$v);
				$pdf->Line(112,$v,202,$v);
				$v2=$pdf->gety();
				$pdf->Cell(104,4,''.iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$firmas[0][$x]),0,1,'C',false,0,0,false,'T','C');
				$pdf->Cell(104,4,''.iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$firmas[1][$x]),0,1,'C',false,0,0,false,'T','C');
				$pdf->SetY($v2);
				$pdf->Cell(295,4,''.iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$firmas[0][$x+1]),0,1,'C',false,0,0,false,'T','C');
				$pdf->Cell(295,4,''.iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$firmas[1][$x+1]),0,1,'C',false,0,0,false,'T','C');
			}
			else
			{
				$pdf->Line(50,$v,160,$v);
				$pdf->Cell(190,4,''.iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$firmas[0][$x]),0,1,'C',false,0,0,false,'T','C');
				$pdf->Cell(190,4,''.iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$firmas[1][$x]),0,0,'C',false,0,0,false,'T','C');
			}
			$v3=$pdf->gety();
		}
		$pdf->SetY($v3);
		$pdf->SetFont('helvetica','',7);
	}
	$pdf->Output('EgresoNomina.pdf', 'I');
?>