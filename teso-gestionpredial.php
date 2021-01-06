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
		<title>:: Spid - Tesoreria</title>
        <link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<?php titlepag();?>
    </head>
    <body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>
            <tr><?php menu_desplegable("teso");?></tr>
        	<tr>
          		<td colspan="3" class="cinta">
					<a><img src="imagenes/add2.png" class="mgbt1"/></a>
					<a><img src="imagenes/guardad.png" class="mgbt1"/></a>
					<a><img src="imagenes/buscad.png" class="mgbt1"/></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a><img src="imagenes/nv.png" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" title="Nueva Ventana" class="mgbt"></a>
				</td>
        	</tr>
        </table>
		<div class="container" style="overflow-y: scroll; height: 82%">
 		<form name="form2" method="post" action="">
    		<table class="inicio">
      			<tr>
        			<td class="titulos" colspan="2">.: Gestion Predial </td>
        			<td class="cerrar" style="width:7%;" ><a href="teso-principal.php">&nbsp;Cerrar</a></td>
      			</tr>
				<tr>
					<td style="background-repeat:no-repeat; background-position:center;">
						<ol id="lista2">
							<li onClick="location.href='teso-causacionpredial.php'" style="cursor:pointer;">Causaci&oacute;n Predial</li>
							<li onClick="location.href='teso-predialactualizar.php'" style="cursor:pointer;">Actualizaci&oacute;n de predios </li>
							<li onClick="location.href='teso-predialhistorico.php'" style="cursor:pointer;">Historial de predio </li>
							<li onClick="location.href='teso-estratificacion.php'" style="cursor:pointer;">Estratificaci&oacute;n</li>
              <li onClick="location.href='teso-importapredial.php'" style="cursor:pointer;">Validaci&oacute;n Predial IGAC</li>
							<li onClick="location.href='teso-prescripciones.php'" style="cursor:pointer;">Prescripci&oacute;n predial</li>
							<li onClick="location.href='teso-exoneracionpredios.php'" style="cursor:pointer;">Exento y Exoneraci&oacute;n predial</li>
							<li onClick="location.href='teso-predialcrear.php'" style="cursor:pointer;">Crear predios </li>
							<li onClick="location.href='teso-autorizapredial.php'" style="cursor:pointer;">Autorizaci&oacute;n Liquidar Predial </li>
							<li onClick="location.href='teso-reportecobropredial_masivo.php'" style="cursor:pointer;">Cobro predial masivo </li>
              <li onClick="location.href='teso-preliquidacionmax.php'" style="cursor:pointer;">Preliquidaci&oacute;n masiva</li>
							<li onClick="location.href='teso-actualizaravaluos.php'" style="cursor:pointer;">Crear avaluos</li>
							<li onClick="location.href='teso-reporteestratificacion.php'" style="cursor:pointer;">Reporte de estratificacion</li>
							<li onClick="location.href='teso-prefacturacion.php'" style="cursor:pointer;">Proceso Prefacturacion</li>
						</ol>
				</td>
				</tr>
    		</table>
		</form>
		</div>
	</body>
</html>
