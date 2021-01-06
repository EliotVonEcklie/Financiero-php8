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
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
        <title>::SPID-Planeaci&oacute;n Estrat&eacute;gica</title>
        <link rel="shortcut icon" href="favicon.ico"/>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<script>
			function guardar()
			{
				var validacion01=document.getElementById('granombre').value;
				var validacion02=document.getElementById('gradescr').value;
				if (validacion01.trim()!='' && validacion02.trim()!='')
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
			function funcionmensaje(){document.location.href = "plan-prioridades.php";}
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
    	<table >
			<tr><script>barra_imagenes("plan");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("plan");?></tr> 
    		<tr>
     	 		<td colspan="3" class="cinta"><a href="plan-prioridades.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a><a href="#" onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a><a href="plan-prioridadesbuscar.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a><a href="#" onClick="mypop=window.open('plan-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
   			</tr>
        </table>	
        <div id="bgventanamodalm" class="bgventanamodalm">
   			<div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
        <form name="form2" method="post">
        	<?php if($_POST[oculto]==""){$_POST[gracolorhx]="#000000";$_POST[gracolor]="#000000";}?>
       		<table class="inicio" >
                <tr>
         			<td class="titulos"colspan="11">:: Ingresar Prioridades</td>
                  	<td class="cerrar" style="width:7%;"><a href="plan-principal.php">&nbsp;Cerrar</a></td>
                </tr>
            	<tr>
                	<td class="saludo1" style="width:7%">:&middot; Nombre:</td>
                	<td style="width:20%"><input type="text" name="granombre" id="granombre" style="width:100%" value="<?php echo $_POST[granombre];?>"></td>
                	<td class="saludo1" style="width:6%">:&middot; color:</td>
                	<td style="width:4%"><input type="color" name="gracolor" id="gracolor" style="width:100%" onChange="document.getElementById('gracolorhx').value=document.getElementById('gracolor').value" value="<?php echo $_POST[gracolor];?>"> </td>
                	<td class="saludo1" style="width:9%">:&middot; Descripci&oacute;n:</td>
                	<td><input type="text" name="gradescr" id="gradescr" style="width:90%" value="<?php echo $_POST[gradescr];?>" ></td>
            	</tr>
       		</table>
        	<input type="hidden" name="oculto" id="oculto" value="1">
        	<input type="hidden" name="gracolorhx" id="gracolorhx" value="<?php echo $_POST[gracolorhx];?>" > 
    		<?php
				if ($_POST[oculto]== "2")
				{
					$mxa=selconsecutivodomi('valor_inicial','PRIORIDAD_EVENTOS_AG');
					$sqlr = "INSERT INTO dominios (valor_inicial,valor_final,descripcion_valor,nombre_dominio,tipo,descripcion_dominio) VALUES ('$mxa','$_POST[gracolorhx]','$_POST[granombre]','PRIORIDAD_EVENTOS_AG','S','$_POST[gradescr]')";
					if (!mysql_query($sqlr,$linkbd)){echo"<script>despliegamodalm('visible','2',''Error no se almaceno la Prioridad');</script>";}
					else {echo"<script>despliegamodalm('visible','1','Se ha almacenado la Prioridad con Exito');</script>";}
					
				}
			?>
     	</form>
	</body>
</html>