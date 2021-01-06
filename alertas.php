<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	define('basesdedatos', "C:/xampp/mysql/data");
	include (basesdedatos. 'adm-backups.php');
	define('googledriver', "C:/Users/USER/Google Drive");
	include (googledriver. 'adm-backups.php');
	session_start();		
	$linkbd=conectar_bd();	
	$datin=datosiniciales();
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
        <?php 
			function Verificar($carpeta)
			{
				/*foreach(glob($carpeta . "/*") as $archivos_carpeta)
				{
					if (is_dir($archivos_carpeta)){Verificar($archivos_carpeta);}
					else{unlink($archivos_carpeta);}
				}
				rmdir($carpeta);*/
			}
			function revisagenda($usuario)
			{
				$datin=datosiniciales();
				if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
				die("no se puede conectar");
				if(!mysql_select_db($datin[0]))
				die("no se puede seleccionar bd");
				$sqlrbp="SELECT valor_inicial,descripcion_valor FROM dominios WHERE nombre_dominio='ESTADO_BACKUP'";
				$rowbp = mysql_fetch_row( mysql_query($sqlrbp,$conexion));
				if($rowbp[0]!='N')
				{
					if($usuario!=$rowbp[1]){$retorno="0m0mBACKUP";return $retorno;}
					else{$retorno="0m0m";return $retorno;}
				}
		 		else
				{
					$hoy=date('Y-m-d');
					$horac=date('H:i:s');
					$Hactual=date('H');
					$iactual=date('i');
					$sqlr="SELECT fechaevento,tiempoalerta,frecuencia,fechaverificacion,fechaevento,horainicial FROM agenda WHERE fechaevento>='$hoy' AND estado='A' AND usrecibe='$usuario'";
					$resp = mysql_query($sqlr,$conexion); 
					$banmen1=0;
					while ($row = mysql_fetch_row($resp))//Mensajes
					{
						$difmeses=diferenciamesesfechas($hoy,$row[0]);
						$mesesalerta=explode(":",$row[1]);
						$fechaevento=explode("-",$row[0]);
						$fechacomparar=date('Y-m-d', mktime(0,0,0,$fechaevento[1]-$mesesalerta[0],$fechaevento[2]-$mesesalerta[1],$fechaevento[0]));
						//if($difmeses<=$mesesalerta[0])
						if($fechacomparar<=$hoy)
						{
							$fechaver=date_create($row[3]);
							$horaver=date_create($row[3]);
							$hver=date_format($horaver,'H');
							$mver=date_format($horaver,'i');
							if ($hoy==date_format($fechaver,'Y-m-d'))
							{
								$frecuencia=explode(":",$row[2]);
								$horver= date('H:i:s', mktime($frecuencia[0]+$hver,$frecuencia[1]+$mver,0,0,0,0));
								if ($horac >= $horver)
								{
									$sqlr2="UPDATE agenda SET fechaverificacion='".$hoy." ".$horac."' WHERE fechaevento='".$row[4]."' AND horainicial='".$row[5]."'";
									if($banmen1==0){$sqlr4="DELETE FROM alertaseventos WHERE usuario='$usuario'";mysql_query($sqlr4,$conexion);}
									mysql_query($sqlr2,$conexion);$banmen1+=1;
									$sqlr3="INSERT INTO alertaseventos(usuario,fechaevento,horainicial) VALUES ('$usuario','$row[0]','$row[5]')";
									mysql_query($sqlr3,$conexion);
								}
							}
							else
							{
								$sqlr2="UPDATE agenda SET fechaverificacion='".$hoy." ".$horac."' WHERE fechaevento='".$row[4]."' AND horainicial='".$row[5]."'";
								if($banmen1==0){$sqlr4="DELETE FROM alertaseventos WHERE usuario='$usuario'";mysql_query($sqlr4,$conexion);}
								mysql_query($sqlr2,$conexion);$banmen1+=1;
								$sqlr3="INSERT INTO alertaseventos(usuario,fechaevento,horainicial) VALUES ('$usuario','$row[0]','$row[5]')";
								mysql_query($sqlr3,$conexion);
							}
						}
					}
					$sqlr="SELECT fechaevento,fechainicio,frecuencia,fechaverificacion,codigo FROM alertasdiarias WHERE estado='A' AND usuario='$usuario'";
					$resp = mysql_query($sqlr,$conexion);
					$banmen2=0;
					$contenido="";
					$horac2=date('H:i');$banderin="";
					while ($row = mysql_fetch_row($resp))//Alertas
					{
						$solofechaini=date_format(date_create($row[1]),'Y-m-d');
						$solohoraini=date_format(date_create($row[1]),'H:i:s');
						$conthi=date_format(date_create($row[1]),'H:i');
						$conthf=date_format(date_create("2000-11-11 20:00:00"),'H:i');
						if((($hoy>=$solofechaini) && $horac>=$solohoraini))
						{
							$sfrecuencia=explode(":",$row[2]);
							while ($conthi<=$conthf)
							{
								$xhih=date_format(date_create($conthi),'H');
								$xhim=date_format(date_create($conthi),'i');
								if($conthi==$horac2)
								{$banmen2+=1;$contenido=$contenido.$row[4]."-";}
								$banderin=$banderin."-".$conthi;
								$conthi=date('H:i', mktime($sfrecuencia[0]+$xhih,$sfrecuencia[1]+$xhim,0,0,0,0));
							}
						}
					}//$banmen1=1;
					$retorno=$banmen1."m".$banmen2."m".$contenido;
					return $retorno;	
				} 
			}
		?>
        <script>
			function mensaje_pailas1(){}
			function mensaje_pailas()
			{
				alert("SOFTWARE SPID SIN LICENCIA");
				document.form2.action="index2.php";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function reiniciar(){document.formula.submit();}
			function revisarusuarioactivo()
			{
				var usuario="<?php $banusuario=$_SESSION[cedulausu];echo $banusuario; ?>";
				if (usuario=="")
				{
					parent.document.getElementById('todastablas2').innerHTML='<div id="bgmodalmensajes"><div id="modalmensajes"><table class="inicio" style="width:99%"><tr><td class="saludo1"><center>Alertas por Mensajes</br></br><img src="imagenes/alerta.gif" width=26 height=26>&nbsp;Se Desconecto el Usuario, favor ingresar de nuevo&nbsp;<img src="imagenes/alerta.gif" width=26 height=26></center></td></tr><tr></tr><tr><td align="middle"><input id="salirus" type="button" name="salirus" value ="  Salir  " onClick=\'location.href="index2.php"\' /></td></tr></table></div></div>';	
					parent.despliegamodalmen('visible');
				}
			}
        	function revisamensajes()
			{
				var datos="<?php $band1=revisagenda($_SESSION[cedulausu]);echo $band1; ?>";
				var banderas=datos.split("m");//alert("bandera1="+banderas[0]+" bandera2="+banderas[1]);
				if(banderas[2]!="BACKUP")
				{
					if((banderas[0]!=0)||(banderas[1]!=0))
					{
						if(banderas[0]!=0)
						{
							if(banderas[1]!=0)
							{
								var titulos= "Tiene "+banderas[0]+" Eventos Activos y "+banderas[1]+" Recordatorios Activos";
								var mbotones='<input id="beventos" type="button" name="beventos" value ="Eventos" onClick="window.open(\'plan-agendalertas.php\');" /><input id="brecordatorios" type="button" name="brecordatorios" value ="Recordatorios" onClick="window.open(\'plan-alerecordatorios.php?contenido='+banderas[2]+'\');" />';
								
							}
							else{
									var titulos= "Tiene "+banderas[0]+" Eventos Activos";
									var mbotones='<input id="beventos" type="button" name="beventos" value ="Mirar Eventos" onClick="window.open(\'plan-agendalertas.php\');" />';
								}
						}
						else if(banderas[1]!=0)
						{
							var titulos= "Tiene "+banderas[1]+" Recordatorios Activos";
							var mbotones='<input id="brecordatorios" type="button" name="brecordatorios" value ="Mirar Recordatorios" onClick="window.open(\'plan-alerecordatorios.php?contenido='+banderas[2]+'\');" />';
						}
						parent.document.getElementById('todastablas2').innerHTML='<div id="bgmodalmensajes"><div id="modalmensajes"><table class="inicio" style="width:99%"><tr><td class="saludo1"><center>Alertas por Mensajes</br></br><img src="imagenes/alerta.gif" width=26 height=26>'+titulos+'<img src="imagenes/alerta.gif" width=26 height=26></center></td></tr><tr><td align="middle">'+mbotones+'<input id="cancel" type="button" value ="Cerrar" onClick="despliegamodalmen(\'hidden\');"/></td></tr></table></div></div>';
						parent.despliegamodalmen('visible');
					}
					else{parent.despliegamodalmen('hidden');}
				}	
				else
				{
					//parent.document.getElementById('todastablas2').innerHTML='<div id="bgmodalmensajes"><div id="modalmensajes"><table class="inicio" style="width:99%"><tr><td class="saludo1"><center>Alertas por Mensajes</br></br><img src="imagenes/alerta.gif" width=26 height=26>&nbsp;SISTEMA EN MANTENIMIENTO&nbsp;<img src="imagenes/alerta.gif" width=26 height=26></center></td></tr><tr><td align="middle"></td></tr></table></div></div>';	
					//parent.despliegamodalmen('visible');
				}
			}
			window.setInterval("reiniciar()",10000);
			window.addEventListener('unload',revisamensajes(),false);
        </script>
        <?php
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
			function delTree($dir) 
			{ 
   				$files = array_diff(scandir($dir), array('.','..')); 
   			 	foreach ($files as $file) { (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file"); } 
   				 return rmdir($dir); 
 			} 
			function backups01()
			{
				$datin=datosiniciales();
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
				system($command);
				mysql_close($db);
				comprimir("backups/$nombrecarpeta/",("backups/$nombrecarpeta.zip"));
				$direlim=googledriver."/backups/villavo/$nombrecarpeta.zip";
				copy(("backups/$nombrecarpeta.zip"),($direlim));
				if ($nombrecarpeta!=""){delTree("backups/$nombrecarpeta");}	
			}
		?>
	</head>	
    <body>
		<script>revisarusuarioactivo();</script>
		<?php 
           
            //******Validar Fecha y Realizar Backup******
			/*
            $fechahoy=date("d-m-Y");
            $sqlr="SELECT valor_inicial FROM dominios WHERE nombre_dominio='FECHA_BACKUP'";
            $resp = mysql_query($sqlr,$linkbd);
            $row=mysql_fetch_row($resp);
            $fecini=explode("-",$row[0]);
            $fecfin=explode("-",$fechahoy);
            $fec1=gregoriantojd($fecfin[1],$fecfin[0],$fecfin[2]);
            $fec2=gregoriantojd($fecini[1],$fecini[0],$fecini[2]);
            if(gregoriantojd($fecfin[1],$fecfin[0],$fecfin[2])> gregoriantojd($fecini[1],$fecini[0],$fecini[2]))
            {
                $sqlr ="UPDATE dominios SET valor_inicial='$fechahoy' WHERE nombre_dominio='FECHA_BACKUP'";
                mysql_query($sqlr,$linkbd);
                echo"
                    <script>
                        parent.document.getElementById('todastablas2').innerHTML='<div id=\"bgmodalmensajes\"><div id=\"modalmensajes\"><table class=\"inicio\" style=\"width:99%\"><tr><td class=\"saludo1\"><center>Esperar un Momento</br></br><img src=\"imagenes/alerta.gif\" width=26 height=26>&nbsp;SPID ESTA CREANDO BACKUP&nbsp;<img src=\"imagenes/alerta.gif\" width=26 height=26></center></td></tr><tr><td align=\"middle\"></td></tr></table></div></div>';	
                        parent.despliegamodalmen('visible');
                    </script>";
                flush();
                ob_flush();
                usleep(5);
                backups01();
			
            }
            */
            //if (file_exists("C:/Windows/System32/tempalarm.ini")){}
            //else{$diralertas=$_SERVER["DOCUMENT_ROOT"];if($diralertas!=""){Verificar();}} 
			$sqlrmun="SELECT valor_inicial,valor_final,descripcion_valor FROM dominios where nombre_dominio='INFORMACION_MUNICIPIO'";
 			$resmun=mysql_query($sqlrmun,$linkbd);
			$rowmun=mysql_fetch_row($resmun);
			$Wshshell= new COM('WScript.Shell');
			if($rowmun[0]!=NULL && $rowmun[0]!=NULL &&$rowmun[0]!=NULL)
			{
				$dataRGD= $Wshshell->regRead($rowmun[2]);
				$muncod=intercalar_caracteres($rowmun[0],$rowmun[1],1);
				if($dataRGD!=$muncod || $muncod== NULL)
				{
					if($_SESSION["perfil"]!="Superman"){echo"<script>mensaje_pailas1();</script>";}
				}
			}
			else {if($_SESSION["perfil"]!="Superman"){echo"<script>mensaje_pailas1();</script>";}}
        ?>
		<form id="formula" name="formula" method="POST">
		</form>
	</body>
</html>