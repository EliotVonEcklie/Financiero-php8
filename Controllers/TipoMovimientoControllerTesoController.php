<?php
include_once ($_SERVER['DOCUMENT_ROOT'].'/financiero/dirs.php');
require_once (MODELS_PATH.'Tipo_movdocumentos.php');
require_once (ROOT_PATH.'conexion.php');

class TipoMovimientoControllerTesoController
{
    public $tipoMov = '';
    private $condiciones='';
    public function __construct()
    {
    }
    public function obtenerTipoMovimiento($codigo,$modulo)
    {
        $condiciones = ['codigo' => $codigo, 'modulo' => $modulo];
        $this->tipoMov = Tipo_movdocumentos::where($condiciones)->get(['id','codigo','descripcion']);
    }

}
