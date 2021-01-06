<?php
    include_once ($_SERVER['DOCUMENT_ROOT'].'/financiero/dirs.php');
    require_once (MODELS_PATH.'CcpetAcuerdos.php');
    require_once (ROOT_PATH.'conexion.php');

    class CcpetAcuerdosController{

        public function __construct(){}

        public function buscarAcuerdos($datos=''){
            $resAcuerdos = null;
            if(is_array($datos)){
                if(intval(@$datos['consecutivo']) == -1)
                    $resAcuerdos = CcpetAcuerdos::where('estado','!=','A')
                        ->orderBy('fecha','desc')->orderBy('vigencia','desc')->get();
                else{
                    array_shift($datos);
                    $sql = 'CcpetAcuerdos::';
                    $init = false;
                    foreach ($datos as $field => $value) {
                        if($field == 'sql_like'){
                            list($field,$value) = explode('=',$datos['sql_like']);
                            ($init) ? $sql = $sql.'->' : $init = true;
                            $sql = $sql."where('$field','LIKE','%$value%')";
                            unset($datos['sql_like']);
                        } else if($field == 'sql_between'){
                            preg_match_all("/\d{4}\-\d{1,2}\-\d{1,2}/",$datos['sql_between'], $dates);
                            ($init) ? $sql = $sql.'->' : $init = true;
                            $sql = $sql."whereBetween('fecha',['".$dates[0][0]."','".$dates[0][1]."'])";
                            unset($datos['sql_between']);
                        }
                    }

                    if(count(@$datos) > 0){
                        ($init) ? $sql = $sql.'->' : $init = true;
                        $data = str_replace(["{","}",":"],["[","]","=>"], json_encode($datos));
                        $sql = $sql."where($data)->get();";
                    }else{
                        ($init) ? $sql = $sql.'->' : $init = true;
                        $sql = $sql."where([])->get();";
                    }

                    eval('$resAcuerdos = '.$sql.';');
                }
            }
            return $resAcuerdos;
        }

        public function guardarAcuerdos($datos){
            $fecha = [];
            preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/",$_POST['fecha'],$fecha);
            if(is_array($datos)){
                if ($datos['proceso'] == 'PPTOACUERDOS_GUARDAR'){
                    $almPptoAcuerdos = new CcpetAcuerdos();
                    $almPptoAcuerdos -> consecutivo = $datos['consecutivo'];
                    $almPptoAcuerdos -> numero_acuerdo = $datos['acuerdo'];
                    $almPptoAcuerdos -> fecha = "$fecha[3]-$fecha[2]-$fecha[1]";
                    $almPptoAcuerdos -> vigencia = $fecha[3];
                    $almPptoAcuerdos -> estado = $datos['estado'];
                    $almPptoAcuerdos -> tipo = $datos['tipo'];
                    $almPptoAcuerdos -> tipo_acto_adm = $datos['tipo_acto_adm'];
                    $almPptoAcuerdos -> valorinicial = $datos['valor_inicial'];
                    $almPptoAcuerdos -> valoradicion = $datos['valor_adicion'];
                    $almPptoAcuerdos -> valorreduccion = $datos['valor_reduccion'];
                    $almPptoAcuerdos -> valortraslado = $datos['valor_traslado'];
                    $verifPptoAcuerdos = $almPptoAcuerdos -> save();
                } else if ($datos['proceso'] == 'PPTOACUERDOS_EDITAR'){
                    $almPptoAcuerdos = CcpetAcuerdos::find($datos['id_acuerdo']);
                    $almPptoAcuerdos -> consecutivo = $datos['consecutivo'];
                    $almPptoAcuerdos -> numero_acuerdo = $datos['acuerdo'];
                    $almPptoAcuerdos -> fecha = "$fecha[3]-$fecha[2]-$fecha[1]";
                    $almPptoAcuerdos -> vigencia = $fecha[3];
                    $almPptoAcuerdos -> estado = $datos['estado'];
                    $almPptoAcuerdos -> tipo = $datos['tipo'];
                    $almPptoAcuerdos -> tipo_acto_adm = $datos['tipo_acto_adm'];
                    $almPptoAcuerdos -> valorinicial = $datos['valor_inicial'];
                    $almPptoAcuerdos -> valoradicion = $datos['valor_adicion'];
                    $almPptoAcuerdos -> valorreduccion = $datos['valor_reduccion'];
                    $almPptoAcuerdos -> valortraslado = $datos['valor_traslado'];
                    $verifPptoAcuerdos = $almPptoAcuerdos -> save();
                }

                if($verifPptoAcuerdos == 1)
                    return 0;
            }
        }

        public function anularAcuerdos($datos){
            if(is_array($datos)){
                $almPptoAcuerdos = CcpetAcuerdos::find($datos['id_acuerdo']);
                $almPptoAcuerdos -> estado = $datos['estado'];
                $verifPptoAcuerdos = $almPptoAcuerdos -> save();
                if($verifPptoAcuerdos == 1)
                    return 0;
            }
        }
    }