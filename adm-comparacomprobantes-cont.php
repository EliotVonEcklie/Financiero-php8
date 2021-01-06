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
		<title>:: Spid - Administracion</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<?php titlepag();?>
    </head>
	<style>
	
	</style>
    <body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("adm");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("adm");?></tr>
        	<tr>
          		<td colspan="3" class="cinta">
					<a class="mgbt"><img src="imagenes/add2.png" /></a>
					<a class="mgbt"><img src="imagenes/guardad.png" style="width:24px;"/></a>
					<a class="mgbt"><img src="imagenes/buscad.png"/></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
				</td>
        	</tr>
        </table>
 		<form name="form2" method="post" action="">
    		<table class="inicio">
      			<tr>
        			<td class="titulos" colspan="2">.: Compara Comprobantes </td>
        			<td class="cerrar" style="width:7%;" ><a href="cont-principal.php">&nbsp;Cerrar</a></td>
      			</tr>
					<td width="60%" style="background-repeat:no-repeat; background-position:center;">
						<ol id="lista2">
							<table>
								<tr>
									<td style="width:50%;">
										<li onClick="location.href='cont-reflejarrecibosmasivo.php'" style="cursor:pointer;">Reflejar comprobantes Masivos a contabilidad. </li>
									</td>
								</tr>
							</table>
						</ol>
					</td>	
				</tr>							
    		</table>
		</form>
	</body>
</html>