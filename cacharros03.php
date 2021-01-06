<?php
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=iso-8859-1");
	require 'comun.inc';
	require 'funciones.inc';
	require 'validaciones.inc';
	session_start();
	$linkbd=conectar_v7();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	date_default_timezone_set("America/Bogota");
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=iso-8859-1"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Spid - Tesoreria</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<style>
			.example1
			{
				font-size: 3em;
				color: limegreen;
				position: absolute;
				width: 100%;
				height: 100%;
				margin: 0;
				line-height: 50px;
				text-align: center;
				transform:translateX(100%);/* Starting position */
				animation: example1 15s linear infinite;/* Apply animation to this element */
			}
			@keyframes example1 /* Move it (define the animation) */
			{
				0% {transform: translateX(100%);}
				100% {transform: translateX(-100%);}
			}
		</style>
		<script type="text/javascript" src="css/programas.js"></script>
		<script>
			function procesos(){document.form2.oculto.value='2';document.form2.submit();}
		</script>
		<?php 
			titlepag();
			function traercuentapresu($tipo,$cc,$vigencia,$sector)
			{
				$linkbd=conectar_v7();
				if($sector!='')
				{
					if($sector=='PR'){$tpf='privado';}
					else {$tpf='publico';}
					$adic="AND sector='$tpf'";
				}
				else{$adic="";}
				$sqlr="SELECT cuentapres FROM humparafiscales_det WHERE codigo='$tipo' AND cc='$cc' AND estado='S' AND vigencia='$vigencia' $adic";
				$res= mysqli_query($linkbd,$sqlr);
				$r=mysqli_fetch_row($res);
				return $r[0];
			}
			function traercuentapresu2($tipo,$cc,$vigencia)
			{
				$linkbd=conectar_v7();
				$sqlr="SELECT cuentapres FROM humvariables_det WHERE codigo='$tipo' AND cc='$cc' AND estado='S' AND vigencia='$vigencia'";
				$res= mysqli_query($linkbd,$sqlr);
				$r=mysqli_fetch_row($res);
				return $r[0];
			}
		?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("hum");</script><?php cuadro_titulos();?></tr>
			<tr><?php menu_desplegable("hum");?></tr>
		</table>
		<form name="form2" method="post" action="">
			<table class="inicio">
				<tr>
					<td class="titulos" colspan="7">ARREGLO CACHARROS VARIOS</td>
					<td class="cerrar" style="width:7%" onClick="location.href='teso-principal.php'">Cerrar</td>
				</tr>
				<tr>
					<td class="saludo1" style="width:2.5cm;">.: Inicio:</td>
					<td style="width:10%;"><input type="text" name="varini" id="varini" value="<?php echo @$_POST['varini']?>" style="width:100%"/></td>
					<td class="saludo1" style="width:2.5cm;">.: Fin:</td>
					<td style="width:10%;"><input type="text" name="varfin" id="varfin" value="<?php echo @$_POST['varfin']?>" style="width:100%"/></td>
					<td></td>
				</tr>
				<tr>
					<td class="saludo1">.: Proceso:</td>
					<td colspan="4" style='height:28px;'>
						<select name="selecob" id="selecob" style='text-transform:uppercase; width:100%; height:22px;'>
							<option value="">....</option>
							<option value='1' <?php if(@$_POST['selecob']=='1'){echo "SELECTED";}?>>1: Recalcular las cuentas presupuestales de nomina (ingresar No Nomina)</option>
							<option value='2' <?php if(@$_POST['selecob']=='2'){echo "SELECTED";}?>>2: Recalcular los aportes Parafiscales (ingresar No Nomina)</option>
						</select>
					<td style="padding-bottom:5px" colspan="2"><em class="botonflecha" onClick="procesos();">Correr</em></td>
					<td></td>
				</tr>
			</table>
			<input type="hidden" name="oculto" id="oculto" value="1"/>
			<?php
				if(@$_POST['oculto']==2)
				{
					switch ($_POST['selecob'])
					{
						case '1':	// Recalcular las cuentas presupuestales de nomina
						{
							if($_POST['varini']!='')
							{
								$pfcp=array();
								$sqlrg="SELECT * FROM humnomina WHERE id_nom='".$_POST['varini']."'";
								$respg=mysqli_query($linkbd,$sqlrg);
								$rowg=mysqli_fetch_row($respg);
								$fecha=$rowg[1];
								$vigencia=$rowg[7];
								$cont=0;
								$sqlrt="SELECT * FROM humnomina_det WHERE id_nom='".$_POST['varini']."'";
								$respt = mysqli_query($linkbd,$sqlrt);
								while ($rowt =mysqli_fetch_row($respt)) 
								{
									$cont++;
									@$pfcp[traercuentapresu2($rowt[36],$rowt[34],$vigencia)]+=$rowt[9];//neto apagar
									@$pfcp[traercuentapresu('07',$rowt[34],$vigencia)]+=$rowt[11];//salud empresa
									@$pfcp[traercuentapresu('09',$rowt[34],$vigencia,$rowt[27])]+=$rowt[13];//pension empresa
									@$pfcp[traercuentapresu('06',$rowt[34],$vigencia)]+=$rowt[30];//arl
									@$pfcp[traercuentapresu('01',$rowt[34],$vigencia)]+=$rowt[22];//ccf
									@$pfcp[traercuentapresu('03',$rowt[34],$vigencia)]+=$rowt[23];//sena
									@$pfcp[traercuentapresu('02',$rowt[34],$vigencia)]+=$rowt[24];//icbf
									@$pfcp[traercuentapresu('04',$rowt[34],$vigencia)]+=$rowt[25];//institec
									@$pfcp[traercuentapresu('05',$rowt[34],$vigencia)]+=$rowt[26];//esap
								}
								echo"
									<div class='content' style='overflow-x:hidden'>
										<table class='inicio'>
											<tr>
												<td class='titulos'>Cuenta Presupuestal</td>
												<td class='titulos'>Nombre Cuenta Presupuestal</td>
												<td class='titulos'>Valor</td>
												<td class='titulos' style='width:5%'>Saldo</td>
											</tr>";
								$totalrubro=0;
								$iter="zebra1";
								$iter2="zebra2";
								foreach($pfcp as $k => $valrubros)
								{
									$ncta=existecuentain($k);
									if($valrubros>0)
									{
										$saldo="";
										$vsal=generaSaldo($k,$vigencia,$vigencia);
										if($vsal>=$valrubros)
										{
											$saldo="OK";
											$color=" style='text-align:center;background-color :#092; color:#fff' ";
										}
										else
										{
											@$_POST['saldocuentas']="1";
											$saldo="SIN SALDO";
											$color=" style='text-align:center;background-color :#901; color:#fff' ";
										}
										echo "
										<input type='hidden' name='rubrosp[]' value='$k'/>
										<input type='hidden' name='nrubrosp[]' value='".strtoupper(iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$ncta))."'/>
										<input type='hidden' name='vrubrosp[]' value='$valrubros'/>
										<input type='hidden' name='vsaldo[]' value='$saldo'/>
										<tr class='$iter'>
											<td>$k</td>
											<td>".strtoupper(iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$ncta))."</td>
											<td style='text-align:right;'>".number_format($valrubros,0)."</td>
											<td $color>".$saldo."</td>
										</tr>";
										$totalrubro+=$valrubros;
										$aux=$iter;
										$iter=$iter2;
										$iter2=$aux;
									}
								}
								echo"
										<tr class='$iter'>
											<td></td>
											<td style='text-align:right;'>Total:</td>
											<td style='text-align:right;'>".number_format($totalrubro,2)."</td>
										</tr>
									</tabla>
								</div>";
								if(@$_POST['varfin']=='SI')
								{
									$sql="SELECT cdp,rp FROM hum_nom_cdp_rp WHERE nomina='".$_POST['varini']."'";
									$res=mysqli_query($linkbd,$sql);
									$row=mysqli_fetch_row($res);
									$ncdp=$row[0];
									$nrp=$row[1];
									//******Borrar Presupupuesto nomina
									$sqld="DELETE FROM humnom_presupuestal WHERE id_nom='".$_POST['varini']."'";
									$resd=mysqli_query($linkbd,$sqld);
									//******Borrar Presupupuesto CDP
									$sqld="DELETE FROM pptocdp_detalle WHERE consvigencia='$ncdp' AND vigencia='$vigencia'";
									$resd=mysqli_query($linkbd,$sqld);
									//******Borrar Presupupuesto RP
									$sqld="DELETE FROM pptorp_detalle WHERE consvigencia='$nrp' AND vigencia='$vigencia'";
									$resd=mysqli_query($linkbd,$sqld);
									for ($x=0; $x < count(@$_POST['rubrosp']); $x++)
									{
										//******Crear Presupupuesto nomina
										$sqli="INSERT INTO humnom_presupuestal (id_nom,cuenta,valor,estado) VALUES ('".$_POST['varini']."', '".$_POST['rubrosp'][$x]."','".$_POST['vrubrosp'][$x]."','S')";
										$resi=mysqli_query($linkbd,$sqli);
										//******Crear Presupupuesto CDP
										$fuente=buscafuenteppto($_POST['rubrosp'][$x],$vigencia);
										$infofte = explode("_", $fuente);
										$sqli="INSERT INTO pptocdp_detalle (id_cdpdetalle,vigencia,consvigencia,cuenta,fuente,valor,estado, saldo,saldo_liberado,tipo_mov) VALUES ('','$vigencia','$ncdp','".$_POST['rubrosp'][$x]."', '$infofte[0]','".$_POST['vrubrosp'][$x]."','S','0','0','201')";
										$resi=mysqli_query($linkbd,$sqli);
										//******Crear Presupupuesto RP
										$sqli="INSERT INTO pptorp_detalle (id_cdpdetalle,vigencia,consvigencia,cuenta,fuente,valor,estado, saldo,saldo_liberado,tipo_mov) VALUES ('','$vigencia','$nrp','".$_POST['rubrosp'][$x]."', '$infofte[0]','".$_POST['vrubrosp'][$x]."','S','".$_POST['vrubrosp'][$x]."','0','201')";
										$resi=mysqli_query($linkbd,$sqli);
									}
									//******Modifica Valor Total Presupupuesto CDP
									$sql="UPDATE pptocdp SET valor='$totalrubro' WHERE vigencia='$vigencia' AND consvigencia='$ncdp'";
									$res=mysqli_query($linkbd,$sql);
									//******Modifica Valor Total Presupupuesto RP
									$sql="UPDATE pptorp SET valor='$totalrubro' WHERE vigencia='$vigencia' AND consvigencia='$nrp'";
									$res=mysqli_query($linkbd,$sql);
								}
								echo "<h3 class='example1'>OK</h3>";
								
							}
							else{echo "<h3 class='example1'>Error agrega numero de nomina en inicio</h3>";}
						}break;
						case '2':	//Recalcular los aportes Parafiscales
						{
							if($_POST['varini']!='')
							{
								$pf[]=array();
								if(@$_POST['varfin']=='SI')
								{
									//******Borrar tabla salud y pesion
									$sqld="DELETE FROM humnomina_saludpension WHERE id_nom='".$_POST['varini']."'";
									$resd=mysqli_query($linkbd,$sqld);
									//******Borrar tabla parafiscales
									$sqld="DELETE FROM humnomina_parafiscales WHERE id_nom='".$_POST['varini']."'";
									$resd=mysqli_query($linkbd,$sqld);
								}
								$sqlrg="SELECT * FROM humnomina WHERE id_nom='".$_POST['varini']."'";
								$respg=mysqli_query($linkbd,$sqlrg);
								$rowg=mysqli_fetch_row($respg);
								$fecha=$rowg[1];
								$vigencia=$rowg[7];
								$cont=0;
								$sqlrt="SELECT * FROM humnomina_det WHERE id_nom='".$_POST['varini']."'";
								$respt = mysqli_query($linkbd,$sqlrt);
								$sumaarl = $sumaccf = $sumasena = $sumaicbf = $sumaintec = $sumaesap = $sumasaludfu = $sumasaludem = $sumapensionfu = $sumapensionem = $sumafondosol = 0;
								while ($rowt =mysqli_fetch_row($respt)) 
								{
									$cont++;
									@$pf['06'][$rowt[34]]+=$rowt[30];//arl
									@$pf['01'][$rowt[34]]+=$rowt[22];//ccf
									@$pf['03'][$rowt[34]]+=$rowt[23];//sena
									@$pf['02'][$rowt[34]]+=$rowt[24];//icbf
									@$pf['04'][$rowt[34]]+=$rowt[25];//institec
									@$pf['05'][$rowt[34]]+=$rowt[26];//esap
									$sumaarl+=$rowt[30];
									$sumaccf+=$rowt[22];
									$sumasena+=$rowt[23];
									$sumaicbf+=$rowt[24];
									$sumaintec+=$rowt[25];
									$sumaesap+=$rowt[26];
									$sumasaludfu+=$rowt[10];
									$sumasaludem+=$rowt[11];
									$sumapensionfu+=$rowt[12];
									$sumapensionem+=$rowt[13];
									$sumafondosol+=$rowt[14];
									if(@$_POST['varfin']=='SI')
									{
										if($rowt[10]>0)//********SALUD EMPLEADO *****
										{
											$idsalud=selconsecutivo('humnomina_saludpension','id');
											$sqli="SELECT descripcion FROM hum_funcionarios WHERE item = 'NUMEPS' AND codfun='$rowt[38]' AND estado='S'";
											$resi = mysqli_query($linkbd,$sqli);
											$rowi =mysqli_fetch_row($resi);
											$sqlrins="INSERT INTO humnomina_saludpension (id_nom,tipo,empleado,tercero,cc,valor,estado,sector,id) VALUES ('".$_POST['varini']."','SE','$rowt[1]','$rowi[0]','$rowt[34]','$rowt[10]','S','','$idsalud')";
											mysqli_query($linkbd,$sqlrins);
										}
										if($rowt[12]>0)//********PENSION EMPLEADO *****NUMAFP
										{
											$idsalud=selconsecutivo('humnomina_saludpension','id');
											$sqli="SELECT descripcion FROM hum_funcionarios WHERE item = 'NUMAFP' AND codfun='$rowt[38]' AND estado='S'";
											$resi = mysqli_query($linkbd,$sqli);
											$rowi =mysqli_fetch_row($resi);
											$sqlrins="INSERT INTO  humnomina_saludpension (id_nom,tipo,empleado,tercero,cc,valor,estado,sector,id) VALUES ('".$_POST['varini']."','PE','$rowt[2]','$rowi[0]','$rowt[34]','$rowt[12]','S','PR','$idsalud')";
											mysqli_query($linkbd,$sqlrins);
										}
										if($rowt[14]>0)//********FONDO SOLIDARIDAD EMPLEADO *****
										{
											$idsalud=selconsecutivo('humnomina_saludpension','id');
											$sqli="SELECT descripcion FROM hum_funcionarios WHERE item = 'NUMAFP' AND codfun='$rowt[38]' AND estado='S'";
											$resi = mysqli_query($linkbd,$sqli);
											$rowi =mysqli_fetch_row($resi);
											$sqlrins="INSERT INTO  humnomina_saludpension (id_nom,tipo,empleado,tercero,cc,valor,estado,sector,id) VALUES ('".$_POST['varini']."','FS','$rowt[2]','$rowi[0]','$rowt[34]','$rowt[14]','S','PR','$idsalud')";
											mysqli_query($linkbd,$sqlrins);
										}
										if($rowt[11]>0)//******** SALUD EMPLEADOR *******
										{
											$idsalud=selconsecutivo('humnomina_saludpension','id');
											$sqli="SELECT descripcion FROM hum_funcionarios WHERE item = 'NUMEPS' AND codfun='$rowt[38]' AND estado='S'";
											$resi = mysqli_query($linkbd,$sqli);
											$rowi =mysqli_fetch_row($resi);
											$sqlrins="INSERT INTO  humnomina_saludpension (id_nom,tipo,empleado,tercero,cc,valor,estado,sector,id) VALUES ('".$_POST['varini']."','SR','$rowt[2]','$rowi[0]','$rowt[34]','$rowt[11]','S','','$idsalud')";
											mysqli_query($linkbd,$sqlrins);
										}
										if($rowt[13]>0)//******** PENSIONES EMPLEADOR *******
										{
											$idsalud=selconsecutivo('humnomina_saludpension','id');
											$sqli="SELECT descripcion FROM hum_funcionarios WHERE item = 'NUMAFP' AND codfun='$rowt[38]' AND estado='S'";
											$resi = mysqli_query($linkbd,$sqli);
											$rowi =mysqli_fetch_row($resi);
											$sqlrins="INSERT INTO  humnomina_saludpension (id_nom,tipo,empleado,tercero,cc,valor,estado,sector,id) VALUES ('".$_POST['varini']."','PR','$rowt[2]','$rowi[0]','$rowt[34]','$rowt[13]','S','PR','$idsalud')";
											mysqli_query($linkbd,$sqlrins);
										}
										
									}
								}
								if(@$_POST['varfin']=='SI')
								{
									$sqlr="SELECT * FROM centrocosto WHERE estado='S'";
									$rescc=mysqli_query($linkbd,$sqlr);
									while ($rowcc =mysqli_fetch_row($rescc)) 
									{
										if(@$pf['01'][$rowcc[0]]>0)//CAJAS DE COMPENSACION
										{
											$sqlr="INSERT INTO humnomina_parafiscales (id_nom,id_parafiscal,porcentaje,valor,cc,estado) VALUES ('".$_POST['varini']."','01','4.00000','".@$pf['01'][$rowcc[0]]."','$rowcc[0]','S')";
											mysqli_query($linkbd,$sqlr);
											
										}
										if(@$pf['02'][$rowcc[0]]>0)//ICBF
										{
											$sqlr="INSERT INTO humnomina_parafiscales (id_nom, id_parafiscal, porcentaje, valor, cc,estado) VALUES ('".$_POST['varini']."','02','3.00000','".@$pf['02'][$rowcc[0]]."','$rowcc[0]','S')";
											mysqli_query($linkbd,$sqlr);
										}
										if(@$pf['03'][$rowcc[0]]>0)//SENA
										{
											$sqlr="INSERT INTO humnomina_parafiscales (id_nom, id_parafiscal, porcentaje, valor, cc, estado) VALUES ('".$_POST['varini']."','03','0.50000','".$pf['03'][$rowcc[0]]."','$rowcc[0]', 'S')";
											mysqli_query($linkbd,$sqlr);
										}
										if(@$pf['04'][$rowcc[0]]>0)//ITI
										{
											$sqlr="INSERT INTO humnomina_parafiscales (id_nom, id_parafiscal, porcentaje, valor, cc, estado) VALUES ('".$_POST['varini']."','04','1.00000','".$pf['04'][$rowcc[0]]."','$rowcc[0]', 'S')";
											mysqli_query($linkbd,$sqlr);
										}
										if(@$pf['05'][$rowcc[0]]>0)//ESAP
										{
											$sqlr="INSERT INTO humnomina_parafiscales (id_nom,id_parafiscal,porcentaje,valor,cc,estado) VALUES ('".$_POST['varini']."','05','0.50000','".$pf['05'][$rowcc[0]]."','$rowcc[0]','S')";
											mysqli_query($linkbd,$sqlr);
										}
										if(@$pf['06'][$rowcc[0]]>0)//ARL
										{
											$sqlr="INSERT INTO humnomina_parafiscales (id_nom,id_parafiscal,porcentaje,valor,cc,estado) VALUES ('".$_POST['varini']."','06','0.52220','".$pf['06'][$rowcc[0]]."','$rowcc[0]','S')";
											mysqli_query($linkbd,$sqlr);
										}
									}
								}
								$sumatotal = $sumaarl + $sumaccf + $sumasena + $sumaicbf + $sumaintec + $sumaesap + $sumasaludfu + $sumasaludem + $sumapensionfu + $sumapensionem + $sumafondosol;
								echo"
								<div class='content' style='overflow-x:hidden'>
										<table class='inicio'>
											<tr class='titulos'>
												<td>C&oacute;digo</td>
												<td>Aportes Parafiscales</td>
												<td style='width:10%'>Porcentaje</td>
												<td style='width:10%'>Valor</td>
												<td>descripci&oacute;n</td>
											</tr>
											<tr class='zebra1'>
												<td>01</td>
												<td>CAJAS DE COMPENSACION FAMILIAR</td>
												<td>4.00000 %</td>
												<td style='text-align:right;'>$ ".number_format($sumaccf,0)."&nbsp;</td>
												<td>APORTES EMPRESA</td>
											</tr>
											<tr class='zebra2'>
												<td>02</td>
												<td>ICBF</td>
												<td>3.00000 %</td>
												<td style='text-align:right;'>$ ".number_format($sumaicbf,0)."&nbsp;</td>
												<td>APORTES EMPRESA</td>
											</tr>
											<tr class='zebra1'>
												<td>03</td>
												<td>SENA</td>
												<td>0.50000 %</td>
												<td style='text-align:right;'>$ ".number_format($sumasena,0)."&nbsp;</td>
												<td>APORTES EMPRESA</td>
											</tr>
											<tr class='zebra2'>
												<td>04</td>
												<td>INSTITUTOS TECNICOS</td>
												<td>1.00000 %</td>
												<td style='text-align:right;'>$ ".number_format($sumaintec,0)."&nbsp;</td>
												<td>APORTES EMPRESA</td>
											</tr>
											<tr class='zebra1'>
												<td>05</td>
												<td>ESAP</td>
												<td>0.50000 %</td>
												<td style='text-align:right;'>$ ".number_format($sumaesap,0)."&nbsp;</td>
												<td>APORTES EMPRESA</td>
											</tr>
											<tr class='zebra2'>
												<td>06</td>
												<td>ARL</td>
												<td>Ind/Fun</td>
												<td style='text-align:right;'>$ ".number_format($sumaarl,0)."&nbsp;</td>
												<td>APORTES EMPRESA</td>
											</tr>
											<tr class='zebra1'>
												<td>07</td>
												<td>SALUD EMPLEADOR</td>
												<td>8.50000 %</td>
												<td style='text-align:right;'>$ ".number_format($sumasaludem,0)."&nbsp;</td>
												<td>APORTES EMPRESA</td>
											</tr>
											<tr class='zebra2'>
												<td>08</td>
												<td>SALUD EMPLEADO</td>
												<td>4.00000 %</td>
												<td style='text-align:right;'>$ ".number_format($sumasaludfu,0)."&nbsp;</td>
												<td>APORTES EMPLEADO</td>
											</tr>
											<tr class='zebra1'>
												<td>09</td>
												<td>PENSION EMPLEADOR</td>
												<td>12.00000 %</td>
												<td style='text-align:right;'>$ ".number_format($sumapensionem,0)."&nbsp;</td>
												<td>APORTES EMPRESA</td>
											</tr>
											<tr class='zebra2'>
												<td>10</td>
												<td>PENSION EMPLEADO</td>
												<td>4.00000 %</td>
												<td style='text-align:right;'>$ ".number_format($sumapensionfu,0)."&nbsp;</td>
												<td>APORTES EMPLEADO</td>
											</tr>
											<tr class='zebra1'>
												<td>10</td>
												<td>FONDO SOLIDARIDAD</td>
												<td>Ind/Fu</td>
												<td style='text-align:right;'>$ ".number_format($sumafondosol,0)."&nbsp;</td>
												<td>APORTES EMPLEADO</td>
											</tr>
											<tr class='titulos'>
												<td colspan='3' style='text-align:right;'>TOTAL :</td>
												<td style='text-align:right;'>$ ".number_format($sumatotal,0)."&nbsp;</td>
												<td></td>
											</tr>";
								
							}
							else{echo "<h3 class='example1'>Error agrega numero de nomina en inicio</h3>";}
						}break;
					}
					//if($_POST['varini']!='' && $_POST['varfin']!=''){}
					//else{echo "error contenido inicial";}
					
				}
			?> 
		</form>
	</body>
</html>