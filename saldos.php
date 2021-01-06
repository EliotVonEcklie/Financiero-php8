<?php //V 1000 12/12/16 ?> 
<!--V 1.0 24/02/2015-->
<?php
	header('Content-Type: text/html; charset=ISO-8859-1'); 
	require"comun.inc";
	require"funciones.inc";
	require"validaciones.inc";
	require "conversor.php";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
	
	// $sqlr="select consvigencia from pptocdp where 1 order by consvigencia asc";
	// $resdes=mysql_query($sqlr);
	// while($rowdes=mysql_fetch_row($resdes))
	// {				
		// echo "CDP: ".$rowdes[0]." - ";
		// $sqlr1="select sum(saldo) from pptocdp_detalle where consvigencia=$rowdes[0]";
		// $resdes1=mysql_query($sqlr1);
		// $rowdes1=mysql_fetch_row($resdes1);
		// echo "SALDO: ".$rowdes1[0]."  ";
		// $sqlr2="update pptocdp set saldo=$rowdes1[0] where consvigencia=$rowdes[0] and vigencia=".$_SESSION["vigencia"]."";
		// mysql_query($sqlr2);
		// echo "ACTUALIZADO <br>";
	// }
	
	$sqlr="select consvigencia from pptorp where saldo=0";
	$res=mysql_query($sqlr,$linkbd);
	while($row=mysql_fetch_row($res)){
		$sqlr1="update pptorp set estado='C' where consvigencia=$row[0] and estado='S'";
		mysql_query($sqlr1,$linkbd);
		echo $sqlr1."<br>";
	}
?>