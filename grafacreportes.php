<?php //V 1000 12/12/16 ?> 
<?php
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_pie.php');
require('fpdf.php');
require('comun.inc');
require"funciones.inc";
session_start();
class PDF extends FPDF{
	function Header(){//Cabecera de página************************************************************
	  	$linkbd=conectar_bd();	
		$sqlr="select *from configbasica where estado='S'";
		$res=mysql_query($sqlr,$linkbd);
		while($row=mysql_fetch_row($res)){
		  $nit=$row[0];
		  $rs=$row[1];
	 	}
		$detalles='Estadística de Documentos Radicados';
		
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
		$this->Cell(149,20,'DOCUMENTOS RADICADOS',0,0,'C'); 
//************************************
		$this->SetFont('Arial','I',10);
		$this->SetY(27);
		$this->Cell(50.2);
		$this->multiCell(149,5,''.strtoupper($detalles),'T','L');
		$this->SetFont('Arial','B',10);
		$this->MultiCell(105.7,4,'',0,'L');		
		$this->SetFont('times','B',10);
		$this->ln(12);
	}

	function Footer(){
		$this->SetY(-15);
		$this->SetFont('Arial','I',8);
		$this->Cell(0,10,'Impreso por: Software SPID - G&C Tecnoinversiones SAS. - Pagina '.$this->PageNo().' de 1',0,0,'R');  	
	}
}
	
  	$linkbd=conectar_bd();	
	unlink('grafico.png');

	//parametrizar grafico
	$datay=array();
	if(($_POST[fecini]!="")&&($_POST[fecfin]!="")){
		$sql1="SELECT COUNT(planacresponsables.codradicacion) FROM planacresponsables INNER JOIN planacradicacion ON planacresponsables.codradicacion=planacradicacion.numeror WHERE planacradicacion.fechar >= '$_POST[fecini]' AND planacradicacion.fechalimite >= '$_POST[fecfin]' AND planacresponsables.estado = 'A'";
	}
	else{
		$sql1="SELECT COUNT(planacresponsables.codradicacion) FROM planacresponsables INNER JOIN planacradicacion ON planacresponsables.codradicacion=planacradicacion.numeror WHERE planacradicacion.fechalimite >= CURDATE( ) AND planacresponsables.estado = 'A'";
	}
	$res1=mysql_query($sql1, $linkbd);
	$row1=mysql_fetch_array($res1);
	$totasig=$row1[0];
	$datay[0]=$totasig;
	//CONTESTADOS
	if(($_POST[fecini]!="")&&($_POST[fecfin]!="")){
		$sql2="SELECT COUNT(DISTINCT(p1.codradicacion)) FROM planacresponsables AS p1, planacradicacion AS p2 WHERE p2.fechar >= '$_POST[fecini]' AND p2.fechalimite >= '$_POST[fecfin]' AND p1.codradicacion=p2.numeror AND p1.fechares<=p2.fechalimite AND p1.estado='C'";
	}
	else{
		$sql2="SELECT COUNT(DISTINCT(p1.codradicacion)) FROM planacresponsables AS p1, planacradicacion AS p2 WHERE p1.codradicacion=p2.numeror AND p1.fechares<=p2.fechalimite AND p1.estado='C'";
	}
	$res2=mysql_query($sql2, $linkbd);
	$row2=mysql_fetch_array($res2);
	$totcon=$row2[0];
	$datay[1]=$totcon;
	//CONTESTADOS VENCIDOS
	if(($_POST[fecini]!="")&&($_POST[fecfin]!="")){
		$sql3="SELECT COUNT(DISTINCT(p1.codradicacion)) FROM planacresponsables AS p1, planacradicacion AS p2 WHERE p2.fechar >= '$_POST[fecini]' AND p2.fechalimite >= '$_POST[fecfin]' AND p1.codradicacion=p2.numeror AND p1.fechares>p2.fechalimite AND p1.estado='C'";
	}
	else{
		$sql3="SELECT COUNT(DISTINCT(p1.codradicacion)) FROM planacresponsables AS p1, planacradicacion AS p2 WHERE p1.codradicacion=p2.numeror AND p1.fechares>p2.fechalimite AND p1.estado='C'";
	}
	$res3=mysql_query($sql3, $linkbd);
	$row3=mysql_fetch_array($res3);
	$totcven=$row3[0];
	$datay[2]=$totcven;
	//VENCIDOS
	if(($_POST[fecini]!="")&&($_POST[fecfin]!="")){
		$sql4="SELECT COUNT(planacresponsables.codradicacion) FROM planacresponsables INNER JOIN planacradicacion ON planacresponsables.codradicacion=planacradicacion.numeror WHERE planacradicacion.fechar >= '$_POST[fecini]' AND planacradicacion.fechalimite < '$_POST[fecfin]' AND planacresponsables.estado = 'A'";
	}
	else{
		$sql4="SELECT COUNT(planacresponsables.codradicacion) FROM planacresponsables INNER JOIN planacradicacion ON planacresponsables.codradicacion=planacradicacion.numeror WHERE planacradicacion.fechalimite < CURDATE( ) AND planacresponsables.estado = 'A'";
	}
	$res4=mysql_query($sql4, $linkbd);
	$row4=mysql_fetch_array($res4);
	$totven=$row4[0];
	$datay[3]=$totven;
	$leyenda=array('A - Asignados ['.$totasig.']','C - Contestados ['.$totcon.']','CV - Contestados Vencidos ['.$totcven.']','V - Vencidos ['.$totven.']');	
	// pintar grafico
	$graph = new PieGraph(450,350);

//	$theme_class=new UniversalTheme;

/*	$graph->SetTheme($theme_class);
	$graph->img->SetAntiAliasing(false);
	$graph->title->Set('');
	$graph->SetBox(false);

	$graph->img->SetAntiAliasing();*/

	// Create the piegraph
	$p1 = new PiePlot($datay);
	$p1->SetLegends($leyenda);
	$p1->SetCenter(0.4);
//	$graph->legend->SetFrameWeight(1);
	$graph->legend->SetPos(0.15, 0.85);
	$graph->legend->SetColumns(2);
	$graph->Add($p1);
	$graph->Stroke('grafico.png');

	//Creación del objeto de la clase heredada
	$pdf=new PDF('P','mm','Letter'); 
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Times','',10);
	$pdf->SetAutoPageBreak(true,20);
	$pdf->SetFont('Arial','B',12);


	$pdf->Image("grafico.png",10,45,200,150);		
	$pdf->Ln(2);
	$pdf->Output();

?>