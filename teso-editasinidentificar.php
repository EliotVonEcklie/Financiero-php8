<?php
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=iso-8859-1");
	require 'comun.inc';
	require 'funciones.inc';
	require 'conversor.php';
	sesion();
	$linkbd=conectar_bd();
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
		<meta http-equiv="X-UA-Compatible" content="ie=edge"/>
		<title>:: SPID - Tesoreria</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script type="text/javascript" src="css/calendario.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
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
				if(document.form2.codingreso.value!="" &&  document.form2.valor.value>0  )
				{ 
					document.form2.agregadet.value=1;
				//			document.form2.chacuerdo.value=2;
					document.form2.submit();
				}
				else {
				 	alert("Falta informacion para poder Agregar");
				}
			}
			function eliminar(variable)
			{
				if (confirm("Esta Seguro de Eliminar"))
				{
					document.form2.elimina.value=variable;
					//eli=document.getElementById(elimina);
					vvend=document.getElementById('elimina');
					//eli.value=elimina;
					vvend.value=variable;
					document.form2.submit();
				}
			}
			function guardar()
			{
				ingresos2=document.getElementsByName('dcoding[]');
				if (document.form2.fecha.value!='' && ingresos2.length>0)
				{
					if (confirm("Esta Seguro de Guardar"))
				  	{
				  		document.form2.oculto.value=2;
				  		document.form2.submit();
				  	}
				}
				else{
				  	alert('Faltan datos para completar el registro');
				  	document.form2.fecha.focus();
				  	document.form2.fecha.select();
				}
			}
			function guardar1()
			{
				despliegamodalm('visible','4','Esta Seguro de Guardar Comprobante Manual','1');
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
					case "1":	document.getElementById('oculto').value="3";
								document.form2.submit();break;
				}
			}
			function funcionmensaje()
			{
				var codig=document.form2.idcomp.value;
				document.location.href = "teso-editasinidentificar.php?idrecaudo="+codig;
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
			function adelante()
			{
				if(parseFloat(document.form2.idcomp.value)<parseFloat(document.form2.maximo.value))
				{
					document.form2.idcomp.value=parseFloat(document.form2.idcomp.value)+1;
					var idcta=document.form2.idcomp.value;
					document.form2.action="";
					location.href="teso-editasinidentificar.php?idrecaudo="+idcta+"#";
				}
			}
			function atrasc()
			{
				if(document.form2.idcomp.value>1)
				{
					document.form2.idcomp.value=document.form2.idcomp.value-1;
					var idcta=document.form2.idcomp.value;
					location.href="teso-editasinidentificar.php?idrecaudo="+idcta+"#";
				}
			}
			function iratras()
			{
				var idcta=document.getElementById('idcomp').value;
				location.href="teso-buscasinidentificar.php?idcta="+idcta;
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
		  			<a href="teso-sinidentificar.php" class="mgbt"><img src="imagenes/add.png" alt="Nuevo"  border="0" title="Nuevo"/></a> 
		  			<a class="mgbt" onClick="guardar();"><img src="imagenes/guarda.png"  alt="Guardar" title="Guardar"/></a>
		  			<a href="teso-buscasinidentificar.php" class="mgbt"><img src="imagenes/busca.png"  alt="Buscar" title="Buscar"/></a> 
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
		  			<a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana" title="Nueva ventana"></a> 
		  			<a href="#" onClick="pdf()" class="mgbt" ><img src="imagenes/print.png"  alt="Buscar" title="Imprimir"/></a>
		  			<a href="#" onClick="iratras()" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
		  		</td>
			</tr>		  
		</table>
			<tr>
				<td colspan="3" class="tablaprin" align="center"> 
					<?php
						$linkbd=conectar_bd();
						$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
						$vigencia=$vigusu;
						$_POST[vigencia]=$vigencia;
						$sqlr="select valor_inicial,descripcion_valor from dominios where nombre_dominio='INGRESOS_IDENTIFICAR'";
						$res=mysql_query($sqlr,$linkbd);
						while ($row =mysql_fetch_row($res)) 
						{
						 	$_POST[codingreso]=$row[0];
						 	$_POST[ningreso]=$row[1];
						}
					?>	
					<?php
						if(!$_POST[oculto])
						{

							$sqlr="select max(id_recaudo) from  tesosinidentificar";
							$res=mysql_query($sqlr,$linkbd);
							$r=mysql_fetch_row($res);
				 			$_POST[maximo]=$r[0];
						}
						//*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
						if(!$_POST[oculto])
						{
							$check1="checked";
							$fec=date("d/m/Y");
							$_POST[vigencia]=$vigencia;

							$sqlr="select *from cuentacaja where estado='S' and vigencia=".$vigusu;
							$res=mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($res)) 
							{
							 $_POST[cuentacaja]=$row[1];
							}
							if(!$_POST[oculto])
							{
								$linkbd=conectar_bd();
								$sqlr="select distinct *from tesosinidentificar, tesosinidentificar_det   where	  tesosinidentificar.id_recaudo=$_GET[idrecaudo]  AND tesosinidentificar.ID_recaudo=tesosinidentificar_det.ID_recaudo and tesosinidentificar_det.id_recaudo=$_GET[idrecaudo]";
								$res=mysql_query($sqlr,$linkbd);
								$cont=0;
								$_POST[idcomp]=$_GET[idrecaudo];
								$total=0;
								while ($row =mysql_fetch_row($res)) 
								{	
									$p1=substr($row[2],0,4);
									$p2=substr($row[2],5,2);
									$p3=substr($row[2],8,2);
									$_POST[fecha]=$p3."/".$p2."/".$p1;
									$_POST[cc]=$row[8];
									$_POST[dcoding][$cont]=$row[14];
									$_POST[cb]=$row[5];
									$_POST[dncoding][$cont]=buscaingreso($row[15]);
									$_POST[tercero]=$row[7];
									$_POST[ntercero]=buscatercero($row[7]);
									$_POST[concepto]=$row[6];
									$total=$total+$row[16]; 
									$_POST[totalc]=$total;
									$_POST[dvalores][$cont]=$row[16];
									$_POST[estadoI] = $row[10];
									$cont=$cont+1;
									$sqlcu="select TB1.razonsocial,TB3.nombre,TB2.cuenta,TB2.ncuentaban,TB2.tipo,TB2.tercero from terceros TB1,tesobancosctas TB2,cuentasnicsp TB3 where TB2.tercero=TB1.cedulanit and TB2.estado='S'  AND TB3.cuenta=TB2.cuenta AND TB2.ncuentaban='$row[5]'";
									$rescu = mysql_query($sqlcu,$linkbd);
									$rowcu =mysql_fetch_row($rescu);
									$_POST[nbanco]=$rowcu[1];
									$_POST[banco]=$rowcu[2];
									$_POST[ter]=$rowcu[5];
									
								}
								$sqlr="SELECT estado FROM `tesosinidentificar` WHERE id_recaudo=$_GET[idrecaudo]";
								$res=mysql_query($sqlr,$linkbd);		
								$row =mysql_fetch_row($res);
								if($row[0]!="R")
								{
									$_POST[estado]="ACTIVO";
									$_POST[tipomovimiento]=201;
									$_POST[estadoc]="#0CD02A";
								}
								else
								{
									$_POST[tipomovimiento]=401;
									$_POST[estado]="REVERSADO";
									$_POST[estadoc]="#FF0000";
								}
							}
						}
						switch($_POST[tabgroup1])
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
						if(!$_POST[oculto])
						{
							$sqlrCompt = "SELECT * FROM tesoidentidicadoscont WHERE id_identificado = '$_POST[idcomp]'";
							$rowComp = view($sqlrCompt);
							if($rowComp[0]['comprobante'])
							{
								$_POST[identificar] = 'identificado';
								$_POST[compManual] = $rowComp[0]['comprobante'];
							}
							elseif($_POST[estadoI]=='I' && !$rowComp[0]['comprobante'])
							{
								$_POST[compManual] = 'Con comprobante';
							}
							else
							{
								$_POST[identificar] = 'porIdentificar';
							}
						}
						
					?>
					<div id="bgventanamodalm" class="bgventanamodalm">
						<div id="ventanamodalm" class="ventanamodalm">
							<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
							</IFRAME>
						</div>
					</div>
					<form name="form2" id="form2" method="post" action=""> 
					 	<?php
					 	//***** busca tercero
							if($_POST[bt]=='1')
							{
							  	$nresul=buscatercero($_POST[tercero]);
							  	if($nresul!='')
							   	{
							  		$_POST[ntercero]=$nresul;
					  			}
							 	else
							 	{
							  		$_POST[ntercero]="";
							  	}
							}
							//******** busca ingreso *****
							//***** busca tercero
							if($_POST[bin]=='1')
							{
								$nresul=buscaingreso($_POST[codingreso]);
								if($nresul!='')
								{
								 	$_POST[ningreso]=$nresul;
					  			}
								else
								{
								  	$_POST[ningreso]="";
								}
							}
								 
					 	?>
					 	<table class="inicio" align="center" >
					     	<tr>
						        <td style="width:95%;" class="titulos" colspan="2">Ingresos Sin Identificar</td>
						        <td style="width:5%;" class="cerrar"><a href="teso-principal.php">Cerrar</a></td>
					      	</tr>
					      	<tr>
					      		<td style="width:80%;">
					      			<table>
					      				<tr>
									        <td style="width:15%; " class="saludo1">Numero Ingreso:</td>
									        <td style="width:20%;">
									        	<a href="#" onClick="atrasc()"><img src="imagenes/back.png" title="anterior" align="absmiddle"></a>
									        	<input name="idcomp" id="idcomp" type="text" value="<?php echo $_POST[idcomp]?>" style="width:70%;"onKeyUp="return tabular(event,this) "  readonly>
									        	<a href="#" onClick="adelante()"><img src="imagenes/next.png" title="siguiente" align="absmiddle"></a> 
									        	<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo">
									        </td>
									  		<td style="width:10%; " class="saludo1">Fecha:</td>
								        	<td style="width:20%;">
								        		<input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" style="width:60%;" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" readonly>
								        		         
								        	</td>
								         	<td style="width:10%;" class="saludo1">Vigencia:</td>
										 	<td style="width:10%;">
										 		<input type="text" id="vigencia" name="vigencia" onKeyPress="javascript:return solonumeros(event)"
										  		onKeyUp="return tabular(event,this)" style="width:40%;" value="<?php echo $_POST[vigencia]?>" onClick="document.getElementById('tipocta').focus();document.getElementById('tipocta').select();" readonly>   
										  	</td>   
										  	<td class="saludo1">Estado:</td>
										  	<td style="width:50%" >
								            	<input type="text" name="estado" value="<?php echo $_POST[estado] ?>" style="width:40%; background-color:<?php echo $_POST[estadoc] ?>; color:white; text-align:center;"  readonly>  
								                <input type="hidden" name="estadoc" value="<?php echo $_POST[estadoc] ?>">
												<select name="tipomov" id="tipomov" style="width:50%;" onKeyUp="return tabular(event,this)" onChange="validar()" style="float:right">
												<?php
													$codMovimiento='201';
													if(isset($_POST['tipomov']))
													{
														if(!empty($_POST['tipomov'])){$codMovimiento=$_POST['tipomov'];}
													}
													$sql="SELECT tipo_mov FROM tesosinidentificar where id_recaudo=$_POST[idcomp]  ORDER BY tipo_mov";
													$resultMov=mysql_query($sql,$linkbd);
													$movimientos=Array();
													$movimientos["201"]["nombre"]="201-Documento de Creacion";
													$movimientos["201"]["estado"]="";
													$movimientos["401"]["nombre"]="401-Reversion Total";
													$movimientos["401"]["estado"]="";
													$movimientos["402"]["nombre"]="402-Reversion Parcial";
													$movimientos["402"]["estado"]="";
													while($row = mysql_fetch_row($resultMov))
													{
														$mov=$movimientos[$row[0]]["nombre"];
														$movimientos[$codMovimiento]["estado"]="selected";
														$state=$movimientos[$row[0]]["estado"];
														echo "<option value='$row[0]' $state>$mov</option>";
													}
													$movimientos[$codMovimiento]["estado"]="";
												?>        
												</select>
												<input name="estado" type="hidden" id="estado" value="<?php echo $_POST[estado] ?>" >
												<input name="tipomovimiento" type="hidden" id="tipomovimiento" value="<?php echo $codMovimiento; ?>" >
											</td> 
								        </tr>
								        <tr>
												<td class='tamano01'>Cuenta :</td>
												<td><input type='text' name='cb' id='cb' value='<?php echo @ $_POST['cb'];?>' style='width:100%;' onDblClick="despliegamodal2('visible','1');" title='Doble Click: Listado Cuentas Bancarias'/></td>
												<td colspan='5'><input type='text' id='nbanco' name='nbanco' style='width:100%;' value='<?php echo @ $_POST['nbanco'];?>' readonly></td>
													<input type='hidden' name='banco' id='banco' value='<?php echo @ $_POST['banco'];?>'/>
												<input type="hidden" id="ter" name="ter" value="<?php echo $_POST[ter]?>" >
								        </tr>
								      	<tr>
									        <td  class="saludo1">Concepto Recaudo:</td>
									        <td colspan="7" >
									        	<input name="concepto" type="text" value="<?php echo $_POST[concepto]?>" style="width:100%;"  onKeyUp="return tabular(event,this)" readonly>
									        </td>
									    </tr>  
								      	<tr>
									        <td  class="saludo1">NIT: </td>
									        <td >
									        	<input name="tercero" type="text" value="<?php echo $_POST[tercero]?>"  onKeyUp="return tabular(event,this)" onBlur="buscater(event)" readonly>
									        	
									        </td>
											<td class="saludo1">Contribuyente:</td>
									  		<td colspan="5" style="width:25%;">
									  			<input type="text" id="ntercero" name="ntercero" value="<?php echo $_POST[ntercero]?>" style="width:100%" onKeyUp="return tabular(event,this) "  readonly>
									  			<input type="hidden" value="0" name="bt">
									  			<input type="hidden" id="ct" name="ct" value="<?php echo $_POST[ct]?>" >
									  			<input type="hidden" value="1" name="oculto" id="oculto">
									  		</td>
									  		
									 	</tr>
									  	<tr>
									  		<td class="saludo1">Ingreso:</td>
									  		<td style="width:60%;" colspan="3">
									  			<input type="text" id="codingreso" name="codingreso" value="<?php echo $_POST[codingreso]?>" style="width:14%;"  onKeyUp="return tabular(event,this)" onBlur="buscaing(event)" readonly > 
											    <input type="hidden" value="0" name="bin" >
											    <input name="ningreso" type="text" id="ningreso" value="<?php echo $_POST[ningreso]?>" style="width:85%;" readonly>
									    	</td>
									    	<td class="saludo1">Centro Costo:</td>
									  		<td colspan="4">
												<select name="cc"  onChange="validar()" onKeyUp="return tabular(event,this)">
												<?php
													$linkbd=conectar_bd();
													$sqlr="select *from centrocosto where estado='S'";
													$res=mysql_query($sqlr,$linkbd);
													while ($row =mysql_fetch_row($res)) 
													{
														echo "<option value=$row[0] ";
														$i=$row[0];
														if($i==$_POST[cc])
														{
															echo "SELECTED";
														}
														echo ">".$row[0]." - ".$row[1]."</option>";	 	 
													}	 	
												?>
											   </select>
											</td>
											
											
											
								        </tr>
										<tr>
											<td class="saludo1" style="width:10%">Identificar Manual:</td>
            								<td width="21%"> 
												<select name="identificar" id="identificar" style="width: 95%" onChange='validar()'>
													<option value='identificado' <?php if($_POST[identificar]=='identificado') {echo "SELECTED";} ?>>Identificar Manual</option>
													<option value='porIdentificar' <?php if($_POST[identificar]=='porIdentificar') {echo "SELECTED";} ?>>Por Identificar</option>
												</select>
											</td>
											<?php
												//echo  $_POST[identificar];
												if($_POST[identificar]=='porIdentificar' || $_POST[compManual]=='Con comprobante')
												{
													$readIdentificado = 'readonly';
												}
												else
												{
													$readIdentificado = '';
												}
											?>
											<td class="saludo1" style="width:10%">No comprobante:</td>
											<td>
												<input name="compManual" type="text" id="compManual" value="<?php echo $_POST[compManual]?>" style="width:85%;" <?php echo $readIdentificado ?>>
											</td>
											<?php
												if($readIdentificado=='')
												{
													?>
													<td colspan="3"><em class="botonflecha" onClick="guardar1()">Guardar indentificacion manual</em></td>
													<?php 
												}
											?>
										</tr>
					      			</table>
					      		</td>
					      		<td  colspan="2" style="width:20%; background:url(imagenes/siglas.png); background-repeat:no-repeat; background-position:right; background-size: 100% 100%;" ></td> 
					      	</tr>
					</table>
					     <?php
					        //***** busca tercero
							if($_POST[bt]=='1')
							{
								$nresul=buscatercero($_POST[tercero]);
								if($nresul!='')
								{
								  	$_POST[ntercero]=$nresul;
					  	?>
						<script>document.getElementById('codingreso').focus();document.getElementById('codingreso').select();</script>
						<?php
								}
								else
								{
								  	$_POST[ntercero]="";
						?>
						<script>
							alert("Tercero Incorrecto o no Existe")				   		  	
							document.form2.tercero.focus();	
						</script>
						<?php
								}
							}
								 //*** ingreso
							if($_POST[bin]=='1')
							{
								$nresul=buscaingreso($_POST[codingreso]);
								if($nresul!='')
								{
								  	$_POST[ningreso]=$nresul;
					  	?>
						<script>document.getElementById('valor').focus();document.getElementById('valor').select();</script>
						<?php
								}
								else
								{
								  	$_POST[codingreso]="";
						?>
						<script>alert("Codigo Ingresos Incorrecto");document.form2.codingreso.focus();</script>
						<?php
								}
							}
						?>
					      
					    <div class="subpantalla">
						   	<table class="inicio">
						   	   	<tr>
					   	      		<td colspan="4" class="titulos">Detalle Sin Identificar</td>
					   	      	</tr>                  
								<tr>
									<td class="titulos2">Codigo</td>
									<td class="titulos2">Ingreso</td>
									<td class="titulos2">Valor</td>
									<td class="titulos2">
										<img src="imagenes/del.png" >
										<input type='hidden' name='elimina' id='elimina'>
									</td>
								</tr>
								<?php 		
									if ($_POST[elimina]!='')
								 	{ 
								 		//echo "<TR><TD>ENTROS :".$_POST[elimina]."</TD></TR>";
								 		$posi=$_POST[elimina];
								  
								 		unset($_POST[dcoding][$posi]);	
								 		unset($_POST[dncoding][$posi]);			 
										unset($_POST[dvalores][$posi]);			  		 
										$_POST[dcoding]= array_values($_POST[dcoding]); 		 
										$_POST[dncoding]= array_values($_POST[dncoding]); 		 		 
										$_POST[dvalores]= array_values($_POST[dvalores]); 		 		 		 		 		 
								 	}	 
								 	if ($_POST[agregadet]=='1' )
								 	{
								 		$_POST[dcoding][]=$_POST[codingreso];
								 		$_POST[dncoding][]=$_POST[ningreso];			 		
								  		$_POST[dvalores][]=$_POST[valor];
								 		$_POST[agregadet]=0;
								  	?>
									<script>
									  	//document.form2.cuenta.focus();	
										document.form2.valor.value="";	
										document.form2.valor.select();
									  	document.form2.valor.focus();	
									</script>
							         
					         		<?php
							  		}
									$_POST[totalc]=0;
									unset($_POST[dcoding]);
									unset($_POST[dncoding]);
									unset($_POST[dvalores]);
									$sqlr = "SELECT ingreso, valor FROM tesosinidentificar_det WHERE id_recaudo='$_POST[idcomp]' AND tipo_mov='$_POST[tipomovimiento]'";
									$res=mysql_query($sqlr,$linkbd);
									while ($row =mysql_fetch_row($res)) 
									{
										$_POST[dcoding][]=$row[0];
										$_POST[dncoding][]=buscaingreso($row[0]);			 		
										$_POST[dvalores][]=$row[1];
									}
									for ($x=0;$x<count($_POST[dcoding]);$x++)
									{		 
									 	echo "<tr>
									 			<td class='saludo1' style='width:8%;'>
									 				<input name='dcoding[]' value='".$_POST[dcoding][$x]."' type='text' style='width:100%;' readonly>
									 			</td>
									 			<td class='saludo1' style='width:70%;'>
									 				<input name='dncoding[]' value='".$_POST[dncoding][$x]."' type='text' style='width:100%;' readonly>
									 			</td>
									 			<td class='saludo1' style='width:20%;'>
									 				<input name='dvalores[]' value='".$_POST[dvalores][$x]."' type='text' style='width:100%;' readonly>
									 			</td>
									 			
									 		</tr>";
									 	$_POST[totalc]=$_POST[totalc]+$_POST[dvalores][$x];
									 	$_POST[totalcf]=number_format($_POST[totalc],2);
									}
					 				$resultado = convertir($_POST[totalc]);
									$_POST[letras]=$resultado." Pesos";
							 		echo "<tr>
							 				<td></td>
							 				<td class='saludo2'>Total</td>
							 				<td class='saludo1'>
							 					<input name='totalcf' type='text' style='width:100%;' value='$_POST[totalcf]' readonly>
							 					<input name='totalc' type='hidden' value='$_POST[totalc]'>
							 				</td>
							 			</tr>
							 			<tr>
							 				<td class='saludo1'>Son:</td>
							 				<td >
							 					<input name='letras' type='text' value='$_POST[letras]' style='width:100%;' readonly>
							 				</td>
							 			</tr>";
								?> 
						   	</table>
						</div>
						<?php 
							if($_POST[oculto]=='3')
							{
								$sqlrU = "UPDATE tesosinidentificar SET estado='I' WHERE id_recaudo='$_POST[idcomp]'";
								view($sqlrU);
								$sqlrCompr = "SELECT * FROM tesoidentidicadoscont WHERE id_identificado='$_POST[idcomp]'";
								$rowCompr = view($sqlrCompr);
								//var_dump($sqlrCompr);
								if($rowCompr[0]['id_identificado'])
								{
									$sqlrG = "UPDATE tesoidentidicadoscont SET comprobante='$_POST[compManual]' WHERE id_identificado='$_POST[idcomp]'";
									view($sqlrG);
									echo "<script>despliegamodalm('visible','1','Se ha Actualizado el Comprobante Manual por identificar con Exito');</script>";
								}
								else
								{
									$sqlrG = "INSERT INTO tesoidentidicadoscont(id_identificado,comprobante) VALUES ('$_POST[idcomp]','$_POST[compManual]')";
									view($sqlrG);
									echo "<script>despliegamodalm('visible','1','Se ha Almacendao el Comprobante Manual por identificar con Exito');</script>";
								}
							}
							if($_POST[oculto]=='2')
							{
								$linkbd=conectar_bd();
							 	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
								$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
								//*********************CREACION DEL COMPROBANTE CONTABLE ***************************
								$sqlr="delete from comprobante_cab where numerotipo='$_POST[idcomp]' and tipo_comp='27'";
								mysql_query($sqlr,$linkbd);
								//***busca el consecutivo del comprobante contable
								$consec=$_POST[idcomp];	
								//***cabecera comprobante
								$sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($consec,27,'$fechaf','".strtoupper($_POST[concepto])."',0,$_POST[totalc],$_POST[totalc],0,'1')";
								mysql_query($sqlr,$linkbd);	
								$idcomp=mysql_insert_id();
								$sqlr="delete from comprobante_det where id_comp='27 $_POST[idcomp]'";
								mysql_query($sqlr,$linkbd);
								
								echo "<input type='hidden' name='ncomp' value='$consec'>";
								//******************* DETALLE DEL COMPROBANTE CONTABLE *********************
								for($x=0;$x<count($_POST[dcoding]);$x++)
								{
									 //***** BUSQUEDA INGRESO ********
									$sqlri="Select * from tesoingresos_det where codigo='".$_POST[dcoding][$x]."' and vigencia=$vigusu";
								 	$resi=mysql_query($sqlri,$linkbd);
									//	echo "$sqlri <br>";	    
									while($rowi=mysql_fetch_row($resi))
									{
								    	//**** busqueda concepto contable*****
										$sq="select fechainicial from conceptoscontables_det where codigo=".$rowi[2]." and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
										$re=mysql_query($sq,$linkbd);
										while($ro=mysql_fetch_assoc($re))
										{
											$_POST[fechacausa]=$ro["fechainicial"];
										}
									 	$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo=".$rowi[2]." and tipo='C' and fechainicial='".$_POST[fechacausa]."'";
								 	 	$resc=mysql_query($sqlrc,$linkbd);	  
									 	//	echo "con: $sqlrc <br>";	      
										while($rowc=mysql_fetch_row($resc))
									 	{
										  	$porce=$rowi[5];	
										 	if($_POST[cc]==$rowc[5])
										 	{
												if($rowc[7]=='S')
										  		{			
										  			$valorcred=$_POST[dvalores][$x]*($porce/100);
													//echo "-Valor:".$_POST[dvalores][$x];
													$valordeb=0;
													$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values ('27 $consec','".$rowc[4]."','".$_POST[tercero]."','".$_POST[cc]."','Recaudo Transferencia".strtoupper($_POST[dncoding][$x])."','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."','27','$consec')";
													mysql_query($sqlr,$linkbd);
													//echo "<br>".$sqlr;
										  			$valordeb=$_POST[dvalores][$x]*($porce/100);
													$valorcred=0;				   
													$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values ('27 $consec','".$_POST[banco]."','".$_POST[tercero]."','".$_POST[cc]."','Recaudo Transferencia".strtoupper($_POST[dncoding][$x])."','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."','27','$consec')";
													mysql_query($sqlr,$linkbd);
													$vi=$_POST[dvalores][$x]*($porce/100);
												}	
														   
										 	}
										//echo "Conc: $sqlr <br>";
									 	}
									}
								}	
								//************ insercion de cabecera recaudos ************

								
								
								$sqlr="delete from tesosinidentificar_det where id_recaudo='$consec'";
								mysql_query($sqlr,$linkbd);

								$sqlr="UPDATE tesosinidentificar SET banco='".$_POST['ter']."',ncuentaban='".$_POST['cb']."' WHERE id_recaudo='$consec'";
								//$sqlr="insert into tesosinidentificar (id_recaudo,idcomp,fecha,vigencia,banco,ncuentaban,concepto,tercero,cc,valortotal,estado) values($consec,$idcomp,'$fechaf',".$vigusu.",'$_POST[ter]','$_POST[cb]','".strtoupper($_POST[concepto])."','$_POST[tercero]','$_POST[cc]','$_POST[totalc]','S')";
								mysql_query($sqlr,$linkbd);
								$idrec=mysql_insert_id();
								//echo "Conc: $sqlr <br>";
								//************** insercion de consignaciones **************
								for($x=0;$x<count($_POST[dcoding]);$x++)
								{
									if ($_POST['tipomovimiento']=='201') {$estaw='S';}
									else {$estaw='R';}
									$sqlr="insert into tesosinidentificar_det (id_recaudo,ingreso,valor,estado,tipo_mov) values($consec,'".$_POST[dcoding][$x]."',".$_POST[dvalores][$x].",'$estaw','".$_POST['tipomovimiento']."')";
									if (!mysql_query($sqlr,$linkbd))
									{
									 	echo "<table ><tr><td class='saludo1'><center><font color=blue><img src='imagenes/alert.png'> Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petici�n: <br><font color=red><b>$sqlr</b></font></p>";
								//	 	$e =mysql_error($respquery);
									 	echo "Ocurri� el siguiente problema:<br>";
								  	 	//echo htmlentities($e['message']);
								  	 	echo "<pre>";
								     	///echo htmlentities($e['sqltext']);
								    	// printf("\n%".($e['offset']+1)."s", "^");
								     	echo "</pre></center></td></tr></table>";
									}
							  		else
							  		{
									  	echo "<table  class='inicio'><tr><td class='saludo1'><center>Se ha almacenado el Recaudo con Exito <img src='imagenes/confirm.png'></center></td></tr></table>";
						?>
						<script>
							document.form2.numero.value='';
							document.form2.valor.value=0;
						</script>
						<?php
									}
								}	 
							}
						?>	
					</form>
				</td>
			</tr>
		</table>
		<div id="bgventanamodal2">
				<div id="ventanamodal2">
					<IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
					</IFRAME>
				</div>
			</div>
	</body>
</html> 		