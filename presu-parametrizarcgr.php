<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
	error_reporting(0);
	ini_set('max_execution_time', 720);
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: SPID - Presupuesto</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
		<link type="text/css" href="JQuery/jquery-ui-1.12.1/jquery-ui.css" rel="Stylesheet" /> 
		<script type="text/javascript" src="JQuery/jquery-2.1.4.min.js"></script>
		<script type="text/javascript" src="JQuery/jquery-ui-1.12.1/jquery-ui.js"></script>
        <script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
		 <script type="text/javascript">
		 function simulateKeyPress(character) {
			jQuery.event.trigger({ type : 'keypress', which : character.charCodeAt(0) });
		}
		
      $(document).ready(function(){
		  
		$('body').keypress(function(e) {
		//alert(e.which);
		});
	
		$('#imagen').click(function(){
			  $('#autoc1').focus();
			  $('#autoc1').trigger({type: 'keypress', which: 32, keyCode: 32});
		});
		  $.post('JQuery/peticionesajax/codcgr.php',{}, obtenervalores);
		  var arrayValoresAutocompletar='0';
		  var arreglocgr=[];
		  function obtenervalores (data){
			  var arrayValoresAutocompletar=JSON.parse(data);
			  for(var i=0;i<arrayValoresAutocompletar.length;i++)
			  {
				  arreglocgr.push(arrayValoresAutocompletar[i].codigo+" - "+ arrayValoresAutocompletar[i].nombre);
			  }
			  //console.log(arrayValoresAutocompletar[0].codigo);
		  }
		  $("#autoc1").autocomplete({
            source: arreglocgr
         })
      })
   </script>
		<script>		
			function despliegamodal2(_valor)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else {document.getElementById('ventana2').src="contra-productos-ventana.php";}
			}
			function despliegamodal2(_valor,_nomcu)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else 
				{
					document.getElementById('ventana2').src="cuentasgral-ventana03.php?vigencia=<?php echo $_SESSION[vigencia]?>&objeto="+_nomcu+"&nobjeto=000";
				}
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
				document.form2.action="presu-ejecuciongastospdf.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function excell()
			{
				document.form2.action="presu-ejecuciongastosexcel2.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function validar()
			{
				document.getElementById('oculto').value='3';
				document.form2.submit(); 
			}
			var expanded = false;
			function showCheckboxes() {
			  var checkboxes = document.getElementById("checkboxes");
			  if (!expanded) {
			    checkboxes.style.display = "block";
			    expanded = true;
			  } else {
			    checkboxes.style.display = "none";
			    expanded = false;
			  }
			}
			var expanded1 = false;
			function showCheckboxes1() {
			  var checkboxes1 = document.getElementById("checkboxes1");
			  if (!expanded1) {
			    checkboxes1.style.display = "block";
			    expanded1 = true;
			  } else {
			    checkboxes1.style.display = "none";
			    expanded1 = false;
			  }
			}
			function direccionaCuentaGastos(row){
			var cell = row.getElementsByTagName("td")[0];
			var id = cell.innerHTML;
			window.open("presu-auxiliarcuentagastos.php?cod="+id);
			}
		function buscacta(e)
			{
				if (document.form2.cuenta.value!="")
				{
					document.form2.bc.value=2;
					document.form2.submit();
				}
			}

		</script>
		<style type="text/css">
		.multiselect {
  width: 200px;
}

.selectBox {
  position: relative;

}

.selectBox select {
  width: 100%;
  font-weight: bold;
}

.overSelect {
  position: absolute;
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;

}

#checkboxes {
  display: none;
  border: 1px #dadada solid;
  position: absolute;
  width: 13%;
  overflow-y: scroll;
  z-index: 999999999;
}
#checkboxes1{
 display: none;
  border: 1px #dadada solid;
  position: absolute;
  width: 13%;
  overflow-y: scroll;
  z-index: 9999;	
}
#checkboxes label,#checkboxes1 label {
  display: block;
  background: #ECEFF1;
  border-bottom: 1px solid #CFD8DC;
  font-size: 10px;
}
#checkboxes label:last-child, #checkboxes1 label:last-child {
  display: block;
  background: #ECEFF1;
  border-bottom: none;
}

#checkboxes label:hover,#checkboxes1 label:hover {
  background-color: #1e90ff;
}

	</style>
		<?php titlepag();?>
	</head>
<body>
 <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
        	<tr><?php menu_desplegable("presu");?></tr>
        	<tr>
  				<td colspan="3" class="cinta"><a href="#" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a> <a href="#" class="mgbt" onClick="document.form2.submit();"><img src="imagenes/guarda.png" title="Guardar"/></a> <a href="#" onClick="document.form2.submit()" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a> <a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a> <a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png" title="imprimir"></a> <a href="#" onClick="excell()" class="mgbt"><img src="imagenes/excel.png" title="excel"></a> <a href="presu-ejecucionpresupuestal.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a></td>
          	</tr>
		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>	  
		<form name="form2" method="post" action="presu-parametrizarcgr.php">
			<input type="hidden" name="vigencia" id="vigencia" value="<?php echo $_POST[vigencia];?>" >
			<?php
			$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
			$vigencia=$vigusu;
			if($_POST[bc]!='')
			{
				$nresul=buscacuentapres($_POST[cuenta],2);			
				if($nresul!='')
				{
					$_POST[ncuenta]=$nresul;
   		 			  

				}
				else
				{
					$_POST[ncuenta]="";	
				}
			}
 ?>
    <table  align="center" class="inicio" >
	<tr>
				<td colspan='2'>
					<input type="text" id="autoc1">
					<img src="imagenes/selctcgr.png" id="imagen" class="saludo2" style="width:20px;height:20px"> 
				</td>
			</tr>
		<tr >
			<td class="titulos" colspan="12">.: Ejecucion Gastos</td>
			<td width="7%" class="cerrar"><a href="presu-principal.php">Cerrar</a></td>
		</tr>
		
		<tr>     
			<td style="width=5%" class="saludo1">Unidad(es): </td>
			<td style="width=10%">
				<div class="multiselect">
			    <div class="selectBox" onclick="showCheckboxes()">
			      <select>
			        <option id="texto" >Selecciona...</option>
			      </select>
			      <div class="overSelect"></div>
			    </div>
			    <div id="checkboxes">
			    <?php
			    $sql="Select * from pptouniejecu  WHERE estado='S' order by id_cc";
			    $query=mysql_query($sql,$linkbd);
			  
			    while ($row = mysql_fetch_array($query)){
			    	echo "<label for='".$row[0]."'>";
			    	echo "<input type='checkbox' class='".$row[0]."' id='$row[0]' name='unidad'/>$row[0] - ".utf8_encode($row[1])." ";
			    	echo "</label>";
			   
			    }
			    ?>
			    </div>
			  </div>
			  <input type="hidden" name="filtros" id="filtros" value="">
			</td>
			
			<td style="width:5%" class="saludo1">Fuente: </td>
			<td style="width:30%">
				<select id="ffunc" style="width: 100%">
					<option value="">Seleccione ....</option>
					<?php
						$sql="SELECT codigo,nombre FROM pptofutfuentefunc UNION SELECT codigo,nombre FROM pptofutfuenteinv ORDER BY CAST(codigo AS SIGNED) ASC";
						$result=mysql_query($sql,$linkbd);
						while($row = mysql_fetch_row($result)){
							echo "<option value='$row[0]'>$row[0] - $row[1]</option>";
						}
					?>
				</select>
			</td>
			<td width="5%">
				<input type="button" name="generar" value="Generar" onClick="validar()"> 
				<input type="hidden" value="<?php echo $_POST[oculto]; ?>" name="oculto" id="oculto">
			</td>
			<td width="33%"></td>
		</tr>   		
    </table>
	<?php

		if($_POST[oculto]==2){
			ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha1);
			$fechaf=$fecha1[3]."-".$fecha1[2]."-".$fecha1[1];
			ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha2);
			$fechaf2=$fecha2[3]."-".$fecha2[2]."-".$fecha2[1];	
			if($_POST[vereg]=='1'){
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
					echo "<script>despliegamodalm('visible','1','El Presupuesto General SOLO Aplica para Una Vigencia');</script>";				
				}
			}
			elseif($_POST[vereg]=='2'){
				if($fecha1[3]==$fecha2[3]){
					$correcto=1;
					$sqlv="SELECT vigencia, vigenciaf FROM pptocuentas WHERE vigencia='$fecha1[3]' AND regalias='S'";
					//echo $sqlv;
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
		//**** busca cuenta
		if($_POST[bc]!='')
		{
			$nresul=buscacuentapres($_POST[cuenta],2);
			if($nresul!='')
			{
				$_POST[ncuenta]=$nresul;
				/*$linkbd=conectar_bd();
				$sqlr="select *from pptocuentas where cuenta=$_POST[cuenta] and vigencia=$vigusu";
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
				$_POST[valor]=$row[5];		  
				$_POST[valor2]=$row[5];	*/	  			  
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
	<table>
	
	</table>
	<?php
	if ($_POST[oculto]==3)
	{
	?>

	
	<?php
		$_POST[vigencia]=$_SESSION[vigencia];
		//$vigencia=$_SESSION[vigencia];
		$fech1=split("/",$_POST[fecha]);
		$fech2=split("/",$_POST[fecha2]);
		$f1=$fech1[2]."-".$fech1[1]."-".$fech1[0];
		$f2=$fech2[2]."-".$fech2[1]."-".$fech2[0];
		$cuentaInicial='';
		$cuentaFinal='';
		$iter="zebra1";
		$iter2="zebra2";
		if(isset($_POST['cuenta1'])){
			if(!empty($_POST['cuenta1']))
				$cuentaInicial=$_POST['cuenta1'];
		}
		if(isset($_POST['cuenta2'])){
			if(!empty($_POST['cuenta2']))
				$cuentaFinal=$_POST['cuenta2'];
		}
		$cuentaPadre=Array();
		$vectorDif=Array();
		cuentasAux();
		$vectorBusqueda=explode("-",$_POST[filtros]);
		echo "<div class='subpantallac5' style='height:60%; width:99.6%; margin-top:0px; overflow-x:scroll' id='divdet'>
				<table class='inicio' align='center' id='valores' >
					<tr class='titulos'>
				<td colspan='15'>.: Ejecucion Cuentas</td>
			</tr>
			<tr class='titulos2'>
				<td id='col1' >Cuenta</td>
				<td id='col2' >Nombre</td>
				<td id='col3' >Fuentes</td>
				<td id='col4' >Presupuesto Inicial</td>
				<td id='col5' >Adicion</td>
				<td id='col6' >Reduccion</td>
				<td id='col7' >Credito</td>
				<td id='col8' >Contra Credito</td>
				<td id='col9' >Presupuesto Definitivo</td>
				<td id='col10' >Disponibilidad</td>
				<td id='col11' >Compromisos</td>
				<td id='col12' >Obligaciones</td>
				<td id='col13' >Pagos</td>
				<td id='col14' >Saldo Disponible</td>
				
			</tr>
				<tbody>";
			$elimina="DELETE FROM pptoejecucionpresu_gastos";
			mysql_query($elimina,$linkbd);
					
	   		for ($i=0; $i <sizeof($cuentaPadre) ; $i++) { 
	   			buscaCuentasHijo($cuentaPadre[$i]);
	   		}
	
	   		$totPresuInicial=0;
			foreach ($cuentas as $key => $value) {
					$numeroCuenta=$cuentas[$key]['numCuenta'];
					$nombreCuenta=$cuentas[$key]['nomCuenta'];
					$fuenteCuenta=$cuentas[$key]['fuenCuenta'];
					$presupuestoInicial=$cuentas[$key]['presuInicial'];
					$adicion=$cuentas[$key]['adicion'];
					$reduccion=$cuentas[$key]['reduccion'];
					$credito=$cuentas[$key]['credito'];
					$contracredito=$cuentas[$key]['conCredito'];
					$presupuestoDefinitivo=$cuentas[$key]['presuDefinitivo'];
					$cdp=$cuentas[$key]['cdp'];
					$rp=$cuentas[$key]['rp'];
					$cxp=$cuentas[$key]['cxp'];
					$egreso=$cuentas[$key]['egreso'];
					$saldo=$cuentas[$key]['saldo'];
					$tipo=$cuentas[$key]['tipo'];
					$tasa=$cuentas[$key]['tasa'];
					$entidad=$cuentas[$key]['entidad'];
					$style='';
					if($saldo<0){
						$style='background: yellow';
					}
					if($entidad=='externa'){
						$style='background: #BBDEFB';
					}
					if(!empty($numeroCuenta)){  //----bloque nuevo 17/01/2016
						if($tipo=='Auxiliar' || $tipo=='auxiliar'){
						$totPresuInicial+=$cuentas[$key]['presuInicial'];
						$totAdiciones+=$cuentas[$key]['adicion'];
						$totReducciones+=$cuentas[$key]['reduccion'];
						$totCreditos+=$cuentas[$key]['credito'];
						$totContraCreditos+=$cuentas[$key]['conCredito'];
						$totCdp+=$cuentas[$key]['cdp'];
						$totRp+=$cuentas[$key]['rp'];
						$totCxp+=$cuentas[$key]['cxp'];
						$totEgresos+=$cuentas[$key]['egreso'];
						$totSaldos+=$cuentas[$key]['saldo'];
						
						$totPresuDefinitivo+=$cuentas[$key]['presuDefinitivo'];
						echo "<tr style='font-size:9px; text-rendering: optimizeLegibility;$style' class='$iter' ondblclick='direccionaCuentaGastos(this)'>";
					echo "<td id='1' style='width: 5%'>$numeroCuenta</td><td id='2' style='width: 20%'>$nombreCuenta</td><td id='3' style='width: 20%'>$fuenteCuenta</td><td id='4' style='width: 5.5%'>".number_format($presupuestoInicial,2,",",".")."</td><td id='5' style='width: 4.5%'>".number_format($adicion,2,",",".")."</td><td id='6' style='width: 4.5%'>".number_format($reduccion,2,",",".")."</td><td id='7' style='width: 4.5%'>".number_format($credito,2,",",".")."</td><td id='8' style='width: 4.5%'>".number_format($contracredito,2,",",".")."</td><td id='9' style='width: 5%'>".number_format($presupuestoDefinitivo,2,",",".")."</td><td id='10' style='width: 4.5%'>".number_format($cdp,2,",",".")."</td><td id='11' style='width: 4.5%'>".number_format($rp,2,",",".")."</td><td id='12' style='width: 4.5%'>".number_format($cxp,2,",",".")."</td><td id='13' style='width: 4.5%'>".number_format($egreso,2,",",".")."</td><td id='14' style='width: 4.5%'>".number_format($saldo,2,",",".")."</td>";
					echo "</tr>";
					}else{
						echo "<tr style='font-weight:bold; font-size:9px; text-rendering: optimizeLegibility' class='$iter'>";
					echo "<td id='1' style='width: 5%'>$numeroCuenta</td><td id='2' style='width: 20%'>$nombreCuenta</td><td id='3' style='width: 20%'>$fuenteCuenta</td><td id='4' style='width: 5.5%'>".number_format($presupuestoInicial,2,",",".")."</td><td id='5' style='width: 4.5%'>".number_format($adicion,2,",",".")."</td><td id='6' style='width: 4.5%'>".number_format($reduccion,2,",",".")."</td><td id='7' style='width: 4.5%'>".number_format($credito,2,",",".")."</td><td id='8' style='width: 4.5%'>".number_format($contracredito,2,",",".")."</td><td id='9' style='width: 5%'>".number_format($presupuestoDefinitivo,2,",",".")."</td><td id='10' style='width: 4.5%'>".number_format($cdp,2,",",".")."</td><td id='11' style='width: 4.5%'>".number_format($rp,2,",",".")."</td><td id='12' style='width: 4.5%'>".number_format($cxp,2,",",".")."</td><td id='13' style='width: 4.5%'>".number_format($egreso,2,",",".")."</td><td id='14' style='width: 4.5%'>".number_format($saldo,2,",",".")."</td>";
					echo "</tr>";
			
					}
					
					$inserta="INSERT INTO pptoejecucionpresu_gastos(cuenta,pptoinicial,adicion,reduccion,credito,contracredito,pptodefinitivo,cdp,rp,cxp,egreso,saldo_dispo,unidad,vigencia) VALUES ('$numeroCuenta','$presupuestoInicial','$adicion','$reduccion','$credito','$contracredito','$presupuestoDefinitivo','$cdp','$rp','$cxp','$egreso','$saldo','central','$_POST[vigencia]')";
					mysql_query($inserta,$linkbd);

					$aux=$iter;
					$iter=$iter2;
					$iter2=$aux;
					}  //----bloque nuevo 17/01/2016
					
					echo "<input type='hidden' name='cuenta[]' id='cuenta[]' value='".$numeroCuenta."' />";
					echo "<input type='hidden' name='nombre[]' id='nombre[]' value='".$nombreCuenta."' />";
					
					echo "<input type='hidden' name='fuente[]' id='fuente[]' value='".$fuenteCuenta."' />";
					echo "<input type='hidden' name='pid[]' id='pid[]' value='".$presupuestoInicial."' />";
					echo "<input type='hidden' name='adc[]' id='adc[]' value='".$adicion."' />";
					echo "<input type='hidden' name='red[]' id='red[]' value='".$reduccion."' />";
					echo "<input type='hidden' name='cred[]' id='cred[]' value='".$credito."' />";
					echo "<input type='hidden' name='contra[]' id='contra[]' value='".$contracredito."' />";
					echo "<input type='hidden' name='ppto[]' id='ppto[]' value='".$presupuestoDefinitivo."' />";
					echo "<input type='hidden' name='cdpd[]' id='cdpd[]' value='".$cdp."' />";
					echo "<input type='hidden' name='rpd[]' id='rpd[]' value='".$rp."' />";
					echo "<input type='hidden' name='cxpd[]' id='cxpd[]' value='".$cxp."' />";
					echo "<input type='hidden' name='egd[]' id='egd[]' value='".$egreso."' />";
					echo "<input type='hidden' name='tipo[]' id='tipo[]' value='".$tipo."' />";
					echo "<input type='hidden' name='saldos[]' id='saldos[]' value='".$saldo."' />";

				

			
		}
	
 		
		echo "</tbody></table>
		</div>";
		echo "<div class='subpantallac5' style='height:20%; width:99.6%; margin-top:0px; overflow-x:hidden' id='divdet'>";
				echo "<table class='inicio' align='center' id='valores' >
					<tr>
						<td class='saludo1'>Presupueso Inicial</td>
						<td style='width: 6%;border-right: 1px solid gray'>$".number_format($totPresuInicial)."</td>
						<td class='saludo1'>Adiciones</td>
						<td style='width: 6%;border-right: 1px solid gray'>$".number_format($totAdiciones)."</td>
						<td class='saludo1'>Reducciones</td>
						<td style='width: 6%;border-right: 1px solid gray'>$".number_format($totReducciones)."</td>
						<td class='saludo1'>Creditos</td>
						<td style='width: 6%;border-right: 1px solid gray'>$".number_format($totCreditos)."</td>
						<td class='saludo1' colspan='4'>Contracreditos</td>
						<td style='width:6%;border-right: 1px solid gray'>$".number_format($totContraCreditos)."</td>
					</tr>

					<tr><td class='saludo1'>Presupueso Definitivo</td><td style='width: 6%;border-right: 1px solid gray'>$".number_format($totPresuDefinitivo)."</td><td class='saludo1'>CDP</td><td style='width: 6%;border-right: 1px solid gray'>$".number_format($totCdp)."</td><td class='saludo1'>RP</td><td style='width: 6%;border-right: 1px solid gray'>$".number_format($totRp)."</td><td class='saludo1'>CXP</td><td style='width: 6%;border-right: 1px solid gray'>$".number_format($totCxp)."</td><td class='saludo1'>Egresos</td><td style='width:6%;border-right: 1px solid gray'>$".number_format($totEgresos)."</td><td class='saludo1' colspan='2'>Saldo</td><td style='width:6%;border-right: 1px solid gray'>$".number_format($totSaldos)."</td></tr>
					</table>";
		echo "</div>";



		

		
	?> 
	
	<?php
	}

	function generaVectorCuenta($numCuenta,$vigencia,$fechaf,$fechaf2,$regalias,$vigenciari,$vigenciarf){
			$ejecucionxcuenta=Array();
			global $linkbd;
			$queryPresupuesto="SELECT valor,vigencia FROM pptocuentaspptoinicial WHERE cuenta='$numCuenta' AND vigencia=$vigencia";
		
			$result=mysql_query($queryPresupuesto, $linkbd);
			
						while($row=mysql_fetch_array($result)){
							
							$presuDefinitivo+=$row[0];
						 }

						$ejecucionxcuenta[0]=$presuDefinitivo;
						if($regalias=='S'){
							$fecha1=split("-",$fechaf);
							$fecha2=split("-",$fechaf2);
							$fechar1=$vigenciari."-".$fecha1[1]."-".$fecha1[2];
							$fechar2=$vigenciari."-".$fecha2[1]."-".$fecha2[2];
							$fechar3=$vigenciarf."-".$fecha1[1]."-".$fecha1[2];
							$fechar4=$vigenciarf."-".$fecha2[1]."-".$fecha2[2];
							$querySalidaPresuDefi="SELECT SUM(D.valor) FROM pptocdp C, pptocdp_detalle D WHERE D.cuenta='$numCuenta' AND (D.vigencia=$vigenciari OR D.vigencia=$vigenciarf) AND D.tipo_mov='201' AND D.consvigencia=C.consvigencia AND C.tipo_mov='201' AND (C.vigencia=$vigenciari OR C.vigencia=$vigenciarf) AND NOT(D.estado='N' OR D.estado='R') GROUP BY D.cuenta";
						}else{
							$querySalidaPresuDefi="SELECT SUM(D.valor) FROM pptocdp C, pptocdp_detalle D WHERE D.cuenta='$numCuenta' AND D.vigencia=$vigencia AND D.tipo_mov='201' AND D.consvigencia=C.consvigencia AND C.tipo_mov='201' AND C.vigencia=$vigencia AND NOT(D.estado='N' OR D.estado='R') AND C.fecha BETWEEN '$fechaf' AND '$fechaf2' GROUP BY D.cuenta";
						}
						
						$valCDP=0.0;
						$result=mysql_query($querySalidaPresuDefi, $linkbd);
						if(mysql_num_rows($result)!=0){
							while($row=mysql_fetch_array($result)){
						$valCDP=$row[0];
						    }
						}
					if($regalias=='S'){
						$fecha1=split("-",$fechaf);
							$fecha2=split("-",$fechaf2);
							$fechar1=$vigenciari."-".$fecha1[1]."-".$fecha1[2];
							$fechar2=$vigenciari."-".$fecha2[1]."-".$fecha2[2];
							$fechar3=$vigenciarf."-".$fecha1[1]."-".$fecha1[2];
							$fechar4=$vigenciarf."-".$fecha2[1]."-".$fecha2[2];
							
						$queryAdiciones="SELECT SUM(pad.valor),pad.id_adicion,pa.fecha FROM pptoadiciones pad,pptoacuerdos pa WHERE pad.cuenta='$numCuenta' AND (pad.vigencia=$vigenciari OR pad.vigencia=$vigenciarf) AND pa.id_acuerdo=pad.id_acuerdo AND pad.id_acuerdo>0 AND NOT(pa.estado='N') GROUP BY cuenta";
					}else{
						$queryAdiciones="SELECT SUM(pad.valor),pad.id_adicion,pa.fecha FROM pptoadiciones pad,pptoacuerdos pa WHERE pad.cuenta='$numCuenta' AND pad.vigencia=$vigencia AND pa.id_acuerdo=pad.id_acuerdo AND pad.id_acuerdo>0 AND NOT(pa.estado='N') GROUP BY cuenta";
					}
					

					$result=mysql_query($queryAdiciones, $linkbd);
					$totentAdicion=0.0;
					$totsalAdicion=0.0;
						if(mysql_num_rows($result)!=0){
							while($row=mysql_fetch_array($result)){
							$presuDefinitivo+=$row[0];
							$totentAdicion+=$row[0];
							$totsalAdicion+=0.0;
						}
						}
						$ejecucionxcuenta[1]=$totentAdicion;
						if($regalias=='S'){
							$fecha1=split("-",$fechaf);
							$fecha2=split("-",$fechaf2);
							$fechar1=$vigenciari."-".$fecha1[1]."-".$fecha1[2];
							$fechar2=$vigenciari."-".$fecha2[1]."-".$fecha2[2];
							$fechar3=$vigenciarf."-".$fecha1[1]."-".$fecha1[2];
							$fechar4=$vigenciarf."-".$fecha2[1]."-".$fecha2[2];
							$queryReducciones="SELECT SUM(pr.valor),pr.id_reduccion,pa.fecha FROM pptoreducciones pr,pptoacuerdos pa WHERE pr.cuenta='$numCuenta' AND (pr.vigencia=$vigenciari OR pr.vigencia=$vigenciarf) AND pr.id_acuerdo=pa.id_acuerdo AND pr.id_acuerdo>0 AND NOT(pa.estado='N') GROUP BY pr.cuenta";

						}else{
							$queryReducciones="SELECT SUM(pr.valor),pr.id_reduccion,pa.fecha FROM pptoreducciones pr,pptoacuerdos pa WHERE pr.cuenta='$numCuenta' AND pr.vigencia=$vigencia AND pr.id_acuerdo=pa.id_acuerdo AND pr.id_acuerdo>0 AND NOT(pa.estado='N') GROUP BY pr.cuenta";

						}

						
						$result=mysql_query($queryReducciones, $linkbd);
						$totentReduccion=0.0;
						$totsalReduccion=0.0;
						if(mysql_num_rows($result)!=0){
							while($row=mysql_fetch_array($result)){
							$presuDefinitivo-=$row[0];
							$totentReduccion+=$row[0];
							$totsalReduccion+=0.0;
						}
						}

			$ejecucionxcuenta[2]=$totentReduccion;
						if($regalias=='S'){
							$fecha1=split("-",$fechaf);
							$fecha2=split("-",$fechaf2);
							$fechar1=$vigenciari."-".$fecha1[1]."-".$fecha1[2];
							$fechar2=$vigenciari."-".$fecha2[1]."-".$fecha2[2];
							$fechar3=$vigenciarf."-".$fecha1[1]."-".$fecha1[2];
							$fechar4=$vigenciarf."-".$fecha2[1]."-".$fecha2[2];
							$queryTraslados="SELECT pt.id_acuerdo,pt.tipo,SUM(pt.valor),pa.fecha FROM pptotraslados pt,pptoacuerdos pa WHERE pt.cuenta='$numCuenta' AND (pt.vigencia=$vigenciari OR pt.vigencia=$vigenciarf) AND pt.id_acuerdo>0 AND  pt.id_acuerdo=pa.id_acuerdo AND NOT(pa.estado='N')  GROUP BY pt.id_acuerdo";
						}else{
							$queryTraslados="SELECT pt.id_acuerdo,pt.tipo,SUM(pt.valor),pa.fecha FROM pptotraslados pt,pptoacuerdos pa WHERE pt.cuenta='$numCuenta' AND pt.vigencia=$vigencia AND pt.id_acuerdo>0 AND  pt.id_acuerdo=pa.id_acuerdo AND NOT(pa.estado='N') GROUP BY pt.id_acuerdo";
						}

						

						$presuSalida=0.0;
						$totentTraslado=0.0;
						$totsalTraslado=0.0;
						$result=mysql_query($queryTraslados, $linkbd);
						if(mysql_num_rows($result)!=0){
							while($row=mysql_fetch_array($result)){
							
							if($row[1]=='R'){
							$presuSalida+=$row[2];
							$totsalTraslado+=$row[2];
							$presuDefinitivo-=$row[2];
							}
							else{

							$presuDefinitivo+=$row[2];
							$totentTraslado+=$row[2];
							}
						echo "</tr>";
						}
						}
			$ejecucionxcuenta[3]=$totentTraslado;
			$ejecucionxcuenta[4]=$totsalTraslado;

			$presuDefinitivoSalida=$valCDP+$presuSalida;
			$ejecucionxcuenta[5]=$presuDefinitivo;

			$totalCDPEnt=0;
			$totalCDPSal=0;
			$pos=0;
			$pos1=0;
			if($regalias=='S'){
				$fecha1=split("-",$fechaf);
				$fecha2=split("-",$fechaf2);
				$fechar1=$vigenciari."-".$fecha1[1]."-".$fecha1[2];
				$fechar2=$vigenciari."-".$fecha2[1]."-".$fecha2[2];
				$fechar3=$vigenciarf."-".$fecha1[1]."-".$fecha1[2];
				$fechar4=$vigenciarf."-".$fecha2[1]."-".$fecha2[2];
				$queryTraslados="SELECT D.consvigencia,SUM(D.valor),D.tipo_mov FROM  pptocdp_detalle D WHERE D.cuenta='$numCuenta' AND (D.vigencia=$vigenciari OR D.vigencia=$vigenciarf)  AND NOT(D.estado='N') AND D.valor>0   GROUP BY D.consvigencia,D.tipo_mov";
				$pos=1;
				$pos1=2;
			}else{
				$queryTraslados="SELECT C.consvigencia,C.fecha,C.objeto,C.tipo_mov,SUM(D.valor),D.tipo_mov FROM pptocdp C, pptocdp_detalle D WHERE D.cuenta='$numCuenta' AND D.vigencia=$vigencia AND D.consvigencia=C.consvigencia AND C.vigencia=$vigencia AND NOT(D.estado='N') AND D.valor>0 AND D.tipo_mov=C.tipo_mov AND C.fecha BETWEEN '$fechaf' AND '$fechaf2' GROUP BY C.consvigencia,C.tipo_mov";
				$pos=4;
				$pos1=5;
			}
			
		
				$result=mysql_query($queryTraslados, $linkbd);
						if(mysql_num_rows($result)!=0){
							while($row=mysql_fetch_array($result)){
							if($row[$pos1]=='201'){
								$totalCDPEnt+=$row[$pos];
							}else if(($row[$pos1]=='401') || ($row[$pos1]=='402')){
								$totalCDPEnt-=$row[$pos];
							}
							
						}
						}
			    $ejecucionxcuenta[6]=$totalCDPEnt;

						$totalRPEnt=0;
						$totalRPSal=0;
						$arregloRP=Array();
						$pos=0;
						$pos1=0;
						if($regalias=='S'){
							$fecha1=split("-",$fechaf);
							$fecha2=split("-",$fechaf2);
							$fechar1=$vigenciari."-".$fecha1[1]."-".$fecha1[2];
							$fechar2=$vigenciari."-".$fecha2[1]."-".$fecha2[2];
							$fechar3=$vigenciarf."-".$fecha1[1]."-".$fecha1[2];
							$fechar4=$vigenciarf."-".$fecha2[1]."-".$fecha2[2];
							$queryTraslados="SELECT RD.consvigencia,RD.tipo_mov,SUM(RD.valor) FROM pptorp_detalle RD where RD.cuenta='$numCuenta' AND (RD.vigencia=$vigenciari OR RD.vigencia=$vigenciarf)  AND NOT(RD.estado='N') AND RD.valor>0  GROUP BY RD.consvigencia,RD.tipo_mov";
							$pos=2;
							$pos1=1;
						}else{
							$queryTraslados="SELECT R.consvigencia,R.fecha,R.tipo_mov,SUM(RD.valor),RD.tipo_mov FROM pptorp R,pptorp_detalle RD where  R.vigencia=$vigencia AND RD.cuenta='$numCuenta' AND RD.consvigencia=R.consvigencia AND RD.vigencia=$vigencia  AND NOT(R.estado='N') AND R.tipo_mov=RD.tipo_mov AND RD.valor>0 AND R.fecha BETWEEN '$fechaf' AND '$fechaf2' GROUP BY R.consvigencia,R.tipo_mov";
							$pos=3;
							$pos1=4;
						}
						
						$result=mysql_query($queryTraslados, $linkbd);
						if(mysql_num_rows($result)!=0){
					
							while($row=mysql_fetch_array($result)){
								if( $row[$pos1]=='201'){
								$totalRPEnt+=$row[$pos];
								$arregloRP[]=$row[0];
							}else if(( $row[$pos1]=='401') || ($row[$pos1]=='402')){
								$totalRPEnt-=$row[$pos];
							}
							
							
						
						}
						}
			$ejecucionxcuenta[7]=$totalRPEnt;

						$totalCxPEnt=0.0;
						$totalCxPSal=0.0;
						if($regalias=='S'){
							$fecha1=split("-",$fechaf);
							$fecha2=split("-",$fechaf2);
							$fechar1=$vigenciari."-".$fecha1[1]."-".$fecha1[2];
							$fechar2=$vigenciari."-".$fecha2[1]."-".$fecha2[2];
							$fechar3=$vigenciarf."-".$fecha1[1]."-".$fecha1[2];
							$fechar4=$vigenciarf."-".$fecha1[1]."-".$fecha1[2];
							$queryTraslados="SELECT T.id_orden,T.fecha,T.tipo_mov,TD.valor,T.estado,TD.tipo_mov FROM tesoordenpago T,tesoordenpago_det TD WHERE (T.vigencia=$vigenciari OR T.vigencia=$vigenciarf)  AND T.id_orden=TD.id_orden AND NOT(T.estado='N') AND TD.valor>0 AND TD.cuentap='$numCuenta' AND T.tipo_mov=TD.tipo_mov ";
						}else{
							$queryTraslados="SELECT T.id_orden,T.fecha,T.tipo_mov,TD.valor,T.estado,TD.tipo_mov FROM tesoordenpago T,tesoordenpago_det TD WHERE T.vigencia=$vigencia  AND T.id_orden=TD.id_orden AND NOT(T.estado='N') AND TD.valor>0 AND TD.cuentap='$numCuenta' AND T.tipo_mov=TD.tipo_mov AND T.fecha BETWEEN '$fechaf' AND '$fechaf2'";
						}
						
						$result=mysql_query($queryTraslados, $linkbd);
						if(mysql_num_rows($result)!=0){
							$salida=0.0;
							while($row=mysql_fetch_array($result)){
							
							if($row[5]=='201'){
								$totalCxPEnt+=$row[3];
							}else if($row[5]=='401'){
								$totalCxPEnt-=$row[3];
							}
							
							
							
						}
						}
				$totalEgresoEnt=0.0;
				
				$queryssf="SELECT E.id_orden,SUM(ED.valor) FROM  tesossfegreso_cab E, tesossfegreso_det ED WHERE E.id_orden=ED.id_egreso AND E.vigencia=$vigencia AND E.fecha BETWEEN '$fechaf' AND '$fechaf2' AND ED.cuentap='$numCuenta' AND E.estado='S' GROUP BY E.id_orden";
				
					$result=mysql_query($queryssf, $linkbd);
						if(mysql_num_rows($result)!=0){
							$salida=0.0;
							while($row=mysql_fetch_array($result)){
							
	
								$totalCxPEnt+=$row[1];
								$totalEgresoEnt+=$row[1];
							
							
							
						}
						}
						
				for ($i=0; $i <sizeof($arregloRP); $i++) { 
				
							$queryTraslados="SELECT TEN.id_orden,TEN.concepto,HNP.valor,TEN.id_egreso,TEN.fecha FROM hum_nom_cdp_rp HNR,humnom_presupuestal HNP,tesoegresosnomina TEN WHERE HNR.rp=$arregloRP[$i] AND HNR.nomina=HNP.id_nom AND HNP.cuenta='$numCuenta' AND HNR.vigencia=$vigencia AND HNP.estado='P' AND NOT(HNR.estado='N' OR HNR.estado='R') AND TEN.id_orden=HNP.id_nom AND TEN.vigencia=$vigencia AND NOT(TEN.estado='N' OR TEN.estado='R') AND HNP.valor>0 AND TEN.fecha BETWEEN '$fechaf' AND '$fechaf2' GROUP BY TEN.id_orden";
							$result=mysql_query($queryTraslados, $linkbd);
						if(mysql_num_rows($result)==0)
							echo "";
						else{
							while($row=mysql_fetch_array($result)){
							$arregloEgresosNom[]=@Array("id" => "$row[3]",
														"concepto" => "Egreso de nomina",
														"valor" => "$row[2]",
														"fecha" => "$row[4]");
							$totalCxPEnt+=$row[2];
							$totalCxPSal+=$row[2];
							break;

						}
					}

				}
						

			$ejecucionxcuenta[8]=$totalCxPEnt;
			
				
						$totalEgresoSal=0.0;
						if($regalias=='S'){
							$fecha1=split("-",$fechaf);
							$fecha2=split("-",$fechaf2);
							$fechar1=$vigenciari."-".$fecha1[1]."-".$fecha1[2];
							$fechar2=$vigenciari."-".$fecha2[1]."-".$fecha2[2];
							$fechar3=$vigenciarf."-".$fecha1[1]."-".$fecha1[2];
							$fechar4=$vigenciarf."-".$fecha2[1]."-".$fecha2[2];
							$queryTraslados="SELECT TE.id_egreso,TE.fecha,TE.tipo_mov,TD.valor FROM tesoegresos TE,tesoordenpago_det TD where (TE.vigencia=$vigenciari OR TE.vigencia=$vigenciarf) AND TD.cuentap='$numCuenta' AND TE.id_orden=TD.id_orden AND  NOT(TE.estado='N') AND TD.valor >0 ";
						}else{
							$queryTraslados="SELECT TE.id_egreso,TE.fecha,TE.tipo_mov,TD.valor FROM tesoegresos TE,tesoordenpago_det TD where TE.vigencia=$vigencia AND TD.cuentap='$numCuenta' AND TE.id_orden=TD.id_orden AND  NOT(TE.estado='N') AND TD.valor >0 AND TE.fecha BETWEEN '$fechaf' AND '$fechaf2'";
						}
						
						$result=mysql_query($queryTraslados, $linkbd);
						if(mysql_num_rows($result)!=0){
							while($row=mysql_fetch_array($result)){
							if($row[2]=='201'){
								$totalEgresoEnt+=$row[3];
							}else if($row[2]=='401'){
								$totalEgresoEnt-=$row[3];
							}

							

						}
						}

						for($i=0;$i<sizeof($arregloEgresosNom);$i++){
							$valor=$arregloEgresosNom[$i]['valor'];
							$totalEgresoEnt+=$valor;
						}
			$ejecucionxcuenta[9]=$totalEgresoEnt;
			$ejecucionxcuenta[10]=$presuDefinitivo-$totalCDPEnt;
			$ejecucionxcuenta[11]=$numCuenta;
			return $ejecucionxcuenta;		
             
		}
		function generarUnidadExterna($arreglo){
			$resultado="AND (";
			$tiene=false;
			for($i=0;$i<count($arreglo); $i++ ){
				if($arreglo[$i]=='02'){
					if(!$tiene){
						$resultado.="pptocuentasentidades.unidad LIKE '%concejo%' ";
					}else{
						$resultado.="OR pptocuentasentidades.unidad LIKE '%concejo%' ";
					}
				 $tiene=true;
				}
				if($arreglo[$i]=='03'){
					if(!$tiene){
						$resultado.="pptocuentasentidades.unidad LIKE '%personeria%' ";
					}else{
						$resultado.="OR pptocuentasentidades.unidad LIKE '%personeria%' ";
					}
					
					 $tiene=true;
				}
			}
			$resultado.=")";
			return $resultado;
		}
		function cuentasAux(){
		global $cuentas,$linkbd,$vigencia,$f1,$f2,$cuentaPadre,$cuentaInicial,$cuentaFinal,$vectorDif;
		$datosBase=datosiniciales();
		$orden='cuenta';
		$buqueda=" ";
		$vectorBusqueda=explode("-",$_POST[filtros]);
		$vectorBusquedaClases=explode("-",$_POST[filtrosclases]);
		$tieneAntes=false;
		$sqlunidadext="SELECT * FROM entidadesgastos";
		$tabla2="";
		$bentidades="";
		$condtercero="";
		$tablatercero="";
		for($i=0;$i<sizeof($vectorBusqueda); $i++){
			if($vectorBusqueda[$i]=='01' AND sizeof($vectorBusqueda)==1){
				if(!$tieneAntes)
					$buqueda.="AND (pptocuentas.unidad LIKE '%central%' OR pptocuentas.unidad LIKE '%concejo%' OR pptocuentas.unidad LIKE '%personeria%'";
				else
					$buqueda.=" OR (pptocuentas.unidad  LIKE '%central%' OR pptocuentas.unidad LIKE '%concejo%' OR pptocuentas.unidad LIKE '%personeria%' ";
			$tieneAntes=true;
			}elseif($vectorBusqueda[$i]=='01' AND sizeof($vectorBusqueda)>1){
				if(!$tieneAntes)
					$buqueda.="AND (pptocuentas.unidad LIKE '%central%'";
				else
					$buqueda.=" OR (pptocuentas.unidad  LIKE '%central%' ";
			$tieneAntes=true;
			}
			if($vectorBusqueda[$i]=='02'){
				if(!$tieneAntes)
					$buqueda.=" AND (pptocuentas.unidad NOT LIKE '%concejo%'";
				else
					$buqueda.=" OR pptocuentas.unidad NOT LIKE '%concejo%'";
			$tieneAntes=true;
			
			}
			if($vectorBusqueda[$i]=='03'){
				if(!$tieneAntes)
					$buqueda.=" AND (pptocuentas.unidad NOT LIKE '%personeria%'";
				else
					$buqueda.=" OR pptocuentas.unidad NOT LIKE '%personeria%'";
			$tieneAntes=true;
			}
			if($vectorBusqueda[$i]=='02' || $vectorBusqueda[$i]=='03'){
				$bentidades="UNION SELECT pptocuentasentidades.cuenta,pptocuentasentidades.nombre,pptocuentasentidades.tipo,pptocuentasentidades.futfuentefunc,pptocuentasentidades.futfuenteinv,SUBSTR(pptocuentasentidades.cuenta,1,1) AS c,pptocuentasentidades.regalias,pptocuentasentidades.vigencia,pptocuentasentidades.vigenciaf,pptocuentas_pos.entidad,pptocuentas_pos.posicion,pptocuentas_pos.cuentapos FROM pptocuentasentidades,pptocuentas_pos WHERE pptocuentasentidades.estado='S' AND pptocuentasentidades.clasificacion NOT LIKE '%ingresos%' AND (pptocuentasentidades.vigencia=$vigencia OR pptocuentasentidades.vigenciaf=$vigencia) AND pptocuentas_pos.cuentapos = pptocuentasentidades.cuenta AND pptocuentas_pos.entidad='externa' ".generarUnidadExterna($vectorBusqueda);
			}
		}
		$pos=stripos($buqueda,"pptocuentas.unidad");
		if($pos!=null){
			$buqueda.=")";
		}
		
		$tieneAntes=false;
		$regalias="AND pptocuentas.regalias='N' ";
		for($i=0;$i<sizeof($vectorBusquedaClases); $i++){
			if($vectorBusquedaClases[$i]=='10'){
				$regalias="";
				if(!$tieneAntes)
					$buqueda.=" AND (pptocuentas.clasificacion LIKE '%reservas-gastos%'";
				else
					$buqueda.=" OR pptocuentas.clasificacion LIKE '%reservas-gastos%'";
			$tieneAntes=true;
			
			}
			if($vectorBusquedaClases[$i]=='11'){
				$regalias="";
				if(!$tieneAntes)
					$buqueda.=" AND (pptocuentas.clasificacion LIKE '%sgr-gastos%'";
				else
					$buqueda.=" OR pptocuentas.clasificacion LIKE '%sgr-gastos%'";
			$tieneAntes=true;
			}
			if($vectorBusquedaClases[$i]=='12'){
				$regalias="";
				if(!$tieneAntes)
					$buqueda.=" AND (pptocuentas.clasificacion LIKE '%inversion%'";
				else
					$buqueda.=" OR pptocuentas.clasificacion LIKE '%inversion%'";
			$tieneAntes=true;
			}
			if($vectorBusquedaClases[$i]=='13'){
				$regalias="";
				if(!$tieneAntes)
					$buqueda.=" AND (pptocuentas.clasificacion LIKE '%deuda%'";
				else
					$buqueda.=" OR pptocuentas.clasificacion LIKE '%deuda%'";
			$tieneAntes=true;
			}
			if($vectorBusquedaClases[$i]=='14'){
				$regalias="";
				if(!$tieneAntes)
					$buqueda.=" AND (pptocuentas.clasificacion LIKE '%funcionamiento%'";
				else
					$buqueda.=" OR pptocuentas.clasificacion LIKE '%funcionamiento%'";
			$tieneAntes=true;
			}
		}
		if(isset($_POST[regalias])){
			if(!empty($_POST[regalias])){
				$regalias="AND pptocuentas.regalias='S' ";
			}
		}
		$pos=stripos($buqueda,"pptocuentas.clasificacion");
		if($pos!=null){
			$buqueda.=")";
		}
		
		if(isset($_POST[sectores])){
			if(!empty($_POST[sectores])){
				$buqueda.=" AND pptocuentas_sectores.cuenta=pptocuentas.cuenta AND pptocuentas_sectores.sector LIKE '%$_POST[sectores]%' AND (pptocuentas_sectores.vigenciai=$vigencia OR pptocuentas_sectores.vigenciaf=$vigencia)";
				$tabla2=",pptocuentas_sectores";
			}
		}
		if(isset($_POST[ffunc])){
			if(!empty($_POST[ffunc])){
				$buqueda.="AND pptocuentas.futfuentefunc=$_POST[ffunc]";
			}
		}
		if(isset($_POST[finv])){
			if(!empty($_POST[finv])){
				$buqueda.="AND pptocuentas.futfuenteinv=$_POST[finv]";
			}
		}
		
		if(empty($cuentaInicial) || empty($cuentaFinal)){
			$sql="SELECT * FROM (SELECT pptocuentas.cuenta,pptocuentas.nombre,pptocuentas.tipo,pptocuentas.futfuentefunc,pptocuentas.futfuenteinv,SUBSTR(pptocuentas.cuenta,1,1) AS c,pptocuentas.regalias,pptocuentas.vigencia,pptocuentas.vigenciaf,pptocuentas_pos.entidad,pptocuentas_pos.posicion,pptocuentas_pos.cuentapos FROM pptocuentas,pptocuentas_pos $tabla2  WHERE pptocuentas.estado='S' AND (pptocuentas.tipo='Auxiliar' or pptocuentas.tipo='auxiliar') AND pptocuentas.clasificacion NOT LIKE '%ingresos%' $regalias AND (pptocuentas.vigencia=$vigencia OR pptocuentas.vigenciaf=$vigencia) AND pptocuentas_pos.cuentapos = pptocuentas.cuenta AND pptocuentas_pos.tipo='gastos'   AND pptocuentas_pos.entidad='interna' AND pptocuentas_pos.vigencia=$vigencia $buqueda $bentidades ) AS tabla ORDER BY posicion,cuentapos";
		}else{
			$sql="SELECT * FROM (SELECT pptocuentas.cuenta,pptocuentas.nombre,pptocuentas.tipo,pptocuentas.futfuentefunc,pptocuentas.futfuenteinv,SUBSTR(pptocuentas.cuenta,1,1) AS c,pptocuentas.regalias,pptocuentas.vigencia,pptocuentas.vigenciaf,pptocuentas_pos.entidad,pptocuentas_pos.posicion,pptocuentas_pos.cuentapos FROM pptocuentas,pptocuentas_pos $tabla2  WHERE pptocuentas.estado='S' AND (pptocuentas.tipo='Auxiliar' or pptocuentas.tipo='auxiliar') AND pptocuentas.clasificacion NOT LIKE '%ingresos%' AND $regalias AND (pptocuentas.vigencia=$vigencia OR pptocuentas.vigenciaf=$vigencia) AND pptocuentas_pos.cuentapos = pptocuentas.cuenta AND pptocuentas_pos.tipo='gastos' AND  pptocuentas_pos.entidad='interna' AND pptocuentas_pos.vigencia=$vigencia AND pptocuentas.cuenta between '$cuentaInicial' AND '$cuentaFinal' $buqueda $bentidades) AS tabla ORDER BY posicion,cuentapos";
		}
		//echo $sql;
		$result=mysql_query($sql,$linkbd);
		while($row = mysql_fetch_array($result)){
			if($row[9]=='interna'){
			if($row[2]=='Auxiliar' || $row[2]=='auxiliar'){
			$arregloCuenta=generaVectorCuenta($row[0],$vigencia,$f1,$f2,$row[6],$row[7],$row[8]);
			$cuentas[$row[0]]["numCuenta"]=$row[0];
			$cuentas[$row[0]]["nomCuenta"]=$row[1];
			$cuentas[$row[0]]["presuInicial"]=$arregloCuenta[0];
			$cuentas[$row[0]]["fuenCuenta"]=obtenerFuente($row[3],$row[4]);
			$cuentas[$row[0]]["adicion"]=$arregloCuenta[1];
			$cuentas[$row[0]]["reduccion"]=$arregloCuenta[2];
			$cuentas[$row[0]]["credito"]=$arregloCuenta[3];
			$cuentas[$row[0]]["conCredito"]=$arregloCuenta[4];
			$cuentas[$row[0]]["presuDefinitivo"]=$arregloCuenta[5];
			$cuentas[$row[0]]["cdp"]=$arregloCuenta[6];
			$cuentas[$row[0]]["rp"]=$arregloCuenta[7];
			$cuentas[$row[0]]["cxp"]=$arregloCuenta[8];
			$cuentas[$row[0]]["egreso"]=$arregloCuenta[9];
			$cuentas[$row[0]]["saldo"]=$arregloCuenta[10];
			$cuentas[$row[0]]["tipo"]="Auxiliar";
			$cuentas[$row[0]]["entidad"]=$row[9];

			}else{
			
			$cuentas[$row[0]]["numCuenta"]=$row[0];
			$cuentas[$row[0]]["nomCuenta"]=$row[1];
			$cuentas[$row[0]]["presuInicial"]=0;
			$cuentas[$row[0]]["fuenCuenta"]=obtenerFuente($row[3],$row[4]);
			$cuentas[$row[0]]["adicion"]=0;
			$cuentas[$row[0]]["reduccion"]=0;
			$cuentas[$row[0]]["credito"]=0;
			$cuentas[$row[0]]["conCredito"]=0;
			$cuentas[$row[0]]["presuDefinitivo"]=0;
			$cuentas[$row[0]]["cdp"]=0;
			$cuentas[$row[0]]["rp"]=0;
			$cuentas[$row[0]]["cxp"]=0;
			$cuentas[$row[0]]["egreso"]=0;
			$cuentas[$row[0]]["saldo"]=0;
			$cuentas[$row[0]]["tipo"]="Mayor";
			$cuentas[$row[0]]["entidad"]=$row[9];
			$cuentaPadre[]=$row[0];
			}
			}else{
			$vectorcuentas=generaVectorTercero($row[0]);
			$cuentas[$row[0]]["numCuenta"]=$row[0];
			$cuentas[$row[0]]["nomCuenta"]=$row[1];
			$cuentas[$row[0]]["presuInicial"]=$vectorcuentas[0];
			$cuentas[$row[0]]["fuenCuenta"]=obtenerFuente($row[3],$row[4]);
			$cuentas[$row[0]]["adicion"]=$vectorcuentas[1];
			$cuentas[$row[0]]["reduccion"]=$vectorcuentas[2];
			$cuentas[$row[0]]["credito"]=$vectorcuentas[3];
			$cuentas[$row[0]]["conCredito"]=$vectorcuentas[4];
			$cuentas[$row[0]]["presuDefinitivo"]=$vectorcuentas[5];
			$cuentas[$row[0]]["cdp"]=$vectorcuentas[6];
			$cuentas[$row[0]]["rp"]=$vectorcuentas[7];
			$cuentas[$row[0]]["cxp"]=$vectorcuentas[8];
			$cuentas[$row[0]]["egreso"]=$vectorcuentas[10];
			$cuentas[$row[0]]["saldo"]=$vectorcuentas[11];
			$cuentas[$row[0]]["tipo"]=$row[2];
			$cuentas[$row[0]]["entidad"]=$row[9];
			}
			

		}
	
		}
			function generaVectorTercero($cuenta){
				global $linkbd,$vigencia,$f1,$f2;
				$ejecucionxcuenta=Array();
				$sql="SELECT * FROM entidadesgastos,pptocuentashomologacion WHERE entidadesgastos.vigencia='$vigencia' AND pptocuentashomologacion.cuentacentral='$cuenta' AND pptocuentashomologacion.cuentaexterna=entidadesgastos.cuenta  AND pptocuentashomologacion.vigencia='$vigencia' AND entidadesgastos.fecha between '$f1' AND '$f2' ";
				//echo $sql;
				$res=mysql_query($sql,$linkbd);
				while ($row = mysql_fetch_row($res)){
					$ejecucionxcuenta[0]=$row[2];  //Inicial
					$ejecucionxcuenta[1]=$row[3];  //Adicion
					$ejecucionxcuenta[2]=$row[4];  //Reduccion
					$ejecucionxcuenta[3]=$row[5];  //Creditos
					$ejecucionxcuenta[4]=$row[6];  //Contracredito
					$ejecucionxcuenta[5]=$row[7];  //Definitivo
					$ejecucionxcuenta[6]=$row[8];  //cdp
					$ejecucionxcuenta[7]=$row[9];  //rp
					$ejecucionxcuenta[8]=$row[10];  //cxp
					$ejecucionxcuenta[9]=$row[11];  //compromiso en ejec.
					$ejecucionxcuenta[10]=$row[12];  //egreso
					$ejecucionxcuenta[11]=$row[14];  //saldo
					$ejecucionxcuenta[12]=$row[15];  //unidad
					$ejecucionxcuenta[13]=$row[16];  //vigencia
					$ejecucionxcuenta[14]=$row[17];  //trimestre
				}
			return $ejecucionxcuenta;
			}
			
			function buscaCuentasHijo($cuenta){
			global $cuentas,$linkbd,$vigencia,$f1,$f2,$cuentaPadre;
			$arreglo=Array('0','1','2','3','4','5','6','7','8','9');
			$numcuenta=strlen($cuenta);
			if($cuenta=="01-A.1"){
				$cuenta=$cuenta.".";
			}
			if($cuenta=="01-A.1.1"){
				$cuenta=$cuenta.".";
			}
			if($cuenta=="4.1"){
				$cuenta=$cuenta.".";
			}
			if(($numcuenta==1 || $numcuenta==2) && !in_array($cuenta, $arreglo)){
				$sql="SELECT cuenta FROM pptocuentas WHERE cuenta LIKE '%$cuenta%' AND estado='S' AND clasificacion NOT LIKE '%ingresos%' AND (vigencia=$vigencia OR vigenciaf=$vigencia) AND (tipo='Auxiliar' OR tipo='auxiliar')";
			}else{
				$sql="SELECT cuenta FROM pptocuentas WHERE cuenta LIKE '$cuenta%' AND estado='S' AND clasificacion NOT LIKE '%ingresos%' AND (vigencia=$vigencia OR vigenciaf=$vigencia) AND (tipo='Auxiliar' OR tipo='auxiliar')";
			}
		
			$result=mysql_query($sql,$linkbd);
			$acumpptoini=0.0;
			$acumadic=0.0;
			$acumredu=0.0;
			$acumcred=0.0;
			$acumcontra=0.0;
			$acumpptodef=0.0;
			$acumcdp=0.0;
			$acumrp=0.0;
			$acumcxp=0.0;
			$acumegreso=0.0;
			$acumsaldo=0.0;
			while($row = mysql_fetch_array($result)){
			
				$acumpptoini+=$cuentas[$row[0]]["presuInicial"];
				$acumadic+=$cuentas[$row[0]]["adicion"];
				$acumredu+=$cuentas[$row[0]]["reduccion"];
				$acumcred+=$cuentas[$row[0]]["credito"];
				$acumcontra+=$cuentas[$row[0]]["conCredito"];
				$acumcdp+=$cuentas[$row[0]]["cdp"];
				$acumrp+=$cuentas[$row[0]]["rp"];
				$acumcxp+=$cuentas[$row[0]]["cxp"];
				$acumegreso+=$cuentas[$row[0]]["egreso"];
				$acumsaldo+=$cuentas[$row[0]]["saldo"];
				$acumpptodef+=$cuentas[$row[0]]["presuDefinitivo"];
			}

			//******
			$sql="SELECT cuenta FROM pptocuentasentidades WHERE cuenta LIKE '$cuenta%' AND estado='S' AND clasificacion NOT LIKE '%ingresos%' AND vigencia=$vigencia AND (tipo='Auxiliar' OR tipo='auxiliar')";
			$result=mysql_query($sql,$linkbd);
			while($row = mysql_fetch_array($result)){
			
				$acumpptoini+=$cuentas[$row[0]]["presuInicial"];
				$acumadic+=$cuentas[$row[0]]["adicion"];
				$acumredu+=$cuentas[$row[0]]["reduccion"];
				$acumcred+=$cuentas[$row[0]]["credito"];
				$acumcontra+=$cuentas[$row[0]]["conCredito"];
				$acumcdp+=$cuentas[$row[0]]["cdp"];
				$acumrp+=$cuentas[$row[0]]["rp"];
				$acumcxp+=$cuentas[$row[0]]["cxp"];
				$acumegreso+=$cuentas[$row[0]]["egreso"];
				$acumsaldo+=$cuentas[$row[0]]["saldo"];
				$acumpptodef+=$cuentas[$row[0]]["presuDefinitivo"];
			}
			//**
			if($cuenta=="01-A.1."){
				$cuenta=substr($cuenta,0,strlen($cuenta)-1);
			}
			if($cuenta=="01-A.1.1."){
				$cuenta=substr($cuenta,0,strlen($cuenta)-1);
			}
			if($cuenta=="4.1."){
				$cuenta=substr($cuenta,0,strlen($cuenta)-1);
			}
			$cuentas[$cuenta]["presuInicial"]=$acumpptoini;
			$cuentas[$cuenta]["adicion"]=$acumadic;
			$cuentas[$cuenta]["reduccion"]=$acumredu;
			$cuentas[$cuenta]["credito"]=$acumcred;
			$cuentas[$cuenta]["conCredito"]=$acumcontra;
			$cuentas[$cuenta]["cdp"]=$acumcdp;
			$cuentas[$cuenta]["rp"]=$acumrp;
			$cuentas[$cuenta]["cxp"]=$acumcxp;
			$cuentas[$cuenta]["egreso"]=$acumegreso;
			$cuentas[$cuenta]["saldo"]=$acumsaldo;
			$cuentas[$cuenta]["presuDefinitivo"]=$acumpptodef;



		}
		function obtenerFuente($fuenFuncion,$fuenInversion){
		global $linkbd;
		$codigo='';
		$nombre='';
		if(!empty($fuenFuncion) && $fuenFuncion!=null){
			$sql="SELECT codigo,nombre FROM pptofutfuentefunc WHERE codigo=$fuenFuncion";
		}else{
			$sql="SELECT codigo,nombre FROM pptofutfuenteinv WHERE codigo=$fuenInversion";
		}
		$result=mysql_query($sql,$linkbd);
		while($row = mysql_fetch_array($result)){
			$codigo = $row[0];
			$nombre = $row[1];
			break;
		}
		return $codigo." - ".$nombre;
		}
		function generaCuenta($cuenta){
		global $cuentas;
		$arreglo=Array($cuentas[$cuenta]['presuInicial'],$cuentas[$cuenta]['adicion'],$cuentas[$cuenta]['reduccion'],$cuentas[$cuenta]['credito'],$cuentas[$cuenta]['conCredito'],$cuentas[$cuenta]['presuDefinitivo'],$cuentas[$cuenta]['cdp'],$cuentas[$cuenta]['rp'],$cuentas[$cuenta]['cxp'],$cuentas[$cuenta]['egreso'],$cuentas[$cuenta]['saldo']);
		return $arreglo;	
		}

	?>
	   <div id="bgventanamodal2">
                <div id="ventanamodal2">
                    <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                    </IFRAME>
                </div>
       	 	</div>
</form>
<script type="text/javascript">

        	jQuery(function($){
        		if(jQuery){
        				var countChecked = function() {
						  var texto="";
							
						  $("input[name=unidad]").change(function(){
						  		if($(this).attr("class")=="01" && $(this).is(":checked")){
						  		$('input[name=clasifica]').attr("disabled",false);
						  		$('input[name=clasifica]').closest('label').css('color','black');
						  		}else if($(this).attr("class")=="01" && !($(this).is(":checked"))){
						  			if($("input[name=unidad][class=02]").is(":checked") || $("input[name=unidad][class=03]").is(":checked")){
						  				$('input[name=clasifica]').not(document.getElementById( "14" )).attr("disabled",true);
						  				$('input[name=clasifica]').not(document.getElementById( "14" )).closest('label').css('color','#BDBDBD');
						  				
						  			}else{
						  				$('input[name=clasifica]').attr("disabled",true);
						  				$('input[name=clasifica]').closest('label').css('color','#BDBDBD');
						  			}
						  
						  		$('input[name=clasifica]').attr("checked",false);
						  		
						  		}
						  		if($(this).attr("class")=="02" && $(this).is(":checked")){
						  		$('input[name=clasifica][id=14]').attr("disabled",false);
						  		$('input[name=clasifica][id=14]').closest('label').css('color','black');
						  		}else if($(this).attr("class")=="02" && !($(this).is(":checked"))){

						  			if($("input[name=unidad][class=01]").is(":checked") || $("input[name=unidad][class=03]").is(":checked")){
						  				$('input[name=clasifica][id=14]').attr("disabled",false);
						  				$('input[name=clasifica][id=14]').closest('label').css('color','black');
						  				
						  			}else{
						  				$('input[name=clasifica][id=14]').attr("disabled",true);
						  				$('input[name=clasifica][id=14]').closest('label').css('color','#BDBDBD');
						  			}

					
						  		$('input[name=clasifica][id=14]').attr("checked",false);
						  		
						  		}
						  		if($(this).attr("class")=="03" && $(this).is(":checked")){
						  		$('input[name=clasifica][id=14]').attr("disabled",false);
						  		$('input[name=clasifica][id=14]').closest('label').css('color','black');
						  		}else if($(this).attr("class")=="03" && !($(this).is(":checked"))){
						  		if($("input[name=unidad][class=01]").is(":checked") || $("input[name=unidad][class=02]").is(":checked")){
						  				$('input[name=clasifica][id=14]').attr("disabled",false);
						  				$('input[name=clasifica][id=14]').closest('label').css('color','black');
						  				
						  			}else{
						  				$('input[name=clasifica][id=14]').attr("disabled",true);
						  				$('input[name=clasifica][id=14]').closest('label').css('color','#BDBDBD');
						  			}

					
						  		$('input[name=clasifica][id=14]').attr("checked",false);
						  		}
						  });


						  $( "input[name=unidad]:checked" ).each(function(){
						  	texto+=($(this).attr('class'))+"-";

						  });

					

						  if(texto==''){
						  	$( "#texto" ).text("Selecciona...");
						  }else{
						  	$( "#texto" ).text(texto.substring(0,texto.length-1));
						  	$('input[name=filtros]').val(texto.substring(0,texto.length-1));
						  }
						  
						};

						var countChecked1 = function() {
						  var texto="";
						 
						  $( "input[name=clasifica]:checked" ).each(function(){
						  	texto+=($(this).attr('id'))+"-";
						  });
						  if(texto==''){
						  	$( "#texto1" ).text("Selecciona...");
						  }else{
						  	$( "#texto1" ).text(texto.substring(0,texto.length-1));
						  	$('input[name=filtrosclases]').val(texto.substring(0,texto.length-1));
						  	

						  }
						  
						};

						countChecked();
						countChecked1();
        				$( "input[name=unidad][type=checkbox]" ).on( "click", countChecked );
        				$( "input[name=clasifica][type=checkbox]" ).on( "click", countChecked1 );

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
        					if($(this).attr('id')=='9'){
        					
        						$('#col9').css('width',$(this).css('width'));
        					}
        					if($(this).attr('id')=='10'){
        					
        						$('#col10').css('width',$(this).css('width'));
        					}
        					if($(this).attr('id')=='11'){
        					
        						$('#col11').css('width',$(this).css('width'));
        					}
        					if($(this).attr('id')=='12'){
        					
        						$('#col12').css('width',$(this).css('width'));
        					}
        					if($(this).attr('id')=='13'){
        					
        						$('#col13').css('width',$(this).css('width'));
        					}
        					if($(this).attr('id')=='14'){
        					
        						$('#col14').css('width',$(this).css('width'));
        					}
        					if($(this).attr('id')=='15'){
        					
        						$('#col15').css('width',$(this).css('width'));
        					}
        				});
        				
        			}
        		
        	});	
        	
        </script>

        <script>
 jQuery(function($){
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
</html>