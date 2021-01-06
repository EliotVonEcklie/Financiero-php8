<?php
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=iso-8859-1");
	require"comun.inc";
	require"funciones.inc";
	require"funciones_nomina.inc";
	sesion();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	date_default_timezone_set("America/Bogota");
	ini_set('max_execution_time', 7200);
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Spid - Gestion Humana</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
		<script>
			function guardar()
			{
				if (document.form2.tperiodo.value!='' && document.form2.periodo.value!='')
				{
					if (confirm("Esta Seguro de Guardar"))
					{
						document.form2.oculto.value=2;
						document.form2.submit();
					}
				}
				else { alert('Faltan datos para completar el registro');}
			}
			function validar(formulario)
			{
				document.form2.cperiodo.value='2';
				document.form2.action="cont-liquidarnomina-regrabar.php";
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
				document.form2.action="pdfplanillapago.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>
			<tr><?php menu_desplegable("cont");?></tr>
			<tr>
				<td colspan="3" class="cinta"><img src="imagenes/add.png" onClick="location.href='cont-liquidarnomina-regrabar.php'" title="Nuevo" class='mgbt'/><img src="imagenes/guardad.png" class="mgbt1"/><img src="imagenes/buscad.png" class='mgbt1'/><img src="imagenes/nv.png" title="Nueva Ventana" class='mgbt' onClick="mypop=window.open('cont-principal.php','','');mypop.focus();"/><img src="imagenes/reflejar1.png" title="Reflejar" class='mgbt' onClick="guardar()"/><img src="imagenes/printd.png" class='mgbt1'/><img src="imagenes/excel.png" title="Excel" onClick='excell()' class='mgbt'/><img src="imagenes/iratras.png" title="Retornar" onClick="location.href='cont-reflejardocs.php'" class='mgbt'/></td>
			</tr>
		</table>
		<form name="form2" method="post" action="">
			<?php
				$pf[]=array();
				$pfcp=array();
			?>
			<table  class="inicio" align="center" >
			<tr>
				<td class="titulos" colspan="10">:: Buscar Liquidaciones</td>
				<td class="cerrar" ><a href="cont-principal.php">Cerrar</a></td>
			</tr>
			<tr>
				<td class="saludo1">No Liquidacion</td>
				<td>
					<select name="idliq" id="idliq" onChange="validar()" >
						<option value="-1">Sel ...</option>
						<?php
							$sqlr="SELECT * FROM humnomina T1, humnomina_aprobado T2 WHERE T1.id_nom=T2.id_nom AND T2.estado='S' ORDER BY T1.id_nom DESC";
							$resp = mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($resp)) 
							{
								if($row[0]==$_POST[idliq])
								{
									echo "<option value='$row[0]' SELECTED>$row[0]</option>";
									$_POST[tperiodo]=$row[2];	
									$_POST[periodo]=$row[3];
									$_POST[cc]=$row[6];
									$_POST[diasperiodo]=$row[4];				  
									ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $row[1],$fecha);
									$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
									$_POST[fecha]=$fechaf;
									$_POST[fechafi]=$row[1];
									$_POST[vigenomi]=$row[7];
								}
								else {echo "<option value='$row[0]'>$row[0]</option>";}
							}
						?>
					</select>
				</td>
				<td class="saludo1">Fecha</td>
				<td><input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10" size="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY">   <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a></td>
				<td class="saludo1">RP</td> 
				<td>
					<select name="rp" id="rp" onChange="validar()" >
						<option value="-1">Sel ...</option>
						<?php
							$sqlr="Select humnom_rp.consvigencia, pptorp.valor, pptorp.idcdp, humnom_rp.vigencia  from humnom_rp inner join pptorp on humnom_rp.consvigencia=pptorp.consvigencia  where humnom_rp.estado='S' and humnom_rp.vigencia='$_POST[vigenomi]' and pptorp.vigencia='$_POST[vigenomi]'";
							$resp = mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($resp)) 
							{
								if($row[0]==$_POST[rp])
								{
									echo "<option value='$row[0]' SELECTED>$row[0]</option>";
									$_POST[rp]=$row[0];	
									$_POST[valorp]=$row[1];
									$_POST[hvalorp]=$row[1];
									$_POST[cdp]=$row[2];
								}
								else {echo "<option value='$row[0]'>$row[0]</option>";}
							}
						?>
					</select>
					<input type="hidden" value="<?php echo $_POST[hvalorp]?>" name="hvalorp"/>
					<input type="text" value="<?php echo number_format($_POST[valorp],2)?>" name="valorp" size="14" readonly/>
				</td>
				<td class="saludo1" style="width:3cm">Causacion Contable:</td>
				<td >
					<select name="causacion" id="causacion" onKeyUp="return tabular(event,this)">
						<option value="1" <?php if($_POST[causacion]=='1') echo "selected" ?> >Si</option>
						<option value="2" <?php if($_POST[causacion]=='2') echo "selected" ?> >No</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="saludo1">Detalle RP:</td>
				<td colspan="3"><input type="text" id="detallecdp" name="detallecdp" value="<?php echo $_POST[detallecdp]?>" size="50" readonly></td>
				<td class="saludo1">Tercero:</td>
				<td ><input id="tercero" type="text" name="tercero" size="10" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo $_POST[tercero]?>" ><input type="hidden" value="0" name="bt"><a href="#" onClick="mypop=window.open('terceros-ventana.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=900,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a></td>
				<td colspan="6"><input id="ntercero" name="ntercero" type="text" value="<?php echo $_POST[ntercero]?>" size="80" readonly></td>
			</tr>
			<tr>
				<td class="saludo1">Valor RP:</td>
				<td><input type="text" id="valorrp" name="valorrp" value="<?php echo $_POST[valorrp]?>" size="15" onKeyUp="return tabular(event,this)" readonly></td>
				<td class="saludo1">Saldo:</td>
				<td><input type="text" id="saldorp" name="saldorp"  value="<?php echo $_POST[saldorp]?>" size="15" onKeyUp="return tabular(event,this)" readonly></td>
				<td class="saludo1" >Valor a Pagar:</td>
				<td><input type="text" id="valor" name="valor" value="<?php echo $_POST[valor]?>" size="15" readonly></td>
				<td class="saludo1" >CDP:</td>
				<td><input type="text" id="cdp" name="cdp" value="<?php echo $_POST[cdp]?>" size="10" readonly></td>
			</tr>
			<tr>
				<td class="saludo1">Periodo Liquidar:</td>
				<?php
					if(!$_POST[oculto])
					{
						$_POST[diast]=array();
						$_POST[devengado]=array();
						$_POST[empleados]=array();
					}
					$sqlr="select * from admfiscales where vigencia='$_POST[vigenomi]'";
					$resp = mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($resp)) 
					{
						$_POST[balim]=$row[7];
						$_POST[btrans]=$row[8];
						$_POST[bfsol]=$row[6];
						$_POST[alim]=$row[5];
						$_POST[transp]=$row[4];
						$_POST[salmin]=$row[3];
						$_POST[cajacomp]=$row[13];
						$_POST[icbf]=$row[10];
						$_POST[sena]=$row[11];
						$_POST[esap]=$row[14];
						$_POST[iti]=$row[12];
					}
				?>
				<td>
					<?php
						$sqlr="select sueldo, cajacompensacion,icbf,sena,iti,esap,arp,salud_empleador,salud_empleado,pension_empleador, pension_empleado,sub_alimentacion,aux_transporte,prima_navidad  from humparametrosliquida ";
						$resp = mysql_query($sqlr,$linkbd);
						while ($row =mysql_fetch_row($resp)) 
						{
							$_POST[psalmin]=$row[0];
							$_POST[pcajacomp]=$row[1];
							$_POST[picbf]=$row[2];
							$_POST[psena]=$row[3];
							$_POST[piti]=$row[4];
							$_POST[pesap]=$row[5];
							$_POST[parp]=$row[6];
							$_POST[psalud_empleador]=$row[7];
							$_POST[psalud_empleado]=$row[8];
							$_POST[ppension_empleador]=$row[9];
							$_POST[ppension_empleado]=$row[10];
							$_POST[palim]=$row[11];
							$_POST[ptransp]=$row[12];
							$_POST[pbfsol]=$_POST[ppension_empleado];
							$_POST[tprimanav]=$row[13];
						}
					?>
					<input type="hidden" id="cajacomp" name="cajacomp" value="<?php echo $_POST[cajacomp]?>" >
					<input type="hidden" id="icbf" name="icbf" value="<?php echo $_POST[icbf]?>" >
					<input type="hidden" id="sena" name="sena" value="<?php echo $_POST[sena]?>" >
					<input type="hidden" id="esap" name="esap" value="<?php echo $_POST[esap]?>" >
					<input type="hidden" id="iti" name="iti" value="<?php echo $_POST[iti]?>" >
					<input type="hidden" id="btrans" name="btrans" value="<?php echo $_POST[btrans]?>" >
					<input type="hidden" id="balim" name="balim" value="<?php echo $_POST[balim]?>" >
					<input type="hidden" id="bfsol" name="bfsol" value="<?php echo $_POST[bfsol]?>" >
					<input type="hidden" id="transp" name="transp" value="<?php echo $_POST[transp]?>" >
					<input type="hidden" id="alim" name="alim" value="<?php echo $_POST[alim]?>" >
					<input type="hidden" id="salmin" name="salmin" value="<?php echo $_POST[salmin]?>" >  
					<input type="hidden" id="tprimanav" name="tprimanav" value="<?php echo $_POST[tprimanav]?>" >
					<input type="hidden" id="pcajacomp" name="pcajacomp" value="<?php echo $_POST[pcajacomp]?>" >
					<input type="hidden" id="picbf" name="picbf" value="<?php echo $_POST[picbf]?>" >
					<input type="hidden" id="psena" name="psena" value="<?php echo $_POST[psena]?>" >
					<input type="hidden" id="pesap" name="pesap" value="<?php echo $_POST[pesap]?>" >
					<input type="hidden" id="piti" name="piti" value="<?php echo $_POST[piti]?>" >
					<input type="hidden" id="psalud_empleado" name="psalud_empleado" value="<?php echo $_POST[psalud_empleado]?>" >
					<input type="hidden" id="psalud_empleador" name="psalud_empleador" value="<?php echo $_POST[psalud_empleador]?>" >
					<input type="hidden" id="ppension_empleador" name="ppension_empleador" value="<?php echo $_POST[ppension_empleador]?>" >
					<input type="hidden" id="ppension_empleado" name="ppension_empleado" value="<?php echo $_POST[ppension_empleado]?>" >
					<input type="hidden" id="pbfsol" name="pbfsol" value="<?php echo $_POST[pbfsol]?>" >
					<input type="hidden" id="ptransp" name="ptransp" value="<?php echo $_POST[ptransp]?>" >
					<input type="hidden" id="palim" name="palim" value="<?php echo $_POST[palim]?>" >
					<input type="hidden" id="psalmin" name="psalmin" value="<?php echo $_POST[psalmin]?>" >
					<input type="hidden" id="parp" name="parp" value="<?php echo $_POST[parp]?>"/>
					<input type="hidden" id="vigenomi" name="vigenomi" value="<?php echo $_POST[vigenomi]?>"/>
					<input type="hidden" id="fechafi" name="fechafi" value="<?php echo $_POST[fechafi]?>"/>
					<select name="tperiodo" id="tperiodo" onChange="validar()" >
						<option value="-1">Seleccione ....</option>
						<?php
							$sqlr="Select * from humperiodos  where estado='S'";
							$resp = mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($resp)) 
							{
								if($row[0]==$_POST[tperiodo])
								{
									echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";
									$_POST[tperiodonom]=$row[1];
									$_POST[diasperiodo]=$row[2];
								}
								else{echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
							}
						?>
					</select>
					<input id="tperiodonom" name="tperiodonom" type="hidden" value="<?php echo $_POST[tperiodonom]?>" >
					<input name="cperiodo" type="hidden" value="">
				</td>
				<td class="saludo1">Dias:</td>
				<td><input name="diasperiodo" type="text" id="diasperiodo" value="<?php echo $_POST[diasperiodo]?>" size="5" readonly></td>
				<input name="oculto" type="hidden" value="1">
				<td class="saludo1">CC:</td>
				<td>
					<select name="cc"  onChange="validar()" onKeyUp="return tabular(event,this)">
						<option value='' <?php if(''==$_POST[cc]) echo "SELECTED"?>>Todos</option>
						<?php
							$sqlr="select *from centrocosto where estado='S'";
							$res=mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($res)) 
							{
								if($row[0]==$_POST[cc]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
								else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
							}	 	
						?>
					</select>
				</td>
				<td class="saludo1" colspan="1">Mes:</td>
				<td>
					<select name="periodo" id="periodo" onChange="validar()"  >
						<option value="-1">Seleccione ....</option>
						<?php
							$sqlr="Select * from meses where estado='S' ";
							$resp = mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($resp))
							{
								if($row[0]==$_POST[periodo])
								{
									echo "<option value='$row[0]' SELECTED>$row[1]</option>";
									$_POST[periodonom]=$row[1];
									$_POST[periodonom]=$row[2];
								}
								else {echo "<option value='$row[0]'>$row[1]</option>";}
							}
						?>
					</select>
					<?php 
						if($_POST[tperiodo]=='1'){echo"  <input type='hidden' name='mesnum' value='1'>";}  
						if($_POST[tperiodo]=='2')
						{
							echo "
							<select name='mesnum' id='mesnum'>
								<option value='1'"; if($_POST[mesnum]=='1'){echo "selected";} echo">1 Quincena</option>
								<option value='2'"; if($_POST[mesnum]=='2'){echo "selected";} echo">2 Quincena</option>
							</select>";
						}
					?>
				</td>
			</tr>
		</table>
		<div class="subpantalla">
			<?php
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
				$sqlr="SELECT mes,vigencia FROM humnomina WHERE id_nom='$_POST[idliq]'";
				$resp = mysql_query($sqlr,$linkbd);
				$row =mysql_fetch_row($resp); 
				$mesnnomina=$row[0];
				$meslnomina=mesletras($row[0]);
				$vigenomina=$row[1]; 
				echo "
				<table class='inicio'>
					<tr><td colspan='89' class='titulos'>.: Detalles Comprobantes</td></tr>
					<tr>
						<td class='titulos2'>ITEM</td>
						<td class='titulos2'>CUENTA</td>
						<td class='titulos2'>NOMBRE CUENTA</td>
						<td class='titulos2'>TERCERO</td>
						<td class='titulos2'>NOMBRE TERCERO</td>
						<td class='titulos2'>CC</td>
						<td class='titulos2'>DETALLE</td>
						<td class='titulos2'>VLR. DEBITO</td>
						<td class='titulos2'>VLR. CREDITO</td>
					</tr>";
				$iter="zebra1";
				$iter2="zebra2";
				$sqlr="SELECT cedulanit,SUM(devendias),SUM(auxalim),SUM(auxtran),SUM(salud),SUM(saludemp),SUM(pension),SUM(pensionemp),SUM(fondosolid),SUM(otrasdeduc),SUM(arp), SUM(cajacf),SUM(sena),SUM(icbf),SUM(instecnicos),SUM(esap),tipofondopension,prima_navi,cc,tipopago,SUM(retefte) FROM humnomina_det WHERE id_nom='$_POST[idliq]' GROUP BY idfuncionario, tipopago ORDER BY tipopago, cc"; 
				$resp = mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($resp)) 
				{
					$ccosto=$row[18]; 
					$empleado=buscatercero($row[0]);
					if($row[1]!=0)//tipo de pago (Salarios, Subsidios, primas .....)
					{
						$ctaconcepto=$ctacont='';
						//Cuenta debito salario empleado
						$ctacont=cuentascontables::cuentadebito_tipomov($row[19],$ccosto,$vigenomina,$_POST['fechafi']);
						$nresul=buscacuenta($ctacont);
						$sqlrdes="SELECT nombre FROM humvariables WHERE estado='S' AND codigo='$row[19]'";
						$resdes = mysql_query($sqlrdes,$linkbd);
						$rowdes =mysql_fetch_row($resdes);
						$nomceunta=ucwords(strtolower($rowdes[0]));
						echo "
						<tr class='$iter' >
							<td>$con</td>
							<td>$ctacont</td>
							<td>$nresul</td>
							<td>$row[0]</td>
							<td>$empleado</td>
							<td>$row[18]</td>
							<td>$nomceunta Mes $meslnomina </td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($row[1],0)."</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
						</tr>";
						$listacuentas[]=$ctacont;
						$listanombrecuentas[]=$nresul;
						$listaterceros[]=$row[0];
						$listanombreterceros[]=$empleado;
						$listaccs[]=$row[18];
						$listadetalles[]="$nomceunta Mes $meslnomina";
						$listadebitos[]=$row[1];
						$listacreditos[]=0;
						$listatipo[]="$row[19]<->DB";
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
						$con+=1;
						//Cuenta credito salario empleado
						$ctaconcepto=cuentascontables::cuentacredito_tipomov($row[19],$ccosto,$vigenomina,$_POST['fechafi']);
						$nresul=buscacuenta($ctaconcepto);
						echo "
						<tr class='$iter'>
							<td>$con</td>
							<td>$ctaconcepto</td>
							<td>$nresul</td>
							<td>$row[0]</td>
							<td>$empleado</td>
							<td>$row[18]</td>
							<td>$nomceunta Mes $meslnomina</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($row[1],0)."</td>
						</tr>";
						$listacuentas[]=$ctaconcepto;
						$listanombrecuentas[]=$nresul;
						$listaterceros[]=$row[0];
						$listanombreterceros[]=$empleado;
						$listaccs[]=$row[18];
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
						echo "
						<tr class='$iter'>
							<td>$con</td>
							<td>$ctacont</td>
							<td>$nresul</td>
							<td>$row[0]</td>
							<td>$empleado</td>
							<td>$row[18]</td>
							<td>Aporte Salud Empleado Mes $meslnomina</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($row[4],0)."</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
						</tr>";
						$listacuentas[]=$ctacont;
						$listanombrecuentas[]=$nresul;
						$listaterceros[]=$row[0];	
						$listanombreterceros[]=$empleado;	
						$listaccs[]=$row[18];
						$listadetalles[]="Aporte Salud Empleado Mes $meslnomina";
						$listadebitos[]=$row[4];
						$listacreditos[]=0;
						$listatipo[]="SE<->DB";
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
						$con+=1;
						//Cuenta credito salud empleado
						$ctaconcepto=cuentascontables::cuentacredito_parafiscales($_POST['psalud_empleado'],$ccosto,$vigenomina, $_POST['fechafi']);
						$nresul=buscacuenta($ctaconcepto);
						$epsnit=buscadatofuncionario($row[0],'NUMEPS');
						$epsnom=buscadatofuncionario($row[0],'NOMEPS');
						echo "
						<tr class='$iter'>
							<td>$con</td>
							<td>$ctaconcepto</td>
							<td>$nresul</td>
							<td>$epsnit</td>
							<td>$epsnom</td>
							<td>$row[18]</td>
							<td>Aporte Salud Empleado Mes $meslnomina</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($row[4],0)."</td>
						</tr>";
						$listacuentas[]=$ctaconcepto;
						$listanombrecuentas[]=$nresul;
						$listaterceros[]=$epsnit;	
						$listanombreterceros[]=$epsnom;	
						$listaccs[]=$row[18];
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
						$ctacont=cuentascontables::cuentacredito_tipomov($row[19],$ccosto,$vigenomina,$_POST['fechafi']);
						//Cuenta debito pension empleado
						$nresul=buscacuenta($ctacont);
						echo "
						<tr class='$iter'>
							<td>$con</td>
							<td>$ctacont</td>
							<td>$nresul</td>
							<td>$row[0]</td>
							<td>$empleado</td>
							<td>$row[18]</td>
							<td>Aporte Pension Empleado Mes $meslnomina</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($row[6],0)."</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
						</tr>";
						$listacuentas[]=$ctacont;
						$listanombrecuentas[]=$nresul;
						$listaterceros[]=$row[0];
						$listanombreterceros[]=$empleado;
						$listaccs[]=$row[18];
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
						echo "
						<tr class='$iter'>
							<td>$con</td>
							<td>$ctaconcepto</td>
							<td>$nresul</td>
							<td>$epsnit</td>
							<td>$epsnom</td>
							<td>$row[18]</td>
							<td>Aporte Pension Empleado Mes $meslnomina</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($row[6],0)."</td>
						</tr>";
						$listacuentas[]=$ctaconcepto;
						$listanombrecuentas[]=$nresul;
						$listaterceros[]=$epsnit;	
						$listanombreterceros[]=$epsnom;	
						$listaccs[]=$row[18];
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
						echo "
						<tr class='$iter'>
							<td>$con</td>
							<td>$ctacont</td>
							<td>$nresul</td>
							<td>$row[0]</td>
							<td>$empleado</td>
							<td>$row[18]</td>
							<td>Aporte Fondo Solidaridad Empleado Mes $meslnomina</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($row[8],0)."</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
						</tr>";
						$listacuentas[]=$ctacont;
						$listanombrecuentas[]=$nresul;
						$listaterceros[]=$row[0];	
						$listanombreterceros[]=$empleado;	
						$listaccs[]=$row[18];
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
						echo "
						<tr class='$iter'>
							<td>$con</td>
							<td>$ctaconcepto</td>
							<td>$nresul</td>
							<td>$epsnit</td>
							<td>$epsnom</td>
							<td>$row[18]</td>
							<td>Aporte Fondo Solidaridad Empleado Mes $meslnomina</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($row[8],0)."</td>
						</tr>";
						$listacuentas[]=$ctaconcepto;
						$listanombrecuentas[]=$nresul;
						$listaterceros[]=$epsnit;	
						$listanombreterceros[]=$epsnom;	
						$listaccs[]=$row[18];
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
						$respd1=mysql_query($sqlrd1,$linkbd);
						while ($rowd1=mysql_fetch_row($respd1))
						{
							//debito
							$ctaconcepto=$ctacont='';
							$ctacont=cuentascontables::cuentacredito_tipomov($row[19],$ccosto,$vigenomina,$_POST['fechafi']);
							$nresul=buscacuenta($ctacont);
							$sqlrdes="SELECT nombre FROM humvariables WHERE estado='S' AND codigo='$row[19]'";
							$resdes = mysql_query($sqlrdes,$linkbd);
							$rowdes =mysql_fetch_row($resdes);
							$nomceunta=ucwords(strtolower($rowdes[0]));
							echo "
							<tr class='$iter' >
								<td>$con</td>
								<td>$ctacont</td>
								<td>$nresul</td>
								<td>$row[0]</td>
								<td>$empleado</td>
								<td>$row[18]</td>
								<td>Descuento $nomceunta Mes $meslnomina </td>
								<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($rowd1[0],0)."</td>
								<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
							</tr>";
							$listacuentas[]=$ctacont;
							$listanombrecuentas[]=$nresul;
							$listaterceros[]=$row[0];
							$listanombreterceros[]=$empleado;
							$listaccs[]=$row[18];
							$listadetalles[]="Decuento $nomdescu Mes $meslnomina";
							$listadebitos[]=$rowd1[0];
							$listacreditos[]=0;
							$listatipo[]="DS<->DB";
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux;
							$con+=1;
							//credito
							$sqlrcu="SELECT DISTINCT T1.nombre,T1.beneficiario,T2.cuenta FROM humvariablesretenciones T1, humvariablesretenciones_det T2 WHERE T1.codigo = '$rowd1[1]' AND T1.codigo = T2.codigo AND T2.credito = 'S' AND fechainicial=(SELECT MAX(T3.fechainicial) FROM humvariablesretenciones_det T3 WHERE T3.codigo=T2.codigo AND T3.fechainicial<='".$_POST['fechafi']."')";
							$respcu = mysql_query($sqlrcu,$linkbd);
							while ($rowcu =mysql_fetch_row($respcu)) 
							{
								$ctaconcepto=$rowcu[2];
								$docbenefi=$rowcu[1];
								$nomdescu=ucwords(strtolower($rowcu[0])); 
							}
							//Cuenta credito otras deducciones
							$nresul=buscacuenta($ctaconcepto);
							$nombenefi=buscatercero($docbenefi);
							echo "
							<tr class='$iter'>
								<td>$con</td>
								<td>$ctaconcepto</td>
								<td>$nresul</td>
								<td>$docbenefi</td>
								<td>$nombenefi</td>
								<td>$row[18]</td>
								<td>Decuento $nomdescu Mes $meslnomina</td>
								<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
								<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($rowd1[0],0)."</td>
							</tr>";
							$listacuentas[]=$ctaconcepto;
							$listanombrecuentas[]=$nresul;
							$listaterceros[]=$docbenefi;
							$listanombreterceros[]=$nombenefi;
							$listaccs[]=$row[18];
							$listadetalles[]="Decuento $nomdescu Mes $meslnomina";
							$listadebitos[]=0;
							$listacreditos[]=$rowd1[0];
							$listatipo[]="DS<->CR";
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux;
							$con+=1;
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
						echo "
						<tr class='$iter'>
							<td>$con</td>
							<td>$ctacont</td>
							<td>$nresul</td>
							<td>$epsnit</td>
							<td>$epsnom</td>
							<td>$row[18]</td>
							<td>Aporte Salud Empleador Mes $meslnomina</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($row[5],0)."</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
						</tr>";
						$listacuentas[]=$ctacont;
						$listanombrecuentas[]=$nresul;
						$listaterceros[]=$epsnit;	
						$listanombreterceros[]=$epsnom;	
						$listaccs[]=$row[18];
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
						echo "
						<tr class='$iter'>
							<td>$con</td>
							<td>$ctaconcepto</td>
							<td>$nresul</td>
							<td>$epsnit</td>
							<td>$epsnom</td>
							<td>$row[18]</td>
							<td>Aporte Salud Empleador Mes $meslnomina</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($row[5],0)."</td>
						</tr>";
						$listacuentas[]=$ctaconcepto;
						$listanombrecuentas[]=$nresul;
						$listaterceros[]=$epsnit;	
						$listanombreterceros[]=$epsnom;	
						$listaccs[]=$row[18];
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
						echo "
						<tr class='$iter'>
							<td>$con</td>
							<td>$ctacont</td>
							<td>$nresul</td>
							<td>$epsnit</td>
							<td>$epsnom</td>
							<td>$row[18]</td>
							<td>Aporte Pension Empleador Mes $meslnomina</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($row[7],0)."</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
						</tr>";
						$listacuentas[]=$ctacont;
						$listanombrecuentas[]=$nresul;
						$listaterceros[]=$epsnit;	
						$listanombreterceros[]=$epsnom;	
						$listaccs[]=$row[18];
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
						echo "
						<tr class='$iter'>
							<td>$con</td>
							<td>$ctaconcepto</td>
							<td>$nresul</td>
							<td>$epsnit</td>
							<td>$epsnom</td>
							<td>$row[18]</td>
							<td>Aporte Pension Empleador Mes $meslnomina</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($row[7],0)."</td>
						</tr>";
						$listacuentas[]=$ctaconcepto;
						$listanombrecuentas[]=$nresul;
						$listaterceros[]=$epsnit;	
						$listanombreterceros[]=$epsnom;	
						$listaccs[]=$row[18];
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
						echo "
						<tr class='$iter'>
							<td>$con</td>
							<td>$ctacont</td>
							<td>$nresul</td>
							<td>$epsnit</td>
							<td>$epsnom</td>
							<td>$row[18]</td>
							<td>Aportes ARL Mes $meslnomina</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($row[10],0)."</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
						</tr>";
						$listacuentas[]=$ctacont;
						$listanombrecuentas[]=$nresul;
						$listaterceros[]=$epsnit;	
						$listanombreterceros[]=$epsnom;	
						$listaccs[]=$row[18];
						$listadetalles[]="Aportes ARL Mes $meslnomina";
						$listadebitos[]=$row[10];
						$listacreditos[]=0;
						$listatipo[]="P6<->DB";
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
						$con+=1;
						//Cuenta credito ARL empleado
						$ctaconcepto=cuentascontables::cuentacredito_parafiscales($_POST['parp'],$ccosto ,$vigenomina, $_POST['fechafi']);
						$nresul=buscacuenta($ctaconcepto);
						echo "
						<tr class='$iter'>
							<td>$con</td>
							<td>$ctaconcepto</td>
							<td>$nresul</td>
							<td>$epsnit</td>
							<td>$epsnom</td>
							<td>$row[18]</td>
							<td>Aportes ARL Mes $meslnomina</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($row[10],0)."</td>
						</tr>";
						$listacuentas[]=$ctaconcepto;
						$listanombrecuentas[]=$nresul;
						$listaterceros[]=$epsnit;	
						$listanombreterceros[]=$epsnom;	
						$listaccs[]=$row[18];
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
					if($row[11]!=0){$listacajacf[$row[18]][]=$row[11];}
					//SENA
					if($row[12]!=0){$listasena[$row[18]][]=$row[12];}
					//ICBF
					if($row[13]!=0){$listaicbf[$row[18]][]=$row[13];}
					//INSTITUTOS TEC
					if($row[14]!=0){$listainstecnicos[$row[18]][]=$row[14];}
					//ESAP
					if($row[15]!=0){$listaesap[$row[18]][]=$row[15];}
					if($row[20]!=0)//Retenciones
					{
						$ctaconcepto=$ctacont='';
						$sqlrd1="SELECT T1.valor,T2.tiporetencion FROM humnominaretenemp T1, hum_retencionesfun T2 WHERE T1.id_nom='$_POST[idliq]' AND T1.cedulanit='$row[0]' AND T1.id=T2.id AND T1.tipo_des='RE'";
						$respd1=mysql_query($sqlrd1,$linkbd);
						while ($rowd1=mysql_fetch_row($respd1))
						{
							$sqlcodi="SELECT T2.conceptoingreso,T1.nombre FROM tesoretenciones T1,tesoretenciones_det T2 WHERE T1.id=T2.codigo AND T1.id='$rowd1[1]'";
							$rescodi=mysql_query($sqlcodi,$linkbd);
							$rowcodi=mysql_fetch_row($rescodi);
							$sqlrcu="SELECT DISTINCT cuenta, debito, credito FROM conceptoscontables_det WHERE modulo='4' AND tipo='RI' AND cc='$row[18]' AND tipocuenta='N' AND codigo='$rowcodi[0]' AND fechainicial=(SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE fechainicial <=  '$_POST[fechafi]' AND modulo='4' AND tipo='RI' AND cc='$row[18]' AND tipocuenta='N' AND codigo='$rowcodi[0]')  ORDER BY credito";
							$respcu = mysql_query($sqlrcu,$linkbd);
							while ($rowcu =mysql_fetch_row($respcu)) 
							{
								$ctaconcepto=$rowcu[0];
								$docbenefi=$rowcu[1];
								$nomdescu=ucwords(strtolower($rowcu[0])); 
							}
							
							//Cuenta debito otras deducciones
							$ctacont=cuentascontables::cuentacredito_tipomov($row[19],$ccosto,$vigenomina,$_POST['fechafi']);
							$nresul=buscacuenta($ctacont);
							echo "
							<tr class='$iter'>
								<td>$con</td>
								<td>$ctacont</td>
								<td>$nresul</td>
								<td>$row[0]</td>
								<td>$empleado</td>
								<td>$row[18]</td>
								<td>Retención $rowcodi[1] Mes $meslnomina</td>
								<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($rowd1[0],0)."</td>
								<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
							</tr>";
							$listacuentas[]=$ctacont;
							$listanombrecuentas[]=$nresul;
							$listaterceros[]=$row[0];	
							$listanombreterceros[]=$empleado;	
							$listaccs[]=$row[18];
							$listadetalles[]="Retencion $rowcodi[1] Mes $meslnomina";
							$listadebitos[]=$rowd1[0];
							$listacreditos[]=0;
							$listatipo[]="RE<->DB";
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux;
							$con+=1;
							//Cuenta credito otras deducciones
							$nresul=buscacuenta($ctaconcepto);
							echo "
							<tr class='$iter'>
								<td>$con</td>
								<td>$ctaconcepto</td>
								<td>$nresul</td>
								<td>$row[0]</td>
								<td>$empleado</td>
								<td>$row[18]</td>
								<td>Retención $rowcodi[1] Mes $meslnomina</td>
								<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
								<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($rowd1[0],0)."</td>
							</tr>";
							$listacuentas[]=$ctaconcepto;
							$listanombrecuentas[]=$nresul;
							$listaterceros[]=$row[0];	
							$listanombreterceros[]=$empleado;	
							$listaccs[]=$row[18];
							$listadetalles[]="Retención $rowcodi[1] Mes $meslnomina";
							$listadebitos[]=0;
							$listacreditos[]=$rowd1[0];
							$listatipo[]="RE<->CR";
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux;
							$con+=1;
						}
					}
				}
				$sqlrcc="SELECT id_cc FROM centrocosto WHERE estado='S' ORDER BY CONVERT(id_cc, SIGNED INTEGER)";
				$respcc = mysql_query($sqlrcc,$linkbd);
				while ($rowcc =mysql_fetch_row($respcc)) 
				{
					$totalcajacf=array_sum($listacajacf[$rowcc[0]]);
					$totalsena=array_sum($listasena[$rowcc[0]]);
					$totalicbf=array_sum($listaicbf[$rowcc[0]]);
					$totalinstecnicos=array_sum($listainstecnicos[$rowcc[0]]);
					$totalesap=array_sum($listaesap[$rowcc[0]]);
					$ccosto=$rowcc[0];
					if($totalcajacf!=0)//Caja de compensación familiar 
					{
						$ctaconcepto=$ctacont='';
						$parafiscal=$_POST[pcajacomp];
						$nomparafiscal=buscatercero($_POST[cajacomp]);
						$nitparafiscal=$_POST[cajacomp];
 						$valparafiscal=$totalcajacf;
						//Cuenta debito Caja de compensación familiar
						$ctacont=cuentascontables::cuentadebito_parafiscales($parafiscal,$ccosto,$vigenomina, $_POST['fechafi']);
						$nresul=buscacuenta($ctacont);
						echo "
						<tr class='$iter'>
							<td>$con</td>
							<td>$ctacont</td>
							<td>$nresul</td>
							<td>$nitparafiscal</td>
							<td>$nomparafiscal</td>
							<td>$rowcc[0]</td>
							<td>Aportes Caja Compensación Mes $meslnomina</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($valparafiscal,0)."</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
						</tr>";
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
						$ctaconcepto=cuentascontables::cuentacredito_parafiscales($parafiscal,$ccosto,$vigenomina, $_POST['fechafi']);
						$nresul=buscacuenta($ctaconcepto);
						echo "
						<tr class='$iter'>
							<td>$con</td>
							<td>$ctaconcepto</td>
							<td>$nresul</td>
							<td>$nitparafiscal</td>
							<td>$nomparafiscal</td>
							<td>$ccosto</td>
							<td>Aportes Caja Compensación Mes $meslnomina</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($valparafiscal,0)."</td>
						</tr>";
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
						$parafiscal=$_POST[picbf];
						$nomparafiscal=buscatercero($_POST[icbf]);
						$nitparafiscal=$_POST[icbf];
						$valparafiscal=$totalicbf;
						//Cuenta debito ICBF
						$ctacont=cuentascontables::cuentadebito_parafiscales($parafiscal,$ccosto,$vigenomina, $_POST['fechafi']);
						$nresul=buscacuenta($ctacont);
						echo "
						<tr class='$iter'>
							<td>$con</td>
							<td>$ctacont</td>
							<td>$nresul</td>
							<td>$nitparafiscal</td>
							<td>$nomparafiscal</td>
							<td>$rowcc[0]</td>
							<td>Aportes ICBF Mes $meslnomina</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($valparafiscal,0)."</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
						</tr>";
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
						$ctaconcepto=cuentascontables::cuentacredito_parafiscales($parafiscal,$ccosto,$vigenomina, $_POST['fechafi']);
						$nresul=buscacuenta($ctaconcepto);
						echo "
						<tr class='$iter'>
							<td>$con</td>
							<td>$ctaconcepto</td>
							<td>$nresul</td>
							<td>$nitparafiscal</td>
							<td>$nomparafiscal</td>
							<td>$ccosto</td>
							<td>Aportes ICBF Mes $meslnomina</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($valparafiscal,0)."</td>
						</tr>";
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
						$parafiscal=$_POST[psena];
						$nitparafiscal=$_POST[sena];
						$nomparafiscal=buscatercero($_POST[sena]);
						$valparafiscal=$totalsena;
						//Cuenta debito SENA
						$ctacont=cuentascontables::cuentadebito_parafiscales($parafiscal,$ccosto,$vigenomina, $_POST['fechafi']);
						$nresul=buscacuenta($ctacont);
						echo "
						<tr class='$iter'>
							<td>$con</td>
							<td>$ctacont</td>
							<td>$nresul</td>
							<td>$nitparafiscal</td>
							<td>$nomparafiscal</td>
							<td>$rowcc[0]</td>
							<td>Aportes SENA Mes $meslnomina</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($valparafiscal,0)."</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
						</tr>";
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
						$ctaconcepto=cuentascontables::cuentacredito_parafiscales($parafiscal,$ccosto,$vigenomina, $_POST['fechafi']);
						$nresul=buscacuenta($ctaconcepto);
						echo "
						<tr class='$iter'>
							<td>$con</td>
							<td>$ctaconcepto</td>
							<td>$nresul</td>
							<td>$nitparafiscal</td>
							<td>$nomparafiscal</td>
							<td>$ccosto</td>
							<td>Aportes SENA Mes $meslnomina</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($valparafiscal,0)."</td>
						</tr>";
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
						$parafiscal=$_POST[piti];
						$nitparafiscal=$_POST[iti];
						$nomparafiscal=buscatercero($_POST[iti]);
						$valparafiscal=$totalinstecnicos;
						//Cuenta debito Inst tecnicos 
						$ctacont=cuentascontables::cuentadebito_parafiscales($parafiscal,$ccosto,$vigenomina, $_POST['fechafi']);
						$nresul=buscacuenta($ctacont);
						echo "
						<tr class='$iter'>
							<td>$con</td>
							<td>$ctacont</td>
							<td>$nresul</td>
							<td>$nitparafiscal</td>
							<td>$nomparafiscal</td>
							<td>$rowcc[0]</td>
							<td>Aportes Inst técnicos Mes $meslnomina</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($valparafiscal,0)."</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
						</tr>";
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
						$ctaconcepto=cuentascontables::cuentacredito_parafiscales($parafiscal,$ccosto,$vigenomina, $_POST['fechafi']);
						$nresul=buscacuenta($ctaconcepto);
						echo "
						<tr class='$iter'>
							<td>$con</td>
							<td>$ctaconcepto</td>
							<td>$nresul</td>
							<td>$nitparafiscal</td>
							<td>$nomparafiscal</td>
							<td>$ccosto</td>
							<td>Aportes Inst técnicos Mes $meslnomina</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($valparafiscal,0)."</td>
						</tr>";
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
						$parafiscal=$_POST[pesap];
  						$nitparafiscal=$_POST[esap];
  						$nomparafiscal=buscatercero($_POST[esap]);
						$valparafiscal=$totalesap;
						//Cuenta debito ESAP
						$ctacont=cuentascontables::cuentadebito_parafiscales($parafiscal,$ccosto,$vigenomina, $_POST['fechafi']);
						$nresul=buscacuenta($ctacont);
						echo "
						<tr class='$iter'>
							<td>$con</td>
							<td>$ctacont</td>
							<td>$nresul</td>
							<td>$nitparafiscal</td>
							<td>$nomparafiscal</td>
							<td>$rowcc[0]</td>
							<td>Aportes ESAP Mes $meslnomina</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($valparafiscal,0)."</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
						</tr>";
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
						$ctaconcepto=cuentascontables::cuentacredito_parafiscales($parafiscal,$ccosto,$vigenomina, $_POST['fechafi']);
						$nresul=buscacuenta($ctaconcepto);
						echo "
						<tr class='$iter'>
							<td>$con</td>
							<td>$ctaconcepto</td>
							<td>$nresul</td>
							<td>$nitparafiscal</td>
							<td>$nomparafiscal</td>
							<td>$ccosto</td>
							<td>Aportes ESAP Mes $meslnomina</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($valparafiscal,0)."</td>
						</tr>";
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
				echo "
					<tr class='titulos2'>
						<td colspan='4'></td>
						<td colspan='2' style='text-align:right;'>Diferencia:</td>
						<td> $".number_format(array_sum($listadebitos)-array_sum($listacreditos),0,',','.')."</td>
						<td style='text-align:right;'>$".number_format(array_sum($listadebitos),0,',','.')."</td>
					  	<td style='text-align:right;'>$".number_format(array_sum($listacreditos),0,',','.')."</td>
					</tr>
				</table>";			
			?>
		</div>
		<?php
			if($_POST[oculto]==2)
 			{
				$id=$_POST[idliq];
				$sqlr="DELETE FROM comprobante_cab WHERE numerotipo='$id' AND tipo_comp='4'";
				mysql_query($sqlr,$linkbd);
				$sqlr="DELETE FROM comprobante_det WHERE numerotipo='$id' AND tipo_comp='4'";
				mysql_query($sqlr,$linkbd);
   				ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
				$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	  			$lastday = mktime (0,0,0,$_POST[periodo],1,$_POST[vigenomi]);
				if($_POST[causacion]!='2'){$descripgen="CAUSACION $primanom MES $meslnomina";}
				else {$descripgen="ESTE DOCUMENTO NO REQUIERE CAUSACION CONTABLE";}
	 			$sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($id,4,'$fechaf','$descripgen',0,0,0,0,'1')";
				mysql_query($sqlr,$linkbd);
				if($_POST[causacion]!='2')
				{
					for ($x=0;$x<count($listacuentas);$x++) 
					{
						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('4 $id','$listacuentas[$x]','$listaterceros[$x]','$listaccs[$x]','$listadetalles[$x]','','$listadebitos[$x]','$listacreditos[$x]','1', '$_POST[vigenomi]')";	
						mysql_query($sqlr,$linkbd);		
					}
				}
 			}
?>
		</form>
	</body>
</html>