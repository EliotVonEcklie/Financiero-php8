<?php
	require_once '/../Models/Humvariables.php';
	require_once '/../conexion.php';
	class HumVariablesController
	{
		public $allHumvariables='';
		public $maxHumvariable;
		public $minHumvariable;
		public $actualizahumvariables;
		public function generarAllHumVariables($valorbusqueda='',$nombrecampo='')
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
				$this->allHumvariables=Humvariables::where($condiciones)->get();
			}
			else //CUANDO LA CONSULTA LLAMA A TODOS O APLICA UNA SOLA CONDICION 
			{
				if($valorbusqueda != ''){$this->allHumvariables=Humvariables::where($nombrecampo,$valorbusqueda)->get();}
				else {$this->allHumvariables=Humvariables::all();}
			}
		}
		public function generarMaxHumVariables()
		{
			$this->maxHumvariable=Humvariables::max('id');
		}
		public function generarMinHumVariables()
		{
			$this->minHumvariable=Humvariables::min('id');
		}
		public function actualizarHumVariables()
		{
			if(@$_POST['swboton1']=="" || @$_POST['swboton1']=="N"){$valsalud='N';}
			else{$valsalud='S';}
			if(@$_POST['swboton2']=="" || @$_POST['swboton2']=="N"){$valsalude='N';}
			else{$valsalude='S';}
			if(@$_POST['swboton3']=="" || @$_POST['swboton3']=="N"){$valpesion='N';}
			else{$valpesion='S';}
			if(@$_POST['swboton4']=="" || @$_POST['swboton4']=="N"){$valpesione='N';}
			else{$valpesione='S';}
			if(@$_POST['swboton5']=="" || @$_POST['swboton5']=="N"){$valarl='N';}
			else{$valarl='S';}
			if(@$_POST['swboton6']=="" || @$_POST['swboton6']=="N"){$valccf='N';}
			else{$valccf='S';}
			if(@$_POST['swboton7']=="" || @$_POST['swboton7']=="N"){$valicbf='N';}
			else{$valicbf='S';}
			if(@$_POST['swboton8']=="" || @$_POST['swboton8']=="N"){$valsena='N';}
			else{$valsena='S';}
			if(@$_POST['swboton9']=="" || @$_POST['swboton9']=="N"){$valintec='N';}
			else{$valintec='S';}
			if(@$_POST['swboton10']=="" || @$_POST['swboton10']=="N"){$valesap='N';}
			else{$valesap='S';}
			if(@$_POST['swboton11']=="" || @$_POST['swboton11']=="N"){$valprovision='N';}
			else{$valprovision='S';}
			$acthumvariables = Humvariables::find($_POST['idvar']);
			$acthumvariables -> nombre = $_POST['nombre'];
			$acthumvariables -> pccf = $valccf;
			$acthumvariables -> provision = $valprovision;
			$acthumvariables -> psalud = $valsalud;
			$acthumvariables -> ppension = $valpesion;
			$acthumvariables -> parl = $valarl;
			$acthumvariables -> concepto = $_POST['concecont'];
			$acthumvariables -> psalude = $valsalude;
			$acthumvariables -> ppensione = $valpesione;
			$acthumvariables -> picbf = $valicbf;
			$acthumvariables -> psena = $valsena;
			$acthumvariables -> pinstec = $valintec;
			$acthumvariables -> pesap = $valesap;
			$this -> actualizahumvariables = $acthumvariables ->save();
		}
	}
?>