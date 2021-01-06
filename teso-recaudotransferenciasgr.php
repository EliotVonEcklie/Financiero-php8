<?php
require "comun.inc";
require "funciones.inc";
require "conversor.php";
session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html" />
	<meta http-equiv="X-UA-Compatible" content="IE=9" />
	<title>:: SPID - Tesoreria</title>

	<script>
		//************* ver reporte ************
		//***************************************
		function verep(idfac)
		{
			document.form1.oculto.value=idfac;
			document.form1.submit();
		}

		function genrep(idfac)
		{
			document.form2.oculto.value=idfac;
			document.form2.submit();
		}

		function buscacta(e)
		{
			if (document.form2.cuenta.value!="")
			{
				document.form2.bc.value='1';
				document.form2.submit();
			}
		}
	</script>
	<script language="JavaScript1.2">
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
			if(document.form2.codingreso.value!="" &&  document.form2.valor.value>0   && document.form2.tiporet.value!='')
			{ 
				document.form2.agregadet.value=1;
				//document.form2.chacuerdo.value=2;
				document.form2.submit();
			}
			else 
			{
				despliegamodalm('visible','2','Falta informacion para poder Agregar');
			}
		}

		function agregardetalled()
		{
			if(document.form2.retencion.value!="" &&  document.form2.vporcentaje.value!="")
			{ 
				document.form2.agregadetdes.value=1;
				document.form2.submit();
			}
			else {despliegamodalm('visible','2','Falta informacion para poder Agregar');}
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

		function eliminard(variable)
		{
			if (confirm("Esta Seguro de Eliminar"))
			{
				document.form2.eliminad.value=variable;
				vvend=document.getElementById('eliminad');
				vvend.value=variable;
				document.form2.submit();
			}
		}

		//************* genera reporte ************
		//***************************************
		function guardar()
		{
			if(document.form2.tipomovimiento.value=='101')
			{
				ingresos2 = document.form2.codingreso.value;
				banco = document.form2.nbanco.value;
				destino = document.form2.tiporet.value;
				if(destino == 'M')
				{
					retencionIngresos = document.getElementsByName('dndescuentos[]');
					if(retencionIngresos.length > 0)
					{
						totalRecaudo = document.form2.totalcf.value;
						totalRetenciones = document.form2.totaldes.value;
						totalRecaudo = totalRecaudo.replace(",","");
						totalRecaudo = totalRecaudo.replace(",","");
						totalRecaudo = totalRecaudo.replace(",","");
						totalRecaudo = totalRecaudo.replace(",","");
						
						if(parseInt(totalRecaudo) == parseInt(totalRetenciones))
						{
							if (document.form2.fecha.value!='' && document.form2.concepto.value!='' && ingresos2!='' && banco!='')
							{
								despliegamodalm('visible','4','Esta Seguro de Guardar','1');
							}
							else
							{
								despliegamodalm('visible','2','Faltan datos para completar el registro');
								document.form2.fecha.focus();
								document.form2.fecha.select();
							}
						}
						else
						{
							despliegamodalm('visible','2','El valor del recaudo y el total de retenciones ingresos no coinciden.');
							document.form2.fecha.focus();
							document.form2.fecha.select();
						}
					}
					else
					{
						despliegamodalm('visible','2','Faltan agregar retencion ingresos propios');
						document.form2.fecha.focus();
						document.form2.fecha.select();
					}
				}
				else
				{
					if (document.form2.fecha.value!='' && document.form2.concepto.value!='' && ingresos2!='' && banco!='')
					{
						despliegamodalm('visible','4','Esta Seguro de Guardar','1');
					}
					else
					{
						despliegamodalm('visible','2','Faltan datos para completar el registro');
						document.form2.fecha.focus();
						document.form2.fecha.select();
					}
				}
			}
			else
			{
				numeroDeRecaudoAReversar = document.form2.ncomp.value;
				descripcionDeReversion = document.form2.descripcion.value;
				if (numeroDeRecaudoAReversar!='' && descripcionDeReversion!='')
				{
					despliegamodalm('visible','4','Esta Seguro de Guardar','1');
				}
				else
				{
					despliegamodalm('visible','2','Faltan datos para completar el registro');
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
			location.href="teso-editarecaudotransferenciasgr.php?idrecaudo="+document.form2.idcomp.value;
		}
		function respuestaconsulta(pregunta)
		{
			switch(pregunta)
			{
				case "1":	
					document.form2.oculto.value='2';
					document.form2.submit();break;
			}
		}

		function pdf()
		{
			document.form2.action="teso-pdfrecaudostrans.php";
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
					case '1':	document.getElementById('ventana2').src="cuentasbancarias-ventana02.php?tipoc=D&obj01=banco&obj02=nbanco&obj03=&obj04=cb&obj05=ter";break;
					case '2':	document.getElementById('ventana2').src="ventana-recaudosgrreversar.php";break;
					case '3':	document.getElementById('ventana2').src="ingresosgral-ventana02.php?objeto=codingreso&nobjeto=ningreso";break;
					case '4': document.getElementById('ventana2').src="tercerosgral-ventana01.php?objeto=tercero&nobjeto=ntercero&nfoco=codingreso";break;
				}
			}
		}

		function respuestamensaje()
		{
			if(document.form2.tipomovimiento.value=='101')
			{
				location.href="teso-editarecaudotransferenciasgr.php?idrecaudo="+document.form2.idcomp.value;

			}
			else
			{
				location.href="teso-editarecaudotransferenciasgr.php?idrecaudo="+document.form2.ncomp.value;

			}
		}


		function validafinalizar(e)
		{
			var id=e.id;
			var check=e.checked;
			if(id=='retencionesPropias')
			{
				document.getElementById('retencionesPropias').value=1;
			}
			else
			{
				document.form2.retencionesPropias.checked=false;
			}
			document.form2.submit();
		}
	</script>
	<script src="css/programas.js"></script>
	<script src="css/calendario.js"></script>
	<link href="css/css2.css" rel="stylesheet" type="text/css" />
	<link href="css/css3.css" rel="stylesheet" type="text/css" />
	<link href="css/tabs.css" rel="stylesheet" type="text/css" />
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
				<a href="teso-recaudotransferenciasgr.php" class="mgbt" ><img src="imagenes/add.png" alt="Nuevo"  border="0" /></a>  
				<a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png"  alt="Guardar" /></a>  
				<a href="teso-buscarecaudotransferenciasgr.php" class="mgbt"> <img src="imagenes/busca.png"  alt="Buscar" /></a> 
				<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
				<a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana"></a>  
				<a href="#" <?php if($_POST[oculto]==2) { ?> onClick="pdf()"  <?php } ?> class="mgbt"> <img src="imagenes/print.png"  alt="Buscar" /></a>
			</td>
		</tr>		  
	</table>
	<div id="bgventanamodalm" class="bgventanamodalm">
		<div id="ventanamodalm" class="ventanamodalm">
			<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; "> 
			</IFRAME>
		</div>
	</div>
	<tr>
	<td colspan="3" class="tablaprin" align="center"> 
	<?php
	$linkbd=conectar_bd();
	$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
	$vigencia=$vigusu;
		$_POST[vigencia]=$vigencia;
	?>	
	<?php
	//*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
	if(!$_POST[oculto])
	{
		$_POST[tipomovimiento]="101";
		$check1="checked";
		$fec=date("d/m/Y");
		$_POST[vigencia]=$vigencia;

		$sqlr="select valor_inicial from dominios where nombre_dominio='CUENTA_CAJA'";
		$res=mysql_query($sqlr,$linkbd);
		while ($row =mysql_fetch_row($res)) 
		{
	 		$_POST[cuentacaja]=$row[0];
		}
		/*$sqlr="select max(numerotipo) from comprobante_cab where tipo_comp='2' and EXTRACT(YEAR FROM fecha)=".$_SESSION["vigencia"];
		$res=mysql_query($sqlr,$linkbd);
		$consec=0;
		while($r=mysql_fetch_row($res))
		{
		$consec=$r[0];	  
		}
		$consec+=1;*/
	 	
 		$fec=date("d/m/Y");
		$_POST[fecha]=$fec; 		 		  			 
		$_POST[valor]=0;		 
	}
	if(!$_POST[tabgroup1])
	{
		$check1='checked';
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
	}/*
    $_POST[dcoding]= array(); 		 
    $_POST[dncoding]= array(); 		 
    $_POST[dvalores]= array();*/

	if($_POST[tipomovimiento] == '101')
	{
		$sqlr="select max(id_recaudo) from tesorecaudotransferenciasgr ";
		$res=mysql_query($sqlr,$linkbd);
		$consec=0;
		while($r=mysql_fetch_row($res))
	 	{
	  		$consec=$r[0];	  
	 	}
	 	$consec+=1;
	 	$_POST[idcomp]=$consec;	
	}
	?>
 	<form name="form2" method="post" action=""> 
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

	if($_POST[oculto]=='3')
	{
		$_POST[dcoding]= array(); 		 
		$_POST[dncoding]= array(); 		 
		$_POST[dvalores]= array();
		$sqlr = "SELECT ingreso, valor FROM tesorecaudotransferenciasgr_det WHERE id_recaudo='$_POST[ncomp]'";
		$res = mysql_query($sqlr, $linkbd);
		while($row = mysql_fetch_row($res))
		{
			$_POST[dcoding][]=$row[0];
			$_POST[dncoding][]=buscaingreso($row[0]);			 		
			$_POST[dvalores][]=$row[1];
		}
	}

 	?>
	<table class="inicio">
		<tr>
			<td class="titulos" style="width:100%;">.: Tipo de Movimiento 
				<select name="tipomovimiento" id="tipomovimiento" onKeyUp="return tabular(event,this)" onChange="document.form2.submit();" style="width:20%;" >
					<?php 
						$user=$_SESSION[cedulausu];
						$sql="SELECT * from permisos_movimientos WHERE usuario='$user' AND estado='T' ";
						$res=mysql_query($sql,$linkbd);
						$num=mysql_num_rows($res);
						if($num==1)
						{
							$sqlr="select * from tipo_movdocumentos where estado='S' and modulo=3 AND (id='1' OR id='3')";
							$resp = mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($resp)) 
							{
								if($_POST[tipomovimiento]==$row[0].$row[1])
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
							$sql="SELECT codmov,tipomov from permisos_movimientos WHERE usuario='$user' AND estado='S' AND modulo='3' AND transaccion='PIC' ";
							$res=mysql_query($sql,$linkbd);
							while($row = mysql_fetch_row($res))
							{
								if($_POST[tipomovimiento]==$row[0])
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
			<td style="width:80%;">
			</td>
		</tr>
	</table>
	<input type="hidden" name="oculto" id="oculto" value="1" >
	<?php
	if($_POST[tipomovimiento]=="101")
	{
		?>
		<div class="tabsmeci" style='min-height:31% !important;'>
			<div class="tab">
				<input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
				<label for="tab-1">Recaudo transferencia</label>
				<div class="content" style="overflow-x:hidden;" id="divdet">
					<table class="inicio" align="center" >
						<tr >
							<td class="titulos" style="width:93%;" colspan="3"> Recaudos Transferencias SGR</td>
							<td class="cerrar" style="width:7%;" ><a href="teso-principal.php">Cerrar</a></td>
						</tr>
						<tr>
							<td style="width:80%;">
								<table>
									<tr>
										<td style="width:12%;" class="saludo1" >No Recaudo:</td>
										<td style="width:10%;">
											<input name="idcomp" type="text" value="<?php echo $_POST[idcomp]?>" style="width:70%;" onKeyUp="return tabular(event,this) "  readonly>
										</td>
										<td style="width:5%;" class="saludo1">Fecha:</td>
										<td style="width:15%;">
											<input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" style="width:80%;"> 
											<a href="#" onClick="displayCalendarFor('fc_1198971545');">
												<img src="imagenes/buscarep.png" align="absmiddle" border="0">
											</a>         
										</td>
										<td style="width:12%;" class="saludo1">Vigencia:</td>
										<td style="width:5%;">
											<input type="text" id="vigencia" name="vigencia" style="width:86%;" onKeyPress="javas cript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  value="<?php echo $_POST[vigencia]?>" onClick="document.getElementById('tipocta').focus(); document.getElementById('tipocta').select();" readonly>
										</td>
										<td style="width:10%;" class="saludo1">Destino:</td>
										<td colspan="4" style="width:30%;">
											<select name="tiporet" id="tiporet" onChange="validar()" >
												<option value="" >Seleccione...</option>
												<option value="N" <?php if($_POST[tiporet]=='N') echo "SELECTED"?>>Nacional</option>
												<option value="D" <?php if($_POST[tiporet]=='D') echo "SELECTED"?>>Departamental</option>
												<option value="M" <?php if($_POST[tiporet]=='M') echo "SELECTED"?>>Municipal</option>            
											</select>        
										</td>
									</tr>
									<tr>
										<td style="width:15%;" class="saludo1">Concepto Recaudo:</td>
										<td colspan="3">
											<input name="concepto" type="text" value="<?php echo $_POST[concepto]?>" style="width:100%;" onKeyUp="return tabular(event,this)" >
										</td>
										<td class="saludo1">Fuente de Recurso:</td>
										<td style="width:10%;">
											<input type="text" id="codingreso" name="codingreso" value="<?php echo $_POST[codingreso]?>"  onKeyUp="return tabular(event,this)" onBlur="buscaing(event)" style="width:60%;" readonly>&nbsp;<a onClick="despliegamodal2('visible','3');" title="Listado de Ingresos"><img src="imagenes/find02.png" style="width:20px;cursor:pointer;"/></a>
											<input type="hidden" value="0" name="bin">
										</td> 
										<td colspan="3"><input type="text" name="ningreso" id="ningreso" value="<?php echo $_POST[ningreso]?>" style="width:100%;" readonly></td>
									</tr>
									<tr>
										<td style="width:5%;" class="saludo1">Recaudado:</td>
										<td style="width:15%;">
										<!-- 
											<select id="banco" name="banco"  onChange="validar()" onKeyUp="return tabular(event,this)">
												<option value="">Seleccione....</option>
												<?php
													$linkbd=conectar_bd();
													$sqlr="select tesobancosctas.estado, tesobancosctas.cuenta, tesobancosctas.ncuentaban, tesobancosctas.tipo, terceros.razonsocial, tesobancosctas.tercero from tesobancosctas,terceros where tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.estado='S' ";
													$res=mysql_query($sqlr,$linkbd);
													while ($row =mysql_fetch_row($res)) 
													{
														echo "<option value=$row[1] ";
														$i=$row[1];
														$ncb=buscacuenta($row[1]);
														if($i==$_POST[banco])
														{
															echo "SELECTED";
															$_POST[nbanco]=$row[4];
															$_POST[ter]=$row[5];
															$_POST[cb]=$row[2];
														}
														echo ">".substr($ncb,0,70)." - Cuenta ".$row[3]."</option>";	 	 
													}	 	
												?>
											</select>-->
											<input type="text" name="cb" id="cb" value="<?php echo $_POST[cb]; ?>" style="width:70%;"/>&nbsp;
												<a onClick="despliegamodal2('visible','1');" title="Listado Cuentas Bancarias">	
													<img src='imagenes/find02.png' style="width:20px;cursor:pointer;"/>
												</a>
											<input name="banco" id="banco" type="hidden" value="<?php echo $_POST[banco]?>" >
											<input type="hidden" id="ter" name="ter" value="<?php echo $_POST[ter]?>" >           
										</td>
										<td colspan="4"> 
											<input type="text" id="nbanco" name="nbanco" value="<?php echo $_POST[nbanco]?>" style="width:100%;" readonly>
										</td>
										<td style="width:10%;" class="saludo1">Centro Costo:</td>
											<td colspan="2" style="width:30%;">
											<select name="cc"  onChange="validar()" style="width:100%;" onKeyUp="return tabular(event,this)">
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
										<td  class="saludo1">NIT: </td>
										<td ><input type="text" name="tercero" id="tercero" value="<?php echo $_POST[tercero]?>" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" style="width:70%;"/>&nbsp;
										<a onClick="despliegamodal2('visible','4');" title="Listado Contribuyentes"><img src="imagenes/find02.png" style="width:20px;cursor:pointer;"/></a></td>
										<td class="saludo1">Contribuyente:</td>
										<td colspan="3">
											<input type="text" id="ntercero" name="ntercero" value="<?php echo $_POST[ntercero]?>" onKeyUp="return tabular(event,this)" style="width:100%;" readonly>
											<input type="hidden" value="0" name="bt">
											<input type="hidden" id="cb" name="cb" value="<?php echo $_POST[cb]?>" >
											<input type="hidden" id="ct" name="ct" value="<?php echo $_POST[ct]?>" >
											
										</td>
										<td class="saludo1" >Valor:</td>
										<td style="width:10%;">
											<input type="hidden" id="valor" name="valor" value="<?php echo $_POST[valor]?>"/>
											<input type="text" name="valorvl" id="valorvl" data-a-sign="$" data-a-dec="<?php echo $_SESSION["spdecimal"];?>" data-a-sep="<?php echo $_SESSION["spmillares"];?>" data-v-min='0' onKeyUp="sinpuntitos2('valor','valorvl');return tabular(event,this);" value="<?php echo $_POST[valorvl]; ?>" style='text-align:right;' />
											
										</td>
										<td >
											<input type="button" name="agregact" value="Agregar" onClick="agregardetalle()">
											<input type="hidden" name="agregadet"/>
										</td>
										
									</tr>
									<tr>
								
									</tr>
								</table>
							</td>
							<td colspan="3" style="width:20%; background:url(imagenes/siglas.png); background-repeat:no-repeat; background-position:right; background-size: 100% 100%;" ></td>  
						</tr>
					</table>
				</div>
			</div>
			<div class="tab">
				<input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?> >
				<?php
				if($_POST[tiporet]=='M')
				{
				?>
				<label for="tab-2">Retencion ingresos propios</label>
				<div class="content" style="overflow-x:hidden;" id="divdet">
					<table class="inicio" align="center" >
						<tr >
							<td class="titulos" colspan="8">Retenciones</td>
							<td class="cerrar" style="width:7%;"><a href="teso-principal.php">&nbsp;Cerrar</a></td>
						</tr>
						<tr>
							<td class="saludo1">Detalle:</td>
							<td style="width:30%">
								<input type="text" name="detalleretencion" id="detalleretencion" style="width:100%" value="<?php echo $_POST[detalleretencion] ?>">
							</td>
							<td class="saludo1" style="width:12%">Retencion y Descuento:</td>
							<td>
								<select name="retencion"  onKeyUp="return tabular(event,this)">
									<option value="">Seleccione ...</option>
									<?php
										$sqlr="select *from tesoretenciones where estado='S' and (terceros!='1' or tipo='C') ";
										$res=mysql_query($sqlr,$linkbd);
										while ($row =mysql_fetch_row($res)) 
										{
											if("$row[0]"==$_POST[retencion])
											{
												echo "<option value='$row[0]' SELECTED>$row[1] - $row[2]</option>";
												$_POST[porcentaje]=$row[5];
												$_POST[nretencion]=$row[1]." - ".$row[2];
											}
											else {echo "<option value='$row[0]'>$row[1] - $row[2]</option>";} 	 
										}	 	
									?>
								</select>
								<input type="hidden" value="<?php echo $_POST[nretencion]?>" name="nretencion">
							</td>
							<td class="saludo1">Valor:</td><td><input class='inputnum' id="vporcentaje" name="vporcentaje" type="text" size="10" value="<?php echo $_POST[vporcentaje]?>" ></td>
							<td class="saludo1" style="width:10%">Total Descuentos:</td>
							<td style="width:15%">
								<input class='inputnum' id="totaldes" name="totaldes" type="text" size="10" value="<?php echo $_POST[totaldes]?>" readonly>
								<input type="button" name="agregard" id="agregard" value="   Agregar   " onClick="agregardetalled()" ><input type="hidden" value="0" name="agregadetdes">
							</td>
						</tr>
						<?php 	
							$_POST[valoregreso]=$_POST[valor];
							$_POST[valorretencion]=$_POST[totaldes];
							$_POST[valorcheque]=$_POST[valoregreso]-$_POST[valorretencion];
							if ($_POST[eliminad]!='')
							{ 
								$posi=$_POST[eliminad];
								unset($_POST[ddescuentos][$posi]);
								unset($_POST[dndescuentos][$posi]);
								unset($_POST[ddesvalores][$posi]);
								$_POST[ddescuentos]= array_values($_POST[ddescuentos]); 
								$_POST[dndescuentos]= array_values($_POST[dndescuentos]);
								$_POST[ddesvalores]= array_values($_POST[ddesvalores]); 		 
							}	 
							if ($_POST[agregadetdes]=='1')
							{
								$_POST[ddescuentos][]=$_POST[retencion];
								$_POST[dndescuentos][]=$_POST[nretencion];
								$_POST[ddesvalores][]=$_POST[vporcentaje];
								$_POST[agregadetdes]='0';
								echo"
								<script>
									document.form2.vporcentaje.value=0;	
									document.form2.retencion.value='';	
								</script>";
							}
						?>
						</table>
						<table class="inicio" style="overflow:scroll">
							<tr>
								<td class="titulos">Descuento</td>
								<td class="titulos">Valor</td>
								<td class="titulos2"><img src="imagenes/del.png" ><input type='hidden' name='eliminad' id='eliminad'></td>
							</tr>
							<?php
								$totaldes=0;
								for ($x=0;$x<count($_POST[ddescuentos]);$x++)
								{		 		 
									echo "
									<input type='hidden' name='dndescuentos[]' value='".$_POST[dndescuentos][$x]."'>
									<input type='hidden' name='ddescuentos[]' value='".$_POST[ddescuentos][$x]."' >
									<input type='hidden' name='ddesvalores[]' value='".($_POST[ddesvalores][$x])."'>
									<tr>
										<td class='saludo2'>".$_POST[dndescuentos][$x]."</td>
										<td class='saludo2'>".($_POST[ddesvalores][$x])."</td>
										<td class='saludo2'><a href='#' onclick='eliminard($x)'><img src='imagenes/del.png'></a></td>
									</tr>";
									$totaldes=$totaldes+($_POST[ddesvalores][$x])	;
								}		 
								$_POST[valorretencion]=$totaldes;
								echo"
								<script>
									document.form2.totaldes.value='$totaldes';		
									document.form2.valorretencion.value='$totaldes';
								</script>";
								$_POST[valorcheque]=$_POST[valoregreso]-$_POST[valorretencion];
							?>
						</table>
				</div>
				<?php } ?>
			</div>
		</div>
       	<?php
	}
	else if($_POST[tipomovimiento]=='301')
	{
		?>
		<div class="subpantalla" style="height:110px;" style="overflow-x:hidden; !important">
			<table class="inicio">
				<tr>
					<td class="titulos" colspan="6">.: Reversion de Recaudos Transferencias SGR</td>
				</tr>
				<tr>
					<td style="width:10%;" class="saludo1" >No Recaudo:</td>
					<td style="width:10%">
						<input type="text" name="ncomp" id="ncomp" style="width:80%;" onKeyPress="javascript:return solonumeros(event)" value="<?php echo $_POST[ncomp]?>" onKeyUp="return tabular(event,this) " onBlur="validar2()" readonly >&nbsp;<img src="imagenes/find02.png" style="width:20px;" onClick="despliegamodal2('visible','2');" title="Buscar REGLIAS" class="icobut" />  
					</td>
					<td class="saludo1" style="width:5%;">Fecha:</td>
					<td style="width:10%;">
						<input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" style="width:80%;" title="DD/MM/YYYY"/>&nbsp;<a href="#" onClick="displayCalendarFor('fc_1198971545');" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px;"/></a>
					</td>
					<td class="saludo1" style="width:5%;">Descripcion: </td>
					<td style="width:60%;" colspan="3">
						<input type="text" name="descripcion" id="descripcion" value="<?php echo $_POST[descripcion]?>" style="width:100%;">
					</td>
				</tr>
				<tr>
					<td style="width:10%;" class="saludo1" >Tercero</td>
					<td>
						<input type="text" id="terceroAReversar" name="terceroAReversar" value="<?php echo $_POST[terceroAReversar] ?>" style="width:80%;" readonly>
					</td>
					<td colspan="4">
						<input type="text" id="nombreTerceroAReversar" name="nombreTerceroAReversar" value="<?php echo $_POST[nombreTerceroAReversar] ?>" style="width:100%;" readonly>
					</td>
				</tr>
			</table>
		</div>
		<?php
	}
           //***** busca tercero
			 if($_POST[bt]=='1')
			 {
			  $nresul=buscatercero($_POST[tercero]);
			  if($nresul!='')
			   {
			  $_POST[ntercero]=$nresul;
  				?>
			<script>
			  document.getElementById('codingreso').focus();document.getElementById('codingreso').select();</script>
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
			  <script>
			  document.getElementById('valor').focus();document.getElementById('valor').select();</script>
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
      
     <div class="subpantalla" style='height:40%;'>
	   <table class="inicio">
	   	   <tr>
   	      <td colspan="4" class="titulos">Detalle  Recaudos Transferencia</td></tr>                  
		<tr><td class="titulos2">Codigo</td><td class="titulos2">Ingreso</td><td class="titulos2">Valor</td><td class="titulos2"><img src="imagenes/del.png" ><input type='hidden' name='elimina' id='elimina'></td></tr>
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
		 if ($_POST[agregadet]=='1')
		 {
		 $_POST[dcoding][]=$_POST[codingreso];
		 $_POST[dncoding][]=$_POST[ningreso];			 		
		  $_POST[dvalores][]=$_POST[valor];
		 $_POST[agregadet]=0;
		  ?>
		 <script>
		  		//document.form2.cuenta.focus();	
				//document.form2.codingreso.value="";
				document.form2.valor.value="";
                document.form2.valorvl.value='';
				document.form2.ningreso.value="";
		 </script>
         
         
		  <?php
		  }
		  $_POST[totalc]=0;
		 for ($x=0;$x<count($_POST[dcoding]);$x++)
		 {
		 echo "<tr class='saludo1'>
		 		<td style='width:5%;'>
		 			<input name='dcoding[]' value='".$_POST[dcoding][$x]."' type='text' style='width:100%;' readonly>
		 		</td>
		 		<td style='width:80%;'>
		 			<input name='dncoding[]' value='".$_POST[dncoding][$x]."' type='text' style='width:100%;' readonly>
		 		</td>
		 		<td style='width:15%;'>
		 			<input name='dvalores[]' value='".$_POST[dvalores][$x]."' type='text' style='width:100%;' readonly>
		 		</td>
		 		<td >
		 			<a href='#' onclick='eliminar($x)'>
		 				<img src='imagenes/del.png'>
		 			</a>
		 		</td>
		 	</tr>";
		 $_POST[totalc]=$_POST[totalc]+$_POST[dvalores][$x];
		 $_POST[totalcf]=number_format($_POST[totalc],2);
		 }
 			$resultado = convertir($_POST[totalc]);
			$_POST[letras]=$resultado." Pesos";
		 echo "<tr class='saludo1'>
		 		<td style='width:5%;'>
		 		</td>
		 		<td style='width:80%;'>Total</td>
		 		<td style='width:15%;'>
		 			<input name='totalcf' type='text' value='$_POST[totalcf]' style='width:100%;' readonly>
		 			<input name='totalc' type='hidden' value='$_POST[totalc]'>
		 		</td>
		 	</tr>
		 	<tr>
		 		<td style='width:5%;' class='saludo1'>Son:</td>
		 		<td style='width:80%;'>
		 			<input name='letras' type='text' value='$_POST[letras]' style='width:100%;'>
		 		</td>
		 	</tr>";
		?> 
	   </table></div>
	  <?php
    if($_POST[oculto]=='2')
    {
		if($_POST[tipomovimiento] == '101')
		{
			$sqlr="select count(*) from tesorecaudotransferenciasgr where id_recaudo=$_POST[idcomp]";
			$res=mysql_query($sqlr,$linkbd);
			//echo $sqlr;
			while($r=mysql_fetch_row($res))
			{
				$numerorecaudos=$r[0];
			}
			if($numerorecaudos==0)
			{
				$linkbd=conectar_bd();
				ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
				$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
				//*********************CREACION DEL COMPROBANTE CONTABLE ***************************
				//***busca el consecutivo del comprobante contable
				//************ insercion de cabecera recaudos ************
	
				$sqlr="insert into tesorecaudotransferenciasgr (id_recaudo,fecha,vigencia,banco,ncuentaban,concepto,detalleretencion,tercero,cc,valortotal,estado,tipo_mov,destino) values($_POST[idcomp],'$fechaf','".$_POST[vigencia]."','$_POST[ter]','$_POST[cb]','".strtoupper($_POST[concepto])."','".strtoupper($_POST[detalleretencion])."','$_POST[tercero]','$_POST[cc]','$_POST[totalc]','S','$_POST[tipomovimiento]','$_POST[tiporet]')";
				//echo $sqlr;
				mysql_query($sqlr,$linkbd);
				$idrec=$_POST[idcomp];

				$consec=0;
				
				$consec=$idrec;
				//***cabecera comprobante
				$sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($consec,36,'$fechaf','".strtoupper($_POST[concepto])."',0,$_POST[totalc],$_POST[totalc],0,'1')";
				mysql_query($sqlr,$linkbd);
		
				//******************* DETALLE DEL COMPROBANTE CONTABLE *********************
				//echo count($_POST[dcoding])."v";
				for($x=0;$x<count($_POST[dcoding]);$x++)
				{
					//***** BUSQUEDA INGRESO ********
					$sqlri="Select * from tesoingresos_det where codigo='".$_POST[dcoding][$x]."'  and vigencia=$vigusu";
					$resi=mysql_query($sqlri,$linkbd);
					while($rowi=mysql_fetch_row($resi))
					{
						//**** busqueda concepto contable*****
						$sq="select fechainicial from conceptoscontables_det where codigo='".$rowi[2]."' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
						$re=mysql_query($sq,$linkbd);
						while($ro=mysql_fetch_assoc($re))
						{
							$_POST[fechacausa]=$ro["fechainicial"];
						}
						$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo=".$rowi[2]." and tipo='C' and fechainicial='".$_POST[fechacausa]."'";
						$resc=mysql_query($sqlrc,$linkbd);
						while($rowc=mysql_fetch_row($resc))
						{
							$porce=$rowi[5];
							if($_POST[cc]==$rowc[5])
							{
								if($rowc[6]=='S')
								{
									$valorcred=$_POST[dvalores][$x];
									$valordeb=0;
									$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('36 $consec','".$rowc[4]."','".$_POST[tercero]."','".$_POST[cc]."','Recaudo Transferencia".strtoupper($_POST[dncoding][$x])."','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
									mysql_query($sqlr,$linkbd);
									$valordeb=$_POST[dvalores][$x];
									$valorcred=0;
									$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('36 $consec','".$_POST[banco]."','".$_POST[tercero]."','".$_POST[cc]."','Recaudo Transferencia".strtoupper($_POST[dncoding][$x])."','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
									mysql_query($sqlr,$linkbd);
								}
							}
						}

						if($_POST[tiporet]!='M')
						{
							$sqlSelectRetention = "SELECT TRD.conceptocausa, TRD.conceptosgr FROM tesoretenciones  AS TR, tesoretenciones_det AS TRD WHERE TR.destino='$_POST[tiporet]' AND TR.id=TRD.codigo AND TR.estado='S' AND TRD.conceptocausa!='-1' AND TRD.conceptocausa!='' AND TR.tipo='S' LIMIT 1";
							$resConsult = mysql_query($sqlSelectRetention,$linkbd);
							$rowRetention = mysql_fetch_row($resConsult);

							$sq="select fechainicial from conceptoscontables_det where codigo='".$rowRetention[0]."' and modulo='4' and tipo='RE' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
							$re=mysql_query($sq,$linkbd);
							while($ro=mysql_fetch_assoc($re))
							{
								$_POST[fechacausa]=$ro["fechainicial"];
							}
							$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo=".$rowRetention[0]." and tipo='RE' and fechainicial='".$_POST[fechacausa]."'";
							$resc=mysql_query($sqlrc,$linkbd);
							while($rowc=mysql_fetch_row($resc))
							{
								if($rowc[6]=='S')
								{
									$valorcred=$_POST[dvalores][$x];
									$valordeb=0;
									$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('36 $consec','".$rowc[4]."','".$_POST[tercero]."','".$_POST[cc]."','Recaudo Transferencia".strtoupper($_POST[dncoding][$x])."','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
									mysql_query($sqlr,$linkbd);
								}
							}

							$sq="select fechainicial from conceptoscontables_det where codigo='".$rowRetention[1]."' and modulo='4' and tipo='SR' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
							$re=mysql_query($sq,$linkbd);
							while($ro=mysql_fetch_assoc($re))
							{
								$_POST[fechacausa]=$ro["fechainicial"];
							}
							$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo=".$rowRetention[1]." and tipo='SR' and fechainicial='".$_POST[fechacausa]."'";
							$resc=mysql_query($sqlrc,$linkbd);
							while($rowc=mysql_fetch_row($resc))
							{
								if($rowc[4]!='')
								{
									$valorcred=0;
									$valordeb=$_POST[dvalores][$x];
									$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('36 $consec','".$rowc[4]."','".$_POST[tercero]."','".$_POST[cc]."','Recaudo Transferencia".strtoupper($_POST[dncoding][$x])."','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
									mysql_query($sqlr,$linkbd);
								}
							}
						}
					}
				}
				
				for($x=0;$x<count($_POST[dndescuentos]);$x++)
				{
					$dd=$_POST[ddescuentos][$x];
					$sqlr="select * from tesoretenciones_det,tesoretenciones where tesoretenciones_det.codigo=tesoretenciones.id and tesoretenciones.id='".$dd."'";
					//echo $sqlr."<br>";
					$resdes=mysql_query($sqlr,$linkbd);
					$valordes=0;
					while($rowdes=mysql_fetch_row($resdes))
					{
						if($rowdes[10]!='D' && $rowdes[10]!='N')
						{
							$nomDescuento=$_POST[dndescuentos][$x];
							$valordes=$_POST[ddesvalores][$x];
							$sq="select fechainicial from conceptoscontables_det where codigo='$rowdes[3]' and modulo='$rowdes[5]' and tipo='RE' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
							$re=mysql_query($sq,$linkbd);
							while($ro=mysql_fetch_assoc($re))
							{
								$_POST[fechacausa]=$ro["fechainicial"];
							}
							$sqlr="select * from conceptoscontables_det where codigo='$rowdes[3]' and modulo='$rowdes[5]' and cc='".$_POST[cc]."' and tipo='RE' and fechainicial='".$_POST[fechacausa]."'";
							$rst=mysql_query($sqlr,$linkbd);
							$row1=mysql_fetch_assoc($rst);
							//TERMINA BUSQUEDA CUENTA CONTABLE////////////////////////
							if($row1['cuenta']!='' && $valordes>0)
							{
								$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito, valcredito, estado, vigencia) values ('36 $consec','".$row1['cuenta']."','".$_POST[tercero]."' ,'".$_POST[cc]."' , 'Descuento ".$nomDescuento."','',0,".$valordes.",'1' ,'".$_POST[vigencia]."')";
								mysql_query($sqlr,$linkbd);
							}
							
							$sq="select fechainicial from conceptoscontables_det where codigo='$rowdes[9]' and modulo='$rowdes[5]' and tipo='SR' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
							$re=mysql_query($sq,$linkbd);
							while($ro=mysql_fetch_assoc($re))
							{
								$_POST[fechacausa]=$ro["fechainicial"];
							}
							$sqlr="select * from conceptoscontables_det where codigo='$rowdes[9]' and modulo='$rowdes[5]' and cc='".$_POST[cc]."' and tipo='SR' and fechainicial='".$_POST[fechacausa]."'";
							$rst=mysql_query($sqlr,$linkbd);
							$row2=mysql_fetch_assoc($rst);
							//TERMINA BUSQUEDA CUENTA CONTABLE////////////////////////
							if($row2['cuenta']!='' && $valordes>0)
							{
								$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito, valcredito, estado, vigencia) values ('36 $consec','".$row2['cuenta']."','".$_POST[tercero]."' ,'".$_POST[cc]."' , 'Descuento ".$nomDescuento."','',".$valordes.",0,'1' ,'".$_POST[vigencia]."')";
								mysql_query($sqlr,$linkbd);
								
							}
							$sqlr3="SELECT *FROM tesoretenciones_det_presu WHERE cod_presu='".$rowdes[2]."' AND vigencia='$_POST[vigencia]'";
							$res3=mysql_query($sqlr3,$linkbd);
							$row3=mysql_fetch_assoc($res3);
							$sqlr="insert into pptoingtranpptosgr (cuenta,idrecibo,valor,vigencia) values('".$row3['cuentapres']."',$idrec,'".$_POST[ddesvalores][$x]."','".$_POST[vigencia]."')";
							mysql_query($sqlr,$linkbd);
						}
						
					}
				}
				
				$noGuarda = 0;
				//************** insercion de consignaciones **************
				for($x=0;$x<count($_POST[dndescuentos]);$x++)
				{
					$sqlr="insert into tesorecaudotransferenciaretencionsgr (id_recaudo,descuento,valor,estado) values($idrec,'".$_POST[ddescuentos][$x]."',".$_POST[ddesvalores][$x].",'S')";
					if (!mysql_query($sqlr,$linkbd))
					{
						echo "<table ><tr><td class='saludo1'><center><font color=blue><img src='imagenes/alert.png'> Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petici�n: <br><font color=red><b>$sqlr</b></font></p>";
						//	 $e =mysql_error($respquery);
						echo "Ocurri� el siguiente problema:<br>";
						  //echo htmlentities($e['message']);
						  echo "<pre>";
						///echo htmlentities($e['sqltext']);
						// printf("\n%".($e['offset']+1)."s", "^");
						echo "</pre></center></td></tr></table>";
						$noGuarda += 1;
					}
				}
				for($x=0;$x<count($_POST[dcoding]);$x++)
				{
					$sqlr="insert into tesorecaudotransferenciasgr_det (id_recaudo,ingreso,valor,estado,tipo_mov) values($idrec,'".$_POST[dcoding][$x]."',".$_POST[dvalores][$x].",'S','$_POST[tipomovimiento]')";
					if (!mysql_query($sqlr,$linkbd))
					{
						echo "<table ><tr><td class='saludo1'><center><font color=blue><img src='imagenes/alert.png'> Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petici�n: <br><font color=red><b>$sqlr</b></font></p>";
						//	 $e =mysql_error($respquery);
						echo "Ocurri� el siguiente problema:<br>";
						  //echo htmlentities($e['message']);
						  echo "<pre>";
						///echo htmlentities($e['sqltext']);
						// printf("\n%".($e['offset']+1)."s", "^");
						echo "</pre></center></td></tr></table>";
						$noGuarda += 1;
					}
					  else
					  {
						$sqlri="Select * from tesoingresos_det where codigo='".$_POST[dcoding][$x]."' and vigencia=$vigusu";
						 $resi=mysql_query($sqlri,$linkbd);
						//	echo "$sqlri <br>";
						while($rowi=mysql_fetch_row($resi))
						{
							$vi=$_POST[dvalores][$x];
							//$sqlr="update pptocuentaspptoinicial  set ingresos=ingresos+".$vi." where cuenta ='".$rowi[6]."' AND VIGENCIA='".$_POST[vigencia]."'";
							//mysql_query($sqlr,$linkbd);	
							//****creacion documento presupuesto ingresos
							//$sqlr="insert into pptoingtranppto (cuenta,idrecibo,valor,vigencia) values('$rowi[6]',$idrec,$vi,'".$vigusu."')";
							  //mysql_query($sqlr,$linkbd);
						}
					  /*  echo "<table  class='inicio'>
							<tr>
								<td class='saludo1'>
									<center>Se ha almacenado el Recaudo con Exito <img src='imagenes/confirm.png'></center>
								</td>
							</tr>
						</table>
						<script>respuestamensaje();</script>
						";*/
						
					}
				}
				if($noGuarda == 0)
				{
					echo "<table  class='inicio'>
						<tr>
							<td class='saludo1'>
								<center>Se ha almacenado el Recaudo con Exito <img src='imagenes/confirm.png'></center>
							</td>
						</tr>
					</table>
					<script>respuestamensaje();</script>
					";
					?>
					<script>
						document.form2.numero.value="";
						document.form2.valor.value=0;
					</script>
					<?php
				}
			}
			else
			{
				echo "<table class='inicio'><tr><td class='saludo1'><center>Ya Existe un Recibo con este numero <img src='imagenes/alert.png'></center></td></tr></table>";
			}
		}
		else
		{
			$linkbd=conectar_bd();
			ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
			$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
			$vigencia = $fecha[3];
			//*********************CREACION DEL COMPROBANTE CONTABLE ***************************
			//***busca el consecutivo del comprobante contable
			//************ insercion de cabecera recaudos ************
			$sqlr = "UPDATE tesorecaudotransferenciasgr SET estado = 'R' WHERE id_recaudo='$_POST[ncomp]'";
			mysql_query($sqlr,$linkbd);

			$sqlr="insert into tesorecaudotransferenciasgr (id_recaudo,fecha,vigencia,banco,ncuentaban,concepto,detalleretencion,tercero,cc,valortotal,estado,tipo_mov) values($_POST[ncomp],'$fechaf','".$vigencia."','','','".strtoupper($_POST[descripcion])."','','$_POST[terceroAReversar]','','$_POST[totalc]','R','$_POST[tipomovimiento]')";
			//echo $sqlr;
			mysql_query($sqlr,$linkbd);

			$sqlr = "SELECT * FROM comprobante_det WHERE tipo_comp='36' AND numerotipo='$_POST[ncomp]'";
			$res = mysql_query($sqlr,$linkbd);
			while($row = mysql_fetch_row($res))
			{
					$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito, valcredito, estado, vigencia) values ('36 $_POST[ncomp]','".$row[2]."','".$row[3]."' ,'".$row[4]."' , 'Reversion ".$row[5]."','',".$row[8].",".$row[7].",'2' ,'".".$row[10]."."')";
					mysql_query($sqlr,$linkbd);
			}
			echo "<table  class='inicio'>
				<tr>
					<td class='saludo1'>
						<center>Se ha almacenado el Recaudo con Exito <img src='imagenes/confirm.png'></center>
					</td>
				</tr>
			</table>
			<script>respuestamensaje();</script>
			";
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
 </td></tr>
</table>
</body>
</html> 		