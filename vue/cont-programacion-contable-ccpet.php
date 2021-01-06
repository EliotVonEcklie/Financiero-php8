<?php 
require '../comun.inc';
$linkbd = conectar_v7();

$out = array('error' => false);

$action = "show";

if(isset($_GET['action'])){
	$action = $_GET['action'];
}

if($action == 'show'){
    $vigencia = $_GET['vigencia'];
    $unidadEjecutora = $_GET['unidadEjecutora'];
    $medioPago = $_GET['medioPago'];
    $sql = "SELECT codigo, nombre, tipo FROM cuentasccpet WHERE municipio=1 AND codigo NOT LIKE '%2.3%' UNION SELECT codigo, nombre, tipo FROM cuentasccpet WHERE municipio=1 AND codigo LIKE '%2.3.1%'";
    $res=mysqli_query($linkbd,$sql);
    $gastos = array();
    $valorPorCuenta = array();

    while($row=mysqli_fetch_row($res))
    {
        $sql_cuenta = "SELECT concepto_cont FROM ccpetcuentas_concepto_contable WHERE estado='S' AND cuenta_p LIKE '%$row[0]%'";
        $res_cuenta = mysqli_query($linkbd, $sql_cuenta);
        $row_cuenta = mysqli_fetch_row($res_cuenta);
        $valorPorCuenta[$row[0]] = $row_cuenta[0];

        array_push($gastos, $row);
    }
    $out['gastos'] = $gastos;
    $out['valorPorCuenta'] = $valorPorCuenta;
}

if($action == 'buscarClasificadores'){
    $cuenta = $_GET['cuentaIngreso'];
    $cuenta_tipo = substr($cuenta, 0, 3);
    $cuenta_tipo2 = substr($cuenta,0, 5);
    $cuenta_tipo3 = substr($cuenta,0, 8);
    $tipo="";
    if ($cuenta_tipo=='2.2') {
        $tipo='SD';
    }
    elseif ($cuenta_tipo2=='2.1.5') {
        $tipo='GO';
    }
    elseif ($cuenta_tipo3=='2.1.1.01') {
        $tipo='F';
    }
    elseif ($cuenta_tipo3=='2.1.1.02') {
        $tipo='FT';
    }
    elseif($cuenta_tipo2=='2.1.2'|| $cuenta_tipo2=='2.1.3'|| $cuenta_tipo2=='2.1.4'|| $cuenta_tipo2=='2.1.6'|| $cuenta_tipo2=='2.1.7'|| $cuenta_tipo2=='2.1.8'){
        $tipo='GF'; 
    }
    elseif($cuenta_tipo3=='2.3.1.01'){
        $tipo='IN';
    }
    elseif($cuenta_tipo3=='2.3.1.02'){
        $tipo='IT';
    }
    else{
        $tipo='404';
        array_push($out['insertaBien'], "404 TYPE NOT FOUND", " ");
        array_push($out['insertaBienDebug'], "[guardarTotal] 404 TYPE NOT FOUND");
    }

    $sql = "SELECT codigo, nombre, tipo FROM conceptoscontables WHERE tipo = '$tipo'";
    $res = mysqli_query($linkbd, $sql); //echo $sql;
    $codigosDet = array();


    while ($row = mysqli_fetch_row($res)) {
        array_push($codigosDet, $row);
    }

    $out['codigo'] = $codigosDet;
    
}

if($action=='searchFuente'){ 
    $tipoCuenta = $_GET['tipoCuenta'];
    $cuentaTipo1 = substr($tipoCuenta,0, 3);
    $cuentaTipo2 = substr($tipoCuenta,0, 5);
    $cuentaTipo3 = substr($tipoCuenta,0, 8);
    $tipo2="";
    if ($cuentaTipo1=='2.2') {
        $tipo2="SD";
    }
    elseif ($cuentaTipo2=='2.1.5') {
        $tipo2="GO";
    }
    elseif ($cuentaTipo3=='2.1.1.01') {
        $tipo2="F";
    }
    elseif ($cuentaTipo3=='2.1.1.02') {
        $tipo2="FT";
    }
    elseif($cuentaTipo2=='2.1.2'|| $cuentaTipo2=='2.1.3'|| $cuentaTipo2=='2.1.4'|| $cuentaTipo2=='2.1.6'|| $cuentaTipo2=='2.1.7'|| $cuentaTipo2=='2.1.8' ){
        $tipo2="GF";
    }
    elseif($cuentaTipo3=='2.3.1.01'){
        $tipo2="IN";
    }
    elseif($cuentaTipo3=='2.3.1.02'){
        $tipo2="IT";
    }
    else{
        $tipo2="404";
        array_push($out['insertaBien'], "404 TYPE NOT FOUND", " ");
        array_push($out['insertaBienDebug'], "[guardarTotal] 404 TYPE NOT FOUND");
    }

    $keywordFuente=$_POST['keywordFuente'];
    $sql="SELECT * FROM conceptoscontables WHERE nombre LIKE '%$keywordFuente%' AND tipo = '$tipo2' ";
    $res=mysqli_query($linkbd,$sql);//echo $sql;
    $codigosDet = array();

	while($row=mysqli_fetch_row($res))
    {
        array_push($codigosDet, $row);
    }

	$out['codigos'] = $codigosDet;
}


if($action=='guardarValorSolo'){

    $sqlr = "UPDATE ccpetcuentas_concepto_contable SET estado = 'N' WHERE cuenta_p='".$_POST['cuentaPresupuestal']."'";
    mysqli_query($linkbd, $sqlr);//echo $sqlr;

    $now = date("Y-m-d");

    $sql = "INSERT INTO ccpetcuentas_concepto_contable (cuenta_p, concepto_cont, tipo, estado, fecha) VALUE ('".$_POST['cuentaPresupuestal']."', '".$_POST['conceptoContable']."', '".$_POST['tipo']."', 'S', '".$now."')";
    if(mysqli_query($linkbd, $sql))
    {
        array_push($out['insertaBien'], "200 OK", " ");
        array_push($out['insertaBienDebug'], "[guardarTotal] 200 OK");
    }
    
    
}

if($action=='guardarTotal')
{ 

    $conceptoContable = [];
    $out['insertaBien'] = [];
    $out['insertaBienDebug'] = [];

    for ($i = 0; $i < count($_POST['conceptoContable']); $i++)
    {
        $conceptoContable[$i] = preg_split('/(,)/', $_POST['conceptoContable'][$i]);
    }

    if(is_array($conceptoContable))
    {
       for ($i = 0; $i < count($conceptoContable); $i++)
       {
            if(is_array($conceptoContable[$i]))
            {
                $cuentaTipoA = substr($conceptoContable[$i][0], 0, 3);
                $cuentaTipoB = substr($conceptoContable[$i][0], 0, 5);
                $cuentaTipoC = substr($conceptoContable[$i][0], 0, 8);

                $tipoCuentaPresupuestal;

                if ($cuentaTipoA=='2.2') {
                    $tipoCuentaPresupuestal="SD";
                }
                elseif ($cuentaTipoB=='2.1.5') {
                    $tipoCuentaPresupuestal="GO";
                }
                elseif ($cuentaTipoC=='2.1.1.01') {
                    $tipoCuentaPresupuestal="F";
                }
                elseif ($cuentaTipoC=='2.1.1.02') {
                    $tipoCuentaPresupuestal="FT";
                }
                elseif($cuentaTipoB=='2.1.2' || $cuentaTipoB=='2.1.3'|| $cuentaTipoB=='2.1.4'|| $cuentaTipoB=='2.1.6'|| $cuentaTipoB=='2.1.7'|| $cuentaTipoB=='2.1.8'){
                    $tipoCuentaPresupuestal="GF";
                }
                elseif($cuentaTipoC=='2.3.1.01'){
                    $tipoCuentaPresupuestal="IN";
                }
                elseif($cuentaTipoC=='2.3.1.02'){
                    $tipoCuentaPresupuestal="IT";
                }
                else{
                    $tipoCuentaPresupuestal="404";
                    array_push($out['insertaBien'], "404 TYPE NOT FOUND", " ");
                    array_push($out['insertaBienDebug'], "[guardarTotal][".$i."] 404 TYPE NOT FOUND");
                }

                if($conceptoContable[$i][2] == 'C')
                {
                    $sqlr = "SELECT concepto_cont FROM ccpetcuentas_concepto_contable WHERE cuenta_p='".$conceptoContable[$i][0]."' AND tipo='".$tipoCuentaPresupuestal."' AND estado='S'";
                    $res = mysqli_query($linkbd, $sqlr);

                    $conceptoContableRow = mysqli_fetch_row($res);

                    $sqlr = "SELECT codigo FROM conceptoscontables WHERE codigo = '".$conceptoContable[$i][1]."' AND tipo = '".$tipoCuentaPresupuestal."'";
                    $res = mysqli_query($linkbd, $sqlr);

                    $codigoRow = mysqli_fetch_row($res);

                    if($codigoRow[0] != null || $codigoRow[0] != "" || is_array($codigoRow) || $conceptoContable[$i][1] == null || $conceptoContable[$i][1] == "")
                    {
                        if($conceptoContableRow[0] != $conceptoContable[$i][1])
                        {
                            $sqlr = "UPDATE ccpetcuentas_concepto_contable SET estado = 'N' WHERE cuenta_p='".$conceptoContable[$i][0]."' AND tipo = '$tipoCuentaPresupuestal'";
                            mysqli_query($linkbd, $sqlr);
                
                            $now = date("Y-m-d");
                
                            $sql = "INSERT INTO ccpetcuentas_concepto_contable (cuenta_p, concepto_cont, tipo, estado, fecha) VALUE ('".$conceptoContable[$i][0]."', '".$conceptoContable[$i][1]."', '".$tipoCuentaPresupuestal."', 'S', '".$now."')";
                            if(mysqli_query($linkbd, $sql))
                            {
                                array_push($out['insertaBien'], "200 OK", " ");
                                array_push($out['insertaBienDebug'], "[guardarTotal][".$i."] 200 OK");
                            } 
                            else
                            {
                                array_push($out['insertaBien'], "400 SQL QUERY ERROR", " ");
                                array_push($out['insertaBienDebug'], "[guardarTotal][".$i."] 400 SQL QUERY ERROR");
                            }
                        }
                        else
                        {
                            array_push($out['insertaBien'], "300 IGNORED", " ");
                            array_push($out['insertaBienDebug'], "[guardarTotal][".$i."] 300 IGNORED");
                        }
                    }
                    else
                    {
                        array_push($out['insertaBien'], "401 INVALID DATA VALUE ERROR", "El codigo insertado (".$conceptoContable[$i][1].") en la cuenta ".$conceptoContable[$i][0]." no es valido!");
                        array_push($out['insertaBienDebug'], "[guardarTotal][".$i."] 401 INVALID DATA VALUE ERROR");
                    }
                }
                else
                {
                    array_push($out['insertaBien'], "302 INVALID DATA TYPE", " ");
                    array_push($out['insertaBienDebug'], "[guardarTotal][".$i."] 302 INVALID DATA TYPE");
                }
            }
            else
            {
                array_push($out['insertaBien'], "403 DATA COUNT MISMATCH ERROR", " ");
                array_push($out['insertaBienDebug'], "[guardarTotal][".$i."] 403 DATA COUNT MISMATCH ERROR");
            }
        }
    }
    else
    {
        array_push($out['insertarBien'], "402 INVALID DATA STREAM ERROR", " ");
        array_push($out['insertaBienDebug'], "[guardarTotal] 402 INVALID DATA STREAM ERROR");
    }
}



header("Content-type: application/json");
echo json_encode($out);
die();