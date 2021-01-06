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
		<title>:: Spid - Presupuesto</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
		<link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
	
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
    		<tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
    		<tr><?php menu_desplegable("presu");?></tr>	
			<tr class="cinta">
  				<td colspan="3" class="cinta">
	  				<a class="mgbt"><img src="imagenes/add2.png"/></a>
	  				<a class="mgbt"><img src="imagenes/guardad.png"/></a>
	  				<a href="#" onClick="document.form2.submit()" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a>
	  				<a href="#" class="mgbt" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
	  				<a href="presu-estadocomprobantes.php" class="mgbt"><img src="imagenes/iratras.png" title="Retornar"></a>
  				</td>
         	</tr>
		</table>

		<form name="form2" method="post" action="presu-compdescuadrados.php"> 
  			<table  align="center" class="inicio" >
      			<tr>
        			<td class="titulos" colspan="8" >.: Comprobantes Descuadrados</td>
        			<td  class="cerrar" style="width:7%;"><a href="presu-principal.php">&nbsp;Cerrar</a></td>
      			</tr>
      			<tr>
       				<td class="saludo1" style="width:2cm;">N° del Comprobante:</td>
        			<td style="width:15%;">
						<input name="comprobante" type="text" id="comprobante" style="width:50%;" value="<?php echo $_POST[comprobante]; ?>" />
					</td>
        			<td  class="saludo1" style="width:3cm;">Tipo Comprobante:</td>
          			<td style="width:25%;">
                    	<select name="tipocomprobante" onKeyUp='return tabular(event,this)' onChange="validar()" style="width:100%;">
		 					<option value="">Seleccion Tipo Comprobante</option>	  
		   					<?php
  		   						$sqlr="SELECT * FROM pptotipo_comprobante WHERE estado='S' AND codigo>'5' ORDER BY codigo";
		 						$resp = mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($resp)) 
								{
									if($row[3]==$_POST[tipocomprobante])
			 						{
										$_POST[ntipocomp]=$row[1];
				 						echo "<option value='$row[3]' SELECTED>$row[1]</option>";
									}
									else {echo "<option value='$row[3]'>$row[1]</option>";}
			     				}			
		  					?>
		  				</select>
                 	</td>
					<td>&nbsp;<input type="button" name="generar" value="Generar" onClick="document.form2.submit()"></td>
				</tr>
 			</table>
			
			<div class="subpantalla" style="height:68%; width:99.6%; overflow-x:hidden;">
	 			<table class='inicio' >
					<tr><td colspan='8' class='titulos'>.: Comprobante Descuadrados</td></tr>
					<tr>
						<td class='titulos2'>TIPO COMPROBANTE</td>
						<td class='titulos2'>COMPROBANTE</td>
						<td class='titulos2'>CUENTA</td>
						<td class='titulos2' style='width: 7%;'>FECHA</td>
						<td class='titulos2'>CONCEPTO</td>
						<td class='titulos2'>TOTAL CREDITO</td>
						<td class='titulos2'>TOTAL DEBITO</td>
						<td class='titulos2'>DIFERENCIA</td>
						<td class='titulos2'>TIPO MOVIMIENTO</td> 
					</tr>
					<?php
						$script1="AND tipo_comp>'5' ";
						if ($_POST[tipocomprobante]!='') {
							$script1+="AND tipo_comp='$_POST[tipocomprobante]'";
						}
						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
						$fechaf1=$fecha[3]."-".$fecha[2]."-".$fecha[1];
						$anio1=$fecha[3];
						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
						$fechaf2=$fecha[3]."-".$fecha[2]."-".$fecha[1];
						$anio2=$fecha[3];
						$sqlr="SELECT * FROM pptocomprobante_cab
							WHERE estado='1'
							AND fecha BETWEEN '$fechaf1' AND '$fechaf2'
							$script1
							ORDER BY tipo_comp";
						//echo $sqlr;

						$res=mysql_query($sqlr,$linkbd);
						$co="zebra1";
						$co2="zebra2";

						$sumacredito=0;
						$sumadebito=0;
						while($row=mysql_fetch_row($res)){
							
							$sqlr3="SELECT SUM(valdebito), SUM(valcredito), cuenta FROM pptocomprobante_det
							WHERE estado='1'
							AND numerotipo='$row[0]'
							AND tipo_comp='$row[1]'
							AND vigencia BETWEEN '$anio1' AND '$anio2'
							GROUP BY tipo_comp, numerotipo
							ORDER BY tipo_comp, numerotipo";
							//echo $sqlr3.'<br>';
							$res3=mysql_query($sqlr3,$linkbd);
							$row3=mysql_fetch_row($res3);
							if ($row3[1]>$row3[0]) {
								$sqlr2="SELECT nombre FROM pptotipo_comprobante WHERE estado='S' AND codigo='$row[1]'";
								//echo $sqlr2.'<br>';
		 						$resp2 = mysql_query($sqlr2,$linkbd);
								$row2 =mysql_fetch_row($resp2);

								echo "<tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
										onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase'>
										<td>$row2[0]</td>
										<td>$row[0]</td>
										<td>$row3[2]</td>
										<td align='center'>$row[2]</td>
										<td>$row[3]</td>
										<td align='right'>$".number_format($row3[1],2)."</td>
										<td align='right'>$".number_format($row3[0],2)."</td>
										<td align='right'>$".number_format($row3[1]-$row3[0],2)."</td>
									</tr>";
								$aux=$co;
								$co=$co2;
								$co2=$aux;
								$sumacredito+=$row3[1];
								$sumadebito+=$row3[0];
							}
						}

						 echo "<tr>
						 <td class='titulos2' align='center' colspan='5'>TOTALES:</td>
						 <td class='titulos2' align='right'>$".number_format($sumacredito,2)."</td>
						 <td class='titulos2' align='right'>$".number_format($sumadebito,2)."</td>
						 <td class='titulos2' align='right'>$".number_format($sumacredito-$sumadebito,2)."</td>
						 </tr>
						 </table>";

					?>
			</div>
		</form>

	</body>
</html>