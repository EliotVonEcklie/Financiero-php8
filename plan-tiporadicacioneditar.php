<?php
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=iso-8859-1");
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_v7();
	cargarcodigopag($_GET['codpag'],$_SESSION["nivel"]);
	date_default_timezone_set("America/Bogota");
	$scroll=$_GET['scrtop'];
	$totreg=$_GET['totreg'];
	$idcta=$_GET['idcta'];
	$altura=$_GET['altura'];
	$filtro=$_GET['filtro'];
	//error_reporting(E_ALL);
	//ini_set('display_errors', '1');
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>::SPID-Planeaci&oacute;n Estrat&eacute;gica</title>
		<link rel="shortcut icon" href="favicon.ico"/>
		<link href="css/css2.css" rel="stylesheet" type="text/css"/>
		<link href="css/css3.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js"></script>
		<script type='text/javascript' src='JQuery/jquery-2.1.4.min.js'></script>
		<script type="text/javascript" src="JQuery/alphanum/jquery.alphanum.js"></script>
		<style>
			/*boton1*/
			.swestado
			{position: relative; width: 71px;-webkit-user-select:none;-moz-user-select:none;-ms-user-select: none;}
			.swestado-checkbox {display: none;}
			.swestado-label 
			{display: block;overflow: hidden;cursor: pointer;border: 2px solid #DDE6E2;border-radius: 20px;}
			.swestado-inner 
			{display: block;width: 200%;margin-left: -100%;transition: margin 0.3s ease-in 0s;}
			.swestado-inner:before, .swestado-inner:after 
			{display: block;float: left;width: 50%;height: 23px;padding: 0;line-height: 23px;font-size: 14px;color: white;font-family: Trebuchet, Arial, sans-serif;font-weight: bold;box-sizing: border-box;}
			.swestado-inner:before 
			{content: "SI";padding-left: 10px;background-color: #51C3E0;color: #FFFFFF;}
			.swestado-inner:after 
			{content: "NO";padding-right: 10px;background-color: #EEEEEE; color: #999999;text-align: right;}
			.swestado-switch 
			{display: block;width: 17px;margin: 3px;background: #FFFFFF;position: absolute;top: 0;bottom: 0;right: 44px;border: 2px solid #DDE6E2;border-radius: 20px;transition: all 0.3s ease-in 0s;}
			.swestado-checkbox:checked + .swestado-label .swestado-inner {margin-left: 0;}
			.swestado-checkbox:checked + .swestado-label .swestado-switch {right: 0px;}
		</style>
		<script>
			function guardar()
			{
				var validacion01=document.getElementById('granombre').value;
				var validacion02=document.getElementById('gradescr').value;
				var validacion03=document.getElementById('gratiempo').value;
				if (validacion01.trim()!='' && validacion02.trim()!='' && validacion03.trim()!='')
				{despliegamodalm('visible','4','Esta Seguro de Modificar','1');}
				else
				{
					despliegamodalm('visible','2','Faltan datos para completar el registro');
					document.form2.nombre.focus();document.form2.nombre.select();
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
			function funcionmensaje(){document.location.href = "";}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":
						document.getElementById('oculto').value='2';
						document.form2.submit();break;
				}
			}
			function valrrespuesta()
			{
				if (document.getElementById('rrespuesta').value!='S')
				{
					document.getElementById('gratiempo').value=0;
					document.getElementById('vrespuesta').value="readonly";
				}
				else {document.getElementById('vrespuesta').value="";}
				//document.getElementById('oculto').value='9';
				document.form2.submit();
			}
			function adelante(scrtop, numpag, limreg, filtro, next)
			{
				var maximo=document.getElementById('maximo').value;
				var actual=document.getElementById('codid').value;
				actual++;
				if(parseFloat(maximo)>=parseFloat(actual))
				{
					var nider=document.getElementsByName('valorid[]').item(actual-1).value;
					document.location.href = "plan-tiporadicacioneditar.php?idtradica="+nider+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
				}
			}
			function atrasc(scrtop, numpag, limreg, filtro, prev)
			{
				var minimo=document.getElementById('minimo').value;
			 	var actual=document.getElementById('codid').value;
				actual--;
				if(parseFloat(minimo)<=parseFloat(actual))
				{
					var nider=document.getElementsByName('valorid[]').item(actual-1).value;
					document.location.href = "plan-tiporadicacioneditar.php?idtradica="+nider+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
				}
			}
			function iratras(scrtop, numpag, limreg, filtro)
			{
				var idcta=document.getElementById('codrec').value;
				location.href="plan-tiporadicacionbuscar.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
			}
			function cambiocheck(id)
			{
				switch(id)
				{
					case "1":	if(document.getElementById('idswestado').value=='S'){document.getElementById('idswestado').value='N';}
								else{document.getElementById('idswestado').value='S';}
								break;
				}
				document.form2.submit();
			}
		</script>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<?php
			$numpag= $_GET['numpag'];
			$limreg= $_GET['limreg'];
			$scrtop=26*$totreg;
		?>
		<table>
			<tr><script>barra_imagenes("plan");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("plan");?></tr>
			<tr>
				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='plan-tiporadicacion.php'" class="mgbt"/><img src="imagenes/guarda.png" title="Guardar" onClick="guardar();" class="mgbt"/><img src="imagenes/busca.png" title="Buscar" onClick="location.href='plan-tiporadicacionbuscar.php'" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana"  onClick="<?php echo paginasnuevas("plan");?>" class="mgbt"/><img src="imagenes/iratras.png" title="Atr&aacute;s" onClick="iratras(<?php echo "'$scrtop','$numpag','$limreg','$filtro'";?>)" class="mgbt"/></td>
			</tr>
		</table>
		<div id="bgventanamodalm" class="bgventanamodalm">
			<div id="ventanamodalm" class="ventanamodalm">
				<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"></IFRAME>
			</div>
		</div>
		<form name="form2" method="post" action="">
			<?php
				if (@ $_GET['idtradica']!="")
				{
					$conv=0;
					$_POST['codrec']=$_GET['idtradica'];
					$_POST['minimo']=1;
					$sqlr="SELECT codigo FROM plantiporadicacion WHERE radotar='RA' ORDER BY codigo";
					$res=mysqli_query($linkbd,$sqlr);
					$_POST['maximo']=mysqli_num_rows($res);
					while ($row=mysqli_fetch_row($res))
					{
						echo"<input type='hidden' name='valorid[]' value='$row[0]'/>";
						$conv++;
						if($_GET['idtradica']==$row[0]){$_POST['codid']=$conv;}
					}
				}
				if(@ $_POST['oculto']=="")
				{
					$sqlr="SELECT * FROM plantiporadicacion WHERE codigo='".$_POST['codrec']."'";
					$res=mysqli_query($linkbd,$sqlr);
					$row = mysqli_fetch_row($res);
					$_POST['granombre']=$row[1];
					$_POST['gradescr']=$row[2];
					$_POST['gratiempo']=$row[3];
					$_POST['tipcal']=$row[4];
					$_POST['rrespuesta']=$row[5];
					$_POST['readjunto']=$row[6];
					$_POST['tipopqr']=$row[11];
					$_POST['swestado']=$row[7];
					if (@ $_POST['rrespuesta']!='S'){$_POST['vrespuesta']="readonly";}
					else {$_POST['vrespuesta']="";}
				}
			?>
			<table class="inicio" >
				<tr>
					<td class="titulos" colspan="9">:: Modificar Tipo de Radicaci&oacute;n</td>
					<td class="cerrar" style="width:7%" onClick="location.href='plan-principal.php'">&nbsp;Cerrar</td>
				</tr>
				<tr>
					<td class="saludo1" style="width:2.5cm">:&middot; C&oacute;digo:</td>
					<td style="width:10%"><img src="imagenes/back.png" onClick="atrasc(<?php echo "'$scrtop','$numpag','$limreg','$filtro'";?>)" class="icobut"/>&nbsp;<input type="text" name="codid" id="codid" value="<?php echo @ $_POST['codid']?>" style="width:35%"/>&nbsp;<img src="imagenes/next.png" title="siguiente" onClick="adelante(<?php echo "'$scrtop','$numpag','$limreg','$filtro'";?>)" class="icobut"/><input type="hidden" name="codrec" id="codrec" value="<?php echo @ $_POST['codrec']?>"/></td>
					<td class="saludo1" style="width:1cm;">:&middot; Nombre:</td>
					<td ><input type="text" name="granombre" id="granombre" style="width:100%" value="<?php echo @ $_POST['granombre'];?>"/> </td>
					<td class="saludo1" style="width:4cm">:&middot;Requiere Respuesta:</td>
					<td style="width:7%">
						<select name="rrespuesta" id="rrespuesta" style="width:100%" onChange="valrrespuesta()">
							<option value="S" <?php if(@ $_POST['rrespuesta']=="S"){echo "SELECTED ";}?>>SI</option>
							<option value="N" <?php if(@ $_POST['rrespuesta']=="N"){echo "SELECTED ";}?>>NO</option>
						</select>
						<input type="hidden" id="vrespuesta" name="vrespuesta" value="<?php echo @ $_POST['vrespuesta'];?>"/>
					</td>
					<td class="saludo1" style="width:4cm">:&middot; Tiempo de Respuesta:</td>
					<td ><input type="text"name="gratiempo" id="gratiempo" style="width:100%" value="<?php echo @ $_POST['gratiempo'];?>" <?php echo @ $_POST['vrespuesta'];?>/></td>
				</tr>
				<tr>
					<td class="saludo1" style="width:2.5cm">:&middot; Descripci&oacute;n:</td>
					<td colspan="3" style="width:40%"><input type="text" name="gradescr" id="gradescr" style="width:100%" value="<?php echo @ $_POST['gradescr'];?>"/></td>
					<td class="saludo1" >:&middot; Tipo de D&iacute;as:</td>
					<td>
						<select name="tipcal" id="tipcal" style="width:100%">
							<option value="N" <?php if($_POST[tipcal]=="N"){echo "SELECTED ";}?>>....</option>
							<?php
								if(@ $_POST['vrespuesta']=="")
								{
									echo"<option value='H' "; if(@ $_POST['tipcal']=="H"){echo "SELECTED ";}echo">Habiles</option>";
									echo"<option value='C' "; if(@ $_POST['tipcal']=="C"){echo "SELECTED ";}echo">Calendario</option>";
								}
							?>
						</select>
					</td>
					<td class="saludo1" style="width:4cm">:&middot; Requiere Adjunto:</td>
					<td>
						<select name="readjunto" id="readjunto" style="width:100%">
							<option value="S" <?php if(@ $_POST['readjunto']=="S"){echo "SELECTED ";}?>>SI</option>
							<option value="N" <?php if(@ $_POST['readjunto']=="N"){echo "SELECTED ";}?>>NO</option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="saludo1" style="width:2cm;">:&middot; Tipo PQR:</td>
					<td>
						<select name="tipopqr" id="tipopqr" style="width:100%">
							<option value="N" <?php if(@ $_POST['tipopqr']=="N"){echo "SELECTED ";}?>>N - Ninguno</option>
							<option value="P" <?php if(@ $_POST['tipopqr']=="P"){echo "SELECTED ";}?>>P - Petici&oacute;n</option>
							<option value="Q" <?php if(@ $_POST['tipopqr']=="Q"){echo "SELECTED ";}?>>Q - Queja</option>
							<option value="R" <?php if(@ $_POST['tipopqr']=="R"){echo "SELECTED ";}?>>R - Reclamo</option>
							<option value="S" <?php if(@ $_POST['tipopqr']=="S"){echo "SELECTED ";}?>>S - Sugerencia</option>
							<option value="D" <?php if(@ $_POST['tipopqr']=="D"){echo "SELECTED ";}?>>D - Denuncia</option>
							<option value="F" <?php if(@ $_POST['tipopqr']=="F"){echo "SELECTED ";}?>>F - Felicitaci&oacute;n</option>
						</select>
					</td>
					<td class="saludo1" >:&middot; Estado:</td>
					<td >
						<div class="swestado">
							<input type="checkbox" name="swestado" class="swestado-checkbox" id="idswestado" value="<?php echo @ $_POST['swestado'];?>" <?php if(@ $_POST['swestado']=='S'){echo "checked";}?> onChange="cambiocheck('1');"/>
							<label class="swestado-label" for="idswestado">
								<span class="swestado-inner"></span>
								<span class="swestado-switch"></span>
							</label>
						</div>
					</td>
				</tr>
			</table>
			<input type="hidden" value="<?php echo @ $_POST['maximo']?>" name="maximo" id="maximo">
			<input type="hidden" value="<?php echo @ $_POST['minimo']?>" name="minimo" id="minimo">
			<input type="hidden" id="oculto" name="oculto" value="1">
			<?php
				if (@ $_POST['oculto']== 2)
				{
					if(@ $_POST['swestado']==''){$vestado='N';}
					else {$vestado='S';}
					$sqlr = "UPDATE plantiporadicacion SET nombre='".$_POST['granombre']."',descripcion='".$_POST['gradescr']."', dias='".$_POST['gratiempo']."',tdias='".$_POST['tipcal']."',slectura='".$_POST['rrespuesta']."', adjunto='".$_POST['readjunto']."', estado='".$vestado."',clasificacion='".$_POST['tipopqr']."' WHERE codigo='".$_POST['codrec']."'";
					if (!mysqli_query($linkbd,$sqlr)){echo"<script>despliegamodalm('visible','2',''Error no se modifico El Tipo de Radicación');</script>";}
					else {echo"<script>despliegamodalm('visible','3','Se Modifico con Exito El Tipo de Radicación');</script>";}
				}
			?>
		</form>
	</body>
</html>