 <?php
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=iso-8859-1");
	require 'comun.inc';
	require 'funciones.inc';
	session_start();
	$linkbd=conectar_v7();
	cargarcodigopag($_GET['codpag'],$_SESSION["nivel"]);
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Spid - Gestion Humana</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script type="text/javascript" src="css/calendario.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script type="text/javascript" src="jquery-1.11.0.min.js"></script>
		<script>
			function funordenar(var01)
			{
				if(document.getElementById(''+var01).value==0){document.getElementById(''+var01).value=1;}
				else if(document.getElementById(''+var01).value==1) {document.getElementById(''+var01).value=2;}
				else{document.getElementById(''+var01).value=0;}
				switch(var01)
				{
					case 'cel01':	document.getElementById('cel02').value=0;
									document.getElementById('cel03').value=0
									document.getElementById('cel04').value=0;
									document.getElementById('cel05').value=0;
									var cotar = document.getElementById('cel01').value
									document.getElementById('celall').value=cotar+'0000';
									break;
					case 'cel02':	document.getElementById('cel01').value=0;
									document.getElementById('cel03').value=0;
									document.getElementById('cel04').value=0;
									document.getElementById('cel05').value=0;
									var cotar = document.getElementById('cel02').value
									document.getElementById('celall').value='0'+cotar+'000';
									break;
					case 'cel03':	document.getElementById('cel01').value=0;
									document.getElementById('cel02').value=0;
									document.getElementById('cel04').value=0;
									document.getElementById('cel05').value=0;
									var cotar = document.getElementById('cel03').value
									document.getElementById('celall').value='00'+cotar+'00';
									break;
					case 'cel04':	document.getElementById('cel01').value=0;
									document.getElementById('cel02').value=0;
									document.getElementById('cel03').value=0;
									document.getElementById('cel05').value=0;
									var cotar = document.getElementById('cel04').value
									document.getElementById('celall').value='000'+cotar+'0';
									break;
					case 'cel05':	document.getElementById('cel01').value=0;
									document.getElementById('cel02').value=0;
									document.getElementById('cel03').value=0;
									document.getElementById('cel04').value=0;
									var cotar = document.getElementById('cel05').value
									document.getElementById('celall').value='0000'+cotar;
									break;
				}
				document.form2.submit();
			}
			function excell()
			{
				document.form2.action="hum-buscadescuentosnomexcel.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function verUltimaPos(idcta, filas, filtro)
			{
				var scrtop = $('#divdet').scrollTop();
				var altura = $('#divdet').height();
				var numpag = $('#nummul').val();
				var limreg = $('#numres').val();
				var numcelt = document.getElementById('celall').value;
				var fechaini = document.getElementById('fc_1198971545').value.replace(/\//gi,'');
				var fechafin = document.getElementById('fc_1198971546').value.replace(/\//gi,'');
				var filnum = document.getElementById('numero').value;
				if((numpag<=0)||(numpag=="")){numpag=0;}
				if((limreg==0)||(limreg=="")){limreg=10;}
				numpag++;
				location.href="hum-editadescuentosnom.php?idr=" + idcta + "&scrtop=" + scrtop + "&totreg=" + filas + "&altura=" + altura + "&numpag=" + numpag + "&limreg=" + limreg + "&filtro=" + filtro + "&numcelt=" + numcelt + "&feini="+ fechaini + "&fefin=" + fechafin +"&filnum=" + filnum;
			}
		</script>
		<?php
			titlepag();
			@$scrtop=$_GET['scrtop'];
			if($scrtop=="") {$scrtop=0;}
			echo"<script> window.onload=function(){ $('#divdet').scrollTop(".$scrtop.")}</script>";
			@$gidcta=$_GET['idcta'];
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
				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='hum-descuentosnom.php'" class="mgbt"/><img src="imagenes/guardad.png" class="mgbt1"/><img src="imagenes/busca.png" title="Buscar" onClick="document.form2.submit();" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" class="mgbt" onClick="mypop=window.open('hum-principal.php','','');mypop.focus();"/><img src="imagenes/excel.png" title="Excel" onClick='excell()' class="mgbt"/><img src='imagenes/iratras.png' title='Men&uacute; Nomina' class='mgbt' onClick="location.href='hum-menunomina.php'"/></td>
			</tr>
		</table>
		<form name="form2" method="post" action="hum-buscadescuentosnom.php">
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
					if(@$_POST['celall']=="")
					{
						if(@$_GET['numcelt']=="")
						{
							$_POST['cel01']=2;
							$_POST['cel02']=$_POST['cel03']=$_POST['cel04']=$_POST['cel05']=0;
							$_POST['celall']='20000';
						}
						else
						{
							$_POST['celall']=$_GET['numcelt'];
							$_POST['cel01']=substr($_POST['celall'],0,1);
							$_POST['cel02']=substr($_POST['celall'],1,1);
							$_POST['cel03']=substr($_POST['celall'],2,1);
							$_POST['cel04']=substr($_POST['celall'],3,1);
							$_POST['cel05']=substr($_POST['celall'],4,1);
						}
					}
					if(@$_GET['feini']!="")
					{
						$_POST['fecha']=substr($_GET['feini'],0,2) . '/' . substr($_GET['feini'],2,2)  . '/' . substr($_GET['feini'],4,4);
						$_POST['fecha2']=substr($_GET['fefin'],0,2) . '/' . substr($_GET['fefin'],2,2)  . '/' . substr($_GET['fefin'],4,4);
					}
					if(@$_GET['filnum']!=""){$_POST['numero']=$_GET['filnum'];}
					
				}
			?>
			<table class="inicio" align="center" >
				<tr>
					<td class="titulos" colspan="8">:. Buscar Descuentos de Nomina</td>
					<td class="cerrar" style="width:7%" onClick="location.href='hum-principal.php'">Cerrar</td>
				</tr>
				<tr>
					<td class="tamano01" style="width:2.5cm;">Fecha Inicial:</td>
					<td style="width:10%;"><input type="search" name="fecha" value="<?php echo @$_POST['fecha']?>" maxlength="10"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" style="width:75%;height:30px;" title="DD/MM/YYYY"/>&nbsp;<img src="imagenes/calendario04.png" onClick="displayCalendarFor('fc_1198971545');" title="Calendario" class="icobut"/></td>
					<td class="tamano01" style="width:2.5cm;">Fecha Final:</td>
					<td style="width:10%;"><input type="search" name="fecha2" value="<?php echo @$_POST['fecha2']?>" maxlength="10"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971546" onKeyDown="mascara(this,'/',patron,true)" style="width:75%;height:30px;" title="DD/MM/YYYY"/>&nbsp;<img src="imagenes/calendario04.png" onClick="displayCalendarFor('fc_1198971546');" title="Calendario" class="icobut"/></td>
					<td class="tamano01" style="width:1.8cm;">CC/NIT:</td>
					<td style="width:8%;"><input type="search" name="numero" id="numero" value="<?php echo @$_POST['numero'];?>" style="width:100%;height:30px"></td>
					<td class="tamano01" style="width:2.5cm;">Funcionario: </td>
					<td  style="width:25%;"><input type="search" name="nombre" id="nombre" value="<?php echo @$_POST['nombre'];?>" style="width:100%;height:30px"></td>
				</tr>
				<tr>
					<td class="tamano01" style="width:2.5cm;">Descripci&oacute;n: </td>
					<td colspan="4"><input type="search" name="descrip" id="descrip" value="<?php echo @$_POST['descrip'];?>" style="width:100%;height:30px"></td>
					<td colspan="2" style="padding-bottom:0px"><em class="botonflecha" onClick="document.form2.submit();">Buscar</em></td>
				</tr>
			</table>
			<input type="hidden" name="numres" id="numres" value="<?php echo $_POST['numres'];?>"/>
			<input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST['numpos'];?>"/>
			<input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST['nummul'];?>"/>
			<input type="hidden" name="cel01" id="cel01" value="<?php echo $_POST['cel01'];?>"/>
			<input type="hidden" name="cel02" id="cel02" value="<?php echo $_POST['cel02'];?>"/>
			<input type="hidden" name="cel03" id="cel03" value="<?php echo $_POST['cel03'];?>"/>
			<input type="hidden" name="cel04" id="cel04" value="<?php echo $_POST['cel04'];?>"/>
			<input type="hidden" name="cel05" id="cel05" value="<?php echo $_POST['cel05'];?>"/>
			<input type="hidden" name="celall" id="celall" value="<?php echo $_POST['celall'];?>"/>
			<input type="hidden" name="oculto" id="oculto" value="1">
			<div class="subpantallac5" style="height:62%; width:99.6%; overflow-x:hidden;" id="divdet">
				<?php
					if (@$_POST['numero']!=""){$crit1="AND empleado LIKE '%".$_POST['numero']."%'";}
					else {$crit1="";}
					if (@$_POST['nombre']!=""){$crit2="AND nombrefun LIKE '%".$_POST['nombre']."%'";}
					else {$crit2="";}
					if (@$_POST['descrip']!=""){$crit3="AND descripcion LIKE '%".$_POST['descrip']."%'";}
					else {$crit3="";}
					if (@$_POST['fecha']!='')
					{
						$fech1=explode("/",$_POST['fecha']);
						$fech2=explode("/",$_POST['fecha2']);
						$f1=$fech1[2]."-".$fech1[1]."-".$fech1[0];
						$f2=$fech2[2]."-".$fech2[1]."-".$fech2[0];
						$crit4="AND fecha between '$f1' AND '$f2'";
					}
					else {$crit4="";}
					if($_POST['cel01']==0){$cl01='titulos3';$ord01=$ico01="";}
					else 
					{
						$cl01='celactiva';
						if($_POST['cel01']==1)
						{
							$ord01="ORDER BY id ASC";
							$ico01="<img src='imagenes/bullet_arrow_up.png' style='width:24px;'/>";
						}
						else
						{
							$ord01="ORDER BY id DESC";
							$ico01="<img src='imagenes/bullet_arrow_down.png' style='width:24px;'/>";
						}
					}
					if($_POST['cel02']==0){$cl02='titulos3';$ord02=$ico02="";}
					else 
					{
						$cl02='celactiva';
						if($_POST['cel02']==1)
						{
							$ord02="ORDER BY descripcion ASC";
							$ico02="<img src='imagenes/bullet_arrow_up.png' style='width:24px;'/>";
						}
						else 
						{
							$ord02="ORDER BY descripcion DESC"; 
							$ico02="<img src='imagenes/bullet_arrow_down.png' style='width:24px;'/>";
						}
					}
					if($_POST['cel03']==0){$cl03='titulos3';$ord03=$ico03="";}
					else 
					{
						$cl03='celactiva';
						if($_POST['cel03']==1)
						{
							$ord03="ORDER BY empleado ASC";
							$ico03="<img src='imagenes/bullet_arrow_up.png' style='width:24px;'/>";
						}
						else 
						{
							$ord03="ORDER BY empleado DESC"; 
							$ico03="<img src='imagenes/bullet_arrow_down.png' style='width:24px;'/>";
						}
					}
					if($_POST['cel04']==0){$cl04='titulos3';$ord04=$ico04="";}
					else 
					{
						$cl04='celactiva';
						if($_POST['cel04']==1)
						{
							$ord04="ORDER BY nombrefun ASC";
							$ico04="<img src='imagenes/bullet_arrow_up.png' style='width:24px;'/>";
						}
						else 
						{
							$ord04="ORDER BY nombrefun DESC"; 
							$ico04="<img src='imagenes/bullet_arrow_down.png' style='width:24px;'/>";
						}
					}
					if($_POST['cel05']==0){$cl05='titulos3';$ord05=$ico05="";}
					else 
					{
						$cl05='celactiva';
						if($_POST['cel05']==1)
						{
							$ord05=" ORDER BY fecha ASC";
							$ico05="<img src='imagenes/bullet_arrow_up.png' style='width:24px;'/>";
						}
						else 
						{
							$ord05=" ORDER BY fecha DESC"; 
							$ico05="<img src='imagenes/bullet_arrow_down.png' style='width:24px;'/>";
						}
					}
					$sqlr="SELECT * FROM humvistadescuentos WHERE estado<>'' $crit1 $crit2 $crit3 $crit4";
					$resp = mysqli_query($linkbd,$sqlr);
					$_POST['numtop']=mysqli_num_rows($resp);
					$nuncilumnas=ceil($_POST['numtop']/$_POST['numres']);
					if ($_POST['numres']!="-1"){$cond2="LIMIT ".$_POST['numpos'].", ".$_POST['numres'];}
					else{$cond2="";}
					$sqlr="SELECT * FROM humvistadescuentos WHERE estado<>'' $crit1 $crit2 $crit3 $crit4 $ord01 $ord02 $ord03 $ord04 $ord05 $cond2";
					$resp = mysqli_query($linkbd,$sqlr);
					$ntr = mysqli_num_rows($resp);
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
					if($_POST['numpos']==0)
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
					<table class='inicio' align='center' id='columns'>
						<tr>
							<td colspan='9' class='titulos'>.: Resultados Busqueda:</td>
							<td class='submenu'>
								<select name='renumres' id='renumres' onChange='cambionum();' style='width:100%'>
									<option value='10'"; if ($_POST['renumres']=='10'){echo 'selected';} echo ">10</option>
									<option value='20'"; if ($_POST['renumres']=='20'){echo 'selected';} echo ">20</option>
									<option value='30'"; if ($_POST['renumres']=='30'){echo 'selected';} echo ">30</option>
									<option value='50'"; if ($_POST['renumres']=='50'){echo 'selected';} echo ">50</option>
									<option value='100'"; if ($_POST['renumres']=='100'){echo 'selected';} echo ">100</option>
									<option value='-1'"; if ($_POST['renumres']=='-1'){echo 'selected';} echo ">Todos</option>
								</select>
							</td>
						</tr>
						<tr><td colspan='10'>Variables Encontradas: ".$_POST['numtop']."</td></tr>
						<tr>
							<th class='$cl01' style='width:5%;' onClick=\"funordenar('cel01');\">C&oacute;digo $ico01</th>
							<th class='$cl02' onClick=\"funordenar('cel02');\">Descripci&oacute;n $ico02</th>
							<th class='$cl03' style='width:8%;' onClick=\"funordenar('cel03');\">CC/Nit $ico03</th>
							<th class='$cl04' onClick=\"funordenar('cel04');\">Empleado $ico04</th>
							<th class='$cl05' style='width:8%;' onClick=\"funordenar('cel05');\">Fecha $ico05</th>
							<th class='titulos3' style='width:8%;'>Valor</th>
							<th class='titulos3' style='width:8%;'>Valor Cuota</th>
							<th class='titulos3' style='width:5%;'>Cuotas Faltantes</th>
							<th class='titulos3' style='width:5%;'>Total Cuotas</th>
							<th class='titulos3' style='width:5%;'>Estado</th>
						</tr>";	
					$iter='saludo1a';
					$iter2='saludo2';
					while ($row =mysqli_fetch_row($resp)) 
					{
						$con2=$con+ $_POST['numpos'];
						$sqlrct="SELECT COUNT(1) FROM humnominaretenemp WHERE id='$row[0]' AND estado='P' AND tipo_des='DS'";
						$resct=mysqli_query($linkbd,$sqlrct);
						$rowct=mysqli_fetch_row($resct);
						$cuotaf=$row[6]-$rowct[0];
						$estadopg="";
						if($cuotaf==0 && $row[10]=='H')
						{
							$sqlrct="UPDATE humretenempleados SET estado='P', habilitado='D' WHERE id='$row[0]'";
							mysqli_query($linkbd,$sqlrct);$estadopg="S";
						}
						if($row[9]=='P' || $estadopg=="S"){$imgsem="src='imagenes/sema_azul1ON.jpg' title='Paga'";}
						elseif($row[10]=='H'){$imgsem="src='imagenes/sema_verdeON.jpg' title='Activo'";}
						else {$imgsem="src='imagenes/sema_rojoON.jpg' title='Inactiva'";}
						$nomdesc=iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",@$row[1]);
						$nemp=iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",@$row[11]);
						$fechar=date('d-m-Y',strtotime($row[3]));
						if($gidcta!="")
						{
							if($gidcta==$row[0]){$estilo='background-color:yellow';}
							else{$estilo="";}
						}
						else{$estilo="";}
						$idcta=@$row[0];
						$numfil=@$filas;
						$filtro=@$_POST['nombre'];
						echo"
						<tr class='$iter' onDblClick=\"verUltimaPos('$idcta','$numfil','$filtro')\" style='text-transform:uppercase; $estilo' id='$row[0]'>
							<td>$row[0]</td>
							<td>$nomdesc</td>
							<td>$row[4]</td>
							<td>$nemp</td>
							<td>$fechar</td>
							<td style='text-align:right;'>$".number_format($row[5])."</td>
							<td style='text-align:right;'>$".number_format($row[8])."</td>
							<td style='text-align:center;'>$cuotaf</td>
							<td style='text-align:center;'>$row[6]</td>
							<td style='text-align:center;'><img $imgsem style='width:20px'/></td>
						</tr>";
						$con+=1;
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
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
					echo"		&nbsp;&nbsp;<a href='#'>$imagenforward</a>
								&nbsp;<a href='#'>$imagensforward</a>
							</td>
						</tr>
					</table>";
				?>
			</div>
			<input type="hidden" name="numtop" id="numtop" value="<?php echo $_POST['numtop'];?>" />
		</form>
	</body>
</html>