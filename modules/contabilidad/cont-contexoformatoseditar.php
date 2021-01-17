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
			function buscactap(e){if (document.form2.cuentap.value!=""){document.form2.bcp.value='1';document.form2.submit();}}
			function validar(){document.form2.submit();}
			function agregardetalle()
			{
				if(document.getElementById('ncuentap').value!="" )
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
				{document.getElementById('ventana2').src="contconceptos-ventana01.php";}
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
			function funcionmensaje(){document.location.href = "";}
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
					//if(actual<10){actual="0"+actual;}
					location.href="cont-contexoformatoseditar.php?idr=" +actual+ "&scrtop=" +scrtop+ "&numpag=" +numpag+ "&limreg=" +limreg+ "&filtro=" +filtro;
				}
			}
			function atrasc(scrtop, numpag, limreg, filtro, prev)
			{
				var minimo=document.getElementById('minimo').value;
				var actual=document.getElementById('idnum').value;
				actual=parseFloat(actual)-1;
				if(actual>=parseFloat(minimo))
				{
					//if(actual<10){actual="0"+actual;}
					location.href="cont-contexoformatoseditar.php?idr=" +actual+ "&scrtop=" +scrtop+ "&numpag=" +numpag+ "&limreg=" +limreg+ "&filtro=" +filtro;
				}
			}
			function iratras(scrtop, numpag, limreg, filtro)
			{
				var idcta=document.getElementById('idnum').value;
				location.href="cont-contexoformatosbuscar.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
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
				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='cont-contexoformatosagregar.php'" class="mgbt"/><img src="imagenes/guarda.png"  title="Guardar" onClick="guardar();" class="mgbt"/><img src="imagenes/busca.png"  title="Buscar"  onClick="location.href='cont-contexoformatosbuscar.php'" class="mgbt"/><img src="imagenes/nv.png" title="nueva ventana" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s" onClick="iratras(<?php echo "$scrtop, $numpag, $limreg, $filtro"; ?>)" class="mgbt"/></td>
			</tr>
		</table>
		<div id="bgventanamodalm" class="bgventanamodalm">
			<div id="ventanamodalm" class="ventanamodalm">
				<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
				</IFRAME>
			</div>
		</div>
		<?php
			if ($_GET['idr']!="")
			{
				$sqlr="SELECT idnum FROM contexoformatos WHERE codigo='".$_GET['idr']."'";
				$res=mysql_query($sqlr,$linkbd);
				$r=mysql_fetch_row($res);
				echo "<script>document.getElementById('codrec').value=$r;</script>";
			}
			$sqlr="SELECT MIN(idnum), MAX(idnum) FROM contexoformatos ORDER BY idnum";
			$res=mysql_query($sqlr,$linkbd);
			$r=mysql_fetch_row($res);
			$_POST['minimo']=$r[0];
			$_POST['maximo']=$r[1];
			if($_POST['oculto']=="")
			{
				if ($_POST['codrec']!="" || $_GET['idr']!="")
				{
					if($_POST['codrec']!=""){$sqlr="SELECT * FROM contexoformatos WHERE idnum='".$_POST['codrec']."'";}
					else
					{
						$sqlr="SELECT * FROM contexoformatos WHERE idnum ='".$_GET['idr']."'";
					}
				}
				else{$sqlr="SELECT * FROM contexoformatos ORDER BY idnum DESC";}
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
				$_POST['idnum']=$row[0];
				$_POST['codigo']=$row[1];
				$_POST['nombre']=$row[2];
				if(($_POST['oculto']!="2")&&($_POST['oculto']!="6")&&($_POST['oculto']!="7")&&($_POST['oculto']!="1"))
				{
					$sqlr="SELECT * FROM contexoformatos_det WHERE idnum='".$_POST['idnum']."'";
					$cont=0;
					unset($_POST['dcodigo']);
					unset($_POST['dncuentas']);
					$resp = mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($resp))
					{
						$_POST['dcodigo'][$cont]=$row[2];
						$_POST['dncuentas'][$cont]=$row[3];
						$cont=$cont+1;
					}
					$sqlr="SELECT * FROM contexoformatos WHERE idnum='".$_POST['idnum']."'";
					$resp = mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($resp))
					{
						$_POST['codigo']=$row[1];
						$_POST['nombre']=$row[2];
						$_POST['monto']=$row[4];
						$_POST['letra']=$row[5];
					}
				}
			}
		?>
		<form name="form2" method="post" action="">
			<input type="hidden" name="valfocus" id="valfocus" value="1"/>
			<table class="inicio" align="center" >
				<tr >
					<td class="titulos" colspan="8">.: Editar Formatos</td>
					<td style="width:7%"><label class="boton02" onClick="location.href='cont-principal.php'">Cerrar</label></td>
				</tr>
				<tr style="height: 35px;">
					<td class="tamano01" style="width:2cm;">C&oacute;digo:</td>
					<td style="width:10%;"><img src="imagenes/back.png" onClick="atrasc(<?php echo "$scrtop, $numpag, $limreg, $filtro"; ?>)" class="icobut" title="Anterior"/>&nbsp;<input type="text" name="codigo" id="codigo" value="<?php echo @ $_POST['codigo'];?>" maxlength="5" style="width:35%;height:35px!important;" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" class="tamano02" readonly/>&nbsp;<img src="imagenes/next.png" onClick="adelante(<?php echo "$scrtop, $numpag, $limreg, $filtro" ?>);" class="icobut" title="Sigiente"/></td>
					<input type="hidden" name="codrec" id="codrec" value="<?php echo @ $_POST['codrec']?>"/>
					<td class="tamano01" style="width:3cm;">Nombre:</td>

					<td style="width:30%"><input type="text" name="nombre" id="nombre" value="<?php echo @ $_POST['nombre'];?>" style="width:100%;height:35px!important;" onKeyUp="return tabular(event,this)" class="tamano02"/></td>

					<td class="tamano01" style="width:10%">Monto minimo:</td>

					<td style="width:10%"><input type="text" name="monto" id="monto" value="<?php echo @ $_POST['monto'];?>" style="width:100%;height:35px!important;" onKeyUp="return tabular(event,this)" class="tamano02"/></td>

					<td class="tamano01" style="width:15%">Letra inicio valores excel:</td>

					<td style="width:5%"><input type="text" name="letra" id="letra" value="<?php echo @ $_POST['letra'];?>" style="width:100%;height:35px!important;" onKeyUp="return tabular(event,this)" class="tamano02"/></td>
				</tr>
			</table>
			<input type="hidden" name="maximo" id="maximo" value="<?php echo @ $_POST['maximo']?>"/>
			<input type="hidden" name="minimo" id="minimo" value="<?php echo @$_POST['minimo']?>"/>
			<input type="hidden" name="oculto" id="oculto" value="1"/>
			<input type="hidden" name="idnum" id="idnum" id="" value="<?php echo @ $_POST['idnum'];?>"/>
			
			<input type="hidden" name="condeta" id="condeta" value="<?php echo $_POST['condeta'];?>"/>
			<?php
				$oculto=$_POST['oculto'];
				if($_POST['oculto']=='2')
				{
					if ($_POST['nombre']!="")
					{
						$sqlr="UPDATE contexoformatos SET nombre='".iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$_POST['nombre'])."', monto='".$_POST['monto']."', columna='".strtoupper($_POST['letra'])."' WHERE idnum = '".$_POST['idnum']."'";
						if (!mysql_query($sqlr,$linkbd))
						{
							echo "<script>despliegamodalm('visible','2','Manejador de Errores de la Clase BD contcodigosinternos, No se pudo ejecutar la petici�n');</script>";
						}
						else
						{
							echo "<script>despliegamodalm('visible','3','Se ha almacenado la Variable con Exito');</script>";
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
