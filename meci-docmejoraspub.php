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
    <script>function funbuscar(){document.form2.submit();}</script>
    <script type="text/javascript" src="css/programas.js"></script>
    <?php titlepag();?>
</head>
<body>
	<form name="form2" method="post" action="meci-docmejoraspub.php" enctype="multipart/form-data">
		<table  class="inicio" align="center" >
			<tr>
            	<td class="titulos" colspan="4">:: Buscar Mejoras Publicadas </td>
			</tr>
            	<td style="width:5%" class="saludo1">Mes:</td>   
           		<td style="width:10%">
                    <select name="mes">
                        <?php
                        $meses=array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                         for ($i=0; $i<=11; $i++)
                         {
                             if($_POST[mes]==$i){$seleccion=" SELECTED";}
                             else{$seleccion="";}
                             echo '<option value="'.$i.'" '.$seleccion.'>'.$meses[$i].'</option>';
                         }
                        ?>
                    </select> 
            	</td> 
                <td style="width:5%" class="saludo1">A&ntilde;o:</td>  
                <td>
                	<select name="ano">
						<?php
                        for($i=date('o'); $i>=1910; $i--)
						{
							if($_POST[ano]==$i){$seleccion=" SELECTED";}
                            else{$seleccion="";}	
							echo '<option value="'.$i.'" '.$seleccion.'>'.$i.'</option>';
						}
                        ?>
					</select>
                </td>                
    </table>
	<input name="oculto" type="hidden" value="1">
   	<input name="oculfecha" type="hidden" value="<?php echo $_POST[oculfecha]?>">
    <div class="subpantallac5" style="height:85%">
	<?php
		if($_POST[oculfecha]==""){?><script>var hoy=new Date();var nMes=hoy.getMonth();document.form2.mes.value=nMes;document.form2.oculfecha.value="3";</script><?php }
		
		$oculto=$_POST['oculto'];
		if($_POST[oculto])
		{
			$contad=0;
			$ames=$_POST[mes]+1;
			$linkbd=conectar_bd();
			$namearch="informacion/temp/mejoras_publicadas.csv";
			$Descriptor1 = fopen($namearch,"w+"); 
			$crit1=" AND (cld.fechaprov >= '".$_POST[ano]."-".$ames."-01' AND cld.fechaprov <= '".$_POST[ano]."-".$ames."-31' ) ";
			//sacar el consecutivo 
			$sqlr="SELECT cgd.*, cld.* FROM calgestiondoc cgd, callistadoc cld WHERE cgd.idarchivo=cld.id AND cgd.estado='S' ".$crit1." ORDER BY cgd.proceso, cgd.id";
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
						<td class='titulos2' style=\"width:4%\">fecha Aprob.</td>
					</tr>";	
			fputs($Descriptor1,"ITEM;CODIGO SPID;PROCESOS;DOCUMENTOS;POLITICAS;ARCHIVO;VERSION;FECHA\r\n");
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
						<td align=\"middle\">".$row[13]."</td>
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
?></div>
</form>
</body>
</html>