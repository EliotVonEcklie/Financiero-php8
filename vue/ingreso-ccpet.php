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

if($action=='show'){ 
    $sql="SELECT * FROM cuentasingresosccpet WHERE nivel=2";
    $res=mysqli_query($linkbd,$sql);
    $codigos = array();

    while($row=mysqli_fetch_row($res))
    {
        array_push($codigos, $row);
    }

	$out['codigos'] = $codigos;
}

if(isset($_GET['nombre'])){
    $codigo_nivel = $_GET['nombre'];
    $sql="SELECT nombre FROM cuentasingresosccpet WHERE codigo='$codigo_nivel' ";
    $res=mysqli_query($linkbd,$sql);
	$out['nombre'] = $row=mysqli_fetch_row($res);
}

if($codigo != ""){
    //$padre=$_POST['padre'];
    //var_dump($padre);
    $sql="SELECT * FROM cuentasingresosccpet WHERE padre='$codigo' ";
    $res=mysqli_query($linkbd,$sql);
    $codigos = array();

    while($row=mysqli_fetch_row($res))
    {
        array_push($codigos, $row);
    }

	$out['codigos'] = $codigos;
}

if($action=='search'){
	$keyword=$_POST['keyword'];
	$sql="SELECT * FROM cuentasingresosccpet WHERE nombre like '%$keyword%' AND tipo like 'C'";
    $res=mysqli_query($linkbd,$sql);
    $codigos = array();

	while($row=mysqli_fetch_row($res))
    {
        array_push($codigos, $row);
    }

	$out['codigos'] = $codigos;
}

header("Content-type: application/json");
echo json_encode($out);
die();
