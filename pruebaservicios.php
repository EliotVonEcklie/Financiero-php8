<?php //V 1000 12/12/16 ?> 
<?php
require "comun.inc";
$linkbd=conectar_bd();
$ncon=1;
$sqlr="select codigo,terceroactual from servclientes where (terceroactual like '12345' or terceroactual='0')";
$resp=mysql_query($sqlr,$linkbd);
 while($row=mysql_fetch_row($resp))
 {
  //$sqlr="select consecutivo,cedulanit from  terceros_servicios where consecutivo=$row[0] ";
  $sqlr="update  servclientes set terceroactual=$ncon where codigo=$row[0] ";
  $resp2=mysql_query($sqlr,$linkbd);
  //while($row2=mysql_fetch_row($resp2))
  //{
   //echo "<br>Nuevo:$ncon  concodigo:".$row2[0]."-".$row[0]."  cedula:".$row2[1]."-".$row[1];   
  //}
$ncon+=1;
 }	
?>
