<?php //V 1001 20/12/16 ?> 
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
		<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Spid - Gestion Humana</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
        <script type="text/javascript" src="css/calendario.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
        <script>
			function funordenar(var01)
			{
				if(document.getElementById(''+var01).value==0){document.getElementById(''+var01).value=1;}
				else if(document.getElementById(''+var01).value==1) {document.getElementById(''+var01).value=2;}
				else{document.getElementById(''+var01).value=0;}
				switch(var01)
				{
					case 'cel01':	document.getElementById('cel02').value=0;
									document.getElementById('cel03').value=0
									document.getElementById('cel04').value=0;
									document.getElementById('cel05').value=0;
									break;
					case 'cel02':	document.getElementById('cel01').value=0;
									document.getElementById('cel03').value=0;
									document.getElementById('cel04').value=0;
									document.getElementById('cel05').value=0;
									break;
					case 'cel03':	document.getElementById('cel01').value=0;
									document.getElementById('cel02').value=0;
									document.getElementById('cel04').value=0;
									document.getElementById('cel05').value=0;
									break;
					case 'cel04':	document.getElementById('cel01').value=0;
									document.getElementById('cel02').value=0;
									document.getElementById('cel03').value=0;
									document.getElementById('cel05').value=0;
									break;
					case 'cel05':	document.getElementById('cel01').value=0;
									document.getElementById('cel02').value=0;
									document.getElementById('cel03').value=0;
									document.getElementById('cel04').value=0;
									break;
				}
				document.form2.submit();
			}
			function callprogress(vValor,vInfor)
			{
				document.getElementById("getprogress").innerHTML = vInfor+" "+vValor;
				document.getElementById("getProgressBarFill").innerHTML = '<div class="ProgressBarFill" style="width: '+vValor+'%;"></div>';				
				document.getElementById("titulog1").style.display='block';
				document.getElementById("progreso").style.display='block';
				document.getElementById("getProgressBarFill").style.display='block';
				if (vValor==100){document.getElementById("titulog1").style.display='none';}
			}
			function callprogress2(vValor,vInfor)
			{
				document.getElementById("getprogress2").innerHTML = vInfor+" "+vValor;
				document.getElementById("getProgressBarFill2").innerHTML = '<div class="ProgressBarFill" style="width: '+vValor+'%;"></div>';				
				document.getElementById("titulog2").style.display='block';
				document.getElementById("progreso2").style.display='block';
				document.getElementById("getProgressBarFill2").style.display='block';
				if (vValor==100)
				{
					document.getElementById("titulog2").style.display='none';
					document.getElementById("progreso2").style.display='none';
					document.getElementById("getProgressBarFill2").style.display='none';
				}
			}
			function cargardatos()
			{
				document.form2.cargainfo.value="1";
				document.form2.sema01.value='imagenes/sema_OFF.jpg';
				document.form2.sema02.value='imagenes/sema_OFF.jpg';
				document.form2.sema03.value='imagenes/sema_OFF.jpg';
				document.form2.sema04.value='imagenes/sema_OFF.jpg';
				document.form2.sema05.value='imagenes/sema_OFF.jpg';
				document.form2.submit();
				
			}
			function cambiosema(valsem)
			{
				switch(valsem)
				{
					case '01':		document.form2.sema01.value='imagenes/sema_verdeON.jpg';
									document.form2.vsema01.src='imagenes/sema_verdeON.jpg';
									break;
					case '02':		document.form2.sema02.value='imagenes/sema_verdeON.jpg';
									document.form2.vsema02.src='imagenes/sema_verdeON.jpg';
									break;
					case '03':		document.form2.sema03.value='imagenes/sema_verdeON.jpg';
									document.form2.vsema03.src='imagenes/sema_verdeON.jpg';
									break;
					case '04':		document.form2.sema04.value='imagenes/sema_verdeON.jpg';
									document.form2.vsema04.src='imagenes/sema_verdeON.jpg';
									break;
					case '05':		document.form2.sema05.value='imagenes/sema_verdeON.jpg';
									document.form2.vsema05.src='imagenes/sema_verdeON.jpg';
									break;
				}
			}
			function excell()
			{
				document.form2.action="hum-buscadescuentosnomexcel.php";
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
			<tr><script>barra_imagenes("hum");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("hum");?></tr>
			<tr>
				<td colspan="3" class="cinta"><img src="imagenes/add2.png" title="Nuevo" class="mgbt1"/><img src="imagenes/guardad.png" class="mgbt1"/><img src="imagenes/busca.png" title="Buscar" onClick="document.form2.submit();" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana"  onClick="mypop=window.open('hum-principal.php','','');mypop.focus();" class="mgbt"/><img src="imagenes/excel.png" title="Excel" onClick='excell()' class="mgbt"/><img src='imagenes/iratras.png' title='Men&uacute; Nomina' class='mgbt' onClick="location.href='hum-menunomina.php'"/></td>
			</tr>	
		</table>
		<form name="form2" method="post" action="hum-reportenom_liquidacion_egresos.php">
			<?php 
				if($_POST[oculto]=="")
				{
					$_POST[numpos]=0;$_POST[numres]=10;$_POST[nummul]=0;
					$_POST[cel01]=$_POST[cel02]=$_POST[cel03]=$_POST[cel04]=$_POST[cel05]=0;
					$_POST[sema01]=$_POST[sema02]=$_POST[sema03]=$_POST[sema04]=$_POST[sema05]="imagenes/sema_OFF.jpg";
					
					$sqlr="TRUNCATE TABLE hum_temreporteliquiegreso;";
					mysql_query($sqlr,$linkbd);
				}
			?>
			<table  class="inicio" align="center" >
				<tr>
					<td class="titulos" colspan="8">:. Buscar Descuentos de Nomina</td>
					<td class="cerrar" style="width:7%" onClick="location.href='hum-principal.php'">Cerrar</td>
				</tr>
				<tr>
					<td class="saludo1">Fecha Inicio:</td>
					<td><input type="text" name="fechafdc" id="fc_1198971551" value="<?php echo $_POST[fechafdc]?>" maxlength="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY"  style="width:75%;height:35px"/>&nbsp;<img src="imagenes/calendario04.png" onClick="displayCalendarFor('fc_1198971551');" class="icobut" title="Fecha Inicio"/></td>
                    <td class="saludo1">Fecha Final:</td>
					<td><input type="text" name="fechafin" id="fc_1198971552" value="<?php echo $_POST[fechafin]?>" maxlength="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY"  style="width:75%;height:35px"/>&nbsp;<img src="imagenes/calendario04.png" onClick="displayCalendarFor('fc_1198971552');" class="icobut" title="Fecha Final"/></td>
					<td style="padding-bottom:5px" colspan="2"><em class="botonflecha" onClick="cargardatos();">Cargar Datos</em></td>
					
						<?php
							echo"
							<td>
								<input type='hidden' name='sema01' id='sema01' value='$_POST[sema01]'/>
								<input type='hidden' name='sema02' id='sema02' value='$_POST[sema02]'/>
								<input type='hidden' name='sema03' id='sema03' value='$_POST[sema03]'/>
								<input type='hidden' name='sema04' id='sema04' value='$_POST[sema04]'/>
								<input type='hidden' name='sema05' id='sema05' value='$_POST[sema05]'/>
								<img name='vsema01' id='vsema01' src='$_POST[sema01]' style='width:21px;'/><img name='vsema02' id='vsema02' src='$_POST[sema02]' style='width:21px;'/><img name='vsema03' id='vsema03' src='$_POST[sema03]' style='width:21px;'/><img name='vsema04' id='vsema04' src='$_POST[sema04]' style='width:21px;'/><img name='vsema05' id='vsema05' src='$_POST[sema05]' style='width:21px;'/>
							</td>
							<td>
								<div id='titulog1' style='display:none; float:left'></div>
								<div id='progreso' class='ProgressBar' style='display:none; float:left'>
									<div class='ProgressBarText'><span id='getprogress'></span>&nbsp;% </div>
									<div id='getProgressBarFill'></div>
								</div>
								
							</td>
							";
						?>
				</tr>
				<tr>
					<td class="saludo1" style="width:2.5cm;">N&deg; Aprobado:</td>
					<td style="width:10%;" ><input type="search" name="naprobado" id="naprobado" value="<?php echo $_POST[naprobado];?>" style="width:75%;height:35px"></td>
					<td class="saludo1" style="width:2.5cm;">N&deg; Nomina: </td>
					<td style="width:10%;"><input type="search" name="nnomina" id="nnomina" value="<?php echo $_POST[nnomina];?>" style="width:100%;height:35px"></td>
                    <td class="saludo1" style="width:2.5cm;">Tipo: </td>
					<td  style="width:8%;"><input type="search" name="descrip" id="descrip" value="<?php echo $_POST[descrip];?>" style="width:100%;height:35px"></td>
					<td style=" padding-bottom:5px"><em class="botonflecha" onClick="document.form2.submit();">Buscar</em></td>
				</tr>
			</table> 
			<input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
			<input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
			<input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
			<input type="hidden" name="cel01" id="cel01" value="<?php echo $_POST[cel01];?>"/>
			<input type="hidden" name="cel02" id="cel02" value="<?php echo $_POST[cel02];?>"/>
			<input type="hidden" name="cel03" id="cel03" value="<?php echo $_POST[cel03];?>"/>
			<input type="hidden" name="cel04" id="cel04" value="<?php echo $_POST[cel04];?>"/>
			<input type="hidden" name="cel05" id="cel05" value="<?php echo $_POST[cel05];?>"/>
            <input type="hidden" name="cargainfo" id="cargainfo" value="0">
			<input type="hidden" name="oculto" id="oculto" value="1">   
			<div class="subpantallac5" style="height:58.5%; width:99.6%; overflow-x:hidden;">
				<?php
					if($_POST[cargainfo]=='1')
					{
						ini_set('max_execution_time', 7200);
						$sqlr="TRUNCATE TABLE hum_temreporteliquiegreso;";
						mysql_query($sqlr,$linkbd);
						$varfech=0;
						if($_POST[fechafdc]!=""){$varfech=1;}
						if($_POST[fechafin]!=""){$varfech=$varfech+2;}
						switch($varfech)
						{
							case 0:		$fechach="";
										break;
							case 1:		preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $_POST[fechafdc],$fecha);
										$fechaf="$fecha[3]-$fecha[2]-$fecha[1]";
										$fechach="WHERE T1.fecha >= '$fechaf'";
										break;
							case 2: 	preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $_POST[fechafin],$fecha);
										$fechaf="$fecha[3]-$fecha[2]-$fecha[1]";
										$fechach="WHERE T1.fecha <= '$fechaf'";
										break;
							case 3: 	preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $_POST[fechafdc],$fecha1);
										$fechai="$fecha1[3]-$fecha1[2]-$fecha1[1]";
										preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $_POST[fechafin],$fecha2);
										$fechaf="$fecha2[3]-$fecha2[2]-$fecha2[1]";
										$fechach="WHERE T1.fecha BETWEEN '$fechai' AND '$fechaf'";
										break;
						}		
						//Liquidación pagos funcionarios aprobados
						$c=0;
						$sqlr="SELECT T1.id_aprob,T1.id_nom,T2.cedulanit,T2.netopagar,T2.tipopago,T2.cc,T2.id FROM humnomina_aprobado T1 INNER JOIN humnomina_det T2 ON T1.id_nom=T2.id_nom $fechach";
						$resp = mysql_query($sqlr,$linkbd);
						$totalcli=mysql_affected_rows ($linkbd);
						while ($row =mysql_fetch_row($resp)) 
						{
							$c+=1;
							$porcentaje = $c * 100 / $totalcli; 
							echo"<script>progres='".round($porcentaje)."';callprogress(progres,'Nomina');</script>"; 
							flush();
							ob_flush();
							usleep(5);
							$idlista=selconsecutivo('hum_temreporteliquiegreso','id');
							$sqlr01="INSERT INTO hum_temreporteliquiegreso (id,aprobado,nomina,documento,netonom,tipopago,cc,idnom) VALUES ('$idlista','$row[0]','$row[1]','$row[2]','$row[3]','$row[4]','$row[5]','$row[6]')";
							mysql_query($sqlr01,$linkbd);
						}
						echo "<script>cambiosema('01');</script>";
						//Liquidación pagos Parafiscales aprobados
						$c=0;
						$sqlpf="SELECT * FROM admfiscales WHERE estado='S' AND vigencia='2018'";
						$respf = mysql_query($sqlpf,$linkbd);
						while($rowpf=mysql_fetch_row($respf))
						{
							$cajascom=$rowpf[13];
							$icbf=$rowpf[10];	
							$sena=$rowpf[11];	
							$iti=$rowpf[12];	
							$esap=$rowpf[14];
							$arp=$rowpf[15];						 					 					 					 
						}
						$sqlr="SELECT T1.id_aprob,T1.id_nom,T2.valor,T2.id_parafiscal,T2.cc FROM humnomina_aprobado T1 INNER JOIN humnomina_parafiscales T2 ON T1.id_nom=T2.id_nom $fechach";
						$resp = mysql_query($sqlr,$linkbd);
						$totalcli=mysql_affected_rows ($linkbd);
						while ($row =mysql_fetch_row($resp)) 
						{
							$c+=1;
							$porcentaje = $c * 100 / $totalcli; 
							echo"<script>progres='".round($porcentaje)."';callprogress(progres,'Parafiscales');</script>"; 
							flush();
							ob_flush();
							usleep(5);
							switch($row[3])
							{
								case '01': $tercero=$cajascom;break;
								case '02': $tercero=$icbf;break;
								case '03': $tercero=$sena;break;
								case '04': $tercero=$iti;break;
								case '05': $tercero=$esap;break;
								case '06': $tercero=$arp;break;
							}						
							$idlista=selconsecutivo('hum_temreporteliquiegreso','id');
							$sqlr01="INSERT INTO hum_temreporteliquiegreso (id,aprobado,nomina,documento,netonom,tipopago,cc,idnom) VALUES ('$idlista','$row[0]','$row[1]','$tercero','$row[2]','F','$row[4]','')";
							mysql_query($sqlr01,$linkbd);
						}
						echo "<script>cambiosema('02');</script>";
						//Liquidación pagos Salud y Pensión aprobados
						$c=0;
						$sqlr="SELECT T1.id_aprob,T1.id_nom,T2.tercero,SUM(T2.valor),T2.tipo,T2.cc,T2.id FROM humnomina_aprobado T1 INNER JOIN humnomina_saludpension T2 ON T1.id_nom=T2.id_nom $fechach GROUP BY T1.id_nom,T2.tercero,T2.tipo";
						$resp = mysql_query($sqlr,$linkbd);
						$totalcli=mysql_affected_rows ($linkbd);
						while ($row =mysql_fetch_row($resp)) 
						{
							$c+=1;
							$porcentaje = $c * 100 / $totalcli; 
							echo"<script>progres='".round($porcentaje)."';callprogress(progres,'Salud y Pension');</script>"; 
							flush();
							ob_flush();
							usleep(5);
							$idlista=selconsecutivo('hum_temreporteliquiegreso','id');
							$sqlr01="INSERT INTO hum_temreporteliquiegreso (id,aprobado,nomina,documento,netonom,tipopago,cc,idnom) VALUES ('$idlista','$row[0]','$row[1]','$row[2]','$row[3]','$row[4]','$row[5]','$row[6]')";
							mysql_query($sqlr01,$linkbd);
						}
						echo "<script>cambiosema('03');</script>";
						//Liquidación pagos Descuentos y Retenciones
						$c=0;
						$sqlr="SELECT T1.id_aprob,T1.id_nom,T2.id,T2.valor,T2.tipo_des,T2.id_des FROM humnomina_aprobado T1 INNER JOIN humnominaretenemp T2 ON T1.id_nom=T2.id_nom $fechach";
						$resp = mysql_query($sqlr,$linkbd);
						$totalcli=mysql_affected_rows ($linkbd);
						while ($row =mysql_fetch_row($resp)) 
						{
							$c+=1;
							$porcentaje = $c * 100 / $totalcli; 
							echo"<script>progres='".round($porcentaje)."';callprogress(progres,'Descuentos');</script>"; 
							flush();
							ob_flush();
							usleep(5);
							if($row[4]=='DS')
							{
								$sqlre0="SELECT id_retencion FROM humretenempleados WHERE id='$row[2]'";
								$resre0 = mysql_query($sqlre0,$linkbd);
								$rowre0 =mysql_fetch_row($resre0);
								$sqlre1="SELECT beneficiario FROM humvariablesretenciones WHERE codigo='$rowre0[0]'";
								$resre1 = mysql_query($sqlre1,$linkbd);
								$rowre1 = mysql_fetch_row($resre1);
								$tercero=$rowre1[0];
							}
							else {$tercero="";}
							$idlista=selconsecutivo('hum_temreporteliquiegreso','id');
							$sqlr01="INSERT INTO hum_temreporteliquiegreso (id,aprobado,nomina,documento,netonom,tipopago,cc,idnom) VALUES ('$idlista','$row[0]','$row[1]','$tercero','$row[3]','$row[4]','','$row[5]')";
							mysql_query($sqlr01,$linkbd);
						}
						echo "<script>cambiosema('04');</script>";
						//ingreso informacion egresos
						$c=0;
						$sqlr="SELECT id,nomina,tipopago,documento,netonom FROM hum_temreporteliquiegreso";
						$resp = mysql_query($sqlr,$linkbd);
						$totalcli=mysql_affected_rows ($linkbd);
						while ($row =mysql_fetch_row($resp)) 
						{
							$c+=1;
							$porcentaje = $c * 100 / $totalcli; 
							echo"<script>progres='".round($porcentaje)."';callprogress(progres,'Egresos');</script>"; 
							flush();
							ob_flush();
							usleep(5);
							$varidegreso=$variddetalle=$varcuenta=$varestado="";
							$valnom=round($row[4]);
							$sqleg="SELECT id_egreso,id_det,cuentap,estado FROM tesoegresosnomina_det WHERE id_orden='$row[1]' AND tipo='$row[2]' AND tercero='$row[3]' AND valor='$valnom'";
							$reseg = mysql_query($sqleg,$linkbd);
							while ($roweg =mysql_fetch_row($reseg)) 
							{
								if($varidegreso==""){$varidegreso=$roweg[0];}
								else 
								{
									$pos = strpos($varidegreso, $roweg[0]);
									if($pos !== false){$varidegreso=$varidegreso;}
									else {$varidegreso= "$varidegreso - $roweg[0]";}
								}
								if($variddetalle==""){$variddetalle=$roweg[1];}
								else {$variddetalle="$variddetalle - $roweg[1]";}
								if($varcuenta==""){$varcuenta=$roweg[2];}
								else {$varcuenta="$varcuenta - $roweg[2]";}
								if($varestado==""){$varestado=$roweg[3];}
								else {$varestado="$varestado - $roweg[3]";}
							}
							if ($varidegreso==""){$valegreso=0;}
							else {$valegreso=$row[4];}
							$sqlr01="UPDATE hum_temreporteliquiegreso SET idegreso='$varidegreso',iddetalle='$variddetalle',cuenta='$varcuenta', netoegreso='$valegreso',estado='$varestado' WHERE id='$row[0]'";
							mysql_query($sqlr01,$linkbd);
						}
						echo "<script>cambiosema('05');</script>";
					}
					if ($_POST[naprobado]!=""){$crit1=" AND aprobado LIKE '%$_POST[naprobado]%'";}
					else {$crit1="";}
					if ($_POST[nnomina]!=""){$crit2=" AND nomina LIKE '%$_POST[nnomina]%'";}
					else {$crit2="";}
					if ($_POST[descrip]!=""){$crit3=" AND descripcion LIKE '%$_POST[descrip]%'";}
					else {$crit3="";}
					if($_POST[cel01]==0){$cl01='titulos3';$ord01=$ico01="";}
					else 
					{
						$cl01='celactiva';
						if($_POST[cel01]==1)
						{
							$ord01="ORDER BY aprobado ASC";
							$ico01="<img src='imagenes/bullet_arrow_up.png' style='width:24px;'/>";
						}
						else 
						{
							$ord01="ORDER BY aprobado DESC";
							$ico01="<img src='imagenes/bullet_arrow_down.png' style='width:24px;'/>";
						}
					}
					if($_POST[cel02]==0){$cl02='titulos3';$ord02=$ico02="";}
					else 
					{
						$cl02='celactiva';
						if($_POST[cel02]==1)
						{
							$ord02="ORDER BY nomina ASC";
							$ico02="<img src='imagenes/bullet_arrow_up.png' style='width:24px;'/>";
						}
						else 
						{
							$ord02="ORDER BY nomina DESC"; 
							$ico02="<img src='imagenes/bullet_arrow_down.png' style='width:24px;'/>";
						}
					}
					if($_POST[cel03]==0){$cl03='titulos3';$ord03=$ico03="";}
					else 
					{
						$cl03='celactiva';
						if($_POST[cel03]==1)
						{
							$ord03="ORDER BY tipopago ASC";
							$ico03="<img src='imagenes/bullet_arrow_up.png' style='width:24px;'/>";
						}
						else 
						{
							$ord03="ORDER BY tipopago DESC"; 
							$ico03="<img src='imagenes/bullet_arrow_down.png' style='width:24px;'/>";
						}
					}
					if($_POST[cel04]==0){$cl04='titulos3';$ord04=$ico04="";}
					else 
					{
						$cl04='celactiva';
						if($_POST[cel04]==1)
						{
							$ord04="ORDER BY cc ASC";
							$ico04="<img src='imagenes/bullet_arrow_up.png' style='width:24px;'/>";
						}
						else 
						{
							$ord04="ORDER BY cc DESC"; 
							$ico04="<img src='imagenes/bullet_arrow_down.png' style='width:24px;'/>";
						}
					}
					if($_POST[cel05]==0){$cl05='titulos3';$ord05=$ico05="";}
					else 
					{
						$cl05='celactiva';
						if($_POST[cel05]==1)
						{
							$ord05=" ORDER BY documento ASC";
							$ico05="<img src='imagenes/bullet_arrow_up.png' style='width:24px;'/>";
						}
						else 
						{
							$ord05=" ORDER BY documento DESC"; 
							$ico05="<img src='imagenes/bullet_arrow_down.png' style='width:24px;'/>";
						}
					}
					$sqlr="SELECT * FROM hum_temreporteliquiegreso WHERE id<>'' $crit1 $crit2";
					$resp = mysql_query($sqlr,$linkbd);
					$_POST[numtop]=mysql_num_rows($resp);
					$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
					if ($_POST[numres]!="-1"){$cond2="LIMIT $_POST[numpos], $_POST[numres]";}
					else{$cond2="";}
					$sqlr="SELECT * FROM hum_temreporteliquiegreso WHERE id<>'' $crit1 $crit2 $ord01 $ord02 $ord03 $ord04 $ord05 $cond2";
					$resp = mysql_query($sqlr,$linkbd);
					$totalcli=$ntr = mysql_num_rows($resp); 
					$con=1;
					$numcontrol=$_POST[nummul]+1;
					if($nuncilumnas==$numcontrol)
					{
						$imagenforward="<img src='imagenes/forward02.png' style='width:17px'>";
						$imagensforward="<img src='imagenes/skip_forward02.png' style='width:16px' >";
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
					<table class='inicio' align='center' id='columns'>
						<tr>
							<td colspan='11' class='titulos'>.: Resultados Busqueda:</td>
							<td class='submenu'>
								<select name='renumres' id='renumres' onChange='cambionum();' style='width:100%'>
									<option value='10'"; if ($_POST[renumres]=='10'){echo 'selected';} echo ">10</option>
									<option value='20'"; if ($_POST[renumres]=='20'){echo 'selected';} echo ">20</option>
									<option value='30'"; if ($_POST[renumres]=='30'){echo 'selected';} echo ">30</option>
									<option value='50'"; if ($_POST[renumres]=='50'){echo 'selected';} echo ">50</option>
									<option value='100'"; if ($_POST[renumres]=='100'){echo 'selected';} echo ">100</option>
									<option value='-1'"; if ($_POST[renumres]=='-1'){echo 'selected';} echo ">Todos</option>
								</select>
							</td>
						</tr>
						<tr>
							<td colspan='4'>Variables Encontradas: $_POST[numtop]</td>
							<td colspan='7'>
								<div id='titulog2' style='display:none; float:left'></div>
								<div id='progreso2' class='ProgressBar' style='display:none; float:left'>
									<div class='ProgressBarText'><span id='getprogress2'></span>&nbsp;% </div>
									<div id='getProgressBarFill2'></div>
								</div>
							</td>
						</tr>
						<tr>
							<th class='$cl01' style='width:6%' onClick=\"funordenar('cel01');\">Aprobado $ico01</th>
							<th class='$cl02' style='width:6%' onClick=\"funordenar('cel02');\">Nomina $ico02</th>
							<th class='$cl03' style='width:4%' onClick=\"funordenar('cel03');\">Tipo $ico03</th>
							<th class='$cl04' style='width:3%'onClick=\"funordenar('cel04');\">cc $ico04</th>
							<th class='$cl05' style='width:8%' onClick=\"funordenar('cel05');\">Documento $ico05</th>
							<th class='titulos3'>Nombre</th>
							<th class='titulos3' style='width:8%'>Neto Nomina</th>
							<th class='titulos3' style='width:8%'>Egreso</th>
							<th class='titulos3' style='width:8%'>Detalle</th>
							<th class='titulos3' style='width:10%'>Cuenta</th>
							<th class='titulos3' style='width:8%'>Neto Egreso</th>
							<th class='titulos3' style='width:6%'>Estado</th>
						</tr>";	
					$iter='saludo1a';
					$iter2='saludo2';
					$c=0;
					while ($row =mysql_fetch_row($resp)) 
					{
						$nomdesc=iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$row[1]);
						$nemp=iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$row[11]);
						$fechar=date('d-m-Y',strtotime($row[3]));
						$numegr=strlen($row[8]); 
						if($numegr=="" || $numegr>4){$estilo='background-color:#FF9'; }
						else {$estilo='';}
						$nomtercero=buscatercero($row[5]);
						$c+=1;
						$porcentaje = $c * 100 / $totalcli; 
						echo"<script>progres='".round($porcentaje)."';callprogress2(progres,'Mostrar Informaci&oacute;n');</script>"; 
						flush();
						ob_flush();
						usleep(5);
						echo"
						<tr class='$iter'  style='text-transform:uppercase; $estilo'>
							<td>$row[1]</td>
							<td>$row[2]</td>
							<td>$row[3]</td>
							<td>$row[4]</td>
							<td>".number_format($row[5],0,',','.')."</td>
							<td>$nomtercero</td>
							<td style='text-align:right;'>$".number_format($row[7],0,',','.')."&nbsp;</td>
							<td>$row[8]</td>
							<td>$row[9]</td>
							<td>$row[10]</td>
							<td style='text-align:right;'>$".number_format($row[11],0,',','.')."&nbsp;</td>
							<td>$row[12]</td>
						</tr>";
						$con+=1;
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
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
					echo"		&nbsp;&nbsp;<a href='#'>$imagenforward</a>
								&nbsp;<a href='#'>$imagensforward</a>
							</td>
						</tr>
					</table>";
				?>
			</div>
			<input type="hidden" name="numtop" id="numtop" value="<?php echo $_POST[numtop];?>"/>
		</form>
	</body>
</html>