<?php //V 1001 20/12/16 Modificado implementacion de Reversion?> 
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
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: SPID - Presupuesto</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/calendario.js"></script>
        <script type="text/javascript" src="css/programas.js"></script>
		<script>
			function despliegamodal2(_valor)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else {document.getElementById('ventana2').src="contra-productos-ventana.php";}
			}
 			function despliegamodalm(_valor,_tip,mensa,pregunta,variable)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventanam').src="";}
				else
				{
					switch(_tip)
					{
						case "1":	document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
						case "2":	document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
						case "3":	document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
						case "4":	document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;	
				case "5":
					document.getElementById('ventanam').src="ventana-elimina1.php?titulos="+mensa+"&idresp="+pregunta+"&variable="+variable;break;	
					}
				}
			}
			function respuestaconsulta(pregunta, variable)
			{
				switch(pregunta)
				{
					case "1":	document.getElementById('oculto').value="2";
								document.form2.submit();break;
					case "2":
						document.form2.elimina.value=variable;
						//eli=document.getElementById(elimina);
						vvend=document.getElementById('elimina');
						//eli.value=elimina;
						vvend.value=variable;
						document.form2.submit();
						break;
				}
			}
			function funcionmensaje(){}
			function pdf()
			{
				document.form2.action="pdfauxiliargaspresgastos.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function buscacta(e)
			{
				if (document.form2.cuenta.value!="")
				{
					document.form2.bc.value=2;
					document.form2.submit();
				}
			}
			function excell()
			{
				document.form2.action="presu-auxiliarcuenta2excelgastos.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function validar()
			{
				document.getElementById('oculto').value='2';
				document.form2.submit(); 
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
					<a href="#" class="mgbt" onClick="document.form2.submit();"><img src="imagenes/guarda.png" title="Guardar" /></a> 
					<a href="#" onClick="document.form2.submit()" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a> 
					<a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a> 
					<a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png" title="imprimir"></a>  
					<a href="#"   onClick="excell()" ritle><img src="imagenes/excel.png" title="excel"></a> 
					<a href="presu-ejecucionpresupuestal.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
				</td>
			</tr>
		</table>
		<div id="bgventanamodalm" class="bgventanamodalm">
			<div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>	  
		<form name="form2" method="post" action="presu-auxiliarcuentagastos1.php">
			<?php
			$linkbd=conectar_bd();
			$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
			$_POST[vigencia]=$vigusu;
			if($_POST[bc]!='')
			{
				$nresul=buscacuentapres($_POST[cuenta],2);			
				if($nresul!='')
				{
					$_POST[ncuenta]=$nresul;
					$sqlr="select vigencia, vigenciaf from pptocuentaspptoinicial where cuenta='$_POST[cuenta]' and (vigencia=".$vigusu." or vigenciaf='$vigusu')";
					$res=mysql_query($sqlr,$linkbd);
					$row=mysql_fetch_row($res);
					$_POST[valor]=$row[0];		  
					$_POST[valor2]=$row[1];		  			  
				}
				else
				{
					$_POST[ncuenta]="";	
				}
			}
			?>
			<table  align="center" class="inicio" >
				<tr >
					<td class="titulos" colspan="8">.: Auxilar por Cuenta de Gastos</td>
					<td width="" class="cerrar"><a href="presu-principal.php">Cerrar</a></td>
				</tr>
				<tr  >
					<td  class="saludo1">Cuenta:          </td>
					<td  valign="middle" ><input type="text" id="cuenta" name="cuenta" size="12" onKeyPress="javascript:return solonumeros(event)" 
						onKeyUp="return tabular(event,this)" onBlur="buscacta(event)" value="<?php echo $_POST[cuenta]?>" onClick="document.getElementById('cuenta').focus();document.getElementById('cuenta').select();"><input type="hidden" value="0" name="bc"><a href="#" onClick="mypop=window.open('cuentasppto-ventana.php?ti=2','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>  </td><td width="367"><input name="ncuenta" type="text" value="<?php echo $_POST[ncuenta]?>" size="60" readonly> <input name="oculto" type="hidden" value="1"> <input name="valor" type="hidden" value="<?php echo $_POST[valor]?>"  readonly><input name="valor2" type="hidden" value="<?php echo $_POST[valor2]?>"  readonly>
					</td>    
					<td  class="saludo1">Fecha Inicial:</td>
					<td ><input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return 	tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">         <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/calendario04.png"style="width:20px" align="absmiddle" border="0"></a>        
					</td>
					<td class="saludo1">Fecha Final: </td>
					<td ><input name="fecha2" type="text" id="fc_1198971546" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha2]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">         <a href="#" onClick="displayCalendarFor('fc_1198971546');"><img src="imagenes/calendario04.png" align="absmiddle" border="0" style="width:20px"></a>       <input type="button" name="generar" value="Generar" onClick="validar()"> <input type="hidden" value="1" name="oculto" id="oculto"> 
					</td>
				</tr>      
			</table>
			<?php
		if($_POST[oculto]==2){
			ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha1);
			$fechaf=$fecha1[3]."-".$fecha1[2]."-".$fecha1[1];
			ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha2);
			$fechaf2=$fecha2[3]."-".$fecha2[2]."-".$fecha2[1];	
			$sql="SELECT cuenta, regalias FROM pptocuentas WHERE cuenta='$_POST[cuenta]'";
			$result=mysql_query($sql, $linkbd);
			if(mysql_num_rows($result)!=0){
				$rwp=mysql_fetch_array($result);
				if($rwp[1]!='S'){
					if($fecha1[3]==$fecha2[3]){
						$correcto=1;
						$sqlv="SELECT vigencia, vigenciaf FROM pptocuentas WHERE vigencia='$fecha1[3]' AND regalias='S'";
						$resv=mysql_query($sqlv,$linkbd);
						if(mysql_num_rows($resv)!=0){
							$todos=1;
						}
						else{
							$todos=0;
						}
					}
					else{
						$correcto=0;
						echo "<script>despliegamodalm('visible','1','Esta Cuenta SOLO Aplica para Una Vigencia');</script>";				
					}
				}
				elseif($rwp[1]=='S'){
					if($fecha1[3]==$fecha2[3]){
						$correcto=1;
						$sqlv="SELECT vigencia, vigenciaf FROM pptocuentas WHERE vigencia='$fecha1[3]' AND regalias='S'";
						$resv=mysql_query($sqlv,$linkbd);
						if(mysql_num_rows($resv)!=0){
							$todos=1;
						}
						else{
							$todos=0;
						}
					}
					else{
						$numvig=$fecha2[3]-$fecha1[3];
						if(($numvig>0)&&($numvig<3)){
							$vigenciarg=$fecha1[3].' - '.$fecha2[3];
							$sqlv2="SELECT * FROM pptocuentas WHERE vigenciarg='$vigenciarg'";
							$resv2=mysql_query($sqlv2,$linkbd);
							if(mysql_num_rows($resv2)!=0){
								$correcto=1;
								if($numvig>0){
									$todos=1;
								}
								else{
									$sqlv="SELECT vigencia, vigenciaf FROM pptocuentas WHERE vigencia='$fecha1[3]' AND regalias='S'";
									$resv=mysql_query($sqlv,$linkbd);
									if(mysql_num_rows($resv)!=0){
										$todos=1;
									}
									else{
										$todos=0;
									}
								}
							}
							else{
								$correcto=0;
								echo "<script>despliegamodalm('visible','1','Su Busqueda NO corresponde a una Vigencia del SGR');</script>";			
							}
						}
						else{
							$correcto=0;
							echo "<script>despliegamodalm('visible','1','La Vigencia para SGR se puede Consultar Maximo por 2 Años');</script>";
						}
					}
				}
			}
			else{
				echo "<script>despliegamodalm('visible','1','Cuenta Incorrecta');</script>";				
			}
		}
		//fin validacion
			//**** busca cuenta
			if($_POST[bc]!='')
			{
				$nresul=buscacuentapres($_POST[cuenta],2);
				if($nresul!='')
				{
					$_POST[ncuenta]=$nresul;
					$sqlr="select vigencia, vigenciaf from pptocuentas where cuenta='$_POST[cuenta]' and (vigencia=".$vigusu." or vigenciaf='$vigusu')";
					$res=mysql_query($sqlr,$linkbd);
					$row=mysql_fetch_row($res);
					//echo $sqlr;
					$_POST[valor]=$row[0];		  
					$_POST[valor2]=$row[1];			  			  
					?>
					<script>
						document.form2.fecha.focus();
						document.form2.fecha.select();
					</script>
					<?php
				}
				else
				{
					$_POST[ncuenta]="";
					?>
					<script>despliegamodalm('visible','1','Cuenta Incorrecta');</script>
					<?php
				}
			}
			?>
			<div class="subpantallap" style="height:67%; width:99.6%; overflow-x:hidden;">
				<?php
				//**** para sacar la consulta del balance se necesitan estos datos ********
				//**** nivel, mes inicial, mes final, cuenta inicial, cuenta final, cc inicial, cc final  
				$oculto=$_POST['oculto'];
					if($correcto==1){
						$numCuenta="";
						$vigencia="";
						$presuDefinitivo=0.0;
						if(isset($_POST[cuenta]))
							$numCuenta=$_POST[cuenta];
						if(isset($_POST[valor]))
							$vigencia=$_POST[valor];
						$queryPresupuesto="SELECT pptoinicial FROM pptocuentas WHERE cuenta=$numCuenta AND vigencia=$vigencia";
						$result=mysql_query($queryPresupuesto, $linkbd);
						while($row=mysql_fetch_array($result)){
							echo "Presupuesto Inicial: ";
							echo "<br>Entrada: ".number_format($row[0]);
							$presuDefinitivo+=$row[0];
						}
						$querySalidaPresuDefi="SELECT SUM(D.valor) FROM pptocdp C, pptocdp_detalle D WHERE D.cuenta=$numCuenta AND D.vigencia=$vigencia AND D.tipo_mov='201' AND D.consvigencia=C.consvigencia AND C.tipo_mov='201' AND C.vigencia=$vigencia AND NOT(D.estado='N' OR D.estado='R') AND C.fecha BETWEEN '$fechaf' AND '$fechaf2' GROUP BY D.cuenta";
						$valCDP=0.0;
						$result=mysql_query($querySalidaPresuDefi, $linkbd);
						if(mysql_num_rows($result)==0)
							echo "<b>Dicho rubro no tiene salidas</b>";
						else{
							while($row=mysql_fetch_array($result)){
						echo "<br>Salida: ".number_format($row[0])."<br>";
						$valCDP=$row[0];
						    }
						}

						echo "<br> Adiciones<br>";
						$queryAdiciones="SELECT SUM(valor) FROM pptoadiciones WHERE cuenta=$numCuenta AND vigencia=$vigencia AND fecha BETWEEN '$fechaf' AND '$fechaf2' GROUP BY cuenta";
						$result=mysql_query($queryAdiciones, $linkbd);
						if(mysql_num_rows($result)==0)
							echo "<b>Dicho rubro no tiene adiciones</b>";
						else{
							while($row=mysql_fetch_array($result)){
							echo "<b>Adiciones:</b> ".$row[0];
							$presuDefinitivo+=$row[0];
						}
						}
						echo "<br> Reducciones <br>";
						$queryReducciones="SELECT SUM(valor) FROM pptoreducciones WHERE cuenta=$numCuenta AND vigencia=$vigencia AND fecha BETWEEN '$fechaf' AND '$fechaf2' GROUP BY cuenta";
						$result=mysql_query($queryReducciones, $linkbd);
						if(mysql_num_rows($result)==0)
							echo "<b>Dicho rubro no tiene reducciones</b>";
						else{
							while($row=mysql_fetch_array($result)){
							echo "<b>Reducciones:</b> ".$row[0];
							$presuDefinitivo-=$row[0];
						}
						}
						echo "<br> Traslados <br>";
						$queryTraslados="SELECT id_traslados,tipo,valor FROM pptotraslados WHERE cuenta=$numCuenta AND vigencia=$vigencia AND fecha BETWEEN '$fechaf' AND '$fechaf2' GROUP BY cuenta";
						$presuSalida=0.0;
						$result=mysql_query($queryTraslados, $linkbd);
						if(mysql_num_rows($result)==0)
							echo "<b>Dicho rubro no tiene traslados</b>";
						else{
							while($row=mysql_fetch_array($result)){
							echo "<b>Traslado No $row[0]</b> ";
							echo "<b>Valor $row[2]</b> ";
							if($row[1]=='R')
								$presuSalida+=$row[2];
							else
								$presuDefinitivo+=$row[2];
						}
						}
						//echo $queryTraslados;
						echo "<br> PRESUPUESTO DEFINITIVO: <br>";
						echo "Entrada: ".number_format($presuDefinitivo)."<br>";
					
						echo "Salida: ".number_format($valCDP+$presuSalida)."<br>";
						$presuDefinitivoSalida=$valCDP+$presuSalida;
						echo "<br> CDP o DISPONIBILIDAD <br>";
						$totalCDPEnt=0;
						$totalCDPSal=0;
						$queryTraslados="SELECT C.consvigencia,C.fecha,C.objeto,C.tipo_mov,D.valor,(SELECT SUM(RD.valor) FROM pptorp R,pptorp_detalle RD where R.idcdp=C.consvigencia AND R.vigencia=$vigencia AND R.tipo_mov='201' AND RD.cuenta=$numCuenta AND RD.consvigencia=R.consvigencia AND RD.tipo_mov='201' AND RD.vigencia=$vigencia AND  NOT(R.estado='N' OR R.estado='R') AND R.fecha BETWEEN '$fechaf' AND '$fechaf2') FROM pptocdp C, pptocdp_detalle D WHERE D.cuenta=$numCuenta AND D.vigencia=$vigencia AND D.tipo_mov='201' AND D.consvigencia=C.consvigencia AND C.tipo_mov='201' AND C.vigencia=$vigencia AND NOT(D.estado='N' OR D.estado='R') AND D.valor>0 AND C.fecha BETWEEN '$fechaf' AND '$fechaf2' ORDER BY C.consvigencia";
						$result=mysql_query($queryTraslados, $linkbd);
						if(mysql_num_rows($result)==0)
							echo "<b>Dicho rubro no CDPs</b>";
						else{
							while($row=mysql_fetch_array($result)){
							echo "CDP No. <b>$row[0]</b> <br>";
							echo "Fecha $row[1] <br>";
							echo "Detalle $row[2] <br>";
							echo "Movimiento $row[3] <br>";
							echo "Entrada    ".number_format($row[4])." <br>";
							echo "Salida    ".number_format($row[5])." <br>";
							echo "Saldo ".generaSaldo($row[0],'1',$row[4],$row[5],$vigencia,$numCuenta,$fechaf,$fechaf2)."<br>";
							$totalCDPEnt+=$row[4];
							$totalCDPSal+=$row[5];
						}
						}
						//echo $queryTraslados;
						echo "----------------------->";
						echo "Subtotal en entrada CDP: ".number_format($totalCDPEnt);
						echo "--Subtotal en salida CDP: ".number_format($totalCDPSal);
						echo "<br> RP o Registro Presupuestal <br>";
						$totalRPEnt=0;
						$totalRPSal=0;
						$arregloRP=Array();
						$i=0;
						$queryTraslados="SELECT R.consvigencia,R.fecha,R.tipo_mov,RD.valor,(SELECT SUM(TD.valor) FROM tesoordenpago T,tesoordenpago_det TD WHERE T.id_rp=R.consvigencia AND T.vigencia=$vigencia AND T.tipo_mov='201' AND T.id_orden=TD.id_orden AND TD.tipo_mov='201' AND NOT(T.estado='N' OR T.estado='R') AND TD.cuentap=$numCuenta AND T.fecha BETWEEN '$fechaf' AND '$fechaf2'),(SELECT SUM(HNP.valor) FROM hum_nom_cdp_rp HNR,humnom_presupuestal HNP WHERE HNR.rp=R.consvigencia AND HNR.nomina=HNP.id_nom AND HNP.cuenta=$numCuenta AND HNR.vigencia=$vigencia AND HNP.estado='P' AND NOT(HNR.estado='N' OR HNR.estado='R')) FROM pptorp R,pptorp_detalle RD where  R.vigencia=$vigencia AND R.tipo_mov='201' AND RD.cuenta=$numCuenta AND RD.consvigencia=R.consvigencia AND RD.tipo_mov='201' AND RD.vigencia=$vigencia  AND NOT(R.estado='N' OR R.estado='R') AND RD.valor>0 AND R.fecha BETWEEN '$fechaf' AND '$fechaf2'";
						$result=mysql_query($queryTraslados, $linkbd);
						if(mysql_num_rows($result)==0)
							echo "<b>Dicho rubro no tiene RPs</b>";
						else{
							while($row=mysql_fetch_array($result)){
							echo "RP No. <b>$row[0]</b> <br>";
							$arregloRP[$i]=$row[0];
							echo "Fecha $row[1] <br>";
							echo "Detalle <br>";
							echo "Movimiento $row[2] <br>";
							echo "Entrada    ".number_format($row[3])." <br>";
							echo "Salida    ".number_format($row[4]+$row[5])." <br>";
							echo "Saldo ".generaSaldo($row[0],'2',$row[3],$row[4]+$row[5],$vigencia,$numCuenta)."<br>";
							$totalRPEnt+=$row[3];
							$totalRPSal+=($row[4]+$row[5]);
							$i++;
						}
						}
						//echo $queryTraslados;
						echo "----------------------->";
						echo "Subtotal en entrada RP: ".number_format($totalRPEnt);
						echo "--Subtotal en salida RP: ".number_format($totalRPSal);

						echo "<br> CxP o Cuentas por pagar <br>";
						$totalCxPEnt=0.0;
						$totalCxPSal=0.0;
						$queryTraslados="SELECT T.id_orden,T.fecha,T.tipo_mov,TD.valor,T.estado FROM tesoordenpago T,tesoordenpago_det TD WHERE T.vigencia=$vigencia AND T.tipo_mov='201' AND T.id_orden=TD.id_orden AND TD.tipo_mov='201' AND NOT(T.estado='N' OR T.estado='R') AND TD.valor>0 AND TD.cuentap=$numCuenta AND T.fecha BETWEEN '$fechaf' AND '$fechaf2'";
						$result=mysql_query($queryTraslados, $linkbd);
						if(mysql_num_rows($result)==0)
							echo "<b>Dicho rubro no CxP</b>";
						else{
							$salida=0.0;
							while($row=mysql_fetch_array($result)){
							echo "CxP No. <b>$row[0]</b> <br>";
							echo "Fecha $row[1] <br>";
							echo "Detalle CUENTA POR PAGAR<br>";
							echo "Movimiento $row[2] <br>";
							echo "Entrada    ".number_format($row[3])." <br>";
							if($row[4]=='P'){

								echo "Salida    ".number_format($row[3])." <br>";
								$salida=$row[3];
								$totalCxPSal+=$row[3];
								echo "Saldo ".generaSaldo($row[0],'31',$row[3],$salida,$vigencia,$numCuenta)."<br>";

							}
							else{

								echo "Salida    0 <br>";
								echo "Saldo ".number_format($row[3])."<br>";
								$salida=0.0;
							}

							$totalCxPEnt+=$row[3];
							
						}
						}



				for ($i=0; $i <sizeof($arregloRP); $i++) { 
							$queryTraslados="SELECT TEN.id_orden,TEN.concepto,HNP.valor,TEN.id_egreso,TEN.fecha FROM hum_nom_cdp_rp HNR,humnom_presupuestal HNP,tesoegresosnomina TEN WHERE HNR.rp=$arregloRP[$i] AND HNR.nomina=HNP.id_nom AND HNP.cuenta=$numCuenta AND HNR.vigencia=$vigencia AND HNP.estado='P' AND NOT(HNR.estado='N' OR HNR.estado='R') AND TEN.id_orden=HNP.id_nom AND TEN.vigencia=$vigencia AND NOT(TEN.estado='N' OR TEN.estado='R') AND HNP.valor>0 AND TEN.fecha BETWEEN '$fechaf' AND '$fechaf2' GROUP BY TEN.id_orden";
							$result=mysql_query($queryTraslados, $linkbd);
						if(mysql_num_rows($result)==0)
							echo "";
						else{
							while($row=mysql_fetch_array($result)){
							$arregloEgresosNom[]=@Array("id" => "$row[3]",
														"concepto" => "Egreso de nomina",
														"valor" => "$row[2]",
														"fecha" => "$row[4]");

							echo "CxP No. <b>$row[0]</b> <br>";
							echo "Fecha  <br>";
							echo "Detalle $row[1]<br>";
							echo "Movimiento 201 <br>";
							echo "Entrada    ".number_format($row[2])." <br>";
							echo "Salida    ".number_format($row[2])." <br>";
							echo "Saldo ".generaSaldo($row[0],'32',$row[2],$row[2],$vigencia,$numCuenta)."<br>";
							$totalCxPEnt+=$row[2];
							$totalCxPSal+=$row[2];
							break;

						}
						}

						}

						echo "----------------------->";
						echo "Subtotal en entrada CxP: ".number_format($totalCxPEnt);
						echo "--Subtotal en salida CxP: ".number_format($totalCxPSal);

						echo "<br> Egresos <br>";
						$totalEgresoEnt=0.0;
						$totalEgresoSal=0.0;
						$queryTraslados="SELECT TE.id_egreso,TE.fecha,TE.tipo_mov,TD.valor FROM tesoegresos TE,tesoordenpago_det TD where TE.vigencia=$vigencia AND TE.tipo_mov='201' AND TD.cuentap=$numCuenta AND TE.id_orden=TD.id_orden AND  NOT(TE.estado='N' OR TE.estado='R') AND TD.valor >0 AND TE.fecha BETWEEN '$fechaf' AND '$fechaf2'";
						$result=mysql_query($queryTraslados, $linkbd);
						if(mysql_num_rows($result)==0)
							echo "<b>Dicho rubro no CxP</b>";
						else{
							while($row=mysql_fetch_array($result)){
							echo "EGRESO No. <b>$row[0]</b> <br>";
							echo "Fecha $row[1] <br>";
							echo "Detalle EGRESO<br>";
							echo "Movimiento $row[2] <br>";
							echo "Entrada    ".number_format($row[3])." <br>";
							echo "Salida    0<br>";
							echo "Saldo    ".number_format($row[3])." <br>";
							$totalEgresoEnt+=$row[3];

						}
						}

						for($i=0;$i<sizeof($arregloEgresosNom);$i++){
							$numEgreso=$arregloEgresosNom[$i]['id'];
							$fecha=$arregloEgresosNom[$i]['fecha'];
							$concepto=$arregloEgresosNom[$i]['concepto'];
							$valor=$arregloEgresosNom[$i]['valor'];
							echo "EGRESO No. <b>$numEgreso</b> <br>";
							echo "Fecha $fecha <br>";
							echo "Detalle $concepto<br>";
							echo "Movimiento 201 <br>";
							echo "Entrada    ".number_format($valor)." <br>";
							echo "Salida    0<br>";
							echo "Saldo    ".number_format($valor)." <br>";
							$totalEgresoEnt+=$valor;
						}
						echo "----------------------->";
						echo "Subtotal en entrada EGRESOS: ".number_format($totalEgresoEnt);
						echo "--Subtotal en salida EGRESOS: ".number_format($totalEgresoSal);
						echo "<br>";
						echo "Saldo disponible: ".number_format($presuDefinitivo-$presuDefinitivoSalida);
					}

					function generaSaldo($id_compro,$opc,$entact,$entsig,$vigencia,$numCuenta,$fechaf,$fechaf2){
						switch ($opc) {
							case '1':
								$querySaldo="SELECT SUM(RD.valor) FROM pptorp R,pptorp_detalle RD where R.idcdp=$id_compro AND R.vigencia=$vigencia AND (R.tipo_mov='401' OR R.tipo_mov='402') AND RD.cuenta=$numCuenta AND RD.consvigencia=R.consvigencia AND (RD.tipo_mov='401' OR RD.tipo_mov='402') AND RD.vigencia=$vigencia AND R.fecha BETWEEN '$fechaf' AND '$fechaf2'";
								$result=mysql_query($querySaldo,$linkbd);
								$valorReversado=mysql_fetch_array($result);
								$saldo=$entact-$entsig+$valorReversado[0];
								return $saldo;
								break;
							case '2':
								$querySaldo="SELECT SUM(TD.valor) FROM tesoordenpago T,tesoordenpago_det TD WHERE T.id_rp=$id_compro AND T.vigencia=$vigencia AND (T.tipo_mov='401' OR T.tipo_mov='402') AND T.id_orden=TD.id_orden AND (TD.tipo_mov='401' OR TD.tipo_mov='402') AND TD.cuentap=$numCuenta AND T.fecha BETWEEN '$fechaf' AND '$fechaf2' ";
								$result=mysql_query($querySaldo,$linkbd);
								$valorReversado1=mysql_fetch_array($result);

								$querySaldo="SELECT SUM(HNP.valor) FROM hum_nom_cdp_rp HNR,humnom_presupuestal HNP WHERE HNR.rp=$id_compro AND HNR.nomina=HNP.id_nom AND HNP.cuenta=$numCuenta AND HNR.vigencia=$vigencia AND HNP.estado='P' AND HNR.estado='R'";
								$result=mysql_query($querySaldo,$linkbd);
								$valorReversado2=mysql_fetch_array($result);

								$saldo=$entact-$entsig+($valorReversado1[0]+$valorReversado2[0]);
								return $saldo;
								break;
							case '31':
								$querySaldo="SELECT 1 FROM tesoegresos TE,tesoordenpago_det TD where TE.vigencia=$vigencia AND (TE.tipo_mov='401' OR TE.tipo_mov='402') AND TD.cuentap=$numCuenta AND TE.id_orden=$id_compro AND TE.id_orden=TD.id_orden AND TE.fecha BETWEEN '$fechaf' AND '$fechaf2'";
								$result=mysql_result($querySaldo, $linkbd);
								$numRegistros=mysql_num_rows($result);
								if($numRegistros>0){
									$saldo=$entact-$entsig+$entsig;
								}else{
									$saldo=$entact-$entsig;
								}
								return $saldo;
							break;
							case '32':
								$querySaldo="SELECT 1 FROM tesoegresosnomina TE WHERE TE.id_orden=$id_compro AND TE.estado='R' AND TE.vigencia=$vigencia";
								$result=mysql_result($querySaldo, $linkbd);
								$numRegistros=mysql_num_rows($result);
								if($numRegistros>0){
									$saldo=$entact-$entsig+$entsig;
								}else{
									$saldo=$entact-$entsig;
								}
								return $saldo;
							break;
							default:
								echo '0.0';
								break;
						}
					}
				
				?> 
			</div>
		</form>
</body>
</html>