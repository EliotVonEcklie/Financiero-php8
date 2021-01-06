<?php //V 1000 12/12/16 ?> 
<!--V 1.0 24/02/2015-->
<?php
	require"comun.inc";
	require"funciones.inc";
	require"validaciones.inc";
	sesion();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Spid - Gestion Humana</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css"/>
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css"/>
		<script type="text/javascript" src="css/calendario.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
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
									break;
					case 'cel02':	document.getElementById('cel01').value=0;
									document.getElementById('cel03').value=0;
									document.getElementById('cel04').value=0;
									document.getElementById('cel05').value=0;
									break;
					case 'cel03':	document.getElementById('cel01').value=0;
									document.getElementById('cel02').value=0;
									document.getElementById('cel04').value=0;
									document.getElementById('cel05').value=0;
									break;
					case 'cel04':	document.getElementById('cel01').value=0;
									document.getElementById('cel02').value=0;
									document.getElementById('cel03').value=0;
									document.getElementById('cel05').value=0;
									break;
					case 'cel05':	document.getElementById('cel01').value=0;
									document.getElementById('cel02').value=0;
									document.getElementById('cel03').value=0;
									document.getElementById('cel04').value=0;
									break;
				}
				document.form2.submit();
			}
			function excell()
			{
				document.form2.action="hum-reportegdesexcel.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			
		</script>
		<?php titlepag(); ?>
	</head>
	<!--<body oncopy="return false" onpaste="return false">-->
    <body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("hum");</script><?php cuadro_titulos();?></tr>
			<tr><?php menu_desplegable("hum");?></tr>
			<tr>
				<td colspan="3" class="cinta"><img src="imagenes/add2.png" class="mgbt1"/><img src="imagenes/guardad.png" class="mgbt1"/><img class="mgbt" src="imagenes/busca.png" title="Buscar" onClick="document.form2.submit();"/><img class="mgbt" src="imagenes/nv.png" title="Nueva Ventana" onClick="mypop=window.open('hum-principal.php','','');mypop.focus();"/><img src="imagenes/print.png" title="Imprimir" onClick="pdf()" class="mgbt"/><img src="imagenes/excel.png" title="Excel" onClick='excell()' class="mgbt"/><img src='imagenes/iratras.png' title='Men&uacute; Nomina' class='mgbt' onClick="location.href='hum-menunomina.php'"/></td>
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
				if($_POST[oculto]=='')
				{
					$_POST[numres]=10;$_POST[numpos]=$_POST[nummul]=0;
					$_POST[cel01]=$_POST[cel02]=$_POST[cel03]=$_POST[cel04]=$_POST[cel05]=$_POST[cel06]=$_POST[cel07]=$_POST[cel08]=0;
				}
			?>
			<table class="inicio">
				<tr>
					<td class="titulos" colspan="8">:: Descuentos a Funcionarios </td>
					<td class="cerrar" style="width:7%" onClick="location.href='hum-principal.php'">Cerrar</td>
				</tr>
                <tr >
                	<td class="saludo1" style="width:3cm;">No Nomina:</td>
                	<td style="width:5%;"><input type="search" name="nomifill" id="nomifill" value="<?php echo $_POST[nomifill]?>" style="width:100%;height:30px;"/></td>
                    <td class="saludo1" style="width:3cm;">Descripción:</td>
                    <td style="width:20%;"><input type="search" name="descfill" id="descfill" value="<?php echo $_POST[descfill]?>" style="width:100%;height:30px;"/></td>
                      <td class="saludo1" style="width:3cm;">Funcionario:</td>
                    <td style="width:20%;"><input type="search" name="funcfill" id="funcfill" value="<?php echo $_POST[funcfill]?>" style="width:100%;height:30px;"/></td>
                    <td><em class="botonflecha" onClick="document.form2.submit();">Buscar</em></td>
                </tr>
			</table>
			<input type="hidden" name="oculto" id="oculto"  value="1"/>
			<input type="hidden" name="cel01" id="cel01" value="<?php echo $_POST[cel01];?>"/>
			<input type="hidden" name="cel02" id="cel02" value="<?php echo $_POST[cel02];?>"/>
			<input type="hidden" name="cel03" id="cel03" value="<?php echo $_POST[cel03];?>"/>
			<input type="hidden" name="cel04" id="cel04" value="<?php echo $_POST[cel04];?>"/>
			<input type="hidden" name="cel05" id="cel05" value="<?php echo $_POST[cel05];?>"/>
			<input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
			<input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
			<input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
			<div class="subpantalla" style="height:68.5%; width:99.6%; overflow-x:hidden;">
				<?php
					if($_POST[oculto]=="")
					{
					
					}
					if($_POST[oculto])
					{
						if($_POST[nomifill]!=""){$crit1="AND id_nom='$_POST[nomifill]'";}
						else{$crit1="";}
						if($_POST[descfill]!=""){$crit2="AND descripcion LIKE '%$_POST[descfill]%'";}
						else{$crit2="";}
						if($_POST[funcfill]!=""){$crit3="AND nombrefun LIKE '%$_POST[funcfill]%'";}
						else{$crit3="";}
						if($_POST[cel01]==0){$cl01='titulos3';$ord01=$ico01="";}
						else 
						{
							$cl01='celactiva';
							if($_POST[cel01]==1)
							{
								$ord01="ORDER BY id_nom ASC";
								$ico01="<img src='imagenes/bullet_arrow_up.png' style='width:24px;'/>";
							}
							else 
							{
								$ord01="ORDER BY id_nom DESC";
								$ico01="<img src='imagenes/bullet_arrow_down.png' style='width:24px;'/>";
							}
						}
						if($_POST[cel02]==0){$cl02='titulos3';$ord02=$ico02="";}
						else 
						{
							$cl02='celactiva';
							if($_POST[cel02]==1)
							{
								$ord02="ORDER BY fecha ASC";
								$ico02="<img src='imagenes/bullet_arrow_up.png' style='width:24px;'/>";
							}
							else 
							{
								$ord02="ORDER BY fecha DESC"; 
								$ico02="<img src='imagenes/bullet_arrow_down.png' style='width:24px;'/>";
							}
						}
						if($_POST[cel03]==0){$cl03='titulos3';$ord03=$ico03="";}
						else 
						{
							$cl03='celactiva';
							if($_POST[cel03]==1)
							{
								$ord03="ORDER BY descripcion ASC";
								$ico03="<img src='imagenes/bullet_arrow_up.png' style='width:24px;'/>";
							}
							else 
							{
								$ord03="ORDER BY descripcion DESC"; 
								$ico03="<img src='imagenes/bullet_arrow_down.png' style='width:24px;'/>";
							}
						}
						if($_POST[cel04]==0){$cl04='titulos3';$ord04=$ico04="";}
						else 
						{
							$cl04='celactiva';
							if($_POST[cel04]==1)
							{
								$ord04="ORDER BY id ASC";
								$ico04="<img src='imagenes/bullet_arrow_up.png' style='width:24px;'/>";
							}
							else 
							{
								$ord04="ORDER BY id DESC"; 
								$ico04="<img src='imagenes/bullet_arrow_down.png' style='width:24px;'/>";
							}
						}
						if($_POST[cel05]==0){$cl05='titulos3';$ord05=$ico05="";}
						else 
						{
							$cl05='celactiva';
							if($_POST[cel05]==1)
							{
								$ord05=" ORDER BY nombrefun ASC";
								$ico05="<img src='imagenes/bullet_arrow_up.png' style='width:24px;'/>";
							}
							else 
							{
								$ord05=" ORDER BY nombrefun DESC"; 
								$ico05="<img src='imagenes/bullet_arrow_down.png' style='width:24px;'/>";
							}
						}
						$sqlr="SELECT * FROM vistadescuentosempleados WHERE tipo_des='DS' $crit1 $crit2 $crit3 $ord01 $ord02 $ord03 $ord04 $ord05";
						$resp = mysql_query($sqlr,$linkbd);
						$_POST[numtop]=mysql_num_rows($resp); 
						$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
						if ($_POST[numres]!="-1"){$cond2="LIMIT $_POST[numpos], $_POST[numres]";}
						else{$cond2="";}
						$sqlr="SELECT * FROM vistadescuentosempleados WHERE tipo_des='DS' $crit1 $crit2 $crit3 $ord01 $ord02 $ord03 $ord04 $ord05 $cond2";
						$resp = mysql_query($sqlr,$linkbd);
						$numcontrol=$_POST[nummul]+1;
						if(($nuncilumnas==$numcontrol)||($_POST[numres]=="-1"))
						{
							$imagenforward="<img src='imagenes/forward02.png' style='width:17px;cursor:default;'>";
							$imagensforward="<img src='imagenes/skip_forward02.png' style='width:16px;cursor:default;' >";
						}
						else 
						{
							$imagenforward="<img src='imagenes/forward01.png' style='width:17px;cursor:pointer;' title='Siguiente' onClick='numsiguiente()'>";
							$imagensforward="<img src='imagenes/skip_forward01.png' style='width:16px;cursor:pointer;' title='Fin' onClick='saltocol(\"$nuncilumnas\")'>";
						}
						if(($_POST[numpos]==0)||($_POST[numres]=="-1"))
						{
							$imagenback="<img src='imagenes/back02.png' style='width:17px;cursor:default;'>";
							$imagensback="<img src='imagenes/skip_back02.png' style='width:16px;cursor:default;'>";
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
										<option value='10'"; if ($_POST[renumres]=='10'){echo 'selected';} echo ">10</option>
										<option value='20'"; if ($_POST[renumres]=='20'){echo 'selected';} echo ">20</option>
										<option value='30'"; if ($_POST[renumres]=='30'){echo 'selected';} echo ">30</option>
										<option value='50'"; if ($_POST[renumres]=='50'){echo 'selected';} echo ">50</option>
										<option value='100'"; if ($_POST[renumres]=='100'){echo 'selected';} echo ">100</option>
										<option value='-1'"; if ($_POST[renumres]=='-1'){echo 'selected';} echo ">Todos</option>
									</select>
								</td>
							</tr>
							<tr><td colspan='8'>Clientes Encontrados: $_POST[numtop]</td></tr>
							<tr>
								<th class='titulos3' style='width:5%;'>N°</th>
								<th class='$cl01' style='width:8%;' onClick=\"funordenar('cel01');\">N&deg; Nomi $ico01</th>
								<th class='$cl02' style='width:10%;'onClick=\"funordenar('cel02');\">Fecha $ico02</th>
								<th class='$cl03' onClick=\"funordenar('cel03');\">Descripción $ico03</th>
								<th class='$cl04' style='width:8%;' onClick=\"funordenar('cel04');\">C&oacute;digo $ico04</th>
								<th class='$cl05' style='width:30%;' onClick=\"funordenar('cel05');\">Funcionario $ico05</th>
								<th class='titulos3' style='width:8%;'>valor</th>
								<th class='titulos3' style='width:5%;'>N° Cuota</th>
							</tr>";	
						$iter='saludo1a';
						$iter2='saludo2';
						$conta=1;
						while ($row =mysql_fetch_row($resp)) 
 						{
							$nomdescr=iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$row[4]);
							$nomfunci=iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$row[10]);
							echo "
							<tr class='$iter'>
								<td>$conta</td>
								<td>$row[0]</td>
								<td>$row[3]</td>
								<td>$nomdescr</td>
								<td style='text-align:right;'>$row[1]&nbsp;&nbsp;</td>
								<td>$nomfunci</td>
								<td style='text-align:right;'>$".number_format($row[5],0,',','.')."&nbsp;</td>
								<td style='text-align:right;'>$row[6]&nbsp;</td>
							</tr>";
	 						$conta+=1;
	 						$aux=$iter;
	 						$iter=$iter2;
	 						$iter2=$aux;
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
					}
					
				?>
			</div>
            <input type="hidden" name="numtop" id="numtop" value="<?php echo $_POST[numtop];?>" />
		</form>
	</body>
</html>