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
			if($_POST[nomdep]!=""){$titulo1="Listado $_POST[nomdep]";}
			else{$titulo1="Listado General";}
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
			$this->Cell(190,17,'LISTADO FUNCIONARIOS NOMINA',0,0,'C'); 
			$this->SetFont('helvetica','I',10);
			$this->SetY(27);
			$this->SetX(62);
			$this->Cell(190,7," $titulo1.",'T',0,'L',false,0,1); 
			if ($_POST[fechaini]!="" && $_POST[fechafin]!="")
			{
				$this->SetY(34);
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
			$this->Cell(10,5,'ITEM',1,0,'C',false,0,0,false,'T','C');
			$this->Cell(45,5,'FUNCIONARIO',1,0,'C',false,0,0,false,'T','C');
			$this->Cell(45,5,'NIVEL',1,0,'C',false,0,0,false,'T','C');
			$this->Cell(45,5,'EPS',1,0,'C',false,0,0,false,'T','C');
			$this->Cell(45,5,'ARP',1,0,'C',false,0,0,false,'T','C');
			$this->Cell(45,5,'AFP',1,0,'C',false,0,0,false,'T','C');
			$this->Cell(45,5,'FONDO CESANTIAS',1,0,'C',false,0,0,false,'T','C');
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
	$pdf->SetTitle('Reporte Terceros');
	$pdf->SetSubject('Informacion de Nomina');
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
	$crit1="";
	if ($_POST[nombre]!="")
	{
		$crit1="AND concat_ws(' ', TB2.nombre1, TB2.nombre2, TB2.apellido1, TB2.apellido2, TB2.razonsocial, TB2.cedulanit) LIKE '%$_POST[nombre]%'";
	}
	if($_POST[dependencias]!='')
	{
		$sqlr="SELECT concat_ws(' ', TB2.apellido1, TB2.apellido2, TB2.nombre1, TB2.nombre2, TB2.razonsocial), TB1.* FROM terceros_nomina TB1, terceros TB2, planestructura_terceros TB3, planaccargos TB4, planacareas TB5 WHERE TB1.estado='S' AND TB1.cedulanit=TB2.cedulanit $crit1 AND TB3.cedulanit=TB1.cedulanit AND TB3.codcargo=TB4.codcargo AND TB4.dependencia=TB5.codarea AND TB5.codarea='$_POST[dependencias]' ORDER BY TB2.apellido1,TB2.apellido2,TB2.nombre1,TB2.nombre2, TB2.razonsocial";
	}
	else
	{
		$sqlr="SELECT concat_ws(' ', TB2.apellido1, TB2.apellido2, TB2.nombre1, TB2.nombre2, TB2.razonsocial), TB1.* FROM terceros_nomina TB1, terceros TB2 WHERE TB1.estado='S' AND TB1.cedulanit=TB2.cedulanit $crit1 ORDER BY TB2.apellido1,TB2.apellido2,TB2.nombre1,TB2.nombre2, TB2.razonsocial";
	}
	$resp = mysql_query($sqlr,$linkbd);
	$ntr = mysql_num_rows($resp);
	$cont=1;
	$concolor=0;
	$pdf->SetFont('helvetica','I',9);
	while ($row = mysql_fetch_row($resp)) 
	{
		$nomeps=buscatercero($row[4]);if($nomeps==""){$nomeps="No Disponible";}
		$nomarp=buscatercero($row[5]);if($nomarp==""){$nomarp="No Disponible";}
		$nomafp=buscatercero($row[6]);if($nomafp==""){$nomafp="No Disponible";}
		$nomfce=buscatercero($row[7]);if($nomfce==""){$nomfce="No Disponible";}
		$sqlrns="SELECT nombre FROM humnivelsalarial WHERE id_nivel='$row[8]'";
		$rowns =mysql_fetch_row(mysql_query($sqlrns,$linkbd));
		if ("$rowns[0]"!=""){$nomniv=$rowns[0];}
		else {$nomniv="No Disponible";}
		if ($concolor==0){$pdf->SetFillColor(200,200,200);$concolor=1;}
		else {$pdf->SetFillColor(255,255,255);$concolor=0;}
		$ancho=45;
		$altura=6;
		$ancini=21;
		$altini=6;
		$coti=0;
		$datosn = array(utf8_encode($row[0]), utf8_encode($nomniv), utf8_encode($nomeps), utf8_encode($nomarp), utf8_encode($nomafp), utf8_encode($nomfce));
		for ($xx = 0; $xx <= 5; $xx++)
		{
			$cantidad_lineas= strlen($datosn[$xx]);
			$altaux=0;
			if($cantidad_lineas > $ancini)
			{
				$coti++;
				$cant_espacios = $cantidad_lineas/$ancini;
				$rendondear=round($cant_espacios,0,PHP_ROUND_HALF_UP);
				$altaux=$altini*round($cant_espacios);
			}
			if($altaux>$altura){$altura=$altaux;}
		}
		//$pdf->MultiCell($w,$h,$txt,$border = 0,$align = 'J',$fill = false,$ln = 1,	$x = '',$y = '',$reseth = true,$stretch = 0,$ishtml = false,$autopadding = true,$maxh = 0,$valign = 'T',$fitcell = false);	
		$pdf->MultiCell(10,$altura,$cont,1,'L',true,0,'','',true,0,false,true,0,'T',false);
		$pdf->MultiCell(45,$altura,$datosn[0],1,'L',true,0,'','',true,0,false,true,0,'T',false);
		$pdf->MultiCell(45,$altura,$datosn[1],1,'L',true,0,'','',true,0,false,true,0,'T',false);
		$pdf->MultiCell(45,$altura,$datosn[2],1,'L',true,0,'','',true,0,false,true,0,'T',false);
		$pdf->MultiCell(45,$altura,$datosn[3],1,'L',true,0,'','',true,0,false,true,0,'T',false);
		$pdf->MultiCell(45,$altura,$datosn[4],1,'L',true,0,'','',true,0,false,true,0,'T',false);
		$pdf->MultiCell(45,$altura,$datosn[5],1,'L',true,1,'','',true,0,false,true,0,'T',false);
		$cont++;
	}
	
	
	$pdf->Output('reptercerosnomina.pdf', 'I');//Close and output PDF document
?>