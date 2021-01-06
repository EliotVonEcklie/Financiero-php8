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
		<title>:: Spid - Contratacion</title>
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
            <tr><script>barra_imagenes("contra");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("contra");?></tr>
        	<tr>
          		<td colspan="3" class="cinta">
					<a class="mgbt1"><img src="imagenes/add2.png" /></a>
					<a class="mgbt1"><img src="imagenes/guardad.png" style="width:24px;"/></a>
					<a class="mgbt1"><img src="imagenes/buscad.png"/></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a onClick="<?php echo paginasnuevas("contra");?>" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
				</td>
        	</tr>
        </table>
 		<form name="form2" method="post" action="">
    		<table class="inicio">
      			<tr>
        			<td class="titulos" colspan="2">.: Gesti&oacute;n Contractual</td>
                    <td class="cerrar" style="width:7%"><a onClick="location.href='contra-principal.php'">Cerrar</a></td>
      			</tr>
      			
     			
				<tr>
				<td class='saludo1' width='70%'>
				<ol id="lista2">
						<li onClick="location.href='contra-gestioncontratos.php'" style="cursor:pointer">Proceso contractual</li>
						<li onClick="location.href='#'" style="cursor:pointer">Adiciones contractuales</li>
                        <li onClick="location.href='#'" style="cursor:pointer">Liquidacion contractual</li>
						
				</ol>
				
				</tr>							
    		</table>
		</form>
	</body>
</html>