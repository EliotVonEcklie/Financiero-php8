<?php
	require_once("tcpdf/tcpdf_include.php");
	require('comun.inc');
	require"funciones.inc";
	session_start();
	global $hola;
	$desplaza = 0;
	class MYPDF extends TCPDF 
	{
		public function Header() 
		{	
			if ($_POST[estadoc]=='ANULADO'){$this->Image('imagenes/anulado.jpg',30,15,150,80);}
			$linkbd=conectar_bd();
			$sqlr="SELECT * FROM configbasica WHERE estado='S'";
			$res=mysql_query($sqlr,$linkbd);
			while($row=mysql_fetch_row($res))
			{
				$nit=$row[0];
				$rs=$row[1];
			}
			$this->Image('imagenes/escudo.jpg',23,12,25,25);
			$this->SetFont('helvetica','B',10);
			$this->SetY(10);
			$this->RoundedRect(10, 10, 199, 31, 2.5,'' );
			$this->Cell(0.1);
			$this->Cell(50,31,'','R',0,'L'); 
			$mov='';
			if(isset($_POST['movimiento']))
			{
				if($_POST['movimiento']=='401' || $_POST['movimiento']=='402'){$mov="DOCUMENTO DE REVERSION";}
			}
			$this->Cell(149,31,$mov,0,1,'C'); 
			$this->SetY(10);
			
			$this->SetFont('helvetica','B',14);
			if(strlen($rs)<40)
			{
				$this->Cell(50.1);
				$this->Cell(149,15,"$rs",0,0,'C');
				$this->SetY(10);
			}
			else
			{
				$this->Cell(74.1);
				$this->MultiCell(100,15,$rs,0,'C',false,1,'','',true,4,false,true,19,'T',false);
				$this->SetY(12);
			}
			//$this->MultiCell(149,15,$rs,0,'C',false,1,'','',true,4,false,true,19,'T',false);
			
			$this->Cell(50.1);
			$this->SetFont('helvetica','B',10);
			$this->Cell(149,25,"$nit",0,0,'C'); 
			$this->SetY(27);
			$this->Cell(161.1);
			$this->Cell(38,14,'','TL',0,'C');
			$this->SetY(27.5);
			$this->Cell(162);
			$this->Cell(35,5,'No RP : '.$_POST[numero],0,0,'L');
			$this->SetY(31.5);
			$this->Cell(162);
			$this->Cell(35,5,'VIGENCIA F.: '.$_POST[vigencia],0,0,'L');
			$this->SetY(35.5);
			$this->Cell(162);
			$this->Cell(35,5,'FECHA: '.$_POST[fecha],0,0,'L');
			$this->SetY(27);
			$this->Cell(50.2);
			$this->SetFont('helvetica','B',12);
			$this->Cell(111,8,'REGISTRO PRESUPUESTAL DE COMPROMISO',1,0,'C'); 
			$this->SetFont('helvetica','B',10);
			$this->SetY(36);
			$this->Cell(50.2);
			$this->Cell(29.7,5,'CDP No: '.$_POST[numerocdp],0,0,'L');
			$this->SetY(36);
			$this->Cell(80);
			$this->Cell(82,5,'EXPEDIDO EL: '.$_POST[fechacdp],0,0,'L');
			$this->SetY(36);
			$this->Cell(130);
			$this->Cell(34.1,5,'Contrato: '.$_POST[ncontrato],'',0,'L');
			
		}
		function Footer()
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
	$linkbd=conectar_bd();
	$sqlr="select id_cargo,id_comprobante from pptofirmas where id_comprobante='7' and vigencia='".$_POST[vigencia]."'";
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
			$_POST[ppto][]=iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",buscar_empleado($row1[0]));
			$_POST[nomcargo][]=$row1[1];
		}
	}
	$pdf = new MYPDF('P','mm','Letter', true, 'iso-8859-1', false);
	$pdf->SetDocInfoUnicode (true); 
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('G&CSAS');
	$pdf->SetTitle('Registro');
	$pdf->SetSubject('Registro de Disponibilidad');
	$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
	$pdf->SetMargins(10, 45, 10);// set margins
	$pdf->SetHeaderMargin(45);// set margins
	$pdf->SetFooterMargin(20);// set margins
	$pdf->SetAutoPageBreak(TRUE, 20);// set auto page breaks
	// set some language-dependent strings (optional)
	if (@file_exists(dirname(__FILE__).'/lang/spa.php')) 
	{
		require_once(dirname(__FILE__).'/lang/spa.php');
		$pdf->setLanguageArray($l);
	}
	$pdf->AddPage();
	$pdf->SetFont('helvetica','B',10);
	$pdf->Cell(28,5,'BENEFICIARIO:',0,0,'L');
	$pdf->SetFont('helvetica','',10);
	$pdf->Cell(171,5,''.iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[ntercero]),0,1,'L');		
	$pdf->SetFont('helvetica','B',10);
	$pdf->Cell(18,5,'OBJETO: ',0,'L');
	$pdf->SetFont('helvetica','',10);
	$pdf->MultiCell(179,5,''.iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[objeto]),0,'L',false,1,'','',true,4,false,true,60,'T',false);
	if(isset($_POST[detaller]))
	{
		if(!empty($_POST[detaller]))
		{
			$pdf->SetFont('helvetica','B',10);  //Nuevo
			$pdf->Cell(40,5,'DETALLE REVERSION:',0,0,'L');	 //Nuevo
			$pdf->SetFont('helvetica','',10); //Nuevo
			$pdf->MultiCell(160,2,''.iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[detaller]),0,'L',false,1,'','',true,4,false,true,14,'T',false);	
		}
	}
	$posy=$pdf->GetY();
	$pdf->line(10,$posy+1,209,$posy+1);
	$pdf->ln(2);
	$pdf->SetFont('helvetica','B',10);
	$pdf->Cell(181,5,''.$_POST[beneficiario],0,0,'L');
	$posy=$pdf->GetY();
	$pdf->RoundedRect(10,$posy+1, 199, 5, 1.2,'' );
	$pdf->SetFont('helvetica','B',10);
	$posy=$pdf->GetY();
	$pdf->SetY($posy+1);
	$pdf->Cell(0.1);
	$pdf->Cell(32,5,"CODIGO",0,0,'C'); 
	$pdf->Cell(69,5,'RUBRO',0,0,'C');
	$pdf->Cell(63,5,'RECURSO',0,0,'C');
	$pdf->Cell(35,5,'INGRESOS',0,1,'C');
	$pdf->SetFont('helvetica','I',9);
	$pdf->ln(2);
	//$posy=$pdf->GetY()+$_POST[desplaza];
	//$pdf->SetY(5+$posy);   
	$con=0;
	while ($con<count($_POST[dcuentas]))
	{	
		if ($con%2==0){$pdf->SetFillColor(245,245,245);}
		else{$pdf->SetFillColor(255,255,255);}
		$posy=$pdf->GetY();
		$pdf->Cell(32,4,''.$_POST[dcuentas][$con].$tops,0,0,'L',0);
		$pdf->MultiCell(65,4,iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[dncuentas][$con]),0,'L',false,1,'','',true,4,false,true,19,'T',false);
		$posyc=$pdf->GetY();
		$pdf->SetY($posy);
		$pdf->Cell(99);
		$pdf->Cell(57,4,substr(''.(iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[dfuentes][$con])),0,28),0,0,'L',0);
		$pdf->Cell(43,4,"$ ".number_format($_POST[dgastos][$con],2,$_SESSION["spdecimal"],$_SESSION["spmillares"]),0,0,'R',0);
		$pdf->ln(4);	
		$pdf->SetY($posyc+1);   
		$con=$con+1;
	}	
	$pdf->SetFont('helvetica','B',10);
	$pdf->ln(2);	
	$pdf->SetLineWidth(0.5);
	$pdf->cell(106.8,5,'','T',0,'R');
	$pdf->cell(57,5,'Total','T',0,0,'R');
	$pdf->cell(35,5,'$'.number_format($_POST[cuentagas],2,$_SESSION["spdecimal"],$_SESSION["spmillares"]),'T',0,'R');
	$pdf->SetLineWidth(0.2);	
	$pdf->ln(10);	
	$v=$pdf->gety();
	$pdf->RoundedRect(8, $v-1, 199, 8, 1.2,'' );
	$pdf->MultiCell(199,4,'SON: '.$_POST[letras],0,'L');
	for($x=0;$x<count($_POST[ppto]);$x++)
	{
		$pdf->ln(16);
		$v=$pdf->gety();
		$pdf->setFont('times','B',10);
		$pdf->Line(50,$v,160,$v);
		$pdf->Cell(190,4,''.$_POST[ppto][$x],0,1,'C',false,0,0,false,'T','C');
		$pdf->Cell(190,4,''.iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[nomcargo][$x]),0,0,'C',false,0,0,false,'T','C');
		$pdf->SetFont('helvetica','',7);
	}
	
$pdf->Output('reporterp.pdf', 'I');
?>