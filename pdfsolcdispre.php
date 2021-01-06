<?php
	error_reporting(0);
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
	$copi=$_GET[copi];
	if($copi!=1)
	{
		if($row[0]=="")
		{
			$sqlr2="UPDATE contrasoladquisiciones SET codcdp='S' WHERE codsolicitud='".$_POST[codid]."'";
			mysql_query($sqlr2,$linkbd);
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
			$this->Cell(149,17,'SOLICITUD CERTIFICADO DE',0,0,'C');
			$this->SetY(15);
			$this->Cell(50.1); 
			$this->Cell(149,15,'DISPONIBILIDAD PRESUPUESTAL',0,0,'C');
			//************************************
			$this->SetFont('Arial','B',10);
			$this->SetY(27);
			$this->Cell(161.1);
			$this->SetY(28.5);
			$this->Cell(60);
			$this->Cell(35,5,'NUMERO : '.$_POST[codigot],0,0,'L');
			$this->SetY(35);
			$this->Cell(60);
			$this->Cell(35,5,'VIGENCIA : '.$_POST[ovigencia],0,0,'L');
			$this->SetY(28.5);
			$this->Cell(130);
			$this->Cell(35,5,'FECHA ELABORACION:',0,0,'L');
			$this->Cell(10);
			$fecha2=date("d-m-Y",strtotime($_POST[fechat]));
			$this->Cell(35,5,$fecha2,0,0,'L');
			$this->SetY(35);
			$this->Cell(130);
			$this->Cell(35,5,'FECHA RECIBIDO: ',0,0,'L');
			$this->Cell(10);
			$fecha1=date("d-m-Y");
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
		$this->Cell(65,10,'NOTA: LA PRESENTE SOLICITUD TIENE UNA VALIDEZ POR 30 DIAS CALENDARIO',0,1,'L');
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
	$pdf->SetFont('Times','',8);
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
	while ($con<count($_POST[sdocumento]))
	{	
		if ($con%2==0){$pdf->SetFillColor(255,255,255);}
		else{$pdf->SetFillColor(245,245,245);}
		$pdf->Cell(45,4,'   '.number_format($_POST[sdocumento][$con].'    ',0,".",","),0,0,'L',TRUE);
		$pdf->Cell(84.5,4,substr('           '.$_POST[snombre][$con],0,40),0,0,'L',TRUE);
		$pdf->Cell(85,4,substr(''.$_POST[sndependencia][$con],0,40),0,0,'L',TRUE);
		$pdf->ln(4);	
		$con=$con+1;
	}
	$posy=$pdf->GetY();	
	$pdf->line(10,$posy+1,209,$posy+1);
	$pdf->ln(5);
	//********************************************************************************************************************************
	$tamletras=strlen($_POST[letras]);
	if($tamletras<80){$adicion=0;}
	else{$adicion=5;} 
	$pdf->SetFont('arial','',10);
	$posy=$pdf->GetY();	
	$pdf->RoundedRect(10,$posy+1, 199, 40+$adicion, 1,'' );
	$posy=$pdf->GetY();
	$pdf->SetY($posy+1);
	$cont1="Este CERTIFICADO DE DISPONIBILIDAD PRESUPUESTAL, se solicita como requisito previo en cumplimiento de las normas vigentes en materia presupuestal y contractual y con el fin de garantizar la existencia de aprobacion presupuestal disponible y libre de afectacion para asumir un compromiso aproximadamente por:";
    $pdf->Cell(0.1);
	$pdf->MultiCell(198,5,$cont1,'','J');
	$pdf->ln(4);
	$posy=$pdf->GetY();
	$pdf->SetY($posy+1);
    $pdf->Cell(0.1);
	$pdf->Cell(21,5,'Numeros:',0,1,'L');
	$pdf->SetY($posy+1);
    $pdf->Cell(23);
	$pdf->SetFillColor(235,235,235);
	$pdf->cell(80,5,'$ '.number_format($_POST[cuentagas],2),1,0,'C',TRUE);
	$pdf->ln(10);
	$posy=$pdf->GetY();
	$pdf->SetY($posy+1);
    $pdf->Cell(0.1);
	$pdf->Cell(21,5,'Letras:',0,1,'L');
	$pdf->SetY($posy+1);
    $pdf->Cell(23);
	$pdf->MultiCell(170,5,$_POST[letras],1,'J',TRUE);
	$pdf->ln(5);
	//********************************************************************************************************************************
	$pdf->SetFont('Arial','B',10);
	$posy=$pdf->GetY();
	$pdf->SetY($posy+1);
    $pdf->Cell(0.1);
	$pdf->Cell(35,5,'OBJETO DE LA SOLICITUD: ',0,0,'L');
	$pdf->SetFont('arial','',10);
	$pdf->SetY($posy+6);
    $pdf->Cell(0.1);
	$pdf->MultiCell(199,5,$_POST[descripciont],1,'J',TRUE);
	$pdf->ln(2);
	//********************************************************************************************************************************
	$pdf->SetFont('Arial','B',10);
	$posy=$pdf->GetY();
	$pdf->SetY($posy);
    $pdf->Cell(0.1);
	$pdf->Cell(35,5,'TIPO DE GASTO: ',0,0,'L');
	$pdf->SetFont('Times','',8);
	$pdf->SetAutoPageBreak(true,20);
	$pdf->ln(4);
	$con=0;
	$_POST[contador]=0;
	$sql="SELECT MAX(cod_meta) FROM planproyectos_det WHERE codigo=$codigo AND vigencia=$vigusu";
	$result=mysql_query($sql,$linkbd);
	$rowc = mysql_fetch_row($result);
    $_POST[contador]=$rowc[0]+1;
	
	while ($con<count($_POST[dcuentas]))
	{	
		$posy=$pdf->GetY();
		$pdf->SetY($posy+1); 
		$pdf->RoundedRect(10,$posy+1, 199, 5, 1,'' );
		$pdf->SetFont('Arial','B',9);
		if($_POST[dtipogastos][$con]==2 || $_POST[dtipogastos][$con]==3)
		{
			$pdf->SetY($posy+1);
			$pdf->Cell(1);
			$pdf->Cell(17,5.5,'FUNCIONAMIEMTO',0,1,'L');
			$pdf->SetY($posy+1.2); 
			$pdf->Cell(34);
			if($_POST[dtipogastos][$con]==2){$pdf->Cell(4,4.5,'X',1,1,'L');}
			else {$pdf->Cell(4,4.5,'',1,1,'L');}
			$pdf->SetY($posy+1);
			$pdf->Cell(50.1);
			$pdf->Cell(65,5.5,'INVERSION',0,1,'L');
			$pdf->SetY($posy+1.2); 
			$pdf->Cell(70);
			$pdf->Cell(4,4.5,'',1,1,'L');		
			$pdf->SetY($posy+1);
			$pdf->Cell(100);
			$pdf->Cell(34,5.5,'REGALIAS',0,1,'L');
			$pdf->SetY($posy+1.2); 
			$pdf->Cell(120);
			if($_POST[dtipogastos][$con]==3){$pdf->Cell(4,4.5,'X',1,1,'L');}
			else {$pdf->Cell(4,4.5,'',1,1,'L');}
			$pdf->SetFont('Arial','',9);
			$posy=$pdf->GetY();
			$pdf->SetY($posy+1);
			$pdf->Cell(0.1);
			$pdf->Cell(30,4.5,'RUBRO',1,1,'C'); 
			$pdf->Cell(0.1);
			$pdf->Cell(30,4.5,'NOMBRE',1,1,'C');
			$pdf->Cell(0.1);
			$pdf->Cell(30,4.5,'FUENTE',1,1,'C');
			$pdf->Cell(0.1);
			$pdf->Cell(30,4.5,'PROYECTO',1,1,'C');
			$pdf->SetY($posy+1);
			$pdf->Cell(30.1);
			$pdf->Cell(67,4.5,' '.$_POST[dcuentas][$con],1,1,'L'); 
			$pdf->Cell(30.1);
			$pdf->Cell(169,4.5,' '.ucfirst(strtolower(substr($_POST[dncuentas][$con],0,115))),1,1,'L');
			$pdf->Cell(30.1);
			$pdf->Cell(169,4.5,' '.ucfirst(strtolower(substr($_POST[dfuentes][$con],0,115))),1,1,'L'); 
			$pdf->Cell(30.1);
			$pdf->Cell(169,4.5,' '.ucfirst(strtolower(substr($_POST[dnomproyec][$con],0,115))),1,1,'L');
			$pdf->SetY($posy+1);
			$pdf->Cell(97);
			$pdf->Cell(30,4.5,'VALOR',1,1,'C');
			$pdf->SetY($posy+1);
			$pdf->Cell(127);
			$pdf->Cell(72,4.5,' $'.number_format($_POST[dgastos][$con],2,".",","),1,1,'L');	
			$pdf->ln(14);
			$posy=$pdf->GetY();
			$pdf->SetY($posy+1);
		}
		else
		{
			$bussubprograma=buscapadreplan($_POST[dmetas][$con]);
			$busprograma=buscapadreplan($bussubprograma[0]);
			$bussector=buscapadreplan($busprograma[0]);
			$buseje=buscapadreplan($bussector[0]);
			$pdf->SetY($posy+1);
			$pdf->Cell(1);
			$pdf->Cell(17,5.5,'FUNCIONAMIEMTO',0,1,'L');
			$pdf->SetY($posy+1.2); 
			$pdf->Cell(34);
			$pdf->Cell(4,4.5,'',1,1,'L'); 
			$pdf->SetY($posy+1);
			$pdf->Cell(50.1);
			$pdf->Cell(65,5.5,'INVERSION',0,1,'L');
			$pdf->SetY($posy+1.2); 
			$pdf->Cell(70);
			$pdf->Cell(4,4.5,'X',1,1,'L');		
			$pdf->SetY($posy+1);
			$pdf->Cell(100);
			$pdf->Cell(34,5.5,'REGALIAS',0,1,'L');
			$pdf->SetY($posy+1.2); 
			$pdf->Cell(120);
			$pdf->Cell(4,4.5,'',1,1,'L');
			$pdf->SetFont('Arial','',9);
			$posy=$pdf->GetY();
			$pdf->SetY($posy+1);
			$pdf->Cell(0.1);
			$pdf->Cell(30,4.5,'RUBRO',1,1,'C'); 
			$pdf->Cell(0.1);
			$pdf->Cell(30,4.5,'NOMBRE',1,1,'C');
			$pdf->Cell(0.1);
			$pdf->Cell(30,4.5,'FUENTE',1,1,'C');
			$pdf->Cell(0.1);
			$pdf->Cell(30,4.5,'PROYECTO',1,1,'C');
			$sqln="SELECT nombre, orden FROM plannivelespd WHERE estado='S' ORDER BY orden";
            $resn=mysql_query($sqln,$linkbd);
            $n=0; $j=0;
            $cont=0;
            while($wres=mysql_fetch_array($resn))
                  {
                     if (strcmp($wres[0],'INDICADORES')!=0)
                         {
                         	
                            $pdf->Cell(0.1);
							$pdf->SetFillColor(235,235,235);
							for($x=0;$x<$_POST[contador]; $x++){
		
									  if(!empty($_POST["matmetas$x"][$cont])){
										    $pdf->Cell(0.1);
											$tamano=strlen($_POST["matmetas$x"][$cont])+strlen($_POST["matmetasnom$x"][$cont])+1;
											$modulo=$tamano%82;
											if($modulo==$tamano){
												$pdf->Cell(30,4.5,' '.strtoupper($wres[0]),1,1,'C',TRUE);
											}else{
												$multi=(round($tamano/82)+1);
												$pdf->Cell(30,(4.5*$multi),' '.strtoupper($wres[0]),1,1,'C',TRUE);
											}
											
										}
								
							}
							
                            $cont++;            	
                          }
                   }

			$pdf->SetY($posy+1);
			$pdf->Cell(30.1);
			$pdf->Cell(67,4.5,' '.$_POST[dcuentas][$con],1,1,'L'); 
			$pdf->Cell(30.1);
			$pdf->Cell(169,4.5,' '.ucfirst(strtolower(substr($_POST[dncuentas][$con],0,115))),1,1,'L');
			$pdf->Cell(30.1);
			$pdf->Cell(169,4.5,' '.ucfirst(strtolower(substr($_POST[dfuentes][$con],0,115))),1,1,'L');
			$pdf->Cell(30.1);
			$pdf->Cell(169,4.5,' '.ucfirst(strtolower(substr($_POST[dnomproyec][$con],0,115))),1,1,'L');
			for($x=0;$x<$_POST[contador]; $x++){
				for ($y=0;$y<$cont;$y++)
                       {
						  if(!empty($_POST["matmetas$x"][$y])){
								$pdf->Cell(30.1);
								$pdf->MultiCell(169,4.5,' '.$_POST["matmetas$x"][$y].' '.strtoupper($_POST["matmetasnom$x"][$y]),1,1,'L');
							}
                       }
			}
			$pdf->SetY($posy+1);
			$pdf->Cell(97);
			$pdf->Cell(30,4.5,'VALOR',1,1,'L');
			$pdf->SetY($posy+1);
			$pdf->Cell(127);
			$pdf->Cell(72,4.5,' $'.number_format($_POST[dgastos][$con],2,".",","),1,1,'L');	
			$pdf->ln(36.5);
			$posy=$pdf->GetY();
			$pdf->SetY($posy+1);
		}
		$con=$con+1;
	}
	$pdf->ln(20);
	$posy=$pdf->GetY();
	$pdf->SetY($posy+3);
	$pdf->SetFont('arial','B',10);
	$pdf->Cell(20);
	$pdf->Cell(50,5.5,'Solicitante','T',1,'C');
	$pdf->SetY($posy+3); 
	$pdf->Cell(105);
	$pdf->Cell(50,5.5,'Ordenador del Gasto','T',1,'C');
	
	$pdf->Output();
?> 


