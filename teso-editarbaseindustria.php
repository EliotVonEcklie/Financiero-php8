<?php
	require "comun.inc";
	require "funciones.inc";
	require "validaciones.inc";
	require "conversor.php";
	session_start();
	$linkbd=conectar_bd();
	$scroll=$_GET['scrtop'];
	$totreg=$_GET['totreg'];
	$idcta=$_GET['idcta'];
	$altura=$_GET['altura'];
	$filtro="'".$_GET['filtro']."'";
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	header("Content-Type: text/html;charset=iso-8859-1");
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=iso-8859-1"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Spid - Tesoreria</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/tabs.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/calendario.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script type="text/javascript" src="JQuery/jquery-2.1.4.min.js"></script>
		<script type="text/javascript" src="JQuery/autoNumeric-master/autoNumeric-min.js"></script>
		<style>
			input[type='text']{height:30px;}
			input[type='search']{height:30px;}
			select{height:30px;}
		</style>
		<script>
			function despliegamodal2(_valor,_num)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else 
				{
					switch(_num)
					{
						case '0':	document.getElementById('ventana2').src="cargosadministrativos-ventana01.php";break;
						case '1':	document.getElementById('ventana2').src="tercerosgral-ventana04.php?objeto=tercero&nobjeto=ntercero&nfoco=tercero&valsub=SI"; break;
						case '2':	document.getElementById('ventana2').src="tercerosgral-ventana01.php?objeto=eps&nobjeto=neps&nfoco=arp";break;
						case "3":	document.getElementById('ventana2').src="ciiu-ventana01.php";break;
						case "4":	document.getElementById('ventana2').src="tercerosgral-ventana01.php?objeto=afp&nobjeto=nafp&nfoco=fondocesa";break;
						case "5":	document.getElementById('ventana2').src="tercerosgral-ventana01.php?objeto=fondocesa&nobjeto=nfondocesa&nfoco=cargo";break;
						case "6":	document.getElementById('ventana2').src="nivelsalarial-ventana01.php";break;
					}
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
						case "1":	document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
						case "2":	document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
						case "3":	document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
						case "4":	document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;	
					}
				}
			}
			function funcionmensaje()
			{
				var _cons=document.getElementById('id').value;
				document.location.href = "teso-editarbaseindustria.php?idegre="+_cons+"&scrtop=0&numpag=1&limreg=10&filtro1=&filtro2=";
			}
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
					case "3": 
						document.form2.oculto.value="6";
						document.form2.submit();
						break;
					case "4": 
						document.form2.oculto.value="7";
						document.form2.submit();
						break;
					case "5": 
						document.form2.oculto.value="8";
						document.form2.submit();
						break;
					case "6": 
						document.form2.oculto.value="9";
						document.form2.submit();
						break;
					case "7": 
						document.form2.oculto.value="10";
						document.form2.submit();
						break;
				}
			}
			function validar(){document.form2.submit();}
			function buscar(_num)
			{
				switch(_num)
				{
					case "1":	
						var validacion01=document.getElementById('tercero').value;
						if (validacion01.trim()!='')
						{
							document.getElementById('vbuscar').value="1";
							document.form2.submit();
							break;
						}
						else
						{
							document.getElementById('ntercero').value=""
							document.getElementById('direccion').value="";
							document.getElementById('telefono').value="";
							document.getElementById('celular').value="";
							document.getElementById('email').value="";
							break;
						}
				}
			}
			function guardar()
			{
				if ((document.form2.fechain.value!='' && existeFecha(document.form2.fechain.value)) && document.form2.tercero.value!='' && document.form2.ntercero.value!='')
				{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
				else {despliegamodalm('visible','2','Faltan datos para completar el registro');}
			}
			function agregadet()
			{
				if(document.form2.fechaMatricula.value!="")
				{
					if(document.form2.razonSocial.value!="")
					{
						if(document.form2.direccionEstablecimiento.value!="")
						{
							if(document.form2.valorActivo.value!="")
							{
								document.form2.oculto.value="4";
								document.form2.submit();
							}
							else{despliegamodalm('visible','2','Falta digitar el valor de los activos');}
						}else{despliegamodalm('visible','2','Falta digitar la direccion del establecimiento');}
					}else{despliegamodalm('visible','2','Falta digitar la razon social del establecimiento');}
				}else{despliegamodalm('visible','2','Falta digitar la fecha de matricula del establecimiento');}
			}
			function agregadetciiu()
			{
				if(document.form2.nuMatriculaCiiu.value!="")
				{
					if(document.form2.ciiu.value!="")
					{
						document.form2.oculto.value="5";
						document.form2.submit();
					}
					else{despliegamodalm('visible','2','Falta seleccionar el codigo CIIU');}
				}
				else{despliegamodalm('visible','2','Falta Seleccioar el numero de matricula del establecimiento');}
			}
			function eliminar(variable)
			{
				document.getElementById('elimina').value=variable;
				despliegamodalm('visible','4','¿Esta Seguro que desea eliminar este establecimiento?','2');
			}
			function cambioswitch(variable,valor)
			{
				if(valor==1)
				{
					document.getElementById('anula').value=variable;
					despliegamodalm('visible','4','¿Esta Seguro que desea Desactivar este establecimiento?','4');
				}
				else
				{
					document.getElementById('anula').value=variable;
					despliegamodalm('visible','4','¿Esta Seguro que desea Activar este establecimiento?','5');
				}
				
			}
			function cambioswitch1(variable,valor)
			{
				if(valor==1)
				{
					document.getElementById('anula').value=variable;
					despliegamodalm('visible','4','¿Esta Seguro que desea Desactivar este establecimiento?','6');
				}
				else
				{
					document.getElementById('anula').value=variable;
					despliegamodalm('visible','4','¿Esta Seguro que desea Activar este establecimiento?','7');
				}
				
			}
			function eliminarciiu(variable)
			{
				document.getElementById('eliminaciiu').value=variable;
				despliegamodalm('visible','4','Esta Seguro de Eliminar','3');
			}
			function adelante(scrtop, numpag, limreg, filtro, next)
			{
				var maximo=document.getElementById('maximo').value;
				var actual=document.getElementById('id').value;
				if(parseFloat(maximo)>parseFloat(actual)){
					document.getElementById('oculto').value='';
					document.getElementById('id').value=next;
					var idcta=document.getElementById('id').value;
					document.form2.action="teso-editarbaseindustria.php?idegre="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					document.form2.submit();
				}
			}
			function atrasc(scrtop, numpag, limreg, filtro, prev)
			{
				var minimo=document.getElementById('minimo').value;
				var actual=document.getElementById('id').value;
				if(parseFloat(minimo)<parseFloat(actual)){
					document.getElementById('oculto').value='';
					document.getElementById('id').value=prev;
					var idcta=document.getElementById('id').value;
					document.form2.action="teso-editarbaseindustria.php?idegre="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					document.form2.submit();
				}
			}
			function iratras(scrtop, numpag, limreg, filtro)
			{
				var idcta=document.getElementById('id').value;
				location.href="teso-buscabaseindustria.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
			}
			function pdfcertificado()
			{
				document.form2.action="pdfcertificacionica.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function excell()
			{
				document.form2.action="teso-listadobaseindustria.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
		</script>
		<?php titlepag(); ?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<?php $numpag=$_GET[numpag];$limreg=$_GET[limreg];$scrtop=22*$totreg;?>
		<table>
			<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("teso");?></tr>
			<tr>
				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='teso-baseindustria.php'" class="mgbt"/><img src="imagenes/guarda.png" title="Guardar" onClick="guardar()" class="mgbt"/><img src="imagenes/busca.png" title="Buscar" onClick="location.href='teso-buscabaseindustria.php'" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" onClick="<?php echo paginasnuevas("teso");?>" class="mgbt"><img src="imagenes/excel.png" title="Excel" onClick='excell()' class="mgbt"/><img src='imagenes/iratras.png' title='Busca base industria' onClick="iratras(<?php echo "$scrtop,$numpag,$limreg,$filtro"; ?>)" class='mgbt'></td>
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
				$sqlr="select MIN(CONVERT(id, SIGNED INTEGER)), MAX(CONVERT(id, SIGNED INTEGER)) from tesorepresentantelegal ORDER BY CONVERT(id, SIGNED INTEGER)";
				$res=mysql_query($sqlr,$linkbd);
				$r=mysql_fetch_row($res);
				$_POST['minimo']=$r[0];
				$_POST['maximo']=$r[1];
				if(!$_POST['oculto'])
				{
					$check1="checked";
				}
				switch($_POST['tabgroup1'])
				{
					case 1:	$check1='checked';break;
					case 2: $check2='checked';break;
					case 3: $check3='checked';break;
					case 4: $check4='checked';break;
					case 5: $check5='checked';break;
				}
				if($_GET['idegre']!='')
				{
					$sqlr = "SELECT id,fecha,cedulanit,estado FROM tesorepresentantelegal WHERE id='".$_GET['idegre']."'";
					$res = mysql_query($sqlr,$linkbd);
					$row = mysql_fetch_row($res);
					$_POST['id'] = $row[0];
					$_POST['fechain'] = $row[1];
					$_POST['tercero']= $row[2];
					if($row[3]=='S'){$_POST['estmatricula']='Matricula Activa';}
					else {$_POST['estmatricula']='Matricula Cancelada';}
				}
				if ($_POST[id]!="")
				{
					$sqlr="SELECT nombre1,nombre2,apellido1,apellido2,direccion,telefono,celular,email,id_tercero,razonsocial FROM terceros where cedulanit='".$_POST['tercero']."' AND estado='S'";
					$res=mysql_query($sqlr,$linkbd);
					while($r=mysql_fetch_row($res))
					{
						if ($r[3]!="" && $r[1]!=""){$_POST[ntercero]="$r[2] $r[3] $r[0] $r[1]";}
						elseif($r[3]!=""){$_POST[ntercero]="$r[2] $r[3] $r[0]";}
						elseif($r[1]!=""){$_POST[ntercero]="$r[2] $r[0] $r[1]";}
						else {$_POST[ntercero]="$r[2] $r[0]";}
						if($r[4]!=""){$_POST[direccion]=$r[4];}
						else {$_POST[direccion]="SIN DIRECCION DIGITADA";}
						if($r[5]!=""){$_POST[telefono]=$r[5];}
						else{$_POST[telefono]="SIN NUMERO TELEFONICO";}
						if($r[6]!=""){$_POST[celular]=$r[6];}
						else{$_POST[celular]="SIN NUMERO CELULAR";}
						if($r[7]!=""){$_POST[email]=$r[7];}
						else{$_POST[email]="SIN CORREO ELECTRONICO";}
						$_POST[idterc]=$r[8];
						if($_POST[ntercero]==' ' || $_POST[ntercero]=='  ')
						{
							$_POST[ntercero] = $r[9];
						}
					}
					$sqlr="SELECT MAX(matricula) FROM tesoestablecimiento";
					$resp = mysql_query($sqlr,$linkbd);
					$row = mysql_fetch_row($resp);
					if($_POST[numMatricula]=='')
						$_POST[numMatricula]=$row[0]+1;

					if(!$_POST[oculto])
					{
						$_POST[numMatriculaDet]=array();
						$_POST[fechaMatriculaDet]=array();
						$_POST[razonSocialDet]=array();
						$_POST[direccionEstablecimientoDet]=array();
						$_POST[fechaInicioDet]=array();
						$_POST[valorActivoDet]=array();
						$_POST[localDet]=array();
						$_POST[ciiuDet]=array();
						$_POST[nciiuDet]=array();
						$_POST[nuMatriculaCiiuDet]=array();
						$_POST[estadoDet]=array();
						$_POST[estadociiuDet]=array();
						$_POST[idDet]=array();
						$_POST[idciiuDet]=array();
						$sqlr = "SELECT matricula, fechamatricula, razonsocial, direccion, fechainicio,local, valoractivos,estado,id FROM tesoestablecimiento WHERE matricula='$_POST[id]'";
						//echo "go".$sqlr;
						$resp = mysql_query($sqlr,$linkbd);

						while($row = mysql_fetch_row($resp))
						{
							$_POST[numMatriculaDet][]=$row[0];
							$_POST[fechaMatriculaDet][]=$row[1];
							$_POST[razonSocialDet][]=$row[2];
							$_POST[direccionEstablecimientoDet][]=$row[3];
							$_POST[fechaInicioDet][]=$row[4];
							$_POST[valorActivoDet][]=$row[6];
							$_POST[localDet][]=$row[5];
							$_POST[estadoDet][]=$row[7];
							$_POST[idDet][]=$row[8];
						}
						$sqlrciiu = "SELECT ciiu,matricula,estado,id FROM tesoestablecimientociiu WHERE idrepresentantelegal='$_POST[id]'";
						$respciiu = mysql_query($sqlrciiu,$linkbd);
						while($rowciiu = mysql_fetch_row($respciiu))
						{
							$_POST[ciiuDet][]=$rowciiu[0];
							$_POST[nciiuDet][]=buscacodigociiu($rowciiu[0]);
							$_POST[nuMatriculaCiiuDet][]=$rowciiu[1];
							$_POST[estadociiuDet][]=$rowciiu[2];
							$_POST[idciiuDet][]=$rowciiu[3];
						}
					}
				}
				//NEXT
				$sqln="select *from tesorepresentantelegal WHERE id > '$_POST[id]' ORDER BY id ASC LIMIT 1";
				$resn=mysql_query($sqln,$linkbd);
				$row=mysql_fetch_row($resn);
				$next="'".$row[0]."'";
				//PREV
				$sqlp="select *from tesorepresentantelegal WHERE id < '$_POST[id]' ORDER BY id DESC LIMIT 1";
				$resp=mysql_query($sqlp,$linkbd);
				$row=mysql_fetch_row($resp);
				$prev="'".$row[0]."'";
			?>
			<div class="tabs" style="height:20%; width:99.7%">
				<!--Represantante Legal-->
				<div class="tab" >
					<input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
					<label for="tab-1">Representante Legal</label>
					<div class="content" style="overflow-x:hidden;" >
						<table class="inicio">
							<tr>
								<td class="titulos" colspan="8">.: Ingresar Datos Propietario o Representate Legal</td>
								<td class="cerrar" style="width:7%" onClick="location.href='hum-principal.php'">Cerrar</td>
							</tr>
							<tr>
								<td class="tamano01" style="width:3cm;">.: Consecutivo:</td>
								<td style="width:10%;">
									<a href="#" onClick="atrasc(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $prev; ?>)">
										<img src="imagenes/back.png" alt="anterior" align="absmiddle">
									</a> 
									<input name="id" id="id" type="text" value="<?php echo $_POST[id]?>" maxlength="2" style="width:30%" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly>        
									<a href="#" onClick="adelante(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $next; ?>)">
										<img src="imagenes/next.png" alt="siguiente" align="absmiddle">
									</a> 
									<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo" id="maximo">
									<input type="hidden" value="<?php echo $_POST[minimo]?>" name="minimo" id="minimo">
								</td>
								<td class="tamano01" style="width:2cm;">.: Fecha Registro:</td>
								<td style="width:10%;"><input type="text" name="fechain" id="fechain" value="<?php echo $_POST[fechain]?>" maxlength="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" style="width:75%;" readonly/>&nbsp;<img src="imagenes/calendario04.png" onClick="displayCalendarFor('fechain');" class="icobut" title="Calendario"/></td>
								<td class="tamano01" style="width:3cm;">.: Estado:</td>
								<td style="width:10%;"><input type="text" name="estmatricula" id="estmatricula" value="<?php echo @$_POST['estmatricula']?>" style="width:100%" readonly/></td>
								<td></td>
								<td rowspan="11"></td>
							</tr>
							<input type="hidden" name="idcargoad" id="idcargoad" value="<?php echo $_POST[idcargoad]?>"/>
							<tr>
								<td class="tamano01">.: Tercero:</td>
								<td><input type="text" name="tercero" id="tercero" onKeyUp="return tabular(event,this)" onBlur="buscar('1')" value="<?php echo $_POST[tercero]?>" style="width:80%" readonly></td>
								<td  colspan="4"><input type="text" name="ntercero" id="ntercero" value="<?php echo $_POST[ntercero]?>" style="width:100%" readonly></td>
								<?php
									if($_POST[ntercero]==""){$editer=" class='icobut1' src='imagenes/usereditd.png'";}
									else{$editer=" class='icobut' src='imagenes/useredit.png' onClick=\"mypop=window.open('teso-editaterceros.php?idter=$_POST[idterc]','','');mypop.focus();\"";}
								?>
								<td style="width:1.5cm;">&nbsp;<img <?php echo $editer; ?> title="Editar Tercero" /></td>
							</tr>
							<tr>
								<td class="tamano01">.: Direcci&oacute;n:</td>
								<td colspan="5"><input type="text" name="direccion" id="direccion" value="<?php echo $_POST[direccion]?>" style="width:100%;" readonly/></td>
							</tr>
							<tr>
								<td class="tamano01">.: Telefono:</td>
								<td><input type="text" name="telefono" id="telefono" value="<?php echo $_POST[telefono]?>" style="width:100%;" readonly/></td>
								<td class="tamano01" style="width:10%;">.: Celular:</td>
								<td colspan="3"><input type="text" name="celular" id="celular" value="<?php echo $_POST[celular]?>" style="width:100%;" readonly/></td>
							</tr>
							<tr>
								<td class="tamano01">.: E-mail:</td>
								<td colspan="5"><input type="text" name="email" id="email" value="<?php echo $_POST[email]?>" style="width:100%;" readonly/></td>
							</tr>
						</table>
					</div>
				</div>
				<!--Establecimientos-->
				<div class="tab">
					<input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?> >
					<label for="tab-2">Establecimientos</label>
					<div class="content" style="overflow-x:hidden;">
						<table class="inicio">
							<tr>
								<td class="titulos" colspan="8">.: Ingresar Datos del Establecimiento</td>
							</tr>
							<tr>
								<td class="saludo1" style="width:10%;">.: Fecha Matricula:</td>
								<td style="width:10%;">
									<input type="text" name="fechaMatricula" id="fechaMatricula" value="<?php echo $_POST[fechaMatricula]?>" maxlength="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" style="width:80%;"/>&nbsp;<img src="imagenes/calendario04.png" onClick="displayCalendarFor('fechaMatricula');" class="icobut" title="Calendario"/>
								</td>
							</tr>
							<tr>
								<td class="saludo1">.: Razon Social: </td>
								<td colspan="5">
									<input type="text" name="razonSocial" id="razonSocial" value="<?php echo $_POST[razonSocial]?>" style="width:100%;" />
								</td>
							</tr>
							<tr>
								<td class="saludo1">.: Direccion: </td>
								<td colspan="5">
									<input type="text" name="direccionEstablecimiento" id="direccionEstablecimiento" value="<?php echo $_POST[direccionEstablecimiento]?>" style="width:100%;" />
								</td>
							</tr>
							<tr>
								<td class="saludo1">.: Inicio Actividad:</td>
								<td>
									<input type="text" name="fechaInicio" id="fechaInicio" value="<?php echo $_POST[fechaInicio]?>" maxlength="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" style="width:80%;"/>&nbsp;<img src="imagenes/calendario04.png" onClick="displayCalendarFor('fechaInicio');" class="icobut" title="Calendario"/>
								</td>
								<td class="saludo1">.: Valor Activos:</td>
								<td>
									<input type="text" name="valorActivo" id="valorActivo" data-a-sign="$" data-a-dec="<?php echo $_SESSION["spdecimal"];?>" data-a-sep="<?php echo $_SESSION["spmillares"];?>" data-v-min='0' onKeyUp="sinpuntitos3('valor','valorActivo','".$_SESSION["spdecimal"]."');return tabular(event,this);" value="<?php echo $_POST[valorActivo]; ?>" style='width:13%;text-align:right;' />
								</td>
							</tr>
							<tr>
								<td class="saludo1">.: Local</td>
								<td colspan="2">
									<input type="text" name="local" id="local" value="<?php echo $_POST[local] ?>" style="width:100%;">
								</td>
								<td><em class="botonflecha" onClick="agregadet();">Agregar</em></td>
							</tr>
						</table>
					</div>
				</div>
				<?php
					if($_POST[oculto]=='3')
					{
						$posi=$_POST[elimina];
						unset($_POST[numMatriculaDet][$posi]);
						unset($_POST[fechaMatriculaDet][$posi]);
						unset($_POST[razonSocialDet][$posi]);
						unset($_POST[direccionEstablecimientoDet][$posi]);
						unset($_POST[fechaInicioDet][$posi]);
						unset($_POST[valorActivoDet][$posi]);
						unset($_POST[localDet][$posi]);
						$_POST[numMatriculaDet]= array_values($_POST[numMatriculaDet]); 
						$_POST[fechaMatriculaDet]= array_values($_POST[fechaMatriculaDet]); 
						$_POST[razonSocialDet]= array_values($_POST[razonSocialDet]); 
						$_POST[direccionEstablecimientoDet]= array_values($_POST[direccionEstablecimientoDet]);
						$_POST[fechaInicioDet]= array_values($_POST[fechaInicioDet]);
						$_POST[valorActivoDet]= array_values($_POST[valorActivoDet]); 
						$_POST[localDet]= array_values($_POST[localDet]);
						echo"
							<script>
								if(document.form2.numMatricula.value>1)
									{
										document.form2.numMatricula.value=document.form2.numMatricula.value-1;
									}	
							</script>";
						$_POST[elimina]='';
					}
					if($_POST[oculto]=='7')
					{
						$posi=$_POST[anula];
						$sqlr = "UPDATE tesoestablecimiento SET estado='N' WHERE id='$posi'";
						mysql_query($sqlr,$linkbd);
						$_POST[anula]='';
						echo "
							<script>
								document.form2.submit();
							</script>
						";
					}
					if($_POST[oculto]=='8')
					{
						$posi=$_POST[anula];
						$sqlr = "UPDATE tesoestablecimiento SET estado='S' WHERE id='$posi'";
						mysql_query($sqlr,$linkbd);
						$_POST[anula]='';
						echo "
							<script>
								document.form2.submit();
							</script>
						";
					}
					if($_POST[oculto]=='4')
					{
						$_POST[numMatriculaDet][]=$_POST[id];
						$_POST[fechaMatriculaDet][]=$_POST[fechaMatricula];
						$_POST[razonSocialDet][]=$_POST[razonSocial];
						$_POST[direccionEstablecimientoDet][]=$_POST[direccionEstablecimiento];
						$_POST[fechaInicioDet][]=$_POST[fechaInicio];
						$_POST[valorActivoDet][]=$_POST[valorActivo];
						$_POST[localDet][]=$_POST[local];
						echo"
							<script>
								document.form2.numMatricula.value=parseInt(document.form2.numMatricula.value) + 1;
								document.form2.fechaMatricula.value='';
								document.form2.razonSocial.value='';							
								document.form2.direccionEstablecimiento.value='';
								document.form2.fechaInicio.value='';
								document.form2.valorActivo.value='';
								document.form2.local.value='';
								document.form2.razonSocial.focus();	
							</script>";
							//echo "hola";
					}
					for($x=0;$x<count($_POST[numMatriculaDet]);$x++)
					{
						echo "
							<input type='hidden' name='numMatriculaDet[]' value='".$_POST[numMatriculaDet][$x]."'/>
							<input type='hidden' name='fechaMatriculaDet[]' value='".$_POST[fechaMatriculaDet][$x]."'/>
							<input type='hidden' name='razonSocialDet[]' value='".$_POST[razonSocialDet][$x]."'/>
							<input type='hidden' name='direccionEstablecimientoDet[]' value='".$_POST[direccionEstablecimientoDet][$x]."'/>
							<input type='hidden' name='fechaInicioDet[]' value='".$_POST[fechaInicioDet][$x]."'/>
							<input type='hidden' name='valorActivoDet[]' value='".$_POST[valorActivoDet][$x]."'/>
							<input type='hidden' name='localDet[]' value='".$_POST[localDet][$x]."'/>
							<input type='hidden' name='estadoDet[]' value='".$_POST[estadoDet][$x]."'/>
							<input type='hidden' name='idDet[]' value='".$_POST[idDet][$x]."'/>
						";
					}
				?>
				<!--Codigos CIIU-->
				<div class="tab">
					<input type="radio" id="tab-3" name="tabgroup1" value="3" <?php echo $check3;?> >
					<label for="tab-3">Codigos CIIU</label>
					<div class="content" style="overflow-x:hidden;">
						<table class="inicio">
							<tr>
								<td class="titulos" colspan="8">.: Ingresar Los codigos CIIU</td>
							</tr>
							<tr>
								<td class="saludo1" style="width:10%;">Acti Economica:</td>
								<td colspan="2"  style="width:10%;">
									<input type="text" name="ciiu" value="<?php echo $_POST[ciiu]?>" onKeyUp="return tabular(event,this) " onBlur="consultaciiu()"  style="width:76%;">
									<input type="hidden" name="tciiu" value="<?php echo $_POST[tciiu]?>" >
									<input type="hidden" value="0" name="bci">&nbsp;<img src="imagenes/find02.png" class="icobut" onClick="despliegamodal2('visible','3')"/>
								</td>
								<td style="width:20%;">
									<input type="text" name="nciiu" style="width:90%;" value="<?php echo $_POST[nciiu]?>" readonly>
								</td>
								<td class="saludo1" style="width:10%;">.: Numero Matricula:</td>
								<td style="width:15%;">
									<select name="nuMatriculaCiiu"  id="nuMatriculaCiiu" style="width:80%;">
										<option value="-1">Seleccione ....</option>
										<?php
										for($y = 0; $y < count($_POST['numMatriculaDet']); $y++)
										{
											if($_POST['numMatriculaDet'][$y]==$_POST['nuMatriculaCiiu'])
											{
												echo "<option value='".$_POST['numMatriculaDet'][$y]."' SELECTED>".$_POST['numMatriculaDet'][$y]." - ".$_POST['razonSocialDet'][$y]."</option>";
											}
											echo "<option value='".$_POST['numMatriculaDet'][$y]."'>".$_POST['numMatriculaDet'][$y]." - ".$_POST['razonSocialDet'][$y]."</option>";
										}
										?> 
									</select>
								</td>
								<td><em class="botonflecha" onClick="agregadetciiu();">Agregar</em></td>
							</tr>
						</table>
						<table class="inicio">
							<td class="titulos2" style="width:14%">C&oacute;digo CIIU</td>
							<td class="titulos2" style="width:60%">nombre</td>
							<td class="titulos2" style="width:20%">N&uacute;mero de matr&iacute;cula</td>
							<td class="titulos2" style="width:6%">Eliminar</td>
							<?php
								for ($x=0;$x<count($_POST[ciiuDet]);$x++)
								{
									//echo $_POST[estadoCiiuDet][$x]."<br>";
									echo "
										<input type='hidden' name='ciiuDet[]' value='".$_POST['ciiuDet'][$x]."'/>
										<input type='hidden' name='nciiuDet[]' value='".$_POST['nciiuDet'][$x]."'/>
										<input type='hidden' name='estadoCiiuDet[]' value='".$_POST['estadoCiiuDet'][$x]."'/>
										<input type='hidden' name='nuMatriculaCiiuDet[]' value='".$_POST['nuMatriculaCiiuDet'][$x]."'/>
									";
								}
								if($_POST[oculto]=='6')
								{
									$posi=$_POST[eliminaciiu];
									unset($_POST[ciiuDet][$posi]);
									unset($_POST[nciiuDet][$posi]);
									unset($_POST[nuMatriculaCiiuDet][$posi]);
									unset($_POST[direccionEstablecimientoDet][$posi]);
									unset($_POST[fechaInicioDet][$posi]);
									unset($_POST[valorActivoDet][$posi]);
									unset($_POST[localDet][$posi]);
									$_POST[ciiuDet]= array_values($_POST[ciiuDet]);
									$_POST[nciiuDet]= array_values($_POST[nciiuDet]);
									$_POST[nuMatriculaCiiuDet]= array_values($_POST[nuMatriculaCiiuDet]); 
									$_POST[eliminaciiu]='';
								}
								if($_POST[oculto]=='9')
								{
									$posi=$_POST[anula];
									$sqlr = "UPDATE tesoestablecimientociiu SET estado='N' WHERE id='$posi'";
									mysql_query($sqlr,$linkbd);
									$_POST[anula]='';
									echo "
										<script>
											document.form2.submit();
										</script>
									";
								}
								if($_POST[oculto]=='10')
								{
									$posi=$_POST[anula];
									$sqlr = "UPDATE tesoestablecimientociiu SET estado='S' WHERE id='$posi'";
									mysql_query($sqlr,$linkbd);
									$_POST[anula]='';
									echo "
										<script>
											document.form2.submit();
										</script>
									";
								}
								if($_POST[oculto]=='5')
								{
									$_POST[ciiuDet][]=$_POST[ciiu];
									$_POST[nciiuDet][]=$_POST[nciiu];
									$_POST[nuMatriculaCiiuDet][]=$_POST[nuMatriculaCiiu];
									echo"
										<script>
											document.form2.ciiu.value='';
											document.form2.nciiu.value='';	
											document.form2.nuMatriculaCiiu.value='';								
											document.form2.ciiu.focus();	
										</script>";
								}
								$co="saludo1a";
								$co2="saludo2";
								for ($x=0;$x<count($_POST[ciiuDet]);$x++)
								{
									if($_POST[estadoCiiuDet][$x]=="S")
									{
										$imgsem="src='imagenes/sema_verdeON.jpg' title='Activo'";
										$coloracti="#0F0";
										$_POST[lswitch1]=1;
									}
									else
									{
										$imgsem="src='imagenes/sema_rojoON.jpg' title='Inactivo'";
										$coloracti="#C00";
										$_POST[lswitch1]=0;
									}
									$posicion = $_POST[idciiuDet][$x];
									$change="<input type='range' name='lswitch1[]' value='".$_POST[lswitch1]."' min ='0' max='1' step ='1' style='background:$coloracti; width:70%' onChange='cambioswitch1(\"".$posicion."\",\"".$_POST[lswitch1]."\")' />";
									echo "
										<tr class='$co'>
											<td style='text-align:letf;'>".$_POST[ciiuDet][$x]."</td>
											<td style='text-align:letf;'>".$_POST[nciiuDet][$x]."</td>
											<td style='text-align:letf;'>".$_POST[nuMatriculaCiiuDet][$x]."</td>
											<td style='text-align:center;'>$change</td>
										</tr>
									";
									$aux=$co;
									$co=$co2;
									$co2=$aux;
								}
							?>
						<input type='hidden' name='eliminaciiu' id='eliminaciiu'/>
						</table>
					</div>
				</div>
				<!--Generar pdf de Certificaci�n-->
				<div class="tab">
					<input type="radio" id="tab-4" name="tabgroup1" value="4" <?php echo $check4;?> >
					<label for="tab-4">Generar pdf de Certificaci&oacute;n</label> 
					<div class="content" style="overflow:hidden">
						<table class="inicio" align="center">
							<tr>
								<td class="titulos" colspan="8">.: GENERAR EL CERTIFICADO DE INDUSTRIA Y COMERCIO </td>
								<td class="cerrar" style="width:6%"><a href="#" onClick="cerrarventanas()"> Cerrar</a></td>
							</tr>
							<tr>
								<td class="saludo1">Certificado de industria y comercio:</td>
								<td>
									<input type="button" name="pdfsol2" id="pdfsol2" value="PDF Certificacion" onClick="pdfcertificado()">
								</td>
							</tr>
						</table>
					</div>
				</div>
				<!--Novedades-->
				<div class="tab">
					<input type="radio" id="tab-5" name="tabgroup1" value="5" <?php echo $check5;?> >
					<label for="tab-5">Novedades</label>
					<div class="content" style="overflow:hidden">
						<table class="inicio" align="center">
							<tr>
								<td class="titulos" colspan="6">.: NOVEDADES EN LA MATRICULA</td>
								<td class="cerrar" style="width:6%"><a href="#" onClick="cerrarventanas()"> Cerrar</a></td>
							</tr>
							<tr>
								<td class="tamano01" style="width:3cm;">N&uacute;mero:</td>
								<td style="width:10%"><input type="text" name="numnovedad" id="numnovedad" onKeyUp="return tabular(event,this)" value="<?php echo $_POST['numnovedad']?>" style="width:100%" readonly></td>
								<td class="tamano01" style="width:3cm;">.: Fecha Novedad:</td>
								<td style="width:10%"><input type="text" name="fechanov" id="fechanov" value="<?php echo $_POST['fechanov']?>" maxlength="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" style="width:80%;" readonly/>&nbsp;<img src="imagenes/calendario04.png" onClick="displayCalendarFor('fechanov');" class="icobut" title="Calendario"/></td>
								<td class="tamano01" style="width:3cm;">Tipo Novedad:</td>
								<td>
									<select name='tiponov' id='tiponov' onChange='cambionum();' style='width:100%'>
										<option value='' <?php if (@$_POST['tiponov']==''){echo 'selected';}?>>.......</option>
										<option value='1' <?php if (@$_POST['tiponov']=='1'){echo 'selected';}?>>Cancelar La Matricula</option>
										<option value='2' <?php if (@$_POST['tiponov']=='2'){echo 'selected';}?>>Cambio de Propietario</option>
									</select>
								</td>
							</tr>
							<tr>
								<td class="tamano01" >Detalles:</td>
								<td colspan="5"><input type="text" name="detnovedad" id="detnovedad" onKeyUp="return tabular(event,this)" value="<?php echo $_POST['detnovedad']?>" style="width:100%"/></td>
							</tr>
						</table>
					</div>
				</div>
			</div>
			<input type="hidden" name="oculto" id="oculto" value="1"/>
			<input type="hidden" name="vbuscar" id="vbuscar" value="0"/>
			<input type="hidden" name="idterc" id="idterc" value="<?php echo $_POST[idterc];?>"/>
			<input type="hidden" name="idfunc" id="idfunc" value="<?php echo $_POST[idfunc];?>"/>
			<div class="subpantalla" style="height:38.5%; width:99%;overflow-x:hidden" >
				<table class="inicio" width="99%">
					<tr>
						<td class="titulos" colspan="9">Detalles Del Establecimiento</td>
					</tr>
					<tr>
						<td class="titulos2" style="width:8%">No Matricula</td>
						<td class="titulos2" style="width:10%">Fecha de Matricula</td>
						<td class="titulos2" style="width:30%">Razon social</td>
						<td class="titulos2" style="width:15%">Direccion</td>
						<td class="titulos2">Fecha Inicio</td>
						<td class="titulos2">Local</td>
						<td class="titulos2">Valor Activos</td>
						<td class="titulos2" style="width:5%;">Estado</td>
					</tr>
					<?php
					$co="saludo1a";
					$co2="saludo2";
					for ($x=0;$x<count($_POST[numMatriculaDet]);$x++)
					{
						/*if($_POST[estadoDet][$x]=='S')
						{
							$posicion = $_POST[idDet][$x];
							$imgsem="src='imagenes/sema_verdeON.jpg' title='Activo'";$coloracti="#0F0";$_POST[lswitch1][$posicion]=0;
							$iconanu="<img src='imagenes/anular.png' onClick=\"anular($posicion)\" class='icoop' title='Anular'/>";
						}
						else {$imgsem="src='imagenes/sema_rojoON.jpg' title='Inactivo'";$coloracti="#C00";$_POST[lswitch1][$posicion]=1;}
						*/
						if($_POST[estadoDet][$x]=="S")
						{
							$imgsem="src='imagenes/sema_verdeON.jpg' title='Activo'";
							$coloracti="#0F0";
							$_POST[lswitch1]=1;
						}
						else
						{
							$imgsem="src='imagenes/sema_rojoON.jpg' title='Inactivo'";
							$coloracti="#C00";
							$_POST[lswitch1]=0;
						}
						$posicion = $_POST[idDet][$x];
						$change="<input type='range' name='lswitch1[]' value='".$_POST[lswitch1]."' min ='0' max='1' step ='1' style='background:$coloracti; width:70%' onChange='cambioswitch(\"".$posicion."\",\"".$_POST[lswitch1]."\")' />";
						echo "
							<tr class='$co'>
								<td style='text-align:letf;'>".$_POST[numMatriculaDet][$x]."</td>
								<td style='text-align:letf;'>".$_POST[fechaMatriculaDet][$x]."</td>
								<td style='text-align:letf;'>".$_POST[razonSocialDet][$x]."</td>
								<td style='text-align:letf;'>".$_POST[direccionEstablecimientoDet][$x]."</td>
								<td style='text-align:letf;'>".$_POST[fechaInicioDet][$x]."</td>
								<td style='text-align:letf;'>".$_POST[localDet][$x]."</td>
								<td style='text-align:right;'>".$_POST[valorActivoDet][$x]."</td>	
								<td style='text-align:center;'>$change</td>
							</tr>
						";
						$aux=$co;
						$co=$co2;
						$co2=$aux;
					}
					?>
					<input type='hidden' name='elimina' id='elimina'/>
					<input type='hidden' name='anula' id='anula'/>
				</table>
			</div>
			<?php
				if($_POST[oculto]==2)
				{
					/*
					$sqlr = "DELETE FROM tesoestablecimiento WHERE cedulanit='$_POST[tercero]'";
					mysql_query($sqlr,$linkbd);
					for ($x=0;$x<count($_POST[numMatriculaDet]);$x++)
					{
						$pos = strpos($_POST[fechaMatriculaDet][$x], '-');
						if($pos === false)
						{
							preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $_POST[fechaMatriculaDet][$x],$fecha);
							$fechamatricula = "$fecha[3]-$fecha[2]-$fecha[1]";
						}
						else
						{
							$fechamatricula = $_POST[fechaMatriculaDet][$x];
						}
						$pos = strpos($_POST[fechaInicioDet][$x], '-');
						if($pos === false)
						{
							preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $_POST[fechaInicioDet][$x],$fecha);
							$fechamainicio = "$fecha[3]-$fecha[2]-$fecha[1]";
						}
						else
						{
							$fechamainicio = $_POST[fechaInicioDet][$x];
						} 
						$sqlr = "INSERT INTO tesoestablecimiento (cedulanit,matricula,fechamatricula,valoractivos,razonsocial,direccion,fechainicio,local,estado) VALUES ($_POST[tercero],'".$_POST[numMatriculaDet][$x]."','$fechamatricula','".$_POST[valorActivoDet][$x]."','".$_POST[razonSocialDet][$x]."','".$_POST[direccionEstablecimientoDet][$x]."','$fechamainicio','".$_POST[localDet][$x]."','S')";
						if (!mysql_query($sqlr,$linkbd))
						{
							$noinsert = 1;
						}
						else
						{
							$noinsert = 0;
						}
						$sqlr = "DELETE FROM tesoestablecimientociiu WHERE matricula='".$_POST[numMatriculaDet][$x]."'";
						mysql_query($sqlr,$linkbd);
					}
					for ($y=0;$y<count($_POST[ciiuDet]);$y++)
					{
						$sqlr = "INSERT INTO tesoestablecimientociiu (ciiu,matricula,estado) VALUES ('".$_POST[ciiuDet][$y]."','".$_POST[nuMatriculaCiiuDet][$y]."','S')";
						mysql_query($sqlr,$linkbd);
					}
					if ($noinsert=='1')
					{
						$e =mysql_error(mysql_query($sqlr,$linkbd));
						echo"<script>despliegamodalm('visible','2','No se pudo ejecutar la peticion: $e');</script>";
					}
  					else {echo "<script>despliegamodalm('visible','1','Se ha actualizado el funcionario con Exito');</script>";}*/
				}
            ?>
		</form>
        <div id="bgventanamodal2">
			<div id="ventanamodal2">
				<IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"></IFRAME>
        	</div>
		</div>
    </body>
</html>