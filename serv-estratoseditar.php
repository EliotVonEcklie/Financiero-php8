<?php
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=iso-8859-1");
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_v7();
	cargarcodigopag($_GET['codpag'],$_SESSION["nivel"]);
	date_default_timezone_set("America/Bogota");
	$scroll=$_GET['scrtop'];
	$totreg=$_GET['totreg'];
	$idcta=$_GET['idcta'];
	$altura=$_GET['altura'];
	$filtro="'".$_GET['filtro']."'";
	//error_reporting(E_ALL);
	//ini_set('display_errors', '1');
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=iso-8859-1"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Ideal.10 - Servicios P&uacute;blicos</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css4.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
		<style>
			.onoffswitch
			{
				position: relative; width: 71px;
				-webkit-user-select:none;
				-moz-user-select:none;
				-ms-user-select: none;
			}
			.onoffswitch-checkbox {display: none;}
			.onoffswitch-label
			{
				display: block;
				overflow: hidden;
				cursor: pointer;
				border: 2px solid #DDE6E2;
				border-radius: 20px;
			}
			.onoffswitch-inner
			{
				display: block;
				width: 200%;
				margin-left: -100%;
				transition: margin 0.3s ease-in 0s;
			}
			.onoffswitch-inner:before, .onoffswitch-inner:after
			{
				display: block;
				float: left;
				width: 50%;
				height: 23px;
				padding: 0;
				line-height: 23px;
				font-size: 14px;
				color: white;
				font-family: Trebuchet, Arial, sans-serif;
				font-weight: bold;
				box-sizing: border-box;
			}
			.onoffswitch-inner:before
			{
				content: "SI";
				padding-left: 10px;
				background-color: #51C3E0;
				color: #FFFFFF;
			}
			.onoffswitch-inner:after
			{
				content: "NO";
				padding-right: 10px;
				background-color: #EEEEEE; color: #999999;
				text-align: right;
			}
			.onoffswitch-switch 
			{
				display: block;
				width: 17px;
				margin: 3px;
				background: #FFFFFF;
				position: absolute;
				top: 0;
				bottom: 0;
				right: 44px;
				border: 2px solid #DDE6E2;
				border-radius: 20px;
				transition: all 0.3s ease-in 0s;
			}
			.onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-inner {margin-left: 0;}
			.onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-switch {right: 0px;}
		</style>
		<script>
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventanam').src="";}
				else
				{
					switch(_tip)
					{
						case "1":	document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
						case "2":	document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
						case "3":	document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
						case "4":	document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;	
					}
				}
			}
			function funcionmensaje(){}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.form2.oculto.value='2';
								document.form2.submit();
								break;
				}
			}
			function guardar()
			{
				var validacion01=document.getElementById('codban').value;
				var validacion02=document.getElementById('nomban').value;
				if (validacion01.trim()!='' && validacion02.trim()) {despliegamodalm('visible','4','Esta Seguro de Modificar','1');}
				else {despliegamodalm('visible','2','Falta información para Modificar el Estrato');}
			}
			function cambiocheck()
			{
				if(document.getElementById('myonoffswitch').value=='S'){document.getElementById('myonoffswitch').value='N';}
				else{document.getElementById('myonoffswitch').value='S';}
				document.form2.submit();
			}
			function iratras(scrtop, numpag, limreg, filtro)
			{
				var idcta=document.getElementById('codban').value;
				location.href="serv-estratosbuscar.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+ "&filtro="+filtro;
			}
			function adelante(scrtop, numpag, limreg, filtro)
			{
				var maximo=document.getElementById('maximo').value;
				var actual=document.getElementById('codban').value;
				actual=parseFloat(actual)+1;
				if(actual<=parseFloat(maximo))
				{
					if(actual<10){actual="0"+actual;}
					location.href="serv-estratoseditar.php?idban=" +actual+ "&scrtop=" +scrtop+ "&numpag=" +numpag+ "&limreg=" +limreg+ "&filtro=" +filtro;
				}
			}
			function atrasc(scrtop, numpag, limreg, filtro, prev)
			{
				var minimo=document.getElementById('minimo').value;
				var actual=document.getElementById('codban').value;
				actual=parseFloat(actual)-1;
				if(actual>=parseFloat(minimo))
				{
					if(actual<10){actual="0"+actual;}
					location.href="serv-estratoseditar.php?idban=" +actual+ "&scrtop=" +scrtop+ "&numpag=" +numpag+ "&limreg=" +limreg+ "&filtro=" +filtro;
				}
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<?php
			$numpag=@ $_GET['numpag'];
			$limreg=@ $_GET['limreg'];
			$scrtop=26*$totreg;
		?>
		<table>
			<tr><script>barra_imagenes("serv");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("serv");?></tr>
			<tr>
				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='serv-estratos.php'" class="mgbt"/><img src="imagenes/guarda.png" title="Guardar" onClick="guardar()" class="mgbt"/><img src="imagenes/busca.png" title="Buscar" onClick="location.href='serv-estratosbuscar.php'" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" onClick="<?php echo paginasnuevas("serv");?>" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s" onClick="iratras(<?php echo "$scrtop, $numpag, $limreg, $filtro"; ?>)" class="mgbt"/></td>
			</tr>
		</table>
		<div id="bgventanamodalm" class="bgventanamodalm">
			<div id="ventanamodalm" class="ventanamodalm">
				<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"></IFRAME>
			</div>
		</div>
		<form name="form2" method="post" action="">
			<?php
				if(@ $_POST['oculto']=="")
				{
					
					$sqlr="SELECT MIN(id), MAX(id) FROM srvestratos";
					$res=mysqli_query($linkbd,$sqlr);
					$r=mysqli_fetch_row($res);
					$_POST['minimo']=$r[0];
					$_POST['maximo']=$r[1];
					$sqlr="SELECT * FROM srvestratos WHERE id='".$_GET['idban']."'";
					$resp = mysqli_query($linkbd,$sqlr);
					$row =mysqli_fetch_row($resp); 
					$_POST['codban']=$row[0];
					$_POST['nomban']=$row[1];
					$_POST['vtipo']=$row[2];
					$_POST['vuso']=$row[3];
					$_POST['onoffswitch']=$row[4];

				}
			?>
			<table class="inicio ancho">
				<tr>
					<td class="titulos" colspan="6">.: Editar Estrato</td>
					<td class="cerrar" style="width:7%" onClick="location.href='serv-principal.php'">Cerrar</td>
				</tr>
				<tr>
					<td class="tamano01" style="width:3cm;">C&oacute;digo:</td>
					<td style="width:15%;"><img src="imagenes/back.png" onClick="atrasc(<?php echo "$scrtop, $numpag, $limreg, $filtro"; ?>)" class="icobut" title="Anterior"/>&nbsp;<input type="text" name="codban" id="codban" onKeyUp="return tabular(event,this)" value="<?php echo @ $_POST['codban'];?>" style="width:60%;height:30px;" readonly/>&nbsp;<img src="imagenes/next.png" onClick="adelante(<?php echo "$scrtop, $numpag, $limreg, $filtro" ?>);" class="icobut" title="Sigiente"/></td>
					<td class="tamano01" style="width:3cm;">Descripci&oacute;n:</td>
					<td colspan="3"><input type="text" name="nomban" id="nomban" value="<?php echo $_POST['nomban'];?>" style="width:100%; height:30px;text-transform:uppercase"/></td>
				</tr>
				<tr>
					<td class="tamano01" style="width:3cm;">Tipo:</td>
					<td><input type="text" name="vtipo" id="vtipo" onKeyUp="return tabular(event,this)" value="<?php echo @ $_POST['vtipo'];?>" style="width:100%;height:30px;"/></td>
					<td class="tamano01" style="width:3cm;">Uso:</td>
					<td style="width:15%;">
						<select name="vuso" id="vuso" style="width:100%">
							<option value="-1">:: Seleccione Barrio ::</option>
							<?php
								$sqlr="SELECT id,nombre FROM srvusosdesuelo WHERE estado = 'S' ORDER BY id;";
								$resp = mysqli_query($linkbd,$sqlr);
								while ($row =mysqli_fetch_row($resp))
								{
									if($_POST['vuso']==$row[0])
									{
										echo "<option value='$row[0]' SELECTED>$row[1]</option>";
									}
									else {echo "<option value='$row[0]'>$row[1]</option>no";}
								}
							?>
						</select>
					</td>
					<td class="tamano01" style="width:3cm;">Estado:</td>
					<td>
						<div class="onoffswitch">
							<input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" value="<?php echo @ $_POST['onoffswitch'];?>" <?php if(@ $_POST['onoffswitch']=='S'){echo "checked";}?> onChange="cambiocheck();"/>
							<label class="onoffswitch-label" for="myonoffswitch">
								<span class="onoffswitch-inner"></span>
								<span class="onoffswitch-switch"></span>
							</label>
						</div>
					</td>
				</tr>
			</table>
			<input type="hidden" name="maximo" id="maximo" value="<?php echo @ $_POST['maximo']?>"/>
			<input type="hidden" name="minimo" id="minimo" value="<?php echo @ $_POST['minimo']?>"/>
			<input type="hidden" name="oculto" id="oculto" value="1"/>
			<?php
				if(@ $_POST['oculto']=="2")
				{
					if (@ $_POST['onoffswitch']!='S'){$valest='N';}
					else {$valest='S';}
					$sqlr ="UPDATE srvestratos SET descripcion='".$_POST['nomban']."',tipo='".$_POST['vtipo']."', uso='".$_POST['vuso']."',estado='$valest' WHERE id='".$_POST['codban']."'";
					if (!mysqli_query($linkbd,$sqlr))
					{
						$e =mysqli_error(mysqli_query($linkbd,$sqlr));
						echo"<script>despliegamodalm('visible','2','No se pudo ejecutar la petición: $e');</script>";
					}
					else 
					{
						echo "<script>despliegamodalm('visible','3','Se ha Edito con Exito');</script>";
					}
				}
			?>
		</form>
		<div id="bgventanamodal2">
			<div id="ventanamodal2">
				<IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"></IFRAME>
			</div>
		</div>
	</body>
</html>