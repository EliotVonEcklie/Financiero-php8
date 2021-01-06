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
            <tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("presu");?></tr>
        	<tr>
  				<td colspan="3" class="cinta">
	  				<a href="#" class="mgbt"><img src="imagenes/add2.png" title="Nuevo"/></a>
	  				<a href="#" class="mgbt" onClick="document.form2.submit();"><img src="imagenes/guardad.png" title="Guardar" /></a>
	  				<a href="#" onClick="document.form2.submit()" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
	  				<a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
	  				<a href="#" onclick="excell()" class="mgbt" title="Excel"><img src="imagenes/excel.png" title="excel"></a>
	  				<a href="presu-ejecucionpresupuestal.php" class="mgbt"><img src="imagenes/iratras.png" title="Atras" /></a>
  				</td>
  				</tr>
		</table>

		<form name="form2" method="post" action="presu-estadoregistro.php">
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
				<td class="titulos" colspan="10">.: Estado de Registro</td>
				<td width="" class="cerrar"><a href="presu-principal.php">Cerrar</a></td>
			</tr>
			<tr>
				<td class="saludo1">Estado: </td>
				<td>
					<select name="tipoestado" id="tipoestado" style="width: 100%;">
						<option value="" selected="">- Seleccione...</option>
	          			<option value="1" <?php if($_POST[tipoestado]==1) echo 'selected'; ?> >Disponibles</option>
	          			<option value="2" <?php if($_POST[tipoestado]==2) echo 'selected'; ?> >No Encontrado</option>
	          			<option value="3" <?php if($_POST[tipoestado]==3) echo 'selected'; ?> >Incompletos</option>
	          			<option value="4" <?php if($_POST[tipoestado]==4) echo 'selected'; ?> >Vacios</option>
	        		</select>
				</td>
				<td class="saludo1">Tipo Comprobante: </td>
				<td>
					<select name="tipocom" id="tipocom" style="width: 100%;">
						<option value="" selected="">- Todas</option>
	          			<option value="2" <?php if($_POST[tipocom]==2) echo 'selected'; ?> >APROPIACION ADICIONES</option>
	          			<option value="3" <?php if($_POST[tipocom]==3) echo 'selected'; ?> >APROPIACION REDUCIONES</option>
	          			<option value="5" <?php if($_POST[tipocom]==5) echo 'selected'; ?> >APROPIACION TRASLADOS</option>
	          			<option value="6" <?php if($_POST[tipocom]==6) echo 'selected'; ?> >DISPONIBILIDAD CDP</option>
	          			<option value="7" <?php if($_POST[tipocom]==7) echo 'selected'; ?> >REGISTRO RP</option>
	          			<option value="8" <?php if($_POST[tipocom]==8) echo 'selected'; ?> >CUENTA POR PAGAR</option>
	          			<option value="11" <?php if($_POST[tipocom]==11) echo 'selected'; ?> >EGRESO</option>
	        		</select>
				</td>
				<td  class="saludo1">Fecha Inicial:</td>
				<td >
					<input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10"><a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/calendario04.png" style="width: 20px;" align="absmiddle" border="0"></a>        
				</td>
				<td class="saludo1">Fecha Final: </td>
				<td >
					<input name="fecha2" type="text" id="fc_1198971546" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha2]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10"><a href="#" onClick="displayCalendarFor('fc_1198971546');"><img src="imagenes/calendario04.png" style="width: 20px;" align="absmiddle" border="0"></a>       
					<input type="button" name="generar" value="Generar" onClick="document.form2.submit()"> 
					<input type="hidden" value="1" name="oculto"> 
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
				<script>alert("Cuenta Incorrecta");document.form2.cuenta.focus();</script>
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
						
						$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
						//****ppto inicial
						//Todos
						//echo $_POST[tipomov];
						$tipocomScript="AND (pptocomprobante_det.tipo_comp='2' ||  pptocomprobante_det.tipo_comp='3' ||  pptocomprobante_det.tipo_comp='5' ||  pptocomprobante_det.tipo_comp='6' ||  pptocomprobante_det.tipo_comp='7' ||  pptocomprobante_det.tipo_comp='8' ||  pptocomprobante_det.tipo_comp='11') ";
						if($_POST[tipocom] && $_POST[tipoestado]){

							//Disponibles----------------------------------------------------------------
							if($_POST[tipoestado]=='1' && ($_POST[tipocom]=='6' || $_POST[tipocom]=='7' || $_POST[tipocom]=='8')){
								$sqlr3="SELECT 
								pptocomprobante_det.cuenta,
								pptocomprobante_det.valdebito,
								pptocomprobante_det.valcredito, pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_cab.fecha,pptocomprobante_cab.concepto,pptotipo_comprobante.nombre, pptocomprobante_det.doc_receptor, pptocomprobante_det.tipomovimiento
								FROM pptocomprobante_det, pptocomprobante_cab, pptotipo_comprobante
								WHERE pptocomprobante_cab.tipo_comp = pptocomprobante_det.tipo_comp
								AND pptocomprobante_det.numerotipo = pptocomprobante_cab.numerotipo
								AND pptocomprobante_det.estado != 0
								AND pptocomprobante_det.vigencia='$vigusu'
								AND pptotipo_comprobante.id_tipo=pptocomprobante_det.tipo_comp						
								AND pptocomprobante_det.tipo_comp='$_POST[tipocom]'
								AND pptocomprobante_cab.fecha BETWEEN '$fechaf' AND '$fechaf2'
								ORDER BY pptocomprobante_det.tipo_comp ASC ,  pptocomprobante_det.numerotipo ASC";
								/*
								$sqlr3="SELECT
								pptocomprobante_det.cuenta,
								pptocomprobante_det.valdebito,
								pptocomprobante_det.valcredito, pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_cab.fecha,
								pptocomprobante_cab.concepto,pptotipo_comprobante.nombre, pptocomprobante_det.doc_receptor, pptocomprobante_det.tipomovimiento
								FROM pptocomprobante_det, pptocomprobante_cab, pptotipo_comprobante
								WHERE pptocomprobante_cab.tipo_comp = pptocomprobante_det.tipo_comp
								AND pptocomprobante_det.numerotipo = pptocomprobante_cab.numerotipo
								AND pptocomprobante_det.estado != 0
								AND pptocomprobante_det.vigencia='$vigusu'
								AND pptotipo_comprobante.id_tipo=pptocomprobante_det.tipo_comp						
								AND pptocomprobante_det.tipo_comp='$_POST[tipocom]'
								AND pptocomprobante_cab.fecha BETWEEN '$fechaf' AND '$fechaf2'
								ORDER BY pptocomprobante_det.tipo_comp ASC, pptocomprobante_cab.numerotipo ASC, pptocomprobante_det.numerotipo ASC";*/
							}else if($_POST[tipoestado]=='2'){//No Encontrado---------------------------------------------------
								$sqlr3="SELECT * FROM pptocomprobante_cab 
									WHERE pptocomprobante_cab.vigencia='$vigusu' AND tipo_comp!='1'
									ORDER BY tipo_comp, numerotipo";

							}else if($_POST[tipoestado]=='3'){//Incompletos------------------------------------------------------
								$sqlr3="SELECT * 
								FROM pptocomprobante_det
								WHERE tercero=''
								OR detalle=''
								OR ((valdebito='0') AND (valcredito='0'))
								OR estado=''
								OR vigencia=''
								OR (tipo_comp='0' OR tipo_comp='')
								OR (numerotipo='0' OR numerotipo='')
								OR doc_receptor=''";
								
							}else if($_POST[tipoestado]=='4'){//Vacios----------------------------------------
								$sqlr3="SELECT * FROM pptocomprobante_cab WHERE pptocomprobante_cab.estado!='0' AND pptocomprobante_cab.vigencia='$vigusu' AND pptocomprobante_cab.tipo_comp='$_POST[tipocom]' AND pptocomprobante_cab.fecha BETWEEN '$fechaf' AND '$fechaf2' ORDER BY tipo_comp, numerotipo";
							}
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
							AND pptocomprobante_det.valcredito!='0'
							AND pptotipo_comprobante.id_tipo=pptocomprobante_det.tipo_comp
							AND pptocomprobante_cab.fecha BETWEEN '$fechaf' AND '$fechaf2'";
							
							//echo $sqlr3;
						}else if($_POST[tipoestado]){
							//Disponibles
							if($_POST[tipoestado]=='1'){//Disponibles--------------------------------------------------------
								$sqlr3="SELECT 
								pptocomprobante_det.cuenta,
								pptocomprobante_det.valdebito,
								pptocomprobante_det.valcredito, pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_cab.fecha,pptocomprobante_cab.concepto,pptotipo_comprobante.nombre, pptocomprobante_det.doc_receptor, pptocomprobante_det.tipomovimiento
								FROM pptocomprobante_det, pptocomprobante_cab, pptotipo_comprobante
								WHERE pptocomprobante_cab.tipo_comp = pptocomprobante_det.tipo_comp
								AND pptocomprobante_det.numerotipo = pptocomprobante_cab.numerotipo
								AND pptocomprobante_det.estado != 0
								AND pptocomprobante_det.vigencia='$vigusu'
								AND pptotipo_comprobante.id_tipo=pptocomprobante_det.tipo_comp
								AND (pptocomprobante_det.tipo_comp='6' ||  pptocomprobante_det.tipo_comp='7' ||  pptocomprobante_det.tipo_comp='8')
								AND pptocomprobante_cab.fecha BETWEEN '$fechaf' AND '$fechaf2'
								ORDER BY pptocomprobante_det.tipo_comp ASC ,  pptocomprobante_det.numerotipo ASC";

								/*$sqlr3="SELECT pptocomprobante_cab.* , pptotipo_comprobante.nombre
								FROM pptocomprobante_cab, pptotipo_comprobante
								WHERE pptocomprobante_cab.estado = '1'
								AND pptocomprobante_cab.vigencia='$vigusu'
								AND pptotipo_comprobante.id_tipo=pptocomprobante_cab.tipo_comp
								AND (pptocomprobante_cab.tipo_comp='6' ||  pptocomprobante_cab.tipo_comp='7' ||  pptocomprobante_cab.tipo_comp='8')
								AND pptocomprobante_cab.fecha BETWEEN '$fechaf' AND '$fechaf2'
								ORDER BY pptocomprobante_cab.tipo_comp ASC , pptocomprobante_cab.numerotipo ASC";*/
							} else if($_POST[tipoestado]=='2'){//No Encontrado---------------------------------------------------

								$sqlr3="SELECT * FROM pptocomprobante_cab 
									WHERE pptocomprobante_cab.vigencia='$vigusu' AND tipo_comp!='1'
									ORDER BY tipo_comp, numerotipo";

								//$sqlr3="SELECT * FROM pptocomprobante_cab	WHERE pptocomprobante_cab.vigencia='$vigusu' ORDER BY numerotipo";

							} else if($_POST[tipoestado]=='3'){//Incompletos------------------------------------------------------
								$sqlr3="SELECT * 
								FROM pptocomprobante_det
								WHERE tercero=''
								OR detalle=''
								OR ((valdebito='0') AND (valcredito='0'))
								OR estado=''
								OR vigencia=''
								OR (tipo_comp='0' OR tipo_comp='')
								OR (numerotipo='0' OR numerotipo='')
								OR doc_receptor=''";
							} else if($_POST[tipoestado]=='4'){//Vacios-------------------------------------------------------------
								$sqlr3="SELECT * FROM pptocomprobante_cab WHERE pptocomprobante_cab.estado!='0' AND pptocomprobante_cab.vigencia='$vigusu' AND pptocomprobante_cab.fecha BETWEEN '$fechaf' AND '$fechaf2' ORDER BY tipo_comp, numerotipo";
							}
						}else{
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
							AND pptocomprobante_det.valcredito!='0'
							$tipocomScript
							AND pptocomprobante_cab.fecha BETWEEN '$fechaf' AND '$fechaf2'";
							
						}
						//echo '----->'.$sqlr3;
						
						if($_POST[tipoestado]=='1'){
							
							echo "<table class='inicio' ><tr><td colspan='9' class='titulos'>Estado de Registro</td></tr>";
							echo "<tr><td class='titulos2' style='width: 11%;'>Cuenta</td>
							<td class='titulos2' style='width: 11%;'>TIPO COMPROBANTE</td>
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


							$res=mysql_query($sqlr3,$linkbd);
							$valdebito=0;
							$valcredito=0;						
							while($row =mysql_fetch_row($res))
							{

								$sql4="SELECT COUNT(numerotipo) FROM pptocomprobante_det WHERE cuenta='$row[0]' AND numerotipo='$row[4]'";
								
								$res4=mysql_query($sql4,$linkbd);
								$row4 =mysql_fetch_row($res4);
								if ($row4[0]==1) {								
									echo "<tr class='$iter'>
									<td ><input type='hidden' name='cuentas[]' value='$row[0]'>$row[0]</td>
									<td ><input type='hidden' name='tiporec[]' value='$row[7]'>$row[7]</td>
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
							}
							echo "<tr class='$iter'>
							<td class='titulos2' colspan='7' style='text-align: center;' ><b>Total</b></td>
							<td class='titulos2' style='text-align: right;'><input type='hidden' name='totaldebito[]' value='$valdebito'>$".number_format($valdebito,2)."</td>
							<td class='titulos2' style='text-align: right;'><input type='hidden' name='totalcredito[]' value='$valcredito'>$".number_format($valcredito,2)."</td>
							</tr>";
							/*
							echo "<table class='inicio' ><tr><td colspan='7' class='titulos'>Estado de Registro</td></tr>";
							echo "<tr>
							<td class='titulos2' style='width: 11%;'>TIPO COMPROBANTE</td>
							<td class='titulos2' style='width: 11%;'>Numero Tipo</td>
							<td class='titulos2' style='width: 11%;'>Fecha</td>
							<td class='titulos2' style='width: 50%;'>Concepto</td>
							<td class='titulos2' style='width: 11%;'>Total Debito</td>
							<td class='titulos2' style='width: 11%;'>Total Credito</td>
							<td class='titulos2' style='width: 11%;'>Diferencia</td>
							</tr>";		
							
							$iter='zebra1';
							$iter2='zebra2';


							$res=mysql_query($sqlr3,$linkbd);
							$valdebito=0;
							$valcredito=0;						
							while($row =mysql_fetch_row($res))
							{
					
								echo "<tr class='$iter'>
								<td ><input type='hidden' name='tiporec[]' value='$row[7]'>$row[9]</td>
								<td style='text-align: center;'><input type='hidden' name='com[]' value='$row[4]'>$row[0]</td>
								<td ><input type='hidden' name='cuentas[]' value='$row[0]'>$row[2]</td>
								<td style='text-align: center;'><input type='hidden' name='mov[]' value='$row[9]'>$row[3]</td>
								<td style='text-align: center;'><input type='hidden' name='rec[]' value='$row[8]'>$".number_format($row[5],2)."</td>
								<td ><input type='hidden' name='fecrec[]' value='$row[5]'>$".number_format($row[6],2)."</td>
								<td ><input type='hidden' name='detalle[]' value='$row[6]'>$".number_format($row[7],2)."</td></tr>";	 
								$aux=$iter;
								$iter=$iter2;
								$iter2=$aux;
							}
							
							echo "<tr class='$iter'>
							<td class='titulos2' colspan='4' style='text-align: center;' ><b>Total</b></td>
							<td class='titulos2' style='text-align: right;'><input type='hidden' name='totaldebito[]' value='$valdebito'>$".number_format($valdebito,2)."</td>
							<td class='titulos2' style='text-align: right;'><input type='hidden' name='totalcredito[]' value='$valcredito'>$".number_format($valcredito,2)."</td>
							</tr>";
							*/

						} else if($_POST[tipoestado]=='2'){// NO Encontrado
							
							echo "<table class='inicio'>
								<tr>
									<td colspan='2' class='titulos'>Estado de Registro</td>
								</tr>";
							echo "<tr>
								<td class='titulos2' style='width: 7%;'>Tipo Comp</td>
								<td class='titulos2' style='width: 7%;'>Numero Tipo</td>
							</tr>";		
							
							$iter='zebra1';
							$iter2='zebra2';

							$res=mysql_query($sqlr3,$linkbd);

							while($row = mysql_fetch_row($res)){
								$sql4="SELECT MAX(numerotipo) FROM pptocomprobante_cab WHERE tipo_comp='$row[1]'";
								$res4=mysql_query($sql4,$linkbd);
								$row4=mysql_fetch_row($res4);

								//echo '<br>'.$sql4.'<br>';
								//echo '------------'.$row[0].'-------------<br>';
								//echo '------------'.$row4[0].'-------------<br>';

								$sql5="SELECT numerotipo FROM pptocomprobante_cab WHERE tipo_comp='$row[1]' AND vigencia='2016' ORDER BY numerotipo ASC";
								$res5=mysql_query($sql5,$linkbd);
								$row5=mysql_fetch_row($res);
								//echo $sql5;
								$auxNumeroTipo=1;
								//echo '<br>***************'.$row[0].'********************<br>';
								for ($i=0; $i < $row4[0]; $i++) { 

									//echo '<br>'.$row[0].'!='.$auxNumeroTipo;

									if ($row[0]!=$auxNumeroTipo) {
										echo "<tr class='$iter'>
											<td style='text-align: center;'><input type='hidden' name='cuentas[]' value='$row[1]'>$row[1]</td>
											<td style='text-align: center;'><input type='hidden' name='tiporec[]' value='$auxNumeroTipo'>$auxNumeroTipo</td>
										</tr>";	
										$aux=$iter;
										$iter=$iter2;
										$iter2=$aux;
									}else{
										if($i < ($row4[0]-1)){
											//echo '------->'.$row[0].'-----<br>';
											$row = mysql_fetch_row($res);
											//echo '------->>	>'.$row[0].'-----<br>';
										}
									}
									$auxNumeroTipo++;
								}
																	
							}
							/*
							echo "<table class='inicio'>
								<tr>
									<td colspan='2' class='titulos'>Auxiliar por Cuenta</td>
								</tr>";
							echo "<tr>
								<td class='titulos2' style='width: 7%;'>Numero Tipo</td>
								<td class='titulos2' style='width: 7%;'>Tipo Comp</td>
							</tr>";		
							
							$iter='zebra1';
							$iter2='zebra2';

							$auxNumeroTipo=-1;
							$res=mysql_query($sqlr3,$linkbd);
							while($row = mysql_fetch_row($res))
							{
								if ($auxNumeroTipo!=$row[0]) {
								
									$sqlr2="SELECT numerotipo, tipo_comp FROM pptocomprobante_cab WHERE numerotipo='$row[0]' AND vigencia='$vigusu' ORDER BY tipo_comp DESC";
									$res2=mysql_query($sqlr2,$linkbd);
									$row2=mysql_fetch_row($res2);
									$auxTipoCom=2;
									//echo $sqlr2.'<br>';
									$sqlr3="SELECT numerotipo, tipo_comp FROM pptocomprobante_cab WHERE numerotipo='$row[0]' AND vigencia='$vigusu' ORDER BY tipo_comp ASC";
									$res3=mysql_query($sqlr3,$linkbd);
									$row3=mysql_fetch_row($res3);

									for ($i=0; $i < ($row2[1]-1); $i++) {
										//echo "if (".$auxTipoCom."!=".$row3[1];
										if ($auxTipoCom!=$row3[1]) {
											echo "<tr class='$iter'>
											<td style='text-align: center;'><input type='hidden' name='cuentas[]' value='$row[0]'>$row[0]</td>
											<td style='text-align: center;'><input type='hidden' name='tiporec[]' value='$auxTipoCom'>$auxTipoCom</td>
											</tr>";	
											$aux=$iter;
											$iter=$iter2;
											$iter2=$aux;
										}else{
											$row3=mysql_fetch_row($res3);
										}
										$auxTipoCom++;
									}
								}
								$auxNumeroTipo=$row[0];
							}

							*/
						} else if($_POST[tipoestado]=='3'){// Incompletos

							echo "<table class='inicio' ><tr><td colspan='13' class='titulos'>Estado de Registro</td></tr>";
							echo "<tr>							
							<td class='titulos2' style='width: 10%;'>cuenta</td>
							<td class='titulos2' style='width: 10%;'>tercero</td>
							<td class='titulos2' style='width: 10%;'>detalle</td>
							<td class='titulos2' style='width: 10%;'>Ascendente</td>
							<td class='titulos2' style='width: 10%;'>valdebito</td>
							<td class='titulos2' style='width: 10%;'>valcredito</td>
							<td class='titulos2' style='width: 10%;'>estado</td>
							<td class='titulos2' style='width: 10%;'>vigencia</td>
							<td class='titulos2' style='width: 10%;'>tipo_comp</td>
							<td class='titulos2' style='width: 10%;'>numerotipo</td>
							<td class='titulos2' style='width: 10%;'>tipomovimiento</td>
							<td class='titulos2' style='width: 10%;'>uniejecutora</td>
							<td class='titulos2' style='width: 10%;'>doc_recepto</td>
							</tr>";		
							
							$iter='zebra1';
							$iter2='zebra2';

							$res=mysql_query($sqlr3,$linkbd);
							$valdebito=0;
							$valcredito=0;						
							while($row =mysql_fetch_row($res))
							{
							
									echo "<tr class='$iter'>
									<td ><input type='hidden' name='cuentas[]' value='$row[1]'>$row[1]</td>
									<td ><input type='hidden' name='cuentas[]' value='$row[2]'>$row[2]</td>
									<td ><input type='hidden' name='cuentas[]' value='$row[3]'>$row[3]</td>
									<td ><input type='hidden' name='cuentas[]' value='$row[4]'>$row[4]</td>
									<td ><input type='hidden' name='cuentas[]' value='$row[5]'>$".number_format($row[5],2)."</td>
									<td ><input type='hidden' name='cuentas[]' value='$row[6]'>$".number_format($row[6],2)."</td>
									<td ><input type='hidden' name='cuentas[]' value='$row[7]'>$row[7]</td>
									<td ><input type='hidden' name='tiporec[]' value='$row[8]'>$row[8]</td>
									<td ><input type='hidden' name='tiporec[]' value='$row[9]'>$row[9]</td>
									<td ><input type='hidden' name='tiporec[]' value='$row[10]'>$row[10]</td>
									<td ><input type='hidden' name='tiporec[]' value='$row[11]'>$row[11]</td>
									<td ><input type='hidden' name='tiporec[]' value='$row[12]'>$row[12]</td>
									<td ><input type='hidden' name='tiporec[]' value='$row[13]'>$row[13]</td>";	 
									$aux=$iter;
									$iter=$iter2;
									$iter2=$aux; 
									$valdebito+=$row[1];
									$valcredito+=$row[2];
							}
							echo "<tr class='$iter'>
							<td class='titulos2' colspan='11' style='text-align: center;' ><b>Total</b></td>
							<td class='titulos2' style='text-align: right;'><input type='hidden' name='totaldebito[]' value='$valdebito'>$".number_format($valdebito,2)."</td>
							<td class='titulos2' style='text-align: right;'><input type='hidden' name='totalcredito[]' value='$valcredito'>$".number_format($valcredito,2)."</td>
							</tr>";
						} else if($_POST[tipoestado]=='4'){// Vacio
															
							echo "<table class='inicio'>
								<tr>
									<td colspan='9' class='titulos'>Estado de Registro</td>
								</tr>";
							echo "<tr>
								<td class='titulos2' style='width: 7%;'>Tipo Comp</td>
								<td class='titulos2' style='width: 7%;'>Numero Tipo</td>
								<td class='titulos2' style='width: 7%;'>Fecha</td>
								<td class='titulos2' style='width: 50%;'>concepto</td>
								<td class='titulos2' style='width: 5%;'>vigencia</td>
								<td class='titulos2' style='width: 13%;text-align: right;'>Total Debito</td>
								<td class='titulos2' style='width: 13%;text-align: right;'>Total Credito</td>
								<td class='titulos2' style='width: 13%;text-align: right;'>diferencia</td>
							</tr>";		
							
							$iter='zebra1';
							$iter2='zebra2';

							$res=mysql_query($sqlr3,$linkbd);
							$valdebito=0;
							$valcredito=0;						
							$valdiferencia=0;
							while($row =mysql_fetch_row($res))
							{
								$sqlrvacio="SELECT numerotipo, tipo_comp FROM pptocomprobante_det WHERE numerotipo='$row[0]' AND tipo_comp='$row[1]'";
								$resvacio=mysql_query($sqlrvacio,$linkbd);
								if (mysql_num_rows($resvacio)==0) {
																
									echo "<tr class='$iter'>
									<td style='text-align: center;'><input type='hidden' name='tiporec[]' value='$row[1]'>$row[1]</td>
									<td style='text-align: center;'><input type='hidden' name='cuentas[]' value='$row[0]'>$row[0]</td>
									<td style='text-align: center;'><input type='hidden' name='com[]' value='$row[2]'>$row[2]</td>
									<td style='text-align: center;'><input type='hidden' name='mov[]' value='$row[3]'>$row[3]</td>
									<td style='text-align: center;'><input type='hidden' name='rec[]' value='$row[4]'>$row[4]</td>
									<td style='text-align: right;><input type='hidden' name='fecrec[]' value='$row[5]'>$".number_format($row[5],2)."</td>
									<td style='text-align: right;><input type='hidden' name='detalle[]' value='$row[6]'>$".number_format($row[6],2)."</td>
									<td style='text-align: right;'><input type='hidden' name='debito[]' value='$row[7]'>$".number_format($row[7],2)."</td>
									</tr>";	 
									$aux=$iter;
									$iter=$iter2;
									$iter2=$aux; 
									$valdebito+=$row[5];
									$valcredito+=$row[6];
									$valdiferencia+=$row[7];
								}
							}
							echo "<tr class='$iter'>
							<td class='titulos2' colspan='5' style='text-align: center;' ><b>Total</b></td>
							<td class='titulos2' style='text-align: right;'><input type='hidden' name='totaldebito[]' value='$valdebito'>$".number_format($valdebito,2)."</td>
							<td class='titulos2' style='text-align: right;'><input type='hidden' name='totalcredito[]' value='$valcredito'>$".number_format($valcredito,2)."</td>
							<td class='titulos2' style='text-align: right;'><input type='hidden' name='totalcredito[]' value='$valcredito'>$".number_format($valdiferencia,2)."</td>
							</tr>";
						}
						
					}
					
					?>
			</div>
		</form>
	</body>
</html>



