<?php
	include_once ($_SERVER['DOCUMENT_ROOT'].'/financiero/dirs.php');
	require_once (MODELS_PATH.'HumRetencionesNomina.php');
	require_once (ROOT_PATH.'conexion.php');
	class HumRetencionesNominaController
	{
		public $allretencionesnomina;
		public $maxretencionesnomina;
		public $minretencionesnomina;
		public $saveretencionesnomina;
		public $actualizaretencionesnomina;
		public $activarretencionesnomina;
		public function __construct(){}
		public function generarAllRetencionesNomina($valorbusqueda='',$nombrecampo='')
		{
			if($valorbusqueda != ''){$this->allretencionesnomina=HumRetencionesNomina::where($nombrecampo,$valorbusqueda)->get();}
			else {$this->allretencionesnomina=HumRetencionesNomina::all();}
		}
		public function generarMaxRetencionesNomina()
		{
			$this->maxretencionesnomina=HumRetencionesNomina::max('id');
		}
		public function generarMinRetencionesNomina()
		{
			$this->minretencionesnomina=HumRetencionesNomina::min('id');
		}
		public function guardarRetencinesNomina()
		{
			$totalret=count(@$_POST['tfecha']);
			$totalf=0;
			for($x=0;$x<$totalret;$x++)
			{
				preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/",$_POST['tfecha'][$x],$fecha);
				$fechaf="$fecha[3]-$fecha[2]-$fecha[1]";
				$maxretencionesnomina=HumRetencionesNomina::max('id');
				$maxretencionesnomina+=1;
				$almretencionesnomina = new HumRetencionesNomina();
				$almretencionesnomina -> id = $maxretencionesnomina;
				$almretencionesnomina -> fecha = $fechaf;
				$almretencionesnomina -> tiporetencion = $_POST['ttreste'][$x];
				$almretencionesnomina -> docfuncionario = $_POST['ttercero'][$x];
				$almretencionesnomina -> nomfuncionario = $_POST['tntercero'][$x];
				$almretencionesnomina -> salbasico = $_POST['tsalbas'][$x];
				$almretencionesnomina -> valorretencion = $_POST['tvalrete'][$x];
				$almretencionesnomina -> mes = $_POST['tperiodo'][$x];
				$almretencionesnomina -> vigencia = $_POST['tvigencia'][$x];
				$almretencionesnomina -> estadopago = 'N';
				$almretencionesnomina -> estado = 'S';
				$sipasa = $almretencionesnomina -> save();
				if(!$sipasa){$totalf++;}
			}
			$this-> saveretencionesnomina = $totalf;
		}
		public function actualizarRetencinesNomina()
		{
			$actretencionesnomina = HumRetencionesNomina::find($_POST['codigo']);
			$actretencionesnomina -> tiporetencion = $_POST['tiporete'];
			$actretencionesnomina -> docfuncionario = $_POST['tercero'];
			$actretencionesnomina -> nomfuncionario = $_POST['ntercero'];
			$actretencionesnomina -> salbasico = $_POST['salbas'];
			$actretencionesnomina -> valorretencion = $_POST['valrete'];
			$actretencionesnomina -> mes = $_POST['periodo'];
			$actretencionesnomina -> vigencia = $_POST['vigencia'];
			$this -> actualizaretencionesnomina = $actretencionesnomina ->save();
		}
		public function actualizarEstadoRetencinesNomina($estado)
		{
			$actestadoretencionesnomina = HumRetencionesNomina::find($_POST['idestado']);
			$actestadoretencionesnomina -> estado = $estado;
			$this -> activarretencionesnomina = $actestadoretencionesnomina ->save();
		}
	}
?>