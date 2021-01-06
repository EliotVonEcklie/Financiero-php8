<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");	
	$sqlr="update pptocomprobante_det set fecha='2016-01-01' where tipo_comp=1 and vigencia=2016 and valdebido!=0 and tipomovimiento=1";
	mysql_query($sqlr,$linkbd);
	echo "Actualizado P.I <br>";
	$sqlr="SELECT id_acuerdo,fecha FROM pptoadiciones where vigencia=2016 group by id_acuerdo";
	$res=mysql_query($sqlr,$linkbd);
	while($row=mysql_fetch_row($res)){
		$sqlu="update pptocomprobante_det set fecha='$row[1]' where tipo_comp=2 and vigencia=2016 and numerotipo=$row[0] and tipomovimiento=1";
		mysql_query($sqlu,$linkbd);
		echo $sqlu."<br>";
	}
	echo "Actualizado Adiciones <br>";
	$sqlr="SELECT id_acuerdo,fecha FROM pptoreducciones where vigencia=2016 group by id_acuerdo";
	$res=mysql_query($sqlr,$linkbd);
	while($row=mysql_fetch_row($res)){
		$sqlu="update pptocomprobante_det set fecha='$row[1]' where tipo_comp=3 and vigencia=2016 and numerotipo=$row[0] and tipomovimiento=1";
		mysql_query($sqlu,$linkbd);
	}
	echo "Actualizado Reducciones <br>";
	$sqlr="SELECT id_acuerdo,fecha FROM pptotraslados where vigencia=2016 group by id_acuerdo";
	$res=mysql_query($sqlr,$linkbd);
	while($row=mysql_fetch_row($res)){
		$sqlu="update pptocomprobante_det set fecha='$row[1]' where tipo_comp=5 and vigencia=2016 and numerotipo=$row[0] and tipomovimiento=1";
		mysql_query($sqlu,$linkbd);
	}
	echo "Actualizado Traslados <br>";
	$sqlr="select consvigencia,fecha from pptocdp where vigencia=2016";
	$res=mysql_query($sqlr,$linkbd);
	while($row=mysql_fetch_row($res)){
		$sqlu="update pptocomprobante_det set fecha='$row[1]' where tipo_comp=6 and vigencia=2016 and numerotipo=$row[0] and tipomovimiento=1";
		mysql_query($sqlu,$linkbd);
	}
	echo "Actualizado CDP <br>";
	$sqlr="select consvigencia,fecha from pptorp where vigencia=2016";
	$res=mysql_query($sqlr,$linkbd);
	while($row=mysql_fetch_row($res)){
		$sqlu="update pptocomprobante_det set fecha='$row[1]' where tipo_comp=7 and vigencia=2016 and numerotipo=$row[0] ";
		mysql_query($sqlu,$linkbd);
	}
	echo "Actualizado RP <br>";
	$sqlr="select id_orden,fecha from tesoordenpago where vigencia=2016";
	$res=mysql_query($sqlr,$linkbd);
	while($row=mysql_fetch_row($res)){
		$sqlu="update pptocomprobante_det set fecha='$row[1]' where tipo_comp=8 and vigencia=2016 and numerotipo=$row[0] and tipomovimiento=1";
		mysql_query($sqlu,$linkbd);
	}
	echo "Actualizado CxP <br>";
	$sqlr="select id_egreso,fecha from tesoegresos where vigencia=2016";
	$res=mysql_query($sqlr,$linkbd);
	while($row=mysql_fetch_row($res)){
		$sqlu="update pptocomprobante_det set fecha='$row[1]' where tipo_comp=11 and vigencia=2016 and numerotipo=$row[0] and tipomovimiento=1";
		mysql_query($sqlu,$linkbd);
	}
	echo "Actualizado E <br>";
	
	
?>