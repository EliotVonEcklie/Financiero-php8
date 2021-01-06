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
		<title>:: SPID - Tesoreria</title>
         <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<script>
			function excell()
			{
				if (document.getElementById('vigencias').value!='')
				{
					document.form2.action="teso-exogena1481excel.php";
					document.form2.target="_BLANK";
					document.form2.submit(); 
					document.form2.action="";
					document.form2.target="";
				}
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("cont");?></tr>
			<tr>
  				<td colspan="3" class="cinta">
					<a class="mgbt1"><img src="imagenes/add2.png"/></a>
					<a class="mgbt1"><img src="imagenes/guardad.png"/></a>
					<a onClick="location.href='teso-exogena1481.php'" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a class="mgbt" onClick="<?php echo paginasnuevas("cont");?>"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
					<a class="mgbt" onClick="excell();"><img src="imagenes/excel.png"  title="Exogena 1481"></a>
					<a  onClick="location.href='teso-formatoexogena.php'"  class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
				</td>
       		</tr>	
		</table>
		<tr><td colspan="3" class="tablaprin"> 
<div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
 		<form name="form2" method="post" action="teso-exogena1481.php">
			<?php
                $vigusu=vigencia_usuarios($_SESSION[cedulausu]);
                $vigencia=$vigusu;
                $vact=$vigusu; 
            ?>
			<table  class="inicio" align="center" >
      			<tr>
        			<td class="titulos" colspan="3">:. Formato Exogena Industria Y Comercio 1481</td>
        			<td class="cerrar" style="width:7%"><a onClick="location.href='teso-principal.php'">Cerrar</a></td>
      			</tr>
 				<tr>
                    <td class="saludo1" style="width:3cm;">Vigencia Exogena:</td>
                    <td style="width:10%;">    
                    	<select name="vigencias" id="vigencias" onChange=""  style="width:100%;">
      						<option value="">Sel..</option>
	  						<?php	  
     							for($x=$vact;$x>=$vact-4;$x--)
	  							{
		 							if($x==$_POST[vigencias]){echo "<option value='$x' SELECTED>$x</option>";}
									else {echo "<option value='$x'>$x</option>";}
								}
	  						?>
      					</select>     
                	</td>
					<td>        
         				<input type="button" name="generar" value="Generar" onClick="document.form2.submit()"> 
                    	<input type="hidden" name="oculto" id="oculto" value="1"/>
                    </td>
             	</tr>                    
			</table>  
    		<div class="subpantallap" style="height:65%; width:99.7%;">
				<?php	 
                    if($_POST[oculto])
                    {
						$vigenciaAnt = $_POST[vigencias]-1;
						$sqlr="SELECT TB1.tercero,TB2.codigociiu,TB2.ingreso,TB3.industria FROM tesoindustria TB1, tesoindustria_ciiu TB2, tesoindustria_det TB3 WHERE TB1.estado='P' AND TB1.ageliquidado='$vigenciaAnt' AND year(TB1.fecha)='$_POST[vigencias]' AND TB1.id_industria=TB2.id_industria AND TB1.id_industria=TB3.id_industria GROUP BY TB1.tercero";
						$res=mysql_query($sqlr,$linkbd);
						$talbus=mysql_num_rows($res);
						echo"
						<table class='inicio'>
            				<tr><td class='titulos' colspan='23'>:: Lista de Tareas Asignadas</td></tr>
							<tr><td colspan='23'>Tareas Encontrados: $_POST[numtop]</td></tr>
							<tr>
								<td class='titulos2'>Tipo de Documento</td>
								<td class='titulos2'>N&uacute;mero de Identificaci&oacute;n</td>
								<td class='titulos2'>Primer Apellido</td>
								<td class='titulos2'>Segundo Apellido </td>
								<td class='titulos2'>Primer Nombre</td>
								<td class='titulos2'>Otros nombres</td>
								<td class='titulos2'>Raz&oacute;n Social</td>
								<td class='titulos2'>Direcci&oacute;n</td>
								<td class='titulos2'>Departamento</td>
								<td class='titulos2'>Municipio</td>
								<td class='titulos2'>Actividad Econ&oacute;mica Principal</td>
								<td class='titulos2'>N&uacute;mero Establecimientos</td>
								<td class='titulos2'>Ingresos Brutos Jurisdicci&oacute;n</td>
								<td class='titulos2'>Ingresos Brutos Otras jurisdicciones</td>
								<td class='titulos2'>Devoluciones Deducciones Exenciones Jurisdicci&oacute;n</td>
								<td class='titulos2'>Ingresos Netos Jurisdicci&oacute;n</td>
								<td class='titulos2'>Impuesto Industria y Comercio a cargo</td>
								<td class='titulos2'>Impuesto Industria y Comercio pagado</td>
							</tr>";
						$iter='saludo1a';
						$iter2='saludo2';
						while ($row = mysql_fetch_row($res)) 
						{
							$sqlrt="SELECT tipodoc,apellido1,apellido2,nombre1,nombre2,razonsocial,direccion,depto,mnpio FROM terceros WHERE cedulanit='$row[0]'";
							$rest=mysql_query($sqlrt,$linkbd);
							$rowt = mysql_fetch_row($rest);
							$sqlrf="SELECT depto,mnpio FROM configbasica ";
							$resf=mysql_query($sqlrf,$linkbd);
							$rowf = mysql_fetch_row($resf);
							
							echo"
							<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
			onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase;'>
								<td>$rowt[0]</td>
								<td>$row[0]</td>
								<td>$rowt[1]</td>
								<td>$rowt[2]</td>
								<td>$rowt[3]</td>
								<td>$rowt[4]</td>
								<td>$rowt[5]</td>
								<td>$rowt[6]</td>
								<td>$rowf[0]</td>
								<td>$rowf[1]</td>
								<td>$row[1]</td>
								<td>1</td>
								<td>$row[2]</td>
								<td>0</td>
								<td>0</td>
								<td>$row[2]</td>
								<td>$row[3]</td>
								<td>$row[3]</td>
							</tr>
							";
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux;
						}
                    }
					
                ?>
			</div>
		</form>
	</body>
</html>