<?php //V 1000 12/12/16 ?> 
<!--V 1.0 24/02/2015-->
<?php
	require"comun.inc";
	require"funciones.inc";
	sesion();
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
        <meta http-equiv="expira" content="no-cache">
		<title>:: Spid - Administracion</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css"/>
        <script type="text/javascript" src="css/programas.js"></script>
        <script type='text/javascript' src='JQuery/jquery-2.1.4.min.js'></script>
        <script type="text/javascript" src="JQuery/alphanum/jquery.alphanum.js"></script>
		<script type="text/javascript" src="css/cssrefresh.js"></script>
		<script>
			function comparar()
			{
				if(document.getElementById('base1').value !="" && document.getElementById('base2').value!="")
				{
					document.getElementById('oculto').value="2";
					document.form2.submit();
				}
			}	
		</script>
		<?php 
			titlepag();
			$lista_bd = mysql_list_dbs($linkbd);
			$xx=0;
			while ($fbases = mysql_fetch_object($lista_bd)) 
			{
				$bases[$xx]=$fbases->Database;
				$xx++;
			}
		?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table >
   			<tr><script>barra_imagenes("adm");</script><?php cuadro_titulos();?></tr>
    		<tr><?php menu_desplegable("adm");?></tr>
			<tr>
  				<td colspan="3" class="cinta"><a class="mgbt"><img src="imagenes/add2.png" /></a><a onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png" title="Guardar"/></a><a class="mgbt" onClick="comparar();"><img src="imagenes/busca.png" /></a><a  onClick="mypop=window.open('adm-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
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
				if ($_POST[oculto]=="")
                {
					$_POST[tabgroup1]=1;
				}
				switch($_POST[tabgroup1])
				{
					case 1:	$check1='checked';break;
					case 2:	$check2='checked';break;
				}
			?>
            <div class="tabsmeci"  style="height:76.5%; width:99.6%">
                <div class="tab">
                    <input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
                    <label for="tab-1">Bases de Datos</label>
                    <div class="content" style="overflow:hidden;">
                        <!--Primera Base de Datos--> 
                        <div class="subpantallap"  style="height:98%; width:49%; overflow:hidden; float: left;">
                            <table  class="inicio">
                                <tr>
                                    <td class="titulos" style="width:4cm;">Seleccionar Base 1:</td>
                                    <td>
                                        <select name="base1" id="base1" onChange="document.form2.submit();" style='text-transform:uppercase'>
                                            <option value="">Sel..</option>
                                             <?php
                                                $xb1=count($bases);
                                                for($x=0;$x<$xb1;$x++)
                                                {
                                                    if($bases[$x]==$_POST[base1]){echo"<option value='$bases[$x]' SELECTED>- $bases[$x]</option>";}
                                                    else {echo"<option value='$bases[$x]'>- $bases[$x]</option>";}
                                                }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                            <div class="subpantallap"  style="height:92%; width:99%; overflow-x:hidden; margin-left:3">
                                <table class="inicio">
                                    <tr class='titulos2' style='text-align:center;'>
                                        <td>Tablas</td>
                                        <td>Campos</td>
                                        <td>Estado</td>
                                    </tr>
                                    <?php
									
                                        if($_POST[base1]!="")
                                        {
                                            $sqlr = "SHOW TABLES FROM $_POST[base1]";
                                            $resp = mysql_query($sqlr,$linkbd);
                                            $iter='zebra1';
                                            $iter2='zebra2';
                                            while ($fila = mysql_fetch_row($resp))
                                            {
                                                $sqlr2 = "SHOW COLUMNS FROM $_POST[base1].$fila[0]";
                                                $resp2 = mysql_query($sqlr2,$linkbd);
                                                $numcam=mysql_num_rows($resp2);
                                                if($_POST[base2]!="")
                                                {
                                                    $sqlr3="SHOW TABLES FROM $_POST[base2] LIKE '$fila[0]'";
                                                    $result = mysql_query($sqlr3,$linkbd);
                                                    $existe = mysql_num_rows($result);
                                                    if(mysql_num_rows($result)!=0)
                                                    {
                                                        $sqlr4 = "SHOW COLUMNS FROM $_POST[base2].$fila[0]";
                                                        $resp4 = mysql_query($sqlr4,$linkbd);
                                                        $numcam2=mysql_num_rows($resp4);
                                                        if($numcam==$numcam2)
														{
															$desc1a="";
															$desc1b="";
															$desc1c="";
															$desc1d="";
															$desc1e="";
															$desc2a="";
															$desc2b="";
															$desc2c="";
															$desc2d="";
															$desc2e="";
															$sqlrf = "SHOW FULL FIELDS FROM $_POST[base1].$fila[0]";
                                        					$respf = mysql_query($sqlrf,$linkbd);
															 while ($rcampos = mysql_fetch_row($respf))
															{
																$desc1a="$desc1a $rcampos[0]<br>";
																$desc1b="$desc1b $rcampos[1]<br>";
																$desc1c="$desc1c $rcampos[3]<br>";
																$desc1d="$desc1d $rcampos[4]<br>";
																$desc1e="$desc1e ".substr($rcampos[6],0,4)."<br>";
															}
															$sqlrf = "SHOW FULL FIELDS FROM $_POST[base2].$fila[0]";
                                        					$respf = mysql_query($sqlrf,$linkbd);
															 while ($rcampos = mysql_fetch_row($respf))
															{
																$desc2a="$desc2a $rcampos[0]<br>";
																$desc2b="$desc2b $rcampos[1]<br>";
																$desc2c="$desc2c $rcampos[3]<br>";
																$desc2d="$desc2d $rcampos[4]<br>";
																$desc2e="$desc2e ".substr($rcampos[6],0,4)."<br>";
															}
															if($desc1a==$desc2a && $desc1b==$desc2b && $desc1c==$desc2c && $desc1d==$desc2d && $desc1e==$desc2e)
															{$existe="<img src='imagenes/sema_verdeON.jpg' style='width:20px;'/>";}
															else
															{
																$camposdifb1[]="$fila[0]";
                                                                $existe="<img src='imagenes/sema_azulON.jpg' style='width:20px;' title='Campos Diferentes'/>";
															}
														}
                                                        else 
                                                        {
                                                            if($numcam=='' || $numcam2=='')
                                                            {
                                                                $existe="<img src='imagenes/sema_amarilloON.jpg' style='width:20px;' title='Error Archivo .MYD'/>";
                                                            }
                                                            else
                                                            {
                                                                $camposdifb1[]="$fila[0]";
                                                                $existe="<img src='imagenes/sema_azulON.jpg' style='width:20px;' title='Campos Diferentes'/>";
                                                            }
                                                        }
                                                    }
                                                    else {$existe="<img src='imagenes/sema_rojoON.jpg' style='width:20px;' title='No existe en: $_POST[base2]'/>";}
                                                }
                                                else {$existe="<img src='imagenes/sema_amarilloOFF.jpg' style='width:20px;'/>";}
                                                echo"
                                                <tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
                    onMouseOut=\"this.style.backgroundColor=anterior\">
                                                    <td>- $fila[0]</td>
                                                    <td>$numcam</td>
                                                    <td style='text-align:center;'>$existe</td>
                                                </tr>";
                                                $aux=$iter;
                                                $iter=$iter2;
                                                $iter2=$aux;
                                            }						
                                        }
                                    ?>
                                </table>
                            </div>
                        </div>
                        <!--Segunda Base de Datos--> 
                        <div class="subpantallap"  style="height:98%; width:49%; overflow:hidden; float: left; margin-left:15; margin-bottom:10">
                            <table  class="inicio">
                                <tr>
                                    <td class="titulos" style="width:4cm;">Seleccionar Base 2:</td>
                                    <td>
                                        <select name="base2" id="base2" onChange="document.form2.submit();" style='text-transform:uppercase'>
                                            <option value="">Sel..</option>
                                             <?php
                                                $xb1=count($bases);
                                                for($x=0;$x<$xb1;$x++)
                                                {
                                                    if($bases[$x]==$_POST[base2]){echo"<option value='$bases[$x]' SELECTED>- $bases[$x]</option>";}
                                                    else {echo"<option value='$bases[$x]'>- $bases[$x]</option>";}
                                                }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                            <div class="subpantallap"  style="height:92%; width:99%; overflow-x:hidden; margin-left:3">
                                <table class="inicio">
                                    <tr class='titulos2'>
                                        <td>Tablas</td>
                                        <td>Campos</td>
                                        <td>Estado</td>
                                    </tr>
                                    <?php
                                        if($_POST[base2]!="")
                                        {
                                            $sqlr = "SHOW TABLES FROM $_POST[base2]";
                                            $resp = mysql_query($sqlr,$linkbd);
                                            $iter='zebra1';
                                            $iter2='zebra2';
                                            while ($fila = mysql_fetch_row($resp))
                                            {
                                                $sqlr2 = "SHOW COLUMNS FROM $_POST[base2].$fila[0]";
                                                $resp2 = mysql_query($sqlr2,$linkbd);
                                                $numcam=mysql_num_rows($resp2);
                                                if($_POST[base1]!="")
                                                {
                                                    $sqlr3="SHOW TABLES FROM $_POST[base1] LIKE '$fila[0]'";
                                                    $result = mysql_query($sqlr3,$linkbd);
                                                    if(mysql_num_rows($result)!=0)
                                                    {
                                                        $sqlr4 = "SHOW COLUMNS FROM $_POST[base1].$fila[0]";
                                                        $resp4 = mysql_query($sqlr4,$linkbd);
                                                        $numcam2=mysql_num_rows($resp4);
                                                        if($numcam==$numcam2)
														{
															$desc1a="";
															$desc1b="";
															$desc1c="";
															$desc1d="";
															$desc1e="";
															$desc2a="";
															$desc2b="";
															$desc2c="";
															$desc2d="";
															$desc2e="";
															$sqlrf = "SHOW FULL FIELDS FROM $_POST[base1].$fila[0]";
                                        					$respf = mysql_query($sqlrf,$linkbd);
															 while ($rcampos = mysql_fetch_row($respf))
															{
																$desc1a="$desc1a $rcampos[0]<br>";
																$desc1b="$desc1b $rcampos[1]<br>";
																$desc1c="$desc1c $rcampos[3]<br>";
																$desc1d="$desc1d $rcampos[4]<br>";
																$desc1e="$desc1e ".substr($rcampos[6],0,4)."<br>";
															}
															$sqlrf = "SHOW FULL FIELDS FROM $_POST[base2].$fila[0]";
                                        					$respf = mysql_query($sqlrf,$linkbd);
															 while ($rcampos = mysql_fetch_row($respf))
															{
																$desc2a="$desc2a $rcampos[0]<br>";
																$desc2b="$desc2b $rcampos[1]<br>";
																$desc2c="$desc2c $rcampos[3]<br>";
																$desc2d="$desc2d $rcampos[4]<br>";
																$desc2e="$desc2e ".substr($rcampos[6],0,4)."<br>";
															}
															if($desc1a==$desc2a && $desc1b==$desc2b && $desc1c==$desc2c && $desc1d==$desc2d && $desc1e==$desc2e)
															{$existe="<img src='imagenes/sema_verdeON.jpg' style='width:20px;'/>";}
															else
															{
																$camposdifb1[]="$fila[0]";
                                                                $existe="<img src='imagenes/sema_azulON.jpg' style='width:20px;' title='Campos Diferentes'/>";
															}
														}
                                                        else 
                                                        {
                                                            if($numcam=='' || $numcam2=='')
                                                            {
                                                                $existe="<img src='imagenes/sema_amarilloON.jpg' style='width:20px;' title='Error Archivo .MYD'/>";
                                                            }
                                                            else
                                                            {
                                                            $existe="<img src='imagenes/sema_azulON.jpg' style='width:20px;' title='Campos Diferentes'/>";}
                                                        }
                                                    }
                                                    else {$existe="<img src='imagenes/sema_rojoON.jpg' style='width:20px;' title='No existe en: $_POST[base1]'/>";}
                                                }
                                                else {$existe="<img src='imagenes/sema_amarilloOFF.jpg' style='width:20px;'/>";}
                                                echo"
                                                <tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
                    onMouseOut=\"this.style.backgroundColor=anterior\">
                                                    <td>- $fila[0]</td>
                                                    <td>$numcam</td>
                                                    <td>$existe</td>
                                                </tr>";
                                                $aux=$iter;
                                                $iter=$iter2;
                                                $iter2=$aux;
                                            }						
                                        }
                                    ?>
                                </table>
                            </div>
                        </div>
                        <input type="hidden" name="oculto" id="oculto" value="" />
                    </div>
                </div>
                <div class="tab">
             		<input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?> >
         			<label for="tab-2">Campos Inconsistentes</label>
           			<div class="content" style="overflow:hidden;">
               			<!--Respuestas Comparación--> 
                		<div class="subpantallap"  style="height:98%; width:99.5%; overflow-x:hidden; margin-left:3">
                			<table class="inicio">
                                <tr class="titulos">
                                    <td colspan="6" style='text-align:center;text-transform:uppercase;'>Base 1: <?php echo $_POST[base1];?></td>
                                    <td colspan="6" style='text-align:center;text-transform:uppercase;'>Base 2: <?php echo $_POST[base2];?></td>
                                </tr>
                                <tr class='titulos2' style='text-align:center;'>
                                    <td rowspan="2">Tabla</td>
                                    <td colspan="5">Campo</td>
                                    <td rowspan="2">Tabla</td>
                                    <td colspan="5">Campo</td>
                                </tr>
                                <tr class='titulos2' style='text-align:center;'>
                                    <td>Nombre</td>
                                    <td>Tipo</td>
                                    <td>Null</td>
                                    <td>Key</td>
                                    <td>Auto</td>
                                    <td>Nombre</td>
                                    <td>Tipo</td>
                                    <td>Null</td>
                                    <td>Key</td>
                                    <td>Auto</td>
                                </tr>
								<?php
									if($_POST[base1]!="" && $_POST[base2]!="")
									{
										$ctad=count($camposdifb1);
										$iter='zebra1';
										$iter2='zebra2';
										for($x=0;$x<$ctad;$x++)
										{
											$sqlrf = "SHOW FULL FIELDS FROM $_POST[base1].$camposdifb1[$x]";
											$respf = mysql_query($sqlrf,$linkbd);
											$descampo1a="";
											$descampo1b="";
											$descampo1c="";
											$descampo1d="";
											$descampo1e="";
											while ($rcampos = mysql_fetch_row($respf))
											{
												$descampo1a="$descampo1a $rcampos[0]<br>";
												$descampo1b="$descampo1b $rcampos[1]<br>";
												$descampo1c="$descampo1c $rcampos[3]<br>";
												$descampo1d="$descampo1d $rcampos[4]<br>";
												$descampo1e="$descampo1e ".substr($rcampos[6],0,4)."<br>";
											}
											$sqlrf = "SHOW FULL FIELDS FROM $_POST[base2].$camposdifb1[$x]";
											$respf = mysql_query($sqlrf,$linkbd);
											$descampo2a="";
											$descampo2b="";
											$descampo2c="";
											$descampo2d="";
											$descampo2e="";
											while ($rcampos = mysql_fetch_row($respf))
											{
												$descampo2a="$descampo2a $rcampos[0]<br>";
												$descampo2b="$descampo2b $rcampos[1]<br>";
												$descampo2c="$descampo2c $rcampos[3]<br>";
												$descampo2d="$descampo2d $rcampos[4]<br>";
												$descampo2e="$descampo2e ".substr($rcampos[6],0,4)."<br>";
											}
											echo"
											<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
						onMouseOut=\"this.style.backgroundColor=anterior\">
												<td style='width:10%'>$camposdifb1[$x]</td>
												<td style='width:10%'>$descampo1a</td>
												<td style='width:12%'>$descampo1b</td>
												<td style='width:5%'>$descampo1c</td>
												<td style='width:5%'>$descampo1d</td>
												<td style='width:5%'>$descampo1e</td>
												<td style='width:10%'>$camposdifb1[$x]</td>
												<td style='width:10%'>$descampo2a</td>
												<td style='width:12%'>$descampo2b</td>
												<td style='width:5%'>$descampo2c</td>
												<td style='width:5%'>$descampo2d</td>
												<td >$descampo2e</td>
											</tr>";
											$aux=$iter;
											$iter=$iter2;
											$iter2=$aux;
										}
									}
                                ?>
                            </table>
                        </div>
                    </div>
               </div>
         	</div>
		</form>
	</body>
</html>