<?php
	require_once '/../Models/TesoIngresos.php';
	require_once '/../conexion.php';
	class TesoIngresosController
	{
		public $allIngresos;
		public function generarAllTesoIngresos($valorbusqueda='',$nombrecampo='')
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
				$this->allIngresos=TesoIngresos::where($condiciones)->get();
			}
			else //CUANDO LA CONSULTA LLAMA A TODOS O APLICA UNA SOLA CONDICION 
			{
				if($valorbusqueda != ''){$this->allIngresos=TesoIngresos::where($nombrecampo,$valorbusqueda)->get();}
				else {$this->allIngresos=TesoIngresos::all();}
			}
		}
	}
?>