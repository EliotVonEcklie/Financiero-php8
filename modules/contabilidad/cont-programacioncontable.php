<?php
	require "comun.inc";
	require "funciones.inc";
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
		<title>:: Contabilidad</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
		<link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
        
		<?php titlepag();?>
    </head>
    <body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("cont");?></tr>
       		<tr>
          		<td colspan="3" class="cinta"><a class="mgbt"><img src="imagenes/add2.png"/></a><a class="mgbt"><img src="imagenes/guardad.png" title="Guardar" /></a><a class="mgbt"><img src="imagenes/buscad.png"/></a><a href="#" class="mgbt" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
       	 	</tr>
        </table>
        <?php

        $sqlr = "SELECT ruta, nombre_ruta FROM opcion_menu WHERE id_opcion='890'";
        $resp = view($sqlr);
        $filas = count($resp);
        ?>
        <form name="form2" method="post" action="">
			<table class="inicio">
      			<tr>
        			<td class="titulos" colspan="2">.: Parametros Contables </td>
        			<td class="cerrar" style="width:7%;" ><a href="presu-principal.php">&nbsp;Cerrar</a></td>
      			</tr>
      			
				<tr>
                    <td>
                        <ol id="lista2">
                            <?php 
                            for($x = 0; $x < $filas; $x++)
                            {
                                echo "<li onclick=\"location.href='".$resp[$x]['ruta']."'\" style='cursor:pointer'>".$resp[$x]['nombre_ruta']."</li>";
                            }
                            ?>
                            <li onclick="location.href='cont-programacion-contable-ccpet.php'" style="cursor:pointer">Programaci&oacute;n Contable CCPET</li>
                        </ol>
                    </td>
				</tr>							
    		</table>
		</form>
    </body>
</html>