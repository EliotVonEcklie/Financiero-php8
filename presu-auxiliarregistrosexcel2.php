<?php //V 1000 12/12/16 ?> 
<?php  
header("content-disposition: attachment;filename=auxiliarregistros.xls");
header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
require('comun.inc');
require('funciones.inc');
//session_start();
  date_default_timezone_set("America/Bogota");
$linkbd=conectar_bd();
$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
$sqlr="select *from configbasica where estado='S'";
//echo $sqlr;
$res=mysql_query($sqlr,$linkbd);
while($row=mysql_fetch_row($res)){
	$nit=$row[0];
  	$rs=$row[1];
}
echo "<table bordercolor=#333333 border=1 >
	<tr>
		<td colspan='10' style='color:#000000; font-weight:bold;background-color:#cccccc' align='center'>$rs - $nit</td>
	</tr>
	<tr>
		<td colspan='10' style='color:#000000; font-weight:bold;background-color:#ccddee' align='center' >
			AUXILIAR DE REGISTROS - Periodo: $_POST[fechaini] - $_POST[fechafin]
		</td>
	</tr>";
  echo"<tr>
  		<td style='color:#000000; font-weight:bold;background-color:#0066FF'>FECHA</td>
		<td style='color:#000000; font-weight:bold;background-color:#0066FF''>TIPO COMPROBANTE</td>
		<td style='color:#000000; font-weight:bold;background-color:#0066FF''>NO COMPROBANTE</td>
		<td style='color:#000000; font-weight:bold;background-color:#0066FF''>VIGENCIA</td>
		<td style='color:#000000; font-weight:bold;background-color:#0066FF''>RUBRO</td>
		<td style='color:#000000; font-weight:bold;background-color:#0066FF''>NOMBRE RUBRO</td>
		<td style='color:#000000; font-weight:bold;background-color:#0066FF''>TERCERO</td>
		<td style='color:#000000; font-weight:bold;background-color:#0066FF''>NOMBRE TERCERO</td>
		<td style='color:#000000; font-weight:bold;background-color:#0066FF''>DETALLE</td>
		<td style='color:#000000; font-weight:bold;background-color:#0066FF''>VALOR</td>
	</tr>";
	$crit1="";
	if($_POST[estado]!="-1")
		$crit1=" AND estado='$_POST[estado]'";
	$sqlr="SELECT pptocomprobante_cab.fecha, pptocomprobante_cab.tipo_comp, pptotipo_comprobante.nombre, pptocomprobante_cab.numerotipo, pptocomprobante_cab.vigencia FROM pptocomprobante_cab INNER JOIN pptotipo_comprobante ON pptocomprobante_cab.tipo_comp=pptotipo_comprobante.id_tipo WHERE pptotipo_comprobante.id_tipo='7'".$crit1." AND pptocomprobante_cab.fecha BETWEEN '$_POST[fechaini]' AND '$_POST[fechafin]' and pptocomprobante_cab.vigencia=$vigusu  ORDER BY pptocomprobante_cab.fecha, pptocomprobante_cab.numerotipo";
	$resp = mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($resp)){
		$sqld="SELECT pptocomprobante_det.cuenta, pptocuentas.nombre, pptocomprobante_det.tercero, pptocomprobante_det.detalle, pptocomprobante_det.valdebito FROM pptocomprobante_det INNER JOIN pptocuentas ON pptocomprobante_det.cuenta=pptocuentas.cuenta WHERE pptocomprobante_det.vigencia='$row[4]' AND pptocomprobante_det.tipo_comp='$row[1]' AND pptocomprobante_det.numerotipo='$row[3]' ";
		$resd=mysql_query($sqld,$linkbd);
		while($rowd =mysql_fetch_row($resd)){
			$sqlr="select pptorp.tercero,pptocdp.objeto from pptorp,pptocdp where pptorp.vigencia=$row[4] and pptorp.consvigencia=$row[3] and pptorp.idcdp=pptocdp.consvigencia and pptocdp.vigencia=$vigusu";
			//echo $sqlr;
			$resrp=mysql_query($sqlr,$linkbd);
			$rowrp =mysql_fetch_row($resrp);
			$terrp=$rowrp[0];
	  		echo"<tr>
				<td>$row[0]</td>
				<td>$row[1] - $row[2]</td>
				<td>$row[3]</td>
				<td>$row[4]</td>
				<td>$rowd[0]</td>
				<td>$rowd[1]</td>
				<td>$terrp</td>
				<td>".buscatercero($terrp)."</td>
				<td>$rowrp[1]</td>
				<td>$rowd[4]</td>
			</tr>";
		}
	}
echo"</table>";
?> 


	