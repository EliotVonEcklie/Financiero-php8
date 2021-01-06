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
		<title>:: Spid - Calidad</title>
		<script>
			function verUltimaPos(idcta, filas, filtro){
				var scrtop=$('#divdet').scrollTop();
				var altura=$('#divdet').height();
				var numpag=$('#nummul').val();
				var limreg=$('#numres').val();
				if((numpag<=0)||(numpag==""))
					numpag=0;
				if((limreg==0)||(limreg==""))
					limreg=10;
				numpag++;
				location.href="meci-gestiondocedita.php?idproceso="+idcta+"&scrtop="+scrtop+"&totreg="+filas+"&altura="+altura+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
			}
			function eliminar_arch(cod1,narch,nombredel)
			{
				despliegamodalm('visible','4','Esta Seguro de Eliminar la plantilla de la Clase de Contrato '+nombredel.toUpperCase(),'3');
				document.getElementById('idclase').value=cod1;
				document.getElementById('archdel').value=narch;
				document.getElementById('nomdel').value=nombredel;
			}
			function cambioswitch(id,valor)
			{
				document.getElementById('idestado').value=id;
				if(valor==1){despliegamodalm('visible','4','Desea Activar este Tipo de Documento','1');}
				else{despliegamodalm('visible','4','Desea Desactivar este Tipo de Documento','2');}
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
							document.getElementById('ventanam').src="ventana-consulta2.php?titulos="+mensa+"&idresp="+pregunta;break;	
					}
				}
			}
			function respuestaconsulta(estado,pregunta)
			{
				if(estado=="S")
				{
					switch(pregunta)
					{
						case "1":	document.form2.cambioestado.value="1";break;
						case "2":	document.form2.cambioestado.value="0";break;
						case "3":	document.getElementById('ocudelplan').value="1";break;
					}
				}
				else
				{
					switch(pregunta)
					{
						case "1":	document.form2.nocambioestado.value="1";break;
						case "2":	document.form2.nocambioestado.value="0";break;
						case "3":   document.getElementById('ocudelplan').value="2";break;
					}
				}
				document.form2.submit();
			}
		</script>
		<?php
		$scrtop=$_GET['scrtop'];
		if($scrtop=="") $scrtop=0;
		echo"<script>
			window.onload=function(){
				$('#divdet').scrollTop(".$scrtop.")
			}
		</script>";
		$gidcta="'".$_GET['idcta']."'";
		if(isset($_GET['filtro']))
			$_POST[nombre]=$_GET['filtro'];
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
					<a href="meci-gestiondoc.php" class="tooltip bottom mgbt"><img src="imagenes/add.png"/><span class="tiptext">Nuevo</span></a>
					<a class="tooltip bottom mgbt"><img src="imagenes/guarda.png"  /></a>
					<a onClick="document.form2.submit()" class="tooltip bottom mgbt"><img src="imagenes/busca.png" /><span class="tiptext">Buscar</span></a>
					<a class="tooltip bottom mgbt" onClick="mypop=window.open('meci-principal.php','','');mypop.focus();"><img src="imagenes/nv.png"><span class="tiptext">Nueva Ventana</span></a>
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
		<?php
		if($_GET[numpag]!=""){
			$oculto=$_POST[oculto];
			if($oculto!=2){
				$_POST[numres]=$_GET[limreg];
				$_POST[numpos]=$_GET[limreg]*($_GET[numpag]-1);
				$_POST[nummul]=$_GET[numpag]-1;
			}
		}
		else{
			if($_POST[nummul]==""){
				$_POST[numres]=10;
				$_POST[numpos]=0;
				$_POST[nummul]=0;
			}
		}
		?>
 		<form name="form2" method="post" action="meci-gestiondocbusca.php" enctype="multipart/form-data">
			<input type="hidden" name="cambioestado" id="cambioestado" value="<?php echo $_POST[cambioestado];?>"/>
		  	<input type="hidden" name="nocambioestado" id="nocambioestado" value="<?php echo $_POST[nocambioestado];?>"/>
			<?php
				if($_POST[oculto]=="")
				{
					$_POST[cambioestado]="";
					$_POST[nocambioestado]="";
				}
				//*****************************************************************
				if($_POST[cambioestado]!="")
				{
					if($_POST[cambioestado]=="1")
					{
						$sqlr ="UPDATE calgestiondoc SET estado='S' WHERE  codigospid='$_POST[idestado]'";
						mysql_fetch_row(mysql_query($sqlr,$linkbd)); 
					}
					else 
					{
						$sqlr ="UPDATE calgestiondoc SET estado='N' WHERE codigospid='$_POST[idestado]'";
						mysql_fetch_row(mysql_query($sqlr,$linkbd)); 
					}
					echo"<script>document.form2.cambioestado.value=''</script>";
				}
				//*****************************************************************
				if($_POST[nocambioestado]!="")
				{
					if($_POST[nocambioestado]=="1"){$_POST[lswitch1][$_POST[idestado]]=1;}
					else {$_POST[lswitch1][$_POST[idestado]]=0;}
					echo"<script>document.form2.nocambioestado.value=''</script>";
				}
			?>
			<table  class="inicio ancho" align="center" >
	  			<tr>
					<td class="titulos" colspan="4" width='100%'>:: Buscar Gesti&oacute;n Documental </td>
					<td class="boton02" onclick="location.href='meci-principal.php'">Cerrar</td>
	  			</tr>
	  			<tr>
					<td class="saludo1" style="width:5%">Proceso:</td>
	   				<td style="width:30%"><input type="text" name="nombre" id="nombre" value="<?php echo $_POST[nombre];?>"/></td>
					<td class="saludo1" style="width:13%">C&oacute;digo SPID:</td>
					<td><input type="text" name="documento" id="documento" value="<?php echo $_POST[documento];?>"  maxlength="16"/></td>
	   			</tr>                       
			</table>
			<input name="oculto" id='oculto' type="hidden" value="1">
			<input name="iddel" id="iddel" type="hidden" value="<?php echo $_POST[iddel]?>">
			<input name="ocudel" id="ocudel" type="hidden" value="<?php echo $_POST[ocudel]?>">
			<input name="archdel" id="archdel" type="hidden" value="<?php echo $_POST[archdel]?>">
			<input name="nomdel" id="nomdel" type="hidden" value="<?php echo $_POST[nomdel]?>">
			<input name="idclase" id="idclase" type="hidden" value="<?php echo $_POST[idclase]?>">
			<input name="ocudelplan" id="ocudelplan" type="hidden" value="<?php echo $_POST[ocudelplan]?>">
			<input name="contador" id="contador" type="hidden" value="<?php echo $_POST[contador]?>">
			<input type="hidden" name="idestado" id="idestado" value="<?php echo $_POST[idestado];?>"/>
		 	<input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
	   		<input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
		 	<input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
   			<div class="subpantallac5" style="height:68%; width:99.6%; overflow-x:hidden;">
				<?php
					if($_POST['ocudelplan']=="1")//Eliminar Archivos
					{
						$sqlr="UPDATE callistadoc SET nomarchivo='' WHERE id='$_POST[idclase]'";
						echo "<script>document.form2.ocudelplan.value='2';</script>";
					}
					if (is_uploaded_file($_FILES['upload']['tmp_name'][$_POST[contador]])) //Cargar Archivo
					{	
						$trozos = explode(".",$_FILES['upload']['name'][$_POST[contador]]);  
						$extension = end($trozos);  
						$nomar=$_POST[nomdel].".".$extension;
						copy($_FILES['upload']['tmp_name'][$_POST[contador]], "informacion/calidad_documental/documentos/".$nomar);
						$sqlr="UPDATE callistadoc SET nomarchivo='$nomar' WHERE id='$_POST[idclase]'";
						mysql_query($sqlr,$linkbd);
					}
					$contad=0;
					$crit1=" ";
					$crit2=" ";
					if ($_POST[nombre]!="")
					{
						$sqlr2="SELECT id FROM calprocesos WHERE nombre LIKE '%$_POST[nombre]%'";
						$res2=mysql_query($sqlr2,$linkbd);
						$row2 = mysql_fetch_row($res2);
						$proceso=$row2[0];
						$crit1=" AND (cgd.proceso='$proceso') ";
					}
					if ($_POST[documento]!=""){$crit2=" AND cgd.codigospid LIKE '%$_POST[documento]%' ";}
					$sqlr="SELECT cgd.*, cld.* FROM calgestiondoc cgd, callistadoc cld WHERE cgd.idarchivo=cld.id $crit1 $crit2";
					$resp = mysql_query($sqlr,$linkbd);
					$_POST[numtop]=mysql_num_rows($resp);
					$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
					$sqlr="SELECT cgd.*, cld.* FROM calgestiondoc cgd, callistadoc cld WHERE cgd.idarchivo=cld.id  $crit1 $crit2 ORDER BY cgd.proceso, cgd.id LIMIT $_POST[numpos],$_POST[numres]";
					$resp = mysql_query($sqlr,$linkbd);
					$ntr = mysql_num_rows($resp);
					$con=1;
					$numcontrol=$_POST[nummul]+1;
					if($nuncilumnas==$numcontrol)
					{
						$imagenforward="<img src='imagenes/forward02.png' style='width:17px'>";
						$imagensforward="<img src='imagenes/skip_forward02.png' style='width:16px'>";
					}
					else 
					{
						$imagenforward="<img src='imagenes/forward01.png' style='width:17px' title='Siguiente' onClick='numsiguiente()'>";
						$imagensforward="<img src='imagenes/skip_forward01.png' style='width:16px' title='Fin' onClick='saltocol(\"$nuncilumnas\")'>";
					}
					if($_POST[numpos]==0)
					{
						$imagenback="<img src='imagenes/back02.png' style='width:17px'>";
						$imagensback="<img src='imagenes/skip_back02.png' style='width:16px'>";
					}
					else
					{
						$imagenback="<img src='imagenes/back01.png' style='width:17px' title='Anterior' onClick='numanterior();'>";
						$imagensback="<img src='imagenes/skip_back01.png' style='width:16px' title='Inicio' onClick='saltocol(\"1\")'>";
					}
					echo "
						<table class='inicio' align='center' width='80%'>
							<tr>
								<td colspan='10' class='titulos'>.: Resultados Busqueda:</td>
								<td class='submenu'>
									<select name='renumres' id='renumres' onChange='cambionum();' style='width:100%'>
										<option value='10'"; if ($_POST[renumres]=='10'){echo 'selected';} echo ">10</option>
										<option value='20'"; if ($_POST[renumres]=='20'){echo 'selected';} echo ">20</option>
										<option value='30'"; if ($_POST[renumres]=='30'){echo 'selected';} echo ">30</option>
										<option value='50'"; if ($_POST[renumres]=='50'){echo 'selected';} echo ">50</option>
										<option value='100'"; if ($_POST[renumres]=='100'){echo 'selected';} echo ">100</option>
									</select>
								</td>
							</tr>
							<tr>
								<td colspan='5'>Encontrados: $_POST[numtop]</td>
							</tr>
							<tr>
								<td class='titulos2' style='width:10%'>C&oacute;digo SPID</td>
								<td class='titulos2'>Procesos</td>
								<td class='titulos2' style='width:10%'>Documentos</td>
								<td class='titulos2' style='width:10%'>Pol&iacute;ticas</td>
								<td class='titulos2' style='width:20%'>Titulo</td>
								<td class='titulos2' style='width:5%;text-align:center;' colspan='4'>Plantilla</td>
								<td class='titulos2' style='width:3%'>Versi&oacute;n</td>
								<td class='titulos2' style='width:6%'>Estado</td>
							</tr>";	
					$iter='saludo1a';
					$iter2='saludo2';
					$filas=1;
					while ($row =mysql_fetch_row($resp)) 
					{
						$sqlr2="SELECT nombre FROM calprocesos WHERE id='$row[1]'";
						$res2=mysql_query($sqlr2,$linkbd);
						$row2 = mysql_fetch_row($res2);
						$procesos=$row2[0];
						$sqlr2="SELECT nombre FROM caldocumentos WHERE id='$row[2]'";
						$res2=mysql_query($sqlr2,$linkbd);
						$row2 = mysql_fetch_row($res2);
						$documentos=$row2[0];
						$sqlr2="SELECT descripcion_valor FROM dominios WHERE nombre_dominio='TIPOS_DE_POLITICAS' AND valor_inicial='$row[3]'";
						$res2=mysql_query($sqlr2,$linkbd);
						$row2 = mysql_fetch_row($res2);
						$politicas=$row2[0];

						if($row[8]=='S') {$coloracti="#0F0";$_POST[lswitch1][$row[4]]=0;}
						else {$coloracti="#C00";$_POST[lswitch1][$row[4]]=1;}

						if($gidcta!="")
						{
							if($gidcta=="'".$row[4]."'"){
								$estilo='background-color:#FF9';
							}
							else{
								$estilo="";
							}
						}
						else
						{
							$estilo="";
						}

						if ($row[15]!="")
						{
							$bdescargar="<a href='informacion/calidad_documental/documentos/$row[15]' target='_blank' ><img src='imagenes/descargar.png'  title='(Descargar)' ></a>";
							$beliminar="<a href='#' onClick='eliminar_arch(\"$row[9]\",\"$row[15]\",\"$row[10].\");'><img src='imagenes/cross.png'></a>";
							$bcargar="<div class='upload' style='display:none'><input type='file' name='upload[]'/></div><img src='imagenes/del3.png' >";
						} 
						else
						{
							$bdescargar="<img src='imagenes/vacio2.png' title='(Sin Plantilla)'>";
							$beliminar="<img src='imagenes/del4.png'>";
							$bcargar="<div class='upload'><input type='file' name='upload[]' onFocus='document.form2.contador.value=$contad; document.form2.idclase.value=\"$row[9]\";document.form2.nomdel.value=\"$row[10]\";' onChange='document.form2.submit();' /><img src='imagenes/attach.png'  title='(Cargar)' /> </div>";
						}
						if($row[16]=="N"){$enrepara="<img src='imagenes/b_tblops.png' title='(En Mejora)'>";}
						else{$enrepara="<img src='imagenes/confirm.png' title='(Activo)' title='(Activo)'>";}
						$contad++;
						if($politicas==""){$nombredel="$procesos\\n$documentos";}
						else{$nombredel="$procesos\\n$politicas";}

						$idcta="'".$row[4]."'";
						$numfil="'".$filas."'";
						$filtro="'".$_POST[nombre]."'";
						
						echo "
							<tr class='$iter' onDblClick=\"verUltimaPos($idcta, $numfil, $filtro)\" onMouseOver=\"anterior=this.style.backgroundColor; this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase; $estilo'>
								
								<td class='icoop'>$row[4]</td>
								<td class='icoop'>$procesos</td>
								<td class='icoop'>$documentos</td>
								<td class='icoop'>$politicas</td>
								<td class='icoop'>$row[6]</td>
								<td style='text-align:center;'>$bdescargar</td>
								<td style='text-align:center;'>$bcargar</td>
								<td style='text-align:center;'>$beliminar</td>
								<td style='text-align:center;'>$enrepara</td>
								<td style='text-align:center;'>$row[11]</td>
								<td class='centrartext'><input type='range' name='lswitch1[]' value='".$_POST[lswitch1][$row[4]]."' min ='0' max='1' step ='1' style='background:$coloracti; width:60%' onChange='cambioswitch(\"$row[4]\",\"".$_POST[lswitch1][$row[4]]."\")' /></td>
							</tr>";
						 $con+=1;
						 $aux=$iter;
						 $iter=$iter2;
						 $iter2=$aux;
						 $filas++;
					 }
					echo"
						</table>
						<table class='inicio'>
							<tr>
								<td style='text-align:center;'>
									<a href='#'>$imagensback</a>&nbsp;
									<a href='#'>$imagenback</a>&nbsp;&nbsp;";
					if($nuncilumnas<=9){$numfin=$nuncilumnas;}
					else{$numfin=9;}
					for($xx = 1; $xx <= $numfin; $xx++)
					{
						if($numcontrol<=9){$numx=$xx;}
						else{$numx=$xx+($numcontrol-9);}
						if($numcontrol==$numx){echo"<a href='#' onClick='saltocol(\"$numx\")'; style='color:#24D915'> $numx </a>";}
						else {echo"<a href='#' onClick='saltocol(\"$numx\")'; style='color:#000000'> $numx </a>";}
					}
					echo "		&nbsp;&nbsp;<a href='#'>$imagenforward</a>
									&nbsp;<a href='#'>$imagensforward</a>
								</td>
							</tr>
						</table>";
				?>
			</div>
			<input type="hidden" name="numtop" id="numtop" value="<?php echo $_POST[numtop];?>" />
		</form>
	</body>
</html>