<?php //V 1000 12/12/16 ?> 
<?php
	require('fpdf.php');
	session_start();
	date_default_timezone_set("America/Bogota");
	//*****las variables con los contenidos***********
	//**********pdf*******
	class PDF extends FPDF
	{
		//Cabecera de página
		function Header()
		{	
  			$rs="Municipio de Cubarral";
 			$nit="892000812-0";
 			$nalca="RIVERA RINCON JAIRO ";
			//Parte Izquierda
			$this->Image('imagenes/eng.jpg',23,10,25,25);
			$this->SetFont('Arial','B',10);
			$this->SetY(10);
			$this->RoundedRect(10, 10, 261, 31, 1,'' );
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
			$this->Cell(190,20,'REPORTE PLAN DE COMPRAS ',0,0,'C'); 
			//************************************
			$this->SetFont('Arial','I',10);
			$this->SetY(27);
			$this->Cell(50.2);
			$this->multiCell(169.8,7,' Se Filtro por: '.strtoupper($_POST[detallefill]),'T','L');
	   		$this->SetFont('Arial','B',10);
			$this->SetY(27);
			$this->Cell(220.1);
			$this->Cell(40.8,14,'','TL',0,'L');
			$this->SetY(27);
			$this->Cell(220);
			$this->Cell(35,5,'RESULTADOS : '.$_POST[nresultados],10,0,'L');
			$this->SetY(31);
			$this->Cell(220);
			$this->Cell(35,5,'FECHA: '.date("d/m/Y"),0,0,'L');
			$this->SetY(35);
			$this->Cell(220);
			$this->Cell(35,5,'',0,0,'L');
			$this->SetY(27);
			$this->Cell(50.2);
			$this->MultiCell(105.7,4,'',0,'L');		
			//***************************************************************************************************************
			$this->SetFont('times','B',10);
			$this->ln(12);
			//***************************************************************************************************************
		}
		//Pie de página
		function Footer()
		{
			$this->SetY(-15);
			$this->SetFont('Arial','I',10);
			$this->Cell(0,10,'Impreso por: Software SPID - G&C Tecnoinversiones SAS. - Pagina '.$this->PageNo().' de {nb}',0,0,'R'); // el parametro {nb} 	
		}
	}
	//Creación del objeto de la clase heredada
	$pdf=new PDF('L','mm','Letter'); 
	$pdf->AliasNbPages();
	$pdf->AddPage();	
	$y=$pdf->GetY();	
	$pdf->SetY($y);
	$pdf->SetFillColor(222,222,222);
	$pdf->SetFont('Arial','B',10);
    $pdf->Cell(0.1);
    $pdf->Cell(261,5,'ADQUISICIONES',0,0,'C',1); 
 	$pdf->ln(6); 
	$y=$pdf->GetY();	
	$pdf->SetFillColor(222,222,222);
	$pdf->SetFont('Arial','B',10);
	$pdf->SetY($y);
    $pdf->Cell(0.1);
    $pdf->Cell(16,5,'Codigos',0,0,'C',1); 
	$pdf->SetY($y);
	$pdf->Cell(17.1);
	$pdf->Cell(78,5,'Descripcion',0,0,'C',1);
	$pdf->SetY($y);
	$pdf->Cell(96);
	$pdf->Cell(20,5,'Fecha',0,0,'C',1);
	$pdf->SetY($y);
	$pdf->Cell(117);
	$pdf->Cell(20,5,'Duracion',0,0,'C',1);
	$pdf->SetY($y);
	$pdf->Cell(138);
	$pdf->Cell(30,5,'Modalidad',0,0,'C',1);
	$pdf->SetY($y);
	$pdf->Cell(169);
	$pdf->Cell(30,5,'Fuente',0,0,'C',1);
	$pdf->SetY($y);
	$pdf->Cell(200);
	$pdf->Cell(30,5,'Vlr Estimado',0,0,'C',1);
	$pdf->SetY($y);
	$pdf->Cell(231);
	$pdf->Cell(30,5,'Vlr Estimado VA.',0,0,'C',1);
	$pdf->SetFont('Arial','',8);
	$cont=0;
	$pdf->ln(5); 
	$y=$pdf->GetY();
	for($k=0;$k<count($_POST[adqdescripcion]); $k++)
	{	
		$ymax=$y;
 		$codigos=$_POST[adqprodtodos][$k];	
		if ($con%2==0){$pdf->SetFillColor(255,255,255);}
		else{$pdf->SetFillColor(245,245,245);}
		$cadena=str_replace("-"," ",$_POST[adqprodtodos][$k]);
		$pdf->SetY($y+1);
		$pdf->MultiCell(16,4,$cadena,'0','L',1);
		$y1=$pdf->GetY();
		$pdf->SetY($y+1);
		$pdf->Cell(17);
		$pdf->MultiCell(78,4,''.strtoupper($_POST[adqdescripcion][$k]).$sy,'0','L');
		$y2=$pdf->GetY();
		$pdf->SetY($y+1);
		$pdf->Cell(97);
		$pdf->MultiCell(18,4,''.$_POST[adqfecha2][$k],'0','L');		
		$pdf->SetY($y+1);
		$pdf->Cell(120);
		if ($_POST[adqduracion][$k]>1){$admes=" Meses";}
		else {$admes=" Mes";}
		$pdf->MultiCell(15,4,''.$_POST[adqduracion][$k].$admes,'0','L');
		$pdf->SetY($y+1);
		$pdf->Cell(138);
		$pdf->MultiCell(30,4,''.$_POST[adqmodalidad2][$k],'0','L');	
		$y3=$pdf->GetY();
		$pdf->SetY($y+1);
		$pdf->Cell(169);
		$pdf->MultiCell(30,4,''.$_POST[adqfuente2][$k],'0','L');
		$pdf->SetY($y+1);
		$pdf->Cell(200);
		$pdf->MultiCell(30,4,'$'.number_format($_POST[adqvlrestimado][$k],0),'0','R');
		$pdf->SetY($y+1);
		$pdf->Cell(231);
		$pdf->MultiCell(30,4,'$'.number_format($_POST[adqvlrvig][$k],0),'0','R');				
		$con=$con+1;
		if($y1<$y2)
		{
			if($y3<$y2){$y=$y2;}
			else {$y=$y3;}
		}
		else 
		{
			if($y3<$y1){$y=$y1;}
			else {$y=$y3;}
		}
	}
	$pdf->Output();
?> 