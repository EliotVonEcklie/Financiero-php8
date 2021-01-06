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
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
        <meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9" />
        <title>::SPID-Planeaci&oacute;n Estrat&eacute;gica</title>
        <link rel="shortcut icon" href="favicon.ico"/>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <link href="css/tabs.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
        <script>
			function despliegamodal2(_valor){document.getElementById("bgventanamodal2").style.visibility=_valor;}
			function busquedajs()
			{if (document.form2.responsable.value!=""){document.form2.busquedas.value="1";document.form2.submit();}}
			function agregardocumento()
			{
				if(document.form2.nomarch.value!="")
				{
					document.getElementById('banmlg').value=parseInt(document.getElementById('banmlg').value)+1;
					document.form2.agregamlg.value=1;
					document.form2.submit();
				}
			 	else {despliegamodalm('visible','2','Falta informaci\xf3n para poder Agregar');}	
			}
			function eliminarml(variable)
			{
				document.form2.idelimina.value=variable;
				despliegamodalm('visible','4','Seguro de Eliminar esta Archivo Adjunto','1');
			}
			function agresponsable()
			{
				if(document.form2.nresponsable.value!="")
				{
					document.getElementById('ban01').value=parseInt(document.getElementById('ban01').value)+1;
					document.form2.agresp.value=1;
					document.form2.submit();
				}
			 	else {parent.despliegamodalm('visible','2','Falta informaci\xf3n del Responsable para poder Agregar');}	
				
			}
			function eliresponsable(variable)
			{
				document.form2.idelimina.value=variable;
				despliegamodalm('visible','4','Seguro de Eliminar este Responsable','2');
			}
			function cambiolecesc(id,estado)
			{
				document.form2.idelimina.value=id;
				document.form2.camestado.value=estado;
				if(estado=="E")
					{despliegamodalm('visible','4','Seguro de cambiar el estado a "Solo Lectura"','4');}
				else
					{despliegamodalm('visible','4','Seguro de cambiar el estado a "Responder la Solicitud"','4');}
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
			function guardar()
    		{
				
				if(document.getElementById('numrespon').value!="")
				{
					if (document.getElementById('textresp').value!="" && document.getElementById('textresp').value!="Escribe aquí la una Respuesta a la solicitud")
						{despliegamodalm('visible','4','Seguro desea Redirigir la Solicitud','4');}
					else
						{despliegamodalm('visible','2','Falta agregar respuesta a la solicitud');}
				}
				else if(document.getElementById('numconsulta').value!=0)
				{despliegamodalm('visible','4','Seguro desea Consultar Informaci\xf3n a otro','5');}
				else
				{
					var comproceso=document.getElementById('proceso').value;
					switch(comproceso)
					{
						case "C":			
							if (document.getElementById('textresp').value!="" && document.getElementById('textresp').value!="Escribe aquí la una Respuesta a la solicitud")
							{despliegamodalm('visible','4','Seguro desea terminar de responder la solicitud','3');}
							else
							{despliegamodalm('visible','2','Falta agregar respuesta a la solicitud');}
							break;
						case "A":
							{despliegamodalm('visible','2','Falta agregar un responsable para redirigir');}
							break;
						case "CA":
							{despliegamodalm('visible','2','Falta agregar un responsable consultar');}
							break;
						case "L":
							if(document.getElementById('ban01').value!=0)
							{despliegamodalm('visible','4','Seguro desea Compartir esta informaci\xf3n','6');}
							else
							{despliegamodalm('visible','2','Falta agregar un responsable para poder Compartir informaci\xf3n');}
							break;
					}
				}
			}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					
					case "1"://Eliminar Archivo Adjunto de la lista
						document.getElementById('banmlg').value=parseInt(document.getElementById('banmlg').value)-1;
						document.form2.iddelad.value=document.form2.idelimina.value;
						document.form2.submit();
						break;
					case "2"://Eliminar Responsable de la lista
						document.getElementById('ban01').value=parseInt(document.getElementById('ban01').value)-1;
						document.form2.eliminaml.value=document.form2.idelimina.value;
						document.form2.submit();
						break;
					case "3"://Contertar la solicitud
						document.form2.oculto.value="1";
						document.form2.submit();
						break;
					case "4"://Redirigir solisitud
						document.form2.oculto.value="2";
						document.form2.submit();
						break;
					case "5"://Consultar solisitud
						document.form2.oculto.value="3";
						document.form2.submit();
						break;
				}
			}
			function funcionmensaje()
			{document.location.href = "http://servidor/financiero/plan-actareasbusca.php";}
			function mredirigir(act)
			{
				switch(act)
				{
					case "C":
						document.getElementById('resocul').value="hidden";
						break;
					default:
						document.getElementById('resocul').value="visible";
				}
				document.getElementById('responsable').value="";
				document.getElementById('nresponsable').value="";
				document.form2.submit();
			}
			function borrarinicio()
			{
				if(document.getElementById('textresp').value=="Escribe aquí la una Respuesta a la solicitud")
					{document.getElementById('textresp').value="";}
			}
		</script>
		<?php
			function eliminarDir($carpeta)
			{
				$carpeta2="informacion/documentosradicados/".$carpeta;
				foreach(glob($carpeta2 . "/*") as $archivos_carpeta)
				{
					if (is_dir($archivos_carpeta)){eliminarDir($archivos_carpeta);}
					else{unlink($archivos_carpeta);}
				}
				rmdir($carpeta2);
			}
			function cargarchivos($nomcarpeta)
			{	
				$nomarccomp="I".$nomcarpeta.".zip";
				$ruta="informacion/documentosradicados/responsables/I".$nomcarpeta;
				copy(($ruta.'.zip'),($nomarccomp));
				$zip = new ZipArchive;
				if ($zip->open($nomarccomp) === TRUE){$zip->extractTo(getcwd()."/");$zip->close();} 	
				unlink($nomarccomp);
			}
		?>
 	</head>
    <body>
    	<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("plan");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("plan");?></tr>
            <tr>
      			<td colspan="3" class="cinta"><a href="#" class="mgbt"><img src="imagenes/add2.png"/></a><a href="#" onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a><a href="plan-actareasbusca.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" border="0"/></a><a href="#" onClick="mypop=window.open('plan-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a></td>
   			</tr>
    	</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
		<form name="form2" id="form2" method="post" enctype="multipart/form-data">
        	<?php       		//*****************************************************************
 				if($_POST[oculto]=="")
                {
					$_POST[oculid]=$_GET[idradicado];
					$_POST[oculres]=$_GET[idresponsable];
					$_POST[tipoes]=$_GET[tipoe];
					$_POST[resocul]="hidden";
					$_POST[numrespon]="";
					$ruta="informacion/documentosradicados/responsables/I".$_POST[oculres];
					if(!file_exists($ruta))
					{mkdir ($ruta);}//Se ha creado el directorio en la ruta para los Responsables
					else {eliminarDir("responsables/I".$_POST[oculres]);mkdir ($ruta);}// " ya existe el directorio en la ruta ";
					$_POST[rutaad]=$ruta."/";
					$sqlr="SELECT codigobarras,narchivosad FROM planacradicacion WHERE numeror = '".$_POST[oculid]."'";
					$row = mysql_fetch_row(mysql_query($sqlr,$linkbd));
					$_POST[oculrad]=$row[0];
					$_POST[mararcori]=$row[1];
					$rutara='informacion/documentosradicados/'.$_POST[oculrad];
					if(!file_exists($rutara))
					{mkdir ($rutara);}//Se ha creado el directorio en la ruta para la Radicacion
					else {eliminarDir($_POST[oculrad]);mkdir ($rutara);}// " ya existe el directorio en la ruta ";
					$_POST[rutara]=$ruta."/";
					$nomarccomp=$_POST[oculrad].'.zip';
					copy(($rutara.'.zip'),($nomarccomp));
					$zip = new ZipArchive;
					if ($zip->open($nomarccomp) === TRUE) {
						$zip->extractTo(getcwd()."/");
						$zip->close();
					} 	
					unlink($nomarccomp);
					$_POST[banmlg]=0;
					$_POST[ban01]=0;
					$_POST[tabgroup1]=1;
					$_POST[numconsulta]=0;
					$_POST[textresp]="Escribe aqu&iacute; la una Respuesta a la solicitud";
					$_POST[oculto]="0";
                }			//*****************************************************************
                switch($_POST[tabgroup1])
                {
                    case 1:
                        $check1='checked';break;
                    case 2:
                        $check2='checked';break;
                    case 3:
                        $check3='checked';break;
                    case 4:
                        $check4='checked';break;
                }
				//*****Agregar Archivo Adjunto A Lista*****************************
				if ($_POST[agregamlg]=='1')
				{
					$_POST[nomarchivo][]=$_POST[nomarch];
					$_POST[nomarch]="";	
					$_POST[agregamlg]='0';
				}
				//******Eliminar Archivo de la Lista********************************
				if ($_POST[iddelad]!='')
				{ 
					$posi=$_POST[iddelad];
					$archivodell=$_POST[rutaad].$_POST[nomarchivo][$posi];
					unlink($archivodell);
					unset($_POST[nomarchivo][$posi]);
					$_POST[nomarchivo]= array_values($_POST[nomarchivo]); 
					$_POST[iddelad]='';
				}
				//*****Agregar Reponsable en la Lista************************************
				if ($_POST[agresp]=='1')
				{
					if(in_array($_POST[responsable],$_POST[docres]))
					{echo"<script>despliegamodalm('visible','2','Ya se Asigno a este Responsable');</script>";}
					else
					{
						$_POST[docres][]=$_POST[responsable];	
						$_POST[nomdes][]=$_POST[nresponsable];
						switch($_POST[proceso])
						{
							case "A":
								if($_POST[mararcori]!=""){$_POST[mararcori2]=$_POST[mararcori];}
								$_POST[lecesc][]="A";$_POST[numrespon]=$_POST[responsable];$_POST[proceso]="CA";
								break;
							case "CA":
								$_POST[lecesc][]="CA";$_POST[numconsulta]=$_POST[numconsulta]+1; break;
							case "L":
								$_POST[lecesc][]="L";break;
						}
						$_POST[responsable]="";
						$_POST[nresponsable]="";
					}
					$_POST[agregamlg]='0';
				}
				//******Eliminar Responsable de la Lista*****************************************
				if ($_POST[eliminaml]!='')
				{ 
					$posi=$_POST[eliminaml];
					if($_POST[lecesc][$posi]=="CA"){$_POST[numconsulta]=$_POST[numconsulta]-1;}
					if($_POST[docres][$posi]==$_POST[numrespon]){$_POST[numrespon]="";$_POST[mararcori2]="";}
					unset($_POST[docres][$posi]);
					unset($_POST[nomdes][$posi]);
					unset($_POST[lecesc][$posi]);
					$_POST[docres]= array_values($_POST[docres]); 
					$_POST[nomdes]= array_values($_POST[nomdes]);
					$_POST[lecesc]= array_values($_POST[lecesc]); 
				}
				//*****modificar************************************
				if ($_POST[modestado]!='')
				{
					if($_POST[camestado]=='E'){$_POST[lecesc][$_POST[modestado]]="L";}
					else {$_POST[lecesc][$_POST[modestado]]="E";}
					$_POST[modestado]="";
				}
				//******Busqueda Por Documento****************************************
				if ($_POST[busquedas]!="")
				{
					$sqlid="SELECT codigo FROM planacresponsables WHERE codradicacion='$_POST[oculid]' AND usuariocon='$_POST[responsable]'";
					$resid=mysql_query($sqlid,$linkbd);
					if (mysql_num_rows($resid)>0)
					{
						echo"<script>despliegamodalm('visible','2','El funcionario ya tiene una actividad asignada en esta tarea');</script>";
					}	
					else
					{
						$nresul=buscaresponsable($_POST[responsable]);
						if($nresul!=''){$_POST[nresponsable]=$nresul;}
						else
						{
							$_POST[nresponsable]="";
							echo"<script>despliegamodalm('visible','2','No existe o est\xe1 vinculado un funcionario con este documento');</script>";	
						}
						$_POST[busquedas]="";	
					}
				}
			?>
            <input type="hidden" name="ban01" id="ban01" value="<?php echo $_POST[ban01];?>">
            <input type="hidden" name="banmlg" id="banmlg" value="<?php echo $_POST[banmlg];?>" >
			<div class="tabsmeci"  style="height:76.5%; width:99.6%">
                <div class="tab">
                    <input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
                    <label for="tab-1">Informaci&oacute;n</label>
                    <div class="content" style="overflow:hidden;">
                    	<div class="subpantallac5" style="height:99%; overflow-x: hidden;">	
                        	<?php
                    			$sqlr="SELECT * FROM planacradicacion WHERE numeror = '".$_POST[oculid]."'";
								$res=mysql_query($sqlr,$linkbd);
								$row = mysql_fetch_row($res);
								$sqlr2="SELECT descripcion_valor FROM dominios WHERE nombre_dominio='TIPO_TAREAS' AND valor_inicial=".$row[5];
								$res2=mysql_query($sqlr2,$linkbd);
								$row2 = mysql_fetch_row($res2);
								$trtipo=$row2[0];
								$sqlr2="SELECT usuarioasig,usuariocon,fechasig FROM planacresponsables WHERE codigo='".$_POST[oculres]."'";
								$res2=mysql_query($sqlr2,$linkbd);
								$row2 = mysql_fetch_row($res2);
								$trasig=buscaresponsable($row2[0]);
								$trcont=buscaresponsable($row2[1]);
								$trradicador=buscaresponsable($row[4]);
								$fechav=date("d-m-Y",strtotime($row[6]));
								$fechactual=date("d-m-Y");
								$tmp = explode('-',$fechav);
								$fcpv=mktime(0,0,0,$tmp[1],$tmp[0],$tmp[2]);
								$tmp = explode('-',$fechactual);
								$fcpa=mktime(0,0,0,$tmp[1],$tmp[0],$tmp[2]);
								switch($row[20])
								{
									case "C":
										{$estadodoc='<img src="imagenes/sema_verdeON.jpg" style="height:20px;"> CONTESTADO';}
										break;
									case "L":
										$sqlec="SELECT usuariocon FROM planacresponsables WHERE estado='LN' ";
										$reslec = mysql_query($sqlec,$linkbd);
										$nlec = mysql_num_rows($reslec);
										if ($nlec==0)
										{$estadodoc='<img src="imagenes/sema_verdeON.jpg" style="height:20px;"> REVISADO';}
										else
										{$estadodoc='<img src="imagenes/sema_amarilloON.jpg" style="height:20px;"> SIN LEER';}
										break;
									case "A":
										if($fcpa > $fcpv )
										{$estadodoc='<img src="imagenes/sema_rojoON.jpg" style="height:20px;"> VENCIDO';}
										else 
										{$estadodoc='<img src="imagenes/sema_amarilloON.jpg" style="height:22px;"> PENDIENTE';}
										break;
								}
								$_POST[codrad]=$row[1];
								$_POST[oculcodigo]=$row[1];
								echo'
								<table class="inicio">        
									<tr>
										<td height="25" colspan="8" class="titulos" >:.Informaci&oacute;n b&aacute;sica Documento Redicado</td>
									</tr>
									<tr>
										<td class="titulos2" style="width:9%" >C&oacute;digo</td>
										<td class="titulos2" style="width:9%">Fecha Tarea</td>
										<td class="titulos2" style="width:9%">Fecha L&iacute;mite</td>
										<td class="titulos2" style="width:20%">Tipo</td>
										<td class="titulos2" style="width:30%">Radicado por:</td>
										<td class="titulos2" style="width:20%" colspan="3">Asignado Por</td>
									 </tr>
									 <tr class="saludo1">
										<td>'.$row[1].'</td>
										<td>'.$row[2].'</td>
										<td>'.$row[6].'</td>
										<td>'.$trtipo.'</td>
										<td>'.$trradicador.'</td>
										<td colspan="3">'.$trasig.'</td>
									 </tr>
									 <tr>
										<td class="titulos2" colspan="2">Responsable</td>
										<td class="titulos2">Fecha Asignaci&oacute;n</td>
										<td class="titulos2" colspan="2">Descripci&oacute;n</td>
										<td class="titulos2" >Estado</td>
										<td class="titulos2" colspan="2" >Archivos Adjuntos</td>
									 </tr>
									 <tr class="saludo1">
										<td colspan="2">'.$trcont.'</td>
										<td >'.$row2[2].'</td>
										<td colspan="2">'.strtoupper($row[8]).'</td>
										<td>'.$estadodoc.'</td>
										<td>
											<select id="archiad" name="archiad" class="elementosmensaje" style="width:100%"  onKeyUp="return tabular(event,this)"  onChange="document.form2.submit();" >
												<option onChange="" value=""  >Seleccione....</option>';	
										$sqlr4="SELECT nomarchivo FROM planacarchivosad WHERE idradicacion='".$_POST[oculid]."' ORDER BY nomarchivo ASC ";
										$res4=mysql_query($sqlr4,$linkbd);
										while ($row4 = mysql_fetch_row($res4)) 
										{
											echo "<option  value='".$row4[0]."'";
											$i=$row4[0];
											if($i==$_POST[archiad])
											{
												echo "  SELECTED";
											}
											echo "> - ".$row4[0]." </option>"; 	 
										}		
								echo'
											</select> 
										</td>
										<td>';
										if($_POST[archiad]!="")
										{	
											echo'<a id="arcorig" href="informacion/documentosradicados/'.$_POST[oculrad].'/'.$_POST[archiad].'"  download><img src="imagenes/descargar.png" title="Descargar Archivo" ></a>';
										}
										else
										{echo'<a id="arcorig" href="#"><img src="imagenes/descargard.png" title="Sin Archivo" ></a>';}
										echo'
										</td>
									 </tr>
								</table>';
									//Historial*****************************************************************************************
								$sqlr2="SELECT * FROM planacresponsables WHERE usuarioasig='$_SESSION[cedulausu]' AND codradicacion='$_POST[oculid]' ORDER BY codigo DESC";
								$res2=mysql_query($sqlr2,$linkbd);
								$iter='zebra1';
								$iter2='zebra2';
								$iter3='saludo11';
								$ntr = mysql_num_rows($res2);
								$cont=1;
								if($ntr > 0)
								{
									echo '
									<table class="inicio">        
										<tr>
											<td class="titulos" colspan="9">:.Historial</td>
										</tr>
										<tr>
											<td class="titulos2" style="width:3%" >Item</td>
											<td class="titulos2" style="width:10%">Fecha Asignaci&oacute;n</td>
											<td class="titulos2" style="width:10%">Fecha Respuesta</td>
											<td class="titulos2" style="width:20%">Asignado Por</td>
											<td class="titulos2" style="width:20%">Contestado Por</td>
											<td class="titulos2" style="width:20%">Solicitud</td>
											<td class="titulos2" style="width:4%">Tipo</td>
											<td class="titulos2" style="width:4%">Estado</td>
											<td class="titulos2" colspan="2" >Archivos</td>
										 </tr>';
									while ($row2 = mysql_fetch_row($res2)) 
									{
										$hisasig=buscaresponsable($row2[4]);
										$hiscont=buscaresponsable($row2[5]);
										if ($cont==1){$color=$iter3;}
										else{$color=$iter;}
										$vardisable="";
										switch($row2[6])
										{
											case "A":
												$estadores='<img src="imagenes/sema_amarilloON.jpg" style="height:22px;" title="Sin Responder">';
												$imgtip='<img src="imagenes/escritura.png" style="height:20px;" title="Tarea">';
												break;
											case "CR":
												$estadores='<img src="imagenes/sema_amarilloON.jpg" style="height:22px;" title="Sin Responder">';
												$imgtip='<img src="imagenes/redirigir.png" style="height:20px;" title="Redirigir">';
												break;
											case "CA":
												$estadores='<img src="imagenes/sema_amarilloON.jpg" style="height:22px;" title="Sin Responder">';
												$imgtip='<img src="imagenes/consulta.png" style="height:22px;" title="Consulta">';
												break;
											case "CC":
												$estadores='<img src="imagenes/sema_verdeON.jpg" style="height:20px;" title="Contestada">';
												$imgtip='<img src="imagenes/consulta.png" style="height:22px;" title="Consulta">';
												break;
											case "LS":
												$estadores='<img src="imagenes/sema_verdeON.jpg" style="height:20px;" title="Revisada">';
												$vardisable="disabled";
												$imgtip='<img src="imagenes/lectura.png" style="height:20px;" title="Informativa">';
												break;
											case "LN":
												$estadores='<img src="imagenes/sema_verdeON.jpg" style="height:20px;" title="Sin Revisar">';
												$vardisable="disabled";
												$imgtip='<img src="imagenes/lectura.png" style="height:20px;" title="Informativa">';
												break;
										}
										echo '
										<tr class="'.$color.'" >
											<td >'.$cont.'</td>
											<td >'.$row2[2].'</td>
											<td>'.$row2[3].'</td>
											<td>'.strtoupper($hisasig).'</td>
											<td>'.strtoupper($hiscont).'</td>
											<td>'.$row2[8].'</td>
											<td style="text-align:center;">'.$imgtip.'</td>
											<td style="text-align:center;">'.$estadores.'</td>
											<td>
												<select id="archiad'.$row2[0].'" name="archiad'.$row2[0].'" class="elementosmensaje" style="width:100%"  onKeyUp="return tabular(event,this)"  onChange="document.form2.submit();" '.$vardisable.' >';
												$sqlr4="SELECT nomarchivo FROM planarchresponsables WHERE codresponsable=".$row2[0]." ORDER BY nomarchivo ASC ";
												$res4=mysql_query($sqlr4,$linkbd);
												if (mysql_num_rows($res4)>0)
												{
													echo '<option onChange="" value=""  >Seleccione....</option>';
													cargarchivos($row2[0]);
													while ($row4 = mysql_fetch_row($res4)) 
													{
														echo "<option  value='".$row4[0]."'";
														$i=$row4[0];
														if($i==$_POST["archiad".$row2[0]])
														{
															echo "  SELECTED";
														}
														echo "> - ".$row4[0]." </option>"; 	 
													}
												}
												else {echo '<option onChange="" value=""  >Sin Archivos</option>';}
											echo'	
												</select>	
											</td>
											<td>';										
											if(($_POST["archiad".$row2[0]])!="")
											{
												echo'<a href="informacion/documentosradicados/responsables/I'.$row2[0].'/'.$_POST["archiad".$row2[0]].'" download><img src="imagenes/descargar.png" title="Descargar Archivo" ></a>';
											}
											else
											{echo'<a href="#"><img src="imagenes/descargard.png" title="Sin Archivo" ></a>';}
											echo'</td>
										</tr>';
										$aux=$iter;
										$iter=$iter2;
										$iter2=$aux;
										$cont++;
									}
									echo '</table>';
								}
							?>
						</div>
               	 	</div>
				</div> 
                <div class="tab">
                    <input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?> >
                    <label for="tab-2">Responder</label>
                    <div class="content" style="overflow:hidden;">
                    	<div class="subpantallac5" style="height:99%; overflow: hidden;">
                        	<table class="inicio" >
                                <tr><td colspan="15" class="titulos">Responder a Terea Asignada</td></tr>
                                <tr>
                                    <td class="saludo1"  style="width:10%; height:120px;">Responder:</td>
                                    <td style="width:90%; height:120px;" colspan="14"><textarea id="textresp" name="textresp" style="width:100%; height:100%; resize:none"onClick="borrarinicio();"><?php echo $_POST[textresp] ?></textarea></td>
                                </tr>
                                <tr>
                                	<td class="saludo1">:&middot;Documentos:</td>
               						<td colspan="3" style=" width:25%;"><input type="text" name="nomarch" id="nomarch"  style="width:100%" value="<?php echo $_POST[nomarch]?>" readonly></td>
                                    <td>
                                        <div class='upload'> 
                                            <input type="file" name="plantillaad" onChange="document.form2.submit();" />
                                            <img src='imagenes/attach.png'  title='Cargar Documento'  /> 
                                        </div> 
                                    </td>
                                    <td style="width:6%"><input name="agregadoc" type="button" value="  Adjuntar " onClick="agregardocumento()"></td>
                                    <td style="width:9%">
                                        <select id="proceso" name="proceso" class="elementosmensaje" onChange="mredirigir(this.value);">
                                            <option value="C" <?php if($_POST[proceso]=="C"){echo "SELECTED ";}if($_POST[numrespon]!=""){echo "hidden";}elseif($_POST[numconsulta]!=0){echo "hidden";}?>>Contestar</option>
                                            <option value="A" <?php if($_POST[proceso]=="A"){echo "SELECTED ";}if ($_POST[tipoes]=="CA"){echo "hidden";}elseif($_POST[numrespon]!=""){echo "hidden";}elseif($_POST[numconsulta]!=0){echo "hidden";}?>>Redirigir</option>
                                            <option value="CA" <?php if($_POST[proceso]=="CA"){echo "SELECTED ";}if($_POST[numrespon]!=""){echo "hidden";}?>>Consultar</option>
                                            <option value="L" <?php if($_POST[proceso]=="L"){echo "SELECTED ";}?>>Mostrar</option>
                                        </select>
                                    </td>
                                        <?php  
											if($_POST[resocul]!='hidden')
											{echo '<td class="saludo1" style="width:7%">:&middot; Redirigir:</td>';} 
											else
											{echo '<td style="width:7%"></td>';} 
										?> 
                                        <td style="width:10%">
                                        	<div style="visibility:<?php echo $_POST[resocul];?>">
                                                <input id="responsable" type="text" name="responsable" style="width:100%" onKeyPress="return solonumeros(event);" onBlur="busquedajs();" value="<?php echo $_POST[responsable]?>" onClick="document.getElementById('responsable').focus();document.getElementById('responsable').select();">
                                                <input type="hidden" value="0" name="bres">
                                            </div>
                                        </td>
                                        <td colspan="4">
                                        	<div style=" visibility:<?php echo $_POST[resocul];?>">
                                                <a href="#" onClick="despliegamodal2('visible','2');" style="width:25%"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>
                                                <input type="text" name="nresponsable" id="nresponsable" value="<?php echo $_POST[nresponsable]?>" style=" width:90% " readonly>
                                            </div>
                                        </td>
                                        <td style="width:7%">
                 							<div style=" visibility:<?php echo $_POST[resocul];?>">
                                        		<input name="agregamar" type="button" value="  Agregar  " onClick="agresponsable()">
                                        	</div>
                                        </td>
                                </tr>
                            </table>
                           	<section class="subpantallap" style="height:59%; margin-right:5; width:48%;display:block; float:left; overflow-x:hidden;" >
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
                                        $iter="saludo1";
                                        $iter2="saludo2";
                                        $tam=count($_POST[nomarchivo]);   
                                        for($x=0;$x<$tam;$x++)
                                        {
                                            echo "
                                                <tr class='$iter'>
                                                    <td><input class='inpnovisibles type='text' name='nomarchivo[]' value='".$_POST[nomarchivo][$x]."' style='width:100%;' readonly></td>
                                                    <td style='text-align:center;'>".traeico($_POST[nomarchivo][$x])."</td>
                                                    <td><a href='#' onclick='eliminarml($x)'><img src='imagenes/del.png'></a></td>
                                                </tr>";   
                                            $aux=$iter;
                                            $iter=$iter2;
                                            $iter2=$aux;
                                        }
                                    ?>
                                </table>
                            </section>
                            <section class="subpantallap" style="height:59%; width:48%;display:block; float:left; overflow-x:hidden;" >	
                                <table class="inicio">
                                    <tr>
                                        <td colspan="4" class="titulos">Redirigir</td>
                                    </tr>
                                    <tr>
                                        <td class="titulos2" style="width:15%;">Documento</td>
                                        <td class="titulos2" style="width:67%;">Nombre</td>
                                        <td class="titulos2" style="width:8%;">Tipo</td>
                                        <td class="titulos2" style="width:10%;">Eliminar</td>
                                    </tr>
                                    <?php
                                        $iter="saludo1";
                                        $iter2="saludo2";
                                        $tam=count($_POST[docres]);   
                                        for($x=0;$x<$tam;$x++)
                                        {
											switch($_POST[lecesc][$x])
											{
												case "A":
													$imglecesc="src='imagenes/redirigir.png' title='Redirigir'";
													break;
												case "CA":
													$imglecesc="src='imagenes/escritura.png' title='Consultar'";
													break;
												case "L":
													$imglecesc="src='imagenes/lectura.png' title='Solo Lectura'";
													break;
											}
                                            echo "
                                                <tr class='$iter'>
                                                    <td><input class='inpnovisibles type='text' name='docres[]' value='".$_POST[docres][$x]."' style='width:100%;' readonly></td>
                                                    <td><input class='inpnovisibles type='text' name='nomdes[]' value='".$_POST[nomdes][$x]."' style='width:100%;' readonly></td>
                                                    <td style='text-align:center;'>
                                                        <input type='hidden' name='lecesc[]' value='".$_POST[lecesc][$x]."'>
                                                        <img $imglecesc style='width:20px' onclick='cambiolecesc($x,\"".$_POST[lecesc][$x]."\")'/>
                                                    </td>
                                                    <td style='text-align:center;'><a href='#' onclick='eliresponsable($x)'><img src='imagenes/del.png'/></a></td>
                                                </tr>";   
                                            $aux=$iter;
                                            $iter=$iter2;
                                            $iter2=$aux;
                                        }
                                    ?>
                                </table>
                            </section>	
                        </div>
                    </div>
            	</div>
			</div>
            <input type="hidden" name="mararcori2" id="mararcori2" value="<?php echo $_POST[mararcori2];?>">
            <input type="hidden" name="mararcori" id="mararcori" value="<?php echo $_POST[mararcori];?>">
            <input type="hidden" name="oculto" id="oculto" value="<?php echo $_POST[oculto];?>">
            <input type="hidden" name="numrespon" id="numrespon" value="<?php echo $_POST[numrespon];?>">
            <input type="hidden" name="numconsulta" id="numconsulta" value="<?php echo $_POST[numconsulta];?>">
            <input type="hidden" name="oculcodigo" id="oculcodigo" value="<?php echo $_POST[oculcodigo]?>">
            <input type="hidden" name="oculid" id="oculid" value="<?php echo $_POST[oculid]?>">
            <input type="hidden" name="oculres" id="oculres" value="<?php echo $_POST[oculres]?>">
            <input type="hidden" name="oculrad" id="oculrad" value="<?php echo $_POST[oculrad];?>">
            <input type="hidden" name="resocul" id="resocul" value="<?php echo $_POST[resocul];?>">
            <input type="hidden" name="codrad" id="codrad" value="<?php echo $_POST[codrad];?>">
            <input type="hidden" name="rutaad" id="rutaad" value="<?php echo $_POST[rutaad]?>">
            <input type="hidden" name="rutara" id="rutara" value="<?php echo $_POST[rutara]?>">
            <input type="hidden" name="iddelad" id="iddelad" value="<?php echo $_POST[iddelad]?>">
            <input type="hidden" name="archivonom" id="archivonom"  value="<?php echo $_POST[archivonom]?>">
            <input type="hidden" name="idelimina" id="idelimina" value="<?php echo $_POST[idelimina]?>">
            <input type="hidden" name="busquedas" id="busquedas" value="<?php echo $_POST[busquedas];?>">
            <input type="hidden" name="camestado" id="camestado" value="<?php echo $_POST[camestado]?>">
            <input type="hidden" name="modestado" id="modestado" value="<?php echo $_POST[modestado]?>">
             <input type="hidden" name="tipoes" id="tipoes" value="<?php echo $_POST[tipoes]?>">
            <input type="hidden" name="agresp" id="agresp" value="0">
            <input type='hidden' name='eliminaml' id='eliminaml'>
            <input type="hidden" name="agregamlg" value="0">
            <input type="hidden" name="ocudelad"  id="ocudelad" value="1">

            <?php
				//archivos
				if (is_uploaded_file($_FILES['plantillaad']['tmp_name'])) 
				{
					echo"<script>document.getElementById('nomarch').value='".$_FILES['plantillaad']['name']."';</script>";
					copy($_FILES['plantillaad']['tmp_name'], $_POST[rutaad].$_FILES['plantillaad']['name']);
				}
				//guardar ********************************************************************************
 				if($_POST[oculto]=="1")
				{
					//guardar la respuesta********************************************************************************
					$fechares=date("Y-m-d");
					$contex=preg_replace("/\n/","&lt;br/&gt;",$_POST["textresp"]);
					if ($_POST[tipoes]=="A")
					{
						$sqlr="UPDATE planacradicacion SET estado='C' WHERE numeror='$_POST[oculid]'"; 
						$res=(mysql_query($sqlr,$linkbd));
					
						$sqlr="UPDATE planacresponsables SET estado='C', fechares='$fechares', respuesta='$contex' WHERE codigo='$_POST[oculres]'"; 
					}
					elseif ($_POST[tipoes]=="RA")
					{
						$sqlr="UPDATE planacradicacion SET estado='C' WHERE numeror='$_POST[oculid]'"; 
						$res=(mysql_query($sqlr,$linkbd));
						$sqlr="UPDATE planacresponsables SET estado='RC', fechares='$fechares', respuesta='$contex' WHERE codigo='$_POST[oculres]'";
					}
					else
					{$sqlr="UPDATE planacresponsables SET estado='CC', fechares='$fechares', respuesta='$contex' WHERE codigo='$_POST[oculres]'";}
					$res=(mysql_query($sqlr,$linkbd));
					//guarda Los archivos y crear .zip***********************************************************************
					$archcomp="I".$_POST[oculres].".zip";
					comprimir($_POST[rutaad],$archcomp);
					copy($archcomp,("informacion/documentosradicados/".$archcomp));
					eliminarDir("I".$_POST[oculres]);
					unlink($archcomp);
					$yconta=count($_POST[nomarchivo]);
					for($y=0;$y<$yconta;$y++)
					{
						$sqliy="SELECT MAX(codigo) FROM planarchresponsables ";
						$rowiy=mysql_fetch_row(mysql_query($sqliy,$linkbd));
						$numid=$rowiy[0]+1;
						$sqlr = "INSERT INTO planarchresponsables (codigo,codresponsable,nomarchivo) VALUES ('$numid','$_POST[oculres]', '".$_POST[nomarchivo][$y]."')";
						mysql_query($sqlr,$linkbd);
					}
					//Guardar Usuaris Mirar*********************************************************************************
					$fecharado=date("Y-m-d");
					$xconta=count($_POST[docres]);
					for($x=0;$x<$xconta;$x++)
					{	
						$sqlid="SELECT MAX(codigo) FROM planacresponsables ";
						$rowid=mysql_fetch_row(mysql_query($sqlid,$linkbd));
						$numid=$rowid[0]+1;
						$sqlr = "INSERT INTO planacresponsables (codigo,codradicacion,fechasig, fechares,usuarioasig,usuariocon,estado, archivos,respuesta) VALUES ('$numid','$_POST[oculid]','$fecharado','','$_SESSION[cedulausu]','".$_POST[docres][$x]."','LN','','')";
						mysql_query($sqlr,$linkbd);
					}
					$_POST[oculto]=="0";
					echo"<script>despliegamodalm('visible','1','Se Contesto con Exito La Solicitud');</script>";
				}
				//Redirigir********************************************************************************
 				if($_POST[oculto]=="2")
				{
					//guardar la respuesta********************************************************************************
					$fechares=date("Y-m-d");
					$contex=preg_replace("/\n/","&lt;br/&gt;",$_POST["textresp"]);
					$sqlr="UPDATE planacresponsables SET estado='RC', fechares='$fechares', respuesta='$contex' WHERE codigo='$_POST[oculres]'";
					$res=(mysql_query($sqlr,$linkbd));
					$fecharado=date("Y-m-d");
					$xconta=count($_POST[docres]);
					for($x=0;$x<$xconta;$x++)
					{	
						if($_POST[lecesc][$x]=="L"){$vallecesc="LN";}
						else{$vallecesc="RA";}
						$sqlid="SELECT MAX(codigo) FROM planacresponsables ";
						$rowid=mysql_fetch_row(mysql_query($sqlid,$linkbd));
						$numid=$rowid[0]+1;
						$sqlr = "INSERT INTO planacresponsables (codigo,codradicacion,fechasig,fechares,usuarioasig,usuariocon, estado,archivos,respuesta) VALUES ('$numid','$_POST[oculid]','$fecharado','','$_SESSION[cedulausu]','".$_POST[docres][$x]."','$vallecesc','','')";
						mysql_query($sqlr,$linkbd);
					}
					$sqlr="UPDATE planacradicacion SET archivos='$numid', narchivosad='$_POST[mararcori2]' WHERE numeror='$_POST[oculid]'"; 
					$res=(mysql_query($sqlr,$linkbd));
					$_POST[oculto]=="0";	
					echo"<script>despliegamodalm('visible','1','Se Redirigi\xf3 con Exito La Solicitud');</script>";
				}
				//Consultar********************************************************************************
 				if($_POST[oculto]=="3")
				{
					$fecharado=date("Y-m-d");
					$xconta=count($_POST[docres]);
					for($x=0;$x<$xconta;$x++)
					{	
						if($_POST[lecesc][$x]=="L"){$vallecesc="LN";}
						else{$vallecesc="CA";}
						$sqlid="SELECT MAX(codigo) FROM planacresponsables ";
						$rowid=mysql_fetch_row(mysql_query($sqlid,$linkbd));
						$numid=$rowid[0]+1;
						$sqlr = "INSERT INTO planacresponsables (codigo,codradicacion,fechasig,fechares,usuarioasig,usuariocon, estado,archivos,respuesta) VALUES ('$numid','$_POST[oculid]','$fecharado','','$_SESSION[cedulausu]','".$_POST[docres][$x]."','$vallecesc','','')";
						mysql_query($sqlr,$linkbd);
					}
					$_POST[oculto]=="0";
					echo"<script>despliegamodalm('visible','1','Se envi\xf3 la Consulta con Exito');</script>";
				}
				//*****************************************************************
			?>
        </form>
		<div id="bgventanamodal2">
			<div id="ventanamodal2">
            	<a href="javascript:despliegamodal2('hidden'); " style="position: absolute; left: 810px; top: 5px; z-index: 100;"><img src="imagenes/exit.png" alt="cerrar" width=22 height=22>Cerrar</a>
                <IFRAME  src="plan-acresponsablest.php<?php echo "?id=".$_POST[oculid]."&pro=".$_POST[proceso]; ?>" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                </IFRAME>
            </div>
        </div>
	</body>
</html>