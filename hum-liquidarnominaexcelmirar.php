<?php
header("content-disposition: attachment;filename=nominaliquidacion.xls");
 header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
require('comun.inc');
//session_start();
   date_default_timezone_set("America/Bogota");
 echo "<table bordercolor=#333333 border=1 >
 			<tr>
 				<td colspan='17' style='color:#000000; font-weight:bold;' align='center' >NOMINA</td>
 			</tr>";
  echo "<tr>
  			<td style='color:#000000; font-weight:bold;' >Id</td>
  			<td style='color:#000000; font-weight:bold;' >SECTOR</td>
  			<td style='color:#000000; font-weight:bold;'>EMPLEADO</td>
  			<td style='color:#000000; font-weight:bold;'>Doc Id</td>
  			<td style='color:#000000; font-weight:bold;'>SAL BAS</td>
  			<td style='color:#000000; font-weight:bold;'>DIAS LIQ</td>
  			<td style='color:#000000; font-weight:bold;'>Dias Novedad</td>
  			<td style='color:#000000; font-weight:bold;'>DEVENGADO</td>
  			<td style='color:#000000; font-weight:bold;'>AUX ALIM</td>
  			<td style='color:#000000; font-weight:bold;'>AUX TRAN</td>
  			<td style='color:#000000; font-weight:bold;'>HORAS EXTRAS</td>
  			<td style='color:#000000; font-weight:bold;'>TOT DEV</td>
  			<td style='color:#000000; font-weight:bold;'>SALUD</td>
  			<td style='color:#000000; font-weight:bold;'>PENSION</td>
  			<td style='color:#000000; font-weight:bold;'>F SOLIDA</td>
  			<td style='color:#000000; font-weight:bold;'>RETE FTE</td>
  			<td style='color:#000000; font-weight:bold;'>OTRAS DEDUC</td>
  			<td style='color:#000000; font-weight:bold;'>TOT DEDUC</td>
  			<td style='color:#000000; font-weight:bold;'>NETO PAG</td>
  		</tr>";  

  $ft="<tr>
	  		<td>%s</td>
	  		<td>%s</td>
	  		<td>%s</td>
	  		<td>%s</td>
	  		<td>%s</td>
	  		<td>%s</td>
	  		<td>%s</td>
	  		<td>%s</td>
	  		<td>%s</td>
	  		<td>%s</td>
	  		<td>%s</td>
	  		<td>%s</td>
	  		<td>%s</td>
	  		<td>%s</td>
	  		<td>%s</td>
	  		<td>%s</td>
	  		<td>%s</td>
	  		<td>%s</td>
	  		<td>%s</td>
  		</tr>";
	 for ($x=0;$x<count($_POST[salbas1]);$x++) 
	 {
		 printf($ft,$x+1,$_POST[tipopension][$x],$_POST[empleado][$x],$_POST[doc_id][$x],$_POST[salbas1][$x],$_POST[diasalbas][$x],0,$_POST[totaldevini1][$x],$_POST[totalauxalim1][$x],$_POST[totalauxtra1][$x],$_POST[totalhorex1][$x],$_POST[totaldevtot1][$x],$_POST[totalsalud1][$x],$_POST[totalpension1][$x],$_POST[totalfondosolida1][$x],$_POST[totalretef1][$x],$_POST[totalotrasreducciones1][$x],$_POST[totaldeductot1][$x],$_POST[totalnetopago1][$x]);
	 }
	$linkbd=conectar_bd();
	for ($x=0;$x<6;$x++) 
	 {
		$xy=$x+1;
		$sqlr="SELECT SUM(valor) FROM humnomina_parafiscales WHERE  id_parafiscal='0$xy' AND id_nom='$_POST[idcomp]'";
		$row =mysql_fetch_row(mysql_query($sqlr,$linkbd));
		$valparaf[$x]=$row[0];
	 }
	 $sqlr="SELECT SUM(saludemp),SUM(pensionemp) FROM humnomina_det WHERE id_nom='$_POST[idcomp]'";
	$row =mysql_fetch_row(mysql_query($sqlr,$linkbd));
	$valparaf[6]=$row[0];$valparaf[7]=$row[1];
	
//printf($ft,'',"TOTALES",'','','',$_POST[totaldevini],$_POST[totalauxalim],$_POST[totalauxtra],$_POST[totalhorex],$_POST[totaldevtot],$_POST[totalibc],$_POST[totalsalud],$_POST[totalpension],$_POST[totalfondosolida],0,$_POST[totalotrasreducciones],$_POST[totaldeductot],$_POST[totalnetopago	]); 
echo "<tr></tr>";	 
echo "<tr><td style='color:#000000; font-weight:bold;'>Codigo</td><td style='color:#000000; font-weight:bold;'>Aportes Parafiscales</td><td style='color:#000000; font-weight:bold;'>Porcentaje</td><td style='color:#000000; font-weight:bold;'>Valor</td></tr>";
$ft="<tr><td >%s</td><td >%s</td><td >%s</td><td >%s</td></tr>";
for($x=0;$x<count($_POST[codpara]);$x++)
 {
	printf($ft,$_POST[codpara][$x],$_POST[codnpara][$x],$_POST[porpara][$x],$valparaf[$x]); 	 
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