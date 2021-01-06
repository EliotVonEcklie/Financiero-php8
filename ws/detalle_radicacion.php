<?php
require_once "../comun.inc";
require_once "../funciones.inc";
$linkbd=conectar_bd();	

$radicado=$_POST['radicado'];

$tabla='<table width="70%">
	<tr>
		<td>Fecha Asignación</td>
		<td>Fecha Respuesta</td>
		<td>Usuario Asignado</td>
		<td>Usuario Que Contesta</td>
		<td>Estado</td>
	</tr>';
	$sql="SELECT CASE estado
		WHEN 'A' THEN 'Asignado'
		WHEN 'C' THEN 'Contestado'
		WHEN 'L' THEN 'No Leido'
		WHEN 'LN' THEN 'No Leido'
		WHEN 'LS' THEN 'Leido'
		WHEN 'R' THEN 'Redirigido'
	END nestado, fechasig, fechares, usuarioasig, usuariocon, estado FROM planacresponsables WHERE codradicacion='$radicado'";
	$result=mysql_query($sql, $linkbd);
	while($row=mysql_fetch_array($result)){
		$usuasig=buscatercero($row[3]);
		$usucon=buscatercero($row[4]);
		$tabla.='<tr>
			<td class="cssdeta">'.$row[1].'</td>
			<td class="cssdeta">'.$row[2].'</td>
			<td class="cssdeta">'.$row[3].' - '.utf8_encode($usuasig).'</td>
			<td class="cssdeta">'.$row[4].' - '.utf8_encode($usucon).'</td>
			<td class="cssdeta">'.$row[5].' - '.$row[0].'</td>
		</tr>';
	}
$tabla.='</table>';
	
$data_row = array('detalle'=>$tabla);
header('Content-Type: application/json');
echo json_encode($data_row);

?>