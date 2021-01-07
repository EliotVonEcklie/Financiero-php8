<?php
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=iso-8859-1");
	require "comun.inc";
	require "funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	date_default_timezone_set("America/Bogota"); 
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=iso-8859-1"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9" />
		<title>:: SPID - Contabilidad</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("cont");?></tr>
			<tr>
				<td colspan="3" class="cinta"><img src="imagenes/add2.png" class="mgbt1"/><img src="imagenes/guardad.png" style="width:24px;" class="mgbt1"/><img src="imagenes/buscad.png" class="mgbt1"/><img src="imagenes/nv.png" title="Nueva Ventana"  onClick="<?php echo paginasnuevas("cont");?>" class="mgbt"><img src='imagenes/iratras.png' title='Men&uacute; Nomina' class='mgbt' onClick="location.href='teso-gestionexogena.php'"/></td>
			</tr>
		</table>
		<form name="form2" method="post" action="">
			<table class="inicio">
				<tr>
					<td class="titulos" colspan="2">.: Clasificaci&oacute;n contable</td>
					<td class="cerrar" style="width:7%" onClick="location.href='cont-principal.php'">Cerrar</td>
				</tr>
				<tr>
				<td class='saludo1' width='70%'>
					<ol id="lista2">
						<li onClick="location.href='cont-contexoformatosbuscar.php'" style="cursor:pointer">Formatos</li>
						<li onClick="location.href='cont-contexoconceptosdianbuscar.php'" style="cursor:pointer">Conceptos DIAN</li>
						<li onClick="location.href='cont-codigosint1001buscar.php'" style="cursor:pointer">Columnas 1001-N</li>
						<li onClick="location.href='cont-contexoconceptosbuscar.php'" style="cursor:pointer">Marcar cuentas</li>
						<li onClick="location.href='cont-generareportebuscar.php'" style="cursor:pointer">Generar Reportes</li>
					</ol>
				</td> 
				<td colspan="2" rowspan="1" style="background:url(imagenes/dian.png); background-repeat:no-repeat; background-position:center; background-size: 100% 100%"></td>
				</tr>
			</table>
		</form>
	</body>
</html>