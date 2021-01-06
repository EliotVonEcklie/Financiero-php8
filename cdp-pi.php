<?php //V 1002 28/12/16 NO enviaba bn el estado a la cabecera?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	require "conversor.php";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
	
	$sqlr="select numerotipo,sum(valdebito),sum(valcredito),tipomovimiento from pptocomprobante_det where cuenta like '20302020501' and tipo_comp=6 group by numerotipo,tipomovimiento,doc_receptor";
	$res=mysql_query($sqlr,$linkbd);
	while($row=mysql_fetch_row($res)){
		$sqlr1="select valdebito,valcredito,tipomovimiento from pptocomprobante_det where tipo_comp=1 and cuenta like '20302020501' and doc_receptor=$row[0] and tipomovimiento=$row[3]";
		// echo $sqlr1;
		$res1=mysql_query($sqlr1,$linkbd);
		$row1=mysql_fetch_row($res1);
		echo "CDP: ".$row[0]." D: ".$row[1]." C: ".$row[2]." TM: ".$row[3]." PID: ".$row1[0]." PIC:".$row1[1]." PITM: ".$row1[2]."<br>";
	} 
?>
