<?php
include_once ($_SERVER['DOCUMENT_ROOT'].'/financiero/dirs.php');
require_once (MODELS_PATH.'TesoNotasBancariasDet.php');
require_once (ROOT_PATH.'conexion.php');

class NotasBancariasDetController
{
    private $NotaBancariaDet = 0;
    public function __construct()
    {
    }

    public function buscarNotaBancariaDet($notaBancaria)
    {
        $condiciones = ['id_notabancab' => $notaBancaria];
        $this->NotaBancariaDet = TesoNotasBancariasDet::where($condiciones)->get();
    }
        
    public function getNotaBancariaDet()
    {
        return $this->NotaBancariaDet;
    }
}