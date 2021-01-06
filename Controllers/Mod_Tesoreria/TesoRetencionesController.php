<?php
	include_once ($_SERVER['DOCUMENT_ROOT'].'/financiero/dirs.php');
	require_once (MODELS_PATH.'/Mod_Tesoreria/TesoRetenciones.php');
	require_once (ROOT_PATH.'conexion.php');
	class TesoRetencionesController
	{
		public $alltesoretenciones;
		public function generarAllTesoRetenciones($valorbusqueda='',$nombrecampo='')
		{
			if(is_array($valorbusqueda))//CUANDO LA CONSULTA APLICA MAS DE UNA CONDICION
			{
				$condiciones ='';
				$tcondi=count($valorbusqueda);
				switch ($tcondi)
				{
					case 2: $condiciones = [$nombrecampo[0] => $valorbusqueda[0], $nombrecampo[1] => $valorbusqueda[1]];break;
					case 3: $condiciones = [$nombrecampo[0] => $valorbusqueda[0], $nombrecampo[1] => $valorbusqueda[1], $nombrecampo[2] => $valorbusqueda[2]];break;
					case 4: $condiciones = [$nombrecampo[0] => $valorbusqueda[0], $nombrecampo[1] => $valorbusqueda[1], $nombrecampo[2] => $valorbusqueda[2], $nombrecampo[3] => $valorbusqueda[3]];break;
				}
				$this->alltesoretenciones=TesoRetenciones::where($condiciones)->get();
			}
			else //CUANDO LA CONSULTA LLAMA A TODOS O APLICA UNA SOLA CONDICION 
			{
				if($valorbusqueda != ''){$this->alltesoretenciones=TesoRetenciones::where($nombrecampo,$valorbusqueda)->get();}
				else {$this->alltesoretenciones=TesoRetenciones::all();}
			}
		}
	}
?>