<?php
	/** IDEAL10 28/12/2019 DD
 	 * PDF - Soporte de traslado
	 */
	require_once 'tcpdf/tcpdf_include.php';
	require 'comun.inc';
	require 'funciones.inc';
	session_start();
	date_default_timezone_set("America/Bogota");


	class PDF extends TCPDF{
		/**
		 * Función para crear la cabecera del documento pdf con información del cliente
		 */
		public function Header(){
			$linkbd=conectar_v7();
			$sqlr="SELECT * FROM configbasica WHERE estado='S'";
			$row=mysqli_fetch_row(mysqli_query($linkbd,$sqlr));
			$nit=$row[0];$rs=$row[1];
			$this->Image('imagenes/escudo.jpg', 20, 12, 25, 25, 'JPG', '', 'T', true, 300, '', false, false, 0, false, false, false);
			$this->SetFont('helvetica','B',10);
			$this->SetY(10);
			$this->RoundedRect(10, 10, 190, 31, 1,'' );
			$this->Cell(0.1);
			$this->Cell(45,31,'','R',0,'L');
			$this->SetY(31);
			$this->SetFont('helvetica','B',8);
			$this->SetY(35);
			$this->Cell(0.1);
			$this->SetFont('helvetica','B',14);
			$this->SetY(14);
			$this->Cell(65.1);
			$this->cell(85,6,$rs,0,1,'C',0);
			$this->Cell(65.1);
			$this->SetFont('helvetica','B',10);
			$this->Cell(85,5,$nit,0,1,'C',0);
			$this->SetFont('helvetica','B',12);
			$this->Cell(65.1);
			$this->cell(85,10,'TRASLADO DE ACTIVO','T',1,'C',0);
		}

		/**
		 * Función para crear el pie de pagina del documento pdf con información del cliente
		 */
		public function Footer(){
			$linkbd=conectar_v7();
			$sqlr="SELECT direccion,telefono,web,email FROM configbasica WHERE estado='S'";
			$resp=mysqli_query($linkbd,$sqlr);
			while($row=mysqli_fetch_row($resp)){
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

	// Información de metadatos del archivo y parametros estandares
	$linkbd=conectar_v7();
	$pdf = new PDF('P','mm','Letter', true, 'iso-8859-1', false);
	$pdf->SetMargins(10, 45, 10, true);
	$pdf->SetHeaderMargin(45);
	$pdf->SetFooterMargin(20);
	$pdf->SetAutoPageBreak(TRUE, 20);
	if (@file_exists(dirname(__FILE__).'/lang/spa.php')){
		require_once(dirname(__FILE__).'/lang/spa.php');
		$pdf->setLanguageArray($l);
	}
	$pdf->AddPage();
	$pdf->SetFont('Times','',14);

	$sqlr="SELECT * FROM actitraslados_resp WHERE id=".$_POST['idtras'];
	$rowTraslado=mysqli_fetch_row(mysqli_query($linkbd,$sqlr));

	$sqlr="SELECT * FROM acticrearact_det WHERE placa=".$rowTraslado[1];
	$rowActivo=mysqli_fetch_row(mysqli_query($linkbd,$sqlr));

	//Cuerpo del documento
	$txt = "Fecha, ".@$rowTraslado[2];
	$txt1 = "ACTA DE ENTREGA DE ACTIVO N° ".$_POST['idtras'];
	$txt2 = "Se realiza entrega con constancia fisica, lo cual hace responsable del a quien recibe el activo de su estado, cuidado y entrega, en constancia firman.";
	$headerSizes = array(20,100,25,20,25);
	$headerNames = array('Placa', 'Nombre', 'Referencia', 'Modelo', 'Serial');
	$bodyText = array($rowActivo[1], $rowActivo[2], $rowActivo[3], $rowActivo[4], $rowActivo[5]);

	//Info Cabecera
	$y=$pdf->gety();
	$pdf->SetY(5+$y);
	$pdf->Cell(0, 5, @$txt,0,0,'L');
	$pdf->ln(15);
	$pdf->Cell(190, 5, @$txt1,0,0,'C');

	//Info del activo
	$pdf->ln(25);
	$pdf->Cell(50, 5, 'Información del activo:', 0, 0, 'c');
	$pdf->ln();
	$pdf->SetFont('Times','',10);
	for($i = 0; $i < count(@$headerSizes); ++$i)
		$pdf->Cell(@$headerSizes[$i], 7, @$headerNames[$i], 1, 0, 'C', 0);
	$pdf->ln();
	for($i = 0; $i < count(@$headerSizes); ++$i)
		$pdf->Cell(@$headerSizes[$i], 7, @$bodyText[$i], 1, 0, 'C', 0);

	//Info traslado
	$pdf->ln(15);
	$pdf->SetFont('Times','',14);
	$pdf->Cell(50, 5, 'Información del traslado:', 0, 0, 'L');
	$pdf->ln();
	$pdf->Cell(50, 7, 'Estado actual:', 1, 0, 'L', 0);
	$pdf->Cell(140, 7, @$rowTraslado[6], 1, 0, 'L', 0);
	$pdf->ln();
	$pdf->Cell(50, 7, 'Motivo del traslado:', 1, 0, 'L', 0);
	$pdf->Cell(140, 7, @$rowTraslado[7], 1, 0, 'L', 0);

	//Firmas
	$pdf->ln(15);
	$pdf->SetFont('Times','',14);
	$pdf->MultiCell(190,10,@$txt2,0,'L',false,1,'','',true,0,false,true,0,'T',false);

	$funcionarios = [];
	$sqlr="SELECT item, descripcion FROM hum_funcionarios
			WHERE codfun in ( SELECT codfun FROM hum_funcionarios WHERE descripcion=$rowTraslado[3])";
	$resp=mysqli_query($linkbd,$sqlr);
	while($row=mysqli_fetch_row($resp)){
		if($row[0] == 'NOMCARGO')
			array_push($funcionarios,$row[1]);
		if($row[0] == 'NOMTERCERO')
			array_push($funcionarios,$row[1]);
	};
	$sqlr="SELECT item, descripcion FROM hum_funcionarios
			WHERE codfun in ( SELECT codfun FROM hum_funcionarios WHERE descripcion=$rowTraslado[4])";
	$resp=mysqli_query($linkbd,$sqlr);
	while($row=mysqli_fetch_row($resp)){
		if($row[0] == 'NOMCARGO')
			array_push($funcionarios,$row[1]);
		if($row[0] == 'NOMTERCERO')
			array_push($funcionarios,$row[1]);
	};
	$sqlr="SELECT item, descripcion FROM hum_funcionarios
			WHERE codfun in ( SELECT codfun FROM hum_funcionarios WHERE descripcion=$rowTraslado[5])";
	$resp=mysqli_query($linkbd,$sqlr);
	while($row=mysqli_fetch_row($resp)){
		if($row[0] == 'NOMCARGO')
			array_push($funcionarios,$row[1]);
		if($row[0] == 'NOMTERCERO')
			array_push($funcionarios,$row[1]);
	};
	$pdf->ln(30);
	$y=$pdf->gety();
	$pdf->line(10,$y,90,$y);
	$pdf->Cell(80, 5, @$funcionarios[1], 0, 0, 'C');
	$pdf->ln();
	$pdf->Cell(80, 5, @$funcionarios[0], 0, 0, 'C');
	$pdf->ln();
	$pdf->Cell(80, 5, 'Elaborado.', 0, 0, 'C');

	$pdf->ln(30);
	$y=$pdf->gety();
	$pdf->line(10,$y,90,$y);
	$pdf->line(110,$y,190,$y);

	$pdf->Cell(80, 5, @$funcionarios[3], 0, 0, 'C');
	$pdf->Cell(125, 5, @$funcionarios[5], 0, 0, 'C');
	$pdf->ln();
	$pdf->Cell(80, 5, @$funcionarios[2] , 0, 0, 'C');
	$pdf->Cell(125, 5, @$funcionarios[4] , 0, 0, 'C');
	$pdf->ln();
	$pdf->Cell(80, 5, 'Quien entrega.', 0, 0, 'C');
	$pdf->Cell(125, 5, 'Quien recibe.', 0, 0, 'C');
	$pdf->Output();
?>