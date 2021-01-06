<?php
	require_once 'tcpdf/tcpdf_include.php';
	require 'comun.inc';
	require 'funciones.inc';
	sesion();
	date_default_timezone_set("America/Bogota");
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
			$this->SetY(27);
			$this->Cell(50.2);
			$descrip=iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT","Desprendible de global de nómina periodos laborados del ".$_POST['fecha']." al ".$_POST['fecha2']);
			$this->multiCell(148.8,14,$descrip,'T','C');
			$this->ln(12);
		}
		public function Footer() 
		{
			$linkbd=conectar_v7();
			$sqlr="SELECT direccion,telefono,web,email FROM configbasica WHERE estado='S'";
			$resp=mysqli_query($linkbd,$sqlr);
			while($row=mysqli_fetch_row($resp))
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
	$linkbd=conectar_v7();
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(26,5,'Funcionario: ','LT',0,'L',1);
	$pdf->SetFont('helvetica','',10);
	$pdf->cell(98,5,''.$_POST['ntercero'],'T',0,'L',1);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(35,5,'C.C. o NIT: ','T',0,'L',1);
	$pdf->SetFont('helvetica','',10);
	$pdf->cell(40,5,''.$_POST['tercero'],'TR',1,'L',1);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(26,5,'Cargo: ','LB',0,'L',1);
	$cargofun=cargofuncionario($_POST['idusuario']);
	$pdf->SetFont('helvetica','',10);
	$pdf->cell(98,5,''.iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$cargofun),'B',0,'L',1);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(35,5,iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT","Días Laborales").': ','B',0,'L',1);
	$pdf->SetFont('helvetica','',10);
	$pdf->cell(40,5,''.array_sum ($_POST['pdfdiaslab']),'BR',1,'L',1);
	$totalgeneral=$sumingtotal=$sumegrtotal=0;
	for ($xy=0;$xy<count($_POST['pdfidnom']);$xy++)
	{
		$pdf->ln(5);	
		$pdf->SetFont('helvetica','B',10);
		$pdf->Cell(199,5,'NOMINA No '.$_POST['pdfidnom'][$xy],1,1,'C',0);
		$pdf->Cell(119,5,'DETALLES',1,0,'C',0); 
		$pdf->Cell(40,5,'PAGOS',1,0,'C',0);
		$pdf->Cell(40,5,'DESCUENTOS',1,1,'C',0);
		$x=$tsalud=$tpension=$tfondosol=$suming=$sumegr=$auxalim=$auxtran=$retefte=0;
		$sqlr="SELECT tipopago,SUM(devendias),SUM(salud),SUM(pension),SUM(fondosolid),SUM(auxalim),SUM(auxtran),SUM(retefte) FROM humnomina_det WHERE id_nom='".$_POST['pdfidnom'][$xy]."' AND idfuncionario='".$_POST['idusuario']."' GROUP BY tipopago ORDER BY id_nom DESC, tipopago";
		$resp = mysqli_query($linkbd,$sqlr);
		while ($row =mysqli_fetch_row($resp))
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
			$pdf->Cell(119,5,iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",'SUBSIDIO DE ALIMENTACION'),'L',0, 'L',1); 
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
			$pdf->Cell(119,5,iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",'Retención en la Fuente'),'L',0, 'L',1); 
			$pdf->Cell(40,5,'$'.number_format(0,2),0,0,'R',1);
			$pdf->Cell(40,5,'$'.number_format($retefte,2),'R',1,'R',1);
			$sumegr=$sumegr+$retefte;
		}
		if($tsalud>0)
		{
			if($x==0){$pdf->SetFillColor(255,255,255);$x++;}
			else {$pdf->SetFillColor(245,245,245);$x=0;}
			$pdf->Cell(119,5,'Aporte Salud Funcionario 4%','L',0,'L',1); 
			$pdf->Cell(40,5,'$'.number_format(0,2),0,0,'R',1);
			$pdf->Cell(40,5,'$'.number_format($tsalud,2),'R',1,'R',1);
			$sumegr=$sumegr+$tsalud;
		}
		if($tpension>0)
		{
			if($x==0){$pdf->SetFillColor(255,255,255);$x++;}
			else {$pdf->SetFillColor(245,245,245);$x=0;}
			$pdf->Cell(119,5,'Aporte Pension Funcionario 4%','L',0,'L',1); 
			$pdf->Cell(40,5,'$'.number_format(0,2),0,0,'R',1);
			$pdf->Cell(40,5,'$'.number_format($tpension,2),'R',1,'R',1);
			$sumegr=$sumegr+$tpension;
		}
		if($tfondosol>0)
		{
			if($x==0){$pdf->SetFillColor(255,255,255);$x++;}
			else {$pdf->SetFillColor(245,245,245);$x=0;}
			$pdf->Cell(119,5,'Aporte Fondo de Solidaridad','L',0,'L',1); 
			$pdf->Cell(40,5,'$'.number_format(0,2),0,0,'R',1);
			$pdf->Cell(40,5,'$'.number_format($tfondosol,2),'R',1,'R',1);
			$sumegr=$sumegr+$tfondosol;
		}
		$sqlr="SELECT hp.descripcion,hp.ncta,hr.ncuotas,hr.valorcuota FROM humnominaretenemp hp, humretenempleados hr WHERE hp.id_nom='".$_POST['pdfidnom'][$xy]."' AND hp.cedulanit='".$_POST['tercero']."' AND hr.id=hp.id AND hp.tipo_des='DS' ORDER BY hr.id";
		$resp = mysqli_query($linkbd,$sqlr);
		while ($row =mysqli_fetch_row($resp))
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
		$pdf->Cell(119,5,'Total Nomina '.$_POST['pdfidnom'][$xy],1,0,'L',1); 
		$pdf->Cell(80,5,'$'.number_format($suming-$sumegr,2),1,1,'C',1);
		$sumingtotal+=$suming;
		$sumegrtotal+=$sumegr;
		$totalgeneral=$totalgeneral+$suming-$sumegr;
	}
	$pdf->ln(5);
	$pdf->SetFont('Times','',10);
	$pdf->SetFont('helvetica','B',12);
	$pdf->Cell(119,5,'Totales Generales:',1,0,'L',1); 
	$pdf->Cell(40,5,'$'.number_format($sumingtotal,2),1,0,'R',1);
	$pdf->Cell(40,5,'$'.number_format($sumegrtotal,2),1,1,'R',1);
	$pdf->ln(5);
	$pdf->cell(125);
	$pdf->cell(27,8,'TOTAL CANCELADO: ',0,0,'R');
	$pdf->cell(47,8,'$'.number_format($totalgeneral,2),1,0,'C',0);
	$pdf->ln(10);
	$fechafirmas=date('Y-m-d');
	$linkbd=conectar_v7();
	$sqlr="SELECT funcionario,nomcargo FROM firmaspdf_det WHERE idfirmas='3' AND estado ='S' AND fecha < '$fechafirmas' ORDER BY orden";
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
	$pdf->Output();
?>