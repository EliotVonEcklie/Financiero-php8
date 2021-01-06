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
			$nalca=$row[6];
		}
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
		$this->Cell(149,20,'ACTIVACION PROPIEDAD PLANTA Y EQUIPO',0,1,'C'); 
		//************************************
		$this->SetFont('Arial','I',8);

		$this->SetY(27);
	$this->Cell(50.2);
	$concepto = ($val==0) ? utf8_decode($_POST[nombre]) : iconv('UTF-8', 'windows-1252', $_POST[nombre]);
	$this->multiCell(110.7,8,'ACTIVACION '.strtoupper($concepto),'T','L');

		$this->SetY(27);
		$this->SetX(171);
		$this->Cell(37.8,14,'','TL',0,'R');
		$this->SetY(27);
		$this->Cell(162);
		$this->Cell(35,5,"NUMERO : $_POST[orden]",0,0,'L');
		$this->SetY(31);
		$this->Cell(162);
		$this->Cell(35,5,"FECHA: $_POST[fecha]",0,0,'L');
		$this->SetY(35);

		$this->SetY(27);
		$this->Cell(50.2);

		$this->MultiCell(105.7,4,'',0,'L');		
		//********************************************************************************************************************************
		$this->SetFont('times','B',10);
		$this->ln(12);
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
$pdf=new PDF('P','mm','Letter'); 
$pdf->AliasNbPages();
for ($x=0;$x< count($_POST[dclase]);$x++)
	{
	
	$pdf->AddPage();
	
	$pdf->SetFont('Times','',10);
	$pdf->SetAutoPageBreak(true,20);

	$pdf->SetFont('Arial','B',12);
	//$pdf->SetFillColor(255,255,153);				
	$pdf->SetY(46);   
	$pdf->cell(125);
	$pdf->cell(27,8,'VALOR: ',0,0,'R');
	$pdf->RoundedRect(161, 46 ,48 , 8, 2,'');
	$pdf->cell(45,8,'$'.number_format($_POST[dvalor][$x],2),0,0,'R');

	$pdf->ln(15);

	$pdf->SetFillColor(255,255,255);
	$pdf->cell(0.2);
	$pdf->SetFont('Arial','B',10);
	$pdf->cell(35,5,'Nombre del Activo: ',0,0,'L',1);
	$pdf->SetFont('Arial','',10);
	$pdf->Multicell(165,5,''.substr(ucwords(strtolower($_POST[dnombre][$x])),0,100),'L',1,'L',1);
	$pdf->cell(0.2);  
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','B',10);
	$pdf->cell(35,5,'Placa: ','T',0,'L',1);
	$pdf->SetFont('Arial','',10);
	$pdf->cell(40,5,''.$_POST[dplaca][$x],'TL',0,'L',1);
	$pdf->SetFont('Arial','B',10);
	$pdf->cell(45,5,'Unidad de Medida:','TL',0,'L',1);
	$pdf->SetFont('Arial','',10);
	$pdf->cell(78.5,5,$_POST[dumed][$x],'TL',1,'L',1); 
	$pdf->cell(0.2);
	$pdf->SetFont('Arial','B',10);
	$pdf->cell(35,5,'Fecha de Compra:','T',0,'L',1);
	$pdf->SetFont('Arial','',10);
	$pdf->cell(40,5,$_POST[dfecom][$x],'TL',0,'L',1);
	$pdf->SetFont('Arial','B',10);
	$pdf->cell(45,5,'Fecha de Activacion:','TL',0,'L',1);
	$pdf->SetFont('Arial','',10);
	$pdf->cell(78.5,5,$_POST[dfecact][$x],'TL',1,'L',1);
	$pdf->SetFont('Arial','B',10);
	$pdf->cell(35.2,5,'Referencia:','T',0,'L',1);
	$pdf->SetFont('Arial','',10);
	$pdf->cell(30,5,''.$_POST[dref][$x],'TL',0,'L',1);
	$pdf->SetFont('Arial','B',10);
	$pdf->cell(35,5,'Modelo:','TL',0,'L',1);
	$pdf->SetFont('Arial','',10);
	$pdf->cell(34,5,''.($_POST[dmodelo][$x]),'TL',0,'L',1);
	$pdf->SetFont('Arial','B',10);
	$pdf->cell(35,5,'Serie:','TL',0,'L',1);
	$pdf->SetFont('Arial','',10);
	$pdf->cell(29.5,5,''.($_POST[dserial][$x]),'TL',1,'L',1);
	$pdf->SetFont('Arial','B',10);

	$link=conectar_bd();
	$sqlr="SELECT * from actipo where estado='S' and codigo='".$_POST[dclase][$x]."'";
	$resp = mysql_query($sqlr,$link);
	$row =mysql_fetch_row($resp);

	$pdf->SetFont('Arial','B',10);
	$pdf->cell(35.2,5,'Clase:','T',0,'L',1);
	$pdf->SetFont('Arial','',10);
	$pdf->cell(163.5,5,$_POST[dclase][$x].' - '.$row[1],'TL',1,'L',1);

	$sqlr="SELECT * from actipo where estado='S' and codigo='".$_POST[dgrupo][$x]."' and niveluno='".$_POST[dclase][$x]."'";
	$resp = mysql_query($sqlr,$link);
	$row =mysql_fetch_row($resp);

	$pdf->SetFont('Arial','B',10);
	$pdf->cell(35.2,5,'Grupo:','T',0,'L',1);
	$pdf->SetFont('Arial','',10);
	$pdf->cell(163.5,5,$_POST[dgrupo][$x].' - '.$row[1],'TL',1,'L',1);

	$sqlr="SELECT * from actipo where estado='S' and codigo='".$_POST[dtipo][$x]."' and niveluno='".$_POST[dgrupo][$x]."' AND niveldos='".$_POST[dclase][$x]."'";
	$resp = mysql_query($sqlr,$link);
	$row =mysql_fetch_row($resp);

	$pdf->SetFont('Arial','B',10);
	$pdf->cell(35.2,5,'Tipo:','T',0,'L',1);
	$pdf->SetFont('Arial','',10);
	$pdf->cell(163.5,5,$_POST[dtipo][$x].' - '.strtoupper($row[1]),'TL',1,'L',1);

	$sqlr="SELECT * from acti_prototipo where estado='S' and id='".$_POST[dproto][$x]."'";
	$resp = mysql_query($sqlr,$link);
	$row =mysql_fetch_row($resp);

	$pdf->SetFont('Arial','B',10);
	$pdf->cell(35.2,5,'Prototipo:','T',0,'L',1);
	$pdf->SetFont('Arial','',10);
	$pdf->cell(163.5,5,$_POST[dproto][$x].' - '.$row[1],'TL',1,'L',1);

	$sqlr="Select * from planacareas where planacareas.estado='S' and codarea='".$_POST[darea][$x]."'";
	$resp = mysql_query($sqlr,$link);
	$row =mysql_fetch_row($resp);

	$pdf->SetFont('Arial','B',10);
	$pdf->cell(35.2,5,'Area:','T',0,'L',1);
	$pdf->SetFont('Arial','',10);
	$pdf->cell(163.5,5,$_POST[darea][$x].' - '.$row[1],'TL',1,'L',1);

	$sqlr="Select * from actiubicacion where estado='S' and id_cc='".$_POST[dubi][$x]."'";
	$resp = mysql_query($sqlr,$link);
	$row =mysql_fetch_row($resp);

	$pdf->SetFont('Arial','B',10);
	$pdf->cell(35.2,5,'Ubicacion:','T',0,'L',1);
	$pdf->SetFont('Arial','',10);
	$pdf->cell(163.5,5,$_POST[dubi][$x].' - '.$row[1],'TL',1,'L',1);

	$sqlr="select *from centrocosto where estado='S' and id_cc='".$_POST[dccs][$x]."'";
	$resp = mysql_query($sqlr,$link);
	$row =mysql_fetch_row($resp);

	$pdf->SetFont('Arial','B',10);
	$pdf->cell(35.2,5,'Centro de Costos:','T',0,'L',1);
	$pdf->SetFont('Arial','',10);
	$pdf->cell(163.5,5,$_POST[dccs][$x]." - ".$row[1],'TL',1,'L',1);

	$sqlr="select estadoactivo from acticrearact_det where codigo='".$_POST[orden]."' and tipo_mov='101'";
	$resp = mysql_query($sqlr,$link);
	$row =mysql_fetch_row($resp);

	$pdf->SetFont('Arial','B',10);
	$pdf->cell(35.2,5,'Estado:','T',0,'L',1);
	$pdf->SetFont('Arial','',10);
	$pdf->cell(163.5,5,strtoupper($row[0]),'TL',1,'L',1);

	$pdf->RoundedRect(10, 58 ,199 , 68, 2,'' );

	$pdf->ln(32);
	$pdf->SetFont('times','B',9);
	$pdf->Cell(50);	
	$v=$pdf->gety();
	$pdf->Line(17,$v,107,$v);
	$pdf->Line(112,$v,202,$v);
	$v2=$pdf->gety();
	$pdf->Cell(4,4,'',0,1,'C',false,0,0,false,'T','C');
	$pdf->Cell(104,4,'ELABORO',0,1,'C',false,0,0,false,'T','C');
	$pdf->SetY($v2);
	$pdf->Cell(295,4,'',0,1,'C',false,0,0,false,'T','C');
	$pdf->Cell(295,4,'REVISO',0,1,'C',false,0,0,false,'T','C');

	$pdf->ln(20);
	$pdf->SetFont('times','B',9);
	$pdf->Cell(50);	
	$v=$pdf->gety();
	$pdf->Line(70,$v,150,$v);

	$pdf->Cell(105,4,''.$_POST[ntercero],0,1,'C',false,0,0,false,'T','C');
	$pdf->Cell(200,4,'RESPONSABLE',0,1,'C',false,0,0,false,'T','C');

	$pdf->SetFont('times','',10);
	$pdf->cell(25);
	$pdf->Cell(55,4,'',0,1,'C'); 
}
$pdf->Output();
?> 


