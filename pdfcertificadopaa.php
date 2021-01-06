<?php
	error_reporting(0);
	setlocale(LC_ALL,"es_ES");
	require_once("tcpdf/tcpdf_include.php");
	require('comun.inc');
	require('funciones.inc');
	require"conversor.php";
	session_start();
	class MYPDF extends TCPDF 
	{
		public function Header()
		{
			$linkbd=conectar_bd();
			$sqlr="SELECT nit, razonsocial FROM configbasica WHERE estado='S'";
			$resp=mysql_query($sqlr,$linkbd);
			while($row=mysql_fetch_row($resp)){$nit=$row[0];$rs=utf8_encode(strtoupper($row[1]));}
			$this->Image('imagenes/eng.jpg', 25, 10, 25, 25, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);// Logo
			$this->SetFont('helvetica','B',10);
			$this->SetY(10);
			$this->RoundedRect(10, 10, 278, 31, 1,'' );
			$this->Line(62, 10, 62, 41);
			$this->SetY(31);
			$this->Cell(52,5,''.$rs,0,0,'C',false,0,1,false,'T','B'); //Nombre Municipio
			$this->SetFont('helvetica','B',8);
			$this->SetY(35);
			$this->Cell(52,5,''.$nit,0,0,'C',false,0,1,false,'T','C'); //Nit
			$this->SetFont('helvetica','B',14);
			$this->SetY(10);
			$this->SetX(62);
			$this->Cell(226,15,'CERTIFICADO PLAN ANUAL DE ADQUISICIONES',1,0,'C'); 
			$this->SetFont('helvetica','B',10);
			$this->Line(240, 25, 240, 41);
			$this->SetY(27);
			$this->SetX(242);
			$this->Cell(35,5,'VIGENCIA : '.$_POST[vigencia],10,0,'L');
			$this->SetY(33);
			$this->SetX(242);
			$this->Cell(35,5,'FECHA: '.date("d/m/Y"),0,0,'L');
			//$this->ln(15); 
			
		}
		
		public function Footer() 
		{
			$linkbd=conectar_bd();
			$sqlr="SELECT direccion,telefono,web,email,razonsocial FROM configbasica WHERE estado='S'";
			$resp=mysql_query($sqlr,$linkbd);
			$razon="";
			while($row=mysql_fetch_row($resp))
			{
				$direcc=utf8_encode(strtoupper($row[0]));
				$telefonos=$row[1];
				$dirweb=utf8_encode(strtoupper($row[2]));
				$coemail=utf8_encode(strtoupper($row[3]));
				$razon=utf8_encode(strtoupper($row[4]));
			}
			$this->SetY(-15);
			$this->SetFont('helvetica', 'I', 8);
			$this->RoundedRect(10, 195, 278,10, 1,'' );
			$this->Cell(0, 5, "Dirección: $direcc, Telefonos: $telefonos, Email:$dirweb, Pagina Web: $coemail",0, 1, 'C', 0, '', 0, false, 'T', 'M');
			$this->Cell(0, 5, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, 1, 'C', 0, '', 0, false, 'T', 'M');
		}
	}
	$pdf = new MYPDF('L','mm','Letter', true, 'iso-8859-1', false);// create new PDF document
	$pdf->SetDocInfoUnicode (true); 
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('G&CSAS');
	$pdf->SetTitle('Plan Anual de Adquisiciones');
	$pdf->SetSubject('Lista Adquisiciones');
	$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
	$pdf->SetMargins(10, 60, 10);
	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
	$pdf->SetAutoPageBreak(TRUE, 20);
	if (@file_exists(dirname(__FILE__).'/lang/spa.php')) 
	{
		require_once(dirname(__FILE__).'/lang/spa.php');
		$pdf->setLanguageArray($l);
	}
	$pdf->AddPage();// add a page
	$linkbd=conectar_bd();
	$pdf->SetFont('times','B',12);
	$pdf->SetY(47);
	$pdf->MultiCell(280,5,'EL PROFESIONAL UNIVERSITARIO CON FUNCIONES DE ALMACENISTA MUNICIPAL','','C');
	$pdf->Cell(280,12,'HACE CONSTAR:',0,0,'C');
	$pdf->SetY(64);
	$pdf->SetFont('times','',11);
	$pdf->cell(0.1);
	$pdf->MultiCell(280,8,'Que en el Plan Anual de Adquisición Municipal vigencia '.$_POST[vigencia].', se encuentran incluidos los servicios y/o elementos que se detallan a continuación, mencionando sus características.',0,'C',false,1,'','',true,0,false,true,0,'T',false);
	$pdf->SetFillColor(222,222,222);
	$pdf->SetFont('helvetica','B',10);
	$margeny=$pdf->GetY();	
	$pdf->SetY($margeny+11);
	$pdf->SetX(10);
	$pdf->MultiCell(22, 9, 'Item', 1, 'C', 1, 0, '', '', true, 0, false, true, 40, 'T');
	$pdf->MultiCell(30, 9, 'Codigo UNSPSC', 1, 'C', 1, 0, '', '', true, 0, false, true, 40, 'T');
	$pdf->Cell(67,9,'Descripción',1,0,'C',true,0,1,false,'T','C');
	$pdf->MultiCell(30, 9, 'Duración Estimada', 1, 'C', 1, 0, '', '', true, 0, false, true, 40, 'T');
	$pdf->MultiCell(35, 9, 'Modalidad Selección', 1, 'C', 1, 0, '', '', true, 0, false, true, 40, 'T');
	$pdf->MultiCell(30, 9, 'Mes a Contratar', 1, 'C', 1, 0, '', '', true, 0, false, true, 40, 'T');
	$pdf->MultiCell(58, 9, 'Dependencia', 1, 'C', 1, 0, '', '', true, 0, false, true, 40, 'T');
			
	$codigos="";
	$modalidad="";
	$duracion="";
	$solicitante="";
	$fecha="";
	$sqlr="SELECT razonsocial FROM configbasica WHERE estado='S'";
	$resp=mysql_query($sqlr,$linkbd);
	$razon="";
	while($row=mysql_fetch_row($resp))
	{
		$razon=utf8_encode(strtoupper($row[0]));
	}
	$numDias=intval(date("j"));
	$numAno=intval(date("Y"));
	$txtDias=convertir($numDias);	
	$txtAnos=convertir($numAno);
	$sql="SELECT planaccargos.nombrecargo,UPPER(CONCAT(terceros.nombre1,' ',terceros.apellido1)) FROM planaccargos,planestructura_terceros,terceros WHERE terceros.cedulanit = planestructura_terceros.cedulanit AND planaccargos.codcargo = planestructura_terceros.codcargo AND planaccargos.nombrecargo LIKE '%SECRETARIA DE PLANEACION%' AND  terceros.estado='S' ";
	$res=mysql_query($sql,$linkbd);
	$fila=mysql_fetch_row($res);
	$nombrePerson=$fila[1];
	$cargoPerson=$fila[0];
	if($_POST[tipo]=='1')
		$sql="SELECT codigosaprob,codplan FROM contrasolicitudpaa WHERE  codsolicitud='$_POST[codigot]' ";
	else
		$sql="SELECT codigosaprob,codplan FROM contrasolicitudpaa WHERE  codsolicitud='$_POST[solproyec]' ";
	$res=mysql_query($sql,$linkbd);
	$row=mysql_fetch_row($res);
	$arregloplanes=explode("-",$row[1]);
	$codigos=$row[0];
	
	
	$arreglocodigos=explode("-",$codigos);
	$nuevafecha=explode("-",$fecha);
	$margeny=$pdf->GetY();	
	$pdf->SetY($margeny+9);
	for($i=0;$i<count($arreglocodigos);$i++ ){
		$sqlr="SELECT cpc.duracionest,cpc.modalidad,cpc.fechaestinicio FROM contraplancompras AS cpc WHERE cpc.codplan='".$arregloplanes[$i]."' ";
		$resp = mysql_query($sqlr,$linkbd);
		while ($row =mysql_fetch_row($resp)) 
		{
			$modalidad=$row[1];
			$duracion=$row[0];
			$fecha=$row[2];
		}
		$sql="SELECT codsolicitante FROM contrasoladquisiciones WHERE codsolicitud='$_POST[codigot]' ";
		$res=mysql_query($sql,$linkbd);
		$fila=mysql_fetch_row($res);
		$solicitante=$fila[0];
		$sqlr2="SELECT UPPER(descripcion_valor) FROM dominios  WHERE nombre_dominio='MODALIDAD_SELECCION' AND (valor_final IS NULL or valor_final ='') AND valor_inicial='$modalidad'";
		$row2 =mysql_fetch_row(mysql_query($sqlr2,$linkbd));
		$sqlr3="SELECT UPPER(CONCAT(nombre1,' ',nombre2,' ',apellido1,' ',apellido2)) FROM terceros WHERE cedulanit='$solicitante' ";
		$row3 =mysql_fetch_row(mysql_query($sqlr3,$linkbd));
		$sql="SELECT UPPER(nombre) FROM productospaa WHERE codigo='$arreglocodigos[$i]' AND estado='S' ";
		$rowp=mysql_fetch_row(mysql_query($sql,$linkbd));
		$altura=9;
		$tiempodiv=explode("/",$duracion);
		$numero = cal_days_in_month(CAL_GREGORIAN, date("n"), date("Y"));
		$dias=intval($tiempodiv[0])+intval($tiempodiv[1])*$numero;

		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('helvetica','I',8);
		$pdf->Cell(22,$altura,($i+1),1,0,'C',true,0,1,false,'T','C');
		$pdf->Cell(30,$altura,$arreglocodigos[$i],1,0,'C',true,0,1,false,'T','C');
		$pdf->MultiCell(67, $altura, utf8_encode($rowp[0]), 1, 'C', 1, 0, '', '', true, 0, false, true, 0, 'T');
		$pdf->MultiCell(30, $altura, $dias.' DIAS', 1, 'C', 1, 0, '', '', true, 0, false, true, 40, 'T');
		$pdf->Cell(35,$altura,utf8_encode($row2[0]),1,0,'C',true,0,1,false,'T','C');
		$pdf->MultiCell(30, $altura, obtenerMes($nuevafecha[1]), 1, 'C', 1, 0, '', '', true, 0, false, true, 40, 'T');
		$pdf->MultiCell(58, $altura, utf8_encode("SECRETARIA DE PLANEACION E INFRAESTRUCTURA"), 1, 'C', 1, 0, '', '', true, 0, false, true, 40, 'T');
		$pdf->ln($altura);
	}
	$pdf->ln(7);
	$y=$pdf->GetY();
	$pdf->SetFont('helvetica', 'I', 8);
	$pdf->RoundedRect(10, $y, 275,10, 1,'' );
	$pdf->Cell(0, 5, "En constancia de lo anterior, se firma en el $razon, a los $txtDias ($numDias) dias del mes de ".obtenerMes(date("n"))." de $txtAnos ($numAno) ",0, 1, 'C', 0, '', 0, false, 'T', 'M');
	
	$pdf->ln(30);
	$v=$pdf->gety();
	$pdf->setFont('times','B',10);
	$pdf->Line(90,$v,200,$v);
	$pdf->Cell(40);
	$pdf->Cell(190,6,''.utf8_encode("FUNCIONARIO AUTORIZANTE"),0,1,'C',false,0,0,false,'T','C');
	$pdf->Cell(40);
	$pdf->Cell(190,6,utf8_encode($cargoPerson),0,0,'C',false,0,0,false,'T','C');		
	function obtenerMes($mes){
		switch($mes){
			case "01":
				return "ENERO";
				break;
			case "02":
				return "FEBRERO";
				break;
			case "03":
				return "MARZO";
				break;
			case "04":
				return "ABRIL";
				break;
			case "05":
				return "MAYO";
				break;
			case "06":
				return "JUNIO";
				break;
			case "07":
				return "JULIO";
				break;
			case "08":
				return "AGOSTO";
				break;
			case "09":
				return "SEPTIEMBRE";
				break;
			case "10":
				return "OCTUBRE";
				break;
			case "11":
				return "NOVIEMBRE";
				break;
			case "11":
				return "DICIEMBRE";
				break;
		}
	}
	$pdf->Output('Radicacion.pdf', 'I');//Close and output PDF document
	
?> 