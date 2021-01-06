<?php
include "../comun.inc";
$conexion=conectar_v7();
$vigenciarp=$_POST["vigenciarp"];
$nrp=$_POST["numerorp"];
$sqlr="SELECT * from actipo where niveluno='0' and estado='S'";
echo "<option>Seleccione Clasificacion</option>";
$res=mysqli_query($conexion,$sqlr);
while($r=mysqli_fetch_row($res))
{
echo "<option value='".$r[0]."'>".$r[0]." - ".strtoupper($r[1])." </option>";
}
?>