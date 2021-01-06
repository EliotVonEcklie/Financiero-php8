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
        <!-- ************************************************************************* -->
        <!-- ************Cambiar****************-->
		<title>:: Spid - Activos Fijos</title>
		<!-- ************************************************************************* -->
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
		<link href="css/css3.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
        <script type="text/javascript" src="css/programas.js"></script>

		<?php titlepag();?>

   	</head>

   	<body>
   		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<!-- ************************************************************************* -->
			<!-- ************Cambiar****************-->
	   		<tr><script>barra_imagenes("acti");</script><?php cuadro_titulos();?></tr>
	    	<tr><?php menu_desplegable("acti");?></tr>
	    	<!-- ************************************************************************* -->
    		<tr>
  				<td colspan="3" class="cinta">
	  				<a href="acti-grupos.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a>
	  				<a class="mgbt"><img src="imagenes/guardad.png"/></a>
	  				<a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
	  				<!-- ************************************************************************* -->
	  				<!-- ************Cambiar****************-->
	  				<a href="#" onClick="mypop=window.open('acti-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a>
	  				<!-- ************************************************************************* -->
  				</td>
			</tr>
		</table> 

   	</body>
</html>