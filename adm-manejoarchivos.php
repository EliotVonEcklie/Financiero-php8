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
        <title>::Spid - administraci&oacute;n</title>
        <link rel="shortcut icon" href="favicon.ico"/>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
        <script>
			function cargarfuncion(){document.form2.oculto.value="2";document.form2.submit();}
		</script>
        <?php titlepag();?>
    </head>
	<body>
    	<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
        	<tr><script>barra_imagenes("adm");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("adm");?></tr>
    		<tr class="cinta">
  				<td colspan="3" class="cinta"><a class="mgbt"><img src="imagenes/add2.png"/></a><a class="mgbt"><img src="imagenes/guardad.png"/></a><a class="mgbt"><img src="imagenes/buscad.png"/></a><a href="#" onClick="mypop=window.open('adm-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
         	</tr>  
		</table>
		<form name="form2" method="post" enctype="multipart/form-data" action="">
        	<?php if($_POST[oculto]==""){$_POST[oculto]="1";}?>
            <table class="inicio">
                <tr>
                    <td colspan="4" class="titulos" style='width:93%'>.:Consola SQL:.</td>
                    <td class="cerrar" style='width:7%'><a href="adm-principal.php">Cerrar</a></td>
                </tr>
                <tr>
                	<td style="width:50%;">Archivos</td>
                    <td>Resultado</td>
                </tr>
                <tr>
                    <td class="tamano01" >:&middot; Escudo:</td>
                    <input type="hidden" name="oculto" id="oculto" value="1"/>
                   	<td><input type="file" name="adnimagen1" id="adnimagen1" value="<?php echo $_POST[adnimagen1];?>" title="Cargar Imagen" /> </td>
                    <td><input type="button" name="pri" value="cargar" onClick="cargarfuncion()" /></td>
                    
                </tr>
            </table>
            <?php
				if($_POST[oculto]=="2")
				{
					if (is_uploaded_file($_FILES['adnimagen1']['tmp_name'])) 
					{
						$archivo = $_FILES['adnimagen1']['name'];
						$tipo = $_FILES['adnimagen1']['type'];
						$destino = $archivo;
						if (copy($_FILES['adnimagen1']['tmp_name'],$destino))
						{
							echo"<script>alert('listo');</script>";
						}
						else
						{
							echo"<script>alert('error');</script>";
						} 
					}
				}
			?>
		</form>
    </body>
</html>