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
				document.form2.action="pdfauxiliargaspres.php";
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
		<form name="form2" method="post" action="presu-auxiliarcuenta.php">
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
					<td ><input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return 	tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">         <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>        
					</td>
					<td class="saludo1">Fecha Final: </td>
					<td ><input name="fecha2" type="text" id="fc_1198971546" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha2]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">         <a href="#" onClick="displayCalendarFor('fc_1198971546');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>       <input type="button" name="generar" value="Generar" onClick="validar()"> <input type="hidden" value="1" name="oculto" id="oculto"> 
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
			<div class="subpantallap" style="height:67%; width:99.6%; overflow-x:hidden;">
				<?php
				//**** para sacar la consulta del balance se necesitan estos datos ********
				//**** nivel, mes inicial, mes final, cuenta inicial, cuenta final, cc inicial, cc final  
				$oculto=$_POST['oculto'];
				if($correcto==1)
				{
					if($todos==0){
						//año anterior
						$_POST[tiporec]=array();
						//		$_POST[valrec]=array();
						$totsa=0;
						$sumada=0;
						$sumaca=0;	
						$pia=0;
						$pada=0;
						$preda=0;
						$ptraa=0;
						$pdefa=0;
						$cdpsa=0;
						$rpsa=0;
						$cxpa=0;
						$pagosa=0;
		
						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
						$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
						$fechaf2=$fecha[3]."-".$fecha[2]."-".$fecha[1];	
						$fechafa=($fecha[3]-1)."-01-01";
						$fechaf2a=($fecha[3]-1)."-12-31";
						//$ti=substr($_POST[cuenta],0,1);
						$ti=2;
						echo "<table class='inicio' ><tr><td colspan='6' class='titulos'>Auxiliar por Cuenta</td></tr>";
						echo "<tr><td class='titulos2'>TIPO COMPROBANTE</td><td class='titulos2'>No COMPROBANTE</td><td class='titulos2'>FECHA</td><td class='titulos2'>DETALLE</td><td class='titulos2'>VALOR</td></tr>";
						//$nc=buscacuentap($_POST[cuenta]);
						$iter='zebra1';
						$iter2='zebra2';
						//******* INGRESOS SSF
						//****ppto inicial
						$sqlr3="SELECT 
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
						AND pptocomprobante_cab.fecha BETWEEN '$fechafa' AND '$fechaf2a'
						AND pptocomprobante_det.tipo_comp = 1 
						AND pptocomprobante_cab.tipo_comp = 1 		  
						AND pptocomprobante_det.cuenta = '".$_POST[cuenta]."' 		 
						ORDER BY pptocomprobante_cab.fecha,pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_det.cuenta";
						// echo "<br>".$sqlr3;
						$res=mysql_query($sqlr3,$linkbd);
						while($row =mysql_fetch_row($res))
						{
							$pia+=$row[1];
						}
						$pdefa+=$pia;
		
						//****ppto Adicion
						$sqlr3="SELECT 
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
						AND pptocomprobante_cab.fecha BETWEEN '$fechafa' AND '$fechaf2a'
						AND pptocomprobante_det.tipo_comp = 2 
						AND pptocomprobante_cab.tipo_comp = 2 		  
						AND pptocomprobante_det.cuenta = '".$_POST[cuenta]."' 		  
						ORDER BY pptocomprobante_cab.fecha,pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_det.cuenta";
						// echo "<br>".$sqlr3;
						$res=mysql_query($sqlr3,$linkbd);
						while($row =mysql_fetch_row($res))
						{
							$pada+=$row[1];
						}
						$pdefa+=$pada;
		
						//****ppto Reducciones
						$sqlr3="SELECT 
						pptocomprobante_det.cuenta,
						pptocomprobante_det.valdebito,
						pptocomprobante_det.valcredito, pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_cab.fecha
						FROM pptocomprobante_det, pptocomprobante_cab
						WHERE     pptocomprobante_cab.tipo_comp = pptocomprobante_det.tipo_comp
						AND pptocomprobante_det.numerotipo = pptocomprobante_cab.numerotipo
						AND pptocomprobante_cab.estado = 1
						AND (   pptocomprobante_det.valdebito > 0
						OR pptocomprobante_det.valcredito > 0)			   
						AND
						(pptocomprobante_cab.VIGENCIA=".$_POST[valor]." or pptocomprobante_cab.VIGENCIA=".$_POST[valor2].")
						and(pptocomprobante_det.VIGENCIA=".$_POST[valor]." or pptocomprobante_det.VIGENCIA=".$_POST[valor2].")
						and pptocomprobante_cab.VIGENCIA=pptocomprobante_det.VIGENCIA
						AND pptocomprobante_cab.fecha BETWEEN '$fechafa' AND '$fechaf2a'
						AND pptocomprobante_det.tipo_comp = 3 
						AND pptocomprobante_cab.tipo_comp = 3 		  
						AND pptocomprobante_det.cuenta = '".$_POST[cuenta]."' 		  
						ORDER BY pptocomprobante_cab.fecha,pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_det.cuenta";
						// echo "<br>".$sqlr3;
						$res=mysql_query($sqlr3,$linkbd);
						while($row =mysql_fetch_row($res))
						{
							$preda+=$row[2];
						}
						$pdefa-=$preda;	   
		   
						//****ppto Traslados
						$sqlr3="SELECT 
						pptocomprobante_det.cuenta,
						pptocomprobante_det.valdebito,
						pptocomprobante_det.valcredito, pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_cab.fecha
						FROM pptocomprobante_det, pptocomprobante_cab
						WHERE     pptocomprobante_cab.tipo_comp = pptocomprobante_det.tipo_comp
						AND pptocomprobante_det.numerotipo = pptocomprobante_cab.numerotipo
						AND pptocomprobante_cab.estado = 1
						AND (   pptocomprobante_det.valdebito > 0
						OR pptocomprobante_det.valcredito > 0)			   
						AND
						(pptocomprobante_cab.VIGENCIA=".$_POST[valor]." or pptocomprobante_cab.VIGENCIA=".$_POST[valor2].")
						and(pptocomprobante_det.VIGENCIA=".$_POST[valor]." or pptocomprobante_det.VIGENCIA=".$_POST[valor2].")
						and pptocomprobante_cab.VIGENCIA=pptocomprobante_det.VIGENCIA
						AND pptocomprobante_cab.fecha BETWEEN '$fechafa' AND '$fechaf2a'
						AND pptocomprobante_det.tipo_comp = 5 
						AND pptocomprobante_cab.tipo_comp = 5 		  
						AND pptocomprobante_det.cuenta LIKE '".$_POST[cuenta]."' 		  
						ORDER BY pptocomprobante_cab.fecha,pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_det.cuenta";
						//echo "<br>".$sqlr3;
						$res=mysql_query($sqlr3,$linkbd);
						while($row =mysql_fetch_row($res))
						{
							$ptraa=$ptraa+$row[1]-$row[2];
						}
						$pdefa+=$ptraa;	   
						//****ppto cdps
						$valorlibcdp=0;
						$sqlr3="SELECT 
						pptocomprobante_det.cuenta,
						pptocomprobante_det.valdebito,
						pptocomprobante_det.valcredito, pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_cab.fecha, pptocomprobante_cab.vigencia
						FROM pptocomprobante_det, pptocomprobante_cab
						WHERE     pptocomprobante_cab.tipo_comp = pptocomprobante_det.tipo_comp
						AND pptocomprobante_det.numerotipo = pptocomprobante_cab.numerotipo
						AND pptocomprobante_cab.estado = 1
						AND (   pptocomprobante_det.valdebito > 0
						OR pptocomprobante_det.valcredito > 0)			   
						AND
						(pptocomprobante_cab.VIGENCIA=".$_POST[valor]." or pptocomprobante_cab.VIGENCIA=".$_POST[valor2].")
						and(pptocomprobante_det.VIGENCIA=".$_POST[valor]." or pptocomprobante_det.VIGENCIA=".$_POST[valor2].")
						and pptocomprobante_cab.VIGENCIA=pptocomprobante_det.VIGENCIA
						AND pptocomprobante_cab.fecha BETWEEN '$fechafa' AND '$fechaf2a'
						AND pptocomprobante_det.tipo_comp = 6 
						AND pptocomprobante_cab.tipo_comp = 6 		  
						AND pptocomprobante_det.cuenta LIKE '".$_POST[cuenta]."' 		  
						ORDER BY pptocomprobante_cab.fecha,pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_det.cuenta";
						//echo "<br>".$sqlr3;
						$valorlibcdpa=0;
						$res=mysql_query($sqlr3,$linkbd);
						while($row =mysql_fetch_row($res))
						{
							$cdpsa+=$row[1];
							$valorlibcdpa+=$row[2];
						}

						//****ppto RPS
						$valorlibrpa=0;
						$sqlr3="SELECT 
						pptocomprobante_det.cuenta,
						pptocomprobante_det.valdebito,
						pptocomprobante_det.valcredito, pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_cab.fecha, pptocomprobante_cab.vigencia 
						FROM pptocomprobante_det, pptocomprobante_cab
						WHERE     pptocomprobante_cab.tipo_comp = pptocomprobante_det.tipo_comp
						AND pptocomprobante_det.numerotipo = pptocomprobante_cab.numerotipo
						AND pptocomprobante_cab.estado = 1
						AND (   pptocomprobante_det.valdebito > 0
						OR pptocomprobante_det.valcredito > 0)			   
						AND
						(pptocomprobante_cab.VIGENCIA=".$_POST[valor]." or pptocomprobante_cab.VIGENCIA=".$_POST[valor2].")
						and(pptocomprobante_det.VIGENCIA=".$_POST[valor]." or pptocomprobante_det.VIGENCIA=".$_POST[valor2].")
						and pptocomprobante_cab.VIGENCIA=pptocomprobante_det.VIGENCIA
						AND pptocomprobante_cab.fecha BETWEEN '$fechafa' AND '$fechaf2a'
						AND pptocomprobante_det.tipo_comp = 7 
						AND pptocomprobante_cab.tipo_comp = 7 		  
						AND pptocomprobante_det.cuenta LIKE '".$_POST[cuenta]."' 		  
						ORDER BY pptocomprobante_cab.fecha,pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_det.cuenta";
						//echo "<br>".$sqlr3;
						$res=mysql_query($sqlr3,$linkbd);
						while($row =mysql_fetch_row($res))
						{
							$rpsa+=$row[1];
							$valorlibrpa+=$row[2];
						}
						//****ppto cxp
						$sqlr3="SELECT 
						pptocomprobante_det.cuenta,
						pptocomprobante_det.valdebito,
						pptocomprobante_det.valcredito, pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_cab.fecha
						FROM pptocomprobante_det, pptocomprobante_cab,pptotipo_comprobante
						WHERE     pptocomprobante_cab.tipo_comp = pptocomprobante_det.tipo_comp
						AND pptocomprobante_det.numerotipo = pptocomprobante_cab.numerotipo
						AND pptocomprobante_cab.estado = 1
						AND (   pptocomprobante_det.valdebito > 0
						OR pptocomprobante_det.valcredito > 0)			   
						AND
						(pptocomprobante_cab.VIGENCIA=".$_POST[valor]." or pptocomprobante_cab.VIGENCIA=".$_POST[valor2].")
						and(pptocomprobante_det.VIGENCIA=".$_POST[valor]." or pptocomprobante_det.VIGENCIA=".$_POST[valor2].")
						and pptocomprobante_cab.VIGENCIA=pptocomprobante_det.VIGENCIA
						AND pptocomprobante_cab.fecha BETWEEN '$fechafa' AND '$fechaf2a'
						AND pptocomprobante_cab.tipo_comp = pptotipo_comprobante.codigo
						AND (pptotipo_comprobante.tipo = 'C')			  
						AND pptocomprobante_det.cuenta LIKE '".$_POST[cuenta]."' 		  
						ORDER BY pptocomprobante_cab.fecha,pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_det.cuenta";
						//echo "<br>".$sqlr3;
						$res=mysql_query($sqlr3,$linkbd);
						while($row =mysql_fetch_row($res))
						{
							$cxpa+=$row[1];
						}
						//****ppto pagos
						$sqlr3="SELECT 
						pptocomprobante_det.cuenta,
						pptocomprobante_det.valdebito,
						pptocomprobante_det.valcredito, pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_cab.fecha
						FROM pptocomprobante_det, pptocomprobante_cab,pptotipo_comprobante
						WHERE     pptocomprobante_cab.tipo_comp = pptocomprobante_det.tipo_comp
						AND pptocomprobante_det.numerotipo = pptocomprobante_cab.numerotipo
						AND pptocomprobante_cab.estado = 1
						AND (   pptocomprobante_det.valdebito > 0
						OR pptocomprobante_det.valcredito > 0)			   
						AND
						(pptocomprobante_cab.VIGENCIA=".$_POST[valor]." or pptocomprobante_cab.VIGENCIA=".$_POST[valor2].")
						and(pptocomprobante_det.VIGENCIA=".$_POST[valor]." or pptocomprobante_det.VIGENCIA=".$_POST[valor2].")
						and pptocomprobante_cab.VIGENCIA=pptocomprobante_det.VIGENCIA
						AND pptocomprobante_cab.fecha BETWEEN '$fechafa' AND '$fechaf2a'
						AND pptocomprobante_cab.tipo_comp = pptotipo_comprobante.codigo
						AND (pptotipo_comprobante.tipo = 'G' or pptotipo_comprobante.tipo = 'D')			  
						AND pptocomprobante_det.cuenta LIKE '".$_POST[cuenta]."' 		  
						ORDER BY pptocomprobante_cab.fecha,pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_det.cuenta";
						//echo "<br>".$sqlr3;
						$res=mysql_query($sqlr3,$linkbd);
						while($row =mysql_fetch_row($res))
						{	
							$pagosa+=$row[1];
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux; 
						}
						$saldoa=$pdefa-$cdpsa-$valorlibcdpa;
						//fin año anterior
						//**********************************************************************************************
						//año nuevo
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
						$ti=2;
						echo "<table class='inicio' ><tr><td colspan='6' class='titulos'>Auxiliar por Cuenta</td></tr>";
						echo "<tr><td class='titulos2'>TIPO COMPROBANTE</td><td class='titulos2'>No COMPROBANTE</td><td class='titulos2'>FECHA</td><td class='titulos2'>DETALLE</td><td class='titulos2'>VALOR</td></tr>";
						//$nc=buscacuentap($_POST[cuenta]);
						$iter='zebra1';
						$iter2='zebra2';
						//******* INGRESOS SSF
						//****ppto inicial
						$sqlr3="SELECT 
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
								<td ><input type='hidden' name='fecrec[]' value='$row[5]'>$row[5]</td>
								<td ><input type='hidden' name='terrec[]' value='PPTO INICIAL'>".$tercero." PPTO INICIAL</td>
								<td align='right' ><input type='hidden' name='valrec[]' value='$row[1]'>".number_format($row[1],2,',','.')."</td>
							</tr>";	 
							$pi+=$row[1];
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux; 
						}
						$pi=$saldoa;
						echo "<tr class='saludo2'>
							<td colspan='3'>
								<input type='hidden' name='tiporec[]' value=''>
								<input type='hidden' name='nrec[]' value=''>
								<input type='hidden' name='fecrec[]' value=''>
								<input type='hidden' name='terrec[]' value='SUBTOTAL APROPIACION INICIAL'>
								<input type='hidden' name='valrec[]' value='$pi'>
							</td>
							<td colspan='1'>Subtotal Apropiacion Inicial</td>
							<td align='right'>$".number_format($pi,2,',','.')."</td>
						</tr>";
						$pdef+=$pi;
		
						//****ppto Adicion
						$sqlr3="SELECT 
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
							<td colspan='3'></td>
							<td colspan='1'>
								<input type='hidden' name='tiporec[]' value=''>
								<input type='hidden' name='nrec[]' value=''>
								<input type='hidden' name='fecrec[]' value=''>
								<input type='hidden' name='terrec[]' value='SUBTOTAL ADICIONES'>
								<input type='hidden' name='valrec[]' value='$pad'>
							</td>
							<td align='right'>$".number_format($pad,2,',','.')."</td>
						</tr>";
						$pdef+=$pad;
		
						//****ppto Reducciones
						$sqlr3="SELECT 
						pptocomprobante_det.cuenta,
						pptocomprobante_det.valdebito,
						pptocomprobante_det.valcredito, pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_cab.fecha
						FROM pptocomprobante_det, pptocomprobante_cab
						WHERE     pptocomprobante_cab.tipo_comp = pptocomprobante_det.tipo_comp
						AND pptocomprobante_det.numerotipo = pptocomprobante_cab.numerotipo
						AND pptocomprobante_cab.estado = 1
						AND (   pptocomprobante_det.valdebito > 0
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
								<td ><input type='hidden' name='fecrec[]' value='$row[5]'>$row[5]</td>
								<td ><input type='hidden' name='terrec[]' value='REDUCCION PPTAL'>".$tercero."REDUCCION PPTAL</td>
								<td align='right' ><input type='hidden' name='valrec[]' value='$row[2]'>".number_format($row[2],2,',','.')."</td>
							</tr>";	 
							$pred+=$row[2];
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux; 
						}
						echo "<tr class='saludo1'>
							<td colspan='3'></td>
							<td colspan='1'>
								<input type='hidden' name='tiporec[]' value=''>
								<input type='hidden' name='nrec[]' value=''>
								<input type='hidden' name='fecrec[]' value=''>
								<input type='hidden' name='terrec[]' value='SUBTOTAL REDUCCIONES'>
								<input type='hidden' name='valrec[]' value='$pred'>Subtotal Reducciones
							</td>
							<td align='right'>$".number_format($pred,2,',','.')."</td>
						</tr>";
						$pdef-=$pred;	   
		   
						//****ppto Traslados
						$sqlr3="SELECT 
						pptocomprobante_det.cuenta,
						pptocomprobante_det.valdebito,
						pptocomprobante_det.valcredito, pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_cab.fecha
						FROM pptocomprobante_det, pptocomprobante_cab
						WHERE     pptocomprobante_cab.tipo_comp = pptocomprobante_det.tipo_comp
						AND pptocomprobante_det.numerotipo = pptocomprobante_cab.numerotipo
						AND pptocomprobante_cab.estado = 1
						AND (   pptocomprobante_det.valdebito > 0
						OR pptocomprobante_det.valcredito > 0)			   
						AND
						(pptocomprobante_cab.VIGENCIA=".$_POST[valor]." or pptocomprobante_cab.VIGENCIA=".$_POST[valor2].")
						and(pptocomprobante_det.VIGENCIA=".$_POST[valor]." or pptocomprobante_det.VIGENCIA=".$_POST[valor2].")
						and pptocomprobante_cab.VIGENCIA=pptocomprobante_det.VIGENCIA
						AND pptocomprobante_cab.fecha BETWEEN '$fechaf' AND '$fechaf2'
						AND pptocomprobante_det.tipo_comp = 5 
						AND pptocomprobante_cab.tipo_comp = 5 		  
						AND pptocomprobante_det.cuenta LIKE '".$_POST[cuenta]."' 		  
						ORDER BY pptocomprobante_cab.fecha,pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_det.cuenta";
						//echo "<br>".$sqlr3;
						$res=mysql_query($sqlr3,$linkbd);
						while($row =mysql_fetch_row($res))
						{
							echo "<tr class='$iter'>
								<td ><input type='hidden' name='tiporec[]' value='Traslados'>Traslados</td>
								<td ><input type='hidden' name='nrec[]' value='$row[4]'>$row[4]</td>
								<td ><input type='hidden' name='fecrec[]' value='$row[5]'>$row[5]</td>
								<td ><input type='hidden' name='terrec[]' value='TRASLADO PPTAL'>".$tercero."TRASLADO PPTAL</td>
								<td align='right' >
									<input type='hidden' name='valrec[]' value='".($row[1]-$row[2])."'>"
									.number_format(($row[1]-$row[2]),2,',','.')."
								</td>
							</tr>";	 
							$ptra=$ptra+$row[1]-$row[2];
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux; 
						}
						echo "<tr class='saludo2'>
							<td colspan='3'></td>
							<td colspan='1'>
								<input type='hidden' name='tiporec[]' value=''>
								<input type='hidden' name='nrec[]' value=''>
								<input type='hidden' name='fecrec[]' value=''>
								<input type='hidden' name='terrec[]' value='SUBTOTAL TRASLADOS'>
								<input type='hidden' name='valrec[]' value='$ptra'>Subtotal Traslado
							</td>
							<td align='right'>$".number_format($ptra,2,',','.')."</td>
						</tr>";
						$pdef+=$ptra;	   
						echo "<tr class='saludo2'>
							<td colspan='3'></td>
							<td colspan='1'>
								<input type='hidden' name='tiporec[]' value=''>
								<input type='hidden' name='nrec[]' value=''>
								<input type='hidden' name='fecrec[]' value=''>
								<input type='hidden' name='terrec[]' value='PRESUPUESTO DEFINITIVO'>
								<input type='hidden' name='valrec[]' value='$pdef'>PRESUPUESTO DEFINITIVO
							</td>
							<td align='right'>$".number_format($pdef,2,',','.')."</td>
						</tr>";	   
						//****ppto cdps
						$valorlibcdp=0;
						$sqlr3="SELECT 
						pptocomprobante_det.cuenta,
						pptocomprobante_det.valdebito,
						pptocomprobante_det.valcredito, pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_cab.fecha, pptocomprobante_cab.vigencia
						FROM pptocomprobante_det, pptocomprobante_cab
						WHERE     pptocomprobante_cab.tipo_comp = pptocomprobante_det.tipo_comp
						AND pptocomprobante_det.numerotipo = pptocomprobante_cab.numerotipo
						AND pptocomprobante_cab.estado = 1
						AND (   pptocomprobante_det.valdebito > 0
						OR pptocomprobante_det.valcredito > 0)			   
						AND
						(pptocomprobante_cab.VIGENCIA=".$_POST[valor]." or pptocomprobante_cab.VIGENCIA=".$_POST[valor2].")
						and(pptocomprobante_det.VIGENCIA=".$_POST[valor]." or pptocomprobante_det.VIGENCIA=".$_POST[valor2].")
						and pptocomprobante_cab.VIGENCIA=pptocomprobante_det.VIGENCIA
						AND pptocomprobante_cab.fecha BETWEEN '$fechaf' AND '$fechaf2'
						AND pptocomprobante_det.tipo_comp = 6 
						AND pptocomprobante_cab.tipo_comp = 6 		  
						AND pptocomprobante_det.cuenta LIKE '".$_POST[cuenta]."' 		  
						ORDER BY pptocomprobante_cab.fecha,pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_det.cuenta";
						//echo "<br>".$sqlr3;
						$res=mysql_query($sqlr3,$linkbd);
						while($row =mysql_fetch_row($res))
						{
							$detalles=buscacdp_detalle($row[4],$row[6]);
							echo "<tr class='$iter'>
								<td ><input type='hidden' name='tiporec[]' value='Disponibilidad'>Disponibilidad</td>
								<td ><input type='hidden' name='nrec[]' value='$row[4]'>$row[4]</td>
								<td ><input type='hidden' name='fecrec[]' value='$row[5]'>$row[5]</td>
								<td ><input type='hidden' name='terrec[]' value='$detalles'>".$detalles."</td>
								<td align='right' >
									<input type='hidden' name='valrec[]' value='".($row[1]-$row[2])."'>"
									.number_format($row[1],2,',','.')." - ".number_format($row[2],2,',','.')."
								</td>
							</tr>";	 
							$cdps+=$row[1];
							$valorlibcdp+=$row[2];
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux; 
						}
						echo "<tr class='saludo1'>
							<td colspan='3'></td>
							<td colspan='1'>
								<input type='hidden' name='tiporec[]' value=''>
								<input type='hidden' name='nrec[]' value=''>
								<input type='hidden' name='fecrec[]' value=''>
								<input type='hidden' name='terrec[]' value='SUBTOTAL DISPONIBILIDADES'>
								<input type='hidden' name='valrec[]' value='$cdps'>Subtotal DISPONIBILIDADES
							</td>
							<td align='right'>
								$".number_format($cdps,2,',','.')." - $".number_format($valorlibcdp,2,',','.')." = <br>$".number_format($cdps-$valorlibcdp,2,',','.')."
							</td>
						</tr>";

						//****ppto RPS
						$valorlibrp=0;
						$sqlr3="SELECT 
						pptocomprobante_det.cuenta,
						pptocomprobante_det.valdebito,
						pptocomprobante_det.valcredito, pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_cab.fecha, pptocomprobante_cab.vigencia 
						FROM pptocomprobante_det, pptocomprobante_cab
						WHERE     pptocomprobante_cab.tipo_comp = pptocomprobante_det.tipo_comp
						AND pptocomprobante_det.numerotipo = pptocomprobante_cab.numerotipo
						AND pptocomprobante_cab.estado = 1
						AND (   pptocomprobante_det.valdebito > 0
						OR pptocomprobante_det.valcredito > 0)			   
						AND
						(pptocomprobante_cab.VIGENCIA=".$_POST[valor]." or pptocomprobante_cab.VIGENCIA=".$_POST[valor2].")
						and(pptocomprobante_det.VIGENCIA=".$_POST[valor]." or pptocomprobante_det.VIGENCIA=".$_POST[valor2].")
						and pptocomprobante_cab.VIGENCIA=pptocomprobante_det.VIGENCIA
						AND pptocomprobante_cab.fecha BETWEEN '$fechaf' AND '$fechaf2'
						AND pptocomprobante_det.tipo_comp = 7 
						AND pptocomprobante_cab.tipo_comp = 7 		  
						AND pptocomprobante_det.cuenta LIKE '".$_POST[cuenta]."' 		  
						ORDER BY pptocomprobante_cab.fecha,pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_det.cuenta";
						//echo "<br>".$sqlr3;
						$res=mysql_query($sqlr3,$linkbd);
						while($row =mysql_fetch_row($res))
						{
							$ncdp=buscacdp_rp($row[4],$row[6]);
							$detalle=buscacdp_detalle($ncdp,$row[6]);
							$tercero="CDP ".$ncdp." - ".$detalle;
							echo "<tr class='$iter'>
								<td ><input type='hidden' name='tiporec[]' value='Registros Presupuestales'>Registros Presupuestales</td>
								<td ><input type='hidden' name='nrec[]' value='$row[4]'>$row[4]</td>
								<td ><input type='hidden' name='fecrec[]' value='$row[5]'>$row[5]</td>
								<td ><input type='hidden' name='terrec[]' value='$tercero'>".$tercero."</td>
								<td align='right' >
									<input type='hidden' name='valrec[]' value='".($row[1]-$row[2])."'>"
									.number_format($row[1],2,',','.')." - ".number_format($row[2],2,',','.')."
								</td>
							</tr>";	 
							$rps+=$row[1];
							$valorlibrp+=$row[2];
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux; 
						}
						echo "<tr class='saludo1'>
							<td colspan='3'></td>
							<td colspan='1'>
								<input type='hidden' name='tiporec[]' value=''>
								<input type='hidden' name='nrec[]' value=''>
								<input type='hidden' name='fecrec[]' value=''>
								<input type='hidden' name='terrec[]' value='SUBTOTAL REGISTROS PRESUPUESTALES'>
								<input type='hidden' name='valrec[]' value='$rps'>Subtotal Registros Presupuestales
							</td>
							<td align='right'>
								$".number_format($rps,2,',','.')." - $".number_format($valorlibrp,2,',','.')." = <br>$".number_format($rps-$valorlibrp,2,',','.')."
							</td>
						</tr>";

						//****ppto cxp
						$sqlr3="SELECT 
						pptocomprobante_det.cuenta,
						pptocomprobante_det.valdebito,
						pptocomprobante_det.valcredito, pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_cab.fecha
						FROM pptocomprobante_det, pptocomprobante_cab,pptotipo_comprobante
						WHERE     pptocomprobante_cab.tipo_comp = pptocomprobante_det.tipo_comp
						AND pptocomprobante_det.numerotipo = pptocomprobante_cab.numerotipo
						AND pptocomprobante_cab.estado = 1
						AND (   pptocomprobante_det.valdebito > 0
						OR pptocomprobante_det.valcredito > 0)			   
						AND
						(pptocomprobante_cab.VIGENCIA=".$_POST[valor]." or pptocomprobante_cab.VIGENCIA=".$_POST[valor2].")
						and(pptocomprobante_det.VIGENCIA=".$_POST[valor]." or pptocomprobante_det.VIGENCIA=".$_POST[valor2].")
						and pptocomprobante_cab.VIGENCIA=pptocomprobante_det.VIGENCIA
						AND pptocomprobante_cab.fecha BETWEEN '$fechaf' AND '$fechaf2'
						AND pptocomprobante_cab.tipo_comp = pptotipo_comprobante.codigo
						AND (pptotipo_comprobante.tipo = 'C')			  
						AND pptocomprobante_det.cuenta LIKE '".$_POST[cuenta]."' 		  
						ORDER BY pptocomprobante_cab.fecha,pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_det.cuenta";
						//echo "<br>".$sqlr3;
						$res=mysql_query($sqlr3,$linkbd);
						while($row =mysql_fetch_row($res))
						{
							$tercero="";
							echo "<tr class='$iter'>
								<td ><input type='hidden' name='tiporec[]' value='Cuentas Por Pagar'>Cuentas Por Pagar</td>
								<td ><input type='hidden' name='nrec[]' value='$row[4]'>$row[4]</td>
								<td ><input type='hidden' name='fecrec[]' value='$row[5]'>$row[5]</td>
								<td ><input type='hidden' name='terrec[]' value='$tercero'>".$tercero."</td>
								<td align='right' ><input type='hidden' name='valrec[]' value='".$row[1]."'>".number_format($row[1],2,',','.')."</td>
							</tr>";	 
							$cxp+=$row[1];
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux; 
						}
						echo "<tr class='saludo1'>
							<td colspan='3'></td>
							<td colspan='1'>
								<input type='hidden' name='tiporec[]' value=''>
								<input type='hidden' name='nrec[]' value=''>
								<input type='hidden' name='fecrec[]' value=''>
								<input type='hidden' name='terrec[]' value='SUBTOTAL CUENTAS POR PAGAR'>
								<input type='hidden' name='valrec[]' value='$cxp'>Subtotal Cuentas Por Pagar
							</td>
							<td align='right'>$".number_format($cxp,2,',','.')."</td>
						</tr>";
						//****ppto pagos
						$sqlr3="SELECT 
						pptocomprobante_det.cuenta,
						pptocomprobante_det.valdebito,
						pptocomprobante_det.valcredito, pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_cab.fecha
						FROM pptocomprobante_det, pptocomprobante_cab,pptotipo_comprobante
						WHERE     pptocomprobante_cab.tipo_comp = pptocomprobante_det.tipo_comp
						AND pptocomprobante_det.numerotipo = pptocomprobante_cab.numerotipo
						AND pptocomprobante_cab.estado = 1
						AND (   pptocomprobante_det.valdebito > 0
						OR pptocomprobante_det.valcredito > 0)			   
						AND
						(pptocomprobante_cab.VIGENCIA=".$_POST[valor]." or pptocomprobante_cab.VIGENCIA=".$_POST[valor2].")
						and(pptocomprobante_det.VIGENCIA=".$_POST[valor]." or pptocomprobante_det.VIGENCIA=".$_POST[valor2].")
						and pptocomprobante_cab.VIGENCIA=pptocomprobante_det.VIGENCIA
						AND pptocomprobante_cab.fecha BETWEEN '$fechaf' AND '$fechaf2'
						AND pptocomprobante_cab.tipo_comp = pptotipo_comprobante.codigo
						AND (pptotipo_comprobante.tipo = 'G' or pptotipo_comprobante.tipo = 'D')			  
						AND pptocomprobante_det.cuenta LIKE '".$_POST[cuenta]."' 		  
						ORDER BY pptocomprobante_cab.fecha,pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_det.cuenta";
						//echo "<br>".$sqlr3;
						$res=mysql_query($sqlr3,$linkbd);
						while($row =mysql_fetch_row($res))
						{	
							$tercero="";
							echo "<tr class='$iter'>
							<td ><input type='hidden' name='tiporec[]' value='PAGOS'>PAGOS</td>
							<td ><input type='hidden' name='nrec[]' value='$row[4]'>$row[4]</td>
							<td ><input type='hidden' name='fecrec[]' value='$row[5]'>$row[5]</td>
							<td ><input type='hidden' name='terrec[]' value='$tercero'>".$tercero."</td>
							<td align='right' ><input type='hidden' name='valrec[]' value='".$row[1]."'>".number_format($row[1],2,',','.')."</td></tr>";	 
							$pagos+=$row[1];
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux; 
						}
						echo "<tr class='saludo1'>
							<td colspan='3'></td>
							<td colspan='1'>
								<input type='hidden' name='tiporec[]' value=''>
								<input type='hidden' name='nrec[]' value=''>
								<input type='hidden' name='fecrec[]' value=''>
								<input type='hidden' name='terrec[]' value='SUBTOTAL PAGOS'>
								<input type='hidden' name='valrec[]' value='$pagos'>Subtotal Pagos</td>
								<td align='right'>$".number_format($pagos,2,',','.')."</td>
							</tr>";		
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux; 
						$saldo=$pdef-$cdps-$valorlibcdp;
						//echo "<tr><td colspan='4'></td><td>Total:</td><td class='saludo1'>$".number_format( array_sum($_POST[valrec]),2)."</td></tr>";
						echo "<tr class='saludo1'>
							<td colspan='3'></td>
							<td>
								<input type='hidden' name='tiporec[]' value=''>
								<input type='hidden' name='nrec[]' value=''>
								<input type='hidden' name='fecrec[]' value=''>
								<input type='hidden' name='terrec[]' value='SALDO DISPONIBLE (Pres Def - CDP)'>
								<input type='hidden' name='valrec[]' value='$saldo'>Saldo Disponible (Pres Def - CDP):</td>
								<td align='right' >$".number_format($saldo,2,',','.')."
							</td>
						</tr>";
						//fin año nuevo
					}
					else{
						$_POST[tiporec]=array();
						//		$_POST[valrec]=array();
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
						$ti=2;
						echo "<table class='inicio' ><tr><td colspan='6' class='titulos'>Auxiliar por Cuenta</td></tr>";
						echo "<tr><td class='titulos2'>TIPO COMPROBANTE</td><td class='titulos2'>No COMPROBANTE</td><td class='titulos2'>FECHA</td><td class='titulos2'>DETALLE</td><td class='titulos2'>VALOR</td></tr>";
						//$nc=buscacuentap($_POST[cuenta]);
						$iter='zebra1';
						$iter2='zebra2';
						//******* INGRESOS SSF
						//****ppto inicial
						$sqlr3="SELECT 
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
							<td colspan='3'>
								<input type='hidden' name='tiporec[]' value=''>
								<input type='hidden' name='nrec[]' value=''>
								<input type='hidden' name='fecrec[]' value=''>
								<input type='hidden' name='terrec[]' value='SUBTOTAL APROPIACION INICIAL'>
								<input type='hidden' name='valrec[]' value='$pi'>
							</td>
							<td colspan='1'>Subtotal Apropiacion Inicial</td>
							<td align='right'>$".number_format($pi,2,',','.')."</td>
						</tr>";
						$pdef+=$pi;
		
						//****ppto Adicion
						$sqlr3="SELECT 
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
							<td colspan='3'></td>
							<td colspan='1'>
								<input type='hidden' name='tiporec[]' value=''>
								<input type='hidden' name='nrec[]' value=''>
								<input type='hidden' name='fecrec[]' value=''>
								<input type='hidden' name='terrec[]' value='SUBTOTAL ADICIONES'>
								<input type='hidden' name='valrec[]' value='$pad'>
							</td>
							<td align='right'>$".number_format($pad,2,',','.')."</td>
						</tr>";
						$pdef+=$pad;
		
						//****ppto Reducciones
						$sqlr3="SELECT 
						pptocomprobante_det.cuenta,
						pptocomprobante_det.valdebito,
						pptocomprobante_det.valcredito, pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_cab.fecha
						FROM pptocomprobante_det, pptocomprobante_cab
						WHERE     pptocomprobante_cab.tipo_comp = pptocomprobante_det.tipo_comp
						AND pptocomprobante_det.numerotipo = pptocomprobante_cab.numerotipo
						AND pptocomprobante_cab.estado = 1
						AND (   pptocomprobante_det.valdebito > 0
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
								<td ><input type='hidden' name='fecrec[]' value='$row[5]'>$row[5]</td>
								<td ><input type='hidden' name='terrec[]' value='REDUCCION PPTAL'>".$tercero."REDUCCION PPTAL</td>
								<td align='right' ><input type='hidden' name='valrec[]' value='$row[2]'>".number_format($row[2],2,',','.')."</td>
							</tr>";	 
							$pred+=$row[2];
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux; 
						}
						echo "<tr class='saludo1'>
							<td colspan='3'></td>
							<td colspan='1'>
								<input type='hidden' name='tiporec[]' value=''>
								<input type='hidden' name='nrec[]' value=''>
								<input type='hidden' name='fecrec[]' value=''>
								<input type='hidden' name='terrec[]' value='SUBTOTAL REDUCCIONES'>
								<input type='hidden' name='valrec[]' value='$pred'>Subtotal Reducciones
							</td>
							<td align='right'>$".number_format($pred,2,',','.')."</td>
						</tr>";
						$pdef-=$pred;	   
		   
						//****ppto Traslados
						$sqlr3="SELECT 
						pptocomprobante_det.cuenta,
						pptocomprobante_det.valdebito,
						pptocomprobante_det.valcredito, pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_cab.fecha
						FROM pptocomprobante_det, pptocomprobante_cab
						WHERE     pptocomprobante_cab.tipo_comp = pptocomprobante_det.tipo_comp
						AND pptocomprobante_det.numerotipo = pptocomprobante_cab.numerotipo
						AND pptocomprobante_cab.estado = 1
						AND (   pptocomprobante_det.valdebito > 0
						OR pptocomprobante_det.valcredito > 0)			   
						AND
						(pptocomprobante_cab.VIGENCIA=".$_POST[valor]." or pptocomprobante_cab.VIGENCIA=".$_POST[valor2].")
						and(pptocomprobante_det.VIGENCIA=".$_POST[valor]." or pptocomprobante_det.VIGENCIA=".$_POST[valor2].")
						and pptocomprobante_cab.VIGENCIA=pptocomprobante_det.VIGENCIA
						AND pptocomprobante_cab.fecha BETWEEN '$fechaf' AND '$fechaf2'
						AND pptocomprobante_det.tipo_comp = 5 
						AND pptocomprobante_cab.tipo_comp = 5 		  
						AND pptocomprobante_det.cuenta LIKE '".$_POST[cuenta]."' 		  
						ORDER BY pptocomprobante_cab.fecha,pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_det.cuenta";
						//echo "<br>".$sqlr3;
						$res=mysql_query($sqlr3,$linkbd);
						while($row =mysql_fetch_row($res))
						{
							echo "<tr class='$iter'>
								<td ><input type='hidden' name='tiporec[]' value='Traslados'>Traslados</td>
								<td ><input type='hidden' name='nrec[]' value='$row[4]'>$row[4]</td>
								<td ><input type='hidden' name='fecrec[]' value='$row[5]'>$row[5]</td>
								<td ><input type='hidden' name='terrec[]' value='TRASLADO PPTAL'>".$tercero."TRASLADO PPTAL</td>
								<td align='right' >
									<input type='hidden' name='valrec[]' value='".($row[1]-$row[2])."'>"
									.number_format(($row[1]-$row[2]),2,',','.')."
								</td>
							</tr>";	 
							$ptra=$ptra+$row[1]-$row[2];
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux; 
						}
						echo "<tr class='saludo2'>
							<td colspan='3'></td>
							<td colspan='1'>
								<input type='hidden' name='tiporec[]' value=''>
								<input type='hidden' name='nrec[]' value=''>
								<input type='hidden' name='fecrec[]' value=''>
								<input type='hidden' name='terrec[]' value='SUBTOTAL TRASLADOS'>
								<input type='hidden' name='valrec[]' value='$ptra'>Subtotal Traslado
							</td>
							<td align='right'>$".number_format($ptra,2,',','.')."</td>
						</tr>";
						$pdef+=$ptra;	   
						echo "<tr class='saludo2'>
							<td colspan='3'></td>
							<td colspan='1'>
								<input type='hidden' name='tiporec[]' value=''>
								<input type='hidden' name='nrec[]' value=''>
								<input type='hidden' name='fecrec[]' value=''>
								<input type='hidden' name='terrec[]' value='PRESUPUESTO DEFINITIVO'>
								<input type='hidden' name='valrec[]' value='$pdef'>PRESUPUESTO DEFINITIVO
							</td>
							<td align='right'>$".number_format($pdef,2,',','.')."</td>
						</tr>";	   
						//****ppto cdps
						$valorlibcdp=0;
						$sqlr3="SELECT 
						pptocomprobante_det.cuenta,
						pptocomprobante_det.valdebito,
						pptocomprobante_det.valcredito, pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_cab.fecha, pptocomprobante_cab.vigencia
						FROM pptocomprobante_det, pptocomprobante_cab
						WHERE     pptocomprobante_cab.tipo_comp = pptocomprobante_det.tipo_comp
						AND pptocomprobante_det.numerotipo = pptocomprobante_cab.numerotipo
						AND pptocomprobante_cab.estado = 1
						AND (   pptocomprobante_det.valdebito > 0
						OR pptocomprobante_det.valcredito > 0)			   
						AND
						(pptocomprobante_cab.VIGENCIA=".$_POST[valor]." or pptocomprobante_cab.VIGENCIA=".$_POST[valor2].")
						and(pptocomprobante_det.VIGENCIA=".$_POST[valor]." or pptocomprobante_det.VIGENCIA=".$_POST[valor2].")
						and pptocomprobante_cab.VIGENCIA=pptocomprobante_det.VIGENCIA
						AND pptocomprobante_cab.fecha BETWEEN '$fechaf' AND '$fechaf2'
						AND pptocomprobante_det.tipo_comp = 6 
						AND pptocomprobante_cab.tipo_comp = 6 		  
						AND pptocomprobante_det.cuenta LIKE '".$_POST[cuenta]."' 		  
						ORDER BY pptocomprobante_cab.fecha,pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_det.cuenta";
						//echo "<br>".$sqlr3;
						$res=mysql_query($sqlr3,$linkbd);
						while($row =mysql_fetch_row($res))
						{
							$detalles=buscacdp_detalle($row[4],$row[6]);
							echo "<tr class='$iter'>
								<td ><input type='hidden' name='tiporec[]' value='Disponibilidad'>Disponibilidad</td>
								<td ><input type='hidden' name='nrec[]' value='$row[4]'>$row[4]</td>
								<td ><input type='hidden' name='fecrec[]' value='$row[5]'>$row[5]</td>
								<td ><input type='hidden' name='terrec[]' value='$detalles'>".$detalles."</td>
								<td align='right' >
									<input type='hidden' name='valrec[]' value='".($row[1]-$row[2])."'>"
									.number_format($row[1],2,',','.')." - ".number_format($row[2],2,',','.')."
								</td>
							</tr>";	 
							$cdps+=$row[1];
							$valorlibcdp+=$row[2];
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux; 
						}
						echo "<tr class='saludo1'>
							<td colspan='3'></td>
							<td colspan='1'>
								<input type='hidden' name='tiporec[]' value=''>
								<input type='hidden' name='nrec[]' value=''>
								<input type='hidden' name='fecrec[]' value=''>
								<input type='hidden' name='terrec[]' value='SUBTOTAL DISPONIBILIDADES'>
								<input type='hidden' name='valrec[]' value='$cdps'>Subtotal DISPONIBILIDADES
							</td>
							<td align='right'>
								$".number_format($cdps,2,',','.')." - $".number_format($valorlibcdp,2,',','.')." = <br>$".number_format($cdps-$valorlibcdp,2,',','.')."
							</td>
						</tr>";

						//****ppto RPS
						$valorlibrp=0;
						$sqlr3="SELECT 
						pptocomprobante_det.cuenta,
						pptocomprobante_det.valdebito,
						pptocomprobante_det.valcredito, pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_cab.fecha, pptocomprobante_cab.vigencia 
						FROM pptocomprobante_det, pptocomprobante_cab
						WHERE     pptocomprobante_cab.tipo_comp = pptocomprobante_det.tipo_comp
						AND pptocomprobante_det.numerotipo = pptocomprobante_cab.numerotipo
						AND pptocomprobante_cab.estado = 1
						AND (   pptocomprobante_det.valdebito > 0
						OR pptocomprobante_det.valcredito > 0)			   
						AND
						(pptocomprobante_cab.VIGENCIA=".$_POST[valor]." or pptocomprobante_cab.VIGENCIA=".$_POST[valor2].")
						and(pptocomprobante_det.VIGENCIA=".$_POST[valor]." or pptocomprobante_det.VIGENCIA=".$_POST[valor2].")
						and pptocomprobante_cab.VIGENCIA=pptocomprobante_det.VIGENCIA
						AND pptocomprobante_cab.fecha BETWEEN '$fechaf' AND '$fechaf2'
						AND pptocomprobante_det.tipo_comp = 7 
						AND pptocomprobante_cab.tipo_comp = 7 		  
						AND pptocomprobante_det.cuenta LIKE '".$_POST[cuenta]."' 		  
						ORDER BY pptocomprobante_cab.fecha,pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_det.cuenta";
						//echo "<br>".$sqlr3;
						$res=mysql_query($sqlr3,$linkbd);
						while($row =mysql_fetch_row($res))
						{
							$ncdp=buscacdp_rp($row[4],$row[6]);
							$detalle=buscacdp_detalle($ncdp,$row[6]);
							$tercero="CDP ".$ncdp." - ".$detalle;
							echo "<tr class='$iter'>
								<td ><input type='hidden' name='tiporec[]' value='Registros Presupuestales'>Registros Presupuestales</td>
								<td ><input type='hidden' name='nrec[]' value='$row[4]'>$row[4]</td>
								<td ><input type='hidden' name='fecrec[]' value='$row[5]'>$row[5]</td>
								<td ><input type='hidden' name='terrec[]' value='$tercero'>".$tercero."</td>
								<td align='right' >
									<input type='hidden' name='valrec[]' value='".($row[1]-$row[2])."'>"
									.number_format($row[1],2,',','.')." - ".number_format($row[2],2,',','.')."
								</td>
							</tr>";	 
							$rps+=$row[1];
							$valorlibrp+=$row[2];
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux; 
						}
						echo "<tr class='saludo1'>
							<td colspan='3'></td>
							<td colspan='1'>
								<input type='hidden' name='tiporec[]' value=''>
								<input type='hidden' name='nrec[]' value=''>
								<input type='hidden' name='fecrec[]' value=''>
								<input type='hidden' name='terrec[]' value='SUBTOTAL REGISTROS PRESUPUESTALES'>
								<input type='hidden' name='valrec[]' value='$rps'>Subtotal Registros Presupuestales
							</td>
							<td align='right'>
								$".number_format($rps,2,',','.')." - $".number_format($valorlibrp,2,',','.')." = <br>$".number_format($rps-$valorlibrp,2,',','.')."
							</td>
						</tr>";

						//****ppto cxp
						$sqlr3="SELECT 
						pptocomprobante_det.cuenta,
						pptocomprobante_det.valdebito,
						pptocomprobante_det.valcredito, pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_cab.fecha
						FROM pptocomprobante_det, pptocomprobante_cab,pptotipo_comprobante
						WHERE     pptocomprobante_cab.tipo_comp = pptocomprobante_det.tipo_comp
						AND pptocomprobante_det.numerotipo = pptocomprobante_cab.numerotipo
						AND pptocomprobante_cab.estado = 1
						AND (   pptocomprobante_det.valdebito > 0
						OR pptocomprobante_det.valcredito > 0)			   
						AND
						(pptocomprobante_cab.VIGENCIA=".$_POST[valor]." or pptocomprobante_cab.VIGENCIA=".$_POST[valor2].")
						and(pptocomprobante_det.VIGENCIA=".$_POST[valor]." or pptocomprobante_det.VIGENCIA=".$_POST[valor2].")
						and pptocomprobante_cab.VIGENCIA=pptocomprobante_det.VIGENCIA
						AND pptocomprobante_cab.fecha BETWEEN '$fechaf' AND '$fechaf2'
						AND pptocomprobante_cab.tipo_comp = pptotipo_comprobante.codigo
						AND (pptotipo_comprobante.tipo = 'C')			  
						AND pptocomprobante_det.cuenta LIKE '".$_POST[cuenta]."' 		  
						ORDER BY pptocomprobante_cab.fecha,pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_det.cuenta";
						//echo "<br>".$sqlr3;
						$res=mysql_query($sqlr3,$linkbd);
						while($row =mysql_fetch_row($res))
						{
							$tercero="";
							echo "<tr class='$iter'>
								<td ><input type='hidden' name='tiporec[]' value='Cuentas Por Pagar'>Cuentas Por Pagar</td>
								<td ><input type='hidden' name='nrec[]' value='$row[4]'>$row[4]</td>
								<td ><input type='hidden' name='fecrec[]' value='$row[5]'>$row[5]</td>
								<td ><input type='hidden' name='terrec[]' value='$tercero'>".$tercero."</td>
								<td align='right' ><input type='hidden' name='valrec[]' value='".$row[1]."'>".number_format($row[1],2,',','.')."</td>
							</tr>";	 
							$cxp+=$row[1];
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux; 
						}
						echo "<tr class='saludo1'>
							<td colspan='3'></td>
							<td colspan='1'>
								<input type='hidden' name='tiporec[]' value=''>
								<input type='hidden' name='nrec[]' value=''>
								<input type='hidden' name='fecrec[]' value=''>
								<input type='hidden' name='terrec[]' value='SUBTOTAL CUENTAS POR PAGAR'>
								<input type='hidden' name='valrec[]' value='$cxp'>Subtotal Cuentas Por Pagar
							</td>
							<td align='right'>$".number_format($cxp,2,',','.')."</td>
						</tr>";
						//****ppto pagos
						$sqlr3="SELECT 
						pptocomprobante_det.cuenta,
						pptocomprobante_det.valdebito,
						pptocomprobante_det.valcredito, pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_cab.fecha
						FROM pptocomprobante_det, pptocomprobante_cab,pptotipo_comprobante
						WHERE     pptocomprobante_cab.tipo_comp = pptocomprobante_det.tipo_comp
						AND pptocomprobante_det.numerotipo = pptocomprobante_cab.numerotipo
						AND pptocomprobante_cab.estado = 1
						AND (   pptocomprobante_det.valdebito > 0
						OR pptocomprobante_det.valcredito > 0)			   
						AND
						(pptocomprobante_cab.VIGENCIA=".$_POST[valor]." or pptocomprobante_cab.VIGENCIA=".$_POST[valor2].")
						and(pptocomprobante_det.VIGENCIA=".$_POST[valor]." or pptocomprobante_det.VIGENCIA=".$_POST[valor2].")
						and pptocomprobante_cab.VIGENCIA=pptocomprobante_det.VIGENCIA
						AND pptocomprobante_cab.fecha BETWEEN '$fechaf' AND '$fechaf2'
						AND pptocomprobante_cab.tipo_comp = pptotipo_comprobante.codigo
						AND (pptotipo_comprobante.tipo = 'G' or pptotipo_comprobante.tipo = 'D')			  
						AND pptocomprobante_det.cuenta LIKE '".$_POST[cuenta]."' 		  
						ORDER BY pptocomprobante_cab.fecha,pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,pptocomprobante_det.cuenta";
						//echo "<br>".$sqlr3;
						$res=mysql_query($sqlr3,$linkbd);
						while($row =mysql_fetch_row($res))
						{	
							$tercero="";
							echo "<tr class='$iter'>
							<td ><input type='hidden' name='tiporec[]' value='PAGOS'>PAGOS</td>
							<td ><input type='hidden' name='nrec[]' value='$row[4]'>$row[4]</td>
							<td ><input type='hidden' name='fecrec[]' value='$row[5]'>$row[5]</td>
							<td ><input type='hidden' name='terrec[]' value='$tercero'>".$tercero."</td>
							<td align='right' ><input type='hidden' name='valrec[]' value='".$row[1]."'>".number_format($row[1],2,',','.')."</td></tr>";	 
							$pagos+=$row[1];
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux; 
						}
						echo "<tr class='saludo1'>
							<td colspan='3'></td>
							<td colspan='1'>
								<input type='hidden' name='tiporec[]' value=''>
								<input type='hidden' name='nrec[]' value=''>
								<input type='hidden' name='fecrec[]' value=''>
								<input type='hidden' name='terrec[]' value='SUBTOTAL PAGOS'>
								<input type='hidden' name='valrec[]' value='$pagos'>Subtotal Pagos</td>
								<td align='right'>$".number_format($pagos,2,',','.')."</td>
							</tr>";		
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux; 
						$saldo=$pdef-$cdps-$valorlibcdp;
						//echo "<tr><td colspan='4'></td><td>Total:</td><td class='saludo1'>$".number_format( array_sum($_POST[valrec]),2)."</td></tr>";
						echo "<tr class='saludo1'>
							<td colspan='3'></td>
							<td>
								<input type='hidden' name='tiporec[]' value=''>
								<input type='hidden' name='nrec[]' value=''>
								<input type='hidden' name='fecrec[]' value=''>
								<input type='hidden' name='terrec[]' value='SALDO DISPONIBLE (Pres Def - CDP)'>
								<input type='hidden' name='valrec[]' value='$saldo'>Saldo Disponible (Pres Def - CDP):</td>
								<td align='right' >$".number_format($saldo,2,',','.')."
							</td>
						</tr>";
					}
				}
				?> 
			</div>
		</form>
</body>
</html>