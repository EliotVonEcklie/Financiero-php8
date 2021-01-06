<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
//**niveles menu: Administracion (0) - Consultas (1) - Herramientas (2) - Reportes (3)
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
    <title>:: Spid - Meci Calidad</title>
    <script type="text/javascript" src="css/programas.js"></script>
	<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
	<?php titlepag();?>
    <script>
    	function guardar()
		{
			if((document.form2.fechapro.value!='')&&(document.form2.nomplantilla.value!='')&&(document.form2.nomarch.value!='')&&(document.form2.versiona.value!=''))
			{
				if (confirm("Esta Seguro de Guardar")){document.form2.oculto.value=1;document.form2.submit();}
			}
			else{alert('Faltan datos para completar el registro');document.form2.fechapro.focus();document.form2.fechapro.select();}
		}
    </script>
</head>
<body>
    <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
    <span id="todastablas2"></span>
    <?php 
		if($_POST[oculto]=="")
		{
			$_POST[idoculto]=$_GET[codigo];
			$hoy=date('Y-m-d');
			$_POST[fechapro]=$hoy;
			$linkbd=conectar_bd();
			$sqlr="SELECT nombre,adjunto,version FROM contraclasecontratos WHERE id=$_POST[idoculto]";
			$row = mysql_fetch_row(mysql_query($sqlr,$linkbd));
			$_POST[nomplantilla]=$row[0];
			$nomarchivo=explode(".",$row[1]);
			$_POST[nomarch]=$nomarchivo[0];
			$_POST[exticono]=$nomarchivo[1];
			$_POST[oculto]=0;		
		}
	?>
	<table>
		<tr><script>barra_imagenes("meci");</script><?php cuadro_titulos();?></tr>	 
		<tr><?php menu_desplegable("meci");?></tr>
        <tr>
  			<td colspan="3" class="cinta"><a href="#" class="mgbt"><img src="imagenes/add2.png" border="0" /></a><a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a><a href="meci-plantillascontra.php"><img src="imagenes/busca.png" title="Buscar" border="0" /></a><a href="#" onClick="mypop=window.open('meci-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a>
            </td>
		</tr>
	</table>
	<form name="form2" method="post" enctype="multipart/form-data" > 
    <script>activapoli("<?php echo $_POST[estadopo];?>")</script>
  	<table class="inicio"> 
      	<tr>
       		<td class="titulos" colspan="9">Aprobar Plantilla Contrataci&oacute;n</td>
            <td width="11%" class="cerrar" ><a href="meci-principal.php">Cerrar</a></td>
		</tr> 
		<tr>
        	<td class="saludo1" style="width:12%">Fecha Aprobaci&oacute;n:</td>
   			<td style="width:10%"><input name="fechapro" type="date" style="width:95%" value="<?php echo $_POST[fechapro]?>" ></td>
            <td class="saludo1" style="width:12%"> Nombre Plantilla:</td>
   			<td style="width:25%" colspan="2"><input type="text" name="nomplantilla" id="nomplantilla"value="<?php echo $_POST[nomplantilla]?>" readonly style="width:98%"></td>
            <td class="saludo1" style="width:12%">Nombre Archivo:</td>
   			<td><input type="text" name="nomarch" id="nomarch"  style="width:90%" value="<?php echo $_POST[nomarch]?>" readonly><?php echo traeico($_POST[exticono])?></td>	
       	</tr>
        <tr>  
            <td class="saludo1">Versi&oacute;n:</td>
            <td>
            	<input name="versiona" type="text" style="width:25; text-align:right;" value="<?php echo $_POST[versiona]?>" onKeyPress="return solonumeros(event);">.<input name="versionb" type="text" style="width:25%;" value="<?php echo $_POST[versionb]?>" onKeyPress="return solonumeros(event);">
            </td>   
   		</tr>        
	</table>
    <div class="subpantallac5" style="height:64%; overflow-x: hidden;">
    <table class="inicio"> 
   		<?php
			$linkbd=conectar_bd();
			$sqlr="SELECT * FROM calplantillascontratacion WHERE nombreplantilla='$_POST[nomplantilla]' ORDER BY codigo DESC";
			$resp = mysql_query($sqlr,$linkbd);
			$ntr = mysql_num_rows($resp);
			echo "
					<tr>
						<td colspan='12' class='titulos'>.: Historial:</td>
					</tr>
					<tr>
						<td colspan='7'>Encontrados: $ntr</td>
					</tr>
					<tr>
						<td class='titulos2' style=\"width:5%\">Item</td>
						<td class='titulos2' style=\"width:5%\">Fecha</td>
						<td class='titulos2' style=\"width:25%\">Nombre Plantilla</td>
						<td class='titulos2' style=\"width:25%\">Nombre Archivo</td>
						<td class='titulos2' style=\"width:5%\">Formato</td>
						<td class='titulos2' style=\"width:5%\">Descargar</td>
						<td class='titulos2' style=\"width:5%\">Versi&oacute;n</td>
						<td class='titulos2' style=\"width:5%\">Estado</td>
						
					</tr>";	
			$iter='saludo1';
			$iter2='saludo2';
			$con=1;
			while ($row =mysql_fetch_row($resp)) 
			{
				$archalm=explode(".",$row[3]);
				echo "
					<tr class='$iter'>
						<td>$con</td>
						<td>$row[1]</td>
						<td>".strtoupper($row[2])."</td>
						<td>".strtoupper($archalm[0])."</td>
						<td align=\"middle\">".traeico($row[3])."</td>
						<td align=\"middle\"><a href=\"informacion/calidad_documental/calidaplantillascontra/".$row[3]."\" target=\"_blank\" ><img src=\"imagenes/descargar.png\" title=\"(Descargar)\"></a></td>
						<td align=\"middle\">$row[4]</td>
						<td align=\"middle\">$row[5]</td>
					</tr>";
				 $con+=1;
				 $aux=$iter;
				 $iter=$iter2;
				 $iter2=$aux;
			}
		?>    
	</table>
    </div>
    <input type="hidden" name="oculto" value="<?php echo $_POST[oculto]?>">
    <input type="hidden" name="idoculto" value="<?php echo $_POST[idoculto]?>">
    <input type="hidden" name="exticono" value="<?php echo $_POST[exticono]?>">
	<?php  
		//********guardar
		if ($_POST[oculto]==1)
		{
			$linkbd=conectar_bd();
			$sqlr="SELECT MAX(codigo) FROM calplantillascontratacion";
       		$row =mysql_fetch_row(mysql_query($sqlr,$linkbd));
			$codigo=$row[0];
			$codigo++;
			$versiont=$_POST[versiona].".".$_POST[versionb];
			$nomar=$_POST[nomarch].$_POST[versiona].$_POST[versionb].".".$_POST[exticono];
			$sqlr="INSERT INTO calplantillascontratacion (codigo,fechaversion,nombreplantilla,nombrearchivo,version,estado) VALUES ('$codigo', '$_POST[fechapro]','$_POST[nomplantilla]','$nomar','$versiont','S') ";
			mysql_query($sqlr,$linkbd);
			$sqlr="UPDATE contraclasecontratos SET version='$versiont' WHERE id='$_POST[idoculto]'";
			mysql_query($sqlr,$linkbd);
			$archivoo="informacion/plantillas_contratacion/".$_POST[nomarch].".".$_POST[exticono];
			echo $archivoo;
			$archivod="informacion/calidad_documental/calidaplantillascontra/".$nomar;
			echo $archivod;
			copy($archivoo, $archivod); 
			echo "<table id='ventanamensaje1' style='visibility:visible' class='inicio'><tr><td class='saludo1'><center>Se ha almacenado el la plantilla con Exito <img src='imagenes\confirm.png'></center></td></tr></table>";		
			?><script>document.form2.oculto.value=0;alert("Se ha almacenado el la plantilla con Exito");window.location.href="meci-plantillascontra.php"; </script><?php
		}
	 ?>
 </form>       
 </td>       
 </tr>       
		</table>
	</body>
</html>