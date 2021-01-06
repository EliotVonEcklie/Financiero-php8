<?php //V 1000 12/12/16 ?> 
<?php 
	require "comun.inc";
	require"funciones.inc";
	header("Cache-control: private"); // Arregla IE 6
	header("Content-Type: text/html;charset=iso-8859-1");
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<?php require "head.php";?>
	</head>
	<body style="overflow:hidden"></br></br>
  		<table id='ventanamensaje1' class='inicio'>
  			<tr>
    			<td class='saludo1' style="text-align:center;width:100%"><img src='imagenes\intera.jpg' height="16px;"> <?php echo $_GET[titulos];?> <img src='imagenes\interc.jpg' height="16px;"></td>
    		</tr>
  		</table>
  		<table>
  			<tr>
				<td style="text-align:center">
				<br>
					<em  name="aceptar" id="aceptar" class="botonflecha" onClick=" parent.respuestaconsulta('S','<?php echo $_GET[idresp];?>');parent.despliegamodalm('hidden');" >Aceptar</em>
					<em name="cancelar" id="cancelar" class="botonflecha" onClick='parent.respuestaconsulta("N","<?php echo $_GET[idresp];?>");parent.despliegamodalm("hidden");' >Cancelar</em>
				</td>
    		</tr>
  		</table>
	</body>
</html>
