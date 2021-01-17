<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();  
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
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
		<script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
		<script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
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
				location.href="cont-contexoconceptoseditar.php?idr="+idcta+"&scrtop="+scrtop+"&totreg="+filas+"&altura="+altura+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
			}
			function cambioswitch(id,valor)
			{
				document.getElementById('idestado').value=id;
				if(valor==1){despliegamodalm('visible','4','Desea Desactivar C�digo Interno','1');}
				else{despliegamodalm('visible','4','Desea Activar C�digo Interno','2');}
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
			function pdf()
			{
				document.form2.action="teso-pdfconsignaciones.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
		</script>
		<?php 
			titlepag();
			$scrtop=$_GET['scrtop'];
			if($scrtop=="") $scrtop=0;
			echo"<script>
				window.onload=function(){
					$('#divdet').scrollTop(".$scrtop.")
				}
			</script>";
			$gidcta=$_GET['idcta'];
			if(isset($_GET['filtro'])){$_POST[nombre]=$_GET['filtro'];}
		?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("cont");?></tr>
			<tr>
				<td colspan="3" class="cinta"><img src="imagenes/add2.png" title="Nuevo" onClick="location.href='#'" class="mgbt"/><img src="imagenes/guardad.png" title="Guardar" class="mgbt1"/><img src="imagenes/busca.png" title="Buscar" onClick="document.form2.submit();" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();" class="mgbt"><img src='imagenes/iratras.png' title='Men&uacute; Nomina' class='mgbt' onClick="location.href='cont-menuclasifcontable.php'"/></td>
			</tr>	
		</table>
		<div id="bgventanamodalm" class="bgventanamodalm">
			<div id="ventanamodalm" class="ventanamodalm">
				<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"></IFRAME>
			</div>
		</div>
		<form name="form2" method="post" action="cont-contexoconceptosbuscar.php">
			<?php
				$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
				if($_GET[numpag]!="")
				{
					if($_POST[oculto]!=2)
					{
						$_POST[numres]=$_GET[limreg];
						$_POST[numpos]=$_GET[limreg]*($_GET[numpag]-1);
						$_POST[nummul]=$_GET[numpag]-1;
					}
				}
				else
				{
					if($_POST[nummul]=="")
					{
						$_POST[numres]=10;
						$_POST[numpos]=0;
						$_POST[nummul]=0;
					}
				}
					if($_POST[oculto]==""){$_POST[cambioestado]=$_POST[nocambioestado]="";}
					//*****************************************************************
					
					//*****************************************************************
					if($_POST[nocambioestado]!="")
					{
						if($_POST[nocambioestado]=="1"){$_POST[lswitch1][$_POST[idestado]]=1;}
						else {$_POST[lswitch1][$_POST[idestado]]=0;}
						echo"<script>document.form2.nocambioestado.value=''</script>";
					}
			?>
			<table  class="inicio" align="center" >
				<tr>
					<td class="titulos" colspan="5">:. Buscar Conceptos </td>
					<td style="width:7%"><label class="boton02" onClick="location.href='cont-principal.php'">Cerrar</label></td>
				</tr>
				<tr style="height: 35px;">
					<td class="tamano01" style='width:4cm;'>:: Nombre:</td>
					<td><input type="search" name="nombre" id="nombre" value="<?php echo $_POST[nombre];?>" class="tamano02" style='width:100%;height: 35px!important;'/></td>
					<td style="padding-bottom:0px"><em class="botonflecha" onClick="limbusquedas();">Buscar</em></td>
					<td></td>
				</tr>
				<tr></tr>
			</table>
			<input type="hidden" name="oculto" id="oculto" value="1"/>
			<input type="hidden" name="cambioestado" id="cambioestado" value="<?php echo $_POST[cambioestado];?>"/>
			<input type="hidden" name="nocambioestado" id="nocambioestado" value="<?php echo $_POST[nocambioestado];?>"/>
			<input type="hidden" name="idestado" id="idestado" value="<?php echo $_POST[idestado];?>">
			<input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
			<input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
			<input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
			<div class="subpantalla" style="height:63.5%; width:99.6%;overflow-x:hidden" id="divdet">
				<?php
					//if($_POST[oculto])
					{
						$crit1="";
						if ($_POST[nombre]!=""){$crit1="WHERE nombre LIKE '%$_POST[nombre]%'";}
						$sqlr="SELECT * FROM contexoformatos $crit1";
						$resp = mysql_query($sqlr,$linkbd);
						$_POST[numtop]=mysql_num_rows($resp);
						$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
						$cond2="";
						if ($_POST[numres]!="-1"){$cond2="LIMIT $_POST[numpos], $_POST[numres]";}
						$sqlr="SELECT * FROM contexoformatos $crit1 $cond2";
						$resp = mysql_query($sqlr,$linkbd);
						$con=1;
						$numcontrol=$_POST[nummul]+1;
						if(($nuncilumnas==$numcontrol)||($_POST[numres]=="-1"))
						{
							$imagenforward="<img src='imagenes/forward02.png' style='width:17px'>";
							$imagensforward="<img src='imagenes/skip_forward02.png' style='width:16px' >";
						}
						else 
						{
							$imagenforward="<img src='imagenes/forward01.png' style='width:17px' title='Siguiente' onClick='numsiguiente()'>";
							$imagensforward="<img src='imagenes/skip_forward01.png' style='width:16px' title='Fin' onClick='saltocol(\"$nuncilumnas\")'>";
						}
						if(($_POST[numpos]==0)||($_POST[numres]=="-1"))
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
						<table class='inicio' align='center'>
							<tr>
								<td colspan='5' class='titulos'>.: Resultados Busqueda:</td>
								<td class='submenu'>
									<select name='renumres' id='renumres' onChange='cambionum();' style='width:100%'>
										<option value='10'"; if ($_POST[renumres]=='10'){echo 'selected';} echo ">10</option>
										<option value='20'"; if ($_POST[renumres]=='20'){echo 'selected';} echo ">20</option>
										<option value='30'"; if ($_POST[renumres]=='30'){echo 'selected';} echo ">30</option>
										<option value='50'"; if ($_POST[renumres]=='50'){echo 'selected';} echo ">50</option>
										<option value='100'"; if ($_POST[renumres]=='100'){echo 'selected';} echo ">100</option>
										<option value='-1'"; if ($_POST[renumres]=='-1'){echo 'selected';} echo ">Todos</option>
									</select>
								</td>
							</tr>
							<tr><td colspan='2'>Encontradas: $_POST[numtop]</td></tr>
							<tr>
								<td class='titulos2' style='width:5%;'>id</td>
								<td class='titulos2' style='width:5%;'>Codigo</td>
								<td class='titulos2'>Nombre</td>
								<td class='titulos2' colspan='2' style='text-align:center;width:7%;'>Estado</td>
								<td class='titulos2' style='width:5%;'>Cuentas</td>
							</tr>";	
						$iter='saludo1a';
						$iter2='saludo2';
						$filas=1;
						while ($row =mysql_fetch_row($resp)) 
						{
							$con2=$con+ $_POST[numpos];
							$sqlr2="SELECT * FROM contexoconceptos_det WHERE estado='S' AND idnum='$row[0]'";
							$resp2 = mysql_query($sqlr2,$linkbd);
							$concep=mysql_num_rows($resp2);
							if($row[3]=='S'){$imgsem="src='imagenes/sema_verdeON.jpg' title='Activo'";$coloracti="#0F0";$_POST[lswitch1][$row[0]]=0;}
							else{$imgsem="src='imagenes/sema_rojoON.jpg' title='Inactivo'";$coloracti="#C00";$_POST[lswitch1][$row[0]]=1;}
							if($gidcta!="")
							{
								if($gidcta==$row[0]){$estilo='background-color:yellow';}
								else {$estilo="";}
							}
							else {$estilo="";}
							$idcta="$row[1]";
							$numfil="$filas";
							$filtro="$_POST[nombre]";
							echo"<tr class='$iter' onDblClick=\"verUltimaPos('$idcta', '$numfil', '$filtro')\" style='text-transform:uppercase; $estilo'>
									<td class='icoop'>$row[0]</td>
									<td class='icoop'>$row[1]</td>
									<td class='icoop'>$row[2]</td>
									 <td style='text-align:center;'><img $imgsem style='width:20px'/></td>
									 <td><input type='range' name='lswitch1[]' value='".$_POST[lswitch1][$row[0]]."' min ='0' max='1' step ='1' style='background:$coloracti; width:60%' /></td>
									<td class='icoop' style='text-align:center;'>$concep</td>
								</tr>";

								$con+=1;
								$aux=$iter;
								$iter=$iter2;
								$iter2=$aux;
								$filas++;
 						}
						if ($_POST[numtop]==0)
						{
							echo "
							<table class='inicio'>
								<tr>
									<td class='saludo1' style='text-align:center;width:100%'><img src='imagenes\alert.png' style='width:25px'>No hay coincidencias en la b&uacute;squeda $tibusqueda<img src='imagenes\alert.png' style='width:25px'></td>
								</tr>
							</table>";
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
						</table>";
					}
				?>
			</div>
			<input type="hidden" name="numtop" id="numtop" value="<?php echo $_POST[numtop];?>" />
		</form> 
	</body>
</html>