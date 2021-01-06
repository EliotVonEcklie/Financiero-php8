<?php 
 header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=pagotercerosdetallado.xls");
require('comun.inc');

//session_start();
   date_default_timezone_set("America/Bogota");
//*****las variables con los contenidos***********
//**********pdf*******
//$pdf=new FPDF('P','mm','Letter'); 
 $_POST[tsaldoant]=0;
	 $_POST[tdebito]=0;
	 $_POST[tcredito]=0;
	 $_POST[tsaldofinal]=0;
	 $co='saludo1';
	 $co2='saludo2';
	 
	  echo "<table bordercolor=#333333 border=1 ><tr><td colspan='5' style='color:#000000; font-weight:bold;' align='center' >RETENCIONES E INGRESOS PARA TERCEROS</td></tr>";
	if(substr($_POST[ddescuentos][0],0,1)!='I')
	{ 
		echo "<tr><td style='color:#000000; font-weight:bold;' >NOMBRE</td><td style='color:#000000; font-weight:bold;'>BANCO</td><td style='color:#000000; font-weight:bold;'>CUENTA BANCARIA</td><td style='color:#000000; font-weight:bold;'>CONTABILIDAD</td><td style='color:#000000; font-weight:bold;'>VALOR</td></tr>";  
	}
	else
	{
		echo "<tr><td style='color:#000000; font-weight:bold;' >NOMBRE</td><td style='color:#000000; font-weight:bold;'>Recibo Caja</td><td style='color:#000000; font-weight:bold;'>Liquidacion</td><td style='color:#000000; font-weight:bold;'>BASE</td><td style='color:#000000; font-weight:bold;'>VALOR</td></tr>";  
	}
  $ft="<tr><td >%s</td><td>%s</td><td >%s</td><td >%s</td><td>%s</td></tr>";
  for ($x=0;$x<count($_POST[mddescuentos]);$x++)
  {
/*$row[3]=str_replace(".",",",round($row[3],2));
$row[4]=str_replace(".",",",round($row[4],2));
$row[5]=str_replace(".",",",round($row[5],2));
$row[6]=str_replace(".",",",round($row[6],2));*/
	if(substr($_POST[ddescuentos][$x],0,1)!='I')
	{
		printf($ft,$_POST[mdndescuentos][$x],$_POST[mnbancos][$x],'No. '.$_POST[mctanbancos][$x],$_POST[mdctas][$x],$_POST[mddesvalores][$x]);
	}
	else
	{
		printf($ft,$_POST[mdndescuentos][$x],$_POST[mnbancos][$x],$_POST[mctanbancos][$x],$_POST[mdctas][$x],$_POST[mddesvalores][$x]);
	}
	 $_POST[tsaldoant]+=$row[3];
	 $_POST[tdebito]+=$row[4];
	 $_POST[tcredito]+=$row[5];
	  $aux=$co;
         $co=$co2;
         $co2=$aux;
		 $i=1+$i;
  }
  $_POST[tsaldofinal]= $_POST[tdebito]-$_POST[tcredito];
 // echo "<tr class='$co'><td colspan='2'></td><td class='$co'>".number_format($_POST[tsaldoant],2,".",",")."<input type='hidden' name='tsaldoant' value= '$_POST[tsaldoant]'></td><td class='$co'>".number_format($_POST[tdebito],2,".",",")."<input type='hidden' name='tdebito' value= '$_POST[tdebito]'></td><td class='$co'>".number_format($_POST[tcredito],2,".",",")."<input type='hidden' name='tcredito' value= '$_POST[tcredito]'></td><td class='$co'>".number_format($_POST[tsaldofinal],2,".",",")."<input type='hidden' name='tsaldofinal' value= '$_POST[tsaldofinal]'></td></tr>";  
?> 