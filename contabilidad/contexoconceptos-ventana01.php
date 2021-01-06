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
			function ponprefijo(pref,opc)
			{
				parent.document.form2.cuentap.value =pref;
				parent.document.form2.ncuentap.value =opc ;
				parent.despliegamodal2("hidden");
			} 
		</script> 
		<?php titlepag();?>
	</head>
	<body>
		<form method="post" name="form2">
			<table class="inicio">
				<tr>
					<td style="height:30px!important;" colspan="3" class="titulos" >Buscar Cuentas</td>
					<td style="width:7%;padding-bottom:7px!important;"><label class="boton02" onClick="parent.despliegamodal2('hidden');">Cerrar</label></td>
				</tr>
				<tr><td colspan="4" class="titulos2" >:&middot; Por Descripcion </td></tr>
				<tr>
					<td class="saludo1" style="width:4cm;">C&oacute;digo o Nombre:</td>
					<td>
						<input type="search" name="nombre" id="nombre" value="<?php echo @ $_POST['nombre'];?>" style="width:60%;"/>
						<input type="button" name="bboton" onClick="document.form2.submit();" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;" />
					</td>
				</tr>
			</table>
			<div class="subpantalla" style="height:81.5%; width:99.6%; overflow-x:hidden;">
				<?php
					if ($_POST['nombre']!=""){$cond="WHERE concat_ws(' ',tabla.cuenta,tabla.nombre) LIKE '%".$_POST['nombre']."%'";}
					else {$cond="";}
					$sqlr="SELECT * FROM (SELECT cn1.cuenta,cn1.nombre,cn1.naturaleza,cn1.centrocosto,cn1.tercero,cn1.tipo,cn1.estado FROM cuentasnicsp AS cn1 INNER JOIN cuentasnicsp AS cn2 ON cn2.tipo='Auxiliar'  AND cn2.cuenta LIKE CONCAT( cn1.cuenta,  '%' ) WHERE cn1.tipo='Mayor' GROUP BY cn1.cuenta UNION SELECT cuenta,nombre,naturaleza,centrocosto,tercero,tipo,estado FROM cuentasnicsp WHERE tipo='Auxiliar') AS tabla $cond ORDER BY 1";
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
							<td width='76' class='titulos2' >Cuenta </td>
							<td width='140' class='titulos2' >Descripci&oacute;n</td>
							<td width='140' class='titulos2' >Tipo</td>
						</tr>";
					while ($r =mysql_fetch_row($resp)) 
					{
						if($r[5]=='Auxiliar'){echo "<tr class='$co' onClick=\"javascript:ponprefijo('$r[0]','$r[1]')\">";}
						else {echo "<tr class='$co'>";}
						echo"
							<td>$i</td>
							<td>$r[0]</td>
							<td>$r[1]</td>
							<td>$r[5]</td>
						</tr>";
						$aux=$co;
						$co=$co2;
						$co2=$aux;
						++$i;
					}
					echo"
					</table>";
				?>
			</div>
		</form>
	</body>
</html>
 