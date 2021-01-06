<?php
require_once "../comun.inc";
require_once "../funciones.inc";
$linkbd=conectar_bd();	

$codcat=$_POST['codcat'];

$tabla='<table width="70%">
	<tr>
		<td>Vigencia</td>
		<td>Pago</td>
		<td>Estado</td>
		<td align="center">Avaluo</td>
	</tr>';
	$sql="SELECT CASE pago
		WHEN 'P' THEN 'Prescrito'
		WHEN 'S' THEN 'Pagado'
		WHEN 'N' THEN 'Activo'
		END	npago, vigencia, estado, avaluo FROM tesoprediosavaluos WHERE codigocatastral='$codcat' ORDER BY vigencia";
	$result=mysql_query($sql, $linkbd);
	while($row=mysql_fetch_array($result)){
		$tabla.='<tr>
			<td class="cssdeta">'.$row[1].'</td>
			<td class="cssdeta">'.$row[2].'</td>
			<td class="cssdeta">'.$row[0].'</td>
			<td class="cssdeta" align="right">'.number_format($row[3],2,',','.').'</td>
		</tr>';
	}
$tabla.='</table>';
	
$data_row = array('detalle'=>$tabla);
header('Content-Type: application/json');
echo json_encode($data_row);

?>