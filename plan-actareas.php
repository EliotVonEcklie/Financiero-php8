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
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
    <meta http-equiv="X-UA-Compatible" content="IE=9"/>
    <title>::SPID-Planeaci&oacute;n Estrat&eacute;gica</title>
    <link href="css/css2.css" rel="stylesheet" type="text/css" />
    <link href="css/css3.css" rel="stylesheet" type="text/css" />
    <script>
    function mostrarg(_valor){document.getElementById("ventanamensaje1").style.visibility=_valor; }
    function guardar()
    {
		if (document.form2.procesos.value!='' && document.form2.tdocumento.value!='' && document.form2.titulofmt.value!='' && document.form2.fechapro.value!='' && document.form2.responsable.value!='' && document.form2.nomarch.value!='' && document.form2.versiona.value!='' && document.form2.versionb.value!='')
		{
			if(document.form2.versionanta.value!='') 
			{ 
				if(document.form2.versiona.value == document.form2.versionanta.value)
				{
					if(document.form2.versionb.value > document.form2.versionantb.value)
					{
						if (confirm("Esta Seguro de Guardar")){document.form2.oculto.value=2;document.form2.submit();}
					}
					else
					{
					alert('La Versi\xf3n debe ser mayor a la Versi\xf3n Anterior');document.form2.versionb.focus();document.form2.versionb.select();
					}
				}
				else if (document.form2.versiona.value > document.form2.versionanta.value)
				{
					if (confirm("Esta Seguro de Guardar")){document.form2.oculto.value=2;document.form2.submit();}
				}
				else
				{
					alert('La Versi\xf3n debe ser mayor a la Versi\xf3n Anterior');document.form2.versiona.focus();document.form2.versiona.select();
				}
					 
			}
			else if (confirm("Esta Seguro de Guardar")){document.form2.oculto.value=2;document.form2.submit();}
			
		}
		else{alert('Faltan datos para completar el registro');document.form2.procesos.focus();document.form2.procesos.select();}
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
	function despliegamodal2(_valor){document.getElementById("bgventanamodal2").style.visibility=_valor;}
	
    </script>
    <script type="text/javascript" src="css/programas.js"></script>
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
		<tr><script>barra_imagenes("plan");</script><?php cuadro_titulos();?></tr>	 
		<tr><?php menu_desplegable("plan");?></tr>
        <tr>
  			<td colspan="3" class="cinta"><a href="plan-actareas.php" class="mgbt"><img src="imagenes/add.png"  title="Nuevo" border="0" /></a> <a href="#"  onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png"  title="Guardar" /></a><a href="plan-actareasbusca.php" class="mgbt"><img src="imagenes/busca.png"  title="Buscar" border="0" /></a><a href="#" onClick="mypop=window.open('plan-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a>
            </td>
		</tr>
	</table>
	<form name="form2" method="post" enctype="multipart/form-data" > 
    <script>activapoli("<?php echo $_POST[estadopo];?>")</script>
	<?php
        $linkbd=conectar_bd();
		if($_POST[oculto]=="")
		{
   			$sqlr="SELECT MAX(id) FROM callistadoc";
    		$resp = mysql_query($sqlr,$linkbd);
       		while ($row =mysql_fetch_row($resp)){$mxa=$row[0];}
			$mxa++;
			$_POST[idarchivo]=$mxa;
			$sqlr="SELECT depto,mnpio FROM configbasica";
    		$resp = mysql_query($sqlr,$linkbd);
			$row =mysql_fetch_row($resp);
			$_POST[coddane]=$row[0].$row[1];
  		}
		if ($_POST[ocul2]=="")
		{
			$mx=0;
			$sqlr="SELECT MAX(id) FROM calgestiondoc where proceso='".$_POST[preprocesoid]."' AND documento='".$_POST[predocumentoid]."'";
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
			$_POST[codigospid]=$_POST[preproceso]."-".$_POST[coddane]."-".$_POST[predocumento]."-".$_POST[codigo];
			if($_POST[preproceso]!="000" && $bandera)
			{
				if ($_POST[politicas]=="")
				{$sqlr="SELECT * FROM calgestiondoc where estado='S' AND proceso='".$_POST[preprocesoid]."' AND documento='".$_POST[predocumentoid]."'";}
				else
				{$sqlr="SELECT * FROM calgestiondoc where estado='S' AND proceso='".$_POST[preprocesoid]."' AND documento='".$_POST[predocumentoid]."' AND politicas='".$_POST[politicas]."'";}
    			$resp = mysql_query($sqlr,$linkbd);
				$ntr = mysql_num_rows($resp);
				if ($ntr >= 1)
				{
					$row =mysql_fetch_row($resp);
					/*$_POST[idanterior]=$row[0];
					$_POST[titulofmt]=$row[6];
					$_POST[codigoet]=$row[5];
					$_POST[idarchivoant]=$row[7];
					$sqlr2="SELECT * FROM callistadoc where id='".$row[7]."'";
					$resp2 = mysql_query($sqlr2,$linkbd);
					$row2 =mysql_fetch_row($resp2);
					$versat = explode(".", $row2[2]);
					$_POST[versionanta]=$versat[0];
					$_POST[versionantb]=$versat[1];
					$_POST[fechapro]=$row2[4];
					$_POST[responsable]=$row2[5];
					$_POST[nomarch]=$row2[6];
					$_POST[arcori]=$row2[6];*/
					$nresul=buscaresponsable($_POST[responsable]);
			  		if($nresul!='')
			   		{$_POST[nresponsable]=$nresul;}
			 		else
			 		{$_POST[nresponsable]="";}
					$archivo ="informacion/calidad_documental/cambios/".$row2[9];
					$handle = fopen($archivo, "r"); // Abris el archivo
					$contenido = fread ($handle, filesize ($archivo)); //Lees el archivo
					fclose($archivo);
					$_POST[tcambios]=$contenido;
				}
				else
				{;
					$_POST[idanterior]="";
					$_POST[titulofmt]="";
					$_POST[codigoet]="";
					$_POST[versionanta]="";
					$_POST[versionantb]="";
					$_POST[fechapro]="";
					$_POST[responsable]="";
					$_POST[nomarch]="";
					$_POST[nresponsable]="";
					$_POST[tcambios]="";
					$_POST[arcori]="";
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
						$sqlr2="SELECT * FROM callistadoc where id='".$mxa."'";
						$resp2 = mysql_query($sqlr2,$linkbd);
						$row2 =mysql_fetch_row($resp2);
						$versat = explode(".", $row2[2]);
						/*$_POST[versionanta]=$versat[0];
						$_POST[versionantb]=$versat[1];
						$_POST[fechapro]=$row2[4];
						$_POST[responsable]=$row2[5];
						$_POST[nomarch]=$row2[6];
						$_POST[arcori]=$row2[6];*/
						$nresul=buscaresponsable($row2[5]);
						if($nresul!='')
						{$_POST[nresponsable]=$nresul;}
						else
						{$_POST[nresponsable]="";}
						/*$sqlr3="SELECT * FROM calgestiondoc where codigospid='".$row2[1]."'";
						$resp3 = mysql_query($sqlr3,$linkbd);
						$row3 =mysql_fetch_row($resp3);
						$_POST[idanterior]=$row3[0];
						$_POST[titulofmt]=$row3[6];
						$_POST[codigoet]=$row3[5];
						$_POST[idarchivoant]=$row3[7];*/
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
			if($nresul!='')
			{$_POST[nresponsable]=$nresul;}
			else
			{?><script>alert("No existe o est\xe1 vinculado un funcionario con este documento")</script><?php $_POST[nresponsable]=""; }
			
			$_POST[bres]="";
		}
	?>
   	<table class="inicio" >
		<tr>
       		<td class="titulos" colspan="7">Crear Gesti&oacute;n Documental</td>
         	<td class="cerrar" ><a href="meci-principal.php">Cerrar</a></td>
		</tr>
        <tr>
        	<td class="saludo1" style="width:8%" >Proceso:</td>
            <td style="width:30%" >
				<select id="procesos" name="procesos" class="elementosmensaje" style="width:95%"  onKeyUp="return tabular(event,this)"  onChange="cargadatos('pro');" >
					<option onChange="" value="-"  >Seleccione....</option>
					<?php	
						$sqlr="SELECT * FROM calprocesos ORDER BY id ASC  ";
						$res=mysql_query($sqlr,$linkbd);
						while ($rowEmp = mysql_fetch_assoc($res)) 
						{
							echo "<option  value= ".$rowEmp['id']."-".$rowEmp['prefijo'];
							$i=$rowEmp['id']."-".$rowEmp['prefijo'];
					 		if($i==$_POST[procesos])
			 				{
						 		echo "  SELECTED";
						 		$_POST[octradicacion]=$rowEmp['nombre'];
						 	}
					  		echo ">".$rowEmp['id']." - ".$rowEmp['nombre']." </option>"; 	 
						}		
					?> 
           		</select> 
            </td>
            <td class="saludo1" style="width:8%">Documento:</td>
            <td style="width:25%">
				<select id="tdocumento" name="tdocumento" class="elementosmensaje" style="width:95%"  onKeyUp="return tabular(event,this)" onChange="cargadatos('doc');">
					<option onChange="" value="-">Seleccione....</option>
					<?php	
						$sqlr="SELECT * FROM caldocumentos ORDER BY id ASC  ";
						$res=mysql_query($sqlr,$linkbd);
						while ($rowEmp = mysql_fetch_assoc($res)) 
						{
							echo "<option value= ".$rowEmp['id']."-".$rowEmp['prefijo'];
							$i=$rowEmp['id']."-".$rowEmp['prefijo'];
					 		if($i==$_POST[tdocumento])
			 				{
						 		echo "  SELECTED";
						 		$_POST[octradicacion]=$rowEmp['nombre'];
						 	}
					  		echo ">".$rowEmp['id']." - ".$rowEmp['nombre']."</option>"; 	 
						}		
					?> 
           		</select> 
            </td>
            <td style="width:22%" colspan="2">
				<select id="politicas" name="politicas" class="elementosmensaje" style=" <?php if($_POST[estadopo]!=''){ echo ('width:100%; visibility:'.$_POST[estadopo].';');}else{echo ('width:100%; visibility:hidden;');}?>"  onKeyUp="return tabular(event,this)" onChange="document.form2.ocul2.value='';document.form2.submit();"  >
					<option onChange="" value="" >Seleccione....</option>
					<?php	
						$sqlr="SELECT * FROM dominios WHERE nombre_dominio='TIPOS_DE_POLITICAS' ORDER BY valor_inicial ASC  ";
						$res=mysql_query($sqlr,$linkbd);
						while ($rowEmp = mysql_fetch_assoc($res)) 
						{
							echo "<option value= ".$rowEmp['valor_inicial'];
							$i=$rowEmp['valor_inicial'];
					 		if($i==$_POST[politicas])
			 				{
						 		echo "  SELECTED";
						 		$_POST[octradicacion]=$rowEmp['descripcion_valor'];
						 	}
					  		echo ">".$rowEmp['valor_inicial']." - ".$rowEmp['descripcion_valor']."</option>"; 	 
						}		
					?> 
           		</select> 
            </td>
        </tr>
        <tr>
        	<td class="saludo1" >T&iacute;tulo:</td>
   			<td><input id="titulofmt" type="text" name="titulofmt" style="width:95%" value="<?php echo $_POST[titulofmt]?>"></td>
         	<td class="saludo1" style="width:8%">C&oacute;digo SPID:</td>
          	<td > <input id="codigospid" name="codigospid" type="text" value="<?php echo $_POST[codigospid]?>" style="width:95%" readonly></td>
        	<td class="saludo1">C&oacute;digo Alt:</td>
            <td><input id="codigoet" type="text" name="codigoet" style="width:100%" value="<?php echo $_POST[codigoet]?>"></td>
       	</tr>
      </table>
      <table class="inicio"> 
      	<tr>
       		<td class="titulos" colspan="9">Informaci&oacute;n Documento</td>
		</tr> 
         <tr>
        	<td class="saludo1">Fecha Aprobaci&oacute;n:</td>
   			<td style="width:10%"><input name="fechapro" type="date" style="width:95%" value="<?php echo $_POST[fechapro]?>" ></td>
            <td class="saludo1" >Responsable:</td>
   			<td style="width:10%" ><input id="responsable" type="text" name="responsable" style="width:100%" onKeyPress="return solonumeros(event);" onKeyUp="return tabular(event,this)" onBlur="buscares(event)" value="<?php echo $_POST[responsable]?>" onClick="document.getElementById('responsable').focus(); document.getElementById('responsable').select();"></td>
           
            <td colspan="2"style="width:25%" >
				<a href="#" onClick="despliegamodal2('visible');" style="width:25%"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>
				<input name="nresponsable" type="text" value="<?php echo $_POST[nresponsable]?>" style=" width:88.5% " readonly>
			</td>
            <td class="saludo1">Plantilla</td>
   			<td><input type="text" name="nomarch" id="nomarch"  style="width:100%" value="<?php echo $_POST[nomarch]?>" readonly></td>
   			<td>
                <div class='upload'> 
                    <input type="file" name="plantillaad" onChange="document.form2.submit();" />
                    <img src='imagenes/attach.png'  alt='(Cargar)' title='(Cargar)'  /> 
                </div> 
   			</td>
       	</tr>
        <tr>  
            <td class="saludo1">Versi&oacute;n:</td>
            <td>
            	<input name="versiona" type="text" style="width:25; text-align:right;" value="<?php echo $_POST[versiona]?>" onKeyPress="return solonumeros(event);">.<input name="versionb" type="text" style="width:25%;" value="<?php echo $_POST[versionb]?>" onKeyPress="return solonumeros(event);">
            </td>
            <td class="saludo1">Versi&oacute;n Anterior:</td>        
   			<td>
           		<input id="versionanta" name="versionanta" type="text" style="width:25%; text-align:right;"  onkeypress="return solonumeros(event);" value="<?php echo $_POST[versionanta]?>" readonly >.<input id="versionantb" name="versionantb" type="text" style="width:25%"  onkeypress="return solonumeros(event);" value="<?php echo $_POST[versionantb]?>" readonly>
            </td>
            <td class="saludo1" style="width:10%">Mejora o Cambio:</td>
            <td><input type="checkbox" name="mejcam" id="mejcam" <?php if(isset($_REQUEST['mejcam'])){echo "checked";} ?> value="<?php echo $_POST[mejcam]?>" /></td>
   		</tr>
        
	</table>
    <table class="inicio"> 
      	<tr>
       		<td class="titulos" >Descripci&oacute;n, mejoras y cambios realizados</td>
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
    <input type="hidden" name="bres" value="<?php echo $_POST[bres]?>">
    <input id="cargat" name="cargat" type="hidden" value="<?php echo $_POST[cargat]?>">
    <input id="arcori" name="arcori" type="hidden" value="<?php echo $_POST[arcori]?>">
    <input type="hidden" name="oculto" value="1">
    <input type="hidden" name="ocul2" value="1">
	<?php  
		//********guardar
 		if($_POST[oculto]=="2")
		{	if($_POST[idanterior]!="")
			{
				$sqlr="UPDATE calgestiondoc SET estado='N' WHERE id='".$_POST[idanterior]."' AND proceso='".$_POST[preprocesoid]."' AND documento='".$_POST[predocumentoid]."' AND politicas='".$_POST[politicas]."'";mysql_query($sqlr,$linkbd);
			}
			$sqlr="INSERT INTO calgestiondoc (id,proceso,documento,politicas,codigospid,codigoalt,titulo,idarchivo,estado) VALUES ('$_POST[codigo]', '$_POST[preprocesoid]','$_POST[predocumentoid]','$_POST[politicas]','$_POST[codigospid]','$_POST[codigoet]','$_POST[titulofmt]','$_POST[idarchivo]', 'S') ";
			if (!mysql_query($sqlr,$linkbd))
			{echo "<script>alert('ERROR EN LA CREACION DEL ANEXO');document.form2.nombre.focus();</script>";echo $sqlr;}
			else
			{
				if(isset($_REQUEST['mejcam'])){$checkmejora=1;}else{$checkmejora=0;}
				if($_POST[versiona]!="" && $_POST[versionb]!=""){$vers1=$_POST[versiona].".".$_POST[versionb];}
				else{$vers1="";}
				if($_POST[versionanta]!="" && $_POST[versionantb]!=""){$vers2=$_POST[versionanta].".".$_POST[versionantb];}
				else{$vers2="";}
				$trozos = explode(".",$_POST[nomarch]);  
				$extension = end($trozos);  
				$nomar=$_POST[codigospid].".".$extension;
				if ($_POST[arcori]==$_POST[nomarch]){$dircarga="informacion/calidad_documental/documentos/";}
				else{$dircarga="informacion/calidad_documental/temp/";}
				copy($dircarga.$_POST[nomarch],("informacion/calidad_documental/documentos/".$nomar));
				$sqlr2="INSERT INTO callistadoc(id,codigospid,version,versionant,fechaprov,idresponsable,nomarchivo,estado,fechamejora,cambios,mejocam) VALUES ('$_POST[idarchivo]', '$_POST[codigospid]','$vers1','$vers2','$_POST[fechapro]','$_POST[responsable]','$nomar','S','', '".$_POST[codigospid].".txt','".$checkmejora."')";
				mysql_query($sqlr2,$linkbd);
				//combertir en .txt	el textarea	
				$ar=fopen("informacion/calidad_documental/cambios/".$_POST[codigospid].".txt","w+") or die("Problemas en la creacion");
				fputs($ar,$_REQUEST['tcambios']);
				fputs($ar,"\n");
				fclose($ar);
				?><script>
					var codigos=parseInt(document.form2.idarchivo.value);
					document.form2.idarchivo.value=codigos+1;
                	document.form2.procesos.value="";
					document.form2.tdocumento.value="";
					document.form2.politicas.value="";
					document.form2.titulofmt.value="";
					document.form2.codigospid.value="";
					document.form2.codigoet.value="";
					document.form2.fechapro.value="";
					document.form2.responsable.value="";
					document.form2.nresponsable.value="";
					document.form2.nomarch.value="";
					document.form2.versiona.value="";
					document.form2.versionb.value="";
					document.form2.versionanta.value="";
					document.form2.versionantb.value="";
					document.form2.tcambios.innerHTML="";
					document.form2.nombre.focus();
                </script><?php
				echo "<table id='ventanamensaje1' style='visibility:visible' class='inicio'><tr><td class='saludo1'><center>Se ha almacenado el Proceso con Exito <img src='imagenes\confirm.png'></center></td></tr></table>";
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
                <a href="javascript:despliegamodal2('hidden')" style="position: absolute; left: 810px; top: 5px; z-index: 100;"><img src="imagenes/exit.png" title="cerrar" width=22 height=22>Cerrar</a>
                <IFRAME  src="meci-gestiondocresponsables.php" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                </IFRAME>
            </div>
        </div>
	</body>
</html>