<?php
require"../../comun.inc";
require"../../funciones.inc";

	$linkbd=conectar_bd();	
		$result = mysql_query("Select * from pptofutinversion  order by codigo",$linkbd);	
	
	
	while ($row = mysql_fetch_array($result)) {
		$data[] = @Array("codigo" => "$row[0]", "nombre" => utf8_encode($row[1]));
	}	
	echo json_encode($data);


?>