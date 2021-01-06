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
		    $this->Cell(149,18,'CITACION DE COBRO PERSUASIVO',0,0,'C'); 
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
		$this->SetY(-15);
		$this->SetFont('Arial','I',8);
		$this->Cell(0,10,'Impreso por: Software SPID - G&C Tecnoinversiones SAS. - Pagina '.$this->PageNo().' de 1',0,0,'R'); // el parametro {nb} 	
	}
}

//Creación del objeto de la clase heredada
//$pdf=new PDF('P','mm',array(210,140));
$pdf=new PDF('P','mm','Legal'); 


$linkbd=conectar_bd();
$dvigencias=array();
$dcodcatas=array();
$dpredial=array();
$dipredial=array();
$dimpuesto1=array();
$dinteres1=array();
$dimpuesto2=array();
$dinteres2=array();
$ddescuentos=array();
$dtasavig=array();
$dvaloravaluo=array();
$numresolucion=array();
$fecha="";
	$sqlr="select *from configbasica where estado='S'";
	$res=mysql_query($sqlr,$linkbd);
	while($row=mysql_fetch_row($res))
	{
	  $rs=$row[1];
	}
		 

	if ($_POST[nombre]!="")
			$crit1="and codcatastral LIKE '%$_POST[nombre]%'";
	if($_POST[numresolucion]!=""){
			$crit2="and numresolucion='$_POST[numresolucion]'";
		}
	if ($_POST[expediente]=="")
	{
		$_POST[expediente]=$_POST[numresolucion];
	}
			
	$sql="select codcatastral,fecha,sum(valortotal),MIN(vigencia),MAX(vigencia) from tesocobroreporte where idtesoreporte>-1 $crit1 $crit2 $crit3 group by codcatastral";
	$result = mysql_query($sql,$linkbd);
	$i=0;
	$vigMin = 0;
	$vigMax = 0;
	while($row=mysql_fetch_array($result)){
		$dcodcatas[$i]=$row[0];
		$fecha=$row[1];
		$total=$row[2];
		$vigegravables="$row[3] - $row[4]";
		$vigMin = $row[3];
		$vigMax = $row[4];
		$i++;
	}
	$totalPredial = 0;
	//$difPredios = $vigMax - $vigMin;
	$totPredios = generaReporteSinPagos($dcodcatas[0],$vigMin);
	//echo "$dcodcatas[0] - $vigMin";
	//$arregloSerilizado = serialize($totPredios);
	//echo "<input type='hidden' name='serializados[]' value='".$arregloSerilizado."' /> ";
	foreach($totPredios as $key => $value){
		$totalPredial+=$value["total"];
	}
	//echo $totalPredial."hol <br>  ";

$linkbd=conectar_bd();
$nr=selconsecutivo('tesocobroreportepdf','numresolucion');
$fecharesol=date('Y-m-d');

$disc=count($dcodcatas);
$nuevo="";
$actual="";
for($v=0;$v<$disc;$v++)
{
	if($nuevo=="")
	{
		$nuevo=1;
	}

		$pdf->AddPage();
		$direccion="";
		$tercero="";
		$ntercero="";
		
		$sqlr="select *from tesopredios where cedulacatastral='".$dcodcatas[$v]."' and estado='S'";
		$res=mysql_query($sqlr,$linkbd);
		while($row=mysql_fetch_row($res))
		{
			$direccion=$row[7];
			$tercero=$row[5];
			$ntercero=$row[6];
			
 		}
		$actual=$dcodcatas[$v];
		$cont=$v;
		$igual=1;
		$totdeuda=0;
		while($igual==1)
	 	{	
	 		if($dcodcatas[$v]==$dcodcatas[$cont])
	 		{
				$totage=0;	 
				$interes=$dinteres1[$cont]+$dipredial[$cont];
				$totage=$dpredial[$cont]+$interes+$dimpuesto2[$cont]+$dinteres2[$cont]+$dimpuesto1[$cont];	
				$cont+=1;
				$totdeuda+=$totage;
			}
			else
			{
			$igual=0;
	 		}
	 	}
	 	//$fecharesol=date('d-m-Y'),'T','L');
		//$pdf->SetAutoPageBreak(true,20);
		$pdf->SetFont('Times','B',10);
		$pdf->SetY(27);
		$pdf->Cell(50.2);
		$pdf->multiCell(110.7,7,'','T','L');
		$posy=$pdf->GetY();
    	$pdf->SetY($posy+10);
		$pdf->Cell(1);
		//$nr=$nr+1;
		$pdf->SetFont('Times','',14);
		$pdf->MultiCell(190,6,utf8_decode("\n \n \n \n Señor(a): ".$ntercero." \n Dirección: ".$direccion." \n \n REFERENCIA: : Cobro persuasivo. ".$rs." \n  Factura No: ".$_POST[expediente]." \n Código Catastral: ".$dcodcatas[$v]." \n \n \n \n \nPor medio de la presente me permito comunicarle(es) que en este Despacho se encuentra para el cobro administrativo coactivo la factura de liquidación de Impuesto predial, número ".$_POST[numresolucion]." de fecha(s) ".$fecha." mediante la(s) cual(es) se determinó a su cargo una obligación por valor de $ ".number_format($total,2)." a favor del Tesoro Municipal, correspondiente a los períodos gravables de ".$vigegravables.".
		
		\n Su deuda a la fecha es de $ ".number_format($totalPredial,2).".

		En consecuencia, solicito a usted que dentro de los diez (10) días siguientes a la fecha del recibido de la presente comunicación, se acerque a esta oficina con el fin de aclarar la situación y si es del caso, realizar el pago efectivo de la deuda, evitando así el inicio del Proceso Administrativo Coactivo. 
 
		\n \n Cordialmente, "),0,'J');			
		$sqlr="select *from  tesoparametros where estado='S'";
		//echo $sqlr;
		$res=mysql_query($sqlr,$linkbd);

		while($row=mysql_fetch_row($res))
 		{
			//$ppto=$row[0];
			$teso=$row[4];
 		}	
		$pdf->SetFont('Times','B',10);
		$pdf->MultiCell(200,4," \n \n \n \n \n \n \n \n \n \n \n \n \n \n ".strtoupper($teso)." \n SECRETARIA HACIENDA MUNICIPAL",0,'C');	
		//$pdf->ln(4);
		$pdf->SetFont('times','',8);
	//$pdf->multicell(199,4,'* Contra la presente liquidaci'.utf8_decode(ó).'n procede el recurso de reconsideraci'.utf8_decode(ó).'n dentro de los dos (2) meses siguientes a su notificaci'.utf8_decode(ó).'n',0);
	$nr=$nr+1;
	
	$linkbd=conectar_bd();
	$sqlr="UPDATE tesocobroreporte SET expediente='' WHERE numresolucion='$_POST[numresolucion]'";
	mysql_query($sqlr,$linkbd);
	$sq="UPDATE tesocobroreporte SET expediente='$_POST[expediente]' WHERE numresolucion='$_POST[numresolucion]'";
	mysql_query($sq,$linkbd);
	//fin de if
}//**fin de for

$pdf->Output();
?>