<?php
//V 1000 12/12/16 
require('fpdf.php');
require('comun.inc');
require('funciones.inc');
session_start();
   date_default_timezone_set("America/Bogota");
//*****las variables con los contenidos***********
//**********pdf*******
//$pdf=new FPDF('P','mm','Letter'); 
class PDF extends FPDF
{

//Cabecera de p�gina
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
    $this->Cell(149,20,'CERTIFICACION DE INSCRIPCION INDUSTRIA Y COMERCIO',0,0,'C'); 
	//************************************
    $this->SetFont('Arial','B',10);
	
	$this->SetY(27);
	$this->Cell(50.2);
	$this->multiCell(110.7,7,'Fecha Expedicion: '.date("Y-m-d"),'T','L');
	$this->Cell(50.2);
	$this->multiCell(110.7,7,'','','L');
	$this->SetY(27);
    $this->Cell(161.1);
	$this->Cell(37.8,14,'','TL',0,'L');
	
	$this->SetY(28.5);
    $this->Cell(161);
	$this->Cell(38,5,'NUMERO','B',0,'C');
	
	$this->SetY(34.5);
    $this->Cell(161);
	$this->Cell(38,5,''.$_POST[id],'0',0,'C');
	
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
//Pie de p�gina
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
//Creaci�n del objeto de la clase heredada
//$pdf=new PDF('P','mm',array(210,140));
$pdf=new PDF('P','mm','Letter'); 
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Times','',10);
$meses=array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

$pdf->SetAutoPageBreak(true,20);
	$pdf->SetFont('times','B',14);
	$pdf->SetY(43.7);
	$pdf->ln(18);
    $pdf->Cell(20);
	$pdf->Cell(150,4,'EL TESORERO DEL '.strtoupper($rs),'',1,'C'); 
		$pdf->ln(14);
	$pdf->SetFont('times','',14);	
	$otros="";
    $mm=substr($_POST[fechain],5,2)*1;
    $texto=utf8_decode("Certifica que ").$_POST[ntercero].utf8_decode(" CC/NIT ").$_POST[tercero].utf8_decode(" se encuetra inscrito en la base de datos de industria y comercio en la alcaldia desde el ").substr($_POST[fechain],8,2).utf8_decode(" dias del Mes de ").$meses[$mm].utf8_decode(" de ").substr($_POST[fechain],0,4).utf8_decode(" con numero de matricula ").$_POST[id].".";
	$pdf->MultiCell(0,4,$texto,0,'J');
	$pdf->ln(10);
	$pdf->ln(6);

    $texto='';
    if(count($_POST[numMatriculaDet])>1)
    {
        $pdf->SetFont('Arial','I',14);
        $pdf->MultiCell(0,4,"Se encuentran registrados los siguientes establecimientos: ",0,'J');
        $pdf->SetFont('times','',12);	
        $pdf->ln(6);
    }
    elseif(count($_POST[numMatriculaDet])==1)
    {
        $pdf->SetFont('Arial','I',9);
        $pdf->MultiCell(0,4,"Se encuentra registrado el siguiente establecimiento: ",0,'J');
        $pdf->SetFont('times','',12);	
        $pdf->ln(6);
    }
    for ($x=0;$x<count($_POST[numMatriculaDet]);$x++)
	{
        $texto=utf8_decode(" - ").$_POST[razonSocialDet][$x].utf8_decode(" Direccion: ").$_POST[direccionEstablecimientoDet][$x].utf8_decode(" Valor Activos: ").$_POST[valorActivoDet][$x];
        $pdf->SetFont('Arial','I',9);
        $pdf->MultiCell(0,4,$texto,0,'J');
        $pdf->SetFont('times','',12);	
        $pdf->ln(6);
    }
				
	

	$pdf->ln(6);
	$mm=substr(date("Y-m-d"),5,2)*1;
	$texto=utf8_decode("Se Expide, a los ").substr(date("Y-m-d"),8,2).utf8_decode(" dias del Mes de ").$meses[$mm].utf8_decode(" de ").substr(date("Y-m-d"),0,4);
	$pdf->MultiCell(0,4,$texto,0,'J');
	
	
$sqlr="select id_cargo,id_comprobante from pptofirmas TB1,pptotipo_comprobante TB2 where TB1.id_comprobante=TB2.id_tipo and TB2.tipo='P01' and TB1.vigencia='".$_POST[vigencia]."'";
$res=mysql_query($sqlr,$linkbd);
while($row=mysql_fetch_assoc($res))
{
	if($row["id_cargo"]=='0')
	{
		$_POST[ppto][]=utf8_decode(buscatercero($_POST[tercero]));
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
$_POST[ppto][]=buscar_empleado(30946526);
$_POST[nomcargo][$x]='SECRETARIA DE HACIENDA';
for($x=0;$x<count($_POST[ppto]);$x++)
{
	$pdf->ln(25);
	$v=$pdf->gety();
	$pdf->setFont('times','B',10);
	$pdf->Line(50,$v,160,$v);
	$pdf->Cell(190,6,''.utf8_encode($_POST[ppto][$x]),0,1,'C',false,0,0,false,'T','C');
	$pdf->Cell(190,6,''.utf8_encode($_POST[nomcargo][$x]),0,0,'C',false,0,0,false,'T','C');
	$pdf->SetFont('helvetica','',7);
}

$pdf->Output();
?>