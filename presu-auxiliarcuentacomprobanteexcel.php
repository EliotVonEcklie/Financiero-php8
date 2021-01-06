<?php //V 1000 12/12/16 ?> 
<?php
	header("content-disposition: attachment;filename=presupuestoauxiliarcuentasingresos.xls");
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
	// echo "<table class='inicio' ><tr><td colspan='12' class='titulos'>Ejecucion Cuentas $_POST[fecha] - $_POST[fecha2]</td></tr>";
	//$nc=buscacuentap($_POST[cuenta]);
	$linkbd=conectar_bd();
	$sqlr="select * from configbasica where estado='S'";
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
					<td colspan='8' style='color:#000000; font-weight:bold;background-color:#39C' align='center' >MOVIMIENTOS CONTABLES - Periodo: $_POST[fecha] - $_POST[fecha2]</td>
				</tr>";
	echo "<tr>
			<td style='color:#000000; font-weight:bold;background-color:#9DF'>FECHA</td>
			<td style='color:#000000; font-weight:bold;background-color:#9DF'>TIPO COMPROBANTE</td>
			<td style='color:#000000; font-weight:bold;background-color:#9DF'>NO COMPROBANTE</td>
			<td style='color:#000000; font-weight:bold;background-color:#9DF'>Tipo Movimiento</td>
			<td style='color:#000000; font-weight:bold;background-color:#9DF'>Documento Receptor</td>			
			<td style='color:#000000; font-weight:bold;background-color:#9DF'>DETALLE</td>
			<td style='color:#000000; font-weight:bold;background-color:#9DF;'>DEBITO</td>
			<td style='color:#000000; font-weight:bold;background-color:#9DF;'>CREDITO</td>
		</tr>";  
	
	$ft="<tr>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td valign='middle' align='right'>%s</td>
			<td valign='middle' align='right'>%s</td>
		</tr>";
	$ftn="<tr><td style='font-weight:bold'> %s </td><td style='font-weight:bold'>%s</td><td style='font-weight:bold'>%s</td></tr>";
	//echo $sqlr;
	for($x=0;$x<count($_POST[com]);$x++)
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
		printf($ft,''.$_POST[fecrec][$x], $_POST[tiporec][$x], $_POST[com][$x], $_POST[mov][$x], $_POST[rec][$x], $_POST[detalle][$x], '$'.number_format($_POST[debito][$x],2), '$'.number_format($_POST[credito][$x],2));	
	}
	echo "<tr>
			<td colspan='6' style='color:#000000; font-weight:bold;background-color:#9DF'>TOTAL</td>
			<td style='color:#000000; font-weight:bold;background-color:#9DF;'>$".number_format($_POST[totaldebito][0],2)."</td>
			<td style='color:#000000; font-weight:bold;background-color:#9DF;'>$".number_format($_POST[totalcredito][0],2)."</td>
		</tr>";  
?>