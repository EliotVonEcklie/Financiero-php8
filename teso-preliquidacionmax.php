<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	header("Content-Type: text/html;charset=iso-8859-1");
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-type" content="text/html; charset=iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Spid - Tesoreria</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js"></script>
		<script>
			function procesos($tip)
			{	
				switch ($tip) 
				{
					case 1:	despliegamodalm('visible','4','Generar preliquidación de este periodo','1');
							break;
				}
 			}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
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
					}
				}
			}
			function funcionmensaje(){}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.form2.oculto.value=3;	
  								document.form2.submit();break;
				}
			}
			function callprogress(vValor)
			{
 				document.getElementById("getprogress").innerHTML = vValor;
 				document.getElementById("getProgressBarFill").innerHTML = '<div class="ProgressBarFill" style="width: '+vValor+'%;"></div>';				
				document.getElementById("titulog1").style.display='block';
   				document.getElementById("progreso").style.display='block';
     			document.getElementById("getProgressBarFill").style.display='block';
				if (vValor==100){document.getElementById("titulog2").style.display='block';}
			} 
			function ocultarcallprogress()
			{
				document.getElementById("titulog1").style.display='none';
   				document.getElementById("progreso").style.display='none';
     			document.getElementById("getProgressBarFill").style.display='none';
				if (vValor==100){document.getElementById("titulog2").style.display='none';}
			} 
			function pdf(codimp)
			{
				document.form2.action="teso-preliquidacionmasver.php?codimpre="+codimp;
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
		</script>
		<?php titlepag(); ?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("teso");?></tr>
			<tr>
  				<td colspan="3" class="cinta">
					<img src="imagenes/add2.png" class="mgbt1"/>
					<img src="imagenes/guardad.png" class="mgbt1"/>
					<img src="imagenes/busca.png" title="Buscar" class="mgbt"/>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<img src="imagenes/nv.png" title="Nueva Ventana" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"/>
					<img src="imagenes/iratras.png" title="Menu Gesti&oacute;n Predial" class="mgbt" onClick="location.href='teso-gestionpredial.php'"/>
				</td>
			</tr>		  
		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
        <?php if ($_POST[oculto]==""){$_POST[numres]=10;$_POST[numpos]=0;$_POST[nummul]=0;}?>
        <form name="form2" method="post" action="">
            <input type="hidden" name="numres" id="numres" value="<?php echo $_POST[numres];?>"/>
			<input type="hidden" name="numpos" id="numpos" value="<?php echo $_POST[numpos];?>"/>
			<input type="hidden" name="nummul" id="nummul" value="<?php echo $_POST[nummul];?>"/>
			<table class="inicio">
                <tr>
                    <td class="titulos" colspan="13">Preliquidaci&oacute;n Predial Masiva</td>
                    <td class="cerrar" style='width:7%'><a onClick="location.href='teso-principal.php'">&nbsp;Cerrar</a></td>
                </tr>
                <tr>
                    <td class="saludo1" style="width:4cm;">Nueva Preliquidaci&oacute;n:</td>
                    <td><input type="button" name="buscapredios"  value=" Generar " onClick="procesos(1)"/></td>
                    <td>
						<div id='titulog1' style='display:none; float:left'></div>
						<div id='progreso' class='ProgressBar' style='display:none; float:left'>
							<div class='ProgressBarText'><span id='getprogress'></span>&nbsp;% </div>
							<div id='getProgressBarFill'></div>
						</div>
					</td>
                </tr>
			</table>
            <input type="hidden" name="oculto" id="oculto" value="<?php echo $_POST[oculto];?>"/>
            <div class="subpantalla" style="height:68.5%; width:99.6%; overflow-x:hidden;">
      		<?php
				if($_POST[oculto]==3)
	   			{
					$_POST[oculto]=2;
					$sqlr="SELECT diasplazo FROM servparametros";
					$row =mysql_fetch_row(mysql_query($sqlr,$linkbd));
					$diaplazo=$row[0];
					$facrevi="0";
					$c=0;
					$vigenciaactual=date('Y');
					$vigenciaanterior=$vigenciaactual-1;
					$codgenpre=selconsecutivo('tesopreliquidacion_gen','codpregen');
					$codpreini=$codpreval=selconsecutivo('tesopreliquidacion','codpreli');
					$codprefin=0;
					$sqlrdes="SELECT valordesc1,valordesc2,valordesc3,fechafin1,fechafin2,fechafin3 FROM tesodescuentoincentivo WHERE vigencia='$vigenciaactual' AND estado='S'";
			 		$resdes=mysql_query($sqlrdes,$linkbd);
	 				$rowdes=mysql_fetch_row($resdes);
					$fdes1 = explode("-",date("d-m-Y",$rowdes[3]));
					$fdes2 = explode("-",date("d-m-Y",$rowdes[4]));
					$fdes3 = explode("-",date("d-m-Y",$rowdes[5]));
					$fehoy = explode("-",date("d-m-Y"));
					$fechag=date("Y/m/d");
					if(GregorianToJd($fdes1[0],$fdes1[1],$fdes1[2])<=GregorianToJd($fehoy[0],$fehoy[1],$fehoy[2]))
					{$fechades=$rowdes[3]; $pordescuento=$rowdes[0];}
					else if(GregorianToJd($fdes2[0],$fdes2[1],$fdes2[2])<=GregorianToJd($fehoy[0],$fehoy[1],$fehoy[2]))
					{$fechades=$rowdes[4]; $pordescuento=$rowdes[1];}
					else if(GregorianToJd($fdes3[0],$fdes3[1],$fdes3[2])<=GregorianToJd($fehoy[0],$fehoy[1],$fehoy[2]))
					{$fechades=$rowdes[5]; $pordescuento=$rowdes[2];}
					else {$fechades="";$pordescuento=0;}
					$sqlr="
					SELECT DISTINCT TB1.codigocatastral,TB1.avaluo,TB1.pago,TB1.estado,TB2.tipopredio,TB2.estratos,TB1.areacon,TB2.documento, TB2.nombrepropietario,TB2.direccion,TB2.ha,TB2.met2,TB2.areacon
					FROM tesoprediosavaluos TB1, tesopredios TB2
					WHERE TB1.vigencia='$vigenciaactual'
					AND TB1.estado = 'S'
					AND TB1.pago = 'N'
					AND TB1.codigocatastral = TB2.cedulacatastral
					ORDER BY TB1.vigencia ASC ";
					$respn=mysql_query($sqlr,$linkbd);
					$totalcli=mysql_affected_rows ($linkbd);
					while ($row =mysql_fetch_row($respn)) 
					{	
						$c+=1;
						$porcentaje = $c * 100 / $totalcli; 
						echo"<script>progres='".round($porcentaje)."';callprogress(progres);</script>"; 
						flush();
						ob_flush();
						usleep(5);//microsegundos
						//ACTUALIZAR FACTURA
						$sqlrin="SELECT pago FROM tesoprediosavaluos WHERE codigocatastral='$row[0]' AND vigencia='$vigenciaanterior'";
						$resin=mysql_query($sqlrin,$linkbd);
						$rowin=mysql_fetch_row($resin);
						if ($rowin[0]=='S')
						{
							$base=$row[1];
							$sqlrt1="SELECT valor_inicial,valor_final, tipo FROM dominios WHERE nombre_dominio='BASE_PREDIAL' ";
							$rest1=mysql_query($sqlrt1,$linkbd);
							while ($rowt1 =mysql_fetch_row($rest1)){$basepredial=$rowt1[0];}
							$sqlrt1="SELECT valor_inicial,valor_final, tipo FROM dominios WHERE nombre_dominio='BASE_PREDIALAMB' ";
							$rest1=mysql_query($sqlrt1,$linkbd);
							while ($rowt1 =mysql_fetch_row($rest1)){$basepredialamb=$rowt1[0];}	
							$sqlrt1="select valor_inicial,valor_final, tipo from dominios where nombre_dominio='NORMA_PREDIAL' ";
							$rest1=mysql_query($sqlrt1,$linkbd);
							while ($rowt1 =mysql_fetch_row($rest1)){$aplicapredial=$rowt1[0];}
							$sqlrtr="SELECT tasa FROM tesotarifaspredial WHERE vigencia='$vigenciaactual' AND tipo='$row[4]' AND estratos='$row[5]'";
			 				$restr=mysql_query($sqlrtr,$linkbd);
	 						$rowtr=mysql_fetch_row($restr);
							$tasapre=$rowtr[0];
							$predial=round($base*($rowtr[0]/1000)-$base*($rowtr[0]/1000)*($_POST[deduccion]/100),2);
							$sqlrht="SELECT TB2.predial,TB1.areacon FROM tesoliquidapredial TB1, tesoliquidapredial_det TB2 WHERE TB1.idpredial=TB2.idpredial AND TB1.vigencia='$vigenciaanterior' AND TB1.codigocatastral='$row[0]' ";
							$resht=mysql_query($sqlrht,$linkbd);
							$rowht=mysql_fetch_row($resht);	
							$predialanterior=$rowht[0];
							$predialanterior2=$predialanterior*2;
							$sqlrare="SELECT areacon FROM tesoprediosavaluos WHERE vigencia='$vigenciaanterior' AND codigocatastral='$row[0]' ";
							$resare=mysql_query($sqlrare,$linkbd);
							$roware=mysql_fetch_row($resRE);	
							$areaanterior=$roware[0];
							if(($predial>$predialanterior2) && ($row[6]==$areaanterior)){$predial=$predialanterior2;}
							$sqlr2="SELECT * FROM tesoingresos_det WHERE codigo='01' AND modulo='4' AND  estado='S' AND vigencia='$vigenciaactual' ORDER BY concepto";
							$res3=mysql_query($sqlr2,$linkbd);
							
							while($r3=mysql_fetch_row($res3))
							{
								if($r3[5]>0 && $r3[5]<100)
					 			{
					  				if($r3[2]=='03')
					    			{
										if( $basepredial==1)	
										{
											$tasabomberil=round($base*($r3[5]/1000),0)-($base*($r3[5]/1000)*($_POST[deduccion]/100));
										}
										if( $basepredial==2)
										{	
					  						$tasabomberil=round($predial*($r3[5]/100),0);
										}
					    			}
					    			if($r3[2]=='02')
					    			{
										if( $basepredialamb==1)	
										{
											$tasaambiental=round($base*($r3[5]/1000),0)-($base*($r3[5]/1000)*($_POST[deduccion]/100));
										}	
										if( $basepredialamb==2)
										{	
					  						$tasaambiental=round($predial*($r3[5]/100),0);
										}
					   				}	
					 			}
							}
							$sqlrdes="SELECT valordesc1,valordesc2,valordesc3,fechafin1,fechafin2,fechafin3 FROM tesodescuentoincentivo WHERE vigencia='$vigenciaactual' AND estado='S'";
			 				$resdes=mysql_query($sqlrdes,$linkbd);
	 						$rowdes=mysql_fetch_row($resdes);
							$descuento=round(($predial*($pordescuento/100)),0);
							$prediald=$predial-$descuento;
							$valtotal00=$predial+$tasabomberil+$tasaambiental;
							$valtotal01=$prediald+$tasabomberil+$tasaambiental;
							$sqlrguar="INSERT INTO tesopreliquidacion (codpreli,codpregen,codigocatastral,vigencia,tercero,nomtercero,direccion,ha, met2,areacon,tasapredial,avaluo,predial,bomberil,medioambiente,descuentos,totaliquidavig,totalpredes,estado) VALUES ('$codpreval','$codgenpre', '$row[0]','$vigenciaactual','$row[7]','$row[8]','$row[9]','$row[10]','$row[11]','$row[12]','$tasapre','$base','$predial','$tasabomberil', '$tasaambiental','$descuento','$valtotal00', '$valtotal01','S')";
							 mysql_query($sqlrguar,$linkbd);
							 $codpreval++;
						}
	  				}
					$codprefin=$codpreval-1;
					$sqlrguar="INSERT INTO tesopreliquidacion_gen(codpregen,vigencia,fecha,fechades,numinicial,numfinal,pordescuento,estado) VALUES ('$codgenpre','$vigenciaactual','$fechag','$fechades','$codpreini','$codprefin','$pordescuento','S')";
					mysql_query($sqlrguar,$linkbd);
				}
				//************************
				echo "<script>ocultarcallprogress();</script>";
				$sqlr="SELECT * FROM tesopreliquidacion_gen WHERE estado='S'";
				$resp = mysql_query($sqlr,$linkbd);
				$ntr = mysql_num_rows($resp);
				$_POST[numtop]=$ntr;
				$nuncilumnas=ceil($_POST[numtop]/$_POST[numres]);
				$cond2="";
				if ($_POST[numres]!="-1"){ $cond2="LIMIT $_POST[numpos], $_POST[numres]";}
				$sqlr="SELECT * FROM tesopreliquidacion_gen WHERE estado='S' ORDER BY codpregen DESC $cond2 ";
				$resp = mysql_query($sqlr,$linkbd);
				$numcontrol=$_POST[nummul]+1;
				if(($nuncilumnas==$numcontrol)||($_POST[numres]=="-1"))
				{
					$imagenforward="<img src='imagenes/forward02.png' style='width:17px'>";
					$imagensforward="<img src='imagenes/skip_forward02.png' style='width:16px' >";
				}
				else
				{
					$imagenforward="<img src='imagenes/forward01.png' style='width:17px' title='Siguiente' onClick='numsiguiente()'>";
					$imagensforward="<img src='imagenes/skip_forward01.png' style='width:16px' title='Fin' onClick='saltocol(\"$nuncilumnas\")'>";
				}
				if(($_POST[numpos]==0)||($_POST[numres]=="-1"))
				{
					$imagenback="<img src='imagenes/back02.png' style='width:17px'>";
					$imagensback="<img src='imagenes/skip_back02.png' style='width:16px'>";
				}
				else
				{
					$imagenback="<img src='imagenes/back01.png' style='width:17px' title='Anterior' onClick='numanterior();'>";
					$imagensback="<img src='imagenes/skip_back01.png' style='width:16px' title='Inicio' onClick='saltocol(\"1\")'>";
				}
				$con=1;
				echo "
				<table class='inicio' align='center'>
					<tr>
						<td colspan='7' class='titulos'>.: Listado de Preliquidaciones Generadas:</td>
						<td class='submenu'>
							<select name='renumres' id='renumres' onChange='cambionum();' style='width:100%'>
								<option value='10'"; if ($_POST[renumres]=='10'){echo 'selected';} echo ">10</option>
								<option value='20'"; if ($_POST[renumres]=='20'){echo 'selected';} echo ">20</option>
								<option value='30'"; if ($_POST[renumres]=='30'){echo 'selected';} echo ">30</option>
								<option value='50'"; if ($_POST[renumres]=='50'){echo 'selected';} echo ">50</option>
								<option value='100'"; if ($_POST[renumres]=='100'){echo 'selected';} echo ">100</option>
								<option value='-1'"; if ($_POST[renumres]=='-1'){echo 'selected';} echo ">Todos</option>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan='8' class='saludo3'>Recaudos Encontrados: $ntr</td>
					</tr>
					<tr>
						<td width='150' class='titulos2'>No Ciclo</td>
						<td class='titulos2'>Vigencia</td>
						<td class='titulos2'>Fecha Impresion</td>
						<td class='titulos2'>Fecha Limite</td>
						<td class='titulos2'>Inicial</td>
						<td class='titulos2'>Final</td>
						<td class='titulos2'>Descuento</td>
						<td class='titulos2' width='5%'>Imprimir</td>
					</tr>";	
				$iter='saludo1a';
           		$iter2='saludo2';
				while ($row =mysql_fetch_row($resp))
				{
					echo"
					<tr class='$iter'  style='text-transform:uppercase;' onDblClick='pdf(\"$row[0]\")'>
						<td>$row[0]</td>
						<td>$row[1]</td>
						<td>$row[2]</td>
						<td>$row[3]</td>
						<td>$row[4]</td>
						<td>$row[5]</td>
						<td>$row[6]%</td>
						<td style='text-align:center;'><img src='imagenes/print.png' title='Imprimir' class='icoop' onClick='pdf(\"$row[0]\")' /></td>
					</tr>";
					$aux=$iter;
               		$iter=$iter2;
                	$iter2=$aux;
				}
				echo"</table>
				<table class='inicio'>
					<tr>
						<td style='text-align:center;'>
							<a href='#'>$imagensback</a>&nbsp;
							<a href='#'>$imagenback</a>&nbsp;&nbsp;";
							if($nuncilumnas<=9){$numfin=$nuncilumnas;}
							else{$numfin=9;}
							for($xx = 1; $xx <= $numfin; $xx++)
							{
								if($numcontrol<=9){$numx=$xx;}
								else{$numx=$xx+($numcontrol-9);}
								if($numcontrol==$numx){echo"<a href='#' onClick='saltocol(\"$numx\")'; style='color:#24D915'> $numx </a>";}
								else {echo"<a href='#' onClick='saltocol(\"$numx\")'; style='color:#000000'> $numx </a>";}
							}
							echo"&nbsp;&nbsp;<a href='#'>$imagenforward</a>
								&nbsp;<a href='#'>$imagensforward</a>
						</td>
					</tr>
				</table>";
			?>
			</div>
            <input type="hidden" name="numtop" id="numtop" value="<?php echo $_POST[numtop];?>" />
		</form>
	</body>
</html>