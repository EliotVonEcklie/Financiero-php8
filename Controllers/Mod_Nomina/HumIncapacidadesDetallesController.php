<?php
	include_once ($_SERVER['DOCUMENT_ROOT'].'/financiero/dirs.php');
	require_once (MODELS_PATH.'Mod_Nomina/HumIncapacidadesDetalles.php');
	require_once (ROOT_PATH.'conexion.php');
	class HumIncapacidadesDetallesController
	{
		public $Humincapdetalles;
		public function __construct(){}
		public function generarAllHumIncapasidadesDetalles($codigo='')
		{
			$this->Humincapdetallesa = HumIncapacidadesDetalles::where('num_inca', $codigo)->where('estado','<>','D')->get();
		}
		
	}
?>