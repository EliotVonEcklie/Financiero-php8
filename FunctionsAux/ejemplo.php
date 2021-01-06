<?php
	include_once ($_SERVER['DOCUMENT_ROOT'].'/financiero/dirs.php');
	require_once (MODELS_PATH.'Mod_Tesoreria/TesoGastosBancarios.php');
	require_once (ROOT_PATH.'conexion.php');
	$arrayGastosBancarios = explode("-","01");
	$gastoBancarioTipo = TesoGastosBancarios::find($arrayGastosBancarios[0]);
	var_dump($gastoBancarioTipo['tipo']);