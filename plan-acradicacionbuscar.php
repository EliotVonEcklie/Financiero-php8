<?php
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=iso-8859-1");
	require"comun.inc";
	require"funciones.inc";
	sesion();
	$linkbd=conectar_bd();
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>::SPID-Planeaci&oacute;n Estrat&eacute;gica</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css4.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type='text/javascript' src='JQuery/jquery-2.1.4.min.js?<?php echo date('d_m_Y_h_i_s');?>'></script>
		<script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<style>
			input[type='text']{height:30px;}
			input[type='search']{height:30px;}
			select{height:30px;}
		</style>
		<script>
			function pdf()
			{
				document.form2.action="plan-pdfradicaciones.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function excell()
			{
				document.form2.action="plan-acradicacionexcel.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function anularrad(nid,codbar)
			{
				document.getElementById('idanul').value=nid;
				despliegamodalm('visible','4','Esta Seguro de Anular la Radicación N°: '+codbar,'1');
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
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.getElementById('oculto').value="3";
								document.form2.submit();break;
				}
			}
			function busquedaini()
			{
				document.getElementById('oculto').value="10";
				document.form2.submit();
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
				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='plan-acradicacion.php'" class="mgbt"/><img src="imagenes/guardad.png" class="mgbt1"/><img src="imagenes/busca.png" title="Buscar" class="mgbt" onClick="document.form2.submit();"/><img src="imagenes/nv.png" title="Nueva Ventana" class="mgbt" onClick="<?php echo paginasnuevas("plan");?>"/><img src="imagenes/print.png" title="Imprimir" class="mgbt" onClick="pdf();"/><img src="imagenes/excel.png" title="Excel" onClick="excell()" class="mgbt"/></td>
			</tr>
		</table>
		<div id="bgventanamodalm" class="bgventanamodalm">
			<div id="ventanamodalm" class="ventanamodalm">
				<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"></IFRAME>
			</div>
		</div>
		<form name="form2" method="post" action="">
			<div class="loading" id="divcarga"><span>Cargando...</span></div>
			<?php
				if($_POST[oculto]=="")
				{
					echo"<script>document.getElementById('divcarga').style.display='none';</script>";
				}
			?>
			<table class="inicio">
				<tr>
					<td style="height:25;" colspan="8" class="titulos" >:.Buscar Documento Radicado</td>
					<td class="cerrar" style="width:7%" onClick="location.href='plan-principal.php'">&nbsp;Cerrar</td>
				</tr>
				<tr><td colspan="9" class="titulos2">:&middot; Por Descripci&oacute;n</td></tr>
				<tr>
					<td class="tamano01" style="width:2.5cm">Dependencia:</td>
					<td colspan="3">
						<select name="dependencias" id="dependencias" onKeyUp="return tabular(event,this)" style="width:100%;text-transform:uppercase" class="tamano02">
							<option value="" <?php if($_POST[dependencias]=='') {echo "SELECTED";$_POST[nomdep]="";}?>>- Todas</option>
							<?php
								$sqlr="SELECT * FROM planacareas WHERE estado='S'";
								$resp = mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($resp)) 
								{
									if("$row[0]"==$_POST[dependencias])
									{
										echo "<option value='$row[0]' SELECTED>- $row[1]</option>";
										$_POST[nomdep]="Dependencia: $row[1]";
									}
									else {echo "<option value='$row[0]'>- $row[1]</option>";}	  
								}
							?>
						</select>
					</td>
					<td class="tamano01" style="width:2.5cm">Clase Proceso:</td>
					<td>
						<select name="proceso" id="proceso" onKeyUp="return tabular(event,this)" style="width:100%;" class="tamano02">
							<option value="" <?php if($_POST[proceso]=='') {echo "SELECTED";$_POST[nompro]="";}?>>....</option>
							<option value="AN" <?php if($_POST[proceso]=='AN') {echo "SELECTED";$_POST[nompro]="Pendientes";}?>>Pendientes</option>
							<option value="AC" <?php if($_POST[proceso]=='AC') {echo "SELECTED";$_POST[nompro]="Contestados";}?>>Contestados</option>
							<option value="AV" <?php if($_POST[proceso]=='AV') {echo "SELECTED";$_POST[nompro]="Vencidos";}?>>Vencidos</option>
							<option value="LN" <?php if($_POST[proceso]=='LN') {echo "SELECTED";$_POST[nompro]="Solo Lectura";}?>>Solo Lectura</option>
							<option value="DL" <?php if($_POST[proceso]=='DL') {echo "SELECTED";$_POST[nompro]="Anulados";}?>>Anulados</option>
						</select>
					</td>
					<td class="tamano01" style="width:4cm">:&middot; N° Rad. o Documento:</td>
					<td><input type="search" name="numero" id="numero" value="<?php echo $_POST[numero]?>" class="tamano02"/></td>
				</tr>
				<tr>
					<td class="tamano01">Tercero:</td>
					<td colspan="3"><input type="search" name="ntercero" id="ntercero" value="<?php echo $_POST[ntercero]?>" style=" width:100%" class="tamano02"/></td>
					<td class="tamano01">Tipo Rad.:</td>
					<td colspan="3">
						<select name="tradicacion" id="tradicacion" style="width:100%;text-transform:uppercase;" onKeyUp="return tabular(event,this)" class="tamano02">
							<option onChange="" value="" >Seleccione....</option>
							<?php
								$sqlr="SELECT * FROM plantiporadicacion WHERE estado='S' AND radotar='RA' ORDER BY nombre ASC  ";
								$resp=mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($resp)) 
								{
									if($_POST[tradicacion]=="$row[0]")
									{
										echo "<option value='$row[0]' SELECTED>:- $row[1]</option>";
										$_POST[nomtiporadica]=$row[1];
									}
									else {echo "<option value='$row[0]'>:- $row[1]</option>";} 	 
								}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td class="tamano01" style="height:31px">Fecha Inicial:</td>
					<td><input type="date" id="fechaini" name="fechaini" value="<?php echo $_POST[fechaini] ?>" class="tamano02"/></td>
					<td class="tamano01">Fecha Final:</td>
					<td><input type="date" id="fechafin" name="fechafin" value="<?php echo $_POST[fechafin] ?>" class="tamano02"/></td>
					<td style="padding-bottom:0px"><em class="botonflecha" onClick="busquedaini();">Buscar</em></td>
					<td></td>
				</tr>
			</table>
			<input type="hidden" name="oculto" id="oculto" />
			<input type="hidden" name="nomdep" id="nomdep" value="<?php echo $_POST[nomdep];?>"/>
			<input type="hidden" name="idanul" id="idanul" value="<?php echo $_POST[idanul];?>"/>
			<input type="hidden" name="nompro" id="nompro" value="<?php echo $_POST[nompro];?>"/>
			<input type="hidden" name="nomtiporadica" id="nomtiporadica" value="<?php echo $_POST[nomtiporadica];?>"/>
			<div class="subpantallac5" style="height:53.5%; width:99.5%; overflow-x:hidden">
				<?php
					ini_set('max_execution_time', 7200);
					$c=0;
					$cond1="";
					$cond2="";
					$cond3="";
					$cond4="";
					$cond5="";
					if ($_POST[oculto]=="3")
					{
						$sqlr="UPDATE planacradicacion SET estado2='3' WHERE numeror='$_POST[idanul]'";
						if(!mysql_query($sqlr,$linkbd))
						{
							$e =mysql_error(mysql_query($sqlr,$linkbd));
							echo"<script>despliegamodalm('visible','2','No se pudo ejecutar la petición: $e');</script>";
						}
						else {echo "<script>despliegamodalm('visible','3','Se Anulo la Radicación con Exito');</script>";}
						
					}
					if ($_POST[fechaini]!="" xor $_POST[fechafin]!="")
					{
						if($_POST[fechaini]==""){echo "<script>despliegamodalm('visible','2','Se deben ingresar la fecha inicial ')</script>";}
						else {echo "<script>despliegamodalm('visible','2','Se deben ingresar la fecha final ')</script>";}
					}
					elseif ($_POST[fechaini]!="" && $_POST[fechafin]!="")
					{
						$fecini=explode("-",date('d-m-Y',strtotime($_POST[fechaini])));
						$fecfin=explode("-",date('d-m-Y',strtotime($_POST[fechafin])));
						if(gregoriantojd($fecfin[1],$fecfin[0],$fecfin[2])< gregoriantojd($fecini[1],$fecini[0],$fecini[2]))
						{echo "<script>despliegamodalm('visible','2','La fecha inicial no debe ser mayor a la fecha final')</script>";}
						else
						{$cond3=" AND TB1.fechar BETWEEN CAST('$_POST[fechaini]' AS DATE) AND CAST('$_POST[fechafin]' AS DATE)";}
					}
					if($_POST[dependencias]!="")
					{
						//$cond2="AND EXISTS(SELECT TB2.estado FROM planacresponsables TB2, planaccargos TB3 WHERE TB1.numeror=TB2.codradicacion AND TB3.codcargo=TB2.codcargo AND TB3.dependencia='$_POST[dependencias]' AND TB2.codigo=(SELECT MAX(TB4.codigo) FROM planacresponsables TB4 WHERE TB2.codradicacion=TB4.codradicacion AND TB4.estado IN('AR','AC','AN')))";
						$cond2="AND EXISTS(SELECT TB2.estado FROM planacresponsables TB2, planaccargos TB3 WHERE TB1.numeror=TB2.codradicacion AND TB3.codcargo=TB2.codcargo AND TB3.dependencia='$_POST[dependencias]' AND TB2.codigo=(SELECT MAX(TB4.codigo) FROM planacresponsables TB4 WHERE TB2.codradicacion=TB4.codradicacion))";
					}
					if($_POST[numero]!="") {$cond1="AND concat_ws(' ', TB1.codigobarras,TB1.idtercero) LIKE '%$_POST[numero]%'";}
					if($_POST[ntercero]!=""){$cond4="AND EXISTS(SELECT TB4.estado FROM terceros TB4 WHERE TB1.idtercero=TB4.cedulanit AND concat_ws(' ', TB4.nombre1,TB4.nombre2,TB4.apellido1,TB4.apellido2,TB4.razonsocial,TB4.cedulanit) LIKE '%$_POST[ntercero]%')";}
					if($_POST[tradicacion]!=""){$cond5="AND tipor='$_POST[tradicacion]'";}
					switch ($_POST[proceso])
					{
						case '':	
							$presqlr="SELECT TB1.* FROM planacradicacion TB1 WHERE TB1.tipot='RA' $cond2 $cond1 $cond3 $cond4 $cond5 ORDER BY TB1.numeror DESC";break;
						case 'LN':
						case 'LS':	
							$presqlr="SELECT TB1.* FROM planacradicacion TB1 WHERE TB1.tipot='RA' AND (TB1.estado='LS' OR TB1.estado='LN') $cond2 $cond1 $cond3 $cond4 $cond5 ORDER BY TB1.numeror DESC";break;
						case 'AC':
						case 'AN':	
							$presqlr="SELECT TB1.* FROM planacradicacion TB1 WHERE TB1.tipot='RA' AND TB1.estado='$_POST[proceso]' $cond2 $cond1 $cond3 $cond4 $cond5 ORDER BY TB1.numeror DESC";break;
						case 'AV':	
							$presqlr="SELECT TB1.* FROM planacradicacion TB1  WHERE TB1.tipot='RA' AND TB1.fechalimite <> '0000-00-00'  AND EXISTS (SELECT TB2.codigo FROM planacresponsables TB2 WHERE TB2.codradicacion=TB1.numeror AND ((TB2.fechares > TB1.fechalimite AND TB1.estado='AC') OR (TB1.estado='AN' AND TB1.fechalimite <= CURDATE()))) $cond2 $cond1 $cond3 $cond4 $cond5  ORDER BY TB1.numeror DESC";break;
						case 'DL': 
							$presqlr="SELECT TB1.* FROM planacradicacion TB1 WHERE TB1.tipot='RA' AND TB1.estado2='3' $cond2 $cond1 $cond3 $cond4 $cond5 ORDER BY TB1.numeror DESC";break;
					}
					if ($_POST[oculto]=="3" || $_POST[oculto]=="10")
					{
					$sqlr="$presqlr";
					$res=mysql_query($sqlr,$linkbd);
					$_POST[numtop]=mysql_num_rows($res);
					$numcontrol=1;
					echo"
					<table class='inicio'>
						<tr><td class='titulos' colspan='13'>:: Lista de Documentos Radicados $_POST[nomdep]</td></tr>
						<tr><td colspan='13'>Encontrados: $_POST[numtop]</td></tr>
						<tr class='titulos2'>
							<td class='titulos2'><img src='imagenes/plus.gif'></td>
							<td>N&ordm;</td>
							<td style='width:6%;'>Radicaci&oacute;n</td>
							<td style='width:8%;'>Fecha Radicado</td>
							<td style='width:9%;'>Fecha Vencimiento</td>
							<td style='width:8%;'>Fecha Respuesta</td>
							<td style='width:30%;'>Tercero</td>
							<td>Descripci&oacute;n</td>
							<td style='width:5%;'>Mirar</td>
							<td style='width:5%;'>Editar</td>
							<td style='width:5%;'>Anular</td>
							<td style='width:5%;'>Estado</td>
							<td style='width:5%;'>Concluida</td>
						 </tr>";
					$iter='saludo1a';
					$iter2='saludo2';
					$con=1;
					while ($row = mysql_fetch_row($res))
					{
						if($row[7]!=''){$tercero=buscatercero($row[7]);}
						else
						{
							$sqlter="SELECT nombre FROM planradicacionsindoc WHERE numeror='$row[1]'";
							$rester=mysql_query($sqlter,$linkbd);
							$rowter = mysql_fetch_row($rester);
							$tercero=$rowter[0];
						}
						$fechar=date("d-m-Y",strtotime($row[2]));
						$fechav=date("d-m-Y",strtotime($row[6]));
						$fechactual=date("d-m-Y");
						$tmp = explode('-',$fechav);
						$fcpv=gregoriantojd($tmp[1],$tmp[0],$tmp[2]);
						$tmp = explode('-',$fechactual);
						$fcpa=gregoriantojd($tmp[1],$tmp[0],$tmp[2]); 
						switch($row[20])
						{
							case "AC":
								if($row[6]!="0000-00-00")
								{
									$sqlac="SELECT fechares FROM planacresponsables WHERE estado='AC' AND codradicacion='$row[0]'";
									$rowac=mysql_fetch_row(mysql_query($sqlac,$linkbd));
									$fechares=explode("-",date('d-m-Y',strtotime($rowac[0])));
									if($fcpv <= gregoriantojd($fechares[1],$fechares[0],$fechares[2]))
									{$imgsem="src='imagenes/sema_rojoON.jpg' title='Vencida'";$estrad="RO";$vextra='Vencida';}
									else {$imgsem="src='imagenes/sema_verdeON.jpg' title='Contestada'";$estrad="VE";$vextra='Contestada';}
									$imgcon="src='imagenes/confirm3.png' title='Concluida'";
									$vimgcon='Concluida';
									$mfechares=date('d-m-Y',strtotime($rowac[0]));
								}
								else
								{
									$imgcon="src='imagenes/confirm3.png' title='Concluida'";
									$vimgcon='Concluida';
									$imgsem="src='imagenes/sema_verdeON.jpg' title='Contestada'";
									$vextra='Contestada';
									$estrad="VE";
									$mfechares=date('d-m-Y',strtotime($rowac[0]));
									$fechav="Sin Limite";
								}
								break;
							case "LS":
								$imgsem="src='imagenes/sema_verdeON.jpg' title='Revisados'";
								$vextra='Revisados';
								$estrad="VE";
								$imgcon="src='imagenes/confirm3.png' title='Concluida'";
								$vimgcon='Concluida';
								$mfechares="Solo Lectura";
								$fechav="Sin Limite";
								break;
							case "LN":
								$imgsem="src='imagenes/sema_amarilloON.jpg' title='Pendientes'";
								$vextra='Pendientes';
								$estrad="AM";
								$imgcon="src='imagenes/confirm3d.png' title='No Concluida'";
								$vimgcon='No Concluida';
								$mfechares="Solo Lectura";
								$fechav="Sin Limite";
								break;
							case "AN": 
								if($row[6]!="0000-00-00")
								{
									if ($fcpv <= $fcpa)
									{
										$imgsem="src='imagenes/sema_rojoON.jpg' title='Vencida'";
										$estrad="RO";
										$vextra='Vencida';
									}
									else 
									{
										$imgsem="src='imagenes/sema_amarilloON.jpg' title='Sin Responder'";
										$estrad="AM";
										$vextra='Sin Responder';
									}
									
								}
								else
								{
									$imgsem="src='imagenes/sema_amarilloON.jpg' title='Sin Responder'";
									$vextra='Sin Responder';
									$estrad="AM";
									$fechav="Sin Limite";
								}
								$imgcon="src='imagenes/confirm3d.png' title='No Concluida'";
								$vimgcon='No Concluida';
								$mfechares="00-00-000";
								break;
						}	
						switch($row[22])
						{
							case 3:		$imgsem="src='imagenes/sema_amarilloOFF.jpg' title='Anulado'";
										$vextra='Anulado';
										$estrad="OF";
										$imgedi="<img src='imagenes/b_editd.png' style='width:18px' title='Editar'>";
										$imganu="<img src='imagenes/anulard.png' style='width:22px' title='Anular'>";
										break;
							case 2:		$imgedi="<img src='imagenes/b_editd.png' style='width:18px' title='Editar'>";
										$imganu="<a onClick=\"anularrad('$row[0]','$row[1]');\" style='cursor:pointer;'><img src='imagenes/anular.png' style='width:22px' title='Anular'></a>";
										break;
							
							default:	$imgedi="<a onClick=\"location.href='plan-acradicacionmodificar.php?id=$row[0]'\" style='cursor:pointer;'><img src='imagenes/b_edit.png' style='width:18px' title='Editar'></a>";
										$imganu="<a onClick=\"anularrad('$row[0]','$row[1]');\" style='cursor:pointer;'><img src='imagenes/anular.png' style='width:22px' title='Anular'></a>";
										break;
						}
						$imgver="<a onClick=\"location.href='plan-acradicacionmirar.php?id=$row[0]&esra=$estrad'\" style='cursor:pointer;'><img src='imagenes/lupa02.png' style='width:22px' title='Mirar'></a>";
						if($row[0] == $_GET[nradicado]  && $row[0] != null)
						{
							echo 
							"<tr class='' style='background-color: yellow;' onDblClick=\"location.href='plan-acradicacionmirar.php?id=$row[0]&esra=$estrad'\">";
						}
						else
						{
							echo 
							"<tr class='$iter' onDblClick=\"location.href='plan-acradicacionmirar.php?id=$row[0]&esra=$estrad'\">";
						}
						echo "
						<input type='hidden' name='vradica[]' value='$row[1]'/>
						<input type='hidden' name='vfecharad[]' value='$fechar'/>
						<input type='hidden' name='vfechaven[]' value='$fechav'/>
						<input type='hidden' name='vfechares[]' value='$mfechares'/>
						<input type='hidden' name='vtercero[]' value='$tercero'/>
						<input type='hidden' name='vdescrip[]' value='$row[8]'/>
						<input type='hidden' name='vestado[]' value='$vextra'/>
						<input type='hidden' name='vconclu[]' value='$vimgcon'/>
							<td class='titulos2'>
								<a onClick='detallesdocradi($con, $row[0])' style='cursor:pointer;'>
									<img id='img$con' src='imagenes/plus.gif'>
								</a>
							</td>
							<td>$con</td>
							<td>$row[1]</td>
							<td>$fechar</td>
							<td>$fechav</td>
							<td>$mfechares</td>
							<td>$tercero</td>
							<td>$row[8]</td>
							<td style='text-align:center;'>$imgver</td>
							<td style='text-align:center;'>$imgedi</td>
							<td style='text-align:center;'>$imganu</td>
							<td style='text-align:center;'><img $imgsem style='width:20px'/></td>
							<td style='text-align:center;'><img $imgcon style='width:20px'/></td>
						</tr>
						<tr>
							<td align='center'></td>
							<td colspan='11'>
								<div id='detalle$con' style='display:none'></div>
							</td>
						</tr>";
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
						$con++;
					}
					if ($_POST[numtop]==0)
					{
						echo "
						<table class='inicio'>
							<tr>
								<td class='saludo1' style='text-align:center;width:100%'><img src='imagenes\alert.png' style='width:25px'>No hay coincidencias en la b&uacute;squeda $tibusqueda<img src='imagenes\alert.png' style='width:25px'></td>
							</tr>
						</table>";
					}
					echo"</table>
					<script>document.getElementById('divcarga').style.display='none';</script>";
						
					}
				?>
			</div>
			<input type="hidden" name="numtop" id="numtop" value="<?php echo $_POST[numtop];?>" />
		</form>
	</body>
</html>