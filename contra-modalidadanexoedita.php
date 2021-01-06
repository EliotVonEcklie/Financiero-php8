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
	$scroll=$_GET['scrtop'];
	$totreg=$_GET['totreg'];
	$idcta=$_GET['idcta'];
	$altura=$_GET['altura'];
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
				{despliegamodalm('visible','4','Esta Seguro de Modificar los Datos Bàsicos del Contrato','1');}
				else
				{
					despliegamodalm('visible','2','Faltan datos para Modificar los Datos Bàsicos del Contrato');
					document.form2.modalidad.focus();document.form2.modalidad.select();
				}
			}
			function agregardetalle()
			{
				if(document.form2.estado.value!="" && document.form2.anexos.value!="" )
				{
					document.form2.agregadet.value=1;
					document.getElementById('oculto').value='7';
					document.form2.contdet.value=parseInt(document.form2.contdet.value)+1;
					document.form2.submit();
				 }
				 else {despliegamodalm('visible','2','Faltan datos para Agregar el Anexo');}
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
			function funcionmensaje(){}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.getElementById('oculto').value='2';document.form2.submit();break;
					case "2":	document.getElementById('oculto').value='6';
								document.form2.contdet.value=parseInt(document.form2.contdet.value)-1;
								document.form2.submit();break;
				}
			}
		</script>
		<script>
			function adelante(scrtop, numpag, limreg, filtro, next){
				if(parseFloat(document.form2.idcomp.value)<parseFloat(document.form2.maximo.value)){
					document.getElementById('oculto').value='1';
					document.getElementById('modalidadcod').value=next;
					var idcta=document.getElementById('modalidadcod').value;
					document.form2.action="contra-modalidadanexoedita.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					document.form2.submit();
				}
			}
		
			function atrasc(scrtop, numpag, limreg, filtro, prev){
				if(document.form2.cuenta.value>1){
					document.getElementById('oculto').value='1';
					document.getElementById('modalidadcod').value=prev;
					var idcta=document.getElementById('modalidadcod').value;
					document.form2.action="contra-modalidadanexoedita.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					document.form2.submit();
				}
			}

			function iratras(scrtop, numpag, limreg){
				var idcta=document.getElementById('modalidadcod').value;
				location.href="contra-modalidadanexobusca.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg;
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <?php
		$numpag=$_GET[numpag];
		$limreg=$_GET[limreg];
		$scrtop=26*$totreg;
		?>
        <table>
            <tr><script>barra_imagenes("contra");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("contra");?></tr>
            <tr>
  				<td colspan="3" class="cinta">
					<a href="contra-modalidadanexo.php" class="mgbt"><img src="imagenes/add.png"  title="Nuevo" border="0" /></a>
					<a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png"  title="Guardar" /></a>
					<a href="contra-modalidadanexobusca.php" class="mgbt"><img src="imagenes/busca.png"  title="Buscar" border="0" /></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" onClick="mypop=window.open('contra-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a>
					<a href="#" onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>)" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
				</td>
			</tr>
		</table>
		<div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
 		<form name="form2" method="post"> 
		<?php
			if ($_GET[idproceso]!=""){echo "<script>document.getElementById('codrec').value=$_GET[idproceso];</script>";}
			if ($_GET[idproceso2]!=""){echo "<script>document.getElementById('codrec2').value=$_GET[idproceso2];</script>";}
			$sqlr="SELECT * FROM contramodalidadanexos ORDER BY idanexo DESC";
			$res=mysql_query($sqlr,$linkbd);
			$r=mysql_fetch_row($res);
			$_POST[maximo]=$r[0];
			if($_POST[oculto]==""){
				if ($_POST[codrec]!="" || $_GET[idproceso]!=""){
					if($_POST[codrec]!=""){
						$sqlr="SELECT * FROM contramodalidadanexos WHERE idmodalidad=".$_POST[codrec]." AND idpadremod=".$_POST[codrec2];
					}
					else{
						$sqlr="SELECT * FROM contramodalidadanexos WHERE idmodalidad=".$_GET[idproceso]." AND idpadremod=".$_GET[idproceso2];
					}
				}
				else{
					$sqlr="SELECT * FROM contramodalidadanexos ORDER BY idanexo DESC";
				}
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
			   	$_POST[modalidadcod]=$row[0];
			   	$_POST[submodalidadcod]=$row[1];
			}
 			if(($_POST[oculto]!="2")&&($_POST[oculto]!="6")&&($_POST[oculto]!="7")){	
				$_POST[contdet]=0;
				$sqlr="SELECT * FROM contramodalidadanexos WHERE idmodalidad=".$_POST[modalidadcod]." AND idpadremod=".$_POST[submodalidadcod]." ORDER BY idanexo";
				$resp = mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($resp))
				{
					$sqlf="SELECT Fijo FROM contraanexos WHERE id='$row[2]'";
					$resf = mysql_query($sqlf,$linkbd);
					$rowf =mysql_fetch_row($resf);
					$_POST[estado]=$row[5];
					$_POST[obligatorio]=$row[4];
					$_POST[manex][]=$row[2];
					$_POST[mestad][]=$row[5];
					$_POST[mobliga][]=$row[4];;
					$_POST[contdet]=$_POST[contdet]+1;
					$_POST[mbloqueo][]=$rowf[0];
				}
			}
			$sqlr="SELECT descripcion_valor FROM dominios WHERE nombre_dominio='MODALIDAD_SELECCION' AND (valor_final IS NULL OR valor_final='' ) AND valor_inicial=".$_POST[modalidadcod];
			$resp = mysql_query($sqlr,$linkbd);
			$row =mysql_fetch_row($resp);
			$_POST[modalidad]=strtoupper($row[0]);
			$sqlr="SELECT descripcion_valor FROM dominios WHERE nombre_dominio='MODALIDAD_SELECCION' AND valor_final=".$_POST[modalidadcod]." AND valor_inicial=".$_POST[submodalidadcod];
			$resp = mysql_query($sqlr,$linkbd);
			$row =mysql_fetch_row($resp);
			$_POST[submodalidad]=strtoupper($row[0]);
			if ($_POST[agregadet]=='1')
			{
				if($_POST[contdet]==1)
				{
					$contb=0;
					unset($_POST[manex]);
					unset($_POST[mestad]);
					unset($_POST[mobliga]);	 
					unset($_POST[esfijo]);	
					unset($_POST[mbloqueo]);	 		 		 		 
					$sqlr="SELECT id FROM contraanexos WHERE Fijo='S' ORDER BY id";
					$resp = mysql_query($sqlr,$linkbd);
					while ($row=mysql_fetch_row($resp)) 
					{
						$_POST[manex][]=1;
						$_POST[mestad][]="S";
						$_POST[mobliga][]="S";
						$_POST[mbloqueo][]="S";
						$_POST[esfijo][]="N";
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
			//NEXT
			$sqln="SELECT * FROM contramodalidadanexos WHERE idmodalidad > ".$_POST[modalidadcod]." ORDER BY idanexo ASC LIMIT 1";
			$resn=mysql_query($sqln,$linkbd);
			$row=mysql_fetch_row($resn);
			$next=$row[0];
			//PREV
			$sqlp="SELECT * FROM contramodalidadanexos WHERE idmodalidad < ".$_POST[modalidadcod]." ORDER BY idanexo DESC LIMIT 1";
			$resp=mysql_query($sqlp,$linkbd);
			$row=mysql_fetch_row($resp);
			$prev=$row[0];
 		?>
			<table class="inicio" >
                <tr>
                    <td class="titulos" colspan="4" style="width:90%">Editar Datos B&aacute;sicos Contratos</td>
                    <td class="cerrar" style="width:6%" ><a href="contra-principal.php">Cerrar</a></td>
                </tr>
   				<tr>
        			<td class="saludo1" style="width:5%">Modalidad:</td>
                    <td style="width:20%">
	        	    	<a href="#" onClick="atrasc(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $prev; ?>)"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a> 
                        <input id="modalidad" name="modalidad"style="width:50%" type="text" value="<?php echo $_POST[modalidad]?>" readonly>
	    	            <a href="#" onClick="adelante(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $next; ?>)"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> 
						<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo">
						<input type="hidden" value="<?php echo $_POST[codrec]?>" name="codrec" id="codrec">
						<input type="hidden" value="<?php echo $_POST[codrec2]?>" name="codrec2" id="codrec2">
                        <input id="modalidadcod" name="modalidadcod" type="hidden" value="<?php echo $_POST[modalidadcod]?>">
                    </td>
   					<td class="saludo1" style="width:8%">Proceso:</td>
                    <td style="width:28%">
                        <input id="submodalidad" name="submodalidad"style="width:60%" type="text" value="<?php echo $_POST[submodalidad]?>" readonly>
                        <input id="submodalidadcod" name="submodalidadcod" type="hidden" value="<?php echo $_POST[submodalidadcod]?>">
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
                        <select name="estado" id="estado" onKeyUp="return tabular(event,this)" onChange="document.form2.ocuestado.value=1;document.form2.oculto.value=6; document.form2.submit();" >
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
 				</tr>
 			</table> 
            <input type="hidden" name="oculto" id="oculto" value="1">
          	<input type="hidden"  name="ocuestado" id="ocuestado" value="<?php echo $_POST[ocuestado]?>">
          	<input type="hidden" name="agregadet"value="0" >
         	<input type="hidden" name="contdet" id="contdet" value="<?php echo $_POST[contdet]?>">
            <input type="hidden" name="elimina" id="elimina"  value="<?php echo $_POST[elimina]?>">
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
							unset($_POST[esfijo][$posi]);	
							unset($_POST[mbloqueo][$posi]);	 		 		 		 
							$_POST[manex]= array_values($_POST[manex]); 
							$_POST[mestad]= array_values($_POST[mestad]); 
							$_POST[mobliga]= array_values($_POST[mobliga]); 
							$_POST[esfijo]=array_values($_POST[esfijo]); 
							$_POST[mbloqueo]= array_values($_POST[mbloqueo]);
							$_POST[elimina]='';		
							$_POST[oculto]='1';	 
						 }	 
						$iter='saludo1';
						$iter2='saludo2';
						for ($x=0;$x<count($_POST[mestad]);$x++)
						{		
							$sqlr="SELECT nombre,fase FROM contraanexos WHERE id=".$_POST[manex][$x];
							$resp=mysql_query($sqlr,$linkbd);
							$row=mysql_fetch_row($resp);
							$nomanex=$row[0];
							if ($row[1]==1){$fase="Precontractual";}
							else if($row[1]==2){$fase="Contractual";}
							else{$fase="Postcontractual";}
							if ($_POST[mbloqueo][$x]=='S'){$beliminar="<a href='#'><img src='imagenes/candado.png' style='width:18px' title='Bloqueado'></a>";}
							else{$beliminar="<a href='#' onclick='eliminar($x)'><img src='imagenes/del.png' style='width:16px' title='Eliminar'></a>";}
							echo "
							<tr class='$iter' >
								<td  style='width:6%'><input class='inpnovisibles'  name='manex[]' value='".$_POST[manex][$x]."' type='text' readonly ></td>
								<td style='width:60%'><input class='inpnovisibles' name='manex2[]' value='".$nomanex." (".$fase.")' type='text' style='width:100%;' readonly></td>
								<td style='width:6%'><input class='inpnovisibles' name='mestad[]' value='".$_POST[mestad][$x]."' type='text'  readonly></td>
								<td style='width:6%'><input class='inpnovisibles' name='mobliga[]' value='".$_POST[mobliga][$x]."' type='text' readonly></td>
								<td  align=\"middle\" >$beliminar</td>
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
					$sqlr="DELETE * FROM contramodalidadanexos WHERE idmodalidad=".$_POST[modalidadcod]." AND idpadremod=".$_POST[submodalidadcod];
					$resp = mysql_query($sqlr,$linkbd);
					$row =mysql_fetch_row($resp);
					for ($x=0;$x<count($_POST[mestad]);$x++)
					{
						$sqlr2="SELECT fase FROM contraanexos WHERE id=".$_POST[manex][$x];
						$res2=mysql_query($sqlr2,$linkbd);
						$row2=mysql_fetch_row($res2);
						$sqlr="insert into contramodalidadanexos (idmodalidad,idpadremod,idanexo,obligatorio,estado,fase) values ('$_POST[modalidadcod]','$_POST[submodalidadcod]','".$_POST[manex][$x]."','".$_POST[mobliga][$x]."','".$_POST[mestad][$x]."','".$row2[0]."') ";	
						mysql_query($sqlr,$linkbd);
					}
					echo"<script>despliegamodalm('visible','3','Se Modificaron los Datos Básicos de Contrato con Exito');</script>";
					
				}
 			?>
 		</form>       
	</body>
</html>