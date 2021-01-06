<?php
	require"comun.inc";
	require"funciones.inc";
	sesion();
	$_SESSION["usuario"] ;
	$_SESSION["perfil"] ;
	$_SESSION["linkset"] ;
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Spid - Administracion</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
		<link href="css/tabs.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
        <script type="text/javascript" src="JQuery/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="JQuery/autoNumeric-master/autoNumeric-min.js"></script>
		<script>
			jQuery(function($){ $('#vltmindustria').autoNumeric('init');});
			function guardar()
			{
	
				if (confirm("Esta Seguro de Guardar"))
				{
					document.form2.oculto.value=2;
					document.form2.submit();
				}
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("adm");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("adm");?></tr>
   			<tr>
  				<td colspan="3" class="cinta"><a class="mgbt" onClick="location.href='adm-firmas.php'"><img src="imagenes/add.png" title="Nuevo"/></a><a class="mgbt" onClick="guardar()" ><img src="imagenes/guarda.png" title="Guardar"/></a><a class="mgbt1"><img src="imagenes/buscad.png"/></a><a class="mgbt" onClick="<?php echo paginasnuevas("adm");?>"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
    		</tr>
    	</table>		  
		<form name="form2" method="post" >
			<?php
 				$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
			
  					$_POST[diacorte]=1;
					$angu=array();
					$selregis="SELECT id_comprobante,id_cargo FROM pptofirmas WHERE vigencia='$vigusu'";
					$resul=mysql_query($selregis,$linkbd);
					while($filas=mysql_fetch_row($resul))
					{
						$angu[]="$filas[0]-$filas[1]";
					}
  					
			?>
       				<div style="height:68%; width:99.6%; overflow-x: scroll;"> 
         				<table class="inicio" >
							<head>
								<td class='titulos2' align="center">Cargos</td>
							<?php 
								//selecciona el nombre del cargo registrado, para el titulo de la tabla
								$sqlr="select nombrecargo from planaccargos where estado='S' order by codcargo";
								$res = mysql_query($sqlr,$linkbd);
								$cont=count($angu);
								$k=0;
								echo "<td class='titulos2' align='center'>BENEFICIARIO</td>";
								while($row=mysql_fetch_row($res))
								{
									echo "<td class='titulos2' align='center'>$row[0]</td>";
								}
								//seleccionael nombre y el id de cada comprobante de contabilidad
								$sqlr="select nombre,id_tipo from pptotipo_comprobante where estado='S' order by id_tipo";
								$res = mysql_query($sqlr,$linkbd);
								?>
								</head>
								<?php								
								while($row=mysql_fetch_row($res))
								{
									echo "<tr>";
									echo "<td class='saludo1'>$row[0]</td>";
									//selecciona el codigo del cargo para crear los checkboxs
									$sqlr1="select codcargo from planaccargos where estado='S' order by codcargo";
									$res1 = mysql_query($sqlr1,$linkbd);
									while($row1=mysql_fetch_row($res1))
									{
										$posCargo=$row1[0]-1;
										$pos="$row[1]-$posCargo";
										$check="";
										for($f=0;$f<$cont;$f++)
										{
											if($angu[$f]==$pos){
												$check="checked";
											}
										}
										
										$k=$f+$cont;
										$_POST[select1]="$row[1]-$posCargo";
										
										echo "<td class='saludo1' align='center'><input name='selec[]' value='$_POST[select1]' type='checkbox' $check/></td>";	
									}
									echo "</tr>";
								} 
							?>
							
							</tr>
							<input type="hidden" value="0" name="oculto">
						</table>
			</div>
      		<?php
				$oculto=$_POST[oculto];
				if($oculto=="2")
				{echo "hola";
					//recorrer el array donde se guardan los check seleccionados
					//elimina registro si existen en tabla firmas
					$delregis="DELETE FROM pptofirmas";
					mysql_query($delregis,$linkbd);
					foreach($_POST[selec] as $key=>$value)
					{
						//varios strings de un solo string, separados por un guion
						$ang = explode("-", $value);
						//actualizar o guardar en 
						$inregis="INSERT INTO pptofirmas (id_comprobante,id_cargo,vigencia) VALUES ('$ang[0]','$ang[1]','$vigusu')";
						mysql_query($inregis,$linkbd);
					}
					?>
					<script>
						document.form2.oculto.value='';
						document.form2.submit();
					</script>
					<?php
				}
			?>
		</form>
	</body>
</html>