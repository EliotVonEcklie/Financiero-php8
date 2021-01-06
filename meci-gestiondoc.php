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
	 	<?php require "head.php"; ?>
    	<title>:: Spid - Meci Calidad</title>
    	<script>
			function mostrarg(_valor){document.getElementById("ventanamensaje1").style.visibility=_valor;}
    		function guardar()
    		{
				var validacion01=document.getElementById('titulofmt').value;
				if (document.form2.procesos.value!='' && document.form2.tdocumento.value!='' && validacion01.trim()!='' && document.form2.fechapro.value!='' && document.form2.responsable.value!='' && document.form2.nomarch.value!='' && document.form2.versiona.value!='' && document.form2.versionb.value!='')
				{
					if(document.form2.versionanta.value!='') 
					{ 
						if(document.form2.versiona.value == document.form2.versionanta.value)
						{
							if(document.form2.versionb.value > document.form2.versionantb.value)
							{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
							else
							{
								despliegamodalm('visible','2','La Versión debe ser mayor a la Versión Anterior');
								document.form2.versionb.focus();document.form2.versionb.select();
							}
						}
						else if (document.form2.versiona.value > document.form2.versionanta.value)
						{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
						else
						{
							despliegamodalm('visible','2','La Versión debe ser mayor a la Versión Anterior');
							document.form2.versiona.focus();document.form2.versiona.select();
						}
					 
					}
					else {despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
				}
				else{despliegamodalm('visible','2','Faltan datos para completar el registro');}
			}
			function codspid(cod,pre)
			{
				var codigo=document.form2.codigospid.value;
				if (cod=="pro")
				{if (pre==""){pre="000";}document.form2.codigospid.value=pre+codigo.substring(3, 16);}
				else{if (pre==""){pre="00";}document.form2.codigospid.value=codigo.substring(0, 10)+pre+codigo.substring(12, 16);}
			}
			function buscares(e)
			{
				if (document.form2.responsable.value!="")
				{document.form2.bres.value='1';document.form2.submit();}
			}
			function activapoli(pre)
			{
				if (pre=="PO"){document.form2.politicas.style.visibility="visible";document.form2.estadopo.value="visible";}
				else{document.form2.politicas.style.visibility="hidden";document.form2.politicas.value="";document.form2.estadopo.value="hidden";}
			}
			function cargadatos(pre)
			{
				
				if(pre=="pro")
				{
					var infor=document.form2.procesos.value;
					var infodiv=infor.split('-');
					document.form2.preprocesoid.value=(infodiv[0]);
					document.form2.preproceso.value=(infodiv[1]);
				}
				else
				{
					var infor=document.form2.tdocumento.value;
					var infodiv=infor.split('-');
					activapoli(infodiv[1]);
					document.form2.predocumentoid.value=infodiv[0];
					document.form2.predocumento.value=infodiv[1];
				}
				document.form2.ocul2.value='';
				document.form2.submit();
			}
			function despliegamodal2(_valor)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else {document.getElementById('ventana2').src="meci-gestiondocresponsables.php";}
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
			function funcionmensaje(){document.location.href = "meci-gestiondoc.php";}
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
				$carpeta="informacion/calidad_documental/temp";
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
  				<td colspan="3" class="cinta">
					<a onclick="location.href='meci-gestiondoc.php'" class="tooltip bottom mgbt"><img src="imagenes/add.png"  border="0" /><span class="tiptext">Nuevo</span></a>
					<a onClick="guardar()" class="tooltip bottom mgbt"><img src="imagenes/guarda.png" /><span class="tiptext">Guardar</span></a>
					<a onclick="location.href='meci-gestiondocbusca.php'" class="tooltip bottom mgbt"><img src="imagenes/busca.png" border="0" /><span class="tiptext">Buscar</span></a>
					<a onClick="mypop=window.open('meci-principal.php','','');mypop.focus();" class="tooltip bottom mgbt"><img src="imagenes/nv.png"><span class="tiptext">Nueva ventana</span></a>
					<a onClick="mypop=window.open('<?php echo $url2; ?>','','');mypop.focus();" class="tooltip bottom mgbt"><img src="imagenes/duplicar_pantalla.png"><span class="tiptext">Duplicar pestaña</span></a>
				</td>
			</tr>
		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
		<form name="form2" method="post" enctype="multipart/form-data" > 
    		<script>activapoli("<?php echo $_POST[estadopo];?>")</script>
			<?php
				if($_POST[oculto]=="")
				{
					$_POST[idarchivo]=selconsecutivo('callistadoc','id');
					$sqlr="SELECT depto,mnpio FROM configbasica";
					$row =mysql_fetch_row(mysql_query($sqlr,$linkbd));
					$_POST[coddane]=$row[0].$row[1];
				}
				if ($_POST[ocul2]=="")
				{
					$mx=0;
					$sqlr="SELECT MAX(id) FROM calgestiondoc where proceso='$_POST[preprocesoid]' AND documento='$_POST[predocumentoid]'";
					$resp = mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($resp)){$mx=$row[0];}
					$mx++;
					if($_POST[preproceso]==""){$_POST[preproceso]="000";}
					if($_POST[predocumento]==""){$_POST[predocumento]="00";}	
					$conc="";
					if($mx<100){$conc="0";}
					if($mx<10){$conc=$conc."0";}
					$_POST[codigo]=$conc.$mx;
					$bandera=false;
					if($_POST[predocumento]!="00")
					{
						if($_POST[predocumento]=="PO"){if($_POST[politicas]!=""){$bandera=true;}}
						else{$bandera=true;}
					}
					$_POST[codigospid]="$_POST[preproceso]-$_POST[coddane]-$_POST[predocumento]-$_POST[codigo]";
					if($_POST[preproceso]!="000" && $bandera)
					{
						if ($_POST[politicas]=="")
						{$sqlr="SELECT * FROM calgestiondoc where estado='S' AND proceso='$_POST[preprocesoid]' AND documento='$_POST[predocumentoid]'";}
						else
						{$sqlr="SELECT * FROM calgestiondoc where estado='S' AND proceso='$_POST[preprocesoid]' AND documento='$_POST[predocumentoid]' AND politicas='$_POST[politicas]'";}
						$resp = mysql_query($sqlr,$linkbd);
						$ntr = mysql_num_rows($resp);
						if ($ntr >= 1)
						{
							$row =mysql_fetch_row($resp);
							$nresul=buscaresponsable($_POST[responsable]);
							if($nresul!=''){$_POST[nresponsable]=$nresul;}
							else {$_POST[nresponsable]="";}
							$archivo ="informacion/calidad_documental/cambios/".$row2[9];
							$handle = fopen($archivo, "r"); // Abris el archivo
							$contenido = fread ($handle, filesize ($archivo)); //Lees el archivo
							fclose($archivo);
							$_POST[tcambios]=$contenido;
						}
						else
						{
							if($_POST[predocumento]!="PO")
							{
								$sqlr="SELECT MAX(idarchivo) FROM calgestiondoc where proceso='$_POST[preprocesoid]' AND documento='$_POST[predocumentoid]'";
							}
							else
							{
								$sqlr="SELECT MAX(idarchivo) FROM calgestiondoc where proceso='$_POST[preprocesoid]' AND documento='$_POST[predocumentoid]' AND politicas='$_POST[politicas]'";
							}
							$resp = mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($resp)){if($row[0]==""){$mxa=0;}else{$mxa=$row[0];}}
							if($mxa!=0)
							{
								$sqlr2="SELECT * FROM callistadoc where id='$mxa'";
								$resp2 = mysql_query($sqlr2,$linkbd);
								$row2 =mysql_fetch_row($resp2);
								$versat = explode(".", $row2[2]);
								$nresul=buscaresponsable($row2[5]);
								if($nresul!=''){$_POST[nresponsable]=$nresul;}
								else {$_POST[nresponsable]="";}
								$archivo ="informacion/calidad_documental/cambios/".$row2[9];
								$handle = fopen($archivo, "r"); // Abris el archivo
								$contenido = fread ($handle, filesize ($archivo)); //Lees el archivo
								fclose($archivo);
								$_POST[tcambios]=$contenido;
							}
						}
					}
				}
				if($_POST[bres]=='1')
				{
					$nresul=buscaresponsable($_POST[responsable]);
					if($nresul!='') {$_POST[nresponsable]=$nresul;}
					else
					{"<script>alert('No existe o est\xe1 vinculado un funcionario con este documento')</script>"; $_POST[nresponsable]=""; }
					$_POST[bres]="";
				}
			?>
   			<table class="inicio ancho" >
                <tr>
                    <td class="titulos" colspan="7" width="100%">Crear Gesti&oacute;n Documental</td>
                    <td class="boton02" onclick="location.href='meci-principal.php'">Cerrar</td>
                </tr>
        		<tr>
        			<td class="saludo1" style="width:2cm;" >Proceso:</td>
            		<td style="width:30%" >
						<select id="procesos" name="procesos" class="elementosmensaje" style="width:95%;text-transform:uppercase;"  onKeyUp="return tabular(event,this)"  onChange="cargadatos('pro');" >
							<option value="-"  >Seleccione....</option>
							<?php	
								$sqlr="SELECT * FROM calprocesos ORDER BY id ASC  ";
								$res=mysql_query($sqlr,$linkbd);
								while ($rowEmp = mysql_fetch_assoc($res)) 
								{
									if($_POST[procesos]=="$rowEmp[id]-$rowEmp[prefijo]")
									{
										echo "<option style='text-transform:uppercase;' value='$rowEmp[id]-$rowEmp[prefijo]' SELECTED>$rowEmp[id] - $rowEmp[nombre]</option>";
										$_POST[octradicacion]=$rowEmp[nombre];
									}
									else {echo "<option style='text-transform:uppercase;' value='$rowEmp[id]-$rowEmp[prefijo]'>$rowEmp[id] - $rowEmp[nombre]</option>";}
								}		
							?> 
           				</select> 
            		</td>
            		<td class="saludo1" style="width:2.5cm;">Documento:</td>
           			<td style="width:25%">
						<select id="tdocumento" name="tdocumento" class="elementosmensaje" style="width:95%;text-transform:uppercase;"  onKeyUp="return tabular(event,this)" onChange="cargadatos('doc');">
							<option value="-">Seleccione....</option>
							<?php	
								$sqlr="SELECT * FROM caldocumentos ORDER BY id ASC  ";
								$res=mysql_query($sqlr,$linkbd);
								while ($rowEmp = mysql_fetch_assoc($res)) 
								{
									if($_POST[tdocumento]=="$rowEmp[id]-$rowEmp[prefijo]")
									{
										echo "<option style='text-transform:uppercase;' value='$rowEmp[id]-$rowEmp[prefijo]' SELECTED>$rowEmp[id] - $rowEmp[nombre]</option>";
										$_POST[octradicacion]=$rowEmp[nombre];
									}
									else {echo "<option style='text-transform:uppercase;' value='$rowEmp[id]-$rowEmp[prefijo]'>$rowEmp[id] - $rowEmp[nombre]</option>";}
								}		
							?> 
           				</select> 
            		</td>
            		<td colspan="2">
						<select id="politicas" name="politicas" class="elementosmensaje" style="width:100%;text-transform:uppercase; <?php if($_POST[estadopo]!=''){ echo (" visibility:$_POST[estadopo];");}else {echo ("visibility:hidden;");}?>"  onKeyUp="return tabular(event,this)" onChange="document.form2.ocul2.value='';document.form2.submit();" >
							<option  value="" >Seleccione....</option>
							<?php	
                                $sqlr="SELECT * FROM dominios WHERE nombre_dominio='TIPOS_DE_POLITICAS' ORDER BY length(valor_inicial),valor_inicial ASC  ";
                                $res=mysql_query($sqlr,$linkbd);
                                while ($rowEmp = mysql_fetch_assoc($res)) 
                                {
                                    if($rowEmp[valor_inicial]==$_POST[politicas])
                                    {
                                        echo "<option style='text-transform:uppercase;' value='$rowEmp[valor_inicial]' SELECTED>$rowEmp[valor_inicial] - $rowEmp[descripcion_valor]</option>";
                                        $_POST[octradicacion]=$rowEmp[descripcion_valor];
                                    }
                                    else{echo "<option style='text-transform:uppercase;' value='$rowEmp[valor_inicial]'>$rowEmp[valor_inicial] - $rowEmp[descripcion_valor]</option>";}	 
                                }		
                            ?> 
           				</select> 
            		</td>
        		</tr>
                <tr>
                    <td class="saludo1" style="width:2cm;">T&iacute;tulo:</td>
                    <td><input type="text" id="titulofmt" name="titulofmt" style="width:95%" value="<?php echo $_POST[titulofmt]?>"></td>
                    <td class="saludo1" style="width:2.5cm;">C&oacute;digo SPID:</td>
                    <td><input type="text" id="codigospid" name="codigospid" value="<?php echo $_POST[codigospid]?>" style="width:95%" readonly></td>
                    <td class="saludo1" style="width:2cm;">C&oacute;digo Alt:</td>
                    <td><input type="text" id="codigoet" name="codigoet" style="width:100%" value="<?php echo $_POST[codigoet]?>"></td>
                </tr>
      		</table>
      		<table class="inicio ancho"> 
      			<tr><td class="titulos" colspan="9">Informaci&oacute;n Documento</td></tr> 
         		<tr>
                    <td class="saludo1">Fecha Aprobaci&oacute;n:</td>
					<td style="width:10%">
						<input type="text" style="width:75%" name="fechapro" value="<?php echo $_POST[fechapro]?>" maxlength="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971541" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" style="width: 25%;height: 30px;">&nbsp;<img src="imagenes/calendario04.png" onClick="displayCalendarFor('fc_1198971541');" title="Calendario" class="icobut"/>
					</td>
                    <td class="saludo1" >Responsable:</td>
                    <td style="width:10%" ><input type="text" id="responsable" name="responsable" style="width:100%" onKeyPress="return solonumeros(event);" onKeyUp="return tabular(event,this)" onBlur="buscares(event)" value="<?php echo $_POST[responsable]?>" onClick="document.getElementById('responsable').focus(); document.getElementById('responsable').select();"></td>           
            		<td colspan="2"style="width:25%" >
						<a href="#" onClick="despliegamodal2('visible');" style="width:25%"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>
						<input type="text" name="nresponsable" id="nresponsable" value="<?php echo $_POST[nresponsable]?>" style=" width:88.5% " readonly>
					</td>
           			<td class="saludo1">Plantilla</td>
   					<td><input type="text" name="nomarch" id="nomarch" style="width:100%" value="<?php echo $_POST[nomarch]?>" readonly></td>
   					<td>
                		<div class='upload'> 
                    		<a href="#" title="Cargar Documento"><input type="file" name="plantillaad" onChange="document.form2.submit();" />
                    		<img src='imagenes/upload01.png' style="width:18px"/></a>
                		</div> 
   					</td>
       			</tr>
        		<tr>  
            		<td class="saludo1">Versi&oacute;n:</td>
           			<td>
            			<input type="text" name="versiona" style="width:25; text-align:right;" value="<?php echo $_POST[versiona]?>" onKeyPress="return solonumeros(event);">.<input type="text" name="versionb" style="width:25%;" value="<?php echo $_POST[versionb]?>" onKeyPress="return solonumeros(event);">
           	 		</td>
            		<td class="saludo1">Versi&oacute;n Anterior:</td>        
   					<td>
           				<input type="text" id="versionanta" name="versionanta" style="width:25%; text-align:right;"  onkeypress="return solonumeros(event);" value="<?php echo $_POST[versionanta]?>" readonly >.<input type="text" id="versionantb" name="versionantb" style="width:25%"  onkeypress="return solonumeros(event);" value="<?php echo $_POST[versionantb]?>" readonly>
            		</td>
                    <td class="saludo1" style="width:10%">Mejora o Cambio:</td>
                    <td><input type="checkbox" name="mejcam" id="mejcam" <?php if(isset($_REQUEST['mejcam'])){echo "checked";} ?> value="<?php echo $_POST[mejcam]?>" /></td>
   				</tr>
			</table>
    		<table class="inicio"> 
      			<tr><td class="titulos" >Descripci&oacute;n, mejoras y cambios realizados</td></tr>         
        		<tr>
					<td style="height:150px;"><textarea id="tcambios" name="tcambios" style="width:100%; height:100%; resize:none;" ><?php echo $_POST[tcambios]?></textarea></td>
      			</tr>
			</table>
            <input type="hidden" name="preproceso" id="preproceso" value="<?php echo $_POST[preproceso]?>">
            <input type="hidden" name="preprocesoid" id="preprocesoid" value="<?php echo $_POST[preprocesoid]?>">
            <input type="hidden" name="predocumento" id="predocumento" value="<?php echo $_POST[predocumento]?>">
            <input type="hidden" name="predocumentoid" id="predocumentoid" value="<?php echo $_POST[predocumentoid]?>">
            <input type="hidden" name="coddane" id="coddane" value="<?php echo $_POST[coddane]?>">
            <input type="hidden" name="codigo" id="codigo" value="<?php echo $_POST[codigo]?>">
            <input type="hidden" name="idarchivo" id="idarchivo" value="<?php echo $_POST[idarchivo]?>">
            <input type="hidden" name="idanterior" id="idanterior" value="<?php echo $_POST[idanterior]?>">
            <input type="hidden" name="idarchivoant" id="idarchivoant" value="<?php echo $_POST[idarchivoant]?>">
            <input type="hidden" name="estadopo" id="estadopo" value="<?php echo $_POST[estadopo]?>">
            <input type="hidden" name="bres" id="bres" value="<?php echo $_POST[bres]?>">
            <input type="hidden" name="cargat" id="cargat"  value="<?php echo $_POST[cargat]?>">
            <input type="hidden" name="arcori" id="arcori" value="<?php echo $_POST[arcori]?>">
            <input type="hidden" name="oculto" id="oculto" value="1">
    		<input type="hidden" name="ocul2" id="ocul2" value="1">
			<?php  
 				if($_POST[oculto]=="2")//********guardar
				{	
					if($_POST[idanterior]!="")
					{
						$sqlr="UPDATE calgestiondoc SET estado='N' WHERE id='$_POST[idanterior]' AND proceso='$_POST[preprocesoid]' AND documento='$_POST[predocumentoid]' AND politicas='$_POST[politicas]'";mysql_query($sqlr,$linkbd);
					}
					$sqlr="INSERT INTO calgestiondoc (id,proceso,documento,politicas,codigospid,codigoalt,titulo,idarchivo,estado) VALUES ('$_POST[codigo]', '$_POST[preprocesoid]','$_POST[predocumentoid]','$_POST[politicas]','$_POST[codigospid]','$_POST[codigoet]','$_POST[titulofmt]','$_POST[idarchivo]', 'S') ";
					if (!mysql_query($sqlr,$linkbd))
					{echo "<script>alert('ERROR EN LA CREACION DEL ANEXO');document.form2.nombre.focus();</script>";echo $sqlr;}
					else
					{
						if(isset($_REQUEST['mejcam'])){$checkmejora=1;}else{$checkmejora=0;}
						if($_POST[versiona]!="" && $_POST[versionb]!=""){$vers1="$_POST[versiona].$_POST[versionb]";}
						else{$vers1="";}
						if($_POST[versionanta]!="" && $_POST[versionantb]!=""){$vers2="$_POST[versionanta].$_POST[versionantb]";}
						else{$vers2="";}
						$trozos = explode(".",$_POST[nomarch]);  
						$extension = end($trozos);  
						$nomar="$_POST[codigospid].$extension";
						if ($_POST[arcori]==$_POST[nomarch]){$dircarga="informacion/calidad_documental/documentos/";}
						else{$dircarga="informacion/calidad_documental/temp/";}
						copy($dircarga.$_POST[nomarch],("informacion/calidad_documental/documentos/$nomar"));
						$sqlr2="INSERT INTO callistadoc(id,codigospid,version,versionant,fechaprov,idresponsable,nomarchivo,estado,fechamejora,cambios,mejocam) VALUES ('$_POST[idarchivo]', '$_POST[codigospid]','$vers1','$vers2','$_POST[fechapro]','$_POST[responsable]','$nomar','S','', '$_POST[codigospid].txt','$checkmejora')";
						mysql_query($sqlr2,$linkbd);
						//combertir en .txt	el textarea	
						$ar=fopen("informacion/calidad_documental/cambios/$_POST[codigospid].txt","w+") or die("Problemas en la creacion");
						fputs($ar,$_REQUEST['tcambios']);
						fputs($ar,"\n");
						fclose($ar);
						echo"<script>despliegamodalm('visible','1','Se ha almacenado la Gestión de Documentos con Exito');</script>";
					}
				}
				if (is_uploaded_file($_FILES['plantillaad']['tmp_name'])) //archivos
				{
					$rutaad="informacion/calidad_documental/temp/";
					if(!file_exists($rutaad)){mkdir ($rutaad);}
					else {eliminarDir();mkdir ($rutaad);}
					?><script>document.getElementById('nomarch').value='<?php echo $_FILES['plantillaad']['name'];?>';</script><?php 
					copy($_FILES['plantillaad']['tmp_name'], $rutaad.$_FILES['plantillaad']['name']);
				}
 			?>
           	<div id="bgventanamodal2">
                <div id="ventanamodal2">
                    <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                    </IFRAME>
                </div>
        	</div>
		</form>       
	</body>
</html>