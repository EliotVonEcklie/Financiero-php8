<?php
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=iso-8859-1");
	require 'comun.inc';
	require 'funciones.inc';
	sesion();
	$linkbd=conectar_v7();
	cargarcodigopag($_GET['codpag'],$_SESSION["nivel"]);
	date_default_timezone_set("America/Bogota");
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>::SPID-Planeacion Estrategica</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type='text/javascript' src='JQuery/jquery-2.1.4.min.js'></script>
		<script type='text/javascript' src='funcioneshf.js?<?php echo date('d_m_Y_h_i_s');?>'></script>
		<script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script type="text/javascript" src="css/calendario.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script>
			function despliegaimagen(_estado)
			{
				document.getElementById("imagencm").style.visibility=_estado;
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
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.getElementById('oculto').value="1";
								document.form2.submit();break;
				}
			}
			function funcionmensaje(){document.location.href = "plan-informacionguardar.php";}
			function guardar()
			{
				var validacion01=document.getElementById('gratitulo').value;
				if (validacion01.trim()!='' && document.getElementById('fc_1198971545').value!="" && document.getElementById('fc_1198971546').value!="" &&document.form2.gradescr.value!="Escribe aquí la Información de interés" )
				{
					if(document.getElementById('fc_1198971545').value > document.getElementById('fc_1198971546').value)
					{despliegamodalm('visible','2','La fecha inicial no puede ser mayor que la fecha final');}
					else {despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
				}
				else{despliegamodalm('visible','2','Faltan datos para completar el registro');}
			}
			function borrarinicio()
			{
				if(document.getElementById('gradescr').value=="Escribe aquí la Información de interés")
				document.getElementById('gradescr').value="";
			}
		</script>
		<?php 
			titlepag();
			function eliminarDir()
			{
				$usersave=$_SESSION['cedulausu'];
				$carpeta="informacion/temp/us$usersave";
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
			<tr><script>barra_imagenes("plan");</script><?php cuadro_titulos();?></tr>
			<tr><?php menu_desplegable("plan");?></tr>
			<tr>
				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='plan-informacionguardar.php'"  class="mgbt"/><img src="imagenes/guarda.png"  title="Guardar"  onClick="guardar();" class="mgbt"/><img src="imagenes/busca.png"  title="Buscar" onClick="location.href='plan-informacionbuscar.php'" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" onClick="<?php echo paginasnuevas("plan");?>" class="mgbt"/></td>
			</tr>
		</table>
		<div id="bgventanamodalm" class="bgventanamodalm">
			<div id="ventanamodalm" class="ventanamodalm">
				<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
				</IFRAME>
			</div>
		</div>
		<form  name="form2" method="post" enctype="multipart/form-data" action="#"> 
			<input type="hidden" name="dirimag" id="dirimag" value="<?php echo @ $_POST['dirimag'];?>" onChange="document.form2.submit();"/>
			<img id="imagencm" src="imagenes/nofoto.jpg" style="height:260px; width:260px;  position: fixed; top: 160px; left: 820px; visibility: hidden;"/>
			<?php
				if(@ $_POST['oculto']=="")
				{
					$usersave=$_SESSION['cedulausu'];
					$rutaad="informacion/temp/us$usersave/";
					$_POST['gradescr']="Escribe aquí la Información de interés";
					if(!file_exists($rutaad)){mkdir ($rutaad);}
					else {eliminarDir();mkdir ($rutaad);}
					echo "<script>document.getElementById('dirimag').value='imagenes/nofoto.jpg';</script>";
					$_POST['ttle02']=20;$_POST['ttle01']=30; 
					$_POST['colorf1']=$_POST['colorf2']='#ffffff';
					$_POST['fechaini']=$_POST['fechafin']=date("d/m/Y");
				}
			?>
			<table class="inicio" >
				<tr>
					<td class="titulos" colspan="6" style="width:90%">:: Ingresar Informaci&oacute de Inter&eacute;s</td>
					<td class="cerrar"  onClick="location.href='plan-principal.php'">Cerrar</td>
				</tr>
				<tr>
					<td class="tamano01" style="width:2.5cm">:&middot; Fecha inicio:</td>
					<td style="width:12%"><input type="search" name="fechaini" id="fc_1198971545" class="tamano02" value="<?php echo @ $_POST['fechaini'];?>" title="DD/MM/YYYY" style="width:75%;height:30px;" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onKeyDown="mascara(this,'/',patron,true)"/>&nbsp;<img src="imagenes/calendario04.png" onClick="displayCalendarFor('fc_1198971545');" title="Calendario" class="icobut"/></td>
					<td class="tamano01" style="width:2.5cm">:&middot; Fecha Final:</td>
					<td style="width:35%"><input type="search" name="fechafin" id="fc_1198971546" class="tamano02" value="<?php echo @ $_POST['fechafin'];?>" title="DD/MM/YYYY" style="width:25%;height:30px;" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onKeyDown="mascara(this,'/',patron,true)"/>&nbsp;<img src="imagenes/calendario04.png" onClick="displayCalendarFor('fc_1198971546');" title="Calendario" class="icobut"/></td>
					<td></td>
					<td rowspan="7" colspan="2" style="text-align:center">
						<img id="imagencm" src="imagenes/cartelera03.png" style="height:260px; " >
					</td>
				</tr>
				<tr >
					<td class="tamano01" style="width:2.5cm">:&middot; Titulo:</td>
					<td style="width:55%" colspan="4"><input type="text" name="gratitulo" id="gratitulo" style="width:100%; text-transform:uppercase;" class="tamano02" value="<?php echo @ $_POST['gratitulo'];?>"/></td>
				</tr>
				<tr >
					<td class="tamano01" >:&middot; Formato: </td>
					<td colspan="4">
						<select name="tple01" id="tple01" class="tamano02" style="width:30%;float:left;text-transform:uppercase;">
							<?php
								$sqlr="SELECT * FROM dominios WHERE nombre_dominio='TIPOS_DE_LETRA' ORDER BY length(valor_inicial),valor_inicial ASC";
								$resp = mysqli_query($linkbd,$sqlr);
								while ($row =mysqli_fetch_row($resp))
								{
									if(@ $_POST['tple01']==$row[0])
									{
										echo "<option style='font-family:$row[2];' value='$row[0]' SELECTED>$row[1]</option>";
										$_POST['tletra1']=$row[2];
									}
									else{echo "<option style='font-family:$row[2];' value='$row[0]'>$row[1]</option>";}
								}
							?>
						</select>
						<select name="flle01" id="flle01" class="tamano02" style="width:18%;float:left;margin-left:2px;text-transform:uppercase;">
							<option value="normal" style="font-style:normal;" <?php if(@ $_POST['flle01']=="normal"){echo "SELECTED";}?>>Normal</option>
							<option value="italic" style="font-style:italic;"<?php if(@ $_POST['flle01']=="italic"){echo "SELECTED";}?>>Italica</option>
							<option value="oblique" style="font-style:oblique;"<?php if(@ $_POST['flle01']=="oblique"){echo "SELECTED";}?>>Cursiva</option>
						</select>
						<input type="number" name="ttle01" id="ttle01" value="<?php echo @ $_POST['ttle01'];?>" class="tamano02" min="20" max="50" step="5" style=" width:10%;float:left; margin-left:2px"/>
												
					</td>
				</tr>
				<tr>
					<td class="tamano01" >:&middot; Color Letra: </td>
					<td><input type="color" name="colorl1" id="colorl1" style=" width:100%;float:left; margin-left:2px" value="<?php echo @ $_POST['colorl1'];?>" class="tamano02" title="Color Letra"/></td>
					<td class="tamano01" >:&middot; Color Fondo: </td>
					<td><input type="color" name="colorf1" id="colorf1" style=" width:30%;float:left; margin-left:2px" value="<?php echo @ $_POST['colorf1'];?>" class="tamano02" title="Color Fondo"/></td>
					<td></td>
				</tr>
				<tr>
					<td class="tamano01" style="width:2cm;">:&middot; Adjunto:</td>
					<td colspan="4" >
						<input type="text" name="nomarch" id="nomarch"  style="width:95%" value="<?php echo @ $_POST['nomarch']?>" class="tamano02" readonly/>
						<div class='upload' style="height:24px;float:right !important;">
							<input type="file" name="adjuntom" onChange="document.form2.submit();" title="Cargar Archivo"/>
							<img src='imagenes/upload01.png' style="width:23px"/> 
						</div> 
					</td>
				</tr>
				<tr>
					<td class="tamano01" style="width:2cm;">:&middot; Imagen:</td>
					<td colspan="4">
						<input type="text" name="nimagen" id="nimagen" style="width:95%" value="<?php echo @ $_POST['nimagen']?>" class="tamano02"  readonly/>
						<div class='upload' style="height:24px;float:right !important;">
							<input type="file" name="adnimagen" id="adnimagen" onChange="document.form2.submit();" title="Cargar Imagen" onMouseMove="despliegaimagen('visible');" onMouseOut="despliegaimagen('hidden');" />
							<img src='imagenes/upload01.png' style="width:23px"/>
						</div> 
					</td>
				</tr>
				<tr>
					<td class="tamano01" style="width:9%">:&middot; Descripci&oacute;n:</td>
					<td id="areadetexto" colspan="4" ><textarea id="gradescr" name="gradescr" onClick="borrarinicio();" style="width:100%; height:150px;resize:none;" ><?php echo @ $_POST['gradescr'];?></textarea></td>
				</tr>
				<tr >
					<td class="tamano01" style="width:3.5cm">:&middot; Formato Des.: </td>
					<td colspan="4">
						<select name="tple02" id="tple02" class="tamano02" style="width:30%;float:left;text-transform:uppercase;">
							<?php
								$sqlr="SELECT * from dominios WHERE nombre_dominio='TIPOS_DE_LETRA' ORDER BY length(valor_inicial),valor_inicial ASC";
								$resp = mysqli_query($linkbd,$sqlr);
								while ($row =mysqli_fetch_row($resp))
								{
									if(@ $_POST['tple02']==$row[0])
									{
										echo "<option style='font-family:$row[2];' value='$row[0]' SELECTED>$row[1]</option>";
										$_POST['tletra2']=$row[2];
									}
									else{echo "<option style='font-family:$row[2];' value='$row[0]'>$row[1]</option>";}
								}
							?>
						</select>
						<select name="flle02" id="flle02" class="tamano02" style="width:18%;float:left;margin-left:2px;text-transform:uppercase;">
							<option value="normal" style="font-style:normal;" <?php if(@ $_POST['flle02']=="normal"){echo "SELECTED";}?>>Normal</option>
							<option value="italic" style="font-style:italic;"<?php if(@ $_POST['flle02']=="italic"){echo "SELECTED";}?>>Italica</option>
							<option value="oblique" style="font-style:oblique;"<?php if(@ $_POST['flle02']=="oblique"){echo "SELECTED";}?>>Cursiva</option>
						</select>
						<input type="number" name="ttle02" id="ttle02" value="<?php echo @ $_POST['ttle02'];?>" class="tamano02" min="12" max="40" step="1"  style="width:10%;float:left; margin-left:2px"/>	
					</td>
				</tr>
				<tr>
					<td class="tamano01" >:&middot; Color Letra: </td>
					<td><input type="color" name="colorl2" id="colorl2" style=" width:100%;float:left; margin-left:2px" value="<?php echo @ $_POST['colorl2'];?>" class="tamano02" title="Color letra"/></td>
					<td class="tamano01" >:&middot; Color Fondo: </td>
					<td><input type="color" name="colorf2" id="colorf2" style=" width:30%;float:left; margin-left:2px" value="<?php echo @ $_POST['colorf2'];?>" class="tamano02" title="Color Fondo"/></td>
					<td></td>
				</tr>
			</table>
			<input type="hidden" name="oculto" id="oculto" value="0"/>
			<script>
				//function cargar_imagen
				function preloader() 
				{
					if (document.getElementById) 
					{document.getElementById('imagencm').src=document.getElementById('dirimag').value;

						//document.getElementById('vista_previa').innerHTML= "<img id='imagencm' src='"+document.getElementById('dirimag').value+"' style='height:220px; width:200px' >";
					}
				}
				function addLoadEvent(func) 
				{
					var oldonload = window.onload;
					if (typeof window.onload != 'function') {window.onload = func;} 
					else 
					{
						window.onload = function() 
						{
							if (oldonload) {oldonload();}
							func();
						}
					}
				}
				addLoadEvent(preloader);
			</script>
			<?php
				if (@ is_uploaded_file($_FILES['adjuntom']['tmp_name'])) 
				{
					$archivo = $_FILES['adjuntom']['name'];
					$tipo = $_FILES['adjuntom']['type'];
					$usersave=$_SESSION['cedulausu'];
					$destino = "informacion/temp/us$usersave/".$archivo;
					if (copy($_FILES['adjuntom']['tmp_name'],$destino))
					{
						echo"
						<script>
							document.getElementById('nomarch').value='".$_FILES['adjuntom']['name']."';
							despliegamodalm('visible','3','Archivo Adjunto Cargado Con Éxito');
						</script>";
					}
					else
					{
						echo"<script>document.getElementById('nomarch').value='';
						despliegamodalm('visible','2','Error Al Cargar el Archivo');</script>";
					} 
				}
				if (@ is_uploaded_file($_FILES['adnimagen']['tmp_name'])) 
				{
					$archivo = $_FILES['adnimagen']['name'];
					$tipo = $_FILES['adnimagen']['type'];
					$usersave=$_SESSION['cedulausu'];
					$destino = "informacion/temp/us$usersave/".$archivo;
					if (copy($_FILES['adnimagen']['tmp_name'],$destino))
					{
						echo"
						<script>
							document.getElementById('nimagen').value='".$_FILES['adnimagen']['name']."';
							document.getElementById('dirimag').value='$destino';
							document.getElementById('dirimag').scr='$destino';
							despliegamodalm('visible','3','Imagen Cargada Con Éxito');
						</script>";
					}
					else
					{
						echo"<script>document.getElementById('nimagen').value='';
						despliegamodalm('visible','2','Error Al Cargar el Archivo');</script>";
					} 
				}
				if(@ $_POST['oculto']=="1")
				{
					$codigo=selconsecutivo('infor_interes','indices');
					$usersave=$_SESSION['cedulausu'];
					//almacenar en el servidor archivo
					if(@ $_POST['nomarch']!="")
					{
						$adnombre=$_POST['nomarch'];
						$temarchivo="informacion/temp/us$usersave/$adnombre";
						copy($temarchivo, "informacion/adjuntos/$adnombre");
					}
					//almacenar en el servidor imagen
					if(@ $_POST['nimagen']!="")
					{
						$adnombre=$_POST['nimagen'];
						$temarchivo="informacion/temp/us$usersave/$adnombre";
						copy($temarchivo, "informacion/imagenes/$adnombre");
					}
					//archivar
					$texnombre="archivo$codigo.txt";
					$ar=fopen("informacion/archivos/$texnombre","w") or die("Problemas en la creacion");
					fputs($ar,$_REQUEST['gradescr']);
					fputs($ar,"\n");
					fclose($ar);
					preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $_POST['fechaini'],$fecha);
					$fechai="$fecha[3]-$fecha[2]-$fecha[1]";
					preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $_POST['fechafin'],$fecha);
					$fechaf="$fecha[3]-$fecha[2]-$fecha[1]";
					$titulo=$_POST['gratitulo'];
					$sqlr="INSERT INTO infor_interes VALUES ('$codigo','".$_SESSION['cedulausu']."','$titulo', '".$_POST['nimagen']."',NULL,'$texnombre',NULL,'$fechai','$fechaf', '".$_POST['nomarch']."','S', '".$_POST['tple01']."','".$_POST['flle01']."','".$_POST['ttle01']."', '".$_POST['colorl1']."','".$_POST['colorf1']."','".$_POST['tple02']."','".$_POST['flle02']."', '".$_POST['ttle02']."','".$_POST['colorl2']."','".$_POST['colorf2']."')";
					if (!mysqli_query($linkbd,$sqlr)){echo"<script>despliegamodalm('visible','2','Error no se almaceno');</script>";}
					else {echo"<script>despliegamodalm('visible','1','La información se Guardo con exito');</script>";}
				}
			?>
		</form>
	</body>
</html>