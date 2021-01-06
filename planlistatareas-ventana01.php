<?php 
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=iso-8859-1");
	require"comun.inc";
	require"funciones.inc";
	sesion();
	$linkbd=conectar_bd();
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: </title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<?php titlepag();?>
	</head>
	<body>
		<form name="form2" method="post">
			<?php
				$_POST[tcodigo]=$_GET[codi];
				$sqlr="SELECT usuariocon,proceso,respuesta,fechares FROM planacresponsables WHERE codigo='".$_GET['codi']."'";
				$resp = mysql_query($sqlr,$linkbd);
				$row =mysql_fetch_row($resp);
				$_POST['nombre']=buscatercero($row[0]);
				$_POST['ractividad']=$row[1];
				$_POST['respuesta']=$row[2];
				$_POST['fechares']=$row[3];
			?>
			<table class="inicio" align="center" >
				<tr>
					<td class="titulos" colspan="3">:: Informaci&oacute;n de Tarea</td>
					<td class="cerrar" style="width:7%" onClick="parent.modaltareas('hidden')">&nbsp;Cerrar</td>
				</tr>	
				<tr>
					<td class="tamano01" style='width:4cm;'>:: Responsable:</td>
					<td><input type="search" name="nombre" id="nombre" value="<?php echo @$_POST['nombre'];?>" style='width:100%;' readonly/></td>
				</tr>
				<tr>
					<td class="tamano01">:: Actividad:</td>
					<td id="areadetexto"><textarea id="actividad" name="ractividad" style="width:100%;height:150px; resize:none;" readonly><?php echo @ $_POST['ractividad'];?></textarea></td>
				</tr>
				<tr>
					<td class="tamano01">:: Respuesta:</td>
					<td id="areadetexto"><textarea id="respuesta" name="respuesta" style="width:100%;height:150px; resize:none;" readonly><?php echo @ $_POST['respuesta'];?></textarea></td>
				</tr>
				<tr>
					<td class="tamano01">Fecha Respuesta:</td>
					<td><input type="date" id="fechares" name="fechares" value="<?php echo @ $_POST['fechares'] ?>" class="tamano02" readonly/>
				</tr>
				<tr>
					<td class="tamano01" style="width:3cm">:&middot;Adjuntos:</td>
					<td>
						<?php
							echo "<select id='archiad' name='archiad' class='elementosmensaje' style='width:85%'  onKeyUp='return tabular(event,this)'  onChange='document.form2.submit();'>
									<option onChange='' value=''  >Seleccione....</option>";
							$sqlr4="SELECT nomarchivo FROM planacarchivosad WHERE idradicacion='$_POST[oculid]' ORDER BY nomarchivo ASC ";
							$res4=mysql_query($sqlr4,$linkbd);
							while ($row4 = mysql_fetch_row($res4)) 
							{
								if("$row4[0]"==$_POST[archiad]){echo "<option value='$row4[0]' SELECTED> - $row4[0] </option>";}
								else {echo "<option value='$row4[0]'> - $row4[0] </option>";}
							}		
							echo "</select>";
							if($_POST[archiad]!="")
							{	
								echo"<a id='arcorig' href='informacion/documentosradicados/$_POST[oculrad]/$_POST[archiad]' download><img src='imagenes/descargar.png' title='Descargar Archivo' ></a>";
							}
							else
							{echo'<a id="arcorig"><img src="imagenes/descargard.png" title="Sin Archivo" ></a>';}
						?>
					</td>
				</tr>
			</table>
			<input type="hidden" name="tcodigo" id="tcodigo" value="<?php echo @$_POST['tcodigo']?>"/>
		</form>
	</body>
</html>
