<?php
/**
 * Switch case para seleccionar el proceso el llamado al controlador pertinente
 * Se evalua el valor obtenido de $_POST
 */
include_once ($_SERVER['DOCUMENT_ROOT'].'/financiero/dirs.php');
require_once (CONTROLLERS_PATH.'TesoController.php');
require_once (CONTROLLERS_PATH.'TesoNotasBancariasController.php');
require_once (CONTROLLERS_PATH.'/Mod_Tesoreria/NotasBancariasController.php');
require_once (CONTROLLERS_PATH.'/Mod_Tesoreria/NotasBancariasDetController.php');
require_once (CONTROLLERS_PATH.'/Mod_Tesoreria/TesoBancosCtasController.php');

switch ($_POST['proceso']) {
	case 'TESO_BUSCARPARAMETROS':
		$Tesoreria = new TesoController();
		$ResultTesoreria = $Tesoreria->buscarParametrosTeso($_POST);
		echo json_encode($ResultTesoreria);
	break;
	case 'TESO_BUSCARCUENTAS':
		$Tesoreria = new TesoController();
		$ResultTesoreria = $Tesoreria->buscarCuentasTeso($_POST);
		echo json_encode($ResultTesoreria);
	break;
	case 'TESO_GUARDARPARAMETROS':
		$Tesoreria = new TesoController();
		$ResultTesoreria = $Tesoreria->guardarParametrosTeso($_POST);
		echo json_encode($ResultTesoreria);
	break;
	case 'TESO_BUSCARPARAMETROS_NOTAS':
		$TesoNotas = new TesoNotasBancariasController();
		$ResultNotas = $TesoNotas->buscarParametrosNotas($_POST);
		echo json_encode($ResultNotas);
	break;
	case 'TESO_GUARDAR_NOTAS':
		$TesoNotas = new TesoNotasBancariasController();
		$ResultNotas = $TesoNotas->guardarNotasBanca($_POST);
		echo json_encode($ResultNotas);
	break;
	case 'TESO_EDITAR_NOTAS':
		$TesoNotas = new TesoNotasBancariasController();
		$ResultNotas = $TesoNotas->editarNotasBanca($_POST);
		echo json_encode($ResultNotas);
	break;
	case 'TESO_REVERSAR_NOTAS':
		$TesoNotas = new TesoNotasBancariasController();
		$ResultNotas = $TesoNotas->reversarNotasBanca($_POST);
		echo json_encode($ResultNotas);
	break;
	case 'TESO_BUSCARDETALLES_RP':
		$TesoNotas = new TesoNotasBancariasController();
		$ResultNotas = $TesoNotas->buscarDetallesRpNotas($_POST);
		echo json_encode($ResultNotas);
	break;
	case 'TESO_HISTORIAL_NOTAS':
	case 'TESO_FILTRAR_NOTAS':
		$TesoNotas = new TesoNotasBancariasController();
		$ResultNotas = $TesoNotas->buscarHistorialNotas($_POST);
		echo json_encode($ResultNotas);
	break;
	case 'GUARDAR_GASTO_BANCARIO':
		$notaBancaria = new NotasBancariasController();
		$respuesta = $notaBancaria->guardarNotaBancaria($_POST);
		echo json_encode($respuesta);
	break;
	case 'DETALLES_GASTO_BANCARIO':
		$notaBancariaDet = new NotasBancariasDetController();
		$notaBancariaDet->buscarNotaBancariaDet($_POST['numeroNota']);
		$respuesta = $notaBancariaDet->getNotaBancariaDet();
		
		$cuentaBanco = new TesoBancosCtasController();
		$cuentaBanco->buscarCuentaBanco('ncuentaban', $respuesta[0]['ncuentaban']);
		$respuesta[] =  $cuentaBanco->getcuentaBanco();
		echo json_encode($respuesta);
	break;
	case 'EDITAR_GASTO_BANCARIO':
		$notaBancaria = new NotasBancariasController();
		$respuesta = $notaBancaria->editarNotaBancaria($_POST);
		echo json_encode($respuesta);
	break;
	default:break;
}
?>
