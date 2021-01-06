<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	require "conversor.php";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
	
	$sqlr="select * from tesopagoterceros_det";
	$res=mysql_query($sqlr,$linkbd);
	$x=0;
	while($r=mysql_fetch_row($res)){
		echo $r[0]." ".$r[1]."<br>";
		$sqlu="update tesopagoterceros_det set id_det=".$x." where id_pago=$r[0] and movimiento=$r[1]";
		mysql_query($sqlu,$linkbd);
		$x+=1;
	}
?>