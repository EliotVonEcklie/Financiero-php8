<?php
	require_once('barras/tcpdf_include.php');
	require('comun.inc');
	session_start();
	class MYPDF extends TCPDF 
	{
		public function Header() {}
		public function Footer() {}
	}
	$pdf = new MYPDF('P','mm','Letter', true, 'iso-8859-1', false);// create new PDF document
	// define barcode style
	$style = array(
		'position' => '',
		'align' => 'C',
		'stretch' => false,
		'fitwidth' => true,
		'cellfitalign' => '',
		'border' => false,
		'hpadding' => 'auto',
		'vpadding' => 'auto',
		'fgcolor' => array(0,0,0),
		'bgcolor' => false, //array(255,255,255),
		'text' => false,
		'font' => 'helvetica',
		'fontsize' => 8,
		'stretchtext' => 1
	);
	$pdf->AddPage();// add a page
	$linkbd=conectar_bd();
	$sqlr="SELECT nit, razonsocial FROM configbasica WHERE estado='S'";
	$resp=mysql_query($sqlr,$linkbd);
	while($row=mysql_fetch_row($resp))
	{
		$nit=$row[0];
		$rs=utf8_encode(strtoupper($row[1]));
	}
	$pdf->RoundedRect(10, 10, 60, 31, 2.5,''); //Borde del encabezado
	$pdf->SetY(10);
	$pdf->SetFont('helvetica','B',9);
	$pdf->Cell(60,5,"N°: $_POST[nradicado]",0,0,'C');
	$pdf->SetY(15);
	$pdf->Cell(60,5,"FECHA: $_POST[fecharad]",0,0,'C');
	$pdf->SetY(20);
	$pdf->Cell(60,5,"HORA: ".date('h:i:s a',strtotime($_POST[horarad])),0,0,'C');
	$pdf->SetY(24);
	$pdf->write1DBarcode($_POST[nradicado],'C39', 12, '', 80, 9, 0.25, $style, 'N');
	$pdf->SetFont('helvetica','B',8);
	$pdf->SetY(31);
	$pdf->Cell(60,5,''.$rs,0,0,'C',false,0,1,false,'T','B'); //Nombre Municipio
	$pdf->SetFont('helvetica','B',8);
	$pdf->SetY(35);
	$pdf->Cell(60,5," $nit",0,0,'C',false,0,1,false,'T','C'); //Nit
	// ---------------------------------------------------------
	$pdf->Output('Radicacion.pdf', 'I');//Close and output PDF document
?>