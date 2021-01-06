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
    <script>
   
    </script>
    <script type="text/javascript" src="css/programas.js"></script>
	<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
    <?php titlepag();?>
</head>
<body>
    <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
    <span id="todastablas2"></span>
	<table>
		<tr><script>barra_imagenes("meci");</script><?php cuadro_titulos();?></tr>	 
		<tr><?php menu_desplegable("meci");?></tr>
        <tr>
  			<td colspan="3" class="cinta"><a href="#" class="mgbt"><img src="imagenes/add2.png" border="0" /></a><a href="#" class="mgbt"><img src="imagenes/guardad.png" /></a><a href="#" onClick="document.form2.submit()" class="mgbt"><img src="imagenes/busca.png" title="Buscar" border="0" /></a><a href="#" onClick="mypop=window.open('meci-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a></td>
		</tr>
	</table>	
 	<form name="form2" method="post" action="meci-plantillascontra.php" enctype="multipart/form-data">
	<table  class="inicio" align="center" >
		<tr>
     		<td class="titulos" colspan="4">:: Plnatillas Contrataci&oacute;n </td>
        	<td width="11%" class="cerrar" ><a href="meci-principal.php">Cerrar</a></td>
      	</tr>
      	<tr>
       	 	<td style="width:5%" class="saludo1">Nombre:</td>
        	<td style="width:30%"><input name="nombre" type="text" value="" size="40">
            </td>
            <td style="width:13%" class="saludo1">Plantilla:</td>
            <td style="width:43%"><input name="documento" type="text" id="documento" value="" size="40" ></td>
       	</tr>                       
    </table>
	<input name="oculto" type="hidden" value="1">
    <div class="subpantallac5" style="height:68%">
	<?php
		$oculto=$_POST['oculto'];
		if($_POST[oculto])
		{
			$linkbd=conectar_bd();
			$crit1=" ";
			$crit2=" ";
			if ($_POST[nombre]!=""){$crit1=" AND  nombre LIKE '%".$_POST[nombre]."%' ";}
			if ($_POST[documento]!=""){$crit2=" AND adjunto LIKE '%$_POST[documento]%' ";}
			$sqlr="SELECT * FROM contraclasecontratos WHERE estado='S' ".$crit1.$crit2." ORDER BY id";
			$resp = mysql_query($sqlr,$linkbd);
			$ntr = mysql_num_rows($resp);
			$con=1;
			echo "
				<table class='inicio' align='center' width='80%'>
					<tr>
						<td colspan='12' class='titulos'>.: Resultados Busqueda:</td>
					</tr>
					<tr>
						<td colspan='7'>Encontrados: $ntr</td>
					</tr>
					<tr>
						<td class='titulos2' style=\"width:5%\">Codigo</td>
						<td class='titulos2' style=\"width:25%\">Nombre Plantilla</td>
						<td class='titulos2' style=\"width:25%\">Nombre Archivo</td>
						<td class='titulos2' style=\"width:5%\">Formato</td>
						<td class='titulos2' style=\"width:5%\">Versi&oacute;n</td>
						<td class='titulos2' style=\"width:5%\">Estado</td>
						<td class='titulos2' style=\"width:5%\" >Descargar</td>
						<td class='titulos2' style=\"width:5%\" >Aprobado</td>
						<td class='titulos2' style=\"width:5%\" >Editar</td>
					</tr>";	
			$iter='saludo1';
			$iter2='saludo2';
			while ($row =mysql_fetch_row($resp)) 
			{
				if($row[4]!="")
				{$descargas='<a href="informacion/plantillas_contratacion/'.$row[4].'" target="_blank" ><img src="imagenes/descargar.png" title="(Descargar)" ></a>';}
				else {$descargas='<img src="imagenes/descargard.png" title="(Sin Plantilla)" >';}
				if($row[5]=="")
				{
					$darversion='<a href="meci-plantillascontrav.php?codigo='.$row[0].'"><img style="width:22px" src="imagenes/red_check.png" title="(Aprobar Version)" ></a>';
					$editar='<img src="imagenes/b_editd.png"  >';
				}
				else
				{
					$darversion='<img src="imagenes/confirm22.png" title="(Aprobado)" >';
					$editar='<a href="meci-plantillascontrae.php?codigo='.$row[0].'"><img src="imagenes/b_edit.png" title="(Editar)" ></a>';
				}
				$nomarchivo=explode(".",$row[4]);
				$icoext=traeico($row[4]);
				echo "
					<tr class='$iter'>
						
						<td>$row[0]</td>
						<td>".strtoupper($row[1])."</td>
						<td>".strtoupper($nomarchivo[0])."</td>
						<td align=\"middle\">$icoext</td>
						<td align=\"middle\">$row[5]</td>
						<td align=\"middle\">$row[2]</td>
						<td align=\"middle\">$descargas</td>
						<td align=\"middle\">$darversion</td>
						<td align=\"middle\">$editar</td>
					</tr>";
				 $con+=1;
				 $aux=$iter;
				 $iter=$iter2;
				 $iter2=$aux;
			 }
 echo"</table>";
}
?></div></form>  

</body>
</html>