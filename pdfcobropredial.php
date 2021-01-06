<?php
//V 1000 12/12/16 
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
/*$linkbd=conectar_bd();
$sqlr="select *from configbasica where estado='S'";
//echo $sqlr;
$res=mysql_query($sqlr,$linkbd);
while($row=mysql_fetch_row($res))
 {
  $nit=$row[0];
  $rs=$row[1];
 }*/
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
	$this->Cell(38,5,'NUMERO','B',0,'C');
	
	$this->SetY(34.5);
    $this->Cell(161);
	$this->Cell(38,5,''.$_POST[numpredial],'0',0,'C');
	
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
	$this->Cell(0,10,'Pagina '.$this->PageNo().' de {nb}',0,0,'R'); // el parametro {nb} 
	
}
}

//Creación del objeto de la clase heredada
//$pdf=new PDF('P','mm',array(210,140));
$pdf=new PDF('P','mm','Legal'); 
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetAutoPageBreak(true,20);
$pdf->SetFont('Times','B',10);
	$pdf->SetY(27);
	$pdf->Cell(50.2);
	$pdf->multiCell(110.7,7,'RESOLUCION No '.$_POST[numpredial].' DE '.$_POST[fecha],'T','L');
$posy=$pdf->GetY();
    $pdf->SetY($posy+10);
	$pdf->Cell(1);
$pdf->SetFont('Times','',10);
	$pdf->MultiCell(195,4,utf8_decode('Por medio de la cual se determina una obligación a cargo del propietario o poseedor actual del predio con Cedula Catastral No. '. $_POST[codcat].', ubicado en la siguiente dirección '.$_POST[direccion].', que aparece actualmente en la base catastral del Instituto Geografico Agustin Codazzi como propiedad de: '.$_POST[ntercero].'.El suscrito secretario de Hacienda Municipal, en uso de sus facultades legales, en especial de las conferidas por el Art. 368  Del Estatuto de Rentas Municipal, acuerdo 024 de Diciembre de 2010 y'),0,'J');		
	$pdf->Cell(1);
	$pdf->SetFont('Times','B',10);
	$pdf->MultiCell(200,4,"CONSIDERANDO \n ",0,'C');	
$pdf->SetFont('Times','',10);
	$pdf->MultiCell(195,4,utf8_decode('Que conforme a la liquidación que se detalla en la parte resolutiva de esta resolución, el propietario o poseedor del predio identificado con la cedula catastral No. '. $_POST[codcat].', adeuda al Municipio de Cubarral (Meta) por concepto de Impuesto Predial Unificado, Sobretasa Bomberil y Sobretasa Ambiental, la suma de $'.number_format($_POST[totliquida],2,",",".").', correspondiente al capital de las vigencias que se detallan, mas los intereses que se causen hasta el momento en que se haga efectivo el pago total de la obligación.
Que el Articulo 49 del Acuerdo 024 de 2010, establece: "CAUSACIÓN DEL IMPUESTO PREDIAL.  El impuesto predial se causa el primero (1) de enero del respectivo período fiscal. En el Municipio de Cubarral su liquidación será anual y vencidos los plazos establecidos en el presente Estatuto, se empezará a cobrar el interés moratorio diario legal vigente, estipulado por  la Superintendencia Financiera, en cumplimiento de la Ley 1066 de 2006, o las normas que la modifiquen o adicionen".'),0,'J');	
	$pdf->MultiCell(195,4,utf8_decode("Que la administración Municipal estableció los plazos para pagar las vigencias antes señaladas, y el contribuyente incumplió con su obligación tributaria de hacerlo.
Que de conformidad con lo anterior, las vigencias antes indicadas son exigibles por parte de la administración.
Que para efectuar la determinación de la obligación se toma como base el avaluo catastral determinado por el Instituto Geografico Agustin Codazzi - IGAC, de conformidad con lo dispuesto en el artículo 28 y el articulo 54 del Estatuto de Rentas Municipal  y demás normas concordantes.
Que con fundamento en lo previsto en el artículo 53 del Estatuto de Rentas Municipal, las tarifas del Impuesto Predial Unificado se aplicaran de conformidad con su destinación económica y de acuerdo a la clasificación establecida en el mismo cuerpo normativo.

En mérito de lo anteriormente expuesto, este despacho, \n \n"),0,'J');	
$pdf->SetFont('Times','B',10);
	$pdf->MultiCell(195,4,"\nRESUELVE  \n",0,'L');	
$pdf->SetFont('Times','',10);
	$pdf->MultiCell(195,4,utf8_decode("\nPRIMERO - DETERMINAR a cargo de ".$_POST[ntercero].", o de quien sea que ostente a la fecha la calidad propietario o poseedor este o no inscrito en la base catastral del Instituto Geografico Agustin Codazzi, y por ende sujeta pasivo del Impuesto Predial, del Predio identificado con referencia catastral No ". $_POST[codcat].", la obligación de pagar a favor del Municipio de Cubarral (Meta), la suma de $ ".number_format($_POST[totliquida],2,",",".").", correspondiente al capital adeudado por concepto de Impuesto Predial Unificado, Sobretasa Bomberil y Sobretasa Ambiental, según liquidación que se detalla a continuación, mas los intereses que se causen desde que se hizo exigible hasta el momento en que se haga efectivo el pago total de la obligación:"),0,'J');
$pdf->SetFont('Times','B',10);
	$pdf->MultiCell(195,4,"\nTABLA DEUDA  \n",0,'L');	
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
	for($x=0;$x<count($_POST[dselvigencias]);$x++)
	{	
	 	$cont=0;
		while($cont<count($_POST[dvigencias]))
		{
			if($_POST[dvigencias][$cont]==$_POST[dselvigencias][$x])
			{	
				//echo $cont." ".$_POST[dvaloravaluo][$cont]."<br>";
				$interes=$_POST[dinteres1][$cont]+$_POST[dipredial][$cont];
				$pdf->Cell(25,4,''.$_POST[dvaloravaluo][$cont],'LBR',0,'C');
				$pdf->Cell(10,4,''.$_POST[dvigencias][$cont],'LBR',0,'C');
				$pdf->Cell(10,4,''.$_POST[dtasavig][$cont].' xmil','LBR',0,'C');
				$pdf->Cell(22,4,''.number_format($_POST[dpredial][$cont],2),'LBR',0,'R');
				$pdf->Cell(22,4,''.number_format($interes,2),'LBR',0,'R');
				$pdf->Cell(22,4,''.number_format($_POST[dimpuesto2][$cont],2),'LBR',0,'R');
				$pdf->Cell(20,4,''.number_format($_POST[dinteres2][$cont],2),'LBR',0,'R');
				$pdf->Cell(22,4,''.number_format($_POST[dimpuesto1][$cont],2),'LBR',0,'R');
				$pdf->Cell(20,4,''.number_format($_POST[ddescuentos][$cont],2),'LBR',0,'R');
				$pdf->Cell(26,4,''.number_format($_POST[dhavaluos][$x],2),'LBR',1,'R');
			}
			$cont=$cont +1;
		}
	}
	 	$cont=0;
while($cont<(6-count($_POST[dselvigencias])))
 {
	 $pdf->Cell(25,4,'','LBR',0,'C');
	$pdf->Cell(10,4,'','LBR',0,'C');
	$pdf->Cell(10,4,'','LBR',0,'C');
	$pdf->Cell(22,4,'','LBR',0,'C');
	$pdf->Cell(22,4,'','LBR',0,'C');
	$pdf->Cell(22,4,'','LBR',0,'C');
	$pdf->Cell(20,4,'','LBR',0,'C');
	$pdf->Cell(22,4,'','LBR',0,'C');
	$pdf->Cell(20,4,'','LBR',0,'C');
	$pdf->Cell(26,4,'','LBR',1,'C');	 
		   	$cont=$cont +1;
 }
			
	$pdf->ln(4);
	$pdf->cell(102);
	$pdf->SetFont('times','B',9);
	$pdf->Cell(20,4,'TOTAL A PAGAR',0,0,'L');
	$pdf->SetFont('times','B',14);
		$pdf->cell(12);
	$pdf->Cell(55,4,'$'.$_POST[totliquida2],0,1,'L'); 
			
	$y=$pdf->GetY();		

$pdf->SetFont('Times','',10);
$pdf->MultiCell(195,4,utf8_decode("SEGUNDO: Contra la presente resolución procede el recurso de reconsideración, el cual deberá interponerse ante la secretaria de Hacienda Municipal dentro de los dos(2) meses siguientes a su notificación.
TERCERO: Una vez ejecutoriada la presente resolución, constituirá titulo ejecutivo en contra del sujeto pasivo del impuesto predial unificado, conforme a lo dispuesto en el numeral primero de la parte resolutiva de la presente resolución y en contra de sus herederos o legatarios.
CUARTO: NOTIFICASE de conformidad con lo dispuesto en los artículos 374 y subsiguientes del Estatuto Tributario Municipal.
"),0,'J');	
$pdf->SetFont('Times','B',10);
	$pdf->MultiCell(200,4," \n \n \n NOTIFIQUESE Y CUMPLASE  \n \n \n",0,'L');	
	$pdf->SetFont('Times','B',10);
	$pdf->MultiCell(200,4," \n \n \n JEIN ASTRID MURCIA TRIANA \n SECRETARIA HACIENDA MUNICIPAL",0,'C');	
$pdf->ln(4);
$pdf->SetFont('times','',8);
	$pdf->multicell(199,4,'* Contra la presente liquidaci'.utf8_decode(ó).'n procede el recurso de reconsideraci'.utf8_decode(ó).'n dentro de los dos (2) meses siguientes a su notificaci'.utf8_decode(ó).'n',0);

$pdf->Output();
?> 