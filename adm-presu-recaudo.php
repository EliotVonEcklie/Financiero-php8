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
        <title>:: Spid - Administracion</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
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
            <tr><script>barra_imagenes("adm");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("adm");?></tr>
        	<tr>
  				<td colspan="3" class="cinta">
				<a href="teso-ingresos.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
				<a class="mgbt"><img src="imagenes/guarda.png"/></a>
				<a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
				<a href="#" class="mgbt" onClick="mypop=window.open('principal.php','',''); mypop.focus();"><img src="imagenes/nv.png" title="Nueva Ventana"></a> 
				<a href="#" onclick="crearexcel()" class="mgbt"><img src="imagenes/excel.png" title="Excell"></a><a href="adm-comparacomprobantes-cont.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a></td>
         	</tr>	
		</table>
 		<form name="form2" method="post" action="">  
			<input type="hidden" name="nn[]" id="nn[]" value="<?php echo $_POST[nn] ?>" >
 			
				
                <?php
					//$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
                    // $sqlr="select count(*) from tesoegresos T, comprobante_cab C where T.id_egreso=C.numerotipo and C.tipo_comp=6 order by T.id_egreso ";
					// $r=mysql_query($sqlr,$linkbd);
                    // $row =mysql_fetch_row($r);
                    // $ntr=$row[0];
					
					$sqlr="select count(*) from tesoegresos";
					$r=mysql_query($sqlr,$linkbd);
                    $row =mysql_fetch_row($r);
                    $eet=$row[0];
					
					$sqlr="select count(*) from pptocomprobante_cab C where C.tipo_comp=11";
					$r=mysql_query($sqlr,$linkbd);
                    $row =mysql_fetch_row($r);
                    $eec=$row[0];

                        echo utf8_decode ("
                            <table class='inicio' align='center'>
                                <tr>
                                    <td colspan='6' class='titulos'>.: Resultados Busqueda:</td>
                                </tr>
                                <tr>
                                    <td colspan='6'>Egresos Encontrados: Tesoreria: $eet - Presupuesto: $eec</td>
                                </tr>");	
                        
						
						echo "<tr class='titulos ' style='text-align:center;'>
								<td></td>
								<td></td>
								<td >Tesoreria</td>
								<td colspan='2' >Presupuesto</td>
							</tr>
							<tr class='titulos' style='text-align:center;'>
								<td style='width:7%;'>Id Egreso</td>
								<td style='width:68%;'>Concepto</td>
								<td style='width:6.8%;'>Valor Total</td>
								<td style='width:7%;'>Total Debito</td>
								<td style='width:7%;'>Total Credito</td>
							</tr>
						</table>";
						$iter='saludo1b';
                        $iter2='saludo2b';
						$filas=1;
					?>
			<div class="subpantallac5" style="height:40%; width:99.6%; margin-top:0px; overflow-x:hidden" id="divdet">
				<table class='inicio' align='center'>
					<?php
						$sqlr="select T.id_egreso, T.concepto, T.valortotal, C.total_debito, C.total_credito, T.estado from tesoegresos T, pptocomprobante_cab C where T.id_egreso=C.numerotipo and C.tipo_comp=11 order by T.id_egreso";	
						$resp=mysql_query($sqlr,$linkbd);
                        while ($row =mysql_fetch_row($resp)) 
                        {
							$stilo="";
							if(($row[2]!=$row[3])){
								$stilo="background-color:#FF9";
							}
							$stado="";
							if($row[5]=='N'){
								$stado="color:red";
							}
                            echo"<tr class='$iter' style='$stilo; $stado;' >
	                                <td style='width:7%;'>$row[0]</td>
	                                <td>$row[1]</td>
									<td style='width:7%;' style='text-align:right;'>".number_format($row[2])."</td>
									<td style='width:7%;' style='text-align:right;'>".number_format($row[3])."</td>
									<td style='width:7%;' style='text-align:right;'>".number_format($row[4])."</td>
								
								</tr>";
									
                            $con+=1;
                            $aux=$iter;
                            $iter=$iter2;
                            $iter2=$aux;
							$filas++;
                        } 
						echo "</table>";
						
						
						
                ?>
				
            </div>
			<?php 
				$dif=$eet-$eec;
				echo "<table class='inicio' align='center'>
                        <tr>
                            <td colspan='6' class='titulos'>.: Egresos No Encontrados en Presupuesto: $dif</td>
						</tr>
						<tr class='titulos' style='text-align:center;'>
							<td style='width:7%;'>Id Egreso</td>
							<td>Concepto</td>
							<td style='width:7%;'>Valor Debito</td>
						</tr>
					</table>";
			?>
			<div class="subpantallac5" style="height:18%; width:99.6%; margin-top:0px; overflow-x:hidden" id="divdet">
				<table class='inicio' align='center'>
			<?php
				$sqlr="select * from tesoegresos";
				$resp=mysql_query($sqlr,$linkbd);
				$iter='saludo1b';
				$iter2='saludo2b';
				$filas=1;
				while ($row =mysql_fetch_row($resp)) 
				{
					$sqlr1="select * from pptocomprobante_cab where tipo_comp=11 and numerotipo=$row[0]";
					$resp1=mysql_query($sqlr1,$linkbd);
					$row1 =mysql_fetch_row($resp1);
					//echo $row1[1]."<br>";
					if($row[13]=='N'){
						$stado="color:red";
					}
					if($row1[0]==''){
						echo "<tr class='$iter' $stado;' >
								<td style='width:7%;'>$row[0]</td>
								<td>$row[8]</td>
								<td style='width:7%;'>$row[5]</td>
								";
								
						$con+=1;
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
						$filas++;
					}
				}
				echo "</table>";
			?>
        </form> 
</body>
</html>