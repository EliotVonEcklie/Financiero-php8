<?php //V 1000 12/12/16 ?> 
<!--V 1.0 24/02/2015-->
<?php
	require"comun.inc";
	require"funciones.inc";
	require"validaciones.inc";
	sesion();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
    	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Spid - Gestion Humana</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <link href="css/tabs.css" rel="stylesheet" type="text/css"/>
        <script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
		<script>
			function guardar()
			{
				if (document.form2.tperiodo.value!='-1' && document.form2.periodo.value!='-1')
  				{despliegamodalm('visible','4','Esta Seguro de Guardar','1')}
  				else{despliegamodalm('visible','2','Faltan datos para completar el registro');}
			}
			function validar(formulario)
			{
				document.form2.cperiodo.value='2';
				document.form2.action="hum-liquidarnomina.php";
				document.form2.submit();
			}
	
			function marcarex(indice,posicion)
			{
				vvigencias=document.getElementsByName('liqempleados[]');
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
			function checktodos()
			{
 				vvigencias=document.getElementsByName('empleados[]');
 				for (var i=0;i < vvigencias.length;i++) 
 				{ 
					if (document.getElementById("todos").checked == true) 
					{
	 					vvigencias.item(i).checked = true;
 	 					document.getElementById("todos").value=1;	
						vvigencias.item(i).style.backgroundColor='#3399bb'; 
					}
					else
					{
						vvigencias.item(i).checked = false;
    					document.getElementById("todos").value=0;
						vvigencias.item(i).style.backgroundColor='#ffffff';
					}
 				}	
 				resumar() ;
			}
			
			function checktodosex()
			{
 				vvigencias=document.getElementsByName('liqempleados[]');
 				for (var i=0;i < vvigencias.length;i++) 
 				{ 
					if (document.getElementById("todosex").checked == true) 
					{
	 					vvigencias.item(i).checked = true;
 	 					document.getElementById("todosex").value=1;	
						vvigencias.item(i).style.backgroundColor='#3399bb'; 
					}
					else
					{
						vvigencias.item(i).checked = false;
    					document.getElementById("todosex").value=0;
						vvigencias.item(i).style.backgroundColor='#ffffff';
					}
 				}	
 				resumar() ;
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
				document.form2.action="pdfpeticionrp.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
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
			function funcionmensaje(){
				document.location.href = "hum-liquidarnominamirar.php?idnomi="+document.form2.idcomp.value;
			}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	
						document.form2.oculto.value=2;
						document.form2.cperiodo.value=2;
						document.form2.submit();
					break;
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
                <td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='hum-liquidarnomina.php'" class="mgbt"/><img src="imagenes/guarda.png" title="Guardar" onClick="guardar()" class="mgbt"/><img class="mgbt" src="imagenes/busca.png" title="Buscar" onClick="location.href='hum-liquidarnominabuscar.php'"/><img class="mgbt" src="imagenes/nv.png" title="Nueva Ventana" onClick="mypop=window.open('hum-principal.php','','');mypop.focus();"/><img src="imagenes/print.png" title="Imprimir" onClick="pdf()" class="mgbt"/><img src="imagenes/excel.png" title="Excel" onClick='excell()' class="mgbt"/></td>
            </tr>	
  		</table>	
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
            <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
            </IFRAME>
         </div>
        </div>
 		<form name="form2" method="post" action="">
			<?php
				$salrioaux="S";
				$tnov=array();
				$sqlr="Select * from dominios where tipo='S' and nombre_dominio LIKE 'LICENCIAS' ";
				$res=mysql_query($sqlr,$linkbd);
				$consec=0;
				while($r=mysql_fetch_row($res)){$tnov["$r[1]"]=$r[2];}
				if($_POST[anticipo]=='S'){$chkant=' checked ';}
				$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
				$_POST[vigencia]=$vigusu;
				if($_POST[oculto]=="")
				{
					$_POST[tabgroup1]=1;
	 				$consec=selconsecutivo('humnomina','id_nom');
								
						 
						  
									   
	 				$_POST[idcomp]=$consec;		 
		 			$fec=date("d/m/Y");
		 			$_POST[fecha]=$fec; 
		 			//**** carga parametros de nomina
					$sqlr="select *from humparametrosliquida";	
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
//					echo $sqlr;	 		
					//*** fin parametros de nomina *******					
				}
		 		$pf[]=array();
		 		$pfcp=array();	
				$ccpar[]=array();
				switch($_POST[tabgroup1])
				{
					case 1:	$check1='checked';break;
					case 2:	$check2='checked';break;
					case 3:	$check3='checked';break;
					case 4:	$check4='checked';break;
					case 5:	$check5='checked';break;
					case 6:	$check6='checked';break;
				}		 
			?>
			<table  class="inicio" align="center" >
                <tr>
                    <td class="titulos" colspan="8">:: Liquidar Nomina</td>
                    <td class="cerrar" style="width:7%" onClick="location.href='hum-principal.php'">Cerrar</td>
      			</tr>
      			<tr>
                	<td class="saludo1">No Liquidaci&oacute;n</td>
                    <td>
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
                        <input type="text" id="idcomp" name="idcomp"  size="5" value="<?php echo $_POST[idcomp]?>" readonly>
                    </td>
                   	<td class="saludo1">Fecha</td>
                    <td><input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10" size="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY">&nbsp;<a href="#" onClick="displayCalendarFor('fc_1198971545');" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px;"></a></td>
                    <td class="saludo1">Vigencia</td> 
                    <td><input name="vigencia" type="text" size="5" value="<?php echo $_POST[vigencia]?>" readonly></td>
                    <td class="saludo1">&nbsp;</td>
	    		</tr>
      			<tr >
        			<td class="saludo1">Periodo Liquidar:</td>
        			<?php
						if(!$_POST[oculto])
						{
	 						$_POST[diast]=array();
	 						$_POST[devengado]=array();
	 						$_POST[empleados]=array();		 		
						}
						$sqlr="select *from admfiscales where vigencia='$vigusu'";
						$resp = mysql_query($sqlr,$linkbd);
						while ($row =mysql_fetch_row($resp)) 
						{
					 		$_POST[balim]=$row[7];
					 		$_POST[btrans]=$row[8];
					 		$_POST[bfsol]=$row[6];
							$_POST[alim]=$row[5];
					 		$_POST[transp]=$row[4];
							$_POST[salmin]=$row[3];
							$_POST[cajacomp]=$row[13];
							$_POST[icbf]=$row[10];
							$_POST[sena]=$row[11];
							$_POST[esap]=$row[14];
							$_POST[iti]=$row[12];	
							$_POST[indiceinca]=$row[15];						 	
						}		
        			?>
					<td>
						<input type="hidden" id="cajacomp" name="cajacomp" value="<?php echo $_POST[cajacomp]?>" >
                        <input type="hidden" id="icbf" name="icbf" value="<?php echo $_POST[icbf]?>" >
                        <input type="hidden" id="sena" name="sena" value="<?php echo $_POST[sena]?>" >
                        <input type="hidden" id="esap" name="esap" value="<?php echo $_POST[esap]?>" >
                        <input type="hidden" id="iti" name="iti" value="<?php echo $_POST[iti]?>" >           
                        <input type="hidden" id="indiceinca" name="indiceinca" value="<?php echo $_POST[indiceinca]?>" >                   
                        <input type="hidden" id="btrans" name="btrans" value="<?php echo $_POST[btrans]?>" >
                        <input type="hidden" id="balim" name="balim"  value="<?php echo $_POST[balim]?>" >
                        <input type="hidden" id="bfsol" name="bfsol" value="<?php echo $_POST[bfsol]?>" >
                        <input type="hidden" id="transp" name="transp"  value="<?php echo $_POST[transp]?>" >
                        <input type="hidden" id="alim" name="alim" value="<?php echo $_POST[alim]?>" >
                        <input type="hidden" id="salmin" name="salmin" value="<?php echo $_POST[salmin]?>" >        
						<select name="tperiodo" id="tperiodo" onChange="validar()" >
				  			<option value="-1">Seleccione ....</option>
							<?php
					 			$sqlr="Select * from humperiodos  where estado='S'";
		 						$resp = mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($resp)) 
								{
									if($row[0]==$_POST[tperiodo])
			 						{
				 						echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";
										$_POST[tperiodonom]=$row[1];
										$_POST[diasperiodo]=$row[2];
				 					}
									else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
			     				}   
							?>
		  				</select>
                        <input type="hidden" id="tperiodonom" name="tperiodonom" value="<?php echo $_POST[tperiodonom]?>" >
                        <input type="hidden" id="cperiodo"  name="cperiodo" value="">
                 	</td>
       				<td class="saludo1">Dias:</td>
        			<td>
                    	<input name="diasperiodo" type="text" id="diasperiodo" value="<?php echo $_POST[diasperiodo]?>" size="5" readonly>
          				<input type="hidden" name="oculto" value="1">
                 	</td>
          			<td class="saludo1">CC:</td>
          			<td>
          				<select name="cc"  onChange="validar()" onKeyUp="return tabular(event,this)">
          					<option value='' <?php if(''==$_POST[cc]) echo "SELECTED"?>>Todos</option>
							<?php
								$sqlr="select *from centrocosto where estado='S' ORDER BY ID_CC	";
								$res=mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($res)) 
				    			{
					 				if($row[0]==$_POST[cc]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
									else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
								}	 	
							?>
   						</select>
          			</td>
          			<td class="saludo1" colspan="1">Mes:</td>
          			<td>
                    	<select name="periodo" id="periodo" onChange="validar()"  >
				  			<option value="-1">Seleccione ....</option>
							<?php
					 			$sqlr="Select * from meses where estado='S' ";
		 						$resp = mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($resp)) 
								{
									if($row[0]==$_POST[periodo])
			 						{
				 						echo "<option value='$row[0]' SELECTED>$row[1]</option>";
				 						$_POST[periodonom]=$row[1];
				 						$_POST[periodonom]=$row[2];
				 					}
									else {echo "<option value='$row[0]'>$row[1]</option>";}
			     				}   
							?>
		  				</select> 
		  				<?php 
		  					if($_POST[tperiodo]=='1')
							{
								?><input type="hidden" name="mesnum" value='1'>	<?php 			
							}  
		 					if($_POST[tperiodo]=='2')
							{
								?>
        						<select name="mesnum" id="mesnum">
          							<option value="1" <?php if($_POST[mesnum]=='1') echo "selected" ?>>1 Quincena</option>
          							<option value="2" <?php if($_POST[mesnum]=='2') echo "selected" ?>>2 Quincena</option>
        						</select> 
		 						<?php 	
							}
		   				?>
           				<input type="button" value="Calcular" name="calcular" onClick="validar()" >
           			</td>
       			</tr>                       
    		</table>    
			<div class="tabscontra" style="height:64%; width:99.6%"> 
 				<div class="tab">
       				<input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
	   				<label for="tab-1">Liquidacion Empleados</label>
	   				<div class="content" >
      					<?php
							$crit1=" ";
							$crit2=" ";
							echo "
							<table class='inicio' align='center' width='99%'>
								<tr><td colspan='34' class='titulos'>.: Resultados Busqueda: $ntr Empleados</td></tr>
								<tr>
									<td class='titulos2' >Id</td>
									<td class='titulos2' >Excluir<input type='checkbox' id='todosex' name='todosex' value='' onClick='checktodosex()' $chkex></td>
									<td class='titulos2'>SECTOR</td>
									<td class='titulos2'>Vac<input type='checkbox' id='todos' name='todos' value='' onClick='' $chk></td>
									<td class='titulos2'>EMPLEADO</td>
									<td class='titulos2' >Doc Id</td>
									<td class='titulos2'>SAL BAS</td>
									<td class='titulos2'>DIAS LIQ</td>
									<td class='titulos2'>Dias Novedad</td>
									<td class='titulos2'>DEVENGADO</td>
									<td class='titulos2'>AUX ALIM</td>
									<td class='titulos2'>AUX TRAN</td>
									<td class='titulos2'>OTROS</td>
									<td class='titulos2'>TOT DEV</td>
									<td class='titulos2'>IBC</td>
									<td class='titulos2'>BASE PARAFISCALES</td>									
									<td class='titulos2'>BASE ARP</td>
									<td class='titulos2'>ARP</td>
									<td class='titulos2'>SALUD EMPLEADO</td>
									<td class='titulos2'>SALUD EMPRESA</td>
									<td class='titulos2'>SALUD TOTAL</td>
									<td class='titulos2'>PENSION EMPLEADO</td>
									<td class='titulos2'>PENSION EMPRESA</td>
									<td class='titulos2'>PENSION TOTAL</td>
									<td class='titulos2'>FONDO SOLIDARIDAD</td>
									<td class='titulos2'>RETE FTE</td>
									<td class='titulos2'>OTRAS DEDUC</td>
									<td class='titulos2'>TOT DEDUC</td>
									<td class='titulos2'>NETO PAG</td>
									<td class='titulos2'>CCF</td>
									<td class='titulos2'>SENA</td>
									<td class='titulos2'>ICBF</td>
									<td class='titulos2'>INS. TEC.</td>
									<td class='titulos2'>ESAP</td>
								</tr>";	
							$iter='saludo3';
							$iter2='saludo3';
							if ($_POST[cperiodo]=='2')
  							{
								$saludportot=0;
	 							$pensionportot=0;	 
								//*** parafiscales
								$sqlr="select porcentaje from humparafiscales where codigo='$_POST[tarp]'";
								$resp2 = mysql_query($sqlr,$linkbd);
								$row2 =mysql_fetch_row($resp2);
								$arp=$row2[0];
								$sqlr="select porcentaje from humparafiscales where codigo='$_POST[tsaludemr]'";
								$resp2 = mysql_query($sqlr,$linkbd);
								$row2 =mysql_fetch_row($resp2);
								$saludportot=$row2[0];
								$saludporemr=$row2[0];
								$saludemp=$row2[0];	 
								$sqlr="select porcentaje from humparafiscales where codigo='$_POST[tsaludemp]'";
								$resp2 = mysql_query($sqlr,$linkbd);
								$row2 =mysql_fetch_row($resp2);
								$salud=$row2[0];
								$saludpor=$row2[0];
								$saludportot+=$row2[0];
								$sqlr="select porcentaje from humparafiscales where codigo='$_POST[tpensionemr]'";
								$resp2 = mysql_query($sqlr,$linkbd);
								$row2 =mysql_fetch_row($resp2);
								$pensionportot=$row2[0];
								$pensionemp=$row2[0];
								$pensionporemp=$row2[0];
								$sqlr="select porcentaje from humparafiscales where codigo='$_POST[tpensionemp]'";
								$resp2 = mysql_query($sqlr,$linkbd);
								$row2 =mysql_fetch_row($resp2);
								$pension=$row2[0];
								$pensionportot+=$row2[0];	 	  
								$pensionpor=$row2[0];
								$_POST[totsaludtot]=0;
								$_POST[totpenstot]=0;
								$_POST[totaldevini]=0;
								$_POST[totalauxalim]=0;
								$_POST[totalauxtra]=0;
								$_POST[totaldevtot]=0;
								$_POST[totalsalud]=0;
								$_POST[totalpension]=0;
								$_POST[totaltransporte]=0;
								$_POST[totalfondosolida]=0;
								$_POST[totalotrasreducciones]=0;
								$_POST[totaldeductot]=0;
								$_POST[totalnetopago]=0;
								$totsaludtot=0;
								$totpenstot=0;
								$valtotalccf=0;
								$valtotalsena=0;
								$valtotalicbf=0;
								$valtotalinstec=0;
								$valtotalesap=0;
								$valtotalibc=0;
								$valtotalbaspara=0;
								$valtotalarp=0;
								$valtotalsalempr=0;
								$valtotalsaltot=0;
								$valtotalpesempr=0;
								$valtotalpestot=0;$contapru=0;
								$iter="zebra1";
								$iter2="zebra2";
								$sqlr="select *from terceros inner join terceros_nomina on terceros.cedulanit=terceros_nomina.cedulanit where terceros.estado='S' and terceros.empleado='1' and terceros_nomina.cc LIKE '%".$_POST[cc]."%' AND terceros_nomina.estado='S' order by terceros.cedulanit";
								$resp = mysql_query($sqlr,$linkbd);
								$ntr = mysql_num_rows($resp);
								$con=0;
								$totalparafiscales=0;
								while ($row =mysql_fetch_row($resp)) 
	 							{
									$indicador="";
									$tipoinca="";
									$pagapara="S";
									$sqlr="select distinct humincapacidades_det.dias,humincapacidades.tipo_inca,humincapacidades.indicador,humincapacidades.pagar_parafiscales, humincapacidades_det.diasdesc from humincapacidades,humincapacidades_det where tercero='$row[12]' and humincapacidades_det.vigencia='$vigusu' and humincapacidades_det.mes=$_POST[periodo] and humincapacidades_det.estado='S' and humincapacidades.estado='S' and  humincapacidades.id_inca=humincapacidades_det.id_inca";
									//echo "$sqlr </br>";
									$diatn=0;
									$resp2 = mysql_query($sqlr,$linkbd);
									while($row2 =mysql_fetch_row($resp2))
									{
									$diatn=	($row2[0]-$row2[4]);									
									$indicador=$row2[2];
									$tipoinca=$row2[1];
									$pagapara=$row2[3];
									}
									$_POST[diasnov][$con]=$diatn;
									$sqlr="select terceros_nomina.cargo, humnivelsalarial.nombre, humnivelsalarial.valor, terceros_nomina.fondopensionestipo from terceros_nomina inner join humnivelsalarial on terceros_nomina.cargo=humnivelsalarial.id_nivel where terceros_nomina.cedulanit=$row[12] ";
								 	$resp2 = mysql_query($sqlr,$linkbd);
									$row2 =mysql_fetch_row($resp2);
									$valordia=$row2[2]/30;								
									$diaspagnorm=$_POST[diast][$con];
									$horex=$_POST[horaextra][$con];
									$valordianov=0;
									$auxalim=0;
									$auxtra=0;
									$otrasrete=0;
									$totalretenciones=0;
									$rsalud=0;
									$rpension=0;
									$rpensionemp=0;
									$valsaludtot=0;
									$valpensiontot=0;									
									$otrasrete=0;
									$fondosol=0;
									$varp=0;
									$deven=0;
									$deven2=0;
									$salario=0;
									$bparafiscales=0;
									$bparafiscales2=0;
									$auxtratot=0;
 									$auxalimtot=0;
									$auxalimtot2=0;
									$totalneto=0;
									$totdev=0;
									$netopago=0;
									$valccf=0;
									$valsena=0;
									$valicbf=0;
									$valinstec=0;
									$valesap=0;
									$valdevengado=0;
									$valhorext=0;
									$diaslab=$_POST[diast][$con];
	 								$chk='';	 	
									$chkex='';
									$ch='';
									$chex=''; 							
									$ch=esta_en_array($_POST[empleados],$row[12]);
	 								$chkex='';
									$chex=esta_en_array($_POST[liqempleados],$row[12]);
									if($chex==1)
									$chkex=' checked';
									if($chex!=1)
									{
									if($row2[2]<=$_POST[balim]){$auxalim=$_POST[alim];$auxalim=$auxalim/30; }
									if($row2[2]<=$_POST[btrans]){$auxtra=$_POST[transp];$auxtra=$auxtra/30;} 
			 						$style="";		
									$auxtratot=round($auxtra*$diaspagnorm,0);
 	 								$auxalimtot=round($auxalim*$diaspagnorm,0);
									if($ch=='1')
			 						{
			 							$chk="checked";
										$diaslab=$_POST[diast][$con]-$_POST[diasnov][$con];
										$diaspagnorm=$_POST[diasperiodo]-$_POST[diasnov][$con];
										$diaslabarp=$_POST[diast][$con]-$_POST[diasnov][$con];										
			 							$auxtratot=round($auxtra*$diaslabarp,0);
 	 		 							$auxalimtot=round($auxalim*$diaslabarp,0);
										$auxalimtot2=round($auxalim*30,0);
 			  							$style="style='backgroundColor=#3399bb'";
			 						}	
	 								if($_POST[diasnov][$con]>0)
	 								{
										$diaslab=$_POST[diast][$con]-$_POST[diasnov][$con];
	  									//$valordianov=($_POST[indiceinca]/100)*$valordia; 
										$valordianov=($indicador/100)*$valordia;
  	  									$diaspagnorm=$_POST[diasperiodo]-$_POST[diasnov][$con];
										$auxtratot=round($auxtra*$diaspagnorm,0);
	 	 								$auxalimtot=round($auxalim*$diaspagnorm,0);
										if($ch=='1')
										{
	 										$auxtratot=round($auxtra*$diaslab,0);
	 	 									$auxalimtot=round($auxalim*$diaslab,0);
											$auxalimtot2=round($auxalim*30,0);
										}
									}
									$salario=$row2[2]; 
									$tipofondopension=$row2[3];
									
	 								if($_POST[diast][$con]>$_POST[diasperiodo] || $_POST[diast][$con]<0 || $_POST[diast][$con]=='')
	 								{$_POST[diast][$con]=$_POST[diasperiodo];}
	 								
	 								$rsalud=0;
									$rpension=0;
									$otrasrete=0;
									$fondosol=0;
									$varp=0;	 
									 
     								$vdv=round($valordianov*$_POST[diasnov][$con],0);
	 								$deven=(round($valordia*$diaslab,0)+round($valordianov*$_POST[diasnov][$con],0));
	 								if($_POST[diasnov][$con]>0 && $ch!='1')
	 								{
										if($ch!='1')
										{
	 										$deven2=round(($valordia*$diaspagnorm)+($valordianov*$_POST[diasnov][$con])+$horex,0);
	 										$diasarp=round(($valordia*$diaspagnorm),0,PHP_ROUND_HALF_DOWN);
										}
	 								}
	 								else
	 								{
										//****modificacion temporal - suspension auxilio alim al IBC
	 									$deven2=round(($valordia* $diaslab)+$auxalimtot+$auxtratot+$horex,0);
										if($ch=='1')
				 						{
	 									$diasarp=round(($valordia*($diaslabarp))+$auxalimtot+$auxtratot+$horex,0,PHP_ROUND_HALF_DOWN);
										$deven2=round(($valordia*(30))+$auxalimtot2+$auxtratot+$horex,0);									
										$deven=(round($valordia*$diaslab,0)+round($valordianov*$_POST[diasnov][$con],0));
										}
										else
										{
	 									$diasarp=round(($valordia*$diaslab)+$auxalimtot+$auxtratot+$horex,0,PHP_ROUND_HALF_DOWN);	
										}
	 								}
									//****modificacion temporal - suspension auxilio alim al IBC
									$totdev=$deven+$auxalimtot+$auxtratot+$horex; 
	 	 							//**devengado
									$sqlr="select * from  humvariables_det where codigo='$_POST[tsueldo]' and cc='".$row[31]."' and estado='S' and vigencia='$vigusu'";
									$resrp = mysql_query($sqlr,$linkbd);
									$rowrp =mysql_fetch_row($resrp);
									$ctapresnomina=$rowrp[7];
									$pfcp[$ctapresnomina]+= $deven+$horex; 
	 	 							//**alimentacion
									$sqlr="select * from  humvariables_det where codigo='$_POST[tsubalim]' and cc='".$row[31]."' and estado='S' and vigencia='$vigusu'";
									$resrp = mysql_query($sqlr,$linkbd);
									$rowrp =mysql_fetch_row($resrp);
									$pfcp[$rowrp[7]]+= $auxalimtot;
		 							//**transporte
									$sqlr="select * from  humvariables_det where codigo='$_POST[tauxtrans]' and cc='".$row[31]."' and estado='S' and vigencia='$vigusu'";
									$resrp = mysql_query($sqlr,$linkbd);
									$rowrp =mysql_fetch_row($resrp);
									
									$pfcp[$rowrp[7]]+= $auxtratot;		
									//****
									if($ch==1)
									{
										
										$bparafiscales2=round($salario + $auxalimtot2,-3,PHP_ROUND_HALF_DOWN);
									}
									else
									{
										
										$bparafiscales2=round((($salario/30)*$_POST[diast][$con])+ $auxalimtot,-3,PHP_ROUND_HALF_DOWN);
									}
									
									if($tipoinca!='L')
									{	
										
										if($pagapara=='S')	
										{
											if ($salrioaux == "S")
											{
												$basearp=(($salario/30)*($_POST[diast][$con] -$_POST[diasnov][$con]))+ $auxalimtot;
												$bparafiscales=round((($salario/30)*$_POST[diast][$con])+ $auxalimtot,-3,PHP_ROUND_HALF_DOWN);
												$basearp=round($basearp,-3,PHP_ROUND_HALF_DOWN);
												//$basearp=ceil($basearp/1000)*1000;
											}
											else
											{
												$basearp=(($salario/30)*($_POST[diast][$con]-$_POST[diasnov][$con]));
												$basearp=round($basearp,-3,PHP_ROUND_HALF_DOWN);
												$bparafiscales=round((($salario/30)*$_POST[diast][$con]),-3,PHP_ROUND_HALF_DOWN);
											}
										}
										else
										{
											if ($salrioaux == "S")
											{
												$basearp=round((($salario/30)*($_POST[diast][$con]-$_POST[diasnov][$con]))+$auxalimtot,-3,PHP_ROUND_HALF_DOWN);
												$bparafiscales=round((($salario/30)*($_POST[diast][$con]-$_POST[diasnov][$con]))+ $auxalimtot,-3,PHP_ROUND_HALF_DOWN);
											}
											else
											{
												$basearp=round((($salario/30)*($_POST[diast][$con]-$_POST[diasnov][$con])),-3,PHP_ROUND_HALF_DOWN);
												$bparafiscales=round((($salario/30)*($_POST[diast][$con]-$_POST[diasnov][$con])),-3,PHP_ROUND_HALF_DOWN);
											}	
										}
									}
									else
									{$basearp=$bparafiscales=0;}
									$sqlr="select *from centrocosto where estado='S'";
									$rescc=mysql_query($sqlr,$linkbd);
									while ($rowcc =mysql_fetch_row($rescc)) 
	 								{
									//***fondo de solidaridad
									
									$fondosol=0;
									if($tipofondopension!='N/A')	
									  {
											$sqlr="select * from humfondosoli where estado='S' and $salario between (rangoinicial*$_POST[salmin]) and (rangofinal*$_POST[salmin])";
											$resp2 = mysql_query($sqlr,$linkbd);
											$row2 =mysql_fetch_row($resp2);	
																				
												
											$fondosol=round((($row2[3]/2)/100)*(round($salario + $auxalimtot2,-3,PHP_ROUND_HALF_DOWN)),-2)*2;
										}
									
									
	  									$sqlr="select * from humparafiscales where tipo='A' and estado='S'";
	  									$respf = mysql_query($sqlr,$linkbd);
	  									while($rowf =mysql_fetch_row($respf))
	  									{
		 									if($row[31]==$rowcc[0])
		  									{ 
		    									if($rowf[0]!=$_POST[tpensionemr] &&  $rowf[0]!=$_POST[tsaludemr])//parafiscales
												{
													if ($rowf[0]!=$_POST[tarp] )
													{  
														if($pagapara=='S')
														{
															//$pf[$rowf[0]][$rowcc[0]]+=round (($bparafiscales*$rowf[3])/100,-2,PHP_ROUND_HALF_DOWN);
															$pf[$rowf[0]][$rowcc[0]]+=ceil(($bparafiscales*$rowf[3])/10000)*100;
															
														}	
													  	else
														{
															//$pf[$rowf[0]][$rowcc[0]]+=round (($basearp*$rowf[3])/100,-2,PHP_ROUND_HALF_DOWN);
															$pf[$rowf[0]][$rowcc[0]]+=ceil(($basearp*$rowf[3])/10000)*100;
														}
													}
													if ($rowf[0]==$_POST[tarp] )//riesgos profecionales
													{
														//$pf[$rowf[0]][$rowcc[0]]+=round (($basearp*$rowf[3])/100,-2,PHP_ROUND_HALF_DOWN);
														$pf[$rowf[0]][$rowcc[0]]+=ceil(($basearp*$rowf[3])/10000)*100;
													}
												}
												else 
												{
													if($rowf[0]==$_POST[tpensionemr])//pension empleador
													{
													 	if($tipofondopension!='N/A')	
													  	{
															$pf[$rowf[0]][$rowcc[0]]+=((round((ceil (($bparafiscales2*16)/100)),-2,PHP_ROUND_HALF_DOWN))-(($bparafiscales2*$pensionpor)/100));
				 
													  	}														
													}
													else
													{
														if($rowf[0]==$_POST[tsaludemr])//salud empleador
													  	{
															$pf[$rowf[0]][$rowcc[0]]+=(round ((ceil (($bparafiscales2*12.5)/100)),-2,PHP_ROUND_HALF_DOWN))-(($bparafiscales2*$saludpor)/100);
									 
													  	}
													  	else
													  	{
													  	//$pf[$rowf[0]][$rowcc[0]]+=round (($bparafiscales*$rowf[3])/100,-2,PHP_ROUND_HALF_DOWN);
															$pf[$rowf[0]][$rowcc[0]]+=ceil(($bparafiscales*$rowf[3])/10000)*100;
															
													  	}
													}	
												}
												if($rowf[0]==$_POST[tpensionemr])
		 										{
			 										if($tipofondopension=='N/A'){$tpf='N/A';}
			 										if($tipofondopension=='PR'){$tpf='privado';}
			 										if($tipofondopension=='PB'){$tpf='publico';}
													if($tpf!='N/A')													
													{
													$sqlr="select * from humparafiscales_det where codigo='$rowf[0]' and cc='$rowcc[0]' and estado='S' and sector='$tpf' and vigencia='$vigusu'";
		 											$resrp = mysql_query($sqlr,$linkbd);
													$rowrp =mysql_fetch_row($resrp);
													
													$pfcp[$rowrp[6]]+=((round((ceil (($bparafiscales2*16)/100)),-2,PHP_ROUND_HALF_DOWN))-(($bparafiscales2*$pensionpor)/100));
													}
		 										}
			 									else
				 								{
													$sqlr="select * from humparafiscales_det where codigo='$rowf[0]' and cc='$rowcc[0]' and estado='S' and vigencia='$vigusu'";
													$resrp = mysql_query($sqlr,$linkbd);
													$rowrp =mysql_fetch_row($resrp);
													if($rowf[0]==$_POST[tsaludemr] )
													{
														$pfcp[$rowrp[6]]+=(round ((ceil (($bparafiscales2*12.5)/100)),-2,PHP_ROUND_HALF_DOWN))-(($bparafiscales2*$saludpor)/100);
													}
													else 
													{
														if($rowf[0]==$_POST[tarp])
														{
															
																//$pfcp[$rowrp[6]]+= round(($rowf[3]/100)*$basearp,-2,PHP_ROUND_HALF_DOWN);
																$pfcp[$rowrp[6]]+= ceil(($rowf[3]/10000)*$basearp)*100;
														}
														  	if ($rowf[0]!=$_POST[tarp])	
														  	{
														  		if ($pagapara=='S')													  
														  		{
																	//$pfcp[$rowrp[6]]+=round(($rowf[3]/100)*$bparafiscales,-2,PHP_ROUND_HALF_DOWN);
																	$pfcp[$rowrp[6]]+=ceil((($rowf[3]/100)*$bparafiscales)/100)*100;
																}												
														  		else
														   		{
																	//$pfcp[$rowrp[6]]+= round(($rowf[3]/100)*$basearp,-2,PHP_ROUND_HALF_DOWN);
																	$pfcp[$rowrp[6]]+= ceil(($rowf[3]/10000)*$basearp)*100;
																	
																}
														  }
													}
		 										}				 
		  									}
	  									}	
									}
	 								$varp=round((($arp/100)*$basearp),-2);   //***con redondeo
									$rsalud=($saludpor/100)*$bparafiscales2;
									$rsaludemp=($saludporemr/100)*$bparafiscales2;
									$valsaludtot=ceil (($rsalud+$rsaludemp)/100)*100;
									if($tpf!='N/A')
									{
										$valpensiontot=round(($pensionportot/100)*$bparafiscales,-2,PHP_ROUND_HALF_DOWN);
										$rpension=($pensionpor*$bparafiscales2)/100;
										$rpensionemp=($pensionporemp*$bparafiscales2)/100;
										$valpensiontot=$rpension+$rpensionemp+$fondosol;	
									}
									else
									{
										$rpension=0;
										$rpensionemp=0;
										$valpensiontot=0;	
									}
									
									$sqlr="select sum(valorcuota) from humretenempleados where estado='S' and habilitado='H'  and empleado='".$row[12]."' and sncuotas>0";
									$resp2 = mysql_query($sqlr,$linkbd);
									$row2 =mysql_fetch_row($resp2);
									$otrasrete=round($row2[0]);
									$totalretenciones=$rsalud+$rpension+$otrasrete+$fondosol;
									$totalneto= $totdev-$totalretenciones;//******AJUSTE DEL AUXILIO
	  								if($ch=='1'){$totalparafiscales+=$bparafiscales2;}
			 						else {$totalparafiscales+=$bparafiscales;}
											
									//ARREGLO PROVICIONAL PARA NOMINA AGOSTO 2016 PUERTO RICO
									//devengado
									
									$valdevengado=round(($salario/30)*($_POST[diast][$con]-$_POST[diasnov][$con]),0,PHP_ROUND_HALF_DOWN)+round($valordianov*($_POST[diasnov][$con]),0,PHP_ROUND_HALF_DOWN);
									//horas extras
									$valhorext=$_POST[horaextra][$con];
									if($valhorext==''){$valhorext=0;}
									//total salario devengado = devengado + auxilio alimentación
									if($ch=='1')
									{
										//$valcalculos=round($salario + $auxalimtot2,-3,PHP_ROUND_HALF_DOWN);
										$valcalculos=ceil(($salario + $auxalimtot2)/100)*100;
									}
									else 
									{
										if ($salrioaux == "S")
										{
											//$valcalculos=round((($salario/30)*$_POST[diast][$con])+ $auxalimtot,-3,PHP_ROUND_HALF_DOWN);
											//$valcalculos=ceil(((($salario/30)*$_POST[diast][$con])+ $auxalimtot)/100)*100;
											$valcalculos=ceil(($valdevengado+ $auxalimtot)/100)*100;
										}
										else
										{
											//$valcalculos=round((($salario/30)*$_POST[diast][$con]),-3,PHP_ROUND_HALF_DOWN);
											//$valcalculos=ceil(((($salario/30)*$_POST[diast][$con]))/100)*100;
											$valcalculos=ceil((($valdevengado))/100)*100;
										}
									}
									if($tipoinca!='L')
									{
										if ($salrioaux == "S")
										{
											if($pagapara=='S')	
											{$valcalculosotos=round((($salario/30)*$_POST[diast][$con])+ $auxalimtot,-3,PHP_ROUND_HALF_DOWN);}
											else
											{$valcalculosotos=round((($salario/30)*($_POST[diast][$con]-$_POST[diasnov][$con]))+ $auxalimtot,-3,PHP_ROUND_HALF_DOWN);}
										}
										else
										{
											if($pagapara=='S')	
											{$valcalculosotos=round((($salario/30)*$_POST[diast][$con]),-3,PHP_ROUND_HALF_DOWN);}
											else
											{$valcalculosotos=round((($salario/30)*($_POST[diast][$con]-$_POST[diasnov][$con])),-3,PHP_ROUND_HALF_DOWN);}
										}
									}
									else {$valcalculosotos=0;}
									//**Pension
									if($tpf!='N/A')
									{
										$valpensiontot=ceil (($valcalculos*16)/10000)*100;
										//$valpensiontot=round($valpensiontot,-2,PHP_ROUND_HALF_DOWN);
										$rpension=($valcalculos*$pensionpor)/100;
										$rpensionemp=$valpensiontot-$rpension;
									}
									else
									{
										
										$valpensiontot=0;
										$rpension=0;
										$rpensionemp=0;
									}
									//**Salud
									$valsaludtotsin=($valcalculos*12.5)/100;
									$valsaludtot=ceil(($valcalculos*12.5)/10000)*100;
									//$valsaludtot=round ($valsaludtot,-2,PHP_ROUND_HALF_DOWN);
									$rsalud=($valcalculos*$saludpor)/100;
									$rsaludemp=$valsaludtot-$rsalud;
									//**ARP
									//$valarp=round (($basearp*0.522)/100,-2,PHP_ROUND_HALF_DOWN);
									$valarp=ceil(($basearp*0.522)/10000)*100;
									//**CCF
									//$valccf=round (($valcalculosotos*4)/100,-2,PHP_ROUND_HALF_DOWN);
									$valccf=ceil(($valcalculosotos*4)/10000)*100;
									//**SENA
									//$valsena=round (($valcalculosotos*0.5)/100,-2,PHP_ROUND_HALF_DOWN);
									$valsena=ceil(($valcalculosotos*0.5)/10000)*100;
									//**ICBF
									//$valicbf=round (($valcalculosotos*3)/100,-2,PHP_ROUND_HALF_DOWN);
									$valicbf=ceil(($valcalculosotos*3)/10000)*100;
									//**INSTITUTOS TECNICOS
									//$valinstec=round (($valcalculosotos*1)/100,-2,PHP_ROUND_HALF_DOWN);
									$valinstec=ceil(($valcalculosotos*1)/10000)*100;
									//**ESAP
									//$valesap=round (($valcalculosotos*0.5)/100,-2,PHP_ROUND_HALF_DOWN);
									$valesap=ceil(($valcalculosotos*0.5)/10000)*100;
									//**Total descuentos
									$totalretenciones=$rsalud+$rpension+$otrasrete+$fondosol;
									//**Neto a Pagar
									$totalneto= $totdev-$totalretenciones;								
								}
								$nemp=buscatercero($row[12]);									
	 								echo "
									<input type='hidden' name='nomemp[]' value='".strtoupper($nemp)."'/>
									<input type='hidden' name='ccemp[]' value='$row[12]'/>
									<input type='hidden' name='centrocosto[]' value='$row[31]'/>
									<input type='hidden' name='salbas[]' value='$salario'/>
									<input type='hidden' name='devengado[]' value='$valdevengado'/>
									<input type='hidden' name='ealim[]' value='$auxalimtot'/>
									<input type='hidden' name='etrans[]' value='$auxtratot'/>
									<input type='hidden' name='horaextra[]' value='$valhorext'/>
									<input type='hidden' name='totaldev[]' value='$totdev'/>
									<input type='hidden' name='ibc[]' value='$valcalculos'/>
									<input type='hidden' name='ibc2[]' value='$valcalculosotos'/>
									<input type='hidden' name='ibcarp[]' value='$basearp'/>
									<input type='hidden' name='arpemp[]' value='$valarp'/>
									<input type='hidden' name='saludrete[]' value='$rsalud'/>
									<input type='hidden' name='saludemprete[]' value='$rsaludemp'/>
									<input type='hidden' name='totsaludrete[]' value='$valsaludtot'/>
									<input type='hidden' name='pensionrete[]' value='$rpension'/>
									<input type='hidden' name='pensionemprete[]' value='$rpensionemp'/> 
									<input type='hidden' name='totpensionrete[]' value='$valpensiontot'/>
									<input type='hidden' name='fondosols[]' value='$fondosol'/>
									<input type='hidden' name='otrasretenciones[]' value='$otrasrete'/>
									<input type='hidden' name='totalrete[]' value='$totalretenciones'/>
									<input type='hidden' name='netopagof[]' value='".number_format($totalneto,0)."'/>
									<input type='hidden' name='netopago[]' value='$totalneto'>
									<tr id='fila$row[12]' class='$iter' onMouseOut=\"this.style.backgroundColor=anterior\" onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\">
										<td>$con</td>
										<td><input type='checkbox' name='liqempleados[]' value='$row[12]' onClick='marcarliq($row[12],$con);' $chkex></td>									
										<td>$tipofondopension</td>
										<td><input type='checkbox' name='empleados[]' value='$row[12]' onClick='marcar($row[12],$con);' $chk></td>
										<td>".strtoupper($nemp)."</td>													
										<td>$row[12]</td>
										<td style='text-align:right;'>$".number_format($salario,0,',','.')."</td>
										<td><input type='text' size='2' name='diast[]' value='".$_POST[diast][$con]."'  onKeyPress='javascript:return solonumeros(event)' onKeyUp='return tabular(event,this)'/></td>
										<td><input type='number' max='30' min='0' size='2' name='diasnov[]' value='".$_POST[diasnov][$con]."'  onKeyPress='javascript:return solonumeros(event)' onKeyUp='return tabular(event,this)'  onBlur='validar()' readonly> </td>
										<td style='text-align:right;'>$".number_format($valdevengado,0,',','.')."</td>
										<td style='text-align:right;'>$".number_format($auxalimtot,0,',','.')."</td>
										<td style='text-align:right;'>$".number_format($auxtratot,0,',','.')."</td>
										<td style='text-align:right;'>$".number_format($valhorext,0,',','.')."</td>
										<td style='text-align:right;'>$".number_format($totdev,0,',','.')."</td>
										<td style='text-align:right;'>$".number_format($valcalculos,0,',','.')."</td>
										<td style='text-align:right;'>$".number_format($valcalculosotos,0,',','.')."</td>
										<td style='text-align:right;'>$".number_format($basearp,0,',','.')."</td>
										<td style='text-align:right;'>$".number_format($valarp,0,',','.')."</td>
										<td style='text-align:right;'>$".number_format($rsalud,0,',','.')."</td>
										<td style='text-align:right;'>$".number_format($rsaludemp,0,',','.')."</td>
										<td style='text-align:right;'>$".number_format($valsaludtot,0,',','.')."</td>
										<td style='text-align:right;'>$".number_format($rpension,0,',','.')."</td>
										<td style='text-align:right;'>$".number_format($rpensionemp,0,',','.')."</td>
										<td style='text-align:right;'>$".number_format($valpensiontot,0,',','.')."</td>
										<td style='text-align:right;'>$".number_format($fondosol,0,',','.')."</td>
										<td style='text-align:right;'>$0</td>
										<td style='text-align:right;'>$".number_format($otrasrete,0,',','.')."</td>
										<td style='text-align:right;'>$".number_format($totalretenciones,0,',','.')."</td>
										<td style='text-align:right;'>$".number_format($totalneto,0,',','.')."</td>
										<td style='text-align:right;'>$".number_format($valccf,0,',','.')."</td>
										<td style='text-align:right;'>$".number_format($valsena,0,',','.')."</td>
										<td style='text-align:right;'>$".number_format($valicbf,0,',','.')."</td>
										<td style='text-align:right;'>$".number_format($valinstec,0,',','.')."</td>
										<td style='text-align:right;'>$".number_format($valesap,0,',','.')."</td>
									</tr>";
									$valtotalccf+=$valccf;
									$valtotalsena+=$valsena;
									$valtotalicbf+=$valicbf;
									$valtotalinstec+=$valinstec;
									$valtotalesap+=$valesap;
									$valtotalibc+=$valcalculos;
									$valtotalbaspara+=$valcalculosotos;
									$valtotalarp+=$valarp;
									$valtotalsalempr+=$rsaludemp;
									$valtotalsaltot+=$valsaludtot;
									$valtotalpesempr+=$rpensionemp;
									$valtotalpestot+=$valpensiontot;
									$auxalimtot=$auxalim*$_POST[diast][$con];
									$auxtratot=$auxtra*$_POST[diast][$con];
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
									$_POST[totalhorex]+=$_POST[horaextra][$con];
									$con+=1;
									$aux=$iter;
									$iter=$iter2;
									$iter2=$aux;
								}
  							}
 							
							echo "
							<input type='hidden' name='totaldevini' value='$_POST[totaldevini]'/>
							<input type='hidden' name='totalauxalim' value='$_POST[totalauxalim]'/>
							<input type='hidden' name='totalauxtra' value='$_POST[totalauxtra]'/>
							<input type='hidden' name='totalhorex' value='$_POST[totalhorex]'/>
							<input type='hidden' name='totaldevtot' value='$_POST[totaldevtot]'/>
							<input type='hidden' name='totalibc' value='$valtotalibc'/>
							<input type='hidden' name='totalsalud' value='$_POST[totalsalud]'/>
							<input type='hidden' name='totalpension' value='$_POST[totalpension]'/>
							<input type='hidden' name='totalfondosolida' value='$_POST[totalfondosolida]'/>
							<input type='hidden' name='totalotrasreducciones' value='$_POST[totalotrasreducciones]'/>
							<input type='hidden' name='totaldeductot' value='$_POST[totaldeductot]'/>
							<input type='hidden' name='totalnetopago' value='$_POST[totalnetopago]'/>
							<tr class='titulos2'>
								<td colspan='9'></td>
								<td style='text-align:right;'>$".number_format($_POST[totaldevini],0,',','.')."</td>
								<td style='text-align:right;'>$".number_format($_POST[totalauxalim],0,',','.')."</td>
								<td style='text-align:right;'>$".number_format($_POST[totalauxtra],0,',','.')."</td>
								<td style='text-align:right;'>$".number_format($_POST[totalhorex],0,',','.')."</td>
								<td style='text-align:right;'>$".number_format($_POST[totaldevtot],0,',','.')."</td>
								<td style='text-align:right;'>$".number_format($valtotalibc,0,',','.')."</td>
								<td style='text-align:right;'>$".number_format($valtotalbaspara,0,',','.')."</td>
								<td style='text-align:right;'>$".number_format($valtotalbaspara,0,',','.')."</td>
								<td style='text-align:right;'>$".number_format($valtotalarp,0,',','.')."</td>
								<td style='text-align:right;'>$".number_format($_POST[totalsalud],0,',','.')."</td>
								<td style='text-align:right;'>$".number_format($valtotalsalempr,0,',','.')."</td>
								<td style='text-align:right;'>$".number_format($valtotalsaltot,0,',','.')."</td>
								<td style='text-align:right;'>$".number_format($_POST[totalpension],2)."</td>
								<td style='text-align:right;'>$".number_format($valtotalpesempr,0,',','.')."</td>
								<td style='text-align:right;'>$".number_format($valtotalpestot,0,',','.')."</td>
								<td style='text-align:right;'>$".number_format($_POST[totalfondosolida],0,',','.')."</td>
								<td style='text-align:right;'>$0</td>
								<td style='text-align:right;'>$".number_format($_POST[totalotrasreducciones],0,',','.')."</td>
								<td style='text-align:right;'>$".number_format($_POST[totaldeductot],0,',','.')."</td>
								<td style='text-align:right;'>$".number_format($_POST[totalnetopago],0,',','.')."</td>
								<td style='text-align:right;'>$".number_format($valtotalccf,0,',','.')."</td>
								<td style='text-align:right;'>$".number_format($valtotalsena,0,',','.')."</td>
								<td style='text-align:right;'>$".number_format($valtotalicbf,0,',','.')."</td>
								<td style='text-align:right;'>$".number_format($valtotalinstec,0,',','.')."</td>
								<td style='text-align:right;'>$".number_format($valtotalesap,0,',','.')."</td>
							</tr>";	
 							echo"</table>";
						?>
                 	</div>
				</div>
    			<div class="tab">
       				<input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?> >
	   				<label for="tab-2">Aportes Parafiscales</label>
	   				<div class="content" style="overflow:hidden">
						<table class="inicio">
							<tr>
								<td class="titulos">Codigo</td>
                                <td class="titulos">Aportes Parafiscales</td>
                                <td class="titulos">Porcentaje</td>
                                <td class="titulos">Valor</td>
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
  	 								if($co==0){echo "<tr>"; }	  
									$caja=$row2[0];
									$ncaja=$row2[1];
									$pcaja=$row2[3];
									// 	 $vcaja=round(($pcaja/100)*($totalparafiscales),-2);	
  									$vcaja=array_sum($pf[$row2[0]]);
	 								echo "
									<td class='saludo1'><input name='codpara[]' type='hidden' value='$caja'> $caja </td>
									<td class='saludo3'><input name='codnpara[]' type='hidden' value='$ncaja'>  $ncaja </td>
									<td class='saludo3'><input name='porpara[]' type='hidden' value='$pcaja'> $pcaja %</td>
									<td class='saludo3'><input name='valpara[]' type='hidden' value='$vcaja'>".number_format($vcaja,0)."</td>";
	  								$co+=1;
	 								if($co==3){echo "</tr>";$co=0;} 
	 							}
	 							echo "
								<tr><td  class='saludo1'>TOTAL SALUD</td><td class='saludo3'>".number_format($_POST[totsaludtot],2)."</td></tr>
								<tr><td  class='saludo1'>TOTAL PENSION</td><td class='saludo3'>".number_format($_POST[totpenstot],2)."</td></tr>";
							?>
						</table>
					</div>
				</div>
    			<div class="tab">
       				<input type="radio" id="tab-3" name="tabgroup1" value="3" <?php echo $check3;?> >
	   				<label for="tab-3">Presupuesto</label>
	   				<div class="content" style="overflow-x:hidden">
						<table class="inicio">
							<tr>
								<td class="titulos">Cuenta Presupuestal</td>
                                <td class="titulos">Nombre Cuenta Presupuestal</td>
                                <td class="titulos">Valor</td>
                                 <td class="titulos" style='width:5%'>Saldo</td>
                          	</tr>
							<?php
								$totalrubro=0;
								
								foreach($pfcp as $k => $valrubros)
 								{
  									$ncta=existecuentain($k);
									
  									if($valrubros>0)
  									{  		
  									$saldo="";							
  									$vsal=generaSaldo($k,$vigusu,$vigusu);
  									if($vsal>=$valrubros)
									{
									$saldo="OK";
									$color=" style=' background-color :#092; color:#fff' ";
									}
  									else
  									{
  									$saldo="SIN SALDO";
  									$color=" style=' background-color :#901; color:#fff' ";
  									}
 										echo "
										<tr class='saludo3'>
											<td><input type='hidden' name='rubrosp[]' value='$k'>$k</td>
											<td><input type='hidden' name='nrubrosp[]' value='".strtoupper($ncta)."'>".strtoupper($ncta)."</td>
											<td align='right'><input type='hidden' name='vrubrosp[]' value='$valrubros'>".number_format($valrubros,2)."</td>
											<td align='center' $color><input type='hidden' name='vsaldo[]' value='$saldo'>".$saldo."</td>
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
				<div class="tab">
       				<input type="radio" id="tab-4" name="tabgroup1" value="4" <?php echo $check4;?> >
	   				<label for="tab-4">Vacaciones</label>
	   				<div class="content" >
       					<table class="inicio">
       						<tr>
                            	<td class="titulos">No</td>
                                <td class="titulos">Documento</td>
                                <td class="titulos">Nombre</td>
                                <td class="titulos">Salario Basico</td>
                                <td class="titulos">Otros Salarios</td>
                                <td class="titulos">Valor</td>
                                <td class="titulos">Fecha Inicio</td>
                                <td class="titulos">Fecha Final</td>
                                <td class="titulos">Dias Novedad Mes</td>
                          	</tr>
       						<?php
	   							$co="zebra1s";
	   							$co2="zebra2s";
	   							$sqlr="select *from humvacaciones_cab where vigencia=$vigusu and mes=$_POST[periodo] and estado='S'";
	   							$res=mysql_query($sqlr,$linkbd);
	   							$con=1;
	   							while($row=mysql_fetch_row($res))
	    						{
		 							$sqlr="select *from humvacaciones_det where id_vac=$row[0] and ('$_POST[periodo]' BETWEEN MONTH(humvacaciones_det.fechainicial) and MONTH(humvacaciones_det.fechafinal) and '$vigusu' BETWEEN YEAR(humvacaciones_det.fechainicial) and YEAR(humvacaciones_det.fechafinal)) order by id_vac"; 
	   								$res2=mysql_query($sqlr,$linkbd);
	   								while($row2=mysql_fetch_row($res2))
	    							{	
			 							if(1==esta_en_array($_POST[ccemp],$row2[1]))
			 							{			  	 
											//$diasnov=ultimodia($vigusu,$_POST[periodo]);
											$diasnov=dias_transcurridos($row2[9],$row2[10]);
			  								echo "
											<tr class='$co'>
												<td>$con</td>
												<td>$row2[1]</td>
												<td>".buscatercero($row2[1])."</td>
												<td>".number_format($row2[2],2,",",".")."</td>
												<td>".number_format($row2[4],2,",",".")."</td>
												<td>".number_format($row2[5],2,",",".")."</td>
												<td>$row2[9]</td>
												<td>$row2[10]</td>
												<td>$diasnov</td>
											</tr>";
			 								$aux=$co2;
			 								$co2=$co;
	 		 								$co=$aux;
			 								$con+=1;
			 							}
									}
								}
	   						?>
                            </table>
       					</div>  
 					</div>                        
                     <div class="tab">
       				<input type="radio" id="tab-5" name="tabgroup1" value="5" <?php echo $check5;?> >
	   				<label for="tab-5">Incapacidades</label>
	   				<div class="content" >
       					<table class="inicio">
       						<tr>
                            	<td class="titulos">No</td>
                                <td class="titulos">Documento</td>
                                <td class="titulos">Nombre</td>
                                <td class="titulos">Mes</td>                                
                                <td class="titulos">Dias Novedad Mes</td>
                                <td class="titulos">Dias Descontados</td>
                                <td class="titulos">Valor Incapacidad</td>
                                <td class="titulos">Tipo Novedad</td>                                
				<td class="titulos">PAGO PARAFISCALES</td>  
                          	</tr>
       						<?php
	   							$co="zebra1s";
	   							$co2="zebra2s";
	   							$sqlr="select humincapacidades.id_inca,humincapacidades.tipo_inca,humincapacidades.tercero,humincapacidades_det.mes,humincapacidades_det.vigencia,humincapacidades_det.dias,humincapacidades_det.diasdesc,humincapacidades_det.valor,humincapacidades.pagar_parafiscales from humincapacidades,humincapacidades_det where  humincapacidades_det.vigencia='$vigusu' and humincapacidades_det.mes='$_POST[periodo]' and humincapacidades_det.estado='S' and humincapacidades.estado='S' and  humincapacidades.id_inca=humincapacidades_det.id_inca";
	   							$res=mysql_query($sqlr,$linkbd);
	   							$con=1;
								//echo $sqlr;
	   							while($row=mysql_fetch_row($res))
	    						{
									//echo $sqlr; 3214189433 luz amparo saludcoop
											   //$cf=esta_en_array($_POST[liqempleados],$row[2]);
									//echo "Ex:".$cf;
		 							if((1==esta_en_array($_POST[ccemp],$row[2])) && (1!==esta_en_array($_POST[liqempleados],$row[2])))
			 							{			  	 
			  							  echo "<tr class='$co'>
												<td>$row[0]</td>
												<td>$row[2]</td>
												<td>".buscatercero($row[2])."</td>
												<td>".mesletras($row[3])."</td>
												<td>$row[5]</td>
												<td>$row[6]</td>
												<td>$row[7]</td>
												<td>($row[1]) ".$tnov[$row[1]]."</td>											<td>$row[8]</td>	
												</tr>";
			 								$aux=$co2;
			 								$co2=$co;
	 		 								$co=$aux;
			 								$con+=1;
			 							}
								}
	   						?>
                            </table>
       					</div>
 					</div>    
                     <div class="tab">
       				<input type="radio" id="tab-6" name="tabgroup1" value="6" <?php echo $check6;?> >
	   				<label for="tab-6">Descuentos</label>
	   				<div class="content" >
       					<table class="inicio">
       						<tr>
                            	<td class="titulos">No</td>
                                <td class="titulos">Fecha Registro</td>
                                <td class="titulos">Documento</td>
                                <td class="titulos">Nombre</td>
                                <td class="titulos">Descripcion</td>                                
                                <td class="titulos">Valor</td>
                                <td class="titulos">No Cuota</td>
                          	</tr>
       						<?php
	   							$co="zebra1s";
	   							$co2="zebra2s";
	   							//$sqlr="select *from humincapacidades where vigencia=$vigusu and mes=$_POST[periodo] and estado='S' ";
								$sqlr="select * from humretenempleados where estado='S' and habilitado='H' and sncuotas>0 order by fecha,descripcion";
	   							$res=mysql_query($sqlr,$linkbd);
	   							$con=1;
								//echo $sqlr;
	   							while($row=mysql_fetch_row($res))
	    						{
									//echo $sqlr;
		 							if((1==esta_en_array($_POST[ccemp],$row[4])) && (1!==esta_en_array($_POST[liqempleados],$row[4])))
			 							{			  	 
			  							  echo "<tr class='$co'>
												<td>$con</td>
												<td>$row[3]</td>
												<td>".$row[4]."</td>												
												<td>".buscatercero($row[4])."</td>
												<td>$row[1]</td>
												<td>$row[8]</td>
												<td>".($row[6]-$row[7]+1)."</td>
												</tr>";
			 								$aux=$co2;
			 								$co2=$co;
	 		 								$co=$aux;
			 								$con+=1;
			 							}
								}
	   						?>
                            </table>
       					</div>
 					</div>      
				</div> 
				<?php 
					if($_POST[oculto]==2)
 					{
						if($_POST[cc]==''){$sqlr="select count(*) from humnomina where mes=$_POST[periodo] and vigencia=$vigusu and estado<>'N'";}
 						else {$sqlr="select count(*) from humnomina where mes=$_POST[periodo] and vigencia=$vigusu and cc='$_POST[cc]' and estado<>'N'";}
 						$respval=mysql_query($sqlr,$linkbd);
 						$rval =mysql_fetch_row($respval);
 						if($rval[0]<=10)
 						{
							$_POST[idcomp]=selconsecutivo('humnomina','id_nom');
  							ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
							$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
  							$sqlr="insert into humnomina (id_nom,fecha, periodo,mes,diasp,mesnum,cc,vigencia,estado) values ('$_POST[idcomp]','$fechaf','$_POST[tperiodo]','$_POST[periodo]','$_POST[diasperiodo]','$_POST[mesnum]','$_POST[cc]','$vigusu','S')";
  							if (!mysql_query($sqlr,$linkbd))
							{
	 							echo "<script>despliegamodalm('visible','2','Manejador de Errores de la Clase BDTsaltoTNo se pudo ejecutar la petición:');</script>";
							}
  							else
  							{
	 							$id=$_POST[idcomp];
								$idconec=selconsecutivo('hum_nom_cdp_rp','id');
								$sqlrco="insert into hum_nom_cdp_rp (id,nomina,cdp,rp,vigencia,estado) values ('$idconec','$id','0','0','$vigusu', 'S')";
								mysql_query($sqlrco,$linkbd);
	 							/*$sqlr="insert into humnomina_aprobado (id_nom,fecha,id_rp,persoaprobo,estado) values ($id,'$fechaf',$_POST[rp], '$_SESSION[usuario]', 'S')";
	 							if (!mysql_query($sqlr,$linkbd))
	 							{echo "<table class='inicio'><tr><td class='saludo1'><center>No se Pudo Aprobrar la Nomina <img src='imagenes\alert.png'></center></td></tr></table>";}
	  							else
	  							{echo "<table class='inicio'> <tr><td class='saludo1'> <center>Registros Exitosos:$cex   -   Registros Erroneos: $cerr<img src='imagenes\confirm.png'></center></td></tr></table> "; }*/
	  							$lastday = mktime (0,0,0,$_POST[periodo],1,$vigusu);
	  							echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado la Liquidacion de la Nomina $id - Centro Costo:$_POST[cc] - Mes: ".strtoupper(strftime('%B',$lastday))." <img src='imagenes\confirm.png'></center></td></tr></table>";
								$cex=0;
								$cerr=0;
	 							$sqlr="insert into humcomprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito, diferencia,estado) values ('$id','4','$fechaf','CAUSACION NOMINA MES ".strtoupper(strftime('%B',$lastday))."',0,0,0,0,'1')";
								mysql_query($sqlr,$linkbd);
								//echo "<br>sq:  $sqlr";
	 							for ($x=0;$x<count($_POST[salbas]);$x++) 
	 							{
									$excluido=esta_en_array($_POST[liqempleados],$_POST[ccemp][$x]);
									if($excluido!=1)
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
											if('PR'==$rown[11]){$tipoafp="privado";}			 				 
											if('PB'==$rown[11]){$tipoafp='publico';}				 				 
										}				
										//*************************************		 
										$ch=esta_en_array($_POST[empleados],$_POST[ccemp][$x]);
										$sqlr="insert into humnomina_det (id_nom,cedulanit,salbas,diaslab,devendias,ibc,auxalim,auxtran,valhorex, totaldev,salud,saludemp,pension,pensionemp,fondosolid,retefte,otrasdeduc,totaldeduc,netopagar,estado,vac,diasarl) values ('$id','".$_POST[ccemp][$x]."',".$_POST[salbas][$x].",".$_POST[diast][$x].",".$_POST[devengado][$x].",".$_POST[ibc][$x].",".$_POST[ealim][$x].",".$_POST[etrans][$x].",".$_POST[horaextra][$x].",".$_POST[totaldev][$x].",".$_POST[saludrete][$x].",".$_POST[saludemprete][$x].",".$_POST[pensionrete][$x].",".$_POST[pensionemprete][$x].",".$_POST[fondosols][$x].",0,".$_POST[otrasretenciones][$x].",".$_POST[totalrete][$x].",".$_POST[netopago][$x].",'S','$ch','".$_POST[diasnov][$x]."')";
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
											//echo "<br>$sqlr";
											while ($rowh =mysql_fetch_row($resph)) 
											{
				   								$ctacont=$rowh[11];	 
				   								$concepto=$rowh[7];	 
												//echo "<br>Concpto=".$rowh[7];
												$cuentas=concepto_cuentas($concepto,'H',2,$_POST[centrocosto][$x]); 
												$tam=count($cuentas);
												for($cta=0;$cta<$tam;$cta++)
												{
													/*echo "<br>pos0: ".$cuentas[$cta][0];
													echo "  pos1: ".$cuentas[$cta][1];
													echo "  pos2: ".$cuentas[$cta][2];
													echo "  pos3: ".$cuentas[$cta][3];	*/																																		
													if($cuentas[$cta][1]=='N' && $cuentas[$cta][2]=='S'){$ctacont=$cuentas[$cta][0];}
													if($cuentas[$cta][1]=='N' && $cuentas[$cta][3]=='S'){$ctaconcepto=$cuentas[$cta][0];}
												}				
			   								}
											$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('4 $id','$ctacont','".$_POST[ccemp][$x]."','".$_POST[centrocosto][$x]."','Causacion Salario Mes ".strtoupper(strftime('%B',$lastday))."','',".$_POST[devengado][$x].",0,'1','$vigusu')";
											mysql_query($sqlr,$linkbd);
											//echo "<br>$sqlr";
											$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('4 $id','$ctaconcepto','".$_POST[ccemp][$x]."','".$_POST[centrocosto][$x]."','Causacion Salario Mes ".strtoupper(strftime('%B',$lastday))."','',0,".$_POST[devengado][$x].",'1','$vigusu')";
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
													$ctacont=$rowh[11];	 
													$concepto=$rowh[7];	 
													$cuentas=concepto_cuentas($concepto,'H',2,$_POST[centrocosto][$x]); 
													$tam=count($cuentas);
													for($cta=0;$cta<$tam;$cta++)
													{
														if($cuentas[$cta][1]=='N' && $cuentas[$cta][2]=='S'){$ctacont=$cuentas[$cta][0];}
														if($cuentas[$cta][1]=='N' && $cuentas[$cta][3]=='S'){$ctaconcepto=$cuentas[$cta][0];}
													}				
													$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('4 $id','$ctacont','".$_POST[ccemp][$x]."','".$_POST[centrocosto][$x]."','Causacion Aux Alimentacion Mes ".strtoupper(strftime('%B',$lastday))."','',".$_POST[ealim][$x].",0,'1','".$vigusu."')";
													mysql_query($sqlr,$linkbd);
													$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('4 $id','$ctaconcepto','".$_POST[ccemp][$x]."','".$_POST[centrocosto][$x]."','Causacion Aux Alimentacion Mes ".strtoupper(strftime('%B',$lastday))."','',0,".$_POST[ealim][$x].",'1','$vigusu')";
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
												//echo "<br>$sqlr";
												while ($rowh =mysql_fetch_row($resph)) 
												{
													$ctacont=$rowh[11];	 
													$concepto=$rowh[7];	 												
													$cuentas=concepto_cuentas($concepto,'H',2,$_POST[centrocosto][$x]); 
													$tam=count($cuentas);
													for($cta=0;$cta<$tam;$cta++)
													{
														if($cuentas[$cta][1]=='N' && $cuentas[$cta][2]=='S'){$ctacont=$cuentas[$cta][0];}
														if($cuentas[$cta][1]=='N' && $cuentas[$cta][3]=='S'){$ctaconcepto=$cuentas[$cta][0];}
													}				
													$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('4 $id','$ctacont','".$_POST[ccemp][$x]."','".$_POST[centrocosto][$x]."','Causacion Aux Transporte Mes ".strtoupper(strftime('%B',$lastday))."','',".$_POST[etrans][$x].",0,'1','$vigusu')";
													mysql_query($sqlr,$linkbd);	
													$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito, valcredito,estado,vigencia) values ('4 $id','$ctaconcepto','".$_POST[ccemp][$x]."','".$_POST[centrocosto][$x]."','Causacion Aux Transporte Mes ".strtoupper(strftime('%B',$lastday))."','',0,".$_POST[etrans][$x].",'1','$vigusu')";
													mysql_query($sqlr,$linkbd);
												}
												//echo "<br>$sqlr";
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
														$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$tercero."','".$_POST[centrocosto][$x]."','APORTE SALUD EMPLEADO Mes ".strtoupper(strftime('%B',$lastday))."','',".$debito.",".$credito.",'1','".$vigusu."')";
														mysql_query($sqlr,$linkbd);
														$ctasalud=$ctacont;
													}
													if($cuentas[$cta][1]=='N' && $cuentas[$cta][3]=='S')
													{			
														$credito=$_POST[saludrete][$x];
														$debito=0;
														$tercero=$eps;
														$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$tercero."','".$_POST[centrocosto][$x]."','APORTE SALUD EMPLEADO Mes ".strtoupper(strftime('%B',$lastday))."','',".$debito.",".$credito.",'1','".$vigusu."')";
														mysql_query($sqlr,$linkbd);
														$ctasalud=$ctacont;				  
													}
				 									//echo "<br>Salud Empleado:  $sqlr";	
													/*if($_POST[centrocosto][$x]==$rowh[2]) {$ctacont=$rowh[3];$concepto=$rowh[6];}				 
												}
												if('S'==$rowh[4])
												{
													$debito=$_POST[saludrete][$x];
													$credito=0;
												  	$tercero=$_POST[ccemp][$x];
												}
												if('S'==$rowh[5])
												{
													$credito=$_POST[saludrete][$x];
													$debito=0;
													$tercero=$eps;
												}				 				 */
												//$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$tercero."','".$_POST[centrocosto][$x]."','APORTE SALUD EMPLEADO Mes ".strtoupper(strftime('%B',$lastday))."','',".$debito.",".$credito.",'1','".$vigusu."')";
												//mysql_query($sqlr,$linkbd);
												//$ctasalud=$ctacont;
												//echo "<br>$sqlr";			
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
  													$debito=$_POST[pensionrete][$x];
													$credito=0;
													$tercero=$_POST[ccemp][$x];
													$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$tercero."','".$_POST[centrocosto][$x]."','APORTE PENSION EMPLEADO Mes ".strtoupper(strftime('%B',$lastday))."','',".$debito.",".$credito.",'1','".$vigusu."')";
													mysql_query($sqlr,$linkbd);
													$ctasalud=$ctacont;
				  								}
				  								if($cuentas[$cta][1]=='N' && $cuentas[$cta][3]=='S')
				  								{			
			  										$credito=$_POST[pensionrete][$x];
													$debito=0;
													$tercero=$afp;
													$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$tercero."','".$_POST[centrocosto][$x]."','APORTE PENSION EMPLEADO Mes ".strtoupper(strftime('%B',$lastday))."','',".$debito.",".$credito.",'1','".$vigusu."')";
													mysql_query($sqlr,$linkbd);
													$ctasalud=$ctacont;				  
				 								}
												// echo "<br>Pension Empleado:  $sqlr";	
			   								}				
										}
										//******** FIN PENSION EMPLEADO ****
										//********FONDO SOLIDARIDAD EMPLEADO *****
										$ctacont='';
										$ctapres='';
										//echo "<br>fondo".$_POST[fondosols][$x];
										if($_POST[fondosols][$x]>0)
		 								{
		  									$sqlrins="insert into  humnomina_saludpension (id_nom, tipo, empleado, tercero, cc, valor, estado,sector) values($id,'FS','".$_POST[ccemp][$x]."','$afp','".$_POST[centrocosto][$x]."',".$_POST[fondosols][$x].",'S','$sector')";
											mysql_query($sqlrins,$linkbd);
		  									$sqlr="select distinct *from humparafiscales_det where  humparafiscales_det.codigo='$_POST[tpensionemp]' and humparafiscales_det.CC='".$_POST[centrocosto][$x]."' and humparafiscales_det.vigencia='$vigusu' and  humparafiscales_det.sector='$tipoafp'";
											$resph=mysql_query($sqlr,$linkbd);
											//echo "<br>FONDO: $sqlr";
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
														$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$tercero."','".$_POST[centrocosto][$x]."','APORTE FONDO SOLIDARIDAD EMPLEADO Mes ".strtoupper(strftime('%B',$lastday))."','',".$debito.",".$credito.",'1','".$vigusu."')";
														mysql_query($sqlr,$linkbd);
														//echo "<br>FONDO1: $sqlr";
														$ctasalud=$ctacont;
				  									}
				  									if($cuentas[$cta][1]=='N' && $cuentas[$cta][3]=='S')
				  									{			
			  											$credito=$_POST[fondosols][$x];
														$debito=0;
														$tercero=$afp;
														$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$tercero."','".$_POST[centrocosto][$x]."','APORTE FONDO SOLIDARIDAD EMPLEADO Mes ".strtoupper(strftime('%B',$lastday))."','',".$debito.",".$credito.",'1','".$vigusu."')";
														mysql_query($sqlr,$linkbd);
														//echo "<br>FONDO2: $sqlr";
														$ctasalud=$ctacont;				  
				  									}
			   									}
											}
		 								}
										//******** FIN FONDO SOLIDARIDAD EMPLEADO ****		
										//********OTROS DESCUENTOS EMPLEADO *****
										$ctacont='';
										$ctapres='';
										//	echo "<br>desc".$_POST[otrasretenciones][$x];
										if($_POST[otrasretenciones][$x]>0)
		 								{
											$sqlr="select *from humretenempleados where humretenempleados.empleado='".$_POST[ccemp][$x]."' and humretenempleados.sncuotas>0 and habilitado='H' and estado='S'";		
											$respli=mysql_query($sqlr,$linkbd);
											//echo "<br>$sqlr";
											while ($rowh=mysql_fetch_row($respli)) 
											{
												$valorlibranza=$rowh[8];
												$sqlr="select distinct *from humvariablesretenciones,humvariablesretenciones_det where humvariablesretenciones.codigo='".$rowh[2]."' and humvariablesretenciones.codigo=humvariablesretenciones_det.codigo";
												$respr=mysql_query($sqlr,$linkbd);
												//echo "<br>$sqlr";
												while ($rowr=mysql_fetch_row($respr)) 
												{						
				  									$ctacont=$rowr[8];	 
				 									if('S'==$rowr[9])
				  									{
														$debito=$valorlibranza;
														$credito=0;
				 										$sqlret="INSERT INTO  humnominaretenemp (id_nom, id, cedulanit, fecha, descripcion, valor, ncta, estado) values($id,$rowh[0],'$rowh[4]','$fechaf','$rowh[1]',$debito,".($rowh[6]-$rowh[7]+1).",'S')";
				  										mysql_query($sqlret,$linkbd);
				 										// echo "<br>".$sqlret;
				  									}
				 									if('S'==$rowr[10])
				   									{
														$credito=$valorlibranza;
														$debito=0;
													}				 				 
													$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('4 $id','$ctacont','$rowr[2]','".$_POST[centrocosto][$x]."','DESCUENTO $rowr[1] Mes ".strtoupper(strftime('%B',$lastday))."','','$debito','$credito','1','$vigusu')";
													mysql_query($sqlr,$linkbd);
													//echo "<br>$sqlr";
												}
											}
			   							}				
										//******** FIN otros descuentos EMPLEADO ****
										//****OTRAS RETENCIONES ******		
										//$sqlr="UPDATE humretenempleados SET SNCUOTAS=SNCUOTAS-1 where estado='S' and empleado='".$_POST[ccemp][$x]."' and CONCAT(YEAR(fecha),'-',MONTH(fecha))<='".$vigusu."-$_POST[periodo]' and sncuotas>0";				
										//$sqlr="UPDATE humretenempleados SET SNCUOTAS=SNCUOTAS-1 where estado='S' and empleado='".$_POST[ccemp][$x]."' and sncuotas>0";				
										//$resp2 = mysql_query($sqlr,$linkbd);
	 									//$row2 =mysql_fetch_row($resp2);
		 								//$sqlr="UPDATE humretenempleados SET estado='P' where estado='S' and empleado='".$_POST[ccemp][$x]."'  and sncuotas<=0";
	 									//$resp2 = mysql_query($sqlr,$linkbd);
	 									//$row2 =mysql_fetch_row($resp2);
										//*****************************
										//******** SALUD EMPLEADOR *******
										$ctacont='';
										$ctapres='';	
										//$sector=buscasector($_POST[ccemp][$x]);	
										$sqlrins="insert into  humnomina_saludpension (id_nom, tipo, empleado, tercero, cc, valor, estado) values($id,'SR','".$_POST[ccemp][$x]."','$eps','".$_POST[centrocosto][$x]."',".$_POST[saludemprete][$x].",'S')";
										mysql_query($sqlrins,$linkbd);
										$sqlr="select distinct *from humparafiscales_det where  humparafiscales_det.codigo='$_POST[tsaludemr]' and humparafiscales_det.CC='".$_POST[centrocosto][$x]."' and humparafiscales_det.vigencia='$vigusu' ";
										$resph=mysql_query($sqlr,$linkbd);
										//echo "<br>$sqlr ";
										while ($rowh =mysql_fetch_row($resph)) 
										{
											//echo "<br>cc: ".$rowh[2]."  CCe:".$_POST[centrocosto][$x];											
											//echo "<br>sector: ".$rowh[7];					
											//$ctacont=$rowh[3];	 
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
													$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$eps."','".$_POST[centrocosto][$x]."','APORTE SALUD EMPLEADOR Mes ".strtoupper(strftime('%B',$lastday))."','',".$debito.",".$credito.",'1','".$vigusu."')";
													mysql_query($sqlr,$linkbd);
													//echo "<br>$sqlr ";
				   								}							 				 
				 								if($cuentas[$cta][1]=='N' && $cuentas[$cta][3]=='S')
				  								{
													//echo "<br>$sqlr ";
													$credito=$_POST[saludemprete][$x];
													$debito=0;
													$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$eps."','".$_POST[centrocosto][$x]."','APORTE SALUD EMPLEADOR Mes ".strtoupper(strftime('%B',$lastday))."','',".$debito.",".$credito.",'1','".$vigusu."')";
													mysql_query($sqlr,$linkbd);									
													//echo "<br>$sqlr ";
				   								}	 		  
				  							}
										}
			 							//**************FIN SALUD EMPLEADOR		
										//******** PENSIONES EMPLEADOR *******
										$ctacont='';
										$ctapres='';		
										$sqlrins="insert into  humnomina_saludpension (id_nom, tipo, empleado, tercero, cc, valor, estado,sector) values($id,'PR','".$_POST[ccemp][$x]."','$afp','".$_POST[centrocosto][$x]."',".$_POST[pensionemprete][$x].",'S','$sector')";
										mysql_query($sqlrins,$linkbd);
										//echo "<br>$sqlrins ";
										$sqlr="select distinct *from humparafiscales_det where  humparafiscales_det.codigo='$_POST[tpensionemr]' and humparafiscales_det.CC='".$_POST[centrocosto][$x]."' and humparafiscales_det.vigencia='$vigusu'  and sector='".$tipoafp."'  and  humparafiscales_det.sector='$tipoafp'";
										$resph=mysql_query($sqlr,$linkbd);
										//echo "<br>$sqlr - $tipoafp";
										while ($rowh =mysql_fetch_row($resph)) 
										{
											//$ctacont=$rowh[3];	 
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
													$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$afp."','".$_POST[centrocosto][$x]."','APORTE PENSIONES EMPLEADOR Mes ".strtoupper(strftime('%B',$lastday))."','',".$debito.",".$credito.",'1','".$vigusu."')";
													mysql_query($sqlr,$linkbd);
						 						}				
	 											if($cuentas[$cta][1]=='N' && $cuentas[$cta][3]=='S')
						 						{			 				 
						 							$credito=$_POST[pensionemprete][$x];
						 							$debito=0;
						 							$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$afp."','".$_POST[centrocosto][$x]."','APORTE PENSIONES EMPLEADOR Mes ".strtoupper(strftime('%B',$lastday))."','',".$debito.",".$credito.",'1','".$vigusu."')";
						 							mysql_query($sqlr,$linkbd);	
													//echo "<br>$sqlr ";						
						 						}
											}
				 						}
			 							//**************FIN PENSION EMPLEADOR					 
			 							//******ARP ******			 
										$ctacont='';
										$ctapres='';		
										$sqlr="select distinct *from humparafiscales_det inner join humparafiscales on humparafiscales_det.codigo=humparafiscales.codigo  where  humparafiscales_det.codigo='$_POST[tarp]' and humparafiscales_det.CC='".$_POST[centrocosto][$x]."' and humparafiscales_det.vigencia='$vigusu'";
										$resph=mysql_query($sqlr,$linkbd);		
										//	echo "<br>$sqlr ";
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
													$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('4 $id','$ctacont.','$arp','".$_POST[centrocosto][$x]."','APORTE ARP EMPLEADOR Mes ".strtoupper(strftime('%B',$lastday))."','','$debito','$credito','1','$vigusu')";
													mysql_query($sqlr,$linkbd);
												}	
												if($cuentas[$cta][1]=='N' && $cuentas[$cta][3]=='S')
					  							{
													$credito=$_POST[arpemp][$x];
													$debito=0;
													$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$arp."','".$_POST[centrocosto][$x]."','APORTE ARP EMPLEADOR Mes ".strtoupper(strftime('%B',$lastday))."','',".$debito.",'".$credito."','1','".$vigusu."')";
													mysql_query($sqlr,$linkbd);		
					  							}
												//$sqlr="insert into humnomina_parafiscales (id_nom, id_parafiscal, porcentaje, valor, cc) values ($id,'06',$rowh[13],$debito,'".$_POST[centrocosto][$x]."')";			
												//mysql_query($sqlr,$linkbd);		
												//echo "<br>$sqlr ";								
												//$sqlr="insert into humnomina_parafiscales (id_nom, id_parafiscal, porcentaje, valor, cc) values ($id,'06',$rowh[14],$debito,'".$_POST[centrocosto][$x]."')";			
												//mysql_query($sqlr,$linkbd);			 		 
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
											$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$_POST[ccemp][$x]."','".$_POST[centrocosto][$x]."','PROVISION CESANTIAS EMPLEADO Mes ".strtoupper(strftime('%B',$lastday))."','',".$debito.",".$credito.",'1','".$vigusu."')";
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
											$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$_POST[ccemp][$x]."','".$_POST[centrocosto][$x]."','PROVISION CESANTIAS EMPLEADO Mes ".strtoupper(strftime('%B',$lastday))."','',".$debito.",".$credito.",'1','".$vigusu."')";
											mysql_query($sqlr,$linkbd);
											//echo "<br>$sqlr";
											$ctapension=$ctacont;
										}*/			 		
										//******** FIN INTERESES CESANTIAS EMPLEADO ****	
					
									} //***fin exclusion		
								}//**FIN DEL FOR DE EMPLEADOS
	 						}
	 	 					//***********PARAFISCALES ******
		 					//****ARP DETALLE PARAFISCALES
							//$sqlr="insert into humnomina_parafiscales (id_nom, id_parafiscal, porcentaje, valor, cc) values ($id,'06',$rowh[13],$debito,'".$_POST[centrocosto][$x]."')";			
							//mysql_query($sqlr,$linkbd);			 		 
		 					//*****		 
			 				//CAJAS DE COMPENSACION
	 						$sqlr="select *from centrocosto where estado='S'";
	 						$rescc=mysql_query($sqlr,$linkbd);
							//echo "<br>$sqlr";
							while ($rowcc =mysql_fetch_row($rescc)) 
	 						{
								$ctacont='';
								$ctapres='';		
		  						if($pf[$_POST[tcajacomp]][$rowcc[0]]>0)
		   						{			
									$sqlr="select distinct *from humparafiscales_det  inner join humparafiscales on humparafiscales_det.codigo=humparafiscales.codigo where  humparafiscales_det.codigo='$_POST[tcajacomp]' and humparafiscales_det.CC='$rowcc[0]' and humparafiscales_det.vigencia='$vigusu'";
									$resph=mysql_query($sqlr,$linkbd);		
									//	echo "<br>$sqlr ";
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
												//echo "<br>$sqlr ";
					  						}
					  						if($cuentas[$cta][1]=='N' && $cuentas[$cta][3]=='S')
					  						{
												$credito=$pf[$_POST[tcajacomp]][$rowcc[0]];
												$debito=0;				  	 							 				 
												$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$_POST[cajacomp]."','".$rowcc[0]."','APORTE CAJA COMPENSACION Mes ".strtoupper(strftime('%B',$lastday))."','',".$debito.",".$credito.",'1','".$vigusu."')";
												mysql_query($sqlr,$linkbd);	
												//	echo "<br>$sqlr ";
					  						}						
										}
									//***nomina parafiscales
									$sqlr="insert into humnomina_parafiscales (id_nom,id_parafiscal,porcentaje,valor,cc,estado) values ($id,'$_POST[tcajacomp]',$rowh[14],".$pf[$_POST[tcajacomp]][$rowcc[0]].",'$rowcc[0]','S')";			
									mysql_query($sqlr,$linkbd);											
				   				}
							}
	 					}
						//*************FIN CAJAS DE COMP
			 			//ICBF
		 				$sqlr="select *from centrocosto where estado='S'";
	 					$rescc=mysql_query($sqlr,$linkbd);
						//echo "<br>$sqlr";
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
											$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('4 $id','$ctacont','$_POST[icbf]','$rowcc[0]','APORTE ICBF Mes ".strtoupper(strftime('%B',$lastday))."','','$debito','$credito','1','$vigusu')";
											mysql_query($sqlr,$linkbd);
										}
					 					if($cuentas[$cta][1]=='N' && $cuentas[$cta][3]=='S')
					  					{
											$debito=$pf[$_POST[ticbf]][$rowcc[0]];
											$credito=0;				  	 						 				 
											$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('4 $id','$ctacont','$_POST[icbf]','$rowcc[0]','APORTE ICBF Mes ".strtoupper(strftime('%B',$lastday))."','',0,'$debito','1','$vigusu')";
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
						//echo "<br>$sqlr";
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
											$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('4 $id','$ctacont','$_POST[sena]','$rowcc[0]','APORTE SENA Mes ".strtoupper(strftime('%B',$lastday))."','',".$debito.",0,'1','".$vigusu."')";
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
						//echo "<br>$sqlr";
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
											$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('4 $id','$ctacont','$_POST[iti]','$rowcc[0]','APORTE INST TECNICOS Mes ".strtoupper(strftime('%B',$lastday))."','','$debito',0,'1','$vigusu')";
											mysql_query($sqlr,$linkbd);
					  					}
										if($cuentas[$cta][1]=='N' && $cuentas[$cta][3]=='S')
					  					{
											$debito=$pf[$_POST[titi]][$rowcc[0]];
											$credito=0;						  
											$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('4 $id','$ctacont','$_POST[iti]','$rowcc[0]','APORTE INST TECNICOS Mes ".strtoupper(strftime('%B',$lastday))."','',0,'$debito','1','$vigusu')";
											mysql_query($sqlr,$linkbd);											
					   					}
									}
		   							//***nomina parafiscales
									$sqlr="insert into humnomina_parafiscales (id_nom, id_parafiscal, porcentaje, valor, cc, estado) values ('$id','$_POST[titi]','$rowh[14]','$debito','$rowcc[0]', 'S')";			
									mysql_query($sqlr,$linkbd);										
								}
		   					}
	 					}
						//*************FIN ITI		
						//ESAP********
	 					$sqlr="select *from centrocosto where estado='S'";
	 					$rescc=mysql_query($sqlr,$linkbd);
						//	 echo "<br>$sqlr";
					 	while ($rowcc =mysql_fetch_row($rescc)) 
	 					{
							$ctacont='';
							$ctapres='';
							//		 echo "<br>ESAP $rowcc[0]: ".$pf['05'][$rowcc[0]]." d:".$pf[$_POST[tesap]][$rowcc[0]];
		 					if($pf[$_POST[tesap]][$rowcc[0]]>0)
		   					{			
								$sqlr="select distinct *from humparafiscales_det inner join humparafiscales on humparafiscales_det.codigo=humparafiscales.codigo where  humparafiscales_det.codigo='$_POST[tesap]' and humparafiscales_det.CC='$rowcc[0]' and humparafiscales_det.vigencia='$vigusu'";
								$resph=mysql_query($sqlr,$linkbd);		
								// echo "<br>$sqlr";
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
											$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('4 $id','$ctacont','$_POST[esap]','$rowcc[0]','APORTE ESAP Mes ".strtoupper(strftime('%B',$lastday))."','','$debito',0,'1','$vigusu')";
											mysql_query($sqlr,$linkbd);
					  					}
  					 					if($cuentas[$cta][1]=='N' && $cuentas[$cta][3]=='S')
					  					{
											$debito=$pf[$_POST[tesap]][$rowcc[0]];
											$credito=0;
											$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('4 $id','$ctacont','$_POST[esap]','$rowcc[0]','APORTE ESAP Mes ".strtoupper(strftime('%B',$lastday))."','',0,'$debito','1','$vigusu')";
											mysql_query($sqlr,$linkbd);	
											//***nomina parafiscales
					  					}						
				   					}
				   					$sqlr="insert into humnomina_parafiscales (id_nom,id_parafiscal,porcentaje,valor,cc,estado) values ($id,'$_POST[tesap]',$rowh[14],$debito,'$rowcc[0]','S')";			
									mysql_query($sqlr,$linkbd);								
								}
		   					}
	 					}
						//*************FIN ESAP	
						//ARP********
						$sqlr="select *from centrocosto where estado='S'";
	 					$rescc=mysql_query($sqlr,$linkbd);
						//echo "<br>$sqlr";
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
						echo"<script>despliegamodalm('visible','3','Registros Exitosos:$cex   -   Registros Erroneos: $cerr');</script>";
						//***** crea la solicitud de cdp *************
						foreach($pfcp as $k => $valrubros)
		 				{
  							$ncta=existecuentain($k);
							$sqlrp="insert into humnom_presupuestal (id_nom,cuenta,valor,estado) values ($id,$k,$valrubros,'S')";
  							//mysql_query($sqlrp,$linkbd);	
						 }	
						for($rb=0;$rb<count($_POST[rubrosp]);$rb++)
		 				{
  							//$ncta=existecuentain($_POST[rubrosp][$rb]);
							$valrubros=$_POST[vrubrosp][$rb];
							$sqlrp="insert into humnom_presupuestal (id_nom,cuenta,valor,estado) values ($id,'".$_POST[rubrosp][$rb]."',$valrubros,'S')";
  							mysql_query($sqlrp,$linkbd);	
							//echo "<br>".$sqlrp;
		 				}		 	
					} 
					echo "<script>funcionmensaje();</script>";
  				}	
				else
				{
				echo "<script>despliegamodalm('visible','2','LIQUIDACION DE NOMINA EXISTENTE PARA ESTOS PARAMETROS');</script>";
				}
			}
			?>
		</form>
	</body>
</html>