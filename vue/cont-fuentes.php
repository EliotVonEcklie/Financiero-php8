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
    $sql="SELECT * FROM conceptoscontables WHERE version=(SELECT MAX(version) FROM conceptoscontables )";
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
   	$sql="SELECT * FROM conceptoscontables WHERE nombre LIKE '%$keyword%' AND version=(SELECT MAX(version) FROM conceptoscontables )";
    $res=mysqli_query($linkbd,$sql);
    $codigos = array();

	while($row=mysqli_fetch_row($res))
    {
        array_push($codigos, $row);
    }

    $out['codigos'
    ] = $codigos;
}
header("Content-type: application/json");
echo json_encode($out);
die();
