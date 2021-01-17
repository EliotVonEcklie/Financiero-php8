<?php
require_once "../comun.inc";
require_once "../funciones.inc";
$linkbd=conectar_bd();	

$meta=$_POST['meta'];
$vigenciai=$_POST['vigenciai'];
$vigenciaf=$_POST['vigenciaf'];
$tabla='<table width="100%" class="titulos2" >
	<tr >
		<td style="width: 10% ">Cuenta</td>
		<td style="width: 14% ">Nombre</td>
		<td style="width: 16.5% ">Fuente</td>
		<td align="center" style="width: 15% " colspan="2">'.$vigenciai.' ($)</td>
		<td align="center" style="width: 15% " colspan="2">'.($vigenciai+1).' ($)</td>
		<td align="center" style="width: 15% " colspan="2">'.($vigenciai+2).' ($)</td>
		<td align="center" style="width: 15% " colspan="2">'.($vigenciai+3).' ($)</td>
	</tr>';
	$j=$vigenciai;
	for($i=$vigenciai;$i<=$vigenciaf;$i++){
		$arreglo=Array();
		$arregloplan=Array();
		$sql1="SELECT cuenta,valor,vigencia FROM planfuentes WHERE vigencia='$i' AND meta='$meta' ";
	    $result=mysql_query($sql1, $linkbd);
		while($row=mysql_fetch_array($result)){
	
			$sqleje="SELECT TB4.cuentap,TB4.valor,TB3.vigencia FROM presucdpplandesarrollo AS TB1,pptorp AS TB2,tesoordenpago AS TB3,pptocdp AS TB5,tesoordenpago_det AS TB4 WHERE TB1.codigo_meta='$meta' AND TB1.id_cdp=TB5.consvigencia AND  TB5.tipo_mov='201' AND TB2.idcdp=TB1.id_cdp AND TB1.vigencia='$i' AND TB2.tipo_mov='201' AND TB2.vigencia='$i' AND TB3.id_rp=TB2.consvigencia AND TB3.tipo_mov='201' AND TB3.id_orden=TB4.id_orden AND TB4.cuentap='$row[0]' AND TB3.vigencia='$i' AND NOT EXISTS (SELECT 1 FROM tesoegresos AS TEGRE WHERE TEGRE.tipo_mov='401' AND TEGRE.id_orden=TB3.id_orden) ";
			$reseje=mysql_query($sqleje,$linkbd);
			while($rowejec = mysql_fetch_row($reseje)){
				$arreglo[$i]+=$rowejec[1];
			}
	
			$sql="SELECT nombre,futfuentefunc,futfuenteinv  FROM pptocuentas WHERE cuenta='".$row[0]."' AND (vigencia='".$row[2]."' OR vigenciaf='".$row[2]."') ";
			$res=mysql_query($sql,$linkbd);
			$fila=mysql_fetch_row($res);
			if(is_null($fila[2]) || empty($fila[2])){
				$sql2="SELECT codigo,nombre FROM pptofutfuentefunc WHERE codigo='".$fila[1]."' ";
			}else{
				$sql2="SELECT codigo,nombre FROM pptofutfuenteinv WHERE codigo='".$fila[2]."' ";
				
			}

			$res=mysql_query($sql2,$linkbd);
			$filafu=mysql_fetch_row($res);
			$arregloplan[$i]+=$row[1];
			$tabla.='<tr style="cursor:pointer">
				<td class="cssdeta">'.$row[0].'</td>
				<td class="cssdeta">'.$fila[0].'</td>
				<td class="cssdeta">'.$filafu[0].'-'.$filafu[1].'</td>';
			$tabla.='<td class="cssdeta">$ '.number_format($arreglo[$j],2,',','.').'</td><td class="cssdeta">$ '.number_format($arregloplan[$j],2,',','.').'</td><td class="cssdeta">$ '.number_format($arreglo[$j+1],2,',','.').'</td><td class="cssdeta">$ '.number_format($arregloplan[$j+1],2,',','.').'</td><td class="cssdeta">$ '.number_format($arreglo[$j+2],2,',','.').'</td><td class="cssdeta">$ '.number_format($arregloplan[$j+2],2,',','.').'</td><td class="cssdeta">$ '.number_format($arreglo[$j+3],2,',','.').'</td><td class="cssdeta">$ '.number_format($arregloplan[$j+3],2,',','.').'</td>';
			
			$tabla.='<tr>';
		  }
		
	}
	
$tabla.='</table>';
	
$data_row = array('detalle'=>$tabla);
header('Content-Type: application/json');
echo json_encode($data_row);

?>