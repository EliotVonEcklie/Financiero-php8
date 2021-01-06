<?php
//V 1000 12/12/16 
	require('fpdf.php');
	require('comun.inc');
	require"funciones.inc";
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
			$this->Cell(149,20,'AUTORIZACION LIQUIDACION PREDIAL',0,0,'C'); 
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
			$this->Cell(35,5,'No AUTO: '.$_POST[numpredial],0,0,'L');
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
	//Creación del objeto de la clase heredada
	$nresul=buscatercero($_POST[pdftercero]);
	$pdf=new PDF('P','mm','Letter'); 
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Times','',10);
	$pdf->SetAutoPageBreak(true,20);
	$pdf->SetFont('Arial','B',12);
	$pdf->SetY(45);   
	$pdf->SetFillColor(255,255,255);
	$pdf->cell(0.2); 
	$pdf->SetFont('Arial','B',10);
	$pdf->cell(42,5,'Proyección Liquidación: ',0,0,'L',1);
	$pdf->SetFont('Arial','',10);
	$pdf->cell(30,5,date('d-m-Y',strtotime($_POST[fechav])),0,0,'L',1);
	$pdf->cell(0.2);
	$pdf->SetFont('Arial','B',10);
	$pdf->cell(33,5,'Código Catastral:',0,0,'L',1);
	$pdf->SetFont('Arial','',10);
	$pdf->cell(50,5,$_POST[codcat]."  ".$_POST[ord]."  ".$_POST[tot],0,1,'L',1);
	$pdf->SetFillColor(245,245,245);
	$pdf->cell(0.2);
	$pdf->SetFont('Arial','B',10);
	$pdf->cell(23,5,'Valor Pago: ',0,0,'L',1);
	$pdf->SetFont('Arial','',10);
	$pdf->cell(49,5,'$'.number_format($_POST[valor],2),0,0,'L',1);
	$pdf->cell(0.2); 
	$pdf->SetFont('Arial','B',10);
	$pdf->cell(33,5,'Periodos a Pagar: ',0,0,'L',1);
	$pdf->SetFont('Arial','',10);
	$pdf->cell(93.5,5,$anos,0,1,'L',1);
	$pdf->SetFillColor(255,255,255);
	$pdf->cell(0.2); 
	$pdf->SetFont('Arial','B',10);
	$pdf->cell(23,5,'Propietario: ',0,0,'L',1);
	$pdf->SetFont('Arial','',10);
	$pdf->cell(82,5,$_POST[ntercero],0,0,'L',1);
	$pdf->cell(0.2);
	$pdf->SetFont('Arial','B',10);
	$pdf->cell(24,5,'Documento:',0,0,'L',1);
	$pdf->SetFont('Arial','',10);
	$pdf->cell(50,5,$_POST[tercero],0,1,'L',1);
	$pdf->SetFillColor(245,245,245);
	$pdf->cell(0.2);
	$pdf->SetFont('Arial','B',10);
	$pdf->cell(23,5,'Dirección:',0,0,'L',1);
	$pdf->SetFont('Arial','',10);
	$pdf->cell(176,5,$_POST[direccion],0,1,'L',1);
	$pdf->SetFillColor(255,255,255);
	$pdf->cell(0.2); 
	$pdf->SetFont('Arial','B',10);
	$pdf->cell(9,5,'Ha:',0,0,'L',1);
	$pdf->SetFont('Arial','',10);
	$pdf->cell(15,5,$_POST[ha],0,0,'L',1);
	$pdf->cell(0.2);
	$pdf->SetFont('Arial','B',10);
	$pdf->cell(10,5,'Mt2:',0,0,'L',1);
	$pdf->SetFont('Arial','',10);
	$pdf->cell(39,5,number_format($_POST[mt2]),0,0,'L',1);
	$pdf->cell(0.2);
	$pdf->SetFont('Arial','B',10);
	$pdf->cell(21,5,'Area Cons:',0,0,'L',1);
	$pdf->SetFont('Arial','',10);
	$pdf->cell(40,5,number_format($_POST[areac]),0,0,'L',1);
	$pdf->cell(0.2);
	$pdf->SetFont('Arial','B',10);
	$pdf->cell(15,5,'Avaluo:',0,0,'L',1);
	$pdf->SetFont('Arial','',10);
	$pdf->cell(49,5,$_POST[avaluo],0,1,'L',1);
	$pdf->SetFillColor(245,245,245);
	$pdf->cell(0.2); 
	$pdf->SetFont('Arial','B',10);
	$pdf->cell(12,5,'Tipo:',0,0,'L',1);
	$pdf->SetFont('Arial','',10);
	$pdf->cell(30,5,$_POST[tipop],0,0,'L',1);
	$pdf->cell(0.2);
	$pdf->SetFont('Arial','B',10);
	$pdf->cell(28,5,'Rango Avaluo:',0,0,'L',1);
	$pdf->SetFont('Arial','',10);
	$pdf->cell(128.5,5,$_POST[nrango],0,1,'L',1);
	$pdf->RoundedRect(10, 44 ,199 , 33, 1,'' );
	$pdf->SetFillColor(255,255,255);
	$pdf->ln(26);
	$pdf->cell(0.2);
	$pdf->SetFont('Arial','B',11);
	$pdf->cell(20,5,'Autoriza:',0,0,'L',1);
	$pdf->SetFont('Arial','',11);
	$pdf->cell(39,5,$_POST[autoriza],0,0,'L',1);	
	$pdf->line(10,100,110,100);
	
		
	$pdf->Output();
?>