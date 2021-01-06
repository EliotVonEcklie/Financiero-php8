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
			$this->Image('imagenes/escudo.jpg', 25, 10, 25, 23.9, 'JPG', '', 'T', true, 300, '', false, false, 0, false, false, false);// Logo
			$this->SetFont('helvetica','B',8);
			$this->SetY(10);
			$this->RoundedRect(10, 10, 190, 31, 2.5,''); //Borde del encabezado
			$this->Cell(52,31,'','R',0,'L'); //Linea que separa el encabazado verticalmente
			$this->SetY(31);
			$this->Cell(52,5,''.$rs,0,0,'C',false,0,1,false,'T','B'); //Nombre Municipio
			$this->SetFont('helvetica','B',8);
			$this->SetY(35);
			$this->Cell(52,5,''.$nit,0,0,'C',false,0,1,false,'T','C'); //Nit
			$this->SetFont('helvetica','B',10);
			$this->SetY(10);
			$this->SetX(62);
			$this->Cell(100,17,"ACTO ADMINISTRATIVO DE ACUERDO DE RECUPERACIÓN",1,0,'C'); 
			$this->SetFont('helvetica','I',10);
			$this->SetY(27);
			$this->SetX(62);
			if($_POST[estadogn]=='N'){$estado="ACTO ADMINISTRATIVO ANULADO";}
			elseif($_POST[estadogn]=='S'){$estado="ACTO ADMINISTRATIVO ASIGNADO";}
			else{$estado='';}
			$this->SetFont('helvetica','B',10);
			$this->Cell(100,7,$estado,'T',0,'C',false,0,1); 
			$this->SetY(27);
			$this->SetX(62);
			$this->Cell(100,7,"",0,0,'L',false,0,1);
			$this->SetFont('helvetica','B',9);
			$this->SetY(10);
			$this->SetX(162);
			$this->Cell(37.8,30.7,'','L',0,'L');
			$this->SetY(20);
			$this->SetX(162.5);
			$this->Cell(35,5," NUMERO: ".$_POST[codigo],0,0,'L');
			$this->SetY(27);
			$this->SetX(162.5);
			$this->Cell(35,5," FECHA: ".$_POST[fecha],0,0,'L');
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
			$this->SetY(-16);
			$this->SetFont('helvetica', 'I', 8);
			$txt = <<<EOD
$vardirec $vartelef
$varemail $varpagiw
EOD;
			$this->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);
			$this->SetY(-13);
			$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
			
		}
	}
		
	$pdf = new MYPDF('P','mm','Letter', true, 'iso-8859-1', false);// create new PDF document
	$pdf->SetDocInfoUnicode (true); 
	// set document information
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('G&CSAS');
	$pdf->SetTitle('Recuperaciones');
	$pdf->SetSubject('Actos Administrativos de Recuperaciones');
	$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
	$pdf->SetMargins(10, 45, 10);// set margins
	$pdf->SetHeaderMargin(45);// set margins
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
	$pdf->SetFont('helvetica','',12);
	$fechaen = explode('-', $_POST[fecha]);
	$mesen=mesletras($fechaen[1]);
	$infoinicio="En la ciudad de $_POST[ciudad] a los $fechaen[0] días del mes de $mesen del $fechaen[2] en el $_POST[lugarfi], se procede a la entrega física de los bienes recuperados efectuada por $_POST[ntercero].";
	$pdf->MultiCell(190,4,$infoinicio,0,'L',false,1,'','',true,2,false,true,0,'M',false);
	$pdf->ln(2);
	$pdf->MultiCell(190,4,iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[motivo]),0,'L',false,1,'','',true,2,false,true,0,'M',false);
	$pdf->ln(2);
	if($_POST[otdetalles]!="")
	{
		$pdf->MultiCell(190,4,iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[otdetalles]),0,'L',false,1,'','',true,2,false,true,0,'M',false);
		$pdf->ln(2);
	}
	$pdf->SetFont('helvetica','',11);
	$pdf->Cell(30,4,"Articulos Recuperados:",0,1,'L',false,0,0,false,'T','C');
	$pdf->Cell(8,4,"N°",1,0,'C',false,0,0,false,'T','C');
	$pdf->Cell(52,4,"Descripción",1,0,'C',false,0,0,false,'T','C');
	$pdf->Cell(40,4,"Unidad de Medida",1,0,'C',false,0,0,false,'T','C');
	$pdf->Cell(30,4,"Cantidad",1,0,'C',false,0,0,false,'T','C');
	$pdf->Cell(30,4,"Valor",1,0,'C',false,0,0,false,'T','C');
	$pdf->Cell(30,4,"Estado",1,1,'C',false,0,0,false,'T','C');
	$con=0;
	while ($con<count($_POST[agdescripcion]))
	{
		$altura=6;
		$altini=6;
		$ancini=50;
		$altaux=0;
		$colst01=strlen(iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[dncuentas][$con]));
		if($colst01 > $ancini)
		{
			$cant_espacios = $colst01/$ancini;
			$rendondear=ceil($cant_espacios);
			$altaux=$altini*$rendondear;
		}
		if($altaux>$altura){$altura=$altaux;}
		if ($concolor==0){$pdf->SetFillColor(200,200,200);$concolor=1;}
		else {$pdf->SetFillColor(255,255,255);$concolor=0;}
		$pdf->SetFont('times','',9);
		if($_POST[agestado][$con]=='U'){$mdestado="Usado";}
		else{$mdestado="Nuevo";}
		$pdf->Cell(8,$altura,($con+1),1,0,'L',true,0,0,false,'T','C');
		$pdf->MultiCell(52,$altura,iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[agdescripcion][$con]),1,'L',true,0,'','',true,0,false,true,$altura,'M',false);
		$pdf->Cell(40,$altura,iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[agunimedida][$con]),1,0,'L',true,0,0,false,'T','C');
		$pdf->Cell(30,$altura,number_format($_POST[agcantidad][$con],0,$_SESSION["spdecimal"],$_SESSION["spmillares"])."   ",1,0,'R',true,0,0,false,'T','C');
		$pdf->Cell(30,$altura,"$ ".number_format($_POST[agvalor][$con],2,$_SESSION["spdecimal"],$_SESSION["spmillares"])."   ",1,0,'R',true,0,0,false,'T','C');
		$pdf->Cell(30,$altura,$mdestado,1,1,'L',true,0,0,false,'T','C');
		$con++;
	}
	$pdf->Cell(130,6,'TOTAL:',0,0,'R',false,0,0,false,'T','C');
	$pdf->setFont('times','B',9);
	$pdf->Cell(30,6,"$ ".number_format(array_sum($_POST[agvalor]),2,$_SESSION["spdecimal"],$_SESSION["spmillares"])."  ",1,1,'R',false,0,0,false,'T','C');
	$pdf->ln(2);
	$pdf->SetFont('helvetica','',12);
	$infoadicional="Al respecto, se hace entrega en fotocopia de la documentación sustentatoria presentada; sobre la leagalidad de los bienes recuperados, para su registro respectivo.";
	$pdf->MultiCell(190,4,$infoadicional,0,'L',false,1,'','',true,2,false,true,0,'M',false);
	$pdf->ln(2);
	$pdf->Cell(190,4,"En señal de conformidad se firma la presente Acta.",0,1,'L',false,0,0,false,'T','C');
	$pdf->ln(15);
	$con=0;
	$conx=10;
	$cony=$pdf->GetY();
	while ($con<count($_POST[agtercerop]))
	{
		$pdf->SetY($cony);
		$pdf->SetX($conx);
		$pdf->SetFont('helvetica','',10);
		$pdf->Cell(88,4,iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[agntercerop][$con]),'T',1,'C',false,0,0,false,'T','C');
		$pdf->SetX($conx);
		$pdf->SetFont('helvetica','',9);
		$pdf->Cell(88,4,iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[agcargop][$con]),0,1,'C',false,0,0,false,'T','C');
		if($conx==10){$conx=100;}
		else 
		{
			$conx=10;
			$pdf->ln(15);
			$cony=$pdf->GetY();
		}
		$con++;
	}
	// ---------------------------------------------------------
	$pdf->Output('Actorecuperacion.pdf', 'I');//Close and output PDF document
?>