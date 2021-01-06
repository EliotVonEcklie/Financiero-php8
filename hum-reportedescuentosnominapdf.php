<?php
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
			while($row=mysql_fetch_row($resp))
			{
				$nit=$row[0];
				$rs=iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",strtoupper($row[1]));
			}
			$sqlr="SELECT mes,fecha,vigencia FROM humnomina WHERE id_nom='$_POST[numnomp]'";
			$resp=mysql_query($sqlr,$linkbd);
			$row=mysql_fetch_row($resp);
			$mes=$row[0];
			$fechanom=date('d-m-Y',strtotime($row[1]));
			$vigencia=$row[2];
			$varfecha="$vigencia-$mes-01";
			$fechaul = new DateTime($varfecha);
			$fechaul->modify('last day of this month');
			$ultfecha=$fechaul->format('d-m-Y');
			$pirfecha=date('d-m-Y',strtotime($varfecha));
			$this->Image('imagenes/escudo.jpg', 22, 12, 25, 23.9, 'JPG', '', 'T', true, 300, '', false, false, 0, false, false, false);// Logo
			$this->SetFont('helvetica','B',8);
			$this->SetY(10);
			$this->RoundedRect(10, 10, 190, 31, 2.5,''); //Borde del encabezado
			$this->Cell(48,31,'','R',0,'L'); //Linea que separa el encabazado verticalmente
			$this->SetY(10);
			$this->SetX(58);
			$this->SetFont('helvetica','B',12);
			$this->Cell(142,15,"$rs",0,0,'C'); 
			$this->SetY(16);
			$this->SetX(58);
			$this->SetFont('helvetica','B',11);
			$this->Cell(142,10,"$nit",0,0,'C');
			$this->SetY(27);
			$this->SetX(58);
			$this->Cell(104,10,"REPORTE DESCUENTOS DE NOMINA ","TR",0,'C'); 
			$this->SetFont('helvetica','I',10);
			$this->SetY(32);
			$this->SetX(58);
			$this->Cell(104,9,"Periodo: $pirfecha al $ultfecha","R",0,'C'); 
			$this->SetFont('helvetica','B',9);
			$this->SetY(27);
			$this->SetX(162.5);
			$this->Cell(37,5," NOMINA: $_POST[numnomp]","T",0,'L');
			$this->SetY(31);
			$this->SetX(162.5);
			$this->Cell(35,6," FECHA: $fechanom",0,0,'L');
			$this->SetY(36);
			$this->SetX(162.5);
			$this->Cell(35,5," VIGENCIA: $vigencia",0,0,'L');
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
			//$this->SetY(-16);
			$this->SetFont('helvetica', 'I', 8);
			$txt = <<<EOD
$vardirec $vartelef
$varemail $varpagiw
EOD;
			$this->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);
			//$this->SetY(-13);
			$this->Cell(0, 3, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
			
		}
	}
		
	$pdf = new MYPDF('P','mm','Letter', true, 'iso-8859-1', false);// create new PDF document
	$pdf->SetDocInfoUnicode (true); 
	// set document information
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('G&CSAS');
	$pdf->SetTitle('Certificados');
	$pdf->SetSubject('Certificado de Disponibilidad');
	$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
	$pdf->SetMargins(10, 48, 10);// set margins
	$pdf->SetHeaderMargin(48);// set margins
	$pdf->SetFooterMargin(35);// set margins
	$pdf->SetAutoPageBreak(TRUE, 35);// set auto page breaks
	// set some language-dependent strings (optional)
	if (@file_exists(dirname(__FILE__).'/lang/spa.php')) 
	{
		require_once(dirname(__FILE__).'/lang/spa.php');
		$pdf->setLanguageArray($l);
	}
	// ---------------------------------------------------------
	$pdf->AddPage();
	$linkbd=conectar_bd();
	//limpiar tabla
	$sqlr="TRUNCATE hum_reportenominatem";
	mysql_query($sqlr,$linkbd);
	$sqlr="SELECT vigencia FROM humnomina WHERE id_nom='$_POST[numnomp]'";
	$resp=mysql_query($sqlr,$linkbd);
	$row=mysql_fetch_row($resp);
	$vigencia=$row[0];
	//carga parametros admfiscales
	$sqlr="SELECT icbf,sena,iti,cajas,esap FROM admfiscales WHERE vigencia='$vigencia'";
	$resp = mysql_query($sqlr,$linkbd);
	$row =mysql_fetch_row($resp);
	$vicbf=$row[0];
	$vsena=$row[1];
	$viti=$row[2];
	$vcajacomp=$row[3];
	$vesap=$row[4];
	if($vcajacomp!=''){$nomcaja=buscatercero($vcajacomp);}
	if($vicbf!=''){$nomicbf=buscatercero($vicbf);}
	if($vsena!=''){$nomsena=buscatercero($vsena);}
	if($viti!=''){$nomiti=buscatercero($viti);}
	if($vesap!=''){$nomesap=buscatercero($vesap);}
	//PARAMETROS INSTITUCION
	$sqlr="SELECT nit, razonsocial FROM configbasica WHERE estado='S'";
	$resp=mysql_query($sqlr,$linkbd);
	while($row=mysql_fetch_row($resp))
	{
		$nit=$row[0];
		$rs=iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",strtoupper($row[1]));
	}
	//descuentos funcionarios
	//visualizar
	$totalgeneral=0;
	$sqlr="SELECT cedulanit,SUM(valor) FROM humnominaretenemp WHERE id_nom='$_POST[numnomp]' GROUP BY cedulanit ORDER BY cedulanit";
	$resp=mysql_query($sqlr,$linkbd);
	while($row=mysql_fetch_row($resp))
	{
		$nomter=iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",buscatercero($row[0]));
		$pdf->SetFont('helvetica','IB',10);
		$pdf->Cell(30,6,"$row[0]",0,0,'L',false,0,0,false,'T','C');
		$pdf->MultiCell(160,6,$nomter,0,'L',false,1,'','',true,0,false,true,6,'M',false);
		$sqlr2="SELECT id,valor,descripcion FROM humnominaretenemp WHERE id_nom='$_POST[numnomp]' AND cedulanit='$row[0]'";
		$resp2=mysql_query($sqlr2,$linkbd);
		while($row2=mysql_fetch_row($resp2))
		{
			$sqlret1="SELECT id_retencion FROM humretenempleados WHERE id='$row2[0]'";
			$resret1=mysql_query($sqlret1,$linkbd);
			$rowret1=mysql_fetch_row($resret1);
			$sqlret2="SELECT beneficiario FROM humvariablesretenciones WHERE codigo='$rowret1[0]'";
			$resret2=mysql_query($sqlret2,$linkbd);
			$rowret2=mysql_fetch_row($resret2);
			$nomemp=iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",buscatercero($rowret2[0]));
			$descripc=iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$row2[2]);
			$pdf->SetFont('helvetica','',9);
			$pdf->Cell(30,6,"$rowret2[0]",0,0,'L',false,0,0,false,'T','C');
			$pdf->MultiCell(130,6,$descripc,0,'L',false,0,'','',true,0,false,true,6,'M',false);
			$pdf->Cell(30,6,"$ ".number_format($row2[1]),0,1,'R',false,0,0,false,'T','C');
		}
		$pdf->SetFont('helvetica','IB',10);
		$pdf->Cell(160,6,"Total:",0,0,'R',false,0,0,false,'T','C');
		$pdf->Cell(30,6,"$ ".number_format($row[1]),0,1,'R',false,0,0,false,'T','C');
		$pdf->ln(2);
		$totalgeneral=$totalgeneral+$row[1];
	}
	$pdf->SetFont('helvetica','IB',10);
	$pdf->Cell(160,6,"Total General:",0,0,'R',false,0,0,false,'T','C');
	$pdf->Cell(30,6,"$ ".number_format($totalgeneral),0,1,'R',false,0,0,false,'T','C');
	$pdf->ln(16);
	$sqlr="SELECT cedulanit,(SELECT nombrecargo FROM planaccargos WHERE codcargo='1') FROM planestructura_terceros WHERE codcargo='1' AND estado='S'";
	$res=mysql_query($sqlr,$linkbd);
	$row=mysql_fetch_row($res);
	$ppto=buscar_empleado($row[0]);
	$cargo=$row[1];
	$v=$pdf->gety();
	$pdf->Line(50,$v,160,$v);
	$pdf->Cell(190,4,''.iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$ppto),0,1,'C',false,0,0,false,'T','C');
	$pdf->Cell(190,4,''.iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$cargo),0,0,'C',false,0,0,false,'T','C');
	
	// ---------------------------------------------------------
	$pdf->Output('hum-reportenominaentidad.pdf', 'I');//Close and output PDF document
?>