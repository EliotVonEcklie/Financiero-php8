<?php
	include_once ($_SERVER['DOCUMENT_ROOT'].'/financiero/dirs.php');
	require_once (MODELS_PATH.'/Mod_General/Meses.php');
	require_once (ROOT_PATH.'conexion.php');
	class MesesController
	{
		public $allmeses;
		public function generarAllMeses($valorbusqueda='',$nombrecampo='')
		{
			if($valorbusqueda != ''){$this->allmeses=Meses::where($nombrecampo,$valorbusqueda)->get();}
			else {$this->allmeses=Meses::all();}
		}
	}
?>