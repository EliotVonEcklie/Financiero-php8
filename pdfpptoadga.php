<?php
//V 1000 12/12/16 
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
    //Parte Izquierda
    $this->Image('imagenes/eng.jpg',18,12,38,20);
	$this->SetFont('Arial','B',10);
	$this->SetY(10);
	$this->RoundedRect(10, 10, 199, 31, 2.5,'' );
	$this->Cell(0.1);
    $this->Cell(50,31,'','R',0,'L'); 
	$this->SetY(31);
    $this->Cell(0.1);
    $this->Cell(50,5,''.$_POST[nomemp],0,0,'C'); 
	$this->SetFont('Arial','B',8);
	$this->SetY(35);
    $this->Cell(0.1);
    $this->Cell(50,5,''.$_POST[nit],0,0,'C'); //Cuadro Izquierda

	
    //*****************************************************************************************************************************
	$this->SetFont('Arial','B',14);
	$this->SetY(10);
    $this->Cell(50.1);
    $this->Cell(149,31,'',0,1,'C'); 


	$this->SetY(8);
    $this->Cell(50.1);
    $this->Cell(149,25,''.$_POST[adre].' / '.$_POST[adre1],0,0,'C'); 
	//************************************
    $this->SetFont('Arial','B',10);
	
	$this->SetY(29);
    $this->Cell(161.1);
	$this->Cell(38,12,'','TL',0,'L');
	
	
	$this->SetY(30);
    $this->Cell(162);
	$this->Cell(35,5,'VIGENCIA : '.$_POST[vigencia],0,0,'L');
	$this->SetY(34);
    $this->Cell(162);
	$this->Cell(35,5,'FECHA:  '.$_POST[fecha],0,0,'L');

	$this->SetY(29);
	$this->Cell(50.2);

	$this->MultiCell(110.7,4,'Acto Administrativo No. : '.$_POST[nomacuerdo],'T','L');		


//********************************************************************************************************************************
		
	$this->line(10.1,42,209,42);
	$this->RoundedRect(10,43, 199, 5, 1.2,'' );
	$this->SetFont('Arial','B',10);
	$this->SetY(43);
    $this->Cell(0.1);
    $this->Cell(30,5,'CODIGO ',0,1,'C'); 
		$this->SetY(43);
    	$this->Cell(22.1);
		$this->Cell(93,5,'CUENTA',0,1,'C');
			$this->SetY(43);
        	$this->Cell(123.1);
			$this->Cell(38,5,'INGRESOS',0,1,'C');
			$this->SetY(43);
        	$this->Cell(161.1);
			$this->Cell(38,5,'GASTOS',0,1,'C');
			$this->line(10.1,49,209,49);
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
//$pdf=new PDF('P','mm',array(210,140));
$pdf=new PDF('P','mm','Letter'); 
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Times','',10);


$pdf->SetAutoPageBreak(true,20);



$pdf->SetY(50);   
$con=0;


//while ($con<$_POST[control])
while ($con<count($_POST[dcuentas]))
{	if ($con%2==0)
	{$pdf->SetFillColor(245,245,245);
	}
    else
	{$pdf->SetFillColor(255,255,255);
	}
	

    $pdf->Cell(30,4,''.$_POST[dcuentas][$con],0,0,'L',1);//descrip

    $pdf->Cell(93,4,substr(''.ucwords(strtolower($_POST[dncuentas][$con])),0,56),0,0,'L',1);//descrip

    //$pdf->Cell(8,4,substr(''.$_POST[balan][2],0,4),1,0,'R',1);//descrip

   // $pdf->Cell(32,4,substr(''.$_POST[balan][3],0,28),0,0,'L',1);//descrip

    $pdf->Cell(38,4,''.$_POST[dingresos][$con],0,0,'R',1);//descrip

  $pdf->Cell(38,4,''.$_POST[dgastos][$con],0,0,'R',1);
	$pdf->ln(4);	

$con=$con+1;
}
	
	$pdf->SetFont('Arial','B',10);
	$pdf->ln(4);
//	$pdf->cell(103);
	$pdf->SetLineWidth(0.5);
	$pdf->cell(91,5,'','T',0,'R');
	$pdf->cell(32,5,'Total','T',0,'R');

	$pdf->cell(38,5,''.$_POST[cuentaing],'T',0,'R');

	$pdf->cell(38,5,''.$_POST[cuentagas],'T',0,'R');
		
	$pdf->ln(10);
	$pdf->SetLineWidth(0.2);
	
	$v=$pdf->gety();
	$pdf->RoundedRect(10, $v-1, 199, 10, 1.2,'' );
	$pdf->MultiCell(199,4,'SON: '.$_POST[letras],0,'L');
	$pdf->ln(20);
	$pdf->cell(60);
	$pdf->Cell(80,5,'SECRETARIA ADMINISTRATIVA Y FINANCIERA','T',0,'C');
	
	
	



//********************************************************************************************************************************
	//$pdf->SetY(77); //**********CUADRO
    //$pdf->Cell(5);
   // $pdf->Cell(185,44,'',1,0,'R');

//***********************************************************************************************************************************************
//************************************************************************************************************************************************
	
//**********************************************************************************************************
$pdf->Output();
?> 


