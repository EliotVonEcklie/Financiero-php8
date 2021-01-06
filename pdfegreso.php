<?php
	require_once("tcpdf/tcpdf_include.php");
	require('comun.inc');
	require('funciones.inc');
	session_start();
	date_default_timezone_set("America/Bogota");
	$val = 0;
	class MYPDF extends TCPDF 
	{
		public function Header() 
		{
			$linkbd=conectar_bd();
			$sqlr="SELECT nit, razonsocial FROM configbasica WHERE estado='S'";
			$resp=mysql_query($sqlr,$linkbd);
			while($row=mysql_fetch_row($resp)){$nit=$row[0];$rs=utf8_encode(strtoupper($row[1]));}
			$this->Image('imagenes/escudo.jpg', 22, 12, 25, 23.9, 'JPG', '', 'T', true, 300, '', false, false, 0, false, false, false);// Logo
			$this->SetFont('helvetica','B',8);
			$this->SetY(10);
			$this->RoundedRect(10, 10, 199, 31, 2.5,''); //Borde del encabezado
			$this->Cell(48,31,'','R',0,'L'); //Linea que separa el encabazado verticalmente
			$this->SetY(10);
			$this->SetX(58);
			$this->SetFont('helvetica','B',12);
			$this->Cell(142,15,"$rs",0,0,'C'); 
			$this->SetY(16);
			$this->SetX(58);
			$this->SetFont('helvetica','B',11);
			$this->Cell(142,10,"$nit",0,0,'C');
			$this->SetY(27);
			$this->SetX(58);
			$this->Cell(104,14,"COMPROBANTE EGRESO",1,0,'C'); 
			$this->SetFont('helvetica','I',10);
			$this->SetY(27);
			$this->SetX(62);
			$mov='';
			if(isset($_POST['movimiento']))
			{
				if($_POST['movimiento']=='401' || $_POST['movimiento']=='402'){$mov="DOCUMENTO DE REVERSION";}
			}
			$this->SetFont('helvetica','B',10);
			$this->Cell(100,7,$mov,'T',0,'C',false,0,1); 
			$this->SetFont('helvetica','B',9);
			$this->SetY(27);
			$this->SetX(162.5);
			$this->Cell(46,5," NUMERO: ".$_POST[egreso],"T",0,'L');
			$this->SetY(31);
			$this->SetX(162.5);
			$this->Cell(35,6," FECHA: ".$_POST[fecha],0,0,'L');
			$this->SetY(36);
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
			//$this->SetY(-16);
			$this->SetFont('helvetica', 'I', 8);
			$txt = <<<EOD
$vardirec $vartelef
$varemail $varpagiw
EOD;
			$this->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);
			//$this->SetY(-13);
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
	$pdf->SetMargins(10, 101, 10);// set margins
	$pdf->SetHeaderMargin(101);// set margins
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
	$pdf->SetY(46);   
	$pdf->cell(125);
	$pdf->cell(27,8,'NETO A PAGAR: ',0,0,'R');
	$pdf->RoundedRect(161, 46 ,48 , 8, 2,'');
	$pdf->cell(45,8,'$'.number_format($_POST[valorpagar],2),0,'C');

	$pdf->ln(10);

	$pdf->SetFillColor(255,255,255);
	$pdf->cell(0.2);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(35,5,'Beneficiario: ','LT',0,'L',1);
	$pdf->SetFont('helvetica','',10);
	$ntercero = ($val==0) ? utf8_decode($_POST[ntercero]) : iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT", $_POST[ntercero]);
	$pdf->cell(164,5,''.substr(ucwords(strtolower($ntercero)),0,100),'TR',1,'L',0);
	$pdf->cell(0.2);  
	$pdf->SetFillColor(245,245,245);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(35,5,'C.C. o NIT: ','L',0,'L',1);
	$pdf->SetFont('helvetica','',10);
	$pdf->cell(40,5,''.$_POST[tercero],0,0,'L',1);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(35,5,'Cta Beneficiario: ',0,0,'L',1);
	$pdf->SetFont('helvetica','',9);
	$pdf->cell(89,5,$_POST[tercerocta],'R',1,'L',1);
	$pdf->cell(0.2);
	$pdf->MultiCell(199,$altura,"CONCEPTO:  ".iconv($_SESSION["VERCARPDFINI"], $_SESSION["VERCARPDFFIN"]."//TRANSLIT",$_POST[concepto]),'LR','L',true,1,'','',true,0,false,true,$altura,'M',false);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(0.2);
	$pdf->cell(35,5,'No CxP::','L',0,'L',1);
	$pdf->SetFont('helvetica','',10);
	$pdf->cell(40,5,''.$_POST[orden],0,0,'L',1);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(35,5,'FORMA PAGO:',0,0,'L',1);
	$pdf->SetFont('helvetica','',10);
	$pdf->cell(89,5,''.strtoupper($_POST[tipop]),'R',1,'L',1);
	$pdf->SetFillColor(245,245,245);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(0.2);
	$pdf->cell(35,5,'BANCO: ','L',0,'L',1);
	$pdf->SetFont('helvetica','',10);
	$pdf->cell(91,5,''.substr(strtoupper($_POST[nbanco]),0,80),0,0,'L',1);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(15,5,'N Cta.:',0,0,'L',1);
	$pdf->SetFont('helvetica','',10);
	$pdf->cell(58,5,''.$_POST[tcta].' '.$_POST[cb],'R',1,'L',1);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(0.2);
	$pdf->cell(37,5,'CHEQUE/TRANSF.:','L',0,'L',1);
	$pdf->SetFont('helvetica','',10);
	$pdf->cell(162,5,''.$_POST[ntransfe].$_POST[ncheque],'R',1,'L',1);
	$pdf->SetFillColor(245,245,245);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(0.2);
	$pdf->cell(35,5,'Valor Pago:','L',0,'L',1);
	$pdf->SetFont('helvetica','',10);
	$pdf->cell(40,5,'$'.number_format($_POST[valororden],2),0,0,'L',1);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(25,5,'Retenciones: ',0,0,'L',1);
	$pdf->SetFont('helvetica','',10);
	$pdf->cell(35,5,'$'.number_format($_POST[retenciones],2),0,0,'L',1);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(25,5,'Iva: ',0,0,'L',1);
	$pdf->SetFont('helvetica','',10);
	$pdf->cell(39,5,'$'.number_format($_POST[iva],2),'R',1,'L',1);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(0.2);
	$pdf->cell(25,5,'Neto a Pagar:','L',0,'L',1);
	$pdf->SetFont('helvetica','',10);
	$pdf->cell(174,5,'$'.number_format($_POST[valorpagar],2),'R',1,'L',1);
	$pdf->SetFillColor(245,245,245);
	$pdf->SetFont('helvetica','B',10);
	$pdf->cell(0.2);
	$pdf->cell(35,5,'Son: ','LB',0,'L',1);
	$pdf->SetFont('helvetica','',8);
	$pdf->cell(164,5,''.strtoupper($_POST[letras]),'BR',0,'L',1);
	


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
			 $pdf->ln(5); 
 for($x=0;$x<count($_POST[ddescuentos]);$x++)
	 {	
	  if ($con%2==0)
	  {$pdf->SetFillColor(255,255,255);
	  }
      else
	  {$pdf->SetFillColor(245,245,245);
	  }
		$pdf->Cell(22,4,''.$_POST[ddescuentos][$x],'',0,'C',1);
		$pdf->Cell(110,4,''.$_POST[dndescuentos][$x],'',0,'L',1);
		$pdf->Cell(20,4,''.$_POST[dporcentajes][$x].'%','',0,'R',1);		
		$pdf->Cell(47,4,'$'.number_format($_POST[ddesvalores][$x],2),'',1,'R',1);				
		$con=$con+1;
	 }

	
	if(count($_POST[dcuenta])>0){

		$pdf->ln(5);
		$pdf->SetFillColor(222,222,222);
		$pdf->SetFont('helvetica','B',10);
	    $pdf->Cell(0.1);
	    $pdf->Cell(199,5,utf8_decode('AFECTACIÓN PRESUPUESTAL'),0,0,'C',1); 
	    $pdf->ln(6); 
		$pdf->SetFont('helvetica','',10);
		$pdf->Cell(44,6,'CUENTA ',1,0,'C',true,'',0,false,'T','C');
		$pdf->Cell(115,6,utf8_decode('DESCRIPCIÓN '),1,0,'C',true,'',1,false,'T','C');
		$pdf->Cell(40,6,'VALOR ',1,1,'C',true,'',1,false,'T','C');
		$pdf->ln(1);
		$pdf->SetFont('helvetica','I',10);
		$con=0;
		$ltrb = '';
		
		for($i=0;$i<count($_POST[dcuenta]);$i++){
			$gdcuenta[$_POST[dcuenta][$i]][0]=$_POST[dcuenta][$i];
			$gdcuenta[$_POST[dcuenta][$i]][1]=$_POST[ncuenta][$i];
			$gdcuenta[$_POST[dcuenta][$i]][2]=$gdcuenta[$_POST[dcuenta][$i]][2]+str_replace(',','',$_POST[rvalor][$i]);
		}
		
		foreach($gdcuenta as $val){
			if ($con%2==0){
				$pdf->SetFillColor(245,245,245);
			}
	   	 	else{
	   	 		$pdf->SetFillColor(255,255,255);
	   	 	}
			$niy=$pdf->Gety();
	   	 	if($niy >= 269.5) $ltrb = 'B';
	   	 	if($niy >= 275.5) $ltrb = 'T';
			$pdf->Cell(44,6,''.$val[0],'L'.$ltrb,0,'C',true,'',1,false,'T','C');
			$pdf->Cell(115,6,''.$val[1],'L'.$ltrb,0,'L',true,'',1,false,'T','C');
			$pdf->Cell(40,6,''.number_format($val[2],2,".",","),'LR'.$ltrb,1,'R',true,'',1,false,'T','C');
			$ltrb = '';
			
			$con=$con+1; 
		}
		
		if ($con%2==0){
			$pdf->SetFillColor(245,245,245);
		}
		else{
			$pdf->SetFillColor(255,255,255);
		}
		$pdf->Cell(159,6,'Total: ','TLB',0,'R',true,'',1,false,'T','C');
		$pdf->Cell(40,6,''.$_POST[varto],'TLRB',1,'R',true,'',0,false,'T','C');

	}
	
	 
$linkbd = conectar_v7();
$linkbd -> set_charset("utf8");
$sqlr="select id_cargo,id_comprobante from pptofirmas where id_comprobante='11' and vigencia='".$_POST[vigencia]."'";
$res=mysqli_query($linkbd,$sqlr);
while($row=mysqli_fetch_assoc($res))
{
	if($row["id_cargo"]=='0')
	{
		$_POST[ppto][]=buscatercero($_POST[tercero]);
		$_POST[nomcargo][]='BENEFICIARIO';
	}
	else
	{
		$sqlr1="select cedulanit,(select nombrecargo from planaccargos where codcargo='".$row["id_cargo"]."') from planestructura_terceros where codcargo='".$row["id_cargo"]."' and estado='S'";
		$res1=mysqli_query($linkbd,$sqlr1);
		$row1=mysqli_fetch_row($res1);
		$_POST[ppto][]=buscar_empleado($row1[0]);
		$_POST[nomcargo][]=$row1[1];
	}
	
}

for($x=0;$x<count($_POST[ppto]);$x++)
{
	$pdf->ln(14);
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
			$pdf->Cell(104,4,''.$_POST[nomcargo][$x],0,1,'C',false,0,0,false,'T','C');
			$pdf->SetY($v2);
			$pdf->Cell(295,4,''.$_POST[ppto][$x+1],0,1,'C',false,0,0,false,'T','C');
			$pdf->Cell(295,4,''.$_POST[nomcargo][$x+1],0,1,'C',false,0,0,false,'T','C');
		}else{
			$pdf->Line(50,$v,160,$v);
			$pdf->Cell(190,4,''.$_POST[ppto][$x],0,1,'C',false,0,0,false,'T','C');
			$pdf->Cell(190,4,''.$_POST[nomcargo][$x],0,0,'C',false,0,0,false,'T','C');
		}
		$v3=$pdf->gety();
	}
	$pdf->SetY($v3);
	$pdf->SetFont('helvetica','',7);
}

	$pdf->SetFont('times','',10);
		$pdf->cell(25);
	$pdf->Cell(55,4,'',0,1,'L'); 

$pdf->Output();
?>