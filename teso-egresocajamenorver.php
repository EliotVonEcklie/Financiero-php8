<?php
	require"comun.inc";
	require"funciones.inc";
	require "conversor.php";
	require "validaciones.inc";
	session_start();
	$linkbd=conectar_bd();
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: SPID - Tesoreria</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
		<script>
			function validar(){document.form2.submit();}
			function buscarp(e)
			{
				if (document.form2.rp.value!="")
				{
					document.form2.brp.value='1';
					document.form2.submit();
				}
			}
			function agregardetalle()
			{
				if(document.form2.numero.value!="" &&  document.form2.valor.value>0 &&  document.form2.banco.value!=""  )
				{
					document.form2.agregadet.value=1;
					document.form2.submit();
				}
				else {alert("Falta informacion para poder Agregar");}
			}
			function agregardetalled()
			{
				if(document.form2.retencion.value!="" &&  document.form2.vporcentaje.value!=""  )
				{
					document.form2.agregadetdes.value=1;
					//document.form2.chacuerdo.value=2;
					document.form2.submit();
				}
				else {alert("Falta informacion para poder Agregar");}
			}
			function despliegamodal2(_valor,_num)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else 
				{
					switch(_num)
					{
						case '1':	document.getElementById('ventana2').src="ordenpago-ventana1.php?vigencia="+document.form2.vigencia.value;break;
						case '2':	document.getElementById('ventana2').src="cuentasbancarias-ventana01.php?tipoc=C";break;
						case '3':	document.getElementById('ventana2').src="cuentasbancarias-ventana01.php?tipoc=D";break;
						case '4':	document.getElementById('ventana2').src="reversar-egreso.php?vigencia="+document.form2.vigencia.value;break;
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
				var _cons=document.getElementById('idcomp').value;
				document.location.href = "teso-editaegresocajamenor.php?idegreso="+_cons;
			}
			function pdf()
			{
				document.form2.action="pdfegresocajamenor.php";
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
			<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("teso");?></tr>
			<tr class="cinta">
				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='teso-egresocajamenor.php'" class="mgbt"/><img src="imagenes/guarda.png" title="Guardar" onClick="guardar()" class="mgbt"/><img src="imagenes/busca.png"  title="Buscar" onClick="location.href='teso-buscaegresocajamenor.php'" class="mgbt"/><img src="imagenes/agenda1.png" title="Agenda" onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"/><img src="imagenes/nv.png"title="Nueva Ventana" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"/><img src="imagenes/duplicar_pantalla.png" title="Duplica" class="mgbt"/><img src="imagenes/print.png"  title="Imprimir" style="width:29px;height:25px;" onClick="pdf()" class="mgbt"/><img src="imagenes/iratras.png" title="Atr&aacute;s" onClick="location.href='teso-gestioncajamenor.php'" class="mgbt"/></td>
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
				$vigencia=date(Y);
				$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
				if(!$_POST[oculto])
				{
					$_POST[idcomp]=$_GET[idegre];
					$sqlr="SELECT fecha,vigencia,tipo_egreso,actoadministrativo,valoracto,reintegro,valor_reintegro,formapago,cuentabanco, numformapago,id_rp,cc,detalle,tercero,valorrp,valorpagar FROM tesoegresocajamenor WHERE id='$_POST[idcomp]'";
					$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res)) 
					{
						$_POST[fecha]=date('d/m/Y',strtotime($row[0]));
						$_POST[vigencia]=$row[1];
						$_POST[tipoegreso]=$row[2];
						$_POST[tipop]=$row[7];
						$_POST[cb]=$row[8];
						$_POST[rp]=$row[10];
						$_POST[cc]=$row[11];
						$_POST[cdp]=buscaregistro($_POST[rp],$_POST[vigencia]);
						$_POST[detallecdp]=$_POST[detallegreso]=$row[12];
						$_POST[tercero]=$row[13];
						$_POST[ntercero]=buscatercero($_POST[tercero]);
						$_POST[valorrp]='$ '.number_format($row[14],2,".",",");
						$_POST[valor]='$ '.number_format($row[15],2,".",",");
						
						$_POST[saldorp]=generaSaldoRP($_POST[rp],$_POST[vigencia]);
						if($_POST[tipoegreso]=='apertura')
						{
							$_POST[acuerdo]=$row[3];
							$_POST[valorac]='$ '.number_format($row[4],2,".",",");
						}
						else
						{
							$_POST[reintegro]=$row[5];
							$_POST[valorreintegro]='$ '.number_format($row[6],2,".",",");
						}
						if($_POST[tipop]=='cheque')
						{
							$sqlc="SELECT TB3.nombre FROM terceros TB1,tesobancosctas TB2,cuentasnicsp TB3 WHERE TB2.tercero=TB1.cedulanit AND TB2.estado='S' AND TB3.cuenta=TB2.cuenta AND TB2.tipo='Corriente' AND TB2.cuenta='$row[8]'";
							$resc = mysql_query($sqlc,$linkbd);
							$rowc =mysql_fetch_row($resc);
							$_POST[nbanco]=$rowc[0];
							$_POST[ncheque]=$row[9];
						}
						else
						{
							$sqlc="SELECT TB3.nombre FROM terceros TB1,tesobancosctas TB2,cuentasnicsp TB3 WHERE TB2.tercero=TB1.cedulanit AND TB2.estado='S' AND TB3.cuenta=TB2.cuenta AND TB2.cuenta='$row[8]'";
							$resc = mysql_query($sqlc,$linkbd);
							$rowc =mysql_fetch_row($resc);
							$_POST[nbanco]=$rowc[0];
							$_POST[ntransfe]=$row[9];
						}
					}
				}
			?>
			<table class="inicio" align="center" >
				<tr >
					<td class="titulos" colspan="12">Egreso caja menor</td>
					<td style="width:7%"><label class="boton02" onClick="location.href='teso-principal.php';">Cerrar</label></td>
				</tr>
				<tr >
					<td style="width:11%;" class="tamano01" >Numero Egreso:</td>
					<td style="width:15%;">
						<input type="text" name="idcomp" id="idcomp" class="tamano02" style="width:90%;" value="<?php echo $_POST[idcomp]?>" readonly> 
					</td>
					<td style="width:8%;" class="tamano01">Fecha: </td>
					<td style="width:15%;"><input type="text" name="fecha" id="fc_1198971545" class="tamano02" value="<?php echo $_POST[fecha]?>" readonly></td>
					<td style="width:10%;" class="tamano01">Vigencia: </td>
					<td style="width:10%;"><input type="text" name="vigencia" id="vigencia" class="tamano02" value="<?php echo $_POST[vigencia]?>" readonly></td>
					<td class="tamano01" style="width:10%;">Tipo Egreso:</td>
					<td >
						<select name="tipoegreso" id="tipoegreso" class="tamano02" style="width:100%">
							<?php
								if($_POST[tipoegreso]=='apertura'){echo "<option value='apertura' SELECTED>Apertura</option>";}
								if($_POST[tipoegreso]=='reintegro'){echo "<option value='reintegro' SELECTED>Reintegro</option>";}
							?>
						</select>
					</td>
				</tr>
				<?php
					$linkbd=conectar_bd();
					if($_POST[tipoegreso]=='apertura')
					{
						echo "
						<tr>
							<td class='tamano01'>Acto Administrativo:</td>
							<td colspan='3'>
								<select name='acuerdo' class='tamano02' style='width:100%;'>
						";
						$sqlr="Select * from tesoacuerdo where estado='S'";
						$resp = mysql_query($sqlr,$linkbd);
						while ($row =mysql_fetch_row($resp))
						{
							if($row[0]==$_POST[acuerdo]){echo "<option value='$row[0]' SELECTED>$row[1]-$row[2]</option>";}
						}
						echo "
								</select>
							<td style='width:10%;' class='tamano01'>Valor Acuerdo:</td>
							<td style='width:10%;'><input type='text' name='valorac' value='$_POST[valorac]' class='tamano02' readonly></td>
								";
					}
					else
					{
						echo "
						<tr>
							<td class='tamano01'>Reintegro:</td>
							<td colspan='3'>
								<select name='reintegro' class='tamano02' style='width:100%;'>
						";
						$sqlr="Select * from tesocontabilizacajamenor where finaliza='1'";
						$resp = mysql_query($sqlr,$linkbd);
						while ($row =mysql_fetch_row($resp)) 
						{
							if($row[0]==$_POST[reintegro]){echo "<option value='$row[0]' SELECTED>$row[0]-$row[1]</option>";}
						}
						echo "
								</select>
							<td class='tamano01'>Valor Reintegro:</td>
							<td ><input type='text' name='valorreintegro' value='$_POST[valorreintegro]' class='tamano02' readonly></td>";
					}
				?>
					<td class="tamano01" style="width:2.8cm;">Forma de Pago:</td>
					<td >
						<select name="tipop" id="tipop" class='tamano02' style="width:100%">
							<?php 
								if($_POST[tipop]=='cheque'){echo "<option value='cheque' SELECTED>Cheque</option>";}
								if($_POST[tipop]=='transferencia'){echo"<option value='transferencia' SELECTED>Transferencia</option>";}
							?>
						</select> 
					</td>
				</tr>
				<tr>
					<td class='tamano01'>Cuenta Bancaria:</td>
					<td><input type='text' name='cb' id='cb' value="<?php echo $_POST[cb];?>" style='width:100%' class='tamano02' readonly/></td>
					<td colspan='4'><input type='text' id='nbanco' name='nbanco' value="<?php echo $_POST[nbanco];?>" class='tamano02' style='width:100%' readonly></td>
					<?php
						if($_POST[tipop]=='cheque') //**** if del cheques
						{
							echo" 
								<td class='tamano01'>Cheque:</td>
								<td><input type='text' id='ncheque' name='ncheque' value='$_POST[ncheque]' style='width:100%' class='tamano02' readonly/></td>
							</tr>";
						}//cierre del if de cheques
						if($_POST[tipop]=='transferencia')//**** if del transferencias
						{
							echo"
								<td class='tamano01'>No Transferencia:</td>
								<td><input type='text' id='ntransfe' name='ntransfe' value='$_POST[ntransfe]' style='width:100%' class='tamano02' readonly/></td>
							</tr>";
						}//cierre del if de cheques
					?>
				<tr>
					<td class="tamano01">Registro:</td>
					<td><input name="rp" type="text" style="width:100%;" value="<?php echo $_POST[rp]?>" class='tamano02' readonly/></td>
					<td class="tamano01">CDP:</td>
					<td><input type="text" id="cdp" name="cdp" value="<?php echo $_POST[cdp]?>" class='tamano02' style="width:100%;" readonly></td>
					<td class="tamano01">Detalle RP:</td>
					<td colspan="3"><input type="text" id="detallecdp" name="detallecdp" style="width:100%;" class='tamano02' value="<?php echo $_POST[detallecdp]?>" readonly/></td>
				</tr>
				<tr>
					<td class="tamano01">Centro Costo:</td>
					<td>
						<select name="cc" style="width:100%;" class='tamano02' >
							<?php
								$linkbd=conectar_bd();
								$sqlr="SELECT * FROM centrocosto WHERE estado='S'";
								$res=mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($res)) 
								{
									if($row[0]==$_POST[cc]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
								}
							?>
						</select>
					</td>
					<td class="tamano01">Tercero:</td>
					<td><input type="text" id="tercero" name="tercero" value="<?php echo $_POST[tercero]?>" style="width:100%;" class='tamano02' readonly/></td>
					<td colspan="4"><input type="text" name="ntercero" id="ntercero" style="width:100%;" class='tamano02' value="<?php echo $_POST[ntercero]?>" readonly/></td>
				</tr>
				<tr>
					<td class="tamano01">Detalle Orden de Pago:</td>
					<td colspan="7"><input type="text" id="detallegreso" name="detallegreso" class='tamano02' style="width:100%;" value="<?php echo $_POST[detallegreso]?>"/></td>
				</tr>
				<tr>
					<td class="tamano01">Valor RP:</td>
					<td ><input type="text" id="valorrp" name="valorrp" class='tamano02' style="width:90%;" value="<?php echo $_POST[valorrp]?>" onKeyUp="return tabular(event,this)" readonly></td>
					<td class="tamano01" >Valor a Pagar:</td>
					<td><input type="text" id="valor" name="valor" class='tamano02' value="<?php echo $_POST[valor]?>" readonly/></td>
				</tr>
			</table>
			<input type="hidden" value="1" name="oculto">
			<div class="subpantallac2">
				<table class="inicio">
					<tr><td colspan="8" class="titulos">Detalle Orden de Pago</td></tr>
					<?php
						echo"
						<tr>
							<td class='titulos2'>Cuenta</td>
							<td class='titulos2'>Nombre Cuenta</td>
							<td class='titulos2'>Recurso</td>
							<td class='titulos2'>Valor</td>
						</tr>";
						$sumval=0;
						$iter='saludo1a';
						$iter2='saludo2';
						$sqlr="SELECT cuentap,valor,cc FROM tesoegresocajamenor_det WHERE id_egreso='$_POST[idcomp]' ORDER BY id";
						$res=mysql_query($sqlr,$linkbd);
						while ($row =mysql_fetch_row($res)) 
						{
							$nomcuenta=buscacuentapres($row[0],2);
							$sumval=$sumval+$row[1];
							echo "
							<tr class='$iter'>
								<td>$row[0]</td>
								<td>$nomcuenta</td>
								<td>$_POST[rp]</td>
								<td style='text-align:right;'>$ ".number_format($row[1],2,".",",")."</td>
							</tr>";
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux;
						}
						$resultado = convertir($sumval);
						$_POST[letras]=$resultado." PESOS M/CTE";
						echo "
						<tr>
							<td colspan='2'></td>
							<td class='saludo2' style='text-align:right;'>Total:</td>
							<td class='saludo2' style='text-align:right;'>$ ".number_format($sumval,2,".",",")."</td>
						</tr>
						<tr>
							<td  class='saludo1'>Son:</td>
							<td colspan='5' class='saludo1'><input name='letras' type='text' value='$_POST[letras]' size='90'></td>
						</tr>";
					?>
				</table>
			</div>
			<div id="bgventanamodal2">
				<div id="ventanamodal2">
					<IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"></IFRAME>
				</div>
			</div>
		</form>
	</body>
</html>