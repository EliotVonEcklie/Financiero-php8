<?php
//V 1000 12/12/16
	require_once("tcpdf/tcpdf_include.php");
	require('comun.inc');
	require"funciones.inc";
	session_start();
	
	$_POST[datoaux][0]=0;
	$_POST[datoaux2][0]=0;
	
	class MYPDF extends TCPDF 
	{
			
		public function Header() 
		{
			$linkbd=conectar_bd();
			$con=0;
			$_POST[contador]=0;
			$sql="SELECT MAX(cod_meta) FROM planproyectos_det WHERE codigo='$codigo'";
			$result=mysql_query($sql,$linkbd);
			$rowc = mysql_fetch_row($result);
			$_POST[contador]=$rowc[0]+1;
			
			$sqlr="SELECT nit, razonsocial FROM configbasica WHERE estado='S'";
			$resp=mysql_query($sqlr,$linkbd);
			while($row=mysql_fetch_row($resp)){$nit=$row[0];$rs=utf8_encode(strtoupper($row[1]));}
			$this->Image('imagenes/escudo.jpg', 25, 10, 25, 23.9, 'JPG', '', 'T', true, 300, '', false, false, 0, false, false, false);// Logo
			$this->SetFont('helvetica','B',8);
			$this->SetY(10);
			$this->RoundedRect(10, 10, 190, 31, 2.5,''); //Borde del encabezado
			$this->Cell(52,31,'','R',0,'L'); //Linea que separa el encabazado verticalmente
			$this->SetY(31);
			$this->Cell(52,5,''.$rs,0,0,'C',false,0,1,false,'T','B'); //Nombre Municipio
			$this->SetFont('helvetica','B',8);
			$this->SetY(35);
			$this->Cell(52,5,''.$nit,0,0,'C',false,0,1,false,'T','C'); //Nit
			$this->SetFont('helvetica','B',10);
			$this->SetY(10);
			$this->SetX(62);
			$this->Cell(100,17,'SECRETARIA DE PLANEACIÓN E INFRAESTRUCTURA',1,0,'C'); 
			$this->SetFont('helvetica','I',10);
			$this->SetY(27);
			$this->SetX(62);
			$this->SetFont('helvetica','B',10);
			$this->Cell(100,7,'BPPIM','T',0,'C',false,0,1); 
			$this->SetY(27);
			$this->SetX(62);
			$this->Cell(100,7,"",0,0,'L',false,0,1);
			$this->SetFont('helvetica','B',9);
			$this->SetY(10);
			$this->SetX(162);
			$this->Cell(37.8,30.7,'','L',0,'L');
			$this->SetY(24);
			$this->SetX(162.5);
			$this->Cell(35,5," FECHA: ".$_POST[fecha],0,0,'L');
			$this->SetY(29);
			$this->SetX(162.5);
			$this->Cell(35,5," VIGENCIA: ".$_POST[vigencia],0,0,'L');

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
			if($direcc!=''){$vardirec="Dirección: $direcc, ";}
			else {$vardirec="";}
			if($telefonos!=''){$vartelef="Telefonos: $telefonos";}
			else{$vartelef="";}
			if($dirweb!=''){$varemail="Email: $dirweb, ";}
			else {$varemail="";}
			if($coemail!=''){$varpagiw="Pagina Web: $coemail";}
			else{$varpagiw="";}
			$this->SetY(-16);
			$this->SetFont('helvetica', 'I', 8);
			$txt = <<<EOD
$vardirec $vartelef
$varemail $varpagiw
EOD;
			$this->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);
			$this->SetY(-13);
			$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
			
		}
	}
	function obtenerCodigoMeta($proyecto,$meta){
		$linkbd=conectar_bd();
		$sql="SELECT planproyectos_det.cod_meta FROM planproyectos_det WHERE planproyectos_det.codigo='$proyecto' AND planproyectos_det.valor='$meta' ";
		$res=mysql_query($sql,$linkbd);
		$fila=mysql_fetch_row($res);
		return $fila[0];
	}
		
	$pdf = new MYPDF('P','mm','Letter', true, 'iso-8859-1', false);// create new PDF document
	$pdf->SetDocInfoUnicode (true); 
	// set document information
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('G&CSAS');
	$pdf->SetTitle('Certificados');
	$pdf->SetSubject('Certificado de Disponibilidad');
	$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
	$pdf->SetMargins(10, 60, 10);// set margins
	$pdf->SetHeaderMargin(60);// set margins
	$pdf->SetFooterMargin(25);// set margins
	$pdf->SetAutoPageBreak(TRUE, 25);// set auto page breaks
	// set some language-dependent strings (optional)
	if (@file_exists(dirname(__FILE__).'/lang/spa.php')) 
	{
		require_once(dirname(__FILE__).'/lang/spa.php');
		$pdf->setLanguageArray($l);
	}
	// ---------------------------------------------------------
	$pdf->AddPage();
	$linkbd=conectar_bd();
	//-----------------------------------------------------
	$sql="SELECT UPPER(razonsocial) from configbasica";
	$res=mysql_query($sql,$linkbd);
	$config=mysql_fetch_row($res);
	
	$sql="SELECT tipo,descripcion FROM contrasolicitudproyecto WHERE codsolicitud='$_POST[codigot]' ";
	$res=mysql_query($sql,$linkbd);
	$fila=mysql_fetch_row($res);
	$tipo="EL PROYECTO DENOMINADO";
	if($fila[0]=='proyecto'){
		$tipo="EL PROYECTO DENOMINADO";
	}else if($fila[0]=='actividad'){
		$tipo="LA ACTIVIDAD DENOMINADA";
	}
	$pdf->SetY(50);
	$pdf->SetFont('times','B',12);
	$pdf->MultiCell(195.7,5,'BANCO DE PROGRAMAS Y PROYECTOS DE INVERSIÓN MUNICIPAL','','C');	
	$pdf->Cell(199,12,'CERTIFICA:',0,0,'C');
	$pdf->SetY(70);	
	$pdf->SetFont('times','',11);
	$pdf->cell(0.1);
	$pdf->MultiCell(190,8,'Que '.strtolower($tipo).': " '.strtoupper(utf8_encode($_POST[nombre])).' ". Hace parte del proyecto de inversión registrado en el BPIM con el código '.$_POST[codigoproy].', de fecha '.$_POST[fecha].' cuyo objeto es " '.strtoupper(utf8_encode($fila[1])).' ", el cual se articula con el Plan de Desarrollo Municipal del '.$config[0].', bajo la siguiente estructura. ',0,'L',false,1,'','',true,0,false,true,0,'T',false);
	//---
	$pdf->ln(10);
	$pdf->SetFont('times','',9);
	$posy=$pdf->GetY();
	$pdf->SetY($posy+1);
	$pdf->SetFillColor(255,255,255);
	$sql="SELECT contrasolicitudproyecto.metascert FROM contrasolicitudproyecto WHERE contrasolicitudproyecto.codsolicitud='$_POST[codigot]'  ";
	$res=mysql_query($sql,$linkbd);
	$fila = mysql_fetch_row($res);
	$cont=0;
	$arreglo=explode("-",$fila[0]);
	$cantidad=count($arreglo);
	for($i=0;$i<$cantidad;$i++){
		$nummeta=obtenerCodigoMeta($_POST[codigoproy],$arreglo[$i]);
		$sql1="SELECT valor,nombre_valor FROM planproyectos_det WHERE codigo='$_POST[codigoproy]' AND cod_meta='$nummeta'  ORDER BY LENGTH(valor),cod_meta ASC ";
		$res1=mysql_query($sql1,$linkbd);
		while($row1 = mysql_fetch_row($res1)){
			$_POST[datoaux][$cont]=$row1[0];
			$_POST[datoaux2][$cont]=$row1[1];
			$tam=strlen($row1[0])+strlen(strtoupper(utf8_decode($row1[1])))+1;
			$pdf->Cell(50.1);
			$pdf->MultiCell(140,4.4,' '.$row1[0].' '.strtoupper(utf8_encode($row1[1])),1,1,'L');
			$cont++;
		}$cont=0;
	}
	$sql="SELECT valor FROM planproyectos WHERE codigo='$_POST[codigoproy]' ";
	$res=mysql_query($sql,$linkbd);
	$fila=mysql_fetch_row($res);
	$pdf->Cell(50.1);
	$pdf->Cell(140,5.5,' $'.number_format($fila[0],2,',','.'),1,1,'L');
	$pdf->Cell(50.1);
	$sql="SELECT val_actividad, apor_convenio, apor_municipio FROM contrasolicitudproyecto WHERE codsolicitud='$_POST[codigot]' ";
	$res=mysql_query($sql,$linkbd);
	$row = mysql_fetch_row($res);
	$_POST[valacti]=$row[0];
	$_POST[aporconv]=$row[1];
	$_POST[apormuni]=$row[2];
	$pdf->Cell(140,5.5,' '.$_POST[valacti],1,1,'L');
	$pdf->Cell(50.1);
	$pdf->Cell(140,5.5,' '.$_POST[aporconv],1,1,'L');
	$pdf->Cell(50.1);
	$pdf->Cell(140,5.5,' '.$_POST[apormuni],1,1,'L');
	$posicionfinal=$pdf->GetY();
	$pdf->SetPage(1);
	$pdf->SetY($posy+1);
	$pdf->SetFont('times','',9);
	$pdf->SetFillColor(255,255,255);
	$sql="SELECT contrasolicitudproyecto.metascert FROM contrasolicitudproyecto WHERE contrasolicitudproyecto.codsolicitud='$_POST[codigot]'  ";
	$res=mysql_query($sql,$linkbd);
	$fila = mysql_fetch_row($res);
	$cantidad=count(explode("-",$fila[0]));
	$numax=$cantidad;
	for($x=0;$x<$numax; $x++){
		$sqln="SELECT nombre, orden FROM plannivelespd WHERE estado='S' ORDER BY orden";
		$resn=mysql_query($sqln,$linkbd);
		$n=0; $j=0;
		$pdf->Cell(0.1);
		while($wres=mysql_fetch_array($resn))
			{
				if (strcmp($wres[0],'INDICADORES')!=0)
				{
					$pdf->SetFillColor(235,235,235);
					if(!empty($_POST["matmetas$x"][$cont]) || !empty($_POST["matmetas1$x"][$cont]))
					{
						$tamano=strlen($_POST[datoaux][$cont])+strlen(strtoupper(utf8_decode($_POST[datoaux2][$cont])))+1;
						$modulo=$tamano%80;
						if($modulo==$tamano)
						{
							$pdf->Cell(50,4.4,' '.strtoupper($wres[0]),1,1,'C',TRUE);		
						}else{
							$multi=(round($tamano/80*2));
							if($tamano==134)
							{
								$pdf->Cell(50,(4.1*2),' '.strtoupper($wres[0]),1,1,'C',TRUE);
							}else{
								if($modulo>=37)
								{
									$pdf->Cell(50,(4.1*$multi),' '.strtoupper($wres[0]),1,1,'C',TRUE);
								}else{
									$pdf->Cell(50,(4.1*$multi),' '.strtoupper($wres[0]),1,1,'C',TRUE);
								}
							}
						}
					}
					$cont++; 
				}
			}
		$cont=0;
	}
	$pdf->Cell(0.1);
	$pdf->SetFillColor(235,235,235);
	$pdf->Cell(50,5.5,'VALOR COMPONENTE MGA',1,1,'C',TRUE);
	$pdf->Cell(0.1);
	$pdf->SetFillColor(235,235,235);
	$pdf->Cell(50,5.5,'VALOR SOLICITADO',1,1,'C',TRUE);
	$pdf->Cell(0.1);
	$pdf->SetFillColor(235,235,235);
	$pdf->Cell(50,5.5,'APORTE CONVENIO',1,1,'C',TRUE);
	$pdf->Cell(0.1);
	$pdf->SetFillColor(235,235,235);
	$pdf->Cell(50,5.5,'APORTE MUNICIPIO',1,1,'C',TRUE);
	$pdf->Cell(50.1);
	$pdf->ln(8);
	$pdf->SetFont('times','',11);
	$pdf->cell(0.1);
	$hoy=getdate();
	$pdf->MultiCell(190,8,'La presente certificación se expide a los '.$hoy[mday].' dias del mes de Agosto de '.$hoy[year].' en el despacho de la Secretaría de Planeación e infraestructura en cumplimiento de los procesos y procedimientos establecidos por el Banco de Programas y Proyectos de Inversión Municipal.',0,'L',false,1,'','',true,0,false,true,0,'T',false);
			//Termina cuerpo
	$pdf->SetFont('helvetica','I',9);
	$pdf->ln(15);
	$v=$pdf->gety();
	$pdf->setFont('times','B',10);
	$pdf->Line(50,$v,160,$v);
	$pdf->Cell(190,6,''.utf8_encode("FUNCIONARIO AUTORIZANTE"),0,1,'C',false,0,0,false,'T','C');
	$pdf->SetFont('helvetica','',7);
	$pdf->ln(15);
	$pdf->Cell(80,5,'Elaboro: '.strtoupper($_SESSION[usuario]),'',0,'L');
	//$this->Cell(40,5,'Total: ',1,0,'C',false,0,0,false,'T','C');
	
	
	// ---------------------------------------------------------
	$pdf->Output('reporterp.pdf', 'I');//Close and output PDF document
?>