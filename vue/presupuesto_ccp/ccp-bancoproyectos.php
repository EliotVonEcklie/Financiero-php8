<?php
	require '../../comun.inc';
	$linkbd = conectar_v7();
	$linkbd -> set_charset("utf8");
	$out = array('error' => false);

	function selconsecutivo($base,$campo)
	{
		$conexion=conectar_v7();
		$sqlr="SELECT MAX(CONVERT($campo, SIGNED INTEGER)) FROM $base";
		$resp = mysqli_query($conexion,$sqlr);
		while ($row =mysqli_fetch_row($resp)){$mx=$row[0];}
		$mx=$mx+1;
		return $mx; 
	}
	if(isset($_GET['numid']))
	{
		$sqlr="SELECT MAX(id) FROM ccpproyectospresupuesto";
		$resp = mysqli_query($linkbd,$sqlr);
		while ($row =mysqli_fetch_row($resp)){$mx=$row[0];}
		$mx=$mx+1;
		$out['numid']=$mx;
	}
	if(isset($_GET['guardar']))
	{
		$guardar=$_GET['guardar'];
		switch ($guardar)
		{
			case 'cabecera':
			{
				$numid=$_POST['idnum'];
				$idunidadej=$_POST['idunidadej'];
				$codigo=$_POST['codigo'];
				$vigencia=$_POST['vigencia'];
				$nombre=$_POST['nombre'];
				$descripcion=$_POST['descripcion'];
				$valortotal=$_POST['valortotal'];
				$sql="INSERT INTO ccpproyectospresupuesto (id,idunidadej,codigo,vigencia,nombre,descripcion,valortotal,aprobado,estado) VALUES ('$numid', '$idunidadej', '$codigo','$vigencia','$nombre', '$descripcion','$valortotal','N','S')";
				mysqli_query($linkbd,$sql);
			}break;
			case 'productos':
			{
				$numid=$_POST['idnum'];
				$codigo=$_POST['infproyectos'];
				for($x=0;$x < count($codigo);$x++)
				{ 
					$productos = explode(",", $codigo[$x]);
					$idproducto=selconsecutivo('ccpproyectospresupuesto_productos','id');
					$sql="INSERT INTO ccpproyectospresupuesto_productos (id,codproyecto,sector,programa,subprograma,producto,indicador,estado) VALUES ('$idproducto','$numid','$productos[2]','$productos[3]','$productos[4]','$productos[0]','$productos[1]','S')";
					mysqli_query($linkbd,$sql);
					unset($productos);
				}
			}break;
			case 'ccuentascuin':
			{
				$numid=$_POST['idnum'];
				$codigo=$_POST['infcuentascuin'];
				for($x=0;$x < count($codigo);$x++)
				{
					$cuentas = explode(",", $codigo[$x]);
					if($cuentas[6]=='CSF')
					{
						$valcsf=$cuentas[4];
						$valssf=0;
					}
					else
					{
						$valcsf=0;
						$valssf=$cuentas[4];
					}
					$idcuenta=selconsecutivo('ccpproyectospresupuesto_presupuesto','id');
					$sql="INSERT INTO ccpproyectospresupuesto_presupuesto (id,codproyecto,id_fuente,medio_pago,rubro,clasificacion,seccion,divicion,grupo, clase,subclase,identidad,nitentidad,codigocuin,valorcsf,valorssf,estado) VALUES ('$idcuenta','$numid','$cuentas[5]','$cuentas[6]','$cuentas[0]','1','','','','','','$cuentas[1]','$cuentas[2]','$cuentas[3]','$valcsf','$valssf','S')";
					mysqli_query($linkbd,$sql);
					unset($cuentas);
				}
			}break;
			case 'ccuentassinclasificador':
			{
				$numid=$_POST['idnum'];
				$codigo=$_POST['infcuentassinclasificador'];
				for($x=0;$x < count($codigo);$x++)
				{
					$cuentas = explode(",", $codigo[$x]);
					if($cuentas[3]=='CSF')
					{
						$valcsf=$cuentas[1];
						$valssf=0;
					}
					else
					{
						$valcsf=0;
						$valssf=$cuentas[1];
					}
					$idcuenta=selconsecutivo('ccpproyectospresupuesto_presupuesto','id');
					$sql="INSERT INTO ccpproyectospresupuesto_presupuesto (id,codproyecto,id_fuente,medio_pago,rubro,clasificacion,seccion,divicion,grupo,clase, subclase,identidad,nitentidad,codigocuin,valorcsf,valorssf,estado) VALUES ('$idcuenta','$numid','$cuentas[2]','$cuentas[3]','$cuentas[0]','0', '','','','','','','','','$valcsf','valssf','S')";
					mysqli_query($linkbd,$sql);
					unset($cuentas);
				}
			}break;
			case 'cuentasb':
			{
				$numid=$_POST['idnum'];
				$codigo=$_POST['infcuentasb'];
				for($x=0;$x < count($codigo);$x++)
				{
					$cuentas = explode(",", $codigo[$x]);
					if($cuentas[9]=='CSF')
					{
						$valcsf=$cuentas[7];
						$valssf=0;
					}
					else
					{
						$valcsf=0;
						$valssf=$cuentas[7];
					}
					$idcuenta=selconsecutivo('ccpproyectospresupuesto_presupuesto','id');
					$sql="INSERT INTO ccpproyectospresupuesto_presupuesto (id,codproyecto,id_fuente,medio_pago,rubro,clasificacion,seccion,divicion,grupo, clase,subclase,subproducto,identidad,nitentidad,codigocuin,valorcsf,valorssf,estado) VALUES ('$idcuenta','$numid','$cuentas[8]','$cuentas[9]', '$cuentas[0]','$cuentas[1]','$cuentas[2]','$cuentas[3]','$cuentas[4]','$cuentas[5]', '$cuentas[6]','$cuentas[10]','','','','$valcsf','$valssf', 'S')";
					mysqli_query($linkbd,$sql);
					unset($cuentas);
				}
			}break;
			//default: echo 'H:'.$guardar;
		}
	}
	if(isset($_GET['buscar']))
	{
		$buscar=$_GET['buscar'];
		switch ($buscar)
		{
			case 'nombregrupo':
			{
				$grupo=$_GET['grupo'];
				$sql = "SELECT titulo FROM ccpetbienestransportables WHERE grupo like '$grupo'";
				$res = mysqli_query($linkbd,$sql);
				$codigos = array();
				while($row=mysqli_fetch_row($res))
				{
					array_push($codigos, $row);
				}
				$out['codigos'] = $codigos;
			}break;
			case 'nombregrupos':
			{
				$grupo=$_GET['grupo'];
				$sql = "SELECT titulo FROM ccpetservicios WHERE grupo like '$grupo'";
				$res = mysqli_query($linkbd,$sql);
				$codigos = array();
				while($row=mysqli_fetch_row($res))
				{
					array_push($codigos, $row);
				}
				$out['codigos'] = $codigos;
			}break;
			case 'subproducto':
			{
				$keywordsubproductos = $_POST['keywordsubproductos'];
				if(isset($_GET['seccion']))
				{
					if($_GET['seccion']!='')
					{
						$idt="AND LEFT(grupo,".$_GET['nivel'].")='".$_GET['seccion']."'";
					}
					else {$idt='';}
				}
				else {$idt='';}
				$sql="SELECT MAX(version) FROM ccpetbienestransportables";
				$res = mysqli_query($linkbd,$sql);
				$row=mysqli_fetch_row($res);
				$maxversion=$row[0];
				$sql = "SELECT grupo, titulo, ciiu, sistema_armonizado, cpc FROM ccpetbienestransportables WHERE concat_ws(' ', grupo, titulo) like '%$keywordsubproductos%' AND version='$maxversion' AND LENGTH(grupo) = '7' $idt";
				$res = mysqli_query($linkbd,$sql);
				$codigos = array();
				while($row=mysqli_fetch_row($res))
				{
					array_push($codigos, $row);
				}
				$out['codigos'] = $codigos;
			}break;
			case 'valsubproducto':
			{
				if(isset($_POST['codigo']))
				{
					if(isset($_POST['seccion']))
					{
						if($_POST['seccion']!='')
						{
							$idt="AND LEFT(grupo,".$_POST['nivel'].")='".$_POST['seccion']."'";
						}
						else {$idt='';}
					}
					else {$idt='';}
					$sql="SELECT MAX(version) FROM ccpetbienestransportables";
					$res = mysqli_query($linkbd,$sql);
					$row=mysqli_fetch_row($res);
					$maxversion=$row[0];
					$sql = "SELECT titulo FROM ccpetbienestransportables WHERE concat_ws(' ', grupo, titulo) like '%".$_POST['codigo']."%' AND version='$maxversion' $idt";
					$res = mysqli_query($linkbd,$sql);
					$codigos = array();
					while($row=mysqli_fetch_row($res))
					{
						array_push($codigos, $row);
					}
					$out['codigos'] = $codigos;
				}
			}break;
			case 'valsubclases':
			{
				if(isset($_POST['codigo']))
				{
					if(isset($_POST['seccion']))
					{
						if($_POST['seccion']!='')
						{
							$idt="AND LEFT(grupo,".$_POST['nivel'].")='".$_POST['seccion']."'";
						}
						else {$idt='';}
					}
					else {$idt='';}
					$sql="SELECT MAX(version) FROM ccpetservicios";
					$res = mysqli_query($linkbd,$sql);
					$row=mysqli_fetch_row($res);
					$maxversion=$row[0];
					$sql = "SELECT titulo FROM ccpetservicios WHERE concat_ws(' ', grupo, titulo) like '%".$_POST['codigo']."%' AND version='$maxversion' $idt";
					$res = mysqli_query($linkbd,$sql);
					$codigos = array();
					while($row=mysqli_fetch_row($res))
					{
						array_push($codigos, $row);
					}
					$out['codigos'] = $codigos;
				}
			}break;
			case 'valsubclaseb':
			{
				if(isset($_POST['codigo']))
				{
					if(isset($_POST['seccion']))
					{
						if($_POST['seccion']!='')
						{
							$idt="AND LEFT(grupo,".$_POST['nivel'].")='".$_POST['seccion']."'";
						}
						else {$idt='';}
					}
					else {$idt='';}
					$sql="SELECT MAX(version) FROM ccpetbienestransportables";
					$res = mysqli_query($linkbd,$sql);
					$row=mysqli_fetch_row($res);
					$maxversion=$row[0];
					$sql = "SELECT titulo FROM ccpetbienestransportables WHERE concat_ws(' ', grupo, titulo) like '%".$_POST['codigo']."%' AND version='$maxversion' $idt";
					$res = mysqli_query($linkbd,$sql);
					$codigos = array();
					while($row=mysqli_fetch_row($res))
					{
						array_push($codigos, $row);
					}
					$out['codigos'] = $codigos;
				}
			}break;
			case 'subclaseb':
			{
				$keywordsubclase = $_POST['keywordsubclase'];
				if(isset($_GET['seccion']))
				{
					if($_GET['seccion']!='')
					{
						$idt="AND LEFT(grupo,".$_GET['nivel'].")='".$_GET['seccion']."'";
					}
					else {$idt='';}
				}
				else {$idt='';}
				$sql="SELECT MAX(version) FROM ccpetbienestransportables";
				$res = mysqli_query($linkbd,$sql);
				$row=mysqli_fetch_row($res);
				$maxversion=$row[0];
				$sql = "SELECT grupo, titulo, ciiu, sistema_armonizado, cpc FROM ccpetbienestransportables WHERE concat_ws(' ', grupo, titulo) like '%$keywordsubclase%' AND version='$maxversion' AND LENGTH(grupo) = '5' $idt";
				$res = mysqli_query($linkbd,$sql);
				$subClases = array();
				while($row=mysqli_fetch_row($res))
				{
					array_push($subClases, $row);
				}
				$out['subClases'] = $subClases;
			}break;
			case 'subclases':
			{
				$keywordsubclase = $_POST['keywordsubclase'];
				if(isset($_GET['seccion']))
				{
					if($_GET['seccion']!='')
					{
						$idt="AND LEFT(grupo,".$_GET['nivel'].")='".$_GET['seccion']."'";
					}
					else {$idt='';}
				}
				else {$idt='';}
				$sql="SELECT MAX(version) FROM ccpetservicios";
				$res = mysqli_query($linkbd,$sql);
				$row=mysqli_fetch_row($res);
				$maxversion=$row[0];
				$sql = "SELECT grupo, titulo, ciiu,'', cpc FROM ccpetservicios WHERE concat_ws(' ', grupo, titulo) like '%$keywordsubclase%' AND version='$maxversion' AND LENGTH(grupo) = '5' $idt";
				$res = mysqli_query($linkbd,$sql);
				$subClases = array();
				while($row=mysqli_fetch_row($res))
				{
					array_push($subClases, $row);
				}
				$out['subClases'] = $subClases;
			}break;
			case 'valindicproducto':
			{
				if(isset($_POST['codigo']))
				{
					$sql="SELECT MAX(version) FROM ccpetbienestransportables";
					$res = mysqli_query($linkbd,$sql);
					$row=mysqli_fetch_row($res);
					$maxversion=$row[0];
					$sql = "SELECT indicador_producto,cod_producto,producto FROM ccpetproductos WHERE codigo_indicador = '".$_POST['codigo']."' AND version='$maxversion'";
					$res = mysqli_query($linkbd,$sql);
					$codigos = array();
					while($row=mysqli_fetch_row($res))
					{
						array_push($codigos, $row);
					}
					$out['codigos'] = $codigos;
				}
			}break;
			case 'valprograma':
			{
				$sql="SELECT MAX(version) FROM ccpetprogramas";
				$res = mysqli_query($linkbd,$sql);
				$row=mysqli_fetch_row($res);
				$maxversion=$row[0];
				$sqlr = "SELECT nombre,codigo_subprograma,nombre_subprograma FROM ccpetprogramas WHERE codigo = '".$_GET['programa']."' AND version='$maxversion'";
				$res=mysqli_query($linkbd,$sqlr);
				$programas = array();
				while($row=mysqli_fetch_row($res))
				{
					array_push($programas, $row);
				}
				$out['programas'] = $programas;
			}break;
			case 'valsector':
			{
				$sql = "SELECT MAX(version) FROM ccpetsectores";
				$res = mysqli_query($linkbd,$sql);
				$row=mysqli_fetch_row($res);
				$maxversion=$row[0];
				$sqlr="SELECT nombre FROM ccpetsectores WHERE codigo='".$_GET['sector']."' AND version='$maxversion'";
				$res = mysqli_query($linkbd,$sqlr);
				$sectores = array();
				while($row=mysqli_fetch_row($res))
				{
					array_push($sectores, $row);
				}
				$out['sectores'] = $sectores;
			}break;
			case 'years':
			{
				$sqlr="SELECT anio FROM admbloqueoanio WHERE bloqueado='N'";
				$res = mysqli_query($linkbd,$sqlr);
				$anio = array();
				while($row=mysqli_fetch_row($res))
				{
					array_push($anio, $row);
				}
				$out['anio'] = $anio;
			}break;
		}
	}
	header("Content-type: application/json");
	echo json_encode($out);
	die();
?>