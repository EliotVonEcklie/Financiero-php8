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
		<title>:: Spid - Contrataci&oacute;n</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<script>
			function guardar()
			{
				var validacion01=document.getElementById('codigo').value;
				var validacion02=document.getElementById('nombre').value;
				if (validacion01.trim()!='' && validacion02.trim()!='' && document.form2.contdet.value!=0)
			  		{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
			  	else
				{
			  		despliegamodalm('visible','2','Faltan datos para completar el registro');
					document.form2.nombre.focus();document.form2.nombre.select();
			  	}
			 }
			function agregardetalle()
			{
				validacion01=document.getElementById('nombredet').value
				validacion02=document.getElementById('iddet').value
				if(validacion01.trim()!='' && validacion02.trim()!=''){document.form2.agregadet.value=1;document.form2.submit();}
			 	else {despliegamodalm('visible','2','Falta información para poder Agregar Detalle de Modalidad');}
			}
			function eliminar(variable)
			{
				document.getElementById('elimina').value=variable;
				despliegamodalm('visible','4','Esta Seguro de Eliminar el Detalle de Modalidad','2');
			}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventanam').src="";}
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
			function funcionmensaje()
			{document.location.href = "contra-modalidad.php?idproceso="+document.getElementById('codigo').value}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.form2.oculto.value=2;document.form2.submit();break;
					case "2":	document.form2.contdet.value=parseInt(document.form2.contdet.value)-1;document.form2.submit();break;
				}
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("contra");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("contra");?></tr>
			<tr>
  				<td colspan="3" class="cinta">
					<a href="contra-modalidad.php" class="mgbt"><img src="imagenes/add.png"  title="Nuevo"/></a>
					<a href="#"  onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar"/></a>
					<a href="contra-modalidadbusca.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" onClick="mypop=window.open('contra-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a>
				</td>
			</tr>
     	</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
 		<form name="form2" method="post"> 
		<?php
    		$vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
 			if($_POST[oculto]=="")
			{
				$_POST[contdet]=0;
				$sqlr="SELECT MAX(CONVERT(VALOR_INICIAL, SIGNED INTEGER)) FROM dominios WHERE NOMBRE_DOMINIO='MODALIDAD_SELECCION' AND (VALOR_FINAL IS NULL or valor_final ='')";
				$resp = mysql_query($sqlr,$linkbd);
	    		while ($row =mysql_fetch_row($resp)){$mx=$row[0];}
				$_POST[codigo]=$mx+1;
			}
 		?>
            <table class="inicio" >
                <tr>
                    <td class="titulos" colspan="6">Crear Modalidad De Selecci&oacute;n</td>
                    <td class="cerrar" style='width:7%'><a href="contra-principal.php">&nbsp;Cerrar</a></td>
                </tr>
                <tr>
                    <td class="saludo1" style="width:8%">Codigo:</td>
                    <td style="width:10%;"><input type="text" name="codigo" id="codigo" value="<?php echo $_POST[codigo]?>" style="width:80%;" readonly></td>
                    <td class="saludo1"  style="width:8%;">Nombre:</td>
                    <td><input type="text" name="nombre" id="nombre" value="<?php echo $_POST[nombre]?>" style="width:93%;"></td>
					<td class="saludo1"  style="width:8%;">Abreviatura:</td>
                    <td><input type="text" name="abr" id="abr" value="<?php echo $_POST[abr]?>" style="width:20%;text-align:center;text-rendering:optimizeLegibility;text-transform: uppercase"></td>
                </tr>
                <tr>
                    <td class="saludo1">Estado:</td>
                    <td> 
                        <select name="estado" id="estado" onKeyUp="return tabular(event,this)" style="width:80%;">
                            <option value="S" <?php if($_POST[estado]=='S') echo "SELECTED"; ?>>Activo</option>
                            <option value="N" <?php if($_POST[estado]=='N') echo "SELECTED"; ?>>Inactivo</option>
                        </select>
                    </td>
                </tr>
            </table>
            <table class="inicio" >
                <tr><td class="titulos" colspan="4">Agregar Procedimiento / Causal</td></tr>
                <tr>
                    <td class="saludo1" style="width:8%">Id:</td>
                    <td style="width:10%;"><input type="text" name="iddet" id="iddet" value="<?php echo $_POST[iddet];?>" style="width:60%;"></td>
                    <td class="saludo1" style="width:8%">Nombre:</td>
                    <td>
                        <input type="text" name="nombredet" id="nombredet" value="<?php echo $_POST[nombredet];?>" style="width:54.5%;" >
                        <input type="button" name="agregar" id="agregar" value="   Agregar   " onClick="agregardetalle()" >
                    </td>
                </tr>
            </table> 
            <input type="hidden" name="oculto" value="1"/> 
            <input type="hidden" value="0" name="agregadet">
            <input type="hidden" name="contdet" id="contdet" value="<?php echo $_POST[contdet];?>"> 
            <input type='hidden' name='elimina' id='elimina' value="<?php echo $_POST[elimina];?>">  
            <div class="subpantalla" style="height:56%; width:99.6%; overflow-x:hidden;">
                <table class="inicio" >
                    <tr><td class="titulos" colspan="4">Detalles Modalidad</td></tr>
                    <tr>
                        <td class="titulos2">No</td>
                        <td class="titulos2">Nombre Variable</td>
                        <td class="titulos2"><img src="imagenes/del.png"></td>
                    </tr>    
                    <?php 
                        if ($_POST[elimina]!='')
                        { 
                            $posi=$_POST[elimina];
                            unset($_POST[dids][$posi]);
                            unset($_POST[dnvars][$posi]);
                            unset($_POST[dadjs][$posi]);		 		 		 		 		 
                            $_POST[dids]= array_values($_POST[dids]); 
                            $_POST[dnvars]= array_values($_POST[dnvars]); 
                            $_POST[dadjs]= array_values($_POST[dadjs]); 
                            echo"<script>document.form2.elimina.value='';</script>";	 		 		 
                        }	 
                        if ($_POST[agregadet]=='1')
                        {
							if (in_array($_POST[iddet], $_POST[dids]))
								{echo "<script>despliegamodalm('visible','2','ID del Detalle duplicado favor corregir');</script>";}
							else
							{
								$_POST[dids][]=$_POST[iddet];
								$_POST[dnvars][]=$_POST[nombredet];
								$_POST[dadjs][]=$_POST[adjuntodet]; 
								$_POST[agregadet]=0;
								echo "
								<script>
									document.form2.contdet.value=parseInt(document.form2.contdet.value)+1;
									document.form2.iddet.value='';
									document.form2.nombredet.value=''; 
									document.form2.iddet.focus();
								</script>";
							}
                        }
                        $iter='saludo1';
                        $iter2='saludo2';
                        for ($x=0;$x<count($_POST[dnvars]);$x++)
                        {		 
                            echo "
                            <tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase'>
                                <td>
                                    <input class='inpnovisibles' name='dids[]' value='".$_POST[dids][$x]."' type='text' size='5' readonly>
                                </td>
                                <td>
                                    <input class='inpnovisibles' name='dnvars[]' value='".$_POST[dnvars][$x]."' type='text' size='80' readonly>
                                </td>
                                <td><a href='#' onclick='eliminar($x)'><img src='imagenes/del.png'></a></td>
                            </tr>";
                            $aux=$iter;
                            $iter=$iter2;
                            $iter2=$aux;
                        }
                    ?>
                </table> 
            </div>     
 			<?php  
				//********guardar
				if($_POST[oculto]=="2")
				{
					$sqlr="insert into dominios (valor_inicial,descripcion_valor,nombre_dominio,tipo,descripcion_dominio) values ('$_POST[codigo]','$_POST[nombre]','MODALIDAD_SELECCION','$_POST[estado]','$_POST[abr]') ";	
					if (!mysql_query($sqlr,$linkbd))
					{
						echo"<script>despliegamodalm('visible','2',''ERROR EN LA CREACION');document.form2.nombre.focus();</script>";
					}
					else
					{
						for ($x=0;$x<count($_POST[dnvars]);$x++)
						{
							$sqlr="insert into DOMINIOS (valor_inicial,valor_final,descripcion_valor,nombre_dominio,tipo) values ('".$_POST[dids][$x]."','$_POST[codigo]','".$_POST[dnvars][$x]."','MODALIDAD_SELECCION','S') ";
							mysql_query($sqlr,$linkbd);
						}
						echo"<script>despliegamodalm('visible','1','Se ha almacenado la Modalidad de Contratación con Exito');</script>";
					}
				}
 			?>
 		</form>       
	</body>
</html>