<?php 
require '../comun.inc';
$linkbd = conectar_v7();

$out = array('error' => false);

$action = "show";
$sector = "";
$programa = "";

if(isset($_GET['action'])){
	$action=$_GET['action'];
}

if(isset($_GET['sector'])){
	$sector = $_GET['sector'];
}

if(isset($_GET['programa'])){
	$programa = $_GET['programa'];
}

if($action=='show'){ 
    $sql="SELECT codigo, nombre, aplicacion FROM ccpetsectores WHERE version=(SELECT MAX(version) FROM ccpetsectores )";
    $res=mysqli_query($linkbd,$sql);
    $codigos = array();

    while($row=mysqli_fetch_row($res))
    {
        array_push($codigos, $row);
    }

	$out['codigos'] = $codigos;
}

if($action=='unidadejecutora'){ 
    $sql="SELECT * FROM pptouniejecu WHERE estado = 'S' ORDER BY id_cc ASC";
    $res=mysqli_query($linkbd,$sql);
    $unidadesejecutoras = array();

    while($row=mysqli_fetch_row($res))
    {
        array_push($unidadesejecutoras, $row);
    }

	$out['unidadesejecutoras'] = $unidadesejecutoras;
}

if($action=='searchSector'){
	$keyword=$_POST['keyword'];
	$sql="SELECT codigo, nombre, aplicacion FROM ccpetsectores WHERE nombre like '%$keyword%' AND version=(SELECT MAX(version) FROM ccpetsectores )";
    $res=mysqli_query($linkbd,$sql);
    $codigos = array();

	while($row=mysqli_fetch_row($res))
    {
        array_push($codigos, $row);
    }

	$out['codigos'] = $codigos;
}

if($action=='searchProgram'){
    $keyword=$_POST['keywordProgram'];
    $sectorSearch = $_GET['sectorSearch'];
	$sql="SELECT codigo, nombre, codigo_subprograma, nombre_subprograma, aplicacion FROM ccpetprogramas WHERE nombre like '%$keyword%' AND LEFT(codigo,2) = '$sectorSearch'";
    $res=mysqli_query($linkbd,$sql);
    $programas = array();

    while($row=mysqli_fetch_row($res))
    {
        array_push($programas, $row);
    }

	$out['programas'] = $programas;
}

if($action=='searchProduct'){

    $keywordProduct = $_POST['keywordProduct'];
    $programSearch = $_GET['programSearch'];

    $sql="SELECT cod_producto, producto, descripcion, medio_a_traves, codigo_indicador, indicador_producto, unidad_medida, indicador_principal FROM ccpetproductos WHERE producto like '%$keywordProduct%' AND LEFT(cod_producto,4) = '$programSearch'";
    
    $res=mysqli_query($linkbd,$sql);
    $productos = array();

    while($row=mysqli_fetch_row($res))
    {
        array_push($productos, $row);
    }

	$out['productos'] = $productos;
}

if($action=='searchCuentaPresupuestal'){

    $padre='2.3';
    $keyword = $_POST['keywordCuentaPresupuestal'];
	$sql="SELECT codigo, nombre, tipo FROM cuentasccpet WHERE codigo LIKE '$padre%' AND nombre LIKE '%$keyword%' ORDER BY id";
	$res=mysqli_query($linkbd,$sql);
	$cuentaspresu = array();
	while($row=mysqli_fetch_row($res))
	{
		array_push($cuentaspresu, $row);
	}
	$out['cuentaspresu'] = $cuentaspresu;

}

if($sector != "")
{
    $sqlr = "SELECT codigo, nombre, codigo_subprograma, nombre_subprograma, aplicacion FROM ccpetprogramas WHERE LEFT(codigo,2) = '$sector'";
    //var_dump($sector); 
    $res=mysqli_query($linkbd,$sqlr);
    $programas = array();

    while($row=mysqli_fetch_row($res))
    {
        array_push($programas, $row);
    }

	$out['programas'] = $programas;
}

if($programa != "")
{
    $sqlr = "SELECT cod_producto, producto, descripcion, medio_a_traves, codigo_indicador, indicador_producto, unidad_medida, indicador_principal FROM ccpetproductos WHERE LEFT(cod_producto,4) = '$programa'";
    //var_dump($sector); 
    $res=mysqli_query($linkbd,$sqlr);
    $productos = array();

    while($row=mysqli_fetch_row($res))
    {
        array_push($productos, $row);
    }

	$out['productos'] = $productos;
}

header("Content-type: application/json");
echo json_encode($out);
die();