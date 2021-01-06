<?php
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=iso-8859-1");
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_v7();
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	date_default_timezone_set("America/Bogota");
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=iso-8859-1"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Ideal.10 - Servicios P&uacute;blicos</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css4.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js"></script>
		<script>
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
			function funcionmensaje(){document.location.href = "serv-tasainteres.php";}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":
						document.form2.oculto.value='2';
						document.form2.submit();
						break;
					case "2":
						document.form2.oculto.value="3";
						document.form2.submit();
						break;
				}
			}
			function guardar()
			{
				var valc01=document.getElementById('incopri').value;
				var valc02=document.getElementById('incoseg').value;
				var valc03=document.getElementById('incoter').value;
				var valc04=document.getElementById('incocua').value;
				var valc05=document.getElementById('incoqui').value;
				var valc06=document.getElementById('incosex').value;
				var valc07=document.getElementById('incosep').value;
				var valc08=document.getElementById('incooct').value;
				var valc09=document.getElementById('inconov').value;
				var valc10=document.getElementById('incodec').value;
				var valc11=document.getElementById('incoonc').value;
				var valc12=document.getElementById('incodoc').value;
				var valm01=document.getElementById('incopri').value;
				var valm02=document.getElementById('incoseg').value;
				var valm03=document.getElementById('incoter').value;
				var valm04=document.getElementById('incocua').value;
				var valm05=document.getElementById('incoqui').value;
				var valm06=document.getElementById('incosex').value;
				var valm07=document.getElementById('incosep').value;
				var valm08=document.getElementById('incooct').value;
				var valm09=document.getElementById('inconov').value;
				var valm10=document.getElementById('incodec').value;
				var valm11=document.getElementById('incoonc').value;
				var valm12=document.getElementById('incodoc').value;
				if (valc01.trim()!='' && valc02.trim()!='' && valc03.trim()!='' && valc04.trim()!='' && valc05.trim()!='' && valc06.trim()!='' && valc07.trim()!='' && valc08.trim()!='' && valc09.trim()!='' && valc10.trim()!='' && valc11.trim()!='' && valc12.trim()!='' && valm01.trim()!='' && valm02.trim()!='' && valm03.trim()!='' && valm04.trim()!='' && valm05.trim()!='' && valm06.trim()!='' && valm07.trim()!='' && valm08.trim()!='' && valm09.trim()!='' && valm10.trim()!='' && valm11.trim()!='' && valm12.trim()!='')
				{despliegamodalm('visible','4','Esta Seguro de Agregar las Tasas de Interes','1');}
				else {despliegamodalm('visible','2','No puede dejar campos nulos para Agregar las Tasa de Interes');}
			}
			function cambiovigencia()
			{
				despliegamodalm('visible','4','Esta Seguro cambiar de vigencia, los datos que no se guardaron se perderan','2');
			}
		</script>
		<?php 
			titlepag();
			function imgresobase($mes,$vigencia,$porcentaje,$tipo)
			{
				$linkbd=conectar_v7();
				$sqlr="SELECT MAX(id) FROM srvtasa_interes WHERE mes = '$mes'AND estado = 'S' AND vigencia = '$vigencia' AND tipo = '$tipo'";
				$resp = mysqli_query($linkbd,$sqlr);
				$row =mysqli_fetch_row($resp);
				if($row[0]!='')
				{
					$sqlup ="UPDATE srvtasa_interes SET estado='N' WHERE id='$row[0]'";
					mysqli_query($linkbd,$sqlup);
				}
				$codid=selconsecutivo('srvtasa_interes','id');
				$sqlup="INSERT INTO srvtasa_interes (id,vigencia,mes,porcentaje,tipo,estado) VALUES ('$codid','$vigencia','$mes','$porcentaje','$tipo','S')";
				mysqli_query($linkbd,$sqlup);
			}
		?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("serv");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("serv");?></tr>
			<tr>
				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='serv-tasainteres.php'" class="mgbt"/><img src="imagenes/guarda.png" onClick="guardar();" class="mgbt"/><img src="imagenes/busca.png" onClick="location.href='serv-tasainteresbuscar.php'" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" onClick="<?php echo paginasnuevas("serv");?>" class="mgbt"></td>
			</tr>
		</table>
		<div id="bgventanamodalm" class="bgventanamodalm">
			<div id="ventanamodalm" class="ventanamodalm">
				<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"></IFRAME>
			</div>
		</div>
		<form name="form2" method="post" action="">
			<?php
				if(@ $_POST['oculto']==""){$_POST['vigenciat']=date('Y');}
				if(@ $_POST['oculto']=="" || @ $_POST['oculto']=='3')
				{
					//INTERESES CORRIENTES
					$_POST['incopri']=$_POST['incoseg']=$_POST['incoter']=$_POST['incocua']=$_POST['incoqui']=$_POST['incosex']="0";
					$_POST['incosep']=$_POST['incooct']=$_POST['inconov']=$_POST['incodec']=$_POST['incoonc']=$_POST['incodoc']="0";
					$_POST['incopric']=$_POST['incosegc']=$_POST['incoterc']=$_POST['incocuac']=$_POST['incoquic']=$_POST['incosexc']="0";
					$_POST['incosepc']=$_POST['incooctc']=$_POST['inconovc']=$_POST['incodecc']=$_POST['incooncc']=$_POST['incodocc']="0";
					//INTERESES MORATORIOS
					$_POST['inmopri']=$_POST['inmoseg']=$_POST['inmoter']=$_POST['inmocua']=$_POST['inmoqui']=$_POST['inmosex']="0";
					$_POST['inmosep']=$_POST['inmooct']=$_POST['inmonov']=$_POST['inmodec']=$_POST['inmoonc']=$_POST['inmodoc']="0";
					$_POST['inmopric']=$_POST['inmosegc']=$_POST['inmoterc']=$_POST['inmocuac']=$_POST['inmoquic']=$_POST['inmosexc']="0";
					$_POST['inmosepc']=$_POST['inmooctc']=$_POST['inmonovc']=$_POST['inmodecc']=$_POST['inmooncc']=$_POST['inmodocc']="0";
					$sqlr="SELECT id,mes,porcentaje,tipo FROM srvtasa_interes WHERE estado='S' AND vigencia='".$_POST['vigenciat']."' ORDER BY mes ASC, id DESC";
					$resp = mysqli_query($linkbd,$sqlr);
					while ($row =mysqli_fetch_row($resp))
					{
						switch($row[1])
						{
							case 1:
							{
								if($row[3]=='C'){$_POST['incopri']=$_POST['incopric']=$row[2];}
								elseif($row[3]=='M'){$_POST['inmopri']=$_POST['inmopric']=$row[2];}
							}break;
							case 2:
							{
								if($row[3]=='C'){$_POST['incoseg']=$_POST['incosegc']=$row[2];}
								elseif($row[3]=='M'){$_POST['inmoseg']=$_POST['inmosegc']=$row[2];}
							}break;
							case 3:
							{
								if($row[3]=='C'){$_POST['incoter']=$_POST['incoterc']=$row[2];}
								elseif($row[3]=='M'){$_POST['inmoter']=$_POST['inmoterc']=$row[2];}
							}break;
							case 4:
							{
								if($row[3]=='C'){$_POST['incocua']=$_POST['incocuac']=$row[2];}
								elseif($row[3]=='M'){$_POST['inmocua']=$row[2];}
							}break;
							case 5:
							{
								if($row[3]=='C'){$_POST['incoqui']=$_POST['incoquic']=$row[2];}
								elseif($row[3]=='M'){$_POST['inmoqui']=$_POST['inmoquic']=$row[2];}
							}break;
							case 6:
							{
								if($row[3]=='C'){$_POST['incosex']=$_POST['incosexc']=$row[2];}
								elseif($row[3]=='M'){$_POST['inmosex']=$_POST['inmosexc']=$row[2];}
							}break;
							case 7:
							{
								if($row[3]=='C'){$_POST['incosep']=$_POST['incosepc']=$row[2];}
								elseif($row[3]=='M'){$_POST['inmosep']=$_POST['inmosepc']=$row[2];}
							}break;
							case 8:
							{
								if($row[3]=='C'){$_POST['incooct']=$_POST['incooctc']=$row[2];}
								elseif($row[3]=='M'){$_POST['inmooct']=$_POST['inmooctc']=$row[2];}
							}break;
							case 9:
							{
								if($row[3]=='C'){$_POST['inconov']=$_POST['inconovc']=$row[2];}
								elseif($row[3]=='M'){$_POST['inmonov']=$_POST['inmonovc']=$row[2];}
							}break;
							case 10:
							{
								if($row[3]=='C'){$_POST['incodec']=$_POST['incodecc']=$row[2];}
								elseif($row[3]=='M'){$_POST['inmodec']=$_POST['inmodecc']=$row[2];}
							}break;
							case 11:
							{
								if($row[3]=='C'){$_POST['incoonc']=$_POST['incooncc']=$row[2];}
								elseif($row[3]=='M'){$_POST['inmoonc']=$_POST['inmooncc']=$row[2];}
							}break;
							case 12:
							{
								if($row[3]=='C'){$_POST['incodoc']=$_POST['incodocc']=$row[2];}
								elseif($row[3]=='M'){$_POST['inmodoc']=$_POST['inmodocc']=$row[2];}
							}break;
						}
					}
				}
			?>
			<table class="inicio ancho">
				<tr>
					<td class="titulos" colspan="11">.: Ingresar Tasa de Interes</td>
					<td class="cerrar" style="width:7%" onClick="location.href='serv-principal.php'">Cerrar</td>
				</tr>
				<tr>
					<td class="tamano01" style="width:2cm;">Vigencia:</td>
					<td>
						<select name="vigenciat" id="vigenciat" style="width:100%;" onChange="cambiovigencia();">
							<?php
							$anini=2050;
							for($y=0;$y<100;$y++)
							{
								$anfin=$anini-$y;
								if($anfin==$_POST['vigenciat']){echo "<option value='$anfin' SELECTED>$anfin</option>";}
								else {echo "<option value='$anfin'>$anfin</option>";}
							}
							?>
						</select>
					</td>
				</tr>
				<tr><td colspan="12" class="titulos">Intereses Corrientes</td></tr>
				<tr>
					<td class="saludo1" style="width: 6% !important">Enero:</td>
					<td style="width: 6% !important"><input type="text" id="incopri" name="incopri" value="<?php echo @ $_POST['incopri']?>" onKeyUp="return tabular(event,this)" onKeyPress="javascript:return solonumeros(event)" style="width: 80%"/>&nbsp;%</td>
					<td class="saludo1" style="width: 6% !important">Febrero:</td>
					<td style="width: 6% !important"><input type="text" id="incoseg" name="incoseg" value="<?php echo @ $_POST['incoseg']?>" onKeyUp="return tabular(event,this)" onKeyPress="javascript:return solonumeros(event)" style="width: 80%"/>&nbsp;%</td>
					<td style="width: 6% !important" class="saludo1">Marzo:</td>
					<td style="width: 6% !important"><input type="text" id="incoter" name="incoter" value="<?php echo @ $_POST['incoter']?>" onKeyUp="return tabular(event,this)" onKeyPress="javascript:return solonumeros(event)" style="width: 80%"/>&nbsp;%</td>
					<td style="width: 6% !important" class="saludo1">Abril:</td>
					<td style="width: 6% !important"><input type="text" id="incocua" name="incocua" value="<?php echo @ $_POST['incocua']?>" onKeyUp="return tabular(event,this)" onKeyPress="javascript:return solonumeros(event)" style="width: 80%"/>&nbsp;%</td>
					<td style="width: 6% !important" class="saludo1">Mayo:</td>
					<td style="width: 6% !important"><input type="text" id="incoqui" name="incoqui" value="<?php echo @ $_POST['incoqui']?>" onKeyUp="return tabular(event,this)" onKeyPress="javascript:return solonumeros(event)" style="width: 80%"/>&nbsp;%</td>
					<td style="width: 6% !important" class="saludo1" >Junio:</td>
					<td style="width: 6% !important"><input type="text" id="incosex" name="incosex" value="<?php echo @ $_POST['incosex']?>" onKeyUp="return tabular(event,this)" onKeyPress="javascript:return solonumeros(event)" style="width: 80%"/>&nbsp;%</td>
				</tr>
				<tr>
					<td class="saludo1">Julio:</td>
					<td style="width: 6% !important"><input type="text" id="incosep" name="incosep" value="<?php echo @ $_POST['incosep']?>" onKeyUp="return tabular(event,this)" onKeyPress="javascript:return solonumeros(event)" style="width: 80%"/>&nbsp;%</td>
					<td class="saludo1">Agosto:</td>
					<td style="width: 6% !important"><input type="text" id="incooct" name="incooct" value="<?php echo @ $_POST['incooct']?>" onKeyUp="return tabular(event,this)" onKeyPress="javascript:return solonumeros(event)" style="width: 80%"/>&nbsp;%</td>
					<td class="saludo1">Septiembre:</td>
					<td style="width: 6% !important"><input type="text" id="inconov" name="inconov" value="<?php echo @ $_POST['inconov']?>" onKeyUp="return tabular(event,this)" onKeyPress="javascript:return solonumeros(event)" style="width: 80%"/>&nbsp;%</td>
					<td class="saludo1">Octubre:</td>
					<td style="width: 6% !important"><input type="text" id="incodec" name="incodec" value="<?php echo @ $_POST['incodec']?>" onKeyUp="return tabular(event,this)" onKeyPress="javascript:return solonumeros(event)" style="width: 80%"/>&nbsp;%</td>
					<td class="saludo1">Noviembre:</td>
					<td style="width: 6% !important"><input type="text" id="incoonc" name="incoonc" value="<?php echo @ $_POST['incoonc']?>" onKeyUp="return tabular(event,this)" onKeyPress="javascript:return solonumeros(event)" style="width: 80%"/>&nbsp;%</td>
					<td class="saludo1">Diciembre:</td>
					<td style="width: 6% !important"><input type="text" id="incodoc" name="incodoc" value="<?php echo @ $_POST['incodoc']?>" onKeyUp="return tabular(event,this)" onKeyPress="javascript:return solonumeros(event)" style="width: 80%"/>&nbsp;%</td>
				</tr>
				<tr><td colspan="12" class="titulos">Intereses Moratorios</td></tr>
				<tr>
					<td class="saludo1" style="width: 6% !important">Enero:</td>
					<td><input type="text" id="inmopri" name="inmopri" value="<?php echo @ $_POST['inmopri']?>" onKeyUp="return tabular(event,this)" onKeyPress="javascript:return solonumeros(event)" style="width: 80%"/>&nbsp;%</td>
					<td class="saludo1" style="width: 6% !important">Febrero:</td>
					<td><input type="text" id="inmoseg" name="inmoseg" value="<?php echo @ $_POST['inmoseg']?>" onKeyUp="return tabular(event,this)" onKeyPress="javascript:return solonumeros(event)" style="width: 80%"/>&nbsp;%</td>
					<td class="saludo1" style="width: 6% !important">Marzo:</td>
					<td><input type="text" id="inmoter" name="inmoter" value="<?php echo @ $_POST['inmoter']?>" onKeyUp="return tabular(event,this)" onKeyPress="javascript:return solonumeros(event)" style="width: 80%"/>&nbsp;%</td>
					<td class="saludo1" style="width: 6% !important">Abril:</td>
					<td><input type="text" id="inmocua" name="inmocua" value="<?php echo @ $_POST['inmocua']?>" onKeyUp="return tabular(event,this)" onKeyPress="javascript:return solonumeros(event)" style="width: 80%"/>&nbsp;%</td>
					<td class="saludo1" style="width: 6% !important">Mayo:</td>
					<td><input type="text" id="inmoqui" name="inmoqui" value="<?php echo @ $_POST['inmoqui']?>" onKeyUp="return tabular(event,this)" onKeyPress="javascript:return solonumeros(event)" style="width: 80%"/>&nbsp;%</td>
					<td class="saludo1" style="width: 6% !important">Junio:</td>
					<td><input type="text" id="inmosex" name="inmosex" value="<?php echo @ $_POST['inmosex']?>" onKeyUp="return tabular(event,this)" onKeyPress="javascript:return solonumeros(event)" style="width: 80%"/>&nbsp;%</td>
				</tr>
				<tr>
					<td class="saludo1">Julio:</td>
					<td><input type="text" id="inmosep" name="inmosep" value="<?php echo @ $_POST['inmosep']?>" onKeyUp="return tabular(event,this)" onKeyPress="javascript:return solonumeros(event)" style="width: 80%"/>&nbsp;%</td>
					<td class="saludo1">Agosto:</td>
					<td><input type="text" id="inmooct" name="inmooct" value="<?php echo @ $_POST['inmooct']?>" onKeyUp="return tabular(event,this)" onKeyPress="javascript:return solonumeros(event)" style="width: 80%"/>&nbsp;%</td>
					<td class="saludo1">Septiembre:</td>
					<td><input type="text" id="inmonov" name="inmonov" value="<?php echo @ $_POST['inmonov']?>" onKeyUp="return tabular(event,this)" onKeyPress="javascript:return solonumeros(event)" style="width: 80%"/>&nbsp; %</td>
					<td class="saludo1">Octubre:</td>
					<td><input type="text" id="inmodec" name="inmodec" value="<?php echo @ $_POST['inmodec']?>" onKeyUp="return tabular(event,this)" onKeyPress="javascript:return solonumeros(event)" style="width: 80%"/>&nbsp;%</td>
					<td class="saludo1">Noviembre:</td>
					<td><input type="text" id="inmoonc" name="inmoonc" value="<?php echo @ $_POST['inmoonc']?>" onKeyUp="return tabular(event,this)" onKeyPress="javascript:return solonumeros(event)" style="width: 80%"/>&nbsp;%</td>
					<td class="saludo1">Diciembre:</td>
					<td><input type="text" id="inmodoc" name="inmodoc" value="<?php echo @ $_POST['inmodoc']?>" onKeyUp="return tabular(event,this)"  onKeyPress="javascript:return solonumeros(event)" style="width: 80%"/>&nbsp;%</td>
				</tr>
			</table>
			<!--variables auxiliares intereses corrientes-->
			<input type="hidden" id="incopric" name="incopric" value="<?php echo @ $_POST['incopric']?>"/>
			<input type="hidden" id="incosegc" name="incosegc" value="<?php echo @ $_POST['incosegc']?>"/>
			<input type="hidden" id="incoterc" name="incoterc" value="<?php echo @ $_POST['incoterc']?>"/>
			<input type="hidden" id="incocuac" name="incocuac" value="<?php echo @ $_POST['incocuac']?>"/>
			<input type="hidden" id="incoquic" name="incoquic" value="<?php echo @ $_POST['incoquic']?>"/>
			<input type="hidden" id="incosexc" name="incosexc" value="<?php echo @ $_POST['incosexc']?>"/>
			<input type="hidden" id="incosepc" name="incosepc" value="<?php echo @ $_POST['incosepc']?>"/>
			<input type="hidden" id="incooctc" name="incooctc" value="<?php echo @ $_POST['incooctc']?>"/>
			<input type="hidden" id="inconovc" name="inconovc" value="<?php echo @ $_POST['inconovc']?>"/>
			<input type="hidden" id="incodecc" name="incodecc" value="<?php echo @ $_POST['incodecc']?>"/>
			<input type="hidden" id="incooncc" name="incooncc" value="<?php echo @ $_POST['incooncc']?>"/>
			<input type="hidden" id="incodocc" name="incodocc" value="<?php echo @ $_POST['incodocc']?>"/>
			<!--variables auxiliares intereses moratorios-->
			<input type="hidden" id="inmopric" name="inmopric" value="<?php echo @ $_POST['inmopric']?>"/>
			<input type="hidden" id="inmosegc" name="inmosegc" value="<?php echo @ $_POST['inmosegc']?>"/>
			<input type="hidden" id="inmoterc" name="inmoterc" value="<?php echo @ $_POST['inmoterc']?>"/>
			<input type="hidden" id="inmocuac" name="inmocuac" value="<?php echo @ $_POST['inmocuac']?>"/>
			<input type="hidden" id="inmoquic" name="inmoquic" value="<?php echo @ $_POST['inmoquic']?>"/>
			<input type="hidden" id="inmosexc" name="inmosexc" value="<?php echo @ $_POST['inmosexc']?>"/>
			<input type="hidden" id="inmosepc" name="inmosepc" value="<?php echo @ $_POST['inmosepc']?>"/>
			<input type="hidden" id="inmooctc" name="inmooctc" value="<?php echo @ $_POST['inmooctc']?>"/>
			<input type="hidden" id="inmonovc" name="inmonovc" value="<?php echo @ $_POST['inmonovc']?>"/>
			<input type="hidden" id="inmodecc" name="inmodecc" value="<?php echo @ $_POST['inmodecc']?>"/>
			<input type="hidden" id="inmooncc" name="inmooncc" value="<?php echo @ $_POST['inmooncc']?>"/>
			<input type="hidden" id="inmodocc" name="inmodocc" value="<?php echo @ $_POST['inmodocc']?>"/>
			<?php
				if(@ $_POST['oculto']=="2")
				{
					//ntereses corrientes
					if($_POST['incopri']!=$_POST['incopric']){imgresobase('1',$_POST['vigenciat'],$_POST['incopri'],'C');}
					if($_POST['incoseg']!=$_POST['incosegc']){imgresobase('2',$_POST['vigenciat'],$_POST['incoseg'],'C');}
					if($_POST['incoter']!=$_POST['incoterc']){imgresobase('3',$_POST['vigenciat'],$_POST['incoter'],'C');}
					if($_POST['incocua']!=$_POST['incocuac']){imgresobase('4',$_POST['vigenciat'],$_POST['incocua'],'C');}
					if($_POST['incoqui']!=$_POST['incoquic']){imgresobase('5',$_POST['vigenciat'],$_POST['incoqui'],'C');}
					if($_POST['incosex']!=$_POST['incosexc']){imgresobase('6',$_POST['vigenciat'],$_POST['incosex'],'C');}
					if($_POST['incosep']!=$_POST['incosepc']){imgresobase('7',$_POST['vigenciat'],$_POST['incosep'],'C');}
					if($_POST['incooct']!=$_POST['incooctc']){imgresobase('8',$_POST['vigenciat'],$_POST['incooct'],'C');}
					if($_POST['inconov']!=$_POST['inconovc']){imgresobase('9',$_POST['vigenciat'],$_POST['inconov'],'C');}
					if($_POST['incodec']!=$_POST['incodecc']){imgresobase('10',$_POST['vigenciat'],$_POST['incodec'],'C');}
					if($_POST['incoonc']!=$_POST['incooncc']){imgresobase('11',$_POST['vigenciat'],$_POST['incoonc'],'C');}
					if($_POST['incodoc']!=$_POST['incodocc']){imgresobase('12',$_POST['vigenciat'],$_POST['incodoc'],'C');}
					//intereses moratorios
					if($_POST['inmopri']!=$_POST['inmopric']){imgresobase('1',$_POST['vigenciat'],$_POST['inmopri'],'M');}
					if($_POST['inmoseg']!=$_POST['inmosegc']){imgresobase('2',$_POST['vigenciat'],$_POST['inmoseg'],'M');}
					if($_POST['inmoter']!=$_POST['inmoterc']){imgresobase('3',$_POST['vigenciat'],$_POST['inmoter'],'M');}
					if($_POST['inmocua']!=$_POST['inmocuac']){imgresobase('4',$_POST['vigenciat'],$_POST['inmocua'],'M');}
					if($_POST['inmoqui']!=$_POST['inmoquic']){imgresobase('5',$_POST['vigenciat'],$_POST['inmoqui'],'M');}
					if($_POST['inmosex']!=$_POST['inmosexc']){imgresobase('6',$_POST['vigenciat'],$_POST['inmosex'],'M');}
					if($_POST['inmosep']!=$_POST['inmosepc']){imgresobase('7',$_POST['vigenciat'],$_POST['inmosep'],'M');}
					if($_POST['inmooct']!=$_POST['inmooctc']){imgresobase('8',$_POST['vigenciat'],$_POST['inmooct'],'M');}
					if($_POST['inmonov']!=$_POST['inmonovc']){imgresobase('9',$_POST['vigenciat'],$_POST['inmonov'],'M');}
					if($_POST['inmodec']!=$_POST['inmodecc']){imgresobase('10',$_POST['vigenciat'],$_POST['inmodec'],'M');}
					if($_POST['inmoonc']!=$_POST['inmooncc']){imgresobase('11',$_POST['vigenciat'],$_POST['inmoonc'],'M');}
					if($_POST['inmodoc']!=$_POST['inmodocc']){imgresobase('12',$_POST['vigenciat'],$_POST['inmodoc'],'M');}
					
					echo "<script>despliegamodalm('visible','1','Se ha agrego con Exito la Tasa de Interes');</script>";
					
				}
			?>
			<input type="hidden" name="oculto" id="oculto" value="1"/>
		</form>
		<div id="bgventanamodal2">
			<div id="ventanamodal2">
				<IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"></IFRAME>
			</div>
		</div>
	</body>
</html>