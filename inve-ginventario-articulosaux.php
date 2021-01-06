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
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<?php require "head.php"; ?>
		<script>
			function validar(){document.form2.submit();}
			function buscaref(){document.form2.oculto.value=2;document.form2.submit();}
			function ponprefijo(opc1,opc2,opc3,opc4,opc5,opc6)
			{
				parent.document.getElementById('docum').value=opc1;	
				parent.document.getElementById('codigoarticulo').value=opc1;	
				parent.document.getElementById('ndocum').value=opc2;
				parent.document.getElementById('narticulo').value=opc2;
				parent.document.getElementById('codigounspsc').value=opc3;
				parent.document.getElementById('cbodega').value=opc4;
				parent.document.getElementById('unidadmedidaart').value=opc5;
				parent.document.getElementById('nombodega').value=opc6;
				parent.document.getElementById('bodega').disabled=true;
				//parent.document.form2.submit();
				parent.despliegamodal2('hidden');
			} 
		</script> 
	</head>
	<body>
		<form name="form2" method="post">
        	<?php
				if($_POST[oculto]=="")
				{
					$_POST[numpos]=0;
					$_POST[numres]=10;
					$_POST[nummul]=0;
				}
				if($_GET[bodega])
				{
					$_POST[bodega] = $_GET[bodega];
				}
			?>
 			<table  class="inicio ancho" style="width:99.4%;" >
      			<tr>
              		<td class="titulos" colspan="4" width="100%">:: Buscar Articulos</td>
                    <td class="boton02" onClick="parent.despliegamodal2('hidden');">Cerrar</td>
                </tr>
     			<tr>
                	<td class="saludo1" style="width:2cm;">:: C&oacute;digo:</td>
                    <td style="width:15%;"><input type="text" name="codigo" id="codigo" value="<?php echo $_POST[codigo];?>" style="width:100%;"/></td>
        			<td class="saludo1" style="width:2cm;">:: Nombre:</td>
        			<td>
                    	<input type="text" name="nombre" id="nombre" value="<?php echo $_POST[nombre];?>" style="width:65%"/>&nbsp;
                        <em class="botonflecha" name="Submit" onClick="document.form2.submit();">Buscar</em>
                    </td>
 				</tr>
 			</table>
            <input type="hidden" name="oculto" id="oculto" value="1"/>
            <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
       		<input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
         	<input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
         	<input type="hidden" name="bodega" id="bodega" value="<?php echo $_POST[bodega];?>"/>
            <div class="subpantallac" style="height:87%; width:99.1%; overflow-x:hidden;">
			<?php
 					$co='saludo1a';
 					$co2='saludo2';
					$crit1="";
                    $crit2="";
					if ($_POST[codigo]!=""){$crit1="AND concat_ws('', grupoinven, codigo) LIKE '%$_POST[codigo]%'";}
                    if ($_POST[nombre]!=""){$crit2="AND nombre LIKE '%$_POST[nombre]%'";}

					$sqlr="SELECT * FROM almarticulos WHERE estado='S' $crit1 $crit2 ORDER BY length(grupoinven),grupoinven ASC, length(codigo),codigo ASC";
					$resp=mysql_query($sqlr,$linkbd);

					if($_POST[numpos]==0)
					{
						$imagenback="<img src='imagenes/back02.png' style='width:17px'>";
						$imagensback="<img src='imagenes/skip_back02.png' style='width:16px'>";
					}
					else
					{
						$imagenback="<img src='imagenes/back01.png' style='width:17px' title='Anterior' onClick='numanterior();'>";
						$imagensback="<img src='imagenes/skip_back01.png' style='width:16px' title='Inicio' onClick='saltocol(\"1\")'>";
					}
					echo"
 					<table class='inicio'>
 						<tr>
							<td class='titulos2' style='width:10%'>Codigo</td>
							<td class='titulos2'>Nombre</td>
							
							<td class='titulos2' style='width:25%'>Grupo Inventario</td>
							<td class='titulos2' style='width:8%'>Disponible</td>
							<td class='titulos2' style='width:8%'>Unidad</td>
							<td class='titulos2' style='width:8%'>CC</td>
						</tr>";
					while($row=mysql_fetch_row($resp))
  					{
						$sqlr1="SELECT nombre FROM productospaa  WHERE codigo='$row[2]' AND tipo='5'";
 						$row1 =mysql_fetch_row(mysql_query($sqlr1,$linkbd));
						$codUNSPSC="$row[2] - $row1[0]";
						$sqlr2="SELECT nombre FROM almgrupoinv WHERE codigo='$row[3]'";
						$row2 =mysql_fetch_row(mysql_query($sqlr2,$linkbd));
						$grupinv="$row2[0]";
						$codart="$row[3]$row[0]";
						$unprinart=almconculta_um_principal($codart);
						
						/*$sqlcc="SELECT id_cc,nombre FROM centrocosto WHERE estado='S' AND entidad='S' ORDER BY id_cc";
						echo $sqlcc;
						$rescc=mysql_query($sqlcc,$linkbd);
						while($rowcc = mysql_fetch_row($rescc))
						{*/
							$nombreBodega = '';
							$sqlrBodegas="SELECT * FROM almbodegas WHERE estado='S' AND id_cc = '$_POST[bodega]' ORDER BY id_cc";
							$respBodegas = mysql_query($sqlrBodegas,$linkbd);
							$rowBodegas =mysql_fetch_row($respBodegas);
							$nombreBodega = $rowBodegas[0]." - ".$rowBodegas[1];;
							$totalreserva=0;
							$disponible=totalinventarioConRutina($codart,$_POST[bodega]);
							$ponePrefijo = '';
							if($disponible>0)
							{
								$ponePrefijo = "\"ponprefijo('$row[3]$row[0]','$row[1]','$row[2]','$disponible','$unprinart','$nombreBodega')\"";
							}
								echo"
								<tr class='$co' onClick=$ponePrefijo style='text-transform:uppercase'>
									<td>$row[3]$row[0]</td>
									<td>$row[1]</td>
									<td>$grupinv</td>
									<td style='text-align:right;'>".number_format($disponible,2,'.',',')."</td>
									<td>$unprinart</td>
									<td>$_POST[bodega]</td>
								</tr>";
								$aux=$co;
								$co=$co2;
								$co2=$aux;
							
						//}
  					}
 					echo"
						</table>";
 			?>
 			</div>
            <input type="hidden" name="numtop" id="numtop" value="<?php echo $_POST[numtop];?>" />
 		</form>
	</body>
</html>
