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
    $sql = "SELECT codigo, nombre, tipo FROM cuentasingresosccpet WHERE municipio=1";
    $res=mysqli_query($linkbd,$sql);
    $ingresos = array();
    $valorPorCuenta = array();
    while($row=mysqli_fetch_row($res))
    {
        $sql_cuenta = "SELECT sum(valor_total) FROM ccpetinicialingresos WHERE cuenta like '$row[0]%' AND vigencia = '$vigencia' AND unidad='$unidadEjecutora' AND medioPago='$medioPago'";//echo $sql_cuenta;
        $res_cuenta = mysqli_query($linkbd, $sql_cuenta);
        $row_cuneta = mysqli_fetch_row($res_cuenta);
        $valorPorCuenta[$row[0]] = $row_cuneta[0];

        array_push($ingresos, $row);
    }
    $out['ingresos'] = $ingresos;
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
    $sql = "SELECT clasificadores FROM ccpetprogramarclasificadores WHERE cuenta = '$cuenta'";
    $res = mysqli_query($linkbd, $sql);
    $clasificadores = array();

    while ($row = mysqli_fetch_row($res)) {
        array_push($clasificadores, $row);
    }

    $out['clasificadores'] = $clasificadores;
}

if($action=='searchValorSolo'){ 
    $cuentaAgr = $_GET['cuentaAgr'];
    $unidadEjecutora = $_GET['unidadEjecutora'];
    $fuente = $_GET['fuente'];
    $medioPago = $_GET['medioPago'];
    $vigencia = $_GET['vigencia'];
   	// $sql="SELECT * FROM ccpet_cuin WHERE (nit like '%$keyword%' || nombre like '%$keyword%') AND version=(SELECT MAX(version) FROM ccpet_cuin )";
	$sql = "SELECT valor FROM ccpetinicialvaloringresos WHERE cuenta = '$cuentaAgr' AND unidad = '$unidadEjecutora' AND fuente='$fuente' AND medioPago = '$medioPago' AND vigencia = '$vigencia'"; //echo $sql;
    $res = mysqli_query($linkbd,$sql);
    $row = mysqli_fetch_row($res);
	$out['valor'] = $row[0];
}

if($action=='cuin'){
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

if($action=='clasificador'){

    $clasificador = $_GET['clas'];
    $sql="SELECT PR.codigo, PR.nombre, PR.tipo FROM cuentasingresosccpet AS PR, cuentasingresosccpet_det AS DET WHERE PR.id = DET.id_cuentasingreso AND DET.id_clasificador = $clasificador ORDER BY PR.codigo ASC";
    $res=mysqli_query($linkbd,$sql);
    $codigos = array();

    while($row=mysqli_fetch_row($res))
    {
        array_push($codigos, $row);
    }

    $out['codigos'] = $codigos;    
}

if($action=='guardarValorSolo'){

    $sql = "DELETE FROM ccpetinicialingresos WHERE cuenta = '".$_POST['cuentaPresupuestal']."' AND unidad = '".$_POST['unidadEjecutora']."' AND fuente='".$_POST['fuente']."' AND medioPago = '".$_POST['medioPago']."' AND vigencia = '".$_POST['vigencia']."'";
    mysqli_query($linkbd, $sql);

    
    $sql = "DELETE FROM ccpetinicialvaloringresos WHERE cuenta = '".$_POST['cuentaPresupuestal']."' AND unidad = '".$_POST['unidadEjecutora']."' AND fuente='".$_POST['fuente']."' AND medioPago = '".$_POST['medioPago']."' AND vigencia = '".$_POST['vigencia']."'";
    mysqli_query($linkbd, $sql);

    if($_POST['valorSolo'] > 0){
        $sql="INSERT INTO  ccpetinicialingresos (cuenta, valor_total, unidad, fuente, medioPago, vigencia) VALUES ('".$_POST['cuentaPresupuestal']."', '".$_POST['valorSolo']."', '".$_POST['unidadEjecutora']."', '".$_POST['fuente']."', '".$_POST['medioPago']."', '".$_POST['vigencia']."')";
        mysqli_query($linkbd, $sql);


        $sql="INSERT INTO  ccpetinicialvaloringresos (cuenta, valor, unidad, fuente, medioPago, vigencia) VALUES ('".$_POST['cuentaPresupuestal']."', '".$_POST['valorSolo']."', '".$_POST['unidadEjecutora']."', '".$_POST['fuente']."', '".$_POST['medioPago']."', '".$_POST['vigencia']."')";
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

if($action=='guardarCuin'){ 

    //var_dump($_POST);
    

    $sql = "DELETE FROM ccpetinicialingresos WHERE cuenta = '".$_POST['cuentaPresupuestal']."' AND unidad = '".$_POST['unidadEjecutora']."' AND fuente='".$_POST['fuente']."' AND medioPago = '".$_POST['medioPago']."' AND vigencia = '".$_POST['vigencia']."'";
    mysqli_query($linkbd, $sql);

    $sql = "DELETE FROM ccpetinicialingresoscuin WHERE cuenta = '".$_POST['cuentaPresupuestal']."' AND unidad = '".$_POST['unidadEjecutora']."' AND fuente='".$_POST['fuente']."' AND medioPago = '".$_POST['medioPago']."'";
    mysqli_query($linkbd, $sql);

    if($_POST['valorTotal'] > 0){
        $sql="INSERT INTO  ccpetinicialingresos (cuenta, valor_total, unidad, fuente, medioPago, vigencia) VALUES ('".$_POST['cuentaPresupuestal']."', '".$_POST['valorTotal']."', '".$_POST['unidadEjecutora']."', '".$_POST['fuente']."', '".$_POST['medioPago']."', '".$_POST['vigencia']."')";
        if(mysqli_query($linkbd, $sql)){
            //var_dump($_POST['cuentasCuin']);
            for($x = 0; $x < count($_POST['cuentasCuin']); $x++){

                $cuentas_separadas = explode(",", $_POST['cuentasCuin'][$x]);
                //var_dump($cuentas_separadas);
                
                //echo $x;
                //echo $_POST['cuentasCuin'][$x];
                $sql = "INSERT INTO  ccpetinicialingresoscuin (cuenta, cuin, valor, unidad, fuente, medioPago, vigencia) VALUES ('".$_POST['cuentaPresupuestal']."', '".$cuentas_separadas[13]."', '".$cuentas_separadas[15]."', '".$_POST['unidadEjecutora']."', '".$_POST['fuente']."', '".$_POST['medioPago']."', '".$_POST['vigencia']."')";

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
    

    /*$sql="SELECT * FROM ccpet_cuin WHERE version=(SELECT MAX(version) FROM ccpet_cuin) LIMIT 0, 1000";
    $res=mysqli_query($linkbd,$sql);
    $codigos = array();

    while($row=mysqli_fetch_row($res))
    {
        array_push($codigos, $row);
    }

    $out['codigos'] = $codigos;
    $out['codigos_count'] = $row_count[0];*/
    
}

if($action=='guardarClasificador'){

    $sql = "DELETE FROM ccpetinicialingresos WHERE cuenta = '".$_POST['cuentaPresupuestal']."' AND unidad = '".$_POST['unidadEjecutora']."' AND fuente='".$_POST['fuente']."' AND medioPago = '".$_POST['medioPago']."' AND vigencia = '".$_POST['vigencia']."'";
    mysqli_query($linkbd, $sql);

    $sql = "DELETE FROM ccpetinicialingresosclasificador WHERE cuenta = '".$_POST['cuentaPresupuestal']."' AND unidad = '".$_POST['unidadEjecutora']."' AND fuente='".$_POST['fuente']."' AND medioPago = '".$_POST['medioPago']."' AND id_clasificador = '".$_POST['id_clasificador']."'";
    mysqli_query($linkbd, $sql);

    if($_POST['valorTotalClasificador'] > 0){
        $sql="INSERT INTO  ccpetinicialingresos (cuenta, valor_total, unidad, fuente, medioPago, vigencia) VALUES ('".$_POST['cuentaPresupuestal']."', '".$_POST['valorTotalClasificador']."', '".$_POST['unidadEjecutora']."', '".$_POST['fuente']."', '".$_POST['medioPago']."', '".$_POST['vigencia']."')";
        if(mysqli_query($linkbd, $sql)){
            //var_dump($_POST['cuentasCuin']);
            for($x = 0; $x < count($_POST['cuentasClasificador']); $x++){

                $cuentas_separadas = explode(",", $_POST['cuentasClasificador'][$x]);
                //var_dump($cuentas_separadas);
                
                //echo $x;
                //echo $_POST['cuentasCuin'][$x];
                $sql = "INSERT INTO  ccpetinicialingresosclasificador (cuenta, cuenta_clasificador, valor, unidad, fuente, medioPago, vigencia, id_clasificador) VALUES ('".$_POST['cuentaPresupuestal']."', '".$cuentas_separadas[0]."', '".$cuentas_separadas[3]."', '".$_POST['unidadEjecutora']."', '".$_POST['fuente']."', '".$_POST['medioPago']."', '".$_POST['vigencia']."', '".$_POST['id_clasificador']."')";

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

if($action == "searchCuentaAgr"){
    $cuentaAgr = $_GET['cuentaAgr'];
    $unidadEjecutora = $_GET['unidadEjecutora'];
    $fuente = $_GET['fuente'];
    $medioPago = $_GET['medioPago'];
    $vigencia = $_GET['vigencia'];
    $sql = "SELECT subclase, valor FROM ccpetinicialingresosbienestransportables WHERE cuenta = '$cuentaAgr' AND unidad = '$unidadEjecutora' AND fuente = '$fuente' AND medioPago = '$medioPago' AND vigencia = '$vigencia'";
    $res = mysqli_query($linkbd, $sql);//echo $sql;
    $codigos = array();
    $codigosEliminar = array();
    $valorTotal = 0;

    while($row = mysqli_fetch_row($res))
    {
        $sql_bienes = "SELECT grupo, titulo, ciiu, sistema_armonizado, cpc FROM ccpetbienestransportables WHERE grupo = '$row[0]'";
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
    $sql = "SELECT subclase, valor FROM ccpetinicialserviciosingresos WHERE cuenta = '$cuentaAgr' AND unidad = '$unidadEjecutora' AND fuente = '$fuente' AND medioPago = '$medioPago' AND vigencia = '$vigencia'";
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

if($action=='varlorFuenteCSF'){ 
    $cuentaAgr = $_POST['cuentaPresupuestal'];
    $unidadEjecutora = $_POST['unidadEjecutora'];
    $vigencia = $_POST['vigencia'];
    //$fuente = $_GET['fuente'];
    $medioPago = 'CSF';
    $valor = array();
   	// $sql="SELECT * FROM ccpet_cuin WHERE (nit like '%$keyword%' || nombre like '%$keyword%') AND version=(SELECT MAX(version) FROM ccpet_cuin )";
	$sql = "SELECT SUM(valor), fuente FROM ccpetinicialvaloringresos WHERE cuenta = '$cuentaAgr' AND unidad = '$unidadEjecutora' AND medioPago = '$medioPago' AND vigencia = '$vigencia' GROUP BY fuente"; //echo $sql;
    $res = mysqli_query($linkbd,$sql);
    while($row = mysqli_fetch_row($res)){
        $valor[$row[1]] = $row[0];
    }
    
    
    $sql = "SELECT SUM(valor), fuente FROM ccpetinicialserviciosingresos WHERE cuenta = '$cuentaAgr' AND unidad = '$unidadEjecutora' AND medioPago = '$medioPago' AND vigencia = '$vigencia' GROUP BY fuente"; //echo $sql;
    $res = mysqli_query($linkbd,$sql);
    while($row = mysqli_fetch_row($res)){
        $valor[$row[1]] += $row[0];
    }
    
    
    $sql = "SELECT SUM(valor), fuente FROM ccpetinicialingresosbienestransportables WHERE cuenta = '$cuentaAgr' AND unidad = '$unidadEjecutora'  AND medioPago = '$medioPago' AND vigencia = '$vigencia' GROUP BY fuente"; //echo $sql;
    $res = mysqli_query($linkbd,$sql);
    while($row = mysqli_fetch_row($res)){
        $valor[$row[1]] += $row[0];
    }

    $sql = "SELECT SUM(valor), fuente FROM ccpetinicialingresoscuin WHERE cuenta = '$cuentaAgr' AND unidad = '$unidadEjecutora'  AND medioPago = '$medioPago' AND vigencia = '$vigencia' GROUP BY fuente"; //echo $sql;
    $res = mysqli_query($linkbd,$sql);
    while($row = mysqli_fetch_row($res)){
        $valor[$row[1]] += $row[0];
    }

    $sql = "SELECT SUM(valor), fuente FROM ccpetinicialingresosclasificador WHERE cuenta = '$cuentaAgr' AND unidad = '$unidadEjecutora'  AND medioPago = '$medioPago' AND vigencia = '$vigencia' GROUP BY fuente"; //echo $sql;
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
	$sql = "SELECT SUM(valor), fuente FROM ccpetinicialvaloringresos WHERE cuenta = '$cuentaAgr' AND unidad = '$unidadEjecutora' AND medioPago = '$medioPago' AND vigencia = '$vigencia' GROUP BY fuente"; //echo $sql;
    $res = mysqli_query($linkbd,$sql);
    while($row = mysqli_fetch_row($res)){
        $valor[$row[1]] = $row[0];
    }
    
    
    $sql = "SELECT SUM(valor), fuente FROM ccpetinicialserviciosingresos WHERE cuenta = '$cuentaAgr' AND unidad = '$unidadEjecutora' AND medioPago = '$medioPago' AND vigencia = '$vigencia' GROUP BY fuente"; //echo $sql;
    $res = mysqli_query($linkbd,$sql);
    while($row = mysqli_fetch_row($res)){
        $valor[$row[1]] += $row[0];
    }
    
    
    $sql = "SELECT SUM(valor), fuente FROM ccpetinicialingresosbienestransportables WHERE cuenta = '$cuentaAgr' AND unidad = '$unidadEjecutora'  AND medioPago = '$medioPago' AND vigencia = '$vigencia' GROUP BY fuente"; //echo $sql;
    $res = mysqli_query($linkbd,$sql);
    while($row = mysqli_fetch_row($res)){
        $valor[$row[1]] += $row[0];
    }

    $sql = "SELECT SUM(valor), fuente FROM ccpetinicialingresoscuin WHERE cuenta = '$cuentaAgr' AND unidad = '$unidadEjecutora'  AND medioPago = '$medioPago' AND vigencia = '$vigencia' GROUP BY fuente"; //echo $sql;
    $res = mysqli_query($linkbd,$sql);
    while($row = mysqli_fetch_row($res)){
        $valor[$row[1]] += $row[0];
    }

    $sql = "SELECT SUM(valor), fuente FROM ccpetinicialingresosclasificador WHERE cuenta = '$cuentaAgr' AND unidad = '$unidadEjecutora'  AND medioPago = '$medioPago' AND vigencia = '$vigencia' GROUP BY fuente"; //echo $sql;
    $res = mysqli_query($linkbd,$sql);
    while($row = mysqli_fetch_row($res)){
        $valor[$row[1]] += $row[0];
    }

	$out['valor'] = $valor;
}

if($action=='guardarBienes'){ 

    //var_dump($_POST);
    
    
    $sql = "DELETE FROM ccpetinicialingresos WHERE cuenta = '".$_POST['cuentaPresupuestal']."' AND unidad = '".$_POST['unidadEjecutora']."' AND fuente = '".$_POST[fuente]."' AND medioPago = '".$_POST['medioPago']."' AND vigencia='".$_POST['vigencia']."'";
    mysqli_query($linkbd, $sql);

    $sql = "DELETE FROM ccpetinicialingresosbienestransportables WHERE cuenta = '".$_POST['cuentaPresupuestal']."' AND unidad = '".$_POST['unidadEjecutora']."' AND fuente = '".$_POST[fuente]."' AND medioPago = '".$_POST['medioPago']."' AND vigencia='".$_POST['vigencia']."'";
    mysqli_query($linkbd, $sql);

    if($_POST['valorTotal'] > 0){
        $sql="INSERT INTO  ccpetinicialingresos (cuenta, valor_total, unidad, fuente, medioPago, vigencia) VALUES ('".$_POST['cuentaPresupuestal']."', '".$_POST['valorTotal']."', '".$_POST['unidadEjecutora']."', '".$_POST[fuente]."', '".$_POST['medioPago']."', '".$_POST['vigencia']."')";
        if(mysqli_query($linkbd, $sql)){
            //var_dump($_POST['cuentasCuin']);
            for($x = 0; $x < count($_POST['cuentasSubclase']); $x++){

                $cuentas_separadas = explode(",", $_POST['cuentasSubclase'][$x]);
                //var_dump($cuentas_separadas);
                
                //echo $x;
                //echo $_POST['cuentasCuin'][$x];
                $sql = "INSERT INTO  ccpetinicialingresosbienestransportables (cuenta, subclase, valor, unidad, fuente, medioPago, vigencia) VALUES ('".$_POST['cuentaPresupuestal']."', '".$cuentas_separadas[0]."', '".$cuentas_separadas[1]."', '".$_POST['unidadEjecutora']."', '".$_POST[fuente]."', '".$_POST['medioPago']."', '".$_POST['vigencia']."')";

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
    $sql = "DELETE FROM ccpetinicialingresos WHERE cuenta = '".$_POST['cuentaPresupuestal']."' AND unidad = '".$_POST['unidadEjecutora']."' AND fuente='".$_POST['fuente']."' AND medioPago = '".$_POST['medioPago']."'  AND vigencia = '".$_POST['vigencia']."'";
    mysqli_query($linkbd, $sql);

    $sql = "DELETE FROM ccpetinicialserviciosingresos WHERE cuenta = '".$_POST['cuentaPresupuestal']."' AND unidad = '".$_POST['unidadEjecutora']."' AND fuente='".$_POST['fuente']."' AND medioPago = '".$_POST['medioPago']."' AND vigencia = '".$_POST['vigencia']."'";
    mysqli_query($linkbd, $sql);

    if($_POST['valorTotalServicios'] > 0){
        $sql="INSERT INTO  ccpetinicialingresos (cuenta, valor_total, unidad, fuente, medioPago, vigencia) VALUES ('".$_POST['cuentaPresupuestal']."', '".$_POST['valorTotalServicios']."', '".$_POST['unidadEjecutora']."', '".$_POST['fuente']."', '".$_POST['medioPago']."', '".$_POST['vigencia']."')";
        if(mysqli_query($linkbd, $sql)){
            //var_dump($_POST['cuentasCuin']);
            for($x = 0; $x < count($_POST['cuentasSubclaseServicios']); $x++){

                $cuentas_separadas = explode(",", $_POST['cuentasSubclaseServicios'][$x]);
                //var_dump($cuentas_separadas);
                
                //echo $x;
                //echo $_POST['cuentasCuin'][$x];
                $sql = "INSERT INTO  ccpetinicialserviciosingresos (cuenta, subclase, valor, unidad, fuente, medioPago, vigencia) VALUES ('".$_POST['cuentaPresupuestal']."', '".$cuentas_separadas[0]."', '".$cuentas_separadas[1]."', '".$_POST['unidadEjecutora']."', '".$_POST['fuente']."', '".$_POST['medioPago']."', '".$_POST['vigencia']."')";

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

if($action == "searchCuentaAgr"){
    $cuentaAgr = $_GET['cuentaAgr'];
    $unidadEjecutora = $_GET['unidadEjecutora'];
    $fuente = $_GET['fuente'];
    $medioPago = $_GET['medioPago'];
    $vigencia = $_GET['vigencia'];
    $sql = "SELECT subclase, valor FROM ccpetinicialingresosbienestransportables WHERE cuenta = '$cuentaAgr' AND unidad = '$unidadEjecutora' AND fuente = '$fuente' AND medioPago = '$medioPago' AND vigencia = '$vigencia'";
    $res = mysqli_query($linkbd, $sql);//echo $sql;
    $codigos = array();
    $codigosEliminar = array();
    $valorTotal = 0;

    while($row = mysqli_fetch_row($res))
    {
        $sql_bienes = "SELECT grupo, titulo, ciiu, sistema_armonizado, cpc FROM ccpetbienestransportables WHERE grupo = '$row[0]'";
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

if($action == "searchCuentaAgrCuin"){
    $cuentaAgr = $_GET['cuentaAgr'];
    $unidadEjecutora = $_GET['unidadEjecutora'];
    $fuente = $_GET['fuente'];
    $medioPago = $_GET['medioPago'];
    $vigencia = $_GET['vigencia'];
    $sql = "SELECT cuin, valor FROM ccpetinicialingresoscuin WHERE cuenta = '$cuentaAgr' AND unidad = '$unidadEjecutora' AND fuente = '$fuente' AND medioPago = '$medioPago' AND vigencia = '$vigencia'";
    $res = mysqli_query($linkbd,$sql);
    $codigos = array();
    $codigosEliminar = array();
    $valorTotal = 0;

    while($row = mysqli_fetch_row($res))
    {
        $sql_cuin = "SELECT * FROM ccpet_cuin WHERE codigo_cuin = '$row[0]'";
        $res_cuin = mysqli_query($linkbd, $sql_cuin);
        $row_cuin = mysqli_fetch_row($res_cuin);

        array_push($codigosEliminar, $row_cuin);

        array_push($row_cuin, $row[1]);

        array_push($codigos, $row_cuin);

        $valorTotal += $row[1];
    }
    $out['codigos'] = $codigos;
    $out['codigosEliminar'] = $codigosEliminar;
    $out['valorTotal'] = $valorTotal;
}

if($action == "searchCuentaAgrClasificador"){
    $cuentaAgr = $_GET['cuentaAgr'];
    $unidadEjecutora = $_GET['unidadEjecutora'];
    $fuente = $_GET['fuente'];
    $medioPago = $_GET['medioPago'];
    $vigencia = $_GET['vigencia'];
    $sql = "SELECT cuenta_clasificador, valor FROM ccpetinicialingresosclasificador WHERE cuenta = '$cuentaAgr' AND unidad = '$unidadEjecutora' AND fuente = '$fuente' AND medioPago = '$medioPago' AND vigencia = '$vigencia'";
    $res = mysqli_query($linkbd,$sql);
    $codigos = array();
    $valorTotal = 0;

    while($row = mysqli_fetch_row($res))
    {
        $sql_cuenta = "SELECT codigo, nombre, tipo FROM cuentasingresosccpet WHERE codigo = '$row[0]'";
        $res_cuenta = mysqli_query($linkbd, $sql_cuenta);
        $row_cuenta = mysqli_fetch_row($res_cuenta);

        array_push($row_cuenta, $row[1]);

        array_push($codigos, $row_cuenta);

        $valorTotal += $row[1];
    }
    $out['codigos'] = $codigos;
    $out['valorTotal'] = $valorTotal;
}

header("Content-type: application/json");
echo json_encode($out);
die();