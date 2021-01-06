<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
	$_POST[oculto2]=$_GET[oculto2];
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
        <title>:: Spid - Administracion</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
        <script type="text/javascript" src="css/programas.js"></script>
        <script>
			function crearexcel(){
				
			}
        </script>
		<?php titlepag();?>
        
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("adm");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("adm");?></tr>
        	<tr>
  				<td colspan="3" class="cinta">
					<a href="teso-ingresos.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
					<a class="mgbt"><img src="imagenes/guarda.png"/></a>
					<a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
					<a href="#" class="mgbt" onClick="mypop=window.open('principal.php','',''); mypop.focus();"><img src="imagenes/nv.png" title="Nueva Ventana"></a> 
					<a href="adm-comparacomprobantes-cont.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
				</td>
         	</tr>	
		</table>
 		<form name="form2" method="post" action="">  
			<input type="hidden" name="vig" id="vig" value="<?php echo $_POST[vig] ?>" >
			<input type="hidden" name="url" id="url" value="<?php echo $_POST[url] ?>" >
			<table class="inicio">
				<tr class="titulos">
					<td colspan="10">.: Metodo de Busqueda</td>
				</tr>
				<tr>
					<td style="width:10%;" class="saludo1">Tipo de Busqueda</td>
					<td style="width:10%;">
						<select name="metodo" onchange="document.form2.submit()" style="width:100%;">
							<option value="">Seleccione...</option>
							<option value="1" <?php if($_POST[metodo]==1) echo 'selected="selected"'; ?> ><?php echo utf8_decode("Por Año"); ?></option>
							<option value="2" <?php if($_POST[metodo]==2) echo 'selected="selected"'; ?> >Por Mes</option>
							<option value="3" <?php if($_POST[metodo]==3) echo 'selected="selected"'; ?> >Por Periodo</option>
						</select>
					</td>
					<?php 
						if($_POST[metodo]==1){
							?>
							<td style="width:10%;" class="saludo1"><?php echo utf8_decode("Año"); ?></td>
							<td>
								<input type="text" name="anio" id="anio" value="<?php echo $_POST[anio] ?>" onchange="document.form2.submit()">
							</td>
							<?php
							$_POST[vig]=$_POST[anio];
							$_POST[url]="plotegresos.php?vig=".$_POST[vig];
							
						}
						if($_POST[metodo]==2){
							$_POST[vig]=0;
							?>
							<td style="width:10%;" class="saludo1"><?php echo utf8_decode("Año"); ?></td>
							<td>
								<input type="text" name="anio" id="anio" value="<?php echo $_POST[anio] ?>" onchange="document.form2.submit()">
							</td>
							<td style="width:10%;" class="saludo1">Mes</td>
							<td style="width:10%;">
								<select name="mes" onchange="document.form2.submit()" style="width:100%;">
									<option value="">Seleccione...</option>
									<option value="1" <?php if($_POST[mes]==1) echo 'selected="selected"'; ?> >Enero</option>
									<option value="2" <?php if($_POST[mes]==2) echo 'selected="selected"'; ?> >Febrero</option>
									<option value="3" <?php if($_POST[mes]==3) echo 'selected="selected"'; ?> >Marzo</option>
									<option value="4" <?php if($_POST[mes]==4) echo 'selected="selected"'; ?> >Abril</option>
									<option value="5" <?php if($_POST[mes]==5) echo 'selected="selected"'; ?> >Mayo</option>
									<option value="6" <?php if($_POST[mes]==6) echo 'selected="selected"'; ?> >Junio</option>
									<option value="7" <?php if($_POST[mes]==7) echo 'selected="selected"'; ?> >Julio</option>
									<option value="8" <?php if($_POST[mes]==8) echo 'selected="selected"'; ?> >Agosto</option>
									<option value="9" <?php if($_POST[mes]==9) echo 'selected="selected"'; ?> >Septiembre</option>
									<option value="10" <?php if($_POST[mes]==10) echo 'selected="selected"'; ?> >Octubre</option>
									<option value="11" <?php if($_POST[mes]==11) echo 'selected="selected"'; ?> >Noviembre</option>
									<option value="12" <?php if($_POST[mes]==12) echo 'selected="selected"'; ?> >Diciembre</option>
								</select>
							</td>
							<?php
							$_POST[vig]=$_POST[anio];
							$_POST[url]="plotegresos.php?anio=".$_POST[anio]."&mes=".$_POST[mes];
							//echo $_POST[url];
							
						}
						if($_POST[metodo]==3){
							?>
							<td style="width:10%;" class="saludo1"><?php echo utf8_decode("Año"); ?></td>
							<td>
								<input type="text" name="anio" id="anio" value="<?php echo $_POST[anio] ?>" onchange="document.form2.submit()">
							</td>
							<td style="width:10%;" class="saludo1">Mes Inicial</td>
							<td style="width:10%;">
								<select name="mes0" onchange="document.form2.submit()" style="width:100%;">
									<option value="">Seleccione...</option>
									<option value="1" <?php if($_POST[mes0]==1) echo 'selected="selected"'; ?> >Enero</option>
									<option value="2" <?php if($_POST[mes0]==2) echo 'selected="selected"'; ?> >Febrero</option>
									<option value="3" <?php if($_POST[mes0]==3) echo 'selected="selected"'; ?> >Marzo</option>
									<option value="4" <?php if($_POST[mes0]==4) echo 'selected="selected"'; ?> >Abril</option>
									<option value="5" <?php if($_POST[mes0]==5) echo 'selected="selected"'; ?> >Mayo</option>
									<option value="6" <?php if($_POST[mes0]==6) echo 'selected="selected"'; ?> >Junio</option>
									<option value="7" <?php if($_POST[mes0]==7) echo 'selected="selected"'; ?> >Julio</option>
									<option value="8" <?php if($_POST[mes0]==8) echo 'selected="selected"'; ?> >Agosto</option>
									<option value="9" <?php if($_POST[mes0]==9) echo 'selected="selected"'; ?> >Septiembre</option>
									<option value="10" <?php if($_POST[mes0]==10) echo 'selected="selected"'; ?> >Octubre</option>
									<option value="11" <?php if($_POST[mes0]==11) echo 'selected="selected"'; ?> >Noviembre</option>
									<option value="12" <?php if($_POST[mes0]==12) echo 'selected="selected"'; ?> >Diciembre</option>
								</select>
							</td>
							<td style="width:10%;" class="saludo1">Mes Final</td>
							<td style="width:10%;">
								<select name="mes1" onchange="document.form2.submit()" style="width:100%;">
									<option value="">Seleccione...</option>
									<option value="1" <?php if($_POST[mes1]==1) echo 'selected="selected"'; ?> >Enero</option>
									<option value="2" <?php if($_POST[mes1]==2) echo 'selected="selected"'; ?> >Febrero</option>
									<option value="3" <?php if($_POST[mes1]==3) echo 'selected="selected"'; ?> >Marzo</option>
									<option value="4" <?php if($_POST[mes1]==4) echo 'selected="selected"'; ?> >Abril</option>
									<option value="5" <?php if($_POST[mes1]==5) echo 'selected="selected"'; ?> >Mayo</option>
									<option value="6" <?php if($_POST[mes1]==6) echo 'selected="selected"'; ?> >Junio</option>
									<option value="7" <?php if($_POST[mes1]==7) echo 'selected="selected"'; ?> >Julio</option>
									<option value="8" <?php if($_POST[mes1]==8) echo 'selected="selected"'; ?> >Agosto</option>
									<option value="9" <?php if($_POST[mes1]==9) echo 'selected="selected"'; ?> >Septiembre</option>
									<option value="10" <?php if($_POST[mes1]==10) echo 'selected="selected"'; ?> >Octubre</option>
									<option value="11" <?php if($_POST[mes1]==11) echo 'selected="selected"'; ?> >Noviembre</option>
									<option value="12" <?php if($_POST[mes1]==12) echo 'selected="selected"'; ?> >Diciembre</option>
								</select>
							</td>
							<?php
							$_POST[vig]=$_POST[anio];
							$_POST[url]="plotegresos.php?anio=".$_POST[anio]."&mes0=".$_POST[mes0]."&mes1=".$_POST[mes1];
						}
					?>
					<td style="width:60%;"></td>
				</tr>
			</table>
			<table class="inicio" style="height:70%;">
				<tr class="titulos">
					<td>.: Grafica</td>
				</tr>
				<tr>
					<td style="text-align:center">
						<IFRAME src="<?php echo $_POST[url] ?>" name="grafica" id="grafica" marginWidth=0 marginHeight=0 frameBorder=0  style=" width:70%; height:100%; "> 
						</IFRAME>
					</td>
				</tr>	
			</table>
        </form> 
</body>
</html>