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
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<?php titlepag();?>
    </head>
	<style>
	
	</style>
    <body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("presu");?></tr>
        	<tr>
          		<td colspan="3" class="cinta"><a class="mgbt"><img src="imagenes/add2.png" /></a>
				<a class="mgbt"><img src="imagenes/guardad.png" style="width:24px;"/></a><a class="mgbt"><img src="imagenes/buscad.png"/></a><a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
        	</tr>
        </table>
 		<form name="form2" method="post" action="">
    		<table class="inicio">
      			<tr>
        			<td class="titulos" colspan="2">.: REPORTES FUT</td>
        			<td class="cerrar" style="width:7%;" ><a href="presu-principal.php">&nbsp;Cerrar</a></td>
      			</tr>
      			<tr><td class="titulos2" colspan="3">REPORTES FUT</td></tr>
				<tr >
					<td style="width:35%;background:url(imagenes/imgfut.jpg);background-repeat:no-repeat; background-position:center;">
						<ol id="lista3">
							<li onClick="location.href='presu-reportesfut01.php'" style="cursor:pointer;">CGR PERSONAL Y COSTOS</li>
                            <li onClick="location.href='presu-reportesfut02.php'" style="cursor:pointer;">CGR PRESUPUESTAL</li>
                            <li onClick="location.href='presu-reportesfut03.php'" style="cursor:pointer;">CONPES PRIMERA INFANCIA</li>
                            <li onClick="location.href='presu-reportesfut04.php'" style="cursor:pointer;">DESPLAZADOS 1</li>
                            <li onClick="location.href='presu-reportesfut05.php'" style="cursor:pointer;">DESPLAZADOS 2</li>
                            <li onClick="location.href='presu-reportesfut06.php'" style="cursor:pointer;">FUT CIERRE FISCAL</li>
                            <li onClick="location.href='presu-reportesfut07.php'" style="cursor:pointer;">FUT CUENTAS POR PAGAR</li>
                            <li onClick="location.href='presu-reportesfut08.php'" style="cursor:pointer;">FUT DEUDA PUBLICA</li>
                            <li onClick="location.href='presu-reportesfut09.php'" style="cursor:pointer;">FUT EJECUCIÓN DEL FONDO DE SALUD</a></li>
                            <li onClick="location.href='presu-reportesfut10.php'" style="cursor:pointer;">FUT EXCEDENTES LIQUIDEZ</li>
                            <li onClick="location.href='presu-reportesfut11.php'" style="cursor:pointer;">FUT GASTOS DE INVERSIÓN</li>
                            <li onClick="location.href='presu-reportesfut12.php'" style="cursor:pointer;">FUT GASTOS FUNCIONAMIENTO</li>
                            <li onClick="location.href='presu-reportesfut13.php'" style="cursor:pointer;">FUT INDICADORES DE CALIDAD</li>
                            
						</ol>
				</td>  
                <td style="width:35%;background:url(imagenes/imgfut.jpg);background-repeat:no-repeat; background-position:center;">
                	<ol start="14" id="lista3" style="counter-reset: li 13;" >
                    	<li onClick="location.href='presu-reportesfut14.php'" style="cursor:pointer;">FUT INGRESOS</li>
						<li onClick="location.href='presu-reportesfut15.php'" style="cursor:pointer;">FUT REGISTRO PRESUPUESTAL</li>
                        <li onClick="location.href='presu-reportesfut16.php'" style="cursor:pointer;">FUT RESERVAS</li>
                        <li onClick="location.href='presu-reportesfut17.php'" style="cursor:pointer;">FUT SERVICIO DEUDA</li>
                        <li onClick="location.href='presu-reportesfut18.php'" style="cursor:pointer;">FUT TESORERÍA FONDO DE SALUD</li>
                        <li onClick="location.href='presu-reportesfut19.php'" style="cursor:pointer;">FUT VICTIMAS 1</li>
                        <li onClick="location.href='presu-reportesfut20.php'" style="cursor:pointer;">FUT VIGENCIAS FUTURAS</li>
                        <li onClick="location.href='presu-reportesfut21.php'" style="cursor:pointer;">REGALIAS 1</li>
                        <li onClick="location.href='presu-reportesfut22.php'" style="cursor:pointer;">REGALIAS 2</li>
                        <li onClick="location.href='presu-reportesfut23.php'" style="cursor:pointer;"> CIERRE FISCAL</li>
                        <li onClick="location.href='presu-reportesfut24.php'" style="cursor:pointer;"> GASTOS</li>
                        <li onClick="location.href='presu-reportesfut25.php'" style="cursor:pointer;"> INGRESOS</li>
                        <li onClick="location.href='presu-reportesfut26.php'" style="cursor:pointer;"> TRANSFERENCIAS</li>
                     </ol>
                </td>
                
				</tr>							
    		</table>
		</form>
	</body>
</html>