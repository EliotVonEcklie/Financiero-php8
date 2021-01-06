<?php
	require '../../comun.inc';
	$linkbd = conectar_v7();
	$linkbd -> set_charset("utf8");
	$out = array('error' => false);
	if(isset($_GET['visualizar']))
	{
		$visualizar=$_GET['visualizar'];
		switch ($visualizar)
		{
			case 'cabecera':
				$sql="SELECT id,idunidadej,codigo,vigencia,nombre,descripcion,valortotal,aprobado,estado FROM ccpproyectospresupuesto ORDER BY id DESC";
				$res=mysqli_query($linkbd,$sql);
				$codigos = array();
				while($row=mysqli_fetch_row($res))
				{
					array_push($codigos, $row);
				}
				$out['codigos'] = $codigos;
		}
	}
	if(isset($_GET['action']))
	{
		$action=$_GET['action'];
		if($action=='searchProyecto')
		{
			$keyword=$_POST['keyword'];
			$sql="SELECT id,idunidadej,codigo,vigencia,nombre,descripcion,valortotal,aprobado,estado FROM ccpproyectospresupuesto WHERE nombre like '%$keyword%' OR descripcion like '%$keyword%' OR codigo like '%$keyword%' ORDER BY id DESC";
			$res=mysqli_query($linkbd,$sql);
			$codigos = array();
			while($row=mysqli_fetch_row($res))
			{
				array_push($codigos, $row);
			}
				$out['codigos'] = $codigos;
		}
	}
	if(isset($_GET['elimina']))
	{
		$numdel=$_GET['elimina'];
		if($numdel!='')
		{
			$sql="DELETE FROM ccpproyectospresupuesto WHERE id = $numdel";
			$res=mysqli_query($linkbd,$sql);
			$sql="DELETE FROM ccpproyectospresupuesto_productos WHERE codproyecto = $numdel";
			$res=mysqli_query($linkbd,$sql);
			$sql="DELETE FROM ccpproyectospresupuesto_presupuesto WHERE codproyecto = $numdel";
			$res=mysqli_query($linkbd,$sql);
		}
	}

	header("Content-type: application/json");
	echo json_encode($out);
	die();
?>