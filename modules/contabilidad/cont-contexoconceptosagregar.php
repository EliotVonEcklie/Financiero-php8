<?php
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=iso-8859-1");
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	date_default_timezone_set("America/Bogota");
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
			function buscactap(e)
			{
				if (document.form2.cuentap.value!="")
				{
					document.form2.bcp.value='1';
					document.form2.submit();
				}
			}
			function buscacodigos(e)
			{
				if (document.form2.codigo.value!="")
				{
					document.form2.buscodi.value='1';
					document.form2.submit();
				}
			}
			function validar(){document.form2.submit();}
			function agregardetalle()
			{
				if(document.getElementById('ncuentap').value!="" && document.getElementById('nconcepto').value!="")
				{document.form2.agregadet.value=1;document.form2.submit();}
 				else {despliegamodalm('visible','2','Falta información para poder Agregar Detalle');}
			}
			function eliminar(variable)
			{
				document.form2.elimina.value=variable;
				despliegamodalm('visible','4','Esta Seguro de Eliminar Detalle','1');
			}
			function guardar()
			{
				var validacion01=document.getElementById('nombre').value;
				if (document.form2.codigo.value!='' && validacion01.trim()!='' )
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
					{	if (document.getElementById('valfocus').value==11)
						{
							document.getElementById('valfocus').value='0';
							document.getElementById('codigo').focus();
							document.getElementById('codigo').select();
						}
						else
						{
						document.getElementById('valfocus').value='0';
						document.getElementById('cuentap').focus();
						document.getElementById('cuentap').select();
						}
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
			function funcionmensaje(){document.location.href = "cont-contexoconceptosagregar.php";}
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
				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='cont-contexoconceptosagregar.php'" class="mgbt"/><img src="imagenes/guarda.png"  title="Guardar" onClick="guardar();" class="mgbt"/><img src="imagenes/busca.png"  title="Buscar" onClick="location.href='cont-contexoconceptosbuscar.php'" class="mgbt"/><img src="imagenes/nv.png" title="nueva ventana" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();" class="mgbt"></td>
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
				if($_POST['oculto']==""){$_POST['condeta']="0";}
				if(!$_POST['oculto'])
				{
					$_POST['idnum']=$_POST['codigo']=selconsecutivo('contexoconceptos','idnum');
					if(strlen($_POST['codigo'])==1){$_POST['codigo']='0'.$_POST['codigo'];}
				}
				
			?>
			<input type="hidden" name="valfocus" id="valfocus" value="1"/>
			<table class="inicio" align="center" >
				<tr >
					<td class="titulos" colspan="10">.: Agregar Conceptos</td>
					<td style="width:7%"><label class="boton02" onClick="location.href='cont-principal.php'">Cerrar</label></td>
				</tr>
				<tr style="height: 35px;">
					<td class="tamano01" style="width:3cm;">C&oacute;digo:</td>
					<td style="width:5%;"><input type="text" name="codigo" id="codigo" value="<?php echo @ $_POST['codigo'];?>" maxlength="5" style="width:98%;height:35px!important;" onKeyUp="return tabular(event,this)" class="tamano02" onBlur="buscacodigos(event)"/></td>
					<td class="tamano01" style="width:4cm;">Nombre:</td>
					<td colspan="7"><input type="text" name="nombre" id="nombre" value="<?php echo @ $_POST['nombre'];?>" style="width:100%;height:35px!important;" onKeyUp="return tabular(event,this)" class="tamano02"/></td>
				</tr>
			</table>
			<input type="hidden" name="oculto" id="oculto" value="1"/>
			<input type="hidden" name="idnum" id="idnum" id="" value="<?php echo @ $_POST['idnum'];?>"/>
			<table class="inicio">
				<tr><td colspan="6" class="titulos">Agregar Cuenta</td></tr>
				<tr style="height: 35px;">
					<td class="tamano01" style="width:10%;">Cuenta: </td>
					<td colspan="1"  valign="middle" style="width:15%;"><input type="text" id="cuentap" name="cuentap" class="tamano02" onKeyUp="return tabular(event,this)" value="<?php echo @ $_POST['cuentap']?>" style="background-color:#40f3ff;width:98%;height:35px!important;" title="Doble Click Listado Cuentas" onDblClick="despliegamodal2('visible');"/></td>
					<td><input type="text" name="ncuentap" id="ncuentap" value="<?php echo @ $_POST['ncuentap'];?>" style="width:100%;height:35px!important;" class="tamano02" readonly/></td>
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
					<td style="padding-bottom:0px"><em class="botonflecha" onClick="agregardetalle()">Agregar</em></td>
				</tr>
				<input type="hidden" name="agregadet" value="0"/>
				<input type="hidden" name="bcp" id="bcp" value=""/>
				<input type="hidden" name="buscodi" id="buscodi" value=""/>				
			</table>
			<?php
				//**** busca cuenta
				if($_POST['buscodi']!='')//Busca si hay codigo duplicado
				{
					$sqlr="SELECT codigo FROM contexoconceptos";
					$resp = mysql_query($sqlr,$linkbd);
					$x=0;
					while ($row =mysql_fetch_row($resp))
					{
						$temparray[]= $row[0];
						$x++;
					}
					$repetido=esta_en_array($temparray,$_POST['codigo']);
					if ($repetido==1)
					{
						
						echo "
						<script>
							document.getElementById('valfocus').value='11';
							document.getElementById('buscodi').value='';
							document.getElementById('codigo').value='';
							despliegamodalm('visible','2','Codigo No ".$_POST['codigo']." Duplicado');
						</script>";
					}
				}
				if($_POST[bcp]!='')
				{
					$nresul=buscacuentapres($_POST[cuentap],2);
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
						echo "<script>document.getElementById('valfocus').value='3';despliegamodalm('visible','2','Cuenta Incorrecta');</script>";
					}
				}
			?>
			<div class="subpantalla" style="height:46.5%; width:99.5%;overflow-x:hidden;">
				<table class="inicio">
					<tr><td class="titulos" colspan="7">Detalle Concepto - Cuentas</td></tr>
					<tr>
						<td class="titulos2" style="width:5%;">Item</td>
						<td class="titulos2" style="width:15%;">Cuenta</td>
						<td class="titulos2">Descripci&oacute;n</td>
						<td class="titulos2" style="width:10%;">Tipo de Cuenta</td>
						<td class="titulos2" style="width:3%;text-align:center;"><img src="imagenes/del.png"/></td>
					</tr>
					<input type='hidden' name='elimina' id='elimina'>
					<?php
						if ($_POST['oculto']=='6')
						{ 
							$posi=$_POST['elimina'];
							unset($_POST['dcodigo'][$posi]);
							unset($_POST['dncuentas'][$posi]);
							unset($_POST['dconceptos'][$posi]);
							$_POST['dcodigo']= array_values($_POST['dcodigo']);
							$_POST['dncuentas']= array_values($_POST['dncuentas']);
							$_POST['dconceptos']= array_values($_POST['dconceptos']);
						}
						if ($_POST['agregadet']=='1')
						{
							$_POST['dcodigo'][]=$_POST['cuentap'];
							$_POST['dncuentas'][]=$_POST['ncuentap'];
							$_POST['dconceptos'][]=$_POST['nconcepto'];
							$_POST['agregadet']=0;
							echo"
							<script>
								document.form2.cuentap.value='';
								document.form2.ncuentap.value='';
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
							<input type='hidden' name='dcodigo[]' value='".$_POST[dcodigo][$x]."'/>
							<input type='hidden' name='dncuentas[]' value='".$_POST[dncuentas][$x]."'/>
							<input type='hidden' name='dconceptos[]' value='".$_POST[dconceptos][$x]."'/>
							<tr class='$iter'>
								<td>".($x+1)."</td>
								<td>".$_POST[dcodigo][$x]."</td>
								<td>".$_POST[dncuentas][$x]."</td>
								<td>".$_POST[dconceptos][$x]."</td>
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
						
						$_POST['idnum']=$_POST['codigo']=selconsecutivo('contexoconceptos','idnum');
						$sqlr="INSERT INTO contexoconceptos (idnum,codigo,nombre,estado) VALUES ('".$_POST['idnum']."','".$_POST['codigo']."','".iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$_POST['nombre'])."','S')";
						if (!mysql_query($sqlr,$linkbd))
						{
							echo "<script>despliegamodalm('visible','2','Manejador de Errores de la Clase BD contexoconceptos, No se pudo ejecutar la petición');</script>";
						}
						else
						{
							for($x=0;$x<count($_POST['dcodigo']);$x++)
							{
								$niddet=selconsecutivo('contexoconceptos_det','iddet');
								$sqlr="INSERT INTO contexoconceptos_det (iddet,idnum,cuenta,descipcion,tipo,estado)VALUES ('$niddet','".$_POST['idnum']."','".$_POST['dcodigo'][$x]."','".$_POST['dncuentas'][$x]."', '".$_POST['dconceptos'][$x]."','S')";
								if (!mysql_query($sqlr,$linkbd))
								{
									echo "<script>despliegamodalm('visible','2','Manejador de Errores de la Clase BD contexoconceptos_det, No se pudo ejecutar la petición');</script>";
								}
								else{echo "<script>despliegamodalm('visible','1','Se ha almacenado la Variable con Exito');</script>";}
							}//***** fin del for	
							if(count($_POST['dcodigo'])==0){echo "<script>despliegamodalm('visible','1','Se ha almacenado la Variable con Exito');</script>";}
						}
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