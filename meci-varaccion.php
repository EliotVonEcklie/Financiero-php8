<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<?php require "head.php"; ?>
		<title>:: Spid - Calidad</title>
		<script>
			function guardar()
			{
				var validacion01=document.getElementById('codigo').value;
				var validacion02=document.getElementById('nombre').value;
				if (validacion01.trim()!='' && validacion02.trim()!='')
			  		{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
			  	else
				{
			  		despliegamodalm('visible','2','Faltan datos para completar el registro');
					document.form2.nombre.focus();document.form2.nombre.select();
			  	}
			 }
			function agregardetalle()
			{
				validacion01=document.getElementById('nombredet').value
				validacion02=document.getElementById('iddet').value
				if(validacion01.trim()!='' && validacion02.trim()!=''){document.form2.agregadet.value="1";document.form2.submit();}
			 	else {despliegamodalm('visible','2','Falta informaci�n para poder Agregar Detalle de Modalidad');}
			}
			function eliminar(variable)
			{
				document.getElementById('elimina').value=variable;
				despliegamodalm('visible','4','Esta Seguro de Eliminar el Detalle de Modalidad','2');
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
			function funcionmensaje(){document.location.href = "meci-editavaraccion.php?idproceso="+document.getElementById('codigo').value;}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.form2.oculto.value="2";document.form2.submit();break;
					case "2":	document.form2.oculto.value="3";document.form2.submit();break;
				}
			}
		</script>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("meci");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("meci");?></tr>
			<tr>
  				<td colspan="3" class="cinta">
					<a onclick="location.href='meci-varaccion.php'" class="tooltip bottom mgbt"><img src="imagenes/add.png"/><span class="tiptext">Nuevo</span></a>
					<a onClick="guardar()" class="tooltip bottom mgbt"><img src="imagenes/guarda.png" /><span class="tiptext">Guardar</span></a>
					<a onclick="location.href='meci-buscavaraccion.php'" class="tooltip bottom mgbt"><img src="imagenes/busca.png" /><span class="tiptext">Buscar</span></a>
					<a onClick="mypop=window.open('meci-principal.php','','');mypop.focus();" class="tooltip bottom mgbt"><img src="imagenes/nv.png"><span class="tiptext">Nueva Ventana</span></a>
					<a onClick="mypop=window.open('<?php echo $url2; ?>','','');mypop.focus();" class="tooltip bottom mgbt"><img src="imagenes/duplicar_pantalla.png"><span class="tiptext">Duplicar pestaña</span></a>
				</td>
			</tr>
	 	</table>
		<div id="bgventanamodalm" class="bgventanamodalm">
			<div id="ventanamodalm" class="ventanamodalm">
				<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
				</IFRAME>
			</div>
		</div>
 		<form name="form2" method="post"> 
 			<?php if($_POST[oculto]==""){$_POST[codigo]=selconsecutivo('calvaraccion','id');}?>
   			<table class="inicio ancho" >
				<tr>
					<td class="titulos" colspan="6" width='100%'>Crear Variable Plan Acción</td>
					<td class="boton02" onclick="location.href='meci-principal.php'">Cerrar</td>
				</tr>
				<tr>
					<td class="saludo1" style="width:1.5cm">Código:</td>
					<td style="width:7%;"><input type="text" name="codigo" id="codigo" value="<?php echo $_POST[codigo]?>" style="width:60%"/></td>
					<td class="saludo1" style="width:1.5cm">Nombre:</td>
					<td style="width:35%;"><input type="text" name="nombre" id="nombre" value="<?php echo $_POST[nombre]?>" style="width:90%;"/></td>
					<td class="saludo1" style="width:1.5cm">Estado:</td>
					<td> 
						<select name="estado" id="estado" onKeyUp="return tabular(event,this)" >
							<option value="S" <?php if($_POST[estado]=='S') echo "SELECTED"; ?>>Activo</option>
							<option value="N" <?php if($_POST[estado]=='N') echo "SELECTED"; ?>>Inactivo</option>
						</select>
					</td>
				</tr>
			</table>
			<table class="inicio ancho" >
				<tr><td class="titulos" colspan="6">Agregar Detalles Variable Plan Acción</td></tr>
				<tr>
					<td class="saludo1" style="width:1.5cm">Id:</td>
					<td style="width:7%;"><input type="text" name="iddet" id="iddet" value="<?php echo $_POST[iddet];?>" style="width:60%"></td>
					<td class="saludo1" style="width:1.5cm">Nombre:</td>
					<td style="width:35%;"><input type="text" name="nombredet" id="nombredet" value="<?php echo $_POST[nombredet];?>" style="width:90%;"></td>
					<td class="saludo1" style="width:4.6cm">Archivo Adjunto Obligatorio:</td>
					<td>
						<select name="adjuntodet" id="adjuntodet" onKeyUp="return tabular(event,this)" >
							<option value="N" <?php if($_POST[adjuntodet]=='N') echo "SELECTED"; ?>>NO</option>
							<option value="S" <?php if($_POST[adjuntodet]=='S') echo "SELECTED"; ?>>SI</option>
						</select>&nbsp; 
						<em class="botonflecha" name="agregar" id="agregar" onClick="agregardetalle()" >Agregar</em>
				 	</td>
				</tr>
			</table>    
			<input type="hidden" name="oculto" id="oculto" value="1"/> 
			<input type="hidden" name="agregadet" id="agregadet" value="0"/>
			<input type="hidden" name="contdet" id="contdet" value="<?php echo $_POST[contdet];?>"> 
			<input type='hidden' name='elimina' id='elimina' value="<?php echo $_POST[elimina];?>"> 
			<div class="subpantalla" style="height:59.5%; width:99.6%; overflow-x:hidden;">
				<table class="inicio" >
					<tr><td class="titulos" colspan="4">Detalle Variables Plan de Acción</td> </tr>
					<tr class="centrartext">
						<td class="titulos2">No</td>
						<td class="titulos2">Nombre Variable</td>
						<td class="titulos2">Archivo Adjunto Obligatorio</td>
						<td class="titulos2">Eliminar</td>
					</tr>    
					<?php 
						if ($_POST[oculto]=='3')
						{ 
							$posi=$_POST[elimina];
							unset($_POST[dids][$posi]);
							unset($_POST[dnvars][$posi]);
							unset($_POST[dadjs][$posi]);		 		 		 		 		 
							$_POST[dids]= array_values($_POST[dids]); 
							$_POST[dnvars]= array_values($_POST[dnvars]); 
							$_POST[dadjs]= array_values($_POST[dadjs]); 
							$_POST[elimina]='';	 		 		 		 
						}	 
						if ($_POST[agregadet]=='1')
						{
							$_POST[dids][]=$_POST[iddet];
							$_POST[dnvars][]=$_POST[nombredet];
							$_POST[dadjs][]=$_POST[adjuntodet]; 		 
							echo"
							<script>
								document.getElementById('agregadet').value='0';
								document.form2.iddet.value='';
								document.form2.nombredet.value='';
								document.form2.iddet.focus';
							</script>";
						}
						$iter='saludo1a';
						$iter2='saludo2';
						for ($x=0;$x<count($_POST[dnvars]);$x++)
						{		 
							echo "
							<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor; this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\">
								<td style='width:5%;'><input class='inpnovisibles centrartext' name='dids[]' value='".$_POST[dids][$x]."' type='text' style='width:100%;text-transform:uppercase' readonly></td>
								<td><input class='inpnovisibles' name='dnvars[]' value='".$_POST[dnvars][$x]."' type='text' style='width:100%;text-transform:uppercase' readonly></td>
								<td style='width:14%;'><input class='inpnovisibles centrartext' name='dadjs[]' value='".$_POST[dadjs][$x]."' type='text' style='width:100%;text-transform:uppercase' readonly></td>
								<td class='centrartext' style='width:5%;'><a href='#' onclick='eliminar($x)'><img src='imagenes/del.png'></a></td>
							</tr>";
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux;
						}
					?>
				</table>  
		  	</div>    
			<?php  
				if($_POST[oculto]=="2")
				{
					$mxa=selconsecutivo('calvaraccion','id');
					$sqlr="insert into calvaraccion (id,nombre,estado) values ('$mxa','$_POST[nombre]','$_POST[estado]')";	
					if (!mysql_query($sqlr,$linkbd))
					{echo"<script>despliegamodalm('visible','2','ERROR EN LA CREACION DE LA VARIABLE DEL PLAN DE ACCION');document.form2.nombre.focus();</script>";}
					else
					{
						for ($x=0;$x<count($_POST[dnvars]);$x++)
						{
							$sqlr="insert into calvaraccion_det (id_varaccion, nombre,id_det, adjunto,estado) values ($mxa, '".$_POST[dnvars][$x]."','".$_POST[dids][$x]."','".$_POST[dadjs][$x]."','S') ";	
							mysql_query($sqlr,$linkbd);
						}
						echo"
						<script>
							document.getElementById('codigo').value=$mxa;
							despliegamodalm('visible','1','Se han almacenado la Variable del Plan de Acci�n con Exito');
						</script>";
					}
				}	
			?>
 		</form>       
	</body>
</html>