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
        <script src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
		<script>
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
				document.form2.action="pdfpeticionrp.php";
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
            <tr><script>barra_imagenes("hum");</script><?php cuadro_titulos();?></tr>
            <tr><?php menu_desplegable("hum");?></tr>
			<tr>
  				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='hum-nominacrear.php'" class="mgbt"/><img src="imagenes/guardad.png" class="mgbt1"/><img class="mgbt" src="imagenes/busca.png" onClick="location.href='hum-liquidarnominabuscar.php'" title="Buscar"/><img class="mgbt" src="imagenes/nv.png" title="Nueva Ventana" onClick="mypop=window.open('hum-principal.php','','');mypop.focus();"/><img src="imagenes/print.png" title="Imprimir" onClick="pdf()" class="mgbt"/><img src="imagenes/excel.png" title="Excel" onClick='excell()' class="mgbt"/><img src='imagenes/iratras.png' title='Men&uacute; Nomina' class='mgbt' onClick="location.href='hum-menunomina.php'"/></td>
         	</tr>	
		</table>	
 		<form name="form2" method="post" action="">
			<?php
				$_POST[idcomp]=$_GET[idnomi];
				$listaempleados=array();
				$listadocumentos=array();
				$listasalariobasico=array();	
				$listadevengados=array();
				$listaauxalimentacion=array();
				$listaauxtrasporte=array();
				$listaotrospagos=array();
				$listatotaldevengados=array();
				$listaibc=array();
				$listabaseparafiscales=array();
				$listabasearp=array();
				$listaarp=array();
				$listasaludempleado=array();
				$listasaludempresa=array();
				$listasaludtotal=array();
				$listapensionempleado=array();
				$listapensionempresa=array();
				$listapensiontotal=array();
				$listafondosolidaridad=array();
				$listaretenciones=array();
				$listaotrasdeducciones=array();
				$listatotaldeducciones=array();
				$listanetoapagar=array();
				$listaccf=array();
				$listasena=array();
				$listaicbf=array();
				$listainstecnicos=array();
				$listaesap=array();
				$listatotalparafiscales=array();
				$listadiasincapacidad=array();
				$listatipofondopension=array();
				$listadiaslaborados=array();
				$stesap=$stinstec=$sticbf=$stsena=$stccf=$stvneto=$sttdescu=$stodescu=$strete=$stfsol=$stpent=$stpemr=$stpfun=0;
				$stsalt=$stsemr=$stsfun=$starl=$sttdev=$stotp=$stauxt=$stauxa=$stdeven=0;
				$sqlrg="SELECT * FROM humnomina WHERE id_nom='$_POST[idcomp]'";
				$respg=mysql_query($sqlrg,$linkbd);
				$rowg=mysql_fetch_row($respg);
				$_POST[fecha]=$rowg[1];
				$_POST[vigencia]=$rowg[7];
				//*****************************************
				$_POST[diast]=array();
				$sqlrp="SELECT * FROM humperiodos WHERE id_periodo='$rowg[2]'";
				$rowp =mysql_fetch_row(mysql_query($sqlrp,$linkbd));
				$_POST[tperiodo]=$rowg[2];
				$_POST[tperiodov]=$rowg[2]." - ".$rowp[1];
				$_POST[tperiodonom]=$rowp[1];
				$_POST[diasperiodo]=$rowp[2];
				if ($rowg[6]!='')
				{
					$sqlrcc="SELECT * FROM centrocosto WHERE id_cc='$rowg[6]'";
					$rowcc=mysql_fetch_row(mysql_query($sqlrcc,$linkbd));	
					$_POST[ccv]= $rowcc[0]." - ".$rowcc[1];
					$_POST[cc]=$rowcc[0];
				}
				else{$_POST[ccv]='TODOS';$_POST[cc]='';}
				$sqlrm="SELECT * FROM meses WHERE id=$rowg[3]";
				$rowm =mysql_fetch_row(mysql_query($sqlrm,$linkbd));
				$_POST[periodov]=$rowm[1];
				$_POST[periodo]=$rowm[0];
				$_POST[periodonom]=$rowm[1];
				$_POST[periodonom]=$rowm[2]; 
				if ($rowg[5]=='1'){$_POST[mesnumv]="1 Quincena";}				
				else {$_POST[mesnumv]="2 Quincena";}
				$_POST[mesnum]=$rowg[5];
				$_POST[cperiodo]="2";
				//*****parametros de nomina
				$_POST[tabgroup1]=1;
		 			 				 		
				//*** fin parametros de nomina *******					
		 	$pf[]=array();
		 	$pfcp=array();	
			switch($_POST[tabgroup1])
			{
				case 1:$check1='checked';break;
				case 2:$check2='checked';break;
				case 3:$check3='checked';break;
				case 4:$check4='checked';break;
			}		 
		?>
            
			<table  class="inicio">
      			<tr>
        			<td class="titulos" colspan="8" style='width:93%'>:: Liquidar Nomina</td>
                    <td class="cerrar" style='width:7%'><a href="hum-principal.php">Cerrar</a></td>
      			</tr>
      			<tr>
                	<td class="saludo1" style='width:10%'>No Liquidacion:</td>
                    <td style='width:12%'><input name="idcomp" type="text" value="<?php echo $_POST[idcomp]?>" style='width:100%' readonly></td>
                    <td class="saludo1" style='width:5%'>Fecha:</td>
                    <td style='width:10%'><input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" style='width:100%' readonly></td>
                    <td class="saludo1" style='width:5%'>Vigencia:</td> 
                    <td colspan="3"><input name="vigencia" type="text"  value="<?php echo $_POST[vigencia]?>" style='width:100%' readonly></td>
	    		</tr>
      			<tr>
        			<td class="saludo1">Periodo Liquidar:</td>
					<td>
                    	<input name="tperiodov" id="tperiodov" type="text" value="<?php echo $_POST[tperiodov];?>" readonly> 
						<input name="tperiodo" id="tperiodo" type="hidden" value="<?php echo $_POST[tperiodo];?>" >  
                        <input id="tperiodonom" name="tperiodonom" type="hidden" value="<?php echo $_POST[tperiodonom]?>" >
                        <input name="cperiodo" type="hidden" value="">
					</td>
        			<td class="saludo1">Dias:</td>
        			<td>
                    	<input name="diasperiodo" type="text" id="diasperiodo" value="<?php echo $_POST[diasperiodo]?>"  readonly>
         				<input name="oculto" type="hidden" value="1">
                   	</td>
          			<td class="saludo1">CC:</td>
          			<td>
                    	<input type="text" name="ccv" id="ccv" value="<?php echo $_POST[ccv];?>" readonly>
                        <input type="hidden" name="cc" id="cc" value="<?php echo $_POST[cc];?>" >
          			</td>
          			<td class="saludo1" colspan="1">Mes:</td>
          			<td>
                    	<input type="text" name="periodov" id="periodov" value="<?php echo $_POST[periodov];?>" readonly/>
                        <input type="hidden" name="periodo" id="periodo" value="<?php echo $_POST[periodo];?>" readonly/>
		  				<input <?php if($_POST[tperiodo]!='1'){echo "type='text'";}else{echo "type='hidden'";}?> name="mesnumv" id="mesnumv" value="<?php echo $_POST[mesnumv];?>" style='width:30%' readonly> 
                        <input type="hidden" name="mesnum" id="mesnum" value="<?php echo $_POST[mesnum];?>"/> 
           			</td>
       			</tr>                       
    		</table>    
			<div class="tabscontra" style="height:63.5%; width:99.6%;">
 				<div class="tab">
       				<input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?>/>
	   				<label for="tab-1">Liquidacion Empleados</label>
	   				<div class="content">
      				<?php
						$crit1=" ";
						$crit2=" ";
						echo "
						<table class='inicio' align='center' width='99%'>
							<tr><td colspan='33' class='titulos'>.: Resultados Busqueda: $ntr Empleados</td></tr>
							<tr>
								<th class='titulos2'>ID</th>
								<th class='titulos2'>TIPO</th>
								<th class='titulos2'>SECTOR</th>
								<th class='titulos2'>VAC</th>
								<th class='titulos2'>EMPLEADO</th>
								<th class='titulos2'>DOC ID</th>
								<th class='titulos2'>SAL BAS</th>
								<th class='titulos2'>DIAS LIQ</th>
								<th class='titulos2'>DIAS NOVEDAD</th>
								<th class='titulos2'>DEVENGADO</th>
								<th class='titulos2'>AUX ALIM</th>
								<th class='titulos2'>AUX TRAN</th>
								<th class='titulos2'>OTROS</th>
								<th class='titulos2'>TOT DEV</th>
								<th class='titulos2'>IBC</th>
								<th class='titulos2'>BASE PARAFISCALES</th>									
								<th class='titulos2'>BASE ARP</th>
								<th class='titulos2'>ARP</th>
								<th class='titulos2'>SALUD EMPLEADO</th>
								<th class='titulos2'>SALUD EMPRESA</th>
								<th class='titulos2'>SALUD TOTAL</th>
								<th class='titulos2'>PENSION EMPLEADO</th>
								<th class='titulos2'>PENSION EMPRESA</th>
								<th class='titulos2'>PENSION TOTAL</th>
								<th class='titulos2'>FONDO SOLIDARIDAD</th>
								<th class='titulos2'>RETE FTE</th>
								<th class='titulos2'>OTRAS DEDUC</th>
								<th class='titulos2'>TOT DEDUC</th>
								<th class='titulos2'>NETO PAG</th>
								<th class='titulos2'>CCF</th>
								<th class='titulos2'>SENA</th>
								<th class='titulos2'>ICBF</th>
								<th class='titulos2'>INS. TEC.</th>
								<th class='titulos2'>ESAP</th>
							</tr>";	
						$iter='zebra1';
						$iter2='zebra2';
						$con=1;
						$numtervar="";
							$sqlrt="SELECT * FROM humnomina_det WHERE id_nom='$_POST[idcomp]' ORDER BY idfuncionario, tipopago";
							$respt = mysql_query($sqlrt,$linkbd);
	 						while ($rowt =mysql_fetch_row($respt)) 
							{
								if($numtervar==""){$numtervar=$rowt[1];}
								if($numtervar!=$rowt[1])
								{
									$sqlnet="SELECT SUM(devendias),SUM(auxalim),SUM(auxtran),SUM(valhorex),SUM(totaldev),SUM(ibc),SUM(basepara), SUM(basearp),SUM(arp),SUM(salud),SUM(saludemp),SUM(totalsalud),SUM(pension),SUM(pensionemp),SUM(totalpension),SUM(fondosolid),SUM(retefte), SUM(otrasdeduc),SUM(totaldeduc),SUM(netopagar),SUM(cajacf),SUM(sena),SUM(icbf),SUM(instecnicos),SUM(esap) FROM humnomina_det WHERE id_nom='$_POST[idcomp]' AND cedulanit='$numtervar'";
									$resnet = mysql_query($sqlnet,$linkbd);
									$rownet = mysql_fetch_row($resnet);
									$empleado=buscatercero($numtervar);
									echo "
									<tr  class='$iter' style='font-weight:bold;'>
										<td style='font-size:10px; text-align:center;'>$con</td>
										<td style='font-size:10px; text-align:center;'>&nbsp;Neto Total</td>
										<td style='font-size:10px; text-align:center;'>&nbsp;--</td>
										<td style='font-size:10px; text-align:center;'>--</td>
										<td style='font-size:10px;'>$empleado</td>
										<td style='font-size:10px;'>&nbsp;$numtervar</td>
										<td style='text-align:center;font-size:10px;' title='Salario Basico'>&nbsp;--</td>
										<td style='font-size:10px; text-align:center;' title='Dias Liquidados'>--</td>
										<td style='font-size:10px; text-align:center;' title='Dias Novedad'>--</td>
										<td style='text-align:right;font-size:10px;' title='Salario Devengado'>&nbsp;$".number_format($rownet[0],0)."</td>
										<td style='text-align:right;font-size:10px;' title='Aux Alimentaci&oacute;n'>&nbsp;$".number_format($rownet[1],0)."</td>
										<td style='text-align:right;font-size:10px;' title='Aux Transporte'>&nbsp;$".number_format($rownet[2],0)."</td>
										<td style='text-align:right;font-size:10px;' title='Otros Pagos'>&nbsp;$".number_format($rownet[3],0)."</td>
										<td style='text-align:right;font-size:10px;' title='Total Devengado'>&nbsp;$".number_format($rownet[4],0)."</td>
										<td style='text-align:right;font-size:10px;' title='IBC'>&nbsp;$".number_format($rownet[5],0)."</td>
										<td style='text-align:right;font-size:10px;' title='Base Parafiscales'>&nbsp;$".number_format($rownet[6],0)."</td>
										<td style='text-align:right;font-size:10px;' title='Base ARL'>&nbsp;$".number_format($rownet[7],0)."</td>
										<td style='text-align:right;font-size:10px;' title='ARL'>&nbsp;$".number_format($rownet[8],0)."</td>
										<td style='text-align:right;font-size:10px;' title='Salud Empleado'>&nbsp;$".number_format($rownet[9],0)."</td>
										<td style='text-align:right;font-size:10px;' title='Salud Empresa'>&nbsp;$".number_format($rownet[10],0)."</td>
										<td style='text-align:right;font-size:10px;' title='Total salud'>&nbsp;$".number_format($rownet[11],0)."</td>
										<td style='text-align:right;font-size:10px;' title='Pension Empleado'>&nbsp;$".number_format($rownet[12],0)."</td>
										<td style='text-align:right;font-size:10px;' title='Pension Empresa'>&nbsp;$".number_format($rownet[13],0)."</td>
										<td style='text-align:right;font-size:10px;' title='Total Pension'>&nbsp;$".number_format($rownet[14],0)."</td>
										<td style='text-align:right;font-size:10px;' title='Fondo Soliraridad'>&nbsp;$".number_format($rownet[15],0)."</td>
										<td style='text-align:right;font-size:10px;' title='Retefuente'>&nbsp;$".number_format($rownet[16],0)."</td>
										<td style='text-align:right;font-size:10px;' title='Otras Deducciones'>&nbsp;$".number_format($rownet[17],0)."</td>
										<td style='text-align:right;font-size:10px;' title='Total Deducciones'>&nbsp;$".number_format($rownet[18],0)."</td>
										<td style='text-align:right;font-size:10px;' title='Neto A Pagar'>&nbsp;$".number_format($rownet[19],0)."</td>
										<td style='text-align:right;font-size:10px;' title='CCF'>&nbsp;$".number_format($rownet[20],0)."</td>
										<td style='text-align:right;font-size:10px;' title='SENA'>&nbsp;$".number_format($rownet[21],0)."</td>
										<td style='text-align:right;font-size:10px;' title='ICBF'>&nbsp;$".number_format($rownet[22],0)."</td>
										<td style='text-align:right;font-size:10px;' title='Institutos Tecnicos'>&nbsp;$".number_format($rownet[23],0)."</td>
										<td style='text-align:right;font-size:10px;' title='ESAP'>&nbsp;$".number_format($rownet[24],0)."</td>
									</tr>";
									$con+=1;
									$aux=$iter;
									$iter=$iter2;
									$iter2=$aux;
									$listaempleados[]=strtoupper($empleado);
									$listadocumentos[]=$numtervar;
									$listasalariobasico[]="--";
									$listadevengados[]=$rownet[0];
									$listaauxalimentacion[]=$rownet[1];
									$listaauxtrasporte[]=$rownet[2];
									$listaotrospagos[]=$rownet[3];
									$listatotaldevengados[]=$rownet[4];
									$listaibc[]=$rownet[5];
									$listabaseparafiscales[]=$rownet[6];
									$listabasearp[]=$rownet[7];
									$listaarp[]=$rownet[8];
									$listasaludempleado[]=$rownet[9];
									$listasaludempleadog[]=$rownet[9];
									$listasaludempresa[]=$rownet[10];
									$listasaludempresag[]=$rownet[10];
									$listasaludtotal[]=$rownet[11];
									$listasaludtotalg[]=$rownet[11];
									$listapensionempleado[]=$rownet[12];
									$listapensionempleadog[]=$rownet[12];
									$listapensionempresa[]=$rownet[13];
									$listapensionempresag[]=$rownet[13];
									$listapensiontotal[]=$rownet[14];
									$listapensiontotalg[]=$rownet[14];
									$listafondosolidaridad[]=$rownet[15];
									$listafondosolidaridadg[]=$rownet[15];
									$listaretenciones[]=$rownet[16];
									$listaotrasdeducciones[]=$rownet[17];
									$listatotaldeducciones[]=$rownet[18];
									$listanetoapagar[]=$rownet[19];
									$listaccf[]=$rownet[20];
									$listasena[]=$rownet[21];
									$listaicbf[]=$rownet[22];
									$listainstecnicos[]=$rownet[23];
									$listaesap[]=$rownet[24];
									$listatipofondopension[]="--";
									$listadiasincapacidad[]="--";
									$listadiaslaborados[]="--";
									$listatipopago[]="NN";
									$numtervar=$rowt[1];
									$stdeven+=$rownet[0];
									$stauxa+=$rownet[1];
									$stauxt+=$rownet[2];
									$stotp+=$rownet[3];
									$sttdev+=$rownet[4];
									$starl+=$rownet[8];
									$stsfun+=$rownet[9];
									$stsemr+=$rownet[10];
									$stsalt+=$rownet[11];
									$stpfun+=$rownet[12];
									$stpemr+=$rownet[13];
									$stpent+=$rownet[14];
									$stfsol+=$rownet[15];
									$strete+=$rownet[16];
									$stodescu+=$rownet[17];
									$sttdescu+=$rownet[18];
									$stvneto+=$rownet[19];
									$stccf+=$rownet[20];
									$stsena+=$rownet[21];
									$sticbf+=$rownet[22];
									$stinstec+=$rownet[23];
									$stesap+=$rownet[24];
								}
								$empleado=buscatercero($rowt[1]);
								if($rowt[20]==1){$varvacas="X";}
								else {$varvacas="";}
								if($rowt[21]!=""){$diasnove="$rowt[21]";}
								else {$diasnove="0";}
								if($rowt[36]=='01'){$tipodepago="$rowt[37]";}
								else {$tipodepago=buscavariblespagonomina($rowt[36]);}
								echo "
								<tr  class='$iter'>
									<td style='font-size:10px; text-align:center;'>$con</td>
									<td style='font-size:10px; text-align:center;'>&nbsp;$tipodepago</td>
									<td style='font-size:10px; text-align:center;'>&nbsp;$rowt[27]</td>
									<td style='font-size:10px; text-align:center;'>$varvacas</td>
									<td style='font-size:10px;'>$empleado</td>
									<td style='font-size:10px;'>&nbsp;$rowt[1]</td>
									<td style='text-align:right;font-size:10px;' title='Salario Basico'>&nbsp;$".number_format($rowt[2],0)."</td>
									<td style='font-size:10px; text-align:center;' title='Dias Liquidados'>$rowt[3]</td>
									<td style='font-size:10px; text-align:center;' title='Dias Novedad'>$diasnove</td>
									<td style='text-align:right;font-size:10px;' title='Salario Devengado'>&nbsp;$".number_format($rowt[4],0)."</td>
									<td style='text-align:right;font-size:10px;' title='Aux Alimentaci&oacute;n'>&nbsp;$".number_format($rowt[6],0)."</td>
									<td style='text-align:right;font-size:10px;' title='Aux Transporte'>&nbsp;$".number_format($rowt[7],0)."</td>
									<td style='text-align:right;font-size:10px;' title='Otros Pagos'>&nbsp;$".number_format($rowt[8],0)."</td>
									<td style='text-align:right;font-size:10px;' title='Total Devengado'>&nbsp;$".number_format($rowt[9],0)."</td>
									<td style='text-align:right;font-size:10px;' title='IBC'>&nbsp;$".number_format($rowt[5],0)."</td>
									<td style='text-align:right;font-size:10px;' title='Base Parafiscales'>&nbsp;$".number_format($rowt[28],0)."</td>
									<td style='text-align:right;font-size:10px;' title='Base ARL'>&nbsp;$".number_format($rowt[29],0)."</td>
									<td style='text-align:right;font-size:10px;' title='ARL'>&nbsp;$".number_format($rowt[30],0)."</td>
									<td style='text-align:right;font-size:10px;' title='Salud Empleado'>&nbsp;$".number_format($rowt[10],0)."</td>
									<td style='text-align:right;font-size:10px;' title='Salud Empresa'>&nbsp;$".number_format($rowt[11],0)."</td>
									<td style='text-align:right;font-size:10px;' title='Total salud'>&nbsp;$".number_format($rowt[31],0)."</td>
									<td style='text-align:right;font-size:10px;' title='Pension Empleado'>&nbsp;$".number_format($rowt[12],0)."</td>
									<td style='text-align:right;font-size:10px;' title='Pension Empresa'>&nbsp;$".number_format($rowt[13],0)."</td>
									<td style='text-align:right;font-size:10px;' title='Total Pension'>&nbsp;$".number_format($rowt[32],0)."</td>
									<td style='text-align:right;font-size:10px;' title='Fondo Soliraridad'>&nbsp;$".number_format($rowt[14],0)."</td>
									<td style='text-align:right;font-size:10px;' title='Retefuente'>&nbsp;$".number_format($rowt[15],0)."</td>
									<td style='text-align:right;font-size:10px;' title='Otras Deducciones'>&nbsp;$".number_format($rowt[16],0)."</td>
									<td style='text-align:right;font-size:10px;' title='Total Deducciones'>&nbsp;$".number_format($rowt[17],0)."</td>
									<td style='text-align:right;font-size:10px;' title='Neto A Pagar'>&nbsp;$".number_format($rowt[18],0)."</td>
									<td style='text-align:right;font-size:10px;' title='CCF'>&nbsp;$".number_format($rowt[22],0)."</td>
									<td style='text-align:right;font-size:10px;' title='SENA'>&nbsp;$".number_format($rowt[23],0)."</td>
									<td style='text-align:right;font-size:10px;' title='ICBF'>&nbsp;$".number_format($rowt[24],0)."</td>
									<td style='text-align:right;font-size:10px;' title='Institutos Tecnicos'>&nbsp;$".number_format($rowt[25],0)."</td>
									<td style='text-align:right;font-size:10px;' title='ESAP'>&nbsp;$".number_format($rowt[26],0)."</td>
								</tr>";
								$con+=1;
								$listaempleados[]=strtoupper($empleado);
								$listadocumentos[]=$rowt[1];
								$listasalariobasico[]=$rowt[2];
								$listadevengados[]=$rowt[4];
								$listaauxalimentacion[]=$rowt[6];
								$listaauxtrasporte[]=$rowt[7];
								$listaotrospagos[]=$rowt[8];
								$listatotaldevengados[]=$rowt[9];
								$listaibc[]=$rowt[5];
								$listabaseparafiscales[]=$rowt[28];
								$listabasearp[]=$rowt[29];
								$listaarp[]=$rowt[30];
								$listasaludempleado[]=$rowt[10];
								$listasaludempresa[]=$rowt[11];
								$listasaludtotal[]=$rowt[31];
								$listapensionempleado[]=$rowt[12];
								$listapensionempresa[]=$rowt[13];
								$listapensiontotal[]=$rowt[32];
								$listafondosolidaridad[]=$rowt[14];
								$listaretenciones[]=$rowt[15];
								$listaotrasdeducciones[]=$rowt[16];
								$listatotaldeducciones[]=$rowt[17];
								$listanetoapagar[]=$rowt[18];
								$listaccf[]=$rowt[22];
								$listasena[]=$rowt[23];
								$listaicbf[]=$rowt[24];
								$listainstecnicos[]=$rowt[25];
								$listaesap[]=$rowt[26];
								$listatipofondopension[]=$rowt[27];
								$listadiasincapacidad[]=$diasnove;
								$listadiaslaborados[]=$rowt[3];
								$listatipopago[]=$rowt[36];
								$ultimocc=$rowt[1];
							}
							$sqlnet="SELECT SUM(devendias),SUM(auxalim),SUM(auxtran),SUM(valhorex),SUM(totaldev),SUM(ibc),SUM(basepara), SUM(basearp),SUM(arp),SUM(salud),SUM(saludemp),SUM(totalsalud),SUM(pension),SUM(pensionemp),SUM(totalpension),SUM(fondosolid),SUM(retefte), SUM(otrasdeduc),SUM(totaldeduc),SUM(netopagar),SUM(cajacf),SUM(sena),SUM(icbf),SUM(instecnicos),SUM(esap) FROM humnomina_det WHERE id_nom='$_POST[idcomp]' AND cedulanit='$ultimocc'";
							$resnet = mysql_query($sqlnet,$linkbd);
							$rownet = mysql_fetch_row($resnet);
							$empleado=buscatercero($numtervar);
							echo "
							<tr  class='$iter' style='font-weight:bold;'>
								<td style='font-size:10px; text-align:center;'>$con</td>
								<td style='font-size:10px; text-align:center;'>&nbsp;Neto Total</td>
								<td style='font-size:10px; text-align:center;'>&nbsp;--</td>
								<td style='font-size:10px; text-align:center;'>--</td>
								<td style='font-size:10px;'>$empleado</td>
								<td style='font-size:10px;'>&nbsp;$numtervar</td>
								<td style='text-align:center;font-size:10px;' title='Salario Basico'>&nbsp;--</td>
								<td style='font-size:10px; text-align:center;' title='Dias Liquidados'>--</td>
								<td style='font-size:10px; text-align:center;' title='Dias Novedad'>--</td>
								<td style='text-align:right;font-size:10px;' title='Salario Devengado'>&nbsp;$".number_format($rownet[0],0)."</td>
								<td style='text-align:right;font-size:10px;' title='Aux Alimentaci&oacute;n'>&nbsp;$".number_format($rownet[1],0)."</td>
								<td style='text-align:right;font-size:10px;' title='Aux Transporte'>&nbsp;$".number_format($rownet[2],0)."</td>
								<td style='text-align:right;font-size:10px;' title='Otros Pagos'>&nbsp;$".number_format($rownet[3],0)."</td>
								<td style='text-align:right;font-size:10px;' title='Total Devengado'>&nbsp;$".number_format($rownet[4],0)."</td>
								<td style='text-align:right;font-size:10px;' title='IBC'>&nbsp;$".number_format($rownet[5],0)."</td>
								<td style='text-align:right;font-size:10px;' title='Base Parafiscales'>&nbsp;$".number_format($rownet[6],0)."</td>
								<td style='text-align:right;font-size:10px;' title='Base ARL'>&nbsp;$".number_format($rownet[7],0)."</td>
								<td style='text-align:right;font-size:10px;' title='ARL'>&nbsp;$".number_format($rownet[8],0)."</td>
								<td style='text-align:right;font-size:10px;' title='Salud Empleado'>&nbsp;$".number_format($rownet[9],0)."</td>
								<td style='text-align:right;font-size:10px;' title='Salud Empresa'>&nbsp;$".number_format($rownet[10],0)."</td>
								<td style='text-align:right;font-size:10px;' title='Total salud'>&nbsp;$".number_format($rownet[11],0)."</td>
								<td style='text-align:right;font-size:10px;' title='Pension Empleado'>&nbsp;$".number_format($rownet[12],0)."</td>
								<td style='text-align:right;font-size:10px;' title='Pension Empresa'>&nbsp;$".number_format($rownet[13],0)."</td>
								<td style='text-align:right;font-size:10px;' title='Total Pension'>&nbsp;$".number_format($rownet[14],0)."</td>
								<td style='text-align:right;font-size:10px;' title='Fondo Soliraridad'>&nbsp;$".number_format($rownet[15],0)."</td>
								<td style='text-align:right;font-size:10px;' title='Retefuente'>&nbsp;$".number_format($rownet[16],0)."</td>
								<td style='text-align:right;font-size:10px;' title='Otras Deducciones'>&nbsp;$".number_format($rownet[17],0)."</td>
								<td style='text-align:right;font-size:10px;' title='Total Deducciones'>&nbsp;$".number_format($rownet[18],0)."</td>
								<td style='text-align:right;font-size:10px;' title='Neto A Pagar'>&nbsp;$".number_format($rownet[19],0)."</td>
								<td style='text-align:right;font-size:10px;' title='CCF'>&nbsp;$".number_format($rownet[20],0)."</td>
								<td style='text-align:right;font-size:10px;' title='SENA'>&nbsp;$".number_format($rownet[21],0)."</td>
								<td style='text-align:right;font-size:10px;' title='ICBF'>&nbsp;$".number_format($rownet[22],0)."</td>
								<td style='text-align:right;font-size:10px;' title='Institutos Tecnicos'>&nbsp;$".number_format($rownet[23],0)."</td>
								<td style='text-align:right;font-size:10px;' title='ESAP'>&nbsp;$".number_format($rownet[24],0)."</td>
							</tr>";
							$con+=1;
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux;
							$listaempleados[]=strtoupper($empleado);
							$listadocumentos[]=$numtervar;
							$listasalariobasico[]="--";
							$listadevengados[]=$rownet[0];
							$listaauxalimentacion[]=$rownet[1];
							$listaauxtrasporte[]=$rownet[2];
							$listaotrospagos[]=$rownet[3];
							$listatotaldevengados[]=$rownet[4];
							$listaibc[]=$rownet[5];
							$listabaseparafiscales[]=$rownet[6];
							$listabasearp[]=$rownet[7];
							$listaarp[]=$rownet[8];
							$listasaludempleado[]=$rownet[9];
							$listasaludempleadog[]=$rownet[9];
							$listasaludempresa[]=$rownet[10];
							$listasaludempresag[]=$rownet[10];
							$listasaludtotal[]=$rownet[11];
							$listasaludtotalg[]=$rownet[11];
							$listapensionempleado[]=$rownet[12];
							$listapensionempleadog[]=$rownet[12];
							$listapensionempresa[]=$rownet[13];
							$listapensionempresag[]=$rownet[13];
							$listapensiontotal[]=$rownet[14];
							$listapensiontotalg[]=$rownet[14];
							$listafondosolidaridad[]=$rownet[15];
							$listafondosolidaridadg[]=$rownet[15];
							$listaretenciones[]=$rownet[16];
							$listaotrasdeducciones[]=$rownet[17];
							$listatotaldeducciones[]=$rownet[18];
							$listanetoapagar[]=$rownet[19];
							$listaccf[]=$rownet[20];
							$listasena[]=$rownet[21];
							$listaicbf[]=$rownet[22];
							$listainstecnicos[]=$rownet[23];
							$listaesap[]=$rownet[24];
							$listatipofondopension[]="--";
							$listadiasincapacidad[]="--";
							$listadiaslaborados[]="--";
							$listatipopago[]="NN";
							$numtervar=$rowt[1];
							$stdeven+=$rownet[0];
							$stauxa+=$rownet[1];
							$stauxt+=$rownet[2];
							$stotp+=$rownet[3];
							$sttdev+=$rownet[4];
							$starl+=$rownet[8];
							$stsfun+=$rownet[9];
							$stsemr+=$rownet[10];
							$stsalt+=$rownet[11];
							$stpfun+=$rownet[12];
							$stpemr+=$rownet[13];
							$stpent+=$rownet[14];
							$stfsol+=$rownet[15];
							$strete+=$rownet[16];
							$stodescu+=$rownet[17];
							$sttdescu+=$rownet[18];
							$stvneto+=$rownet[19];
							$stccf+=$rownet[20];
							$stsena+=$rownet[21];
							$sticbf+=$rownet[22];
							$stinstec+=$rownet[23];
							$stesap+=$rownet[24];
						echo "
						<input type='hidden' name='lista_empleados' value='".serialize($listaempleados)."'/>
						<input type='hidden' name='lista_documento' value='".serialize($listadocumentos)."'/>
						<input type='hidden' name='lista_salariobasico' value='".serialize($listasalariobasico)."'/>
						<input type='hidden' name='lista_devengados' value='".serialize($listadevengados)."'/>
						<input type='hidden' name='lista_auxalimentacion' value='".serialize($listaauxalimentacion)."'/>
						<input type='hidden' name='lista_auxtrasporte' value='".serialize($listaauxtrasporte)."'/>
						<input type='hidden' name='lista_otrospagos' value='".serialize($listaotrospagos)."'/>
						<input type='hidden' name='lista_totaldevengados' value='".serialize($listatotaldevengados)."'/>
						<input type='hidden' name='lista_ibc' value='".serialize($listaibc)."'/>
						<input type='hidden' name='lista_baseparafiscales' value='".serialize($listabaseparafiscales)."'/>
						<input type='hidden' name='lista_basearp' value='".serialize($listabasearp)."'/>
						<input type='hidden' name='lista_arp' value='".serialize($listaarp)."'/>
						<input type='hidden' name='lista_saludempleado' value='".serialize($listasaludempleado)."'/>
						<input type='hidden' name='lista_saludempleadog' value='".serialize($listasaludempleadog)."'/>
						<input type='hidden' name='lista_saludempresa' value='".serialize($listasaludempresa)."'/>
						<input type='hidden' name='lista_saludempresag' value='".serialize($listasaludempresag)."'/>
						<input type='hidden' name='lista_saludtotal' value='".serialize($listasaludtotal)."'/>
						<input type='hidden' name='lista_saludtotalg' value='".serialize($listasaludtotalg)."'/>
						<input type='hidden' name='lista_pensionempleado' value='".serialize($listapensionempleado)."'/>
						<input type='hidden' name='lista_pensionempleadog' value='".serialize($listapensionempleadog)."'/>
						<input type='hidden' name='lista_pensionempresa' value='".serialize($listapensionempresa)."'/>
						<input type='hidden' name='lista_pensionempresag' value='".serialize($listapensionempresag)."'/>
						<input type='hidden' name='lista_pensiontotal' value='".serialize($listapensiontotal)."'/>
						<input type='hidden' name='lista_pensiontotalg' value='".serialize($listapensiontotalg)."'/>
						<input type='hidden' name='lista_fondosolidaridad' value='".serialize($listafondosolidaridad)."'/>
						<input type='hidden' name='lista_fondosolidaridadg' value='".serialize($listafondosolidaridadg)."'/>
						<input type='hidden' name='lista_retenciones' value='".serialize($listaretenciones)."'/>
						<input type='hidden' name='lista_otrasdeducciones' value='".serialize($listaotrasdeducciones)."'/>
						<input type='hidden' name='lista_totaldeducciones' value='".serialize($listatotaldeducciones)."'/>
						<input type='hidden' name='lista_netoapagar' value='".serialize($listanetoapagar)."'/>
						<input type='hidden' name='lista_ccf' value='".serialize($listaccf)."'/>
						<input type='hidden' name='lista_sena' value='".serialize($listasena)."'/>
						<input type='hidden' name='lista_icbf' value='".serialize($listaicbf)."'/>
						<input type='hidden' name='lista_instecnicos' value='".serialize($listainstecnicos)."'/>
						<input type='hidden' name='lista_esap' value='".serialize($listaesap)."'/>
						<input type='hidden' name='lista_diasincapacidad' value='".serialize($listadiasincapacidad)."'/>
						<input type='hidden' name='lista_diaslaborados' value='".serialize($listadiaslaborados)."'/>
						<input type='hidden' name='lista_tipopago' value='".serialize($listatipopago)."'/>
						<tr class='titulos2'>
								<td colspan='9'></td>
								<td style='text-align:right;'>$".number_format($stdeven,0,',','.')."</td>
								<td style='text-align:right;'>$".number_format($stauxa,0,',','.')."</td>
								<td style='text-align:right;'>$".number_format($stauxt,0,',','.')."</td>
								<td style='text-align:right;'>$".number_format($stotp,0,',','.')."</td>
								<td style='text-align:right;'>$".number_format($sttdev,0,',','.')."</td>
								<td style='text-align:center;'>--</td>
								<td style='text-align:center;'>--</td>
								<td style='text-align:center;'>--</td>
								<td style='text-align:right;'>$".number_format($starl,0,',','.')."</td>
								<td style='text-align:right;'>$".number_format($stsfun,0,',','.')."</td>
								<td style='text-align:right;'>$".number_format($stsemr,0,',','.')."</td>
								<td style='text-align:right;'>$".number_format($stsalt,0,',','.')."</td>
								<td style='text-align:right;'>$".number_format($stpfun,0,',','.')."</td>
								<td style='text-align:right;'>$".number_format($stpemr,0,',','.')."</td>
								<td style='text-align:right;'>$".number_format($stpent,0,',','.')."</td>
								<td style='text-align:right;'>$".number_format($stfsol,0,',','.')."</td>
								<td style='text-align:right;'>$".number_format($strete,0,',','.')."</td>
								<td style='text-align:right;'>$".number_format($stodescu,0,',','.')."</td>
								<td style='text-align:right;'>$".number_format($sttdescu,0,',','.')."</td>
								<td style='text-align:right;'>$".number_format($stvneto,0,',','.')."</td>
								<td style='text-align:right;'>$".number_format($stccf,0,',','.')."</td>
								<td style='text-align:right;'>$".number_format($stsena,0,',','.')."</td>
								<td style='text-align:right;'>$".number_format($sticbf,0,',','.')."</td>
								<td style='text-align:right;'>$".number_format($stinstec,0,',','.')."</td>
								<td style='text-align:right;'>$".number_format($stesap,0,',','.')."</td>
							</tr>
						</table>";
					?>
                    </div>
				</div>
    			<div class="tab">
       				<input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?> >
	   				<label for="tab-2">Aportes Parafiscales</label>
	   				<div class="content" style="overflow-x:hidden;">
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
									<td class='saludo3' style='text-align:right;'>$ ".number_format(array_sum($listasaludtotalg),2)."</td>
									<td></td>
								</tr>
								<tr '>
									<td></td>
									<td colspan='2' style='text-align:right;'>TOTAL PENSION: </td>
									<td class='saludo3' style='text-align:right;'>".number_format(array_sum($listapensiontotalg),2)."</td>
								</tr>";
							?>
						</table>
					</div>
				</div>
    			<div class="tab">
       				<input type="radio" id="tab-3" name="tabgroup1" value="3" <?php echo $check3;?> >
	   				<label for="tab-3">Presupuesto</label>
	   				<div class="content" style="overflow-x:hidden;">
						<table class="inicio">
							<tr>
								<td class="titulos">Cuenta Presupuestal</td>
                                <td class="titulos">Nombre Cuenta Presupuestal</td>
                                <td class="titulos">Valor</td>
                         	</tr>
							<?php
								$sqlr="select * from  humnom_presupuestal where id_nom=$_POST[idcomp]";
	 							$resp2 = mysql_query($sqlr,$linkbd);
	 							$co=0;
								$totalrubro=0;
	 							while($row2 =mysql_fetch_row($resp2))
	  							{								
								$valrubros=$row2[2];
  									if($valrubros>0)
  									{
										$ncta=existecuentain($row2[1]);
  										echo "
										<tr class='saludo3'>
											<td ><input type='hidden' name='rubrosp[]' value='$row2[1]'>$row2[1]</td>
											<td><input type='hidden' name='nrubrosp[]' value='".strtoupper($ncta)."'>".strtoupper($ncta)."</td>
											<td align='right'><input type='hidden' name='vrubrosp[]' value='$valrubros'>".number_format($valrubros,2)."</td>
										</tr>";
										$totalrubro+=$valrubros;
									}
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
</form>
</body>
</html>