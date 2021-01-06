<?php //V 1000 12/12/16 ?> 
<!--V 1.0 24/02/2015-->
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
		<title>:: Meci - Calidad</title>
        <script>
			function guardar()
			{
				var validacion01=document.getElementById('granombre').value;
				if (validacion01.trim()!='' && document.getElementById('nombrepadre').value!='')
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
			function funcionmensaje(){document.location.href = "adm-dependenciasbuscar.php";}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.form2.oculto.value='2';document.form2.submit();break;
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
					<a onclick="location.href='adm-dependenciasguardar.php'" class="tooltip bottom mgbt"><img src="imagenes/add.png" /><span class="tiptext">Nuevo</span></a>
					<a onClick="guardar()" class="tooltip bottom mgbt"><img src="imagenes/guarda.png"/><span class="tiptext">Guardar</span></a>
					<a onclick="location.href='adm-dependenciasbuscar.php'" class="tooltip bottom mgbt"><img src="imagenes/busca.png" /><span class="tiptext">Buscar</span></a>
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
		<form name="form2" method="post" action="" >
            <table class="inicio ancho">
                <tr>
                  <td class="titulos"colspan="4" width="100%">:: Ingresar Dependencia</td>
                  <td class="boton02" onclick="location.href='meci-principal.php'">Cerrar</td>
                </tr>
                <tr>
                   
                    <td class="saludo1" style="width:10%">:&middot; Dependencia:</td>
                    <td style="width:20%" ><input name="granombre" type="text" id="granombre" style="width:100%" value="<?php echo $_POST[granombre]?>"></td>
                    <td class="saludo1" style="width:10%">:&middot; Pertenece a:</td>
                    <td>
                    	<select id="nombrepadre" name="nombrepadre" class="Listahorasmen">
                        <option value="">Seleccione....</option>
                        <option value=0>&#8226; Ninguno</option>
                     		<?php
								$sqlr="SELECT * FROM planacareas WHERE estado='S'";
								$res=mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($res)) 
				    			{
					 				if($row[0]==$_POST[nombrepadre])
			 						{echo "<option value='$row[0]' SELECTED> &#8226; $row[1]</option>";}
					  				else{echo "<option value='$row[0]'> &#8226; $row[1]</option>";}
								}	
              				?> 
                    	</select>
                    </td>
                </tr>
            </table>
            <input type="hidden" id="oculto" name="oculto" value="1">
           	<?php
				if ($_POST[oculto]=="2")
				{	
					$mxa=selconsecutivo('planacareas','codarea');
					$sqlr = "INSERT INTO planacareas (codarea,nombrearea,codpadrearea,estado) VALUES (NULL,'$_POST[granombre]','$_POST[nombrepadre]','S')";
					if (!mysql_query($sqlr,$linkbd)){echo"<script>despliegamodalm('visible','2',''Error no se almaceno el ');</script>";}
					else {echo"<script>despliegamodalm('visible','1','La Dependencia se Guardo con exito');</script>";}
				}
			?>
        </form>
	</body>
</html>