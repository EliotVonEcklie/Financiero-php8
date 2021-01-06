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
		    $this->Cell(149,18,'CITACION OFICIAL PARA PAGO DE IMPUESTO PREDIAL UNIFICADO',0,0,'C'); 
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
$codigorural='261';
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
		
		$sqlr="select *from tesopredios where cedulacatastral='".$_POST[codcatastral][$v]."' and estado='S' group by cedulacatastral";
		$res=mysql_query($sqlr,$linkbd);
		while($row=mysql_fetch_row($res))
		{
			$direccion=$row[7];
			$tercero=$row[5];
			$ntercero=$row[6];
			
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
		$pdf->MultiCell(195,4,utf8_decode("\n \n \n \n Señor(a): ".$ntercero." \n \n Cedula Catastral No. ".$_POST[codcatastral][$v]." \n \n REFERENCIA: Proceso  Administrativo Coactivo  del MUNICIPIO DE CUBARRAL  - META \n \n Expediente No: ".$codigorural." \n \n \n \nSírvase  comparecer ante  este Despacho, en  horas hábiles de oficina, dentro de los diez(10) días siguientes  a la fecha de la presente comunicación, para efectos de la notificación  personal del mandamiento de Pago librado  dentro del proceso de la referencia. \nSe le advierte que de no comparecer dentro del término fijado, el mandamiento se le notificará conforme  lo  dispuesto en  el artículo  826 del Estatuto Tributario Nacional concordante con el artículo 432 del estatuto de rentas del municipio. \n \nCordialmente, "),0,'J');		
		
		$sqlr="select *from  tesoparametros where estado='S'";
		$res=mysql_query($sqlr,$linkbd);
		while($row=mysql_fetch_row($res))
 		{
			$teso=$row[4];
 		}	
		$pdf->SetFont('Times','B',10);
		$pdf->MultiCell(200,4," \n \n \n \n \n \n \n \n \n \n \n \n \n \n ".strtoupper($teso)." \n SECRETARIA HACIENDA MUNICIPAL",0,'C');	
		$pdf->SetFont('times','',8);
	//$pdf->multicell(199,4,'* Contra la presente liquidaci'.utf8_decode(ó).'n procede el recurso de reconsideraci'.utf8_decode(ó).'n dentro de los dos (2) meses siguientes a su notificaci'.utf8_decode(ó).'n',0);
	
	$sql="select numresolucion from tesocobroreporte where codcatastral='".$_POST[codcatastral][$v]."' group by numresolucion";
	$res1=mysql_query($sql,$linkbd);
	$row1=mysql_fetch_row($res1);
	//echo $sql;
	$sq="insert into tesoreportecitacion(codproceso,numresolucion,codcatastral,ruta,vigencia,diasproceso,fechainicio,fechafin) values ('$codigorural','$row1[0]','".$_POST[codcatastral][$v]."','','2017','','','')";
	mysql_query($sq,$linkbd);
	$nr=$nr+1;
	$codigorural+=1;
	//fin de if
}//**fin de for

$pdf->Output();
?>