<?php
require('fpdf.php');
require('comun.inc');
require"funciones.inc";
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
	}
	if($_POST[tinforme]==1){
		$listado= "PROCESO";
	}else{
		$listado= "DOCUMENTO";
	}



		//Parte Izquierda
	$this->Image('imagenes/eng.jpg',18,12,30,20);
	$this->SetFont('Arial','B',7);
	$this->SetY(10);
	$this->RoundedRect(10, 10, 199, 31, 2,'' );
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
	$this->Cell(149,19,'LISTADO MAESTRO POR '.$listado,'B',0,'C'); 
	//************************************
	$this->SetFont('Arial','B',10);



	$ncc=$_POST[listado];
	if($ncc==0){
		$ncc='TODOS';
	}else {
		$linkbd=conectar_bd();
		if ($_POST[tinforme]==1) {
			$sqlr="SELECT nombre FROM calprocesos where id=$ncc";
			$res=mysql_query($sqlr,$linkbd);
			$ncc=mysql_fetch_row($res);
			$ncc=$ncc[0];
		}else{
			$sqlr="SELECT nombre FROM caldocumentos where id=$ncc";
			$res=mysql_query($sqlr,$linkbd);
			$ncc=mysql_fetch_row($res);
			$ncc=$ncc[0];
		}
	}
	$this->SetY(32);
	$this->Cell(50.2);
	$this->MultiCell(65.7,5,''.$listado.':'.$ncc,'','L');			
	$this->SetFont('Arial','B',12);
	$this->SetY(46);
	$this->ln(4);
	
	
	$this->SetFont('Arial','B',10);
	$this->cell(0.1);
	$this->multicell(199,4,'OBJETO: SOLICITUD DE LISTADO MAESTRO POR '.$listado,0);		
	$this->line(10,60,209,60);
	$this->RoundedRect(10,61, 199, 5, 1,'' );


	if ($_POST[tinforme]==2) {
		//********************************************************************************************************************************
		
		$this->SetFont('Arial','B',9);
		$this->SetY(61);
		$this->Cell(18,5,'Item ',0,1,'C'); 
		$this->SetY(61);
		$this->Cell(60,5,'Documentos',0,1,'C');		
		$this->SetY(61);
		$this->Cell(120,5,'Codigo',0,1,'C');
		$this->SetY(61);
		$this->Cell(220,5, 'Titulo',0,1,'C');
		$this->SetY(61);
		$this->Cell(340,5, 'Proceso',0,1,'C');
		
		$this->line(10,67,209,67);
		$this->ln(2);
				
		//***********************************************************************************************************************************
	}else {
		//********************************************************************************************************************************
		
		$this->SetFont('Arial','B',9);
		$this->SetY(61);
		$this->Cell(18,5,'Item ',0,1,'C'); 
		$this->SetY(61);
		$this->Cell(60,5,'Procesos',0,1,'C');		
		$this->SetY(61);
		$this->Cell(120,5,'Codigo',0,1,'C');
		$this->SetY(61);
		$this->Cell(195,5, 'Titulo',0,1,'C');
		$this->SetY(61);
		$this->Cell(310,5, 'Documentos',0,1,'C');
		
		$this->line(10,67,209,67);
		$this->ln(2);
				
		//***********************************************************************************************************************************
	}

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
$pdf=new PDF('P','mm','Letter'); 
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Times','',8);

$pdf->SetAutoPageBreak(true,20);
$pdf->SetY(68); 

if($_POST[tinforme]==2){
	$linkbd=conectar_bd();
	$crit1=" ";
	$crit2=" ";
	$namearch="informacion/temp/documentos_en_mejora.csv";
	if ($_POST[listado]!="0"){$crit1=" AND documento='$_POST[listado]'";}
	if ($_POST[documento]!=""){$crit2=" AND cgd.codigospid LIKE '%$_POST[documento]%' ";}
	$sqlr="SELECT distinct documento FROM calgestiondoc WHERE estado='S' ".$crit1.$crit2." ORDER BY documento, id";
	$resp = mysql_query($sqlr,$linkbd);
	$ntr = mysql_num_rows($resp);
	$con=1;

	$iter='saludo1';
	$iter2='saludo2';
	while ($row =mysql_fetch_row($resp)) 
	{
		$sqlr2="SELECT cgd.*, cld.* FROM calgestiondoc cgd, callistadoc cld WHERE cgd.idarchivo=cld.id AND cgd.estado='S' AND cgd.documento=".$row[0]." ".$crit1.$crit2." ORDER BY cgd.documento, cgd.id";
		$resp2=mysql_query($sqlr2,$linkbd);
		$row2 =mysql_fetch_row($resp2);
		$ntr2 = mysql_num_rows($resp2);
		$sqlr3="SELECT nombre FROM caldocumentos WHERE id='".$row[0]."'";
		$res3=mysql_query($sqlr3,$linkbd);
		$row3 = mysql_fetch_row($res3);
		$documentos=$row3[0];
		$sqlr3="SELECT nombre FROM calprocesos WHERE id='".$row2[1]."'";
		$res3=mysql_query($sqlr3,$linkbd);
		$row3 = mysql_fetch_row($res3);
		$procesos=$row3[0];
		$sqlr3="SELECT descripcion_valor FROM dominios WHERE nombre_dominio='TIPOS_DE_POLITICAS' AND valor_inicial='".$row2[3]."'";
		$res3=mysql_query($sqlr3,$linkbd);
		$row3 = mysql_fetch_row($res3);
		$politicas=$row3[0];
		$nombredel=strtoupper($documentos);
		//$bdescargar='<a href="informacion/calidad_documental/documentos/'.$row2[15].'" target="_blank" ><img src="imagenes/descargar.png" title=\'(Descargar)\' title="(Descargar)" ></a>';
		$nresul=buscaresponsable($row2[14]);
		
		if ($con%2==0)
		{$pdf->SetFillColor(245,245,245);
		}
		else
		{$pdf->SetFillColor(255,255,255);
		}

		$pdf->Cell(15,5,''.$con,0,0,'C',1);
		$pdf->Cell(30,5,''.strtoupper($nombredel),0,0,'C',1);
		$pdf->Cell(30,5,''.$row2[4],0,0,'C',1);
		$x=$pdf->GetX(); $y=$pdf->GetY(); 
		$w=80;
		$pdf->MultiCell(75,5,''.$row2[6],0,'J',true);
		$pdf->SetXY($x+$w,$y);
		$pdf->MultiCell(40,5,''.$procesos,0,'J',true);
		$pdf->ln(4);

		if($ntr2!=1)
		{
			
			while ($row2 =mysql_fetch_row($resp2))
			{	
				$sqlr3="SELECT nombre FROM calprocesos WHERE id='".$row2[1]."'";
				$res3=mysql_query($sqlr3,$linkbd);
				$row3 = mysql_fetch_row($res3);
				$procesos=$row3[0];
				$sqlr3="SELECT descripcion_valor FROM dominios WHERE nombre_dominio='TIPOS_DE_POLITICAS' AND valor_inicial='".$row2[3]."'";
				$res3=mysql_query($sqlr3,$linkbd);
				$row3 = mysql_fetch_row($res3);
				$politicas=$row3[0];
				$nombredel=strtoupper($documentos);
				//$bdescargar='<a href="informacion/calidad_documental/documentos/'.$row2[15].'" target="_blank" ><img src="imagenes/descargar.png" title=\'(Descargar)\' title="(Descargar)" ></a>';
				$nresul=buscaresponsable($row2[14]);
				$pdf->Cell(15);
				$pdf->Cell(30);
				$pdf->Cell(30,5,''.$row2[4],0,0,'C',1);
				$x=$pdf->GetX(); $y=$pdf->GetY(); 
				$w=80;
				$pdf->MultiCell(75,5,''.$row2[6],0,'J',true);
				$pdf->SetXY($x+$w,$y);
				$pdf->MultiCell(40,5,''.$procesos,0,'J',true);
				$pdf->ln(6);
			}
		}
		$con+=1;
		$aux=$iter;
		$iter=$iter2;
		$iter2=$aux;
	}
}else if ($_POST[tinforme]==1) {

	$linkbd=conectar_bd();
	$crit1=" ";
	$crit2=" ";
	$namearch="informacion/temp/documentos_en_mejora.csv";
	if ($_POST[listado]!="0"){$crit1=" AND proceso='$_POST[listado]'";}
	if ($_POST[documento]!=""){$crit2=" AND codigospid LIKE '%$_POST[documento]%' ";}
	$sqlr="SELECT distinct proceso FROM calgestiondoc WHERE estado='S' ".$crit1.$crit2." ORDER BY proceso, id";
	$resp = mysql_query($sqlr,$linkbd);
	$ntr = mysql_num_rows($resp);
	$con=1;
	$iter='saludo1';
	$iter2='saludo2';
	while ($row =mysql_fetch_row($resp)) 
	{	
		$sqlr2="SELECT cgd.*, cld.* FROM calgestiondoc cgd, callistadoc cld WHERE cgd.idarchivo=cld.id AND cgd.estado='S' AND cgd.proceso='".$row[0]."' ".$crit1.$crit2." ORDER BY cgd.proceso, cgd.id";
		$resp2 = mysql_query($sqlr2,$linkbd);
		$row2 =mysql_fetch_row($resp2);
		$ntr2 = mysql_num_rows($resp2);
		$sqlr3="SELECT nombre FROM calprocesos WHERE id='".$row[0]."'";
		$res3=mysql_query($sqlr3,$linkbd);
		$row3 = mysql_fetch_row($res3);
		$procesos=$row3[0];
		$sqlr3="SELECT nombre FROM caldocumentos WHERE id='".$row2[2]."'";
		$res3=mysql_query($sqlr3,$linkbd);
		$row3 = mysql_fetch_row($res3);
		$documentos=$row3[0];
		$sqlr3="SELECT descripcion_valor FROM dominios WHERE nombre_dominio='TIPOS_DE_POLITICAS' AND valor_inicial='".$row2[3]."'";
		$res3=mysql_query($sqlr3,$linkbd);
		$row3 = mysql_fetch_row($res3);
		$politicas=$row3[0];
		if($politicas==""){$nombredel=strtoupper($documentos);}
		else{$nombredel=strtoupper($politicas);}
		$bdescargar='<a href="informacion/calidad_documental/documentos/'.$row2[15].'" target="_blank" ><img src="imagenes/descargar.png" title=\'(Descargar)\' title="(Descargar)" ></a>';
		$nresul=buscaresponsable($row2[14]);

		if ($con%2==0)
		{$pdf->SetFillColor(245,245,245);
		}
		else
		{$pdf->SetFillColor(255,255,255);
		}

		$pdf->Cell(15,5,''.$con,0,0,'C',1);
		$x=$pdf->GetX(); $y=$pdf->GetY(); 
		$w=30;
		$pdf->MultiCell(30,5,''.strtoupper($procesos),0,'C',true);
		$pdf->SetXY($x+$w,$y);
		$pdf->Cell(30,5,''.$row2[4],0,0,'C',1);
		$x=$pdf->GetX(); $y=$pdf->GetY(); 
		$w=80;
		$pdf->MultiCell(75,5,''.$row2[6],0,'J',true);
		$pdf->SetXY($x+$w,$y);
		$pdf->MultiCell(40,5,''.$nombredel,0,'J',true);
		$pdf->ln(6);

		if($ntr2!=1)
		{
			while ($row2 =mysql_fetch_row($resp2))
			{	
				$sqlr3="SELECT nombre FROM caldocumentos WHERE id='".$row2[2]."'";
				$res3=mysql_query($sqlr3,$linkbd);
				$row3 = mysql_fetch_row($res3);
				$documentos=$row3[0];
				$sqlr3="SELECT descripcion_valor FROM dominios WHERE nombre_dominio='TIPOS_DE_POLITICAS' AND valor_inicial='".$row2[3]."'";
				$res3=mysql_query($sqlr3,$linkbd);
				$row3 = mysql_fetch_row($res3);
				$politicas=$row3[0];
				if($politicas==""){$nombredel=strtoupper($documentos);}
				else{$nombredel=strtoupper($politicas);}
				$bdescargar='<a href="informacion/calidad_documental/documentos/'.$row2[15].'" target="_blank" ><img src="imagenes/descargar.png" title=\'(Descargar)\' title="(Descargar)" ></a>';
				$nresul=buscaresponsable($row2[14]);

				$pdf->Cell(15);
				$pdf->Cell(30);
				$pdf->Cell(30,5,''.$row2[4],0,0,'C',1);
				$x=$pdf->GetX(); $y=$pdf->GetY(); 
				$w=80;
				$pdf->MultiCell(75,5,''.$row2[6],0,'J',true);
				$pdf->SetXY($x+$w,$y);
				$pdf->MultiCell(40,5,''.$nombredel,0,'J',true);
				$pdf->ln(6);
			}
		}
		$con+=1;
		$aux=$iter;
		$iter=$iter2;
		$iter2=$aux;
	}



}
  
//$con=0;



	$pdf->SetLineWidth(0.2);
	
	$pdf->ln(10);
$linkbd=conectar_bd();
$sqlr="select *from configbasica where estado='S'";
//echo $sqlr;
$res=mysql_query($sqlr,$linkbd);
while($row=mysql_fetch_row($res))
 {
  $nit=$row[0];
  $rs=$row[6];
 }


	$v=$pdf->gety();
	$pdf->ln(15);
	$pdf->cell(60);
	$pdf->Cell(80,5,''.strtoupper($rs),'T',0,'C');
	$pdf->ln(6);
	$pdf->cell(60);
	$pdf->Cell(80,5,'MECI CALIDAD','',0,'C');		
	
	



//********************************************************************************************************************************
	//$pdf->SetY(77); //**********CUADRO
    //$pdf->Cell(5);
   // $pdf->Cell(185,44,'',1,0,'R');

//***********************************************************************************************************************************************
//************************************************************************************************************************************************
	
//**********************************************************************************************************
$pdf->Output();
?> 


