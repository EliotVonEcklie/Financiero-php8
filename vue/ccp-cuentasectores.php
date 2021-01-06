<?php 
require '../comun.inc';
$linkbd = conectar_v7();

$out = array('error' => false);
// $codigo = "";

if(isset($_GET['action'])){
	$action=$_GET['action'];
}

if(isset($_GET['codigo'])){
	$codigo=$_GET['codigo'];
}

if(isset($_GET['mostrar_sectores'])){ 
    // $sql="SELECT * FROM ccpetsectores";
    $sql="SELECT * FROM ccpetsectores LEFT JOIN ccpet_cuentasectores 
ON ccpetsectores.codigo = (SELECT ccpet_cuentasectores.id_sector FROM ccpet_cuentasectores
WHERE ccpetsectores.codigo = ccpet_cuentasectores.id_sector AND ccpet_cuentasectores.id_sector =  ccpetsectores.codigo) 
WHERE ccpet_cuentasectores.id_sector IS NULL";
    $res=mysqli_query($linkbd,$sql);
    $sectores = array();

    while($row=mysqli_fetch_row($res))
    {
        array_push($sectores, $row);
    }

	$out['sectores'] = $sectores;
}

if(isset($_GET['mostrar_cuentas'])){
    $sql="SELECT cuenta, nombre FROM cuentasnicsp WHERE LENGTH(cuenta) = 4 AND LEFT(cuenta, 2) = 55";
    $res=mysqli_query($linkbd,$sql);
    $cuentas = array();

    while($row=mysqli_fetch_row($res))
    {
        array_push($cuentas, $row);
    }

    $out['cuentas'] = $cuentas;
}

if(isset($_GET['mostrar_cuentasectores'])){
    $sql="SELECT ccpet_cuentasectores.id, id_sector, S.nombre, id_cuenta, C.nombre 
    FROM ccpet_cuentasectores, ccpetsectores AS S, cuentasnicsp  AS C
    WHERE id_sector = S.codigo AND id_cuenta = C.cuenta ORDER BY ccpet_cuentasectores.id ASC";
    $res=mysqli_query($linkbd,$sql);
    $cuenta_sectores = array();

    while($row=mysqli_fetch_row($res))
    {
        array_push($cuenta_sectores, $row);
    }

    $out['cuenta_sectores'] = $cuenta_sectores;
}

if($action == 'validar_cuentasector'){
    $sector = $_POST['codigo'];
	$sql="SELECT id_sector FROM ccpet_cuentasectores WHERE id_sector = '$sector'";
    $res=mysqli_query($linkbd,$sql);
    // $validar = array();

	// while()
    // {
    //     array_push($validar, $row);
    // }

	$out['validar'] = $row=mysqli_fetch_row($res);
}

if($action == 'insert'){
    $sector=$_POST['cod_sector'];
    $cuenta=$_POST['cod_cuenta'];
    $sql="INSERT INTO ccpet_cuentasectores (id_sector, id_cuenta) VALUES ('$sector', '$cuenta')";
    $res=mysqli_query($linkbd,$sql);
    $codigos = array();
}


if($action == 'delete'){
    $id_cuentasector=$_POST['id_cuentasector'];
    $sql="DELETE FROM ccpet_cuentasectores WHERE ccpet_cuentasectores.id = '$id_cuentasector'";
    $res=mysqli_query($linkbd,$sql);
}

if($action=='search'){ 
    $keyword=$_POST['keyword'];
	$sql="SELECT * FROM ccpetsectores LEFT JOIN ccpet_cuentasectores 
    ON ccpetsectores.codigo = (SELECT ccpet_cuentasectores.id_sector FROM ccpet_cuentasectores
    WHERE ccpetsectores.codigo = ccpet_cuentasectores.id_sector AND ccpet_cuentasectores.id_sector =  ccpetsectores.codigo)  WHERE ccpet_cuentasectores.id_sector IS NULL AND concat_ws(' ', codigo, nombre) LIKE '%$keyword%' AND version=(SELECT MAX(version) FROM ccpet_cuin )";
    $res=mysqli_query($linkbd,$sql);
    $codigos = array();

	while($row=mysqli_fetch_row($res))
    {
        array_push($codigos, $row);
    }

	$out['codigos'] = $codigos;
}

// var_dump($out);
header("Content-type: application/json");
echo json_encode($out);
die();
