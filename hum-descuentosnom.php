<?php
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=iso-8859-1");
	require 'comun.inc';
	require 'funciones.inc';
	session_start();
	$linkbd=conectar_v7();
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: SPID - Gestion Humana</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css4.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
		<script type='text/javascript' src='JQuery/jquery-2.1.4.min.js'></script>
		<script type="text/javascript" src="JQuery/alphanum/jquery.alphanum.js"></script>
		<script type="text/javascript" src="JQuery/autoNumeric-master/autoNumeric-min.js"></script>
		<script>
			jQuery(function($){ $('#vldeuda').autoNumeric('init');});
			function calculacuota()
			{
				var caldeuda=parseFloat(document.getElementById('deuda').value);
				var calcuotas=parseFloat(document.getElementById('cuotas').value);
				if (calcuotas!=0){document.getElementById('vcuotas').value=caldeuda/calcuotas;}
				else{document.getElementById('vcuotas').value=0;}
			}
			function guardar()
			{
				var validacion01=document.getElementById('nombre').value;
				if (document.getElementById('codigo').value !='' && document.getElementById('fc_1198971545').value!='' && validacion01.trim()!='' && document.getElementById('ntercero').value !='' && document.getElementById('retencion').value!="-1")
 				{despliegamodalm('visible','4','Esta Seguro de Guardar','1')}
 				else{despliegamodalm('visible','2','Faltan datos para completar el registro');}
 			}
			function buscater(e)
 			{
				if (document.form2.tercero.value!="")
				{
 					document.form2.bt.value='1';
 					document.form2.submit();
				}
			}
			function despliegamodal2(_valor)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else {document.getElementById('ventana2').src="ventana-cargafuncionarios01.php?documento=tercero&nombre=ntercero&codfun=codfun";}
			}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden")
				{
					document.getElementById('ventanam').src="";
					if (document.getElementById('valfocus').value =="1")
					{
						document.getElementById('valfocus').value='0';
						document.getElementById('ntercero').value='';
						document.getElementById('tercero').focus();
						document.getElementById('tercero').select();
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
			function funcionmensaje(){document.location.href = "hum-descuentosnom.php";}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.getElementById('oculto').value="2";
								document.form2.submit();break;
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
				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='hum-descuentosnom.php'" class="mgbt"/><img src="imagenes/guarda.png" title="Guardar" onClick="guardar();" class="mgbt"/><img src="imagenes/busca.png" title="Buscar" onClick="location.href='hum-buscadescuentosnom.php'" class="mgbt"/><img src="imagenes/nv.png" title="nueva ventana" onClick="mypop=window.open('hum-principal.php','','');mypop.focus();" class="mgbt"/><img src='imagenes/iratras.png' title='Men&uacute; Nomina' class='mgbt' onClick="location.href='hum-menunomina.php'"/></td>
			</tr>
		</table>
		<div id="bgventanamodalm" class="bgventanamodalm">
			<div id="ventanamodalm" class="ventanamodalm">
				<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"></IFRAME>
			</div>
		</div>
		<form name="form2" method="post" action="">
			<input type="hidden" name="valfocus" id="valfocus" value="0"/>
			<?php
				$vigencia=date('Y');
				if(@ $_POST['oculto']=="")
				{
					$fec=date("d/m/Y");
					$_POST['fecha']=$fec;
					$_POST['tipo']='S';
					$_POST['deuda']=$_POST['cuotas']=$_POST['vcuotas']=$_POST['valor']=0;
					$_POST['origencobro']='E';
					$_POST['codigo']=selconsecutivo('humretenempleados','id');
					if(strlen($_POST['codigo'])==1){$_POST['codigo']='0'.$_POST['codigo'];}
				}
				if(@ $_POST['bt']=='1')//***** busca tercero
				{
					$nresul=buscatercero($_POST['tercero']);
					if($nresul!=''){$_POST['ntercero']=$nresul;}
					else { $_POST['ntercero']="";}
				}
			?>
			<table class="inicio ancho">
				<tr>
					<td class="titulos" colspan="8">.: Agregar Descuentos de Nomina</td>
					<td class="cerrar" style="width:7%" onClick="location.href='hum-principal.php'">Cerrar</td>
				</tr>
				<tr>
					<td class="tamano01" style="width:6%;">Codigo:</td>
					<td style="width:5%;"><input type="text" name="codigo" id="codigo" value="<?php echo @ $_POST['codigo']?>" style="width:90%;" readonly/></td>
					<td class="tamano01" style="width:6%;">Fecha:</td>
					<td style="width:14%;"><input type="text" name="fecha" id="fc_1198971545" title="DD/MM/YYYY" value="<?php echo @ $_POST['fecha']; ?>" onKeyUp="return tabular(event,this)" onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" style="width:75%;"/>&nbsp;<img src="imagenes/calendario04.png" onClick="displayCalendarFor('fc_1198971545');" title="Calendario" class="icobut"/></td>
					<td class="tamano01" style="width:9%;">Descripcion:</td>
					<td><input type="text" name="nombre" id="nombre" value="<?php echo @ $_POST['nombre']?>" onKeyUp="return tabular(event,this)" style="width:100%;"/></td>
				</tr> 
			</table>
			<table class="inicio ancho">
				<tr><td colspan="9" class="titulos">Detalle Descuento de Nomina</td></tr>
				<tr>
					<td class="tamano01" style="width:2.5cm;">Empleado:</td>
					<td style="width:15%"><input type="text" name="tercero" id="tercero" onKeyUp="return tabular(event,this)" onChange="buscater(event)" value="<?php echo @ $_POST['tercero']?>" style="width:100%;" onDblClick="despliegamodal2('visible');" class="colordobleclik" autocomplete="off"/></td>
					<td colspan="6"><input type="text" name="ntercero" id="ntercero" value="<?php echo @ $_POST['ntercero']?>" style="width:100%;" readonly/></td>
					<td style="width:10%;"></td>
				</tr>
				<tr>
					<td class="tamano01">Retencion:</td>
					<td colspan="2">
						<select name="retencion" id="retencion" class="tamano02" style="width: 100%">
							<option value="-1">Seleccione ....</option>
							<?php
								$sqlr="SELECT codigo,nombre,estado FROM humvariablesretenciones WHERE estado='S' order by codigo";
								$resp = mysqli_query($linkbd,$sqlr);
								while ($row =mysqli_fetch_row($resp)) 
								{
									if(@ $_POST['retencion'] == $row[0])
									{
										echo "<option value='$row[0]' SELECTED>$row[0] - $row[2] - $row[1]</option>";
										$_POST['retencionom']="$row[0] - $row[2] - $row[1]";
									}
									else {echo "<option value='$row[0]'>$row[0] - $row[2] - $row[1]</option>";}
								}
							?>
						</select>
						<input type="hidden" id="retencionom" name="retencionom" value="<?php echo $_POST['retencionom']?>" >
					</td>
					<td class="tamano01">Tipo de Pago:</td>
					<td colspan="4">
						<select name="variablepago" id="variablepago" class="tamano02" style="width:100%;">
							<option value="-1">Seleccione ....</option>
							<?php
								$sqlr="SELECT codigo,nombre FROM humvariables WHERE estado='S'";
								$resp = mysqli_query($linkbd,$sqlr);
								while ($row =mysqli_fetch_row($resp))
								{
									if(in_array($row[0], $vtiponum)){$vartip="S";}
									else{$vartip="N";}
									if(@ $_POST['variablepago'] == $row[0])
									{
										if($vartip=="N"){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
									}
									else
									{
										if($vartip=="N"){echo "<option value='$row[0]' >$row[0] - $row[1]</option>";}
									}
								}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td class="tamano01">Deuda:</td>
					<td>
						<input type="hidden" name="deuda" id="deuda" value="<?php echo @ $_POST['deuda']?>" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" >
						<input type="text" name="vldeuda" id="vldeuda" data-a-sign="$" data-a-dec="," data-a-sep="." data-v-min='0' onKeyUp="sinpuntitos('deuda','vldeuda');return tabular(event,this);" value="<?php echo @ $_POST['vldeuda']; ?>" style='text-align:right; width: 100%' onBlur="calculacuota();" />
					</td>
					<td class="tamano01" style="width:9%;">Cuotas:</td>
					<td style="width:10%;"><input type="text" name="cuotas" id="cuotas" value="<?php echo @ $_POST['cuotas']?>" class="tamano02" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="calculacuota();" style="width: 100%;"/></td>
					<td class="tamano01" style="width:9%;">Valor Cuota:</td>
					<td style="width:15%;"><input type="text" name="vcuotas" id="vcuotas" value="<?php echo @ $_POST['vcuotas']?>"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" class="tamano02" style="width: 100%;" readonly></td>
					<td class="tamano01">Origen:</td>
					<td>
						<select name="origencobro" id="origencobro" class="tamano02" style="width:100%;">
							<option value='E' "<?php if (@ $_POST['origencobro']=='E'){echo 'SELECTED';}?>">Externo</option>
							<option value='I' "<?php if (@ $_POST['origencobro']=='I'){echo 'SELECTED';}?>">Interno</option>
						</select>
					</td>
				</tr>
			</table>
			<input type="hidden" name="codfun" id="codfun" value="<?php echo $_POST['codfun'];?>"/>
			<input type="hidden" name="oculto" id="oculto" value="1"/>
			<input type="hidden" name="bt" id="bt" value="0"/>
			
			<?php
				if(@ $_POST['oculto']=='2')
				{
					preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $_POST['fecha'],$fecha);
					$fechaf="$fecha[3]-$fecha[2]-$fecha[1]";
					$nr="1";
					$_POST['codigo']=selconsecutivo('humretenempleados','id');
					if(strlen($_POST['codigo'])==1){$_POST['codigo']='0'.$_POST['codigo'];}
					$sqlr="INSERT INTO humretenempleados (id,descripcion,id_retencion,fecha,empleado,deuda,ncuotas,sncuotas,valorcuota,estado, habilitado,tipopago,modopago,idfuncionario) VALUES ('".$_POST['codigo']."','".$_POST['nombre']."','".$_POST['retencion']."','$fechaf','".$_POST['tercero']."','".$_POST['deuda']."','".$_POST['cuotas']."', '".$_POST['cuotas']."','".$_POST['vcuotas']."','S','H','".$_POST['variablepago']."','".$_POST['origencobro']."','".$_POST['codfun']."')";
					if (!mysqli_query($linkbd,$sqlr))
						{echo "<script>despliegamodalm('visible','2','Manejador de Errores de la Clase BD humretenempleados');</script>";}
					else {echo "<script>despliegamodalm('visible','1','Se ha almacenado con Exito');</script>";}
				}
			?>
		</form>
		<script type="text/javascript">$('#cuotas').alphanum({allow: '',allowSpace: false, allowLatin: false});</script>
		<script type="text/javascript">$('#nombre').alphanum({allow: ''});</script>
		<div id="bgventanamodal2">
			<div id="ventanamodal2">
				<IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"></IFRAME>
			</div>
		</div>
	</body>
</html>