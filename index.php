<?php
	require 'include/comun.php';
	require 'include/funciones.php';

	session_start();
	session_destroy();
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9"/>

		<title>:: FINANCIERO</title>
		
		<link rel="shortcut icon" href="favicon.ico"/>
	</head>
	<body style="background-color:darkseagreen; display: flex; justify-content: center; align-items: center;" >
		<script>
			function recarga()
			{
				var pagina = 'login.php';
				location.href = pagina;
			} 
			setTimeout ('recarga()', 3000);
		</script>
		<div style="align-content: center;">
            <img src="img/ideal_logo_light.png" align="absmiddle" style="width: 100%;">
        </div>
	</body>
</html>
