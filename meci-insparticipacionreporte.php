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
		<?php titlepag(); ?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
			<tr><script>barra_imagenes("meci");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("meci");?></tr>
          	<tr>
          		<td colspan="3" class="cinta"><a href="#" class="mgbt"><img src="imagenes/add2.png"/></a><a href="#" class="mgbt"><img src="imagenes/guardad.png"/></a><a href="#" class="mgbt" onClick="document.form2.submit();"><img src="imagenes/busca.png" title="Buscar"/></a><a href="#" class="mgbt" onClick="mypop=window.open('meci-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
        	</tr>
		</table>
		<form name="form2" method="post" action="meci-insparticipacionreporte.php" enctype="multipart/form-data">
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
										<td colspan='8' class='titulos'>.: Resultados Busqueda:</td>
									</tr>
									<tr class='saludo3'>
										<td colspan='8'>Encontrados: $ntr</td>
									</tr>
									<tr>
										<td class='titulos' style='width:4%;'>N&deg;</td>
										<td class='titulos' style='width:15%;'>Clase</td>
										<td class='titulos' style='width:10%;'>Documento</td>
										<td class='titulos' style='width:30%;'>Nombre</td>
										<td class='titulos' style='width:15%;'>Cargo</td>
										<td class='titulos' style='width:8%;'>Fecha Inicio</td>
										<td class='titulos' style='width:8%;'>Fecha Retiro</td>
										<td class='titulos' style='width:6%;'>Estado</td>

									</tr>";
							while ($row =mysql_fetch_row($resp)) 
							{
								if($row[6]=='S')
								{$imgsem="src='imagenes/sema_verdeON.jpg' title='Activo'";}
								else
								{$imgsem="src='imagenes/sema_rojoON.jpg' title='Inactivo'";}	
								$nombre=buscaresponsable($row[2]);
								$fechai=date("d-m-Y",strtotime($row[4]));
								$fechar=date("d-m-Y",strtotime($row[5]));
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
										<td colspan='8' class='titulos'>.: Resultados Busqueda:</td>
									</tr>
									<tr class='saludo3'>
										<td colspan='8'>Encontrados: $ntr</td>
									</tr>
									<tr>
										<td class='titulos2' style='width:4%'>Item</td>
										<td class='titulos2' style='width:10%'>Clase</td>
										<td class='titulos2' style='width:39%'>Descripci&oacute;n</td>
										<td class='titulos2' style='width:8%'>Fecha</td>
										<td class='titulos2' style='width:8%' colspan='2'>Documentos</td>
										<td class='titulos2' style='width:6%'>Estado</td>

									</tr>";
							while ($row =mysql_fetch_row($resp)) 
							{
								if($row[5]=='S'){$imgsem="src='imagenes/sema_verdeON.jpg' title='Activo'";}
								else{$imgsem="src='imagenes/sema_rojoON.jpg' title='Inactivo'";}							
								$nombre=buscaresponsable($row[2]);
								$fecha=date("d-m-Y",strtotime($row[2]));
								if ($row[4]!="")
								{
									$bdescargar='<a href="informacion/protocolos_eticos/'.$row[4].'" target="_blank" ><img src="imagenes/descargar.png" title="Descargar: '.$row[4].'" ></a>';
								}
								else
								{
									$bdescargar='<img src="imagenes/del4.png" title="Sin Archivo" >';
								}
								$contad++;
								echo "
									<tr class='$iter'>	
										<td>$con</td>
										<td>Protocolo Etico</td>
										<td>".substr(ucfirst(strtolower(str_replace("&lt;br/&gt;","\n",$row[3]))), 0, 80)."</td>
										<td>$fecha</td>
										<td style='text-align:center;'>".$bdescargar."</td>
										<td style='text-align:center;'>".traeico($row[4])."</td>
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
            <input type="hidden" name="cambioestado" id="cambioestado" value="<?php echo $_POST[cambioestado];?>">
            <input type="hidden" name="nocambioestado" id="nocambioestado" value="<?php echo $_POST[nocambioestado];?>">
            <input type="hidden" name="idestado" id="idestado" value="<?php echo $_POST[idestado];?>">
        </form>
	</body>
</html>