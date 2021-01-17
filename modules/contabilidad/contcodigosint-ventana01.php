<?php
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=iso-8859-1");
	require "comun.inc";
	require "funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=iso-8859-1"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9" />
		<title>:: SPID - Contabilidad</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
		<script>
			var anterior;
			function ponprefijo(pref,opc,comc )
			{
				parent.document.form2.cuentap.value =pref;
				parent.document.form2.ncuentap.value =opc ;
				parent.document.form2.nconcepto.value =comc ;
				parent.despliegamodal2("hidden");
			} 
		</script> 
		<?php titlepag();?>
	</head>
	<body>
		<form method="post" name="form2">
			<table class="inicio">
				<tr>
					<td style="height:30px!important;" colspan="3" class="titulos" >Buscar Variables de Pago</td>
					<td style="width:7%;padding-bottom:7px!important;"><label class="boton02" onClick="parent.despliegamodal2('hidden');">Cerrar</label></td>
				</tr>
				<tr><td colspan="4" class="titulos2" >:&middot; Por Descripcion </td></tr>
			</table>
			<div class="subpantalla" style="height:86.5%; width:99.6%; overflow-x:hidden;">
				<?php
					$sqlr="SELECT codigo,nombre,concepto FROM humvariables ORDER BY codigo";
					$resp = mysql_query($sqlr,$linkbd);
					$numero = mysql_num_rows($resp);
					$co='saludo1a';
					$co2='saludo2';
					$i=1;
					echo "
					<table class='inicio'>
						<tr>
							<td colspan='4' class='titulos' >Resultados Busqueda </td>
						</tr>
						<tr><td colspan='5'>Cuentas Encontradas: $numero</td></tr>
						<tr>
							<td width='32' class='titulos2' >Item</td>
							<td width='76' class='titulos2' >C&oacute;digo </td>
							<td width='140' class='titulos2' >Descripci&oacute;n</td>
							<td width='140' class='titulos2' >Concepto</td>
						</tr>";
					while ($r =mysql_fetch_row($resp)) 
					{
						echo"
						<tr class='$co' onClick=\"javascript:ponprefijo('$r[0]','$r[1]','$r[2]')\">
							<td>$i</td>
							<td>$r[0]</td>
							<td>".ucwords(strtolower($r[1]))."</td>
							<td>$r[2]</td>
						</tr>";
						$aux=$co;
						$co=$co2;
						$co2=$aux;
						++$i;
					}
					echo"
						<tr class='$co' onClick=\"javascript:ponprefijo('SR','SALUD EMPLEADOR','07')\">
							<td>$i</td>
							<td>SR</td>
							<td>Salud Empleador</td>
							<td>07</td>
						</tr>";
						$aux=$co;
						$co=$co2;
						$co2=$aux;
						++$i;
					echo"
						<tr class='$co' onClick=\"javascript:ponprefijo('SE','SALUD EMPLEADO','08')\">
							<td>$i</td>
							<td>SE</td>
							<td>Salud Empleado</td>
							<td>08</td>
						</tr>";
						$aux=$co;
						$co=$co2;
						$co2=$aux;
						++$i;
					echo"
						<tr class='$co' onClick=\"javascript:ponprefijo('PR','PENSION EMPLEADOR','09')\">
							<td>$i</td>
							<td>PR</td>
							<td>Pension Empleador</td>
							<td>09</td>
						</tr>";
						$aux=$co;
						$co=$co2;
						$co2=$aux;
						++$i;
					echo"
						<tr class='$co' onClick=\"javascript:ponprefijo('PE','PENSION EMPLEADO','10')\">
							<td>$i</td>
							<td>PE</td>
							<td>Pension Empleado</td>
							<td>10</td>
						</tr>";
						$aux=$co;
						$co=$co2;
						$co2=$aux;
						++$i;
					echo"
					</table>";
				?>
			</div>
		</form>
	</body>
</html>
 