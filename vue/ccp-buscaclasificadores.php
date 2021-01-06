<?php
require '../comun.inc';
$linkbd = conectar_v7();

$out = array('error' => false);
$codigo = "";

$action = "show";

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

if (isset($_GET['codigo'])) {
    $codigo = $_GET['codigo'];
}


if ($action == 'get_codigos') {
    $codigo = $_POST['codigo'];
    $sql = "SELECT codigo, id FROM `cuentasingresosccpet` WHERE codigo LIKE '$codigo%' ORDER BY codigo ASC";
    $res = mysqli_query($linkbd, $sql);
    $codes = array();

    while ($row = mysqli_fetch_row($res)) {
        array_push($codes, $row);
    }

    $out['codes'] = $codes;
}

if ($action == 'show') {
    $sql = "SELECT * FROM cuentasingresosccpet_cab ORDER BY cuentasingresosccpet_cab.id_clasificador ASC";
    $res = mysqli_query($linkbd, $sql);
    $clasificadores = array();

    while ($row = mysqli_fetch_row($res)) {
        array_push($clasificadores, $row);
    }

    $out['clasificadores'] = $clasificadores;
}

if ($action == 'insert_cab') {
    $nombre = $_POST['nombre_clasificador'];
    date_default_timezone_set('America/Bogota');
    $fecha_creacion = date("Y-m-d");
    $estado = 1;
    $sql = "INSERT INTO cuentasingresosccpet_cab(nombre, estado, fecha_creacion) VALUES ('$nombre', $estado, '$fecha_creacion')";
    $res = mysqli_query($linkbd, $sql);
    $out['id_cab'] =  mysqli_insert_id($linkbd);
}

if ($action == 'insert_det') {
    $id_cuentasingreso = $_POST['id_cuentasingreso'];
    $id_clasificador = $_POST['id_clasificador'];
    $sql = "INSERT INTO cuentasingresosccpet_det (id_cuentasingreso, id_clasificador) VALUES ($id_cuentasingreso, $id_clasificador)";
    $res = mysqli_query($linkbd, $sql);
}


if ($action == 'search') {
    $keyword = $_POST['keyword'];
    $sql = "SELECT * FROM cuentasingresosccpet_cab WHERE concat_ws(' ', nombre) LIKE '%$keyword%'";
    $res = mysqli_query($linkbd, $sql);
    $clasificadores = array();

    while ($row = mysqli_fetch_row($res)) {
        array_push($clasificadores, $row);
    }

    $out['clasificadores'] = $clasificadores;
}

if ($action == 'search_clasificador_det') {
    $id_clasificador = $_POST['id_clasificador'];
    $sql = "SELECT PR.codigo, PR.nombre, PR.tipo FROM cuentasingresosccpet AS PR, cuentasingresosccpet_det AS DET WHERE PR.id = DET.id_cuentasingreso AND DET.id_clasificador = $id_clasificador ORDER BY PR.codigo ASC";
    // $sql = "SELECT * FROM cuentasingresosccpet_det WHERE concat_ws(' ', id_clasificador) LIKE $id_clasificador ORDER BY id_cuentasingreso ASC";
    $res = mysqli_query($linkbd, $sql);
    $clasificadores_det = array();

    while ($row = mysqli_fetch_row($res)) {
        array_push($clasificadores_det, $row);
    }

    $out['clasificadores_det'] = $clasificadores_det;
}



if($action == 'delete'){
    $id_clasificador=$_POST['id_clasificador'];   
    $query_delete_det = "DELETE FROM cuentasingresosccpet_det WHERE id_clasificador = $id_clasificador";
    $query_delete_cab = "DELETE FROM cuentasingresosccpet_cab WHERE id_clasificador = $id_clasificador";
    $query_delete_clasi = "DELETE FROM ccpetclasificadores WHERE id = $id_clasificador";
    mysqli_query($linkbd,$query_delete_det);
    mysqli_query($linkbd,$query_delete_cab);
    mysqli_query($linkbd,$query_delete_clasi);
}

//var_dump($out);
header("Content-type: application/json");
echo json_encode($out);
die();
