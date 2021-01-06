<?php
/**
 * Switch case para seleccionar el proceso el llamado al controlador pertinente
 * Se evalua el valor obtenido de $_POST
 */
include_once ($_SERVER['DOCUMENT_ROOT'].'/financiero/dirs.php');
require_once (CONTROLLERS_PATH.'PptoCuentasController.php');
require_once (CONTROLLERS_PATH.'PptoAcuerdosController.php');
require_once (CONTROLLERS_PATH.'PptoRPSController.php');

switch ($_POST['proceso']) {
	case 'PPTOCUENTAS_GUARDAR':
		$PptoCuentas = new PptoCuentasController();
		$ResultPptoCuentas = $PptoCuentas->guardarCuentas($_POST);
		echo $ResultPptoCuentas;
		break;
	case 'PPTOACUERDOS_BUSCAR':
	case 'PPTOACUERDOS_FILTRAR':
		$PptoAcuerdos = new PptoAcuerdosController();
		$ResultPptoAcuerdos = $PptoAcuerdos->buscarAcuerdos($_POST);
		echo $ResultPptoAcuerdos;
		break;
	case 'PPTOACUERDOS_GUARDAR';
	case 'PPTOACUERDOS_EDITAR':
		$PptoAcuerdos = new PptoAcuerdosController();
		$ResultPptoAcuerdos = $PptoAcuerdos->guardarAcuerdos($_POST);
		echo $ResultPptoAcuerdos;
		break;
	case 'PPTOACUERDOS_ANULAR':
		$PptoAcuerdos = new PptoAcuerdosController();
		$ResultPptoAcuerdos = $PptoAcuerdos->anularAcuerdos($_POST);
		echo $ResultPptoAcuerdos;
		break;
	case 'PPTORPS_BUSCAR':
		$PptoRPS = new PptoRPSController();
		$ResultPptoRPS = $PptoRPS->buscarRPS($_POST);
		echo $ResultPptoRPS;
	default:break;
}
?>