<?php

include_once ($_SERVER['DOCUMENT_ROOT'].'/financiero/dirs.php');
require_once (MODELS_PATH.'PptoCuentas.php');
require_once (ROOT_PATH.'conexion.php');
/* Functiones de acceso global */

class FunctionsController {

	/*Varibales*/
	private $condAnd;
	private $condOr;
	private $result;

	public function __constructor(){}

	/** Función para la busqueda de cuentas presupuestales */
	public function buscaCuentaPres($cuenta = '', $vigencia = ''){
		$result = null;
		$condAnd = [
			'cuenta' => $cuenta,
			'vigencia' => $vigencia,
			'vigenciaf' => $vigencia
		];
		$result = PptoCuentas::where($condAnd)->select('nombre')->first();
		return $result;
	}
}
?>
