<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	define('basesdedatos', "C:/xampp/mysql/data");
	include (basesdedatos. 'adm-backups.php');
	define('googledriver', "C:/Users/USER/Google Drive");
	include (googledriver. 'adm-backups.php');
	//require"PHPMailer-master/PHPMailerAutoload.php";
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
		<script type="text/javascript">
			function generar_ba(){despliegamodalm('visible','4','Esta Seguro de Generar la Copia de Seguridad del Sistema','1');}
			function generar_ma(){despliegamodalm('visible','4','Esta Seguro de Generar la Copia Manual de Seguridad del Sistema','4');}
			function callprogress(vValor)
			{
 				document.getElementById("getprogress").innerHTML = vValor;
 				document.getElementById("getProgressBarFill").innerHTML = '<div class="ProgressBarFill" style="width: '+vValor+'%;"></div>';
				document.getElementById("titulog1").style.display='block';
   				document.getElementById("progreso").style.display='block';
     			document.getElementById("getProgressBarFill").style.display='block';
				if (vValor==100){document.getElementById("titulog2").style.display='block';}
			}  
			function cambioswitch(valor)
			{
				if(valor==1){despliegamodalm('visible','4','Desea Activar el Sistema','2');}
				else{despliegamodalm('visible','4','Desea Desactivar el Sistema','3');}
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
						case "1":	document.form2.oculto.value = '1';break;
						case "2":	document.form2.cambioestado.value="1";break;
						case "3":	document.form2.cambioestado.value="0";break;
						case "4":	document.form2.oculto.value = '2';break;
					}
				}
				else
				{
					switch(pregunta)
					{
						case "1":	break;
						case "2":	document.form2.nocambioestado.value="1";break;
						case "3":	document.form2.nocambioestado.value="0";break;
						case "4":	break;
					}
				}
				document.form2.submit();
			}
		</script>
		<?php 
			titlepag();
			function eliminarDir($carpeta)
			{
				$carpeta2="backups/".$carpeta;
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
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("adm");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("adm");?></tr>
        	<tr>
  				<td colspan="3" class="cinta"><a href="#" class="mgbt"><img src="imagenes/add2.png" title="Nuevo" /></a><a class="mgbt"><img src="imagenes/guardad.png"/></a><a class="mgbt"><img src="imagenes/buscad.png" title="Buscar" /></a><a href="#" onClick="mypop=window.open('adm-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
           	</tr>
   		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
		<form name="form2" method="post" action="adm-backups.php">
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
                	<td class="titulos" colspan="2">:: Copias de Seguridad</td>
                    <td class="cerrar" style='width:7%'><a href="adm-principal.php">Cerrar</a></td>
             	</tr>
                <tr>
                	<td class="saludo1" style='width:16%'>::Estado del Servidor:</td>
                   	<?php
						$sqlr="SELECT valor_inicial FROM dominios WHERE nombre_dominio='ESTADO_BACKUP'";
						$row =mysql_fetch_row(mysql_query($sqlr,$linkbd));
						if($row[0]=='N') {$imgsem="src='imagenes/sema_verdeON.jpg' title='Activo'";$coloracti="#0F0";$_POST[lswitch]=0;}
						else {$imgsem="src='imagenes/sema_rojoON.jpg' title='Inactivo'";$coloracti="#C00";$_POST[lswitch]=1;}
						echo"<td><input type='range' name='lswitch' value='".$_POST[lswitch]."' min ='0' max='1' step ='1' style='background:$coloracti; width:6.5%' onChange='cambioswitch(\"".$_POST[lswitch]."\")' /><img $imgsem style='width:20px'/></td>"
					?>
             	</tr>
      			<tr>
       				<td class="saludo1" style='width:16%'>::Generar Copia de Seguridad:</td>
        			<td>
                    	<input type="button" name="generar" value="Generar Copia" onClick ="generar_ba();"/>
                        <input type="button" name="generar2" id="generar2" value="Copia Manual" onClick ="generar_ma();"/>
                    </td>
      			</tr>
    		</table> 
            <input type="hidden" name="cambioestado" id="cambioestado" value="<?php echo $_POST[cambioestado];?>">
            <input type="hidden" name="nocambioestado" id="nocambioestado" value="<?php echo $_POST[nocambioestado];?>">
            <input type="hidden" name="oculto" id="oculto" value="0">
   			<div class="subpantalla" style="height:63%; width:99.6%; ">
            	<div id="titulog1" class='inicio' style="display:none">1. GENERANDO ARCHIVO</div>
            	<div class='inicio'>
    				<div id="progreso" class="ProgressBar" style="display:none">
      					<div class="ProgressBarText"><span id="getprogress"></span>&nbsp;% completado</div>
      					<div id="getProgressBarFill"></div>
                    </div>
    			</div>   
                <div id="titulog2" class='inicio' style="display:none">2. ALMACENANDO ARCHIVO</div>     
				<?php
					if ($_POST[oculto]=='2')
					{
						$dbname = $datin[0];
						$dbhost = $datin[1]; 
						$dbuser = $datin[2];
						$dbpass = $datin[3];
						$date = date("Ymd_His", time());
						$nombrecarpeta = "dbBackup_".$dbname."_".$date;
						mkdir ("backups/$nombrecarpeta");
						$source =basesdedatos."/$dbname/";
						$destination = "backups/$nombrecarpeta/$dbname/";
						full_copy($source, $destination);
						full_copy("archivos/","backups/$nombrecarpeta/archivos/");
						full_copy("informacion/","backups/$nombrecarpeta/informacion/");
						$db = mysql_connect($dbhost, $dbuser, $dbpass) or die ("Error connecting to database.");
						mysql_select_db($dbname, $db) or die ("Couldn't select the database.");
						$date = date("Ymd-His", time());
						$backupFile = "backups/$nombrecarpeta/$nombrecarpeta.sql";
						$nombrearchivo = "$nombrecarpeta.sql";
						$mysqldumppath = '"../../mysql/bin/mysqldump.exe"';
						$command = "$mysqldumppath --default-character-set=latin1 --skip-set-charset --opt --triggers -h $dbhost -u$dbuser -p$dbpass $dbname > $backupFile";
						$sql = "show tables from ".$dbname."";
						$resc=mysql_query($sql,$linkbd);
						$rowc=mysql_num_rows($resc);
						$valortotal=$rowc;
						$i=0;
						while($rowc=mysql_fetch_row($resc))
						{ 
							$i+=1;
							$porcentaje = $i * 100 / $valortotal;  
							echo"<script>progres='".round($porcentaje)."';callprogress(progres);</script>"; 
							flush();
							ob_flush();
							usleep(5);
						} 
						if(!system($command))
						{  	
							echo "<div class='inicio'>Archivo Almacenado: \"".$nombrearchivo."\" <a href=".$backupFile." target='_blank' download><img src='imagenes/descargar.png' title='Descargar'/></a></div>";
						}
						else {echo "<div class='inicio'>Copia de Seguridad Resultado: <img src='imagenes/alert.png'></div>";}
						mysql_close($db);
						comprimir("backups/$nombrecarpeta/",("backups/$nombrecarpeta.zip"));
						$direlim=googledriver."/backups/villavo/$nombrecarpeta.zip";
						copy(("backups/$nombrecarpeta.zip"),($direlim));
						if ($nombrecarpeta!=""){eliminarDir("$nombrecarpeta");}
					}
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
						$nombrearchivo = 'dbBackup-'.$dbname.'-'.$date.'.sql';
						$mysqldumppath = '"../../mysql/bin/mysqldump.exe"';
						$command = "$mysqldumppath --default-character-set=latin1 --skip-set-charset --opt --triggers -h $dbhost -u$dbuser -p$dbpass $dbname > $backupFile";
						$sql = "show tables from ".$dbname."";
						$resc=mysql_query($sql,$linkbd);
						$rowc=mysql_num_rows($resc);
						$valortotal=$rowc;
						$i=0;
						while($rowc=mysql_fetch_row($resc))
						{ 
							$i+=1;
							$porcentaje = $i * 100 / $valortotal;  
							//llamo a la funciÃ³n JS(JavaScript) para actualizar el progreso
							echo"<script>progres='".round($porcentaje)."';callprogress(progres);</script>"; 
							flush(); //con esta funcion hago que se muestre el resultado de inmediato y no espere a terminar todo el bucle con los 25 registros para recien mostrar el resultado
							ob_flush();
        					//sleep(1);segundos
							usleep(5);//microsegundos
						} 
						if(!system($command))
						{  	
							//inicio correo
							/*
							$mail = new PHPMailer;// Crear una nueva instancia PHPMailer
							$mail->isSMTP();// Indicar PHPMailer utilizar SMTP
							// Habilitar depuración SMTP
							// 0 = apagado (para uso en producción)
							// 1 = mensajes del cliente
							// 2 = cliente y servidor de mensajes
							$mail->SMTPDebug = 3;
							$mail->Debugoutput = 'html';// Obtener la salida de depuración de usar HTML
							$mail->Host = 'smtp.gmail.com';// Establecer el nombre de host del servidor de correo
							// utilizar
							// $ Mail-> Host = gethostbyname ( 'smtp.gmail.com');
							// Si la red no admite SMTP a través de IPv6
							$mail->Port = 587;// Establecer el número de puerto SMTP - 587 para TLS autenticado, también conocido como presentación RFC4409 SMTP
							$mail->SMTPSecure = 'tls';// Establecer el sistema de encriptación de usar - SSL (en desuso) o TLS
							$mail->SMTPAuth = true;// Si se debe usar la autenticación SMTP
							$mail->Username = "soportespid@gmail.com";// Nombre de usuario a utilizar para la autenticación SMTP - introduzca la dirección de correo electrónico completa de Gmail
							$mail->Password = "ENERO123";// Contraseña a utilizar para la autenticación SMTP
							$mail->setFrom('soportespid@gmail.com', 'First Last');// Set que se va a enviar el mensaje de
							$mail->addReplyTo('soportespid@gmail.com', 'First Last');// Establecer una alternativa dirección de respuesta
							$mail->addAddress('horacioandresferreirarojas@gmail.com', 'John Doe');// Set que se va a enviar al mensaje
							$mail->Subject = 'PHPMailer GMail SMTP test';// Establecer la línea de asunto
							// Lea un cuerpo de mensaje HTML desde un archivo externo, convertir las imágenes referenciadas a incrustado,
							//$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));// Convertir HTML en un cuerpo alternativo de texto sin formato básico
							//$mail->AltBody = 'plano texto mirar';// Sustituir el cuerpo de texto plano con una creada manualmente
							$mail->Body = 'plano texto mirar';
							$mail->addAttachment('imagenes/useradd03.png');// Adjuntar un archivo de imagen
							
							//Create a new PHPMailer instance
						$mail = new PHPMailer;
							$mail->setFrom('soportespid@gmail.com', 'First Last');
							$mail->addReplyTo('soportespid@gmail.com', 'First Last');
							$mail->addAddress('horacioandresferreirarojas@gmail.com', 'horacio');
							$mail->Subject = 'PHPMailer mail() test';
							//$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
							//$mail->AltBody = 'This is a plain-text message body';
							$mail->addAttachment('imagenes/useradd03.png');
							
							// Enviar el mensaje, comprobar si hay errores
							if (!$mail->send()) {echo "Mailer Error: " . $mail->ErrorInfo;} 
							else {echo "Mensaje enviado!" ;}*/
							
							
						
							echo "<div class='inicio'>Archivo Almacenado: \"".$nombrearchivo."\" <a href=".$backupFile." target='_blank' download><img src='imagenes/descargar.png' title='Descargar'/></a></div>";
							//<a href='backups/db-backup-".$dbname."-".date("Ymd-His", time()).".sql' target='_blank'>".$outputDir."</a>
						}
						else {echo "<div class='inicio'>Copia de Seguridad Resultado: <img src='imagenes/alert.png'></div>";}
						mysql_close($db);
					}
				?> 
			</div> 
        </form>  
	</body>
</html>