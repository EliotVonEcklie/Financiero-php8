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
			if($_POST[tinforme]==''){$titulo1="Listado General";}
			elseif($_POST[tinforme]=='1'){$titulo1="Listado Tareas Internas";}
			else{$titulo1="Listado Tareas Externas";}
			switch($_POST[testado])
   			{ 
       			case '':	$titulo2="Todos Los Estados";break;
				case 'LN':	$titulo2="Solo Lectura Sin Ver";break;
				case 'LS':	$titulo2="Solo Lectura Vistos";break;
				case 'AN':	$titulo2="Para Constestar";break;
				case 'AC':	$titulo2="Contestadas";break;
				case 'AR':	$titulo2="Redirigidas";break;
				case 'AV':	$titulo2="Vencidas";break;
				case 'CN':	$titulo2="Consultas Sin Contestas";break;
				case 'CS':	$titulo2="Consultas Sin Contestas";break;
			}
			if ($_POST[fechaini]!="" && $_POST[fechafin]!=""){$titulo3="Fecha Inicial: $_POST[fechaini] - Fecha Final: $_POST[fechafin]";}
			else{$titulo3="Sin Rango Definido";}
			if($_POST[nradicacion]==""){$titulo4="Todos";}
			else {$titulo4="$_POST[nradicacion]";}
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
			$this->Cell(190,17,'LISTADO TAREAS PROGRAMADAS',0,0,'C'); 
			$this->SetY(27);
			$this->SetX(62);
			$this->SetFont('helvetica','B',10);
			$this->Cell(33,7," Tipo de Tareas: ",'T',0,'L',false,0,1); 
			$this->SetFont('helvetica','I',10);
			$this->Cell(87,7,"$titulo1.",'T',0,'L',false,0,1); 
			$this->SetFont('helvetica','B',10);
			$this->Cell(15,7,"No Código: ",'T',0,'L',false,0,1);
			$this->SetFont('helvetica','I',10);
			$this->Cell(55,7,"$titulo4",'T',0,'L',false,0,1);
			$this->SetY(31.2);
			$this->SetX(62);
			$this->SetFont('helvetica','B',10);
			$this->Cell(33,7," Estado de Tareas:",0,0,'L',false,0,1);
			$this->SetFont('helvetica','I',10);
			$this->Cell(157,7,"$titulo2",0,0,'L',false,0,1);
			$this->SetY(35.5);
			$this->SetX(62);
			$this->SetFont('helvetica','B',10);
			$this->Cell(33,7," Rango de Fechas:",0,0,'L',false,0,1); 
			$this->SetFont('helvetica','I',10);
			$this->Cell(157,7,"$titulo3",0,0,'L',false,0,1); 
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
			$this->Cell(20,5,'Código',1,0,'C',false,0,0,false,'T','C');
			$this->Cell(25,5,'F. Asignación',1,0,'C',false,0,0,false,'T','C');
			$this->Cell(25,5,'F. Limite',1,0,'C',false,0,0,false,'T','C');
			$this->Cell(70,5,'Asignado Por',1,0,'C',false,0,0,false,'T','C');
			$this->Cell(100,5,'Descripción',1,0,'C',false,0,0,false,'T','C');
			$this->Cell(20,5,'Tipo',1,0,'C',false,0,0,false,'T','C');
			$this->Cell(20,5,'Estado',1,1,'C',false,0,0,false,'T','C');
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
	if ($_POST[fechaini]!="" && $_POST[fechafin]!="")
	{$crit4=" AND TB1.fechasig BETWEEN CAST('$_POST[fechaini]' AS DATE) AND CAST('$_POST[fechafin]' AS DATE)";}
	switch($_POST[tinforme])
	{
		case "":	$crit1="";break;
		case "1":	$crit1=" AND TB1.tipot='1'";break;
		case "0":	$crit1=" AND TB1.tipot='0'";break;
	}
	switch($_POST[testado])
	{
		case "":	$crit2="";break;
		case "LN":	$crit2=" AND TB1.estado='LN'";break;
		case "LS":	$crit2=" AND TB1.estado='LS'";break;
		case "AN":	$crit2=" AND TB1.estado='AN'";break;
		case "AC":	$crit2=" AND TB1.estado='AC'";break;
		case "AR":	$crit2=" AND TB1.estado='AR'";break;
		case "CN":	$crit2=" AND TB1.estado='CN'";break;
		case "CC":	$crit2=" AND TB1.estado='CC'";break;
		case "AV":	$crit2=" AND ((TB1.estado='AN' AND (TB2.fechalimite <= CURDATE()))OR((TB1.estado='AC')AND(TB2.fechalimite <= TB1.fechares)))";
		
	}
	$sqlr="SELECT TB1.*,TB2.numeror,TB2.fechalimite,TB2.descripcionr,TB2.codigobarras,TB2.estado,TB2.estado2 FROM planacresponsables TB1, planacradicacion TB2 WHERE TB1.codradicacion=TB2.numeror AND TB1.usuariocon='$_SESSION[cedulausu]' $crit1 $crit2 $crit3 $crit4 ORDER BY TB1.codigo DESC";
	$resp=mysql_query($sqlr,$linkbd);
	$concolor=0;
	while ($row = mysql_fetch_row($resp)) 
	{
		$col01=utf8_encode($row[18]);
		$col02=date('d-m-Y',strtotime($row[2]));
		if($row[19]=="AC" || $row[19]=="AN"){$col03=date('d-m-Y',strtotime($row[16]));}
		else{$col03="Sin Limite";}
		$col04=utf8_encode(buscaresponsable($row[4]));
		$col05=strtoupper(utf8_encode($row[17]));
		switch($row[6])
		{
			case "LN":	$col06="Informativa";$col07="Sin Revisar";break;
			case "LS":	$col06="Informativa";$col07="Revisada";break;
			case "AN":	$col06="Tarea";$col07="Contestar";break;
			case "AC":	$col06="Tarea";$col07="Contestada";break;
			case "AR":	$col06="Redirigida";$col07="Contestada";break;
			case "CN":	$col06="Consuta";$col07="Sin Contestar";break;
			case "CS":	$col06="Consuta";$col07="Contestada";break;
		}
		if ($concolor==0){$pdf->SetFillColor(200,200,200);$concolor=1;}
		else {$pdf->SetFillColor(255,255,255);$concolor=0;}
		$altura=6;
		$ancini=48;
		$altini=6;
		$coti=0;
		$cantidad_lineas= strlen($col05);
		$altaux=0;
		if($cantidad_lineas > $ancini)
		{
			$coti++;
			$cant_espacios = $cantidad_lineas/$ancini;
			$rendondear=round($cant_espacios,0,PHP_ROUND_HALF_UP);
			$altaux=$altini*round($cant_espacios);
		}
		if($altaux>$altura){$altura=$altaux;}
		$pdf->Cell(20,$altura,$col01,1,0,'C',true,0,0,false,'T','C');
		$pdf->Cell(25,$altura,$col02,1,0,'C',true,0,0,false,'T','C');
		$pdf->Cell(25,$altura,$col03,1,0,'C',true,0,0,false,'T','C');
		$pdf->Cell(70,$altura,$col04,1,0,'L',true,0,1,false,'T','C');
		$pdf->MultiCell(100,$altura,$col05,1,'L',true,0,'','',true,0,false,true,$altura,'M',false);
		$pdf->Cell(20,$altura,$col06,1,0,'C',true,0,0,false,'T','C');
		$pdf->Cell(20,$altura,$col07,1,1,'C',true,0,0,false,'T','C');
	}
	// ---------------------------------------------------------
	$pdf->Output('reportetareasas.pdf', 'I');//Close and output PDF document
?>