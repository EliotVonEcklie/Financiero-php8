<?php
require"../../comun.inc";
require"../../funciones.inc";

	$linkbd=conectar_bd();	
		$result = mysql_query("Select * from pptosidefclas  where nivel='D'  AND LEFT(codigo,1)>='2'order by codigo",$linkbd);	
	
	
	while ($row = mysql_fetch_array($result)) {
		$data[] = @Array("codigo" => "$row[0]", "nombre" => "$row[1]");
	}	
	echo json_encode($data);


?>