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
			if($_POST[nomdep]!='')
			{
				if($_POST[nompro]!=''){$titulo1="Listado: ".utf8_encode($_POST[nomdep]).", Proceso: ".utf8_encode($_POST[nompro]);}
				else {$titulo1="Listado: ".utf8_encode($_POST[nomdep]);}
			}
			else
			{
				if($_POST[nompro]!=''){$titulo1="Listado Proceso: ".utf8_encode($_POST[nompro]);}
				else {$titulo1="Listado General";}
			}	
			if($_POST[nomtiporadica]!=""){$nomtipro=utf8_encode($_POST[nomtiporadica]);}
			else{$nomtipro="Todas";}
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
			$this->Cell(190,17,'LISTADO DOCUMENTOS RADICADOS',0,0,'C'); 
			$this->SetFont('helvetica','I',10);
			$this->SetY(27);
			$this->SetX(62);
			$this->Cell(190,7," $titulo1.",'T',0,'L',false,0,1); 
			$this->SetY(31.2);
			$this->SetX(62);
			$this->Cell(190,7," Tipo Radicación: $nomtipro.",0,0,'L',false,0,1);
			if ($_POST[fechaini]!="" && $_POST[fechafin]!="")
			{
				$this->SetY(35.5);
				$this->SetX(62);
				$this->Cell(190,7," Fecha Inicial: $_POST[fechaini]   Fecha Final: $_POST[fechafin]",0,0,'L',false,0,1); 
			}
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
			$this->Cell(20,5,'Radicación',1,0,'C',false,0,0,false,'T','C');
			$this->Cell(20,5,'Fecha Radi.',1,0,'C',false,0,0,false,'T','C');
			$this->Cell(20,5,'Fecha Venc.',1,0,'C',false,0,0,false,'T','C');
			$this->Cell(20,5,'Fecha Resp.',1,0,'C',false,0,0,false,'T','C');
			$this->Cell(80,5,'Tercero',1,0,'C',false,0,0,false,'T','C');
			$this->Cell(80,5,'Descripción',1,0,'C',false,0,0,false,'T','C');
			$this->Cell(22,5,'Estado',1,0,'C',false,0,0,false,'T','C');
			$this->Cell(18,5,'Contestada',1,0,'C',false,0,0,false,'T','C');
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
	$pdf->SetFont('helvetica','I',9);
	$linkbd=conectar_bd();
	$cond1="";
	$cond2="";
	$cond3="";
	$cond4="";
	$cond5="";
	if ($_POST[fechaini]!="" && $_POST[fechafin]!="")
	{$cond3=" AND TB1.fechar BETWEEN CAST('$_POST[fechaini]' AS DATE) AND CAST('$_POST[fechafin]' AS DATE)";}
	if($_POST[dependencias]!="")
	{
		$cond2=" AND EXISTS(SELECT TB2.estado FROM planacresponsables TB2, planaccargos TB3 WHERE TB1.numeror=TB2.codradicacion AND TB3.codcargo=TB2.codcargo AND TB3.dependencia='$_POST[dependencias]' AND TB2.codigo=(SELECT MAX(TB4.codigo) FROM planacresponsables TB4 WHERE TB2.codradicacion=TB4.codradicacion AND (TB4.estado='AR' OR TB4.estado='AC' OR TB4.estado='AN')))";
	}
	if($_POST[numero]!=""){$cond1="AND concat_ws(' ', TB1.codigobarras,TB1.idtercero) LIKE '%$_POST[numero]%'";}
	if($_POST[ntercero]!=""){$cond4="AND EXISTS(SELECT TB4.estado FROM terceros TB4 WHERE TB1.idtercero=TB4.cedulanit AND concat_ws(' ', TB4.nombre1,TB4.nombre2,TB4.apellido1,TB4.apellido2,TB4.razonsocial,TB4.cedulanit) LIKE '%$_POST[ntercero]%')";}
	if($_POST[tradicacion]!=""){$cond5="AND tipor='$_POST[tradicacion]'";}
	switch ($_POST[proceso]) 
	{
		case '':	$presqlr="SELECT TB1.* FROM planacradicacion TB1  WHERE TB1.tipot='0' $cond2 $cond1 $cond3 $cond4 $cond5 ORDER BY TB1.numeror DESC";break;
		case 'LN':
		case 'AC':
		case 'AN':	$presqlr="SELECT TB1.* FROM planacradicacion TB1 WHERE TB1.tipot='0' AND TB1.estado='$_POST[proceso]' $cond2 $cond1 $cond3 $cond4 $cond5 ORDER BY TB1.numeror DESC";break;
		case 'AV':	$presqlr="SELECT TB1.* FROM planacradicacion TB1  WHERE TB1.tipot='0' AND EXISTS (SELECT TB2.codigo FROM planacresponsables TB2 WHERE TB2.codradicacion=TB1.numeror $cond2 $cond1 $cond3 $cond4 $cond5 AND ((TB2.fechares > TB1.fechalimite AND TB1.estado='AC') OR (TB1.estado='AN' AND TB1.fechalimite <= CURDATE()))) ORDER BY TB1.numeror DESC";break;
		case 'DL': $presqlr="SELECT TB1.* FROM planacradicacion TB1 WHERE TB1.tipot='0' AND TB1.estado2='3' $cond2 $cond1 $cond3 $cond4 $cond5 ORDER BY TB1.numeror";break;
	}
	$sqlr="$presqlr";
	$resp=mysql_query($sqlr,$linkbd);
	$concolor=0;
	while ($row = mysql_fetch_row($resp)) 
	{
		$tercero=strtoupper(utf8_encode(buscatercero($row[7])));
		$descripcion=strtoupper(utf8_encode($row[8]));
		$fechar=date("d-m-Y",strtotime($row[2]));
		$fechav=date("d-m-Y",strtotime($row[6]));
		$fechactual=date("d-m-Y");
		$tmp = explode('-',$fechav);
		$fcpv=gregoriantojd($tmp[1],$tmp[0],$tmp[2]);
		$tmp = explode('-',$fechactual);
		$fcpa=gregoriantojd($tmp[1],$tmp[0],$tmp[2]);
		switch($row[20])
		{
			case "AC":
				if($row[6]!="0000-00-00")
				{
					$sqlac="SELECT fechares FROM planacresponsables WHERE estado='AC' AND codradicacion='$row[0]'";
					$rowac=mysql_fetch_row(mysql_query($sqlac,$linkbd));
					$fechares=explode("-",date('d-m-Y',strtotime($rowac[0])));
					if($fcpv <= gregoriantojd($fechares[1],$fechares[0],$fechares[2])){$imgsem="Vencida";}
					else{$imgsem="Contestada";}
					$imgcon="SI";
					$mfechares=date('d-m-Y',strtotime($rowac[0]));
				}
				else
				{
					$imgcon="src='imagenes/confirm3.png' title='Concluida'";
					$imgsem="Contestada";
					$mfechares="Sin Limite";
					$fechav="Sin Limite";
				}
				break;
			case "LS":
				$imgsem="Revisados";
				$imgcon="SI";
				$mfechares="Solo Lectura";
				$fechav="Sin Limite";
				break;
			case "LN":
				$sqlec="SELECT usuariocon FROM planacresponsables WHERE estado='LN' AND codradicacion='$row[0]'";
				$reslec = mysql_query($sqlec,$linkbd);
				$nlec = mysql_num_rows($reslec);
				if ($nlec==0)
				{
					$imgsem="Revisados";
					$imgcon="SI";
				}
				else
				{
					$imgsem="Pendiantes";
					$imgcon="NO";
				}
				$mfechares="Solo Lectura";
				$fechav="Sin Limite";
				break;
			case "AN": 
				if($row[6]!="0000-00-00")
				{
					if ($fcpv <= $fcpa){$imgsem="Vencida";}
					else {$imgsem="Sin Responder";}
				}
				else
				{
					$imgsem="Sin Responder";
					$fechav="Sin Limite";
				}
				$imgcon="NO";
				$mfechares="00-00-000";
				break;
		}
		if ($concolor==0){$pdf->SetFillColor(200,200,200);$concolor=1;}
		else {$pdf->SetFillColor(255,255,255);$concolor=0;}
		$altura=6;
		$ancini=41;
		$altini=6;
		$coti=0;
		$colst01=strlen($tercero);
		$colst02=strlen($descripcion);
		if($colst01>$colst02){$cantidad_lineas= $colst01;}
		else{$cantidad_lineas= $colst02;}
		$altaux=0;
		if($cantidad_lineas > $ancini)
		{
			$coti++;
			$cant_espacios = $cantidad_lineas/$ancini;
			$rendondear=round($cant_espacios,0,PHP_ROUND_HALF_UP);
			$altaux=$altini*round($cant_espacios);
		}
		if($altaux>$altura){$altura=$altaux;}
		$pdf->Cell(20,$altura,$row[1],1,0,'C',true,0,0,false,'T','C');
		$pdf->Cell(20,$altura,$fechar,1,0,'C',true,0,0,false,'T','C');
		$pdf->Cell(20,$altura,$fechav,1,0,'C',true,0,0,false,'T','C');
		$pdf->Cell(20,$altura,$mfechares,1,0,'C',true,0,0,false,'T','C');
		$pdf->MultiCell(80,$altura,$tercero,1,'L',true,0,'','',true,0,false,true,$altura,'M',false);
		$pdf->MultiCell(80,$altura,$descripcion,1,'L',true,0,'','',true,0,false,true,$altura,'M',false);
		$pdf->Cell(22,$altura,$imgsem,1,0,'C',true,0,0,false,'T','C');
		$pdf->Cell(18,$altura,$imgcon,1,1,'C',true,0,0,false,'T','C');
	}
	// ---------------------------------------------------------
	$pdf->Output('reportetareas.pdf', 'I');//Close and output PDF document
?>