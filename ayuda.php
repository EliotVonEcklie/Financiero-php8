<?php
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=iso-8859-1");
	require 'comun.inc';
	require 'funciones.inc';
	sesion();
	$linkbd=conectar_v7();
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	date_default_timezone_set("America/Bogota");
	//error_reporting(E_ALL);
	//ini_set('display_errors', '1');
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=iso-8859-1"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Spid - Administraci&oacute;n</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<style>
			input[type='text']{height:30px;}
			input[type='search']{height:30px;}
			select{height:30px;}
		</style>
		<script>
			
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
			
			
		</script>
		<?php titlepag(); ?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("ayuda");</script><?php cuadro_titulos();?></tr>
			<tr><?php menu_desplegable("ayuda");?></tr>
			<tr>
				<td colspan="3" class="cinta"><img src="imagenes/add2.png" class="mgbt1"/><img src="imagenes/guardad.png" class="mgbt1"/><img src="imagenes/buscad.png" title="Buscar"class="mgbt1"/></td>
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
				if(@ $_POST['oculto']=="")
				{
					$_POST['numpos']=0;$_POST['numres']=10;$_POST['nummul']=0;
					$_POST['idestado']=$_POST['iddeshacer']=0;
					$_POST['vardeshacer']="N";
				}
			?>
			<table class="inicio">
				<tr>
					<td class="titulos" colspan="7">.: Buscar Ayuda</td>
					<td class="cerrar" style="width:7%" onClick="location.href='adm-principal.php'">Cerrar</td>
				</tr>
				<tr>
					<td class="saludo1" style="width:2cm;" >Modulo:</td>
					<td style="width:30%">
						<select id="idmodulo" name="idmodulo" style="width:95%;text-transform:uppercase;">
							<option value=''>Seleccione....</option>
							<?php	
								$sqlr="SELECT id_modulo,nombre FROM modulos ORDER BY id_modulo ASC";
								$res=mysqli_query($linkbd,$sqlr);
								while ($row = mysqli_fetch_row($res)) 
								{
									if(@ $_POST['idmodulo']==$row[0])
									{
										echo "<option style='text-transform:uppercase;' value='$row[0]' SELECTED>$row[0] - $row[1]</option>";
									}
									else {echo "<option style='text-transform:uppercase;' value='$row[0]'>$row[0] - $row[1]</option>";}
								}
							?>
						</select>
					</td>
					<td class="tamano01" style="width:3cm; height: 34px;">Descripci&oacute;n:</td>
					<td style="width:30%;"><input type="search" style="width:100%; height:30px;" name="numero" id="numero" value="<?php echo @ $_POST['numero'];?>" /></td>
					<td colspan="2" style="padding-bottom:0px"><em class="botonflecha" onClick="document.form2.submit();">Buscar</em></td>
					<td colspan="2"></td>
				</tr>
			</table>
			<input type="hidden" name="oculto" id="oculto" value="1" />
			<input type="hidden" name="idestado" id="idestado" value="<?php echo $_POST['idestado'];?>"/> 
			<input type="hidden" name="numres" id="numres" value="<?php echo @ $_POST['numres'];?>"/>
			<input type="hidden" name="numpos" id="numpos" value="<?php echo @ $_POST['numpos'];?>"/>
			<input type="hidden" name="nummul" id="nummul" value="<?php echo @ $_POST['nummul'];?>"/>
			<div class="subpantalla" style="height:68.5%; width:99.6%; overflow-x:hidden;">
				<?php
					if (@ $_POST['idmodulo']!="")
					{
						if (@ $_POST['numero']!=""){$crit2="AND idmodulo = '".$_POST['idmodulo']."'";}
						else {$crit2="WHERE idmodulo = '".$_POST['idmodulo']."'";}
					}
					if (@ $_POST['numero']!=""){$crit1="WHERE descripcion like '%".$_POST['numero']."%' ";}
					else{$crit1=" ";}
					$sqlr="
					SELECT * FROM adm_ayuda $crit1 $crit2";
					$resp = mysqli_query($linkbd,$sqlr);
					$_POST['numtop']=mysqli_num_rows($resp);
					$nuncilumnas=ceil($_POST['numtop']/$_POST['numres']);
					$sqlr="SELECT * FROM adm_ayuda $crit1 $crit2 GROUP BY idayuda DESC LIMIT ".$_POST['numpos'].",".$_POST['numres'];
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
					if(@ $_POST['numpos']==0)
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
							<td colspan='3' class='titulos'>.: Resultados Busqueda:</td>
							<td class='submenu' colspan='3'>
								<select name='renumres' id='renumres' onChange='cambionum();' style='width:100%'>
									<option value='10'"; if (@ $_POST['renumres']=='10'){echo 'selected';} echo ">10</option>
									<option value='20'"; if (@ $_POST['renumres']=='20'){echo 'selected';} echo ">20</option>
									<option value='30'"; if (@ $_POST['renumres']=='30'){echo 'selected';} echo ">30</option>
									<option value='50'"; if (@ $_POST['renumres']=='50'){echo 'selected';} echo ">50</option>
									<option value='100'"; if (@ $_POST['renumres']=='100'){echo 'selected';} echo ">100</option>
								</select>
							</td>
						</tr>
						<tr><td colspan='5'>Vacaciones Encontradas: ".$_POST['numtop']."</td></tr>
						<tr>
							<td class='titulos2' style='width:5%'>ID</td>
							<td class='titulos2' style='width:23%'>Modulo</td>
							<td class='titulos2' >Descripci&oacute;n</td>
							<td class='titulos2' colspan='2' style='width:4%;text-align:center;'>Archivos</td>
						</tr>";	
					$iter='saludo1a';
					$iter2='saludo2';
					$cont=1;
					while ($row =mysqli_fetch_row($resp)) 
					{
						
						$sqlarc="SELECT nomarchivo FROM adm_ayuda_det WHERE estado='S' AND tipo='D' AND idayuda='$row[0]'";
						$resarc = mysqli_query($linkbd,$sqlarc);
						$rowarc = mysqli_fetch_row($resarc);
						$archdoc=$rowarc[0];
						$sqlarc="SELECT nomarchivo FROM adm_ayuda_det WHERE estado='S' AND tipo='V' AND idayuda='$row[0]'";
						$resarc = mysqli_query($linkbd,$sqlarc);
						$rowarc = mysqli_fetch_row($resarc);
						$archvid=$rowarc[0];
						if($archdoc!='')
						{
							$imgdoc="src='imagenes/fileupload.png' title='Con Documento' onClick=\"mypop=window.open('repro_pdf_ideal10.php?cod=$row[0]','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=850,height=450px');mypop.focus();\"";
						}
						else{$imgdoc="src='imagenes/fileupload2.png' title='Sin Documento'";}
						if($archvid!='')
						{
							$imgvid="src='imagenes/icovideo2.png' title='Con video' onClick=\"mypop=window.open('repro_video_ideal10.php?cod=$row[0]','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=850,height=450px');mypop.focus();\"";
						}
						else{$imgvid="src='imagenes/icovideo1.png' title='Sin video'";}
						echo "
						<tr class='$iter'>
							<td style='text-align:right;'>$cont&nbsp;</td>
							<td>$row[2]</td>
							<td>$row[3]</td>
							<td style='text-align:center;'><img $imgdoc style='width:24px'/></td>
							<td style='text-align:center;'><img $imgvid style='width:24px'/></td>
						</tr>";
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
						$cont++;
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
           
			<input type="hidden" name="numtop" id="numtop" value="<?php echo $_POST[numtop];?>" />
		</form>
        <div id="bgventanamodal2">
			<div id="ventanamodal2">
				<IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"></IFRAME>
        	</div>
		</div>
    </body>
</html>