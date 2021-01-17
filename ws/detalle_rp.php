<?php
require_once "../comun.inc";
require_once "../funciones.inc";
$linkbd=conectar_bd();	

$tipocom=$_POST['tipocom'];
$vigencia=$_POST['vigencia'];
$tipomov=$_POST['tipomov'];

$tabla='<table width="70%">
	<tr>
		<td>Cuenta</td>
		<td>Fuente</td>
		<td align="center">Valor</td>
		<td>Tipo Movimiento</td>
	</tr>';
	$sql="SELECT cuenta, fuente, valor FROM pptorp_detalle WHERE vigencia='$vigencia' AND consvigencia='$tipocom' AND tipo_mov='$tipomov'";
	$result=mysql_query($sql, $linkbd);
	while($row=mysql_fetch_array($result)){
		$tabla.='<tr>
			<td class="cssdeta">'.$row[0].'</td>
			<td class="cssdeta">'.$row[1].'</td>
			<td class="cssdeta" align="right">'.number_format($row[2],2).'</td>
			<td class="cssdeta">'.$tipomov.'</td>
		</tr>';
	}
$tabla.='</table>';
	
$data_row = array('detalle'=>$tabla);
header('Content-Type: application/json');
echo json_encode($data_row);

?>