<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE  6
	date_default_timezone_set("America/Bogota");
	$_POST[oculto2]=$_GET[oculto2];
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
        <title>:: IDEAL</title>
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
			function direccionaComprobante(idCat,tipo_compro,num_compro)
			{
				window.open("cont-buscacomprobantes.php?idCat="+idCat+"&tipo_compro="+tipo_compro+"&num_compro="+num_compro);
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
        	<tr>
  				<td colspan="3" class="cinta">
				<a href="adm-reciboscaja-cont.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
				<a class="mgbt"><img src="imagenes/guarda.png"/></a>
				<a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
				<a href="#" class="mgbt" onClick="mypop=window.open('cont-principal.php','',''); mypop.focus();"><img src="imagenes/nv.png" title="Nueva Ventana"></a> 
				<a href="#" onclick="crearexcel()" class="mgbt"><img src="imagenes/excel.png" title="Excell"></a><a href="cont-estadocomprobantes.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a></td>
         	</tr>	
		</table>
 		<form name="form2" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">  
			<input type="hidden" name="nn[]" id="nn[]" value="<?php echo $_POST[nn] ?>" >
 			
				
                <?php
						$iter='saludo1b';
                        $iter2='saludo2b';
						$filas=1;
					?>
			<table width="100%" align="center"  class="inicio" >
                <tr>
                    <td class="titulos" colspan="9">:: Buscar .: Liquidaciones predial </td>
                    <td class="cerrar" style='width:7%' onClick="location.href='presu-principal.php'">Cerrar</td>
                    <input type="hidden" name="oculto" id="oculto" value="1">
                    <input type="hidden" name="iddeshff" id="iddeshff" value="<?php echo $_POST[iddeshff];?>">	 
                </tr>                       
                <tr>
                    <td  class="saludo1" >Fecha Inicial: </td>
                    <td><input type="search" name="fechaini" id="fc_1198971545" title="YYYY/MM/DD"  value="<?php echo $_POST[fechaini]; ?>" onKeyUp="return tabular(event,this)" onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">&nbsp;<img src="imagenes/calendario04.png" style="width:20px" onClick="displayCalendarFor('fc_1198971545');" class="icobut" title="Calendario"></td>
                    <td  class="saludo1" >Fecha Final: </td>
					<td ><input type="search" name="fechafin" id="fc_1198971546" title="YYYY/MM/DD"  value="<?php echo $_POST[fechafin]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">&nbsp;<img src="imagenes/calendario04.png" style="width:20px" onClick="displayCalendarFor('fc_1198971546');"  class="icobut" title="Calendario"></td>  
					<td class="saludo1" style="width:2.5cm;">Tipo Recaudo:</td>
                    <td >
						<select name="tiporec" id="tiporec" onKeyUp="return tabular(event,this)" onChange="validar()" style="width:95%;height:30px;" disabled>
							<option value="1" <?php if($_POST[tiporec]=='1') echo "SELECTED"; ?>>Predial</option>
						</select>
					</td>
                    <td><input type="button" name="bboton" onClick="validar()" value="&nbsp;&nbsp;Buscar&nbsp;&nbsp;" /></td>
                </tr>
			</table>
					
			<?php
			if($_POST['oculto']==3){
						echo "
						<div class='subpanta' style='width:100%; margin-top:0px; overflow-x:hidden;overflow-y:scroll' id='divdet'>
			<table class='inicio' align='center'>
						<tr>
                           <td colspan='7' class='titulos'>.: Resultados Busqueda:</td>
                                </tr>
						 <tr class='titulos ' style='text-align:center;'>
								<td ></td>
								<td ></td>
								<td >Tesoreria</td>
								<td colspan='2' >Contabilidad</td>
							</tr>
							<tr class='titulos' style='text-align:center;'>
								<td id='col1'>Id Recaudo</td>
								<td id='col2'>Concepto</td>
								<td id='col3'>Valor Total</td>
								<td id='col6'>Valor Total</td>
								<td id='col7'>Diferencia</td>
							</tr>	</table>
</div>";
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
								$queryDate=" T.fecha>='".$fechaInicial."' and T.fecha<='".$fechaFinal."'";
							}
						}
                        $sqlr="select T.idpredial, T.totalmedio, T.estado,T.codigocatastral from tesoliquidapredial T where $queryDate  and T.estado='P' order by T.idpredial ASC";
						//echo $sqlr;
						$resp=mysql_query($sqlr,$linkbd);
						$arreglo=Array();
						$co="zebra1";
                        $co2="zebra2";
                        $totTesoreria=0;
                        $totContabilidad=0;
                        while ($row =mysql_fetch_row($resp)) 
                        {
							$sq="select TD.id_recibos from tesoreciboscaja TD where TD.id_recaudo='$row[0]' and TD.tipo=1 AND estado='S'";
							$re=mysql_query($sq,$linkbd);
							$ro=mysql_fetch_row($re);
								$estilo="";
								$stado="";
								
								
                            $sql="select C.numerotipo,sum(C.valdebito),C.cuenta,T.estado,sum(C.valcredito) from comprobante_det C, comprobante_cab T  where T.numerotipo=C.numerotipo and T.fecha>='".$fechaInicial."' and T.fecha<='".$fechaFinal."'  and T.tipo_comp=C.tipo_comp and C.numerotipo='$ro[0]' and C.tipo_comp='5' and cuenta='240719001'";
                            //echo $sql."<br>";
							$rs=mysql_query($sql,$linkbd);
							$rw=mysql_fetch_row($rs);
							$dif=round($row[1])-round($rw[4]);
							if($row[2]=='N')
							{
								$stado="color:red";
							}
							if ($dif!=0)
							{
								$estilo='background-color:yellow';
							}
							if($rw[3]=='1')
							{
								$estadoCont = 'P';
							}
							else
							{
								$estadoCont = 'N';
							}
							if ($row[2]!= $estadoCont)
							{
								$estilo='background-color:#9F33FF';
							}
							$sqlr1="SELECT * FROM tipo_comprobante WHERE codigo='5'";
							$res2=mysql_query($sqlr1);
							$row2=mysql_fetch_row($res2);
                            echo"<tr class='$co' ondblclick='direccionaComprobante($row2[5],$row2[3],$ro[0])' style='text-transform:uppercase; $estilo; $stado' >
                                    <td style='width:7%;' id='1'>$row[0]</td>
                                    <td style='width:32%;' id='2'>$row[3]</td>
                                    <td style='text-align:right;width:3%;' id='3'>$".number_format(round($row[1]),2,',','.')."</td>
                                    <td  style='text-align:right;width:4.5%;' id='6'>$".number_format(round($rw[4]),2,',','.')."</td>
                                    <td  style='text-align:right;width:4.5%;' id='7'>$".number_format($dif,2,',','.')."</td>
                                
                                </tr>";
                            
                            $totTesoreria =  $totTesoreria + $row[1];   
                            $totContabilidad =  $totContabilidad + $rw[4];   
                                    
                            $aux=$co;
                            $co=$co2;
                            $co2=$aux;
                            $filas++;
                            $resultadoSuma=0.0;
							
                        } 
                        echo "<tr class='$co'>
                                    <td></td>
                                    <td></td>
                                    <td>$totTesoreria</td>
                                    <td>$totContabilidad</td>
                                    <td></td>
                                </tr>";
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
        					
        					if($(this).attr('id')=='6'){
        					
        						$('#col6').css('width',$(this).css('width'));
        					}
        					if($(this).attr('id')=='7'){
        					
        						$('#col7').css('width',$(this).css('width'));
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