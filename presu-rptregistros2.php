<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	require "conversor.php";
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
		<title>:: Spid - Presupuesto</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
        <script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/funciones.js"></script>
<script>
//************* genera reporte ************
//***************************************
	function despliegamodalm(_valor,_tip,mensa,pregunta, variable){
		document.getElementById("bgventanamodalm").style.visibility=_valor;
		if(_valor=="hidden"){
			document.getElementById('ventanam').src="";
		}
		else{
			switch(_tip){
				case "1":	document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
				case "2":	document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
				case "3":	document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
				case "4":	document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;	
			}
		}
	}
	function respuestaconsulta(pregunta, variable){
		switch(pregunta){
			case "1":	
				document.getElementById('oculto').value="2";
				document.form2.submit();
				break;
		}
	}
	function funcionmensaje(){}

	function despliegamodal2(_valor,_pag){
		document.getElementById("bgventanamodal2").style.visibility=_valor;
		if(_valor=="hidden"){
			document.getElementById('ventana2').src="";
		}
		else if(_pag=="1"){
			document.getElementById('ventana2').src="inve-kardex-articulos.php";
		}
	}
//************* genera reporte ************
	function pdf(){
		var validacion01=document.getElementById('fechaini').value;
		var validacion02=document.getElementById('fechafin').value;
		if(validacion01!='' && validacion02!=''){
			document.form2.action="pdfrptregistros.php";
			document.form2.target="_BLANK";
			document.form2.submit(); 
			document.form2.action="";
			document.form2.target="";
		}
		else{
			document.form2.fechaini.focus();
			document.form2.fechaini.select();
			despliegamodalm('visible','2','Faltan Datos para Generar el Reporte');
		}
	}
//************* genera reporte ************
	function excell(){
		var validacion01=document.getElementById('fechaini').value;
		var validacion02=document.getElementById('fechafin').value;
		if(validacion01!='' && validacion02!=''){
			document.form2.action="presu-auxiliarregistrosexcel.php";
			document.form2.target="_BLANK";
			document.form2.submit(); 
			document.form2.action="";
			document.form2.target="";
		}
		else{
			document.form2.fechaini.focus();
			document.form2.fechaini.select();
			despliegamodalm('visible','2','Faltan Datos para Generar el Reporte');
		}
	}
//***************************************
	function validar(formulario){
		document.form2.action="presu-rptregistros.php";
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
      <td colspan="3" class="cinta"><a href="presu-rp.php" class="mgbt"><img src="imagenes/add2.png" title="Nuevo"/></a> <a class="mgbt"><img src="imagenes/guardad.png" /></a> <a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/buscad.png" title="Buscar" /></a> <a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a> <a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png"  title="Buscar" /></a> <a href="#" onClick="excell()" class="mgbt"><img src="imagenes/excel.png"  title="excel"></a> <a href="presu-librosppto.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a></td></tr>	
      </table>

<div id="bgventanamodalm" class="bgventanamodalm">
	<div id="ventanamodalm" class="ventanamodalm">
    	<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
        </IFRAME>
   	</div>
</div>		  
<form name="form2" method="post" action="presu-rptregistros.php">
	<table width="100%" align="center"  class="inicio" >
    	<tr>
        	<td class="titulos" style="width:93%" colspan="7">:: Buscar .: Auxiliar de Registos</td>
       		<td class="cerrar" style="width:7%" ><a href="presu-principal.php"> Cerrar</a></td>
            	<input name="oculto" type="hidden" value="1">
    	</tr>                       
    	<tr>
    		<td class="saludo1" style="width:10%">Fecha Inicial: </td>
    		<td style="width:15%">
            	<input name="fechaini" type="date" id="fechaini" value="<?php echo $_POST[fechaini]; ?>" onKeyUp="return tabular(event,this)" style="width:70%">
          	</td>
  			<td class="saludo1" style="width:10%">Fecha Final: </td>
    		<td style="width:15%">
            	<input name="fechafin" type="date" id="fechafin" value="<?php echo $_POST[fechafin]; ?>" onKeyUp="return tabular(event,this)" style="width:70%" >
			</td>
    		<td class="saludo1" style="width:10%">Estado: </td>
    		<td style="width:20%">
            	<select name="estado" id="estado">
					<?php
					if($_POST[estado]=='1'){
						echo "<option value='-1'>Todos</option>";
						echo "<option value='1' SELECTED>APROBADOS</option>";
						echo "<option value='0'>ANULADOS</option>";
					}
					elseif($_POST[estado]=='2'){
						echo "<option value='-1'>Todos</option>";
						echo "<option value='1'>APROBADOS</option>";
						echo "<option value='0' SELECTED>ANULADOS</option>";
					}
					else{
						echo "<option value='-1' SELECTED>Todos</option>";
						echo "<option value='1'>APROBADOS</option>";
						echo "<option value='0'>ANULADOS</option>";
					}
					?>
        		</select>
          	</td>
    		<td style="width:13%">
            	<input type="button" name="buscar" value="Buscar" onClick="validar()">
            </td>
  		</tr>
	  	<tr>
    		<td><input type="hidden" value="1" name="oculto2"></td>
	    </tr>
	</table>
 
  <div class="subpantallac5" style="height:67%; width:99.6%; overflow-x:hidden;">
      <?php
	  $vigusu=vigencia_usuarios($_SESSION[cedulausu]);
	  $oculto=$_POST['oculto'];
		if($_POST[oculto]){
			if(($_POST[fechaini]!="")&&($_POST[fechafin]!="")){
				$crit1="";
				if($_POST[estado]!="-1")
					$crit1=" AND estado='$_POST[estado]'";
				$sqlr="SELECT pptocomprobante_cab.tipo_comp, pptocomprobante_cab.numerotipo, pptocomprobante_cab.fecha, pptocomprobante_cab.concepto, pptocomprobante_cab.vigencia, pptotipo_comprobante.nombre FROM pptocomprobante_cab INNER JOIN pptotipo_comprobante ON pptocomprobante_cab.tipo_comp=pptotipo_comprobante.id_tipo WHERE pptotipo_comprobante.id_tipo='7'".$crit1." AND pptocomprobante_cab.fecha BETWEEN '$_POST[fechaini]' AND '$_POST[fechafin]' and pptocomprobante_cab.vigencia=$vigusu  ORDER BY pptocomprobante_cab.fecha, pptocomprobante_cab.numerotipo";
				$resp = mysql_query($sqlr,$linkbd);
				$ntr = mysql_num_rows($resp);
				echo"<table class='inicio' align='center' width='80%'>
					<tr>
						<td colspan='11' class='titulos'>.: Resultados Busqueda:</td>
					</tr>
					<tr>
						<td colspan='5'>Registro de Egresos Encontrados: $ntr</td>
					</tr>
					<tr>
						<td class='titulos2'><img src='imagenes/plus.gif'></td>
						<td class='titulos2'>Tipo Comprobante</td>
						<td class='titulos2'>No.</td>
						<td class='titulos2'>Fecha</td>
						<td class='titulos2'>Concepto</td>
						<td class='titulos2'>Vigencia</td>
						<td class='titulos2'>Valor</td>
					</tr>";	
					$iter='saludo1a';
					$iter2='saludo2';
					$con=1;
					while ($row =mysql_fetch_row($resp)){
						$sqlr="select tercero from pptorp where vigencia=$row[4] and consvigencia=$row[1]";
						//echo $sqlr;
						$resrp=mysql_query($sqlr,$linkbd);
						$rowrp =mysql_fetch_row($resrp);
						$terrp=$rowrp[0];
						$nterrp=buscatercero($terrp);
						$sqld="SELECT SUM(valdebito) FROM pptocomprobante_det WHERE vigencia='$row[4]' AND tipo_comp='$row[0]' AND numerotipo='$row[1]'";
						$resd=mysql_query($sqld, $linkbd);
						$rowd =mysql_fetch_row($resd);
		 				echo "<tr>
							<td class='titulos2'>
								<a onClick='verDetalle($con, $row[0], $row[1], $row[4])' style='cursor:pointer;'>
									<img id='img".$con."' src='imagenes/plus.gif'>
								</a>
							</td>
							<td class='$iter'>$row[0] - $row[5]</td>
							<td class='$iter'>$row[1]</td>
							<td class='$iter'>$row[2]</td>
							<td class='$iter'>$row[3]</td>
							<td class='$iter'>$row[4]</td>
							<td class='$iter' align='right'>".number_format($rowd[0],2)."</td>
						</tr>
						<tr>
							<td align='center'></td>
							<td colspan='6' align='right'>
								<div id='detalle".$con."' style='display:none'></div>
							</td>
						</tr>";
						$con+=1;
		 				$aux=$iter;
	 					$iter=$iter2;
	 					$iter2=$aux;
 					}
	 			echo"</table>";
			}
			else{
				echo "<script>
					despliegamodalm('visible','2','Ingrese el Rango de Fechas para Su Busqueda');
				</script>";
			}
		}
		?>
	</div>
	<div id="bgventanamodal2">
		<div id="ventanamodal2">
	       	<IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
    	    </IFRAME>
		</div>
  	</div>
</form>
 
</body>
</html>