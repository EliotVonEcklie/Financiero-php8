<?php
    require_once "../comun.inc";
    require_once "../funciones.inc";

    $linkbd = conectar_v7();	

    $cuenta = $_POST['cuenta'];
    $unidadEjecutora = $_POST['unidadEjecutora'];
    $medioPago = $_POST['medioPago'];
    $vigencia = $_POST['vigencia'];
    $codInv = $_POST['codInv'];

    $crit = '';
    if($_POST['unidadEjecutora'] != ''){
        $crit = "AND unidad = '$_POST[unidadEjecutora]'";
    }
    
    $crit1 = '';
    if($_POST['medioPago'] != ''){
        $crit1 = "AND medioPago = '$medioPago'";
    }

    $critinv1 = '';
    if($_POST['medioPago'] != ''){
        $critinv1 = "AND medio_pago = '$medioPago'";
    }

    $tabla='<table class="titulos" width="70%">';

    $sqlr = "SELECT fuente, medioPago, unidad, valor FROM ccpetinicialvalorgastos WHERE cuenta = '$cuenta' AND vigencia='$vigencia' $crit $crit1";
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

    $sqlr = "SELECT fuente, medioPago, subclase, unidad, valor FROM ccpetinicialigastosbienestransportables WHERE cuenta = '$cuenta' AND vigencia='$vigencia' $crit $crit1";
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

    $sqlr = "SELECT fuente, medioPago, subclase, unidad, valor FROM ccpetinicialservicios WHERE cuenta = '$cuenta' AND vigencia='$vigencia' $crit $crit1";
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

    $sqlr = "SELECT id_fuente, medio_pago, subproducto, codigocuin, valorcsf, valorssf, subclase FROM ccpproyectospresupuesto_presupuesto WHERE rubro = '$cuenta' $critinv1";
    $result = mysqli_query($linkbd, $sqlr);
    if(mysqli_num_rows($result) > 0){
        $tabla.='<tr>
                    <td>Fuente</td>
                    <td>MedioPago</td>
                    <td>Producto/Servicio</td>
                    <td>Unidad</td>
                    <td>CodigoCuin</td>
                    <td>Valor</td>
                </tr>';

        while($row = mysqli_fetch_array($result)){
            $sqlr_fuente = "SELECT fuente_financiacion FROM ccpet_fuentes WHERE id_fuente = '$row[0]'";
            $result_fuente = mysqli_query($linkbd, $sqlr_fuente);
            $row_fuente = mysqli_fetch_array($result_fuente);

            $sqlr_bienes = "SELECT titulo FROM ccpetbienestransportables WHERE grupo = '$row[2]'";
            $result_bienes = mysqli_query($linkbd, $sqlr_bienes);
            $row_bienes = mysqli_fetch_array($result_bienes);
            $codigoProducto = $row[2];
            if($row_bienes[0] == ''){
                $sqlr_bienes = "SELECT titulo FROM ccpetservicios WHERE grupo = '$row[6]'";
                $result_bienes = mysqli_query($linkbd, $sqlr_bienes);
                $row_bienes = mysqli_fetch_array($result_bienes);
                $codigoProducto = $row[6];
            }

            $sqlr_unidad = "SELECT nombre FROM pptouniejecu WHERE id_cc = '".$_POST['unidadEjecutora']."'";
            $result_unidad = mysqli_query($linkbd, $sqlr_unidad);
            $row_unidad = mysqli_fetch_array($result_unidad);

            $sqlr_cuin = "SELECT nombre FROM ccpet_cuin WHERE codigo_cuin = '$row[3]'";
            $result_cuin = mysqli_query($linkbd, $sqlr_cuin);
            $row_cuin = mysqli_fetch_array($result_cuin);

            if($row[1] == 'CSF'){
                $medioPago = 'Con situacion de fondos';
                $valor = $row[4];
            }else{
                $medioPago = 'Sin situacion de fondos';
                $valor = $row[5];
            }

            $tabla.='<tr>
                        <td class="cssdeta">'.$row[0].' - '.$row_fuente[0].'</td>
                        <td class="cssdeta" >'.$medioPago.'</td>
                        <td class="cssdeta" >'.$codigoProducto.' - '.$row_bienes[0].'</td>
                        <td class="cssdeta" >'.$_POST['unidadEjecutora'].' - '.$row_unidad[0].'</td>
                        <td class="cssdeta" >'.$row[3].' - '.$row_cuin[0].'</td>
                        <td class="cssdeta" >'.number_format($valor, 2, ',', '.').'</td>
                    </tr>
                    ';
        }
    }
    
	 
    $tabla.='</table>';

    $data_row = array('detalle'=>$tabla);
    header('Content-Type: application/json');
    echo json_encode($data_row);