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
		<script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
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
				document.form2.action="pdfauxiliaringpres.php";
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
				document.form2.action="presu-auxiliarcuenta2excel.php";
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
			<tr><script>barra_imagenes("ccpet");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("ccpet");?></tr>
          	<tr>
  				<td colspan="3" class="cinta">
					<a href="#" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a> 
					<a href="#" onClick="document.form2.submit();" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a> 
					<a href="#" onClick="document.form2.submit()" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a> 
					<a href="#" onClick="mypop=window.open('ccp-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a> <a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png" title="imprimir"></a> 
					<a href="#"   onClick="excell()" class="mgbt"><img src="imagenes/excel.png" titlw="excel"></a> 
					<a href="ccp-ejecucionpresupuestal.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
				</td>
         	</tr>
		</table>
          <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>	  
	<form name="form2" method="post" action="ccp-auxiliarcuentaingresos.php">
		<?php
		$linkbd=conectar_bd();
		
		$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
		$_POST[vigencia]=$vigusu;
		if(isset($_GET['cod'])){
				if(!empty($_GET['cod'])){
					$_POST[cuenta]=$_GET['cod'];
					$_POST[ncuenta]=buscacuentapres($_POST[cuenta],2);
					$_POST[fecha]=$_GET['fechai'];
					$_POST[fecha2]=$_GET['fechaf'];
				}
			}
		if($_POST[bc]!='')
		{
			$nresul=buscacuentapres($_POST[cuenta],1);			
			if($nresul!='')
			{
				$_POST[ncuenta]=$nresul;
				$sqlr="select vigencia, vigenciaf from pptocuentas where cuenta='$_POST[cuenta]' and (vigencia=".$vigusu." or vigenciaf='$vigusu')";
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
				<td class="titulos" colspan="8">.: Auxilar por Cuenta Ingresos</td>
				<td class="cerrar"><a href="ccp-principal.php">Cerrar</a></td>
			</tr>
			<tr>
				<td  class="saludo1">Cuenta:</td>
				<td  valign="middle" ><input type="text" id="cuenta" name="cuenta" size="12" onKeyPress="javascript:return solonumeros(event)" 
		  onKeyUp="return tabular(event,this)" onBlur="buscacta(event)" value="<?php echo $_POST[cuenta]?>" onClick="document.getElementById('cuenta').focus();document.getElementById('cuenta').select();"><input type="hidden" value="0" name="bc"><a href="#" onClick="mypop=window.open('cuentasppto-ventana.php?ti=1','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>  </td><td width="367"><input name="ncuenta" type="text" value="<?php echo $_POST[ncuenta]?>" size="60" readonly>  </td>    
				<td  class="saludo1">Fecha Inicial:</td>
				<td ><input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">         <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>        </td>
				<td  class="saludo1">Fecha Final: </td>
				<td ><input name="fecha2" type="text" id="fc_1198971546" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha2]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">         <a href="#" onClick="displayCalendarFor('fc_1198971546');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>       <input type="button" name="generar" value="Generar" onClick="validar()"> <input type="hidden" value="<?php echo $_POST[oculto]; ?>" name="oculto" id="oculto"> <input name="valor" type="hidden" value="<?php echo $_POST[valor]?>"  readonly><input name="valor2" type="hidden" value="<?php echo $_POST[valor2]?>"  readonly> </td>
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
				else{
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
									$sqlv="SELECT vigencia, vigenciaf FROM pptocuentas WHERE vigencia='$fecha1[3]'";
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
			$nresul=buscacuentapres($_POST[cuenta],1);
			if($nresul!='')
			{
				$_POST[ncuenta]=$nresul;
				$linkbd=conectar_bd();
				$sqlr="select vigencia, vigenciaf from pptocuentas where cuenta='$_POST[cuenta]' and (vigencia=".$vigusu." or vigenciaf='$vigusu')";
				//echo $sqlr;
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
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
			$sumaTotal=0.0;
			if($correcto==1)
			{
				$_POST[tiporec]=array();
				$tots=0;
				$sumad=0;
				$sumac=0;	
				ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
				$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
				ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
				$fechaf2=$fecha[3]."-".$fecha[2]."-".$fecha[1];	
				$fechafa=($fecha[3]-1)."-01-01";
				$fechaf2a=($fecha[3]-1)."-12-31";
				//$ti=substr($_POST[cuenta],0,1);
				$ti=1;
			
					echo "<div class='subpanta' style='width:100%; margin-top:0px; overflow-x:hidden;overflow-y:scroll' id='divdet'>
			<table class='inicio' align='center'>
						<tr><td colspan='8' class='titulos'>Auxiliar por Cuenta</td></tr>
				<tr class='titulos' style='text-align:center;'>
								<td class='titulos2' id='col1'>TIPO COMPROBANTE</td>
								<td class='titulos2' id='col2'>No. COMPROBANTE</td>
								<td style=' width:6%; ' class='titulos2' id='col3'>FECHA</td>
								<td class='titulos2' id='col4'>No. LIQUIDACION</td>
								<td class='titulos2' id='col5'>ENTRADAS</td>
								<td class='titulos2' id='col6'>SALIDAS</td>
								<td class='titulos2' id='col7'>SALDO</td>
							</tr></table>
						</div>";
				echo "<div class='subpantallac5' style='height:55%; width:99.6%; margin-top:0px; overflow-x:hidden' id='divdet'>
				<table class='inicio' align='center' id='valores' ><tbody>";
					$linkbd=conectar_bd();
				$iter='zebra1';
				$iter2='zebra2';
				$queryPresupuesto="SELECT valor,vigencia FROM pptocuentaspptoinicial WHERE cuenta='$_POST[cuenta]' AND vigencia=$_POST[valor]";

				$result=mysql_query($queryPresupuesto, $linkbd);
				echo "<tr class='$iter'>";
				echo "<td id='1'><input type='hidden' name='tiporec[]' id='tiporec[]' value='Apropiacion Inicial' />Apropiacion Inicial</td>";
				while($row=mysql_fetch_array($result)){		
					  echo "<td id='2'><input type='hidden' name='nrec[]' id='nrec[]' value='$row[1]' /> $row[1]</td>";
					  echo "<td id='3'><input type='hidden' name='fecrec[]' id='fecrec[]' value='$row[1]-01-01' /> $row[1]-01-01</td>";
					  echo "<td id='4'><input type='hidden' name='nliq[]' id='nliq[]' value='-' /><input type='hidden' name='tliq[]' id='tliq[]' value='Apropiacion Inicial' /> -</td>";
					  echo "<td id='5'><input type='hidden' name='entrada[]' id='entrada[]' value='$row[0]' /> $".number_format($row[0],2,',','.')."</td>";
					  echo "<td id='6'><input type='hidden' name='salida[]' id='salida[]' value='0' /> $".number_format(0,2,',','.')."</td>";
					  echo "<td id='7'><input type='hidden' name='saldo[]' id='saldo[]' value='$row[0]' />$".number_format($row[0],2,',','.')."</td>";
					  $presuDefinitivo+=$row[0];
					}
				echo "</tr>";
				$queryAdiciones="SELECT SUM(pad.valor),pad.id_adicion,pa.fecha FROM pptoadiciones pad,pptoacuerdos pa WHERE pad.cuenta='$_POST[cuenta]' AND pad.vigencia=$_POST[valor] AND pa.id_acuerdo=pad.id_acuerdo AND pad.id_acuerdo>0 AND pad.tipomovimiento<>'S' AND   pa.fecha BETWEEN '$fechaf' AND '$fechaf2' GROUP BY cuenta";
						$result=mysql_query($queryAdiciones, $linkbd);
						$totentAdicion=0.0;
						$totsalAdicion=0.0;
						if(mysql_num_rows($result)==0){

							//echo "<b>Dicho rubro no tiene adiciones</b>";
						}
						else{
							while($row=mysql_fetch_array($result)){
							echo "<tr class='zebra2'>";
						     echo "<td id='1'><input type='hidden' name='tiporec[]' id='tiporec[]' value='Adicion' />Adicion</td>";
						     echo "<td id='2'><input type='hidden' name='nrec[]' id='nrec[]' value='$row[1]' />$row[1]</td>";
						     echo "<td id='3'><input type='hidden' name='fecrec[]' id='fecrec[]' value='$row[2]' />$row[2]</td>";
						     echo "<td id='4'><input type='hidden' name='nliq[]' id='nliq[]' value='-' /><input type='hidden' name='tliq[]' id='tliq[]' value='Adicion' />-</td>";
						     echo "<td id='5' style='text-align:right'><input type='hidden' name='entrada[]' id='entrada[]' value='$row[0]' /> $".number_format($row[0],2,',','.')."</td>";
						     echo "<td id='6' style='text-align:right'><input type='hidden' name='salida[]' id='salida[]' value='0' /> $".number_format(0,2,',','.')."</td>";
						     echo "<td id='7' style='text-align:right'><input type='hidden' name='saldo[]' id='saldo[]' value='$row[0]' /> $".number_format($row[0],2,',','.')."</td>";
						     echo "</tr>";
							$presuDefinitivo+=$row[0];
							$totentAdicion+=$row[0];
							$totsalAdicion+=0;
							
						}
						}
					echo "<tr class='saludo1'>";
				echo "<td></td><td colspan='3'><center><b>Subtotal Adiciones</b></center></td><td style='text-align:right'>$".number_format($totentAdicion,2,',','.')."</td><td style='text-align:right'>$".number_format($totsalAdicion,2,',','.')."</td><td style='text-align:right'>$".number_format($totentAdicion-$totsalAdicion,2,',','.')."</td>";
			echo "</tr>";

			$queryAdiciones="SELECT SUM(pad.valor),pad.id_adicion,pa.fecha FROM pptoadiciones pad,pptoacuerdos pa WHERE pad.cuenta='$_POST[cuenta]' AND pad.vigencia=$_POST[valor] AND pa.id_acuerdo=pad.id_acuerdo AND pad.id_acuerdo>0 AND pad.tipomovimiento='S' AND   pa.fecha BETWEEN '$fechaf' AND '$fechaf2' GROUP BY cuenta";
						$result=mysql_query($queryAdiciones, $linkbd);
						$totentAdicion=0.0;
						$totsalAdicion=0.0;
						if(mysql_num_rows($result)==0){

							//echo "<b>Dicho rubro no tiene adiciones</b>";
						}
						else{
							while($row=mysql_fetch_array($result)){
							echo "<tr class='zebra2'>";
						     echo "<td id='1'><input type='hidden' name='tiporec[]' id='tiporec[]' value='Adicion' />Adicion</td>";
						     echo "<td id='2'><input type='hidden' name='nrec[]' id='nrec[]' value='$row[1]' />$row[1]</td>";
						     echo "<td id='3'><input type='hidden' name='fecrec[]' id='fecrec[]' value='$row[2]' />$row[2]</td>";
						     echo "<td id='4'><input type='hidden' name='nliq[]' id='nliq[]' value='-' /><input type='hidden' name='tliq[]' id='tliq[]' value='Adicion' />-</td>";
						     echo "<td id='5' style='text-align:right'><input type='hidden' name='entrada[]' id='entrada[]' value='$row[0]' /> $".number_format($row[0],2,',','.')."</td>";
						     echo "<td id='6' style='text-align:right'><input type='hidden' name='salida[]' id='salida[]' value='0' /> $".number_format(0,2,',','.')."</td>";
						     echo "<td id='7' style='text-align:right'><input type='hidden' name='saldo[]' id='saldo[]' value='$row[0]' /> $".number_format($row[0],2,',','.')."</td>";
						     echo "</tr>";
							$presuDefinitivo+=$row[0];
							$totentAdicion+=$row[0];
							$totsalAdicion+=0;
							
						}
						}
					echo "<tr class='saludo1'>";
				echo "<td></td><td colspan='3'><center><b>Subtotal Disponibilidad Inicial</b></center></td><td style='text-align:right'>$".number_format($totentAdicion,2,',','.')."</td><td style='text-align:right'>$".number_format($totsalAdicion,2,',','.')."</td><td style='text-align:right'>$".number_format($totentAdicion-$totsalAdicion,2,',','.')."</td>";
			echo "</tr>";


				$queryReducciones="SELECT SUM(pr.valor),pr.id_reduccion,pa.fecha FROM pptoreducciones pr,pptoacuerdos pa WHERE pr.cuenta='$_POST[cuenta]' AND pr.vigencia=$_POST[valor] AND pr.id_acuerdo=pa.id_acuerdo AND pr.id_acuerdo>0 AND pa.fecha BETWEEN '$fechaf' AND '$fechaf2' GROUP BY pr.cuenta";
						
						$result=mysql_query($queryReducciones, $linkbd);
						$totentReduccion=0.0;
						$totsalReduccion=0.0;
						if(mysql_num_rows($result)==0){

							//echo "<b>Dicho rubro no tiene adiciones</b>";
						}
						else{
							while($row=mysql_fetch_array($result)){
							 echo "<tr class='zebra2'>";
						     echo "<td id='1'><input type='hidden' name='tiporec[]' id='tiporec[]' value='Reduccion' />Reduccion</td>";
						     echo "<td id='2'><input type='hidden' name='nrec[]' id='nrec[]' value='$row[1]' />$row[1]</td>";
						     echo "<td id='3'><input type='hidden' name='fecrec[]' id='fecrec[]' value='$row[2]' />$row[2]</td>";
						     echo "<td id='4'><input type='hidden' name='nliq[]' id='nliq[]' value='-' /><input type='hidden' name='tliq[]' id='tliq[]' value='Reduccion' />-</td>";
						     echo "<td style='text-align:right' id='5'><input type='hidden' name='entrada[]' id='entrada[]' value='0' />$".number_format(0,2,',','.')."</td>";
						     echo "<td style='text-align:right' id='6'><input type='hidden' name='salida[]' id='salida[]' value='$row[0]' />$".number_format($row[0],2,',','.')."</td>";
						     echo "<td style='text-align:right' id='7'><input type='hidden' name='saldo[]' id='saldo[]' value='".(-1*$row[0])."' /> $".number_format(-1*$row[0],2,',','.')."</td>";
						     echo "</tr>";
							$presuDefinitivo-=$row[0];
							$totentReduccion+=0.0;
							$totsalReduccion+=$row[0];
						}
						}
				echo "<tr class='saludo1'>";
				echo "<td></td><td colspan='3'><center><b>Subtotal Reducciones</b></center></td><td style='text-align:right'>$".number_format($totentReduccion,2,',','.')."</td><td style='text-align:right'>$".number_format($totsalReduccion,2,',','.')."</td><td style='text-align:right'>$".number_format($totentReduccion-$totsalReduccion,2,',','.')."</td>";
			echo "</tr>";
				$queryTraslados="SELECT pt.id_acuerdo,pt.tipo,SUM(pt.valor),pa.fecha FROM pptotraslados pt,pptoacuerdos pa WHERE pt.cuenta='$_POST[cuenta]' AND pt.vigencia=$_POST[valor] AND pt.id_acuerdo>0 AND  pt.id_acuerdo=pa.id_acuerdo AND pa.fecha BETWEEN '$fechaf' AND '$fechaf2' GROUP BY pt.id_acuerdo";
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
							echo "<td id='1'><input type='hidden' name='tiporec[]' id='tiporec[]' value='Traslado' />Traslado</td>";
							echo "<td id='2'><input type='hidden' name='nrec[]' id='nrec[]' value='$row[0]' /> $row[0]</td>";
							echo "<td id='3'><input type='hidden' name='fecrec[]' id='fecrec[]' value='$row[3]' />$row[3]</td>";
							echo "<td id='4'><input type='hidden' name='nliq[]' id='nliq[]' value='-' /><input type='hidden' name='tliq[]' id='tliq[]' value='Traslado' />-</td>";
							if($row[1]=='R'){
							$presuSalida+=$row[2];
							$presuDefinitivo-=$row[2];
							$entrada=0.0;
							$salida=$row[2];
							$saldo=0-$row[2];
							echo "<td style='text-align:right' id='5'><input type='hidden' name='entrada[]' id='entrada[]' value='0' />$".number_format('0',2,',','.')."</td>";
							echo "<td style='text-align:right' id='6'><input type='hidden' name='salida[]' id='salida[]' value='$row[2]' /> $".number_format($row[2],2,',','.')."</td>";
							echo "<td style='text-align:right' id='7'><input type='hidden' name='saldo[]' id='saldo[]' value='-$row[2]' /> $".number_format(0-$row[2],2,',','.')."</td>";
							$totsalTraslado+=$row[2];
							}
							else{
							$presuDefinitivo+=$row[2];
							$entrada=$row[2];
							$salida=0.0;
							$saldo=$row[2];
							echo "<td style='text-align:right' id='5'><input type='hidden' name='entrada[]' id='entrada[]' value='$row[2]' /> $".number_format($row[2],2,',','.')."</td>";
							echo "<td style='text-align:right' id='6'><input type='hidden' name='salida[]' id='salida[]' value='0' />$".number_format('0',2,',','.')."</td>";
							echo "<td style='text-align:right' id='7'><input type='hidden' name='saldo[]' id='saldo[]' value='$row[2]' />$".number_format($row[2],2,',','.')."</td>";
							$totentTraslado+=$row[2];
							}

						echo "</tr>";
						}
						}
				echo "<tr class='saludo1'>";
				echo "<td></td><td colspan='3'><center><b>Subtotal Traslados</b></center></td><td style='text-align:right'>$".number_format($totentTraslado,2,',','.')."</td><td style='text-align:right'>$".number_format($totsalTraslado,2,',','.')."</td><td style='text-align:right'>$".number_format($totentTraslado-$totsalTraslado,2,',','.')."</td>";
				echo "</tr>";

				echo "<tr class='saludo1'>";
				echo "<td ></td><td colspan='3'><center><b><input type='hidden' name='tiporec[]' id='tiporec[]' value='PRESUPUESTO DEFINITIVO' /><input type='hidden' name='nrec[]' id='nrec[]' value='**' />PRESUPUESTO DEFINITIVO</b></center></td><td style='text-align:right'><input type='hidden' name='entrada[]' id='entrada[]' value='$presuDefinitivo' />$".number_format($presuDefinitivo,2,',','.')."</td><td style='text-align:right'><input type='hidden' name='salida[]' id='salida[]' value='$presuDefinitivoSalida' /> $".number_format($presuDefinitivoSalida,2,',','.')."</td><td style='text-align:right'><input type='hidden' name='saldo[]' id='saldo[]' value='".($presuDefinitivo-$presuDefinitivoSalida)."' />$".number_format($presuDefinitivo-$presuDefinitivoSalida,2,',','.')."</td>";
			echo "</tr>";

			$queryreccaja="SELECT trc.id_recibos,trc.id_recaudo,trc.vigencia,trc.fecha,SUM(prc.valor),trc.tipo FROM pptorecibocajappto prc,tesoreciboscaja trc WHERE prc.cuenta='$_POST[cuenta]' AND prc.vigencia=$_POST[valor] AND trc.id_recibos=prc.idrecibo AND NOT(trc.estado='N' OR trc.estado='R') AND NOT(prc.tipo='R' OR prc.tipo='P') AND trc.fecha between '$fechaf' AND '$fechaf2' GROUP BY trc.id_recibos";
			//echo $queryreccaja;
			$result=mysql_query($queryreccaja,$linkbd);
			while($row = mysql_fetch_row($result)){
				$tipo="";
				switch($row[5]){
					case "1":
					$tipo="PREDIAL";
					break;
					case "2":
					$tipo="INDUSTRIA Y COMERCIO";
					break;
					case "3":
					$tipo="OTROS RECAUDOS";
					break;
				}
				echo "<tr class='zebra1'>";
				echo "<td id='1'><input type='hidden' name='tiporec[]' id='tiporec[]' value='Recibo de caja' />RECIBO DE CAJA</td>";
				echo "<td id='2'><input type='hidden' name='nrec[]' id='nrec[]' value='$row[0]' />$row[0]</td>";
				echo "<td id='3'><input type='hidden' name='fecrec[]' id='fecrec[]' value='$row[3]' /> $row[3]</td>";
				echo "<td id='4'><input type='hidden' name='nliq[]' id='nliq[]' value='$row[1]' /><input type='hidden' name='tliq[]' id='tliq[]' value='$tipo' />$row[1] - $tipo</td>";
				echo "<td style='text-align:right' id='5'><input type='hidden' name='entrada[]' id='entrada[]' value='".$row[4]."' />$".number_format($row[4],2,',','.')."</td>";
				echo "<td style='text-align:right' id='6'><input type='hidden' name='salida[]' id='salida[]' value='0' /> $".number_format(0,2,',','.')."</td>";
				echo "<td style='text-align:right' id='7'><input type='hidden' name='saldo[]' id='saldo[]' value='$row[4]' />$".number_format($row[4],2,',','.')."</td>";
				echo "</tr>";
				$sumaTotal+=$row[4];
			}

			$querysinreccaja="SELECT tsrc.id_recibos,tsrc.id_recaudo,tsrc.vigencia,tsrc.fecha,SUM(psrc.valor) FROM pptosinrecibocajappto psrc,tesosinreciboscaja tsrc WHERE psrc.cuenta='$_POST[cuenta]' AND psrc.vigencia=$_POST[valor] AND tsrc.id_recibos=psrc.idrecibo AND NOT(tsrc.estado='N' OR tsrc.estado='R') AND tsrc.fecha between '$fechaf' AND '$fechaf2' GROUP BY tsrc.id_recibos";
			//echo $querysinreccaja;
			$result=mysql_query($querysinreccaja,$linkbd);
			while($row = mysql_fetch_row($result)){
				echo "<tr class='zebra1'>";
				echo "<td id='1'><input type='hidden' name='tiporec[]' id='tiporec[]' value='Sin recibo de caja' />SIN RECIBO DE CAJA</td>";
				echo "<td id='2'><input type='hidden' name='nrec[]' id='nrec[]' value='$row[0]' />$row[0]</td>";
				echo "<td id='3'><input type='hidden' name='fecrec[]' id='fecrec[]' value='$row[3]' />$row[3]</td>";
				echo "<td id='4'><input type='hidden' name='nliq[]' id='nliq[]' value='$row[1]' /><input type='hidden' name='tliq[]' id='tliq[]' value='Sin recibo de caja' />$row[1] - SIN RECIBO DE CAJA</td>";
				echo "<td style='text-align:right' id='5'><input type='hidden' name='entrada[]' id='entrada[]' value='$row[4]' />$".number_format($row[4],2,',','.')."</td>";
				echo "<td style='text-align:right' id='6'><input type='hidden' name='salida[]' id='salida[]' value='0' />$".number_format(0,2,',','.')."</td>";
				echo "<td style='text-align:right' id='7'><input type='hidden' name='saldo[]' id='saldo[]' value='$row[4]' />$".number_format($row[4],2,',','.')."</td>";
				echo "</tr>";
				$sumaTotal+=$row[4];
			}
			
			
			$queryregalias="SELECT prd.codigo,prd.liquidacion,prc.vigencia,prc.fecha,SUM(prd.valor) FROM pptoregalias_cab prc,pptoregalias_det prd WHERE prd.rubro='$_POST[cuenta]' AND prc.vigencia=$_POST[valor] AND prc.codigo=prd.codigo AND NOT(prc.estado='N' OR prc.estado='R') AND prc.fecha between '$fechaf' AND '$fechaf2' GROUP BY prd.codigo";
			//echo $queryregalias;
			$result=mysql_query($queryregalias,$linkbd);
			while($row = mysql_fetch_row($result)){
				echo "<tr class='zebra1'>";
				echo "<td id='1'><input type='hidden' name='tiporec[]' id='tiporec[]' value='Ingreso de regalias' />INGRESO DE REGALIAS</td>";
				echo "<td id='2'><input type='hidden' name='nrec[]' id='nrec[]' value='$row[0]' />$row[0]</td>";
				echo "<td id='3'><input type='hidden' name='fecrec[]' id='fecrec[]' value='$row[3]' />$row[3]</td>";
				echo "<td id='4'><input type='hidden' name='nliq[]' id='nliq[]' value='$row[1]' /><input type='hidden' name='tliq[]' id='tliq[]' value='regalias' />$row[1] - INGRESO DE REGALIAS</td>";
				echo "<td style='text-align:right' id='5'><input type='hidden' name='entrada[]' id='entrada[]' value='$row[4]' />$".number_format($row[4],2,',','.')."</td>";
				echo "<td style='text-align:right' id='6'><input type='hidden' name='salida[]' id='salida[]' value='0' />$".number_format(0,2,',','.')."</td>";
				echo "<td style='text-align:right' id='7'><input type='hidden' name='saldo[]' id='saldo[]' value='$row[4]' />$".number_format($row[4],2,',','.')."</td>";
				echo "</tr>";
				$sumaTotal+=$row[4];
			}
			

			$querysinreccajasp="SELECT tsrc.id_recibos,tsrc.id_recaudo,tsrc.vigencia,tsrc.fecha,SUM(psrc.valor) FROM pptosinrecibocajaspppto psrc,tesosinreciboscajasp tsrc WHERE psrc.cuenta='$_POST[cuenta]' AND psrc.vigencia=$_POST[valor] AND tsrc.id_recibos=psrc.idrecibo AND NOT(tsrc.estado='N' OR tsrc.estado='R') AND tsrc.fecha between '$fechaf' AND '$fechaf2' GROUP BY tsrc.id_recibos";
			//echo $querysinreccaja;
			$result=mysql_query($querysinreccajasp,$linkbd);
			while($row = mysql_fetch_row($result)){
				echo "<tr class='zebra1'>";
				echo "<td id='1'><input type='hidden' name='tiporec[]' id='tiporec[]' value='Sin recibo de caja' />SIN RECIBO DE CAJA SP</td>";
				echo "<td id='2'><input type='hidden' name='nrec[]' id='nrec[]' value='$row[0]' />$row[0]</td>";
				echo "<td id='3'><input type='hidden' name='fecrec[]' id='fecrec[]' value='$row[3]' />$row[3]</td>";
				echo "<td id='4'><input type='hidden' name='nliq[]' id='nliq[]' value='$row[1]' /><input type='hidden' name='tliq[]' id='tliq[]' value='Sin recibo de caja sp' />$row[1] - SIN RECIBO DE CAJA SP</td>";
				echo "<td style='text-align:right' id='5'><input type='hidden' name='entrada[]' id='entrada[]' value='$row[4]' />$".number_format($row[4],2,',','.')."</td>";
				echo "<td style='text-align:right' id='6'><input type='hidden' name='salida[]' id='salida[]' value='0' />$".number_format(0,2,',','.')."</td>";
				echo "<td style='text-align:right' id='7'><input type='hidden' name='saldo[]' id='saldo[]' value='$row[4]' />$".number_format($row[4],2,',','.')."</td>";
				echo "</tr>";
				$sumaTotal+=$row[4];
			}
			
			
			
			$queryingssf="SELECT tissf.id_recaudo,tissf.idcomp,tissf.vigencia,tissf.fecha,SUM(pissf.valor) FROM pptoingssf pissf,tesossfingreso_cab tissf WHERE pissf.cuenta='$_POST[cuenta]' AND pissf.vigencia=$_POST[valor] AND pissf.idrecibo=tissf.id_recaudo AND NOT(tissf.estado='N' OR tissf.estado='R') AND tissf.vigencia=$_POST[valor] AND tissf.fecha between '$fechaf' AND '$fechaf2' GROUP BY tissf.id_recaudo";

			$result=mysql_query($queryingssf,$linkbd);
			while($row = mysql_fetch_row($result)){
				echo "<tr class='zebra1'>";
				echo "<td><input type='hidden' name='tiporec[]' id='tiporec[]' value='Ingreso SSF' />INGRESO SSF</td>";
				echo "<td><input type='hidden' name='nrec[]' id='nrec[]' value='$row[0]' />$row[0]</td>";
				echo "<td><input type='hidden' name='fecrec[]' id='fecrec[]' value='$row[3]' />$row[3]</td>";
				echo "<td><input type='hidden' name='nliq[]' id='nliq[]' value='$row[1]' /><input type='hidden' name='tliq[]' id='tliq[]' value='Ingreso SSF' />$row[1]</td>";
				echo "<td style='text-align:right'><input type='hidden' name='entrada[]' id='entrada[]' value='$row[4]' />$".number_format($row[4],2,',','.')."</td>";
				echo "<td style='text-align:right'><input type='hidden' name='salida[]' id='salida[]' value='0' />$".number_format(0,2,',','.')."</td>";
				echo "<td style='text-align:right'><input type='hidden' name='saldo[]' id='saldo[]' value='$row[4]' />$".number_format($row[4],2,',','.')."</td>";
				echo "</tr>";
				$sumaTotal+=$row[4];
			}

			$querynotasban="SELECT tnp.id_comp,tnp.id_comp,tnp.vigencia,tnp.fecha,SUM(pnb.valor) FROM pptonotasbanppto pnb,tesonotasbancarias_cab tnp WHERE pnb.cuenta='$_POST[cuenta]' AND pnb.vigencia=$_POST[valor] AND tnp.id_comp=pnb.idrecibo AND NOT(tnp.estado='R' OR tnp.estado='N')  AND tnp.vigencia=$_POST[valor] AND tnp.fecha between '$fechaf' AND '$fechaf2' GROUP BY tnp.id_comp";
			//echo $querynotasban;
			$result=mysql_query($querynotasban,$linkbd);
			while($row = mysql_fetch_row($result)){
				echo "<tr class='zebra1'>";
				echo "<td><input type='hidden' name='tiporec[]' id='tiporec[]' value='Nota bancaria' />NOTA BANCARIA</td>";
				echo "<td><input type='hidden' name='nrec[]' id='nrec[]' value='$row[0]' />$row[0]</td>";
				echo "<td><input type='hidden' name='fecrec[]' id='fecrec[]' value='$row[3]' />$row[3]</td>";
				echo "<td><input type='hidden' name='nliq[]' id='nliq[]' value='$row[1]' /><input type='hidden' name='tliq[]' id='tliq[]' value='Nota Bancaria' />$row[1]</td>";
				echo "<td style='text-align:right'><input type='hidden' name='entrada[]' id='entrada[]' value='$row[4]' />$".number_format($row[4],2,',','.')."</td>";
				echo "<td style='text-align:right'><input type='hidden' name='salida[]' id='salida[]' value='0' />$".number_format(0,2,',','.')."</td>";
				echo "<td style='text-align:right'><input type='hidden' name='saldo[]' id='saldo[]' value='$row[4]' />$".number_format($row[4],2,',','.')."</td>";
				echo "</tr>";
				$sumaTotal+=$row[4];
			}


			$queryrecatrans="SELECT titp.id_recaudo,titp.idcomp,titp.vigencia,titp.fecha,SUM(pitp.valor) FROM pptoingtranppto pitp,tesorecaudotransferencia titp WHERE pitp.cuenta='$_POST[cuenta]' AND pitp.vigencia=$_POST[valor] AND pitp.idrecibo=titp.id_recaudo AND NOT(titp.estado='N' OR titp.estado='R') AND titp.fecha between '$fechaf' AND '$fechaf2' GROUP BY pitp.idrecibo";
			//echo $queryrecatrans;
			$result=mysql_query($queryrecatrans,$linkbd);
			while($row = mysql_fetch_row($result)){
				echo "<tr class='zebra1'>";
				echo "<td><input type='hidden' name='tiporec[]' id='tiporec[]' value='Recaudo Transferencia' />RECAUDO TRANSFERENCIA</td>";
				echo "<td><input type='hidden' name='nrec[]' id='nrec[]' value='$row[0]' />$row[0]</td>";
				echo "<td><input type='hidden' name='fecrec[]' id='fecrec[]' value='$row[3]' />$row[3]</td>";
				echo "<td><input type='hidden' name='nliq[]' id='nliq[]' value='$row[1]' /><input type='hidden' name='tliq[]' id='tliq[]' value='Recaudo transferencia' />$row[1]</td>";
				echo "<td style='text-align:right'><input type='hidden' name='entrada[]' id='entrada[]' value='$row[4]' />$".number_format($row[4],2,',','.')."</td>";
				echo "<td style='text-align:right'><input type='hidden' name='salida[]' id='salida[]' value='0' />$".number_format(0,2,',','.')."</td>";
				echo "<td style='text-align:right'><input type='hidden' name='saldo[]' id='saldo[]' value='$row[4]' />$".number_format($row[4],2,',','.')."</td>";
				echo "</tr>";
				$sumaTotal+=$row[4];
			}

			$queryrecatrans="SELECT titp.id_recaudo,titp.vigencia,titp.fecha,SUM(pitp.valor) FROM pptoingtranpptosgr pitp,tesorecaudotransferenciasgr titp WHERE pitp.cuenta='$_POST[cuenta]' AND pitp.vigencia=$_POST[valor] AND pitp.idrecibo=titp.id_recaudo AND NOT(titp.estado='N' OR titp.estado='R') AND titp.fecha between '$fechaf' AND '$fechaf2' GROUP BY pitp.idrecibo";
			//echo $queryrecatrans;
			$result=mysql_query($queryrecatrans,$linkbd);
			while($row = mysql_fetch_row($result)){
				echo "<tr class='zebra1'>";
				echo "<td><input type='hidden' name='tiporec[]' id='tiporec[]' value='Recaudo Transferencia' />RECAUDO TRANSFERENCIA SGR</td>";
				echo "<td><input type='hidden' name='nrec[]' id='nrec[]' value='$row[0]' />$row[0]</td>";
				echo "<td><input type='hidden' name='fecrec[]' id='fecrec[]' value='$row[2]' />$row[2]</td>";
				echo "<td><input type='hidden' name='tliq[]' id='tliq[]' value='Recaudo transferencia SGR' />$row[0] - RECAUDO TRANSFERENCIA SGR</td>";
				echo "<td style='text-align:right'><input type='hidden' name='entrada[]' id='entrada[]' value='$row[3]' />$".number_format($row[3],2,',','.')."</td>";
				echo "<td style='text-align:right'><input type='hidden' name='salida[]' id='salida[]' value='0' />$".number_format(0,2,',','.')."</td>";
				echo "<td style='text-align:right'><input type='hidden' name='saldo[]' id='saldo[]' value='$row[3]' />$".number_format($row[3],2,',','.')."</td>";
				echo "</tr>";
				$sumaTotal+=$row[3];
			}


			$querysuperavit="SELECT ps.consvigencia,ps.vigencia,ps.fecha,SUM(psd.valor) FROM pptosuperavit ps, pptosuperavit_detalle psd WHERE psd.cuenta='$_POST[cuenta]' AND psd.vigencia=$_POST[valor] AND ps.consvigencia=psd.consvigencia AND NOT(ps.estado='N' OR psd.estado='R') AND ps.fecha between '$fechaf' AND '$fechaf2' GROUP BY psd.consvigencia";
			//echo $queryretencion;
			$result=mysql_query($querysuperavit,$linkbd);
			while($row = mysql_fetch_row($result)){
				echo "<tr class='zebra1'>";
				echo "<td><input type='hidden' name='tiporec[]' id='tiporec[]' value='Superavit' />SUPERAVIT</td>";
				echo "<td><input type='hidden' name='nrec[]' id='nrec[]' value='$row[0]' />$row[0]</td>";
				echo "<td><input type='hidden' name='fecrec[]' id='fecrec[]' value='$row[2]' />$row[2]</td>";
				echo "<td><input type='hidden' name='nliq[]' id='nliq[]' value='-' /><input type='hidden' name='tliq[]' id='tliq[]' value='Superavit' />-</td>";
					echo "<td style='text-align:right'><input type='hidden' name='entrada[]' id='entrada[]' value='$row[3]' />$".number_format($row[3],2,',','.')."</td>";
				echo "<td style='text-align:right'><input type='hidden' name='salida[]' id='salida[]' value='0' />$".number_format(0,2,',','.')."</td>";
				echo "<td style='text-align:right'><input type='hidden' name='saldo[]' id='saldo[]' value='$row[3]' />$".number_format($row[3],2,',','.')."</td>";
				echo "</tr>";
				$sumaTotal+=$row[3];
			}
			
		$queryreservas="SELECT ps.consvigencia,ps.vigencia,ps.fecha,SUM(psd.valor) FROM pptoreservas ps, pptoreservas_det psd WHERE psd.cuenta='$_POST[cuenta]' AND psd.vigencia=$_POST[valor] AND ps.consvigencia=psd.consvigencia AND NOT(ps.estado='N' OR psd.estado='R') AND ps.fecha between '$fechaf' AND '$fechaf2' GROUP BY psd.consvigencia";
			//echo $queryretencion;
			$result=mysql_query($queryreservas,$linkbd);
			while($row = mysql_fetch_row($result)){
				echo "<tr class='zebra1'>";
				echo "<td><input type='hidden' name='tiporec[]' id='tiporec[]' value='Reservas' />RESERVA</td>";
				echo "<td><input type='hidden' name='nrec[]' id='nrec[]' value='$row[0]' />$row[0]</td>";
				echo "<td><input type='hidden' name='fecrec[]' id='fecrec[]' value='$row[2]' />$row[2]</td>";
				echo "<td><input type='hidden' name='nliq[]' id='nliq[]' value='-' /><input type='hidden' name='tliq[]' id='tliq[]' value='Reserva' />-</td>";
					echo "<td style='text-align:right'><input type='hidden' name='entrada[]' id='entrada[]' value='$row[3]' />$".number_format($row[3],2,',','.')."</td>";
				echo "<td style='text-align:right'><input type='hidden' name='salida[]' id='salida[]' value='0' />$".number_format(0,2,',','.')."</td>";
				echo "<td style='text-align:right'><input type='hidden' name='saldo[]' id='saldo[]' value='$row[3]' />$".number_format($row[3],2,',','.')."</td>";
				echo "</tr>";
				$sumaTotal+=$row[3];
			}	
			$queryreservas="SELECT ps.consvigencia,ps.vigencia,ps.fecha,SUM(psd.valor) FROM pptoingresopresupuesto ps, pptoingresopresupuesto_det psd WHERE psd.cuenta='$_POST[cuenta]' AND psd.vigencia=$_POST[valor] AND ps.consvigencia=psd.consvigencia AND NOT(ps.estado='N' OR psd.estado='R') AND ps.fecha between '$fechaf' AND '$fechaf2' GROUP BY psd.consvigencia";
			//echo $queryretencion;
			$result=mysql_query($queryreservas,$linkbd);
			while($row = mysql_fetch_row($result)){
				echo "<tr class='zebra1'>";
				echo "<td><input type='hidden' name='tiporec[]' id='tiporec[]' value='Reservas' />INGRESO A PRESUPUESTO</td>";
				echo "<td><input type='hidden' name='nrec[]' id='nrec[]' value='$row[0]' />$row[0]</td>";
				echo "<td><input type='hidden' name='fecrec[]' id='fecrec[]' value='$row[2]' />$row[2]</td>";
				echo "<td><input type='hidden' name='nliq[]' id='nliq[]' value='-' /><input type='hidden' name='tliq[]' id='tliq[]' value='Reserva' />-</td>";
					echo "<td style='text-align:right'><input type='hidden' name='entrada[]' id='entrada[]' value='$row[3]' />$".number_format($row[3],2,',','.')."</td>";
				echo "<td style='text-align:right'><input type='hidden' name='salida[]' id='salida[]' value='0' />$".number_format(0,2,',','.')."</td>";
				echo "<td style='text-align:right'><input type='hidden' name='saldo[]' id='saldo[]' value='$row[3]' />$".number_format($row[3],2,',','.')."</td>";
				echo "</tr>";
				$sumaTotal+=$row[3];
			}
		$queryretencion="SELECT trc.id_egreso,trc.vigencia,trc.fecha,prc.valor FROM pptoretencionpago prc,tesoegresos trc WHERE prc.cuenta='$_POST[cuenta]' AND prc.vigencia=$_POST[valor] AND trc.id_egreso=prc.idrecibo AND NOT(trc.estado='N') AND prc.tipo='egreso' AND NOT EXISTS (SELECT 1 FROM tesoegresos tra WHERE tra.id_egreso=trc.id_egreso  AND tra.tipo_mov='401') AND trc.tipo_mov='201' AND trc.fecha between '$fechaf' AND '$fechaf2' ";
	
			$result=mysql_query($queryretencion,$linkbd);
			while($row = mysql_fetch_row($result)){
				echo "<tr class='zebra1'>";
				echo "<td><input type='hidden' name='tiporec[]' id='tiporec[]' value='Retencion Egreso' />RETENCION EGRESO</td>";
				echo "<td><input type='hidden' name='nrec[]' id='nrec[]' value='$row[0]' />$row[0]</td>";
				echo "<td><input type='hidden' name='fecrec[]' id='fecrec[]' value='$row[2]' />$row[2]</td>";
				echo "<td><input type='hidden' name='nliq[]' id='nliq[]' value='$row[0]' /><input type='hidden' name='tliq[]' id='tliq[]' value='Egreso' />$row[0] - EGRESO</td>";
				echo "<td style='text-align:right'><input type='hidden' name='entrada[]' id='entrada[]' value='$row[3]' />$".number_format($row[3],2,',','.')."</td>";
				echo "<td style='text-align:right'><input type='hidden' name='salida[]' id='salida[]' value='0' />$".number_format(0,2,',','.')."</td>";
				echo "<td style='text-align:right'><input type='hidden' name='saldo[]' id='saldo[]' value='$row[3]' />$".number_format($row[3],2,',','.')."</td>";
				echo "</tr>";
				$sumaTotal+=$row[3];
			}
			$queryretencion1="SELECT trc.id_orden,trc.vigencia,trc.fecha,prc.valor FROM pptoretencionpago prc,tesoordenpago trc WHERE prc.cuenta='$_POST[cuenta]' AND prc.vigencia=$_POST[valor] AND trc.id_orden=prc.idrecibo AND NOT(trc.estado='N') AND prc.tipo='orden' AND NOT EXISTS (SELECT 1 FROM tesoordenpago tca WHERE tca.id_orden=trc.id_orden  AND tca.tipo_mov='401') AND trc.tipo_mov='201' AND trc.fecha between '$fechaf' AND '$fechaf2' ";
			//echo $queryretencion;
			$result=mysql_query($queryretencion1,$linkbd);
			while($row = mysql_fetch_row($result)){
				echo "<tr class='zebra1'>";
				echo "<td><input type='hidden' name='tiporec[]' id='tiporec[]' value='Retencion Orden' />RETENCION ORDEN</td>";
				echo "<td><input type='hidden' name='nrec[]' id='nrec[]' value='$row[0]' />$row[0]</td>";
				echo "<td><input type='hidden' name='fecrec[]' id='fecrec[]' value='$row[2]' />$row[2]</td>";
				echo "<td><input type='hidden' name='nliq[]' id='nliq[]' value='$row[0]' /><input type='hidden' name='tliq[]' id='tliq[]' value='Orden' />$row[0] - ORDEN</td>";
					echo "<td style='text-align:right'><input type='hidden' name='entrada[]' id='entrada[]' value='$row[3]' />$".number_format($row[3],2,',','.')."</td>";
				echo "<td style='text-align:right'><input type='hidden' name='salida[]' id='salida[]' value='0' />$".number_format(0,2,',','.')."</td>";
				echo "<td style='text-align:right'><input type='hidden' name='saldo[]' id='saldo[]' value='$row[3]' />$".number_format($row[3],2,',','.')."</td>";
				echo "</tr>";
				$sumaTotal+=$row[3];
			}
			echo "<tr class='saludo1'>";
				echo "<td></td><td colspan='3'><center><b><input type='hidden' name='tiporec[]' id='tiporec[]' value='RECAUDO TOTAL' /><input type='hidden' name='nrec[]' id='nrec[]' value='**' />Total</b></center></td><td style='text-align:right'><input type='hidden' name='entrada[]' id='entrada[]' value='$sumaTotal' />$".number_format($sumaTotal,2,',','.')."</td><td style='text-align:right'><input type='hidden' name='salida[]' id='salida[]' value='0' />$".number_format(0.0,2,',','.')."</td><td style='text-align:right'><input type='hidden' name='saldo[]' id='saldo[]' value='$sumaTotal' />$".number_format($sumaTotal,2,',','.')."</td>";
			echo "</tr>";
				echo "</tbody></table></div>";
			

			}
			?> 
		
	</form>
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

</body>
</html>