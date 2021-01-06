<?php
	header("content-disposition: attachment;filename=presupuestoauxiliarcuentasingresos.xls");
	header("Content-Type: application/vnd.ms-excel");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	require('comun.inc');
	require('funciones.inc');
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
//echo $sqlr;
$res=mysql_query($sqlr,$linkbd);
while($row=mysql_fetch_row($res))
 {
  $nit=$row[0];
  $rs=$row[1];
 }

   echo "<table bordercolor=#333333 border=1 >
   			<tr>
   				<td colspan='8' style='color:#000000; font-weight:bold;background-color:#cccccc' align='center'>$rs - $nit</td>
   			</tr>
   			<tr>
   				<td colspan='8' style='color:#000000; font-weight:bold;background-color:#ccddee' align='center' >MOVIMIENTOS CONTABLES - Periodo: $_POST[fecha] - $_POST[fecha2] <b> <span style='padding-left:10%' >$_POST[cuenta] - $_POST[ncuenta]</span></b></td>
   			</tr>";
  echo "<tr>
			<td style='color:#000000; font-weight:bold;background-color:#0066FF''>TIPO COMPROBANTE</td>
			<td style='color:#000000; font-weight:bold;background-color:#0066FF''>NO COMPROBANTE</td>
			<td style='color:#000000; font-weight:bold;background-color:#0066FF''>FECHA</td>
			<td style='color:#000000; font-weight:bold;background-color:#0066FF''>DETALLE</td>
	  		<td style='color:#000000; font-weight:bold;background-color:#0066FF''>TIPO MOV</td>
	  		<td style='color:#000000; font-weight:bold;background-color:#0066FF''>ENTRADA</td>
	  		<td style='color:#000000; font-weight:bold;background-color:#0066FF''>SALIDA</td>
	  		<td style='color:#000000; font-weight:bold;background-color:#0066FF''>SALDO</td>
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
	 
  		</tr>";
  $ftn="<tr><td style='font-weight:bold'> %s </td><td style='font-weight:bold'>%s</td><td style='font-weight:bold'>%s</td></tr>";
//echo $sqlr;
//$res=mysql_query($sqlr,$linkbd);
for($x=0;$x<count($_POST[tipocomp]);$x++)
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
	printf($ft,''.$_POST[tipocomp][$x],$_POST[numcomp][$x],$_POST[fecha1][$x],$_POST[detalle][$x],$_POST[tipomov][$x],number_format(round($_POST[entrada][$x],2),2,',','.'),number_format(round($_POST[salida][$x],2),2,',','.'),number_format(round($_POST[saldo][$x],2),2,',','.'));	
 }

?> 


	