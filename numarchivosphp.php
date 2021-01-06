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

	
echo "Cont: ". count(glob("financiero/{*.php}",GLOB_BRACE));
	
?>
