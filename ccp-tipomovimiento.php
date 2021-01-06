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
    	<title>:: Spid - Presupuesto</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
    	<link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
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
			function funcionmensaje(){document.location.href = "ccp-tipomovimiento.php";}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	
					document.form2.oculto.value="2";
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
			<tr><script>barra_imagenes("ccpet");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("ccpet");?></tr>
        	<tr>
  				<td colspan="3" class="cinta"><a href="ccp-tipomovimiento.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a><a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png"  title="Guardar" /></a><a href="ccp-tipomovdocumentosbuscar.php" class="mgbt"><img src="imagenes/busca.png"  title="Buscar"/></a><a href="#" onClick="mypop=window.open('ccp-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a></td>
			</tr>
		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
		<form name="form2" method="post"> 
			<?php if($_POST[oculto]==""){
				$sqlr="SELECT MAX(id) FROM tipo_movdocumentos;";
				$resp = mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($resp)){
					$mx=$row[0];
					}
				$mx=$mx+1;
				$_POST[codigo]=$mx;
				
				}?>
   			<table class="inicio" >
				<tr>
       				<td class="titulos" colspan="6">Crear Tipo de Movimiento</td>
         			<td class="cerrar" style="width:7%;"><a href="ccp-principal.php">&nbsp;Cerrar</a></td>
				</tr>
   				<tr>
        			<td class="saludo1" style="width:2cm">C&oacute;digo:</td>
                    <td style="width:4%;"><input type="text" name="codigo" id="codigo" value="<?php echo $_POST[codigo]?>" style="width:100%;" readonly /></td>
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
					
					$sqlr="INSERT INTO tipo_movdocumentos (codigo,descripcion,estado) VALUES ('$_POST[codigo]','$_POST[nombre]', '$_POST[estado]')";	
					if (!mysql_query($sqlr,$linkbd))
					{echo"<script>despliegamodalm('visible','2',''Error no se almaceno el Tipo de Movimiento');</script>";}
					else {echo"<script>despliegamodalm('visible','1','Se ha almacenado el Tipo de Movimiento con Exito');</script>";}
				}
 			?>
 		</form>       
	</body>
</html>