<?php 
	header('Cache-control: no-cache, no-store, must-revalidate');
    header('Content-Type: text/html;charset=utf8');
    
	require 'include/comun.php';
    require 'include/funciones.php';
    
	session_start();
	session_destroy();

    date_default_timezone_set("America/Bogota");
    
    $linkbd = conectar_v7();
    
    error_reporting(E_ALL);
    
	ini_set('display_errors', '1');
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="utf-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: FINANCIERO</title>

		<link href="css/css2.css<?php /*echo date('d_m_Y_h_i_s');*/?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css<?php /*echo date('d_m_Y_h_i_s');*/?>" rel="stylesheet" type="text/css" />
		<link href="css/cssimagenes.css" rel="stylesheet" type="text/css" />

		<style>
			#myVideo {
			  position: fixed;
			  right: 0;
			  bottom: 0;
			  min-width: 100%;
			  min-height: 100%;
			z-index:-100;
            }
			.marquee1
			{
				font-size:12;
				color:black;
				position: absolute;
				width: 80%;
				height: 100%;
				margin: 0;
				text-align: center;
				transform:translateX(100%);
				animation: marquee1 15s linear infinite;
			}
			@keyframes marquee1 
			{
				0% {transform: translateX(100%);}
				100% {transform: translateX(-100%);}
			}
		</style>

		<script type='text/javascript' src = 'js/JQuery/jquery-2.1.4.min.js'></script>
		<script type="text/javascript" src = 'js/JQuery/jquery.ripples.js'></script>

        <script>
            $(document).ready(function() {
                $('body').ripples({
                    resolution: 512,
                    dropRadius: 10,
                    perturbance: 0.04
                });
            });
        </script>

		<script>
			function despliegamodalm(_valor,mensa)
			{
				document.getElementById("bgventanamodalm").style.visibility = _valor;
				if(_valor == "hidden") {document.getElementById('ventanam').src = "";}
				else {document.getElementById('ventanam').src="ventana-mensaje3.php?titulos = "+mensa;}
			}
			var ctrlPressed = false;
			var tecla01 = 16, tecla02 = 66;
			$(document).keydown(function(e){
			if (e.keyCode == tecla01){ctrlPressed = true;}
			if (ctrlPressed && (e.keyCode == tecla02))
			{
				if(document.form1.vistab.value == "hidden")
				{
					document.form1.vistab.value = "visible";
					document.form1.oculto.value = "2";
					document.form1.submit();
				}
				else 
				{
					document.form1.vistab.value = "hidden";
					document.form1.oculto.value ="2"
					document.form1.submit();
				}
			}
			if (e.keyCode == '13'){document.form1.submit();}
			});
			$(document).keyup(function(e){
			if (e.keyCode == tecla01){ctrlPressed = false;}
			});
		</script>

		<?php titlepag();?>
	</head>

	<body>
		<video autoplay muted loop id="myVideo">
			<source src="img/login/acuario.mp4" type="video/mp4">
		</video>
		<form name="form1" method="post" action="login.php"> 
			<?php 
				if(!isset($_POST['oculto']))
				{
					$_POST['vistab'] = 'hidden';
					$archivo = '.env';
					$contenido = file_get_contents($archivo);
					$contenido = explode("\n", $contenido);
                    $_POST['basesfun'] = str_replace('DB_NAME = ', '', $contenido[1]);
                    
				}
			?>
			<div  style="margin: 15px auto; padding-bottom: 30px; padding-top:30px; padding-left: 250px; padding-right: 250px;   width:35%;   ">
				<div><img src="img/ideal_logo_light.png" align="absmiddle" style="width:100%; margin-bottom:10px; margin-top: 50px;"></div>
				<table class="inicio"  style=" padding: 0; position: relative; width: 100%;height: 15.5em; list-style: none; border: 3px solid #eee; border-radius: 5px; box-shadow: 0 0 10px #000; overflow: hidden;">
					<tr>
						<td style="border-bottom:#222 thin dotted; background-color:rgba(44, 198, 219); color:#FFFFFF; width:100%" colspan="3"><image src='img/icons/llaves.png' style=" height:40%; width:12%; "> Inicio de Sesion :.</td>	
					</tr>
					<tr>
						<td style="border-bottom:#222 thin dotted; background-color: rgba(75, 231, 89); text-align:center; width:10%; height:20%" colspan="1"><image src='img/icons/usuario_on.png' style=" height:20%; width:60%;"></td>
						<td style="border-bottom:#222 thin dotted; background-color: #eeeeee;"> Usuario :.</td> 
						<td style="border-bottom:#222 thin dotted; text-align:center"><input type="text" name="user" id="user" value="<?php if(isset($_POST['user'])) echo $_POST['user'];?>" style="width:65%; height:90%"/></td>
					</tr>
					<tr>
						<td style="border-bottom:#222 thin dotted; background-color: rgba(75, 231, 89); text-align:center; width:10%; height:20%" colspan="1"><image src='img/icons/candado.png' style=" height:16%; width:50%;"></td> <td style="border-bottom:#222 thin dotted; background-color: #CCCCCC;">Contraseña :.</td>
						<td style=" text-align:center;border-bottom:#222 thin dotted;"><input type="password" name="pass" id="pass" value="<?php if(isset($_POST['pass'])) echo $_POST['pass'];?>" style="width:65%; height:90%" /></td>
					</tr>
					<tr>
						<td colspan="3" style="padding-bottom:5px; text-align: center;" ><em class="botonflecha" onClick="document.form1.submit();">Aceptar</em></td>
					</tr>
				</table>
				<input type="hidden" name="vistab" id="vistab" value="<?php if(isset($_POST['vistab'])){ echo $_POST['vistab']; }?>"/>
				<table class="inicio"  style="visibility: <?php if(isset($_POST['vistab'])){ echo $_POST['vistab']; }?>;">
					<tr>
						<td>
							<select name="basesfun" id="basesfun">
								<?php
                                    $sqlr = "SHOW DATABASES";
                                    
                                    $resp = mysqli_query($linkbd,$sqlr);


									while ($row = mysqli_fetch_row($resp)) 
									{
                                        if(isset($_POST['basesfun']))
                                        {
                                            if($row[0] == $_POST['basesfun'])
                                                echo '<option value="'.$row[0].'" selected>'.$row[0].'</option>';
                                                continue;
                                        }

                                        echo '<option value = "'.$row[0].'">'.$row[0].'</option>';
									}
								?>
							</select>
							<input type="button" name="bcambio" id="bcambio" value="Cambio de Base" onClick="document.form1.oculto.value='4'; document.form1.submit();"/>
						</td>
					</tr>
				</table>
				<br>
			</div>
			<div class="inicio" style="position: fixed;bottom: 0;left: 0px;margin: 0px; width:100%; height: 3%; text-align: right"><h3 class='marquee1'>Este Software es de Propiedad de IDEAL 10 SAS, su uso debe ser autorizado</h3></div>
			<div style="margin-top:7%;">
				<div id="bgventanamodalm" class="bgventanamodalm">
					<div id="ventanamodalm" class="ventanamodalm">
						<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;" ></IFRAME>
					</div>
				</div>
				<input type="hidden" name="oculto" id="oculto" value="1"/>
				
				<?php
                    if(isset($_POST['oculto']))
                        if (isset($_POST['user']) && isset($_POST['pass']) && $_POST['oculto'] == '1')
                        {
                            $valap = validasusuarioypass($_POST['user'], $_POST['pass']);

                            if ($valap == "")
                            {
                                echo "<script>despliegamodalm('visible','Error el Usuario o la Contraseña no son correctos');</script>";
                            }
                            else
                            {
                                echo "<script>document.form1.action='principal.php';document.form1.submit();</script>";
                            }
                        }
                        else if($_POST['user'] == '' && $_POST['oculto'] == '1')
                        {
                            echo "<script>despliegamodalm('visible','Debe Ingresar Nombre del Usuario');</script>";
                        }
                        else if($_POST['oculto'] == '1')
                        {
                            echo "<script>despliegamodalm('visible','Debe Ingresar La Clave Asignada');</script>";
                        }
				?>
			</div>
			<?php
                if(isset($_POST['oculto']))
                    if($_POST['oculto'] == '4')
                    {
                        $archivo = 'include/comun.php';
                        
                        $contenido = file_get_contents($archivo);
                        $contenido = explode("\n", $contenido);

                        $_POST['basesfun'] = preg_replace('/\r/', null, $_POST['basesfun']);

                        $contenido[17] = "\t".'$datin[0] = \''.$_POST['basesfun'].'\';'."\t\t".'// Nombre de la base';
                        
                        $contenido = implode("\n",$contenido);
                        
                        $abrir = fopen($archivo,'w');
                        
                        fwrite($abrir,$contenido);
                        fclose($abrir);
                        
                        $archivo = '.env';
                        
                        $contenido = file_get_contents($archivo);
                        $contenido = explode("\n",$contenido);
                        
                        $contenido[1] = 'DB_NAME='.$_POST['basesfun'];
                        
                        $contenido = implode("\n",$contenido);
                        
                        $abrir = fopen($archivo,'w');
                        
                        fwrite($abrir,$contenido);
                        fclose($abrir);
                        
                        echo '<script>location.href="login.php"</script>';
                    }
			?>
		</form>
	</body>
</html>
