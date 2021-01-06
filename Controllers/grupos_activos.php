<?php
include "../comun.inc";
$conexion=conectar_v7();
$clase=$_POST["clase"];
$sqlr="SELECT * from actipo where niveluno=$clase and estado='S'";
echo "<option>Seleccione Grupo</option>";
$res=mysqli_query($conexion,$sqlr);
while($r=mysqli_fetch_row($res))
{
echo "<option value='".$r[0]."'>".$r[0]." - ".strtoupper($r[1])." </option>";
}
?>