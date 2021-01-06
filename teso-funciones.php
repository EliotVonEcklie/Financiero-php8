<?php

require_once 'Controllers/TesoRetencionesController.php';
require_once 'Controllers/TesoRetencionesDetController.php';
require_once 'Controllers/ConceptosContablesDetController.php';
require_once 'Controllers/Mod_Tesoreria/GastoBancarioDetController.php';

switch (@$_POST['proceso']) {
    case 'CUENTA_CONTABLE_RETENCION_INGRESOS':
        if($_POST['reteIng']=='R')
        {
            $idRetencion = buscarIdTesoRetenciones($_POST['numReteIng']);
            $parametrosConceptos = parametrosParaBuscarConceptoContableRetenciones($idRetencion);

            $fechaBase = cambiarFormatoFecha($_POST['fechaInicial']);
            $tipoR = substr($parametrosConceptos["tipo"],-2);
            $cuentaCont = buscaCuentaContable($parametrosConceptos["codigo"], $tipoR, $_POST['cc'], $parametrosConceptos["modulo"], $fechaBase);
            echo $cuentaCont["cuenta"];
        }
        else
        {

        }
        
	break;
	default:break;
}

function buscarIdTesoRetenciones($codigo)
{
    $retencion = new TesoRetencionesController();
    $valorBusqueda = $codigo;
    $nombreCampo = 'codigo';
    $retencion->generarAllTesoRetenciones($valorBusqueda,$nombreCampo);
    $idRetencion = $retencion->alltesoretenciones;
    return $idRetencion[0]['id'];
}

function parametrosParaBuscarConceptoContableRetenciones($idRetencion)
{
    $retencionDet = new TesoRetencionesDetController();
    $valorBusquedaDet = $idRetencion;
    $nombreCampoDet = 'codigo';
    $retencionDet->generarAllTesoRetencionesDet($valorBusquedaDet,$nombreCampoDet);
    $retenciones = $retencionDet->retenciones;
    $parametros = [
        "codigo"=> $retenciones[0]["conceptoingreso"],
        "tipo"=> $retenciones[0]["tipoconce"],
        "modulo"=> $retenciones[0]["modulo"]
    ];
    return $parametros;
}

function buscaCuentaContable($codigo, $tipo, $cc, $modulo, $fechaInicial)
{
    $cuentaContable = new ConceptosContablesDetController();
    $cuentaContable->generarCuentaContable($codigo, $tipo, $cc, $modulo, $fechaInicial);
    return $cuentaContable->cuentaContable;
}

function buscaCuentaPresupuestalNotaBanco($codigo,$vigencia)
{
    $cuentaPres = new GastoBancarioDetController();
    $cuentaPres->buscarCuentaPresupuestal($codigo,$vigencia);
    return $cuentaPres->getcuentaPresupuestal();
	
}

function cambiarFormatoFecha($fecha)
{
    preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/",$fecha,$fecha);
    $fechaf="$fecha[3]-$fecha[2]-$fecha[1]";
    
    return $fechaf;
}