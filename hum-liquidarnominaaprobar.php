<?php
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=iso-8859-1");
	require"comun.inc";
	require"funciones.inc";
	require"funciones_nomina.inc";
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
		<title>:: Spid - Gestion Humana</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/calendario.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script>
			function buscater(e){if (document.form2.tercero.value!=""){document.form2.bt.value='1';document.form2.submit();}}
			function guardar()
			{
				if (document.getElementById('idliq').value!='-1' && document.getElementById('rp').value!='-1' && document.getElementById('ntercero').value!=''){despliegamodalm('visible','4','Esta Seguro de Guardar','1')}
				else{despliegamodalm('visible','2','Faltan datos para completar el registro'); }
			}
			function validar(formulario)
			{
				document.form2.cperiodo.value='2';
				document.form2.action="hum-liquidarnominaaprobar.php";
				document.form2.submit();
			}
			function marcar(indice,posicion)
			{
				vvigencias=document.getElementsByName('empleados[]');
				vtabla=document.getElementById('fila'+indice);
				clase=vtabla.className;
				if(vvigencias.item(posicion).checked){vtabla.style.backgroundColor='#3399bb';}
	 			else
	 			{
					e=vvigencias.item(posicion).value;
					document.getElementById('fila'+e).style.backgroundColor='#ffffff';
	 			}
	 			sumarconc();
 			}
			function excell()
			{
				document.form2.action="hum-liquidarnominaexcel.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function pdf()
			{
				document.form2.action="pdfpeticionrp2.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function despliegamodal2(_valor)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else 
				{document.getElementById('ventana2').src="tercerosgral-ventana01.php?objeto=tercero&nobjeto=ntercero&nfoco=";}
			}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden")
				{
					document.getElementById('ventanam').src="";
					if(document.getElementById('valfocus').value=="1")
					{
						document.getElementById('valfocus').value='0';
						document.getElementById('ntercero').value='';
						document.getElementById('bt').value='0';
					}
				}
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
			function funcionmensaje(){document.location.href = "";}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.form2.oculto.value="2";
								document.form2.submit();break;
					case "2": 	despliegamodalm("hidden");
								mypop=window.open('cont-terceros.php','','');break;
				}
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("hum");</script><?php cuadro_titulos();?></tr>
			<tr><?php menu_desplegable("hum");?></tr>
			<tr>
				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" class='mgbt' onClick="location.href='hum-liquidarnominaaprobar.php'"/><img src="imagenes/guarda.png" title="Guardar" onClick="guardar()" class="mgbt"/><img src="imagenes/busca.png" title="Buscar"  onClick="location.href='hum-buscanominasaprobadas.php'" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana"  onClick="mypop=window.open('hum-principal.php','','');mypop.focus();" class="mgbt"/><img src="imagenes/print.png" title="Imprimir" onClick="pdf()" class="mgbt"><img src="imagenes/excel.png" title="Excel" onClick='excell()' class="mgbt"/><img src='imagenes/iratras.png' title='Men&uacute; Nomina' class='mgbt' onClick="location.href='hum-menunomina.php'"/></td>
			</tr>
		</table>
		<div id="bgventanamodalm" class="bgventanamodalm">
			<div id="ventanamodalm" class="ventanamodalm">
				<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
				</IFRAME>
			</div>
		</div>
		<form name="form2" method="post" action="">
			<input type="hidden" name="valfocus" id="valfocus" value="0"/>
			<?php
				$vigusu=vigencia_usuarios($_SESSION['cedulausu']);
				if(@ $_POST['oculto']=="")
				{
					$_POST['tabgroup1']=1;
					$_POST['idcomp']=selconsecutivo('humnomina_aprobado','id_aprob');
					$_POST['fecha']=date("d/m/Y");
				}
				switch(@ $_POST['tabgroup1'])
				{
					case 1:	$check1='checked';break;
					case 2:	$check2='checked';break;
					case 3:	$check3='checked';break;
				}
				$pf[]=array();
				$pfcp=array();
			?>
			<div class="tabscontra" style="height:74.5%; width:99.6%">
				<div class="tab">
					<input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo @ $check1;?> >
					<label for="tab-1">Liquidaciones</label>
					<div class="content" style="overflow-y:hidden">
						<table  class="inicio" align="center" >
							<tr>
								<td class="titulos" colspan="10">:: Buscar Liquidaciones</td>
								<td class="cerrar" style="width:7%" onClick="location.href='hum-principal.php'">Cerrar</td>
							</tr>
							<tr>
								<td class="saludo1" style="width:3cm">No Aprobaci&oacute;n:</td>
								<td style="width:12%;"><input type="text"  name="idcomp" value="<?php echo @ $_POST['idcomp']?>" style="width:100%" readonly></td>
								<td class="saludo1" style="width:3cm">No Liquidaci&oacute;n:</td>
								<td  style="width:10%;">
									<select name="idliq" id="idliq" onChange="document.form2.submit();" style="width:100%;">
										<option value="-1">Sel ...</option>
										<?php
											$sqlr="SELECT TB1.*,TB2.cdp,TB2.rp FROM humnomina TB1, hum_nom_cdp_rp TB2 WHERE TB1.estado='S' AND TB1.id_nom=TB2.nomina AND TB2.vigencia='$vigusu'";
											$resp = mysqli_query($linkbd,$sqlr);
											while ($row =mysqli_fetch_row($resp))
											{
												if($_POST['idliq']==$row[0])
												{
													echo "<option value='$row[0]' SELECTED>$row[0]</option>";
													$_POST['tperiodo']=$row[2];
													$_POST['periodo']=$row[3];
													$_POST['cc']=$row[6];
													$_POST['diasperiodo']=$row[4];
													if($row[10]!='0'){$_POST['rp']=$row[10];}
													else{$_POST['rp']='';$_POST['descrp']="RP Sin Asignar";}
													if($row[9]=='0'){$_POST['cdp']="CDP Sin Asignar";}
													
												}
												else {echo "<option value='$row[0]'>$row[0]</option>";}
											}
										?>
									</select>
								</td>
								<td class="saludo1" style="width:3cm;">Fecha: </td>
								<td style="width:10%;"><input id="fc_1198971545" name="fecha" type="text" value="<?php echo @ $_POST['fecha']?>" maxlength="10" title="DD/MM/YYYY"onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" style="width:75%;"/>&nbsp;<img src="imagenes/calendario04.png" class="icobut" onClick="displayCalendarFor('fc_1198971545');"></td>
							<td colspan="3"></td>
							</tr>
							<tr>
								<td class="saludo1">RP:</td> 
								<td>
									<select name="rp" id="rp" onChange="validar()" style="width:100%">
										<option value="-1">Sel ...</option>
										<?php
											$sqlr="SELECT DISTINCT TB1.rp,TB2.valor,TB2.idcdp,TB1.vigencia,TB3.objeto FROM hum_nom_cdp_rp TB1 INNER JOIN pptorp TB2 ON TB1.rp=TB2.consvigencia AND TB1.estado='S' AND TB1.vigencia='$vigusu' AND TB2.vigencia='$vigusu' INNER JOIN pptocdp TB3 ON TB3.consvigencia=TB2.idcdp AND TB3.vigencia='$vigusu'";
											$resp = mysqli_query($linkbd,$sqlr);
											while ($row =mysqli_fetch_row($resp))
											{
												if($_POST['rp']==$row[0])
												{
													echo "<option value='$row[0]' SELECTED>$row[0]</option>";
													$_POST['rp']=$row[0];
													$_POST['valorp']=$row[1];
													$_POST['hvalorp']=$row[1];
													$_POST['cdp']=$row[2];
													$desglo = explode(" - ", $row[4]);
													$_POST['descrp']=$row[4];
												}
											}
										?>
									</select>
								</td>
								<td colspan="3"><input type="text" name="descrp" id="descrp" value="<?php echo @ $_POST['descrp'];?>" style="width:100%" readonly/></td>
								<td>
									<input type="hidden" name="hvalorp" id="hvalorp" value="<?php echo @ $_POST['hvalorp']?>"/>
									<input type="text" name="valorp" id="valorp" style="width:100%;" value="<?php echo @ number_format($_POST['valorp'],2)?>" readonly/>
								</td>
								<td class="saludo1" style="width:3cm">CDP:</td>
								<td style="width:10%">
									<input type="text" id="cdp" name="cdp" value="<?php echo @ $_POST['cdp']?>" style="width:100%;" readonly>
								</td>
								<td></td>
							</tr>
							<tr>
								<td class="saludo1">Tercero:</td>
								<td>
									<input type="text" id="tercero" name="tercero"  onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo @ $_POST['tercero']?>" style="width:80%"/>
									<input type="hidden" value="0" name="bt" id="bt">&nbsp;<img class="icobut" src="imagenes/find02.png"  title="Listado Terceros"  onClick="despliegamodal2('visible');"/></td>
								<td colspan="6"><input type="text" id="ntercero" name="ntercero" style="width:100%;" value="<?php echo @ $_POST['ntercero']?>" readonly></td>
								<td></td>
							</tr>
						</table>
						<input type="hidden" id="cajacomp" name="cajacomp" value="<?php echo @ $_POST['cajacomp']?>"/>
						<input type="hidden" id="icbf" name="icbf" value="<?php echo @ $_POST['icbf']?>"/>
						<input type="hidden" id="sena" name="sena" value="<?php echo @ $_POST['sena']?>"/>
						<input type="hidden" id="esap" name="esap" value="<?php echo @ $_POST['esap']?>"/>
						<input type="hidden" id="iti" name="iti" value="<?php echo @ $_POST['iti']?>"/>
						<input type="hidden" id="btrans" name="btrans" value="<?php echo @ $_POST['btrans']?>"/>
						<input type="hidden" id="balim" name="balim" value="<?php echo @ $_POST['balim']?>"/>
						<input type="hidden" id="bfsol" name="bfsol" value="<?php echo @ $_POST['bfsol']?>"/>
						<input type="hidden" id="transp" name="transp" value="<?php echo @ $_POST['transp']?>"/>
						<input type="hidden" id="alim" name="alim" value="<?php echo @ $_POST['alim']?>"/>
						<input type="hidden" id="salmin" name="salmin" value="<?php echo @ $_POST['salmin']?>"/>
						<input type="hidden" id="tperiodonom" name="tperiodonom" value="<?php echo @ $_POST['tperiodonom']?>"/>
						<input type="hidden" name="cperiodo" id="cperiodo" value="">
					</div>
				</div>
				<div class="tab">
					<input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo @ $check2;?> >
					<label for="tab-2">Empleados</label>
					<div class="content" >
						<?php
							$crit1=" ";
							$crit2=" ";
							echo "
							<table class='inicio' align='center' width='99%'>
								<tr><td colspan='19' class='titulos'>.: Resultados Busqueda: ".@ $ntr." Empleados</td></tr>
								<tr class='titulos2'>
									<th></th>
									<th width='1%'>Vac<input type='checkbox' name='todos' value=''  onClick='' ".@ $chk."></th>
									<th>TIPO</th>
									<th>EMPLEADO</th>
									<th width='2%'>DOCUMENTO</th>
									<th>SAL BAS</th>
									<th>DIAS LIQ</th>
									<th>DEVENGADO</th>
									<th>AUX ALIM</th>
									<th>AUX TRAN</th>
									<th>HORAS EXTRAS</th>
									<th>TOT DEV</th>
									<th>SALUD</th>
									<th>PENSION</th>
									<th>F SOLIDA</th>
									<th>RETE FTE</th>
									<th>OTRAS DEDUC</th>
									<th>TOT DEDUC</th>
									<th>NETO PAG</th>
								</tr>";
							$iter="zebra1";
							$iter2="zebra2";
							$con=0;
							$sqlr="SELECT * FROM humnomina_det WHERE id_nom='".@ $_POST['idliq']."'";
							$resp = mysqli_query($linkbd,$sqlr);
							while ($row =mysqli_fetch_row($resp))
							{
								$_POST['ccemp'][$con]=$row[1];
								$_POST['nomemp'][$con]=buscatercero($row[1]);
								$salario=$row[2];
								$_POST['diast'][$con]=$row[3];
								$deven=$row[4];
								$auxalimtot=$row[6];
								$auxtratot=$row[7];
								$primanavi=$row[33];
								$ibc=$row[5];
								$horaextra=$row[8];
								$totdev=$row[9];
								$arpemp=$row[9];
								$rsalud=$row[10];
								$rsaludemp=$row[11];
								$valsaludtot=$row[10]+$row[11];
								$rpension=$row[12];
								$rpensionemp=$row[13];
								$fondosol=$row[14];
								$valpensiontot=$row[12]+$row[13]+$row[14];
								$otrasrete=$row[16];
								$totalretenciones=$row[17];
								$totalneto=$row[18];
								$tipopago=$row[36];
								$chk='';
								if($row[20]=='S'){$chk='checked';}
								echo "
								<input type='hidden' name='tippago[]' value='".@ $tipopago."'/>
								<input type='hidden' name='nomemp[]' value='".@ $_POST['nomemp'][$con]."'/>
								<input type='hidden' name='ccemp[]' value='".@ $_POST['ccemp'][$con]."'/>
								<input type='hidden' name='centrocosto[]' value='".@ $row[31]."'/>
								<input type='hidden' name='salbas[]' value='".@ $salario."'/>
								<input type='hidden' name='diast[]' value='".@ $_POST['diast'][$con]."'/>
								<input type='hidden' name='devengado[]' value='".@ $deven."'/>
								<input type='hidden' name='ealim[]' value='".@ $auxalimtot."'/>
								<input type='hidden' name='etrans[]' value='".@ $auxtratot."'>
								<input type='hidden' name='horaextra[]' value='".@ $horaextra."'/>
								<input type='hidden' name='totaldev[]' value='".@ $totdev."'/>
								<input type='hidden' name='ibc[]' value='".@ $ibc."'/>
								<input type='hidden' name='arpemp[]' value='".@ $varp."'/>
								<input type='hidden' name='saludrete[]' value='".@ $rsalud."'/>
								<input type='hidden' name='saludemprete[]' value='".@ $rsaludemp."'/>
								<input type='hidden' name='totsaludrete[]' value='".@ $valsaludtot."'/>
								<input type='hidden' name='pensionrete[]' value='".@ $rpension."'/>
								<input type='hidden' name='pensionemprete[]' value='".@ $rpensionemp."'/>
								<input type='hidden' name='totpensionrete[]' value='".@ $valpensiontot."'/>
								<input type='hidden' name='fondosols[]' value='".@ $fondosol."'/>
								<input type='hidden' name='otrasretenciones[]' value='".@ $otrasrete."'/>
								<input type='hidden' name='totalrete[]' value='".@ $totalretenciones."'/>
								<input type='hidden' name='netopagof[]' value='".number_format(@ $totalneto,0)."'/>
								<input type='hidden' name='netopago[]' value='".@ $totalneto."'>
								<tr id='fila$row[1]' class='$iter' ".@ $style.">
									<td>$con</td>
									<td><input type='checkbox' name='empleados[]' value='".$_POST['ccemp'][$con]."' onClick='marcar(".@ $_POST['empleados'][$con].",$con);' $chk disabled><input name='vacacion' type='hidden' value='$row[20]'></td>
									<td>$tipopago</td>
									<td>".$_POST['nomemp'][$con]."&nbsp;</td>
									<td>&nbsp;".$_POST['ccemp'][$con]."&nbsp;</td>
									<td style='text-align:right;'>$".number_format(@ $salario)."</td>
									<td style='text-align:right;'>".@ $_POST['diast'][$con]."</td>
									<td style='text-align:right;'>$".number_format(@ $deven)."</td>
									<td style='text-align:right;'>$".number_format(@ $auxalimtot)."</td>
									<td style='text-align:right;'>$".number_format(@ $auxtratot)."</td>
									<td style='text-align:right;'>$".number_format(@ $horaextra)."</td>
									<td style='text-align:right;'>$".number_format(@ $totdev)."</td>
									<td style='text-align:right;'>$".number_format(@ $rsalud)."</td>
									<td style='text-align:right;'>$".number_format(@ $rpension)."</td>
									<td style='text-align:right;'>$".number_format(@ $fondosol)."</td>
									<td style='text-align:right;'>$".number_format(@ $row2[2])."</td>
									<td style='text-align:right;'>$".number_format(@ $otrasrete)."</td>
									<td style='text-align:right;'>$".number_format(@ $totalretenciones)."</td>
									<td style='text-align:right;'>$".number_format(@ $totalneto,0)."</td>
								</tr>";
								@ $_POST['totsaludtot']+=$valsaludtot;
								@ $_POST['totpenstot']+=$valpensiontot;
								@ $_POST['totaldevini']+=$deven;
								@ $_POST['totalauxalim']+=$auxalimtot;
								@ $_POST['totalauxtra']+=$auxtratot;
								@ $_POST['totaldevtot']+=$totdev;
								@ $_POST['totalsalud']+=$rsalud;
								@ $_POST['totalpension']+=$rpension;
								@ $_POST['totalfondosolida']+=$fondosol;
								@ $_POST['totalotrasreducciones']+=$otrasrete;
								@ $_POST['totaldeductot']+=$totalretenciones;
								@ $_POST['totalnetopago']+=$totalneto;
								$con+=1;
								$aux=$iter;
								$iter=$iter2;
								$iter2=$aux;
							}
							echo "
								<input type='hidden' name='totaldevini' value='".@ $_POST['totaldevini']."'>
								<input type='hidden' name='totalauxalim' value='".@ $_POST['totalauxalim']."'>
								<input type='hidden' name='totalauxtra' value='".@ $_POST['totalauxtra']."'>
								<input type='hidden' name='totalhorex' value='".@ $_POST['totalhorex']."'>
								<input type='hidden' name='totaldevtot' value='".@ $_POST['totaldevtot']."'>
								<input type='hidden' name='totalsalud' value='".@ $_POST['totalsalud']."'>
								<input type='hidden' name='totalpension' value='".@ $_POST['totalpension']."'>
								<input type='hidden' name='totalfondosolida' value='".@ $_POST['totalfondosolida']."'>
								<input type='hidden' name='totalotrasreducciones' value='".@ $_POST['totalotrasreducciones']."'>
								<input type='hidden' name='totalotrasreducciones' value='".@ $_POST['totalotrasreducciones']."'>
								<input type='hidden' name='totaldeductot' value='".@ $_POST['totaldeductot']."'>
								<input type='hidden' name='totalnetopago' value='".@ $_POST['totalnetopago']."'>
								<tr class='$iter'>
									<td colspan='5'></td>
									<td>".@ number_format($_POST['totaldevini'],2)."</td>
									<td>".@ number_format($_POST['totalauxalim'],2)."</td>
									<td>".@ number_format($_POST['totalauxtra'],2)."</td>
									<td> ".@ number_format($_POST['totalhorex'],2)."</td>
									<td></td>
									<td>".@ number_format($_POST['totaldevtot'],2)."</td>
									<td> ".@ number_format($_POST['totalsalud'],2)."</td>
									<td> ".@ number_format($_POST['totalpension'],2)."</td>
									<td> ".@ number_format($_POST['totalfondosolida'],2)."</td>
									<td></td>
									<td>".@ number_format($_POST['totalotrasreducciones'],2)."</td>
									<td>".@ number_format($_POST['totaldeductot'],2)."</td>
									<td>".@ number_format($_POST['totalnetopago'],2)."</td>
								</tr>";
								echo"</table>";
						?>
					</div>
				</div>
				<div class="tab">
					<input type="radio" id="tab-3" name="tabgroup1" value="3" <?php echo @ $check3;?> >
					<label for="tab-3">Aportes</label>
					<div class="content" style="overflow-x:hidden">
						<table class="inicio">
							<tr>
								<td class="titulos" style="width:8%">Codigo</td>
								<td class="titulos" style="width:20%">Aportes Parafiscales</td>
								<td class="titulos" style="width:8%">Porcentaje</td>
								<td class="titulos" style="width:10%">Valor</td>
								<td class="titulos" >descripci&oacute;n</td>
							</tr>
							<?php
								$sqlr="SELECT id_parafiscal, porcentaje, SUM(valor) FROM humnomina_parafiscales WHERE id_nom='".$_POST['idcomp']."' GROUP BY id_parafiscal";
								$resp2 = mysqli_query($linkbd,$sqlr);
								$iter="zebra1";
								$iter2="zebra2";
								while($row2 =mysqli_fetch_row($resp2))
								{
									$sqlrtipo="SELECT tipo, nombre FROM humparafiscales WHERE codigo='$row2[0]'";
									$resptipo = mysqli_query($linkbd,$sqlrtipo);
									$rowtipo=mysqli_fetch_row($resptipo);
									echo "
									<tr class='$iter'>
										<input type='hidden' name='codpara[]' value='$row2[0]'/>
										<input type='hidden' name='codnpara[]' value='$rowtipo[1]'/>
										<input type='hidden' name='porpara[]' value='$row2[1]'/>
										<input type='hidden' name='valpara[]' value='$row2[2]'/>
										<input type='hidden' name='tipopara[]' value='$rowtipo[0]'/>
										<td>$row2[0]</td>
										<td>$rowtipo[1]</td>
										<td style='text-align:right;'>$row2[1] %</td>
										<td style='text-align:right;'>$ $row2[2]&nbsp;</td>";
									if ($rowtipo[0]=="A"){echo"<td>&nbsp;APORTES EMPRESA</td>";}
									else{echo"<td>&nbsp;APORTE EMPLEADOS</td>";}
									echo"</tr>";
									$aux=$iter;
									$iter=$iter2;
									$iter2=$aux;
								}
								echo "
								<tr>
									<td></td>
									<td colspan='2' style='text-align:right;'>TOTAL SALUD: </td>
									<td class='saludo3' style='text-align:right;'>$ ".number_format(@ array_sum($listasaludtotal),2)."</td>
									<td></td>
								</tr>
								<tr '>
									<td></td>
									<td colspan='2' style='text-align:right;'>TOTAL PENSION: </td>
									<td class='saludo3' style='text-align:right;'>".number_format(@ array_sum($listapensiontotal),2)."</td>
								</tr>";
							?>
						</table>
						<table class="inicio">
							<tr>
								<td class="titulos">Cuenta Presupuestal</td>
								<td class="titulos">Nombre Cuenta Presupuestal</td>
								<td class="titulos">Valor</td>
							</tr>
							<?php
								$totalrubro=0;
								$sqlr="SELECT * FROM humnom_presupuestal WHERE id_nom='".@ $_POST['idliq']."'";
								$resp=mysqli_query($linkbd,$sqlr);
								while($rp=mysqli_fetch_row($resp))
								{
									$k=$rp[1];
									$ncta=existecuentain($k);
									$valrubros=$rp[2];
									$ncta=existecuentain($k);
									echo "
									<tr class='$iter'>
										<td ><input type='hidden' name='rubrosp[]' value='$k'>$k</td>
										<td><input type='hidden' name='nrubrosp[]' value='".strtoupper($ncta)."'>".strtoupper($ncta)."</td>
										<td align='right'><input type='hidden' name='vrubrosp[]' value='$valrubros'>".number_format($valrubros,2)."</td>
									</tr>";
									$totalrubro+=$valrubros;
									$aux=$iter;
									$iter=$iter2;
									$iter2=$aux;
								}
							?>
							<tr class='saludo3'>
								<td></td>
								<td>Total:</td>
								<td align='right'><?php echo number_format($totalrubro,2) ?></td>
							</tr> 
						</table>
					</div>
				</div>
			</div>
			<input type="hidden" name="oculto" id="oculto" value="1"/>
			<?php
				if(@ $_POST['bt']=='1')
				{
					$nresul=buscatercero($_POST['tercero']);
					if($nresul!='')
					{
						echo"
						<script>
							document.getElementById('ntercero').value='$nresul';
							document.getElementById('cuenta').focus();
							document.getElementById('cuenta').select();
						</script>";
					}
					else 
					{
						echo"
						<script>
							document.getElementById('valfocus').value='1';
							despliegamodalm('visible','4','Tercero Incorrecto o no Existe, ¿Desea Agregar un Tercero?','2');
						</script>";
					}
				}
				if(@ $_POST['oculto']=="2")
				{
					$vigenomina=$vigusu;
					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST['fecha'],$fecha);
					$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
					$_POST['idcomp']=selconsecutivo('humnomina_aprobado','id_aprob');
					$sqlr="INSERT INTO humnomina_aprobado (id_aprob,id_nom,fecha,id_rp,persoaprobo,estado) VALUES (".$_POST['idcomp'].",'".$_POST['idliq']."','$fechaf','".$_POST['rp']."','".$_SESSION['usuario']."','S')";
					if (!mysqli_query($linkbd,$sqlr)) {echo"<script>despliegamodalm('visible','2','No se Pudo Aprobrar la Nomina');</script>";}
					else
					{
						$sqlr="UPDATE humnomina SET estado='P' WHERE id_nom='".$_POST['idliq']."'"; 
						mysqli_query($linkbd,$sqlr);
						$sqlr="UPDATE humnom_presupuestal SET estado='P' WHERE id_nom='".$_POST['idliq']."'";
						mysql_query($linkbd,$sqlr);
						echo"<script>despliegamodalm('visible','3','Registros Exitosos:$cex   -   Registros Erroneos: $cerr');</script>";
						//*****cargue comprobante de nomina desde el precomprobante
						$sqlr="SELECT * FROM admfiscales WHERE vigencia='$vigenomina'";
						$resp = mysqli_query($linkbd,$sqlr);
						//Nuevo codigo contable
						while ($row =mysqli_fetch_row($resp)) 
						{
							$_POST['balim']=$row[7];
							$_POST['btrans']=$row[8];
							$_POST['bfsol']=$row[6];
							$_POST['alim']=$row[5];
							$_POST['transp']=$row[4];
							$_POST['salmin']=$row[3];
							$_POST['cajacomp']=$row[13];
							$_POST['icbf']=$row[10];
							$_POST['sena']=$row[11];
							$_POST['esap']=$row[14];
							$_POST['iti']=$row[12];
						}
						$sqlr="SELECT sueldo, cajacompensacion,icbf,sena,iti,esap,arp,salud_empleador,salud_empleado,pension_empleador, pension_empleado,sub_alimentacion,aux_transporte,prima_navidad from humparametrosliquida ";
						$resp = mysqli_query($linkbd,$sqlr);
						while ($row =mysqli_fetch_row($resp))
						{
							$_POST['psalmin']=$row[0];
							$_POST['pcajacomp']=$row[1];
							$_POST['picbf']=$row[2];
							$_POST['psena']=$row[3];
							$_POST['piti']=$row[4];
							$_POST['pesap']=$row[5];
							$_POST['parp']=$row[6];
							$_POST['psalud_empleador']=$row[7];
							$_POST['psalud_empleado']=$row[8];
							$_POST['ppension_empleador']=$row[9];
							$_POST['ppension_empleado']=$row[10];
							$_POST['palim']=$row[11];
							$_POST['ptransp']=$row[12];
							$_POST['pbfsol']=$_POST['ppension_empleado'];
							$_POST['tprimanav']=$row[13];
						}
						$listacuentas=array();
						$listanombrecuentas=array();
						$listaterceros=array();
						$listanombreterceros=array();
						$listaccs=array();
						$listadetalles=array();
						$listadebitos=array();
						$listacreditos=array();
						$listacajacf[]=array();
						$listasena[]=array();
						$listaicbf[]=array();
						$listainstecnicos[]=array();
						$listaesap[]=array();
						$listatipo[]=array();
						$crit1=$crit2=" ";
						$con=1;
						$sqlr="SELECT mes,vigencia,fecha FROM humnomina WHERE id_nom='".$_POST['idliq']."'";
						$resp = mysqli_query($linkbd,$sqlr);
						$row =mysqli_fetch_row($resp); 
						$mesnnomina=$row[0];
						$meslnomina=mesletras($row[0]);
						$vigenomina=$row[1]; 
						$_POST['fechafi']=$row[2];
						$sqlr="SELECT cedulanit,devendias,auxalim,auxtran,salud,saludemp,pension,pensionemp,fondosolid,otrasdeduc,arp, cajacf,sena,icbf,instecnicos,esap,tipofondopension,prima_navi,cc,tipopago,idfuncionario FROM humnomina_det WHERE id_nom='".$_POST['idliq']."'";
						$resp = mysqli_query($linkbd,$sqlr);
						while ($row =mysqli_fetch_row($resp)) 
						{
							$ccosto=$row[18];
							$empleado=buscatercero($row[0]);
							if($row[1]!=0)//tipo de pago (Salarios, Subsidios, primas .....)
							{
								$ctaconcepto=$ctacont='';
								//Cuenta debito 
								$ctacont=cuentascontables::cuentadebito_tipomov($row[19],$ccosto,$vigenomina,$_POST['fechafi']);
								$nresul=buscacuenta($ctacont);
								$sqlrdes="SELECT nombre FROM humvariables WHERE estado='S' AND codigo='$row[19]'";
								$resdes = mysqli_query($linkbd,$sqlrdes);
								$rowdes =mysqli_fetch_row($resdes);
								$nomceunta=ucwords(strtolower($rowdes[0]));
								$listacuentas[]=$ctacont;
								$listanombrecuentas[]=$nresul;
								$listaterceros[]=$row[0];
								$listanombreterceros[]=$empleado;
								$listaccs[]=$ccosto;
								$listadetalles[]="$nomceunta Mes $meslnomina";
								$listadebitos[]=$row[1];
								$listacreditos[]=0;
								$listatipo[]="$row[19]<->DB";
								$aux=$iter;
								$iter=$iter2;
								$iter2=$aux;
								$con+=1;
								//Cuenta credito
								$ctaconcepto=cuentascontables::cuentacredito_tipomov($row[19],$ccosto,$vigenomina,$_POST['fechafi']);
								$nresul=buscacuenta($ctaconcepto);
								$listacuentas[]=$ctaconcepto;
								$listanombrecuentas[]=$nresul;
								$listaterceros[]=$row[0];
								$listanombreterceros[]=$empleado;
								$listaccs[]=$ccosto;
								$listadetalles[]="$nomceunta Mes $meslnomina";
								$listadebitos[]=0;
								$listacreditos[]=$row[1];
								$listatipo[]="$row[19]<->CR";
								$aux=$iter;
								$iter=$iter2;
								$iter2=$aux;
								$con+=1;
							}
							if($row[4]!=0)//Salud Empleado
							{
								$ctaconcepto=$ctacont='';
								//Cuenta debito salud empleado
								$ctacont=cuentascontables::cuentacredito_tipomov($row[19],$ccosto,$vigenomina,$_POST['fechafi']);
								$nresul=buscacuenta($ctacont);
								$listacuentas[]=$ctacont;
								$listanombrecuentas[]=$nresul;
								$listaterceros[]=$row[0];
								$listanombreterceros[]=$empleado;
								$listaccs[]=$ccosto;
								$listadetalles[]="Aporte Salud Empleado Mes $meslnomina";
								$listadebitos[]=$row[4];
								$listacreditos[]=0;
								$listatipo[]="SE<->DB";
								$aux=$iter;
								$iter=$iter2;
								$iter2=$aux;
								$con+=1;
								//Cuenta credito salud empleado
								$nresul=buscacuenta($ctaconcepto);
								$epsnit=buscadatofuncionario($row[0],'NUMEPS');
								$epsnom=buscadatofuncionario($row[0],'NOMEPS');
								$ctaconcepto=cuentascontables::cuentacredito_parafiscales($_POST['psalud_empleado'],$ccosto,$vigenomina, $_POST['fechafi']);
								$listacuentas[]=$ctaconcepto;
								$listanombrecuentas[]=$nresul;
								$listaterceros[]=$epsnit;
								$listanombreterceros[]=$epsnom;
								$listaccs[]=$ccosto;
								$listadetalles[]="Aporte Salud Empleado Mes $meslnomina";
								$listadebitos[]=0;
								$listacreditos[]=$row[4];
								$listatipo[]="SE<->CR";
								$aux=$iter;
								$iter=$iter2;
								$iter2=$aux;
								$con+=1;
							}
							if($row[6]!=0)//Pension Empleado
							{
								$ctaconcepto=$ctacont='';
								//Cuenta debito pension empleado
								$ctacont=cuentascontables::cuentacredito_tipomov($row[19],$ccosto,$vigenomina,$_POST['fechafi']);
								$nresul=buscacuenta($ctacont);
								$listacuentas[]=$ctacont;
								$listanombrecuentas[]=$nresul;
								$listaterceros[]=$row[0];
								$listanombreterceros[]=$empleado;
								$listaccs[]=$ccosto;
								$listadetalles[]="Aporte Pension Empleado Mes $meslnomina";
								$listadebitos[]=$row[6];
								$listacreditos[]=0;
								$listatipo[]="PE<->DB";
								$aux=$iter;
								$iter=$iter2;
								$iter2=$aux;
								$con+=1;
								//Cuenta credito pension empleado
								$ctaconcepto=cuentascontables::cuentacredito_parafiscales($_POST['ppension_empleado'],$ccosto, $vigenomina,$_POST['fechafi']);
								$nresul=buscacuenta($ctaconcepto);
								$epsnit=buscadatofuncionario($row[0],'NUMAFP');
								$epsnom=buscadatofuncionario($row[0],'NOMAFP');
								$listacuentas[]=$ctaconcepto;
								$listanombrecuentas[]=$nresul;
								$listaterceros[]=$epsnit;
								$listanombreterceros[]=$epsnom;
								$listaccs[]=$ccosto;
								$listadetalles[]="Aporte Pension Empleado Mes $meslnomina";
								$listadebitos[]=0;
								$listacreditos[]=$row[6];
								$listatipo[]="PE<->CR";
								$aux=$iter;
								$iter=$iter2;
								$iter2=$aux;
								$con+=1;
							}
							if($row[8]!=0)//Fondo Solidaridad
							{
								$ctaconcepto=$ctacont='';
								//Cuenta debito fondo solidaridad
								$ctacont=cuentascontables::cuentacredito_tipomov($row[19],$ccosto,$vigenomina,$_POST['fechafi']);
								$nresul=buscacuenta($ctacont);
								$listacuentas[]=$ctacont;
								$listanombrecuentas[]=$nresul;
								$listaterceros[]=$row[0];
								$listanombreterceros[]=$empleado;
								$listaccs[]=$ccosto;
								$listadetalles[]="Aporte Fondo Solidaridad Empleado Mes $meslnomina";
								$listadebitos[]=$row[8];
								$listacreditos[]=0;
								$listatipo[]="FS<->DB";
								$aux=$iter;
								$iter=$iter2;
								$iter2=$aux;
								$con+=1;
								//Cuenta credito fondo solidaridad
								$ctaconcepto=cuentascontables::cuentacredito_parafiscales($_POST['pbfsol'],$ccosto,$vigenomina, $_POST['fechafi']);
								$nresul=buscacuenta($ctaconcepto);
								$epsnit=buscadatofuncionario($row[0],'NUMAFP');
								$epsnom=buscadatofuncionario($row[0],'NOMAFP');
								$listacuentas[]=$ctaconcepto;
								$listanombrecuentas[]=$nresul;
								$listaterceros[]=$epsnit;
								$listanombreterceros[]=$epsnom;
								$listaccs[]=$ccosto;
								$listadetalles[]="Aporte Fondo Solidaridado Mes $meslnomina";
								$listadebitos[]=0;
								$listacreditos[]=$row[8];
								$listatipo[]="FS<->CR";
								$aux=$iter;
								$iter=$iter2;
								$iter2=$aux;
								$con+=1;
							}
							if($row[9]!=0)//Otras Deducciones
							{
								$ctaconcepto=$ctacont='';
								$sqlrd1="SELECT T1.valor,T2.id_retencion,T2.tipopago FROM humnominaretenemp T1, humretenempleados T2 WHERE T1.id_nom='".$_POST['idliq']."' AND T1.cedulanit='$row[0]' AND T1.id=T2.id AND T1.tipo_des='DS' AND T2.tipopago='".$row[19]."'";
								$respd1=mysqli_query($linkbd,$sqlrd1);
								while ($rowd1=mysqli_fetch_row($respd1))
								{
									$sqlrcu="SELECT DISTINCT T1.nombre,T1.beneficiario,T2.cuenta FROM humvariablesretenciones T1, humvariablesretenciones_det T2 WHERE T1.codigo = '$rowd1[1]' AND T1.codigo = T2.codigo AND T2.credito = 'S' AND fechainicial=(SELECT MAX(T3.fechainicial) FROM humvariablesretenciones_det T3 WHERE T3.codigo=T2.codigo AND T3.fechainicial<='".$_POST['fechafi']."')";
									$respcu = mysqli_query($linkbd,$sqlrcu);
									while ($rowcu =mysqli_fetch_row($respcu))
									{
										$ctaconcepto=$rowcu[2];
										$docbenefi=$rowcu[1];
										$nomdescu=ucwords(strtolower($rowcu[0])); 
									}
									//Cuenta debito otras deducciones
									$ctacont=cuentascontables::cuentacredito_tipomov($row[19],$ccosto,$vigenomina,$_POST['fechafi']);
									$nresul=buscacuenta($ctacont);
									$listacuentas[]=$ctacont;
									$listanombrecuentas[]=$nresul;
									$listaterceros[]=$row[0];	
									$listanombreterceros[]=$empleado;
									$listaccs[]=$ccosto;
									$listadetalles[]="Decuento $nomdescu Mes $meslnomina";
									$listadebitos[]=$rowd1[0];
									$listacreditos[]=0;
									$listatipo[]="DS<->DB";
									//Cuenta credito otras deducciones
									$nresul=buscacuenta($ctaconcepto);
									$nombenefi=buscatercero($docbenefi);
									$listacuentas[]=$ctaconcepto;
									$listanombrecuentas[]=$nresul;
									$listaterceros[]=$docbenefi;
									$listanombreterceros[]=$nombenefi;
									$listaccs[]=$ccosto;
									$listadetalles[]="Decuento $nomdescu Mes $meslnomina";
									$listadebitos[]=0;
									$listacreditos[]=$rowd1[0];
									$listatipo[]="DS<->CR";
								}
							}
							if($row[5]!=0)//Salud Empleador
							{
								$ctaconcepto=$ctacont='';
								$epsnit=buscadatofuncionario($row[0],'NUMEPS');
								$epsnom=buscadatofuncionario($row[0],'NOMEPS');
								//Cuenta debito salud empleador
								$ctacont=cuentascontables::cuentadebito_parafiscales($_POST['psalud_empleador'],$ccosto,$vigenomina, $_POST['fechafi']);
								$nresul=buscacuenta($ctacont);
								$listacuentas[]=$ctacont;
								$listanombrecuentas[]=$nresul;
								$listaterceros[]=$epsnit;
								$listanombreterceros[]=$epsnom;
								$listaccs[]=$ccosto;
								$listadetalles[]="Aporte Salud Empleador Mes $meslnomina";
								$listadebitos[]=$row[5];
								$listacreditos[]=0;
								$listatipo[]="SR<->DB";
								$aux=$iter;
								$iter=$iter2;
								$iter2=$aux;
								$con+=1;
								//Cuenta credito salud empleador
								$ctaconcepto=cuentascontables::cuentacredito_parafiscales($_POST['psalud_empleador'],$ccosto, $vigenomina,$_POST['fechafi']);
								$nresul=buscacuenta($ctaconcepto);
								$listacuentas[]=$ctaconcepto;
								$listanombrecuentas[]=$nresul;
								$listaterceros[]=$epsnit;
								$listanombreterceros[]=$epsnom;
								$listaccs[]=$ccosto;
								$listadetalles[]="Aporte Salud Empleador Mes $meslnomina";
								$listadebitos[]=0;
								$listacreditos[]=$row[5];
								$listatipo[]="SR<->CR";
								$aux=$iter;
								$iter=$iter2;
								$iter2=$aux;
								$con+=1;
							}
							if($row[7]!=0)//Pension Empleador
							{
								$ctaconcepto=$ctacont='';
								$epsnit=buscadatofuncionario($row[0],'NUMAFP');
								$epsnom=buscadatofuncionario($row[0],'NOMAFP');
								//Cuenta debito pension empleador
								$ctacont=cuentascontables::cuentadebito_parafiscales($_POST['ppension_empleador'],$ccosto,$vigenomina, $_POST['fechafi']);
								$nresul=buscacuenta($ctacont);
								$listacuentas[]=$ctacont;
								$listanombrecuentas[]=$nresul;
								$listaterceros[]=$epsnit;	
								$listanombreterceros[]=$epsnom;	
								$listaccs[]=$ccosto;
								$listadetalles[]="Aporte Pension Empleador Mes $meslnomina";
								$listadebitos[]=$row[7];
								$listacreditos[]=0;
								$listatipo[]="PR<->DB";
								$aux=$iter;
								$iter=$iter2;
								$iter2=$aux;
								$con+=1;
								//Cuenta credito pension empleador
								$ctaconcepto=cuentascontables::cuentacredito_parafiscales($_POST['ppension_empleador'],$ccosto ,$vigenomina,$_POST['fechafi']);
								$nresul=buscacuenta($ctaconcepto);
								$listacuentas[]=$ctaconcepto;
								$listanombrecuentas[]=$nresul;
								$listaterceros[]=$epsnit;	
								$listanombreterceros[]=$epsnom;	
								$listaccs[]=$ccosto;
								$listadetalles[]="Aporte Pension Empleador Mes $meslnomina";
								$listadebitos[]=0;
								$listacreditos[]=$row[7];
								$listatipo[]="PR<->CR";
								$aux=$iter;
								$iter=$iter2;
								$iter2=$aux;
								$con+=1;
							}
							if($row[10]!=0)//ARL
							{
								$ctaconcepto=$ctacont='';
								$epsnit=buscadatofuncionario($row[0],'NUMARL');
								$epsnom=buscadatofuncionario($row[0],'NOMARL');
								//Cuenta debito ARL empleador
								$ctacont=cuentascontables::cuentadebito_parafiscales($_POST['parp'],$ccosto,$vigenomina, $_POST['fechafi']);
								$nresul=buscacuenta($ctacont);
								$listacuentas[]=$ctacont;
								$listanombrecuentas[]=$nresul;
								$listaterceros[]=$epsnit;
								$listanombreterceros[]=$epsnom;
								$listaccs[]=$ccosto;
								$listadetalles[]="Aportes ARL Mes $meslnomina";
								$listadebitos[]=$row[10];
								$listacreditos[]=0;
								$listatipo[]="P6<->DB";
								$aux=$iter;
								$iter=$iter2;
								$iter2=$aux;
								$con+=1;
								//Cuenta credito ARL empleado
								$ctaconcepto=cuentascontables::cuentacredito_parafiscales($_POST['parp'],$ccosto ,$vigenomina,$_POST['fechafi']);
								$nresul=buscacuenta($ctaconcepto);
								$listacuentas[]=$ctaconcepto;
								$listanombrecuentas[]=$nresul;
								$listaterceros[]=$epsnit;	
								$listanombreterceros[]=$epsnom;	
								$listaccs[]=$ccosto;
								$listadetalles[]="Aportes ARL Mes $meslnomina";
								$listadebitos[]=0;
								$listacreditos[]=$row[10];
								$listatipo[]="P6<->CR";
								$aux=$iter;
								$iter=$iter2;
								$iter2=$aux;
								$con+=1;
							}
							//COFREM
							if($row[11]!=0){$listacajacf[$ccosto][]=$row[11];}
							//SENA
							if($row[12]!=0){$listasena[$ccosto][]=$row[12];}
							//ICBF
							if($row[13]!=0){$listaicbf[$ccosto][]=$row[13];}
							//INSTITUTOS TEC
							if($row[14]!=0){$listainstecnicos[$ccosto][]=$row[14];}
							//ESAP
							if($row[15]!=0){$listaesap[$ccosto][]=$row[15];}
							if($row[20]!=0)//Retenciones
							{
								$ctaconcepto=$ctacont='';
								$sqlrd1="SELECT T1.valor,T2.tiporetencion FROM humnominaretenemp T1, hum_retencionesfun T2 WHERE T1.id_nom='".$_POST['idliq']."' AND T1.cedulanit='$row[0]' AND T1.id=T2.id AND T1.tipo_des='RE'";
								$respd1=mysqli_query($linkbd,$sqlrd1);
								while ($rowd1=mysqli_fetch_row($respd1))
								{
									$sqlcodi="SELECT T2.conceptoingreso,T1.nombre FROM tesoretenciones T1,tesoretenciones_det T2 WHERE T1.id=T2.codigo AND T1.id='$rowd1[1]'";
									$rescodi=mysqli_query($linkbd,$sqlcodi);
									$rowcodi=mysqli_fetch_row($rescodi);
									$sqlrcu="SELECT DISTINCT cuenta, debito, credito FROM conceptoscontables_det WHERE modulo='4' AND tipo='RI' AND cc='$ccosto' AND tipocuenta='N' AND codigo='$rowcodi[0]' AND fechainicial=(SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE fechainicial <=  '".$_POST['fechafi']."' AND modulo='4' AND tipo='RI' AND cc='$ccosto' AND tipocuenta='N' AND codigo='$rowcodi[0]')  ORDER BY credito";
									$respcu = mysqli_query($linkbd,$sqlrcu);
									while ($rowcu =mysqli_fetch_row($respcu)) 
									{
										$ctaconcepto=$rowcu[0];
										$docbenefi=$rowcu[1];
										$nomdescu=ucwords(strtolower($rowcu[0])); 
									}
									//Cuenta debito otras deducciones
									$ctacont=cuentascontables::cuentacredito_tipomov($row[19],$ccosto,$vigenomina,$_POST['fechafi']);
									$nresul=buscacuenta($ctacont);
									$listacuentas[]=$ctacont;
									$listanombrecuentas[]=$nresul;
									$listaterceros[]=$row[0];
									$listanombreterceros[]=$empleado;
									$listaccs[]=$row[18];
									$listadetalles[]="Retencion $rowcodi[1] Mes $meslnomina";
									$listadebitos[]=$rowd1[0];
									$listacreditos[]=0;
									$listatipo[]="RE<->DB";
									//Cuenta credito otras deducciones
									$nresul=buscacuenta($ctaconcepto);
									$listacuentas[]=$ctaconcepto;
									$listanombrecuentas[]=$nresul;
									$listaterceros[]=$row[0];
									$listanombreterceros[]=$empleado;
									$listaccs[]=$row[18];
									$listadetalles[]="Retención $rowcodi[1] Mes $meslnomina";
									$listadebitos[]=0;
									$listacreditos[]=$rowd1[0];
									$listatipo[]="RE<->CR";
									
								}
							}
						}
						$sqlrcc="SELECT id_cc FROM centrocosto WHERE estado='S' ORDER BY CONVERT(id_cc, SIGNED INTEGER)";
						$respcc = mysqli_query($linkbd,$sqlrcc);
						while ($rowcc =mysqli_fetch_row($respcc))
						{
							$totalcajacf=array_sum($listacajacf[$rowcc[0]]);
							$totalsena=array_sum($listasena[$rowcc[0]]);
							$totalicbf=array_sum($listaicbf[$rowcc[0]]);
							$totalinstecnicos=array_sum($listainstecnicos[$rowcc[0]]);
							$totalesap=array_sum($listaesap[$rowcc[0]]);
							if($totalcajacf!=0)//Caja de compensación familiar 
							{
								$ctaconcepto=$ctacont='';
								$parafiscal=$_POST['pcajacomp'];
								$nomparafiscal=buscatercero($_POST['cajacomp']);
								$nitparafiscal=$_POST['cajacomp'];
								$valparafiscal=$totalcajacf;
								//Cuenta debito Caja de compensación familiar
								$ctacont=cuentascontables::cuentadebito_parafiscales($parafiscal,$ccosto,$vigenomina, $_POST['fechafi']);
								$nresul=buscacuenta($ctacont);
								$listacuentas[]=$ctacont;
								$listanombrecuentas[]=$nresul;
								$listaterceros[]=$nitparafiscal;
								$listanombreterceros[]=$nomparafiscal;
								$listaccs[]=$rowcc[0];
								$listadetalles[]="Aportes Caja Compensación Mes $meslnomina";
								$listadebitos[]=$valparafiscal;
								$listacreditos[]=0;
								$listatipo[]="P1<->DB";
								$aux=$iter;
								$iter=$iter2;
								$iter2=$aux;
								$con+=1;
								//Cuenta credito Caja de compensación familiar
								$ctaconcepto=cuentascontables::cuentacredito_parafiscales($parafiscal,$ccosto, $vigenomina,$_POST['fechafi']);
								$nresul=buscacuenta($ctaconcepto);
								$listacuentas[]=$ctaconcepto;
								$listanombrecuentas[]=$nresul;
								$listaterceros[]=$nitparafiscal;
								$listanombreterceros[]=$nomparafiscal;
								$listaccs[]=$rowcc[0];
								$listadetalles[]="Aportes Caja Compensación Mes $meslnomina";
								$listadebitos[]=0;
								$listacreditos[]=$valparafiscal;
								$listatipo[]="P1<->CR";
								$aux=$iter;
								$iter=$iter2;
								$iter2=$aux;
								$con+=1;
							}
							if($totalicbf!=0)//ICBF
							{
								$ctaconcepto=$ctacont='';
								$parafiscal=$_POST['picbf'];
								$nomparafiscal=buscatercero($_POST['icbf']);
								$nitparafiscal=$_POST['icbf'];
								$valparafiscal=$totalicbf;
								//Cuenta debito ICBF
								$ctacont=cuentascontables::cuentadebito_parafiscales($parafiscal,$ccosto,$vigenomina, $_POST['fechafi']);
								$nresul=buscacuenta($ctacont);
								$listacuentas[]=$ctacont;
								$listanombrecuentas[]=$nresul;
								$listaterceros[]=$nitparafiscal;	
								$listanombreterceros[]=$nomparafiscal;	
								$listaccs[]=$rowcc[0];
								$listadetalles[]="Aportes ICBF Mes $meslnomina";
								$listadebitos[]=$valparafiscal;
								$listacreditos[]=0;
								$listatipo[]="P2<->DB";
								$aux=$iter;
								$iter=$iter2;
								$iter2=$aux;
								$con+=1;
								//Cuenta credito ICBF
								$ctaconcepto=cuentascontables::cuentacredito_parafiscales($parafiscal,$ccosto, $vigenomina,$_POST['fechafi']);
								$nresul=buscacuenta($ctaconcepto);
								$listacuentas[]=$ctaconcepto;
								$listanombrecuentas[]=$nresul;
								$listaterceros[]=$nitparafiscal;
								$listanombreterceros[]=$nomparafiscal;
								$listaccs[]=$rowcc[0];
								$listadetalles[]="Aportes ICBF Mes $meslnomina";
								$listadebitos[]=0;
								$listacreditos[]=$valparafiscal;
								$listatipo[]="P2<->CR";
								$aux=$iter;
								$iter=$iter2;
								$iter2=$aux;
								$con+=1;
							}
							if($totalsena!=0)//SENA
							{
								$ctaconcepto=$ctacont='';
								$parafiscal=$_POST['psena'];
								$nitparafiscal=$_POST['sena'];
								$nomparafiscal=buscatercero($_POST['sena']);
								$valparafiscal=$totalsena;
								//Cuenta debito SENA
								$ctacont=cuentascontables::cuentadebito_parafiscales($parafiscal,$ccosto,$vigenomina, $_POST['fechafi']);
								$nresul=buscacuenta($ctacont);
								$listacuentas[]=$ctacont;
								$listanombrecuentas[]=$nresul;
								$listaterceros[]=$nitparafiscal;
								$listanombreterceros[]=$nomparafiscal;
								$listaccs[]=$rowcc[0];
								$listadetalles[]="Aportes SENA Mes $meslnomina";
								$listadebitos[]=$valparafiscal;
								$listacreditos[]=0;
								$listatipo[]="P3<->DB";
								$aux=$iter;
								$iter=$iter2;
								$iter2=$aux;
								$con+=1;
								//Cuenta credito ICBF
								$ctaconcepto=cuentascontables::cuentacredito_parafiscales($parafiscal,$ccosto, $vigenomina,$_POST['fechafi']);
								$nresul=buscacuenta($ctaconcepto);
								$listacuentas[]=$ctaconcepto;
								$listanombrecuentas[]=$nresul;
								$listaterceros[]=$nitparafiscal;
								$listanombreterceros[]=$nomparafiscal;
								$listaccs[]=$rowcc[0];
								$listadetalles[]="Aportes SENA Mes $meslnomina";
								$listadebitos[]=0;
								$listacreditos[]=$valparafiscal;
								$listatipo[]="P3<->CR";
								$aux=$iter;
								$iter=$iter2;
								$iter2=$aux;
								$con+=1;
							}
							if($totalinstecnicos!=0)//Institutos Tecnicos
							{
								$ctaconcepto=$ctacont='';
								$parafiscal=$_POST['piti'];
								$nitparafiscal=$_POST['iti'];
								$nomparafiscal=buscatercero($_POST['iti']);
								$valparafiscal=$totalinstecnicos;
								//Cuenta debito Inst tecnicos 
								$ctacont=cuentascontables::cuentadebito_parafiscales($parafiscal,$ccosto,$vigenomina, $_POST['fechafi']);
								$nresul=buscacuenta($ctacont);
								$listacuentas[]=$ctacont;
								$listanombrecuentas[]=$nresul;
								$listaterceros[]=$nitparafiscal;	
								$listanombreterceros[]=$nomparafiscal;	
								$listaccs[]=$rowcc[0];
								$listadetalles[]="Aportes Inst técnicos Mes $meslnomina";
								$listadebitos[]=$valparafiscal;
								$listacreditos[]=0;
								$listatipo[]="P4<->DB";
								$aux=$iter;
								$iter=$iter2;
								$iter2=$aux;
								$con+=1;
								//Cuenta credito Inst tecnicos 
								$ctaconcepto=cuentascontables::cuentacredito_parafiscales($parafiscal,$ccosto, $vigenomina,$_POST['fechafi']);
								$nresul=buscacuenta($ctaconcepto);
								$listacuentas[]=$ctaconcepto;
								$listanombrecuentas[]=$nresul;
								$listaterceros[]=$nitparafiscal;	
								$listanombreterceros[]=$nomparafiscal;	
								$listaccs[]=$rowcc[0];
								$listadetalles[]="Aportes Inst técnicos Mes $meslnomina";
								$listadebitos[]=0;
								$listacreditos[]=$valparafiscal;
								$listatipo[]="P4<->CR";
								$aux=$iter;
								$iter=$iter2;
								$iter2=$aux;
								$con+=1;
							}
							if($totalesap!=0)//ESAP
							{
								$ctaconcepto=$ctacont='';
								$parafiscal=$_POST['pesap'];
								$nitparafiscal=$_POST['esap'];
								$nomparafiscal=buscatercero($_POST['esap']);
								$valparafiscal=$totalesap;
								//Cuenta debito ESAP
								$ctacont=cuentascontables::cuentadebito_parafiscales($parafiscal,$ccosto,$vigenomina, $_POST['fechafi']);
								$nresul=buscacuenta($ctacont);
								$listacuentas[]=$ctacont;
								$listanombrecuentas[]=$nresul;
								$listaterceros[]=$nitparafiscal;
								$listanombreterceros[]=$nomparafiscal;
								$listaccs[]=$rowcc[0];
								$listadetalles[]="Aportes ESAP Mes $meslnomina";
								$listadebitos[]=$valparafiscal;
								$listacreditos[]=0;
								$listatipo[]="P5<->DB";
								$aux=$iter;
								$iter=$iter2;
								$iter2=$aux;
								$con+=1;
								//Cuenta credito Inst tecnicos 
								$ctaconcepto=cuentascontables::cuentacredito_parafiscales($parafiscal,$ccosto, $vigenomina,$_POST['fechafi']);
								$nresul=buscacuenta($ctaconcepto);
								$listacuentas[]=$ctaconcepto;
								$listanombrecuentas[]=$nresul;
								$listaterceros[]=$nitparafiscal;
								$listanombreterceros[]=$nomparafiscal;
								$listaccs[]=$rowcc[0];
								$listadetalles[]="Aportes ESAP Mes $meslnomina";
								$listadebitos[]=0;
								$listacreditos[]=$valparafiscal;
								$listatipo[]="P5<->CR";
								$aux=$iter;
								$iter=$iter2;
								$iter2=$aux;
								$con+=1;
							}
						}
					}
					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST['fecha'],$fecha);
					$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
					$lastday = mktime (0,0,0,$_POST['periodo'],1,$vigenomina);
					$sqlr="INSERT INTO comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito, diferencia,estado) VALUES ('".$_POST['idliq']."',4,'$fechaf','CAUSACION $primanom MES $meslnomina',0,0,0,0,'1')";
					mysqli_query($linkbd,$sqlr);
					for ($x=0;$x<count($listacuentas);$x++) 
					{
						$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito, estado,vigencia) VALUES ('4 ".$_POST['idliq']."','$listacuentas[$x]','$listaterceros[$x]','$listaccs[$x]', '$listadetalles[$x]','','$listadebitos[$x]','$listacreditos[$x]','1', '$vigenomina')";
						mysqli_query($linkbd,$sqlr);
					}
				}
			?>
		</form>
		<div id="bgventanamodal2">
			<div id="ventanamodal2">
				<IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
				</IFRAME>
			</div>
		</div>
	</body>
</html>