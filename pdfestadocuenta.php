<?php
require('fpdf.php');
require('comun.inc');
session_start();
date_default_timezone_set("America/Bogota");
//*****las variables con los contenidos***********
//**********pdf*******
//$pdf=new FPDF('P','mm','Letter'); 
class PDF extends FPDF
{
//Cabecera de página
function Header()
{	
$linkbd=conectar_bd();
$sqlr="select *from configbasica where estado='S'";
//echo $sqlr;
$res=mysql_query($sqlr,$linkbd);
while($row=mysql_fetch_row($res))
 {
  $nit=$row[0];
  $rs=$row[1];
 }
$sqlr="select *from interfaz01 ";
//echo $sqlr;
$res=mysql_query($sqlr,$linkbd);
while($row=mysql_fetch_row($res))
 {
  $lemas=$row[0];
  $escentidad=$row[12];
  $escudo=$row[11];
 } 
   //Parte Izquierda
    $this->Image('imagenes/'.$escudo,23,10,25,25);
	$this->SetFont('Arial','B',8);
	$this->Image('imagenes/'.$escentidad.'',180,10,25,25);
	$this->SetFont('Arial','B',8);
	$this->SetY(10);
	$this->RoundedRect(10, 10, 199, 31, 2.5,'' );
	$this->Cell(0.1);
    $this->Cell(50,31,'','R',0,'L'); 
	$this->SetY(31);
    $this->Cell(0.1);
    $this->Cell(50,5,''.$rs,0,0,'C'); 
	$this->SetFont('Arial','B',8);
	$this->SetY(35);
    $this->Cell(0.1);
    $this->Cell(50,5,''.$nit,0,0,'C'); //Cuadro Izquierda
    //*****************************************************************************************************************************
	$this->SetFont('Arial','B',14);
	$this->SetY(10);
    $this->Cell(50.1);
    $this->Cell(149,31,'',0,1,'C'); 
	$this->SetY(10);
    $this->Cell(50.1);
    $this->Cell(111,18,'ESTADO DE CUENTA','R',0,'C'); 
	//************************************
    $this->SetFont('Arial','B',10);	
	$this->SetY(27);
	$this->Cell(50.2);
	$this->multiCell(110.7,7,'"'.$lemas.'"'.$_POST[concepto],'T','C');	
	$this->SetY(27);
    $this->Cell(161.1);
	$this->Cell(37.8,14,'','L',0,'L');	
	$this->SetY(28.5);
    $this->Cell(161);
	$this->Cell(38,5,'','',0,'C');	
	$this->SetY(34.5);
    $this->Cell(161);
	$this->Cell(38,5,''.$_POST[idpredial],'0',0,'C');	
	//$this->SetY(35.5);
    //$this->Cell(162);
	//$this->Cell(35,5,'FECHA: '.$_POST[fecha],0,0,'L');
	$this->SetY(27);
	$this->Cell(50.2);
	$this->MultiCell(105.7,4,'',0,'L');
//********************************************************************************************************************************
//	$this->line(10.1,42,209,42);
//	$this->RoundedRect(10,42.7, 199, 4, 1.2,'' );
	$this->SetFont('times','B',10);
//	$this->SetY(42.5);
 //   $this->Cell(0.1);
//	$this->Cell(199,5,'IDENTIFICACION DEL PREDIO',0,1,'C');    
	//		$this->SetY(48);
     //   	$this->Cell(101);
///			$this->Cell(36,5,'DETALLE',0,1,'C');
//			$this->SetY(48);
//        	$this->Cell(96.5);
//			$this->Cell(5,5,'C.C.',0,1,'C');
//			$this->SetY(48);
 //       	$this->Cell(137);
			
//			$this->Cell(31,5,'DEBITO',0,1,'C');
//			$this->SetY(48);
 //       	$this->Cell(168);
//			$this->Cell(31,5,'CREDITO',0,1,'C');
			//$this->line(10.1,49,209,49);
				$this->ln(2);			
//************************	***********************************************************************************************************
}
//Pie de página
function Footer()
{
   $this->SetY(-15);
	$this->SetFont('Arial','I',10);
	$this->Cell(0,10,'Impreso por: Software SPID - G&C Tecnoinversiones SAS. - Pagina '.$this->PageNo().' de {nb}',0,0,'R'); // el parametro {nb} 
}
}

//Creación del objeto de la clase heredada
//$pdf=new PDF('P','mm',array(210,140));
$pdf=new PDF('P','mm','Letter'); 
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Times','',10);


$pdf->SetAutoPageBreak(true,20);

	$pdf->SetFont('times','B',9);
	$pdf->SetY(43.7);
    $pdf->Cell(0.1);
	$pdf->Cell(33,4,'FECHA IMPRESION:','B',1,'L'); 
	
	$pdf->SetFont('times','',9);
	$pdf->SetY(43.7);
    $pdf->Cell(33.1);
	$pdf->Cell(67,4,''.$_POST[fechaav],'B',1,'L'); 

	$pdf->SetFont('times','B',9);
	$pdf->SetY(43.7);
   	$pdf->Cell(100.1);
	$pdf->Cell(27,4,'','LB',1,'L');

	$pdf->SetFont('times','',9);
	$pdf->SetY(43.7);
    $pdf->Cell(127.1);
	$pdf->Cell(72,4,'','B',1,'L'); 
	
	$pdf->SetFont('times','B',9);
	$pdf->SetY(47.7);
    $pdf->Cell(0.1);
	$pdf->Cell(33,4,'PROPIETARIO:','B',1,'L'); 
	
	$pdf->SetFont('times','',9);
	$pdf->SetY(47.7);
    $pdf->Cell(27.1);
	$otros="";
	if($_POST[tot]>'001')
	$otros=" y OTROS ";
	$pdf->Cell(73,4,''.substr(strtoupper($_POST[ntercero].$otros),0,80),'B',1,'L'); 

	$pdf->SetFont('times','B',9);
	$pdf->SetY(47.7);
   	$pdf->Cell(100.1);
	$pdf->Cell(27,4,'DIRECCION:','LB',1,'L');

	$pdf->SetFont('times','',9);
	$pdf->SetY(47.7);
    $pdf->Cell(122.1);
	$pdf->Cell(77,4,''.substr(strtoupper($_POST[direccion]),0,80),'B',1,'L'); 
		
	$pdf->SetFont('times','B',9);
	$pdf->SetY(51.7);
    $pdf->Cell(0.1);
	$pdf->Cell(38,4,'CEDULA CIUDADANIA:','B',1,'L'); 
	
	$pdf->SetFont('times','',9);
	$pdf->SetY(51.7);
    $pdf->Cell(38.1);
	$pdf->Cell(62,4,''.$_POST[tercero],'B',1,'L'); 

	$pdf->SetFont('times','B',9);
	$pdf->SetY(51.7);
   	$pdf->Cell(100.1);
	$pdf->Cell(27,4,'VEREDA:','LB',1,'L');

	$pdf->SetFont('times','',9);
	$pdf->SetY(51.7);
    $pdf->Cell(117.1);
	$pdf->Cell(82,4,''.$_POST[vereda],'B',1,'L'); 
	
	$pdf->SetFont('times','B',9);
	$pdf->SetY(55.7);
    $pdf->Cell(0.1);
	$pdf->Cell(36.7,4,'CEDULA CATASTRAL:','B',1,'L'); 
	
	$pdf->SetFont('times','',9);
	$pdf->SetY(55.7);
    $pdf->Cell(37.1);
	$pdf->Cell(63,4,''.$_POST[catastral],'B',1,'L'); 

	$pdf->SetFont('times','B',9);
	$pdf->SetY(55.7);
   	$pdf->Cell(100.1);
	$pdf->Cell(12,4,'HA:','LB',1,'L');

	$pdf->SetFont('times','',9);
	$pdf->SetY(55.7);
    $pdf->Cell(112.1);
	$pdf->Cell(20,4,''.$_POST[ha],'B',1,'L'); 
	
	$pdf->SetFont('times','B',9);
	$pdf->SetY(55.7);
   	$pdf->Cell(132.1);
	$pdf->Cell(8,4,'M2:','LB',1,'L');

	$pdf->SetFont('times','',9);
	$pdf->SetY(55.7);
    $pdf->Cell(140.1);
	$pdf->Cell(15,4,''.$_POST[mt2],'B',1,'L'); 
	
	$pdf->SetFont('times','B',9);
	$pdf->SetY(55.7);
   	$pdf->Cell(155.1);
	$pdf->Cell(8,4,'AC:','LB',1,'L');

	$pdf->SetFont('times','',9);
	$pdf->SetY(55.7);
    $pdf->Cell(163.1);
	$pdf->Cell(36,4,''.$_POST[areac],'B',1,'L'); 
	
	
	$pdf->SetFont('times','B',9);
	$pdf->SetY(59.7);
    $pdf->Cell(0.1);
	$pdf->Cell(36.7,4,'AVALUO VIGENTE:','L',1,'L'); 
	
	$pdf->SetFont('times','',9);
	$pdf->SetY(59.7);
    $pdf->Cell(37.1);
	$pdf->Cell(63,4,''.$_POST[avaluo2],'L',1,'L'); 
	
		$pdf->SetFont('times','B',9);
	$pdf->SetY(59.7);
   	$pdf->Cell(100.1);
	$pdf->Cell(8,4,'Tipo:','L',0,'L');
if($_POST[tipop]=='urbano')
 {
  $_POST[nestrato]=$_POST[nestrato];
 }
if($_POST[tipop]=='rural')
 {
   $_POST[nestrato]=$_POST[nrango];
 }

	$pdf->SetFont('times','',9);
	$pdf->SetY(59.7);
    $pdf->Cell(108.1);
	$pdf->Cell(24,4,''.strtoupper($_POST[tipop]),'',0,'L'); 
	
	$pdf->SetFont('times','B',9);
	$pdf->SetY(59.7);
   	$pdf->Cell(132.1);
	$pdf->Cell(8,4,'Estrato:','L',0,'L');

	$pdf->SetFont('times','',9);
	$pdf->SetY(59.7);
    $pdf->Cell(145.1);
	$pdf->Cell(59,4,''.substr($_POST[nestrato],0,40),'',0,'L'); 
	
	
		
	$pdf->SetFont('times','B',9);
	$pdf->SetY(69.7);
	$pdf->SetFillColor(220,220,220);
	$pdf->Cell(199,4,'ESTADO DE CUENTA IMPUESTO PREDIAL','B',0,'C',1);	
	$pdf->SetY(73.7);
	if(count($_POST[dvalorAlumbrado])>0)
	{
		$pdf->Cell(15,4,'A'.utf8_decode('Ñ').'O','BR',0,'C');
		$pdf->Cell(12,4,'TASA','LBR',0,'C');
		$pdf->Cell(22,4,'CAPITAL','LBR',0,'C');
		$pdf->Cell(22,4,'INTERESES','LBR',0,'C');
		$pdf->Cell(22,4,'SOBRETASA','LBR',0,'C');
		$pdf->Cell(22,4,'INT/SOBRET','LBR',0,'C');
		$pdf->Cell(20,4,'BOMBEROS','LBR',0,'C');
		$pdf->Cell(22,4,'ALUMBRADO','LBR',0,'C');
		$pdf->Cell(20,4,'DESCTOS','LBR',0,'C');
		$pdf->Cell(22,4,'TOTAL A'.utf8_decode('Ñ').'O','LB',0,'C');
	}
	else
	{
		$pdf->Cell(25,4,'AVALUO','BR',0,'C');
		$pdf->Cell(10,4,'A'.utf8_decode('Ñ').'O','LBR',0,'C');
		$pdf->Cell(10,4,'TASA','LBR',0,'C');
		$pdf->Cell(22,4,'CAPITAL','LBR',0,'C');
		$pdf->Cell(22,4,'INTERESES','LBR',0,'C');
		$pdf->Cell(22,4,'SOBRETASA','LBR',0,'C');
		$pdf->Cell(20,4,'INT/SOBRET','LBR',0,'C');
		$pdf->Cell(22,4,'BOMBEROS','LBR',0,'C');
		$pdf->Cell(20,4,'DESCTOS','LBR',0,'C');
		$pdf->Cell(26,4,'TOTAL A'.utf8_decode('Ñ').'O','LB',0,'C');
	}
	
	

	$pdf->SetY(77.7);
	for($x=0;$x<count($_POST[dselvigencias]);$x++)
	{	
	 	$cont=0;
	 	while($cont<count($_POST[dvigencias]))
		{
			if($_POST[dvigencias][$cont]==$_POST[dselvigencias][$x])
	 		{
				if(count($_POST[dvalorAlumbrado])>0)
				{
					$interes=$_POST[dinteres1][$cont]+$_POST[dipredial][$cont];
					$pdf->Cell(15,4,''.$_POST[dvigencias][$cont],'BR',0,'C');
				    $pdf->Cell(12,4,''.$_POST[dtasavig][$cont].' xmil','LBR',0,'C');
				    $pdf->Cell(22,4,''.number_format($_POST[dpredial][$cont],2),'LBR',0,'C');
				    $pdf->Cell(22,4,''.number_format($interes,2),'LBR',0,'R');
				    $pdf->Cell(22,4,''.number_format($_POST[dimpuesto2][$cont],2),'LBR',0,'R');
				    $pdf->Cell(22,4,''.number_format($_POST[dinteres2][$cont],2),'LBR',0,'R');
				    $pdf->Cell(20,4,''.number_format($_POST[dimpuesto1][$cont],2),'LBR',0,'R');
				    $pdf->Cell(22,4,''.number_format($_POST[dvalorAlumbrado][$cont],2),'LBR',0,'R');
				    $pdf->Cell(20,4,''.number_format($_POST[ddescuentos][$cont],2),'LBR',0,'R');
				    $pdf->Cell(22,4,''.number_format($_POST[dhavaluos][$x],2),'LB',1,'R');
				}
				else
				{
					$interes=$_POST[dinteres1][$cont]+$_POST[dipredial][$cont];
				    $pdf->Cell(25,4,''.number_format($_POST[dvaloravaluo][$cont],2),'BR',0,'C');
					$pdf->Cell(10,4,''.$_POST[dvigencias][$cont],'LBR',0,'C');
					$pdf->Cell(10,4,''.$_POST[dtasavig][$cont].' xmil','LBR',0,'C');
					$pdf->Cell(22,4,''.number_format($_POST[dpredial][$cont],2),'LBR',0,'R');
					$pdf->Cell(22,4,''.number_format($interes,2),'LBR',0,'R');
					$pdf->Cell(22,4,''.number_format($_POST[dimpuesto2][$cont],2),'LBR',0,'R');
					$pdf->Cell(20,4,''.number_format($_POST[dinteres2][$cont],2),'LBR',0,'R');
					$pdf->Cell(22,4,''.number_format($_POST[dimpuesto1][$cont],2),'LBR',0,'R');
					$pdf->Cell(20,4,''.number_format($_POST[ddescuentos][$cont],2),'LBR',0,'R');
					$pdf->Cell(26,4,''.number_format($_POST[dhavaluos][$x],2),'LB',1,'R');
				}
	 		}
	   		$cont=$cont +1;
	 	}
	}
	 	$cont=0;
while($cont<(6-count($_POST[dselvigencias])))
 {
	if(count($_POST[dvalorAlumbrado])>0)
	{
		$pdf->Cell(15,4,'','BR',0,'C');
		$pdf->Cell(12,4,'','LBR',0,'C');
		$pdf->Cell(22,4,'','LBR',0,'C');
		$pdf->Cell(22,4,'','LBR',0,'C');
		$pdf->Cell(22,4,'','LBR',0,'C');
		$pdf->Cell(22,4,'','LBR',0,'C');
		$pdf->Cell(20,4,'','LBR',0,'C');
		$pdf->Cell(22,4,'','LBR',0,'C');
		$pdf->Cell(20,4,'','LBR',0,'C');
		$pdf->Cell(22,4,'','LB',1,'C');	 
	}
	else
	{
		$pdf->Cell(25,4,'','BR',0,'C');
		$pdf->Cell(10,4,'','LBR',0,'C');
		$pdf->Cell(10,4,'','LBR',0,'C');
		$pdf->Cell(22,4,'','LBR',0,'C');
		$pdf->Cell(22,4,'','LBR',0,'C');
		$pdf->Cell(22,4,'','LBR',0,'C');
		$pdf->Cell(20,4,'','LBR',0,'C');
		$pdf->Cell(22,4,'','LBR',0,'C');
		$pdf->Cell(20,4,'','LBR',0,'C');
		$pdf->Cell(26,4,'','LB',1,'C');
	}
		   	$cont=$cont +1;
 }
			
	$pdf->ln(6);
		$pdf->cell(102);
	$pdf->SetFont('times','B',9);
	$pdf->Cell(20,4,'TOTAL A PAGAR',0,0,'L');
	$pdf->SetFont('times','B',14);
		$pdf->cell(12);
	$pdf->Cell(55,4,'$'.number_format($_POST[totliquida],2),0,1,'L'); 
			
	$y=$pdf->GetY();		
	
	$linkbd=conectar_bd();
	$sqlr="select *from configbasica where estado='S'";
	$res=mysql_query($sqlr,$linkbd);
	while($row=mysql_fetch_row($res))
	{
		$nit=$row[0];
		$rs=$row[1];
	}
	
	$pdf->RoundedRect(10, 43, 199, $y-91, 1.2,'' );
	$y=$pdf->GetY();	
	$pdf->RoundedRect(10, 69, 199, $y-69, 1.2,'' );
	$pdf->ln(70);
	$pdf->SetFont('Times','',12);
	$pdf->MultiCell(190,4,utf8_decode("Señor contribuyente, la alcaldía del ".ucwords(strtolower($rs))." lo invita a pagar su impuesto predial. Recuerde que para realizar su pago, deben acercarse a la secretaría de hacienda municipal y reclamar la liquidación correspondiente.
	
	'Evitese sanciones y embargos'."),0,'C');

	//$pdf->multicell(199,4,'Contra la presente liquidaci'.utf8_decode(ó).'n procede el recurso de reconsideraci'.utf8_decode(ó).'n dentro de los dos (2) meses siguientes a su notificaci'.utf8_decode(ó).'n',0);
	//$pdf->multicell(199,4,'Consignar a la Cuenta Corriente 04523000012-2 Banco Agrario. Nota: El Valor a Pagar Aplica a La Fecha del Estado de Cuenta',0);
$pdf->Output();
?>