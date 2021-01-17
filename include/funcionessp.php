<?php 
	function fgeneral01($servicio,$estrato,$rangosub,$consecutivo)
	{
		$tiposervisio=buscaservicio_liquida($servicio);
		$valorsubsidio=buscasubsidio_valor($servicio,$estrato,$tiposervisio,$rangosub);
		$valsaldoanterios=buscasaldoanterior($servicio,$consecutivo);
		$valintereses=buscar_intereses($servicio,$consecutivo);
		$valortarifa=buscatarifa_valor($servicio,$estrato,$tiposervisio,$rangosub);
		$valorcontribucion=buscacontribucion_valor($servicio,$estrato,$tiposervisio,$rangosub);
		$valgenerl01=array($tiposervisio,$valorsubsidio,$valsaldoanterios,$valintereses,$valortarifa,$valorcontribucion);
		return $valgenerl01;
	}
	function buscaservicio_liquida($servicio)//funciones
	{
		$mx='';
		$conexion = conectar_v7();
		$sqlr="SELECT tipo_liqui FROM servservicios WHERE codigo='$servicio'";
		$resp = mysqli_query($conexion,$sqlr);
		while ($row =mysqli_fetch_row($resp)){$mx=$row[0];}
		return $mx;
	}
	function buscasubsidio_valor($servicio,$estrato,$tiposervisio,$rangosub)//funciones
	{
		$mx=0;
		$conexion = conectar_v7();
		if($tiposervisio==1)
		{
			$sqlr="SELECT TB2.valor FROM servsubsidios TB1,servsubsidios_det TB2 WHERE TB1.codigo=TB2.codigo AND TB1.codservicio='$servicio' AND TB2.estrato='$estrato' AND  TB2.estado='S'";
		}
		elseif($tiposervisio==2)
		{
			$sqlr="SELECT TB2.valor FROM servsubsidios TB1,servsubsidios_det TB2 WHERE TB1.codigo=TB2.codigo AND TB1.codservicio='$servicio' AND TB2.estrato='$estrato' AND $rangosub between TB2.rango2 AND TB2.rango2 AND TB2.estado='S'";
		}
		$resp = mysqli_query($conexion,$sqlr);
		while ($row =mysqli_fetch_row($resp)){$mx=$row[0];}
		return $mx;
	}
	function buscasaldoanterior($servicio,$consecutivo)//funciones
	{
		$mx=0;
		$conexion = conectar_v7();
		$sqlr="SELECT valorliquidacion,abono FROM servliquidaciones_det WHERE codusuario='$consecutivo' AND servicio='$servicio' AND id_det=(SELECT MAX(id_det) FROM servliquidaciones_det WHERE codusuario='$consecutivo' AND servicio='$servicio')";
		$resp = mysqli_query($conexion,$sqlr);
		while ($row =mysqli_fetch_row($resp)){$mx=$row[0]-$row[1];}
		return $mx;
	}
	
	function buscar_intereses($servicio,$consecutivo)//validaciones
	{
		$mx=0;
		$conexion = conectar_v7();
		$sqlr="SELECT intereses FROM servliquidaciones_det WHERE codusuario='$consecutivo' AND servicio='$servicio' AND id_det=(SELECT MAX(id_det) FROM servliquidaciones_det WHERE codusuario='$consecutivo' AND servicio='$servicio')";
		$sqlr="SELECT intereses FROM servclientes WHERE codigo='$consecutivo'";
		$resp = mysqli_query($conexion,$sqlr);
		while ($row =mysqli_fetch_row($resp)){$mx=$row[0];}
		return $mx;
	}
	function buscatarifa_valor($servicio,$estrato,$tiposervisio,$rangosub)//funciones
	{
		$mx=array(0,0);
		$conexion = conectar_v7();
		if($tiposervisio==1)
		{
			$sqlr="SELECT TB2.valor,TB2.valorcf FROM servtarifas TB1,servtarifas_det TB2 WHERE TB1.codigo=TB2.codigo AND TB1.codservicio='$servicio' AND TB2.estrato=$estrato AND  TB2.estado='S'";
		}
		elseif($tiposervisio==2)
		{
			$sqlr="SELECT TB2.valor,TB2.valorcf FROM servtarifas TB1,servtarifas_det TB2 WHERE TB1.codigo=TB2.codigo AND TB1.codservicio='$servicio' AND TB2.estrato='$estrato' AND '$rangosub' between TB2.rango2 AND TB2.rango2 AND TB2.estado='S'";
		}
		$resp = mysqli_query($conexion,$sqlr);
		while ($row =mysqli_fetch_row($resp))
		{
			$mx[0]=$row[0];
			$mx[1]=$row[1];
		}
		return $mx;
	}
	function buscacontribucion_valor($servicio,$estrato,$tiposervisio,$rangosub)//funciones
	{
		$mx=0;
		$conexion = conectar_v7();
		if($tiposervisio==1)
		{
			$sqlr="SELECT TB2.valor FROM servcontribuciones TB1,servcontribuciones_det TB2 WHERE TB1.codigo=TB2.codigo AND TB1.codservicio='$servicio' AND TB2.estrato='$estrato' AND TB2.estado='S'";
		}
		elseif($tiposervisio==2)
		{
			$sqlr="SELECT TB2.valor FROM servcontribuciones TB1,servcontribuciones_det TB2 WHERE TB1.codigo=TB2.codigo AND TB1.codservicio='$servicio' AND TB2.estrato='$estrato' AND '$rangosub' between TB2.rango2 AND TB2.rango2 AND  TB2.estado='S'";
		}
		$resp = mysqli_query($conexion,$sqlr);
		while ($row =mysqli_fetch_row($resp)){$mx=$row[0];}
		return $mx;
	}
	function buscar_servicio($servicio)//funciones
	{
		$conexion = conectar_v7();
		$sqlr="SELECT nombre FROM servservicios WHERE codigo='$servicio'";
		$res=mysqli_query($conexion,$sqlr);
		while($r=mysqli_fetch_row($res)){$valor=$r[0];}
		return $valor;
	}
	function buscar_codcatservicios($idusuario)//validaciones
	{
		$conexion = conectar_v7();
		$sqlr="SELECT codcatastral FROM servclientes WHERE codigo='$idusuario'";
		$res=mysqli_query($conexion,$sqlr);
		while($r=mysqli_fetch_row($res)){$valor=$r[0];}
		return $valor;
	}
	function buscar_nomtercerosp($codigo)//validaciones
	{
		$conexion = conectar_v7();
		$sqlr="SELECT nombretercero FROM servclientes WHERE codigo='$codigo'";
		$res=mysqli_query($conexion,$sqlr);
		while($r=mysqli_fetch_row($res)){$valor=$r[0];}
		return $valor;
	}
	function buscaservicio_cc($servicio)//servicios
	{
		$conexion = conectar_v7();
		$sqlr="SELECT cc FROM servservicios WHERE codigo='$servicio' ";
		$res=mysqli_query($conexion,$sqlr);
		while($r=mysqli_fetch_row($res)){$valor=$r[0];}
		return $valor;
	}
	function buscar_barriodirecc($idcliente)//validaciones
	{
		$valor=array();
		$conexion = conectar_v7();
		$sqlr="SELECT barrio,direccion FROM servclientes WHERE codigo='$idcliente'";
		$res=mysqli_query($conexion,$sqlr);
		while($r=mysqli_fetch_row($res)){$valor[0]=$r[0];$valor[1]=$r[1];}
		return $valor;
	}
	function buscar_barrio($barrio)//validaciones
	{
		$conexion = conectar_v7();
		$sqlr="SELECT nombre FROM servbarrios WHERE id='$barrio'";
		$res=mysqli_query($conexion,$sqlr);
		while($r=mysqli_fetch_row($res)){$valor=$r[0];}
		return $valor;
	}
	function buscar_ruta($barrio)//validaciones
	{
		$conexion = conectar_v7();
		$sqlr="SELECT ruta FROM servrutas_barrios WHERE id_barrio='$barrio'";
		$res=mysqli_query($conexion,$sqlr);
		while($r=mysqli_fetch_row($res)){$valor=$r[0];}
		return $valor;
	}
	function buscaestrato_servicios($codigo)//funciones
	{
		$co=0;
		$conexion = conectar_v7();
		$sqlr="SELECT * FROM servestratos WHERE id='$codigo'";
		$res=mysqli_query($conexion,$sqlr);
		while($r=mysqli_fetch_row($res)){$valor2=$r[0]." - ".$r[2]." - ".$r[1];$co+=1;}
		if ($co>0){$nombre=$valor2;}
		else {$nombre="";}
		return $nombre;
	}
	function buscar_usosuelo($estrato)//validaciones
	{
		$conexion = conectar_v7();
		$sqlr="SELECT uso FROM servestratos WHERE id='$estrato'";
		$res=mysqli_query($conexion,$sqlr);
		while($r=mysqli_fetch_row($res)){$uso=$r[0];}
		$sqlr="SELECT * FROM dominios WHERE NOMBRE_DOMINIO='USO_SUELO' AND valor_inicial='$uso' ";
		$res=mysqli_query($conexion,$sqlr);
		while($r=mysqli_fetch_row($res)){$valor=$r[1];}
		return $valor;
	}
	function buscaconcepto_sp($servicio,$tipo)//funciones
	{
		$conexion = conectar_v7();
		switch ($tipo)
		{
			case 'TR':  //tarifas
				$sqlr="SELECT concecont FROM servtarifas WHERE codservicio='$servicio' AND estado='S' ";break;
			case 'SB':  //subsidios
				$sqlr="SELECT concecont FROM servsubsidios WHERE codservicio='$servicio' AND estado='S' ";break;
			case 'CT':  //contribucion
				$sqlr="SELECT concecont FROM servcontribuciones WHERE codservicio='$servicio' AND estado='S' ";break;
			case 'DS': //descuentos
				$sqlr="SELECT concecont FROM servdescuentos WHERE codservicio='$servicio' AND estado='S' ";break;
		}
		$res=mysqli_query($conexion,$sqlr);
		while($r=mysqli_fetch_row($res)){$valor=$r[0];}
		return $valor;
	}
	function mostrarservicios($cliente)//funciones
	{
		$conexion = conectar_v7();
		$valor='';
		$sqlr="SELECT servicio FROM terceros_servicios WHERE estado='S' AND consecutivo='$cliente' ";
		$res=mysqli_query($conexion,$sqlr);
		while($r=mysqli_fetch_row($res)){$valor.=" ".$r[0];}
		return $valor;
	}
	function buscarmedidor($cliente)//funciones
	{
		$conexion = conectar_v7();
		$valor='';
		$sqlr="SELECT codigo FROM servmedidores WHERE estado='S' AND cliente='$cliente' ";
		$res=mysqli_query($conexion,$sqlr);
		while($r=mysqli_fetch_row($res)){$valor=$r[0];}
		return $valor;
	}
	function buscarmedidor_servicios($cliente)//funciones
	{
		$conexion = conectar_v7();
		$valor=' ';
		$sqlr="SELECT servicio FROM servmedidores_servicios WHERE estado='S' and codigo='$cliente' ";
		$res=mysqli_query($conexion,$sqlr);
		while($r=mysqli_fetch_row($res))
		{$valor.=$r[0]." ";}
		return $valor;
	}
?>
