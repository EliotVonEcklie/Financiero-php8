<!--V 1000 14/12/16 -->
<?php
require "comun.inc";
require "funciones.inc";
session_start();
//**niveles menu: Administracion (0) - Consultas (1) - Herramientas (2) - Reportes (3)
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html" />
		<title>:: Contabilidad</title>
		<script>
			//************* ver reporte ************
			//***************************************
			function verep(idfac)
			{
				document.form1.oculto.value=idfac;
				document.form1.submit();
			}
		</script>
		<script>
			//************* genera reporte ************
			//***************************************
			function genrep(idfac)
			{
				document.form2.oculto.value=idfac;
				document.form2.submit();
  			}
		</script>
		<script>
			//************* genera reporte ************
			//***************************************
			function guardar()
			{
				if (document.form2.numero.value!='' && document.form2.nombre.value!='')
				{
					if (confirm("Esta Seguro de Guardar"))
					{
						document.form2.oculto.value=2;
						document.form2.submit();
					}
				}
				else
				{
					alert('Faltan datos para completar el registro');
					document.form2.numero.focus();
					document.form2.numero.select();
				}
			}
		</script>
		<script >
			function clasifica(formulario)
			{
				//document.form2.action="presu-recursos.php";
				document.form2.submit();
			}
		</script>
		<script>
			function agregardetalle()
			{
				if(document.getElementById('fecha1').value!='')
				{
					if(document.form2.cuenta.value!=""  && document.form2.cc.value!="" )
					{
					document.form2.agregadet.value=1;
					document.form2.submit();
					}
					else {
					alert("Falta informacion para poder Agregar");
					}
				}
				else
				{
					alert('Falta digitar la Fecha');
				}
			}
		</script>
		<script>
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
		</script>
		<script>
			function buscacta(e)
			{
				if (document.form2.cuenta.value!="")
				{
					document.form2.bc.value='1';
					document.form2.submit();
 				}
 			}
		</script>
		<script>
			function buscacc(e)
			{
				if (document.form2.cc.value!="")
				{
					document.form2.bcc.value='1';
					document.form2.submit();
 				}
 			}
		</script>
		<script language="JavaScript1.2">
			function validar2()
			{
				//   alert("Balance Descuadrado");
				document.form2.oculto.value=2;
				document.form2.action="presu-concecontablescausa.php";
				document.form2.submit();
			}
			function validar3(formulario)
			{
				document.form2.action="teso-concecongastosban.php";
				document.form2.submit();
			}
			
			function despliegamodal2(_valor,v)
			{
				if (document.form2.fecha1.value!='')
				{
					document.getElementById("bgventanamodal2").style.visibility=_valor;
					if(_valor=="hidden"){
						document.getElementById('ventana2').src="";
						document.form2.submit();
					}
					else {
						if(v==1){
							document.getElementById('ventana2').src="cuentasin-ventana1.php?fecha="+document.form2.fecha1.value;
						}
						else if(v==2)
						{
							document.getElementById('ventana2').src="cuentas-ventana2.php?fecha="+document.form2.fecha1.value;
						}
						else if(v==3)
						{
							document.getElementById('ventana2').src="cuentas-ventana3.php?fecha="+document.form2.fecha1.value;
						}
						else if(v==4)
						{
							document.getElementById('ventana2').src="cuentas-ventana4.php?fecha="+document.form2.fecha1.value;
						}
					}
				}
				else
				{
					alert ("Falta digitar la fehca");
				}
			}
		</script>
		<script language="JavaScript1.2">
			function validar()
			{
				document.form2.submit();
			}
		</script>
		<script src="css/programas.js"></script>
		<script src="css/calendario.js"></script>
		<link href="css/css2.css" rel="stylesheet" type="text/css" />
		<link href="css/css3.css" rel="stylesheet" type="text/css" />
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("cont");?></tr>
			<tr>
  				<td colspan="3" class="cinta"><a href="presu-concecontablespag.php" ><img src="imagenes/add.png"  alt="Nuevo" border="0" class="mgbt"/></a> <a href="#"  onClick="guardar()"><img src="imagenes/guarda.png"  alt="Guardar" class="mgbt"/></a> <a href="presu-buscaconcecontablespag.php"><img src="imagenes/busca.png"  alt="Buscar" border="0" class="mgbt"/></a><a href="#" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" alt="nueva ventana" class="mgbt"></a> <a href="presu-concecontables.php"><img src="imagenes/iratras.png" title="Atr&aacute;s" class="mgbt"></a></td>
			</tr>
		</table>
		<tr>
			<td colspan="3" class="tablaprin"> 
				<?php
				$vigencia=date(Y);
				$linkbd=conectar_bd();
				?>	
				<?php
				if(!$_POST[oculto])
				{	
					$_POST[vigencia]=$vigencia;
					$_POST[valoradicion]=0;
					$_POST[valorreduccion]=0;
					$_POST[valortraslados]=0;		 		  			 
					$_POST[valor]=0;		 
					$sqlr="select MAX(codigo) from conceptoscontables where modulo=3 and tipo='P' order by codigo Desc";
					//echo $sqlr;
					$res=mysql_query($sqlr);
					$row=mysql_fetch_row($res);
					$_POST[numero]=$row[0]+1;
					if(strlen($_POST[numero])==1)
					{
						$_POST[numero]='0'.$_POST[numero];
					}
				}
				?>
				<form name="form2" method="post" action=""> 
					<?php //**** busca cuenta
					if($_POST[bc]=='1')
					{
						$nresul=buscacuenta($_POST[cuenta]);
						if($nresul!='')
						{
							$_POST[ncuenta]=$nresul;
						}
						else
						{
							$_POST[ncuenta]="";
						}
					}
					//**** busca centro costo
					if($_POST[bcc]=='1')
					{
						$nresul=buscacentro($_POST[cc]);
						if($nresul!='')
						{
							$_POST[ncc]=$nresul;
						}
						else
						{
							$_POST[ncc]="";
						}
					}
					?>
					<table class="inicio" align="center"  >
						<tr>
							<td class="titulos" colspan="8" style='width:93%'>.: Concepto Contable de Gastos</td>
							<td class="cerrar" style='width:7%'><a href="presu-principal.php">Cerrar</a></td>
						</tr>
						<tr>
							<td width="119" class="saludo1">Codigo:</td>
							<td width="180" valign="middle" ><input type="text" id="numero" name="numero" size="10" onKeyPress="javascript:return solonumeros(event)" 		  onKeyUp="return tabular(event,this)" value="<?php echo $_POST[numero]?>" onClick="document.getElementById('numero').focus();document.getElementById('numero').select();"></td>
							<td width="119" class="saludo1">Nombre:</td>
							<td width="100" valign="middle" ><input type="text" id="nombre" name="nombre" size="30" 
							onKeyUp="return tabular(event,this)" value="<?php echo $_POST[nombre]?>" onClick="document.getElementById('acuerdo').focus();document.getElementById('acuerdo').select();"></td><td class="saludo1">Tipo:</td><td><input name="tipo" value="Gasto" size="10" type="text"><input name="tipoc" value="P" size="10" type="hidden"></td><td class="saludo1">Almacen:</td><td><input name="almacen" id="almacen"  type="checkbox" style="max-height: 15px" <?php if(!empty($_POST[almacen])){echo "checked "; }?> ></td>
						</tr>
					</table>
					<table class="inicio">
						<tr><td colspan="6" class="titulos2">Crear Detalle Concepto</td></tr>
						<tr>
							<td class="saludo1" style="width:10%">Fecha Inicial:</td>
							<td style="width:10%;">
								<input name="fecha1" id="fecha1" type="text" id="fecha1" title="DD/MM/YYYY" style="width:75%;" value="<?php echo $_POST[fecha1]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" tabindex="2"/>&nbsp;<a href="#" onClick="displayCalendarFor('fecha1');" tabindex="3" title="Calendario"><img src="imagenes/calendario04.png" align="absmiddle" style="width:20px;"></a>
							</td>  
							<td class="saludo1">Cuenta: </td>
							<td  valign="middle" >
								<input name="cuenta" id="cuenta" type="text"  value="<?php echo $_POST[cuenta]?>" onKeyUp="return tabular(event,this) " style="width:75%;" onBlur="buscacta(event)"><input type="hidden" value="" name="bc" id="bc">
								<input name="cuenta_" type="hidden" value="<?php echo $_POST[cuenta_]?>">&nbsp;<img src="imagenes/find02.png" style="width:20px;" onClick="despliegamodal2('visible',1);" title="Buscar cuenta" class="icobut" />
							</td>
							<td>
								<input type="hidden" value="<?php echo $_POST[defecto]?>" name="defecto" id="defecto">
								<input name="ncuenta" type="text" value="<?php echo $_POST[ncuenta]?>" size="70" readonly>
							</td>
						</tr>
						<tr>
							<td class="saludo1">Tipo:</td>
							<td>
								<select style="width:90%;" name="debcred">
									<option value="1" <?php if($_POST[debcred]=='1') echo "SELECTED"; ?>>Debito</option>
								</select>
							</td>
							<td class="saludo1">CC:</td>
							<td>
								<select name="cc" style="width:85%;" onChange="validar()" onKeyUp="return tabular(event,this)">
									<?php
									$linkbd=conectar_bd();
									$sqlr="select *from centrocosto where estado='S' ORDER BY ID_CC";
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
							<td>
								<input type="button" name="agrega" value="  Agregar  " onClick="agregardetalle()" ><input type="hidden" value="0" name="agregadet">
								<?php
								if (!$_POST[oculto])
								{
									?>
									<script>
										//document.form2.cc.focus();
									</script>	
									<?php
								}
			
								if($_POST[bc]=='1')
								{
									$nresul=buscacuenta($_POST[cuenta]);
									if($nresul!='')
									{
										$_POST[ncuenta]=$nresul;
										?>
										<script>
											document.getElementById('debcred').focus();
										</script>
										<?php
									}
									else
									{
										$_POST[ncuenta]="";
										?>
										<script>alert("Cuenta Incorrecta");document.form2.cuenta.focus();</script>
										<?php
									}
								}
								//*** centro  costo
								if($_POST[bcc]=='1')
								{
									$nresul=buscacentro($_POST[cc]);
									if($nresul!='')
									{
										$_POST[ncc]=$nresul;
										?>
										<script>
										document.getElementById('cuenta').focus();document.getElementById('cuenta').select();</script>
										<?php
									}
									else
									{
										$_POST[ncc]="";
										?>
										<script>alert("Centro de Costos Incorrecto");document.form2.cc.focus();</script>
										<?php
									}
								}
								?>
								<input type="hidden" value="0" name="oculto">	
							</td>
						</tr>
					</table>
					<div class="subpantalla" style="height:52%; width:99.6%; overflow-x:hidden;">
						<table class="inicio">
							<tr><td class="titulos" colspan="7">Detalle Concepto</td></tr>
							<tr><td class="titulos2">Fecha</td><td class="titulos2">CC</td><td class="titulos2">Cuenta</td><td class="titulos2">Nombre Cuenta</td><td class="titulos2">Debito</td><td class="titulos2">Credito</td><td class="titulos2"><img src="imagenes/del.png" ><input type='hidden' name='elimina' id='elimina'></td></tr>
							<?php
							if ($_POST[elimina]!='')
							{ 
								$posi=$_POST[elimina];
								unset($_POST[tcuentas][$posi]);
								unset($_POST[dcuentas][$posi]);
								unset($_POST[dncuentas][$posi]);
								unset($_POST[dccs][$posi]);
								unset($_POST[dcreditos][$posi]);		 		 		 		 		 
								unset($_POST[ddebitos][$posi]);	
								unset($_POST[fecha][$posi]);
								$_POST[tcuentas]= array_values($_POST[tcuentas]); 
								$_POST[dcuentas]= array_values($_POST[dcuentas]); 
								$_POST[dncuentas]= array_values($_POST[dncuentas]); 		 		 
								$_POST[dccs]= array_values($_POST[dccs]);
								$_POST[fecha]= array_values($_POST[fecha]);
								$_POST[dcreditos]= array_values($_POST[dcreditos]); 
								$_POST[ddebitos]= array_values($_POST[ddebitos]); 		 		 		 		 
							}
		
							if ($_POST[agregadet]=='1')
							{
								$cuentacred=0;
								$cuentadeb=0;
								$diferencia=0;
								$_POST[tcuentas][]='N';
								$_POST[dcuentas][]=$_POST[cuenta];
								$_POST[dncuentas][]=$_POST[ncuenta];
								$_POST[dccs][]=$_POST[cc];		 
								$_POST[fecha][]=$_POST[fecha1];
								if ($_POST[debcred]==1)
								{
									$_POST[dcreditos][]='N';
									$_POST[ddebitos][]="S";
								}
								else
								{
									$_POST[dcreditos][]='S';
									$_POST[ddebitos][]="N";
								}
								$_POST[agregadet]=0;
								?>
								<script>
									//document.form2.cuenta.focus();	
									document.form2.cc.select();
									document.form2.cc.value="";
								</script>
								<?php
							}
							$iter='saludo1a';
							$iter2='saludo2';
							for ($x=0;$x< count($_POST[dcuentas]);$x++)
							{echo "
								<tr class='$iter'>
									<td><input name='fecha[]' value='".$_POST[fecha][$x]."' type='text' size='8' class='inpnovisibles' readonly></td>
									<td><input name='dccs[]' value='".$_POST[dccs][$x]."' type='text' size='2' class='inpnovisibles' readonly></td>
									<td><input name='tcuentas[]' value='".$_POST[tcuentas][$x]."' type='hidden' ><input name='dcuentas[]' value='".$_POST[dcuentas][$x]."' type='text' size='8' class='inpnovisibles' readonly></td>
									<td><input name='dncuentas[]' value='".$_POST[dncuentas][$x]."' type='text' size='70' class='inpnovisibles' readonly></td>
									<td><input name='ddebitos[]' value='".$_POST[ddebitos][$x]."' type='text' size='3' onDblClick='llamarventanadeb(this,$x)' class='inpnovisibles' readonly></td>
									<td><input name='dcreditos[]' value='".$_POST[dcreditos][$x]."' type='text' size='3' onDblClick='llamarventanacred(this,$x)' class='inpnovisibles' readonly></td>
									<td><a href='#' onclick='eliminar($x)'><img src='imagenes/del.png'></a></td>
								</tr>";
								$aux=$iter;
								$iter=$iter2;
								$iter2=$aux;
							}	 
							?>
						</table>
					</div>
				</form>
				<?php 
				//********** GUARDAR EL COMPROBANTE ***********
				if($_POST[oculto]=='2')	
				{
					$almacen="N";
				
					if(!empty($_POST[almacen])){
						$almacen="S";
					}
				
					$fec=date("d/m/Y");
					$_POST[fecha]=$fec;
					//rutina de guardado cabecera
					$linkbd=conectar_bd();
			
					$sqlr="insert into conceptoscontables (codigo,nombre,modulo,tipo,almacen) values ('$_POST[numero]','$_POST[nombre]',3,'$_POST[tipoc]','$almacen')";
					if(!mysql_query($sqlr,$linkbd))
					{
						echo "<table class='inicio'><tr><td class='saludo1'><center>No Se ha Almacenado con Exito El Concepto Contable, Error: $sqlr </center></td></tr></table>";
					}
					else
					{
						echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha Almacenado con Exito El Concepto Contable</center></td></tr></table>";
					}
					//**** crear el detalle del concepto
					for($x=0;$x<count($_POST[dcuentas]);$x++) 
					{
						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
						$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
						$sqlr="insert into conceptoscontables_det (codigo,tipo,tipocuenta,cuenta,cc,debito,credito,estado,modulo,fechainicial) values ('$_POST[numero]','$_POST[tipoc]','".$_POST[tcuentas][$x]."','".$_POST[dcuentas][$x]."','".$_POST[dccs][$x]."','".$_POST[ddebitos][$x]."','".$_POST[dcreditos][$x]."','S','3','$fechaf')";
						echo $sqlr;
						$res=mysql_query($sqlr,$linkbd);		
						$cc=$_POST[dccs][$x];
						$sqlr="insert into conceptoscontables_det (codigo,tipo,tipocuenta,cuenta,cc,debito,credito,estado,modulo,fechainicial) values ('$_POST[numero]','$_POST[tipoc]','B','','".$cc."','N','S','S','3','$fechaf')";
						$res=mysql_query($sqlr,$linkbd);
					}		
				}
				?>	
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