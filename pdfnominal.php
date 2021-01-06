<?php
	require_once("tcpdf/tcpdf_include.php");
	require('comun.inc');
	require('funciones.inc');
	session_start();
	date_default_timezone_set("America/Bogota");
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
			}
			$sqlp="SELECT * FROM humnomina_prima WHERE id_nom='$_POST[pdfidnom]'";
			$rsp = mysql_query($sqlp,$linkbd);
			$filpri=mysql_num_rows($rsp);
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
			$this->SetFont('helvetica','B',14);
			$this->SetY(10);
			$this->Cell(50.1);
			$this->Cell(149,31,'',0,1,'C'); 
			$this->SetFont('helvetica','B',10);
			$this->SetY(15);
			$this->Cell(50.1);
			$this->Cell(149,20,$mov,0,0,'C'); 
			$this->SetFont('helvetica','B',14);
			$this->SetY(27);
			$this->Cell(50.2);
			$descrip=iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT","Desprendible de nómina periodo laborado $_POST[pdfmes] del $_POST[pdfvigen]");
			$this->multiCell(111,14,$descrip,'T','C');
			$this->SetFont('helvetica','B',10);
			$this->SetY(27);
			$this->Cell(161.1);
			$this->Cell(37.8,14,'','TL',0,'L');
			$this->SetY(27);
			$this->Cell(162);
			$this->Cell(35,5,'NUMERO : '.$_POST[pdfidnom],0,0,'L');
			$this->SetY(31);
			$this->Cell(162);
			$this->Cell(35,5,'FECHA: '.$_POST[pdfmes],0,0,'L');
			$this->SetY(35);
			$this->Cell(162);
			$this->Cell(35,5,'VIGENCIA: '.$_POST[pdfvigen],0,0,'L');
			$this->SetY(27);
			$this->Cell(50.2);
			$this->MultiCell(105.7,4,'',0,'L');		
			$this->SetFont('times','B',10);
			$this->ln(12);
		}
		public function Footer() 
		{
			$linkbd=conectar_bd();
			$sqlr="SELECT direccion,telefono,web,email FROM configbasica WHERE estado='S'";
			$resp=mysql_query($sqlr,$linkbd);
			while($row=mysql_fetch_row($resp))
			{
				$direcc=iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT","Dirección: ".strtoupper($row[0]));
				$telefonos=$row[1];
				$dirweb=iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",strtoupper($row[3]));
				$coemail=iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",strtoupper($row[2]));
			}
			if($direcc!=''){$vardirec="$direcc, ";}
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
	$linkbd=conectar_bd();	
	$nresul=buscatercero($_POST[pdftercero]);
	$nresul=iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$nresul);
	$pdf = new MYPDF('P','mm','Letter', true, 'iso-8859-1', false);// create new PDF document
	$pdf->SetDocInfoUnicode (true);
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetMargins(10, 43, 10);// set margins
	$pdf->SetHeaderMargin(43);// set margins
	$pdf->SetFooterMargin(20);// set margins
	$pdf->SetAutoPageBreak(TRUE, 20);// set auto page breaks
	if (@file_exists(dirname(__FILE__).'/lang/spa.php')) 
	{
		require_once(dirname(__FILE__).'/lang/spa.php');
		$pdf->setLanguageArray($l);
	}
	$pdf->AddPage();
	$pdf->SetFont('Times','',10);
	$pdf->SetFont('helvetica','B',12);
	$pdf->cell(125);
	$pdf->cell(27,8,'TOTAL A PAGAR: ',0,0,'R');
	$pdf->cell(47,8,'$'.number_format($_POST[pdftotalpago],2),1,0,'C',0);
	$pdf->ln(10);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(26,5,'Funcionario: ','LT',0,'L',1);
	$pdf->SetFont('helvetica','',10);
	$pdf->cell(98,5,''.$nresul,'T',0,'L',1);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(35,5,'C.C. o NIT: ','T',0,'L',1);
	$pdf->SetFont('helvetica','',10);
	$pdf->cell(40,5,''.$_POST[pdftercero],'TR',1,'L',1);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(26,5,'Cargo: ','LB',0,'L',1);
	$cargofun=cargofuncionario($_POST[pdfnfun]);
	$pdf->SetFont('helvetica','',10);
	$pdf->cell(98,5,''.iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$cargofun),'B',0,'L',1);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(35,5,iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT","Días Laborales").': ','B',0,'L',1);
	$pdf->SetFont('helvetica','',10);
	$pdf->cell(40,5,''.$_POST[pdfdiaslab],'BR',1,'L',1);
	$pdf->ln(5);
	$pdf->SetFont('helvetica','B',10);
	$pdf->Cell(119,5,'DETALLES',1,0,'C',0);
	$pdf->Cell(40,5,'PAGOS',1,0,'C',0);
	$pdf->Cell(40,5,'DESCUENTOS',1,1,'C',0);
	$x=$tsalud=$tpension=$tfondosol=$suming=$sumegr=$auxalim=$auxtran=$retefte=0;
	$sqlr="SELECT tipopago,SUM(devendias),SUM(salud),SUM(pension),SUM(fondosolid),SUM(auxalim),SUM(auxtran),SUM(retefte) FROM humnomina_det WHERE id_nom='$_POST[pdfidnom]' AND idfuncionario='$_POST[pdfnfun]' GROUP BY tipopago ORDER BY id_nom DESC";
	$resp = mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($resp))
	{
		$tipopago=buscavariblespagonomina($row[0]);
		$tsalud=$tsalud+$row[2];
		$tpension=$tpension+$row[3];
		$tfondosol=$tfondosol+$row[4];
		$auxalim=$auxalim+$row[5];
		$auxtran=$auxtran+$row[6];
		$retefte=$retefte+$row[7];
		$suming=$suming+$row[1];
		if($x==0){$pdf->SetFillColor(255,255,255);$x++;}
		else {$pdf->SetFillColor(245,245,245);$x=0;}
		$pdf->SetFont('helvetica','',10);
		$pdf->Cell(119,5,iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$tipopago),'L',0,'L',1);
		$pdf->Cell(40,5,'$'.number_format($row[1],2),0,0,'R',1);
		$pdf->Cell(40,5,'$'.number_format(0,2),'R',1,'R',1);
	}
	if($auxalim>0)
	{
		if($x==0){$pdf->SetFillColor(255,255,255);$x++;}
		else {$pdf->SetFillColor(245,245,245);$x=0;}
		$pdf->Cell(119,5,iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",'Auxilio de Alimentación'),'L',0,'L',1); 
		$pdf->Cell(40,5,'$'.number_format($auxalim,2),0,0,'R',1);
		$pdf->Cell(40,5,'$'.number_format(0,2),'R',1,'R',1);
		$suming=$suming+$auxalim;
	}
	if($auxtran>0)
	{
		if($x==0){$pdf->SetFillColor(255,255,255);$x++;}
		else {$pdf->SetFillColor(245,245,245);$x=0;}
		$pdf->Cell(119,5,'Auxilio de Transporte','L',0,'L',1);
		$pdf->Cell(40,5,'$'.number_format($auxtran,2),0,0,'R',1);
		$pdf->Cell(40,5,'$'.number_format(0,2),'R',1,'R',1);
		$suming=$suming+$auxtran;
	}
	if($retefte>0)
	{
		if($x==0){$pdf->SetFillColor(255,255,255);$x++;}
		else {$pdf->SetFillColor(245,245,245);$x=0;}
		$pdf->Cell(119,5,iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",'Retención en la Fuente'),'L',0,'L',1); 
		$pdf->Cell(40,5,'$'.number_format(0,2),0,0,'R',1);
		$pdf->Cell(40,5,'$'.number_format($retefte,2),'R',1,'R',1);
		$sumegr=$sumegr+$retefte;
	}
	if($tsalud>0)
	{
		if($x==0){$pdf->SetFillColor(255,255,255);$x++;}
		else {$pdf->SetFillColor(245,245,245);$x=0;}
		$pdf->Cell(119,5,'Aporte Salud Funcionario 4% ','L',0,'L',1); 
		$pdf->Cell(40,5,'$'.number_format(0,2),0,0,'R',1);
		$pdf->Cell(40,5,'$'.number_format($tsalud,2),'R',1,'R',1);
		$sumegr=$sumegr+$tsalud;
	}
	if($tpension>0)
	{
		if($x==0){$pdf->SetFillColor(255,255,255);$x++;}
		else {$pdf->SetFillColor(245,245,245);$x=0;}
		$pdf->Cell(119,5,'Aporte Pension Funcionario 4% ','L',0,'L',1); 
		$pdf->Cell(40,5,'$'.number_format(0,2),0,0,'R',1);
		$pdf->Cell(40,5,'$'.number_format($tpension,2),'R',1,'R',1);
		$sumegr=$sumegr+$tpension;
	}
	if($tfondosol>0)
	{
		if($x==0){$pdf->SetFillColor(255,255,255);$x++;}
		else {$pdf->SetFillColor(245,245,245);$x=0;}
		$pdf->Cell(119,5,'Aporte Fondo de Solidaridad ','L',0,'L',1); 
		$pdf->Cell(40,5,'$'.number_format(0,2),0,0,'R',1);
		$pdf->Cell(40,5,'$'.number_format($tfondosol,2),'R',1,'R',1);
		$sumegr=$sumegr+$tfondosol;
	}
	$sqlr="SELECT hp.descripcion,hp.ncta,hr.ncuotas,hr.valorcuota FROM humnominaretenemp hp, humretenempleados hr WHERE hp.id_nom='$_POST[pdfidnom]' AND hp.cedulanit='$_POST[pdftercero]' AND hr.id=hp.id ORDER BY hr.id";
	$resp = mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($resp))
	{
		if($x==0){$pdf->SetFillColor(255,255,255);$x++;}
		else {$pdf->SetFillColor(245,245,245);$x=0;}
		$nomdescuento=iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$row[0]);
		$lineas = $pdf->getNumLines($nomdescuento, 121);
		$altura=(4*$lineas1);
		$pdf->Cell(121,$altura,$nomdescuento.' '.$row[1].' de '.$row[2],'L',0,'L',1); 
		$pdf->Cell(38,$altura,'$'.number_format(0,2),0,0,'R',1);
		$pdf->Cell(40,$altura,'$'.number_format($row[3],2),'R',1,'R',1);
		$sumegr+=$row[3];
	}
	if($x==0){$pdf->SetFillColor(255,255,255);$x++;}
	else {$pdf->SetFillColor(245,245,245);$x=0;}
	$pdf->Cell(119,5,'Totales:',1,0,'L',1); 
	$pdf->Cell(40,5,'$'.number_format($suming,2),1,0,'R',1);
	$pdf->Cell(40,5,'$'.number_format($sumegr,2),1,1,'R',1);
	$pdf->ln(18);
	$sqlrjn="SELECT nombrejnomina FROM humparametrosnomina WHERE estado='S'";
	$rowjn =mysql_fetch_row(mysql_query($sqlrjn,$linkbd));
	$jnomina=ucwords(strtolower($rowjn[0]));
	$pdf->SetFont('helvetica','I',8);
	$pdf->Cell(0.2);
	$pdf->cell(100,5,'Elaborado por: '.iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$jnomina),'T',0,'L',1);
	$pdf->Output();
?>