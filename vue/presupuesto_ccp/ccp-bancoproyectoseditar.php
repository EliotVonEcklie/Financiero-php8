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
				$sql="DELETE FROM ccpproyectospresupuesto WHERE id = $numid";
				mysqli_query($linkbd,$sql);
				$sql="DELETE FROM ccpproyectospresupuesto_productos WHERE codproyecto = $numid";
				$res=mysqli_query($linkbd,$sql);
				$sql="DELETE FROM ccpproyectospresupuesto_presupuesto WHERE codproyecto = $numid";
				$res=mysqli_query($linkbd,$sql);
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
					$sql="INSERT INTO ccpproyectospresupuesto_presupuesto (id,codproyecto,id_fuente,medio_pago,rubro,clasificacion,seccion,divicion,grupo, clase,subclase,identidad,nitentidad,codigocuin,valorcsf,valorssf,estado) VALUES ('$idcuenta','$numid','$cuentas[8]','$cuentas[9]','$cuentas[0]','$cuentas[1]', '$cuentas[2]','$cuentas[3]','$cuentas[4]','$cuentas[5]', '$cuentas[6]','','','','$valcsf','$valssf','S')";
					mysqli_query($linkbd,$sql);
					unset($cuentas);
				}
			}break;
			//default: echo 'H:'.$guardar;
		}
	}
	if(isset($_GET['accion']))
	{
		$accion=$_GET['accion'];
		switch ($accion)
		{
			case 'inicialproyecto':
			{
				$idproy=$_GET['idproy'];
				$sql="SELECT id,idunidadej,codigo,vigencia,nombre,descripcion,valortotal,aprobado,estado FROM ccpproyectospresupuesto WHERE id='$idproy'";
				$res=mysqli_query($linkbd,$sql);
				$codigos = array();
				while($row=mysqli_fetch_row($res))
				{
					array_push($codigos, $row);
				}
				$out['codigos'] = $codigos;
			}break;
			case 'unidadejecutora':
			{
				$idunieje=$_GET['idunieje'];
				$sql="SELECT nombre FROM pptouniejecu WHERE id_cc='$idunieje'";
				$res=mysqli_query($linkbd,$sql);
				$codigos = array();
				while($row=mysqli_fetch_row($res))
				{
					array_push($codigos, $row);
				}
				$out['codigos'] = $codigos;
			}break;
			case 'iniciaproductos':
			{
				$idunieje=$_GET['idunieje'];
				$sql="SELECT T1.sector,T1.programa,T1.subprograma,T1.producto,T1.indicador,T2.indicador_producto,T2.producto FROM ccpproyectospresupuesto_productos AS T1 INNER JOIN ccpetproductos AS T2 ON T2.codigo_indicador = T1.indicador WHERE T1.codproyecto='$idunieje'";
				$res=mysqli_query($linkbd,$sql);
				$codigos = array();
				while($row=mysqli_fetch_row($res))
				{
					array_push($codigos, $row);
				}
				$out['codigos'] = $codigos;
			}break;
			case 'iniciasector':
			{
				$idproy=$_GET['idproy'];
				$sql="SELECT DISTINCT (T1.sector),T2.nombre FROM ccpproyectospresupuesto_productos AS T1 INNER JOIN ccpetsectores AS T2 ON T2.codigo = T1.sector WHERE T1.codproyecto='$idproy'";
				$res=mysqli_query($linkbd,$sql);
				$codigos = array();
				while($row=mysqli_fetch_row($res))
				{
					array_push($codigos, $row);
				}
				$out['codigos'] = $codigos;
			}break;
			case 'iniciaprograma':
			{
				$idproy=$_GET['idproy'];
				$sql="SELECT DISTINCT (T1.programa),T1.subprograma,T2.nombre,T2.nombre_subprograma FROM ccpproyectospresupuesto_productos AS T1 INNER JOIN ccpetprogramas AS T2 ON T2.codigo= T1.programa WHERE T1.codproyecto='$idproy'";
				$res=mysqli_query($linkbd,$sql);
				$codigos = array();
				while($row=mysqli_fetch_row($res))
				{
					array_push($codigos, $row);
				}
				$out['codigos'] = $codigos;
			}break;
			case 'iniciasinclasificador':
			{
				$idproy=$_GET['idproy'];
				$sql="SELECT T1.id_fuente, T1.medio_pago, T1.rubro, T1.valorcsf, T1.valorssf, T2.nombre FROM ccpproyectospresupuesto_presupuesto AS T1 INNER JOIN cuentasccpet AS T2 ON T2.codigo=T1.rubro WHERE T1.codproyecto='$idproy' AND clasificacion='0'";
				$res=mysqli_query($linkbd,$sql);
				$codigos = array();
				while($row=mysqli_fetch_row($res))
				{
					array_push($codigos, $row);
				}
				$out['codigos'] = $codigos;
			}break;
			case 'iniciaclasificador1':
			{
				$idproy=$_GET['idproy'];
				$sql="SELECT T1.id_fuente, T1.medio_pago,T1.rubro,T1.identidad,T1.nitentidad,T1.codigocuin,T1.valorcsf,T1.valorssf,T2.nombre,T3.fuente_financiacion FROM ccpproyectospresupuesto_presupuesto AS T1 INNER JOIN ccpet_cuin AS T2 ON T2.id_entidad=T1.identidad AND T2.nit=T1.nitentidad INNER JOIN ccpet_fuentes AS T3 ON T3.id=T1.id_fuente WHERE T1.codproyecto='$idproy' AND clasificacion='1'";
				$res=mysqli_query($linkbd,$sql);
				$codigos = array();
				while($row=mysqli_fetch_row($res))
				{
					array_push($codigos, $row);
				}
				$out['codigos'] = $codigos;
			}break;
			case 'iniciaclasificador2':
			{
				$idproy=$_GET['idproy'];
				$sql="SELECT T1.id_fuente, T1.medio_pago,T1.rubro,T1.seccion,T1.divicion,T1.grupo,T1.clase,T1.subclase,T1.valorcsf,T1.valorssf,T2.nombre, T3.fuente_financiacion,T4.titulo,T1.subproducto FROM ccpproyectospresupuesto_presupuesto AS T1 INNER JOIN cuentasccpet AS T2 ON T2.codigo=T1.rubro INNER JOIN ccpet_fuentes AS T3 ON T3.id=T1.id_fuente INNER JOIN ccpetbienestransportables AS T4 ON T4.grupo = T1.subclase WHERE T1.codproyecto='$idproy' AND clasificacion='2'";
				$res=mysqli_query($linkbd,$sql);
				$codigos = array();
				while($row=mysqli_fetch_row($res))
				{
					array_push($codigos, $row);
				}
				$out['codigos'] = $codigos;
			}break;
			case 'iniciaclasificador3':
			{
				$idproy=$_GET['idproy'];
				$sql="SELECT T1.id_fuente, T1.medio_pago,T1.rubro,T1.seccion,T1.divicion,T1.grupo,T1.clase,T1.subclase,T1.valorcsf,T1.valorssf,T2.nombre, T3.fuente_financiacion,T4.titulo FROM ccpproyectospresupuesto_presupuesto AS T1 INNER JOIN cuentasccpet AS T2 ON T2.codigo=T1.rubro INNER JOIN ccpet_fuentes AS T3 ON T3.id=T1.id_fuente INNER JOIN ccpetservicios AS T4 ON T4.grupo = T1.subclase WHERE T1.codproyecto='$idproy' AND clasificacion='3'";
				$res=mysqli_query($linkbd,$sql);
				$codigos = array();
				while($row=mysqli_fetch_row($res))
				{
					array_push($codigos, $row);
				}
				$out['codigos'] = $codigos;
			}break;
		}
	}
	header("Content-type: application/json");
	echo json_encode($out);
	die();
?>