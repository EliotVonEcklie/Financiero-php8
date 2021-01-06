<?php
//V 1000 12/12/16 
	require_once("tcpdf/tcpdf_include.php");
	require('comun.inc');
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();
	$vigusu=vigencia_usuarios($_SESSION[cedulausu]);

	class MYPDF extends TCPDF 
	{
		public function Header() 
		{
			$linkbd=conectar_bd();
			$sqlr="SELECT nit, razonsocial FROM configbasica WHERE estado='S'";
			$resp=mysql_query($sqlr,$linkbd);
			while($row=mysql_fetch_row($resp)){$nit=$row[0];$rs=utf8_encode(strtoupper($row[1]));}
			if($_POST[nomdep]!='')
			{
				if($_POST[nompro]!=''){$titulo1="Listado: ".utf8_encode($_POST[nomdep]).", Proceso: ".utf8_encode($_POST[nompro]);}
				else {$titulo1="Listado: ".utf8_encode($_POST[nomdep]);}
			}
			else
			{
				if($_POST[nompro]!=''){$titulo1="Listado Proceso: ".utf8_encode($_POST[nompro]);}
				else {$titulo1="Listado General";}
			}	
			if($_POST[nomtiporadica]!=""){$nomtipro=utf8_encode($_POST[nomtiporadica]);}
			else{$nomtipro="Todas";}
			$cuotas="";
			if(isset($_POST[tipo])){
				if($_POST[tipo]=="1"){
					$sql="SELECT cuotas,cuota_pagada FROM tesoacuerdopredial WHERE idacuerdo=$_POST[idrecaudo]";
					$res=mysql_query($sql,$linkbd);
					$fila=mysql_fetch_row($res);
					
					$cuotas="Cuota No. ".$fila[1].' de '.$fila[0];
				}
			}
			$this->Image('imagenes/eng.jpg', 25, 10, 25, 23.9, 'JPG', '', 'T', true, 300, '', false, false, 0, false, false, false);// Logo
			$this->SetFont('helvetica','B',8);
			$this->SetY(10);
			$this->RoundedRect(10, 10, 195, 31, 2.5,'1111'); //Borde del encabezado
			$this->Cell(52,31,'','R',0,'L'); //Linea que separa el encabazado verticalmente
			$this->SetY(32.5);
			$this->Cell(52,5,''.$rs,0,0,'C',false,0,1,false,'T','B'); //Nombre Municipio
			$this->SetFont('helvetica','B',8);
			$this->SetY(36.5);
			$this->Cell(52,5,''.$nit,0,0,'C',false,0,1,false,'T','C'); //Nit
			$this->SetFont('helvetica','B',14);
			$this->SetY(10);
			$this->SetX(62);
			$this->Cell(107,12,'RECIBO RECAUDOS TRANSFERENCIAS',0,0,'C'); 
			$this->SetFont('helvetica','I',9);
			$this->SetY(22);
			$this->SetX(62);
			$this->MultiCell(107,14,"CONCEPTO: ".utf8_encode($_POST[concepto]),'T','L',false,0,'','',true,1,false,true,14,'T',false);
			$this->SetFont('helvetica','B',9);
			$this->SetY(36);
			$this->SetX(62);
			
			$this->SetY(10);
			$this->SetX(169);
			$this->Cell(37.8,30.7,'','L',0,'L');
			$this->SetY(29);
			$this->SetX(169.5);
			$this->Cell(35,5," NUMERO: $_POST[idcomp] ",0,0,'L');
			$this->SetY(34);
			$this->SetX(169.5);
			$this->Cell(35,5," FECHA: ".$_POST[fecha],0,0,'L');
			//-----------------------------------------------------
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
			$this->Line(10, 280, 203, 280,$styleline);
		}
	}
	$pdf = new MYPDF('P','mm','Letter', true, 'iso-8859-1', false);// create new PDF document
	$pdf->SetDocInfoUnicode (true); 
	// set document information
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('G&CSAS');
	$pdf->SetTitle('Modulo Tesoreria');
	$pdf->SetSubject('Recibo de Caja');
	$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
	$pdf->SetMargins(10, 42, 10);// set margins
	$pdf->SetHeaderMargin(42);// set margins
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
	
	$pdf->SetFont('helvetica','B',12);
	$pdf->SetX(138);
	$pdf->Cell(19,8,'VALOR:',0,0,'L',false,'',0,false,'T','C');
	$pdf->Cell(48,8,'$'.$_POST[totalcf],0,1,'R',false,'',0,false,'T','C');
	$pdf->RoundedRect(157, 42 ,48 , 8, 2,'1111');

	$pdf->ln(1.5);	
	$pdf->SetFont('helvetica','B',10);	
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(35,6,'RECIBIMOS DE: ',0,0,'L',true,'',0,false,'T','C');
	$pdf->SetFont('helvetica','',10);
	$pdf->Cell(160,6,utf8_encode($_POST[ntercero]),0,1,'L',true,'',1,false,'T','C');
	$pdf->SetFillColor(245,245,245);
	$pdf->SetFont('helvetica','B',10);
	$pdf->Cell(35,6,'C.C. o NIT: ',0,0,'L',true,'',0,false,'T','C');
	$pdf->SetFont('helvetica','',10);
	$pdf->Cell(160,6,$_POST[tercero],0,1,'L',true,'',0,false,'T','C');
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('helvetica','B',10);
	$pdf->Cell(35,6,'LA SUMA DE: ',0,0,'L',true,'',0,false,'T','C');
	$pdf->SetFont('helvetica','',8);
	$pdf->Cell(160,6,$_POST[letras],0,1,'L',true,'',1,false,'T','C');
	$pdf->SetFillColor(245,245,245);
	$pdf->SetFont('helvetica','',10);
	$pdf->RoundedRect(10, 52.5 ,195 , 19, 2,'1111');
	
	$pdf->ln(14);	
	$pdf->Cell(156,6,'DESCRIPCION ','B',0,'C',false,'',0,false,'T','C');
	$pdf->Cell(39,6,'VALOR ','LB',1,'C',false,'',1,false,'T','C');
	$pdf->ln(1);
	$pdf->SetFont('helvetica','I',10);
	$con=0;
	//while ($con<<count($_POST[balan]))
	while ($con<count($_POST[dcoding]))
	{	
		if ($con%2==0){
			$pdf->SetFillColor(245,245,245);
		}
   	 	else{
   	 		$pdf->SetFillColor(255,255,255);
   	 	}
		if ($_POST[dcoding][$con]!='')
	 	{
			$pdf->Cell(156,6,$_POST[dcoding][$con]." - ".utf8_encode($_POST[dncoding][$con]),0,0,'L',true,'',1,false,'T','C');
			$pdf->Cell(39,6,''.number_format($_POST[dvalores][$con],2),'L',1,'R',true,'',1,false,'T','C');
	 	}
		else
	 	{
		 	$pdf->Cell(156,6,'',0,0,'L',true,'',1,false,'T','C');
			$pdf->Cell(39,6,'','L',1,'R',true,'',0,false,'T','C');
		}
		$con=$con+1;   
	}
	while ($con<8-count($_POST[dcoding]))
	{	
		if ($con%2==0){$pdf->SetFillColor(245,245,245);}
    	else{$pdf->SetFillColor(255,255,255);}
		$pdf->Cell(156,6,'',0,0,'L',true,'',1,false,'T','C');
		$pdf->Cell(39,6,'','L',1,'R',true,'',0,false,'T','C');
 		$con=$con+1;   
	}
	$niy=$pdf->Gety();
	$pdf->RoundedRect(10, 82 ,195 ,$niy-82 , 2,'1111' );
	$pdf->ln(5);

	
	$aux=$pdf->Gety();
	$pdf->SetFont('helvetica','',10);
	$pdf->Cell(35,6,'CUENTA ',1,0,'C',false,'',0,false,'T','C');
	$pdf->Cell(121,6,'DESCRIPCION ',1,0,'C',false,'',1,false,'T','C');
	$pdf->Cell(39,6,'VALOR ',1,1,'C',false,'',1,false,'T','C');
	$pdf->ln(1);
	$pdf->SetFont('helvetica','I',10);
	$con=0;
	$ltrb = '';

	while ($con<count($_POST[dcuenta]))
	{	
		if ($con%2==0){
			$pdf->SetFillColor(245,245,245);
		}
   	 	else{
   	 		$pdf->SetFillColor(255,255,255);
   	 	}
   	 	$niy=$pdf->Gety();
   	 	if($niy == 269.5) $ltrb = 'B';
   	 	if($niy == 275.5) $ltrb = 'T';
 		$pdf->Cell(35,6,''.$_POST[dcuenta][$con],'L'.$ltrb,0,'C',true,'',1,false,'T','C');
		$pdf->Cell(121,6,''.$_POST[ncuenta][$con],'L'.$ltrb,0,'L',true,'',1,false,'T','C');
		$pdf->Cell(39,6,''.$_POST[rvalor][$con],'LR'.$ltrb,1,'R',true,'',1,false,'T','C');
		$ltrb = '';

		$con=$con+1;   
	}
	if ($con%2==0){
		$pdf->SetFillColor(245,245,245);
	}
	else{
		$pdf->SetFillColor(255,255,255);
	}
	$pdf->Cell(156,6,'Total: ','TLB',0,'R',true,'',1,false,'T','C');
	$pdf->Cell(39,6,''.$_POST[varto],'TLRB',1,'R',true,'',0,false,'T','C');
	$pdf->SetFont('helvetica','B',7);
	$pdf->ln(20);

	$pdf->cell(60);
	$pdf->Cell(80,5,'RECIBIDO Y SELLO','T',0,'C');
	// ---------------------------------------------------------

	$pdf->Output('reporterecaudo.pdf', 'I');//Close and output PDF document
?>