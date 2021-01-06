<?php 
error_reporting(E_ALL);
ini_set('display_errors', '1');
class Predial
{
    private $avaluo;
    private $tasaPorMil;

    function __construct()
    {
    }

    public function setAvaluo($avaluo)
    {
        $this->avaluo = $avaluo;
    }

    public function setTasaPorMil($tasaPorMil)
    {
        $this->tasaPorMil = $tasaPorMil;
    }

    public function calcularDeudaPredial()
    {
        $this->deudaPredial = ($this->avaluo/1000) * $this->tasaPorMil;
        return $this->deudaPredial;
    }
}

$predial = new Predial();
$predial->setAvaluo(11488000);
$predial->setTasaPorMil(5);
$valorPredial = $predial->calcularDeudaPredial();
var_dump($valorPredial);