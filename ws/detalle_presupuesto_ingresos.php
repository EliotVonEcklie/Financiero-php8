<?php
    require_once "../comun.inc";
    require_once "../funciones.inc";

    $linkbd = conectar_v7();	

    $cuenta = $_POST['cuenta'];
    $unidadEjecutora = $_POST['unidadEjecutora'];
    $medioPago = $_POST['medioPago'];
    $vigencia = $_POST['vigencia'];

    $crit = '';
    if($_POST['unidadEjecutora'] != ''){
        $crit = "AND unidad = '$unidadEjecutora'";
    }

    $crit1 = '';
    if($_POST['medioPago'] != ''){
        $crit1 = "AND medioPago = '$medioPago'";
    }

    $tabla='<table class="titulos" width="70%">';

    $sqlr = "SELECT fuente, medioPago, unidad, valor FROM ccpetinicialvaloringresos WHERE cuenta = '$cuenta' AND vigencia='$vigencia' $crit $crit1";
    $result = mysqli_query($linkbd, $sqlr);
    if(mysqli_num_rows($result) > 0){
        $tabla.='<tr>
                    <td>Fuente</td>
                    <td>MedioPago</td>
                    <td>Unidad</td>
                    <td>Valor</td>
                </tr>';

        while($row = mysqli_fetch_array($result)){
            $sqlr_fuente = "SELECT fuente_financiacion FROM ccpet_fuentes WHERE id_fuente = '$row[0]'";
            $result_fuente = mysqli_query($linkbd, $sqlr_fuente);
            $row_fuente = mysqli_fetch_array($result_fuente);

            $sqlr_unidad = "SELECT nombre FROM pptouniejecu WHERE id_cc = '$row[2]'";
            $result_unidad = mysqli_query($linkbd, $sqlr_unidad);
            $row_unidad = mysqli_fetch_array($result_unidad);

            if($row[1] == 'CSF'){
                $medioPago = 'Con situacion de fondos';
            }else{
                $medioPago = 'Sin situacion de fondos';
            }

            $tabla.='<tr>
                        <td class="cssdeta">'.$row[0].' - '.$row_fuente[0].'</td>
                        <td class="cssdeta" >'.$medioPago.'</td>
                        <td class="cssdeta" >'.$row[2].' - '.$row_unidad[0].'</td>
                        <td class="cssdeta" >'.number_format($row[3], 2, ',', '.').'</td>
                    </tr>
                    ';
        }
    }

    $sqlr = "SELECT fuente, medioPago, subclase, unidad, valor FROM ccpetinicialingresosbienestransportables WHERE cuenta = '$cuenta' AND vigencia='$vigencia' $crit $crit1";
    $result = mysqli_query($linkbd, $sqlr);
    if(mysqli_num_rows($result) > 0){
        $tabla.='<tr>
                    <td>Fuente</td>
                    <td>MedioPago</td>
                    <td>subClase</td>
                    <td>Unidad</td>
                    <td>Valor</td>
                </tr>';

        while($row = mysqli_fetch_array($result)){
            $sqlr_fuente = "SELECT fuente_financiacion FROM ccpet_fuentes WHERE id_fuente = '$row[0]'";
            $result_fuente = mysqli_query($linkbd, $sqlr_fuente);
            $row_fuente = mysqli_fetch_array($result_fuente);

            $sqlr_bienes = "SELECT titulo FROM ccpetbienestransportables WHERE grupo = '$row[2]'";
            $result_bienes = mysqli_query($linkbd, $sqlr_bienes);
            $row_bienes = mysqli_fetch_array($result_bienes);

            $sqlr_unidad = "SELECT nombre FROM pptouniejecu WHERE id_cc = '$row[3]'";
            $result_unidad = mysqli_query($linkbd, $sqlr_unidad);
            $row_unidad = mysqli_fetch_array($result_unidad);

            if($row[1] == 'CSF'){
                $medioPago = 'Con situacion de fondos';
            }else{
                $medioPago = 'Sin situacion de fondos';
            }

            $tabla.='<tr>
                        <td class="cssdeta">'.$row[0].' - '.$row_fuente[0].'</td>
                        <td class="cssdeta" >'.$medioPago.'</td>
                        <td class="cssdeta" >'.$row[2].' - '.$row_bienes[0].'</td>
                        <td class="cssdeta" >'.$row[3].' - '.$row_unidad[0].'</td>
                        <td class="cssdeta" >'.number_format($row[4], 2, ',', '.').'</td>
                    </tr>
                    ';
        }
    }

    $sqlr = "SELECT fuente, medioPago, subclase, unidad, valor FROM ccpetinicialserviciosingresos WHERE cuenta = '$cuenta' AND vigencia='$vigencia' $crit $crit1";
    $result = mysqli_query($linkbd, $sqlr);
    if(mysqli_num_rows($result) > 0){
        $tabla.='<tr>
                    <td>Fuente</td>
                    <td>MedioPago</td>
                    <td>subClase</td>
                    <td>Unidad</td>
                    <td>Valor</td>
                </tr>';

        while($row = mysqli_fetch_array($result)){
            $sqlr_fuente = "SELECT fuente_financiacion FROM ccpet_fuentes WHERE id_fuente = '$row[0]'";
            $result_fuente = mysqli_query($linkbd, $sqlr_fuente);
            $row_fuente = mysqli_fetch_array($result_fuente);

            $sqlr_bienes = "SELECT titulo FROM ccpetservicios WHERE grupo = '$row[2]'";
            $result_bienes = mysqli_query($linkbd, $sqlr_bienes);
            $row_bienes = mysqli_fetch_array($result_bienes);

            $sqlr_unidad = "SELECT nombre FROM pptouniejecu WHERE id_cc = '$row[3]'";
            $result_unidad = mysqli_query($linkbd, $sqlr_unidad);
            $row_unidad = mysqli_fetch_array($result_unidad);

            if($row[1] == 'CSF'){
                $medioPago = 'Con situacion de fondos';
            }else{
                $medioPago = 'Sin situacion de fondos';
            }

            $tabla.='<tr>
                        <td class="cssdeta">'.$row[0].' - '.$row_fuente[0].'</td>
                        <td class="cssdeta" >'.$medioPago.'</td>
                        <td class="cssdeta" >'.$row[2].' - '.$row_bienes[0].'</td>
                        <td class="cssdeta" >'.$row[3].' - '.$row_unidad[0].'</td>
                        <td class="cssdeta" >'.number_format($row[4], 2, ',', '.').'</td>
                    </tr>
                    ';
        }
    }

    $sqlr = "SELECT fuente, medioPago, cuin, unidad, valor FROM ccpetinicialingresoscuin WHERE cuenta = '$cuenta' AND vigencia='$vigencia' $crit $crit1";
    $result = mysqli_query($linkbd, $sqlr);
    if(mysqli_num_rows($result) > 0){
        $tabla.='<tr>
                    <td>Fuente</td>
                    <td>MedioPago</td>
                    <td>Cuin</td>
                    <td>Unidad</td>
                    <td>Valor</td>
                </tr>';

        while($row = mysqli_fetch_array($result)){
            $sqlr_fuente = "SELECT fuente_financiacion FROM ccpet_fuentes WHERE id_fuente = '$row[0]'";
            $result_fuente = mysqli_query($linkbd, $sqlr_fuente);
            $row_fuente = mysqli_fetch_array($result_fuente);

            $sqlr_bienes = "SELECT nombre FROM ccpet_cuin WHERE codigo_cuin = '$row[2]'";
            $result_bienes = mysqli_query($linkbd, $sqlr_bienes);
            $row_bienes = mysqli_fetch_array($result_bienes);

            $sqlr_unidad = "SELECT nombre FROM pptouniejecu WHERE id_cc = '$row[3]'";
            $result_unidad = mysqli_query($linkbd, $sqlr_unidad);
            $row_unidad = mysqli_fetch_array($result_unidad);

            if($row[1] == 'CSF'){
                $medioPago = 'Con situacion de fondos';
            }else{
                $medioPago = 'Sin situacion de fondos';
            }

            $tabla.='<tr>
                        <td class="cssdeta">'.$row[0].' - '.$row_fuente[0].'</td>
                        <td class="cssdeta" >'.$medioPago.'</td>
                        <td class="cssdeta" >'.$row[2].' - '.$row_bienes[0].'</td>
                        <td class="cssdeta" >'.$row[3].' - '.$row_unidad[0].'</td>
                        <td class="cssdeta" >'.number_format($row[4], 2, ',', '.').'</td>
                    </tr>
                    ';
        }
    }

    $sqlr = "SELECT fuente, medioPago, cuenta_clasificador, unidad, valor, id_clasificador FROM ccpetinicialingresosclasificador WHERE cuenta = '$cuenta' AND vigencia='$vigencia' $crit $crit1";
    $result = mysqli_query($linkbd, $sqlr);
    if(mysqli_num_rows($result) > 0){
        $tabla.='<tr>
                    <td>Fuente</td>
                    <td>MedioPago</td>
                    <td>Clasificador</td>
                    <td>Cuenta</td>
                    <td>Unidad</td>
                    <td>Valor</td>
                </tr>';

        while($row = mysqli_fetch_array($result)){
            $sqlr_fuente = "SELECT fuente_financiacion FROM ccpet_fuentes WHERE id_fuente = '$row[0]'";
            $result_fuente = mysqli_query($linkbd, $sqlr_fuente);
            $row_fuente = mysqli_fetch_array($result_fuente);

            $sqlr_ingresos = "SELECT nombre FROM cuentasingresosccpet WHERE codigo = '$row[2]'";
            $result_ingresos = mysqli_query($linkbd, $sqlr_ingresos);
            $row_ingresos = mysqli_fetch_array($result_ingresos);

            $sqlr_unidad = "SELECT nombre FROM pptouniejecu WHERE id_cc = '$row[3]'";
            $result_unidad = mysqli_query($linkbd, $sqlr_unidad);
            $row_unidad = mysqli_fetch_array($result_unidad);

            $sqlr_clasificador = "SELECT nombre FROM cuentasingresosccpet_cab WHERE id_clasificador = '$row[5]'";
            $result_clasificador = mysqli_query($linkbd, $sqlr_clasificador);
            $row_clasificador = mysqli_fetch_array($result_clasificador);

            if($row[1] == 'CSF'){
                $medioPago = 'Con situacion de fondos';
            }else{
                $medioPago = 'Sin situacion de fondos';
            }

            $tabla.='<tr>
                        <td class="cssdeta">'.$row[0].' - '.$row_fuente[0].'</td>
                        <td class="cssdeta" >'.$medioPago.'</td>
                        <td class="cssdeta" >'.$row[5].' - '.$row_clasificador[0].'</td>
                        <td class="cssdeta" >'.$row[2].' - '.$row_ingresos[0].'</td>
                        <td class="cssdeta" >'.$row[3].' - '.$row_unidad[0].'</td>
                        <td class="cssdeta" >'.number_format($row[4], 2, ',', '.').'</td>
                    </tr>
                    ';
        }
    }
    
	 
    $tabla.='</table>';

    $data_row = array('detalle'=>$tabla);
    header('Content-Type: application/json');
    echo json_encode($data_row);