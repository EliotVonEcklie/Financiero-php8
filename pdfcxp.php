<?php
	require_once("tcpdf/tcpdf_include.php");
	require('comun.inc');
	require"funciones.inc";
	date_default_timezone_set("America/Bogota");
	session_start();
	$val = 0;
	class MYPDF extends TCPDF 
	{
		public function Header() 
		{
			if ($_POST[estado]=='R'){$this->Image('imagenes/reversado02.png',75,41.5,50,15);}
			$linkbd=conectar_bd();
			$sqlr="select *from configbasica where estado='S' ";
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
			$this->SetFont('helvetica','B',14);
			$this->SetY(10);
			$this->Cell(50.1);
			$this->Cell(149,31,'',0,1,'C'); 
			$this->SetY(27);
			$this->SetX(60);
			$this->Cell(111,14,"LIQUIDACIÓN CUENTA X PAGAR",0,0,'C'); 
			$mov='';
			if(isset($_POST[movimiento]))
			{
				if(!empty($_POST[movimiento]))
				{
					if($_POST[movimiento]=='401'){$mov="DOCUMENTO DE REVERSION";}
				}
			}
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
			//**********************************************************
			$this->SetFont('times','B',10);
			$this->ln(12);
			//**********************************************************
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
	$pdf = new MYPDF('P','mm','Letter', true, 'iso-8859-1', false);// create new PDF document
	$pdf->SetDocInfoUnicode (true); 
	// set document information
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('G&CSAS');
	$pdf->SetTitle('Certificados');
	$pdf->SetSubject('Certificado de Disponibilidad');
	$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
	$pdf->SetMargins(10, 50, 10);// set margins
	$pdf->SetHeaderMargin(101);// set margins
	$pdf->SetFooterMargin(20);// set margins
	$pdf->SetAutoPageBreak(TRUE, 20);// set auto page breaks
	// set some language-dependent strings (optional)
	if (@file_exists(dirname(__FILE__).'/lang/spa.php')) 
	{
		require_once(dirname(__FILE__).'/lang/spa.php');
		$pdf->setLanguageArray($l);
	}
	$pdf->AddPage();
	$pdf->SetFont('Times','',10);
	$pdf->SetFont('helvetica','B',12);
	$pdf->SetY(46);
	$pdf->cell(125);
	$pdf->cell(27,8,'NETO A PAGAR: ',0,0,'R');
	$pdf->RoundedRect(161, 46 ,48, 8, 1,'');
	$pdf->cell(45,8,'$'.number_format($_POST[valorcheque],2),0,'C');
	$pdf->ln(10);
	$pdf->cell(0.2);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(25,5,'Beneficiario: ','LT',0,'L',0);
	$pdf->SetFont('helvetica','',10);	
	$ntercero =  iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"],$_POST[ntercero]);
	$pdf->cell(174,5,''.$ntercero,'RT',1,'L',0);
	$pdf->cell(0.2);  
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(25,5,'C.C. o NIT: ','L',0,'L',0);
	$pdf->SetFont('helvetica','',10);
	$pdf->cell(174,5,''.$_POST[tercero],'R',1,'L',0);
	$pdf->cell(0.2);
	$pdf->SetFillColor(245,245,245);
	$detallegreso = iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[detallegreso]);
	$lineas = $pdf->getNumLines($detallegreso, 174);
	$alturadt=(5*$lineas);
	$pdf->SetFont('helvetica','B',10);
	$pdf->MultiCell(25,$alturadt,'Detalle: ', 'L', 'J', 0, 0, '', '', true, 0, false, true, $alturadt, 'T');
	$pdf->SetFont('helvetica','',10);
	$pdf->MultiCell(174,$alturadt,"$detallegreso",'R','J',false,1,'','',true,0,false,true,$alturadt,'T',false);
	$pdf->cell(0.2);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(25,5,'Registro:','L',0,'L',0);
	$pdf->SetFont('helvetica','',10);
	$pdf->cell(20,5,''.$_POST[rp],0,0,'L',0);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(15,5,'Detalle: ',0,0,'L',0);
	$pdf->SetFont('helvetica','',10);
	$detallecdp = iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT", $_POST[detallecdp]);
	$pdf->cell(139,5,''.substr($detallecdp,0,60),'R',1,'L',0);
	$pdf->SetFillColor(245,245,245);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(0.2);
	$pdf->cell(20,5,'Valor Pago:','LB',0,'L',0);
	$pdf->SetFont('helvetica','',10);
	$pdf->cell(35,5,'$'.number_format($_POST[valor],2),'B',0,'L',0);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(22,5,'Retenciones: ','B',0,'L',0);
	$pdf->SetFont('helvetica','',10);
	$pdf->cell(35,5,'$'.number_format($_POST[valorretencion],2),'B',0,'L',0);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(16,5,'Base Ret:','B',0,'L',0);
	$pdf->SetFont('helvetica','',10);
	$pdf->cell(38,5,'$'.number_format($_POST[base],2),'B',0,'L',0);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(6,5,'Iva:','B',0,'L',0);
	$pdf->SetFont('helvetica','',10);
	$pdf->cell(27,5,'$'.number_format($_POST[iva],2),'BR',1,'L',0);
	$pdf->RoundedRect(10.2, 56 ,0 , 23, 0,'' );
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
    $pdf->Cell(34,5,'Cuenta',0,0,'C',1); 
	$pdf->SetY($y);
	$pdf->Cell(35.1);
	$pdf->Cell(68,5,'Nombre',0,0,'C',1);
	$pdf->SetY($y);
	$pdf->Cell(104.1);
	$pdf->Cell(50,5,'Recurso',0,0,'C',1);
	$pdf->SetY($y);
	$pdf->Cell(155);
	$pdf->Cell(44,5,'Valor',0,0,'C',1);
	$pdf->SetFont('helvetica','',8);
	$cont=0;
	$pdf->ln(5); 
	for($x=0;$x<count($_POST[dcuentas]);$x++)
	{	
		if($_POST[dvalores][$x]>0)
		{
			if ($con%2==0){$pdf->SetFillColor(255,255,255);}
			else {$pdf->SetFillColor(245,245,245);}
			$dncuentas =iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[dncuentas][$x]);
			$drecursos =iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[drecursos][$x]);
			$lineas1 = $pdf->getNumLines($dncuentas, 70);
			$lineas2 = $pdf->getNumLines($drecursos, 51);
			if($lineas1>$lineas2){$altura=(4*$lineas1);}
			else {$altura=(4*$lineas2);}
			//echo $altura."<br>";
			$pdf->Cell(34,$altura,''.$_POST[dcuentas][$x],'',0,'C',1);
			$pdf->MultiCell(70,$altura,$dncuentas,0,'L',true,0,'','',true,0,false,true,0,'L',false);
			$pdf->MultiCell(51,$altura,$drecursos,0,'L',true,0,'','',true,0,false,true,0,'L',false);
			$pdf->Cell(44,$altura,'$'.number_format($_POST[dvalores][$x],2),'',1,'R',1);
			$con=$con+1;
		}
	}
	$pdf->ln(8);
	$y=$pdf->GetY();	
	$pdf->SetY($y);
	$pdf->SetFillColor(222,222,222);
	$pdf->SetFont('helvetica','B',10);
	$pdf->Cell(0.1);
	$pdf->Cell(199,5,'RETENCIONES',0,0,'C',1); 
	$pdf->ln(6); 
	$y=$pdf->GetY();	
	$pdf->SetFillColor(222,222,222);
	$pdf->SetFont('helvetica','B',10);
	$pdf->SetY($y);
	$pdf->Cell(0.1);
	$pdf->Cell(22,5,'Codigo ',0,0,'C',1); 
	$pdf->SetY($y);
	$pdf->Cell(23.1);
	$pdf->Cell(110,5,'Retencion',0,0,'C',1);
	$pdf->SetY($y);
	$pdf->Cell(134.1);
	$pdf->Cell(20,5,'Porcentaje',0,0,'C',1);
	$pdf->SetY($y);
	$pdf->Cell(155);
	$pdf->Cell(44,5,'Valor',0,0,'C',1);
	$pdf->SetFont('helvetica','',8);
	$cont=0;
	for($x=0;$x<count($_POST[ddescuentos]);$x++)
	{	
		$pdf->ln(5); 
		if ($con%2==0){$pdf->SetFillColor(255,255,255);}
		else {$pdf->SetFillColor(245,245,245);}
		$pdf->Cell(22,4,''.$_POST[ddescuentos][$x],'',0,'C',1);
		$pdf->Cell(110,4,''.$_POST[dndescuentos][$x],'',0,'L',1);
		$pdf->Cell(20,4,''.$_POST[dporcentajes][$x].'%','',0,'R',1);		
		$pdf->Cell(47,4,'$'.number_format($_POST[ddesvalores][$x],2),'',1,'R',1);				
		$con=$con+1;
	}
	if(count($_POST[dcuenta])>0)
	{
		$pdf->ln(5);
		$pdf->SetFillColor(222,222,222);
		$pdf->SetFont('helvetica','B',10);
		$pdf->Cell(0.1);
		$pdf->Cell(199,5, 'AFECTACIÓN PRESUPUESTAL',0,0,'C',1); 
		$pdf->ln(6); 
		$pdf->SetFont('helvetica','',10);
		$pdf->Cell(44,6,'CUENTA ',1,0,'C',true,'',0,false,'T','C');
		$pdf->Cell(115,6,'DESCRIPCIÓN ',1,0,'C',true,'',1,false,'T','C');
		$pdf->Cell(40,6,'VALOR ',1,1,'C',true,'',1,false,'T','C');
		$pdf->ln(1);
		$pdf->SetFont('helvetica','I',10);
		$con=0;
		$ltrb = '';
		for($i=0;$i<count($_POST[dcuenta]);$i++)
		{
			$gdcuenta[$_POST[dcuenta][$i]][0]=$_POST[dcuenta][$i];
			$gdcuenta[$_POST[dcuenta][$i]][1]=$_POST[ncuenta][$i];
			$gdcuenta[$_POST[dcuenta][$i]][2]=$gdcuenta[$_POST[dcuenta][$i]][2]+str_replace(',','',$_POST[rvalor][$i]);
		}
		foreach($gdcuenta as $val)
		{
			if ($con%2==0){$pdf->SetFillColor(245,245,245);}
			else {$pdf->SetFillColor(255,255,255);}
			$niy=$pdf->Gety();
			if($niy >= 269.5) $ltrb = 'B';
			if($niy >= 275.5) $ltrb = 'T';
			$pdf->Cell(44,6,''.$val[0],'L'.$ltrb,0,'C',true,'',1,false,'T','C');
			$pdf->Cell(115,6,''.$val[1],'L'.$ltrb,0,'L',true,'',1,false,'T','C');
			$pdf->Cell(40,6,''.number_format($val[2],2,".",","),'LR'.$ltrb,1,'R',true,'',1,false,'T','C');
			$ltrb = '';
			$con=$con+1; 
		}
		if ($con%2==0){$pdf->SetFillColor(245,245,245);}
		else {$pdf->SetFillColor(255,255,255);}
		$pdf->Cell(159,6,'Total: ','TLB',0,'R',true,'',1,false,'T','C');
		$pdf->Cell(40,6,''.$_POST[varto],'TLRB',1,'R',true,'',0,false,'T','C');
	}
	$linkbd=conectar_bd();
	$sqlr="select id_cargo,id_comprobante from pptofirmas where id_comprobante='8' and vigencia='".$_POST[vigencia]."'";
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
			$_POST[ppto][]=buscar_empleado($row1[0]);
			$_POST[nomcargo][]=$row1[1];
		}
	};
	for($x=0;$x<count($_POST[ppto]);$x++)
	{
		$pdf->ln(15);
		$v=$pdf->gety();
		if($v>=251)
		{ 
			$pdf->AddPage();
			$pdf->ln(15);
			$v=$pdf->gety();
		}
		$pdf->setFont('times','B',8);
		if (($x%2)==0) 
		{
			if(isset($_POST[ppto][$x+1]))
			{
				$pdf->Line(17,$v,107,$v);
				$pdf->Line(112,$v,202,$v);
				$v2=$pdf->gety();
				$pdf->Cell(104,4,''.iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[ppto][$x]),0,1,'C',false,0,0,false,'T','C');
				$pdf->Cell(104,4,''.iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[nomcargo][$x]),0,1,'C',false,0,0,false,'T','C');
				$pdf->SetY($v2);
				$pdf->Cell(295,4,''.iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[ppto][$x+1]),0,1,'C',false,0,0,false,'T','C');
				$pdf->Cell(295,4,''.iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[nomcargo][$x+1]),0,1,'C',false,0,0,false,'T','C');
			}
			else
			{
				$pdf->Line(50,$v,160,$v);
				$pdf->Cell(190,4,''.iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[ppto][$x]),0,1,'C',false,0,0,false,'T','C');
				$pdf->Cell(190,4,''.iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[nomcargo][$x]),0,0,'C',false,0,0,false,'T','C');
			}
			$v3=$pdf->gety();
		}
		$pdf->SetY($v3);
		$pdf->SetFont('helvetica','',7);
	}
	$pdf->Output();
?> 


