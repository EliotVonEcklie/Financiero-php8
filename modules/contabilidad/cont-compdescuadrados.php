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
		<title>:: Spid - Contabilidad</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
		
		<?php titlepag();?>
		<script>
			function reflejar(linkref,consecutivo)
			{
				window.open(""+linkref+"?consecutivo="+consecutivo);
			}
			function direccionaComprobante(idCat,tipo_compro,num_compro)
			{
				window.open("cont-buscacomprobantes.php?idCat="+idCat+"&tipo_compro="+tipo_compro+"&num_compro="+num_compro);
			}
		</script>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
    		<tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
    		<tr><?php menu_desplegable("cont");?></tr>	
			<tr class="cinta">
  				<td colspan="3" class="cinta">
	  				<a class="mgbt"><img src="imagenes/add2.png"/></a>
	  				<a class="mgbt"><img src="imagenes/guardad.png"/></a>
	  				<a href="#" onClick="document.form2.submit()" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a>
	  				<a href="#" class="mgbt" onClick="<?php echo paginasnuevas("cont");?>"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
	  				<a href="cont-estadocomprobantes.php" class="mgbt"><img src="imagenes/iratras.png" title="Retornar"></a>
  				</td>
         	</tr>
		</table>
 		<form name="form2" method="post" action="cont-compdescuadrados.php"> 
  			<table  align="center" class="inicio" >
      			<tr>
        			<td class="titulos" colspan="8" >.: Comprobantes Descuadrados</td>
        			<td  class="cerrar" style="width:7%;"><a href="cont-principal.php">&nbsp;Cerrar</a></td>
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
  		   						$sqlr="SELECT * FROM tipo_comprobante WHERE estado='S' ORDER BY nombre";
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
            <input type="hidden" name="oculto" id="oculto" value="1"/>
			<div class="subpantalla" style="height:68%; width:99.6%; overflow-x:hidden;">
				<?php
  					$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
 				 	if($_POST['oculto'])
  					{
  						$crit1="";
						if($_POST[tipocomprobante]!=""){$crit1="AND comprobante_cab.tipo_comp LIKE '$_POST[tipocomprobante]'";}  
						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
						$fechaf1=$fecha[3]."-".$fecha[2]."-".$fecha[1];
						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
						$fechaf2=$fecha[3]."-".$fecha[2]."-".$fecha[1];
						//**** para sacar la consulta del balance se necesitan estos datos ********
  						//**** nivel, mes inicial, mes final, cuenta inicial, cuenta final, cc inicial, cc final  
						$oculto=$_POST['oculto'];
						$sumad=0;
						$sumac=0;	
						$sqlr="SELECT DISTINCT comprobante_det.id_comp,comprobante_cab.tipo_comp, comprobante_cab.numerotipo, comprobante_cab.fecha, comprobante_cab.concepto, sum(comprobante_det.valdebito), sum(comprobante_det.valcredito) FROM comprobante_cab,comprobante_det WHERE comprobante_cab.fecha BETWEEN '$fechaf1' AND '$fechaf2' AND comprobante_det.tipo_comp=comprobante_cab.tipo_comp AND comprobante_det.numerotipo=comprobante_cab.numerotipo  AND comprobante_cab.estado='1' $crit1 GROUP BY comprobante_det.id_comp,comprobante_cab.tipo_comp, comprobante_cab.numerotipo ORDER BY comprobante_cab.tipo_comp, comprobante_cab.numerotipo";	
						$fechaf=$_POST[fecha];
						$fechaf2=$_POST[fecha2];	
  						echo "<table class='inicio' >
							<tr><td colspan='9' class='titulos'>COMPROBANTES DESCUADRADOS</td></tr>";
						$nc=buscacuenta($_POST[cuenta]);
						echo "<tr>
								<td class='titulos2' style='width: 10%;'>TIPO COMPROBANTE</td>
								<td class='titulos2' style='width: 3%;'>COMPROBANTE</td>
								<td class='titulos2' style='width: 7%;'>FECHA</td>
								<td class='titulos2'>CONCEPTO</td>
								<td class='titulos2' style='width: 10%;'>DEBITO</td>
								<td class='titulos2' style='width: 10%;'>CREDITO</td>
								<td class='titulos2' style='width: 5%;'>REFLEJAR</td>
							</tr>";
						$res=mysql_query($sqlr,$linkbd);
						$co="zebra1";
						$co2="zebra2";
						while($row=mysql_fetch_row($res))
						{
							if(round($row[5],2)!= round($row[6],2))
							{
								$sqlr="SELECT * FROM tipo_comprobante WHERE codigo=$row[1]";
								$res2=mysql_query($sqlr);
								$row2=mysql_fetch_row($res2);
								switch($row[1])
								{
									case '5':
										$linkreflejar="cont-recibocaja-reflejar.php";
										break;
									case '17':
										$linkreflejar="cont-pagonominaver-reflejar.php";
										break;
									case '6':
										$linkreflejar="cont-girarcheques-reflejar.php";
										break;
									case '2':
										$linkreflejar="cont-recaudos-reflejar.php";
										break;
									case '11':
										$linkreflejar="cont-egreso-reflejar.php";
										break;
									case '31':
										$linkreflejar="cont-exentos-reflejar.php";
										break;
									case '26':
										$linkreflejar="cont-sinrecaudos-reflejar.php";
										break;
									case '4':
										$linkreflejar="cont-liquidarnomina-regrabar.php";
										break;
									case '20':
										$linkreflejar="cont-sinsituacion-reflejar.php";
										break;
									case '21':
										$linkreflejar="cont-buscasinsituacionegreso.php";
										break;
									case '3':
										$linkreflejar="cont-industriaver-reflejar.php";
										break;
									case '12':
										$linkreflejar="cont-pagoterceros-reflejar.php";
										break;
									case '14':
										$linkreflejar="cont-recaudotransferencia-reflejar.php";
										break;
									case '28':
										$linkreflejar="cont-recaudotransferencialiquidar-reflejar.php";
										break;
								}
								echo "
								<tr class='$co' ondblclick='direccionaComprobante($row2[5],$row2[3],$row[2])' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase'>
									<td>$row2[1]</td>
									<td align='center'>$row[2]</td>
									<td>$row[3]</td>
									<td>$row[4]</td> 
									<td  align='right'>$".number_format($row[5],2)."</td>
									<td  align='right'>$".number_format($row[6],2)."</td>
									<td style='text-align:center;'><img src='imagenes/reflejar1.png' class='icoop' title='Ver' onClick=\"reflejar('$linkreflejar','$row[2]');\"/></td>
								</tr>";
								$sumad+=$row[5];
								$sumac+=$row[6];
								$aux=$co;
								$co=$co2;
								$co2=$aux;
							}
						}
						$sqlr="SELECT DISTINCT comprobante_det.id_comp,comprobante_cab.tipo_comp, comprobante_cab.numerotipo, comprobante_cab.fecha, comprobante_cab.concepto,comprobante_det.valdebito, comprobante_det.valcredito,comprobante_det.cuenta FROM comprobante_cab,comprobante_det WHERE comprobante_cab.fecha BETWEEN '$fechaf1' AND '$fechaf2' AND comprobante_det.tipo_comp=comprobante_cab.tipo_comp AND comprobante_det.numerotipo=comprobante_cab.numerotipo and comprobante_cab.estado='1' AND comprobante_det.CUENTA='' $crit1 GROUP BY comprobante_det.id_comp,comprobante_cab.tipo_comp, comprobante_cab.numerotipo ORDER BY comprobante_cab.tipo_comp, comprobante_cab.numerotipo";
						$res=mysql_query($sqlr,$linkbd);
						while($row=mysql_fetch_row($res))
						{
							$sqlr="SELECT * FROM tipo_comprobante WHERE codigo=$row[1]";
							$res2=mysql_query($sqlr);
							$row2=mysql_fetch_row($res2);
							echo "
							<tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase'>
								<td>$row2[1]</td>
								<td align='center'>$row[2]</td>
								<td>$row[3]</td>
								<td>$row[4] - CUENTA NO EXISTE '$row[7]' </td>
								<td align='right'>$".number_format($row[5],2)."</td>
								<td align='right'>$".number_format($row[6],2)."</td>
							</tr>"; 
							$sumad+=$row[5];
							$sumac+=$row[6];
							$aux=$co;
							$co=$co2;
							$co2=$aux;
						}
						$sqlr="SELECT comprobante_cab.tipo_comp, comprobante_cab.numerotipo, comprobante_cab.fecha, comprobante_cab.concepto,count(comprobante_det.CUENTA),comprobante_cab.estado FROM comprobante_cab left join comprobante_det  on comprobante_det.tipo_comp=comprobante_cab.tipo_comp AND comprobante_det.numerotipo=comprobante_cab.numerotipo WHERE comprobante_cab.fecha BETWEEN '$fechaf1' AND '$fechaf2' AND comprobante_cab.estado='1' $crit1 GROUP BY  comprobante_cab.tipo_comp, comprobante_cab.numerotipo ORDER BY comprobante_cab.tipo_comp, comprobante_cab.numerotipo";
						$res=mysql_query($sqlr,$linkbd);
						while($row=mysql_fetch_row($res))
						{
							if($row[4]<=0)
							{
								$tipoc=buscacomprobante($row[0]);
								if($row[5]==1){$estado="ACTIVO";}
								else {$estado="PASIVO";}
								echo "
								<tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase'>
									<td>$tipoc</td>
									<td  align='center'>$row[1]</td>
									<td>$row[2]</td>
									<td>EL COMPROBANTE NO TIENE MOVIMIENTOS - Estado: $estado</td>
									<td align='right'>$".number_format($row[6],2)."</td>
									<td align='right'>$".number_format($row[6],2)."</td>
								</tr>"; 
								$aux=$co;
								$co=$co2;
								$co2=$aux;
							}
						}
						echo "<tr>
						<td class='titulos2' align='center' colspan='4' >TOTAL</td>
						<td class='titulos2' align='right'>$".number_format($sumad,2)."</td>
						<td class='titulos2' align='right'>$".number_format($sumac,2)."</td>
						</tr>";
						/*
						echo "
							<tr>
								<td colspan='3'></td>
								<td>Totales:</td>
								<td class='saludo1'>$".number_format($sumad,2)."</td>
								<td class='saludo1'>$".number_format($sumac,2)."</td>
							</tr>
						</table>";*/
					}
				?> 
			</div>
		</form>
	</body>
</html>