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
		<meta http-equiv="Content-type" content="text/html; charset=iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Spid</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
		<script>
			function continuar(){parent.funcionmensaje();parent.despliegamodalm("hidden");}
			setTimeout("continuar()",5000);
			var tecla01 = 13;
			$(document).keydown(function(e){if (e.keyCode == tecla01){continuar();}})
		</script>
	</head>
	<body style="overflow:hidden"></br></br>
		<table id='ventanamensaje1' class='inicio' >
  			<tr>
    			<td class='saludo1' style="text-align:center;width:100%"><?php echo $_GET[titulos];?><img src='imagenes\confirm.png'></td>
				</tr>
 		</table>
		<table>
  			<tr>
    			<td style="text-align:center"><input type="button" name="continuar" id="continuar" value="   Continuar   " onClick="continuar()" ></td>
    		</tr>
  		</table>
	</body>
    <script>document.getElementById('continuar').focus();</script>
</html>