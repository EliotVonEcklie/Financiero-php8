<?php //V 1000 12/12/16 ?> 
<?php  
header("content-disposition: attachment;filename=auxiliardisponibilidad.xls");
header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
require('comun.inc');
require('funciones.inc');
//session_start();
  date_default_timezone_set("America/Bogota");
$linkbd=conectar_bd();
$sqlr="select *from configbasica where estado='S'";
//echo $sqlr;
$res=mysql_query($sqlr,$linkbd);
while($row=mysql_fetch_row($res)){
	$nit=$row[0];
  	$rs=$row[1];
}
echo "<table bordercolor=#333333 border=1 >
	<tr>
		<td colspan='12' style='color:#000000; font-weight:bold;background-color:#cccccc' align='center'>$rs - $nit</td>
	</tr>
	<tr>
		<td colspan='12' style='color:#000000; font-weight:bold;background-color:#ccddee' align='center' >
			AUXILIAR DE DISPONIBILIDADES - Periodo: $_POST[fechaini] - $_POST[fechafin]
		</td>
	</tr>";
  echo"<tr>
  		<td style='color:#000000; font-weight:bold;background-color:#0066FF'>FECHA</td>
		<td style='color:#000000; font-weight:bold;background-color:#0066FF''>TIPO COMPROBANTE</td>
		<td style='color:#000000; font-weight:bold;background-color:#0066FF''>NO COMPROBANTE</td>
		<td style='color:#000000; font-weight:bold;background-color:#0066FF''>VIGENCIA</td>
		<td style='color:#000000; font-weight:bold;background-color:#0066FF''>RUBRO</td>
		<td style='color:#000000; font-weight:bold;background-color:#0066FF''>NOMBRE RUBRO</td>
		<td style='color:#000000; font-weight:bold;background-color:#0066FF''>FUENTE</td>
		<td style='color:#000000; font-weight:bold;background-color:#0066FF''>NOMBRE FUENTE</td>
		<td style='color:#000000; font-weight:bold;background-color:#0066FF''>DETALLE</td>
		<td style='color:#000000; font-weight:bold;background-color:#0066FF''>VALOR</td>
		<td style='color:#000000; font-weight:bold;background-color:#0066FF''>ESTADO</td>
		<td style='color:#000000; font-weight:bold;background-color:#0066FF''>TIPO MOVIMIENTO</td>
	</tr>";
	$crit1="";
	//$sqlr="SELECT pptocomprobante_cab.fecha, pptocomprobante_cab.tipo_comp, pptotipo_comprobante.nombre, pptocomprobante_cab.numerotipo, pptocomprobante_cab.vigencia FROM pptocomprobante_cab INNER JOIN pptotipo_comprobante ON pptocomprobante_cab.tipo_comp=pptotipo_comprobante.id_tipo WHERE pptotipo_comprobante.id_tipo='6'".$crit1." AND pptocomprobante_cab.fecha BETWEEN '$_POST[fechaini]' AND '$_POST[fechafin]' ORDER BY pptocomprobante_cab.fecha, pptocomprobante_cab.numerotipo";
	$sqlr = "SELECT pptocdp.consvigencia, pptocdp.fecha, pptocdp.objeto, pptocdp.vigencia, pptocdp.estado, pptocdp.tipo_mov FROM pptocdp WHERE pptocdp.fecha BETWEEN '$_POST[fechaini]' AND '$_POST[fechafin]' ORDER BY pptocdp.fecha, pptocdp.consvigencia";
	$resp = mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($resp)){
		//$sqld="SELECT pptocomprobante_det.cuenta, pptocuentas.nombre, pptocomprobante_det.tercero, pptocomprobante_det.detalle, pptocomprobante_det.valdebito FROM pptocomprobante_det INNER JOIN pptocuentas ON pptocomprobante_det.cuenta=pptocuentas.cuenta WHERE pptocomprobante_det.vigencia='$row[4]' AND pptocomprobante_det.tipo_comp='$row[1]' AND pptocomprobante_det.numerotipo='$row[3]'";
		$sqld="SELECT cuenta, fuente, valor FROM pptocdp_detalle WHERE vigencia='$row[3]' AND consvigencia='$row[0]' AND tipo_mov='$row[5]'";
		$resd=mysql_query($sqld,$linkbd);
		$estado = '';
		if($row[4] == 'N')
		{
			$estado = 'ANULADO';
		}
		else if($row[4] == 'R')
		{
			$estado = 'REVERSADO';
		}
		else
		{
			$estado = 'ACTIVO';
		}

		while($rowd =mysql_fetch_row($resd)){
	  		echo"<tr>
				<td>$row[1]</td>
				<td>DISPONIBILIDAD</td>
				<td>$row[0]</td>
				<td>$row[3]</td>
				<td>$rowd[0]</td>
				<td>".buscacuentapres($rowd[0])."</td>
				<td>$rowd[1]</td>
				<td>".buscafuenteppto($rowd[0], $row[3])."</td>
				<td>$row[2]</td>
				<td>$rowd[2]</td>
				<td>$estado</td>
				<td>$row[5]</td>

			</tr>";
		}
	}
echo"</table>";
?> 


	