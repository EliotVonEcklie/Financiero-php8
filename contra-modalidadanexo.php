<?php //V 1000 12/12/16 ?> 
<?php
	error_reporting(0);
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
		<title>:: Spid - Contrataci&oacute;n</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<script>
			function guardar()
			{
				if (document.form2.modalidad.value!='' && document.form2.submodalidad.value!='' && document.form2.contdet.value!=0)
				{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
				else
				{
					despliegamodalm('visible','2','Faltan datos para completar el registro');
					document.form2.modalidad.focus();document.form2.modalidad.select();
				}
			 }
			function agregardetalle()
			{
				if(document.form2.estado.value!="" && document.form2.anexos.value!="")
				{ 
					document.form2.contdet.value=parseInt(document.form2.contdet.value)+1;
					document.form2.agregadet.value=1;document.form2.submit();
				}
				else {despliegamodalm('visible','2','Falta información para poder Agregar Detalle Anexo');}
			}
			function eliminar(variable)
			{
				
				document.getElementById('elimina').value=variable;
				despliegamodalm('visible','4','Esta Seguro de Eliminar el Anexo','2');
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
							document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;	
					}
				}
			}
			function funcionmensaje(){document.location.href = "contra-modalidadanexo.php";}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.form2.oculto.value=2;document.form2.submit();break;
					case "2":	document.form2.oculto.value='6';
								document.form2.contdet.value=parseInt(document.form2.contdet.value)-1;
								document.form2.submit();break;
				}
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("contra");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("contra");?></tr>
        	<tr>
  				<td colspan="3" class="cinta">
					<a href="contra-modalidadanexo.php" class="mgbt"><img src="imagenes/add.png"  title="Nuevo" border="0" /></a>
					<a href="#"  onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png"  title="Guardar" /></a>
					<a href="contra-modalidadanexobusca.php" class="mgbt"><img src="imagenes/busca.png"  title="Buscar" border="0" /></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" onClick="mypop=window.open('contra-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a>
            	</td>
			</tr>
		</table>
     	<div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
		<form name="form2" method="post" > 
 		<?php
			if($_POST[oculto]=="")
			{
				$_POST[contdet]=0;
				$_POST[oculto]="5";
			}
			if ($_POST[agregadet]=='1')
			{
				if($_POST[contdet]==1)
				{
					$contb=0;
					$sqlr="SELECT id FROM contraanexos WHERE Fijo='S' ORDER BY id";
					$resp = mysql_query($sqlr,$linkbd);
					while ($row=mysql_fetch_row($resp)) 
					{
						$_POST[manex][]=$row[0];
						$_POST[mestad][]="S";
						$_POST[mobliga][]="S";
						$_POST[mbloqueo][]="S";
						$contb++;
					}
					$_POST[contdet]=$_POST[contdet]+$contb;
				}
				$_POST[manex][]=$_POST[anexos];
				$_POST[mestad][]=$_POST[estado];
				$_POST[mobliga][]="S";
				$_POST[mbloqueo][]="N";
				if($_POST[obligatorio]==""){$_POST[mobliga][]="S";}
				else{$_POST[mobliga][]=$_POST[obligatorio];}
				$_POST[anexos]=""; 
				$_POST[agregadet]=0;
				echo"<script>document.form2.nombredet.value='';document.form2.nombredet.focus();</script>";
			}		
 		?>
			<table class="inicio" >
				<tr>
					<td class="titulos" colspan="4" style="width:90%">Crear Datos B&aacute;sicos Contratos</td>
         			<td class="cerrar" style="width:6%" ><a href="contra-principal.php">Cerrar</a></td>
        		</tr>
                <tr>
                    <td class="saludo1" style="width:5%">Modalidad:</td>
                    <td style="width:20%">
            			<select id="modalidad" name="modalidad" class="elementosmensaje" style="width:80%"  onKeyUp="return tabular(event,this)" onChange="document.form2.submodalidad.value=0;document.form2.submit();">
                			<option onChange="" value="" >Seleccione....</option>
							<?php	
								$sqlr="SELECT * FROM dominios WHERE nombre_dominio='MODALIDAD_SELECCION' AND (valor_final IS NULL OR valor_final='') AND tipo='S' ORDER BY valor_inicial ASC  ";
								$res=mysql_query($sqlr,$linkbd);
								while ($rowEmp = mysql_fetch_assoc($res)) 
								{
									$sqlr2="SELECT * FROM dominios WHERE nombre_dominio='MODALIDAD_SELECCION' AND valor_final='".$rowEmp['valor_inicial']."' AND tipo='S' ORDER BY valor_inicial ASC  ";
									$res2=mysql_query($sqlr2,$linkbd);
									$ntr = mysql_num_rows($res2);
									if($ntr!=0)
									{
										echo "<option value= ".$rowEmp['valor_inicial'];
										$i=$rowEmp['valor_inicial'];
										if($i==$_POST[modalidad])
										{
											echo "  SELECTED";
											$_POST[octradicacion]=$rowEmp['descripcion_valor'];
										}
										echo ">".$rowEmp['valor_inicial']." - ".strtoupper($rowEmp['descripcion_valor'])."</option>";
									}
								}
              				?> 
						</select>
           			</td>
   					<td class="saludo1" style="width:8%">Proceso:</td>
            		<td style="width:28%">
            			<select id="submodalidad" name="submodalidad" class="elementosmensaje" style="width:60%"  onKeyUp="return tabular(event,this)" onChange="document.form2.submit();">
                			<option onChange="" value="" >Seleccione....</option>
							<?php	
								$contsm=0;
								$sqlr="SELECT * FROM dominios WHERE nombre_dominio='MODALIDAD_SELECCION' AND VALOR_FINAL IS NOT NULL AND valor_final='$_POST[modalidad]' ORDER BY  valor_inicial ASC  ";
								$res=mysql_query($sqlr,$linkbd);
								while ($rowEmp = mysql_fetch_assoc($res)) 
				    			{
									if($rowEmp['tipo']=='S')
									{
										$sqlr2="SELECT * FROM contramodalidadanexos WHERE idmodalidad='$_POST[modalidad]' AND idpadremod=".$rowEmp['valor_inicial'];
										$res2=mysql_query($sqlr2,$linkbd);
										if( mysql_num_rows($res2)==0)
										{
											$contsm++;
											echo "<option value= ".$rowEmp['valor_inicial'];
											$i=$rowEmp['valor_inicial'];
											if($i==$_POST[submodalidad])
											{
											echo "  SELECTED";
											$_POST[octradicacion]=$rowEmp['descripcion_valor'];
											}
											echo ">".$rowEmp['valor_inicial']." - ".$rowEmp['descripcion_valor']."</option>";
										}
										
									}
								}
								if($contsm==0&&$_POST[modalidad]!=""){echo "<option value='' SELECTED>Ya se ingresaron todas las SubModalidades</option>";}
									
              				?> 
						</select>
            		</td>
   				</tr>
			</table>
			<table class="inicio" >
                <tr>
                    <td class="titulos" colspan="7">Agregar Anexos</td>
                </tr>
 				<tr>
                    <td class="saludo1" style="width:8%">Anexo:</td>
                    <td style="width:30%">
            			<select id="anexos" name="anexos" class="elementosmensaje" style="width:80%"  onKeyUp="return tabular(event,this)" >
                			<option onChange="" value="" >Seleccione....</option>
							<?php	
								$sqlr="SELECT * FROM contraanexos WHERE Fijo='N' AND estado='S' ORDER BY id ASC  ";
								$res=mysql_query($sqlr,$linkbd);
								while ($rowEmp = mysql_fetch_assoc($res)) 
								{
									if (!in_array($rowEmp['id'], $_POST[manex]))
									{
										$sqlr2="SELECT * FROM contramodalidadanexos WHERE idmodalidad=".$_POST[modalidad]." AND idpadremod=".$_POST[submodalidad]." AND idanexo=".$rowEmp['id'];
										$res2=mysql_query($sqlr2,$linkbd);
										if( mysql_num_rows($res2)==0)
										{
											echo "<option value= ".$rowEmp['id'];
											$i=$rowEmp['id'];
											if($i==$_POST[anexos])
											{
												echo "  SELECTED";
												$_POST[octradicacion]=$rowEmp['nombre'];
											}
											if ($rowEmp['fase']==1){$fase="Precontractual";}
											else if ($rowEmp['fase']==2){$fase="Contractual";}
											else if ($rowEmp['fase']==3){$fase="Postcontractual";}
											echo ">".$rowEmp['id']." - ".$rowEmp['nombre']." (".$fase.")"."</option>"; 
										}
									}
								}		
              				?> 
						</select>
            		</td>
                    <td class="saludo1" style="width:10%">Soporte para Pago:</td>
                    <td style="width:10%"> 
            			<select name="estado" id="estado" onKeyUp="return tabular(event,this)" onChange="document.form2.ocuestado.value=1; document.form2.submit();">
          					<option value="S" <?php if($_POST[estado]=='S') echo "SELECTED"; ?>>SI</option>
          					<option value="N" <?php if($_POST[estado]=='N') echo "SELECTED"; ?>>NO</option>
        				</select>
					</td>
            		<td class="saludo1" style="width:6%">Obligatorio:</td>
           			<td style="width:10%"> 
                        <select name="obligatorio" id="obligatorio" onKeyUp="return tabular(event,this)" disabled  >
                            <option value="S" <?php if($_POST[obligatorio]=='S') echo "SELECTED"; ?>>SI</option>
                            <option value="N" <?php if($_POST[obligatorio]=='N') echo "SELECTED"; ?>>NO</option>
                        </select>
					</td>
            		<td><input type="button" name="agregar" id="agregar" value="   Agregar   " onClick="agregardetalle();" ></td>
                    <input type="hidden" name="oculto" value="1">
                    <input type="hidden" name="ocuestado" id="ocuestado" value="<?php echo $_POST[ocuestado]?>">
                    <input type="hidden" name="agregadet" value="0"> 
                    <input type="hidden" name="contdet" id="contdet"  value="<?php echo $_POST[contdet]?>"> 
                    <input type="hidden" name="elimina" id="elimina"  value="<?php echo $_POST[elimina]?>">
 				</tr>
 			</table> 
    		<div class="subpantallac5"style="height:59.7%; width:99.6%; overflow-x:hidden;">    
 				<table class="inicio" >
                    <tr>
                        <td class="titulos" colspan="5">Detalles Anexos</td>
                    </tr>
					<tr>
						<td class="titulos2">ID Anexos</td>
                        <td class="titulos2"> Anexos</td>
                        <td class="titulos2">Soporte para Pagos</td>
                        <td class="titulos2">Obligatorio</td>
                        <td class="titulos2">Eliminar</td>
   					</tr>    
   					<?php 
						if($_POST[ocuestado]==1)
						{
							if ($_POST[estado]=='S')
							{echo"<script>document.form2.obligatorio.value='S';document.form2.obligatorio.disabled=true;</script>";}
							else
							{echo"<script>document.form2.obligatorio.disabled=false;</script>";}
							$_POST[ocuestado]=0;
						}
						if ($_POST[oculto]=='6')
						{ 
							$posi=$_POST[elimina];
							unset($_POST[manex][$posi]);
							unset($_POST[mestad][$posi]);
							unset($_POST[mobliga][$posi]);
							unset($_POST[mbloqueo][$posi]);
							$_POST[manex]= array_values($_POST[manex]); 
							$_POST[mestad]= array_values($_POST[mestad]); 
							$_POST[mobliga]= array_values($_POST[mobliga]); 
							$_POST[mbloqueo]= array_values($_POST[mbloqueo]);
							$_POST[elimina]='';	
							$_POST[oculto]='1';		 
						 }	 
						$iter='saludo1';
						$iter2='saludo2';
						for ($x=0;$x<count($_POST[mestad]);$x++)
		 				{		 
							$sqlr="SELECT nombre,fase FROM contraanexos WHERE id='".$_POST[manex][$x]."'";
							$resp=mysql_query($sqlr,$linkbd);
							$row=mysql_fetch_row($resp);
							$nomanex=$row[0];
							if ($row[1]==1){$fase="Precontractual";}
							else {$fase="Contractual";}
							if ($_POST[mbloqueo][$x]=='S'){$beliminar="<a href='#'><img src='imagenes/candado.png' style='width:18px' title='Bloqueado'></a>";}
							else{$beliminar="<a href='#' onclick='eliminar($x);'><img src='imagenes/del.png' style='width:16px' title='Eliminar'></a>";}
		 					echo "
							<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase'>
								<td  style='width:6%'><input class='inpnovisibles' name='manex[]' value='".$_POST[manex][$x]."' type='text' style='background-color:transparent;'  readonly ></td>
								<td style='width:60%'><input class='inpnovisibles' name='manex2[]' value='".$nomanex." (".$fase.")' type='text' style='width:100%; background-color:transparent;' readonly></td>
								<td style='width:6%'><input class='inpnovisibles' name='mestad[]' value='".$_POST[mestad][$x]."' type='text' style='background-color:transparent;' readonly></td>
								<td style='width:6%'><input class='inpnovisibles' name='mobliga[]' value='".$_POST[mobliga][$x]."' type='text' style='background-color:transparent;' readonly></td>
								<td style='text-align:center;'>$beliminar</td>
								<input name='mbloqueo[]' value='".$_POST[mbloqueo][$x]."' type='hidden'>
							</tr>";
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux;
			 			}
					?>
  				</table>  
  			</div>    
 			<?php  
				if($_POST[oculto]=="2")//********guardar
				{
					
					for ($x=0;$x<count($_POST[mestad]);$x++)
					{
							$sqlr2="SELECT fase FROM contraanexos WHERE id=".$_POST[manex][$x];
							$res2=mysql_query($sqlr2,$linkbd);
							$row2=mysql_fetch_row($res2);
							$sqlr="insert into contramodalidadanexos (idmodalidad,idpadremod,idanexo,obligatorio,estado,fase) values ('$_POST[modalidad]','$_POST[submodalidad]','".$_POST[manex][$x]."','".$_POST[mobliga][$x]."','".$_POST[mestad][$x]."','".$row2[0]."') ";	
							mysql_query($sqlr,$linkbd);
					}
					echo"<script>despliegamodalm('visible','1','Se ha almacenado los Datos Básicos de Contrato con Exito');</script>";
				}
			
 			?>
 		</form>       
	</body>
</html>