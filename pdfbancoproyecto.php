<?php
//V 1000 12/12/16 
	require('fpdf.php');
	require('comun.inc');
	require"funciones.inc";
	require"conversor.php";
	header('Content-Type: text/html; charset=utf-8');
	session_start();
    date_default_timezone_set("America/Bogota");
	//*****las variables con los contenidos***********
	//**********pdf*******
	$linkbd=conectar_bd();
	$sql="SELECT cpc.duracionest FROM contraplancompras cpc,contrasoladquisiciones csa WHERE csa.codplan=cpc.codplan AND csa.codsolicitud='".$_POST[codid]."' ";
	$res=mysql_query($sql,$linkbd);
	$row =mysql_fetch_row($res);
	$arraytime=explode("/",$row[0]);
	$dias=$arraytime[0];
	$meses=$arraytime[1];
	$nombre="";
	$cargo="";
	if(!empty($meses) && $meses!=null){
		$dias+=$meses;
	} 
	$duracion=convertir((int)$dias)."(".$dias.") DIAS O A LA ".utf8_decode("TERMINACIÓN")." DE LAS ACTIVIDADES";
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
	$valor=$_SESSION[cedulausu];
	$nresul=buscatercerod($valor);		 
	$_POST[sdocumento][0]=$valor;
	$_POST[snombre][0]=$nresul[0]; 
	$_POST[sidependencia][0]=$nresul[2];
	$_POST[sndependencia][0]=$nresul[1];
			
	$_POST[datoaux][0]=0;
	$_POST[tam][0]=0;
	
	$sql="SELECT MAX(cod_meta) FROM contrasolicitudproyecto_det WHERE codigosol='$_POST[codigot]'";
	$res=mysql_query($sql,$linkbd);
	$fila = mysql_fetch_row($res);
	for($i=0;$i<$fila[0]+1;$i++){
		$sql1="SELECT valor,nombre_valor FROM contrasolicitudproyecto_det WHERE codigosol='$_POST[codigot]' AND cod_meta='0' ORDER BY LENGTH(valor),cod_meta ASC ";
		$res1=mysql_query($sql1,$linkbd);
		while($row1 = mysql_fetch_row($res1)){
			$_POST[tam][$cont]=strlen($row1[0])+strlen(strtoupper(utf8_decode($row1[1])))+1;
			$_POST[datoaux][$cont]=' '.$row1[0].' '.strtoupper(utf8_decode($row1[1]));
			$cont++;
		}$cont=0;
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
			$this->Cell(149,17,'SOLICITUD CERTIFICADO',0,0,'C');
			$this->SetY(15);
			$this->Cell(50.1); 
			$this->Cell(149,15,'BPPIM',0,0,'C');
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
	$nombre=$row2[0].' '.$row2[1].' '.$row2[2].' '.$row2[3];
	$cargo=$nresul[1];	
	$pdf->ln(5);
	$pdf->line(10,62,209,62);

	//********************************************************************************************************************************
	$tamano=strlen($_POST[descripcionb])+1;
	$modulo=$tamano%72;	
	$pdf->SetAutoPageBreak(true,20);
	$pdf->ln(4);
	$con=0;
	$posy=$pdf->GetY();
	$pdf->SetY($posy+1);
	$pdf->Cell(0.1);
	$pdf->SetFillColor(235,235,235);
	$pdf->SetFont('times','B',9);
	$pdf->Cell(50,6.5,'SE SOLICITA A','RTL',0,'C');
	$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('times','',9);
	$pdf->Cell(147,6.5,utf8_decode(' BANCO DE PROGRAMAS Y PROYECTOS DE INVERSIÓN MUNICIPAL'),'TLR',1,'L');
	$pdf->SetFillColor(235,235,235);
	$pdf->SetFont('times','B',9);	
	if($modulo==$tamano){
		$pdf->Cell(50,6.5,'OBJETO','RTL',0,'C');
	}else{
		$multi=(round($tamano/72)+1);
		$pdf->Cell(50,(6.5*$multi),'OBJETO','RTL',0,'C');
	}
	$pdf->SetFont('times','',9);
	$pdf->SetFillColor(255,255,255);
	$pdf->MultiCell(147,6.5,' '.strtoupper($_POST[descripciont]),'TLR',1,'L');	
	$pdf->SetFont('times','B',9);	
	$pdf->SetFillColor(235,235,235);
	$pdf->Cell(50,13,'NOMBRE DEL PROYECTO','T',0,'C');
	$pdf->SetFont('times','',9);
	$pdf->SetFillColor(255,255,255);
	$sql="SELECT planproyectos.nombre FROM contrasolicitudproyecto,planproyectos WHERE contrasolicitudproyecto.codsolicitud='$_POST[codigot]' AND contrasolicitudproyecto.codproyecto=planproyectos.codigo ";
	$res=mysql_query($sql,$linkbd);
	$fila=mysql_fetch_row($res);
	$pdf->MultiCell(147,6.5,' '.strtoupper(utf8_encode($fila[0])),'T',1,'L');
	$pdf->RoundedRect(10, 66.5 ,197 , 26, 0,'' );
	$pdf->line(60,72,60,92.2);
	$posy=$pdf->GetY();
	$sql="SELECT MAX(cod_meta) FROM contrasolicitudproyecto_det WHERE codigosol='$_POST[codigot]' ";
	$res=mysql_query($sql,$linkbd);
	$fila = mysql_fetch_row($res);
	$numax=$fila[0]+1;
	$pdf->SetFont('times','B',9);
	for($x=0;$x<$numax; $x++){
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
						  if(!empty($_POST["matmetas1$x"][$cont])){
								$tamano=strlen($_POST[datoaux][$cont])+strlen(strtoupper(utf8_decode($_POST[datoaux][$cont])));
								$modulo=$_POST[tam][$cont]%80;
								if($modulo==$_POST[tam][$cont]){
									$pdf->Cell(50,4.4,' '.strtoupper(utf8_decode($wres[0])),1,1,'C',TRUE);
								}else{
									$multi=(round($_POST[tam][$cont]/80));
									if($_POST[tam][$cont]>=80){
										$pdf->Cell(50,(4.2*2),' '.strtoupper(utf8_decode($wres[0])),1,1,'C',TRUE);
									}else{
										if($modulo>=37){
											$pdf->Cell(50,(4.1*$multi),' '.strtoupper(utf8_decode($wres[0])),1,1,'C',TRUE);
										}else{
											$pdf->Cell(50,(4.36*$multi),' '.strtoupper(utf8_decode($wres[0])),1,1,'C',TRUE);
										}
									}
									
							
								}
								
							}
						
						$cont++; 
										
					}
			}
			$cont=0;
	}
	$pdf->SetY($posy);
	$pdf->SetFillColor(255,255,255);
	$sql="SELECT MAX(cod_meta) FROM contrasolicitudproyecto_det WHERE codigosol='$_POST[codigot]'";
	$res=mysql_query($sql,$linkbd);
	$fila = mysql_fetch_row($res);
	$pdf->SetFont('times','',9);
	for($i=0;$i<$fila[0]+1;$i++){
		$sql1="SELECT valor,nombre_valor FROM contrasolicitudproyecto_det WHERE codigosol='$_POST[codigot]' AND cod_meta='0' ORDER BY LENGTH(valor),cod_meta ASC ";
		$res1=mysql_query($sql1,$linkbd);
		while($row1 = mysql_fetch_row($res1)){
			$tamano=strlen($_POST[datoaux][$cont])+strlen(strtoupper(utf8_decode($_POST[datoaux][$cont])));
			$tam=strlen($row1[0])+strlen(strtoupper(utf8_decode($row1[1])))+1;
			$pdf->Cell(50.1);
			$pdf->MultiCell(147,4.4,' '.$row1[0].'    '.strtoupper(utf8_decode($row1[1])),1,1,'L');
			
		}
	}
	$pdf->ln(30);
	$posy=$pdf->GetY();
	$pdf->SetY($posy+1);
	$pdf->SetFont('arial','B',10);
	$pdf->Cell(70);
	$pdf->Cell(60,5.5,$nombre,'T',1,'C');
	$pdf->Cell(70);
	$pdf->SetFont('arial','',10);
	$pdf->Cell(60,5.5,$cargo,0,'C');
	$cod=$_POST[codigot];
	if(!file_exists("informacion/proyectos/temp")){
		mkdir("informacion/proyectos/temp",0777);
	}
	$filename="informacion/proyectos/temp/solicitudbanco$cod.pdf";
	$pdf->Output($filename,'F');
	$host=$_SERVER[REQUEST_URI];
	echo "<meta http-equiv=\"refresh\" content=\"0;URL='/financiero/informacion/proyectos/temp/solicitudbanco$cod.pdf' \" />";
?> 


