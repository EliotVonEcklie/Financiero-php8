<?php
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=iso-8859-1");
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	date_default_timezone_set("America/Bogota");
	$scroll=$_GET['scrtop'];
	$totreg=$_GET['totreg'];
	$idcta=$_GET['idcta'];
	$altura=$_GET['altura'];
	$filtro="'".$_GET['filtro']."'";
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=iso-8859-1"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9" />
		<title>:: SPID - Contabilidad</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script>
			function buscacta(e)
			{
				if (document.form2.cuentap.value!="")
				{
					document.form2.bcp.value='1';
					document.form2.submit();
				}
			}
			function validar(){document.form2.submit();}
			function agregardetalle()
			{
				if(document.getElementById('ncuentap').value!="" && document.getElementById('nconcepto').value!="")
				{document.form2.agregadet.value=1;document.form2.submit();}
 				else {despliegamodalm('visible','2','Falta informaci�n para poder Agregar Detalle');}
			}
			function eliminar(variable)
			{
				document.form2.elimina.value=variable;
				despliegamodalm('visible','4','Esta Seguro de Eliminar Detalle','1');
			}
			function guardar()
			{
				var validacion01=document.getElementById('nombre').value;
				if (document.form2.codigo.value!='' && validacion01.trim()!='' && document.getElementById('condeta').value != "0")
 				{despliegamodalm('visible','4','Esta Seguro de Guardar','2')}
 				else{despliegamodalm('visible','2','Faltan datos para completar el registro');}
			}
			function despliegamodal2(_valor)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else 
				{document.getElementById('ventana2').src="contexoconceptos-ventana01.php";}
			}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden")
				{
					document.getElementById('ventanam').src="";
					if (document.getElementById('valfocus').value!="0")
					{
						document.getElementById('valfocus').value='0';
						document.getElementById('cuentap').focus();
						document.getElementById('cuentap').select();
					}
				}
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
			function funcionmensaje(){document.location.href = "cont-codigosint.php";}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.getElementById('oculto').value="6";
								document.form2.submit();break;
					case "2":	document.form2.oculto.value=2;
								document.form2.submit();break;
				}
			}
			function adelante(scrtop, numpag, limreg, filtro)
			{
				var maximo=document.getElementById('maximo').value;
				var actual=document.getElementById('idnum').value;
				actual=parseFloat(actual)+1;
				if(actual<=parseFloat(maximo))
				{
					if(actual<10){actual="0"+actual;}
					location.href="cont-contexoconceptoseditar.php?idr=" +actual+ "&scrtop=" +scrtop+ "&numpag=" +numpag+ "&limreg=" +limreg+ "&filtro=" +filtro;
				}
			}
			function atrasc(scrtop, numpag, limreg, filtro, prev)
			{
				var minimo=document.getElementById('minimo').value;
				var actual=document.getElementById('idnum').value;
				actual=parseFloat(actual)-1;
				if(actual>=parseFloat(minimo))
				{
					if(actual<10){actual="0"+actual;}
					location.href="cont-contexoconceptoseditar.php?idr=" +actual+ "&scrtop=" +scrtop+ "&numpag=" +numpag+ "&limreg=" +limreg+ "&filtro=" +filtro;
				}
			}
			function iratras(scrtop, numpag, limreg, filtro)
			{
				var idcta=document.getElementById('idnum').value;
				location.href="cont-contexoconceptosbuscar.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
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
				<td colspan="3" class="cinta"><img src="imagenes/add2.png" title="Nuevo" onClick="location.href=cont-contexoconceptosagregar.php'" class="mgbt"/><img src="imagenes/guarda.png"  title="Guardar" onClick="guardar();" class="mgbt"/><img src="imagenes/busca.png"  title="Buscar"  onClick="location.href='cont-contexoconceptosbuscar.php'" class="mgbt"/><img src="imagenes/nv.png" title="nueva ventana" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s" onClick="iratras(<?php echo "$scrtop, $numpag, $limreg, $filtro"; ?>)" class="mgbt"/></td>
			</tr>
		</table>
		<div id="bgventanamodalm" class="bgventanamodalm">
			<div id="ventanamodalm" class="ventanamodalm">
				<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
				</IFRAME>
			</div>
		</div>
		<?php
			if ($_GET['idr']!=""){echo "<script>document.getElementById('codrec').value=".$_GET['idr'].";</script>";}
			$sqlr="SELECT MIN(idnum), MAX(idnum) FROM contexoconceptos ORDER BY idnum";
			$res=mysql_query($sqlr,$linkbd);
			$r=mysql_fetch_row($res);
			$_POST['minimo']=$r[0];
			$_POST['maximo']=$r[1];
			if($_POST['oculto']=="")
			{
				if ($_POST['codrec']!="" || $_GET['idr']!="")
				{
					if($_POST['codrec']!="")
					{
						$sqlr="SELECT * FROM contexoformatos WHERE codigo='".$_POST['codrec']."'";

					}
					else
					{
						$sqlr="SELECT * FROM contexoformatos WHERE codigo ='".$_GET['idr']."'";
					}
				}
				else
				{
					$sqlr="SELECT * FROM contexoformatos ORDER BY codigo DESC";
				}
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
				
				
				$_POST['idnum']=$row[0];
				$_POST['codigo']=$row[1];
				$_POST['nombre']=$row[2];
				if(($_POST['oculto']!="2")&&($_POST['oculto']!="6")&&($_POST['oculto']!="7")&&($_POST['oculto']!="1"))
				{
					$sqlr="SELECT * FROM contexoconceptos_det WHERE idnum='".$_POST['idnum']."'";
					$cont=0;
					unset($_POST['dcodigo']);
					unset($_POST['dncuentas']);
					unset($_POST['dconceptos']);
					unset($_POST['dconceptoDian']);
					unset($_POST['dcolumna']);
					$resp = mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($resp))
					{
						$sqlrDian="Select * from contexoconceptosdian_det where estado='S' AND iddet='$row[5]'";
						$respDian = mysql_query($sqlrDian,$linkbd);
						$rowDian =mysql_fetch_row($respDian);

						$sqlrColumna="Select * from contexoformatos_det where estado='S' AND iddet='$row[6]'";
						$respColumna = mysql_query($sqlrColumna,$linkbd);
						$rowColumna =mysql_fetch_row($respColumna);

						$_POST['dcodigo'][$cont]=$row[2];
						$_POST['dncuentas'][$cont]=$row[3];
						$_POST['dconceptos'][$cont]=$row[4];
						$_POST['dconceptoDian'][$cont]=$row[5];
						$_POST['dnconceptoDian'][$cont]=$rowDian[2]." - ".$rowDian[3];
						$_POST['dcolumna'][$cont]=$row[6];
						$_POST['dncolumna'][$cont]=$rowColumna[2]." - ".$rowColumna[3];
						$cont=$cont+1;
					}
					$sqlr="SELECT * FROM contexoconceptos WHERE idnum='".$_POST['idnum']."'";
					$resp = mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($resp))
					{
						$_POST['codigo']=$row[1];
						$_POST['nombre']=$row[2];
					}
				}
			}
		?>
		<form name="form2" method="post" action="">
			<input type="hidden" name="valfocus" id="valfocus" value="1"/>
			<table class="inicio" align="center" >
				<tr >
					<td class="titulos" colspan="4">.: Agregar Conceptos</td>
					<td style="width:7%"><label class="boton02" onClick="location.href='cont-principal.php'">Cerrar</label></td>
				</tr>
				<tr style="height: 35px;">
					<td class="tamano01" style="width:2cm;">C&oacute;digo:</td>
					<td style="width:10%;"><img src="imagenes/back.png" onClick="atrasc(<?php echo "$scrtop, $numpag, $limreg, $filtro"; ?>)" class="icobut" title="Anterior"/>&nbsp;<input type="text" name="codigo" id="codigo" value="<?php echo @ $_POST['codigo'];?>" maxlength="5" style="width:35%;height:35px!important;" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" class="tamano02" readonly/>&nbsp;<img src="imagenes/next.png" onClick="adelante(<?php echo "$scrtop, $numpag, $limreg, $filtro" ?>);" class="icobut" title="Sigiente"/></td>
					<input type="hidden" name="codrec" id="codrec" value="<?php echo @ $_POST['codrec']?>"/>
					<td class="tamano01" style="width:3cm;">Nombre:</td>
					<td><input type="text" name="nombre" id="nombre" value="<?php echo @ $_POST['nombre'];?>" style="width:100%;height:35px!important;" onKeyUp="return tabular(event,this)" class="tamano02" readonly/></td>
				</tr>
			</table>
			<input type="hidden" name="maximo" id="maximo" value="<?php echo @ $_POST['maximo']?>"/>
			<input type="hidden" name="minimo" id="minimo" value="<?php echo @$_POST['minimo']?>"/>
			<input type="hidden" name="oculto" id="oculto" value="1"/>
			<input type="hidden" name="idnum" id="idnum" id="" value="<?php echo @ $_POST['idnum'];?>"/>
			<table class="inicio">
				<tr><td colspan="7" class="titulos">Agregar Cuenta</td></tr>
				<tr style="height: 35px;">
					<td class="tamano01" style="width:10%;">Cuenta: </td>
					<td colspan="1"  valign="middle" style="width:15%;">
					<input type="text" id="cuentap" name="cuentap" class="tamano02" onKeyUp="return tabular(event,this)" value="<?php echo @ $_POST['cuentap']?>" style="background-color:#40f3ff;width:98%;height:35px!important;" title="Doble Click Listado Cuentas" onDblClick="despliegamodal2('visible');" onBlur="buscacta(event)"/></td>
					<td colspan="4"><input type="text" name="ncuentap" id="ncuentap" value="<?php echo @ $_POST['ncuentap'];?>" style="width:100%;height:35px!important;" class="tamano02" readonly/></td>
				</tr>
				<tr style="height: 35px;">
					<td class="tamano01">Tipo Cuenta: </td>
					<td>
						<select name="nconcepto" id="nconcepto" style="width:98%;height: 35px;">
							<option value='' <?php if(@$_POST['nconcepto']==''){echo"SELECTED";}?>>Seleccione ....</option>
							<option value="CREDITO" <?php if(@$_POST['nconcepto']=='CREDITO'){echo"SELECTED";}?>>CREDITO</option>
							<option value="DEBITO" <?php if(@$_POST['nconcepto']=='DEBITO'){echo"SELECTED";}?>>DEBITO</option>
							<option value="SALDO FINAL" <?php if(@$_POST['nconcepto']=='SALDO FINAL'){echo"SELECTED";}?>>SALDO FINAL</option>
						</select>
					</td>
					<td class="tamano01" style="width:10%">Concepto DIAN: </td>
					<td style="width:20%">
						<select name="conceptoDian" id="conceptoDian" style="width:98%;height: 35px;">
							<option value='' <?php if(@$_POST['conceptoDian']==''){echo"SELECTED";}?>>Seleccione ....</option>
							<?php
								$sqlr="Select * from contexoconceptosdian_det where estado='S' AND idnum='$_POST[idnum]' order by concepto";
								$resp = mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($resp))
								{
									$i=$row[0];
									echo "<option value=$row[0] ";
									if($i==$_POST[conceptoDian])
									{
										echo "SELECTED";
										$_POST[nconceptoDian]=$row[2]." - ".$row[3];
									}
									echo " >".$row[2]." - ".$row[3]."</option>";	  
								}		
							?>
						</select>
						<input id="nconceptoDian" name="nconceptoDian" type="hidden" value="<?php echo $_POST[nconceptoDian]?>" >
					</td>
					<td class="tamano01" style="width:10%">Columnas: </td>
					<td style="width:20%">
						<select name="columna" id="columna" style="width:98%;height: 35px;">
							<option value='' <?php if(@$_POST['columna']==''){echo"SELECTED";}?>>Seleccione ....</option>
							<?php
								$sqlr="Select * from contexoformatos_det where estado='S' AND idnum='$_POST[idnum]' order by concepto";
								$resp = mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($resp))
								{
									$i=$row[0];
									echo "<option value=$row[0] ";
									if($i==$_POST[columna])
									{
										echo "SELECTED";
										$_POST[ncolumna]=$row[2]." - ".$row[3];
									}
									echo " >".$row[2]." - ".$row[3]."</option>";	  
								}		
							?>
						</select>
						<input id="ncolumna" name="ncolumna" type="hidden" value="<?php echo $_POST[ncolumna]?>" >
					</td>
					<td style="padding-bottom:0px"><em class="botonflecha" onClick="agregardetalle()">Agregar</em></td>
				</tr>
				<input type="hidden" name="agregadet" value="0"/>
				<input type="hidden" name="bcp" id="bcp" value=""/>
			</table>
			<?php
				//**** busca cuenta
				if($_POST[bcp]!='')
				{
					$nresul=buscacuenta($_POST[cuentap]);
					if($nresul!='')
					{
						echo"
							<script>
								document.getElementById('bcp').value='';
								document.getElementById('ncuentap').value='$nresul';
								document.getElementById('concecont').focus();
							</script>";
					}
					else
					{

						echo "
							<script>
								document.getElementById('ncuentap').value='';
								document.getElementById('valfocus').value='3';
								despliegamodalm('visible','2','Cuenta Incorrecta');
							</script>";
					}
				}
			?>
			<div class="subpantalla" style="height:40.5%; width:99.5%;overflow-x:hidden;">
				<table class="inicio">
					<tr><td class="titulos" colspan="7">Detalle C&oacute;digo - Variable de Pago</td></tr>
					<tr>
						<td class="titulos2" style="width:5%;">Item</td>
						<td class="titulos2" style="width:15%;">Cuenta</td>
						<td class="titulos2">Descripci&oacute;n</td>
						<td class="titulos2">Concepto DIAN</td>
						<td class="titulos2">Columnas</td>
						<td class="titulos2" style="width:10%;">Tipo Cuenta</td>
						<td class="titulos2" style="width:3%;text-align:center;"><img src="imagenes/del.png"/></td>
					</tr>
					<input type='hidden' name='elimina' id='elimina'>
					<?php
						if ($_POST['oculto']=='6')
						{ 
							$posi=$_POST['elimina'];
							unset($_POST['dcodigo'][$posi]);
							unset($_POST['dncuentas'][$posi]);
							unset($_POST['dconceptoDian'][$posi]);
							unset($_POST['dnconceptoDian'][$posi]);
							unset($_POST['dcolumna'][$posi]);
							unset($_POST['dncolumna'][$posi]);
							unset($_POST['dconceptos'][$posi]);
							$_POST['dcodigo']= array_values($_POST['dcodigo']);
							$_POST['dncuentas']= array_values($_POST['dncuentas']);
							$_POST['dconceptoDian']= array_values($_POST['dconceptoDian']);
							$_POST['dnconceptoDian']= array_values($_POST['dnconceptoDian']);
							$_POST['dcolumna']= array_values($_POST['dcolumna']);
							$_POST['dncolumna']= array_values($_POST['dncolumna']);
							$_POST['dconceptos']= array_values($_POST['dconceptos']);
						}
						if ($_POST['agregadet']=='1')
						{
							$_POST['dcodigo'][]=$_POST['cuentap'];
							$_POST['dncuentas'][]=$_POST['ncuentap'];
							$_POST['dconceptoDian'][]=$_POST['conceptoDian'];
							$_POST['dnconceptoDian'][]=$_POST['nconceptoDian'];
							$_POST['dcolumna'][]=$_POST['columna'];
							$_POST['dncolumna'][]=$_POST['ncolumna'];
							$_POST['dconceptos'][]=$_POST['nconcepto'];
							$_POST['agregadet']=0;
							echo"
								<script>
									document.form2.cuentap.value='';
									document.form2.ncuentap.value='';
									document.form2.conceptoDian.value='';
									document.form2.nconceptoDian.value='';
									document.form2.columna.value='';
									document.form2.ncolumna.value='';
									document.form2.nconcepto.value='';
							</script>";
						}
						$iter='saludo1a';
						$iter2='saludo2';
						$cdtll=count($_POST['dcodigo']);
						$_POST['condeta']=$cdtll;
						for ($x=0;$x< $cdtll;$x++)
						{
							echo "
							<input type='hidden' name='dcodigo[]' value='".$_POST['dcodigo'][$x]."'/>
							<input type='hidden' name='dncuentas[]' value='".$_POST['dncuentas'][$x]."'/>
							<input type='hidden' name='dconceptoDian[]' value='".$_POST['dconceptoDian'][$x]."'/>
							<input type='hidden' name='dnconceptoDian[]' value='".$_POST['dnconceptoDian'][$x]."'/>
							<input type='hidden' name='dcolumna[]' value='".$_POST['dcolumna'][$x]."'/>
							<input type='hidden' name='dncolumna[]' value='".$_POST['dncolumna'][$x]."'/>
							<input type='hidden' name='dconceptos[]' value='".$_POST['dconceptos'][$x]."'/>
							<tr class='$iter'>
								<td>".($x+1)."</td>
								<td>".$_POST['dcodigo'][$x]."</td>
								<td>".$_POST['dncuentas'][$x]."</td>
								<td>".$_POST['dnconceptoDian'][$x]."</td>
								<td>".$_POST['dncolumna'][$x]."</td>
								<td>".$_POST['dconceptos'][$x]."</td>
								<td style='text-align:center;'><img src='imagenes/del.png' onclick='eliminar($x)' class='icomen1'/></td>
							</tr>";
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux;
						}
					?>
					<tr></tr>
				</table>	
			</div>
			<input type="hidden" name="condeta" id="condeta" value="<?php echo $_POST['condeta'];?>"/>
			<?php
				$oculto=$_POST['oculto'];
				if($_POST['oculto']=='2')
				{
					if ($_POST['nombre']!="")
					{
						//$sqlrDelete = "DELETE FROM contexoconceptos WHERE codigo='".$_POST['idnum']."'";
						//mysql_query($sqlrDelete,$linkbd);
						//$sqlr="INSERT INTO contexoconceptos (idnum,codigo,nombre,estado) VALUES ('".$_POST['idnum']."','".$_POST['codigo']."','".iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$_POST['nombre'])."','S')";

						//$sqlr="UPDATE contexoconceptos SET nombre='".iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$_POST['nombre'])."' WHERE idnum = '".$_POST['idnum']."'";

						$sqlr="DELETE FROM contexoconceptos_det WHERE idnum='".$_POST['idnum']."'";
						mysql_query($sqlr,$linkbd);
						for($x=0;$x<count($_POST['dcodigo']);$x++)
						{
							$niddet=selconsecutivo('contexoconceptos_det','iddet');
							$sqlr="INSERT INTO contexoconceptos_det (iddet,idnum,cuenta,descipcion,tipo,concepto,columna,estado)VALUES ('$niddet','".$_POST['idnum']."','".$_POST['dcodigo'][$x]."','".$_POST['dncuentas'][$x]."', '".$_POST['dconceptos'][$x]."','".$_POST['dconceptoDian'][$x]."','".$_POST['dcolumna'][$x]."','S')";
							if (!mysql_query($sqlr,$linkbd))
							{
								echo "<script>despliegamodalm('visible','2','Manejador de Errores de la Clase BD contcodigosinternos_det, No se pudo ejecutar la petici�n');</script>";
							}
							else{echo "<script>despliegamodalm('visible','3','Se ha almacenado la Variable con Exito');</script>";}
						}//***** fin del for	
						
					}
					else {echo "<script>despliegamodalm('visible','2','Falta informacion para Crear la Variable');</script>";}
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
