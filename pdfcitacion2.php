<?php
require('fpdf.php');
require('comun.inc');
require('funciones.inc');
//session_start();
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
		  $nalca=$row[6];
		}
		 
		     //Parte Izquierda
		    $this->Image('imagenes/eng.jpg',23,10,25,25);
			$this->SetFont('Arial','B',10);
			$this->SetY(10);
			$this->RoundedRect(10, 10, 199, 31, 1.5,'' );
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
			$this->SetFont('Arial','B',12);
			$this->SetY(10);
		    $this->Cell(50.1);
		    $this->Cell(149,31,'',0,1,'C'); 

			$this->SetY(8);
		    $this->Cell(50.1);
		    $this->Cell(149,18,'SECRETARIA DE HACIENDA',0,0,'C'); 
			//************************************
		    $this->SetFont('Arial','B',10);
			
			$this->SetY(27);
		    $this->Cell(161.1);
			$this->Cell(37.8,14,'','TL',0,'L');
			
			$this->SetY(28.5);
		    $this->Cell(161);
			$this->Cell(38,5,'FECHA','B',0,'C');
			
			$this->SetY(34.5);
		    $this->Cell(161);
			$this->Cell(38,5,'  '.date('d-m-Y'),'0',0,'C');
			//$this->SetY(35.5);
		    //$this->Cell(162);
			//$this->Cell(35,5,'FECHA: '.$_POST[fecha],0,0,'L');

			$this->SetY(27);
			$this->Cell(50.2);

			$this->MultiCell(105.7,4,'',0,'L');		
			

			
		//********************************************************************************************************************************
		//	$this->line(10.1,42,209,42);
		//	$this->RoundedRect(10,42.7, 199, 4, 1.2,'' );
			$this->SetFont('times','B',10);
		//	$this->SetY(42.5);
		 //   $this->Cell(0.1);
		//	$this->Cell(199,5,'IDENTIFICACION DEL PREDIO',0,1,'C');
		    
			
					
					
			//		$this->SetY(48);
		     //   	$this->Cell(101);
		///			$this->Cell(36,5,'DETALLE',0,1,'C');
		//			$this->SetY(48);
		//        	$this->Cell(96.5);
		//			$this->Cell(5,5,'C.C.',0,1,'C');
		//			$this->SetY(48);
		 //       	$this->Cell(137);
					
		//			$this->Cell(31,5,'DEBITO',0,1,'C');
		//			$this->SetY(48);
		 //       	$this->Cell(168);
		//			$this->Cell(31,5,'CREDITO',0,1,'C');
					//$this->line(10.1,49,209,49);
						$this->ln(2);
					
	//************************	***********************************************************************************************************
	}
	//Pie de página
	function Footer()
	{

	/*
	    $this->SetY(-15);
		$this->SetFont('Arial','I',10);
		$this->Cell(0,10,'Pagina '.$this->PageNo().' de {nb}',0,0,'R'); // el parametro {nb} 
		*/
	}
}

//Creación del objeto de la clase heredada
//$pdf=new PDF('P','mm',array(210,140));
$pdf=new PDF('P','mm','Legal'); 


	if ($_POST[nombre]!="")
			$crit1="and codcatastral LIKE '%$_POST[nombre]%'";
	if($_POST[numresolucion]!=""){
			$crit2="and numresolucion='$_POST[numresolucion]'";
		}
		
//$pdf->AddPage();
//$disc=0;

$linkbd=conectar_bd();
$nr=selconsecutivo('tesocobroreportepdf','numresolucion');
$fecharesol=date('Y-m-d');

$disc=count($_POST[codcatastral]);
$nuevo="";
$actual="";
for($v=0;$v<$disc;$v++)
{
	if($nuevo=="")
	{
		//$actual=$_POST[vigencias][$v];
	$nuevo=1;
	}
		$pdf->AddPage();
		$direccion="";
		$tercero="";
		$ntercero="";
		$codigorural="";
		$sqlr2="select *from tesoreportemandamiento where codcatastral='".$_POST[codcatastral][$v]."'  group by codcatastral";
		//echo $_POST[codcatastral][$v];
		$res2=mysql_query($sqlr2,$linkbd);
		while($row2=mysql_fetch_row($res2))
		{
			$codigorural=$row2[0];
			
 		}
		
		$sqlr="select *from tesopredios where cedulacatastral='".$_POST[codcatastral][$v]."' and estado='S' group by cedulacatastral";
		$res=mysql_query($sqlr,$linkbd);
		while($row=mysql_fetch_row($res))
		{
			$direccion=$row[7];
			$tercero=$row[5];
			$nomtercero=$row[6];
			$ntercero=$row[5];
 		}
		$sqlr1="select numresolucion,fecha,sum(valortotal) from tesocobroreporte where codcatastral='".$_POST[codcatastral][$v]."' group by codcatastral";
		$res1=mysql_query($sqlr1,$linkbd);
		while($row1=mysql_fetch_row($res1))
		{
			$actadministrativo=$row1[0];
			$fecactoadministrativo=$row1[1];
			$valoract=$row1[2];
 		}
		$pdf->SetFont('Times','B',10);
		$pdf->SetY(27);
		$pdf->Cell(50.2);
		$pdf->multiCell(110.7,7,'','T','L');
		$posy=$pdf->GetY();
    	$pdf->SetY($posy+10);
		$pdf->Cell(1);
		//$nr=$nr+1;
		$pdf->SetFont('Times','',12);
		$pdf->MultiCell(195,4,utf8_decode("\n \n \n \n MANDAMIENTO DE PAGO No: ".$codigorural." \n \n Cubarral-Meta, ".strftime("%A, %d de %B de %Y")." \n \n \n Obra  al  Despacho para  su  cobro por   jurisdicción  coactiva  la    Resolución No: ".$actadministrativo." de  fecha ".$fecharesol.", en  la  cual  consta  una obligación clara, expresa y actualmente exigible, a favor del MUNICIPIO  DE CUBARRAL  - META y en contra del identificado con Cedula de ciudadania No. ".$ntercero."  (".$nomtercero.") , correspondiente al inmueble identificado con cédula catastral No. ".$_POST[codcatastral][$v].";  tal como consta en Acto Administrativo No ".$actadministrativo." De calendado en la fecha de ".$fecactoadministrativo."  en cuantía de  $ ".number_format($valoract,2)."; correspondiente al periodo gravable 2016; documento que presta mérito  ejecutivo de  conformidad con el artículo  828  del  Estatuto Tributario y 488  del  C.P.C,   sumas que no han sido  pagadas por  el  ejecutado, por  lo  cual se hace  necesario iniciar el procedimiento   de   cobro  administrativo  coactivo  contenido  en los  artículos  823  y  siguientes  del Estatuto Tributario para obtener su  pago. \n \nEl suscrito funcionario es competente para conocer del procedimiento, con fundamento en la resolución ".$actadministrativo.", mediante la cual se dispone el otorgamiento de facultades por delegación. \n \n \n \n                                                                          RESUELVE:\n \n \n \nPRIMERO: Librar orden de pago por la vía administrativa coactiva a favor del MUNICIPIO DE CUBARRAL  - META -  a cargo del señor ".$nomtercero." con Nit. ".$ntercero.", propietario del inmueble identificado con cedula catastral No. ".$_POST[codcatastral][$v].", por la suma de($ ".number_format($valoract,2).") por   los   conceptos   y periodos señalados en la parte motiva, más los intereses que se causen desde cuando se hizo exigible cada  obligación y hasta cuando se cancelen conforme lo disponen los Artículos 634,635y867-1 del Estatuto Tributario, más las costas del presente proceso. SEGUNDO:  Notificar este mandamiento de pago  personalmente  al  ejecutado,  su apoderado  o  propietario, previa citación por correo certificado dirigida    al   predio identificado con número catastral ".$_POST[codcatastral][$v]." para  que  comparezca   dentro   de los diez  (10) días siguientes a la misma. De  no comparecer en  el término fijado, notificar por correo conforme lo  dispuesto el  articulo  826, concordante  con  el  Artículo  565  del  Estatuto  Tributario. TERCERO: Advertir al deudor(es) que dispone(n) de quince (15) días después de notificada esta providencia, para cancelar la(s) deuda(s) o  proponer las excepciones legales que estime(n) pertinentes, conforme al Artículo 831 del Estatuto Tributario.CUARTO: Líbrense los oficios correspondientes. "),0,'J');	
		
		$pdf->SetFont('Times','B',10);
		$pdf->MultiCell(200,4," \n \n \n \n NOTIFIQUESE Y CUMPLASE",0,'C');	
		$pdf->SetFont('times','',8);
		
		$sqlr="select *from  tesoparametros where estado='S'";
		$res=mysql_query($sqlr,$linkbd);
		while($row=mysql_fetch_row($res))
 		{
			$teso=$row[4];
 		}	
		$pdf->SetFont('Times','B',10);
		$pdf->MultiCell(200,4," \n \n \n \n \n \n \n \n ".strtoupper($teso)." \n SECRETARIA HACIENDA MUNICIPAL",0,'C');	
		$pdf->SetFont('times','',8);
	//$pdf->multicell(199,4,'* Contra la presente liquidaci'.utf8_decode(ó).'n procede el recurso de reconsideraci'.utf8_decode(ó).'n dentro de los dos (2) meses siguientes a su notificaci'.utf8_decode(ó).'n',0);
	$nr=$nr+1;
	$codigorural+=1;
	$sql="select numresolucion from tesocobroreporte where codcatastral='".$_POST[codcatastral][$v]."' group by numresolucion";
	//echo $sql;
	$re=mysql_query($sql,$linkbd);
	$ro=mysql_fetch_row($re);
	$sq="insert into tesoreportecitacion(codproceso,numresolucion,codcatastral,ruta,vigencia) values ('$codigorural',)";
	//fin de if
}//**fin de for

$pdf->Output();
?>