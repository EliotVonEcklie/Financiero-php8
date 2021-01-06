<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	require "conversor.php";
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
		<title>:: Spid - Presupuesto</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script src="css/calendario.js"></script>
		<script src="css/programas.js"></script>
		<script>
			function eliminar(idr)
			{
				if (confirm("Esta Seguro de Eliminar el CDP "+idr))
				{
				document.form2.oculto.value=2;
				document.form2.var1.value=idr;
				document.form2.var2.value=idr;
				document.form2.submit();
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
						case "2":
							document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
						case "5":
							var idcdp=document.form2.var2.value;
							document.getElementById('ventanam').src="ventana-comentarios.php?infor="+mensa+"&tabl=pptoanulaciones&tipo=CDP&idr="+idcdp;break;
					}
					
				}
		  }
</script>
		<?php titlepag();?>
    </head>
    <body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("presu");?></tr>
        	<tr>
          		<td colspan="3" class="cinta">
				<a href="#" class="mgbt"><img src="imagenes/add2.png" title="Nuevo"/></a>
				<a class="mgbt"><img src="imagenes/guardad.png" /></a>
				<a href="presu-buscacdp.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a>
				<a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
			</tr>
		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
 		<form name="form2" method="post" action="presu-eliminacdp.php">
        	<input name="var2" id="var2" type="hidden" value=<?php echo $_POST[var2];?>>
       	<?php
			$oculto=$_POST['oculto'];
			$vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
			if($_POST[oculto]==2)
			{	
				$sqlr="select * from pptorp where idcdp='$_POST[var1]' and estado='S' and vigencia=$vigusu";	
				$resp = mysql_query($sqlr,$linkbd);
				$cont=0;
				while($r=mysql_fetch_row($resp)){$cont=$cont +1 ;}	
				if ($cont >0){echo "<script> alert('Existe Registros presupuestales anexos a este CDP ');</script>";}
				else	
				{	
					$sqlr="select * from pptocdp_detalle where pptocdp_detalle.consvigencia='$_POST[var1]' and vigencia=$vigusu";
					$resp = mysql_query($sqlr,$linkbd);
					$cont=0;
					while($row =mysql_fetch_row($resp))
					{
						$sqlr="update pptocuentaspptoinicial set saldos= saldos + $row[5] where cuenta='$row[3]' and vigencia=$vigusu";
						if (!mysql_query($sqlr,$linkbd))
						{
	 						echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1>				</font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
				 			echo "Ocurrió el siguiente problema:<br>";
  	 						echo "<pre>";
    						echo "</pre></center></td></tr></table>";
						}
						else
						{	
							$sqlr="update pptocdp_detalle set pptocdp_detalle.estado='N' where pptocdp_detalle.consvigencia='$_POST[var1]' and vigencia=$vigusu";
							mysql_query($sqlr,$linkbd);
							$sqlr="update pptocdp set pptocdp.estado='N' where pptocdp.consvigencia='$_POST[var1]' and vigencia=$vigusu";
							if (!mysql_query($sqlr,$linkbd))
							{
	 							echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
	 							echo "Ocurrió el siguiente problema:<br>";
 	 							echo "<pre>";
     							echo "</pre></center></td></tr></table>";
							}
							else
							{
  		 						$sqlr="update pptocdp set pptocdp.estado='N' where pptocdp.consvigencia='$_POST[var1]' and vigencia=$vigusu";
								if (!mysql_query($sqlr,$linkbd))
								{
	 								echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
	 								echo "Ocurrió el siguiente problema:<br>";
 									echo "<pre>";
     								echo "</pre></center></td></tr></table>";
								}
								else
		 						{
									$sqlr="update pptocomprobante_cab set pptocomprobante_cab.estado='0' where pptocomprobante_cab.numerotipo=$_POST[var1] and pptocomprobante_cab.tipo_comp=6 and pptocomprobante_cab.vigencia=$vigusu";
									mysql_query($sqlr,$linkbd);			
									$sqlr="update pptocomprobante_det set pptocomprobante_det.estado='0' where pptocomprobante_det.numerotipo=$_POST[var1] and pptocomprobante_det.tipo_comp=6 and pptocomprobante_det.vigencia=$vigusu";
		mysql_query($sqlr,$linkbd);				
		  							echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha eliminado el CDP con Exito</center></td></tr>				</table>";
									
				        		}	
							}
							echo"<script>despliegamodalm('visible','5','Escriba la justificacion de la anulacion');</script>";
						}	
					}
				}
				
}
?>
<table width="60%" align="center"  class="inicio" >
      <tr >
        <td class="titulos" colspan="4">:: Anular .: Certificado Disponibilidad Presupuestal<input type="hidden" value="1" name="oculto2">
        </td>
        <td width="9%" class="cerrar" ><a href="presu-principal.php">Cerrar</a></td>
             <input name="oculto" type="hidden" value="1"><input name="var1" id="var1" type="hidden" value=<?php echo $_POST[var1];?>>
    </tr>
    <tr></tr>
    <tr></tr>
    <tr>
    	<td class="saludo1" style="width:5%">Número:</td>
        <td >
            <input name="numero" type="search" id="numero" value="<?php echo $_POST[numero] ?>" style='width:10%;'/>
            
        </td>
    </tr>
    
</table>
<div class="subpantalla" style="height:66.5%; width:99.6%; overflow-x:hidden;">
 <?php
if ($_POST[numero]!="")
$crit2=" and pptocdp.consvigencia like '%$_POST[numero]%' ";
$linkbd=conectar_bd();
 	$sqlr="select *from pptocdp where pptocdp.estado='S' and vigencia=$vigusu".$crit2." order by pptocdp.consvigencia desc";
// echo "<div><div>sqlr:".$sqlr."</div></div>";
$resp = mysql_query($sqlr,$linkbd);
$ntr = mysql_num_rows($resp);
$con=1;
echo "<table class='inicio' align='center' width='80%'><tr><td colspan='8' class='titulos'>.: Resultados Busqueda:</td></tr><tr><td colspan='5'>Certificado Disponibilidad Presupuestal Encontrados: $ntr</td></tr><tr><td width='5%' class='titulos2'>Vigencia</td><td class='titulos2'>Numero</td><td class='titulos2'>Valor</td><td class='titulos2'>Solicita</td><td class='titulos2'>Objeto</td><td class='titulos2' width='10%'>Fecha</td><td class='titulos2' width='5%'>Anular</td></tr>";	
//echo "nr:".$nr;
$iter='zebra1';
$iter2='zebra2';
 while ($row =mysql_fetch_row($resp)) 
 {
	 echo "<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\">
	 	<td >$row[1]</td>
		<td >$row[2]</td>
		<td >$row[4]</td>
		<td >".strtoupper($row[6])."</td>
		<td >".strtoupper($row[7])."</td>
		<td >$row[3]</td>
		<td ><a href='#' onClick=eliminar(id=$row[2])><center><img src='imagenes/anular.png'></center></a></td></tr>";
	 $con+=1;
	 $aux=$iter;
	 $iter=$iter2;
	 $iter2=$aux;
 }
 echo"</table>";
 ?>
 </div>
</form>
</body>
</html>