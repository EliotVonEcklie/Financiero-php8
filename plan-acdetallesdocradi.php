<?php //V 1000 12/12/16 ?> 
<?php
	require_once "comun.inc";
	require_once "funciones.inc";
	$linkbd=conectar_bd();
	$radicado=$_POST['radicado'];
	$tipor=$_POST['tipor'];
	$tabla="<table class='inicio'>
	<tr style='text-align:center;'>
		<td class='titulos2' colspan='2'>Asignación</td>
		<td class='titulos2' colspan='2'>Respuesta</td>
		<td class='titulos2' rowspan='2'>Usuario Asignado</td>
		<td class='titulos2' rowspan='2'>Usuario Que Contesta</td>
		<td class='titulos2' rowspan='2'>Estado</td>
	</tr>
	<tr style='text-align:center;'>
		<td class='titulos2' style='width:8%;'>Fecha</td>
		<td class='titulos2' style='width:8%;'>Hora</td>
		<td class='titulos2' style='width:8%;'>Fecha</td>
		<td class='titulos2' style='width:8%;'>Hora</td>
	
	</tr>";
	$sql="SELECT CASE estado
		WHEN 'AN' THEN 'Asignado'
		WHEN 'AC' THEN 'Contestado'
		WHEN 'LN' THEN 'No Leido'
		WHEN 'LS' THEN 'Leido'
		WHEN 'AR' THEN 'Redirigido'
		WHEN 'CS' THEN 'Consulta Contestada'
		WHEN 'CN' THEN 'Consulta Sin Contestar'
	END nestado, fechasig, fechares, usuarioasig,usuariocon,estado,horasig,horresp,codigo FROM planacresponsables WHERE codradicacion='$radicado' AND tipot='$tipor'";
	$result=mysql_query($sql, $linkbd);
	while($row=mysql_fetch_array($result)){
		$usuasig=buscatercero($row[3]);
		$usucon=buscatercero($row[4]);
		if($row[1]!='0000-00-00'){$fecharad=date('d-m-Y',strtotime($row[1]));}
		else{$fecharad='00-00-0000';}
		if($row[2]!='0000-00-00'){$fechares=date('d-m-Y',strtotime($row[2]));}
		else{$fechares='00-00-0000';}
		if($row[6]!='00:00:00'){$horarad=date('h:i:s a',strtotime($row[6]));}
		else{$horarad=$row[6];}
		if($row[7]!='00:00:00'){$horares=date('h:i:s a',strtotime($row[7]));}
		else{$horares=$row[7];}
		$tabla.="<tr class='cssdeta' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase' onClick=\"modaltareas('visible','$row[8]')\" >
			<td>$fecharad</td>
			<td>$horarad</td>
			<td>$fechares</td>
			<td>$horares</td>
			<td>$row[3] - ".utf8_encode($usuasig)."</td>
			<td>$row[4] - ".utf8_encode($usucon)."</td>
			<td>$row[0]</td>
		</tr>";
	}
$tabla.='</table>';
$data_row = array('detalle'=>$tabla);
header('Content-Type: application/json');
echo json_encode($data_row);
?>