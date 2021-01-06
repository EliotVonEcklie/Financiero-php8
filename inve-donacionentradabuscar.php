<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	header("Content-Type: text/html;charset=iso-8859-1");
	date_default_timezone_set("America/Bogota"); 
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
        <script>
			var ctrlPressed = false;
			var tecla01 = 16, tecla02 = 80, tecla03 = 81;
			$(document).keydown(
				function(e){
					
					if (e.keyCode == tecla01){ctrlPressed = true;}
					if (e.keyCode == tecla03){tecla3Pressed = true;}
					if (ctrlPressed && (e.keyCode == tecla02) && tecla3Pressed)
					{
						
						if(document.form2.iddeshff.value=="0"){document.form2.iddeshff.value="1";}
						else {document.form2.iddeshff.value="0";}
						document.form2.submit();
					}
					})
					$(document).keyup(function(e){if (e.keyCode ==tecla01){ctrlPressed = false;}})
					$(document).keyup(function(e){if (e.keyCode ==tecla03){tecla3Pressed = false;}
				})
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
		<?php titlepag(); ?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
    		<tr><script>barra_imagenes("inve");</script><?php cuadro_titulos();?></tr>	 
    		<tr><?php menu_desplegable("inve");?></tr>
			<tr>
  				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='inve-donacionentrada.php'" class="mgbt"/><img src="imagenes/guardad.png" class="mgbt1"/><img src="imagenes/busca.png" title="Buscar" onClick="document.form2.submit();" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" class="mgbt" onClick="mypop=window.open('inve-principal.php','','');mypop.focus();"><img src="imagenes/printd.png" class="mgbt1"/></td>
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
				if($_POST[oculto]=="")
				{
					$_POST[numpos]=0;
					$_POST[numres]=10;
					$_POST[nummul]=0;
					$_POST[iddeshff]=0;
					$_POST[idestado]=$_POST[iddeshacer]=0;
					$_POST[vardeshacer]="N";
				}
				if($_POST[cambioestado]!="")
				{
					if($_POST[cambioestado]=="1")
					{
                        $sqlr="UPDATE hum_incapacidades SET estado='S' WHERE num_inca='$_POST[idestado]'";
                     	mysql_fetch_row(mysql_query($sqlr,$linkbd)); 
						$sqlr="UPDATE hum_incapacidades_det SET estado='S' WHERE num_inca='$_POST[idestado]' AND estado!='D'";
                     	mysql_fetch_row(mysql_query($sqlr,$linkbd)); 
					}
					else 
					{
                        $sqlr="UPDATE hum_incapacidades SET estado='N' WHERE num_inca='$_POST[idestado]'";
                     	mysql_fetch_row(mysql_query($sqlr,$linkbd)); 
						$sqlr="UPDATE hum_incapacidades_det SET estado='N' WHERE num_inca='$_POST[idestado]' AND estado!='D'";
                     	mysql_fetch_row(mysql_query($sqlr,$linkbd));
					}
					echo"<script>document.form2.cambioestado.value=''</script>";
				}
			?>
        	<input type="hidden" name="iddeshff" id="iddeshff" value="<?php echo $_POST[iddeshff];?>"/>
        	<table class="inicio">
      			<tr>
        			<td class="titulos" colspan="5">.: Buscar Actos Administrativos de Acuerdo de Donaci&oacute;n</td>
                    <td class="cerrar" style="width:7%" onClick="location.href='inve-principal.php'">Cerrar</td>
      			</tr>
               <tr>
                    <td class="saludo1" style="width:3cm;">Donante:</td>
                    <td style="width:30%;"><input type="search" style="width:100%; height:30px;" name="numero" id="numero" value="<?php echo $_POST[numero];?>" /></td>
                   <td style="width:10%;"><label class="boton02" onClick="document.form2.submit();">&nbsp;&nbsp;Buscar&nbsp;&nbsp;</label></td>
                   <td colspan="2"></td>
                </tr>
        	</table>
            <input type="hidden" name="oculto" id="oculto" value="1"/>  
            <input type="hidden" name="cambioestado" id="cambioestado" value="<?php echo $_POST[cambioestado];?>"/>
    		<input type="hidden" name="nocambioestado" id="nocambioestado" value="<?php echo $_POST[nocambioestado];?>"/>
    		<input type="hidden" name="idestado" id="idestado" value="<?php echo $_POST[idestado];?>"/> 
            <input type="hidden" name="iddeshacer" id="iddeshacer" value="<?php echo $_POST[iddeshacer];?>"/> 
             <input type="hidden" name="vardeshacer" id="vardeshacer" value="<?php echo $_POST[vardeshacer];?>"/>
            <input type="hidden" name="desdel" id="desdel" value="<?php echo $_POST[desdel];?>"/>
            <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
    		<input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
       		<input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
            
            <div class="subpantalla" style="height:68.5%; width:99.6%; overflow-x:hidden;">
            	<?php
					if ($_POST[numero]!=""){$crit1="WHERE nomdonante like '%$_POST[numero]%' ";}
					else{$crit1=" ";}
					$sqlr="
					SELECT id FROM almactodonacionesent $crit1";
					$resp = mysql_query($sqlr,$linkbd);
					$_POST[numtop]=mysql_num_rows($resp);
					$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
					$sqlr="
					SELECT id,fecha,nomdonante,motivo,valortotal,estado FROM almactodonacionesent $crit1 GROUP BY id ASC LIMIT $_POST[numpos], $_POST[numres]";
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
							<td colspan='5' class='titulos'>.: Resultados Busqueda:</td>
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
						<tr><td colspan='6'>Donaciones Encontradas: $_POST[numtop]</td></tr>
						<tr>
							<th class='titulos2' style='width:5%'>No.</th>
							<th class='titulos2' style='width:10%'>FECHA</th>
							<th class='titulos2' style='width:23%'>DONANTE</td>
							<td class='titulos2'>MOTIVO</td>
							<td class='titulos2' style='width:10%'>VALOR</td>
							<td class='titulos2' style='width:6%;'>ESTADO</td>
						</tr>";	
					$iter='saludo1a';
					$iter2='saludo2';
					while ($row =mysql_fetch_row($resp)) 
					{
						switch($row[5])
						{
							case 'S':	$imgsem="src='imagenes/sema_verdeON.jpg' title='Asignada'";
										$imganu="src='imagenes/borrar02.png' title='No se puede Anular'";break;
							case 'N':	$imgsem="src='imagenes/sema_rojoON.jpg' title='Anulada'";
										$imganu="src='imagenes/borrar02.png' title='Ya se encuentra Anulada'";break;
							case 'A':	$imgsem="src='imagenes/sema_amarilloON.jpg' title='Activa'";
										$imganu="src='imagenes/borrar01.png' title='Disponible para Anular'";break;
						}
						echo "
						<tr class='$iter' style='text-transform:uppercase' onDblClick=\"location.href='inve-donacionentradaedita.php?codi=$row[0]'\">
							<td style='text-align:right;'>$row[0]&nbsp;</td>
							<td>$row[1]</td>
							<td>".iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$row[2])."</td>
							<td>".iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$row[3])."</td>
							<td style='text-align:right;'>$".number_format($row[4],0,',','.')."&nbsp;</td>
							<td style='text-align:center;'><img $imgsem style='width:20px'/></td>
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