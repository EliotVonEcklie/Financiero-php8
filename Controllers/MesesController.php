<?php
	require_once '/../Models/Meses.php';
	require_once '/../conexion.php';
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