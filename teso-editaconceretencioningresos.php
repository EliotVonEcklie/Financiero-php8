<!--V 1000 14/12/16 -->
<?php
	require "comun.inc";
	require "funciones.inc";
	session_start();
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	date_default_timezone_set("America/Bogota");
	$linkbd=conectar_bd();
	$scroll=$_GET['scrtop'];
	$totreg=$_GET['totreg'];
	$idcta=$_GET['idcta'];
	$altura=$_GET['altura'];
	$filtro="'".$_GET['filtro']."'";
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html" />
		<title>:: Contabilidad</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script type="text/javascript" src="css/calendario.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script>
			function guardar()
			{
				if (document.form2.numero.value!='' && document.form2.nombre.value!='')
				{
					despliegamodalm('visible','4','Esta Seguro de Guardar','1')
				}
 				else
				{
					despliegamodalm('visible','2','Faltan datos para completar el registro');
					document.form2.numero.focus();
					document.form2.numero.select();
				}
			}
			function clasifica(formulario)
			{
				//document.form2.action="presu-recursos.php";
				document.form2.submit();
			}
			function agregardetalle()
			{
				if(document.getElementById('fecha1').value!='')
				{
					if(document.form2.cuenta.value!=""  && document.form2.cc.value!="" )
					{
						document.form2.agregadet.value=1;
						document.form2.oculto.value=9;
						document.form2.submit();
					}
					else {despliegamodalm('visible','2','Falta informacion para poder Agregar');}
				}
				else {despliegamodalm('visible','2','Falta digitar la Fecha');}
			}
			function eliminar(variable)
			{
				document.form2.elimina.value=variable;
				document.getElementById('elimina').value=variable;
				despliegamodalm('visible','4','Esta Seguro de Eliminar','2');
			}
			function buscacta(e)
			{
				if (document.form2.cuenta.value!="")
				{
					document.form2.bc.value='1';
					document.getElementById('oculto').value='9';
					document.form2.submit();
				}
			}
			function buscacc(e)
 			{
				if (document.form2.cc.value!="")
				{
					document.form2.bcc.value='1';
					document.form2.submit();
				}
 			}
 			function adelante(scrtop, numpag, limreg, filtro, next)
			{
				var maximo=document.getElementById('maximo').value;
				var actual=document.getElementById('numero').value;
				if(parseFloat(maximo)>parseFloat(actual))
				{
					document.getElementById('oculto').value='1';
					document.getElementById('numero').value=next;
					var idcta=document.getElementById('numero').value;
					document.form2.action="teso-editaconceretencioningresos.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					document.form2.submit();
				}
			}
			function atrasc(scrtop, numpag, limreg, filtro, prev)
			{
				var minimo=document.getElementById('minimo').value;
				var actual=document.getElementById('numero').value;
				if(parseFloat(minimo)<parseFloat(actual))
				{
					document.getElementById('oculto').value='1';
					document.getElementById('numero').value=prev;
					var idcta=document.getElementById('numero').value;
					document.form2.action="teso-editaconceretencioningresos.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					document.form2.submit();
				}
			}
			function iratras(scrtop, numpag, limreg, filtro)
			{
				var idcta=document.getElementById('numero').value;
				location.href="teso-buscaconceretencioningresos.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
			}
			function validar3(formulario)
			{
				document.form2.action="teso-buscaconceretencioningresos.php";
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
			function validar2()
			{
				//   alert("Balance Descuadrado");
				document.form2.oculto.value=2;
				document.form2.action="presu-editaconcecontablesanticipo.php";
				document.form2.submit();
			}
			function validar()
			{
				document.form2.oculto.value=9;
				document.form2.submit();
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
				//document.location.href = "hum-liquidarnominamirar.php?idnomi="+document.form2.idcomp.value;
			}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.form2.oculto.value=2;
								document.form2.submit();
								break;
					case "2":	document.form2.oculto.value=3;
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
		<?php
			$numpag=$_GET[numpag];
			$limreg=$_GET[limreg];
			$scrtop=26*$totreg;
		?>
		<table>
			<tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("cont");?></tr>
			<tr>
				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='teso-conceretencioningresos.php'" class="mgbt"/><img src="imagenes/guarda.png"  title="Guardar" onClick="guardar()" class="mgbt"/><img src="imagenes/busca.png"  title="Buscar" onClick="location.href='teso-buscaconceretencioningresos.php'" class="mgbt"/><img src="imagenes/agenda1.png" title="Agenda"  onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" class="mgbt" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();"/><img src="imagenes/iratras.png" title="Atr&aacute;s" onClick="iratras(<?php echo "$scrtop,$numpag,$limreg,$filtro";?>)" class="mgbt"/></td>
			</tr>
		</table>
		<div id="bgventanamodalm" class="bgventanamodalm">
			<div id="ventanamodalm" class="ventanamodalm">
				<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
				</IFRAME>
			</div>
		</div>
		<?php
			if ($_GET[is]!=""){echo "<script>document.getElementById('codrec').value=$_GET[is];</script>";}
			$sqlr="select MIN(CONVERT(codigo, SIGNED INTEGER)), MAX(CONVERT(codigo, SIGNED INTEGER)) from conceptoscontables where modulo='4' and tipo='RI' ORDER BY CONVERT(codigo, SIGNED INTEGER)";
			$res=mysql_query($sqlr,$linkbd);
			$r=mysql_fetch_row($res);
			$_POST[minimo]=$r[0];
			$_POST[maximo]=$r[1];
			if($_POST[oculto]=="")
			{
				if ($_POST[codrec]!="" || $_GET[is]!="")
				{
					if($_POST[codrec]!=""){$sqlr="select *from conceptoscontables where codigo='$_POST[codrec]' and modulo='4' and tipo='RI'";}
					else {$sqlr="select *from conceptoscontables where codigo ='$_GET[is]' and modulo='4' and tipo='RI'";}
				}
				else {$sqlr="select * from  conceptoscontables where modulo='4' and tipo='RI' ORDER BY CONVERT(codigo, SIGNED INTEGER) DESC";}
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_assoc($res);
				$_POST[numero]=$row["codigo"];
			}
			if(($_POST[oculto]!="2")&&($_POST[oculto]!="9"))
			{
				$sqlr="select *from conceptoscontables where conceptoscontables.codigo=$_POST[numero] and conceptoscontables.tipo='RI'  and conceptoscontables.modulo='4'";
				$res=mysql_query($sqlr,$linkbd); 
				while ($row=mysql_fetch_assoc($res)) 
				{
					$_POST[nombre]=$row["nombre"];
					$_POST[numero]=$row["codigo"];
				}
			}
			if(($_POST[oculto]!="2")&&($_POST[oculto]!="9"))
			{
				unset($_POST[dcuentas]);
				unset($_POST[dncuentas]);
				unset($_POST[dccs]);
				unset($_POST[dcreditos]);		 		 		 		 		 
				unset($_POST[ddebitos]);	
				unset($_POST[fecha]);
				unset($_POST[fecha1]);
				unset($_POST[cuenta]);
				unset($_POST[ncuenta]);	
				$sqlr="select *from conceptoscontables, conceptoscontables_det  where conceptoscontables.codigo=conceptoscontables_det.codigo and conceptoscontables.codigo=$_POST[numero] and conceptoscontables.tipo='RI' and conceptoscontables_det.tipo='RI' and conceptoscontables.modulo='4' and conceptoscontables_det.modulo='4' and conceptoscontables_det.cuenta!='' order by conceptoscontables_det.fechainicial desc";
				$res=mysql_query($sqlr,$linkbd); 
				//echo $sqlr;
				$cont=0;
				while ($row=mysql_fetch_assoc($res))
				{
					$_POST[dcuentas][$cont]=$row["cuenta"];
					$_POST[dccs][$cont]=$row["cc"];
					$_POST[dncuentas][$cont]=buscacuenta($row["cuenta"]);
					$_POST[ddebitos][$cont]=$row["debito"];
					$_POST[dcreditos][$cont]=$row["credito"];
					$_POST[fecha][$cont]=date('d/m/Y',strtotime($row["fechainicial"]));
					$cont=$cont+1;
				}
			}
			//NEXT
			$sqln="select *from conceptoscontables WHERE codigo > '$_POST[numero]' and modulo='4' and tipo='RI' ORDER BY codigo ASC LIMIT 1";
			$resn=mysql_query($sqln,$linkbd);
			$row=mysql_fetch_row($resn);
			$next="'".$row[0]."'";
			//PREV
			$sqlp="select *from conceptoscontables WHERE codigo < '$_POST[numero]' and modulo='4' and tipo='RI' ORDER BY codigo DESC LIMIT 1";
			$resp=mysql_query($sqlp,$linkbd);
			$row=mysql_fetch_row($resp);
			$prev="'".$row[0]."'";	
		?>
		<form name="form2" method="post" action=""> 
			<?php 
				if($_POST[bc]=='1')//**** busca cuenta
				{
					$nresul=buscacuenta($_POST[cuenta]);
					if($nresul!=''){$_POST[ncuenta]=$nresul; }
					else {$_POST[ncuenta]="";}
				}
				if($_POST[bcc]=='1')//**** busca centro costo
				{
					$nresul=buscacentro($_POST[cc]);
					if($nresul!=''){$_POST[ncc]=$nresul;}
					else {$_POST[ncc]="";}
				}
			 ?>
			<table class="inicio" align="center"  >
				<tr>
					<td class="titulos" colspan="8">.: Editar Concepto Contable Retencion Ingresos</td>
					<td class="cerrar" style="width:7%;"><a onClick="location.href='teso-principal.php'">&nbsp;Cerrar</a></td>
				</tr>
				<tr>
					<td width="119" class="saludo1">Codigo:</td>
					<td  style="width:15%"><img src="imagenes/back.png" title="Anterior" class="icobut" onClick="atrasc(<?php echo "$scrtop,$numpag,$limreg,$filtro,$prev"; ?>)"/>&nbsp;<input type="text" id="numero" name="numero" style="width:50%;height:30px;" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[numero]?>" onClick="document.getElementById('numero').focus();document.getElementById('numero').select();" readonly/>&nbsp;<img src="imagenes/next.png" title="siguiente" onClick="adelante(<?php echo "$scrtop,$numpag,$limreg,$filtro,$next";?>)" class="icobut"></td>
					<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo" id="maximo">
					<input type="hidden" value="<?php echo $_POST[minimo]?>" name="minimo" id="minimo">
					<input type="hidden" value="<?php echo $_POST[codrec]?>" name="codrec" id="codrec">
					<input type="hidden" value="<?php echo $_POST[defecto]?>" name="defecto" id="defecto">
					<td width="119" class="saludo1">Nombre:</td>
					<td style="width:40%"><input type="text" id="nombre" name="nombre" style="width:100%;height:30px;"
		  onKeyUp="return tabular(event,this)" value="<?php echo $_POST[nombre]?>" onClick="document.getElementById('acuerdo').focus();document.getElementById('acuerdo').select();"></td>
					<td class="saludo1">Tipo:</td>
					<td><input name="tipo" value="Anticipo" style="width:100%;height:30px;" type="text"></td>
					<input type="hidden" name="tipoc" value="RI"/>
					<input type="hidden" name="ban" value="1">
				</tr>
			</table>
			<table class="inicio">
				<tr><td colspan="7" class="titulos2">Crear Detalle Concepto</td></tr>
				<tr>
					<td class="saludo1" style="width:10%;">Fecha Inicial:</td>
					<td style="width:10%;"><input name="fecha1" id="fecha1" type="text" title="DD/MM/YYYY" style="width:75%;height:30px;" value="<?php echo $_POST[fecha1]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" tabindex="2"/>&nbsp;<img src="imagenes/calendario04.png" onClick="displayCalendarFor('fecha1');" title="Calendario" class="icobut"/></td>   
					<td class="saludo1" style="width:8%">Cuenta: </td>
					<td style="width:15%"><input name="cuenta" id="cuenta" type="text"  value="<?php echo $_POST[cuenta]?>" onKeyUp="return tabular(event,this) " style="width:75%;height:30px;" onBlur="buscacta(event)"><input type="hidden" value="" name="bc" id="bc"><input name="cuenta_" type="hidden" value="<?php echo $_POST[cuenta_]?>">&nbsp;<img src="imagenes/find02.png" style="width:20px;" onClick="despliegamodal2('visible',1);" title="Buscar cuenta" class="icobut" /></td>
					<td colspan="2"><input type="text" name="ncuenta" value="<?php echo $_POST[ncuenta]?>" style="width:100%;height:30px;" readonly/></td>
                    <td style="width:7%;"></td>
				</tr>
				<tr>
					<td class="saludo1">Tipo:</td>
					<td>
						<select name="debcred" style="width:90%;height:30px;">
							<option value="2" <?php if($_POST[debcred]=='2') echo "SELECTED"; ?>>Credito</option>
		  				</select>
					</td>
					<td class="saludo1" >CC:</td>
					<td colspan="2" style="width:20%;">
						<select name="cc" style="width:99%;height:30px;" onChange="validar()" onKeyUp="return tabular(event,this)">
							<?php
								$sqlr="select *from centrocosto where estado='S'";
								$res=mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($res)) 
								{
									if($row[0]==$_POST[cc]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
									else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
								}	 	
							?>
						</select>
	 				</td>
		  			<td><em class="botonflecha" onClick="agregardetalle();">Agregar</em></td>
                    <input type="hidden" value="0" name="agregadet">
					<?php
						if($_POST[bc]=='1')
			 			{
							$nresul=buscacuenta($_POST[cuenta]);
							if($nresul!='')
							{
								$_POST[ncuenta]=$nresul;
								echo"<script> document.getElementById('debcred').focus();</script>";
							}
							else
							{
								$_POST[ncuenta]="";
								echo" <script>despliegamodalm('visible','2','Cuenta Incorrecta');document.form2.cuenta.focus();</script>";
							}
						}
						if($_POST[bcc]=='1') //*** centro  costo
						{
							$nresul=buscacentro($_POST[cc]);
							if($nresul!='')
							{
								$_POST[ncc]=$nresul;
								echo"
									<script>
										document.getElementById('cuenta').focus();
										document.getElementById('cuenta').select();
									</script>";
							}
							else
							{
								$_POST[ncc]="";
								echo"
								<script>
									despliegamodalm('visible','2','Centro de Costos Incorrecto');
									document.form2.cc.focus();
								</script>";
							}
						}
					?>
					<input type="hidden" name="oculto" id="oculto" value="0" >	
				</td>
			</tr>
		</table>
			<div class="subpantallac" style="height:51.8%; width:99.6%; overflow-x:hidden;">
				<table class="inicio">
					<tr><td class="titulos" colspan="7">Detalle Concepto</td></tr>
					<tr>
						<td class="titulos2">Fecha</td>
						<td class="titulos2">CC</td>
						<td class="titulos2">Cuenta</td>
						<td class="titulos2">Nombre Cuenta</td>
						<td class="titulos2">Debito</td>
						<td class="titulos2">Credito</td>
						<td class="titulos2"><img src="imagenes/del.png" ><input type='hidden' name='elimina' id='elimina'></td>
					</tr>
					<?php
						if ($_POST[oculto]=='3')
						{ 
							$posi=$_POST[elimina];
							unset($_POST[dcuentas][$posi]);
							unset($_POST[dncuentas][$posi]);
							unset($_POST[dccs][$posi]);
							unset($_POST[dcreditos][$posi]);		 		 		 		 		 
							unset($_POST[ddebitos][$posi]);	
							unset($_POST[fecha][$posi]);
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
							echo"<script>document.form2.cc.select();document.form2.cc.value='';</script>";
		 				}
						$iter='saludo1a';
						$iter2='saludo2';
						for ($x=0;$x< count($_POST[dcuentas]);$x++)
						{
							echo "
								<input type='hidden' name='fecha[]' value='".$_POST[fecha][$x]."'/>
								<input type='hidden' name='dccs[]' value='".$_POST[dccs][$x]."'/>
								<input type='hidden' name='dcuentas[]' value='".$_POST[dcuentas][$x]."'/>
								<input type='hidden' name='dncuentas[]' value='".$_POST[dncuentas][$x]."'/>
								<input type='hidden' name='ddebitos[]' value='".$_POST[ddebitos][$x]."'/>
								<input type='hidden' name='dcreditos[]' value='".$_POST[dcreditos][$x]."'/>
								<tr class='$iter'>
									<td style='width:10%'>".$_POST[fecha][$x]."</td>
									<td style='width:10%'>".$_POST[dccs][$x]."</td>
									<td style='width:15%'>".$_POST[dcuentas][$x]."</td>
									<td >".$_POST[dncuentas][$x]."</td>
									<td style='width:10%'>".$_POST[ddebitos][$x]."</td>
									<td style='width:10%'>".$_POST[dcreditos][$x]."</td>
									<td class='icoop' style='width:3%;text-align:center;'><img src='imagenes/del.png' onclick='eliminar($x)'></td>
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
			if($_POST[oculto]=='2')	
			{
				$sqlr="delete from conceptoscontables_det where codigo='$_POST[numero]' and tipo='$_POST[tipoc]' and modulo ='4'";	
				mysql_query($sqlr,$linkbd);
				$sqlr="delete from conceptoscontables where codigo='$_POST[numero]' and tipo='$_POST[tipoc]' and modulo ='4'";	 
				mysql_query($sqlr,$linkbd);
				$sqlr="insert into conceptoscontables (codigo,nombre,modulo,tipo) values ('$_POST[numero]','$_POST[nombre]',4,'$_POST[tipoc]')";
				if(!mysql_query($sqlr,$linkbd))
				{
					echo "<table class='inicio'><tr><td class='saludo1'><center>No Se ha Almacenado con Exito El Concepto Contable, Error: $sqlr </center></td></tr></table>";
				}
				else
				{
					echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha Almacenado con Exito El Concepto Contable</center></td></tr></table>";
				}
				for($x=0;$x<count($_POST[dcuentas]);$x++) 
				{
					preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $_POST[fecha][$x],$fecha);
					$fechaf="$fecha[3]-$fecha[2]-$fecha[1]";
					$sqlr="insert into conceptoscontables_det (codigo,tipo,tipocuenta,cuenta,cc,debito,credito,estado,modulo,fechainicial) values ('$_POST[numero]','$_POST[tipoc]','N','".$_POST[dcuentas][$x]."','".$_POST[dccs][$x]."','".$_POST[ddebitos][$x]."','".$_POST[dcreditos][$x]."','S','4','$fechaf')";
					$res=mysql_query($sqlr,$linkbd);
				}
			}
		?>	
		<div id="bgventanamodal2">
			<div id="ventanamodal2">
				<IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"></IFRAME>
			</div>
		</div>
	</body>
</html>