<?php
	require_once("tcpdf/tcpdf_include.php");
	require('comun.inc');
	session_start();
	date_default_timezone_set("America/Bogota");
	class MYPDF extends TCPDF 
	{
		public function Header() 
		{	
			if ($_POST[estadoc]=='R'){$this->Image('imagenes/anulado.jpg',30,15,150,80);}
			$linkbd=conectar_bd();
			$sqlr="select *from configbasica where estado='S'";
			//echo $sqlr;
			$res=mysql_query($sqlr,$linkbd);
			while($row=mysql_fetch_row($res))
			{
				$nit=$row[0];
				$rs=$row[1];
				$nalca=$row[6];
			}
			//Parte Izquierda
			$this->Image('imagenes/escudo.jpg', 22, 12, 25, 23.9, 'JPG', '', 'T', true, 300, '', false, false, 0, false, false, false);// Logo
			$this->SetFont('helvetica','B',8);
			$this->SetY(10);
			$this->RoundedRect(10, 10, 199, 31, 1,'' );
			$this->Cell(0.1);
			$this->Cell(50,31,'','R',0,'L'); 
			$this->SetY(11);
			$this->SetX(60);
			$this->SetFont('helvetica','B',12);
			$this->Cell(149,12,strtoupper(iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT","$rs")),0,0,'C'); 
			$this->SetFont('helvetica','B',8);
			$this->SetY(18);
			$this->SetX(60);
			$this->SetFont('helvetica','B',11);
			$this->Cell(149,10,"$nit",0,0,'C');
			$this->SetFont('helvetica','B',13);
			$this->SetY(10);
			$this->Cell(50.1);
			$this->Cell(149,31,'',0,1,'C'); 
			$this->SetY(27);
			$this->SetX(60);
			$this->Cell(111,14,"RETENCIONES E INGRESOS PARA TERCEROS",0,0,'C'); 
			$this->SetFont('helvetica','B',10);
			$this->SetY(15);
			$this->Cell(50.1);
			$this->Cell(149,20,$mov,0,0,'C'); 
			$this->SetFont('helvetica','I',7);
			$this->SetY(27);
			$this->Cell(50.2);
			$this->multiCell(110.7,3,''.strtoupper($detallegreso),'T','L');
			$this->SetFont('helvetica','B',10);
			$this->SetY(27);
			$this->Cell(161.1);
			$this->Cell(37.8,14,'','TL',0,'L');
			$this->SetY(31);
			$this->Cell(162);
			$this->Cell(35,5,'FECHA: '.$_POST[fecha],0,0,'L');
			$this->SetY(35);
			$this->Cell(162);
			$this->Cell(35,5,'VIGENCIA: '.$_POST[vigencias],0,0,'L');
			$this->SetY(27);
			$this->Cell(50.2);
			$this->MultiCell(105.7,4,'',0,'L');		
			$this->SetFont('times','B',10);
			$this->ln(12);
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
			$this->SetFont('helvetica', 'I', 8);
			$txt = <<<EOD
$vardirec $vartelef
$varemail $varpagiw
EOD;
			$this->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);
			$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
			
		}
	}
	$pdf = new MYPDF('P','mm','A4', true, 'iso-8859-1', false);
	$pdf->SetDocInfoUnicode (true); 
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('G&CSAS');
	$pdf->SetTitle('Certificados');
	$pdf->SetSubject('Certificado de Disponibilidad');
	$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
	$pdf->SetMargins(10, 46, 10);// set margins
	$pdf->SetHeaderMargin(46);// set margins
	$pdf->SetFooterMargin(20);// set margins
	$pdf->SetAutoPageBreak(TRUE, 20);// set auto page breaks
	if (@file_exists(dirname(__FILE__).'/lang/spa.php')) 
	{
		require_once(dirname(__FILE__).'/lang/spa.php');
		$pdf->setLanguageArray($l);
	}
	$pdf->AddPage();
	$pdf->SetFont('helvetica','B',12);
	$pdf->SetY(46);   
	$pdf->cell(125);
	$pdf->cell(27,8,'NETO A PAGAR: ',0,0,'R');
	$pdf->RoundedRect(161, 46 ,48 , 8, 2,'');
	$pdf->cell(45,8,'$'.number_format($_POST[valorpagar],2),0,'C');
	$pdf->ln(10);
	$meses=array('','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
	$pdf->cell(0.2);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(25,5,'Tercero: ',0,0,'L',0);
	$pdf->SetFont('helvetica','',10);	
	$ntercero =  iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"],$_POST[ntercero]);
	$pdf->cell(174,5,''.$ntercero,0,1,'L',0);
	$pdf->cell(0.2);  
	$pdf->SetFillColor(250,250,250);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(25,5,'C.C. o NIT: ',0,0,'L',0);
	$pdf->SetFont('helvetica','',10);
	$pdf->cell(174,5,''.$_POST[tercero],0,1,'L',0);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(0.2);
	$pdf->cell(35,5,'MES:',0,0,'L',1);
	$pdf->SetFont('helvetica','',10);
	$pdf->cell(40,5,''.$meses[$_POST[mes]],0,0,'L',1);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(35,5,'',0,0,'L',1);
	$pdf->SetFont('helvetica','',10);
	$pdf->cell(40,5,'',0,1,'L',1);
	$pdf->SetFillColor(250,250,250);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(0.2);
	$pdf->cell(35,5,'Valor Pago:',0,0,'L',1);
	$pdf->SetFont('helvetica','',10);
	$pdf->cell(40,5,'$'.number_format($_POST[valorpagar],2),0,0,'L',1);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(25,5,'Neto a Pagar:',0,0,'L',1);
	$pdf->SetFont('helvetica','',10);
	$pdf->cell(38,5,'$'.number_format($_POST[valorpagar],2),0,1,'L',1);
	$pdf->RoundedRect(10, 55 ,199 , 23, 2,'');
	$pdf->ln(6);	
	$y=$pdf->GetY();	
	$pdf->SetY($y);
	$pdf->SetFillColor(222,222,222);
	$pdf->SetFont('helvetica','B',10);
    $pdf->Cell(0.1);
    $pdf->Cell(199,5,'DETALLE',0,0,'C',1); 
 	$pdf->ln(6); 
	$y=$pdf->GetY();	
	$pdf->SetFillColor(222,222,222);
	$pdf->SetFont('helvetica','B',10);
	$pdf->SetY($y);
    $pdf->Cell(0.1);
   	$pdf->Cell(70,5,'Nombre',0,0,'C',1);
	$pdf->SetY($y);
    $pdf->Cell(50);
   	$pdf->Cell(55,5,'No Documento',0,0,'C',1);	
	$pdf->SetY($y);
    $pdf->Cell(105);
   	$pdf->Cell(30,5,'Tipo documento',0,0,'C',1);	
	$pdf->SetY($y);
    $pdf->Cell(135);
   	$pdf->Cell(30,5,'Base',0,0,'C',1);	
	$pdf->SetY($y);
	$pdf->Cell(158);
	$pdf->Cell(41,5,'Valor',0,0,'C',1);
	$pdf->SetFont('helvetica','',8);
	$cont=0;
	$pdf->ln(5); 
	for($x=0;$x<count($_POST[mddescuentos]);$x++)
	{
		if ($con%2==0) {$pdf->SetFillColor(255,255,255);}
		else  {$pdf->SetFillColor(245,245,245);}
		$pdf->Cell(70,4,''.$_POST[mddescuentos][$x].' '.$_POST[mdndescuentos][$x],'',0,'L',1);
		$pdf->Cell(40,4,''.$_POST[mnbancos][$x],'',0,'L',1);
		$pdf->Cell(32,4,''.$_POST[mctanbancos][$x],'',0,'L',1);
		$pdf->Cell(30,4,''.$_POST[mdctas][$x],'',0,'L',1);
		$pdf->Cell(17,4,'$'.$_POST[mddesvalores2][$x],'',1,'R',1);
		$con=$con+1;
	}
	$pdf->ln(8);
	$linkbd=conectar_bd();
	$sqlr="select *from configbasica where estado='S'";
	$res=mysql_query($sqlr,$linkbd);
	while($row=mysql_fetch_row($res))
 	{
		$nit=$row[0];
		$rs=$row[1];
		$nalca=$row[6];
	}
	$pdf->ln(29);
	$pdf->SetFont('times','B',9);
	$pdf->Cell(50);
	$pdf->Cell(80,4,''.strtoupper( iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"],$_SESSION[usuario])),'T',1,'C');
	$pdf->Cell(50);
	$pdf->Cell(80,4,'ELABORO','',1,'C');
	$pdf->SetFont('times','',10);
	$pdf->cell(25);
	$pdf->Cell(55,4,'',0,1,'L'); 
	$pdf->Output();
?> 


