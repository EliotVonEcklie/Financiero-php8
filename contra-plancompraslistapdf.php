<?php //V 1000 12/12/16 ?> 
<?php
	require_once("tcpdf/tcpdf_include.php");
	require('comun.inc');
	require('funciones.inc');
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
			$this->Cell(226,15,'REPORTE PLAN ANUAL DE ADQUISICIONES',1,0,'C'); 
			$this->SetFont('helvetica','B',10);
			$this->Line(240, 25, 240, 41);
			$this->SetY(27);
			$this->SetX(242);
			$this->Cell(35,5,'VIGENCIA : '.vigencia_usuarios($_SESSION[cedulausu]),10,0,'L');
			$this->SetY(33);
			$this->SetX(242);
			$this->Cell(35,5,'FECHA: '.date("d/m/Y"),0,0,'L');
			$this->ln(10); 
			$this->SetFillColor(222,222,222);
			$this->SetFont('helvetica','B',10);
			$margeny=$this->GetY();	
			$this->SetY($margeny);
			$this->SetX(10);
			$this->MultiCell(22, 9, 'Código Adquisición', 1, 'C', 1, 0, '', '', true, 0, false, true, 40, 'T');
			$this->MultiCell(18, 9, 'Codigos UNSPSC', 1, 'C', 1, 0, '', '', true, 0, false, true, 40, 'T');
			$this->Cell(67,9,'Descripción',1,0,'C',true,0,1,false,'T','C');
			$this->MultiCell(18, 9, ' Fecha  Estimada', 1, 'C', 1, 0, '', '', true, 0, false, true, 40, 'T');
			$this->MultiCell(18, 9, 'Duración Estimada', 1, 'C', 1, 0, '', '', true, 0, false, true, 40, 'T');
			$this->MultiCell(30, 9, 'Modalidad Selección', 1, 'C', 1, 0, '', '', true, 0, false, true, 40, 'T');
			$this->Cell(30,9,'Fuente',1,0,'C',true,0,1,false,'T','C');
			$this->MultiCell(30, 9, '   Valor    Estimado', 1, 'C', 1, 0, '', '', true, 0, false, true, 40, 'T');
			$this->MultiCell(30, 9, 'Valor Estimado Vigente Actual', 1, 'C', 1, 0, '', '', true, 0, false, true, 40, 'T');
			$this->Cell(15,9,'Estado',1,1,'C',true,1,0,false,'T','C');
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
				$dirweb=utf8_encode(strtoupper($row[2]));
				$coemail=utf8_encode(strtoupper($row[3]));
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
	$pdf->SetMargins(10, 52, 10);
	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
	$pdf->SetAutoPageBreak(TRUE, 15);
	if (@file_exists(dirname(__FILE__).'/lang/spa.php')) 
	{
		require_once(dirname(__FILE__).'/lang/spa.php');
		$pdf->setLanguageArray($l);
	}
	$pdf->AddPage();// add a page
	$linkbd=conectar_bd();
	$sqlr="SELECT * FROM contraplancompras WHERE vigencia='".vigencia_usuarios($_SESSION[cedulausu])."' $crit1 $crit2  ORDER BY length(codplan), codplan";
	$resp = mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($resp)) 
	{
		$comcodigo=str_replace("-"," ",$row[4]);
		$sqlr2="SELECT descripcion_valor FROM dominios  WHERE nombre_dominio='MODALIDAD_SELECCION' AND (valor_final IS NULL or valor_final ='') AND valor_inicial='$row[8]'";
		$row2 =mysql_fetch_row(mysql_query($sqlr2,$linkbd));
		$sqlr3="SELECT nombre FROM (SELECT codigo,nombre FROM pptofutfuentefunc UNION SELECT codigo,nombre FROM pptofutfuentefunc) AS tabla WHERE codigo='$row[9]'";
		$row3 =mysql_fetch_row(mysql_query($sqlr3,$linkbd));
		switch($row[14])
		{
			case 'S':	$estados='Activo';break;
			case 'A':	$estados='Ligado';break;
			case 'N':	$estados='Inactivo';
		}
		$altura=9;
		$altura1=0;
		$altura2=0;
		$altura3=0;
		$altura4=0;
		$alturacl=0;
		$primul=$comcodigo;
		$segmul=utf8_encode(strtoupper($row[5]));
		$termul=utf8_encode(strtoupper($row2[0]));
		$cuamul=utf8_encode(strtoupper($row3[0]));
		$cantidad_lineas1= strlen($primul);
		$cantidad_lineas2= strlen($segmul);
		$cantidad_lineas3= strlen($termul);
		$cantidad_lineas4= strlen($cuamul);
		if($cantidad_lineas1 > 18){$cant_espacios = $cantidad_lineas1/18;$rendondear=round($cant_espacios,2);$altura1=$altura*$rendondear;}
		if($cantidad_lineas2 > 67){$cant_espacios = $cantidad_lineas2/67;$rendondear=round($cant_espacios,2);$altura2=$altura*$rendondear;}
		if($cantidad_lineas3 > 30){$cant_espacios = $cantidad_lineas3/30;$rendondear=round($cant_espacios,2);$altura3=$altura*$rendondear;}
		if($cantidad_lineas4 > 30){$cant_espacios = $cantidad_lineas4/30;$rendondear=round($cant_espacios,2);$altura4=$altura*$rendondear;}
		$alturacl=MAX($altura1,$altura2,$altura3,$altura4);
		if($altura < $alturacl){$altura=$alturacl;}
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('helvetica','I',8);
		$pdf->Cell(22,$altura,"$row[0]",1,0,'C',true,0,1,false,'T','C');
		$pdf->MultiCell(18, $altura, $primul, 1, 'C', 1, 0, '', '', true, 0, false, true, 0, 'T');
		$pdf->MultiCell(67, $altura, $segmul, 1, 'C', 1, 0, '', '', true, 0, false, true, 40, 'T');
		$pdf->Cell(18,$altura,date('d-m-Y',strtotime($row[6])),1,0,'C',true,0,1,false,'T','C');
		$pdf->Cell(18,$altura,"$row[7] meses",1,0,'C',true,0,1,false,'T','C');
		$pdf->MultiCell(30, $altura, $termul, 1, 'C', 1, 0, '', '', true, 0, false, true, 40, 'T');
		$pdf->MultiCell(30, $altura, $cuamul, 1, 'C', 1, 0, '', '', true, 0, false, true, 40, 'T');
		$pdf->Cell(30,$altura,'$'.number_format($row[10],2),1,0,'C',true,0,0,false,'T','C');
		$pdf->Cell(30,$altura,'$'.number_format($row[11],2),1,0,'C',true,0,0,false,'T','C');
		$pdf->Cell(15,$altura,$estados,1,1,'C',true,1,0,false,'T','C');
	}
	
	
	$pdf->Output('Radicacion.pdf', 'I');//Close and output PDF document
	
?> 