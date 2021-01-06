<?php
//V 1000 12/12/16 
require('fpdf.php');
require('comun.inc');
//	session_start();
   date_default_timezone_set("America/Bogota");
//*****las variables con los contenidos***********
//**********pdf*******
//$pdf=new FPDF('P','mm','Letter'); 
class PDF extends FPDF
{
//Cabecera de página
function Header()
{	
if ($_POST[estadoc]=='ANULADO'){
		    $this->Image('imagenes/anulado.jpg',30,15,150,80);
	}
$linkbd=conectar_bd();
$sqlr="select *from configbasica where estado='S'";
//echo $sqlr;
$res=mysql_query($sqlr,$linkbd);
while($row=mysql_fetch_row($res))
 {
  $nit=$row[0];
  $rs=$row[1];
 }
//$nit='892000812-0';
//$rs='Municipio de Cubarral';
        //Parte Izquierda
    $this->Image('imagenes/eng.jpg',18,12,30,20);
	$this->SetFont('arial','B',10);
	$this->SetY(10);
	$this->RoundedRect(10, 10, 199, 31, 2.5,'' );
	$this->Cell(0.1);
    $this->Cell(50,31,'','R',0,'L'); 
	$this->SetY(31);
    $this->Cell(0.1);
    $this->Cell(50,5,''.$rs,0,0,'C'); 
	$this->SetFont('arial','B',8);
	$this->SetY(35);
    $this->Cell(0.1);
    $this->Cell(50,5,''.$nit,0,0,'C'); //Cuadro Izquierda
    //*****************************************************************************************************************************
	$this->SetFont('arial','B',14);
	$this->SetY(10);
    $this->Cell(50.1);
    $this->Cell(149,31,'',0,1,'C'); 
	$this->SetY(8);
    $this->Cell(50.1);
    $this->Cell(149,25,'CERTIFICADO DE RETENCION EN LA FUENTE',0,0,'C'); 
	//************************************
    $this->SetFont('times','B',10);	
	$this->SetY(27);
    $this->Cell(161.1);
	$this->Cell(37.8,14,'','TL',0,'L');
	$this->SetY(27.5);
    $this->Cell(162);
	//$this->Cell(35,5,'NUMERO : '.$_POST[numero],0,0,'L');
	$this->SetY(31.5);
    $this->Cell(162);
	$this->Cell(35,5,'VIGENCIA F.: '.$_POST[vigencias],0,0,'L');
	$this->SetY(35.5);
    $this->Cell(162);
	$this->Cell(35,5,'FECHA: '.date('Y-m-d'),0,0,'L');
	$this->SetY(27);
	$this->Cell(50.2);
	$this->MultiCell(110.7,5,'','T','C');			
	$this->SetFont('times','B',12);
	$this->SetY(46);
	$this->Cell(199,12,'CERTIFICA:',0,0,'C');		
	$this->SetY(60);
	$this->SetFont('times','',10);
	$this->cell(0.1);
	if($_POST[fecha1]!="" && $_POST[fecha2]!="")
		{
		 $cond=" y entre el periodo de $_POST[fecha1] al $_POST[fecha2], ";
		}
	$this->MultiCell(199,4,utf8_decode('Durante el año gravable de '.$_POST[vigencias].' '.$cond.' practicó en el '.$rs.', Retención en la Fuente al Proveedor '.$_POST[ntercero].' con Nit/Cc '.$_POST[tercero].' '),0,'J');
	$this->ln(4);
	$this->line(10,75,209,75);
//********************************************************************************************************************************
	$this->SetFont('times','B',10);
	$this->SetY(76);
    $this->Cell(0.1);
    $this->Cell(24,5,'CODIGO ',0,1,'C'); 
		$this->SetY(76);
    	$this->Cell(24.1);
		$this->Cell(78,5,'RETENCION',0,1,'C');
			$this->SetY(76);
        	$this->Cell(102);
			$this->Cell(63,5,utf8_decode('Monto del Pago Sujeto a Retención'),0,1,'C');
			$this->SetY(76);
        	$this->Cell(165);
			$this->Cell(34,5,'VALOR',0,1,'C');		
			$this->line(10,82,209,82);
				$this->ln(2);
//********************************************************************************************************************************
}
//Pie de página
function Footer()
{
    $this->SetY(-15);
	$this->SetFont('times','I',10);
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
$pdf->SetY(81);   
$con=0;
$linkbd=conectar_bd();
$sqlr="select *from configbasica where estado='S'";
//echo $sqlr;
$res=mysql_query($sqlr,$linkbd);
while($row=mysql_fetch_row($res))
 {
  $nit=$row[0];
  $rs=$row[1];
 }
while ($con<count($_POST[valores]))
{	if ($con%2==0)
	{$pdf->SetFillColor(245,245,245);
	}
    else
	{$pdf->SetFillColor(255,255,255);
	}
	$pdf->Cell(24,4,''.$_POST[codigo][$con],0,0,'C',0);
    $pdf->Cell(95,4,substr(''.$_POST[nombres][$con],0,50),0,0,'L',0);
    $pdf->Cell(40,4,$_POST[valoresret][$con],0,0,'R',0);
    $pdf->Cell(40,4,''.number_format($_POST[valores][$con],2),0,0,'R',0);
	$pdf->ln(4);	
	$con=$con+1;
	$total+=$_POST[valores][$con];
}
	$pdf->SetFont('arial','',10);
	$pdf->ln(4);
	$pdf->SetLineWidth(0.5);
	$pdf->cell(110,5,'','T',0,'R');
	$pdf->cell(55,5,'Total','T',0,'R');
	$pdf->cell(34,5,''.number_format($total,2),'T',0,'R');
	$pdf->SetLineWidth(0.2);
	$pdf->ln(10);
	$v=$pdf->gety();
//	$pdf->RoundedRect(10, $v-1, 199, 10, 1.2,'' );
	$pdf->MultiCell(199,4,utf8_decode('El presente certificado se expide en concordancia con las disposiciones legales contenidas en el artículo 381 del Estatuto Tributario'),0,'J');
	$pdf->ln(4);
//	$pdf->cell(10);
	$pdf->MultiCell(199,4,utf8_decode('Dicha retención fue consignada oportunamente a nombre de La Administración de Impuestos Nacionales en el '.$rs),0,'J');
	$pdf->ln(4);
//	$pdf->cell(10);
	$pdf->MultiCell(199,4,utf8_decode('Señor (a) recuerde que Ud. Puede estar obligado a declarar renta por el año gravable de '.$_POST[vigencias].'.'),0,'J');
	$pdf->ln(4);
//	$pdf->cell(10);
	$pdf->MultiCell(199,4,utf8_decode('Para mayor información lo invitamos a que consulte la página en internet (www.dian.gov.co) o acerquese a la Administración más cercana a su domicilio'),0,'J');
	$pdf->ln(4);
//	$pdf->cell(10);
	$pdf->MultiCell(199,4,utf8_decode('NO REQUIERE FIRMA AUTOGRAFA ART. 10 DECRETO 836/91'),0,'J');
	//$pdf->Cell(80,5,'Dicha retención fue consignada oportunamente a nombre de La Administración de Impuestos de la ciudad de VILLAVICENCIO','',0,'L');
//********************************************************************************************************************************
	//$pdf->SetY(77); //**********CUADRO
    //$pdf->Cell(5);
   // $pdf->Cell(185,44,'',1,0,'R');
//***********************************************************************************************************************************************
//************************************************************************************************************************************************
//**********************************************************************************************************
$pdf->Output();
?>