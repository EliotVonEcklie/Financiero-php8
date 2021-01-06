<?php //V 1000 12/12/16 ?> 
<?php
header("content-disposition: attachment;filename=presupuestoejecuciongastos.xls");
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
 // echo "<table class='inicio' ><tr><td colspan='12' class='titulos'>Ejecucion Cuentas $_POST[fecha] - $_POST[fecha2]</td></tr>";
	 //$nc=buscacuentap($_POST[cuenta]);
$linkbd=conectar_bd();
$sqlr="select *from configbasica where estado='S'";
//echo $sqlr;
$res=mysql_query($sqlr,$linkbd);
while($row=mysql_fetch_row($res))
 {
  $nit=$row[0];
  $rs=$row[1];
 }
//$sqlr="Select distinct cuenta from pptocuentaspptoinicial where left(cuenta,1)>='2' and vigencia='".$_POST[vigencias]."'"; 	 	 
 // echo "<tr><td class='titulos2'>Cuenta</td><td class='titulos2'>Nombre</td><td class='titulos2'>PRES INI</td><td class='titulos2'>ADICION</td><td class='titulos2'>REDUCC</td><td class='titulos2'>CREDITO</td><td class='titulos2'>CONT CRED</td><td class='titulos2'>PRES DEF</td><td class='titulos2'>CDP</td><td class='titulos2'>RP</td><td class='titulos2' >ORDEN PAGO</td><td class='titulos2' >PAGOS</td></tr>";  
   echo "<table bordercolor=#333333 border=1 ><tr><td colspan='15' style='color:#000000; font-weight:bold;background-color:#cccccc' align='center'>$rs - $nit</td></tr><tr><td colspan='15' style='color:#000000; font-weight:bold;background-color:#ccddee' align='center' >Ejecucion Presupuestal de Gastos - Periodo: $_POST[fecha] - $_POST[fecha2]</td></tr>";
  echo "<tr><td style='color:#000000; font-weight:bold;background-color:#0066FF'>RUBRO</td><td style='color:#000000; font-weight:bold;background-color:#0066FF''>CONCEPTO</td><td style='color:#000000; font-weight:bold;background-color:#0066FF''>FUENTE</td><td style='color:#000000; font-weight:bold;background-color:#0066FF''>PRESUPUESTO INICIAL</td><td style='color:#000000; font-weight:bold;background-color:#0066FF''>ADICIONES</td><td style='color:#000000; font-weight:bold;background-color:#0066FF''>REDUCCIONES</td><td style='color:#000000; font-weight:bold;background-color:#0066FF''>CREDITOS</td><td style='color:#000000; font-weight:bold;background-color:#0066FF''>CONTRACREDITOS</td><td style='color:#000000; font-weight:bold;background-color:#0066FF''>PRESUPUESTO DEFINITIVO</td><td style='color:#000000; font-weight:bold;background-color:#0066FF''>CDP</td><td style='color:#000000; font-weight:bold;background-color:#0066FF''>COMPROMISOS</td><td style='color:#000000; font-weight:bold;background-color:#0066FF''>OBLIGACIONES</td><td style='color:#000000; font-weight:bold;background-color:#0066FF''>COMPROMISOS EN EJECUCION</td><td style='color:#000000; font-weight:bold;background-color:#0066FF''>PAGOS</td><td style='color:#000000; font-weight:bold;background-color:#0066FF''>CUENTAS POR PAGAR</td><td style='color:#000000; font-weight:bold;background-color:#0066FF''>SALDO</td></tr>";  
  $ft="<tr><td > %s </td><td>%s</td><td >%s</td><td >%s</td><td >%s</td><td>%s</td><td >%s</td><td >%s</td><td >%s</td><td >%s</td><td>%s</td><td >%s</td><td >%s</td><td>%s</td><td >%s</td><td >%s</td></tr>";
  $ftn="<tr><td style='font-weight:bold'> %s </td><td style='font-weight:bold'>%s</td><td style='font-weight:bold'>%s</td><td style='font-weight:bold'>%s</td><td style='font-weight:bold'>%s</td><td style='font-weight:bold'>%s</td><td style='font-weight:bold'>%s</td><td style='font-weight:bold'>%s</td><td style='font-weight:bold'>%s</td><td style='font-weight:bold'>%s</td><td style='font-weight:bold'>%s</td><td style='font-weight:bold'>%s</td><td style='font-weight:bold'>%s</td><td style='font-weight:bold'>%s</td><td style='font-weight:bold'>%s</td><td style='font-weight:bold'>%s</td></tr>";
//echo $sqlr;
//$res=mysql_query($sqlr,$linkbd);
for($x=0;$x<count($_POST[codcuenta]);$x++)
 {		 		
	$compeje=$_POST[rpcuenta][$x]-$_POST[opcuenta][$x];
	$cxxp=$_POST[opcuenta][$x]-$_POST[pgcuenta][$x];
	if($_POST[tcodcuenta][$x]=='1')	 
	{
	$sumapcr+=$_POST[pcrcuenta][$x];
	$sumapccr+=$_POST[pccrcuenta][$x];
	$sumapred+=$_POST[predcuenta][$x];
	$sumapad+=$_POST[padcuenta][$x];
	$sumapi+=$_POST[picuenta][$x];
	$sumai+=$_POST[pdefcuenta][$x]; 
	$sumacdp+=$_POST[cdpcuenta][$x];
	$sumarp+=$_POST[rpcuenta][$x];
	$sumaop+=$_POST[opcuenta][$x];
	$sumap+=$_POST[pgcuenta][$x];
	$compeje=$_POST[rpcuenta][$x]-$_POST[opcuenta][$x];
	$cxxp=$_POST[opcuenta][$x]-$_POST[pgcuenta][$x];
	printf($ft,'CG:'.$_POST[codcuenta][$x],$_POST[nomcuenta][$x],$_POST[nomfuente][$x],$_POST[picuenta][$x],$_POST[padcuenta][$x],$_POST[predcuenta][$x],$_POST[pcrcuenta][$x],$_POST[pccrcuenta][$x],$_POST[pdefcuenta][$x],$_POST[cdpcuenta][$x],$_POST[rpcuenta][$x],$_POST[opcuenta][$x], $compeje,$_POST[pgcuenta][$x], $cxxp,$_POST[saldocuenta][$x]);
	}
	else
	{
	/*$sumapcr+=$_POST[pcrcuenta][$x];
	$sumapccr+=$_POST[pccrcuenta][$x];
	$sumapred+=$_POST[predcuenta][$x];
	$sumapad+=$_POST[padcuenta][$x];
	$sumapi+=$_POST[picuenta][$x];
	$sumai+=$_POST[pdefcuenta][$x];
	$sumacdp+=$_POST[cdpcuenta][$x];
	$sumarp+=$_POST[rpcuenta][$x];
	$sumaop+=$_POST[opcuenta][$x];
	$sumap+=$_POST[pgcuenta][$x];
	$compeje=$_POST[rpcuenta][$x]-$_POST[opcuenta][$x];
	$cxxp=$_POST[opcuenta][$x]-$_POST[pgcuenta][$x];*/
	printf($ftn,'CG:'.$_POST[codcuenta][$x],strtoupper($_POST[nomcuenta][$x]),strtoupper($_POST[nomfuente][$x]),$_POST[picuenta][$x],$_POST[padcuenta][$x],$_POST[predcuenta][$x],$_POST[pcrcuenta][$x],$_POST[pccrcuenta][$x],$_POST[pdefcuenta][$x],$_POST[cdpcuenta][$x],$_POST[rpcuenta][$x],$_POST[opcuenta][$x], $compeje,$_POST[pgcuenta][$x], $cxxp, $_POST[saldocuenta][$x]);
	}
 }
printf($ftn,'','TOTALES',number_format($sumapi,2,",",""),number_format($sumapad,2,",",""),number_format($sumapred,2,",",""),number_format($sumapcr,2,",",""),number_format($sumapccr,2,",",""),number_format($sumai,2,",",""),number_format($sumacdp,2,",",""),number_format($sumarp,2,",",""),number_format($sumaop,2,",",""),number_format($compeje,2,",",""),number_format($sumap,2,",",""),number_format($cxxp,2,",",""),'');
// echo "<tr><td ></td><td  align='right'>Totales:</td><td class='saludo3' align='right'>$".number_format($sumapi,2)."</td><td class='saludo3' align='right'>$".number_format($sumapad,2)."</td><td class='saludo3' align='right'>$".number_format($sumared,2)."</td><td class='saludo3' align='right'>$".number_format($sumapcr,2)."</td><td class='saludo3' align='right'>$".number_format($sumapccr,2)."</td><td class='saludo3' align='right'>$".number_format($sumai,2)."</td><td class='saludo3' align='right'>$".number_format($sumacdp,2)."</td><td class='saludo3' align='right'>$".number_format($sumarp,2)."</td><td class='saludo3' align='right'>$".number_format($sumaop,2)."</td><td class='saludo3'  align='right'>$".number_format($sumap,2)."</td></tr>";
?> 


	