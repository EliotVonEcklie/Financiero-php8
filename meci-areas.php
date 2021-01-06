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
		<?php require "head.php";?>
		<title>:: Spid - Meci Calidad</title>
		<script>
			function guardar()
			{
				if (document.getElementById('codigo').value !='' && document.getElementById('nombre').value!='')
 				{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
 				else{despliegamodalm('visible','2','Faltan datos para completar el registro');}
 			}
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
			function funcionmensaje(){document.location.href = "meci-areas.php";}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	
						document.getElementById('oculto').value="2";
						document.form2.submit();break;
				}
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
   			<tr><script>barra_imagenes("meci");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("meci");?></tr>
			<tr>
  				<td colspan="3" class="cinta">
					<a class="tooltip bottom mgbt"><img src="imagenes/add2.png" title="Nuevo"/></a>
					<a onClick="guardar();" class="tooltip bottom mgbt"><img src="imagenes/guarda.png" title=""/><span class="tiptext">Guardar</span></a>
					<a href="meci-buscaareas.php" class="tooltip bottom mgbt"><img src="imagenes/busca.png"  title="" /><span class="tiptext">Buscar</span></a>
					<a class="tooltip bottom mgbt" onClick="mypop=window.open('meci-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" title=""><span class="tiptext">Nueva Ventana</span></a>
					<a onClick="mypop=window.open('<?php echo $url2; ?>','','');mypop.focus();" class="tooltip bottom mgbt"><img src="imagenes/duplicar_pantalla.png"><span class="tiptext">Duplicar pesta&ntilde;a</span></a>
				</td>
         	</tr>
     	</table>	
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>	  
 		<form name="form2" method="post" action="meci-areas.php">
    		<table class="inicio ancho" align="center" >
                <tr>
                    <td class="titulos" colspan="6" width="100%">.: Agregar Areas</td>
                    <td class="boton02" onclick="location.href='meci-principal.php'">Cerrar</td>
                </tr>
                <tr>
                    <td class="saludo1" style="width:2cm;">.: C&oacute;digo:</td>
                    <td style="width:6%;"><input type="text" name="codigo" id="codigo" value="<?php echo $_POST[codigo]?>" maxlength="2" size="2" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"></td>
                    <td class="saludo1" style="width:3cm;">.: Nombre Areas:</td>
                    <td style="width:30%;"><input type="text" name="nombre" id="nombre" value="<?php echo $_POST[nombre]?>"  onKeyUp="return tabular(event,this)" style="width:97%;"></td>
                    <td class="saludo1" style="width:2cm;">.: Activo:</td>
                    <td >
                        <select name="estado" id="estado">
                            <option value="S">SI</option>
                            <option value="N">NO</option>
                        </select>       
                    </td>
                </tr>  
            </table>
    		<input type="hidden" name="oculto" id="oculto" value="1"> 
  			<?php
				if($_POST[oculto]=="2")
				{
 					$sqlr="INSERT INTO admareas (id_cc,nombre,estado)VALUES ('$_POST[codigo]','$_POST[nombre]','$_POST[estado]')";
  					if (!mysql_query($sqlr,$linkbd)){echo"<script>despliegamodalm('visible','2',''Error no se almaceno el ');</script>";}
					else {echo"<script>despliegamodalm('visible','1','El Area se guardo con exito');</script>";}
				}
			?>
		</form>
	</body>
</html>