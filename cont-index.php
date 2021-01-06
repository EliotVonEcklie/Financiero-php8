<?php //V 1000 12/12/16 ?> 
<?php
	require "comun.inc";  
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
	session_destroy();
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
	<title>:: FINANCIERO</title>
	<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
	<?php titlepag();?>
	</head>
<body>
	<img src="imagenes/fondo.png" >
	<div class="inicio" style="width:33%">
	<div>
		<img src="imagenes/inicio.png">
	</div>
	<form name="form1" method="post" action="cont-principal.php">
		<div>.:. Usuario:</div><div> <input type="text" name="user"  /></div>
		<div>.:. Contraseña:</div><div> <input type="password" name="pass"  /></div>
		<div><br><input type="submit" name="aceptar" value=" Entrar >"/></div>
	</form>
	</div>
	<div class="inicio">Desarrollado por: SOCIEDAD</div>
</body>
</html>
