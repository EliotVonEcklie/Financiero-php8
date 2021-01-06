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
		<title>:: Spid - Contabilidad</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		
		<?php titlepag();?>
	</head>
	<body >
        <form name="form2">
            <table>
                <tr><script>barra_imagenes("");</script><?php cuadro_titulos();?></tr>	 
            </table>
            
        </form>
    	<div class="subpantallap" style="height:75%; width:99.6%; overflow:hidden; background:url(imagenes/enconstuccion.gif); background-repeat:no-repeat; background-position:center;" >
        	<input type="button" value="  Salir  " onClick="location.href='../spid.php'"/>
        </div>
       
	</body>
</html>