<?php
include_once ($_SERVER['DOCUMENT_ROOT'].'/financiero/dirs.php');
require_once (CONTROLLERS_PATH.'CentroCostoController.php');
require_once (CONTROLLERS_PATH.'FunctionsController.php');
require_once (CONTROLLERS_PATH.'ConceptosContablesDetController.php');
require_once (MODELS_PATH.'PptoRpDetalle.php');
require_once (MODELS_PATH.'ComprobanteCab.php');
require_once (MODELS_PATH.'ComprobanteDet.php');
require_once (MODELS_PATH.'TesoNotasBancariasCab.php');
require_once (MODELS_PATH.'TesoNotasBancariasDet.php');
require_once (MODELS_PATH.'TesoGastosBancarios.php');
require_once (MODELS_PATH.'TesoGastosBancariosDet.php');
require_once (MODELS_PATH.'PptoNotasBanPpto.php');
require_once (MODELS_PATH.'Terceros.php');
require_once (MODELS_PATH.'Transaccion.php');
require_once (ROOT_PATH.'conexion.php');
require_once (ROOT_PATH.'comun.inc');
require_once (ROOT_PATH.'validaciones.inc');

/**
 * Clase controlador con funciones para las notas bancarias
 * Importa modelos relacionados a las notas bancarias
 */
class  TesoNotasBancariasController{
	public function __construct(){}

	/**
	 * Función para buscar el max id
	 * Se retronar el max id
	 */
	public function maxTesoNotasBancariasCab(){
		return TesoNotasBancariasCab::max('id_notaban');
	}

	/**
	 * Función para buscar parametros para las notas bancarias
	 * Se retronar información los parametros
	 * @param Array $datos
	*/
	public function buscarParametrosNotas($datos=''){
		$resParametrosNotas = array();
		if(is_array($datos)){
			array_shift($datos);
			$CCosto = new CentroCostoController();
			$CCosto->generarCentroCosto();
			$condiciones = [
				'estado' => 'S'
			];
			$resParametrosNotas['id_comp'] = $this->maxTesoNotasBancariasCab() + 1;
			$resParametrosNotas['ccosto'] = $CCosto->cc;
			$resParametrosNotas['gasto_banca'] = TesoGastosBancarios::where($condiciones)->get();
		}
		return $resParametrosNotas;
	}

	/**
	 * Función para buscar parametros para las notas bancarias
	 * Se retronar información los parametros
	 * @param Array $datos
	*/
	public function buscarDetallesRpNotas($datos=''){
		$resDetallesRp = null;
		if(is_array($datos)){
			array_shift($datos);
			$resDetallesRp = PptoRpDetalle::where($datos)->get();
			foreach ($resDetallesRp as $pos => $detalleRp) {
				$functions = new FunctionsController();
				$detalleRp['saldo'] = generaSaldoRPxcuenta($detalleRp['consvigencia'], $detalleRp['cuenta'], $detalleRp['vigencia']);
				$detalleRp['ncuenta'] = $functions->buscaCuentaPres($detalleRp['cuenta'],$detalleRp['vigencia']);
			}
		}
		return $resDetallesRp;
	}

	/**
	 * Función para guardar información de los parametros del control activos físico
	 * Se evalua si existe parametros
	 * Se retorna valor para validación de la operación
	 * @param Array $datos
	 */
	public function guardarNotasBanca($datos=''){
		if(is_array($datos)){
			$fecha = [];
			preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/",$datos['fecha'],$fecha);
			$fecha_reg = "$fecha[3]-$fecha[2]-$fecha[1]";

			$condiciones=[
				'id_notaban' => @$datos['id_comp'],
				'estado' => 'S'
			];
			$almTesoNotasCab = TesoNotasBancariasCab::where($condiciones)->first();
			if(count($almTesoNotasCab)==0)
				$almTesoNotasCab = new TesoNotasBancariasCab();
			$almTesoNotasCab -> id_comp = 0;
			$almTesoNotasCab -> fecha = $fecha_reg;
			$almTesoNotasCab -> vigencia = $fecha[3];
			$almTesoNotasCab -> estado = $datos['estado'];
			$almTesoNotasCab -> concepto = $datos['concepto'];
			$almTesoNotasCab -> tipo_mov = $datos['tipo_mov'];
			$almTesoNotasCab -> user = $datos['nickusu'];
			//var_dump(json_encode($almTesoNotasCab));
			$verifTesoNotasCab = $almTesoNotasCab -> save();
			if($verifTesoNotasCab)
				$datos['id_comp'] = $almTesoNotasCab -> id_notaban;

			$condiciones=[
				'numerotipo' => @$datos['id_comp'],
				'estado' => '1',
				'tipo_comp' => 9
			];
			$almCompCab = ComprobanteCab::where($condiciones)->first();
			if(count($almCompCab)==0)
				$almCompCab = new ComprobanteCab();
			$almCompCab -> fecha = $fecha_reg;
			$almCompCab -> numerotipo = $datos['id_comp'];
			$almCompCab -> tipo_comp = 9;
			$almCompCab -> concepto = $datos['concepto'];
			$almCompCab -> total = 0;
			$almCompCab -> total_debito = $datos['total'];
			$almCompCab -> total_credito = $datos['total'];
			$almCompCab -> diferencia = 0;
			$almCompCab -> estado = '1';
			//var_dump(json_encode($almCompCab));
			$verifCompCab = $almCompCab -> save();

			//Verificado guardado de datos
			$ConceptosContablesDetalles = new ConceptosContablesDetController();
			foreach ($datos as $index => $detalle) {
				if(is_array($detalle)){
					$condiciones =[
						'tesogastosbancarios_det.tipoconce'=> 'GB',
						'tesogastosbancarios_det.modulo' => '4',
						'tesogastosbancarios_det.codigo' => $detalle['gasto_banca'],
						'tesogastosbancarios_det.estado' => $datos['estado'],
						'tesogastosbancarios_det.vigencia' => $fecha[3]
					];
					$resTesoGastosBanca = TesoGastosBancariosDet::join('tesogastosbancarios','tesogastosbancarios_det.codigo','=','tesogastosbancarios.codigo')
					->where($condiciones)
					->select('concepto','cuentapres','tipo')
					->get()->first();

					$ConceptosContablesDetalles->generarCuentaContable($resTesoGastosBanca['concepto'],'GB',$detalle['ccosto'],'4',$fecha_reg);
					$resConceptoConta = $ConceptosContablesDetalles->cuentaContable;

					$almTesoNotasDet = new TesoNotasBancariasDet();
					$almTesoNotasDet -> id_notabancab = $datos['id_comp'];
					$almTesoNotasDet -> fecha = $fecha_reg;
					$almTesoNotasDet -> docban = $detalle['num_banco'];
					$almTesoNotasDet -> cc = $detalle['ccosto'];
					$almTesoNotasDet -> ncuentaban = $detalle['cuenta_banca'];
					$almTesoNotasDet -> tercero = $detalle['tccuenta_banca'];
					$almTesoNotasDet -> gastoban = $detalle['gasto_banca'];
					$almTesoNotasDet -> cheque = '';
					$almTesoNotasDet -> valor = $detalle['valor'];
					$almTesoNotasDet -> estado = $datos['estado'];
					$almTesoNotasDet -> tipo_mov = $datos['tipo_mov'];
					$almTesoNotasDet -> user = $datos['nickusu'];
					//$almTesoNotasDet -> rp = $detalle['rp'];
					//$almTesoNotasDet -> rubro = $detalle['cuenta_rubro'];
					//var_dump(json_encode($almTesoNotasDet));
					$verifTesoNotasDet = $almTesoNotasDet -> save();

					if($resTesoGastosBanca['tipo'] == 'G' && $resConceptoConta['tipocuenta'] == 'N'){//GASTO & NOTA BANCARIA DETALLE CONTABLE
						$almCompDet = new ComprobanteDet();
						$almCompDet -> id_comp = '9 '.$datos['id_comp'];
						$almCompDet -> cuenta = $resConceptoConta['cuenta'];
						$almCompDet -> tercero = $detalle['tccuenta_banca'];
						$almCompDet -> centrocosto = $detalle['ccosto'];
						$almCompDet -> detalle = 'Doc Banco '.$detalle['num_banco'];
						$almCompDet -> cheque = '';
						$almCompDet -> valdebito = $detalle['valor'];
						$almCompDet -> valcredito = 0;
						$almCompDet -> estado = 1;
						$almCompDet -> vigencia = $fecha[3];
						//var_dump(json_encode($almCompDet));
						$verifCompDet = $almCompDet -> save();
						
						$almCompDet2 = new ComprobanteDet();
						$almCompDet2 -> id_comp = '9 '.$datos['id_comp'];
						$almCompDet2 -> cuenta = $detalle['ccuenta_banca'];
						$almCompDet2 -> tercero = $detalle['tccuenta_banca'];
						$almCompDet2 -> centrocosto = $detalle['ccosto'];
						$almCompDet2 -> detalle = 'Doc Banco '.$detalle['num_banco'];
						$almCompDet2 -> cheque = '';
						$almCompDet2 -> valdebito = 0;
						$almCompDet2 -> valcredito = $detalle['valor'];
						$almCompDet2 -> estado = 1;
						$almCompDet2 -> vigencia = $fecha[3];
						//var_dump(json_encode($almCompDet2));
						$verifCompDet2 = $almCompDet2 -> save();

						$almPptoNotaBanca = new PptoNotasBanPpto();
						$almPptoNotaBanca -> cuenta = $detalle['cuenta_rubro'];
						$almPptoNotaBanca -> idrecibo = $datos['id_comp'];
						$almPptoNotaBanca -> valor = $detalle['valor'];
						$almPptoNotaBanca -> vigencia = $fecha[3];
						$almPptoNotaBanca -> rp = $detalle['rp'];
						//var_dump(json_encode($almPptoNotaBanca));
						$verifPptoNotaBanca = $almPptoNotaBanca -> save();

					} else if($resTesoGastosBanca['tipo']=='I' && $resConceptoConta['tipocuenta'] == 'N'){//INGRESO & NOTA BANCARIA DETALLE CONTABLE
						$almCompDet = new ComprobanteDet();
						$almCompDet -> id_comp = '9 '.$datos['id_comp'];
						$almCompDet -> cuenta = $resConceptoConta['cuenta'];
						$almCompDet -> tercero = $detalle['tccuenta_banca'];
						$almCompDet -> centrocosto = $detalle['ccosto'];
						$almCompDet -> detalle = 'Doc Banco'.$detalle['num_banco'];
						$almCompDet -> cheque = '';
						$almCompDet -> valdebito = 0;
						$almCompDet -> valcredito = $detalle['valor'];
						$almCompDet -> estado = 1;
						$almCompDet -> vigencia = $fecha[3];
						//var_dump(json_encode($almCompDet));
						$verifCompDet = $almCompDet -> save();

						$almCompDet = new ComprobanteDet();
						$almCompDet -> id_comp = '9 '.$datos['id_comp'];
						$almCompDet -> cuenta = $detalle['ccuenta_banca'];
						$almCompDet -> tercero = $detalle['tccuenta_banca'];
						$almCompDet -> centrocosto = $detalle['ccosto'];
						$almCompDet -> detalle = 'Doc Banco'.$detalle['num_banco'];
						$almCompDet -> cheque = '';
						$almCompDet -> valdebito = $detalle['valor'];
						$almCompDet -> valcredito = 0;
						$almCompDet -> estado = 1;
						$almCompDet -> vigencia = $fecha[3];
						//var_dump(json_encode($almCompDet));
						$verifCompDet2 = $almCompDet -> save();

						$almPptoNotaBanca = new PptoNotasBanPpto();
						$almPptoNotaBanca -> cuenta = $resTesoGastosBanca['cuentapres'];
						$almPptoNotaBanca -> idrecibo = $datos['id_comp'];
						$almPptoNotaBanca -> valor = $detalle['valor'];
						$almPptoNotaBanca -> vigencia = $fecha[3];
						$almPptoNotaBanca -> rp = $detalle['rp'];
						//var_dump(json_encode($almPptoNotaBanca));
						$verifPptoNotaBanca = $almPptoNotaBanca -> save();
					}
				}
			}
			if($verifCompCab == 1 && $verifCompDet == 1 && $verifCompDet2 == 1 &&
			   $verifPptoNotaBanca == 1 && $verifTesoNotasCab == 1 && $verifTesoNotasDet == 1)
				return 0;
		}
	}

	/**
	 * Función para editar la nota bancaria
	 * Se evalua si existe parametros
	 * Se retorna valor para validación de la operación
	 * @param Array $datos
	 */
	public function editarNotasBanca($datos=''){
		if(is_array($datos)){
			$condiciones=[
				'id_notabancab' => @$datos['id_comp'],
				'estado' => 'S'
			];
			$almTesoNotasDet = TesoNotasBancariasDet::where($condiciones)->delete();

			$condiciones=[
				'id_comp' => '9 '.@$datos['id_comp'],
				'numerotipo' => @$datos['id_comp'],
				'estado' => '1',
				'tipo_comp' => 9,
			];
			$almCompDet = ComprobanteDet::where($condiciones)->delete();

			$condiciones=[
				'idrecibo' => @$datos['id_comp']
			];
			$almPptoNotaBanca = PptoNotasBanPpto::where($condiciones)->delete();
			//var_dump($condiciones);
		    if($almPptoNotaBanca && $almCompDet && $almTesoNotasDet)
				return $this->guardarNotasBanca((array)$datos);
			else
				return;
		}
	}

	/**
	 * Función para reversar la nota bancaria
	 * Se evalua si existe parametros
	 * Se retorna valor para validación de la operación
	 * @param Array $datos
	 */
	public function reversarNotasBanca($datos=''){
		if(is_array($datos)){
			$fecha = [];
			preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/",$datos['fecha'],$fecha);
			$fecha_reg = "$fecha[3]-$fecha[2]-$fecha[1]";

			$condiciones=[
				'id_notaban' => @$datos['id_comp'],
				'estado' => 'S'
			];
			$almTesoNotasCab = TesoNotasBancariasCab::where($condiciones)->get()->first();
			if($almTesoNotasCab){
				$almTesoNotasCab -> estado = @$datos['estado'];
				$verifTesoNotasCab = $almTesoNotasCab -> save();
			}

			$almTesoNotasCabRev = new TesoNotasBancariasCab();
			$almTesoNotasCabRev -> id_comp = 0;
			$almTesoNotasCabRev -> fecha = $fecha_reg;
			$almTesoNotasCabRev -> vigencia = $fecha[3];
			$almTesoNotasCabRev -> estado = $datos['estado'];
			$almTesoNotasCabRev -> concepto = $datos['concepto'];
			$almTesoNotasCabRev -> tipo_mov = $datos['tipo_mov'];
			$almTesoNotasCabRev -> user = $datos['nickusu'];
			//var_dump(json_encode($almTesoNotasCabRev));
			$verifTesoNotasCabRev = $almTesoNotasCabRev -> save();
			if($verifTesoNotasCabRev)
				$idNotaRev = $almTesoNotasCabRev -> id_notaban;

			$condiciones=[
				'id_notabancab' => $datos['id_comp'],
				'estado' => 'S'
			];
			$almTesoNotasDet = TesoNotasBancariasDet::where($condiciones)->get()->first();
			if($almTesoNotasDet){
				$almTesoNotasDet -> estado = @$datos['estado'];
				$verifTesoNotasDet = $almTesoNotasDet -> save();
			}
			//var_dump(json_encode($almTesoNotasDet));
			$almTesoNotasDetRev = new TesoNotasBancariasDet();
			$almTesoNotasDetRev -> id_notabancab = $idNotaRev;
			$almTesoNotasDetRev -> fecha = $fecha_reg;
			$almTesoNotasDetRev -> docban = $almTesoNotasDet['docban'];
			$almTesoNotasDetRev -> cc = $almTesoNotasDet['cc'];
			$almTesoNotasDetRev -> ncuentaban = $almTesoNotasDet['ncuentaban'];
			$almTesoNotasDetRev -> tercero = $almTesoNotasDet['tercero'];
			$almTesoNotasDetRev -> gastoban = $almTesoNotasDet['gastoban'];
			$almTesoNotasDetRev -> cheque = '';
			$almTesoNotasDetRev -> valor = $almTesoNotasDet['valor'];
			$almTesoNotasDetRev -> estado = $datos['estado'];
			$almTesoNotasDetRev -> tipo_mov = $datos['tipo_mov'];
			$almTesoNotasDetRev -> user = $datos['nickusu'];
		    //var_dump(json_encode($almTesoNotasDetRev));
			$verifTesoNotasDetRev = $almTesoNotasDetRev -> save();

			$condiciones=[
				'numerotipo' => $datos['id_comp'],
				'estado' => '1',
				'tipo_comp' => 9
			];
			$almCompCab = ComprobanteCab::where($condiciones)->update(['estado' => '0']);

			$condiciones=[
				'id_comp' => '9 '.$datos['id_comp'],
				'numerotipo' => $datos['id_comp'],
				'estado' => '1',
				'tipo_comp' => 9,
			];
			$almCompDet = ComprobanteDet::where($condiciones)->delete();

			$condiciones=[
				'idrecibo' => $datos['id_comp'],
				'vigencia' => $almTesoNotasCab['vigencia']
			];
			$almPptoNotaBanca = PptoNotasBanPpto::where($condiciones)->delete();
			if($verifTesoNotasCab && $verifTesoNotasCabRev && $verifTesoNotasDet &&
			   $verifTesoNotasDetRev && $almCompCab && $almCompDet && $almPptoNotaBanca)
				return 0;
		}
	}

	/**
	 * Función para buscar historial del activo físico
	 * Se evaluar los parametros para realizar la busqueda
	 * Se retorna todos los registros del activo físico
	 * @param Array $datos
	 */
	public function buscarHistorialNotas($datos=''){
		$resHistorial = null;
		if(is_array($datos)){
			$detalles = @$datos['detalles'];
			unset($datos['proceso']);
			unset($datos['detalles']);

			$sql = 'TesoNotasBancariasCab::';
			$init = false;

			foreach ($datos as $field => $value) {
				if($field == 'sql_like'){
					list($field,$value) = explode('=',$datos['sql_like']);
					($init) ? $sql = $sql.'->' : $init = true;
					$sql = $sql."where('$field','LIKE','%$value%')";
					unset($datos['sql_like']);
				} else if($field == 'sql_between'){
					preg_match_all("/\d{4}\-\d{1,2}\-\d{1,2}/",$datos['sql_between'], $dates);
					($init) ? $sql = $sql.'->' : $init = true;
					$sql = $sql."whereBetween('fecha',['".$dates[0][0]."','".$dates[0][1]."'])";
					unset($datos['sql_between']);
				}
			}

			if(count(@$datos) > 0){
				($init) ? $sql = $sql.'->' : $init = true;
				$data = str_replace(["{","}",":"],["[","]","=>"], json_encode($datos));
				$sql = $sql."where($data)->get();";
			}else{
				($init) ? $sql = $sql.'->' : $init = true;
				$sql = $sql."where([])->get();";
			}
			eval('$resHistorial = '.$sql.';');
			if($resHistorial){
				$vigencia = @$resHistorial[0]['vigencia'];
				foreach ($resHistorial as $key => $value) {
					$value['valor'] = TesoNotasBancariasDet::where('id_notabancab',$value['id_notaban'])->get()->sum('valor');
				}
				if($detalles){
					$condiciones=[
						'id_notabancab' => $datos['id_notaban']
					];
					$almTesoNotasDet = TesoNotasBancariasDet::where($condiciones)->orderBy('id_notabandet','ASC')->get();
					$resHistorial['TesoNotasBancariasDet'] = $almTesoNotasDet;
					foreach ($almTesoNotasDet as $index => $detalle) {
						$resHistorial['TesoNotasBancariasDet'][$index]['TerceroCtaBanca']
						= Terceros::where(['cedulanit'=>$detalle['tercero']])->select('razonsocial')->get()->first();
					}
					$condiciones=[
						'numerotipo' => $datos['id_notaban'],
						'tipo_comp' => 9
					];
					$almCompCab = ComprobanteCab::where($condiciones)->get()->first();
					$resHistorial['ComprobanteCab'] = $almCompCab;
					$condiciones=[
						'id_comp' => '9 '.$datos['id_notaban'],
						'numerotipo' => $datos['id_notaban'],
						'tipo_comp' => 9,
						'valdebito' => 0
					];
					$almCompDet = ComprobanteDet::where($condiciones)->orderBy('id_det','ASC')->get();
					$resHistorial['ComprobanteDet'] = $almCompDet;
					$condiciones=[
						'idrecibo' => $datos['id_notaban'],
						'vigencia' => $vigencia
					];
					$almPptoNotaBanca = PptoNotasBanPpto::where($condiciones)->orderBy('id','ASC')->get();
					$resHistorial['PptoNotasBanPpto'] = $almPptoNotaBanca;
				}
			}
		}
		return $resHistorial;
	}
}