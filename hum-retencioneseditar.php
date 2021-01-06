<?php
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=utf8");
	require 'comun.inc';
	require 'funciones.inc';
	require 'conversor.php';
	require_once '/controllers/HumRetencionesNominaController.php';
	require_once '/controllers/TesoRetencionesController.php';
	require_once '/controllers/MesesController.php';
	sesion();
	$linkbd=conectar_v7();
	cargarcodigopag(@$_GET['codpag'],@$_SESSION["nivel"]);
	date_default_timezone_set("America/Bogota");
	//error_reporting(E_ALL);
	//ini_set('display_errors', '1');
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
		<meta http-equiv="Content-Type" content="text/html" charset="utf8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Spid - Gestion Humana</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script type="text/javascript" src="css/calendario.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<style>
			input[type='text']{height:30px;}
			select{height:30px;}
		</style>
		<script>
			function guardar()
			{
				var tret=document.form2.tiporete.value;
				var terc=document.form2.tercero.value;
				var tern=document.form2.ntercero.value;
				var salb=document.form2.salbas.value;
				var valr=document.form2.valrete.value;
				var mesr=document.form2.periodo.value;
				var vigr=document.form2.vigencia.value;
				if((tret.trim() != '') && (terc.trim() != '') && (tern.trim() != '') && (salb.trim() != '') && (valr.trim() != '') && (mesr.trim() != '') && (vigr.trim() != ''))
				{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
				else{despliegamodalm('visible','2','Falta asignar retenciones a un funcionario');}
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
			function funcionmensaje(){document.location.href = "hum-retencionesbuscar.php";}
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
			function despliegamodal2(_valor,_num)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else 
				{	
					document.getElementById('ventana2').src="cargafuncionarios-ventana03.php?objeto=tercero";
				}
			}
			function fagregar()
			{
				var vvigencia=document.form2.vigencia.value;
				if(document.form2.tiporete.value!="-1")
				{
					if(document.form2.ntercero.value!="")
					{
						if(document.form2.valrete.value!="")
						{
							if(vvigencia.length>="4")
							{
								document.form2.oculto.value="4";
								document.form2.submit();
							}
							else{despliegamodalm('visible','2','Falta asignar la vigencia');}
						}
						else{despliegamodalm('visible','2','Falta asignar el valor de la retención');}
					}
					else{despliegamodalm('visible','2','Falta asignar un funcionario');}
				
				}
				else{despliegamodalm('visible','2','Falta seleccionar el tipo de retención');}
			}
			function eliminar(variable)
			{
				document.getElementById('elimina').value=variable;
				despliegamodalm('visible','4','Esta Seguro de Eliminar','2');
			}
			function atrasc(scrtop,numpag,limreg,filtro,totreg,altura)
			{
				var codig = document.form2.codigo.value;
				var minim = document.form2.minimo.value;
				codig=parseFloat(codig)-1;
				if(codig => minim){location.href="hum-retencioneseditar.php?idban=" + codig + "&scrtop=" + scrtop + "&totreg=" + totreg +  "&altura=" + altura + "&numpag=" + numpag + "&limreg=" + limreg + "&filtro=" + filtro;}
			}
			function adelante(scrtop,numpag,limreg,filtro,totreg,altura)
			{
				var codig = document.form2.codigo.value;
				var maxim = document.form2.maximo.value;
				codig=parseFloat(codig)+1;
				if(codig <= maxim){location.href="hum-retencioneseditar.php?idban=" + codig + "&scrtop=" + scrtop + "&totreg=" + totreg +  "&altura=" + altura + "&numpag=" + numpag + "&limreg=" + limreg + "&filtro=" + filtro;}
			}
			function iratras(scrtop,numpag,limreg,filtro,totreg,altura)
			{
				var codig=document.getElementById('codigo').value;
				location.href="hum-retencionesbuscar.php?idban=" + codig + "&scrtop=" + scrtop + "&totreg=" + totreg + "&altura=" + altura + "&numpag=" + numpag + "&limreg=" + limreg + "&filtro=" + filtro;
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
				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='hum-retencionesagregar.php'" class="mgbt"/><img src="imagenes/guarda.png" title="Guardar" onClick="guardar()" class="mgbt"/><img src="imagenes/busca.png" title="Buscar" onClick="location.href='hum-retencionesbuscar.php'" class="mgbt"/><img src="imagenes/nv.png" title="nueva ventana"  class="mgbt" onClick="mypop=window.open('hum-principal.php','','');mypop.focus();"><img src='imagenes/iratras.png' title='Men&uacute; Nomina' class='mgbt'  onClick="iratras(<?php echo "'$scrtop','$numpag','$limreg','$filtro','$totreg','$altura'"; ?>)"/></td>
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
				
				if(@$_POST['oculto']=='')
				{
					$registrosretenciones = new HumRetencionesNominaController();
					$registrosretenciones -> generarAllRetencionesNomina($_GET['idban'],'id');
					$tablaretenciones = $registrosretenciones -> allretencionesnomina;
					$_POST['fecha'] = date('d-m-Y',strtotime($tablaretenciones[0]['fecha']));
					$_POST['periodo'] = $tablaretenciones[0]['mes'];
					$_POST['vigencia'] = $tablaretenciones[0]['vigencia'];
					$_POST['tiporete'] = $tablaretenciones[0]['tiporetencion'];
					$_POST['tercero'] = $tablaretenciones[0]['docfuncionario'];
					$_POST['ntercero'] = $tablaretenciones[0]['nomfuncionario'];
					$_POST['salbas'] = $tablaretenciones[0]['salbasico'];
					$_POST['valrete'] = $tablaretenciones[0]['valorretencion'];
					$_POST['codigo'] = $_GET['idban'];
					$maxretenciones = new HumRetencionesNominaController();
					$maxretenciones -> generarMaxRetencionesNomina();
					$_POST['maximo'] = $maxretenciones -> maxretencionesnomina;
					$minretenciones = new HumRetencionesNominaController();
					$minretenciones -> generarMinRetencionesNomina();
					$_POST['minimo'] = $minretenciones -> minretencionesnomina;
				}
				if(@$_POST['bt']=='1')
				{
					$nresul=buscatercero($_POST['tercero']);
					if($nresul!='')
					{
						$_POST['ntercero']=$nresul;
						$sqlr="
						SELECT codfun, GROUP_CONCAT(descripcion ORDER BY CONVERT(valor, SIGNED INTEGER) SEPARATOR '<->')
						FROM hum_funcionarios
						WHERE (item = 'VALESCALA') AND codfun=(SELECT codfun FROM hum_funcionarios WHERE descripcion='".$_POST['tercero']."' AND estado='S') AND estado='S'
						GROUP BY codfun";
						$resp2 = mysqli_query($linkbd,$sqlr);
						$row2 =mysqli_fetch_row($resp2);
						$_POST['salbas']=$row2[1];
					}
					else {$_POST['ntercero']="";}
				}
			?>
			<table  class="inicio" style="width:99.7%;">
				<tr>
					<td class="titulos" colspan="10">:: Retenciones Funcionarios</td>
					<td class="cerrar" style="width:7%" onClick="location.href='hum-principal.php'">Cerrar</td>
				</tr>
				<tr>
					<td class="tamano01" style="width: 2.5cm;">C&oacute;digo:</td>
					<td style="width:12%;"><img src="imagenes/back.png" onClick="atrasc(<?php echo "'$scrtop','$numpag','$limreg','$filtro','$totreg','$altura'"; ?>)" class="icobut" title="Anterior"/>&nbsp;<input name="codigo" id="codigo" type="text" value="<?php echo @$_POST['codigo']?>" maxlength="2" size="2" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly>&nbsp;<img src="imagenes/next.png" onClick="adelante(<?php echo "'$scrtop','$numpag','$limreg','$filtro','$totreg','$altura'"; ?>)" class="icobut" title="Sigiente"/></td>
					<td class="tamano01"  style="width:4cm;">Fecha Registro:</td>
					<td style="width:12%"><input type="text" name="fecha" value="<?php echo @$_POST['fecha']?>" style="width:98%;" readonly/></td>
					<td class="tamano01" style="width:3.5cm;">Tipo Retenci&oacute;n:</td>
					<td colspan="5">
						<select name="tiporete" id="tiporete" style="width:100%;" >
							<option value="-1">Seleccione ....</option>
							<?php 
								$nomcampos=array("estado", "nomina");//CAMPOS A CONSULTAR
								$numvalores=array("S", "1");//VALORES DE LOS CAMPOS A VALIDAR
								$cargartesoretenciones = new TesoRetencionesController();
								$cargartesoretenciones -> generarAllTesoRetenciones($numvalores,$nomcampos);
								$tablatesoretenciones = $cargartesoretenciones -> alltesoretenciones;
								$ttesoretenciones=count($tablatesoretenciones);
								for($x=0;$x<$ttesoretenciones;$x++)
								{
									if($tablatesoretenciones[$x]['id']==$_POST['tiporete'])
									{
										echo "<option value='".$tablatesoretenciones[$x]['id']."' SELECTED>".$tablatesoretenciones[$x]['codigo']." - ".$tablatesoretenciones[$x]['nombre']."</option>";
										$_POST['ntiporete']=$tablatesoretenciones[$x]['codigo'];
									}
									else{echo "<option value='".$tablatesoretenciones[$x]['id']."'>".$tablatesoretenciones[$x]['codigo']." - ".$tablatesoretenciones[$x]['nombre']."</option>";}
								}
							?>
						</select>
						<input type="hidden" name="ntiporete" id="ntiporete" value="<?php echo $_POST['ntiporete']?>" />
					</td>
				</tr>
				<tr>
					<td class="saludo1">Funcionario:</td>
 					<td><input type="text" id="tercero" name="tercero" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo @$_POST['tercero']?>" style="width:80%;"/>&nbsp;&nbsp;<img class="icobut" src="imagenes/find02.png"  title="Listado Terceros" onClick="despliegamodal2('visible');"/></td>
					<td colspan="8"><input type="text" name="ntercero" id="ntercero" value="<?php echo @$_POST['ntercero']?>" style="width: 100%;" readonly/></td>
				</tr>
				<tr>
					<td class="saludo1">Salario B&aacute;sico:</td>
					<td><input type="text" name="salbas" id="salbas" value="<?php echo @$_POST['salbas']?>" style="width:100%;" readonly/></td>
					<td class="saludo1">Valor Retenci&oacute;n:</td>
					<td style="width:12%;"><input type="text" name="valrete" id="valrete" value="<?php echo @$_POST['valrete']?>" style="width:100%;" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"/></td>
					<td class="saludo1" style="width:2.5cm;">Mes:</td>
					<td style="width:12%;">
						<select name="periodo" id="periodo" style="width:100%">
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
										$_POST['nmes']=$tablameses[$x]['nombre'];
									}
									else{echo "<option value='".$tablameses[$x]['id']."'>".$tablameses[$x]['nombre']."</option>";}
								}
							?>
						</select>
						<input type="hidden" name="nmes" id="nmes" value="<?php echo @$_POST['nmes'];?>" />
					</td>
					<td class="saludo1" style="width:2.5cm;">Vigencia:</td>
					<td><input type="text" name="vigencia" id="vigencia" value="<?php echo @$_POST['vigencia']?>" maxlength="4" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"/></td>
					<td></td>
				</tr>
				<tr></tr>
			</table>
			<?php
				if(@$_POST['oculto']=="2")
				{
					$actualizaretenciones = new HumRetencionesNominaController();
					$actualizaretenciones -> actualizarRetencinesNomina();
					$tablaretenciones = $actualizaretenciones -> actualizaretencionesnomina;
					if(!$tablaretenciones){echo"<script>despliegamodalm('visible','2','Error al Editar Retenciones');</script>";}
					else {echo "<script>despliegamodalm('visible','3','Se Edito la Retenci\\xf3n Exitosamente');</script>";}
				}
			?>
			<input type="hidden" name="maximo" id="maximo" value="<?php echo @$_POST['maximo'] ?>"/>
			<input type="hidden" name="minimo" id="minimo" value="<?php echo @$_POST['minimo'] ?>"/>
			<input type="hidden" name="bt" id="bt" value="0"/>
			<input type="hidden" name="oculto" id="oculto" value="1"/>
		</form>
		<div id="bgventanamodal2">
			<div id="ventanamodal2">
				<IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"></IFRAME>
			</div>
		</div>
	</body>
</html>