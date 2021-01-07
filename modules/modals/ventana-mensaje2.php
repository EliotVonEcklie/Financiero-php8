<?php 
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=utf8");
	require "comun.inc";
	require"funciones.inc";
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="utf8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="JQuery/jquery-2.1.4.min.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script>
			function continuar()
			{parent.despliegamodalm("hidden");}
			var tecla01 = 13;
			$(document).keydown(function(e){if (e.keyCode == tecla01){continuar();}})
		</script>
	</head>
	<body style="overflow:hidden"></br></br>
		<table id='ventanamensaje1' class='inicio'>
			<tr>
				<td class='saludo1'><center><?php echo $_GET[titulos];?><img src='imagenes\confirm.png'></center></td>
			</tr>
		</table>
		<table>
			<tr>
				<td style="padding: 15px;text-align:center">
					<em name="continuar" id="continuar" class="botonflecha" onclick="continuar()">Continuar</em>
				</td>
			</tr>
		</table>
	</body>
<script>document.getElementById('continuar').focus();</script>
</html>
