<?php
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=iso-8859-1");
	require 'comun.inc';
	require 'funciones.inc';
	sesion();
	cargarcodigopag($_GET['codpag'],$_SESSION["nivel"]);
	$linkbd=conectar_v7();
	$scroll=$_GET['scrtop'];
	$totreg=$_GET['totreg'];
	$idcta=$_GET['idcta'];
	$altura=$_GET['altura'];
	$filtro="'".$_GET['filtro']."'";
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=iso-8859-1"/>
		<meta http-equiv="X-UA-Compatible" content="ie=edge"/>
		<title>:: IDEAL.10 - Contabilidad</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<style>
			input[type='text']{height:30px;}
			input[type='search']{height:30px;}
			select{height:30px;}
		</style>
		<script>
			function adelante(scrtop, numpag, limreg, filtro, next)
			{
				var maximo=document.getElementById('maximo').value;
				var actual=document.getElementById('codigo').value;
				if(parseFloat(maximo)>parseFloat(actual))
				{
					document.getElementById('oculto').value='1';
					document.getElementById('codigo').value=next;
					var idcta=document.getElementById('codigo').value;
					location.href="teso-editaactividades.php?idtipocom="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
				}
			}
			function atrasc(scrtop, numpag, limreg, filtro, prev)
			{
				var minimo=document.getElementById('minimo').value;
				var actual=document.getElementById('codigo').value;
				if(parseFloat(minimo)<parseFloat(actual))
				{
					document.getElementById('oculto').value='1';
					document.getElementById('codigo').value=prev;
					var idcta=document.getElementById('codigo').value;
					location.href="teso-editaactividades.php?idtipocom="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					
				}
			}
			function iratras(scrtop, numpag, limreg, filtro)
			{
				var idcta=document.getElementById('codigo').value;
				location.href="teso-buscaactividades.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
			}
			function guardar()
			{
				if (document.form2.codigo.value!='' && document.form2.nombre.value!='')
				{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
				else {despliegamodalm('visible','2','Falta asignar un codigo');}
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
			function funcionmensaje(){}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":
						document.form2.oculto.value="2";
						document.form2.submit();
						break;
				}
			}
			function despliegamodal2(_valor,_num)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else 
				{	
					document.getElementById('ventana2').src="cargafuncionarios-ventana03.php?objeto=tercero";
				}
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<?php
			$numpag=$_GET['numpag'];
			$limreg=$_GET['limreg'];
			$scrtop=22*$totreg;
		?>
		<table>
			<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("teso");?></tr>
			<tr>
				<td colspan="3" class="cinta">
				  <a href="teso-actividades.php" class="mgbt"><img src="imagenes/add.png"  alt="Nuevo" title="Nuevo"/></a> 
				  <a href="#"  onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png" alt="Guardar" title="Guardar"/></a>
				  <a href="teso-buscaactividades.php" class="mgbt"> <img src="imagenes/busca.png" alt="Buscar" title="Buscar"/></a>
				  <a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" alt="nueva ventana" class="mgbt" title="Nueva Ventana"></a>
				  <a href="#" onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>)" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s" class="mgbt"></a></td>
			</tr>
		</table>
		<div id="bgventanamodalm" class="bgventanamodalm">
			<div id="ventanamodalm" class="ventanamodalm">
				<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"></IFRAME>
			</div>
		</div>
		<?php
			if ($_GET['idtipocom']!=""){echo "<script>document.getElementById('codrec').value='".$_GET['idtipocom']."';</script>";}
			$sqlr="select MIN(CONVERT(codigo, SIGNED INTEGER)), MAX(CONVERT(codigo, SIGNED INTEGER)) from codigosciiu ORDER BY CONVERT(codigo, SIGNED INTEGER)";
			$res=mysqli_query($linkbd,$sqlr);
			$r=mysqli_fetch_row($res);
			$_POST['minimo']=$r[0];
			$_POST['maximo']=$r[1];
			if($_POST['oculto']=="")
			{
				if ($_POST['codrec']!="" || $_GET['idtipocom']!="")
				{
					if($_POST['codrec']!=""){$sqlr="SELECT * FROM codigosciiu WHERE codigo='".$_POST['codrec']."'";}
					else {$sqlr="SELECT * FROM codigosciiu WHERE codigo ='".$_GET['idtipocom']."'";}
				}
				else {$sqlr="SELECT * FROM codigosciiu ORDER BY CONVERT(codigo, SIGNED INTEGER) DESC";}
				$res=mysqli_query($linkbd,$sqlr);
				$row=mysqli_fetch_row($res);
				$_POST['codigo']=$row[0];
			}
			if(!$_POST['oculto'])
			{
				$sqlr="SELECT * FROM codigosciiu WHERE codigo='".$_POST['codigo']."'";
				$res=mysqli_query($linkbd,$sqlr);
				while($row=mysqli_fetch_row($res))
				{
					$_POST['codigo']=$row[0];
					$_POST['nombre']=$row[1];
					$_POST['porcentaje']=$row[2];
				}
			}
			//NEXT
			$sqln="SELECT * FROM codigosciiu WHERE codigo > '".$_POST['codigo']."' ORDER BY codigo ASC LIMIT 1";
			$resn=mysqli_query($linkbd,$sqln);
			$row=mysqli_fetch_row($resn);
			$next="'".$row[0]."'";
			//PREV
			$sqlp="SELECT * FROM codigosciiu WHERE codigo < '".$_POST['codigo']."' ORDER BY codigo DESC LIMIT 1";
			$resp=mysqli_query($linkbd,$sqlp);
			$row=mysqli_fetch_row($resp);
			$prev="'".$row[0]."'";
		?>
		<form name="form2" method="post" action="teso-editaactividades.php">
			<table class="inicio" align="center" >
				<tr>
					<td class="titulos" colspan="9">.: Editar Actividades</td>
					<td class="cerrar" style="width:7%" onClick="location.href='teso-principal.php'">Cerrar</td>
				</tr>
				<tr>
				<td style="width:5%">Codigo: </td>
				<td style="width:10%">
					<a href="#" onClick="atrasc(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $prev; ?>)"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a> 
					<input name="codigo" id="codigo" type="text" value="<?php echo @ $_POST['codigo'];?>" style="width:30%" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)">
					<a href="#" onClick="adelante(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $next; ?>)"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> 
				</td>
				<input type="hidden" name="maximo" id="maximo"value="<?php echo @ $_POST['maximo']?>"/>
				<input type="hidden" name="minimo" id="minimo"value="<?php echo @ $_POST['minimo']?>"/>
				<input type="hidden" name="codrec" id="codrec" value="<?php echo $_POST['codrec']?>"/>
				<td style="width:5%">Nombre:</td>
				<td style="width:40%">
				<input name="nombre" type="text" value="<?php echo $_POST['nombre'];?>"  onKeyUp="return tabular(event,this)" style="width:70%"></td>
				<td style="width:5%">Activo:</td>
				<td style="width:12%"><input name="porcentaje" id="porcentaje" type="text" value="<?php echo $_POST['porcentaje']?>" style="width:50%"></td>
				<input name="oculto" id="oculto" type="hidden" value="1">
				<input name="idcomp" type="hidden" value="<?php echo $_POST['idcomp']?>"/>
				</tr>
				<tr><td></td></tr>
			</table>
			<?php
				if(@$_POST['oculto'] == '2')
				{
					if ($_POST['nombre']!="")
					{
						$nr="1";
						$sqlr="UPDATE codigosciiu SET nombre='".$_POST['nombre']."',porcentaje='".$_POST['porcentaje']."', codigo='".$_POST['codigo']."' WHERE codigo='".$_POST['codigo']."'";
						if (!mysqli_query($linkbd,$sqlr))
						{
							echo "<table><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
							echo "Ocurrió el siguiente problema:<br>";
							echo "<pre>";
							echo "</pre></center></td></tr></table>";
						}
						else
						{
							echo "<script>despliegamodalm('visible','1','Se ha Actualizado con Exito');</script>";
						}
					}
					else
					{
						echo"<script>despliegamodalm('visible','2','Falta informacion para Modificar');</script>";
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