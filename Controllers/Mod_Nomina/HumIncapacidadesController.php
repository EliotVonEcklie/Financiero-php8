<?php
	include_once ($_SERVER['DOCUMENT_ROOT'].'/financiero/dirs.php');
	require_once (MODELS_PATH.'Mod_Nomina/HumIncapacidades.php');
	require_once (ROOT_PATH.'conexion.php');
	class HumIncapacidadesController
	{
		public $Humincap;
		public $Humincapasidades;
		public $activarincapasidades;
		public $maxincapasidades;
		public $minincapasidades;
		public function __construct(){}
		public function generarAllHumIncapasidades($documento='',$nombre='')
		{
			if($documento != ''){$this->Humincap = HumIncapacidades::where('doc_funcionario', $_POST['numdoc'])->get();}
			elseif($nombre != ''){$this->Humincap = HumIncapacidades::where('nom_funcionario', $_POST['nombrefun'])->get();}
			else {$this->Humincap = HumIncapacidades::orderBy('num_inca','DESC')->get();}
		}
		public function generarHumIncapasidades($codigo='')
		{
			$this->Humincapasidades = HumIncapacidades::where('num_inca', $codigo)->get();
		}
		public function actualizarEstadoIncapasidades($estado)
		{
			$actestadoincapasidades= HumIncapacidades::find($_POST['idestado']);
			$actestadoincapasidades -> estado = $estado;
			$this -> activarincapasidades = $actestadoincapasidades ->save();
		}
		public function generarMaxIncapasidades()
		{
			$this->maxincapasidades=HumIncapacidades::max('num_inca');
		}
		public function generarMinIncapasidades()
		{
			$this->minincapasidades=HumIncapacidades::min('num_inca');
		}
	}
?>