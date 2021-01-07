<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
	@$nombre_archivo = @$_SERVER['REQUEST_URI'];
	if ( strpos(@$nombre_archivo, '/') !== FALSE )
	{@$nombre_archivo = array_pop(explode('/', @$nombre_archivo));}
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
			<div style="overflow-y: scroll; height: 78%">
				<table class="inicio">
					<tr>
						<td class="titulos" colspan="2">.: Reflejar Documentos Contabilidad</td>
						<td class="cerrar" style="width:7%;" ><a href="cont-principal.php">&nbsp;Cerrar</a></td>
					</tr>
					<tr>
						<td class="titulos2" colspan="3">Reflejar Contabilidad</td></tr>
					
					<tr>
					<td class='saludo1' width='70%'>

						<ol id="lista2">
							<table>
								<tr>
									<td>
										<li><a href='cont-recibocaja-reflejar.php'>Recibos de Caja</a></li>
										<li><a href='cont-sinrecibocaja-refleja.php'>Ingresos Internos</a></li>
										<li><a href='cont-pagonominaver-reflejar.php'>Pagar N&oacute;mina</a></li>
										<li><a href='cont-girarcheques-reflejar.php'>Egresos</a></li>
										<li><a href='cont-pagotercerosvigant-reflejar.php'>Otros Egresos</a></li>
										<li><a href='cont-recaudos-reflejar.php'>Otros Recaudos</a></li> 
										<li><a href='cont-egreso-reflejar.php'>Liquidaci&oacute;n Cuentas por Pagar</a></li> 
										<li><a href='cont-exentos-reflejar.php'>Predial Exentos</a></li>
										<li><a href='cont-exoneracion-reflejar.php'>Predial Exoneraciones</a></li>
										<li><a href='cont-prescripcion-reflejar.php'>Prescripci&oacute;n Predial</a></li>
											
									</td>
									<td>
										<li><a href='cont-sinrecaudos-reflejar.php'>Liquidaci&oacute;n Ingresos Internos</a></li>
										<li><a href='cont-liquidarnomina-regrabar.php'>Liquidaci&oacute;n de N&oacute;mina</a></li>
										<li><a href='cont-sinsituacion-reflejar.php'>Ingresos SSF</a></li> 
										<li><a href='cont-sinsituacionegreso-reflejar.php'>Egresos SSF</a></li> 
										<li><a href='cont-industriaver-reflejar.php'>Liquidaci&oacute;n Industria y Comercio</a></li> 
										<li><a href='cont-pagoterceros-reflejar.php'>Pago Recaudo Terceros</a></li>
										<li><a href='cont-recaudotransferencia-reflejar.php'>Recaudo Transferencia</a></li>
										<li><a href='cont-recaudotransferencialiquidar-reflejar.php'>Liquidar Recaudo Transferencia</a></li>
										<li><a href='cont-sinrecaudos-reflejarsp.php'>Liquidaci&oacute;n Ingresos Internos SP</a></li>
										<li><a href='cont-sinrecibocaja-reflejasp.php'>Ingresos Internos SP</a></li>
											
									</td>
									<td>
										<li><a href='cont-reflejaractivo.php'>Contabilizar Activos </a></li>
										<li><a href='cont-salidadirecta-reflejar.php'>Salida directa de almacen </a></li>
										<li><a href='cont-salidareserva-reflejar.php'>Salida por reserva de almacen </a></li>
										<li><a href='cont-entradacompra-reflejar.php'>Otras entradas por compra</a></li>
										<li><a href='cont-abono-reflejar.php'>Abonos de predial </a></li>
										<li><a href='cont-ordenactivacion-reflejar.php'>Orden de Activaci&oacute;n </a></li>
										<li><a href='cont-recaudotransferenciasgr-reflejar.php'>Recaudo transferencia SGR </a></li>
									</td>
								</tr>
							</table>
						</ol>
					</td>  
					<td colspan="2" rowspan="1" style="background:url(imagenes/reflejar.png); background-repeat:no-repeat; background-position:center; background-size: 100% 100%"></td>
					</tr>							
				</table>
			</div>	
		</form>
	</body>
</html>