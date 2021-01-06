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
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
		<meta http-equiv="X-UA-Compatible" content="IE=9" />
		<title>::SPID-Planeaci&oacute;n Estrat&eacute;gica</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="funcioneshf.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script>
			function mirarad(archivo)
			{
				document.getElementById('archivoad').value=archivo;
				document.form2.submit();
			}
		</script>
		<?php
			titlepag();
			function eliminarDir($carpeta)
			{
				$carpeta2="informacion/documentosradicados/$carpeta";
				foreach(glob($carpeta2 . "/*") as $archivos_carpeta)
				{
					if (is_dir($archivos_carpeta)){eliminarDir($archivos_carpeta);}
					else{unlink($archivos_carpeta);}
				}
				rmdir($carpeta2);
			}
			function cargarchivos($nomcarpeta)
			{
				$nomarccomp="R".$nomcarpeta.".zip";
				$ruta="informacion/documentosradicados/responsables/R$nomcarpeta";
				copy(($ruta.'.zip'),($nomarccomp));
				$zip = new ZipArchive;
				if ($zip->open($nomarccomp) === TRUE){$zip->extractTo(getcwd()."/");$zip->close();} 	
				unlink($nomarccomp);
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
				<td colspan="3" class="cinta"><a class="mgbt1"><img src="imagenes/add2.png"/></a><a class="mgbt1"><img src="imagenes/guardad.png"/></a><a onClick="location.href='plan-actareasbusca.php'" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a><a onClick="<?php echo paginasnuevas("plan");?>" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
			</tr>
		</table>
		<form name="form2" method="post" enctype="multipart/form-data">
			<?php
				if (@ $_POST['oculto']=="")
				{
					$_POST['oculid']=$_GET['idradicado'];
					$_POST['oculres']=$_GET['idresponsable'];
					$_POST['tiprad']=$_GET['tiporad'];
					$ruta="informacion/documentosradicados/responsables/".$_POST['tiprad']."/".$_POST['oculres'];
					$_POST['rutaad']=$ruta."/";
					$sqlr="SELECT codigobarras,estado,estado2 FROM planacradicacion WHERE numeror ='".$_POST['oculid']."' AND tipot='".$_POST['tiprad']."'"; 
					$row = mysqli_fetch_row(mysqli_query($linkbd,$sqlr));
					$_POST['oculrad']=$row[0];
					$_POST['esttra']=$row[1];
					$_POST['estrad']=$row[2];
					$rutara='informacion/documentosradicados/'.$_POST['oculrad'];
					$fechalec=date("Y-m-d");
					$sqllec="UPDATE planacresponsables SET estado='LS', fechares='$fechalec' WHERE estado='LN' AND codigo='".$_POST['oculres']."'";
					$reslec=mysqli_query($linkbd,$sqllec);
					$sqlrrr="UPDATE planacradicacion SET estado2='2' WHERE estado2='0' AND numeror='".$_POST['oculid']."' AND tipot='".$_POST['tiprad']."'";
					mysqli_query($linkbd,$sqlrrr);
					$sqllet="SELECT estado FROM planacresponsables WHERE estado='LN' AND codradicacion='".$_POST['oculid']."' AND tipot='".$_POST['tiprad']."'";
					$numlet=mysqli_num_rows(mysqli_query($linkbd,$sqllet));
					if(@ $_POST['esttra']=='LN' && $numlet==0 )
					{
						$sqllec2="UPDATE planacradicacion SET estado='LS' where estado='LN' AND numeror='".$_POST['oculid']."' AND tipot='".$_POST['tiprad']."'";
						mysqli_query($linkbd,$sqllec2);
					}
					$_POST['tabgroup1']=1;
					$_POST['oculto']="0";
				}
				switch(@ $_POST['tabgroup1'])
				{
					case 1:	$check1='checked';break;
					case 2:	$check2='checked';break;
				}
			?>
			<div class="tabsmeci" style="height:76.5%; width:99.6%">
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
								$sqlr2="SELECT usuarioasig,usuariocon,fechasig,consulta,fechares FROM planacresponsables WHERE codigo='".$_POST['oculres']."'";
								$res2=mysqli_query($linkbd,$sqlr2);
								$row2 = mysqli_fetch_row($res2);
								$trasig=buscaresponsable($row2[0]);
								$trcont=buscaresponsable($row2[1]);
								$trtercero=buscatercero($row[7]);
								$trradicador=buscaresponsable($row[4]);
								if (@ $_POST['estrad']==3)
								{
									$estadodoc='<img src="imagenes/sema_amarilloOFF.jpg" style="height:20px;"> ANULADA';
									$imgestado="trabajos03.png";
								}
								elseif($row2[4]!='')
								{
									$fecha01=explode('-',date('d-m-Y',strtotime($row2[4])));
									$fecha01g=gregoriantojd($fecha01[1],$fecha01[0],$fecha01[2]);
									$fecha02=explode('-',date('d-m-Y',strtotime($row[6])));
									$fecha02g=gregoriantojd($fecha02[1],$fecha02[0],$fecha02[2]);
									$difefecha = $fecha02g - $fecha01g;
									if($difefecha>=0)
									{
										$estadodoc='<img src="imagenes/sema_verdeON.jpg" style="height:22px;"> CONTESTADA';
										$imgestado="trabajos01.png";
									}
									else
									{
										if((@ $_POST['esttra']!='LS')&&(@ $_POST['esttra']!='LN'))
										{
											$estadodoc='<img src="imagenes/sema_rojoON.jpg" style="height:20px;"> VENCIDO';
											$imgestado="trabajos02.png";
										}
										else
										{
											$estadodoc='<img src="imagenes/sema_amarilloON.jpg" style="height:22px;"> PENDIENTE';
											$imgestado="trabajos01.png";
										}
									}
								}
								else
								{
									$fecha01=explode('-',date("d-m-Y"));
									$fecha01g=gregoriantojd($fecha01[1],$fecha01[0],$fecha01[2]);
									$fecha02=explode('-',date('d-m-Y',strtotime($row[6])));
									$fecha02g=gregoriantojd($fecha02[1],$fecha02[0],$fecha02[2]);
									$difefecha = $fecha02g - $fecha01g;
									if($difefecha>=0)
									{
										$estadodoc='<img src="imagenes/sema_amarilloON.jpg" style="height:22px;"> PENDIENTE';
										$imgestado="trabajos01.png";
									}
									else
									{
										if((@ $_POST['esttra']!='LS')&&(@ $_POST['esttra']!='LN'))
										{
											$estadodoc='<img src="imagenes/sema_rojoON.jpg" style="height:20px;"> VENCIDO';
											$imgestado="trabajos02.png";
										}
										else
										{
											$estadodoc='<img src="imagenes/sema_amarilloON.jpg" style="height:22px;"> PENDIENTE';
											$imgestado="trabajos01.png";
										}
									}
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
									<td colspan="5"><input type="text" id="raddescri" name="raddescri" style="width:100%;text-transform:uppercase;" value="<?php echo @ $_POST['raddescri']?>" class="tamano02" readonly/></td>
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
											echo "<select id='archiad' name='archiad' class='elementosmensaje' style='width:85%'  onKeyUp='return tabular(event,this)'  onChange='document.form2.submit();'>
													<option onChange='' value=''>Seleccione....</option>";	
											$sqlr4="SELECT nomarchivo FROM planacarchivosad WHERE idradicacion = '".$_POST['oculid']."' AND tipot='".$_POST['tiprad']."' ORDER BY nomarchivo ASC ";
											$res4=mysqli_query($linkbd,$sqlr4);
											while ($row4 = mysqli_fetch_row($res4))
											{
												if(@ $_POST['archiad']=="$row4[0]"){echo "<option value='$row4[0]' SELECTED> - $row4[0] </option>";}
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
									<td class="tamano03" style="text-transform:uppercase;"><?php echo @ $estadodoc;?></td>
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
									echo '
									<table class="inicio">
										<tr>
											<td class="titulos" colspan="10">:.Historial</td>
										</tr>
										<tr>
											<td class="titulos2" style="width:3%" >Item</td>
											<td class="titulos2" style="width:10%">Fecha Asignaci&oacute;n</td>
											<td class="titulos2" style="width:10%">Fecha Respuesta</td>
											<td class="titulos2" style="width:20%">Asignado Por</td>
											<td class="titulos2" style="width:20%">Contestado Por</td>
											<td class="titulos2" style="width:20%">Solicitud o Respuesta</td>
											<td class="titulos2" style="width:4%">Tipo</td>
											<td class="titulos2" style="width:4%">Estado</td>
											<td class="titulos2" colspan="2" >Archivos</td>
										 </tr>';
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
												$ultrad=selconsecutivohres(@ $_POST['oculid'])-1;
												if ($row2[12]==$ultrad)
												{
													$estadores='<img src="imagenes/sema_verdeON.jpg" style="height:20px;" title="Contestada">';
													$imgtip='<img src="imagenes/escritura.png" style="height:20px;" title="Tarea">';
												}
												else
												{
													$estadores='<img src="imagenes/sema_verdeON.jpg" style="height:20px;" title="Contestada">';
													$imgtip='<img src="imagenes/redirigir.png" style="height:20px;" title="Tarea Redirigida">';
												}
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
										echo "
										<tr class='$color' style='text-transform:uppercase'>
											<td >$cont</td>
											<td >$row2[2]</td>
											<td>$row2[3]</td>
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
												echo'<a href="informacion/documentosradicados/responsables/'.$_POST['tiprad'].'/'.$row2[0].'/'.$_POST["archiad".$row2[0]].'" download><img src="imagenes/descargar.png" title="Descargar Archivo"/></a>';
											}
											else
											{echo'<a href="#"><img src="imagenes/descargard.png" title="Sin Archivo"/></a>';}
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
			<input type="hidden" name="resocul" id="resocul" value="<?php echo @ $_POST['resocul'];?>">
			<input type="hidden" name="codrad" id="codrad" value="<?php echo @ $_POST['codrad'];?>">
			<input type="hidden" name="rutaad" id="rutaad" value="<?php echo @ $_POST['rutaad']?>">
			<input type="hidden" name="rutara" id="rutara" value="<?php echo @ $_POST['rutara']?>">
			<input type="hidden" name="esttra" id="esttra" value="<?php echo @ $_POST['esttra']?>">
			<input type="hidden" name="estrad" id="estrad" value="<?php echo @ $_POST['estrad']?>">
			<input type="hidden" name="tiprad" id="tiprad" value="<?php echo @ $_POST['tiprad']?>">
			<?php
				//archivos
				if (is_uploaded_file(@ $_FILES['plantillaad']['tmp_name'])) 
				{
					echo"<script>document.getElementById('nomarch').value='".$_FILES['plantillaad']['name']."';</script>";
					copy($_FILES['plantillaad']['tmp_name'], $_POST[rutaad].$_FILES['plantillaad']['name']);
				}
			?>
		</form>
		<div id="bgventanamodal2">
			<div id="ventanamodal2">
				<a href="javascript:despliegamodal2('hidden'); " style="position: absolute; left: 810px; top: 5px; z-index: 100;"><img src="imagenes/exit.png" alt="cerrar" width=22 height=22>Cerrar</a>
				<IFRAME  src="plan-acresponsablest.php" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
				</IFRAME>
			</div>
		</div>
	</body>
</html>