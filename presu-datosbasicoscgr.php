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
		<title>:: SPID - Presupuesto</title>
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
         		<td colspan="3" class="cinta"><a class="mgbt"><img src="imagenes/add2.png"/></a><a class="mgbt"><img src="imagenes/guardad.png"/></a><a class="mgbt"><img src="imagenes/buscad.png"/></a><a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a><a href="presu-datosbasicos.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a></td>
        	</tr>
		</table>
<div class="subpantalla" style="height:76.5%; width:99.6%; overflow-x:hidden;">
 <table class="inicio">
 <tr>
 <td colspan="2" class="titulos" style="width:93%">DATOS B&Aacute;SICOS CGR</td><td class="cerrar" style="width:7%"><a href="presu-principal.php">Cerrar</a></td></tr>

				<td class='saludo1' >
					<ol id="lista2">
					<table>
						<tr>
							<td style="40%;">
								<li><a href='presu-buscarecursos.php'>CREAR RECURSOS >></a></li>
								<li><a href='presu-buscaclasificacion.php'>CLASIFICACI&Oacute;N C.G.R. >></a></li>
								<li><a href='presu-buscarecurcgs.php'>RECURSOS C.G.R. >></a></li>
								<li><a href='presu-buscaorigen.php'> ORIGEN C.G.R. >></a></li>
								<li><a href='presu-buscadestinacion.php'>DESTINACI&Oacute;N C.G.R. >></a></li> 
							</td>
							<td style="40%;">
								<li><a href='presu-buscatercgs.php'>TERCEROS C.G.R. >></a></li> 
								<li><a href='presu-buscaviggasto.php'>VIGENCIA GASTO C.G.R. >></a></li> 
								<li><a href='presu-buscaviggastofin.php'>FINALIDAD GASTO C.G.R. >></a></li> 
								<li><a href='presu-buscadependencia.php'>DEPENDENCIA C.G.R. >></a></li> 
								<li><a href='presu-buscafondos.php'>SITUACI&Oacute;N FONDOS C.G.R. >></a></li>
							</td>
						</tr>							
					</table>
					</ol>
				</td>  
				
 
 </table>
 </div>
</body>
</html>