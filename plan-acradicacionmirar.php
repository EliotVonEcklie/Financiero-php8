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
		<title>::SPID-Planeaci&oacute;n Estrat&eacute;gica</title>
		<link href="css/css2.css" rel="stylesheet" type="text/css" />
		<link href="css/css3.css" rel="stylesheet" type="text/css" />
		<link href="css/tabs.css" rel="stylesheet" type="text/css"/> 
		<script type="text/javascript" src="css/programas.js"></script>
		<?php 
		titlepag();
		?>
		<script>
			function iratras()
			{
				var id = <?php echo $_GET[id] ?>;
				location.href="plan-acradicacionbuscar.php?nradicado="+id;
			}
			function pdf()
			{
				var ndoc = document.form2.nradicado.value;
				document.form2.action="plan-acradicacionmirarpdf.php?iddoc="+ndoc;
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
		</script>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("plan");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("plan");?></tr>
			<tr>
				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='plan-acradicacion.php'" class="mgbt"/><img src="imagenes/guardad.png" class="mgbt1"/><img src="imagenes/busca.png" title="Buscar" onClick="location.href='plan-acradicacionbuscar.php'" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" class="mgbt" onClick="<?php echo paginasnuevas("plan");?>"/><img src="imagenes/print.png" title="Imprimir" onClick="pdf()" class="mgbt"/><img src="imagenes/iratras.png" title="Atr&aacute;s" onClick="iratras()" class="mgbt"></a>
				</td>
			</tr>
		</table>
		<form name="form2" id="form2" method="post" enctype="multipart/form-data">
			<?php
				if (@ $_POST['oculto']=="")
				{
					$_POST['oculid']=$_GET['id'];
					$_POST['estrad']=$_GET['esra'];
					$sqlr="SELECT * FROM planacradicacion WHERE numeror = '".$_POST['oculid']."' AND tipot='RA'";
					$row = mysqli_fetch_row(mysqli_query($linkbd,$sqlr));
					$_POST['nradicado']=$row[1];
					$_POST['fecharad']=date("d-m-Y",strtotime($row[2]));
					$_POST['horarad']=date("h:i a",strtotime($row[3]));
					$sqlrtp="SELECT nombre FROM plantiporadicacion WHERE codigo='$row[5]'";
					$rowtp = mysqli_fetch_row(mysqli_query($linkbd,$sqlrtp));
					$_POST['tradicacion']=$rowtp[0];
					if ($row[6]=="0000-00-00") {$_POST['fechares']="SIN LIMITE";}
					else {$_POST['fechares']=date("d/m/Y",strtotime($row[6]));}
					$_POST['tercero']=$row[7];
					$_POST['ntercero']=buscatercero($row[7]);
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
					$sqlrar="SELECT nomarchivo FROM planacarchivosad WHERE idradicacion = '".$_POST['oculid']."' AND tipot='RA' ORDER BY idarchivoad ASC";
					$resar=mysqli_query($linkbd,$sqlrar);
					while ($rowar = mysqli_fetch_row($resar)){$_POST['nomarchivo'][]=$rowar[0];}
					$sqlres="SELECT usuariocon,estado FROM planacresponsables WHERE codradicacion = '".$_POST['oculid']."' AND tipot='RA' ORDER BY codigo ASC";
					$resre=mysqli_query($linkbd,$sqlres);
					while ($rowre = mysqli_fetch_row($resre))
					{
						$_POST['docres'][]=$rowre[0];
						$_POST['nomdes'][]=buscaresponsable($rowre[0]);
						$_POST['estadoes'][]=$rowre[1];
						$sqlfun="SELECT id_usu FROM usuarios WHERE cc_usu='$rowre[0]' AND est_usu='1'";
						$resfun=mysqli_query($linkbd,$sqlfun);
						$numfun=mysqli_num_rows($resfun);
						if($numfun==0){$_POST['estfun'][]="N";}
						else{$_POST['estfun'][]="S";}
					}
					$_POST['tabgroup1']=1;
					$_POST['oculto']="0";
				}
				//*****************************************************************
				switch(@ $_POST['tabgroup1'])
				{
					case 1:
						$check1='checked';break;
					case 2:
						$check2='checked';break;
					case 3:
						$check3='checked';break;
					case 4:
						$check4='checked';break;
				}
			?>
			<input type="hidden" name="mararcori" id="mararcori" value="<?php echo @ $_POST['mararcori'];?>">
			<div class="tabsmeci"  style="height:76.5%; width:99.6%">
				<div class="tab">
					<input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo @ $check1;?> >
					<label for="tab-1">Informaci&oacute;n General</label>
					<div class="content" style="overflow:hidden;">
						<table class="inicio">
							<tr>
								<td height="25" colspan="7" class="titulos" >:.Vista Documento Radicado</td>
								<td class="cerrar" style="width:7%;" onClick="location.href='plan-principal.php'">&nbsp;Cerrar</td>
							</tr>
							<tr>
								<td class="tamano01" style="width:4cm;">:&middot; N&deg; Radicaci&oacute;n:</td>
								<td style="width:16%;"><input type="text" name="nradicado" id="nradicado" style="width:100%" value="<?php echo @ $_POST['nradicado']?>" class="tamano02" readonly/></td>
								<td class="tamano01" style="width:2cm">:&middot; Fecha:</td>
								<td style="width:16%;"><input type="text" name="fecharad" id="fecharad" style="width:100%" value="<?php echo @ $_POST['fecharad'];?>" class="tamano02" readonly></td>
								<td class="tamano01"  style="width:2.5cm">:&middot; Hora:</td>
								<td style="width:16%;"><input type="text" name="horarad" id="horarad" style="width:100%" value="<?php echo @ $_POST['horarad'];?>" class="tamano02" readonly></td>
								<?php
										switch(@ $_POST['estrad'])
										{
											case 'AM': $imgprin="url(imagenes/atencionalc.jpg)";break;
											case 'OF': $imgprin="url(imagenes/atencionalc01.png)";break;
											case 'RO': $imgprin="url(imagenes/atencionalc02.png)";break;
											case 'VE': $imgprin="url(imagenes/atencionalc03.png)";break;
										}
									?>
								<td colspan="2" rowspan="8"  style="background:<?php echo $imgprin;?>; background-repeat:no-repeat; background-position:center; background-size: 90% 100%">

								</td>

							</tr>
							<tr>
								<td class="tamano01" >:&middot;Tipo Radicaci&oacute;n:</td>
								<td colspan="3"><input type="text" name="tradicacion" id="tradicacion" style="width:100%;text-transform:uppercase;" value="<?php echo @ $_POST['tradicacion'];?>" class="tamano02" readonly></td>
								<td class="tamano01"  >:&middot; Fecha L&iacute;mite:</td>
								<td ><input type="text" name="fechares" id="fechares" style="width:100%" value="<?php echo @ $_POST['fechares']?>" class="tamano02" readonly></td>
							</tr>
							<tr>
								<td class="tamano01" >:&middot; Tercero:</td>
								<td><input type="text" name="tercero" id="tercero" style="width:100%" value="<?php echo @ $_POST['tercero']?>" class="tamano02" readonly></td>
								<td colspan="4"><input name="ntercero" type="text" value="<?php echo @ $_POST['ntercero']?>" style="width:100%;text-transform:uppercase;" class="tamano02" readonly></td>
							</tr>
							<tr>
								<td class="tamano01">:&middot; Descripci&oacute;n:</td>
								<td colspan="5"><input id="raddescri" name="raddescri" type="text" style="width:100%;text-transform:uppercase;" value="<?php echo @ $_POST['raddescri']?>" class="tamano02" readonly></td>
							</tr>
							<tr>
								<td class="tamano01">:&middot; Respuesta :</td>
								<td class="tamano03" colspan="3">
									<input type="checkbox" name="trescrito" id="trescrito"  value="<?php echo @ $_POST['trescrito'];?>" class="defaultcheckbox" disabled/>&nbsp;Escrita&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="checkbox" name="trtelefono" id="trtelefono" value="<?php echo @ $_POST['trtelefono']?>" class="defaultcheckbox"  disabled/>&nbsp;Telef&oacute;nica&nbsp;&nbsp; &nbsp;&nbsp;
									<input type="checkbox" name="trcorreo" id="trcorreo" value="<?php echo @ $_POST['trcorreo']?>" class="defaultcheckbox" disabled/>&nbsp;Correo Electr&oacute;nico
								</td>
								<td class="tamano01">:&middot;Folios:</td>
								<td><input type="text" name="contarch" id="contarch" value="<?php echo @ $_POST['contarch']?>" style="width:100%;" class="tamano02" readonly></td>
							</tr>
							<tr>
								<td class="tamano01">:&middot; Direcci&oacute;n Corresp.:</td>
								<td colspan="5"><input type="text" name="ndirecc" id="ndirecc" style="width:100%;text-transform:uppercase;" value="<?php echo @ $_POST['ndirecc']?>" class="tamano02" readonly></td>
							</tr>
							<tr>
								<td class="tamano01" >:&middot; Correo Electr&oacute;nico:</td>
								<td colspan="5"><input type="text" name="ncorreoe" id="ncorreoe" style="width:100%" value="<?php echo @ $_POST['ncorreoe']?>" class="tamano02" readonly></td>
							</tr>
							<tr>
								<td class="tamano01" >:&middot; Tel&eacute;fono:</td>
								<td><input type="text" name="ntelefono" id="ntelefono" style="width:100%" class="tamano02" value="<?php echo @ $_POST['ntelefono']?>" readonly></td>
								<td class="tamano01" >:&middot; Celular:</td>
								<td><input type="text" name="ncelular" id="ncelular" style="width:100%" class="tamano02" value="<?php echo @ $_POST['ncelular']?>" readonly></td>

							</tr>
						</table>
						<?php
							if (@ $_POST['trescrito']=="1"){echo "<script>document.getElementById('trescrito').checked=true;</script>";} 	
							if (@ $_POST['trtelefono']=="1"){echo "<script>document.getElementById('trtelefono').checked=true;</script>";}
							if (@ $_POST['trcorreo']=="1"){echo "<script>document.getElementById('trcorreo').checked=true;</script>";}
						//Historial*****************************************************************************************
						?>
					</div>
				</div>
				<div class="tab">
					<input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo @ $check2;?> >
					<label for="tab-2">Responsables</label>
					<div class="content" style="overflow-x:hidden;">
						<table class="inicio">
							<tr>
								<td colspan="7" class="titulos">Responsables</td>
							</tr>
							<tr>
								<td class="titulos2" style="width:5%;">Item</td>
								<td class="titulos2" style="width:15%;">Documento</td>
								<td class="titulos2" >Nombre</td>
								<td class="titulos2" style="width:5%;">Tipo</td>
								<td class="titulos2" style="width:5%;" title="Documento Original">Original</td>
								<td class="titulos2" style="width:8%;">Estado Usuario</td>
								<td class="titulos2" style="width:5%;">Estado</td>
							</tr>
							<?php
								$iter="saludo1a";
								$iter2="saludo2";
								$con=1;
								$tam=count(@ $_POST['docres']);
								for($x=0;$x<$tam;$x++)
								{
									if(@ $_POST['mararcori']==$_POST['docres'][$x]){$marcador='checked';}
									else {$marcador='';}
									switch (@ $_POST['estadoes'][$x]) 
									{
										case "AC":
											$imgsem="<img src='imagenes/sema_verdeON.jpg' title='Contestada' style='width:20px'/>";
											$imgtip="<img src='imagenes/escritura.png' title='Responder' style='width:20px;'/>";
											break;
										case "AN":
											$imgsem="<img src='imagenes/sema_amarilloON.jpg' title='Pendiante' style='width:20px'/>";
											$imgtip="<img src='imagenes/escritura.png' title='Responder' style='width:20px'/>";
											break;
										case "AR":
											$imgsem="<img src='imagenes/sema_verdeON.jpg' title='Contestado' style='width:20px'/>";
											$imgtip="<img src='imagenes/redirigir.png' title='Redirigido' style='width:20px'/>";
											break;
										case "LN":
											$imgsem="<img src='imagenes/sema_amarilloON.jpg' title='Sin Revisar' style='width:20px'/>";
											$imgtip="<img src='imagenes/lectura.jpg' title='Solo Lectura'style='width:20px'/>";
											break;
										case "LS":
											$imgsem="<img src='imagenes/sema_verdeON.jpg' title='Revisado' style='width:20px'/>";
											$imgtip="<img src='imagenes/lectura.jpg' title='Solo Lectura' style='width:20px'/>";
											break;
										case "CN":
											$imgsem="<img src='imagenes/sema_amarilloON.jpg' title='Sin Contestar' style='width:20px'/>";
											$imgtip="<img src='imagenes/consulta01.png' title='Consulta'style='width:20px'/>";
											break;
										case "CS":
											$imgsem="<img src='imagenes/sema_verdeON.jpg' title='Contestada' style='width:20px'/>";
											$imgtip="<img src='imagenes/consulta01.png' title='Consulta' style='width:20px'/>";
											break;
									}
									if (@ $_POST['estfun'][$x]=="S"){$imgfun="<img src='imagenes/usuario01.png' style=width:18px;'/> Activo <img src='imagenes/usuario01.png' style=width:18px;'/>";}
											else{$imgfun="<img src='imagenes/usuario02.png' style=width:18px;'/> Inactivo <img src='imagenes/usuario02.png' style=width:18px;'/>";}
									echo "
										<input type='hidden' name='docres[]' value='".$_POST['docres'][$x]."'/>
										<input type='hidden' name='nomdes[]' value='".$_POST['nomdes'][$x]."'/>
										<input type='hidden' name='estadoes[]' value='".$_POST['estadoes'][$x]."'>
										<input type='hidden' name='estfun[]' value='".$_POST['estfun'][$x]."'>
										<tr class='$iter' style='text-transform:uppercase'>
											<td>$con</td>
											<td>".$_POST['docres'][$x]."</td>
											<td>".$_POST['nomdes'][$x]."</td>
											<td style='text-align:center;cursor:pointer;'> $imgtip </td>
											<td><input type='radio' name='docorig' class='defaultradio' $marcador disabled /></td>
											<td>$imgfun</td>
											<td style='text-align:center;'> $imgsem </td>
										</tr>";   
									$aux=$iter;
									$iter=$iter2;
									$iter2=$aux;
									$con=$con+1;
								}
							?>
						</table>
					</div>
				</div>
				<div class="tab">
					<input type="radio" id="tab-3" name="tabgroup1" value="3" <?php echo @ $check3;?> >
					<label for="tab-3">Archivos Adjuntos</label>
					<div class="content" style="overflow:hidden;">
						<table class="inicio" >
							<tr>
								<td colspan="4" class="titulos">Archivos Adjuntos</td>
							</tr>
							<tr>
								<td class="titulos2" style="width:5%;">Item</td>
								<td class="titulos2" style="width:85%;">Nombre del Archivo</td>
								<td class="titulos2" style="width:10%;">Tipo</td>

							</tr>
							<?php
								$iter="saludo1";
								$iter2="saludo2";
								$con=1;
								$tam=count(@ $_POST['nomarchivo']);
								for($x=0;$x<$tam;$x++)
								{
									echo "
										<tr class='$iter'>
											<td>$con</td>
											<td><input class='inpnovisibles type='text' name='nomarchivo[]' value='".$_POST['nomarchivo'][$x]."' style='width:100%;' readonly></td>
											<td style='text-align:center;'>".traeico($_POST['nomarchivo'][$x])."</td>
										</tr>";
									$aux=$iter;
									$iter=$iter2;
									$iter2=$aux;
									$con=$con+1;
								}
							?>
						</table>
					</div>
				</div>
				<div class="tab">
					<input type="radio" id="tab-4" name="tabgroup1" value="4" <?php echo @ $check3;?> >
					<label for="tab-4">Historial</label>
					<div class="content" style="overflow:hidden;">
						<?php
							$sqlr2="SELECT * FROM planacresponsables WHERE codradicacion='".$_POST['oculid']."' AND tipot='RA' ORDER BY idhistory DESC, codigo";
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
										case "AN":
											$estadores='<img src="imagenes/sema_amarilloON.jpg" style="height:22px;" title="Sin Responder">';
											$imgtip='<img src="imagenes/escritura.png" style="height:22px;" title="Tarea">';
											break;
										case "AC":
											$estadores='<img src="imagenes/sema_verdeON.jpg" style="height:20px;" title="Contestada">';
											$imgtip='<img src="imagenes/escritura.png" style="height:20px;" title="Tarea">';
											break;
										case "LS":
											$estadores='<img src="imagenes/sema_verdeON.jpg" style="height:20px;" title="Revisada">';
											$vardisable="disabled";
											$imgtip='<img src="imagenes/lectura.png" style="height:20px;" title="Solo Lectura">';
											break;
										case "LN":
											$estadores='<img src="imagenes/sema_amarilloON.jpg" style="height:20px;" title="Sin Revisar">';
											$vardisable="disabled";
											$imgtip='<img src="imagenes/lectura.png" style="height:20px;" title="Solo Lectura">';
											break;
										case "AR":
											$estadores='<img src="imagenes/sema_verdeON.jpg" style="height:22px;" title="Sin Contestar">';
											$imgtip='<img src="imagenes/redirigir.png" style="height:20px;" title="Redirigida">';
											break;
										case "CN":
											$estadores='<img src="imagenes/sema_amarilloON.jpg" style="height:22px;" title="Sin Contestar">';
											$imgtip='<img src="imagenes/consulta01.png" style="height:20px;" title="Consulta">';
											break;
										case "CS":
											$estadores='<img src="imagenes/sema_verdeON.jpg" style="height:20px;" title="Contestada">';
											$imgtip='<img src="imagenes/consulta01.png" style="height:22px;" title="Consulta">';
											break;
									}
									if ($row2[8]!=''){$contex=str_replace("&lt;br/&gt;"," ",$row2[8]);}
									else {$contex=str_replace("&lt;br/&gt;"," ",$row2[11]);}
									if($row2[2]!='0000-00-00'){$fecharadst=date('d-m-Y',strtotime($row2[2]));}
									else{$fecharadst='00-00-0000';}
									if($row2[3]!='0000-00-00'){$fecharesst=date('d-m-Y',strtotime($row2[3]));}
									else{$fecharesst='00-00-0000';}
									if($row2[13]!='00:00:00'){$horaradst=date('h:i:s a',strtotime($row2[13]));}
									else{$horaradst=$row2[13];}
									if($row2[14]!='00:00:00'){$horaresst=date('h:i:s a',strtotime($row2[14]));}
									else{$horaresst=$row2[14];}
									echo "
									<tr class='$color' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase'> 
										<td>$cont</td>
										<td>$fecharadst</td>
										<td>$horaradst</td>
										<td>$fecharesst</td>
										<td>$horaresst</td>
										<td>$hisasig</td>
										<td>$hiscont</td>
										<td>$contex</td>
										<td style='text-align:center;'>$imgtip</td>
										<td style='text-align:center;'>$estadores</td>
										<td>
											<select id='archiad".$row2[0]."' name='archiad".$row2[0]."' class='elementosmensaje' style='width:100%'  onKeyUp='return tabular(event,this)' onChange='document.form2.submit();' $vardisable>";
											
											$sqlr4="SELECT nomarchivo FROM planarchresponsables WHERE codresponsable='$row2[0]' ORDER BY nomarchivo ASC ";
											$res4=mysqli_query($linkbd,$sqlr4);
											if (mysqli_num_rows($res4)>0)
											{
												echo "<option onChange='' value='' >Seleccione....</option>";
												while ($row4 = mysqli_fetch_row($res4))
												{
													if($row4[0]==$_POST["archiad".$row2[0]])
													{echo "<option value='$row4[0]' SELECTED> - $row4[0]</option>";}
													else {echo "<option value='$row4[0]'> - $row4[0]</option>";}
												}
											}
											else {echo "<option onChange='' value=''>Sin Archivos</option>";}
										echo"	
											</select>
										</td>
										<td>";
										if((@ $_POST["archiad".$row2[0]])!="")
										{
											echo'<a href="informacion/documentosradicados/responsables/RA/'.$row2[0].'/'.$_POST["archiad".$row2[0]].'" download><img src="imagenes/descargar.png" title="Descargar Archivo" ></a>';
										}
										else
										{echo'<a ><img src="imagenes/descargard.png" title="Sin Archivo" ></a>';}
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
			<input type="hidden" name="estrad" id="estrad" value="<?php echo @ $_POST['estrad']?>">
			<input type="hidden" id="oculid" name="oculid" value="<?php echo @ $_POST['oculid']?>">
			<input type="hidden" id="oculto" name="oculto" value="<?php echo @ $_POST['oculto']?>">
		</form>
	</body>
</html>