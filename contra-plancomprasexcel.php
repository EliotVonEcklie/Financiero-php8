<?php //V 1000 12/12/16 ?> 
<?php 
header("content-disposition: attachment;filename=plancompras.xls");
header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
require('comun.inc');
require('funciones.inc');
//session_start();
   date_default_timezone_set("America/Bogota");
//*****las variables con los contenidos***********
//**********pdf*******
$linkbd=conectar_bd();
$sqlr="select *from configbasica where estado='S'";
$res=mysql_query($sqlr,$linkbd);
while($row=mysql_fetch_row($res))
 {
  $nit=$row[0];
  $rs=$row[1];
 }
   echo "
   <table bordercolor=#333333 border=1 >
   	<tr>
		<td colspan='9' style='color:#000000; font-weight:bold;background-color:#cccccc' align='center'>$rs - $nit</td>
	</tr>
	<tr>
		<td colspan='9' style='color:#000000; font-weight:bold;background-color:#ccddee' align='center' >REPORTE PLAN DE COMPRAS - Filtrado por: $_POST[detallefill]</td>
	</tr>";
  echo "
  	<tr>
		<td style='color:#000000; font-weight:bold;background-color:#0066FF'>VIGENCIA</td>
		<td style='color:#000000; font-weight:bold;background-color:#0066FF'>CODIGOS UNSPSC</td>
		<td style='color:#000000; font-weight:bold;background-color:#0066FF''>DESCRIPCION</td>
		<td style='color:#000000; font-weight:bold;background-color:#0066FF''>FECHA ESTIMADA</td>
		<td style='color:#000000; font-weight:bold;background-color:#0066FF''>DURACION ESTIMADA</td>
		<td style='color:#000000; font-weight:bold;background-color:#0066FF''>MODALIDAD SELECCION</td>
		<td style='color:#000000; font-weight:bold;background-color:#0066FF''>FUENTE</td>
		<td style='color:#000000; font-weight:bold;background-color:#0066FF''>VLR ESTIMADO</td>
		<td style='color:#000000; font-weight:bold;background-color:#0066FF''>VLR ESTIMADO VIG ACTUAL</td>
	</tr>";  
  $ftn="<tr>
  <td style=\"font-weight:bold; mso-number-format:'@';\"> %s </td>
  <td style=\"font-weight:bold\"> %s </td>
  <td style='font-weight:bold'>%s</td>
  <td style=\"font-weight:bold; mso-number-format:'dd-mm-yyyy';\">%s</td>
  <td style='font-weight:bold'>%s</td>
  <td style='font-weight:bold'>%s</td>
  <td style=\"font-weight:bold;\">%s</td>
  <td style=\"font-weight:bold; mso-number-format:'\$#,##0;' \">%s</td>
  <td style=\"font-weight:bold; mso-number-format:'\$#,##0;' \">%s </td></tr>";
  $sumatoria=0;
  $sumatori2=0;
for($x=0;$x<count($_POST[adqdescripcion]);$x++)
 {		 	
		
	printf($ftn,''.$_POST[vigencias][$x],$_POST[adqprodtodos2][$x],$_POST[adqdescripcion][$x],$_POST[adqfecha2][$x],$_POST[adqduracion][$x].' Meses',$_POST[adqmodalidad2][$x],$_POST[adqfuente2][$x],$_POST[adqvlrestimado][$x],'$'.$_POST[adqvlrvig][$x]);	
	$sumatoria=$sumatoria+$_POST[adqvlrestimado][$x];
	$sumatoria2=$sumatoria2+$_POST[adqvlrvig][$x];	
 }
 echo"<tr> <td colspan='7' rowspan='2'></td><td style=\"font-weight:bold; \" >Total</td><td style=\"font-weight:bold; \" >Total</td></tr><tr><td style=\"font-weight:bold; mso-number-format:'\$#,##0;' \" >$sumatoria</td><td style=\"font-weight:bold; mso-number-format:'\$#,##0;' \" >$sumatoria2</td></tr>";
?>


	