<?php 
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=iso-8859-1");
	require"comun.inc";
	require"funciones.inc";
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=iso-8859-1"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
	</head>
	<body style="overflow:hidden"></br>
		<table class='inicio' style="width:99%;margin-bottom:10px;">
			<tr style="border-radius: 30px;">
				<td class='titulos' style="text-align:center;"> SELECCIONE EL TIPO DE PRESUPUESTO</td>
				<td class="cerrar" style="width:7%" onClick="parent.tipopresupuesto('hidden');">Cerrar</td>
			</tr>
		</table>
		<table>
			<tr style="height: 15px;"></tr>
			<tr>
				<td style="padding-bottom:0px;text-align: center;"><em class="botonflecha" onClick="parent.presupuesto_normal();">Presupuesto Normal</em></td>
				<td style="padding-bottom:0px"><em class="botonflecha" onClick="parent.presupuesto_ccpet();">Presupuesto CCPET</em></td>
			</tr>
		</table>
	</body>
</html>
