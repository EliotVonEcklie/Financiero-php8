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
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css"/>
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css"/>
		<link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css"/>
		<script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script type="text/javascript" src="css/calendario.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
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
					}
				}
			}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.getElementById('oculto').value="3";
								document.form2.submit();break;
				}
			}
			function pdf()
			{
				document.form2.action="plan-pdftareasas.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function excell()
			{
				document.form2.action="plan-actareasxcel.php";
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
			<tr><script>barra_imagenes("plan");</script><?php cuadro_titulos();?></tr>
			<tr><?php menu_desplegable("plan");?></tr>
			<tr>
				<td colspan="3" class="cinta"><a class="mgbt1"><img src="imagenes/add2.png"/></a><a class="mgbt1"><img src="imagenes/guardad.png" /></a><a onClick="document.form2.submit();" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a><a class="mgbt" onClick="<?php echo paginasnuevas("plan");?>"><img src="imagenes/nv.png" title="Nueva Ventana"></a><a class="mgbt" onClick="pdf();" ><img src="imagenes/print.png" title="Imprimir" style="width:29px; height:25px;"></a><a onClick="excell()" class="mgbt"><img src="imagenes/excel.png" title="Excel"></a></td>
			</tr>
		</table>
		<div id="bgventanamodalm" class="bgventanamodalm">
			<div id="ventanamodalm" class="ventanamodalm">
				<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
				</IFRAME>
			</div>
		</div>
		<form name="form2" method="post" action="plan-actareasbusca.php" >
			<?php 
				if(@ $_POST['oculto']=="")
				{
					$_POST['tinforme']="";
					$_POST['oculto']="0";
					$_POST['numpos']=0;
					$_POST['numres']=10;
					$_POST['nummul']=0;
				}
			?>
			<table class="inicio" align="center">
				<tr>
					<td class="titulos" colspan="6" >:: Tareas Programadas </td>
					<td class="cerrar" style="width:7%" onClick="location.href='plan-principal.php'">&nbsp;Cerrar</td>
				</tr>
				<tr>
					<td class="saludo1" style="width:3cm">Tipo de Tarea:</td>
					<td style="width:15%">
						<select id="tinforme" name="tinforme" class="elementosmensaje" style="width:95%"  onKeyUp="return tabular(event,this)"  onChange="limbusquedas();" >
							<option value="" <?php if(@ $_POST['tinforme']==""){echo " SELECTED";}?>>Todas Las Tareas</option>
							<option value="TR" <?php if(@ $_POST['tinforme']=="TR"){echo " SELECTED";}?>>Tareas Internas</option>
							<option value="RA" <?php if(@ $_POST['tinforme']=="RA"){echo " SELECTED";}?>>Tareas Externas</option>
						</select> 
					</td>
					<td class="saludo1" style="width:3cm">Estado de Tarea:</td>
					<td style="width:15%">
						<select id="testado" name="testado" class="elementosmensaje" style="width:95%"  onKeyUp="return tabular(event,this)"  onChange="limbusquedas();">
							<option value="" <?php if(@ $_POST['testado']==""){echo " SELECTED";}?>>Todos Los Estados</option>
							<option value="LN" <?php if(@ $_POST['testado']=="LN"){echo " SELECTED";}?>>Solo Lectura Sin Ver</option>
							<option value="LS" <?php if(@ $_POST['testado']=="LS"){echo " SELECTED";}?>>Solo Lectura Vistos</option>
							<option value="AN" <?php if(@ $_POST['testado']=="AN"){echo " SELECTED";}?>>Para Constestar</option>
							<option value="AC" <?php if(@ $_POST['testado']=="AC"){echo " SELECTED";}?>>Contestadas</option>
							<option value="AR" <?php if(@ $_POST['testado']=="AR"){echo " SELECTED";}?>>Redirigidas</option>
							<option value="AV" <?php if(@ $_POST['testado']=="AV"){echo " SELECTED";}?>>Vencidas</option>
							<option value="CN" <?php if(@ $_POST['testado']=="CN"){echo " SELECTED";}?>>Consultas Sin Contestas</option>
							<option value="CS" <?php if(@ $_POST['testado']=="CS"){echo " SELECTED";}?>>Consultas Sin Contestas</option>
						</select>
					</td>
					<td style="width:3cm" class="saludo1">C&oacute;digo:</td>
					<td><input type="search" name="nradicacion" id="nradicacion" value="<?php echo @ $_POST['nradicacion'];?>" style="width:50%" onBlur="limbusquedas();"></td>
					<td></td>
				</tr>
				<tr>
					<td class="saludo1">Fecha Inicial:</td>
					<td>
						<input type="date" name="fechaini" id="fc_01" title="YYYY-MM-DD" value="<?php echo @ $_POST['fechaini']; ?>" max="2999-12-31" onKeyUp="return tabular(event,this);"style="width:80%;" />&nbsp;<a onClick="displayCalendarFor('fc_01');"><img src="imagenes/calendario04.png" style="width:20px; cursor:pointer;" title="Calendario"/></a>
					</td>
					<td class="saludo1">Fecha Final:</td>
					<td>
					<input type="date" name="fechafin"  id="fc_02" title="YYYY-MM-DD" value="<?php echo @ $_POST['fechafin']; ?>" max="2999-12-31" onKeyUp="return tabular(event,this);"style="width:80%;" />&nbsp;<a onClick="displayCalendarFor('fc_02');"><img src="imagenes/calendario04.png" style="width:20px; cursor:pointer;" title="Calendario"/></a>
					</td>
					<td><input type="button" name="bboton" onClick="limbusquedas();" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;" /></td>
				</tr>
			</table>
			<input type="hidden" name="numres" id="numres" value="<?php echo @ $_POST['numres'];?>"/>
			<input type="hidden" name="numpos" id="numpos" value="<?php echo @ $_POST['numpos'];?>"/>
			<input type="hidden" name="nummul" id="nummul" value="<?php echo @ $_POST['nummul'];?>"/>
			<div class="subpantallac5" style="height:65%; width:99.5%; overflow-x:hidden">
				<?php
					$crit1=$crit2=$crit3=$crit4='';
					if (@ $_POST['fechaini']!="" xor @ $_POST['fechafin']!="")
					{
						if(@ $_POST['fechaini']==""){echo "<script>despliegamodalm('visible','2','Se deben ingresar la fecha inicial ')</script>";}
						else {echo "<script>despliegamodalm('visible','2','Se deben ingresar la fecha final ')</script>";}
					}
					elseif (@ $_POST['fechaini']!="" && @ $_POST['fechafin']!="")
					{
						$fecini=explode("-",date('d-m-Y',strtotime($_POST['fechaini'])));
						$fecfin=explode("-",date('d-m-Y',strtotime($_POST['fechafin'])));
						if(gregoriantojd($fecfin[1],$fecfin[0],$fecfin[2])< gregoriantojd($fecini[1],$fecini[0],$fecini[2]))
						{echo "<script>despliegamodalm('visible','2','La fecha inicial no debe ser mayor a la fecha final')</script>";}
						else
						{$crit4=" AND TB1.fechasig BETWEEN CAST('".$_POST['fechaini']."' AS DATE) AND CAST('".$_POST['fechafin']."' AS DATE)";}
					}
					switch(@ $_POST['tinforme'])
					{
						case "":	$crit1="";break;
						case "TR":	$crit1=" AND TB1.tipot='TR'";break;
						case "RA":	$crit1=" AND TB1.tipot='RA'";break;
					}
					switch(@ $_POST['testado'])
					{
						case "":	$crit2="";break;
						case "LN":	$crit2=" AND TB1.estado='LN'";break;
						case "LS":	$crit2=" AND TB1.estado='LS'";break;
						case "AN":	$crit2=" AND TB1.estado='AN'";break;
						case "AC":	$crit2=" AND TB1.estado='AC'";break;
						case "AR":	$crit2=" AND TB1.estado='AR'";break;
						case "CN":	$crit2=" AND TB1.estado='CN'";break;
						case "CC":	$crit2=" AND TB1.estado='CC'";break;
						case "AV":	$crit2=" AND (TB2.fechalimite <> '0000-00-00' AND (TB1.estado='AN' AND (TB2.fechalimite <= CURDATE())) OR ((TB1.estado='AC') AND (TB2.fechalimite <= TB1.fechares)))";
					}
					if(@ $_POST['nradicacion']!=""){$crit3=" AND TB2.codigobarras LIKE '%".$_POST['nradicacion']."%'";}
					else{$crit3="";}
					$sqlr="SELECT TB1.*,TB2.numeror,TB2.fechalimite,TB2.descripcionr,TB2.codigobarras,TB2.estado,TB2.estado2 FROM planacresponsables TB1, planacradicacion TB2 WHERE TB1.codradicacion=TB2.numeror AND TB1.tipot=TB2.tipot AND TB1.usuariocon='".$_SESSION['cedulausu']."' $crit1 $crit2 $crit3 $crit4";
					$resp=mysqli_query($linkbd,$sqlr);
					$_POST['numtop']=mysqli_num_rows($resp);
					$nuncilumnas=ceil($_POST['numtop']/$_POST['numres']);
					$cond2="";
					if (@ $_POST['numres']!="-1"){$cond2="LIMIT ".$_POST['numpos'].", ".$_POST['numres'];}
					$sqlr="SELECT TB1.*,TB2.numeror,TB2.fechalimite,TB2.descripcionr,TB2.codigobarras,TB2.estado,TB2.estado2 FROM planacresponsables TB1, planacradicacion TB2 WHERE TB1.codradicacion=TB2.numeror AND TB1.tipot=TB2.tipot AND TB1.usuariocon='".$_SESSION['cedulausu']."' $crit1 $crit2 $crit3 $crit4 ORDER BY TB1.codigo DESC $cond2";
					$res=mysqli_query($linkbd,$sqlr);
					$numcontrol=$_POST['nummul']+1;
					if(($nuncilumnas==$numcontrol)||(@ $_POST['numres']=="-1"))
					{
						$imagenforward="<img src='imagenes/forward02.png' style='width:17px;cursor:default;'>";
						$imagensforward="<img src='imagenes/skip_forward02.png' style='width:16px;cursor:default;' >";
					}
					else 
					{
						$imagenforward="<img src='imagenes/forward01.png' style='width:17px;cursor:pointer;' title='Siguiente' onClick='numsiguiente()'>";
						$imagensforward="<img src='imagenes/skip_forward01.png' style='width:16px;cursor:pointer;' title='Fin' onClick='saltocol(\"$nuncilumnas\")'>";
					}
					if((@ $_POST['numpos']==0)||(@ $_POST['numres']=="-1"))
					{
						$imagenback="<img src='imagenes/back02.png' style='width:17px;cursor:default;'>";
						$imagensback="<img src='imagenes/skip_back02.png' style='width:16px;cursor:default;'>";
					}
					else
					{
						$imagenback="<img src='imagenes/back01.png' style='width:17px;cursor:pointer;' title='Anterior' onClick='numanterior();'>";
						$imagensback="<img src='imagenes/skip_back01.png' style='width:16px;cursor:pointer;' title='Inicio' onClick='saltocol(\"1\")'>";
					}
					echo"
					<table class='inicio'>
				<tr>
					<td class='titulos' colspan='9'>:: Lista de Tareas Asignadas</td>
					<td class='submenu'>
							<select name='renumres' id='renumres' onChange='cambionum();' style='width:100%'>
								<option value='10'"; if (@ $_POST['renumres']=='10'){echo 'selected';} echo ">10</option>
								<option value='20'"; if (@ $_POST['renumres']=='20'){echo 'selected';} echo ">20</option>
								<option value='30'"; if (@ $_POST['renumres']=='30'){echo 'selected';} echo ">30</option>
								<option value='50'"; if (@ $_POST['renumres']=='50'){echo 'selected';} echo ">50</option>
								<option value='100'"; if (@ $_POST['renumres']=='100'){echo 'selected';} echo ">100</option>
								<option value='-1'"; if (@ $_POST['renumres']=='-1'){echo 'selected';} echo ">Todos</option>
							</select>
						</td>
				</tr>
				<tr><td colspan='10'>Tareas Encontrados: ".$_POST['numtop']."</td></tr>
				<tr>
					<td class='titulos2' rowspan='2' style='width:8%;'>C&oacute;digo</td>
					<td class='titulos2' rowspan='2' style='width:8%;'>Fecha Asignaci&oacute;n</td>
					<td class='titulos2' rowspan='2' style='width:8%;'>Fecha Limite</td>
					<td class='titulos2' rowspan='2' style='width:30%;'>Asignado Por</td>
					<td class='titulos2' rowspan='2' >Descripci&oacute;n</td>
					<td class='titulos2' rowspan='2' style='width:5%;'>Tipo</td>
					<td class='titulos2' rowspan='2' style='width:5%;'>Acci&oacute;n</td>
					<td class='titulos2' colspan='2' style='width:10%;text-align:center;'>Estado</td>
					<td class='titulos2' rowspan='2' style='width:5%;'>Concluida</td>
				</tr>
				<tr>
					<td class='titulos2' style='width:5%;'>Usuario</td>
					<td class='titulos2'>Tarea</td>
				</tr>";
					$iter='saludo1a';
					$iter2='saludo2';
					while ($row = mysqli_fetch_row($res)) 
					{
						$nresul=buscaresponsable($row[4]);
						if($row[10]=='1')
						{
							$paginar="onClick='location.href=\"plan-tareasresponder.php?idradicado=$row[1]&idresponsable=$row[0]&tipoe=$row[6]&tiporad=$row[10]\"'";
							$paginav="onClick='location.href=\"plan-tareasremirar.php?idradicado=$row[1]&idresponsable=$row[0]&tipoe=$row[6]&tiporad=$row[10]\"'";
							$paginam="onClick='location.href=\"plan-tareasremodificar.php?idradicado=$row[1]&idresponsable=$row[0]\"'";
						}
						else
						{
							$paginar="onClick='location.href=\"plan-actareasresponder.php?idradicado=$row[1]&idresponsable=$row[0]&tipoe=$row[6]&tiporad=$row[10]\"'";
							$paginav="onClick='location.href=\"plan-actareasmirar.php?idradicado=$row[1]&idresponsable=$row[0]&tipoe=$row[6]&tiporad=$row[10]\"'";
							$paginam="onClick='location.href=\"plan-actareasmodificar.php?idradicado=$row[1]&idresponsable=$row[0]\"'";
						};
						switch($row[20])
						{
							case "AC":	
										if($row[17]!="0000-00-00")
										{
											$imgcon="<img src='imagenes/confirm3.png' style='height:20px;' title='Concluida'>";
											$fecha01=explode('-',date('d-m-Y',strtotime($row[3])));
											$fecha01g=gregoriantojd($fecha01[1],$fecha01[0],$fecha01[2]);
											$fecha02=explode('-',date('d-m-Y',strtotime($row[17])));
											$fecha02g=gregoriantojd($fecha02[1],$fecha02[0],$fecha02[2]);
											if($fecha02g<=$fecha01g)
											{$imgtar="<img src='imagenes/sema_rojoON.jpg' style='height:20px;' title='Vencida'/>";}
											else {$imgtar="<img src='imagenes/sema_verdeON.jpg' style='height:20px;' title='Contestada'/>";}
											$feclim=date('d-m-Y',strtotime($row[17]));
										}
										else
										{
											$imgcon="<img src='imagenes/confirm3.png' style='height:20px;'>";
											$feclim="Sin Limite";
											$imgtar="<img src='imagenes/sema_verdeON.jpg' style='height:20px;' title='Contestada'/>";
										}
										break;
							case "AN":	if($row[17]!="0000-00-00")
										{
											$imgcon="<img src='imagenes/confirm3d.png' style='height:20px;' title='No Concluida'>";
											$fecha01=explode('-',date("d-m-Y"));
											$fecha01g=gregoriantojd($fecha01[1],$fecha01[0],$fecha01[2]);
											$fecha02=explode('-',date('d-m-Y',strtotime($row[17])));
											$fecha02g=gregoriantojd($fecha02[1],$fecha02[0],$fecha02[2]);
											if($fecha02g<=$fecha01g)
											{$imgtar="<img src='imagenes/sema_rojoON.jpg' style='height:20px;' title='Vencida'/>";}
											else {$imgtar="<img src='imagenes/sema_amarilloON.jpg' style='height:20px;' title='Pendiente'/>";}
											$feclim=date('d-m-Y',strtotime($row[17]));
										}
										else
										{
											$imgcon="<img src='imagenes/confirm3d.png' style='height:20px;'>";
											$feclim="Sin Limite";
											$imgtar="<img src='imagenes/sema_amarilloON.jpg' style='height:20px;' title='Pendiente'/>";
										}
										break;
							case "LS":	$imgcon="<img src='imagenes/confirm3.png' style='height:20px;'>";
										$feclim="Sin Limite";
										$imgtar="<img src='imagenes/sema_verdeON.jpg' style='height:20px;' title='Revisada'/>";
										break;
							case "LN":	$imgcon="<img src='imagenes/confirm3d.png' style='height:20px;'>";
										$feclim="Sin Limite";
										$imgtar="<img src='imagenes/sema_amarilloON.jpg' style='height:20px;' title='Sin Revisadar'/>";
										break;
						}
						switch($row[6])
						{
							case "LN":	$imgtip="<img src='imagenes/lectura.png' style='height:20px;' title='Informativa'/>";
										$icopreoce="<a $paginav><img src='imagenes/lupa02.png' style='width:21px;cursor:pointer;' title='Mirar'/></a>";
										$estadosol="<img src='imagenes/sema_amarilloON.jpg' style='height:22px;' title='Sin Revisar'/>";
										break;
							case "LS":	$imgtip="<img src='imagenes/lectura.png' style='height:20px;' title='Informativa'>";
										$icopreoce="<a $paginav><img src='imagenes/lupa02.png' style='width:21px;cursor:pointer;' title='Mirar'/></a>";
										$estadosol="<img src='imagenes/sema_verdeON.jpg' style='height:20px;' title='Revisada'>";
										break;
							case "AN":	$imgtip="<img src='imagenes/escritura.png' style='height:22px;' title='Tarea'/>";
										$estadosol="<img src='imagenes/sema_amarilloON.jpg' style='height:22px;' title='Sin Contestar'/>";
										$icopreoce="<a $paginar><img src='imagenes/b_edit.png' style='width:18px;cursor:pointer;' title='Contestar'/></a>";
										break;
							case "AC":	$imgtip="<img src='imagenes/escritura.png' style='height:20px;' title='Tarea'/>";
										$estadosol="<img src='imagenes/sema_verdeON.jpg' style='height:20px;' title='Contestada'/>";
										$icopreoce="<a $paginav><img src='imagenes/lupa02.png' style='width:21px;cursor:pointer;' title='Mirar'/></a>";
										break;
							case "AR":	$imgtip="<img src='imagenes/redirigido.png' style='height:22px;' title='Redirigida'/>";
										$estadosol="<img src='imagenes/sema_amarilloON.jpg' style='height:20px;' title='Contestada'/>";
										$icopreoce="<a $paginar><img src='imagenes/b_edit.png' style='width:18px;cursor:pointer;' title='Contestar'/></a>";
										break;
							case "CN":	$imgtip="<img src='imagenes/consulta01.png' style='height:22px;' title='Consuta'/>";
										$estadosol="<img src='imagenes/sema_amarilloON.jpg' style='height:20px;' title='Sin Contestar'/>";
										$icopreoce="<a $paginar><img src='imagenes/b_edit.png' style='width:18px;cursor:pointer;' title='Editar' /></a>";
										break;
							case "CS":	$imgtip="<img src='imagenes/consulta01.png' style='height:22px;' title='Consuta'/>";
										$estadosol="<img src='imagenes/sema_verdeON.jpg' style='height:20px;' title='Contestada'/>";
										$icopreoce="<a $paginav><img src='imagenes/lupa02.png' style='width:21px;cursor:pointer;' title='Mirar'/></a>";
										break;
						}
						if($row[21]==3)
						{
							$imgtar="<img src='imagenes/sema_amarilloOFF.jpg' title='Anulado' style='height:20px;'/>";
							$icopreoce="<a $paginav><img src='imagenes/lupa02.png' style='width:21px;cursor:pointer;' title='Mirar'/></a>";
						}
						echo "
						<tr class='$iter'>
							<td>$row[19]</td>
							<td>".date('d-m-Y',strtotime($row[2]))."</td>
							<td>$feclim</td>
							<td>$nresul</td>
							<td>$row[18]</td>
							<td style='text-align:center;'>$imgtip</td>
							<td style='text-align:center;'>$icopreoce</td>
							<td style='text-align:center;'>$estadosol</td>
							<td style='text-align:center;'>$imgtar</td>
							<td style='text-align:center;'>$imgcon</td>
						</tr>";
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
					}
					if (@ $_POST['numtop']==0)
				{
					echo "
					<table class='inicio'>
						<tr>
							<td class='saludo1' style='text-align:center;width:100%'><img src='imagenes\alert.png' style='width:25px'>No hay coincidencias en la b&uacute;squeda ".@ $tibusqueda."<img src='imagenes\alert.png' style='width:25px'></td>
						</tr>
					</table>";
				}
				echo"
						</table>
						<table class='inicio'>
							<tr>
								<td style='text-align:center;'>
									<a>$imagensback</a>&nbsp;
									<a>$imagenback</a>&nbsp;&nbsp;";
					if($nuncilumnas<=9){$numfin=$nuncilumnas;}
					else{$numfin=9;}
					for($xx = 1; $xx <= $numfin; $xx++)
					{
						if($numcontrol<=9){$numx=$xx;}
						else{$numx=$xx+($numcontrol-9);}
						if($numcontrol==$numx){echo"<a onClick='saltocol(\"$numx\")'; style='color:#24D915;cursor:pointer;'> $numx </a>";}
						else {echo"<a onClick='saltocol(\"$numx\")'; style='color:#000000;cursor:pointer;'> $numx </a>";}
					}
					echo"			&nbsp;&nbsp;<a href='#'>$imagenforward</a>
									&nbsp;<a href='#'>$imagensforward</a>
								</td>
							</tr>
						</table>";
				?>
			</div>
			<input type="hidden" name="numtop" id="numtop" value="<?php echo @ $_POST['numtop'];?>" />
			<input type="hidden" id="oculto" name="oculto" value="<?php echo @ $_POST['oculto']?>">
		</form>
	</body>
</html>