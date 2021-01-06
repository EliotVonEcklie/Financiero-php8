<?php //V 1000 12/12/16 ?> 
<?php
require"comun.inc";
require"funciones.inc";
	 $linkbd=conectar_bd();	
	  $sqlr="select * from  acticlasificacion";
  	  $resp=mysql_query($sqlr,$linkbd);
	  while($r=mysql_fetch_row($resp))
	   {
		$sqlr="update acticrearact set valdepmen=(valor/($r[3]*12)),saldodepact=(valor), nummesesdep=($r[3]*12),saldomesesdep=($r[3]*12) where clasificacion='$r[0]'";
		mysql_query($sqlr,$linkbd);
		echo "<br>".$sqlr;
	   }	
?>