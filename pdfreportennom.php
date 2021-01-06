<?php
	require_once 'tcpdf/tcpdf_include.php';
	require 'comun.inc';
	require 'funciones.inc';
	session_start();
	date_default_timezone_set("America/Bogota");
	class MYPDF extends TCPDF 
	{
		public function Header()
		{
			$linkbd=conectar_v7();
			$sqlr="SELECT * FROM configbasica WHERE estado='S'";
			$row=mysqli_fetch_row(mysqli_query($linkbd,$sqlr));
			$nit=$row[0];$rs=$row[1];
			$detalles="LIQUIDACION No. ".$_POST['nnomina']."  VIGENCIA ".$_POST['vigencias'];
			$this->Image('imagenes/escudo.jpg', 30, 12, 25, 25, 'JPG', '', 'T', true, 300, '', false, false, 0, false, false, false);
			$this->SetFont('helvetica','B',10);
			$this->SetY(10);
			$this->RoundedRect(10, 10, 260, 31, 1,'' );
			$this->Cell(0.1);
			$this->Cell(65,31,'','R',0,'L'); 
			$this->SetY(31);
			$this->SetFont('helvetica','B',8);
			$this->SetY(35);
			$this->Cell(0.1);
			$this->SetFont('helvetica','B',14);
			$this->SetY(14);
			$this->Cell(65.1);
			$this->cell(195,6,$rs,0,1,'C',0);
			$this->Cell(65.1);
			$this->SetFont('helvetica','B',10);
			$this->Cell(195,5,$nit,0,1,'C',0);
			$this->SetFont('helvetica','B',12);
			$this->Cell(65.1);
			$this->cell(195,10,'REPORTE DE NOMINA','T',1,'C',0);
			$this->SetFont('helvetica','B',10);
			$this->SetY(33);
			$this->Cell(65);
			$this->MultiCell(195,10,$detalles,0,'C',false,1,'','',true,0,false,true,0,'T',false);
			$this->SetFont('helvetica','B',10);
			$this->SetY(27);
			$this->Cell(50.2);
			$this->MultiCell(105.7,4,'',0,'L');
			$this->SetFont('times','B',10);
		}
		public function Footer()
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
	$linkbd=conectar_v7();
	$pdf = new MYPDF('L','mm','Letter', true, 'iso-8859-1', false);
	$pdf->SetMargins(10, 45, 10, true);
	$pdf->SetHeaderMargin(45);
	$pdf->SetFooterMargin(20);
	$pdf->SetAutoPageBreak(TRUE, 20);
	if (@file_exists(dirname(__FILE__).'/lang/spa.php')) 
	{
		require_once(dirname(__FILE__).'/lang/spa.php');
		$pdf->setLanguageArray($l);
	}	
	$pdf->AddPage();
	$pdf->SetFont('Times','',10);
	$con=$con1=0;
	while ($con<count($_POST['cont'])) 
	{
		$yy=$pdf->gety();//echo "$yy - ";
		if($yy==45)
		{
			$pdf->line(10,45,270,45);
			$pdf->RoundedRect(10,46, 260, 5, 1,'' );
			$pdf->line(10,52,270,52);
			$pdf->SetFont('helvetica','B',7);
			$pdf->cell(5,5,'No.',0,0,'C',0);
			$pdf->Cell(45,5,'Nombre',0,0,'C',0);
			$pdf->Cell(10,5,'Basico',0,0,'C',0);
			$pdf->Cell(8,5,'Dias',0,0,'C',0);
			$pdf->Cell(15,5,'Devengado',0,0,'C',0);
			$pdf->Cell(15,5,'Aux Alimen',0,0,'C',0);
			$pdf->Cell(15,5,'Aux Trans',0,0,'C',0);
			$pdf->Cell(12,5,'Otros Pag.',0,0,'C',0);
			$pdf->Cell(15,5,'Total Dev',0,0,'C',0);
			$pdf->Cell(15,5,'IBC',0,0,'C',0);
			$pdf->Cell(15,5,'Salud',0,0,'C',0);
			$pdf->Cell(15,5,'Pension',0,0,'C',0);
			$pdf->Cell(15,5,'Fondo',0,0,'C',0);
			$pdf->Cell(15,5,'ReteFu',0,0,'C',0);
			$pdf->Cell(15,5,'Otras Ded',0,0,'C',0);
			$pdf->Cell(15,5,'Total Ded',0,0,'C',0);
			$pdf->Cell(15,5,'A Pagar',0,1,'C',0);
			$pdf->ln(3);
		}
		if ($con%2==0){$pdf->SetFillColor(245,245,245);}
		else{$pdf->SetFillColor(255,255,255);}
		$pdf->SetFont('Times','',6.5);
		$pdf->cell(5,5,$_POST['cont'][$con],0,0,'L',1); 
		$pdf->cell(45,5,iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST['empleados'][$con]),0,0,'L',1);
		$pdf->cell(10,5,number_format($_POST['basico'][$con]),0,0,'R',1);
		$pdf->cell(8,5,$_POST['dias'][$con],0,0,'C',1);
		$pdf->cell(15,5,number_format($_POST['deveng'][$con]),0,0,'R',1);
		$pdf->cell(15,5,number_format($_POST['auxali'][$con]),0,0,'R',1);
		$pdf->cell(15,5,number_format($_POST['auxtrans'][$con]),0,0,'R',1);
		$pdf->cell(12,5,number_format($_POST['horas_ex'][$con]),0,0,'R',1);
		$pdf->cell(15,5,number_format($_POST['totaldev'][$con]),0,0,'R',1);
		$pdf->cell(15,5,number_format($_POST['ibc'][$con]),0,0,'R',1);
		$pdf->cell(15,5,number_format($_POST['salud'][$con]),0,0,'R',1);
		$pdf->cell(15,5,number_format($_POST['pension'][$con]),0,0,'R',1);
		$pdf->cell(15,5,number_format($_POST['fsoli'][$con]),0,0,'R',1);
		$pdf->cell(15,5,number_format($_POST['retefuen'][$con]),0,0,'R',1);
		$pdf->cell(15,5,number_format($_POST['otrasded'][$con]),0,0,'R',1);
		$pdf->cell(15,5,number_format($_POST['totalded'][$con]),0,0,'R',1);
		$pdf->cell(15,5,number_format($_POST['netopag'][$con]),0,1,'R',1);
		$con=$con+1;
		$yy=$pdf->gety();
		if ($yy==188){$pdf->line(10,188,270,188);$pdf->AddPage();}
	}	
	if($yy>=168){$pdf->AddPage();}
	if($yy != 45){$pdf->line(10,$yy,270,$yy);}
	$pdf->SetFont('Times','B',6.5);
	$pdf->Cell(68,5,'TOTALES','T',0,'R');
	$pdf->Cell(15,5,'$ '.number_format($_POST['totaldevini']),'T',0,'R');
	$pdf->Cell(15,5,'$ '.number_format($_POST['totalauxalim']),'T',0,'R');
	$pdf->Cell(15,5,'$ '.number_format($_POST['totalauxtra']),'T',0,'R');
	$pdf->Cell(12,5,'$ '.number_format($_POST['totalhorex']),'T',0,'R');
	$pdf->Cell(15,5,'$ '.number_format($_POST['totaldevtot']),'T',0,'R');
	$pdf->Cell(15,5,'$ '.number_format($_POST['totalibc']),'T',0,'R');
	$pdf->Cell(15,5,'$ '.number_format($_POST['totalsalud']),'T',0,'R');
	$pdf->Cell(15,5,'$ '.number_format($_POST['totalpension']),'T',0,'R');
	$pdf->Cell(15,5,'$ '.number_format($_POST['totalfondosolida']),'T',0,'R');
	$pdf->Cell(15,5,'$ '.number_format($_POST['totalretef']),'T',0,'R');
	$pdf->Cell(15,5,'$ '.number_format($_POST['totalotrasreducciones']),'T',0,'R');
	$pdf->Cell(15,5,'$ '.number_format($_POST['totaldeductot']),'T',0,'R');
	$pdf->Cell(15,5,'$ '.number_format($_POST['totalnetopago']),'T',0,'R');
	$pdf->ln(2);
	$v=$pdf->gety();
	$x=$pdf->getx();
	$sqlr="SELECT * FROM dominios WHERE nombre_dominio='APRUEBA_NOMINA' and tipo='S'";
	$res=mysqli_query($linkbd,$sqlr);
	while($row=mysqli_fetch_row($res))
	{
		$cargo=$row[5];
		$responsable=$row[2];
	}
	$pdf->ln(2);
	$linkbd=conectar_v7();
	$sqlr="SELECT funcionario,nomcargo FROM firmaspdf_det WHERE idfirmas='4' AND estado ='S' AND fecha < '".$_POST['fecha']."' ORDER BY orden";
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
		if (($x%3)==0) 
		{
			if(isset($_POST['ppto'][$x+1]))
			{
				$pdf->Line(10,$v,90,$v);
				$pdf->Line(95,$v,175,$v);
				$pdf->Line(180,$v,270,$v);
				$v2=$pdf->gety();
				$pdf->Cell(87,4,''.iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST['ppto'][$x]),0,1,'C',false,0,0,false,'T','C');
				$pdf->Cell(87,4,''.iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST['nomcargo'][$x]),0,1,'C',false,0,0,false,'T','C');
				$pdf->SetY($v2);
				$pdf->Cell(258,4,''.iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST['ppto'][$x+1]),0,1,'C',false,0,0,false,'T','C');
				$pdf->Cell(258,4,''.iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST['nomcargo'][$x+1]),0,1,'C',false,0,0,false,'T','C');
				$pdf->SetY($v2);
				$pdf->Cell(439,4,''.iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST['ppto'][$x+2]),0,1,'C',false,0,0,false,'T','C');
				$pdf->Cell(439,4,''.iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST['nomcargo'][$x+2]),0,1,'C',false,0,0,false,'T','C');
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