<?php 
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=utf8");
	require"../../include/comun.php";
	require"../../include/funciones.php";
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="utf8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<link href="../../css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css"/>
		<link href="../../css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css"/>
	</head>
	<body style="overflow:hidden"></br></br>
		<table id='ventanamensaje1' class='inicio'>
		<tr>
			<td class='saludo1' style="text-align:center;width:100%"><img src='imagenes\intera.jpg' height="16px;"> <?php echo $_GET['titulos'];?> <img src='imagenes\interc.jpg' height="16px;"></td>
		</tr>
		</table>
		<br>
		<table>
			<tr>
				<td style="text-align:center"><em class="botonflecha" name="aceptar" id="aceptar" onClick='parent.respuestaconsulta("<?php echo $_GET['idresp'];?>");parent.despliegamodalm("hidden");'>Aceptar </em>
				&nbsp;<em class="botonflecha" name="cancelar" id="cancelar" onClick='parent.despliegamodalm("hidden");<?php echo $_GET['recarga'];?>'>Cancelar</em></td>
			</tr>
		</table>
	</body>
</html>
