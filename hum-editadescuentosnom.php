<?php
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=iso-8859-1");
	require 'comun.inc';
	require 'funciones.inc';
	session_start();
	$linkbd=conectar_v7();
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	date_default_timezone_set("America/Bogota");
	$scroll=@$_GET['scrtop'];
	$totreg=@$_GET['totreg'];
	$idcta=@$_GET['idcta'];
	$altura=@$_GET['altura'];
	$filtro=@$_GET['filtro'];
	$numcelt=@$_GET['numcelt']; 
	$fechaini=@$_GET['feini'];
	$fechafin=@$_GET['fefin'];
	$filnum=@$_GET['filnum'];
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html" />
		<meta http-equiv="X-UA-Compatible" content="IE=9" />
		<title>:: SPID - Gestion Humana</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css4.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
		<script type='text/javascript' src='JQuery/jquery-2.1.4.min.js'></script>
		<script type="text/javascript" src="JQuery/alphanum/jquery.alphanum.js"></script>
		<script type="text/javascript" src="JQuery/autoNumeric-master/autoNumeric-min.js"></script>
		<style>
			/*boton1*/
			.swhabilitar
			{position: relative; width: 71px;-webkit-user-select:none;-moz-user-select:none;-ms-user-select: none;}
			.swhabilitar-checkbox {display: none;}
			.swhabilitar-label 
			{display: block;overflow: hidden;cursor: pointer;border: 2px solid #DDE6E2;border-radius: 20px;}
			.swhabilitar-inner 
			{display: block;width: 200%;margin-left: -100%;transition: margin 0.3s ease-in 0s;}
			.swhabilitar-inner:before, .swhabilitar-inner:after 
			{display: block;float: left;width: 50%;height: 23px;padding: 0;line-height: 23px;font-size: 14px;color: white;font-family: Trebuchet, Arial, sans-serif;font-weight: bold;box-sizing: border-box;}
			.swhabilitar-inner:before 
			{content: "SI";padding-left: 10px;background-color: #51C3E0;color: #FFFFFF;}
			.swhabilitar-inner:after 
			{content: "NO";padding-right: 10px;background-color: #EEEEEE; color: #999999;text-align: right;}
			.swhabilitar-switch 
			{display: block;width: 17px;margin: 3px;background: #FFFFFF;position: absolute;top: 0;bottom: 0;right: 44px;border: 2px solid #DDE6E2;border-radius: 20px;transition: all 0.3s ease-in 0s;}
			.swhabilitar-checkbox:checked + .swhabilitar-label .swhabilitar-inner {margin-left: 0;}
			.swhabilitar-checkbox:checked + .swhabilitar-label .swhabilitar-switch {right: 0px;}
		</style>
		<script>
			jQuery(function($){ $('#vldeuda').autoNumeric('init');});
			function validar(){document.form2.submit();}
			function guardar()
			{
				if (document.form2.codigo.value!='' && document.form2.nombre.value!='')
				{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
				else {despliegamodalm('visible','2','Falta asignar retenciones a un funcionario');}
			}
			function buscater(e)
			{
				if (document.form2.tercero.value!="")
				{
					document.form2.bt.value='1';
					document.form2.submit();
				}
			}
			function iratras(scrtop,numpag,limreg,filtro,numcelt,feini,fefin,filnum)
			{
				var iddescuento=document.getElementById('codigo').value;
				location.href="hum-buscadescuentosnom.php?idcta=" + iddescuento + "&scrtop=" + scrtop + "&numpag=" + numpag + "&limreg=" + limreg + "&filtro=" + filtro + "&numcelt=" + numcelt +"&feini=" + feini + "&fefin=" + fefin +"&filnum=" + filnum;
			}
			function cambiocheck(id)
			{
				switch(id)
				{
					case "1":	if(document.getElementById('idswhabilitar').value=='H'){document.getElementById('idswhabilitar').value='D';}
								else{document.getElementById('idswhabilitar').value='H';}
								break;
					
				}
				document.form2.submit();
			}
			function atrasc(scrtop,numpag,limreg,filtro,numcelt,feini,fefin,filnum)
			{
				var codig = document.form2.codigo.value;
				var minim = document.form2.minimo.value;
				codig=parseFloat(codig)-1;
				if(codig >= minim){location.href="hum-editadescuentosnom.php?idr=" + codig + "&scrtop=" + scrtop + "&numpag=" + numpag + "&limreg=" + limreg + "&filtro=" + filtro + "&numcelt=" + numcelt +"&feini=" + feini + "&fefin=" + fefin +"&filnum=" + filnum;}
			}
			function adelante(scrtop,numpag,limreg,filtro,numcelt,feini,fefin,filnum)
			{
				var codig = document.form2.codigo.value;
				var maxim = document.form2.maximo.value;
				codig=parseFloat(codig)+1;
				if(codig <= maxim){location.href="hum-editadescuentosnom.php?idr=" + codig + "&scrtop=" + scrtop + "&numpag=" + numpag + "&limreg=" + limreg + "&filtro=" + filtro + "&numcelt=" + numcelt +"&feini=" + feini + "&fefin=" + fefin +"&filnum=" + filnum;}
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
			function funcionmensaje(){}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":
						document.form2.oculto.value="2";
						document.form2.submit();
						break;
				}
			}
			function despliegamodal2(_valor,_num)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else 
				{	
					document.getElementById('ventana2').src="ventana-cargafuncionarios01.php?documento=tercero&nombre=ntercero&codfun=codfun";
				}
			}
			function calculacuota()
			{
				var caldeuda=parseFloat(document.form2.deuda.value);
				var calcuotas=parseFloat(document.form2.cuotas.value);
				if (calcuotas!=0){document.form2.vcuotas.value=caldeuda/calcuotas;}
				else{document.fomr2.vcuotas.value=0;}
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<form name="form2" method="post" action="">
			<?php
				$numpag=@$_GET['numpag'];
				$limreg=@$_GET['limreg'];
				$scrtop=20*$totreg;
				$vigusu=vigencia_usuarios($_SESSION['cedulausu']);
				if(!@$_POST['oculto'])
				{
					$sqlb="SELECT MIN(id),MAX(id) FROM humretenempleados";
					$resb=mysqli_query($linkbd,$sqlb);
					$rowb=mysqli_fetch_array($resb);
					$_POST['maximo']=$rowb[1];
					$_POST['minimo']=$rowb[0];
					$sqlr="SELECT * FROM humretenempleados WHERE id='".$_GET['idr']."'";
					$res=mysqli_query($linkbd,$sqlr);
					while($row=mysqli_fetch_row($res))
					{
						$_POST['codigo']=$row[0];
						$_POST['nombre']=$row[1];
						$_POST['fecha']=$row[3];
						preg_match("/([0-9]{4})\-([0-9]{2})\-([0-9]{2})/", $_POST['fecha'],$fecha);
						$fechaf="$fecha[3]/$fecha[2]/$fecha[1]";
						$_POST['fecha']=$fechaf;
						$_POST['tercero']=$row[4];
						$_POST['retencion']=$row[2];
						$_POST['ntercero']=buscatercero($_POST['tercero']);
						$_POST['deuda']=$_POST['vldeuda']=$row[5];
						$_POST['cuotas']=$row[6];
						$_POST['scuotas']=$row[7];
						$_POST['vcuotas']=$row[8];
						$_POST['estado']=$row[9];
						$_POST['swhabilitar']=$row[10];
						$_POST['variablepago']=$row[11];
						$_POST['origencobro']=$row[12];
						$_POST['codfun']=$row[13];
					}
					$sql="SELECT COUNT(1) FROM humnominaretenemp WHERE id='".$_POST['codigo']."' AND estado='P' AND tipo_des='DS'";
					$res=mysqli_query($linkbd,$sql);
					$row=mysqli_fetch_row($res);
					$_POST['npagos']=$row[0];
				}
			?>
			<table>
				<tr><script>barra_imagenes("hum");</script><?php cuadro_titulos();?></tr>	 
				<tr><?php menu_desplegable("hum");?></tr>
				<tr>
					<?php 
						if(@$_POST['estado']=='S'){$imaguar="src='imagenes/guarda.png' title='Guardar' onClick='guardar();' class='mgbt'";}
						else{$imaguar="src='imagenes/guardad.png' class='mgbt1'";}
					?>
					<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='hum-descuentosnom.php'" class="mgbt"/><img <?php echo $imaguar;?>/><img src="imagenes/busca.png" title="Buscar" onClick="location.href='hum-buscadescuentosnom.php'" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" onClick="mypop=window.open('hum-principal.php','','');mypop.focus();"class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s" onClick="iratras(<?php echo "'$scrtop','$numpag','$limreg','$filtro','$numcelt','$fechaini','$fechafin', '$filnum'"; ?>)" class="mgbt"></td>
				</tr>
			</table>
			<div id="bgventanamodalm" class="bgventanamodalm">
				<div id="ventanamodalm" class="ventanamodalm">
					<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"></IFRAME>
				</div>
			</div>
			<?php
				
				if(@$_POST['bt']=='1')//***** busca tercero
				{
					$nresul=buscatercero($_POST['tercero']);
					if($nresul!=''){$_POST['ntercero']=$nresul;}
					else {$_POST['ntercero']=""; }
				}
			?>
			<table class="inicio ancho">
				<tr>
					<td class="titulos" colspan="8">.: Editar Descuentos de Nomina</td>
					<td class="cerrar" style="width:7%" onClick="location.href='hum-principal.php'">Cerrar</td>
				</tr>
				<tr>
					<td class="tamano01" style="width: 2.5cm;">C&oacute;digo:</td>
					<td style="width:10%;"><img src="imagenes/back.png" onClick="atrasc(<?php echo "'$scrtop','$numpag','$limreg','$filtro','$numcelt','$fechaini', '$fechafin','$filnum'"; ?>)" class="icobut" title="Anterior"/>&nbsp;<input name="codigo" id="codigo" type="text" value="<?php echo @ $_POST['codigo']?>" maxlength="2" size="2" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" class="tamano02" readonly>&nbsp;<img src="imagenes/next.png" onClick="adelante(<?php echo "'$scrtop','$numpag','$limreg','$filtro', '$numcelt','$fechaini','$fechafin','$filnum'"; ?>)" class="icobut" title="Sigiente"/></td>
					<td class="tamano01" style="width:2.5cm;">Fecha:</td>
					<td style="width:12%;"><input type="text" name="fecha" id="fc_1198971545" title="DD/MM/YYYY" value="<?php echo @ $_POST['fecha']; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)" maxlength="10" class="tamano02" style="width:80%;" <?php if ($_POST['npagos']>0){echo 'readonly';}?>/>&nbsp;<img src="imagenes/calendario04.png" onClick="displayCalendarFor('fc_1198971545');" title="Calendario" class="icobut" <?php if ($_POST['npagos']>0){echo 'style="visibility: hidden;"';}?>/></td>
					<td class="tamano01" style="width:2.5cm">Descripci&oacute;n:</td>
					<td><input type="text" name="nombre" style="width:100%;" value="<?php echo  @$_POST['nombre']?>" onKeyUp="return tabular(event,this)" class="tamano02" <?php if ($_POST['npagos']>0){echo 'readonly';}?>/></td>
				</tr>
				<input type="hidden" name="estado" id="estado" value="<?php echo @ $_POST['estado']?>"/>
				<tr>
					<td class="tamano01">Habilitar</td>
					<td style="background: image(imagenes/pagado.png)">
						<div class="swhabilitar" style="visibility:<?php if(@ $_POST['estado']=='S'){echo 'visible';} else{echo 'hidden';}?>">
							<input type="checkbox" name="swhabilitar" class="swhabilitar-checkbox" id="idswhabilitar" value="<?php echo @ $_POST['swhabilitar'];?>" <?php if(@$_POST['swhabilitar']=='H'){echo "checked";}?> onChange="cambiocheck('1');"/>
							<label class="swhabilitar-label" for="idswhabilitar">
								<span class="swhabilitar-inner"></span>
								<span class="swhabilitar-switch"></span>
							</label>
						</div>
					</td>
				</tr> 
			</table>
			<input type="hidden" name="maximo" id="maximo" value="<?php echo @$_POST['maximo'] ?>"/>
			<input type="hidden" name="minimo" id="minimo" value="<?php echo @$_POST['minimo'] ?>"/>
			<input name="oculto" id="oculto" type="hidden" value="1">
			<table class="inicio ancho">
				<tr><td colspan="9" class="titulos">Detalle Descuento de Nomina</td></tr>
				<tr>
					<td class="tamano01" style="width:2.5cm;">Empleado:</td>
					<td style="width:15%"><input type="text" name="tercero" id="tercero" onKeyUp="return tabular(event,this)" onChange="buscater(event)" value="<?php echo @ $_POST['tercero']?>" style="width:100%;" autocomplete="off" <?php if ($_POST['npagos']>0){echo 'readonly';} else{echo" onDblClick=\"despliegamodal2('visible');\" class='colordobleclik'";}?>/></td>
					<td colspan="6"><input type="text" name="ntercero" id="ntercero" value="<?php echo @ $_POST['ntercero']?>" style="width:100%;" readonly/></td>
					<td style="width:10%;"></td>
				</tr>
				<input type="hidden" name="bt" id="bt" value="0"/>
				<tr>
					<td class="tamano01">Retencion:</td>
					<td colspan="2">
						<select name="retencion" id="retencion" class="tamano02" style="width: 100%" <?php if ($_POST['npagos']>0){echo 'disabled';}?>>
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
						<select name="variablepago" id="variablepago" class="tamano02" style="width:100%;" <?php if ($_POST['npagos']>0){echo 'disabled';}?>>
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
						<input type="text" name="vldeuda" id="vldeuda" data-a-sign="$" data-a-dec="," data-a-sep="." data-v-min='0' onKeyUp="sinpuntitos('deuda','vldeuda');return tabular(event,this);" value="<?php echo @ $_POST['vldeuda']; ?>" style='text-align:right; width: 100%' onBlur="calculacuota();" <?php if ($_POST['npagos']>0){echo 'readonly';}?>/>
					</td>
					<td class="tamano01" style="width:9%;">Cuotas:</td>
					<td style="width:10%;"><input type="text" name="cuotas" id="cuotas" value="<?php echo @ $_POST['cuotas']?>" class="tamano02" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="calculacuota();" style="width: 100%;" <?php if ($_POST['npagos']>0){echo 'readonly';}?>/></td>
					<td class="tamano01" style="width:9%;">Valor Cuota:</td>
					<td style="width:15%;"><input type="text" name="vcuotas" id="vcuotas" value="<?php echo @ $_POST['vcuotas']?>"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" class="tamano02" style="width: 100%;" readonly></td>
					<td class="tamano01">Origen:</td>
					<td>
						<select name="origencobro" id="origencobro" class="tamano02" style="width:100%;" <?php if ($_POST['npagos']>0){echo 'disabled';}?>>
							<option value='E' <?php if ( $_POST['origencobro'] == 'E'){echo 'SELECTED';}?>>Externo</option>
							<option value='I' <?php if ( $_POST['origencobro'] == 'I'){echo 'SELECTED';}?>>Interno</option>
						</select>
					</td>
				</tr>
			</table>
			<input type="hidden" name="codfun" id="codfun" value="<?php echo $_POST['codfun'];?>"/>
			<input type="hidden" name="npagos" id="npagos" value="<?php echo $_POST['npagos'];?>"/>
			<div class="subpantallac5" style="height:39%; width:99.6%; margin-top:0px; overflow-x:hidden">
				<table class='inicio' align='center' >
					<tr><td colspan='10' class='titulos'>.: Pagos Realizados: &nbsp;<?php echo $_POST['npagos'];?></td></tr>
					<tr class='titulos2'>
						<td  style='width:8%'>No.</td>
						<td style='width:8%'>ID Descuento</td>
						<td>Valor</td>
						<td>Nomina</td>
						<td>Fecha</td>
						<td>Mes</td>
						<td>Egreso</td>
						<td>Fecha</td>
						<td>Cancelado a</td>
						<td>Cuenta P.</td>
					</tr>
					<?php
						if ($_POST['npagos']>0)
						{
							$iter='saludo1a';
							$iter2='saludo2';
							$cont=1;
							$sql="SELECT T1.id_nom,T1.id_des,T1.ncta,T1.valor,T2.fecha,T2.mes FROM humnominaretenemp AS T1 INNER JOIN humnomina AS T2 ON T1.id_nom=T2.id_nom WHERE T1.id='".$_POST['codigo']."' AND T1.estado='P' AND T1.tipo_des='DS'";
							$res=mysqli_query($linkbd,$sql);
							while ($row = mysqli_fetch_row($res))
							{
								$fechanomina=date('d-m-Y',strtotime($row[4]));
								$mesnomina=mesletras($row[5]);
								if ($_POST['origencobro'] == 'I')
								{
									$egreso = "Pago Directo";
									$fechaegreso = "Pago Directo";
									$tercerore = "Pago Directo";
									$cuentapre = "Pago Directo";
								}
								else
								{
									$sqleg = "SELECT T1.id_egreso, T1.ntercero_det, T1.cuentap, T2.fecha FROM tesoegresosnomina_det AS T1 INNER JOIN tesoegresosnomina AS T2  ON T1.id_egreso=T2.id_egreso WHERE T1.id_orden='$row[0]' AND T1.ndes='".$_POST['codigo']."' AND T1.tipo='DS'";
									$reseg = mysqli_query($linkbd,$sqleg);
									$roweg = mysqli_fetch_row($reseg);
									$egreso = "$roweg[0]";
									$tercerore = "$roweg[1]";
									$cuentapre = "$roweg[2]";
									$fechaegreso = date('d-m-Y',strtotime($roweg[3]));
								}
								echo "
								<tr class='$iter' style='text-transform:uppercase'>
									<td style='text-align:center;'>$cont</td>
									<td style='text-align:center;'>$row[1]</td>
									<td style='text-align:center;'>$".number_format($row[3],0,',','.')."</td>
									<td style='text-align:center;'>$row[0]</td>
									<td style='text-align:center;'>$fechanomina</td>
									<td style='text-align:center;'>$mesnomina</td>
									<td>$egreso</td>
									<td>$fechaegreso</td>
									<td>$tercerore</td>
									<td>$cuentapre</td>
								</tr>";
								$aux=$iter;
								$iter=$iter2;
								$iter2=$aux;
								$cont++;
							}
						}
					?>
				</table>
			</div>
			<img style="left: 600px; top: 200px; position: absolute; width:18%; visibility:<?php if(@$_POST['estado']=='S'){echo 'hidden';} else{echo 'visible';}?>" src="imagenes/pagado.png" target="_blank" rel="nofollow">
			<?php
				if(@$_POST[bc]!='')//**** busca cuenta
				{
					$nresul=buscacuenta($_POST['cuenta']);
					if($nresul!='')
					{
						$_POST[ncuenta]=$nresul;
						echo"
						<script>
							document.getElementById('cuentap').focus();
							document.getElementById('cuentap').select();
							document.getElementById('bc').value='';
						</script>";
					}
					else
					{
						$_POST[ncuenta]="";
						echo "<script>alert('Cuenta Incorrecta');document.form2.cuenta.focus();</script>";
					}
				}
				if(@$_POST['bt']=='1')//***** busca tercero
				{
					$nresul=buscatercero($_POST['tercero']);
					if($nresul!='')
					{
						$_POST['ntercero']=$nresul;
						echo"<script> document.getElementById('retencion').focus();document.getElementById('retencion').select();</script>";
					}
					else
					{
						$_POST['ntercero']="";
						echo"<script>alert('Tercero Incorrecto o no Existe');document.form2.tercero.focus();</script>";
					}
				}
				if(@$_POST['oculto']=='2')
				{
					if (@$_POST['nombre']!="")
					{
						preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $_POST['fecha'],$fecha);
						$fechaf="$fecha[3]-$fecha[2]-$fecha[1]";
						$nr="1";
						if($_POST['swhabilitar']=="" || $_POST['swhabilitar']=="D"){$valswhabilitar='D';}
						else{$valswhabilitar='H';}
						if ($_POST['npagos']>0)
						{
							$sqlr="UPDATE humretenempleados SET habilitado='$valswhabilitar' WHERE id='".$_POST['codigo']."'";
						}
						else
						{
							$sqlr="UPDATE humretenempleados SET descripcion='".$_POST['nombre']."',id_retencion='".$_POST['retencion']."',fecha='$fechaf', empleado='".$_POST['tercero']."',deuda='".$_POST['deuda']."',ncuotas='".$_POST['cuotas']."', valorcuota='".$_POST['vcuotas']."', habilitado='$valswhabilitar',tipopago='".$_POST['variablepago']."',modopago='".$_POST['origencobro']."', idfuncionario='".$_POST['codfun']."' WHERE id='".$_POST['codigo']."'";
						}
						
						if (!mysqli_query($linkbd,$sqlr)) {echo"<script>despliegamodalm('visible','2','Error no se Actualizado el Descuento');</script>";}
						else {echo "<script>despliegamodalm('visible','1','Se ha Actualizado el Descuento con Exito');</script>";}
					}
					else {echo"<script>despliegamodalm('visible','2','Falta informacion para Modificar el Descuento');</script>";}
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