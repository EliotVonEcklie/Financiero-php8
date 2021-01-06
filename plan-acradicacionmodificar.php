<?php
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=iso-8859-1");
	require 'comun.inc';
	require 'funciones.inc';
	sesion();
	$linkbd=conectar_bd();
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	date_default_timezone_set("America/Bogota");
    //error_reporting(E_ALL);
    //ini_set('display_errors', '1');
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
		<script type="text/javascript" src="funcioneshf.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script type='text/javascript' src='JQuery/jquery-2.1.4.min.js?<?php echo date('d_m_Y_h_i_s');?>'></script>
		<script type="text/javascript" src="JQuery/alphanum/jquery.alphanum.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<style>
			input[type='text']{height:30px;}
			input[type='search']{height:30px;}
			select{height:30px;}
		</style>
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
			function busquedajs(tipo)
			{
				if(tipo=="1"){if (document.form2.tercero.value!=""){document.form2.busquedas.value=tipo;document.form2.submit();}}
				else {if (document.form2.responsable.value!=""){document.form2.busquedas.value=tipo;document.form2.submit();}}
			}
			function despliegamodal2(_valor,_tipo)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else if(_tipo=="1"){document.getElementById('ventana2').src="plan-actercerosas.php";}
				else {document.getElementById('ventana2').src="plan-acresponsables.php";}
			}
			function buscares(e)
			{
				if (document.form2.responsable.value!="")
				{
					document.form2.bres.value='1';
					document.form2.submit();
				}
			}
			function numradicado(d)
			{
				var diab=d.getDate();
				var semb=d.getDay();
				var mesb=d.getMonth()+1;
				var anob=d.getFullYear();
				if (mesb <10) mesb="0"+mesb;
				return(anob+""+mesb+""+diab);
			}
			function cambiolecesc(id,estado)
			{
				document.form2.idelimina.value=id;
				document.form2.camestado.value=estado;
				if(estado=="E")
					{despliegamodalm('visible','4','Seguro de cambiar el estado a "Solo Lectura"','4');}
				else
					{
						if (document.getElementById('tirespuesta').value!="0")
							{despliegamodalm('visible','4','Seguro de cambiar el estado a "Responder la Solicitud"','4');}
						else {despliegamodalm('visible','2','No se puede cambiar el estado');}
						
					}
			}
			function agresponsable()
			{
				if(document.form2.nresponsable.value!="")
				{
					document.getElementById('ban01').value=parseInt(document.getElementById('ban01').value)+1;
					document.form2.agresp.value=1;
					document.form2.submit();
				}
			 	else {despliegamodalm('visible','2','Falta informaci\xf3n del Responsable para poder Agregar');}	
				
			}
			function eliresponsable(variable)
			{
				document.form2.idelimina.value=variable;
				despliegamodalm('visible','4','Seguro de Eliminar este Responsable','2');
			}
			function agregardocumento()
			{
				if(document.form2.nomarch.value!="")
				{
					document.getElementById('banmlg').value=parseInt(document.getElementById('banmlg').value)+1;
					document.form2.agregamlg.value=1;
					document.form2.submit();
				}
			 	else {despliegamodalm('visible','2','Falta informaci\xf3n para poder Agregar');}	
			}
			function eliminarml(variable)
			{
				document.form2.idelimina.value=variable;
				despliegamodalm('visible','4','Seguro de Eliminar esta Archivo Adjunto','1');
			}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					
					case "1"://Eliminar Archivo Adjunto de la lista
						document.getElementById('banmlg').value=parseInt(document.getElementById('banmlg').value)-1;
						document.form2.iddelad.value=document.form2.idelimina.value;
						document.form2.submit();
						break;
					case "2"://Eliminar Responsable de la lista
						document.getElementById('ban01').value=parseInt(document.getElementById('ban01').value)-1;
						document.form2.eliminaml.value=document.form2.idelimina.value;
						document.form2.submit();
						break;
					case "3"://Guardar Radicación
						document.form2.oculto.value="1";
						document.form2.submit();
						break;
					case "4"://Modificar Estado Lectura Escritura Responsables
						document.form2.modestado.value=document.form2.idelimina.value;
						document.form2.submit();
						break;
				}
			}
			function guardar()
			{
				var conproce="no";
				if(document.getElementById('tirespuesta').value!="0")
					if(document.getElementById('actescritura').value=="si"){conproce="si";}
					else {despliegamodalm('visible','2','Debe asignar un Responsable para dar respuesta a la solicitud');}
				else	
					if(document.getElementById('actescritura').value=="no"){conproce="si";}
					else{despliegamodalm('visible','2','Todos los responsables deben ser del tipo "Solo Lectura" ');}
				if( document.form2.adjuntosn.value=="S")
				{
					if( document.form2.contadjuntos.value!="0"){var pasoadj="SI";}
					else {var pasoadj="NO";}
				}
				else {var pasoadj="SI";}
				if(conproce=="si")
				{
					if(document.form2.tradicacion.value!="")
						if(document.form2.ntercero.value!="")
							if(document.form2.raddescri.value!="")
								if(document.getElementById('ban01').value!=0)
									if( document.form2.contarch.value!="")
										if( pasoadj=="SI"){despliegamodalm('visible','4','Est\xe1 Seguro de Guardar la Radicaci\xf3n','3');}
										else{despliegamodalm('visible','2','Falta adjuntar Un Documento para poder Guardar');}
									else{despliegamodalm('visible','2','Falta agregar el Numero de Folios para poder Modificar');}
								else{despliegamodalm('visible','2','Falta agregar Un Responsable para poder Modificar');}
							else{despliegamodalm('visible','2','Falta agregar La Descipci\xf3n para poder Modificar');}
						else{despliegamodalm('visible','2','Falta agregar Un Tercero para poder Modificar');}
					else{despliegamodalm('visible','2','Falta agregar Tipo de Radicaci\xf3n para poder Modificar');}
				}
			}
			function funcionmensaje(){}
			function camarcori(doc){document.getElementById('mararcori').value=doc;}
			function pdf()
			{
				document.form2.action="plan-acradicacionpdf.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function pdf2()
			{
				document.form2.action="plan-acradicacionsello.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function verificacheck(nomcheck)
			{
				if (document.getElementById(''+nomcheck).checked == false)
				{
					document.getElementById(''+nomcheck).value="0";
					document.getElementById(''+nomcheck).checked=false;
				}
				else 
				{
					document.getElementById(''+nomcheck).value="1";
					document.getElementById(''+nomcheck).checked=true;
				}
				if(document.getElementById('trescrito').checked!=false || document.getElementById('trcorreo').checked!=false || document.getElementById('trtelefono').checked!=false)
				{document.getElementById('tirespuesta').value="1";}
				else {document.getElementById('tirespuesta').value="0";}
			}
			function iratras()
			{
				var id = <?php echo $_GET[id] ?>;
				location.href="plan-acradicacionbuscar.php?nradicado="+id;
			}
		</script>
		<?php
			titlepag();
			function eliminarDir($carpeta)
			{
				$carpeta2="informacion/documentosradicados/".$carpeta;
				foreach(glob($carpeta2 . "/*") as $archivos_carpeta)
				{
					//echo $archivos_carpeta;
					if (is_dir($archivos_carpeta)){eliminarDir($archivos_carpeta);}
					else{unlink($archivos_carpeta);}
				}
				rmdir($carpeta2);
			}
		?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("plan");</script><?php cuadro_titulos();?></tr>
			<tr><?php menu_desplegable("plan");?></tr>
			<tr>
				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='plan-acradicacion.php'" class="mgbt"/><img src="imagenes/guarda.png" title="Guardar" onClick="guardar()" class="mgbt"/><img src="imagenes/busca.png" title="Buscar" onClick="location.href='plan-acradicacionbuscar.php'" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" class="mgbt" onClick="<?php echo paginasnuevas("plan");?>"/><img src="imagenes/print.png" title="Imprimir" class="mgbt" onClick="pdf();"><img src="imagenes/print.gif" title="Sello" class="mgbt" onClick="pdf2();"/><img src="imagenes/iratras.png" title="Atr&aacute;s" onClick="iratras()" class="mgbt"/></td>
			</tr>
		</table>
		<div id="bgventanamodalm" class="bgventanamodalm">
			<div id="ventanamodalm" class="ventanamodalm">
				<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"></IFRAME>
			</div>
		</div>
		<form name="form2" id="form2" method="post" enctype="multipart/form-data">
			<?php
				if (@ $_POST['oculto']=="")
				{
					$_POST['oculid']=$_GET['id'];
					$_POST['ban01']=0;
					$_POST['banmlg']=0;
					$sqlr="SELECT * FROM planacradicacion WHERE numeror = '".$_POST['oculid']."' AND tipot='RA'";
					$row = mysql_fetch_row(mysql_query($sqlr,$linkbd));
					$_POST['nradicado']=$row[1];
					$_POST['codbarras']=$row[1];
					$_POST['fecharad']=date("d/m/Y",strtotime($row[2]));
					$_POST['fecharado']=date("Y/m/d");
					$_POST['horarad']=$row[3];
					$sqlrtp="SELECT * FROM plantiporadicacion WHERE codigo='$row[5]'";
					$rowtp = mysql_fetch_row(mysql_query($sqlrtp,$linkbd));
					$_POST['tradicacion']="$rowtp[0]-$rowtp[4]$rowtp[3]-$rowtp[6]-$rowtp[4]";
					$_POST['adjuntosn']=$rowtp[6];
					if ($row[6]=="0000-00-00") 
					{
						$_POST['fechares']="SIN LIMITE";
						$_POST['fechareso']="0000/00/00";
					}
					else
					{
						$_POST['fechares']=date("d/m/Y",strtotime($row[6]));
						$_POST['fechareso']=date("Y/m/d",strtotime($row[6]));
					}
					if($row[7]!='')
					{
						$_POST['tercero']=$row[7];
						$_POST['ntercero']=buscatercero($row[7]);
						$_POST['ntelefono']=$row[12];
						$_POST['ncelular']=$row[13];
						$_POST['ndirecc']=$row[14];
						$_POST['ncorreoe']=$row[15];
					}
					else
					{
						$sqlter="SELECT * FROM planradicacionsindoc WHERE numeror='".$_POST['oculid']."'";
						$rester=mysql_query($sqlter,$linkbd);
						$rowter = mysql_fetch_row($rester);
						$_POST['ntercero']=$rowter[1];
						$_POST['ndirecc']=$rowter[2];
						$_POST['ncorreoe']=$rowter[3];
						$_POST['ntelefono']=$rowter[4];
						$_POST['ncelular']=$rowter[6];
					}
					$_POST['raddescri'] = stripslashes($row[8]);
					$_POST['trescrito']=$row[9];
					$_POST['trtelefono']=$row[10];
					$_POST['trcorreo']=$row[11];
					$_POST['contarch']=$row[18];
					$_POST['mararcori']=$row[19];
					$_POST['mdrece']=$row[24];
					$sqlrar="SELECT nomarchivo FROM planacarchivosad WHERE idradicacion = '".$_POST['oculid']."' ORDER BY idarchivoad ASC";
					$resar=mysql_query($sqlrar,$linkbd);
					while ($rowar = mysql_fetch_row($resar))
					{
						$_POST['nomarchivo'][]=$rowar[0];
						$_POST['banmlg']=$_POST['banmlg']+1;
					}
					$sqlres="SELECT usuariocon,fechasig,estado,codcargo FROM planacresponsables WHERE codradicacion = '".$_POST['oculid']."' ORDER BY codigo ASC";
					$resre=mysql_query($sqlres,$linkbd);
					$_POST['actescritura']="no";
					$_POST['tirespuesta']=0;
					$_POST['horres']="";
					while ($rowre = mysql_fetch_row($resre))
					{
						$_POST['docres'][]=$rowre[0];
						$_POST['nomdes'][]=buscaresponsable($rowre[0]);
						$_POST['recargo'][]=$rowre[3];
						$_POST['feradicado'][]=date("Y/m/d",strtotime($rowre[1]));
						if($rowre[2]=="LN"){$_POST['lecesc'][]=$rowre[2];}
						else 
						{
							$_POST['lecesc'][]="E";
							$_POST['actescritura']="si";
							$_POST['tirespuesta']=1;
						}
						$_POST['ban01']=$_POST['ban01']+1;
						$sqlfun="SELECT id_usu FROM usuarios WHERE cc_usu='$rowre[0]' AND est_usu='1'";
						$resfun=mysql_query($sqlfun,$linkbd);
						$numfun=mysql_num_rows($resfun);
						if($numfun==0){$_POST['estfun'][]="N";}
						else{$_POST['estfun'][]="S";}
						$_POST['horres']=$_POST['horres']." ".$rowre[0];
					}
					$ruta="informacion/documentosradicados/temp/RA/".$_POST['nradicado'];
					if(!file_exists($ruta))
					{mkdir ($ruta);}
					$rutaorigen="informacion/documentosradicados/RA/".$_POST['nradicado'];
					$yconta=count($_POST['nomarchivo']);
					for($y=0;$y<$yconta;$y++)
					{
						$nomarch=$rutaorigen.$_POST['nomarchivo'][$y];
						$nuevoarch=$ruta.'/'.$_POST['nomarchivo'][$y];
						copy($nomarch, $nuevoarch);
					}
					$_POST['rutaad']=$ruta."/";
					$_POST['modestado']="";
					$_POST['tabgroup1']=1;
					$_POST['oculto']="0";
				}
				//*****************************************************************
				switch(@ $_POST['tabgroup1'])
				{
					case 1:	$check1='checked';break;
					case 2:	$check2='checked';break;
					case 3:	$check3='checked';break;
					case 4:	$check4='checked';break;
				}
				//*****modificar************************************
				if (@ $_POST['modestado'] != '')
				{
					if($_POST['camestado']=='E')
					{
						$_POST['lecesc'][$_POST['modestado']]="LN";$_POST['actescritura']="no";
					}
					else 
					{
						$xconta=count($_POST['docres']);
						for($x=0;$x<$xconta;$x++){$_POST['lecesc'][$x]="LN";}
						$_POST['lecesc'][$_POST['modestado']]="E";$_POST['actescritura']="si";
					}
					$_POST['modestado']="";
				}
				//*****Agregar Reponsable en la Lista************************************
				if ($_POST['agresp']=='1')
				{
					$_POST['docres'][]=$_POST['responsable'];
					$_POST['nomdes'][]=$_POST['nresponsable'];
					$_POST['feradicado'][]=$_POST['fecharado'];
					$_POST['recargo'][]=$_POST['cargotercero'];
					if ($_POST['tirespuesta']=="0"){$_POST['lecesc'][]="LN";}
					else 
					{
						if($_POST['actescritura']=="no")
						{
							$_POST['lecesc'][]="E";
							$_POST['actescritura']="si";
						}
						else {$_POST['lecesc'][]="LN";}
					}
					$sqlfun="SELECT id_usu FROM usuarios WHERE cc_usu='".$_POST['responsable']."'";
					$resfun=mysql_query($sqlfun,$linkbd);
					$numfun=mysql_num_rows($resfun);
					if($numfun==0){$_POST['estfun'][]="N";}
					$_POST['responsable']="";
					$_POST['nresponsable']="";
					$_POST['cargotercero']="";
					$_POST['agregamlg']='0';
				}
				//******Eliminar Responsable de la Lista*****************************************
				if (@ $_POST['eliminaml']!='')
				{ 
					$posi=$_POST['eliminaml'];
					unset($_POST['docres'][$posi]);
					unset($_POST['nomdes'][$posi]);
					unset($_POST['feradicado'][$posi]);
					unset($_POST['recargo'][$posi]);
					unset($_POST['lecesc'][$posi]);
					unset($_POST['estfun'][$posi]);
					$_POST['docres']= array_values($_POST['docres']);
					$_POST['nomdes']= array_values($_POST['nomdes']);
					$_POST['feradicado']= array_values($_POST['feradicado']);
					$_POST['recargo']= array_values($_POST['recargo']);
					$_POST['lecesc']= array_values($_POST['lecesc']);
					$_POST['estfun']= array_values($_POST['estfun']);
				}
				//*****Agregar Archivo Adjunto A Lista*****************************
				if (@ $_POST['agregamlg']=='1')
				{
					$_POST['nomarchivo'][]=$_POST['nomarch'];
					$_POST['nomarch']="";
					$_POST['agregamlg']='0';
				}
				//******Eliminar Archivo de la Lista*****************************************
				if ($_POST['iddelad']!='')
				{ 
					$posi=$_POST['iddelad'];
					$archivodell=$_POST['rutaad'].$_POST['nomarchivo'][$posi];
					unlink($archivodell);
					unset($_POST['nomarchivo'][$posi]);
					$_POST['nomarchivo']= array_values($_POST['nomarchivo']); 
					$_POST['iddelad']='';
				}
				//******Busqueda Por Documento****************************************
				if ($_POST['busquedas']!="")
				{
					 switch($_POST['busquedas'])
					{
						case 1:	//***** busca tercero
						{
							$nresul=buscatercero2($_POST['tercero']);
							if($nresul[0]!='')
							{
								$_POST['ntercero']=$nresul[0];
								if ($nresul[1]==""){$_POST['ndirecc']="Sin Dirección de Correo";}
								else{$_POST['ndirecc']=$nresul[1];}
								if ($nresul[2]==""){$_POST['ntelefono']="Sin Numero Telefónico";}
								else{$_POST['ntelefono']=$nresul[2];}
								if ($nresul[3]==""){$_POST['ncelular']="Sin Numero Celular";}
								else{$_POST['ncelular']=$nresul[3];}
								if ($nresul[4]==""){$_POST['ncorreoe']="Sin Correo Electrónico";}
								else{$_POST['ncorreoe']=$nresul[4];}
							}
							else
							{
								$_POST['ntercero']=$_POST['ndirecc']=$_POST['ntelefono']=$_POST['ncelular']=$_POST['ncorreoe']="";
								echo "<script>despliegamodalm('visible','2','No existe o est\xe1 vinculado un Tercero con este documento');</script>";
							}
						}break;
						case 2://busca responsable
						{
							$nresul=buscaresponsable($_POST['responsable']);
							if($nresul!=''){$_POST['nresponsable']=$nresul;}
							else
							{
								$_POST['nresponsable']="";
								echo "<script>despliegamodalm('visible','2','No existe o est\xe1 vinculado un funcionario con este documento');</script>";
							}
						}break;
					}
					$_POST['busquedas']="";
				}
			?>
			<input type="hidden" name="ban01" id="ban01" value="<?php echo @ $_POST['ban01'];?>"/>
			<input type="hidden" name="banmlg" id="banmlg" value="<?php echo @ $_POST['banmlg'];?>"/>
			<input type="hidden" name="mararcori" id="mararcori" value="<?php echo @ $_POST['mararcori'];?>"/>
			<input type="hidden" name="adjuntosn" id="adjuntosn" value="<?php echo @ $_POST['adjuntosn']?>"/>
			<input type="hidden" name="tirespuesta" id="tirespuesta" value="<?php echo @ $_POST['tirespuesta']?>"/>
			<div class="tabsmeci"  style="height:76.5%; width:99.6%">
				<div class="tab">
				<input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
					<label for="tab-1">Informaci&oacute;n General</label>
					<div class="content" style="overflow:hidden;">
						<table class="inicio">
							<tr>
								<td colspan="7" class="titulos">:.Modificar Documento Radicado</td>
								<td class="cerrar" style="width:7%" onClick="location.href='plan-principal.php'">&nbsp;Cerrar</td>
							</tr>
							<tr>
								<td colspan="6" class="titulos2">:.Datos B&aacute;sicos </td>
								<td rowspan="10" colspan="2"><img src="imagenes/atencionalc.jpg" style="width:95%; height:80%" /></td>
							</tr>
							<tr>
								<td class="tamano01" style="width:3.5cm;">:&middot; N&deg; Radicaci&oacute;n:</td>
								<td style="width:16%">
									<input type="text" name="nradicado" id="nradicado" class="tamano02" style="width:100%" value="<?php echo @ $_POST['nradicado']?>" readonly/>
									<input type="hidden" name="codbarras" id="codbarras" value="<?php echo @ $_POST['codbarras']?>"/>
								</td>
								<td class="tamano01" style="width:3cm;">:&middot; Fecha:</td>
								<td style="width:16%;">
									<input type="text" name="fecharad" id="fecharad" class="tamano02" style="width:100%" value="<?php echo @ $_POST['fecharad']?>" readonly/>
									<input type="hidden" name="fecharado" id="fecharado" value="<?php echo @ $_POST['fecharado']?>"/>
								</td>
								<td class="tamano01" style="width:3cm;">:&middot; Hora:</td>
								<td style="width:16%"><input type="time" name="horarad" id="horarad" class="tamano02" style="width:100%" value="<?php echo @ $_POST['horarad'];?>" readonly/></td>
							</tr>
							<tr>
								<td class="tamano01" style="width:3cm;" >:&middot;Tipo Radicaci&oacute;n:</td>
								<td colspan="3">
									<select name="tradicacion" id="tradicacion" class="tamano02" style="width:100%;text-transform:uppercase;"  onKeyUp="return tabular(event,this)" onChange="var traddiv=this.value.split('-');document.getElementById('adjuntosn').value= traddiv[2]; if(traddiv[3]!='N'){sumadiashabiles(document.form2.fechares, document.form2.fechareso, traddiv[1]);}else{document.form2.fechares.value='SIN LIMITE';document.form2.fechareso.value='0000/00/00'}">
										<?php
											$sqlr="SELECT * FROM plantiporadicacion WHERE estado='S' AND radotar='RA' ORDER BY nombre ASC";
											$res=mysql_query($sqlr,$linkbd);
											while ($row = mysql_fetch_row($res))
											{
												switch ($row[11])
												{
													case "N":	$tipopqr="N - Ninguno";break;
													case "P":	$tipopqr="P - Petición";break;
													case "Q":	$tipopqr="Q - Queja";break;
													case "R":	$tipopqr="R - Reclamo";break;
													case "S":	$tipopqr="S - Sugerencia";break;
													case "D":	$tipopqr="D - Denuncia";break;
													case "F":	$tipopqr="F - Felicitacion";
												}
												if($_POST['tradicacion']=="$row[0]-$row[4]$row[3]-$row[6]-$row[4]")
												{
													echo "<option value='$row[0]-$row[4]$row[3]-$row[6]-$row[4]' SELECTED>- $row[1] ($tipopqr)</option>";
													$_POST['octradicacion']=$row[1];
												}
												else {echo "<option value='$row[0]-$row[4]$row[3]-$row[6]-$row[4]'>- $row[1] ($tipopqr)</option>";}
											}
										?>
									</select>
									<input type="hidden" name="octradicacion" id="octradicacion" value="<?php echo @ $_POST['octradicacion']?>"/>
								</td>
								<td class="tamano01" style="width:3cm">:&middot; Fecha L&iacute;mite:</td>
								<td>
									<input type="text" name="fechares" id="fechares" class="tamano02" style="width:100%" value="<?php echo @ $_POST['fechares']?>" readonly/>
									<input type="hidden" name="fechareso" id="fechareso" value="<?php echo @ $_POST['fechareso']?>"/>
								</td>
							</tr>
							<tr>
								<td class="tamano01">:&middot; Descripci&oacute;n:</td>
								<td colspan="5"><input type="text" id="raddescri" name="raddescri" class="tamano02" style="width:100%;text-transform:uppercase;" value="<?php echo @ $_POST['raddescri']?>"></td>
							</tr>
							<tr>
								<td class="tamano01" style="width:3cm">:&middot; Respuesta:</td>
								<td class="tamano03" colspan="3">
									<input type="checkbox" name="trescrito" id="trescrito" value="<?php echo @ $_POST['trescrito'];?>" class="defaultcheckbox" onClick="verificacheck(this.id);"/>Escrita &nbsp;&nbsp;&nbsp;&nbsp;
									<input type="checkbox" name="trtelefono" id="trtelefono" value="<?php echo @ $_POST['trtelefono'];?>" class="defaultcheckbox"  onClick="verificacheck(this.id);"/>Telef&oacute;nica &nbsp;&nbsp; &nbsp;&nbsp;
									<input type="checkbox" name="trcorreo" id="trcorreo" value="<?php echo @ $_POST['trcorreo'];?>" class="defaultcheckbox" onClick="verificacheck(this.id);"  />Correo Electr&oacute;nico
								</td>
								<td class="tamano01" style="width:3cm">:&middot;Folios:</td>
								<td><input type="text" name="contarch" id="contarch" class="tamano02" style="width:100%" value="<?php echo $_POST[contarch]?>"/></td>
							</tr>
							<tr>
								<td class="tamano01" style="width:3cm">:&middot;Medio Recepción:</td>
								<td colspan="3">
									<select name="mdrece" id="mdrece" class="tamano02">
										<option value="O" <?php if($_POST['mdrece']=="O"){echo "SELECTED ";}?>>O - Oficio</option>
										<option value="F" <?php if($_POST['mdrece']=="F"){echo "SELECTED ";}?>>F - Formato PQRSDF</option>
										<option value="E" <?php if($_POST['mdrece']=="E"){echo "SELECTED ";}?>>E - Correo Electrónico</option>
										<option value="P" <?php if($_POST['mdrece']=="P"){echo "SELECTED ";}?>>P - Pagina WEB</option>
									</select>
								</td>
							</tr>
							<tr><td colspan="6" class="titulos2">:.Datos Remitente </td></tr>
							<tr>
								<td class="tamano01" >:&middot; Nombre:</td>
								<td><input type="text" name="tercero" id="tercero" class="tamano02" style="width:85%" onKeyPress="return solonumeros(event);" onBlur="busquedajs('1');" value="<?php echo @ $_POST['tercero']?>" onClick="document.getElementById('tercero').focus();document.getElementById('tercero').select();"/>&nbsp;<img src="imagenes/find02.png" onClick="despliegamodal2('visible','1');" title="Listado Terceros" class="icobut"/></td>
								<td colspan="4"><input name="ntercero" class="tamano02" type="text" value="<?php echo @ $_POST['ntercero']?>" style="width:95%;text-transform:uppercase;"/>&nbsp;<img  src="imagenes/usuarion.png"  onClick="mypop=window.open('plan-acterceros.php','','');mypop.focus();" class="icobut" title="Ingresar Nuevo Tercero"/></td>
							</tr>
							<tr>
								<td class="tamano01">:&middot; Direcci&oacute;n:</td>
								<td colspan="5"><input type="text" name="ndirecc" id="ndirecc" class="tamano02" style="width:100%;text-transform:uppercase;" value="<?php echo @ $_POST['ndirecc']?>"/></td>
							</tr>
							<tr>
								<td class="tamano01" >:&middot; Email:</td>
								<td colspan="5"><input type="text" name="ncorreoe" id="ncorreoe" class="tamano02" style="width:100%;" value="<?php echo @ $_POST['ncorreoe']?>"/></td>
							</tr>
							<tr>
								<td class="tamano01" >:&middot; Tel&eacute;fono:</td>
								<td><input type="text" name="ntelefono" id="ntelefono" class="tamano02" style="width:100%" value="<?php echo @ $_POST['ntelefono']?>"/></td>
								<td class="tamano01" >:&middot; Celular:</td>
								<td><input type="text" name="ncelular" id="ncelular" class="tamano02" style="width:100%" value="<?php echo @ $_POST['ncelular']?>"/></td>
							</tr>
						</table>
					</div>
				</div>
				<div class="tab">
					<input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?>/>
					<label for="tab-2">Responsables</label>
					<div class="content" style="overflow:hidden;">
						<table  class="inicio">
							<tr><td colspan="4" class="titulos">Responsables</td></tr>
							<tr>
								<td class="tamano01" style="width:15%">:&middot; Responsable Respuesta:</td>
								<td style="width:15%"><input id="responsable" type="text" name="responsable" style="width:100%" onKeyPress="return solonumeros(event);" onBlur="busquedajs('2');" value="<?php echo @ $_POST['responsable']?>" onClick="document.getElementById('responsable').focus();document.getElementById('responsable').select();" class="tamano02"/></td>
								<input type="hidden" value="0" name="bres">
								<td><img src="imagenes/find02.png" onClick="despliegamodal2('visible','2');" title="Listado Funcionarios"/ class="icobut">&nbsp;<input type="text" name="nresponsable" id="nresponsable" value="<?php echo @ $_POST['nresponsable']?>" style=" width:90%" class="tamano02" readonly/></td>
								<td style="padding-bottom:5px"><em class="botonflecha" onClick="agresponsable();">Agregar</em></td>
							</tr>
						</table>
						<input type="hidden" name="cargotercero" id="cargotercero" value="<?php echo @ $_POST['cargotercero']?>"/>
						<div style="overflow-x:hidden;">
							<table class="inicio">
								<tr><td colspan="6" class="titulos">Responsables</td></tr>
								<tr>
									<td class="titulos2" style="width:15%;">Documento</td>
									<td class="titulos2" >Nombre</td>
									<td class="titulos2" style="width:8%;">Tipo</td>
									<td class="titulos2" style="width:8%;" title="Documento Original">Original</td>
									<td class="titulos2" style="width:8%;">Estado Usuario</td>
									<td class="titulos2" style="width:5%;">Eliminar</td>
								</tr>
								<?php
									$iter="saludo1a";
									$iter2="saludo2";
									$tam=count($_POST['docres']);
									for($x=0;$x<$tam;$x++)
									{
										if(($_POST['lecesc'][$x] == "LN") || ($_POST['lecesc'][$x] == "LS"))
										{$imglecesc="src='imagenes/lectura.jpg' title='Solo Lectura'";}
										else {$imglecesc="src='imagenes/escritura.png' title='Responder'";}
										if($_POST['mararcori']==$_POST['docres'][$x]){$marcador='checked';}
										else {$marcador='';}
										if ($_POST['estfun'][$x]=="S"){$imgfun="<img src='imagenes/usuario01.png' style=width:18px;'/> Activo <img src='imagenes/usuario01.png' style=width:18px;'/>";}
										else{$imgfun="<img src='imagenes/usuario02.png' style=width:18px;'/> Inactivo <img src='imagenes/usuario02.png' style=width:18px;'/>";}
										echo "
											<input type='hidden' name='docres[]' value='".$_POST['docres'][$x]."'/>
											<input type='hidden' name='nomdes[]' value='".$_POST['nomdes'][$x]."'/>
											<input type='hidden' name='recargo[]' value='".$_POST['recargo'][$x]."'>
											<input type='hidden' name='lecesc[]' value='".$_POST['lecesc'][$x]."'/>
											<input type='hidden' name='feradicado[]' value='".$_POST['feradicado'][$x]."'/>
											<input type='hidden' name='estfun[]' value='".$_POST['estfun'][$x]."'>
											<tr class='$iter' style='text-transform:uppercase'>
												<td>".$_POST['docres'][$x]."</td>
												<td>".$_POST['nomdes'][$x]."</td>
												<td style='text-align:center;cursor:pointer;'><img $imglecesc style='width:20px' onclick='cambiolecesc($x,\"".$_POST['lecesc'][$x]."\")'/></td>
												<td><input type='radio' name='docorig' class='defaultradio' $marcador onclick='camarcori(\"".$_POST['docres'][$x]."\")' /></td>
												<td style='text-align:center;'>$imgfun</td>
												<td style='text-align:center;'><a onclick='eliresponsable($x)' style='cursor:pointer'><img src='imagenes/del.png'></a></td>
											</tr>";
										$aux=$iter;
										$iter=$iter2;
										$iter2=$aux;
									}
								?>
							</table>
						</div>
					</div>
				</div>
				<div class="tab">
					<input type="radio" id="tab-3" name="tabgroup1" value="3" <?php echo $check3;?> >
					<label for="tab-3">Archivos Adjuntos</label>
					<div class="content" style="overflow:hidden;">
						<table class="inicio">
							<tr><td colspan="4" class="titulos">Archivos Adjuntos</td></tr>
							<tr>
								<td class="saludo1" style="width:10%">:&middot;Documentos:</td>
								<td><input type="text" name="nomarch" id="nomarch" style="width:100%" value="<?php echo $_POST['nomarch']?>" class="tamano02" readonly></td>
								<td>
									<div class='upload' style="height: 23px">
										<input type="file" name="plantillaad" onChange="document.form2.submit();" title='Cargar Documento' style='cursor:pointer;' title='Cargar Documento' />
										<img src='imagenes/upload01.png' style="width:22px" />
									</div>
								</td>
								<td><input name="agregadoc" type="button" value="  Adjuntar " onClick="agregardocumento()"></td>
							</tr>
						</table>
						<div style="overflow-x:hidden;">
							<table class="inicio" >
								<tr><td colspan="4" class="titulos">Archivos Adjuntos</td></tr>
								<tr>
									<td class="titulos2" style="width:80%;">Nombre del Archivo</td>
									<td class="titulos2" style="width:10%;">Tipo</td>
									<td class="titulos2" style="width:10%;">Eliminar</td>
								</tr>
								<?php
									$iter="saludo1a";
									$iter2="saludo2";
									$tam=count($_POST['nomarchivo']);
									for($x=0;$x<$tam;$x++)
									{
										echo "
										<tr class='$iter'>
											<td><input class='inpnovisibles type='text' name='nomarchivo[]' value='".$_POST['nomarchivo'][$x]."' style='width:100%;' readonly></td>
											<td style='text-align:center;'>".traeico($_POST['nomarchivo'][$x])."</td>
											<td><a href='#' onclick='eliminarml($x)'><img src='imagenes/del.png'></a></td>
										</tr>";
										$aux=$iter;
										$iter=$iter2;
										$iter2=$aux;
									}
								?>
							</table>
						</div>
					</div>
				</div>
			</div>
			<input type="hidden" name="archivonom" id="archivonom"  value="<?php echo $_POST['archivonom']?>">
			<input type="hidden" name="iddelad" id="iddelad" value="<?php echo $_POST['iddelad']?>">
			<input type="hidden" name="ocudelad" id="ocudelad" value="<?php echo $_POST['oculdel']?>">
			<input type="hidden" name="refrest" id="refrest" value="<?php echo $_POST['refrest']?>">
			<input type="hidden" name="rutaad" id="rutaad" value="<?php echo $_POST['rutaad']?>">
			<input type="hidden" id="oculto" name="oculto" value="0">
			<input type="hidden" name="busquedas" id="busquedas" value="<?php echo $_POST['busquedas'];?>">
			<input type="hidden" name="idelimina" id="idelimina" value="<?php echo $_POST['idelimina']?>">
			<input type="hidden" name="camestado" id="camestado" value="<?php echo $_POST['camestado']?>">
			<input type="hidden" name="modestado" id="modestado" value="<?php echo $_POST['modestado']?>">
			<input type="hidden" name="actescritura" id="actescritura" value="<?php echo $_POST['actescritura']?>">
			<input type="hidden" name="contadjuntos" id="contadjuntos" value="<?php echo $_POST['contadjuntos']?>"/>
			<input type='hidden' name='eliminaml' id='eliminaml'>
			<input type="hidden" name="agresp" id="agresp" value="0">
			<input type="hidden" name="agregamlg" value="0">
			<input type="hidden" name="oculid" id="oculid" value="<?php echo $_POST['oculid']?>">
			<input type="hidden" name="horres" id="horres" value="<?php echo $_POST['horres']?>">
			<?php
				if (@ $_POST['trescrito'] == "1"){echo "<script>document.getElementById('trescrito').checked=true;</script>";} 	
				if (@ $_POST['trtelefono'] == "1"){echo "<script>document.getElementById('trtelefono').checked=true;</script>";}
				if (@ $_POST['trcorreo'] == "1"){echo "<script>document.getElementById('trcorreo').checked=true;</script>";}
				//archivos
				if (is_uploaded_file($_FILES['plantillaad']['tmp_name'])) 
				{
					copy($_FILES['plantillaad']['tmp_name'], $_POST['rutaad'].$_FILES['plantillaad']['name']);
					if (file_exists($_POST['rutaad'].$_FILES['plantillaad']['name']))
					{
						echo"<script>document.getElementById('nomarch').value='".$_FILES['plantillaad']['name']."';</script>";
					}
					else 
					{
						echo"<script>despliegamodalm('visible','2','No Se pudo cargar el archivo, favor intentar de nuevo');</script>";
					}
				}
				//modificar la informacion de la Radicación**************************
				if (@ $_POST['oculto'] == "1")
				{
					/*$nomdirarchivo="informacion/documentosradicados/".$_POST['codbarras'].".zip";
					comprimir($_POST['rutaad'],($_POST['codbarras'].".zip"));
					copy(($_POST['codbarras'].".zip"),($nomdirarchivo));
					if (file_exists($nomdirarchivo))*/
					{
						$vallecesc="LN";
						$xconta=count($_POST['docres']);
						for($x=0;$x<$xconta;$x++){if($_POST['lecesc'][$x]=="E"){$vallecesc="AN";}}
						$nomarchivoad=$_POST['codbarras'].".zip";
						$cadtrad=explode("-",$_POST['tradicacion']);
						//Modificar la informacion general de la radicacion****************************************
						$sqlr = "UPDATE planacradicacion SET tipor='$cadtrad[0]',fechalimite='".$_POST['fechareso']."', idtercero='".$_POST['tercero']."',descripcionr='".$_POST['raddescri']."',tescrito='".$_POST['trescrito']."',ttelefono='".$_POST['trtelefono']."',temail='".$_POST['trcorreo']."',telefonot='".$_POST['ntelefono']."', celulart='".$_POST['ncelular']."',direcciont='".$_POST['ndirecc']."',emailt='".$_POST['ncorreoe']."', nfolios='".$_POST['contarch']."',narchivosad='".$_POST['mararcori']."',estado='$vallecesc', mrecepcion='".$_POST['mdrece']."' WHERE numeror= '".$_POST['oculid']."'"; 
						$res=(mysql_query($sqlr,$linkbd));
						if(@ $_POST['tercero'] == "")
						{
							$sqlr = "UPDATE planradicacionsindoc SET nombre='".$_POST['ntercero']."',direccion='".$_POST['ndirecc']."', email='".$_POST['ncorreoe']."',telefono='".$_POST['ntelefono']."',celular='".$_POST['ncelular']."' WHERE numeror= '".$_POST['oculid']."'";
							$res=(mysqli_query($linkbd,$sqlr));
						}
						//Modificar Los responsables********************************************************************************
						$sqlr="DELETE FROM planacresponsables WHERE codradicacion='".$_POST['oculid']."'";
						mysql_query($sqlr,$linkbd);
						$xconta=count($_POST['docres']);
						for($x=0;$x<$xconta;$x++)
						{
							if($_POST['lecesc'][$x]=="E"){$vallecesc="AN";}
							else{$vallecesc=$_POST['lecesc'][$x];}
							$sqlid="SELECT MAX(codigo) FROM planacresponsables ";
							$rowid=mysql_fetch_row(mysql_query($sqlid,$linkbd));
							$numid=$rowid[0]+1;
							$pos = strpos($_POST['horres'], $_POST['docres'][$x]);
							if ($pos === false){$horain=date('H:i:s');}
							else{$horain=$_POST['horarad'];}
							$sqlr = "INSERT INTO planacresponsables (codigo,codradicacion,fechasig,fechares,usuarioasig,usuariocon, estado,archivos,respuesta,codcargo,consulta,idhistory,horasig,horresp) VALUES ('$numid', '".$_POST['oculid']."','".$_POST['feradicado'][$x]."','','".$_SESSION['cedulausu']."','".$_POST['docres'][$x]."','$vallecesc','','','".$_POST['recargo'][$x]."','','0','$horain','')";
							mysql_query($sqlr,$linkbd);
						}
						//guarda Los archivos y crear .zip***********************************************************************
						$sqlr="DELETE FROM planacarchivosad WHERE idradicacion='".$_POST['oculid']."'";
						mysql_query($sqlr,$linkbd);
						$yconta=count($_POST['nomarchivo']);
						for($y=0;$y<$yconta;$y++)
						{
							$numid=selconsecutivo('planacarchivosad','idarchivoad');
							$sqlr = "INSERT INTO planacarchivosad (idarchivoad,idradicacion,nomarchivo) VALUES ('$numid','".$_POST['oculid']."','".$_POST['nomarchivo'][$y]."')";
							mysql_query($sqlr,$linkbd);
						}
						$_POST['oculto']="0";
						echo"<script>despliegamodalm('visible','1','Se Modifico con Exito La Radicaci\xf3n');</script>";
					}
					/*else
					{
						echo"<script>despliegamodalm('visible','2','No Se pudo guardar los archivos, favor intentar guardar de nuevo');</script>";
					}*/
				}
			?>
			<script>document.getElementById('contadjuntos').value="<?php echo count($_POST['nomarchivo']);?>";</script>
			<script type="text/javascript">$('#tercero, #responsable').numeric({allowThouSep: false,allowDecSep: false,allowMinus:false});</script>
		</form>
		<div id="bgventanamodal2">
			<div id="ventanamodal2">
				<IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"></IFRAME>
			</div>
		</div>
	</body>
</html>