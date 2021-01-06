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
    	<title>:: Spid - Meci Calidad</title>
    	<script>
			function guardar()
			{
				var validacion01=document.getElementById('nombre').value;
				if (validacion01.trim()!='' && document.getElementById('codigo').value!='')
			  		{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
			  	else {despliegamodalm('visible','2','Faltan datos para completar el registro');}
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
			function funcionmensaje(){document.location.href = "meci-tipoliticas.php";}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.form2.oculto.value="2";document.form2.submit();break;
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
					<a onclick="location.href='meci-tipoliticas.php'" class="tooltip bottom mgbt"><img src="imagenes/add.png" title=""/><span class="tiptext">Nuevo</span></a>
					<a onClick="guardar()" class="tooltip bottom mgbt"><img src="imagenes/guarda.png"  title="" /><span class="tiptext">Guardar</span></a>
					<a onclick="location.href='meci-tipoliticasbusca.php'" class="tooltip bottom mgbt"><img src="imagenes/busca.png"  title=""/><span class="tiptext">Buscar</span></a>
					<a onClick="mypop=window.open('meci-principal.php','','');mypop.focus();" class="tooltip bottom mgbt"><img src="imagenes/nv.png" title="a"><span class="tiptext">Nueva ventan</span></a>
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
			<?php if($_POST[oculto]==""){$_POST[codigo]=selconsecutivodomi('valor_inicial','TIPOS_DE_POLITICAS');}?>
   			<table class="inicio ancho" >
				<tr>
       				<td class="titulos" colspan="6" width='100%'>Crear Tipo de Política</td>
         			<td class="boton02" onclick="location.href='meci-principal.php'">Cerrar</td>
				</tr>
   				<tr>
        			<td class="saludo1" style="width:2cm">C&oacute;digo:</td>
                    <td style="width:4%;"><input type="text" class="centrartext" name="codigo" id="codigo" value="<?php echo $_POST[codigo]?>" style="width:100%;" readonly /></td>
            		<td class="saludo1" style="width:2cm">Nombre:</td>
            		<td style="width:35%"><input type="text" name="nombre" id="nombre" value="<?php echo $_POST[nombre]?>" onKeyUp="return tabular(event,this)" style="width:100%"/></td>
   					<td class="saludo1" style="width:2cm">Estado</td>
            		<td> 
            			<select name="estado" id="estado" onKeyUp="return tabular(event,this)" >
          					<option value="S" <?php if($_POST[estado]=='S') echo "SELECTED"; ?>>Activo</option>
          					<option value="N" <?php if($_POST[estado]=='N') echo "SELECTED"; ?>>Inactivo</option>
        				</select>
        			</td>
   				</tr>
			</table>
    		<input type="hidden" name="oculto" id="oculto" value="1"/>
			<?php  
 				if($_POST[oculto]=="2")//********guardar
				{	
					$mxa=selconsecutivodomi('valor_inicial','TIPOS_DE_POLITICAS');
					$sqlr="INSERT INTO dominios (valor_inicial,descripcion_valor,tipo,nombre_dominio) VALUES ('$mxa','$_POST[nombre]', '$_POST[estado]','TIPOS_DE_POLITICAS')";	
					if (!mysql_query($sqlr,$linkbd))
					{echo"<script>despliegamodalm('visible','2',''Error no se almaceno el Tipo de Política');</script>";}
					else {echo"<script>despliegamodalm('visible','1','Se ha almacenado el Tipo de Política con Exito');</script>";}
				}
 			?>
 		</form>       
	</body>
</html>