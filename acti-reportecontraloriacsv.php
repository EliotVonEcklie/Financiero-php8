<?php 
	//ini_set('max_execution_time',3600);
	require"comun.inc"; 
	$linkbd=conectar_bd();	
	$sql="SELECT * FROM acticrearact_det";
	$res=mysql_query($sql,$linkbd);

	if($res > 0){
		$delimiter = ",";
		$filename = "reportecontraloria_" . date('Y-m-d') . ".csv";
		
		$f = fopen('php://memory', 'w');
		
		$fields = array('Fecha Adquisición O Baja', 'Concepto', 'Codigo Contable', 'Detalle', 'Valor');
		fputcsv($f, $fields, $delimiter,"\t\n\r");
		
		while($row=mysql_fetch_row($res)){
			$rest = substr($row[1],0,-4);
			$sql1="SELECT cuenta_activo FROM acti_activos_det WHERE tipo=$rest";
			$res1=mysql_query($sql1,$linkbd);
			$row1=mysql_fetch_row($res1);
			
			$detalle = $row[2];
			$detalle = trim($detalle, ",;\t\n\r\x0B\0");
			$caracteres = array(",", ";", "\t", "\n", "\r", "\x0B", "\0", "?", "\r\n");
			$detalle = str_replace($caracteres, "", $detalle);

			$lineData = array($row[8], "ADQUISICION", $row1[0], $detalle , $row[15]);
			fputcsv($f, $lineData, $delimiter,"\t\n\r");
		}
		
		fseek($f, 0);
		
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename="' . $filename . '";');
		
		fpassthru($f);
		fclose($f);
	}
	exit;

?>