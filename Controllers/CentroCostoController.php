<?php
include_once ($_SERVER['DOCUMENT_ROOT'].'/financiero/dirs.php');
require_once (MODELS_PATH.'CentroCosto.php');
require_once (ROOT_PATH.'conexion.php');

class CentroCostoController
{
    public $cc;
    public function __construct()
    {
    }

    public function generarCentroCosto()
    {
        $condiciones = ['estado' => 'S', 'entidad' => 'S'];
        $this->cc = CentroCosto::where($condiciones)->get();
    }
}
