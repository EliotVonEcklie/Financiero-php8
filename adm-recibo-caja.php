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
        <script type="text/javascript" src="css/calendario.js"></script>
        <script>
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
            <tr><script>barra_imagenes("adm");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("adm");?></tr>
        	<tr>
  				<td colspan="3" class="cinta">
				<a href="teso-ingresos.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
				<a class="mgbt"><img src="imagenes/guarda.png"/></a>
				<a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
				<a href="#" class="mgbt" onClick="mypop=window.open('principal.php','',''); mypop.focus();"><img src="imagenes/nv.png" title="Nueva Ventana"></a> 
				<a href="#" onclick="crearexcel()" class="mgbt"><img src="imagenes/excel.png" title="Excell"></a><a href="adm-comparacomprobantes-presu.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a></td>
         	</tr>	
		</table>
 		<form name="form2" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">  
			<input type="hidden" name="nn[]" id="nn[]" value="<?php echo $_POST[nn] ?>" >
 			
				
                <?php
					//$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
                    // $sqlr="select count(*) from tesoegresos T, comprobante_cab C where T.id_egreso=C.numerotipo and C.tipo_comp=6 order by T.id_egreso ";
					// $r=mysql_query($sqlr,$linkbd);
                    // $row =mysql_fetch_row($r);
                    // $ntr=$row[0];
					
					$sqlr="select count(*) from tesoreciboscaja";
					$r=mysql_query($sqlr,$linkbd);
                    $row =mysql_fetch_row($r);
                    $eet=$row[0];
					
					//CODIGO PARA INSERTAR VALOR DEL EGRESO EN LA TABLA PPTOCOMPROBNTE_CAB
					//------------------------------------------------------------------------------------------
					/*
					$sqlr="select count(*) from tesoordenpago C";
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
						$sqlr="select T.id_egreso, T.concepto, T.valortotal, C.valorpagar, T.estado, C.id_orden from tesoegresos T, tesoordenpago C where T.id_orden=C.id_orden  order by T.id_egreso";	
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
								
							$sqlr2="UPDATE pptocomprobante_cab SET total_debito='$row[3]' WHERE numerotipo='$row[0]' and tipo_comp='11'";
							mysql_query($sqlr2,$linkbd);
									
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
			//-----------------------------------------------------------------------------
			//FIN CODIGO PARA INSERTAR EL VALOR DE EGRESO EN LA TABLA PPTOCOMPROBNTE_CAB
			**/
			
			//INICIO CODIGO PARA COMPARAR EL VALOR DEL EGRESO DE TESORERIA Y PRESUPUESTO
			
					$sqlr="select count(*) from pptocomprobante_cab C where C.tipo_comp='16'";
					$r=mysql_query($sqlr,$linkbd);
                    $row =mysql_fetch_row($r);
                    $eec=$row[0];

                       
						$iter='saludo1b';
                        $iter2='saludo2b';
						$filas=1;
					?>
			<table width="100%" align="center"  class="inicio" >
                <tr>
                    <td class="titulos" colspan="9">:: Buscar .: Ingresos Recibos de Caja </td>
                    <td class="cerrar" style='width:7%' onClick="location.href='presu-principal.php'">Cerrar</td>
                    <input type="hidden" name="oculto" id="oculto" value="1">
                    <input type="hidden" name="iddeshff" id="iddeshff" value="<?php echo $_POST[iddeshff];?>">	 
                </tr>                       
                <tr>
                    <td  class="saludo1" >Fecha Inicial: </td>
                    <td><input type="search" name="fechaini" id="fc_1198971545" title="YYYY/MM/DD"  value="<?php echo $_POST[fechaini]; ?>" onKeyUp="return tabular(event,this)" onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">&nbsp;<img src="imagenes/calendario04.png" style="width:20px" onClick="displayCalendarFor('fc_1198971545');" class="icobut" title="Calendario"></td>
                    <td  class="saludo1" >Fecha Final: </td>
                    <td ><input type="search" name="fechafin" id="fc_1198971546" title="YYYY/MM/DD"  value="<?php echo $_POST[fechafin]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">&nbsp;<img src="imagenes/calendario04.png" style="width:20px" onClick="displayCalendarFor('fc_1198971546');"  class="icobut" title="Calendario"></td>  
                    <td><input type="button" name="bboton" onClick="validar()" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;" /></td>
                </tr>
			</table>
			<?php
			if($_POST['oculto']==3){
						echo "
							<div class='subpanta' style='width:100%; margin-top:0px; overflow-x:hidden;overflow-y:scroll' id='divdet'>
			<table class='inicio' align='center'>
						<tr>
                           <td colspan='10' class='titulos'>.: Resultados Busqueda:</td>
                                </tr>
                                <tr>
                                    <td colspan='10'>Ingresos Recibos de Caja Encontrados: Tesoreria: $eet - Presupuesto: $eec</td>
                                </tr>
						
						 <tr class='titulos ' style='text-align:center;'>
								<td ></td>
								<td ></td>
								<td ></td>
								<td ></td>
								<td >Tesoreria</td>
								<td colspan='2' >Presupuesto</td>
							</tr>
							<tr class='titulos' style='text-align:center;'>
								<td id='col1'>Id Recibo</td>
								<td id='col2'>Estado</td>
								<td id='col3'>Concepto</td>
								<td id='col4'>Recaudado en</td>
								<td id='col5'>Valor Total</td>
								<td id='col6'>Total Debito</td>
								<td id='col7'>Total Credito</td>
							</tr></table></div>";
		?>
				
			
					<?php
						
						echo "<div class='subpantallac5' style='height:55%; width:99.6%; margin-top:0px; overflow-x:hidden' id='divdet'>
				<table class='inicio' align='center' id='valores' >
				<tbody>";
						//$sqlr="select T.id_egreso, T.concepto, T.valortotal, C.valorpagar, T.estado, C.id_orden from tesoegresos T, tesoordenpago C where T.id_orden=C.id_orden  order by T.id_egreso";	
						$queryDate="";
						if(isset($_POST['fechafin']) and isset($_POST['fechaini'])){

							if(!empty($_POST['fechaini']) and !empty($_POST['fechafin'])){
								$fechaInicial=date('Y-m-d',strtotime($_POST['fechaini']));
								$fechaFinal=date('Y-m-d',strtotime($_POST['fechafin']));
								$queryDate="AND T.fecha>='".$fechaInicial."' and T.fecha<='".$fechaFinal."'";
							}
						}
						$sqlr="select T.id_recibos,T.estado,R.concepto,T.recaudado,T.valor,sum(D.valdebito),sum(D.valcredito) from tesoreciboscaja T,pptocomprobante_det D,tesorecaudos R where T.id_recibos=D.numerotipo AND D.tipo_comp='16' AND R.id_recaudo=T.id_recaudo $queryDate group by T.id_recibos";	
						$resp=mysql_query($sqlr,$linkbd);
						$arreglo=Array();
                        $resp=mysql_query($sqlr,$linkbd);
                        while ($row =mysql_fetch_row($resp)) 
                        {
							$stilo="";
							$stado="";
							if($row[1]=='N'){
								$stado="color:red";
							}
							$estCaja="";
							if($row[1]=='R'){
								$estCaja='Reversado';
							}else if($row[1]=='S'){
								$estCaja='Activo';
							}else if($row[1]=='N'){
								$estCaja='Anulado';
							}else if($row[1]=='P'){
								$estCaja='Pagado';
							}else if($row[1]=='C'){
								$estCaja='Con registro';
							}
							if((($row[4]!=$row[5]) && $row[1]=='S') || ( ($row[4]!=$row[5] || $row[4]!=$row[6] || $row[5]!=$row[6]) && $row[1]=='R')){
								$stilo="background-color:yellow !important";
							}
                            echo"<tr class='$iter' style='$stilo; $stado;' >
	                                <td style='width:7%;' id='1'>$row[0]</td>
	                                <td style='width:4%;' id='2'>$estCaja</td>
	                                <td style='width:32%;' id='3'>$row[2]</td>
	                                <td style='width:7%;' id='4'>$row[3]</td>
									<td style='text-align:right;width:3%;' id='5'>$".number_format($row[4],2,',','.')."</td>
									
									<td  style='text-align:right;width:4.5%;' id='6'>$".number_format($row[5],2,',','.')."</td>
									<td  style='text-align:right;width:4.5%;' id='7'>$".number_format($row[6],2,',','.')."</td>
								
								</tr>";
							
									
                            $con+=1;
                            $aux=$iter;
                            $iter=$iter2;
                            $iter2=$aux;
							$filas++;
							$resultadoSuma=0.0;
                        } 
						echo "</table></tbody>
            </div>";
						
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
        				
        					
        				});
        			}
        		
        	});	
        </script>
</body>
</html>