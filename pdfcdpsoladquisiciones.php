<?php
//V 1000 12/12/16 
	require('fpdf.php');
	require('comun.inc');
	require"funciones.inc";
	header('Content-Type: text/html; charset=utf-8');
	session_start();
    date_default_timezone_set("America/Bogota");
	//*****las variables con los contenidos***********
	//**********pdf*******
	$linkbd=conectar_bd();
	$sqlr="SELECT codcdp FROM contrasoladquisiciones  WHERE codsolicitud='".$_POST[codid]."'";
	$res=mysql_query($sqlr,$linkbd);
	$row =mysql_fetch_row($res);
	if($row[0]=="")
	{
		$sqlr2="UPDATE contrasoladquisiciones SET codcdp='S' WHERE codsolicitud='".$_POST[codid]."'";
		mysql_query($sqlr2,$linkbd);
	}
	
	$sql="SELECT descripcion,fecha,valtotalsol FROM contrasolicitudpaa WHERE codsolicitud='".$_POST[codigot]."' ";
	$res=mysql_query($sql,$linkbd);
	$fila=mysql_fetch_row($res);
	$_POST[descripciont]=$fila[0];
	$_POST[fechat]=$fila[1];
	$valorsol=$fila[2];
	$sql="SELECT codigossol,cantidadunit,valoresunit from contrasolicitudpaa WHERE codsolicitud='$_POST[codigot]'";
	$res=mysql_query($sql,$linkbd);
	$row = mysql_fetch_row($res);
	if(!empty($row[0])){
		$codunspsc1=explode("-",$row[0]);
		$cantidad=explode("-",$row[1]);
		$valores=explode("-",$row[2]);
		$i=0;
		foreach ($codunspsc1 as &$valor)
		{
			if(!empty($valor)){
				$sqlr2="SELECT nombre FROM productospaa WHERE codigo='$valor'";
				$row2 =mysql_fetch_row(mysql_query($sqlr2,$linkbd));
				$_POST[dproductos1][]=$valor;
				$_POST[dnproductos1][]=$row2[0]; 
				$nt=buscaproductotipo($valor);
				$_POST[dtipos1][]=buscadominiov2("UNSPSC",$nt);
				$_POST[dcantidad1][]=$cantidad[$i];
				$_POST[dvaluni1][]=$valores[$i];
				$i++;
			}
			
		}
	}	
	class PDF extends FPDF
	{
		//Cabecera de página
		function Header()
		{	
			$linkbd=conectar_bd();
			$sqlr="select *from configbasica where estado='S'";
			$res=mysql_query($sqlr,$linkbd);
			while($row=mysql_fetch_row($res))
			{$nit=$row[0];$rs=$row[1];}
			//Parte Izquierda
			$this->Image('imagenes/eng.jpg',18,12,30,20);
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
			//********************************************************************************************************************
			$this->SetFont('Arial','B',14);
			$this->SetY(10);
			$this->Cell(50.1);
			$this->Cell(149,31,'',0,1,'C'); 
			$this->SetY(8);
			$this->Cell(50.1);
			$this->Cell(149,17,'SOLICITUD DE COMPRA',0,0,'C');
			$this->SetY(15);
			$this->Cell(50.1); 
			$this->Cell(149,15,'',0,0,'C');
			//************************************
			$this->SetFont('Arial','B',10);
			$this->SetY(27);
			$this->Cell(161.1);
			$this->SetY(28.5);
			$this->Cell(60);
			$this->Cell(35,5,'SOLICITUD : '.$_POST[codigot],0,0,'L');
			$this->SetY(35);
			$this->Cell(60);
			$this->Cell(35,5,'VIGENCIA : '.$_POST[ovigencia],0,0,'L');
			$this->SetY(28.5);
			$this->Cell(130);
			$this->Cell(35,5,'FECHA ELABORACION:',0,0,'L');
			$this->Cell(10);
			$this->Cell(35,5,$_POST[fechat],0,0,'L');
			$this->SetY(35);
			$this->Cell(130);
			$this->Cell(35,5,'FECHA RECIBIDO: ',0,0,'L');
			$this->Cell(10);
			$fecha1=date("Y-m-d");
			$this->Cell(35,5,$fecha1,0,0,'L');
			$this->SetY(27);
			$this->Cell(50.2);
			$this->MultiCell(148.5,5,'','T','C');			
			$this->SetFont('Arial','B',12);
			$this->SetY(46);
			$this->ln(4);
		}
		//Pie de página
		function Footer()
		{
		
		$this->SetFont('arial','B',10);
		$this->SetY(-15);
		$this->Cell(0.1);
		$this->Cell(65,10,'',0,1,'L');
		$this->SetFont('Arial','I',10);
		$posy=$this->GetY();
		$this->SetY($posy-10);
		$this->Cell(175);
		$this->Cell(0,10,'Pagina '.$this->PageNo().' de {nb}',0,0,'R'); // el parametro {nb} 	
		}
	}
	//Creación del objeto de la clase heredada
	//$pdf=new PDF('P','mm',array(210,140));
	$pdf=new PDF('P','mm','Letter'); 
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetAutoPageBreak(true,20);
	//********************************************************************************************************************************
	$pdf->SetFont('Arial','B',10);
	$pdf->cell(0.1);
	$pdf->SetY(45);
	$pdf->Cell(35,5,'SOLICITA: ',0,0,'L');
	$pdf->RoundedRect(10,50, 199, 5, 1,'' );
	$pdf->SetFont('Arial','B',9);
	$pdf->SetY(50);
	$pdf->Cell(3);
	$pdf->Cell(24,5.5,'DOCUMENTO',0,1,'C'); 
	$pdf->SetY(50);
    $pdf->Cell(24.1);
	$pdf->Cell(78,5.5,'NOMBRE',0,1,'C');		
	$pdf->SetY(50);
	$pdf->Cell(125);
	$pdf->Cell(34,5.5,'DEPENDENCIA',0,1,'C');
	$pdf->SetFont('Arial','',9);
	$pdf->SetAutoPageBreak(true,20);
	$posy=$pdf->GetY();
	$pdf->SetY($posy+1);   
	$con=0;
	
	$linkbd=conectar_bd();
	$sqlr="SELECT codsolicitante FROM contrasoladquisiciones  WHERE codsolicitud='".$_POST[codigot]."'";
	$res=mysql_query($sqlr,$linkbd);
	$row=mysql_fetch_row($res);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(55,4,'  '.number_format($row[0].'    ',0,".",","),0,0,'L',TRUE);
	$nresul=buscatercerod($row[0]);
	$sqlr2="SELECT nombre1, nombre2, apellido1,apellido2 FROM terceros WHERE cedulanit='".$row[0]."'";
	$res2=mysql_query($sqlr2,$linkbd);
	$row2=mysql_fetch_row($res2);
	$pdf->Cell(74,4,$row2[0].' '.$row2[1].' '.$row2[2].' '.$row2[3],0,0,'L');
	$pdf->Cell(65,4,$nresul[1],0,0,'L');
	$pdf->ln(4);
	$posy=$pdf->GetY();	
	$pdf->line(10,$posy+1,209,$posy+1);
	$pdf->ln(3);
	//********************************************************************************************************************************
	
	$posy=$pdf->GetY();
	$pdf->Cell(0.1);
	$pdf->SetFont('Arial','B',10);
    $pdf->Cell(24,5,'PRODUCTOS SOLICITADOS:',0,1,'L'); 
	$posy=$pdf->GetY();
	$pdf->SetY($posy);
	$pdf->RoundedRect(10,$posy, 199, 5, 1.2,'' );
	$pdf->SetFont('times','B',10);
	$posy=$pdf->GetY();
	$pdf->SetY($posy+0.1);
    $pdf->Cell(0.1);
    $pdf->Cell(24,5,'CODIGO ',0,1,'C'); 
	$pdf->SetY($posy+0.1);
    $pdf->Cell(7);
	$pdf->Cell(78,5,'NOMBRE',0,1,'C');
	$pdf->SetY($posy+0.1);
	$pdf->Cell(75);
	$pdf->Cell(63,5,'TIPO',0,1,'C');
	$pdf->SetY($posy+0.1);
	$pdf->Cell(110);
	$pdf->Cell(63,5,'CANTIDAD',0,1,'C');	
	$pdf->SetY($posy+0.1);
	$pdf->Cell(145);
	$pdf->Cell(63,5,'VALOR',0,1,'C');
	$posy=$pdf->GetY();	
	$pdf->ln(1);
    	//********************************************************************************************************************************
	
	$pdf->SetFont('Times','',8);
	$pdf->SetAutoPageBreak(true,20);
	$posy=$pdf->GetY();
	$pdf->SetY($posy+1);   
	$con=0;
	while ($con<count($_POST[dproductos1]))
	{	
		if ($con%2==0){$pdf->SetFillColor(245,245,245);}
		else{$pdf->SetFillColor(255,255,255);}
		$pdf->Cell(32,4,'   '.$_POST[dproductos1][$con],0,0,'L',TRUE);
		$pdf->Cell(67,4,substr(''.$_POST[dnproductos1][$con],0,70),0,0,'L',TRUE);
		$pdf->Cell(40,4,substr(''.$_POST[dtipos1][$con],0,20),0,0,'L',TRUE);
		$pdf->Cell(29,4,''.$_POST[dcantidad1][$con],0,0,'L',TRUE);
		$pdf->Cell(31,4,' $ '.number_format($_POST[dvaluni1][$con],2,',','.'),0,0,'L',TRUE);
		$pdf->ln(4);	
		$con=$con+1;
	}
	$posy=$pdf->GetY();	
	$pdf->line(10,$posy+1,209,$posy+1);
	
	$pdf->ln(5);
 	//********************************************************************************************************************************
	$tamano=strlen($_POST[descripciont])+1;
	$modulo=$tamano%80;	
										
	$pdf->SetFont('times','B',9);
	$pdf->SetAutoPageBreak(true,20);
	$pdf->ln(4);
	$con=0;
	$posy=$pdf->GetY();
	$pdf->SetY($posy+1);
	$pdf->Cell(0.1);
	$pdf->SetFillColor(235,235,235);
	//$pdf->SetFont('Arial','B',10);
	$pdf->Cell(30,6.5,'SE SOLICITA A',1,1,'C',TRUE);
	$pdf->Cell(0.1);
	$pdf->SetFillColor(235,235,235);
	//$pdf->SetFont('Arial','B',10);
	if($modulo==$tamano){
		$pdf->Cell(30,6.5,'OBJETO',1,1,'C',TRUE);
	}else{
		$multi=(round($tamano/80)+1);
		$pdf->Cell(30,(6.5*$multi),'OBJETO',1,1,'C',TRUE);
	}
	$pdf->Cell(0.1);
	$pdf->SetFillColor(235,235,235);
	//$pdf->SetFont('Arial','B',10);
	$pdf->Cell(30,6.5,'VALOR',1,1,'C',TRUE);
	
	$pdf->SetFont('times','',9);
	$pdf->SetY($posy+1);
	//$pdf->SetFont('Arial','',10);
	$pdf->Cell(30.1);
	$pdf->Cell(169,6.5,' ALMACEN MUNICIPAL',1,1,'L');
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(30.1);
	$pdf->MultiCell(169,6.5,' '.strtoupper($_POST[descripciont]),1,1,'L');
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(30.1);
	$pdf->MultiCell(169,6.5,' $ '.number_format($valorsol,2,',','.'),1,1,'L');
	//********************************************************************************************************************************
	$pdf->ln(40);
	$posy=$pdf->GetY();
	$pdf->SetY($posy+1);
	$pdf->SetFont('arial','B',10);
	$pdf->Cell(70);
	$pdf->Cell(60,5.5,$nresul[0],'T',1,'C');
	$pdf->SetFont('arial','',10);
	$pdf->MultiCell(200,5.5,$nresul[1],0,'C');
	$cod=$_POST[codigot];
	$filename="informacion/proyectos/temp/solicitudpaa$cod.pdf";
	$pdf->Output($filename,'F');
	$host=$_SERVER[REQUEST_URI];
	echo "<meta http-equiv=\"refresh\" content=\"0;URL='/financiero/informacion/proyectos/temp/solicitudpaa$cod.pdf' \" />";
?> 