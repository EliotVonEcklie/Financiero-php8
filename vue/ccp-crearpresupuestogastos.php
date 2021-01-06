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
    $sql = "SELECT codigo, nombre, tipo FROM cuentasccpet WHERE municipio=1 AND codigo NOT LIKE '%2.3%'";
    $res=mysqli_query($linkbd,$sql);
    $gastos = array();
    $valorPorCuenta = array();

    while($row=mysqli_fetch_row($res))
    {
        $sql_cuenta = "SELECT sum(valor_total) FROM ccpetinicialgastos WHERE cuenta like '$row[0]%' AND vigencia = '$vigencia'  AND unidad='$unidadEjecutora' AND medioPago='$medioPago'";
        $res_cuenta = mysqli_query($linkbd, $sql_cuenta);
        $row_cuneta = mysqli_fetch_row($res_cuenta);
        $valorPorCuenta[$row[0]] = $row_cuneta[0];

        array_push($gastos, $row);
    }

    $out['gastos'] = $gastos;
    $out['valorPorCuenta'] = $valorPorCuenta;
}

if($action == 'search'){
    $keyword = $_POST['keyword'];
    $sql = "SELECT * FROM cuentasingresosccpet_cab WHERE concat_ws(' ', nombre) LIKE '%$keyword%'";
    $res = mysqli_query($linkbd, $sql);
    $ingresosBuscados = array();

    while ($row = mysqli_fetch_row($res)) {
        array_push($ingresosBuscados, $row);
    }

    $out['ingresosBuscados'] = $ingresosBuscados;
}

if($action == 'buscarClasificadores'){
    $cuenta = $_GET['cuentaIngreso'];
    $sql = "SELECT clasificadores FROM ccpetprogramarclasificadoresgastos WHERE cuenta = '$cuenta'";
    $res = mysqli_query($linkbd, $sql);
    $clasificadores = array();

    while ($row = mysqli_fetch_row($res)) {
        array_push($clasificadores, $row);
    }

    $out['clasificadores'] = $clasificadores;
}

if($action=='bienesTransportables'){
    
    $sql_count = "SELECT count(id) FROM ccpet_cuin WHERE version=(SELECT MAX(version) FROM ccpet_cuin)";
    $res_count = mysqli_query($linkbd,$sql_count);
    $row_count = mysqli_fetch_row($res_count);

    $sql="SELECT * FROM ccpet_cuin WHERE version=(SELECT MAX(version) FROM ccpet_cuin) LIMIT 0, 1000";
    $res=mysqli_query($linkbd,$sql);
    $codigos = array();

    while($row=mysqli_fetch_row($res))
    {
        array_push($codigos, $row);
    }

    $out['codigos'] = $codigos;
    $out['codigos_count'] = $row_count[0];
    
}

if($action=='guardarBienes'){ 

    //var_dump($_POST);
    
    
    $sql = "DELETE FROM ccpetinicialgastos WHERE cuenta = '".$_POST['cuentaPresupuestal']."' AND unidad = '".$_POST['unidadEjecutora']."' AND fuente = '".$_POST[fuente]."' AND medioPago = '".$_POST['medioPago']."' AND vigencia = '".$_POST['vigencia']."'";
    mysqli_query($linkbd, $sql);

    $sql = "DELETE FROM ccpetinicialigastosbienestransportables WHERE cuenta = '".$_POST['cuentaPresupuestal']."' AND unidad = '".$_POST['unidadEjecutora']."' AND fuente = '".$_POST[fuente]."' AND medioPago = '".$_POST['medioPago']."' AND vigencia = '".$_POST['vigencia']."'";
    mysqli_query($linkbd, $sql);

    if($_POST['valorTotal'] > 0){
        $sql="INSERT INTO  ccpetinicialgastos (cuenta, valor_total, unidad, fuente, medioPago, vigencia) VALUES ('".$_POST['cuentaPresupuestal']."', '".$_POST['valorTotal']."', '".$_POST['unidadEjecutora']."', '".$_POST[fuente]."', '".$_POST['medioPago']."', '".$_POST['vigencia']."')";
        if(mysqli_query($linkbd, $sql)){
            //var_dump($_POST['cuentasCuin']);
            for($x = 0; $x < count($_POST['cuentasSubclase']); $x++){

                $cuentas_separadas = explode(",", $_POST['cuentasSubclase'][$x]);
                //var_dump($cuentas_separadas);
                
                //echo $x;
                //echo $_POST['cuentasCuin'][$x];
                $sql = "INSERT INTO  ccpetinicialigastosbienestransportables (cuenta, subclase, valor, unidad, fuente, medioPago, vigencia) VALUES ('".$_POST['cuentaPresupuestal']."', '".$cuentas_separadas[0]."', '".$cuentas_separadas[1]."', '".$_POST['unidadEjecutora']."', '".$_POST[fuente]."', '".$_POST['medioPago']."', '".$_POST['vigencia']."')";

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
    }else{
        $out['insertaBien'] = true; 
    }
    
}

if($action=='guardarServicios'){ 

    //var_dump($_POST);
    $sql = "DELETE FROM ccpetinicialgastos WHERE cuenta = '".$_POST['cuentaPresupuestal']."' AND unidad = '".$_POST['unidadEjecutora']."' AND fuente='".$_POST['fuente']."' AND medioPago = '".$_POST['medioPago']."' AND vigencia = '".$_POST['vigencia']."'";
    mysqli_query($linkbd, $sql);

    $sql = "DELETE FROM ccpetinicialservicios WHERE cuenta = '".$_POST['cuentaPresupuestal']."' AND unidad = '".$_POST['unidadEjecutora']."' AND fuente='".$_POST['fuente']."' AND medioPago = '".$_POST['medioPago']."' AND vigencia = '".$_POST['vigencia']."'";
    mysqli_query($linkbd, $sql);

    if($_POST['valorTotalServicios'] > 0){
        $sql="INSERT INTO  ccpetinicialgastos (cuenta, valor_total, unidad, fuente, medioPago, vigencia) VALUES ('".$_POST['cuentaPresupuestal']."', '".$_POST['valorTotalServicios']."', '".$_POST['unidadEjecutora']."', '".$_POST['fuente']."', '".$_POST['medioPago']."', '".$_POST['vigencia']."')";
        if(mysqli_query($linkbd, $sql)){
            //var_dump($_POST['cuentasCuin']);
            for($x = 0; $x < count($_POST['cuentasSubclaseServicios']); $x++){

                $cuentas_separadas = explode(",", $_POST['cuentasSubclaseServicios'][$x]);
                //var_dump($cuentas_separadas);
                
                //echo $x;
                //echo $_POST['cuentasCuin'][$x];
                $sql = "INSERT INTO  ccpetinicialservicios (cuenta, subclase, valor, unidad, fuente, medioPago, vigencia) VALUES ('".$_POST['cuentaPresupuestal']."', '".$cuentas_separadas[0]."', '".$cuentas_separadas[1]."', '".$_POST['unidadEjecutora']."', '".$_POST['fuente']."', '".$_POST['medioPago']."', '".$_POST['vigencia']."')";

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
    }else{
        $out['insertaBien'] = true; 
    }
    
}

if($action=='guardarValorSolo'){

    $sql = "DELETE FROM ccpetinicialgastos WHERE cuenta = '".$_POST['cuentaPresupuestal']."' AND unidad = '".$_POST['unidadEjecutora']."' AND fuente='".$_POST['fuente']."' AND medioPago = '".$_POST['medioPago']."' AND vigencia = '".$_POST['vigencia']."'";
    mysqli_query($linkbd, $sql);

    
    $sql = "DELETE FROM ccpetinicialvalorgastos WHERE cuenta = '".$_POST['cuentaPresupuestal']."' AND unidad = '".$_POST['unidadEjecutora']."' AND fuente='".$_POST['fuente']."' AND medioPago = '".$_POST['medioPago']."' AND vigencia = '".$_POST['vigencia']."'";
    mysqli_query($linkbd, $sql);

    if($_POST['valorSolo'] > 0){
        $sql="INSERT INTO  ccpetinicialgastos (cuenta, valor_total, unidad, fuente, medioPago, vigencia) VALUES ('".$_POST['cuentaPresupuestal']."', '".$_POST['valorSolo']."', '".$_POST['unidadEjecutora']."', '".$_POST['fuente']."', '".$_POST['medioPago']."', '".$_POST['vigencia']."')";
        mysqli_query($linkbd, $sql);


        $sql="INSERT INTO  ccpetinicialvalorgastos (cuenta, valor, unidad, fuente, medioPago, vigencia) VALUES ('".$_POST['cuentaPresupuestal']."', '".$_POST['valorSolo']."', '".$_POST['unidadEjecutora']."', '".$_POST['fuente']."', '".$_POST['medioPago']."', '".$_POST['vigencia']."')";
        if(mysqli_query($linkbd,$sql))
        {
            $out['insertaBien'] = true; 
        }
        else
        {
            $out['insertaBien'] = false; 
        }
    }else{
        $out['insertaBien'] = true; 
    }
    
    
}

if($action == "searchCuentaAgr"){
    $cuentaAgr = $_GET['cuentaAgr'];
    $unidadEjecutora = $_GET['unidadEjecutora'];
    $fuente = $_GET['fuente'];
    $medioPago = $_GET['medioPago'];
    $vigencia = $_GET['vigencia'];
    $sql = "SELECT subclase, valor FROM ccpetinicialigastosbienestransportables WHERE cuenta = '$cuentaAgr' AND unidad = '$unidadEjecutora' AND fuente = '$fuente' AND medioPago = '$medioPago' AND vigencia='$vigencia'";
    $res = mysqli_query($linkbd, $sql);//echo $sql;
    $codigos = array();
    $codigosEliminar = array();
    $valorTotal = 0;

    while($row = mysqli_fetch_row($res))
    {
        $sql_bienes = "SELECT grupo, titulo, ud FROM ccpetbienestransportables WHERE grupo = '$row[0]'";
        $res_bienes = mysqli_query($linkbd, $sql_bienes);
        $row_bienes = mysqli_fetch_row($res_bienes);

        //array_push($codigosEliminar, $row_bienes);

        array_push($row_bienes, $row[1]);

        array_push($codigos, $row_bienes);

        $valorTotal += $row[1];
    }
    $out['codigos'] = $codigos;
    //$out['codigosEliminar'] = $codigosEliminar;
    $out['valorTotal'] = $valorTotal;
}

if($action == "searchCuentaServiciosAgr"){
    $cuentaAgr = $_GET['cuentaAgr'];
    $unidadEjecutora = $_GET['unidadEjecutora'];
    $fuente = $_GET['fuente'];
    $medioPago = $_GET['medioPago'];
    $vigencia = $_GET['vigencia'];
    $sql = "SELECT subclase, valor FROM ccpetinicialservicios WHERE cuenta = '$cuentaAgr' AND unidad = '$unidadEjecutora' AND fuente = '$fuente' AND medioPago = '$medioPago' AND vigencia='$vigencia'";
    $res = mysqli_query($linkbd, $sql);
    $codigos = array();
    $codigosEliminar = array();
    $valorTotalServicios = 0;

    while($row = mysqli_fetch_row($res))
    {
        $sql_bienes = "SELECT grupo, titulo, ciiu, cpc FROM ccpetservicios WHERE grupo = '$row[0]'";
        $res_bienes = mysqli_query($linkbd, $sql_bienes);
        $row_bienes = mysqli_fetch_row($res_bienes);

        //array_push($codigosEliminar, $row_bienes);

        array_push($row_bienes, $row[1]);

        array_push($codigos, $row_bienes);

        $valorTotalServicios += $row[1];
    }
    $out['codigos'] = $codigos;
    //$out['codigosEliminar'] = $codigosEliminar;
    $out['valorTotalServicios'] = $valorTotalServicios;
}

if($action=='searchFuente'){ 
    $keywordFuente=$_POST['keywordFuente'];
   	// $sql="SELECT * FROM ccpet_cuin WHERE (nit like '%$keyword%' || nombre like '%$keyword%') AND version=(SELECT MAX(version) FROM ccpet_cuin )";
	$sql="SELECT * FROM ccpet_fuentes WHERE concat_ws(' ', fuente_financiacion, entidad_financiadora) LIKE '%$keywordFuente%' AND version=(SELECT MAX(version) FROM ccpet_fuentes )";
    $res=mysqli_query($linkbd,$sql);
    $codigos = array();

	while($row=mysqli_fetch_row($res))
    {
        array_push($codigos, $row);
    }

	$out['codigos'] = $codigos;
}

if($action=='searchValorSolo'){ 
    $cuentaAgr = $_GET['cuentaAgr'];
    $unidadEjecutora = $_GET['unidadEjecutora'];
    $fuente = $_GET['fuente'];
    $medioPago = $_GET['medioPago'];
    $vigencia = $_GET['vigencia'];
   	// $sql="SELECT * FROM ccpet_cuin WHERE (nit like '%$keyword%' || nombre like '%$keyword%') AND version=(SELECT MAX(version) FROM ccpet_cuin )";
	$sql = "SELECT valor FROM ccpetinicialvalorgastos WHERE cuenta = '$cuentaAgr' AND unidad = '$unidadEjecutora' AND fuente='$fuente' AND medioPago = '$medioPago' AND vigencia = '$vigencia'"; //echo $sql;
    $res = mysqli_query($linkbd,$sql);
    $row = mysqli_fetch_row($res);
	$out['valor'] = $row[0];
}

if($action=='varlorFuenteCSF'){ 
    $cuentaAgr = $_POST['cuentaPresupuestal'];
    $unidadEjecutora = $_POST['unidadEjecutora'];
    $vigencia = $_POST['vigencia'];
    //$fuente = $_GET['fuente'];
    $medioPago = 'CSF';
    $valor = array();
   	// $sql="SELECT * FROM ccpet_cuin WHERE (nit like '%$keyword%' || nombre like '%$keyword%') AND version=(SELECT MAX(version) FROM ccpet_cuin )";
	$sql = "SELECT SUM(valor), fuente FROM ccpetinicialvalorgastos WHERE cuenta = '$cuentaAgr' AND unidad = '$unidadEjecutora' AND medioPago = '$medioPago' AND vigencia = '$vigencia'  GROUP BY fuente"; //echo $sql;
    $res = mysqli_query($linkbd,$sql);
    while($row = mysqli_fetch_row($res)){
        $valor[$row[1]] = $row[0];
    }
    
    
    $sql = "SELECT SUM(valor), fuente FROM ccpetinicialservicios WHERE cuenta = '$cuentaAgr' AND unidad = '$unidadEjecutora' AND medioPago = '$medioPago' AND vigencia = '$vigencia' GROUP BY fuente"; //echo $sql;
    $res = mysqli_query($linkbd,$sql);
    while($row = mysqli_fetch_row($res)){
        $valor[$row[1]] += $row[0];
    }
    
    
    $sql = "SELECT SUM(valor), fuente FROM ccpetinicialigastosbienestransportables WHERE cuenta = '$cuentaAgr' AND unidad = '$unidadEjecutora'  AND medioPago = '$medioPago' AND vigencia = '$vigencia' GROUP BY fuente"; //echo $sql;
    $res = mysqli_query($linkbd,$sql);
    while($row = mysqli_fetch_row($res)){
        $valor[$row[1]] += $row[0];
    }

	$out['valor'] = $valor;
}

if($action=='varlorFuenteSSF'){ 
    $cuentaAgr = $_POST['cuentaPresupuestal'];
    $unidadEjecutora = $_POST['unidadEjecutora'];
    $vigencia = $_POST['vigencia'];
    //$fuente = $_GET['fuente'];
    $medioPago = 'SSF';
    $valor = array();
   	// $sql="SELECT * FROM ccpet_cuin WHERE (nit like '%$keyword%' || nombre like '%$keyword%') AND version=(SELECT MAX(version) FROM ccpet_cuin )";
	$sql = "SELECT SUM(valor), fuente FROM ccpetinicialvalorgastos WHERE cuenta = '$cuentaAgr' AND unidad = '$unidadEjecutora' AND medioPago = '$medioPago' AND vigencia = '$vigencia' GROUP BY fuente"; //echo $sql;
    $res = mysqli_query($linkbd,$sql);
    while($row = mysqli_fetch_row($res)){
        $valor[$row[1]] = $row[0];
    }
    
    
    $sql = "SELECT SUM(valor), fuente FROM ccpetinicialservicios WHERE cuenta = '$cuentaAgr' AND unidad = '$unidadEjecutora' AND medioPago = '$medioPago' AND vigencia = '$vigencia' GROUP BY fuente"; //echo $sql;
    $res = mysqli_query($linkbd,$sql);
    while($row = mysqli_fetch_row($res)){
        $valor[$row[1]] += $row[0];
    }
    
    
    $sql = "SELECT SUM(valor), fuente FROM ccpetinicialigastosbienestransportables WHERE cuenta = '$cuentaAgr' AND unidad = '$unidadEjecutora'  AND medioPago = '$medioPago' AND vigencia = '$vigencia' GROUP BY fuente"; //echo $sql;
    $res = mysqli_query($linkbd,$sql);
    while($row = mysqli_fetch_row($res)){
        $valor[$row[1]] += $row[0];
    }

	$out['valor'] = $valor;
}

header("Content-type: application/json");
echo json_encode($out);
die();