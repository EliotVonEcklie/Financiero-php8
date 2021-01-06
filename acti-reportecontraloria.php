<?php
	require"comun.inc";
	require"funciones.inc";
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]); 
	header("Cache-control: private"); 
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<?php require 'head.php';?>
		<title>:: Spid - Control de activos</title>
		<script>

			function csv()
			{
				document.form2.action="acti-reportecontraloriacsv.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				switch(_tip)
				{
					case "1":
						document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
					case "2":
						document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
					case "3":
						document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
					case "4":
						document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;	
				}
			}
			function funcionmensaje()
			{
				document.location.href = "cont-homologacioncuentas.php";
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("acti");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("acti");?></tr>
			<tr>
  				<td colspan="3" class="cinta">
					<a class="tooltip bottom  mgbt"><img src="imagenes/add2.png"/></a>
					<a class="tooltip bottom  mgbt"><img src="imagenes/guardad.png"/></a>
					<a href="acti-reportecontraloria.php" class="tooltip bottom mgbt"><img src="imagenes/busca.png"/><span class="tiptext">Buscar</span></a>
					<a onClick="csv();" class="tooltip bottom  mgbt"><img src="imagenes/csv.png"><span class="tiptext">Exportar CSV</span></a>
					<a onClick="mypop=window.open('cont-principal.php','','');mypop.focus();" class="tooltip bottom  mgbt"><img src="imagenes/nv.png"><span class="tiptext">Nueva Ventana</span></a>
					<a onClick="mypop=window.open('<?php echo $url2; ?>','','');mypop.focus();" class="tooltip bottom mgbt"><img src="imagenes/duplicar_pantalla.png"><span class="tiptext">Duplicar pesta&ntilde;a</span></a>
				</td>
		 	</tr>
		</table>
		<div id="bgventanamodalm" class="bgventanamodalm">
			<div id="ventanamodalm" class="ventanamodalm">
				<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
				</IFRAME>
			</div>
		</div>
  		<form name="form2" action="acti-reportecontraloria.php"  method="post" enctype="multipart/form-data" >
 			<?php
	  			$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
				if(!$_POST[oculto]){$_POST[oculto]=1;}
				$vact=$vigusu;  
				$sqlr="select *from configbasica where estado='S'";
				$res=mysql_query($sqlr,$linkbd);
				while($row=mysql_fetch_row($res))
	 			{
  					$_POST[nitentidad]=$row[0];
  					$_POST[entidad]=$row[1];
					$_POST[codent]=$row[8];
 				}
	 		?> 
			<input type="hidden" name="oculto" id="oculto" value="<?php echo $_POST[oculto] ?>">
   		  	<table class="inicio ancho" align="center"> 
				<tr>
					<td class="titulos" width="100%">Reporte para Contraloria</td>
					<td class="boton02" onclick="location.href='acti-principal.php'">Cerrar</td>
				</tr>  
			</table>   
			<div class="subpantallap" style="height:62.2%;width:99.6%; overflow-x:hidden;">
				<table class='inicio' >
					<tr>
						<td colspan='6' class='titulos'>Reporte</td>

					</tr>
					<tr class="centrartext">
						<td class='titulos2' style='width:5%;'>No</td>
						<td class='titulos2' style='width:10%;'>Fecha Adquisición O Baja</td>
						<td class='titulos2' style='width:15%;'>Concepto</td>
						<td class='titulos2' style='width:15%;'>Codigo Contable</td>
						<td class='titulos2' style='width:37%;'>Detalle</td>
						<td class='titulos2' style='width:8%;'>Valor</td>
					</tr>
					<?php
						$sql="SELECT * FROM acticrearact_det";
						$res=mysql_query($sql,$linkbd);
						$con =1;
						$co="zebra1";
						$co2='zebra2';
						while($row=mysql_fetch_row($res)){
							$rest = substr($row[1],0,-4);
							$sql1="SELECT cuenta_activo FROM acti_activos_det WHERE tipo=$rest";
							$res1=mysql_query($sql1,$linkbd);
							$row1=mysql_fetch_row($res1);
							echo "<tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\" >
							<td class='centrartext'>$con</td>
							<td class='centrartext'>".$row[8]."</td>
							<td class='centrartext'>ADQUISICION</td>
							<td class='centrartext'>".$row1[0]."</td>
							<td>".$row[2]."</td>
							<td style='text-align:right;'>".number_format($row[15],2,',','.')."</td>
							</tr>";	
				
							$con+=1;
							$aux=$co;
							$co=$co2;
							$co2=$aux;
							$sumavalor+=$row[15];
						}		
						echo "<tr class='$co' style='text-align:right;'><td colspan='5'><b>TOTALES: </b></td><td>".number_format($sumavalor,2,',','.')."</td></tr>";

					?>
				</table>
			</div>
		</form>
	</body>
</html>