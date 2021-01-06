<?php 
require '../../comun.inc';
$linkbd = conectar_v7();
$linkbd -> set_charset("utf8");

$out = array('error' => false);

$action = "show";
$padre="";
$cuenta="";


if(isset($_GET['action'])){
	$action=$_GET['action'];
}

if(isset($_GET['padre'])){
	$padre= $_GET['padre'];
}

if(isset($_GET['cuenta'])){
	$cuenta= $_GET['cuenta'];
}

if($action=='show')
{ 
	if ($padre!=''){$sql="SELECT codigo, nombre, tipo FROM cuentasccpet WHERE codigo LIKE '$padre%' ORDER BY id";}
	else {$sql="SELECT codigo, nombre, tipo FROM cuentasccpet ORDER BY id";}
	$res=mysqli_query($linkbd,$sql);
	$codigos = array();
	while($row=mysqli_fetch_row($res))
	{
		array_push($codigos, $row);
	}
	$out['cuentaspresu'] = $codigos;
}
if($action=='buscaclasificadores')
{
	$sql="SELECT DISTINCT clasificadores FROM ccpetprogramarclasificadoresgastos WHERE cuenta like '2.3%' ORDER BY clasificadores"; 
	$res=mysqli_query($linkbd,$sql);
	$codigos = array();
	while($row=mysqli_fetch_row($res))
	{
		array_push($codigos, $row);
	}
	$out['clasificadores'] = $codigos;
}
if($action=='searchSector')
{
	$keyword=$_POST['keyword'];
	$sql="SELECT codigo, nombre, tipo FROM cuentasccpet WHERE nombre like '%$keyword%' ";
	$res=mysqli_query($linkbd,$sql);
	$codigos = array();
	while($row=mysqli_fetch_row($res))
	{
		array_push($codigos, $row);
	}
	$out['codigos'] = $codigos;
}
if($action=='buscaclasificador')
{
	$sql="SELECT clasificadores FROM ccpetprogramarclasificadoresgastos WHERE cuenta like '$cuenta' ORDER BY clasificadores"; 
	$res=mysqli_query($linkbd,$sql);
	$row=mysqli_fetch_row($res);
	$idclasificador = explode(",",$row[0]);
	$numidecla=count($idclasificador);
	if($numidecla > 0)
	{
		$codigos = array();
		for($x=0;$x < $numidecla;$x++)
		{
			if($idclasificador[$x]!='')
			{
				$sql2="SELECT id,nombre FROM ccpetclasificadores WHERE id='$idclasificador[$x]'";
				$res2=mysqli_query($linkbd,$sql2);
				$row2=mysqli_fetch_row($res2);
				array_push($codigos, $row2);
			}
		}
		$out['cuentaclasifi'] = $codigos;
	}
}

header("Content-type: application/json");
echo json_encode($out);
die();