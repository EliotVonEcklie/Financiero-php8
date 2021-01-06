<?php
//V 1000 12/12/16 
require('fpdf.php');
require('comun.inc');
session_start();
$nomuser=$_SESSION[usuario];
date_default_timezone_set("America/Bogota");
$linkbd=conectar_bd();
//*****las variables con los contenidos***********
//**********pdf*******
//$pdf=new FPDF('P','mm','Letter'); 
class PDF extends FPDF{
	//Cabecera de página
	function Header(){	
		$sqlr="select *from configbasica where estado='S'";
		$res=mysql_query($sqlr,$linkbd);
		while($row=mysql_fetch_row($res)){
	  		$nit=$row[0];
  			$rs=$row[1];
 		}
	  	//Parte Izquierda
    	$this->Image('imagenes/eng.jpg',23,10,25,25);
		$this->SetFont('Arial','B',10);
		$this->SetY(10);
		$this->RoundedRect(10, 10, 260, 38, 5,'' );
		$this->Cell(0.1);
    	$this->Cell(50,38,'','R',0,'C'); 
		$this->SetY(31);
    	$this->Cell(0.1);
    	$this->Cell(50,5,''.$rs,0,0,'C'); 
		$this->SetFont('Arial','B',8);
		$this->SetY(35);
    	$this->Cell(0.1);
    	$this->Cell(50,5,''.$nit,0,0,'C'); //Cuadro Izquierda
//*****************************************************************************************************************************
		$this->SetFont('Arial','B',14);
		$this->SetY(7);
        $this->Cell(50.1);
		if($_POST[tipomov]==101){
			$this->Cell(149,20,'Acta Entrada de Activos',0,1,'C'); 
		}
		else{
			if($_POST[tipomov]==201){
				$this->Cell(149,31,'Acta de Salida de Activos',0,1,'C');
			}
			else{
				if($_POST[tipomov]==301){
					$this->Cell(149,31,'Reversion de Entrada',0,1,'C');
				}else{
					if($_POST[tipomov]==401){
						$this->Cell(149,31,'Reversion de Salida'.$_POST[tipomov],0,1,'C');
					}
				}
			}
        }
		$this->SetY(8);
    	$this->Cell(50.1);
	    $this->Cell(149,20,''.$_POST[ntipoentra],0,0,'C'); 
//************************************
	    $this->SetFont('Arial','B',10);
        $linkbd=conectar_bd();
        $sqlrRp = "SELECT detalle FROM pptorp WHERE vigencia='$_POST[vigencia]' AND consvigencia='$_POST[docgen]'";
        $resRp=mysql_query($sqlrRp,$linkbd);
		$rowRp=mysql_fetch_row($resRp);
		$this->SetY(27);
		$this->Cell(50.2);
		$this->multiCell(209.5,4,'LA SUSCRITA JEFE DEL ALMACEN MUNICIPAL DE ALCALDIA SE PERMITE DAR ACTA DE INGRESO '.$rowRp[0],'T','L');
	
		$this->SetY(10);
    	$this->Cell(222.1);
		$this->Cell(37.8,17,'','L',0,'L');

	    $this->SetFont('Arial','B',8);
	
		$this->SetY(12);
		$this->Cell(223);
		$this->Cell(35,5,'NUMERO : '.$_POST[orden],0,0,'L');

		$this->SetY(16);
		$this->Cell(223);
		$this->Cell(35,5,'SOLICITUD : '.$_POST[docgen],0,0,'L');
	
		$this->SetY(20);
	    $this->Cell(223);
		$this->Cell(35,5,'FECHA: '.date('d-m-Y',strtotime($_POST[fecha])),0,0,'L');

		$this->SetY(27);
		$this->Cell(50.2);

		$this->MultiCell(110.7,4,'',0,'L');		
        
//********************************************************************************************************************************
		$this->line(10.1,52,269,52);
		$this->RoundedRect(10,53, 260, 9, 1.2,'' );	
        $this->SetFont('Arial','B',9);
        $this->SetY(55);
    	$this->Cell(15,5,'Item ',0,0,'C'); 
		$this->SetY(55);
    	$this->Cell(7);
    	$this->Cell(50,5,'Placa ',0,0,'C'); 
		$this->SetY(55);
   		$this->Cell(80.1);
		$this->Cell(41,5,'Nombre del Articulo',0,0,'C');
		$this->SetY(55);
   		$this->Cell(182.1);
		$this->Cell(31,5,'Vr. Articulo',0,0,'C');
		$this->line(10.1,63,269,63);
		$this->ln(4);
//********************************************************************************************************************************
	}
//Pie de página
	function Footer(){
	    $this->SetY(-15);
		$this->SetFont('Arial','I',10);
		$this->Cell(0,10,'Pagina '.$this->PageNo().' de {nb}',0,0,'R'); // el parametro {nb} 
	}
}
//Creación del objeto de la clase heredada
//$pdf=new PDF('P','mm',array(210,140));
$pdf=new PDF('L','mm','Letter'); 
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Times','',8);

$pdf->SetAutoPageBreak(true,20);

$pdf->SetY(65);   
$con=0;
$total=0;
//$sql="SELECT almginventario_det.unspsc, almginventario_det.codart, almarticulos.nombre, almginventario_det.cantidad_entrada,almginventario_det.cantidad_salida, almginventario_det.valorunit, almginventario_det.valortotal,almginventario_det.unidad FROM almginventario_det INNER JOIN almarticulos ON almginventario_det.codart=CONCAT(almarticulos.grupoinven, almarticulos.codigo) WHERE almginventario_det.codigo='$_POST[numero]' AND almginventario_det.tipomov='$_POST[tipomov]' AND almginventario_det.tiporeg='$_POST[entr]' ORDER BY almginventario_det.codart";
$cant=0;
$cont=1;
for($x=0; $x<count($_POST[dplaca]); $x++)
{
    $sql = "SELECT nombre, valor  FROM acticrearact_det WHERE placa='".$_POST[dplaca][$x]."' AND codigo='$_POST[orden]'";
    $res=mysql_query($sql, $linkbd);
    $row=mysql_fetch_array($res);

    $v=$pdf->gety();
    if($v>=160){
        $pdf->AddPage();
        $pdf->ln(10);
        $v=$pdf->gety();
    }
    
    if ($con%2==0){
        $pdf->SetFillColor(255,255,255);
    }
    else{
        $pdf->SetFillColor(245,245,245);
    }
    $pdf->Cell(2);
    $pdf->Cell(20,4,$cont,0,0,'L',1);//descrip
    $pdf->Cell(40,4,$_POST[dplaca][$x],0,0,'L',1);//descrip
    $pdf->MultiCell(100,4,$row[0],0,'L',true);//descrip
    $w=$pdf->gety();
    $pdf->SetY($v);
    $pdf->SetX(155);
    $pdf->Cell(58,4,number_format($row[1]),0,1,'R',1);//descrip
    $total=$total+$row[1];		
    $con=$con+1;
    $cont+=1;
    $pdf->SetY($w);
}


$pdf->ln(4);
$v=$pdf->gety();
$x=$pdf->getx();
$pdf->line(10.1,$v-2,269,$v-2);
$pdf->Cell(155);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(30,4,'Total',0,0,'C');
$pdf->Cell(26,4,''.number_format($total),0,1,'C');
$pdf->ln(3);

if($_POST[tipomov]==101)
{
    $v=$pdf->gety();
    if($v>=160){
        $pdf->AddPage();
        $pdf->ln(10);
        $v=$pdf->gety();
    }
    $x=$pdf->getx();
	$pdf->RoundedRect($x+7, $v, 120 , 40, 1.2,'' );
	$pdf->RoundedRect($x+130, $v, 120 , 40, 1.2,'' );
    $pdf->Cell(8);
    $pdf->Cell(125,6,'ENTREGA: ',0,0,'L');
    $pdf->Cell(200,6,'RECIBIO: ',0,0,'L');
    $pdf->ln(5.5);
    $pdf->Cell(8);
    $pdf->Cell(125,6,'Firma: ',0,0,'L');
    $pdf->Cell(125,6,'Firma: ',0,0,'L');
    $w=$pdf->gety();
    $pdf->line(30,$w+4,80,$w+4);
    $pdf->line(155,$w+4,210,$w+4);
    $pdf->ln(5.5);
    $pdf->Cell(8);
    $pdf->Cell(125,6,'Nombre: ',0,0,'L');
    $pdf->Cell(200,6,'Nombre: Claudia Milena Hernandez Garcia',0,0,'L');
    $w=$pdf->gety();
    $pdf->line(35,$w+4,130,$w+4);
    $pdf->ln(5.5);
    $pdf->Cell(8);
    $pdf->Cell(125,6,'C.C: ',0,0,'L');
    $pdf->Cell(200,6,'Cargo: Jefe de Almacen',0,0,'L');
    $w=$pdf->gety();
    $pdf->line(30,$w+4,100,$w+4);
    $pdf->ln(5.5);
    $pdf->Cell(8);
    $pdf->Cell(125,6,'Direccion: ',0,0,'L');
    $w=$pdf->gety();
    $pdf->line(36,$w+4,130,$w+4);
    $pdf->ln(5.5);
    $pdf->Cell(8);
    $pdf->Cell(125,6,'Telefono: ',0,0,'L');
    $w=$pdf->gety();
    $pdf->line(35,$w+4,80,$w+4);
    $pdf->ln(5.5);
    $pdf->Cell(8);
    $pdf->Cell(125,6,'Correo Electronico: ',0,0,'L');
    $w=$pdf->gety();
	$pdf->line(50,$w+4,130,$w+4);

	for($x=0; $x<$_GET[beneficiario];$x++)
	{
		$v=$pdf->gety();
		if($v>=160){
			$pdf->AddPage();
			$pdf->ln(10);
			$v=$pdf->gety();
		}
		$x=$pdf->getx();
		$pdf->RoundedRect($x+7, $v, 120 , 40, 1.2,'' );
		$pdf->RoundedRect($x+130, $v, 120 , 40, 1.2,'' );
		$pdf->Cell(8);
		$pdf->Cell(125,6,'ENTREGA: ',0,0,'L');
		$pdf->Cell(200,6,'RECIBIO: ',0,0,'L');
		$pdf->ln(5.5);
		$pdf->Cell(8);
		$pdf->Cell(125,6,'Firma: ',0,0,'L');
		$pdf->Cell(125,6,'Firma: ',0,0,'L');
		$w=$pdf->gety();
		$pdf->line(30,$w+4,80,$w+4);
		$pdf->line(155,$w+4,210,$w+4);
		$pdf->ln(5.5);
		$pdf->Cell(8);
		$pdf->Cell(125,6,'Nombre: ',0,0,'L');
		$pdf->Cell(200,6,'Nombre: Claudia Milena Hernandez Garcia',0,0,'L');
		$w=$pdf->gety();
		$pdf->line(35,$w+4,130,$w+4);
		$pdf->ln(5.5);
		$pdf->Cell(8);
		$pdf->Cell(125,6,'C.C: ',0,0,'L');
		$pdf->Cell(200,6,'Cargo: Jefe de Almacen',0,0,'L');
		$w=$pdf->gety();
		$pdf->line(30,$w+4,100,$w+4);
		$pdf->ln(5.5);
		$pdf->Cell(8);
		$pdf->Cell(125,6,'Direccion: ',0,0,'L');
		$w=$pdf->gety();
		$pdf->line(36,$w+4,130,$w+4);
		$pdf->ln(5.5);
		$pdf->Cell(8);
		$pdf->Cell(125,6,'Telefono: ',0,0,'L');
		$w=$pdf->gety();
		$pdf->line(35,$w+4,80,$w+4);
		$pdf->ln(5.5);
		$pdf->Cell(8);
		$pdf->Cell(125,6,'Correo Electronico: ',0,0,'L');
		$w=$pdf->gety();
		$pdf->line(50,$w+4,130,$w+4);
	}
}
else
{
    $v=$pdf->gety();
    if($v>=160){
        $pdf->AddPage();
        $pdf->ln(10);
        $v=$pdf->gety();
    }
    $x=$pdf->getx();
	$pdf->RoundedRect($x+7, $v, 120 , 35, 1.2,'' );
	$pdf->RoundedRect($x+130, $v, 120 , 35, 1.2,'' );
    $pdf->Cell(8);
    $pdf->Cell(125,6,'RECIBIO: ',0,0,'L');
    $pdf->Cell(200,6,'ENTREGA: ',0,0,'L');
    $pdf->ln(5.5);
    $pdf->Cell(8);
    $pdf->Cell(125,6,'Firma: ',0,0,'L');
    $pdf->Cell(125,6,'Firma: ',0,0,'L');
    $w=$pdf->gety();
    $pdf->line(30,$w+4,80,$w+4);
    $pdf->line(155,$w+4,210,$w+4);
    $pdf->ln(5.5); 
    $pdf->Cell(8); 
    $pdf->Cell(125,6,'Comunidad: '.$_POST[comunidad],0,0,'L');
    $pdf->Cell(200,6,'Nombre: Claudia Milena Hernandez Garcia',0,0,'L');
    $w=$pdf->gety();
    $pdf->ln(5.5);
    $pdf->Cell(8);
    $pdf->Cell(125,6,'Nombre: '.$_POST[nomb],0,0,'L');
    $pdf->Cell(200,6,'Cargo: Jefe de Almacen',0,0,'L');
    $w=$pdf->gety();
    $pdf->ln(5.5);
    $pdf->Cell(8);
    $pdf->Cell(125,6,'C.C: '.$_POST[cedula],0,0,'L');
    $w=$pdf->gety();
    $pdf->ln(5.5);
    $pdf->Cell(8);
    $pdf->Cell(125,6,'Cargo: '.$_POST[cargo],0,0,'L');
    $w=$pdf->gety();
    $pdf->ln(5.5);
    $pdf->Cell(8);

	$pdf->ln(10);

	$contabene = $_GET[beneficiario]-1;
	for($z=0; $z<$contabene;$z++)
	{
		$v=$pdf->gety();
		if($v>=160){
			$pdf->AddPage();
			$pdf->ln(10);
			$v=$pdf->gety();
		}
		$x=$pdf->getx();

		if($contabene%2=='0')
		{
			$pdf->RoundedRect($x+7, $v, 120 , 22, 1.2,'' );
			$pdf->RoundedRect($x+130, $v, 120 , 22, 1.2,'' );
			$pdf->Cell(8);
			$pdf->Cell(125,6,'RECIBIO: ',0,0,'L');
			$pdf->Cell(200,6,'RECIBIO: ',0,0,'L');
			$pdf->ln(5.5);
			$pdf->Cell(8);
			$pdf->Cell(125,6,'Firma: ',0,0,'L');
			$pdf->Cell(125,6,'Firma: ',0,0,'L');
			$w=$pdf->gety();
			$pdf->line(30,$w+4,80,$w+4);
			$pdf->line(155,$w+4,210,$w+4);
			$pdf->ln(5.5);
			$pdf->Cell(8);
			$pdf->Cell(125,6,'Nombre: ',0,0,'L');
			$pdf->Cell(200,6,'Nombre: ',0,0,'L');
			$w=$pdf->gety();
			$pdf->line(35,$w+4,130,$w+4);
			$pdf->line(250,$w+4,160,$w+4);
			$pdf->ln(5.5);
			$pdf->Cell(8);
			$pdf->Cell(125,6,'C.C: ',0,0,'L');
			$pdf->Cell(200,6,'C.C:',0,0,'L');
			$pdf->line(50,$w+4,130,$w+4);
			$pdf->ln(10);
			$z=$z+1;
		}
		else
		{
			if($contabene-$z < '2')
			{
				$pdf->RoundedRect($x+7, $v, 120 , 22, 1.2,'' );
				$pdf->Cell(8);
				$pdf->Cell(125,6,'RECIBIO: ',0,0,'L');
				$pdf->ln(5.5);
				$pdf->Cell(8);
				$pdf->Cell(125,6,'Firma: ',0,0,'L');
				$w=$pdf->gety();
				$pdf->line(30,$w+4,80,$w+4);
				$pdf->ln(5.5);
				$pdf->Cell(8);
				$pdf->Cell(125,6,'Nombre: ',0,0,'L');
				$w=$pdf->gety();
				$pdf->line(35,$w+4,130,$w+4);
				$pdf->ln(5.5);
				$pdf->Cell(8);
				$pdf->Cell(125,6,'C.C: ',0,0,'L');
				$pdf->line(50,$w+4,130,$w+4);
				$pdf->ln(10);
			}
			else
			{
				$pdf->RoundedRect($x+7, $v, 120 , 22, 1.2,'' );
				$pdf->RoundedRect($x+130, $v, 120 , 22, 1.2,'' );
				$pdf->Cell(8);
				$pdf->Cell(125,6,'RECIBIO: ',0,0,'L');
				$pdf->Cell(200,6,'RECIBIO: ',0,0,'L');
				$pdf->ln(5.5);
				$pdf->Cell(8);
				$pdf->Cell(125,6,'Firma: ',0,0,'L');
				$pdf->Cell(125,6,'Firma: ',0,0,'L');
				$w=$pdf->gety();
				$pdf->line(30,$w+4,80,$w+4);
				$pdf->line(155,$w+4,210,$w+4);
				$pdf->ln(5.5);
				$pdf->Cell(8);
				$pdf->Cell(125,6,'Nombre: ',0,0,'L');
				$pdf->Cell(200,6,'Nombre: ',0,0,'L');
				$w=$pdf->gety();
				$pdf->line(35,$w+4,130,$w+4);
				$pdf->line(250,$w+4,160,$w+4);
				$pdf->ln(5.5);
				$pdf->Cell(8);
				$pdf->Cell(125,6,'C.C: ',0,0,'L');
				$pdf->Cell(200,6,'C.C:',0,0,'L');
				$pdf->line(50,$w+4,130,$w+4);
				$pdf->ln(10);
				$z=$z+1;
			}
		}
	}
}

$pdf->Output();
?> 


