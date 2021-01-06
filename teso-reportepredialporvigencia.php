<?php
ini_set('max_execution_time',36000);
require "comun.inc";
require "funciones.inc";
require "conversor.php";
$linkbd=conectar_bd();
session_start();
cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<title>:: SPID - Tesoreria</title>

<script language="JavaScript1.2">
	function validar(){
		document.form2.oculto.value='1';
		document.form2.submit();
	}

	function pdf(){
		document.form2.action="pdfpredial.php";
		document.form2.target="_BLANK";
		document.form2.submit(); 
		document.form2.action="";
		document.form2.target="";
	}
</script>
<script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
<script src="css/programas.js"></script>
<script src="css/funciones.js"></script>
<link href="css/css2.css" rel="stylesheet" type="text/css" />
<link href="css/css3.css" rel="stylesheet" type="text/css" />
<link href="css/tabs.css" rel="stylesheet" type="text/css" />

<script>
	$(window).load(function () {
		$('#cargando').hide();
	});
</script>

<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
	<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("teso");?></tr>
	<tr>
		<td colspan="3" class="cinta">
			<a href="teso-reportepredios.php" class="mgbt"><img src="imagenes/add2.png" alt="Nuevo"  border="0" title="Nuevo"/></a> 
			<a href="#" onClick="#" class="mgbt"><img src="imagenes/guardad.png"  alt="Guardar" title="Guardar"/></a>
			<a href="teso-reportepredios.php" class="mgbt"> <img src="imagenes/buscad.png"  alt="Buscar" title="Buscar" /></a>
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana" title="Nueva ventana"></a> 
			<a href="#" <?php if($_POST[oculto]==2) { ?> onClick="pdf()" <?php } ?> class="mgbt"> <img src="imagenes/print.png"  alt="Buscar" title="Imprimir"/></a>
			<a href="<?php echo "archivos/".$_SESSION[usuario]."reportepredios.csv"; ?>" target="_blank" class="mgbt"><img src="imagenes/csv.png"  alt="csv" title="csv"></a>
			<a href="teso-informespredios.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
		</td>
	</tr>		  
</table>
<tr>
<td colspan="3" class="tablaprin" align="center"> 
<?php
$vigencia=date(Y);
$vact=$_SESSION[vigencia]; 
 ?>	
<div id="cargando" style=" position:absolute;left: 46%; bottom: 45%">
		<img src="imagenes/loading.gif" style=" width: 80px; height: 80px"/>
	</div>
<form name="form2" method="post" action="">
	<table class="inicio">
	    <tr>
    	  	<td class="titulos" colspan="7">Reporte Acumulado</td>
        	<td class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
  		</tr>
      	<tr>
        	<td class="saludo3" style="width: 10%">Codigo Catastral Inicial:</td>
            <td style="width: 20%">
				<input id="codcat" type="text" name="codcat" size="20" onKeyUp="return tabular(event,this)" onBlur="buscar(event)" value="<?php echo $_POST[codcat]?>" >
                <input id="ord" type="text" name="ord" size="3"  value="<?php echo $_POST[ord]?>" readonly><input id="tot" type="text" name="tot" size="3" value="<?php echo $_POST[tot]?>" readonly>
                <a href="#" onClick="mypop=window.open('catastral-ventana.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=900,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>
           	</td>
			<td class="saludo3" style="width: 10%">Codigo Catastral Final:</td>
            <td style="width: 20%">
				<input id="codcatf" type="text" name="codcatf" size="20" onKeyUp="return tabular(event,this)" onBlur="buscar(event)" value="<?php echo $_POST[codcatf]?>" >
                <input id="ordf" type="text" name="ordf" size="3"  value="<?php echo $_POST[ordf]?>" readonly><input id="totf" type="text" name="totf" size="3" value="<?php echo $_POST[totf]?>" readonly>
                <a href="#" onClick="mypop=window.open('catastral-ventanaf.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=900,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>
                <input name="oculto" type="hidden" value="<?php echo $_POST[oculto] ?>">
           	</td>
			
        	<td>
            	<input type="button" name="buscar" value="  Buscar  " onClick="validar()" style="margin-left: 10%">
            </td>
      	</tr>
  	</table>
	
    <div class="subpantallac" style="height:65%; overflow-x:hidden;">
    	<table class="inicio">
      		<tr>
            	<td class="titulos" colspan="16">Predios Encontrados</td>
           	</tr>
      		<tr>
				<td class='titulos2'><img src='imagenes/plus.gif'></td>
            	<td class="titulos2">No</td>
				<td class="titulos2">Vigencias</td>
                <td class="titulos2">Cod Catastral</td>
                <td class="titulos2">ID. Tercero</td>
                <td class="titulos2">Tercero</td>
				<td class="titulos2">Tipo</td>
                <td class="titulos2">Predial</td>
                <td class="titulos2">Interes Predial</td>
                <td class="titulos2">Desc.Interes Predial</td>
				<td class="titulos2">Sobretasa Bomberial</td>
				<td class="titulos2">Interes Bomberial</td>
				<td class="titulos2">Sobretasa Ambiental</td>
				<td class="titulos2">Interes Ambiental</td>
				<td class="titulos2">Descuentos</td>
				<td class="titulos2">Valor Total</td>
          	</tr>
			
			<input type="hidden" name="basepredial" id="basepredial" value="<?php echo $_POST[basepredial]; ?>" />
			<input type="hidden" name="basepredialamb" id="basepredialamb" value="<?php echo $_POST[basepredialamb]; ?>" />
			<input type="hidden" name="aplicapredial" id="aplicapredial" value="<?php echo $_POST[aplicapredial]; ?>" />
			<input type="hidden" name="vigmaxdescint" id="vigmaxdescint" value="<?php echo $_POST[vigmaxdescint]; ?>" />
			<input type="hidden" name="porcdescint" id="porcdescint" value="<?php echo $_POST[porcdescint]; ?>" />
			<input type="hidden" name="aplicadescint" id="aplicadescint" value="<?php echo $_POST[aplicadescint]; ?>" />
			<input type="hidden" name="fecha" id="fecha" value="<?php echo $_POST[fecha]; ?>" />
			<input type="hidden" name="fechaav" id="fechaav" value="<?php echo $_POST[fechaav]; ?>" />
			<input type="hidden" name="vigencia" id="vigencia" value="<?php echo $_POST[vigencia]; ?>" />
			<input type="hidden" name="tasamora" id="tasamora" value="<?php echo $_POST[tasamora]; ?>" />
			<input type="hidden" name="tasa" id="tasa" value="<?php echo $_POST[tasa]; ?>" />
			
			<input type="hidden" name="predial" id="predial" value="<?php echo $_POST[predial]; ?>" />
			<input type="hidden" name="descuento" id="descuento" value="<?php echo $_POST[descuento]; ?>" />
			<input type="hidden" name="catastral" id="catastral" value="<?php echo $_POST[catastral]; ?>" />
			<input type="hidden" name="ntercero" id="ntercero" value="<?php echo $_POST[ntercero]; ?>" />
			<input type="hidden" name="tercero" id="tercero" value="<?php echo $_POST[tercero]; ?>" />
			<input type="hidden" name="direccion" id="direccion" value="<?php echo $_POST[direccion]; ?>" />
			<input type="hidden" name="avaluo2" id="avaluo2" value="<?php echo $_POST[avaluo2]; ?>" />
			<input type="hidden" name="vavaluo" id="vavaluo" value="<?php echo $_POST[vavaluo]; ?>" />
			<input type="hidden" name="tipop" id="tipop" value="<?php echo $_POST[tipop]; ?>" />
			<input type="hidden" name="rangos" id="rangos" value="<?php echo $_POST[rangos]; ?>" />
			<input type="hidden" name="estrato" id="estrato" value="<?php echo $_POST[estrato]; ?>" />
			<input type="hidden" name="var1" id="var1" value="<?php echo $_POST[var1]; ?>" />
			<input type="hidden" name="var2" id="var2" value="<?php echo $_POST[var2]; ?>" />

      		<?php
			//print_r(generaReporteSinPagos("000100010007000","2017"));
			function limpiaNumero($numero){
				$num=0;
				$conca="";
				for($i=0;$i<strlen($numero);$i++ ){
					if($numero[$i]!=0){
						break;
					}else{
						$num++;
					}
				}
				return substr($numero,$num)."-".$num;
			}

	  		if($_POST[oculto]==1){
				$linkbd=conectar_bd();
				if(empty($_POST[codcat]) || empty($_POST[codcatf]) ){
					$sqlr="select tesopredios.cedulacatastral, tesopredios.direccion from tesopredios where !(tesopredios.estado='N') GROUP BY tesopredios.cedulacatastral";
				}else{
					$sqlr="select tesopredios.cedulacatastral, tesopredios.direccion  from tesopredios where tesopredios.cedulacatastral between  '$_POST[codcat]' AND '$_POST[codcatf]' AND !(tesopredios.estado='N') GROUP BY tesopredios.cedulacatastral";
				}
				$res=mysql_query($sqlr,$linkbd);
				$np=1;
				$codcat="'".$row[0]."'";
				$namearch="archivos/".$_SESSION[usuario]."reportepredios.csv";
				$Descriptor1 = fopen($namearch,"w+"); 
				fputs($Descriptor1,"Vigencia; cedula_catastral; Id.Tercero ; Tercero; Direccion; Tipo; Predial; Interes Predial; Desc. Interes Predial; Sobretasa Bomberil; Int. Sobretasa Bomberil; Sobretasa Ambiental; Int. Sobretasa Ambiental; Descuentos; Valor total\r\n");
				while ($row =mysql_fetch_row($res)){ 
					$arregloFinal=generaReporteSinPagos($row[0],$vigencia);
					$predial=0;
					$ipredial=0;
					$descipred=0;
					$bomberil=0;
					$ibomberil=0;
					$ambiental=0;
					$iambiental=0;
					$descuentos=0;
					$total=0;
					$tercero="";
					$ntercero="";
					$tipo="";
					foreach($arregloFinal as $key => $value){
						$predial+=$value["predial"];
						$ipredial+=$value["ipredial"];
						$descipred+=$value["descipred"];
						$bomberil+=$value["bomberil"];
						$ibomberil+=$value["ibomberil"];
						$ambiental+=$value["ambiental"];
						$iambiental+=$value["iambiental"];
						$descuentos+=$value["descuentos"];
						$total+=$value["total"];
						$tercero=$value["tercero"];
						$ntercero=$value["ntercero"];
						$tipo=$value["tipopredio"];
						
					}
					$codcasarr=explode("-",limpiaNumero($row[0]));
					$codcas=$codcasarr[0];
					$numceros=$codcasarr[1];
					
					if($total>0){
						$sqlvig="SELECT CONCAT(MIN(vigencia),'-',MAX(vigencia)) FROM tesoprediosavaluos WHERE codigocatastral='$row[0]' AND pago='N'";
						$resvig=mysql_query($sqlvig,$linkbd);
						$rangovigencia=mysql_fetch_row($resvig);
						echo "<tr class='saludo3'>
						<td class='titulos2'>
							<a onClick='verDetallePredialAcumulado($np, $codcas,$numceros,".json_encode($arregloFinal).")' style='cursor:pointer;'>
								<img id='img".$np."' src='imagenes/plus.gif'>
							</a>
						</td>
						<td>$np</td>
						<td>".$rangovigencia[0]."</td>
						<td>$row[0]</td>
						<td>$tercero</td>
						<td>$ntercero</td>
						<td>$tipo</td>
						<td>$".number_format($predial,2,',','.')."</td>
						<td>$".number_format($ipredial,2,',','.')."</td>
						<td>$".number_format($descipred,2,',','.')."</td>
						<td>$".number_format($bomberil,2,',','.')."</td>
						<td>$".number_format($ibomberil,2,',','.')."</td>
						<td>$".number_format($ambiental,2,',','.')."</td>
						<td>$".number_format($iambiental,2,',','.')."</td>
						<td>$".number_format($descuentos,2,',','.')."</td>
						<td>$".number_format($total,2,',','.')."</td>
					</tr>
					<tr>
						<td align='center'></td>
						<td colspan='13' align='right'>
							<div id='detalle".$np."' style='display:none;padding-left: 10%'></div>
						</td>
					</tr>";	
					fputs($Descriptor1,"".$rangovigencia[0].";'".$row[0]."';".$tercero.";".$ntercero.";".$row[1].";".$tipo.";".$predial.";".$ipredial.";".$descipred.";".$bomberil.";".$ibomberil.";".$ambiental.";".$iambiental.";".$descuentos.";".$total."\r\n");					
					$np+=1;
					}
					
					}		
				fclose($Descriptor1);			
	   		}
      		?>
      	</table>
	</div>      
</form>
</td></tr>
</table>
</body>
</html>