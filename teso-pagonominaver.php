<?php
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=iso-8859-1");
	require"comun.inc";
	require"funciones.inc";
	require "conversor.php";
	sesion();
	$linkbd=conectar_v7();
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	date_default_timezone_set("America/Bogota");
	$scroll=$_GET['scrtop'];
	$totreg=$_GET['totreg'];
	$idcta=$_GET['idcta'];
	$altura=$_GET['altura'];
	$filtro="'".$_GET['filtro']."'"; 
	//error_reporting(E_ALL);
	//ini_set('display_errors', '1');
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: SPID - Tesoreria</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css"/>
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css"/>
		<link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css"/>
		<script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script type="text/javascript" src="css/calendario.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
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
			function validar(){document.form2.submit();}
			function validar(id)
			{
				document.form2.ncomp.value=id;
				document.form2.submit();
			}
			function buscaop(e)
			{
				if (document.form2.orden.value!="")
				{
					document.form2.bop.value='1';
					document.form2.submit();
				}
			}
			function calcularpago()
			{
				valorp=document.form2.valor.value;
				descuentos=document.form2.totaldes.value;
				valorc=valorp-descuentos;
				document.form2.valorcheque.value=valorc;
				document.form2.valoregreso.value=valorp;
				document.form2.valorretencion.value=descuentos;
			}
			function pdf()
			{
				document.form2.action="pdfegresonomina.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function adelante()
			{
				if(parseFloat(document.form2.ncomp.value)<parseFloat(document.form2.maximo.value))
				{
					document.form2.oculto.value=1;
					document.form2.ncomp.value=parseFloat(document.form2.ncomp.value)+1;
					document.form2.egreso.value=parseFloat(document.form2.egreso.value)+1;
					document.form2.action="teso-pagonominaver.php";
					document.form2.submit();
				}
			}
			function atrasc()
			{
				if(document.form2.ncomp.value>1)
				{
					document.form2.oculto.value=1;
					document.form2.ncomp.value=document.form2.ncomp.value-1;
					document.form2.egreso.value=document.form2.egreso.value-1;
					document.form2.action="teso-pagonominaver.php";
					document.form2.submit();
 				}
			}
			function iratras(scrtop, numpag, limreg, filtro)
			{
				var idcta=document.getElementById('ncomp').value;
				location.href="teso-buscapagonomina.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<?php $numpag=$_GET['numpag'];$limreg=$_GET['limreg'];$scrtop=22*$totreg;?>
		<table>
			<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("teso");?></tr>
			<tr>
 		 		<td colspan="3" class="cinta"><img src="imagenes/add2.png" title="Nuevo" class="mgbt"/><img src="imagenes/guardad.png"class="mgbt1" /><img src="imagenes/busca.png" title="Buscar"  class="mgbt" onClick="location.href='teso-buscapagonomina.php'"/><img src="imagenes/nv.png" title="Nueva Ventana" onClick="<?php echo paginasnuevas("teso");?>" class="mgbt"/><img src="imagenes/print.png"  title="Imprimir" style="width:29px;height:25px;" onClick="pdf()" class="mgbt"/><img src="imagenes/iratras.png" title="Atr&aacute;s" onClick="iratras(<?php echo "$scrtop,$numpag,$limreg,$filtro"; ?>)" class="mgbt"/></td>
			</tr>
		</table>
		<form name="form2" method="post" action=""> 
			<?php
				$_POST['vigencia']=$vigencia=date('Y');
				$sqlr="SELECT * FROM cuentapagar WHERE estado='S'";
				$res=mysqli_query($linkbd,$sqlr);
				while ($row =mysqli_fetch_row($res)){$_POST['cuentapagar']=$row[1];}
				//*********** cuenta origen va al credito y la destino al debito
				if(! @$_POST['oculto'])
				{
					$sqlr="SELECT * FROM cuentapagar WHERE estado='S' ";
					$res=mysqli_query($linkbd,$sqlr);
					while ($row =mysqli_fetch_row($res)){ $_POST['cuentapagar']=$row[1];}
					$sqlr="SELECT * FROM tesoegresosnomina ORDER BY id_EGRESO DESC";
					$res=mysqli_query($linkbd,$sqlr);
					$r=mysqli_fetch_row($res);
					$_POST['maximo']=$r[0];
					$_POST['ncomp']=$_GET['idegre'];
					$check1="checked";
				}
				if((@ $_POST['oculto'] == '1') || (! @ $_POST['oculto']))
				{
					$sqlr="SELECT * FROM tesoegresosnomina WHERE id_egreso='".$_POST['ncomp']."'";
					$res=mysqli_query($linkbd,$sqlr);
					$consec=0;
					while($r=mysqli_fetch_row($res))
					{
						$consec=$r[0];
						$_POST['orden']=$r[2];
						$_POST['estado']=$r[13];
						$_POST['tipop']=$r[14];
						$_POST['banco']=$r[9];
						$_POST['vigenciaegr']=$r[9];
						if(@ $_POST['tipop']=='transferencia'){$_POST['ntransfe']=$r[10];}
						else {$_POST['ncheque']=$r[10];}
						$_POST['cb']=$r[12];
						$_POST['transferencia']=$r[12];
						$_POST['fecha']=$r[3];
					}
					preg_match("/([0-9]{4})\-([0-9]{2})\-([0-9]{2})/", $_POST['fecha'],$fecha);
					$fechaf="$fecha[3]/$fecha[2]/$fecha[1]";
					$_POST['fecha']=$fechaf;
					$_POST['egreso']=$consec;
				}
				switch(@ $_POST['tabgroup1'])
				{
					case 1:	$check1='checked';break;
					case 2:	$check2='checked';break;
					case 3:	$check3='checked';
				}
				if(@ $_POST['orden']!='' )//*** busca detalle cdp
				{
					$sqlr="SELECT * FROM tesoegresosnomina WHERE id_egreso='".$_POST['ncomp']."'";
					$resp = mysqli_query($linkbd,$sqlr);
					$row =mysqli_fetch_row($resp);
					$_POST['concepto']=$row[8];
					$_POST['tercero']=$row[11];
					$_POST['ntercero']=buscatercero($_POST['tercero']);
					$_POST['valororden']=$row[7];
					$_POST['retenciones']=0;
					$_POST['totaldes']=number_format($_POST['retenciones'],2);
					$_POST['valorpagar']=$_POST['valororden']-$_POST['retenciones'];
					$_POST['bop']="";
				}
				else
				{
					$_POST['cdp']="";
					$_POST['detallecdp']="";
					$_POST['tercero']="";
					$_POST['ntercero']="";
					$_POST['bop']="";
				}
			?>
			<table class="inicio" align="center"  style="border:none!">
				<tr>
					<td class="titulos">Comprobante de Egreso Nomina</td>
					<td width="74" class="cerrar" >
						<a href="teso-principal.php">Cerrar</a>
					</td>
				</tr>
			</table>
			<table class="inicio" align="center" >
				<tr>
					<td class="saludo1" style="width: 7%">No Egreso:</td>
					<td style="width:10%;">
						<img src="imagenes/back.png" onClick="atrasc()" class="icobut" title="Anterior"/>&nbsp;<input name="cuentapagar" type="hidden" value="<?php echo @ $_POST['cuentapagar']?>"/><input name="egreso" type="text" value="<?php echo @ $_POST['egreso']?>" size="10" onKeyUp="return tabular(event,this)" onBlur="buscarp(event)" onChange="validar(document.form2.egreso.value)"/><input name="ncomp" id="ncomp" type="hidden" value="<?php echo @ $_POST['ncomp']?>"/>&nbsp;<img src="imagenes/next.png" onClick="adelante()" class="icobut" title="Sigiente"/>
						<input type="hidden" value="a" name="atras"/>
						<input type="hidden" value="s" name="siguiente"/>
						<input type="hidden" value="<?php echo @ $_POST['maximo']?>" name="maximo">
					</td>
					<td style="width:7%;" class="saludo1">Fecha: </td>
					<td style="width:10%;">
						<input id="fc_1198971545" name="fecha" type="text" value="<?php echo @ $_POST['fecha']?>" maxlength="10" style="width:80%;" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" />&nbsp;<img src="imagenes/calendario04.png" class="icobut" onClick="displayCalendarFor('fc_1198971545');" title="Calendario"/>
					</td>
					<td class="saludo1" style="width: 7% !important">Forma de Pago:</td>
					<td>
						<select name="tipop" style="width: 100% ">
							<?php
								switch(@ $_POST['tipop'])
								{
									case '':	echo "<option value='' SELECTED>Sin Forma de pago</option>";break;
									case 'cheque':	echo"<option value='cheque' SELECTED>Cheque</option>";break;
									case 'transferencia': 	echo "<option value='transferencia' SELECTED>Transferencia</option>"; break;
								}
							?>
						</select>
					</td>  
					<td width="20%" rowspan="5" style="background-image:url('imagenes/cheque04.png');background-repeat: no-repeat;background-position:center; background-size:200px "></td>
				</tr>
				<tr>
					<td class="saludo1">No Orden Pago:</td>
					<td style="width:10%;">
						<input name="orden" type="text" value="<?php echo @ $_POST['orden']?>" style="width:100%;" onKeyUp="return tabular(event,this)" onBlur="buscaop(event)" readonly/>
						<input type="hidden" value="0" name="bop"/>
					</td>
					<td style="width:8%;" class="saludo1">Tercero:</td>
					<td style="width:10%;">
						<input id="tercero" type="text" name="tercero" style="width:100%;" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo @ $_POST['tercero']?>" readonly/>
					</td>
					<td colspan="2">
						<input name="ntercero" type="text" value="<?php echo @ $_POST['ntercero']?>" style="width:100%;" readonly>
					</td>
				</tr>
				<tr>
					<td class="saludo1">Concepto:</td>
					<td colspan="5" style="width:38%;">
						<input name="concepto" type="text" style="width:100%;" value="<?php echo @ $_POST['concepto']?>" readonly>
					</td>
				</tr>
				<?php 
					if(@ $_POST['tipop']=='cheque')//**** if del cheques
					{
						echo"
						<tr>
							<td class='saludo1'>Cuenta Bancaria:</td>
							<td style='width:10%;'>
								<select 'id=banco' name='banco' onChange='validar()' onKeyUp='return tabular(event,this)'/>";
						$sqlr="SELECT T1.estado,T1.cuenta,T1.ncuentaban,T1.tipo,T2.razonsocial,T1.tercero FROM tesobancosctas AS T1,terceros AS T2 WHERE T1.tercero=T2.cedulanit AND T1.estado='S' AND T1.tipo='Corriente'";
						$res=mysqli_query($linkbd,$sqlr);
						while ($row =mysqli_fetch_row($res))
						{
							if(@ $_POST['banco']==$row[1])
							{
								echo "<option value='$row[1]' SELECTED>$row[2] - Cuenta $row[3]</option>";
								$_POST['nbanco']=$row[4];
								$_POST['ter']=$row[5];
								$_POST['cb']=$row[2];
								$_POST['tcta']=$row[3];
							}
						}
						echo"
								</select>
								<input type='hidden' name='tcta' value='".$_POST['tcta']."'/>
								<input type='hidden' name='cb' value='".$_POST['cb']."'/>
								<input type='hidden' id='ter' name='ter' value='".$_POST['ter']."'/>
								<input type='hidden' id='vigenciaegr' name='vigenciaegr' value='".$_POST['vigenciaegr']."'/>
							</td>
							<td colspan='2'>
								<input type='text' id='nbanco' name='nbanco' value='".$_POST['nbanco']."' size='50' readonly/>
							</td>
							<td style='width:10%;' class='saludo1'>Cheque:</td>
							<td style='width:10%;'>
								<input type='text 'id='ncheque' name='ncheque' value='123".$_POST['ncheque']." 'size='20' readonly/>
							</td>
						</tr>";
					}//cierre del if de cheques
					if(@ $_POST['tipop']=='transferencia')//**** if del transferencias
					{
						echo"
						<tr>
							<td class='saludo1'>Cuenta Bancaria:</td>
							<td>
								<select id='banco' name='banco' style='width: 100%'>";
						$sqlr="SELECT T1.estado,T1.cuenta,T1.ncuentaban,T1.tipo,T2.razonsocial,T1.tercero FROM tesobancosctas AS T1,terceros AS T2 WHERE T1.tercero=T2.cedulanit AND T1.estado='S'";
						$res=mysqli_query($linkbd,$sqlr);
						while ($row =mysqli_fetch_row($res))
						{
							if(@ $_POST['banco']==$row[1])
							{
								echo "<option value='$row[1]' SELECTED>$row[2] - Cuenta $row[3]</option>";
								$_POST['nbanco']=$row[4];
								$_POST['ter']=$row[5];
								$_POST['cb']=$row[2];
								$_POST['tcta']=$row[3];
							}
						}
						echo"
								</select>
								<input type='hidden' name='tcta' value='".$_POST['tcta']."'/>
								<input type='hidden' name='cb' value='".$_POST['cb']."'/>
								<input type='hidden' name='ter' id='ter' value='".$_POST['ter']."'/>
							</td>
							<td colspan='2'>
								<input type='text' name='nbanco' id='nbanco' style='width:100%;' value='".$_POST['nbanco']."' size='50' readonly/>
							</td>
							<td class='saludo1'>No Transferencia:</td>
							<td >
								<input type='text' name='ntransfe' id='ntransfe' value='".$_POST['ntransfe']."' size='20'/>
							</td>
						</tr>";
					}//cierre del if de cheques
				?>
				<tr>
					<td class="saludo1">Valor Orden:</td>
					<td style="width:10%;">
						<input name="valororden" type="text" id="valororden" onKeyUp="return tabular(event,this)" value="<?php echo @ $_POST['valororden']?>" readonly/>
					</td>
					<td style="width:8%;" class="saludo1">Retenciones:</td>
					<td style="width:10%;">
						<input name="retenciones" type="text" id="retenciones" style="width:100%;" onKeyUp="return tabular(event,this)" value="<?php echo @ $_POST['retenciones']?>"  readonly/>
					</td>	  
					<td style="width:10%;" class="saludo1">Valor a Pagar:</td>
					<td style="width:10%;">
						<input name="valorpagar" type="text" id="valorpagar" onKeyUp="return tabular(event,this)" value="<?php echo @ $_POST['valorpagar']?>" readonly/> 
						<input type="hidden" name="oculto" value="1"/>
					</td>
				</tr>
			</table>
			<div class="subpantallac4">
				<table class="inicio">
					<tr><td colspan="8" class="titulos">Detalle Egreso Nomina</td></tr>
					<tr>
						<td class="titulos2">No</td>
						<td class="titulos2">Nit</td>
						<td class="titulos2">Tercero</td>
						<td class="titulos2">CC</td>
						<td class="titulos2">Cta Presupuestal</td>
						<td class="titulos2">Valor</td>
					</tr>
					<?php
						if (@ $_POST['elimina']!='')
						{
							$posi=$_POST['elimina'];
							unset($_POST['dccs'][$posi]);
							unset($_POST['dvalores'][$posi]);
							$_POST['dccs']= array_values($_POST['dccs']);
						}
						if (@ $_POST['agregadet']=='1')
						{
							$_POST['dccs'][]=$_POST['cc'];
							$_POST['agregadet']='0';
							echo"
							<script>
								document.form2.banco.value='';
								document.form2.nbanco.value='';
								document.form2.banco2.value='';
								document.form2.nbanco2.value='';
								document.form2.cb.value='';
								document.form2.cb2.value='';
								document.form2.valor.value='';
								document.form2.numero.value='';
								document.form2.agregadet.value='0';
								document.form2.numero.select();
								document.form2.numero.focus();
							</script>";
						}
						$_POST['totalc']=0;
						$sqlr="SELECT * FROM tesoegresosnomina_det where id_egreso='".$_POST['egreso']."' AND estado='S'";
						$iter='saludo1a';
						$iter2='saludo2';
						$dcuentas[]=array();
						$dncuentas[]=array();
						$resp2 = mysqli_query($linkbd,$sqlr);
						while($row2=mysqli_fetch_row($resp2))
						{
							$nid=$row2[3];
							$nombre=buscacuentapres($row2[6],2);
							$tercero=buscatercero($row2[4]);
							echo "
							<input type='hidden' size='1' name='tedet[]' value='".$row2[3]."'/>
							<input type='hidden' name='decuentas[]' value='".$row2[4]."'/>
							<input type='hidden' name='dencuentas[]' value='".$tercero."'/>
							<input type='hidden' name='deccs[]' value='".$row2[7]."'/>
							<input type='hidden' name='derecursos[]' value='".$row2[6]."'/>
							<input type='hidden' name='devalores[]' value='".$row2[8]."'/>
							<tr class='$iter'>
								<td>$row2[3]</td>
								<td>$row2[4]</td>
								<td>$tercero</td>
								<td>$row2[7]</td>
								<td>$row2[6]</td>
								<td>$row2[8]</td>
							</tr>";
							$_POST['totalc']=$_POST['totalc']+$row2[8];
							$_POST['totalcf']=number_format($_POST['totalc'],2,".",",");
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux;
						}
						$resultado = convertir($_POST['valorpagar']);
						$_POST['letras']=$resultado." PESOS M/CTE";
						echo "
						<input type='hidden' name='totalcf' value='".$_POST['totalcf']."'/>
						<input type='hidden' name='totalc' value='".$_POST['totalc']."'/>
						<input type='hidden' name='letras' value='".$_POST['letras']."'/>
						<tr class='$iter'>
							<td colspan='4'></td>
							<td>Total</td>
							<td>".$_POST['totalcf']."</td>
						</tr>
						<tr>
							<td class='saludo1'>Son:</td> 
							<td colspan='5' class='saludo1'>".$_POST['letras']."</td>
						</tr>
						<script>document.form2.valor.value=".$_POST['totalc'].";</script>";
					?>
				</table>
			</div>
			<?php
				if(@ $_POST['oculto']=='2')
				{
					preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $_POST['fecha'],$fecha);
					$fechaf="$fecha[3]-$fecha[2]-$fecha[1]";
					//************CREACION DEL COMPROBANTE CONTABLE ************************
					$sqlr="UPDATE tesoegresos SET fecha='$fechaf' WHERE id_egreso='".$_POST['egreso']."'";
					$res=mysqli_query($linkbd,$sqlr);
					$sqlr="UPDATE comprobante_cab SET fecha='$fechaf' WHERE numerotipo='".$_POST['egreso']."' AND tipo_comp=6";
					$res=mysqli_query($linkbd,$sqlr);
				}//************ FIN DE IF OCULTO************
			?>
		</form>
	</body>
</html>