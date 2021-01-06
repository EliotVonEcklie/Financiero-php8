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
		<meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>::SPID-Planeaci&oacute;n Estrat&eacute;gica</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css"/>
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css"/>
		<link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css"/>
		<script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script type="text/javascript" src="funcioneshf.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script type='text/javascript' src='JQuery/jquery-2.1.4.min.js'></script>
		<script type="text/javascript" src="JQuery/alphanum/jquery.alphanum.js"></script>
		<script>
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
						case "5":
							document.getElementById('ventanam').src="ventana-comentarios.php?infor="+mensa+"&bas=fulanita";break;	
					}
				}
			}
		 	function busquedajs(tipo)
			{
				if(tipo=="1"){}
				else {if (document.form2.responsable.value!=""){document.form2.busquedas.value=tipo;document.form2.submit();}}
			}
			function despliegamodal2(_valor,_tipo)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else if(_tipo=="1"){}
				else {document.getElementById('ventana2').src="plan-tareasvenresponsable.php";}
			}
			function buscares(e)
			{
				if (document.form2.responsable.value!="")
				{
					document.form2.bres.value='1';
					document.form2.submit();
				}
			}
			function numradicado(d)
			{
				var diab=d.getDate();
				var semb=d.getDay();
				var mesb=d.getMonth()+1;
				var anob=d.getFullYear();
				if (mesb <10) mesb="0"+mesb;
				return(anob+""+mesb+""+diab);
			}
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
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					
					case "1":
					{
						document.getElementById('banmlg').value=parseInt(document.getElementById('banmlg').value)-1;
						document.form2.iddelad.value=document.form2.idelimina.value;
						document.form2.submit();
					}break;//Eliminar Archivo Adjunto de la lista
					case "2":
					{
						document.getElementById('ban01').value=parseInt(document.getElementById('ban01').value)-1;
						document.form2.eliminaml.value=document.form2.idelimina.value;
						document.form2.submit();
					}break;//Eliminar Responsable de la lista
					case "3":
					{
						document.form2.oculto.value="1";
						document.form2.submit();
					}break;//Guardar Tarea
					case "4":
					{
						document.form2.modestado.value=document.form2.idelimina.value;;
						document.form2.submit();
					}break;//Modificar Estado Lectura Escritura Responsables
				}
			}
			function guardar()
			{
				var conproce="no";
				if(document.getElementById('actescritura').value=="si"){conproce="si";}
				else {despliegamodalm('visible','2','Debe asignar un Responsable para dar respuesta a la solicitud');}
				if( document.form2.adjuntosn.value=="S")
				{
					if( document.form2.contadjuntos.value!="0"){var pasoadj="SI";}
					else {var pasoadj="NO";}
				}
				else {var pasoadj="SI";}
				if(conproce=="si")
				{
					if(document.form2.tradicacion.value!="")
							if(document.form2.raddescri.value!="")
								if(document.getElementById('ban01').value!=0)
										if( pasoadj=="SI"){despliegamodalm('visible','4','Est\xe1 Seguro de Guardar la Radicaci\xf3n','3');}
										else{despliegamodalm('visible','2','Falta adjuntar Un Documento para poder Guardar');}
								else{despliegamodalm('visible','2','Falta agregar Un Responsable para poder Guardar');}
							else{despliegamodalm('visible','2','Falta agregar La Descipci\xf3n para poder Guardar');}
					else{despliegamodalm('visible','2','Falta agregar Tipo de Radicaci\xf3n para poder Guardar');}
				}
			}
			function funcionmensaje()
			{
				//document.location.href = "plan-acradicacionmodificar.php?id="+document.getElementById('nradicadot').value;
				document.location.href = "plan-tareaasignar.php";
			}
			function verificacheck(nomcheck)
			{
				if (document.getElementById(''+nomcheck).checked == false)
				{
					document.getElementById(''+nomcheck).value="0";
					document.getElementById(''+nomcheck).checked=false;
				}
				else 
				{
					document.getElementById(''+nomcheck).value="1";
					document.getElementById(''+nomcheck).checked=true;
				}
				if(document.getElementById('trescrito').checked!=false || document.getElementById('trcorreo').checked!=false || document.getElementById('trtelefono').checked!=false)
				{document.getElementById('tirespuesta').value="1";}
				else {document.getElementById('tirespuesta').value="0";}
			}
		</script>
		<?php
			titlepag();
			function eliminarDir($carpeta)
			{
				$carpeta2="informacion/documentosradicados/temp/".$carpeta;
				foreach(glob($carpeta2 . "/*") as $archivos_carpeta)
				{
					//echo $archivos_carpeta;
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
				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='plan-tareaasignar.php'" class="mgbt"/><img src="imagenes/guarda.png" title="Guardar" onClick="guardar();" class="mgbt"/><img src="imagenes/busca.png" title="Buscar" onClick="location.href='plan-tareabuscar.php'" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" class="mgbt" onClick="<?php echo paginasnuevas("plan");?>"><img src="imagenes/printd.png" style="width:28px; height:25px;" class="mgbt1"/></td>
			</tr>
		</table>
		<div id="bgventanamodalm" class="bgventanamodalm">
			<div id="ventanamodalm" class="ventanamodalm">
				<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"></IFRAME>
			</div>
		</div>
		<form name="form2" id="form2" method="post" enctype="multipart/form-data">
			<?php
				//*****carga inicial de Varibles************************************
				if(@ $_POST['oculto']=="")
				{ 
					$_POST['tabgroup1']=1;
					$_POST['oculid']=$_GET['id'];
					$_POST['estrad']=$_GET['esra'];
					$sqlr="SELECT * FROM planacradicacion WHERE numeror = '".$_POST['oculid']."' AND tipot='TR'";
					$row = mysqli_fetch_row(mysqli_query($linkbd,$sqlr));
					$_POST['nradicado']=$row[1];
					$_POST['fecharad']=date("d-m-Y",strtotime($row[2]));
					$_POST['horarad']=date("h:i a",strtotime($row[3]));
					$sqlrtp="SELECT nombre FROM plantiporadicacion WHERE codigo='$row[5]'";
					$rowtp = mysqli_fetch_row(mysqli_query($linkbd,$sqlrtp));
					$_POST['tradicacion']=$rowtp[0];
					if ($row[6]=="0000-00-00") {$_POST['fechares']="SIN LIMITE";}
					else {$_POST['fechares']=date("d/m/Y",strtotime($row[6]));}
					$_POST['raddescri']=$row[8];
					$_POST['trescrito']=$row[9];
					$_POST['trtelefono']=$row[10];
					$_POST['trcorreo']=$row[11];
					$_POST['ntelefono']=$row[12];
					$_POST['ncelular']=$row[13];
					$_POST['ndirecc']=$row[14];
					$_POST['ncorreoe']=$row[15];
					$_POST['contarch']=$row[18];
					$_POST['mararcori']=$row[19];
					$sqlrar="SELECT nomarchivo FROM planacarchivosad WHERE idradicacion = '$_POST[oculid]' AND tipot='TR' ORDER BY idarchivoad ASC";
					$resar=mysqli_query($linkbd,$sqlrar);
					while ($rowar = mysqli_fetch_row($resar)){$_POST['nomarchivo'][]=$rowar[0];}
					$sqlres="SELECT usuariocon,estado,proceso FROM planacresponsables WHERE codradicacion = '$_POST[oculid]' AND tipot='TR' ORDER BY codigo ASC";
					$resre=mysqli_query($linkbd,$sqlres);
					while ($rowre = mysqli_fetch_row($resre))
					{
						$_POST['docres'][]=$rowre[0];
						$_POST['nomdes'][]=buscaresponsable($rowre[0]);
						$_POST['estadoes'][]=$rowre[1];
						$_POST['nactividad'][]=$rowre[2];
						$sqlfun="SELECT id_usu FROM usuarios WHERE cc_usu='$rowre[0]' AND est_usu='1'";
						$resfun=mysqli_query($linkbd,$sqlfun);
						$numfun=mysqli_num_rows($resfun);
						if($numfun==0){$_POST['estfun'][]="N";}
						else{$_POST['estfun'][]="S";}
					}
					$_POST['oculto']="0";
					
				}
				//*****************************************************************
				switch(@ $_POST['tabgroup1'])
				{
					case 1:	$check1='checked';break;
					case 2:	$check2='checked';break;
					case 3:	$check3='checked';break;
					case 4:	$check4='checked';break;
				}
				//*****modificar************************************
				if (@ $_POST['modestado']!='')
				{
					if(@ $_POST['camestado']=='E'){$_POST['lecesc'][$_POST['modestado']]="LN";$_POST['actescritura']="no";}
					else 
					{$_POST['lecesc'][$_POST['modestado']]="E";$_POST['actescritura']="si";}
					$_POST['modestado']="";
				}
				//*****Agregar Reponsable en la Lista************************************
				if (@ $_POST['agresp']=='1')
				{
					$_POST['docres'][]=$_POST['responsable'];
					$_POST['nomdes'][]=$_POST['nresponsable'];
					$_POST['recargo'][]=$_POST['cargotercero'];
					$_POST['lecesc'][]="E";
					$_POST['actescritura']="si";
					$sqlfun="SELECT id_usu FROM usuarios WHERE cc_usu='".$_POST['responsable']."' AND est_usu='1'";
					$resfun=mysqli_query($linkbd,$sqlfun);
					$numfun=mysqli_num_rows($resfun);
					if($numfun==0){$_POST['estfun'][]="N";}
					else{$_POST['estfun'][]="S";}
					$_POST['responsable']="";
					$_POST['nresponsable']="";
					$_POST['cargotercero']="";
					$_POST['agregamlg']='0';
				}
				//******Eliminar Responsable de la Lista*****************************************
				if (@ $_POST['eliminaml']!='')
				{
					$posi=$_POST['eliminaml'];
					unset($_POST['docres'][$posi]);
					unset($_POST['nomdes'][$posi]);
					unset($_POST['recargo'][$posi]);
					unset($_POST['lecesc'][$posi]);
					unset($_POST['estfun'][$posi]);
					$_POST['docres']= array_values($_POST['docres']);
					$_POST['nomdes']= array_values($_POST['nomdes']);
					$_POST['recargo']= array_values($_POST['recargo']);
					$_POST['lecesc']= array_values($_POST['lecesc']);
					$_POST['estfun']= array_values($_POST['estfun']);
				}
				//*****Agregar Archivo Adjunto A Lista*****************************
				if (@ $_POST['agregamlg']=='1')
				{
					$_POST['nomarchivo'][]=$_POST['nomarch'];
					$_POST['nomarch']="";
					$_POST['agregamlg']='0';
				}
				//******Eliminar Archivo de la Lista*****************************************
				if (@ $_POST['iddelad']!='')
				{
					$posi=$_POST['iddelad'];
					$archivodell=$_POST['rutaad'].$_POST['nomarchivo'][$posi];
					unlink($archivodell);
					unset($_POST['nomarchivo'][$posi]);
					$_POST['nomarchivo']= array_values($_POST['nomarchivo']);
					$_POST['iddelad']='';
				}
				//******Busqueda Por Documento****************************************
				if (@ $_POST['busquedas']!="")
				{
					switch($_POST['busquedas'])
					{
						case 1://***** busca tercero
							break;
						case 2://busca responsable
							$nresul=buscaresponsable($_POST['responsable']);
							if($nresul!=''){$_POST['nresponsable']=$nresul;}
							else
							{
								$_POST['nresponsable']="";
								echo"<script>despliegamodalm('visible','2','No existe o est\xe1 vinculado un funcionario con este documento');</script>";
							}
							break;
					}
					$_POST['busquedas']="";
				}
				//*****************************************************************
			?>
			<input type="hidden" name="ban01" id="ban01" value="<?php echo @ $_POST['ban01'];?>">
			<input type="hidden" name="banmlg" id="banmlg" value="<?php echo @ $_POST['banmlg'];?>">
			<input type="hidden" name="adjuntosn" id="adjuntosn" value="<?php echo @ $_POST['adjuntosn']?>">
			<input type="hidden" name="tirespuesta" id="tirespuesta" value="<?php echo @ $_POST['tirespuesta']?>">
			<div class="tabsmeci"  style="height:76.5%; width:99.6%">
				<div class="tab">
					<input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo @ $check1;?> >
					<label for="tab-1">Informaci&oacute;n General</label>
					<div class="content" style="overflow:hidden;">
						<table class="inicio">
							<tr>
								<td colspan="7" class="titulos">:.Asignar Tarea </td>
								<td class="cerrar" style="width:7%" onClick="location.href='plan-principal.php'">&nbsp;Cerrar</td>
							</tr>
							<tr>
								<td colspan="6" class="titulos2">:.Datos B&aacute;sicos </td>
								<td rowspan="10" colspan="2"><img src="imagenes/trabajos01.png" style="width:95%; height:90%" /></td>
							</tr>
							<tr>
								<td class="tamano01" style="width:3cm;">:&middot; N&deg; Tarea:</td>
								<td style="width:16%">
									<input type="text" name="nradicado" id="nradicado" style="width:100%" class="tamano02" value="<?php echo @ $_POST['nradicado']?>" readonly/>
									<input type="hidden"  name="codbarras" id="codbarras" value="<?php echo @ $_POST['codbarras']?>"/>
								</td>
								<td class="tamano01" style="width:3cm;">:&middot; Fecha:</td>
								<td style="width:16%">
									<input type="text" name="fecharad" id="fecharad" style="width:100%" class="tamano02" readonly>
									<input type="hidden" name="fecharado" id="fecharado">
								</td>
								<script>
									document.getElementById("fecharad").value=fecha_corta2(new Date());
									document.getElementById("fecharado").value=fecha_sinformato(new Date());
								</script>
								<td class="tamano01" style="width:3cm;" >:&middot; Hora:</td>
								<td style="width:16%">
									<input type="text" name="horarad" id="horarad" value="<?php echo $_POST['horarad']?>" style="width:100%" class="tamano02" readonly>
									<input type="hidden" name="horarado" id="horarado">
								</td>
							</tr>
							<tr>
								<td class="tamano01" style="width:3cm" >:&middot;Tipo Tarea:</td>
								<td  colspan="5">
									<input type="text" name="tradicacion" id="tradicacion" value="<?php echo $_POST['tradicacion']?>" style="width:100%" class="tamano02" readonly>
								</td>
							</tr>
							<tr>
								<td class="tamano01" >:&middot; Descripci&oacute;n:</td>
								<td id="areadetexto"  colspan="5" ><textarea id="raddescri" name="raddescri" onClick="borrarinicio();" style="width:100%;height:150px;resize: none;" readonly><?php echo @ $_POST['raddescri'];?></textarea></td>
							</tr>
							<tr>
								<td class="tamano01" style="width:3cm">:&middot; Fecha L&iacute;mite:</td>
								<td>
									<input type="date" name="fechares" id="fechares" class="tamano02" style="width:100%" value="<?php echo @ $_POST['fechares']?>"/>  
								</td>
								<td class="tamano01" style="width:3cm;">:&middot; Hora L&iacute;mite:</td>
								<td style="width:16%"><input type="time" name="horalim" id="horalim" class="tamano02" style="width:100%" value="<?php echo @ $_POST['horalim'];?>">
								</td>
							</tr>
							<tr>
								<td class="tamano01" style="width:3cm">:&middot; Respuesta:</td>
								<td class="tamano03" colspan="3">
									<input type="checkbox" name="trescrito" id="trescrito" value="<?php echo @ $_POST['trescrito'];?>" class="defaultcheckbox" onClick="verificacheck(this.id);"/>&nbsp;Escrita &nbsp;&nbsp;&nbsp;&nbsp;
									<input type="checkbox" name="trtelefono" id="trtelefono" value="<?php echo @ $_POST['trtelefono'];?>" class="defaultcheckbox"  onClick="verificacheck(this.id);"/>&nbsp;Telef&oacute;nica &nbsp;&nbsp; &nbsp;&nbsp;
									<input type="checkbox" name="trcorreo" id="trcorreo" value="<?php echo @ $_POST['trcorreo'];?>" class="defaultcheckbox" onClick="verificacheck(this.id);"/>&nbsp;Correo Electr&oacute;nico &nbsp;&nbsp;&nbsp;&nbsp;
								</td>
							</tr>
							<tr>
								<td class="tamano01" style="width:3cm">:&middot;Medio Recepción:</td>
								<td colspan="3">
									<select name="mdrece" id="mdrece" class="tamano02">
										<option value="N" <?php if(@$_POST['mdrece']=="N"){echo "SELECTED ";}?>>N - Ninguno</option>
										<option value="O" <?php if(@$_POST['mdrece']=="O"){echo "SELECTED ";}?>>O - Oficio</option>
										<option value="F" <?php if(@$_POST['mdrece']=="F"){echo "SELECTED ";}?>>F - Formato PQRSDF</option>
										<option value="E" <?php if(@$_POST['mdrece']=="E"){echo "SELECTED ";}?>>E - Correo Electrónico</option>
										<option value="P" <?php if(@$_POST['mdrece']=="P"){echo "SELECTED ";}?>>P - Pagina WEB</option>
									</select>
									
								</td>
							</tr>
						</table>
					</div>
				</div>
				<div class="tab">
					<input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo @ $check2;?> >
					<label for="tab-2">Responsables</label>
					<div class="content" style="overflow:hidden;" >
						<input type="hidden" name="cargotercero" id="cargotercero" value="<?php echo @ $_POST['cargotercero']?>"/>
						<div style="overflow-x:hidden;">
							<table class="inicio">
								<tr>
									<td colspan="7" class="titulos">Responsables</td>
								</tr>
								<tr>
									<td class="titulos2" style="width:15%;">Documento</td>
									<td class="titulos2" >Nombre</td>
									<td class="titulos2" >Actividades</td>
									<td class="titulos2" style="width:8%;">Tipo</td>
									<td class="titulos2" style="width:8%;">Estado Usuario</td>
								</tr>
								<?php
									$iter="saludo1a";
									$iter2="saludo2";
									$tam=count(@ $_POST['docres']);
									for($x=0;$x<$tam;$x++)
									{
										if(@ $_POST['lecesc'][$x] == "LN"){$imglecesc="src='imagenes/lectura.jpg' title='Solo Lectura'";}
										else {$imglecesc="src='imagenes/escritura.png' title='Responder'"; }
										if (@ $_POST['estfun'][$x]=="S"){$imgfun="<img src='imagenes/usuario01.png' style=width:18px;'/> Activo <img src='imagenes/usuario01.png' style=width:18px;'/>";}
											else{$imgfun="<img src='imagenes/usuario02.png' style=width:18px;'/> Inactivo <img src='imagenes/usuario02.png' style=width:18px;'/>";}
										echo "
											<input type='hidden' name='docres[]' value='".@ $_POST['docres'][$x]."'/>
											<input type='hidden' name='nomdes[]' value='".@ $_POST['nomdes'][$x]."'/>
											<input type='hidden' name='recargo[]' value='".@ $_POST['recargo'][$x]."'/>
											<input type='hidden' name='lecesc[]' value='".@ $_POST['lecesc'][$x]."'/>
											<input type='hidden' name='estfun[]' value='".@ $_POST['estfun'][$x]."'/>
											<tr class='$iter' style='text-transform:uppercase'>
												<td>".$_POST['docres'][$x]."</td>
												<td>".$_POST['nomdes'][$x]."</td>
												<td><textarea name='nactividad[]' style='width:100%; height:50px;resize: none;' readonly>".@ $_POST['nactividad'][$x]."</textarea></td>
												<td style='text-align:center;'>
													<img $imglecesc style='width:20px'/>
												</td>
												<td style='text-align:center;'>$imgfun</td>
											</tr>";
										$aux=$iter;
										$iter=$iter2;
										$iter2=$aux;
									}
								?>
							</table>
						</div>
					</div>
				</div>
				<div class="tab">
					<input type="radio" id="tab-3" name="tabgroup1" value="3" <?php echo @ $check3;?> >
					<label for="tab-3">Archivos Adjuntos</label>
					<div class="content" style="overflow:hidden;">
						<div style="overflow-x:hidden;" >
							<table class="inicio" >
								<tr><td colspan="4" class="titulos">Archivos Adjuntos</td></tr> 
								<tr>
									<td class="titulos2" style="width:80%;">Nombre del Archivo</td>
									<td class="titulos2" style="width:10%;">Tipo</td>
								</tr>
								<?php
									$iter="saludo1a";
									$iter2="saludo2";
									$tam=count(@ $_POST['nomarchivo']);
									for($x=0;$x<$tam;$x++)
									{
										echo "
											<tr class='$iter'>
												<td><input class='inpnovisibles type='text' name='nomarchivo[]' value='".$_POST['nomarchivo'][$x]."' style='width:100%;' readonly></td>
												<td style='text-align:center;'>".traeico($_POST['nomarchivo'][$x])."</td>
											</tr>";
										$aux=$iter;
										$iter=$iter2;
										$iter2=$aux;
									}
								?>
							</table>
						</div>
					</div>
				</div>
			</div>
			<input type="hidden" name="nradicadot" id="nradicadot" value="<?php echo @ $_POST['nradicadot']?>"/>
			<input type="hidden" name="archivonom" id="archivonom" value="<?php echo @ $_POST['archivonom']?>"/>
			<input type="hidden" name="iddelad" id="iddelad" value="<?php echo @ $_POST['iddelad']?>"/>
			<input type="hidden" name="ocudelad" id="ocudelad" value="<?php echo @ $_POST['oculdel']?>"/>
			<input type="hidden" name="refrest" id="refrest" value="<?php echo @ $_POST['refrest']?>"/>
			<input type="hidden" name="rutaad" id="rutaad" value="<?php echo @ $_POST['rutaad']?>"/>
			<input type="hidden" id="oculto" name="oculto" value="<?php echo @ $_POST['oculto']?>"/>
			<input type="hidden" name="busquedas" id="busquedas" value="<?php echo @ $_POST['busquedas'];?>"/>
			<input type="hidden" name="idelimina" id="idelimina" value="<?php echo @ $_POST['idelimina']?>"/>
			<input type="hidden" name="camestado" id="camestado" value="<?php echo @ $_POST['camestado']?>"/>
			<input type="hidden" name="modestado" id="modestado" value="<?php echo @ $_POST['modestado']?>"/>
			<input type="hidden" name="actescritura" id="actescritura" value="<?php echo @ $_POST['actescritura']?>"/>
			<input type="hidden" name="contadjuntos" id="contadjuntos" value="<?php echo @ $_POST['contadjuntos']?>"/>
			<input type="hidden" name="nvigencia" id="nvigencia" value="<?php echo @ $_POST['nvigencia']?>"/>
			<input type='hidden' name='eliminaml' id='eliminaml'/>
			<input type="hidden" name="agresp" id="agresp" value="0"/>
			<input type="hidden" name="agregamlg" value="0"/>
			<?php
				if (@ $_POST['trescrito']=="1"){echo "<script>document.getElementById('trescrito').checked=true;</script>";} 
				if (@ $_POST['trtelefono']=="1"){echo "<script>document.getElementById('trtelefono').checked=true;</script>";}
				if (@ $_POST['trcorreo']=="1"){echo "<script>document.getElementById('trcorreo').checked=true;</script>";}
				//archivos
				if (@ is_uploaded_file($_FILES['plantillaad']['tmp_name'])) 
				{
					echo"<script>document.getElementById('nomarch').value='".$_FILES['plantillaad']['name']."';</script>";
					copy($_FILES['plantillaad']['tmp_name'], $_POST['rutaad'].$_FILES['plantillaad']['name']);
				}
				//guarda la informacion de la Radicación*********************************
				if (@ $_POST['oculto']=="1")
				{	
					$vallecesc="LN";
					$xconta=count(@ $_POST['docres']);
					$yconta=count(@ $_POST['nomarchivo']);
					if($yconta>0){$nomarchivoad=$_POST['codbarras'].".zip";}
					else {$nomarchivoad="Sin Archivo";}
					for($x=0;$x<$xconta;$x++){if($_POST['lecesc'][$x]=="E"){$vallecesc="AN";}}
					$cadtrad=explode("-",$_POST['tradicacion']); 
					$_POST['modestado']="";
					$maxid=selconsecutivo('planacradicacion','id');
					//guarda la informacion general de la radicacion********************************************************
					$sqlr = "INSERT INTO planacradicacion (numeror,codigobarras,fechar,horar,usuarior,tipor,fechalimite,idtercero, descripcionr,tescrito,ttelefono,temail,telefonot,celulart,direcciont,emailt,documento,numeromod,nfolios,narchivosad,estado,tipot,estado2,mrecepcion,id) VALUES ('".$_POST['nradicadot']."', '".$_POST['codbarras']."', '".$_POST['fecharado']."','".$_POST['horarado']."','".$_SESSION['cedulausu']."','$cadtrad[0]', '".$_POST['fechares']."','','".$_POST['raddescri']."','".$_POST['trescrito']."','".$_POST['trtelefono']."', '".$_POST['trcorreo']."','','','','','$nomarchivoad',0,'','', '$vallecesc','TR','0','".$_POST['mdrece']."', '$maxid')";
					$res=(mysqli_query($linkbd,$sqlr));
					//guarda Los responsables********************************************************************************
					for($x=0;$x<$xconta;$x++)
					{
						if(@ $_POST['lecesc'][$x]=="E"){$vallecesc="AN";}
						else{$vallecesc="LN";}
						$numid=selconsecutivo('planacresponsables','codigo');
						$sqlr = "INSERT INTO planacresponsables (codigo,codradicacion,fechasig,fechares,usuarioasig,usuariocon, estado,archivos, respuesta,codcargo,tipot,consulta,idhistory,horasig,horresp,proceso) VALUES ('$numid', '".$_POST['nradicadot']."','".$_POST['fecharado']."','','".$_SESSION['cedulausu']."','".$_POST['docres'][$x]."','$vallecesc','','','".$_POST['recargo'][$x]."','TR','','0','".$_POST['horarado']."','', '".$_POST['nactividad'][$x]."')";
						mysqli_query($linkbd,$sqlr);
					}
					//guarda Los archivos y crear .zip***********************************************************************
					if($yconta>0)
					{
						zipplan::zipcrear($_POST['rutaad'],$_POST['codbarras'].'.zip',$_POST['nomarchivo'],'TR');
						for($y=0;$y<$yconta;$y++)
						{
							$numid=selconsecutivo('planacarchivosad','idarchivoad');
							$sqlr = "INSERT INTO planacarchivosad (idarchivoad,idradicacion,nomarchivo,tipot) VALUES ('$numid','".$_POST['nradicadot']."','".$_POST['nomarchivo'][$y]."','TR')";
							mysqli_query($linkbd,$sqlr);
						}
					}
					$_POST['oculto']="0";
					echo"<script>despliegamodalm('visible','1','Se Guardo con Exito La Radicaci\xf3n');</script>";
				}
			?>
			<script>document.getElementById('contadjuntos').value="<?php echo count($_POST['nomarchivo']);?>";</script>
			<script type="text/javascript">$('#raddescri').alphanum({allow: ''});</script>
			<script type="text/javascript">$('#responsable').numeric({allowThouSep: false,allowDecSep: false,allowMinus:false});</script>
		</form>
		<div id="bgventanamodal2">
			<div id="ventanamodal2">
				<IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
				</IFRAME>
			</div>
		 </div>
	</body>
</html>