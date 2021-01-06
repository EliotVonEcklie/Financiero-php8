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
<script>

</script>
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
 <table class="inicio" width="50%">
 <tr>
     <td colspan="2" class="titulos" style="width:90%">DATOS BASICOS FUT</td>
     <td class="cerrar" style="width:10%"><a href="presu-principal.php">Cerrar</a></td>
 </tr>
 <tr>
	<td class='saludo1'>
	<ol id="lista2">
							<li><a href='presu-buscacodfun.php'>C&Oacute;DIGOS DE FUNCIONAMIENTO>></a></li>
							<li><a href='presu-buscacoding.php'>C&Oacute;DIGOS INGRESO >></a></li>
							<li><a href='presu-buscafutdependencias.php'>UNIDADES >></a></li>
							<li><a href='presu-buscafutdeudas.php'>DEUDA >></a></li>
							<li><a href='presu-buscafutfuentefun.php'>FUENTE FUNCIONAMIENTO >></a></li> 
							<li><a href='presu-buscafutfuenteinv.php'>FUENTE DE INVERSION >></a></li> 
							<li><a href='presu-buscafuttipooper.php'>TIPO DE OPERACION >></a></li> 
							<li><a href='presu-buscafutinversion.php'>TIPO DE INVERSION >></a></li> 
							
					</ol>
	</td>
 </tr>

 </table>
 </div>
</td></tr>     
</table>
</body>
</html>