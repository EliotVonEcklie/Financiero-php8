<?php //V 1001 19/12/16 HAFR?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	$linkbd=conectar_bd();
	session_start();
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
        <title>::SPID-Planeacion Estrategica</title>
        <link rel="shortcut icon" href="favicon.ico"/>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type='text/javascript' src='JQuery/jquery-2.1.4.min.js'></script>
        <script type='text/javascript' src='funcioneshf.js'></script>
        <script type="text/javascript" src="css/programas.js"></script>
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
				if (validacion01.trim()!='' && document.getElementById('fechaini').value!="" && document.getElementById('fechafin').value!="" &&document.form2.gradescr.value!="Escribe aquí la Información de interés" )
				{
					if(document.getElementById('fechaini').value > document.getElementById('fechafin').value)
					{despliegamodalm('visible','2','La fecha inicial no puede ser mayor que la fecha final');}
					else {despliegamodalm('visible','4','Esta Seguro de Modificar la Información','1');}
				}
				else{despliegamodalm('visible','2','Faltan datos para completar el registro');}
			}
 			function borrarinicio()
			{
				if(document.getElementById('gradescr').value=="Escribe aquí la Información de interés")
				document.getElementById('gradescr').value="";
			}
		</script>
		<script>
			function iratras(){
				var codigo = <?php echo $_GET[codigo] ?>;
				location.href="plan-informacionbuscar.php?codigo="+codigo;
			}
		</script>
        <?php 
			titlepag();
			function eliminarDir()
			{
				$usersave=$_SESSION[cedulausu];
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
  				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='plan-informacionguardar.php'"  class="mgbt"/><img src="imagenes/guarda.png"  title="Guardar" onClick="guardar();" class="mgbt"/><img src="imagenes/busca.png"  title="Buscar" onClick="location.href='plan-informacionbuscar.php'" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" onClick="<?php echo paginasnuevas("plan");?>" class="mgbt"/><img src="imagenes/iratras.png" title="Atr&aacute;s" onClick="iratras()" class="mgbt"/></td>
			</tr>
		</table>
         <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
        <form  name="form2" method="post" enctype="multipart/form-data" action="#"> 
        	<?php
				if($_POST[oculto]=="")
				{
					$_POST[codigo]=$_GET[codigo];
					$usersave=$_SESSION[cedulausu];
					$rutaad="informacion/temp/us$usersave/";
					if(!file_exists($rutaad)){mkdir ($rutaad);}
					else {eliminarDir();mkdir ($rutaad);}
					$sqlr="SELECT * FROM infor_interes WHERE indices='$_POST[codigo]'"; 
                    $res=mysql_query($sqlr,$linkbd);
					while($row=mysql_fetch_row($res))
                    {
						$_POST[gratitulo]=$row[2];
						$_POST[fechaini]=$row[7];
						$_POST[fechafin]=$row[8];
						if($row[3]!=""){$_POST[dirimag]="informacion/imagenes/$row[3]";}
						else{$_POST[dirimag]="imagenes/nofoto.jpg";}
						$_POST[nomarch]=$row[9];
						$_POST[noarin]=$row[9];
						$_POST[arcini]="1";
						$_POST[nimagen]=$row[3];
						$_POST[noimin]=$row[3];
						$_POST[imaini]="1";
						$_POST[tple01]=$row[11];
						$_POST[flle01]=$row[12];
						$_POST[ttle01]=$row[13];
						$_POST[colorl1]=$row[14];
						$_POST[colorf1]=$row[15];
						$_POST[tple02]=$row[16];
						$_POST[flle02]=$row[17];
						$_POST[ttle02]=$row[18];
						$_POST[colorl2]=$row[19];
						$_POST[colorf2]=$row[20];
						
						$txtarchivo="informacion/archivos/$row[5]";
						$ar=fopen($txtarchivo,"r") or die("No se pudo abrir el archivo");
                        while (!feof($ar))
						{
							$linea=fgets($ar);
							$lineasalto=nl2br($linea);
							$_POST[gradescr]=$_POST[gradescr].str_replace ('<br />','',$lineasalto);
						}
					  	fclose($ar);
						
					}
				}
			?>
            <input type="hidden" name="dirimag" id="dirimag" value="<?php echo $_POST[dirimag];?>" onChange="document.form2.submit();"/>
            <img id="imagencm" src="<?php echo $_POST[dirimag];?>" style="height:260px; width:260px;  position: fixed; top: 160px; left: 820px; visibility: hidden;"/>
        	<table class="inicio" >
         		<tr>
            		<td class="titulos" colspan="5" style="width:90%">:: Ingresar Informaci&oacute de Inter&eacute;s</td>
                  	<td class="cerrar"  onClick="location.href='hum-principal.php'">Cerrar</td>
                </tr>
                 <tr>
                    <td class="tamano01" style="width:2.5cm">:&middot; Fecha inicio:</td>
                    <td style="width:10%"><input type="date" name="fechaini" id="fechaini" class="tamano02" value="<?php echo $_POST[fechaini];?>"/></td>
                    <td class="tamano01" style="width:2.5cm">:&middot; Fecha Final:</td>
                    <td style="width:35%"><input type="date" name="fechafin" id="fechafin" class="tamano02" value="<?php echo $_POST[fechafin];?>"/></td>
                      <td rowspan="7" colspan="2" style="text-align:center">
                    	<img id="imagencm" src="imagenes/cartelera03.png" style="height:260px; " >
                    </td>
             	</tr>
                <tr >
         			<td class="tamano01" style="width:2.5cm">:&middot; Titulo:</td>
                    <td style="width:55%" colspan="3"><input type="text" name="gratitulo" id="gratitulo" style="width:100%; text-transform:uppercase;" class="tamano02" value="<?php echo $_POST[gratitulo];?>"/></td>
               	</tr>
         		<tr >
                	<td class="tamano01" >:&middot; Formato: </td>
                   	<td colspan="3">
             			<select name="tple01" id="tple01" class="tamano02" style="width:30%;float:left;text-transform:uppercase;"/>
                    		<?php
                           		$sqlr="SELECT * FROM dominios WHERE nombre_dominio='TIPOS_DE_LETRA' ORDER BY length(valor_inicial),valor_inicial ASC";
                             	$resp = mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($resp))
								{
									if($row[0]==$_POST[tple01])
									{
										echo "<option style='font-family:$row[2];' value='$row[0]' SELECTED>$row[1]</option>";
										$_POST[tletra1]=$row[2];
									}
									else{echo "<option style='font-family:$row[2];' value='$row[0]'>$row[1]</option>";}
								}
                        	?>
                  		</select>
                  		<select name="flle01" id="flle01" class="tamano02" style="width:18%;float:left;margin-left:2px;text-transform:uppercase;" >
                 			<option value="normal" style="font-style:normal;" <?php if($_POST[flle01]=="normal"){echo "SELECTED";}?>>Normal</option>
                        	<option value="italic" style="font-style:italic;"<?php if($_POST[flle01]=="italic"){echo "SELECTED";}?>>Italica</option>
                       		<option value="oblique" style="font-style:oblique;"<?php if($_POST[flle01]=="oblique"){echo "SELECTED";}?>>Cursiva</option>
             			</select>
                		<input type="number" name="ttle01" id="ttle01" value="<?php echo $_POST[ttle01];?>" class="tamano02" min="20" max="50" step="5" style=" width:10%;float:left; margin-left:2px"/>
                		<input type="color" name="colorl1" id="colorl1" style=" width:10%;float:left; margin-left:2px" value="<?php echo $_POST[colorl1];?>" class="tamano02" title="Color Letra"/>
                        <input type="color" name="colorf1" id="colorf1" style=" width:10%;float:left; margin-left:2px" value="<?php echo $_POST[colorf1];?>" class="tamano02" title="Color Fondo"/>
                                
       			</tr>
                <tr>
                	<td class="tamano01" style="width:2cm;">:&middot; Adjunto:</td>
               		<td colspan="3" >
                    	<input type="text" name="nomarch" id="nomarch"  style="width:95%" value="<?php echo $_POST[nomarch]?>" class="tamano02" readonly/>
                         <div class='upload' style="height:24px;float:right !important;"  > 
                            <input type="file" name="adjuntom" onChange="document.form2.submit();"  title="Cargar Archivo"  />
                            <img src='imagenes/upload01.png' style="width:23px"/> 
                         </div> 
                     </td>
                </tr>
                <tr>
                	<td class="tamano01" style="width:2cm;">:&middot; Imagen:</td>
               		<td colspan="3">
                    	<input type="text" name="nimagen" id="nimagen"  style="width:95%" value="<?php echo $_POST[nimagen]?>" class="tamano02"  readonly/>
                         <div class='upload' style="height:24px;float:right !important;" > 
                            <input type="file" name="adnimagen" id="adnimagen" onChange="document.form2.submit();"  title="Cargar Imagen" onMouseMove="despliegaimagen('visible');" onMouseOut="despliegaimagen('hidden');" />
                            <img src='imagenes/upload01.png' style="width:23px"/> 
                         </div> 
                     </td>
                </tr>
                <tr>   
                	<td class="tamano01" style="width:9%">:&middot; Descripci&oacute;n:</td>
                	<td id="areadetexto"  colspan="3" ><textarea id="gradescr" name="gradescr" onClick="borrarinicio();" style="width:100%; height:150px;resize:none;" ><?php echo $_POST[gradescr];?></textarea></td>
           		</tr>
   				<tr >
      				<td class="tamano01" style="width:3.5cm">:&middot; Formato Des.: </td>
               		<td colspan="3">
                 		<select name="tple02" id="tple02" class="tamano02" style="width:30%;float:left;text-transform:uppercase;"/>
                      		<?php
                          		$sqlr="SELECT * from dominios WHERE nombre_dominio='TIPOS_DE_LETRA' ORDER BY length(valor_inicial),valor_inicial ASC";
                              	$resp = mysql_query($sqlr,$linkbd);
                            	while ($row =mysql_fetch_row($resp))
                             	{
                             		if($row[0]==$_POST[tple02])
									{
										echo "<option style='font-family:$row[2];' value='$row[0]' SELECTED>$row[1]</option>";
										$_POST[tletra2]=$row[2];
									}
									else{echo "<option style='font-family:$row[2];' value='$row[0]'>$row[1]</option>";}
                             	}
                       		?>
                  		</select>
           				<select name="flle02" id="flle02" class="tamano02" style="width:18%;float:left;margin-left:2px;text-transform:uppercase;"/>
                   			<option value="normal" style="font-style:normal;" <?php if($_POST[flle02]=="normal"){echo "SELECTED";}?>>Normal</option>
                        	<option value="italic" style="font-style:italic;"<?php if($_POST[flle02]=="italic"){echo "SELECTED";}?>>Italica</option>
                       		<option value="oblique" style="font-style:oblique;"<?php if($_POST[flle02]=="oblique"){echo "SELECTED";}?>>Cursiva</option>
                    	</select>
                     	<input type="number" name="ttle02" id="ttle02" value="<?php echo $_POST[ttle02];?>" class="tamano02" min="12" max="40" step="1"  style="width:10%;float:left; margin-left:2px"/>
                     	<input type="color" name="colorl2" id="colorl2" style=" width:10%;float:left; margin-left:2px" value="<?php echo $_POST[colorl2];?>" class="tamano02" title="Color letra"/>
                        <input type="color" name="colorf2" id="colorf2" style=" width:10%;float:left; margin-left:2px" value="<?php echo $_POST[colorf2];?>" class="tamano02" title="Color Fondo"/>
      				</td>
   				</tr>
  			</table>
    		<input type="hidden" name="oculto" id="oculto" value="0"/>
            <input type="hidden" name="codigo" id="codigo" value="<?php echo $_POST[codigo];?>"/>
            <input type="hidden" name="arcini" id="arcini" value="<?php echo $_POST[arcini];?>"/>
            <input type="hidden" name="noarin" id="noarin" value="<?php echo $_POST[noarin];?>"/>
            <input type="hidden" name="imaini" id="imaini" value="<?php echo $_POST[imaini];?>"/>
            <input type="hidden" name="noimin" id="noimin" value="<?php echo $_POST[noimin];?>"/>
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
				if (is_uploaded_file($_FILES['adjuntom']['tmp_name'])) 
				{
					$archivo = $_FILES['adjuntom']['name'];
					$tipo = $_FILES['adjuntom']['type'];
					$usersave=$_SESSION[cedulausu];
					$destino = "informacion/temp/us$usersave/".$archivo;
					if (copy($_FILES['adjuntom']['tmp_name'],$destino))
					{
						echo"
						<script>
							document.getElementById('nomarch').value='".$_FILES['adjuntom']['name']."';
							document.getElementById('arcini').value='2';
							despliegamodalm('visible','3','Archivo Adjunto Cargado Con Éxito');
						</script>";
					}
					else
					{
						echo"<script>document.getElementById('nomarch').value='';
						despliegamodalm('visible','2','Error Al Cargar el Archivo');</script>";
					} 
				}
				if (is_uploaded_file($_FILES['adnimagen']['tmp_name'])) 
				{
					$archivo = $_FILES['adnimagen']['name'];
					$tipo = $_FILES['adnimagen']['type'];
					$usersave=$_SESSION[cedulausu];
					$destino = "informacion/temp/us$usersave/".$archivo;
					if (copy($_FILES['adnimagen']['tmp_name'],$destino))
					{
						echo"
						<script>
							document.getElementById('nimagen').value='".$_FILES['adnimagen']['name']."';
							document.getElementById('dirimag').value='$destino';
							document.getElementById('dirimag').scr='$destino';
							document.getElementById('imaini').value='2';
							despliegamodalm('visible','3','Imagen Cargada Con Éxito');
						</script>";
					}
					else
					{
						echo"<script>document.getElementById('nimagen').value='';
						despliegamodalm('visible','2','Error Al Cargar el Archivo');</script>";
					} 
				}
				if($_POST[oculto]=="1")
				{
					$usersave=$_SESSION[cedulausu];
					$dat01="";
					$dat02="";
					//almacenar en el servidor archivo
					if($_POST[arcini]=="2" && $_POST[nomarch]!="")
					{
						unlink("informacion/adjuntos/$_POST[noarin]");
						$adnombre=$_POST[nomarch];
						$temarchivo="informacion/temp/us$usersave/$adnombre";
						copy($temarchivo, "informacion/adjuntos/$adnombre");
						$_POST[noarin]=$adnombre;
						$_POST[arcini]='1';
						$dat02=",adjunto='$_POST[nomarch]'";
					}
					//almacenar en el servidor imagen
					if($_POST[imaini]=="2" && $_POST[nimagen]!="")
					{
						unlink("informacion/imagenes/$_POST[noimin]");
						$adnombre=$_POST[nimagen];
						$temarchivo="informacion/temp/us$usersave/$adnombre";
						copy($temarchivo, "informacion/imagenes/$adnombre");
						$_POST[noimin]=$adnombre;
						$_POST[imaini]='1';
						$dat01="imgnombre='$_POST[nimagen]',";
					}
					//archivar
					$texnombre="archivo$_POST[codigo].txt";
					$ar=fopen("informacion/archivos/$texnombre","w") or die("Problemas en la creacion");
					fputs($ar,$_REQUEST['gradescr']);
					fputs($ar,"\n");
					fclose($ar);
					$titulo=$_POST[gratitulo];
					$sqlr="UPDATE infor_interes SET titulos='$_POST[gratitulo]', $dat01 texnombre='$texnombre',fecha_inicio='$_POST[fechaini]', fecha_fin='$_POST[fechafin]' $dat02,tipoletrat='$_POST[tple01]',formatoletrat='$_POST[flle01]',tamanoletrat='$_POST[ttle01]', colorletrat='$_POST[colorl1]',colorfondot='$_POST[colorf1]',tipoletrad='$_POST[tple02]',formatoletrad='$_POST[flle02]', 	tamanoletrad='$_POST[ttle02]',colorletrad='$_POST[colorl2]',colorfondod='$_POST[colorf2]' WHERE indices='$_POST[codigo]'";
					if (!mysql_query($sqlr,$linkbd)){echo"<script>despliegamodalm('visible','2','Error no se almaceno');</script>";}	
					else {echo"<script>despliegamodalm('visible','3','La información se Modifico con exito');</script>";}
					echo"<script>document.getElementById('oculto').value='0';</script>";
				}
			?>
 		</form>
    </body>
</html>