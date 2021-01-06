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
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9" />
		<title>::SPID-Planeaci&oacute;n Estrat&eacute;gica</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css"/>
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css"/>
		<link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css"/>
		<script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script>
			function despliegamodal2(_valor){document.getElementById("bgventanamodal2").style.visibility=_valor;}
			function busquedajs()
			{if (document.form2.responsable.value!=""){document.form2.busquedas.value="1";document.form2.submit();}}
			function agregardocumento()
			{
				if(document.form2.nomarch.value!="")
				{
					document.getElementById('banmlg').value=parseInt(document.getElementById('banmlg').value)+1;
					document.form2.agregamlg.value=1;
					document.form2.submit();
				}
			 	else {despliegamodalm('visible','2','Falta informaci\xf3n para poder Agregar');}	
			}
			function eliminarml(variable)
			{
				document.form2.idelimina.value=variable;
				despliegamodalm('visible','4','Seguro de Eliminar esta Archivo Adjunto','1');
			}
			function agresponsable()
			{
				if(document.form2.nresponsable.value!="")
				{
					document.getElementById('ban01').value=parseInt(document.getElementById('ban01').value)+1;
					document.form2.agresp.value=1;
					document.form2.submit();
				}
			 	else {parent.despliegamodalm('visible','2','Falta informaci\xf3n del Responsable para poder Agregar');}	
			}
			function eliresponsable(variable)
			{
				document.form2.idelimina.value=variable;
				despliegamodalm('visible','4','Seguro de Eliminar este Responsable','2');
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
			function guardar()
			{
				if(document.getElementById('numrespon').value!="")
				{
					if (document.getElementById('textresp').value!="" && document.getElementById('textresp').value!="Escribe aquí la Respuesta a la solicitud")
						{despliegamodalm('visible','4','Seguro desea Redirigir la Solicitud','4');}
					else
						{despliegamodalm('visible','2','Falta agregar respuesta a la solicitud');}
				}
				else if(document.getElementById('numconsulta').value!=0)
				{despliegamodalm('visible','4','Seguro desea Consultar Informaci\xf3n a otro','5');}
				else
				{
					if(document.getElementById('proceso').value=='AC')
					{document.getElementById('connoln').value=parseInt(document.getElementById('connoln').value)+1;}
					if(document.getElementById('connoln').value==0){var comproceso="LN";}
					else {var comproceso=document.getElementById('procesofin').value;}
					switch(comproceso)
					{
						case "AC":
							if (document.getElementById('textresp').value!="" && document.getElementById('textresp').value!="Escribe aquí la Respuesta a la solicitud")
							{despliegamodalm('visible','4','Seguro desea terminar de responder la solicitud','3');}
							else
							{despliegamodalm('visible','2','Falta agregar respuesta a la solicitud');}
							break;
						case "AR":
							{despliegamodalm('visible','2','Falta agregar un responsable para redirigir');}
							break;
						case "CN":
							{despliegamodalm('visible','2','Falta agregar un responsable consultar');}
							break;
						case "LN":
							if(document.getElementById('ban01').value!=0)
							{despliegamodalm('visible','4','Seguro desea Compartir esta informaci\xf3n','6');}
							else
							{despliegamodalm('visible','2','Falta agregar un responsable para poder Compartir informaci\xf3n');}
							break;
					}
				}
			}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					
					case "1"://Eliminar Archivo Adjunto de la lista
						document.getElementById('banmlg').value=parseInt(document.getElementById('banmlg').value)-1;
						document.form2.iddelad.value=document.form2.idelimina.value;
						document.form2.submit();
						break;
					case "2"://Eliminar Responsable de la lista
						document.getElementById('ban01').value=parseInt(document.getElementById('ban01').value)-1;
						document.form2.eliminaml.value=document.form2.idelimina.value;
						document.form2.submit();
						break;
					case "3"://Contestar la solicitud
						document.form2.oculto.value="1";
						document.form2.submit();
						break;
					case "4"://Redirigir solisitud
						document.form2.oculto.value="2";
						document.form2.submit();
						break;
					case "5"://Consultar solisitud
						document.form2.oculto.value="3";
						document.form2.submit();
						break;
				}
			}
			function funcionmensaje()
			{document.location.href = "plan-actareasbusca.php";}
			function mredirigir(act)
			{
				switch(act)
				{
					case "AC":	document.getElementById('resocul').value="hidden";
								document.getElementById('procesofin').value=act;
								break;
					case "LN":	document.getElementById('resocul').value="visible";
								break;
					default:	document.getElementById('resocul').value="visible";
								document.getElementById('procesofin').value=act;
								break;
				}
				document.getElementById('responsable').value="";
				document.getElementById('nresponsable').value="";
				document.form2.submit();
			}
			function borrarinicio()
			{
				if(document.getElementById('textresp').value=="Escribe aquí la Respuesta a la solicitud")
				{document.getElementById('textresp').value="";}
			}
		</script>
		<?php
			function eliminarDir($carpeta)
			{
				$carpeta2="informacion/documentosradicados/temp/responsables/".$carpeta;
				foreach(glob($carpeta2 . "/*") as $archivos_carpeta)
				{
					if (is_dir($archivos_carpeta)){eliminarDir($archivos_carpeta);}
					else{unlink($archivos_carpeta);}
				}
				rmdir($carpeta2);
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
				<td colspan="3" class="cinta"><a class="mgbt1"><img src="imagenes/add2.png"/></a><a onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a><a onClick="location.href='plan-actareasbusca.php'" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a><a onClick="<?php echo paginasnuevas("plan");?>" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a></td>
			</tr>
		</table>
		<div id="bgventanamodalm" class="bgventanamodalm">
			<div id="ventanamodalm" class="ventanamodalm">
				<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
				</IFRAME>
			</div>
		</div>
		<form name="form2" id="form2" method="post" enctype="multipart/form-data">
			<?php
				if(@ $_POST['oculto']=="")
				{
					$_POST['oculid']=$_GET['idradicado'];
					$_POST['oculres']=$_GET['idresponsable'];
					$_POST['tipoes']=$_GET['tipoe'];
					$_POST['tiprad']=$_GET['tiporad'];
					$_POST['resocul']="hidden";
					$_POST['numrespon']="";
					$ruta="informacion/documentosradicados/temp/responsables/".$_POST['tiprad']."/".$_POST['oculres'];
					if(!file_exists($ruta))
					{mkdir ($ruta);}
					else {eliminarDir($_POST['tiprad']."/".$_POST['oculres']);mkdir ($ruta);}
					$_POST['rutaad']=$ruta."/";
					$sqlr="SELECT codigobarras,narchivosad,estado2 FROM planacradicacion WHERE numeror = '".$_POST['oculid']."' AND tipot='".$_POST['tiprad']."'";
					$row = mysqli_fetch_row(mysqli_query($linkbd,$sqlr));
					$_POST['oculrad']=$row[0];
					$_POST['mararcori']=$row[1];
					$_POST['estrad']=$row[2];
					$rutara="informacion/documentosradicados/".$_POST['tiprad']."/".$_POST['oculrad'];
					$_POST['rutara']=$ruta."/";
					$_POST['banmlg']=0;
					$_POST['ban01']=0;
					$_POST['tabgroup1']=1;
					$_POST['numconsulta']=0;
					$_POST['textresp']="Escribe aquí la Respuesta a la solicitud";
					$_POST['oculto']="0";
					$_POST['procesofin']="AC";
					if (@ $_POST['tipoes']!="CN"){$_POST['connoln']=0;}
					else{$_POST['connoln']=1;}
				}
				switch(@ $_POST['tabgroup1'])
				{
					case 1:
						$check1='checked';break;
					case 2:
						$check2='checked';break;
					case 3:
						$check3='checked';break;
				}
				//*****Agregar Archivo Adjunto A Lista*****************************
				if (@ $_POST['agregamlg']=='1')
				{
					$_POST['nomarchivo'][]=$_POST['nomarch'];
					$_POST['nomarch']="";
					$_POST['agregamlg']='0';
				}
				//******Eliminar Archivo de la Lista********************************
				if (@ $_POST['iddelad']!='')
				{ 
					$posi=$_POST['iddelad'];
					unset($_POST['nomarchivo'][$posi]);
					$_POST['nomarchivo']= array_values($_POST['nomarchivo']); 
					$_POST['iddelad']='';
				}
				//*****Agregar Reponsable en la Lista************************************
				if (@ $_POST[agresp]=='1')
				{
					if(in_array($_POST['responsable'],$_POST['docres']))
					{echo"<script>despliegamodalm('visible','2','Ya se Asigno a este Responsable');</script>";}
					else
					{
						$_POST['docres'][]=$_POST['responsable'];
						$_POST['nomdes'][]=$_POST['nresponsable'];
						$_POST['recargo'][]=$_POST['cargotercero'];
						switch(@ $_POST['proceso'])
						{
							case "AR":
								if($_POST['mararcori']!=""){$_POST['mararcori2']=$_POST['mararcori'];}
								$_POST['lecesc'][]="AR";
								$_POST['numrespon']=$_POST['responsable'];
								$_POST['proceso']="AC";
								$_POST['connoln']++;
								break;
							case "CN":
								$_POST['lecesc'][]="CN";
								$_POST['numconsulta']=$_POST['numconsulta']+1;
								$_POST['connoln']++;break;
							case "LN":
								$_POST['lecesc'][]="LN";break;
						}
						$sqlfun="SELECT id_usu FROM usuarios WHERE cc_usu='".$_POST['responsable']."' AND est_usu='1'";
						$resfun=mysqli_query($linkbd,$sqlfun);
						$numfun=mysqli_num_rows($resfun);
						if($numfun==0){$_POST['estfun'][]="N";}
						else{$_POST['estfun'][]="S";}
						$_POST['responsable']="";
						$_POST['nresponsable']="";
						$_POST['cargotercero']="";
					}
					$_POST['agregamlg']='0';
				}
				//******Eliminar Responsable de la Lista*****************************************
				if (@ $_POST['eliminaml']!='')
				{
					$posi=$_POST['eliminaml'];
					if($_POST['lecesc'][$posi]!="LN"){$_POST['connoln']--;}
					if($_POST['lecesc'][$posi]=="CN"){$_POST['numconsulta']=$_POST['numconsulta']-1;}
					if($_POST['docres'][$posi]==$_POST['numrespon']){$_POST['numrespon']="";$_POST['mararcori2']="";}
					unset($_POST['docres'][$posi]);
					unset($_POST['nomdes'][$posi]);
					unset($_POST['lecesc'][$posi]);
					unset($_POST['estfun'][$posi]);
					unset($_POST['recargo'][$posi]);
					$_POST['docres']= array_values($_POST['docres']); 
					$_POST['nomdes']= array_values($_POST['nomdes']);
					$_POST['lecesc']= array_values($_POST['lecesc']); 
					$_POST['estfun']= array_values($_POST['estfun']); 
					$_POST['recargo']= array_values($_POST['recargo']);
				}
				//******Busqueda Por Documento****************************************
				if (@ $_POST['busquedas']!="")
				{
					$sqlid="SELECT codigo FROM planacresponsables WHERE codradicacion='".$_POST['oculid']."' AND usuariocon='".$_POST['responsable']."'";
					$resid=mysqli_query($linkbd,$sqlid);
					if (mysqli_num_rows($resid)>0)
					{
						echo"<script>despliegamodalm('visible','2','El funcionario ya tiene una actividad asignada en esta Radicaci\xf3n ');</script>";
					}	
					else
					{
						$nresul=buscaresponsable($_POST['responsable']);
						if($nresul!=''){$_POST['nresponsable']=$nresul;}
						else
						{
							$_POST['nresponsable']="";
							echo"<script>despliegamodalm('visible','2','No existe o est\xe1 vinculado un funcionario con este documento');</script>";	
						}
						$_POST['busquedas']="";
					}
				}
			?>
			<input type="hidden" name="ban01" id="ban01" value="<?php echo @ $_POST['ban01'];?>"/>
			<input type="hidden" name="banmlg" id="banmlg" value="<?php echo @ $_POST['banmlg'];?>"/>
			<input type="hidden" name="procesofin" id="procesofin" value="<?php echo @ $_POST['procesofin'];?>"/>
			<input type="hidden" name="connoln" id="connoln" value="<?php echo @ $_POST['connoln'];?>"/>
			<div class="tabsmeci"  style="height:76.5%; width:99.6%">
				<div class="tab">
					<input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo @ $check1;?> >
					<label for="tab-1">Informaci&oacute;n</label>
					<div class="content" style="overflow:hidden;">
						<div class="subpantallac5" style="height:99%; overflow-x: hidden;">	
							<?php
								$sqlr="SELECT * FROM planacradicacion WHERE numeror='".$_POST['oculid']."' AND tipot='".$_POST['tiprad']."'";
								$res=mysqli_query($linkbd,$sqlr);
								$row = mysqli_fetch_row($res);
								$sqlr2="SELECT nombre FROM plantiporadicacion WHERE codigo='$row[5]'";
								$res2=mysqli_query($linkbd,$sqlr2);
								$row2 = mysqli_fetch_row($res2);
								$trtipo=$row2[0];
								$sqlr2="SELECT usuarioasig,usuariocon,fechasig,consulta,proceso FROM planacresponsables WHERE codigo='".$_POST['oculres']."'";
								$res2=mysqli_query($linkbd,$sqlr2);
								$row2 = mysqli_fetch_row($res2);
								$trasig=buscaresponsable($row2[0]);
								$trcont=buscaresponsable($row2[1]);
								$trtercero=buscatercero($row[7]);
								$trradicador=buscaresponsable($row[4]);
								$fecha01=explode('-',date("d-m-Y"));
								$fecha01g=gregoriantojd($fecha01[1],$fecha01[0],$fecha01[2]);
								$fecha02=explode('-',date('d-m-Y',strtotime($row[6])));
								$fecha02g=gregoriantojd($fecha02[1],$fecha02[0],$fecha02[2]);
								if($fecha02g<=$fecha01g)
								{
									$estadodoc='<img src="imagenes/sema_rojoON.jpg" style="height:20px;"> VENCIDO';
									$imgestado="trabajos02.png";
								}
								else 
								{
									$estadodoc='<img src="imagenes/sema_amarilloON.jpg" style="height:22px;"> PENDIENTE';
									$imgestado="trabajos01.png";
								}
								$_POST['codrad']=$row[1];
								$_POST['oculcodigo']=$row[1];
								$_POST['nradicado']=$row[1];
								$_POST['fecharad']=$row[2];
								$_POST['horarad']=$row[3];
								$_POST['tradicacion']=$trtipo;
								$_POST['fechares']=$row[6];
								$_POST['raddescri']=$row[8];
								if($row[9]==1) {$check01="checked";}
								if($row[10]==1) {$check02="checked";}
								if($row[11]==1) {$check03="checked";}
								$_POST['contarch']=$row[18];
								$_POST['radpor']=$trradicador;
								$_POST['tercero1']=$row[7];
								$_POST['ntercero1']=$trtercero;
								$_POST['ndirecc']=$row[14];
								$_POST['ncorreoe']=$row[15];
								$_POST['ntelefono']=$row[12]; 
								$_POST['ncelular']=$row[13];
								$_POST['asigpor']=$trasig;
								$_POST['fecasig']=$row2[2];
								$_POST['vactividad']=$row2[4];
								$_POST['nresponsable1']=$trcont;
								if($row2[3]!=''){$_POST['nsolicitud']=$row2[3];}
								else {$_POST['nsolicitud']='Responder Radicación';}
							?>
							<table class="inicio">
								<tr>
									<td colspan="7" class="titulos">:.Informaci&oacute;n B&aacute;sica Documento Radicado</td>
									<td class="cerrar" style="width:7%" onClick="location.href='plan-principal.php'">&nbsp;Cerrar</td>
								</tr>
								<tr>
									<td colspan="6" class="titulos2">:.Datos B&aacute;sicos </td>
									<td rowspan="14" colspan="2" style='text-align:center;'><img src="imagenes/<?php echo $imgestado;?>" style="width:90%; height:90%" /></td>
								</tr>
								<tr>
									<td class="tamano01" style="width:3cm;">:&middot; N&deg; Radicaci&oacute;n:</td>
									<td style="width:16%"><input type="text" name="nradicado" id="nradicado" style="width:100%" class="tamano02" value="<?php echo @ $_POST['nradicado']?>" readonly/></td>
									<td class="tamano01" style="width:3cm;">:&middot; Fecha:</td>
									<td style="width:16%"><input type="date" name="fecharad" id="fecharad" style="width:100%;background-color:#E6F7FF;color:#333;border-color:#ccc;" value="<?php echo @ $_POST['fecharad']?>" class="tamano02" readonly/> </td>
									<td class="tamano01" style="width:3cm;" >:&middot; Hora:</td>
									<td style="width:16%"><input type="time" name="horarad" id="horarad" style="width:100%" value="<?php echo @ $_POST['horarad']?>" class="tamano02" readonly/></td>
								</tr>
								<tr>
									<td class="tamano01" style="width:3cm"  >:&middot;Tipo Radicaci&oacute;n:</td>
									<td  colspan="3"><input type="text" name="tradicacion" id="tradicacion" class="tamano02" style="width:100%;text-transform:uppercase;" value="<?php echo @ $_POST['tradicacion']?>" readonly/></td>
									<td class="tamano01" style="width:3cm">:&middot; Fecha L&iacute;mite:</td>
									<td><input type="date" name="fechares" id="fechares" class="tamano02" style="width:100%;background-color:#E6F7FF;color:#333;border-color:#ccc;" value="<?php echo @ $_POST['fechares']?>" readonly/></td>
								</tr>
								<tr>
									<td class="tamano01" >:&middot; Descripci&oacute;n:</td>
									<td colspan="5"><input type="text" id="raddescri" name="raddescri"  style="width:100%;text-transform:uppercase;" value="<?php echo @ $_POST['raddescri']?>" class="tamano02" readonly/></td>
								</tr>
								<tr>
									<td class="tamano01" >:&middot;Actividad:</td>
									<td colspan="5"><input type="text" id="vactividad" name="vactividad"  style="width:100%;text-transform:uppercase;" value="<?php echo @ $_POST['vactividad']?>" class="tamano02" readonly/></td>
								</tr>
								<tr>
									<td class="tamano01" style="width:3cm">:&middot; Respuesta:</td>
									<td class="tamano03" colspan="3">
										<input type="checkbox" name="trescrito" id="trescrito"  class="defaultcheckbox" disabled <?php echo @ $check01;?>/>&nbsp;Escrita &nbsp;&nbsp;&nbsp;&nbsp;
										<input type="checkbox" name="trtelefono" id="trtelefono" class="defaultcheckbox" disabled <?php echo @ $check02;?>/>&nbsp;Telef&oacute;nica &nbsp;&nbsp; &nbsp;&nbsp;
										<input type="checkbox" name="trcorreo" id="trcorreo" class="defaultcheckbox" disabled <?php echo @ $check03;?>/>&nbsp;Correo Electr&oacute;nico 
									</td>
									<td class="tamano01" style="width:3cm">:&middot;Folios:</td>
									<td><input type="text" name="contarch" id="contarch" style="width:100%" class="tamano02" value="<?php echo @ $_POST['contarch']?>" readonly/></td>
								</tr>
								<tr>
									<td class="tamano01" style="width:3cm">:&middot; Radicado Por:</td>
									<td colspan="3"><input type="text" name="radpor" id="radpor" style="width:100%;text-transform:uppercase;" class="tamano02" value="<?php echo @ $_POST['radpor']?>" readonly/></td>
									<td class="tamano01" style="width:3cm">:&middot;Adjuntos:</td>
									<td>
										<?php
											echo "<select id='archiad' name='archiad' class='elementosmensaje' style='width:85%' onKeyUp='return tabular(event,this)'  onChange='document.form2.submit();'>
													<option onChange='' value=''  >Seleccione....</option>";
											$sqlr4="SELECT nomarchivo FROM planacarchivosad WHERE idradicacion='".$_POST['oculid']."' ORDER BY nomarchivo ASC ";
											$res4=mysqli_query($linkbd,$sqlr4);
											while ($row4 = mysqli_fetch_row($res4))
											{
												if("$row4[0]"==$_POST['archiad']){echo "<option value='$row4[0]' SELECTED> - $row4[0] </option>";}
												else {echo "<option value='$row4[0]'> - $row4[0] </option>";}
											}		
											echo "</select>";
											if(@ $_POST['archiad']!="")
											{	
												echo"<a id='arcorig' href='informacion/documentosradicados/".$_POST['tiprad']."/".$_POST['oculrad']."/".$_POST['archiad']."' download><img src='imagenes/descargar.png' title='Descargar Archivo' ></a>";
											}
											else
											{echo'<a id="arcorig"><img src="imagenes/descargard.png" title="Sin Archivo" ></a>';}
										?>
									</td>
								</tr>
								<tr><td colspan="6" class="titulos2">:.Datos Remitente </td></tr>
								<tr>
									<td class="tamano01" >:&middot; Nombre:</td>
									<td><input type="text" name="tercero1" id="tercero1" style="width:100%" value="<?php echo @ $_POST['tercero1']?>"  class="tamano02" readonly></td>
									<td colspan="4"><input type="text" name="ntercero1" id="ntercero1" value="<?php echo @ $_POST['ntercero1']?>" style="width:100%;text-transform:uppercase;" class="tamano02" readonly></td>
								</tr>
								<tr>
									<td class="tamano01">:&middot; Direcci&oacute;n:</td>
									<td colspan="5"><input type="text" name="ndirecc" id="ndirecc" style="width:100%;text-transform:uppercase;" value="<?php echo @ $_POST['ndirecc']?>" class="tamano02" readonly></td>
								</tr>
								<tr>
									 <td class="tamano01">:&middot; Email:</td>
									<td colspan="5"><input type="text" name="ncorreoe" id="ncorreoe" style="width:100%;text-transform:uppercase;" value="<?php echo @ $_POST['ncorreoe']?>" class="tamano02" readonly></td>
								</tr>
								<tr>
									<td class="tamano01">:&middot; Tel&eacute;fono:</td>
									<td><input type="text" name="ntelefono" id="ntelefono" style="width:100%;text-transform:uppercase;" value="<?php echo @ $_POST['ntelefono']?>" class="tamano02" readonly></td>
									<td class="tamano01">:&middot; Celular:</td>
									<td><input type="text" name="ncelular" id="ncelular" style="width:100%;text-transform:uppercase;" value="<?php echo @ $_POST['ncelular']?>" class="tamano02" readonly></td>
								</tr>
								<tr><td colspan="6" class="titulos2">:.Datos Asignaci&oacute;n </td></tr>
								<tr>
									<td class="tamano01" style="width:3cm">:&middot; Asignado Por:</td>
									<td colspan="3"><input type="text" name="asigpor" id="asigpor" style="width:100%;text-transform:uppercase;" class="tamano02" value="<?php echo @ $_POST['asigpor']?>" readonly/></td>
									<td class="tamano01" style="width:3cm">:&middot; Fecha :</td>
									<td><input type="date" name="fecasig" id="fecasig" style="width:100%;background-color:#E6F7FF;color:#333;border-color:#ccc;" class="tamano02" value="<?php echo @ $_POST['fecasig']?>" readonly/></td>
								</tr>
								<tr>
									<td class="tamano01" style="width:3cm">:&middot; Responsable:</td>
									<td colspan="3"><input type="text" name="nresponsable1" id="nresponsable1" style="width:100%;text-transform:uppercase;" class="tamano02" value="<?php echo @ $_POST['nresponsable1']?>" readonly/></td>
									<td class="tamano01" style="width:3cm">:&middot; Estado :</td>
									<td class="tamano03" style="text-transform:uppercase;"><?php echo $estadodoc;?></td>
								</tr>
								<tr>
									<td class="tamano01" style="width:3cm">:&middot; Solicitud:</td>
									<td colspan="5"><input type="text" name="nsolicitud" id="nsolicitud" style="width:100%;text-transform:uppercase;f" class="tamano02" value="<?php echo @ $_POST['nsolicitud']?>" readonly/></td>
								</tr>
							</table>
						</div>
					</div>
				</div> 
				<div class="tab">
					<input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo @ $check2;?> >
					<label for="tab-2">Historial</label>
					<div class="content" style="overflow:hidden;">
						<div class="subpantallac5" style="height:99%; overflow-x: hidden;">	
							<?php
								//Historial*****************************************************************************************
								$sqlr2="SELECT * FROM planacresponsables WHERE codradicacion='".$_POST['oculid']."' AND tipot='".$_POST['tiprad']."' ORDER BY idhistory DESC, codigo DESC";
								$res2=mysqli_query($linkbd,$sqlr2);
								$iter='zebra1';
								$iter2='zebra2';
								$iter3='saludo12';
								$ntr = mysqli_num_rows($res2);
								$cont=1;
								if($ntr > 0)
								{
									echo "
									<table class='inicio'>
										<tr>
											<td class='titulos' colspan='12'>:.Historial</td>
										</tr>
										<tr>
											<td class='titulos2' style='width:3%' rowspan='2'>Item</td>
											<td class='titulos2' colspan='2' style='text-align:center;'>Asignaci&oacute;n</td>
											<td class='titulos2' colspan='2' style='text-align:center;'>Respuesta</td>
											<td class='titulos2' style='width:20%' rowspan='2'>Asignado Por</td>
											<td class='titulos2' style='width:20%' rowspan='2'>Contestado Por</td>
											<td class='titulos2' rowspan='2'>Solicitud o Respuesta</td>
											<td class='titulos2' style='width:4%' rowspan='2'>Tipo</td>
											<td class='titulos2' style='width:4%' rowspan='2'>Estado</td>
											<td class='titulos2' colspan='2' rowspan='2'>Archivos</td>
										 </tr>
										 <tr>
											<td class='titulos2' style='width:7%'>Fecha</td>
											<td class='titulos2' style='width:7%'>Hora</td>
											<td class='titulos2' style='width:7%'>Fecha</td>
											<td class='titulos2' style='width:7%'>Hora</td>
										 </tr>";
									while ($row2 = mysqli_fetch_row($res2)) 
									{
										$hisasig=buscaresponsable($row2[4]);
										$hiscont=buscaresponsable($row2[5]);
										if ($cont==1){$color=$iter3;}
										else{$color=$iter;}
										$vardisable="";
										switch($row2[6])
										{
											case "LN":
												$estadores='<img src="imagenes/sema_amarilloON.jpg" style="height:20px;" title="Sin Revisar">';
												$vardisable="disabled";
												$imgtip='<img src="imagenes/lectura.png" style="height:20px;" title="Informativa">';
												break;
											case "LS":
												$estadores='<img src="imagenes/sema_verdeON.jpg" style="height:20px;" title="Revisada">';
												$vardisable="disabled";
												$imgtip='<img src="imagenes/lectura.png" style="height:20px;" title="Informativa">';
												break;
											case "AC":
												$estadores='<img src="imagenes/sema_verdeON.jpg" style="height:20px;" title="Contestada">';
												$imgtip='<img src="imagenes/redirigir.png" style="height:20px;" title="Tarea Redirigida">';
												break;
											case "AN":
												$estadores='<img src="imagenes/sema_amarilloON.jpg" style="height:20px;" title="Sin Responder">';
												$imgtip='<img src="imagenes/escritura.png" style="height:20px;" title="Tarea">';
												break;
											case "AR":
												$estadores='<img src="imagenes/sema_amarilloON.jpg" style="height:20px;" title="Redirigida">';
												$imgtip='<img src="imagenes/redirigido.png" style="height:20px;" title="Redirigida">';
												break;
											case "CN":
												$estadores='<img src="imagenes/sema_amarilloON.jpg" style="height:20px;" title="Sin Responder">';
												$imgtip='<img src="imagenes/consulta01.png" style="height:22px;" title="Consulta">';
												break;
											case "CS":
												$estadores='<img src="imagenes/sema_verdeON.jpg" style="height:20px;" title="Contestada">';
												$imgtip='<img src="imagenes/consulta01.png" style="height:22px;" title="Consulta">';
												break;
										}
										if ($row2[8]!=''){$solores=str_replace("&lt;br/&gt;"," ",$row2[8]);}
										else {$solores=str_replace("&lt;br/&gt;"," ",$row2[11]);}
										if($row2[2]!='0000-00-00'){$fecharadst=date('d-m-Y',strtotime($row2[2]));}
										else{$fecharadst='00-00-0000';}
										if($row2[3]!='0000-00-00'){$fecharesst=date('d-m-Y',strtotime($row2[3]));}
										else{$fecharesst='00-00-0000';}
										if($row2[13]!='00:00:00'){$horaradst=date('h:i:s a',strtotime($row2[13]));}
										else{$horaradst=$row2[13];}
										if($row2[14]!='00:00:00'){$horaresst=date('h:i:s a',strtotime($row2[14]));}
										else{$horaresst=$row2[14];}
										echo "
										<tr class='$color' style='text-transform:uppercase'>
											<td >$cont</td>
											<td>$fecharadst</td>
											<td>$horaradst</td>
											<td>$fecharesst</td>
											<td>$horaresst</td>
											<td>$hisasig</td>
											<td>$hiscont</td>
											<td>$solores</td>
											<td style='text-align:center;'>$imgtip</td>
											<td style='text-align:center;'>$estadores</td>
											<td>
												<select id='archiad$row2[0]' name='archiad$row2[0]' class='elementosmensaje' style='width:100%'  onKeyUp='return tabular(event,this)'  onChange='document.form2.submit();' $vardisable >";
												
												$sqlr4="SELECT nomarchivo FROM planarchresponsables WHERE codresponsable='$row2[0]' ORDER BY nomarchivo ASC ";
												$res4=mysqli_query($linkbd,$sqlr4);
												if (mysqli_num_rows($res4)>0)
												{
													echo '<option onChange="" value=""  >Seleccione....</option>';
													cargarchivos();
													while ($row4 = mysqli_fetch_row($res4)) 
													{
														if("$row4[0]"==$_POST["archiad$row2[0]"])
														{echo "<option value='$row4[0]' SELECTED> - $row4[0] </option>";}
														else {echo "<option value='$row4[0]'> - $row4[0] </option>";}
													}		
												}
												else {echo '<option onChange="" value="">Sin Archivos</option>';}
											echo"
												</select>
											</td>
											<td>";
											if((@ $_POST["archiad$row2[0]"])!="")
											{
												echo'<a href="informacion/documentosradicados/responsables/'.$_POST['tiprad'].'/'.$row2[0].'/'.$_POST["archiad".$row2[0]].'" download><img src="imagenes/descargar.png" title="Descargar Archivo" ></a>';
											}
											else
											{echo'<a href="#"><img src="imagenes/descargard.png" title="Sin Archivo" ></a>';}
											echo'</td>
										</tr>';
										$aux=$iter;
										$iter=$iter2;
										$iter2=$aux;
										$cont++;
									}
									echo '</table>';
								}
							?>
						</div>
					</div>
				</div> 
				<div class="tab">
					<input type="radio" id="tab-3" name="tabgroup1" value="3" <?php echo @ $check3;?> >
					<label for="tab-3">Responder</label>
					<div class="content" style="overflow:hidden;">
						<div class="subpantallac5" style="height:99%; overflow: hidden;">
							<table class="inicio" >
								<tr><td colspan="15" class="titulos">Responder a Documento Radicado</td></tr>
								<tr>
									<td class="saludo1"  style="width:10%; height:120px;">Responder:</td>
									<td style="width:90%; height:120px;" colspan="14"><textarea id="textresp" name="textresp" style="width:100%; height:100%;resize:none" onClick="borrarinicio();"><?php echo @ $_POST['textresp'] ?></textarea></td>
								</tr>
								<tr>
									<td class="saludo1">:&middot;Documentos:</td>
									<td colspan="3" style=" width:25%;"><input type="text" name="nomarch" id="nomarch" style="width:100%" value="<?php echo @ $_POST['nomarch']?>" readonly></td>
									<td>
										<div class='upload' style='cursor:pointer;'>
											<input type="file" name="plantillaad" onChange="document.form2.submit();" style='cursor:pointer;' title='Cargar Documento' />
											<img src='imagenes/upload01.png' style="width:18px"/> 
										</div> 
									</td>
									<td style="width:6%"><input name="agregadoc" type="button" value="  Adjuntar " onClick="agregardocumento()"></td>
									<td style="width:9%">
										 <select id="proceso" name="proceso" class="elementosmensaje" onChange="mredirigir(this.value);" <?php if(@ $_POST['numrespon']!="")echo "hidden='true'";?>>
											<option value="AC" <?php if(@ $_POST['proceso']=="AC"){echo "SELECTED ";}if(@ $_POST['numrespon']!=""){echo "hidden";}elseif(@ $_POST['numconsulta']!=0){echo "hidden";}?>>Contestar</option>
											<option value="AR" <?php if(@ $_POST['proceso']=="AR"){echo "SELECTED ";}if (@ $_POST['tipoes']=="CN"){echo "hidden";}elseif(@ $_POST['numrespon']!=""){echo "hidden";}elseif(@ $_POST['numconsulta']!=0){echo "hidden";}?>>Redirigir</option>
											<option value="CN" <?php if(@ $_POST['proceso']=="CN"){echo "SELECTED ";}if(@ $_POST['numrespon']!=""){echo "hidden";}?>>Consultar</option>
											<option value="LN" <?php if(@ $_POST['proceso']=="LN"){echo "SELECTED ";}?>>Mostrar</option>
										</select>
									</td>
									<?php
										if(@ $_POST['resocul']!='hidden' OR @ $_POST['numrespon']!="")
										{
											switch(@ $_POST['proceso'])
											{
												case 'AR': 	echo '<td class="saludo1" style="width:7%">:&middot; Redirigir:</td>';break;
												case 'LN':	echo '<td class="saludo1" style="width:7%">:&middot; Compartir:</td>';break;
												case 'CN':	echo '<td class="saludo1" style="width:7%">:&middot; Consultar:</td>';break;
											}
										}
										else
										{echo '<td style="width:7%"></td>';} 
									?>
									<td style="width:10%">
										<div style="visibility:<?php if(@ $_POST['resocul']=="hidden"){echo "hidden";} elseif(@ $_POST['numrespon']!=""){echo "hidden";} else{echo "visible";}?>">
											<input id="responsable" type="text" name="responsable" style="width:100%" onKeyPress="return solonumeros(event);" onBlur="busquedajs();" value="<?php echo @ $_POST['responsable']?>" onClick="document.getElementById('responsable').focus();document.getElementById('responsable').select();">
											<input type="hidden" value="0" name="bres">
										</div>
									</td>
									<td colspan="4">
										<div style=" visibility:<?php if(@ $_POST['resocul']=="hidden"){echo "hidden";} elseif(@ $_POST['numrespon']!=""){echo "hidden";} else{echo "visible";}?>">
											<a onClick="despliegamodal2('visible','2');" style="cursor:pointer;" title="Listado Funcionarios"><img src="imagenes/find02.png" style="width:20px;"></a>
											<input type="text" name="nresponsable" id="nresponsable" value="<?php echo @ $_POST['nresponsable']?>" style=" width:90% " readonly>
										</div>
									</td>
									<td style="width:7%">
										<div style=" visibility:<?php if(@ $_POST['resocul']=="hidden"){echo "hidden";} elseif(@ $_POST['numrespon']!=""){echo "hidden";} else{echo "visible";}?>">
											<input name="agregamar" type="button" value="  Agregar  " onClick="agresponsable()">
										</div>
									</td>
								</tr>
							</table>
							<input type="hidden" name="cargotercero" id="cargotercero" value="<?php echo @ $_POST['cargotercero']?>"/>
							<section class="subpantallap" style="height:59%; margin-right:5; width:48%;display:block; float:left; overflow-x:hidden;" >
								<table class="inicio" >
									<tr>
										<td colspan="4" class="titulos">Archivos Adjuntos</td>
									</tr>
									<tr>
										<td class="titulos2" style="width:80%;">Nombre del Archivo</td>
										<td class="titulos2" style="width:10%;">Tipo</td>
										<td class="titulos2" style="width:10%;">Eliminar</td>
									</tr>
									<?php
										$iter="saludo1";
										$iter2="saludo2";
										$tam=count(@ $_POST['nomarchivo']);
										for($x=0;$x<$tam;$x++)
										{
											echo "
												<tr class='$iter'>
													<td><input class='inpnovisibles type='text' name='nomarchivo[]' value='".$_POST['nomarchivo'][$x]."' style='width:100%;' readonly></td>
													<td style='text-align:center;'>".traeico($_POST['nomarchivo'][$x])."</td>
													<td><a onclick='eliminarml($x)'><img src='imagenes/del.png'></a></td>
												</tr>";   
											$aux=$iter;
											$iter=$iter2;
											$iter2=$aux;
										}
									?>
								</table>
							</section>
							<section class="subpantallap" style="height:59%; width:48%;display:block; float:left; overflow-x:hidden;" >	
								<table class="inicio">
									<tr>
										<td colspan="5" class="titulos">Redirigir</td>
									</tr>
									<tr>
										<td class="titulos2" style="width:15%;">Documento</td>
										<td class="titulos2" >Nombre</td>
										<td class="titulos2" style="width:8%;">Tipo</td>
										<td class="titulos2" style="width:8%;">Usuario</td>
										<td class="titulos2" style="width:10%;">Eliminar</td>
									</tr>
									<?php
										$iter="saludo1";
										$iter2="saludo2";
										$tam=count(@ $_POST['docres']);
										for($x=0;$x<$tam;$x++)
										{
											switch(@ $_POST['lecesc'][$x])
											{
												case "AR":
													$imglecesc="src='imagenes/redirigir.png' title='Redirigir'";
													break;
												case "CN":
													$imglecesc="src='imagenes/consulta01.png' title='Consulta'";
													break;
												case "LN":
													$imglecesc="src='imagenes/lectura.png' title='Solo Lectura'";
													break;
											}
											if (@ $_POST['estfun'][$x]=="S"){$imgfun="<img src='imagenes/sema_verdeON.jpg ' style=width:20px;' title='Usuario Activo'/>";}
											else{$imgfun="<img src='imagenes/sema_rojoON.jpg' style=width:20px;' title='Usuario Inactivo'/>";}
											echo "
												<input type='hidden' name='docres[]' value='".@ $_POST['docres'][$x]."'/>
												<input type='hidden' name='nomdes[]' value='".@ $_POST['nomdes'][$x]."'/>
												<input type='hidden' name='recargo[]' value='".@ $_POST['recargo'][$x]."'/>
												<input type='hidden' name='lecesc[]' value='".@ $_POST['lecesc'][$x]."'/>
												<input type='hidden' name='estfun[]' value='".@ $_POST['estfun'][$x]."'/>
												<tr class='$iter'>
													<td>".$_POST['docres'][$x]."</td>
													<td>".$_POST['nomdes'][$x]."</td>
													<td style='text-align:center;'><img $imglecesc style='width:20px'/></td>
													<td style='text-align:center;'>$imgfun</td>
													<td style='text-align:center;'><a onclick='eliresponsable($x)'><img src='imagenes/del.png'/></a></td>
												</tr>";
											$aux=$iter;
											$iter=$iter2;
											$iter2=$aux;
										}
									?>
								</table>
							</section>	
						</div>
					</div>
				</div>
			</div>
			<input type="hidden" name="mararcori2" id="mararcori2" value="<?php echo @ $_POST['mararcori2'];?>">
			<input type="hidden" name="mararcori" id="mararcori" value="<?php echo @ $_POST['mararcori'];?>">
			<input type="hidden" name="oculto" id="oculto" value="<?php echo @ $_POST['oculto'];?>">
			<input type="hidden" name="numrespon" id="numrespon" value="<?php echo @ $_POST['numrespon'];?>">
			<input type="hidden" name="numconsulta" id="numconsulta" value="<?php echo @ $_POST['numconsulta'];?>">
			<input type="hidden" name="oculcodigo" id="oculcodigo" value="<?php echo @ $_POST['oculcodigo']?>">
			<input type="hidden" name="oculid" id="oculid" value="<?php echo @ $_POST['oculid']?>">
			<input type="hidden" name="oculres" id="oculres" value="<?php echo @ $_POST['oculres']?>">
			<input type="hidden" name="oculrad" id="oculrad" value="<?php echo @ $_POST['oculrad'];?>">
			<input type="hidden" name="resocul" id="resocul" value="<?php echo@ $_POST['resocul'];?>">
			<input type="hidden" name="codrad" id="codrad" value="<?php echo @ $_POST['codrad'];?>">
			<input type="hidden" name="rutaad" id="rutaad" value="<?php echo @ $_POST['rutaad']?>">
			<input type="hidden" name="rutara" id="rutara" value="<?php echo @ $_POST['rutara']?>">
			<input type="hidden" name="iddelad" id="iddelad" value="<?php echo @ $_POST['iddelad']?>">
			<input type="hidden" name="archivonom" id="archivonom"  value="<?php echo @ $_POST['archivonom']?>">
			<input type="hidden" name="idelimina" id="idelimina" value="<?php echo @ $_POST['idelimina']?>">
			<input type="hidden" name="busquedas" id="busquedas" value="<?php echo @ $_POST['busquedas'];?>">
			<input type="hidden" name="modestado" id="modestado" value="<?php echo @ $_POST['modestado']?>">
			<input type="hidden" name="tipoes" id="tipoes" value="<?php echo @ $_POST['tipoes']?>">
			<input type="hidden" name="tiprad" id="tiprad" value="<?php echo @ $_POST['tiprad']?>">
			<input type="hidden" name="agresp" id="agresp" value="0">
			<input type='hidden' name='eliminaml' id='eliminaml'>
			<input type="hidden" name="agregamlg" value="0">
			<input type="hidden" name="ocudelad"  id="ocudelad" value="1">
			<input type="hidden" name="estrad" id="estrad" value="<?php echo @ $_POST['estrad']?>">
			<?php
				//archivos
				if (is_uploaded_file(@ $_FILES['plantillaad']['tmp_name']))
				{
					echo"<script>document.getElementById('nomarch').value='".$_FILES['plantillaad']['name']."';</script>";
					copy($_FILES['plantillaad']['tmp_name'], $_POST['rutaad'].$_FILES['plantillaad']['name']);
				}
				//guardar ********************************************************************************
 				if(@ $_POST['oculto']=="1")
				{
					//Guardar Usuarios*********************************************************************************
					$fecharado=date("Y-m-d");
					$xconta=count(@ $_POST['docres']);
					$horain=date('H:i:s');
					for($x=0;$x<$xconta;$x++)
					{	
						$conhis=selconsecutivohres($_POST['oculid']);
						$numid=selconsecutivo('planacresponsables','codigo');
						$sqlr = "INSERT INTO planacresponsables (codigo,codradicacion,fechasig,fechares,usuarioasig,usuariocon,estado,archivos, respuesta,codcargo,tipot,consulta,idhistory,horasig,horresp,proceso) VALUES ('$numid','".$_POST['oculid']."','$fecharado','','".$_SESSION['cedulausu']."','".$_POST['docres'][$x]."','LN','','','".$_POST['recargo'][$x]."','".$_POST['tiprad']."','','$conhis','$horain','','')";
						mysqli_query($linkbd,$sqlr);
					}
					//guardar la respuesta********************************************************************************
					$fechares=date("Y-m-d");
					$contex=preg_replace("/\n/","&lt;br/&gt;",$_POST["textresp"]);
					$conhis=selconsecutivohres($_POST['oculid']);
					if (@ $_POST['tipoes']=="CN")
					{
						$sqlr="UPDATE planacresponsables SET estado='CS',fechares='$fechares',respuesta='$contex',idhistory='$conhis', horresp='$horain' WHERE codigo='".$_POST['oculres']."'";
					}
					else
					{
						$sqlr="UPDATE planacradicacion SET estado='AC' WHERE numeror='".$_POST['oculid']."' AND tipot='".$_POST['tiprad']."'"; 
						$res=(mysqli_query($linkbd,$sqlr));
						$sqlr="UPDATE planacresponsables SET estado='AC', fechares='$fechares', respuesta='$contex', idhistory='$conhis' WHERE codigo='".$_POST['oculres']."'";
					}
					$res=(mysqli_query($linkbd,$sqlr));
					//guarda Los archivos y crear .zip***********************************************************************
					$yconta=count($_POST['nomarchivo']);
					if($yconta>0)
					{
						zipplan::zipcrear2($_POST['rutaad'],$_POST['oculres'],$_POST['nomarchivo'],$_POST['tiprad']);
						for($y=0;$y<$yconta;$y++)
						{
							$numid=selconsecutivo('planarchresponsables','codigo');
							$sqlr = "INSERT INTO planarchresponsables (codigo,codresponsable,nomarchivo) VALUES ('$numid','".$_POST['oculres']."', '".$_POST['nomarchivo'][$y]."')";
							mysqli_query($linkbd,$sqlr);
						}
					}
					$_POST['oculto']=="0";
					if(@ $_POST['estrad']==0)
					{
						$sqlr="UPDATE planacradicacion SET estado2='2' WHERE numeror='".$_POST['oculid']."' AND tipot='".$_POST['tiprad']."'";
						mysqli_query($linkbd,$sqlr);
					}
					echo"<script>despliegamodalm('visible','1','Se Contesto con Exito La Solicitud');</script>";
				}
				//Redirigir********************************************************************************
 				if(@ $_POST['oculto']=="2")
				{
					//guardar la respuesta********************************************************************************
					$contex=preg_replace("/\n/","&lt;br/&gt;",$_POST["textresp"]);
					$fecharado=date("Y-m-d");
					$horain=date('H:i:s');
					$xconta=count($_POST['docres']);
					for($x=0;$x<$xconta;$x++)
					{	
						if($_POST['lecesc'][$x]=="LN"){$vallecesc="LN";}
						else{$vallecesc="AR";}
						$conhis=selconsecutivohres($_POST['oculid']);
						$numid=selconsecutivo('planacresponsables','codigo');
						$sqlr = "INSERT INTO planacresponsables (codigo,codradicacion,fechasig,fechares,usuarioasig,usuariocon, estado,archivos,respuesta,codcargo,tipot,consulta,idhistory,horasig,horresp,proceso) VALUES ('$numid','".$_POST['oculid']."','$fecharado','', '".$_SESSION['cedulausu']."','".$_POST['docres'][$x]."','$vallecesc','','','".$_POST['recargo'][$x]."','".$_POST['tiprad']."','$contex', '$conhis', '$horain','','')";
						mysqli_query($linkbd,$sqlr);
					}
					$fechares=date("Y-m-d");
					$conhis=selconsecutivohres($_POST['oculid']);
					$sqlr="UPDATE planacresponsables SET estado='AC', fechares='$fechares', respuesta='$contex', idhistory='$conhis', horresp='$horain' WHERE codigo='".$_POST['oculres']."'";
					$res=(mysqli_query($linkbd,$sqlr));
					
					$sqlr="UPDATE planacradicacion SET archivos='$numid', narchivosad='".$_POST['mararcori2']."' WHERE numeror='".$_POST['oculid']."' AND tipot='".$_POST['tiprad']."'"; 
					$res=(mysqli_query($linkbd,$sqlr));
					$_POST['oculto']=="0";
					if(@ $_POST['estrad']==0)
					{
						$sqlr="UPDATE planacradicacion SET estado2='2' WHERE numeror='".$_POST['oculid']."' AND tipot='".$_POST['tiprad']."'";
						mysqli_query($linkbd,$sqlr);
					}
					echo"<script>despliegamodalm('visible','1','Se Redirigi\xf3 con Exito La Solicitud');</script>";
				}
				//Consultar********************************************************************************
 				if(@ $_POST['oculto']=="3")
				{
					$fecharado=date("Y-m-d");
					$horain=date('H:i:s');
					$xconta=count(@ $_POST['docres']);
					$contex=preg_replace("/\n/","&lt;br/&gt;",$_POST["textresp"]);
					for($x=0;$x<$xconta;$x++)
					{	
						if($_POST['lecesc'][$x]=="LN"){$vallecesc="LN";}
						else{$vallecesc="CN";}
						$conhis=selconsecutivohres($_POST['oculid']);
						$numid=selconsecutivo('planacresponsables','codigo');
						$sqlr = "INSERT INTO planacresponsables (codigo,codradicacion,fechasig,fechares,usuarioasig,usuariocon, estado,archivos,respuesta,codcargo,tipot,consulta,idhistory,horasig,horresp) VALUES ('$numid','".$_POST['oculid']."','$fecharado','','".$_SESSION['cedulausu']."','".$_POST['docres'][$x]."','$vallecesc','','','".$_POST['recargo'][$x]."','".$_POST['tiprad']."','$contex','$conhis','$horain','')";
						mysqli_query($linkbd,$sqlr);
					}
					$conhis=selconsecutivohres($_POST['oculid']);
					$sqlr="UPDATE planacresponsables SET respuesta='Realizo Consulta', idhistory='$conhis', horresp='$horain' WHERE codigo='".$_POST['oculres']."'";
					$res=(mysqli_query($linkbd,$sqlr));
					$_POST['oculto']=="0";
					if(@ $_POST['estrad']==0)
					{
						$sqlr="UPDATE planacradicacion SET estado2='2' WHERE numeror='".$_POST['oculid']."'";
						mysqli_query($linkbd,$sqlr);
					}
					echo"<script>despliegamodalm('visible','1','Se envi\xf3 la Consulta con Exito');</script>";
				}
				//*****************************************************************
			?>
        </form>
		<div id="bgventanamodal2">
			<div id="ventanamodal2">
                <IFRAME  src="plan-acresponsables.php<?php echo "?id=".$_POST[oculid]."&pro=".$_POST[proceso]; ?>" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                </IFRAME>
            </div>
        </div>
	</body>
</html>