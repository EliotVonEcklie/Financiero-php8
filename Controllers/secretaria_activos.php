<?php
include "../comun.inc";
$conexion=conectar_v7();
$sqlr="Select * from actiubicacion where estado='S'";
echo "<option>Seleccione Ubicacion</option>";
$res=mysqli_query($conexion,$sqlr);
while($r=mysqli_fetch_row($res))
{
echo "<option value='".$r[0]."'>".$r[0]." - ".strtoupper($r[1])." </option>";
}
?>