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
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<?php titlepag();?>
    </head>
	<style>
	
	</style>
    <body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("teso");?></tr>
        	<tr>
          		<td colspan="3" class="cinta">
					<a class="mgbt"><img src="imagenes/add2.png" /></a> 
					<a class="mgbt"><img src="imagenes/guardad.png" style="width:24px;"/></a> 
					<a class="mgbt"><img src="imagenes/buscad.png"/></a> 
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
				</td>
        	</tr>
        </table>
 		<form name="form2" method="post" action="">
			<div style="overflow-y: scroll; height: 78%">
				<table class="inicio">
					<tr>
						<td class="titulos" colspan="2">.: Gesti&oacute;n Predial </td>
						<td class="cerrar" style="width:7%;" ><a href="teso-principal.php">&nbsp;Cerrar</a></td>
					</tr>
						<td style="background-repeat:no-repeat; background-position:center;" class="saludo1">
							<ol id="lista2">
								<li onClick="location.href='teso-saldobancos.php'" style="cursor:pointer;">Saldos bancos</li>
								<li onClick="location.href='teso-reporingresos.php'" style="cursor:pointer;">Comprobante de ingresos</li>
								<li onClick="location.href='teso-reporegresos.php'" style="cursor:pointer;">Comprobante de egresos</li>
								<li onClick="location.href='ayuda.html'" style="cursor:pointer;">Reporte cheques </li>
								<li onClick="location.href='teso-reporegresosnomina.php'" style="cursor:pointer;">Egreso n&oacute;mina</li>
								<li onClick="location.href='teso-estadocuenta.php'" style="cursor:pointer;">Estado cuenta</li>
								<li onClick="location.href='teso-reporcontribuyente.php'" style="cursor:pointer;">Reporte pago terceros</li>
								<li onClick="location.href='teso-reportenotasbancarias.php'" style="cursor:pointer;">Reporte Notas Bancarias</li>
								<li onClick="location.href='teso-reportecodigoingreso.php'" style="cursor:pointer;">Reporte de Codigos Ingresos</li>
								<li onClick="location.href='teso-reporteliquidacionpredial.php'" style="cursor:pointer;">Reporte liquidacion predial</li>
								<li onClick="location.href='teso-reporteliquidacionpredial1.php'" style="cursor:pointer;">Reporte liquidacion predial 1.0 </li>
								<li onClick="location.href='teso-reportecxp.php'" style="cursor:pointer;">Reporte Cuentas Por Pagar</li>
								<li onClick="location.href='teso-reporteidentificados.php'" style="cursor:pointer;">Reporte de recaudos por clasificacion</li>
								<li onClick="location.href='teso-reportebancos.php'" style="cursor:pointer;">Reporte de recaudo por Bancos</li>
							</ol>
						</td> 
						
					</tr>							
				</table>
			</div>
		</form>
	</body>
</html>