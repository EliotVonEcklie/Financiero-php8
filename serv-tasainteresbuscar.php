<?php
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=iso-8859-1");
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_v7();
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	date_default_timezone_set("America/Bogota");
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=iso-8859-1"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Ideal.10 - Servicios P&uacute;blicos</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css4.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js"></script>
		<script>
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventanam').src="";}
				else
				{
					switch(_tip)
					{
						case "1":	document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
						case "2":	document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
						case "3":	document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
						case "4":	document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;
					}
				}
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("serv");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("serv");?></tr>
			<tr>
				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='serv-tasainteres.php'" class="mgbt"/><img src="imagenes/guardad.png" class="mgbt"/><img src="imagenes/buscad.png" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" onClick="<?php echo paginasnuevas("serv");?>" class="mgbt"></td>
			</tr>
		</table>
		<div id="bgventanamodalm" class="bgventanamodalm">
			<div id="ventanamodalm" class="ventanamodalm">
				<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"></IFRAME>
			</div>
		</div>
		<form name="form2" method="post" action="">
			<?php 
				if(@ $_POST['oculto']=="")
				{
					$_POST['onoffswitch']="S";
					$_POST['codban']=selconsecutivo('srvestratos','id');
					$_POST['vigenciat']=date('Y');
					$_POST['tipodes']='C';
				}
			?>
			<table class="inicio ancho">
				<tr>
					<td class="titulos" colspan="9">.: Ingresar Tasa de Interes</td>
					<td class="cerrar" style="width:7%" onClick="location.href='serv-principal.php'">Cerrar</td>
				</tr>
				<tr>
					<td class="tamano01" style="width:2cm;">Vigencia:</td>
					<td style="width:15%;">
						<select name="vigenciat" id="vigenciat" style="width:100%;" onChange="document.form2.submit();">
							<?php
							$anini=2050;
							for($y=0;$y<100;$y++)
							{
								$anfin=$anini-$y;
								if($anfin==$_POST['vigenciat']){echo "<option value='$anfin' SELECTED>$anfin</option>";}
								else {echo "<option value='$anfin'>$anfin</option>";}
							}
							?>
						</select>
					</td>
					<td class="tamano01" style="width:2cm;">Tipo:</td>
					<td style="width:15%;">
						<select name="tipodes" id="tipodes" style="width:100%;" onChange="document.form2.submit();">
							<option value='C' <?php if($_POST['tipodes']=='C'){echo 'SELECTED';}?> >Intereses Correintes</option>";
							<option value='M' <?php if($_POST['tipodes']=='M'){echo 'SELECTED';}?> >Intereses Moratorios</option>";
						</select>
					</td>
					<td></td>
				</tr>
			</table>
			<div class="subpantalla" style="height:60.5%; width:99.6%; overflow-x:hidden;">
				<table class="inicio" width="99%">
					<tr><td class="titulos" colspan="5">Detalles Tasas de Interes</td></tr>
					<tr class="titulos2">
						<td style="width:10%">id</td>
						<td style="width:15%">vigencia</td>
						<td>Mes</td>
						<td style="width:15%">porcentaje</td>
						<td style="width:10%">Estado</td>
					</tr>
					<?php
						$co="saludo1a";
						$co2="saludo2";
						$sqlr="SELECT id,mes,porcentaje,estado FROM srvtasa_interes WHERE vigencia='".$_POST['vigenciat']."' AND tipo='".$_POST['tipodes']."' ORDER BY mes ASC, id DESC";
						$resp = mysqli_query($linkbd,$sqlr);
						while ($row =mysqli_fetch_row($resp))
						{
							if($row[3]=='N')
							{
								$colorline="sombra01";
								$imgsem="<img src='imagenes/sema_rojoON.jpg' style='height:21px;'>";
							}
							else 
							{
								$colorline=$co;
								$imgsem="<img src='imagenes/sema_verdeON.jpg' style='height:21px;'>";
							}
							$mestexto=mesletras($row[1]);
							echo"
							<tr class='$colorline'>
								<td>$row[0]</td>
								<td>".$_POST['vigenciat']."</td>
								<td>$mestexto</td>
								<td>$row[2]</td>
								<td style='text-align:center;'>$imgsem</td>
							<tr>
							";
							$aux=$co;
							$co=$co2;
							$co2=$aux;
						}
					?>
				</table>
			</div>
			<input type="hidden" name="oculto" id="oculto" value="1"/>
		</form>
		<div id="bgventanamodal2">
			<div id="ventanamodal2">
				<IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"></IFRAME>
			</div>
		</div>
	</body>
</html>