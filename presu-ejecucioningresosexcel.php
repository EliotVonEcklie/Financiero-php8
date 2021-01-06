<?php
header("content-disposition: attachment;filename=presupuestoejecucioningresos.xls");
header("Content-Type: application/vnd.ms-excel");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Expires: 0");
require('comun.inc');
require('funciones.inc');
// header("Content-Transfer-Encoding: binary");
//session_start();
   date_default_timezone_set("America/Bogota");
//*****las variables con los contenidos***********
//**********pdf*******
//$pdf=new FPDF('P','mm','Letter'); 
$sumacdp=0;
	$sumareca=0;	
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
  
	echo "<table bordercolor=#333333 border=1 >
			<tr>
				<td colspan='13' style='color:#000000; font-weight:bold;background-color:#cccccc' align='center'>$rs - $nit</td>
			</tr>
			<tr>
				<td colspan='13' style='color:#000000; font-weight:bold;background-color:#ccddee' align='center' >Ejecucion Presupuestal de INGRESOS - Periodo: $_POST[fecha] - $_POST[fecha2]</td>
			</tr>";
		if(!empty($_POST[regalias])){
			echo "
			<tr>
				<td style='color:#000000; font-weight:bold;background-color:#0066FF'>RUBRO</td>
				<td style='color:#000000; font-weight:bold;background-color:#0066FF''>CONCEPTO</td>
				<td style='color:#000000; font-weight:bold;background-color:#0066FF''>FUENTE</td>
				<td style='color:#000000; font-weight:bold;background-color:#0066FF''>DISPONIBILIDAD INICIAL</td>
				<td style='color:#000000; font-weight:bold;background-color:#0066FF''>PRESUPUESTO INICIAL</td>
				<td style='color:#000000; font-weight:bold;background-color:#0066FF''>ADICIONES</td>
				<td style='color:#000000; font-weight:bold;background-color:#0066FF''>REDUCCIONES</td>
				<td style='color:#000000; font-weight:bold;background-color:#0066FF''>PRESUPUESTO DEFINITIVO</td>
				<td style='color:#000000; font-weight:bold;background-color:#0066FF''>RECAUDO ANTERIOR</td>
				<td style='color:#000000; font-weight:bold;background-color:#0066FF''>RECAUDO DE CONSULTA</td>
				<td style='color:#000000; font-weight:bold;background-color:#0066FF''>TOTAL RECAUDO</td>
				<td style='color:#000000; font-weight:bold;background-color:#0066FF''>SALDO POR RECAUDAR</td>
				<td style='color:#000000; font-weight:bold;background-color:#0066FF''>% EN EJECUCION</td>
			</tr>";  
  $ft="		<tr>
				<td  > %s </td>
				<td  >%s</td>
				<td  >%s</td>
				<td  >%s</td>
				<td  >%s</td>
				<td  > %s </td>
				<td  >%s</td>
				<td  >%s</td>
				<td  > %s </td>
				<td  >%s</td>
				<td  >%s</td>
				<td  >%s</td>
				<td  >%s</td>
			</tr>";
//echo $sqlr;
	$ftn="	<tr>
				<td  style='font-weight:bold'> %s </td>
				<td  style='font-weight:bold'>%s</td>
				<td  style='font-weight:bold'>%s</td>
				<td  style='font-weight:bold'>%s</td>
				<td  style='font-weight:bold'>%s</td>
				<td  style='font-weight:bold'>%s</td>
				<td  style='font-weight:bold'>%s</td>
				<td  style='font-weight:bold'>%s</td>
				<td  style='font-weight:bold'>%s</td>
				<td  style='font-weight:bold'>%s</td>
				<td  style='font-weight:bold'>%s</td>
				<td  style='font-weight:bold'>%s</td>
				<td  style='font-weight:bold'>%s</td>
			</tr>";
		}else{
			echo "
			<tr>
				<td style='color:#000000; font-weight:bold;background-color:#0066FF'>RUBRO</td>
				<td style='color:#000000; font-weight:bold;background-color:#0066FF''>CONCEPTO</td>
				<td style='color:#000000; font-weight:bold;background-color:#0066FF''>FUENTE</td>
				<td style='color:#000000; font-weight:bold;background-color:#0066FF''>PRESUPUESTO INICIAL</td>
				<td style='color:#000000; font-weight:bold;background-color:#0066FF''>ADICIONES</td>
				<td style='color:#000000; font-weight:bold;background-color:#0066FF''>REDUCCIONES</td>
				<td style='color:#000000; font-weight:bold;background-color:#0066FF''>PRESUPUESTO DEFINITIVO</td>
				<td style='color:#000000; font-weight:bold;background-color:#0066FF''>RECAUDO ANTERIOR</td>
				<td style='color:#000000; font-weight:bold;background-color:#0066FF''>RECAUDO DE CONSULTA</td>
				<td style='color:#000000; font-weight:bold;background-color:#0066FF''>TOTAL RECAUDO</td>
				<td style='color:#000000; font-weight:bold;background-color:#0066FF''>SALDO POR RECAUDAR</td>
				<td style='color:#000000; font-weight:bold;background-color:#0066FF''>% EN EJECUCION</td>
			</tr>";  
  $ft="		<tr>
				<td  > %s </td>
				<td  >%s</td>
				<td  >%s</td>
				<td  >%s</td>
				<td  > %s </td>
				<td  >%s</td>
				<td  >%s</td>
				<td  > %s </td>
				<td  >%s</td>
				<td  >%s</td>
				<td  >%s</td>
				<td  >%s</td>
			</tr>";
//echo $sqlr;
	$ftn="	<tr>
				<td  style='font-weight:bold'> %s </td>
				<td  style='font-weight:bold'>%s</td>
				<td  style='font-weight:bold'>%s</td>
				<td  style='font-weight:bold'>%s</td>
				<td  style='font-weight:bold'>%s</td>
				<td  style='font-weight:bold'>%s</td>
				<td  style='font-weight:bold'>%s</td>
				<td  style='font-weight:bold'>%s</td>
				<td  style='font-weight:bold'>%s</td>
				<td  style='font-weight:bold'>%s</td>
				<td  style='font-weight:bold'>%s</td>
				<td  style='font-weight:bold'>%s</td>
			</tr>";
		}
  	
//echo $sqlr;
//$res=mysql_query($sqlr,$linkbd);
for($x=0;$x<count($_POST[codcuenta]);$x++)
 {		 	
	$sumapcr+=$pcr;
	$sumapccr+=$pccr;
	$sumapred+=$pred;
	$sumapad+=$pad;
	$sumapsv+=$psv;
	$sumapi+=$pi;
	$sumai+=$pdef;
	$sumacdp+=$row5[1];
	$sumarp+=$row2[1];
	$sumaop+=$row3[1];
	$sumap+=$row4[1];

	if(!empty($_POST[regalias])){
		if($_POST[tcodcuenta][$x]=='Auxiliar' || $_POST[tcodcuenta][$x]=='auxiliar')	 
	printf($ft,$_POST[codcuenta][$x],strtoupper($_POST[nomcuenta][$x]),$_POST[fuente][$x],str_replace($_SESSION["spdecimal"],$_SESSION["spmillares"],$_POST[pdcuenta][$x]),str_replace($_SESSION["spdecimal"],$_SESSION["spmillares"],$_POST[picuenta][$x]),str_replace($_SESSION["spdecimal"],$_SESSION["spmillares"],$_POST[padcuenta][$x]),str_replace($_SESSION["spdecimal"],$_SESSION["spmillares"],$_POST[predcuenta][$x]),str_replace($_SESSION["spdecimal"],$_SESSION["spmillares"],$_POST[pdefcuenta][$x]),str_replace($_SESSION["spdecimal"],$_SESSION["spmillares"],$_POST[vantcuenta][$x]),str_replace($_SESSION["spdecimal"],$_SESSION["spmillares"],$_POST[vmescuenta][$x]),str_replace($_SESSION["spdecimal"],$_SESSION["spmillares"],$_POST[vtotcuenta][$x]),str_replace($_SESSION["spdecimal"],$_SESSION["spmillares"],$_POST[vsalcuenta][$x]),str_replace($_SESSION["spdecimal"],$_SESSION["spmillares"],$_POST[vporcuenta][$x]));
	else
	printf($ftn,$_POST[codcuenta][$x],strtoupper($_POST[nomcuenta][$x]),$_POST[fuente][$x],str_replace($_SESSION["spdecimal"],$_SESSION["spmillares"],$_POST[pdcuenta][$x]),str_replace($_SESSION["spdecimal"],$_SESSION["spmillares"],$_POST[picuenta][$x]),str_replace($_SESSION["spdecimal"],$_SESSION["spmillares"],$_POST[padcuenta][$x]),str_replace($_SESSION["spdecimal"],$_SESSION["spmillares"],$_POST[predcuenta][$x]),str_replace($_SESSION["spdecimal"],$_SESSION["spmillares"],$_POST[pdefcuenta][$x]),str_replace($_SESSION["spdecimal"],$_SESSION["spmillares"],$_POST[vantcuenta][$x]),str_replace($_SESSION["spdecimal"],$_SESSION["spmillares"],$_POST[vmescuenta][$x]),str_replace($_SESSION["spdecimal"],$_SESSION["spmillares"],$_POST[vtotcuenta][$x]),str_replace($_SESSION["spdecimal"],$_SESSION["spmillares"],$_POST[vsalcuenta][$x]),str_replace($_SESSION["spdecimal"],$_SESSION["spmillares"],$_POST[vporcuenta][$x]));
	}else{
		if($_POST[tcodcuenta][$x]=='Auxiliar' || $_POST[tcodcuenta][$x]=='auxiliar')	 
	printf($ft,$_POST[codcuenta][$x],strtoupper($_POST[nomcuenta][$x]),$_POST[fuente][$x],str_replace($_SESSION["spdecimal"],$_SESSION["spmillares"],$_POST[picuenta][$x]),str_replace($_SESSION["spdecimal"],$_SESSION["spmillares"],$_POST[padcuenta][$x]),str_replace($_SESSION["spdecimal"],$_SESSION["spmillares"],$_POST[predcuenta][$x]),str_replace($_SESSION["spdecimal"],$_SESSION["spmillares"],$_POST[pdefcuenta][$x]),str_replace($_SESSION["spdecimal"],$_SESSION["spmillares"],$_POST[vantcuenta][$x]),str_replace($_SESSION["spdecimal"],$_SESSION["spmillares"],$_POST[vmescuenta][$x]),str_replace($_SESSION["spdecimal"],$_SESSION["spmillares"],$_POST[vtotcuenta][$x]),str_replace($_SESSION["spdecimal"],$_SESSION["spmillares"],$_POST[vsalcuenta][$x]),str_replace($_SESSION["spdecimal"],$_SESSION["spmillares"],$_POST[vporcuenta][$x]));
	else
	printf($ftn,$_POST[codcuenta][$x],strtoupper($_POST[nomcuenta][$x]),$_POST[fuente][$x],str_replace($_SESSION["spdecimal"],$_SESSION["spmillares"],$_POST[picuenta][$x]),str_replace($_SESSION["spdecimal"],$_SESSION["spmillares"],$_POST[padcuenta][$x]),str_replace($_SESSION["spdecimal"],$_SESSION["spmillares"],$_POST[predcuenta][$x]),str_replace($_SESSION["spdecimal"],$_SESSION["spmillares"],$_POST[pdefcuenta][$x]),str_replace($_SESSION["spdecimal"],$_SESSION["spmillares"],$_POST[vantcuenta][$x]),str_replace($_SESSION["spdecimal"],$_SESSION["spmillares"],$_POST[vmescuenta][$x]),str_replace($_SESSION["spdecimal"],$_SESSION["spmillares"],$_POST[vtotcuenta][$x]),str_replace($_SESSION["spdecimal"],$_SESSION["spmillares"],$_POST[vsalcuenta][$x]),str_replace($_SESSION["spdecimal"],$_SESSION["spmillares"],$_POST[vporcuenta][$x]));
	}
	
 }
?> 
