<?php
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=iso-8859-1");
	require "comun.inc";
	require "funciones.inc";
	require "conversor.php";
	sesion();
	$linkbd=conectar_v7();
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	date_default_timezone_set("America/Bogota");
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=iso-8859-1"/>
		<meta http-equiv="X-UA-Compatible" content="ie=edge"/>
		<title>:: SPID - Tesoreria</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script type="text/javascript" src="css/calendario.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script type="text/javascript" src="JQuery/jquery-2.1.4.min.js"></script>
		<style>
			input[type='text']{height:30px;}
			input[type='search']{height:30px;}
			select{height:30px;}
		</style>
		<script>
			function buscacta(e)
			{
				if (document.form2.cuenta.value!="")
				{
					document.form2.bc.value='1';
					document.form2.submit();
				}
			}
			function validar()
			{
				document.form2.oculto.value='3';
				document.form2.submit();
			}
			function buscater(e)
			{
				if (document.form2.tercero.value!="")
				{
					document.form2.bt.value='1';
					document.form2.submit();
				}
			}
			function agregardetalle()
			{
				if(document.form2.codingreso.value!="" && document.form2.valor.value>0 )
				{ 
					document.form2.agregadet.value=1;
					document.form2.submit();
				}
				else 
				{
					alert("Falta informacion para poder Agregar");
				}
			}
			function eliminar(variable)
			{
				if (confirm("Esta Seguro de Eliminar"))
				{
					document.form2.elimina.value=variable;
					vvend=document.getElementById('elimina');
					vvend.value=variable;
					document.form2.submit();
				}
			}
			function guardar()
			{
				var fechabloqueo=document.form2.fechabloq.value;
				var fechadocumento=document.form2.fecha.value;
				var nuevaFecha=fechadocumento.split("/");
				var fechaCompara=nuevaFecha[2]+"-"+nuevaFecha[1]+"-"+nuevaFecha[0];

				if((Date.parse(fechabloqueo)) > (Date.parse(fechaCompara)))
				{
					despliegamodalm('visible','2','Fecha de documento menor que fecha de bloqueo');
				}
				else
				{
					if(document.form2.tipomovimiento.value=='201')
					{
						var validacion01=document.form2.idcomp.value;
						if(validacion01.trim()!='' && document.form2.fecha.value!='')
						{
							if (document.getElementById('nbanco').value!='')
							{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
							else {despliegamodalm('visible','2','Falta informacion para Crear la Cuenta');}
						}
						else {despliegamodalm('visible','2','Falta informacion para Crear la Cuenta');}
					}
					else {despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
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
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.getElementById('oculto').value="2";
								document.form2.submit();break;
					case "2":	document.getElementById('tipoelimina').value="1";
								document.form2.submit();break;
					case "3":	document.getElementById('tipoelimina').value="2";
								document.form2.submit();break;
				}
			}
			function funcionmensaje()
			{
				if(document.form2.tipomovimiento.value=='201')
				{
					var codig=document.form2.idcomp.value;
					document.location.href = "teso-editasinidentificar.php?idrecaudo="+codig;
				}
				else
				{
					var codig=document.form2.numIngreso.value;
					document.location.href = "teso-editasinidentificar.php?idrecaudo="+codig;
				}

			}
			function pdf()
			{
				document.form2.action="teso-pdfsinidentificar.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function buscater(e)
			{
				if (document.form2.tercero.value!="")
				{
					document.form2.bt.value='1';
					document.form2.submit();
				}
			}
			function buscaing(e)
			{
				if (document.form2.codingreso.value!="")
				{
					document.form2.bin.value='1';
					document.form2.submit();
				}
			}
			function despliegamodal2(_valor,_num)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else 
				{
					switch(_num)
					{
						case '1':	document.getElementById('ventana2').src="cuentasbancarias-ventana02.php?tipoc=D&obj01=banco&obj02=nbanco&obj03=&obj04=cb&obj05=ter";
									break;
						case '2':	document.getElementById('ventana2').src="reversar-ingreso.php";
									break;
					}
				}
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("teso");?></tr>
			<tr>
				<td colspan="3" class="cinta">
					<a href="teso-sinidentificar.php" class="mgbt"><img src="imagenes/add.png" alt="Nuevo"  border="0" /></a>
					<a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png"  alt="Guardar" /></a>
					<a href="teso-buscasinidentificar.php" class="mgbt"> <img src="imagenes/busca.png"  alt="Buscar" /></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana"></a>
					<a href="#" <?php if(@ $_POST['oculto']==2) { echo "onClick='pdf()'"; } ?> class="mgbt"> <img src="imagenes/print.png"  alt="Buscar" /></a>
				</td>
			</tr>
		</table>
		<?php
			$vigusu=vigencia_usuarios($_SESSION['cedulausu']);
			$vigencia=$vigusu;
			$sesion=$_SESSION['cedulausu'];
			$_POST['vigencia']=$vigencia;
			$sqlr="SELECT valor_inicial,descripcion_valor FROM dominios WHERE nombre_dominio='INGRESOS_IDENTIFICAR'";
			$res=mysqli_query($linkbd,$sqlr);
			while ($row =mysqli_fetch_row($res)) 
			{
				$_POST['codingreso']=$row[0];
				$_POST['ningreso']=$row[1];
			}
			if(@ $_POST['oculto']=='3')
			{
				unset($_POST['dcoding']);
				unset($_POST['dncoding']);
				unset($_POST['dvalores']);
				unset($_POST['concepto']);
				unset($_POST['totalc']);
				$_POST['idcomp']=$consec=selconsecutivo('tesosinidentificar','id_recaudo');
				$fec=date("d/m/Y");
				$_POST['fecha']=$fec;
				$_POST['valor']=0;
			}
			if(! @ $_POST['oculto'])
			{
				$check1="checked";
				$_POST['tipomovimiento']='201';
				$fec=date("d/m/Y");
				$_POST['vigencia']=$vigencia;
				$_POST['idcomp']=$consec=selconsecutivo('tesosinidentificar','id_recaudo');
				$fec=date("d/m/Y");
				$_POST['fecha']=$fec;
				$_POST['valor']=0;
			}
			switch(@ $_POST['tabgroup1'])
			{
				case 1:
					$check1='checked';
				break;
				case 2:
					$check2='checked';
				break;
				case 3:
					$check3='checked';
			}
		?>
		<div id="bgventanamodalm" class="bgventanamodalm">
			<div id="ventanamodalm" class="ventanamodalm">
				<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
				</IFRAME>
			</div>
		</div>
		<form name="form2" method="post" action=""> 
			<?php
				$sqlr="SELECT T2.valor_final FROM usuarios AS T1,dominios AS T2 WHERE T1.cc_usu='$sesion' AND T2.nombre_dominio='PERMISO_MODIFICA_DOC' AND T2.valor_inicial=T1.cc_usu ";
				$resp = mysqli_query($linkbd,$sqlr);
				$fechaBloqueo=mysqli_fetch_row($resp);
				echo "<input type='hidden' name='fechabloq' id='fechabloq' value='$fechaBloqueo[0]' />";
				if(@ $_POST['bt']=='1')//***** busca tercero
				{
					$nresul=buscatercero($_POST['tercero']);
					if($nresul!='')
					{
						$_POST['ntercero']=$nresul;
					}
					else
					{
						$_POST['bt']="";
						echo"
						<script>
							despliegamodalm('visible','2','Tercero Incorrecto o no Existe');
							document.form2.tercero.focus();
							document.getElementById('tercero').focus()
						</script>";
					}
				}
				if(@ $_POST['bin']=='1')//***** busca tercero
				{
					$nresul=buscaingreso($_POST['codingreso']);
					if($nresul!='')
					{
						$_POST['ningreso']=$nresul;
					}
					else
					{
						$_POST['ningreso']="";
					}
				}
			?>
			<table class="inicio">
				<tr>
					<td class="titulos" style="width:100%;">.: Tipo de Movimiento
						<input type="hidden" value="1" name="oculto" id="oculto">
						<select name="tipomovimiento" id="tipomovimiento" onKeyUp="return tabular(event,this)" onChange="validar()" style="width:20%;" >
							<?php
								$user=$_SESSION['cedulausu'];
								$sql="SELECT * FROM permisos_movimientos WHERE usuario='$user' AND estado='T' ";
								$res=mysqli_query($linkbd,$sql);
								$num=mysqli_num_rows($res);
								if($num==1)
								{
									$sqlr="SELECT * FROM tipo_movdocumentos WHERE estado='S' AND modulo=4 AND (id='2' OR id='4')";
									$resp = mysqli_query($linkbd,$sqlr);
									while ($row =mysqli_fetch_row($resp)) 
									{
										if($_POST['tipomovimiento']==$row[0].$row[1])
										{
											echo "<option value='$row[0]$row[1]' SELECTED >$row[0]$row[1]-$row[2]</option>";
										}
										else
										{
											echo "<option value='$row[0]$row[1]'>$row[0]$row[1]-$row[2]</option>";
										}
									}
								}
								else
								{
									$sql="SELECT codmov,tipomov from permisos_movimientos WHERE usuario='$user' AND estado='S' AND modulo='4' AND transaccion='TPB'";
									$res=mysqli_query($linkbd,$sql);
									while($row = mysqli_fetch_row($res))
									{
										if(@ $_POST['tipomovimiento']==$row[0])
										{
											echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";
										}
										else
										{
											echo "<option value='$row[0]'>$row[0] - $row[1]</option>";
										}
									}
								}
							?>
						</select>
					</td>
					<td style="width:80%;"></td>
				</tr>
			</table>
			<?php 
			if (@ $_POST['tipomovimiento']=='201') 
			{
				$altudeta='33%';
				echo"
				<table class='inicio' align='center'>
					<tr>
						<input type='hidden' name='vguardar' id='vguardar' value=''>
						<td  class='titulos' colspan='2'>Ingresos Sin Identificar</td>
						<td class='cerrar' style='width:7%' onClick=\"location.href='teso-principal.php'\">Cerrar</td>
					</tr>
					<tr>
						<td style='width:80%;'>
							<table>
								<tr>
									<td style='width:2.5cm;' class='tamano01'>N&uacute;mero Ingreso:</td>
									<td style='width:18%;'><input type='text' name='idcomp' id='idcomp' value='".@ $_POST['idcomp']."' onKeyUp=\"return tabular(event,this)\" style='width:100%;' readonly/></td>
									<td class='tamano01' style='width:2cm;'>Fecha:</td>
									<td style='width:10%;'><input type='text' name='fecha' id='fc_1198971545' title='DD/MM/YYYY' style='width:75%;' value='".@ $_POST['fecha']."' onKeyUp=\"return tabular(event,this)\" maxlength='10' onKeyDown=\"mascara(this,'/',patron,true)\"/>&nbsp;<img src='imagenes/calendario04.png' class='icobut' onClick=\"displayCalendarFor('fc_1198971545');\" title='Calendario'/></td>
									<td class='tamano01'>Vigencia:</td>
									<td style='width:5%;'><input type='text' id='vigencia' name='vigencia' onKeyPress=\"javascript:return solonumeros(event)\" onKeyUp=\"return tabular(event,this)\" style='width:100%;' value='".@ $_POST['vigencia']."' onClick=\"document.getElementById('tipocta').focus(); document.getElementById('tipocta').select();\" readonly/></td>
									<td></td>
								</tr>
								<tr>
									<td class='tamano01'>Cuenta :</td>
									<td><input type='text' name='cb' id='cb' value='".@ $_POST['cb']."' style='width:100%;' onDblClick=\"despliegamodal2('visible','1');\" title='Doble Click: Listado Cuentas Bancarias'/></td>
									<td colspan='5'><input type='text' id='nbanco' name='nbanco' style='width:100%;' value='".@ $_POST['nbanco']."' readonly></td>
								</tr>
								<input type='hidden' name='banco' id='banco' value='".@ $_POST['banco']."'/>
								<input type='hidden' id='ter' name='ter' value='".@ $_POST['ter']."'/>
								<tr>
									<td  class='tamano01'>Concepto Recaudo:</td>
									<td colspan='6'><input type='text' name='concepto' value='".@ $_POST['concepto']."' style='width:100%;' onKeyUp=\"return tabular(event,this)\"/></td>
								</tr>
								<tr>
									<td class='tamano01'>NIT:</td>
									<td><input type='text' name='tercero' value='".@ $_POST['tercero']."' onKeyUp=\"return tabular(event,this)\" onBlur=\"buscater(event)\" onDblClick=\"mypop=window.open('terceros-ventana.php?ti=1','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();\" title='Doble Click: Listado Terceros' style='width:100%;'/></td>
									<td class='tamano01'>Contribuyente:</td>
									<td><input type='text' id='ntercero' name='ntercero' value='".@ $_POST['ntercero']."' style='width:100%;' onKeyUp=\"return tabular(event,this)\" readonly></td>
									<input type='hidden' value='0' name='bt'>
									<input type='hidden' name='ct' id='ct' value='".@ $_POST['ct']."'/>
									<td class='tamano01'>Ingreso:</td>
									<td><input type='text' name='codingreso' id='codingreso' value='".@ $_POST['codingreso']."' style='width:100%;' onKeyUp=\"return tabular(event,this)\" onBlur=\"buscaing(event)\" readonly/></td>
									<input type='hidden' value='0' name='bin'/>
									<td><input type='text' name='ningreso' id='ningreso' value=".@ $_POST['ningreso']." style='width:100%;' readonly></td> 
								</tr>
								<tr>
									<td class='tamano01' style='height:33px;'>Centro Costo:</td>
									<td>
										<select name='cc' onKeyUp=\"return tabular(event,this)\" style='width:100%;'>";
				$sqlr="SELECT * FROM centrocosto WHERE estado='S'";
				$res=mysqli_query($linkbd,$sqlr);
				while ($row =mysqli_fetch_row($res))
				{
					if($row[0]==$_POST['cc'])
					{
						echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";
					}
					else{echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
				}
				echo"
										</select>
									</td>
									<td class='tamano01'>Valor:</td>
									<td><input type='text' id='valor' name='valor' value='".@ $_POST['valor']."' onKeyUp=\"return tabular(event,this)\"/></td>
									<td colspan='3' style='padding-top:3px'><em class='botonflecha' onClick=\"agregardetalle();\">Agregar</em></td>
									<input type='hidden' value='0' name='agregadet'/>
								</tr>
							</table>
						</td>
						<td colspan='3' style='width:20%; background:url(imagenes/FONDO-1.png); background-repeat:no-repeat; background-position:right; background-size: 100% 100%;'></td>
						</td>
					</tr>
				</table>";
				if(@ $_POST['bin']=='1')//*** ingreso
				{
					$nresul=buscaingreso($_POST['codingreso']);
					if($nresul!='')
					{
						$_POST['ningreso']=$nresul;
						echo"
						<script>
							document.getElementById('valor').focus();
							document.getElementById('valor').select();
						</script>";

					}
					else
					{
						$_POST['codingreso']="";
						echo
						"<script>
							alert('Codigo Ingresos Incorrecto)';
							document.form2.codingreso.focus();
						</script>";
					}
				}
			}
			else
			{
				$altudeta='50%';
				echo"
				<table class='inicio' aling='center'>
					<tr>
						<td class='titulos'>Reversion de ingresos por identificar</td>
						<td class='cerrar' style='width:7%' onClick=\"location.href='teso-principal.php'\">Cerrar</td>
					</tr>
				</table>
				<table class='inicio' aling='center'>
					<tr>
						<td class='tamano01' style='width:10%'>N&uacute;mero Ingreso:<td>
						<td style='width:10%'><input type='text' name='numIngreso' id='numIngreso' value='".@ $_POST['numIngreso']."' style='width:100%' onDblClick=\"despliegamodal2('visible','2');\" title='Doble Click: Buscar Ingreso' readonly></td>
						<input type='hidden' name='banco' id='banco' value='".@ $_POST['banco']."'/>
						<input type='hidden' name='tercero' id='tercero' value='".@ $_POST['tercero']."'/>
						<td class='tamano01' style='width:10%;'>Fecha:</td>
						<td style='width:10%;'>
							<input type='text' name='fecha' value='".@ $_POST['fecha']."' maxlength='10' onKeyPress=\"javascript:return solonumeros(event)\" onKeyUp=\"return tabular(event,this)\" id='fc_1198971545' onKeyDown=\"mascara(this,'/',patron,true)\" style='width:80%;' title='DD/MM/YYYY'/>&nbsp;<a onClick=\"displayCalendarFor('fc_1198971545');\" title='Calendario'><img src='imagenes/calendario04.png' style='width:20px;'/></a>
						</td>
						<td class='tamano01' style='width:10%;'>Descripcion: </td>
						<td style='width:60%;'><input type='text' name='descripcion' id='descripcion' style='width:80%;' value='".@ $_POST['descripcion']."'/></td>
					</tr>
					<tr>
						<td class='tamano01'>Concepto:<td>
						<td colspan='3'><input type='text' name='concepto' id='concepto' value='".@ $_POST['concepto']."' style='width:100%;' readonly/></td>
						<td class='tamano01'>Valor: </td>
						<td><input type='text' name='valorIngreso' id='valorIngreso' value='".@ $_POST['valorIngreso']."' readonly/></td>
					</tr>
				</table>";
				unset($_POST['dcoding']);
				unset($_POST['dncoding']);
				unset($_POST['dvalores']);
				$sqlr = "SELECT ingreso, valor FROM tesosinidentificar_det WHERE id_recaudo='".@ $_POST['numIngreso']."'";
				$res=mysqli_query($linkbd,$sqlr);
				while ($row =mysqli_fetch_row($res)) 
				{
					$_POST['dcoding'][]=$row[0];
					$_POST['dncoding'][]=buscaingreso($row[0]);
					$_POST['dvalores'][]=$row[1];
				}
			}
			?>
			<div class="subpantalla" style="height:<?php echo $altudeta;?>">
				<table class="inicio">
					<tr><td colspan="4" class="titulos">Detalle Ingresos Sin Identificar</td></tr>
					<tr>
						<td class="titulos2">C&oacute;digo</td>
						<td class="titulos2">Ingreso</td>
						<td class="titulos2">Valor</td>
						<td class="titulos2">
							<img src="imagenes/del.png" >
							<input type='hidden' name='elimina' id='elimina'>
						</td>
					</tr>
					<?php
						if (@ $_POST['elimina']!='')
						{ 
							$posi=$_POST['elimina'];
							unset($_POST['dcoding'][$posi]);
							unset($_POST['dncoding'][$posi]);
							unset($_POST['dvalores'][$posi]);
							$_POST['dcoding']= array_values($_POST['dcoding']);
							$_POST['dncoding']= array_values($_POST['dncoding']);
							$_POST['dvalores']= array_values($_POST['dvalores']);
						}
						if (@ $_POST['agregadet']=='1')
						{
							$_POST['dcoding'][]=$_POST['codingreso'];
							$_POST['dncoding'][]=$_POST['ningreso'];
							$_POST['dvalores'][]=$_POST['valor'];
							$_POST['agregadet']=0;
							echo"
								<script>
									document.form2.valor.value='';
									document.form2.valor.select();
									document.form2.valor.focus();
								</script>";
						}
						$_POST['totalc']=0;
						$iter='saludo1c';
						$iter2='saludo2c';
						for ($x=0;$x<count(@ $_POST['dcoding']);$x++)
						{
							echo "
							<input type='hidden' name='dcoding[]' value='".@ $_POST['dcoding'][$x]."'/>
							<input type='hidden' name='dncoding[]' value='".@ $_POST['dncoding'][$x]."'/>
							<input type='hidden' name='dvalores[]' value='".@ $_POST['dvalores'][$x]."'/>
							<tr class='$iter'>
								<td style='width:5%;'>".@ $_POST['dcoding'][$x]."</td>
								<td style='width:70%;'>".@ $_POST['dncoding'][$x]."</td>
								<td style='width:20%;'>".@ $_POST['dvalores'][$x]."</td>
								<td style='width:2%;'><img src='imagenes/del.png' onclick='eliminar($x)' class='icoop'></td>
							</tr>";
							$_POST['totalc']=$_POST['totalc']+$_POST['dvalores'][$x];
							$_POST['totalcf']=number_format($_POST['totalc'],2);
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux;
						}
						$resultado = convertir($_POST['totalc']);
						$_POST['letras']=$resultado." Pesos";
						echo "
							<tr>
								<td style='width:5%;'></td>
								<td class='saludo2' style='width:70%;'>Total</td>
								<td class='tamano01' style='width:20%;'>
									<input name='totalcf' type='text' style='width:100%;' value='".@ $_POST['totalcf']."'>
									<input name='totalc' type='hidden' value='".@ $_POST['totalc']."'>
								</td>
							</tr>
							<tr>
								<td class='tamano01' style='width:5%;'>Son:</td>
								<td style='width:70%;'>
									<input name='letras' type='text' value='".@ $_POST['letras']."' style='width:100%;'>
								</td>
							</tr>";
					?> 
				</table>
			</div>
			<?php
				if(@ $_POST['oculto']=='2')
				{
					if($_POST['tipomovimiento']=='201')
					{
						$sqlr="SELECT count(*) FROM tesosinidentificar WHERE id_recaudo='".$_POST['idcomp']."'";
						$res=mysqli_query($linkbd,$sqlr);
						while($r=mysqli_fetch_row($res))
						{
							$numerorecaudos=$r[0];
						}
						if($numerorecaudos==0)
						{
							preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $_POST['fecha'],$fecha);
							$fechaf="$fecha[3]-$fecha[2]-$fecha[1]";
							//*********************CREACION DEL COMPROBANTE CONTABLE ***************************
							//***cabecera comprobante
							$idcomp=$consec=$_POST['idcomp'];
							echo "<input type='hidden' name='ncomp' value='$idcomp'>";
							$sqlr="INSERT INTO comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito, total_credito,diferencia,estado) VALUES ($consec,27,'$fechaf','".strtoupper($_POST['concepto'])."', 0,'".$_POST['totalc']."','".$_POST['totalc']."',0,'1')";
							mysqli_query($linkbd,$sqlr);
							//******************* DETALLE DEL COMPROBANTE CONTABLE *********************
							for($x=0;$x<count($_POST['dcoding']);$x++)
							{
								//***** BUSQUEDA INGRESO ********
								$sqlri="SELECT * FROM tesoingresos_det WHERE codigo='".$_POST['dcoding'][$x]."' AND vigencia='$vigusu'";
								$resi=mysqli_query($linkbd,$sqlri);
								while($rowi=mysqli_fetch_row($resi))
								{
									//**** busqueda concepto contable*****
									$sqlrc="SELECT * FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='$rowi[2]' AND tipo='C' AND fechainicial=(SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='$rowi[2]' AND tipo='C' AND fechainicial<='$fechaf')";
									$resc=mysqli_query($linkbd,$sqlrc);
									while($rowc=mysqli_fetch_row($resc))
									{
										$porce=$rowi[5];
										if($_POST['cc']==$rowc[5])
										{
											if($rowc[6]=='N')
											{
												$valorcred=$_POST['dvalores'][$x]*($porce/100);
												$valordeb=0;
												$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) VALUES ('27 $consec','".$rowc[4]."','".$_POST['tercero']."','".$_POST['cc']."','Ingreso por Identificar ".strtoupper($_POST['dncoding'][$x])."','','$valordeb', '$valorcred','1','".$_POST['vigencia']."','27','$consec')";
												mysqli_query($linkbd,$sqlr);
												$valordeb=$_POST['dvalores'][$x]*($porce/100);
												$valorcred=0;
												$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) VALUES ('27 $consec','".$_POST['banco']."','".$_POST['tercero']."','".$_POST['cc']."','Ingreso por Identificar ".strtoupper($_POST['dncoding'][$x])."','','$valordeb', '$valorcred','1','".$_POST['vigencia']."','27','$consec')";
												mysqli_query($linkbd,$sqlr);
												$vi=$_POST['dvalores'][$x]*($porce/100);
											}
										}
									}
								}
							}
							//************ insercion de cabecera recaudos ************
							$sqlr="INSERT INTO tesosinidentificar (id_recaudo,idcomp,fecha,vigencia,banco,ncuentaban, concepto,tercero,cc,valortotal,estado,tipo_mov,usuario) VALUES ($idcomp,'','$fechaf', '".$_POST["vigencia"]."','".$_POST['ter']."','".$_POST['cb']."','".strtoupper($_POST['concepto'])."','".$_POST['tercero']."','".$_POST['cc']."','".$_POST['totalc']."','S','".$_POST['tipomovimiento']."','".$_SESSION['usuario']."')";
							mysqli_query($linkbd,$sqlr);
							//************** insercion de consignaciones **************
							for($x=0;$x<count($_POST['dcoding']);$x++)
							{
								$sqlr="INSERT INTO tesosinidentificar_det (id_recaudo,ingreso,valor,estado,tipo_mov) VALUES ($idcomp,'".$_POST['dcoding'][$x]."',".$_POST['dvalores'][$x].",'S', '".$_POST['tipomovimiento']."')";
								if (!mysqli_query($linkbd,$sqlr))
								{
									echo "<table >
											<tr>
												<td class='tamano01'><center><font color=blue><img src='imagenes/alert.png'> Manejador de Errores de la Clase BD<br><	font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
									echo "Ocurrió el siguiente problema:<br>";
									echo "<pre>";
									echo "</pre></center></td></tr></table>";
								}
								else
								{
									$sqlri="SELECT * FROM tesoingresos_det WHERE codigo='".$_POST['dcoding'][$x]."' AND vigencia='$vigusu'";
									$resi=mysqli_query($linkbd,$sqlri);
									while($rowi=mysqli_fetch_row($resi))
									{
										$porce=$rowi[5];
										$vi=$_POST[dvalores][$x]*($porce/100);
									}
									echo "<table  class='inicio'><tr><td class='tamano01'><center>Se ha almacenado el Ingreso por Identificar con Exito <img src='imagenes/confirm.png'></center></td></tr></table>
									<script>
										document.form2.numero.value='';
										document.form2.valor.value=0;
									</script>";
								}
							}
						}
						else
						{
							echo "<table class='inicio'><tr><td class='tamano01'><center>Ya Existe un Recibo con este numero <img src='imagenes/alert.png'></center></td></tr></table>";
						}
							echo "<script>despliegamodalm('visible','1','Se ha almacenado el Ingreso por identificar con Exito');</script>";
					}
					else
					{
						preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $_POST['fecha'],$fecha);
						$fechaf="$fecha[3]-$fecha[2]-$fecha[1]";
						$vigenciaReversion = $fecha[3];
						$consec = $_POST['numIngreso'];
						$sqlr = "UPDATE comrpobante_cab SET estado=0 WHERE numerotipo='$consec' AND tipo_comp='27'";
						mysql_query($sqlr,$linkbd);
						$sqlr="INSERT INTO comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito, total_credito,diferencia,estado) VALUES ($consec,27,'$fechaf', '".strtoupper($_POST['descripcion'])."',0,'".$_POST['totalc']."','".$_POST['totalc']."',0,'2')";
						mysqli_query($linkbd,$sqlr);
						for($x=0;$x<count($_POST['dcoding']);$x++)
						{
							//***** BUSQUEDA INGRESO ********
							$sqlri="SELECT * FROM tesoingresos_det WHERE codigo='".$_POST['dcoding'][$x]."' AND vigencia='$vigenciaReversion'";
							$resi=mysqli_query($linkbd,$sqlri);
							while($rowi=mysqli_fetch_row($resi))
							{
								//**** busqueda concepto contable*****
								$sqlrc="SELECT * FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='$rowi[2]' AND tipo='C' AND fechainicial=(SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='$rowi[2]' AND tipo='C' AND fechainicial<='$fechaf')";
								$resc=mysqli_query($linkbd,$sqlrc);
								while($rowc=mysqli_fetch_row($resc))
								{
									$porce=$rowi[5];
									if($rowc[6]=='N')
									{
										$valorcred=$_POST[dvalores][$x]*($porce/100);
										$valordeb=0;
										$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values ('27 $consec','".$rowc[4]."','".$_POST[tercero]."','".$_POST[cc]."','Reversion de Ingreso por Identificar ".strtoupper($_POST[dncoding][$x])."','',".$valorcred.",".$valordeb.",'1','".$_POST[vigencia]."','27','$consec')";
										mysqli_query($linkbd,$sqlr);
										$valordeb=$_POST[dvalores][$x]*($porce/100);
										$valorcred=0;
										$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values ('27 $consec','".$_POST[banco]."','".$_POST[tercero]."','".$_POST[cc]."','Reversion de Ingreso por Identificar ".strtoupper($_POST[dncoding][$x])."','',".$valorcred.",".$valordeb.",'1','".$_POST[vigencia]."','27','$consec')";
										mysqli_query($linkbd,$sqlr);
										$vi=$_POST[dvalores][$x]*($porce/100);
									}

								}
							}
						}
						$sqlr = "UPDATE tesosinidentificar SET estado='R' WHERE id_recaudo='$consec'";
						mysqli_query($linkbd,$sqlr);
						$sqlr="insert into tesosinidentificar (id_recaudo,idcomp,fecha,vigencia,banco,ncuentaban,concepto,tercero,cc,valortotal,estado,tipo_mov,usuario) values($consec,'','$fechaf','".$_POST["vigencia"]."','$_POST[ter]','$_POST[cb]','".strtoupper($_POST['descripcion'])."','".$_POST['tercero']."','".$_POST['cc']."','".$_POST['totalc']."','R','".$_POST['tipomovimiento']."','".$_SESSION['usuario']."')";
						mysqli_query($linkbd,$sqlr);
						//************** insercion de consignaciones **************
						for($x=0;$x<count($_POST['dcoding']);$x++)
						{
							$sqlr = "UPDATE tesosinidentificar_det SET estado='R' WHERE id_recaudo='$consec'";
							mysqli_query($linkbd,$sqlr);
							$sqlr="insert into tesosinidentificar_det (id_recaudo,ingreso,valor,estado,tipo_mov) values($consec,'".$_POST[dcoding][$x]."',".$_POST[dvalores][$x].",'R','$_POST[tipomovimiento]')";
							if (!mysqli_query($linkbd,$sqlr))
							{
								echo "<table >
										<tr>
											<td class='tamano01'><center><font color=blue><img src='imagenes/alert.png'> Manejador de Errores de la Clase BD<br><	font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
								echo "Ocurrió el siguiente problema:<br>";
								echo "<pre>";
								echo "</pre></center></td></tr></table>";
							}
							else
							{
								$sqlri="Select * from tesoingresos_det where codigo='".$_POST[dcoding][$x]."' and vigencia=$vigusu";
								$resi=mysqli_query($linkbd,$sqlri);
								while($rowi=mysqli_fetch_row($resi))
								{
									$porce=$rowi[5];
									$vi=$_POST[dvalores][$x]*($porce/100);
								}
								echo "<table  class='inicio'><tr><td class='tamano01'><center>Se ha almacenado el Ingreso por Identificar con Exito <img src='imagenes/confirm.png'></center></td></tr></table>
								<script>
									document.form2.numero.value='';
									document.form2.valor.value=0;
								</script>";
							}
						}
						echo "<script>despliegamodalm('visible','1','Se ha reversado el Ingreso por identificar con Exito');</script>";
					}
				}
			?>
			<div id="bgventanamodal2">
				<div id="ventanamodal2">
					<IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
					</IFRAME>
				</div>
			</div>
		</form>
	</body>
</html>