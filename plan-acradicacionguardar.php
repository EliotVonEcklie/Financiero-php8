<?php //V 1000 12/12/16 ?> 
<?php 
	require"comun.inc";
	require"funciones.inc";
	$linkbd=conectar_bd();
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
?>
<?php 
	function modificar_acentos($cadena) {$no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","Ñ","–");
	$permitidas= array ("&aacute;","&eacute;","&iacute;","&oacute;","&uacute;","&Aacute;","&Eacute;","&Iacute;","&Oacute;","&Uacute;","&ntilde;","&Ntilde;","-");$texto = str_replace($no_permitidas, $permitidas ,$cadena);return $texto;}
	function modificar_acentosjs($cadena) {$no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","Ñ","–");
	$permitidas= array ("\\xe1","\\xe9","\\xed","\\xf3","\\xfa;","\\xc1","\\xc9","\\xcd","\\xd3","\\xda","\\xf1","\\xd1","-");$texto = str_replace($no_permitidas, $permitidas ,$cadena);return $texto;}
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
        <link rel="shortcut icon" href="favicon.ico"/>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type='text/javascript' src='funcioneshf.js'></script>
        <script>
			function despliegamodal(_valor){parent.document.getElementById("bgventanamodal").style.visibility=_valor;}
			function despliegamodal2(_valor){parent.document.getElementById("bgventanamodal2").style.visibility=_valor;}
			function buscater(e)
				{if (document.formguardar.tercero.value!=""){document.formguardar.bt.value='1';document.formguardar.submit();} }
			function buscares(e)
				{if (document.formguardar.responsable.value!=""){document.formguardar.bres.value='1';document.formguardar.submit();}}
			function numradicado(d)
			{
				var diab=d.getDate();
				var semb=d.getDay();
				var mesb=d.getMonth()+1;
				var anob=d.getFullYear();
				if (mesb <10) mesb="0"+mesb;
				return(anob+""+mesb+""+diab);
			}
			function elimina_adjunto(iddel)
			{
				if (confirm("¿Seguro de Eliminar esta Archivo Adjunto?"))
				{
					document.formguardar.ocudelad.value="1";
					document.formguardar.refrest.value="1";
					document.formguardar.iddelad.value=iddel;
					document.formguardar.submit();
				}
			}
			function agresponsable()
			{
				if(document.formguardar.nresponsable.value!="")
				{
					document.getElementById('ban01').value=parseInt(document.getElementById('ban01').value)+1;
					document.formguardar.agresp.value=1;
					document.formguardar.submit();
				}
			 	else {parent.despliegamodalm('visible','2','Falta informaci\xf3n del Responsable para poder Agregar');}	
			}
			function eliresponsable(variable)
			{
				if (confirm("Esta Seguro de Eliminar"))
			 	{
					document.getElementById('ban01').value=parseInt(document.getElementById('ban01').value)-1;
					document.formguardar.eliminaml.value=variable;
					document.getElementById('eliminaml').value=variable;
					document.formguardar.submit();
				}
			}
		</script>
        <?php
			function eliminarDir($carpeta)
			{
				$carpeta2="informacion/documentosradicados/".$carpeta;
				foreach(glob($carpeta2 . "/*") as $archivos_carpeta)
				{
					//echo $archivos_carpeta;
					if (is_dir($archivos_carpeta)){eliminarDir($archivos_carpeta);}
					else{unlink($archivos_carpeta);}
				}
				rmdir($carpeta2);
			}
		?>
	</head>
	<body>
		<form name="formguardar" id="formguardar" method="post" enctype="multipart/form-data"  >
        <?php 
			//***** busca tercero
			if($_POST[bt]=='1')
			{
				$nresul=buscatercero2($_POST[tercero]);
			  	if($nresul[0]!='')
			   	{
					$_POST[ntercero]=$nresul[0];
					if ($nresul[1]==""){$_POST[ndirecc]="Sin Dirección de Correo";}
					else{$_POST[ndirecc]=$nresul[1];}
					if ($nresul[2]==""){$_POST[ntelefono]="Sin Numero Telefónico";}
					else{$_POST[ntelefono]=$nresul[2];}
					if ($nresul[3]==""){$_POST[ncelular]="Sin Numero Celular";}
					else{$_POST[ncelular]=$nresul[3];}
					if ($nresul[4]==""){$_POST[ncorreoe]="Sin Correo Electrónico";}
					else{$_POST[ncorreoe]=$nresul[4];}
				}
			 	else
			 	{$_POST[ntercero]="";}
			}
			//***** busca responsable
			if($_POST[bres]=='1')
			{
				$nresul=buscaresponsable($_POST[responsable]);
			  	if($nresul!='')
			   	{$_POST[nresponsable]=$nresul;}
			 	else
			 	{$_POST[nresponsable]="";}
			}
			//*****carga inicial busca numero radicado
 				if($_POST[oculto]=="")
				{
					$sqlr="SELECT max(numeror) FROM planacradicacion  ";
					$resp = mysql_query($sqlr,$linkbd);
					$_POST[ban01]=0;
					while ($row =mysql_fetch_row($resp)){$mx=$row[0];}
					$mx++;
					$ndig=strlen($mx);
					for($xx=1;$xx < (8-$ndig);$xx++)
					{$_POST[nradicado]=$_POST[nradicado]."0";}
					$_POST[nradicado]=$_POST[nradicado].($mx);
					$_POST[codbarras]=$_POST[nradicado];
					$sqlr="DELETE FROM planacarchivosadt  ";
					$resp = mysql_query($sqlr,$linkbd);
					$ruta="informacion/documentosradicados/".$_POST[nradicado];
					if(!file_exists($ruta))
					{mkdir ($ruta);}//Se ha creado el directorio en la ruta
					else {eliminarDir($_POST[nradicado]);mkdir ($ruta);}// " ya existe el directorio en la ruta ";
					$_POST[rutaad]=$ruta."/";
				}
				//*****************************************************************
				if ($_POST[agresp]=='1')
				{
					$_POST[docres][]=$_POST[responsable];	
					$_POST[nomdes][]=$_POST[nresponsable];	
					$_POST[responsable]="";
					$_POST[nresponsable]="";
					$_POST[agregamlg]='0';
				}
				//*****************************************************************
				if ($_POST[eliminaml]!='')
				{ 
					$posi=$_POST[eliminaml];
					unset($_POST[docres][$posi]);
					unset($_POST[nomdes][$posi]);
					$_POST[docres]= array_values($_POST[docres]); 
					$_POST[nomdes]= array_values($_POST[nomdes]); 
				}
				//*****************************************************************
		?>
        <input type="hidden" name="ban01" id="ban01" value="<?php echo $_POST[ban01];?>" >
        	<table class="inicio">
            	<tr>
                	<td height="25" colspan="10" class="titulos" >:.Radicar Documento </td>
                	<td width="5%" class="cerrar" ><a href="#" onClick="parent.cerrargeneral()">Cerrar</a></td>
                </tr>
                <tr>
					<td width="13%" class="saludo1" style="width:9%" >:&middot; N&deg; Radicaci&oacute;n:</td>
                    <td style="width:12%">
                    	<input id="nradicado" name="nradicado" type="text" style="width:100%" value="<?php echo $_POST[nradicado]?>" readonly>
                    	<input id="codbarras" name="codbarras" type="hidden"value="<?php echo $_POST[codbarras]?>">
                    </td>
                    <td class="saludo1" style="width:6%">:&middot; Fecha:</td>
					<td style="width:10.5%">
                        <input id="fecharad" name="fecharad" type="text"  style="width:100%" readonly>
                        <input id="fecharado" name="fecharado" type="hidden">
                    </td>
                    <script>
						//document.getElementById('nradicado').value=numradicado(new Date());
						//document.getElementById("fecharad").value=fecha_corta(new Date());
						document.getElementById("fecharad").value=fecha_corta2(new Date());
						document.getElementById("fecharado").value=fecha_sinformato(new Date());
					</script>
                	<td class="saludo1" style="width:5%" >:&middot; Hora:</td>
                	<td style="width:9%">
                    	<input id="horarad" name="horarad" type="text"  style="width:100%" readonly>
                   		<input id="horarado" name="horarado" type="hidden">
                   	</td>
                   	<script>window.onload = function(){setInterval(hora_corta, 1000);}</script>
                   	<td class="saludo1" style="width:10%" >:&middot;Tipo Radicaci&oacute;n:</td>
					<td style="width:15%" >
                   		<select id="tradicacion" name="tradicacion" class="elementosmensaje" style="width:100%"  onKeyUp="return tabular(event,this)" onChange="var traddiv=this.value.split('-'); sumadiashabiles(document.formguardar.fechares,document.formguardar.fechareso,traddiv[1]);">
                    		<option onChange="" value="" >Seleccione....</option>
                            <?php	
								$sqlr="SELECT * FROM dominios WHERE nombre_dominio='TIPO_RADICACION_AC' ORDER BY  valor_inicial ASC  ";
								$res=mysql_query($sqlr,$linkbd);
								while ($rowEmp = mysql_fetch_assoc($res)) 
				    			{
									echo "<option value= ".$rowEmp['valor_inicial']."-".$rowEmp['valor_final'];
									$i=$rowEmp['valor_inicial']."-".$rowEmp['valor_final'];
					 				if($i==$_POST[tradicacion])
			 						{
						 				echo "  SELECTED";
						 				$_POST[octradicacion]=$rowEmp['descripcion_valor'];
						 			}
					  				echo ">".$rowEmp['valor_inicial']." - ".modificar_acentos($rowEmp['descripcion_valor'])."</option>"; 	 
								}		
              				?> 
                           
                        </select>
                        <input id="octradicacion" name="octradicacion" type="hidden" value="<?php echo $_POST[octradicacion]?>">
     				</td>
					<td class="saludo1" style="width:8%" >:&middot; Fecha L&iacute;mite:</td>
          			<td colspan="2">
                    	<input id="fechares" name="fechares" type="text"  style="width:100%" value="<?php echo $_POST[fechares]?>" readonly>
                   		<input id="fechareso" name="fechareso" type="hidden" value="<?php echo $_POST[fechareso]?>">
             		</td>
      			</tr>
               	<tr>
					<td class="saludo1" >:&middot; Tercero:</td>
             		<td>
               			<input id="tercero" type="text" name="tercero" style="width:85%" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo $_POST[tercero]?>" onClick="document.getElementById('tercero').focus();document.getElementById('tercero').select();">
                        <input type="hidden" value="0" name="bt">
            <a href="#" onClick="despliegamodal('visible');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>
                   	</td>
                   	<td colspan="3">
                     	<input name="ntercero" type="text" value="<?php echo $_POST[ntercero]?>" style="width:100%" readonly>
               		</td>
					<td class="saludo1" >:&middot; Descripci&oacute;n:</td>
                 	<td colspan="5"><input id="raddescri" name="raddescri" type="text" style="width:100%" value="<?php echo $_POST[raddescri]?>"required="required"></td>
            	</tr>
              	<tr>
                  	<td class="saludo1">:&middot; Respuesta :</td>
                    <td class="saludo2" colspan="3">
                    	<label>
                        	<input type="checkbox"  name="trescrito" <?php if(isset($_REQUEST['trescrito'])){echo "checked";} ?>  value="escr" id="trescrito" />Escrita
                       	</label>&nbsp;&nbsp;&nbsp;&nbsp;
                       
                       	<label>
                       		<input type="checkbox" name="trtelefono" <?php if(isset($_REQUEST['trtelefono'])){echo "checked";} ?> value="tele" id="trtelefono" />Telef&oacute;nica
                       	</label>&nbsp;&nbsp; &nbsp;&nbsp;
                       	<label>
                       		<input type="checkbox" name="trcorreo" <?php if(isset($_REQUEST['trcorreo'])){echo "checked";} ?> value="corr" id="trcorreo" />Correo Electr&oacute;nico
                 		</label>
                   	</td>
                   	<td class="saludo1" colspan="2" >:&middot; Responsable Respuesta:</td>
                   	<td>
                    	<input id="responsable" type="text" name="responsable" style="width:100%" onKeyUp="return tabular(event,this)" onBlur="buscares(event)" value="<?php echo $_POST[responsable]?>" onClick="document.getElementById('responsable').focus();document.getElementById('responsable').select();">
                       	<input type="hidden" value="0" name="bres">
                   	</td>
                   	<td colspan="3">
                    	<a href="#" onClick="despliegamodal2('visible');" style="width:25%"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>
                    	<input type="text" name="nresponsable" id="nresponsable" value="<?php echo $_POST[nresponsable]?>" style=" width:95% " readonly>
             		</td>
                    <td><input name="agregamar" type="button" value="  Agregar  " onClick="agresponsable()"></td>
				</tr>
             	<tr>
                	<td class="saludo1" >:&middot; Tel&eacute;fono:</td>
                	<td><input type="text" name="ntelefono" id="ntelefono" style="width:100%" value="<?php echo $_POST[ntelefono]?>" readonly></td>
                    <td class="saludo1" >:&middot; Celular:</td>
                    <td><input type="text" name="ncelular" id="ncelular" style="width:100%" value="<?php echo $_POST[ncelular]?>" readonly></td>
                    <td class="saludo1" colspan="2">:&middot; Direcci&oacute;n Correspondencia:</td>
                    <td colspan="5"><input type="text" name="ndirecc" id="ndirecc" style="width:100%" value="<?php echo $_POST[ndirecc]?>" readonly></td>
             	</tr>   
           		<tr>
                	<td class="saludo1" >:&middot; Email:</td>
                  	<td colspan="3"><input type="text" name="ncorreoe" id="ncorreoe" style="width:100%" value="<?php echo $_POST[ncorreoe]?>" readonly></td>
                 	<td class="saludo1" colspan="2" >:&middot;Adjuntar Documento:</td>
               		<td>
                    	<input type="file" name="archivoesc" id="archivoesc" style="width:100%" value="<?php echo $_POST[archivoesc]?>" onChange="document.formguardar.refrest.value='1';document.formguardar.submit();">
                    </td>
                    	<td class="saludo1">:&middot;N&#176; Folios Radicados:</td>
                    <td colspan="2">
                    	<input type="text" id="contarch" name="contarch" value="<?php echo $_POST[contarch]?>"> 
                        <input type="hidden" name="archivonom" id="archivonom"  value="<?php echo $_POST[archivonom]?>" readonly>
                        <input name="iddelad" type="hidden" id="iddelad" value="<?php echo $_POST[iddelad]?>">
                        <input name="ocudelad" type="hidden" id="ocudelad" value="<?php echo $_POST[oculdel]?>">
                        <input name="refrest" type="hidden" id="refrest" value="<?php echo $_POST[refrest]?>">
                       <input name="rutaad" type="hidden" id="rutaad" value="<?php echo $_POST[rutaad]?>">
                    </td>
  				</tr>
			</table> 
            <section class="subpantallap" style="height:65%; width:50%; display:block; float:left; overflow-x:hidden;"  >
            	<table class="inicio">
                	<tr>
                    	<td colspan="4" class="titulos">Responsables</td>
                 	</tr>
                    <tr>
                   	 	<td class="titulos2" style="width:20%;">Documento</td>
                    	<td class="titulos2" style="width:70%;">Nombre</td>
                        <td class="titulos2" style="width:10%;">Eliminar</td>
                   	</tr>
                     <?php
						$iter="saludo1";
						$iter2="saludo2";
						$tam=count($_POST[docres]);   
						for($x=0;$x<$tam;$x++)
						{
							echo "
								<tr class='$iter'>
									<td><input class='inpnovisibles type='text' name='docres[]' value='".$_POST[docres][$x]."' style='width:100%;' readonly></td>
									<td><input class='inpnovisibles type='text' name='nomdes[]' value='".$_POST[nomdes][$x]."' style='width:100%;' readonly></td>
									<td><a href='#' onclick='eliresponsable($x)'><img src='imagenes/del.png'></a></td>
								</tr>";   
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux;
						}
					?>
				</table>
            </section>
            <section class="subpantallap" style="height:65%; width:49.5%;display:block; float:left; overflow-x:hidden;" >
			<table class="inicio" >
           		<tr>
                	<td colspan="4" class="titulos">Archivos Adjuntos</td>
              	</tr>                  
				<tr>
                	<td class="titulos2" style="width:80%;">Nombre del Archivo</td>
                    <td class="titulos2" style="width:10%;">Tipo</td>
                    <td class="titulos2" style="width:10%;">Eliminar</td>
            	</tr>
                 <?php
					if ($_POST[ocudelad]=="1")
						{
							$sqlr="select nomarchivo FROM planacarchivosadt where idarchivoad=".$_POST[iddelad];
							$res=mysql_query($sqlr,$linkbd);
							$rowEmp = mysql_fetch_assoc($res);
							$nomarchivo=$rowEmp['nomarchivo'];
							$sqlr="DELETE FROM planacarchivosadt where idarchivoad=".$_POST[iddelad];
							$res=mysql_query($sqlr,$linkbd);  
							$_POST['ocudelad']="";
							unlink($_POST[rutaad].$nomarchivo);
						}
					if (is_uploaded_file($_FILES['archivoesc']['tmp_name'])) 
						{	
							?><script>
								document.getElementById('archivonom').value='<?php $nomarchivo= $_FILES['archivoesc']['name'];$tipoarch= $_FILES['archivoesc']['type'];echo $nomarchivo;?>';
                            </script><?php 
							copy($_FILES['archivoesc']['tmp_name'], $_POST[rutaad].$_FILES['archivoesc']['name'].'');
							
							$sqlr = "INSERT INTO planacarchivosadt(idarchivoad,idradicacion,nomarchivo,tipoarchivo) VALUES (NULL, $_POST[nradicado],'".$nomarchivo."', '".$tipoarch."')";
									$resp = mysql_query($sqlr,$linkbd);
						}
					if ($_POST[refrest]=="1")
								{
									$sqlr="SELECT * FROM planacarchivosadt ORDER BY nomarchivo ASC";
								    $res=mysql_query($sqlr,$linkbd);
                                    $iter='saludo1';
                                    $iter2='saludo2';
                                    while ($rowEmp = mysql_fetch_assoc($res)) 
                                    {
                                         echo '<tr class="'.$iter.'" >
                               			 <td>'.$rowEmp['nomarchivo'].'</td>
										 <td>'.$rowEmp['tipoarchivo'].'</td>
                                       	 <td><a href="#"><img src="imagenes/del.png" onClick=elimina_adjunto('.$rowEmp["idarchivoad"].'); " /></a></td>
										 </tr>';
                                        $aux=$iter;
                                        $iter=$iter2;
                                        $iter2=$aux;
                               	 	}
									$sqlr="SELECT idarchivoad FROM planacarchivosadt";
								    $res=mysql_query($sqlr,$linkbd);
									$narchiad=mysql_num_rows($res);
									$_POST[refrest]="";
								}
				?>
            </table>
            </section>
            <input type='hidden' name='eliminaml' id='eliminaml'>
           	<input type="hidden" name="agresp" id="agresp" value="0">
       		<input type="hidden" id="oculto" name="oculto" value="<?php echo $_POST[oculto]?>"><input type="hidden" id="oculto2" name="oculto2" value="<?php echo $_POST[oculto2]?>">
           		<?php
					if($_POST[oculto]==""){?><script>document.getElementById('oculto').value=3;</script><?php }
					
					if ($_POST[oculto]=="1")
					{	
						if (($_POST[tercero]!="")&&($_POST[tradicacion])&&($_POST[raddescri]!="")&&($_POST[responsable]!="")&&($_POST[contarch]!=""))
						{
							if(isset($_REQUEST['trescrito'])){$cbescrito=1;}else{$cbescrito=0;}
							if(isset($_REQUEST['trtelefono'])){$cbtelefono=1;}else{$cbtelefono=0;}
							if(isset($_REQUEST['trcorreo'])){$cbcorreo=1;}else{$cbcorreo=0;}
							$nomarchivoad=$_POST[codbarras].".zip";
							$cadtrad=explode("-",$_POST[tradicacion]);
							$sqlr = "INSERT INTO planacradicacion (numeror,codigobarras,fechar,horar,usuarior,tipor,fechalimite,idtercero, descripcionr,tescrito,ttelefono,temail,idresponsable,telefonot,celulart,direcciont,emailt,documento,numeromod,nfolios,narchivosad,estado) VALUES ('$_POST[nradicado]','$_POST[codbarras]','$_POST[fecharado]','$_POST[horarado]','$_SESSION[cedulausu]','$cadtrad[0]', '$_POST[fechareso]','$_POST[tercero]','$_POST[raddescri]','$cbescrito','$cbtelefono','$cbcorreo','$_POST[responsable]','$_POST[ntelefono]', '$_POST[ncelular]','$_POST[ndirecc]','$_POST[ncorreoe]','$nomarchivoad',0,'$_POST[contarch]','$narchiad','A')";
							$res=(mysql_query($sqlr,$linkbd));
							$sqlr = "INSERT INTO planacradicacionhistory (idmodificacion,fechamodificacion,horamodificacion, usuariomodificacion, numeror,codigobarras,fechar,horar,usuarior,tipor,fechalimite,idtercero,descripcionr, tescrito,ttelefono,temail, idresponsable,telefonot,celulart, direcciont,emailt,documento,numeromod,nfolios,narchivosad,estado) VALUES (NULL,NULL,NULL,NULL, '$_POST[nradicado]','$_POST[codbarras]','$_POST[fecharado]','$_POST[horarado]','$_SESSION[cedulausu]','$cadtrad[0]','$_POST[fechareso]', '$_POST[tercero]','$_POST[raddescri]','$cbescrito','$cbtelefono','$cbcorreo','$_POST[responsable]','$_POST[ntelefono]','$_POST[ncelular]', '$_POST[ndirecc]','$_POST[ncorreoe]','$nomarchivoad',0,'$_POST[contarch]', '$narchiad','A')";
							$res=(mysql_query($sqlr,$linkbd));
							$sqlr = "INSERT INTO planacresponsables (codigo,codradicacion,fechasig, fechares,usuarioasig,usuariocon, estado,archivos,respuesta) VALUES (NULL,'$_POST[codbarras]','$_POST[fecharado]','','$_SESSION[cedulausu]','$_POST[responsable]','A','','')";
							$res=(mysql_query($sqlr,$linkbd));
							echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado el Documento con Exito <img src='imagenes\confirm.png'></center></td></tr></table>";
							?><script>parent.guardar_des();</script><?php
						}
						else
						{
							echo "<script languaje='javascript'>alert('Se deben ingresar la informacion en todos los campos');</script>";	
						}

						comprimir($_POST[rutaad],($_POST[codbarras].".zip"));
						copy(($_POST[codbarras].".zip"),("informacion/documentosradicados/".$_POST[codbarras].".zip"));
						//unlink($_POST[codbarras].".zip");
						eliminarDir($_POST[codbarras]);
						$sqlr="insert into planacarchivosad  select * from planacarchivosadt";
						$res=(mysql_query($sqlr,$linkbd));
						$_POST[oculto]="2";
					}
				?>
        </form>
	</body>
</html>