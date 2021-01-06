<?php //V 1000 12/12/16 ?> 
<?php
require"comun.inc";
$linkbd=conectar_bd();
$sqlr="select *from pptorp, pptocdp_detalle where pptorp.idcdp=pptocdp_detalle.consvigencia and pptocdp_detalle.vigencia='2013' order by pptorp.consvigencia";
$res=mysql_query($sqlr,$linkbd);
while($row=mysql_fetch_row($res))
  {
   $sqlr="insert into pptorp_detalle (vigencia, consvigencia, cuenta, fuente, valor, estado, saldo) values('$row[10]',$row[1],'$row[12]',$row[13],$row[14],'$row[15]',$row[16])";
   mysql_query($sqlr,$linkbd);
   echo "<br>$sqlr";
  }
?>