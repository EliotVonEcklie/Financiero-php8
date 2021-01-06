<?php
include_once ($_SERVER['DOCUMENT_ROOT'].'/financiero/dirs.php');
require_once (MODELS_PATH.'PptoCuentas.php');
require_once (MODELS_PATH.'PptoCuentasPos.php');
require_once (MODELS_PATH.'PptoCuentasHis.php');
require_once (ROOT_PATH.'conexion.php');

/**
 * Clase controlador con funciones para las cuentas importadas
 * Importa modelos PptoCuentas, PptoCuentasPos, PptoCuentasHis
 */
class  PptoCuentasController{

	public function __construct(){}

	/**
	 * Función para guardar cuentas importadas, recibe parámetros de función AJAX POST
	 * Se realiza validación con cuentas ya existentes
	 * Se almacena cuentas nuevas (Cuentas únicas con vigencia única)
	 * Se realiza validación para registrar el movimiento en el historial
	 * Se realiza retorna valor [0 - Cuentas nuevas] [1 - Algunas cuentas existentes]
	 * @param Array $datos
	 * @param boolean 0-1
	 */
	public function guardarCuentas($datos){
		$totalPptoCuentas = 0;
		$totalPptoCuentasPos = 0;
		$cuentas = $datos['cuenta'];
		$totalCuentas = sizeof($cuentas);
		$fecha = [];
		$existe = 0;
		preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/",$_POST['fecha'],$fecha);

		for ($i=0; $i < $totalCuentas; $i++) {
			$condiciones=[
				'cuenta' => $cuentas[$i],
				'vigencia' => $fecha[3]
			];

			$valExistenciaCuenta = PptoCuentas::where($condiciones)->get();
			if(sizeof($valExistenciaCuenta) == 0){
				$almPptoCuentas = new PptoCuentas();
				$almPptoCuentas -> cuenta = $datos['cuenta'][$i];
				$almPptoCuentas -> nombre = $datos['nombre'][$i];
				$almPptoCuentas -> tipo = $datos['tipo'][$i];
				$almPptoCuentas -> estado = 'S';
				$almPptoCuentas -> vigencia = $fecha[3];
				$almPptoCuentas -> vigenciaf = $fecha[3];
				$almPptoCuentas -> clasificacion = $datos['clasificacion'][$i];
				$almPptoCuentas -> regalias = $datos['regalias'][$i];

				if($datos['causacion'][$i] == 'S')
					$almPptoCuentas -> nomina = 'N';
				if($datos['clasificacion'][$i] == 'inversion')
					$almPptoCuentas -> futfuenteinv = $datos['fuente'][$i];
				else if($datos['clasificacion'][$i] == 'funcionamiento')
					$almPptoCuentas -> futfuentefunc = $datos['fuente'][$i];

				$verifPptoCuentas = $almPptoCuentas -> save();
				if(!$verifPptoCuentas){$totalPptoCuentas++;}

				$almPptoCuentasPos = new PptoCuentasPos();
				$almPptoCuentasPos -> posicion = $datos['posicion'][$i];
				$almPptoCuentasPos -> cuentapos = $datos['cuenta'][$i];
				$almPptoCuentasPos -> tipo = ($datos['clasificacion'][$i] != 'ingresos')? 'gastos': 'ingresos';
				$almPptoCuentasPos -> vigencia = $fecha[3];
				$almPptoCuentasPos -> entidad = $datos['entidad'];
				$verifPptoCuentasPos = $almPptoCuentasPos -> save();
				if(!$verifPptoCuentasPos){$totalPptoCuentasPos++;}
			}else
				$existe++;
		}
		if ($totalCuentas > 0 && $existe < $totalCuentas ){
			$almPptoCuentasHis = new PptoCuentasHis();
			$almPptoCuentasHis -> fecha = "$fecha[3]-$fecha[2]-$fecha[1]";
			$almPptoCuentasHis -> entidad = $datos['entidad'];
			$almPptoCuentasHis -> descripcion = ($existe == 0) ? "Cargue de cuentas iniciales vigencia ".$fecha[3]:"Cargue adicicional con modificaciones vigencia ".$fecha[3];
			$verifPptoCuentasHis = $almPptoCuentasHis -> save();
		}

		if($existe == 0)
			return 0;
		else if($existe > 0)
			return 1;
	}
}
?>