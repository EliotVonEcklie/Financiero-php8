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
        <title>:: Spid - Meci Calidad</title>
        <script type="text/javascript" src="css/programas.js"></script>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script>
			function eliminar_arch(cod1,narch)
			{ 
				if (confirm("Esta Seguro de Eliminar el Documento "+narch.toUpperCase()))
				{
					document.getElementById('idclase').value=cod1;
					document.getElementById('archdel').value=narch;
					document.getElementById('ocudelplan').value="1";
					document.form2.submit();
				}
			}
			function cambioswitch(id,valor)
			{
				if(valor==1)
				{
					if (confirm("Desea activar esta Normativa")){document.form2.cambioestado.value="1";}
					else{document.form2.nocambioestado.value="1"}
				}
				else
				{
					if (confirm("Desea Desactivar esta Normativa")){document.form2.cambioestado.value="0";}
					else{document.form2.nocambioestado.value="0"}
				}
				document.getElementById('idestado').value=id;
				document.form2.submit();
			}
		</script>
         <style>
			input[type='range'] {
			-webkit-appearance: none;
			border-radius: 5px;
			box-shadow: inset 0 0 5px #333;
			background-color: #999;
			height: 10px;
			vertical-align: middle;
			}
		</style>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
			<tr><script>barra_imagenes("meci");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("meci");?></tr>
          	<tr>
          		<td colspan="3" class="cinta"><a href="meci-insparticipacion.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a><a href="#"  onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar"/></a><a href="#" class="mgbt" onClick="document.form2.submit();"><img src="imagenes/busca.png" title="Buscar"/></a><a href="#" class="mgbt" onClick="mypop=window.open('meci-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
        	</tr>
		</table>
		<form name="form2" method="post" action="meci-insparticipacionbusca.php" enctype="multipart/form-data">
        <?php
			if($_POST[oculto]=="")
			{
				$_POST[oculto]="0";
				$_POST[cambioestado]="";
				$_POST[nocambioestado]="";
			}
			//*****************************************************************
				if($_POST[cambioestado]!="")
				{
					$linkbd=conectar_bd();
					if($_POST[cambioestado]=="1")
					{
						if($_POST[proceso]!="CPE"){$sqlr="UPDATE mecinsparticipacion SET estado='S' WHERE id='".$_POST[idestado]."'";}
						else{$sqlr="UPDATE meciprotocoloseticos SET estado='S' WHERE id='".$_POST[idestado]."'";}
                     	mysql_fetch_row(mysql_query($sqlr,$linkbd)); 
					}
					else 
					{
						if($_POST[proceso]!="CPE"){$sqlr="UPDATE mecinsparticipacion SET estado='N' WHERE id='".$_POST[idestado]."'";}
                        else{$sqlr="UPDATE meciprotocoloseticos SET estado='N' WHERE id='".$_POST[idestado]."'";}
                     	mysql_fetch_row(mysql_query($sqlr,$linkbd)); 
					}
				}
				
				//*****************************************************************
				if($_POST[nocambioestado]!="")
				{
					if($_POST[nocambioestado]=="1"){$_POST[lswitch1][$_POST[idestado]]=1;}
					else {$_POST[lswitch1][$_POST[idestado]]=0;}
					$_POST[nocambioestado]="";
				}
		?>
        	<table class="inicio" >
				<tr>
                	<td class="titulos" colspan="4" style="width:95%">:: Buscar Estrucctura Organizacional </td>
                	<td class="cerrar" style="width:5%"><a href="meci-principal.php">Cerrar</a></td>
              	</tr>
              	<tr>
                	<td style="width:9%" class="saludo1">Clase Proceso:</td>
                	<td style="width:11%">
                    	<select name="proceso" id="proceso" onKeyUp="return tabular(event,this)" style="width:95%;" onChange="document.form2.submit();" >
                        	<option value="" <?php if($_POST[proceso]=='') {echo "SELECTED";}?>>....</option>
          					<option value="CCI" <?php if($_POST[proceso]=='CCI') {echo "SELECTED";}?>>Comit&eacute; Coordinador CI</option>
                            <option value="RAD" <?php if($_POST[proceso]=='RAD') {echo "SELECTED";}?>>Alta Direcci&oacute;n</option>
                            <option value="REM" <?php if($_POST[proceso]=='REM') {echo "SELECTED";}?>>Equipo Meci</option>
                            <option value="CPE" <?php if($_POST[proceso]=='CPE') {echo "SELECTED";}?>>Protocolos Eticos</option>
        				</select>
                    </td>
                    <td style="width:10%;"></td>
                    <td style="width:43%;"></td>
               </tr>                       
   			</table>
            <input name="idclase" id="idclase" type="hidden" value="<?php echo $_POST[idclase]?>">
            <input name="contador" id="contador" type="hidden" value="<?php echo $_POST[contador]?>">
            <input name="archdel" id="archdel" type="hidden" value="<?php echo $_POST[archdel]?>">
            <input name="ocudelplan" id="ocudelplan" type="hidden" value="<?php echo $_POST[ocudelplan]?>">
            <div class="subpantallac5" style="height:68%; width:99.5%; overflow-x:hidden">
            	<?php
					$linkbd=conectar_bd();
					//Cargar Archivo
					if (is_uploaded_file($_FILES['upload']['tmp_name'][$_POST[contador]])) 
					{	
						$trozos = explode(".",$_FILES['upload']['name'][$_POST[contador]]);  
						$extension = end($trozos);  
						$nomar=$_FILES['upload']['name'][$_POST[contador]];
						copy($_FILES['upload']['tmp_name'][$_POST[contador]], "informacion/protocolos_eticos/".$nomar);
						$sqlr="UPDATE meciprotocoloseticos SET adjunto='".$nomar."' WHERE id='".$_POST[idclase]."'";
						mysql_query($sqlr,$linkbd);
					}
					//Eliminar Archivos
					if($_POST['ocudelplan']=="1")
					{
						$sqlr="UPDATE meciprotocoloseticos SET adjunto='' WHERE id='".$_POST[idclase]."'";
						mysql_query($sqlr,$linkbd);
						unlink("informacion/protocolos_eticos/".$_POST[archdel]);
						?><script>document.form2.ocudelplan.value="2";</script><?php
					}
					//************************************************************************
					if($_POST[proceso]!="")
					{
						switch($_POST[proceso])
						{
							case 'CCI':
								$clase="Comit&eacute; Coordinador CI";
								break;
							case 'RAD':
								$clase="Alta Direcci&oacute;n";
								break;
							case 'REM':
								$clase="Equipo Meci";
								break;
						}
						if($_POST[proceso]!="CPE")
						{
							$sqlr="SELECT * FROM mecinsparticipacion WHERE clase='".$_POST[proceso]."'  ORDER BY id ASC";
							$resp = mysql_query($sqlr,$linkbd);
							$ntr = mysql_num_rows($resp);
							$con=1;
							$iter='saludo1';
							$iter2='saludo2';
							echo "
								<table class='inicio' align='center' width='80%'>
									<tr>
										<td colspan='10' class='titulos'>.: Resultados Busqueda:</td>
									</tr>
									<tr class='saludo3'>
										<td colspan='10'>Encontrados: $ntr</td>
									</tr>
									<tr>
										<td class='titulos' style='width:4%;'>N&deg;</td>
										<td class='titulos' style='width:15%;'>Clase</td>
										<td class='titulos' style='width:10%;'>Documento</td>
										<td class='titulos' style='width:30%;'>Nombre</td>
										<td class='titulos' style='width:15%;'>Cargo</td>
										<td class='titulos' style='width:8%;'>Fecha Inicio</td>
										<td class='titulos' style='width:8%;'>Fecha Retiro</td>
										<td class='titulos' style='width:6%;' colspan='2'>Estado</td>
										<td class='titulos' style='width:4%;'>Editar</td>
									</tr>";
							while ($row =mysql_fetch_row($resp)) 
							{
								if($row[6]=='S')
								{$imgsem="src='imagenes/sema_verdeON.jpg' title='Activo'";$coloracti="#0F0";$_POST[lswitch1][$row[0]]=0;}
								else
								{$imgsem="src='imagenes/sema_rojoON.jpg' title='Inactivo'";$coloracti="#C00";;$_POST[lswitch1][$row[0]]=1;}							$nombre=buscaresponsable($row[2]);
								$fechai=date("d-m-Y",strtotime($row[4]));
								$fechar=date("d-m-Y",strtotime($row[5]));
								$imgedi="<a href='meci-insparticipacioneditar.php?id=".$row[0]."&clase=".$_POST[proceso]."'><img src='imagenes/b_edit.png' style='width:18px' title='Editar'></a>";
								$sqlrcg="SELECT nombre FROM mecivariables WHERE id='".$row[3]."'";
								$rowcg =mysql_fetch_row(mysql_query($sqlrcg,$linkbd));
								echo "
									<tr class='$iter'>	
										<td>$con</td>
										<td>$clase</td>
										<td>$row[2]</td>
										<td>".substr(ucwords(strtolower(str_replace("&lt;br/&gt;","\n",$nombre))), 0, 80)."</td>
										<td>$rowcg[0]</td>
										<td>$fechai</td>
										<td>$fechar</td>
										<td style='text-align:center;'><img $imgsem style='width:20px'/></td>
										<td><input type='range' name='lswitch1[]' value='".$_POST[lswitch1][$row[0]]."' min ='0' max='1' step ='1' style='background:$coloracti; width:60%' onChange='cambioswitch(\"".$row[0]."\",\"".$_POST[lswitch1][$row[0]]."\")' /></td>
										<td style='text-align:center;'>$imgedi</td>
									</tr>";
								 $con+=1;
								 $aux=$iter;
								 $iter=$iter2;
								 $iter2=$aux;
							}
							echo"</table>";
						}
						else
						{
							$sqlr="SELECT * FROM meciprotocoloseticos ORDER BY id ASC";
							$resp = mysql_query($sqlr,$linkbd);
							$ntr = mysql_num_rows($resp);
							$contad=0;
							$con=1;
							$iter='saludo1';
							$iter2='saludo2';
							echo "
								<table class='inicio' align='center' width='80%'>
									<tr>
										<td colspan='10' class='titulos'>.: Resultados Busqueda:</td>
									</tr>
									<tr class='saludo3'>
										<td colspan='10'>Encontrados: $ntr</td>
									</tr>
									<tr>
										<td class='titulos2' style='width:4%'>Item</td>
										<td class='titulos2' style='width:10%'>Clase</td>
										<td class='titulos2' style='width:39%'>Descripci&oacute;n</td>
										<td class='titulos2' style='width:8%'>Fecha</td>
										<td class='titulos2' style='width:8%' colspan='3'>Documentos</td>
										<td class='titulos2' style='width:6%' colspan='2'>Estado</td>
										<td class='titulos2' style='width:4%'>Editar</td>
									</tr>";
							while ($row =mysql_fetch_row($resp)) 
							{
								if($row[5]=='S')
								{$imgsem="src='imagenes/sema_verdeON.jpg' title='Activo'";$coloracti="#0F0";$_POST[lswitch1][$row[0]]=0;}
								else
								{$imgsem="src='imagenes/sema_rojoON.jpg' title='Inactivo'";$coloracti="#C00";;$_POST[lswitch1][$row[0]]=1;}							$nombre=buscaresponsable($row[2]);
								$fecha=date("d-m-Y",strtotime($row[2]));
								if ($row[4]!="")
								{
									$bdescargar='<a href="informacion/protocolos_eticos/'.$row[4].'" target="_blank" ><img src="imagenes/descargar.png" title="Descargar: '.$row[4].'" ></a><div class="upload" style="display:none"><input type="file" name="upload[]"/></div>';
									$beliminar='<a href="#" onClick="eliminar_arch('.$row[0].',\''.$row[4].'\');"><img src="imagenes/cross.png" title="Eliminar Documento"></a>';
								}
								else
								{
									$bdescargar="<div class='upload'><input type='file' name='upload[]' onFocus='document.form2.contador.value=".$contad."; document.form2.idclase.value=".$row[0].";' onChange='document.form2.submit();' /><img src='imagenes/attach.png'  title='Cargar Documento'  /> </div>";
									$beliminar='<img src="imagenes/del4.png" >';
								}
								$imgedi="<a href='meci-insparticipacioneditar.php?id=".$row[0]."&clase=CPE'><img src='imagenes/b_edit.png' style='width:18px' title='Editar'></a>";
								$contad++;
								echo "
									<tr class='$iter'>	
										<td>$con</td>
										<td>Protocolo Etico</td>
										<td>".substr(ucfirst(strtolower(str_replace("&lt;br/&gt;","\n",$row[3]))), 0, 80)."</td>
										<td>$fecha</td>
										<td style='text-align:center;'>".$bdescargar."</td>
										<td align=\"middle\">".$beliminar."</td>
										<td style='text-align:center;'>".traeico($row[4])."</td>
										<td style='text-align:center;'><img $imgsem style='width:20px'/></td>
										<td><input type='range' name='lswitch1[]' value='".$_POST[lswitch1][$row[0]]."' min ='0' max='1' step ='1' style='background:$coloracti; width:60%' onChange='cambioswitch(\"".$row[0]."\",\"".$_POST[lswitch1][$row[0]]."\")' /></td>
										<td style='text-align:center;'>$imgedi </td>
									</tr>";
								 $con+=1;
								 $aux=$iter;
								 $iter=$iter2;
								 $iter2=$aux;
							}
							echo"</table>";
						}
					}
				?>
            </div>
            <input type="hidden" name="cambioestado" id="cambioestado" value="<?php echo $_POST[cambioestado];?>">
            <input type="hidden" name="nocambioestado" id="nocambioestado" value="<?php echo $_POST[nocambioestado];?>">
            <input type="hidden" name="idestado" id="idestado" value="<?php echo $_POST[idestado];?>">
            <input type="hidden" name="oculto" id="oculto" value="<?php echo $_POST[oculto];?>">
        </form>
	</body>
</html>