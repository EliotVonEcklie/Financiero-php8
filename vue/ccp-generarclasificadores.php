<?php 
require '../comun.inc';
$linkbd = conectar_v7();

$out = array('error' => false);
$codigo = "";

$action="show";

if(isset($_GET['action'])){
	$action=$_GET['action'];
}

if(isset($_GET['codigo'])){
	$codigo=$_GET['codigo'];
}


if($action == 'get_codigos'){
    $codigo = $_POST['codigo'];
    $sql="SELECT codigo, id FROM `cuentasingresosccpet` WHERE codigo LIKE '$codigo%' ORDER BY codigo ASC";
    $res=mysqli_query($linkbd,$sql);
    $codes = array();

    while($row=mysqli_fetch_row($res))
    {
        array_push($codes, $row);
    }

    $out['codes'] = $codes;
}

if($action=='show'){ 
    $sql="SELECT * FROM cuentasingresosccpet  WHERE version=(SELECT MAX(version) FROM cuentasingresosccpet ) ORDER BY cuentasingresosccpet.codigo ASC";
    $res=mysqli_query($linkbd,$sql);
    $codigos = array();

    while($row=mysqli_fetch_row($res))
    {
        array_push($codigos, $row);
    }

    $out['codigos'] = $codigos;
}

// $sql = "SELECT COUNT(id_clasificador) FROM cuentasingresosccpet_cab";
// $res = mysqli_query($linkbd,$sql);
// $row = mysqli_fetch_row($res);
// $id_para_clasificador = $row[0] + 1;
// echo $id_para_clasificador;

if($action == 'insert_cab'){
    $nombre = $_POST['nombre_clasificador'];
    date_default_timezone_set('America/Bogota');
    $fecha_creacion = date("Y-m-d");
    $estado = 1; 
    $sql= "INSERT INTO cuentasingresosccpet_cab(nombre, estado, fecha_creacion) VALUES ('$nombre', $estado, '$fecha_creacion')";
    $res=mysqli_query($linkbd,$sql);
    $id_cab = mysqli_insert_id($linkbd);

    $sql= "INSERT INTO ccpetclasificadores(id, nombre) VALUES ( $id_cab, '$nombre')";
    $res=mysqli_query($linkbd,$sql);

    $out['id_cab'] =  $id_cab;
}

if($action == 'insert_det'){
    $id_cuentasingreso = $_POST['id_cuentasingreso'];
    $id_clasificador = $_POST['id_clasificador'];
    $sql="INSERT INTO cuentasingresosccpet_det (id_cuentasingreso, id_clasificador) VALUES ($id_cuentasingreso, $id_clasificador)";
    $res=mysqli_query($linkbd,$sql);
}

header("Content-type: application/json");
echo json_encode($out);
die();
