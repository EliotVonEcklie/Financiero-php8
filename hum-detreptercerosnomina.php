<?php //V 1000 12/12/16 ?> 
<?php
	require_once "comun.inc";
	require_once "funciones.inc";
	
	$linkbd=conectar_bd();	
	$ndocumento=$_POST['nomdoc'];
	$sqlr="SELECT TB2.nombrecargo,TB3.nombrearea  FROM planestructura_terceros TB1, planaccargos TB2, planacareas TB3 WHERE TB1.cedulanit='$ndocumento' AND TB1.codcargo=TB2.codcargo AND TB2.dependencia=TB3.codarea";
    $resp = mysql_query($sqlr,$linkbd);
    while ($row =mysql_fetch_row($resp)){$ncargo=$row[0];$ndependencia=$row[1];}
	if($ncargo==""){$ncargo="NO ASIGNADO";}
	if($ndependencia==""){$ndependencia="NO ASIGNADO";}
	$tabla='<table width="70%">
		<tr class="titulos2">
			<td>Documento</td>
			<td>Dependencia</td>
			<td>Cargo</td>
		</tr>';
	$tabla.="<tr class='cssdeta'>
			<td>$ndocumento</td>
			<td>$ndependencia</td>
			<td>$ncargo</td>
	 		</tr>";
	$tabla.='</table>';
	$data_row = array('detalle'=>$tabla);
	header('Content-Type: application/json');
	echo json_encode($data_row);
?>