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
    $sql="SELECT * FROM ccpet_fuentes WHERE version=(SELECT MAX(version) FROM ccpet_fuentes )";
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
   	// $sql="SELECT * FROM ccpet_cuin WHERE (nit like '%$keyword%' || nombre like '%$keyword%') AND version=(SELECT MAX(version) FROM ccpet_cuin )";
	$sql="SELECT * FROM ccpet_fuentes WHERE concat_ws(' ', fuente_financiacion, entidad_financiadora) LIKE '%$keyword%' AND version=(SELECT MAX(version) FROM ccpet_fuentes )";
    $res=mysqli_query($linkbd,$sql);
    $codigos = array();

	while($row=mysqli_fetch_row($res))
    {
        array_push($codigos, $row);
    }

	$out['codigos'] = $codigos;
}
//var_dump($out);
header("Content-type: application/json");
echo json_encode($out);
die();
