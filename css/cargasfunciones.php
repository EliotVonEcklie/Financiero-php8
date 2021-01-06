<?php
include "../comun.inc";
$conexion=conectar_v7();
if($_POST["NOMBRE_PROCESO"]=="BUSCARTERCERO")
{
 $documento=$_POST["tercero"];
 $valor2="";
 $sqlr="select * from terceros where cedulanit='$documento' and estado='S'";
 //echo $sqlr;
	$res=mysqli_query($conexion,$sqlr);
	while($r=mysqli_fetch_row($res))
	{
        if ($r[16]=='1')
        {$ntercero=$r[5];}
		else {$ntercero="$r[3] $r[4] $r[1] $r[2]";}
		$valor2=$ntercero;
		$co+=1;
    }
    echo $valor2;
}
if($_POST["NOMBRE_PROCESO"]=="ACTUALIZARESPONSABLEACTIVO")
{
 $documento=$_POST["tercero"];
 $placa=$_POST["placa"];
 
 $sqlr="select * from acticrearact_det_responsable where tercero='$documento' and placa='$placa' and estado='S'";
 //echo $sqlr;
 $res= $conexion->query($sqlr);
    $numfilas=$res->num_rows;
   // echo "n:".$numfilas;
    if($numfilas<=0)
    {

        $sqlr="update acticrearact_det_responsable set estado='N' where  placa='$placa' ";        
        $conexion->query($sqlr);
        $sqlr="insert into acticrearact_det_responsable (tercero,placa,estado) value ('".$documento."','".$placa."','S')";
        $conexion->query($sqlr);
        echo "1";
    }
    else
    {
        
        echo "0";
    }
}

if($_POST['NOMBRE_PROCESO']==='BUSCARENTIDAD')
{
    $id_entidad = $_POST['id_entidad'];
    $sqlr = "SELECT nombre FROM codigoscun WHERE id_entidad='$id_entidad'";
    $res = mysqli_query($conexion,$sqlr);
    $r = mysqli_fetch_row($res);
    
    echo $r[0];
}
?>