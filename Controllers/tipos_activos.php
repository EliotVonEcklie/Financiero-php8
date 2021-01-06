<?php
include "../comun.inc";
$conexion=conectar_v7();
$clase=$_POST["clase"];
$grupo=$_POST["grupo"];
$sqlr="SELECT * from actipo where niveluno='$grupo' and niveldos='$clase' and estado='S'";
echo $sqlr;
echo "<option>Seleccione tipo</option>";
$res=mysqli_query($conexion,$sqlr);
while($r=mysqli_fetch_row($res))
{
echo "<option value='".$r[0]."'>".$r[0]." - ".strtoupper($r[1])." </option>";
}
?>