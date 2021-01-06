<?php
include_once ($_SERVER['DOCUMENT_ROOT'].'/financiero/dirs.php');
require_once (MODELS_PATH.'ActicrearactDetResponsable.php');
require_once (MODELS_PATH.'ActicrearactDet.php');
require_once (MODELS_PATH.'HumFuncionarios.php');
require_once (MODELS_PATH.'ActiTrasladosResp.php');
require_once (MODELS_PATH.'ActiTraslados.php');
require_once (MODELS_PATH.'ActiParametros.php');
require_once (MODELS_PATH.'CentroCosto.php');
require_once (MODELS_PATH.'ActiDisposicionActivos.php');
require_once (MODELS_PATH.'ActiUbicacion.php');
require_once (MODELS_PATH.'PlanacAreas.php');
require_once (MODELS_PATH.'ActiPrototipo.php');
require_once (MODELS_PATH.'ActiActivosDet.php');
require_once (MODELS_PATH.'ComprobanteCab.php');
require_once (MODELS_PATH.'ComprobanteDet.php');
require_once (MODELS_PATH.'ConfigBasica.php');
require_once (MODELS_PATH.'Transaccion.php');
require_once (ROOT_PATH.'conexion.php');

/**
 * Clase controlador con funciones para el control de activos fisicos
 * Importa modelos relacionados a los activos
 */
class  ActiActivosFisicosController{
	public function __construct(){}

	/**
	 * Función para buscar información sobre el activo físico
	 * Se retronar información del activo físico
	 * @param Array $datos
	*/
	public function buscarActivoFisico($datos=''){
		if(is_array($datos)){
			array_shift($datos);
			$resActivoFisico = ActicrearactDet::where($datos)->get();
		}
		return $resActivoFisico;
	}

	/**
	 * Función para buscar información sobre el activo físico
	 * Se realiza validación de activo en el modelo ActicrearactDetResponsable
	 * Se realiza validación de activo en el modelo ActiTrasladosResp
	 * Se realiza la busqueda del tercero como funcionario
	 * Se retronar información del responsable del activo físico
	 * @param Array $datos
	*/
	public function buscarActivoFisicoResp($datos=''){
		if(is_array($datos)){
			array_shift($datos);
			$resActivoFisico = ActicrearactDetResponsable::where($datos)->get();
			if($resActivoFisico){
				$condiciones=[
					'activo' => $datos['placa']
				];
				$resActivoFisico = ActiTrasladosResp::where($condiciones)->get()->last();
			}

			if($resActivoFisico){
				$tercero = $resActivoFisico['tercero'] ?$resActivoFisico['tercero']:$resActivoFisico['destino'];
				$condiciones=[
					'item' => 'DOCTERCERO',
					'descripcion' => $tercero
				];
				$resActivoFisico = $this->buscarFuncionario($condiciones, 'buscarResponsable');
			}
			return $resActivoFisico;
		}
	}

	/**
	 * Función para crear condiciones para la busqueda del resposable de activos fisico
	 * Se retorna nuevos parametros para la busqueda
	 * @param Array $datos
	 */
	public function buscarActivoFisicoResponsable($datos=''){
		$retoActivoFisico = null;
		$retoActivoFisico['codfun'] = $datos[0]['codfun'];
		$retoActivoFisico['codter'] = $datos[0]['descripcion'];
		$condiciones=[
			'item' => 'NOMTERCERO',
			'codfun' => doubleval($datos[0]['codfun'])
		];
		$resActivoFisico = $this->buscarFuncionario($condiciones);
		$retoActivoFisico['nomter'] = $resActivoFisico[0]['descripcion'];
		return $retoActivoFisico;
	}

	/**
	 * Función para buscar información del funcionario responsable de activos físico
	 * Se realiza busqueda en el modelo HumFuncionarios
	 * Se evalua la busqueda, si es resultado es negativo se realiza modificación en los parametros
	 * Se retorna información los datos del resposable del activo físico
	 * @param Array $datos
	 * @param Function $funcion
	 */
	public function buscarFuncionario($datos='', $funcion=null){
		$resFuncionario = null;
		if(is_array($datos)){
			$resFuncionario = HumFuncionarios::where($datos)->get();
		}

		if($funcion!=null && $funcion=='buscarResponsable')
			return $this->buscarActivoFisicoResponsable($resFuncionario);
		else
			return $resFuncionario;
	}

	/**
	 * Función para buscar historial del activo físico
	 * Se retorna todos los registros del activo físico
	 * @param Array $datos
	 */
	public function buscarHistorialActivoResp($datos=''){
		$resHistorial = null;
		if(is_array($datos)){
			array_shift($datos);
			$resHistorial = ActiTrasladosResp::where($datos)->get();
		}
		return $resHistorial;
	}

	/**
	 * Función para guardar el traslado de responsable del activo físico
	 * Se almacena los datos del traslado de activo
	 * Se retorna valor para validación de la operación
	 * @param Array $datos
	 */
	public function guardarTrasladoActivoResp($datos=''){
		$verifActiTrasladosResp = null;
		if(is_array($datos)){
			$fecha = [];
			preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/",$datos['fecha'],$fecha);

			$almActiTrasladosResp = new ActiTrasladosResp();
			$almActiTrasladosResp -> activo = $datos['activo'];
			$almActiTrasladosResp -> fecha = "$fecha[3]-$fecha[2]-$fecha[1]";
			$almActiTrasladosResp -> elaborado = $datos['elaborado'];
			$almActiTrasladosResp -> origen = $datos['origen'];
			$almActiTrasladosResp -> destino = $datos['destino'];
			$almActiTrasladosResp -> estado = $datos['estado'];
			$almActiTrasladosResp -> motivo = $datos['motivo'];

			$verifActiTrasladosResp = $almActiTrasladosResp->save();
			if($verifActiTrasladosResp == 1)
				return 0;
		}
	}

	/**
	 * Función para buscar información de los parametros del control activos físico
	 * Se retorna información de los parametros
	 * @param Array $datos
	 */
	public function buscarParametrosActivos($datos=''){
		$resActiParametros = null;
		if(is_array($datos)){
			$resActiParametros = ActiParametros::all()->first();
			return $resActiParametros;
		}
	}

	/**
	 * Función para guardar información de los parametros del control activos físico
	 * Se evalua si existe parametros
	 * Se retorna valor para validación de la operación
	 * @param Array $datos
	 */
	public function guardarParametrosActivos($datos=''){
		$verifActiParametros = null;
		if(is_array($datos)){
			$almActiParametros = ActiParametros::find($datos['id']);
			if(!$almActiParametros)
				$almActiParametros = new ActiParametros();
			$almActiParametros -> cc_almacenista = $datos['cc_almacenista'];
			$almActiParametros -> nom_almacenista = $datos['nom_almacenista'];
			$almActiParametros -> valor_menor_cuantia = $datos['valor_menor_cuantia'];

			$verifActiParametros = $almActiParametros->save();
			if($verifActiParametros == 1)
				return 0;
		}
	}

	/**
	 * Función para buscar información de los detalles del control activos físico
	 * Se evalua los detalles a consultar
	 * Se retorna información de los parametros
	 * @param Array $datos
	 */
	public function buscarDetallesActivos($datos=''){
		$resActiDetalles = array();
		$condiciones = [
			'estado' => 'S'
		];
		if(is_array($datos)){
			array_shift($datos);
			foreach ($datos['detalles'] as $field => $value) {
				switch($value){
					case 'ccosto_act':
						$res = CentroCosto::where($condiciones)->get();
						$resActiDetalles[$value] = $res;
					break;
					case 'dispactivos_act':
						$res = ActiDisposicionActivos::where($condiciones)->get();
						$resActiDetalles[$value] = $res;
					break;
					case 'ubicacion_act':
						$res = ActiUbicacion::where($condiciones)->get();
						$resActiDetalles[$value] = $res;
					break;
					case 'planacareas_act':
						$res = PlanacAreas::where($condiciones)->get();
						$resActiDetalles[$value] = $res;
					break;
					case 'prototipo_act':
						$res = ActiPrototipo::where($condiciones)->get();
						$resActiDetalles[$value] = $res;
					break;
				}
			}
		}
		return json_encode($resActiDetalles);
	}

	/**
	 * Función para guardar el traslado detalles del activo físico
	 * Se almacena los datos del traslado de activo
	 * Se modifica el registro actual en los detalles del activo
	 * Se evalua y se contabiliza Disposición del activo
	 * Se evalua y se contabiliza Centro de Costo
	 * Se retorna valor para validación de la operación
	 * @param Array $datos
	 */
	public function guardarTrasladoActivoDeta($datos=''){
		$verifActiTrasladosDeta = $verifActiCrearActDeta = null;
		$verifComprobanteCab = $verifComprobanteDeta = $verifComprobanteDeta = null;
		if(is_array($datos)){
			$fecha = [];
			preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/",$datos['fecha'],$fecha);
			$fecha_reg = "$fecha[3]-$fecha[2]-$fecha[1]";

			try{
				Transaccion::beginTransaction();
				$almActiTrasladosDeta = new ActiTraslados();
				$almActiTrasladosDeta -> fecha = $fecha_reg;
				$almActiTrasladosDeta -> activo = $datos['activo'];
				$almActiTrasladosDeta -> estado = $datos['estado'];
				$almActiTrasladosDeta -> motivo = $datos['motivo'];
				$almActiTrasladosDeta -> cc_ori = $datos['cc_ori'];
				$almActiTrasladosDeta -> area_ori = $datos['area_ori'];
				$almActiTrasladosDeta -> ubicacion_ori = $datos['ubicacion_ori'];
				$almActiTrasladosDeta -> prototipo_ori = $datos['prototipo_ori'];
				$almActiTrasladosDeta -> dispoactivo_ori = $datos['dispoactivo_ori'];
				$almActiTrasladosDeta -> cc_des = $datos['cc_des'];
				$almActiTrasladosDeta -> area_des = $datos['area_des'];
				$almActiTrasladosDeta -> ubicacion_des = $datos['ubicacion_des'];
				$almActiTrasladosDeta -> prototipo_des = $datos['prototipo_des'];
				$almActiTrasladosDeta -> dispoactivo_des = $datos['dispoactivo_des'];
				$verifActiTrasladosDeta = $almActiTrasladosDeta->save();

				$id_trasalado = $almActiTrasladosDeta -> id;

				//actualizar detalles del activo
				$almActiCrearAct = ActicrearactDet::find($datos['activo']);
				if($almActiCrearAct){
					$almActiCrearAct -> cc = $datos['cc_des'];
					$almActiCrearAct -> area = $datos['area_des'];
					$almActiCrearAct -> ubicacion = $datos['ubicacion_des'];
					$almActiCrearAct -> prototipo = $datos['prototipo_des'];
					$almActiCrearAct -> dispoact = $datos['dispoactivo_des'];
					$verifActiCrearActDeta = $almActiCrearAct->save();
				}

				//actualizar disposición del activo
				if($datos['dispoactivo_ori'] != $datos['dispoactivo_des']){
					$condiciones = [
						'tipo' => substr($datos['activo'],0,6),
						'centro_costos' => $datos['cc_ori'],
						'disposicion_activos' => $datos['dispoactivo_ori']
					];
					$almActiActivosDeta = ActiActivosDet::where($condiciones)->orderBy('fechainicial','desc')->first();
					$cuenta_activo_credito = $almActiActivosDeta['cuenta_activo'];

					$condiciones = [
						'tipo' => substr($datos['activo'],0,6),
						'centro_costos' => $datos['cc_ori'],
						'disposicion_activos' => $datos['dispoactivo_des']
					];
					$almActiActivosDeta = ActiActivosDet::where($condiciones)->orderBy('fechainicial','desc')->first();
					$cuenta_activo_debito = $almActiActivosDeta['cuenta_activo'];

					$nit_entidad = ConfigBasica::where([])->select('nit')->first()['nit'];

					//Crear 1 comprobante de cabecera
					$almComprobanteCab = new ComprobanteCab();
					$almComprobanteCab -> numerotipo = $id_trasalado;
					$almComprobanteCab -> tipo_comp = '75';
					$almComprobanteCab -> fecha = $fecha_reg;
					$almComprobanteCab -> concepto = $datos['motivo'];
					$almComprobanteCab -> total = 0;
					$almComprobanteCab -> total_debito = $datos['valor_ori'];
					$almComprobanteCab -> total_credito = 0;
					$almComprobanteCab -> diferencia = 0;
					$almComprobanteCab -> estado = 1;
					$verifComprobanteCab = $almComprobanteCab -> save();

					//Crear comprobantes de detalles valor credito
					$almComprobanteDeta = new ComprobanteDet();
					$almComprobanteDeta -> id_comp = '75 '.$id_trasalado;
					$almComprobanteDeta -> cuenta = $cuenta_activo_credito;
					$almComprobanteDeta -> tercero = $nit_entidad;
					$almComprobanteDeta -> centrocosto = $datos['cc_ori'];
					$almComprobanteDeta -> detalle = $datos['motivo'];
					$almComprobanteDeta -> valdebito = 0;
					$almComprobanteDeta -> valcredito = $datos['valor_ori'];
					$almComprobanteDeta -> estado = 1;
					$almComprobanteDeta -> vigencia = $fecha[3];
					$verifComprobanteDeta = $almComprobanteDeta -> save();

					//Crear comprobantes de detalles valor credito
					$almComprobanteDeta = new ComprobanteDet();
					$almComprobanteDeta -> id_comp = '75 '.$id_trasalado;
					$almComprobanteDeta -> cuenta = $cuenta_activo_debito;
					$almComprobanteDeta -> tercero = $nit_entidad;
					$almComprobanteDeta -> centrocosto = $datos['cc_ori'];
					$almComprobanteDeta -> detalle = $datos['motivo'];
					$almComprobanteDeta -> valdebito = $datos['valor_ori'];
					$almComprobanteDeta -> valcredito = 0;
					$almComprobanteDeta -> estado = 1;
					$almComprobanteDeta -> vigencia = $fecha[3];
					$verifComprobanteDeta = $almComprobanteDeta -> save();
				}

				Transaccion::commit();
				if($verifActiTrasladosDeta == 1  && $verifActiCrearActDeta == 1 && $verifComprobanteCab == 1
				&& $verifComprobanteDeta == 1 && $verifComprobanteDeta == 1)
					return 0;
			} catch(\Exception $e){
				var_dump('roll');
				Transaccion::rollBack();
				throw $e;
			}
		}
	}

	/**
	 * Función para buscar historial del activo físico
	 * Se evaluar los parametros para realizar la busqueda
	 * Se retorna todos los registros del activo físico
	 * @param Array $datos
	 */
	public function buscarHistorialActivoDeta($datos=''){
		$resHistorial = null;
		if(is_array($datos)){
			array_shift($datos);

			$sql = 'ActiTraslados::';
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
		}
		return $resHistorial;
	}
}