<?php
include_once ($_SERVER['DOCUMENT_ROOT'].'/financiero/dirs.php');
require_once (MODELS_PATH.'PptoRp.php');
require_once (MODELS_PATH.'PptoCdp.php');
require_once (ROOT_PATH.'validaciones.inc');

class PptoRPSController{

	public function __construct(){}

	public function buscarRPS($datos=''){
		if(is_array($datos)){
			$condicones = [
				'pptorp.tipo_mov' => '201',
				'pptocdp.tipo_mov' => '201',
				'pptorp.vigencia' => 2019,
				'pptocdp.vigencia' => 2019,
			];
			$almPptoRPS = PptoRp::join('pptocdp','idcdp','=','pptocdp.consvigencia')
			->select('pptorp.vigencia','pptorp.consvigencia','pptocdp.objeto','pptorp.estado','pptocdp.consvigencia','pptorp.valor','pptorp.saldo','pptorp.tercero')
			->where($condicones)
			->get();

			return $almPptoRPS;
		}
	}
}
?>
