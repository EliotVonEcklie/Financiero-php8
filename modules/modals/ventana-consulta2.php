<?php //V 1000 12/12/16 ?> 
<?php

	require '../../include/comun.php';
    require '../../include/funciones.php';
    
    header("Content-Type: text/html;charset=iso-8859-1");
    
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">

    <meta http-equiv="cache-control" content="no-cache"> <!-- tells browser not to cache -->    
    <meta http-equiv="expires" content="0"> <!-- says that the cache expires 'now' -->
    <meta http-equiv="pragma" content="no-cache"> <!-- says not to use cached stuff, if there is any -->

	<head>
        <meta http-equiv="Content-type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>

        <link rel="shortcut icon" href="favicon.ico"/>

        <link href="../../css/css2.css" rel="stylesheet" type="text/css"/>
        <link href="../../css/css3.css" rel="stylesheet" type="text/css"/>
        <link href="../../css/css4.css" rel="stylesheet" type="text/css"/>	
        <link href="../../css/tabs.css" rel="stylesheet" type="text/css"/>

        <script type="text/javascript" src="../../js/programas.js"></script>
        <script type="text/javascript" src="../../js/funciones.js"></script>
        <script type='text/javascript' src='../../js/funcioneshf.js'></script>
        <script type="text/javascript" src="../../js/calendario.js"></script>
        <script type="text/javascript" src="../../js/JQuery/jquery-1.11.0.min.js"></script> 
        <script type="text/javascript" src="../../js/JQuery/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="../../js/JQuery/autoNumeric-master/autoNumeric-min.js"></script>

        <?php titlepag();?>
	</head>

	<body style="overflow:hidden"></br></br>
  		<table id='ventanamensaje1' class='inicio'>
  			<tr>
    			<td class='saludo1' style="text-align:center; width:100%;"><img src='imagenes\intera.jpg' height="16px;"> <?php echo $_GET['titulos'];?> <img src='imagenes\interc.jpg' height="16px;"></td>
    		</tr>
  		</table>
  		<table>
  			<tr>
				<td style="text-align:center;">
				    <br>
					<em name="aceptar" id="aceptar" class="botonflecha" onClick="parent.respuestaconsulta('S','<?php echo $_GET['idresp'];?>');parent.despliegamodalm('hidden');">Aceptar</em>
					<em name="cancelar" id="cancelar" class="botonflecha" onClick="parent.respuestaconsulta('N','<?php echo $_GET['idresp'];?>'); parent.despliegamodalm('hidden');">Cancelar</em>
                </td>
    		</tr>
  		</table>
	</body>
</html>
