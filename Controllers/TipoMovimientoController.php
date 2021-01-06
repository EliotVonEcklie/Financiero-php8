<?php
include_once ($_SERVER['DOCUMENT_ROOT'].'/financiero/dirs.php');
require_once (MODELS_PATH.'Almtipomov.php');
require_once (ROOT_PATH.'conexion.php');

class TipoMovimientoController
{
    public $tipoEntrada;
    public $tipoMov;
    public function __construct($tipoMovimiento)
    {
        $this->tipoEntrada = $tipoMovimiento;
    }

    public function generarTiposDeEntrada()
    {
        $this->tipoMov = Almtipomov::where("tipom",$this->tipoEntrada)->get();
    }
}