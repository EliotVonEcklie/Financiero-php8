<?php
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=iso-8859-1");
	require 'comun.inc';
	require 'funciones.inc';
	require 'validaciones.inc';
	require 'conversor.php';
	require 'funcionessp.inc';
	session_start();
	$linkbd=conectar_v7();
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: SPID- Servicios Publicos</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/calendario.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script>
			function validar(){document.form2.submit();}
			function validar2()
			{
				var str =document.form2.idrecaudot.value;
				if (str.length<11){document.form2.idrecaudo.value=str;}
				else
				{
					document.form2.idrecaudo.value=parseInt(str.substring(20, 30),10);
					document.form2.modorec.value='banco';
				}
				document.form2.submit();
			}
			function guardar()
			{
				if (document.form2.fecha.value!='' && document.form2.modorec.value!='' && ((document.form2.modorec.value=='banco' && document.form2.banco.value!='') || (document.form2.modorec.value=='caja' && document.form2.cuentacaja.value!='')) )
				{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
				else {despliegamodalm('visible','2','Faltan datos para completar el registro');}
			}
			function pdf()
			{
				document.form2.action="serv-pdfrecaja.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
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
			function funcionmensaje(){document.location.href = "serv-recaudover.php?idr="+document.getElementById('idcomp').value;}
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
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("serv");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("serv");?></tr>
			<tr>
				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='serv-recaudo.php'" class="mgbt"/><img src="imagenes/guarda.png" title="Guardar" onClick="guardar()" class="mgbt"/><img src="imagenes/busca.png" title="Buscar" onClick="location.href='serv-buscarecaudo.php'" class="mgbt"/><img src="imagenes/nv.png" title="Nueva ventana"  onClick="mypop=window.open('serv-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/printd.png" class="mgbt1"/></td>
			</tr>
		</table>
		<div id="bgventanamodalm" class="bgventanamodalm">
			<div id="ventanamodalm" class="ventanamodalm">
				<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"></IFRAME>
			</div>
		</div>
		<?php
			$vigusu=vigencia_usuarios($_SESSION['cedulausu']);
			if(!@$_POST['oculto'])
			{ 
				$_POST['vigencia']=$vigusu;
				$sqlr="SELECT valor_inicial FROM dominios WHERE nombre_dominio='CUENTA_CAJA'";
				$res=mysqli_query($linkbd,$sqlr);
				while ($row =mysqli_fetch_row($res)) {$_POST['cuentacaja']=$row[0];}
				$_POST['idcomp']=selconsecutivo('servreciboscaja','id_recibos');
				$_POST['fecha']=date("d/m/Y");
				$_POST['valor']=0;
				echo"<script>document.form2.idrecaudot.focus();</script>";
			}
		?>
 		<form name="form2" method="post" action=""> 
 			<input type="hidden" name="encontro"  value="<?php echo @$_POST['encontro']?>" >
	 		<input type="hidden" name="cobrorecibo" value="<?php echo @$_POST['cobrorecibo']?>" >
 			<input type="hidden"name="vcobrorecibo" value="<?php echo @$_POST['vcobrorecibo']?>" >
 			<input type="hidden" name="tcobrorecibo" value="<?php echo @$_POST['tcobrorecibo']?>" > 
 			<input type="hidden" name="codcatastral" value="<?php echo @$_POST['codcatastral']?>" >
 			<?php 
				if(@$_POST['oculto'])
				{
					$sqlr="SELECT * FROM servfacturas WHERE id_factura = '".$_POST['idrecaudo']."' AND estado ='S' AND 4 = '".$_POST['tiporec']."'";
					$_POST['encontro']="";
					$res=mysqli_query($linkbd,$sqlr);
					while ($row =mysqli_fetch_row($res)){$nliqui=$row[0];$tercero=$row[0];}
					$sqlr="
					SELECT T2.servicio,T2.valorliquidacion,T2.estrato,T1.saldo,T1.codusuario,T1.tercero, T1.id_liquidacion 
					FROM servliquidaciones T1, servliquidaciones_det T2 
					WHERE T1.factura='".$_POST['idrecaudo']."' AND T1.id_liquidacion=T2.id_liquidacion AND T1.ESTADO='S'";
					$res=mysqli_query($linkbd,$sqlr);
					while ($row =mysqli_fetch_row($res)) 
					{	
						$_POST['intereses']=0;
						$_POST['codcatastral']=$row[1];
						$_POST['concepto']="USUARIO $row[4]";
						$_POST['tercero']=$row[5];
						$_POST['liquidacion']=$row[6];
						$_POST['codigousuario']=$row[4];
						$_POST['ntercero']=buscatercero($row[5]);
						if ($_POST['ntercero']=='')
						{
							$sqlr2="SELECT * FROM tesopredios WHERE cedulacatastral='$row[1]' ";
							$resc=mysqli_query($linkbd,$sqlr2);
							$rowc =mysqli_fetch_row($resc);
							$_POST['ntercero']=$rowc[6];
						}	
						$_POST['encontro']=1;
					}
					if($_POST['encontro']==0){echo "<script>despliegamodalm('visible','2','Ya se creo un Recibo de Caja para la factura No ".$_POST['idrecaudo']."');</script>";}
				}
			?>
			<table class="inicio" align="center" >
				<tr>
					<td class="titulos" colspan="9">Recibo de Caja</td>
					<td class="cerrar" style="width:7%" onClick="location.href='serv-principal.php'">Cerrar</td>
				</tr>
				<tr>
					<td class="saludo1" >No Recibo:</td>
					<td>
						<input type="hidden" name="codigousuario" value="<?php echo @$_POST['codigousuario']?>"/>
						<input type="hidden" name="liquidacion" value="<?php echo @$_POST['liquidacion']?>"/>
						<input type="hidden" name="intereses" value="<?php echo @$_POST['intereses']?>"/>
						<input type="hidden" name="cuentacaja" value="<?php echo @$_POST['cuentacaja']?>"/>
						<input type="text" name="idcomp" id="idcomp" value="<?php echo @$_POST['idcomp']?>" readonly/>
					</td>
					<td class="saludo1">Fecha:</td>
					<td >
						<input name="fecha" type="text" value="<?php echo @$_POST['fecha']?>" maxlength="10"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY">&nbsp;<img src="imagenes/calendario04.png" class="icobut" title="Calendario" onClick="displayCalendarFor('fc_1198971545');"/>
					</td>
					<td class="saludo1">Vigencia:</td>
					<td >
						<input type="text" id="vigencia" name="vigencia" style="width:20%" onKeyPress="javascript:return solonumeros(event)" 
		  onKeyUp="return tabular(event,this)" value="<?php echo @$_POST['vigencia']?>" onClick="document.getElementById('tipocta').focus();document.getElementById('tipocta').select();" readonly/>
					</td>
				</tr>
				<tr>
					<td class="saludo1"> Recaudo:</td>
					<td> 
						<select name="tiporec" id="tiporec" onKeyUp="return tabular(event,this)" onChange="validar()" >
							<option value="4" <?php if(@$_POST['tiporec']=='4') echo "SELECTED"; ?>>Factura Servicios</option>
						</select>
					</td>
					<?php $sqlr="";?>
					<td class="saludo1">No Factura:</td>
					<td>
						<input type="text" id="idrecaudot" name="idrecaudot" value="<?php echo @$_POST['idrecaudot']?>"  onKeyUp="return tabular(event,this)" onBlur="validar2()">
						<input type="hidden" id="idrecaudo" name="idrecaudo" value="<?php echo @$_POST['idrecaudo']?>"/>
					 </td>
					<td class="saludo1">Recaudado en:</td>
					<td>
						<select name="modorec" id="modorec" onKeyUp="return tabular(event,this)" onChange="validar()">
							<option value="" <?php if(@$_POST['modorec']=='seleccione') echo "SELECTED"; ?>>Seleccione</option>
							<option value="caja" <?php if(@$_POST['modorec']=='caja') echo "SELECTED"; ?>>Caja</option>
							<option value="banco" <?php if(@$_POST['modorec']=='banco') echo "SELECTED"; ?>>Banco</option>
						</select>
						<?php
							if (@$_POST['modorec']=='banco')
							{
								echo"
									<select id='banco' name='banco'  onChange='validar()' onKeyUp='return tabular(event,this)'>
										<option value=''>Seleccione....</option>";
								$sqlr="SELECT T1.estado,T1.cuenta,T1.ncuentaban,T1.tipo, T2.razonsocial,T1.tercero FROM tesobancosctas AS T1,terceros AS T2 WHERE T1.tercero=T2.cedulanit and T1.estado='S' ";
								$res=mysqli_query($linkbd,$sqlr);
								while ($row =mysqli_fetch_row($res))
								{
									if($row[1]==@$_POST['banco'])
									{
										echo "<option value='$row[1]' SELECTED>$row[2] - Cuenta $row[3]</option>";
										$_POST['nbanco']=$row[4];
										$_POST['ter']=$row[5];
										$_POST['cb']=$row[2];
									}
									else{echo "<option value='$row[1]'>$row[2] - Cuenta $row[3]</option>";}
								}	 	
								echo"
									</select>
									<input name='cb' type='hidden' value='".@$_POST['cb']."'/>
									<input type='hidden' id='ter' name='ter' value='".@$_POST['ter']."' >
								</td>
								<td><input type='text' id='nbanco' name='nbanco' value='".@$_POST['nbanco']."' size='40' readonly></td>";
							}
							else {echo "</td>";}
						?>
					</tr>
					<tr>
						<td class="saludo1" >Concepto:</td>
						<td colspan="3"><input name="concepto" type="text" value="<?php echo @$_POST['concepto'] ?>" style="width:84%" onKeyUp="return tabular(event,this)"></td>
						<?php
							if(@$_POST['tiporec']==2)
							{
								echo"
								<td class='saludo1'>No Cuota:</td>
								<td><input name='cuotas' type='text' value='".@$_POST['cuotas']."' readonly/>/<input type='text' id='tcuotas' name='tcuotas' value='".@$_POST['tcuotas']."' readonly/></td>";
							}
						?>
					</tr>
					<tr>
						<td class="saludo1" width="71">Valor:</td>
						<td><input type="text" id="valorecaudo" name="valorecaudo" value="<?php echo @$_POST['valorecaudo']?>" 
	  onKeyUp="return tabular(event,this)" readonly ></td>
						<td class="saludo1">Documento: </td>
						<td><input type="text" name="tercero" value="<?php echo @$_POST['tercero']?>" onKeyUp="return tabular(event,this)" readonly></td>
						<td class="saludo1">Contribuyente:</td>
						<td>
							<input type="text" id="ntercero" name="ntercero" value="<?php echo @$_POST['ntercero']?>" size="50" onKeyUp="return tabular(event,this)" readonly/>
							<input type="hidden" id="cb" name="cb" value="<?php echo @$_POST['cb']?>"/>
							<input type="hidden" id="ct" name="ct" value="<?php echo @$_POST['ct']?>"/>
						</td>
						<td>
							<input type="hidden" name="oculto" value="1"/>
							<input type="hidden" name="trec" value="<?php echo @$_POST['trec']?>"/>
							<input type="hidden" name="agregadet" value="0"/>
						</td>
					</tr>
				</table>
				<div class="subpantallac7">
					<?php 
						if(@$_POST['oculto'] && @$_POST['encontro']=='1')
						{
							$_POST['trec']='Factura Servicios';
							$_POST['dcoding']= array();
							$_POST['dncoding']= array();
							$_POST['dvalores']= array();
							$_POST['destratos']= array();
							$_POST['dcargosfijos']= array();
							$_POST['dtarifas']= array();
							$_POST['dsubsidios']= array(); 
							$_POST['ddescuentos']= array(); 
							$_POST['dcontribuciones']= array();
							$_POST['dsaldos']= array();
							$_POST['dinteres']= array();
							$sqlr="
							SELECT T2.servicio,T2.saldo,T2.estrato,T2.valorliquidacion,T2.cargofijo,T2.tarifa,T2.subsidio,T2.descuento, T2.contribucion,T2.intereses FROM servliquidaciones T1, servliquidaciones_det T2 WHERE T1.factura=$_POST[idrecaudo] AND T1.id_liquidacion=T2.id_liquidacion";
							$res=mysqli_query($linkbd,$sqlr);
							while ($row =mysqli_fetch_row($res))
							{
								$_POST['dcoding'][]=$row[0];
								$_POST['dncoding'][]=buscar_servicio($row[0]);
								$_POST['dcargofijos'][]=$row[4];
								$_POST['dtarifas'][]=$row[5];
								$_POST['dsubsidios'][]=$row[6];
								$_POST['ddescuentos'][]=$row[7];
								$_POST['dcontribuciones'][]=$row[8];
								$_POST['dsaldos'][]=$row[1];
								$_POST['dvalores'][]=$row[3];
								$_POST['dinteres'][]=$row[3]-($row[5]+$row[4]+$row[8]+$row[1]-$row[6]-$row[7]);
							}
						}
					?>
					<table class="inicio">
						<tr><td colspan="11" class="titulos">Detalle Factura</td></tr>
						<tr>
							<td class="titulos2">Codigo</td>
							<td class="titulos2">Servicio</td>
							<td class="titulos2">Cargo Fijo</td>
							<td class="titulos2">Tarifa</td>
							<td class="titulos2">Subsidio</td>
							<td class="titulos2">Descuento</td>
							<td class="titulos2">Contribucion</td>
							<td class="titulos2">Saldo Anterior</td>
							<td class="titulos2">Valor</td>
							<td class="titulos2">Intereses</td>
							<td class="titulos2">Total</td>
						</tr>
						<?php
							$_POST['totalc']=0;
							$iter1="zebra1";
							$iter2="zebra2";
							$tam=count(@$_POST['dcoding']);
							$valorint=0;
		 					for ($x=0;$x<count(@$_POST['dcoding']);$x++)
		 					{
		 						$total=$_POST['dvalores'][$x];
								$toalmed=$_POST['dvalores'][$x]-$_POST['dinteres'][$x];
		 						echo "
								<input type='hidden' name='dcoding[]' value='".$_POST['dcoding'][$x]."'/>
								<input type='hidden' name='dncoding[]' value='".$_POST['dncoding'][$x]."'/>
								<input type='hidden' name='dcargofijos[]' value='".$_POST['dcargofijos'][$x]."'/>
								<input type='hidden' name='dtarifas[]' value='".$_POST['dtarifas'][$x]."'/>
								<input type='hidden' name='dsubsidios[]' value='".$_POST['dsubsidios'][$x]."'>
								<input type='hidden' name='ddescuentos[]' value='".$_POST['ddescuentos'][$x]."'/>
								<input type='hidden' name='dcontribuciones[]' value='".$_POST['dcontribuciones'][$x]."'/>
								<input type='hidden' name='dsaldos[]' value='".$_POST['dsaldos'][$x]."'/>
								<input type='hidden' name='dvalores[]' value='".$_POST['dvalores'][$x]."'/>
								<input type='hidden' name='dinteres[]' value='".$_POST['dinteres'][$x]."'/>
								<input type='hidden' name='dtotales[]' value='".$total."'/>
								<tr class='$iter1'>
									<td>".$_POST['dcoding'][$x]."</td>
									<td>".$_POST['dncoding'][$x]."</td>
									<td style='text-align:right;'>$".number_format($_POST['dcargofijos'][$x],2,',','.')."</td>
									<td style='text-align:right;'>$".number_format($_POST['dtarifas'][$x],2,',','.')."</td>
									<td style='text-align:right;'>$".number_format($_POST['dsubsidios'][$x],2,',','.')."</td>
									<td style='text-align:right;'>$".number_format($_POST['ddescuentos'][$x],2,',','.')."</td>
									<td style='text-align:right;'>$".number_format($_POST['dcontribuciones'][$x],2,',','.')."</td>
									<td style='text-align:right;'>$".number_format($_POST['dsaldos'][$x],2,',','.')."</td>
									<td style='text-align:right;'>$".number_format($toalmed,2,',','.')."</td>
									<td style='text-align:right;'>$".number_format($_POST['dinteres'][$x],2,',','.')."</td>
									<td style='text-align:right;'>$".number_format($total,2,',','.')."</td>
								</tr>";
		 						$_POST['totalc']=$_POST['totalc']+$total;
								$_POST['totalcf']=number_format($_POST['totalc'],0);
								$aux=$iter1;
		 						$iter1=$iter2;
		 						$iter2=$aux;
		 					}
							echo"<script>document.getElementById('valorecaudo').value='".@$_POST['totalc']."'</script>";
 							$resultado = convertir($_POST['totalc'],"PESOS");
							$_POST['letras']=$resultado." PESOS M/CTE";
		 					echo "
								<input type='hidden' name='totalcf' value='".@$_POST['totalcf']."'/>
								<input type='hidden' name='totalc' value='".@$_POST['totalc']."'/>
								<input type='hidden' name='letras' value='".@$_POST['letras']."' >
								<tr class='$iter1'>
									<td colspan='9'></td>
									<td style='text-align:right;'>Total:</td>
									<td style='text-align:right;'>$".number_format($_POST['totalc'],2,',','.')."</td>
								</tr>
								<tr class='titulos2'>
									<td>Son:</td>
									<td colspan='10'>".$_POST['letras']."</td>
								</tr>";
						?> 
					</table></div>
					<?php
						if(@$_POST['oculto']=='2')
						{
							preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $_POST['fecha'],$fecha);
							$fechaf="$fecha[3]-$fecha[2]-$fecha[1]";
							$bloq=bloqueos($_SESSION['cedulausu'],$fechaf);	
							if($bloq>=1)
							{
								//************VALIDAR SI YA FUE GUARDADO ************************
								$sqlr="SELECT count(*) FROM servreciboscaja WHERE id_recaudo='".$_POST['idrecaudo']."' AND tipo='4' AND ESTADO='S'";
								$res=mysqli_query($linkbd,$sqlr);
								while($r=mysqli_fetch_row($res)){$numerorecaudos=$r[0]; }
								if($numerorecaudos==0)
								{
									preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $_POST['fecha'],$fecha);
									$fechaf="$fecha[3]-$fecha[2]-$fecha[1]";
									//*********************CREACION DEL COMPROBANTE CONTABLE ***************************
									//***busca el consecutivo del comprobante contable
									$concecc=0;
									$concecc=selconsecutivo('servreciboscaja','id_recibos');
									echo "<script>document.getElementById('idcomp').value=$concecc</script>";
									//***cabecera comprobante
									$sqlr="INSERT INTO comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito, total_credito,diferencia,estado) VALUES ('$concecc','30','$fechaf','".$_POST['concepto']."','0', '".$_POST['totalc']."','".$_POST['totalc']."','0','1')";
									mysqli_query($linkbd,$sqlr);
									$idcomp=mysqli_insert_id();
									echo "<input type='hidden' name='ncomp' value='$idcomp'>";
									$sqlr="INSERT INTO pptocomprobante_cab (numerotipo,tipo_comp,fecha,concepto,vigencia,total_debito, total_credito,diferencia,estado) VALUES values('$concecc','16','$fechaf','RECIBO DE CAJA', '".$_POST['vigencia']."','".$_POST['totalc']."','".$_POST['totalc']."','0','1')";
									mysqli_query($linkbd,$sqlr);	
									//******************* DETALLE DEL COMPROBANTE CONTABLE *********************
									for($x=0;$x<count($_POST['dcoding']);$x++)
									{
										//***** BUSQUEDA INGRESO ********
										$sqlri="Select * from servservicios where codigo='".$_POST['dcoding'][$x]."' ";
										$resi=mysqli_query($linkbd,$sqlri);
										while($rowi=mysqli_fetch_row($resi))
										{
											//**** busqueda cuenta presupuestal*****
											//busqueda concepto contable
											$sqlrc="SELECT DISTINCT cuenta,tipocuenta,debito,credito,cc FROM conceptoscontables_det T2 WHERE tipo='SP' AND codigo='$rowi[2]' AND modulo='10' AND fechainicial=(SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE fechainicial <= '$fechaf' AND modulo='10' AND tipo='SP' AND codigo='$rowi[2]')";
											$resc=mysqli_query($linkbd,$sqlrc);
											while($rowc=mysqli_fetch_row($resc))
											{
												$columna=$rowc[2];
												$cuentacont=$rowc[0];
												if($columna=='S')
												{				 
													$valorcred=$_POST['dvalores'][$x]-$_POST['dinteres'][$x];
													$valordeb=0;
													if($rowc[1]=='N')
													{
														//*****inserta del concepto contable  
														//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
														$vi=$_POST['dvalores'][$x]-$_POST['dinteres'][$x];
														//****creacion documento presupuesto ingresos
														if($vi>0 && $rowi[6]!="")
														{
															$sqlr="INSERT INTO pptocomprobante_det (cuenta,tercero,detalle,valdebito, valcredito,estado,vigencia,tipo_comp,numerotipo) VALUES ('$rowi[3]','', 'RECIBO CAJA','$vi','0',1,'".$_POST['vigencia']."','16','$concecc')";
															mysqli_query($linkbd,$sqlr);
														}
														//************ FIN MODIFICACION PPTAL
														$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto, detalle,cheque,valdebito,valcredito,estado,vigencia)VALUES ('30 $concecc', '$cuentacont','".$_POST['tercero']."','$rowc[4]','Ingreso ".strtoupper($_POST['dncoding'][$x])."','','$valordeb','$valorcred','1', '".$_POST['vigencia']."')";
														mysqli_query($linkbd,$sqlr);
														//***cuenta caja o banco
														if($_POST['modorec']=='caja')
														{
															$cuentacb=$_POST['cuentacaja'];
															$cajas=$_POST['cuentacaja'];
															$cbancos="";
														}
														if($_POST['modorec']=='banco')
														{
															$cuentacb=$_POST['banco'];
															$cajas="";
															$cbancos=$_POST['banco'];
														}
														$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) VALUES ('30 $concecc','$cuentacb', '".$_POST['tercero']."','$rowc[4]','Ingreso ".strtoupper($_POST['dncoding'][$x])."','','$valorcred',0,'1','".$_POST['vigencia']."')";
														mysqli_query($linkbd,$sqlr);
													}
												}
											}
											//*****intereses ************* 
											//busqueda concepto contable ///SERVICIO *****************
											/*
											if($_POST[dinteres][$x]>0)
											{
												$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='10' AND codigo='$rowi[7]' and tipo='SP'";
												$resc=mysql_query($sqlrc,$linkbd);	  
												while($rowc=mysql_fetch_row($resc))
												{
													$columna= $rowc[6];	
													$cuentacont=$rowc[4];			 
													if($columna=='N')
													{				 
														//$valorcred=$_POST[dvalores][$x];
														$valorcred=$_POST[dinteres][$x];
														$valordeb=0;
														if($rowc[3]=='N')
														{
															//*****inserta del concepto contable  
															//***********MODIFICAR CUENTA PPTAL DE INGRESO AGREGARLE EL RECAUDO *********
															$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito, estado,vigencia,tipo_comp,numerotipo) values('$rowi[3]','','INTERESES ','$valorcred',0,1,'$_POST[vigencia]',16,'$_POST[idcomp]')";
															mysql_query($sqlr,$linkbd); 
															$vi=$_POST[dinteres][$x];
															//************ FIN MODIFICACION PPTAL
															$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito,valcredito,estado,vigencia) values ('30 $_POST[idcomp]','$cuentacont','$_POST[tercero]','$rowc[5]','Ingreso INTERESES ".strtoupper($_POST[dncoding][$x])."','',0,'$vi','1','$_POST[vigencia]')";
															mysql_query($sqlr,$linkbd);
															//***cuenta caja o banco
															if($_POST[modorec]=='caja')
															{				 
																$cuentacb=$_POST[cuentacaja];
																$cajas=$_POST[cuentacaja];
																$cbancos="";
															}
															if($_POST[modorec]=='banco')
															{
																$cuentacb=$_POST[banco];				
																$cajas="";
																$cbancos=$_POST[banco];
															}
															//$valordeb=$_POST[dvalores][$x]*($porce/100);
															//$valorcred=0;
															//echo "bc:$_POST[modorec] - $cuentacb";
															$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('30 $_POST[idcomp]','$cuentacb','$_POST[tercero]', '$rowc[5]','Ingreso INTERESES ".strtoupper($_POST[dncoding][$x])."','','$vi',0,'1','$_POST[vigencia]')";
															mysql_query($sqlr,$linkbd);
															//echo "Conc: $sqlr <br>";					
														}
													}
												}	
											}//********fin intereses
											*/	
										}
									}	
									//************ insercion de cabecera recaudos ************
									$sqlr="INSERT INTO servreciboscaja (id_comp,fecha,vigencia,id_recaudo,recaudado,cuentacaja, cuentabanco,valor, estado,tipo) VALUES ('$idcomp','$fechaf','$vigusu',".$_POST['idrecaudo'].", '".$_POST['modorec']."','$cajas','$cbancos','".$_POST['totalc']."','S','".$_POST['tiporec']."')";
									if (!mysqli_query($linkbd,$sqlr))
									{
										echo "<table><tr><td class='saludo1'><center><font color=blue><img src='imagenes/alert.png'> Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petici�n: <br><font color=red><b>$sqlr</b></font></p>Ocurri� el siguiente problema:<br><pre></pre></center></td></tr></table>";
									}
									else
									{
										$_POST['ncomp']=$concecc;
										//******* GUARDAR DETALLE DEL RECIBO DE CAJA ******	
										for($x=0;$x<count($_POST['dcoding']);$x++)
										{
											$subtotal=$_POST['dvalores'][$x]-$_POST['dinteres'][$x];
											$sqlr="INSERT INTO servreciboscaja_det (id_recibos,ingreso,cargofijo,tarifa,subsidio, descuento,contribucion,saldoanterior,intereses,subtotal,valor,estado) VALUES ('$concecc', '".$_POST['dcoding'][$x]."','".$_POST['dcargofijos'][$x]."','".$_POST['dtarifas'][$x]."', '".$_POST['dsubsidios'][$x]."','".$_POST['ddescuentos'][$x]."','".$_POST['dcontribuciones'][$x]."','".$_POST['dsaldos'][$x]."','".$_POST['dinteres'][$x]."','$subtotal', '".$_POST['dtotales'][$x]."','S')";
											mysqli_query($linkbd,$sqlr);
											//**Actualiza cuenta presupuestal
											$sql="UPDATE servreciboscaja_det JOIN servreciboscaja ON (servreciboscaja_det.id_recibos=servreciboscaja.id_recibos) JOIN tesoingresos_det ON  (tesoingresos_det.codigo=servreciboscaja_det.ingreso AND tesoingresos_det.vigencia=servreciboscaja.vigencia) SET servreciboscaja_det.cuentapres=tesoingresos_det.cuentapres WHERE servreciboscaja_det.id_recibos=$concecc";
											mysqli_query($linkbd,$sql);
											$sqlr="UPDATE terceros_servicios SET saldo=saldo-".$_POST['dsaldos'][$x]."  WHERE CONSECUTIVO='".$_POST['codigousuario']."' AND servicio='".$_POST['dcoding'][$x]."'";
											mysqli_query($linkbd,$sqlr);
											$sqlr="UPDATE servliquidaciones_det SET abono='".$_POST['dtotales'][$x]."' WHERE id_liquidacion='".$_POST['idrecaudo']."' AND servicio='".$_POST['dcoding'][$x]."'";
											mysqli_query($linkbd,$sqlr);
											/*
											//calculos intereses
											$xyx=0;
											$yy=0;
											$datidgen=array(); 
											$datidliq=array();
											$dattarif=array();
											$datsubsi=array();
											$datsaldo=array();
											$datvalli=array();
											$databono=array();
											$databgen=array();
											$datinter=array();
											$datinabo=array();
											$datestad=array();
											$sqlr="
											SELECT id_det,id_liquidacion,tarifa,subsidio,saldo,valorliquidacion,abono,abonogen,intereses,inabono,estado
											FROM servliquidaciones_det 
											WHERE codusuario='$_POST[codigousuario]' AND servicio='".$_POST[dcoding][$x]."'
											ORDER BY id_det DESC";
											$resp = mysql_query($sqlr,$linkbd);
											while (($row =mysql_fetch_row($resp))&&($xyx<1)) 
											{
												$datidgen[$yy]=$row[0];
												$datidliq[$yy]=$row[1];
												$dattarif[$yy]=$row[2];
												$datsubsi[$yy]=$row[3];
												$datsaldo[$yy]=$row[4];
												$datvalli[$yy]=$row[5];
												$databono[$yy]=$row[6];
												$databgen[$yy]=$row[7];
												$datinter[$yy]=$row[8];
												$datinabo[$yy]=$row[9];
												$datestad[$yy]=$row[10];
												if($row[4]==0){$xyx=2;}
												$yy++;
											}
											$totalabonos=$abonres=array_sum($databono);
											$varcont=count($datidgen)-1;
											for ($xf=$varcont;$xf>=0;$xf--)
											{
												$valoreal=$dattarif[$xf]-$datsubsi[$xf]+$datsaldo[$xy];
												$restabonos=$abonres-$valoreal;
												if($restabonos>=0 && $abonres>0)
												{
													$abonres=$restabonos;
													$sqlr3="UPDATE servliquidaciones_det SET estado='PA', abonogen='$valoreal', inabono=intereses WHERE id_det ='$datidgen[$xf]'";
													mysql_query($sqlr3,$linkbd);
												}
												elseif($abonres>0)
												{
													$sqlr3="UPDATE servliquidaciones_det SET estado='A', abonogen='$abonres',inabono=intereses  WHERE id_det ='$datidgen[$xf]'";
													mysql_query($sqlr3,$linkbd);
													$abonres=0;
												}
											}*/
											$sqlr="UPDATE servliquidaciones_det SET estado='P' WHERE id_liquidacion = '".$_POST['idrecaudo']."' and servicio='".$_POST['dcoding'][$x]."'";
											mysqli_query($linkbd,$sqlr);
											
										}		
										//***** FIN DETALLE RECIBO DE CAJA ***************	
										//descargar factura y liquidaciones :    S=ACTIVA N=ANULADA V=VENCIDA
										$sqlr="UPDATE SERVLIQUIDACIONES SET ESTADO='P' WHERE FACTURA='".$_POST['idrecaudo']."'";
										mysqli_query($linkbd,$sqlr);
										$sqlr="UPDATE servfacturas SETestado='P' WHERE id_factura='".$_POST['idrecaudo']."'";
										mysqli_query($linkbd,$sqlr);
										//modificar el saldo del tercero
										$sqlr="UPDATE servclientes SET intereses=intereses-".$_POST['intereses']." WHERE codigo='".$_POST['codigousuario']."'";
										//mysql_query($linkbd,$sqlr);
										//***** INTERESES ***************
										echo "<script>despliegamodalm('visible','1','Se ha almacenado el Recibo de Caja con Exito ');</script>";
									}
								} //fin de la verificacion
								else {echo "<script>despliegamodalm('visible','2','Ya Existe un Recibo de Caja para esta Liquidaci�n');</script>";}
							}
							else {echo "<script>despliegamodalm('visible','2','No Tiene los Permisos para Modificar este Documento');</script>";}
							//****fin if bloqueo
						}//**fin del oculto 
			?>
		</form>
	</body>
</html>