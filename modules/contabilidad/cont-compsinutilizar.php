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
		<script>
			function generar1()
			{
					document.form2.oculto.value=2;
					document.form2.action="cont-compsinutilizar.php";
					document.form2.submit();
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

		<form name="form2" method="post" action="cont-compsinutilizar.php">
  			<table  align="center" class="inicio" >
      			<tr>
        			<td class="titulos" colspan="8" >.: Comprobante Sin Utilizar</td>
        			<td  class="cerrar" style="width:7%;"><a href="cont-principal.php">&nbsp;Cerrar</a></td>
      			</tr>
      			<tr>
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
                 	<input type="hidden" value="0" name="oculto" >
					<td>&nbsp;<input type="button" name="generar" value="Generar" onClick="generar1()"></td>
				</tr>
 			</table>
 			<?php
 				if ($_POST[oculto]=='2') {
 			?>
 			<div class="subpantalla" style="height:68%; width:99.6%; overflow-x:hidden;">
	 			<table class='inicio' >
					<tr><td colspan='9' class='titulos'>.: Comprobante Sin Utilizar</td></tr>
					<tr>
						<td class='titulos2'>TIPO COMPROBANTE</td>
						<td class='titulos2' >COMPROBANTE</td>
					</tr>
					<?php
						
						$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
						if ($_POST[tipocomprobante]=='') {
							$sqlr4="SELECT * FROM tipo_comprobante WHERE estado='S' ORDER BY nombre";
							$resp4 = mysql_query($sqlr4,$linkbd);
							while ($row4 =mysql_fetch_row($resp4)) 
							{
								$sqlr="SELECT MAX(numerotipo) FROM comprobante_cab 
									WHERE tipo_comp='$row4[3]'";
								//echo $sqlr.'<br>';
								$res=mysql_query($sqlr,$linkbd);
								$row=mysql_fetch_row($res);
								//echo $row[0].'<br>';
								$co="zebra1";
								$co2="zebra2";
								for ($i=1; $i <= $row[0]; $i++) { 
									$sqlr2="SELECT tipo_comp, numerotipo FROM comprobante_cab 
									WHERE tipo_comp='$row4[3]'
									AND numerotipo='$i' ";
									//echo $sqlr.'<br>';
									$res2=mysql_query($sqlr2,$linkbd);
	
									if (mysql_num_rows($res2)=='0') {
										$sqlr3="SELECT nombre FROM tipo_comprobante WHERE estado='S' AND codigo='$row4[3]'";
										$sqlr3;
										$resp3 = mysql_query($sqlr3,$linkbd);
										$row3 =mysql_fetch_row($resp3);
	
										echo "<tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
											onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase'>
											<td>$row3[0]</td>
											<td>$i</td>
										</tr>";
										$aux=$co;
										$co=$co2;
										$co2=$aux;
									}
								}
							}
						}else{
							$sqlr="SELECT MAX(numerotipo) FROM comprobante_cab 
								WHERE comprobante_cab.tipo_comp='$_POST[tipocomprobante]'";
							//echo $sqlr.'<br>';
							$res=mysql_query($sqlr,$linkbd);
							$row=mysql_fetch_row($res);
							//echo $row[0].'<br>';
							$co="zebra1";
							$co2="zebra2";
							for ($i=1; $i <= $row[0]; $i++) { 
								$sqlr2="SELECT tipo_comp, numerotipo FROM comprobante_cab 
								WHERE comprobante_cab.tipo_comp='$_POST[tipocomprobante]'
								AND numerotipo='$i' ";
							//	echo $sqlr2.'<br>';
								$res2=mysql_query($sqlr2,$linkbd);

								if (mysql_num_rows($res2)=='0') {
									$sqlr3="SELECT nombre FROM tipo_comprobante WHERE estado='S' AND codigo='$_POST[tipocomprobante]'";
									$resp3 = mysql_query($sqlr3,$linkbd);
									$row3 =mysql_fetch_row($resp3);

									echo "<tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
										onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase'>
										<td>$row3[0]</td>
										<td>$i</td>
									</tr>";
									$aux=$co;
									$co=$co2;
									$co2=$aux;
								}
							}
						}
					?>

				</table>
			</div>

 			<?php
 			}
 			?>
		</form>
	</body>
</html>