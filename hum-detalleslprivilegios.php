<?php //V 1000 12/12/16 ?> 
<?php
	require_once "comun.inc";
	require_once "funciones.inc";
	$linkbd=conectar_bd();	
	$radicado=$_POST['radicado'];
	$tabla="<table class='inicio'>
	<tr style='text-align:center;'>
		<td class='titulos2'>N°</td>
		<td class='titulos2'>MODULO</td>
		<td class='titulos2'>MENU</td>
		<td class='titulos2'>PRIVILEGIO</td>
	</tr>";
	$iter='saludo1a';
	$iter2='saludo2';
	
	if ($radicado==1)
	{
		$sqlr="SELECT DISTINCT T2.id_opcion,T2.nom_opcion,T2.ruta_opcion,T2.niv_opcion,T2.est_opcion, T2.orden,T2.modulo,T1.id_modulo,T3.nombre, T4.nombre 
		FROM modulo_rol T1,opciones T2,modulos T3,niveles T4 
		WHERE T1.id_rol='$radicado' AND T1.id_modulo=T2.modulo AND T3.id_modulo=T1.id_modulo AND T2.modulo=T4.id_modulo AND T4.id_nivel=T2.niv_opcion 
		GROUP BY T2.id_opcion,T2.nom_opcion,T2.ruta_opcion,T2.niv_opcion,T2.est_opcion,T2.orden,T2.modulo,T1.id_modulo,T3.nombre,T4.nombre 
		ORDER BY T3.nombre, T4.nombre";
	}
	else
	{
		$sqlr="SELECT DISTINCT T2.id_opcion,T2.nom_opcion,T2.ruta_opcion,T2.niv_opcion,T2.est_opcion,T2.orden,T2.modulo,T1.id_modulo,T3.nombre, T4.nombre 
		FROM modulo_rol T1,opciones T2,modulos T3,niveles T4
		WHERE T1.id_rol='$radicado' AND T1.id_modulo=T2.modulo AND T3.id_modulo=T1.id_modulo AND T2.modulo=T4.id_modulo AND T4.id_nivel=T2.niv_opcion AND T2.especial<>'S' 
		GROUP BY T2.id_opcion,T2.nom_opcion,T2.ruta_opcion,T2.niv_opcion,T2.est_opcion,T2.orden,T2.modulo,T1.id_modulo,T3.nombre,T4.nombre 
		ORDER BY T3.nombre, T4.nombre";
	}
	$result=mysql_query($sqlr, $linkbd);
	$ii=1;
	while ($row =mysql_fetch_row($result)) 
	{				
		$tabla.="<tr class='$iter'>
			<td style='text-align:center;'>$ii</td>
			<td>".utf8_encode($row[8])."</td>
			<td>".utf8_encode($row[9])."</td>
			<td>".utf8_encode($row[1])."</td>
		</tr>";
		$aux=$iter;
		$iter=$iter2;
		$iter2=$aux;
		$ii++;
	}
$tabla.='</table>';
$data_row = array('detalle'=>$tabla);
header('Content-Type: application/json');
echo json_encode($data_row);
?>