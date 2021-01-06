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
		<title>:: Spid - Gestion Humana</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
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
				if (document.getElementById('persona').value!='' && document.getElementById('regimen').value!='' && document.getElementById('tipodoc').value!='' && document.getElementById('documento').value!='' && ((validacion01.trim()!='' && validacion02.trim()!='') || validacion03.trim()!='') && validacion04.trim()!='' && (validacion05.trim()!='' || validacion06.trim()!='') && validacion06.trim()!='' && document.getElementById('dpto').value!='-1' && document.getElementById('mnpio').value !='-1' && document.getElementById('empleado').checked && document.getElementById('fc_1198971547').value!='' && document.getElementById('fc_1198971546').value !='' && document.getElementById('neps').value!='' && document.getElementById('narp').value!=''  && document.getElementById('nfondocesa').value!='' && document.getElementById('nivsal').value!='' && document.getElementById('pagces').value!='')
  				{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
  				else{despliegamodalm('visible','2','Faltan datos para completar el registro');}
 			}
			function validar(formulario){document.form2.submit();}
			function despliegamodal2(_valor,_nven)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else 
				{
					switch (_nven) 
					{ 
						case "1":	
							document.getElementById('ventana2').src="tercerosgral-ventana01.php?objeto=eps&nobjeto=neps&nfoco=arp";break;
						case "2":	
							document.getElementById('ventana2').src="tercerosgral-ventana01.php?objeto=arp&nobjeto=narp&nfoco=afp";break;
						case "3":	
							document.getElementById('ventana2').src="tercerosgral-ventana01.php?objeto=afp&nobjeto=nafp&nfoco=tipo";break;
						case "4":	
							document.getElementById('ventana2').src="tercerosgral-ventana01.php?objeto=fondocesa&nobjeto=nfondocesa&nfoco=cargo";break;
						case "5":	
							document.getElementById('ventana2').src="nivelsalarial-ventana01.php";break;
					
					}
				}
			}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden")
				{
					document.getElementById('ventanam').src="";
					switch(document.getElementById('valfocus').value)
					{
						case "0":	break;
						case "1": 	document.getElementById('valfocus').value='0';
									document.getElementById('neps').value='';
									document.getElementById('eps').focus();
									document.getElementById('eps').select();break;
						case "2": 	document.getElementById('valfocus').value='0';
									document.getElementById('narp').value='';
									document.getElementById('arp').focus();
									document.getElementById('arp').select();break;
						case "3": 	document.getElementById('valfocus').value='0';
									document.getElementById('nafp').value='';
									document.getElementById('afp').focus();
									document.getElementById('afp').select();break;
						case "4": 	document.getElementById('valfocus').value='0';
									document.getElementById('nfondocesa').value='';
									document.getElementById('fondocesa').focus();
									document.getElementById('fondocesa').select();break;
						case "5": 	document.getElementById('valfocus').value='0';
									document.getElementById('nivsal').value='';
									document.getElementById('asigbas').value='';
									document.getElementById('asigbas2').value='';
									document.getElementById('cargo').focus();
									document.getElementById('cargo').select();break;
					}
				}
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
			function funcionmensaje(){document.location.href = "hum-terceros.php";}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.getElementById('oculto').value="2";
								document.form2.submit();break;
				}
			}
			function busquedas(_nbus)
			{
				switch(_nbus)
				{
					case "1":	if (document.getElementById('eps').value!="")
								{document.getElementById('banbus').value="1";document.form2.submit();}
								break;
					case "2":	if (document.getElementById('arp').value!="")
								{document.getElementById('banbus').value="2";document.form2.submit();}
								break;
					case "3":	if (document.getElementById('afp').value!="")
								{document.getElementById('banbus').value="3";document.form2.submit();}
								break;
					case "4":	if (document.getElementById('fondocesa').value!="")
								{document.getElementById('banbus').value="4";document.form2.submit();}
								break;
					case "5":	if (document.getElementById('cargo').value!="")
								{document.getElementById('banbus').value="5";document.form2.submit();}
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
    		<tr><script>barra_imagenes("hum");</script><?php cuadro_titulos();?></tr>	 
    		<tr><?php menu_desplegable("hum");?></tr>
			<tr>
  				<td colspan="3" class="cinta"><a href="hum-terceros.php" class="mgbt"><img src="imagenes/add.png"  title="Nuevo" /></a><a href="#"  onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png"  title="Guardar" /></a><a href="hum-buscaterceros.php" class="mgbt"><img src="imagenes/busca.png"  title="Buscar" /></a><a href="#" onClick="mypop=window.open('hum-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a></td>
        	</tr>
     	</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
 		<form name="form2" method="post" action="">
        	<input type="hidden" name="valfocus" id="valfocus" value="0"/>
    		<table class="inicio" align="center">
      			<tr>
        			<td class="titulos" colspan="4">.: Agregar Terceros</td>
        			<td class="cerrar" style="width:7%;"><a href="hum-principal.php">&nbsp;Cerrar</a></td>
      			</tr>
	   			<tr>
        			<td class="saludo1" style="width:13%;">.: Tipo Persona:</td>
        			<td>
                    	<select name="persona" id="persona" style="width:30%;" onChange="validar()">
							<option value="-1">...</option>
		 					<?php
  		   						$sqlr="Select * from personas where estado='1'";
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
                    <td><input type="text" name="documento" id="documento" value="<?php echo $_POST[documento]?>" onKeyPress="javascript:return solonumeros(event)" onBlur="codigover()"  onKeyUp="return tabular(event,this)" style="width:35%;"/>&nbsp;-&nbsp;<input name="codver" type="text" id="codver" maxlength="1" value="<?php echo $_POST[codver]?>" style="width:6%;" readonly/></td>
		  		</tr>
		 		<tr>
        			<td class="saludo1">.: Primer Apellido:</td>
        			<td><input type="text" id="apellido1" name="apellido1"  value="<?php echo $_POST[apellido1]?>" style="width:98%;" onKeyUp="return tabular(event,this)"/></td>
         			<td class="saludo1">.: Segundo Apellido:</td>
        			<td><input type="text" id="apellido2" name="apellido2" value="<?php echo $_POST[apellido2]?>" style="width:100%;" onKeyUp="return tabular(event,this)"/></td>
        		</tr>
				<tr>
        			<td class="saludo1">.: Primer Nombre: </td>
        			<td><input type="text" id="nombre1" name="nombre1" value="<?php echo $_POST[nombre1]?>" style="width:98%;" onKeyUp="return tabular(event,this)"/></td>
					<td class="saludo1">.: Segundo Nombre:</td>
        			<td><input type="text" id="nombre2" name="nombre2" value="<?php echo $_POST[nombre2]?>" style="width:100%;" onKeyUp="return tabular(event,this)"/></td>
	  			</tr>
	   			<tr>
        			<td class="saludo1">.: Razon Social:</td>
        			<td colspan="3"><input type="text" name="razonsocial" id="razonsocial" value="<?php echo $_POST[razonsocial]?>" style="width:100%;" onKeyUp="return tabular(event,this)"/></td>	
             	</tr>  
	  			<tr>
        			<td class="saludo1">.: Direccion:</td>
        			<td colspan="3"><input type="text" name="direccion" id="direccion" value="<?php echo $_POST[direccion]?>" style="width:100%;" onKeyUp="return tabular(event,this)"/></td>
				</tr>
				<tr>
         			<td class="saludo1">.: Telefono:</td>
        			<td><input type="text" name="telefono" id="telefono" value="<?php echo $_POST[telefono]?>" style="width:98%;" onKeyUp="return tabular(event,this)"/></td>
		 			<td class="saludo1">.: Celular:</td>
        			<td><input  type="text" name="celular" id="celular" value="<?php echo $_POST[celular]?>" style="width:100%;" onKeyUp="return tabular(event,this)"/></td>
      	 		</tr>  
	    		<tr>
        			<td class="saludo1">.: E-mail:</td>
        			<td><input type="text" name="email" id="email" value="<?php echo $_POST[email]?>" style="width:98%;" onKeyUp="return tabular(event,this)"/></td>
         			<td class="saludo1">.: Pagina Web: </td>
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
									echo "";
					 				if($row[1]==$_POST[dpto]){echo "<option value='$row[1]' SELECTED>$row[2]</option>";}
					 				else {echo "<option value='$row[1]'>$row[2]</option>";}
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
					 				if($row[2]==$_POST[mnpio]){echo "<option value='$row[2]' SELECTED>$row[3]</option>";}
					  	  			else {echo "<option value='$row[2]'>$row[3]</option>";}
								}
							?>        
        				</select>
                	</td>
      			</tr> 
	       		<tr style="height:22px;">
        			<td class="saludo1">.: Tipo Tercero:</td>
        			<td colspan="3" > 
                    	::: Contribuyente:&nbsp;<input type="checkbox" name="contribuyente" id="contribuyente" class="defaultcheckbox" value="1" <?php if(isset($_REQUEST['contribuyente'])){echo "checked";} ?>/>&nbsp;&nbsp;
                        :: Proveedor:&nbsp;<input type="checkbox" name="proveedor" id="proveedor" class="defaultcheckbox" value="1"  <?php if(isset($_REQUEST['proveedor'])){echo "checked";} ?>/>&nbsp;&nbsp; 
  		 				:: Empleado:&nbsp;<input type="checkbox" name="empleado" id="empleado" class="defaultcheckbox" value="1" checked disabled>
        			</td>    
            	</tr>               
				<tr>
 					<td class="saludo1">.: Fecha Ingreso:</td>
        			<td><input type="text" name="fechain" id="fc_1198971547" value="<?php echo $_POST[fechain]?>" maxlength="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" style="width:32%;"/>&nbsp;<a href="#" onClick="displayCalendarFor('fc_1198971547');"><img src="imagenes/buscarep.png" align="absmiddle"></a> 
 					<td class="saludo1">.: Fecha Nacimiento:</td>
        			<td><input type="text" name="fechan" id="fc_1198971546" value="<?php echo $_POST[fechan]?>" maxlength="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" style="width:32%;"/>&nbsp;<a href="#" onClick="displayCalendarFor('fc_1198971546');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a></td>
				</tr>
				<tr>
 					<td class="saludo1">.: EPS:</td>
            		<td><input type="text" name="eps" id="eps" value="<?php echo $_POST[eps]?>" onKeyUp="return tabular(event,this)" style="width:32%;" onBlur="busquedas('1')"/>&nbsp;<a href="#" onClick="despliegamodal2('visible','1');"><img src="imagenes/buscarep.png" align="absmiddle"></a>&nbsp;<input type="text" id="neps" name="neps" value="<?php echo $_POST[neps]?>" onKeyUp="return tabular(event,this)"  style="width:60%;" readonly/></td>
 					<td class="saludo1">.: ARP: </td>
        			<td><input type="text" id="arp" name="arp" value="<?php echo $_POST[arp]?>" onKeyUp="return tabular(event,this)"  style="width:32%;" onBlur="busquedas('2')"/>&nbsp;<a href="#" onClick="despliegamodal2('visible','2');"><img src="imagenes/buscarep.png" align="absmiddle"/></a>&nbsp;<input id="narp" name="narp" type="text" value="<?php echo $_POST[narp]?>" onKeyUp="return tabular(event,this)"  style="width:60%;" readonly></td>
				</tr>
				<tr>
 					<td class="saludo1">.: AFP:</td>
        			<td>
                    	<input type="text" id="afp" name="afp" value="<?php echo $_POST[afp]?>" onKeyUp="return tabular(event,this)" style="width:32%;" onBlur="busquedas('3');"/>&nbsp;<a href="#" onClick="despliegamodal2('visible','3');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>&nbsp;<input id="nafp" name="nafp" type="text" value="<?php echo $_POST[nafp]?>" onKeyUp="return tabular(event,this)" style="width:60%;" readonly> 
                    	<select name="tipo" id="tipo" onChange="validar()" style="width:32%;">  			
            				<option value="PB" <?php if($_POST[tipo]=='PB') echo "SELECTED"?>>Publico</option>
            				<option value="PR" <?php if($_POST[tipo]=='PR') echo "SELECTED"?>>Privado</option>
                			<option value="N/A" <?php if($_POST[tipo]=='N/A') echo "SELECTED"?>>N/A</option>
						</select>
            		</td>
 					<td class="saludo1">.: Fondo Cesantias:</td>
        			<td><input id="fondocesa" name="fondocesa" type="text" value="<?php echo $_POST[fondocesa]?>" onKeyUp="return tabular(event,this)" style="width:32%;" onBlur="busquedas('4')"/>&nbsp;<a href="#" onClick="despliegamodal2('visible','4');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>&nbsp;<input id="nfondocesa" name="nfondocesa" type="text" value="<?php echo $_POST[nfondocesa]?>" onKeyUp="return tabular(event,this)" style="width:60%;" readonly></td>
				</tr>
				<tr>
 					<td class="saludo1">.: Escala:</td>
        			<td><input type="text" name="cargo" id="cargo" value="<?php echo $_POST[cargo]?>" onKeyUp="return tabular(event,this)" style="width:32%;" onBlur="busquedas('5')"/>&nbsp;<a href="#" onClick="despliegamodal2('visible','5');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>&nbsp;<input type="text" name="nivsal" id="nivsal" value="<?php echo $_POST[nivsal]?>"  onKeyUp="return tabular(event,this)" style="width:60%;" readonly></td>
 					<td class="saludo1">.: Asignacion Basica:</td>
        			<td><input type="text" name="asigbas2" id="asigbas2" value="<?php echo $_POST[asigbas]?>" onKeyUp="return tabular(event,this)" style="width:98%;" readonly/></td>
				</tr>
				<tr>	  
                	<td class="saludo1">Centro Costo:</td>
	  				<td>
						<select name="cc" id="cc" onChange="validar()" onKeyUp="return tabular(event,this)">
							<?php
								$sqlr="select *from centrocosto where estado='S'";
								$res=mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($res)) 
				    			{
					 				if($row[0]==$_POST[cc]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
									else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
								}	 	
							?>
   						</select>
					</td>
					<td class="saludo1">.: Pago Cesantias:</td>
        			<td>
            			<select name="pagces" id="pagces" style="width:32%;">
                			<option value="" <?php if($_POST[pagces]==""){echo "SELECTED";} ?>> ...</option>
                			<option value="A" <?php if($_POST[pagces]=="A"){echo "SELECTED";} ?>> Anual</option>
                			<option value="M" <?php if($_POST[pagces]=="M"){echo "SELECTED";} ?>> Mensual</option>
						</select>
        			</td>
				</tr>
    		</table>
            <input type="hidden" name="asigbas" id="asigbas" value="<?php echo $_POST[asigbas]?>"/>
            <input type="hidden" name="banbus" id="banbus" value=""/>
    		<input type="hidden" name="oculto" id="oculto" value="1">
			<?php
				$valor=$_POST[persona];
				switch ($valor) 
				{ 
   					case '1': 	echo"
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
								</script>";break;
   					case '2': 	echo"
								<script>
									document.form2.nombre1.disabled = false;
									document.form2.nombre2.disabled = false;
									document.form2.apellido1.disabled = false;
									document.form2.apellido2.disabled = false;
									document.form2.razonsocial.disabled = true;
									document.form2.razonsocial.value = '';	
								</script>";break;
   					default: 	break;
				} 
				if($_POST[banbus]!='')
				{
					switch ($_POST[banbus]) 
					{ 
						case '1':	
							$nresul=buscatercero($_POST[eps]);
							if($nresul!='')
							{echo"<script>document.getElementById('neps').value='$nresul';document.getElementById('arp').focus();</script>";}
							else
							{echo"<script>document.getElementById('valfocus').value='1';despliegamodalm('visible','2','Documento Incorrecto');</script>";}break;
						case '2':	
							$nresul=buscatercero($_POST[arp]);
							if($nresul!='')
							{echo"<script>document.getElementById('narp').value='$nresul';document.getElementById('afp').focus();</script>";}
							else
							{echo"<script>document.getElementById('valfocus').value='2';despliegamodalm('visible','2','Documento Incorrecto');</script>";}break;
						case '3':	
							$nresul=buscatercero($_POST[afp]);
							if($nresul!='')
							{echo"<script>document.getElementById('nafp').value='$nresul';document.getElementById('fondocesa').focus();</script>";}
							else
							{echo"<script>document.getElementById('valfocus').value='3';despliegamodalm('visible','2','Documento Incorrecto');</script>";}break;
						case '4':	
							$nresul=buscatercero($_POST[fondocesa]);
							if($nresul!='')
							{echo"<script>document.getElementById('nfondocesa').value='$nresul';document.getElementById('cargo').focus();</script>";}
							else
							{echo"<script>document.getElementById('valfocus').value='4';despliegamodalm('visible','2','Documento Incorrecto');</script>";}break;
						case '5':	
							$nresul=buscaescalas($_POST[cargo]);
							if($nresul[0]!='')
							{
								echo"
								<script>
									document.getElementById('nivsal').value='$nresul[0]';
									document.getElementById('asigbas').value='$nresul[1]';
									document.getElementById('asigbas2').value='$ ".number_format($nresul[1], 0, ',', '.')."';
									document.getElementById('cc').focus();
								</script>";
							}
							else
							{echo"<script>document.getElementById('valfocus').value='5';despliegamodalm('visible','2','Nivel Incorrecto');</script>";}break;
					}
				}
				if($_POST[oculto]=='2')
				{
					if ($_POST[documento]!="")
 					{
 						$nr="1";
						$mxa=selconsecutivo('terceros','id_tercero');
						$sqlr="INSERT INTO terceros (id_tercero,nombre1,nombre2,apellido1,apellido2,razonsocial,direccion,telefono, celular,email,web,tipodoc,cedulanit,codver,depto,mnpio,persona,regimen, contribuyente,proveedor,empleado,estado)VALUES ('$mxa','$_POST[nombre1]','$_POST[nombre2]', '$_POST[apellido1]','$_POST[apellido2]','$_POST[razonsocial]','$_POST[direccion]','$_POST[telefono]','$_POST[celular]','$_POST[email]','$_POST[web]',$_POST[tipodoc],'$_POST[documento]','$_POST[codver]','$_POST[dpto]','$_POST[mnpio]',$_POST[persona],$_POST[regimen],'$_POST[contribuyente]', '$_POST[proveedor]','1','S')";
 						if (!mysql_query($sqlr,$linkbd))
						{echo "<script>despliegamodalm('visible','2','Manejador de Errores de la Clase BD, No se pudo ejecutar la petici�n terceros');</script>";}
  						else
  						{
	 						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechain],$fecha);
							$fechai=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	 						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechan],$fecha);
							$fechana=$fecha[3]."-".$fecha[2]."-".$fecha[1];
							$sqlr="INSERT INTO terceros_nomina (`cedulanit`, `fechaing`, `fechanac`, `eps`, `arp`, `afp`, `fondocesantias`, `cargo`, `asignacion`, `cc`, `estado`, `fondopensionestipo`,`pcesantias`)VALUES ('$_POST[documento]','$fechai','$fechana','$_POST[eps]','$_POST[arp]','$_POST[afp]','$_POST[fondocesa]',$_POST[cargo],$_POST[asigbas],'$_POST[cc]','S','$_POST[tipo]','$_POST[pagces]')";
							mysql_query($sqlr,$linkbd);  
  							echo "<script>despliegamodalm('visible','1','Se ha almacenado con Exito');</script>";
 						}
					}
					else{echo "<script>despliegamodalm('visible','2','Falta informacion para Crear el Tercero');</script>";}
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