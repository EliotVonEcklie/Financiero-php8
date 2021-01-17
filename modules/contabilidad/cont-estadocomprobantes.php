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
    		<table class="inicio">
      			<tr>
        			<td class="titulos" colspan="2">.: Estado Comprobantes</td>
        			<td class="cerrar" style="width:7%;" ><a href="cont-principal.php">&nbsp;Cerrar</a></td>
      			</tr>
      			<tr>
					<td class="titulos2" colspan="3">Estado Comprobantes</td></tr>
     			
				<tr>
				<td class='saludo1'>

					<ol id="lista2">
						<table>
							<tr>
								<td>
									<li onClick="location.href='cont-compdescuadrados.php'" style="cursor:pointer;">Comprobantes Descuadrados</li>
									<li onClick="location.href='cont-comprobantessincontabilizacion.php'" style="cursor:pointer;">Comprobantes sin Contabilizaci&oacute;n</li>
									<li onClick="location.href='cont-compsincuenta.php'" style="cursor:pointer;">Comprobantes Sin Cuenta Contable</li>
									<li onClick="location.href='cont-compsinutilizar.php'" style="cursor:pointer;">Comprobante Sin Utilizar</li>
									<li onClick="location.href='cont-companulados.php'" style="cursor:pointer;">Comprobante Anulados</li>
									<li onClick="location.href='cont-compincompleto.php'" style="cursor:pointer;">Comprobante Incompleto</li>
									<li onClick="location.href='cont-compcompleto.php'" style="cursor:pointer;">Comprobante Completos</li>
									<li onClick="location.href='cont-razonabilidadsaldofinal.php'" style="cursor:pointer;">Razonabilidad saldos finales</li>
									<li onClick="location.href='cont-cuentasdiferentesvig.php'" style="cursor:pointer;">Cuentas de otra vigencia</li>
								</td>
								<td>
									<li onClick="location.href='cont-comparabancoegreso.php'" style="cursor:pointer;">Comparar Valor Banco - Egreso Neto</li>
									<li onClick="location.href='cont-comparacxp.php'" style="cursor:pointer;">Comparar Valor CXP contabilidad - CXP Tesoreria</li>	
									<li onClick="location.href='cont-comparabancoegresonomina.php'" style="cursor:pointer;">Comparar Valor Banco - Egreso Nomina Neto</li>
									<li onClick="location.href='adm-reciboscaja-cont.php'" style="cursor:pointer;">Comparar Recibo de ingreso - Contabilidad</li>
                                    <li onClick="location.href='cont-reportenom_liquidacion_egresos.php'" style="cursor:pointer;">Comparar Nomina - Egresos </li>
									<li onClick="location.href='cont-comparaegresocxp.php'" style="cursor:pointer;">Comparar cuentas de egreso y cxp en contabilidad </li>
									<li onClick="location.href='cont-comparasalidasalmacencontabilidad.php'" style="cursor:pointer;">Comparar salida por reservas de almacen - contabilidad </li>
									<li onClick="location.href='cont-comparasalidasdirectacontabilidad.php'" style="cursor:pointer;">Comparar salida directa de almacen - contabilidad </li>
									<li onClick="location.href='cont-comparaentradacontabilidad.php'" style="cursor:pointer;">Comparar entrada de almacen - contabilidad </li>
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