<?php
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=iso-8859-1");
	require 'comun.inc';
	require 'funciones.inc';
	$linkbd=conectar_v7();
	date_default_timezone_set("America/Bogota");
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: SieS</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css4.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script>
			function fagregar(idserv,nomserv)
			{
				if(document.getElementById('tidserv').value!='' && document.getElementById('tidserv').value != null)
				{
					var tidserv = document.getElementById('tidserv').value;
					parent.document.getElementById(''+tidserv).value = idserv;
				}
				if(document.getElementById('tnomserv').value!='' && document.getElementById('tnomserv').value != null)
				{
					var tnomserv=document.getElementById('tnomserv').value;
					parent.document.getElementById(''+tnomserv).value=nomserv
				}
				parent.despliegamodal2("hidden");
			}
		</script> 
		<?php titlepag();?>
	</head>
	<body>
		<form name="form2" method="post">
			<?php
				if(@ $_POST['oculto']=="")
				{
					$_POST['tidserv']=@ $_GET['idserv'];
					$_POST['tnomserv']=@ $_GET['nomserv'];
				}
			?>
			<table class="inicio ancho" style="width:99.5%">
				<tr>
					<td class="titulos" colspan="3">:: Buscar Servicios</td>
					<td class="cerrar" style="width:7%" onClick="parent.despliegamodal2('hidden');">Cerrar</td>
				</tr>
				<tr>
					<td class="tamano01" style='width:3cm;'>:: Nombre:</td>
					<td ><input type="search" name="nombre" id="nombre" value="<?php echo @$_POST['nombre'];?>" style='width:100%;'/></td>
					<td style="padding-bottom:0px;height:35px;"><em class="botonflecha" onClick="document.form2.submit();">Buscar</em></td>
				</tr>
			</table>
			<input type="hidden" name="oculto" id="oculto" value="1"/>
			<input type="hidden" name="tidserv" id="tidserv" value="<?php echo @$_POST['tidserv']?>"/>
			<input type="hidden" name="tnomserv" id="tnomserv" value="<?php echo @$_POST['tnomserv']?>"/>
			<div class="subpantalla" style="height:82%; width:99.2%; overflow-x:hidden;">
				<?php 
					if (@$_POST['nombre']!="")
					{$crit1="WHERE nombre LIKE '%".$_POST['nombre']."%'";}
					else {$crit1="";}
					$sqlr="
					SELECT id, nombre FROM srvservicios $crit1 ORDER BY id";
					$resp = mysqli_query($linkbd,$sqlr);
					$con=mysqli_num_rows($resp);
					echo "
					<table class='inicio' align='center' width='99%'>
						<tr><td colspan='2' class='titulos'>.: Resultados Busqueda:</td></tr>
						<tr><td colspan='2'>Servicios Encontrados: $con</td></tr>
						<tr class='titulos2' >
							<td width='2%'>ID</td>
							<td '>SERVICIO</td>
						</tr>";	
					$iter='saludo1a';
					$iter2='saludo2';
					$conta=1;
					while ($row =mysqli_fetch_row($resp))
					{
						echo "
						<tr class='$iter' onClick=\"javascript:fagregar('$row[0]','$row[1]')\">
							<td>$row[0]</td>
							<td>$row[1]</td>
						</tr>
						";
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
						$conta++;
					}
					echo"</table>";
				?>
			</div>
		</form>
	</body>
</html>
