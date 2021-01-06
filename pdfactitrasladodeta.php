<?php
	/** IDEAL10 07/01/2020 DD
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

	$sqlr="SELECT acti.fecha,acti.motivo, acti.estado,
	acti_det.placa, acti_det.nombre, acti_det.referencia, acti_det.modelo, acti_det.serial,
	cc_ori.nombre AS ccosto_ori, dis_ori.nombre AS disposcion_ori, ubi_ori.nombre AS ubicacion_ori, are_ori.nombrearea AS area_ori, pro_ori.nombre AS prototipo_ori,
	cc_des.nombre AS ccosto_des, dis_des.nombre AS disposcion_des, ubi_des.nombre AS ubicacion_des, are_des.nombrearea AS area_des, pro_des.nombre AS prototipo_des
	FROM actitraslados AS acti
	LEFT JOIN acticrearact_det acti_det ON acti.activo = acti_det.placa
	LEFT JOIN centrocosto AS cc_ori ON acti.cc_ori = cc_ori.id_cc
	LEFT JOIN acti_disposicionactivos AS dis_ori ON acti.dispoactivo_ori = dis_ori.id
	LEFT JOIN actiubicacion AS ubi_ori ON acti.ubicacion_ori = ubi_ori.id_cc
	LEFT JOIN planacareas AS are_ori ON acti.area_ori = are_ori.codarea
	LEFT JOIN acti_prototipo AS pro_ori ON acti.prototipo_ori = pro_ori.id
	LEFT JOIN centrocosto AS cc_des ON acti.cc_des = cc_des.id_cc
	LEFT JOIN acti_disposicionactivos AS dis_des ON acti.dispoactivo_des = dis_des.id
	LEFT JOIN actiubicacion AS ubi_des ON acti.ubicacion_des = ubi_des.id_cc
	LEFT JOIN planacareas AS are_des ON acti.area_des = are_des.codarea
	LEFT JOIN acti_prototipo AS pro_des ON acti.prototipo_des = pro_des.id
	WHERE acti.id=".$_POST['idtras'];

	$rowTraslado=mysqli_fetch_row(mysqli_query($linkbd,$sqlr));

	//Cuerpo del documento
	$txt = "Fecha, ".@$rowTraslado[0];
	$txt1 = "ACTA DE SOPORTE DE MODIFICACIÓN DE ACTIVO N° ".$_POST['idtras'];
	$txt2 = "Se realiza constancia fisica, del cambio de los detalles del activo";
	$headerSizes = array(20,100,25,20,25);
	$headerNames = array('Placa', 'Nombre', 'Referencia', 'Modelo', 'Serial');
	$bodyText = array($rowTraslado[3], $rowTraslado[4], $rowTraslado[5], $rowTraslado[6], $rowTraslado[7]);

	//Info Cabecera
	$y=$pdf->gety();
	$pdf->SetY(5+$y);
	$pdf->Cell(0, 5, @$txt,0,0,'L');
	$pdf->ln(15);
	$pdf->Cell(190, 5, @$txt1,0,0,'C');

	//Info del activo
	$pdf->ln(20);
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
	$pdf->Cell(140, 7, @$rowTraslado[2], 1, 0, 'L', 0);
	$pdf->ln();
	$pdf->Cell(50, 7, 'Motivo del traslado:', 1, 0, 'L', 0);
	$pdf->Cell(140, 7, @$rowTraslado[1], 1, 0, 'L', 0);

	//Tabla de traslado

	$pdf->ln(15);
	$pdf->SetFont('Times','',14);
	$pdf->Cell(50, 5, 'Detalles del traslado:', 0, 0, 'L');
	$pdf->ln();
	$pdf->Cell(40, 7, 'DETALLES:', 1, 0, 'C', 0);
	$pdf->Cell(75, 7, 'ANTERIOR:', 1, 0, 'C', 0);
	$pdf->Cell(75, 7, 'ACTUAL:', 1, 0, 'C', 0);

	$headerNames = array('Centro de Costo:', 'Disposición:', 'Ubicación', 'Área', 'Portotipo');
	$hearderCount = 0;
	for($i = 8; $i < count(@$rowTraslado); $i=$i+2){
		$pdf->ln();
		$pdf->SetFont('Times','',12);
		$pdf->Cell(40, 7, @$headerNames[$hearderCount], 1, 0, 'L', 0);
		$pdf->Cell(75, 7, @$rowTraslado[$i], 1, 0, 'L', 0);
		$pdf->Cell(75, 7, @$rowTraslado[$i+1], 1, 0, 'L', 0);
		$hearderCount++;
	}
	$pdf->Output();
?>