<?php
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=iso-8859-1");
	require 'comun.inc';
	require 'funciones.inc';
	sesion();
	$linkbd=conectar_v7();
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	date_default_timezone_set("America/Bogota");	
	//error_reporting(E_ALL);
	//ini_set('display_errors', '1');
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Spid - Administraci&oacute;n</title>
		<link rel="shortcut icon" href="favicon.ico"/>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script type="text/javascript" src="css/calendario.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script type="text/javascript" src="jquery-1.11.0.min.js?<?php echo date('d_m_Y_h_i_s');?>"></script> 
		<script type="text/javascript" src="JQuery/jquery-2.1.4.min.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<style>
			input[type='text']{height:30px;}
			input[type='search']{height:30px;}
			select{height:30px;}
		</style>
		<script>
			function mostrarg(_valor){document.getElementById("ventanamensaje1").style.visibility=_valor;}
			function guardar()
			{
				
				if(document.form2.idmodulo.value!='') 
				{ 
					if(document.form2.descripcion.value!='')
					{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
					else
					{despliegamodalm('visible','2','Agregar una descripcion');}
				}
				else {despliegamodalm('visible','2','Seleccionar modulo');}
			}
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
			function funcionmensaje()
			{
				var idayu=document.form2.idayuda.value
				document.location.href = "adm_ayudaseditar.php?doc="+idayu;
			}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.getElementById('oculto').value="2";
								document.form2.submit();break;
				}
			}
		</script>
		<?php
			titlepag();
			function eliminarDir()
			{
				$carpeta="informacion/ayudas/temp";
				foreach(glob($carpeta . "/*") as $archivos_carpeta)
				{
					if (is_dir($archivos_carpeta)){eliminarDir($archivos_carpeta);}
					else{unlink($archivos_carpeta);}
				}
				rmdir($carpeta);
			}
		?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("meci");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("meci");?></tr>
			<tr>
				 <td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='adm-ayudasguardar.php'" class="mgbt"/><img src="imagenes/guarda.png" title="Guardar" onClick="guardar()" class="mgbt"/><img class="mgbt" src="imagenes/busca.png" title="Buscar" onClick="location.href='adm-ayudasbuscar.php'"/><img class="mgbt" src="imagenes/nv.png" title="Nueva Ventana" onClick="mypop=window.open('adm-principal.php','','');mypop.focus();"/></td>
			</tr>
		</table>
		<div id="bgventanamodalm" class="bgventanamodalm">
			<div id="ventanamodalm" class="ventanamodalm">
				<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
				</IFRAME>
			</div>
		</div>
		<form name="form2" method="post" enctype="multipart/form-data" > 
			<?php
				if(@ $_POST['oculto']=="")
				{
					$_POST['idayuda']=selconsecutivo('adm_ayuda','idayuda');
					$rutaad="informacion/ayudas/temp/";
					if(!file_exists($rutaad)){mkdir ($rutaad);}
					else {eliminarDir();mkdir ($rutaad);}
				}
			?>
			<table class="inicio ancho">
				<tr>
					<td class="titulos" colspan="4" >Crear Ayudas</td>
					<td class="cerrar" style="width:7%" onClick="location.href='adm-principal.php'">Cerrar</td>
				</tr>
				<tr>
					<input type='hidden' name='idayuda' id='idayuda' value='<?php echo @ $_POST['idayuda'];?>'/>
					<td class="saludo1" style="width:2cm;" >Modulo:</td>
					<td style="width:30%">
						<select id="idmodulo" name="idmodulo" style="width:95%;text-transform:uppercase;">
							<option value=''>Seleccione....</option>
							<?php	
								$sqlr="SELECT id_modulo,nombre FROM modulos ORDER BY id_modulo ASC";
								$res=mysqli_query($linkbd,$sqlr);
								while ($row = mysqli_fetch_row($res)) 
								{
									if(@ $_POST['idmodulo']==$row[0])
									{
										echo "<option style='text-transform:uppercase;' value='$row[0]' SELECTED>$row[0] - $row[1]</option>";
										$_POST['nomodulo']=$row[1];
									}
									else {echo "<option style='text-transform:uppercase;' value='$row[0]'>$row[0] - $row[1]</option>";}
								}
							?>
						</select>
						<input type='hidden' name='nomodulo' id='nomodulo' value='<?php echo @ $_POST['nomodulo'];?>'/>
					</td>
					<td class="tamano01" style="width:2.5cm;">Descripci&oacute;n:</td>
					<td >
						<input type="text" id="descripcion" name="descripcion" value="<?php echo @ $_POST['descripcion'];?>" style="width:100%"/>
						
					</td>
				</tr>
			</table>
			<table class="inicio ancho" >
				<tr><td class="titulos" colspan="9">Informaci&oacute;n Documento</td></tr> 
				<tr>
					<td class="saludo1">Documentos</td>
					<td><input type="text" name="nomarchdoc" id="nomarchdoc" style="width:100%" value="<?php echo @ $_POST['nomarchdoc'];?>" readonly></td>
					<td>
						<div class='upload'> 
							<a href="#" title="Cargar Documento"><input type="file" name="archivodoc" onChange="document.form2.submit();" />
							<img src='imagenes/upload01.png' style="width:18px"/></a>
						</div> 
					</td>
					<td class="saludo1">Videos</td>
					<td><input type="text" name="nomarchvid" id="nomarchvid" style="width:100%" value="<?php echo @ $_POST['nomarchvid'];?>" readonly></td>
					<td>
						<div class='upload'> 
							<a href="#" title="Cargar Video"><input type="file" name="archivovid" onChange="document.form2.submit();" />
							<img src='imagenes/upload01.png' style="width:18px"/></a>
						</div>
					</td>
				</tr>
			</table>
			<input type="hidden" name="oculto" id="oculto" value="1">
			<?php  
				if(@ $_POST['oculto']=="2")//********guardar
				{
					$_POST['idayuda']=selconsecutivo('adm_ayuda','idayuda');
					$sqlr="INSERT INTO adm_ayuda (idayuda,idmodulo,nomodulo,descripcion,estado) VALUES ('".$_POST['idayuda']."', '".$_POST['idmodulo']."','".$_POST['nomodulo']."','".$_POST['descripcion']."','S')";
					if (!mysqli_query($linkbd,$sqlr))
					{echo "<script>alert('ERROR EN LA CREACION DEL ANEXO');document.form2.nombre.focus();</script>";}
					else
					{
						if($_POST['nomarchdoc']!='')
						{
							$idayudadet=selconsecutivo('adm_ayuda_det','iddet');
							$trozos = explode(".",$_POST['nomarchdoc']);
							$extension = end($trozos);
							$nomar="archivodoc$idayudadet.$extension";
							$dirdoc1="informacion/ayudas/temp/".$_POST['nomarchdoc'];
							$dirdoc2="informacion/ayudas/fijo/$nomar";
							copy($dirdoc1,$dirdoc2);
							$sqlr2="INSERT INTO adm_ayuda_det (iddet,idayuda,tipo,nomarchivo,estado) VALUES ('$idayudadet', '".$_POST['idayuda']."','D','$nomar','S')";
							mysqli_query($linkbd,$sqlr2);
						}
						if($_POST['nomarchvid']!='')
						{
							$idayudadet=selconsecutivo('adm_ayuda_det','iddet');
							$trozos = explode(".",$_POST['nomarchvid']);
							$extension = end($trozos);
							$nomar="archivovid$idayudadet.$extension";
							$dirdoc1="informacion/ayudas/temp/".$_POST['nomarchvid'];
							$dirdoc2="informacion/ayudas/fijo/$nomar";
							copy($dirdoc1,$dirdoc2);
							$sqlr2="INSERT INTO adm_ayuda_det (iddet,idayuda,tipo,nomarchivo,estado) VALUES ('$idayudadet', '".$_POST['idayuda']."','V','$nomar','S')";
							mysqli_query($linkbd,$sqlr2);
						}
						echo"<script>despliegamodalm('visible','1','Se ha almacenado la Gestión de Documentos con Exito');</script>";
					}
				}
				if (is_uploaded_file($_FILES['archivodoc']['tmp_name'])) //archivos
				{
					$rutaad="informacion/ayudas/temp/";
					echo"<script>document.getElementById('nomarchdoc').value='".$_FILES['archivodoc']['name']."';</script>";
					copy($_FILES['archivodoc']['tmp_name'], $rutaad.$_FILES['archivodoc']['name']);
				}
				if (is_uploaded_file($_FILES['archivovid']['tmp_name'])) //archivos
				{
					$rutaad="informacion/ayudas/temp/";
					echo"<script>document.getElementById('nomarchvid').value='".$_FILES['archivovid']['name']."';</script>";
					copy($_FILES['archivovid']['tmp_name'], $rutaad.$_FILES['archivovid']['name']);
				}
 			?>
			<div id="bgventanamodal2">
				<div id="ventanamodal2">
					<IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"></IFRAME>
				</div>
			</div>
		</form>
	</body>
</html>