<?php
	require_once '/../Models/ConceptosContables.php';
	require_once '/../conexion.php';
	class ConceptosContablesController
	{
		public $allConceptosContables='';
		public $maxConceptosContables;
		public $minConceptosContables;
		public function generarAllConceptosContables($valorbusqueda='',$nombrecampo='',$campoorden='',$sentido='')
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
				if($campoorden != ''){$this->allConceptosContables = ConceptosContables::where($condiciones)-> orderBy($campoorden, $sentido)->get();}
				else {$this->allConceptosContables = ConceptosContables::where($condiciones)->get();}
			}
			else //CUANDO LA CONSULTA LLAMA A TODOS O APLICA UNA SOLA CONDICION 
			{
				if($valorbusqueda != '')
				{
					if($campoorden != ''){$this->allConceptosContables = ConceptosContables::where($nombrecampo,$valorbusqueda) -> orderBy($campoorden,$sentido) -> get();}
					else {$this->allConceptosContables = ConceptosContables::where($nombrecampo,$valorbusqueda)->get();}
				}
				else 
				{
					if($campoorden = ''){$this->allConceptosContables = ConceptosContables::orderBy($campoorden,$sentido)->all();}
					else {$this->allConceptosContables = ConceptosContables::all();}
					
				}
			}
		}
		public function generarMaxConceptosContables()
		{
			$this->maxConceptosContables=ConceptosContables::max('id');
		}
		public function generarMinHumVariables()
		{
			$this->minConceptosContables=ConceptosContables::min('id');
		}
	}
?>