<?php
include_once ($_SERVER['DOCUMENT_ROOT'].'/financiero/dirs.php');
require_once (MODELS_PATH.'TesoGastosBancarios.php');
require_once (ROOT_PATH.'conexion.php');

class GastoBancarioController
{
    private $gastoBancario;
    public function __construct()
    {
    }

    public function generarGastoBancario()
    {
        $condiciones = ['estado' => 'S'];
        $this->gastoBancario = TesoGastosBancarios::where($condiciones)->get();
    }

    public function getGastoBancario()
    {
        return $this->gastoBancario;
    }
}