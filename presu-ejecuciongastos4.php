<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
	error_reporting(0);
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
  				<td colspan="3" class="cinta"><a href="#" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a> <a href="#" class="mgbt" onClick="document.form2.submit();"><img src="imagenes/guarda.png" title="Guardar"/></a> <a href="#" onClick="document.form2.submit()" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a> <a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a> <a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png" title="imprimir"></a> <a href="#" onClick="excell()" class="mgbt"><img src="imagenes/excel.png" title="excel"></a> <a href="presu-ejecucionpresupuestal.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a></td>
          	</tr>
		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>	  
		<form name="form2" method="post" action="presu-ejecuciongastos4.php">
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
   			 /* $linkbd=conectar_bd();
			  $sqlr="select *from pptocuentaspptoinicial where cuenta=$_POST[cuenta] and vigencia=". $vigusu;
			  $res=mysql_query($sqlr,$linkbd);
			  $row=mysql_fetch_row($res);
			  $_POST[valor]=$row[5];		  
			  $_POST[valor2]=$row[5];	*/	  			  

				}
				else
				{
					$_POST[ncuenta]="";	
				}
			}
 ?>
    <table  align="center" class="inicio" >
		<tr >
			<td class="titulos" colspan="8">.: Ejecucion Gastos</td>
			<td width="7%" class="cerrar"><a href="presu-principal.php">Cerrar</a></td>
		</tr>
		<tr>      
			<td width="10%" class="saludo1">Fecha Inicial:</td>
			<td width="10%"><input type="hidden" value="<?php echo $ $vigusu ?>" name="vigencias"><input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">         <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/calendario04.png" style="width:20px;" align="absmiddle" border="0"></a>        </td>
			<td width="10%" class="saludo1">Fecha Final: </td>
			<td width="10%"><input name="fecha2" type="text" id="fc_1198971546" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha2]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10"> <a href="#" onClick="displayCalendarFor('fc_1198971546');"><img src="imagenes/calendario04.png" style="width:20px;" align="absmiddle" border="0"></a>  
			</td>
			<td style="width=5%" class="saludo1">Ver: </td>
			<td style="width=10%">
				<select name="vereg" id="vereg" style='width: 100%;'>
					<option value="1" <?php if($_POST[vereg]=='1') echo 'selected="selected"'; ?> >TODOS</option>
					<option value="2" <?php if($_POST[vereg]=='2') echo 'selected="selected"'; ?> >SGR</option>
				</select>
			</td>
			<td width="5%">
				<input type="button" name="generar" value="Generar" onClick="validar()"> 
				<input type="hidden" value="<?php echo $_POST[oculto]; ?>" name="oculto" id="oculto">
			</td>
			<td width="33%"></td>
		</tr> 
			<tr> 
    			<td class="saludo1" >Cuenta Inicial:</td>
        		<td><input name="cuenta1" type="text" id="cuenta1" size="10" value="<?php echo $_POST[cuenta1]; ?>"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this) " tabindex="6"/>&nbsp;<a href="#" tabindex="7" onClick="despliegamodal2('visible','cuenta1')"><img src="imagenes/find02.png" style="width:20px;" align="absmiddle" border="0"></a></td>
        		<td class="saludo1" >Cuenta Final:</td>
				<td><input name="cuenta2" type="text" id="cuenta2" size="10" value="<?php echo $_POST[cuenta2]; ?>"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this) " tabindex="8">&nbsp;<a href="#" tabindex="9" onClick="despliegamodal2('visible','cuenta2')"><img src="imagenes/find02.png" style="width:20px;" align="absmiddle" border="0"></a></td>
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
		
		echo "<div class='subpantallac5' style='height:65%; width:99.6%; margin-top:0px; overflow-x:hidden' id='divdet'>
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
				<td id='col14' >Saldo</td>
				
			</tr>
				<tbody>";
					
	   		$cuentasInvertidas=array_reverse($cuentas); //cuentas
	   		$cuentasNuevas=Array();
	

	   		foreach ($cuentasInvertidas as $key => $value) {
	   			
	   			$cadena=$cuentasInvertidas[$key]["numCuenta"];
				$posi=stripos($cadena,'-');
				$posf=strrpos($cadena,'-');
				$entra=true;
				if($posi!=false && $posf!=false){
					if($posi!=$posf && !in_array(substr($cadena, 0,$posf),$cuentaPadre)){
						for ($n=0; $n < sizeof($vectorDif); $n++) { 
							if(substr($cadena, $posi+1,$posf-3)==$vectorDif[$n]){
								//echo $vectorDif[$n];
								$cuentasInvertidas[$vectorDif[$n]]["presuInicial"]+=$cuentasInvertidas[$key]["presuInicial"];
								$cuentasInvertidas[$vectorDif[$n]]["adicion"]+=$cuentasInvertidas[$key]["adicion"];
								$cuentasInvertidas[$vectorDif[$n]]["reduccion"]+=$cuentasInvertidas[$key]["reduccion"];
								$cuentasInvertidas[$vectorDif[$n]]["credito"]+=$cuentasInvertidas[$key]["credito"];
								$cuentasInvertidas[$vectorDif[$n]]["conCredito"]+=$cuentasInvertidas[$key]["conCredito"];
								$cuentasInvertidas[$vectorDif[$n]]["presuDefinitivo"]+=$cuentasInvertidas[$key]["presuDefinitivo"];
								$cuentasInvertidas[$vectorDif[$n]]["cdp"]+=$cuentasInvertidas[$key]["cdp"];
								$cuentasInvertidas[$vectorDif[$n]]["rp"]+=$cuentasInvertidas[$key]["rp"];
								$cuentasInvertidas[$vectorDif[$n]]["cxp"]+=$cuentasInvertidas[$key]["cxp"];
								$cuentasInvertidas[$vectorDif[$n]]["egreso"]+=$cuentasInvertidas[$key]["egreso"];
								$cuentasInvertidas[$vectorDif[$n]]["saldo"]+=$cuentasInvertidas[$key]["saldo"];


								$cuentasInvertidas['FA']["presuInicial"]+=$cuentasInvertidas[$key]["presuInicial"];
								$cuentasInvertidas['FA']["adicion"]+=$cuentasInvertidas[$key]["adicion"];
								$cuentasInvertidas['FA']["reduccion"]+=$cuentasInvertidas[$key]["reduccion"];
								$cuentasInvertidas['FA']["credito"]+=$cuentasInvertidas[$key]["credito"];
								$cuentasInvertidas['FA']["conCredito"]+=$cuentasInvertidas[$key]["conCredito"];
								$cuentasInvertidas['FA']["presuDefinitivo"]+=$cuentasInvertidas[$key]["presuDefinitivo"];
								$cuentasInvertidas['FA']["cdp"]+=$cuentasInvertidas[$key]["cdp"];
								$cuentasInvertidas['FA']["rp"]+=$cuentasInvertidas[$key]["rp"];
								$cuentasInvertidas['FA']["cxp"]+=$cuentasInvertidas[$key]["cxp"];
								$cuentasInvertidas['FA']["egreso"]+=$cuentasInvertidas[$key]["egreso"];
								$cuentasInvertidas['FA']["saldo"]+=$cuentasInvertidas[$key]["saldo"];

								$entra=false;
								break;
							}
						}
						
					}
				}
		
				if($entra){

					for ($l=2; $l <20 ; $l++) { 

	   				if($l<=strlen($cuentasInvertidas[$key]["numCuenta"])){
	   					$sub=substr($cuentasInvertidas[$key]["numCuenta"],0,strlen($cuentasInvertidas[$key]["numCuenta"])-$l);
	   					if(in_array($sub,$cuentaPadre) && $sub!='FA'){
	   					$cuentasInvertidas[$sub]["presuInicial"]+=$cuentasInvertidas[$key]["presuInicial"];
	   					$cuentasInvertidas[$sub]["adicion"]+=$cuentasInvertidas[$key]["adicion"];
	   					$cuentasInvertidas[$sub]["reduccion"]+=$cuentasInvertidas[$key]["reduccion"];
	   					$cuentasInvertidas[$sub]["credito"]+=$cuentasInvertidas[$key]["credito"];
	   					$cuentasInvertidas[$sub]["conCredito"]+=$cuentasInvertidas[$key]["conCredito"];
	   					$cuentasInvertidas[$sub]["presuDefinitivo"]+=$cuentasInvertidas[$key]["presuDefinitivo"];
	   					$cuentasInvertidas[$sub]["cdp"]+=$cuentasInvertidas[$key]["cdp"];
	   					$cuentasInvertidas[$sub]["rp"]+=$cuentasInvertidas[$key]["rp"];
	   					$cuentasInvertidas[$sub]["cxp"]+=$cuentasInvertidas[$key]["cxp"];
	   					$cuentasInvertidas[$sub]["egreso"]+=$cuentasInvertidas[$key]["egreso"];
	   					$cuentasInvertidas[$sub]["saldo"]+=$cuentasInvertidas[$key]["saldo"];
	   					break;
	   					}

	   				}else{
	   					break;
	   				}
	   					
	   				}

	   				for ($a=0; $a < sizeof($vectorDif); $a++) { 
					$domain = stripos($cuentasInvertidas[$key]["numCuenta"], "-".$vectorDif[$a]);
					if($domain!=false){
						$ultimo=substr($cuentasInvertidas[$key]["numCuenta"], $domain+strlen("-".$vectorDif[$a]),strlen($cuentasInvertidas[$key]["numCuenta"]));


						$tam=strlen($ultimo);
						
						$diferencia=1;
						if($vectorDif[$a]=='A'){
							$diferencia=3;
						}else{
							$diferencia=1;
						}
						if($vectorDif[$a]=='T'){
							$diferencia=2;
						}
						if($tam<=$diferencia){
							//echo "A esta cuenta ".$cuentasInvertidas[$key]["numCuenta"]." le corresponde ".$vectorDif[$a]."Con valor de ".$cuentasInvertidas[$key]["presuInicial"]."<br>";
							$cuentasInvertidas[$vectorDif[$a]]["presuInicial"]+=$cuentasInvertidas[$key]["presuInicial"];
							$cuentasInvertidas[$vectorDif[$a]]["adicion"]+=$cuentasInvertidas[$key]["adicion"];
							$cuentasInvertidas[$vectorDif[$a]]["reduccion"]+=$cuentasInvertidas[$key]["reduccion"];
							$cuentasInvertidas[$vectorDif[$a]]["credito"]+=$cuentasInvertidas[$key]["credito"];
							$cuentasInvertidas[$vectorDif[$a]]["conCredito"]+=$cuentasInvertidas[$key]["conCredito"];
							$cuentasInvertidas[$vectorDif[$a]]["presuDefinitivo"]+=$cuentasInvertidas[$key]["presuDefinitivo"];
							$cuentasInvertidas[$vectorDif[$a]]["cdp"]+=$cuentasInvertidas[$key]["cdp"];
							$cuentasInvertidas[$vectorDif[$a]]["rp"]+=$cuentasInvertidas[$key]["rp"];
							$cuentasInvertidas[$vectorDif[$a]]["cxp"]+=$cuentasInvertidas[$key]["cxp"];
							$cuentasInvertidas[$vectorDif[$a]]["egreso"]+=$cuentasInvertidas[$key]["egreso"];
							$cuentasInvertidas[$vectorDif[$a]]["saldo"]+=$cuentasInvertidas[$key]["saldo"];
							//echo "La cuenta $vectorDif[$a] esta con valor: ".$cuentasInvertidas[$vectorDif[$a]]["presuInicial"]."<br>";
						}
					}
	   			}
				}
	   			
	   			
	   		}
	   			
			foreach ($cuentas as $key => $value) {

					$numeroCuenta=$cuentas[$key]['numCuenta'];
					$nombreCuenta=$cuentas[$key]['nomCuenta'];
					$fuenteCuenta=$cuentas[$key]['fuenCuenta'];
					$presupuestoInicial=number_format($cuentas[$key]['presuInicial'],2,",",".");
					$adicion=number_format($cuentas[$key]['adicion'],2,",",".");
					$reduccion=number_format($cuentas[$key]['reduccion'],2,",",".");
					$credito=number_format($cuentas[$key]['credito'],2,",",".");
					$contracredito=number_format($cuentas[$key]['conCredito'],2,",",".");
					$presupuestoDefinitivo=number_format($cuentas[$key]['presuDefinitivo'],2,",",".");
					$cdp=number_format($cuentas[$key]['cdp'],2,",",".");
					$rp=number_format($cuentas[$key]['rp'],2,",",".");
					$cxp=number_format($cuentas[$key]['cxp'],2,",",".");
					$egreso=number_format($cuentas[$key]['egreso'],2,",",".");
					$saldo=number_format($cuentas[$key]['saldo'],2,",",".");
					$tipo=$cuentas[$key]['tipo'];
					$tasa=$cuentas[$key]['tasa'];
					$style='';
					if($saldo<0){
						$style='background: yellow';
					}

					if(!empty($numeroCuenta)){  //----bloque nuevo 17/01/2016
						if($tipo=='Auxiliar' || $tipo=='auxiliar'){
						echo "<tr style='font-size:9px; text-rendering: optimizeLegibility;$style' class='$iter'>";
					echo "<td id='1' style='width: 5%'>$numeroCuenta</td><td id='2' style='width: 20%'>$nombreCuenta</td><td id='3' style='width: 20%'>$fuenteCuenta</td><td id='4' style='width: 5.5%'>$presupuestoInicial</td><td id='5' style='width: 4.5%'>$adicion</td><td id='6' style='width: 4.5%'>$reduccion</td><td id='7' style='width: 4.5%'>$credito</td><td id='8' style='width: 4.5%'>$contracredito</td><td id='9' style='width: 5%'>$presupuestoDefinitivo</td><td id='10' style='width: 4.5%'>$cdp</td><td id='11' style='width: 4.5%'>$rp</td><td id='12' style='width: 4.5%'>$cxp</td><td id='13' style='width: 4.5%'>$egreso</td><td id='14' style='width: 4.5%'>$saldo</td>";
					echo "</tr>";
					}else{
						echo "<tr style='font-weight:bold; font-size:9px; text-rendering: optimizeLegibility' class='$iter'>";
					echo "<td id='1' style='width: 5%'>$numeroCuenta</td><td id='2' style='width: 20%'>$nombreCuenta</td><td id='3' style='width: 20%'>$fuenteCuenta</td><td id='4' style='width: 5.5%'>".number_format($cuentasInvertidas[$numeroCuenta][presuInicial],2,",",".")."</td><td id='5' style='width: 4.5%'>".number_format($cuentasInvertidas[$numeroCuenta][adicion],2,",",".")."</td><td id='6' style='width: 4.5%'>".number_format($cuentasInvertidas[$numeroCuenta][reduccion],2,",",".")."</td><td id='7' style='width: 4.5%'>".number_format($cuentasInvertidas[$numeroCuenta][credito],2,",",".")."</td><td id='8' style='width: 4.5%'>".number_format($cuentasInvertidas[$numeroCuenta][conCredito],2,",",".")."</td><td id='9' style='width: 5%'>".number_format($cuentasInvertidas[$numeroCuenta][presuDefinitivo],2,",",".")."</td><td id='10' style='width: 4.5%'>".number_format($cuentasInvertidas[$numeroCuenta][cdp],2,",",".")."</td><td id='11' style='width: 4.5%'>".number_format($cuentasInvertidas[$numeroCuenta][rp],2,",",".")."</td><td id='12' style='width: 4.5%'>".number_format($cuentasInvertidas[$numeroCuenta][cxp],2,",",".")."</td><td id='13' style='width: 4.5%'>".number_format($cuentasInvertidas[$numeroCuenta][egreso],2,",",".")."</td><td id='14' style='width: 4.5%'>".number_format($cuentasInvertidas[$numeroCuenta][saldo],2,",",".")."</td";
					echo "</tr>";
					$presupuestoInicial=number_format($cuentasInvertidas[$numeroCuenta][presuInicial],2,",",".");
					$adicion=number_format($cuentasInvertidas[$numeroCuenta][adicion],2,",",".");
					$reduccion=number_format($cuentasInvertidas[$numeroCuenta][reduccion],2,",",".");
					$credito=number_format($cuentasInvertidas[$numeroCuenta][credito],2,",",".");
					$contracredito=number_format($cuentasInvertidas[$numeroCuenta][conCredito],2,",",".");
					$presupuestoDefinitivo=number_format($cuentasInvertidas[$numeroCuenta][presuDefinitivo],2,",",".");
					$cdp=number_format($cuentasInvertidas[$numeroCuenta][cdp],2,",",".");
					$rp=number_format($cuentasInvertidas[$numeroCuenta][rp],2,",",".");
					$cxp=number_format($cuentasInvertidas[$numeroCuenta][cxp],2,",",".");
					$egreso=number_format($cuentasInvertidas[$numeroCuenta][egreso],2,",",".");
					$saldo=number_format($cuentasInvertidas[$numeroCuenta][saldo],2,",",".");
					}
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

				

			
		}
	
 		
		echo "</tbody></table>
		</div>";
		


		

		
	?> 
	
	<?php
	}

	function generaVectorCuenta($numCuenta,$vigencia,$fechaf,$fechaf2){
			$ejecucionxcuenta=Array();
			global $linkbd;
			$queryPresupuesto="SELECT valor,vigencia FROM pptocuentaspptoinicial WHERE cuenta='$numCuenta' AND vigencia=$vigencia";
		
			$result=mysql_query($queryPresupuesto, $linkbd);
			
						while($row=mysql_fetch_array($result)){
							
							$presuDefinitivo+=$row[0];
						 }

						$ejecucionxcuenta[0]=$presuDefinitivo;
						$querySalidaPresuDefi="SELECT SUM(D.valor) FROM pptocdp C, pptocdp_detalle D WHERE D.cuenta='$numCuenta' AND D.vigencia=$vigencia AND D.tipo_mov='201' AND D.consvigencia=C.consvigencia AND C.tipo_mov='201' AND C.vigencia=$vigencia AND NOT(D.estado='N' OR D.estado='R') AND C.fecha BETWEEN '$fechaf' AND '$fechaf2' GROUP BY D.cuenta";
						$valCDP=0.0;
						$result=mysql_query($querySalidaPresuDefi, $linkbd);
						if(mysql_num_rows($result)!=0){
							while($row=mysql_fetch_array($result)){
						$valCDP=$row[0];
						    }
						}

					$queryAdiciones="SELECT SUM(pad.valor),pad.id_adicion,pa.fecha FROM pptoadiciones pad,pptoacuerdos pa WHERE pad.cuenta='$numCuenta' AND pad.vigencia=$vigencia AND pa.id_acuerdo=pad.id_acuerdo AND pad.id_acuerdo>0 AND NOT(pa.estado='N') AND  pa.fecha BETWEEN '$fechaf' AND '$fechaf2' GROUP BY cuenta";

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
			


						$queryReducciones="SELECT SUM(pr.valor),pr.id_reduccion,pa.fecha FROM pptoreducciones pr,pptoacuerdos pa WHERE pr.cuenta='$numCuenta' AND pr.vigencia=$vigencia AND pr.id_acuerdo=pa.id_acuerdo AND pr.id_acuerdo>0 AND NOT(pa.estado='N') AND pa.fecha BETWEEN '$fechaf' AND '$fechaf2' GROUP BY pr.cuenta";

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
			

						$queryTraslados="SELECT pt.id_acuerdo,pt.tipo,SUM(pt.valor),pa.fecha FROM pptotraslados pt,pptoacuerdos pa WHERE pt.cuenta='$numCuenta' AND pt.vigencia=$vigencia AND pt.id_acuerdo>0 AND  pt.id_acuerdo=pa.id_acuerdo AND NOT(pa.estado='N') AND pa.fecha BETWEEN '$fechaf' AND '$fechaf2' GROUP BY pt.id_acuerdo";

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
			$queryTraslados="SELECT C.consvigencia,C.fecha,C.objeto,C.tipo_mov,SUM(D.valor),D.tipo_mov FROM pptocdp C, pptocdp_detalle D WHERE D.cuenta='$numCuenta' AND D.vigencia=$vigencia AND D.consvigencia=C.consvigencia AND C.vigencia=$vigencia AND NOT(D.estado='N') AND D.valor>0 AND D.tipo_mov=C.tipo_mov AND C.fecha BETWEEN '$fechaf' AND '$fechaf2' GROUP BY C.consvigencia,C.tipo_mov";
		
				$result=mysql_query($queryTraslados, $linkbd);
						if(mysql_num_rows($result)!=0){
							while($row=mysql_fetch_array($result)){
							if($row[5]=='201'){
								$totalCDPEnt+=$row[4];
							}else if(($row[5]=='401') || ($row[5]=='402')){
								$totalCDPEnt-=$row[4];
							}
							
						}
						}
			$ejecucionxcuenta[6]=$totalCDPEnt;

						$totalRPEnt=0;
						$totalRPSal=0;
						$arregloRP=Array();
						
						$queryTraslados="SELECT R.consvigencia,R.fecha,R.tipo_mov,SUM(RD.valor),RD.tipo_mov FROM pptorp R,pptorp_detalle RD where  R.vigencia=$vigencia AND RD.cuenta='$numCuenta' AND RD.consvigencia=R.consvigencia AND RD.vigencia=$vigencia  AND NOT(R.estado='N') AND R.tipo_mov=RD.tipo_mov AND RD.valor>0 AND R.fecha BETWEEN '$fechaf' AND '$fechaf2' GROUP BY R.consvigencia,R.tipo_mov";
						$result=mysql_query($queryTraslados, $linkbd);
						if(mysql_num_rows($result)!=0){
					
							while($row=mysql_fetch_array($result)){
								if( $row[4]=='201'){
								$totalRPEnt+=$row[3];
								$arregloRP[]=$row[0];
							}else if(( $row[4]=='401') || ($row[4]=='402')){
								$totalRPEnt-=$row[3];
							}
							
							
						
						}
						}
			$ejecucionxcuenta[7]=$totalRPEnt;

						$totalCxPEnt=0.0;
						$totalCxPSal=0.0;
						$queryTraslados="SELECT T.id_orden,T.fecha,T.tipo_mov,TD.valor,T.estado,TD.tipo_mov FROM tesoordenpago T,tesoordenpago_det TD WHERE T.vigencia=$vigencia  AND T.id_orden=TD.id_orden AND NOT(T.estado='N') AND TD.valor>0 AND TD.cuentap='$numCuenta' AND T.tipo_mov=TD.tipo_mov AND T.fecha BETWEEN '$fechaf' AND '$fechaf2'";
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
							$totalCxPEnt+=$row[2];
							$totalCxPSal+=$row[2];
							break;

						}
						}

						}
						

			$ejecucionxcuenta[8]=$totalCxPEnt;
			
				
						$totalEgresoSal=0.0;
						$queryTraslados="SELECT TE.id_egreso,TE.fecha,TE.tipo_mov,TD.valor FROM tesoegresos TE,tesoordenpago_det TD where TE.vigencia=$vigencia AND TD.cuentap='$numCuenta' AND TE.id_orden=TD.id_orden AND  NOT(TE.estado='N') AND TD.valor >0 AND TE.fecha BETWEEN '$fechaf' AND '$fechaf2'";
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
	
		function cuentasAux(){
		global $cuentas,$linkbd,$vigencia,$f1,$f2,$cuentaPadre,$cuentaInicial,$cuentaFinal,$vectorDif;
		$datosBase=datosiniciales();
		$orden='cuenta+0,cuenta';
		$municipio="cumaribo";
		$baseDatos=$datosBase[0];
		//if(substr($baseDatos,0,strlen($municipio))=="cumaribo"){
			//$orden.="+0,cuenta";
			$cuentasDif="SELECT cuenta FROM pptocuentas WHERE estado='S' AND clasificacion NOT LIKE '%ingresos%' AND (vigencia=$vigencia OR vigenciaf=$vigencia) AND cuenta like 'A%' OR cuenta like 'F%' OR cuenta like 'T%' ORDER BY $orden";
			$resultado=mysql_query($cuentasDif,$linkbd);
			while($row1 = mysql_fetch_row($resultado)){
				$vectorDif[]=$row1[0];
			}
		//}
		if(empty($cuentaInicial) || empty($cuentaFinal)){
			$sql="SELECT cuenta,nombre,tipo,futfuentefunc,futfuenteinv FROM pptocuentas WHERE estado='S' AND clasificacion NOT LIKE '%ingresos%' AND (vigencia=$vigencia OR vigenciaf=$vigencia) ORDER BY $orden ";
		}else{
			$sql="SELECT cuenta,nombre,tipo,futfuentefunc,futfuenteinv FROM pptocuentas WHERE estado='S' AND clasificacion NOT LIKE '%ingresos%' AND (vigencia=$vigencia OR vigenciaf=$vigencia) AND cuenta>=$cuentaInicial AND cuenta<=$cuentaFinal ORDER BY $orden  ";
		}
		$result=mysql_query($sql,$linkbd);

		while($row = mysql_fetch_array($result)){
			if($row[2]=='Auxiliar' || $row[2]=='auxiliar'){
			$arregloCuenta=generaVectorCuenta($row[0],$vigencia,$f1,$f2);
			$cuentas[$row[0]]["numCuenta"]=$row[0];
			$cuentas[$row[0]]["nomCuenta"]=$row[1];
			$cuentas[$row[0]]["presuInicial"]=$arregloCuenta[0];
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

			}else{
			
			$cuentas[$row[0]]["numCuenta"]=$row[0];
			$cuentas[$row[0]]["nomCuenta"]=$row[1];
			$cuentas[$row[0]]["presuInicial"]=0;
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
			$cuentaPadre[]=$row[0];
			}
			


		}

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
</body>
</html>