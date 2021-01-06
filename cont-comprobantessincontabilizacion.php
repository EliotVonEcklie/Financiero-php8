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
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
		<link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
		
		<?php titlepag();?>
		<script>
			function reflejar(linkref,consecutivo)
			{
				if(linkref!='#')
				{
					window.open(""+linkref+"?consecutivo="+consecutivo);
				}
				
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
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
	  				<a href="#" class="mgbt" onClick="<?php echo paginasnuevas("cont");?>"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
	  				<a href="cont-estadocomprobantes.php" class="mgbt"><img src="imagenes/iratras.png" title="Retornar"></a>
  				</td>
         	</tr>
		</table>
 		<form name="form2" method="post" action="cont-comprobantessincontabilizacion.php"> 
		 <?php
			if($_POST[compcero]=='S')
			{
				$chkant=' checked ';
			}
		?>
  			<table  align="center" class="inicio" >
      			<tr>
        			<td class="titulos" colspan="9" >.: Comprobantes Sin contabilizaci&oacute;n</td>
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
				 						echo "<option value='$row[3]' SELECTED> $row[1]</option>";
									}
									else {echo "<option value='$row[3]'>$row[3]) $row[1]</option>";}
			     				}			
		  					?>
		  				</select>
                 	</td>
					
					<td>&nbsp;<input type="button" name="generar" value="Generar" onClick="document.form2.submit()"></td>
					<td class="saludo1" style="width:10%">Comprobantes en cero</td>
					<td>
						<input type="checkbox" name="compcero" id="compcero" value='S' <?php echo $chkant; ?>>
					</td>
				</tr>
 			</table>

            <input type="hidden" name="oculto" id="oculto" value="1"/>
			<div class="subpantalla" style="height:68%; width:99.6%; overflow-x:hidden;">
				<?php
  					$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
 				 	if($_POST['oculto'])
  					{
  						$crit1="";
						
						if($_POST[tipocomprobante]!=""){
							$crit1="AND cab.tipo_comp='$_POST[tipocomprobante]'";
						}  
						
						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
						$fechaf1=$fecha[3]."-".$fecha[2]."-".$fecha[1];
						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
						$fechaf2=$fecha[3]."-".$fecha[2]."-".$fecha[1];
						//**** para sacar la consulta del balance se necesitan estos datos ********
  						//**** nivel, mes inicial, mes final, cuenta inicial, cuenta final, cc inicial, cc final  
						$oculto=$_POST['oculto'];
						$sumad=0;
						$sumac=0;	
						/*
						$sqlr="
						SELECT 
						comprobante_cab.tipo_comp, 
						comprobante_cab.numerotipo, 
						comprobante_cab.fecha, 
						comprobante_cab.concepto,
						comprobante_cab.total_debito,
						comprobante_cab.total_credito
						FROM 
						comprobante_cab
						WHERE 
						comprobante_cab.fecha BETWEEN '$fechaf1' AND '$fechaf2' 
						AND comprobante_cab.estado='1' 
						$crit1 
						GROUP BY 
						comprobante_cab.tipo_comp, 
						comprobante_cab.numerotipo 
						ORDER BY 
						comprobante_cab.tipo_comp, 
						comprobante_cab.numerotipo";
						*/
						if($_POST[compcero]=='S')
						{
							$sqlr="SELECT cab.tipo_comp, 
							cab.numerotipo, 
							cab.fecha, 
							cab.concepto,
							cab.total_debito,
							cab.total_credito,
							SUM(det.valcredito),
							SUM(det.valdebito)
							FROM comprobante_cab cab,comprobante_det det WHERE cab.fecha BETWEEN '$fechaf1' AND '$fechaf2' $crit1 AND cab.estado='1' AND det.numerotipo=cab.numerotipo AND det.tipo_comp=cab.tipo_comp  AND det.valdebito=0 AND det.valcredito=0 AND cab.concepto NOT LIKE 'ESTE DOCUMENTO NO REQUIERE CAUSACION CONTABLE%' ORDER BY cab.tipo_comp,cab.numerotipo";
						}
						else
						{
							$sqlr="SELECT cab.tipo_comp, 
							cab.numerotipo, 
							cab.fecha, 
							cab.concepto,
							cab.total_debito,
							cab.total_credito
							FROM comprobante_cab cab WHERE cab.fecha BETWEEN '$fechaf1' AND '$fechaf2' $crit1 AND cab.estado='1' AND ( NOT EXISTS (SELECT * FROM comprobante_det det WHERE cab.numerotipo=det.numerotipo AND cab.tipo_comp=det.tipo_comp) ) AND cab.concepto NOT LIKE 'ESTE DOCUMENTO NO REQUIERE CAUSACION CONTABLE%'  ORDER BY cab.tipo_comp,cab.numerotipo";
						}
						$fechaf=$_POST[fecha];
						$fechaf2=$_POST[fecha2];	
  						echo "
						<table class='inicio' >
							<tr><td colspan='9' class='titulos'>.: Comprobantes Sin contabilizaci&oacute;n</td></tr>";
						$nc=buscacuenta($_POST[cuenta]);
						echo "
							<tr>
								<td class='titulos2' style='width: 15%;'>TIPO COMPROBANTE</td>
								<td class='titulos2' style='width: 5%;' align='center'>Nom. Tipo</td>
								<td class='titulos2' style='width: 7%;' align='center'>FECHA</td>
								<td class='titulos2'>CONCEPTO</td>
								<td class='titulos2'>DEBITO</td>
								<td class='titulos2'>CREDITO</td>
								<td class='titulos2' style='width: 5%;'>REFLEJAR</td>
							</tr>";
						$co="zebra1";
						$co2="zebra2";
						$res=mysql_query($sqlr,$linkbd);
						while($row=mysql_fetch_row($res)){
							if($_POST[compcero]=='S')
							{
								if($row[6]=='0')
								{
									$sqlr2="SELECT numerotipo,tipo_comp FROM comprobante_det WHERE numerotipo='$row[1]' AND tipo_comp='$row[0]' AND estado='1'";
									//echo "$sqlr2 <br>";
									$r=mysql_query($sqlr2,$linkbd);
									$rr=mysql_fetch_row($r);
									//echo $rr[0];
									//if($rr[0]==''){
										// echo "hola";
										$sqlr1="SELECT * FROM tipo_comprobante WHERE codigo=$row[0]";
										$res2=mysql_query($sqlr1);
										$row2=mysql_fetch_row($res2);
										switch($row[0])
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
											default:
												$linkreflejar="#";
										}
										echo "
										<tr class='$co' ondblclick='direccionaComprobante($row2[5],$row2[3],$row[1])' style=\"cursor: hand\" onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
										onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase'>
											<td style='width: 15%;'>$row2[1]</td>
											<td style='width: 3%;' align='center'>$row[1]</td>
											<td style='width: 6%;' align='center'>$row[2]</td>
											<td >$row[3]</td>
											<td style='width: 10%;' align='right'>$".number_format(0,2)."</td>
											<td style='width: 10%;' align='right'>$".number_format(0,2)."</td>
											<td style='text-align:center;'><img src='imagenes/reflejar1.png' class='icoop' title='Ver' onClick=\"reflejar('$linkreflejar','$row[1]');\"/></td>
										</tr>";
										$aux=$co;
										$co=$co2;
										$co2=$aux;
								}
							}
							else
							{
								$sqlr2="SELECT numerotipo,tipo_comp FROM comprobante_det WHERE numerotipo='$row[1]' AND tipo_comp='$row[0]' AND estado='1'";
								//echo "$sqlr2 <br>";
								$r=mysql_query($sqlr2,$linkbd);
								$rr=mysql_fetch_row($r);
								//echo $rr[0];
								//if($rr[0]==''){
									// echo "hola";
									$sqlr1="SELECT * FROM tipo_comprobante WHERE codigo=$row[0]";
									$res2=mysql_query($sqlr1);
									$row2=mysql_fetch_row($res2);
									switch($row[0])
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
											default:
												$linkreflejar="#";
										}
									echo "
									<tr class='$co' ondblclick='direccionaComprobante($row2[5],$row2[3],$row[1])' style=\"cursor: hand\" onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
									onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase'>
										<td style='width: 15%;'>$row2[1]</td>
										<td style='width: 3%;' align='center'>$row[1]</td>
										<td style='width: 6%;' align='center'>$row[2]</td>
										<td >$row[3]</td>
										<td style='width: 10%;' align='right'>$".number_format(0,2)."</td>
										<td style='width: 10%;' align='right'>$".number_format(0,2)."</td>
										<td style='text-align:center;'><img src='imagenes/reflejar1.png' class='icoop' title='Ver' onClick=\"reflejar('$linkreflejar','$row[1]');\"/></td>
									</tr>";
									$aux=$co;
									$co=$co2;
									$co2=$aux;
							}
							//}
						}
						echo "
							<tr>
								<td class='titulos2' colspan='4' align='center'>TOTAL</td>
								<td class='titulos2' align='right'>$".number_format(0,2)."</td>
								<td class='titulos2' align='right'>$".number_format(0,2)."</td>
							</tr>";
						echo "
						</table>";
					}
				?> 
			</div>
		</form>
	</body>
</html>

