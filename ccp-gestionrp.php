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
	
	<style>
	
	</style>
    <body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("ccplet");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("ccplet");?></tr>
        	<tr>
          		<td colspan="3" class="cinta">
				<a class="mgbt1"><img src="imagenes/add2.png" /></a>
				<a class="mgbt1"><img src="imagenes/guardad.png" style="width:24px;"/></a>
				<a class="mgbt1"><img src="imagenes/buscad.png"/></a>
				<a onClick="<?php echo paginasnuevas("ccplet");?>" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
        	</tr>
        </table>
 		<form name="form2" method="post" action="">
    		<table class="inicio">
      			<tr>
        			<td class="titulos" colspan="2">.: Gesti&oacute;n RP</td>
                    <td class="cerrar" style="width:7%"><a onClick="location.href='ccp-principal.php'">Cerrar</a></td>
      			</tr>
				<tr>
				<td class='saludo1' width='70%'>
				<ol id="lista2">
						<li onClick="location.href='ccp-rpn.php'" style="cursor:pointer">RP N&oacute;mina</li>
						<li onClick="location.href='ccp-rp.php'" style="cursor:pointer">RP B&aacute;sico</li>
                        <li onClick="location.href='ccp-rp.php'" style="cursor:pointer">Contrataci&oacute;n</li>
				</ol>
				
				</tr>							
    		</table>
		</form>
	</body>
</html>