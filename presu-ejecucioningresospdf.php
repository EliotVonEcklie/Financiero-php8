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
			//Parte Izquierda
			$this->Image('imagenes/eng.jpg',15,10,25,25);
			$this->SetFont('dejavusans','B',18);
			$this->SetY(10);
			$this->Cell(270,5,''.$rs,0,0,'C'); 
			$this->SetFont('dejavusans','B',12);
			$this->SetY(10);
			//$this->Cell(270,20,'SECRETARÍA DE HACIENDA MUNICIPAL',0,0,'C'); 
			//$this->SetFont('dejavusans','B',10);
			//$this->SetY(15);
			$this->Cell(270,20,'PRESUPUESTO',0,0,'C'); 
			//$this->SetY(20);
			$this->SetY(15);
			ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
			$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
			ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
			$fechaf2=$fecha[3]."-".$fecha[2]."-".$fecha[1];	
			$this->Cell(270,20,'EJECUCION DE INGRESOS DEL '.$fechaf.' AL '.$fechaf2,0,0,'C'); 
			$this->SetFont('dejavusans','',6);
			$this->RoundedRect(10, 36, 280, 8, 1.2, '1111', '');
			$this->SetY(36.5);
			$this->SetX(10.6);
			$this->SetFillColor(150,150,150);
			$this->SetTextColor(255,255,255);
			$this->Cell(279,6.8,'',0,0,'C',1);
			$this->SetY(38);
			$this->SetFont('dejavusans','',7);
			$this->Cell(25,4,'CUENTA',0,0,'C');
			$this->Cell(105,4,'NOMBRE',0,0,'C');
			$this->Cell(5,4,'FTES',0,0,'C');
			$this->Cell(25,4,'PRES.INI',0,0,'C');
			$this->Cell(25,4,'ADICION',0,0,'C');
			$this->Cell(25,4,'REDUC.',0,0,'C');
			$this->Cell(25,4,'PRES.DEF',0,0,'C');
			$this->Cell(25,4,'RECAUDADO',0,0,'C');
			$this->Cell(10,4,'%',0,0,'C');
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
			$this->SetFont('helvetica', 'I', 8);
			$txt = <<<EOD
$vardirec $vartelef
$varemail $varpagiw
EOD;
			$this->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);
			$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
		}
	}

//Creación del objeto de la clase heredada
	$pdf = new MYPDF('L','mm','Letter', true, 'iso-8859-1', false);
	$pdf->SetMargins(11, 45, 11, true);
	$pdf->SetHeaderMargin(45);
	$pdf->SetFooterMargin(20);
	$pdf->SetAutoPageBreak(TRUE, 20);
	if (@file_exists(dirname(__FILE__).'/lang/spa.php')) 
	{
		require_once(dirname(__FILE__).'/lang/spa.php');
		$pdf->setLanguageArray($l);
	}	
	$pdf->AddPage();
	$sumareca=0;
	$sumarp=0;	
	$sumaop=0;	
	$sumap=0;			
	$sumai=0;
	$sumapi=0;				
	$sumapad=0;	
	$sumapred=0;	
	$sumapcr=0;	
	$sumapccr=0;
	$pdf->SetFont('dejavusans','',6);
	for($x=0;$x<count($_POST[codcuenta]);$x++)
	{		
		$nombrett=iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[nomcuenta][$x]);
		$sumapred+=$_POST[predcuenta][$x];
		$sumapad+=$_POST[padcuenta][$x];
		$sumapi+=$_POST[picuenta][$x];
		$sumai+=$_POST[pdefcuenta][$x]; 
		$sumareca+=$_POST[vtotcuenta][$x];
		$lineas = $pdf->getNumLines($nombrett, 105);
		$altura=(3*$lineas);
		if ($con%2==0){$pdf->SetFillColor(255,255,255);}
		else {$pdf->SetFillColor(245,245,245);}
		if($_POST[picuenta][$x]!=''){$ptoinic=$_POST[picuenta][$x];}
		else {$ptoinic=0;}
		if($_POST[pdefcuenta][$x]!=''){$ptopdef=$_POST[pdefcuenta][$x];}
		else {$ptopdef=0;}
		$pdf->cell(25,$altura,$_POST[codcuenta][$x],0,0,'L',1);
		$pdf->MultiCell(105,$altura,$nombrett,0,'L',true,0,'','',true,0,false,true,0,'T',false);
		$pdf->cell(5,$altura,$_POST[fuente][$x],0,0,'C',1);
		$pdf->cell(25,$altura,number_format($ptoinic,2,',','.'),0,0,'R',1);
		$pdf->Cell(25,$altura,number_format($_POST[padcuenta][$x],2,',','.'),0,0,'R',1);
		$pdf->Cell(25,$altura,number_format($_POST[predcuenta][$x],2,',','.'),0,0,'R',1);
		$pdf->Cell(25,$altura,number_format($ptopdef,2,',','.'),0,0,'R',1);
		$pdf->Cell(25,$altura,number_format($_POST[vtotcuenta][$x],2,',','.'),0,0,'R',1);
		$pdf->Cell(10,$altura,number_format(ROUND(($_POST[vtotcuenta][$x]/$_POST[pdefcuenta][$x])*100,2),2),0,1,'R',1);
		$con=$con+1;
	}
	$pdf->Ln(2);
	$pdf->SetFont('dejavusans','',5);
	$vportot=round(($sumareca/$sumai)*100,2);
	$pdf->SetFillColor(150,150,150);
	$pdf->SetTextColor(255,255,255);

	$linkbd=conectar_bd();
	$sqlr="select *from configbasica where estado='S'";
	$res=mysql_query($sqlr,$linkbd);
	while($row=mysql_fetch_row($res))
	{
		$rs=$row[1];
		$nalca=$row[6];
	}
	$sqlr="select *from  tesoparametros where estado='S'";
	$res=mysql_query($sqlr,$linkbd);
	while($row=mysql_fetch_row($res)){$teso=iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$row[4]);}
	$pdf->ln(20);
	$yy1=$pdf->gety();
	$pdf->Cell(40);
	$pdf->Cell(80,4,iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$nalca),'T',1,'C',0);
	$pdf->Cell(40);
	$pdf->Cell(80,4,iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$rs),'',1,'C');
	$pdf->ln(20);
	$pdf->SetY($yy1);
	$pdf->SetFont('times','B',9);
	$pdf->Cell(135);
	$pdf->Cell(80,4,''.$teso,'T',1,'C');
	$pdf->Cell(135);
	$pdf->Cell(80,4,'JEFE TESORERIA','',1,'C');
	$pdf->Output();

?> 


	