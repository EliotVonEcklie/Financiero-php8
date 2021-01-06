<?php

class entradaController
{
    public $tipoMovimiento;
    public function __construct($tipoMovimiento)
    {
        $this->tipoMovimiento = $tipoMovimiento;
    }
    public function inicializar()
    {
        if($this->tipoMovimiento=='')
            $this->tipoMovimiento = 1;
    }
}