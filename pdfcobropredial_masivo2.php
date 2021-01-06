<?php

require('fpdf.php');
require('comun.inc');
require('funciones.inc');
require "conversor.php";
ini_set("max-execution-time",9000000000);
ini_set('memory_limit', 51200000000);
//session_start();
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
			$res=mysql_query($sqlr,$linkbd);
			while($row=mysql_fetch_row($res))
			{
			  $nit=$row[0];
			  $rs=$row[1];
			  $nalca=$row[6];
			}
		     //Parte Izquierda
			$this->Image('imagenes/marca1.jpg' , 18 ,70, 180 , 240,'JPG');
			$this->Image('imagenes/marca2.jpg' , 2 ,305, 213 ,20,'JPG');
		    $this->Image('imagenes/eng.jpg',23,13,25,25);
			$this->SetFont('Arial','B',10);
			$this->SetY(10);
			$this->RoundedRect(10, 10, 199, 31, 1.5,'' );
			$this->Cell(0.1);
		    $this->Cell(50,31,'','R',0,'L'); 
			

		    //*****************************************************************************************************************************
			$this->SetFont('Arial','B',14);
			$this->SetY(10);
			$this->Cell(40);
		    $this->Cell(149,31,'',0,1,''); 
			$this->SetY(8);
		    $this->Cell(40);
		    $this->Cell(110,20,'ALCALDIA MUNICIPAL',0,0,'C');
			$this->SetY(10);
		    $this->Cell(40);
		    $this->Cell(110,25,''.$rs,0,0,'C');
			$this->SetY(10);
		    $this->Cell(40);
			$this->SetFont('Arial','B',12);
		    $this->Cell(110,38,'NIT: '.$nit,0,0,'C');
			 
			//************************************
		    	
			#lineas verticales **************
			$this->SetY(10);
		    $this->Cell(135.1);
			$this->Cell(5,31,'','R',0,'L');
			
			$this->SetY(10);
		    $this->Cell(165.1);
			$this->Cell(5,31,'','R',0,'L');
			//*******************************
			
			#lineas Horizontales **************
			$this->SetY(20.75);
		    $this->Cell(140.5);
			$this->Cell(58.5,31,'','T',0,'L');
			
			$this->SetY(31.5);
		    $this->Cell(140.5);
			$this->Cell(58.5,31,'','T',0,'L');
			
			
			//*******************************
			
			#Textos Horizontales 1 **************
			$this->SetFont('Arial','',10);
			
			$this->SetY(13);
		    $this->Cell(135);
			$this->Cell(38,5,utf8_decode('Código'),0,0,'C');
			
			$this->SetY(24);
		    $this->Cell(135);
			$this->Cell(38,5,'TRD',0,0,'C');
			
			$this->SetY(33.75);
		    $this->Cell(135);
			$this->Cell(38,5,utf8_decode('Versión'),0,0,'C');
			
			//*******************************
			
			#Textos Horizontales 2 **************			
			$this->SetY(13);
		    $this->Cell(165);
			$this->Cell(38,5,'D.A 2000',0,0,'C');
			
			$this->SetY(24);
		    $this->Cell(165);
			$this->Cell(38,5,'',0,0,'C');
			
			$this->SetY(33.75);
		    $this->Cell(165);
			$this->Cell(38,5,'01',0,0,'C');
			
			
			$this->ln(5);
			
			

			//************************************

			$this->SetY(27);
			$this->Cell(50.2);

			$this->MultiCell(105.7,4,'',0,'L');		
			

			
		//********************************************************************************************************************************

			$this->SetFont('times','B',10);

						$this->ln(2);
						
					
	//************************	***********************************************************************************************************
	}
	

	//Pie de página
	function Footer()
	{

		$linkbd=conectar_bd();
		$sql="SELECT planacareas_info.correo FROM planacareas_info,planacareas WHERE planacareas_info.codarea=planacareas.codarea AND planacareas.nombrearea LIKE '%SECRETARI_ DE HACIENDA%' AND planacareas.estado='S' ";
		$res=mysql_query($sql,$linkbd);
		$correo=mysql_fetch_row($res);
		$sql="SELECT web,direccion,telefono FROM configbasica";
		$res=mysql_query($sql,$linkbd);
		$datBasicos=mysql_fetch_row($res);
		$sql2="SELECT lema FROM interfaz01";
		$res2=mysql_query($sql2,$linkbd);
		$lema=mysql_fetch_row($res2);
		
	    $this->SetY(-35);
		$this->SetFont('Arial','BI',14);
		$this->Cell(0,10,'"'.$lema[0].'"',0,0,'C');
		$this->SetFont('Arial','I',10);
		$this->ln(5);
		$this->Cell(0,10,''.utf8_decode($datBasicos[1]),0,0,'C');
		$this->ln(5);
		$this->Cell(0,10,'Telefono '.$datBasicos[2],0,0,'C'); 
		$this->ln(5);
		$this->Cell(0,10,utf8_decode('Página Web: '.strtolower($datBasicos[0])),0,0,'C');
		$this->ln(5);
		$this->Cell(0,10,'E-mail: '.$correo[0],0,0,'C');
		
	}
}

//Creación del objeto de la clase heredada
//$pdf=new PDF('P','mm',array(210,140));
$pdf=new PDF('P','mm','Legal');
$pdf->AliasNbPages();
$linkbd=conectar_bd();
$dvigencias=array();
$dcodcatas=array();
$dpredial=array();
$dipredial=array();
$dimpuesto1=array();
$dinteres1=array();
$dimpuesto2=array();
$dinteres2=array();
$ddescuentos=array();
$dtasavig=array();
$dvaloravaluo=array();
$numresolucion=array();
$fecha=Array();
$totalpagar=array();
	if ($_POST[nombre]!="")
			$crit1="and codcatastral LIKE '%$_POST[nombre]%'";
	if($_POST[numresolucion]!=""){
			$crit2="and numresolucion='$_POST[numresolucion]'";
		}
	if($_POST[numbusqueda]!=""){
			$crit3="and idconsulta='$_POST[numbusqueda]'";
		}
$sql="select *from tesocobroreporte where idtesoreporte>-1 $crit1 $crit2 $crit3 ";
$result = mysql_query($sql,$linkbd);
$i=0;
while($row=mysql_fetch_array($result)){
	$dvigencias[$i]=$row[2];
	$dcodcatas[$i]=$row[3];
	$dpredial[$i]=$row[4];
	$dipredial[$i]=$row[5];
	$dimpuesto1[$i]=$row[6];
	$dinteres1[$i]=$row[7];
	$dimpuesto2[$i]=$row[8];
	$dinteres2[$i]=$row[9];
	$ddescuentos[$i]=$row[10];
	$dtasavig[$i]=$row[14];
	$dvaloravaluo[$i]=$row[15];
	$numresolucion[$i]=$row[16];
	$totalpagar[$i]=$row[12];
	$totage[$i]=$row[12];
	$fecharesolucion[$i]=$row[17];
	$i++;
}
//$pdf->AddPage();
//$disc=0;
$linkbd=conectar_bd();
$sqlr="select *from configbasica where estado='S'";
$res=mysql_query($sqlr,$linkbd);
while($row=mysql_fetch_row($res))
{
  $nit=$row[0];
  $rs=$row[1];
  $nalca=$row[6];
}
$linkbd=conectar_bd();
$nr=selconsecutivo('tesocobroreportepdf','numresolucion');
$fecharesol=date('Y-m-d');

$disc=count($dcodcatas);
$nuevo="";
$actual="";
for($v=0;$v<$disc;$v++)
{
	if($nuevo=="")
	{
		//$actual=$_POST[vigencias][$v];
	$nuevo=1;
	}
	
	if($dcodcatas[$v]!=$actual)
	{

		$pdf->AddPage();
		$direccion="";
		$tercero="";
		$ntercero="";

		$sqlr2="select tl.fecha, tp.* from tesopredios AS tp, tesocobroreporte AS tl where tp.cedulacatastral='".$dcodcatas[$v]."' and tp.cedulacatastral=tl.codcatastral and tp.estado='S'";
		$res2=mysql_query($sqlr2,$linkbd);
		while($row2=mysql_fetch_row($res2))
		{
			$fecha=$row2[0];
			$direccion=$row2[8];
			$tercero=$row2[6];
			$ntercero=$row2[7];
			$ha=$row2[9];
			$m2=$row2[10];
			$ac=$row2[11];
			
 		}
		
		$actual=$dcodcatas[$v];
		$cont=$v;
		$igual=1;
		$totdeuda=0;
		while($igual==1)
	 	{	
	 		if($dcodcatas[$v]==$dcodcatas[$cont])
	 		{
				$totdeuda+=$totage[$cont];
				$cont+=1;
			}
			else
			{
			$igual=0;
	 		}
	 	}
		
		
		$posy=$pdf->GetY();
		$pdf->SetY($posy+10);
		$pdf->Cell(0.5);
		$pdf->SetFont('Arial','B',10);		
		$pdf->MultiCell(195,7,'FACTURA No. '.$numresolucion[$v].' - '.date('Y'),0,'C'); 
		$pdf->MultiCell(195,8,utf8_decode('DETERMINACION DEL IMPUESTO PREDIAL UNIFICADO - ACTO DE LIQUIDACION OFICIAL TESORERIA MUNICIPAL '.strtoupper($rs)),0,'C');
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(195,4,utf8_decode('La Tesorera del '.$rs.' , en uso de sus facultades legales y especialmente las conferidas en el Art.66 Ley 383 de 1997; Art.59 Ley 788 de 2002; Acuerdo 0003 de Mayo 30 de 2014, Estatuto Tributario Municipal profiere el presente acto de liquidación del Impuesto Predial Unificado, tasas y sobretasas, con relación al predio identificado con cedula catastral No.'.$dcodcatas[$v].'denominado y/o ubicado en '.strtoupper($direccion).' zona URBANO, del '.$rs.', y con cargo al contribuyente '.$ntercero.' identificado con la C.C./Nit. No.'.$tercero.' y/o actual propietario o poseedor del predio referido, deuda que equivale a la suma de '.convertir($totdeuda).' PESOS ($ '.number_format($totdeuda).'.oo), discriminados en los siguientes de los siguientes periodos gravables y conceptos que permiten calcular el monto de la obligación, así:'),0,'J');	
		
		//********************************************************************************************************************************
		
		//1º cuadro *************************************************************************************************
		
		$pdf->ln(5);
		$pdf->RoundedRect(10, 100, 199, 24, 0.5, '1111', '');
		$pdf->SetFont('Arial','',8);
		$pdf->SetY(102);
		$pdf->Cell(50,4,utf8_decode('CÉDULA CATASTRAL'),0,0,'L');
		$pdf->Line(58,100,58,112);
		$pdf->Cell(90,4,utf8_decode('DIRECCIÓN'),0,0,'L');
		$pdf->Line(148,100,148,124);
		$pdf->Cell(50,4,utf8_decode('VEREDA'),0,0,'L');
		$pdf->SetY(107);
		$pdf->Cell(50,4,$dcodcatas[$v],0,0,'L');
		$pdf->Cell(90,4,substr(strtoupper($direccion),0,80),0,0,'L');
		$pdf->Cell(50,4,'',0,0,'L');
		$pdf->Line(10,112,209,112);
		$pdf->SetY(113);
		$pdf->Cell(80,4,utf8_decode('NOMBRE'),0,0,'L');
		$pdf->Line(88,112,88,124);
		$pdf->Cell(30,4,utf8_decode('CÉDULA / NIT'),0,0,'L');
		$pdf->Line(118,112,118,124);
		$pdf->Cell(10,4,utf8_decode('HA'),0,0,'L');
		$pdf->Line(128,112,128,124);
		$pdf->Cell(10,4,utf8_decode('M2'),0,0,'L');
		$pdf->Line(138,112,138,124);
		$pdf->Cell(10,4,utf8_decode('AC'),0,0,'L');
		$pdf->Cell(50,4,utf8_decode('FECHA DE LIQUIDACIÓN'),0,0,'L');
		$pdf->SetY(119);
		$pdf->Cell(80,4,utf8_decode(substr(strtoupper($ntercero),0,50)),0,0,'L');
		$pdf->Cell(30,4,$tercero,0,0,'L');
		$pdf->Cell(10,4,$ha,0,0,'L');
		$pdf->Cell(10,4,$m2,0,0,'L');
		$pdf->Cell(10,4,$ac,0,0,'L');
		$pdf->Cell(50,4,$fecha,0,0,'L');
		
		//************************************************************************************
		
		// 2º Tabla **************************************************************************
		$dcodcatas1=$dcodcatas[$v];
		$cont=$v;
				
		$pdf->SetFont('Arial','',6);
		$pdf->SetY(125);
		$pdf->SetX(10.6);
		$pdf->SetFillColor(150,150,150);
		$pdf->SetTextColor(255,255,255);
		$pdf->Cell(197.7,5,'',0,0,'C',1);
		//HORIZONTAL
		//$pdf->Line(10,115,209,115);
		//VERTICAL
		//$pdf->Line(20,108,20,168);
		//$pdf->Line(35,108,35,168);
		//$pdf->Line(60,108,60,168);
		//$pdf->Line(70,108,70,168);
		//$pdf->Line(95,108,95,168);
		//$pdf->Line(111,108,111,168);
		//$pdf->Line(127,108,127,168);
		//$pdf->Line(143,108,143,168);
		//$pdf->Line(159,108,159,168);
		//$pdf->Line(175,108,175,168);
		$pdf->SetY(125.5);
		$pdf->Cell(10,4,utf8_decode('AÑO'),0,0,'C');
		$pdf->Cell(15,4,utf8_decode('CONCEPTO'),0,0,'C');
		$pdf->Cell(25,4,utf8_decode('AVALÚO'),0,0,'C');
		$pdf->Cell(10,4,utf8_decode('TASA'),0,0,'C');
		$pdf->Cell(25,4,utf8_decode('IMPUESTO'),0,0,'C');
		$pdf->Cell(16,4,utf8_decode('INTERESES'),0,0,'C');
		$pdf->Cell(16,4,utf8_decode('SOBRETASA'),0,0,'C');
		$pdf->Cell(16,4,utf8_decode('INT/SOBRET'),0,0,'C');
		$pdf->Cell(16,4,utf8_decode('BOMBEROS'),0,0,'C');
		$pdf->Cell(16,4,utf8_decode('DESCUENTO'),0,0,'C');
		$pdf->Cell(25,4,utf8_decode('VALOR TOTAL'),0,0,'C');
		$pdf->SetTextColor(0,0,0);
		$pdf->RoundedRect(10, 124, 199,6.5, 0.5, '1111', '');
		
		
		//************************************************************************************
		$posy=$pdf->GetY();
		$pdf->SetY($posy+5);
		$igual=1;
		while($igual==1)
		{	
	 		if($dcodcatas[$v]==$dcodcatas[$cont])
			{
				$interes=$dinteres1[$cont]+$dipredial[$cont];
				$pdf->Cell(10,4,''.$dvigencias[$cont],'RL',0,'C'); //1
				$pdf->Cell(15,4,utf8_encode('PREDIAL'),'R',0,'C'); //2
				$pdf->Cell(25,4,''.number_format($dvaloravaluo[$cont],2),'R',0,'C'); //3
				$pdf->Cell(10,4,''.$dtasavig[$cont].' xmil','R',0,'C');//4
				$pdf->Cell(24,4,''.number_format($dpredial[$cont],2),'R',0,'C');//CAPITAL
				$pdf->Cell(18,4,''.number_format($interes,2),'R',0,'C');//6
				$pdf->Cell(14,4,''.number_format($dimpuesto2[$cont],2),'R',0,'C');//7
				$pdf->Cell(18,4,''.number_format($dinteres2[$cont],2),'R',0,'C');//8
				$pdf->Cell(14,4,''.number_format($dimpuesto1[$cont],2),'R',0,'C');//9
				$pdf->Cell(17,4,''.number_format($ddescuentos[$cont],2),'R',0,'C');//11
				$pdf->Cell(34,4,''.number_format($totalpagar[$cont],2),'R',1,'C');//12

				$dvaloravaluo1=$dvaloravaluo[$cont];
				$dvigencias1=$dvigencias[$cont];
				$dtasavig1=$dtasavig[$cont];
				$dpredial1=$dpredial[$cont];

				$dimpuesto21=$dimpuesto2[$cont];
				$dinteres21=$dinteres2[$cont];
				$dimpuesto11=$dimpuesto1[$cont];
				$ddescuentos1=$ddescuentos[$cont];

				$cont+=1;

	 		}
	 		else
	 		{
				$igual=0;
	 		}
		}
		$posy2=$pdf->GetY();
		$pdf->Line(10,$posy2,209,$posy2);
		$sqlr="select *from  tesoparametros where estado='S'";
		//echo $sqlr;
		$res=mysql_query($sqlr,$linkbd);

		while($row=mysql_fetch_row($res))
 		{
			//$ppto=$row[0];
			$teso=$row[4];
 		}
		
		$posy2=$pdf->GetY();
		$pdf->SetY($posy2+5);
		$pdf->SetFont('Arial','B',10);
		$pdf->MultiCell(195,8,utf8_decode('RECURSOS'),0,'C');
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(195,4,utf8_decode('Contra la presente Liquidación Oficial procede el Recurso de Reconsideración, el cual deberá interponerse ante el Alcalde Municipal, dentro de los dos (2) meses siguientes a la notificación del presente acto, en virtud de los Artículos 343 y siguientes del Acuerdo Municipal No.0003 de 2014.Una vez en firme el presente acto administrativo presta merito ejecutivo.'),0,'J');
		$pdf->SetFont('Arial','B',10);
		$pdf->MultiCell(195,8,utf8_decode('CONSTANCIA DE NOTIFICACION'),0,'C');
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(195,4,utf8_decode('La notificación de la factura se realizará mediante inserción en la página web de la Alcaldía del '.$rs.' '.strtolower($datBasicos[0]).' y, simultáneamente con la publicación en medios físicos en el registro, cartelera o lugar visible de la Secretaria Administrativa y Financiera -Tesorería Municipal- Alcaldía conforme al artículo No.354 Ley 1819 de 2016 y articulo No.5 Acuerdo Municipal No.017 de 2017.'),0,'J');
		$pdf->MultiCell(195,4,'',0,0,'');
		$pdf->MultiCell(195,4,utf8_decode('Los intereses de mora se liquidarán hasta el momento del pago total, calculados de conformidad con las normas legales vigentes.'),0,'J');
		$pdf->MultiCell(195,4,'',0,0,'');
		$pdf->MultiCell(195,4,utf8_decode('De conformidad con el decreto 2150 de 1995, la firma mecánica aquí plasmada tiene validez para todos los efectos legales.'),0,'J');
		$pdf->MultiCell(195,4,'',0,0,'');
		$pdf->MultiCell(195,4,utf8_decode('Dada en '.$rs.' a los '.strtoupper(convertir(date('d'))).' ('.(date('d')).') días del mes de '.(strftime('%B')).' de '.strtoupper(convertir(date('Y'))).' ('.(date('Y')).').'),0,'J');
		$pdf->SetFont('Arial','B',10);		
		$pdf->MultiCell(200,4," \n \n NOTIFIQUESE Y CUMPLASE  \n ",0,'C');	
		$pdf->SetFont('Times','B',9);
		$pdf->MultiCell(200,4," \n ".utf8_decode(strtoupper($teso))." \n TESORERA MUNICIPAL",0,'C');	
		//$pdf->ln(4);
		$pdf->SetFont('times','',8);
	//$pdf->multicell(199,4,'* Contra la presente liquidaci'.utf8_decode(ó).'n procede el recurso de reconsideraci'.utf8_decode(ó).'n dentro de los dos (2) meses siguientes a su notificaci'.utf8_decode(ó).'n',0);
		

	$nr=$nr+1;
	}//fin de if



}//**fin de for

$pdf->Output();
?>