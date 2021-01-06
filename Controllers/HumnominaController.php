<?php
	require_once('/../Models/Humnomina.php');
	require_once('/../conexion.php');
	class HumnominaController
	{
		public $numnomina;
		public function __construct()
		{
			
		}
		public function generarNumeroNomina()
		{
			$this->numnomina=Humnomina::all();
		}
	}

?>