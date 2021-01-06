<!--V 1000 14/12/16 -->
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
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
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
 				<td colspan="3" class="cinta"><a class="mgbt"><img src="imagenes/add2.png"/></a><a class="mgbt"><img src="imagenes/guardad.png"/></a><a class="mgbt"><img src="imagenes/buscad.png"/></a><a href="#" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a><a href="cont-programacioncontable.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a></td>
			</tr>
     	</table>
		<form name="form2" method="post" action="">
    		<table class="inicio">
     			<tr>
        			<td class="titulos" colspan="1">.: Configuracion Contable </td>
        			<td class="cerrar" style="width:7%;"><a href="inve-principal.php">&nbsp;Cerrar</a></td>
      			</tr>
    			<tr>
					<td>
						<ol id="lista2">
						    <li onClick="location.href='inve-buscaconceconentalmacen.php'" style="cursor:pointer;">Parametros Contables Entradas de Almacen </li>
							<li onClick="location.href='inve-buscaconcecontablesalmacen.php'" style="cursor:pointer;"> Parametros Contables Deterioros NICSP </li>
							<li onClick="location.href='inve-buscaconceconsalalmacen.php'" style="cursor:pointer;">Parametros Contables Ajuste Cobro a Responsable</li>
							<li onClick="location.href='inve-buscaconcecontransito.php'" style="cursor:pointer;">Parametros Contables Articulos en Transitos</li>
							<li onClick="location.href='inve-buscaconcecondonacion.php' " style="cursor:pointer;">Parametros Contables Entrada por Donacion</li>
							<li onClick="location.href='inve-buscaconceconajuste.php'" style="cursor:pointer;">Parametros Contables Entrada por Ajuste</li>
						</ol>
					</td>
				</tr>
    		</table>
		</form>
	</body>
</html>