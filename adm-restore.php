<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	$datin=datosiniciales();
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Spid - Administracion</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js"></script>
		<script>
          	function restaurarcopia()
			{
			  if(document.form2.nomarch.value == ""){despliegamodalm('visible','2','No hay ningun archivo Seleccionado');}
			  else{despliegamodalm('visible','4','Esta Seguro de Restaurar la Copia de Seguridad del Sistema','1');}
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
							document.getElementById('ventanam').src="ventana-consulta2.php?titulos="+mensa+"&idresp="+pregunta;break;	
					}
				}
			}
			function funcionmensaje(){document.location.href = ".php";}
			function respuestaconsulta(resp,pregunta)
			{
				if(resp=="S")
				{
					switch(pregunta)
					{
						case "1":	document.form2.oculto.value="1";break;
						case "2":	document.form2.cambioestado.value="1";break;
						case "3":	document.form2.cambioestado.value="0";break;
					}
				}
				else
				{
					switch(pregunta)
					{
						case "1":	break;
						case "2":	document.form2.nocambioestado.value="1";break;
						case "3":	document.form2.nocambioestado.value="0";break;
					}
				}
				document.form2.submit();
			}
			function cambioswitch(valor)
			{
				if(valor==1){despliegamodalm('visible','4','Desea Activar el Sistema','2');}
				else{despliegamodalm('visible','4','Desea Desactivar el Sistema','3');}
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
		<table>
   			<tr><script>barra_imagenes("adm");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("adm");?></tr>
			<tr>
  				<td colspan="3" class="cinta"><a class="mgbt"><img src="imagenes/add2.png"/></a><a class="mgbt"><img src="imagenes/guardad.png"/></a><a class="mgbt"><img src="imagenes/buscad.png"/></a><a href="#" onClick="mypop=window.open('adm-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
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
			//*****************************************************************
			if($_POST[cambioestado]!="")
			{
				if($_POST[cambioestado]=="1")
				{
					$sqlr="UPDATE dominios SET valor_inicial='N', descripcion_valor='".$_SESSION[cedulausu]."' WHERE  nombre_dominio='ESTADO_BACKUP'";
					mysql_fetch_row(mysql_query($sqlr,$linkbd)); 
				}
				else 
				{
					$sqlr="UPDATE dominios SET valor_inicial='S', descripcion_valor='".$_SESSION[cedulausu]."' WHERE  nombre_dominio='ESTADO_BACKUP'";
					mysql_fetch_row(mysql_query($sqlr,$linkbd)); 
				}
				$_POST[cambioestado]="";
			}
			//*****************************************************************
			if($_POST[nocambioestado]!="")
			{
				if($_POST[nocambioestado]=="1"){$_POST[lswitch]=1;}
				else {$_POST[lswitch]=0;}
				$_POST[nocambioestado]="";
			}
		?>
    		<table width="40%" class="inicio" >
                <tr>
                    <td class="titulos" colspan="5" style='width:93%'>:: Restaurar Copias de Seguridad ::</td>
                    <td class="cerrar" style='width:7%'><a href="adm-principal.php">Cerrar</a></td>
                </tr>
                <tr>
                	<td class="saludo1" style='width:16%'>::Estado del Servidor:</td>
                   	<?php
						$sqlr="SELECT valor_inicial FROM dominios WHERE nombre_dominio='ESTADO_BACKUP'";
						$row =mysql_fetch_row(mysql_query($sqlr,$linkbd));
						if($row[0]=='N'){$imgsem="src='imagenes/sema_verdeON.jpg' title='Activo'";$coloracti="#0F0";$_POST[lswitch]=0;}
						else {$imgsem="src='imagenes/sema_rojoON.jpg' title='Inactivo'";$coloracti="#C00";$_POST[lswitch]=1;}
						echo"<td><input type='range' name='lswitch' value='".$_POST[lswitch]."' min ='0' max='1' step ='1' style='background:$coloracti; width:10.7%' onChange='cambioswitch(\"".$_POST[lswitch]."\")' /><img $imgsem style='width:20px'/></td>"
					?>
             	</tr>
      		<tr>
        		<td style='width:16%' class="saludo1">:: Cargar Copia de Seguridad:</td>
         		<td><input type="text" name="nomarch" id="nomarch"  style="width:100%" value="<?php echo $_POST[nomarch]?>" readonly></td>
        		<td>
            		<div class='upload'> 
                		<a href="#"><input type="file" name="plantillaad" usemap="" onChange="document.getElementById('cargaci1').style.display='block';document.form2.submit();" accept=".sql"/><img src='imagenes/attach.png'  title='Cargar Documento'/></a>
           			</div>
              	</td>
                <td style="width%:4"><div id="cargaci1"  style="display:none"><img  src='imagenes/cargacirculara.gif' style="width:26px" /></div></td>
            	<td><input name="agregadoc" type="button" value="  Restaurar " onClick="restaurarcopia()"></td>
            	   
       		</tr> 
    	</table>  
        <input type="hidden" name="cambioestado" id="cambioestado" value="<?php echo $_POST[cambioestado];?>">
		<input type="hidden" name="nocambioestado" id="nocambioestado" value="<?php echo $_POST[nocambioestado];?>">
       	<input name="oculto" type="hidden" value="0"> 
		<?php
			if (is_uploaded_file($_FILES['plantillaad']['tmp_name'])) 
    		{
   			 	echo"<script>document.getElementById('nomarch').value='". $_FILES['plantillaad']['name']."';</script>";
    			copy($_FILES['plantillaad']['tmp_name'], 'backups/'.$_FILES['plantillaad']['name']);
    		}
		?>
		<div class="subpantalla" style="height:63%; width:99.6%; overflow:hidden;">
			<div id="titulog1" class='inicio' style="display:none">1. GENERANDO ARCHIVO DE RESPALDO</div>
          	<div id="imagenc1" class='inicio' style="display:none"><img  src='imagenes/barraprogreso1.gif' /></div>
 			<div id="titulog2" class='inicio' style="display:none">2. ALMACENANDO ARCHIVO RESPALDO</div>
            <div id="imagenc2" class='inicio' style="display:none"><img  src='imagenes/barraprogreso1.gif' /></div>
            <div id="titulog3" class='inicio' style="display:none">3. RESTAURANDO COPIA DE SEGURIDAD</div>
             <div id="imagenc3" class='inicio' style="display:none"><img  src='imagenes/barraprogreso1.gif' /></div>
			<?php
				if ($_POST[oculto]=='1')
				{
					$dbname = $datin[0];
					$dbhost = $datin[1]; 
					$dbuser = $datin[2];
					$dbpass = $datin[3];
  					$db = mysql_connect($dbhost, $dbuser, $dbpass) or die ("Error connecting to database.");
					mysql_select_db($dbname, $db) or die ("Couldn't select the database.");
					$date = date("Ymd-His", time());
					$backupFile = 'backups/dbBackup-'.$dbname.'-'.$date.'.sql';
					$outputDir = 'backups';
					$mysqldumppath = '"../../mysql/bin/mysqldump.exe"';
					$nombrearchivo = 'dbBackup-'.$dbname.'-'.$date.'.sql';
					$command = "$mysqldumppath --opt --triggers -h $dbhost -u$dbuser -p$dbpass $dbname > $backupFile";
					$sql = "show tables from ".$dbname."";
					$resc=mysql_query($sql,$linkbd);
					$rowc=mysql_num_rows($resc);
					$valortotal=$rowc;
					$i=0;
					echo"<script> document.getElementById('titulog1').style.display='block'; document.getElementById('imagenc1').style.display='block';</script>";
					flush();ob_flush();usleep(500);
					while($rowc=mysql_fetch_row($resc))
					{$i+=1;$porcentaje = $i * 100 / $valortotal;  } 
					echo"<script>document.getElementById('imagenc1').innerHTML=\"Archivo Generado Con Exito <img src='imagenes/confirm.png'>\"; document.getElementById('titulog2').style.display='block';document.getElementById('imagenc2').style.display='block';</script>";
					flush();ob_flush();usleep(500);
  					if(!system($command))
					{
						echo "<script>document.getElementById('imagenc2').innerHTML=\"Archivo Almacenado: ".$nombrearchivo." <a href='".$backupFile."' target='_blank' download><img src='imagenes/descargar.png' title='Descargar'/></a>\";</script>";
					}
    				else {echo "<div class='inicio'>Copia de Seguridad Resultado: <img src='imagenes/alert.png'></div>";};
					echo"<script> document.getElementById('titulog3').style.display='block'; document.getElementById('imagenc3').style.display='block';</script>";
     				flush();ob_flush();usleep(500);
					$backupFile1 = 'backups/'.$_POST[nomarch].'';
					$mysqldumppath1 = '"../../mysql/bin/mysql.exe"';
					$command1 = "$mysqldumppath1 -h $dbhost -u$dbuser -p$dbpass $dbname < $backupFile1";
					system($command1);
					if(!system($command1))
					{
						echo "<script>document.getElementById('imagenc3').innerHTML=\"Restauraci&oacute;n Completada Con Exito <img src='imagenes/confirm.png'>\";</script> ";
					}  
					else {
					echo "<div class='inicio'>Error Durante la Restauraci&oacute;n <img src='imagenes/alert.png'></div>";
					 };      
					mysql_close($db);
				}
			?>
			</div> 
		</form>       
	</body>
</html>