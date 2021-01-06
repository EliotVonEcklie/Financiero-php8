<?php
	header("Cache-control: no-cache, no-store, must-revalidate");
	header("Content-Type: text/html;charset=utf8");
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	date_default_timezone_set("America/Bogota");
	$_POST[oculto2]=$_GET[oculto2];
?>
<script>
	function direccionaCuentaGastos(row)
	{
		var cell = row.getElementsByTagName("td")[1];
		var id = cell.innerHTML;
		var fec=document.form2.fechai.value;
		var fec1=document.form2.fechaf.value;
		if(fec=='')
		{
			alert("Falta digitar las fechas");
		}
		else
		{
			window.open("cont-conciliacion.php?cod="+id+"&fec="+fec+"&fec1="+fec1);
		}
	}
</script>
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
		<script type="text/javascript" src="jquery-1.11.0.min.js"></script>
		<script>
		$(window).load(function () {
			$('#cargando').hide();
		});
		function excell()
		{
			document.form2.action="cont-conciliacionexcel.php";
			document.form2.target="_BLANK";
			document.form2.submit();
			document.form2.action="";
			document.form2.target="";
		}
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<div id="cargando" style=" position:absolute;left: 46%; bottom: 45%">
			<img src="imagenes/loading.gif" style=" width: 80px; height: 80px"/>
		</div>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr>
				<script>barra_imagenes("cont");</script>
				<?php cuadro_titulos();?>
			</tr>
			<tr>
				<?php menu_desplegable("cont");?>
			</tr>
			<tr>
				<td colspan="3" class="cinta">
				<a href="cont-buscaconciliacion.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
				<a class="mgbt"><img src="imagenes/guarda.png"/></a>
				<a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
				<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
				<a href="#" onClick="excell()" class="mgbt"><img src="imagenes/excel.png" title="excel"></a>
				<a href="#" class="mgbt" onClick="mypop=window.open('principal.php','',''); mypop.focus();"><img src="imagenes/nv.png" title="Nueva Ventana"></a> 
				<a href="cont-conciliacion.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a></td>
			</tr>
		</table>
 		<form name="form2" method="post" action=""> 
			<table class='inicio' align='center'>
				<tr>
					<td colspan='8' class='titulos'>.: Buscar Conciliacion</td>
				</tr>
				<tr>
					<td class="saludo1" style="width:3cm;">Fecha Inicial:</td>
					<td style="width:15%;"><input name="fechai" type="text" id="fc_1198971545" title="YYYY-MM-DD" value="<?php echo $_POST[fechai]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)" maxlength="10">&nbsp;<img src="imagenes/calendario04.png" style="width:20px; cursor:pointer;" title="Calendario"  onClick="displayCalendarFor('fc_1198971545');" class="icobut"/></td>
					<td class="saludo1" style="width:3cm;">Fecha Final:</td>
					<td style="width:15%;"><input name="fechaf" type="text" id="fc_1198971546" title="YYYY-MM-DD" value="<?php echo $_POST[fechaf]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)" maxlength="10">&nbsp;<img src="imagenes/calendario04.png" style="width:20px; cursor:pointer;" title="Calendario"  onClick="displayCalendarFor('fc_1198971546');" class="icobut"/></td>
					<td ><img class="icorot" src="imagenes/reload.png" title="Refrescar" onClick="document.form2.submit();"/></td>
				</tr>
			</table>
			<table class='inicio' align='center'>
				<td colspan='6' class='titulos'>.: Resultados Encontrados: <?php
					$sqlr="select count(tesobancosctas.estado) from tesobancosctas,terceros where tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.estado='S' order by tesobancosctas.cuenta";
					$resp=mysql_query($sqlr,$linkbd);
					$row=mysql_fetch_row($resp);
					echo $row[0];
				?></td>
			</table>
			<div class="subpantallac5" style="height:65%; width:99.6%; margin-top:0px; overflow-x:hidden" id="divdet">
				<table class='inicio' align='center'>
					<?php
						$fanio=$_POST[anio];
						//ECHO $_POST[fechai];
						$fecha=$_POST[fechai];
						$ffecha=$_POST[fechaf];
						echo "	<tr class='titulos'>
									<td style='width:1%;'></td>
									<td style='width:10%;'>Cuenta Contable</td>
									<td style='width:10%;'>Cuenta Bancaria</td>
									<td style='width:15%;'>Banco</td>
									<td style='width:10%;'>Saldo Extracto</td>
									<td style='width:10%;'>Saldo Extracto Calc</td>
									<td style='width:10%;'>Diferencia</td>
									<td style='width:10%;'>Saldo Libros</td>
									<td >Estado</td>
								</tr>";
						$sqlr="select tesobancosctas.estado,tesobancosctas.cuenta,tesobancosctas.ncuentaban,tesobancosctas.tipo, terceros.razonsocial,tesobancosctas.tercero from tesobancosctas,terceros where tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.estado='S' order by tesobancosctas.cuenta";
						// $sqlr="SELECT cuenta, sum(valordeb) as total FROM conciliacion group by cuenta";
						$resp=mysql_query($sqlr,$linkbd);
						$iter='saludo1b';
						$iter2='saludo2b';
						$filas=1;
						$cont=0;
						while ($row =mysql_fetch_row($resp)) 
						{
							$cont+=1;
							$sqlr1="select * from conciliacion_cab where cuenta=$row[1] and periodo1='$fecha' and periodo2='$ffecha'";
							//echo $sqlr1."<br>";
							$resp1=mysql_query($sqlr1,$linkbd);
							$row1 =mysql_fetch_row($resp1);
							$val=round($row1[1],2);
							$dif=$val-$row1[2];
							$dif=round($dif,2);
							$dif=abs($dif);
							
							if($dif<=1)
							{
								$dif=0;
							}
							
							$sqlrbook="select  comprobante_det.cuenta,(sum(comprobante_det.valdebito)-sum(comprobante_det.valcredito)) as saldof from comprobante_cab,comprobante_det where comprobante_det.cuenta='$row[1]' and  comprobante_cab.fecha between '' and '$ffecha' and comprobante_det.tipo_comp=comprobante_cab.tipo_comp AND comprobante_det.numerotipo=comprobante_cab.numerotipo and  comprobante_cab.estado='1' group by comprobante_det.cuenta order by comprobante_cab.tipo_comp, comprobante_cab.numerotipo,comprobante_det.id_det,comprobante_cab.fecha";
							$resbook=mysql_query($sqlrbook,$linkbd);
							$saldoperant=0;	
							while ($rowbook =mysql_fetch_row($resbook)){$saldoperant=$rowbook[1];}
							$saldoperant=round($saldoperant,2);
							
							if($dif<1 && $val!=0){
								$sem1="src='imagenes/sema_verdeON.jpg' title='Conciliado'";
								$sem2="src='imagenes/sema_amarilloOFF.jpg' title='En Conciliacion'";
								$sem3="src='imagenes/sema_rojoOFF.jpg' title='Sin Conciliar'";
								$estado="Conciliado";
							}
							if($dif>1){
								$sem1="src='imagenes/sema_verdeOFF.jpg' title='Conciliado'";
								$sem2="src='imagenes/sema_amarilloOFF.jpg' title='En Conciliacion'";
								$sem3="src='imagenes/sema_rojoON.jpg' title='Sin Conciliar'";
								$estado="Sin Conciliar";
							}
							if(($dif>1) and ($dif<10000) ){
								$sem1="src='imagenes/sema_verdeOFF.jpg' title='Conciliado'";
								$sem2="src='imagenes/sema_amarilloON.jpg' title='En Conciliacion'";
								$sem3="src='imagenes/sema_rojoOFF.jpg' title='Sin Conciliar'";
								$estado="Por Conciliar";
							}
							if($row1[2]==''){
								$sem1="src='imagenes/sema_verdeOFF.jpg' title='Conciliado'";
								$sem2="src='imagenes/sema_amarilloOFF.jpg' title='En Conciliacion'";
								$sem3="src='imagenes/sema_rojoON.jpg' title='Sin Conciliar'";
								$estado="Por Conciliar";
								$row1[2]=0;
							}
							if($dif<1 && $val==0 && $row1[2]==0 && $saldoperant==0){
								$sem1="src='imagenes/sema_verdeON.jpg' title='Conciliado'";
								$sem2="src='imagenes/sema_amarilloOFF.jpg' title='En Conciliacion'";
								$sem3="src='imagenes/sema_rojoOFF.jpg' title='Sin Conciliar'";
								$estado="Conciliado";
							}
							echo"<tr class='$iter' style='$stilo; $stado; cursor: hand' text-rendering: optimizeLegibility; ondblclick='direccionaCuentaGastos(this)'>
									<td>$cont</td>
									<td style='width:7%;'>$row[1]</td>
									<td style='width:7%;'>$row[2]</td>
									<td style='width:7%;'>$row[4]</td>
									<td>$val</td>
									<td>$row1[2]</td>
									<td>$dif</td>
									<td>$saldoperant</td>
									<td style='text-align:center; width:5%;'>
										<img $sem1 style='width:20px'/>
										<img $sem2 style='width:20px'/>
										<img $sem3 style='width:20px'/>
									</td>
								</tr>";
								$nomCuenta=buscacuentacont($row[1]);
								echo "
									<input type='hidden' name='cuentaContable[]' id='cuentaContable[]' value='".$row[1]."' />
									<input type='hidden' name='cuentaBancaria[]' id='cuentaBancaria[]' value='".$row[2]."' />
									<input type='hidden' name='nombrebanco[]' id='nombrebanco[]' value='".$row[4]."' />
									<input type='hidden' name='nomCuenta[]' id='nomCuenta[]' value='".$nomCuenta."' />
									<input type='hidden' name='saldoExtracto[]' id='saldoExtracto[]' value='".$val."' />
									<input type='hidden' name='saldoExtractoCalc[]' id='saldoExtractoCalc[]' value='".$row1[2]."' />
									<input type='hidden' name='diferencia[]' id='diferencia[]' value='".$dif."' />
									<input type='hidden' name='saldoLibros[]' id='saldoLibros[]' value='".$saldoperant."' />
									<input type='hidden' name='vestados[]' id='vestados[]' value='".$estado."' />
								";
							$con+=1;
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux;
							$filas++;
						} 
					?>
				</table>
			</div>
		</form> 
	</body>
</html>