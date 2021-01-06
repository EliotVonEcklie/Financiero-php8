<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	 	<?php require "head.php"; ?>
        <title>:: Spid - Calidad</title>
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
		</script>
		<?php 
			titlepag();
			$gid=$_GET['id'];
			if($_GET['clase']<>''){
				$_POST[proceso]=$_GET['clase'];
			}
		?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
			<tr><script>barra_imagenes("meci");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("meci");?></tr>
          	<tr>
          		<td colspan="3" class="cinta">
					<a onclick="location.href='meci-estruorganizacional.php'" class="tooltip bottom mgbt"><img src="imagenes/add.png" /><span class="tiptext">Nuevo</span></a>
					<a class="tooltip bottom mgbt"><img src="imagenes/guardad.png" title="Guardar"/></a>
					<a class="tooltip bottom mgbt" onClick="document.form2.submit();"><img src="imagenes/busca.png"/><span class="tiptext">Buscar</span></a>
					<a class="tooltip bottom mgbt" onClick="mypop=window.open('meci-principal.php','','');mypop.focus();"><img src="imagenes/nv.png"><span class="tiptext">Nueva Ventana</span></a>
					<a onClick="mypop=window.open('<?php echo $url2; ?>','','');mypop.focus();" class="tooltip bottom mgbt"><img src="imagenes/duplicar_pantalla.png"><span class="tiptext">Duplicar pestaña</span></a>
				</td>
        	</tr>
		</table>
		<form name="form2" method="post" action="meci-estruorganizacionalbusca.php" enctype="multipart/form-data">
        <?php
			if($_POST[oculto]=="")
			{
				$_POST[ocublo]="visibility:hidden;";
				$_POST[oculto]="0";
			}
		?>
        	<table class="inicio ancho" >
				<tr>
                	<td class="titulos" colspan="4" style="width:100%">:: Buscar Estrucctura Organizacional </td>
                	<td class="boton02" onclick="location.href='meci-principal.php'">Cerrar</td>
              	</tr>
              	<tr>
                	<td style="width:9%" class="saludo1">Clase Proceso:</td>
                	<td style="width:11%">
                    	<select name="proceso" id="proceso" onKeyUp="return tabular(event,this)" style="width:95%;" onChange="document.form2.submit();" >
                        	<option value="" <?php if($_POST[proceso]=='') {echo "SELECTED";$_POST[ocublo]="visibility:hidden;";}?>>....</option>
          					<option value="VIS" <?php if($_POST[proceso]=='VIS') {echo "SELECTED";$_POST[ocublo]="visibility:hidden;";}?>>Visi&oacute;n</option>
          					<option value="MIS" <?php if($_POST[proceso]=='MIS') {echo "SELECTED";$_POST[ocublo]="visibility:hidden;";}?>>Misi&oacute;n</option>
							<option value="PCL" <?php if($_POST[proceso]=='PCL') {echo "SELECTED";$_POST[ocublo]="visibility:hidden;";}?>>Politicas de Calidad</option>
                            <option value="OBJ" <?php if($_POST[proceso]=='OBJ') {echo "SELECTED";$_POST[ocublo]="visibility:hidden;";}?>>Objetivos</option>
                            <option value="MCL" <?php if($_POST[proceso]=='MCL') {echo "SELECTED";$_POST[ocublo]="visibility:visible;";}?>>Marco Legal</option>
        				</select>
                    </td>
                    <td class="saludo1" style="width:10%; <?php echo $_POST[ocublo];?>">Clase Normativa:</td>
                    <td style="<?php echo $_POST[ocublo];?>">
                        <select name="normativa" id="normativa" style="width:30%;" onChange="document.form2.submit();">
                        	<option value="" <?php if($_POST[normativa]=='') {echo "SELECTED";}?>>...</option>
                            <?php
								$linkbd=conectar_bd();
                                $sqlr="select * from mecivariables WHERE clase='NML' AND estado='S' order by id ASC";
                                $res=mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($res)) 
                                {
                                    echo "<option value=$row[0] ";
                                    $i=$row[0];
                                    if($i==$_POST[normativa]){echo "SELECTED"; $_POST[normativa]=$row[0];}
                                    echo ">".$row[1]." </option>";
                                }	 	
                            ?>
                        </select>
                    </td>
               </tr>                       
   			</table>
            <input name="idclase" id="idclase" type="hidden" value="<?php echo $_POST[idclase]?>" >
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
						copy($_FILES['upload']['tmp_name'][$_POST[contador]], "informacion/marco_legal/".$nomar);
						$sqlr="UPDATE meciestructuraorg_marcolegal SET adjunto='".$nomar."' WHERE id='".$_POST[idclase]."'";
						mysql_query($sqlr,$linkbd);
					}
					//Eliminar Archivos
					if($_POST['ocudelplan']=="1")
					{
						$sqlr="UPDATE meciestructuraorg_marcolegal SET adjunto='' WHERE id='".$_POST[idclase]."'";
						mysql_query($sqlr,$linkbd);
						unlink("informacion/marco_legal/".$_POST[archdel]);
						?><script>document.form2.ocudelplan.value="2";</script><?php
					}
					//************************************************************************
					
					$crit1=" ";
					$crit2=" ";
									
					if($_POST[proceso]!="")
					{
						if ($_POST[proceso]!="MCL")
						{
							if ($_POST[proceso]!=""){$crit1=" AND clase='$_POST[proceso]' ";}
							$sqlr="SELECT * FROM meciestructuraorg WHERE estado<>'' ".$crit1.$crit2." ORDER BY id DESC";
							$resp = mysql_query($sqlr,$linkbd);
							$ntr = mysql_num_rows($resp);
							$con=1;
							$iter='saludo1a';
							$iter2='saludo2';
							echo "
								<table class='inicio' align='center' width='80%'>
									<tr>
										<td colspan='8' class='titulos'>.: Resultados Busqueda:</td>
									</tr>
									<tr class='saludo3'>
										<td colspan='8'>Encontrados: $ntr</td>
									</tr>
									<tr>
										<td class='titulos2' style='width:4%'>Item</td>
										<td class='titulos2' style='width:10%'>Clase</td>
										<td class='titulos2' style='width:41%'>Descripci&oacute;n</td>
										<td class='titulos2' style='width:8%'>Versi&oacute;n</td>
										<td class='titulos2' style='width:8%'>Fecha</td>
										<td class='titulos2' style='width:8%'>Estado</td>
										<td class='titulos2' style='width:8%'>Mirar</td>
									</tr>";
							while ($row =mysql_fetch_row($resp)) 
							{
								switch($row[1])
								{
									case "VIS": $clase="Visi&oacute;n";break;
									case "MIS": $clase="Misi&oacute;n";break;
									case "PCL": $clase="Politica de Calidad";break;
									case "OBJ": $clase="Objetivos";break;
									case "MCL": $clase="Marco Legal";break;
								}
								$mirar="<a href='meci-estruorganizacionalmirar.php?id=".$row[0]."&clase=".$row[1]."'><img src='imagenes/buscarep.png' style='width:18px' title='Mirar'></a>";
								if($row[5]=='S')
								{
									$imgsem="src='imagenes/sema_verdeON.jpg' title='Activo'";
									echo "
									<tr class='$iter' onDblClick=\"location.href='meci-estruorganizacionaleditar.php?id=$row[0]&clase=$row[1]'\" >
										<td class='icoop'>$con</td>
										<td class='icoop'>$clase</td>
										<td class='icoop'>".substr(ucwords(strtolower(str_replace("&lt;br/&gt;","\n",$row[4]))), 0, 80)."</td>
										<td class='icoop'>$row[2]</td>
										<td>".date("d-m-Y",strtotime($row[3]))."</td>
										<td style='text-align:center;'><img $imgsem style='width:20px'/></td>
										<td style='text-align:center;'>$mirar</td>
									</tr>";
								}
								else
								{
									$imgsem="src='imagenes/sema_rojoON.jpg' title='Inactivo'";
									echo "
									<tr class='$iter'>
										<td>$con</td>
										<td>$clase</td>
										<td>".substr(ucwords(strtolower(str_replace("&lt;br/&gt;","\n",$row[4]))), 0, 80)."</td>
										<td>$row[2]</td>
										<td>".date("d-m-Y",strtotime($row[3]))."</td>
										<td style='text-align:center;'><img $imgsem style='width:20px'/></td>
										<td style='text-align:center;'>$mirar</td>
									</tr>";
								}
								 $con+=1;
								 $aux=$iter;
								 $iter=$iter2;
								 $iter2=$aux;
							}
							echo"</table>";
						}
						else
						{
							$contad=0;
							if ($_POST[normativa]!=""){$crit1=" AND idnormativa='$_POST[normativa]' ";}
							$sqlr="SELECT * FROM meciestructuraorg_marcolegal WHERE estado<>'' ".$crit1." ORDER BY id DESC";
							$resp = mysql_query($sqlr,$linkbd);
							$ntr = mysql_num_rows($resp);
							$con=1;
							$iter='saludo1a';
							$iter2='saludo2';
							echo "
								<table class='inicio' align='center' width='80%'>
									<tr>
										<td colspan='9' class='titulos'>.: Resultados Busqueda:</td>
									</tr>
									<tr class='saludo3'>
										<td colspan='9'>Encontrados: $ntr</td>
									</tr>
									<tr>
										<td class='titulos2' style='width:4%'>Item</td>
										<td class='titulos2' style='width:10%'>Clase</td>
										<td class='titulos2' style='width:10%'>Categor&iacute;a</td>
										<td class='titulos2' style='width:31%'>Descripci&oacute;n</td>
										<td class='titulos2' style='width:8%'>Fecha</td>
										<td class='titulos2' style='width:8%' colspan='3'>Documentos</td>
										<td class='titulos2' style='width:4%'>Estado</td>
									</tr>";
							while ($row =mysql_fetch_row($resp)) 
							{
								$sqlrdoc="SELECT nombre FROM mecivariables WHERE id='$row[2]'";
								$rowdoc =mysql_fetch_row(mysql_query($sqlrdoc,$linkbd));
								$sqlrcate="SELECT nombre FROM mecivariables WHERE id='$row[7]'";
								$rowcate =mysql_fetch_row(mysql_query($sqlrcate,$linkbd));
								if ($row[5]!="")
								{
									$bdescargar='<a href="informacion/marco_legal/'.$row[5].'" target="_blank" ><img src="imagenes/descargar.png" title="Descargar: '.$row[5].'" ></a><div class="upload" style="display:none"><input type="file" name="upload[]"/></div>';
									$beliminar='<a onClick="eliminar_arch('.$row[0].',\''.$row[5].'\');"><img src="imagenes/cross.png" title="Eliminar Documento"></a>';
								}
								else
								{
									$bdescargar="<div class='upload'><input type='file' name='upload[]' onFocus='document.form2.contador.value=".$contad."; document.form2.idclase.value=".$row[0].";' onChange='document.form2.submit();' /><img src='imagenes/attach.png'  title='Cargar Documento'  /> </div>";
									$beliminar='<img src="imagenes/del4.png" >';
								}
								$imgedi="<a href='meci-estruorganizacionaleditar.php?id=".$row[0]."&clase=MCL'><img src='imagenes/b_edit.png' style='width:20px' title='Editar'></a>";
								switch($row[6])
								{
									case "S": 
										$imgsem="src='imagenes/sema_verdeON.jpg' title='Vigente'";
										if($gid!="")
										{
											if($gid==$row[0]){$estilo='background-color:yellow';}
											else {$estilo="";}
										}
										else {
											$estilo="";
										}
										echo "
										<tr class='$iter' style='text-transform:uppercase; $estilo'>
											<td class='icoop' onDblClick=\"location.href='meci-estruorganizacionaleditar.php?id=$row[0]&clase=MCL'\">$con</td>
											<td class='icoop' onDblClick=\"location.href='meci-estruorganizacionaleditar.php?id=$row[0]&clase=MCL'\">$rowdoc[0]</td>
											<td class='icoop' onDblClick=\"location.href='meci-estruorganizacionaleditar.php?id=$row[0]&clase=MCL'\">$rowcate[0]</td>
											<td class='icoop' onDblClick=\"location.href='meci-estruorganizacionaleditar.php?id=$row[0]&clase=MCL'\">$row[4]</td>
											<td>".date("d-m-Y",strtotime($row[3]))."</td>
											<td style='text-align:center;'>".$bdescargar."</td>
											<td align=\"middle\">".$beliminar."</td>
											<td style='text-align:center;'>".traeico($row[5])."</td>
											<td style='text-align:center;'><img $imgsem style='width:20px'/></td>
										</tr>";
										break;
									case "N": 
										$imgsem="src='imagenes/sema_rojoON.jpg' title='No Vigente'";
										echo "
										<tr class='$iter'>
											<td>$con</td>
											<td>$rowdoc[0]</td>
											<td>$rowcate[0]</td>
											<td>$row[4]</td>
											<td>".date("d-m-Y",strtotime($row[3]))."</td>
											<td style='text-align:center;'>".$bdescargar."</td>
											<td align=\"middle\">".$beliminar."</td>
											<td style='text-align:center;'>".traeico($row[5])."</td>
											<td style='text-align:center;'><img $imgsem style='width:20px'/></td>
										</tr>";
										break;
									case "M": $clase="Objetivos";break;
									case "F": $clase="Marco Legal";break;
								}
								$contad++;
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
            <input type="hidden" name="oculto" id="oculto" value="<?php echo $_POST[oculto];?>">
            <input type="hidden" name="ocublo" id="ocublo" value="<?php echo $_POST[ocublo];?>">
        </form>
	</body>
</html>