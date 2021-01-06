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
		<title>:: Spid - Contratacion</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<script>
			function validar(tipo)
			{
				document.getElementById('letrerog').value="";
				switch(tipo)
				{
					case "1":	if (document.getElementById('grupo').value!="")
								{
									document.getElementById('img1a').value="style='display:block'";
									document.getElementById('img1b').value="style='display:none'";
								}
								else
								{
									document.getElementById('img1a').value="style='display:none'";
									document.getElementById('img1b').value="style='display:block'";
								}
								break;
					case "2":	if (document.getElementById('segmento').value!="")
								{
									document.getElementById('img2a').value="style='display:block'";
									document.getElementById('img2b').value="style='display:none'";
								}
								else
								{
									document.getElementById('img2a').value="style='display:none'";
									document.getElementById('img2b').value="style='display:block'";
								}
								break;
					case "3":	if (document.getElementById('familia').value!="")
								{
									document.getElementById('img3a').value="style='display:block'";
									document.getElementById('img3b').value="style='display:none'";		
								}
								else
								{
									document.getElementById('img3a').value="style='display:none'";
									document.getElementById('img3b').value="style='display:block'";
								}
								break;
					case "4":	if (document.getElementById('clases').value!="")
								{
									document.getElementById('img4a').value="style='display:block'";
									document.getElementById('img4b').value="style='display:none'";
								}
								else
								{
									document.getElementById('img4a').value="style='display:none'";
									document.getElementById('img4b').value="style='display:block'";
								}
								break;
					case "5":	if (document.getElementById('productos').value!="")
								{
									document.getElementById('img5a').value="style='display:block'";
									document.getElementById('img5b').value="style='display:none'";
								}
								else
								{
									document.getElementById('img5a').value="style='display:none'";
									document.getElementById('img5b').value="style='display:block'";
								}
								break;
				}
				document.form1.submit();
			}
			function modificar(tipo)
			{
				switch(tipo)
				{
					case '1':	document.getElementById('ocultar1').value="style='width:100%;'";
								document.getElementById('bloqueo1').value="style='width:100%; display:none;'";
								document.getElementById('modgrupo').value=document.getElementById('modcambio1').value;
								document.getElementById('bloqueo2').value="style='width:100%;' disabled";
								document.getElementById('bloqueo3').value="style='width:100%;' disabled";
								document.getElementById('bloqueo4').value="style='width:100%;' disabled";
								document.getElementById('bloqueo5').value="style='width:100%;' disabled";
								document.getElementById('img2a').value="style='display:none'";
								document.getElementById('img2b').value="style='display:none'";
								document.getElementById('img3a').value="style='display:none'";
								document.getElementById('img3b').value="style='display:none'";
								document.getElementById('img4a').value="style='display:none'";
								document.getElementById('img4b').value="style='display:none'";
								document.getElementById('img5a').value="style='display:none'";
								document.getElementById('img5b').value="style='display:none'";
								document.getElementById('codmod').value="1";
								break;
					case '2':	document.getElementById('ocultar2').value="style='width:100%;'";
								document.getElementById('bloqueo2').value="style='width:100%; display:none;'";
								document.getElementById('modsegmento').value=document.getElementById('modcambio2').value;
								document.getElementById('bloqueo2').value="style='width:100%;' disabled";
								document.getElementById('bloqueo3').value="style='width:100%;' disabled";
								document.getElementById('bloqueo4').value="style='width:100%;' disabled";
								document.getElementById('bloqueo5').value="style='width:100%;' disabled";
								document.getElementById('img1a').value="style='display:none'";
								document.getElementById('img1b').value="style='display:none'";
								document.getElementById('img3a').value="style='display:none'";
								document.getElementById('img3b').value="style='display:none'";
								document.getElementById('img4a').value="style='display:none'";
								document.getElementById('img4b').value="style='display:none'";
								document.getElementById('img5a').value="style='display:none'";
								document.getElementById('img5b').value="style='display:none'";
								document.getElementById('codmod').value="2";
								break;
					case '3':	document.getElementById('ocultar3').value="style='width:100%;'";
								document.getElementById('bloqueo3').value="style='width:100%; display:none;'";
								document.getElementById('modfamilia').value=document.getElementById('modcambio3').value;
								document.getElementById('bloqueo1').value="style='width:100%;' disabled";
								document.getElementById('bloqueo2').value="style='width:100%;' disabled";
								document.getElementById('bloqueo4').value="style='width:100%;' disabled";
								document.getElementById('bloqueo5').value="style='width:100%;' disabled";
								document.getElementById('img1a').value="style='display:none'";
								document.getElementById('img1b').value="style='display:none'";
								document.getElementById('img2a').value="style='display:none'";
								document.getElementById('img2b').value="style='display:none'";
								document.getElementById('img4a').value="style='display:none'";
								document.getElementById('img4b').value="style='display:none'";
								document.getElementById('img5a').value="style='display:none'";
								document.getElementById('img5b').value="style='display:none'";
								document.getElementById('codmod').value="3";
								break;
					case '4':	document.getElementById('ocultar4').value="style='width:100%;'";
								document.getElementById('bloqueo4').value="style='width:100%; display:none;'";
								document.getElementById('modclases').value=document.getElementById('modcambio4').value;
								document.getElementById('bloqueo1').value="style='width:100%;' disabled";
								document.getElementById('bloqueo2').value="style='width:100%;' disabled";
								document.getElementById('bloqueo3').value="style='width:100%;' disabled";
								document.getElementById('bloqueo5').value="style='width:100%;' disabled";
								document.getElementById('img1a').value="style='display:none'";
								document.getElementById('img1b').value="style='display:none'";
								document.getElementById('img2a').value="style='display:none'";
								document.getElementById('img2b').value="style='display:none'";
								document.getElementById('img3a').value="style='display:none'";
								document.getElementById('img3b').value="style='display:none'";
								document.getElementById('img5a').value="style='display:none'";
								document.getElementById('img5b').value="style='display:none'";
								document.getElementById('codmod').value="4";
								break;
					case '5':	document.getElementById('ocultar5').value="style='width:100%;'";
								document.getElementById('bloqueo5').value="style='width:100%; display:none;'";
								document.getElementById('modproductos').value=document.getElementById('modcambio5').value;
								document.getElementById('bloqueo1').value="style='width:100%;' disabled";
								document.getElementById('bloqueo2').value="style='width:100%;' disabled";
								document.getElementById('bloqueo3').value="style='width:100%;' disabled";
								document.getElementById('bloqueo4').value="style='width:100%;' disabled";
								document.getElementById('img1a').value="style='display:none'";
								document.getElementById('img1b').value="style='display:none'";
								document.getElementById('img2a').value="style='display:none'";
								document.getElementById('img2b').value="style='display:none'";
								document.getElementById('img3a').value="style='display:none'";
								document.getElementById('img3b').value="style='display:none'";
								document.getElementById('img4a').value="style='display:none'";
								document.getElementById('img4b').value="style='display:none'";
								document.getElementById('codmod').value="5";
								break;
				}
				document.form1.submit();
			}
			function guardar()
			{
				tipo=document.getElementById('codmod').value;;
				switch(tipo)
				{
					case '1':	document.getElementById('oculgen').value="1";break;
					case '2':	document.getElementById('oculgen').value="2";break;
					case '3':	document.getElementById('oculgen').value="3";break;
					case '4':	document.getElementById('oculgen').value="4";break;
					case '5':	document.getElementById('oculgen').value="5";break;
				}
				document.form1.submit();	
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
			function funcionmensaje(){document.location.href = "contra-productos.php";}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "":	break;
					default:	modificar(pregunta);
				}
			}
			function preguntasmod(tipopreguntas,nombrestipo)
			{
				var nombrepregunta ="Esta seguro de Modificar " + nombrestipo;
				despliegamodalm('visible','4',nombrepregunta,tipopreguntas);
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
        <form name="form1" method="post">
    	<table>
        	<tr><script>barra_imagenes("inve");</script><?php cuadro_titulos();?></tr>	 
        	<tr><?php menu_desplegable("inve");?></tr>
    		<tr>
  				<td colspan="3" class="cinta">
					<a href="contra-productosguardar.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a>
					<a href="#" onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png" title="Guardar"/></a>
					<a href="contra-productosbuscar.php" class="mgbt"><img src="imagenes/busca.png"  title="Buscar"/></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" onClick="mypop=window.open('inve-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
				</td>
			</tr>
		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
    	<?php
			if($_POST[oculgen]=="")
			{
				$_POST[bloqueo1]="style='width:100%;' ";
				$_POST[bloqueo2]="style='width:100%;' ";
				$_POST[bloqueo3]="style='width:100%;' ";
				$_POST[bloqueo4]="style='width:100%;' ";
				$_POST[bloqueo5]="style='width:100%;' ";
				$_POST[img1a]="style='display:none'";
				$_POST[img2a]="style='display:none'";
				$_POST[img3a]="style='display:none'";
				$_POST[img4a]="style='display:none'";
				$_POST[img5a]="style='display:none'";
				$_POST[img1b]="style='display:block'";
				$_POST[img2b]="style='display:block'";
				$_POST[img3b]="style='display:block'";
				$_POST[img4b]="style='display:block'";
				$_POST[img5b]="style='display:block'";
				$_POST[ocultar1]="style='display:none'";
				$_POST[ocultar2]="style='display:none'";
				$_POST[ocultar3]="style='display:none'";
				$_POST[ocultar4]="style='display:none'";
				$_POST[ocultar5]="style='display:none'";
				$_POST[oculgen]="0";
			}
		?>
		
 			<table class="inicio" >
            <tr>
                <td colspan="5" class="titulos">Productos Plan de Compras</td>
                <td class="cerrar" style="width:7%;"><a href="contra-principal.php">Cerrar</a></td>
            </tr>
			<tr>
        		<td class="saludo1" style="width:10%;"><?php $dominio='UNSPSC' ; $clasificacion=buscadominiov2($dominio,'1'); echo strtoupper($clasificacion);?></td>
            	<td style="width:40%;">
                	<select id="grupo" name="grupo" onChange="validar('1')" <?php echo $_POST[bloqueo1];?>  > 
                    	<option value=''>Seleccione ...</option>
                   		<?php
                        	$sqlr="Select * from productospaa  where tipo='1'  and estado='S' order by tipo,codigo asc";
                        	$resp = mysql_query($sqlr,$linkbd);
                       	 	while ($row =mysql_fetch_row($resp)) 
                        	{
								if($row[0]==$_POST[grupo]){echo "<option value=$row[0] SELECTED>$row[0] - $row[1]</option>";$_POST[modcambio1]=$row[1];}
								else{echo "<option value=$row[0]>$row[0] - $row[1]</option>";}
                         	}			
						?>
					</select>
                	<input type="text" id="modgrupo" name="modgrupo" value="<?php echo $_POST[modgrupo];?>" <?php echo $_POST[ocultar1];?>>
				</td>
            	<td style="width:5%;"><a href='#'><img src='imagenes/b_edit.png' onClick="preguntasmod('1','El Grupo: <?php echo $_POST[modcambio1];?>')" <?php echo $_POST[img1a];?> /><img src='imagenes/b_editd.png' <?php echo $_POST[img1b];?> /> </a></td>
            	<td></td>
			</tr>
			<tr>
        		<td class="saludo1"><?php $dominio='UNSPSC' ; $clasificacion=buscadominiov2($dominio,'2'); echo strtoupper($clasificacion);?></td>
            	<td>
                	<select id="segmento" name="segmento" onChange="validar('2')" <?php echo $_POST[bloqueo2];?>>
                    	<option value=''>Seleccione ...</option>
                    	<?php
                        	$sqlr="Select * from productospaa  where tipo='2' and padre='$_POST[grupo]' and estado='S' order by tipo,codigo asc";
                        	$resp = mysql_query($sqlr,$linkbd);
                       		while ($row =mysql_fetch_row($resp)) 
                        	{
                            	if($row[0]==$_POST[segmento]){echo"<option value=$row[0] SELECTED>$row[0] - $row[1]</option>";$_POST[modcambio2]=$row[1];}
								else{echo "<option value=$row[0]>$row[0] - $row[1]</option>";}
                         	}			
                    	?>
					</select>
                	<input type="text" id="modsegmento" name="modsegmento" value="<?php echo $_POST[modsegmento];?>" <?php echo $_POST[ocultar2];?>>
     			</td>
            	<td style="width:5%;"><a href='#'><img src='imagenes/b_edit.png' onClick="preguntasmod('2','El Segmento: <?php echo $_POST[modcambio2];?>')" <?php echo $_POST[img2a];?> /><img src='imagenes/b_editd.png' <?php echo $_POST[img2b];?> /> </a></td>
            	<td></td>
     		</tr>
			<tr>
        		<td class="saludo1"><?php $dominio='UNSPSC' ; $clasificacion=buscadominiov2($dominio,'3'); echo strtoupper($clasificacion);?></td>
            	<td>
                	<select id="familia" name="familia" onChange="validar('3')" <?php echo $_POST[bloqueo3];?>>
                    	<option value=''>Seleccione ...</option>
                    	<?php
					   		$sqlr="Select * from productospaa  where tipo='3' and padre='$_POST[segmento]' and estado='S' order by tipo,codigo asc";
							$resp = mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($resp)) 
							{
								if($row[0]==$_POST[familia]){echo "<option value=$row[0] SELECTED>$row[0] - $row[1]</option>";$_POST[modcambio3]=$row[1];}
								else{echo "<option value=$row[0]>$row[0] - $row[1]</option>";}
							}			
		  				?>
					</select>
                	<input type="text" id="modfamilia" name="modfamilia" value="<?php echo $_POST[modfamilia];?>" <?php echo $_POST[ocultar3];?>>
				</td>
            	<td style="width:5%;"><a href='#'><img src='imagenes/b_edit.png' onClick="preguntasmod('3','La Familia: <?php echo $_POST[modcambio3];?>')" <?php echo $_POST[img3a];?> /><img src='imagenes/b_editd.png' onClick="" <?php echo $_POST[img3b];?> /> </a></td>
            	<td></td>
     		</tr>
			<tr>
        		<td class="saludo1"><?php $dominio='UNSPSC' ; $clasificacion=buscadominiov2($dominio,'4'); echo strtoupper($clasificacion);?></td>
            	<td>
                	<select id="clases" name="clases" onChange="validar('4')" <?php echo $_POST[bloqueo4];?>>
                		<option value=''>Seleccione ...</option>
                 		<?php
					   		$sqlr="Select * from productospaa where tipo='4' and padre='$_POST[familia]' and estado='S' order by tipo,codigo asc";
		 					$resp = mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($resp)) 
							{
								if($row[0]==$_POST[clases]){echo "<option value=$row[0] SELECTED>$row[0] - $row[1]</option>";$_POST[modcambio4]=$row[1];}
								else{echo "<option value=$row[0]>$row[0] - $row[1]</option>";}
							}			
		  				?>
					</select>
                	<input type="text" id="modclases" name="modclases" value="<?php echo $_POST[modclases];?>" <?php echo $_POST[ocultar4];?>>
				</td>
           	 	<td style="width:5%;"><a href='#'><img src='imagenes/b_edit.png' onClick="preguntasmod('4','La Clase: <?php echo $_POST[modcambio4];?>')" <?php echo $_POST[img4a];?> /><img src='imagenes/b_editd.png' onClick="" <?php echo $_POST[img4b];?> /> </a></td>
            	<td></td>
    		</tr>
			<tr>
        		<td class="saludo1"><?php $dominio='UNSPSC' ; $clasificacion=buscadominiov2($dominio,'5'); echo strtoupper($clasificacion);?></td>
            	<td>
                	<select id="productos" name="productos" onChange="validar('5')" <?php echo $_POST[bloqueo5];?>>
                    	<option value=''>Seleccione ...</option>
                    	<?php
					   		$sqlr="Select * from productospaa  where tipo='5' and padre='$_POST[clases]' and estado='S' order by tipo,codigo asc";
							$resp = mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($resp)) 
							{
								if($row[0]==$_POST[productos]){echo "<option value=$row[0] SELECTED>$row[0] - $row[1]</option>";$_POST[modcambio5]=$row[1];}
								else{echo "<option value=$row[0]>$row[0] - $row[1]</option>";}
							}			
		  				?>
					</select>
                	<input type="text" id="modproductos" name="modproductos" value="<?php echo $_POST[modproductos];?>" <?php echo $_POST[ocultar5];?>>
				</td>
            	<td style="width:5%;"><a href='#'><img src='imagenes/b_edit.png' onClick="preguntasmod('5','El Producto: <?php echo $_POST[modcambio5];?>')" <?php echo $_POST[img5a];?> /><img src='imagenes/b_editd.png' onClick="" <?php echo $_POST[img5b];?> /> </a></td>
            	<td></td>
    		</tr>
		</table>
        <input type="hidden" id="oculgen" name="oculgen" value="<?php echo $_POST[oculgen];?>">
        <input type="hidden" id="codmod" name="codmod" value="<?php echo $_POST[codmod];?>">
        <input type="hidden" id="letrerog" name="letrerog" value="<?php echo $_POST[letrerog];?>">
        <input type="hidden" id="modcambio1" name="modcambio1" value="<?php echo $_POST[modcambio1];?>">
        <input type="hidden" id="modcambio2" name="modcambio2" value="<?php echo $_POST[modcambio2];?>">
        <input type="hidden" id="modcambio3" name="modcambio3" value="<?php echo $_POST[modcambio3];?>">
        <input type="hidden" id="modcambio4" name="modcambio4" value="<?php echo $_POST[modcambio4];?>">
        <input type="hidden" id="modcambio5" name="modcambio5" value="<?php echo $_POST[modcambio5];?>">
        <input type="hidden" id="img1a" name="img1a" value="<?php echo $_POST[img1a];?>">
        <input type="hidden" id="img2a" name="img2a" value="<?php echo $_POST[img2a];?>">
        <input type="hidden" id="img3a" name="img3a" value="<?php echo $_POST[img3a];?>">
        <input type="hidden" id="img4a" name="img4a" value="<?php echo $_POST[img4a];?>">
        <input type="hidden" id="img5a" name="img5a" value="<?php echo $_POST[img5a];?>">
        <input type="hidden" id="img1b" name="img1b" value="<?php echo $_POST[img1b];?>">
        <input type="hidden" id="img2b" name="img2b" value="<?php echo $_POST[img2b];?>">
        <input type="hidden" id="img3b" name="img3b" value="<?php echo $_POST[img3b];?>">
        <input type="hidden" id="img4b" name="img4b" value="<?php echo $_POST[img4b];?>">
        <input type="hidden" id="img5b" name="img5b" value="<?php echo $_POST[img5b];?>">
        <input type="hidden" id="ocultar1" name="ocultar1" value="<?php echo $_POST[ocultar1];?>">
        <input type="hidden" id="ocultar2" name="ocultar2" value="<?php echo $_POST[ocultar2];?>">
        <input type="hidden" id="ocultar3" name="ocultar3" value="<?php echo $_POST[ocultar3];?>">
        <input type="hidden" id="ocultar4" name="ocultar4" value="<?php echo $_POST[ocultar4];?>">
        <input type="hidden" id="ocultar5" name="ocultar5" value="<?php echo $_POST[ocultar5];?>">
        <input type="hidden" id="bloqueo1" name="bloqueo1" value="<?php echo $_POST[bloqueo1];?>">
        <input type="hidden" id="bloqueo2" name="bloqueo2" value="<?php echo $_POST[bloqueo2];?>">
        <input type="hidden" id="bloqueo3" name="bloqueo3" value="<?php echo $_POST[bloqueo3];?>">
        <input type="hidden" id="bloqueo4" name="bloqueo4" value="<?php echo $_POST[bloqueo4];?>">
        <input type="hidden" id="bloqueo5" name="bloqueo5" value="<?php echo $_POST[bloqueo5];?>">
		<?php
			if ($_POST[oculgen]!="" && $_POST[oculgen]!="0")
			{
				switch($_POST[oculgen])
				{
			
					case '1':	$sqlr="UPDATE productospaa SET nombre='$_POST[modgrupo]' WHERE codigo='$_POST[grupo]'";
								mysql_query($sqlr,$linkbd);
								$nommod="El GRUPO";	
								break;
					case '2':	$sqlr="UPDATE productospaa SET nombre='$_POST[modsegmento]' WHERE codigo='$_POST[segmento]'";
								mysql_query($sqlr,$linkbd);
								$nommod="El SEGMENTO";		
								break;
					case '3':	echo $_POST[familia]."-".$_POST[modfamilia];
								$sqlr="UPDATE productospaa SET nombre='$_POST[modfamilia]' WHERE codigo='$_POST[familia]'";
								mysql_query($sqlr,$linkbd);
								$nommod="La FAMILIA";		
								break;
					case '4':	$sqlr="UPDATE productospaa SET nombre='$_POST[modclases]' WHERE codigo='$_POST[clases]'";
								mysql_query($sqlr,$linkbd);
								$nommod="La CLASE";		
								break;
					case '5':	$sqlr="UPDATE productospaa SET nombre='$_POST[modproductos]' WHERE codigo='$_POST[productos]'";
								mysql_query($sqlr,$linkbd);
								$nommod="El PRODUCTO";		
								break;
				}
				$mensajemod="Se Modifico con Exito ".$nommod;
				echo"<script>despliegamodalm('visible','1','$mensajemod');</script>";
			}
		?>
 		</form>
	</body>
</html>