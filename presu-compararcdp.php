<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
	$_POST[oculto2]=$_GET[oculto2];
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
        <script type="text/javascript" src="css/programas.js"></script>
        <script>
			function crearexcel(){
				
			}
        </script>
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
				<a href="#" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
				<a class="mgbt"><img src="imagenes/guardad.png"/></a>
				<a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
				<a href="#" class="mgbt" onClick="mypop=window.open('presu-principal.php','',''); mypop.focus();"><img src="imagenes/nv.png" title="Nueva Ventana"></a> 
				<a href="presu-comparavalorcomprobantes.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
				</td>
         	</tr>	
		</table>
 		<form name="form2" method="post" action="">  
			<input type="hidden" name="nn[]" id="nn[]" value="<?php echo $_POST[nn] ?>" >
 			
				
                <?php
					$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
					
						echo "<table class='inicio' align='center'>
							<tr class='titulos' style='text-align:center;'>
								<td style='width:7%;'>No cdp - tabla original</td>
								<td style='width:7%;'>No cdp - tabla general</td>
								<td style='width:7%;'>Valor cdp - tabla original</td>
								<td style='width:7%;'>Valor cdp - tabla general</td>
								<td style='width:7%;'>Tipo de comprobante</td>
								<td style='width:0.5%;'></td>
							</tr>
						</table>";
						$iter='saludo1b';
                        $iter2='saludo2b';
						$filas=1;
					?>
			<div class="subpantallac5" style="height:70%; width:99.6%; margin-top:0px; overflow-x:hidden" id="divdet">
				<table class='inicio' align='center'>
					<?php
						$sqlr="select consvigencia,saldo from pptocdp where estado!='N' and vigencia='$vigusu'";
						$r=mysql_query($sqlr,$linkbd);
						while($row =mysql_fetch_row($r))
						{
							$sqlr1="select sum(valdebito), sum(valcredito), numerotipo,tipo_comp from pptocomprobante_det where vigencia='$vigusu' and estado!='0' and numerotipo='$row[0]' and tipo_comp='6'";
							$r1=mysql_query($sqlr1,$linkbd);
							$row1 =mysql_fetch_row($r1);
							
							if($row[1]!=($row1[0]-$row1[1])){
								$stilo="background-color:#FF9";
							}
							else $stilo="background-color:#AADFFB";
							echo"<tr class='$iter' style='$stilo' >
	                                <td style='width:7%;'>$row[0]</td>
	                                <td style='width:7%;'>$row1[2]</td>
									<td style='width:7%;' style='text-align:right;'>".number_format($row[1])."</td>
									<td style='width:7%;' style='text-align:right;'>".number_format($row1[0]-$row1[1])."</td>
									<td style='width:7%;' style='text-align:right;'>$row1[3]</td>
								
								</tr>";
						}
                        
						echo "</table>";
					
                ?>
				
            </div>
		
        </form> 
</body>
</html>