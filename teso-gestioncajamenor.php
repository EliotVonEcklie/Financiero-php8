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
		<title>:: Spid - Tesoreria</title>
        <link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<?php titlepag();?>
    </head>
    <body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>
            <tr><?php menu_desplegable("teso");?></tr>
        	<tr>
          		<td colspan="3" class="cinta">
					<a><img src="imagenes/add2.png" class="mgbt1"/></a>
					<a><img src="imagenes/guardad.png" class="mgbt1"/></a>
					<a><img src="imagenes/buscad.png" class="mgbt1"/></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a><img src="imagenes/nv.png" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" title="Nueva Ventana" class="mgbt"></a>
				</td>
        	</tr>
        </table>
		<div class="container" style="overflow-y: scroll; height: 82%">
 		<form name="form2" method="post" action="">
    		<table class="inicio">
      			<tr>
        			<td class="titulos" colspan="2">.: Gestion Caja Menor </td>
        			<td class="cerrar" style="width:7%;" ><a href="teso-principal.php">&nbsp;Cerrar</a></td>
      			</tr>
				<tr>
					<td style="background-repeat:no-repeat; background-position:center;">
						<ol id="lista2">
							<li onClick="location.href='teso-acuerdo.php'" style="cursor:pointer;">Acuerdo de apertura caja menor</li>
							<li onClick="location.href='teso-egresocajamenor.php'" style="cursor:pointer;">Egreso Caja Menor </li>
							<li onClick="location.href='teso-contabilizacajamenor.php'" style="cursor:pointer;">Coontabiliza Reintegro Caja Menor </li>
							
						</ol>
				</td>
				</tr>
    		</table>
		</form>
		</div>
	</body>
</html>
