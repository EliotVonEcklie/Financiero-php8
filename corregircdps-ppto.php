<?php //V 1000 12/12/16 ?> 
<?php
require"comun.inc";
require"funciones.inc";
require "conversor.php";
session_start();

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<script src="css/programas.js"></script>
<script src="css/calendario.js"></script>
<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
<?php titlepag();?>
</head>
<body>
<table class="inicio" >
<tr><td class="saludo1">Cuenta</td><td class="saludo1">valor cdps</td></tr>
<?php

$linkbd=conectar_bd();
$sqlr="select distinct pptocdp_detalle.cuenta, SUM(pptocdp_detalle.valor) from pptocdp_detalle where pptocdp_detalle.estado<>'N' group by pptocdp_detalle.cuenta";
	$res=mysql_query($sqlr,$linkbd);	
	while ($row =mysql_fetch_row($res)) 
	{		
		echo "<tr><td>$row[0]</td><td>$row[1]</td></tr>";
	}	
?>
</table>
<table class="inicio" >
<tr><td class="saludo1">Cuenta</td><td class="saludo1">valor rps</td><td class="saludo1">rps</td></tr>
<?php

$linkbd=conectar_bd();
$sqlr="select distinct  pptocdp_detalle.cuenta,SUM(pptocdp_detalle.valor),SUM(pptocdp_detalle.saldo) from pptocdp_detalle,pptocdp where pptocdp.estado='C' and pptocdp.consvigencia=pptocdp_detalle.consvigencia group by pptocdp_detalle.cuenta";
	$res=mysql_query($sqlr,$linkbd);	
	while ($row =mysql_fetch_row($res)) 
	{		
		echo "<tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td></tr>";
	}	
?>
</table>




</body>
</html>