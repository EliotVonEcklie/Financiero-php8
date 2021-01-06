<?php //V 1000 12/12/16 ?> 
<?php
require"comun.inc";
require"funciones.inc";
	 $linkbd=conectar_bd();	
	  $sqlr="select * from tesoordenpago_det where id_orden=743";
  	  $resp=mysql_query($sqlr,$linkbd);
	  while($r=mysql_fetch_row($resp))
	   {
		$sqlr="update pptorp_detalle set saldo=saldo+$r[4] where cuenta='$r[2]' and vigencia='2014' and consvigencia=48";
		mysql_query($sqlr,$linkbd);
		echo "<br>".$sqlr;
	   }	
?>