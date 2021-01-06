<?php
	header("content-disposition: attachment;filename=presupuestoauxiliarcuentasingresos.xls");
	header("Content-Type: application/vnd.ms-excel");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	require('comun.inc');
	require('funciones.inc');
	
//session_start();
   date_default_timezone_set("America/Bogota");
//*****las variables con los contenidos***********
//**********pdf*******
//$pdf=new FPDF('P','mm','Letter'); 
$sumacdp=0;
	$sumarp=0;	
	$sumaop=0;	
	$sumap=0;			
	$sumai=0;
	$sumapi=0;				
	$sumapad=0;	
$sumapred=0;	
$sumapcr=0;	
$sumapccr=0;						
ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
	$fechaf2=$fecha[3]."-".$fecha[2]."-".$fecha[1];	

$linkbd=conectar_bd();
$sqlr="select *from configbasica where estado='S'";
//echo $sqlr;
$res=mysql_query($sqlr,$linkbd);
while($row=mysql_fetch_row($res))
 {
  $nit=$row[0];
  $rs=$row[1];
 }
 
   echo "<table bordercolor=#333333 border=1 ><tr><td colspan='8' style='color:#000000; font-weight:bold;background-color:#cccccc' align='center'>$rs - $nit</td></tr><tr><td colspan='8' style='color:#000000; font-weight:bold;background-color:#ccddee' align='center' >MOVIMIENTOS CONTABLES - Periodo: $_POST[fecha] - $_POST[fecha2] <b><span>$_POST[cuenta] - $_POST[ncuenta]</span></b></td></tr>";
  echo "<tr><td style='color:#000000; font-weight:bold;background-color:#0066FF'>FECHA</td><td style='color:#000000; font-weight:bold;background-color:#0066FF''>TIPO COMPROBANTE</td><td style='color:#000000; font-weight:bold;background-color:#0066FF''>NO COMPROBANTE</td><td style='color:#000000; font-weight:bold;background-color:#0066FF''>NO LIQU.</td><td style='color:#000000; font-weight:bold;background-color:#0066FF''>TIPO LIQU.</td><td style='color:#000000; font-weight:bold;background-color:#0066FF''>Entrada</td><td style='color:#000000; font-weight:bold;background-color:#0066FF''>Salida</td><td style='color:#000000; font-weight:bold;background-color:#0066FF''>Saldo</td></tr>";  
  $ft="<tr><td > %s </td><td>%s</td><td >%s</td><td >%s</td><td >%s</td><td >%s</td><td >%s</td><td >%s</td></tr>";
  $ftn="<tr ><td style='font-weight:bold;background-color:#cccccc ' colspan='5'> %s </td><td style='font-weight:bold;background-color:#cccccc '>%s</td><td style='font-weight:bold;background-color:#cccccc '>%s</td><td style='font-weight:bold;background-color:#cccccc '>%s</td></tr>";
//echo $sqlr;
//$res=mysql_query($sqlr,$linkbd);
for($x=0;$x<count($_POST[nrec]);$x++)
 {		 	
	$sumapcr+=$pcr;
	$sumapccr+=$pccr;
	$sumapred+=$pred;
	$sumapad+=$pad;
	$sumapi+=$pi;
	$sumai+=$pdef;
	$sumacdp+=$row5[1];
	$sumarp+=$row2[1];
	$sumaop+=$row3[1];
	$sumap+=$row4[1];
	if($_POST[nrec][$x]=="**"){
		printf($ftn,''.$_POST[tiporec][$x],number_format(round($_POST[entrada][$x],2),2,',','.'),number_format(round($_POST[salida][$x],2),2,',','.'),number_format(round($_POST[saldo][$x],2),2,',','.'));
	}else{
		printf($ft,''.$_POST[fecrec][$x],$_POST[tiporec][$x],$_POST[nrec][$x],$_POST[nliq][$x],$_POST[tliq][$x],number_format(round($_POST[entrada][$x],2),2,',','.'),number_format(round($_POST[salida][$x],2),2,',','.'),number_format(round($_POST[saldo][$x],2),2,',','.'));
	}
		
 }

?> 


	