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
   <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="css/programas.js"></script>
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
            	<a href="#"><img src="imagenes/add2.png" border="0" /></a>
                <a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guardad.png"/></a> 
            	<a href="#" onClick="document.form2.menubotones.value='1';document.form2.submit();" class="mgbt"><img src="imagenes/busca.png" title="Buscar" border="0"/></a> 
                <a href="#" onClick="mypop=window.open('meci-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
        	<?php
			if ($_POST[menubotones]==""){echo'<a href="#"><img src="imagenes/csvb.png"></a>';}
			else
			{echo'<a href="informacion/temp/documentos_en_mejora.csv" target="_blank""><img src="imagenes/csv.png"  title="csv"></a>';}
			?>
            </td>
</tr>
</table>	
 <form name="form2" method="post" action="meci-docenmejora.php" enctype="multipart/form-data">
<table  class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="4">:: Buscar Documentos En Mejora </td>
        <td width="11%" class="cerrar" ><a href="meci-principal.php">Cerrar</a></td>
      </tr>
      <tr >
        <td style="width:5%" class="saludo1">Proceso:</td>
        <td style="width:30%"><input name="nombre" type="text" value="" size="40">
        </td>
        <td style="width:13%" class="saludo1">C&oacute;digo SPID:</td>
        <td style="width:43%"><input name="documento" type="text" id="documento" value=""  maxlength="16"></td>
       </tr>                       
    </table>
	<input name="oculto" type="hidden" value="1">
    <input name="iddel" id="iddel" type="hidden" value="<?php echo $_POST[iddel]?>">
    <input name="ocudel" id="ocudel" type="hidden" value="<?php echo $_POST[ocudel]?>">
    <input name="archdel" id="archdel" type="hidden" value="<?php echo $_POST[archdel]?>">
    <input name="nomdel" id="nomdel" type="hidden" value="<?php echo $_POST[nomdel]?>">
    <input name="idclase" id="idclase" type="hidden" value="<?php echo $_POST[idclase]?>">
    <input name="ocudelplan" id="ocudelplan" type="hidden" value="<?php echo $_POST[ocudelplan]?>">
    <input name="contador" id="contador" type="hidden" value="<?php echo $_POST[contador]?>">
    <input name="menubotones" id="menubotones" type="hidden" value="<?php echo $_POST[menubotones]?>">
    <div class="subpantallac5" style="height:68%">
	<?php
		$oculto=$_POST['oculto'];
		if($_POST[oculto])
		{
			$contad=0;
			$linkbd=conectar_bd();
			$crit1=" ";
			$crit2=" ";
			$namearch="informacion/temp/documentos_en_mejora.csv";
			$Descriptor1 = fopen($namearch,"w+"); 
			if ($_POST[nombre]!="")
			{$crit1=" AND cgd.proceso= ANY (SELECT id FROM calprocesos WHERE nombre LIKE '%".$_POST[nombre]."%') ";}
			if ($_POST[documento]!=""){$crit2=" AND cgd.codigospid LIKE '%$_POST[documento]%' ";}
			//sacar el consecutivo 
			$sqlr="SELECT cgd.*, cld.* FROM calgestiondoc cgd, callistadoc cld WHERE cgd.idarchivo=cld.id AND cld.estado='N' ".$crit1.$crit2." ORDER BY cgd.proceso, cgd.id";
			$resp = mysql_query($sqlr,$linkbd);
			$ntr = mysql_num_rows($resp);
			$con=1;
			echo "
				<table class='inicio' align='center' width='80%'>
					<tr>
						<td colspan='11' class='titulos'>.: Resultados Busqueda:</td>
					</tr>
					<tr>
						<td colspan='7'>Encontrados: $ntr</td>
					</tr>
					<tr>
						<td class='titulos2' style=\"width:3%\">Item</td>
						<td class='titulos2' style=\"width:7%\">C&oacute;digo SPID</td>
						<td class='titulos2' style=\"width:18%\">Procesos</td>
						<td class='titulos2' style=\"width:10%\">Documentos</td>
						<td class='titulos2' style=\"width:10%\">Pol&iacute;ticas</td>
						<td class='titulos2' style=\"width:3%\" >Plantilla</td>
						<td class='titulos2' style=\"width:3%\">Versi&oacute;n</td>
						<td class='titulos2' style=\"width:4%\">Fecha En Mejora</td>
					</tr>";	
			fputs($Descriptor1,"ITEM;CODIGO SPID;PROCESOS;DOCUMENTOS;POLITICAS;ARCHIVO;VERSION;FECHA EN MEJORA\r\n");
			$iter='saludo1';
			$iter2='saludo2';
			while ($row =mysql_fetch_row($resp)) 
			{
				$sqlr2="SELECT nombre FROM calprocesos WHERE id='".$row[1]."'";
				$res2=mysql_query($sqlr2,$linkbd);
				$row2 = mysql_fetch_row($res2);
				$procesos=$row2[0];
				$sqlr2="SELECT nombre FROM caldocumentos WHERE id='".$row[2]."'";
				$res2=mysql_query($sqlr2,$linkbd);
				$row2 = mysql_fetch_row($res2);
				$documentos=$row2[0];
				$sqlr2="SELECT descripcion_valor FROM dominios WHERE nombre_dominio='TIPOS_DE_POLITICAS' AND valor_inicial='".$row[3]."'";
				$res2=mysql_query($sqlr2,$linkbd);
				$row2 = mysql_fetch_row($res2);
				$politicas=$row2[0];
				$bdescargar='<a href="informacion/calidad_documental/documentos/'.$row[15].'" target="_blank" ><img src="imagenes/descargar.png" title=\'(Descargar)\' title="(Descargar)" ></a>';
				$contad++;
				if($politicas==""){$nombredel=strtoupper($procesos)."\\n".strtoupper($documentos);}
				else{$nombredel=strtoupper($procesos)."\\n".strtoupper($politicas);}
				echo "
					<tr class='$iter'>
						<td>".$con."</td>
						<td>".$row[4]."</td>
						<td>".strtoupper($procesos)."</td>
						<td>".strtoupper($documentos)."</td>
						<td>".strtoupper($politicas)."</td>
						<td align=\"middle\">".$bdescargar."</td>
						<td align=\"middle\">".$row[11]."</td>
						<td align=\"middle\">".$row[17]."</td>
					</tr>";
				fputs($Descriptor1,$con.";".$row[4].";".strtoupper($procesos).";".strtoupper($documentos).";".strtoupper($politicas).";".$row[15].";".$row[11].";".$row[17]."\r\n");
				 $con+=1;
				 $aux=$iter;
				 $iter=$iter2;
				 $iter2=$aux;
			 }
 			echo"</table>";
			fclose($Descriptor1);
		}
	?>
</div></form>
</td></tr>     
</table>
</body>
</html>