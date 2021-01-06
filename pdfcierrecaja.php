<?php
//V 1000 12/12/16 
require('fpdf.php');
require('comun.inc');
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
$linkbd=conectar_bd();
$sqlr="select *from configbasica where estado='S'";
//echo $sqlr;
$res=mysql_query($sqlr,$linkbd);
while($row=mysql_fetch_row($res))
 {
  $nit=$row[0];
  $rs=$row[1];
 }
     //Parte Izquierda
    $this->Image('imagenes/eng.jpg',23,10,25,25);
	$this->SetFont('Arial','B',10);
	$this->SetY(10);
	$this->RoundedRect(10, 10, 199, 31, 2.5,'' );
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
    $this->Cell(149,20,'CIERRE DE CAJA',0,0,'C'); 
	//************************************
    $this->SetFont('Arial','B',10);
	
	$this->SetY(27);
	$this->Cell(50.2);
	$this->multiCell(110.7,7,'RANGO RECIBOS: '.$_POST[inicial2].' al '.$_POST[inicial],'T','L');
	
	$this->SetY(27);
    $this->Cell(161.1);
	$this->Cell(37.8,14,'','TL',0,'L');
	
	$this->SetY(28.5);
    $this->Cell(161);
	$this->Cell(38,5,'FECHA CIERRE','B',0,'C');
	
	$this->SetY(34.5);
    $this->Cell(161);
	$this->Cell(38,5,''.$_POST[fechac],'0',0,'C');
	
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
				$this->ln(12);
			
//************************	***********************************************************************************************************
}
//Pie de página
function Footer()
{


    $this->SetY(-15);
	$this->SetFont('Arial','I',7);
	$this->Cell(0,10,'Impreso por: Software SPID - G&C Tecnoinversiones SAS. - Pagina '.$this->PageNo().' de {nb}',0,0,'R'); // el parametro {nb} 
	
	
}
}

//Creación del objeto de la clase heredada
//$pdf=new PDF('P','mm',array(210,140));
$pdf=new PDF('P','mm','Letter'); 
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Times','',10);


$pdf->SetAutoPageBreak(true,20);

	$pdf->SetFont('times','B',9);
	$pdf->SetY(43.7);
    $pdf->Cell(0.1);
	$pdf->Cell(33,4,'FECHA IMPRESION:','B',1,'L'); 
	
	$pdf->SetFont('times','',9);
	$pdf->SetY(43.7);
    $pdf->Cell(33.1);
	$pdf->Cell(67,4,''.$_POST[fecha],'B',1,'R'); 

	$pdf->SetFont('times','B',9);
	$pdf->SetY(43.7);
   	$pdf->Cell(100.1);
	$pdf->Cell(27,4,'VIGENCIA:','LB',1,'L');

	$pdf->SetFont('times','',9);
	$pdf->SetY(43.7);
    $pdf->Cell(127.1);
	$pdf->Cell(72,4,''.$_POST[vigencia],'B',1,'R'); 
	
	$pdf->SetFont('times','B',9);
	$pdf->SetY(47.7);
    $pdf->Cell(0.1);
	$pdf->Cell(33,4,'TOTAL CONTEO:','B',1,'L'); 
	
	$pdf->SetFont('times','',9);
	$pdf->SetY(47.7);
    $pdf->Cell(27.1);
	$pdf->Cell(73,4,''.number_format($_POST[totconteo],2),'B',1,'R'); 

	$pdf->SetFont('times','B',9);
	$pdf->SetY(47.7);
   	$pdf->Cell(100.1);
	$pdf->Cell(27,4,'MONEDAS:','LB',1,'L');

	$pdf->SetFont('times','',9);
	$pdf->SetY(47.7);
    $pdf->Cell(122.1);
	$pdf->Cell(77,4,''.number_format($_POST[monedas],2),'B',1,'R'); 
		
	$pdf->SetFont('times','B',9);
	$pdf->SetY(51.7);
    $pdf->Cell(0.1);
	$pdf->Cell(38,4,'BILLETES:','B',1,'L'); 
	
	$pdf->SetFont('times','',9);
	$pdf->SetY(51.7);
    $pdf->Cell(38.1);
	$pdf->Cell(62,4,''.number_format($_POST[billetes],2),'B',1,'R'); 

	$pdf->SetFont('times','B',9);
	$pdf->SetY(51.7);
   	$pdf->Cell(100.1);
	$pdf->Cell(27,4,'CHEQUES:','LB',1,'L');

	$pdf->SetFont('times','',9);
	$pdf->SetY(51.7);
    $pdf->Cell(117.1);
	$pdf->Cell(82,4,''.number_format($_POST[cheques],2),'B',1,'R'); 
	
	$pdf->SetFont('times','B',9);
	$pdf->SetY(55.7);
    $pdf->Cell(0.1);
	$pdf->Cell(36.7,4,'CONSIGNACIONES:','B',1,'L'); 
	
	$pdf->SetFont('times','',9);
	$pdf->SetY(55.7);
    $pdf->Cell(37.1);
	$pdf->Cell(63,4,''.number_format($_POST[consignaciones],2),'B',1,'R'); 

	$pdf->SetFont('times','B',9);
	$pdf->SetY(55.7);
   	$pdf->Cell(100.1);
	$pdf->Cell(12,4,'','LB',1,'L');

	$pdf->SetFont('times','',9);
	$pdf->SetY(55.7);
    $pdf->Cell(112.1);
	$pdf->Cell(20,4,'','B',1,'L'); 
	
	$pdf->SetFont('times','B',9);
	$pdf->SetY(55.7);
   	$pdf->Cell(132.1);
	$pdf->Cell(8,4,'','B',1,'L');

	$pdf->SetFont('times','',9);
	$pdf->SetY(55.7);
    $pdf->Cell(140.1);
	$pdf->Cell(15,4,'','B',1,'L'); 
	
	$pdf->SetFont('times','B',9);
	$pdf->SetY(55.7);
   	$pdf->Cell(155.1);
	$pdf->Cell(8,4,'','B',1,'L');

	$pdf->SetFont('times','',9);
	$pdf->SetY(55.7);
    $pdf->Cell(163.1);
	$pdf->Cell(36,4,'','B',1,'L'); 
	
	$pdf->SetFont('times','B',9);
	$pdf->SetY(59.7);
    $pdf->Cell(0.1);
	$pdf->Cell(36.7,4,'TOTAL RECAUDADO:','B',1,'L'); 
	
	$pdf->SetFont('times','',9);
	$pdf->SetY(59.7);
    $pdf->Cell(37.1);
	$pdf->Cell(63,4,''.number_format($_POST[totalresumen2],2),'B',1,'R'); 

	$pdf->SetFont('times','B',9);
	$pdf->SetY(59.7);
   	$pdf->Cell(100.1);
	$pdf->Cell(32,4,'EFECTIVO:','LB',1,'L');

	$pdf->SetFont('times','',9);
	$pdf->SetY(59.7);
    $pdf->Cell(132.1);
	$pdf->Cell(67,4,''.number_format($_POST[totalefec2],2),'B',1,'R'); 

	$pdf->SetFont('times','B',9);
	$pdf->SetY(63.7);
    $pdf->Cell(0.1);
	$pdf->Cell(36.7,4,'CONSIGNACIONES:','B',1,'L'); 
	
	$pdf->SetFont('times','',9);
	$pdf->SetY(63.7);
    $pdf->Cell(37.1);
	$pdf->Cell(63,4,''.number_format($_POST[totalban2],2),'B',1,'R'); 

	$pdf->SetFont('times','B',9);
	$pdf->SetY(63.7);
   	$pdf->Cell(100.1);
	$pdf->Cell(32,4,'PREDIAL:','LB',1,'L');

	$pdf->SetFont('times','',9);
	$pdf->SetY(63.7);
    $pdf->Cell(132.1);
	$pdf->Cell(67,4,''.number_format($_POST[totalpredial2],2),'B',1,'R'); 


	$pdf->SetFont('times','B',9);
	$pdf->SetY(67.7);
    $pdf->Cell(0.1);
	$pdf->Cell(36.7,4,'INDUSTRIA:','B',1,'L'); 
	
	$pdf->SetFont('times','',9);
	$pdf->SetY(67.7);
    $pdf->Cell(37.1);
	$pdf->Cell(63,4,''.number_format($_POST[totalindustria2],2),'B',1,'R'); 

	$pdf->SetFont('times','B',9);
	$pdf->SetY(67.7);
   	$pdf->Cell(100.1);
	$pdf->Cell(32,4,'OTROS REC.','LB',1,'L');

	$pdf->SetFont('times','',9);
	$pdf->SetY(67.7);
    $pdf->Cell(132.1);
	$pdf->Cell(67,4,''.number_format($_POST[totalotros2],2),'B',1,'R'); 

$pdf->ln(6);

	$pdf->SetFont('times','B',9);
	$pdf->Cell(20,4,'TOTAL RECAUDO',0,0,'L');
	$pdf->SetFont('times','B',14);
		$pdf->cell(52);
	$pdf->Cell(55,4,'$'.number_format($_POST[totalresumen2],2),0,1,'L'); 
					
	$pdf->RoundedRect(10, 43, 199, 40, 1.2,'' );

$pdf->ln(14);

	$pdf->SetFont('times','B',9);
	$pdf->Cell(20,4,'ELABORO CIERRE:',0,0,'L');
	$pdf->SetFont('times','',10);
		$pdf->cell(12);
	$pdf->Cell(70,4,strtoupper($_SESSION[usuario]),0,0,'L'); 


	$pdf->SetFont('times','B',9);
	$pdf->Cell(20,4,'APROBO JEFE TESORERIA:',0,0,'L');
	$pdf->SetFont('times','',10);
		$pdf->cell(25);
	$pdf->Cell(55,4,'',0,1,'L'); 
	
	$pdf->ln(4);
	$pdf->SetFont('arial','B',14);
	$pdf->Cell(199,4,'RESUMEN CIERRE DE CAJA',0,0,'C');
 $pdf->ln(8); 
	 $y=$pdf->GetY();	
	$pdf->SetFillColor(222,222,222);
	$pdf->SetFont('Arial','B',10);
	$pdf->SetY($y);
    $pdf->Cell(0.1);
    $pdf->Cell(22,5,'Codigo ',0,0,'C',1); 
		$pdf->SetY($y);
    	$pdf->Cell(23.1);
		$pdf->Cell(120,5,'Ingreso',0,0,'C',1);
		$pdf->SetY($y);
       	$pdf->Cell(144.1);
		$pdf->Cell(50,5,'Valor',0,0,'C',1);
$pdf->SetFont('Arial','',10);
	 	$cont=0;
			 $pdf->ln(5); 
			 $suming=0;
 for($x=0;$x<count($_POST[codigos]);$x++)
	 {	
	  if ($con%2==0)
	  {$pdf->SetFillColor(255,255,255);
	  }
      else
	  {$pdf->SetFillColor(245,245,245);
	  }
		$pdf->Cell(22,4,''.$_POST[codigos][$x],'',0,'C',1);
		$pdf->Cell(120,4,''.$_POST[inombres][$x],'',0,'L',1);
		$pdf->Cell(52,4,''.$_POST[valoresi][$x],'',1,'R',1);		
		$con=$con+1;
	}
	 $pdf->SetFillColor(245,245,245);
$pdf->Cell(125);	 
$pdf->Cell(15,4,'TOTAL:','',0,'R',1);	 
$pdf->Cell(54,4,''.number_format($_POST[itotales],2),'',1,'R',1);
	
$pdf->ln(6);

$y=$pdf->GetY();	
	$pdf->SetY($y);
$pdf->SetFillColor(222,222,222);
$pdf->SetFont('Arial','B',10);
	$pdf->SetY($y);
    $pdf->Cell(0.1);
    $pdf->Cell(22,5,'No Recibo ',0,0,'C',1); 
		$pdf->SetY($y);
    	$pdf->Cell(23.1);
		$pdf->Cell(30,5,'Fecha',0,0,'C',1);
			$pdf->SetY($y);
        	$pdf->Cell(54.1);
			$pdf->Cell(31,5,'No Liqui',0,0,'C',1);
			$pdf->SetY($y);
        	$pdf->Cell(86.1);
			$pdf->Cell(45,5,'Valor',0,0,'C',1);
			$pdf->SetY($y);
        	$pdf->Cell(132.1);
			$pdf->Cell(30,5,'Tipo',0,0,'C',1);
			$pdf->SetY($y);
        	$pdf->Cell(163.1);
			$pdf->Cell(31,5,'Forma de Pago',0,0,'C',1);
$pdf->SetFont('Arial','',10);
$pdf->ln(6);
$con=0;
ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechac],$fecha);
$fechab=$fecha[3]."-".$fecha[2]."-".$fecha[1];					
$crit1=" and tesoreciboscaja.fecha = '".$fechab."' ";
$linkbd=conectar_bd();
$sqlr="select *from tesoreciboscaja where tesoreciboscaja.estado='S' ".$crit1.$crit2." order by tesoreciboscaja.id_recibos";
$resp = mysql_query($sqlr,$linkbd);
$tipos=array('Predial','Industria y Comercio','Otros Recaudos');
 while ($row =mysql_fetch_row($resp)) 
 {
	$num='0';
	$sq="SELECT *FROM tesoabono WHERE cierre='$row[4]'";
	$rst=mysql_query($sq,$linkbd);	
	$num=mysql_num_rows($rst);
	if($num=='0')
	{
		if ($con%2==0)
		{
			$pdf->SetFillColor(255,255,255);
		}
		else
		{
			$pdf->SetFillColor(245,245,245);
		}
		$pdf->Cell(23,4,''.$row[0],0,0,'L',1);//descrip
		$pdf->Cell(35,4,substr(''.$row[2],0,25),0,0,'C',1);//descrip
		$pdf->Cell(27,4,substr(''.$row[4],0,25),0,0,'C',1);//descrip
		$pdf->Cell(46,4,substr(''.number_format($row[8],2),0,25),0,0,'R',1);//descrip
		$pdf->Cell(31,4,substr(''.$tipos[$row[10]-1],0,25),0,0,'',1);//descrip
		$pdf->Cell(32,4,substr(''.$row[5],0,25),0,0,'C',1);//descrip	 	 
		$pdf->ln(4);
		$con=$con+1;
	} 
 }

$pdf->ln(6);	
$y=$pdf->GetY();	
	$pdf->SetY($y);
$pdf->SetFillColor(222,222,222);
$pdf->SetFont('Arial','B',10);
    $pdf->Cell(0.1);
    $pdf->Cell(194,5,'RECIBOS ANULADOS',0,0,'C',1); 


$pdf->ln(6);
$y=$pdf->GetY();	

$pdf->SetFillColor(222,222,222);
$pdf->SetFont('Arial','B',10);
	$pdf->SetY($y);
    $pdf->Cell(0.1);
    $pdf->Cell(22,5,'No Recibo ',0,0,'C',1); 
		$pdf->SetY($y);
    	$pdf->Cell(23.1);
		$pdf->Cell(30,5,'Fecha',0,0,'C',1);
			$pdf->SetY($y);
        	$pdf->Cell(54.1);
			$pdf->Cell(31,5,'No Liqui',0,0,'C',1);
			$pdf->SetY($y);
        	$pdf->Cell(86.1);
			$pdf->Cell(45,5,'Valor',0,0,'C',1);
			$pdf->SetY($y);
        	$pdf->Cell(132.1);
			$pdf->Cell(30,5,'Tipo',0,0,'C',1);
			$pdf->SetY($y);
        	$pdf->Cell(163.1);
			$pdf->Cell(31,5,'Forma de Pago',0,0,'C',1);
$pdf->SetFont('Arial','',10);
$pdf->ln(6);
$con=0;
ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechac],$fecha);
$fechab=$fecha[3]."-".$fecha[2]."-".$fecha[1];					
$crit1=" and tesoreciboscaja.fecha = '".$fechab."' ";
$linkbd=conectar_bd();
$sqlr="select *from tesoreciboscaja where tesoreciboscaja.estado='N' ".$crit1.$crit2." order by tesoreciboscaja.id_recibos";
$resp = mysql_query($sqlr,$linkbd);
$tipos=array('Predial','Industria y Comercio','Otros Recaudos');
 while ($row =mysql_fetch_row($resp)) 
 {
  if ($con%2==0)
	{$pdf->SetFillColor(255,255,255);
	}
    else
	{$pdf->SetFillColor(245,245,245);
	}
	 $pdf->Cell(23,4,''.$row[0],0,0,'L',1);//descrip
     $pdf->Cell(35,4,substr(''.$row[2],0,25),0,0,'C',1);//descrip
	 $pdf->Cell(27,4,substr(''.$row[4],0,25),0,0,'C',1);//descrip
	 $pdf->Cell(46,4,substr(''.number_format($row[8],2),0,25),0,0,'R',1);//descrip
	 $pdf->Cell(31,4,substr(''.$tipos[$row[10]-1],0,25),0,0,'',1);//descrip
	 $pdf->Cell(32,4,substr(''.$row[5],0,25),0,0,'C',1);//descrip	 	 
	 $pdf->ln(4);
	 $con=$con+1;
 // echo "<tr ><td class='$iter'>$row[0]</td><td class='$iter'>$row[2]</td><td class='$iter'>$row[4]</td><td class='$iter'>".number_format($row[8],2)."</td><td class='$iter'>".$tipos[$row[10]-1]."</td><td class='$iter'>".$row[5]."</td></tr>"; 
 }

$pdf->Output();
?> 


