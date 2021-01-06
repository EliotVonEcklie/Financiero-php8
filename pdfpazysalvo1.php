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
$linkbd=conectar_bd();
$sqlr="select *from configbasica where estado='S'";
//echo $sqlr;
$res=mysql_query($sqlr,$linkbd);
while($row=mysql_fetch_row($res))
 {
  $nit=$row[0];
  $rs=$row[1];
//  $mnpio=$row[1];
 }
 /* $rs="Municipio de Cubarral";
 $nit="892000812-0";
 $nalca="RIVERA RINCON JAIRO ";*/
     //Parte Izquierda
    $this->Image('imagenes/eng.jpg',23,10,25,25);
	$this->SetFont('Arial','B',10);
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


	$this->SetY(8);
    $this->Cell(50.1);
    $this->Cell(149,20,'PAZ Y SALVO',0,0,'C'); 
	//************************************
    $this->SetFont('Arial','B',10);
	
	$this->SetY(27);
	$this->Cell(50.2);
	$this->multiCell(110.7,7,'Fecha Expedicion: '.$_POST[fecha].' - Cod Catastral: '.$_POST[codcat],'T','L');
	$this->Cell(50.2);
	$this->multiCell(110.7,7,'Recibo de Caja No: '.$_POST[recibo],'','L');
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

$linkbd=conectar_bd();
$sqlr="select *from configbasica where estado='S'";
//echo $sqlr;
$res=mysql_query($sqlr,$linkbd);
while($row=mysql_fetch_row($res))
 {
  $nit=$row[0];
  $rs=$row[1];
//  $mnpio=$row[1];
 }
 /* $rs="Municipio de Cubarral";
 $nit="892000812-0";
 $nalca="RIVERA RINCON JAIRO ";*/
//Creación del objeto de la clase heredada
//$pdf=new PDF('P','mm',array(210,140));
$pdf=new PDF('P','mm','Letter'); 
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Times','',10);


$pdf->SetAutoPageBreak(true,20);
$sqlr="select *from  tesoparametros where estado='S'";
//echo $sqlr;
$res=mysql_query($sqlr,$linkbd);
while($row=mysql_fetch_row($res))
 {
  //$ppto=$row[0];
  $teso=$row[4];
 }
	$pdf->SetFont('times','B',14);
	$pdf->SetY(43.7);
	$pdf->ln(18);
    $pdf->Cell(20);
	$pdf->Cell(150,4,'LA TESORERA DEL '.strtoupper($rs),'',1,'C'); 
		$pdf->ln(14);
	$pdf->SetFont('times','',12);	
	$otros="";
	if($_POST[tot]>'001')
	$otros=" y OTROS ";
$texto=utf8_decode("Que el Predio No. ").$_POST[codcat].utf8_decode(" Inscrito en el Listado de Catastro para este Municipio a nombre de ").$_POST[ntercero].utf8_decode(" CC/NIT ").$_POST[tercero].$otros.utf8_decode(" Denominado ").$_POST[direccion].utf8_decode(" con una Extension de ").$_POST[ha].utf8_decode(" Hectareas, ").$_POST[mt2].utf8_decode(" Metros y ").$_POST[areac].utf8_decode(" AC. Avaluo de $").$_POST[avaluo].utf8_decode(" Se halla a PAZ Y SALVO con el Tesoro Municipal, Por concepto de IMPUESTO PREDIAL hasta el Treinta y Uno (31) de Diciembre de ").substr($_POST[fecha],6,4);
	$pdf->MultiCell(0,4,$texto,0,'J');
	$pdf->ln(10);
	$texto=utf8_decode("Valido para: ".$_POST[destino]);
	$pdf->MultiCell(0,4,$texto,0,'J');
	$pdf->ln(6);

	$sql1="select *from tesopredios where cedulacatastral='$_POST[codcat]'";
	//echo $sql1;
	//$pdf->MultiCell(0,4,$sql1,0,'J');
	$res1=mysql_query($sql1,$linkbd);
	$nota=true;
	$texto='';
	while($row1=mysql_fetch_row($res1))
	{
		if ($row1[2]>=002) {
			if ($nota) {
				$texto=$texto.utf8_decode("Nota: El predio No. ").$_POST[codcat].utf8_decode(" tiene ").($row1[2]+0).utf8_decode(" propietarios: ").$row1[6].utf8_decode(' identificado con el documento ').$row1[5];
				$nota=false;
			}else{
				$texto=$texto.', '.$row1[6].utf8_decode(' identificado con el documento ').$row1[5].".";
			}

		}
	}
	$pdf->SetFont('Arial','I',9);
	$pdf->MultiCell(0,4,$texto,0,'J');
	$pdf->SetFont('times','',12);	
	$pdf->ln(6);
				
	

	$pdf->ln(6);
	$meses=array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	$mm=substr($_POST[fecha],3,2)*1;
	$texto=utf8_decode("Se Expide, a los ").substr($_POST[fecha],0,2).utf8_decode(" dias del Mes de ").$meses[$mm].utf8_decode(" de ").substr($_POST[fecha],6,4);
	$pdf->MultiCell(0,4,$texto,0,'J');
	$pdf->ln(30);
	$pdf->SetFont('times','B',9);
	$pdf->Cell(50);
	$pdf->Cell(80,4,''.$teso,'T',1,'C');
	$pdf->Cell(50);
	$pdf->Cell(80,4,'JEFE TESORERIA','',1,'C');

$pdf->Output();
?>