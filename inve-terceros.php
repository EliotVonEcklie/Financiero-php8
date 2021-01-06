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
		<title>:: SPID - Almacen</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<script>
			function guardar()
			{
				if (document.getElementById('persona').value!="-1")
				{
					if (document.getElementById('persona').value=="1")
					{
						var validacion00=document.getElementById('documento').value;
						var validacion01=document.getElementById('razonsocial').value;
						var validacion02=document.getElementById('direccion').value;
						var validacion03=document.getElementById("contribuyente");
						var validacion04=document.getElementById("proveedor");
						var validacion05=document.getElementById("empleado");
						if(!validacion03.checked){var valcheck01="0";}
						else {var valcheck01="1";}
						if(!validacion04.checked){var valcheck02="0";}
						else {var valcheck02="1";}
						if(!validacion05.checked){var valcheck03="0";}
						else {var valcheck03="1";}
						if((validacion00.trim()!='')&&(validacion01.trim()!='')&&(validacion02.trim()!='')&&(document.getElementById('mnpio').value!="-1")&&((valcheck01=="1")||(valcheck02=="1")||(valcheck03=="1")))
						{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
						else {despliegamodalm('visible','2','Falta informacion para Crear el Tercero');}
					}
					else
					{
						var validacion00=document.getElementById('documento').value;
						var validacion01=document.getElementById('apellido1').value;
						var validacion06=document.getElementById('nombre1').value;
						var validacion02=document.getElementById('direccion').value;
						var validacion03=document.getElementById("contribuyente");
						var validacion04=document.getElementById("proveedor");
						var validacion05=document.getElementById("empleado");
						if(!validacion03.checked){var valcheck01="0";}
						else {var valcheck01="1";}
						if(!validacion04.checked){var valcheck02="0";}
						else {var valcheck02="1";}
						if(!validacion05.checked){var valcheck03="0";}
						else {var valcheck03="1";}
						if((validacion06.trim()!='')&&(validacion00.trim()!='')&&(validacion01.trim()!='')&&(validacion02.trim()!='')&&(document.getElementById('mnpio').value!="-1")&&((valcheck01=="1")||(valcheck02=="1")||(valcheck03=="1")))
						{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
						else {despliegamodalm('visible','2','Falta informacion para Crear el Tercero');}
					
					}
				}
				else {despliegamodalm('visible','2','Falta informacion para Crear el Tercero');}
 			}
			function validar(formulario){document.form2.action="inve-terceros.php";document.form2.submit();}
			function buscater(e){if (document.form2.documento.value!=""){document.form2.bt.value='1';document.form2.submit();}}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden")
				{
					document.getElementById('ventanam').src="";
					if(document.getElementById('valfocus').value=="2")
					{
						document.getElementById('valfocus').value='1';
						document.getElementById('documento').focus();
						document.getElementById('documento').select();
					}
				}
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
							document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;	
					}
				}
			}
			function funcionmensaje(){document.location.href = "inve-terceros.php";}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":
						document.form2.oculto.value="2";
						document.form2.submit();
						break;
				}
			}
 		</script>
		<?php titlepag();?>
	</head>
	<body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("inve");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("inve");?></tr>
			<tr>
  				<td colspan="3" class="cinta"><a href="inve-terceros.php" class="mgbt"><img src="imagenes/add.png"  title="Nuevo" /></a><a href="#"  onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png"  title="Guardar" /></a><a href="inve-buscaterceros.php" class="mgbt"><img src="imagenes/busca.png"  title="Buscar" /></a><a href="#" onClick="mypop=window.open('inve-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a></td>
          	</tr>
     	</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
 		<form name="form2" method="post" action="">
    		<table class="inicio" align="center" width="80%" >
                <tr>
                    <td class="titulos" colspan="4">.: Agregar Terceros</td>
                    <td class="cerrar" ><a href="inve-principal.php">&nbsp;Cerrar</a></td>
                </tr>
	   			<tr>
        			<td class="saludo1" style="width:13%;">.: Tipo Persona:</td>
        			<td>
                    	<select name="persona" id="persona" style="width:30%;" onChange="validar()">
                            <option value="-1">...</option>
                            <?php
                                $sqlr="SELECT * FROM personas WHERE estado='1'";
                                $resp = mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($resp)) 
                                {
                                    if($row[0]==$_POST[persona]){echo "<option value='$row[0]' SELECTED>$row[1]</option>";}
                                    else {echo "<option value='$row[0]'>$row[1]</option>";}	  
                                }
                            ?>
						</select>
        			</td>
        			<td class="saludo1" style="width:13%;">.: Regimen:</td>
        			<td>
                    	<select name="regimen" id="regimen" style="width:44%;">
		 					<?php
  		   						$sqlr="Select * from regimen where estado='1' order by id_regimen";
		 						$resp = mysql_query($sqlr,$linkbd);
				    			while ($row =mysql_fetch_row($resp)) 
				    			{
									if($row[0]==$_POST[regimen]){echo "<option value='$row[0]' SELECTED>$row[1]</option>";}
					  				else {echo "<option value='$row[0]'>$row[1]</option>";}	  
								} 
		  					?>
						</select>
        			</td>
        		</tr>
		   		<tr>
        			<td class="saludo1">.: Tipo Doc:</td>
        			<td>
                    	<select name="tipodoc" id="tipodoc" style="width:30%;">
		 					<?php
  		   						$sqlr="Select docindentidad.id_tipodocid,docindentidad.nombre from  docindentidad, documentopersona where docindentidad.estado='1' and documentopersona.persona='$_POST[persona]' and documentopersona.tipodoc=docindentidad.id_tipodocid";
		 						$resp = mysql_query($sqlr,$linkbd);
				    			while ($row =mysql_fetch_row($resp)) 
				    			{
					 				if($row[0]==$_POST[tipodoc]){echo "<option value='$row[0]' SELECTED>$row[1]</option>";}
					  				else {echo "<option value='$row[0]'>$row[1]</option>";}  
								}
		  					?>
						</select>
        			</td>
        			<td class="saludo1">.: Documento:</td>
        			<td><input type="text" name="documento" id="documento" value="<?php echo $_POST[documento]?>" onBlur="buscater(event)" onKeyPress="codigover()" onKeyUp="return tabular(event,this)" style="width:35%;"/>&nbsp;-&nbsp;<input type="text" name="codver" id="codver" value="<?php echo $_POST[codver]?>" style="width:6%;" readonly/></td>
		   		</tr>
		 		<tr>
        			<td class="saludo1">.: Primer Apellido:</td>
        			<td><input type="text" name="apellido1" id="apellido1" value="<?php echo $_POST[apellido1]?>" style="width:98%;" onKeyUp="return tabular(event,this)" /></td>
         			<td class="saludo1">.: Segundo Apellido:</td>
        			<td><input type="text" name="apellido2" id="apellido2" value="<?php echo $_POST[apellido2]?>" style="width:100%;" onKeyUp="return tabular(event,this)"/></td>
        		</tr>
				<tr>
        			<td class="saludo1">.: Primer Nombre:</td>
        			<td><input type="text" name="nombre1" id="nombre1" value="<?php echo $_POST[nombre1]?>" style="width:98%;" onKeyUp="return tabular(event,this)"/></td>
					<td class="saludo1">.: Segundo Nombre:</td>
        			<td><input type="text" name="nombre2" id="nombre2" value="<?php echo $_POST[nombre2]?>" style="width:100%;" onKeyUp="return tabular(event,this)"/></td>
	  			</tr>
	   			<tr>
        			<td class="saludo1">.: Razon Social:</td>
        			<td colspan="3"><input type="text" name="razonsocial" id="razonsocial"  value="<?php echo $_POST[razonsocial]?>" style="width:100%;" onKeyUp="return tabular(event,this)"/></td>	
             	</tr>  
	   			<tr>
        			<td class="saludo1">.: Direccion:</td>
        			<td colspan="3"><input type="text" name="direccion" id="direccion" value="<?php echo $_POST[direccion]?>" style="width:100%;" onKeyUp="return tabular(event,this)"/></td>
				</tr>
				<tr>
         			<td class="saludo1">.: Telefono:</td>
        			<td><input type="text" name="telefono" id="telefono" value="<?php echo $_POST[telefono]?>" style="width:98%;" onKeyUp="return tabular(event,this)"/></td>
		 			<td class="saludo1">.: Celular:</td>
        			<td><input type="text" name="celular" id="celular" value="<?php echo $_POST[celular]?>" style="width:100%;" onKeyUp="return tabular(event,this)"/></td>
       			</tr>  
	    		<tr>
        			<td class="saludo1">.: E-mail:</td>
        			<td><input type="text" name="email" id="email" value="<?php echo $_POST[email]?>" style="width:98%;" onKeyUp="return tabular(event,this)"></td>
         			<td class="saludo1">.: Pagina Web:</td>
        			<td><input type="text" name="web" id="web" value="<?php echo $_POST[web]?>" style="width:100%;" onKeyUp="return tabular(event,this)"></td>
       			</tr> 
	   			<tr>
        			<td class="saludo1">:: Dpto :</td>
        			<td>
                    	<select name="dpto" id="dpto" onChange="validar()">
                    		<option value="-1">:::: Seleccione Departamento :::</option>
            				<?php
  		   						$sqlr="Select * from danedpto order by nombredpto";
		 						$resp = mysql_query($sqlr,$linkbd);
				    			while ($row =mysql_fetch_row($resp)) 
				    			{
					 				if($row[1]==$_POST[dpto]){echo "<option value=$row[1] SELECTED>$row[2]</option>";}
					 				else {echo "<option value=$row[1]>$row[2]</option>";}  
								}
		  					?>
          				</select>
        			</td>
        			<td class="saludo1">:: Municipio :</td>
        			<td>
                    	<select name="mnpio" id="mnpio">
							<option value="-1">:::: Seleccione Municipio ::::</option>
              				<?php
  		   						$sqlr="Select * from danemnpio where  danemnpio.danedpto='$_POST[dpto]' order by nom_mnpio";
		  						$resp = mysql_query($sqlr,$linkbd);
				    			while ($row =mysql_fetch_row($resp)) 
				    			{
					 				if($row[2]==$_POST[mnpio]){echo "<option value=$row[2] SELECTED>$row[3]</option>";}
					  				echo "<option value=$row[2]>$row[3]</option>";	  
								}
							?>        
        				</select> 
        			</td>
      			</tr> 
	       		<tr style="height:22px;">
        			<td class="saludo1">.: Tipo Tercero:</td>
        			<td colspan="3"  > 
                        :: Contribuyente:&nbsp;<input type="checkbox" name="contribuyente" id="contribuyente" class="defaultcheckbox" value="1" <?php if(isset($_REQUEST['contribuyente'])){echo "checked";} ?>/>&nbsp;&nbsp;
                        :: Proveedor:&nbsp;<input type="checkbox" name="proveedor" id="proveedor" class="defaultcheckbox" value="1"  <?php if(isset($_REQUEST['proveedor'])){echo "checked";} ?>/>&nbsp;&nbsp; 
                        :: Empleado:&nbsp;<input type="checkbox" name="empleado" id="empleado" class="defaultcheckbox" value="1"  <?php if(isset($_REQUEST['empleado'])){echo "checked";} ?>/>
        			</td>    
       		 	</tr>               
    		</table>
    		<input name="oculto" type="hidden" value="1"/> 
    		<input type="hidden" value="0" name="bt"/>
            <input type="hidden" name="valfocus" id="valfocus" value="1"/> 
			<?php
 				//***** busca tercero
			 	if($_POST[bt]=='1')
			 	{
			  		$nresul=buscatercero($_POST[documento]);
			  		if($nresul!='')
			 		{			  
			  			echo"
			  				<script>
								despliegamodalm('visible','2','Tercero ya Existe');
								document.getElementById('valfocus').value='2';
			  				</script>";
			  		}
			 	}	
				$valor=$_POST[persona];
				switch ($valor) 
				{ 
   					case '1': 
						echo"
						<script>
								document.form2.nombre1.disabled = true;
								document.form2.nombre1.value = '';
								document.form2.nombre2.disabled = true;
								document.form2.nombre2.value = '';
								document.form2.apellido1.disabled = true;
								document.form2.apellido1.value = '';		
								document.form2.apellido2.disabled = true;
								document.form2.apellido2.value = '';		
								document.form2.razonsocial.disabled = false;	
							</script>";
      					break;
   					case '2':
						echo" 
							<script>
								document.form2.nombre1.disabled = false;
								document.form2.nombre2.disabled = false;
								document.form2.apellido1.disabled = false;
								document.form2.apellido2.disabled = false;
								document.form2.razonsocial.disabled = true;
								document.form2.razonsocial.value = '';	
							</script>";	
      	 				break ;
   					default: 
				} 
				if($_POST[oculto]=='2')
				{
					$mxa=selconsecutivo('terceros','id_tercero');
					$sqlr="INSERT INTO terceros (id_tercero,nombre1,nombre2,apellido1,apellido2,razonsocial,direccion,telefono,celular,email,web, tipodoc,cedulanit,codver,depto,mnpio,persona,regimen,contribuyente,proveedor,empleado,estado) VALUES ('$mxa','$_POST[nombre1]','$_POST[nombre2]', '$_POST[apellido1]','$_POST[apellido2]','$_POST[razonsocial]','$_POST[direccion]','$_POST[telefono]','$_POST[celular]','$_POST[email]','$_POST[web]', $_POST[tipodoc],'$_POST[documento]','$_POST[codver]','$_POST[dpto]','$_POST[mnpio]',$_POST[persona],$_POST[regimen],'$_POST[contribuyente]', '$_POST[proveedor]','$_POST[empleado]','S')";
  					if (!mysql_query($sqlr,$linkbd)){echo "<script>despliegamodalm('visible','2','No se pudo ejecutar la petición');</script>";}
  					else {echo "<script>despliegamodalm('visible','1','Se ha almacenado con Exito');</script>";}
 				}
			?>
		</form>
	</body>
</html>