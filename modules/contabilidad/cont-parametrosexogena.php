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
		<title>Spid - Contabilidad</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
    		<tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
    		<tr><?php menu_desplegable("cont");?></tr>
			<tr>
  				<td colspan="3" class="cinta">
					<a class="mgbt"><img src="imagenes/add2.png"/></a>
					<a class="mgbt"><img src="imagenes/guardad.png"/></a>
					<a class="mgbt"><img src="imagenes/buscad.png"/></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva ventana"></a>
				</td>
          	</tr>
      	</table>
        <form name="form2" method="post" action="">
            <table class="inicio" align="center" width="80%" >
                <tr>
                    <td class="titulos" colspan="2">.: Par&aacute;metros Exogena </td>
                    <td style="width:7%" class="cerrar" ><a href="cont-principal.php">Cerrar</a></td>
                </tr>
                <tr>
					<td class='saludo1' width='70%'>
						<ol id="lista2">
							<li onClick="location.href='cont-conceptosexogena.php'" style="cursor:pointer;">Conceptos Ex&oacute;gena</li>
							<li onClick="location.href='cont-formatosexogena.php'" style="cursor:pointer;">Formatos Ex&oacute;gena</li>
						</ol>
					</td>
					<td colspan="2" rowspan="1" style="background:url(imagenes/dian.png); background-repeat:no-repeat; background-position:center; background-size: 100% 100%"></td>
				</tr>	
				
            </table>
        </form>
	</body>
</html>