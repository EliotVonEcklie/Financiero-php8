<?php
include_once ($_SERVER['DOCUMENT_ROOT'].'/financiero/dirs.php');
require_once (MODELS_PATH.'Tesopagotercerosvigant.php');
require_once (ROOT_PATH.'conexion.php');

class OtrosEgresosController
{
    public $numeroPago = 0;
    public function __construct()
    {
        $this->numeroPago = $this->generarConsecutivo() + 1;
    }
    public function generarConsecutivo()
    {
        return Tesopagotercerosvigant::max('id_pago');
    }
}
