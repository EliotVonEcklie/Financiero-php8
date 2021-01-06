<?php
include_once ($_SERVER['DOCUMENT_ROOT'].'/financiero/dirs.php');
require_once (MODELS_PATH.'Almginventario.php');
require_once (ROOT_PATH.'conexion.php');

class AlmginventarioController extends TipoMovimientoController
{
    public $consecutivo;
    private $condiciones;
    public function __construct()
    {

    }

    public function generarConsecutivo($tipoMov, $tipoEntrada)
    {
        $condiciones = ['tipo_mov' => $tipoMov, 'tipo_reg' => $tipoEntrada];
        $this->consecutivo = Almginventario::where($condiciones)->max('consecutivo');
    }
}
