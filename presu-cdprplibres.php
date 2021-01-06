<?php //V 1001 20/12/16 Modificado implementacion de Reversion?> 
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
		<script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
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
    		<tr>
  				<td colspan="3" class="cinta">
	  				<a class="mgbt"><img src="imagenes/add2.png" title="Nuevo" /></a>
	  				<a class="mgbt"><img src="imagenes/guardad.png"/></a>
	  				<a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
	  				<a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a>
	  				<a href="presu-estadocomprobantes.php" class="mgbt"><img src="imagenes/iratras.png" title="Retornar"></a>
  				</td>
			</tr>
		</table> 

		<form name="form2" method="post" action="presu-cdprplibres.php"> 
  			<table  align="center" class="inicio" >
      			<tr>
        			<td class="titulos" colspan="8" >.: Comprobantes Libres</td>
        			<td  class="cerrar" style="width:7%;"><a href="presu-principal.php">&nbsp;Cerrar</a></td>
      			</tr>
      			<tr>
		 			<td  class="saludo1" style="width:3cm;">Tipo Comprobante:</td>
          			<td style="width:25%;">
                    	<select name="tipocomprobante" onKeyUp='return tabular(event,this)' onChange="validar()" style="width:100%;">
		 					<option value="" <?php if($_POST[tipocomprobante]==''){echo "selected";} ?> > Seleccion Tipo Comprobante</option>	  
		   					<option value="6" <?php if($_POST[tipocomprobante]=='6'){echo "selected";} ?> > Disponibilidad</option>
							<option value="7" <?php if($_POST[tipocomprobante]=='7'){echo "selected";} ?> > Registro</option>
		  				</select>
                 	</td>
					<td>&nbsp;<input type="button" name="generar" value="Generar" onClick="document.form2.submit()"></td>
				</tr>
 			</table>

 			<input type="hidden" name="oculto" id="oculto" value="1"/>
			<div class="subpantalla" style="height:68%; width:99.6%; overflow-x:hidden;">
				<?php 
					$co="zebra1";
					$co2="zebra2";
					$sqlr="select d.numerotipo, sum(d.valdebito), sum(d.valcredito) from pptocomprobante_det d, pptocomprobante_cab c where d.tipo_comp=c.tipo_comp and d.tipo_comp=$_POST[tipocomprobante] and d.numerotipo=c.numerotipo and d.tipomovimiento='201' and d.estado=c.estado and d.estado=1 group by numerotipo";
					$res=mysql_query($sqlr,$linkbd);
					// echo $sqlr;
					echo "<table class='inicio'>
							<tr >
								<td class='titulos2'>Consecutivo</td>
								<td class='titulos2'>Debito</td>
								<td class='titulos2'>Credito</td>
								<td class='titulos2'>Tipo de Reversion</td>
							</tr>";
					while($row=mysql_fetch_row($res)){
						if(($row[1]-$row[2])>0){
							if($row[2]==0){
								$reversion="REVERSION TOTAL";
							}else{
								$reversion="REVERSION PARCIAL";
							}
							echo "
								<tr class='$co'>
									<td>$row[0]</td>
									<td>$row[1]</td>
									<td>$row[2]</td>
									<td>$reversion</td>
								</tr>";
							$aux=$co;
							$co=$co2;
							$co2=$aux;
						}
					}
					echo "</table>";
				?>
			</div>
		</form>
   	</body>
</html>