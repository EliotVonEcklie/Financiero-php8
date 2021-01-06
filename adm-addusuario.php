<?php //V 1000 12/12/16 ?> 
<!--V 1.0 24/02/2015-->
<?php
	require"comun.inc";
	require"funciones.inc";
	$linkbd=conectar_bd();
	session_start();
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
        <script type='text/javascript' src='JQuery/jquery-2.1.4.min.js'></script>
        <script type="text/javascript" src="JQuery/alphanum/jquery.alphanum.js"></script>
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
			function funcionmensaje(){document.location.href = "adm-addusuario.php";}
			function guardar()
			{
				var validacion01=document.getElementById('nombre').value;
				var validacion02=document.getElementById('usuario').value;
				var validacion03=document.getElementById('contras').value;
				if (validacion01.trim()!='' && validacion02.trim()!='' && validacion03.trim()!='' && document.getElementById('cc').value!="" && document.getElementById('rol').value!="-1")
				{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
				else{despliegamodalm('visible','2','Faltan datos para completar el registro');}
			}
			function existeDetalle(movimiento,modulo,transaccion){
				var arreglo_mov=document.getElementsByName("tipomovs[]");
				var arreglo_tran=document.getElementsByName("transacciones[]");
				var arreglo_mod=document.getElementsByName("modulos[]");
				var existe=false;
				
				for(var i=0; i<arreglo_mod.length; i++){
					if(arreglo_mod[i]==modulo && arreglo_mov[i]==movimiento && arreglo_mod[i]==modulo){
						existe=true;
						break;
					}
				}
				return existe;
			}
			function agregar(){
				var tipomov=document.form2.tipomov.value;
				var modulo=document.form2.modulo01.value;
				var transac=document.form2.transaccion.value;
				
				if(tipomov=='' || modulo=='' || transac==''){
					despliegamodalm('visible','2','Faltan datos para agregar el detalle');
				}else if(existeDetalle(tipomov,modulo,transac) ){
					despliegamodalm('visible','2','Este registro existe');
				}else{
					document.form2.agrega.value=2;
					document.form2.submit();
				}
			}
			function eliminar(pos){
				if(confirm("¿Realmente desea eliminar el elemento No. "+pos+"?")){
					document.form2.elimina.value=2;
					document.form2.posicion.value=pos;
					document.form2.submit();
				}
				
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
		<table>
   			<tr><script>barra_imagenes("adm");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("adm");?></tr>
			<tr>
  				<td colspan="3" class="cinta"><a onClick="location.href='adm-addusuario.php'" class="mgbt"><img src="imagenes/add.png"  title="Nuevo" /></a><a onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png" title="Guardar"/></a><a onClick="location.href='adm-usuarios.php'" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a><a href="#" onClick="<?php echo paginasnuevas("adm");?>" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
            </tr>
    	</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
 		<form name="form2" method="post" enctype="multipart/form-data" action=""> 
        	<input type="hidden" name="dirimag" id="dirimag" value="<?php echo $_POST[dirimag];?>" onChange="document.form2.submit();"/>
        	<?php
				if($_POST[oculto]=="")
				{
					$_POST[estado]=1;
					$usersave=$_SESSION[cedulausu];
					$rutaad="informacion/temp/us$usersave/";
					if(!file_exists($rutaad)){mkdir ($rutaad);}
					else {eliminarDir();mkdir ($rutaad);}
					echo "<script>document.getElementById('dirimag').value='imagenes/usuario_on.png';</script>";
				}
			?>
  			<table class="inicio">
                <tr>
                    <td class="titulos" colspan="8">:: Informacion Usuario</td>
                    <td class="cerrar" style='width:7%'><a onClick="location.href='adm-principal.php'">Cerrar</a></td>
    			</tr>
    			<tr>
      				<td class="tamano01" style="width:4cm;">:&middot; Nombres y Apellidos: </td>
      				<td colspan="6"><input type="text" name="nombre" id="nombre" value="<?php echo $_POST[nombre];?>" class="tamano02" style="width:100%" onKeyUp="return tabular(event,this)"/></td>
                    <td rowspan="6" style="width:15%">
                    	<div class="mfoto01">
                        	<span></span>
                            <img id="imagencm" src="imagenes/usuario_on.png" style="height:160px; width:120px;" />
                      	</div>
                  	</td>
               </tr>
               <tr>
      				<td class="tamano01" style="width:4cm;">:&middot; Cedula:</td>
      				<td style="width:30%" colspan="3"><input type="text" name="cc" id="cc" value="<?php echo $_POST[cc] ?>" class="tamano02" style="width:100%" onKeyUp="return tabular(event,this)"/></td>
                    <td class="tamano01" style="width: 9% !important">:&middot; Perfil: </td>
                    <td>
                        <select name="rol" id="rol" class="tamano02" style="width:100%;text-transform:uppercase;">
                            <option value='-1'>Seleccione Rol</option>
                            <?php
                                $sqlr="select * from roles where id_rol>1 AND est_rol='1' order by nom_rol";
                                $resp = mysql_query($sqlr,$linkbd);
                                while ($fila =mysql_fetch_row($resp))
                                {
                                    $nar=$fila[1];
                                    if($fila[0]==$_POST[rol])
                                    {
                                        echo "<option value='$fila[0]' SELECTED>$fila[1]</option>";
                                        $nam=$fila[1];
                                    }
                                    else{echo "<option value='$fila[0]'>$fila[1]</option>";}
                                }
                            ?>
                        </select>   
		 			</td>
          		</tr>
   				<tr>
   					<td class="tamano01">:&middot; Username:</td>
					<td colspan="3">
   					<input type="text" name="usuario" id="usuario" value="<?php echo $_POST[usuario] ?>" class="tamano02" style="width:100%" onKeyUp="return tabular(event,this)"/></td>
                    <td class="saludo1">Contrase&ntilde;a:</td>     
                    <td><input type="text" name="contras" id="contras" value="<?php echo $_POST[contras] ?>" class="tamano02" style="width:100%" onKeyUp="return tabular(event,this)"/></td>
               	</tr>
                <tr>
                	<td class="tamano01" style="width:2cm;">:&middot; Imagen:</td>
               		<td colspan="5">
                    	<input type="text" name="nimagen" id="nimagen"  style="width:95%" value="<?php echo $_POST[nimagen]?>" class="tamano02"  readonly/>
                         <div class='upload' style="height:24px;float:right !important;" > 
                            <input type="file" name="adnimagen" id="adnimagen" value="<?php echo $_POST[adnimagen];?>"  onChange="document.form2.submit();" title="Cargar Imagen" />
                            <img src='imagenes/upload01.png' style="width:23px"/> 
                         </div> 
                     </td>
                </tr>
                <tr>
                	<td class="tamano01">:&middot; Privilegios:</td>
                    <td class="tamano03" colspan="3">
             			<input type="checkbox" name="trcrear" id="trcrear" value="<?php echo $_POST[trcrear];?>" class="defaultcheckbox" onClick="cambiocheckbox('trcrear');"/>Crear &nbsp;&nbsp;&nbsp;&nbsp;
                    	<input type="checkbox" name="treditar" id="treditar" value="<?php echo $_POST[treditar];?>" class="defaultcheckbox"  onClick="cambiocheckbox('treditar');"/>Editar &nbsp;&nbsp; &nbsp;&nbsp;
                        <input type="checkbox" name="trdesactivar" id="trdesactivar" value="<?php echo $_POST[trdesactivar];?>" class="defaultcheckbox" onClick="cambiocheckbox('trdesactivar');"  />Desactivar &nbsp;&nbsp; &nbsp;&nbsp;
                        <input type="checkbox" name="treliminar" id="treliminar" value="<?php echo $_POST[treliminar];?>" class="defaultcheckbox" onClick="cambiocheckbox('treliminar');"  />Eliminar
            		</td>
					<td class="tamano01">:&middot; Estado:</td>
                    <td>
						<select name="estado" id="estado" class="tamano02" style="width:100%;text-transform:uppercase;">
                    		<option value="1" <?php if ($_POST[estado]==1) echo " SELECTED";?> >Activo</option>    
                            <option value="0" <?php if ($_POST[estado]==0) echo " SELECTED";?> >Inactivo</option>              
            			</select>  
          			</td>
                </tr>
				<tr>
      				<td class="tamano01">:&middot; M&oacute;dulo:</td>
                    <td>
						<select name="modulo01" id="modulo01" style="width:100%;" onChange="document.form2.submit();">
							<option value="-1" <?php if($_POST[modulo01]=="-1"){$_POST[nmodulo01]=''; echo "SELECTED";}?>>Seleccionar...</option>
							<option value="6" <?php if($_POST[modulo01]=="6"){$_POST[nmodulo01]='Activos Fijos'; echo "SELECTED";}?>>Activos Fijos</option>
							<option value="0" <?php if($_POST[modulo01]=="0"){$_POST[nmodulo01]='Administracion'; echo "SELECTED";}?>>Administraci&oacute;n</option>
							<option value="5" <?php if($_POST[modulo01]=="5"){$_POST[nmodulo01]='Almacen'; echo "SELECTED";}?>>Almac&eacute;n</option>
							<option value="1" <?php if($_POST[modulo01]=="1"){$_POST[nmodulo01]='Contabilidad'; echo "SELECTED";}?>>Contabilidad</option>
							<option value="8" <?php if($_POST[modulo01]=="8"){$_POST[nmodulo01]='Contratacion'; echo "SELECTED";}?>>Contrataci&oacute;n</option>
							<option value="2" <?php if($_POST[modulo01]=="2"){$_POST[nmodulo01]='Gestion Humana'; echo "SELECTED";}?>>Gesti&oacute;n Humana</option>
							<option value="7" <?php if($_POST[modulo01]=="7"){$_POST[nmodulo01]='Meci Calidad'; echo "SELECTED";}?>>Meci Calidad</option>
							<option value="9" <?php if($_POST[modulo01]=="9"){$_POST[nmodulo01]='Planeacion Estrategica'; echo "SELECTED";}?>>Planeaci&oacute;n Estrategica</option>
							<option value="3" <?php if($_POST[modulo01]=="3"){$_POST[nmodulo01]='Presupuesto'; echo "SELECTED";}?>>Presupuesto</option>
							<option value="4" <?php if($_POST[modulo01]=="4"){$_POST[nmodulo01]='Tesoreria'; echo "SELECTED";}?>>Tesorer&iacute;a</option>
						</select>
          			</td>
					<td class="tamano01">:&middot; Transacci&oacute;n:</td>
                    <td>
						<select name="transaccion" id="transaccion" class="tamano02" style="width:100%;text-transform:uppercase;">
                    		<?php
							if(!empty($_POST[modulo01])){
								$sql="SELECT comando FROM opciones WHERE comando<>'' AND modulo='$_POST[modulo01]' ";
								$res=mysql_query($sql,$linkbd);
								while($row = mysql_fetch_row($res)){
									if($_POST[transaccion]==$row[0]){
										echo "<option value='$row[0]' SELECTED>$row[0]</option>";
									}else{
										echo "<option value='$row[0]'>$row[0]</option>";
									}
									
								}
							}else{
								echo "<option value=''>*****</option> ";
							}
							
							?>							
            			</select>  
          			</td>
					<td class="tamano01">:&middot; Movimiento:</td>
                    <td class="tamano03">
						<select name="tipomov" id="tipomov" class="tamano02" style="width:60%;text-transform:uppercase;">
						<?php
						if(!empty($_POST[modulo01])){
							$sql="SELECT CONCAT(id,codigo),descripcion FROM tipo_movdocumentos where estado='S' AND modulo='$_POST[modulo01]' ";
							$res=mysql_query($sql,$linkbd);
							while($row = mysql_fetch_row($res)){
								if($_POST[tipomov]==$row[0]){
									echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option> ";
									$_POST[ntipomov]=$row[1];
								}else{
									echo "<option value='$row[0]' >$row[0] - $row[1]</option> ";
								}
								
							}
						}else{
							echo "<option value=''>************</option> ";
						}
						
						?>
		             
            			</select> 
						<input type="button" name="aceptar" id="aceptar" value=" Agregar " onClick="agregar()"/>
						<input type="checkbox" name="todos" id="todos" value="<?php echo $_POST[todos];?>" class="defaultcheckbox" style="top:-6px !important"/>Todos
						<input type="hidden" name="agrega" id="agrega" value="<?php echo $_POST[agrega]; ?>"/>
						<input type="hidden" name="ntipomov" id="ntipomov" value="<?php echo $_POST[ntipomov]; ?>"/>
						<input type="hidden" name="elimina" id="elimina" value="<?php echo $_POST[elimina]; ?>"/>
						<input type="hidden" name="posicion" id="posicion" value="<?php echo $_POST[posicion]; ?>"/>
          			</td>
				</tr>   
  			</table>

			<?php
			$linkbd=conectar_bd();
			echo " <table width='100%'  class='inicio' align='center'>";//*****tabla de Privilegios *****
			echo " <tr class='titulos'><td height='25' colspan='5'>:: Privilegios del Perfil ";
			echo "</td></tr>";
			echo "<tr >";
			echo "<td class='titulos2' width='10%'><center>Item</center></td>";
			echo "<td class='titulos2' width='25%'><center>Modulo</center></td>";
			echo utf8_decode("<td class='titulos2' width='25%'><center>Transacción</center></td>");
			echo "<td class='titulos2' width='30%'><center>Movimiento</center></td>";
			echo "<td class='titulos2' width='10%' height='25'><center> <img src='imagenes/del.png'> </center></td></tr>";
			if($_POST[elimina]==2){
				$pos=$_POST[posicion];
				unset($_POST[modulos][$pos],$_POST[transacciones][$pos],$_POST[tipomovs][$pos]);
				echo "<script>document.getElementById('elimina').value=''; </script>";
				echo "<script>document.getElementById('posicion').value=''; </script>";
			}
			if($_POST[agrega]==2){
				$_POST[modulos][]=$_POST[modulo01];
				$_POST[nmodulos][]=$_POST[nmodulo01];
				$_POST[transacciones][]=$_POST[transaccion];
				$_POST[tipomovs][]=$_POST[tipomov];
				$_POST[ntipomovs][]=$_POST[ntipomov];
				echo "<script>document.getElementById('agrega').value=''; </script>";
			}
			$zebra1="zebra1";
			$zebra1="zebra2";
			for($i=0;$i<count($_POST[modulos]);$i++ ){
				
				echo "<tr class='$zebra1'>";
				echo "<td style='text-align: center' >".($i+1)."</td>";
				echo "<td style='text-align: center'><input type='hidden' name='modulos[]' value='".$_POST[modulos][$i]."' /><input type='hidden' name='nmodulos[]' value='".$_POST[nmodulos][$i]."' /> ".$_POST[nmodulos][$i]." </td>";
				echo "<td style='text-align: center'><input type='hidden' name='transacciones[]' value='".$_POST[transacciones][$i]."' /> ".$_POST[transacciones][$i]." </td>";
				echo "<td style='text-align: center'><input type='hidden' name='tipomovs[]' value='".$_POST[tipomovs][$i]."' /><input type='hidden' name='ntipomovs[]' value='".$_POST[ntipomovs][$i]."' /> ".$_POST[tipomovs][$i]." - ".$_POST[ntipomovs][$i]." </td>";
				echo "<td style='text-align: center'><a href='javascript:void(0)' onClick='eliminar($i)'> <img src='imagenes/del.png' /> </a> </td>";
				echo "</tr>";
				$aux=$zebra1;
				$zebra1=$zebra2;
				$zebra2=$aux;
			}

			//********Sacar los privilegios****
			$_SESSION[idexacli]=array();
			$_SESSION[valexacli]=array();
			if ($cr==1)
			{
			$sqlr="Select distinct opciones.id_opcion,opciones.nom_opcion,opciones.ruta_opcion,opciones.niv_opcion,opciones.est_opcion,opciones.orden,opciones.modulo,modulo_rol.id_modulo,modulos.nombre,niveles.nombre from modulo_rol,opciones,modulos,niveles where modulo_rol.id_rol=$cr and modulo_rol.id_modulo=opciones.modulo and modulos.id_modulo=modulo_rol.id_modulo and opciones.modulo=niveles.id_modulo and niveles.id_nivel=opciones.niv_opcion group by opciones.id_opcion,opciones.nom_opcion,opciones.ruta_opcion,opciones.niv_opcion,opciones.est_opcion,opciones.orden,opciones.modulo,modulo_rol.id_modulo,modulos.nombre,niveles.nombre order by modulos.nombre, niveles.nombre";
			}
			else
			{
			$sqlr="Select distinct opciones.id_opcion,opciones.nom_opcion,opciones.ruta_opcion,opciones.niv_opcion,opciones.est_opcion,opciones.orden,opciones.modulo,modulo_rol.id_modulo,modulos.nombre,niveles.nombre from modulo_rol,opciones,modulos,niveles where modulo_rol.id_rol=$cr and modulo_rol.id_modulo=opciones.modulo and modulos.id_modulo=modulo_rol.id_modulo and opciones.modulo=niveles.id_modulo and niveles.id_nivel=opciones.niv_opcion and opciones.especial<>'S' group by opciones.id_opcion,opciones.nom_opcion,opciones.ruta_opcion,opciones.niv_opcion,opciones.est_opcion,opciones.orden,opciones.modulo,modulo_rol.id_modulo,modulos.nombre,niveles.nombre order by modulos.nombre, niveles.nombre";
			}
			$sqlr2="select ROL_PRIV.ID_opcion, opciones.NOM_opcion,ROL_PRIV.ID_opcion,ROLES.ID_ROL, ROL_PRIV.ID_ROL from	ROLES,ROL_PRIV,opciones where ROL_PRIV.ID_opcion=opciones.id_opcion  "; 
			 $sqlr2=$sqlr2."and	 ROLES.ID_ROL=rol_priv.id_rol and ROL_PRIV.ID_ROL=$cr";
			$iter='saludo1';
			$iter2='saludo2';
			//	echo "$sqlr2";
			$resp = mysql_query($sqlr2,$linkbd);	
			//$resp = oci_parse ($linkbd, $sqlr2);
			//oci_execute ($resp);
			$i=0;
			while ($row = mysql_fetch_row($resp)) 
			 {
			 $_SESSION[idexacli][$i]=$row[0];
			 $_SESSION[valexacli][$i]=$row[1];
			 $i+=1;
			 }
			//oci_free_statement($resp);
			$resp = mysql_query($sqlr,$linkbd);
			//$resp = oci_parse ($linkbd, $sqlr);
			//oci_execute ($resp);
			$i=1;
			while ($row =  mysql_fetch_row($resp)) 
			 {
			  echo "<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
			onMouseOut=\"this.style.backgroundColor=anterior\"><td>$i</td>";
			   echo "<td>$row[8]</td>";
			   echo "<td>$row[9]</td>";
			$i+=1;
			  echo "<td>$row[1]</td>";
			  if (!esta_en_array($_SESSION[idexacli],$row[0]))
			  { 
			   echo "<td><center><input type='checkbox' name=tabla[] value='$row[0]' ></td></tr>";
			  }
			   else
			   {
			  $pos=pos_en_array($_SESSION[idexacli],$row[0]);
			  $valor=$_SESSION[idexacli][$pos];
			   echo "<td><center><input type='checkbox' name=tabla[] value='$row[0]' checked ></td></tr>"; //***** para cuando se registre las sesiones y las variables de sesion
			   }
			  $aux=$iter;
			  $iter=$iter2;
			  $iter2=$aux; 
			 }
			echo "</table>";
				?>
            <input type="hidden" name="codigo" id="codigo" value="<?php echo $_POST[codigo];?>"/>
         	<input type="hidden" name="oculto" id="oculto" value="1"/>
            <script>
				//function cargar_imagen
    			function preloader() 
				{
					if (document.getElementById) 
					{document.getElementById('imagencm').src=document.getElementById('dirimag').value;}
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
				if ($_POST[trcrear]=="1"){echo "<script>document.getElementById('trcrear').checked=true;</script>";} 	
				if ($_POST[treditar]=="1"){echo "<script>document.getElementById('treditar').checked=true;</script>";}
				if ($_POST[trdesactivar]=="1"){echo "<script>document.getElementById('trdesactivar').checked=true;</script>";}
				if ($_POST[treliminar]=="1"){echo "<script>document.getElementById('treliminar').checked=true;</script>";}
				if (is_uploaded_file($_FILES['adnimagen']['tmp_name'])) 
				{
					$archivo = $_FILES['adnimagen']['name'];
					$tipo = $_FILES['adnimagen']['type'];
					$usersave=$_SESSION[cedulausu];
					$destino = "informacion/temp/us$usersave/".$archivo;
					if (copy($_FILES['adnimagen']['tmp_name'],$destino))
					{
						echo"
						<script>
							document.getElementById('nimagen').value='".$_FILES['adnimagen']['name']."';
							document.getElementById('dirimag').value='$destino';
							document.getElementById('dirimag').scr='$destino';
						</script>";
					}
					else
					{
						echo"<script>document.getElementById('nimagen').value='';
						despliegamodalm('visible','2','Error Al Cargar el Archivo');</script>";
					} 
				}
				if($_POST[oculto]=="2")
				{
					$codigo=selconsecutivo('usuarios','id_usu');
					$adnombre="";
					//almacenar en el servidor imagen
					if($_POST[nimagen]!="")
					{
						$extci = explode('.', $_POST[nimagen]);
						$adnombre="foto$codigo.".$extci[1];
						$usersave=$_SESSION[cedulausu];
						$temarchivo="informacion/temp/us$usersave/$_POST[nimagen]";
						copy($temarchivo, "informacion/fotos_usuarios/$adnombre");
					}
					$sqlr="INSERT INTO usuarios (id_usu,nom_usu,cc_usu,usu_usu,pass_usu,est_usu,id_rol,foto_usu) values('$codigo', '$_POST[nombre]','$_POST[cc]','$_POST[usuario]','$_POST[contras]',1,$_POST[rol],'$adnombre')";
					if (!mysql_query($sqlr,$linkbd)){echo"<script>despliegamodalm('visible','2','Error no se almaceno');</script>";}	
					else 
					{
						$sqlr="INSERT INTO dominios VALUES ('$_POST[cc]','','$_POST[usuario]','PERMISO_MODIFICA_DOC','','usuarios del sistema')";
						mysql_query($sqlr,$linkbd);
						$sqlr="INSERT INTO usuarios_privilegios VALUES ('$codigo','$_POST[trcrear]','$_POST[treditar]', '$_POST[trdesactivar]','$_POST[treliminar]')";
						mysql_query($sqlr,$linkbd);
						if(isset($_POST[todos]) && !empty($_POST[todos])){
							$sql="INSERT INTO permisos_movimientos(modulo,nombre_modulo,transaccion,codmov,tipomov,usuario,estado) VALUES (0,'-','-','-','-','$_POST[cc]','T')";
							mysql_query($sql,$linkbd);
						}else{
							for($i=0;$i<count($_POST[modulos]); $i++){
				
							$sql="INSERT INTO permisos_movimientos(modulo,nombre_modulo,transaccion,codmov,tipomov,usuario,estado) VALUES('".$_POST[modulos][$i]."','".$_POST[nmodulos][$i]."','".$_POST[transacciones][$i]."','".$_POST[tipomovs][$i]."','".$_POST[ntipomovs][$i]."','$_POST[cc]','S') ";
							mysql_query($sql,$linkbd);
							}
						}
						
						
						echo"<script>despliegamodalm('visible','1','Se creo el Usuario con Exito');</script>";
					}
				}
			?>
            <script type="text/javascript">$('#nombre,#usuario,#contras').alphanum({allow: ''});</script>
            <script type="text/javascript">$('#cc').numeric({allowThouSep: false,allowDecSep: false});</script>
		</form>
	</body>
</html>