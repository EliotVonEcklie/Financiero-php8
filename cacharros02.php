<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	header("Content-Type: text/html;charset=iso-8859-1");
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=iso-8859-1"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Spid - Tesoreria</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js"></script>
		<script>
			function procesos(){document.form2.oculto.value='2';document.form2.submit();}
		</script>
		<?php titlepag(); ?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("teso");?></tr>
		</table>
		<form name="form2" method="post" action="">
			<table class="inicio">
				<tr>
					<td class="titulos" colspan="7">ARREGLO CACHARROS VARIOS</td>
					<td class="cerrar" style="width:7%" onClick="location.href='teso-principal.php'">Cerrar</td>
				</tr>
				<tr>
					<td class="saludo1" style="width:2.5cm;">.: Inicio:</td>
					<td style="width:10%;"><input type="text" name="varini" id="varini" value="<?php echo @ $_POST['varini']?>" style="width:100%"/></td>
					<td class="saludo1" style="width:2.5cm;">.: Fin:</td>
					<td style="width:10%;"><input type="text" name="varfin" id="varfin" value="<?php echo @ $_POST['varfin']?>" style="width:100%"/></td>
					<td></td>
				</tr>
				<tr>
					<td class="saludo1">.: Proceso:</td>
					<td colspan="4" style='height:28px;'>
						<select name="selecob" id="selecob" style='text-transform:uppercase; width:100%; height:22px;'>
							<option value="">....</option>
							<option value='1' <?php if(@ $_POST['selecob']=='1'){echo "SELECTED";}?>>1: cuadrar centro de costo en nomina</option>
							<option value='2' <?php if(@ $_POST['selecob']=='2'){echo "SELECTED";}?>>2: cuadrar centro de costo en egresos nomina</option>
							<option value='3' <?php if(@ $_POST['selecob']=='3'){echo "SELECTED";}?>>3: cuadrar codigo funcionarios en nomina</option>
							<option value='4' <?php if(@ $_POST['selecob']=='4'){echo "SELECTED";}?>>4: cuadrar centro de costo en egresos nomina descuentos</option>
							<option value='5' <?php if(@ $_POST['selecob']=='5'){echo "SELECTED";}?>>5: llenar valordebangado en egreso de nomina</option>
							<option value='6' <?php if(@ $_POST['selecob']=='6'){echo "SELECTED";}?>>6: llenar listado de activos - depreciar</option>
							<option value='7' <?php if(@ $_POST['selecob']=='7'){echo "SELECTED";}?>>7: cuadrar cuenta de presupuestal egresos nomina</option>
							<option value='8' <?php if(@ $_POST['selecob']=='8'){echo "SELECTED";}?>>8: Verificar formatos para E&ntilde;es y Tildes HTML</option>
							<option value='9' <?php if(@ $_POST['selecob']=='9'){echo "SELECTED";}?>>9: Verificar formatos para E&ntilde;es y Tildes PDF</option>
							<option value='10' <?php if(@ $_POST['selecob']=='10'){echo "SELECTED";}?>>10: Corregir Egresos de Nomina</option>
							<option value='11' <?php if(@ $_POST['selecob']=='11'){echo "SELECTED";}?>>11: corregir cuanta presupuestal en el egreso de nomina</option>
							<option value='12' <?php if(@ $_POST['selecob']=='12'){echo "SELECTED";}?>>11: agregar cuentas bancos que no se agregaron con archivo plano pago predial</option>
						</select>
							<td style="padding-bottom:5px" colspan="2"><em class="botonflecha" onClick="procesos();">Correr</em></td>
					<td></td>
				</tr>
			</table>
			<input type="hidden" name="oculto" id="oculto" value="1"/> 
			<?php
				echo "Tu direcci�n IP es: {$_SERVER['REMOTE_ADDR']}";
				if(@ $_POST['oculto']==2)
				{
					if((@ $_POST['varini'] != '') && (@ $_POST['varfin'] != ''))
					{
						switch (@ $_POST['selecob'])
						{
							case '1':	//**********para cuadrar centro de costo en nomina
							{
								$sql1="SELECT cedulanit,id_nom FROM humnomina_det WHERE id_nom <= '$_POST[varini]'";
								$res1=mysql_query($sql1,$linkbd);
								while($row1=mysql_fetch_row($res1))
								{
									$sql2="SELECT GROUP_CONCAT(T1.descripcion ORDER BY CONVERT(T1.codrad, SIGNED INTEGER) SEPARATOR '<->')
		FROM hum_funcionarios T1 WHERE (T1.item = 'NUMCC') AND T1.estado='S' 
		AND (SELECT T2.codfun FROM hum_funcionarios T2 WHERE T2.descripcion='$row1[0]' AND T2.estado='S' AND T2.codfun=T1.codfun AND T2.item='DOCTERCERO') GROUP BY T1.codfun ORDER BY CONVERT(T1.codfun, SIGNED INTEGER)";
									$res2=mysql_query($sql2,$linkbd);
									$row2=mysql_fetch_row($res2);
									$sql3="UPDATE humnomina_det SET cc='$row2[0]' WHERE id_nom='$row1[1]' AND cedulanit='$row1[0]'";
									mysql_query($sql3,$linkbd);
								}
							}break;
							case '2':	//**********para cuadrar centro de costo en egresos nomina
							{
								$facini=$_POST[varini];
								$facfin=$_POST[varfin];
								for ($xy = $facini; $xy <= $facfin; $xy++)
								{
									$sql1="SELECT tercero,id_det FROM tesoegresosnomina_det WHERE id_egreso = '$xy' AND tipo='01'";
									$res1=mysql_query($sql1,$linkbd);
									while($row1=mysql_fetch_row($res1))
									{
										$sql2="SELECT GROUP_CONCAT(T1.descripcion ORDER BY CONVERT(T1.codrad, SIGNED INTEGER) SEPARATOR '<->')
		FROM hum_funcionarios T1 WHERE (T1.item = 'NUMCC') AND T1.estado='S' 
		AND (SELECT T2.codfun FROM hum_funcionarios T2 WHERE T2.descripcion='$row1[0]' AND T2.estado='S' AND T2.codfun=T1.codfun AND T2.item='DOCTERCERO') GROUP BY T1.codfun ORDER BY CONVERT(T1.codfun, SIGNED INTEGER)";
										$res2=mysql_query($sql2,$linkbd);
										$row2=mysql_fetch_row($res2);
										if($row2[0]!='')
										{
											$sql3="UPDATE tesoegresosnomina_det SET cc='$row2[0]' WHERE id_det='$row1[1]'";
											mysql_query($sql3,$linkbd);
										}
									}
								}
							}break;
							case '3': 	//**********para cuadrar codigo funcionarios en nomina
							{
								$sql1="SELECT cedulanit,id_nom FROM humnomina_det WHERE id_nom <= '$_POST[varini]'";
								$res1=mysql_query($sql1,$linkbd);
								while($row1=mysql_fetch_row($res1))
								{
									$sql2="SELECT codfun, GROUP_CONCAT(T1.descripcion ORDER BY CONVERT(T1.codrad, SIGNED INTEGER) SEPARATOR '<->')
				FROM hum_funcionarios T1 WHERE (T1.item = 'NUMCC') AND T1.estado='S' 
				AND (SELECT T2.codfun FROM hum_funcionarios T2 WHERE T2.descripcion='$row1[0]' AND T2.estado='S' AND T2.codfun=T1.codfun AND T2.item='DOCTERCERO') GROUP BY T1.codfun ORDER BY CONVERT(T1.codfun, SIGNED INTEGER)";
									$res2=mysql_query($sql2,$linkbd);
									$row2=mysql_fetch_row($res2);
									$sql3="UPDATE humnomina_det SET idfuncionario='$row2[0]' WHERE id_nom='$row1[1]' AND cedulanit='$row1[0]'";
									mysql_query($sql3,$linkbd);
								}
							}break;
							case '4':	//**********para cuadrar centro de costo en egresos nomina descuentos
							{
								$facini=$_POST[varini];
								$facfin=$_POST[varfin];
								for ($xy = $facini; $xy <= $facfin; $xy++)
								{
									$sql1="SELECT ndes,id_det FROM tesoegresosnomina_det WHERE id_egreso = '$xy' AND tipo='DS'";
									$res1=mysql_query($sql1,$linkbd);
									while($row1=mysql_fetch_row($res1))
									{
										$ccfunc=ccdescuentoconid($row1[0]);
										$sql3="UPDATE tesoegresosnomina_det SET cc='$ccfunc' WHERE id_det='$row1[1]'";
										mysql_query($sql3,$linkbd);
									}
								}
							}break;
							case '5':	//**********para llenar valordebangado en egreso de nomina
							{
								$facini=$_POST[varini];
								$facfin=$_POST[varfin];
								for ($xy = $facini; $xy <= $facfin; $xy++)
								{
									$sql1="SELECT tipo,valor,id_det FROM tesoegresosnomina_det WHERE id_egreso = '$xy'";
									$res1=mysql_query($sql1,$linkbd);
									while($row1=mysql_fetch_row($res1))
									{
										switch($row1[0])
										{
											case '':	break;
											case 'SR':	//**** Tipo SR: Pago Salud Empresa ****
											case 'SE':	//**** Tipo SE: Pago Salud Empleado ****
											case 'PR':	//**** Tipo PR: Pago Pension Empresa ****
											case 'PE':	//**** Tipo PE: Pago Pension Empleado ****
											case 'F':	//**** Tipo F: Pago Parafiscales ****
											case 'DS':	//**** Tipo DS: Pago Descuentos Empleado ****
											case 'RE':	//**** Tipo DS: Pago Descuentos Empleado ****
											{
														$sql2="UPDATE tesoegresosnomina_det SET valordevengado='$row1[1]' WHERE id_det='$row1[2]'";
														mysql_query($sql2,$linkbd);
														break;
											}
											default:	//**** Tipo N: Pago Salarios ****
											{
														$sql2="UPDATE tesoegresosnomina_det T1 JOIN humnomina_det T2 ON T2.id_nom=T1.id_orden AND T2.cedulanit=T1.tercero AND T1.tipo=T2.tipopago SET T1.valordevengado = T2.devendias WHERE id_det='$row1[2]' ";
														mysql_query($sql2,$linkbd);
														break;
											}
										}
									}
								}
							}break;
							case '6':	//**********para Listado de Activos - depreciar
							{
								$facini=$_POST[varini];
								$facfin=$_POST[varfin];
								for ($xy = $facini; $xy <= $facfin; $xy++)
								{
									$sql1="SELECT id,placa FROM actidepactivo_det WHERE id_dep = '$xy'";
									$res1=mysql_query($sql1,$linkbd);
									while($row1=mysql_fetch_row($res1))
									{
										$sql2="SELECT fechact,nombre,valor,saldodepact FROM acticrearact_det WHERE placa = '$row1[1]'";
										$res2=mysql_query($sql2,$linkbd);
										$row2=mysql_fetch_row($res2);
										$clase=substr($row1[1],0,1);
										$nivel1=substr($row1[1],1,2);
										$nivel2=substr($row1[1],3,3);
										$sqlclase = "SELECT nombre FROM actipo where codigo='$clase' ";
										$resclase = mysql_query($sqlclase,$linkbd);
										$rwclase = mysql_fetch_row($resclase);
										$sqlgrupo = "SELECT nombre FROM actipo where codigo='$nivel1' and niveluno='$clase' ";
										$resgrupo = mysql_query($sqlgrupo,$linkbd);
										$rwgrupo = mysql_fetch_row($resgrupo);
										$sqltipo = "SELECT nombre FROM actipo where codigo='$nivel2' and niveluno='$nivel1' AND niveldos='$clase' ";
										$restipo = mysql_query($sqltipo,$linkbd);
										$rwtipo = mysql_fetch_row($restipo);
										$sq="SELECT valdebito FROM comprobante_det WHERE valdebito!='0' AND numacti='$row1[1]' and tipo_comp='100'";
										$rs=mysql_query($sq,$linkbd);
										$rw=mysql_fetch_row($rs);
										$valord=floatval($rw[0]);
										$valxdep=round($row2[2]-$valord,2);
										$sql3="UPDATE actidepactivo_det SET fechact='$row2[0]', nombre='$row2[1]', clase='$rwclase[0]', grupo='$rwgrupo[0]', tipo='$rwtipo[0]', valor='$row2[2]', valord='$valord', valorad='$valxdep' WHERE id='$row1[0]'";
										mysql_query($sql3,$linkbd);
									}
									
								}
							}break;
							case '7':	//**********para cuadrar cuenta de presupuestal egresos nomina
							{
								$facini=$_POST[varini];
								$facfin=$_POST[varfin];
								for ($xy = $facini; $xy <= $facfin; $xy++)
								{
									$sql1="SELECT T1.id_det,T1.cc,T1.tipo,T2.vigencia,T1.ndes FROM tesoegresosnomina_det T1 INNER JOIN tesoegresosnomina T2 ON T1.id_egreso = T2.id_egreso WHERE T1.id_egreso = '$xy'";
									$res1=mysql_query($sql1,$linkbd);
									while($row1=mysql_fetch_row($res1))
									{
										switch ($row1[2])
										{
											case 'SR':
											{
											
											}break;
											case 'SE':
											{

											}break;
											case 'PR':
											{
												$sql2="SELECT cuentapres FROM humparafiscales_det WHERE codigo='09' AND cc='$row1[1]' AND vigencia='$row1[3]'";
												$res2=mysql_query($sql2,$linkbd);
												$row2=mysql_fetch_row($res2);
												if($row2[0]!='')
												{
													$sql3="UPDATE tesoegresosnomina_det SET cuentap='$row2[0]' WHERE id_det='$row1[0]'";
													mysql_query($sql3,$linkbd);
												}
											}break;
											case 'PE':
											{
												
											}break;
											case 'F':
											{
												
											}break;
											default:	$sql2="SELECT cuentapres FROM humvariables_det WHERE modulo=2 AND codigo='$row1[2]' AND cc='$row1[1]' AND vigencia='$row1[3]'";
														$res2=mysql_query($sql2,$linkbd);
														$row2=mysql_fetch_row($res2);
														if($row2[0]!='')
														{
															$sql3="UPDATE tesoegresosnomina_det SET cuentap='$row2[0]' WHERE id_det='$row1[0]'";
															mysql_query($sql3,$linkbd);
														}break;
										}
										
									}
								}
							}break;
							case '8':	//**********Verificar formato para eñes y tildes HTML
							{
								echo"
								<div class='subpantalla' style='height:68.5%; width:99.6%; overflow-x:hidden;'>
									<table class='inicio'>";
								$co="saludo1a";
								$co2="saludo2";
								$tab = array("UTF-8", "ASCII", "Windows-1252", "ISO-8859-15", "ISO-8859-1", "ISO-8859-6", "CP1256"); 
								$chain = ""; 
								foreach ($tab as $i) 
								{ 
									foreach ($tab as $j) 
									{
										$chain = "($i) - ($j) - (".iconv($i, $j, "PRUEBA: Ñ ñ á é í ó ú Á É Í Ó Í Ú").")";
										echo "<tr class='$co'><td>$chain</td></tr>";
										$aux=$co;
										$co=$co2;
										$co2=$aux;
									} 
									 
								}
								echo"</table></div>";
								
							}break;
							case '9':	//**********Verificar formato para eñes y tildes PDF
							{
								echo"
								<script>
									document.form2.action='cacharros02pdf8.php';
									document.form2.target='_BLANK';
									document.form2.submit(); 
									document.form2.action='';
									document.form2.target='';
								</script>";
							}break;
							case '10':	//**********Verificar formato para eñes y tildes PDF
							{
								$facini=$_POST[varini];
								$facfin=$_POST[varfin];
								for ($xy = $facini; $xy <= $facfin; $xy++)
								{
									
								}
							}break;
							case '11':	//**********corregir cuanta presupuestal en el egreso de nomina
							{
								$facini=$_POST[varini];
								$facfin=$_POST[varfin];
								for ($xy = $facini; $xy <= $facfin; $xy++)
								{
									$sql1="SELECT T1.id_det,T1.tipo,T1.cc,T1.ndes,T2.vigencia FROM tesoegresosnomina_det T1 JOIN tesoegresosnomina T2 ON T2.id_egreso=T1.id_egreso WHERE T1.id_egreso = '$xy'";
									$res1=mysql_query($sql1,$linkbd);
									while($row1=mysql_fetch_row($res1))
									{
										switch($row1[1])
										{
											case 'SR':	//**** Tipo SR: Pago Salud Empresa ****
											case 'SE':	//**** Tipo SE: Pago Salud Empleado ****
											case 'PR':	//**** Tipo PR: Pago Pension Empresa ****
											case 'PE':	//**** Tipo PE: Pago Pension Empleado ****
											case 'F':	//**** Tipo F: Pago Parafiscales ****
											{
												$sql2="SELECT cuentapres FROM humparafiscales_det WHERE codigo='$row1[3]' AND cc='$row1[2]' AND vigencia='$row1[4]' ORDER BY codigo ASC";
												$res2=mysql_query($sql2,$linkbd);
												$row2=mysql_fetch_row($res2);
												$sql3="UPDATE tesoegresosnomina_det SET cuentap='$row2[0]' WHERE id_det='$row1[0]'";
												mysql_query($sql3,$linkbd);
												break;
											}
											case 'DS':	//***+ Tipo DS: Pago Descuentos Empleado ****
											break;
											case 'RE':	//***+ Tipo DR: Pago Retenciones Empleado ****
											break;
											default:	//**** Tipo N: Pago Salarios ****
											{
												$sql2="SELECT cuentapres FROM humvariables_det WHERE codigo='$row1[1]' AND modulo='2' AND cc= '$row1[2]' AND vigencia='$row1[4]' ORDER BY codigo ASC";
												$res2=mysql_query($sql2,$linkbd);
												$row2=mysql_fetch_row($res2);
												$sql3="UPDATE tesoegresosnomina_det SET cuentap='$row2[0]' WHERE id_det='$row1[0]'";
												mysql_query($sql3,$linkbd);
											}
										}
									}
								}
							}break;
							
						}
					}
					else{echo "error contenido inicial";}
					echo "OK";
				}
			?>
		</form>
	</body>
</html>