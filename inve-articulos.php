<?php //V 1000 12/12/16 ?> 
<?php
//*****04-04-2016 se quita codigo unspc
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
		<title>:: Spid - Almacen</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<script>
			function despliegamodal2(_valor)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else {document.getElementById('ventana2').src="contra-productos-ventana.php";}
			}
 			function despliegamodalm(_valor,_tip,mensa,pregunta,variable)
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
				case "5":
					document.getElementById('ventanam').src="ventana-elimina1.php?titulos="+mensa+"&idresp="+pregunta+"&variable="+variable;break;	
					}
				}
			}
			function respuestaconsulta(pregunta, variable)
			{
				switch(pregunta)
				{
					case "1":	document.getElementById('oculto').value="2";
								document.form2.submit();break;
					case "2":
						document.form2.elimina.value=variable;
						//eli=document.getElementById(elimina);
						vvend=document.getElementById('elimina');
						//eli.value=elimina;
						vvend.value=variable;
						document.form2.submit();
						break;
				}
			}
			function funcionmensaje(){document.location.href = "inve-articulos.php";}
			function guarda()
			{
				var validacion01=document.getElementById('codigo').value;
				var validacion02=document.getElementById('nombre').value;
				var validacion03=document.getElementById('cuenta').value;
				if (validacion01.trim()!='' && validacion02.trim()!='' && validacion03.trim()!='' && document.getElementById('grupoinv').value !='' && document.getElementById('umedida').value !='' )
				{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
 				else{despliegamodalm('visible','2','Faltan datos para completar el registro');}
			}
			function codi()
			{
  				document.form2.cod.value=1;
  				document.form2.grup.value=document.form2.grupoinv.value;
  				document.form2.submit();
  			}
			function buscar(){
				if(document.getElementById('cuenta').value!=""){document.form2.busqueda.value='1';document.form2.submit();}
			}

			function agregardetalle(){
				var validacion00=document.getElementById('nombre').value;
				var validacion01=document.getElementById('umedida').value;
				var validacion02=document.getElementById('factor').value;
				if((validacion00.trim()!='')&&(validacion01.trim()!='')&&(validacion02.trim()!='')){
					document.form2.agregadet.value=1;
					document.form2.submit();
				}
				else{
					despliegamodalm('visible','2','Faltan Informaci? para poder Agregar');
				}
			}

			function eliminar(variable){
				despliegamodalm('visible','5','Esta Seguro de Eliminar','2',variable);
			}

			function camarcori(doc){
				document.getElementById('mararcori').value=doc;
				document.getElementById('principal').setAttribute("disabled" , "disabled" , false);;
			}

			function art_principal(){
				if (document.getElementById('principal').checked) {
					document.getElementById('factor').value=1;
					document.getElementById('factor').setAttribute("readonly" , "readonly" , false);
				}else{
					document.getElementById('factor').value='';
					document.getElementById('factor').removeAttribute("readonly"  , false);
				}
			}


		</script>

		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<table>
   			<tr><script>barra_imagenes("inve");</script><?php cuadro_titulos();?></tr>
    		<tr><?php menu_desplegable("inve");?></tr>
			<tr>
  				<td colspan="3" class="cinta"><a href="inve-articulos.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a><a href="#"  onClick="guarda();" class="mgbt"><img src="imagenes/guarda.png"  title="Guardar"/></a><a href="inve-buscaarticulos.php" class="mgbt"><img src="imagenes/busca.png"  title="Buscar" /></a><a href="#" onClick="mypop=window.open('inve-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
			</tr>	
  		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>	  
        <?php
        	if ($_POST[oculto]=="")
            {
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
				$usersave=$_SESSION[cedulausu];
				$rutaad="informacion/temp/us$usersave/";
				if(!file_exists($rutaad)){mkdir ($rutaad);}
				else {eliminarDir();mkdir ($rutaad);}
				$_POST[imaini1]="0";
				$_POST[dirimag1]= "imagenes/usuario_on.png";
			}
        ?>
		<form name="form2" method="post" action="inve-articulos.php" enctype="multipart/form-data">
			<input type="hidden" name="dirimag1" id="dirimag1" value="<?php echo $_POST[dirimag1];?>" onChange="document.form2.submit();"/>
			<input type="hidden" name="imaini1" id="imaini1" value="<?php echo $_POST[imaini1];?>"/> 
            <input type="hidden" name="mararcori" id="mararcori" value="<?php echo $_POST[mararcori];?>">
    		<table class="inicio" align="center" >
      			<tr>
       			 	<td class="titulos" colspan="9">.: Agregar Articulos</td>
        			<td class="cerrar" style="width:7%"><a href="inve-principal.php">&nbsp;Cerrar</a></td>
     		 	</tr>
      			<tr>
	  				<td class="saludo1" style="width:11%;">.: Grupo Inventario:</td>
            		<td style="width:15%;">
             			<select name="grupoinv" id="grupoinv" onChange="codi()" style="width:100%;text-transform:uppercase">
				 			<option value="">Seleccione ....</option>
							<?php
					 			$sqlr="SELECT * FROM almgrupoinv WHERE estado='S' ORDER BY codigo";
								$resp = mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($resp)) 
								{
									if($row[0]==$_POST[grupoinv]){echo "<option value='$row[0]' style='text-transform:uppercase' SELECTED>$row[0] - $row[1]</option>"; }
									else {echo "<option value='$row[0]' style='text-transform:uppercase'>$row[0] - $row[1]</option>";}
			     				}   		
							?>
		  				</select>
       				</td>
       				<td class="saludo1" style="width:7%;">.: Codigo:</td>
        			<td style="width:7%;"><input type="text" name="codigo" id="codigo" value="<?php echo $_POST[codigo]?>" onKeyUp="return tabular(event,this)" style="width:100%;" readonly/></td>
        			<td class="saludo1" style="width:11%;">.: Imagen Producto:</td>
                    <td style="width:11%;">
                        <input type="text" name="nimagen1" id="nimagen1"  style="width:83%" value="<?php echo $_POST[nimagen1]?>" class="tamano02"  readonly/>
                        <div class='upload' style="height:24px;float:right;" > 
                            <input type="file" name="adnimagen1" id="adnimagen1" value="<?php echo $_POST[adnimagen1];?>"  onChange="document.form2.submit();" title="Cargar Imagen" />
                            <img src='imagenes/upload01.png' style="width:23px"/> 
                         </div> 
                     </td>
                     <td style="width:1%;">
                     </td>
                     <td style="width:30%;position: absolute;">
       					<div class="mfoto02">
                            <img id="imagencm1" src="imagenes/usuario_on.png" style="max-height: 110px;">
                        </div>
       				</td>
       			</tr>  
	   		            
       			<tr>
       				<td class="saludo1">.: Nombre Articulo: </td>
        			<td colspan="4"><input type="text" name="nombre" id="nombre" value="<?php echo $_POST[nombre]?>" onKeyUp="return tabular(event,this)" style="width:100%;"/></td>
        			<td class="saludo1">.: Cod Interno:
						<input type="hidden" id="estado" name="estado" value="S">
        			</td>
					<td>
						<input id="codinterno" name="codinterno" value="<?php echo $_POST[codinterno] ?>">
					</td>
       			</tr>

      			<tr>
	  				<td class="saludo1">.: Unidad de Medida:</td>
            		<td >
             			<select name="umedida" id="umedida" style="width:100%;text-transform:uppercase">
				 			<option value="">Seleccione ....</option>
							<?php
					 			$sqlr="SELECT * FROM dominios WHERE nombre_dominio='unidad_medida' AND tipo='S' ORDER BY descripcion_valor";
								$resp = mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($resp)){
									if($row[2]==$_POST[umedida]){
										echo "<option value='$row[2]' style='text-transform:uppercase' SELECTED>$row[2]</option>";										
									}
									else {
										echo "<option value='$row[2]' style='text-transform:uppercase'>$row[2]</option>";
									}
			     				}   		
							?>
		  				</select>
       				</td>
       				<td class="saludo1">.:Unidad Principal:</td>
		           	<td>			
		           		<input type="checkbox" id="principal" name="principal" onclick="art_principal()" value="1">
        			</td>
       				<td class="saludo1" >.: Factor de Conversion: </td>
        			<td >
                    	<input type="text" name="factor" id="factor" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" value="" style="width:100%; text-align:right;"/>
		           	</td>
              	</tr>
              	<tr>
              		<td class="saludo1" >.: Codigo UNSPSC: </td>
        			<td width="10%">
                    	<input type="text" name="cuenta" id="cuenta" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[cuenta]?>" style="width:86%; text-align:right;" onBlur="buscar()"/> <a href="#" onClick="despliegamodal2('visible');"><img src="imagenes/find02.png" style="width:20px;" align="absmiddle" class="icobut"></a>
		           	</td>
		           	<td colspan="5">
                    	<input type="text" name="ncuenta" id="ncuenta" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[ncuenta]?>" style="width:75%; text-align:right;" readonly/>
						<input type="button" name="agrega" value=" Agregar Unidad " onClick="agregardetalle()" >
            			<input type="hidden" value="0" name="agregadet" id="agregadet">
		           	</td>
              	</tr>
    		</table>
    		<script>
				//function cargar_imagen
    			function preloader() 
				{
					if (document.getElementById) 
					{
							document.getElementById('imagencm1').src=document.getElementById('dirimag1').value+"?=<?php echo Date('U');?>";
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
    		?>
			<div class="subpantallac" style="height:76.5%; width:99.6%">
				<table class="inicio">
					<tr>
				    	<td class="titulos" colspan="4">.:Detalle Art�culos - Unidades de Medida</td>
				   	</tr>
					<tr>
				    	<td class="titulos2">Unidad de Medida</td>
				    	<td class="titulos2">Factor de Conversion</td>
				    	<td class="titulos2">Principal</td>
				        <td class="titulos2"><img src="imagenes/del.png" ><input type='hidden' name='elimina' id='elimina'></td>
				   	</tr>
					<?php			 
					if ($_POST[elimina]!=''){ 
		 				$posi=$_POST[elimina];
						unset($_POST[unid][$posi]);
						unset($_POST[facd][$posi]);
						$_POST[unid]= array_values($_POST[unid]); 
						$_POST[facd]= array_values($_POST[facd]); 		 		 
		 			}
	
					if($_POST[agregadet]=='1'){
						if (!in_array($_POST[umedida], $_POST[unid])) {
							$_POST[unid][]=$_POST[umedida];
							$_POST[facd][]=$_POST[factor];
						}else{
							echo "<script>despliegamodalm('visible','2','Unidad de Medida Repetida');</script>";
						}
						$_POST[agregadet]=0;
					}
					$cunid = count($_POST[unid]);
					for($x=0;$x< $cunid;$x++){
						if($_POST[mararcori]==$_POST[unid][$x]){
							$marcador='checked';
							echo "<script>camarcori(\"".$_POST[unid][$x]."\");</script>";
							$princ = 1;
						}else {$marcador='disabled'; $princ = 0;}
                        if ($_POST[principal]==1 && $x == ($cunid-1)) {
                        	$marcador='checked';
                        	echo "<script>camarcori(\"".$_POST[unid][$x]."\");</script>";
                        	$princ = 1;
                        }
						echo "<tr>
							<td class='saludo2' style='width:70%'>
								<input class='inpnovisibles' name='unid[]' value='".$_POST[unid][$x]."' type='text' style='width:100%'>
							</td>
							<td class='saludo2' style='width:15%'>
								<input class='inpnovisibles' name='facd[]' value='".$_POST[facd][$x]."' type='text' style='width:100%; text-align:right'>
							</td>
							<td>
								<input name='prin".$x."' id='prin".$x."' value='".$princ."' type='hidden' >
                            	<input type='radio' name='uniprin' class='defaultradio' $marcador/>
							</td>
							<td class='saludo2' style='width:15%'>
								<a href='#' onclick='eliminar($x)'><img src='imagenes/del.png'></a></td>
							</tr>";
				 	}	 
				 	?>
             	</table>
			</div>
		
            <?php
				if 	($_POST[cod]==1)
				{ 
					$sqlr="select MAX(CONVERT(codigo, SIGNED INTEGER)) FROM almarticulos WHERE grupoinven='$_POST[grup]'";
					$res=mysql_query($sqlr);
					$row=mysql_fetch_row($res);
					$codigo='0000'.($row[0]+1);
					$ta=strlen($codigo);;
					$codigob=substr($codigo,$ta-5,$ta);
					echo"
					<script>
						document.getElementById('codigo').value='$codigob';
						document.getElementById('codigo').focus();
					</script>";
				}
				if($_POST[busqueda]=='1')
				{
					$dosdigitos=substr($_POST[cuenta], 6);
					if($dosdigitos!="00" && $dosdigitos!="")
					{
						$nresul=buscaproducto($_POST[cuenta]);
						if($nresul!=''){echo"<script>document.form2.ncuenta.value='$nresul';</script>";}
						else
						{
							echo"
							<script>
								despliegamodalm('visible','2','C�digo Incorrecto');
								document.form2.ncuenta.value='';
								document.form2.cuenta.value='';
							</script>";
						}
					}
					else
					{
						echo"
						<script>
							despliegamodalm('visible','2','C�digo Incorrecto');
							document.form2.ncuenta.value='';
							document.form2.cuenta.value='';
						</script>";
					}
				}
 			?> 
    		<input type="hidden" name="busqueda" id="busqueda" value="0"/>
           	<input type="hidden" name="codar" id="codar"/>
    		<input type="hidden" name="oculto" id="oculto" value="1"/>  
            <input type="hidden" name="cod" id="cod" alue="0"/>  
            <input type="hidden" name="grup" id="grup" value="0"/>   
            <input type="hidden" name="umed" id="umed" value="0"/>   
  			<?php
				if($_POST[oculto]=="2"){

					$camarchi1=$_POST[nimagen1];
					if($_POST[imaini1]=="2" && $_POST[nimagen1]!="")
					{
						$camarchi1="articulo_".$camarchi1;
						$usersave=$_SESSION[cedulausu];
						$temarchivo="informacion/temp/us$usersave/$_POST[nimagen1]";
						copy($temarchivo, "imagenes/".$camarchi1);
						echo "<script>document.getElementById('imaini1').value='0';</script>";
					}

 					$sqlr="INSERT INTO almarticulos (codigo,nombre,codunspsc,grupoinven,estado,imagen,codinterno) VALUES ('$_POST[codigo]','$_POST[nombre]', '$_POST[cuenta]','$_POST[grupoinv]', '$_POST[estado]', '$camarchi1','$_POST[codinterno]')";
					if (!mysql_query($sqlr,$linkbd)){echo"<script>despliegamodalm('visible','2','Error no se almaceno');</script>";}	
					else 
					{
						$codart=$_POST[grupoinv].$_POST[codigo];
						for($x=0;$x< count($_POST[unid]);$x++)
						{
							$iprinc = 'prin'.$x;
							$consdet=selconsecutivo('almarticulos_det','id_det');
		 					$sqld="INSERT INTO almarticulos_det (id_det,articulo,unidad,factor,principal) VALUES ('$consdet','$codart','".$_POST[unid][$x]."', '".$_POST[facd][$x]."','".$_POST[$iprinc]."')";
							$resd=mysql_query($sqld,$linkbd);
						}
						echo"<script>despliegamodalm('visible','1','Se ha almacenado el Articulo con Exito');</script>";
					}
				}
			?>
            <div id="bgventanamodal2">
                <div id="ventanamodal2">
                    <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                    </IFRAME>
                </div>
       	 	</div>
 		</form>
	</body>
</html>