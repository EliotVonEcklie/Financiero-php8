<?php 
header("content-disposition: attachment;filename=auxiliarcuentas.xls");
header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
require('comun.inc');
require('funciones.inc');
//session_start();
date_default_timezone_set("America/Bogota");

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
$res=mysql_query($sqlr,$linkbd);
while($row=mysql_fetch_row($res))
 {
  $nit=$row[0];
  $rs=$row[1];
 }

   echo "<table bordercolor=#333333 border=1 ><tr><td colspan='13' style='color:#000000; font-weight:bold;background-color:#cccccc' align='center'>$rs - $nit</td></tr><tr><td colspan='13' style='color:#000000; font-weight:bold;background-color:#ccddee' align='center' >MOVIMIENTOS CONTABLES - Periodo: $_POST[fecha] - $_POST[fecha2]</td></tr>";
  echo "<tr><td style='color:#000000; font-weight:bold;background-color:#0066FF'>FECHA</td><td style='color:#000000; font-weight:bold;background-color:#0066FF''>TIPO COMPROBANTE</td><td style='color:#000000; font-weight:bold;background-color:#0066FF''>NO COMPROBANTE</td><td style='color:#000000; font-weight:bold;background-color:#0066FF''>CC</td><td style='color:#000000; font-weight:bold;background-color:#0066FF''>CUENTA</td><td style='color:#000000; font-weight:bold;background-color:#0066FF''>NOMBRE CUENTA</td><td style='color:#000000; font-weight:bold;background-color:#0066FF''>TERCERO</td><td style='color:#000000; font-weight:bold;background-color:#0066FF''>NOMBRE TERCERO</td><td style='color:#000000; font-weight:bold;background-color:#0066FF''>DETALLE</td><td style='color:#000000; font-weight:bold;background-color:#0066FF''>SALDO ANTERIOR</td><td style='color:#000000; font-weight:bold;background-color:#0066FF''>DEBITOS</td><td style='color:#000000; font-weight:bold;background-color:#0066FF''>CREDITOS</td><td style='color:#000000; font-weight:bold;background-color:#0066FF''>SALDO FINAL</td></tr>";  
  $ft="<tr><td > %s </td><td>%s</td><td >%s</td><td >%s</td><td >%s</td><td >%s</td><td>%s</td><td >%s</td><td >%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>";
  $ftn="<tr><td style='font-weight:bold'> %s </td><td style='font-weight:bold'>%s</td><td style='font-weight:bold'>%s</td><td style='font-weight:bold'>%s</td><td style='font-weight:bold'>%s</td><td style='font-weight:bold'>%s</td><td style='font-weight:bold'>%s</td><td style='font-weight:bold'>%s</td><td style='font-weight:bold'>%s</td></tr>";

for($x=0;$x<count($_POST[tipocomps]);$x++)
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
	printf($ft,''.$_POST[fechas][$x],$_POST[tipocomps][$x],$_POST[ncomps][$x],$_POST[ccs][$x],$_POST[cuentas][$x],$_POST[ncuentas][$x],$_POST[terceros][$x],$_POST[nterceros][$x],$_POST[detalles][$x],number_format(round($_POST[saldanteriores][$x],2),2,',','.'),number_format(round($_POST[debitos][$x],2),2,',','.'),number_format(round($_POST[creditos][$x],2),2,',','.'),number_format(round($_POST[nuevosaldos][$x],2),2,',','.'));	
 }

?>


	