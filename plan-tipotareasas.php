<?php
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=iso-8859-1");
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_v7();
	cargarcodigopag($_GET['codpag'],$_SESSION["nivel"]);
	date_default_timezone_set("America/Bogota");
	//error_reporting(E_ALL);
	//ini_set('display_errors', '1');
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=iso-8859-1"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>::SPID-Planeaci&oacute;n Estrat&eacute;gica</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css"/>
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script type='text/javascript' src="JQuery/jquery-2.1.4.min.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script type="text/javascript" src="JQuery/alphanum/jquery.alphanum.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script>
			function guardar()
			{
				var validacion01=document.getElementById('granombre').value;
				var validacion02=document.getElementById('gradescr').value;
				var validacion03=document.getElementById('gratiempo').value;
				if (validacion01.trim()!='' && validacion02.trim()!='' && validacion03.trim()!='')
				{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
				else
				{
					despliegamodalm('visible','2','Faltan datos para completar el registro');
					document.form2.nombre.focus();document.form2.nombre.select();
				}
			}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventanam').src="";}
				else
				{
					switch(_tip)
					{
						case "1":
							document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
						case "2":
							document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
						case "3":
							document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
						case "4":
							document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;	
					}
				}
			}
			function funcionmensaje(){document.location.href = "plan-tipotareasas.php";}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.form2.oculto.value="2";document.form2.submit();break;
				}
			}
			function valrrespuesta()
			{
				if (document.getElementById('rrespuesta').value!='S')
				{
					document.getElementById('gratiempo').value=0;
					document.getElementById('vrespuesta').value="readonly";
				}
				else {document.getElementById('vrespuesta').value="";}
				document.form2.submit();
			}
		</script>
	</head>
	<body>
	<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
	<span id="todastablas2"></span>
		<table >
			<tr><script>barra_imagenes("plan");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("plan");?></tr>
			<tr>
				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='plan-tipotareasas.php'" class="mgbt"/><img src="imagenes/guarda.png" title="Guardar" onClick="guardar();" class="mgbt"/><img src="imagenes/busca.png" title="Buscar" onClick="location.href='plan-tipotareabuscar.php'" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" onClick="<?php echo paginasnuevas("plan");?>" class="mgbt"/></td>
			</tr>
		</table>
		<div id="bgventanamodalm" class="bgventanamodalm">
			<div id="ventanamodalm" class="ventanamodalm">
				<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"></IFRAME>
			</div>
		</div>	
		<form name="form2" method="post" action="">
			<?php if (@ $_POST['oculto']==""){$_POST['tipopqr']='N';}?>
			<table class="inicio" >
				<tr>
					<td class="titulos" colspan="9">:: Ingresar Tipo de Tareas</td>
					<td class="cerrar" style="width:7%" onClick="location.href='plan-principal.php'">&nbsp;Cerrar</td>
				</tr>
				<tr>
					<td class="saludo1" style="width:2.5cm">:&middot; Nombre:</td>
					<td style="width:40%"><input type="text" name="granombre" id="granombre" style="width:100%" value="<?php echo @ $_POST['granombre'];?>"></td>
					<td class="saludo1" style="width:4cm">:&middot; Requiere Respuesta:</td>
					<td style="width:7%">
						<select name="rrespuesta" id="rrespuesta" style="width:100%" onChange="valrrespuesta()">
							<option value="S" <?php if(@ $_POST['rrespuesta']=="S"){echo "SELECTED ";}?>>SI</option>
							<option value="N" <?php if(@ $_POST['rrespuesta']=="N"){echo "SELECTED ";}?>>NO</option>
						</select>
						<input type="hidden" id="vrespuesta" name="vrespuesta" value="<?php echo $_POST[vrespuesta];?>"/>
					</td>
					<td class="saludo1" style="width:4cm">:&middot; Tiempo de Respuesta:</td>
					<td><input type="text" name="gratiempo" id="gratiempo" style="width:100%" value="<?php echo @ $_POST['gratiempo'];?>" title="Días" <?php echo @ $_POST['vrespuesta'];?>/></td>
				</tr>
				<tr>
					<td class="saludo1" style="width:2.5cm">:&middot; Descripci&oacute;n:</td>
					<td style="width:40%"><input type="text" name="gradescr" id="gradescr" style="width:100%" value="<?php echo @ $_POST['gradescr'];?>"></td>
					<td class="saludo1" >:&middot; Tipo de D&iacute;as:</td>
					<td >
						<select name="tipcal" id="tipcal" style="width:100%">
							<option value="N" <?php if(@ $_POST['tipcal']=="N"){echo "SELECTED ";}?>>....</option>
								<?php
									if(@ $_POST['vrespuesta']=="")
									{
										echo"<option value='H' "; if(@ $_POST['tipcal']=="H"){echo "SELECTED ";}echo">Habiles</option>";
										echo"<option value='C' "; if(@ $_POST['tipcal']=="C"){echo "SELECTED ";}echo">Calendario</option>";
									}
								?>
						</select>
					</td>
					<td class="saludo1" style="width:4cm">:&middot; Requiere Adjunto:</td>
					<td>
						<select name="readjunto" id="readjunto" style="width:100%">
							<option value="S" <?php if(@ $_POST['readjunto']=="S"){echo "SELECTED ";}?>>SI</option>
							<option value="N" <?php if(@ $_POST['readjunto']=="N"){echo "SELECTED ";}?>>NO</option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="saludo1" >:&middot; Tipo PQR:</td>
					<td >
						<select name="tipopqr" id="tipopqr" >
							<option value="N" <?php if(@ $_POST['tipopqr']=="N"){echo "SELECTED ";}?>>N - Ninguno</option>
							<option value="P" <?php if(@ $_POST['tipopqr']=="P"){echo "SELECTED ";}?>>P - Petici&oacute;n</option>
							<option value="Q" <?php if(@ $_POST['tipopqr']=="Q"){echo "SELECTED ";}?>>Q - Queja</option>
							<option value="R" <?php if(@ $_POST['tipopqr']=="R"){echo "SELECTED ";}?>>R - Reclamo</option>
							<option value="S" <?php if(@ $_POST['tipopqr']=="S"){echo "SELECTED ";}?>>S - Sugerencia</option>
							<option value="D" <?php if(@ $_POST['tipopqr']=="D"){echo "SELECTED ";}?>>D - Denuncia</option>
							<option value="F" <?php if(@ $_POST['tipopqr']=="F"){echo "SELECTED ";}?>>F - Felicitaci&oacute;n</option>
						</select>
					</td>
				</tr>
			</table>
			<input type="hidden" id="oculto" name="oculto" value="1">
			<?php
				if (@ $_POST['oculto']== "2")
				{
					$mxa=selconsecutivo('plantiporadicacion','codigo');
					$sqlr = "INSERT INTO plantiporadicacion (codigo,nombre,descripcion,dias,tdias,slectura,adjunto,estado,radotar,clasificacion) VALUES ('$mxa','".$_POST['granombre']."','".$_POST['gradescr']."','".$_POST['gratiempo']."','".$_POST['tipcal']."', '".$_POST['rrespuesta']."','".$_POST['readjunto']."','S','TA', '".$_POST['tipopqr']."')";
					if (!mysqli_query($linkbd,$sqlr)){echo"<script>despliegamodalm('visible','2','Error no se almaceno El Tipo de Tarea');</script>";}
					else {echo"<script>despliegamodalm('visible','1','Se ha almacenado con Exito El Tipo de Tarea');</script>";}
				}
			?>
			<script type="text/javascript">$('#granombre, #gradescr').alphanum({allow: ''});</script>
			<script type="text/javascript">$('#gratiempo').numeric({allowThouSep: false,allowDecSep: false,allowMinus:false});</script>
		</form>
	</body>
</html>