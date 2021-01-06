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
	$sqlr="SELECT * FROM tesoprediosavaluos";
	$res=mysql_query($sqlr,$linkbd);
	$x=1;
	while($rowi=mysql_fetch_row($res))
	{
		$sqlr1="update tesoprediosavaluos set ord='$rowi[6]', tot='$rowi[5]' where vigencia='".$rowi[0]."' AND codigocatastral='".$rowi[1]."' AND avaluo='".$rowi[2]."' AND pago='".$rowi[3]."' AND estado='".$rowi[4]."' AND ord='".$rowi[5]."' AND tot='".$rowi[6]."'";
		echo $sqlr1."<br>";
		mysql_query($sqlr1,$linkbd);
		$x+=1;
	}
	
?>
