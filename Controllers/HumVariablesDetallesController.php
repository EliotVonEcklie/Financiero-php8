<?php
	require_once '/../Models/Humvariablesdetalles.php';
	require_once '/../conexion.php';
	class HumVariablesDetallesController
	{
		public $allHumvariablesdetalles;
		public $maxHumvariabledetalles;
		public $minHumvariabledetalles;
		public $savevariablesdetalles;
		public function generarAllHumVariablesDetalles($valorbusqueda='',$nombrecampo='',$campoorden='',$sentido='')
		{
			if(is_array($campoorden))//VERIFICA SI TRAE CAMPOS PARA ORDENAR Y EL NUMERO DE ELLOS
			{
				$varbusqueda="$campoorden[0] $sentido[0]";
				$tvb=count($campoorden);
				for($x=1;$x<$tvb;$x++)
				{$varbusqueda="$varbusqueda, $campoorden[$x] $sentido[$x]";}
			}
			elseif($campoorden!=''){$varbusqueda="$campoorden $sentido";}
			else{$varbusqueda='';}
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
				if($campoorden != '')
				{
					if($varbusqueda!='')
					{$this->allHumvariablesdetalles=Humvariablesdetalles::where($condiciones)->orderByRaw($varbusqueda)->get();}
					else {$this->allHumvariablesdetalles=Humvariablesdetalles::where($condiciones)->get();}
				}
			}
			else //CUANDO LA CONSULTA LLAMA A TODOS O APLICA UNA SOLA CONDICION 
			{
				if($valorbusqueda != '')
				{
					if($varbusqueda!='')
					{$this->allHumvariablesdetalles=Humvariablesdetalles::where($nombrecampo,$valorbusqueda)->orderByRaw($varbusqueda)->get();}
					else {$this->allHumvariablesdetalles=Humvariablesdetalles::where($nombrecampo,$valorbusqueda)->get();}
				}
				else 
				{
					if($varbusqueda!=''){$this->allHumvariablesdetalles=Humvariablesdetalles::orderByRaw($varbusqueda)->all();}
					else {$this->allHumvariablesdetalles=Humvariablesdetalles::all();}
				}
			}
		}
		public function generarMaxHumVariablesDetalles()
		{
			$this->maxHumvariabledetalles=Humvariablesdetalles::max('id_det');
		}
		public function generarMinHumVariablesDetalles()
		{
			$this->minHumvariabledetalles=Humvariablesdetalles::min('id_det');
		}
		public function guardarHumVariablesDetalles()
		{
			$totalf=0;
			$totalvar=count($_POST['dcuentasp']);
			for($x=0;$x<$totalvar;$x++)
			{
				if($_POST['diddet'][$x]=='')
				{
					echo"<script>alert('".$_POST['diddet'][$x]."');</script>";
					preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/",$_POST['fecha'][$x],$fecha);
					$fechaf="$fecha[3]-$fecha[2]-$fecha[1]";
					$nuevoid=Humvariablesdetalles::max('id_det');
					$nuevoid+=1;
					$almHumVariablesDetalles = new Humvariablesdetalles();
					$almHumVariablesDetalles -> id_det = $nuevoid;
					$almHumVariablesDetalles -> codigo = $_POST['codigo'];
					$almHumVariablesDetalles -> concepto = $_POST['dconceptos'][$x];
					$almHumVariablesDetalles -> modulo = '2';
					$almHumVariablesDetalles -> tipoconce = 'C';
					$almHumVariablesDetalles -> cc = $_POST['dccs'][$x];
					$almHumVariablesDetalles -> cuentacon = '';
					$almHumVariablesDetalles -> cuentapres = $_POST['dcuentasp'][$x];
					$almHumVariablesDetalles -> estado = 'S';
					$almHumVariablesDetalles -> vigencia = $_POST['vigencia'];
					$almHumVariablesDetalles -> fecha = $fechaf;
					$sipasa = $almretencionesnomina -> save();
					if(!$sipasa){$totalf++;}
				}
				$this-> savevariablesdetalles = $totalf;
			}
		}
		public function borrarHumVariablesDetalles()
		{
			$eliminar = explode('<->', @$_POST['iddel']);
			$totaldel=count($eliminar);
			for($x=0;$x<$totaldel;$x++)
			{
				$delhumvariablesdetalles = Humvariablesdetalles::find($eliminar[$x]);
				$delhumvariablesdetalles -> delete();
			}
			
		}
	}
?>