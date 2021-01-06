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
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>        
        <title>::Spid - administraci&oacute;n</title>
        <link rel="shortcut icon" href="favicon.ico"/>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
        <script>
			function cargarfuncion(){document.form2.oculto.value="2";document.form2.submit();}
		</script>
        <?php titlepag();?>
        <style type="text/css">
			.stconsola
			{
				font-family:andale mono,courier,monospace;
				height:200px;
				width:100%;
				font-size:12px;
				padding:4px;
				border:1px solid #666;
				border-bottom:1px solid #ccc;
				border-right:1px solid #ccc;margin-bottom:2px;
			}
		</style>
    </head>
	<body>
    	<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
        	<tr><script>barra_imagenes("adm");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("adm");?></tr>
    		<tr class="cinta">
  				<td colspan="3" class="cinta"><a class="mgbt"><img src="imagenes/add2.png"/></a><a class="mgbt"><img src="imagenes/guardad.png"/></a><a class="mgbt"><img src="imagenes/buscad.png"/></a><a href="#" onClick="mypop=window.open('adm-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
         	</tr>  
		</table>
		<form name="form2" method="post" >
        	<?php if($_POST[oculto]==""){$_POST[oculto]="1";}?>
            <table class="inicio">
                <tr>
                    <td colspan="4" class="titulos" style='width:93%'>.:Consola SQL:.</td>
                    <td class="cerrar" style='width:7%'><a href="adm-principal.php">Cerrar</a></td>
                </tr>
                <tr>
                	<td style="width:50%;">C&oacute;digo SQL</td>
                    <td>Resultado</td>
                </tr>
                <tr>
                    <td>
                        <textarea class="stconsola" name="consolasql" id="consolasql" rows="0" cols="0" ><?php echo $_POST[consolasql];?></textarea><br/>
                        <button type="button" onClick="cargarfuncion();">Ejecutar SQL</button>
                        <input type="hidden" name="oculto" id="oculto" value="<?php echo $_POST[oculto];?>">
                    </td>
                    <td>
                         <textarea class="stconsola" name="cresultados" id="cresultados" rows="0" cols="0" readonly><?php echo $_POST[cresultados];?></textarea><br/>
                         <input style="visibility:hidden;">
                    </td>
                </tr>
            </table>
            <?php
				if($_POST[oculto]=="2")
				{
					$no_permitidas= array ("'",'"',"`");
					$permitidas= array ("\'","\"","\`");
					$sentenciasql=explode(";", $_POST[consolasql]);
					$numsentencias=count($sentenciasql)-1;
					for($xp=0;$xp<$numsentencias;$xp++) 
					{
						$sqlr=$sentenciasql[$xp];
						$sqlr2=str_replace($no_permitidas, $permitidas ,$sqlr);
						if(!mysql_query($sqlr,$linkbd))
						{
							$nomerror=str_replace($no_permitidas, $permitidas ,mysql_error($linkbd));
							$resultado="Semtencia: ".str_replace("\r\n"," ",$sqlr2)."\\nError No: ".mysql_errno($linkbd)."\\nDescripción: $nomerror\\n\\n";
						}
						else
						{
							$sentencia=explode(' ',$sqlr);
							switch (strtolower($sentencia[0])) 
							{
								case "insert":	$condescrip="La información se agregó correctamente a la tabla";break;
								case "create":	if(strtolower($sentencia[1])=="table"){$condescrip="La tabla se creó correctamente";}	
												else{$condescrip="La base de datos se creó correctamente";}break;
								case "update":	$condescrip="La información se actualizo correctamente a la tabla";break;
								case "select":	$resp = mysql_query($sqlr,$linkbd);
												$numlineas=mysql_num_rows($resp);
												if($numlineas==0){$condescrip="No se encontraron resultados en la búsqueda";}
												elseif($numlineas==1){}
												else{}
							}
							$resultado="Semtencia: ".str_replace("\r\n"," ",$sqlr2)."\\nDescripción: $condescrip\\n\\n";
						}
						echo"
						<script>
							document.form2.cresultados.value=document.form2.cresultados.value+'$resultado';
							document.form2.consolasql.value=''; 
							document.form2.oculto.value='1';
							document.getElementById('cresultados').scrollTop=document.getElementById('cresultados').scrollHeight;
						</script>";
					}
				}
			?>
		</form>
    </body>
</html>