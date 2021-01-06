<?php 
require '../comun.inc';
$linkbd = conectar_v7();

$out = array('error' => false);

$action = "show";

if(isset($_GET['action'])){
	$action = $_GET['action'];
}

if($action == 'show'){
    $sql = "SELECT id_cc, nombre FROM pptouniejecu WHERE estado='S'";
    $res=mysqli_query($linkbd,$sql);
    $unidades = array();

    while($row=mysqli_fetch_row($res))
    {
        array_push($unidades, $row);
    }

    $out['unidades'] = $unidades;
}

if($action=='searchUnidad'){

    $keywordUnidad = $_POST['keywordUnidad'];
    $sql="SELECT id_cc, nombre FROM pptouniejecu WHERE estado='S' AND nombre like '%$keywordUnidad%'";
    
    $res=mysqli_query($linkbd,$sql);
    $unidades = array();

    while($row=mysqli_fetch_row($res))
    {
        array_push($unidades, $row);
    }

	$out['unidades'] = $unidades;
}

header("Content-type: application/json");
echo json_encode($out);
die();