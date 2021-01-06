<?php
	require_once("tcpdf/tcpdf_include.php");
	require('comun.inc');
	require('funciones.inc');
	require('conversor.php');
	date_default_timezone_set("America/Bogota");
	session_start();
	class MYPDF extends TCPDF 
	{
		public function Header()//Cabecera de página
		{
			$linkbd=conectar_bd();
			$sqlr="select *from configbasica where estado='S'";
			$res=mysql_query($sqlr,$linkbd);
			while($row=mysql_fetch_row($res))
			{
				$nit=$row[0];
				$rs=$row[1];
				$nalca=$row[6];
			}
			$this->Image('imagenes/escudo.jpg', 22, 12, 25, 23.9, 'JPG', '', 'T', true, 300, '', false, false, 0, false, false, false);// Logo
			$this->SetY(10);
			$this->RoundedRect(10, 10, 199, 31, 2.5,'' );
			$this->Cell(0.1);
			$this->Cell(50,31,'','R',0,'L'); 
			$this->SetY(10);
			$this->Cell(50.1);
			$this->Cell(149,31,'',0,1,'C'); 
			$this->SetFont('helvetica','B',12);
			$this->SetY(10);
			$this->Cell(50.1);
			$this->Cell(149,12,strtoupper(iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT","$rs")),0,0,'C'); 
			$this->SetFont('helvetica','B',8);
			$this->SetY(18);//$this->Cell(149,20,'COMPROBANTE EGRESO DE NOMINA',0,0,'C'); 
			$this->SetX(60);
			$this->SetFont('helvetica','B',11);
			$this->Cell(149,10,"$nit",0,0,'C');
			$this->SetFont('helvetica','B',12);
			$this->SetY(10);
			$this->Cell(50.1);
			$this->Cell(149,31,'',0,1,'C'); 
			$this->SetY(27);
			$this->SetX(60);
			$this->Cell(111,14,"EGRESO DE CAJA MENOR",1,0,'C'); 
			$this->SetFont('helvetica','B',10);
			$this->SetY(27);
			$this->Cell(161.1);
			$this->Cell(37.8,14,'','TL',0,'L');
			$this->SetY(27);
			$this->Cell(162);
			$this->Cell(35,5,"NUMERO : $_POST[idcomp]",0,0,'L');
			$this->SetY(31);
			$this->Cell(162);
			$this->Cell(35,5,"FECHA: $_POST[fecha]",0,0,'L');
			$this->SetY(35);
			$this->Cell(162);
			$this->Cell(35,5,"VIGENCIA: $_POST[vigencia]",0,0,'L');
			$this->SetY(27);
			$this->Cell(50.2);
			$this->MultiCell(105.7,4,'',0,'L');		
			$this->SetFont('times','B',10);
			//***************************************************************************************************
		}
		public function Footer() //Pie de página
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
	$pdf->SetTitle('Egreso Caja Menor');
	$pdf->SetSubject('Certificado de Disponibilidad');
	$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
	$pdf->SetMargins(10, 48, 10);// set margins
	$pdf->SetHeaderMargin(48);// set margins
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
	$pdf->SetAutoPageBreak(true,20);
	$linkbd=conectar_bd();
	$pdf->SetFont('helvetica','B',12);
	$pdf->SetY(46);
	$pdf->cell(125);
	$pdf->cell(27,8,'NETO A PAGAR: ',0,0,'R');
	$pdf->RoundedRect(161, 46 ,48 , 8, 2,'');
	$pdf->cell(45,8,$_POST[valor],0,0,'R');
	$pdf->ln(10);
	$pdf->cell(0.2);
	$pdf->SetFillColor(245,245,245);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(35,5,'Tipo Egreso: ','LT',0,'L',1);
	$pdf->SetFont('helvetica','',10);
	$pdf->cell(44,5,''.strtoupper($_POST[tipoegreso]),'RT',0,'L',1);
	$pdf->SetFont('helvetica','B',10);
	if($_POST[tipoegreso]=='apertura')
	{
		$prides="Acto Administrativo:";
		$secdes="Valor Acuerdo:";
		$sqlr="SELECT consecutivo,detalle_acuerdo FROM tesoacuerdo WHERE id_acuerdo='$_POST[acuerdo]'";
		$resp = mysql_query($sqlr,$linkbd);
		$row =mysql_fetch_row($resp);
		$terdes=iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT","$row[0]-$row[1]");
		$cuades=$_POST[valorac];
	}
	else
	{
		$prides="Reintegro:";
		$secdes="Valor Reintegro:";
		$sqlr="SELECT id_cajamenor,objeto FROM tesocontabilizacajamenor WHERE finaliza='1' AND id_cajamenor='$_POST[reintegro]'";
		$resp = mysql_query($sqlr,$linkbd);
		$row =mysql_fetch_row($resp);
		$terdes=iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT","$row[0]-$row[1]");
		$cuades=$_POST[valorreintegro];
	}
	$pdf->cell(35,5,$secdes,'T',0,'L',1);
	$pdf->SetFont('helvetica','',10);
	$pdf->cell(85,5,''.$cuades,'RT',1,'L',1);
	$pdf->cell(0.2);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(35,5,$prides,'L',0,'L',1);
	$pdf->SetFont('helvetica','',10);
	$pdf->cell(164,5,''.strtoupper($terdes),'R',1,'L',1);
	$pdf->cell(0.2);
	$pdf->SetFillColor(245,245,245);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(25,5,'RP: ','L',0,'L',1);
	$pdf->SetFont('helvetica','',10);
	$pdf->cell(25,5,$_POST[rp],0,0,'L',1);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(20,5,'Valor RP: ',0,0,'L',1);
	$pdf->SetFont('helvetica','',10);
	$pdf->cell(35,5,$_POST[valorrp],0,0,'C',1);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(25,5,'CDP: ',0,0,'L',1);
	$pdf->SetFont('helvetica','',10);
	$pdf->cell(25,5,$_POST[cdp],0,0,'L',1);
	$pdf->cell(44,5,'','R',1,'L',1);
	$pdf->cell(0.2);
	$pdf->SetFillColor(245,245,245);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(22,5,'C.C. o NIT: ','L',0,'L',1);
	$pdf->SetFont('helvetica','',10);
	$pdf->cell(28,5,''.$_POST[tercero],0,0,'L',1);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(20,5,'Tercero: ',0,0,'L',1);
	$pdf->SetFont('helvetica','',10);
	$beneficiariot=iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[ntercero]);
	$pdf->cell(129,5,''.strtoupper($beneficiariot),'R',1,'L',1);
	$pdf->cell(0.2);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(35,5,'Banco: ','L',0,'L',1);
	$pdf->SetFont('helvetica','',9);
	$pdf->cell(91,5,''.substr(strtoupper($_POST[nbanco]),0,80),0,0,'L',1);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(15,5,'N Cta.:',0,0,'L',1);
	$pdf->SetFont('helvetica','',10);
	$pdf->cell(58,5,''.$_POST[tcta].' '.$_POST[cb],'R',1,'L',1);
	$pdf->SetFillColor(255,255,255);
	$pdf->cell(0.2);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(25,5,'Forma Pago:','L',0,'L',1);
	$pdf->SetFont('helvetica','',9);
	$pdf->cell(35,5,''.strtoupper($_POST[tipop]),0,0,'L',1);
	if($_POST[tipop]=='transferencia'){$nomtipo='Transf.:';$valtipo=$_POST[ntransfe];}
	else {$nomtipo='Cheque.:';$valtipo=$_POST[ncheque];}
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(18,5,$nomtipo,0,0,'L',1);
	$pdf->SetFont('helvetica','',10);
	$pdf->cell(35,5,''.$valtipo,0,0,'L',1);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(25,5,'Valor Pago:',0,0,'L',1);
	$pdf->SetFont('helvetica','',10);
	$pdf->cell(61,5,$_POST[valor],'R',1,'L',1);
	$pdf->SetFillColor(245,245,245);
	$pdf->cell(0.2);
	$pdf->SetFont('helvetica','B',10);
	$valletras=$_POST[letras];
	$pdf->MultiCell(199,5,'Son: '.strtoupper($valletras),'LBR','L',true,1,'','',true,0,false,true,0,'T',false);
	$pdf->ln(5);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(199,5,'DESCRIPCIÓN: ','LTR',1,'L',1);
	$detallegreso = iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[detallegreso]);
	$pdf->SetFont('helvetica','',10);
	$pdf->MultiCell(199,5,"$detallegreso",'LBR','L',true,1,'','',true,0,false,true,0,'T',false);
	$pdf->ln(5);
	$y=$pdf->GetY();
	$pdf->SetY($y);
	$pdf->SetFillColor(222,222,222);
	$pdf->SetFont('helvetica','B',10);
	$pdf->Cell(0.1);
	$pdf->Cell(199,5,'DETALLE EGRESO',0,0,'C',1); 
	$pdf->ln(6); 
	$y=$pdf->GetY();	
	$pdf->SetFillColor(222,222,222);
	$pdf->SetFont('helvetica','B',10);
	$pdf->Cell(0.1);
	$pdf->Cell(28,5,'Cuenta',0,0,'C',1); 
	$pdf->Cell(110,5,'Nombre Cuenta',0,0,'C',1);
	$pdf->Cell(20,5,'Recurso',0,0,'C',1);
	$pdf->Cell(41,5,'Valor',0,1,'C',1);
	$pdf->SetFont('helvetica','',8);
	$cont=0;
	$sqlr="SELECT cuentap,valor,cc FROM tesoegresocajamenor_det WHERE id_egreso='$_POST[idcomp]' ORDER BY id";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res))
	{
		if ($con%2==0){$pdf->SetFillColor(255,255,255);}
		else {$pdf->SetFillColor(245,245,245);}
		$nomcuenta=buscacuentapres($row[0],2);
		$pdf->Cell(28,4,''.$row[0],'',0,'C',1);
		$pdf->Cell(110,4,''.iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$nomcuenta),'',0,'L',1);
		$pdf->Cell(20,4,''.$_POST[rp].'','',0,'R',1);		
		$pdf->Cell(39,4,'$'.number_format($row[1],2,".",","),'',1,'R',1);
		$con=$con+1;
	 }
	$sqlr="select id_cargo,id_comprobante from pptofirmas where id_comprobante='24' and vigencia='".$_POST[vigencia]."'";
	$res=mysql_query($sqlr,$linkbd);
	while($row=mysql_fetch_assoc($res))
	{
		if($row["id_cargo"]=='0')
		{
			$_POST[ppto][]=iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",buscatercero($_POST[tercero]));
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
	}
	for($x=0;$x<count($_POST[ppto]);$x++)
	{
		$pdf->ln(25);
		$v=$pdf->gety();
		$pdf->setFont('times','B',10);
		$pdf->Line(50,$v,160,$v);
		$pdf->Cell(190,6,''.iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[ppto][$x]),0,1,'C',false,0,0,false,'T','C');
		$pdf->Cell(190,6,''.iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[nomcargo][$x]),0,0,'C',false,0,0,false,'T','C');
		$pdf->SetFont('helvetica','',7);
	}


	
	$pdf->Output();
?> 


