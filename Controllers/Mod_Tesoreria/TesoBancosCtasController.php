<?php  
    include_once ($_SERVER['DOCUMENT_ROOT'].'/financiero/dirs.php');
	require_once (MODELS_PATH.'/Mod_Tesoreria/TesobBancosCtas.php');
	require_once (MODELS_PATH.'terceros.php');
	require_once (ROOT_PATH.'conexion.php');
    
	class TesoBancosCtasController
    {
        private $cuentaBanco;

        public function buscarCuentaBanco($columna, $codigo)
        {
            $condiciones = [$columna => $codigo];
            $this->cuentaBanco = TesobBancosCtas::join('terceros','terceros.cedulanit','=','tesobancosctas.tercero')
					->where($condiciones)
					->select('cuenta','razonsocial')
					->get()->first();
		}
		public function getcuentaBanco()
		{
			return $this->cuentaBanco;
		}
    }
    