<?php //V 1000 12/12/16 ?> 
<?php 
header("content-disposition: attachment;filename=comprobante$tipocomp.xls");
 header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
require('comun.inc');
//session_start();
   date_default_timezone_set("America/Bogota");
//*****las variables con los contenidos***********
//**********pdf*******
//$pdf=new FPDF('P','mm','Letter'); 
$linkbd=conectar_bd();
$sqlr="select *from balanceprueba order by cuenta";
 $res=mysql_query($sqlr,$linkbd);
 $_POST[tsaldoant]=0;
	 $_POST[tdebito]=0;
	 $_POST[tcredito]=0;
	 $_POST[tsaldofinal]=0;
	 $co='saludo1';
	 $co2='saludo2';
	  echo "<table bordercolor=#333333 border=1 ><tr><td colspan='6' style='color:#000000; font-weight:bold;' align='center' >Balance de Prueba</td></tr>";
  echo "<tr><td style='color:#000000; font-weight:bold;' >Codigo</td><td style='color:#000000; font-weight:bold;'>Cuenta</td><td style='color:#000000; font-weight:bold;'>Saldo Anterior</td><td style='color:#000000; font-weight:bold;'>Debito</td><td style='color:#000000; font-weight:bold;'>Credito</td><td style='color:#000000; font-weight:bold;'>Saldo Final</td></tr>";  
  $ft="<tr><td >%s</td><td>%s</td><td >%f</td><td >%f</td><td>%f</td><td >%f</td></tr>";
  while($row=mysql_fetch_row($res))
  {
/*$row[3]=str_replace(".",",",round($row[3],2));
$row[4]=str_replace(".",",",round($row[4],2));
$row[5]=str_replace(".",",",round($row[5],2));
$row[6]=str_replace(".",",",round($row[6],2));*/
 printf($ft,$row[1],$row[2],$row[3],$row[4],$row[5],$row[6]);
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