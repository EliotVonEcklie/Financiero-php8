<?php //V 1000 12/12/16 ?> 
<?php
require"comun.inc"; 
require"funciones.inc";
	 $linkbd=conectar_bd();	
	  $sqlr="select pptorp.consvigencia, pptorp.idcdp, pptorp_detalle.cuenta, pptorp_detalle.valor from  pptorp, pptorp_detalle where pptorp.consvigencia=pptorp_detalle.consvigencia and pptorp.estado<>'N'";
  	  $resp=mysql_query($sqlr,$linkbd);
	  while($r=mysql_fetch_row($resp))
	   {
		$sqlr="update pptocdp_detalle set saldo=pptocdp_detalle.valor-$r[3] where cuenta='$r[2]' and consvigencia=$r[1] ";
//		mysql_query($sqlr,$linkbd);
		echo "<br>".$sqlr;
	   }	
?> 