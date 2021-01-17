<?php
require"../../comun.inc";
require"../../funciones.inc";

	$linkbd=conectar_bd();	
		$result = mysql_query("Select * from conceptoscontables  where modulo='3' and (tipo='C') order by codigo",$linkbd);	
	
	
	while ($row = mysql_fetch_array($result)) {
		$data[] = @Array("codigo" => "$row[0]", "nombre" => "$row[1]");
	}	
	echo json_encode($data);


?>