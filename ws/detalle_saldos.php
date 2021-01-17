<?php
require_once "../comun.inc";
require_once "../funciones.inc";
require_once "../validaciones.inc";
$linkbd=conectar_bd();	

$sector=$_POST['sector'];
$vigusu=$_POST['vigencia'];

$tabla='<table width="70%">
	<tr>
		<td>Rubro</td>
		<td>Nombre Rubro</td>
		<td align="center">Saldo</td>
	</tr>';
	$sql="SELECT * FROM pptocuentas_sectores WHERE sector='$sector' AND (vigenciai=".$vigusu." or vigenciaf=".$vigusu.")";
	$result=mysql_query($sql, $linkbd);
	while($row=mysql_fetch_array($result)){
		$nomcta=existecuentain($row[0]);
		$saldo=consultasaldo($row[0],$vigusu,$vigusu);	
		$tabla.='<tr>
			<td class="cssdeta">'.$row[0].'</td>
			<td class="cssdeta">'.$nomcta.'</td>
			<td class="cssdeta" align="right">'.number_format($saldo[3],2,',','.').'</td>
		</tr>';
	}
$tabla.='</table>';
	
$data_row = array('detalle'=>$tabla);
header('Content-Type: application/json');
echo json_encode($data_row);
?>