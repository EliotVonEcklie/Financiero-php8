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
		<title>:: Spid - Presupuesto</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<?php titlepag();?>
    </head>
    <body>
    <?php
    $linkbd=conectar_bd();
    	$query="SELECT conta_pago FROM tesoparametros";
		$resultado=mysql_query($query,$linkbd);
		$arreglo=mysql_fetch_row($resultado);
		$opcion=$arreglo[0];
    ?>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("presu");?></tr>
        	<tr>
          		<td colspan="3" class="cinta">
					<a class="mgbt"><img src="imagenes/add2.png" /></a>
					<a class="mgbt"><img src="imagenes/guardad.png" style="width:24px;"/></a>
					<a class="mgbt"><img src="imagenes/buscad.png"/></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
				</td>
        	</tr>
        </table>
 		<form name="form2" method="post" action="">
			<table class="inicio">
      			<tr>
        			<td class="titulos" colspan="2">.: Reflejar Documentos Presupuesto </td>
        			<td class="cerrar" style="width:7%;" ><a href="presu-principal.php">&nbsp;Cerrar</a></td>
      			</tr>
      			<tr>
					<td class="titulos2" colspan="3">Reflejar Presupuesto</td></tr>
     			<tr>
				<td class='saludo1' width='70%'>
					<ol id="lista2">
						<table>
							<tr>
								<td style="width:50%;">
									
									<li><a href='presu-recibocaja-reflejarppto.php'>Recibos de Caja	</a></li>
									<li><a href='presu-sinrecibocaja-reflejar.php'>Ingresos Internos</a></li>
									
									<li><a href='presu-notasbancarias-reflejar.php'>Notas bancarias</a></li> 
									<li><a href='presu-sinsituacion-reflejar.php'>Ingresos SSF</a></li>
									<li><a href='presu-sinsituacionegreso-reflejar.php'>Egresos SSF</a></li>
									<li><a href='presu-recaudotransferencia-reflejar.php'>Recaudos transferencias</a></li> 
									<li><a href='presu-recaudotransferencia-reflejar.php'>Egresos de Nomina</a></li> 
									<li><a <?php if($opcion=="1"){ echo "href='presu-egreso-reflejar.php' "; }else{ echo "href='presu-girarcheques-reflejar.php' "; } ?>  >Retenciones</a></li> 
									<li><a href='presu-sinrecibocajasp-reflejar.php'>Ingresos SP</a></li>  
								</td>
							
							</tr>
						</table>
					</ol>
				</td>  <td colspan="2" rowspan="1" style="background:url(imagenes/reflejar.png); background-repeat:no-repeat; background-position:center; background-size: 100% 100%"></td>
				</tr>							
    		</table>
		</form>
	</body>
</html>