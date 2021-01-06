a<?php
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=iso-8859-1");
	require 'comun.inc';
	require 'funciones.inc';
	include_once ($_SERVER['DOCUMENT_ROOT'].'/financiero/dirs.php');
	require_once (CONTROLLERS_PATH.'HumRetencionesNominaController.php');
	sesion();
	$linkbd=conectar_v7();
	cargarcodigopag(@$_GET['codpag'],@$_SESSION["nivel"]);
	date_default_timezone_set("America/Bogota");
	//error_reporting(E_ALL);
	//ini_set('display_errors', '1');
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=iso-8859-1"/>
		<meta http-equiv="X-UA-Compatible" content="ie=edge"/>
		<title>:: Spid - Gesti&oacute;n Humana</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script type="text/javascript" src="css/calendario.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script type="text/javascript" src="jquery-1.11.0.min.js"></script>
		<style>
			input[type='text']{height:30px;}
			input[type='search']{height:30px;}
			select{height:30px;}
		</style>
		<script>
			function verUltimaPos(idcta, filas, filtro)
			{
				var scrtop=$('#divdet').scrollTop();
				var altura=$('#divdet').height();
				var numpag=$('#nummul').val();
				var limreg=$('#numres').val();
				if((numpag<=0)||(numpag=="")){numpag=0;}
				if((limreg==0)||(limreg=="")){limreg=10;}
				numpag++;
				location.href="hum-retencioneseditar.php?idban=" + idcta + "&scrtop=" + scrtop + "&totreg=" + filas + "&altura=" + altura + "&numpag=" + numpag + "&limreg=" + limreg + "&filtro=" + filtro;
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
						case "4":	document.getElementById('ventanam').src="ventana-consulta2.php?titulos="+mensa+"&idresp="+pregunta;break;	
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
			function cambioswitch(id,valor)
			{
				document.getElementById('idestado').value=id;
				if(valor==1){despliegamodalm('visible','4','Desea activar este Banco','1');}
				else{despliegamodalm('visible','4','Desea Desactivar este Banco','2');}
			}
		</script>
		<?php 
			titlepag();
			$scrtop=@$_GET['scrtop'];
			if($scrtop=="") {$scrtop=0;}
			echo"<script>window.onload=function(){ $('#divdet').scrollTop(".$scrtop.") }</script>";
			$gidcta=@$_GET['idban'];
			if(isset($_GET['filtro'])){$_POST['nombre']=$_GET['filtro'];}
		?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("hum");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("hum");?></tr>
			<tr>
				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='hum-retencionesagregar.php'" class="mgbt"/><img src="imagenes/guardad.png" class="mgbt1"/><img src="imagenes/busca.png" title="Buscar" onClick="location.href='hum-retencionesbuscar.php'" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" onClick="<?php echo paginasnuevas("hum");?>" class="mgbt"><img src="imagenes/iratras.png" title="Men&uacute; Nomina" onClick="location.href='hum-menunomina.php'" class="mgbt"></td>
			</tr>
		</table>
		<?php
			if(@$_GET['numpag']!="")
			{
				if(@$_POST['oculto']=='')
				{
					$_POST['numres']=$_GET['limreg'];
					$_POST['numpos']=$_GET['limreg']*($_GET['numpag']-1);
					$_POST['nummul']=$_GET['numpag']-1;
				}
			}
			else
			{
				if(@$_POST['nummul']=="")
				{
					$_POST['numres']=10;
					$_POST['numpos']=0;
					$_POST['nummul']=0;
				}
			}
		?>
		<div id="bgventanamodalm" class="bgventanamodalm">
			<div id="ventanamodalm" class="ventanamodalm">
				<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"></IFRAME>
			</div>
		</div>
		<form name="form2" method="post" action="">
			<input type="hidden" name="numres" id="numres" value="<?php echo @$_POST['numres'];?>"/>
			<input type="hidden" name="numpos" id="numpos" value="<?php echo @$_POST['numpos'];?>"/>
			<input type="hidden" name="nummul" id="nummul" value="<?php echo @$_POST['nummul'];?>"/>
			<input type="hidden" name="oculto" id="oculto" value="1"/>
			<input type="hidden" name="cambioestado" id="cambioestado" value="<?php echo @$_POST['cambioestado'];?>">
			<input type="hidden" name="nocambioestado" id="nocambioestado" value="<?php echo @$_POST['nocambioestado'];?>">
			<input type="hidden" name="idestado" id="idestado" value="<?php echo @$_POST['idestado'];?>">
			<?php
				if(@$_POST['oculto']=="")
				{
					$_POST['cambioestado']="";
					$_POST['nocambioestado']="";
					$_POST['nombre']='';
				}
				//*****************************************************************
				if($_POST['cambioestado']!="")
				{
					$cambioestado = new HumRetencionesNominaController();
					if($_POST['cambioestado']=="1"){$cambioestado -> actualizarEstadoRetencinesNomina('S');}
					else {$cambioestado -> actualizarEstadoRetencinesNomina('N');}
					$tablaretenciones = $guardaretenciones -> saveretencionesnomina;
					echo"<script>document.form2.cambioestado.value=''</script>";
				}
				//*****************************************************************
				if($_POST['nocambioestado']!="")
				{
					if($_POST['nocambioestado']=="1"){$_POST['lswitch1'][$_POST['idestado']]=1;}
					else {$_POST['lswitch1'][$_POST['idestado']]=0;}
					echo"<script>document.form2.nocambioestado.value=''</script>";
				}
			?>
			<table class="inicio">
				<tr>
					<td class="titulos" colspan="4">:: Buscar Retenciones funcionarios</td>
					<td class="cerrar" style="width:7%" onClick="location.href='hum-principal.php'">Cerrar</td>
				</tr>
				<tr>
					<td class="saludo1" style='width:4cm;'>.: C&oacute;digo o Nombre:</td>
					<td>
						<input type="search" name="nombre" id="nombre" value="<?php echo @$_POST['nombre'];?>" style='width:100%;'/>
					</td>
					<td colspan="2" style="padding-bottom:0px;height:35px;"><em class="botonflecha" onClick="limbusquedas();">Buscar</em></td>
				</tr> 
			</table>
			<div class="subpantallac5" style="height:67%; width:99.6%; margin-top:0px; overflow-x:hidden" id="divdet">
			<?php
				if (@$_POST['nombre']!=""){$crit1="WHERE concat_ws(' ', codigo,nombre) LIKE '%".$_POST['nombre']."%'";}
				else {$crit1='';}
				$sqlr="SELECT * FROM hum_retencionesfun $crit1";
				$resp = mysqli_query($linkbd,$sqlr);
				$_POST['numtop']=mysqli_num_rows($resp);
				$nuncilumnas=ceil($_POST['numtop']/$_POST['numres']);
				if ($_POST['numres']!="-1"){$cond2="LIMIT ".$_POST['numpos'].", ".$_POST['numres']; }
				else{$cond2='';}
				$sqlr="SELECT * FROM hum_retencionesfun $crit1 ORDER BY id DESC $cond2";
				$resp = mysqli_query($linkbd,$sqlr);
				$con=1;
				$numcontrol=$_POST['nummul']+1;
				if(($nuncilumnas==$numcontrol)||($_POST['numres']=="-1"))
				{
					$imagenforward="<img src='imagenes/forward02.png' style='width:17px;cursor:default;'>";
					$imagensforward="<img src='imagenes/skip_forward02.png' style='width:16px;cursor:default;' >";
				}
				else 
				{
					$imagenforward="<img src='imagenes/forward01.png' style='width:17px;cursor:pointer;' title='Siguiente' onClick='numsiguiente()'>";
					$imagensforward="<img src='imagenes/skip_forward01.png' style='width:16px;cursor:pointer;' title='Fin' onClick='saltocol(\"$nuncilumnas\")'>";
				}
				if(($_POST['numpos']==0)||($_POST['numres']=="-1"))
				{
					$imagenback="<img src='imagenes/back02.png' style='width:17px;cursor:default;'>";
					$imagensback="<img src='imagenes/skip_back02.png' style='width:16px;cursor:default;'>";
				}
				else
				{
					$imagenback="<img src='imagenes/back01.png' style='width:17px;cursor:pointer;' title='Anterior' onClick='numanterior();'>";
					$imagensback="<img src='imagenes/skip_back01.png' style='width:16px;cursor:pointer;' title='Inicio' onClick='saltocol(\"1\")'>";
				}
				$con=1;
				echo "
					<table class='inicio'>
						<tr>
							<td colspan='8' class='titulos'>.: Resultados Busqueda:</td>
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
						<tr><td colspan='9'>Terceros Encontrados: ".$_POST['numtop']."</td></tr>
						<tr>
							<td class='titulos2' style='width:5%;'>Item</td>
							<td class='titulos2' style='width:20%;'>Tipo Retenci&oacute;n</td>
							<td class='titulos2' style='width:10%;'>Documento</td>
							<td class='titulos2'>Nombre Funcionario</td>
							<td class='titulos2' style='width:10%;'>Retenci&oacute;n</td>
							<td class='titulos2' style='width:10%;'>Mes</td>
							<td class='titulos2' style='width:5%;'>vigencia</td>
							<td class='titulos2' colspan='2' style='width:7%;' >Estado</td>
						</tr>";
						$iter='saludo1a';
						$iter2='saludo2';
						$filas=1;
						while ($row =mysqli_fetch_row($resp)) 
						{
							$con2=$con+ $_POST['numpos'];
							if($row[10]=='S')
							{$imgsem="src='imagenes/sema_verdeON.jpg' title='Activo'";$coloracti="#0F0";$_POST['lswitch1'][$row[0]]=0;}
							else
							{$imgsem="src='imagenes/sema_rojoON.jpg' title='Inactivo'";$coloracti="#C00";$_POST['lswitch1'][$row[0]]=1;}
							
							if($gidcta!="")
							{
								if($gidcta==$row[0]){$estilo='background-color:yellow';}
								else{$estilo="";}
							}
							else{$estilo="";}
							$idcta=$row[0];
							$numfil=$filas;
							$filtro=$_POST['nombre'];
							$sqlr1="SELECT codigo,nombre FROM tesoretenciones WHERE id='$row[2]'";
							$resp1=mysqli_query($linkbd,$sqlr1);
							$row1=mysqli_fetch_row($resp1);
							$mes=mesletras($row[7]);
							if($row[9]=="N")
							{
								$acdobleclick="onDblClick=\"verUltimaPos('$idcta','$numfil','$filtro')\"";
								$acswich="
									<td style='text-align:center;'><input type='range' name='lswitch1[]' value='".$_POST['lswitch1'][$row[0]]."' min ='0' max='1' step ='1' style='background:$coloracti; width:60%' onChange='cambioswitch(\"$row[0]\",\"".$_POST['lswitch1'][$row[0]]."\")'</td>
								</tr>";
							}
							else
							{
								$acdobleclick="";
								$acswich="
									<td class='icoop' style='text-align:center;'><img src='imagenes/candado.png' title='En Uso' style='width:18px;'/></td>
								</tr>";
							}
							echo"<tr class='$iter' $acdobleclick style='text-transform:uppercase; $estilo'>
								<td class='icoop'>$con2</td>
								<td class='icoop'>$row1[0] - $row1[1]</td>
								<td class='icoop'>$row[3]</td>
								<td class='icoop'>$row[4]</td>
								<td class='icoop'>$row[6]</td>
								<td class='icoop'>$mes</td>
								<td class='icoop' style='text-align:center;'>$row[8]</td>
								<td style='text-align:center;'><img $imgsem style='width:20px'/></td>
								$acswich";
							$con+=1;
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux;
							$filas++;
						}
						if (@$_POST['numtop']==0)
						{
							echo "
							<table class='inicio'>
								<tr>
									<td class='saludo1' style='text-align:center;width:100%'><img src='imagenes\alert.png' style='width:25px'>No hay coincidencias en la b&uacute;squeda ".@$tibusqueda."<img src='imagenes\alert.png' style='width:25px'></td>
								</tr>
							</table>";
						}
						echo"
					</table>
					<table class='inicio'>
						<tr>
							<td style='text-align:center;'>
								<a>$imagensback</a>&nbsp;
								<a>$imagenback</a>&nbsp;&nbsp;";
				if($nuncilumnas<=9){$numfin=$nuncilumnas;}
				else{$numfin=9;}
				for($xx = 1; $xx <= $numfin; $xx++)
				{
					if($numcontrol<=9){$numx=$xx;}
					else{$numx=$xx+($numcontrol-9);}
					if($numcontrol==$numx){echo"<a onClick='saltocol(\"$numx\")'; style='color:#24D915;cursor:pointer;'> $numx </a>";}
					else {echo"<a onClick='saltocol(\"$numx\")'; style='color:#000000;cursor:pointer;'> $numx </a>";}
				}
				echo"			&nbsp;&nbsp;<a>$imagenforward</a>
								&nbsp;<a>$imagensforward</a>
							</td>
						</tr>
					</table>";
			?>
			<input type="hidden" name="ocules" id="ocules" value="<?php echo @$_POST['ocules'];?>"/>
			<input type="hidden" name="actdes" id="actdes" value="<?php echo @$_POST['actdes'];?>"/>
			<input type="hidden" name="numtop" id="numtop" value="<?php echo @$_POST['numtop'];?>"/>
		</form>
		<div id="bgventanamodal2">
			<div id="ventanamodal2">
				<IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"></IFRAME>
			</div>
		</div>
	</body>
</html>