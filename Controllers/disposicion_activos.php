<?php
include "../comun.inc";
$conexion=conectar_v7();
$vigenciarp=$_POST["vigenciarp"];
$nrp=$_POST["numerorp"];
$sqlr="SELECT * from acti_disposicionactivos where estado='S' AND id='4'";
echo "<option>Seleccione Disposicion</option>";
$res=mysqli_query($conexion,$sqlr);
while($r=mysqli_fetch_row($res))
{
echo "<option value='".$r[0]."'>".$r[0]." - ".strtoupper($r[1])." </option>";
}
?>