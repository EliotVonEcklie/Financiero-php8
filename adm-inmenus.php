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
         <script type="text/javascript" src="JQuery/prettify.min.js"></script>
         <script type="text/javascript" src="JQuery/modernizr.custom.82437.js"></script>
		<script type="text/javascript" src="css/cssrefresh.js"></script>
		<script>
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
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.getElementById('oculto').value="3";
								document.form2.submit();break;
					case "2":	document.getElementById('oculto').value="4";
								document.form2.submit();break;
				}
			}
			
			function descargarf()
			{
				if (document.getElementById('archivod').value!="")
				{
					{despliegamodalm('visible','4','Esta Seguro de Exportar con el nombre de archivo '+'"'+document.getElementById('archivod').value+'"','1');}
				}
				else{despliegamodalm('visible','2','Falta ingresar un nombre de Archivo');}
			}
			function cargarf()
			{
				if (document.getElementById('nimagen1').value!="")
				{
					{despliegamodalm('visible','4','Esta Seguro de Importar el listado'+'"'+document.getElementById('nimagen1').value+'"','2');}
				}
				else{despliegamodalm('visible','2','Falta ingresar un nombre de Archivo');}
			}
			function importarf()
			{ 
			}
			//******Arrastrar******
			if (Modernizr.draganddrop) {
  // Browser supports HTML5 DnD.
} else {
  // Fallback to a library solution.
}
			function handleDragStart(e) { this.style.opacity = '0.4';}

			var cols = document.querySelectorAll('#columns .column');
			[].forEach.call(cols, function(col) { col.addEventListener('dragstart', handleDragStart, false); });
		</script>
		<?php 
			titlepag();
			function eliminarDir()
			{
				$usersave=$_SESSION[cedulausu];
				$carpeta="informacion/temp/us$usersave";
				foreach(glob($carpeta . "/*") as $archivos_carpeta)
				{
					if (is_dir($archivos_carpeta)){eliminarDir($archivos_carpeta);}
					else{unlink($archivos_carpeta);}
				}
				rmdir($carpeta);
			}
		?>
        <style>
			[draggable] 
			{
  				-moz-user-select: none;
			 	-khtml-user-select: none;
			  	-webkit-user-select: none;
			  	user-select: none;
			  	-khtml-user-drag: element;
			  	-webkit-user-drag: element;
			}
			
			.column 
			{
  height: 150px;
  width: 150px;
  float: left;
  border: 2px solid #666666;
  background-color: #ccc;
  margin-right: 5px;
  -webkit-border-radius: 10px;
  -ms-border-radius: 10px;
  -moz-border-radius: 10px;
  border-radius: 10px;
  -webkit-box-shadow: inset 0 0 3px #000;
  -ms-box-shadow: inset 0 0 3px #000;
  box-shadow: inset 0 0 3px #000;
  text-align: center;
  cursor: move;
}
.column header {
  color: #fff;
  text-shadow: #000 0 1px;
  box-shadow: 5px;
  padding: 5px;
  background: -moz-linear-gradient(left center, rgb(0,0,0), rgb(79,79,79), rgb(21,21,21));
  background: -webkit-gradient(linear, left top, right top,
                               color-stop(0, rgb(0,0,0)),
                               color-stop(0.50, rgb(79,79,79)),
                               color-stop(1, rgb(21,21,21)));
  background: -webkit-linear-gradient(left center, rgb(0,0,0), rgb(79,79,79), rgb(21,21,21));
  background: -ms-linear-gradient(left center, rgb(0,0,0), rgb(79,79,79), rgb(21,21,21));
  border-bottom: 1px solid #ddd;
  -webkit-border-top-left-radius: 10px;
  -moz-border-radius-topleft: 10px;
  -ms-border-radius-topleft: 10px;
  border-top-left-radius: 10px;
  -webkit-border-top-right-radius: 10px;
  -ms-border-top-right-radius: 10px;
  -moz-border-radius-topright: 10px;
  border-top-right-radius: 10px;
}
		</style>
	</head>
	<body>
    	<script>
    	
	</script>
</div>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table >
   			<tr><script>barra_imagenes("adm");</script><?php cuadro_titulos();?></tr>
    		<tr><?php menu_desplegable("adm");?></tr>
			<tr>
  				<td colspan="3" class="cinta"><a class="mgbt"><img src="imagenes/add2.png" /></a><a href="#" onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png" title="Guardar"/></a><a class="mgbt"><img src="imagenes/buscad.png" /></a><a href="#" onClick="mypop=window.open('adm-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
         	</tr>		  
		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
        <form name="form2" method="post" enctype="multipart/form-data" action="">
        	<?php
				if ($_POST[oculto]=="")
                {
					$_POST[tabgroup1]=1;
					$usersave=$_SESSION[cedulausu];
					$rutaad="informacion/temp/us$usersave/";
					if(!file_exists($rutaad)){mkdir ($rutaad);}
					else {eliminarDir();mkdir ($rutaad);}
				}
				switch($_POST[tabgroup1])
                {
                    case 1:	$check1='checked';break;
                    case 2:	$check2='checked';break;
                }
				$modul01 = array
				(
					array("Sistema","Parametros","Herramientas","Informes"),
					array("Archivos Maestros","Procesos","Herramientas","Informes"),
					array("Archivos Maestros","Procesos","Herramientas","Informes"),
					array("Archivos Maestros","Proceso Ingreso","Proceso Gastos","Reportes","Herramientas"),
					array("Archivos Maestros","Recaudo","Pago","Traslados","Herramientas","Informes"),
					array("Archivos Maestros","Procesos","Herramientas","Informes"),
					array("Archivos Maestros","Procesos","Herramientas","Informes"),
					array("Archivos Maestros","Procesos","Herramientas","Informes"),
					array("Archivos Maestros","Procesos","Herramientas","Informes"),
					array("Archivos Maestros","Procesos","Herramientas","Informes")
				);
			?>
            <div class="tabsmeci"  style="height:76.5%; width:99.6%">
            	<div class="tab">
             		<input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
         			<label for="tab-1">Manual</label>
           			<div class="content" style="overflow:hidden;">
          				<div style="width:50%;">
                        	<table class="inicio" >
                            	<tr>
                                    <td class="saludo1" style="width:2cm;">Modulo:</td>
                                    <td style="width:25%;">
                                        <select name="modulo01" id="modulo01" style="width:100%;" onChange="document.getElementById('menusel01').value='-1'; document.form2.submit();">
                                        	<option value="-1" <?php if($_POST[modulo01]=="-1"){echo "SELECTED";}?>>Seleccionar...</option>
                                            <option value="6" <?php if($_POST[modulo01]=="6"){echo "SELECTED";}?>>Activos Fijos</option>
                                            <option value="0" <?php if($_POST[modulo01]=="0"){echo "SELECTED";}?>>Administraci&oacute;n</option>
                                            <option value="5" <?php if($_POST[modulo01]=="5"){echo "SELECTED";}?>>Almac&eacute;n</option>
                                            <option value="1" <?php if($_POST[modulo01]=="1"){echo "SELECTED";}?>>Contabilidad</option>
                                            <option value="8" <?php if($_POST[modulo01]=="8"){echo "SELECTED";}?>>Contrataci&oacute;n</option>
                                            <option value="2" <?php if($_POST[modulo01]=="2"){echo "SELECTED";}?>>Gesti&oacute;n Humana</option>
                                            <option value="7" <?php if($_POST[modulo01]=="7"){echo "SELECTED";}?>>Meci Calidad</option>
                                            <option value="9" <?php if($_POST[modulo01]=="9"){echo "SELECTED";}?>>Planeaci&oacute;n Estrategica</option>
                                            <option value="3" <?php if($_POST[modulo01]=="3"){echo "SELECTED";}?>>Presupuesto</option>
                                            <option value="4" <?php if($_POST[modulo01]=="4"){echo "SELECTED";}?>>Tesorer&iacute;a</option>
                                        </select>
                             		</td>
                                    <td class="saludo1" style="width:2cm;">Menus:</td>
                                    <td>
                                        <select name="menusel01" id="menusel01" onChange="document.form2.submit();">
                                        	<option value="-1" <?php if($_POST[menusel01]=="-1"){echo "SELECTED";}?>>Seleccionar...</option>
                                      		<?php
												$numct=count($modul01[$_POST[modulo01]]);
												for($xm=0;$xm<$numct;$xm++)
												{
													echo"<option value='$xm' "; 
													if ($_POST[menusel01]==$xm){echo "SELECTED";}
													echo">".$modul01[$_POST[modulo01]][$xm]."</option>";
												}
											?>
                                        </select>
                             		</td>
                         		</tr>
 							</table>
                            <div class="subpantallac" style="width:99.6%; overflow-x:hidden;" >
                            	<div id="columns11">
                            	<?php 
									if ($_POST[menusel01]!="" && $_POST[menusel01]!="-1")
									{
										if ($_POST[modulo01]==0){$nivelop=$_POST[menusel01];}
										else {$nivelop=$_POST[menusel01]+1;}
										$sqlrop="SELECT * FROM opciones WHERE modulo='$_POST[modulo01]' AND niv_opcion='$nivelop' ORDER BY orden";
										$resop = mysql_query($sqlrop,$linkbd);
										while ($rowop =mysql_fetch_row($resop)) 
										{
										echo "<div class='column' draggable='true'><header>$rowop[1]</header></div>";
										}
									}
								?>
                               </div>
                            </div>
                  		</div>
           			</div>
            	</div>
                <div class="tab">
                    <input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?> >
                    <label for="tab-2">Automatica</label>
                    <div class="content" style="overflow:hidden;">
                 		<table class="inicio">
                        	<tr>
                                <td class="titulos" colspan="5">:: Configuraci&oacute;n Automatica Menus</td>
                                <td class='cerrar' style="width:7%;"><a href='adm-principal.php'>Cerrar</a></td>
                            </tr>
                            <tr>
                                <td class="titulos2" colspan="6">:: Exportar Menus Programa Actual</td>
                            </tr>
                            <tr>
                            	<td class="tamano01" style="width:3.5cm">:&middot; Nombre Archivo:</td>
                                <td style="width:30%;"><input type="text" name="archivod" id="archivod" style="width:100%;" value="<?php echo $_POST[archivod];?>" class="tamano02"/></td>
                                <td><input type="button" name="descargarb" id="descargarb" value="&nbsp;&nbsp;Descargar&nbsp;&nbsp;" onClick="descargarf();" /> </td>
                            </tr>
                        	 <tr>
                                <td class="titulos2" colspan="6">:: Importar lista Menus desde Archivo</td>
                            </tr>
                            <tr>
                                <td class="tamano01" style="width:3.5cm;">:&middot; Nombre Archivo:</td>
                                <td style="width:40%;">
                                    <input type="text" name="nimagen1" id="nimagen1"  style="width:95%" value="<?php echo $_POST[nimagen1]?>" class="tamano02"  readonly/>
                                     <div class='upload' style="height:24px;float:right !important;" > 
                                        <input type="file" name="adnimagen1" id="adnimagen1" value="<?php echo $_POST[adnimagen1];?>"  onChange="document.form2.submit();" title="Cargar Listado" />
                                        <img src='imagenes/upload01.png' style="width:23px"/> 
                                     </div> 
                      			</td>
                    			<td><input type="button" name="cargarb" id="cargarb" value="&nbsp;&nbsp;&nbsp;Importar&nbsp;&nbsp;&nbsp;" onClick="cargarf();" /></td>
                            </tr>
                        </table>
                    </div>
               	</div>
            </div>
            <input name="oculto" type="hidden" id="oculto" value="1">
        	<script type="text/javascript">$('#archivod').alphanum({allow: '_-', allowSpace: false});</script>
			<?php
				if (is_uploaded_file($_FILES['adnimagen1']['tmp_name'])) 
				{
					$archivo = $_FILES['adnimagen1']['name'];
					$tipo = $_FILES['adnimagen1']['type'];
					$usersave=$_SESSION[cedulausu];
					$destino = "informacion/temp/us$usersave/".$archivo;
					if (copy($_FILES['adnimagen1']['tmp_name'],$destino))
					{
						echo"
						<script>
							document.getElementById('nimagen1').value='".$_FILES['adnimagen1']['name']."';
						</script>";
					}
					else
					{
						echo"<script>document.getElementById('nimagen1').value='';
						despliegamodalm('visible','2','Error Al Cargar el Archivo');</script>";
					} 
				}
				if ($_POST[oculto]==3)//exportar Archivo
				{
					$usersave=$_SESSION[cedulausu];
					$rutaad="informacion/temp/us$usersave/";
					$namearch=$rutaad.$_POST[archivod].".csv";
					$Descriptor1 = fopen($namearch,"w+"); 
					$sqlr="SELECT * FROM opciones ORDER BY id_opcion";
					$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res)) 
					{
						$lista = array ($row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7],$row[8]);
						fputcsv($Descriptor1, $lista,";");
					}
					fclose($Descriptor1);
					echo"<script>document.location='$namearch'</script>";
				}
				if ($_POST[oculto]==4)//Importar Archivo
				{
					$usersave=$_SESSION[cedulausu];
					$namearch="informacion/temp/us$usersave/".$_POST[nimagen1];
					if (($gestor = fopen($namearch, "r")) !== FALSE) 
					{
						while (($datos = fgetcsv($gestor, 1000, ";")) !== FALSE) 
						{
							$verifica=0;
							$sqlr="SELECT * FROM opciones WHERE nom_opcion='$datos[1]' AND modulo='$datos[6]' AND niv_opcion='$datos[3]'";
							$res=mysql_query($sqlr,$linkbd);
							while($row=mysql_fetch_row($res))
							{
								if($row[2]!=$datos[2])
								{$sqlr2="UPDATE opciones SET ruta_opcion='$datos[2]' WHERE id_opcion='$row[0]'";mysql_query($sqlr2,$linkbd);}
								if($row[5]!=$datos[5])
								{$sqlr2="UPDATE opciones SET orden='$datos[5]' WHERE id_opcion='$row[0]'";mysql_query($sqlr2,$linkbd);}
								if($row[7]!=$datos[7])
								{$sqlr2="UPDATE opciones SET especial='$datos[7]' WHERE id_opcion='$row[0]'";mysql_query($sqlr2,$linkbd);}
								if($row[8]!=$datos[8])
								{$sqlr2="UPDATE opciones SET comando='$datos[8]' WHERE id_opcion='$row[0]'";mysql_query($sqlr2,$linkbd);}
								$verifica=$verifica+1;
							}
							if ($verifica==0)
							{
								$sqlr2="INSERT INTO opciones (id_opcion,nom_opcion,ruta_opcion,niv_opcion,est_opcion,orden,modulo,especial,comando) VALUES (NULL,'$datos[1]','$datos[2]','$datos[3]','$datos[4]','$datos[5]','$datos[6]','$datos[7]','$datos[8]')";
								mysql_query($sqlr2,$linkbd);
							}
						}
						fclose($gestor);
					}
				}
			?>
		</form>
	</body>
</html>