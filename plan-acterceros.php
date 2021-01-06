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
		<title>:: SPID- Planeacion Estrategica</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
		<link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
        <script type='text/javascript' src='JQuery/jquery-2.1.4.min.js'></script>
        <script type="text/javascript" src="JQuery/alphanum/jquery.alphanum.js"></script>
		<script>
			function guardar()
			{
				var validacion01=document.getElementById('apellido1').value;
				var validacion02=document.getElementById('nombre1').value;
				var validacion03=document.getElementById('razonsocial').value;
				var validacion04=document.getElementById('direccion').value;
				var validacion05=document.getElementById('telefono').value;
				var validacion06=document.getElementById('celular').value;
				var validacion07=document.getElementById('email').value;
				if (document.getElementById('persona').value!='' && document.getElementById('regimen').value!='' && document.getElementById('tipodoc').value!='' && document.getElementById('documento').value!='' && ((validacion01.trim()!='' && validacion02.trim()!='') || validacion03.trim()!='') && ((validacion04.trim()!='' && (validacion05.trim()!='' || validacion06.trim()!='') && validacion06.trim()!='' && document.getElementById('dpto').value!='-1' && document.getElementById('mnpio').value != '-1' && (document.getElementById('contribuyente').checked || document.getElementById('proveedor').checked || document.getElementById('empleado').checked))||document.getElementById('particular').checked))
				{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
			  	else{despliegamodalm('visible','2','Faltan datos para completar el registro');}
 			}
			function validar(formulario){document.form2.submit();}
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
			function funcionmensaje(){document.location.href = "plan-acterceros.php";}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.form2.oculto.value="2";document.form2.submit();break;
				}
			}
			function cambiocheckbox(nomobj){if (document.getElementById(''+nomobj).checked){document.getElementById(''+nomobj).value="1"}}
			function buscater(e){if (document.form2.documento.value!=""){document.form2.bt.value='1';document.form2.submit();}}
		</script>

<?php titlepag();?>
</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
    	<table>
       		<tr><script>barra_imagenes("plan");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("plan");?></tr>
        	<tr>
				<td colspan="3" class="cinta"><a href="plan-acterceros.php" class="mgbt"><img src="imagenes/add.png"  title="Nuevo" /></a><a href="#"  onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png"  title="Guardar"/></a><a href="plan-actercerosbuscar.php" class="mgbt"><img src="imagenes/busca.png"  title="Buscar" border="0" /></a><a href="#" onClick="mypop=window.open('plan-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
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
					<td class="cerrar" style="width:7%;"><a href="plan-principal.php">&nbsp;Cerrar</a></td>
     			</tr>
	   			<tr>
        			<td class="saludo1" style='width:3.5cm;'>.: Tipo Persona:</td>
        			<td style='width:35%'>
                    	<select name="persona" id="persona" onChange="validar()" style='width:40%'>
							<option value="-1">...</option>
		 					<?php
  		   						$sqlr="Select * from personas where estado='1'";
		 						$resp = mysql_query($sqlr,$linkbd);
				   				 while ($row =mysql_fetch_row($resp)) 
				    			{
									if($row[0]==$_POST[persona]){echo "<option value=$row[0] SELECTED>$row[1]</option>";}
									else{echo "<option value=$row[0]>$row[1]</option>";}
								}
		  					?>
						</select>
        			</td>
                    <td class="saludo1" style='width:3.5cm'>.: Regimen:</td>
					<td>
                    	<select name="regimen" id="regimen" style='width:40%'>
						<?php
                            $sqlr="Select * from regimen where estado='1' order by id_regimen";
                            $resp = mysql_query($sqlr,$linkbd);
                            while ($row =mysql_fetch_row($resp)) 
                            {
                                if($row[0]==$_POST[regimen]){echo "<option value=$row[0] SELECTED>$row[1]</option>";}
                                else{echo "<option value=$row[0]>$row[1]</option>";}
                            }
                        ?>
						</select>
        			</td>
				</tr>
		   		<tr>
       				<td class="saludo1">.: Tipo Doc:</td>
        			<td>
                    	<select name="tipodoc" id="tipodoc" style='width:40%'>
				 		<?php
  		   					$sqlr="Select docindentidad.id_tipodocid,docindentidad.nombre from  docindentidad, documentopersona where docindentidad.estado='1' and documentopersona.persona=$_POST[persona] and documentopersona.tipodoc=docindentidad.id_tipodocid";
		 					$resp = mysql_query($sqlr,$linkbd);
				    		while ($row =mysql_fetch_row($resp)) 
				    		{
					 			if($row[0]==$_POST[tipodoc]){echo "<option value=$row[0] SELECTED>$row[1]</option>";}
								else{echo "<option value=$row[0]>$row[1]</option>";}
							}
		  				?>
						</select>
        			</td>
       				 <td class="saludo1">.: Documento:</td>
      				<td><input type="text" name="documento" id="documento" value="<?php echo $_POST[documento]?>" onKeyUp="return tabular(event,this)"  onBlur="buscater(event)" onKeyPress="codigover()" style='width:31%'>-<input type="text" name="codver" id="codver" style='width:8%'  value="<?php echo $_POST[codver]?>" readonly></td>
		   		</tr>
		 		<tr>
        			<td class="saludo1">.: Primer Apellido:</td>
        			<td><input type="text" id="apellido1" name="apellido1"  value="<?php echo $_POST[apellido1]?>" style='width:98%'></td>
         			<td class="saludo1">.: Segundo Apellido:</td>
        			<td><input id="apellido2" name="apellido2" type="text" value="<?php echo $_POST[apellido2]?>" style='width:98%'></td>
				</tr>
				<tr>
        			<td class="saludo1">.: Primer Nombre:</td>
       				<td><input id="nombre1" name="nombre1" type="text" value="<?php echo $_POST[nombre1]?>" style='width:98%'></td>
					<td class="saludo1">.: Segundo Nombre:</td>
        			<td><input id="nombre2" name="nombre2" type="text" value="<?php echo $_POST[nombre2]?>" style='width:98%'></td>
	  			</tr>
	   			<tr>
        			<td class="saludo1">.: Razon Social:</td>
        			<td><input name="razonsocial" id="razonsocial" type="text" value="<?php echo $_POST[razonsocial]?>" style='width:98%'></td>	
        			<td class="saludo1">.: Direccion:</td>
        			<td><input name="direccion" id="direccion" type="text" value="<?php echo $_POST[direccion]?>" style='width:98%'></td>
				</tr>
				<tr>
         			<td class="saludo1">.: Telefono:</td>
        			<td><input name="telefono" id="telefono" type="text" value="<?php echo $_POST[telefono]?>" style='width:98%'></td>
		 			<td class="saludo1">.: Celular:</td>
        			<td><input name="celular" id="celular" type="text" value="<?php echo $_POST[celular]?>" style='width:98%'></td>
       			</tr>  
	    		<tr>
        			<td class="saludo1">.: E-mail:</td>
        			<td><input name="email" id="email" type="text" value="<?php echo $_POST[email]?>" style='width:98%'></td>
         			<td class="saludo1">.: Pagina Web:</td>
        			<td><input name="web" id="web" type="text" value="<?php echo $_POST[web]?>" style='width:98%'></td>
       			</tr> 
	  			<tr>
        			<td class="saludo1">:: Dpto :</td>
        			<td>
                    	<select name="dpto" id="dpto" onChange="validar()" style='width:50%'>
                    		<option value="-1">:::: Seleccione Departamento :::</option>
            				<?php
  		   						$sqlr="Select * from danedpto order by nombredpto";
		 						$resp = mysql_query($sqlr,$linkbd);
				    			while ($row =mysql_fetch_row($resp)) 
				    			{
					 				if($row[1]==$_POST[dpto]){echo "<option value=$row[1] SELECTED>$row[2]</option>";}
									else{echo "<option value=$row[1]>$row[2]</option>";}
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
									else{echo "<option value=$row[2]>$row[3]</option>";}
								}
							?>        
        				</select>
       				</td>
      			</tr> 
	       		<tr>
        			<td class="saludo1">.: Tipo Tercero:</td>
        			<td colspan="3" > 
               			:: Contribuyente:<input type="checkbox" class="defaultcheckbox" name="contribuyente" id="contribuyente" value="<?php echo $_POST[contribuyente];?>" onClick="cambiocheckbox2('contribuyente','particular');" >
                   		:: Proveedor:<input type="checkbox" class="defaultcheckbox" name="proveedor" id="proveedor" value="<?php echo $_POST[proveedor]; ?>" onClick="cambiocheckbox2('proveedor','particular');">
  		 				:: Empleado:<input type="checkbox" class="defaultcheckbox" name="empleado" id="empleado" value="<?php echo $_POST[empleado];?>" onClick="cambiocheckbox2('empleado','particular');">
                        :: Particular:<input type="checkbox" class="defaultcheckbox" name="particular" id="particular" value="<?php echo $_POST[particular];?>" onClick="cambiocheckbox2('particular','contribuyente-proveedor-empleado');">
        			</td>    
        		</tr>           
    		</table>
            <input type="hidden" name="oculto" id="oculto" value="1">
            <input type="hidden" value="0" name="bt"/>
			<?php
				if ($_POST[contribuyente]=="1"){echo "<script>document.getElementById('contribuyente').checked=true;</script>";} 	
				if ($_POST[proveedor]=="1"){echo "<script>document.getElementById('proveedor').checked=true;</script>";}
				if ($_POST[empleado]=="1"){echo "<script>document.getElementById('empleado').checked=true;</script>";}
				if ($_POST[particular]=="1"){echo "<script>document.getElementById('particular').checked=true;</script>";}
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
   					case '-1': 	//alert("cambia");
      	 						break ;
   					case '1':	//alert("cambia"+valor);
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
								//ap1.disabled=true;
								//ap1.value="true";
      							break ;
   					case '2': 	//alert("cambia"+valor);
								echo"
								<script>
									document.form2.nombre1.disabled = false;
									document.form2.nombre2.disabled = false;
									document.form2.apellido1.disabled = false;
									document.form2.apellido2.disabled = false;
									document.form2.razonsocial.disabled = true;
									document.form2.razonsocial.value = '';	
								</script>";
								//document.form2.nombre1.disabled = true;
								//ap2.disabled=true;
								//ap2.value="true";
      	 						break ;
   					default: 	//Sentencias a ejecutar si el valor no es ninguno de los anteriores 
				} 
				if($_POST[oculto]=='2')
				{
 					$nr="1";
					$mxa=selconsecutivo('terceros','id_tercero');
					$sqlr="INSERT INTO terceros (id_tercero,nombre1,nombre2,apellido1,apellido2,razonsocial,direccion,telefono,celular,email, web,tipodoc,cedulanit,codver,depto,mnpio,persona,regimen,contribuyente,proveedor,empleado,estado) VALUES ('$mxa','$_POST[nombre1]','$_POST[nombre2]', '$_POST[apellido1]','$_POST[apellido2]','$_POST[razonsocial]','$_POST[direccion]','$_POST[telefono]','$_POST[celular]','$_POST[email]', '$_POST[web]',$_POST[tipodoc],'$_POST[documento]','$_POST[codver]','$_POST[dpto]','$_POST[mnpio]',$_POST[persona],$_POST[regimen], '$_POST[contribuyente]','$_POST[proveedor]','$_POST[empleado]','S')";
  					if (!mysql_query($sqlr,$linkbd))
					{
						$e =mysql_error(mysql_query($sqlr,$linkbd));
						echo"<script>despliegamodalm('visible','2','No se pudo ejecutar la petición: $e');</script>";
					}
  						else{echo"<script>despliegamodalm('visible','1','Se ha almacenado el Tercero con Exito');</script>";}
				}
			?>
            <script type="text/javascript">$('#apellido1,#apellido2,#nombre1,#nombre2').alphanum({allow: ''});</script>
            <script type="text/javascript">$('#razonsocial').alphanum({allow: '&'});</script>
            <script type="text/javascript">$('#direccion').alphanum({allow: '-'});</script>
            <script type="text/javascript">$('#email').alphanum({allow: '@_-.'});</script>
            <script type="text/javascript">$('#web').alphanum({allow: ':._-/&@'});</script>
            <script type="text/javascript">$('#telefono,#celular').alphanum({allow: '-',allowSpace: true, allowLatin: false});</script>
            <script type="text/javascript">$('#documento').numeric({allowThouSep: false,allowDecSep: false});</script>
 		</form>
	</body>
</html>