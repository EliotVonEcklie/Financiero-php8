<?php
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=iso-8859-1");
	require"comun.inc";
	require"funciones.inc";
	session_start();
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
		<title>:: SPID - Gestion Humana</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/calendario.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script>
			function despliegamodalm(_valor,_tip,mensa,pregunta, variable)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden")
				{
					document.getElementById('ventanam').src="";
					switch(document.getElementById('valfocus').value)
					{
						case "1":	document.getElementById('docum').focus();
									document.getElementById('docum').select();
									break;
					}
					document.getElementById('valfocus').value='0';
				}
				else
				{
					switch(_tip)
					{
						case "1":	document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
						case "2":	document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
						case "3":	document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
						case "4":	document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;	
						case "5":	document.getElementById('ventanam').src="ventana-elimina1.php?titulos="+mensa+"&idresp="+pregunta+"&variable="+variable;break;	
					}
				}
			}
			function despliegamodal2(_valor,_pag)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else if(_pag=="1"){document.getElementById('ventana2').src="cargafuncionarios-ventana03.php?objeto=tercero&vcodfun=idusuario";}
			}
			function respuestaconsulta(pregunta, variable)
			{
				switch(pregunta)
				{
					case "1":	document.getElementById('oculto').value="2";
								document.form2.submit();break;
					case "2":	document.form2.elimina.value=variable;
								vvend=document.getElementById('elimina');
								vvend.value=variable;
								document.form2.sw.value=document.getElementById('tipomov').value ;
								document.form2.submit();break;
				}
			}
			function funcionmensaje(){}
			function validar(){document.form2.oculto.value=2;document.form2.submit();}
			
			function buscater(e)
			{
				if (document.form2.tercero.value!=""){document.form2.bt.value='1';document.form2.submit();}
				else{document.form2.ntercero.value=""}
			}
			function pdf2()
			{
				document.form2.action="hum-desprendibleglobalpdf.php";
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
				<td colspan="3" class="cinta"><img src="imagenes/add2.png" class="mgbt1"/><img src="imagenes/guardad.png" class="mgbt1"/><img src="imagenes/buscad.png" class="mgbt1"/><img src="imagenes/nv.png" title="Nueva Ventana" onClick="mypop=window.open('hum-principal.php','','');mypop.focus();" class="mgbt"/><img src='imagenes/print.png' title='Imprimir' onClick="pdf2();" class="mgbt"/></td>
			</tr>
		</table>
		<div id="bgventanamodalm" class="bgventanamodalm">
			<div id="ventanamodalm" class="ventanamodalm">
				<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
				</IFRAME>
			</div>
		</div>		  
		<form name="form2" method="post" action="">
			<?php
				$vigusu=vigencia_usuarios($_SESSION['cedulausu']);
				$vact=$vigusu;
				if(@$_POST['bt']=='1')//***** busca tercero
				{
					$nresul=buscatercero($_POST['tercero']);
					if($nresul!=''){$_POST['ntercero']=$nresul;}
					else{@$_POST['ntercero']="";}
				}
			?>
			<table class="inicio">
				<tr>
					<td colspan="10" class="titulos">Detalle Desprendible de Nomina</td>
					<td class="cerrar" style="width:7%" onClick="location.href='hum-principal.php'">Cerrar</td>
				</tr>
				<tr>
					<td class="saludo1" style="width:2.2cm;">Fecha Inicial:</td>
					<td style="width:9%;"><input name="fecha"  type="text" value="<?php echo @$_POST['fecha']?>" maxlength="10"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" style="width:75%;" title="DD/MM/YYYY"/>&nbsp;<a href="#" onClick="displayCalendarFor('fc_1198971545');" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px;"/></a></td>
					<td class="saludo1" style="width:2.2cm;">Fecha Final:</td>
					<td style="width:9%;"><input name="fecha2" type="text" value="<?php echo @$_POST['fecha2']?>" maxlength="10"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971546" onKeyDown="mascara(this,'/',patron,true)" style="width:75%;" title="DD/MM/YYYY"/>&nbsp;<a href="#" onClick="displayCalendarFor('fc_1198971546');" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px;"/></a></td>
					<td class="saludo1" style='width:5%'>Tercero:</td>
					<td style="width:10%"><input type="text" name="tercero" id="tercero" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo @$_POST['tercero']?>" onClick="document.getElementById('tercero').focus();document.getElementById('tercero').select();" style='width:80%'/>&nbsp;<img class="icobut" src="imagenes/find02.png" onClick="despliegamodal2('visible','1');" title="Listado de Funcionarios"/></td>
					<input type="hidden" value="0" name="bt"/>
					<td style='width:30%'><input type="text" name="ntercero" value="<?php echo @$_POST['ntercero']?>" readonly style='width:95%'/></td>
					<input type="hidden" name="idusuario" id="idusuario" value="<?php echo @$_POST['idusuario']?>"/>
					<td style='width:5%'><input type="button" name="buscar" value="Buscar " onClick="validar()"/></td>
				</tr>
				<input type="hidden" name="oculto" id="oculto" value="1"/>
			</table>
			<div class="subpantalla" style="height:68.5%; width:99.6%; overflow-x:hidden;">
				<?php
					//***** busca tercero
					if(@$_POST['bt']=='1')	
					{
						$nresul=buscatercero($_POST['tercero']);
						if($nresul!='')	
						{
							$_POST['ntercero']=$nresul;
							echo "<script>document.getElementById('retencion').focus();document.getElementById('retencion').select();</script>";
						}
						else
						{
							$_POST['ntercero']="";
							echo
							"<script>
								alert('Tercero Incorrecto o no Existe');
								document.form2.tercero.focus();	
							</script>";
						}
					}
					if(@$_POST['oculto']==2 && (@$_POST['tercero']!=''))
					{
						echo "<table class='inicio'>
						<tr><td colspan='12' class='titulos'>Nominas Liquidadas</td></tr>
						<tr>
							<td class='titulos2'>No N&oacute;mina</td>
							<td class='titulos2'>Mes</td>
							<td class='titulos2'>Vigencia</td>
							<td class='titulos2'>Empleado</td>
							<td class='titulos2'>D&iacute;as Lab</td>
							<td class='titulos2'>Devengado</td>
							<td class='titulos2'>Aux Alimentaci&oacute;n</td>
							<td class='titulos2'>Aux Transporte</td>
							<td class='titulos2'>Salud Funcionario</td>
							<td class='titulos2'>Pension Funcionario</td>
							<td class='titulos2'>Total Deducciones</td>
							<td class='titulos2' style='text-align:right;'>Total Pago</td>
						</tr>";
						preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $_POST['fecha'],$fecha);
						$fechai="$fecha[3]-$fecha[2]-$fecha[1]";
						preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $_POST['fecha2'],$fecha);
						$fechaf="$fecha[3]-$fecha[2]-$fecha[1]";
						$sqlr="SELECT hm.id_nom,hm.mes,hm.vigencia,SUM(ht.netopagar),ht.diaslab,SUM(ht.devendias),ht.auxalim,ht.auxtran, SUM(ht.totaldeduc),ht.salbas,SUM(ht.salud),SUM(ht.pension),SUM(ht.fondosolid),ht.retefte FROM humnomina AS hm,humnomina_det AS ht WHERE hm.id_nom=ht.id_nom AND hm.fecha BETWEEN CAST('$fechai' AS DATE) AND CAST('$fechaf' AS DATE) AND ht.cedulanit = '".$_POST['tercero']."' AND hm.estado = 'P' GROUP BY ht.idfuncionario, ht.id_nom ORDER BY hm.id_nom DESC";
						$resp = mysqli_query($linkbd,$sqlr);
						$co="saludo1a";
						$co2="saludo2";
						while ($row =mysqli_fetch_row($resp))
						{
							$auxalimen=$salabasico=0;
							$vmes=mesletras($row[1]);
							
							if($row[6]>0)
							{
								$auxalimen=$row[6];
								$salabasico=$row[5];
							}
							else
							{
								$sqlax="SELECT netopagar FROM humnomina_det WHERE id_nom='$row[0]' AND cedulanit = '".$_POST['tercero']."' AND tipopago='07'";
								$resax = mysqli_query($linkbd,$sqlax);
								while ($rowax =mysqli_fetch_row($resax))
								{
									$auxalimen=$rowax[0];
									$salabasico=$row[5]-$rowax[0];
								}
							}
							echo "
							<input type='hidden' name='pdfidnom[]' value='$row[0]'/>
							<input type='hidden' name='pdfmes[]' value='$row[1]'/>
							<input type='hidden' name='pdfvigen[]' value='$row[2]'/>
							<input type='hidden' name='pdftotalpago[]' value='$row[3]'/>
							<input type='hidden' name='pdfdiaslab[]' value='$row[4]'/>
							<input type='hidden' name='pdfdeveng[]' value='$salabasico'/>
							<input type='hidden' name='pdfauxali[]' value='$row[6]'/>
							<input type='hidden' name='pdfauxtran[]' value='$row[7]'/>
							<input type='hidden' name='pddeducci[]' value='$row[8]'/>
							<input type='hidden' name='pdfsalbasico[]' value='$row[9]'/>
							<input type='hidden' name='pdfsalud[]' value='$row[10]'/>
							<input type='hidden' name='pdfpension[]' value='$row[11]'/>
							<input type='hidden' name='pdffondos[]' value='$row[12]'/>
							<input type='hidden' name='pdfrete[]' value='$row[13]'/>
							<tr class='$co' style='text-transform:uppercase'>
								<td>$row[0]</td>
								<td>$vmes</td>
								<td>$row[2]</td>
								<td>".$_POST['ntercero']."</rd>
								<td>$row[4]</td>
								<td style='text-align:right;'>".number_format($salabasico,2,",",".")."</td>
								<td style='text-align:right;'>".number_format($auxalimen,2,",",".")."</td>
								<td style='text-align:right;'>".number_format($row[7],2,",",".")."</td>
								<td style='text-align:right;'>".number_format($row[10],2,",",".")."</td>
								<td style='text-align:right;'>".number_format($row[11],2,",",".")."</td>
								<td style='text-align:right;'>".number_format($row[8],2,",",".")."</td>
								<td style='text-align:right;'>".number_format($row[3],2,",",".")."</td>
							</tr>";
							$aux=$co;
							$co=$co2;
							$co2=$aux;
						}
						echo "</table>";
					}
				?>
			</div>
			<div id="bgventanamodal2">
				<div id="ventanamodal2">
					<IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"></IFRAME>
				</div>
			</div>
		</form>
	</body>
</html>