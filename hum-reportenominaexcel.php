<?php //V 1000 12/12/16 ?> 
<?php
header("content-disposition: attachment;filename=nominaliquidacion.xls");
header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
require('comun.inc');
//session_start();
   date_default_timezone_set("America/Bogota");
 echo "<table bordercolor=#333333 border=1 ><tr><td colspan='15' style='color:#000000; font-weight:bold;' align='center' >NOMINA</td></tr>";
 echo "<tr>
 		<td style='color:#000000; font-weight:bold;'>No</td>
  		<td style='color:#000000; font-weight:bold;'>EMPLEADO</td>
  		<td style='color:#000000; font-weight:bold;'>SALARIO BASICO</td>
  		<td style='color:#000000; font-weight:bold;'>DIAS</td>
  		<td style='color:#000000; font-weight:bold;'>DEVENGADO</td>
  		<td style='color:#000000; font-weight:bold;'>AUX ALIM</td>
  		<td style='color:#000000; font-weight:bold;'>AUX TRANS</td>
		<td style='color:#000000; font-weight:bold;'>HORAS EXTRAS</td>
		<td style='color:#000000; font-weight:bold;'>TOTAL DEVENGADO</td>
		<td style='color:#000000; font-weight:bold;'>IBC</td>
		<td style='color:#000000; font-weight:bold;'>SALUD</td>
		<td style='color:#000000; font-weight:bold;'>PENSION</td>
		<td style='color:#000000; font-weight:bold;'>FONDO SOLID</td>
		<td style='color:#000000; font-weight:bold;'>RETEFTE</td>
		<td style='color:#000000; font-weight:bold;'>OTRAS DEDUC</td>
  		<td style='color:#000000; font-weight:bold;'>TOTAL RETE</td>
  		<td style='color:#000000; font-weight:bold;'>NETO PAGAR</td></tr>";  
  $ft="<tr><td >%s</td><td >%s</td><td>%s</td><td >%s</td><td >%s</td><td>%s</td><td >%s</td><td >%s</td><td>%s</td><td >%s</td><td >%s</td><td>%s</td><td >%s</td><td >%s</td><td >%s</td><td >%s</td><td >%s</td><td >%s</td><td >%s</td><td >%s</td><td >%s</td></tr>";
	 for ($x=0;$x<count($_POST[cont]);$x++) 
	 {
		 printf($ft,$x+1,$_POST[cont],$_POST[empleados],$_POST[dias],$_POST[basico],$_POST[auxali],$_POST[auxtrans],$_POST[horas_ex],$_POST[totaldev],$_POST[ibc],$_POST[salud],$_POST[pension],$_POST[fsoli], $_POST[retefuen], $_POST[otrasded], $_POST[totaldev], $_POST[netopag]);
	 }
	printf($ft,'',"TOTALES",'','',$_POST[totaldevini],$_POST[totalauxalim],$_POST[totalauxtra],$_POST[totalhorex],$_POST[totaldevtot],$_POST[totalsalud],$_POST[totalpension],$_POST[totalfondosolida],0,$_POST[totalotrasreducciones],$_POST[totaldeductot],$_POST[totalnetopago]); 
echo "<tr></tr>";	 
echo "<tr><td style='color:#000000; font-weight:bold;'>Codigo</td><td style='color:#000000; font-weight:bold;'>Aportes Parafiscales</td><td style='color:#000000; font-weight:bold;'>Porcentaje</td><td style='color:#000000; font-weight:bold;'>Valor</td></tr>";
 $ft="<tr><td >%s</td><td >%s</td><td >%s</td><td >%s</td></tr>";
for($x=0;$x<count($_POST[codpara]);$x++)
 {
	printf($ft,$_POST[codpara][$x],$_POST[codnpara][$x],$_POST[porpara][$x],$_POST[valpara][$x]); 	 
 }
 //****rubro pptal
 echo "<tr></tr>";	 
echo "<tr><td style='color:#000000; font-weight:bold;'>RUBRO</td><td style='color:#000000; font-weight:bold;'>NOMBRE RUBRO</td><td style='color:#000000; font-weight:bold;'>Valor</td></tr>";
 $ft="<tr><td >%s</td><td >%s</td><td >%s</td></tr>";
for($x=0;$x<count($_POST[rubrosp]);$x++)
 {
	printf($ft,$_POST[rubrosp][$x],$_POST[nrubrosp][$x],$_POST[vrubrosp][$x]); 	 
 }
?>