
<?php 
	require"comun.inc";
	require"funciones.inc";
	require "conversor.php";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
	$sqlr="SELECT codigo FROM presuplandesarrollo order by codigo asc";
	$res=mysql_query($sqlr,$linkbd);
	$x=1;
	while($rowi=mysql_fetch_row($res))
	{
		$sqlr1="update presuplandesarrollo set id=$x where  codigo ='".$rowi[0]."'";
		echo $sqlr1."<br>";
		mysql_query($sqlr1,$linkbd);
		$x+=1;
	}	
?>