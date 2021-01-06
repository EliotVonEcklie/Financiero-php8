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
		<?php require "head.php"; ?>
		<title>:: Spid - Calidad</title>
		<script>
		
			function agregarmarco()
			{
				if((document.form2.normativa.value!="")&&(document.form2.fecmls.value!="")&&(document.form2.desmar.value!="")&&(document.form2.nomarch.value!=""))
				{
					document.getElementById('banmlg').value=parseInt(document.getElementById('banmlg').value)+1;
					document.form2.agregamlg.value=1;
					document.form2.submit();
				}
			 	else {despliegamodalm('visible','2','Falta informaci\xf3n para poder Agregar Documento al Marco Legal');}	
			}
			function eliminarml(variable)
			{
				if (confirm("Esta Seguro de Eliminar"))
				{
					document.getElementById('banmlg').value=parseInt(document.getElementById('banmlg').value)-1;
					document.form2.eliminaml.value=variable;
					document.getElementById('eliminaml').value=variable;
					document.form2.submit();
				}
			}
            function iratras(){
                location.href="meci-estruorganizacionalbusca.php";
            }
		</script>
		<?php 
			titlepag();
			function eliminarDir()
			{
				$carpeta="informacion/marco_legal/temp";
				foreach(glob($carpeta . "/*") as $archivos_carpeta)
				{
					if (is_dir($archivos_carpeta)){eliminarDir($archivos_carpeta);}
					else{unlink($archivos_carpeta);}
				}
				rmdir($carpeta);
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
					<a onclick="location.href='meci-estruorganizacional.php'" class="tooltip bottom mgbt"><img src="imagenes/add.png"/><span class="tiptext">Nuevo</span></a>
					<a class="tooltip bottom mgbt"><img src="imagenes/guardad.png"/><span class="tiptext">Guardar</span></a>
					<a onclick="location.href='meci-estruorganizacionalbusca.php'" class="tooltip bottom mgbt"><img src="imagenes/busca.png" /><span class="tiptext">Buscar</span></a>
					<a class="tooltip bottom mgbt" onClick="mypop=window.open('meci-principal.php','','');mypop.focus();"><img src="imagenes/nv.png"><span class="tiptext">Nueva Ventana</span></a>
					<a onClick="mypop=window.open('<?php echo $url2; ?>','','');mypop.focus();" class="tooltip bottom mgbt"><img src="imagenes/duplicar_pantalla.png"><span class="tiptext">Duplicar pestaña</span></a>
					<a onClick="iratras()" class="tooltip bottom mgbt"><img src="imagenes/iratras.png"><span class="tiptext">Atrás</span></a>
				</td>
        	</tr>
		</table>
         <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
 		<form name="form2" method="post" enctype="multipart/form-data"> 
			<?php
                $vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
                $linkbd=conectar_bd(); 
               
				
				//*****************************************************************
				if($_POST[ocumlg]=="")
				{
					$rutaad="informacion/marco_legal/temp/";
					if(!file_exists($rutaad)){mkdir ($rutaad);}
					else {eliminarDir();mkdir ($rutaad);}
					if($_POST[banmlg]!="" && $_POST[banmlg]!=0)
					{ 
						$xx=count($_POST[marcla]);
						for($posi=0;$posi<$xx;$posi++)
						{
							unset($_POST[marcla][0]);
							unset($_POST[marfec][0]);
							unset($_POST[mardes][0]);
							unset($_POST[maradj][0]);
							$_POST[marcla]= array_values($_POST[marcla]); 
							$_POST[marfec]= array_values($_POST[marfec]); 
							$_POST[mardes]= array_values($_POST[mardes]); 
							$_POST[maradj]= array_values($_POST[maradj]);
						}
					}
					$_POST[banmlg]=0;
					$_POST[ocumlg]="1";
					
				}
				//*****************************************************************
 				if($_POST[oculto]=="")
                {
					$_POST[oculid]=$_GET[id];
					$_POST[oculcl]=$_GET[clase];
					switch($_POST[oculcl])
                	{
                   		case "VIS":
							$_POST[tabgroup1]=1;
							$bloqueo2="disabled";
							$bloqueo3="disabled";
							$bloqueo4="disabled";
							$bloqueo5="disabled";
							$sqlv="SELECT * FROM meciestructuraorg WHERE id='".$_POST[oculid]."'";
							$rowv=mysql_fetch_row(mysql_query($sqlv,$linkbd));
							$divpro=explode(".",$rowv[2]);
							$_POST[vervia]=$divpro[0];
							$_POST[vervib]=$divpro[1];	
							$_POST[fecvis]=$rowv[3];
							$_POST[vision]=str_replace("&lt;br/&gt;","\n",$rowv[4]);
							$_POST[idvisi]=$_POST[oculid];
                        	break;
						case "MIS":
							$_POST[tabgroup1]=2;
							$bloqueo1="disabled";
							$bloqueo3="disabled";
							$bloqueo4="disabled";
							$bloqueo5="disabled";
							$sqlm="SELECT * FROM meciestructuraorg WHERE id='".$_POST[oculid]."'";
							$rowm=mysql_fetch_row(mysql_query($sqlm,$linkbd));
							$divpro=explode(".",$rowm[2]);
							$_POST[vermia]=$divpro[0];
							$_POST[vermib]=$divpro[1];	
							$_POST[fecmis]=$rowm[3];
							$_POST[mision]=str_replace("&lt;br/&gt;","\n",$rowm[4]);
							$_POST[idmisi]=$_POST[oculid];
                        	break;
						case "PCL":
							$_POST[tabgroup1]=5;
							$bloqueo1="disabled";
							$bloqueo2="disabled";
							$bloqueo3="disabled";
							$bloqueo4="disabled";
							$sqlm="SELECT * FROM meciestructuraorg WHERE id='".$_POST[oculid]."'";
							$rowm=mysql_fetch_row(mysql_query($sqlm,$linkbd));
							$divpro=explode(".",$rowm[2]);
							$_POST[verpca]=$divpro[0];
							$_POST[verpcb]=$divpro[1];	
							$_POST[fecpcl]=$rowm[3];
							$_POST[policalidad]=str_replace("&lt;br/&gt;","\n",$rowm[4]);
							$_POST[idpcl]=$_POST[oculid];
                        	break;
						case "OBJ":
							$_POST[tabgroup1]=3;
							$bloqueo1="disabled";
							$bloqueo2="disabled";
							$bloqueo4="disabled";
							$bloqueo5="disabled";
							$sqlo="SELECT * FROM meciestructuraorg WHERE id='".$_POST[oculid]."'";
							$rowo=mysql_fetch_row(mysql_query($sqlo,$linkbd));
							$divpro=explode(".",$rowo[2]);
							$_POST[veroba]=$divpro[0];
							$_POST[verobb]=$divpro[1];
							$_POST[fecobj]=$rowo[3];
							$_POST[objgen]=$rowo[4];
							$sqloe="SELECT * FROM meciestructuraorg_objespe WHERE idobjesp='".$_POST[oculid]."' ORDER BY id ASC";
							$resp=mysql_query($sqloe,$linkbd);
							$ntr=mysql_num_rows($resp); 
							while ($rowoe =mysql_fetch_row($resp)) {$_POST[dobjesp][]=$rowoe[2];}
							$_POST[banobj]=$ntr;
							$_POST[idobje]=$_POST[oculid];
                        	break;
						case "MCL":
							$_POST[tabgroup1]=4;
							$bloqueo1="disabled";
							$bloqueo2="disabled";
							$bloqueo3="disabled";
							$bloqueo5="disabled";
                        	break;
					}
					$_POST[oculto]="0";
                }
				//*****************************************************************
				switch($_POST[tabgroup1])
				{
					case 1:	$check1='checked';break;
					case 2:	$check2='checked';break;
					case 3:	$check3='checked';break;
					case 4:	$check4='checked';break;
					case 5:	$check5='checked';break;
				}
				//*****************************************************************
				if ($_POST[eliminaml]!='')
				{ 
					$posi=$_POST[eliminaml];
					unset($_POST[marcla][$posi]);
					unset($_POST[marfec][$posi]);
					unset($_POST[mardes][$posi]);
					unset($_POST[maradj][$posi]);
					$_POST[marcla]= array_values($_POST[marcla]); 
					$_POST[marfec]= array_values($_POST[marfec]); 
					$_POST[mardes]= array_values($_POST[mardes]); 
					$_POST[maradj]= array_values($_POST[maradj]); 
				}
				//*****************************************************************
				if ($_POST[agregamlg]=='1')
				{
					$_POST[marcla][]=$_POST[normativa];	
					$_POST[marfec][]=$_POST[fecmls];	
					$_POST[mardes][]=$_POST[desmar];	
					$_POST[maradj][]=$_POST[nomarch];	
					$_POST[normativa]="";
					$_POST[fecmls]="";
					$_POST[desmar]="";
					$_POST[nomarch]="";	
					$_POST[agregamlg]='0';
				}
				//*****************************************************************
            ?>
            <input type="hidden" name="banobj" id="banobj" value="<?php echo $_POST[banobj];?>" >
            <input type="hidden" name="banmlg" id="banmlg" value="<?php echo $_POST[banmlg];?>" >
            <div class="tabsmeci"  style="height:76.5%; width:99.6%">
                <div class="tab">
                    <input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> <?php echo $bloqueo1;?>>
                    <label for="tab-1">Visi&oacute;n</label>
                    <div class="content" style="overflow:hidden;">
                        <table class="inicio" >
                            <tr>
                                <td class="titulos" colspan="6" style="width:100%">Visi&oacute;n</td>
                                <td class="boton02" onclick="location.href='meci-principal.php'">Cerrar</td>
                            </tr>
                            <tr>
                                <td class="saludo1" colspan="4" style="width:60%;">Descripci&oacute;n:</td>
                                <td rowspan="2" style="text-align:center;"><img src="imagenes/escudo.jpg" style="width:74%"></td>
                            </tr>
                            <tr>
                                <td colspan="4" ><textarea name="vision" id="vision" rows="20" style="width:100%;" readonly><?php echo $_POST[vision];?></textarea></td>  
                            </tr>
                             <tr>
                                <td class="saludo1" style="width:5%;">Versi&oacute;n:</td>
                                <td style="width:10%;">
                                	<input type="text"  name="vervia" id="vervia" value="<?php echo $_POST[vervia];?>" style="width:30%; text-align:right;" readonly>.<input type="text"  name="vervib" id="vervib" value="<?php echo $_POST[vervib];?>" style="width:30%; text-align:right;" readonly>
                                </td>
                                <td class="saludo1" style="width:5%;">Fecha:</td>
                                <td><input type="date" name="fecvis" id="fecvis" value="<?php echo $_POST[fecvis]?>" readonly> </td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                </div> 
                <div class="tab">
                    <input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?> <?php echo $bloqueo2;?>>
                    <label for="tab-2">Misi&oacute;n</label>
                    <div class="content" style="overflow:hidden;">
                        <table class="inicio" >
                       		<tr>
                                <td class="titulos" colspan="5" style="width:100%">Misi&oacute;n</td>
                                <td class="boton02" onclick="location.href='meci-principal.php'">Cerrar</td>
                            </tr>
                            <tr>
                                <td class="saludo1" colspan="4" style="width:60%;">Descripci&oacute;n:</td>
                                <td rowspan="2" style="text-align:center;"><img src="imagenes/escudo.jpg" style="width:74%"></td>
                            </tr>
                            <tr>
                                <td colspan="4" ><textarea name="mision" id="mision" rows="20" style="width:100%;" readonly><?php echo $_POST[mision];?></textarea></td>  
                            </tr>
                             <tr>
                                <td class="saludo1" style="width:5%;">Versi&oacute;n:</td>
                                <td style="width:10%;">
                                	<input type="text"  name="vermia" id="vermia" value="<?php echo $_POST[vermia];?>" style="width:30%; text-align:right;" readonly>.<input type="text"  name="vermib" id="vermib" value="<?php echo $_POST[vermib];?>" style="width:30%; text-align:right;" readonly>
                                </td>
                                <td class="saludo1" style="width:5%;">Fecha:</td>
                                <td><input type="date" name="fecmis" id="fecmis" value="<?php echo $_POST[fecmis]?>" readonly></td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                </div>
				<div class="tab">
					<input type="radio" id="tab-5" name="tabgroup1" value="5" <?php echo $check5;?> <?php echo $bloqueo5;?>>
					<label for="tab-5">Politica de Calidad</label>
					<div class="content" style="overflow:hidden;">
						<table class="inicio" >
							<tr>
								<td class="titulos" colspan="5" style="width:100%">Politica de Calidad</td>
								<td class="boton02" onClick="location.href='meci-principal.php'">Cerrar</td>
							</tr>
							<tr>
								<td class="saludo1" colspan="4" style="width:60%;">Descripci&oacute;n:</td>
								<td rowspan="2" style="text-align:center;"><img src="imagenes/escudo.jpg" style="width:74%"></td>
							</tr>
							<tr>
								<td colspan="4" ><textarea name="policalidad" id="policalidad" rows="20" style="width:100%;" readonly><?php echo $_POST[policalidad];?></textarea></td>
							</tr>
							 <tr>
								<td class="saludo1" style="width:5%;">Versi&oacute;n:</td>
								<td style="width:10%;">
									<input type="text"  name="verpca" id="verpca" value="<?php echo $_POST[verpca];?>" style="width:30%; text-align:right;" onKeyPress="javascript:return solonumeros(event)" readonly>.<input type="text"  name="verpcb" id="verpcb" value="<?php echo $_POST[verpcb];?>" style="width:30%; text-align:right;" onKeyPress="javascript:return solonumeros(event)" readonly>
								</td>
								<td class="saludo1" style="width:5%;">Fecha:</td>
								<td><input type="date" name="fecpcl" id="fecpcl" value="<?php echo $_POST[fecpcl]?>" readonly></td>
								<td></td>
							</tr>
						</table>
					</div>
				</div>
                <div class="tab">
                    <input type="radio" id="tab-3" name="tabgroup1" value="3" <?php echo $check3;?> <?php echo $bloqueo3;?>>
                    <label for="tab-3">Objetivos</label>
                    <div class="content" style="overflow:hidden;">
                        <table class="inicio ancho">
                            <tr>
                                <td class="titulos" colspan="5" width="100%">Objetivos</td>
                                <td class="boton02" onclick="location.href='meci-principal.php'">Cerrar</td>
                            </tr>
                            <tr>
                                <td class="saludo1" style="width:12%;">Objetivo General:</td>
                                <td colspan="4"><input type="text" name="objgen" id="objgen" value="<?php echo $_POST[objgen];?>" style="width:100%;" readonly></td>
                            </tr>
                            <tr>
                                <td class="saludo1" >Versi&oacute;n:</td>
                                <td style=" width:10%;">
                                	<input type="text"  name="veroba" id="veroba" value="<?php echo $_POST[veroba];?>" style="width:30%; text-align:right;" readonly>.<input type="text"  name="verobb" id="verobb" value="<?php echo $_POST[verobb];?>" style="width:30%; text-align:right;" readonly>
                                </td>
                                <td class="saludo1" style="width:5%;">Fecha:</td>
                                <td><input type="date" name="fecobj" id="fecobj" value="<?php echo $_POST[fecobj]?>" readonly></td>
       						</tr>
                            <tr>
                                <td class="saludo1">Objetivos Espec&iacute;ficos:</td>
                                <td colspan="3">
                                 	<input type="text" name="objesp" id="objesp" value="<?php echo $_POST[objesp];?>" style="width:100%" readonly>
                                </td>
                            </tr>
                        </table>
                        <div class="subpantallac5" style="overflow:hidden-x;">
                            <table class="inicio">
                                <tr>
                                    <td class="titulos" style="width:6%;">Item</td>
                                    <td class="titulos" style="width:90%;">Objetivo Espec&iacute;fico</td>
                                </tr>
                                <?php
                                    $iter="saludo1";
                                    $iter2="saludo2";
                                    $tam=count($_POST[dobjesp]);   
                                    for($x=0;$x<$tam;$x++)
                                    {
                                        echo "
                                            <tr class='$iter'>
                                                <td>".($x+1)."</td>
                                                <td><input class='inpnovisibles' type='text' name='dobjesp[]' value='".$_POST[dobjesp][$x]."' style='width:100;' readonly></td>
                                              
                                            </tr>";  
										$aux=$iter;
										$iter=$iter2;
										$iter2=$aux; 
                                    }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab">
                    <input type="radio" id="tab-4" name="tabgroup1" value="4" <?php echo $check4;?> <?php echo $bloqueo4;?>>
                    <label for="tab-4">Marco Legal</label>
                    <div class="content" style="overflow:hidden;">
                        <table class="inicio" >
                            <tr>
                                <td class="titulos" colspan="6" width="100%">Marco Legal</td>
                                 <td class="boton02" onclick="location.href='meci-principal.php'">Cerrar</td>
                            </tr>
                            <tr>
                            	<td class="saludo1" style="width:10%;">Clase Normativa:</td>
                                <td style="width:15%;">
                                	<select name="normativa" id="normativa" style="width:100%;" >
                                    	<?php
                                            $sqlr="select * from mecinormativa order by id ASC";
                                            $res=mysql_query($sqlr,$linkbd);
                                            while ($row =mysql_fetch_row($res)) 
                                            {
                                                echo "<option value=$row[0] ";
                                                $i=$row[0];
                                                if($i==$_POST[normativa]){echo "SELECTED"; $_POST[normativa]=$row[1];}
                                                echo ">".$row[0]." - ".$row[1]." </option>";
                                            }	 	
                                        ?>
                                    </select>
                                </td>
                                <td class="saludo1" style="width:12%;">Documento Adjunto:</td>
                                <td ><input type="text" name="nomarch" id="nomarch"  style="width:100%" value="<?php echo $_POST[nomarch]?>" readonly></td>
                                <td>
                                    <div class='upload'> 
                                        <input type="file" name="plantillaad" onChange="document.form2.submit();" />
                                        <img src='imagenes/attach.png'  title='Cargar Documento'  /> 
                                    </div> 
                                </td>
                            </tr>
                            <tr>
                                <td class="saludo1">Descripci&oacute;:</td>
                                <td colspan="3" style="width:72%">
                					<input type="text" name="desmar" id="desmar" value="<?php echo $_POST[desmar];?>" style="width:100%">
                                </td>
                            </tr>
                             <tr>
                                <td class="saludo1" style="width:5%;">Fecha:</td>
                                <td><input type="date" name="fecmls" id="fecmls" value="<?php echo $_POST[fecmls]?>"></td>
                                <td style="width:5%">
                                	<input name="agregamar" type="button" value="  Agregar Documento " onClick="agregarmarco()">
                               </td>
                            </tr>
                        </table>
                        <div class="subpantallac5" style="overflow:hidden-x;">
                            <table class="inicio">
                            	 <tr>
                                    <td class="titulos" style="width:6%;">Item</td>
                                    <td class="titulos" style="width:15%;">Clase</td>
                                    <td class="titulos" style="width:35%;">Descripci&oacute;n</td>
                                    <td class="titulos" style="width:30%;">Adjunto</td>
                                    <td class="titulos" style="width:10%;">Fecha</td>
                                    <td class="titulos" style="width:4%;"><img src='imagenes/del.png'></td>
                                </tr>
                                <?php
                                    $iter="saludo1";
                                    $iter2="saludo2";
                                    $tam=count($_POST[marcla]);   
                                    for($x=0;$x<$tam;$x++)
                                    {
                                        echo "
                                            <tr class='$iter'>
                                                <td>".($x+1)."</td>
                                                <td><input class='inpnovisibles type='text' name='marcla[]' value='".$_POST[marcla][$x]."' style='width:100%;' readonly></td>
                                                <td><input class='inpnovisibles type='text' name='mardes[]' value='".$_POST[mardes][$x]."' style='width:100%;' readonly></td>
												<td><input class='inpnovisibles type='text' name='maradj[]' value='".$_POST[maradj][$x]."' style='width:100%;' readonly></td>
												<td><input class='inpnovisibles type='text' name='marfec[]' value='".$_POST[marfec][$x]."' style='width:100%;' readonly></td>
                                                <td><a href='#' onclick='eliminarml($x)'><img src='imagenes/del.png'></a></td>
                                            </tr>";   
										$aux=$iter;
										$iter=$iter2;
										$iter2=$aux;
                                    }
                                ?>
                            </table>
                    	</div>
                    </div>
                </div>
            </div>  
            <input type="hidden" name="oculid" id="oculid" value="<?php echo $_POST[oculid];?>">
            <input type="hidden" name="oculcl" id="oculcl" value="<?php echo $_POST[oculcl];?>">
            <input type="hidden" name="oculto" id="oculto" value="<?php echo $_POST[oculto];?>">
            <input type="hidden" name="ocumlg" id="ocumlg" value="<?php echo $_POST[ocumlg];?>">
            <input type="hidden" name="idvisi" id="idvisi" value="<?php echo $_POST[idvisi];?>">
            <input type="hidden" name="idmisi" id="idmisi" value="<?php echo $_POST[idmisi];?>">
            <input type="hidden" name="idobje" id="idobje" value="<?php echo $_POST[idobje];?>">
            <input type="hidden" name="idmale" id="idmale" value="<?php echo $_POST[idobje];?>">
            <input type="hidden" name="agregadet" value="0">
            <input type="hidden" name="agregamlg" value="0">
            <input type='hidden' name='elimina' id='elimina'>
            <input type='hidden' name='eliminaml' id='eliminaml'>
 		</form>       
	</body>
</html>