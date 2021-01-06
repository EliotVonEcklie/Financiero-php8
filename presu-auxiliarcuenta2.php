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
			<tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("presu");?></tr>
          	<tr>
  				<td colspan="3" class="cinta">
					<a href="#" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a> 
					<a href="#" onClick="document.form2.submit();" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a> 
					<a href="#" onClick="document.form2.submit()" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a> 
					<a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a> <a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png" title="imprimir"></a> 
					<a href="#"   onClick="excell()" class="mgbt"><img src="imagenes/excel.png" titlw="excel"></a> 
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
	<form name="form2" method="post" action="presu-auxiliarcuenta2.php">
		<?php
		$linkbd=conectar_bd();
		
		$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
		$_POST[vigencia]=$vigusu;
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
				<td class="cerrar"><a href="presu-principal.php">Cerrar</a></td>
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
    
		<div class="subpantallap" style="height:67%; width:99.8%; overflow-x:hidden;">
			<?php
			//**** para sacar la consulta del balance se necesitan estos datos ********
			//**** nivel, mes inicial, mes final, cuenta inicial, cuenta final, cc inicial, cc final  
			$oculto=$_POST['oculto'];
			if($correcto==1)
			{
				$_POST[tiporec]=array();
		//		$_POST[valrec]=array();
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
				echo "<table class='inicio' >
					<tr>
						<td colspan='6' class='titulos'>Auxiliar por Cuenta</td>
					</tr>";
					echo "<tr>
						<td class='titulos2'>TIPO COMPROBANTE</td>
						<td class='titulos2'>No COMPROBANTE</td>
						<td class='titulos2'>No LIQUIDACION</td>
						<td class='titulos2'>FECHA</td>
						<td class='titulos2'>TERCERO</td>
						<td class='titulos2'>VALOR</td>
					</tr>";
				//$nc=buscacuentap($_POST[cuenta]);
				$linkbd=conectar_bd();
				$iter='zebra1';
				$iter2='zebra2';
				//****ppto inicial
				//año anterior
				if($todos==0){
				//*** todos los ingresos AÑO ANTERIOR***
					$sqlr3="SELECT 
					pptocomprobante_det.cuenta,
					pptocomprobante_det.valdebito,
					pptocomprobante_det.valcredito,pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_cab.fecha,pptocomprobante_det.tercero 
					FROM pptocomprobante_det, pptocomprobante_cab, pptotipo_comprobante
					WHERE pptocomprobante_cab.tipo_comp = pptocomprobante_det.tipo_comp
					AND pptocomprobante_det.numerotipo = pptocomprobante_cab.numerotipo
					AND pptocomprobante_cab.estado = 1
					AND (pptocomprobante_det.valdebito > 0
					OR pptocomprobante_det.valcredito > 0)			   
					AND
					(pptocomprobante_cab.VIGENCIA=".$_POST[valor]." or pptocomprobante_cab.VIGENCIA=".$_POST[valor2].")
					and(pptocomprobante_det.VIGENCIA=".$_POST[valor]." or pptocomprobante_det.VIGENCIA=".$_POST[valor2].")
					and pptocomprobante_cab.VIGENCIA=pptocomprobante_det.VIGENCIA
					AND pptocomprobante_cab.fecha BETWEEN '$fechafa' AND '$fechaf2a'
					AND pptocomprobante_cab.tipo_comp = pptotipo_comprobante.codigo 
					AND (pptotipo_comprobante.tipo = 'I' or pptotipo_comprobante.tipo = 'D')		   
					AND pptocomprobante_det.cuenta = '".$_POST[cuenta]."' 			  
					ORDER BY pptocomprobante_det.cuenta, pptocomprobante_cab.fecha,pptocomprobante_det.tipo_comp,pptocomprobante_cab.numerotipo";
	   	    
					// echo $sqlr3;
					//echo $sqlr;
					$totsa=0;
					$res=mysql_query($sqlr3,$linkbd);
					while($row =mysql_fetch_row($res))
					{	
						$totsa+=$row[1];	
					}
					$pi=$totsa;					
					echo "<tr class='saludo2'>
						<td colspan='4'>
							<input type='hidden' name='tiporec[]' value=''>
							<input type='hidden' name='nrec[]' value=''>
							<input type='hidden' name='fecrec[]' value=''>
							<input type='hidden' name='tliq[]' value=''>
							<input type='hidden' name='nliq[]' value=''>
							<input type='hidden' name='terrec[]' value='SUBTOTAL APROPIACION INICIAL'>
							<input type='hidden' name='valrec[]' value='$pi'>
						</td>
						<td colspan='1'>Subtotal Apropiacion Inicial</td>
						<td align='right'>$".number_format($pi,2,',','.')."</td>
					</tr>";
					$pdef+=$pi;
				}
				//fin año anterior
				//un solo año
				else{
					$sqlr3="SELECT DISTINCT
					pptocomprobante_det.cuenta,
					pptocomprobante_det.valdebito,
					pptocomprobante_det.valcredito, pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_cab.fecha
					FROM pptocomprobante_det, pptocomprobante_cab
					WHERE pptocomprobante_cab.tipo_comp = pptocomprobante_det.tipo_comp
					AND pptocomprobante_det.numerotipo = pptocomprobante_cab.numerotipo
					AND pptocomprobante_cab.estado = 1
					AND ( pptocomprobante_det.valdebito > 0
					OR pptocomprobante_det.valcredito > 0)			   
					AND
					(pptocomprobante_cab.VIGENCIA=".$_POST[valor]." or pptocomprobante_cab.VIGENCIA=".$_POST[valor2].")
					and(pptocomprobante_det.VIGENCIA=".$_POST[valor]." or pptocomprobante_det.VIGENCIA=".$_POST[valor2].")
					and pptocomprobante_cab.VIGENCIA=pptocomprobante_det.VIGENCIA
					AND pptocomprobante_cab.fecha BETWEEN '$fechaf' AND '$fechaf2'
					AND pptocomprobante_det.tipo_comp = 1 
					AND pptocomprobante_cab.tipo_comp = 1 		  
					AND pptocomprobante_det.cuenta = '".$_POST[cuenta]."' 		 
					ORDER BY pptocomprobante_cab.fecha,pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_det.cuenta";
	// echo "<br>".$sqlr3;
					$res=mysql_query($sqlr3,$linkbd);
					while($row =mysql_fetch_row($res))
					{
						echo "<tr class='$iter'>
							<td ><input type='hidden' name='tiporec[]' value='Apropiacion Inicial'>Apropiacion Inicial</td>
							<td ><input type='hidden' name='nrec[]' value='$row[4]'>$row[4]</td>
							<td ><input type='hidden' name='tliq[]' value=''><input type='hidden' name='nliq[]' value=''></td>
							<td ><input type='hidden' name='fecrec[]' value='$row[5]'>$row[5]</td>
							<td ><input type='hidden' name='terrec[]' value='PPTO INICIAL'>".$tercero." PPTO INICIAL</td>
							<td align='right' ><input type='hidden' name='valrec[]' value='$row[1]'>".number_format($row[1],2,',','.')."</td>
						</tr>";	 
						$pi+=$row[1];
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux; 
					}
					echo "<tr class='saludo2'>
						<td colspan='4'>
							<input type='hidden' name='tiporec[]' value=''>
							<input type='hidden' name='nrec[]' value=''>
							<input type='hidden' name='fecrec[]' value=''>
							<input type='hidden' name='tliq[]' value=''>
							<input type='hidden' name='nliq[]' value=''>
							<input type='hidden' name='terrec[]' value='SUBTOTAL APROPIACION INICIAL'>
							<input type='hidden' name='valrec[]' value='$pi'>
						</td>
						<td colspan='1'>Subtotal Apropiacion Inicial</td>
						<td align='right'>$".number_format($pi,2,',','.')."</td>
					</tr>";
					$pdef+=$pi;
				}//fin un solo año
				//****ppto Adicion
				$sqlr3="SELECT DISTINCT
				pptocomprobante_det.cuenta,
				pptocomprobante_det.valdebito,
				pptocomprobante_det.valcredito, pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_cab.fecha
				FROM pptocomprobante_det, pptocomprobante_cab
				WHERE pptocomprobante_cab.tipo_comp = pptocomprobante_det.tipo_comp
				AND pptocomprobante_det.numerotipo = pptocomprobante_cab.numerotipo
				AND pptocomprobante_cab.estado = 1
				AND (   pptocomprobante_det.valdebito > 0
				OR pptocomprobante_det.valcredito > 0)			   
				AND
				(pptocomprobante_cab.VIGENCIA=".$_POST[valor]." or pptocomprobante_cab.VIGENCIA=".$_POST[valor2].")
				and(pptocomprobante_det.VIGENCIA=".$_POST[valor]." or pptocomprobante_det.VIGENCIA=".$_POST[valor2].")
				and pptocomprobante_cab.VIGENCIA=pptocomprobante_det.VIGENCIA
				AND pptocomprobante_cab.fecha BETWEEN '$fechaf' AND '$fechaf2'
				AND pptocomprobante_det.tipo_comp = 2 
				AND pptocomprobante_cab.tipo_comp = 2 		  
				AND pptocomprobante_det.cuenta = '".$_POST[cuenta]."' 		  
				ORDER BY pptocomprobante_cab.fecha,pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_det.cuenta";
				// echo "<br>".$sqlr3;
				$res=mysql_query($sqlr3,$linkbd);
				while($row =mysql_fetch_row($res))
				{
					echo "<tr class='$iter'>
						<td ><input type='hidden' name='tiporec[]' value='Adicion'>Adicion</td>
						<td ><input type='hidden' name='nrec[]' value='$row[4]'>$row[4]</td>
						<td ><input type='hidden' name='tliq[]' value=''><input type='hidden' name='nliq[]' value=''></td>
						<td ><input type='hidden' name='fecrec[]' value='$row[5]'>$row[5]</td>
						<td ><input type='hidden' name='terrec[]' value='ADICION PPTAL'>".$tercero."ADICION PPTAL</td>
						<td align='right' ><input type='hidden' name='valrec[]' value='$row[1]'>".number_format($row[1],2,',','.')."</td>
					</tr>";	 
					$pad+=$row[1];
					$aux=$iter;
					$iter=$iter2;
					$iter2=$aux; 
				}
				echo "<tr class='saludo2'>
					<td colspan='4'></td>
					<td colspan='1'>
						<input type='hidden' name='tiporec[]' value=''>
						<input type='hidden' name='nrec[]' value=''>
						<input type='hidden' name='fecrec[]' value=''>
						<input type='hidden' name='tliq[]' value=''>
						<input type='hidden' name='nliq[]' value=''>
						<input type='hidden' name='terrec[]' value='SUBTOTAL ADICIONES'>
						<input type='hidden' name='valrec[]' value='$pad'></td>
						<td align='right'>$".number_format($pad,2,',','.')."</td>
					</tr>";
				$pdef+=$pad;
	
				//****ppto Reducciones
				$sqlr3="SELECT DISTINCT
				pptocomprobante_det.cuenta,
				pptocomprobante_det.valdebito,
				pptocomprobante_det.valcredito, pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_cab.fecha
				FROM pptocomprobante_det, pptocomprobante_cab
				WHERE pptocomprobante_cab.tipo_comp = pptocomprobante_det.tipo_comp
				AND pptocomprobante_det.numerotipo = pptocomprobante_cab.numerotipo
				AND pptocomprobante_cab.estado = 1
				AND (pptocomprobante_det.valdebito > 0
				OR pptocomprobante_det.valcredito > 0)			   
				AND
				(pptocomprobante_cab.VIGENCIA=".$_POST[valor]." or pptocomprobante_cab.VIGENCIA=".$_POST[valor2].")
				and(pptocomprobante_det.VIGENCIA=".$_POST[valor]." or pptocomprobante_det.VIGENCIA=".$_POST[valor2].")
				and pptocomprobante_cab.VIGENCIA=pptocomprobante_det.VIGENCIA
				AND pptocomprobante_cab.fecha BETWEEN '$fechaf' AND '$fechaf2'
				AND pptocomprobante_det.tipo_comp = 3 
				AND pptocomprobante_cab.tipo_comp = 3 		  
				AND pptocomprobante_det.cuenta = '".$_POST[cuenta]."' 		  
				ORDER BY pptocomprobante_cab.fecha,pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_det.cuenta";
  // echo "<br>".$sqlr3;
				$res=mysql_query($sqlr3,$linkbd);
				while($row =mysql_fetch_row($res))
				{
					echo "<tr class='$iter'>
						<td ><input type='hidden' name='tiporec[]' value='Reducciones'>Reducciones</td>
						<td ><input type='hidden' name='nrec[]' value='$row[4]'>$row[4]</td>
						<td ><input type='hidden' name='tliq[]' value=''><input type='hidden' name='nliq[]' value=''></td>
						<td ><input type='hidden' name='fecrec[]' value='$row[5]'>$row[5]</td>
						<td ><input type='hidden' name='terrec[]' value='REDUCCION PPTAL'>".$tercero."REDUCCION PPTAL</td>
						<td align='right' ><input type='hidden' name='valrec[]' value='$row[1]'>".number_format($row[1],2,',','.')."</td>
					</tr>";	 
					$pred+=$row[2];
					$aux=$iter;
					$iter=$iter2;
					$iter2=$aux; 
				}
				echo "<tr class='saludo1'>
					<td colspan='4'></td>
					<td colspan='1'>
						<input type='hidden' name='tiporec[]' value=''>
						<input type='hidden' name='nrec[]' value=''>
						<input type='hidden' name='fecrec[]' value=''>
						<input type='hidden' name='terrec[]' value='SUBTOTAL REDUCCIONES'>
						<input type='hidden' name='valrec[]' value='$pred'>
						<input type='hidden' name='tliq[]' value=''>
						<input type='hidden' name='nliq[]' value=''>Subtotal Reducciones
					</td>
					<td align='right'>$".number_format($pred,2,',','.')."</td>
				</tr>";
				$pdef-=$pred;	   
	   
				echo "<tr class='saludo2'>
					<td colspan='4'></td>
					<td colspan='1'>
						<input type='hidden' name='tiporec[]' value=''>
						<input type='hidden' name='nrec[]' value=''>
						<input type='hidden' name='fecrec[]' value=''>
						<input type='hidden' name='tliq[]' value=''>
						<input type='hidden' name='nliq[]' value=''>
						<input type='hidden' name='terrec[]' value='PRESUPUESTO DEFINITIVO'>
						<input type='hidden' name='valrec[]' value='$pdef'>PRESUPUESTO DEFINITIVO
					</td>
					<td align='right'>$".number_format($pdef,2,',','.')."</td>
				</tr>";		
	//*** todos los ingresos ***
				$sqlr3="SELECT 
				pptocomprobante_det.cuenta,
				pptocomprobante_det.valdebito,
				pptocomprobante_det.valcredito,pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_cab.fecha,pptocomprobante_det.tercero 
				FROM pptocomprobante_det, pptocomprobante_cab, pptotipo_comprobante
				WHERE pptocomprobante_cab.tipo_comp = pptocomprobante_det.tipo_comp
				AND pptocomprobante_det.numerotipo = pptocomprobante_cab.numerotipo
				AND pptocomprobante_cab.estado = 1
				AND (pptocomprobante_det.valdebito > 0
				OR pptocomprobante_det.valcredito > 0)			   
				AND
				(pptocomprobante_cab.VIGENCIA=".$_POST[valor]." or pptocomprobante_cab.VIGENCIA=".$_POST[valor2].")
				and(pptocomprobante_det.VIGENCIA=".$_POST[valor]." or pptocomprobante_det.VIGENCIA=".$_POST[valor2].")
				and pptocomprobante_cab.VIGENCIA=pptocomprobante_det.VIGENCIA
				AND pptocomprobante_cab.fecha BETWEEN '$fechaf' AND '$fechaf2'
				AND pptocomprobante_cab.tipo_comp = pptotipo_comprobante.codigo 
				AND (pptotipo_comprobante.tipo = 'I' or pptotipo_comprobante.tipo = 'D')		   
				AND pptocomprobante_det.cuenta = '".$_POST[cuenta]."' 			  
				ORDER BY pptocomprobante_det.cuenta, pptocomprobante_cab.fecha,pptocomprobante_det.tipo_comp,pptocomprobante_cab.numerotipo";
	   	    
				// echo $sqlr3;
				//echo $sqlr;
				$res=mysql_query($sqlr3,$linkbd);
				while($row =mysql_fetch_row($res))
				{	
					$tercero=buscatercero($row[6]);
					$nomcomp=buscacomprobanteppto($row[3]);
					SWITCH ($row[3])
					{
						CASE 16:
							$nliq="";
							$tipoliq="";
							$sqlr="select id_recaudo,tipo from tesoreciboscaja where id_recibos=$row[4]";
							//echo $sqlr;
							$res2=mysql_query($sqlr,$linkbd);
							$rowr =mysql_fetch_row($res2);
							$nliq=$rowr[0];
							if($rowr[1]==1)		 
								$tipoliq="PREDIAL";
							if($rowr[1]==2)		 
								$tipoliq="INDUSTRIA Y COMERCIO";
							if($rowr[1]==3)		 
								$tipoliq="OTROS RECAUDOS";
						break;
						CASE 17:
							$nliq="";
							$tipoliq="";
							 /*$sqlr="select id_recaudo,tipo from tesoreciboscaja where id_recibos=$row[4]";
							 //echo $sqlr;
							 $res2=mysql_query($sqlr,$linkbd);
							 $rowr =mysql_fetch_row($res2);
							 $nliq=$rowr[0];*/
						break;
						CASE 18:
							$nliq="";
							$tipoliq="";
							$sqlr="select id_recaudo,tipo from tesosinreciboscaja where id_recibos=$row[4]";
							//echo $sqlr;
							$res2=mysql_query($sqlr,$linkbd);
							$rowr =mysql_fetch_row($res2);
							$nliq=$rowr[0];
							$tipoliq="INGRESOS INTERNO";
						break;
						CASE 19:
							$nliq="";
							$tipoliq="";
							$sqlr="select idcomp,tipo from tesoreciboscaja where id_recibos=$row[4]";
							//echo $sqlr;
							$res2=mysql_query($sqlr,$linkbd);
							$rowr =mysql_fetch_row($res2);
							$nliq=$rowr[0];
							$tipoliq="RECAUDO TRANSFERENCIA";
						break;
						CASE 20:
							$nliq="";
							$tipoliq="";
						break;
						CASE 21:
							$nliq="";
							$tipoliq="";
						break;
						CASE 22:
							$nliq="";
							$tipoliq="";
						break;
					}
	 
					echo "<tr class='$iter'>
						<td ><input type='hidden' name='tiporec[]' value='$nomcomp'>$nomcomp</td>
						<td ><input type='hidden' name='nrec[]' value='$row[4]'>$row[4]</td>
						<td >
							<input type='hidden' name='tliq[]' value='$tipoliq'>
							<input type='hidden' name='nliq[]' value='$nliq'>$tipoliq - $nliq
						</td>
						<td><input type='hidden' name='fecrec[]' value='$row[5]'>$row[5]</td>
						<td ><input type='hidden' name='terrec[]' value='$tercero'>".$tercero."</td>
						<td align='right' ><input type='hidden' name='valrec[]' value='$row[1]'>".number_format($row[1],2)."</td>
					</tr>";	 
					$tots+=$row[1];	
					$aux=$iter;
					$iter=$iter2;
					$iter2=$aux; 
				}		 
				$sumad=0;
				//echo "<tr><td colspan='4'></td><td>Total:</td><td class='saludo1'>$".number_format( array_sum($_POST[valrec]),2)."</td></tr>";
				echo "<tr>
					<td colspan='4'></td>
					<td>Total Ingresos:</td>
					<td class='saludo1' align='right'>
						<input type='hidden' name='toting' value='$tots'>
						$".number_format($tots,2,',','.')."
					</td>
				</tr>";
				$saldo=$pdef-$tots;
				//echo "<tr><td colspan='4'></td><td>Total:</td><td class='saludo1'>$".number_format( array_sum($_POST[valrec]),2)."</td></tr>";
				echo "<tr class='saludo1'>
					<td colspan='4'></td>
					<td>
						<input type='hidden' name='tiporec[]' value=''>
						<input type='hidden' name='nrec[]' value=''>
						<input type='hidden' name='fecrec[]' value=''>
						<input type='hidden' name='terrec[]' value='SALDO POR RECAUDAR (Pres Def - Ingresos)'>
						<input type='hidden' name='valrec[]' value='$saldo'>Saldo Por Recaudar (Pres Def - Ingresos):
					</td>
					<td align='right' >
						$".number_format($saldo,2,',','.')."
					</td>
				</tr>
			</table>";
			}
			?> 
		</div>
	</form>
</body>
</html>