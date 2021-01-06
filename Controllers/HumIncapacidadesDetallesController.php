<?php
	require_once ('/../Models/HumIncapacidadesDetalles.php');
	require_once ('/../conexion.php');
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