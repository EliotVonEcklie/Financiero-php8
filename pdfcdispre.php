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
			$this->Image('imagenes/escudo.jpg', 22, 12, 25, 23.9, 'JPG', '', 'T', true, 300, '', false, false, 0, false, false, false);// Logo
			$this->SetFont('helvetica','B',8);
			$this->SetY(10);
			$this->RoundedRect(10, 10, 190, 31, 2.5,''); //Borde del encabezado
			$this->Cell(48,31,'','R',0,'L'); //Linea que separa el encabazado verticalmente
			$this->SetY(10);
			$this->SetFont('helvetica','B',12);
			if(strlen($rs)<40)
			{
				$this->SetX(58);
				$this->Cell(142,15,"$rs",0,0,'C');
				$this->SetY(16);
			}
			else
			{
				$this->Cell(71);
				$this->MultiCell(100,15,$rs,0,'C',false,1,'','',true,4,false,true,19,'T',false);
				$this->SetY(18);
			}
			
			$this->SetX(58);
			$this->SetFont('helvetica','B',11);
			$this->Cell(142,10,"$nit",0,0,'C');
			$this->SetY(27);
			$this->SetX(58);
			$this->Cell(104,14,"CERTIFICADO DE DISPONIBILIDAD PRESUPUESTAL ",1,0,'C'); 
			$this->SetFont('helvetica','I',10);
			$this->SetY(27);
			$this->SetX(62);
			$mov='';
			if(isset($_POST['movimiento']))
			{
				if($_POST['movimiento']=='401' || $_POST['movimiento']=='402'){$mov="DOCUMENTO DE REVERSION";}
			}
			$this->SetFont('helvetica','B',10);
			$this->Cell(100,7,$mov,'T',0,'C',false,0,1); 
			$this->SetFont('helvetica','B',9);
			$this->SetY(27);
			$this->SetX(162.5);
			$this->Cell(37,5," NUMERO: ".$_POST[numero],"T",0,'L');
			$this->SetY(31);
			$this->SetX(162.5);
			$this->Cell(35,6," FECHA: ".$_POST[fecha],0,0,'L');
			$this->SetY(36);
			$this->SetX(162.5);
			$this->Cell(35,5," VIGENCIA: ".$_POST[vigencia],0,0,'L');
			
			//-----------------------------------------------------
			$this->SetFont('times','B',12);
			$this->SetY(44);
			$this->MultiCell(195.7,5,'EL SUSCRITO JEFE DE PRESUPUESTO','','C');	
			$this->Cell(199,12,'CERTIFICA:',0,0,'C');		
			$this->SetY(60);
			$this->SetFont('times','',10);
			$this->cell(0.1);
			$this->MultiCell(190,4,'Que de acuerdo con el Presupuesto General de Ingresos y Gastos, para la vigencia fiscal de '.$_POST[vigencia].', existe saldo disponible y no comprometido, para amparar el compromiso que se pretende adquirir a continuación:',0,'L',false,1,'','',true,0,false,true,0,'T',false);
			$this->ln(4);
			$this->SetFont('times','UB',10);
			$this->Cell(17,5,"OBJETO:",0,0,'L');
			$this->MultiCell(173,16.6,iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[objeto]),0,'L',false,1,'','',true,0,false,true,19,'T',false);
			$this->SetFont('times','B',10);
			$this->SetFont('times','UB',10);
			$this->Cell(21,5,"META PDM:",0,0,'L');
			$this->SetFont('times','B',10);
			$this->MultiCell(169,4,$_POST[meta].' '.$_POST[nmeta],0,'L',false,1,'','',true,0,false,true,0,'T',false);
			$this->ln(2);
			$this->Cell(50,5,'CODIGO',1,0,'C',false,0,0,false,'T','C');
			$this->Cell(53,5,'RUBRO',1,0,'C',false,0,0,false,'T','C');
			$this->Cell(53,5,'RECURSO',1,0,'C',false,0,0,false,'T','C');
			$this->Cell(34,5,'VALOR',1,1,'C',false,0,0,false,'T','C');
			
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
	$linkbd=conectar_bd();
	$crit1=" ";
	$crit2=" ";
	$crit3=" ";
	
	$sqlr="select id_cargo,id_comprobante from pptofirmas where id_comprobante='6' and vigencia='".$_POST[vigencia]."'";
	$res=mysql_query($sqlr,$linkbd);
	while($row=mysql_fetch_assoc($res))
	{
		if($row["id_cargo"]=='0')
		{
			$_POST[ppto][]=buscatercero($_POST[tercero]);
			$_POST[nomcargo][]='BENEFICIARIO';
		}
		else
		{
			$sqlr1="select cedulanit,(select nombrecargo from planaccargos where codcargo='".$row["id_cargo"]."') from planestructura_terceros where codcargo='".$row["id_cargo"]."' and estado='S'";
			$res1=mysql_query($sqlr1,$linkbd);
			$row1=mysql_fetch_row($res1);
			$_POST[ppto][]=iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",buscatercero($row1[0]));
			$_POST[nomcargo][]=$row1[1];
		}
	}
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
	$con=0;
	while ($con<count($_POST[dcuentas]))
	{
		$altura=6;
		$altini=6;
		$ancini=60;
		$altaux=0;
		$colst01=strlen(iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[dncuentas][$con]));
		$colst02=strlen(iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[dfuentes][$con]));
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
		$pdf->SetFont('times','',9);
		$pdf->Cell(50,$altura,"  ".$_POST[dcuentas][$con],1,0,'L',true,0,0,false,'T','C');
		$pdf->MultiCell(53,$altura,iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[dncuentas][$con]),1,'L',true,0,'','',true,0,false,true,$altura,'M',false);
		$pdf->MultiCell(53,$altura,iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[dfuentes][$con]),1,'L',true,0,'','',true,0,false,true,$altura,'M',false);
		$pdf->Cell(34,$altura,"$ ".number_format($_POST[dgastos][$con],2,$_SESSION["spdecimal"],$_SESSION["spmillares"])."   ",1,1,'R',true,0,0,false,'T','C');
		$con++;
	}
	$sql="SELECT user FROM pptocdp WHERE consvigencia='$_POST[numero]' AND vigencia='$_POST[vigencia]' ";
	$res=mysql_query($sql,$linkbd);
	$row = mysql_fetch_row($res);
	$pdf->Cell(156,6,'TOTAL:',0,0,'R',false,0,0,false,'T','C');
	$pdf->setFont('times','B',9);
	$pdf->Cell(34,6,"$ ".number_format($_POST[cuentagas2],2,$_SESSION["spdecimal"],$_SESSION["spmillares"])."  ",1,1,'R',false,0,0,false,'T','C');
	$pdf->ln(8);
	$v=$pdf->gety();
	$pdf->MultiCell(190,8,'SON: '.strtoupper($_POST[letras]." M/CTE"),1,'L',false,1,'','',true,0,false,true,8,'M',false);
	
	for($x=0;$x<count($_POST[ppto]);$x++)
	{
		$pdf->ln(14);
		$v=$pdf->gety();
		if($v>=251){ 
			$pdf->AddPage();
			$pdf->ln(20);
			$v=$pdf->gety();
		}
		$pdf->setFont('times','B',8);
		if (($x%2)==0) {
			if(isset($_POST[ppto][$x+1])){
				$pdf->Line(17,$v,107,$v);
				$pdf->Line(112,$v,202,$v);
				$v2=$pdf->gety();
				$pdf->Cell(104,4,''.$_POST[ppto][$x],0,1,'C',false,0,0,false,'T','C');
				$pdf->Cell(104,4,''.iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[nomcargo][$x]),0,1,'C',false,0,0,false,'T','C');
				$pdf->SetY($v2);
				$pdf->Cell(295,4,''.$_POST[ppto][$x+1],0,1,'C',false,0,0,false,'T','C');
				$pdf->Cell(295,4,''.iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[nomcargo][$x+1]),0,1,'C',false,0,0,false,'T','C');
			}else{
				$pdf->Line(50,$v,160,$v);
				$pdf->Cell(190,4,''.$_POST[ppto][$x],0,1,'C',false,0,0,false,'T','C');
				$pdf->Cell(190,4,''.iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[nomcargo][$x]),0,0,'C',false,0,0,false,'T','C');
			}
			$v3=$pdf->gety();
		}
		$pdf->SetY($v3);
		$pdf->SetFont('helvetica','',7);
	}
	// ---------------------------------------------------------
	$pdf->Output('reportecdp.pdf', 'I');//Close and output PDF document
?>