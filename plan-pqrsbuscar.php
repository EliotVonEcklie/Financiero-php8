<?php 
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script type="text/javascript" src="css/calendario.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("plan");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("plan");?></tr>
			<tr>
				<td colspan="3" class="cinta"><img src="imagenes/add2.png" class="mgbt1"/><img src="imagenes/guardad.png" class="mgbt1"/><img src="imagenes/busca.png" title="Buscar" onClick="document.form2.submit();" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" onClick="mypop=window.open('plan-principal.php','','');mypop.focus();" class="mgbt"></td>
			</tr>
		</table>
		<form name="form2" method="post" action="">
			<table class="inicio">
				<tr >
					<td height="25"colspan="9" class="titulos" >:.Buscar PQRS</td>
					<td class="cerrar" style="width:7%" onClick="location.href='plan-principal.php'">&nbsp;Cerrar</td>
				</tr>
				<tr><td colspan="10" class="titulos2" >:&middot; Por Descripci&oacute;n </td></tr>
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
				</tr>
				<tr>
					<td class="tamano01" style="width:3cm">:&middot; Tipo PQR:</td>
					<td class="tamano02" style="width:12%">
						<select name="tipopqr" id="tipopqr" class="tamano02" style="width:100%">
							<option onChange="" value="" >Seleccione....</option>
							<option value="P" <?php if($_POST[tipopqr]=="P"){echo "SELECTED ";}?>>P - Petici&oacute;n</option>
							<option value="Q" <?php if($_POST[tipopqr]=="Q"){echo "SELECTED ";}?>>Q - Queja</option>
							<option value="R" <?php if($_POST[tipopqr]=="R"){echo "SELECTED ";}?>>R - Reclamo</option>
							<option value="S" <?php if($_POST[tipopqr]=="S"){echo "SELECTED ";}?>>S - Sugerencia</option>
							<option value="D" <?php if($_POST[tipopqr]=="D"){echo "SELECTED ";}?>>D - Denuncia</option>
							<option value="F" <?php if($_POST[tipopqr]=="F"){echo "SELECTED ";}?>>F - Felicitaci&oacute;n</option>
						</select>
					</td>
					<td class="tamano01" style="width:3.5cm">:&middot;Medio Recepción:</td>
					<td style="width:14%">
						<select name="mdrece" id="mdrece" class="tamano02">
							<option onChange="" value="" >Seleccione....</option>
							<option value="O" <?php if($_POST[mdrece]=="O"){echo "SELECTED ";}?>>O - Oficio</option>
							<option value="F" <?php if($_POST[mdrece]=="F"){echo "SELECTED ";}?>>F - Formato PQRSDF</option>
							<option value="E" <?php if($_POST[mdrece]=="E"){echo "SELECTED ";}?>>E - Correo Electrónico</option>
							<option value="P" <?php if($_POST[mdrece]=="P"){echo "SELECTED ";}?>>P - Pagina WEB</option>
						</select>
					</td>
					<td class="tamano01" style="width:2.5cm;">Fecha Inicial:</td>
					<td style="width:10%;"><input name="fecha"  type="text" value="<?php echo $_POST[fecha]?>" maxlength="10"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" style="width:75%;height:30px;" title="DD/MM/YYYY"/>&nbsp;<img src="imagenes/calendario04.png" onClick="displayCalendarFor('fc_1198971545');" title="Calendario" class="icobut"/></td>
					<td class="tamano01" style="width:2.5cm;">Fecha Final:</td>
					<td style="width:10%;"><input name="fecha2" type="text" value="<?php echo $_POST[fecha2]?>" maxlength="10"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971546" onKeyDown="mascara(this,'/',patron,true)" style="width:75%;height:30px;" title="DD/MM/YYYY"/>&nbsp;<img src="imagenes/calendario04.png" onClick="displayCalendarFor('fc_1198971546');" title="Calendario" class="icobut"/></td>
					<td style="padding-bottom:5px"><em class="botonflecha" onClick="document.form2.submit();">Buscar</em></td>
				</tr>
			</table>
			
			<input type="hidden" name="oculto" id="oculto" value="1">
			<div class="subpantallap" style="height:65%; width:99.6%; overflow-x:hidden;" id="divdet">
				<?php 
					$crit1="";
					if ($_POST[tipopqr]!=''){$crit1="AND T2.clasificacion='$_POST[tipopqr]'";}
					else{$crit1='';}
					if ($_POST[mdrece]!=''){$crit2="WHERE T1.mrecepcion='$_POST[mdrece]'";}
					else{$crit2="";}
					if ($_POST[fecha]!='')
					{
						$fech1=split("/",$_POST[fecha]);
						$fech2=split("/",$_POST[fecha2]);
						$f1=$fech1[2]."-".$fech1[1]."-".$fech1[0];
						$f2=$fech2[2]."-".$fech2[1]."-".$fech2[0];
						if($crit2!=''){$crit3="AND T1.fechar between '$f1' AND '$f2'";}
						else {$crit3="WHERE T1.fechar between '$f1' AND '$f2'";}
					}
					if($_POST[dependencias]!="")
					{
						$cond2="AND EXISTS(SELECT TB3.estado FROM planacresponsables TB3, planaccargos TB4 WHERE T1.numeror=TB3.codradicacion AND TB4.codcargo=TB3.codcargo AND TB4.dependencia='$_POST[dependencias]' AND TB3.codigo=(SELECT MAX(TB5.codigo) FROM planacresponsables TB5 WHERE TB3.codradicacion=TB5.codradicacion))";
					}
					else {$cond2='';}
					$sqlr="SELECT T1.fechar,T2.clasificacion,T1.mrecepcion,T1.numeror,T1.idtercero,T1.descripcionr FROM planacradicacion AS T1 INNER JOIN plantiporadicacion AS T2 ON T2.codigo=T1.tipor AND T2.clasificacion <> 'N' $cond2 $crit1 $crit2 $crit3 ORDER BY T1.numeror";
					$resp=mysql_query($sqlr,$linkbd);
					$_POST[numtop]=mysql_num_rows($resp);
					$conta=1;
					echo"
						<table class='inicio'>
						<tr><td class='titulos' colspan='20'>:: Lista de PQRS</td></tr>
						<tr><td colspan='20'>Encontrados: $_POST[numtop]</td></tr>
						<tr style='text-align:center'>
							<td class='titulos2' rowspan='2' style='width:2.5%'>No</td>
							<td class='titulos2' colspan='6'>clasificaci&oacuten</td>
							<td class='titulos2' colspan='4'>M. Recepci&oacuten</td>
							<td class='titulos2' colspan='5' >Tramite</td>
							<td class='titulos2' colspan='4' >Respuesta</td>
						</tr>
						<tr style='text-align:center'>
							<td class='titulos2' style='width:1.2%' title='Petici&oacute'>P</td>
							<td class='titulos2' style='width:1.2%' title='Queja'>Q</td>
							<td class='titulos2' style='width:1.2%' title='Reclamo'>R</td>
							<td class='titulos2' style='width:1.2%' title='Sugerencia'>S</td>
							<td class='titulos2' style='width:1.2%' title='Denuncia'>D</td>
							<td class='titulos2' style='width:1.2%' title='Felicitaci&oacuten'>F</td>
							<td class='titulos2' style='width:1.2%' title='Oficio'>O</td>
							<td class='titulos2' style='width:1.2%' title='Formato PQRS'>F</td>
							<td class='titulos2' style='width:1.2%' title='Correo Electr&oacute;nico'>E</td>
							<td class='titulos2' style='width:1.2%' title='Pagina WEB'>P</td>
							<td class='titulos2' style='width:3.7%' title='N&uacute;mero Radicaci&oacute;n'>No Rad</td>
							<td class='titulos2' style='width:5.3%' title='Fecha Radicaci&oacute;n'>Fecha Rad</td>
							<td class='titulos2' style='width:6%' title='Documento Solicitante'>Documento</td>
							<td class='titulos2' style='width:15%' title='Nombre Solicitante'>Nombre</td>
							<td class='titulos2' style='width:15%'>Asunto</td>
							<td class='titulos2' style='width:10%' title='Cargo Responsable'>Cargo</td>
							<td class='titulos2' title='Tratamiento Interno'>Tratamiento</td>
							<td class='titulos2' style='width:15%'>Respuesta</td>
							<td class='titulos2' style='width:5%' title='Fecha Respuesta'>Fecha</td>
						</tr>";
					$iter='saludo1b';
					$iter2='saludo2b';
					while ($row = mysql_fetch_row($resp)) 
					{
						$nproceso=$docres=$respuesta=$fechares='';
						$fecha=date('d-m-Y',strtotime($row[0]));
						switch ($row[1])
						{
							case "P":	$calsifi="
										<td title='Petici&oacute;' style='text-align:center'>X</td>
										<td title='Queja' style='text-align:center'>-</td>
										<td title='Reclamo' style='text-align:center'>-</td>
										<td title='Sugerencia' style='text-align:center'>-</td>
										<td title='Denuncia' style='text-align:center'>-</td>
										<td title='Felicitaci&oacute;n' style='text-align:center'>-</td>";
										break;
							case "Q":	$calsifi="
										<td title='Petici&oacute;' style='text-align:center'>-</td>
										<td title='Queja' style='text-align:center'>X</td>
										<td title='Reclamo' style='text-align:center'>-</td>
										<td title='Sugerencia' style='text-align:center'>-</td>
										<td title='Denuncia' style='text-align:center'>-</td>
										<td title='Felicitaci&oacute;n' style='text-align:center'>-</td>";
										break;
							case "R":	$calsifi="
										<td title='Petici&oacute;' style='text-align:center'>-</td>
										<td title='Queja' style='text-align:center'>-</td>
										<td title='Reclamo' style='text-align:center'>X</td>
										<td title='Sugerencia' style='text-align:center'>-</td>
										<td title='Denuncia' style='text-align:center'>-</td>
										<td title='Felicitaci&oacute;n' style='text-align:center'>-</td>";
										break;
							case "S":	$calsifi="
										<td title='Petici&oacute;' style='text-align:center'>-</td>
										<td title='Queja' style='text-align:center'>-</td>
										<td title='Reclamo' style='text-align:center'>-</td>
										<td title='Sugerencia' style='text-align:center'>X</td>
										<td title='Denuncia' style='text-align:center'>-</td>
										<td title='Felicitaci&oacute;n' style='text-align:center'>-</td>";
										break;
							case "D":	$calsifi="
										<td title='Petici&oacute;' style='text-align:center'>-</td>
										<td title='Queja' style='text-align:center'>-</td>
										<td title='Reclamo' style='text-align:center'>-</td>
										<td title='Sugerencia' style='text-align:center'>-</td>
										<td title='Denuncia' style='text-align:center'>X</td>
										<td title='Felicitaci&oacute;n' style='text-align:center'>-</td>";
										break;
							case "F":	$calsifi="
										<td title='Petici&oacute;' style='text-align:center'>-</td>
										<td title='Queja' style='text-align:center'>-</td>
										<td title='Reclamo' style='text-align:center'>-</td>
										<td title='Sugerencia' style='text-align:center'>-</td>
										<td title='Denuncia' style='text-align:center'>-</td>
										<td title='Felicitaci&oacute;n' style='text-align:center'>X</td>";
						}
						switch ($row[2])
						{
							case "O":	$mrecep="
										<td title='Oficio' style='text-align:center'>X</td>
										<td title='Formato PQRS' style='text-align:center'>-</td>
										<td title='Correo Electr&oacute;nico' style='text-align:center'>-</td>
										<td title='Pagina WEB' style='text-align:center'>-</td>";
										break;
							case "F":	$mrecep="
										<td title='Oficio' style='text-align:center'>-</td>
										<td title='Formato PQRS' style='text-align:center'>X</td>
										<td title='Correo Electr&oacute;nico' style='text-align:center'>-</td>
										<td title='Pagina WEB' style='text-align:center'>-</td>";
										break;
							case "E":	$mrecep="
										<td title='Oficio' style='text-align:center'>-</td>
										<td title='Formato PQRS' style='text-align:center'>-</td>
										<td title='Correo Electr&oacute;nico' style='text-align:center'>X</td>
										<td title='Pagina WEB' style='text-align:center'>-</td>";
										break;
							case "P":	$mrecep="
										<td title='Oficio' style='text-align:center'>-</td>
										<td title='Formato PQRS' style='text-align:center'>-</td>
										<td title='Correo Electr&oacute;nico' style='text-align:center'>-</td>
										<td title='Pagina WEB' style='text-align:center'>X</td>";
						}
						$numradi=substr($row[3],4);
						if($row[4]!='')
						{
							$nomsoli=buscatercero($row[4]);
							$nundocu=number_format($row[4],0,'','.');
						}
						else
						{
							$sqlter="SELECT nombre FROM planradicacionsindoc WHERE numeror='$row[3]'";
							$rester=mysql_query($sqlter,$linkbd);
							$rowter = mysql_fetch_row($rester);
							$nomsoli=$rowter[0];
							$nundocu="Sin Documento";
						}
						$descrip=iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$row[5]);
						$sql="SELECT estado,fechares,usuariocon,respuesta,proceso FROM planacresponsables WHERE codradicacion='$row[3]' AND fechares <> '' ORDER BY fechares DESC";
						$res=mysql_query($sql,$linkbd);
						$numres=mysql_num_rows($res);
						$connumres=1;
						if($numres==1)
						{
							$rows = mysql_fetch_row($res);
							$docres=$rows[2];
							$respuesta=iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$rows[3]);
							$nproceso=iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$rows[4]);
							if($respuesta!=''){$fechares=date('d-m-Y',strtotime($rows[1]));}
							else {$fechares="00-00-0000";}
						}
						else
						{
							while ($rows = mysql_fetch_row($res))
							{
								if(($rows[0]=='AN') || ($rows[0]=='AC') || ($rows[0]=='AR') || ($rows[0]=='CS') || ($rows[0]=='CN'))
								{
									$rows = mysql_fetch_row($res);
									$docres=$rows[2];
									$respuesta=iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$rows[3]);
									if($respuesta!=''){$fechares=date('d-m-Y',strtotime($rows[1]));}
									else {$fechares="00-00-0000";}
								}
								$connumres++;
								if(($docres=='') && ($connumres==$numres))
								{
									$docres=$rows[2];
									$respuesta=iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$rows[3]);
									if($respuesta!=''){$fechares=date('d-m-Y',strtotime($rows[1]));}
									else {$fechares="00-00-0000";}
								}
							}
						}
						$sqlr1="SELECT T1.nombrecargo FROM planaccargos AS T1 INNER JOIN planestructura_terceros AS T2 ON T2.codcargo=T1.codcargo AND T2.cedulanit = '$docres'";
						$resp1=mysql_query($sqlr1,$linkbd);
						$row1 = mysql_fetch_row($resp1);
						echo"<tr class='$iter'>
							<td>$conta</td>
							$calsifi
							$mrecep
							<td style='text-align:right;'>$numradi&nbsp;</td>
							<td style='text-align:center'>$fecha</td>
							<td style='text-align:right;'>$nundocu</td>
							<td>$nomsoli</td>
							<td>$descrip</td>
							<td>$row1[0]</td>
							<td>$nproceso</td>
							<td>".str_replace("&lt;br/&gt;"," ",$respuesta)."</td>
							<td style='text-align:center'>$fechares</td>
						</tr>";
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
						$conta++;
					}
					echo"</table>";
				?>
			</div>
		</form>
	</body>
</html>