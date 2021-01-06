<?php  
    include_once ($_SERVER['DOCUMENT_ROOT'].'/financiero/dirs.php');
	require_once (MODELS_PATH.'TesoGastosBancariosDet.php');
	require_once (ROOT_PATH.'conexion.php');
    
	class GastoBancarioDetController
    {
        private $cuentaPresupuestal;

        public function buscarCuentaPresupuestal($codigo, $vigencia)
        {
            $condiciones = ['codigo' => $codigo, 'vigencia' => $vigencia];
            $this->cuentaPresupuestal = TesoGastosBancariosDet::where($condiciones)->first();
        }
		
		public function getcuentaPresupuestal()
		{
			return $this->cuentaPresupuestal;
		}
    }
    