<?php
	require_once("tcpdf/tcpdf_include.php");
	require('comun.inc');
	require('funciones.inc');
	session_start();	
	date_default_timezone_set("America/Bogota");
	class MYPDF extends TCPDF 
	{
		public function Header(){}
		public function Footer(){}
	}
	$pdf = new MYPDF('P','mm','Letter', true, 'iso-8859-1', false);// create new PDF document
	$pdf->SetDocInfoUnicode (true); 
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetMargins(10, 5, 10);// set margins
	$pdf->SetHeaderMargin(5);// set margins
	$pdf->SetFooterMargin(5);// set margins
	$pdf->SetAutoPageBreak(TRUE, 5);// set auto page breaks
	if (@file_exists(dirname(__FILE__).'/lang/spa.php')) 
	{
		require_once(dirname(__FILE__).'/lang/spa.php');
		$pdf->setLanguageArray($l);
	}
	$pdf->AddPage();
	$pdf->SetFont('Times','',10);
	$tab = array("UTF-8", "ASCII", "Windows-1252", "ISO-8859-15", "ISO-8859-1", "ISO-8859-6", "CP1256"); 
	$chain = "";$x=0;
	foreach ($tab as $i) 
	{ 
		foreach ($tab as $j) 
		{
			$chain = "($i) - ($j) - (".iconv($i, $j, "PRUEBA: Ñ ñ á é í ó ú Á É Í Ó Í Ú").")";
			if($x==0){$pdf->SetFillColor(255,255,255);$x++;}
			else {$pdf->SetFillColor(245,245,245);$x=0;}
			$pdf->cell(190,5,$chain,1,1,'L',1);
		} 
	}
	$pdf->Output();
?>