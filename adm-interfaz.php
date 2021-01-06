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
					case "1":	document.getElementById('oculto').value="2";
								document.form2.submit();break;
				}
			}
			function funcionmensaje(){document.location.href = "";}
			function guardar()
			{
				//var validacion01=document.getElementById('nombre').value;
				//var validacion02=document.getElementById('valor').value;
				//if (validacion01.trim()!='' && validacion02.trim()!='' )
				{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
			//	else{despliegamodalm('visible','2','Faltan datos para completar el registro');}
			}
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
	</head>
	<body>
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
        	<input type="hidden" name="dirimag1" id="dirimag1" value="<?php echo $_POST[dirimag1];?>" onChange="document.form2.submit();"/>
            <input type="hidden" name="dirimag2" id="dirimag2" value="<?php echo $_POST[dirimag2];?>" onChange="document.form2.submit();"/>
            <input type="hidden" name="dirimag3" id="dirimag3" value="<?php echo $_POST[dirimag3];?>" onChange="document.form2.submit();"/>
            <input type="hidden" name="dirimag4" id="dirimag4" value="<?php echo $_POST[dirimag4];?>" onChange="document.form2.submit();"/>
            <input type="hidden" name="dirimag5" id="dirimag5" value="<?php echo $_POST[dirimag5];?>" onChange="document.form2.submit();"/>
            <input type="hidden" name="dirimag6" id="dirimag6" value="<?php echo $_POST[dirimag6];?>" onChange="document.form2.submit();"/>
            <input type="hidden" name="dirimag7" id="dirimag7" value="<?php echo $_POST[dirimag7];?>" onChange="document.form2.submit();"/>
            <input type="hidden" name="dirimag8" id="dirimag8" value="<?php echo $_POST[dirimag8];?>" onChange="document.form2.submit();"/>
			<?php
                if ($_POST[oculto]=="")
                {
					$usersave=$_SESSION[cedulausu];
					$rutaad="informacion/temp/us$usersave/";
					if(!file_exists($rutaad)){mkdir ($rutaad);}
					else {eliminarDir();mkdir ($rutaad);}
					$sqlr="SELECT razonsocial FROM configbasica";
                    $row =mysql_fetch_row(mysql_query($sqlr,$linkbd));
					$_POST[entidad]=$row[0];
					$sqlr="SELECT * FROM interfaz01 ";
                    $resp = mysql_query($sqlr,$linkbd);
					$ntr = mysql_num_rows($resp);
                    $row =mysql_fetch_row($resp);
					if($ntr==0 || $row[0]==""){$_POST[lema]="Ingresar Lema de la Entidad";} 
					else {$_POST[lema]=$row[0];}
					if($ntr==0 || $row[1]==""){$_POST[color1]="#000000";}
					else {$_POST[color1]=$row[1];}
					if($ntr==0 || $row[2]==""){$_POST[color2]="#ffffff";}
					else {$_POST[color2]=$row[2];}
					if($ntr==0 || $row[3]==""){$_POST[tple01]="1";}
					else{$_POST[tple01]=$row[3];}
					if($ntr==0 || $row[4]==""){$_POST[flle01]="normal";}
					else {$_POST[flle01]=$row[4];}
					if($ntr==0 || $row[5]==""){$_POST[ttle01]="100";}
					else {$_POST[ttle01]=$row[5];}
					if($ntr==0 || $row[6]==""){$_POST[colorl1]="#000000";}
					else {$_POST[colorl1]=$row[6];}
					if($ntr==0 || $row[7]==""){$_POST[tple02]="1";}
					else{$_POST[tple02]=$row[7];}
					if($ntr==0 || $row[8]==""){$_POST[flle02]="normal";}
					else {$_POST[flle02]=$row[8];}
					if($ntr==0 || $row[9]==""){$_POST[ttle02]="100";}
					else {$_POST[ttle02]=$row[9];}
					if($ntr==0 || $row[10]==""){$_POST[colorl2]="#000000";}
					else {$_POST[colorl2]=$row[10];}
					if($ntr!=0 || $row[11]!=""){$_POST[nimagen1]=$row[11];}
					else {$_POST[nimagen1]="";}
					if($ntr!=0 || $row[12]!=""){$_POST[nimagen2]=$row[12];}
					else {$_POST[nimagen2]="";} 
					if ($_POST[nimagen1]!="")
					{echo "<script>document.getElementById('dirimag1').value='imagenes/$_POST[nimagen1]';</script>";}
					else{echo "<script>document.getElementById('dirimag1').value='imagenes/photo01.png';</script>";}
					if ($_POST[nimagen2]!="")
					{echo "<script>document.getElementById('dirimag2').value='imagenes/$_POST[nimagen2]';</script>";}
					else{echo "<script>document.getElementById('dirimag2').value='imagenes/photo01.png';</script>";}
					$_POST[imaini1]="0";
					$_POST[imaini2]="0";
					$sqlr="SELECT valor_final,descripcion_valor FROM dominios WHERE nombre_dominio='FOTOS_PORTADA' ORDER BY valor_inicial";
                    $resp = mysql_query($sqlr,$linkbd);
					$contips=3;
					while ($row =mysql_fetch_row($resp)) 
					{
						$nomimagenes1="dirimag$contips";
						$nomimagenes2="nimagen$contips";
						$nomimagenes3="imaini$contips";
						$_POST[$nomimagenes3]="0";
						if($row[0]!=0)
						{
							$_POST[$nomimagenes2]=$row[1];
							echo "<script>document.getElementById('$nomimagenes1').value='imagenes/$_POST[$nomimagenes2]';</script>";
						}
						else
						{
							$_POST[$nomimagenes2]="";
							echo "<script>document.getElementById('$nomimagenes1').value='imagenes/photo01.png';</script>";
						}
						$contips=$contips+1;
					}
					$_POST[tabgroup1]=1;
					
                }
				//*****************************************************************
                switch($_POST[tabgroup1])
                {
                    case 1:	$check1='checked';break;
                    case 2:	$check2='checked';break;
                }
            ?>
            <div class="tabsmeci"  style="height:76.5%; width:99.6%">
            	<div class="tab">
             		<input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
         			<label for="tab-1">Configuraci&oacute;n Logos</label>
           			<div class="content" style="overflow:hidden;">
                        <table class="inicio" align="center" >
                            <tr>
                                <td class="titulos" colspan="5">:: Configuraci&oacute;n Logos</td>
                                <td class='cerrar' style="width:7%;"><a href='adm-principal.php'>Cerrar</a></td>
                            </tr>
                            <tr >
                                <td class="tamano01" style="width:3.5cm">:&middot; Entidad:</td>
                                <td colspan="3"><input type="text" name="entidad" id="entidad" style="width:100%;text-transform:uppercase;" value="<?php echo $_POST[entidad];?>" class="tamano02" readonly/></td>
                                <td rowspan="8" style="width:50%;"> 
                                    <div class="mfoto02">
                                        <span style="background:url(imagenes/flescudo.png);width:300px;height:25px;background-repeat:no-repeat; background-size:contain;left:80px;top:-13px;"></span>
                                        <img id="imagencm1" src="imagenes/usuario_on.png" style="height:250px; width:250px;"  />
                                    </div>
                                    <div class="mfoto02">
                                        <span  style="background:url(imagenes/fllogo.png);width:300px;height:25px;background-repeat:no-repeat; background-size:contain;left:70px;top:-13px;"></span>
                                    <img id="imagencm2" src="imagenes/usuario_on.png" style="height:250px; width:250px;" />
                                    </div>
                                </td>
                            </tr>
                            <tr >
                                <td class="tamano01" style="width:3.5cm">:&middot; Lema: </td>
                                <td colspan="3"><input type="text" name="lema" id="lema" style="width:100%" value="<?php echo $_POST[lema];?>" class="tamano02" onChange="document.form2.submit();"/></td>
                            </tr>
                            <tr >
                                <td class="tamano01" style="width:3.5cm">:&middot; Color Primario: </td>
                                <td><input type="color" name="color1" id="color1" style="width:100%" value="<?php echo $_POST[color1];?>" class="tamano02" onChange="document.form2.submit();"/></td>
                            
                                <td class="tamano01" style="width:3.5cm">:&middot; Color Secundario: </td>
                                <td><input type="color" name="color2" id="color2" style="width:100%" value="<?php echo $_POST[color2];?>" class="tamano02" onChange="document.form2.submit();"/></td>
                            </tr>
                            <tr >
                                <td class="tamano01" style="width:3.5cm">:&middot; Formato Entidad: </td>
                                <td colspan="3">
                                    <select name="tple01" id="tple01" class="tamano02" style="width:40%;float:left;text-transform:uppercase;" onChange="document.form2.submit();">
                                        <?php
                                            $sqlr="SELECT * FROM dominios WHERE nombre_dominio='TIPOS_DE_LETRA' ORDER BY length(valor_inicial),valor_inicial ASC";
                                            $resp = mysql_query($sqlr,$linkbd);
                                            while ($row =mysql_fetch_row($resp))
                                            {
                                                if($row[0]==$_POST[tple01])
                                                {
                                                    echo "<option style='font-family:$row[2];' value='$row[0]' SELECTED>$row[1]</option>";
                                                    $_POST[tletra1]=$row[2];
                                                }
                                                else{echo "<option style='font-family:$row[2];' value='$row[0]'>$row[1]</option>";}
                                            }
                                        ?>
                                    </select>
                                    <select name="flle01" id="flle01" class="tamano02" style="width:22%;float:left;margin-left:2px;text-transform:uppercase; font-style:" onChange="document.form2.submit();">
                                        <option value="normal" style="font-style:normal;" <?php if($_POST[flle01]=="normal"){echo "SELECTED";}?>>Normal</option>
                                        <option value="italic" style="font-style:italic;"<?php if($_POST[flle01]=="italic"){echo "SELECTED";}?>>Italica</option>
                                        <option value="oblique" style="font-style:oblique;"<?php if($_POST[flle01]=="oblique"){echo "SELECTED";}?>>Cursiva</option>
                                    </select>
                                    <input type="number" name="ttle01" id="ttle01" value="<?php echo $_POST[ttle01];?>" class="tamano02" onChange="document.form2.submit();" min="50" max="250" step="10" style=" width:10%;float:left; margin-left:2px"/>
                                   
                                <input type="color" name="colorl1" id="colorl1" style=" width:18%;float:left; margin-left:2px" value="<?php echo $_POST[colorl1];?>" class="tamano02" onChange="document.form2.submit();"/></td>
                            </tr>
                             <tr >
                                <td class="tamano01" style="width:3.5cm">:&middot; Formato Lema: </td>
                                <td colspan="3">
                                    <select name="tple02" id="tple02" class="tamano02" style="width:40%;float:left;text-transform:uppercase;" onChange="document.form2.submit();">
                                        <?php
                                            $sqlr="SELECT * from dominios WHERE nombre_dominio='TIPOS_DE_LETRA' ORDER BY length(valor_inicial),valor_inicial ASC";
                                            $resp = mysql_query($sqlr,$linkbd);
                                            while ($row =mysql_fetch_row($resp))
                                            {
                                                if($row[0]==$_POST[tple02])
                                                {
                                                    echo "<option style='font-family:$row[2];' value='$row[0]' SELECTED>$row[1]</option>";
                                                    $_POST[tletra2]=$row[2];
                                                }
                                                else{echo "<option style='font-family:$row[2];' value='$row[0]'>$row[1]</option>";}
                                            }
                                        ?>
                                    </select>
                                    <select name="flle02" id="flle02" class="tamano02" style="width:22%;float:left;margin-left:2px;text-transform:uppercase; font-style:" onChange="document.form2.submit();">
                                        <option value="normal" style="font-style:normal;" <?php if($_POST[flle02]=="normal"){echo "SELECTED";}?>>Normal</option>
                                        <option value="italic" style="font-style:italic;"<?php if($_POST[flle02]=="italic"){echo "SELECTED";}?>>Italica</option>
                                        <option value="oblique" style="font-style:oblique;"<?php if($_POST[flle02]=="oblique"){echo "SELECTED";}?>>Cursiva</option>
                                    </select>
                                    <input type="number" name="ttle02" id="ttle02" value="<?php echo $_POST[ttle02];?>" class="tamano02" onChange="document.form2.submit();" min="50" max="250" step="10" style=" width:10%;float:left; margin-left:2px"/>
                                   
                                <input type="color" name="colorl2" id="colorl2" style=" width:18%;float:left; margin-left:2px" value="<?php echo $_POST[colorl2];?>" class="tamano02" onChange="document.form2.submit();"/></td>
                            </tr>
                            <tr>
                                <td class="tamano01" style="width:3.5cm;">:&middot; Escudo:</td>
                                <td colspan="3">
                                    <input type="text" name="nimagen1" id="nimagen1"  style="width:95%" value="<?php echo $_POST[nimagen1]?>" class="tamano02"  readonly/>
                                     <div class='upload' style="height:24px;float:right !important;" > 
                                        <input type="file" name="adnimagen1" id="adnimagen1" value="<?php echo $_POST[adnimagen1];?>"  onChange="document.form2.submit();" title="Cargar Imagen" />
                                        <img src='imagenes/upload01.png' style="width:23px"/> 
                                     </div> 
                                 </td>
                            </tr>
                            <tr>
                                <td class="tamano01" style="width:3.5cm;">:&middot; Imagen Gobierno :</td>
                                <td colspan="3">
                                    <input type="text" name="nimagen2" id="nimagen2"  style="width:95%" value="<?php echo $_POST[nimagen2]?>" class="tamano02"  readonly/>
                                     <div class='upload' style="height:24px;float:right !important;" > 
                                        <input type="file" name="adnimagen2" id="adnimagen2" value="<?php echo $_POST[adnimagen2];?>"  onChange="document.form2.submit();" title="Cargar Imagen" />
                                        <img src='imagenes/upload01.png' style="width:23px"/> 
                                     </div> 
                                 </td>
                            </tr>
                            <input type="hidden" name="tletra1" id="tletra1" value="<?php echo $_POST[tletra1];?>"/>
                            <tr>
                                <td class="tamano01" style="width:3.5cm; >">:&middot; Vista previa :</td>
                                <td colspan="3" style="-webkit-max-height:60px;">
                                    <table style="width:100%;height:100%; background: -webkit-linear-gradient(<?php echo "$_POST[color1],$_POST[color2]";?>);">
                                        <tr>
                                            <td style="font-family:<?php echo $_POST[tletra1];?>;font-style:<?php echo $_POST[flle01];?>;text-align:center;font-size:<?php echo "$_POST[ttle01]%";?>;color:<?php echo $_POST[colorl1];?>"><?php echo $_POST[entidad];?></td>
                                        </tr>
                                        <tr>
                                            <td style="font-family:<?php echo $_POST[tletra2];?>;font-style:<?php echo $_POST[flle02];?>;text-align:center;font-size:<?php echo "$_POST[ttle02]%";?>;color:<?php echo $_POST[colorl2];?>"><?php echo $_POST[lema];?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
           			</div>
            	</div>
                <div class="tab">
                    <input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?> >
                    <label for="tab-2">Presentaci&oacute;n</label>
                    <div class="content" style="overflow:hidden;">
                    	 <table class="inicio" align="center" >
                            <tr>
                                <td class="titulos" colspan="5">:: Imagenes Presentaci&oacute;n</td>
                                <td class='cerrar' style="width:7%;"><a href='adm-principal.php'>Cerrar</a></td>
                            </tr>
                            <tr>
                                <td class="tamano01" style="width:3.5cm;">:&middot; Imagen 1:</td>
                                <td colspan="3" style="width:40%;">
                                    <input type="text" name="nimagen3" id="nimagen3"  style="width:95%" value="<?php echo $_POST[nimagen3]?>" class="tamano02"  readonly/>
                                     <div class='upload' style="height:24px;float:right !important;" > 
                                        <input type="file" name="adnimagen3" id="adnimagen3" value="<?php echo $_POST[adnimagen3];?>"  onChange="document.form2.submit();" title="Cargar Imagen" />
                                        <img src='imagenes/upload01.png' style="width:23px"/> 
                                     </div> 
                                 </td>
                                 <td rowspan="3">
                                 	<div class="mfoto03" style="margin-right:10px;">
                                        <span></span>
                                        <img id="imagencm3" src="imagenes/photo01.png" style="height:75px; width:110px;"  />
                                    </div>
                                    <div class="mfoto03" style="margin-right:10px;">
                                        <span></span>
                                    <img id="imagencm4" src="imagenes/photo01.png" style="height:75px; width:110px;" />
                                    </div>
                                    <div class="mfoto03">
                                        <span></span>
                                    <img id="imagencm5" src="imagenes/photo01.png" style="height:75px; width:110px;" />
                                    </div>
                                 </td>
                            </tr>
                            <tr>
                                <td class="tamano01" style="width:3.5cm;">:&middot; Imagen 2:</td>
                                <td colspan="3" style="width:40%;">
                                    <input type="text" name="nimagen4" id="nimagen4"  style="width:95%" value="<?php echo $_POST[nimagen4]?>" class="tamano02"  readonly/>
                                     <div class='upload' style="height:24px;float:right !important;" > 
                                        <input type="file" name="adnimagen4" id="adnimagen4" value="<?php echo $_POST[adnimagen4];?>"  onChange="document.form2.submit();" title="Cargar Imagen" />
                                        <img src='imagenes/upload01.png' style="width:23px"/> 
                                     </div> 
                                 </td>
                            </tr>
                             <tr>
                                <td class="tamano01" style="width:3.5cm;">:&middot; Imagen 3:</td>
                                <td colspan="3" style="width:40%;">
                                    <input type="text" name="nimagen5" id="nimagen5"  style="width:95%" value="<?php echo $_POST[nimagen5]?>" class="tamano02"  readonly/>
                                     <div class='upload' style="height:24px;float:right !important;" > 
                                        <input type="file" name="adnimagen5" id="adnimagen5" value="<?php echo $_POST[adnimagen5];?>"  onChange="document.form2.submit();" title="Cargar Imagen" />
                                        <img src='imagenes/upload01.png' style="width:23px"/> 
                                     </div> 
                                 </td>
                            </tr>
                            <tr>
                                <td class="tamano01" style="width:3.5cm;">:&middot; Imagen 4:</td>
                                <td colspan="3" style="width:40%;">
                                    <input type="text" name="nimagen6" id="nimagen6"  style="width:95%" value="<?php echo $_POST[nimagen6]?>" class="tamano02"  readonly/>
                                     <div class='upload' style="height:24px;float:right !important;" > 
                                        <input type="file" name="adnimagen6" id="adnimagen6" value="<?php echo $_POST[adnimagen6];?>"  onChange="document.form2.submit();" title="Cargar Imagen" />
                                        <img src='imagenes/upload01.png' style="width:23px"/> 
                                     </div> 
                                 </td>
                                 <td rowspan="3">
                                 	<div class="mfoto03" style="margin-right:10px;">
                                        <span></span>
                                        <img id="imagencm6" src="imagenes/photo01.png" style="height:75px; width:110px;"  />
                                    </div>
                                    <div class="mfoto03" style="margin-right:10px;">
                                        <span></span>
                                    	<img id="imagencm7" src="imagenes/photo01.png" style="height:75px; width:110px;" />
                                    </div>
                                    <div class="mfoto03">
                                        <span></span>
                                    	<img id="imagencm8" src="imagenes/photo01.png" style="height:75px; width:110px;" />
                                    </div>
                                 </td>
                            </tr>
                            <tr>
                                <td class="tamano01" style="width:3.5cm;">:&middot; Imagen 5:</td>
                                <td colspan="3" style="width:40%;">
                                    <input type="text" name="nimagen7" id="nimagen7"  style="width:95%" value="<?php echo $_POST[nimagen7]?>" class="tamano02"  readonly/>
                                     <div class='upload' style="height:24px;float:right !important;" > 
                                        <input type="file" name="adnimagen7" id="adnimagen7" value="<?php echo $_POST[adnimagen7];?>"  onChange="document.form2.submit();" title="Cargar Imagen" />
                                        <img src='imagenes/upload01.png' style="width:23px"/> 
                                     </div> 
                                 </td>
                            </tr>
                            <tr>
                                <td class="tamano01" style="width:3.5cm;">:&middot; Imagen 6:</td>
                                <td colspan="3" style="width:40%;">
                                    <input type="text" name="nimagen8" id="nimagen8"  style="width:95%" value="<?php echo $_POST[nimagen8]?>" class="tamano02"  readonly/>
                                     <div class='upload' style="height:24px;float:right !important;" > 
                                        <input type="file" name="adnimagen8" id="adnimagen8" value="<?php echo $_POST[adnimagen8];?>"  onChange="document.form2.submit();" title="Cargar Imagen" />
                                        <img src='imagenes/upload01.png' style="width:23px"/> 
                                     </div> 
                                 </td>
                            </tr>
                        </table>
                    </div>
               	</div>
            </div>
            <input name="oculto" type="hidden" id="oculto" value="1">
            <input type="hidden" name="imaini1" id="imaini1" value="<?php echo $_POST[imaini1];?>"/>
            <input type="hidden" name="imaini2" id="imaini2" value="<?php echo $_POST[imaini2];?>"/>
            <input type="hidden" name="imaini3" id="imaini3" value="<?php echo $_POST[imaini3];?>"/>
            <input type="hidden" name="imaini4" id="imaini4" value="<?php echo $_POST[imaini4];?>"/>
            <input type="hidden" name="imaini5" id="imaini5" value="<?php echo $_POST[imaini5];?>"/>
            <input type="hidden" name="imaini6" id="imaini6" value="<?php echo $_POST[imaini6];?>"/>
            <input type="hidden" name="imaini7" id="imaini7" value="<?php echo $_POST[imaini7];?>"/>
            <input type="hidden" name="imaini8" id="imaini8" value="<?php echo $_POST[imaini8];?>"/>
            <script>
				//function cargar_imagen
    			function preloader() 
				{
					if (document.getElementById) 
					{
						
							document.getElementById('imagencm1').src=document.getElementById('dirimag1').value+"?=<?php echo Date('U');?>";
							document.getElementById('imagencm2').src=document.getElementById('dirimag2').value+"?=<?php echo Date('U');?>";
							document.getElementById('imagencm3').src=document.getElementById('dirimag3').value+"?=<?php echo Date('U');?>";
							document.getElementById('imagencm4').src=document.getElementById('dirimag4').value+"?=<?php echo Date('U');?>";
							document.getElementById('imagencm5').src=document.getElementById('dirimag5').value+"?=<?php echo Date('U');?>";
							document.getElementById('imagencm6').src=document.getElementById('dirimag6').value+"?=<?php echo Date('U');?>";
							document.getElementById('imagencm7').src=document.getElementById('dirimag7').value+"?=<?php echo Date('U');?>";
							document.getElementById('imagencm8').src=document.getElementById('dirimag8').value+"?=<?php echo Date('U');?>";
						
					}
				}
				function addLoadEvent(func) 
				{
					var oldonload = window.onload;
					if (typeof window.onload != 'function') {window.onload = func;} 
					else 
					{
						window.onload = function() 
						{
							if (oldonload) {oldonload();}
							func();
						}
					}
				}
				addLoadEvent(preloader);
    		</script>
            <?php
				if ($_POST[tabgroup1]=="1")
				{
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
								document.getElementById('dirimag1').value='$destino';
								document.getElementById('dirimag1').scr='$destino';
								document.getElementById('imaini1').value='2';
							</script>";
						}
						else
						{
							echo"<script>document.getElementById('nimagen1').value='';
							despliegamodalm('visible','2','Error Al Cargar el Archivo');</script>";
						} 
					}
					if (is_uploaded_file($_FILES['adnimagen2']['tmp_name'])) 
					{
						$archivo = $_FILES['adnimagen2']['name'];
						$tipo = $_FILES['adnimagen2']['type'];
						$usersave=$_SESSION[cedulausu];
						$destino = "informacion/temp/us$usersave/".$archivo;
						if (copy($_FILES['adnimagen2']['tmp_name'],$destino))
						{
							echo"
							<script>
								document.getElementById('nimagen2').value='".$_FILES['adnimagen2']['name']."';
								document.getElementById('dirimag2').value='$destino';
								document.getElementById('dirimag2').scr='$destino';
								document.getElementById('imaini2').value='2';
							</script>";
						}
						else
						{
							echo"<script>document.getElementById('nimagen1').value='';
							despliegamodalm('visible','2','Error Al Cargar el Archivo');</script>";
						} 
					}
				}
				else
				{
					if (is_uploaded_file($_FILES['adnimagen3']['tmp_name'])) 
					{
						$archivo = $_FILES['adnimagen3']['name'];
						$tipo = $_FILES['adnimagen3']['type'];
						$usersave=$_SESSION[cedulausu];
						$destino = "informacion/temp/us$usersave/".$archivo;
						if (copy($_FILES['adnimagen3']['tmp_name'],$destino))
						{
							echo"
							<script>
								document.getElementById('nimagen3').value='".$_FILES['adnimagen3']['name']."';
								document.getElementById('dirimag3').value='$destino';
								document.getElementById('dirimag3').scr='$destino';
								document.getElementById('imaini3').value='2';
							</script>";
						}
						else
						{
							echo"<script>document.getElementById('nimagen3').value='';
							despliegamodalm('visible','2','Error Al Cargar el Archivo');</script>";
						} 
					}
					if (is_uploaded_file($_FILES['adnimagen4']['tmp_name'])) 
					{
						$archivo = $_FILES['adnimagen4']['name'];
						$tipo = $_FILES['adnimagen4']['type'];
						$usersave=$_SESSION[cedulausu];
						$destino = "informacion/temp/us$usersave/".$archivo;
						if (copy($_FILES['adnimagen4']['tmp_name'],$destino))
						{
							echo"
							<script>
								document.getElementById('nimagen4').value='".$_FILES['adnimagen4']['name']."';
								document.getElementById('dirimag4').value='$destino';
								document.getElementById('dirimag4').scr='$destino';
								document.getElementById('imaini4').value='2';
							</script>";
						}
						else
						{
							echo"<script>document.getElementById('nimagen4').value='';
							despliegamodalm('visible','2','Error Al Cargar el Archivo');</script>";
						} 
					}
					if (is_uploaded_file($_FILES['adnimagen5']['tmp_name'])) 
					{
						$archivo = $_FILES['adnimagen5']['name'];
						$tipo = $_FILES['adnimagen5']['type'];
						$usersave=$_SESSION[cedulausu];
						$destino = "informacion/temp/us$usersave/".$archivo;
						if (copy($_FILES['adnimagen5']['tmp_name'],$destino))
						{
							echo"
							<script>
								document.getElementById('nimagen5').value='".$_FILES['adnimagen5']['name']."';
								document.getElementById('dirimag5').value='$destino';
								document.getElementById('dirimag5').scr='$destino';
								document.getElementById('imaini5').value='2';
							</script>";
						}
						else
						{
							echo"<script>document.getElementById('nimagen5').value='';
							despliegamodalm('visible','2','Error Al Cargar el Archivo');</script>";
						} 
					}
					if (is_uploaded_file($_FILES['adnimagen6']['tmp_name'])) 
					{
						$archivo = $_FILES['adnimagen6']['name'];
						$tipo = $_FILES['adnimagen6']['type'];
						$usersave=$_SESSION[cedulausu];
						$destino = "informacion/temp/us$usersave/".$archivo;
						if (copy($_FILES['adnimagen6']['tmp_name'],$destino))
						{
							echo"
							<script>
								document.getElementById('nimagen6').value='".$_FILES['adnimagen6']['name']."';
								document.getElementById('dirimag6').value='$destino';
								document.getElementById('dirimag6').scr='$destino';
								document.getElementById('imaini6').value='2';
							</script>";
						}
						else
						{
							echo"<script>document.getElementById('nimagen6').value='';
							despliegamodalm('visible','2','Error Al Cargar el Archivo');</script>";
						} 
					}
					if (is_uploaded_file($_FILES['adnimagen7']['tmp_name'])) 
					{
						$archivo = $_FILES['adnimagen7']['name'];
						$tipo = $_FILES['adnimagen7']['type'];
						$usersave=$_SESSION[cedulausu];
						$destino = "informacion/temp/us$usersave/".$archivo;
						if (copy($_FILES['adnimagen7']['tmp_name'],$destino))
						{
							echo"
							<script>
								document.getElementById('nimagen7').value='".$_FILES['adnimagen7']['name']."';
								document.getElementById('dirimag7').value='$destino';
								document.getElementById('dirimag7').scr='$destino';
								document.getElementById('imaini7').value='2';
							</script>";
						}
						else
						{
							echo"<script>document.getElementById('nimagen7').value='';
							despliegamodalm('visible','2','Error Al Cargar el Archivo');</script>";
						} 
					}
					if (is_uploaded_file($_FILES['adnimagen8']['tmp_name'])) 
					{
						$archivo = $_FILES['adnimagen8']['name'];
						$tipo = $_FILES['adnimagen8']['type'];
						$usersave=$_SESSION[cedulausu];
						$destino = "informacion/temp/us$usersave/".$archivo;
						if (copy($_FILES['adnimagen8']['tmp_name'],$destino))
						{
							echo"
							<script>
								document.getElementById('nimagen8').value='".$_FILES['adnimagen8']['name']."';
								document.getElementById('dirimag8').value='$destino';
								document.getElementById('dirimag8').scr='$destino';
								document.getElementById('imaini8').value='2';
							</script>";
						}
						else
						{
							echo"<script>document.getElementById('nimagen8').value='';
							despliegamodalm('visible','2','Error Al Cargar el Archivo');</script>";
						}
					}
				}
				if($_POST[oculto]=="2")
				{
					if ($_POST[tabgroup1]=="1")
					{
						$camarchi1=$_POST[nimagen1];
						if($_POST[imaini1]=="2" && $_POST[nimagen1]!="")
						{
							$camarchi1="escudo.jpg";
							$usersave=$_SESSION[cedulausu];
							$temarchivo="informacion/temp/us$usersave/$_POST[nimagen1]";
							copy($temarchivo, "imagenes/escudo.jpg");
							copy($temarchivo, "imagenes/eng.jpg");
							echo "<script>document.getElementById('imaini1').value='0';</script>";
						}
						$camarchi2=$_POST[nimagen2];
						if($_POST[imaini2]=="2" && $_POST[nimagen2]!="")
						{
							$camarchi2="logoentidad.jpg";
							$usersave=$_SESSION[cedulausu];
							$temarchivo="informacion/temp/us$usersave/$_POST[nimagen2]";
							copy($temarchivo, "imagenes/logoentidad.jpg");
							echo "<script>document.getElementById('imaini2').value='0';</script>";
						}
						$_POST['oculto']="1";
						$sqlr ="DELETE FROM interfaz01";
						mysql_query($sqlr,$linkbd);
						$sqlr="INSERT INTO interfaz01 (lema,color1,color2,tipoletra1,formaletra1,tamanoletra1,colorletra1,tipoletra2, formaletra2,tamanoletra2,colorletra2,escudo,logo) values('$_POST[lema]','$_POST[color1]','$_POST[color2]','$_POST[tple01]', '$_POST[flle01]','$_POST[ttle01]','$_POST[colorl1]','$_POST[tple02]', '$_POST[flle02]','$_POST[ttle02]','$_POST[colorl2]','$camarchi1', '$camarchi2')";
						if (!mysql_query($sqlr,$linkbd)){echo"<script>despliegamodalm('visible','2','Error no se almaceno');</script>";}	
						else {echo"<script>despliegamodalm('visible','3','Se guardo la Interfaz con Exito');</script>";}
						
					}
					else
					{
						$contfotos=0;
						$controlcam=0;
						for ($i = 3; $i <= 8; $i++)
						{
							$nomimagenes1="nimagen$i";
							$nomimagenes2="imaini$i";
							$camarchi1=$_POST[$nomimagenes1];
							if($_POST[$nomimagenes2]=="2" && $_POST[$nomimagenes1]!="")
							{
								$camarchi1="escudo.jpg";
								$usersave=$_SESSION[cedulausu];
								$temarchivo="informacion/temp/us$usersave/$_POST[$nomimagenes1]";
								copy($temarchivo, "imagenes/photo_$contfotos.jpg");
								echo "<script>document.getElementById('$nomimagenes2').value='0';</script>";
								$sqlr ="UPDATE dominios SET valor_final='1' WHERE valor_inicial='$i' AND nombre_dominio='FOTOS_PORTADA'";
								mysql_fetch_row(mysql_query($sqlr,$linkbd));
								$controlcam=1;
							}
							else if($_POST[$nomimagenes2]=="2" && $_POST[$nomimagenes1]=="")
							{
								$sqlr ="UPDATE dominios SET valor_final='0' WHERE nombre_dominio='FOTOS_PORTADA' AND valor_inicial='$i'";
								mysql_fetch_row(mysql_query($sqlr,$linkbd));
								$controlcam=1;
							}
							$contfotos=$contfotos+1;
						}
						if ($controlcam==1){echo"<script>despliegamodalm('visible','3','Se guardaron las imagenes con Exito');</script>";}
						else {echo"<script>despliegamodalm('visible','3','No se seleccionaron imagenes para almacenar');</script>";}
						
					}
				}
			?>
            <script type="text/javascript">$('#lema').alphanum({allow: ',&'});</script>
		</form>
	</body>
</html>