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
	
	$tipocomp=6;
	$vigencia=2016;
	// $docreceptor=6;
	
	$sqlr="select cuenta, numerotipo, valdebito from pptocomprobante_det where tipo_comp='$tipocomp' and vigencia='$vigencia'";
	$res=mysql_query($sqlr,$linkbd);
	while($row=mysql_fetch_row($res)){
		$sqlu="update pptocomprobante_det set doc_receptor='$row[1]' where cuenta='$row[0]' and numerotipo='2016' and tipo_comp='1' and vigencia='$vigencia' and valcredito='$row[2]' and valdebito='0'";
		mysql_query($sqlu,$linkbd);
		echo "$sqlu <br>";
	}
?>