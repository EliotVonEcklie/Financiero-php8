<?php
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=utf8");
	require 'comun.inc';
	require 'funciones.inc';
	require 'conversor.php';
	require_once '/controllers/AdmFiscalesController.php';
	require_once '/controllers/HumIncapacidadesController.php';
	require_once '/controllers/HumIncapacidadesDetallesController.php';
	require_once '/controllers/MesesController.php';
	sesion();
	$linkbd=conectar_v7();
	cargarcodigopag(@$_GET['codpag'],@$_SESSION["nivel"]);
	date_default_timezone_set("America/Bogota");
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	$scrtop=$_GET['scrtop'];
	$totreg=@$_GET['totreg'];
	$idcta=@$_GET['idcta'];
	$altura=@$_GET['altura'];
	$filtro=@$_GET['filtro'];
	$numpag=@$_GET['numpag'];
	$limreg=@$_GET['limreg'];
	$scrtop=20*$totreg;
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Spid - Gestion Humana</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
		<style>
			input[type='text']{height:30px;}
			input[type='search']{height:30px;}
			select{height:30px;}
			/*boton1*/
			.swibc
			{position: relative; width: 71px;-webkit-user-select:none;-moz-user-select:none;-ms-user-select: none;}
			.swibc-checkbox {display: none;}
			.swibc-label 
			{display: block;overflow: hidden;cursor: pointer;border: 2px solid #DDE6E2;border-radius: 20px;}
			.swibc-inner 
			{display: block;width: 200%;margin-left: -100%;transition: margin 0.3s ease-in 0s;}
			.swibc-inner:before, .swibc-inner:after 
			{display: block;float: left;width: 50%;height: 23px;padding: 0;line-height: 23px;font-size: 14px;color: white;font-family: Trebuchet, Arial, sans-serif;font-weight: bold;box-sizing: border-box;}
			.swibc-inner:before 
			{content: "SI";padding-left: 10px;background-color: #51C3E0;color: #FFFFFF;}
			.swibc-inner:after 
			{content: "NO";padding-right: 10px;background-color: #EEEEEE; color: #999999;text-align: right;}
			.swibc-switch 
			{display: block;width: 17px;margin: 3px;background: #FFFFFF;position: absolute;top: 0;bottom: 0;right: 44px;border: 2px solid #DDE6E2;border-radius: 20px;transition: all 0.3s ease-in 0s;}
			.swibc-checkbox:checked + .swibc-label .swibc-inner {margin-left: 0;}
			.swibc-checkbox:checked + .swibc-label .swibc-switch {right: 0px;}
			/*boton2*/
			.swarl
			{position: relative; width: 71px;-webkit-user-select:none;-moz-user-select:none;-ms-user-select: none;}
			.swarl-checkbox {display: none;}
			.swarl-label 
			{display: block;overflow: hidden;cursor: pointer;border: 2px solid #DDE6E2;border-radius: 20px;}
			.swarl-inner 
			{display: block;width: 200%;margin-left: -100%;transition: margin 0.3s ease-in 0s;}
			.swarl-inner:before, .swarl-inner:after 
			{display: block;float: left;width: 50%;height: 23px;padding: 0;line-height: 23px;font-size: 14px;color: white;font-family: Trebuchet, Arial, sans-serif;font-weight: bold;box-sizing: border-box;}
			.swarl-inner:before 
			{content: "SI";padding-left: 10px;background-color: #51C3E0;color: #FFFFFF;}
			.swarl-inner:after 
			{content: "NO";padding-right: 10px;background-color: #EEEEEE; color: #999999;text-align: right;}
			.swarl-switch 
			{display: block;width: 17px;margin: 3px;background: #FFFFFF;position: absolute;top: 0;bottom: 0;right: 44px;border: 2px solid #DDE6E2;border-radius: 20px;transition: all 0.3s ease-in 0s;}
			.swarl-checkbox:checked + .swarl-label .swarl-inner {margin-left: 0;}
			.swarl-checkbox:checked + .swarl-label .swarl-switch {right: 0px;}
			/*boton3*/
			.swparafiscal
			{position: relative; width: 71px;-webkit-user-select:none;-moz-user-select:none;-ms-user-select: none;}
			.swparafiscal-checkbox {display: none;}
			.swparafiscal-label 
			{display: block;overflow: hidden;cursor: pointer;border: 2px solid #DDE6E2;border-radius: 20px;}
			.swparafiscal-inner 
			{display: block;width: 200%;margin-left: -100%;transition: margin 0.3s ease-in 0s;}
			.swparafiscal-inner:before, .swparafiscal-inner:after 
			{display: block;float: left;width: 50%;height: 23px;padding: 0;line-height: 23px;font-size: 14px;color: white;font-family: Trebuchet, Arial, sans-serif;font-weight: bold;box-sizing: border-box;}
			.swparafiscal-inner:before 
			{content: "SI";padding-left: 10px;background-color: #51C3E0;color: #FFFFFF;}
			.swparafiscal-inner:after 
			{content: "NO";padding-right: 10px;background-color: #EEEEEE; color: #999999;text-align: right;}
			.swparafiscal-switch 
			{display: block;width: 17px;margin: 3px;background: #FFFFFF;position: absolute;top: 0;bottom: 0;right: 44px;border: 2px solid #DDE6E2;border-radius: 20px;transition: all 0.3s ease-in 0s;}
			.swparafiscal-checkbox:checked + .swparafiscal-label .swparafiscal-inner {margin-left: 0;}
			.swparafiscal-checkbox:checked + .swparafiscal-label .swparafiscal-switch {right: 0px;}
		</style>
		<script>
			function guardar()
			{
				if(document.form2.totalinca.value>0)
				{
					if (document.form2.tercero.value!='' && document.form2.periodo.value!='')
					{
						despliegamodalm('visible','4','Esta Seguro de Guardar','1');
					}
					else{despliegamodalm('visible','2','Faltan datos para completar la incapacidad');}
				}
				else{despliegamodalm('visible','2','Falta asignar detalles a la incapacidad');}
 			}
			function validar(formulario){document.form2.submit();}
			function buscater(e)
			{
				if (document.form2.tercero.value!="")
				{
 					document.form2.bt.value='1';
 					document.form2.submit();
 				}
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
					case "2": 
						document.form2.oculto.value="3";
						document.form2.submit();
						break;
				}
			}
			function fagregar()
			{
				if(document.form2.vigenciat.value!="")
				{
					if(document.form2.tipoinca.value!="")
					{
						if(document.form2.periodo.value!="-1")
						{
							if(document.form2.diasperiodo.value!="")
							{
								if(document.form2.porcinca.value!="")
								{
									if(document.form2.salbas.value!="")
									{
										document.form2.oculto.value="4";
										document.form2.submit();
									}
									else{despliegamodalm('visible','2','Falta un funcionario con cargo asignado');}
								}
								else{despliegamodalm('visible','2','Falta asignar porcentaje de incapacidad');}
							}
							else{despliegamodalm('visible','2','Falta asignar días de incapacidad');}
						}
						else{despliegamodalm('visible','2','Falta asignar el mes');}
					}
					else{despliegamodalm('visible','2','Falta asignar tipo de incapacidad');}
				
				}
				else{despliegamodalm('visible','2','Falta activar la vigencia actual');}
			}
			function eliminar(variable)
			{
				document.getElementById('elimina').value=variable;
				despliegamodalm('visible','4','Esta Seguro de Modificar la Incapacidad','2');
			}
			function cambiocheck(id)
			{	
				switch(id)
				{
					case '1':
						if(document.getElementById('idswibc').value=='S'){document.getElementById('idswibc').value='N';}
						else{document.getElementById('idswibc').value='S';}
						break;
					case '2':
						if(document.getElementById('idswarl').value=='S'){document.getElementById('idswarl').value='N';}
						else{document.getElementById('idswarl').value='S';}
						break;
					case '3':
						if(document.getElementById('idswparafiscal').value=='S'){document.getElementById('idswparafiscal').value='N';}
						else{document.getElementById('idswparafiscal').value='S';}
				}
				document.form2.submit();
			}
			function atrasc(scrtop,numpag,limreg,filtro,totreg,altura)
			{
				var codig = document.form2.idcomp.value;
				var minim = document.form2.minimo.value;
				codig=parseFloat(codig)-1;
				if(codig => minim){location.href="hum-incapacidadeseditar.php?idinca=" + codig + "&scrtop=" + scrtop + "&totreg=" + totreg + "&altura=" + altura + "&numpag=" + numpag + "&limreg=" + limreg + "&filtro=" + filtro;}
			}
			function adelante(scrtop,numpag,limreg,filtro,totreg,altura)
			{
				var codig = document.form2.idcomp.value;
				var maxim = document.form2.maximo.value;
				codig=parseFloat(codig)+1;
				if(codig <= maxim){location.href="hum-incapacidadeseditar.php?idinca=" + codig + "&scrtop=" + scrtop + "&totreg=" + totreg + "&altura=" + altura + "&numpag=" + numpag + "&limreg=" + limreg + "&filtro=" + filtro;}
			}
			function iratras(scrtop,numpag,limreg,filtro,totreg,altura)
			{
				var codig=document.getElementById('idcomp').value;
				location.href="hum-incapacidadesbuscar.php?idban=" + codig + "&scrtop=" + scrtop + "&totreg=" + totreg + "&altura=" + altura + "&numpag=" + numpag + "&limreg=" + limreg + "&filtro=" + filtro;
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
				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='hum-incapacidadesagregar.php'" class="mgbt"/><img src="imagenes/guarda.png" title="Guardar" onClick="guardar()" class="mgbt"/><img src="imagenes/busca.png" title="Buscar" onClick="location.href='hum-incapacidadesbuscar.php'" class="mgbt"/><img src="imagenes/nv.png" title="nueva ventana"  class="mgbt" onClick="mypop=window.open('hum-principal.php','','');mypop.focus();"><img src='imagenes/iratras.png' title='Men&uacute; Nomina' class='mgbt' onClick="iratras(<?php echo "'$scrtop','$numpag','$limreg','$filtro','$totreg','$altura'"; ?>)"/></td>
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
				if(!@$_POST['oculto'])
				{
					$_POST['idcomp']=$_GET['idinca'];
					$registrosincapasidades = new HumIncapacidadesController();
					$registrosincapasidades-> generarHumIncapasidades($_POST['idcomp']);
					$tablaincapasidades = $registrosincapasidades -> Humincapasidades;
					$_POST['fecha'] = $tablaincapasidades[0]['fecha'];
					$_POST['vigenciat']=$tablaincapasidades[0]['vigencia'];
					$_POST['tercero']=$tablaincapasidades[0]['doc_funcionario'];
					$_POST['ntercero']=$tablaincapasidades[0]['nom_funcionario'];
					$_POST['incaeps']=$tablaincapasidades[0]['cod_inca_n'];
					$_POST['incaepsant']=$tablaincapasidades[0]['cod_inca_a'];
					$_POST['salbas']=$tablaincapasidades[0]['salario'];
					$_POST['fechai']=date('d/m/Y',strtotime($tablaincapasidades[0]['fecha_ini']));
					$_POST['fechaf']=date('d/m/Y',strtotime($tablaincapasidades[0]['fecha_fin']));
					$_POST['tipoinca']=$tablaincapasidades[0]['tipo_inca'];
					$_POST['swibc']=$tablaincapasidades[0]['paga_ibc'];
					$_POST['swarl']=$tablaincapasidades[0]['paga_arl'];
					$_POST['swparafiscal']=$tablaincapasidades[0]['paga_para'];
					$registrosincapdetalles = new HumIncapacidadesDetallesController();
					$registrosincapdetalles-> generarAllHumIncapasidadesDetalles($_POST['idcomp']);
					$tablaincapdetalles = $registrosincapdetalles-> Humincapdetallesa;
					$limx = count($tablaincapdetalles);
					for($x=0;$x<$limx;$x++)
					{
						$_POST['idinca'][]=$tablaincapdetalles[$x]['id_det'];
						$_POST['viginca'][]=$tablaincapdetalles[$x]['vigencia'];
						$_POST['mesinca'][]=$tablaincapdetalles[$x]['mes'];
						$_POST['diasinca'][]=$tablaincapdetalles[$x]['dias_inca'];
						$_POST['valordiainca'][]=$tablaincapdetalles[$x]['valor_dia'];
						$_POST['valorinca'][]=$tablaincapdetalles[$x]['valor_total'];
						$_POST['porvinca'][]=$tablaincapdetalles[$x]['porcentaje'];
						$_POST['tipinca'][]=$tablaincapdetalles[$x]['tipo_inca'];
					}
					$registrosadmfiscales = new AdmFiscalesController();
					$registrosadmfiscales->AdmFiscalesAll($vigusu);
					$tablaadmfiscales = $registrosadmfiscales -> tadmfiscales;
					$_POST['salmin']=$tablaadmfiscales[0]['salario'];
					$maxincapasidades = new HumIncapacidadesController();
					$maxincapasidades -> generarMaxIncapasidades();
					$_POST['maximo'] = $maxincapasidades -> maxincapasidades;
					$minincapasidades = new HumIncapacidadesController();	
					$minincapasidades -> generarMinIncapasidades();
					$_POST['minimo'] = $minincapasidades -> minincapasidades;
					$_POST['ideliminar']="";
				}
			?>
			<table  class="inicio" align="center" >
				<tr>
					<td class="titulos" colspan="7">:: Incapacidades y Licencias</td>
					<td class="cerrar" style="width:7%" onClick="location.href='hum-principal.php'">Cerrar</td>
				</tr>
				<tr> 
					<td class="saludo1" style="width:3.5cm;">No Incapacidad:</td>
					<td style="width:12%"><img src="imagenes/back.png" onClick="atrasc(<?php echo "'$scrtop','$numpag','$limreg','$filtro','$totreg','$altura'"; ?>)" class="icobut" title="Anterior"/>&nbsp;<input type="text" name="idcomp" id="idcomp" value="<?php echo @$_POST['idcomp']?>" style="width:60%;" readonly/>&nbsp;<img src="imagenes/next.png" onClick="adelante(<?php echo "'$scrtop','$numpag','$limreg','$filtro','$totreg','$altura'"; ?>)" class="icobut" title="Sigiente"/></td>
					<td class="saludo1"  style="width:4cm;">Fecha Registro:</td>
					<td style="width:12%"><input type="date" name="fecha"  value="<?php echo @$_POST['fecha']?>" style="width:98%;" readonly/></td>
					<td class="saludo1" style="width:3.5cm;">Vigencia:</td>
					<td style="width:14%"><input type="text" name="vigenciat" id="vigenciat" value="<?php echo @$_POST['vigenciat'];?>" style="width:100%;" readonly/></td>
					<td rowspan="6" colspan="2" style="background:url(imagenes/incapacidad.png); background-repeat:no-repeat; background-position:center; background-size: 60% 100%;" ></td>
				</tr>
				<tr>
					<td class="saludo1">Funcionario:</td>
					<td><input type="text" id="tercero" name="tercero" onKeyUp="return tabular(event,this)" value="<?php echo @$_POST['tercero']?>" style="width:100%;" readonly/></td>
					<td colspan="4"><input type="text" name="ntercero" id="ntercero" value="<?php echo @$_POST['ntercero']?>" style="width: 100%;"readonly/></td>
					<input type="hidden" name="bt" id="bt" value="0"/>
				</tr>
				<tr>
					<td class="saludo1">Cod Incapacidad EPS:</td>
					<td><input type="text" name="incaeps" id="incaeps" value="<?php echo @$_POST['incaeps']?>" style="width:98%;"/></td>
					<td class="saludo1">Cod Incapacidad Ant. EPS:</td>
					<td><input name="incaepsant" type="text"  value="<?php echo @$_POST['incaepsant']?>" style="width:98%;"/></td>
					<td class="saludo1">Salario Basico:</td>
					<td><input type="text" name="salbas" value="<?php echo @$_POST['salbas']?>" style="width:100%;"/></td>
				</tr>
				<tr>
					<td class="saludo1">Fecha Inicial:</td>
					<td><input type="text" name="fechai" value="<?php echo @$_POST['fechai']?>" maxlength="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" style="width:80%;">&nbsp;<img src="imagenes/calendario04.png" onClick="displayCalendarFor('fc_1198971545');" title="Calendario" class="icobut"/></td>
					<td class="saludo1">Fecha Final:</td>
					<td><input type="text" name="fechaf" value="<?php echo @$_POST['fechaf']?>" maxlength="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" id="fc_1198971546" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" style="width:80%;">&nbsp;<img src="imagenes/calendario04.png" onClick="displayCalendarFor('fc_1198971546');" title="Calendario" class="icobut"/></td> 
					<td class="saludo1">Tipo Incapacidad:</td>
					<td >
						<select name="tipoinca" id="tipoinca" style="width:100%;" >
							<option value="">Seleccione ....</option>
							<?php
								$sqlr="Select * from dominios where tipo='S' and nombre_dominio LIKE 'LICENCIAS' ";
								$resp = mysqli_query($linkbd,$sqlr);
								while ($row =mysqli_fetch_row($resp)) 
								{
									if($row[1]==@$_POST['tipoinca']){echo "<option value='$row[1]' SELECTED>$row[0]</option>";}
									else{echo "<option value='$row[1]'>$row[0]</option>";}
								}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td class="saludo1">Mes:</td>
					<td >
						<select name="periodo" id="periodo" style="width:98%;">
							<option value="-1">Seleccione ....</option>
							<?php
								$cargarmeses = new MesesController();
								$cargarmeses -> generarAllMeses();
								$tablameses = $cargarmeses -> allmeses;
								$tmeses=count($tablameses);
								for($x=0;$x<$tmeses;$x++)
								{
									if($tablameses[$x]['id']==$_POST['periodo'])
									{
										echo "<option value='".$tablameses[$x]['id']."' SELECTED>".$tablameses[$x]['nombre']."</option>";
									}
									else{echo "<option value='".$tablameses[$x]['id']."'>".$tablameses[$x]['nombre']."</option>";}
								}
							?>
						</select>
					</td>
					<td class="saludo1">Dias Incapacidad:</td>
					<td><input type="text" name="diasperiodo" id="diasperiodo" value="<?php echo @$_POST['diasperiodo']?>" style="width:98%;" /></td>
					<td class="saludo1">Incapacidad (%):</td>
					<td >
						<select name="porcinca" id="porcinca" style="width:100%;">
							<option value="">Seleccione ....</option>
							<?php
								$sqlr="SELECT codigo,porcentaje FROM hum_porcentajesinca WHERE estado='S' ";
								$resp = mysqli_query($linkbd,$sqlr);
								while ($row = mysqli_fetch_row($resp))
								{
									if($row[0]==@$_POST['porcinca']){echo "<option value='$row[0]' SELECTED>$row[1]%</option>";}
									else {echo "<option value='$row[0]'>$row[1]%</option>";}
								}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td class="saludo1" >Pagar EPS y AFP:</td>
					<td style="width:7%">
						<div class="swibc">
							<input type="checkbox" name="swibc" class="swibc-checkbox" id="idswibc" value="<?php echo @$_POST['swibc'];?>" <?php if(@$_POST['swibc']=='S'){echo "checked";}?> onChange="cambiocheck('1');"/>
							<label class="swibc-label" for="idswibc">
								<span class="swibc-inner"></span>
								<span class="swibc-switch"></span>
							</label>
						</div>
					</td>
					<td class="saludo1" >Pagar ARL:</td>
					<td style="width:7%">
						<div class="swarl">
							<input type="checkbox" name="swarl" class="swarl-checkbox" id="idswarl" value="<?php echo @$_POST['swarl'];?>" <?php if(@$_POST['swarl']=='S'){echo "checked";}?> onChange="cambiocheck('2');"/>
							<label class="swarl-label" for="idswarl">
								<span class="swarl-inner"></span>
								<span class="swarl-switch"></span>
							</label>
						</div>
					</td>
					<td class="saludo1" >Pagar Parafiscales:</td>
					<td style="width:7%">
						<div class="swparafiscal">
							<input type="checkbox" name="swparafiscal" class="swparafiscal-checkbox" id="idswparafiscal" value="<?php echo @$_POST['swparafiscal'];?>" <?php if(@$_POST['swparafiscal']=='S'){echo "checked";}?> onChange="cambiocheck('3');"/>
							<label class="swparafiscal-label" for="idswparafiscal">
								<span class="swparafiscal-inner"></span>
								<span class="swparafiscal-switch"></span>
							</label>
						</div>
					</td>
				</tr>
				<tr>
					<td><label class="boton01" onClick="fagregar();">&nbsp;&nbsp;Agregar&nbsp;&nbsp;</label></td>
				</tr>
			</table> 
			<input type="hidden" name="oculto" id="oculto" value="1"/>
			<input type="hidden" name="salmin" id="salmin"  value="<?php echo @$_POST['salmin']?>"/>
			<div class="subpantalla" style="height:39%; width:99.5%;overflow-x:hidden" > 
				<table class="inicio" width="99%">
					<tr><td class="titulos" colspan="9">Detalles Incapacidad</td></tr>
					<tr>
						<td class="titulos2" style="width:6%">Item</td>
						<td class="titulos2" style="width:6%">Tipo</td>
						<td class="titulos2" style="width:6%">Vigencia</td>
						<td class="titulos2">Mes</td>
						<td class="titulos2">Dias</td>
						<td class="titulos2">%</td>
						<td class="titulos2">Valor Dia</td>
						<td class="titulos2">Valor Total</td>
						<td class="titulos2" style="width:8%">Eliminar</td>
					</tr>
					<?php
						if (@$_POST['oculto']=='3')
						{
							$posi=$_POST['elimina'];
							if(@$_POST['idinca'][$posi]!="")
							{
								if($_POST['ideliminar']==""){$_POST['ideliminar']=$_POST['idinca'][$posi];}
								else {$_POST['ideliminar']=$_POST['ideliminar']."<->".$_POST['idinca'][$posi];}
							}
							unset($_POST['idinca'][$posi]);
							unset($_POST['viginca'][$posi]);
							unset($_POST['mesinca'][$posi]);
							unset($_POST['diasinca'][$posi]);
							unset($_POST['valordiainca'][$posi]);
							unset($_POST['valorinca'][$posi]);
							unset($_POST['porvinca'][$posi]);
							unset($_POST['tipinca'][$posi]);
							$_POST['idinca']= array_values($_POST['idinca']);
							$_POST['viginca']= array_values($_POST['viginca']);
							$_POST['mesinca']= array_values($_POST['mesinca']);
							$_POST['diasinca']= array_values($_POST['diasinca']);
							$_POST['valordiainca']= array_values($_POST['valordiainca']);
							$_POST['valorinca']= array_values($_POST['valorinca']);
							$_POST['porvinca']= array_values($_POST['porvinca']);
							$_POST['tipinca']= array_values($_POST['tipinca']);
							$_POST['elimina']='';
						}	 
						if (@$_POST['oculto']=='4')
						{
							switch($_POST['tipoinca'])
							{
								case "LR":
									switch($_POST['porcinca'])
									{ 
										case 1:
											$totaldias=$_POST['diasperiodo'];
											$saldia=$_POST['salbas']/30;
											$diasalmin=($_POST['salmin']/30);
											if($totaldias > 2)
											{
												$saldo1=($saldia)*2;
												$saldia2=($saldia*66.667)/100;
												//if($saldia2>=$diasalmin)
												{$saldia2g=$saldia2;}
												//else {$saldia2g=$diasalmin;}
												$saldo2=$saldia2g*($totaldias-2);
												//100%
												$_POST['idinca'][]="";
												$_POST['viginca'][]=$_POST['vigenciat'];
												$_POST['mesinca'][]=$_POST['periodo'];
												$_POST['diasinca'][]=2;
												$_POST['valordiainca'][]=$saldia;
												$_POST['valorinca'][]=$saldo1;
												$_POST['porvinca'][]=100;
												$_POST['tipinca'][]=$_POST['tipoinca'];
												//66,667%
												$_POST['idinca'][]="";
												$_POST['viginca'][]=$_POST['vigenciat'];
												$_POST['mesinca'][]=$_POST['periodo'];
												$_POST['diasinca'][]=$totaldias-2;
												$_POST['valordiainca'][]=$saldia2g;
												$_POST['valorinca'][]=$saldo2;
												$_POST['porvinca'][]=66.667;
												$_POST['tipinca'][]=$_POST['tipoinca'];
											}
											else
											{
												$saldo1=($saldia)*$totaldias;
												$_POST['idinca'][]="";
												$_POST['viginca'][]=$_POST['vigenciat'];
												$_POST['mesinca'][]=$_POST['periodo'];
												$_POST['diasinca'][]=$totaldias;
												$_POST['valordiainca'][]=$saldia;
												$_POST['valorinca'][]=$saldo1;
												$_POST['porvinca'][]=100;
												$_POST['tipinca'][]=$_POST['tipoinca'];
											}
											break;
										case 2:
											$saldia=$_POST['salbas']/30;
											$totaldias=$_POST['diasperiodo'];
											$diasalmin=($_POST['salmin']/30);
											$saldia2=($saldia*66.667)/100;
											if($saldia2>=$diasalmin){$saldia2g=$saldia2;}
											else {$saldia2g=$diasalmin;}
											$saldo2=$saldia2g*($totaldias);
											//66,667%
											$_POST['idinca'][]="";
											$_POST['viginca'][]=$_POST['vigenciat'];
											$_POST['mesinca'][]=$_POST['periodo'];
											$_POST['diasinca'][]=$totaldias;
											$_POST['valordiainca'][]=$saldia2g;
											$_POST['valorinca'][]=$saldo2;
											$_POST['porvinca'][]=66.667;
											$_POST['tipinca'][]=$_POST['tipoinca'];
											break;
										case 3:
											$saldia=$_POST['salbas']/30;
											$totaldias=$_POST['diasperiodo'];
											$diasalmin=($_POST['salmin']/30);
											$saldia2=($saldia*50)/100;
											if($saldia2>=$diasalmin){$saldia2g=$saldia2;}
											else {$saldia2g=$diasalmin;}
											$saldo2=$saldia2g*($totaldias);
											//50%
											$_POST['idinca'][]="";
											$_POST['viginca'][]=$_POST['vigenciat'];
											$_POST['mesinca'][]=$_POST['periodo'];
											$_POST['diasinca'][]=$totaldias;
											$_POST['valordiainca'][]=$saldia2g;
											$_POST['valorinca'][]=$saldo2;
											$_POST['porvinca'][]=50;
											$_POST['tipinca'][]=$_POST['tipoinca'];
											break;
										case 4:
											$_POST['idinca'][]="";
											$_POST['viginca'][]=$_POST['vigenciat'];
											$_POST['mesinca'][]=$_POST['periodo'];
											$_POST['diasinca'][]=$_POST['diasperiodo'];
											$_POST['valordiainca'][]=0;
											$_POST['valorinca'][]=0;
											$_POST['porvinca'][]=0;
											$_POST['tipinca'][]=$_POST['tipoinca'];
									}
									break;
								case "LNR":
									$_POST['idinca'][]="";
									$_POST['viginca'][]=$_POST['vigenciat'];
									$_POST['mesinca'][]=$_POST['periodo'];
									$_POST['diasinca'][]=$_POST['diasperiodo'];
									$_POST['valordiainca'][]=0;
									$_POST['valorinca'][]=0;
									$_POST['porvinca'][]=0;
									$_POST['tipinca'][]=$_POST['tipoinca'];
									break;
								case "LM":
								case "LP":
									$totaldias=$_POST['diasperiodo'];
									$saldia=$_POST['salbas']/30;
									$saldo1=$saldia*$totaldias;
									//100%
									$_POST['idinca'][]="";
									$_POST['viginca'][]=$_POST['vigenciat'];
									$_POST['mesinca'][]=$_POST['periodo'];
									$_POST['diasinca'][]=$totaldias;
									$_POST['valordiainca'][]=$saldia;
									$_POST['valorinca'][]=$saldo1;
									$_POST['porvinca'][]=100;
									$_POST['tipinca'][]=$_POST['tipoinca'];
									break;
							}
						}
					?>
					<input type='hidden' name='elimina' id='elimina'/>
					<?php
						$co="saludo1a";
						$co2="saludo2";
						$sumtotal=0;
						$_POST['totalinca']=count($_POST['valorinca']);
						$_POST['mestemp']="";
						$_POST['mesletras']="";
						$_POST['totaldiasinca']=0;
						for ($x=0;$x<$_POST['totalinca'];$x++)
						{
							echo "
							<input type='hidden' name='idinca[]' value='".@$_POST['idinca'][$x]."'/>
							<input type='hidden' name='mesinca[]' value='".@$_POST['mesinca'][$x]."'/>
							<input type='hidden' name='diasinca[]' value='".@$_POST['diasinca'][$x]."'/>
							<input type='hidden' name='valordiainca[]' value='".@$_POST['valordiainca'][$x]."'/>
							<input type='hidden' name='valorinca[]' value='".@$_POST['valorinca'][$x]."'/>
							<input type='hidden' name='porvinca[]' value='".@$_POST['porvinca'][$x]."'/>
							<input type='hidden' name='tipinca[]' value='".@$_POST['tipinca'][$x]."'/>
							<tr class='$co'>
								<td style='text-align:right;'>".($x+1)."&nbsp;</td>
								<td style='text-align:center;'>".$_POST['tipinca'][$x]."</td>
								<td style='text-align:right;'><input type='text' name='viginca[]' value='".@$_POST['viginca'][$x]."' style='text-align:right; width:100%' class='inpnovisibles'/></td>
								<td style='text-align:right;'>".$_POST['mesinca'][$x]."&nbsp;</td>
								<td style='text-align:right;'>".$_POST['diasinca'][$x]."&nbsp;</td>
								<td style='text-align:right;'>".$_POST['porvinca'][$x]."&nbsp;</td>
								<td style='text-align:right;'>$ ".number_format($_POST['valordiainca'][$x],0)."&nbsp;</td>
								<td style='text-align:right;'>$ ".number_format($_POST['valorinca'][$x],0)."&nbsp;</td>
								<td style='text-align:center;'><img src='imagenes/del.png' onclick='eliminar($x)' class='icoop'></td>
							</tr>";
							$_POST['totaldiasinca']+=$_POST['diasinca'][$x];
							$sumtotal+=$_POST['valorinca'][$x];
							$aux=$co;
							$co=$co2;
							$co2=$aux;
							if($_POST['mestemp']=="")
							{
								$_POST['mesletras']=mesletras($_POST['mesinca'][$x]);
								$_POST['mestemp']=$_POST['mesinca'][$x];
							}
							elseif($_POST['mestemp']!=$_POST['mesinca'][$x])
							{
								$_POST['mesletras']=$_POST['mesletras']." - ".mesletras($_POST['mesinca'][$x]);
								$_POST['mestemp']=$_POST['mesinca'][$x];
							}
						}
						$totalred=round($sumtotal, 0, PHP_ROUND_HALF_UP);
						$_POST['valinca']=$totalred;
						$resultado = convertir($totalred);
						echo "
						<tr class='$co' style='text-align:right;'>
							<td colspan='7'>Total:</td>
							<td>$ ".number_format($sumtotal,0)."</td>
						 </tr>
						<tr class='titulos2'>
							<td>Son:</td>
							<td colspan='8'>$resultado PESOS</td>
						</tr>";
				?>
					<input type="hidden" name="valinca" value="<?php echo @$_POST['valinca']?>"/>
					<input type="hidden" name="totalinca" id="totalinca" value="<?php echo @$_POST['totalinca']?>"/>
					<input type="hidden" name="mesletras" value="<?php echo @$_POST['mesletras']?>"/>
					<input type="hidden" name="mestemp" value="<?php echo @$_POST['mestemp']?>"/>
					<input type="hidden" name="totaldiasinca" value="<?php echo @$_POST['totaldiasinca']?>"/>
					<input type="hidden" name="ideliminar" value="<?php echo @$_POST['ideliminar']?>"/>
					<input type="hidden" name="maximo" id="maximo" value="<?php echo @$_POST['maximo'] ?>"/>
					<input type="hidden" name="minimo" id="minimo" value="<?php echo @$_POST['minimo'] ?>"/>
				</table>
			</div>  
			<?php
				if(@$_POST['oculto']==2)
				{
					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST['fechai'],$fecha);
					$fechai="$fecha[3]-$fecha[2]-$fecha[1]";
					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST['fechaf'],$fecha);
					$fechaf="$fecha[3]-$fecha[2]-$fecha[1]";
					if($_POST['swibc']=='S'){$pagoibc='S';}
					else {$pagoibc='N';}
					if($_POST['swarl']=='S'){$pagoarl='S';}
					else {$pagoarl='N';}
					if($_POST[swparafiscal]=='S'){$pagopara='S';}
					else {$pagopara='N';}
					$sqlr="UPDATE hum_incapacidades SET cod_inca_n='".$_POST['incaeps']."',cod_inca_a='".$_POST['incaepsant']."',fecha_ini='$fechai', fecha_fin='$fechaf',tipo_inca='".$_POST['tipoinca']."',valor_total='".$_POST['valinca']."',paga_ibc='$pagoibc',paga_arl='$pagoarl',paga_para='$pagopara', meses='".$_POST['mesletras']."',dias_total='".$_POST['totaldiasinca']."' WHERE num_inca='".$_POST['idcomp']."'";
					if (mysqli_query($linkbd,$sqlr))
					{
						echo "<script>despliegamodalm('visible','3','Se ha modificado con Exito la Incapacidad');</script>";
						for($y=0;$y<$_POST['totalinca'];$y++)
						{
							if($_POST['idinca'][$y]=="")
							{
								$consdet=selconsecutivo('hum_incapacidades_det','id_det');
								$sqlr1="INSERT INTO hum_incapacidades_det (id_det,doc_funcionario,num_inca,tipo_inca,vigencia,mes,dias_inca, porcentaje,valor_dia,valor_total,pagar_ibc,pagar_arl,pagar_para,estado) VALUES ('$consdet','".$_POST['tercero']."','".$_POST['idcomp']."','".$_POST['tipinca'][$y]."','".$_POST['viginca'][$y]."','".$_POST['mesinca'][$y]."','".$_POST['diasinca'][$y]."','".$_POST['porvinca'][$y]."','".$_POST['valordiainca'][$y]."','".$_POST['valorinca'][$y]."','$pagoibc','$pagoarl','$pagopara','S')";
								mysqli_query($linkbd,$sqlr1);
							}
							else
							{
								$sqlr1="UPDATE hum_incapacidades_det SET vigencia='".$_POST['viginca'][$y]."',pagar_ibc='$pagoibc', pagar_arl='$pagoarl',pagar_para='$pagopara' WHERE id_det='".$_POST['idinca'][$y]."'";
								mysqli_query($linkbd,$sqlr1);
							}
						}
						$ideli = explode('<->', $_POST['ideliminar']);
						$totaleli=count($ideli);
						for($y=0;$y<$totaleli;$y++)
						{
							$sqlr1="UPDATE hum_incapacidades_det SET estado='D' WHERE id_det='$ideli[$y]'";
							mysqli_query($linkbd,$sqlr1);
						}
					}
					else {echo"<script>despliegamodalm('visible','2','Error al Almacenar Incapacidad');</script>";}
				}
			?>
		</form>
	</body>
</html>