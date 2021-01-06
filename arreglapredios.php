<?php //V 1000 12/12/16 ?> 
<?php
require"comun.inc"; 
require"funciones.inc";
	 $linkbd=conectar_bd();	
	  $sqlr="select codigocatastral,avaluo from tesoprediosavaluos where vigencia='2014'";
  	  $resp=mysql_query($sqlr,$linkbd);
	  while($r=mysql_fetch_row($resp))
	   {
		$sqlr="update tesopredios set avaluo=$r[1], vigencia='2014' where cedulacatastral='$r[0]'";
		mysql_query($sqlr,$linkbd);
		echo "<br>".$sqlr;
	   }	
?>