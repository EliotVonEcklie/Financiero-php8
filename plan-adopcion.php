<?php //V 1000 12/12/16 ?> 
<?php
require"comun.inc";
require"funciones.inc";
session_start();

//**niveles menu: Administracion (0) - Consultas (1) - Herramientas (2) - Reportes (3)
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html" />
    <meta http-equiv="X-UA-Compatible" content="IE=9" />
    <title>::SPID-Planeaci&oacute;n Estrat&eacute;gica</title>
    <link href="css/css2.css" rel="stylesheet" type="text/css" />
    <link href="css/css3.css" rel="stylesheet" type="text/css" />
    <script>
    function guardar()
    {
        if (document.form2.documento.value!='')
        {
            if (confirm("Esta Seguro de Guardar")){document.form2.oculto.value=2;document.form2.submit();}
        }
        else{alert('Faltan datos para completar el registro');}
    }
    function eliminar_inf(codigo,nombredel)
    {
        if (confirm("Seguro desea Anular:\n"+nombredel.toUpperCase()))
        {
          	document.getElementById('iddel').value=codigo;
            document.getElementById('ocudel').value="1";
            document.form2.submit();
        }
    }
	function eliminar_arch(cod1,narch,nombredel)
	{
		if (confirm("Esta Seguro de Eliminar la plantilla de la Clase de Contrato "+nombredel.toUpperCase()))
		{
			document.getElementById('idclase').value=cod1;
			document.getElementById('archdel').value=narch;
			document.getElementById('nomdel').value=nombredel;
			document.getElementById('ocudelplan').value="1";
			document.form2.submit();
		}
	}
    </script>
    <script type="text/javascript" src="css/programas.js"></script>
    <?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
	<tr><script>barra_imagenes("plan");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("plan");?></tr>
	<tr>
		<td colspan="3" class="cinta">
			<a href="meci-gestiondoc.php" class="mgbt" ><img src="imagenes/add.png"  alt="Nuevo" border="0" /></a>
			<a href="#" class="mgbt" onClick="guardar()"><img src="imagenes/guarda.png"  alt="Guardar" /></a>
			<a href="#" class="mgbt" onClick="document.form2.submit()"><img src="imagenes/busca.png"  alt="Buscar" border="0" /></a>
			<a href="#" class="mgbt" onClick="mypop=window.open('meci-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" alt="nueva ventana"></a>
		</td>
	</tr>
</table>	
 <form name="form2" method="post" action="plan-adopcion.php" enctype="multipart/form-data">
<table  class="inicio" align="center" >
		<tr>
			<td class="titulos" colspan="4">::Adopci&oacute;n SPID a Meci </td>
            <td width="11%" class="cerrar" ><a href="plan-principal.php">Cerrar</a></td>
		</tr>
		<tr>
		  <?php
            $oculto=$_POST['oculto'];
            if($_POST[oculto])
            {
				$linkbd=conectar_bd();
				$sqlr="SELECT descripcion_valor,descripcion_dominio FROM dominios WHERE nombre_dominio='ADOPCION_SPID_MECI' ";
				$res=mysql_query($sqlr,$linkbd);
				$row = mysql_fetch_row($res);
				$bdescargar='<a href="informacion/formatos_unicos/'.$row[1].'" target="_blank" ><img src="imagenes/descargar.png" alt=\'(Descargar)\' title="(Descargar)" ></a>';
				
				if ($row[0]!="")
				{
					$beliminar='<a href="#" onClick="eliminar_arch('.$row[9].',\''.$row[15].'\',\''.$row[10].'\');"><img src="imagenes/cross.png"></a>';
					$bcargar="<div class='upload' style='display:none'> <input type='file' name='upload[]'/> </div><img src='imagenes/del3.png' >";
				} 
				else
				{
					//$bdescargar='<img src="imagenes/vacio2.png"  alt=\'(Sin Plantilla)\' title="(Sin Plantilla)" >';
					$beliminar='<img src="imagenes/del4.png" >';
					$bcargar="<div class='upload'> <input type='file' name='upload[]' onFocus='document.form2.contador.value=".$contad."; document.form2.idclase.value=".$row[9].";document.form2.nomdel.value=\"".$row[10]."\";' onChange='document.form2.submit();' /><img src='imagenes/attach.png'  alt='(Cargar)' title='(Cargar)'  /> </div>";
				}
				
            	echo "
					<td  class=\"saludo1\" >:&middot; Plantilla Adopci&oacute;n Meci:</td>
					<td align=\"middle\">".$bdescargar."</td>
					<td align=\"middle\">".$bcargar."</td>
					<td align=\"middle\">".$beliminar."</td>
					<td align=\"middle\">".$enrepara."</td>";
            }
          ?>
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
    <div class="subpantallac5" style="height:68%">
	<?php
		//Eliminar Clase Contrato
		if($_POST['ocudel']=="1")
		{
			$linkbd=conectar_bd();
			$sqlr ="UPDATE calgestiondoc SET estado='N' WHERE codigospid='".$_POST[iddel]."'";
			mysql_query($sqlr,$linkbd);
			?> <script> alert("Se Anulo El Proceso con exito");document.form2.ocudel.value="2";</script><?php
			$_POST['ocudel']="2";
		}
		//Eliminar Archivos
		if($_POST['ocudelplan']=="1")
		{
			$linkbd=conectar_bd();
			$sqlr="UPDATE callistadoc SET nomarchivo='' WHERE id='".$_POST[idclase]."'";
			mysql_query($sqlr,$linkbd);
			unlink("informacion/calidad_documental/documentos/".$_POST[archdel]);
			?><script>document.form2.ocudelplan.value="2";</script><?php
		}
		//Cargar Archivo
		if (is_uploaded_file($_FILES['upload']['tmp_name'][$_POST[contador]])) 
		{	
			$linkbd=conectar_bd();
			$trozos = explode(".",$_FILES['upload']['name'][$_POST[contador]]);  
			$extension = end($trozos);  
			$nomar=$_POST[nomdel].".".$extension;
			copy($_FILES['upload']['tmp_name'][$_POST[contador]], "informacion/calidad_documental/documentos/".$nomar);
			$linkbd=conectar_bd();
			$sqlr="UPDATE callistadoc SET nomarchivo='".$nomar."' WHERE id='".$_POST[idclase]."'";
			mysql_query($sqlr,$linkbd);
		}
		$oculto=$_POST['oculto'];
		if($_POST[oculto])
		{
			$contad=0;
			$linkbd=conectar_bd();
			$crit1=" ";
			$crit2=" ";
			if ($_POST[nombre]!="")
			{
				$sqlr2="SELECT id FROM calprocesos WHERE nombre LIKE '%".$_POST[nombre]."%'";
				$res2=mysql_query($sqlr2,$linkbd);
				$row2 = mysql_fetch_row($res2);
				$proceso=$row2[0];
				$crit1=" AND (cgd.proceso='".$proceso."') ";
			}
			if ($_POST[documento]!="")
			$crit2=" AND cgd.codigospid LIKE '%$_POST[documento]%' ";
			//sacar el consecutivo 
			$sqlr="SELECT cgd.*, cld.* FROM calgestiondoc cgd, callistadoc cld WHERE cgd.idarchivo=cld.id AND cgd.estado='S' ".$crit1.$crit2." ORDER BY cgd.proceso, cgd.id";
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
						<td class='titulos2' style=\"width:3%\">Item</td>
						<td class='titulos2' style=\"width:7%\">C&oacute;digo SPID</td>
						<td class='titulos2' style=\"width:18%\">Procesos</td>
						<td class='titulos2' style=\"width:10%\">Documentos</td>
						<td class='titulos2' style=\"width:10%\">Pol&iacute;ticas</td>
						<td class='titulos2' align=\"middle\" style=\"width:5%\" colspan=\"4\">Plantilla</td>
						<td class='titulos2' style=\"width:3%\">Versi&oacute;n</td>
						<td class='titulos2' width='3%'>Editar</td>
						<td class='titulos2' width='3%'>Anular</td>
					</tr>";	
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
				$sqlr2="SELECT descripcion_valor,descripcion_dominio FROM dominios WHERE nombre_dominio='TIPOS_DE_POLITICAS' AND valor_inicial='".$row[3]."'";
				$res2=mysql_query($sqlr2,$linkbd);
				$row2 = mysql_fetch_row($res2);
				$politicas=$row2[0];
				$bdescargar='<a href="informacion/calidad_documental/documentos/'.$row[15].'" target="_blank" ><img src="imagenes/descargar.png" alt=\'(Descargar)\' title="(Descargar)" ></a>';
				if ($row[0]!="")
				{
					
					$beliminar='<a href="#" onClick="eliminar_arch('.$row[9].',\''.$row[15].'\',\''.$row[10].'\');"><img src="imagenes/cross.png"></a>';
					$bcargar="<div class='upload' style='display:none'> <input type='file' name='upload[]'/> </div><img src='imagenes/del3.png' >";
				} 
				else
				{
					$bdescargar='<img src="imagenes/vacio2.png"  alt=\'(Sin Plantilla)\' title="(Sin Plantilla)" >';
					$beliminar='<img src="imagenes/del4.png" >';
					$bcargar="<div class='upload'> <input type='file' name='upload[]' onFocus='document.form2.contador.value=".$contad."; document.form2.idclase.value=".$row[9].";document.form2.nomdel.value=\"".$row[10]."\";' onChange='document.form2.submit();' /><img src='imagenes/attach.png'  alt='(Cargar)' title='(Cargar)'  /> </div>";
				}
				if($row[16]=="N"){$enrepara='<img src="imagenes/b_tblops.png" alt="(En Mejora)" title="(En Mejora)">';}
				else{$enrepara='<img src="imagenes/confirm.png" alt="(Activo)" title="(Activo)">';}
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
						<td align=\"middle\">".$bcargar."</td>
						<td align=\"middle\">".$beliminar."</td>
						<td align=\"middle\">".$enrepara."</td>
						<td align=\"middle\">".$row[11]."</td>
						<td align=\"middle\"><a href='meci-gestiondocedita.php?idproceso=".$row[4]."'><img src='imagenes/b_edit.png'></a></td>
						<td align=\"middle\"><a href='#' onClick='eliminar_inf(\"".$row[4]."\",\"".$nombredel."\");'><img src='imagenes/anular.png'></a></td>
					</tr>";
				 $con+=1;
				 $aux=$iter;
				 $iter=$iter2;
				 $iter2=$aux;
			 }
 echo"</table>";
}
?></div></form>
</td></tr>     
</table>
</body>
</html>