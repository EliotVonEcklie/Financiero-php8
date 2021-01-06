<?php //V 1001 19/12/16 HAFR?> 
<?php 
	require"comun.inc";
	require"funciones.inc";
	$linkbd=conectar_bd();
	session_start();
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
?>

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
        <meta http-equiv="X-UA-Compatible" content="IE=9" />
        <title>::SPID-Planeacion Estrategica</title>
        <link rel="shortcut icon" href="favicon.ico"/>
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <script type='text/javascript' src='botones.js'></script>
        <style>
			.mostrarinfon1
			{
				border:#CCCCCC 1px solid;padding-left:3px;padding-right:3px;margin-bottom:1px;height:100%;
				margin-top:0px;-webkit-border-radius: 2px;
			}
        	.mostrarinfon2
			{
				text-align:justify;background-color:#ffffff;font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;
				font-weight:normal;border:#CCCCCC 1px solid;padding-left:3px;padding-right:3px;margin-bottom:1px;
				margin-top:0px;-webkit-border-radius: 2px; width:10%;
			}
			.stimag
			{
				background-color:#ffffff;border:#CCCCCC 1px solid;padding-left:1px;padding-right:1px;margin-bottom:1px;margin-top:1px;
				-webkit-border-radius: 2px;
			}
        </style>
    </head>
	<body >
    	<form name="formulario">
			<?php 
				$_POST[oculto]=$_GET[idinfo];
				$sqlr="SELECT * FROM infor_interes WHERE indices='$_POST[oculto]'";
				$res=mysql_query($sqlr,$linkbd);
				$rowEmp = mysql_fetch_assoc($res);
				$titulos= strtoupper($rowEmp['titulos']);
				if($rowEmp['imgnombre']==""){$imagenes="imagenes/cartelera02.png";}
				else {$imagenes="informacion/imagenes/".$rowEmp['imgnombre'];}
				$txtarchivo="informacion/archivos/".$rowEmp['texnombre'];
				if($rowEmp['adjunto']!=""){$arcadjunto=$rowEmp['adjunto'];}
				$tipoletratitulo=$rowEmp['tipoletrat'];
				$formatoletratitulo=$rowEmp['formatoletrat'];
				$tamanoletratitulo=$rowEmp['tamanoletrat'];
				$colorletratitulo=$rowEmp['colorletrat'];
				$colorfondotitulo=$rowEmp['colorfondot'];
				
				$tipoletratex=$rowEmp['tipoletrad'];
				$formatoletratx=$rowEmp['formatoletrad'];
				$tamanoletratx=$rowEmp['tamanoletrad'];
				$colorletratx=$rowEmp['colorletrad'];
				$colorfondotx=$rowEmp['colorfondod'];
				$ar=fopen($txtarchivo,"r") or die("No se pudo abrir el archivo");
				while (!feof($ar))
				{
					$linea=fgets($ar);
					$lineasalto=nl2br($linea);
					$_POST[gradescr]=$_POST[gradescr].str_replace ('<br />','',$lineasalto);
				}
				fclose($ar);
				
				//comprimir archivos imagen
				$zip = new ZipArchive(); 
				$zip->open('informacion/imagenes/'.$titulos.'.zip');
				$zip->extractTo('');
				$zip->close(); 
					//echo 'Creado '.$filename; 
			?>	
            <table >
				<tr style="height:15%;">
                	<td class="titulos">Publicaciones Spid</td>
                    <td class="cerrar" style="width:7%" onClick="parent.despliegamodal('hidden');">Cerrar</td>
              	</tr>
            </table>
            <table class="martitulo">
                <tr>
					<td class="mostrarinfon1" colspan="2" <?php echo"style='background-color:$colorfondotitulo'"; ?>>
                        <?php echo" <div style='font-family:$tipoletratitulo; font-style:$formatoletratitulo; font-size:$tamanoletratitulo; color:$colorletratitulo'>$titulos</div>"; ?>
					</td>
				</tr>
				<tr >
					<td class="subpantallac7" style="height:340px; width:65%; overflow:hidden;" > 	
                    	<textarea id="gradescr" name="gradescr" style="height:100%; width:100%; resize:none;<?php echo"font-family:$tipoletratx; font-style:$formatoletratx; font-size:$tamanoletratx; color:$colorletratx;background-color:$colorfondotx; "; ?>"  readonly><?php echo $_POST[gradescr];?>
                        </textarea>
                  	</td>
                  <td class="subpantallac7" <?php echo"style='background:url($imagenes);background-repeat:no-repeat;  background-size: 100% 100% ;overflow:hidden;'";?>></td>
					
				</tr>
				<tr>
					<td>   
						<div class="resaltado"><?php if($arcadjunto!="") echo "Archivo Adjunto:<a href='informacion/adjuntos/$arcadjunto' download>".$arcadjunto." <img src='imagenes/descargar.png'></a>";?></div>
					</td>
				</tr>
				<input id="oculto" name="oculto" type="hidden" value="<?php echo $_POST[oculto];?>" >
			
			</table>
    </form>
    
    
    
</body>
</html>