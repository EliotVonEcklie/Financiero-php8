<?php
	header("content-disposition: attachment;filename=formato_202006_f01_agr_balancedeprueba.xls");
	header("Content-Type: application/vnd.ms-excel");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	require('comun.inc');
	require('funciones.inc');
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
	$mes1=substr($_POST[periodo],1,2);
	$mes2=substr($_POST[periodo],3,2);
	$_POST[fecha]='01'.'/'.$mes1.'/'.$_POST[vigencias];
	$_POST[fecha2]=intval(date("t",$mes2)).'/'.$mes2.'/'.$_POST[vigencias];
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
					<td colspan='6' style='color:#000000; font-weight:bold;background-color:#cccccc' align='center'>$rs - $nit</td>
				</tr>
				<tr>	
					<td colspan='6' style='color:#000000; font-weight:bold;background-color:#81F7F3' align='center'>BALANCE DE PRUEBA ANEXO INFORME CONTRALORIA DEPARTAMENTAL</td>
				</tr>
				<tr>
					<td colspan='6' style='color:#000000; font-weight:bold;background-color:#ccddee' align='center' >BALANCE DE PRUEBA Periodo: $_POST[fecha] - $_POST[fecha2]</td>
				</tr>";
				
				echo "<tr>
						<td style='color:#000000; font-weight:bold;background-color:#0066FF'>CUENTA</td>
						<td style='color:#000000; font-weight:bold;background-color:#0066FF''>NOMBRE CUENTA</td>
						<td style='color:#000000; font-weight:bold;background-color:#0066FF''>SALDO INICIAL</td>
						<td style='color:#000000; font-weight:bold;background-color:#0066FF''>DEBITOS</td>
						<td style='color:#000000; font-weight:bold;background-color:#0066FF''>CREDITOS</td>
						<td style='color:#000000; font-weight:bold;background-color:#0066FF''>SALDO FINAL</td>
					</tr>";  
				$ft="<tr><td > %s </td><td>%s</td><td >%s</td><td >%s</td><td >%s</td><td>%s</td></tr>";
				$ftn="<tr><td style='font-weight:bold'> %s </td><td style='font-weight:bold'>%s</td><td style='font-weight:bold'>%s</td><td style='font-weight:bold'>%s</td><td style='font-weight:bold'>%s</td><td style='font-weight:bold'>%s</td><td style='font-weight:bold'>%s</td><td style='font-weight:bold'>%s</td></tr>";
	for($x=0;$x<count($_POST[dcuentas]);$x++)
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
		printf($ft,''.$_POST[dcuentas][$x],$_POST[dncuentas][$x],$_POST[dsaldoant][$x],$_POST[ddebitos][$x],$_POST[dcreditos][$x],$_POST[dsaldo][$x]);	
	}
?>


	