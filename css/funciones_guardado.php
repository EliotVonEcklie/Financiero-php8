<?php
include "../comun.inc";
$conexion=conectar_v7();
if($_POST["NOMBRE_PROCESO"]=="CONSTRUCCIONCURSO_GUARDAR")
{
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
    $fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
    $descripcion=$_POST["descripcion"];
    $sqlr="INSERT INTO acti_construccion (fecha,descripcion,estado) VALUES ( '$fechaf', '$descripcion $_POST[fecha]','S')";
    if(mysqli_query($conexion,$sqlr))
    {
        $id=mysqli_insert_id($conexion);
        echo "".$id;
    }
    else
    {
     echo "ERROR";
    }
}

?>