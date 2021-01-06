<?php //V 1000 12/12/16 ?> 
<!--V 1.0 24/02/2015-->
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
	 	<?php require "head.php"; ?>
        <script>
			function guardar()
			{
				if (document.getElementById('ntercero').value !='' && document.getElementById('nombrecargo').value!='')
 				{despliegamodalm('visible','4','Esta Seguro de Guardar','1')}
 				else{despliegamodalm('visible','2','Faltan datos para completar el registro');}
 			}
			function despliegamodal2(_valor)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else {document.getElementById('ventana2').src="tercerosgral-funcionarios.php?objeto=tercero&nobjeto=ntercero&nfoco=nombrecargo";}
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
			function funcionmensaje(){document.location.href = "adm-asignacioncargosguardar.php";}
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
	</head>
	<body>
    	<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
        <table>
        	<tr><script>barra_imagenes("meci");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("meci");?></tr>
    		<tr>
  				<td colspan="3" class="cinta">
					<a onClick="location.href='adm-asignacioncargosguardar.php'" class="tooltip bottom mgbt"><img src="imagenes/add.png" /><span class="tiptext">Nuevo</span></a>
					<a onClick="guardar()" class="tooltip bottom mgbt"><img src="imagenes/guarda.png"/><span class="tiptext">Guardar</span></a>
					<a onClick="location.href='adm-asignacioncargosbuscar.php'" class="tooltip bottom mgbt"><img src="imagenes/busca.png" /><span class="tiptext">Buscar</span></a>
					<a onClick="<?php echo paginasnuevas("meci");?>" class="tooltip bottom mgbt"><img src="imagenes/nv.png"><span class="tiptext">Nueva Ventana</span></a>
					<a onClick="mypop=window.open('<?php echo $url2; ?>','','');mypop.focus();" class="tooltip bottom mgbt"><img src="imagenes/duplicar_pantalla.png"><span class="tiptext">Duplicar pestaña</span></a>
				</td>
			</tr>
		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
		<form name="form2" method="post" action="" >
        	<input type="hidden" name="valfocus" id="valfocus" value="0"/>
            <table class="inicio ancho" >
      			<tr>
       				<td class="titulos" colspan="5" width="100%">:: Asignar Cargo a Funcionario</td>
                  	<td class="boton02" onClick="location.href='meci-principal.php'">Cerrar</td>
                </tr>
                <tr>
               		<td class="saludo1" >:&middot; Funcionario:</td>
                    <td><input type="text" id="tercero" name="tercero" style="width:85%" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo $_POST[tercero]?>">&nbsp;<a onClick="despliegamodal2('visible');" title="Lista Funcionarios"><img src="imagenes/find02.png" style="width:20px; cursor:pointer;"></a></td>
                 	<td><input type="text" id="ntercero" name="ntercero" value="<?php echo $_POST[ntercero]?>" style="width:100%" readonly></td>
                    <td class="saludo1" style="width:10%">:&middot; Cargo:</td>
                    <td>
                    	<select id="nombrecargo" name="nombrecargo" class="Listahorasmen" style="width:100%;text-transform:uppercase">
                        <option value="">Seleccione....</option>
                     		<?php
								$sqlr="SELECT * FROM planaccargos WHERE estado='S'";
								$res=mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($res))
				    			{
					 				if($row[0]==$_POST[nombrecargo])
			 						{echo "<option value='$row[0]' SELECTED> &#8226; $row[2]</option>";}
					  				else {echo "<option value='$row[0]'> &#8226; $row[2]</option>";}
								}	
              				?> 
                    	</select>
                    </td>
                </tr>
			</table>
            <input type="hidden" value="0" name="bt">
            <input type="hidden" id="oculto" name="oculto" value="1">
			<?php
                if($_POST[bt]=='1')//***** busca tercero
				{
					$nresul=buscatercero($_POST[tercero]);
			  		if($nresul!='')
			   		{echo"<script>document.getElementById('ntercero').value='$nresul';document.getElementById('nombrecargo').focus();</script>";}
				 	else
					{echo"<script>document.getElementById('valfocus').value='1';despliegamodalm('visible','2','Documento Incorrecto');</script>";}
			 	}
                if ($_POST[oculto]=="2")
                {	
                    $mxa=selconsecutivo('planestructura_terceros','codestter');
         			$sqlr = "INSERT INTO planestructura_terceros (codestter,codcargo,cedulanit,estado) VALUES ($mxa,'$_POST[nombrecargo]','$_POST[tercero]','S')";
                	if (!mysql_query($sqlr,$linkbd)){echo"<script>despliegamodalm('visible','2',''Error no se almaceno el ');</script>";}
					else {echo"<script>despliegamodalm('visible','1','Se asigno el cargo con exito');</script>";}
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