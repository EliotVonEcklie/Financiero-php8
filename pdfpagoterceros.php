<?php
	require_once("tcpdf/tcpdf_include.php");
	require('comun.inc');
	require "funciones.inc";
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
			//*****************************************************************************************************************************
			$this->SetFont('helvetica','B',13);
			$this->SetY(10);
			$this->Cell(50.1);
			$this->Cell(149,31,'',0,1,'C'); 
			$this->SetY(27);
			$this->SetX(60);
			$this->Cell(111,14,"COMPROBANTE PAGO RECAUDO A TERCEROS",0,0,'C'); 
			$this->SetFont('helvetica','B',10);
			$this->SetY(15);
			$this->Cell(50.1);
			$this->Cell(149,20,$mov,0,0,'C'); 
			//************************************
			$this->SetFont('helvetica','I',7);
			$this->SetY(27);
			$this->Cell(50.2);
			$this->multiCell(110.7,3,''.strtoupper($detallegreso),'T','L');
			$this->SetFont('helvetica','B',10);
			$this->SetY(27);
			$this->Cell(161.1);
			$this->Cell(37.8,14,'','TL',0,'L');
			$this->SetY(27);
			$this->Cell(162);
			$this->Cell(35,5,'NUMERO : '.$_POST[idcomp],0,0,'L');
			$this->SetY(31);
			$this->Cell(162);
			$this->Cell(35,5,'FECHA: '.$_POST[fecha],0,0,'L');
			$this->SetY(35);
			$this->Cell(162);
			$this->Cell(35,5,'VIGENCIA: '.$_POST[vigencia],0,0,'L');
			$this->SetY(27);
			$this->Cell(50.2);
			$this->MultiCell(105.7,4,'',0,'L');		
			$this->SetFont('times','B',10);
			$this->ln(12);
			/*
			$linkbd=conectar_bd();
			$sqlr="select *from configbasica where estado='S'";
			$res=mysql_query($sqlr,$linkbd);
			while($row=mysql_fetch_row($res))
			{
				$nit=$row[0];
				$rs=$row[1];
				$nalca=$row[6];
			}
			$this->Image('imagenes/eng.jpg',23,10,25,25);
			$this->SetFont('helvetica','B',8);
			$this->SetY(10);
			$this->RoundedRect(10, 10, 199, 31, 2.5,'' );
			$this->Cell(0.1);
			$this->Cell(50,31,'','R',0,'L'); 
			$this->SetY(31);
			$this->Cell(0.1);
			$this->Cell(50,5,''.$rs,0,0,'C'); 
			$this->SetFont('helvetica','B',8);
			$this->SetY(35);
			$this->Cell(0.1);
			$this->Cell(50,5,''.$nit,0,0,'C'); //Cuadro Izquierda
			$this->SetFont('helvetica','B',14);
			$this->SetY(10);
			$this->Cell(50.1);
			$this->Cell(149,31,'',0,1,'C'); 
			$this->SetY(8);
			$this->Cell(50.1);
			$this->Cell(149,20,'COMPROBANTE PAGO RECAUDO A TERCEROS',0,0,'C');
			$this->SetFont('helvetica','I',10);
			$this->SetY(27);
			$this->Cell(50.2);
			$this->multiCell(110.7,7,''.strtoupper(),'T','L');
			$this->SetFont('helvetica','B',10);
			$this->SetY(27);
			$this->Cell(161.1);
			$this->Cell(37.8,14,'','TL',0,'L');
			$this->SetY(27);
			$this->Cell(162);
			$this->Cell(35,5,'NUMERO : '.$_POST[idcomp],0,0,'L');
			$this->SetY(31);
			$this->Cell(162);
			$this->Cell(35,5,'FECHA: '.$_POST[fecha],0,0,'L');
			$this->SetY(35);
			$this->Cell(162);
			$this->Cell(35,5,'VIGENCIA: '.$_SESSION[vigencia],0,0,'L');
			$this->SetY(27);
			$this->Cell(50.2);
			$this->MultiCell(105.7,4,'',0,'L');		
			$this->SetFont('times','B',10);
			$this->ln(12);
			*/
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
	$pdf->SetMargins(10, 101, 10);// set margins
	$pdf->SetHeaderMargin(101);// set margins
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
	$pdf->cell(45,8,'$'.number_format($_POST[valorpagarmil],2),0,'C');
	$pdf->ln(10);
	$pdf->SetFillColor(245,245,245);
	$pdf->cell(0.2);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(35,5,'Beneficiario: ','LT',0,'L',1);
	$pdf->SetFont('helvetica','',10);
	$ntercero =  iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"],$_POST[ntercero]);
	$pdf->cell(164,5,''.$ntercero,'TR',1,'L',1);
	$pdf->cell(0.2);  
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(35,5,'C.C. o NIT: ','L',0,'L',1);
	$pdf->SetFont('helvetica','',10);
	$pdf->cell(164,5,''.$_POST[tercero],'R',1,'L',1);
	$pdf->cell(0.2);
	$pdf->SetFillColor(245,245,245);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(35,5,'Detalle: ','L',0,'L',0);
	$pdf->SetFont('helvetica','',10);
	$detallegreso = iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[concepto]);
	$pdf->MultiCell(164,5,"$detallegreso",'R','L',false,1,'','',true,0,false,true,0,'T',false);
 	$meses=array('','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(0.2);
	$pdf->cell(35,5,'Mes:','L',0,'L',1);
	$pdf->SetFont('helvetica','',10);
	$pdf->cell(40,5,''.$meses[$_POST[mes]],0,0,'L',1);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(35,5,'Forma Pago:',0,0,'L',1);
	$pdf->SetFont('helvetica','',10);
	$pdf->cell(89,5,''.strtoupper($_POST[tipop]),'R',1,'L',1);
	$pdf->cell(0.2);
	$pdf->SetFillColor(245,245,245);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(35,5,'Banco: ','L',0,'L',1);
	$pdf->SetFont('helvetica','',10);
	$pdf->cell(91,5,''.substr(strtoupper($_POST[nbanco]),0,80),0,0,'L',1);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(15,5,'N Cta.:',0,0,'L',1);
	$pdf->SetFont('helvetica','',10);
	$pdf->cell(58,5,''.$_POST[tcta].' '.$_POST[cb],'R',1,'L',1);
	$pdf->cell(0.2);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(35,5,'Cheque/Transf.:','L',0,'L',1);
	$pdf->SetFont('helvetica','',10);
	$pdf->cell(164,5,''.$_POST[ntransfe].$_POST[ncheque],'R',1,'L',1);
	$pdf->cell(0.2);
	$pdf->SetFillColor(245,245,245);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(35,5,'Valor Pago:','LB',0,'L',1);
	$pdf->SetFont('helvetica','',10);
	$pdf->cell(40,5,'$'.number_format($_POST[valorpagar],2),'B',0,'L',1);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(25,5,'Ajuste Miles: ','B',0,'L',1);
	$pdf->SetFont('helvetica','',10);
	$pdf->cell(35,5,'$'.number_format($_POST[diferencia],2),'B',0,'L',1);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(25,5,'Neto a Pagar:','B',0,'L',1);
	$pdf->SetFont('helvetica','',10);
	$pdf->cell(39,5,'$'.number_format($_POST[valorpagarmil],2),'BR',1,'L',1);
	$pdf->RoundedRect(10.2, 56 ,0 , 34, 0,'' );
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
	$pdf->Cell(154,5,'Nombre',0,0,'C',1);
	$pdf->SetY($y);
	$pdf->Cell(155);
	$pdf->Cell(44,5,'Valor',0,0,'C',1);
	$pdf->SetFont('helvetica','',8);
	$cont=0;
	$pdf->ln(5); 
 	for($x=0;$x<count($_POST[mddescuentos]);$x++)
	{		 
		if ($con%2==0) {$pdf->SetFillColor(255,255,255);}
		else {$pdf->SetFillColor(245,245,245);}
		$pdf->Cell(154,4,''.$_POST[mddescuentos][$x].' '.$_POST[mdndescuentos][$x],'',0,'L',1);
		$pdf->Cell(44,4,'$'.$_POST[mddesvalores2][$x],'',1,'R',1);				
		$con=$con+1;
	}
	//$pdf->ln(8);
	$linkbd=conectar_bd();
	$sqlr="select id_cargo,id_comprobante from pptofirmas where id_comprobante='25' and vigencia='".$_POST[vigencia]."'";
	$res=mysql_query($sqlr,$linkbd);
	while($row=mysql_fetch_assoc($res))
	{
		if($row["id_cargo"]=='0')
		{
			$_POST[ppto][]=buscatercero($_POST[tercero]);
			$_POST[nomcargo][]='BENEFICIARIO';
		}
		else
		{
			$sqlr1="select cedulanit,(select nombrecargo from planaccargos where codcargo='".$row["id_cargo"]."') from planestructura_terceros where codcargo='".$row["id_cargo"]."' and estado='S'";
			$res1=mysql_query($sqlr1,$linkbd);
			$row1=mysql_fetch_row($res1);
			$_POST[ppto][]=iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",buscatercero($row1[0]));
			$_POST[nomcargo][]=$row1[1];
		}
	}
	for($x=0;$x<count($_POST[ppto]);$x++)
	{
		$pdf->ln(16);
		$v=$pdf->gety();
		if($v>=251){ 
			$pdf->AddPage();
			$pdf->ln(20);
			$v=$pdf->gety();
		}
		$pdf->setFont('times','B',8);
		if (($x%2)==0) {
			if(isset($_POST[ppto][$x+1])){
				$pdf->Line(17,$v,107,$v);
				$pdf->Line(112,$v,202,$v);
				$v2=$pdf->gety();
				$pdf->Cell(104,4,''.$_POST[ppto][$x],0,1,'C',false,0,0,false,'T','C');
				$pdf->Cell(104,4,''.iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[nomcargo][$x]),0,1,'C',false,0,0,false,'T','C');
				$pdf->SetY($v2);
				$pdf->Cell(295,4,''.$_POST[ppto][$x+1],0,1,'C',false,0,0,false,'T','C');
				$pdf->Cell(295,4,''.iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[nomcargo][$x+1]),0,1,'C',false,0,0,false,'T','C');
			}else{
				$pdf->Line(50,$v,160,$v);
				$pdf->Cell(190,4,''.$_POST[ppto][$x],0,1,'C',false,0,0,false,'T','C');
				$pdf->Cell(190,4,''.iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[nomcargo][$x]),0,0,'C',false,0,0,false,'T','C');
			}
			$v3=$pdf->gety();
		}
		$pdf->SetY($v3);
		$pdf->SetFont('helvetica','',7);
	}
	$pdf->Output();
?> 


