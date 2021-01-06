<?php //V 1001 20/12/16 Modificado implementacion de Reversion?> 
<?php //V 1000 12/12/16 ?> 
<?php
	error_reporting(0);
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
        <script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
		<script>
		function direccionaDocumento(row){
			var cell = row.getElementsByTagName("td")[1];
			var id = cell.innerHTML;
			alert(id);
			//window.location = "presu-auxiliarcuentagastos2.php";
		}
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
		<form name="form2" method="post" action="presu-auxiliarcuentagastos2.php">
			<?php
			$linkbd=conectar_bd();
			$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
			$_POST[vigencia]=$vigusu;
			if(isset($_GET['cod'])){
				if(!empty($_GET['cod'])){
					$_POST[cuenta]=$_GET['cod'];
					$_POST[ncuenta]=buscacuentapres($_POST[cuenta],2);
					$_POST[fecha]="01/01/".$vigusu;
					$_POST[fecha2]="31/12/".$vigusu;
				}
			}
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
						$iter='zebra1';
						$iter1='zebra2';
				echo "<div class='subpanta' style='width:100%; margin-top:0px; overflow-x:hidden;overflow-y:scroll' id='divdet'>
			<table class='inicio' align='center'>
						<tr><td colspan='8' class='titulos'>Auxiliar por Cuenta</td></tr>
				<tr class='titulos' style='text-align:center;'>
								<td class='titulos2' id='col1'>TIPO COMPROBANTE</td>
								<td class='titulos2' id='col2'>No Comp</td>
								<td style=' width:6%; ' class='titulos2' id='col3'>FECHA</td>
								<td class='titulos2' id='col4'>DETALLE</td>
								<td class='titulos2' id='col5'>TIPO MOV</td>
								<td class='titulos2' id='col6'>ENTRADAS</td>
								<td class='titulos2' id='col7'>SALIDAS</td>
								<td class='titulos2' id='col8'>SALDO</td>
							</tr></table>
						</div>";
			echo "<div class='subpantallac5' style='height:55%; width:99.6%; margin-top:0px; overflow-x:hidden' id='divdet'>
				<table class='inicio' align='center' id='valores' ><tbody>";
			$queryPresupuesto="SELECT valor,vigencia FROM pptocuentaspptoinicial WHERE cuenta='$numCuenta' AND vigencia=$vigencia";
			$result=mysql_query($queryPresupuesto, $linkbd);
			echo "<tr class='$iter'>";
			echo "<td id='1'>Apropiacion Inicial</td>";
						while($row=mysql_fetch_array($result)){
			echo "<td id='2'>$row[1]</td>";
			echo "<td id='3'>$row[1]-01-01</td>";
			echo "<td id='4'>PPTO INICIAL</td>";
			echo "<td id='5'>201</td>";
			echo "<td id='6' style='text-align:right'>$".number_format($row[0],2,',','.')."</td>";
							$presuDefinitivo+=$row[0];
						}
						$querySalidaPresuDefi="SELECT SUM(D.valor) FROM pptocdp C, pptocdp_detalle D WHERE D.cuenta='$numCuenta' AND D.vigencia=$vigencia AND D.tipo_mov='201' AND D.consvigencia=C.consvigencia AND C.tipo_mov='201' AND C.vigencia=$vigencia AND NOT(D.estado='N' OR D.estado='R') AND C.fecha BETWEEN '$fechaf' AND '$fechaf2' GROUP BY D.cuenta";
						$valCDP=0.0;
						$result=mysql_query($querySalidaPresuDefi, $linkbd);
						if(mysql_num_rows($result)==0){

							echo "<td id='7' style='text-align:right'>$".number_format('0',2,',','.')."</td>";
							echo "<td id='8' style='text-align:right'>$".number_format($presuDefinitivo,2,',','.')."</td>";
						}
						else{
							while($row=mysql_fetch_array($result)){
						echo "<td id='7' style='text-align:right'>$".number_format($row[0],2,',','.')."</td>";
						echo "<td id='8' style='text-align:right'>$".number_format($presuDefinitivo-$row[0],2,',','.')."</td>";
						$valCDP=$row[0];
						    }
						}
			echo "</tr>";
			echo "<tr class='saludo1'>";
				echo "<td colspan='3'></td><td><b>Subtotal Apropiacion Inicial</b></td><td></td><td style='text-align:right'>$".number_format($presuDefinitivo,2,',','.')."</td><td style='text-align:right'>$".number_format($valCDP,2,',','.')."</td><td style='text-align:right'>$".number_format($presuDefinitivo-$valCDP,2,',','.')."</td>";
			echo "</tr>";


			

						$queryAdiciones="SELECT SUM(pad.valor),pad.id_adicion,pa.fecha FROM pptoadiciones pad,pptoacuerdos pa WHERE pad.cuenta='$numCuenta' AND pad.vigencia=$vigencia AND pa.id_acuerdo=pad.id_acuerdo AND pad.id_acuerdo>0 AND  pa.fecha BETWEEN '$fechaf' AND '$fechaf2' GROUP BY cuenta";
						$result=mysql_query($queryAdiciones, $linkbd);
						$totentAdicion=0.0;
						$totsalAdicion=0.0;
						if(mysql_num_rows($result)==0){

							//echo "<b>Dicho rubro no tiene adiciones</b>";
						}
						else{
							while($row=mysql_fetch_array($result)){
								echo "<tr class='zebra2'>";
						     echo "<td>Adicion</td>";
						     echo "<td>$row[1]</td>";
						     echo "<td>$row[2]</td>";
						     echo "<td>ADICION PPTAL</td>";
						     echo "<td>201</td>";
						     echo "<td style='text-align:right'>$".number_format($row[0],2,',','.')."</td>";
						     echo "<td style='text-align:right'>$".number_format('0',2,',','.')."</td>";
						     echo "<td style='text-align:right'>$".number_format($row[0],2,',','.')."</td>";
						     	echo "</tr>";
							$presuDefinitivo+=$row[0];
							$totentAdicion+=$row[0];
							$totsalAdicion+=0.0;
						}
						}

		
			echo "<tr class='saludo1'>";
				echo "<td colspan='3'></td><td><b>Subtotal Adiciones</b></td><td></td><td style='text-align:right'>$".number_format($totentAdicion,2,',','.')."</td><td style='text-align:right'>$".number_format($totsalAdicion,2,',','.')."</td><td style='text-align:right'>$".number_format($totentAdicion-$totsalAdicion,2,',','.')."</td>";
			echo "</tr>";

			

						$queryReducciones="SELECT SUM(pr.valor),pr.id_reduccion,pa.fecha FROM pptoreducciones pr,pptoacuerdos pa WHERE pr.cuenta='$numCuenta' AND pr.vigencia=$vigencia AND pr.id_acuerdo=pa.id_acuerdo AND pr.id_acuerdo>0 AND pa.fecha BETWEEN '$fechaf' AND '$fechaf2' GROUP BY pr.cuenta";
						
						$result=mysql_query($queryReducciones, $linkbd);
						$totentReduccion=0.0;
						$totsalReduccion=0.0;
						if(mysql_num_rows($result)==0){

							//echo "<b>Dicho rubro no tiene adiciones</b>";
						}
						else{
							while($row=mysql_fetch_array($result)){
							echo "<tr class='zebra2'>";
						     echo "<td>Reduccion</td>";
						     echo "<td>$row[1]</td>";
						     echo "<td>$row[2]</td>";
						     echo "<td>REDUCCION PPTAL</td>";
						     echo "<td>201</td>";
						     echo "<td style='text-align:right'>$".number_format($row[0],2,',','.')."</td>";
						     echo "<td style='text-align:right'>$".number_format('0',2,',','.')."</td>";
						     echo "<td style='text-align:right'>$".number_format($row[0],2,',','.')."</td>";
						     echo "</tr>";
							$presuDefinitivo-=$row[0];
							$totentReduccion+=$row[0];
							$totsalReduccion+=0.0;
						}
						}

			
			echo "<tr class='saludo1'>";
				echo "<td colspan='3'></td><td><b>Subtotal Reducciones</b></td><td></td><td style='text-align:right'>$".number_format($totentReduccion,2,',','.')."</td><td style='text-align:right'>$".number_format($totsalReduccion,2,',','.')."</td><td style='text-align:right'>$".number_format($totentReduccion-$$totsalReduccion,2,',','.')."</td>";
			echo "</tr>";

						$queryTraslados="SELECT pt.id_acuerdo,pt.tipo,SUM(pt.valor),pa.fecha FROM pptotraslados pt,pptoacuerdos pa WHERE pt.cuenta='$numCuenta' AND pt.vigencia=$vigencia AND pt.id_acuerdo>0 AND  pt.id_acuerdo=pa.id_acuerdo AND pa.fecha BETWEEN '$fechaf' AND '$fechaf2' GROUP BY pt.id_acuerdo";
						$presuSalida=0.0;
						$totentTraslado=0.0;
						$totsalTraslado=0.0;
						$result=mysql_query($queryTraslados, $linkbd);
						if(mysql_num_rows($result)==0)
						{
							//echo "<b>Dicho rubro no tiene traslados</b>";
						}
						else{
							while($row=mysql_fetch_array($result)){
							echo "<tr class='zebra2'>";
							echo "<td>Traslado</td>";
							echo "<td>".$row[0]."</td>";
							echo "<td>$row[3]</td>";
							echo "<td>TRASLADO PPTAL</td>";
							echo "<td>201</td>";
							if($row[1]=='R'){
							$presuSalida+=$row[2];
							$presuDefinitivo-=$row[2];
							echo "<td style='text-align:right'>$".number_format('0',2,',','.')."</td>";
							echo "<td style='text-align:right'>$".number_format($row[2],2,',','.')."</td>";
							echo "<td style='text-align:right'>$".number_format(0-$row[2],2,',','.')."</td>";
							$totsalTraslado+=$row[2];
							}
							else{
							$presuDefinitivo+=$row[2];
							echo "<td style='text-align:right'>$".number_format($row[2],2,',','.')."</td>";
							echo "<td style='text-align:right'>$".number_format('0',2,',','.')."</td>";
							echo "<td style='text-align:right'>$".number_format($row[2],2,',','.')."</td>";
							$totentTraslado+=$row[2];
							}
						echo "</tr>";
						}
						}
			echo "<tr class='saludo1'>";
				echo "<td colspan='3'></td><td><b>Subtotal Traslados</b></td><td></td><td style='text-align:right'>$".number_format($totentTraslado,2,',','.')."</td><td style='text-align:right'>$".number_format($totsalTraslado,2,',','.')."</td><td style='text-align:right'>$".number_format($totentTraslado-$totsalTraslado,2,',','.')."</td>";
			echo "</tr>";


						$presuDefinitivoSalida=$valCDP+$presuSalida;

				echo "<tr class='saludo1'>";
				echo "<td colspan='3'></td><td><b>PRESUPUESTO DEFINITIVO</b></td><td></td><td style='text-align:right'>$".number_format($presuDefinitivo,2,',','.')."</td><td style='text-align:right'>$".number_format($presuDefinitivoSalida,2,',','.')."</td><td style='text-align:right'>$".number_format($presuDefinitivo-$presuDefinitivoSalida,2,',','.')."</td>";
			echo "</tr>";


						$totalCDPEnt=0;
						$totalCDPSal=0;
						$queryTraslados="SELECT C.consvigencia,C.fecha,C.objeto,C.tipo_mov,SUM(D.valor),(SELECT SUM(RD.valor) FROM pptorp R,pptorp_detalle RD where R.idcdp=C.consvigencia AND R.vigencia=$vigencia AND R.tipo_mov='201' AND RD.cuenta='$numCuenta' AND RD.consvigencia=R.consvigencia AND RD.tipo_mov='201' AND RD.vigencia=$vigencia AND  NOT(R.estado='N') AND R.fecha BETWEEN '$fechaf' AND '$fechaf2'),(SELECT SUM(DN.valor) FROM pptocdp CN,pptocdp_detalle DN WHERE  DN.cuenta=D.cuenta AND DN.vigencia=D.vigencia AND (DN.tipo_mov='401' OR DN.tipo_mov='402') AND DN.consvigencia=D.consvigencia AND DN.consvigencia=CN.consvigencia AND (CN.tipo_mov='401' OR CN.tipo_mov='402') AND CN.vigencia=$vigencia AND NOT(DN.estado='N') AND DN.valor>0 AND CN.fecha BETWEEN '$fechaf' AND '$fechaf2'),(SELECT SUM(RDN.valor) FROM pptorp RN,pptorp_detalle RDN where RN.idcdp=C.consvigencia AND RN.vigencia=$vigencia AND (RN.tipo_mov='401' OR RN.tipo_mov='402') AND RDN.cuenta='$numCuenta' AND RDN.consvigencia=RN.consvigencia AND (RDN.tipo_mov='401' OR RDN.tipo_mov='402') AND RDN.vigencia=$vigencia AND  NOT(RN.estado='N') AND RN.fecha BETWEEN '$fechaf' AND '$fechaf2') FROM pptocdp C, pptocdp_detalle D WHERE D.cuenta='$numCuenta' AND D.vigencia=$vigencia AND D.tipo_mov='201' AND D.consvigencia=C.consvigencia AND C.tipo_mov='201' AND C.vigencia=$vigencia AND NOT(D.estado='N') AND D.valor>0 AND C.fecha BETWEEN '$fechaf' AND '$fechaf2' GROUP BY C.consvigencia ORDER BY C.consvigencia";
						$result=mysql_query($queryTraslados, $linkbd);
						if(mysql_num_rows($result)==0){

						//	echo "<b>Dicho rubro no CDPs</b>";
						}
						else{
							while($row=mysql_fetch_array($result)){
								echo "<tr class='zebra1' ondblclick='direccionaDocumento(this)'>";
								echo "<td>CDP</td>";
								echo "<td>$row[0]</td>";
								echo "<td>$row[1]</td>";
								echo "<td>$row[2]</td>";
								echo "<td>$row[3]</td>";
								echo "<td style='text-align:right'>$".number_format($row[4]-$row[6],2,',','.')."</td>";
								echo "<td style='text-align:right'>$".number_format($row[5]-$row[7],2,',','.')."</td>";
								echo "<td style='text-align:right'>$".number_format(generaSaldo($row[0],'1',$row[4],$row[5],$vigencia,$numCuenta,$fechaf,$fechaf2),2,',','.')."</td>";
								echo "</tr>";
						
							$totalCDPEnt+=($row[4]-$row[6]);
							$totalCDPSal+=($row[5]-$row[7]);
						}
						}

			echo "<tr class='saludo1'>";
				echo "<td colspan='3'></td><td><b>Subtotal DISPONIBILIDADES</b></td><td></td><td style='text-align:right'>$".number_format($totalCDPEnt,2,',','.')."</td><td style='text-align:right'>$".number_format($totalCDPSal,2,',','.')."</td><td style='text-align:right'>$".number_format($totalCDPEnt-$totalCDPSal,2,',','.')."</td>";
			echo "</tr>";



						$totalRPEnt=0;
						$totalRPSal=0;
						$arregloRP=Array();
						$i=0;
						$queryTraslados="SELECT R.consvigencia,R.fecha,R.tipo_mov,SUM(RD.valor),(SELECT SUM(TD.valor) FROM tesoordenpago T,tesoordenpago_det TD WHERE T.id_rp=R.consvigencia AND T.vigencia=$vigencia AND T.tipo_mov='201' AND T.id_orden=TD.id_orden AND TD.tipo_mov='201' AND NOT(T.estado='N') AND TD.cuentap='$numCuenta' AND T.fecha BETWEEN '$fechaf' AND '$fechaf2'),(SELECT SUM(HNP.valor) FROM hum_nom_cdp_rp HNR,humnom_presupuestal HNP WHERE HNR.rp=R.consvigencia AND HNR.nomina=HNP.id_nom AND HNP.cuenta='$numCuenta' AND HNR.vigencia=$vigencia AND HNP.estado='P' AND NOT(HNR.estado='N' OR HNR.estado='R')),(SELECT SUM(RDN.valor) FROM pptorp RN,pptorp_detalle RDN where  RN.vigencia=$vigencia AND (RN.tipo_mov='401' OR RN.tipo_mov='402') AND RDN.cuenta='$numCuenta' AND RDN.consvigencia=RN.consvigencia AND RN.consvigencia=R.consvigencia AND (RDN.tipo_mov='401' OR RDN.tipo_mov='402') AND RDN.vigencia=$vigencia  AND NOT(RN.estado='N') AND RDN.valor>0 AND RN.fecha BETWEEN '$fechaf' AND '$fechaf2' ),(SELECT SUM(TDN.valor) FROM tesoordenpago TN,tesoordenpago_det TDN WHERE TN.id_rp=R.consvigencia AND TN.vigencia=$vigencia AND TN.tipo_mov='401' AND TN.id_orden=TDN.id_orden AND TDN.tipo_mov='401' AND NOT(TN.estado='N') AND TDN.cuentap='$numCuenta' AND TN.fecha BETWEEN '$fechaf' AND '$fechaf2') FROM pptorp R,pptorp_detalle RD where  R.vigencia=$vigencia AND R.tipo_mov='201' AND RD.cuenta='$numCuenta' AND RD.consvigencia=R.consvigencia AND RD.tipo_mov='201' AND RD.vigencia=$vigencia  AND NOT(R.estado='N') AND RD.valor>0 AND R.fecha BETWEEN '$fechaf' AND '$fechaf2' GROUP BY R.consvigencia";
						//echo $queryTraslados;
						$result=mysql_query($queryTraslados, $linkbd);
						if(mysql_num_rows($result)==0){

							//echo "<b>Dicho rubro no tiene RPs</b>";
						}
						else{
					
							while($row=mysql_fetch_array($result)){
							echo "<tr class='$iter'>";
								echo "<td>Registro Presupuestal</td>";
								echo "<td>$row[0]</td>";
								echo "<td>$row[1]</td>";
								echo "<td>   </td>";
								echo "<td>$row[2]</td>";
								echo "<td style='text-align:right'>$".number_format(($row[3]-$row[6]),2,',','.')."</td>";
								echo "<td style='text-align:right'>$".number_format(($row[4]+$row[5]-$row[7]),2,',','.')."</td>";
								echo "<td style='text-align:right'>$".number_format(generaSaldo($row[0],'2',$row[3],$row[4]+$row[5],$vigencia,$numCuenta),2,',','.')."</td>";
								echo "</tr>";

							$totalRPEnt+=($row[3]-$row[6]);
							$totalRPSal+=($row[4]+$row[5]-$row[7]);
							$i++;
							$arregloRP[]=$row[0];
						}
						}
			
			echo "<tr class='saludo1'>";
				echo "<td colspan='3'></td><td><b>Subtotal Registros Presupuestales</b></td><td></td><td style='text-align:right'>$".number_format($totalRPEnt,2,',','.')."</td><td style='text-align:right'>$".number_format($totalRPSal,2,',','.')."</td><td style='text-align:right'>$".number_format($totalRPEnt-$totalRPSal,2,',','.')."</td>";
			echo "</tr>";



						$totalCxPEnt=0.0;
						$totalCxPSal=0.0;
						$queryTraslados="SELECT T.id_orden,T.fecha,T.tipo_mov,TD.valor,T.estado,(SELECT SUM(TDN.valor) FROM tesoordenpago TN,tesoordenpago_det TDN WHERE TN.vigencia=$vigencia AND TN.tipo_mov='401' AND TN.id_orden=TDN.id_orden AND TN.id_orden=T.id_orden AND TDN.tipo_mov='401' AND NOT(TN.estado='N') AND TDN.valor>0 AND TDN.cuentap='$numCuenta' AND TN.fecha BETWEEN '$fechaf' AND '$fechaf2') FROM tesoordenpago T,tesoordenpago_det TD WHERE T.vigencia=$vigencia AND T.tipo_mov='201' AND T.id_orden=TD.id_orden AND TD.tipo_mov='201' AND NOT(T.estado='N') AND TD.valor>0 AND TD.cuentap='$numCuenta' AND T.fecha BETWEEN '$fechaf' AND '$fechaf2'";
						$result=mysql_query($queryTraslados, $linkbd);
						if(mysql_num_rows($result)==0){

							//echo "<b>Dicho rubro no CxP</b>";
						}
						else{
							$salida=0.0;
							while($row=mysql_fetch_array($result)){
								echo "<tr class='$iter'>";
								echo "<td>Cuenta por Pagar</td>";
								echo "<td>$row[0]</td>";
								echo "<td>$row[1]</td>";
								echo "<td>Cuenta por pagar</td>";
								echo "<td>$row[2]</td>";
								echo "<td style='text-align:right'>$".number_format($row[3]-$row[5],2,',','.')."</td>";
								
							if($row[4]=='P'){
								echo "<td style='text-align:right'>$".number_format($row[3]-$row[5],2,',','.')."</td>";
								
								$salida=$row[3];
								$totalCxPSal+=$row[3];
								echo "<td style='text-align:right'>$".number_format(generaSaldo($row[0],'31',$row[3],$salida,$vigencia,$numCuenta),2,',','.')."</td>";
							}
							else{
								echo "<td style='text-align:right'>$".number_format('0',2,',','.')."</td>";
								echo "<td style='text-align:right'>$".number_format($row[3]-$row[5],2,',','.')."</td>";
								$salida=0.0;
							}

							$totalCxPEnt+=($row[3]-$row[5]);
							echo "</tr>";
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
							echo "<tr class='$iter'>";
								echo "<td>Cuenta por Pagar</td>";
								echo "<td>$row[0]</td>";
								echo "<td>$row[4]</td>";
								echo "<td>Cuenta por Pagar de nomina</td>";
								echo "<td>201</td>";
								echo "<td style='text-align:right'>$".number_format($row[2],2,',','.')."</td>";
								echo "<td style='text-align:right'>$".number_format($row[2],2,',','.')."</td>";
								echo "<td style='text-align:right'>$".number_format(generaSaldo($row[0],'32',$row[2],$row[2],$vigencia,$numCuenta),2,',','.')."</td>";
								echo "</tr>";
							$totalCxPEnt+=$row[2];
							$totalCxPSal+=$row[2];
							break;

						}
						}

						}
			echo "<tr class='saludo1'>";
				echo "<td colspan='3'></td><td><b>Subtotal Cuentas por Pagar</b></td><td></td><td style='text-align:right'>$".number_format($totalCxPEnt,2,',','.')."</td><td style='text-align:right'>$".number_format($totalCxPSal,2,',','.')."</td><td style='text-align:right'>$".number_format($totalCxPEnt-$totalCxPSal,2,',','.')."</td>";
           echo "</tr>";



						$totalEgresoEnt=0.0;
						$totalEgresoSal=0.0;
						$queryTraslados="SELECT TE.id_egreso,TE.fecha,TE.tipo_mov,SUM(TD.valor),(SELECT SUM(TDN.valor) FROM tesoegresos TEN,tesoordenpago_det TDN where TEN.vigencia=$vigencia AND TEN.tipo_mov='401' AND TDN.cuentap='$numCuenta' AND TEN.id_orden=TE.id_orden AND TEN.id_orden=TDN.id_orden AND NOT(TEN.estado='N') AND TDN.valor >0 AND TEN.fecha BETWEEN '$fechaf' AND '$fechaf2') FROM tesoegresos TE,tesoordenpago_det TD where TE.vigencia=$vigencia AND TE.tipo_mov='201' AND TD.cuentap='$numCuenta' AND TE.id_orden=TD.id_orden AND NOT(TE.estado='N') AND TD.valor >0 AND TE.fecha BETWEEN '$fechaf' AND '$fechaf2' GROUP BY TE.id_egreso";
						//echo $queryTraslados;
						$result=mysql_query($queryTraslados, $linkbd);
						if(mysql_num_rows($result)==0){

							//echo "<b>Dicho rubro no CxP</b>";
						}
						else{
							while($row=mysql_fetch_array($result)){
							echo "<tr class='$iter'>";
								echo "<td>Pagos</td>";
								echo "<td>$row[0]</td>";
								echo "<td>$row[1]</td>";
								echo "<td>EGRESO</td>";
								echo "<td>$row[2]</td>";
								echo "<td style='text-align:right'>$".number_format($row[3]-$row[4],2,',','.')."</td>";
								echo "<td style='text-align:right'>$".number_format('0',2,',','.')."</td>";
								echo "<td style='text-align:right'>$".number_format($row[3]-$row[4],2,',','.')."</td>";
								echo "</tr>";
							$totalEgresoEnt+=($row[3]-$row[4]);

						}
						}

						for($i=0;$i<sizeof($arregloEgresosNom);$i++){
							$numEgreso=$arregloEgresosNom[$i]['id'];
							$fecha=$arregloEgresosNom[$i]['fecha'];
							$concepto=$arregloEgresosNom[$i]['concepto'];
							$valor=$arregloEgresosNom[$i]['valor'];

								echo "<tr class='$iter'>";
								echo "<td>Pagos</td>";
								echo "<td>$numEgreso</td>";
								echo "<td>$fecha</td>";
								echo "<td>$concepto</td>";
								echo "<td>201</td>";
								echo "<td style='text-align:right'>$".number_format($valor,2,',','.')."</td>";
								echo "<td style='text-align:right'>$".number_format('0',2,',','.')."</td>";
								echo "<td style='text-align:right'>$".number_format($valor,2,',','.')."</td>";
								echo "</tr>";
							$totalEgresoEnt+=$valor;
						}
			
						echo "<tr class='saludo1'>";
				echo "<td colspan='3'></td><td><b>Subtotal Cuentas Pagos</b></td><td></td><td style='text-align:right'>$".number_format($totalEgresoEnt,2,',','.')."</td><td style='text-align:right'>$".number_format($totalEgresoSal,2,',','.')."</td><td style='text-align:right'>$".number_format($totalEgresoEnt-$totalEgresoSal,2,',','.')."</td>";
              echo "</tr>";
              echo "<tr class='saludo1'>";
              	echo "<td colspan='3'></td><td><b>Saldo Disponible</b></td><td></td><td style='text-align:right'>$".number_format($presuDefinitivo-$totalCDPEnt,2,',','.')."</td><td style='text-align:right'>$".number_format($presuDefinitivo-$totalCDPEnt,2,',','.')."</td><td style='text-align:right'></td>";
              echo "</tr>";

			echo "</tbody></table></div>";




						
					}
				function generaSaldo($id_compro,$opc,$entact,$entsig,$vigencia,$numCuenta,$fechaf,$fechaf2){
					global $linkbd;
						switch ($opc) {
							case '1':
								$querySaldo="SELECT SUM(RD.valor) FROM pptorp R,pptorp_detalle RD where R.idcdp=$id_compro AND R.vigencia=$vigencia AND (R.tipo_mov='401' OR R.tipo_mov='402') AND RD.cuenta='$numCuenta' AND RD.consvigencia=R.consvigencia AND (RD.tipo_mov='401' OR RD.tipo_mov='402') AND RD.vigencia=$vigencia AND R.fecha BETWEEN '$fechaf' AND '$fechaf2'";
								$result=mysql_query($querySaldo,$linkbd);
								$valorReversado=mysql_fetch_array($result);

								$querySaldo="SELECT SUM(D.valor) FROM pptocdp C, pptocdp_detalle D WHERE C.consvigencia=$id_compro AND D.cuenta='$numCuenta' AND D.vigencia=$vigencia AND ( D.tipo_mov='401' OR D.tipo_mov='402') AND D.consvigencia=C.consvigencia AND (C.tipo_mov='401' OR C.tipo_mov='402') AND C.vigencia=$vigencia AND NOT(D.estado='N') AND D.valor>0 AND C.fecha BETWEEN '$fechaf' AND '$fechaf2'";
								$result=mysql_query($querySaldo,$linkbd);
								$valorReversadoAct=mysql_fetch_array($result);

								$saldo=$entact-$entsig+$valorReversado[0]-$valorReversadoAct[0];
								return $saldo;
								break;
							case '2':
								$querySaldo="SELECT SUM(TD.valor) FROM tesoordenpago T,tesoordenpago_det TD WHERE T.id_rp=$id_compro AND T.vigencia=$vigencia AND (T.tipo_mov='401' OR T.tipo_mov='402') AND T.id_orden=TD.id_orden AND (TD.tipo_mov='401' OR TD.tipo_mov='402') AND TD.cuentap='$numCuenta' AND T.fecha BETWEEN '$fechaf' AND '$fechaf2' ";
								$result=mysql_query($querySaldo,$linkbd);
								$valorReversado1=mysql_fetch_array($result);

								$querySaldo="SELECT SUM(HNP.valor) FROM hum_nom_cdp_rp HNR,humnom_presupuestal HNP WHERE HNR.rp=$id_compro AND HNR.nomina=HNP.id_nom AND HNP.cuenta='$numCuenta' AND HNR.vigencia=$vigencia AND HNP.estado='P' AND HNR.estado='R'";
								$result=mysql_query($querySaldo,$linkbd);
								$valorReversado2=mysql_fetch_array($result);

								$querySaldo="SELECT SUM(RD.valor) FROM pptorp R,pptorp_detalle RD where  R.consvigencia=$id_compro AND R.vigencia=$vigencia AND (R.tipo_mov='401' OR R.tipo_mov='402') AND RD.cuenta='$numCuenta' AND RD.consvigencia=R.consvigencia AND (RD.tipo_mov='401' OR RD.tipo_mov='402') AND RD.vigencia=$vigencia  AND NOT(R.estado='N') AND RD.valor>0 AND R.fecha BETWEEN '$fechaf' AND '$fechaf2'";
								$result=mysql_query($querySaldo,$linkbd);
								$valorReversado3=mysql_fetch_array($result);

								$saldo=$entact-$entsig+($valorReversado1[0]+$valorReversado2[0])-$valorReversado3[0];
								return $saldo;
								break;
							case '31':
								$querySaldo="SELECT 1 FROM tesoegresos TE,tesoordenpago_det TD where TE.vigencia=$vigencia AND (TE.tipo_mov='401' OR TE.tipo_mov='402') AND TD.cuentap='$numCuenta' AND TE.id_orden=$id_compro AND TE.id_orden=TD.id_orden AND TE.fecha BETWEEN '$fechaf' AND '$fechaf2'";
								$result=mysql_result($querySaldo, $linkbd);
								$numRegistros=mysql_num_rows($result);

								$querySaldo="SELECT SUM(TD.valor) FROM tesoordenpago T,tesoordenpago_det TD WHERE T.id_orden=$id_compro AND T.vigencia=$vigencia AND T.tipo_mov='401' AND TD.id_orden=T.id_orden AND TD.tipo_mov='401' AND NOT(T.estado='N') AND TD.valor>0 AND TD.cuentap='$numCuenta' AND T.fecha BETWEEN '$fechaf' AND '$fechaf2'";
								$result=mysql_result($querySaldo, $linkbd);
								$valorReversado=mysql_fetch_array($result);

								if($numRegistros>0){
									$saldo=$entact-$entsig+$entsig-$valorReversado[0];
								}else{
									$saldo=$entact-$entsig-$valorReversado[0];
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
        					
        				});
        				
        			}
        		
        	});	
        </script>
        <script>

 jQuery(function($){
 var codigo="<?php echo $_GET[cod]; ?>";
 	if(codigo!=null && codigo!=''){
 		$('input[name=generar]').click();
 	}
 	
  var user ="<?php echo $_SESSION[cedulausu]; ?>";
  var bloque='';
  $.post('peticionesjquery/seleccionavigencia.php',{usuario: user},selectresponse);
  

 $('#cambioVigencia').change(function(event) {
   var valor= $('#cambioVigencia').val();
   var user ="<?php echo $_SESSION[cedulausu]; ?>";
   var confirma=confirm('¿Realmente desea cambiar la vigencia?');
   if(confirma){
    var anobloqueo=bloqueo.split("-");
    var ano=anobloqueo[0];
    if(valor < ano){
      if(confirm("Tenga en cuenta va a entrar a un periodo bloqueado. Desea continuar")){
        $.post('peticionesjquery/cambiovigencia.php',{valor: valor,usuario: user},updateresponse);
      }else{
        location.reload();
      }

    }else{
      $.post('peticionesjquery/cambiovigencia.php',{valor: valor,usuario: user},updateresponse);
    }
    
   }else{
   	location.reload();
   }
   
 });

 function updateresponse(data){
  json=eval(data);
  if(json[0].respuesta=='2'){
    alert("Vigencia modificada con exito");
  }else if(json[0].respuesta=='3'){
    alert("Error al modificar la vigencia");
  }
  location.reload();
 }
 function selectresponse(data){ 
  json=eval(data);
  $('#cambioVigencia').val(json[0].vigencia);
  bloqueo=json[0].bloqueo;
 }

 }); 
</script>
</body>
</body>
</html>