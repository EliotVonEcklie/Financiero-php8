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
        <title>:: Spid - Calidad</title>
        <script type="text/javascript" src="css/programas.js"></script>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
			<tr><script>barra_imagenes("meci");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("meci");?></tr>
          	<tr>
          		<td colspan="3" class="cinta"><a href="meci-estruorganizacional.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a><a href="#"  onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar"/></a><a href="#" class="mgbt" onClick="document.form2.submit();"><img src="imagenes/busca.png" title="Buscar"/></a><a href="#" class="mgbt" onClick="mypop=window.open('meci-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
        	</tr>
		</table>
		<form name="form2" method="post" action="meci-estruorganizacionalreporte.php" enctype="multipart/form-data">
       	 	<?php if($_POST[oculto]==""){$_POST[ocublo]="visibility:hidden;";$_POST[oculto]="0";}?>
        	<table class="inicio" >
				<tr>
                	<td class="titulos" colspan="4" style="width:95%">:: Buscar Estrucctura Organizacional </td>
                	<td class="cerrar" style="width:5%"><a href="meci-principal.php">Cerrar</a></td>
              	</tr>
              	<tr>
                	<td style="width:9%" class="saludo1">Clase Proceso:</td>
                	<td style="width:11%">
                    	<select name="proceso" id="proceso" onKeyUp="return tabular(event,this)" style="width:95%;" onChange="document.form2.submit();" >
                        	<option value="" <?php if($_POST[proceso]=='') {echo "SELECTED";$_POST[ocublo]="visibility:hidden;";}?>>....</option>
          					<option value="VIS" <?php if($_POST[proceso]=='VIS') {echo "SELECTED";$_POST[ocublo]="visibility:hidden;";}?>>Visi&oacute;n</option>
          					<option value="MIS" <?php if($_POST[proceso]=='MIS') {echo "SELECTED";$_POST[ocublo]="visibility:hidden;";}?>>Misi&oacute;n</option>
                            <option value="OBJ" <?php if($_POST[proceso]=='OBJ') {echo "SELECTED";$_POST[ocublo]="visibility:hidden;";}?>>Objetivos</option>
                            <option value="MCL" <?php if($_POST[proceso]=='MCL') {echo "SELECTED";$_POST[ocublo]="visibility:visible;";}?>>Marco Legal</option>
        				</select>
                    </td>
                    <td class="saludo1" style="width:10%; <?php echo $_POST[ocublo];?>">Clase Normativa:</td>
                    <td style="width:43%; <?php echo $_POST[ocublo];?>">
                        <select name="normativa" id="normativa" style="width:30%;" onChange="document.form2.submit();">
                        	<option value="" <?php if($_POST[normativa]=='') {echo "SELECTED";}?>>...</option>
                            <?php
								$linkbd=conectar_bd();
                                $sqlr="SELECT * FROM mecivariables WHERE clase='NML' ORDER BY id ASC";
                                $res=mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($res)) 
                                {
                                    echo "<option value=$row[0] ";
                                    $i=$row[0];
                                    if($i==$_POST[normativa]){echo "SELECTED"; $_POST[normativa]=$row[0];}
                                    echo ">".$row[0]." - ".$row[1]." </option>";
                                }	 	
                            ?>
                        </select>
                    </td>
               </tr>                       
   			</table>
            <input name="idclase" id="idclase" type="hidden" value="<?php echo $_POST[idclase]?>">
            <input name="contador" id="contador" type="hidden" value="<?php echo $_POST[contador]?>">
            <input name="archdel" id="archdel" type="hidden" value="<?php echo $_POST[archdel]?>">
            <input name="ocudelplan" id="ocudelplan" type="hidden" value="<?php echo $_POST[ocudelplan]?>">
            <div class="subpantallac5" style="height:68%; width:99.5%; overflow-x:hidden">
            	<?php
					$linkbd=conectar_bd();
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
							$iter='saludo1';
							$iter2='saludo2';
							echo "
								<table class='inicio' align='center' width='80%'>
									<tr>
										<td colspan='6' class='titulos'>.: Resultados Busqueda:</td>
									</tr>
									<tr class='saludo3'>
										<td colspan='6'>Encontrados: $ntr</td>
									</tr>
									<tr>
										<td class='titulos2' style='width:4%'>Item</td>
										<td class='titulos2' style='width:10%'>Clase</td>
										<td class='titulos2' style='width:41%'>Descripci&oacute;n</td>
										<td class='titulos2' style='width:8%'>Versi&oacute;n</td>
										<td class='titulos2' style='width:8%'>Fecha</td>
										<td class='titulos2' style='width:8%'>Estado</td>
									</tr>";
							while ($row =mysql_fetch_row($resp)) 
							{
								switch($row[1])
								{
									case "VIS": $clase="Visi&oacute;n";break;
									case "MIS": $clase="Misi&oacute;n";break;
									case "OBJ": $clase="Objetivos";break;
									case "MCL": $clase="Marco Legal";break;
								}
								if($row[5]=='S'){$imgsem="src='imagenes/sema_verdeON.jpg' title='Activo'";}
								else{$imgsem="src='imagenes/sema_rojoON.jpg' title='Inactivo'";}
								
								echo "
									<tr class='$iter'>	
										<td>$con</td>
										<td>$clase</td>
										<td>".substr(ucwords(strtolower(str_replace("&lt;br/&gt;","\n",$row[4]))), 0, 80)."</td>
										<td>$row[2]</td>
										<td>".date("d-m-Y",strtotime($row[3]))."</td>
										<td style='text-align:center;'><img $imgsem style='width:20px'/></td>
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
							$contad=0;
							if ($_POST[normativa]!=""){$crit1=" AND idnormativa='$_POST[normativa]' ";}
							$sqlr="SELECT * FROM meciestructuraorg_marcolegal WHERE estado<>'' ".$crit1." ORDER BY id DESC";
							$resp = mysql_query($sqlr,$linkbd);
							$ntr = mysql_num_rows($resp);
							$con=1;
							$iter='saludo1';
							$iter2='saludo2';
							echo "
								<table class='inicio' align='center' width='80%'>
									<tr>
										<td colspan='7' class='titulos'>.: Resultados Busqueda:</td>
									</tr>
									<tr class='saludo3'>
										<td colspan='7'>Encontrados: $ntr</td>
									</tr>
									<tr>
										<td class='titulos2' style='width:4%'>Item</td>
										<td class='titulos2' style='width:10%'>Clase</td>
										<td class='titulos2' style='width:41%'>Descripci&oacute;n</td>
										<td class='titulos2' style='width:8%'>Fecha</td>
										<td class='titulos2' style='width:8%' colspan='2'>Documentos</td>
										<td class='titulos2' style='width:4%'>Estado</td>
									</tr>";
							while ($row =mysql_fetch_row($resp)) 
							{
								$sqlrdoc="SELECT descripcion FROM mecinormativa WHERE id='$row[2]'";
								$rowdoc =mysql_fetch_row(mysql_query($sqlrdoc,$linkbd));
								if ($row[5]!="")
								{
									$bdescargar='<a href="informacion/marco_legal/'.$row[5].'" target="_blank" ><img src="imagenes/descargar.png" title="Descargar: '.$row[5].'" ></a>';
									
								}
								else{$bdescargar='<img src="imagenes/del4.png" title="Sin Archivo">';}
								switch($row[6])
								{
									case "S": 
										$imgsem="src='imagenes/sema_verdeON.jpg' title='Vigente'";
										break;
									case "N": 
										$imgsem="src='imagenes/sema_rojoON.jpg' title='No Vigente'";
										break;
									case "M": $clase="Objetivos";break;
									case "F": $clase="Marco Legal";break;
								}
								$contad++;
								echo "
									<tr class='$iter'>	
										<td>$con</td>
										<td>$rowdoc[0]</td>
										<td>$row[4]</td>
										<td>".date("d-m-Y",strtotime($row[3]))."</td>
										<td style='text-align:center;'>".$bdescargar."</td>
										<td style='text-align:center;'>".traeico($row[5])."</td>
										<td style='text-align:center;'><img $imgsem style='width:20px'/></td>
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
            <input type="hidden" name="oculto" id="oculto" value="<?php echo $_POST[oculto];?>">
            <input type="hidden" name="ocublo" id="ocublo" value="<?php echo $_POST[ocublo];?>">
        </form>
	</body>
</html>