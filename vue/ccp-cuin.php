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
    $sql="SELECT * FROM ccpet_cuin WHERE version=(SELECT MAX(version) FROM ccpet_cuin)";
    $res=mysqli_query($linkbd,$sql);
    $codigos = array();

    while($row=mysqli_fetch_row($res))
    {
        array_push($codigos, $row);
    }

	$out['codigos'] = $codigos;
}


// if($codigo != ""){
//     //$padre=$_POST['padre'];
//     //var_dump($padre);
//     $sql="SELECT * FROM cuentasingresosccpet WHERE padre='$codigo' ";
//     $res=mysqli_query($linkbd,$sql);
//     $codigos = array();

//     while($row=mysqli_fetch_row($res))
//     {
//         array_push($codigos, $row);
//     }

// 	$out['codigos'] = $codigos;
// }

// if($action=='search'){
// 	$keyword=$_POST['keyword'];
// 	$sql="SELECT * FROM cuentasingresosccpet WHERE nombre like '%$keyword%' AND tipo like 'C'";
//     $res=mysqli_query($linkbd,$sql);
//     $codigos = array();

// 	while($row=mysqli_fetch_row($res))
//     {
//         array_push($codigos, $row);
//     }

// 	$out['codigos'] = $codigos;
// }

if($action=='search'){ 
    $keyword=$_POST['keywordCuin'];
    //var_dump($_POST);
    //echo "dd ".$keyword;
   	// $sql="SELECT * FROM ccpet_cuin WHERE (nit like '%$keyword%' || nombre like '%$keyword%') AND version=(SELECT MAX(version) FROM ccpet_cuin )";
	$sql="SELECT * FROM ccpet_cuin WHERE concat_ws(' ', nit, nombre) LIKE '%$keyword%' AND version=(SELECT MAX(version) FROM ccpet_cuin )";
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
