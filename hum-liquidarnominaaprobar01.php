<?php
	require"comun.inc";
	require"funciones.inc";
	sesion();
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
		<title>:: Spid - Gestion Humana</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
		<script>
			function buscater(e){if (document.form2.tercero.value!=""){document.form2.bt.value='1';document.form2.submit();}}
			function guardar()
			{
				if (document.getElementById('idliq').value!='-1' && document.getElementById('rp').value!='-1' && document.getElementById('ntercero').value!=''){despliegamodalm('visible','4','Esta Seguro de Guardar','1')}
			  else{despliegamodalm('visible','2','Faltan datos para completar el registro'); }
			 }
			function validar(formulario)
			{
				document.form2.cperiodo.value='2';
				document.form2.action="hum-liquidarnominaaprobar.php";
				document.form2.submit();
			}
			function marcar(indice,posicion)
			{
				vvigencias=document.getElementsByName('empleados[]');
				vtabla=document.getElementById('fila'+indice);
				clase=vtabla.className;
				if(vvigencias.item(posicion).checked){vtabla.style.backgroundColor='#3399bb';}
	 			else
	 			{
					e=vvigencias.item(posicion).value;
					document.getElementById('fila'+e).style.backgroundColor='#ffffff';
	 			}
	 			sumarconc();
 			}
			function excell()
			{
				document.form2.action="hum-liquidarnominaexcel.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function pdf()
			{
				document.form2.action="pdfpeticionrp2.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function despliegamodal2(_valor)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else 
				{document.getElementById('ventana2').src="tercerosgral-ventana01.php?objeto=tercero&nobjeto=ntercero&nfoco=";}
			}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden")
				{
					document.getElementById('ventanam').src="";
					if(document.getElementById('valfocus').value=="1")
					{
						document.getElementById('valfocus').value='0';
						document.getElementById('ntercero').value='';
						document.getElementById('bt').value='0';
					}
				}
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
			function funcionmensaje(){document.location.href = "";}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.form2.oculto.value="2";
								document.form2.submit();break;
					case "2": 	despliegamodalm("hidden");
								mypop=window.open('cont-terceros.php','','');break;
				}
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
    		<tr><script>barra_imagenes("hum");</script><?php cuadro_titulos();?></tr>	 
    		<tr><?php menu_desplegable("hum");?></tr>
			<tr>
  				<td colspan="3" class="cinta"><a href="hum-liquidarnominaaprobar.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a><a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar"/></a><a onClick="document.form2.submit();" href="hum-buscanominasaprobadas.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a><a href="#" onClick="mypop=window.open('hum-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a><a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png" title="Imprimir"></a> <a href="#" onClick='excell()' class="mgbt"><img src="imagenes/excel.png" title="Excel"></a></td>
       		</tr>	
		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
 		<form name="form2" method="post" action="">
        	<input type="hidden" name="valfocus" id="valfocus" value="0"/>
			<?php
				$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
				if($_POST[oculto]==""){$_POST[tabgroup1]=1;}
				switch($_POST[tabgroup1])
				{
					case 1:	$check1='checked';break;
					case 2:	$check2='checked';break;
					case 3:	$check3='checked';break;
				}
				if(!$_POST[oculto])
				{
	 				$_POST[idcomp]=selconsecutivo('humnomina_aprobado','id_aprob'); 
					$fec=date("d/m/Y");
		 			$_POST[fecha]=$fec; 
				}
		 		$pf[]=array();
		 		$pfcp=array();	
			?>
            <div class="tabscontra" style="height:74.5%; width:99.6%">
 				<div class="tab">
       				<input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
	   				<label for="tab-1">Liquidaciones</label>
	   				<div class="content" style="overflow-y:hidden">
						<table  class="inicio" align="center" >
                            <tr>
                                <td class="titulos" colspan="10">:: Buscar Liquidaciones</td>
                                <td class="cerrar" style="width:7%;"><a href="hum-principal.php">&nbsp;Cerrar</a></td>
                            </tr>
                            <tr>
                                <td class="saludo1">No Aprobacion</td>
                                <td><input name="idcomp" type="text"  value="<?php echo $_POST[idcomp]?>" readonly></td>
                                <td class="saludo1">No Liquidacion</td>
                                <td>
                                    <select name="idliq" id="idliq" onChange="document.form2.submit();" >
                                        <option value="-1">Sel ...</option>
                                        <?php
                                            $sqlr="SELECT TB1.*,TB2.cdp,TB2.rp FROM humnomina TB1, hum_nom_cdp_rp TB2 WHERE TB1.estado='S' AND TB1.id_nom=TB2.nomina AND TB2.vigencia='$vigusu'";
                                            $resp = mysql_query($sqlr,$linkbd);
                                            while ($row =mysql_fetch_row($resp)) 
                                            {
                                                if($row[0]==$_POST[idliq])
                                                { 
                                                    echo "<option value='$row[0]' SELECTED>$row[0]</option>";
                                                    $_POST[tperiodo]=$row[2];	
                                                    $_POST[periodo]=$row[3];
                                                    $_POST[cc]=$row[6];
                                                    $_POST[diasperiodo]=$row[4];
													if($row[10]!='0'){$_POST[rp]=$row[10];}
													else{$_POST[rp]='';$_POST[descrp]="RP Sin Asignar";}
													if($row[9]=='0'){$_POST[cdp]="CDP Sin Asignar";}	  
                                                }
                                                else {echo "<option value='$row[0]'>$row[0]</option>";}
                                            }   
                                        ?>
                                    </select>
                                </td>
                                <td class="saludo1">Fecha</td>
                                <td><input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY">&nbsp;<a href="#" onClick="displayCalendarFor('fc_1198971545');" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px;"></a></td>
                            </tr>
                            <tr>
                                <td class="saludo1">RP</td> 
                                <td colspan="3">
                                    <select name="rp" id="rp" onChange="validar()" >
                                        <option value="-1">Sel ...</option>
                                        <?php	
                                            $sqlr="SELECT DISTINCT TB1.consvigencia,TB2.valor,TB2.idcdp,TB1.vigencia,TB3.objeto FROM humnom_rp TB1 INNER JOIN pptorp TB2 ON TB1.consvigencia=TB2.consvigencia  AND TB1.estado='S' AND TB1.vigencia='$vigusu' AND TB2.vigencia='$vigusu' INNER JOIN pptocdp TB3 ON TB3.consvigencia=TB2.idcdp AND TB3.vigencia='$vigusu' ORDER BY CONVERT(TB1.consvigencia, SIGNED INTEGER) ";
											
                                            $resp = mysql_query($sqlr,$linkbd);
                                            while ($row =mysql_fetch_row($resp)) 
                                            {
											
                                                if($row[0]==$_POST[rp])
                                                {
                                                    echo "<option value='$row[0]' SELECTED>$row[0]</option>";
                                                    $_POST[rp]=$row[0];	
                                                    $_POST[valorp]=$row[1];
                                                    $_POST[hvalorp]=$row[1];
                                                    $_POST[cdp]=$row[2];
													$desglo = explode(" - ", $row[4]);
													$_POST[descrp]=$row[4];			  
                                                }
                                                
                                            }   
                                        ?>
                                    </select>
                                    <input type="text" name="descrp" id="descrp" value="<?php echo $_POST[descrp];?>" style="width:60%" readonly/>
                                    <input type="hidden" name="hvalorp" id="hvalorp" value="<?php echo $_POST[hvalorp]?>" />
                                    <input type="text" name="valorp" id="valorp "value="<?php echo number_format($_POST[valorp],2)?>" readonly/>
                                </td>
                                <td class="saludo1">CDP:</td>
                                <td>
                                    <input type="text" id="cdp" name="cdp" value="<?php echo $_POST[cdp]?>" style="width:30%;" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td class="saludo1">Tercero:</td>
                                <td>
                                    <input id="tercero" type="text" name="tercero"  onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo $_POST[tercero]?>" >
                                    <input type="hidden" value="0" name="bt" id="bt">&nbsp;<a href="#" onClick="despliegamodal2('visible');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a></td>
                                <td colspan="8"><input type="text" id="ntercero" name="ntercero" value="<?php echo $_POST[ntercero]?>" style="width:86.6%;" readonly></td>
                                
                                    <input type="hidden" id="cajacomp" name="cajacomp" value="<?php echo $_POST[cajacomp]?>">
                                    <input type="hidden" id="icbf" name="icbf" value="<?php echo $_POST[icbf]?>">
                                    <input type="hidden" id="sena" name="sena" value="<?php echo $_POST[sena]?>">
                                    <input type="hidden" id="esap" name="esap" value="<?php echo $_POST[esap]?>">
                                    <input type="hidden" id="iti" name="iti" value="<?php echo $_POST[iti]?>">           
                                    <input type="hidden" id="btrans" name="btrans" value="<?php echo $_POST[btrans]?>">
                                    <input type="hidden" id="balim" name="balim" value="<?php echo $_POST[balim]?>">
                                    <input type="hidden" id="bfsol" name="bfsol" value="<?php echo $_POST[bfsol]?>">
                                    <input type="hidden" id="transp" name="transp" value="<?php echo $_POST[transp]?>">
                                    <input type="hidden" id="alim" name="alim" value="<?php echo $_POST[alim]?>">
                                    <input type="hidden" id="salmin" name="salmin" value="<?php echo $_POST[salmin]?>">        
                                    <input type="hidden" id="tperiodonom" name="tperiodonom" value="<?php echo $_POST[tperiodonom]?>" >
                                    <input type="hidden" name="cperiodo" id="cperiodo" value="">
                                </td>
                            </tr>                       
    					</table>  
                	</div>
				</div>  
         		<div class="tab">
       				<input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?> >
	   				<label for="tab-2">Empleados</label>
	   				<div class="content" >
						<?php
                            $crit1=" ";
                            $crit2=" ";
                            //echo "<table class='inicio' align='center' width='99%'><tr><td colspan='17' class='titulos'>.: Resultados Busqueda: $ntr Empleados</td></tr><tr><td class='titulos2' width='1%'>Vac</td><td class='titulos2' >EMPLEADO</td><td class='titulos2' width='2%'>CC</td><td class='titulos2' >SAL BAS</td><td class='titulos2' >DIAS LIQ</td><td class='titulos2' >DEVENGADO</td><td class='titulos2' >AUX ALIM</td><td class='titulos2' >AUX TRAN</td><td class='titulos2' >HORAS EXTRAS</td><td class='titulos2' >TOT DEV</td></tr>";	
                            echo "
                            <table class='inicio' align='center' width='99%'>
                                <tr><td colspan='18' class='titulos'>.: Resultados Busqueda: $ntr Empleados</td></tr>
                                <tr>
                                    <td class='titulos2'></td>
                                    <td class='titulos2' width='1%'>Vac<input type='checkbox' name='todos' value=''  onClick='' $chk></td>
                                    <td class='titulos2' >EMPLEADO</td>
                                    <td class='titulos2' width='2%'>CC</td>
                                    <td class='titulos2' >SAL BAS</td>
                                    <td class='titulos2' >DIAS LIQ</td>
                                    <td class='titulos2' >DEVENGADO</td>
                                    <td class='titulos2' >AUX ALIM</td>
                                    <td class='titulos2' >AUX TRAN</td>
                                    <td class='titulos2' >HORAS EXTRAS</td>
                                    <td class='titulos2' >TOT DEV</td>
                                    <td class='titulos2' >SALUD</td>
                                    <td class='titulos2' >PENSION</td>
                                    <td class='titulos2' >F SOLIDA</td>
                                    <td class='titulos2' >RETE FTE</td>
                                    <td class='titulos2' >OTRAS DEDUC</td>
                                    <td class='titulos2' >TOT DEDUC</td>
                                    <td class='titulos2' >NETO PAG</td>
                                </tr>";	
                                $iter="zebra1";
                                $iter2="zebra2";
                                $con=0;
                                $sqlr="select *from humnomina_det where id_nom=$_POST[idliq]";
                                $resp = mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($resp)) 
                                {
                                    $_POST[ccemp][$con]=$row[1];
                                    $_POST[nomemp][$con]=buscatercero($row[1]);		
                                    $salario=$row[2];
                                    $_POST[diast][$con]=$row[3];
                                    $deven=$row[4];
                                    $auxalimtot=$row[6];
                                    $auxtratot=$row[7];
                                    $ibc=$row[5];
                                    $horaextra=$row[8];
                                    $totdev=$row[9];
                                    $arpemp=$row[9];
                                    $rsalud=$row[10];
                                    $rsaludemp=$row[11];
                                    $valsaludtot=$row[10]+$row[11];
                                    $rpension=$row[12];
                                    $rpensionemp=$row[13];
                                    $fondosol=$row[14];
                                    $valpensiontot=$row[12]+$row[13]+$row[14];
                                    $otrasrete=$row[16];
                                    $totalretenciones=$row[17];
                                    $totalneto=$row[18];
                                    $chk='';
                                    if($row[20]=='S'){$chk='checked';}
                                    echo "
                                    <tr  id='fila$row[1]' class='$iter' $style>
                                        <td>$con</td>
                                        <td><input type='checkbox' name='empleados[]' value='".$_POST[ccemp][$con]."' onClick='marcar(".$_POST[empleados][$con].",$con);' $chk disabled><input name='vacacion' type='hidden' value='$row[20]'></td>
                                        <td><input type='hidden' name='nomemp[]' value='".$_POST[nomemp][$con]."'>".$_POST[nomemp][$con]."</td><td ><input type='hidden' name='ccemp[]' value='".$_POST[ccemp][$con]."'>".$_POST[ccemp][$con]."</td>
                                        <td><input type='hidden' name='centrocosto[]' value='".$row[31]."' size='8' readonly><input type='text' name='salbas[]' value='$salario' size='8' readonly> </td>
                                        <td><input type='text' size='2' name='diast[]' value='".$_POST[diast][$con]."'  onKeyPress='javascript:return solonumeros(event)' onKeyUp='return tabular(event,this)' onBlur='document.form2.submit()' readonly> </td>
                                        <td><input type='text' size='8' name='devengado[]' value='".($deven)."' readonly></td>
                                        <td><input type='text' size='5' name='ealim[]' value='".($auxalimtot)."' readonly></td>
                                        <td><input type='text' size='5' name='etrans[]' value='".($auxtratot)."' readonly></td>
                                        <td><input type='text' name='horaextra[]' value='$horaextra' size='8' readonly></td>
                                        <td><input type='text' name='totaldev[]' value='$totdev' size='8' readonly><input type='hidden' name='ibc[]' value='$ibc' size='8' readonly></td>
                                        <td><input type='hidden' name='arpemp[]' value='$varp'><input type='text' name='saludrete[]' value='$rsalud' size='8' readonly><input type='hidden' name='saludemprete[]' value='$rsaludemp' size='8' readonly><input type='hidden' name='totsaludrete[]' value='$valsaludtot' size='8' readonly></td>
                                        <td><input type='text' name='pensionrete[]' value='$rpension' size='8' readonly><input type='hidden' name='pensionemprete[]' value='$rpensionemp' size='8' readonly><input type='hidden' name='totpensionrete[]' value='$valpensiontot' size='8' readonly> </td>
                                        <td><input type='text' name='fondosols[]' value='$fondosol' size='8' readonly></td>
                                        <td>$row2[2] </td>
                                        <td><input type='text' name='otrasretenciones[]' value='$otrasrete' size='8' readonly></td>
                                        <td><input type='text' name='totalrete[]' value='$totalretenciones' size='8' readonly> </td><td><input type='text' name='netopagof[]' value='".number_format($totalneto,0)."' size='12' readonly><input type='hidden' name='netopago[]' value='$totalneto'></td>
                                    </tr>";
                                    $_POST[totsaludtot]+=$valsaludtot;
                                    $_POST[totpenstot]+=$valpensiontot;
                                    $_POST[totaldevini]+=$deven;
                                    $_POST[totalauxalim]+=$auxalimtot;
                                    $_POST[totalauxtra]+=$auxtratot;
                                    $_POST[totaldevtot]+=$totdev;	
                                    $_POST[totalsalud]+=$rsalud;
                                    $_POST[totalpension]+=$rpension;
                                    $_POST[totalfondosolida]+=$fondosol;
                                    $_POST[totalotrasreducciones]+=$otrasrete;
                                    $_POST[totaldeductot]+=$totalretenciones;
                                    $_POST[totalnetopago]+=$totalneto;	
                                    $con+=1;
                                    $aux=$iter;
                                    $iter=$iter2;
                                    $iter2=$aux;
                                }
                                echo "
                                <tr class='$iter'>
                                    <td colspan='5'></td>
                                    <td><input type='hidden' name='totaldevini' value='$_POST[totaldevini]'>".number_format($_POST[totaldevini],2)."</td>
                                    <td><input type='hidden' name='totalauxalim' value='$_POST[totalauxalim]'>".number_format($_POST[totalauxalim],2)."</td>
                                    <td><input type='hidden' name='totalauxtra' value='$_POST[totalauxtra]'>".number_format($_POST[totalauxtra],2)."</td>
                                    <td><input type='hidden' name='totalhorex' value='$_POST[totalhorex]'>".number_format($_POST[totalhorex],2)."</td>
                                    <td></td>
                                    <td><input type='hidden' name='totaldevtot' value='$_POST[totaldevtot]'>".number_format($_POST[totaldevtot],2)."</td>
                                    <td><input type='hidden' name='totalsalud' value='$_POST[totalsalud]'>".number_format($_POST[totalsalud],2)."</td>
                                    <td><input type='hidden' name='totalpension' value='$_POST[totalpension]'>".number_format($_POST[totalpension],2)."</td>
                                    <td><input type='hidden' name='totalfondosolida' value='$_POST[totalfondosolida]'>".number_format($_POST[totalfondosolida],2)."</td>
                                    <td></td>
                                    <td><input type='hidden' name='totalotrasreducciones' value='$_POST[totalotrasreducciones]'><input type='hidden' name='totalotrasreducciones' value='$_POST[totalotrasreducciones]'>".number_format($_POST[totalotrasreducciones],2)."</td>
                                    <td><input type='hidden' name='totaldeductot' value='$_POST[totaldeductot]'>".number_format($_POST[totaldeductot],2)."</td>
                                    <td><input type='hidden' name='totalnetopago' value='$_POST[totalnetopago]'>".number_format($_POST[totalnetopago],2)."</td>			
                                </tr>";	
                                echo"</table>";			
                            ?>
               			</div>
                	</div>
                    <div class="tab">
       				<input type="radio" id="tab-3" name="tabgroup1" value="3" <?php echo $check3;?> >
	   				<label for="tab-3">Aportes</label>
	   					<div class="content" style="overflow-x:hidden">
                            <table class="inicio">
                            <tr>
								<td class="titulos" style="width:8%">Codigo</td>
                                <td class="titulos" style="width:20%">Aportes Parafiscales</td>
                                <td class="titulos" style="width:8%">Porcentaje</td>
                                <td class="titulos" style="width:10%">Valor</td>
                                <td class="titulos" >descripci&oacute;n</td>
							</tr>
                            <?php
								$sqlr="SELECT id_parafiscal, porcentaje, SUM(valor) FROM humnomina_parafiscales WHERE id_nom='$_POST[idcomp]' GROUP BY id_parafiscal";
	 							$resp2 = mysql_query($sqlr,$linkbd);
	 							$iter="zebra1";
								$iter2="zebra2";
	 							while($row2 =mysql_fetch_row($resp2))
	  							{
									$sqlrtipo="SELECT tipo, nombre FROM humparafiscales WHERE codigo='$row2[0]'";
	 								$resptipo = mysql_query($sqlrtipo,$linkbd);
									$rowtipo=mysql_fetch_row($resptipo);
									
  	 								echo "
									<tr class='$iter'>
										<input type='hidden' name='codpara[]' value='$row2[0]'/>
										<input type='hidden' name='codnpara[]' value='$rowtipo[1]'/>
										<input type='hidden' name='porpara[]' value='$row2[1]'/>
										<input type='hidden' name='valpara[]' value='$row2[2]'/>
										<input type='hidden' name='tipopara[]' value='$rowtipo[0]'/>
										<td>$row2[0]</td>
										<td>$rowtipo[1]</td>
										<td style='text-align:right;'>$row2[1] %</td>
										<td style='text-align:right;'>$ $row2[2]&nbsp;</td>";
									if ($rowtipo[0]=="A"){echo"<td>&nbsp;APORTES EMPRESA</td>";}
									else{echo"<td>&nbsp;APORTE EMPLEADOS</td>";}
									echo"	</tr>";
									$aux=$iter;
									$iter=$iter2;
									$iter2=$aux;
								}
								echo "
								<tr>
									<td></td>
									<td colspan='2' style='text-align:right;'>TOTAL SALUD: </td>
									<td class='saludo3' style='text-align:right;'>$ ".number_format(array_sum($listasaludtotal),2)."</td>
									<td></td>
								</tr>
								<tr '>
									<td></td>
									<td colspan='2' style='text-align:right;'>TOTAL PENSION: </td>
									<td class='saludo3' style='text-align:right;'>".number_format(array_sum($listapensiontotal),2)."</td>
								</tr>";
							?>
                        </table>
                        <table class="inicio">
                            <tr>
                                <td class="titulos">Cuenta Presupuestal</td>
                                <td class="titulos">Nombre Cuenta Presupuestal</td>
                                <td class="titulos">Valor</td>
                            </tr>
                            <?php
                                $totalrubro=0;
                                $sqlr="select *from  humnom_presupuestal where id_nom='$_POST[idliq]'";
                                $resp=mysql_query($sqlr,$linkbd);
                                while($rp=mysql_fetch_row($resp))
                                {
                                    $k=$rp[1];	
                                    $ncta=existecuentain($k); 
                                    $valrubros=$rp[2];	   
                                    $ncta=existecuentain($k);
                                    echo "
                                    <tr class='$iter'>
                                        <td ><input type='hidden' name='rubrosp[]' value='$k'>$k</td>
                                        <td><input type='hidden' name='nrubrosp[]' value='".strtoupper($ncta)."'>".strtoupper($ncta)."</td>
                                        <td align='right'><input type='hidden' name='vrubrosp[]' value='$valrubros'>".number_format($valrubros,2)."</td>
                                    </tr>";
                                    $totalrubro+=$valrubros;
                                    $aux=$iter;
                                    $iter=$iter2;
                                    $iter2=$aux;
                                }
                            ?>
                            <tr class='saludo3'>
                                <td></td>
                                <td>Total:</td>
                                <td align='right'><?php echo number_format($totalrubro,2) ?></td>
                            </tr> 
                        </table>
                     </div>
                     </div>
                     </div>
                     <input type="hidden" name="oculto" id="oculto" value="1"/>
		<?php
			if($_POST[bt]=='1')
			{
				$nresul=buscatercero($_POST[tercero]);
				if($nresul!='')
				{
					echo"
					<script>									
						document.getElementById('ntercero').value='$nresul';
						document.getElementById('cuenta').focus();
						document.getElementById('cuenta').select();
					</script>";
				}
				else 
				{
					echo"
					<script>
						document.getElementById('valfocus').value='1';
						despliegamodalm('visible','4','Tercero Incorrecto o no Existe, ¿Desea Agregar un Tercero?','2');
					</script>";
				}
			}
			if($_POST[oculto]=="2")
 			{
  				ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
				$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
				$_POST[idcomp]=selconsecutivo('humnomina_aprobado','id_aprob'); 
	 			$sqlr="insert into humnomina_aprobado (id_aprob,id_nom,fecha,id_rp,persoaprobo,estado) values ($_POST[idcomp],$_POST[idliq], '$fechaf','$_POST[rp]','$_SESSION[usuario]','S')";
	 			if (!mysql_query($sqlr,$linkbd)) {echo"<script>despliegamodalm('visible','2','No se Pudo Aprobrar la Nomina');</script>";}
	  			else
	  			{
					$sqlr="insert into  pptocomprobante_cab (numerotipo,tipo_comp,fecha,concepto,vigencia,total_debito,total_credito,diferencia,estado) values('$_POST[idliq]',9,'$fechaf','NOMINA MES   $_POST[periodo]','$vigusu',0,0,0,'1')";
					mysql_query($sqlr,$linkbd);
					$sqlr="select *from  humnom_presupuestal where id_nom='$_POST[idliq]'";
					$resp=mysql_query($sqlr,$linkbd);
					while($rp=mysql_fetch_row($resp))
					{
					$k=$rp[1];	
					$valrubros=$rp[2];		
					$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values('$k','','NOMINA MES   $_POST[periodo]','$valrubros',0,1,'$vigusu',9,'$_POST[idliq]')";
					mysql_query($sqlr,$linkbd); 	 
					}
	  				$sqlr="update humnomina set estado='P' where id_nom=$_POST[idliq]"; 
	 				mysql_query($sqlr,$linkbd);
	  				$sqlr="update humnom_presupuestal set estado='P' where id_nom=$_POST[idliq]";
	 				mysql_query($sqlr,$linkbd);
					echo"<script>despliegamodalm('visible','3','Registros Exitosos:$cex   -   Registros Erroneos: $cerr');</script>";
	 	 			//*****cargue comprobante de nomina desde el precomprobante
	 				$sqlr="select *from humcomprobante_cab where numerotipo=$_POST[idliq]";
	 				$res=mysql_query($sqlr,$linkbd);
	 				while($row=mysql_fetch_row($res))
	  				{
   						$sqlri="insert into comprobante_cab (numerotipo,tipo_comp, fecha, concepto, total, total_debito, total_credito, diferencia, estado) values($row[1],$row[2],'$row[3]','$row[4]',$row[5],$row[6],$row[7],$row[8],$row[9])";
  						mysql_query($sqlri,$linkbd);
	  				}
	  				$sqlr="select *from humcomprobante_det where numerotipo=$_POST[idliq]";
	 				$res=mysql_query($sqlr,$linkbd);
	 				while($row=mysql_fetch_row($res))
	  				{
  						$sqlri="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia, tipo_comp,numerotipo) values('$row[1]','$row[2]','$row[3]','$row[4]','$row[5]','$row[6]',$row[7],$row[8],'$row[9]','$row[10]',$row[11],$row[12])";
   						mysql_query($sqlri,$linkbd);
	  				}	
					
					$sqlrdn="SELECT cedulanit FROM  humnomina_det WHERE id_nom='$_POST[idliq]'";
					$respdn=mysql_query($sqlrdn,$linkbd);
					while($rowdn=mysql_fetch_row($respdn))
					{
						$sqlrdn2="UPDATE humretenempleados SET sncuotas=sncuotas-1 WHERE estado='S' AND habilitado='H' AND empleado='$rowdn[0]' AND sncuotas>0";				
						$respdn2 = mysql_query($sqlrdn2,$linkbd);
	 					$rowdn2 =mysql_fetch_row($respdn2);
		 				$sqlrdn2="UPDATE humretenempleados SET estado='P' WHERE estado='S' AND habilitado='H' AND empleado='$rowdn[0]' AND sncuotas<=0";
	 					$respdn2 = mysql_query($sqlrdn2,$linkbd);
	 					$rowdn2 =mysql_fetch_row($respdn2); 
					}
	  			}
			 }
			?>
		</form>
        <div id="bgventanamodal2">
                <div id="ventanamodal2">
                    <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                    </IFRAME>
                </div>
       	 	</div>
	</body>
</html>