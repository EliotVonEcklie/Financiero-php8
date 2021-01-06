<?php 
require '../comun.inc';
$linkbd = conectar_v7();

$out = array('error' => false);

$action = "show";
$seccion = "";
$division = "";
$grupo = "";
$clase = "";
$subClase = "";

if(isset($_GET['action'])){
	$action=$_GET['action'];
}

if(isset($_GET['seccion'])){
	$seccion = $_GET['seccion'];
}

if(isset($_GET['division'])){
	$division = $_GET['division'];
}

if(isset($_GET['grupo'])){
	$grupo = $_GET['grupo'];
}

if(isset($_GET['clase'])){
	$clase = $_GET['clase'];
}

if(isset($_GET['subClase'])){
	$subClase = $_GET['subClase'];
}

if($action=='show'){ 
    $sql="SELECT grupo, titulo FROM ccpetbienestransportables WHERE version=(SELECT MAX(version) FROM ccpetbienestransportables ) AND padre=''";
    $res=mysqli_query($linkbd,$sql);
    $secciones = array();

    while($row=mysqli_fetch_row($res))
    {
        array_push($secciones, $row);
    }

	$out['secciones'] = $secciones;
}

if($action=='buscaNombre'){ 
    
    $_POST = json_decode(array_keys($_POST)[0], true);
    $nombreBuscar=$_POST['name'];
    $sql="SELECT titulo FROM ccpetbienestransportables WHERE grupo='$nombreBuscar' AND version=(SELECT MAX(version) FROM ccpetbienestransportables )";
    $res=mysqli_query($linkbd,$sql);
    $nombreCodigo = array();

    while($row=mysqli_fetch_row($res))
    {
        $nombreCodigo = $row[0];
    }

	$out['nombreCodigo'] = $nombreCodigo;
}

if($action=='searchSeccion'){
	$keyword=$_POST['keyword'];
	$sql="SELECT grupo, titulo FROM ccpetbienestransportables WHERE concat_ws(' ', grupo, titulo) like '%$keyword%' AND version=(SELECT MAX(version) FROM ccpetbienestransportables ) AND padre=''";
    $res=mysqli_query($linkbd,$sql);
    $secciones = array();

	while($row=mysqli_fetch_row($res))
    {
        array_push($secciones, $row);
    }

	$out['secciones'] = $secciones;
}

if($action=='searchDivision'){
    $keyword=$_POST['keywordDivision'];
    $grupoSearch = $_GET['grupoSearch'];
	$sql="SELECT grupo, titulo FROM ccpetbienestransportables WHERE concat_ws(' ', grupo, titulo) like '%$keyword%' AND version=(SELECT MAX(version) FROM ccpetbienestransportables ) AND padre='$grupoSearch'";
    $res=mysqli_query($linkbd,$sql);
    $divisiones = array();

    while($row=mysqli_fetch_row($res))
    {
        array_push($divisiones, $row);
    }

	$out['divisiones'] = $divisiones;
}

if($action=='searchGrupo'){

    $keywordGrupo = $_POST['keywordGrupo'];
    $divisionSearch = $_GET['divisionSearch'];

    $sql="SELECT grupo, titulo FROM ccpetbienestransportables WHERE concat_ws(' ', grupo, titulo) like '%$keywordGrupo%' AND version=(SELECT MAX(version) FROM ccpetbienestransportables ) AND padre='$divisionSearch'";
    
    $res=mysqli_query($linkbd,$sql);
    $grupos = array();

    while($row=mysqli_fetch_row($res))
    {
        array_push($grupos, $row);
    }

	$out['grupos'] = $grupos;
}

if($action=='searchClase'){

    $keywordClase = $_POST['keywordClase'];
    $grupoSearch = $_GET['grupoSearch'];

    $sql="SELECT grupo, titulo FROM ccpetbienestransportables WHERE concat_ws(' ', grupo, titulo) like '%$keywordClase%' AND version=(SELECT MAX(version) FROM ccpetbienestransportables ) AND padre='$grupoSearch'";
    
    $res=mysqli_query($linkbd,$sql);
    $clases = array();

    while($row=mysqli_fetch_row($res))
    {
        array_push($clases, $row);
    }

	$out['clases'] = $clases;
}


if($action=='searchSubClase'){

    $keywordSubClase = $_POST['keywordSubClase'];
    $subClaseSearch = $_GET['subClaseSearch'];

    $sql="SELECT grupo, titulo, ciiu, sistema_armonizado, cpc FROM ccpetbienestransportables WHERE concat_ws(' ', grupo, titulo) like '%$keywordSubClase%' AND version=(SELECT MAX(version) FROM ccpetbienestransportables ) AND padre='$subClaseSearch'";
    
    $res=mysqli_query($linkbd,$sql);
    $subClases = array();

    while($row=mysqli_fetch_row($res))
    {
        array_push($subClases, $row);
    }

	$out['subClases'] = $subClases;
}

if($action=='searchGeneral'){

    $keywordGeneral = $_POST['keywordGeneral'];
    
    $sql = "SELECT grupo, titulo, ciiu, sistema_armonizado, cpc,ud FROM ccpetbienestransportables WHERE concat_ws(' ', grupo, titulo) like '%$keywordGeneral%' AND version=(SELECT MAX(version) FROM ccpetbienestransportables ) AND LENGTH(grupo) = 7";
    
    $res = mysqli_query($linkbd,$sql);
    $subClasesGeneral = array();

    while($row=mysqli_fetch_row($res))
    {
        array_push($subClasesGeneral, $row);
    }

	$out['subClasesGeneral'] = $subClasesGeneral;
}

if($seccion != "")
{
    $sqlr = "SELECT grupo, titulo FROM ccpetbienestransportables WHERE padre = '$seccion'";
    //var_dump($sector); 
    $res=mysqli_query($linkbd,$sqlr);
    $divisiones = array();

    while($row=mysqli_fetch_row($res))
    {
        array_push($divisiones, $row);
    }

	$out['divisiones'] = $divisiones;
}

if($division != "")
{
    $sqlr = "SELECT grupo, titulo FROM ccpetbienestransportables WHERE padre = '$division'";
    //var_dump($sector); 
    $res=mysqli_query($linkbd,$sqlr);
    $grupos = array();

    while($row=mysqli_fetch_row($res))
    {
        array_push($grupos, $row);
    }

	$out['grupos'] = $grupos;
}

if($grupo != "")
{
    $sqlr = "SELECT grupo, titulo FROM ccpetbienestransportables WHERE padre = '$grupo'";
    //var_dump($sector); 
    $res=mysqli_query($linkbd,$sqlr);
    $clases = array();

    while($row=mysqli_fetch_row($res))
    {
        array_push($clases, $row);
    }

	$out['clases'] = $clases;
}

if($clase != "")
{
    $sqlr = "SELECT grupo, titulo, ciiu, sistema_armonizado, cpc FROM ccpetbienestransportables WHERE padre = '$clase'";
    //var_dump($sector); 
    $res=mysqli_query($linkbd,$sqlr);
    $subClases = array();

    while($row=mysqli_fetch_row($res))
    {
        array_push($subClases, $row);
    }

	$out['subClases'] = $subClases;
}

if($subClase != "")
{
    $sqlr = "SELECT grupo, titulo, ud FROM ccpetbienestransportables WHERE padre = '$subClase'";
    //var_dump($sector); 
    $res=mysqli_query($linkbd,$sqlr);
    $subClases_captura = array();

    while($row=mysqli_fetch_row($res))
    {
        array_push($subClases_captura, $row);
    }

	$out['subClases_captura'] = $subClases_captura;
}

header("Content-type: application/json");
echo json_encode($out);
die();