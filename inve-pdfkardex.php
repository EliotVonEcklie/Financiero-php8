<?php
//V 1000 12/12/16 
	ini_set('max_execution_time',3600);
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
			while($row=mysql_fetch_row($resp)){$nit=$row[0];$rs=utf8_encode(strtoupper($row[1]));}
			$this->Image('imagenes/eng.jpg', 25, 10, 25, 23.9, 'JPG', '', 'T', true, 300, '', false, false, 0, false, false, false);// Logo
			$this->SetFont('helvetica','B',8);
			$this->SetY(10);
			$this->RoundedRect(10, 10, 280, 31, 2.5,''); //Borde del encabezado
			$this->Cell(52,31,'','R',0,'L'); //Linea que separa el encabazado verticalmente
			$this->SetY(32.5);
			$this->Cell(52,5,''.$rs,0,0,'C',false,0,1,false,'T','B'); //Nombre Municipio
			$this->SetFont('helvetica','B',8);
			$this->SetY(36.5);
			$this->Cell(52,5,''.$nit,0,0,'C',false,0,1,false,'T','C'); //Nit
			$this->SetFont('helvetica','B',14);
			$this->SetY(10);
			$this->SetX(62);
			$this->Cell(190,17,'KARDEX ALMACEN',0,0,'C'); 
			$this->SetFont('helvetica','I',10);
			if ($_POST[bodega]!="-1"){$bodegas=$_POST[nbodegas];}
			else {$bodegas="Todas";}
			if ($_POST[narticulo]!=""){$articulos=$_POST[narticulo];}
			else {$articulos="Todos";}
			$this->SetY(27);
			$this->SetX(62);
			$this->Cell(190,7," Fecha Inicial: ".date('d-m-Y',strtotime($_POST[fechain]))."   Bodega: $bodegas",'T',0,'L',false,0,1); 
			$this->SetY(34);
			$this->SetX(62);
			$this->Cell(190,7," Fecha Final: ".date('d-m-Y',strtotime($_POST[fechafi]))."   Artículo: $articulos 	",0,0,'L',false,0,1); 
			$this->SetFont('helvetica','B',9);
			$this->SetY(10);
			$this->SetX(252);
			$this->Cell(37.8,30.7,'','L',0,'L');
			$this->SetY(29);
			$this->SetX(252.5);
			$this->Cell(35,5," FECHA: ".date("d-m-Y"),0,0,'L');
			$this->SetY(34);
			$this->SetX(252.5);
			$this->Cell(35,5," HORA: ".date('h:i:s a'),0,0,'L');
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
			$this->SetY(-16);
			$this->SetFont('helvetica', 'BI', 8);
			$txt = <<<EOD
Dirección: $direcc, Telefonos: $telefonos
Email:$dirweb, Pagina Web: $coemail
EOD;
			$this->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);
			$this->SetY(-13);
			$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
			$this->Line(10, 190, 288, 190,$styleline);
		}
	}
	$pdf = new MYPDF('L','mm','Letter', true, 'iso-8859-1', false);// create new PDF document
	$pdf->SetDocInfoUnicode (true); 
	// set document information
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('G&CSAS');
	$pdf->SetTitle('Reporte Kardex');
	$pdf->SetSubject('Kardex Almacen');
	$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
	$pdf->SetMargins(10, 44, 10);// set margins
	$pdf->SetHeaderMargin(44);// set margins
	$pdf->SetFooterMargin(20);// set margins
	$pdf->SetAutoPageBreak(TRUE, 20);// set auto page breaks
	// set some language-dependent strings (optional)
	if (@file_exists(dirname(__FILE__).'/lang/spa.php')) 
	{
		require_once(dirname(__FILE__).'/lang/spa.php');
		$pdf->setLanguageArray($l);
	}
	// ---------------------------------------------------------
	$pdf->AddPage();
	$linkbd=conectar_bd();
	$crit1="";
	$crit2="";
	$fecha1=explode("-",date('d-m-Y',strtotime($_POST[fechain])));
	$fecha2=explode("-",date('d-m-Y',strtotime($_POST[fechafi])));
	$fecha1g=gregoriantojd($fecha1[1],$fecha1[0],$fecha1[2]);
	$fecha2g=gregoriantojd($fecha2[1],$fecha2[0],$fecha2[2]);
	if($_POST[narticulo]!=""){$crit1="AND CONCAT(almarticulos.grupoinven,almarticulos.codigo) = '$_POST[articulo]'";}
	if($_POST[bodega]!="-1")
	{
		if($_POST[narticulo]!=""){$crit2="AND almginventario_det.bodega = '$_POST[bodega]'";}
		else {$crit2="AND almginventario_det.bodega = '$_POST[bodega]'";}
	}
	$sqlr="SELECT almarticulos.grupoinven, almarticulos.codigo, almarticulos.nombre FROM almarticulos INNER JOIN (almginventario_det INNER JOIN almginventario ON CONCAT(almginventario_det.codigo,almginventario_det.tipomov)=CONCAT(almginventario.consec,almginventario.tipomov)) ON CONCAT(almarticulos.grupoinven,almarticulos.codigo)=almginventario_det.codart $crit1 $crit2  GROUP BY almarticulos.grupoinven, almarticulos.codigo, almarticulos.nombre ORDER BY grupoinven ASC, codigo ASC";
	$resp = mysql_query($sqlr,$linkbd);
	while($row =mysql_fetch_row($resp))
	{
		$posy=$pdf->GetY();
		if($posy<164)
		{
			$pdf->SetFillColor(100,0,0,10,false,'');
			$pdf->SetFont('helvetica','BI',9);
			$pdf->Cell(44.8,5,"Articulo:".utf8_encode(ucwords(strtolower($row[2]))),1,0,'L',true,'',1,false,'T','C');
			$pdf->Cell(78.4,10,"Entradas",1,0,'C',true,'',0,false,'T','C');
			$pdf->Cell(78.4,10,"Salidas",1,0,'C',true,'',0,false,'T','C');
			$pdf->Cell(78.4,10,"Saldo",1,1,'C',true,'',0,false,'T','C');
			$posy=$pdf->GetY();
			$pdf->SetY($posy-5);
			$pdf->Cell(44.8,5,"Código:$row[0]$row[1]",1,1,'L',true,'',1,false,'T','C');
			$pdf->SetFillColor(50,0,0,0,false,'');
			$pdf->SetFont('helvetica','BI',8);
			$pdf->Cell(16.8,10,"Fecha:",1,0,'C',true,'',0,false,'T','C');
			$pdf->MultiCell(14,10,"Doc. Soporte",1,'C',true,0,'','',true,0,false,true,10,'T',false);
			$pdf->Cell(14,10,"Movimiento",1,0,'C',true,'',1,false,'T','C');
			$pdf->Cell(15.4,10,"Cantidad",1,0,'C',true,'',0,false,'T','C');
			$pdf->MultiCell(14,10,"Unidad de Medida",1,'C',true,0,'','',true,0,false,true,10,'T',false);
			$pdf->Cell(22.4,10,"Valor Unitario",1,0,'C',true,'',1,false,'T','C');
			$pdf->Cell(26.5,10,"Costo Total",1,0,'C',true,'',0,false,'T','C');
			$pdf->Cell(15.4,10,"Cantidad",1,0,'C',true,'',0,false,'T','C');
			$pdf->MultiCell(14,10,"Unidad de Medida",1,'C',true,0,'','',true,0,false,true,19,'T',false);
			$pdf->Cell(22.4,10,"Valor Unitario",1,0,'C',true,'',0,false,'T','C');
			$pdf->Cell(26.6,10,"Costo Total",1,0,'C',true,'',0,false,'T','C');
			$pdf->Cell(15.4,10,"Cantidad",1,0,'C',true,'',0,false,'T','C');
			$pdf->MultiCell(14,10,"Unidad de Medida",1,'C',true,0,'','',true,0,false,true,10,'T',false);
			$pdf->Cell(22.4,10,"Valor Unitario",1,0,'C',true,'',0,false,'T','C');
			$pdf->Cell(26.6,10,"Costo Total",1,1,'C',true,'',0,false,'T','C');
			
			$sqld="SELECT almginventario.fecha, almginventario.consec, almginventario.nombre, almginventario.tipomov, almginventario.tiporeg, almginventario_det.cantidad_entrada, almginventario_det.unidad, almginventario_det.codart, almginventario.tipomov,almginventario_det.cantidad_salida FROM almginventario INNER JOIN almginventario_det ON CONCAT(almginventario.consec,almginventario.tipomov,almginventario.tiporeg)=CONCAT(almginventario_det.codigo,almginventario_det.tipomov,almginventario_det.tiporeg) $crit2 and almginventario_det.codart='$row[0]$row[1]' ORDER BY almginventario.codigo";	
			$rkar=mysql_query($sqld,$linkbd);
			$sumarent=0;
			$sumarsal=0;
			$canbod=0;
			$cansal=0;
			$pdf->SetFillColor(0,0,0,0,false,'');
			while($wkar=mysql_fetch_array($rkar))
			{	
				$sqls="SELECT SUM(almginventario_det.cantidad_entrada) FROM almginventario INNER JOIN almginventario_det ON CONCAT(almginventario.consec,almginventario.tipomov)=CONCAT(almginventario_det.codigo,almginventario_det.tipomov) $crit2 and almginventario_det.codart=$wkar[7] AND almginventario.tipomov='1'";	
				$ress=mysql_query($sqls,$linkbd);
				$went=mysql_fetch_array($ress);
				$sqls="SELECT SUM(almginventario_det.cantidad_salida) FROM almginventario INNER JOIN almginventario_det ON CONCAT(almginventario.consec,almginventario.tipomov)=CONCAT(almginventario_det.codigo,almginventario_det.tipomov) $crit2 and almginventario_det.codart=$wkar[7] AND almginventario.tipomov='2'";	
				$ress=mysql_query($sqls,$linkbd);
				$wsal=mysql_fetch_array($ress);
				$sqls="SELECT SUM(almginventario_det.cantidad_salida) FROM almginventario INNER JOIN almginventario_det ON CONCAT(almginventario.consec,almginventario.tipomov)=CONCAT(almginventario_det.codigo,almginventario_det.tipomov) $crit2 and almginventario_det.codart=$wkar[7] AND almginventario.tipomov='3'";	
				$ress=mysql_query($sqls,$linkbd);
				$wrent=mysql_fetch_array($ress);
				$sqls="SELECT SUM(almginventario_det.cantidad_entrada) FROM almginventario INNER JOIN almginventario_det ON CONCAT(almginventario.consec,almginventario.tipomov)=CONCAT(almginventario_det.codigo,almginventario_det.tipomov) $crit2 and almginventario_det.codart=$wkar[7] AND almginventario.tipomov='4'";	
				$ress=mysql_query($sqls,$linkbd);
				$wrsal=mysql_fetch_array($ress);
				if($went[0]=="")$went[0]=0;
				if($wsal[0]=="")$wsal[0]=0;
				if($wrent[0]=="")$wrent[0]=0;
				if($wrsal[0]=="")$wrsal[0]=0;
				//$saldos=$went[0]+$wrsal[0]-($wsal[0]+$wrent[0]);
				$sqlp="SELECT SUM(almginventario_det.valortotal), SUM(almginventario_det.cantidad_entrada) FROM almginventario INNER JOIN almginventario_det ON CONCAT(almginventario.consec,almginventario.tipomov)=CONCAT(almginventario_det.codigo,almginventario_det.tipomov) WHERE almginventario_det.codart='$wkar[7]' AND almginventario.tipomov='1'";	
				$rpre=mysql_query($sqlp,$linkbd);
				$wpre=mysql_fetch_array($rpre);
				//echo"$sqlp";
				$promedio=$wpre[0]/$wpre[1];
				$fecha3=explode("-",date('d-m-Y',strtotime($wkar[0])));
				$fecha3g=gregoriantojd($fecha3[0],$fecha3[1],$fecha3[2]);
				//echo $fecha3[0]."<br>";
				if($wkar[8]=='1')
				{//echo "hola $fecha1g <= $fecha3g $fecha2g";
					$subtotala=$wkar[5]*$promedio;
					$sumarent+=$subtotala;
					$saldos+=$wkar[5];
					$subtotalb=$saldos*$promedio;
						$sqlrtmv="SELECT nombre FROM almtipomov WHERE concat_ws('', tipom,codigo)='$wkar[3]$wkar[4]'";
						$rowtmv =mysql_fetch_row(mysql_query($sqlrtmv,$linkbd));
						$sqlrtmv="SELECT nombre FROM almtipomov WHERE concat_ws('', tipom,codigo)='$wkar[3]$wkar[4]'";
						$rowtmv =mysql_fetch_row(mysql_query($sqlrtmv,$linkbd));
						$pdf->Cell(16.8,10,date('d-m-Y',strtotime($wkar[0])),1,0,'C',true,0,0,false,'T','C');
						$pdf->Cell(14,10,$wkar[1],1,0,'C',true,0,0,false,'T','C');
						$pdf->Cell(14,10,"$wkar[3]$wkar[4]",1,0,'C',true,0,0,false,'T','C');
						$pdf->Cell(15.4,10,$wkar[5],1,0,'C',true,0,0,false,'T','C');
						$pdf->Cell(14,10,$wkar[6],1,0,'C',true,0,0,false,'T','C');
						$pdf->Cell(22.4,10,"$".number_format($promedio,2,',','.'),1,0,'R',true,0,0,false,'T','C');
						$pdf->Cell(26.5,10,"$".number_format($subtotala,2,',','.'),1,0,'R',true,0,0,false,'T','C');
						$pdf->Cell(15.4,10,"",1,0,'C',true,0,0,false,'T','C');
						$pdf->Cell(14,10,"",1,0,'C',true,0,0,false,'T','C');
						$pdf->Cell(22.4,10,"",1,0,'C',true,0,0,false,'T','C');
						$pdf->Cell(26.6,10,"",1,0,'C',true,0,0,false,'T','C');
						$pdf->Cell(15.4,10,$saldos,1,0,'C',true,0,0,false,'T','C');
						$pdf->Cell(14,10,$wkar[6],1,0,'C',true,0,0,false,'T','C');
						$pdf->Cell(22.4,10,"$".number_format($promedio,2,',','.'),1,0,'R',true,0,0,false,'T','C');
						$pdf->Cell(26.6,10,"$".number_format($subtotalb,2,',','.'),1,1,'R',true,0,0,false,'T','C');
					
				}
				elseif($wkar[8]=='2')
				{
					$subtotala=$wkar[9]*$promedio;
					$sumarsal+=$subtotala;
					$saldos-=$wkar[9];
					$subtotalb=$saldos*$promedio;
						$sqlrtmv="SELECT nombre FROM almtipomov WHERE concat_ws('', tipom,codigo)='$wkar[3]$wkar[4]'";
						$rowtmv =mysql_fetch_row(mysql_query($sqlrtmv,$linkbd));
						$pdf->Cell(16.8,10,''.date('d-m-Y',strtotime($wkar[0])),1,0,'C',true,0,0,false,'T','C');
						$pdf->Cell(14,10,$wkar[1],1,0,'C',true,0,0,false,'T','C');
						$pdf->Cell(14,10,"$wkar[3]$wkar[4]",1,0,'C',true,0,0,false,'T','C');
						$pdf->Cell(15.4,10,"",1,0,'C',true,0,0,false,'T','C');
						$pdf->Cell(14,10,"",1,0,'C',true,0,0,false,'T','C');
						$pdf->Cell(22.4,10,"",1,0,'C',true,0,0,false,'T','C');
						$pdf->Cell(26.5,10,"",1,0,'C',true,0,0,false,'T','C');
						$pdf->Cell(15.4,10,"$wkar[9]",1,0,'C',true,0,0,false,'T','C');
						$pdf->Cell(14,10,"$wkar[6]",1,0,'C',true,0,0,false,'T','C');
						$pdf->Cell(22.4,10,"$".number_format($promedio,2,',','.'),1,0,'R',true,0,0,false,'T','C');
						$pdf->Cell(26.6,10,"$".number_format($subtotala,2,',','.'),1,0,'R',true,0,0,false,'T','C');
						$pdf->Cell(15.4,10,$saldos,1,0,'C',true,0,0,false,'T','C');
						$pdf->Cell(14,10,$wkar[6],1,0,'C',true,0,0,false,'T','C');
						$pdf->Cell(22.4,10,"$".number_format($promedio,2,',','.'),1,0,'R',true,0,0,false,'T','C');
						$pdf->Cell(26.6,10,"$".number_format($subtotalb,2,',','.'),1,1,'R',true,0,0,false,'T','C');
					
				}
				$canbod=$saldos;$cansal=$saldos*$promedio;
				$aux=$iter1;
				$iter1=$iter2;
				$iter2=$aux;
			}
			$pdf->Cell(175,10,"Cantidad en Bodega:","LBT",0,'R',true,0,0,false,'T','C');
			$pdf->Cell(26.6,10,$canbod,'RBT',0,'L',true,0,0,false,'T','C');
			$pdf->Cell(15.4,10,"Valor:",'TB',0,'R',true,0,0,false,'T','C');
			$pdf->Cell(63,10,"$".number_format($cansal,2,',','.'),'TRB',1,'L',true,0,0,false,'T','C');
			$pdf->ln(2);
		}
		else {$pdf->AddPage();
			$pdf->SetFillColor(100,0,0,10,false,'');
			$pdf->SetFont('helvetica','BI',9);
			$pdf->Cell(44.8,5,"Articulo:".utf8_encode(ucwords(strtolower($row[2]))),1,0,'L',true,'',1,false,'T','C');
			$pdf->Cell(78.4,10,"Entradas",1,0,'C',true,'',0,false,'T','C');
			$pdf->Cell(78.4,10,"Salidas",1,0,'C',true,'',0,false,'T','C');
			$pdf->Cell(78.4,10,"Saldo",1,1,'C',true,'',0,false,'T','C');
			$posy=$pdf->GetY();
			$pdf->SetY($posy-5);
			$pdf->Cell(44.8,5,"Código:$row[0]$row[1]",1,1,'L',true,'',1,false,'T','C');
			$pdf->SetFillColor(50,0,0,0,false,'');
			$pdf->SetFont('helvetica','BI',8);
			$pdf->Cell(16.8,10,"Fecha:",1,0,'C',true,'',0,false,'T','C');
			$pdf->MultiCell(14,10,"Doc. Soporte",1,'C',true,0,'','',true,0,false,true,10,'T',false);
			$pdf->Cell(14,10,"Movimiento",1,0,'C',true,'',1,false,'T','C');
			$pdf->Cell(15.4,10,"Cantidad",1,0,'C',true,'',0,false,'T','C');
			$pdf->MultiCell(14,10,"Unidad de Medida",1,'C',true,0,'','',true,0,false,true,10,'T',false);
			$pdf->Cell(22.4,10,"Valor Unitario",1,0,'C',true,'',1,false,'T','C');
			$pdf->Cell(26.5,10,"Costo Total",1,0,'C',true,'',0,false,'T','C');
			$pdf->Cell(15.4,10,"Cantidad",1,0,'C',true,'',0,false,'T','C');
			$pdf->MultiCell(14,10,"Unidad de Medida",1,'C',true,0,'','',true,0,false,true,19,'T',false);
			$pdf->Cell(22.4,10,"Valor Unitario",1,0,'C',true,'',0,false,'T','C');
			$pdf->Cell(26.6,10,"Costo Total",1,0,'C',true,'',0,false,'T','C');
			$pdf->Cell(15.4,10,"Cantidad",1,0,'C',true,'',0,false,'T','C');
			$pdf->MultiCell(14,10,"Unidad de Medida",1,'C',true,0,'','',true,0,false,true,10,'T',false);
			$pdf->Cell(22.4,10,"Valor Unitario",1,0,'C',true,'',0,false,'T','C');
			$pdf->Cell(26.6,10,"Costo Total",1,1,'C',true,'',0,false,'T','C');
			$sqls="SELECT SUM(almginventario_det.cantidad_salida) FROM almginventario INNER JOIN almginventario_det ON CONCAT(almginventario.consec,almginventario.tipomov)=CONCAT(almginventario_det.codigo,almginventario_det.tipomov) $crit2 and almginventario_det.codart=$wkar[7] AND almginventario.fecha<'$_POST[fechain]' AND almginventario.tipomov='1'";	
			$ress=mysql_query($sqls,$linkbd);
			$went=mysql_fetch_array($ress);
			$sqls="SELECT SUM(almginventario_det.cantidad_salida) FROM almginventario INNER JOIN almginventario_det ON CONCAT(almginventario.consec,almginventario.tipomov)=CONCAT(almginventario_det.codigo,almginventario_det.tipomov) $crit2 and almginventario_det.codart=$wkar[7] AND almginventario.fecha<'$_POST[fechain]' AND almginventario.tipomov='2'";	
			$ress=mysql_query($sqls,$linkbd);
			$wsal=mysql_fetch_array($ress);
			$sqls="SELECT SUM(almginventario_det.cantidad_salida) FROM almginventario INNER JOIN almginventario_det ON CONCAT(almginventario.consec,almginventario.tipomov)=CONCAT(almginventario_det.codigo,almginventario_det.tipomov) $crit2 and almginventario_det.codart=$wkar[7] AND almginventario.fecha<'$_POST[fechain]' AND almginventario.tipomov='3'";	
			$ress=mysql_query($sqls,$linkbd);
			$wrent=mysql_fetch_array($ress);
			$sqls="SELECT SUM(almginventario_det.cantidad_salida) FROM almginventario INNER JOIN almginventario_det ON CONCAT(almginventario.consec,almginventario.tipomov)=CONCAT(almginventario_det.codigo,almginventario_det.tipomov) $crit2 and almginventario_det.codart=$wkar[7] AND almginventario.fecha<'$_POST[fechain]' AND almginventario.tipomov='4'";	
			$ress=mysql_query($sqls,$linkbd);
			$wrsal=mysql_fetch_array($ress);
			if($went[0]=="")$went[0]=0;
			if($wsal[0]=="")$wsal[0]=0;
			if($wrent[0]=="")$wrent[0]=0;
			if($wrsal[0]=="")$wrsal[0]=0;
			$saldos=$went[0]+$wrsal[0]-($wsal[0]+$wrent[0]);
			$sqld="SELECT almginventario.fecha, almginventario.consec, almginventario.nombre, almginventario.tipomov, almginventario.tiporeg, almginventario_det.cantidad_salida, almginventario_det.unidad, almginventario_det.codart, almginventario.tipomov FROM almginventario INNER JOIN almginventario_det ON CONCAT(almginventario.consec,almginventario.tipomov,almginventario.tiporeg)=CONCAT(almginventario_det.codigo,almginventario_det.tipomov,almginventario_det.tiporeg) $crit2 and almginventario_det.codart=$row[0]$row[1] ORDER BY almginventario.codigo";		
			$rkar=mysql_query($sqld,$linkbd);
			$sumarent=0;
			$sumarsal=0;
			$canbod=0;
			$cansal=0;
			$pdf->SetFillColor(0,0,0,0,false,'');
			while($wkar=mysql_fetch_array($rkar))
			{	
				$sqlp="SELECT SUM(almginventario_det.valortotal), SUM(almginventario_det.cantidad_salida) FROM almginventario INNER JOIN almginventario_det ON CONCAT(almginventario.consec,almginventario.tipomov)=CONCAT(almginventario_det.codigo,almginventario_det.tipomov) WHERE almginventario_det.codart='$wkar[7]' AND almginventario.tipomov='1'";	
				$rpre=mysql_query($sqlp,$linkbd);
				$wpre=mysql_fetch_array($rpre);
				//echo"$sqlp";
				$promedio=$wpre[0]/$wpre[1];
				$fecha3=explode("-",date('d-m-Y',strtotime($wkar[0])));
				$fecha3g=gregoriantojd($fecha3[1],$fecha3[0],$fecha3[2]);
				if($wkar[8]=='1')
				{
					$subtotala=$wkar[5]*$promedio;
					$sumarent+=$subtotala;
					$saldos+=$wkar[5];
					$subtotalb=$saldos*$promedio;
					if(($fecha1g <= $fecha3g) && ($fecha3g <= $fecha2g))
					{
						$sqlrtmv="SELECT nombre FROM almtipomov WHERE concat_ws('', tipom,codigo)='$wkar[3]$wkar[4]'";
						$rowtmv =mysql_fetch_row(mysql_query($sqlrtmv,$linkbd));
						$sqlrtmv="SELECT nombre FROM almtipomov WHERE concat_ws('', tipom,codigo)='$wkar[3]$wkar[4]'";
						$rowtmv =mysql_fetch_row(mysql_query($sqlrtmv,$linkbd));
						$pdf->Cell(16.8,10,date('d-m-Y',strtotime($wkar[0])),1,0,'C',true,0,0,false,'T','C');
						$pdf->Cell(14,10,$wkar[1],1,0,'C',true,0,0,false,'T','C');
						$pdf->Cell(14,10,"$wkar[3]$wkar[4]",1,0,'C',true,0,0,false,'T','C');
						$pdf->Cell(15.4,10,$wkar[5],1,0,'C',true,0,0,false,'T','C');
						$pdf->Cell(14,10,$wkar[6],1,0,'C',true,0,0,false,'T','C');
						$pdf->Cell(22.4,10,"$".number_format($promedio,2,',','.'),1,0,'R',true,0,0,false,'T','C');
						$pdf->Cell(26.5,10,"$".number_format($subtotala,2,',','.'),1,0,'R',true,0,0,false,'T','C');
						$pdf->Cell(15.4,10,"",1,0,'C',true,0,0,false,'T','C');
						$pdf->Cell(14,10,"",1,0,'C',true,0,0,false,'T','C');
						$pdf->Cell(22.4,10,"",1,0,'C',true,0,0,false,'T','C');
						$pdf->Cell(26.6,10,"",1,0,'C',true,0,0,false,'T','C');
						$pdf->Cell(15.4,10,$saldos,1,0,'C',true,0,0,false,'T','C');
						$pdf->Cell(14,10,$wkar[6],1,0,'C',true,0,0,false,'T','C');
						$pdf->Cell(22.4,10,"$".number_format($promedio,2,',','.'),1,0,'R',true,0,0,false,'T','C');
						$pdf->Cell(26.6,10,"$".number_format($subtotalb,2,',','.'),1,1,'R',true,0,0,false,'T','C');
					}
				}
				elseif($wkar[8]=='2')
				{
					$subtotala=$wkar[5]*$promedio;
					$sumarsal+=$subtotala;
					$saldos-=$wkar[5];
					$subtotalb=$saldos*$promedio;
					if(($fecha1g <= $fecha3g)&&($fecha3g <= $fecha2g))
					{
						$sqlrtmv="SELECT nombre FROM almtipomov WHERE concat_ws('', tipom,codigo)='$wkar[3]$wkar[4]'";
						$rowtmv =mysql_fetch_row(mysql_query($sqlrtmv,$linkbd));
						$pdf->Cell(16.8,10,''.date('d-m-Y',strtotime($wkar[0])),1,0,'C',true,0,0,false,'T','C');
						$pdf->Cell(14,10,$wkar[1],1,0,'C',true,0,0,false,'T','C');
						$pdf->Cell(14,10,"$wkar[3]$wkar[4]",1,0,'C',true,0,0,false,'T','C');
						$pdf->Cell(15.4,10,"",1,0,'C',true,0,0,false,'T','C');
						$pdf->Cell(14,10,"",1,0,'C',true,0,0,false,'T','C');
						$pdf->Cell(22.4,10,"",1,0,'C',true,0,0,false,'T','C');
						$pdf->Cell(26.5,10,"",1,0,'C',true,0,0,false,'T','C');
						$pdf->Cell(15.4,10,"$wkar[5]",1,0,'C',true,0,0,false,'T','C');
						$pdf->Cell(14,10,"$wkar[6]",1,0,'C',true,0,0,false,'T','C');
						$pdf->Cell(22.4,10,"$".number_format($promedio,2,',','.'),1,0,'R',true,0,0,false,'T','C');
						$pdf->Cell(26.6,10,"$".number_format($subtotala,2,',','.'),1,0,'R',true,0,0,false,'T','C');
						$pdf->Cell(15.4,10,$saldos,1,0,'C',true,0,0,false,'T','C');
						$pdf->Cell(14,10,$wkar[6],1,0,'C',true,0,0,false,'T','C');
						$pdf->Cell(22.4,10,"$".number_format($promedio,2,',','.'),1,0,'R',true,0,0,false,'T','C');
						$pdf->Cell(26.6,10,"$".number_format($subtotalb,2,',','.'),1,1,'R',true,0,0,false,'T','C');
					}
				}
				if($fecha3g <= $fecha2g){$canbod=$saldos;$cansal=$saldos*$promedio;}
				$aux=$iter1;
				$iter1=$iter2;
				$iter2=$aux;
			}
			$pdf->Cell(175,10,"Cantidad en Bodega:","LBT",0,'R',true,0,0,false,'T','C');
			$pdf->Cell(26.6,10,$canbod,'RBT',0,'L',true,0,0,false,'T','C');
			$pdf->Cell(15.4,10,"Valor:",'TB',0,'R',true,0,0,false,'T','C');
			$pdf->Cell(63,10,"$".number_format($cansal,2,',','.'),'TRB',1,'L',true,0,0,false,'T','C');
			$pdf->ln(2);
		}
	}
	$pdf->Output('ReporteKardex.pdf', 'I');//Close and output PDF document
?>