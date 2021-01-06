<?php //V 1000 12/12/16 ?> 
<!--V 1.0 24/02/2015-->
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
  				<td colspan="3" class="cinta"><a href="hum-liquidarnomina.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a><a class="mgbt"><img src="imagenes/guardad.png"/></a><a href="hum-liquidarnominabuscar.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a><a href="#" onClick="mypop=window.open('hum-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a><a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png" title="Imprimir"></a><a href="#" onClick='excell()' class="mgbt"><img src="imagenes/excel.png"  title="Excel"></a></td></tr>	
		</table>	
 		<form name="form2" method="post" action="">
		<?php
			if($_POST[anticipo]=='S'){$chkant=' checked ';}
			if($_POST[oculto]=="")
			{
				$_POST[idcomp]=$_GET[idnomi];
				$sqlrg="SELECT * FROM humnomina WHERE id_nom='$_POST[idcomp]'";
				$respg=mysql_query($sqlrg,$linkbd);
				$rowg=mysql_fetch_row($respg);
				$_POST[fecha]=date('d/m/Y',strtotime($rowg[1]));
				$_POST[vigencia]=$rowg[7];
				//*****************************************
				$_POST[diast]=array();
				$_POST[devengado]=array();
				$_POST[empleados]=array();		 		
				$sqlrf="SELECT * FROM admfiscales WHERE vigencia='$_POST[vigencia]'";
				$rowf =mysql_fetch_row(mysql_query($sqlrf,$linkbd));
				$_POST[balim]=$rowf[7];
				$_POST[btrans]=$rowf[8];
				$_POST[bfsol]=$rowf[6];
				$_POST[alim]=$rowf[5];
				$_POST[transp]=$row[4];
				$_POST[salmin]=$rowf[3];
				$_POST[cajacomp]=$rowf[13];
				$_POST[icbf]=$rowf[10];
				$_POST[sena]=$rowf[11];
				$_POST[esap]=$rowf[14];
				$_POST[iti]=$rowf[12];	
				$_POST[indiceinca]=$rowf[15];						 	
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
		 		//**** carga parametros de nomina
		 		$sqlr="select * from humparametrosliquida";	
		 		$resp = mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($resp)) 
				{
					$_POST[aprueba]=$row[1];
					$_POST[naprueba]=buscatercero($row[1]);
					$_POST[tsueldo]=$row[2];
					$_POST[tsubalim]=$row[8];
					$_POST[tauxtrans]=$row[9];
					$_POST[trecnoct]=$row[11];
					$_POST[thorextdiu]=$row[12];
					$_POST[thorextnoct]=$row[13];
					$_POST[thororddom]=$row[14];
					$_POST[thorextdiudom]=$row[15];
					$_POST[thorextnoctdom]=$row[16];
					$_POST[tcajacomp]=$row[17];
					$_POST[ticbf]=$row[18];
					$_POST[tsena]=$row[19];
					$_POST[titi]=$row[20];
					$_POST[tesap]=$row[21];
					$_POST[tarp]=$row[22];
					$_POST[tsaludemr]=$row[23];
					$_POST[tsaludemp]=$row[24];
					$_POST[tpensionemr]=$row[25];
					$_POST[tpensionemp]=$row[26];
				}		 				 		
				//*** fin parametros de nomina *******					
			}
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
       		<input type="hidden" id="aprueba" name="aprueba" value="<?php echo $_POST[aprueba] ?>">
            <input type="hidden" id="naprueba" name="naprueba" value="<?php echo $_POST[naprueba] ?>">
            <input type="hidden" id="tsueldo" name="tsueldo" value="<?php echo $_POST[tsueldo] ?>">
            <input type="hidden" id="tsubalim" name="tsubalim" value="<?php echo $_POST[tsubalim] ?>">
            <input type="hidden" id="tauxtrans" name="tauxtrans" value="<?php echo $_POST[tauxtrans] ?>">
            <input type="hidden" id="trecnoct" name="trecnoct" value="<?php echo $_POST[trecnoct] ?>">
            <input type="hidden" id="thorextdiu" name="thorextdiu" value="<?php echo $_POST[thorextdiu] ?>">
            <input type="hidden" id="thorextnoct" name="thorextnoct" value="<?php echo $_POST[thorextnoct] ?>">
            <input type="hidden" id="thororddom" name="thororddom" value="<?php echo $_POST[thororddom] ?>">
            <input type="hidden" id="thorextdiudom" name="thorextdiudom" value="<?php echo $_POST[thorextdiudom] ?>">
            <input type="hidden" id="thorextnoctdom" name="thorextnoctdom" value="<?php echo $_POST[thorextnoctdom] ?>">
            <input type="hidden" id="tcajacomp" name="tcajacomp" value="<?php echo $_POST[tcajacomp] ?>">
            <input type="hidden" id="ticbf" name="ticbf" value="<?php echo $_POST[ticbf] ?>">
            <input type="hidden" id="tsena" name="tsena" value="<?php echo $_POST[tsena] ?>">
            <input type="hidden" id="titi" name="titi" value="<?php echo $_POST[titi] ?>">
            <input type="hidden" id="tesap" name="tesap" value="<?php echo $_POST[tesap] ?>">
            <input type="hidden" id="tarp" name="tarp" value="<?php echo $_POST[tarp] ?>">
            <input type="hidden" id="tsaludemr" name="tsaludemr" value="<?php echo $_POST[tsaludemr] ?>">
            <input type="hidden" id="tsaludemp" name="tsaludemp" value="<?php echo $_POST[tsaludemp] ?>">
            <input type="hidden" id="tpensionemr" name="tpensionemr" value="<?php echo $_POST[tpensionemr] ?>">
            <input type="hidden" id="tpensionemp" name="tpensionemp" value="<?php echo $_POST[tpensionemp] ?>">
            
            <input id="cajacomp" name="cajacomp" type="hidden" value="<?php echo $_POST[cajacomp]?>" >
            <input id="icbf" name="icbf" type="hidden" value="<?php echo $_POST[icbf]?>" >
            <input id="sena" name="sena" type="hidden" value="<?php echo $_POST[sena]?>" >
            <input id="esap" name="esap" type="hidden" value="<?php echo $_POST[esap]?>" >
            <input id="iti" name="iti" type="hidden" value="<?php echo $_POST[iti]?>" >           
            <input id="indiceinca" name="indiceinca" type="hidden" value="<?php echo $_POST[indiceinca]?>" >                   
            <input id="btrans" name="btrans" type="hidden" value="<?php echo $_POST[btrans]?>" >
            <input id="balim" name="balim" type="hidden" value="<?php echo $_POST[balim]?>" >
            <input id="bfsol" name="bfsol" type="hidden" value="<?php echo $_POST[bfsol]?>" >
            <input id="transp" name="transp" type="hidden" value="<?php echo $_POST[transp]?>" >
            <input id="alim" name="alim" type="hidden" value="<?php echo $_POST[alim]?>" >
            <input id="salmin" name="salmin" type="hidden" value="<?php echo $_POST[salmin]?>" >  
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
                    	<input type="text" name="periodov" id="periodov" value="<?php echo $_POST[periodov];?>" readonly >
                        <input type="hidden" name="periodo" id="periodo" value="<?php echo $_POST[periodo];?>" readonly >
		  				<input <?php if($_POST[tperiodo]!='1'){echo "type='text'";}else{echo "type='hidden'";}?> name="mesnumv" id="mesnumv" value="<?php echo $_POST[mesnumv];?>" style='width:30%' readonly> 
                        <input type="hidden" name="mesnum" id="mesnum" value="<?php echo $_POST[mesnum];?>" > 
           				<input type="button" value="Calcular" name="calcular" onClick="validar()" >
           			</td>
       			</tr>                       
    		</table>    
			<div class="tabscontra" style="height:63.5%; width:99.6%;">
 				<div class="tab">
       				<input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
	   				<label for="tab-1">Liquidacion Empleados</label>
	   				<div class="content">
                    	<input type='hidden' name='totaldevini' value='$_POST[totaldevini]'>
                        <input type='hidden' name='totalauxalim' value='$_POST[totalauxalim]'>
                        <input type='hidden' name='totalauxtra' value='$_POST[totalauxtra]'>
                        <input type='hidden' name='totalhorex' value='$_POST[totalhorex]'>
                        <input type='hidden' name='totaldevtot' value='$_POST[totaldevtot]'>
                        <input type='hidden' name='totalsalud' value='$_POST[totalsalud]'>
                        <input type='hidden' name='totalpension' value='$_POST[totalpension]'>
                        <input type='hidden' name='totalfondosolida' value='$_POST[totalfondosolida]'>
                        <input type='hidden' name='totalretef' value='$_POST[totalretef]'>
                        <input type='hidden' name='totalotrasreducciones' value='$_POST[totalotrasreducciones]'>
                        <input type='hidden' name='totaldeductot' value='$_POST[totaldeductot]'>
                        <input type='hidden' name='totalnetopago' value='$_POST[totalnetopago]'>
      				<?php
						$crit1=" ";
						$crit2=" ";
						echo "
						<table class='inicio' align='center' width='99%'>
							<tr><td colspan='20' class='titulos'>.: Resultados Busqueda: $ntr Empleados</td></tr>
							<tr>
								<td  class='titulos2'>Id</td>
								<td class='titulos2' >SECTOR</td>
								<td class='titulos2' width='1%'>Vac<input type='checkbox' name='todos' value=''  onClick='' $chk></td>
								<td class='titulos2' >EMPLEADO</td>
								<td class='titulos2' width='2%'>Doc Id</td>
								<td class='titulos2' >SAL BAS</td>
								<td class='titulos2' >DIAS LIQ</td>
								<td class='titulos2' >Dias Novedad</td>
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
						$iter='zebra1';
						$iter2='zebra2';
						$con=1;
						$_POST[totaldevini]=$_POST[totalauxalim]=$_POST[totalauxtra]=$_POST[totalhorex]=$_POST[totaldevtot]=$_POST[totalsalud]=$_POST[totalpension]=$_POST[totalfondosolida]=$_POST[totalotrasreducciones]=$_POST[totaldeductot]=$_POST[totalnetopago]=0;
							$sqlrt="SELECT * FROM humnomina_det WHERE id_nom='$_POST[idcomp]'";
							$respt = mysql_query($sqlrt,$linkbd);
	 						while ($rowt =mysql_fetch_row($respt)) 
							{
								$empleado=buscatercero($rowt[1]);
								//$empleado= buscar_empleado($rowt[1]);
								//$empleado= $rowt[1];
								$sqlrn="select fondopensionestipo from terceros_nomina where cedulanit='$rowt[1]' ";
								$rown =mysql_fetch_row(mysql_query($sqlrn,$linkbd));
								$tipofondopension=$rown[0];
								echo "
								<tr  class='$iter'>
									<td style='font-size:10px;'>$con</td>
									<td style='font-size:10px;'>$tipofondopension</td>
									<td style='font-size:10px;'><input type='checkbox' name='empleados[]' value='$row[12]'  onClick='marcar($row[12],$con);' $chk></td>
									<td style='font-size:10px;'>$empleado</td>
									<td style='font-size:10px;'>$rowt[1]</td>
									<td style='text-align:right;font-size:10px;'>$".number_format($rowt[2],0)." </td>
									<td style='font-size:10px;'>$rowt[3]</td>
									<td style='font-size:10px;'></td>
									<td style='text-align:right;font-size:10px;'>$".number_format($rowt[4],0)."</td>
									<td style='text-align:right;font-size:10px;'>$".number_format($rowt[6],0)."</td>
									<td style='text-align:right;font-size:10px;'>$".number_format($rowt[7],0)."</td>
									<td style='text-align:right;font-size:10px;'>$".number_format($rowt[8],0)."</td>
									<td style='text-align:right;font-size:10px;'>$".number_format($rowt[9],0)."</td>
									<td style='text-align:right;font-size:10px;'>$".number_format($rowt[10],0)."</td>
									<td style='text-align:right;font-size:10px;'>$".number_format($rowt[12],0)."</td>
									<td style='text-align:right;font-size:10px;'>$".number_format($rowt[14],0)."</td>
									<td style='text-align:right;font-size:10px;'>$".number_format($rowt[15],0)."</td>
									<td style='text-align:right;font-size:10px;'>$".number_format($rowt[16],0)."</td>
									<td style='text-align:right;font-size:10px;'>$".number_format($rowt[17],0)."</td>
									<td style='text-align:right;font-size:10px;'>$".number_format($rowt[18],0)."</td>
								</tr>";
								$con+=1;
								$aux=$iter;
								$iter=$iter2;
								$iter2=$aux;
								$_POST[totaldevini]=$_POST[totaldevini]+$rowt[4];
								$_POST[totalauxalim]=$_POST[totalauxalim]+$rowt[6];
								$_POST[totalauxtra]=$_POST[totalauxtra]+$rowt[7];
								$_POST[totalhorex]=$_POST[totalhorex]+$rowt[8];
								$_POST[totaldevtot]=$_POST[totaldevtot]+$rowt[9];
								$_POST[totalsalud]=$_POST[totalsalud]+$rowt[10];
								$_POST[totalpension]=$_POST[totalpension]+$rowt[12];
								$_POST[totalfondosolida]=$_POST[totalfondosolida]+$rowt[14];
								$_POST[totalretef]=$_POST[totalretef]+$rowt[15];
								$_POST[totalotrasreducciones]=$_POST[totalotrasreducciones]+$rowt[16];
								$_POST[totaldeductot]=$_POST[totaldeductot]+$rowt[17];
								$_POST[totalnetopago]=$_POST[totalnetopago]+$rowt[18];
							}
						echo "
						<tr class='saludo3'>
							<td colspan='8'></td>
							<td style='text-align:right;'>$".number_format($_POST[totaldevini],2)."</td>
							<td style='text-align:right;'>$".number_format($_POST[totalauxalim],2)."</td>
							<td style='text-align:right;'>$".number_format($_POST[totalauxtra],2)."</td>
							<td style='text-align:right;'>$".number_format($_POST[totalhorex],2)."</td>
							<td style='text-align:right;'>$".number_format($_POST[totaldevtot],2)."</td>
							<td style='text-align:right;'>$".number_format($_POST[totalsalud],2)."</td>
							<td style='text-align:right;'>$".number_format($_POST[totalpension],2)."</td>
							<td style='text-align:right;'>$".number_format($_POST[totalfondosolida],2)."</td>
							<td style='text-align:right;'>$".number_format($_POST[totalretef],2)."</td>
							<td style='text-align:right;'>$".number_format($_POST[totalotrasreducciones],2)."</td>
							<td style='text-align:right;'>$".number_format($_POST[totaldeductot],2)."</td>
							<td style='text-align:right;'>$".number_format($_POST[totalnetopago],2)."</td>
						</tr>";	
 						echo"</table>";
					?>
                    </div>
				</div>
    			<div class="tab">
       				<input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?> >
	   				<label for="tab-2">Aportes Parafiscales</label>
	   				<div class="content" style="overflow-x:hidden;">
						<table class="inicio">
							<tr>
								<td class="titulos">Codigo</td>
                                <td class="titulos">Aportes Parafiscales</td>
                                <td class="titulos">Porcentaje</td><td class="titulos">Valor</td>
								<td class="titulos">Codigo</td>
                                <td class="titulos">Aportes Parafiscales</td>
                                <td class="titulos">Porcentaje</td>
                                <td class="titulos">Valor</td>
								<td class="titulos">Codigo</td>
                                <td class="titulos">Aportes Parafiscales</td>
                                <td class="titulos">Porcentaje</td>
                                <td class="titulos">Valor</td>
							</tr>
							<?php
								$sqlr="select * from humparafiscales where tipo='A' and estado='S'";
	 							$resp2 = mysql_query($sqlr,$linkbd);
	 							$co=0;
	 							while($row2 =mysql_fetch_row($resp2))
	  							{
  	 								if($co==0){echo "<tr>";}	  
									$caja=$row2[0];
									$ncaja=$row2[1];
									$pcaja=$row2[3];
   									$vcaja=array_sum($pf[$row2[0]]);
	 								echo "
									<td class='saludo1'><input name='codpara[]' type='hidden' value='$caja'> $caja </td>
									<td class='saludo3'><input name='codnpara[]' type='hidden' value='$ncaja'>  $ncaja </td>
									<td class='saludo3'><input name='porpara[]' type='hidden' value='$pcaja'> $pcaja %</td>
									<td class='saludo3'><input name='valpara[]' type='hidden' value='$vcaja'>".number_format($vcaja,0)."</td>";
	  								$co+=1;
	 								if($co==3){echo "</tr>";  $co=0;} 
								}
								echo "<tr><td  class='saludo1'>TOTAL SALUD</td><td class='saludo3'>".number_format($_POST[totsaludtot],2)."</td></tr>";
 								echo "<tr><td  class='saludo1'>TOTAL PENSION</td><td class='saludo3'>".number_format($_POST[totpenstot],2)."</td></tr>";
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
	 							while($row2 =mysql_fetch_row($resp2))
	  							{
								$totalrubro=0;
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
			<?php
				if($_POST[oculto]==2)
 				{
					if($_POST[cc]==''){$sqlr="select count(*) from humnomina where mes=$_POST[periodo] and vigencia=$vigusu and estado<>'N'";}
 					else{$sqlr="select count(*) from humnomina where mes=$_POST[periodo] and vigencia=$vigusu and cc='$_POST[cc]' and estado<>'N'";}
 					$respval=mysql_query($sqlr,$linkbd);
 					$rval =mysql_fetch_row($respval);
 					if($rval[0]<=0)
 					{
  						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
						$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
  						$sqlr="insert into humnomina (`fecha`, `periodo`, `mes`, `diasp`, `mesnum`, `cc`, `vigencia`, `estado`) values ('$fechaf','$_POST[tperiodo]','$_POST[periodo]','$_POST[diasperiodo]','$_POST[mesnum]','$_POST[cc]','".$vigusu."','S')";
  						if (!mysql_query($sqlr,$linkbd))
						{
	 						echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue><img src='imagenes\alert.png'>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
							//$e =mysql_error($respquery);
							echo "Ocurrió el siguiente problema:<br>";
  	 						//echo htmlentities($e['message']);
  	 						echo "<pre>";
							//echo htmlentities($e['sqltext']);
							// printf("\n%".($e['offset']+1)."s", "^");
							echo "</pre></center></td></tr></table>";
						}
  						else
  						{
	 						$id=mysql_insert_id();
	  						$lastday = mktime (0,0,0,$_POST[periodo],1,$vigusu);
	  						echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado la Liquidacion de la Nomina $id - Centro Costo:$_POST[cc] - Mes: ".strtoupper(strftime('%B',$lastday))." <img src='imagenes\confirm.png'></center></td></tr></table>";
							$cex=0;
							$cerr=0;
	 						$sqlr="insert into humcomprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($id,4,'$fechaf','CAUSACION NOMINA MES ".strtoupper(strftime('%B',$lastday))."',0,0,0,0,'1')";
							mysql_query($sqlr,$linkbd);
							//echo "<br>sq:  $sqlr";
	 						for ($x=0;$x<count($_POST[salbas]);$x++) 
	 						{
								//*****  datos nomina del empleado *****	 
		 						$sqlr="Select *from terceros_nomina where cedulanit='".$_POST[ccemp][$x]."'";
								//echo "<br>$sqlr";
		 						$respn=mysql_query($sqlr,$linkbd);
								$eps="";
								$arp="";				 
								$afp="";	
								$tipoafp="";
		 						while ($rown =mysql_fetch_row($respn)) 
								{
									$eps=$rown[3];
								 	$arp=$rown[4];				 
									$afp=$rown[5];
									if('PR'==$rown[11])
									$tipoafp="privado";				 				 
									if('PB'==$rown[11])
									$tipoafp='publico';				 				 
								}				
								//*************************************		 
								$ch=esta_en_array($_POST[empleados],$_POST[ccemp][$x]);
	 							$sqlr="insert into humnomina_det (`id_nom`, `cedulanit`, `salbas`, `diaslab`, `devendias`, `ibc`, `auxalim`, `auxtran`, `valhorex`, `totaldev`, `salud`, `saludemp`, `pension`, `pensionemp`, `fondosolid`, `retefte`, `otrasdeduc`, `totaldeduc`, `netopagar`, `estado`,vac) values ($id,'".$_POST[ccemp][$x]."',".$_POST[salbas][$x].",".$_POST[diast][$x].",".$_POST[devengado][$x].",".$_POST[ibc][$x].",".$_POST[ealim][$x].",".$_POST[etrans][$x].",0,".$_POST[totaldev][$x].",".$_POST[saludrete][$x].",".$_POST[saludemprete][$x].",".$_POST[pensionrete][$x].",".$_POST[pensionemprete][$x].",".$_POST[fondosols][$x].",0,".$_POST[otrasretenciones][$x].",".$_POST[totalrete][$x].",".$_POST[netopago][$x].",'S','$ch')";
								//	 echo "<br>c:$ch  -   det:".$sqlr;
	  							if (!mysql_query($sqlr,$linkbd)){$cerr+=1;}
								else
								{
									$cex+=1;	
									$ctacont='';
									$ctapres='';
									//*****SALARIO *******
									$sqlr="select distinct *from humvariables,humvariables_det where  humvariables.codigo=humvariables_det.codigo and humvariables_det.modulo=2 and humvariables.codigo='$_POST[tsueldo]' and humvariables_det.CC='".$_POST[centrocosto][$x]."' and humvariables_det.vigencia='$vigusu'";
									$resph=mysql_query($sqlr,$linkbd);
									while ($rowh =mysql_fetch_row($resph)) 
									{
										if($_POST[centrocosto][$x]==$rowh[9]){$ctacont=$rowh[10];$concepto=$rowh[6];}
										$cuentas=concepto_cuentas($concepto,'H',2,$_POST[centrocosto][$x]); 
										$tam=count($cuentas);
										for($cta=0;$cta<$tam;$cta++)
										{
				 							if($cuentas[$cta][1]=='N' && $cuentas[$cta][2]=='S'){$ctacont=$cuentas[$cta][0];}
				 							if($cuentas[$cta][1]=='N' && $cuentas[$cta][3]=='S'){$ctaconcepto=$cuentas[$cta][0];}
										}				
			   						}
									$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$_POST[ccemp][$x]."','".$_POST[centrocosto][$x]."','Causacion Salario Mes ".strtoupper(strftime('%B',$lastday))."','',".$_POST[devengado][$x].",0,'1','".$vigusu."')";
									mysql_query($sqlr,$linkbd);
									$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito, estado,vigencia) values ('4 $id','".$ctaconcepto."','".$_POST[ccemp][$x]."','".$_POST[centrocosto][$x]."','Causacion Salario Mes ".strtoupper(strftime('%B',$lastday))."','',0,".$_POST[devengado][$x].",'1','".$vigusu."')";
									mysql_query($sqlr,$linkbd);
									//echo "<br>$sqlr";
									//************ FIN SALARIO ********
									//****** ALIMENTACION ****
									$ctacont='';
									$ctapres='';
									if($_POST[ealim][$x]>0)
		 							{
		  								$sqlr="select distinct *from humvariables,humvariables_det where  humvariables.codigo=humvariables_det.codigo and humvariables_det.modulo=2 and humvariables.codigo='$_POST[tsubalim]' and humvariables_det.CC='".$_POST[centrocosto][$x]."'  and humvariables_det.vigencia='$vigusu'";
										$resph=mysql_query($sqlr,$linkbd);
										//echo "<br>$sqlr";
										while ($rowh =mysql_fetch_row($resph)) 
										{
											$ctacont=$rowh[10];	 
											$concepto=$rowh[6];	 
											$cuentas=concepto_cuentas($concepto,'H',2,$_POST[centrocosto][$x]); 
											$tam=count($cuentas);
											for($cta=0;$cta<$tam;$cta++)
											{
											 	if($cuentas[$cta][1]=='N' && $cuentas[$cta][2]=='S'){$ctacont=$cuentas[$cta][0];}
											 	if($cuentas[$cta][1]=='N' && $cuentas[$cta][3]=='S'){$ctaconcepto=$cuentas[$cta][0];}
											}				
											$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$_POST[ccemp][$x]."','".$_POST[centrocosto][$x]."','Causacion Aux Alimentacion Mes ".strtoupper(strftime('%B',$lastday))."','',".$_POST[ealim][$x].",0,'1','".$vigusu."')";
											mysql_query($sqlr,$linkbd);
											$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctaconcepto."','".$_POST[ccemp][$x]."','".$_POST[centrocosto][$x]."','Causacion Aux Alimentacion Mes ".strtoupper(strftime('%B',$lastday))."','',0,".$_POST[ealim][$x].",'1','".$vigusu."')";
											mysql_query($sqlr,$linkbd);   			
			   							}
		 							}		
									//*****FIN ALIMENTACION **********
									//******TRANSPORTE *****
								$ctacont='';
								$ctapres='';
								if($_POST[etrans][$x]>0)
		 						{
									$sqlr="select distinct *from humvariables,humvariables_det where  humvariables.codigo=humvariables_det.codigo and humvariables_det.modulo=2 and humvariables.codigo='$_POST[tauxtrans]' and humvariables_det.CC='".$_POST[centrocosto][$x]."'  and humvariables_det.vigencia='$vigusu'";
									$resph=mysql_query($sqlr,$linkbd);
									while ($rowh =mysql_fetch_row($resph)) 
									{
										$ctacont=$rowh[10];	 
										$concepto=$rowh[6];	 
										$cuentas=concepto_cuentas($concepto,'H',2,$_POST[centrocosto][$x]); 
										$tam=count($cuentas);
										for($cta=0;$cta<$tam;$cta++)
										{
				 							if($cuentas[$cta][1]=='N' && $cuentas[$cta][2]=='S'){$ctacont=$cuentas[$cta][0];}
				 							if($cuentas[$cta][1]=='N' && $cuentas[$cta][3]=='S'){$ctaconcepto=$cuentas[$cta][0];}
										}				
				   						$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$_POST[ccemp][$x]."','".$_POST[centrocosto][$x]."','Causacion Aux Transporte Mes ".strtoupper(strftime('%B',$lastday))."','',".$_POST[etrans][$x].",0,'1','".$vigusu."')";
										mysql_query($sqlr,$linkbd);	
   										$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctaconcepto."','".$_POST[ccemp][$x]."','".$_POST[centrocosto][$x]."','Causacion Aux Transporte Mes ".strtoupper(strftime('%B',$lastday))."','',0,".$_POST[etrans][$x].",'1','".$vigusu."')";
										mysql_query($sqlr,$linkbd);
									}
								}
								//****** FIN TRANSPORTE ****
								$sector=buscasector($_POST[ccemp][$x]);
								//********SALUD EMPLEADO *****
								$ctacont='';
								$ctapres='';
								$sqlrins="insert into  humnomina_saludpension (id_nom, tipo, empleado, tercero, cc, valor, estado,sector) values($id,'SE','".$_POST[ccemp][$x]."','$eps','".$_POST[centrocosto][$x]."',".$_POST[saludrete][$x].",'S','')";
								mysql_query($sqlrins,$linkbd);
								$sqlr="select distinct *from humparafiscales_det where  humparafiscales_det.codigo='$_POST[tsaludemp]' and humparafiscales_det.CC='".$_POST[centrocosto][$x]."'  and humparafiscales_det.vigencia='$vigusu'";
								$resph=mysql_query($sqlr,$linkbd);
								//echo "<br>$sqlr";
								while ($rowh =mysql_fetch_row($resph)) 
								{
				 					$concepto=$rowh[8];	 	
									$cuentas=concepto_cuentas($concepto,'H',2,$_POST[centrocosto][$x]); 
									$tam=count($cuentas);
									for($cta=0;$cta<$tam;$cta++)
									{
										$ctacont=$cuentas[$cta][0];
				 						if($cuentas[$cta][1]=='N' && $cuentas[$cta][2]=='S')
				 						{							
											$debito=$_POST[saludrete][$x];
											$credito=0;
											$tercero=$_POST[ccemp][$x];
											$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$tercero."','".$_POST[centrocosto][$x]."','APORTE SALUD EMPLEADO Mes ".strtoupper(strftime('%B',$lastday))."','',".$debito.",".$credito.",'1','".$vigusu."')";
											mysql_query($sqlr,$linkbd);
											$ctasalud=$ctacont;
				  						}
				  						if($cuentas[$cta][1]=='N' && $cuentas[$cta][3]=='S')
				  						{			
											$credito=$_POST[saludrete][$x];
											$debito=0;
											$tercero=$eps;
											$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$tercero."','".$_POST[centrocosto][$x]."','APORTE SALUD EMPLEADO Mes ".strtoupper(strftime('%B',$lastday))."','',".$debito.",".$credito.",'1','".$vigusu."')";
											mysql_query($sqlr,$linkbd);
											$ctasalud=$ctacont;				  
				  						}
									}
			   					}				
								//******** FIN SALUD EMPLEADO ****
								//********PENSION EMPLEADO *****
								$ctacont='';
								$ctapres='';
								$sqlrins="insert into  humnomina_saludpension (id_nom, tipo, empleado, tercero, cc, valor, estado,sector) values($id,'PE',".$_POST[ccemp][$x].",'$afp','".$_POST[centrocosto][$x]."',".$_POST[pensionrete][$x].",'S','$sector')";
		mysql_query($sqlrins,$linkbd);		
								$sqlr="select distinct *from humparafiscales_det where  humparafiscales_det.codigo='$_POST[tpensionemp]' and humparafiscales_det.CC='".$_POST[centrocosto][$x]."' and humparafiscales_det.vigencia='$vigusu'";
								$resph=mysql_query($sqlr,$linkbd);
								//	echo "<br>$sqlr";
								while ($rowh =mysql_fetch_row($resph)) 
								{
									$concepto=$rowh[8];	 		
									$cuentas=concepto_cuentas($concepto,'H',2,$_POST[centrocosto][$x]); 
									$tam=count($cuentas);
									for($cta=0;$cta<$tam;$cta++)
									{
				 						$ctacont=$cuentas[$cta][0];
				 						if($cuentas[$cta][1]=='N' && $cuentas[$cta][2]=='S')
				  						{							
											$debito=$_POST[pensionrete][$x];
											$credito=0;
											$tercero=$_POST[ccemp][$x];
											$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$tercero."','".$_POST[centrocosto][$x]."','APORTE PENSION EMPLEADO Mes ".strtoupper(strftime('%B',$lastday))."','',".$debito.",".$credito.",'1','".$vigusu."')";
											mysql_query($sqlr,$linkbd);
											$ctasalud=$ctacont;
				  						}
				 						if($cuentas[$cta][1]=='N' && $cuentas[$cta][3]=='S')
				  						{			
											$credito=$_POST[pensionrete][$x];
											$debito=0;
											$tercero=$afp;
											$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$tercero."','".$_POST[centrocosto][$x]."','APORTE PENSION EMPLEADO Mes ".strtoupper(strftime('%B',$lastday))."','',".$debito.",".$credito.",'1','".$vigusu."')";
											mysql_query($sqlr,$linkbd);
											$ctasalud=$ctacont;				  
				  						}
			   						}				
								}
								//******** FIN PENSION EMPLEADO ****
								//********FONDO SOLIDARIDAD EMPLEADO *****
								$ctacont='';
								$ctapres='';
								if($_POST[fondosols][$x]>0)
		 						{
		  							$sqlrins="insert into  humnomina_saludpension (id_nom, tipo, empleado, tercero, cc, valor, estado,sector) values($id,'FS','".$_POST[ccemp][$x]."','$afp','".$_POST[centrocosto][$x]."',".$_POST[fondosols][$x].",'S','$sector')";
									mysql_query($sqlrins,$linkbd);
		  							$sqlr="select distinct *from humparafiscales_det where  humparafiscales_det.codigo='$_POST[tpensionemp]' and humparafiscales_det.CC='".$_POST[centrocosto][$x]."' and humparafiscales_det.vigencia='$vigusu' and  humparafiscales_det.sector='$tipoafp'";
									$resph=mysql_query($sqlr,$linkbd);
									while ($rowh =mysql_fetch_row($resph)) 
									{
										$concepto=$rowh[8];	 		
										$cuentas=concepto_cuentas($concepto,'H',2,$_POST[centrocosto][$x]); 
										$tam=count($cuentas);
										for($cta=0;$cta<$tam;$cta++)
										{
				 							$ctacont=$cuentas[$cta][0];
				  							if($cuentas[$cta][1]=='N' && $cuentas[$cta][2]=='S')
				  							{									
												$debito=$_POST[fondosols][$x];
												$credito=0;
												$tercero=$_POST[ccemp][$x];
												$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$tercero."','".$_POST[centrocosto][$x]."','APORTE FONDO SOLIDARIDAD EMPLEADO Mes ".strtoupper(strftime('%B',$lastday))."','',".$debito.",".$credito.",'1','".$vigusu."')";
												mysql_query($sqlr,$linkbd);
												$ctasalud=$ctacont;
				 							}
				  							if($cuentas[$cta][1]=='N' && $cuentas[$cta][3]=='S')
				  							{			
												$credito=$_POST[fondosols][$x];
												$debito=0;
												$tercero=$afp;
												$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$tercero."','".$_POST[centrocosto][$x]."','APORTE FONDO SOLIDARIDAD EMPLEADO Mes ".strtoupper(strftime('%B',$lastday))."','',".$debito.",".$credito.",'1','".$vigusu."')";
												mysql_query($sqlr,$linkbd);
												$ctasalud=$ctacont;				  
				  							}
			  							}
									}
								}
								//******** FIN FONDO SOLIDARIDAD EMPLEADO ****		
								//********OTROS DESCUENTOS EMPLEADO *****
								$ctacont='';
								$ctapres='';
								if($_POST[otrasretenciones][$x]>0)
		 						{
									$sqlr="select *from humretenempleados where humretenempleados.empleado='".$_POST[ccemp][$x]."' and humretenempleados.sncuotas>0 and habilitado='H' and estado='S'";		
									$respli=mysql_query($sqlr,$linkbd);
									while ($rowh=mysql_fetch_row($respli)) 
									{
										$valorlibranza=$rowh[8];
										$sqlr="select distinct *from humvariablesretenciones,humvariablesretenciones_det where humvariablesretenciones.codigo='".$rowh[2]."' and humvariablesretenciones.codigo=humvariablesretenciones_det.codigo";
										$respr=mysql_query($sqlr,$linkbd);
										while ($rowr=mysql_fetch_row($respr)) 
										{						
				 					 		$ctacont=$rowr[8];	 
				 							if('S'==$rowr[9])
				  							{
												$debito=$valorlibranza;
												$credito=0;
				 								$sqlret="INSERT INTO  humnominaretenemp (id_nom, id, cedulanit, fecha, descripcion, valor, ncta, estado) values($id,$rowh[0],'$rowh[4]','$fechaf','$rowh[1]',$debito,".($rowh[6]-$rowh[7]+1).",'S')";
				 								mysql_query($sqlret,$linkbd);
				  							}
				 							if('S'==$rowr[10]){$credito=$valorlibranza;$debito=0;}				 				 
											$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$rowr[2]."','".$_POST[centrocosto][$x]."','DESCUENTO ".$rowr[1]." Mes ".strtoupper(strftime('%B',$lastday))."','',".$debito.",".$credito.",'1','".$vigusu."')";
											mysql_query($sqlr,$linkbd);
										}
									}
			  					}				
								//******** FIN otros descuentos EMPLEADO ****
								//****OTRAS RETENCIONES ******		
								$sqlr="UPDATE humretenempleados SET SNCUOTAS=SNCUOTAS-1 where estado='S' and empleado='".$_POST[ccemp][$x]."' and sncuotas>0";				
								$resp2 = mysql_query($sqlr,$linkbd);
								$row2 =mysql_fetch_row($resp2);
								$sqlr="UPDATE humretenempleados SET estado='P' where estado='S' and empleado='".$_POST[ccemp][$x]."'  and sncuotas<=0";
								$resp2 = mysql_query($sqlr,$linkbd);
								$row2 =mysql_fetch_row($resp2);
								//*****************************
								//******** SALUD EMPLEADOR *******
								$ctacont='';
								$ctapres='';	
								$sqlrins="insert into  humnomina_saludpension (id_nom, tipo, empleado, tercero, cc, valor, estado) values($id,'SR','".$_POST[ccemp][$x]."','$eps','".$_POST[centrocosto][$x]."',".$_POST[saludemprete][$x].",'S')";
		mysql_query($sqlrins,$linkbd);
								$sqlr="select distinct *from humparafiscales_det where  humparafiscales_det.codigo='$_POST[tsaludemr]' and humparafiscales_det.CC='".$_POST[centrocosto][$x]."' and humparafiscales_det.vigencia='$vigusu' ";
								$resph=mysql_query($sqlr,$linkbd);
								while ($rowh =mysql_fetch_row($resph)) 
								{
									$concepto=$rowh[8];	 	
				 					$cuentas=concepto_cuentas($concepto,'H',2,$_POST[centrocosto][$x]); 
									$tam=count($cuentas);
									for($cta=0;$cta<$tam;$cta++)
									{
				 						$ctacont=$cuentas[$cta][0];
				  						if($cuentas[$cta][1]=='N' && $cuentas[$cta][2]=='S')
				  						{									
											$debito=$_POST[saludemprete][$x];
											$credito=0;
											$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$eps."','".$_POST[centrocosto][$x]."','APORTE SALUD EMPLEADOR Mes ".strtoupper(strftime('%B',$lastday))."','',".$debito.",".$credito.",'1','".$vigusu."')";
											mysql_query($sqlr,$linkbd);
				  						}							 				 
				 						if($cuentas[$cta][1]=='N' && $cuentas[$cta][3]=='S')
				  						{
											$credito=$_POST[saludemprete][$x];
											$debito=0;
											$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$eps."','".$_POST[centrocosto][$x]."','APORTE SALUD EMPLEADOR Mes ".strtoupper(strftime('%B',$lastday))."','',".$debito.",".$credito.",'1','".$vigusu."')";
											mysql_query($sqlr,$linkbd);									
				   						}	 		  
				 					}
								}
			 					//**************FIN SALUD EMPLEADOR		
								//******** PENSIONES EMPLEADOR *******
								$ctacont='';
								$ctapres='';		
								$sqlrins="insert into  humnomina_saludpension (id_nom, tipo, empleado, tercero, cc, valor, estado,sector) values($id,'PR','".$_POST[ccemp][$x]."','$afp','".$_POST[centrocosto][$x]."',".$_POST[pensionemprete][$x].",'S','$sector')";
								mysql_query($sqlrins,$linkbd);
								$sqlr="select distinct *from humparafiscales_det where  humparafiscales_det.codigo='$_POST[tpensionemr]' and humparafiscales_det.CC='".$_POST[centrocosto][$x]."' and humparafiscales_det.vigencia='$vigusu'  and sector='".$tipoafp."'  and  humparafiscales_det.sector='$tipoafp'";
								$resph=mysql_query($sqlr,$linkbd);
								while ($rowh =mysql_fetch_row($resph)) 
								{
				   					$concepto=$rowh[8];	
									$cuentas=concepto_cuentas($concepto,'H',2,$_POST[centrocosto][$x]); 
									$tam=count($cuentas);
									for($cta=0;$cta<$tam;$cta++)
									{
										$ctacont=$cuentas[$cta][0];
				 	 					if($cuentas[$cta][1]=='N' && $cuentas[$cta][2]=='S')
					  					{				
											$debito=$_POST[pensionemprete][$x];
											$credito=0;				  	 
											$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$afp."','".$_POST[centrocosto][$x]."','APORTE PENSIONES EMPLEADOR Mes ".strtoupper(strftime('%B',$lastday))."','',".$debito.",".$credito.",'1','".$vigusu."')";
											mysql_query($sqlr,$linkbd);
										}				
	 									if($cuentas[$cta][1]=='N' && $cuentas[$cta][3]=='S')
						 				{			 				 
											$credito=$_POST[pensionemprete][$x];
										 	$debito=0;
										 	$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$afp."','".$_POST[centrocosto][$x]."','APORTE PENSIONES EMPLEADOR Mes ".strtoupper(strftime('%B',$lastday))."','',".$debito.",".$credito.",'1','".$vigusu."')";
						 					mysql_query($sqlr,$linkbd);	
						 				}
									}
				 				}
			 					//**************FIN PENSION EMPLEADOR					 
			 					//******ARP ******			 
								$ctacont='';
								$ctapres='';		
								$sqlr="select distinct *from humparafiscales_det inner join humparafiscales on humparafiscales_det.codigo=humparafiscales.codigo  where  humparafiscales_det.codigo='$_POST[tarp]' and humparafiscales_det.CC='".$_POST[centrocosto][$x]."' and humparafiscales_det.vigencia='$vigusu'";
								$resph=mysql_query($sqlr,$linkbd);		
								while ($rowh =mysql_fetch_row($resph)) 
								{								 				  
				   					$concepto=$rowh[8];	
				   					$cuentas=concepto_cuentas($concepto,'H',2,$_POST[centrocosto][$x]); 
									$tam=count($cuentas);
									for($cta=0;$cta<$tam;$cta++)
									{
					 					$ctacont=$cuentas[$cta][0];
				 	 					if($cuentas[$cta][1]=='N' && $cuentas[$cta][2]=='S')
					  					{			
											$debito=$_POST[arpemp][$x];
											$credito=0;				  	  							 				 
											$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$arp."','".$_POST[centrocosto][$x]."','APORTE ARP EMPLEADOR Mes ".strtoupper(strftime('%B',$lastday))."','',".$debito.",".$credito.",'1','".$vigusu."')";
											mysql_query($sqlr,$linkbd);
										}	
					 					if($cuentas[$cta][1]=='N' && $cuentas[$cta][3]=='S')
					  					{
											$credito=$_POST[arpemp][$x];
											$debito=0;
											$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$arp."','".$_POST[centrocosto][$x]."','APORTE ARP EMPLEADOR Mes ".strtoupper(strftime('%B',$lastday))."','',".$debito.",'".$credito."','1','".$vigusu."')";
											mysql_query($sqlr,$linkbd);		
					  					}
				 					}
			   					}
			 					//***** FIN ARP *****	
			 					//********CESANTIAS*****
								/*$ctacont='';
		$ctapres='';
			$sqlr="select distinct *from humparafiscales_det inner join humparafiscales on humparafiscales_det.codigo=humparafiscales.codigo where  humparafiscales_det.codigo='11' and humparafiscales_det.CC='".$_POST[centrocosto][$x]."'";
		$resph=mysql_query($sqlr,$linkbd);
		//echo "<br>$sqlr";
		while ($rowh =mysql_fetch_row($resph)) 
				{
				if($_POST[centrocosto][$x]==$rowh[2])
				 {
				   $ctacont=$rowh[3];	 
				   $ctapres=$rowh[6];	 
				   $cesantias=round($_POST[totaldev][$x]*($rowh[13]/100),0);
				 }
				 if('S'==$rowh[4])
				  {					
					$debito=round($_POST[totaldev][$x]*($rowh[13]/100),0);
					$credito=0;
				  }
				 if('S'==$rowh[5])
				   {
					$credito=round($_POST[totaldev][$x]*($rowh[13]/100),0);
					$debito=0;
					}				 				 
				$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$_POST[ccemp][$x]."','".$_POST[centrocosto][$x]."','PROVISION CESANTIAS EMPLEADO Mes ".strtoupper(strftime('%B',$lastday))."','',".$debito.",".$credito.",'1','".$vigusu."')";
				mysql_query($sqlr,$linkbd);
				//echo "<br>$sqlr";
			$ctapension=$ctacont;
				}	*/		 		
								//******** FIN CESANTIAS EMPLEADO ****	
								//********INTERESES CESANTIAS*****
		/*$ctacont='';
		$ctapres='';
			$sqlr="select distinct *from humparafiscales_det inner join humparafiscales on humparafiscales_det.codigo=humparafiscales.codigo where  humparafiscales_det.codigo='12' and humparafiscales_det.CC='".$_POST[centrocosto][$x]."'";
		$resph=mysql_query($sqlr,$linkbd);
		//echo "<br>$sqlr";
		while ($rowh =mysql_fetch_row($resph)) 
				{
				if($_POST[centrocosto][$x]==$rowh[2])
				 {
				   $ctacont=$rowh[3];	 
				   $ctapres=$rowh[6];	 
				 }
				 if('S'==$rowh[4])
				  {					
					$debito=round($cesantias*($rowh[13]/100)*$_POST[diast][$x]/360,0);
					$credito=0;
				  }
				 if('S'==$rowh[5])
				   {
					$credito=round($cesantias*($rowh[13]/100)*$_POST[diast][$x]/360,0);
					$debito=0;
					}				 				 
				$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$_POST[ccemp][$x]."','".$_POST[centrocosto][$x]."','PROVISION CESANTIAS EMPLEADO Mes ".strtoupper(strftime('%B',$lastday))."','',".$debito.",".$credito.",'1','".$vigusu."')";
				mysql_query($sqlr,$linkbd);
			//echo "<br>$sqlr";
			$ctapension=$ctacont;
				}*/			 		
								//******** FIN INTERESES CESANTIAS EMPLEADO ****	
			 					//******************
							}//**FIN DEL FOR DE EMPLEADOS
	 					}
	 	 				//***********PARAFISCALES ******
		 				//****ARP DETALLE PARAFISCALES
			 			//CAJAS DE COMPENSACION
	 					$sqlr="select *from centrocosto where estado='S'";
						$rescc=mysql_query($sqlr,$linkbd);
	 					while ($rowcc =mysql_fetch_row($rescc)) 
	 					{
							$ctacont='';
							$ctapres='';		
		  					if($pf[$_POST[tcajacomp]][$rowcc[0]]>0)
		   					{			
								$sqlr="select distinct *from humparafiscales_det  inner join humparafiscales on humparafiscales_det.codigo=humparafiscales.codigo where  humparafiscales_det.codigo='$_POST[tcajacomp]' and humparafiscales_det.CC='$rowcc[0]' and humparafiscales_det.vigencia='$vigusu'";
								$resph=mysql_query($sqlr,$linkbd);		
								while ($rowh =mysql_fetch_row($resph)) 
								{
				   					$concepto=$rowh[8];	
   				    				$cuentas=concepto_cuentas($concepto,'H',2,$rowcc[0]); 
									$tam=count($cuentas);
									for($cta=0;$cta<$tam;$cta++)
									{
										$ctacont=$cuentas[$cta][0];
				 	 					if($cuentas[$cta][1]=='N' && $cuentas[$cta][2]=='S')
					  					{			
											$debito=$pf[$_POST[tcajacomp]][$rowcc[0]];
											$credito=0;				  	 							 				 
											$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$_POST[cajacomp]."','".$rowcc[0]."','APORTE CAJA COMPENSACION Mes ".strtoupper(strftime('%B',$lastday))."','',".$debito.",".$credito.",'1','".$vigusu."')";
											mysql_query($sqlr,$linkbd);
					  					}
					  					if($cuentas[$cta][1]=='N' && $cuentas[$cta][3]=='S')
					  					{
											$credito=$pf[$_POST[tcajacomp]][$rowcc[0]];
											$debito=0;				  	 							 				 
											$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$_POST[cajacomp]."','".$rowcc[0]."','APORTE CAJA COMPENSACION Mes ".strtoupper(strftime('%B',$lastday))."','',".$debito.",".$credito.",'1','".$vigusu."')";
											mysql_query($sqlr,$linkbd);	
					  					}						
									}
									//***nomina parafiscales
									$sqlr="insert into humnomina_parafiscales (id_nom, id_parafiscal, porcentaje, valor, cc,estado) values ($id,'$_POST[tcajacomp]',$rowh[14],".$pf[$_POST[tcajacomp]][$rowcc[0]].",'$rowcc[0]','S')";			
									mysql_query($sqlr,$linkbd);											
				   				}
							}
						}
						//*************FIN CAJAS DE COMP
			 			//ICBF
		 				$sqlr="select *from centrocosto where estado='S'";
	 					$rescc=mysql_query($sqlr,$linkbd);
	 					while ($rowcc =mysql_fetch_row($rescc)) 
	 					{
							$ctacont='';
							$ctapres='';		
		  					if($pf[$_POST[ticbf]][$rowcc[0]]>0)
		   					{			
								$sqlr="select distinct *from humparafiscales_det  inner join humparafiscales on humparafiscales_det.codigo=humparafiscales.codigo where  humparafiscales_det.codigo='$_POST[ticbf]' and humparafiscales_det.CC='$rowcc[0]' and humparafiscales_det.vigencia='$vigusu'";
								$resph=mysql_query($sqlr,$linkbd);		
								while ($rowh =mysql_fetch_row($resph)) 
								{							 
									$concepto=$rowh[8];	
								   	$cuentas=concepto_cuentas($concepto,'H',2,$rowcc[0]); 
									$tam=count($cuentas);
									for($cta=0;$cta<$tam;$cta++)
									{
					 					$ctacont=$cuentas[$cta][0];
				 	 					if($cuentas[$cta][1]=='N' && $cuentas[$cta][2]=='S')
					  					{			
											$debito=$pf[$_POST[ticbf]][$rowcc[0]];
											$credito=0;				  	 						 				 
											$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$_POST[icbf]."','".$rowcc[0]."','APORTE ICBF Mes ".strtoupper(strftime('%B',$lastday))."','',".$debito.",$credito,'1','".$vigusu."')";
											mysql_query($sqlr,$linkbd);
										}
					 					if($cuentas[$cta][1]=='N' && $cuentas[$cta][3]=='S')
					  					{
											$debito=$pf[$_POST[ticbf]][$rowcc[0]];
											$credito=0;				  	 						 				 
											$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$_POST[icbf]."','".$rowcc[0]."','APORTE ICBF Mes ".strtoupper(strftime('%B',$lastday))."','',0,".$debito.",'1','".$vigusu."')";
											mysql_query($sqlr,$linkbd);	
					  					}
									}
									//***nomina parafiscales
									$sqlr="insert into humnomina_parafiscales (id_nom, id_parafiscal, porcentaje, valor, cc,estado) values ($id,'$_POST[ticbf]',$rowh[14],".$pf[$_POST[ticbf]][$rowcc[0]].",'$rowcc[0]','S')";			
									mysql_query($sqlr,$linkbd);															   
								}		  
		   					}
	 					}
						//*************FIN ICBF
 						//SENA
		 				$sqlr="select *from centrocosto where estado='S'";
	 					$rescc=mysql_query($sqlr,$linkbd);
	 					while ($rowcc =mysql_fetch_row($rescc)) 
	 					{
							$ctacont='';
							$ctapres='';		
		  					if($pf[$_POST[tsena]][$rowcc[0]]>0)
		   					{			
								$sqlr="select distinct *from humparafiscales_det inner join humparafiscales on humparafiscales_det.codigo=humparafiscales.codigo where  humparafiscales_det.codigo='$_POST[tsena]' and humparafiscales_det.CC='$rowcc[0]' and humparafiscales_det.vigencia='$vigusu'";
								$resph=mysql_query($sqlr,$linkbd);		
								while ($rowh =mysql_fetch_row($resph)) 
								{
				   					$concepto=$rowh[8];	
				   					$cuentas=concepto_cuentas($concepto,'H',2,$rowcc[0]); 
									$tam=count($cuentas);
									for($cta=0;$cta<$tam;$cta++)
									{
					 					$ctacont=$cuentas[$cta][0];
				 	 					if($cuentas[$cta][1]=='N' && $cuentas[$cta][2]=='S')
					  					{		
											$debito=$pf[$_POST[tsena]][$rowcc[0]];
											$credito=0;
											$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$_POST[sena]."','".$rowcc[0]."','APORTE SENA Mes ".strtoupper(strftime('%B',$lastday))."','',".$debito.",0,'1','".$vigusu."')";
											mysql_query($sqlr,$linkbd);
					  					}
  					 					if($cuentas[$cta][1]=='N' && $cuentas[$cta][3]=='S')
					  					{
											$debito=$pf[$_POST[tsena]][$rowcc[0]];
											$credito=0;
											$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$_POST[sena]."','".$rowcc[0]."','APORTE SENA Mes ".strtoupper(strftime('%B',$lastday))."','',0,".$debito.",'1','".$vigusu."')";
											mysql_query($sqlr,$linkbd);		
					 					}
				   					}
									//***nomina parafiscales
									$sqlr="insert into humnomina_parafiscales (id_nom, id_parafiscal, porcentaje, valor, cc, estado) values ($id,'$_POST[tsena]',$rowh[14],$debito,'$rowcc[0]', 'S')";			
									mysql_query($sqlr,$linkbd);																
								}
		   					}
	 					}
						//*************FIN SENA		
						//ITI
			 			$sqlr="select *from centrocosto where estado='S'";
	 					$rescc=mysql_query($sqlr,$linkbd);
						//	 echo "<br>$sqlr";
	 					while ($rowcc =mysql_fetch_row($rescc)) 
	 					{
						$ctacont='';
						$ctapres='';		
		  				if($pf[$_POST[titi]][$rowcc[0]]>0)
		   				{			
							$sqlr="select distinct *from humparafiscales_det inner join humparafiscales on humparafiscales_det.codigo=humparafiscales.codigo where  humparafiscales_det.codigo='$_POST[titi]' and humparafiscales_det.CC='$rowcc[0]' and humparafiscales_det.vigencia='$vigusu'";
							$resph=mysql_query($sqlr,$linkbd);		
							while ($rowh =mysql_fetch_row($resph)) 
							{
				   				$concepto=$rowh[8];	
   				   				$cuentas=concepto_cuentas($concepto,'H',2,$rowcc[0]); 
								$tam=count($cuentas);
								for($cta=0;$cta<$tam;$cta++)
								{
					 				$ctacont=$cuentas[$cta][0];
				 					if($cuentas[$cta][1]=='N' && $cuentas[$cta][2]=='S')
					  				{	
										$debito=$pf[$_POST[titi]][$rowcc[0]];
										$credito=0;
										$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$_POST[iti]."','".$rowcc[0]."','APORTE INST TECNICOS Mes ".strtoupper(strftime('%B',$lastday))."','',".$debito.",0,'1','".$vigusu."')";
										mysql_query($sqlr,$linkbd);
					  				}
					 				if($cuentas[$cta][1]=='N' && $cuentas[$cta][3]=='S')
					  				{
										$debito=$pf[$_POST[titi]][$rowcc[0]];
										$credito=0;						  
										$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$_POST[iti]."','".$rowcc[0]."','APORTE INST TECNICOS Mes ".strtoupper(strftime('%B',$lastday))."','',0,".$debito.",'1','".$vigusu."')";
										mysql_query($sqlr,$linkbd);											
					   				}
								}
		   						//***nomina parafiscales
								$sqlr="insert into humnomina_parafiscales (id_nom, id_parafiscal, porcentaje, valor, cc, estado) values ($id,'$_POST[titi]',$rowh[14],$debito,'$rowcc[0]', 'S')";			
								mysql_query($sqlr,$linkbd);										
							}
		   				}
	 				}
					//*************FIN ITI		
					//ESAP********
	 				$sqlr="select *from centrocosto where estado='S'";
	 				$rescc=mysql_query($sqlr,$linkbd);
	 				while ($rowcc =mysql_fetch_row($rescc)) 
	 				{
						$ctacont='';
						$ctapres='';
		  				if($pf[$_POST[tesap]][$rowcc[0]]>0)
		   				{			
							$sqlr="select distinct *from humparafiscales_det inner join humparafiscales on humparafiscales_det.codigo=humparafiscales.codigo where  humparafiscales_det.codigo='$_POST[tesap]' and humparafiscales_det.CC='$rowcc[0]' and humparafiscales_det.vigencia='$vigusu'";
							$resph=mysql_query($sqlr,$linkbd);		
							while ($rowh =mysql_fetch_row($resph)) 
							{
				   				$concepto=$rowh[8];	
				   				$cuentas=concepto_cuentas($concepto,'H',2,$rowcc[0]); 
								$tam=count($cuentas);
								for($cta=0;$cta<$tam;$cta++)
								{
					 				$ctacont=$cuentas[$cta][0];
				 	 				if($cuentas[$cta][1]=='N' && $cuentas[$cta][2]=='S')
					  				{	
										$debito=$pf[$_POST[tesap]][$rowcc[0]];
										$credito=0;
										$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$_POST[esap]."','".$rowcc[0]."','APORTE ESAP Mes ".strtoupper(strftime('%B',$lastday))."','',".$debito.",0,'1','".$vigusu."')";
										mysql_query($sqlr,$linkbd);
					  				}
  									if($cuentas[$cta][1]=='N' && $cuentas[$cta][3]=='S')
					 				{
										$debito=$pf[$_POST[tesap]][$rowcc[0]];
										$credito=0;
										$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito, estado,vigencia) values ('4 $id','".$ctacont."','".$_POST[esap]."','".$rowcc[0]."','APORTE ESAP Mes ".strtoupper(strftime('%B',$lastday))."','',0,".$debito.",'1','".$vigusu."')";
										mysql_query($sqlr,$linkbd);	
										//***nomina parafiscales
					  				}						
				   				}
				   				$sqlr="insert into humnomina_parafiscales (id_nom, id_parafiscal, porcentaje, valor, cc,estado) values ($id,'$_POST[tesap]',$rowh[14],$debito,'$rowcc[0]','S')";			
								mysql_query($sqlr,$linkbd);								
							}
		   				}
	 				}
					//*************FIN ESAP	
					//ARP********
	 				$sqlr="select *from centrocosto where estado='S'";
	 				$rescc=mysql_query($sqlr,$linkbd);
	 				while ($rowcc =mysql_fetch_row($rescc)) 
	 				{
						$ctacont='';
						$ctapres='';
		 			 	if($pf[$_POST[tarp]][$rowcc[0]]>0)
		  				{			
							$sqlr="select distinct *from humparafiscales_det inner join humparafiscales on humparafiscales_det.codigo=humparafiscales.codigo where  humparafiscales_det.codigo='$_POST[tarp]' and humparafiscales_det.CC='$rowcc[0]' and humparafiscales_det.vigencia='$vigusu'";
							$resph=mysql_query($sqlr,$linkbd);		
							while ($rowh =mysql_fetch_row($resph)) 
							{
								if($rowcc[0]==$rowh[2])
				 				{				 
				  					$ctacont=$rowh[3];	 
				   					$ctapres=$rowh[6];					    
									$debito=$pf[$_POST[tarp]][$rowcc[0]];
									$credito=0;
									//***nomina parafiscales
									$sqlr="insert into humnomina_parafiscales (id_nom, id_parafiscal, porcentaje, valor, cc,estado) values ($id,'$_POST[tarp]',$rowh[14],$debito,'$rowcc[0]','S')";			
									mysql_query($sqlr,$linkbd);													
				   				}
							}
		   				}
					}
					//*************FIN arp	
	  				echo "<table class='inicio'><tr><td class='saludo1'><center>Registros Exitosos:$cex   -   Registros Erroneos: $cerr<img src='imagenes\confirm.png'></center></td></tr></table>"; 
					//***** crea la solicitud de cdp *************
					foreach($pfcp as $k => $valrubros)
		 			{
  						$ncta=existecuentain($k);
						$sqlrp="insert into humnom_presupuestal (id_nom,cuenta,valor,estado) values ($id,$k,$valrubros,'S')";
  						mysql_query($sqlrp,$linkbd);	
					}
				}
  			}	
  			else
  			{
  				 echo "<table class='inicio'><tr><td class='saludo1'><center>LIQUIDACION DE NOMINA EXISTENTE PARA ESTOS PARAMETROS<img src='imagenes\alert.png'></center></td></tr></table>";   
   				?><script>alert("No se puede Generar: LIQUIDACION DE NOMINA EXISTENTE")</script><?php
  			}
		}
		?>
</form>
</body>
</html>