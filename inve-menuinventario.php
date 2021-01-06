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
		<title>:: Spid - Almacen</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
        <script type="text/javascript" src="JQuery/jquery-2.1.4.min.js"></script>
		<?php titlepag();?>
    </head>
	<style>
	
	</style>
    <body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("inve");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("inve");?></tr>
        	<tr>
          		<td colspan="3" class="cinta"><a class="mgbt"><img src="imagenes/add2.png" /></a> <a class="mgbt"><img src="imagenes/guardad.png" style="width:24px;"/></a> <a class="mgbt"><img src="imagenes/buscad.png"/></a> <a href="#" onClick="mypop=window.open('inve-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
        	</tr>
        </table>
 		<form name="form2" method="post" action="">
    		<table class="inicio">
      			<tr>
        			<td class="titulos" colspan="2">.: Gesti&oacute;n de inventario </td>
        			<td class="cerrar" style="width:7%;" ><a href="presu-principal.php">&nbsp;Cerrar</a></td>
      			</tr>
					<td style="background-repeat:no-repeat; background-position:center;">
						<ol id="lista2">
							<li onClick="location.href='inve-gestioninventarioentrada.php'" style="cursor:pointer;">Entrada a Inventario</li>
                            <li onClick="location.href='inve-gestioninventariosalida.php'" style="cursor:pointer;">Salida de Inventario</li>
                        </ol>
				</td>                 
				</tr>							
    		</table>
		</form>
	</body>
</html>