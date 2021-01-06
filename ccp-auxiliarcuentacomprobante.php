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

		<script type="text/javascript">
			function buscacta(e)
			{
				if (document.form2.cuenta.value!="")
				{
					document.form2.bc.value=2;
					document.form2.submit();
				}
			}
			function excell(){
				document.form2.action="presu-auxiliarcuentacomprobanteexcel.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
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
	  				<a href="#" class="mgbt"><img src="imagenes/add2.png" title="Nuevo"/></a>
	  				<a href="#" class="mgbt" onClick="document.form2.submit();"><img src="imagenes/guardad.png" title="Guardar" /></a>
	  				<a href="#" onClick="document.form2.submit()" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
	  				<a href="#" onClick="mypop=window.open('ccp-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
	  				<a href="#" onclick="excell()" class="mgbt" title="Excel"><img src="imagenes/excel.png" title="excel"></a>
	  				<a href="ccp-ejecucionpresupuestal.php" class="mgbt"><img src="imagenes/iratras.png" title="Atras" /></a>
  				</td>
  				</tr>
		</table>

		<form name="form2" method="post" action="ccp-auxiliarcuentacomprobante.php">
		<?php
			$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
			$_POST[vigencia]=$vigusu;
			if($_POST[bc]!=''){
				$nresul=buscacuentapres($_POST[cuenta],2);			
				if($nresul!=''){
					$_POST[ncuenta]=$nresul;
					  $linkbd=conectar_bd();
					$sqlr="select vigencia, vigenciaf from pptocuentaspptoinicial where cuenta='$_POST[cuenta]' and (vigencia=".$vigusu." or vigenciaf='$vigusu')";
					$res=mysql_query($sqlr,$linkbd);
					$row=mysql_fetch_row($res);
					$_POST[valor]=$row[0];		  
					$_POST[valor2]=$row[1];		  			  
				}
				else{
					$_POST[ncuenta]="";	
				}
			}
		?>

		<table  align="center" class="inicio" >
			<tr >
				<td class="titulos" colspan="10">.: Auxilar por Cuenta Egresos</td>
				<td width="" class="cerrar"><a href="ccp-principal.php">Cerrar</a></td>
			</tr>
			<tr>
				<td class="saludo1">Cuenta:</td>
				<td  valign="middle" >
					<input type="text" id="cuenta" name="cuenta" size="8" style="width: 85%;" onKeyPress="javascript:return solonumeros(event)" 
					onKeyUp="return tabular(event,this)" onBlur="buscacta(event)" value="<?php echo $_POST[cuenta]?>" onClick="document.getElementById('cuenta').focus();document.getElementById('cuenta').select();">
					<input type="hidden" value="0" name="bc"><a href="#" onClick="mypop=window.open('cuentasppto-ventana.php?ti=2','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>
				</td>
				<td colspan="3">
					<input name="ncuenta" type="text" value="<?php echo $_POST[ncuenta]?>" style="width: 100%;" readonly> 
					<input name="oculto" type="hidden" value="1"> 
					<input name="valor" type="hidden" value="<?php echo $_POST[valor]?>"  readonly>
					<input name="valor2" type="hidden" value="<?php echo $_POST[valor2]?>"  readonly>
				</td>    
				<td  class="saludo1">Fecha Inicial:</td>
				<td >
					<input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10"><a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>        
				</td>
				<td class="saludo1">Fecha Final: </td>
				<td >
					<input name="fecha2" type="text" id="fc_1198971546" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha2]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10"><a href="#" onClick="displayCalendarFor('fc_1198971546');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>       
					<input type="button" name="generar" value="Generar" onClick="document.form2.submit()"> 
					<input type="hidden" value="1" name="oculto"> 
				</td>
			</tr>
			<tr>
				
				<td class="saludo1">Tipo Movimiento: </td>
				<td>
					<select name="tipomov" id="tipomov" style="width: 100%;" >
						<option value="" selected="">- Todas</option>
	          			<option value="1" <?php if($_POST[tipomov]=='201') echo 'selected'; ?> >Entrada</option>
	          			<option value="3" <?php if($_POST[tipomov]=='402') echo 'selected'; ?> >Reversado Parcial</option>
	          			<option value="2" <?php if($_POST[tipomov]=='401') echo 'selected'; ?> >Reversado Total</option>
	        		</select>
				</td>
				<td class="saludo1">Tipo Comprobante: </td>
				<td>
					<select name="tipocom" id="tipocom" style="width: 100%;">
						<option value="" selected="">- Todas</option>
	          			<option value="1" <?php if($_POST[tipocom]==1) echo 'selected'; ?> >APROPIACION INICIAL</option>
	          			<option value="2" <?php if($_POST[tipocom]==2) echo 'selected'; ?> >APROPIACION ADICIONES</option>
	          			<option value="3" <?php if($_POST[tipocom]==3) echo 'selected'; ?> >APROPIACION REDUCIONES</option>
	          			<option value="5" <?php if($_POST[tipocom]==5) echo 'selected'; ?> >APROPIACION TRASLADOS</option>
	          			<option value="6" <?php if($_POST[tipocom]==6) echo 'selected'; ?> >DISPONIBILIDAD CDP</option>
	          			<option value="7" <?php if($_POST[tipocom]==7) echo 'selected'; ?> >REGISTRO RP</option>
	          			<option value="8" <?php if($_POST[tipocom]==8) echo 'selected'; ?> >CUENTA POR PAGAR</option>
						<option value="9" <?php if($_POST[tipocom]==9) echo 'selected'; ?> >CUENTA POR PAGAR NOMINA</option>
						<option value="10" <?php if($_POST[tipocom]==10) echo 'selected'; ?> >EGRESO NOMINA</option>
	          			<option value="11" <?php if($_POST[tipocom]==11) echo 'selected'; ?> >EGRESO</option>
	        		</select>
				</td>
			</tr>     
		</table>

		<?php
			//**** busca cuenta
			if($_POST[bc]!='')
			{
				$nresul=buscacuentapres($_POST[cuenta],2);
				if($nresul!='')
				{
					$_POST[ncuenta]=$nresul;
					$linkbd=conectar_bd();
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
				<script>despliegamodalm('visible','0','Cuenta Incorrecta');</script>;
		<?php
					}
				}
		?>
			<div class="subpantallap" style="height:63%; width:99.6%; overflow-x:hidden;">
			  	<?php
					//**** para sacar la consulta del balance se necesitan estos datos ********
					//**** nivel, mes inicial, mes final, cuenta inicial, cuenta final, cc inicial, cc final  
					$oculto=$_POST['oculto'];
					if($_POST[oculto])
					{
						$_POST[tiporec]=array();
						$tots=0;
						$sumad=0;
						$sumac=0;	
						$pi=0;
						$pad=0;
						$pred=0;
						$ptra=0;
						$pdef=0;
						$cdps=0;
						$rps=0;
						$cxp=0;
						$pagos=0;

						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
						$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
						$fechaf2=$fecha[3]."-".$fecha[2]."-".$fecha[1];	
						//$ti=substr($_POST[cuenta],0,1);
						$ti=1;
						echo "<table class='inicio' ><tr><td colspan='8' class='titulos'>Auxiliar por Cuenta</td></tr>";
						echo "<tr><td class='titulos2' style='width: 11%;'>TIPO COMPROBANTE</td>
						<td class='titulos2' style='width: 5%;'>No Com.</td>
						<td class='titulos2' style='width: 5%;'>TIPO Mov.</td>
						<td class='titulos2' style='width: 5%;'>Doc. Rec.</td>
						<td class='titulos2' style='width: 10%;'>FECHA</td>
						<td class='titulos2' style='width: 60%;'>DETALLE</td>
						<td class='titulos2' style='width: 10%;'>DEBITO</td>
						<td class='titulos2' style='width: 10%;'>CREDITO</td>
						</tr>";		
						
						$iter='zebra1';
						$iter2='zebra2';

						$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
						//****ppto inicial
						//Todos
						//echo $_POST[tipomov];
						$tipocomScript="AND (pptocomprobante_det.tipo_comp='1' ||  pptocomprobante_det.tipo_comp='2' ||  pptocomprobante_det.tipo_comp='3' ||  pptocomprobante_det.tipo_comp='5' ||  pptocomprobante_det.tipo_comp='6' ||  pptocomprobante_det.tipo_comp='7' ||  pptocomprobante_det.tipo_comp='8' ||  pptocomprobante_det.tipo_comp='11' ||  pptocomprobante_det.tipo_comp='9') ";
						if($_POST[tipocom] && $_POST[tipomov]){
							$sqlr3="SELECT 
							pptocomprobante_det.cuenta,
							pptocomprobante_det.valdebito,
							pptocomprobante_det.valcredito, pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_cab.fecha,pptocomprobante_cab.concepto,pptotipo_comprobante.nombre, pptocomprobante_det.doc_receptor, pptocomprobante_det.tipomovimiento
							FROM pptocomprobante_det, pptocomprobante_cab, pptotipo_comprobante
							WHERE     pptocomprobante_cab.tipo_comp = pptocomprobante_det.tipo_comp
							AND pptocomprobante_det.numerotipo = pptocomprobante_cab.numerotipo
							AND pptocomprobante_cab.estado != 0
							AND pptocomprobante_det.estado != 0
							AND pptocomprobante_det.vigencia='$vigusu'
							AND pptocomprobante_det.tipomovimiento='$_POST[tipomov]'
							AND pptocomprobante_det.tipo_comp='$_POST[tipocom]'
							AND pptotipo_comprobante.id_tipo=pptocomprobante_det.tipo_comp
							AND pptocomprobante_det.cuenta='$_POST[cuenta]'
							AND pptocomprobante_cab.fecha BETWEEN '$fechaf' AND '$fechaf2'";
						}else if($_POST[tipocom]){
							$sqlr3="SELECT 
							pptocomprobante_det.cuenta,
							pptocomprobante_det.valdebito,
							pptocomprobante_det.valcredito, pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_cab.fecha,pptocomprobante_cab.concepto,pptotipo_comprobante.nombre, pptocomprobante_det.doc_receptor, pptocomprobante_det.tipomovimiento
							FROM pptocomprobante_det, pptocomprobante_cab, pptotipo_comprobante
							WHERE     pptocomprobante_cab.tipo_comp = pptocomprobante_det.tipo_comp
							AND pptocomprobante_det.numerotipo = pptocomprobante_cab.numerotipo
							AND pptocomprobante_cab.estado != 0
							AND pptocomprobante_det.estado != 0
							AND pptocomprobante_det.vigencia='$vigusu'
							AND pptocomprobante_det.tipo_comp='$_POST[tipocom]'
							AND pptotipo_comprobante.id_tipo=pptocomprobante_det.tipo_comp
							AND pptocomprobante_det.cuenta='$_POST[cuenta]'
							AND pptocomprobante_cab.fecha BETWEEN '$fechaf' AND '$fechaf2'";
							
							//echo $sqlr3;
						}else if($_POST[tipomov]){
							$sqlr3="SELECT 
							pptocomprobante_det.cuenta,
							pptocomprobante_det.valdebito,
							pptocomprobante_det.valcredito, pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_cab.fecha,pptocomprobante_cab.concepto,pptotipo_comprobante.nombre, pptocomprobante_det.doc_receptor, pptocomprobante_det.tipomovimiento
							FROM pptocomprobante_det, pptocomprobante_cab, pptotipo_comprobante
							WHERE     pptocomprobante_cab.tipo_comp = pptocomprobante_det.tipo_comp
							AND pptocomprobante_det.numerotipo = pptocomprobante_cab.numerotipo
							AND pptocomprobante_cab.estado != 0
							AND pptocomprobante_det.estado != 0
							AND pptocomprobante_det.vigencia='$vigusu'
							AND pptocomprobante_det.tipomovimiento='$_POST[tipomov]'
							AND pptotipo_comprobante.id_tipo=pptocomprobante_det.tipo_comp
							AND pptocomprobante_det.cuenta='$_POST[cuenta]'
							$tipocomScript
							AND pptocomprobante_cab.fecha BETWEEN '$fechaf' AND '$fechaf2'";
							
						}
						else{
							$sqlr3="SELECT 
							pptocomprobante_det.cuenta,
							pptocomprobante_det.valdebito,
							pptocomprobante_det.valcredito, pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_cab.fecha,pptocomprobante_cab.concepto,pptotipo_comprobante.nombre, pptocomprobante_det.doc_receptor, pptocomprobante_det.tipomovimiento
							FROM pptocomprobante_det, pptocomprobante_cab, pptotipo_comprobante
							WHERE     pptocomprobante_cab.tipo_comp = pptocomprobante_det.tipo_comp
							AND pptocomprobante_det.numerotipo = pptocomprobante_cab.numerotipo
							AND pptocomprobante_cab.estado != 0
							AND pptocomprobante_det.estado != 0
							AND pptocomprobante_det.vigencia='$vigusu'
							AND pptotipo_comprobante.id_tipo=pptocomprobante_det.tipo_comp
							AND pptocomprobante_det.cuenta='$_POST[cuenta]' 
							$tipocomScript
							AND pptocomprobante_cab.fecha BETWEEN '$fechaf' AND '$fechaf2'";
							
						}
						$res=mysql_query($sqlr3,$linkbd);
						$valdebito=0;
						$valcredito=0;
						
						while($row =mysql_fetch_row($res))
						{
							echo "<tr class='$iter'>
							<td ><input type='hidden' name='tiporec[]' value='Apropiacion Inicial'>$row[7]</td>
							<td style='text-align: center;'><input type='hidden' name='com[]' value='$row[4]'>$row[4]</td>
							<td style='text-align: center;'><input type='hidden' name='mov[]' value='$row[9]'>$row[9]</td>
							<td style='text-align: center;'><input type='hidden' name='rec[]' value='$row[8]'>$row[8]</td>
							<td ><input type='hidden' name='fecrec[]' value='$row[5]'>$row[5]</td>
							<td ><input type='hidden' name='detalle[]' value='$row[6]'>$row[6]</td>
							<td style='text-align: right;'><input type='hidden' name='debito[]' value='$row[1]'>$".number_format($row[1],2)."</td>
							<td style='text-align: right;'><input type='hidden' name='credito[]' value='$row[2]'>$".number_format($row[2],2)."</td></tr>";	 
							$pi+=$row[1];
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux; 
							$valdebito+=$row[1];
							$valcredito+=$row[2];
						}
						echo "<tr class='$iter'>
						<td class='titulos2' colspan='6' style='text-align: center;' ><b>Total</b></td>
						<td class='titulos2' style='text-align: right;'><input type='hidden' name='totaldebito[]' value='$valdebito'>$".number_format($valdebito,2)."</td>
						<td class='titulos2' style='text-align: right;'><input type='hidden' name='totalcredito[]' value='$valcredito'>$".number_format($valcredito,2)."</td>
						</tr>";
						
					}
					?>
			</div>
		</form>
	</body>
</html>



