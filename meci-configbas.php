<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	sesion();
	$_SESSION["usuario"] ;
	$_SESSION["perfil"] ;
	$_SESSION["linkset"] ;
	$linkbd=conectar_bd();
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<?php require "head.php";?>
		<title>:: :: Spid - Meci Calidad</title>
		<script>
			function guardar()
			{
				var validacion01=document.getElementById('razon').value;
				var validacion02=document.getElementById('nit').value;
				var validacion03=document.getElementById('direccion').value;
				if (validacion01.trim()!='' && validacion02.trim()!='' && validacion03.trim()!='' && document.getElementById('dpto').value!='' && document.getElementById('dpto').value!='' && document.getElementById('ntercero').value!='')
 				{despliegamodalm('visible','4','Esta Seguro de Guardar','1')}
 				else{despliegamodalm('visible','2','Faltan datos para completar el registro');}
 			}
			function despliegamodal2(_valor)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else {document.getElementById('ventana2').src="tercerosgral-ventana01.php?objeto=tercero&nobjeto=ntercero&nfoco=";}
			}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden")
				{
					document.getElementById('ventanam').src="";
					if (document.getElementById('valfocus').value =="1")
					{
						document.getElementById('valfocus').value='0';
						document.getElementById('ntercero').value='';
						document.getElementById('tercero').focus();
						document.getElementById('tercero').select();
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
			function funcionmensaje(){}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
				  case "1":	document.getElementById('oculto').value="2";
							document.form2.submit();break;
				}
			}
			function buscater(e){if (document.form2.tercero.value!=""){document.form2.bt.value='1';document.form2.submit();}}
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
   			<tr><script>barra_imagenes("meci");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("meci");?></tr>
			<tr>
  				<td colspan="3" class="cinta">
					<a class="tooltip bottom mgbt"><img src="imagenes/add2.png"/></a>
					<a onClick="guardar();" class="tooltip bottom mgbt"><img src="imagenes/guarda.png"/><span class="tiptext">Guardar</span></a>
					<a class="tooltip bottom mgbt"><img src="imagenes/buscad.png"/></a>
					<a onClick="mypop=window.open('meci-principal.php','','');mypop.focus();" class="tooltip bottom mgbt"><img src="imagenes/nv.png"><span class="tiptext">Nueva Ventana</span></a>
					<a onClick="mypop=window.open('<?php echo $url2; ?>','','');mypop.focus();" class="tooltip bottom mgbt"><img src="imagenes/duplicar_pantalla.png"><span class="tiptext">Duplicar pesta&ntilde;a</span></a>
				</td>
          	</tr>
     	</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>		  
		<form name="form2" method="post" >
        	<input type="hidden" name="valfocus" id="valfocus" value="0"/>
			<?php
				if($_POST[oculto]=="")
 				{
  					$sqlr="SELECT * FROM configbasica";
		 			$resp = mysql_query($sqlr,$linkbd);
				    while ($row =mysql_fetch_row($resp)) 
				    {	
						$_POST[nit]=$row[0];
					 	$_POST[razon]=$row[1];
					 	$_POST[direccion]=$row[2];
					 	$_POST[telefono]=$row[3];
					 	$_POST[web]=$row[4];
					 	$_POST[email]=$row[5];
					 	$_POST[ntercero]=$row[6];
					 	$_POST[estado]=$row[7];
					 	$_POST[contaduria]=$row[8];
 					 	$_POST[igac]=$row[9];
					 	$_POST[sigla]=$row[10];
					 	$_POST[liquidacion]=$row[11];
					 	$_POST[orden]=$row[12];
 					 	$_POST[tercero]=$row[13];
 					 	$_POST[dpto]=$row[14];
					 	$_POST[mnpio]=$row[15];										 					 
					}
 				}
			?>
  			<table class="inicio ancho" >
                <tr>
                    <td class="titulos" colspan="8" width="100%">Configuracion Entidad</td>
                    <td class='boton02' onclick="location.href='meci-principal.php'">Cerrar</td>
                </tr>
                <tr>
                    <td class="saludo1" style="width:2cm;">Razon Social: </td>
                    <td style="width:15%"><input type="text" name="razon" id="razon" value="<?php echo $_POST[razon];?>" style="width:100%"/></td>
                    <td class="saludo1" style="width:3cm;">Nit:</td>
                    <td style="width:15%"><input type="text" name="nit" id="nit" value="<?php echo $_POST[nit];?>" style="width:100%"/></td>
                    <td class="saludo1" style="width:1.7cm;">Sigla:</td>
                    <td style="width:15%"><input type="text" name="sigla" id="sigla" value="<?php echo $_POST[sigla];?>" style="width:100%"/></td>
                    <td class="saludo1" style="width:2cm;">Direccion:</td>
                    <td><input type="text" name="direccion" id="direccion" value="<?php echo $_POST[direccion];?>" style="width:100%"/></td>
                </tr>  
                <tr>
                    <td class="saludo1" style="width:2cm;">Dpto: </td>
                    <td style="width:15%">
                        <select name="dpto" id="dpto" onChange="document.form2.submit();" style="width:100%;">
                            <option value="-1">:::: Seleccione Departamento :::</option>
                            <?php
                                $sqlr="SELECT * FROM danedpto ORDER BY nombredpto";
                                $resp = mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($resp)) 
                                {
                                    if($row[1]==$_POST[dpto]){echo "<option value='$row[1]' SELECTED>$row[2]</option>";}
                                    else {echo "<option value='$row[1]'>$row[2]</option>";}
                                }
                            ?>
                        </select>
                    </td>
                    <td class="saludo1" style="width:3cm;">Municipio:</td>
                    <td >
                        <select name="mnpio" id="mnpio" style="width:100%">
                            <option value="-1">:::: Seleccione Municipio ::::</option>
                            <?php
                                $sqlr="SELECT * FROM danemnpio WHERE  danedpto='$_POST[dpto]' ORDER BY nom_mnpio";
                                $resp = mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($resp)) 
                                {
                                    if($row[2]==$_POST[mnpio]){echo "<option value='$row[2]' SELECTED>$row[3]</option>";}
                                    else {echo "<option value='$row[2]'>$row[3]</option>";}
                                }
                            ?>        
                        </select>
                    </td>
                    <td class="saludo1" style="width:1.7cm;">Telefonos:</td>
                    <td><input type="text" name="telefono" id="telefono" value="<?php echo $_POST[telefono];?>" style="width:100%"/></td>
                    <td class="saludo1" style="width:2cm;">Email:</td>
                    <td><input type="text" name="email" id="email" value="<?php echo $_POST[email];?>" style="width:100%"/></td>
                </tr>    
                <tr >
                    <td class="saludo1" style="width:2cm;">Web: </td>
                    <td><input type="text" name="web" id="web" value="<?php echo $_POST[web];?>" style="width:100%"/></td>
                    <td class="saludo1" style="width:3cm;">IGAC:</td>
                    <td><input type="text" name="igac" id="igac" value="<?php echo $_POST[igac];?>" style="width:100%"/></td>
                    <td class="saludo1" style="width:1.7cm;">Cod CGR:</td>
                    <td><input type="text" name="contaduria" id="contaduria" value="<?php echo $_POST[contaduria];?>" style="width:100%"/></td>
                    <td class="saludo1" style="width:2cm;">Orden:</td>
                    <td>
                        <select name="orden" onKeyUp="return tabular(event,this)" style="width:100%">
                            <option value="">Seleccione ...</option>
                            <option value="Nacional" <?php if($_POST[orden]=='Nacional') echo "SELECTED"?>>Nacional</option>
                            <option value="Dptal" <?php if($_POST[orden]=='Dptal') echo "SELECTED"?>>Dptal</option>
                            <option value="Mnpal" <?php if($_POST[orden]=='Mnpal') echo "SELECTED"?>>Mnpal</option>
                        </select>
                    </td>
                </tr>  
                <tr>
                    <td class="saludo1" style="width:2cm;">Liquidacion: </td>
                    <td>
                        <select name="liquidacion" onKeyUp="return tabular(event,this)" style="width:100%" >
                            <option value="">Seleccione ...</option>
                            <option value="S" <?php if($_POST[liquidacion]=='S') echo "SELECTED"?>>SI</option>
                            <option value="N" <?php if($_POST[liquidacion]=='N') echo "SELECTED"?>>NO</option>
                        </select>
                    </td>
                    <td class="saludo1" style="width:3cm;">Cedula Rep Legal:</td>
                    <td><input type="text" name="tercero" id="tercero" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo $_POST[tercero];?>" style="width:80%"/>&nbsp;<a onClick="despliegamodal2('visible');"><img src="imagenes/buscarep.png"/></a></td>
                    <td class="saludo1" style="width:1.7cm;">Rep Legal:</td>
                    <td colspan="3"><input type="text" name="ntercero" id="ntercero" value="<?php echo $_POST[ntercero];?>" style="width:100%" readonly/></td>
                </tr>  
            </table>
            <input type="hidden" name="bt" id="bt" value="0">
      		<input type="hidden" name="oculto" id="oculto" value="1">
      		<?php
	  			if($_POST[bt]=='1')
			 	{
			  		$nresul=buscatercero($_POST[tercero]);
			  		if($nresul!='')
			   		{echo"<script>document.getElementById('ntercero').value='$nresul';document.getElementById('nombrecargo').focus();</script>";}
				 	else
					{echo"<script>document.getElementById('valfocus').value='1';despliegamodalm('visible','2','Documento Incorrecto');</script>";}
			 	}
				if($_POST[oculto]=="2")
				{
					$sqlr="DELETE FROM configbasica";
					if (!mysql_query($sqlr,$linkbd))
						{echo"<script>despliegamodalm('visible','2',''Error al conectar la base');</script>";}
					else
					{
						$sqlr="INSERT INTO configbasica (nit,razonsocial,direccion,telefono,web,email,representante,estado, codcontaduria, igac,sigla,liquidacion,orden,cedulareplegal,depto,mnpio) VALUES ('$_POST[nit]','$_POST[razon]','$_POST[direccion]', '$_POST[telefono]', '$_POST[web]','$_POST[email]','$_POST[ntercero]','S','$_POST[contaduria]','$_POST[igac]','$_POST[sigla]', '$_POST[liquidacion]', '$_POST[orden]','$_POST[tercero]','$_POST[dpto]','$_POST[mnpio]')";
						if (!mysql_query($sqlr,$linkbd)){echo"<script>despliegamodalm('visible','2',''Error no se almaceno');</script>";}
						else {echo"<script>despliegamodalm('visible','3','Se almaceno la informaci�n con exito');</script>";}
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