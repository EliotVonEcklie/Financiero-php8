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
			function guardar()
			{
				if (document.form2.tperiodo.value!='-1' && document.form2.periodo.value!='-1')
  				{despliegamodalm('visible','4','Esta Seguro de Guardar','1')}
  				else{despliegamodalm('visible','2','Faltan datos para completar el registro');}
			}
			function validar(formulario)
			{
				document.form2.cperiodo.value='2';
				document.form2.action="hum-primanavidad.php";
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
 				vvigencias=document.getElementsByName('empleadosex[]');
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
			function funcionmensaje(){document.location.href = "";}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.form2.oculto.value=2;
								document.form2.cperiodo.value=2;
								document.form2.submit();break;
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
                <td colspan="3" class="cinta"><a href="hum-primanavidad.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a><a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar"/></a><a href="hum-primanavidadbuscar.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a><a href="#" onClick="mypop=window.open('hum-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a><a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png" title="Imprimir"></a><a href="#" onClick='excell()' class="mgbt"><img src="imagenes/excel.png"  title="Excel"></a></td>
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
			$linkbd=conectar_bd();
				if($_POST[anticipo]=='S'){$chkant=' checked ';}
				$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
				$_POST[vigencia]=$vigusu;
				if($_POST[oculto]=="")
				{
					$_POST[tabgroup1]=1;
					$sqlr="select max(id_nom) from humnomina";
					$res=mysql_query($sqlr,$linkbd);
					$consec=0;
					while($r=mysql_fetch_row($res)){$consec=$r[0];}
	 				$consec+=1;
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
						$_POST[tprimanav]=$row[3];
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
                    <td class="titulos" colspan="8">:: Liquidar Prima Navidad</td>
                    <td class="cerrar" style="width:7%;"><a href="hum-principal.php">&nbsp;Cerrar</a></td>
      			</tr>
      			<tr>
                	<td class="saludo1">No Liquidacion</td>
                    <td>
                        <input type="hidden" id="aprueba" name="aprueba" value="<?php echo $_POST[aprueba] ?>">
                        <input type="hidden" id="naprueba" name="naprueba" value="<?php echo $_POST[naprueba] ?>">
						<input type="hidden" id="naprueba" name="tprimanav" value="<?php echo $_POST[tprimanav] ?>">
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
						$sqlr="select *from admfiscales where vigencia='".$vigusu."'";
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
						//echo $sqlr;
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
										//$_POST[diasperiodo]=$row[2];
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
                    	<input name="diasperiodo" type="text" id="diasperiodo" value="360" size="5" readonly>
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
								<tr><td colspan='21' class='titulos'>.: Resultados Busqueda: $ntr Empleados</td></tr>
								<tr>
									<td  class='titulos2'>Id</td>
									<td class='titulos2' >EMPLEADO</td>
									<td class='titulos2' width='2%'>Doc Id</td>
									<td class='titulos2' >FECHA INGRESO</td>
									<td class='titulos2' >SAL BAS</td>
									<td class='titulos2' >DIAS LIQ</td>
									<td class='titulos2' >DEVENGADO</td>
									<td class='titulos2' >AUX ALIM</td>
									<td class='titulos2' >AUX TRAN</td>
									<td class='titulos2' >1/12 P.S.</td>
									<td class='titulos2' >1/12 P.V.</td>
									<td class='titulos2' >TOT DEV</td>
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
								$iter="zebra1";
								$iter2="zebra2";
								$sqlr="select *from terceros inner join terceros_nomina on terceros.cedulanit=terceros_nomina.cedulanit where terceros.estado='S' and terceros.empleado='1' and terceros_nomina.cc LIKE '%".$_POST[cc]."%' AND terceros_nomina.estado='S' order by terceros.apellido1,terceros.apellido2,terceros.nombre1,terceros.nombre2";
								$resp = mysql_query($sqlr,$linkbd);
								$ntr = mysql_num_rows($resp);
								$con=0;
								$totalparafiscales=0;
								while ($row =mysql_fetch_row($resp)) 
	 							{
									$sqlr="select terceros_nomina.cargo, humnivelsalarial.nombre, humnivelsalarial.valor, terceros_nomina.fondopensionestipo from terceros_nomina inner join humnivelsalarial on terceros_nomina.cargo=humnivelsalarial.id_nivel where terceros_nomina.cedulanit=$row[12] ";
								 	$resp2 = mysql_query($sqlr,$linkbd);
									$row2 =mysql_fetch_row($resp2);
									$valordia=$row2[2]/360;								
									$diaspagnorm=$_POST[diast][$con];
									$valordianov=0;
									$auxalim=0;
									$auxtra=0;
									$otrasrete=0;
									$totalretenciones=0;
									$diaslab=$_POST[diast][$con];
	 								$chk='';
									$ch=esta_en_array($_POST[empleados],$row[12]);
									//$auxalim=$_POST[alim];
									//$auxtra=$_POST[transp];
			 						if($row2[2]<=$_POST[balim]){$auxalim=$_POST[alim]; }
									if($row2[2]<=$_POST[btrans]){$auxtra=$_POST[transp];} 
									$style="";		
									$auxtratot=$auxtra;
 	 								$auxalimtot=$auxalim;
									// echo "aa:".$_POST[alim];	 								
									$salario=$row2[2]; 
									$tipofondopension=$row2[3];
									
	 								if($_POST[diast][$con]>360 || $_POST[diast][$con]<0 || $_POST[diast][$con]=='')
	 								{$_POST[diast][$con]=$_POST[diasperiodo];}
	 								
	 								$rsalud=0;
									$rpension=0;
									$otrasrete=0;
									$fondosol=0;
									$varp=0;	 
									 
     								//$vdv=round($valordianov*$_POST[diasnov][$con],0);
	 								$deven=$salario;
	 								
									//$totdev=$deven+$auxalimtot+$auxtratot+$horex; 
	 	 							//**devengado
									$sqlr="select * from  humvariables_det where codigo='$_POST[tprimanav]' and cc='".$row[31]."' and estado='S' and vigencia='$vigusu'";
									$resrp = mysql_query($sqlr,$linkbd);
									$rowrp =mysql_fetch_row($resrp);
									$ctapresnomina=$rowrp[7];
									$pfcp[$ctapresnomina]+= $deven; 
	 	 							//**alimentacion
									$sqlr="select * from  humvariables_det where codigo='$_POST[tprimanav]' and cc='".$row[31]."' and estado='S' and vigencia='$vigusu'";
									$resrp = mysql_query($sqlr,$linkbd);
									$rowrp =mysql_fetch_row($resrp);
									$pfcp[$rowrp[7]]+= $auxalimtot;
		 							//**transporte
									$sqlr="select * from  humvariables_det where codigo='$_POST[tprimanav]' and cc='".$row[31]."' and estado='S' and vigencia='$vigusu'";
									$resrp = mysql_query($sqlr,$linkbd);
									$rowrp =mysql_fetch_row($resrp);
									$pfcp[$rowrp[7]]+= $auxtratot;		
									//****
									//****DOCEAVAS
									$pfcp[$rowrp[7]]+=$_POST[doceavaps][$con]+$_POST[doceavapv][$con];
									//$bparafiscales2=round($deven2+$auxalimtot+$horex,-3); BASE COTIZACION COMPLETA
									$totdev=round(($deven+$auxalimtot+$auxtratot+$_POST[doceavaps][$con]+$_POST[doceavapv][$con])*$_POST[diast][$con]/360,0);
 	 								//$totalparafiscales+=$bparafiscales;
	 								echo "
									<tr  id='fila$row[12]' class='$iter' >
										<td>$con</td>																				
										<td><input type='hidden' name='nomemp[]' value='".strtoupper($row[3])." ".strtoupper($row[4])." ".strtoupper($row[1])." ".strtoupper($row[2])."' >".strtoupper($row[3])." ".strtoupper($row[4])." ".strtoupper($row[1])." ".strtoupper($row[2])."</td>
										<td><input type='hidden' name='ccemp[]' value='$row[12]'>$row[12] </td>
										<td><input type='hidden' name='fechaing[]' value='$row[23]'>$row[23] </td>
										<td><input type='hidden' name='centrocosto[]' value='".$row[31]."' size='8' readonly><input type='text' name='salbas[]' value='$salario' size='8' readonly></td>
										<td><input type='text' size='2' name='diast[]' value='".$_POST[diast][$con]."'  onKeyPress='javascript:return solonumeros(event)' onKeyUp='return tabular(event,this)'  onBlur='validar()' ></td>
										<td><input type='text' size='8' name='devengado[]' value='".($deven)."' readonly> </td>
										<td><input type='text' size='5' name='ealim[]' value='".($auxalimtot)."' readonly></td>
										<td><input type='text' size='5' name='etrans[]' value='".($auxtratot)."' readonly></td>
										<td><input type='text' name='doceavaps[]' value='".($_POST[doceavaps][$con]+0)."' size='8' > </td>
										<td><input type='text' name='doceavapv[]' value='".($_POST[doceavapv][$con]+0)."' size='8' > </td>
										<td><input type='text' name='totaldev[]' value='$totdev' size='8' readonly></td>																
									</tr>";
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
									//$_POST[totalnetopago]+=$totalneto;
									$con+=1;
									$aux=$iter;
									$iter=$iter2;
									$iter2=$aux;
								}
  							}
 						
							echo "
							<tr class='saludo3'>
								<td colspan='6'></td>
								<td><input type='hidden' name='totaldevini' value='$_POST[totaldevini]'>".number_format($_POST[totaldevini],2)."</td>
								<td><input type='hidden' name='totalauxalim' value='$_POST[totalauxalim]'>".number_format($_POST[totalauxalim],2)."</td>
								<td><input type='hidden' name='totalauxtra' value='$_POST[totalauxtra]'>".number_format($_POST[totalauxtra],2)."</td>
								<td><input type='hidden' name='totaldoceavaps' value='".array_sum($_POST[doceavaps])."'>".array_sum($_POST[doceavaps])."</td>
								<td><input type='hidden' name='totaldoceavapn' value='".array_sum($_POST[doceavapv])."'>".array_sum($_POST[doceavapv])."</td>
								<td><input type='hidden' name='totalnetopago' value='".array_sum($_POST[totaldev])."'>".array_sum($_POST[totaldev])."</td>
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
                          	</tr>
							<?php
								$totalrubro=0;
								foreach($pfcp as $k => $valrubros)
 								{
  									$ncta=existecuentain($k);
  									if($valrubros>0)
  									{
 										echo "
										<tr class='saludo3'>
											<td><input type='hidden' name='rubrosp[]' value='$k'>$k</td>
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
                                <td class="titulos">Fecha Inicio</td>
                                <td class="titulos">Fecha Final</td>
                                <td class="titulos">Dias Novedad Mes</td>
                                <td class="titulos">Tipo Novedad</td>                                
                          	</tr>
       						<?php
	   							$co="zebra1s";
	   							$co2="zebra2s";
								$tnov=array("g"=>"Enfermedad General","p"=>"Enfermedad Profesional");
	   							$sqlr="select *from humincapacidades where vigencia=$vigusu and mes=$_POST[periodo] and estado='S' ";
	   							$res=mysql_query($sqlr,$linkbd);
	   							$con=1;
								//echo $sqlr;
	   							while($row=mysql_fetch_row($res))
	    						{
									//echo $sqlr; 3214189433 luz amparo saludcoop
		 							if(1==esta_en_array($_POST[ccemp],$row[2]))
			 							{			  	 
			  							  echo "<tr class='$co'>
												<td>$row[0]</td>
												<td>$row[2]</td>
												<td>".buscatercero($row[2])."</td>
												<td>".mesletras($row[5])."</td>
												<td>$row[3]</td>
												<td>$row[4]</td>
												<td>$row[4]</td>
												<td>".$tnov[$row[7]]."</td>												
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
		 							if(1==esta_en_array($_POST[ccemp],$row[4]))
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
 						if($rval[0]<=0)
 						{
  							ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
							$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
  							$sqlr="insert into humnomina (`fecha`, `periodo`, `mes`, `diasp`, `mesnum`, `cc`, `vigencia`, `estado`) values ('$fechaf','$_POST[tperiodo]','$_POST[periodo]','$_POST[diasperiodo]','$_POST[mesnum]','$_POST[cc]','".$vigusu."','S')";
  							if (!mysql_query($sqlr,$linkbd))
							{
								
	 							echo "<script>despliegamodalm('visible','2','Manejador de Errores de la Clase BDTsaltoTNo se pudo ejecutar la petición:');</script>";
							}
  							else
  							{
	 							$id=mysql_insert_id();
								$sqlr="insert into  humnomina_prima (id_nom,fecha,estado) values($id,'$fechaf','S')";
								mysql_query($sqlr,$linkbd);
	 							/*$sqlr="insert into humnomina_aprobado (id_nom,fecha,id_rp,persoaprobo,estado) values ($id,'$fechaf',$_POST[rp], '$_SESSION[usuario]', 'S')";
	 							if (!mysql_query($sqlr,$linkbd))
	 							{echo "<table class='inicio'><tr><td class='saludo1'><center>No se Pudo Aprobrar la Nomina <img src='imagenes\alert.png'></center></td></tr></table>";}
	  							else
	  							{echo "<table class='inicio'> <tr><td class='saludo1'> <center>Registros Exitosos:$cex   -   Registros Erroneos: $cerr<img src='imagenes\confirm.png'></center></td></tr></table> "; }*/
	  							$lastday = mktime (0,0,0,$_POST[periodo],1,$vigusu);
	  							echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado la Liquidacion de la Nomina $id - Centro Costo:$_POST[cc] - Mes: ".strtoupper(strftime('%B',$lastday))." <img src='imagenes\confirm.png'></center></td></tr></table>";
								$cex=0;
								$cerr=0;
	 							$sqlr="insert into humcomprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito, diferencia,estado) values ($id,4,'$fechaf','CAUSACION PRIMA NAVIDAD $vigusu MES ".strtoupper(strftime('%B',$lastday))."',0,0,0,0,'1')";
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
				 						if('PR'==$rown[11]){$tipoafp="privado";}			 				 
				 						if('PB'==$rown[11]){$tipoafp='publico';}				 				 
									}				
									//*************************************		 
									$ch=esta_en_array($_POST[empleados],$_POST[ccemp][$x]);
	 								$sqlr="insert into humnomina_det (`id_nom`, `cedulanit`, `salbas`, `diaslab`, `devendias`, `ibc`, `auxalim`, `auxtran`, `valhorex`, `totaldev`, `salud`, `saludemp`, `pension`, `pensionemp`, `fondosolid`, `retefte`, `otrasdeduc`, `totaldeduc`, `netopagar`, `estado`,vac,diasarl) values ($id,'".$_POST[ccemp][$x]."',".$_POST[salbas][$x].",".$_POST[diast][$x].",".$_POST[devengado][$x].",".($_POST[ibc][$x]+0).",".($_POST[ealim][$x]+0).",".($_POST[etrans][$x]+0).",0,".$_POST[totaldev][$x].",".($_POST[saludrete][$x]+0).",".($_POST[saludemprete][$x]+0).",".($_POST[pensionrete][$x]+0).",".($_POST[pensionemprete][$x]+0).",".($_POST[fondosols][$x]+0).",0,".($_POST[otrasretenciones][$x]+0).",".($_POST[totalrete][$x]+0).",".($_POST[totaldev][$x]+0).",'S','$ch','".($_POST[diasnov][$x]+0)."')";
									//	 echo "<br>c:$ch  -   det:".$sqlr;
	  								if (!mysql_query($sqlr,$linkbd)){$cerr+=1;}
									else
									{
										$sqlr="insert into humnomina_prima_det (id_nom,tercero,diaslab,salbas,auxalim,auxtrans,doceavaps,doceavapv,totalprima,estado) values ($id,'".$_POST[ccemp][$x]."',".$_POST[diast][$x].",".$_POST[devengado][$x].",".($_POST[ealim][$x]+0).",".($_POST[etrans][$x]+0).",".($_POST[doceavaps][$x]+0).",".($_POST[doceavapv][$x]+0).",".($_POST[totaldev][$x]+0).",'S')";
										mysql_query($sqlr,$linkbd);
										$cex+=1;	
										$ctacont='';
										$ctapres='';
										//*****SALARIO *******
										$sqlr="select distinct *from humvariables,humvariables_det where  humvariables.codigo=humvariables_det.codigo and humvariables_det.modulo=2 and humvariables.codigo='$_POST[tprimanav]' and humvariables_det.CC='".$_POST[centrocosto][$x]."' and humvariables_det.vigencia='$vigusu'";
										$resph=mysql_query($sqlr,$linkbd);
										//echo "<br>$sqlr";
										while ($rowh =mysql_fetch_row($resph)) 
										{
											if($_POST[centrocosto][$x]==$rowh[9])
				 							{
				   								$ctacont=$rowh[10];	 
				   								$concepto=$rowh[6];	 
				 							}
											$cuentas=concepto_cuentas($concepto,'H',2,$_POST[centrocosto][$x]); 
											$tam=count($cuentas);
											for($cta=0;$cta<$tam;$cta++)
											{
				 								if($cuentas[$cta][1]=='N' && $cuentas[$cta][2]=='S'){$ctacont=$cuentas[$cta][0];}
				 								if($cuentas[$cta][1]=='N' && $cuentas[$cta][3]=='S'){$ctaconcepto=$cuentas[$cta][0];}
											}				
			   							}
										$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('4 $id','".$ctacont."','".$_POST[ccemp][$x]."','".$_POST[centrocosto][$x]."','Causacion PRIMA NAVIDAD $vigusu Mes ".strtoupper(strftime('%B',$lastday))."','',".$_POST[totaldev][$x].",0,'1','".$vigusu."')";
										mysql_query($sqlr,$linkbd);
										//echo "<br>$sqlr";
										$sqlr="insert into humcomprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('4 $id','".$ctaconcepto."','".$_POST[ccemp][$x]."','".$_POST[centrocosto][$x]."','Causacion PRIMA NAVIDAD $vigusu Mes ".strtoupper(strftime('%B',$lastday))."','',0,".$_POST[totaldev][$x].",'1','".$vigusu."')";
										mysql_query($sqlr,$linkbd);
										//echo "<br>$sqlr";
										//************ FIN SALARIO ********
								
			 
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
		}		 //**FIN DEL FOR DE EMPLEADOS
															
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
			echo "<br>".$sqlrp;
		 }		 	
	}
  }	
  else
  {
  echo "<script>despliegamodalm('visible','2','LIQUIDACION DE NOMINA EXISTENTE PARA ESTOS PARAMETROSTsaltoTNo se puede Generar: LIQUIDACION DE NOMINA EXISTENTE');</script>";
  }
}
?>
</form>
</td></tr>     
</table>
</body>
</html>