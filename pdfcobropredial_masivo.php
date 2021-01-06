<?php
require('fpdf.php');
require('comun.inc');
require('funciones.inc');
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
		    $this->Image('imagenes/eng.jpg',23,10,25,25);
			$this->SetFont('Arial','B',10);
			$this->SetY(10);
			$this->RoundedRect(10, 10, 199, 31, 1.5,'' );
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

			$this->SetY(8);
		    $this->Cell(50.1);
		    $this->Cell(149,20,'LIQUIDACION OFICIAL DE IMPUESTO PREDIAL UNIFICADO',0,0,'C'); 
			//************************************
		    $this->SetFont('Arial','B',10);
			
			$this->SetY(27);
		    $this->Cell(161.1);
			$this->Cell(37.8,14,'','TL',0,'L');
			
			$this->SetY(28.5);
		    $this->Cell(161);
			$this->Cell(38,5,'FECHA','B',0,'C');
			
			$this->SetY(34.5);
		    $this->Cell(161);
			$this->Cell(38,5,'  '.date('d-m-Y'),'0',0,'C');


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
	    $this->SetY(-17);
		$this->SetFont('Arial','I',10);
		$this->Cell(0,10,' URL '.$datBasicos[0].' / e-mail: '.$correo[0],0,0,'C'); 
		$this->ln(5);
		$this->Cell(0,10,' '.$datBasicos[1].' / Cel. '.$datBasicos[2],0,0,'C'); 
		
	}
}

//Creación del objeto de la clase heredada
//$pdf=new PDF('P','mm',array(210,140));
$pdf=new PDF('P','mm','Legal'); 

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
		
		$sqlr="select *from tesopredios where cedulacatastral='".$dcodcatas[$v]."' and estado='S'";
		//echo $sqlr;
		$res=mysql_query($sqlr,$linkbd);
		while($row=mysql_fetch_row($res))
		{
			$direccion=$row[7];
			$tercero=$row[5];
			$ntercero=$row[6];
			
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
		$pdf->SetFont('Times','B',10);
		$pdf->SetY(27);
		$pdf->Cell(50.2);
		$pdf->multiCell(110.7,7,'RESOLUCION No '.$numresolucion[$v].' DE '.$fecharesolucion[$v],'T','L');
			
		$posy=$pdf->GetY();
    	$pdf->SetY($posy+10);
		$pdf->Cell(1);
		$pdf->SetFont('Times','',10);
		$pdf->MultiCell(195,4,utf8_decode('Por medio de la cual se determina una obligación a cargo del propietario o poseedor actual del predio con Cedula Catastral No. '.$dcodcatas[$v].', ubicado en la siguiente dirección '.$direccion.', que aparece actualmente en la base catastral del Instituto Geografico Agustin Codazzi como propiedad de: '.$ntercero.'.El suscrito secretario de Hacienda Municipal, en uso de sus facultades legales, en especial de las conferidas por el Art. 422  Del Estatuto de Rentas Municipal, acuerdo 018 de Diciembre de 2016 y'),0,'J');		
		$pdf->Cell(1);
		$pdf->SetFont('Times','B',10);
		$pdf->MultiCell(200,4,"CONSIDERANDO \n ",0,'C');	
		$pdf->SetFont('Times','',10);
		$pdf->MultiCell(195,4,utf8_decode('Que conforme a la liquidación que se detalla en la parte resolutiva de esta resolución, el propietario o poseedor del predio identificado con la cedula catastral No. '.$dcodcatas[$v].', adeuda al '.$rs.' (Meta) por concepto de Impuesto Predial Unificado, Sobretasa Bomberil y Sobretasa Ambiental, la suma de ($'.number_format($totdeuda,2,",",".").'), correspondiente al capital de las vigencias que se detallan, mas los intereses que se causen hasta el momento en que se haga efectivo el pago total de la obligación.'),0,'J');	
		$pdf->MultiCell(195,4,utf8_decode('Que el Articulo 34 del Acuerdo 018 de 2016, establece: "CAUSACIÓN DEL IMPUESTO PREDIAL.  El impuesto predial se causa el primero (1) de enero del respectivo período fiscal. En el '.$rs.' (Meta) su liquidación será anual y vencidos los plazos establecidos en el presente Estatuto, se empezará a cobrar el interés moratorio diario legal vigente, estipulado por  la Superintendencia Financiera, en cumplimiento de la Ley 1066 de 2006 o las normas que la modifiquen o adicionen".'),0,'J');	
		$pdf->MultiCell(195,4,utf8_decode("Que la administración Municipal estableció los plazos para pagar las vigencias antes señaladas, y el contribuyente incumplió con su obligación tributaria de hacerlo."),0,'J');
		$pdf->Cell(195,4,utf8_decode("Que de conformidad con lo anterior, las vigencias antes indicadas son exigibles por parte de la administración."),0,1); 
		$pdf->MultiCell(195,4,utf8_decode("Que para efectuar la determinacion de la obligacion se toma como base el avaluo catastral determinado por el Instituto Geografico Agustin Codazzi - IGAC, de conformidad con lo dispuesto en el articulo 34 y el articulo 50 del Estatuto de Rentas Municipal  y demas normas concordantes."),0,'J');
		$pdf->MultiCell(195,4,'Que con fundamento en lo previsto en el articulo 48 del Estatuto de Rentas Municipal, las tarifas del Impuesto Predial Unificado se aplicaran de conformidad con la estratificación adoptada por el municipio establecida en el mismo cuerpo normativo.',0,'J');
		$pdf->MultiCell(195,4,utf8_decode("En mérito de lo anteriormente expuesto, este despacho, \n \n"),0,'J');	
		$pdf->SetFont('Times','B',10);
		$pdf->MultiCell(195,4,"\nRESUELVE  \n",0,'L');	
		$pdf->SetFont('Times','',10);
		$pdf->MultiCell(195,4,utf8_decode("\nPRIMERO - DETERMINAR a cargo de ".$ntercero.", o de quien sea que ostente a la fecha la calidad propietario o poseedor este o no inscrito en la base catastral del Instituto Geografico Agustin Codazzi, y por ende sujeta pasivo del Impuesto Predial, del Predio identificado con referencia catastral No ".$dcodcatas[$v].", la obligación de pagar a favor del ".$rs." (Meta), la suma de ($ ".number_format($totdeuda,2,',','.')."), correspondiente al capital adeudado por concepto de Impuesto Predial Unificado, Sobretasa Bomberil y Sobretasa Ambiental, según liquidación que se detalla a continuación, mas los intereses que se causen desde que se hizo exigible hasta el momento en que se haga efectivo el pago total de la obligación:"),0,'J');
		$dcodcatas1=$dcodcatas[$v];
		$cont=$v;

		$pdf->SetFont('Times','B',10);
			
		$posy=$pdf->GetY();
	    $pdf->SetY($posy+10);
		$pdf->SetFont('times','B',9);
		$pdf->SetY($posy+5);
		$pdf->SetFillColor(220,220,220);
		$pdf->Cell(199,4,'LIQUIDACION IMPUESTO PREDIAL','TLBR',0,'C');		
		//	$pdf->ln(4);
		$posy=$pdf->GetY();
		$pdf->SetY($posy+5); 
		//	$pdf->Cell(1);	
		$pdf->Cell(25,4,'AVALUO','LBR',0,'C');
		$pdf->Cell(10,4,'A'.utf8_decode('Ñ').'O','LBR',0,'C');
		$pdf->Cell(10,4,'TASA','LBR',0,'C');
		$pdf->Cell(22,4,'CAPITAL','LBR',0,'C');
		$pdf->Cell(22,4,'INTERESES','LBR',0,'C');
		$pdf->Cell(22,4,'SOBRETASA','LBR',0,'C');
		$pdf->Cell(20,4,'INT/SOBRET','LBR',0,'C');
		$pdf->Cell(22,4,'BOMBEROS','LBR',0,'C');
		$pdf->Cell(20,4,'DESCTOS','LBR',0,'C');
		$pdf->Cell(26,4,'TOTAL A'.utf8_decode('Ñ').'O','LBR',0,'C');
		$posy=$pdf->GetY();
		$pdf->SetY($posy+5);
		$igual=1;
		while($igual==1)
		{	
	 		if($dcodcatas[$v]==$dcodcatas[$cont])
			{
				$interes=$dinteres1[$cont]+$dipredial[$cont];
				$pdf->Cell(25,4,''.number_format($dvaloravaluo[$cont],2),'LBR',0,'C');
				$pdf->Cell(10,4,''.$dvigencias[$cont],'LBR',0,'C');
				$pdf->Cell(10,4,''.$dtasavig[$cont].' xmil','LBR',0,'C');
				$pdf->Cell(22,4,''.number_format($dpredial[$cont],2),'LBR',0,'R');
				$pdf->Cell(22,4,''.number_format($interes,2),'LBR',0,'R');
				$pdf->Cell(22,4,''.number_format($dimpuesto2[$cont],2),'LBR',0,'R');
				$pdf->Cell(20,4,''.number_format($dinteres2[$cont],2),'LBR',0,'R');
				$pdf->Cell(22,4,''.number_format($dimpuesto1[$cont],2),'LBR',0,'R');
				$pdf->Cell(20,4,''.number_format($ddescuentos[$cont],2),'LBR',0,'R');
				$pdf->Cell(26,4,''.number_format($totalpagar[$cont],2),'LBR',1,'R');

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

		$sqlr="select *from  tesoparametros where estado='S'";
		//echo $sqlr;
		$res=mysql_query($sqlr,$linkbd);

		while($row=mysql_fetch_row($res))
 		{
			//$ppto=$row[0];
			$teso=$row[4];
 		}
		$pdf->SetFont('Times','',10);
		$pdf->MultiCell(195,4,utf8_decode("\nSEGUNDO: Por lo anterior, solicito a usted que dentro de los diez (10) días siguientes a la fecha de la presente liquidación, se acerque a este Despacho a efectuar el pago correspondiente o a suscribir acuerdo de pago, en caso contrario la administración Municipal se ve obligada a iniciar proceso de ejecución coactiva.\nTERCERO: Contra la presente resolución procede el recurso de reconsideración, el cual deberá interponerse ante la secretaria de Hacienda Municipal dentro de los dos(2) meses siguientes a su notificación. 
CUARTO: Una vez ejecutoriada la presente resolución, constituirá titulo ejecutivo en contra del sujeto pasivo del impuesto predial unificado, conforme a lo dispuesto en el numeral primero de la parte resolutiva de la presente resolución y en contra de sus herederos o legatarios.
QUINTO: NOTIFICASE de conformidad con lo dispuesto en los artículos 431 y subsiguientes del Estatuto Tributario Municipal.
"),0,'J');	
		$pdf->SetFont('Times','B',10);
		$pdf->MultiCell(200,4," \n \n \n NOTIFIQUESE Y CUMPLASE  \n \n ",0,'L');	
		$pdf->SetFont('Times','B',10);
		$pdf->ln(12);
		$pdf->MultiCell(200,4," \n ".strtoupper($teso)." \n SECRETARIA HACIENDA MUNICIPAL",0,'C');	
		//$pdf->ln(4);
		$pdf->SetFont('times','',8);
		$posy3=$pdf->GetY();
		$pdf->Image('imagenes/firma_jein.jpg' , 80 ,$posy3-40, 60 ,30,'jpg');
	//$pdf->multicell(199,4,'* Contra la presente liquidaci'.utf8_decode(ó).'n procede el recurso de reconsideraci'.utf8_decode(ó).'n dentro de los dos (2) meses siguientes a su notificaci'.utf8_decode(ó).'n',0);
		

	$nr=$nr+1;
	}//fin de if



}//**fin de for

$pdf->Output();
?>