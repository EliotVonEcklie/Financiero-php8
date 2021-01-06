<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	header("Content-Type: text/html;charset=iso-8859-1");
	date_default_timezone_set("America/Bogota"); 
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<?php require "head.php"; ?>
		<?php titlepag();?>
    </head>
    <body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("inve");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("inve");?></tr>
        	<tr>
          		<td colspan="3" class="cinta">
					<a class="tooltip bottom mgbt"><img src="imagenes/add2.png" /></a>
					<a class="tooltip bottom mgbt"><img src="imagenes/guardad.png" /></a>
					<a class="tooltip bottom mgbt"><img src="imagenes/buscad.png" /></a>
					<a class="tooltip bottom mgbt"><img src="imagenes/nv.png" title="Nueva Ventana" onClick="<?php echo paginasnuevas("inve");?>" ></a>
					<a onClick="mypop=window.open('<?php echo $url2; ?>','','');mypop.focus();" class="tooltip bottom mgbt"><img src="imagenes/duplicar_pantalla.png"><span class="tiptext">Duplicar pestaña</span></a>
				</td>
        	</tr>
        </table>
 		<form name="form2" method="post" action="">
        	<?php
				$accion="INGRESO MENU DE ACTOS";
        		$origen=getUserIpAddr();
        		generaLogs($_SESSION["nickusu"],'INV','V',$accion,$origen);
			?>
    		<table class="inicio ancho">
      			<tr>
        			<td class="titulos" width='100%'>.: Men&uacute; Actos de Inventario</td>
                    <td class="boton02" onClick="location.href='inve-principal.php'">Cerrar</td>
      			</tr>
				<tr>
                    <td class='saludo1' colspan="2" width='100%'>
             			<ol id="lista2">
                            <li class='icoom' onClick="location.href='inve-ajusteentrada.php'">Acto Administrativo General</li>
                        </ol>
                    </td>
				</tr>							
    		</table>
		</form>
	</body>
</html>