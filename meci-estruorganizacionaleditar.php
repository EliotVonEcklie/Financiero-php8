
<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
	$id=$_GET['id'];
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<?php require "head.php"; ?>
		<title>:: Spid - Calidad</title>
		<script>
			function despliegamodalm(_valor,_tip,mensa)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventanam').src="";}
				else
				{
					switch(_tip)
					{
						case "1":
							document.getElementById('ventanam').src="ventana-mensaje1.php?titulos=Se Modifico la Informaci\xf3n del Marco Legal con Exito";break;
						case "2":
							document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
						case "3":
							document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;	
					}
				}
			}
			function funcionmensaje()
			{document.form2.ocumlg.value="";document.form2.submit();}
			function borrarinicio()
			{
				var pesact=document.form2.tabgroup1.value;
				switch(pesact)
				{
					case "1":
						if(document.getElementById('vision').value=="Escribe aqu� la Descripci� de la Visi�n")
				(document.getElementById('vision').value="");
						break;
					case "2":
						if(document.getElementById('mision').value=="Escribe aqu� la Descripci� de la Visi�n")
				(document.getElementById('mision').value="");
						break;
				}
			}
			function guardar()
			{
				var pesact=document.form2.tabgroup1.value;
				var varver='N';
				var nomgua='';
				switch(pesact)
				{
					case "1":
						if((document.getElementById('vision').value!="")  && (document.getElementById('fecvis').value!=""))
						{varver='S'; nomgua='la Visi\xf3n';}
						break;
					case "2":
						if((document.getElementById('mision').value!="") && (document.getElementById('fecmis').value!=""))
						{varver='S'; nomgua='la Misi\xf3n';}
						break;
					case "3":
						if((document.getElementById('objgen').value!="") && (document.getElementById('fecobj').value!="")&&(document.getElementById('banobj').value!=0))
						{varver='S';nomgua='los Objetivos'}
						break;
					case "4":
						if(document.getElementById('banmlg').value!=0){varver='S'; nomgua='El Marco Legal'}
						break;
					case "5":
						if((document.getElementById('policalidad').value!="") && (document.getElementById('fecpcl').value!=""))
						{varver='S'; nomgua='la Politica de Calidad';}
						break;
				}
				if(varver=='S'){if (confirm("Esta Seguro de Guardar "+nomgua)){document.form2.oculto.value="1";document.form2.submit();}}
				else{despliegamodalm('visible','2','Falta informaci\xf3n para poder Guardar');}
			}
			
			function agregardetalle()
			{
				if(document.form2.objesp.value!="")
				{
					document.getElementById('banobj').value=parseInt(document.getElementById('banobj').value)+1;
					document.form2.agregadet.value=1;
					document.form2.submit();
				}
			 	else {despliegamodalm('visible','2','Falta informaci\xf3n para poder Agregar Objetivo');}
			}
			function eliminar(variable)
			{
				if (confirm("Esta Seguro de Eliminar"))
			 	{
					document.getElementById('banobj').value=parseInt(document.getElementById('banobj').value)-1;
					document.form2.elimina.value=variable;
					document.getElementById('elimina').value=variable;
					document.form2.submit();
				}
			}
			
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
			function iratras(){
				var id=document.getElementById('codigo').value;
				var clase=document.getElementById('oculcl').value;
				if( clase == 'MCL'){
					var clas = document.getElementById('oculcl').value;
				}
				location.href="meci-estruorganizacionalbusca.php?id="+id+"&clase="+clas;
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
				  	<a onClick="guardar()" class="tooltip bottom mgbt"><img src="imagenes/guarda.png"/><span class="tiptext">Guardar</span></a>
				  	<a onclick="location.href='meci-estruorganizacionalbusca.php'" class="tooltip bottom mgbt"><img src="imagenes/busca.png" /><span class="tiptext">Buscar</span></a>
				  	<a class="tooltip bottom mgbt" onClick="mypop=window.open('meci-principal.php','','');mypop.focus();"><img src="imagenes/nv.png"><span class="tiptext">Nueva Ventana</span></a>
					<a onClick="mypop=window.open('<?php echo $url2; ?>','','');mypop.focus();" class="tooltip bottom mgbt"><img src="imagenes/duplicar_pantalla.png"><span class="tiptext">Duplicar pestaña</span></a>
					<a onClick="iratras()" class="tooltip bottom mgbt"><img src="imagenes/iratras.png"><span class="tiptext">Atr&aacute;s</span></a>
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
							$_POST[fecvis]=date("d-m-Y", strtotime($rowv[3]));
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
							$_POST[fecmis]=date("d-m-Y", strtotime($rowm[3]));
							$_POST[mision]=str_replace("&lt;br/&gt;","\n",$rowm[4]);
							$_POST[idmisi]=$_POST[oculid];
							break;
						case "PCL":
							$_POST[tabgroup1]=5;
							$bloqueo1="disabled";
							$bloqueo2="disabled";
							$bloqueo3="disabled";
							$bloqueo4="disabled";
							$sqlv="SELECT * FROM meciestructuraorg WHERE id='".$_POST[oculid]."'";
							$rowv=mysql_fetch_row(mysql_query($sqlv,$linkbd));
							$divpro=explode(".",$rowv[2]);
							$_POST[verpca]=$divpro[0];
							$_POST[verpcb]=$divpro[1];	
							$_POST[fecpcl]=date("d-m-Y", strtotime($rowv[3]));
							$_POST[policalidad]=str_replace("&lt;br/&gt;","\n",$rowv[4]);
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
							$_POST[fecobj]=date("d-m-Y", strtotime($rowo[3]));
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
							$rutaad="informacion/marco_legal/temp/";
							$sqlml="SELECT * FROM meciestructuraorg_marcolegal WHERE id='".$_POST[oculid]."'";
							$rowml=mysql_fetch_row(mysql_query($sqlml,$linkbd));
							$_POST[normativa]=$rowml[2];
							$_POST[fecmls]=date("d-m-Y", strtotime($rowml[3]));
							$_POST[desmar]=$rowml[4];;
							$_POST[nomarch]=$rowml[5];
							$_POST[idobje]=$_POST[oculid];
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
				if ($_POST[elimina]!='')
				{ 
					$posi=$_POST[elimina];
					unset($_POST[dobjesp][$posi]);
					$_POST[dobjesp]= array_values($_POST[dobjesp]); 
				}
				//*****************************************************************
				if ($_POST[agregadet]=='1')
				{
					$_POST[dobjesp][]=$_POST[objesp];	
					$_POST[objesp]="";	
					$_POST[agregadet]='0';
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
								<td colspan="4" ><textarea name="vision" id="vision" rows="20" style="width:100%;" onClick="borrarinicio();"><?php echo $_POST[vision];?></textarea></td>  
							</tr>
							 <tr>
								<td class="saludo1" style="width:5%;">Versi&oacute;n:</td>
								<td style="width:10%;">
									<input type="text"  name="vervia" id="vervia" value="<?php echo $_POST[vervia];?>" style="width:30%; text-align:right;" onKeyPress="javascript:return solonumeros(event)" readonly>.<input type="text"  name="vervib" id="vervib" value="<?php echo $_POST[vervib];?>" style="width:30%; text-align:right;" onKeyPress="javascript:return solonumeros(event)" readonly>
								</td>
								<td class="saludo1" style="width:5%;">Fecha:</td>
								<td><input type="text" name="fecvis" value="<?php echo $_POST[fecvis]?> "maxlength="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971541" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" style="width:80%;">&nbsp;<img src="imagenes/calendario04.png" onClick="displayCalendarFor('fc_1198971541');" title="Calendario" class="icobut"/></td>
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
								<td colspan="4" ><textarea name="mision" id="mision" rows="20" style="width:100%;" onClick="borrarinicio();"><?php echo $_POST[mision];?></textarea></td>  
							</tr>
							 <tr>
								<td class="saludo1" style="width:5%;">Versi&oacute;n:</td>
								<td style="width:10%;">
									<input type="text"  name="vermia" id="vermia" value="<?php echo $_POST[vermia];?>" style="width:30%; text-align:right;" onKeyPress="javascript:return solonumeros(event)" readonly>.<input type="text"  name="vermib" id="vermib" value="<?php echo $_POST[vermib];?>" style="width:30%; text-align:right;" onKeyPress="javascript:return solonumeros(event)" readonly>
								</td>
								<td class="saludo1" style="width:5%;">Fecha:</td>
								<td><input type="text" name="fecmis" value="<?php echo $_POST[fecmis]?> "maxlength="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971542" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" style="width:80%;">&nbsp;<img src="imagenes/calendario04.png" onClick="displayCalendarFor('fc_1198971542');" title="Calendario" class="icobut"/></td>
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
								<td colspan="4" ><textarea name="policalidad" id="policalidad" rows="20" style="width:100%;" onClick="borrarinicio();"><?php echo $_POST[policalidad];?></textarea></td>
							</tr>
							 <tr>
								<td class="saludo1" style="width:5%;">Versi&oacute;n:</td>
								<td style="width:10%;">
									<input type="text"  name="verpca" id="verpca" value="<?php echo $_POST[verpca];?>" style="width:30%; text-align:right;" onKeyPress="javascript:return solonumeros(event)">.<input type="text"  name="verpcb" id="verpcb" value="<?php echo $_POST[verpcb];?>" style="width:30%; text-align:right;" onKeyPress="javascript:return solonumeros(event)">
								</td>
								<td class="saludo1" style="width:5%;">Fecha:</td>
								<td><input type="text" name="fecpcl" value="<?php echo $_POST[fecpcl]?> "maxlength="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971543" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" style="width:80%;">&nbsp;<img src="imagenes/calendario04.png" onClick="displayCalendarFor('fc_1198971543');" title="Calendario" class="icobut"/></td>
								<td></td>
							</tr>
						</table>
					</div>
				</div>
				<div class="tab">
					<input type="radio" id="tab-3" name="tabgroup1" value="3" <?php echo $check3;?> <?php echo $bloqueo3;?>>
					<label for="tab-3">Objetivos</label>
					<div class="content" style="overflow:hidden;">
						<table class="inicio">
							<tr>
								<td class="titulos" colspan="5" width="100%">Objetivos</td>
								<td class="boton02" onclick="location.href='meci-principal.php'">Cerrar</td>
							</tr>
							<tr>
								<td class="saludo1" style="width:12%;">Objetivo General:</td>
								<td colspan="4"><input type="text" name="objgen" id="objgen" value="<?php echo $_POST[objgen];?>" style="width:100%;"></td>
							</tr>
							<tr>
								<td class="saludo1" >Versi&oacute;n:</td>
								<td style=" width:10%;">
									<input type="text"  name="veroba" id="veroba" value="<?php echo $_POST[veroba];?>" style="width:30%; text-align:right;" onKeyPress="javascript:return solonumeros(event)" readonly>.<input type="text"  name="verobb" id="verobb" value="<?php echo $_POST[verobb];?>" style="width:30%; text-align:right;" onKeyPress="javascript:return solonumeros(event)" readonly>
								</td>
								<td class="saludo1" style="width:5%;">Fecha:</td>
								<td><input type="text" name="fecobj" value="<?php echo $_POST[fecobj]?> "maxlength="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971544" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" style="width:80%;">&nbsp;<img src="imagenes/calendario04.png" onClick="displayCalendarFor('fc_1198971544');" title="Calendario" class="icobut"/></td>
								<td></td>
							</tr>
							<tr>
								<td class="saludo1">Objetivos Espec&iacute;ficos:</td>
								<td colspan="3" style="width:72%">
								 	<input type="text" name="objesp" id="objesp" value="<?php echo $_POST[objesp];?>" style="width:100%">
								</td>
								<td style="width:5%">
									<input name="agregaobj" type="button" value="  Agregar Objetivo " onClick="agregardetalle()">
							   </td>
							</tr>
						</table>
						<div class="subpantallac5" style="overflow:hidden-x;">
							<table class="inicio">
								<tr>
									<td class="titulos" style="width:6%;">Item</td>
									<td class="titulos" style="width:90%;">Objetivo Espec&iacute;fico</td>
									<td class="titulos" style="width:4%;"><img src='imagenes/del.png'></td>
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
												<td><a href='#' onclick='eliminar($x)'><img src='imagenes/del.png'></a></td>
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
						<table class="inicio ancho" >
							<tr>
								<td class="titulos" colspan="6" width="100%">Marco Legal</td>
								 <td class="boton02" onclick="location.href='meci-principal.php'">Cerrar</td>
							</tr>
							<tr>
								<input type="hidden" value="<?php echo $_GET[id]?>" name="codigo" id="codigo">
								<td class="saludo1" style="width:10%;">Clase Normativa:</td>
								<td style="width:15%;">
									<select name="normativa" id="normativa" style="width:100%;" >
										<?php
											$sqlr="SELECT * FROM mecivariables WHERE clase='NML' AND estado='S' ORDER BY id ASC";
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
								<td colspan="3">
									<input type="text" name="desmar" id="desmar" value="<?php echo $_POST[desmar];?>" style="width:100%">
								</td>
							</tr>
							 <tr>
								<td class="saludo1" style="width:5%;">Fecha:</td>
								<td><input type="text" name="fecmls" value="<?php echo $_POST[fecmls]?> "maxlength="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971540" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" style="width:80%;">&nbsp;<img src="imagenes/calendario04.png" onClick="displayCalendarFor('fc_1198971540');" title="Calendario" class="icobut"/></td>                                
								<td style="width:5%"></td>
							</tr>
						</table>
					</div>
				</div>
			</div>  
			<?php  
				//archivos
				if (is_uploaded_file($_FILES['plantillaad']['tmp_name'])) 
				{
					$rutaad="informacion/marco_legal/temp/";
					?><script>document.getElementById('nomarch').value='<?php echo $_FILES['plantillaad']['name'];?>';</script><?php
					copy($_FILES['plantillaad']['tmp_name'], $rutaad.$_FILES['plantillaad']['name']);
				}
				//********guardar
				if($_POST[oculto]=="1")
				{
					switch($_POST[tabgroup1])
					{
						case 1:
							$numid=$_POST[idvisi];
							$clase="VIS";
							$version=$_POST[vervia].".".$_POST[vervib];
							$fecha=$_POST[fecvis];
							$contex=preg_replace("/\n/","&lt;br/&gt;",$_POST["vision"]);
							$clamensaje="la Visi\xf3n";
							break;
						case 2:
							$numid=$_POST[idmisi];
							$clase="MIS";
							$version=$_POST[vermia].".".$_POST[vermib];
							$fecha=$_POST[fecmis];
							$contex=preg_replace("/\n/","&lt;br/&gt;",$_POST["mision"]);
							$clamensaje="la Misi\xf3n";
							break;
						case 3:
							$sqldelobj ="DELETE FROM meciestructuraorg_objespe WHERE idobjesp='".$_POST[idobje]."'";
							mysql_query($sqldelobj,$linkbd);
							$numid=$_POST[idobje];
							$clase="OBJ";
							$contex=$_POST[objgen];
							$version=$_POST[veroba].".".$_POST[verobb];
							$fecha=$_POST[fecobj];
							for($x=0;$x<$_POST[banobj];$x++)
							{
								$sqlidobj="SELECT MAX(id) FROM meciestructuraorg_objespe ";
								$rowidobj=mysql_fetch_row(mysql_query($sqlidobj,$linkbd));
								$numidobj=$rowidobj[0]+1;
								$sqlinsobj="INSERT INTO meciestructuraorg_objespe (id,idobjesp,objetivo) VALUES ('$numidobj','$numid', '".$_POST[dobjesp][$x]."')";
								mysql_query($sqlinsobj,$linkbd);
							}
							$clamensaje="los Objetivos";
							break;
						case 4:
							
							$sqlmlg="UPDATE meciestructuraorg_marcolegal SET idnormativa='".$_POST[marcla][$x]."',fechanorma='".$_POST[marfec][$x]."',descripcion='".$_POST[mardes][$x]."',adjunto='".$_POST[maradj][$x]."'";
							mysql_query($sqlmlg,$linkbd);
							copy("informacion/marco_legal/temp/".$_POST[maradj][$x],("informacion/marco_legal/".$_POST[maradj][$x]));
							break;
						case 5:
							
							$numid=$_POST[idpcl];
							$clase="PCL";
							$version=$_POST[verpca].".".$_POST[verpcb];
							$fecha=$_POST[fecpcl];
							$contex=preg_replace("/\n/","&lt;br/&gt;",$_POST["policalidad"]);
							$clamensaje="la politica de calidad";
							break;
					}
					if ($_POST[tabgroup1]!=4)
					{
						$conmensaje="Se Modifico con exito ".$clamensaje;
						$sqln="UPDATE meciestructuraorg SET version='$version',fecha='$fecha',descripcion='$contex' WHERE id='$numid'" ;
						mysql_query($sqln,$linkbd);
						?><script>despliegamodalm('visible','3','<?php echo $conmensaje;?>');</script><?php
					}
					else {?><script>despliegamodalm('visible','1');</script><?php }
					$_POST[oculto]="0";
				}
			?>
			<input type="hidden" name="oculid" id="oculid" value="<?php echo $_POST[oculid];?>">
			<input type="hidden" name="oculcl" id="oculcl" value="<?php echo $_POST[oculcl];?>">
			<input type="hidden" name="oculto" id="oculto" value="<?php echo $_POST[oculto];?>">
			<input type="hidden" name="ocumlg" id="ocumlg" value="<?php echo $_POST[ocumlg];?>">
			<input type="hidden" name="idvisi" id="idvisi" value="<?php echo $_POST[idvisi];?>">
			<input type="hidden" name="idmisi" id="idmisi" value="<?php echo $_POST[idmisi];?>">
			<input type="hidden" name="idpcl" id="idpcl" value="<?php echo $_POST[idpcl];?>">
			<input type="hidden" name="idobje" id="idobje" value="<?php echo $_POST[idobje];?>">
			<input type="hidden" name="idmale" id="idmale" value="<?php echo $_POST[idmale];?>">
			<input type="hidden" name="agregadet" value="0">
			<input type="hidden" name="agregamlg" value="0">
			<input type='hidden' name='elimina' id='elimina'>
			<input type='hidden' name='eliminaml' id='eliminaml'>
 		</form>       
	</body>
</html>