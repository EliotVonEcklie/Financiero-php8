<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
	//**niveles menu: Administracion (0) - Consultas (1) - Herramientas (2) - Reportes (3)
	$scroll=$_GET['scrtop'];
	$totreg=$_GET['totreg'];
	$idcta=$_GET['idcta'];
	$altura=$_GET['altura'];
	$filtro="'".$_GET['filtro']."'";
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<?php require "head.php"; ?>
    	<title>:: Spid - Meci Calidad</title>
		<script>
			function guardar()
			{
				if (document.form2.titulofmt.value!='' && document.form2.fechapro.value!='' && document.form2.responsable.value!='' && document.form2.nomarch.value!='' && document.form2.versiona.value!='' && document.form2.versionb.value!='')
				{
					if(document.form2.versionanta.value!='') 
					{ 
						if(document.form2.versiona.value == document.form2.versionanta.value)
						{
							if(document.form2.versionb.value > document.form2.versionantb.value)
							{
								despliegamodalm('visible','4','Esta Seguro de Guardar','1');
							}
							else
							{
								despliegamodalm('visible','3','La Versión debe ser mayor a la Versión Anterior');
								document.form2.versionb.focus();document.form2.versionb.select();
							}
						}
						else if (document.form2.versiona.value > document.form2.versionanta.value)
						{
							despliegamodalm('visible','4','Esta Seguro de Guardar','2');
						}
						else
						{
							despliegamodalm('visible','3','La Versión debe ser mayor a la Versión Anterior');
							document.form2.versiona.focus();document.form2.versiona.select();
						}
					}
					else 
					{
						despliegamodalm('visible','4','Esta Seguro de Guardar','3');
					}
				
				}
				else
				{
					despliegamodalm('visible','2','Faltan datos para completar el registro');
					document.form2.procesos.focus();document.form2.procesos.select();
				}
			}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventanam').src="";}
				else
				{
					switch(_tip)
					{
						case "1":
							document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
						case "2":
							document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
						case "3":
							document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
						case "4":
							document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;	
					}
				}
			}
			function funcionmensaje(){document.location.href = "meci-gestiondocbusca.php";}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.form2.oculto.value=2;document.form2.submit();break;
					case "2":	document.form2.oculto.value=2;document.form2.submit();break;
					case "3":	document.form2.oculto.value=2;document.form2.submit();break;
				}
			}	
		
			function iratras(scrtop, numpag, limreg, filtro){
				var idcta=document.getElementById('codigospid').value;
				location.href="meci-gestiondocbusca.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
			}
			function buscares(e)
			{
				if (document.form2.responsable.value!="")
				{document.form2.bres.value='1';document.form2.submit();}
			}
			function mostrarg(_valor){document.getElementById("ventanasalvar").style.visibility=_valor; }
			function despliegamodal2(_valor){document.getElementById("bgventanamodal2").style.visibility=_valor;}
			function fechamejora()
			{
				if(document.form2.estado1.value=="N"){document.form2.estadofech.value="visible";}
				else{document.form2.estadofech.value="hidden";}
				document.form2.submit();
			}
		</script>
		<?php
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
	<?php
		$numpag=$_GET[numpag];
		$limreg=$_GET[limreg];
		$scrtop=26*$totreg;
	?>
	<table>
		<tr><script>barra_imagenes("meci");</script><?php cuadro_titulos();?></tr>	 
		<tr><?php menu_desplegable("meci");?></tr>
        <tr>
  			<td colspan="3" class="cinta">
				<a onclick="location.href='meci-gestiondoc.php'" class="tooltip bottom mgbt"><img src="imagenes/add.png" border="0" /><span class="tiptext">Nuevo</span></a>
				<a onClick="guardar()" class="tooltip bottom mgbt"><img src="imagenes/guarda.png"  /><span class="tiptext">Guardar</span></a>
				<a onclick="location.href='meci-gestiondocbusca.php'" class="tooltip bottom mgbt"><img src="imagenes/busca.png"  border="0" /><span class="tiptext">Buscar</span></a>
				<a onClick="mypop=window.open('meci-principal.php','','');mypop.focus();" class="tooltip bottom mgbt"><img src="imagenes/nv.png"><span class="tiptext">Nueva ventana</span></a>
				<a onClick="mypop=window.open('<?php echo $url2; ?>','','');mypop.focus();" class="tooltip bottom mgbt"><img src="imagenes/duplicar_pantalla.png"><span class="tiptext">Duplicar pestaña</span></a>
				<a onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>)" class="tooltip bottom mgbt"><img src="imagenes/iratras.png"><span class="tiptext">Atrás</span></a>
			</td>
		</tr>
	</table>
	<div id="bgventanamodalm" class="bgventanamodalm">
		<div id="ventanamodalm" class="ventanamodalm">
			<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
			</IFRAME>
		</div>
	</div>
 	<form name="form2" method="post" enctype="multipart/form-data"> 
	 <?php 
        $linkbd=conectar_bd(); 
        if($_POST[oculto]=="")
        {
			$sqlr="SELECT cgd.*, cld.* FROM calgestiondoc cgd, callistadoc cld WHERE cgd.idarchivo=cld.id AND cgd.codigospid='".$_GET[idproceso]."'";
			$resp = mysql_query($sqlr,$linkbd);
            while ($row =mysql_fetch_row($resp))
            {
				$sqlr2="SELECT nombre FROM calprocesos WHERE id='".$row[1]."'";
				$res2=mysql_query($sqlr2,$linkbd);
				$row2 = mysql_fetch_row($res2);
				$_POST[procesos]=$row2[0];
				$sqlr2="SELECT nombre FROM caldocumentos WHERE id='".$row[2]."'";
				$res2=mysql_query($sqlr2,$linkbd);
				$row2 = mysql_fetch_row($res2);
				$_POST[tdocumento]=$row2[0];
				$sqlr2="SELECT descripcion_valor FROM dominios WHERE nombre_dominio='TIPOS_DE_POLITICAS' AND valor_inicial='".$row[3]."'";
				$res2=mysql_query($sqlr2,$linkbd);
				$row2 = mysql_fetch_row($res2);
				$_POST[politicas]=$row2[0];
                $_POST[codigospid]=$_GET[idproceso];				
				$_POST[titulofmt]=$row[6];
				$_POST[codigoet]=$row[5];
				$_POST[fechapro]=$row[13];
				$_POST[responsable]=$row[14];
				$_POST[nomarch]=$row[15];
				$_POST[arcori]=$row[15];
				$_POST[idarchivo]=$row[9];
				$vers = explode(".", $row[11]);
				$_POST[versiona]=$vers[0];
				$_POST[versionb]=$vers[1];
				$vers = explode(".", $row[12]);
				$_POST[versionanta]=$vers[0];
				$_POST[versionantb]=$vers[1];
				$_POST[estado]=$row[8];
				$_POST[estado1]=$row[16];
				$nresul=buscaresponsable($row[14]);
			  	if($nresul!=''){$_POST[nresponsable]=$nresul;}
			 	else{$_POST[nresponsable]="";}
				if($row[16]=="N"){$_POST[estadofech]="visible";}
				else{$_POST[estadofech]="hidden";}
				$_POST[fechame]=$row[17];
				$archivo ="informacion/calidad_documental/cambios/".$row[18];
				$handle = fopen($archivo, "r"); // Abris el archivo
				$contenido = fread ($handle, filesize ($archivo)); //Lees el archivo
				fclose($archivo);
				$_POST[tcambios]=$contenido;
				$_POST[mejcam]=$row[19];
					
            }
        }
     ?>
   	<table class="inicio ancho" >
		<tr>
            <td class="titulos" colspan="6" width='100%'>Editar Gesti&oacute;n Documental</td>
            <td class="boton02" onclick="location.href='meci-principal.php'">Cerrar</td>
        </tr>
        <tr>
        	<td class="saludo1" style="width:8%" >Proceso:</td>
            <td style="width:30%" ><input id="procesos" name="procesos" style="width:95%" value="<?php echo $_POST[procesos]?>"  readonly></td>
            <td class="saludo1" style="width:8%">Documento:</td>
            <td style="width:25%"><input id="tdocumento" name="tdocumento" style="width:95%" value="<?php echo $_POST[tdocumento]?>" readonly></td>
            <td style="width:22%" colspan="2">
            	<input id="politicas" name="politicas" style=" <?php if($_POST[politicas]!=''){ echo ('width:100%; visibility:visible;');}else{echo ('width:100%; visibility:hidden;');}?>;" value="<?php echo $_POST[politicas]?>" readonly>
            </td>
        </tr>
        <tr>
        	<td class="saludo1" >T&iacute;tulo:</td>
   			<td>
            	<input id="titulofmt" type="text" name="titulofmt" style="width:95%" value="<?php echo $_POST[titulofmt]?>" onKeyDown="mostrarg('hidden');" onBlur="mostrarg('hidden');">
         	</td>
         	<td class="saludo1" style="width:8%">C&oacute;digo SPID:</td>
          	<td > <input name="codigospid" id="codigospid" type="text" value="<?php echo $_POST[codigospid]?>" style="width:95%"  readonly></td>
        	<td class="saludo1">C&oacute;digo Alt:</td>
            <td><input id="codigoet" type="text" name="codigoet" style="width:100%" value="<?php echo $_POST[codigoet]?>"></td>
       	</tr>
			<td class="saludo1">Activo/Inactivo:</td>
        	<td> 
            	<select name="estado" id="estado" onKeyUp="return tabular(event,this)">
          			<option value="S" <?php if($_POST[estado]=='S') echo "SELECTED"; ?>>Activo</option>
          			<option value="N" <?php if($_POST[estado]=='N') echo "SELECTED"; ?>>Inactivo</option>
        		</select>
        	</td>

   </table>
   <table class="inicio ancho"> 
      	<tr>
       		<td class="titulos" colspan="9">Informaci&oacute;n Documento</td>
		</tr> 
         <tr>
        	<td class="saludo1">Fecha Aprob:</td>
			<td style="width:10%">
				<input type="text" style="width:75%" name="fechapro" value="<?php echo $_POST[fechapro]?>" maxlength="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971541" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" style="width: 25%;height: 30px;">&nbsp;<img src="imagenes/calendario04.png" onClick="displayCalendarFor('fc_1198971541');" title="Calendario" class="icobut"/>
			</td>
            <td class="saludo1" >Responsable:</td>
   			<td style="width:10%" ><input id="responsable" type="text" name="responsable" style="width:100%" onKeyPress="return solonumeros(event);" onKeyUp="return tabular(event,this)" onBlur="buscares(event)" value="<?php echo $_POST[responsable]?>" onClick="document.getElementById('responsable').focus(); document.getElementById('responsable').select();"></td>
           
            <td colspan="2"style="width:25%" >
				<a onClick="despliegamodal2('visible');" style="width:25%"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>
				<input name="nresponsable" type="text" value="<?php echo $_POST[nresponsable]?>" style=" width:88.5% " readonly>
			</td>
            <td class="saludo1">Plantilla</td>
   			<td><input type="text" name="nomarch" id="nomarch"  style="width:100%" value="<?php echo $_POST[nomarch]?>" readonly></td>
   			<td>
                <div class='upload'> 
                    <input type="file" name="plantillaad" onChange="document.form2.submit();" />
                    <img src='imagenes/attach.png'  title='(Cargar)' title='(Cargar)'  /> 
                </div> 
   			</td>
       	</tr>
        <tr>  
            <td class="saludo1">Versi&oacute;n:</td>
            <td>
            	<input name="versiona" type="text" style="width:25; text-align:right;" value="<?php echo $_POST[versiona]?>" onKeyPress="return solonumeros(event);">.<input name="versionb" type="text" style="width:25%;" value="<?php echo $_POST[versionb]?>" onKeyPress="return solonumeros(event);">
            </td>
            <td class="saludo1">Versi&oacute;n Ant:</td>        
   			<td>
           		<input id="versionanta" name="versionanta" type="text" style="width:25%; text-align:right;"  onkeypress="return solonumeros(event);" value="<?php echo $_POST[versionanta]?>" readonly >.<input id="versionantb" name="versionantb" type="text" style="width:25%"  onkeypress="return solonumeros(event);" value="<?php echo $_POST[versionantb]?>" readonly>
            </td>
            <td class="saludo1" style="width:10%">Mejora o Cambio:</td>
            <td><input type="checkbox" name="mejcam" id="mejcam" <?php if(isset($_REQUEST['mejcam'])or($_POST[mejcam]==1)){echo "checked";} ?> value="<?php echo $_POST[mejcam]?>"/></td>
            <td class="saludo1">Estado:</td>
            <td> 
            	<select name="estado1" id="estado1" onKeyUp="return tabular(event,this)" onChange="fechamejora();">
          			<option value="S" <?php if($_POST[estado1]=='S') echo "SELECTED"; ?>>Activo</option>
          			<option value="N" <?php if($_POST[estado1]=='N') echo "SELECTED"; ?>>En Mejora</option>
        		</select>
        	</td>
   		</tr>
        <tr>
        	<td class="saludo1" style=" <?php if($_POST[estadofech]!=''){ echo ('visibility:'.$_POST[estadofech].';');}else{echo ('visibility:hidden;');}?>">Fecha Mejora:</td>
			<td style=" <?php if($_POST[estadofech]!=''){ echo ('visibility:'.$_POST[estadofech].';');}else{echo ('visibility:hidden;');}?>">
				<input type="text" style="width:75%" id="fechame" name="fechame" value="<?php echo $_POST[fechame]?>" maxlength="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971541" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" style="width: 25%;height: 30px;">&nbsp;<img src="imagenes/calendario04.png" onClick="displayCalendarFor('fc_1198971541');" title="Calendario" class="icobut"/>
			</td>
        </tr>
	</table>
    <table class="inicio"> 
      	<tr>
       		<td class="titulos" >Cambios Realizados</td>
		</tr>         
        <tr>
			<td style="height:150px;"><textarea id="tcambios" name="tcambios" style="width:100%; height:100%; resize:none;" ><?php echo $_POST[tcambios]?></textarea></td>
      	</tr>
	</table>
   <input name="preproceso" type="hidden" value="<?php echo $_POST[preproceso]?>">
    <input name="preprocesoid" type="hidden" value="<?php echo $_POST[preprocesoid]?>">
    <input name="predocumento" type="hidden" value="<?php echo $_POST[predocumento]?>">
    <input name="predocumentoid" type="hidden" value="<?php echo $_POST[predocumentoid]?>">
    <input name="coddane" type="hidden" value="<?php echo $_POST[coddane]?>">
    <input name="codigo" type="hidden" value="<?php echo $_POST[codigo]?>">
    <input name="idarchivo" type="hidden" value="<?php echo $_POST[idarchivo]?>">
    <input name="idanterior" type="hidden" value="<?php echo $_POST[idanterior]?>">
    <input name="idarchivoant" type="hidden" value="<?php echo $_POST[idarchivoant]?>">
    <input name="estadopo" type="hidden" value="<?php echo $_POST[estadopo]?>">
    <input name="estadofech" type="hidden" value="<?php echo $_POST[estadofech]?>">
    <input type="hidden" name="bres" value="<?php echo $_POST[bres]?>">
     <input id="arcori" name="arcori" type="hidden" value="<?php echo $_POST[arcori]?>">
    <input type="hidden" name="oculto" id="oculto" value="1">
    <input type="hidden" name="ocul2" id="ocul2" value="1">
    <input type="hidden" name="ocul3" id="ocul3" value="1">
 	<?php 
		if($_POST[ocul3]=="2")
		{
		
		}	
		//*******Trae nombre Responsable 
		 if($_POST[bres]=='1')
			{
				$nresul=buscaresponsable($_POST[responsable]);
				if($nresul!='')
				{$_POST[nresponsable]=$nresul;}
				else
				{$_POST[nresponsable]="";}
				$_POST[bres]="";
			}
 	//********guardar
		if($_POST[oculto]=="2")
		{
			$sqlr="UPDATE calgestiondoc SET codigoalt='$_POST[codigoet]',titulo='$_POST[titulofmt]',idarchivo='$_POST[idarchivo]', estado='$_POST[estado]' WHERE codigospid='$_POST[codigospid]'";
			if (!mysql_query($sqlr,$linkbd))
			{
				 echo "<script>alert('ERROR EN LA CREACION DEL ANEXO');</script>";
				 echo $sqlr;
				 echo "error ".mysql_error($linkbd);
			}
			else
			{
				if(isset($_REQUEST['mejcam'])){$checkmejora=1;}else{$checkmejora=0;}
				if($_POST[versiona]!="" && $_POST[versionb]!=""){$vers1=$_POST[versiona].".".$_POST[versionb];}
				else{$vers1="";}
				if($_POST[versionanta]!="" && $_POST[versionantb]!=""){$vers2=$_POST[versionanta].".".$_POST[versionantb];}
				else{$vers2="";}
				$trozos = explode(".",$_POST[nomarch]);  
				if($trozos[0]=='$_POST[codigospid]'){$nomar='$_POST[nomarch]';}
				else
				{$extension = end($trozos); $nomar=$_POST[codigospid].".".$extension;}
				if ($_POST[arcori]==$_POST[nomarch]){$dircarga="informacion/calidad_documental/documentos/";}
				else{$dircarga="informacion/calidad_documental/temp/";}
				unlink("informacion/calidad_documental/documentos/".$nomar);
				copy($dircarga.$_POST[nomarch],("informacion/calidad_documental/documentos/".$nomar));
				$sqlr="UPDATE callistadoc SET version='$vers1',versionant='$vers2',fechaprov='$_POST[fechapro]',idresponsable='$_POST[responsable]', nomarchivo='$nomar',estado='$_POST[estado1]',fechamejora='$_POST[fechame]',mejocam='$checkmejora' WHERE id='$_POST[idarchivo]'";
				mysql_query($sqlr,$linkbd);
				//combertir en .txt	el textarea	
				$ar=fopen("informacion/calidad_documental/cambios/".$_POST[codigospid].".txt","w+") or die("Problemas en la creacion");
				fputs($ar,$_REQUEST['tcambios']);
				fputs($ar,"\n");
				fclose($ar);
				?><script>document.form2.nombre.focus();</script><?php
				echo "<script>despliegamodalm('visible','1','Se ha actualizado el proceso con exito');</script>";
			}
		}
		//archivos
		if (is_uploaded_file($_FILES['plantillaad']['tmp_name'])) 
		{
			$rutaad="informacion/calidad_documental/temp/";
			if(!file_exists($rutaad)){mkdir ($rutaad);}
			else {eliminarDir();mkdir ($rutaad);}
			?><script>document.getElementById('nomarch').value='<?php echo $_FILES['plantillaad']['name'];?>';</script><?php 
			copy($_FILES['plantillaad']['tmp_name'], $rutaad.$_FILES['plantillaad']['name']);
		}
	 ?>
 </form>       
 </td>       
 </tr>       
	</table>
    <div id="bgventanamodal2">
            <div id="ventanamodal2">
                
                <IFRAME  src="meci-gestiondocresponsables.php" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                </IFRAME>
            </div>
        </div>
</body>
</html>