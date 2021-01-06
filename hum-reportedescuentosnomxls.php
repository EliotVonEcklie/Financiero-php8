<?php //V 1000 12/12/16 ?> 
<?php 
header("content-disposition: attachment;filename=reportedescuentosnomina.xls");
header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
require('comun.inc');
require('funciones.inc');
$linkbd=conectar_bd();
//session_start();
date_default_timezone_set("America/Bogota");
//*****las variables con los contenidos***********
$criterio="";
$criterio2="";	
$contmaes=0;
$intervmaes=2;
$sqlrjn="SELECT nombrejnomina FROM humparametrosnomina WHERE estado='S'";
$rowjn =mysql_fetch_row(mysql_query($sqlrjn,$linkbd));
$jnomina=ucwords(strtolower($rowjn[0]));

if($_POST[vigencias]!=""){$criterio=" AND hm.vigencia='$_POST[vigencias]' ";}
if($_POST[mes]!=""){$criterio2=" AND hm.mes='$_POST[mes]' ";}

$sqlrg="SELECT hm.id_nom,hm.mes,hm.vigencia,ht.netopagar,ht.diaslab,ht.devendias,ht.auxalim,ht.auxtran,ht.totaldeduc, ht.netopagar, ht.salbas,ht.valhorex,ht.salud,ht.pension,ht.fondosolid,ht.retefte,ht.cedulanit FROM humnomina hm,humnomina_det ht WHERE hm.id_nom=ht.id_nom ".$criterio.$criterio2." AND hm.id_nom LIKE '%$_POST[nnomina]%' AND hm.estado <> 'N' ORDER BY hm.id_nom DESC";
$respg = mysql_query($sqlrg,$linkbd);
while ($rowg =mysql_fetch_row($respg)){
	$lastday = mktime (0,0,0,$rowg[1],1,$rowg[2]);
	$vmes=ucwords(strftime('%B',$lastday));	
	$nresult=buscatercero($rowg[16]);	
   	echo "<table bordercolor=#333333 border=1 >
   		<tr>
			<td colspan='4' style='color:#000000; font-weight:bold;background-color:#cccccc' align='center'>
				DESCUENTOS DE NOMINA
			</td>
		</tr>
		<tr>
			<td colspan='4' style='color:#000000; font-weight:bold;background-color:#ccddee' align='center' >
				No. $rowg[0] - Mes $vmes - Vigencia $rowg[2]
			</td>
		</tr>
		<tr>
			<td colspan='2' style='color:#000000; font-weight:bold;background-color:#ccddee' align='center' >
				C.C o NIT: $rowg[16]
			</td>
			<td colspan='2' style='color:#000000; font-weight:bold;background-color:#ccddee' align='center' >
				Beneficiario: $nresult
			</td>
		</tr>
		<tr>
			<td style='color:#000000; font-weight:bold;background-color:#0066FF'>ITEM</td>
			<td style='color:#000000; font-weight:bold;background-color:#0066FF''>CONCEPTO</td>
			<td style='color:#000000; font-weight:bold;background-color:#0066FF''>SALARIO</td>
			<td style='color:#000000; font-weight:bold;background-color:#0066FF''>DESCUENTO</td>
		</tr>
  		<tr>
			<td>1</td>
			<td>Salario Basico</td>
			<td align='right'>".$rowg[10]."</td>
			<td></td>
		</tr>
  		<tr>
			<td>2</td>
			<td>Salud</td>
			<td></td>
			<td align='right'>".$rowg[12]."</td>
		</tr>
  		<tr>
			<td>3</td>
			<td>Pension</td>
			<td></td>
			<td align='right'>".$rowg[12]."</td>
		</tr>
  		<tr>
			<td>4</td>
			<td>Fondo de Solidaridad</td>
			<td></td>
			<td align='right'>".$rowg[14]."</td>
		</tr>
  		<tr>
			<td>5</td>
			<td>Retefuente</td>
			<td></td>
			<td align='right'>".$rowg[15]."</td>
		</tr>";
		$suming=$rowg[5]+$rowg[6]+$rowg[7]+$rowg[11];
		$sumegr=$rowg[12]+$rowg[13]+$rowg[14]+$rowg[15];
		$sqlr="SELECT hp.descripcion,hp.ncta,hr.ncuotas,hr.valorcuota FROM humnominaretenemp hp, humretenempleados hr WHERE hp.id_nom='$rowg[0]' AND hp.cedulanit='$rowg[16]' AND hr.id=hp.id ORDER BY hr.id";
		$resp = mysql_query($sqlr,$linkbd);
		$cont=6;
		while ($row =mysql_fetch_row($resp)){
			$sumegr+=$row[3];
			echo"<tr>
				<td>$cont</td>
				<td>".ucwords(strtolower($row[0]))." $row[1] de $row[2]</td>
				<td></td>
				<td align='right'>".$row[3]."</td>
			</tr>";
			$cont++;
		}
	echo"</table>";
}
?>


	