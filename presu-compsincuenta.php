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

		<form name="form2" method="post" action="presu-compsincuenta.php"> 
  			<table  align="center" class="inicio" >
      			<tr>
        			<td class="titulos" colspan="8" >.: Comprobante Sin Cuenta Presupuestal</td>
        			<td  class="cerrar" style="width:7%;"><a href="presu-principal.php">&nbsp;Cerrar</a></td>
      			</tr>
      			<tr>
       				<td class="saludo1" style="width:2cm;">Mes Inicial:</td>
        			<td style="width:15%;">
						<input name="fecha" type="text" id="fecha" title="DD/MM/YYYY" style="width:50%;" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" tabindex="2"/>&nbsp;<a href="#" onClick="displayCalendarFor('fecha');" tabindex="3" title="Calendario"><img src="imagenes/calendario04.png" align="absmiddle" style="width:20px;"></a>
					</td>
        			<td class="saludo1" style="width:2cm;">Mes Final: </td>
        			<td style="width:15%;">
						<input name="fecha2" type="text" id="fecha2" title="DD/MM/YYYY" style="width:50%;" value="<?php echo $_POST[fecha2]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" tabindex="2"/>&nbsp;<a href="#" onClick="displayCalendarFor('fecha2');" tabindex="3" title="Calendario"><img src="imagenes/calendario04.png" align="absmiddle" style="width:20px;"></a>
					</td>
		 			<td  class="saludo1" style="width:3cm;">Tipo Comprobante:</td>
          			<td style="width:25%;">
                    	<select name="tipocomprobante" onKeyUp='return tabular(event,this)' onChange="validar()" style="width:100%;">
		 					<option value="">Seleccion Tipo Comprobante</option>	  
		   					<?php
  		   						$sqlr="SELECT * FROM pptotipo_comprobante WHERE estado='S' ORDER BY nombre";
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
					<tr><td colspan='9' class='titulos'>.: Comprobante Sin Cuenta Presupuestal</td></tr>
					<tr>
						<td class='titulos2'>TIPO COMPROBANTE</td>
						<td class='titulos2' >COMPROBANTE</td>
						<td class='titulos2' >FECHA</td>
						<td class='titulos2'>TERCERO</td>
						<td class='titulos2'>NOMBRE</td>
						<td class='titulos2'>CONCEPTO</td>
						<td class='titulos2'>DEBITO</td>
						<td class='titulos2'>CREDITO</td>
					</tr>
					<?php
						$script1='';
						if ($_POST[tipocomprobante]!='') {
							$script1="AND pptocomprobante_det.tipo_comp='$_POST[tipocomprobante]'";
						}
						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
						$fechaf1=$fecha[3]."-".$fecha[2]."-".$fecha[1];
						$anio1=$fecha[3];
						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
						$fechaf2=$fecha[3]."-".$fecha[2]."-".$fecha[1];
						$anio2=$fecha[3];

						$sqlr="SELECT * FROM pptocomprobante_det, pptocomprobante_cab 
							WHERE pptocomprobante_det.cuenta=''
							AND pptocomprobante_cab.estado='1'
							AND pptocomprobante_det.numerotipo=pptocomprobante_cab.numerotipo
							AND pptocomprobante_det.tipo_comp=pptocomprobante_cab.tipo_comp
							AND pptocomprobante_det.vigencia BETWEEN '$anio1' AND '$anio2'
							AND pptocomprobante_cab.fecha BETWEEN '$fechaf1' AND '$fechaf2' 
							$script1
							GROUP BY pptocomprobante_det.numerotipo, pptocomprobante_det.tipo_comp
							ORDER BY pptocomprobante_det.tipo_comp, pptocomprobante_det.numerotipo";
						
						//echo $sqlr;
						$res=mysql_query($sqlr,$linkbd);
						$co="zebra1";
						$co2="zebra2";
						while($row=mysql_fetch_row($res)){
							$sqlr2="SELECT nombre FROM pptotipo_comprobante WHERE estado='S' AND codigo='$row[8]'";
							//echo $sqlr2.'<br>';
	 						$resp2 = mysql_query($sqlr2,$linkbd);
							$row2 =mysql_fetch_row($resp2);

							echo "<tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
									onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase'>
									<td>$row2[0]</td>
									<td>$row[9]</td>
									<td>$row[16]</td>
									<td>$row[2]</td>
									<td>".buscatercero($row[2])."</td>
									<td>$row[17]</td>
									<td>".number_format($row[4],2)."</td>
									<td>".number_format($row[5],2)."</td>
								</tr>";
							$aux=$co;
							$co=$co2;
							$co2=$aux;
						}

					?>

				</table>
			</div>
		</form>

	</body>
</html>