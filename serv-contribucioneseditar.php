<?php
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=iso-8859-1");
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_v7();
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	date_default_timezone_set("America/Bogota");
	$scroll=$_GET['scrtop'];
	$totreg=$_GET['totreg'];
	$idcta=$_GET['idcta'];
	$altura=$_GET['altura'];
	$filtro="'".$_GET['filtro']."'";
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
		<script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
		<style>
			.onoffswitch
			{
				position: relative; width: 71px;
				-webkit-user-select:none;
				-moz-user-select:none;
				-ms-user-select: none;
			}
			.onoffswitch-checkbox {display: none;}
			.onoffswitch-label
			{
				display: block;
				overflow: hidden;
				cursor: pointer;
				border: 2px solid #DDE6E2;
				border-radius: 20px;
			}
			.onoffswitch-inner
			{
				display: block;
				width: 200%;
				margin-left: -100%;
				transition: margin 0.3s ease-in 0s;
			}
			.onoffswitch-inner:before, .onoffswitch-inner:after
			{
				display: block;
				float: left;
				width: 50%;
				height: 23px;
				padding: 0;
				line-height: 23px;
				font-size: 14px;
				color: white;
				font-family: Trebuchet, Arial, sans-serif;
				font-weight: bold;
				box-sizing: border-box;
			}
			.onoffswitch-inner:before
			{
				content: "SI";
				padding-left: 10px;
				background-color: #51C3E0;
				color: #FFFFFF;
			}
			.onoffswitch-inner:after
			{
				content: "NO";
				padding-right: 10px;
				background-color: #EEEEEE; color: #999999;
				text-align: right;
			}
			.onoffswitch-switch 
			{
				display: block;
				width: 17px;
				margin: 3px;
				background: #FFFFFF;
				position: absolute;
				top: 0;
				bottom: 0;
				right: 44px;
				border: 2px solid #DDE6E2;
				border-radius: 20px;
				transition: all 0.3s ease-in 0s;
			}
			.onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-inner {margin-left: 0;}
			.onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-switch {right: 0px;}
		</style>
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
			function funcionmensaje(){}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.form2.oculto.value='2';
								document.form2.submit();
								break;
				}
			}
			function guardar()
			{
				var validacion01=document.getElementById('codban').value;
				var validacion02=document.getElementById('nomban').value;
				if (validacion01.trim()!='' && validacion02.trim()) {despliegamodalm('visible','4','Esta Seguro de Modificar','1');}
				else {despliegamodalm('visible','2','Falta informaci�n para modificar la contribucion');}
			}
			function cambiocheck()
			{
				if(document.getElementById('myonoffswitch').value=='S'){document.getElementById('myonoffswitch').value='N';}
				else{document.getElementById('myonoffswitch').value='S';}
				document.form2.submit();
			}
			function iratras(scrtop, numpag, limreg, filtro)
			{
				var idcta=document.getElementById('codban').value;
				location.href="serv-contribucionesbuscar.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+ "&filtro="+filtro;
			}
			function adelante(scrtop, numpag, limreg, filtro)
			{
				var maximo=document.getElementById('maximo').value;
				var actual=document.getElementById('codban').value;
				actual=parseFloat(actual)+1;
				if(actual<=parseFloat(maximo))
				{
					if(actual<10){actual="0"+actual;}
					location.href="serv-contribucioneseditar.php?idban=" +actual+ "&scrtop=" +scrtop+ "&numpag=" +numpag+ "&limreg=" +limreg+ "&filtro=" +filtro;
				}
			}
			function atrasc(scrtop, numpag, limreg, filtro, prev)
			{
				var minimo=document.getElementById('minimo').value;
				var actual=document.getElementById('codban').value;
				actual=parseFloat(actual)-1;
				if(actual>=parseFloat(minimo))
				{
					if(actual<10){actual="0"+actual;}
					location.href="serv-contribucioneseditar.php?idban=" +actual+ "&scrtop=" +scrtop+ "&numpag=" +numpag+ "&limreg=" +limreg+ "&filtro=" +filtro;
				}
			}
			function despliegamodal2(_valor)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else {document.getElementById('ventana2').src="cuentasppto-ventana1.php?ti=1";}
			}
			function buscacta()
			{
				if (document.form2.cuenta.value!="")
				{
					document.form2.bc.value='1';
					document.form2.submit();
				}
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<?php
			$numpag=@ $_GET['numpag'];
			$limreg=@ $_GET['limreg'];
			$scrtop=26*$totreg;
		?>
		<table>
			<tr><script>barra_imagenes("serv");</script><?php cuadro_titulos();?></tr>	
			<tr><?php menu_desplegable("serv");?></tr>
			<tr>
				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='serv-contribuciones.php'" class="mgbt"/><img src="imagenes/guarda.png" title="Guardar" onClick="guardar()" class="mgbt"/><img src="imagenes/busca.png" title="Buscar" onClick="location.href='serv-contribucionesbuscar.php'" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" onClick="<?php echo paginasnuevas("serv");?>" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s" onClick="iratras(<?php echo "$scrtop, $numpag, $limreg, $filtro"; ?>)" class="mgbt"/></td>
			</tr>
		</table>
		<div id="bgventanamodalm" class="bgventanamodalm">
			<div id="ventanamodalm" class="ventanamodalm">
				<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"></IFRAME>
			</div>
		</div>
		<form name="form2" method="post" action="">
			<?php
				if(@ $_POST['oculto']=="")
				{
					$sqlr="SELECT MIN(id), MAX(id) FROM srvcontribuciones";
					$res=mysqli_query($linkbd,$sqlr);
					$r=mysqli_fetch_row($res);
					$_POST['minimo']=$r[0];
					$_POST['maximo']=$r[1];
					$sqlr="SELECT * FROM srvcontribuciones WHERE id='".$_GET['idban']."'";
					$resp = mysqli_query($linkbd,$sqlr);
					$row =mysqli_fetch_row($resp); 
					$_POST['codban']=$row[0];
					$_POST['nomban']=$row[1];
					$_POST['idestrato']=$row[2];
					$_POST['cuenta']=$row[3];
					$_POST['porcentaje']=$row[4];
					$_POST['valor']=$row[5];
					$_POST['concecont']=$row[6];
					$_POST['onoffswitch']=$row[7];
					$nresul=buscacuentapres(@ $_POST['cuenta'],1);
					$_POST['ncuenta']=utf8_decode($nresul);
				}
				if(@ $_POST['bc']!='')
				{
					$nresul=buscacuentapres(@ $_POST['cuenta'],1);
					if($nresul!=''){$_POST['ncuenta']=utf8_decode($nresul);}
					else{$_POST['ncuenta']="";}
				}
			?>
			<table class="inicio ancho">
				<tr>
					<td class="titulos" colspan="6">.: Editar Contribuci&oacute;n</td>
					<td class="cerrar" style="width:7%" onClick="location.href='serv-principal.php'">Cerrar</td>
				</tr>
				<tr>
					<td class="tamano01" style="width:3.5cm;">C&oacute;digo:</td>
					<td style="width:15%;"><img src="imagenes/back.png" onClick="atrasc(<?php echo "$scrtop, $numpag, $limreg, $filtro"; ?>)" class="icobut" title="Anterior"/>&nbsp;<input type="text" name="codban" id="codban" onKeyUp="return tabular(event,this)" value="<?php echo @ $_POST['codban'];?>" style="width:60%;height:30px;" readonly/>&nbsp;<img src="imagenes/next.png" onClick="adelante(<?php echo "$scrtop, $numpag, $limreg, $filtro" ?>);" class="icobut" title="Sigiente"/></td>
					<td class="tamano01" style="width:3cm;">Nombre:</td>
					<td colspan="3"><input type="text" name="nomban" id="nomban" value="<?php echo $_POST['nomban'];?>" style="width:100%; height:30px;text-transform:uppercase"/></td>
				</tr>
				<tr>
					<td class="tamano01">Cuenta Presupuestal:</td> 
					<td><input type="text" id="cuenta" name="cuenta" style="width:100%;" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onChange="buscacta()" value="<?php echo @ $_POST['cuenta']?>" onDblClick="despliegamodal2('visible');" class="colordobleclik" autocomplete="off"/></td>
					<td colspan="4"><input name="ncuenta" type="text" style="width:100%;" value="<?php echo @ $_POST['ncuenta']?>" readonly></td>
				</tr>
				<tr>
					<td class="tamano01">Estrato:</td>
					<td>
						<select name="idestrato" id="idestrato" style="width:100%">
							<option value="-1">:: Seleccione Estrato ::</option>
							<?php
								$sqlr="SELECT id,descripcion FROM srvestratos WHERE estado = 'S' ORDER BY id";
								$resp = mysqli_query($linkbd,$sqlr);
								while ($row =mysqli_fetch_row($resp))
								{
									if($_POST['idestrato']==$row[0])
									{
										echo "<option value='$row[0]' SELECTED>$row[1]</option>";
									}
									else {echo "<option value='$row[0]'>$row[1]</option>no";}
								}
							?>
						</select>
					</td>
					<td class="tamano01">Pocentaje:</td>
					<td><input type="text" name="porcentaje" id="porcentaje" onKeyUp="return tabular(event,this)" value="<?php echo @ $_POST['porcentaje'];?>" style="width:100%;height:30px;" onKeyPress="javascript:return solonumeros(event)" onChange="document.form2.submit();" <?php if(@ $_POST['valor']=='' or $_POST['valor']=='0'){} else{echo 'readonly';}?>/></td>
					<td class="tamano01">valor:</td>
					<td><input type="text" name="valor" id="valor" onKeyUp="return tabular(event,this)" value="<?php echo @ $_POST['valor'];?>" style="width:100%;height:30px;" onKeyPress="javascript:return solonumeros(event)" onChange="document.form2.submit();" <?php if(@ $_POST['porcentaje']=='' or $_POST['porcentaje']=='0'){} else{echo 'readonly';}?>/></td>
				</tr>
				<tr>
					<td class="tamano01">Estado:</td>
					<td>
						<div class="onoffswitch">
							<input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" value="<?php echo @ $_POST['onoffswitch'];?>" <?php if(@ $_POST['onoffswitch']=='S'){echo "checked";}?> onChange="cambiocheck();"/>
							<label class="onoffswitch-label" for="myonoffswitch">
								<span class="onoffswitch-inner"></span>
								<span class="onoffswitch-switch"></span>
							</label>
						</div>
					</td>
					<td class="tamano01" style="width:3cm;">Concepto:</td>
					<td>
						<select name="concecont" id="concecont" style="width:45%;" >
							<option value="-1">Seleccione ....</option>
							<?php
								$sqlr="SELECT * FROM conceptoscontables WHERE modulo='10' AND tipo='SC' ORDER BY codigo";
								$resp = mysqli_query($linkbd,$sqlr);
								while ($row =mysqli_fetch_row($resp))
								{
									if(@ $_POST['concecont']==$row[0])
									{
										echo "<option value='$row[0]' SELECTED>$row[0] - $row[3] - $row[1]</option>";
									}
									else{echo "<option value='$row[0]'>$row[0] - $row[3] - $row[1]</option>";}
								}
							?>
						</select>
					</td>
				</tr>
			</table>
			<input type="hidden" name="maximo" id="maximo" value="<?php echo @ $_POST['maximo']?>"/>
			<input type="hidden" name="minimo" id="minimo" value="<?php echo @ $_POST['minimo']?>"/>
			<input type="hidden" name="oculto" id="oculto" value="1"/>
			<?php
				if(@ $_POST['oculto']=="2")
				{
					if (@ $_POST['onoffswitch']!='S'){$valest='N';}
					else {$valest='S';}
					$sqlr ="UPDATE srvcontribuciones SET nombre='".$_POST['nomban']."',id_estrato='".$_POST['idestrato']."',cuenta_p='".$_POST['cuenta']."', porcentaje='".$_POST['porcentaje']."', valor='".$_POST['valor']."',concepto='".$_POST['concecont']."',estado='$valest' WHERE id='".$_POST['codban']."'";
					if (!mysqli_query($linkbd,$sqlr))
					{
						$e =mysqli_error(mysqli_query($linkbd,$sqlr));
						echo"<script>despliegamodalm('visible','2','No se pudo ejecutar la petici�n: $e');</script>";
					}
					else 
					{
						echo "<script>despliegamodalm('visible','3','Se ha Edito con Exito');</script>";
					}
				}
			?>
		</form>
		<div id="bgventanamodal2">
			<div id="ventanamodal2">
				<IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"></IFRAME>
			</div>
		</div>
	</body>
</html>