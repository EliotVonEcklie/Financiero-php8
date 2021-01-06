<?php
	ini_set('max_execution_time',3600);
	require "comun.inc";
	require "funciones.inc";
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
		<link href="css/css4.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
        <script type="text/javascript" src="css/programas.js"></script>
        <script type="text/javascript" src="css/calendario.js"></script>
        <script>
			$(window).load(function () { $('#cargando').hide();});
			function crearexcel(){
				
			}
			function validar()
			{
				document.getElementById('oculto').value='3';
				document.form2.submit(); 
			}
        </script>
		<?php titlepag();?>
        <style type="text/css">
        	#valores tbody tr:nth-child(even) {background: #ffffff !important}
        	#valores tbody tr:nth-child(odd) {background: #eee !important}
        	#valores tbody tr:nth-child(even):hover {background: linear-gradient(#40f3ff , #40b3ff 70%, #40f3ff ) !important}
        	#valores tbody tr:nth-child(odd):hover {background: linear-gradient(#40f3ff , #40b3ff 70%, #40f3ff ) !important}
        </style>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("presu");?></tr>
        	<tr>
  				<td colspan="3" class="cinta">
				<a href="teso-ingresos.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
				<a class="mgbt"><img src="imagenes/guarda.png"/></a>
				<a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
				<a href="#" class="mgbt" onClick="mypop=window.open('principal.php','',''); mypop.focus();"><img src="imagenes/nv.png" title="Nueva Ventana"></a> 
				<a href="#" onclick="crearexcel()" class="mgbt"><img src="imagenes/excel.png" title="Excell"></a><a href="presu-estadocomprobantes.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a></td>
         	</tr>	
		</table>
 		<form name="form2" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>"> 
		 	<div class="loading" id="divcarga"><span>Cargando...</span></div>
			<input type="hidden" name="nn[]" id="nn[]" value="<?php echo $_POST[nn] ?>" >
 			
				
                <?php
					if($_POST[oculto]==""){echo"<script>document.getElementById('divcarga').style.display='none';</script>";}
					$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
                    // $sqlr="select count(*) from tesoegresos T, comprobante_cab C where T.id_egreso=C.numerotipo and C.tipo_comp=6 order by T.id_egreso ";
					// $r=mysql_query($sqlr,$linkbd);
                    // $row =mysql_fetch_row($r);
                    // $ntr=$row[0];
					$queryDate1="";
					$queryDate2="";
						if(isset($_POST['fechafin']) and isset($_POST['fechaini'])){

							if(!empty($_POST['fechaini']) and !empty($_POST['fechafin'])){
								$fechaInicial=date('Y-m-d',strtotime($_POST['fechaini']));
								$fechaFinal=date('Y-m-d',strtotime($_POST['fechafin']));
								$queryDate1="WHERE E.fecha>='".$fechaInicial."' and E.fecha<='".$fechaFinal."'";
								$queryDate2="AND E.fecha>='".$fechaInicial."' and E.fecha<='".$fechaFinal."'";
							}
						}
						
					$sqlr="select count(E.id_egreso) from tesoegresos E $queryDate1";
					$r=mysql_query($sqlr,$linkbd);
                    $row =mysql_fetch_row($r);
                    $eet=$row[0];
					
					
					$sqlr="select count(P.idrecibo) from tesoegresos E,pptoretencionpago P WHERE E.id_egreso=P.idrecibo AND P.tipo='egreso' $queryDate2";
					$r=mysql_query($sqlr,$linkbd);
                    $row =mysql_fetch_row($r);
                    $eec=$row[0];
			           
						$iter='saludo1b';
                        $iter2='saludo2b';
						$filas=1;
					?>
			<table width="100%" align="center"  class="inicio" >
                <tr>
                    <td class="titulos" colspan="9">:: Buscar .: Egresos</td>
                    <td class="cerrar" style='width:7%' onClick="location.href='presu-principal.php'">Cerrar</td>
                    <input type="hidden" name="oculto" id="oculto" value="1">
                    <input type="hidden" name="iddeshff" id="iddeshff" value="<?php echo $_POST[iddeshff];?>">	 
                </tr>                       
                <tr>
                    <td  class="saludo1" >Fecha Inicial: </td>
                    <td><input type="search" name="fechaini" id="fc_1198971545" title="YYYY/MM/DD"  value="<?php echo $_POST[fechaini]; ?>" onKeyUp="return tabular(event,this)" onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">&nbsp;<img src="imagenes/calendario04.png" style="width:20px" onClick="displayCalendarFor('fc_1198971545');" class="icobut" title="Calendario"></td>
                    <td  class="saludo1" >Fecha Final: </td>
                    <td ><input type="search" name="fechafin" id="fc_1198971546" title="YYYY/MM/DD"  value="<?php echo $_POST[fechafin]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">&nbsp;<img src="imagenes/calendario04.png" style="width:20px" onClick="displayCalendarFor('fc_1198971546');"  class="icobut" title="Calendario"></td> 
					<td style=" padding-bottom: 0em"><em class="botonflecha" onClick="validar()">Buscar</em></td>
                </tr>
			</table>
					
			<?php
if($_POST['oculto']==3){
						echo "
<div class='subpanta' style='width:100%; margin-top:0px; overflow-x:hidden;overflow-y:scroll' id='divdet'>
			<table class='inicio' align='center'>
					 
<tr>
                                    <td colspan='11' class='titulos'>.: Resultados Busqueda:</td>
                                </tr>
                                <tr>
                                    <td colspan='11'>Egresos Encontrados: Tesoreria: $eet - Presupuesto: $eec</td>
                                </tr>
						
						 <tr class='titulos ' style='text-align:center;'>
								<td ></td>
								<td ></td>
								<td ></td>
								<td colspan='3' >Tesoreria</td>
								<td  >Presupuesto</td>
								
							</tr>
							<tr class='titulos' style='text-align:center;'>
								<td id='col1'>Id Egreso</td>
								<td id='col11'>Estado</td>
								<td id='col2'>Concepto</td>
								<td id='col3'>Valor Total</td>
								<td id='col4'>Valor a Pagar</td>
								<td id='col5'>Retenciones</td>
								<td id='col10'>Retenciones</td>
							</tr></table>
</div>";

		?>
				
			
				<tbody>
					<?php
						echo "<div class='subpantallac5' style='height:50%; width:99.6%; margin-top:0px; overflow-x:hidden;'' id='divdet'>
				<table class='inicio' align='center' id='valores' >";
					
						//$sqlr="select T.id_egreso, T.concepto, T.valortotal, C.valorpagar, T.estado, C.id_orden from tesoegresos T, tesoordenpago C where T.id_orden=C.id_orden  order by T.id_egreso";	
						$queryDate="";
						if(isset($_POST['fechafin']) and isset($_POST['fechaini'])){

							if(!empty($_POST['fechaini']) and !empty($_POST['fechafin'])){
								$fechaInicial=date('Y-m-d',strtotime($_POST['fechaini']));
								$fechaFinal=date('Y-m-d',strtotime($_POST['fechafin']));
								$queryDate="WHERE T.fecha>='".$fechaInicial."' and T.fecha<='".$fechaFinal."'";
							}
						}
						function calcularRetenciones($numCxp)
						{
							$linkbd=conectar_bd();	
							$totalRetenciones = 0;
							$sqlrRetenciones = "SELECT id_retencion, valor FROM tesoordenpago_retenciones WHERE id_orden='$numCxp'";
							//echo $sqlrRetenciones."<br>";
							//$resRetenciones = mysql_query($sqlrRetenciones,$linkbd);
							$resRetenciones=mysql_query($sqlrRetenciones,$linkbd);

							while ($rowRetenciones = mysql_fetch_row($resRetenciones))
							{
								$sqlrPorcentaje = "SELECT porcentaje FROM tesoretenciones_det WHERE codigo='$rowRetenciones[0]' AND conceptocausa!='-1'";
								$resPorcentaje = mysql_query($sqlrPorcentaje,$linkbd);
								$rowPorcentaje = mysql_fetch_row($resPorcentaje);
								$totalRetenciones += (($rowPorcentaje[0]/100) * $rowRetenciones[1]);
							}
							return $totalRetenciones;
						}
						$sqlr="select T.id_egreso, T.concepto, T.valortotal, T.estado, T.valorpago, T.id_orden from tesoegresos T  $queryDate group by T.id_egreso";	
						$resp=mysql_query($sqlr,$linkbd);
						$arreglo=Array();
                        $resp=mysql_query($sqlr,$linkbd);
                        while ($row =mysql_fetch_row($resp)) 
                        {
							$retencion = 0;
							$resultadoSuma=0.0;
							$diff = 0;
                        	$consulta="select sum(valor) from pptoretencionpago where tipo='egreso' and idrecibo=$row[0]";
                        	$respPresu=mysql_query($consulta,$linkbd);
                        	while ( $rowj=mysql_fetch_row($respPresu)) {
                        		$resultadoSuma+=$rowj[0];
							}
							

							$stilo="";
							$stado="";
							if($row[3]=='N' || $row[3]=='R'){
								$stado="color:red";
							}
							$colEstado="";
							if($row[3]=='S'){
								$colEstado="Activo";
							}else if($row[3]=='N'){
								$colEstado="Anulado";
							}else if($row[3]=='R'){
								$colEstado="Reversado";
							}else if($row[3]=='C'){
								$colEstado="Completado";
							}
							$dif_retencion = calcularRetenciones($row[5]);
							$diff = round($dif_retencion - $resultadoSuma);
							if((($dif_retencion==0 && $resultadoSuma!=0.0) || ($dif_retencion!=0 && $resultadoSuma==0.0) && $row[3]!='R') ||  $diff!=0){
								$stado="background: yellow !important;";
							}
                            echo"<tr class='$iter' style='$stilo; $stado;' data-rel=''>
	                                <td style='width:5%;' id='1'>$row[0]</td>
	                                <td  style='width:4%;' id='11'>".$colEstado."</td>
	                                <td style='width:32%;' id='2'>$row[1]</td>
									<td style='text-align:right;width:3%;' id='3'>$".number_format($row[2],2,',','.')."</td>
									<td  style='text-align:right;width:3%;' id='4'>$".number_format($row[4],2,',','.')."</td>
									<td  style='text-align:right;width:3%;' id='5'>$".number_format($dif_retencion,2,',','.')."</td>
									<td  style='text-align:right;width:5%;' id='10'>$".number_format($resultadoSuma,2,',','.')."</td>
									
								
								</tr>";
							
									
                            $con+=1;
                            $aux=$iter;
                            $iter=$iter2;
                            $iter2=$aux;
							$filas++;
							$resultadoSuma=0.0;
                        } 
						echo "</table></tbody>
            </div><script>document.getElementById('divcarga').style.display='none';</script>";
						
              }
						
					//FIN CODIGO PARA COMPARAR EL VALOR DEL EGRESO DE TESORERIA Y PRESUPUESTO 	
					
                ?>
				
        </form> 
        <script type="text/javascript">
        	jQuery(function($){
        		if(jQuery){
        			
        				$('#valores tbody tr:first-child td').each(function(index, el) {
        					if($(this).attr('id')=='1'){
        					
        						$('#col1').css('width',$(this).css('width'));
        					}
        					if($(this).attr('id')=='2'){
        					
        						$('#col2').css('width',$(this).css('width'));
        					}
        					if($(this).attr('id')=='3'){
        					
        						$('#col3').css('width',$(this).css('width'));
        					}
        					if($(this).attr('id')=='4'){
        					
        						$('#col4').css('width',$(this).css('width'));
        					}
        					if($(this).attr('id')=='5'){
        					
        						$('#col5').css('width',$(this).css('width'));
        					}
        					if($(this).attr('id')=='6'){
        					
        						$('#col6').css('width',$(this).css('width'));
        					}
        					if($(this).attr('id')=='7'){
        					
        						$('#col7').css('width',$(this).css('width'));
        					}
        					if($(this).attr('id')=='8'){
        					
        						$('#col8').css('width',$(this).css('width'));
        					}
        					if($(this).attr('id')=='9'){
        					
        						$('#col9').css('width',$(this).css('width'));
        					}
        					if($(this).attr('id')=='10'){
        					
        						$('#col10').css('width',$(this).css('width'));
        					}
        					if($(this).attr('id')=='11'){
        					
        						$('#col11').css('width',$(this).css('width'));
        					}
        				});

        				$(window).resize(function() {
						   location.reload();
						});
        			}
        		
        	});	
        </script>
</body>
</html>