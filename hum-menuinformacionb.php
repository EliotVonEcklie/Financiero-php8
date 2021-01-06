<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	header("Content-Type: text/html;charset=iso-8859-1");
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-type" content="text/html; charset=iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Spid - Gesti&oacute;n Humana</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<?php titlepag();?>
    </head>
    <body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("hum");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("hum");?></tr>
        	<tr>
          		<td colspan="3" class="cinta"><img src="imagenes/add2.png" class="mgbt1"/><img src="imagenes/guardad.png" style="width:24px;" class="mgbt1"/><img src="imagenes/buscad.png" class="mgbt1"/><img src="imagenes/nv.png" title="Nueva Ventana" onClick="<?php echo paginasnuevas("hum");?>" class="mgbt"></td>
        	</tr>
        </table>
 		<form name="form2" method="post" action="">
        	<?php
				$accion="INGRESO MENU DE NOMINA";
        		$origen=getUserIpAddr();
        		generaLogs($_SESSION["nickusu"],'HUM','V',$accion,$origen);
			?>
    		<table class="inicio">
      			<tr>
        			<td class="titulos" colspan="2">.: Men&uacute; Tramites Nomina</td>
                    <td class="cerrar" style="width:7%"><a onClick="location.href='hum-principal.php'">Cerrar</a></td>
      			</tr>
                <tr>
                    <td class="titulos2">&nbsp;Informaci&oacute;n General Nomina</td>
                </tr>
				<tr>
                    
                        <ol id="lista2">
                        	<li class='icoom' onClick="location.href='hum-buscaterceros.php'">Terceros</li>
                            <li class='icoom' onClick="location.href='hum-bancosbuscar.php'">Bancos</li>
                            <li class='icoom' onClick="location.href='hum-nivelesarlbuscar.php'">Tarifas ARL</li>
               				<li class='icoom' onClick="location.href='hum-funcionariosbuscar.php'">Funcionarios</li>
                            <li class='icoom' onClick="location.href='hum-funcionarios.php">Salarios</li>
                        </ol>
                    <td>
				</tr>							
    		</table>
		</form>
	</body>
</html>