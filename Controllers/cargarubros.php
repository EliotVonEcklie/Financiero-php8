<?php
include "../comun.inc";
$conexion=conectar_bd();
$vigenciarp=$_POST["vigenciarp"];
$nrp=$_POST["numerorp"];
$sqlr="Select *from pptorp_detalle where consvigencia=$nrp and vigencia=$vigenciarp";
echo "<option>Seleccione Rubro</option>";
$res=mysql_query($sqlr,$conexion);
while($r=mysql_fetch_row($res))
{
echo "<option value='".$r[3]."'>".$r[3]." Saldo:$".$r[7]." </option>";
}
?>