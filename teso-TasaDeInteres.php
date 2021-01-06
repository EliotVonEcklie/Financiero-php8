<?php

ini_set('display_errors', '-1');
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);
require "comun.inc";
$linkbd=conectar_v7();


class tesoTasaDeInteres
{
    private $tasaInteres;
    private $valorBase;
    private $fechaVencimiento;
    private $fechaPago;
    private $interes;
    private $dias;
    private $interesAcumulado  = 0;

    //funcion que calcula los intereses y los va acumulando en la varable interes acumulado
    public function interesAcumulado()
    {
        $vigenciasDeuda = 0;
        $primeraVigenciaVencida = 0;
        $primerMesVencido = 0;
        
        
        $difInfor = $this->diferenciaEntreFechas($this->fechaVencimiento, $this->fechaPago);
        //var_dump($difInfor);
        $fechaDiv = explode('-',$this->fechaVencimiento);
        $primeraVigenciaVencida = $fechaDiv[0];
        $primerMesVencido = $fechaDiv[1];
        
        $vigenciasDeuda = $difInfor->y;
        $mesesPorVigencia = 0;
        $interesPorVigencia = 0;
        $interesPorVigencia = 0;
        /**
         * funcion que calcula los intereses mensuales segun la vigencia
         * @param int $primeraVigenciaVencida 
         */
        $interesPorVigencia = $this->tasasDeInteresMensuales($primeraVigenciaVencida);
        
        /**
         * se recorre los años que se calcularon en la la funcion diferencia entre fechas
         */
        for($xx=0; $xx<$vigenciasDeuda; $xx++)
        {
            $mesesPorVigencia = $primerMesVencido;
            for($yy=0; $yy<13; $yy++)
            {
                $dias=0;
                $dias = cal_days_in_month(CAL_GREGORIAN, $mesesPorVigencia, $primeraVigenciaVencida);
                $this->interesAcumulado += $this->calcularInteres($dias,$interesPorVigencia[$primeraVigenciaVencida][$mesesPorVigencia-1]);
                if($mesesPorVigencia==12)
                {
                    $mesesPorVigencia = 1;
                    $primeraVigenciaVencida+=1;
                    $interesPorVigencia = $this->tasasDeInteresMensuales($primeraVigenciaVencida);
                }
                else
                {
                    $mesesPorVigencia+=1;
                }
            }
            //$primeraVigenciaVencida+=1;
        }
        
        /**
         * se recorre los meses que se calcularon en la la funcion diferencia entre fechas
         */
        $mesesDeuda = $difInfor->m;
        for($xy = 0; $xy<$mesesDeuda-1; $xy++)
        {
            $dias=0;
            $dias = cal_days_in_month(CAL_GREGORIAN, $mesesPorVigencia, $primeraVigenciaVencida);
            $this->interesAcumulado += $this->calcularInteres($dias,$interesPorVigencia[$primeraVigenciaVencida][$mesesPorVigencia-1]);
            //echo $primeraVigenciaVencida."hola";
            //echo $interesPorVigencia[$primeraVigenciaVencida][$mesesPorVigencia-1]."<br>";
            if($mesesPorVigencia==12)
            {
                $mesesPorVigencia = 1;
                $primeraVigenciaVencida+=1;
                $interesPorVigencia = $this->tasasDeInteresMensuales($primeraVigenciaVencida);
            }
            else
            {
                $mesesPorVigencia+=1;
            }
        }
        /**
         * se calcula el interes de los dias restantes
         */
        //echo "$primeraVigenciaVencida -> ".$interesPorVigencia[$primeraVigenciaVencida][$mesesPorVigencia-1];
        //echo $mesesPorVigencia."hol";
        if($mesesPorVigencia == '')
        {
            $mesesPorVigencia = $primerMesVencido;
        }
        $this->interesAcumulado += $this->calcularInteres($difInfor->d,$interesPorVigencia[$primeraVigenciaVencida][$mesesPorVigencia-1]);
    }
    /**
         * la funcion diferenciaEntreFechas calcula la fiferencia entre dos fechas dadas y devuelve un array de la siguiente manera:
         * DateInterval Object
         *  (
          *      [y] => 0 // year
           *     [m] => 0 // month
            *    [d] => 2 // days
            *    [h] => 0 // hours
            *    [i] => 0 // minutes
            *    [s] => 0 // seconds
            *    [invert] => 0 // positive or negative 
            *    [days] => 2 // total no of days
            * )
            * y se consula de la siguiente manera:
            * will output 2 days
            * var_dump($diff);
            * echo $diff->days . ' year ';
            * @param text $fechaVenciada  fecha del vencimiento legal, donde empieza a correr el cobro.
            * @param text $fecha fecha de pago
         */
    private function diferenciaEntreFechas($fechaVenciada, $fecha)
    {
        $date1 = new DateTime("$fecha");
        $date2 = new DateTime("$fechaVenciada");
        $diff = $date1->diff($date2);
        return $diff;
    }

    /**
     * retorna el interes calculado
     * @param int $dias1
     * @param double $tasaInteres1
     */
    private function calcularInteres($dias1,$tasaInteres1)
    {
        $this->tasaInteres = $this->tasasDeInteresMensuales(2017);
        
        $interesDiario = $this->calcularInteresDiario($tasaInteres1);
        $this->interes = $dias1 * ($interesDiario/100) * $this->valorBase;
        return $this->interes;
    }
    
    /**
     * retorna el interes diario 
     * @param double $tasaInteresMensual
     * @param int $vigencia
     */
    private function calcularInteresDiario($tasaInteresMensual)
    {
        return $tasaInteresMensual/365;
    }

    private function tasasDeInteresMensuales($vigencia)
    {
        global $linkbd;
        $sqlr = "SELECT * FROM tesotasainteres WHERE vigencia>='$vigencia'";
        $res = mysqli_query($linkbd,$sqlr);
        while ($row = mysqli_fetch_assoc($res))
        {
            $mesesInteres[$row['vigencia']][] = $row['inmopri'];
            $mesesInteres[$row['vigencia']][] = $row['inmoseg'];
            $mesesInteres[$row['vigencia']][] = $row['inmoter'];
            $mesesInteres[$row['vigencia']][] = $row['inmocua'];
            $mesesInteres[$row['vigencia']][] = $row['inmoquin'];
            $mesesInteres[$row['vigencia']][] = $row['inmosex'];
            $mesesInteres[$row['vigencia']][] = $row['inmosep'];
            $mesesInteres[$row['vigencia']][] = $row['inmooct'];
            $mesesInteres[$row['vigencia']][] = $row['inmonov'];
            $mesesInteres[$row['vigencia']][] = $row['inmodec'];
            $mesesInteres[$row['vigencia']][] = $row['inmoonc'];
            $mesesInteres[$row['vigencia']][] = $row['inmodoc'];
        }
        return $mesesInteres;
    }
    
    
    public function getInteresesAcumulados()
    {
        return round($this->interesAcumulado);
    }
    public function setValorBase($valorBase)
    {
        $this->valorBase = $valorBase;
    }
    public function setFechaVencida($fechaVencimiento)
    {
        $this->fechaVencimiento = $fechaVencimiento;
    }
    public function setFechaPago($fechaPago)
    {
        $this->fechaPago = $fechaPago;
    }
}

$interesMensual = new tesoTasaDeInteres();
$interesMensual->setFechaVencida('2016-01-01');
$interesMensual->setFechaPago('2020-10-29');
$interesMensual->setValorBase(11415);
$calculoInteres = $interesMensual->interesAcumulado();
echo $interesMensual->getInteresesAcumulados();
//var_dump(round($calculoInteres,-3));

