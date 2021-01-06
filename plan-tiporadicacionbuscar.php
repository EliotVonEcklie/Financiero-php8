<?php
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=iso-8859-1");
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_v7();
	cargarcodigopag($_GET['codpag'],$_SESSION["nivel"]);
	date_default_timezone_set("America/Bogota");
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
		<script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
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
				location.href="plan-tiporadicacioneditar.php?idtradica="+idcta+"&scrtop="+scrtop+"&totreg="+filas+"&altura="+altura+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
			}
			function cambioswitch(id,valor)
			{
				document.getElementById('idestado').value=id;
				if(valor==1){despliegamodalm('visible','4','Desea Activar este Tipo de Radicación','1');}
				else{despliegamodalm('visible','4','Desea Desactivar este Tipo de Radicación','2');}
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
		<?php 
			titlepag();
			$scrtop=$_GET['scrtop'];
			if($scrtop==""){$scrtop=0;}
			echo"<script>window.onload=function(){ $('#divdet').scrollTop(".$scrtop.")}</script>";
			$gidcta=$_GET['idcta'];
			//if(@ isset($_GET['filtro'])){$_POST['descrip']=$_GET['filtro'];}
		?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("plan");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("plan");?></tr>
			<tr>
				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='plan-tiporadicacion.php'" class="mgbt"/><img src="imagenes/guardad.png" class="mgbt1"/><img src="imagenes/busca.png" title="Buscar" onClick="document.form2.submit();" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" onClick="<?php echo paginasnuevas("plan");?>" class="mgbt"/></td>
			</tr>
		</table>
		<div id="bgventanamodalm" class="bgventanamodalm">
			<div id="ventanamodalm" class="ventanamodalm">
				<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"></IFRAME>
			</div>
		</div>
		<?php
			if(@ $_GET['numpag']!="")
			{
				if(@ $_POST['oculto']!=2)
				{
					$_POST['numres']=$_GET['limreg'];
					$_POST['numpos']=$_GET['limreg']*($_GET['numpag']-1);
					$_POST['nummul']=$_GET['numpag']-1;
				}
			}
			else
			{
				if(@ $_POST['nummul']=="")
				{
					$_POST['numres']=10;
					$_POST['numpos']=0;
					$_POST['nummul']=0;
				}
			}
		?>
		<form name="form2" method="post" action=""> 
			<?php
				if(@ $_POST['oculto']=="")
				{
					$_POST['oculto2']="0";
					$_POST['cambioestado']="";
					$_POST['nocambioestado']="";
				}
				if(@ $_POST['cambioestado']!="")
				{
					if(@ $_POST['cambioestado']=="1")
					{
						$sqlr="UPDATE plantiporadicacion SET estado='S' WHERE codigo='".$_POST['idestado']."'";
						mysqli_fetch_row(mysql_query($linkbd,$sqlr)); 
					}
					else 
					{
						$sqlr="UPDATE plantiporadicacion SET estado='N' WHERE codigo='".$_POST['idestado']."'";
						mysqli_fetch_row(mysql_query($linkbd,$sqlr)); 
					}
					echo"<script>document.form2.cambioestado.value=''</script>";
				}
				if(@ $_POST['nocambioestado']!="")
				{
					if(@ $_POST['nocambioestado']=="1"){$_POST['lswitch1'][$_POST['idestado']]=1;}
					else {$_POST['lswitch1'][$_POST['idestado']]=0;}
					echo"<script>document.form2.nocambioestado.value=''</script>";
				}
			?>
			<table class="inicio">
				<tr>
					<td colspan="2" class="titulos">:.Buscar Tipos de Radicaci&oacute;n</td>
					<td class="cerrar" style="width:7%" onClick="location.href='plan-principal.php'">&nbsp;Cerrar</td>
				</tr>
				<tr><td colspan="5" class="titulos2">:&middot;Por Descripci&oacute;n</td></tr>
				<tr>
					<td class="saludo1" style="width:4cm;">:&middot; Tipo Radicaci&oacute;n:</td>
					<td>
						<input type="search" name="descrip" id="descrip" value="<?php echo @ $_POST['descrip'];?>" style="width:50%"/>
						<input type="button" name="bboton" onClick="limbusquedas();" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;" />
					</td>
				</tr>
			</table>
			<input name="oculto" type="hidden" id="oculto" value="1"/>
			<input name="ac" type="hidden" id="ac" value="1"/>
			<input name="cod" type="hidden" id="cod" value="1"/>
			<input type="hidden" name="cambioestado" id="cambioestado" value="<?php echo $_POST['cambioestado'];?>">
			<input type="hidden" name="nocambioestado" id="nocambioestado" value="<?php echo $_POST['nocambioestado'];?>">
			<input type="hidden" name="idestado" id="idestado" value="<?php echo @ $_POST['idestado'];?>">
			<input type="hidden" name="numres" id="numres" value="<?php echo @ $_POST['numres'];?>"/>
			<input type="hidden" name="numpos" id="numpos" value="<?php echo @ $_POST['numpos'];?>"/>
			<input type="hidden" name="nummul" id="nummul" value="<?php echo @ $_POST['nummul'];?>"/>
			<div class="subpantallap" style="height:65%; width:99.6%; overflow-x:hidden;" id="divdet">
				<?php 
					if (@ $_POST['descrip']!=""){$cond="AND concat_ws(' ',nombre,descripcion) LIKE '%".$_POST['descrip']."%'";}
					else{$cond="";}
					$sqlr="SELECT distinct * FROM plantiporadicacion WHERE radotar='RA' $cond";
					$resp=mysqli_query($linkbd,$sqlr);
					$_POST['numtop']=mysqli_num_rows($resp);
					$nuncilumnas=ceil($_POST['numtop']/$_POST['numres']);
					$cond2="";
					if (@ $_POST['numres']!="-1"){$cond2="LIMIT ".$_POST['numpos'].", ".$_POST['numres'];}
					$sqlr="SELECT distinct * FROM plantiporadicacion WHERE radotar='RA' $cond ORDER BY codigo ASC ".$cond2;
					$resp=mysqli_query($linkbd,$sqlr);
					$numcontrol=$_POST['nummul']+1;
					if(($nuncilumnas==$numcontrol)||($_POST['numres']=="-1"))
					{
						$imagenforward="<img src='imagenes/forward02.png' style='width:17px;cursor:default;'>";
						$imagensforward="<img src='imagenes/skip_forward02.png' style='width:16px;cursor:default;'>";
					}
					else 
					{
						$imagenforward="<img src='imagenes/forward01.png' style='width:17px;cursor:pointer;' title='Siguiente' onClick='numsiguiente()'>";
						$imagensforward="<img src='imagenes/skip_forward01.png' style='width:16px;cursor:pointer;' title='Fin' onClick='saltocol(\"$nuncilumnas\")'>";
					}
					if((@ $_POST['numpos']==0)||(@ $_POST['numres']=="-1"))
					{
						$imagenback="<img src='imagenes/back02.png' style='width:17px;cursor:default;'>";
						$imagensback="<img src='imagenes/skip_back02.png' style='width:16px;cursor:default;'>";
					}
					else
					{
						$imagenback="<img src='imagenes/back01.png' style='width:17px;cursor:pointer;' title='Anterior' onClick='numanterior();'>";
						$imagensback="<img src='imagenes/skip_back01.png' style='width:16px;cursor:pointer;' title='Inicio' onClick='saltocol(\"1\")'>";
					}
					$iter='saludo1a';
					$iter2='saludo2';
					$cont1=1;
					echo"
					<table class='inicio'>
						<tr>
							<td class='titulos' colspan='7'>:: Lista de Tipos de Radicaci&oacute;n</td>
							<td class='submenu'>
								<select name='renumres' id='renumres' onChange='cambionum();' style='width:100%'>
									<option value='10'"; if (@ $_POST['renumres']=='10'){echo 'selected';} echo ">10</option>
									<option value='20'"; if (@ $_POST['renumres']=='20'){echo 'selected';} echo ">20</option>
									<option value='30'"; if (@ $_POST['renumres']=='30'){echo 'selected';} echo ">30</option>
									<option value='50'"; if (@ $_POST['renumres']=='50'){echo 'selected';} echo ">50</option>
									<option value='100'"; if (@ $_POST['renumres']=='100'){echo 'selected';} echo ">100</option>
									<option value='-1'"; if (@ $_POST['renumres']=='-1'){echo 'selected';} echo ">Todos</option>
								</select>
							</td>
						</tr>
						<tr><td colspan='8'>Encontrados: ".$_POST['numtop']."</td></tr>
						<tr>
							<td class='titulos2' style='width:5%;'>Id</td>
							<td class='titulos2'>Nombre</td>
							<td class='titulos2'>D&iacute;as Respuesta</td>
							<td class='titulos2'>Descripci&oacute;n</td>
							<td class='titulos2'>Adjunto</td>
							<td class='titulos2'>Tipo PQR</td>
							<td class='titulos2' colspan='2' style='width:6%'>Estado</td>
						</tr>";
					$modfictbl='tablamodificar';
					$contador1=0;
					$filas=1;
					while ($row = mysqli_fetch_row($resp)) 
					{
						if($row[7]=='S')
						{
							$imgsem="src='imagenes/sema_verdeON.jpg' title='Activo'";
							$coloracti="#0F0";$_POST['lswitch1'][$row[0]]=0;
						}
						else{$imgsem="src='imagenes/sema_rojoON.jpg' title='Inactivo'";$coloracti="#C00";$_POST['lswitch1'][$row[0]]=1;}
						if($row[6]=="S"){$vsino="SI";}
						else{$vsino="NO";}
						if($row[4]=="H"){$tipdia="Habiles";}
						elseif($row[4]=="C"){$tipdia="Calendario";}
						else{$tipdia="";}
						if($gidcta!=""){
							if($gidcta==$row[0]){$estilo='background-color:yellow';}
							else{$estilo="";}
						}
						else{$estilo="";}
						switch ($row[11])
						{
							case "N":	$tipopqr="N - Ninguno";break;
							case "P":	$tipopqr="P - Petición";break;
							case "Q":	$tipopqr="Q - Queja";break;
							case "R":	$tipopqr="R - Reclamo";break;
							case "S":	$tipopqr="S - Sugerencia";break;
							case "D":	$tipopqr="D - Denuncia";break;
							case "F":	$tipopqr="F - Felicitación";
						}
						$cont2=$cont1+ $_POST['numpos'];
						$idcta="'$row[0]'";
						$numfil="'$filas'";
						$filtro="'".@ $_POST['descrip']."'";
						echo"
						<tr class='$iter' onDblClick=\"verUltimaPos($idcta, $numfil, $filtro)\" style='text-transform:uppercase; $estilo' >
							<td>$cont2</td>
							<td>$row[1]</td>
							<td>$row[3] D&iacute;as $tipdia</td>
							<td>$row[2]</td>
							<td style='text-align:center;'>$vsino</td>
							<td>$tipopqr</td>
							<td style='text-align:center;'><img $imgsem style='width:20px'/></td>
						<td><input type='range' name='lswitch1[]' value='".$_POST['lswitch1'][$row[0]]."' min ='0' max='1' step ='1' style='background:$coloracti; width:60%' onChange='cambioswitch(\"$row[0]\",\"".$_POST['lswitch1'][$row[0]]."\")' /></td>
						</tr>";
						$aux2=$row[0];
						$arreventos[0][$aux2]=$row[1];
						$arreventos[1][$aux2]=$row[2];
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
						$contador1++;
						$cont1++;
						$filas++;
					}
					if (@ $_POST['numtop']==0)
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
						if($numcontrol==$numx){echo"<a onClick='saltocol(\"$numx\")'; style='color:#24D915;cursor:pointer;'> $numx </a>";}
						else {echo"<a onClick='saltocol(\"$numx\")'; style='color:#000000;cursor:pointer;'> $numx </a>";}
					}
					echo "		&nbsp;&nbsp;<a>$imagenforward</a>
								&nbsp;<a>$imagensforward</a>
							</td>
						</tr>
					</table>";
				?>
			</div>
			<input type="hidden" name="numtop" id="numtop" value="<?php echo @ $_POST['numtop'];?>" />
		</form>
	</body>
</html>