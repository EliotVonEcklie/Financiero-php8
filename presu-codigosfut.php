<?php //V 1000 12/12/16 ?> 
<!--V 1.0 24/02/2015-->
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
		<?php titlepag();?>
    </head>
    <body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("presu");?></tr>
        	<tr>
          		<td colspan="3" class="cinta">
					<a class="mgbt"><img src="imagenes/add2.png"/></a>
					<a class="mgbt"><img src="imagenes/guardad.png"/></a>
					<a class="mgbt"><img src="imagenes/buscad.png"/></a>
					<a href="#" onClick="mypop=window.open('presu-codigosfut.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
				</td>
        	</tr>
		</table>
<div class="subpantalla" style="height:76.5%; width:99.6%; overflow-x:hidden;">
 <table class="inicio" width="50%">
	<tr>
			 <td colspan="2" class="titulos" style="width:90%">DATOS B&Aacute;SICOS</td>
			 <td class="cerrar" style="width:10%"><a href="presu-principal.php">Cerrar</a></td>
	</tr>
	
	<tr>
				<td class='saludo1'>
					<ol id="lista2">
							<li><a href='presu-inversion.php'>INVERSION</a></li>
							<li><a href='presu-ingresos.php'>INGRESOS</a></li>
							<li><a href='presu-gastosfun.php'>GASTOS DE FUNCIONAMIENTO</a></li>
							<li><a href='presu-reservas.php'>RESERVAS</a></li>
							<li><a href='presu-cuentasporpagar.php'>CUENTAS POR PAGAR</a></li>
							<li><a href='presu-vigenciafutura.php'>VIGENCIAS FUTURAS</a></li>
							<li><a href='presu-fondosalud.php'>FONDO SALUD DE EJECUCION</a></li>
							<li><a href='presu-victima.php'>VICTIMAS</a></li>
							<li><a href='presu-excliq.php'>EXCENTES LIQUIDEZ</a></li>
							<li><a href='presu-tesoreria.php'>TESORERIA FONDO SALUD</a></li>
							<li><a href='presu-fuentesinv.php'>FUENTES INVERSION</a></li>
							<li><a href='presu-fuentesfunc.php'>FUENTES FUNCIONAMIENTO</a></li>
							<li><a href='presu-servdeu.php'>SERVICIO DE DEUDA</a></li>

							
					</ol>
				</td>  
				
				</tr>
 </table>
 </div>
</body>
</html>