<?php
//V 1000 12/12/16 
	require('fpdf.php');
	require('comun.inc');
	require"funciones.inc";
	require "conversor.php";
	session_start();
	$linkbd=conectar_bd();
   	date_default_timezone_set("America/Bogota");
	$anos="";
	for($x=0;$x<count($_POST[dselvigencias]);$x++){$anos=$anos.$_POST[dselvigencias][$x].", ";}
	class PDF extends FPDF
	{
		function Header()//Cabecera de página************************************************************
		{	
			$linkbd=conectar_bd();
			$sqlr="select * from configbasica where estado='S'";
			$res=mysql_query($sqlr,$linkbd);
			while($row=mysql_fetch_row($res))
			{
				$nit=$row[0];
				$rs=$row[1];
				$nalca=$row[6];
			}
			$detalles=$_POST[descripcion];
			//Parte Izquierda
			$this->Image('imagenes/eng.jpg',23,10,25,25);
			$this->SetFont('Arial','B',10);
			$this->SetY(10);
			$this->RoundedRect(10, 10, 199, 31, 1,'' );
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
			$this->Cell(149,20,'ACUERDO PAGO PREDIAL',0,0,'C'); 
			//************************************
			$this->SetFont('Arial','I',10);
			$this->SetY(27);
			$this->Cell(50.2);
			$this->multiCell(110.7,7,''.strtoupper($detalles),'T','L');
			$this->SetFont('Arial','B',10);
			$this->SetY(27);
			$this->Cell(161.1);
			$this->Cell(37.8,14,'','TL',0,'L');
			$this->SetY(27);
			$this->Cell(162);
			$this->Cell(35,5,'No Acuerdo: '.$_POST[numacuerdo],0,0,'L');
			$this->SetY(31);
			$this->Cell(162);
			$this->Cell(35,5,'FECHA: '.date('d-m-Y',strtotime($_POST[fecha])),0,0,'L');
			$this->SetY(35);
			$this->Cell(162);
			$this->Cell(35,5,'VIGENCIA: '.$_POST[vigencia],0,0,'L');
			$this->SetY(27);
			$this->Cell(50.2);
			$this->MultiCell(105.7,4,'',0,'L');		
			$this->SetFont('times','B',10);
			$this->ln(12);
		}
		function Footer()
		{
			$this->SetY(-15);
			$this->SetFont('Arial','I',8);
			$this->Cell(0,10,'Impreso por: Software SPID - G&C Tecnoinversiones SAS. - Pagina '.$this->PageNo().' de 1',0,0,'R');  	
		}
	}
	
	
	$sqlr="select fechas from tesoacuerdopredial where tesoacuerdopredial.idacuerdo=$_POST[numacuerdo]  ";
	$res=mysql_query($sqlr,$linkbd);
	$fechas="";
	$fila=mysql_fetch_row($res);
	$fechas=substr($fila[0],0,-1);
	
	//Creación del objeto de la clase heredada
	$sqlr="select vigencia from tesoacuerdopredial_det where tesoacuerdopredial_det.idacuerdo=$_POST[numacuerdo]  ";
	$res=mysql_query($sqlr,$linkbd);
	$vigencias="";
	while($row = mysql_fetch_row($res)){
		$vigencias.=($row[0].",");
	}
	$vigencias=substr($vigencias,0,-1);		
	$resultado = convertir($_POST[totliquida]);
	$_POST[letras]=$resultado." PESOS M/CTE";	
	
	$nuevo=round($_POST[totliquida]/$_POST[cuotas]);
	$resultado1 = convertir($nuevo);
	$nuevoletras=$resultado1." PESOS M/CTE";
	
	$nresul=buscatercero($_POST[pdftercero]);
	$pdf=new PDF('P','mm','Letter'); 
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Times','B',12);
	$pdf->SetAutoPageBreak(true,20);
	$pdf->ln(5);
	$pdf->MultiCell(195.7,5,'EL SUSCRITO SECRETARIO DE HACIENDA','','C');	
	$pdf->Cell(199,12,'ACUERDA:',0,0,'C');		
	$pdf->ln(15);
	$pdf->SetFont('times','',11);
	$pdf->cell(0.1);
	$pdf->MultiCell(190,4,'Realizar el pago del predio con '.utf8_decode("còdigo").' catastral No. '.$_POST[catastral].' de las '.utf8_decode('vigencias').' '.$vigencias.' por la suma total de $'.number_format(round($_POST[totliquida]),2,".",",").' ('.$_POST[letras].') , dividido en '.$_POST[cuotas].' cuotas por un valor de '.number_format(round($_POST[totliquida]/$_POST[cuotas]),2,".",",").' ('.$nuevoletras.') con fechas de pago  '.$fechas.' respectivamente.',0,'L',false,1,'','',true,0,false,true,0,'T',false);
	$pdf->ln(2);
	$pdf->cell(0.1);
	$pdf->MultiCell(190,4,'Si el contribuyente no cancela en el tiempo estipulado '.utf8_decode("perderà").' el beneficio y se '.utf8_decode("iniciarà").' el proceso coactivo.',0,'L',false,1,'','',true,0,false,true,0,'T',false);
	$pdf->ln(8);
	$pdf->SetFont('times','UB',11);
	$pdf->Cell(21,5,"Detalle Liquidacion",0,0,'L');
	$pdf->SetFont('times','B',9);
	$pdf->ln(8);
	$pdf->Cell(30,5,'VIGENCIA',1,0,'C',false,0,0,false,'T','C');
	$pdf->Cell(32,5,'COD. CATASTRAL',1,0,'C',false,0,0,false,'T','C');	
	$pdf->Cell(31,5,'PREDIAL/INTERES',1,0,'C',false,0,0,false,'T','C');
	$pdf->Cell(32,5,'BOMBERO/INTERES',1,0,'C',false,0,0,false,'T','C');
	$pdf->Cell(33,5,'AMBIENTE/INTERES',1,0,'C',false,0,0,false,'T','C');
	$pdf->Cell(31,5,'DESCUENTOS',1,0,'C',false,0,0,false,'T','C');	
	$pdf->ln(5);
	$pdf->SetFont('times','',9);
	$cont=0;
	while($cont<count($_POST[dcodcatas])){
		$pdf->Cell(30,5,$_POST[dvigencias][$cont],1,0,'C',false,0,0,false,'T','C');
		$pdf->Cell(32,5,$_POST[dcodcatas][$cont],1,0,'C',false,0,0,false,'T','C');
		$pdf->Cell(31,5,'$ '.number_format($_POST[dpredial][$cont]).'/ $ '.number_format($_POST[dipredial][$cont]),1,0,'C',false,0,0,false,'T','C');
		$pdf->Cell(32,5,'$ '.number_format($_POST[dimpuesto1][$cont]).'/ $ '.number_format($_POST[dinteres1][$cont]),1,0,'C',false,0,0,false,'T','C');
		$pdf->Cell(33,5,'$ '.number_format($_POST[dimpuesto2][$cont]).'/ $ '.number_format($_POST[dinteres2][$cont]),1,0,'C',false,0,0,false,'T','C');
		$pdf->Cell(31,5,'$ '.number_format($_POST[ddescuentos][$cont]),1,0,'C',false,0,0,false,'T','C');
		$pdf->ln(5);
		$cont++;
	}
	$linkbd=conectar_bd();
	$sqlr="select nombreteso from  tesoparametros where estado='S'";
	$res=mysql_query($sqlr,$linkbd);
	while($row=mysql_fetch_row($res)){$ppto=$row[0];}
	
	$pdf->ln(50);
	$v=$pdf->gety();
	$pdf->setFont('times','B',10);
	$pdf->Line(50,$v,160,$v);
	$pdf->Cell(190,6,''.utf8_encode($ppto),0,1,'C',false,0,0,false,'T','C');
	$pdf->Cell(190,6,'SECRETARIO DE HACIENDA',0,0,'C',false,0,0,false,'T','C');
	
	$pdf->ln(30);
	$v=$pdf->gety();
	$pdf->setFont('times','B',10);
	$pdf->Line(50,$v,160,$v);
	$pdf->Cell(190,6,$_POST[ntercero],0,0,'C',false,0,0,false,'T','C');
	
	$pdf->Output();
?>