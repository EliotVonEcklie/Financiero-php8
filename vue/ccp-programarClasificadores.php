<?php 
require '../comun.inc';
$linkbd = conectar_v7();

$out = array('error' => false);

$action = "show";
$codigo = "";

if(isset($_GET['codigo'])){
	$codigo = $_GET['codigo'];
}
 
if(isset($_GET['action'])){
	$action = $_GET['action'];
}

if($action=='buscarCuenta'){ 

    $cuenta=$_GET['cuenta'];
    $sql="SELECT codigo, nombre FROM cuentasingresosccpet WHERE version=(SELECT MAX(version) FROM cuentasingresosccpet ) AND codigo LIKE '$cuenta%'";
    $res=mysqli_query($linkbd,$sql);
    $cuentas = array();

    while($row=mysqli_fetch_row($res))
    {
        array_push($cuentas, $row);
    }

    $sql_C="SELECT clasificadores FROM ccpetprogramarclasificadores WHERE cuenta = '$cuenta'";
    $res_C = mysqli_query($linkbd,$sql_C);
    $clasificadores = array();

    while($row_C=mysqli_fetch_row($res_C))
    {
        array_push($clasificadores, $row_C);
    }

    $out['cuentas'] = $cuentas;
    $out['clasificadores'] = $clasificadores;
}

if($action=='buscarClasificadores'){ 

    $cuenta=$_GET['cuentaC'];
    $sql="SELECT clasificadores FROM ccpetprogramarclasificadores WHERE cuenta = '$cuenta'";
    $res=mysqli_query($linkbd,$sql);
    $row=mysqli_fetch_row($res);

    $clasificadores_separados = explode(",", $row[0]);
    $nomClasi = array();

    for($i = 0; $i < count($clasificadores_separados); $i++)
    {
        $sql_c = "SELECT nombre FROM ccpetclasificadores WHERE id = '$clasificadores_separados[$i]'";
        $res_c = mysqli_query($linkbd, $sql_c);
        $row_c = mysqli_fetch_row($res_c);
        $nomClasi[] = $row_c[0];
    }
    $cadena = implode(" - ", $nomClasi);
    $out['nomClasi'] = $cadena; 
}

if($codigo != ""){
    $sql="SELECT * FROM cuentasingresosccpet WHERE padre='$codigo' ";
    $res=mysqli_query($linkbd,$sql);
    $codigos = array();
    $nomClasi = array();
    while($row=mysqli_fetch_row($res))
    {
        $sql_cP = "SELECT clasificadores FROM ccpetprogramarclasificadores WHERE cuenta = '$row[1]'";
        $res_cP = mysqli_query($linkbd,$sql_cP);
        $row_cP = mysqli_fetch_row($res_cP);

        $clasificadores_separados = explode(",", $row_cP[0]);
        
        $nomClasi_concat = array();
        $cadena = '';
        for($i = 0; $i < count($clasificadores_separados); $i++)
        {
            $sql_c = "SELECT nombre FROM ccpetclasificadores WHERE id = '$clasificadores_separados[$i]'";
            $res_c = mysqli_query($linkbd, $sql_c);
            $row_c = mysqli_fetch_row($res_c);
            $nomClasi_concat[] = $row_c[0];
        }

        $cadena = implode(" - ", $nomClasi_concat);
        $nomClasi[$row[1]] = $cadena;

        array_push($codigos, $row);
    }
    $out['nomClasi'] = $nomClasi;
	$out['codigos'] = $codigos;
}

if($action=='guardarClasificadores'){ 
    $clasificadores=$_POST['clasificadores'];
    $cuentas=$_POST['cuentas'];
    $cuentas_separadas = explode(",", $cuentas);
    for($i = 0; $i < count($cuentas_separadas); $i++)
    {
        $sql="DELETE FROM ccpetprogramarclasificadores WHERE cuenta = '$cuentas_separadas[$i]'";
        mysqli_query($linkbd,$sql);
        $sql="INSERT INTO  ccpetprogramarclasificadores (cuenta, clasificadores) VALUES ('$cuentas_separadas[$i]', '$clasificadores')";
        if(mysqli_query($linkbd,$sql))
        {
            $out['insertaBien'] = true; 
        }
        else
        {
            $out['insertaBien'] = false; 
        }
    }
}

if($action=='buscarNombreClasificadores'){ 
    $clasificador=$_GET['codigoC'];
    $clasificadores_separados = explode(",", $clasificador);
    $nomClasi = array();

    for($i = 0; $i < count($clasificadores_separados); $i++)
    {
        $sql_c = "SELECT nombre FROM ccpetclasificadores WHERE id = '$clasificadores_separados[$i]'";
        $res_c = mysqli_query($linkbd, $sql_c);
        $row_c = mysqli_fetch_row($res_c);
        $nomClasi[] = $row_c[0];
    }
    $cadena = implode(" - ", $nomClasi);
    $out['nomClasi'] = $cadena; 
}

if($action=='list_clasi'){ 
    $sql = "SELECT * FROM ccpetclasificadores ORDER BY id";
    $res = mysqli_query($linkbd, $sql);
    $list_clasi = array();

    while($row=mysqli_fetch_row($res))
    {
        array_push($list_clasi, $row);
    }

	$out['list_clasi'] = $list_clasi;
}

if($action == "traeDatosCodigo"){
    $code=$_POST['code'];
    $sql="SELECT * FROM cuentasingresosccpet WHERE version=( SELECT MAX(version) FROM cuentasingresosccpet ) AND codigo = '$code'";
    $res=mysqli_query($linkbd,$sql);
    $codes = array();

    while($row=mysqli_fetch_row($res))
    {
        array_push($codes, $row);
    }

	$out['codes'] = $codes;
}

if($action == "traeDatosCodigoPadre"){ 
    $code = $_POST['codepadre'];
    $sql="SELECT * FROM cuentasingresosccpet WHERE version=( SELECT MAX(version) FROM cuentasingresosccpet ) AND padre = '$code' LIMIT 1";
    $res=mysqli_query($linkbd,$sql);
    $codespadre = array();

    while($row=mysqli_fetch_row($res))
    {
        array_push($codespadre, $row);
    }

	$out['codespadre'] = $codespadre;
}

header("Content-type: application/json");
echo json_encode($out);
die();