<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); 
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
		<style type="text/css"> .fijo {position:fixed !important; right:550px; top:197px; z-index:10 !important} </style>

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
						$iter='saludo1b';
                        $iter2='saludo2b';
						$filas=1;
				?>
			<table width="100%" align="center"  class="inicio" >
                <tr>
                    <td class="titulos" colspan="9">:: Buscar .: Cuentas Por Pagar</td>
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
                                    <td colspan='9' class='titulos'>.: Resultados Busqueda:</td>
                                </tr>
                                <tr>
                                    <td colspan='9'>Egresos Encontrados: Tesoreria: $eet - Presupuesto: $eec</td>
                                </tr>
						<tr class='titulos ' style='text-align:center;'>
								<td ></td>
								<td ></td>
								<td colspan='3' >Tesoreria</td>
								<td colspan='4' >Presupuesto</td>
							</tr>
							<tr class='titulos' style='text-align:center;'>
								<td id='col1'>Id Orden</td>
								<td id='col2'>Concepto</td>
								<td id='col3'>Valor Total</td>
								<td id='col4'>Retenciones</td>
								<td id='col5'>Valor a Pagar</td>
								<td id='col6'>Valor Total </td>
								<td id='col7'>Retenciones</td>
								<td id='col8'>Valor a pagar</td>
								<td id='col9'>Diferencia</td>								
							</tr></table>
</div>";
		?>
					<?php
					 echo "<div class='subpantallac5' style='height:55%; width:99.6%; margin-top:0px; overflow-x:hidden' id='divdet'>
				
				<table class='inicio' id='valores' align='center'>
					<tbody>";	
						$queryDate="";
						$errores=0;
						if(isset($_POST['fechafin']) and isset($_POST['fechaini'])){

							if(!empty($_POST['fechaini']) and !empty($_POST['fechafin'])){
								$fechaInicial=date('Y-m-d',strtotime($_POST['fechaini']));
								$fechaFinal=date('Y-m-d',strtotime($_POST['fechafin']));
								$queryDate="AND T.fecha>='".$fechaInicial."' and T.fecha<='".$fechaFinal."'";
							}
						}
						$sqlr="select T.id_orden, T.conceptorden, T.valorpagar , T.estado, D.id_orden, sum(D.valor),T.valorretenciones,T.id_orden from tesoordenpago T, tesoordenpago_det D where T.id_orden=D.id_orden $queryDate group by T.id_orden"; 	

						$resp=mysql_query($sqlr,$linkbd);
						$arreglo=Array();
                        $resp=mysql_query($sqlr,$linkbd);
                        while ($row =mysql_fetch_row($resp)) 
                        {
							$totalteso=0;
							$totalpresu=0;
							$stado="";
							if($row[3]=='N' || $row[3]=='R'){
								$stado="color:red";
							}
							$sq="SELECT sum(valor) FROM pptoretencionpago WHERE tipo='orden' and idrecibo='$row[0]' and cuenta<>'' ";
							$res=mysql_query($sq,$linkbd);
							$ro=mysql_fetch_row($res);
							
							$totalteso=$row[2]-$row[6];
							$totalpresu=$row[5]-$ro[0];
							$stilo="";
							if(($totalteso!=$totalpresu)){
								$stilo="background-color:yellow";
								$errores+=1;
							}
                            echo"<tr class='$iter' style='$stilo; $stado;' >
	                                <td id='1' style='width:5%;'>$row[0]</td>
	                                <td id='2' style='width:33%;'>$row[1]</td>
									<td id='3' style='text-align:right;width:3%;'>$".number_format($row[2],2,',','.')."</td>
									<td id='6' style='text-align:right;width:5%;'>$".number_format($row[6],2,',','.')."</td>
									<td id='5' style='text-align:right;width:3%;'>$".number_format($totalteso,2,',','.')."</td>
									<td id='7' style='text-align:right;width:5%;'>$".number_format($row[5],2,',','.')."</td>
									<td id='8' style='text-align:right;width:5%;'>$".number_format($ro[0],2,',','.')."</td>
									<td id='9' style='text-align:right;width:5%;'>$".number_format($totalpresu,2,',','.')."</td>
									<td id='9' style='text-align:right;width:5%;'>$".number_format($totalteso-$totalpresu,2,',','.')."</td>
								</tr>";
							$con+=1;
                            $aux=$iter;
                            $iter=$iter2;
                            $iter2=$aux;
							$filas++;
						} 
						echo "<div class='fijo' style='background-color:black; color:yellow; border-radius: 5px; padding: 3px'><center><b>Cuentas por pagar descuadradas : $errores</b> <img src='imagenes/alert.png' ></center> </div>";
						echo "</tbody></table></div>";					
}	
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
        				});
        			}
        		
        	});	
        </script>
</body>
</html>