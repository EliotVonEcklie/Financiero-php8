
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
		<title>:: Spid - Gesti&oacute;n Humana</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/calendario.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<style>
			input[type='text']{height:30px;}
			input[type='search']{height:30px;}
			select{height:30px;}
		</style>
		<script>
			function cambioswitch(id,valor)
			{
				document.getElementById('idestado').value=id;
				if(valor==1){despliegamodalm('visible','4','Desea activar el Funcionario ','1');}
				else{despliegamodalm('visible','4','Desea Desactivar el Funcionario','2');}
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
							document.getElementById('ventanam').src="ventana-consulta2.php?titulos="+mensa+"&idresp="+pregunta;break;	
					}
				}
			}
			function funcionmensaje(){}
			function respuestaconsulta(estado,pregunta)
			{
				if(estado=="S")
				{
					switch(pregunta)
					{
						case "1":	document.form2.cambioestado.value="1";break;
						case "2":	document.form2.cambioestado.value="0";break;
					}
				}
				else
				{
					switch(pregunta)
					{
						case "1":	document.form2.nocambioestado.value="1";break;
						case "2":	document.form2.nocambioestado.value="0";break;
					}
				}
				document.form2.submit();
			}
		</script>
		<?php titlepag(); ?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("hum");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("hum");?></tr>
			<tr>
				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='hum-funcionarios.php'" class="mgbt"/><img src="imagenes/guardad.png" class="mgbt1"/><img src="imagenes/busca.png" title="Buscar" onClick="document.form2.submit();" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" onClick="<?php echo paginasnuevas("hum");?>" class="mgbt"><img src='imagenes/iratras.png' title='Men&uacute; Nomina' class='mgbt' onClick="location.href='hum-menunomina.php'"/></td>
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
			if(@$_POST['oculto']=="")
			{
				$accion="INGRESO BUSCAR FUNCIONARIOS";
				$origen=getUserIpAddr();
				generaLogs($_SESSION["nickusu"],'HUM','V',$accion,$origen);
				$_POST['numpos']=0;$_POST['numres']=10;$_POST['nummul']=0;
			}
		?>
			<table class="inicio">
				<tr>
					<td class="titulos" colspan="7">.: Buscar Funcionario</td>
					<td class="cerrar" style="width:7%" onClick="location.href='hum-principal.php'">Cerrar</td>
				</tr>
				<tr>
					<td class="saludo1" style="width:3cm">Funcionario:</td>
					<td style="width:30%"><input type="search" name="numero" id="numero" value="<?php echo @$_POST['numero'];?>" style="width:100%"/></td>
					<td style="padding-bottom:0px;height:35px;"><em class="botonflecha"  onClick="document.form2.submit();">Buscar</em></td>
					<td></td>
				</tr>
			</table>
			<input type="hidden" name="oculto" id="oculto" value="1"/>
			<input type="hidden" name="desdel" id="desdel" value="<?php echo @$_POST['desdel'];?>"/>
			<input type="hidden" name="numres" id="numres" value="<?php echo @$_POST['numres'];?>"/>
			<input type="hidden" name="numpos" id="numpos" value="<?php echo @$_POST['numpos'];?>"/>
			<input type="hidden" name="nummul" id="nummul" value="<?php echo @$_POST['nummul'];?>"/>
			<div class="subpantalla" style="height:68.5%; width:99.6%; overflow-x:hidden;">
				<?php
					if (@$_POST['numero']!="")
					{$crit1=" AND (SELECT T2.codfun FROM hum_funcionarios T2 WHERE T2.descripcion  LIKE  '%".$_POST['numero']."%' AND T2.estado='S' AND T2.codfun=T1.codfun AND (T2.item='NOMTERCERO' OR T2.item='DOCTERCERO'))  ";}
					else {$crit1="";}
					$sqlr="
					SELECT T1.codfun, 
					GROUP_CONCAT(T1.item ORDER BY CONVERT(T1.valor, SIGNED INTEGER) SEPARATOR '<->'), 
					GROUP_CONCAT(T1.descripcion ORDER BY CONVERT(T1.codrad, SIGNED INTEGER) SEPARATOR '<->')
					FROM hum_funcionarios T1
					WHERE (T1.item = 'NOMCARGO' OR T1.item = 'VALESCALA' OR T1.item = 'DOCTERCERO' OR T1.item = 'NOMTERCERO' OR T1.item = 'ESTGEN' OR T1.item = 'NOMCC') AND T1.estado='S' $crit1
					GROUP BY T1.codfun
					ORDER BY CONVERT(T1.codfun, SIGNED INTEGER)";
					$resp = mysqli_query($linkbd,$sqlr);
					$_POST['numtop']=mysqli_num_rows($resp);
					$nuncilumnas=ceil($_POST['numtop']/$_POST['numres']);
					if (@$_POST['numres']!="-1"){$cond2="LIMIT ".$_POST['numpos'].",".$_POST['numres'];}
					else{$cond2="";}
					$sqlr="
					SELECT T1.codfun, 
					GROUP_CONCAT(T1.descripcion ORDER BY CONVERT(T1.valor, SIGNED INTEGER) SEPARATOR '<->')
					FROM hum_funcionarios T1
					WHERE (T1.item = 'NOMCARGO' OR T1.item = 'VALESCALA' OR T1.item = 'DOCTERCERO' OR T1.item = 'NOMTERCERO' OR T1.item = 'ESTGEN' OR T1.item = 'NOMCC') AND T1.estado='S' $crit1 
					GROUP BY T1.codfun
					ORDER BY CONVERT(T1.codfun, SIGNED INTEGER) DESC $cond2";
					$resp = mysqli_query($linkbd,$sqlr);
					$ntr = mysqli_num_rows($resp);
					$con=1;
					$numcontrol=$_POST['nummul']+1;
					if(($nuncilumnas==$numcontrol)||(@$_POST['numres']=="-1"))
					{
						$imagenforward="<img src='imagenes/forward02.png' style='width:17px'>";
						$imagensforward="<img src='imagenes/skip_forward02.png' style='width:16px' >";
					}
					else 
					{
						$imagenforward="<img src='imagenes/forward01.png' style='width:17px;cursor:pointer;' title='Siguiente' onClick='numsiguiente()'>";
						$imagensforward="<img src='imagenes/skip_forward01.png' style='width:16px;cursor:pointer;' title='Fin' onClick='saltocol(\"$nuncilumnas\")'>";
					}
					if((@$_POST['numpos']==0)||(@$_POST['numres']=="-1"))
					{
						$imagenback="<img src='imagenes/back02.png' style='width:17px'>";
						$imagensback="<img src='imagenes/skip_back02.png' style='width:16px'>";
					}
					else
					{
						$imagenback="<img src='imagenes/back01.png' style='width:17px;cursor:pointer;' title='Anterior' onClick='numanterior();'>";
						$imagensback="<img src='imagenes/skip_back01.png' style='width:16px;cursor:pointer;' title='Inicio' onClick='saltocol(\"1\")'>";
					}
					echo "
					<table class='inicio' align='center' >
						<tr>
							<td colspan='7' class='titulos'>.: Resultados Busqueda:</td>
							<td class='submenu'>
								<select name='renumres' id='renumres' onChange='cambionum();' style='width:100%'>
									<option value='10'"; if (@$_POST['renumres']=='10'){echo 'selected';} echo ">10</option>
									<option value='20'"; if (@$_POST['renumres']=='20'){echo 'selected';} echo ">20</option>
									<option value='30'"; if (@$_POST['renumres']=='30'){echo 'selected';} echo ">30</option>
									<option value='50'"; if (@$_POST['renumres']=='50'){echo 'selected';} echo ">50</option>
									<option value='100'"; if (@$_POST['renumres']=='100'){echo 'selected';} echo ">100</option>
									<option value='-1'"; if (@$_POST['renumres']=='-1'){echo 'selected';} echo ">Todos</option>
								</select>
							</td>
						</tr>
						<tr><td colspan='8'>Funcionarios Encontrados: ".$_POST['numtop']."</td></tr>
						<tr>
							<td class='titulos2' style='width:5%'>ID</td>
							<td class='titulos2' style='width:8%'>DOCUMENTO</td>
							<td class='titulos2' style='width:23%'>NOMBRE</td>
							<td class='titulos2'>CARGO</td>
							<td class='titulos2' style='width:18%'>CENTRO DE COSTO</td>
							<td class='titulos2' style='width:8%'>VALOR ESCALA</td>
							<td class='titulos2' style='width:5%;text-align:center;'>ESTADO</td>
							<td class='titulos2' style='width:5%;text-align:center;'>EDITAR</td>
						</tr>";	
					$iter='saludo1a';
					$iter2='saludo2';
					while ($row =mysqli_fetch_row($resp)) 
					{
						$datos = explode('<->', iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$row[1]));
						if($datos[5]=='S'){$imgsem="src='imagenes/sema_verdeON.jpg' title='Activo'";}
						else{$imgsem="src='imagenes/sema_rojoON.jpg' title='Inactivo'";}
						echo "
						<tr class='$iter' style='text-transform:uppercase' onDblClick=\"location.href='hum-funcionarioseditar.php?idfun=$row[0]'\">
							<td class='icoop'>$row[0]</td>
							<td class='icoop'>$datos[2]</td>
							<td class='icoop'>$datos[3]</td>
							<td class='icoop'>$datos[0]</td>
							<td class='icoop'>$datos[4]</td>
							<td class='icoop' style='text-align:right;'>$".number_format($datos[1],0,',','.')."</td>
							<td class='icoop' style='text-align:center;'><img $imgsem style='width:20px'/> </td>
							<td class='icoop' style='text-align:center;'><img src='imagenes/b_edit.png' title='Editar'  onClick=\"location.href='hum-funcionarioseditar.php?idfun=$row[0]'\"/> </td>
						</tr>";
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
					}
					echo"
					</table>
					<table class='inicio'>
						<tr>
							<td style='text-align:center;'>
								$imagensback&nbsp;
								$imagenback&nbsp;&nbsp;";
					if($nuncilumnas<=9){$numfin=$nuncilumnas;}
					else{$numfin=9;}
					for($xx = 1; $xx <= $numfin; $xx++)
					{
						if($numcontrol<=9){$numx=$xx;}
						else{$numx=$xx+($numcontrol-9);}
						if($numcontrol==$numx){echo"<label onClick='saltocol(\"$numx\")'; style='color:#24D915;cursor:pointer;'> $numx </label>";}
						else {echo"<label onClick='saltocol(\"$numx\")'; style='color:#000000;cursor:pointer;'> $numx </label>";}
					}
					echo"		&nbsp;&nbsp;$imagenforward
								&nbsp;$imagensforward
							</td>
						</tr>
					</table>"
				?>
			</div>
			<input type="hidden" name="numtop" id="numtop" value="<?php echo @$_POST['numtop'];?>" />
		</form>
		<div id="bgventanamodal2">
			<div id="ventanamodal2">
				<IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"></IFRAME>
			</div>
		</div>
	</body>
</html>