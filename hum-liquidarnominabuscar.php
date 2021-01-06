<?php //V 1000 12/12/16 ?> 
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
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Spid - Gestion Humana</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/calendario.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
        <script>
			function deshacerli(idliq)
			{
				document.getElementById('desdel').value=idliq;
				despliegamodalm('visible','4','Esta seguro de DESHACER la liquidación de nomina N° '+idliq,'1');
			}
			function botanular(idliq)
			{
				document.getElementById('desdel').value=idliq;
				despliegamodalm('visible','4','Esta Seguro de ANULAR la liquidación de nomina N° '+idliq,'2');
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
						case "4":	document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;	
					}
				}
			}
			function funcionmensaje(){document.location.href = "";}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.getElementById('oculto').value='3';
								document.getElementById('form2').submit();
								break;
					case "2":	document.getElementById('oculto').value='4';
								document.getElementById('form2').submit();
								break;
				}
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none;"></IFRAME>
		<span id="todastablas2"></span>
		<table>
            <tr><script>barra_imagenes("hum");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("hum");?></tr>
			<tr>
  				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='hum-nominacrear.php'" class="mgbt"/><img src="imagenes/guardad.png" class="mgbt1"/><img src="imagenes/busca.png" title="Buscar" onClick="document.form2.submit();" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" onClick="mypop=window.open('hum-principal.php','','');mypop.focus();" class="mgbt"><img src='imagenes/iratras.png' title='Men&uacute; Nomina' class='mgbt' onClick="location.href='hum-menunomina.php'"/></td>
       		</tr>	
		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
            <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
            </IFRAME>
         </div>
        </div>
 		<form name="form2" id="form2" method="post" action="hum-liquidarnominabuscar.php">
        	<?php if($_POST[oculto]==""){$_POST[numpos]=0;$_POST[numres]=10;$_POST[nummul]=0;}?>
            <table class="inicio">
                <tr>
                    <td class="titulos" colspan="6" >:. Buscar Nomina Liquidada</td>
                    <td class="cerrar" style="width:7%" onClick="location.href='hum-principal.php'">Cerrar</td>
                </tr>
                <tr>
                    <td  class="saludo1">Liquidacion:</td>
                    <td ><input type="text" name="numero" id="nuemro" value="<?php echo $_POST[numero];?>" ></td>
                </tr>                       
            </table> 
            <input type="hidden" name="oculto" id="oculto" value="1"/>   
            <input type="hidden" name="desdel" id="desdel" value="<?php echo $_POST[desdel];?>"/>
            <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
    		<input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
       		<input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
			<div class="subpantalla" style="height:68.5%; width:99.6%; overflow-x:hidden;">
      		<?php
				if($_POST[oculto]=="3")
				{
					$sqlr ="DELETE FROM humnomina WHERE id_nom='$_POST[desdel]'";//1
					mysql_query($sqlr,$linkbd);
					$sqlr ="DELETE FROM hum_nom_cdp_rp WHERE nomina='$_POST[desdel]'";//2
					mysql_query($sqlr,$linkbd);
					$sqlr ="DELETE FROM humcomprobante_cab WHERE numerotipo='$_POST[desdel]'";//3
					mysql_query($sqlr,$linkbd);
					$sqlr ="DELETE FROM humnomina_det WHERE id_nom='$_POST[desdel]'";//4
					mysql_query($sqlr,$linkbd);
					$sqlr ="DELETE FROM humcomprobante_det WHERE numerotipo='$_POST[desdel]'";//5
					mysql_query($sqlr,$linkbd);
					$sqlr ="DELETE FROM humnomina_saludpension WHERE id_nom='$_POST[desdel]'";//6
					mysql_query($sqlr,$linkbd);
					$sqlr ="DELETE FROM humnominaretenemp WHERE id_nom='$_POST[desdel]'";//7
					mysql_query($sqlr,$linkbd);
					$sqlr ="DELETE FROM humnomina_parafiscales WHERE id_nom='$_POST[desdel]'";//8
					mysql_query($sqlr,$linkbd);
					$sqlr ="DELETE FROM humnom_presupuestal WHERE id_nom='$_POST[desdel]'";//9
					mysql_query($sqlr,$linkbd);
				}
				if($_POST[oculto]=="4")
				{
					$sqlr="UPDATE humnomina SET estado='N' WHERE id_nom='$_POST[desdel]'";//1
					mysql_query($sqlr,$linkbd);
					$sqlr="UPDATE hum_nom_cdp_rp SET estado='N' WHERE nomina='$_POST[desdel]'";//2
					mysql_query($sqlr,$linkbd);
					$sqlr="UPDATE humcomprobante_cab SET estado='0' WHERE numerotipo='$_POST[desdel]'";//3
					mysql_query($sqlr,$linkbd);
					$sqlr="UPDATE humnomina_det SET estado='N' WHERE id_nom='$_POST[desdel]'";//4
					mysql_query($sqlr,$linkbd);
					$sqlr="UPDATE humcomprobante_det SET estado='0' WHERE numerotipo='$_POST[desdel]'";//5
					mysql_query($sqlr,$linkbd);
					$sqlr="UPDATE humnomina_saludpension SET estado='N' WHERE id_nom='$_POST[desdel]'";//6
					mysql_query($sqlr,$linkbd);
					$sqlr="UPDATE humnominaretenemp SET estado='N' WHERE id_nom='$_POST[desdel]'";//7
					mysql_query($sqlr,$linkbd);
					$sqlr="UPDATE humnomina_parafiscales SET estado='N' WHERE id_nom='$_POST[desdel]'";//8
					mysql_query($sqlr,$linkbd);
					$sqlr="UPDATE humnom_presupuestal SET estado='N' WHERE id_nom='$_POST[desdel]'";//9
					mysql_query($sqlr,$linkbd);
				}
				$crit1=" ";
				$crit2=" ";
				if ($_POST[numero]!="")
				$crit1="AND id_nom like '%$_POST[numero]%'";
				$sqlr="SELECT * FROM humnomina WHERE estado!='' $crit1";
				$resp = mysql_query($sqlr,$linkbd);
				$_POST[numtop]=mysql_num_rows($resp);
				$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
				$sqlr="SELECT * FROM humnomina WHERE estado!='' $crit1 ORDER BY id_nom DESC LIMIT $_POST[numpos],$_POST[numres]";
				$resp = mysql_query($sqlr,$linkbd);
				$ntr = mysql_num_rows($resp);
				$con=1;
				$numcontrol=$_POST[nummul]+1;
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
				if($_POST[numpos]==0)
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
						<td colspan='10' class='titulos'>.: Resultados Busqueda:</td>
						<td class='submenu'>
							<select name='renumres' id='renumres' onChange='cambionum();' style='width:100%'>
								<option value='10'"; if ($_POST[renumres]=='10'){echo 'selected';} echo ">10</option>
								<option value='20'"; if ($_POST[renumres]=='20'){echo 'selected';} echo ">20</option>
								<option value='30'"; if ($_POST[renumres]=='30'){echo 'selected';} echo ">30</option>
								<option value='50'"; if ($_POST[renumres]=='50'){echo 'selected';} echo ">50</option>
								<option value='100'"; if ($_POST[renumres]=='100'){echo 'selected';} echo ">100</option>
							</select>
						</td>
					</tr>
					<tr><td colspan='11'>Liquidaciones Encontradas: $_POST[numtop]</td></tr>
					<tr>
						<td class='titulos2' style='width:5%'>N&deg; Nomina</td>
						<td class='titulos2' style='width:8%'>Fecha</td>
						<td class='titulos2' style='width:10%'>Periodo</td>
						<td class='titulos2' style='width:10%'>Mes</td>
						<td class='titulos2' style='width:8%'>Dias</td>
						<td class='titulos2'>CC</td>
						<td class='titulos2' style='width:8%'>Vigencia</td>
						<td class='titulos2' style='width:4%'>Estado</td>
						<td class='titulos2' style='width:4%'>Deshacer</td>
						<td class='titulos2' style='width:4%'>Anular</td>
						<td class='titulos2' style='width:4%'>Ver</td>
					</tr>";	
				$iter='saludo1a';
				$iter2='saludo2';
				while ($row =mysql_fetch_row($resp)) 
				{
					$con2=$con+ $_POST[numpos];
					$sqlr2="select count(*) from humnomina_aprobado where estado='S' and id_nom='$row[0]' ";
					$resp2 = mysql_query($sqlr2,$linkbd);
					$row2 =mysql_fetch_row($resp2);
					$conc=$row2[0];
					$sqlrp="SELECT nombre FROM humperiodos WHERE id_periodo='$row[2]'";
					$rowp =mysql_fetch_row(mysql_query($sqlrp,$linkbd));
					$vmes=ucwords(strftime('%B',mktime (0,0,0,$row[3],1,$row[7])));	
					if ($row[6]!='')
					{
						$sqlrcc="SELECT nombre from centrocosto where id_cc='$row[6]' ORDER BY ID_CC	";
						$rowcc =mysql_fetch_row(mysql_query($sqlrcc,$linkbd));	
						$vcc=$rowcc[0];
					}
					else{$vcc='TODOS';}
					$sqlrdel="SELECT IF((SELECT id_nom from humnomina_aprobado where id_nom='$row[0]'),'SI','NO');";
					$rowdel =mysql_fetch_row(mysql_query($sqlrdel,$linkbd));
					if($rowdel[0]=="NO"){$imganu="src='imagenes/anular.png' title='Anular' onClick='botanular(\"$row[0]\");'";}
					else {$imganu="src='imagenes/anulard.png' title='No se puede Anular'";}
					switch ($row[8]) 
					{
						case "P":	$imgsem="src='imagenes/sema_verdeON.jpg' title='Aprobada'";break;
						case "S":	$imgsem="src='imagenes/sema_amarilloON.jpg' title='Activa'";break;
						case "N":	$imgsem="src='imagenes/sema_rojoON.jpg' title='Anulada'";
					}
					$sqlrdes="SELECT IF((SELECT id from hum_nom_cdp_rp where nomina='$row[0]' AND (cdp='0' OR cdp='' OR cdp IS NULL)),'SI','NO');";
					$rowdes =mysql_fetch_row(mysql_query($sqlrdes,$linkbd));
					$conid=selconsecutivo('humnomina','id_nom')-1;
					if($conid==$row[0] && $rowdes[0]=="SI")
					{
						$imgdes="src='imagenes/flechades.png' title='Deshacer Liquidación' onClick='deshacerli(\"$row[0]\");'";
						$imgedi="src='imagenes/b_edit.png' title='Editar' onClick=\"location.href='hum-liquidarnominamirar.php?idnomi=$row[0]'\"";
					}
					else
					{
						$imgdes="src='imagenes/flechadesd.png' title='No se puede Deshacer'";
						$imgedi="src='imagenes/lupa02.png' title='Ver' onClick=\"location.href='hum-liquidarnominamirar.php?idnomi=$row[0]'\"";
					}
					echo "
					<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase'>
						<td>$row[0]</td>
						<td>$row[1]</td>
						<td>$rowp[0]</td>
						<td>$vmes</td>
						<td>$row[4]</td>
						<td>$vcc</td>
						<td>$row[7]</td>
						<td style='text-align:center;'><img $imgsem style='width:18px'/></td>
						<td style='text-align:center;cursor:pointer;'><img $imgdes style='width:18px'/> </td>
						<td style='text-align:center;cursor:pointer;'><img $imganu style='width:20px'/> </td>
						<td style='text-align:center;cursor:pointer;'><img $imgedi style='width:20px'/> </td>
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
				echo"			&nbsp;&nbsp;<a href='#'>$imagenforward</a>
								&nbsp;<a href='#'>$imagensforward</a>
							</td>
						</tr>
					</table>";
			?>
			</div>
            <input type="hidden" name="numtop" id="numtop" value="<?php echo $_POST[numtop];?>" />
		</form> 
	</body>
</html>