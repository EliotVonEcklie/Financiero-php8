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
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>::SPID-Planeaci&oacute;n Estrategica</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
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
            	<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='plan-proyectoscrear.php'" class="mgbt"/><img src="imagenes/guardad.png" class="mgbt"/><img src="imagenes/busca.png" title="Buscar" onClick="location.href='plan-proyectosbuscar.php'" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" onClick="mypop=window.open('plan-principal.php','','');mypop.focus();" class="mgbt"/></td>
			</tr>
      	</table>
		<form name="form2" method="post" action="">
			<table  class="inicio" align="center" >
     			<tr>
        			<td class="titulos" colspan="9">:: Crear Proyectos</td>
       		 		<td class="cerrar" style="width:7%" onClick="location.href='plan-principal.php'">Cerrar</td>
      			</tr>
      			<tr>
                <td class="saludo1" style="width:4.5cm;">:. ID:</td>
                    <td><input type="text" id="idproy" name="idproy" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[idproy];?>" /></td>
					<td class="saludo1" style="width:3cm;">:. Cod. Proyecto:</td>
                    <td><input type="text" id="codigoproy" name="codigoproy" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[codigoproy];?>" /></td>
        			<td class="saludo1" style="width:3cm;">Nombre:</td>
					<td colspan="3"><input type="text" name="nproyecto" value="<?php echo $_POST[nproyecto];?>" style="width:100%;"/></td>
       			</tr> 
                <?php
					$sqln="SELECT nombre, orden FROM plannivelespd WHERE estado='S' ORDER BY orden";
					$resn=mysql_query($sqln,$linkbd);
					$n=0; $j=0;
					while($wres=mysql_fetch_array($resn))
					{
						if (strcmp($wres[0],'INDICADORES')!=0)
						{
							if($wres[1]==1){$buspad='';}
							elseif($_POST[arrpad][($j-1)]!=""){$buspad=$_POST[arrpad][($j-1)];}
							else {$buspad='';}
							if($n==0){echo"<tr>";}
							echo"
								<td class='saludo1'>".strtoupper($wres[0])."</td>
								<td colspan='3' style='width:35%;'>
									<select name='niveles[$j]'  onChange='document.form2.submit();' onKeyUp='return tabular(event,this)' style='width:100%;'>
										<option value=''>Seleccione....</option>";
							$sqlr="SELECT * FROM presuplandesarrollo WHERE padre='$buspad'  ORDER BY codigo";
							$res=mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($res)) 
							{
								if($row[0]==$_POST[niveles][$j])
								{
									$_POST[arrpad][$j]=$row[0];
									$_POST[nmeta]=$row[0];
									$_POST[meta]=$row[1];
									echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";
								}
								else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}	 
							}	
							echo"</select>
													<input type='hidden' name='arrpad[$j]' value='".$_POST[arrpad][$j]."' >
													<input type='hidden' name='meta' value='".$_POST[meta]."' >
													<input type='hidden' name='nmeta' value='".$_POST[nmeta]."' >
												</td>";
												$n++;
												if($n>1){$n=0;echo"</tr>";}
												$j++;
											}
										}
				?>                      
    		</table>    
    		<input name="oculto" id="oculto" type="hidden" value="1"> 
 		</form>
	</body>
</html>