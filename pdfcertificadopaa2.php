<?php

require('fpdf.php');
require('comun.inc');
require('funciones.inc');
require "conversor.php";
ini_set("max-execution-time",9000000000);
ini_set('memory_limit', 51200000000);
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

		    $this->Image('imagenes/eng.jpg',18,10,25,25);
		    $this->Image('imagenes/eng.jpg',175,10,25,25);
			$this->SetFont('Arial','B',10);
			$this->SetY(10);
			$this->Cell(0.1);
			

		    //*****************************************************************************************************************************
			$this->SetFont('Arial','B',12);
			$this->SetY(10);
			$this->Cell(40);
		    $this->Cell(149,31,'',0,1,''); 
			$this->SetY(35);
		    $this->Cell(15);
			$this->MultiCell(165,4,'EL ADMINISTRADOR DEL PLAN ANUAL DE ADQUISICIONES DEL '.strtoupper($rs),0,'C');
			$this->Cell(0,10,'HACE CONSTAR',0,1,'C');
		    $this->Cell(40);
			$this->SetFont('Arial','B',12);
			 
			//************************************
		    
			$this->SetY(27);
			$this->Cell(50.2);

			$this->MultiCell(105.7,4,'',0,'L');		
			

			
		//********************************************************************************************************************************

			$this->SetFont('times','B',10);

						$this->ln(2);
						
					
	//************************	***********************************************************************************************************
	}
	

	//Pie de página
	function Footer()
	{

		$linkbd=conectar_bd();
		$sql="SELECT planacareas_info.correo FROM planacareas_info,planacareas WHERE planacareas_info.codarea=planacareas.codarea AND planacareas.nombrearea LIKE '%SECRETARI_ DE HACIENDA%' AND planacareas.estado='S' ";
		$res=mysql_query($sql,$linkbd);
		$correo=mysql_fetch_row($res);
		$sql="SELECT web,direccion,telefono FROM configbasica";
		$res=mysql_query($sql,$linkbd);
		$datBasicos=mysql_fetch_row($res);
		$sql2="SELECT lema FROM interfaz01";
		$res2=mysql_query($sql2,$linkbd);
		$lema=mysql_fetch_row($res2);
		
	    $this->SetY(-35);
		$this->SetFont('Arial','BI',14);
		$this->Cell(0,10,'"'.$lema[0].'"',0,0,'C');
		$this->SetFont('Arial','I',10);
		$this->ln(5);
		$this->Cell(0,10,''.$datBasicos[1],0,0,'C');
		$this->ln(5);
		$this->Cell(0,10,'Telefono '.$datBasicos[2],0,0,'C'); 
		$this->ln(5);
		$this->Cell(0,10,utf8_decode('Página Web: '.strtolower($datBasicos[0])),0,0,'C');
		$this->ln(5);
		$this->Cell(0,10,'E-mail: '.$correo[0],0,0,'C');
		
	}
}

//Creación del objeto de la clase heredada
//$pdf=new PDF('P','mm',array(210,140));
$pdf=new PDF('P','mm','Legal');
$pdf->AliasNbPages();
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
$fecha=Array();
$totalpagar=array();
	if ($_POST[nombre]!="")
			$crit1="and codcatastral LIKE '%$_POST[nombre]%'";
	if($_POST[numresolucion]!=""){
			$crit2="and numresolucion='$_POST[numresolucion]'";
		}
	if($_POST[numbusqueda]!=""){
			$crit3="and idconsulta='$_POST[numbusqueda]'";
		}
$sql="select *from tesocobroreporte where idtesoreporte>-1 $crit1 $crit2 $crit3 ";
$result = mysql_query($sql,$linkbd);
$i=0;
while($row=mysql_fetch_array($result)){
	$dvigencias[$i]=$row[2];
	$dcodcatas[$i]=$row[3];
	$dpredial[$i]=$row[4];
	$dipredial[$i]=$row[5];
	$dimpuesto1[$i]=$row[6];
	$dinteres1[$i]=$row[7];
	$dimpuesto2[$i]=$row[8];
	$dinteres2[$i]=$row[9];
	$ddescuentos[$i]=$row[10];
	$dtasavig[$i]=$row[14];
	$dvaloravaluo[$i]=$row[15];
	$numresolucion[$i]=$row[16];
	$totalpagar[$i]=$row[12];
	$totage[$i]=$row[12];
	$fecharesolucion[$i]=$row[17];
	$i++;
}
//$pdf->AddPage();
//$disc=0;
$linkbd=conectar_bd();
$sqlr="select *from configbasica where estado='S'";
$res=mysql_query($sqlr,$linkbd);
while($row=mysql_fetch_row($res))
{
  $nit=$row[0];
  $rs=$row[1];
  $nalca=$row[6];
}
$linkbd=conectar_bd();
$nr=selconsecutivo('tesocobroreportepdf','numresolucion');
$fecharesol=date('Y-m-d');

$disc=count($dcodcatas);
$nuevo="";
$actual="";
	if($nuevo=="")
	{
		//$actual=$_POST[vigencias][0];
	$nuevo=1;
	}
	
	if($dcodcatas[0]!=$actual)
	{

		$pdf->AddPage();
		$posy=$pdf->GetY();
		$pdf->SetY($posy+20);
		$pdf->Cell(0.5);
		$pdf->SetFont('Arial','B',10);		
		$pdf->MultiCell(195,7,'FECHA '.date('d').' de '.(strftime('%B')).' de '.date('Y'),0,'L'); //'.$numresolucion[0].'
		$pdf->ln(5);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(195,5,utf8_decode('Que se encuentra incluido en el plan de adquisiciones de bienes, servicios y obra publica del municipio para la vigencia '.$_POST[vigencia].' el contrato de prestacion de servicios y sus actividades, que tienen por objeto:'),0,'J');	
		$pdf->ln(5);
		$sqlr="select valortotalest, descripcion from contraplancompras where codplan=".$_POST[dpaa][0];
		$res=mysql_query($sqlr,$linkbd);
		$r=mysql_fetch_row($res);
		$pdf->SetFont('Arial','B',10);
		$pdf->MultiCell(195,5,utf8_decode('OBJETO: '.$r[1]),0,'J');
		$pdf->ln(5);
		$pdf->MultiCell(195,5,utf8_decode('VALOR: '.strtoupper(convertir($r[0])).' PESOS M/CTE ($ '.number_format($r[0]).'.00)'),0,'J');	
		$pdf->ln(8);
		$pdf->Cell(199,4,utf8_decode('FUENTE DE LOS RECURSOS'),0,1,'C');
		$pdf->ln(4);
		$pos=$pdf->GetY();
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(159,5,utf8_decode('FUENTE'),'BR',0,'C');
		$pdf->Cell(40,5,utf8_decode('VALOR'),'B',1,'C');
		
		// 2º Tabla **************************************************************************
		
		$pdf->SetFont('Arial','',6);
		//************************************************************************************
		$posy=$pdf->GetY();
		$pdf->SetY($posy);
		$sum=0;
		$sqlr="select f.nombre, c.valortotalest, c.requierevigfut from contraplancompras c, pptofutfuentefunc f where c.fuente=f.codigo AND codplan=".$_POST[dpaa][0];
		$res=mysql_query($sqlr,$linkbd);
		$r=mysql_fetch_row($res);
		$pdf->Cell(159,4,substr($r[0],0,120),'LB',0,'C'); //2
		$pdf->Cell(40,4,''.number_format($r[1],2),'LB',1,'C'); //3
		$posy2=$pdf->GetY();
		$pdf->RoundedRect(10, $pos, 199, $posy2-$pos, 0.5, '1111', '');
		$pdf->SetFont('Arial','',10);
		$pdf->ln(5);
		$pdf->MultiCell(195,5,utf8_decode('Clasificacion UNSPSC: La prestacion de servicios del objeto de contrato esta codificada en el clasificador de bienes y servicios UNSPSC, hasta el (cuarto) nivel como se indica en la tabla:'),0,'J');	
		$pdf->ln(5);
		$pox=$pdf->GetY();
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(50,5,utf8_decode('CLASIFICACIÓN UNSPSC'),1,0,'C');
		$pdf->Cell(149,5,utf8_decode('DESCRIPCIÓN'),'TBR',1,'C');
		$pdf->SetFont('Arial','',8);
		for($x=0;$x<count($_POST[dcodigos]);$x++)
 		{
			$pdf->Cell(50,5,utf8_decode(''.$_POST[dcodigos][$x]),'LBR',0,'C');
			$pdf->Cell(149,5,utf8_decode(utf8_encode(''.$_POST[dnomsol][$x])),'BR',1,'C');
			$p=$pdf->GetY();
			if($p>=300){
				$pdf->AddPage();
				$pdf->ln(20);
				$p=$pdf->gety();
				$pdf->Line(10,$p,209,$p);
				
			}
 		}
		
		$posy2=$pdf->GetY();
		$pdf->SetY($posy2+5);
		$pdf->SetFont('Arial','B',10);
		/*$pdf->MultiCell(199,8,utf8_decode('CLASIFICACIÓN PLAN DE COMPRAS'),'TRL','C');
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(35,5,utf8_decode('Servicios'),1,0,'C');
		$pdf->Cell(18,5,'','TBR',0,'C');
		$pdf->Cell(20,5,'','TBR',0,'C');
		$pdf->Cell(35,5,utf8_decode('Suministros'),'TBR',0,'C');
		$pdf->Cell(18,5,'','TBR',0,'C');
		$pdf->Cell(20,5,'','TBR',0,'C');
		$pdf->Cell(35,5,utf8_decode('Obra'),'TRB',0,'C');
		$pdf->Cell(18,5,'','TBR',1,'C');
		$pdf->SetFont('Arial','B',10);
		*/$pdf->MultiCell(199,5,utf8_decode('MODALIDAD DE SELECCION:'),'LTR','C');
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(199,5,utf8_decode(''.utf8_encode($_POST[modadqui][0])),1,'L');
		$pdf->SetFont('Arial','B',10);
		$pdf->MultiCell(199,5,utf8_decode('VIGENCIAS FUTURAS'),'LR','C');
		$pdf->SetFont('Arial','',10);
		$vig=$pdf->GetY();
		$pdf->MultiCell(40,5,utf8_decode('Se requieren vigencias Futuras'),1,'L');
		$pdf->SetY($vig);
		$pdf->SetX(50);
		if($r[2]=='N'){
			$pdf->Cell(18,5,'SI','TBR',0,'C');
			$pdf->Cell(18,5,'','TBR',0,'C');
			$pdf->Cell(40,10,'','TBR',0,'C');
			$pdf->MultiCell(40,5,utf8_decode('Estado de Solicitud Vigencias Futuras'),1,'L');
			$pdf->SetY($vig);
			$pdf->SetX(166);
			$pdf->Cell(25,5,'No Aplica',1,0,'L');
			$pdf->Cell(18,5,'X','TBR',0,'C');
		}else
		{
			$pdf->Cell(18,5,'SI','TBR',0,'C');
			$pdf->Cell(18,5,'X','TBR',0,'C');
			$pdf->Cell(40,10,'','TBR',0,'C');
			$pdf->MultiCell(40,5,utf8_decode('Estado de Solicitud Vigencias Futuras'),1,'L');
			$pdf->SetY($vig);
			$pdf->SetX(166);
			$pdf->Cell(25,5,'No Aplica',1,0,'L');
			$pdf->Cell(18,5,'','TBR',0,'C');
		}
		
		$pdf->SetY($vig+5);
		$pdf->SetX(50);
		if($r[2]=='N'){
			$pdf->Cell(18,5,'NO','BR',0,'C');
			$pdf->Cell(18,5,'X','BR',0,'C');
			$pdf->SetX(166);
			$pdf->Cell(25,5,'No Solicitada','BR',0,'L');
			$pdf->Cell(18,5,'','BR',1,'C');
		}else
		{
			$pdf->Cell(18,5,'NO','BR',0,'C');
			$pdf->Cell(18,5,'','BR',0,'C');
			$pdf->SetX(166);
			$pdf->Cell(25,5,'No Solicitada','BR',0,'L');
			$pdf->Cell(18,5,'X','BR',1,'C');
		}
		$pdf->SetFont('Arial','B',10);
		$pdf->MultiCell(199,5,utf8_decode('TIEMPO ESTIMADO PARA LA EJECUCION:'),'RL','L');
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(149,5,''.$_POST[dur][0],'BLT',0,'C');
		$pdf->Cell(50,5,'DIAS',1,0,'C');
		$pdf->ln(10);
		$pdf->MultiCell(195,4,utf8_decode('Esta constancia se hace basada en el registro del Plan Anual de Adquisiciones de la vigencia '.$_POST[vigencia].', establecido por el responsable de la SECRETARIA DE GOBIERNO Y DESARROLLO SOCIAL, y su correspondiente plan de accion' ),0,'J');
		$pdf->ln(18);
		
	$nr=$nr+1;
	}//fin de if
	$linkbd=conectar_bd();

$sqlr="select id_cargo,id_comprobante from pptofirmas where id_comprobante='24' and vigencia='".$_POST[vigencia]."'";
$res=mysql_query($sqlr,$linkbd);
while($row=mysql_fetch_assoc($res))
{
	$sqlr1="select cedulanit,(select nombrecargo from planaccargos where codcargo='".$row["id_cargo"]."') from planestructura_terceros where codcargo='".$row["id_cargo"]."' and estado='S'";
	$res1=mysql_query($sqlr1,$linkbd);
	$row1=mysql_fetch_row($res1);
	$_POST[ppto][]=buscar_empleado($row1[0]);
	$_POST[nomcargo][]=$row1[1];
}

for($x=0;$x<count($_POST[ppto]);$x++)
{
	$pdf->ln(14);
	$v=$pdf->gety();
	if($v>=251){ 
		$pdf->AddPage();
		$pdf->ln(20);
		$v=$pdf->gety();
	}
	$pdf->setFont('times','B',8);
	if (($x%2)==0) {
		if(isset($_POST[ppto][$x+1])){
			$pdf->Line(17,$v,107,$v);
			$pdf->Line(112,$v,202,$v);
			$v2=$pdf->gety();
			$pdf->Cell(104,4,''.utf8_decode($_POST[ppto][$x]),0,1,'C',false,0,0,false,'T','C');
			$pdf->Cell(104,4,''.utf8_decode($_POST[nomcargo][$x]),0,1,'C',false,0,0,false,'T','C');
			$pdf->SetY($v2);
			$pdf->Cell(295,4,''.utf8_decode($_POST[ppto][$x+1]),0,1,'C',false,0,0,false,'T','C');
			$pdf->Cell(295,4,''.utf8_decode($_POST[nomcargo][$x+1]),0,1,'C',false,0,0,false,'T','C');
		}else{
			$pdf->Line(50,$v,160,$v);
			$pdf->Cell(190,4,''.utf8_decode($_POST[ppto][$x]),0,1,'C',false,0,0,false,'T','C');
			$pdf->Cell(190,4,''.utf8_decode($_POST[nomcargo][$x]),0,0,'C',false,0,0,false,'T','C');
		}
		$v3=$pdf->gety();
	}
	$pdf->SetY($v3);
	$pdf->SetFont('helvetica','',7);
}

$pdf->Output();
?>