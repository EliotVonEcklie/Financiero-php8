<?php //V 1000 12/12/16 ?> 
<?php
	require "comun.inc";
	require "funciones.inc";
	require "validaciones.inc";
	require "conversor.php";
	session_start();
	$linkbd=conectar_bd();
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
				despliegamodalm('visible','4','Esta Seguro de Eliminar','2');
			}

			function eliminarciiu(variable)
			{
				document.getElementById('eliminaciiu').value=variable;
				despliegamodalm('visible','4','Esta Seguro de Eliminar','3');
			}
		</script>
		<?php titlepag(); ?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
    		<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
    		<tr><?php menu_desplegable("teso");?></tr>
			<tr>
  				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='teso-baseindustria.php'" class="mgbt"/><img src="imagenes/guarda.png" title="Guardar" onClick="guardar()" class="mgbt"/><img src="imagenes/busca.png" title="Buscar" onClick="location.href='teso-buscabaseindustria.php'" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" onClick="<?php echo paginasnuevas("teso");?>" class="mgbt"><img src='imagenes/iratras.png' title='Men&uacute; Nomina' onClick="location.href='#'" class='mgbt'></td>
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
				if(!$_POST[oculto])
				{
					$check1="checked";
				}
				switch($_POST[tabgroup1])
				{
					case 1:	$check1='checked';break;
					case 2: $check2='checked';break;
					case 3: $check3='checked';break;
				}
				if ($_POST[vbuscar]=="1")
				{
					$sqlr="SELECT nombre1,nombre2,apellido1,apellido2,direccion,telefono,celular,email,id_tercero,razonsocial FROM terceros where cedulanit='$_POST[tercero]' AND estado='S'";
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
				}
				$sqlr="SELECT MAX(id) FROM tesorepresentantelegal";
				$resp = mysql_query($sqlr,$linkbd);
				$row = mysql_fetch_row($resp);
				if($_POST[id]=='')
					$_POST[id]=$row[0]+1;
			?>
			<div class="tabs" style="height:20%; width:99.7%">
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
								<td class="saludo1" style="width:3cm;">.: Consecutivo:</td>
								<td style="width:3%;"><input type="text" name="id" id="id" value="<?php echo $_POST[id]?>" style="width:80%;" readonly/></td>
								<td class="saludo1" style="width:3cm;">.: Fecha Registro:</td>
								<td><input type="text" name="fechain" id="fechain" value="<?php echo $_POST[fechain]?>" maxlength="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" style="width:15%;" readonly/>&nbsp;<img src="imagenes/calendario04.png" onClick="displayCalendarFor('fechain');" class="icobut" title="Calendario"/></td>
								<td></td>
								<td colspan="2"></td>
								<td></td>
								<td rowspan="11"></td>
							</tr>
							<input type="hidden" name="idcargoad" id="idcargoad" value="<?php echo $_POST[idcargoad]?>"/>
							<tr>
								<td class="saludo1">.: Tercero:</td>
								<td style="width:15%;"><input type="text" name="tercero" id="tercero" onKeyUp="return tabular(event,this)" onBlur="buscar('1')" value="<?php echo $_POST[tercero]?>" style="width:80%">&nbsp;<img class="icobut" src="imagenes/find02.png"  title="Listado Terceros" onClick="despliegamodal2('visible','1');"/></td>
								<td style="width:50%;" colspan="3"><input type="text" name="ntercero" id="ntercero" value="<?php echo $_POST[ntercero]?>" style="width:100%" readonly></td>
								<?php
									if($_POST[ntercero]==""){$editer=" class='icobut1' src='imagenes/usereditd.png'";}
									else{$editer=" class='icobut' src='imagenes/useredit.png' onClick=\"mypop=window.open('hum-terceroseditar01.php?idter=$_POST[idterc]','','');mypop.focus();\"";}
								?>
								<td style="width:1.5cm;">&nbsp;<img class="icobut" src="imagenes/usuarion.png" title="Crear Tercero" onClick="mypop=window.open('hum-terceros01.php','','');mypop.focus();"/>&nbsp;<img <?php echo $editer; ?> title="Editar Tercero" /></td>
							</tr>
							<tr>
								<td class="saludo1">.: Direcci&oacute;n:</td>
								<td colspan="5"><input type="text" name="direccion" id="direccion" value="<?php echo $_POST[direccion]?>" style="width:100%;" readonly/></td>
							</tr>
							<tr>
								<td class="saludo1">.: Telefono:</td>
								<td><input type="text" name="telefono" id="telefono" value="<?php echo $_POST[telefono]?>" style="width:100%;" readonly/></td>
								<td class="saludo1" style="width:10%;">.: Celular:</td>
								<td colspan="3"><input type="text" name="celular" id="celular" value="<?php echo $_POST[celular]?>" style="width:100%;" readonly/></td>
							</tr>
							<tr>
								<td class="saludo1">.: E-mail:</td>
								<td colspan="5"><input type="text" name="email" id="email" value="<?php echo $_POST[email]?>" style="width:100%;" readonly/></td>
							</tr>
						</table>
					</div>
				</div>
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
								<td class="saludo1" style="width:10%;">.: Valor Activos:</td>
								<td>
									<input type="text" name="valorActivo" id="valorActivo" data-a-sign="$" data-a-dec="<?php echo $_SESSION["spdecimal"];?>" data-a-sep="<?php echo $_SESSION["spmillares"];?>" data-v-min='0' onKeyUp="sinpuntitos3('valor','valorActivo','".$_SESSION["spdecimal"]."');return tabular(event,this);" value="<?php echo $_POST[valorActivo]; ?>" style='width:11%;text-align:right;' />
								</td>
							</tr>
							<tr>
								<td class="saludo1">.: Local</td>
								<td colspan="2">
									<input type="Texto" name="local" id="local" value="<?php echo $_POST[local] ?>" style="width:100%;">
								</td>
								<td style=" padding-bottom:5px"><em class="botonflecha" onClick="agregadet();">Agregar</em></td>
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
					$_POST[elimina]='';
				}
				if($_POST[oculto]=='4')
				{
					$_POST[numMatriculaDet][]=$_POST[tercero];
					$_POST[fechaMatriculaDet][]=$_POST[fechaMatricula];
					$_POST[razonSocialDet][]=$_POST[razonSocial];
					$_POST[direccionEstablecimientoDet][]=$_POST[direccionEstablecimiento];
					$_POST[fechaInicioDet][]=$_POST[fechaInicio];
					$_POST[valorActivoDet][]=$_POST[valorActivo];
					$_POST[localDet][]=$_POST[local];
					echo"
						<script>
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
					";
				}
				?>
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
								<td class="saludo1" style="width:10%;">.: Tipo Actividad:</td>
								<td style="width:15%;">
									<select name="nuMatriculaCiiu"  id="nuMatriculaCiiu" style="width:80%;">
										<option value="-1">Seleccione ....</option>
										<option value="PRINCIPAL">Actividad Principal</option>
										<option value="SECUNDARIA">Actividad Secundaria</option>
									</select>
								</td>
								<td style=" padding-bottom:5px"><em class="botonflecha" onClick="agregadetciiu();">Agregar</em></td>
							</tr>
						</table>
						<table class="inicio">
							<td class="titulos2" style="width:14%">Codigo CIIU</td>
							<td class="titulos2" style="width:60%">nombre</td>
							<td class="titulos2" style="width:20%">Numero de matricula</td>
							<td class="titulos2" style="width:6%">Eliminar</td>

							<?php
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
									echo "
										<input type='hidden' name='ciiuDet[]' value='".$_POST[ciiuDet][$x]."'/>
										<input type='hidden' name='nciiuDet[]' value='".$_POST[nciiuDet][$x]."'/>
										<input type='hidden' name='nuMatriculaCiiuDet[]' value='".$_POST[nuMatriculaCiiuDet][$x]."'/>
										<tr class='$co'>
											<td style='text-align:letf;'>".$_POST[ciiuDet][$x]."</td>
											<td style='text-align:letf;'>".$_POST[nciiuDet][$x]."</td>
											<td style='text-align:letf;'>".$_POST[nuMatriculaCiiuDet][$x]."</td>
											<td style='text-align:center;'><img src='imagenes/del.png' onclick='eliminarciiu($x)' class='icoop'></td>	
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
                        <td class="titulos2" style="width:6%">Eliminar</td>
                	</tr>
					<?php
					$co="saludo1a";
		  			$co2="saludo2";
					for ($x=0;$x<count($_POST[numMatriculaDet]);$x++)
					{
						echo "
							<tr class='$co'>
								<td style='text-align:letf;'>".$_POST[numMatriculaDet][$x]."</td>
								<td style='text-align:letf;'>".$_POST[fechaMatriculaDet][$x]."</td>
								<td style='text-align:letf;'>".$_POST[razonSocialDet][$x]."</td>
								<td style='text-align:letf;'>".$_POST[direccionEstablecimientoDet][$x]."</td>
								<td style='text-align:letf;'>".$_POST[fechaInicioDet][$x]."</td>
								<td style='text-align:letf;'>".$_POST[localDet][$x]."</td>
								<td style='text-align:right;'>".$_POST[valorActivoDet][$x]."</td>	
								<td style='text-align:center;'><img src='imagenes/del.png' onclick='eliminar($x)' class='icoop'></td>	
							</tr>
						";
						$aux=$co;
						$co=$co2;
		 				$co2=$aux;
					}
					?>
					<input type='hidden' name='elimina' id='elimina'/>
				</table>
			</div>
            <?php
				if($_POST[oculto]==2)
				{
					
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
						$sqlr = "INSERT INTO tesoestablecimiento (cedulanit,matricula,fechamatricula,valoractivos,razonsocial,direccion,fechainicio,local,estado) VALUES ('".$_POST[numMatriculaDet][$x]."','$_POST[id]','$fechamatricula','".$_POST[valorActivoDet][$x]."','".$_POST[razonSocialDet][$x]."','".$_POST[direccionEstablecimientoDet][$x]."','$fechamainicio','".$_POST[localDet][$x]."','S')";
						mysql_query($sqlr,$linkbd);
					}
					for ($y=0;$y<count($_POST[ciiuDet]);$y++)
					{
						$sqlr = "INSERT INTO tesoestablecimientociiu (ciiu,idrepresentantelegal,matricula,estado) VALUES ('".$_POST[ciiuDet][$y]."','$_POST[id]','".$_POST[nuMatriculaCiiuDet][$y]."','S')";
						mysql_query($sqlr,$linkbd);
					}
					$pos = strpos($_POST[fechain], '-');
					if($pos === false)
					{
						preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $_POST[fechain],$fecha);
						$fechaini="$fecha[3]-$fecha[2]-$fecha[1]";
					}
					else
					{
						$fechaini = $_POST[fechain];
					}
					$sqlr = "INSERT INTO tesorepresentantelegal(cedulanit,fecha,estado) VALUES ($_POST[tercero],'$fechaini','S')";
					//echo $sqlr;
					if (!mysql_query($sqlr,$linkbd))
					{
						$e =mysql_error(mysql_query($sqlr,$linkbd));
						echo"<script>despliegamodalm('visible','2','No se pudo ejecutar la peticion: $e');</script>";
					}
  					else {echo "<script>despliegamodalm('visible','1','Se ha almacenado el funcionario con Exito');</script>";}
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