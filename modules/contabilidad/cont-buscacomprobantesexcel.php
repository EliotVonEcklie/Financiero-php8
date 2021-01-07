<?php 
header("content-disposition: attachment;filename=contabilidadcomprobantes.xls");
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
	$fechaf=date('d-m-Y',strtotime($_POST[fecha]));
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
   echo "<table bordercolor=#333333 border=1 ><tr><td colspan='11' style='color:#000000; font-weight:bold;background-color:#cccccc' align='center'>$rs - $nit</td></tr><tr><td colspan='11' style='color:#000000; font-weight:bold;background-color:#ccddee' align='center' >MOVIMIENTOS CONTABLES - Periodo: $fechaf - $_POST[fecha2]</td></tr>";
  echo "<tr><td style='color:#000000; font-weight:bold;background-color:#0066FF'>FECHA</td><td style='color:#000000; font-weight:bold;background-color:#0066FF''>TIPO COMPROBANTE</td><td style='color:#000000; font-weight:bold;background-color:#0066FF''>NO COMPROBANTE</td><td style='color:#000000; font-weight:bold;background-color:#0066FF''>CC</td><td style='color:#000000; font-weight:bold;background-color:#0066FF''>CUENTA</td><td style='color:#000000; font-weight:bold;background-color:#0066FF''>NOMBRE CUENTA</td><td style='color:#000000; font-weight:bold;background-color:#0066FF''>TERCERO</td><td style='color:#000000; font-weight:bold;background-color:#0066FF''>NOMBRE TERCERO</td><td style='color:#000000; font-weight:bold;background-color:#0066FF''>DETALLE</td><td style='color:#000000; font-weight:bold;background-color:#0066FF''>DEBITOS</td><td style='color:#000000; font-weight:bold;background-color:#0066FF''>CREDITOS</td></tr>";  
  $ft="<tr><td > %s </td><td>%s</td><td >%s</td><td >%s</td><td >%s</td><td >%s</td><td>%s</td><td >%s</td><td >%s</td><td>%s</td><td>%s</td></tr>";
  $ftn="<tr><td style='font-weight:bold'> %s </td><td style='font-weight:bold'>%s</td><td style='font-weight:bold'>%s</td><td style='font-weight:bold'>%s</td><td style='font-weight:bold'>%s</td><td style='font-weight:bold'>%s</td><td style='font-weight:bold'>%s</td><td style='font-weight:bold'>%s</td><td style='font-weight:bold'>%s</td></tr>";
//echo $sqlr;
//$res=mysql_query($sqlr,$linkbd);
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
	printf($ft,''.$_POST[fecha],$_POST[ntipocomp],$_POST[ncomp],$_POST[dccs][$x],$_POST[dcuentas][$x],$_POST[dncuentas][$x],$_POST[dterceros][$x],$_POST[dnterceros][$x],$_POST[ddetalles][$x],$_POST[ddebitos][$x],$_POST[dcreditos][$x]);	
 }
//printf($ft,'','TOTALES',$sumapi,$sumapad,$sumapred,$sumapcr,$sumapccr,$sumai,$sumacdp,$sumarp,$sumaop,$sumap); 
// echo "<tr><td ></td><td  align='right'>Totales:</td><td class='saludo3' align='right'>$".number_format($sumapi,2)."</td><td class='saludo3' align='right'>$".number_format($sumapad,2)."</td><td class='saludo3' align='right'>$".number_format($sumared,2)."</td><td class='saludo3' align='right'>$".number_format($sumapcr,2)."</td><td class='saludo3' align='right'>$".number_format($sumapccr,2)."</td><td class='saludo3' align='right'>$".number_format($sumai,2)."</td><td class='saludo3' align='right'>$".number_format($sumacdp,2)."</td><td class='saludo3' align='right'>$".number_format($sumarp,2)."</td><td class='saludo3' align='right'>$".number_format($sumaop,2)."</td><td class='saludo3'  align='right'>$".number_format($sumap,2)."</td></tr>"; 
?>


	