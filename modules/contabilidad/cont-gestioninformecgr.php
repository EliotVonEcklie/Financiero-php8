<?php //V 1000 12/12/16 ?> 
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
	<style>
	
	</style>
    <body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("cont");?></tr>
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
        			<td class="titulos" colspan="2">.: Informes Contables CGN </td>
        			<td class="cerrar" style="width:7%;" ><a href="cont-principal.php">&nbsp;Cerrar</a></td>
      			</tr>
					<td width="70%" style="background-repeat:no-repeat; background-position:center;">
						<ol id="lista2">
							<li onClick="location.href='cont-importacuentas.php'" style="cursor:pointer;">Importar Cuentas CGN</li>
							<li onClick="location.href='cont-validarcuentaschip.php'" style="cursor:pointer;">Validar Cuentas CGN</li>
							<li onClick="location.href='cont-importarchip.php'" style="cursor:pointer;">Importar Saldos Trimestre Anterior</li>
							<li onClick="location.href='cont-validarsaldos.php'" style="cursor:pointer;">Validar saldos Finales vs Saldos Iniciales</li>
							<li onClick="location.href='cont-razonabilidadsaldo.php'" style="cursor:pointer;">Razonabilidad del Saldo</li>
							<li onClick="location.href='cont-consolidarbalances.php'" style="cursor:pointer;">CGN2005_001_SALDOS_Y_MOVIMIENTOS</li>
							<li onClick="location.href='cont-var_trimestral.php'" style="cursor:pointer;">CGN2016_01_VARIACIONES_TRIMESTRALES_SIGNIFICATIVAS</li>
							<li onClick="location.href='cont-opereciprocas.php'" style="cursor:pointer;">CGN2005_002_OPERACIONES_RECIPROCAS</li>
							<li onClick="location.href='cont-codigoscun.php'" style="cursor:pointer;">Codigo Unico Entidad Reciproca</li>
							<li onClick="location.href='cont-marcarcuentasreciprocas.php'" style="cursor:pointer;">Marcar cuentas entidad reciproca</li>
                        </ol>
					</td>
					<td width="33%" align="center"  >
						<img src="imagenes/contaduria.jpg" >
					</td>
				</tr>							
    		</table>
		</form>
	</body>
</html>