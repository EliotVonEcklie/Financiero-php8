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
		<?php require "head.php";?>
		<title>:: Spid - Meci Calidad</title>
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
							document.getElementById('ventanam').src="ventana-mensaje1.php?titulos=Se Guardo la Informaci\xf3n del Marco Legal con Exito";break;
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
						if(document.getElementById('vision').value=="Escribe aquí la Descripción de la Visión")
						{document.getElementById('vision').value="";}
						break;
					case "2":
						if(document.getElementById('mision').value=="Escribe aquí la Descripción de la Visión")
						{document.getElementById('mision').value="";}
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
						if((document.getElementById('vision').value!="Escribe aquí la Descripción de la Visión") &&(document.getElementById('vision').value!="") && (document.getElementById('vervia').value!="") && (document.getElementById('vervib').value!="") && (document.getElementById('fecvis').value!=""))
						{varver='S'; nomgua='la Visi\xf3n';}
						break;
					case "2":
						if((document.getElementById('mision').value!="Escribe aquí la Descripción de la Misión") &&(document.getElementById('mision').value!="") && (document.getElementById('vermia').value!="") && (document.getElementById('vermib').value!="") && (document.getElementById('fecmis').value!=""))
						{varver='S'; nomgua='la Misi\xf3n';}
						break;
					case "3":
						if((document.getElementById('objgen').value!="") && (document.getElementById('veroba').value!="") && (document.getElementById('verobb').value!="") && (document.getElementById('fecobj').value!="")&&(document.getElementById('banobj').value!=0))
						{varver='S';nomgua='los Objetivos'}
						break;
					case "4":
						if(document.getElementById('banmlg').value!=0){varver='S'; nomgua='El Marco Legal'}
						break;
					case "5":
						if((document.getElementById('policalidad').value!="Escribe aquí la Descripción de la Politica de Calidad") &&(document.getElementById('policalidad').value!="") && (document.getElementById('verpca').value!="") && (document.getElementById('verpcb').value!="") && (document.getElementById('fecpcl').value!=""))
						{varver='S'; nomgua='la Politica de Calidad';}
						break;
				}
				if(varver=='S'){if (confirm("Esta Seguro de Guardar "+nomgua)){document.form2.oculto.value="1";document.form2.submit();}}
				else{despliegamodalm('visible','2','Falta informaci\xf3n para poder Guardar');}
			}
			function nuevo()
			{
				var pesact=document.form2.tabgroup1.value;
				switch(pesact)
				{
					case "1":
						if (confirm("Desea crear una nueva Visi\xf3n")){document.form2.ocuvis.value="";document.form2.submit();}
						break;
					case "2":
						if (confirm("Desea crear una nueva Misi\xf3n")){document.form2.ocumis.value="";document.form2.submit();}
						break;
					case "3":
						if (confirm("Desea crear un nuevo Objetivo")){document.form2.ocuobj.value="";document.form2.submit();}
						break;
					case "4":
						break;
				}
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
				if((document.form2.normativa.value!="")&&(document.form2.catenormativa.value!="")&&(document.form2.fecmls.value!="")&&(document.form2.desmar.value!="")&&(document.form2.nomarch.value!=""))
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
					<a onClick="nuevo();" class="tooltip bottom mgbt"><img src="imagenes/add.png" /><span class="tiptext">Nuevo</span></a>
					<a onClick="guardar()" class="tooltip bottom mgbt"><img src="imagenes/guarda.png"/><span class="tiptext">Guardar</span></a>
					<a onClick="location.href='meci-estruorganizacionalbusca.php'" class="tooltip bottom mgbt"><img src="imagenes/busca.png"/><span class="tiptext">Buscar</span></a>
					<a class="tooltip bottom mgbt" onClick="mypop=window.open('meci-principal.php','','');mypop.focus();"><img src="imagenes/nv.png"/><span class="tiptext">Nueva Ventana</span></a>
					<a onClick="mypop=window.open('<?php echo $url2; ?>','','');mypop.focus();" class="tooltip bottom mgbt"><img src="imagenes/duplicar_pantalla.png"><span class="tiptext">Duplicar pestaña</span></a>
				</td>
			</tr>
		</table>
		<div id="bgventanamodalm" class="bgventanamodalm">
			<div id="ventanamodalm" class="ventanamodalm">
				<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"></IFRAME>
			</div>
		</div>
		<form name="form2" method="post" enctype="multipart/form-data"> 
			<?php
				$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
				$linkbd=conectar_bd(); 
				if($_POST[ocuvis]=="")//version de la vision
				{
					$sqlv="SELECT version FROM meciestructuraorg WHERE clase='VIS' AND estado='S' AND id=(SELECT MAX(id) FROM meciestructuraorg WHERE clase='VIS')";
					$rowv=mysql_fetch_row(mysql_query($sqlv,$linkbd));
					if($rowv[0]==""){$convia=1;$convib=0;}
					else
					{
						$divpro=explode(".",$rowv[0]);
						$convia=$divpro[0];
						$convib=$divpro[1]+1;
					}
					$_POST[vervia]=$convia;
					$_POST[vervib]=$convib;
					$_POST[fecvis]=date("d-m-Y");
					$_POST[vision]="Escribe aqu&iacute; la Descripci&oacute;n de la Visi&oacute;n";
					$_POST[idvisi]="";
					$_POST[ocuvis]="1";
				}
				if($_POST[ocumis]=="")//version de la mision
				{
					$sqlm="SELECT version FROM meciestructuraorg WHERE clase='MIS' AND estado='S' AND id=(SELECT MAX(id) FROM meciestructuraorg WHERE clase='MIS')";
					$rowm=mysql_fetch_row(mysql_query($sqlm,$linkbd));
					if($rowm[0]==""){$conmia=1;$conmib=0;}
					else
					{
						$divpro=explode(".",$rowm[0]);
						$conmia=$divpro[0];
						$conmib=$divpro[1]+1;		
					}
					$_POST[vermia]=$conmia;
					$_POST[vermib]=$conmib;
					$_POST[fecmis]=date("d-m-Y");
					$_POST[mision]="Escribe aqu&iacute; la Descripci&oacute;n de la Visi&oacute;n";
					$_POST[idmisi]="";
					$_POST[ocumis]="1";
				}
				if($_POST[ocupcl]=="")//version de lapolitica de calidad
				{
					$sqlm="SELECT version FROM meciestructuraorg WHERE clase='PCL' AND estado='S' AND id=(SELECT MAX(id) FROM meciestructuraorg WHERE clase='PCL')";
					$rowm=mysql_fetch_row(mysql_query($sqlm,$linkbd));
					if($rowm[0]==""){$conmia=1;$conmib=0;}
					else
					{
						$divpro=explode(".",$rowm[0]);
						$conmia=$divpro[0];
						$conmib=$divpro[1]+1;
					}
					$_POST[verpca]=$conmia;
					$_POST[verpcb]=$conmib;
					$_POST[fecpcl]=date("d-m-Y");
					$_POST[policalidad]="Escribe aqu&iacute; la Descripci&oacute;n de la Politica de Calidad";
					$_POST[idpcl]="";
					$_POST[ocupcl]="1";
				}
				if($_POST[ocuobj]=="")//version de los objetivos
				{
					$sqlo="SELECT version FROM meciestructuraorg WHERE clase='OBJ' AND estado='S' AND id=(SELECT MAX(id) FROM meciestructuraorg WHERE clase='OBJ')";
					$rowo=mysql_fetch_row(mysql_query($sqlo,$linkbd));
					if($rowo[0]==""){$conoba=1;$conobb=0;}
					else
					{
						$divpro=explode(".",$rowo[0]);
						$conoba=$divpro[0];
						$conobb=$divpro[1]+1;
					}
					$_POST[veroba]=$conoba;
					$_POST[verobb]=$conobb;
					$_POST[fecobj]=date("d-m-Y");
					if($_POST[banobj]!="" && $_POST[banobj]!=0)
					{ 
						$xx=count($_POST[dobjesp]);
						for($posi=0;$posi<$xx;$posi++)
						{
							unset($_POST[dobjesp][0]);
							$_POST[dobjesp]= array_values($_POST[dobjesp]);  
						}
					}
					$_POST[objgen]="";
					$_POST[banobj]=0;
					$_POST[idobje]="";
					$_POST[ocuobj]="1";
				}
				if($_POST[ocumlg]=="")//marco legal
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
							unset($_POST[marcate][0]);
							unset($_POST[marfec][0]);
							unset($_POST[mardes][0]);
							unset($_POST[maradj][0]);
							$_POST[marcla]= array_values($_POST[marcla]); 
							$_POST[marcate]= array_values($_POST[marcate]); 
							$_POST[marfec]= array_values($_POST[marfec]); 
							$_POST[mardes]= array_values($_POST[mardes]); 
							$_POST[maradj]= array_values($_POST[maradj]);
						}
					}
					$_POST[banmlg]=0;
					$_POST[ocumlg]="1";
				}
				if($_POST[oculto]=="")
				{
					$_POST[tabgroup1]=1;
					$_POST[oculto]="0";
					$_POST[fecmls]=date("d-m-Y"); 
				}
				switch($_POST[tabgroup1])
				{
					case 1:	$check1='checked';break;
					case 2:	$check2='checked';break;
					case 3:	$check3='checked';break;
					case 4:	$check4='checked';break;
					case 5:	$check5='checked';break;
				}
				if($_POST[elimina]!='')
				{
					$posi=$_POST[elimina];
					unset($_POST[dobjesp][$posi]);
					$_POST[dobjesp]= array_values($_POST[dobjesp]); 
				}
				if($_POST[eliminaml]!='')
				{
					$posi=$_POST[eliminaml];
					unset($_POST[marcla][$posi]);
					unset($_POST[marcate][$posi]);
					unset($_POST[marfec][$posi]);
					unset($_POST[mardes][$posi]);
					unset($_POST[maradj][$posi]);
					$_POST[marcla]= array_values($_POST[marcla]); 
					$_POST[marcate]= array_values($_POST[marcate]);
					$_POST[marfec]= array_values($_POST[marfec]); 
					$_POST[mardes]= array_values($_POST[mardes]); 
					$_POST[maradj]= array_values($_POST[maradj]); 
				}
				//*****************************************************************
				if ($_POST[agregadet]=='1')
				{
					$_POST[dobjesp][]=$_POST[objesp];
					$_POST[objesp]="";	
					$_POST[agregadet]='0';
				}
				//*****************************************************************
				if ($_POST[agregamlg]=='1')
				{
					$_POST[marcla][]=$_POST[normativa];
					$_POST[marcate][]=$_POST[catenormativa];	
					$_POST[marfec][]=$_POST[fecmls];	
					$_POST[mardes][]=$_POST[desmar];	
					$_POST[maradj][]=$_POST[nomarch];	
					//$_POST[normativa]="";
					$_POST[fecmls]=date("d-m-Y"); 
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
					<input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
					<label for="tab-1">Visi&oacute;n</label>
					<div class="content" style="overflow:hidden;">
						<table class="inicio ancho" >
							<tr>
								<td class="titulos" colspan="6" style="width:100%">Visi&oacute;n</td>
								<td class="boton02" onClick="location.href='meci-principal.php'">Cerrar</td>
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
									<input type="text"  name="vervia" id="vervia" value="<?php echo $_POST[vervia];?>" style="width:30%; text-align:right;" onKeyPress="javascript:return solonumeros(event)">.<input type="text"  name="vervib" id="vervib" value="<?php echo $_POST[vervib];?>" style="width:30%; text-align:right;" onKeyPress="javascript:return solonumeros(event)">
								</td>
								<td class="saludo1" style="width:5%;">Fecha:</td>
								<td><input type="text" name="fecvis" value="<?php echo $_POST[fecvis]?> "maxlength="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971541" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" style="width: 25%;height: 30px;">&nbsp;<img src="imagenes/calendario04.png" onClick="displayCalendarFor('fc_1198971541');" title="Calendario" class="icobut"/></td>
								<td></td>
							</tr>
						</table>
					</div>
				</div> 
				<div class="tab">
					<input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?> >
					<label for="tab-2">Misi&oacute;n</label>
					<div class="content" style="overflow:hidden;">
						<table class="inicio ancho" >
							<tr>
								<td class="titulos" colspan="5" style="width:100%">Misi&oacute;n</td>
								<td class="boton02" onClick="location.href='meci-principal.php'">Cerrar</td>
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
									<input type="text"  name="vermia" id="vermia" value="<?php echo $_POST[vermia];?>" style="width:30%; text-align:right;" onKeyPress="javascript:return solonumeros(event)">.<input type="text"  name="vermib" id="vermib" value="<?php echo $_POST[vermib];?>" style="width:30%; text-align:right;" onKeyPress="javascript:return solonumeros(event)">
								</td>
								<td class="saludo1" style="width:5%;">Fecha:</td>
								<td><input type="text" name="fecmis" value="<?php echo $_POST[fecmis]?> "maxlength="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971542" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" style="width: 25%;height: 30px;">&nbsp;<img src="imagenes/calendario04.png" onClick="displayCalendarFor('fc_1198971542');" title="Calendario" class="icobut"/></td>
								<td></td>
							</tr>
						</table>
					</div>
				</div>
				<div class="tab">
					<input type="radio" id="tab-5" name="tabgroup1" value="5" <?php echo $check5;?> >
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
								<td><input type="text" name="fecpcl" value="<?php echo $_POST[fecpcl]?> "maxlength="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971543" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" style="width:25%;height: 30px;">&nbsp;<img src="imagenes/calendario04.png" onClick="displayCalendarFor('fc_1198971543');" title="Calendario" class="icobut"/></td>
								<td></td>
							</tr>
						</table>
					</div>
				</div>
				<div class="tab">
					<input type="radio" id="tab-3" name="tabgroup1" value="3" <?php echo $check3;?> >
					<label for="tab-3">Objetivos</label>
					<div class="content" style="overflow:hidden;">
						<table class="inicio ancho">
							<tr>
								<td class="titulos" colspan="5">Objetivos</td>
								<td class="boton02" onClick="location.href='meci-principal.php'">Cerrar</td>
							</tr>
							<tr>
								<td class="saludo1" style="width:12%;">Objetivo General:</td>
								<td colspan="4"><input type="text" name="objgen" id="objgen" value="<?php echo $_POST[objgen];?>" style="width:100%;"></td>
							</tr>
							<tr>
								<td class="saludo1" >Versi&oacute;n:</td>
								<td style=" width:10%;">
									<input type="text"  name="veroba" id="veroba" value="<?php echo $_POST[veroba];?>" style="width:30%; text-align:right;" onKeyPress="javascript:return solonumeros(event)">.<input type="text"  name="verobb" id="verobb" value="<?php echo $_POST[verobb];?>" style="width:30%; text-align:right;" onKeyPress="javascript:return solonumeros(event)">
								</td>
								<td class="saludo1" style="width:5%;">Fecha:</td>
								<td><input type="text" name="fecobj" value="<?php echo $_POST[fecobj]?> "maxlength="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971544" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" style="width:15%;height: 30px;">&nbsp;<img src="imagenes/calendario04.png" onClick="displayCalendarFor('fc_1198971544');" title="Calendario" class="icobut"/></td>
								<td></td>
							</tr>
							<tr>
								<td class="saludo1">Objetivos Espec&iacute;ficos:</td>
								<td colspan="3" style="width:72%">
									<input type="text" name="objesp" id="objesp" value="<?php echo $_POST[objesp];?>" style="width:100%">
								</td>
								<td style="width:13%">
									<em name="agregaobj" class="botonflecha" onClick="agregardetalle()">Agregar Objetivo</em>
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
												<td><input class='inpnovisibles' type='text' name='dobjesp[]' value='".$_POST[dobjesp][$x]."' style='width:100%;' readonly></td>
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
					<input type="radio" id="tab-4" name="tabgroup1" value="4" <?php echo $check4;?> >
					<label for="tab-4">Marco Legal</label>
					<div class="content" style="overflow:hidden;">
						<table class="inicio ancho" >
							<tr>
								<td class="titulos" colspan="6" width="100%">Marco Legal</td>
								<td class="boton02" onClick="location.href='meci-principal.php'">Cerrar</td>
							</tr>
							<tr>
								<td class="saludo1" style="width:10%;">Clase Normativa:</td>
								<td style="width:15%;">
									<select name="normativa" id="normativa" style="width:100%;padding: 0;" >
										<?php
											$sqlr="SELECT * FROM mecivariables WHERE clase='NML' AND estado='S' ORDER BY id ASC";
											$res=mysql_query($sqlr,$linkbd);
											while ($row =mysql_fetch_row($res)) 
											{
												echo "<option value=$row[0] ";
												$i=$row[0];
												if($i==$_POST[normativa]){echo "SELECTED"; $_POST[normativa]=$row[1];}
												echo ">".$row[1]." </option>";
											}	 	
										?>
									</select>
								</td>
								<td class="saludo1" style="width:10%;">Categor&iacute;a Normativa:</td>
								<td style="width:15%;">
									<select name="catenormativa" id="catenormativa" style="width:100%;padding: 0;" >
										<?php
											$sqlr="SELECT * FROM mecivariables WHERE clase='CML' AND estado='S' ORDER BY id ASC";
											$res=mysql_query($sqlr,$linkbd);
											while ($row =mysql_fetch_row($res)) 
											{
												echo "<option value=$row[0] ";
												$i=$row[0];
												if($i==$_POST[catenormativa]){echo "SELECTED"; $_POST[catenormativa]=$row[1];}
												echo ">".$row[1]." </option>";
											}	 	
										?>
									</select>
								</td>
								<td class="saludo1" style="width:12%;">Documento Adjunto:</td>
								<td><input type="text" name="nomarch" id="nomarch" style="width:100%" value="<?php echo $_POST[nomarch]?>" readonly></td>
								<td>
									<div class='upload'> 
										<input type="file" name="plantillaad" onChange="document.form2.submit();" />
										<img src='imagenes/attach.png'  title='Cargar Documento'  /> 
									</div> 
								</td>
							</tr>
							<tr>
								<td class="saludo1">Descripci&oacute;n:</td>
								<td colspan="5" >
									<input type="text" name="desmar" id="desmar" value="<?php echo $_POST[desmar];?>" style="width:100%">
								</td>
							</tr>
							 <tr>
								<td class="saludo1" style="width:5%;">Fecha:</td>
								<td><input type="text" name="fecmls" value="<?php echo $_POST[fecmls]?> "maxlength="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971540" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" style="width:80%;height: 30px;">&nbsp;<img src="imagenes/calendario04.png" onClick="displayCalendarFor('fc_1198971540');" title="Calendario" class="icobut"/></td>
								<td style="width:14%">
									<em name="agregamar" class="botonflecha" onClick="agregarmarco()">Agregar Documento</em>
							   </td>
							</tr>
						</table>
						<div class="subpantallac5" style="overflow:hidden-x;">
							<table class="inicio" style="text-aling:center;">
								 <tr>
									<td class="titulos" style="width:6%;text-align: center;">Item</td>
									<td class="titulos" style="width:15%;text-align: center;">Clase</td>
									<td class="titulos" style="width:15%;text-align: center;">Categor&iacute;a</td>
									<td class="titulos" style="width:30%;text-align: center;">Descripci&oacute;n</td>
									<td class="titulos" style="width:20%;text-align: center;">Adjunto</td>
									<td class="titulos" style="width:10%;text-align: center;">Fecha</td>
									<td class="titulos" style="width:4%;text-align: center;"><img src='imagenes/del.png'></td>
								</tr>
								<?php
									$iter="saludo1";
									$iter2="saludo2";
									$tam=count($_POST[marcla]);   
									for($x=0;$x<$tam;$x++)
									{
										$sqlr="SELECT * FROM mecivariables WHERE id=".$_POST[marcla][$x]." AND estado='S' ORDER BY id ASC";
										$res=mysql_query($sqlr,$linkbd);
										$normativa =mysql_fetch_row($res);


										$sqlr1="SELECT * FROM mecivariables WHERE id=".$_POST[marcate][$x]." AND estado='S' ORDER BY id ASC";
										$res1=mysql_query($sqlr1,$linkbd);
										$clasenormativa =mysql_fetch_row($res1);

										echo "
											<input type='hidden' name='marcla[]' value='".$_POST[marcla][$x]."'>
											<input type='hidden' name='marcate[]' value='".$_POST[marcate][$x]."'>
											
											<tr class='$iter'>
												<td>".($x+1)."</td>										
												<td>$normativa[1]</td>
												<td>$clasenormativa[1]</td>
												<td><input class='inpnovisibles' type='text' name='mardes[]' value='".$_POST[mardes][$x]."' style='width:100%;' readonly></td>
												<td><input class='inpnovisibles' type='text' name='maradj[]' value='".$_POST[maradj][$x]."' style='width:100%;' readonly></td>
												<td><input class='inpnovisibles' type='text' name='marfec[]' value='".$_POST[marfec][$x]."' style='width:100%;' readonly></td>
												<td style='text-align:center' ><a href='#' onclick='eliminarml($x)'><img src='imagenes/del.png'></a></td>
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
			<?php
				//archivos
				if (is_uploaded_file($_FILES['plantillaad']['tmp_name'])) 
				{
					$linkbd=conectar_bd();
					$sqlr="SELECT adjunto FROM meciestructuraorg_marcolegal";
					$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res))
					{$archad[]=$row[0];}
					if (in_array($_FILES['plantillaad']['name'], $archad))
					{?><script>despliegamodalm('visible','2','Ya existe un Documento en el Marco Legal con este nombre');</script><?php }
					else
					{
						$rutaad="informacion/marco_legal/temp/";
						?><script>document.getElementById('nomarch').value='<?php echo $_FILES['plantillaad']['name'];?>';</script><?php
						copy($_FILES['plantillaad']['tmp_name'], $rutaad.$_FILES['plantillaad']['name']);
					}
				}
				if($_POST[oculto]=="1")//********guardar
				{
					$estalm="Nuevo";
					$sqlid="SELECT MAX(id) FROM meciestructuraorg ";
					$rowid=mysql_fetch_row(mysql_query($sqlid,$linkbd));
					switch($_POST[tabgroup1])
					{
						case 1:
							if($_POST[idvisi]!=""){$estalm="Modif";}
							else{$_POST[idvisi]=$rowid[0]+1;}
							$numid=$_POST[idvisi];
							$clase="VIS";
							$version=$_POST[vervia].".".$_POST[vervib];
							$fecha=$_POST[fecvis];
							$contex=preg_replace("/\n/","&lt;br/&gt;",$_POST["vision"]);
							$clamensaje="la Visi\xf3n";
							break;
						case 2:
							if($_POST[idmisi]!=""){$estalm="Modif";}
							else{$_POST[idmisi]=$rowid[0]+1;}
							$numid=$_POST[idmisi];
							$clase="MIS";
							$version=$_POST[vermia].".".$_POST[vermib];
							$fecha=$_POST[fecmis];
							$contex=preg_replace("/\n/","&lt;br/&gt;",$_POST["mision"]);
							$clamensaje="la Misi\xf3n";
							break;
						case 3:
							if($_POST[idobje]!="")
							{
								$estalm="Modif";
								$sqldelobj ="DELETE FROM meciestructuraorg_objespe WHERE idobjesp='".$_POST[idobje]."'";
								mysql_query($sqldelobj,$linkbd);
							}
							else{$_POST[idobje]=$rowid[0]+1;}
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
							for($x=0;$x<$_POST[banmlg];$x++)
							{
								$sqlidml="SELECT MAX(id) FROM meciestructuraorg_marcolegal ";
								$rowidml=mysql_fetch_row(mysql_query($sqlidml,$linkbd));
								$numidml=$rowidml[0]+1;
								$sqlmlg="INSERT INTO meciestructuraorg_marcolegal (id,id_det,idnormativa,fechanorma,descripcion,adjunto,estado,idcatenormativa) VALUES ('$numidml','','".$_POST[marcla][$x]."','".$_POST[marfec][$x]."','".$_POST[mardes][$x]."','".$_POST[maradj][$x]."','S','".$_POST[marcate][$x]."')";
								mysql_query($sqlmlg,$linkbd);
								copy("informacion/marco_legal/temp/".$_POST[maradj][$x],("informacion/marco_legal/".$_POST[maradj][$x]));
							}
							break;
						case 5:
							if($_POST[idpcl]!=""){$estalm="Modif";}
							else{$_POST[idpcl]=$rowid[0]+1;}
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
						if($estalm=="Nuevo")
							{	
								$sqldes="UPDATE meciestructuraorg SET estado='N' WHERE estado='S' AND clase='$clase'";
								mysql_query($sqldes,$linkbd);
								$sqln="INSERT INTO meciestructuraorg (id,clase,version,fecha,descripcion,estado) VALUES ('$numid','$clase', '$version','$fecha','$contex','S')";
								$conmensaje="Se Guardo con exito ".$clamensaje;
							}
						else
							{
								$conmensaje="Se Modifico con exito ".$clamensaje;
								$sqln="UPDATE meciestructuraorg SET version='$version',fecha='$fecha',descripcion='$contex' WHERE id='$numid'" ;
							}
						mysql_query($sqln,$linkbd);
						?><script>despliegamodalm('visible','3','<?php echo $conmensaje;?>');</script><?php
					}
					else {?><script>despliegamodalm('visible','1');</script><?php }
					$_POST[oculto]="0";
				}
			?>
			<input type="hidden" name="oculto" id="oculto" value="<?php echo $_POST[oculto];?>">
			<input type="hidden" name="ocumis" id="ocumis" value="<?php echo $_POST[ocumis];?>">
			<input type="hidden" name="ocupcl" id="ocupcl" value="<?php echo $_POST[ocupcl];?>">
			<input type="hidden" name="ocuvis" id="ocuvis" value="<?php echo $_POST[ocuvis];?>">
			<input type="hidden" name="ocuobj" id="ocuobj" value="<?php echo $_POST[ocuobj];?>">
			<input type="hidden" name="ocumlg" id="ocumlg" value="<?php echo $_POST[ocumlg];?>">
			<input type="hidden" name="idvisi" id="idvisi" value="<?php echo $_POST[idvisi];?>">
			<input type="hidden" name="idmisi" id="idmisi" value="<?php echo $_POST[idmisi];?>">
			<input type="hidden" name="idpcl" id="idpcl" value="<?php echo $_POST[idpcl];?>">
			<input type="hidden" name="idobje" id="idobje" value="<?php echo $_POST[idobje];?>">
			<input type="hidden" name="idmale" id="idmale" value="<?php echo $_POST[idobje];?>">
			<input type="hidden" name="agregadet" value="0">
			<input type="hidden" name="agregamlg" value="0">
			<input type='hidden' name='elimina' id='elimina'>
			<input type='hidden' name='eliminaml' id='eliminaml'>
 		</form
	</body>
</html>