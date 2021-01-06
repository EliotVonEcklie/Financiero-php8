<?php
/**
 * Switch case para seleccionar el proceso el llamado al controlador pertinente
 * Se evalua el valor obtenido de $_POST
 */
include_once ($_SERVER['DOCUMENT_ROOT'].'/financiero/dirs.php');
require_once (CONTROLLERS_PATH.'ActiActivosFisicosController.php');

switch ($_POST['proceso']) {
	case 'ACTIACTIVOSFISICOS_BUSCARACTIVO':
		$ActiActivosFisicos = new ActiActivosFisicosController();
		$ResultActiActivosFisicos = $ActiActivosFisicos->buscarActivoFisico($_POST);
		echo json_encode($ResultActiActivosFisicos);
	break;
	case 'ACTIACTIVOSFISICOS_BUSCARACTIVO_RESPONSABLE':
		$ActiActivosFisicos = new ActiActivosFisicosController();
		$ResultActiActivosFisicos = $ActiActivosFisicos->buscarActivoFisicoResp($_POST);
		echo json_encode($ResultActiActivosFisicos);
	break;
	case 'ACTIACTIVOSFISICOS_HISTORIALTRASLADO_RESPONSABLE':
		$ActiActivosFisicos = new ActiActivosFisicosController();
		$ResultActiActivosFisicos = $ActiActivosFisicos->buscarHistorialActivoResp($_POST);
		echo $ResultActiActivosFisicos;
	break;
	case 'ACTIACTIVOSFISICOS_HISTORIALTRASLADO_DETALLES':
	case 'ACTIACTIVOSFISICOS_FILTRARTRASLADOS_DETALLES':
		$ActiActivosFisicos = new ActiActivosFisicosController();
		$ResultActiActivosFisicos = $ActiActivosFisicos->buscarHistorialActivoDeta($_POST);
		echo json_encode($ResultActiActivosFisicos);
	break;
	case 'ACTIACTIVOSFISICOS_GUARDARTRASLADO_RESPONSABLE':
		$ActiActivosFisicos = new ActiActivosFisicosController();
		$ResultActiActivosFisicos = $ActiActivosFisicos->guardarTrasladoActivoResp($_POST);
		echo $ResultActiActivosFisicos;
	break;
	case 'ACTIACTIVOSFISICOS_GUARDARTRASLADO_DETALLES':
		$ActiActivosFisicos = new ActiActivosFisicosController();
		$ResultActiActivosFisicos = $ActiActivosFisicos->guardarTrasladoActivoDeta($_POST);
		echo $ResultActiActivosFisicos;
	break;
	case 'ACTIACTIVOSFISICOS_BUSCARPARAMETROS':
		$ActiActivosFisicos = new ActiActivosFisicosController();
		$ResultActiActivosFisicos = $ActiActivosFisicos->buscarParametrosActivos($_POST);
		echo $ResultActiActivosFisicos;
	break;
	case 'ACTIACTIVOSFISICOS_GUARDARPARAMETROS':
		$ActiActivosFisicos = new ActiActivosFisicosController();
		$ResultActiActivosFisicos = $ActiActivosFisicos->guardarParametrosActivos($_POST);
		echo $ResultActiActivosFisicos;
	break;
	case 'ACTIACTIVOSFISICOS_BUSCARDETALLES':
		$ActiActivosFisicos = new ActiActivosFisicosController();
		$ResultActiActivosFisicos = $ActiActivosFisicos->buscarDetallesActivos($_POST);
		echo $ResultActiActivosFisicos;
	break;
	default:break;
}
?>