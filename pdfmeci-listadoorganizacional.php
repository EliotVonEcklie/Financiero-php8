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
        $res=mysql_query($sqlr,$linkbd);
        while($row=mysql_fetch_row($res))
        {
            $nit=$row[0];
            $rs=$row[1];
        }
        $clase = $_POST[proceso];
        switch($_POST[proceso])
        {
            case "TODO": $clase="TODOS";break;
            case "VIS": $clase="VISIÓN";break;
            case "MIS": $clase="MISIÓN";break;
            case "PCL": $clase="POLITICA DE CALIDAD";break;
            case "OBJ": $clase="OBJETIVOS";break;
        }
        $clase=utf8_decode($clase);

        //Parte Izquierda
        $this->Image('imagenes/eng.jpg',22, 12, 25, 23.9, 'JPG', '', 'T', true, 300, '', false, false, 0, false, false, false);
        $this->SetFont('Arial','B',7);
        $this->SetY(10);
        $this->RoundedRect(10, 10, 199, 31, 2,'' );
        $this->Cell(0.1);
        $this->Cell(50,31,'','R',0,'L'); 

        /*Cuadro Derecho
        
        $this->SetFont('helvetica','B',9);
        $this->SetY(27);
        $this->SetX(162.5);
        $this->Cell(37,5," NUMERO: ".$_POST[numero],"L",0,'L');
        $this->SetY(31);
        $this->SetX(162.5);
        $this->Cell(35,6," FECHA: ".$_POST[fecha],"L",0,'L');
        $this->SetY(36);
        $this->SetX(162.5);
        $this->Cell(35,5," VIGENCIA: ".$_POST[vigencia],"L",0,'L');*/
        
        //*****************************************************************************************************************************
        $this->SetFont('Arial','B',14);
        $this->SetY(10);
        $this->Cell(50.1);
        $this->Cell(149,31,'',0,1,'C'); 


        $this->SetY(8);
        $this->Cell(50.1);
        $this->Cell(149,19,$rs,'B',0,'C'); 
        $this->SetY(20);
        $this->Cell(50.1);
        $this->Cell(149,5,$nit,0,0,'C');

        $this->SetY(32);
        $this->Cell(50.2);
        $this->SetFont('Arial','B',10);
        $this->MultiCell(65.7,5,'ESTRUCTURA ORGANIZACIONAL','','L');			
        $this->SetY(46);
        $this->ln(4);
        
        
        $this->SetFont('Arial','B',10);
        $this->cell(0.1);
        $this->multicell(199,4,'OBJETO: LISTADO ESTRUCTURA ORGANIZACIONAL - CLASE DEL PROCESO: '.$clase,0);		
        $this->line(10,60,209,60);
        $this->RoundedRect(10,61, 199, 5, 1,'' );



        //********************************************************************************************************************************
        
        $this->SetFont('Arial','B',9);
        $this->SetY(61);
        $this->Cell(18,5,'Item ',0,1,'C'); 
        $this->SetY(61);
        $this->Cell(60,5,'Clase',0,1,'C');		
        $this->SetY(61);
        $this->Cell(160,5,utf8_decode('Descripción'),0,1,'C');
        $this->SetY(61);
        $this->Cell(260,5,utf8_decode('Versión'),0,1,'C');
        $this->SetY(61);
        $this->Cell(320,5,'Fecha',0,1,'C');
        $this->SetY(61);
        $this->Cell(380,5,'Estado',0,1,'C');
        
        $this->line(10,67,209,67);
        $this->ln(2);
                
        //***********************************************************************************************************************************
        

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
$pdf=new PDF('P','mm','Letter'); 
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Times','',10);

$pdf->SetAutoPageBreak(true,20);
$pdf->SetY(68); 

$linkbd=conectar_bd();					
$crit1=" ";
if($_POST[proceso]!="TODO")
{
    if ($_POST[proceso]!="TODO"){$crit1=" AND clase='$_POST[proceso]' ";}
    $sqlr="SELECT * FROM meciestructuraorg WHERE estado<>'' ".$crit1." ORDER BY id DESC";
    $resp = mysql_query($sqlr,$linkbd);
    $ntr = mysql_num_rows($resp);
    $con=1;
    while ($row =mysql_fetch_row($resp)) 
    {
        switch($row[1])
        {
            case "VIS": $clase="Visión";break;
            case "MIS": $clase="Misión";break;
            case "PCL": $clase="Politica de Calidad";break;
            case "OBJ": $clase="Objetivos";break;
        }
        if($row[5]=='S')
        {
            $imgsem="Activo";
            $desc = substr(ucwords(strtolower(str_replace("&lt;br/&gt;","\n",$row[4]))), 0, 80);

            $clase=utf8_decode($clase);

            $pdf->Cell(15,5,$con,0,0,'C');
            $pdf->Cell(30,5,$clase,0,0,'C');
            $x=$pdf->GetX(); $y=$pdf->GetY(); 
            $w=70;
            $pdf->MultiCell(70,5,$desc,0,'J',false);
            $pdf->SetXY($x+$w,$y);
            $pdf->Cell(30,5,$row[2],0,0,'C');
            $pdf->Cell(30,5,date("d-m-Y",strtotime($row[3])),0,0,'C');
            $pdf->Cell(30,5,$imgsem,0,0,'C');
            $pdf->ln(4);
            $con+=1;
        }
        else
        {
            $imgsem="Inactivo";
        }
        
    }
}else{

    $sqlr="SELECT * FROM meciestructuraorg WHERE estado<>'' ORDER BY clase DESC";
    $resp = mysql_query($sqlr,$linkbd);
    $ntr = mysql_num_rows($resp);
    $con=1;
    while ($row =mysql_fetch_row($resp)) 
    {
        switch($row[1])
        {
            case "VIS": $clase="Visión";break;
            case "MIS": $clase="Misión";break;
            case "PCL": $clase="Politica de Calidad";break;
            case "OBJ": $clase="Objetivos";break;
        }
        if($row[5]=='S')
        {
            $imgsem="Activo";
            $desc = substr(ucwords(strtolower(str_replace("&lt;br/&gt;","\n",$row[4]))), 0, 80);

            $clase=utf8_decode($clase);
            $pdf->Cell(15,5,$con,0,0,'C');
            $pdf->Cell(30,5,$clase,0,0,'C');
            $x=$pdf->GetX(); $y=$pdf->GetY(); 
            $w=70;
            $pdf->MultiCell(70,5,$desc,0,'J',false);
            $pdf->SetXY($x+$w,$y);
            $pdf->Cell(30,5,$row[2],0,0,'C');
            $pdf->Cell(30,5,date("d-m-Y",strtotime($row[3])),0,0,'C');
            $pdf->Cell(30,5,$imgsem,0,0,'C');
            $pdf->ln(10);
            $con+=1;
        }
        else
        {
            $imgsem="Inactivo";
        }

    }
}




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

