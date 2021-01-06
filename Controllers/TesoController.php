<?php
include_once ($_SERVER['DOCUMENT_ROOT'].'/financiero/dirs.php');
require_once (MODELS_PATH.'TesoParametros.php');
require_once (MODELS_PATH.'TesoIngresos.php');
require_once (MODELS_PATH.'Dominios.php');
require_once (MODELS_PATH.'Cuentas.php');
require_once (MODELS_PATH.'CuentasNicsp.php');
require_once (MODELS_PATH.'Transaccion.php');
require_once (ROOT_PATH.'conexion.php');
/**
 * Clase controlador de tesoreria
 * Importa modelos relacionados a tesoreria
 */
class  TesoController{
	public function __construct(){}

	/**
	 * Función para buscar información de tesoreria
	 * Se evalua los detalles a consultar
	 * Se retorna información de los parametros
	 * @param Array $datos
	 */
	public function buscarParametrosTeso($datos=''){
		$resTesoParametros = array();
		if(is_array($datos)){
			array_shift($datos);
			foreach ($datos['parametros'] as $field => $value) {
				switch($value){
					case 'TESOPARAMETROS':
						$condiciones = [
							'estado' => 'S'
						];
						$res = TesoParametros::where($condiciones)->get()->first();
						$resTesoParametros[$value] = $res;
					break;
					case 'TESOINGRESOS':
						$condiciones = [
							'estado' => 'S'
						];
						$res = TesoIngresos::where($condiciones)->select('codigo','nombre')->orderBy('codigo','asc')->get();
						$resTesoParametros[$value] = $res;
					break;
					case 'BASE_PREDIAL':
					case 'BASE_PREDIALAMB':
					case 'COBRO_RECIBOS':
					case 'COBRO_ALUMBRADO':
					case 'CUENTA_MILES':
					case 'CUENTA_TRASLADO':
					case 'DESC_INTERESES':
					case 'DESCUENTO_CON_DEUDA':
					case 'NORMA_PREDIAL':
						$condiciones = [
							'nombre_dominio' => $value
						];
						$res = Dominios::where($condiciones)->select('valor_inicial','valor_final','tipo','descripcion_valor')->orderBy('descripcion_valor','desc')->first();
						$resTesoParametros[$value] = $res;
					break;
				}
			}
		}
		return $resTesoParametros;
	}

	/**
	 * Función para buscar información de tesoreria
	 * Se evalua los detalles a consultar
	 * Se retorna información de los parametros
	 * @param Array $datos
	 */
	public function buscarCuentasTeso($datos=''){
		$almTesoCuentas = null;
		$resTesoCuentas = array();
		if(is_array($datos)){
			array_shift($datos);
			foreach ($datos as $field => $value) {
				$condiciones=[
					'cuenta' => $value
				];
				$almTesoCuentas = Cuentas::where($condiciones)->select('nombre')->first();
				$resTesoCuentas[$field] = sizeof($almTesoCuentas) > 0 ? $almTesoCuentas: CuentasNicsp::where($condiciones)->select('nombre')->first();
			}
		}
		return $resTesoCuentas;
	}

	/**
	 * Función para guardar información de los parametros del control activos físico
	 * Se evalua si existe parametros
	 * Se retorna valor para validación de la operación
	 * @param Array $datos
	 */
	public function guardarParametrosTeso($datos=''){
		$verifTesoParametros = $almTesoParametros = null;
		if(is_array($datos)){
			array_shift($datos);
			foreach ($datos as $field => $value){
				switch ($field) {
					case 'BASE_PREDIAL':
					case 'BASE_PREDIALAMB':
					case 'CUENTA_TRASLADO':
					case 'DESCUENTO_CON_DEUDA':
					case 'NORMA_PREDIAL':
						$condiciones = ['nombre_dominio' => $field];
						$actualizacion = ['valor_inicial' => @$value[0]];
						if(count(Dominios::where($condiciones)->get())>0){
							Dominios::where($condiciones)->update($actualizacion);
						}else{
							$almDominio = new Dominios();
							$almDominio -> valor_inicial = @$value;
							$almDominio -> nombre_dominio = $field;
							$almDominio -> save();
						}
						unset($datos[$field]);
						break;
					case 'CUENTA_MILES':
						$condiciones = ['nombre_dominio' => $field];
						$actualizacion = ['valor_inicial' => @$value[0], 'descripcion_valor' => @$value[1]];
						if(count(Dominios::where($condiciones)->get())>0){
							Dominios::where($condiciones)->update($actualizacion);
						}else{
							$almDominio = new Dominios();
							$almDominio -> valor_inicial = @$value[0];
							$almDominio -> descripcion_valor = @$value[1];
							$almDominio -> nombre_dominio = $field;
							$almDominio -> save();
						}
						unset($datos[$field]);
						break;
					case 'COBRO_RECIBOS':
					case 'DESC_INTERESES':
					case 'COBRO_ALUMBRADO':
						$condiciones = ['nombre_dominio' => $field];
						$actualizacion = ['valor_inicial' => @$value[0], 'valor_final' => @$value[1], 'tipo' => @$value[2]];
						if(count(Dominios::where($condiciones)->get())>0){
							$almDominio = Dominios::where($condiciones)->orderBy('descripcion_valor','desc')->take(1);
							$almDominio->update($actualizacion);
						} else {
							$almDominio = new Dominios();
							$almDominio -> valor_inicial = @$value[0];
							$almDominio -> valor_final = @$value[1];
							$almDominio -> tipo = @$value[2];
							$almDominio -> nombre_dominio = $field;
							$almDominio -> save();
						}
						unset($datos[$field]);
						break;
				}
			}

			$almTesoParametros = TesoParametros::find($datos['id']);
			if(!$almTesoParametros)
				$almTesoParametros = new TesoParametros();
				foreach ($datos as $field => $value)
					$almTesoParametros -> $field = $datos[$field];

			$verifTesoParametros = $almTesoParametros->save();
			if($verifTesoParametros == 1)
				return 0;

		}
	}
}