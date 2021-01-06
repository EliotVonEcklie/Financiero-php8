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
				var validacion01=document.getElementById('codigo').value
				var validacion02=document.getElementById('nombre').value
				if (validacion01.trim()!='' && validacion02.trim()!=''){despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
				else
				{
					despliegamodalm('visible','2','Faltan datos para completar el registro');
					document.form2.nombre.focus();
					document.form2.nombre.select();
				}
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
			function funcionmensaje(){document.location.href = "contra-clasecontratos.php";}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.form2.oculto.value=2;document.form2.submit();break;
				}
			}
		</script>
		<?php
            titlepag();
            function eliminarDir()
            {
                $carpeta="informacion/plantillas_contratacion/temp";
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
            <tr><script>barra_imagenes("contra");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("contra");?></tr>
            <tr>
  				<td colspan="3" class="cinta">
					<a href="contra-clasecontratos.php" class="mgbt"><img src="imagenes/add.png" TITLE="Nuevo" border="0" /></a>
					<a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a>
					<a href="contra-clasecontratosbusca.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" border="0" /></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" onClick="mypop=window.open('contra-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva ventana"></a>
				</td>
         	</tr>
    	</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
		<form name="form2" method="post" enctype="multipart/form-data"> 
 		<?php
    		$vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
   			$linkbd=conectar_bd(); 
 			if($_POST[oculto]=="")
			{
				$sqlr="Select max(id) from contraclasecontratos  ";
				$resp = mysql_query($sqlr,$linkbd);
	    		while ($row =mysql_fetch_row($resp))
				{
					$mx=$row[0];
				}
				$_POST[codigo]=$mx+1;
			}
 
 		?>
		<table class="inicio" >
            <tr>
                <td class="titulos" colspan="5">Crear Clase de Contrato</td>
                <td class="cerrar" style='width:7%'><a href="contra-principal.php">&nbsp;Cerrar</a></td>
            </tr>
            <tr>
                <td class="saludo1" style='width:10%'>C&oacute;digo:</td>
                <td colspan="2" style='width:30%'><input type="text" name="codigo" id="codigo" value="<?php echo $_POST[codigo]?>" style='width:15%' readonly></td>
                <td class="saludo1" style='width:10%'>Nombre:</td>
                <td><input type="text" name="nombre" id="nombre" value="<?php echo $_POST[nombre]?>" style='width:70%'></td>
            </tr>
   			<tr>
                <td class="saludo1">Plantilla:</td>
                <td><input type="text" name="nomarch" id="nomarch"  style="width:100%" value="<?php echo $_POST[nomarch]?>" readonly></td>
                <td>
                    <div class='upload'> 
                    	<a href="#" title="Cargar Documento"><input type="file" name="plantillaad" onChange="document.form2.submit();"  title="(Cargar)" /><img src='imagenes/upload01.png' style="width:18px" title='(Cargar)' /></a>
                    </div> 
                </td>
   				<td class="saludo1">Estado:</td>
                <td> 
                    <select name="estado" id="estado" onKeyUp="return tabular(event,this)" >
                        <option value="S" <?php if($_POST[estado]=='S') echo "SELECTED"; ?>>Activo</option>
                        <option value="N" <?php if($_POST[estado]=='N') echo "SELECTED"; ?>>Inactivo</option>
                    </select>
                </td>
   			</tr>
		</table>
		<input type="hidden" name="oculto" value="1">
		<?php  
			if($_POST[oculto]=="2")//********guardar
			{	
				if($_POST[nomarch]!="")
				{
					$sqlr="UPDATE dominios SET descripcion_dominio='$_POST[nomarch]' WHERE valor_inicial=$_POST[submodalidad] AND valor_final=$_POST[modalidad] AND nombre_dominio='MODALIDAD_SELECCION' AND valor_final IS NOT NULL ";
					copy("informacion/plantillas_contratacion/temp/$_POST[nomarch]",("informacion/plantillas_contratacion/$_POST[nomarch]"));
				}
				$sqlr="INSERT INTO contraclasecontratos (id,nombre,estado,Fijo,adjunto,version) VALUES ('$_POST[codigo]','$_POST[nombre]', '$_POST[estado]','S','$_POST[nomarch]','') ";	
				if (!mysql_query($sqlr,$linkbd)){echo"<script>despliegamodalm('visible','2','ERROR EN LA CREACION DEL ANEXO');</script>";}
				else{echo"<script>despliegamodalm('visible','1','Se ha almacenado la Clase de Contrato con Exito');</script>";}
			}
			if (is_uploaded_file($_FILES['plantillaad']['tmp_name'])) //archivos
			{
				$sqlr="SELECT adjunto FROM contraclasecontratos";
				$res=mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($res))
				{$archad[]=$row[0];}
				if (in_array($_FILES['plantillaad']['name'], $archad))
				{echo"<script>despliegamodalm('visible','2','Ya existe una Plantilla con este nombre');</script>";}
				else
				{
					$rutaad="informacion/plantillas_contratacion/temp/";
					if(!file_exists($rutaad)){mkdir ($rutaad);}
					else {eliminarDir();mkdir ($rutaad);}
					echo"<script>document.getElementById('nomarch').value='".$_FILES['plantillaad']['name']."';</script>"; 
					copy($_FILES['plantillaad']['tmp_name'], $rutaad.$_FILES['plantillaad']['name']);
				}
			}
 		?>
 		</form>       
	</body>
</html>