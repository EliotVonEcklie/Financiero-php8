<?php //V 1000 12/12/16 ?> 
<?php
//echo "33333 333 $sqlr <br>";  
require "comun.inc";
require"funciones.inc";
$conectar=conectar_bd();
//$linkbd=mysql_connect("localhost","root","");
//if(!mysql_select_db("contable"))
//die("no se puede seleccionar bd");
$sqlr="select *from pptorp, pptocdp_detalle where  pptorp.consvigencia=24 and  pptorp.idcdp=23 and 23=pptocdp_detalle.consvigencia and pptocdp_detalle.vigencia='2013' order by pptorp.consvigencia";
echo "$sqlr <br>";
echo "ERROORRORORO:".mysql_error($conectar);
$res=mysql_query($sqlr,$conectar);
if($res)
 {
//echo "dddd:".mysql_error($conectar);
//while($row=mysql_fetch_row($res))
while ($row =mysql_fetch_row($res)) 
  {
//echo "cccc:".mysql_error($conectar);
   $sqlr2="insert into pptorp_detalle (vigencia, consvigencia, cuenta, fuente, valor, estado, saldo) values('$row[10]',$row[1],'$row[12]',$row[13],$row[14],'$row[15]',$row[16])";
   //mysql_query($sqlr,$linkbd);
   echo "<br>I: $sqlr2"; 
   $sqlr="u: update ptocuentaspptoinicial set saldoscdprp=saldoscdprp-$row[14] where cuenta='$row[12]' and vigencia='2013'";
   //mysql_query($sqlr,$linkbd);
   echo "<br>$sqlr"; 	
}
}
else {echo "ERROORRORORO:".mysql_error($linkbd);}  
?>