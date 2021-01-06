<?php //V 1001 20/12/16 Modificado implementacion de Reversion?> 
<?php //V 1000 12/12/16 ?> 
<?php
	error_reporting(0);
	require"comun.inc";
	require"funciones.inc";
	require "validaciones.inc";
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
		$(window).load(function () {
				$('#cargando').hide();
			});
		function direccionaDocumento(row){
			var cell = row.getElementsByTagName("td")[1];
			var id = cell.innerHTML;
			var vigencia="<?php echo vigencia_usuarios($_SESSION[cedulausu]); ?>";
			window.open("presu-cdpver.php?is="+id+"&vig="+vigencia);
		}
		function direccionaDocumentoRP(row){
			var cell = row.getElementsByTagName("td")[1];
			var id = cell.innerHTML;
			var vigencia="<?php echo vigencia_usuarios($_SESSION[cedulausu]); ?>";
			window.open("presu-rpver.php?is="+id+"&vig="+vigencia);
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
		
			}
			function buscacta(e)
			{
				document.form2.bc.value=2;
				document.form2.submit();
			}
			function excell()
			{

			}
			function validar()
			{
				document.getElementById('oculto').value='2';
				document.form2.submit(); 
			}
		</script>
		<style>
		.zebra2{
			background-color:#B2DFDB !important;
		}
	
		</style>
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
					<a href="#" class="mgbt" onClick="document.form2.submit();"><img src="imagenes/guarda.png" title="Guardar" /></a> 
					<a href="#" onClick="document.form2.submit()" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a> 
					<a href="#" onClick="mypop=window.open('ccp-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a> 
					<a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png" title="imprimir"></a>  
					<a href="#" onClick="excell()" class="mgbt"><img src="imagenes/excel.png" title="excel"></a> 
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
		<form name="form2" method="post" action="ccp-informecomprobantes.php">
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
			<?php
				$arregloCdp=Array();
				$arregloComprobante=Array();
				$totalreg=0;
				
				function obtenerCombinacion($cdp,$tipomovent,$tipomovrevpar,$tipomovrevtot,$vigencia,$numcuenta,$fechai,$fechaf){
					global $linkbd,$totalreg;
					$arregloPos=Array();
					$arregloPosFin=Array();
					$total=0;
					$acumularp=0;
					$acumulacxp=0;
					$acumulaegreso=0;
					$sql1="SELECT pptorp.consvigencia,SUM(IF(pptorp.tipo_mov=201,pptorp_detalle.valor,0)) AS valentrada,SUM(IF(pptorp.tipo_mov=401,pptorp_detalle.valor,0)) AS valrevertot,SUM(IF(pptorp.tipo_mov=402,pptorp_detalle.valor,0)) AS valreverpac FROM pptorp,pptorp_detalle WHERE pptorp.idcdp = '$cdp' AND pptorp_detalle.consvigencia = pptorp.consvigencia  AND pptorp.vigencia='$vigencia' AND pptorp_detalle.tipo_mov = pptorp.tipo_mov AND  pptorp_detalle.vigencia=pptorp.vigencia AND pptorp_detalle.cuenta='$numcuenta' AND pptorp.fecha BETWEEN '$fechai' AND '$fechaf' GROUP BY pptorp.consvigencia";
					//echo $sql1;
					$res1=mysql_query($sql1,$linkbd);
					while($rowrp = mysql_fetch_row($res1)){
						$llaverp=$rowrp[0]."-rp";
						$sql="SELECT IF(COUNT(tesoordenpago.id_orden)=0,1,COUNT(tesoordenpago.id_orden)) FROM tesoordenpago,tesoordenpago_det WHERE tesoordenpago.id_rp='$rowrp[0]' AND tesoordenpago.vigencia='$vigencia' AND tesoordenpago.tipo_mov='201' AND tesoordenpago_det.cuentap='$numcuenta' AND tesoordenpago_det.id_orden=tesoordenpago.id_orden AND tesoordenpago_det.tipo_mov=tesoordenpago.tipo_mov  ";
						$res=mysql_query($sql,$linkbd);
						$row=mysql_fetch_row($res);
						$arregloPos[$llaverp]["tipo"]="rp";
						$arregloPos[$llaverp]["combina"]=$row[0];
						$arregloPos[$llaverp]["acumula"]=$acumularp;
						$arregloPos[$llaverp]["201"]=$rowrp[1];
						$arregloPos[$llaverp]["401"]=$rowrp[2];
						$arregloPos[$llaverp]["402"]=$rowrp[3];
						$acumularp+=$row[0];
						$sql2="SELECT tesoordenpago.id_orden ,SUM(IF(tesoordenpago.tipo_mov=201,tesoordenpago_det.valor,0)) AS valentrada,SUM(IF(tesoordenpago.tipo_mov=401,tesoordenpago_det.valor,0)) AS valrevertot FROM tesoordenpago,tesoordenpago_det WHERE tesoordenpago.id_rp = '".$rowrp[0]."' AND tesoordenpago_det.id_orden = tesoordenpago.id_orden AND tesoordenpago.vigencia='$vigencia' AND tesoordenpago_det.cuentap='$numcuenta' AND tesoordenpago.fecha BETWEEN '$fechai' AND '$fechaf' GROUP BY  tesoordenpago.id_orden";
						//echo $sql2;
						$res2=mysql_query($sql2,$linkbd);
						while($rowcxp = mysql_fetch_row($res2)){
							$llavecxp=$rowcxp[0]."-cxp";
							$sql="SELECT IF(COUNT(tesoegresos.id_egreso)=0,1,COUNT(tesoegresos.id_egreso)) FROM tesoegresos WHERE tesoegresos.id_orden='$rowcxp[0]' AND tesoegresos.vigencia='$vigencia' AND tesoegresos.tipo_mov='201'";
							$res=mysql_query($sql,$linkbd);
							$row=mysql_fetch_row($res);
							$arregloPos[$llavecxp]["tipo"]="cxp";
							$arregloPos[$llavecxp]["combina"]=$row[0];
							$arregloPos[$llavecxp]["acumula"]=$acumulacxp;
							$arregloPos[$llavecxp]["201"]=$rowcxp[1];
							$arregloPos[$llavecxp]["401"]=$rowcxp[2];
							$arregloPos[$llavecxp]["402"]=0;
							$acumulacxp+=$row[0];
							
							$sql3="SELECT tesoegresos.id_egreso,SUM(IF(tesoegresos.tipo_mov=201,tesoordenpago_det.valor,0) ) AS valentrada,SUM(IF(tesoegresos.tipo_mov=401,tesoordenpago_det.valor,0) ) AS valentrada,SUM(IF(tesoegresos.tipo_mov=402,tesoordenpago_det.valor,0) ) AS valentrada FROM tesoegresos,tesoordenpago_det WHERE tesoegresos.id_orden='$rowcxp[0]' AND tesoordenpago_det.id_orden=tesoegresos.id_orden AND tesoegresos.vigencia='$vigencia' AND tesoordenpago_det.cuentap='$numcuenta' AND tesoegresos.fecha BETWEEN '$fechai' AND '$fechaf' GROUP BY tesoegresos.id_egreso";
							$res3=mysql_query($sql3,$linkbd);
							$total+=mysql_num_rows($res3);
							while($rowegre=mysql_fetch_row($res3)){
								$llaveegreso=$rowegre[0]."-egreso";
								$arregloPos[$llaveegreso]["tipo"]="egreso";
								$arregloPos[$llaveegreso]["combina"]=1;
								$arregloPos[$llaveegreso]["acumula"]=$acumulaegreso;
								$arregloPos[$llaveegreso]["201"]=$rowegre[1];
								$arregloPos[$llaveegreso]["401"]=$rowegre[2];
								$arregloPos[$llaveegreso]["402"]=0;
								$acumulaegreso+=1;
							}
							
						}
						
					}
					$totalreg=max($acumularp,$acumulacxp,$acumulaegreso);
				    $llavecdp=$cdp."-cdp";
					$arregloPos[$llavecdp]["tipo"]="cdp";
					$arregloPos[$llavecdp]["combina"]=$totalreg;
					$arregloPos[$llavecdp]["acumula"]=0;
					$arregloPos[$llavecdp]["201"]=$tipomovent;
					$arregloPos[$llavecdp]["401"]=$tipomovrevpar;
					$arregloPos[$llavecdp]["402"]=$tipomovrevtot;
					
					foreach($arregloPos as $key=>$value){
						if($arregloPos[$key]["tipo"]=="cdp"){
							$arregloPosFin[$key]["tipo"]=$arregloPos[$key]["tipo"];	
							$arregloPosFin[$key]["combina"]=$arregloPos[$key]["combina"];
							$arregloPosFin[$key]["acumula"]=$arregloPos[$key]["acumula"];
							$arregloPosFin[$key]["201"]=$arregloPos[$key]["201"];
							$arregloPosFin[$key]["401"]=$arregloPos[$key]["401"];
							$arregloPosFin[$key]["402"]=$arregloPos[$key]["402"];
						}
					}
					foreach($arregloPos as $key=>$value){
						if($arregloPos[$key]["tipo"]=="rp"){
							$arregloPosFin[$key]["tipo"]=$arregloPos[$key]["tipo"];	
							$arregloPosFin[$key]["combina"]=$arregloPos[$key]["combina"];
							$arregloPosFin[$key]["acumula"]=$arregloPos[$key]["acumula"];
							$arregloPosFin[$key]["201"]=$arregloPos[$key]["201"];
							$arregloPosFin[$key]["401"]=$arregloPos[$key]["401"];
							$arregloPosFin[$key]["402"]=$arregloPos[$key]["402"];
						}
					}
					foreach($arregloPos as $key=>$value){
						if($arregloPos[$key]["tipo"]=="cxp"){
							$arregloPosFin[$key]["tipo"]=$arregloPos[$key]["tipo"];	
							$arregloPosFin[$key]["combina"]=$arregloPos[$key]["combina"];
							$arregloPosFin[$key]["acumula"]=$arregloPos[$key]["acumula"];
							$arregloPosFin[$key]["201"]=$arregloPos[$key]["201"];
							$arregloPosFin[$key]["401"]=$arregloPos[$key]["401"];
							$arregloPosFin[$key]["402"]=$arregloPos[$key]["402"];
						}
					}
					foreach($arregloPos as $key=>$value){
						if($arregloPos[$key]["tipo"]=="egreso"){
							$arregloPosFin[$key]["tipo"]=$arregloPos[$key]["tipo"];	
							$arregloPosFin[$key]["combina"]=$arregloPos[$key]["combina"];
							$arregloPosFin[$key]["acumula"]=$arregloPos[$key]["acumula"];
							$arregloPosFin[$key]["201"]=$arregloPos[$key]["201"];
							$arregloPosFin[$key]["401"]=$arregloPos[$key]["401"];
							$arregloPosFin[$key]["402"]=$arregloPos[$key]["402"];
						}
					}
					return $arregloPosFin;
					
				}

			?>
			<div id="cargando" style=" position:absolute;left: 46%; bottom: 45%">
				<img src="imagenes/loading.gif" style=" width: 80px; height: 80px"/>
			</div>
			<table  align="center" class="inicio" >
				<tr >
					<td class="titulos" colspan="11">.: Informe Movimientos Presupuestales</td>
					<td width="" class="cerrar"><a href="ccp-principal.php">Cerrar</a></td>
				</tr>
				<tr  >
					<td  class="saludo1" style="width: 10%">Cuenta:</td>
					<td  valign="middle" style="width: 10%"><input type="text" id="cuenta" name="cuenta"  onKeyPress="javascript:return solonumeros(event)" 
						onKeyUp="return tabular(event,this)" onBlur="buscacta(event)" value="<?php echo $_POST[cuenta]?>" onClick="document.getElementById('cuenta').focus();document.getElementById('cuenta').select();" style="width: 70%"><input type="hidden" value="0" name="bc"><a href="#" onClick="mypop=window.open('cuentasppto-ventana.php?ti=2','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();">&nbsp;<img src="imagenes/find02.png" align="absmiddle" border="0" style="width:20px; height: 20px"></a>  </td>
						<td width="15%"><input name="ncuenta" type="text" value="<?php echo $_POST[ncuenta]?>"  style="width:100%" readonly> <input name="oculto" type="hidden" value="1"> <input name="valor" type="hidden" value="<?php echo $_POST[valor]?>" ><input name="valor2" type="hidden" value="<?php echo $_POST[valor2]?>"  >
					</td>  					
					<td  class="saludo1"style="width: 10%">Fecha Inicial:</td>
					<td style="width: 10%"><input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return 	tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)" style="width: 80%"><a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/calendario04.png"style="width:20px" align="absmiddle" border="0"></a>        
					</td>
					<td class="saludo1" style="width: 10%">Fecha Final: </td>
					<td style="width: 18%"><input name="fecha2" type="text" id="fc_1198971546" title="DD/MM/YYYY"  value="<?php echo $_POST[fecha2]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  style="width: 60%">         <a href="#" onClick="displayCalendarFor('fc_1198971546');"><img src="imagenes/calendario04.png" align="absmiddle" border="0" style="width:20px"></a>       <input type="button" name="generar" value="Generar" onClick="validar()"> <input type="hidden" value="1" name="oculto" id="oculto"> 
					</td>
				</tr>      
			</table>
			<?php
		if($_POST[oculto]==2){
			ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha1);
			$fechaf=$fecha1[3]."-".$fecha1[2]."-".$fecha1[1];
			ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha2);
			$fechaf2=$fecha2[3]."-".$fecha2[2]."-".$fecha2[1];	
			
		}
		//**** busca cuenta
		if($_POST[bc]==1)
		{
			$nresul=buscacuentapres($_POST[cuenta],2);
		
			if($nresul!='')
			{
				$_POST[ncuenta]=$nresul;
				$sqlr="select vigencia, vigenciaf from pptocuentas where cuenta='$_POST[cuenta]' and (vigencia=".$vigusu." or vigenciaf='$vigusu')";
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
		}else if($_POST[bc]==2)
		{
			$nresul=buscacuentapres($_POST[cuenta],2);
		
			if($nresul!='')
			{
				$_POST[ncuenta]=$nresul;
				$sqlr="select vigencia, vigenciaf from pptocuentas where cuenta='$_POST[cuenta]' and (vigencia=".$vigusu." or vigenciaf='$vigusu')";
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
				$_POST[ncuentai]="";
				?>
				<script>despliegamodalm('visible','1','Cuenta Incorrecta');</script>
				<?php
			}
		}
			?>
			<div class="subpanta" style="width:100%; margin-top:0px; overflow-x:hidden;overflow-y:none" id="divdet">
			<table class="inicio" align="center">
						
						</table>
					</div>
			<?php
			
					$oculto=$_POST['oculto'];
					if($oculto==2){

						$numCuenta="";
						$vigencia="";
						if(isset($_POST[cuenta]))
							$numCuenta=$_POST[cuenta];
						
						if(isset($_POST[valor]))
							$vigencia=$_POST[valor];
						
						$iter='zebra11';
						$iter2='zebra22';
					echo "<div class='subpantallac5' style='height:55%; width:99.6%; margin-top:0px; ' id='divdet'>
					<table class='inicio' align='center' id='comprobantes'  >";
					echo "<thead>";
					echo '<tr><td colspan="19" class="titulos">Comprobantes</td></tr>
						<tr class="titulos" style="text-align:center;">
								<td class="titulos2" colspan="5">CDP</td>
								<td class="titulos2" colspan="5">RP</td>
								<td class="titulos2" colspan="4">CXP</td>
								<td class="titulos2" colspan="4">EGRESO</td>
								<td class="titulos2" rowspan="3">SALDO</td>
							</tr>
							<tr class="titulos" style="text-align:center;">
							
								<td class="titulos2" rowspan="2">Numero</td>
								<td class="titulos2" colspan="3" >Movimientos</td>
								<td class="titulos2" rowspan="2">Definitivo</td>
								
								<td class="titulos2" rowspan="2">Numero</td>
								<td class="titulos2" colspan="3" >Movimientos</td>
								<td class="titulos2" rowspan="2">Definitivo</td>
								
								<td class="titulos2" rowspan="2">Numero</td>
								<td class="titulos2" colspan="2" >Movimientos</td>
								<td class="titulos2" rowspan="2">Definitivo</td>
								
								<td class="titulos2" rowspan="2">Numero</td>
								<td class="titulos2" colspan="2" >Movimientos</td>
								<td class="titulos2" rowspan="2" >Definitivo</td>
							</tr>
							
							<tr class="titulos" style="text-align:center;">
							
								<td class="titulos2"  >201 - Entrada</td>
								<td class="titulos2" >401 - Reversion Total</td>
								<td class="titulos2" >402 - Reversion Parcial</td>
								
								<td class="titulos2" >201 - Entrada</td>
								<td class="titulos2" >401 - Reversion Total</td>
								<td class="titulos2" >402 - Reversion Parcial</td>
								
								<td class="titulos2" >201 - Entrada</td>
								<td class="titulos2" >401 - Reversion Total</td>
								
								<td class="titulos2" >201 - Entrada</td>
								<td class="titulos2" >401 - Reversion Total</td>
							</tr>';
						echo "</thead>";
						echo "<tbody>";
						
						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
						$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
						$fechaf2=$fecha[3]."-".$fecha[2]."-".$fecha[1];	
						$sqlcdp="SELECT pptocdp.consvigencia,SUM(IF(pptocdp.tipo_mov=201,pptocdp_detalle.valor,0)) AS valentrada,SUM(IF(pptocdp.tipo_mov=401,pptocdp_detalle.valor,0)) AS valrevertot,SUM(IF(pptocdp.tipo_mov=402,pptocdp_detalle.valor,0)) AS valreverpac  FROM pptocdp,pptocdp_detalle WHERE pptocdp.consvigencia=pptocdp_detalle.consvigencia AND pptocdp.vigencia='$_POST[valor]' AND pptocdp_detalle.cuenta='$numCuenta'  AND pptocdp_detalle.tipo_mov=pptocdp.tipo_mov AND pptocdp_detalle.vigencia=pptocdp.vigencia AND pptocdp.fecha BETWEEN '$fechaf'  AND '$fechaf2' GROUP BY pptocdp.consvigencia ";
						//echo $sqlcdp;
						$rescdp=mysql_query($sqlcdp,$linkbd);
						$zebra1="zebra1";
						$zebra2="zebra2";
						while($rowcdp = mysql_fetch_row($rescdp)){
							$acumula="";
							$arreglo=obtenerCombinacion($rowcdp[0],$rowcdp[1],$rowcdp[2],$rowcdp[3],$_POST[valor],$numCuenta,$fechaf,$fechaf2);
							$max=$totalreg;
							for($i=0;$i<$max;$i++){
								
								$acumula.="<tr class='$zebra1'>";
								foreach($arreglo as $key=>$value){
									switch($arreglo[$key]["tipo"]){
										case "cdp":
											$filas=$arreglo[$key]["combina"];
											$pos=$arreglo[$key]["acumula"];
											$ent1=$arreglo[$key]["201"];
											$ent2=$arreglo[$key]["401"];
											$ent3=$arreglo[$key]["402"];
											$def=$ent1-$ent2-$ent3;
											$numero=explode("-",$key);
											if($i==$pos){$acumula.="<td rowspan='$filas' >$numero[0]</td><td rowspan='$filas' >".number_format($ent1,2,',','.')."</td><td rowspan='$filas' >".number_format($ent2,2,',','.')."</td><td rowspan='$filas' >".number_format($ent3,2,',','.')."</td><td rowspan='$filas' >".number_format($def,2,',','.')."</td>";}
											break;
										case "rp":
										    $filas=$arreglo[$key]["combina"];
											$pos=$arreglo[$key]["acumula"];
											$ent1=$arreglo[$key]["201"];
											$ent2=$arreglo[$key]["401"];
											$ent3=$arreglo[$key]["402"];
											$def=$ent1-$ent2-$ent3;
											$numero=explode("-",$key);
											if($i==$pos){$acumula.="<td rowspan='$filas' >$numero[0]</td><td rowspan='$filas' >".number_format($ent1,2,',','.')."</td><td rowspan='$filas' >".number_format($ent2,2,',','.')."</td><td rowspan='$filas' >".number_format($ent3,2,',','.')."</td><td rowspan='$filas' >".number_format($def,2,',','.')."</td>";}
											break;
										case "cxp":
										    $filas=$arreglo[$key]["combina"];
											$pos=$arreglo[$key]["acumula"];
											$ent1=$arreglo[$key]["201"];
											$ent2=$arreglo[$key]["401"];
											$ent3=$arreglo[$key]["402"];
											$def=$ent1-$ent2-$ent3;
											$numero=explode("-",$key);
											if($i==$pos){$acumula.="<td rowspan='$filas' >$numero[0]</td><td rowspan='$filas' >".number_format($ent1,2,',','.')."</td><td rowspan='$filas' >".number_format($ent2,2,',','.')."</td><td rowspan='$filas' >".number_format($def,2,',','.')."</td>";}
											break;
										case "egreso":
										    $filas=$arreglo[$key]["combina"];
											$pos=$arreglo[$key]["acumula"];
											$ent1=$arreglo[$key]["201"];
											$ent2=$arreglo[$key]["401"];
											$ent3=$arreglo[$key]["402"];
											$def=$ent1-$ent2-$ent3;
											$saldo=generaSaldoCDP($rowcdp[0],$_POST[valor]);
											$numero=explode("-",$key);
											if($i==$pos){$acumula.="<td rowspan='$filas' >$numero[0]</td><td rowspan='$filas' >".number_format($ent1,2,',','.')."</td><td rowspan='$filas' >".number_format($ent2,2,',','.')."</td><td rowspan='$filas' >".number_format($def,2,',','.')."</td><td rowspan='$filas' >".number_format($saldo,2,',','.')."</td>";}
											break;
									}
								}
								$acumula.="</tr>";
								
							}
							echo $acumula;
							$aux=$zebra1;
							$zebra1=$zebra2;
							$zebra2=$aux;
						}
					
						echo "</tbody>";
					

			echo "</table></div>";
			for ($i=0; $i <sizeof($arregloFinal) ; $i++) { 
				echo "<input type='hidden' name='tipocomp[]' id='tipocomp[]' value='".$arregloFinal[$i]["tipocompro"]."' />";
				echo "<input type='hidden' name='numcomp[]' id='numcomp[]' value='".$arregloFinal[$i]["numcompro"]."' />";
				echo "<input type='hidden' name='fecha1[]' id='fecha1[]' value='".$arregloFinal[$i]["fecha"]."' />";
				echo "<input type='hidden' name='detalle[]' id='detalle[]' value='".$arregloFinal[$i]["detalle"]."' />";
				echo "<input type='hidden' name='tipomov[]' id='tipomov[]' value='".$arregloFinal[$i]["tipomov"]."' />";
				echo "<input type='hidden' name='entrada[]' id='entrada[]' value='".$arregloFinal[$i]["entrada"]."' />";
				echo "<input type='hidden' name='salida[]' id='salida[]' value='".$arregloFinal[$i]["salida"]."' />";
				echo "<input type='hidden' name='saldo[]' id='saldo[]' value='".$arregloFinal[$i]["saldo"]."' />";
			}
					}

				?> 
			
		</form>

</body>
</body>
</html>