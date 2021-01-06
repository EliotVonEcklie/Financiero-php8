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
				<a class="mgbt"><img src="imagenes/add2.png" /></a>
				<a class="mgbt"><img src="imagenes/guardad.png" style="width:24px;"/></a>
				<a class="mgbt"><img src="imagenes/buscad.png"/></a>
				<a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
        	</tr>
        </table>
 		<form name="form2" method="post" action="">
			<table class="inicio">
      			<tr>
        			<td class="titulos" colspan="2">.: Plan de Cuentas </td>
        			<td class="cerrar" style="width:7%;" ><a href="presu-principal.php">&nbsp;Cerrar</a></td>
      			</tr>
      			<tr>
					<td class="titulos2" colspan="3">.:.:.</td></tr>
     			<tr>
				<td class='saludo1' width='70%'>
					<ol id="lista2">
						<table>
							<tr>
								<td style="width:50%;">
									
									<li><a href='presu-cuentasactiva.php'>Plan de Cuentas de Ingresos</a></li>
									<li><a href='presu-cuentaspasiva.php'>Plan de Cuentas de Gastos</a></li>
								</td>
							
							</tr>
						</table>
					</ol>
				</td>  <td colspan="2" rowspan="1" style="background:url(imagenes/reflejar.png); background-repeat:no-repeat; background-position:center; background-size: 100% 100%"></td>
				</tr>							
    		</table>
		</form>
	</body>
</html>