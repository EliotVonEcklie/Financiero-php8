<?php
//V 1000 12/12/16 
	require_once("tcpdf/tcpdf_include.php");
	require('comun.inc');
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
			$this->RoundedRect(10, 10, 190, 31, 2.5,''); //Borde del encabezado
			$this->Cell(52,31,'','R',0,'L'); //Linea que separa el encabazado verticalmente
			$this->SetY(32.5);
			$this->Cell(52,5,''.$rs,0,0,'C',false,0,1,false,'T','B'); //Nombre Municipio
			$this->SetFont('helvetica','B',8);
			$this->SetY(36.5);
			$this->Cell(52,5,''.$nit,0,0,'C',false,0,1,false,'T','C'); //Nit
			$this->SetFont('helvetica','B',14);
			$this->SetY(10);
			$this->SetX(62);
			$this->Cell(138,17,'REPORTE DE TAREAS',0,0,'C'); 
			$this->SetFont('helvetica','I',10);
			$this->SetY(27);
			$this->SetX(62);
			$this->Cell(100,7,' Tareas Programadas Por Dependencia.','T',0,'L',false,0,1); 
			if ($_POST[fechaini]!="" && $_POST[fechafin]!="")
			{
				$this->SetY(33);
				$this->SetX(62);
				$this->Cell(100,7," Fecha inicial: $_POST[fechaini]   Fecha Final: $_POST[fechafin]",0,0,'L',false,0,1); 
			}
			$this->SetFont('helvetica','B',9);
			$this->SetY(27);
			$this->SetX(162);
			$this->Cell(37.8,14,'','TL',0,'L');
			$this->SetY(29);
			$this->SetX(162.5);
			$this->Cell(35,5,"FECHA: ".date("d-m-Y"),0,0,'L');
			$this->SetY(34);
			$this->SetX(162.5);
			$this->Cell(35,5,"HORA: ".date('h:i:s a'),0,0,'L');
			//-----------------------------------------------------
			$this->SetY(44);
			$this->Cell(10,10,'Item',1,0,'C',false,0,0,false,'T','C');
			$this->Cell(100,10,'Dependencias',1,0,'C',false,0,0,false,'T','C');
			$this->Cell(80,5,'Tareas',1,0,'C',false,0,0,false,'T','C');
			$this->SetFont('helvetica','B',9);
			$this->SetY(49);
			$this->SetX(120);
			$this->Cell(20,5,'Total',1,0,'C',false,0,0,false,'T','C');
			$this->Cell(20,5,' Contestadas ',1,0,'C',false,0,1,false,'T','C');
			$this->Cell(20,5,' Sin Contestar ',1,0,'C',false,0,1,false,'T','C');
			$this->Cell(20,5,' Vencidas ',1,0,'C',false,0,1,false,'T','C');
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
			$this->Line(10, 280, 200, 280,$styleline);
		}
	}
	$pdf = new MYPDF('P','mm','Letter', true, 'iso-8859-1', false);// create new PDF document
	$pdf->SetDocInfoUnicode (true); 
	// set document information
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('G&CSAS');
	$pdf->SetTitle('Reporte Tareas');
	$pdf->SetSubject('Division Dependencias');
	$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
	$pdf->SetMargins(10, 54, 10);// set margins
	$pdf->SetHeaderMargin(54);// set margins
	$pdf->SetFooterMargin(17);// set margins
	$pdf->SetAutoPageBreak(TRUE, 17);// set auto page breaks
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
	$crit2="";
	if ($_POST[fechaini]!="" && $_POST[fechafin]!="")
	{$crit2=" AND TB3.fechar BETWEEN CAST('$_POST[fechaini]' AS DATE) AND CAST('$_POST[fechafin]' AS DATE)";}
	if ($_POST[nombre]!=""){$crit1="AND nombrearea like '%$_POST[nombre]%'";}
	$sqlr="SELECT * FROM planacareas WHERE estado='S' $crit1";
	$resp = mysql_query($sqlr,$linkbd);
	$concolor=0;
	$cont1tg=0; //contestadas general
	$cont2tg=0; //sin contestar general
	$cont3tg=0; //Vencidas general
	$cont4tg=0; //total general
	$pdf->SetFont('helvetica','I',10);
	$pdf->SetY(54);	
	while ($row = mysql_fetch_row($resp)) 
	{
		$sqlr2="SELECT TB1.estado, TB1.fechares, TB3.fechalimite FROM planacresponsables TB1,  planaccargos TB2, planacradicacion TB3 WHERE (TB1.estado='AC' OR TB1.estado='AN') AND TB2.codcargo=TB1.codcargo AND TB2.dependencia='$row[0]' AND TB3.numeror=TB1.codradicacion $crit2";
		$resp2 = mysql_query($sqlr2,$linkbd);
		$cont1=0; //contestadas
		$cont2=0; //sin contestar
		$cont3=0; //Vencidas
		$cont4=0; //total
		
		$conit++;
		$fechahoy= explode("-",date("d-m-Y")); 
		while ($row2 = mysql_fetch_row($resp2)) 
		{	
			$cont4++;
			$cont4tg++;
			$fechares=explode("-",date('d-m-Y',strtotime($row2[1])));
			$fechalim=explode("-",date('d-m-Y',strtotime($row2[2])));
			if ($row2[0]=='AC')
			{
				$cont1++;$cont1tg++;
				if(gregoriantojd($fechalim[1],$fechalim[0],$fechalim[2])< gregoriantojd($fechares[1],$fechares[0],$fechahoy[2]))
				{$cont3++;$cont3tg++;}
			}
			if ($row2[0]=='AN')
			{
				$cont2++;$cont2tg++;
				if(gregoriantojd($fechalim[1],$fechalim[0],$fechalim[2])< gregoriantojd($fechahoy[1],$fechahoy[0],$fechahoy[2]))
				{$cont3++;$cont3tg++;}
			}
		}
		if ($concolor==0){$pdf->SetFillColor(200,200,200);$concolor=1;}
		else {$pdf->SetFillColor(255,255,255);$concolor=0;}
		$pdf->Cell(10,5,$conit,1,0,'L',true,0,0,false,'T','B');
		$pdf->Cell(100,5,utf8_encode($row[1]),1,0,'L',true,0,1,false,'T','B');
		$pdf->Cell(20,5,$cont4,1,0,'C',true,0,0,false,'T','C');
		$pdf->Cell(20,5,$cont1,1,0,'C',true,0,0,false,'T','C');
		$pdf->Cell(20,5,$cont2,1,0,'C',true,0,0,false,'T','C');
		$pdf->Cell(20,5,$cont3,1,1,'C',true,0,0,false,'T','C');
	}
	if ($concolor==0){$pdf->SetFillColor(200,200,200);$concolor=1;}
	else {$pdf->SetFillColor(255,255,255);$concolor=0;}
	$pdf->Cell(110,5,'TOTAL: ',1,0,'R',true,0,0,false,'T','C');
	$pdf->Cell(20,5,$cont4tg,1,0,'C',true,0,0,false,'T','C');
	$pdf->Cell(20,5,$cont1tg,1,0,'C',true,0,0,false,'T','C');
	$pdf->Cell(20,5,$cont2tg,1,0,'C',true,0,0,false,'T','C');
	$pdf->Cell(20,5,$cont3tg,1,1,'C',true,0,0,false,'T','C');
	$pdf->SetY(52);				
	//for ($x=0;$x<400;$x++){$pdf->Cell(28,7,"DESCRIPCION:$x",1,1,'L',false,0,0,false,'T','B');}
	// ---------------------------------------------------------
	$pdf->Output('reportetareas.pdf', 'I');//Close and output PDF document
?>