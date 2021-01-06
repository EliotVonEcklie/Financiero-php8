<?php //V 1000 12/12/16 ?> 
<?php
	require('fpdf.php');
	require('comun.inc');
	require('funciones.inc');
	session_start();
   	date_default_timezone_set("America/Bogota");
	class PDF extends FPDF
	{
		function Header()
		{	
  			$linkbd=conectar_bd();	
			$sqlr="SELECT * FROM configbasica WHERE estado='S'";
			$row=mysql_fetch_row(mysql_query($sqlr,$linkbd));
	  		$nit=$row[0];$rs=$row[1];
			$detalles='INFORMACION GENERAL';
			$this->Image('imagenes/eng.jpg',30,10,25,25);
			$this->SetFont('Arial','B',10);
			$this->SetY(10);
			$this->RoundedRect(10, 10, 260, 31, 1,'' );
			$this->Cell(0.1);
			$this->Cell(65,31,'','R',0,'L'); 
			$this->SetY(31);
			$this->Cell(0.1);
			$this->Cell(65,5,''.$rs,0,0,'C'); 
			$this->SetFont('Arial','B',8);
			$this->SetY(35);
			$this->Cell(0.1);
			$this->Cell(65,5,''.$nit,0,0,'C');
			$this->SetFont('Arial','B',14);
			$this->SetY(8);
			$this->Cell(65.1);
			$this->Cell(195,20,'LISTADO DE PREDIOS',0,0,'C'); 
			$this->SetFont('Arial','I',10);
			$this->SetY(27);
			$this->Cell(65);
			$this->multiCell(195,10,''.$detalles,'T','C');
			$this->SetFont('Arial','B',10);
			$this->SetY(27);
			$this->Cell(50.2);
			$this->MultiCell(105.7,4,'',0,'L');		
			$this->SetFont('times','B',10);
		}
		function Footer()
		{
			$totalineas=count($_POST[codcath]);
			$ntotap=ceil($totalineas / 30);
			$this->SetY(-15);
			$this->SetFont('Arial','I',8);
			$this->Cell(0,10,'Impreso por: Software SPID - G&C Tecnoinversiones SAS. - Pagina '.$this->PageNo().' de '.$ntotap,0,0,'R');  	
		}
	}
	$linkbd=conectar_bd();
	$pdf=new PDF('L','mm','Letter'); 
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Times','',10);
	$pdf->SetAutoPageBreak(true,20);
	$interv=4.5;
	$con=0;
	while ($con<count($_POST[codcath])) 
	{
		if($interv==4.5)
		{
			$pdf->line(10,45,270,45);
			$pdf->RoundedRect(10,46, 260, 5, 1,'' );
			$pdf->line(10,52,270,52);
			$pdf->SetFont('Arial','B',9);
			$pdf->SetY(46);
			$pdf->Cell(0.1);
			$pdf->Cell(26,5,'Código Ctral.',0,1,'C'); 
			$pdf->SetY(46);
			$pdf->Cell(26.1);
			$pdf->Cell(20,5,'Avaluó',0,1,'C');
			$pdf->SetY(46);
			$pdf->Cell(46.1);
			$pdf->Cell(20,5,'Documento',0,1,'C');
			$pdf->SetY(46);
			$pdf->Cell(66.1);
			$pdf->Cell(45,5,'Propietario',0,1,'C');
			$pdf->SetY(46);
			$pdf->Cell(111.1);
			$pdf->Cell(45,5,'Dirección',0,1,'C');
			$pdf->SetY(46);
			$pdf->Cell(156.1);
			$pdf->Cell(16,5,'Ha',0,1,'C');
			$pdf->SetY(46);
			$pdf->Cell(172.1);
			$pdf->Cell(18,5,'Mt²',0,1,'C');
			$pdf->SetY(46);
			$pdf->Cell(190.1);
			$pdf->Cell(20,5,'Area Cons.',0,1,'L');
			$pdf->SetY(46);
			$pdf->Cell(210.1);
			$pdf->Cell(18,5,'Tipo',0,1,'C');
			$pdf->SetY(46);
			$pdf->Cell(228.1);
			$pdf->Cell(29,5,'Estrato o Rango',0,1,'C');
		}
		if ($con%2==0){$pdf->SetFillColor(245,245,245);}
		else{$pdf->SetFillColor(255,255,255);}
		$pdf->SetFont('Times','',8);
		$pdf->SetY(50+$interv);
		$pdf->Cell(0.1);
		$pdf->cell(26,5,$_POST[codcath][$con],0,0,'L',1); 
		$pdf->SetY(50+$interv);
		$pdf->Cell(26.1);
		$pdf->cell(20,5,number_format($_POST[avaluoh][$con],0,".",","),0,0,'R',1);
		$pdf->SetY(50+$interv);
		$pdf->Cell(46.1);
		$pdf->cell(20,5,$_POST[documeh][$con],0,0,'R',1);
		$pdf->SetY(50+$interv);
		$pdf->Cell(66.1);
		$pdf->cell(45,5,substr(ucwords(strtolower($_POST[propieh][$con])),0,35),0,0,'L',1);
		$pdf->SetY(50+$interv);
		$pdf->Cell(111.1);
		$pdf->cell(45,5,substr(ucwords(strtolower($_POST[direcch][$con])),0,35),0,0,'L',1);
		$pdf->SetY(50+$interv);
		$pdf->Cell(156.1);
		$pdf->cell(16,5,substr($_POST[hah][$con].'   ',0,12),0,0,'R',1);
		$pdf->SetY(50+$interv);
		$pdf->Cell(172.1);
		$pdf->cell(18,5,$_POST[mt2h][$con],0,0,'C',1);
		$pdf->SetY(50+$interv);
		$pdf->Cell(190.1);
		$pdf->cell(20,5,$_POST[areconh][$con].'  ',0,0,'R',1);
		$pdf->SetY(50+$interv);
		$pdf->Cell(210.1);
		$pdf->cell(18,5,$_POST[tipoh][$con],0,0,'C',1);
		$pdf->SetY(50+$interv);
		$pdf->Cell(228.1);
		$pdf->cell(29,5,$_POST[estrath][$con],0,0,'C',1);
		$con=$con+1;
		if ($interv < 135){$interv=$interv+4.5;}
		else{$pdf->line(10,56.5+$interv,270,56.5+$interv);$interv=4.5;$pdf->AddPage();}
	}
	
	//if($interv>123.9){$pdf->AddPage();$interv=4.5;}
	if($interv != 4.5){$pdf->line(10,52+$interv,270,52+$interv);}
	
	$pdf->Output();
?>