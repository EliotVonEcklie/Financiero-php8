<?php
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=utf8");
	require 'comun.inc';
	require 'funciones.inc';
	require 'conversor.php';
	require_once '/controllers/HumIncapacidadesController.php';
	sesion();
	$linkbd=conectar_v7();
	cargarcodigopag(@$_GET['codpag'],@$_SESSION["nivel"]);
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
		<script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script type='text/javascript' src='JQuery/jquery-2.1.4.min.js'></script>
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
				location.href="hum-incapacidadeseditar.php?idinca=" + idcta + "&scrtop=" + scrtop + "&totreg=" + filas + "&altura=" + altura + "&numpag=" + numpag + "&limreg=" + limreg + "&filtro=" + filtro;
			}
			function cambioswitch(id,valor)
			{
				document.getElementById('idestado').value=id;
				if(valor==1){despliegamodalm('visible','4','Desea Activar la Incapacida No '+id,'1');}
				else{despliegamodalm('visible','4','Desea Anular la Incapacidad No '+id,'2');}
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
						case "3":	document.form2.vardeshacer.value="S";break;
					}
				}
				else
				{
					switch(pregunta)
					{
						case "1":	document.form2.nocambioestado.value="1";break;
						case "2":	document.form2.nocambioestado.value="0";break;
						case "3":	document.form2.iddeshacer.value="";break;
					}
				}
				document.form2.submit();
			}
			function fundeshacer(iddelete)
			{
				document.getElementById('iddeshacer').value=iddelete;
				despliegamodalm('visible','4','Desea Deshacer la Incapacidad No '+iddelete,'3');
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
				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='hum-incapacidadesagregar.php'" class="mgbt"/><img src="imagenes/guardad.png" class="mgbt1"/><img src="imagenes/busca.png" title="Buscar" onClick="document.form2.submit();" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" class="mgbt" onClick="mypop=window.open('hum-principal.php','','');mypop.focus();"><img src='imagenes/iratras.png' title='Men&uacute; Nomina' class='mgbt' onClick="location.href='hum-menunomina.php'"/></td>
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
				if(@$_POST['oculto']=="")
				{
					$_POST['idestado']=$_POST['iddeshacer']=0;
					$_POST['vardeshacer']="N";
				}
				if(@$_POST['cambioestado']!="")
				{
					$cambioestado1 = new HumIncapacidadesController();
					if(@$_POST['cambioestado']=="1")
					{
						$cambioestado1 -> actualizarEstadoIncapasidades('S');
						$sqlr="UPDATE hum_incapacidades_det SET estado='S' WHERE num_inca='".$_POST['idestado']."' AND estado!='D'";
						mysqli_query($linkbd,$sqlr);
					}
					else
					{
						$cambioestado1 -> actualizarEstadoIncapasidades('N');
						$sqlr="UPDATE hum_incapacidades_det SET estado='N' WHERE num_inca='".$_POST['idestado']."' AND estado!='D'";
						mysqli_query($linkbd,$sqlr);
					}
					echo"<script>document.form2.cambioestado.value=''</script>";
				}
				if(@$_POST['nocambioestado']!="")
				{
					if(@$_POST['nocambioestado']=="1"){$_POST['lswitch1'][$_POST['idestado']]=1;}
					else {$_POST['lswitch1'][$_POST['idestado']]=0;}
					echo"<script>document.form2.nocambioestado.value=''</script>";
				}
				if(@$_POST['vardeshacer']!="")
				{
					$sqlr ="DELETE FROM hum_incapacidades WHERE num_inca='".$_POST['iddeshacer']."'";
					mysqli_query($linkbd,$sqlr); 
					$sqlr ="DELETE FROM hum_incapacidades_det WHERE num_inca='".$_POST['iddeshacer']."'";
					mysqli_query($linkbd,$sqlr); 
					echo"<script>document.form2.vardeshacer.value='N'</script>";
					echo"<script>document.form2.iddeshacer.value=''</script>";
				}
			?>
			<table class="inicio">
				<tr>
					<td class="titulos" colspan="5">.: Buscar Incapacidades</td>
					<td class="cerrar" style="width:7%" onClick="location.href='hum-principal.php'">Cerrar</td>
				</tr>
				<tr>
					<td class="saludo1" style='width:3cm;'>::Funcionario:</td>
					<td style="width:30%;"><input type="search" name="nombrefun" id="nombrefun" value="<?php echo @$_POST['nombrefun'];?>" style="width:100%;"/></td>
					<td style="padding-bottom:0px;height:35px;"><em class="botonflecha"  onClick="document.form2.submit();">Buscar</em></td>
					<td colspan="2"></td>
				</tr>
			</table>
			<input type="hidden" name="oculto" id="oculto" value="1"/>  
			<input type="hidden" name="cambioestado" id="cambioestado" value="<?php echo @$_POST['cambioestado'];?>"/>
			<input type="hidden" name="nocambioestado" id="nocambioestado" value="<?php echo @$_POST['nocambioestado'];?>"/>
			<input type="hidden" name="idestado" id="idestado" value="<?php echo @$_POST['idestado'];?>"/> 
			<input type="hidden" name="iddeshacer" id="iddeshacer" value="<?php echo @$_POST['iddeshacer'];?>"/> 
			<input type="hidden" name="vardeshacer" id="vardeshacer" value="<?php echo @$_POST['vardeshacer'];?>"/>
			<input type="hidden" name="desdel" id="desdel" value="<?php echo @$_POST['desdel'];?>"/>
			<input type="hidden" name="numres" id="numres" value="<?php echo @$_POST['numres'];?>"/>
			<input type="hidden" name="numpos" id="numpos" value="<?php echo @$_POST['numpos'];?>"/>
			<input type="hidden" name="nummul" id="nummul" value="<?php echo @$_POST['nummul'];?>"/>
			<div class="subpantallac5" style="height:67%; width:99.6%; margin-top:0px; overflow-x:hidden" id="divdet">
				<?php
					if (@$_POST['nombrefun']!=""){$crit1="WHERE nom_funcionario like '%".$_POST['nombrefun']."%' ";}
					else{$crit1="";}
					$maxvariables = new HumIncapacidadesController();
					$maxvariables -> generarAllHumIncapasidades();
					$tablavariables = $maxvariables -> Humincap;
					$_POST['numtop'] = count($tablavariables);
					$nuncilumnas=ceil($_POST['numtop']/$_POST['numres']);
					$con=1;
					$numcontrol=$_POST['nummul']+1;
					if($nuncilumnas==$numcontrol)
					{
						$imagenforward="<img src='imagenes/forward02.png' style='width:17px'>";
						$imagensforward="<img src='imagenes/skip_forward02.png' style='width:16px' >";
					}
					else 
					{
						$imagenforward="<img src='imagenes/forward01.png' style='width:17px' title='Siguiente' onClick='numsiguiente()'>";
						$imagensforward="<img src='imagenes/skip_forward01.png' style='width:16px' title='Fin' onClick='saltocol(\"$nuncilumnas\")'>";
					}
					if(@$_POST['numpos']==0)
					{
						$imagenback="<img src='imagenes/back02.png' style='width:17px'>";
						$imagensback="<img src='imagenes/skip_back02.png' style='width:16px'>";
					}
					else
					{
						$imagenback="<img src='imagenes/back01.png' style='width:17px' title='Anterior' onClick='numanterior();'>";
						$imagensback="<img src='imagenes/skip_back01.png' style='width:16px' title='Inicio' onClick='saltocol(\"1\")'>";
					}
					echo "
					<table class='inicio' align='center' >
						<tr>
							<td colspan='8' class='titulos'>.: Resultados Busqueda:</td>
							<td class='submenu'>
								<select name='renumres' id='renumres' onChange='cambionum();' style='width:100%'>
									<option value='10'"; if (@$_POST['renumres']=='10'){echo 'selected';} echo ">10</option>
									<option value='20'"; if (@$_POST['renumres']=='20'){echo 'selected';} echo ">20</option>
									<option value='30'"; if (@$_POST['renumres']=='30'){echo 'selected';} echo ">30</option>
									<option value='50'"; if (@$_POST['renumres']=='50'){echo 'selected';} echo ">50</option>
									<option value='100'"; if (@$_POST['renumres']=='100'){echo 'selected';} echo ">100</option>
								</select>
							</td>
						</tr>
						<tr><td colspan='9'>Incapacidades Encontradas: ".$_POST['numtop']."</td></tr>
						<tr>
							<td class='titulos2' style='width:5%'>No Inc.</td>
							<td class='titulos2' style='width:10%'>Tipo</td>
							<td class='titulos2' >Funcionario</td>
							<td class='titulos2' style='width:23%'>Mes</td>
							<td class='titulos2' style='width:5%'>Dias</td>
							<td class='titulos2' style='width:10%;text-align:center;'>Costo</td>
							<td class='titulos2'  colspan='2' style='width:6%;'>Estado</td>
							<td class='titulos2' style='width:4%'>Deshacer</td>";
					echo"</tr>";	
					$iter='saludo1a';
					$iter2='saludo2';
					$filas=1;
					$filtro=@$_POST['nombrefun'];
					$confin=$_POST['numres']*$numcontrol;
					$conini=$confin-$_POST['numres'];
					if($confin>$_POST['numtop']){$confin=$confin-($confin-$_POST['numtop']);}
					for($x=$conini;$x<$confin;$x++)
					{
						$numfil=$filas;
						$idcta=$tablavariables[$x]['num_inca'];
						$sqlrti="SELECT valor_inicial FROM dominios WHERE tipo='S' AND nombre_dominio LIKE 'LICENCIAS' AND valor_final='".$tablavariables[$x]['tipo_inca']."'";
						$respti = mysqli_query($linkbd,$sqlrti);
					 	$rowti =mysqli_fetch_row($respti);
						if(@$tablavariables[$x]['estado']=='S')
						{$imgsem="src='imagenes/sema_verdeON.jpg' title='Activa'";$coloracti="#0F0";$_POST['lswitch1'][$tablavariables[$x]['num_inca']]=0;}
						else
						{$imgsem="src='imagenes/sema_rojoON.jpg' title='Anulada'";$coloracti="#C00";$_POST['lswitch1'][$tablavariables[$x]['num_inca']]=1;}
						if($gidcta!="")
						{
							if(@$gidcta==$tablavariables[$x]['num_inca']){$estilo='background-color:yellow;';}
							else{$estilo="";}
						}
						else{$estilo="";}
						echo "
						<tr class='$iter' style='text-transform:uppercase;$estilo' onDblClick=\"verUltimaPos('$idcta','$numfil','$filtro')\" >
							<td style='text-align:right;'>".$tablavariables[$x]['num_inca']."&nbsp;</td>
							<td>$rowti[0]</td>
							<td>".$tablavariables[$x]['nom_funcionario']."</td>
							<td>".$tablavariables[$x]['meses']."</td>
							<td style='text-align:right;'>".$tablavariables[$x]['dias_total']."&nbsp;</td>
							<td style='text-align:right;'>$".number_format($tablavariables[$x]['valor_total'],0,',','.')."&nbsp;</td>
							
							<td style='text-align:center;'><img $imgsem style='width:20px'/></td>
							<td style='text-align:center;'><input type='range' name='lswitch1[]' value='".@$_POST['lswitch1'][$tablavariables[$x]['num_inca']]."' min ='0' max='1' step ='1' style='background:$coloracti; width:60%' onChange='cambioswitch(\"".$tablavariables[$x]['num_inca']."\",\"".$_POST['lswitch1'][$tablavariables[$x]['num_inca']]."\")' /></td>
							<td style='text-align:center;'><img src='imagenes/flechades.png' title='Deshacer No: ".$tablavariables[$x]['num_inca']."' style='width:18px;cursor:pointer;' onClick=\"fundeshacer('".$tablavariables[$x]['num_inca']."')\" class='icoop'/></td>
						</tr>";
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
						$filas++;
					}
					echo"
					</table>
					<table class='inicio'>
						<tr>
							<td style='text-align:center;'>
								<a href='#'>$imagensback</a>&nbsp;
									<a href='#'>$imagenback</a>&nbsp;&nbsp;";
					if($nuncilumnas<=9){$numfin=$nuncilumnas;}
					else{$numfin=9;}
					for($xx = 1; $xx <= $numfin; $xx++)
					{
						if($numcontrol<=9){$numx=$xx;}
						else{$numx=$xx+($numcontrol-9);}
						if($numcontrol==$numx){echo"<a href='#' onClick='saltocol(\"$numx\")'; style='color:#24D915'> $numx </a>";}
						else {echo"<a href='#' onClick='saltocol(\"$numx\")'; style='color:#000000'> $numx </a>";}
					}
					echo"			&nbsp;&nbsp;<a href='#'>$imagenforward</a>
								&nbsp;<a href='#'>$imagensforward</a>
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