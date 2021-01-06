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
			$sqlr="SELECT * FROM configbasica WHERE estado='S'";
			$res=mysql_query($sqlr,$linkbd);
			while($row=mysql_fetch_row($res))
			{
				$nit=$row[0];
				$rs=$row[1];
			}
			$sqlr="SELECT fechar,horar,tipor FROM planacradicacion WHERE numeror = '$_GET[iddoc]' AND tipot='0'";
			$res=mysql_query($sqlr,$linkbd);
			$row=mysql_fetch_row($res);
			$fechaRad=date('d-m-Y',strtotime($row[0]));
			$horarad=date("h:i:s a",strtotime($row[1]));
			$sqltr="SELECT clasificacion FROM plantiporadicacion WHERE codigo='$row[2]'";
			$restr=mysql_query($sqltr,$linkbd);
			$rowtr = mysql_fetch_row($restr);
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
			$this->SetFont('helvetica','B',14);
			$this->SetY(10);
			$this->Cell(50.1);
			$this->Cell(149,31,'',0,1,'C'); 
			$this->SetY(8);
			$this->Cell(50.1);
			$this->SetFont('helvetica','B',10);
			$this->SetY(27);
			$this->Cell(151.1);
			$this->Cell(47.8,14,'','TL',0,'L');
			$this->SetY(27.5);
			$this->Cell(152);
			$this->Cell(35,5,"NUMERO : $_GET[iddoc]",0,0,'L');
			$this->SetY(31.5);
			$this->Cell(152);
			$this->Cell(35,5,"FECHA: $fechaRad",0,0,'L');
			$this->SetY(35.5);
			$this->Cell(152);
			$this->Cell(35,5,"HORA: $horarad",0,0,'L');
			$this->SetY(27);
			$this->Cell(50.2);
			if($rowtr[0]=='N'){$this->Cell(101,7,'DOCUMENTO RADICADO','T',0,'C');}
			else {$this->Cell(101,7,'PQRSDF RADICADO','T',0,'C');}
			$this->SetFont('helvetica','B',12);
			$this->SetY(46);
			$this->ln(1);
			$this->SetFont('helvetica','B',10);
			$this->cell(0.1);
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
	$pdf->SetMargins(10, 44, 10);// set margins
	$pdf->SetHeaderMargin(44);// set margins
	$pdf->SetFooterMargin(20);// set margins
	$pdf->SetAutoPageBreak(TRUE, 20);// set auto page breaks
	// set some language-dependent strings (optional)
	if (@file_exists(dirname(__FILE__).'/lang/spa.php')) 
	{
		require_once(dirname(__FILE__).'/lang/spa.php');
		$pdf->setLanguageArray($l);
	}
	// ---------------------------------------------------------
	$linkbd=conectar_bd();
	$sqlr="SELECT tipor,idtercero,descripcionr,tescrito,ttelefono,temail,direcciont,emailt,telefonot,celulart,usuarior FROM planacradicacion WHERE numeror = '$_GET[iddoc]'";
	$res=mysql_query($sqlr,$linkbd);
	$row=mysql_fetch_row($res);
	$pdf->AddPage();
	$sqltr="SELECT nombre,clasificacion FROM plantiporadicacion WHERE codigo='$row[0]'";
	$restr=mysql_query($sqltr,$linkbd);
	$rowtr = mysql_fetch_row($restr);
	switch ($rowtr[1])
	{
		case "N":	$tipopqr="N - Ninguno";break;
		case "P":	$tipopqr="P - Petición";break;
		case "Q":	$tipopqr="Q - Queja";break;
		case "R":	$tipopqr="R - Reclamo";break;
		case "S":	$tipopqr="S - Sugerencia";break;
		case "D":	$tipopqr="D - Denuncia";break;
		case "F":	$tipopqr="F - Felicitacion";
	}
	$tiporad="$rowtr[0] ($tipopqr)";
	$nomtercero=buscatercero($row[1]);
	$detallegreso = iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$row[2]);
	$lineas = $pdf->getNumLines($detallegreso, 190);
	$alturadt=(3*$lineas);
	if($row[3]==1){$tiporesp='Escrita';}
	else {$tiporesp='';}
	if($row[4]==1)
	{
		if($tiporesp!=''){$tiporesp='Escrita, Telefonica';}
		else{$tiporesp='Telefonica';}
	}
	if($row[5]==1)
	{
		if($tiporesp!=''){$tiporesp=$tiporesp+', Correo Electronico';}
		else{$tiporesp='Correo Electronico';}
	}
	$direcc=iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$row[6]);
	$diremail=iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$row[7]);
	$numtele=iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$row[8]);
	$numcelu=$row[9];
	$pdf->SetFont('helvetica','B',10);
	$pdf->Cell(35,4,'Tipo Radicación:','TL',0,'L',0);
	$pdf->SetFont('helvetica','',10);
	$pdf->Cell(164,4,iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$tiporad),'TR',1,'L',0);
	$pdf->SetFont('helvetica','B',10);
	$pdf->Cell(35,4,'Radicado Por:','L',0,'L',0);
	$pdf->SetFont('helvetica','',10);
	$pdf->Cell(164,4,$nomtercero,'R',1,'L',0);
	$pdf->SetFont('helvetica','B',10);
	$pdf->MultiCell(35,$alturadt,'Descripción:','L','J',0,0,'','',true,0,false,true);
	$pdf->SetFont('helvetica','',10);
	$pdf->MultiCell(164,$alturadt,"$detallegreso",'R','L',0,1,'','',true,0,false,true);
	$pdf->SetFont('helvetica','B',10);
	$pdf->Cell(35,4,'Tipo Respuesta:','L',0,'L',0);
	$pdf->SetFont('helvetica','',10);
	$pdf->Cell(164,4,$tiporesp,'R',1,'L',0);
	$pdf->SetFont('helvetica','B',10);
	$pdf->Cell(35,4,'Dirección:','L',0,'L',0);
	$pdf->SetFont('helvetica','',10);
	$pdf->Cell(164,4,$direcc,'R',1,'L',0);
	$pdf->SetFont('helvetica','B',10);
	$pdf->Cell(35,4,'Email:','L',0,'L',0);
	$pdf->SetFont('helvetica','',10);
	$pdf->Cell(164,4,$diremail,'R',1,'L',0);
	$pdf->SetFont('helvetica','B',10);
	$pdf->Cell(35,4,'Telefono:','LB',0,'L',0);
	$pdf->SetFont('helvetica','',10);
	$pdf->Cell(64.5,4,$numtele,'B',0,'L',0);
	$pdf->SetFont('helvetica','B',10);
	$pdf->Cell(35,4,'Celular:','B',0,'L',0);
	$pdf->SetFont('helvetica','',10);
	$pdf->Cell(64.5,4,$numcelu,'RB',1,'L',0);
	$pdf->ln(6);
	$pdf->SetFont('helvetica','B',10);
	$pdf->Cell(79,4,'FUNCIONARIO',1,0,'L',0);
	$pdf->Cell(79,4,'CARGO',1,0,'L',0);
	$pdf->Cell(41,4,'TIPO',1,1,'L',0);
	$pdf->SetFont('helvetica','',9);
	$nrespuesta='Sin Respuesta por ahora';
	$nproceso='Sin proceso definido';
	$nfechares='';
	$sqlres="SELECT usuariocon,estado,respuesta,proceso,fechares FROM planacresponsables WHERE codradicacion = '$_GET[iddoc]' ORDER BY codigo ASC";
	$resre=mysql_query($sqlres,$linkbd);
	while ($rowre = mysql_fetch_row($resre))
	{
		$nomfunc=iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",buscatercero($rowre[0]));
		$sqlr1="SELECT T1.nombrecargo FROM planaccargos AS T1 INNER JOIN planestructura_terceros AS T2 ON T2.codcargo=T1.codcargo AND T2.cedulanit = '$rowre[0]'";
		$resp1=mysql_query($sqlr1,$linkbd);
		$row1 = mysql_fetch_row($resp1);
		$nomcargo=iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$row1[0]);
		if($rowre[1]=='LS' || $rowre[1]=='LN') {$tipestado="Solo Lectura";}
		else 
		{
			$tipestado="Responsable";
			$nrespuesta=iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$rowre[2]);
			$nproceso=iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$rowre[3]);
			$nfechares=date('d-m-Y',strtotime($rowre[4]));
		}
		$pdf->Cell(79,4,$nomfunc,1,0,'L',0);
		$pdf->Cell(79,4,$nomcargo,1,0,'L',0);
		$pdf->Cell(41,4,$tipestado,1,1,'L',0);
	}
	if($nrespuesta==''){$nrespuesta='Sin Respuesta por ahora';}
	$pdf->ln(6);
	$pdf->SetFont('helvetica','B',10);
	$pdf->Cell(199,4,'RESPUESTA:','RLT',1,'L',0);
	$pdf->SetFont('helvetica','',10);
	$pdf->MultiCell(199,4,$nrespuesta,'RLB','L',0,1,'','',true,0,false,true);
	if($nproceso==''){$nproceso='Sin proceso definido';}
	$pdf->ln(6);
	$pdf->SetFont('helvetica','B',10);
	$pdf->Cell(199,4,'PROCESO:','RLT',1,'L',0);
	$pdf->SetFont('helvetica','',10);
	$pdf->MultiCell(199,4,$nproceso,'RLB','L',0,1,'','',true,0,false,true);
	$pdf->ln(6);
	$pdf->SetFont('helvetica','B',10);
	$pdf->Cell(199,4,'Archivos Adjuntos:','RLT',1,'L',0);
	$pdf->SetFont('helvetica','',10);
	$conta=1;
	$sqlrar="SELECT nomarchivo FROM planacarchivosad WHERE idradicacion = '$_GET[iddoc]' ORDER BY idarchivoad ASC";
	$resar=mysql_query($sqlrar,$linkbd);
	while ($rowar = mysql_fetch_row($resar))
	{
		$nomarchivo=iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$rowar[0]);
		$pdf->Cell(10,4,"$conta.",'LTB',0,'L',0);
		$pdf->Cell(189,4,$nomarchivo,'RTB',1,'L',0);
		$conta++;
	}

$nomradica=buscatercero($row[10]);
	$pdf->ln(15);
	$pdf->cell(60);
	$pdf->Cell(80,5,$nomradica,'T',0,'C');
	$pdf->ln(4);
	$pdf->cell(60);
	$pdf->Cell(80,5,'RADICACIÓN',0,0,'C');
	$pdf->Output();
?> 


