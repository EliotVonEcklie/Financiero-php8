<?php
require_once "../comun.inc";
require_once "../funciones.inc";
$linkbd=conectar_bd();	

$codigo=$_POST['codigo'];
$vigencia1=$_POST['vigencia1'];
$vigencia2=$_POST['vigencia2'];
$tabla='<table class="titulos" width="70%">
	<tr>
		<td>Codigo</td>
		<td>Nombre</td>
	';
	for($i=$vigencia1;$i<=$vigencia2;$i++)
	{
		$tabla.='<td>Vigencia '.$i.'</td>';
	}
	$tabla.='</tr>';
	$sql="SELECT codigo,nombre,nivel,(select max(nivel) FROM presuplandesarrollo WHERE padre LIKE '$codigo%'),vigencia,vigenciaf,id FROM presuplandesarrollo WHERE padre LIKE '$codigo%' ORDER BY codigo";
	$result=mysql_query($sql, $linkbd);
	while($row=mysql_fetch_array($result)){
	$negrilla='';
	$editaplan='onDblClick=\'window.open("plan-editaplandesarrollopoai.php?idproceso=';
	$puntero='style=\'cursor: hand\'';
	if($row[2]<$row[3])
	{
		$negrilla='style="font-weight:bold"';
		$padre=$row[0];
		$editaplan='';
		$puntero='';
	}
		$tabla.='<tr '.$editaplan.''.$row[0].'&vigini='.$row[4].'&vigfin='.$row[5].'&padre='.$padre.'&buscta='.$row[6].'")\' '.$puntero.'>
			<td class="cssdeta" '.$negrilla.'>'.$row[0].'</td>
			<td class="cssdeta" '.$negrilla.'>'.utf8_encode($row[1]).'</td>';
		for($z=$vigencia1;$z<=$vigencia2;$z++)
		{	$contador='';
			$sqlr="SELECT sum(valor) FROM planfuentes WHERE meta='$row[0]' AND vigencia='$z'";
			$resultado=mysql_query($sqlr, $linkbd);
			$contador=mysql_fetch_row($resultado);
			if($contador[0]=='0')
				$contador[0]='';
			$tabla.='<td class="cssdeta" '.$negrilla.' align="center">'.$contador[0].'</td>';
		}
		$tabla.='</tr>';
	}
$tabla.='</table>';
	
$data_row = array('detalle'=>$tabla);
header('Content-Type: application/json');
echo json_encode($data_row);

?>