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
				valord=document.getElementsByName('tfecha[]');
				if(valord.length>0){despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
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
				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='hum-retencionesagregar.php'" class="mgbt"/><img src="imagenes/guarda.png" title="Guardar" onClick="guardar()" class="mgbt"/><img src="imagenes/busca.png" title="Buscar" onClick="location.href='hum-retencionesbuscar.php'" class="mgbt"/><img src="imagenes/nv.png" title="nueva ventana" class="mgbt" onClick="mypop=window.open('hum-principal.php','','');mypop.focus();"><img src='imagenes/iratras.png' title='Men&uacute; Nomina' class='mgbt' onClick="location.href='hum-menunomina.php'"/></td>
			</tr>
		</table>
		<div id="bgventanamodalm" class="bgventanamodalm">
			<div id="ventanamodalm" class="ventanamodalm">
				<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"></IFRAME>
			</div>
		</div>
		<form name="form2" method="post" action="">
			<?php 
				if(@$_POST['oculto']=='')
				{
					$_POST['fecha']=date("d/m/Y");
					$_POST['periodo']=date("m");
					$_POST['vigencia']=date("Y");
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
					<td style="width:7%"><label class="boton02" onClick="location.href='hum-principal.php'">Cerrar</label></td>
				</tr>
				<tr>
					<td class="tamano01" style="width:4cm;">Fecha Registro:</td>
					<td style="width:12%"><input type="text" name="fecha" value="<?php echo @$_POST['fecha']?>" style="width:98%;" readonly/></td>
					<td class="tamano01" style="width:3.5cm;">Tipo Retenci&oacute;n:</td>
					<td colspan="7">
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
						<input type="hidden" name="ntiporete" id="ntiporete" value="<?php echo @$_POST['ntiporete']?>" />
					</td>
				</tr>
				<tr>
					<td class="tamano01">Funcionario:</td>
					<td><input type="text" id="tercero" name="tercero" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo @$_POST['tercero'];?>" style="width:80%;"/>&nbsp;&nbsp;<img class="icobut" src="imagenes/find02.png"  title="Listado Terceros" onClick="despliegamodal2('visible');"/></td>
					<td colspan="8"><input type="text" name="ntercero" id="ntercero" value="<?php echo @$_POST['ntercero'];?>" style="width: 100%;" readonly/></td> 
				</tr>
				<tr>
					<td class="tamano01">Salario B&aacute;sico:</td>
					<td><input type="text" name="salbas" id="salbas" value="<?php echo @$_POST['salbas'];?>" style="width:100%;" readonly/></td>
					<td class="tamano01">Valor Retenci&oacute;n:</td>
					<td style="width:12%;"><input type="text" name="valrete" id="valrete" value="<?php echo @$_POST['valrete']?>" style="width:100%;" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"/></td>
					<td class="tamano01" style="width:2.5cm;">Mes:</td>
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
						<input type="hidden" name="nmes" id="nmes" value="<?php echo $_POST['nmes']?>" />
					</td>
					<td class="tamano01" style="width:2.5cm;">Vigencia:</td>
					<td><input type="text" name="vigencia" id="vigencia" value="<?php echo $_POST['vigencia']?>" maxlength="4" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"/></td>
					<td></td>
				</tr>
				<tr><td colspan="2" style="padding-bottom:0px;height:35px;"><em class="botonflecha" onClick="fagregar();">Agregar</em></td></tr>
			</table>
			<div class="subpantalla" style="height:50.5%; width:99.5%;overflow-x:hidden;">
				<table class="inicio">
					<tr><td class="titulos" colspan="9">Retenciones Asignadas a Funcionarios</td></tr>
					<tr>
						<td class="titulos2" style="width:5%;">Item</td>
						<td class="titulos2" style="width:5%;">T.R.</td>
						<td class="titulos2" style="width:10%;">Documento</td>
						<td class="titulos2">Nombre Funcionario</td>
						<td class="titulos2" style="width:10%;">Salario B&aacute;sico</td>
						<td class="titulos2" style="width:10%;">Valor Retenci&oacute;n</td>
						<td class="titulos2" style="width:10%;">Mes</td>
						<td class="titulos2" style="width:5%;">Vigencia</td>
						<td class="titulos2" style="width:3%;text-align:center;"><img src="imagenes/del.png"/></td>
					</tr>
				<?php
					if (@$_POST['oculto']=='3')
					{ 
						$posi=$_POST['elimina'];
						unset($_POST['tfecha'][$posi]);
						unset($_POST['ttreste'][$posi]);
						unset($_POST['tntreste'][$posi]);
						unset($_POST['ttercero'][$posi]);
						unset($_POST['tntercero'][$posi]);
						unset($_POST['tsalbas'][$posi]);
						unset($_POST['tvalrete'][$posi]);
						unset($_POST['tperiodo'][$posi]);
						unset($_POST['tnmes'][$posi]);
						unset($_POST['tvigencia'][$posi]);
						$_POST['tfecha']= array_values($_POST['tfecha']); 
						$_POST['ttreste']= array_values($_POST['ttreste']);
						$_POST['tntreste']= array_values($_POST['tntreste']);
						$_POST['ttercero']= array_values($_POST['ttercero']);
						$_POST['tntercero']= array_values($_POST['tntercero']);
						$_POST['tsalbas']= array_values($_POST['tsalbas']);
						$_POST['tvalrete']= array_values($_POST['tvalrete']);
						$_POST['tperiodo']= array_values($_POST['tperiodo']);
						$_POST['tnmes']= array_values($_POST['tnmes']);
						$_POST['tvigencia']= array_values($_POST['tvigencia']);
						$_POST['elimina']='';
					}
					if (@$_POST['oculto']=='4')
					{
						$_POST['tfecha'][]=$_POST['fecha'];
						$_POST['ttreste'][]=$_POST['tiporete'];
						$_POST['tntreste'][]=$_POST['ntiporete'];
						$_POST['ttercero'][]=$_POST['tercero'];
						$_POST['tntercero'][]=$_POST['ntercero'];
						$_POST['tsalbas'][]=$_POST['salbas'];
						$_POST['tvalrete'][]=$_POST['valrete'];
						$_POST['tperiodo'][]=$_POST['periodo'];
						$_POST['tnmes'][]=$_POST['nmes'];
						$_POST['tvigencia'][]=$_POST['vigencia'];
						echo"
		 				<script>
							document.form2.tercero.value='';	
							document.form2.ntercero.value='';	
							document.form2.salbas.value='';	
							document.form2.valrete.value='';	
							document.form2.tercero.select();
		 				</script>";
		 				
					}	
					$co="saludo1a";
		  			$co2="saludo2";
					for ($x=0;$x<count(@$_POST['tfecha']);$x++)
					{
						echo "
						<input type='hidden' name='tfecha[]' value='".@$_POST['tfecha'][$x]."'/>
						<input type='hidden' name='ttreste[]' value='".@$_POST['ttreste'][$x]."'/>
						<input type='hidden' name='tntreste[]' value='".@$_POST['tntreste'][$x]."'/>
						<input type='hidden' name='ttercero[]' value='".@$_POST['ttercero'][$x]."'/>
						<input type='hidden' name='tntercero[]' value='".@$_POST['tntercero'][$x]."'/>
						<input type='hidden' name='tsalbas[]' value='".@$_POST['tsalbas'][$x]."'/>
						<input type='hidden' name='tvalrete[]' value='".@$_POST['tvalrete'][$x]."'/>
						<input type='hidden' name='tperiodo[]' value='".@$_POST['tperiodo'][$x]."'/>
						<input type='hidden' name='tnmes[]' value='".@$_POST['tnmes'][$x]."'/>
						<input type='hidden' name='tvigencia[]' value='".@$_POST['tvigencia'][$x]."'/>
						<tr class='$co'>
							<td class='icoop' style='text-align:right;' >".($x+1)."&nbsp;</td>
							<td class='icoop' style='text-align:right;'>".$_POST['tntreste'][$x]."&nbsp;</td>
							<td class='icoop' style='text-align:right;'>".number_format($_POST['ttercero'][$x],0)."&nbsp;</td>
							<td class='icoop' >".$_POST['tntercero'][$x]."&nbsp;</td>
							<td class='icoop' style='text-align:right;'>$ ".number_format($_POST['tsalbas'][$x],0)."&nbsp;</td>
							<td class='icoop' style='text-align:right;'>$ ".number_format($_POST['tvalrete'][$x],0)."&nbsp;</td>
							<td class='icoop' >".$_POST['tnmes'][$x]."&nbsp;</td>
							<td class='icoop' style='text-align:right;'>".$_POST['tvigencia'][$x]."&nbsp;</td>
							<td class='icoop' style='text-align:center;'><img src='imagenes/del.png' onclick='eliminar($x)'></td>
						</tr>";
						$aux=$co;
						$co=$co2;
						$co2=$aux;
					}
				?>
				</table>
			</div>
			<?php
				if(@$_POST['oculto']=="2")
				{
					$guardaretenciones = new HumRetencionesNominaController();
					$guardaretenciones -> guardarRetencinesNomina();
					$tablaretenciones = $guardaretenciones -> saveretencionesnomina;
					if($tablaretenciones>0){echo"<script>despliegamodalm('visible','2','Error al Almacenar $tablaretenciones Retenciones');</script>";}
					else {echo "<script>despliegamodalm('visible','1','Se  Almacenaron todas las Retenciones Exitosamente');</script>";}
				}
			?>
			<input type="hidden" name="bt" id="bt" value="0"/>
			<input type='hidden' name='elimina' id='elimina'/>
			<input type="hidden" name="oculto" id="oculto" value="1"/>
		</form>
		<div id="bgventanamodal2">
			<div id="ventanamodal2">
				<IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"></IFRAME>
			</div>
		</div>
	</body>
</html>