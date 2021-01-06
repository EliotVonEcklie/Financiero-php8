<?php
	require"comun.inc";
	require"funciones.inc";
	require "conversor.php";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: SPID - Contabilidad</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
		<script>
			function validar(){document.form2.submit();}
			function buscaop(e)
			{
				if (document.form2.orden.value!="")
				{
					document.form2.bop.value='1';
					document.form2.submit();
				}
			}
			function guardar()
			{
				if (document.form2.fecha.value!=''){despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
				else{despliegamodalm('visible','2','Faltan datos para completar el registro');}
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
					document.form2.action="cont-pagonominaver-reflejar.php";
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
					document.form2.action="cont-pagonominaver-reflejar.php";
					document.form2.submit();
 				}
			}
			function validar2()
			{
				document.form2.oculto.value=1;
				document.form2.ncomp.value=document.form2.egreso.value;
				document.form2.action="cont-pagonominaver-reflejar.php";
				document.form2.submit();
			}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden") {document.getElementById('ventanam').src="";}
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
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":
						document.form2.oculto.value=2;
						document.form2.submit();
					break;
				}
			}
			function funcionmensaje(){}
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("cont");?></tr>
			<tr>
				<td colspan="3" class="cinta"><img src="imagenes/add2.png" class="mgbt"/><img src="imagenes/guardad.png" class="mgbt"/><img src="imagenes/busca.png" title="Buscar" onClick="location.href='cont-buscapagonomina-reflejar.php'" class="mgbt" /><img src="imagenes/nv.png" Title="Nueva Ventana" class="mgbt" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();"><img src="imagenes/reflejar1.png" title="Reflejar" style="width:24px;" class="mgbt" onClick="guardar()"/><img src="imagenes/print.png" style="width:29px;height:25px;" title="Imprimir" onClick="pdf();" class="mgbt"/><img src="imagenes/iratras.png" title="Atr&aacute;s" onClick="location.href='cont-reflejardocs.php'"></td>
			</tr>
		</table>
		<div id="bgventanamodalm" class="bgventanamodalm">
			<div id="ventanamodalm" class="ventanamodalm">
				<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"></IFRAME>
			</div>
		</div>
		<?php 
			$sqlr="SELECT * FROM admbloqueoanio";
			$res=mysql_query($sqlr,$linkbd);
			$_POST[anio]=array();
			$_POST[bloqueo]=array();
			while ($row =mysql_fetch_row($res))
			{
	 			$_POST[anio][]=$row[0];
	 			$_POST[bloqueo][]=$row[1];
			}
			$vigencia=date(Y);
			$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
			$vigencia=$vigusu;
			$sqlr="SELECT * FROM cuentapagar WHERE estado='S'";
			$res=mysql_query($sqlr,$linkbd);
			while ($row =mysql_fetch_row($res)){$_POST[cuentapagar]=$row[1];}
			$sqlr="SELECT sueldo, cajacompensacion,icbf,sena,iti,esap,arp,salud_empleador,salud_empleado,pension_empleador,pension_empleado, sub_alimentacion,aux_transporte FROM humparametrosliquida";
			$resp = mysql_query($sqlr,$linkbd);
			while ($row =mysql_fetch_row($resp))
			{
				$_POST[salmin]='01';
				$_POST[cajacomp]=$row[1];
				$_POST[icbf]=$row[2];
				$_POST[sena]=$row[3];
				$_POST[iti]=$row[4];
				$_POST[esap]=$row[5];
				$_POST[arp]=$row[6];
				$_POST[salud_empleador]=$row[7];
				$_POST[salud_empleado]=$row[8];
				$_POST[pension_empleador]=$row[9];
				$_POST[pension_empleado]=$row[10];
				$_POST[auxtran]=$row[12];
				$_POST[auxalim]=$row[11];
			}
			if($_POST[oculto]=='2')
			{
				$anioact=split("/", $_POST[fecha]);
				$_POST[anioact]=$anioact[2];
				for($x=0;$x<count($_POST[anio]);$x++)
				{
					if($_POST[anioact]==$_POST[anio][$x])
					{
						if($_POST[bloqueo][$x]=='S'){$bloquear="S";}
						else {$bloquear="N";}
					}
				}
				if($bloquear=="N")
				{
					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
					$fechaf="$fecha[3]-$fecha[2]-$fecha[1]";
					$sqlr="select count(*) from tesoegresosnomina where id_egreso='$_POST[egreso]' and estado ='S'";
					$res=mysql_query($sqlr,$linkbd);
					$row=mysql_fetch_row($res);
					//***********crear el contabilidad
					$ideg=$_POST[egreso];
					$sqlr="delete from comprobante_cab where numerotipo=$ideg and tipo_comp=17";
					mysql_query($sqlr,$linkbd);
					$sqlr="delete from comprobante_det where id_comp='17 $ideg' ";
					mysql_query($sqlr,$linkbd);
					//************CREACION DEL COMPROBANTE CONTABLE ************************
					$sqlr="select count(*) from tesoegresosnomina where id_egreso=$_POST[egreso] and estado ='S'";
					
					$res=mysql_query($sqlr,$linkbd);
					$row=mysql_fetch_row($res);
					$nreg=$row[0];
					if ($nreg>=0)
					{
						$sqlr="insert into tesoegresosnomina_cheque (id_cheque,id_egreso,estado,motivo) values ('$_POST[ncheque]',$ideg,'S','')";
						mysql_query($sqlr,$linkbd);
						//$sqlr="delete from pptorecibopagoegresoppto where idrecibo=$ideg and vigencia='$vigusu'";	 
						//***********crear el contabilidad
						$sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values 		($ideg,17,'$fechaf','$_POST[concepto]','0','$_POST[valpalgar]','$_POST[valpalgar]','0','$_POST[estadoc]')";
						mysql_query($sqlr,$linkbd);
						$idcomp=mysql_insert_id();
						for($y=0;$y<count($_POST[tedet]);$y++)
						{
							switch($_POST[tedet][$y])
							{
								case '':	break;
								case 'SR':	//**** Tipo SR: Pago Salud Empresa ****
								{
									$concepto=buscapptovarnom($_POST[salud_empleador], $_POST[tedet][$y],$vigusu);
									$cuentas=concepto_cuentasn($concepto,'H',2,$_POST[deccs][$y],$_POST[fechafl]);
									$tam=count($cuentas);
									for ($zt=0;$zt<$tam;$zt++)
									{
										$ctacont=$cuentas[$zt][0];
										$ncppto=buscacuentapres($_POST[decuentas][$y],2);
										if('S'==$cuentas[$zt][3])
										{
											$debito=$valorlibranza;
											$credito=0;
											$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('17 $ideg','$ctacont','$_POST[tercero]','".$_POST[deccs][$y]."','Pago Salud Empleador $ncppto','',".$_POST[devalores][$y].",'0','1','$vigusu')";
											mysql_query($sqlr,$linkbd);
										}
										if('S'==$cuentas[$zt][2])
										{
											$valorp=$_POST[devalores][$y];
											$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('17 $ideg','$_POST[banco]','$_POST[tercero]','".$_POST[deccs][$y]."','Pago Banco Salud Empleador','$_POST[cheque]  $_POST[ntransfe]','0','$valorp','1', '$vigusu')";
											mysql_query($sqlr,$linkbd);
										}
									}
									$sqlr="update `humnomina_saludpension` set estado='P' WHERE id='".$_POST[idedescuento][$y]."' and id_nom='$_POST[orden]'";
								}break;
								case 'SE':	//**** Tipo SE: Pago Salud Empleado ****
								{
								 	$concepto=buscapptovarnom($_POST[salud_empleado], $_POST[tedet][$y],$vigusu);
									$ccosto=$_POST[deccs][$y];
									$sqlr="SELECT * FROM conceptoscontables_det WHERE codigo='$concepto' AND modulo='2' AND cc='$ccosto' and tipo='H' AND fechainicial=(SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE fechainicial <= '$_POST[fechafl]' AND modulo='2' AND tipo='H' AND CC='$ccosto' AND codigo='$concepto')";
									$respc = mysql_query($sqlr,$linkbd);
									while ($rowr=mysql_fetch_row($respc))
									{
										$ctacont=$rowr[4];
										$ncppto=buscacuentapres($_POST[decuentas][$y],2);
										if('S'==$rowr[7])
										{
											$debito=$valorlibranza;
											$credito=0;
											$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('17 $ideg','$rowr[4]','$_POST[tercero]','".$_POST[deccs][$y]."','Pago Salud Empleado','','".$_POST[devalores][$y]."','0','1','$vigusu')";
											mysql_query($sqlr,$linkbd);
										}
										if('S'==$rowr[6])
										{
											$valorp=$_POST[devalores][$y];
											$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('17 $ideg','$_POST[banco]','$_POST[tercero]','".$_POST[deccs][$y]."','Pago Banco Salud Empleado','$_POST[cheque] $_POST[ntransfe]','0','$valorp','1','$vigusu')";
											mysql_query($sqlr,$linkbd);
										}
									}
									$sqlr="update humnomina_saludpension set estado='P' WHERE id='".$_POST[idedescuento][$y]."' and id_nom='$_POST[orden]'";
								}break;
								case 'PE':	//**** Tipo PE: Pago Pension Empleado ****
								{
									$concepto=buscapptovarnom($_POST[pension_empleado], $_POST[tedet][$y],$vigusu);
									$ccosto=$_POST[deccs][$y];
									$sqlr="SELECT * FROM conceptoscontables_det WHERE codigo='$concepto' AND modulo='2' AND cc='$ccosto' AND tipo='H' AND fechainicial=(SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE fechainicial <= '$_POST[fechafl]' AND modulo='2' AND tipo='H' AND CC='$ccosto' AND codigo='$concepto')";
									$respc = mysql_query($sqlr,$linkbd);
									while ($rowr=mysql_fetch_row($respc))
									{
										$ctacont=$rowr[4];
										//$ncppto=buscacuentapres($_POST[decuentas][$y],2);
										if('S'==$rowr[7])
										{
											$debito=$valorlibranza;
											$credito=0;
											$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito, estado, vigencia) values ('17 $ideg','$rowr[4]','$_POST[tercero]','".$_POST[deccs][$y]."','Pago Pension Empleado','',".$_POST[devalores][$y].",'0','1' ,'$vigusu')";
											mysql_query($sqlr,$linkbd);
										}
										if('S'==$rowr[6])
										{
											$valorp=$_POST[devalores][$y];
											$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('17 $ideg','$_POST[banco]','$_POST[tercero]','".$_POST[deccs][$y]."','Pago Banco Pension Empleado','$_POST[cheque]  $_POST[ntransfe]','0','$valorp','1','$vigusu')";
											mysql_query($sqlr,$linkbd);
										}
									}
									$sqlr="update `humnomina_saludpension` set estado='P' WHERE id='".$_POST[idedescuento][$y]."' and id_nom='$_POST[orden]'";
								}break;
								case 'PR':	//**** Tipo PR: Pago Pension Empresa ****
								{
									$concepto=buscapptovarnom($_POST[pension_empleador], $_POST[tedet][$y],$vigusu);
									$cuentas=concepto_cuentasn($concepto,'H',2,$_POST[deccs][$y],$_POST[fechafl]);
									$tam=count($cuentas);
									for ($zt=0;$zt<$tam;$zt++)
									{
										$ctacont=$cuentas[$zt][0];
										$ncppto=buscacuentapres($_POST[decuentas][$y],2);
										if('S'==$cuentas[$zt][3])
										{
											$debito=$valorlibranza;
											$credito=0;
											$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito, estado, vigencia) values ('17 $ideg','$ctacont','$_POST[tercero]' ,'".$_POST[deccs][$y]."' , 'Pago Pension Empleador".$ncppto."','',".$_POST[devalores][$y].",0,'1' ,'$vigusu')";
											mysql_query($sqlr,$linkbd);
										}
										if('S'==$cuentas[$zt][2])
										{
											$valorp=$_POST[devalores][$y];
											$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito, estado, vigencia) values ('17 $ideg','$_POST[banco]','$_POST[tercero]' ,'".$_POST[deccs][$y]."' , 'Pago Banco Pension Empleador','$_POST[cheque]  $_POST[ntransfe]',0,'$valorp','1' ,'$vigusu')";
											mysql_query($sqlr,$linkbd);
										}
									}
									$sqlr="update `humnomina_saludpension` set estado='P' WHERE id='".$_POST[idedescuento][$y]."' and id_nom='$_POST[orden]'";
								}break;
								case 'F':	//**** Tipo F: Pago Parafiscales ****
								{
									$concepto=$_POST[ttipo][$y];
									$cuentas=concepto_cuentasn($concepto,'H',2,$_POST[deccs][$y],$_POST[fechafl]);	
									$tam=count($cuentas);
									for ($zt=0;$zt<$tam;$zt++)
									{
										$ctacont=$cuentas[$zt][0];
										$ncppto=buscacuentapres($_POST[derecursos][$y],2);
										if('S'==$cuentas[$zt][3])
										{
											$debito=$valorlibranza;
											$credito=0;
											$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('17 $ideg','$ctacont','$_POST[tercero]','".$_POST[deccs][$y]."','Pago parafiscales $ncppto','','".$_POST[devalores][$y]."',0,'1','$vigusu')";
											mysql_query($sqlr,$linkbd);
										}
										if('S'==$cuentas[$zt][2])
										{
											$valorp=$_POST[devalores][$y];
											$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito, estado, vigencia) values ('17 $ideg','$_POST[banco]','$_POST[tercero]','".$_POST[deccs][$y]."','Pago Banco $ncppto','$_POST[cheque]  $_POST[ntransfe]',0,'$valorp','1','$vigusu')";
											mysql_query($sqlr,$linkbd);
										}
									}
									$sqlr="update `humnomina_saludpension` set estado='P' WHERE id='".$_POST[idedescuento][$y]."' and id_nom='$_POST[orden]'";
								}break;
								case 'DS':	//***+ Tipo D: Pago Descuentos Empleado ****
								{
									$sqlr="SELECT id_retencion FROM humretenempleados WHERE id='".$_POST[idedescuento][$y]."'";
									$respr=mysql_query($sqlr,$linkbd);
									$rret=mysql_fetch_row($respr);
									$sq="select fechainicial from humvariablesretenciones_det where codigo='$rret[0]' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
									$re=mysql_query($sq,$linkbd);
									while($ro=mysql_fetch_assoc($re)){$_POST[fechacausa]=$ro["fechainicial"];}
									$sqlr="SELECT DISTINCT * FROM humvariablesretenciones T1,humvariablesretenciones_det T2 WHERE T1.codigo='$rret[0]' AND T1.codigo=T2.codigo AND T2.fechainicial='$_POST[fechacausa]'";
									$respr=mysql_query($sqlr,$linkbd);
									while ($rowr=mysql_fetch_row($respr)) 
									{
										$ctacont=$rowr[8];
										$ncppto=buscacuentapres($_POST[derecursos][$y],2);
										if('S'==$rowr[10])
										{
											$debito=$valorlibranza;
											$credito=0;
											$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito, estado, vigencia) values ('17 $ideg','$rowr[8]','$_POST[tercero]' ,'".$_POST[deccs][$y]."' , 'Pago $ncppto','',".$_POST[devalores][$y].",0,'1' ,'$vigusu')";
											mysql_query($sqlr,$linkbd);
										}
										if('S'==$rowr[9])
										{
											$valorp=$_POST[devalores][$y];
											$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito, estado, vigencia) values ('17 $ideg','$_POST[banco]','$_POST[tercero]' ,'".$_POST[deccs][$y]."' , 'Pago Banco $ncppto','$_POST[cheque]  $_POST[ntransfe]',0,'$valorp','1' ,'$vigusu')";
											mysql_query($sqlr,$linkbd);
										}
									}
									$sqlr="update humnominaretenemp set estado='P' WHERE id='".$_POST[decuentas][$y]."' and id_nom='$_POST[orden]'";
									$respr=mysql_query($sqlr,$linkbd);
								}break;
								default:	//**** Tipo : Pago Salarios y otros pagos ****
								{
									//*** BUSCAR NOMINA
									$vnom=0;
									$vauxali=0;
									$vauxtra=0;
									$sqlrnom="SELECT auxalim, auxtran FROM humnomina_det WHERE id_nom='$_POST[orden]' AND cedulanit='".$_POST[decuentas][$y]."' AND tipopago='".$_POST[tedet][$y]."'";
									$resn = mysql_query($sqlrnom,$linkbd);
									while($rown=mysql_fetch_row($resn))
									{
										$vauxali=$rown[0];
										$vauxtra=$rown[1];
									}
									$vnom=$_POST[devalores][$y];
									if($vnom>0)
									{
										$concepto=buscapptovarnom($_POST[tedet][$y],'N',$vigusu);
										$ccosto=$_POST[deccs][$y];
										$sqlrdes="SELECT nombre FROM humvariables WHERE estado='S' AND codigo='".$_POST[tedet][$y]."'";
										$resdes = mysql_query($sqlrdes,$linkbd);
										$rowdes =mysql_fetch_row($resdes);
										$sqlr="SELECT * FROM conceptoscontables_det WHERE codigo='$concepto' AND modulo='2' AND cc='$ccosto' AND tipo='H' AND fechainicial=(SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE fechainicial <= '$_POST[fechafl]' AND modulo='2' AND tipo='H' AND CC='$ccosto' AND codigo='$concepto')";
										$resc = mysql_query($sqlr,$linkbd);
										while($rowc=mysql_fetch_row($resc))
										{
											if($rowc[3]=='N')
											{
												if($rowc[7]=='S')
												{
													$ncppto=buscacuentapres($_POST[decuentas][$y],2);
													$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito, estado, vigencia) values ('17 $ideg','$rowc[4]','$_POST[tercero]','".$_POST[deccs][$y]."','Pago $rowdes[0] $ncppto','','$vnom','0','1' ,'$vigusu')";
													mysql_query($sqlr,$linkbd);
													//***************************
													if($rowc[3]=='N')
													{
														$valorp=$_POST[devalores][$y];
														//***buscar retenciones
														//INCLUYE EL CHEQUE
														$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('17 $ideg','$_POST[banco]','$_POST[tercero]','".$_POST[deccs][$y]."','Pago Banco $rowdes[0] $ncppto', '$_POST[cheque]  $_POST[ntransfe]','0','$vnom','1' ,'$vigusu')";
														mysql_query($sqlr,$linkbd);
													}
												}
											}
										}
									}
								}
							}
						}
						echo "<script>despliegamodalm('visible','2','Se ha almacenado el Egreso con Exito ');</script>";
					}
					else
					{
						echo"<script>despliegamodalm('visible','2','No se puede almacenar, ya existe un egreso para esta orden');</script>";
					}
					}
				else {echo"<script>despliegamodalm('visible','2','No se puede reflejar por Cierre de A�o');</script>";}
			}//************ FIN DE IF OCULTO************
				//*********** cuenta origen va al credito y la destino al debito
				if($_GET[idegre]!=""){echo "<script>document.getElementById('codrec').value=$_GET[idegre];</script>";}
				if(!$_POST[oculto])
				{
					$sqlr="select *from cuentapagar where estado='S' ";
					$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res)){$_POST[cuentapagar]=$row[1];}
					$sqlr="select * from tesoegresosnomina ORDER BY id_EGRESO DESC";
					$res=mysql_query($sqlr,$linkbd);
					$r=mysql_fetch_row($res);
					$_POST[maximo]=$r[0];
					if ($_POST[codrec]!="" || $_GET[idegre]!="")
					{
						if($_POST[codrec]!=""){$sqlr="select * from tesoegresosnomina where id_EGRESO='$_POST[codrec]'";}
						else {$sqlr="select * from tesoegresosnomina where id_EGRESO='$_GET[idegre]'";}
					}
					else {$sqlr="select * from tesoegresosnomina ORDER BY id_EGRESO DESC";}
					$res=mysql_query($sqlr,$linkbd);
					$r=mysql_fetch_row($res);
					$_POST[ncomp]=$r[0];
					$_POST[egreso]=$r[0];
					$check1="checked";
				}
				$_POST[vigencia]=$vigusu;
				if($_POST[oculto]=='1' || !$_POST[oculto])
				{
					$sqlr="select * from tesoegresosnomina where id_egreso=$_POST[egreso]";
					$res=mysql_query($sqlr,$linkbd);
					$consec=0;
					while($r=mysql_fetch_row($res))
					{
						$consec=$r[0];
						$_POST[orden]=$r[2];
						$_POST[estado]=$r[13];
						if($r[13]=='S'){$_POST[estadoc]=1;}
						if($r[13]=='N'){$_POST[estadoc]=0;}
						$_POST[tipop]=$r[14];
						$_POST[banco]=$r[9];
						$_POST[ncheque]=$r[10];
						$_POST[cb]=$r[12];
						$_POST[transferencia]=$r[12];
						$_POST[ntransfe]=$r[10];
						$_POST[fecha]=$r[3];
						$_POST[fechafi]=$r[3];
						$_POST[fechafl]=$r[3];
						$_POST[vigencia]=$r[4];
					}
					ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
					$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
					$_POST[fecha]=$fechaf;
					$_POST[egreso]=$consec;		 
				}
				switch($_POST[tabgroup1])
				{
					case 1:	$check1='checked';break;
					case 2:	$check2='checked';break;
					case 3:	$check3='checked';
				}
			?>
			<form name="form2" method="post" action=""> 
				<input type="hidden" name="anio[]" id="anio[]" value="<?php echo $_POST[anio] ?>"/>
				<input type="hidden" name="anioact" id="anioact" value="<?php echo $_POST[anioact] ?>"/>
				<input type="hidden" name="bloqueo[]" id="bloqueo[]" value="<?php echo $_POST[bloqueo] ?>"/>
				<input type="hidden" id="cajacomp" name="cajacomp"  value="<?php echo $_POST[cajacomp]?>"/>
				<input type="hidden" id="codrec" name="codrec" value="<?php echo $_POST[codrec]?>"/>
				<input type="hidden" id="icbf" name="icbf" value="<?php echo $_POST[icbf]?>"/>
				<input type="hidden" id="sena" name="sena" value="<?php echo $_POST[sena]?>"/>
				<input type="hidden" id="esap" name="esap" value="<?php echo $_POST[esap]?>"/>
				<input type="hidden" id="iti" name="iti" value="<?php echo $_POST[iti]?>"/>
				<input type="hidden" id="arp" name="arp" value="<?php echo $_POST[arp]?>"/>
				<input type="hidden" id="salud_empleador" name="salud_empleador" value="<?php echo $_POST[salud_empleador]?>"/>
				<input type="hidden" id="salud_empleado" name="salud_empleado" value="<?php echo $_POST[salud_empleado]?>"/>
				<input type="hidden" id="transp" name="transp" value="<?php echo $_POST[transp]?>"/>
				<input type="hidden" id="pension_empleador" name="pension_empleador" value="<?php echo $_POST[pension_empleador]?>"/>
				<input type="hidden" id="pension_empleado" name="pension_empleado" value="<?php echo $_POST[pension_empleado]?>"/>
				<input type="hidden" id="salmin" name="salmin" value="<?php echo $_POST[salmin]?>"/> 
				<input type="hidden" id="auxalim" name="auxalim" value="<?php echo $_POST[auxalim]?>"/>
				<input type="hidden" id="auxtran" name="auxtran" value="<?php echo $_POST[auxtran]?>"/>
				<?php
					if($_POST[orden]!='' )
					{
						//*** busca detalle cdp
						$sqlr="select *from tesoegresosnomina where id_egreso=$_POST[ncomp] ";
						$resp = mysql_query($sqlr,$linkbd);
						$row =mysql_fetch_row($resp);
						$_POST[concepto]=$row[8];
						$_POST[tercero]=$row[11];
						$_POST[ntercero]=buscatercero($_POST[tercero]);
						$_POST[valororden]=$row[7];
						$_POST[retenciones]=0;
						$_POST[totaldes]=number_format($_POST[retenciones],2);
						$_POST[valorpagar]=$_POST[valororden]-$_POST[retenciones];
						$_POST[valpalgar]=$_POST[valororden]-$_POST[retenciones];
						$_POST[bop]="";
					}
					else
					{
						$_POST[cdp]="";
						$_POST[detallecdp]="";
						$_POST[tercero]="";
						$_POST[ntercero]="";
						$_POST[bop]="";
					}
				?>
				<input type="hidden" id="valpalgar" name="valpalgar" value="<?php echo $_POST[valpalgar]?>" > 
				<table class="inicio" align="center" >
					<tr>
						<td colspan="8" class="titulos">Comprobante de Egreso Nomina</td>
						<td class="cerrar" style="width:7%;"><a onClick="location.href='cont-principal.php'">&nbsp;Cerrar</a></td>
					</tr>
					<tr>
						<td style="width:3.5cm;" class="saludo1">No Egreso:</td>
						<td style="width:10%;">
							<a href="#" onClick="atrasc()"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a>
							<input name="cuentapagar" type="hidden" value="<?php echo $_POST[cuentapagar]?>" > 
							<input name="egreso" type="text" value="<?php echo $_POST[egreso]?>" style="width:50%" onKeyUp="return tabular(event,this)" onBlur="validar2()"  > 
							<input name="ncomp" type="hidden" value="<?php echo $_POST[ncomp]?>">
							<a href="#" onClick="adelante()"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> 
							<input type="hidden" value="a" name="atras" >
							<input type="hidden" value="s" name="siguiente" >
							<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo">
						</td>
						<td style="width:2.5cm;" class="saludo1">Fecha: </td>
						<td style="width:10%;"><input id="fc_1198971545" name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10" style="width:100%;" onKeyUp="return tabular(event,this)" readonly></td> 
						<input type="hidden" name="fechafi" id="fechafi" value="<?php echo $_POST[fechafi];?>"/>      
						<td style="width:3.5cm;" class="saludo1">Forma de Pago:</td>
						<td style="width:10%;">
							<select name="tipop" onChange="validar();" ="return tabular(event,this)" style="width:100%">
								<?php
									if($_POST[tipop]=='cheque'){echo'<option value="cheque" selected>Cheque</option>'; }
									else {echo'<option value="transferencia" selected>Transferencia</option>';}
								?>
							</select>
						</td>
						<input type="hidden" name="fechafl" id="fechafl" value="<?php echo $_POST[fechafl]?>"/>
						<td style="width:3.5cm;" class="saludo1">Estado:</td> 
						<td style="width:15%;">
						<?php
							if($_POST[estado]=="S")
							{
								$valuees="ACTIVO";
								$stylest="width:68%; background-color:#0CD02A; color:white; text-align:center;";
							}
							else if($_POST[estado]=="N")
							{
								$valuees="ANULADO";
								$stylest="width:68%; background-color:#FF0000; color:white; text-align:center;";
							}
							else if($_POST[estado]=="P")
							{
								$valuees="PAGO";
								$stylest="width:68%; background-color:#0404B4; color:white; text-align:center;";
							}
							echo "<input type='text' name='estado' id='estado' value='$valuees' style='$stylest' readonly />";
						?>
							<input name="estadoc" type="hidden" value="<?php echo $_POST[estadoc]?>" size="5"  readonly >
							<input name="vigencia" type="text" value="<?php echo $_POST[vigencia]?>" size="4"  readonly >
						</td>
					</tr>
					<tr>
						<td style="width:3.5cm" class="saludo1">No Orden Pago:</td>
						<td style="width:10%"><input name="orden" type="text" value="<?php echo $_POST[orden]?>" style="width:62%" onKeyUp="return tabular(event,this)" onBlur="buscaop(event)" readonly ></td>
						<input type="hidden" value="0" name="bop">
						<td class="saludo1">Tercero:</td>
						<td><input id="tercero" type="text" name="tercero" style="width:100%" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo $_POST[tercero]?>" readonly></td>
						<td colspan="4"><input name="ntercero" type="text" value="<?php echo $_POST[ntercero]?>" style="width:100%" readonly></td>
					</tr>
					<tr>
						<td class="saludo1">Concepto:</td>
						<td colspan="7"><input name="concepto" type="text" value="<?php echo $_POST[concepto]?>"  style="width:100%" readonly></td>
					</tr>
					<?php
						if($_POST[tipop]=='cheque')//**** if del cheques 
						{
							echo"
							<tr>
								<td class='saludo1'>Cuenta Bancaria:</td>
								<td colspan='5'>
									<select id='banco' name='banco' onChange='validar()' onKeyUp='return tabular(event,this)'>";
							$sqlr="select tesobancosctas.estado,tesobancosctas.cuenta,tesobancosctas.ncuentaban,tesobancosctas.tipo,terceros.razonsocial,tesobancosctas.tercero from tesobancosctas,terceros where tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.estado='S'  and tesobancosctas.tipo='Corriente'";
							$res=mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($res)) 
							{
								if($row[1]==$_POST[banco])
								{
									echo "<option value=$row[1] SELECTED>$row[2] - Cuenta $row[3] - $row[4]</option>";
									$_POST[nbanco]=$row[4];
									$_POST[ter]=$row[5];
									$_POST[cb]=$row[2];
									$_POST[tcta]=$row[3];
								}
							}
							echo"
									</select>
									<input type='hidden' name='tcta' value='$_POST[tcta]'/>
									<input type='hidden' name='cb' value='$_POST[cb]'/>
									<input type='hidden' name='ter' id='ter' value='$_POST[ter]' >
									<input type='hidden' name='nbanco' id='nbanco' value='$_POST[nbanco]' size='50' readonly/>
								</td>
								<td class='saludo1'>Cheque:</td>
								<td><input type='text' name='ncheque' id='ncheque' value='$_POST[ncheque]' size='20' readonly/></td>
							</tr>";
						}
						if($_POST[tipop]=='transferencia')//**** if del transferencias
						{
							echo"
							<tr>
								<td class='saludo1'>Cuenta Bancaria:</td>
								<td colspan='3'>
									<select id='banco' name='banco' onChange='validar()' onKeyUp='return tabular(event,this)'>";
							$sqlr="select tesobancosctas.estado,tesobancosctas.cuenta,tesobancosctas.ncuentaban,tesobancosctas.tipo, terceros.razonsocial,tesobancosctas.tercero from tesobancosctas,terceros where tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.estado='S' ";
							$res=mysql_query($sqlr,$linkbd);
							while($row =mysql_fetch_row($res))
							{
								if($row[1]==$_POST[banco])
								{
									echo "<option value='$row[1]' SELECTED>$row[2] - Cuenta $row[3] - $row[4]</option>";
									$_POST[nbanco]=$row[4];
									$_POST[ter]=$row[5];
									$_POST[cb]=$row[2];
									$_POST[tcta]=$row[3];
								}
							}
							echo"
								</select>
									<input type='hidden' name='tcta' value='$_POST[tcta]'/>
									<input type='hidden 'name='cb' value='$_POST[cb]'/>
									<input type='hidden' id='ter' name='ter' value='$_POST[ter]'/>
									<input type='hidden' id='nbanco' name='nbanco' value='$_POST[nbanco]'/>
								</td>
								<td class='saludo1'>No Transferencia:</td>
								<td><input type='text' id='ntransfe' name='ntransfe' value='$_POST[ntransfe]' style='width:100%' readonly/></td>
							</tr>";
						}
					?> 
					<tr>
						<td class="saludo1">Valor Orden:</td>
						<td><input type="text" name="valororden" id="valororden" onKeyUp="return tabular(event,this)" value="<?php echo number_format($_POST[valororden],2,',','.')?>" style="width:100%; text-align:right;" readonly/></td>	  
						<td class="saludo1">Retenciones:</td>
						<td><input name="retenciones" type="text" id="retenciones" onKeyUp="return tabular(event,this)" value="<?php echo number_format($_POST[retenciones],2,',','.')?>" style="width:100%; text-align:right;" readonly/></td>	  
						<td class="saludo1">Valor a Pagar:</td>
						<td><input name="valorpagar" type="text" id="valorpagar" onKeyUp="return tabular(event,this)" value="<?php echo number_format($_POST[valorpagar],2,',','.')?>" style="width:100%; text-align:right;" readonly/></td>
						<input type="hidden" name="oculto"value="1"/>
					</tr>
				</table>
				<div class="subpantallac4" style="width:100%; height:55%" >
 					<table class="inicio">
						<tr><td colspan="7" class="titulos">Detalle Egreso Nomina</td></tr>
						<tr class="titulos2" >
        					<td>No</td>
            				<td>Nit</td>
                            <td>Tercero</td>
                            <td>Detalle</td>
                            <td>CC</td>
                            <td>Cta Presupuestal</td>
                            <td>Valor</td>
       					</tr>
						<?php 		
							if ($_POST[elimina]!='')
							{ 
		 						$posi=$_POST[elimina];
		 						unset($_POST[dccs][$posi]);
		 						unset($_POST[dvalores][$posi]);		 
		 						$_POST[dccs]= array_values($_POST[dccs]); 
							}	 
							if ($_POST[agregadet]=='1')
							{
		 						$_POST[dccs][]=$_POST[cc];
		 						$_POST[agregadet]='0';
								echo"
		 						<script>
									document.form2.banco.value='';
									document.form2.nbanco.value='';
									document.form2.banco2.value='';
									document.form2.nbanco2.value='';
									document.form2.cb.value='';
									document.form2.cb2.value=';
									document.form2.valor.value='';	
									document.form2.numero.value='';	
									document.form2.agregadet.value='0';				
									document.form2.numero.select();
									document.form2.numero.focus();	
		 						</script>";
							}
							$_POST[totalc]=0;
							$sqlrul="SELECT * FROM tesoegresosnomina_det WHERE id_egreso='$_POST[egreso]' AND estado='S' AND (tipo='F' OR tipo='DS')";
							$respul = mysql_query($sqlrul,$linkbd);
							if (mysql_num_rows($respul)>0)
							{$sqlr="SELECT * FROM tesoegresosnomina_det WHERE id_egreso='$_POST[egreso]' AND estado='S'";}
							else
							{$sqlr="SELECT id_det,id_egreso,id_orden,tipo,tercero,ntercero_det,cuentap,cc,SUM(valor),estado,ndes,valordevengado FROM tesoegresosnomina_det WHERE id_egreso='$_POST[egreso]' AND estado='S' GROUP BY tipo ";}
							$dcuentas[]=array();
							$dncuentas[]=array();
							$resp2 = mysql_query($sqlr,$linkbd);
							$iter='saludo1a';
							$iter2='saludo2';
							while($row2=mysql_fetch_row($resp2))
							{
								$vauxali=$vauxtra=0;
								if($row2[3]=='01')
								{
									$sqlrnom="SELECT auxalim, auxtran FROM humnomina_det WHERE id_nom='$_POST[orden]' AND cedulanit='$row2[4]' AND tipopago='01'"; 
									$resn = mysql_query($sqlrnom,$linkbd);
									$rown=mysql_fetch_row($resn);
									$vauxali=$rown[0];
									$vauxtra=$rown[1];						
									$valorneto=$row2[8]-$vauxali-$vauxtra;
								}
								else{$valorneto=$row2[8];}
								$nombre=buscacuentapres($row2[6],2);
								$tercero=buscatercero($row2[4]);
								
								if($row2[10]=='')
								{
									switch($row2[3])
									{
										case 'SR':	$nomdetalle='Pago Salud Empresa';break;
										case 'SE':	$nomdetalle='Pago Salud Empleado';break;
										case 'PR':	$nomdetalle='Pago Pension Empresa';break;
										case 'PE':	$nomdetalle='Pago Pension Empleado';break;
										default:	$sqlrdes="SELECT nombre FROM humvariables WHERE estado='S' AND codigo='$row2[3]'";
													$resdes = mysql_query($sqlrdes,$linkbd);
													$rowdes =mysql_fetch_row($resdes);
													$nomdetalle=$rowdes[0];
									}
								}
								else
								{
									$sqlrdes="SELECT nombre FROM humparafiscales WHERE estado='S' AND codigo='$row2[10]'";
									$resdes = mysql_query($sqlrdes,$linkbd);
									$rowdes =mysql_fetch_row($resdes);
									$nomdetalle=$rowdes[0];
								}
								echo "
								<tr class='$iter'>
									<input type='hidden' name='tedet[]' value='$row2[3]'/>
									<input type='hidden' name='ttipo[]' value='$row2[10]'/>
									<input type='hidden' name='decuentas[]' value='$row2[4]'/>
									<input type='hidden' name='idedescuento[]' value='$row2[10]'/>
									<input type='hidden' name='deccs[]' value='$row2[7]'/>
									<input type='hidden' name='derecursos[]' value='$row2[6]'/>
									<input type='hidden' name='devalores[]' value='$valorneto'/>
									<td>$row2[3] - $row2[10]</td>
									<td>$row2[4]</td>
									<td>$tercero </td>
									<td>$nomdetalle</td>
									<td>$row2[7]</td>
									<td>$row2[6]</td>
		 							<td style='text-align:right;'>$".number_format($valorneto,2,',','.')."</td>
								</tr>";
		 						$aux=$iter;
								$iter=$iter2;
								$iter2=$aux;
								$_POST[totalc]=$_POST[totalc]+$valorneto;
								if($vauxali!=0)
								{
									$sqlrdes="SELECT nombre FROM humvariables WHERE estado='S' AND codigo='07'";
									$resdes = mysql_query($sqlrdes,$linkbd);
									$rowdes =mysql_fetch_row($resdes);
									$nomdetalle=$rowdes[0];
									$sqlrcp="SELECT cuentapres FROM humvariables_det WHERE codigo='07' AND cc='$row2[7]' AND estado='S' AND vigencia='$_POST[vigencia]'";
									$rescp= mysql_query($sqlrcp,$linkbd);
									$rcp=mysql_fetch_row($rescp);
									echo "
									<tr class='$iter'>
										<input type='hidden' name='tedet[]' value='07'/>
										<input type='hidden' name='ttipo[]' value='$row2[10]'/>
										<input type='hidden' name='decuentas[]' value='$row2[4]'/>
										<input type='hidden' name='idedescuento[]' value='$row2[10]'/>
										<input type='hidden' name='deccs[]' value='$row2[7]'/>
										<input type='hidden' name='derecursos[]' value='$rcp[0]'/>
										<input type='hidden' name='devalores[]' value='$vauxali'/>
										<td>07 - $row2[10]</td>
										<td>$row2[4]</td>
										<td>$tercero</td>
										<td>$nomdetalle</td>
										<td>$row2[7]</td>
										<td>$rcp[0]</td>
										<td style='text-align:right;'>$".number_format($vauxali,2,',','.')."</td>
									</tr>";
									$aux=$iter;
									$iter=$iter2;
									$iter2=$aux;
									$_POST[totalc]=$_POST[totalc]+$vauxali;
								}
								if($vauxtra!=0)
								{
									$sqlrdes="SELECT nombre FROM humvariables WHERE estado='S' AND codigo='08'";
									$resdes = mysql_query($sqlrdes,$linkbd);
									$rowdes =mysql_fetch_row($resdes);
									$nomdetalle=$rowdes[0];
									$sqlrcp="SELECT cuentapres FROM humvariables_det WHERE codigo='07' AND cc='$row2[7]' AND estado='S' AND vigencia='$_POST[vigencia]'";
									$rescp= mysql_query($sqlrcp,$linkbd);
									$rcp=mysql_fetch_row($rescp);
									echo "
									<tr class='$iter'>
										<input type='hidden' name='tedet[]' value='08'/>
										<input type='hidden' name='ttipo[]' value='$row2[10]'/>
										<input type='hidden' name='decuentas[]' value='$row2[4]'/>
										<input type='hidden' name='idedescuento[]' value='$row2[10]'/>
										<input type='hidden' name='deccs[]' value='$row2[7]'/>
										<input type='hidden' name='derecursos[]' value='$rcp[0]'/>
										<input type='hidden' name='devalores[]' value='$vauxtra'/>
										<td>08 - $row2[10]</td>
										<td>$row2[4]</td>
										<td>$tercero</td>
										<td>$nomdetalle</td>
										<td>$row2[7]</td>
										<td>$rcp[0]</td>
										<td style='text-align:right;'>$".number_format($vauxtra,2,',','.')."</td>
									</tr>";
									$aux=$iter;
									$iter=$iter2;
									$iter2=$aux;
									$_POST[totalc]=$_POST[totalc]+$vauxtra;
								}
								
		 						$_POST[totalcf]=number_format($_POST[totalc],2,".",",");
							}
							$resultado = convertir($_POST[valorpagar]);
							$_POST[letras]=$resultado." PESOS M/CTE";
	   						 echo "<tr class='titulos2'>
			<td colspan='5'></td>
			<td>Total</td>
			<td align='right'>
				<input name='totalcf' type='hidden' value='$_POST[totalcf]'>".number_format($_POST[totalc],2,',','.')."
				<input name='totalc' type='hidden' value='$_POST[totalc]'>
			</td>
		</tr>
		<tr class='titulos2'>
			<td >Son:</td> 
			<td colspan='6'>
				<input name='letras' type='hidden' value='$_POST[letras]'>".$_POST[letras]."
			</td>
		</tr>";
		?>
        <script>
       
		//calcularpago();
        </script>
	</table>
</div>	
        <?php
if($_POST[oculto]=='2')
{
	
				//$linkbd=conectar_bd();
				//ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
				//$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
			//************CREACION DEL COMPROBANTE CONTABLE ************************
			//$sqlr="update  tesoegresos set fecha='$fechaf' where id_egreso=$_POST[egreso]";
			//$res=mysql_query($sqlr,$linkbd);
			//$sqlr="update  comprobante_cab set fecha='$fechaf' where 	numerotipo=$_POST[egreso] and tipo_comp=6";
			//$res=mysql_query($sqlr,$linkbd);
			//echo $sqlr;
			
}//************ FIN DE IF OCULTO************
?>	
</form>
 </td></tr>  
</table>
</body>
</html>	 