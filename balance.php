<?php //V 1000 12/12/16 ?> 
<?php
require('fpdf.php');
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
    //Logo
    $this->Image('imagenes/eng.jpg',18,12,38,20);
	
				$this->SetFont('Arial','B',10);
	$this->SetY(10);
    $this->Cell(0.5);
    $this->Cell(50,31,'',1,0,'L'); 
	$this->SetY(31);
    $this->Cell(0.5);
    $this->Cell(50,5,'Alcaldia de Cubarral',0,0,'C'); 
	
	
	$this->SetFont('Arial','B',8);
	$this->SetY(35);
    $this->Cell(0.5);
    $this->Cell(50,5,'Nit 89654321',0,0,'C'); //CUADRO LOGO
	

	
    //*****************************************************************************************************************************
	$this->SetFont('Arial','B',14);
	$this->SetY(10);
    $this->Cell(50.5);
    $this->Cell(146.5,31,'BALANCE',1,1,'C'); 
	//************************************
    $this->SetFont('Arial','B',10);
	$this->SetY(31);
    $this->Cell(54);
	$this->Cell(135,5,'Desde: '.$_POST[inicial].' Hasta:'.$_POST[finalf],0,0,'C');
	$this->line(10.5,42,207,42);
	$this->line(10.5,43,207,43);
//********************************************************************************************************************************
	
	$this->SetFont('Arial','B',10);
	$this->SetY(43);
    $this->Cell(0.5);
    $this->Cell(22,5,'Cod. Cuenta ',0,0,'C'); 
		$this->SetY(43);
    	$this->Cell(22.5);
		$this->Cell(50.5,5,'Nombre de la Cuenta',0,0,'C');
			$this->SetY(43);
        	$this->Cell(73);
			$this->Cell(31,5,'Saldo Anterior',0,0,'C');
			$this->SetY(43);
        	$this->Cell(104);
			$this->Cell(62,5,'Movimiento Mes',0,0,'C');
			$this->SetY(43);
        	$this->Cell(166);
			$this->Cell(31,5,'Saldo Final',0,0,'C');
			$this->SetY(47);
        	$this->Cell(104);
			$this->Cell(31,5,'Debitos',0,0,'C');
			$this->SetY(47);
        	$this->Cell(135);
			$this->Cell(31,5,'Creditos',0,0,'C');
			$this->line(10.5,52,207,52);
			$this->line(10.5,53,207,53);
//***********************************************************************************************************************************
}
//Pie de página
function Footer()
{
   		//****************************
   	    //$this->SetY(-15);
}
}

//Creación del objeto de la clase heredada
//$pdf=new PDF('P','mm',array(210,140));
$pdf=new PDF('P','mm','Letter'); 
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',10);
 
    $pdf->SetY(55);
    $pdf->Cell(0.5);
    $pdf->Cell(22,4,''.$_POST[cuenta],0,1,'L');//descrip
    
	$pdf->SetY(55);
    $pdf->Cell(22.5);
    $pdf->Cell(50.5,4,''.$_POST[nombrec],0,1,'L');//descrip

    $pdf->SetY(55);
    $pdf->Cell(73);
    $pdf->Cell(31,4,"".$_POST[saldoini],0,1,'R');//descrip

    $pdf->SetY(55);
    $pdf->Cell(104);
    $pdf->Cell(31,4,"".$_POST[credito],0,1,'R');//descrip

    $pdf->SetY(55);
    $pdf->Cell(135);
    $pdf->Cell(31,4,"".$_POST[debito],0,1,'R');//descrip

    $pdf->SetY(55);
    $pdf->Cell(166);
    $pdf->Cell(31,4,"".$_POST[saldofin],0,1,'R');

//********************************************************************************************************************************
	//$pdf->SetY(77); //**********CUADRO
    //$pdf->Cell(5);
   // $pdf->Cell(185,44,'',1,0,'R');

//***********************************************************************************************************************************************
//************************************************************************************************************************************************
	
//**********************************************************************************************************
$pdf->Output(); 
?>  


