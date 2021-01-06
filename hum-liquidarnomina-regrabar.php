<?php //V 1000 12/12/16 ?> 
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
		<script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
		<script>
			function guardar()
			{
				if (document.form2.tperiodo.value!='' && document.form2.periodo.value!='')
  				{
					if (confirm("Esta Seguro de Guardar"))
  					{
  						document.form2.oculto.value=2;
  						document.form2.submit();
  					}
  				}
  				else { alert('Faltan datos para completar el registro');}
			}
			function validar(formulario)
			{
				document.form2.cperiodo.value='2';
				document.form2.action="hum-liquidarnomina-regrabar.php";
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
				document.form2.action="pdfplanillapago.php";
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
  				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='hum-liquidarnomina-regrabar.php'" class='mgbt'/><img src="imagenes/guardad.png" class="mgbt1"/><img src="imagenes/busca.png" title="Buscar" class='mgbt' onClick="location.href='hum-buscanominasaprobadas.php'"/><img src="imagenes/nv.png" title="Nueva Ventana" class='mgbt' onClick="mypop=window.open('hum-principal.php','','');mypop.focus();"/><img src="imagenes/reflejar1.png" title="Reflejar" class='mgbt' onClick="guardar()"/><img src="imagenes/print.png" title="imprimir" onClick="pdf()" class='mgbt'/><img src="imagenes/excel.png" title="Excel" onClick='excell()' class='mgbt'/><img src="imagenes/iratras.png" title="Retornar" onClick="location.href='hum-actualizardatos.php'" class='mgbt'/></td>
         	</tr>	
  		</table>
 		<form name="form2" method="post" action="">
			<?php
                $pf[]=array();
                $pfcp=array();	
            ?>
			<table  class="inicio" align="center" >
      		<tr>
        		<td class="titulos" colspan="10">:: Buscar Liquidaciones</td>
                <td class="cerrar" ><a href="hum-principal.php">Cerrar</a></td>
      		</tr>
      		<tr>
                <td class="saludo1">No Liquidacion</td>
                <td>
                	<select name="idliq" id="idliq" onChange="validar()" >
				  		<option value="-1">Sel ...</option>
						<?php
							$sqlr="Select *  from humnomina  ";
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
				  					ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $row[1],$fecha);
				  					$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
				  					$_POST[fecha]=$fechaf;
									$_POST[vigenomi]=$row[7];
				 				}
				 				else {echo "<option value='$row[0]'>$row[0]</option>";}	  
			     			}   
						?>
		  			</select>
            	</td>
                <td class="saludo1">Fecha</td>
                <td><input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10" size="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY">   <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a></td>
                <td class="saludo1">RP</td> 
                <td>
      				<select name="rp" id="rp" onChange="validar()" >
				  		<option value="-1">Sel ...</option>
				 		<?php
				 			$sqlr="Select humnom_rp.consvigencia, pptorp.valor, pptorp.idcdp, humnom_rp.vigencia  from humnom_rp inner join pptorp on humnom_rp.consvigencia=pptorp.consvigencia  where humnom_rp.estado='S' and humnom_rp.vigencia='$_POST[vigenomi]' and pptorp.vigencia='$_POST[vigenomi]'";
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
				 				}
				 	  			else {echo "<option value='$row[0]'>$row[0]</option>";}
			     			}   
						?>
		 			</select>
      				<input type="hidden" value="<?php echo $_POST[hvalorp]?>" name="hvalorp"/>
     				<input type="text" value="<?php echo number_format($_POST[valorp],2)?>" name="valorp" size="14" readonly/>
               	</td>
                <td class="saludo1">CDP:</td>
	 			<td><input type="text" id="cdp" name="cdp" value="<?php echo $_POST[cdp]?>" size="10" readonly></td>
          	</tr>
            <tr>
	 			<td class="saludo1">Detalle RP:</td>
	  			<td colspan="3"><input type="text" id="detallecdp" name="detallecdp" value="<?php echo $_POST[detallecdp]?>" size="50" readonly></td>
     			<td class="saludo1">Tercero:</td>
          		<td ><input id="tercero" type="text" name="tercero" size="10" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo $_POST[tercero]?>" ><input type="hidden" value="0" name="bt"><a href="#" onClick="mypop=window.open('terceros-ventana.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=900,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a></td>
          		<td colspan="6"><input id="ntercero" name="ntercero" type="text" value="<?php echo $_POST[ntercero]?>" size="80" readonly></td>
          	</tr>
	  		<tr>
            	<td class="saludo1">Valor RP:</td>
                <td><input type="text" id="valorrp" name="valorrp" value="<?php echo $_POST[valorrp]?>" size="15" onKeyUp="return tabular(event,this)" readonly></td>
                <td class="saludo1">Saldo:</td>
                <td><input type="text" id="saldorp" name="saldorp"  value="<?php echo $_POST[saldorp]?>" size="15" onKeyUp="return tabular(event,this)" readonly></td>
	  			<td class="saludo1" >Valor a Pagar:</td>
                <td><input type="text" id="valor" name="valor" value="<?php echo $_POST[valor]?>" size="15" readonly></td>
     		</tr>
      		<tr>
        		<td class="saludo1">Periodo Liquidar:</td>
        		<?php
					if(!$_POST[oculto])
					{
	 					$_POST[diast]=array();
	 					$_POST[devengado]=array();
	 					$_POST[empleados]=array();		 		
					}
					$sqlr="select *from admfiscales where vigencia='$_POST[vigenomi]'";
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
			 		}		
        		?>
				<td>
					<?php
						$sqlr="select sueldo, cajacompensacion,icbf,sena,iti,esap,arp,salud_empleador,salud_empleado,pension_empleador, pension_empleado,sub_alimentacion,aux_transporte,prima_navidad  from humparametrosliquida ";
						$resp = mysql_query($sqlr,$linkbd);
						while ($row =mysql_fetch_row($resp)) 
						{					 
							$_POST[psalmin]=$row[0];
							$_POST[pcajacomp]=$row[1];
							$_POST[picbf]=$row[2];
							$_POST[psena]=$row[3];
							$_POST[piti]=$row[4];
							$_POST[pesap]=$row[5];
					 		$_POST[parp]=$row[6];
							$_POST[psalud_empleador]=$row[7];		
							$_POST[psalud_empleado]=$row[8];
							$_POST[ppension_empleador]=$row[9];
							$_POST[ppension_empleado]=$row[10];
							$_POST[palim]=$row[11];
							$_POST[ptransp]=$row[12];		
							$_POST[pbfsol]=$_POST[ppension_empleado];	
							$_POST[tprimanav]=$row[13];		 
				 		}
					?>	 
                    <input id="cajacomp" name="cajacomp" type="hidden" value="<?php echo $_POST[cajacomp]?>" >
                    <input id="icbf" name="icbf" type="hidden" value="<?php echo $_POST[icbf]?>" >
                    <input id="sena" name="sena" type="hidden" value="<?php echo $_POST[sena]?>" >
                    <input id="esap" name="esap" type="hidden" value="<?php echo $_POST[esap]?>" >
                    <input id="iti" name="iti" type="hidden" value="<?php echo $_POST[iti]?>" >           
                    <input id="btrans" name="btrans" type="hidden" value="<?php echo $_POST[btrans]?>" >
                    <input id="balim" name="balim" type="hidden" value="<?php echo $_POST[balim]?>" >
                    <input id="bfsol" name="bfsol" type="hidden" value="<?php echo $_POST[bfsol]?>" >
                    <input id="transp" name="transp" type="hidden" value="<?php echo $_POST[transp]?>" >
                    <input id="alim" name="alim" type="hidden" value="<?php echo $_POST[alim]?>" >
                    <input id="salmin" name="salmin" type="hidden" value="<?php echo $_POST[salmin]?>" >  
                    <input id="tprimanav" name="tprimanav" type="hidden" value="<?php echo $_POST[tprimanav]?>" >    
		 			<input id="pcajacomp" name="pcajacomp" type="hidden" value="<?php echo $_POST[pcajacomp]?>" >
                    <input id="picbf" name="picbf" type="hidden" value="<?php echo $_POST[picbf]?>" >
                    <input id="psena" name="psena" type="hidden" value="<?php echo $_POST[psena]?>" >
                    <input id="pesap" name="pesap" type="hidden" value="<?php echo $_POST[pesap]?>" >
                    <input id="piti" name="piti" type="hidden" value="<?php echo $_POST[piti]?>" >           
                    <input id="psalud_empleado" name="psalud_empleado" type="hidden" value="<?php echo $_POST[psalud_empleado]?>" >
                    <input id="psalud_empleador" name="psalud_empleador" type="hidden" value="<?php echo $_POST[psalud_empleador]?>" >
                    <input id="ppension_empleador" name="ppension_empleador" type="hidden" value="<?php echo $_POST[ppension_empleador]?>" >
                    <input id="ppension_empleado" name="ppension_empleado" type="hidden" value="<?php echo $_POST[ppension_empleado]?>" >
                    <input id="pbfsol" name="pbfsol" type="hidden" value="<?php echo $_POST[pbfsol]?>" >
                    <input id="ptransp" name="ptransp" type="hidden" value="<?php echo $_POST[ptransp]?>" >
                    <input id="palim" name="palim" type="hidden" value="<?php echo $_POST[palim]?>" >
		 			<input id="psalmin" name="psalmin" type="hidden" value="<?php echo $_POST[psalmin]?>" >  
		 			<input id="parp" name="parp" type="hidden" value="<?php echo $_POST[parp]?>"/>  	
                    <input id="vigenomi" name="vigenomi" type="hidden" value="<?php echo $_POST[vigenomi]?>"/>  	
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
								else{echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}	  
			     			}   
						?>
		  			</select>
                    <input id="tperiodonom" name="tperiodonom" type="hidden" value="<?php echo $_POST[tperiodonom]?>" >
                    <input name="cperiodo" type="hidden" value="">
              	</td>
        		<td class="saludo1">Dias:</td>
        		<td><input name="diasperiodo" type="text" id="diasperiodo" value="<?php echo $_POST[diasperiodo]?>" size="5" readonly></td>
                <input name="oculto" type="hidden" value="1">
          		<td class="saludo1">CC:</td>
         		<td>
          			<select name="cc"  onChange="validar()" onKeyUp="return tabular(event,this)">
                        <option value='' <?php if(''==$_POST[cc]) echo "SELECTED"?>>Todos</option>
                        <?php
                            $sqlr="select *from centrocosto where estado='S'";
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
		  				if($_POST[tperiodo]=='1'){echo"  <input type='hidden' name='mesnum' value='1'>";}  
		 				if($_POST[tperiodo]=='2')
						{
							echo "
                            <select name='mesnum' id='mesnum'>
          						<option value='1'"; if($_POST[mesnum]=='1'){echo "selected";} echo">1 Quincena</option>
          						<option value='2'"; if($_POST[mesnum]=='2'){echo "selected";} echo">2 Quincena</option>
        					</select>";
						}
		   			?>
           		</td>
       		</tr>                       
    	</table>    
		<div class="subpantalla">
			<?php
				$listacuentas=array();
				$listanombrecuentas=array();
				$listaterceros=array();	
				$listanombreterceros=array();	
				$listaccs=array();
				$listadetalles=array();
				$listadebitos=array();
				$listacreditos=array();
				$listacajacf[]=array();
				$listasena[]=array();
				$listaicbf[]=array();
				$listainstecnicos[]=array();
				$listaesap[]=array();
				$listatipo[]=array();
                $crit1=$crit2=" ";
				$con=1;
				$sqlr="SELECT mes,vigencia FROM humnomina WHERE id_nom='$_POST[idliq]'";
				$resp = mysql_query($sqlr,$linkbd);
				$row =mysql_fetch_row($resp); 
				$mesnnomina=$row[0];
				$meslnomina=mesletras($row[0]);
				$vigenomina=$row[1]; 
                echo "
                <table class='inicio'>
					<tr><td colspan='89' class='titulos'>.: Detalles Comprobantes</td></tr>
					<tr>
						<td class='titulos2'>ITEM</td>
						<td class='titulos2'>CUENTA</td>
						<td class='titulos2'>NOMBRE CUENTA</td>
						<td class='titulos2'>TERCERO</td>
						<td class='titulos2'>NOMBRE TERCERO</td>
						<td class='titulos2'>CC</td>
						<td class='titulos2'>DETALLE</td>
						<td class='titulos2'>VLR. DEBITO</td>
						<td class='titulos2'>VLR. CREDITO</td>
					</tr>";
				$iter="zebra1";
				$iter2="zebra2";	
				$sqlr="SELECT cedulanit,totaldev,auxalim,auxtran,salud,saludemp,pension,pensionemp,fondosolid,otrasdeduc,arp,cajacf,sena,icbf, instecnicos,esap,tipofondopension FROM humnomina_det WHERE id_nom='$_POST[idliq]'";
				$resp = mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($resp)) 
				{
					$ccosto=buscaccnomina($row[0]);
					$empleado=buscatercero($row[0]);
					//Salarios
					$sqlrcp="SELECT DISTINCT concepto FROM humvariables_det WHERE modulo=2 AND codigo='$_POST[psalmin]' AND CC='$ccosto' AND vigencia='$vigenomina'";
					$respcp=mysql_query($sqlrcp,$linkbd);
					$rowcp =mysql_fetch_row($respcp);
					$sqlrcu="SELECT DISTINCT cuenta, debito, credito FROM conceptoscontables_det WHERE modulo='2' AND tipo='H' AND CC='$ccosto' AND tipocuenta='N' AND codigo='$rowcp[0]' ORDER BY credito";
					$respcu = mysql_query($sqlrcu,$linkbd);
					while ($rowcu =mysql_fetch_row($respcu)) 
					{
						if($rowcu[2]=='S'){$ctaconcepto=$rowcu[0];}
						if($rowcu[1]=='S'){$ctacont=$rowcu[0];}	 
					}
					//Cuenta debito salario empleado
					$nresul=buscacuenta($ctacont);
					echo "
					<tr class='$iter' >
						<td>$con</td>
						<td>$ctacont</td>
						<td>$nresul</td>
						<td>$row[0]</td>
						<td>$empleado</td>
						<td>$ccosto</td>
						<td>Causación Salario Mes $meslnomina </td>
						<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($row[1],0)."</td>
						<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
					</tr>";
					$listacuentas[]=$ctacont;
					$listanombrecuentas[]=$nresul;
					$listaterceros[]=$row[0];	
					$listanombreterceros[]=$empleado;	
					$listaccs[]=$ccosto;
					$listadetalles[]="Causación Salario Mes $meslnomina";
					$listadebitos[]=$row[1];
					$listacreditos[]=0;
					$listatipo[]="SL<->DB";
					$aux=$iter;
					$iter=$iter2;
					$iter2=$aux;
					$con+=1;
					//Cuenta credito salario empleado
					$nresul=buscacuenta($ctaconcepto);
					echo "
					<tr class='$iter'>
						<td>$con</td>
						<td>$ctaconcepto</td>
						<td>$nresul</td>
						<td>$row[0]</td>
						<td>$empleado</td>
						<td>$ccosto</td>
						<td>Causación Salario Mes $meslnomina</td>
						<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
						<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($row[1],0)."</td>
					</tr>";
					$listacuentas[]=$ctaconcepto;
					$listanombrecuentas[]=$nresul;
					$listaterceros[]=$row[0];	
					$listanombreterceros[]=$empleado;	
					$listaccs[]=$ccosto;
					$listadetalles[]="Causacion Salario Mes $meslnomina";
					$listadebitos[]=0;
					$listacreditos[]=$row[1];
					$listatipo[]="SL<->CR";
					$aux=$iter;
					$iter=$iter2;
					$iter2=$aux;
					$con+=1;
					//Auxilio Alimentacion
					if($row[2]!=0)
					{
						$sqlrcp="SELECT DISTINCT concepto FROM humvariables_det WHERE modulo=2 AND codigo='$_POST[palim]' AND CC='$ccosto' AND vigencia='$vigenomina'";
						$respcp=mysql_query($sqlrcp,$linkbd);
						$rowcp =mysql_fetch_row($respcp);
						$sqlrcu="SELECT DISTINCT cuenta, debito, credito FROM conceptoscontables_det WHERE modulo='2' AND tipo='H' AND CC='$ccosto' AND tipocuenta='N' AND codigo='$rowcp[0]' ORDER BY credito";
						$respcu = mysql_query($sqlrcu,$linkbd);
						while ($rowcu =mysql_fetch_row($respcu)) 
						{
							if($rowcu[2]=='S'){$ctaconcepto=$rowcu[0];}
							if($rowcu[1]=='S'){$ctacont=$rowcu[0];}	 
						}
						//Cuenta debito auxilio alimentacion
						$nresul=buscacuenta($ctacont);
						echo "
						<tr class='$iter' >
							<td>$con</td>
							<td>$ctacont</td>
							<td>$nresul</td>
							<td>$row[0]</td>
							<td>$empleado</td>
							<td>$ccosto</td>
							<td>Causación Aux Alimentacion Mes $meslnomina</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($row[2],0)."</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
						</tr>";
						$listacuentas[]=$ctacont;
						$listanombrecuentas[]=$nresul;
						$listaterceros[]=$row[0];	
						$listanombreterceros[]=$empleado;	
						$listaccs[]=$ccosto;
						$listadetalles[]="Causación Aux Alimentacion Mes $meslnomina";
						$listadebitos[]=$row[2];
						$listacreditos[]=0;
						$listatipo[]="AA<->DB";
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
						$con+=1;
						//Cuenta credito auxilio alimentacion
						$nresul=buscacuenta($ctaconcepto);
						echo "
						<tr class='$iter'>
							<td>$con</td>
							<td>$ctaconcepto</td>
							<td>$nresul</td>
							<td>$row[0]</td>
							<td>$empleado</td>
							<td>$ccosto</td>
							<td>Causación Aux Alimentacion Mes $meslnomina</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($row[2],0)."</td>
						</tr>";
						$listacuentas[]=$ctaconcepto;
						$listanombrecuentas[]=$nresul;
						$listaterceros[]=$row[0];	
						$listanombreterceros[]=$empleado;	
						$listaccs[]=$ccosto;
						$listadetalles[]="Causación Aux Alimentacion Mes $meslnomina";
						$listadebitos[]=0;
						$listacreditos[]=$row[2];
						$listatipo[]="AA<->CR";
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
						$con+=1;
					}
					//Auxilio transporte
					if($row[3]!=0)
					{
						$sqlrcp="SELECT DISTINCT concepto FROM humvariables_det WHERE modulo=2 AND codigo='$_POST[palim]' AND CC='$ccosto' AND vigencia='$vigenomina'";
						$respcp=mysql_query($sqlrcp,$linkbd);
						$rowcp =mysql_fetch_row($respcp);
						$sqlrcu="SELECT DISTINCT cuenta, debito, credito FROM conceptoscontables_det WHERE modulo='2' AND tipo='H' AND CC='$ccosto' AND tipocuenta='N' AND codigo='$rowcp[0]' ORDER BY credito";
						$respcu = mysql_query($sqlrcu,$linkbd);
						while ($rowcu =mysql_fetch_row($respcu)) 
						{
							if($rowcu[2]=='S'){$ctaconcepto=$rowcu[0];}
							if($rowcu[1]=='S'){$ctacont=$rowcu[0];}	 
						}
						//Cuenta debito auxilio transporte
						$nresul=buscacuenta($ctacont);
						echo "
						<tr class='$iter' >
							<td>$con</td>
							<td>$ctacont</td>
							<td>$nresul</td>
							<td>$row[0]</td>
							<td>$empleado</td>
							<td>$ccosto</td>
							<td>Causación Aux Transporte Mes $meslnomina</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($row[3],0)."</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
						</tr>";
						$listacuentas[]=$ctacont;
						$listanombrecuentas[]=$nresul;
						$listaterceros[]=$row[0];	
						$listanombreterceros[]=$empleado;	
						$listaccs[]=$ccosto;
						$listadetalles[]="Causación Aux Transporte Mes $meslnomina";
						$listadebitos[]=$row[3];
						$listacreditos[]=0;
						$listatipo[]="AT<->DB";
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
						$con+=1;
						//Cuenta credito auxilio transporte
						$nresul=buscacuenta($ctaconcepto);
						echo "
						<tr class='$iter'>
							<td>$con</td>
							<td>$ctaconcepto</td>
							<td>$nresul</td>
							<td>$row[0]</td>
							<td>$empleado</td>
							<td>$ccosto</td>
							<td>Causación Aux transporte Mes $meslnomina</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($row[3],0)."</td>
						</tr>";
						$listacuentas[]=$ctaconcepto;
						$listanombrecuentas[]=$nresul;
						$listaterceros[]=$row[0];	
						$listanombreterceros[]=$empleado;	
						$listaccs[]=$ccosto;
						$listadetalles[]="Causación Aux transporte Mes $meslnomina";
						$listadebitos[]=0;
						$listacreditos[]=$row[3];
						$listatipo[]="AT<->CR";
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
						$con+=1;
					}
					//Salud Empleado
					if($row[4]!=0)
					{
						$sqlrcp="SELECT DISTINCT concepto FROM humparafiscales_det WHERE codigo='$_POST[psalud_empleado]' AND CC='$ccosto' AND vigencia='$vigenomina'";
						$respcp=mysql_query($sqlrcp,$linkbd);
						$rowcp =mysql_fetch_row($respcp);
						$sqlrcu="SELECT DISTINCT cuenta, debito, credito FROM conceptoscontables_det WHERE modulo='2' AND tipo='H' AND CC='$ccosto' AND tipocuenta='N' AND codigo='$rowcp[0]' ORDER BY credito";
						$respcu = mysql_query($sqlrcu,$linkbd);
						while ($rowcu =mysql_fetch_row($respcu)) 
						{
							if($rowcu[2]=='S'){$ctaconcepto=$rowcu[0];}
							if($rowcu[1]=='S'){$ctacont=$rowcu[0];}	 
						}
						//Cuenta debito salud empleado
						$nresul=buscacuenta($ctacont);
						echo "
						<tr class='$iter'>
							<td>$con</td>
							<td>$ctacont</td>
							<td>$nresul</td>
							<td>$row[0]</td>
							<td>$empleado</td>
							<td>$ccosto</td>
							<td>Aporte Salud Empleado Mes $meslnomina</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($row[4],0)."</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
						</tr>";
						$listacuentas[]=$ctacont;
						$listanombrecuentas[]=$nresul;
						$listaterceros[]=$row[0];	
						$listanombreterceros[]=$empleado;	
						$listaccs[]=$ccosto;
						$listadetalles[]="Aporte Salud Empleado Mes $meslnomina";
						$listadebitos[]=$row[4];
						$listacreditos[]=0;
						$listatipo[]="SE<->DB";
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
						$con+=1;
						//Cuenta credito salud empleado
						$nresul=buscacuenta($ctaconcepto);
						$epsnit=buscadatofuncionario($row[0],'NUMEPS');
						$epsnom=buscadatofuncionario($row[0],'NOMEPS');
						echo "
						<tr class='$iter'>
							<td>$con</td>
							<td>$ctaconcepto</td>
							<td>$nresul</td>
							<td>$epsnit</td>
							<td>$epsnom</td>
							<td>$ccosto</td>
							<td>Aporte Salud Empleado Mes $meslnomina</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($row[4],0)."</td>
						</tr>";
						$listacuentas[]=$ctaconcepto;
						$listanombrecuentas[]=$nresul;
						$listaterceros[]=$epsnit;	
						$listanombreterceros[]=$epsnom;	
						$listaccs[]=$ccosto;
						$listadetalles[]="Aporte Salud Empleado Mes $meslnomina";
						$listadebitos[]=0;
						$listacreditos[]=$row[4];
						$listatipo[]="SE<->CR";
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
						$con+=1;
					}
					//Pension Empleado
					if($row[6]!=0)
					{
						$sqlrcp="SELECT DISTINCT concepto FROM humparafiscales_det WHERE codigo='$_POST[ppension_empleado]' AND CC='$ccosto' AND vigencia='$vigenomina'";
						$respcp=mysql_query($sqlrcp,$linkbd);
						$rowcp =mysql_fetch_row($respcp);
						$sqlrcu="SELECT DISTINCT cuenta, debito, credito FROM conceptoscontables_det WHERE modulo='2' AND tipo='H' AND CC='$ccosto' AND tipocuenta='N' AND codigo='$rowcp[0]' ORDER BY credito";
						$respcu = mysql_query($sqlrcu,$linkbd);
						while ($rowcu =mysql_fetch_row($respcu)) 
						{
							if($rowcu[2]=='S'){$ctaconcepto=$rowcu[0];}
							if($rowcu[1]=='S'){$ctacont=$rowcu[0];}	 
						}
						//Cuenta debito pension empleado
						$nresul=buscacuenta($ctacont);
						echo "
						<tr class='$iter'>
							<td>$con</td>
							<td>$ctacont</td>
							<td>$nresul</td>
							<td>$row[0]</td>
							<td>$empleado</td>
							<td>$ccosto</td>
							<td>Aporte Pension Empleado Mes $meslnomina</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($row[6],0)."</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
						</tr>";
						$listacuentas[]=$ctacont;
						$listanombrecuentas[]=$nresul;
						$listaterceros[]=$row[0];	
						$listanombreterceros[]=$empleado;	
						$listaccs[]=$ccosto;
						$listadetalles[]="Aporte Pension Empleado Mes $meslnomina";
						$listadebitos[]=$row[6];
						$listacreditos[]=0;
						$listatipo[]="PE<->DB";
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
						$con+=1;
						//Cuenta credito pension empleado
						$nresul=buscacuenta($ctaconcepto);
						$epsnit=buscadatofuncionario($row[0],'NUMAFP');
						$epsnom=buscadatofuncionario($row[0],'NOMAFP');
						echo "
						<tr class='$iter'>
							<td>$con</td>
							<td>$ctaconcepto</td>
							<td>$nresul</td>
							<td>$epsnit</td>
							<td>$epsnom</td>
							<td>$ccosto</td>
							<td>Aporte Pension Empleado Mes $meslnomina</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($row[6],0)."</td>
						</tr>";
						$listacuentas[]=$ctaconcepto;
						$listanombrecuentas[]=$nresul;
						$listaterceros[]=$epsnit;	
						$listanombreterceros[]=$epsnom;	
						$listaccs[]=$ccosto;
						$listadetalles[]="Aporte Pension Empleado Mes $meslnomina";
						$listadebitos[]=0;
						$listacreditos[]=$row[6];
						$listatipo[]="PE<->CR";
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
						$con+=1;
					}
					//Fondo Solidaridad
					if($row[8]!=0)
					{
						$sqlrcp="SELECT DISTINCT concepto FROM humparafiscales_det WHERE codigo='$_POST[pbfsol]' AND CC='$ccosto' AND vigencia='$vigenomina'";
						$respcp=mysql_query($sqlrcp,$linkbd);
						$rowcp =mysql_fetch_row($respcp);
						$sqlrcu="SELECT DISTINCT cuenta, debito, credito FROM conceptoscontables_det WHERE modulo='2' AND tipo='H' AND CC='$ccosto' AND tipocuenta='N' AND codigo='$rowcp[0]' ORDER BY credito";
						$respcu = mysql_query($sqlrcu,$linkbd);
						while ($rowcu =mysql_fetch_row($respcu)) 
						{
							if($rowcu[2]=='S'){$ctaconcepto=$rowcu[0];}
							if($rowcu[1]=='S'){$ctacont=$rowcu[0];}	 
						}
						//Cuenta debito fondo solidaridad
						$nresul=buscacuenta($ctacont);
						echo "
						<tr class='$iter'>
							<td>$con</td>
							<td>$ctacont</td>
							<td>$nresul</td>
							<td>$row[0]</td>
							<td>$empleado</td>
							<td>$ccosto</td>
							<td>Aporte Fondo Solidaridad Empleado Mes $meslnomina</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($row[8],0)."</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
						</tr>";
						$listacuentas[]=$ctacont;
						$listanombrecuentas[]=$nresul;
						$listaterceros[]=$row[0];	
						$listanombreterceros[]=$empleado;	
						$listaccs[]=$ccosto;
						$listadetalles[]="Aporte Fondo Solidaridad Empleado Mes $meslnomina";
						$listadebitos[]=$row[8];
						$listacreditos[]=0;
						$listatipo[]="FS<->DB";
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
						$con+=1;
						//Cuenta credito fondo solidaridad
						$nresul=buscacuenta($ctaconcepto);
						$epsnit=buscadatofuncionario($row[0],'NUMAFP');
						$epsnom=buscadatofuncionario($row[0],'NOMAFP');
						echo "
						<tr class='$iter'>
							<td>$con</td>
							<td>$ctaconcepto</td>
							<td>$nresul</td>
							<td>$epsnit</td>
							<td>$epsnom</td>
							<td>$ccosto</td>
							<td>Aporte Fondo Solidaridad Empleado Mes $meslnomina</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($row[8],0)."</td>
						</tr>";
						$listacuentas[]=$ctaconcepto;
						$listanombrecuentas[]=$nresul;
						$listaterceros[]=$epsnit;	
						$listanombreterceros[]=$epsnom;	
						$listaccs[]=$ccosto;
						$listadetalles[]="Aporte Fondo Solidaridado Mes $meslnomina";
						$listadebitos[]=0;
						$listacreditos[]=$row[8];
						$listatipo[]="FS<->CR";
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
						$con+=1;
					}
					//Otras Deducciones
					if($row[9]!=0)
					{
						$sqlrd1="SELECT T1.valor,T2.id_retencion FROM humnominaretenemp T1, humretenempleados T2 WHERE T1.id_nom='$_POST[idliq]' AND T1.cedulanit='$row[0]' AND T1.id=T2.id";
						$respd1=mysql_query($sqlrd1,$linkbd);
						while ($rowd1=mysql_fetch_row($respd1))
						{
							$sqlrcu="SELECT DISTINCT T1.nombre,T1.beneficiario,T2.cuenta,T2.debito,T2.credito FROM humvariablesretenciones T1,humvariablesretenciones_det T2 WHERE T1.codigo='$rowd1[1]' AND T1.codigo=T2.codigo";
							$respcu = mysql_query($sqlrcu,$linkbd);
							while ($rowcu =mysql_fetch_row($respcu)) 
							{
								if($rowcu[4]=='S'){$ctaconcepto=$rowcu[2];$docbenefi=$rowcu[1];}
								if($rowcu[3]=='S'){$ctacont=$rowcu[2];}	
								$nomdescu=ucwords(strtolower($rowcu[0])); 
							}
							//Cuenta debito otras deducciones
							$nresul=buscacuenta($ctacont);
							echo "
							<tr class='$iter'>
								<td>$con</td>
								<td>$ctacont</td>
								<td>$nresul</td>
								<td>$row[0]</td>
								<td>$empleado</td>
								<td>$ccosto</td>
								<td>Decuento $nomdescu Mes $meslnomina</td>
								<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($rowd1[0],0)."</td>
								<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
							</tr>";
							$listacuentas[]=$ctacont;
							$listanombrecuentas[]=$nresul;
							$listaterceros[]=$row[0];	
							$listanombreterceros[]=$empleado;	
							$listaccs[]=$ccosto;
							$listadetalles[]="Decuento $nomdescu Mes $meslnomina";
							$listadebitos[]=$rowd1[0];
							$listacreditos[]=0;
							$listatipo[]="DS<->DB";
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux;
							$con+=1;
							//Cuenta credito otras deducciones
							$nresul=buscacuenta($ctaconcepto);
							$nombenefi=buscatercero($docbenefi);
							echo "
							<tr class='$iter'>
								<td>$con</td>
								<td>$ctaconcepto</td>
								<td>$nresul</td>
								<td>$docbenefi</td>
								<td>$nombenefi</td>
								<td>$ccosto</td>
								<td>Decuento $nomdescu Mes $meslnomina</td>
								<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
								<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($rowd1[0],0)."</td>
							</tr>";
							$listacuentas[]=$ctaconcepto;
							$listanombrecuentas[]=$nresul;
							$listaterceros[]=$docbenefi;	
							$listanombreterceros[]=$nombenefi;	
							$listaccs[]=$ccosto;
							$listadetalles[]="Decuento $nomdescu Mes $meslnomina";
							$listadebitos[]=0;
							$listacreditos[]=$rowd1[0];
							$listatipo[]="DS<->CR";
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux;
							$con+=1;
						}
					}
					//Salud Empleador
					if($row[5]!=0)
					{
						$epsnit=buscadatofuncionario($row[0],'NUMEPS');
						$epsnom=buscadatofuncionario($row[0],'NOMEPS');
						$sqlrcp="SELECT DISTINCT concepto FROM humparafiscales_det WHERE codigo='$_POST[psalud_empleador]' AND CC='$ccosto' AND vigencia='$vigenomina'";
						$respcp=mysql_query($sqlrcp,$linkbd);
						$rowcp =mysql_fetch_row($respcp);
						$sqlrcu="SELECT DISTINCT cuenta, debito, credito FROM conceptoscontables_det WHERE modulo='2' AND tipo='H' AND CC='$ccosto' AND tipocuenta='N' AND codigo='$rowcp[0]' ORDER BY credito";
						$respcu = mysql_query($sqlrcu,$linkbd);
						while ($rowcu =mysql_fetch_row($respcu)) 
						{
							if($rowcu[2]=='S'){$ctaconcepto=$rowcu[0];}
							if($rowcu[1]=='S'){$ctacont=$rowcu[0];}	 
						}
						//Cuenta debito salud empleador
						$nresul=buscacuenta($ctacont);
						echo "
						<tr class='$iter'>
							<td>$con</td>
							<td>$ctacont</td>
							<td>$nresul</td>
							<td>$epsnit</td>
							<td>$epsnom</td>
							<td>$ccosto</td>
							<td>Aporte Salud Empleador Mes $meslnomina</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($row[5],0)."</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
						</tr>";
						$listacuentas[]=$ctacont;
						$listanombrecuentas[]=$nresul;
						$listaterceros[]=$epsnit;	
						$listanombreterceros[]=$epsnom;	
						$listaccs[]=$ccosto;
						$listadetalles[]="Aporte Salud Empleador Mes $meslnomina";
						$listadebitos[]=$row[5];
						$listacreditos[]=0;
						$listatipo[]="SR<->DB";
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
						$con+=1;
						//Cuenta credito salud empleador
						$nresul=buscacuenta($ctaconcepto);
						
						echo "
						<tr class='$iter'>
							<td>$con</td>
							<td>$ctaconcepto</td>
							<td>$nresul</td>
							<td>$epsnit</td>
							<td>$epsnom</td>
							<td>$ccosto</td>
							<td>Aporte Salud Empleador Mes $meslnomina</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($row[5],0)."</td>
						</tr>";
						$listacuentas[]=$ctaconcepto;
						$listanombrecuentas[]=$nresul;
						$listaterceros[]=$epsnit;	
						$listanombreterceros[]=$epsnom;	
						$listaccs[]=$ccosto;
						$listadetalles[]="Aporte Salud Empleador Mes $meslnomina";
						$listadebitos[]=0;
						$listacreditos[]=$row[5];
						$listatipo[]="SR<->CR";
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
						$con+=1;
					}
					//Pension Empleador
					if($row[7]!=0)
					{
						$epsnit=buscadatofuncionario($row[0],'NUMAFP');
						$epsnom=buscadatofuncionario($row[0],'NOMAFP');
						$sqlrcp="SELECT DISTINCT concepto FROM humparafiscales_det WHERE codigo='$_POST[ppension_empleador]' AND CC='$ccosto' AND vigencia='$vigenomina'";
						$respcp=mysql_query($sqlrcp,$linkbd);
						$rowcp =mysql_fetch_row($respcp);
						$sqlrcu="SELECT DISTINCT cuenta, debito, credito FROM conceptoscontables_det WHERE modulo='2' AND tipo='H' AND CC='$ccosto' AND tipocuenta='N' AND codigo='$rowcp[0]' ORDER BY credito";
						$respcu = mysql_query($sqlrcu,$linkbd);
						while ($rowcu =mysql_fetch_row($respcu)) 
						{
							if($rowcu[2]=='S'){$ctaconcepto=$rowcu[0];}
							if($rowcu[1]=='S'){$ctacont=$rowcu[0];}	 
						}
						//Cuenta debito pension empleador
						$nresul=buscacuenta($ctacont);
						echo "
						<tr class='$iter'>
							<td>$con</td>
							<td>$ctacont</td>
							<td>$nresul</td>
							<td>$epsnit</td>
							<td>$epsnom</td>
							<td>$ccosto</td>
							<td>Aporte Pension Empleador Mes $meslnomina</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($row[7],0)."</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
						</tr>";
						$listacuentas[]=$ctacont;
						$listanombrecuentas[]=$nresul;
						$listaterceros[]=$epsnit;	
						$listanombreterceros[]=$epsnom;	
						$listaccs[]=$ccosto;
						$listadetalles[]="Aporte Pension Empleador Mes $meslnomina";
						$listadebitos[]=$row[7];
						$listacreditos[]=0;
						$listatipo[]="PR<->DB";
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
						$con+=1;
						//Cuenta credito pension empleador
						$nresul=buscacuenta($ctaconcepto);
						echo "
						<tr class='$iter'>
							<td>$con</td>
							<td>$ctaconcepto</td>
							<td>$nresul</td>
							<td>$epsnit</td>
							<td>$epsnom</td>
							<td>$ccosto</td>
							<td>Aporte Pension Empleador Mes $meslnomina</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($row[7],0)."</td>
						</tr>";
						$listacuentas[]=$ctaconcepto;
						$listanombrecuentas[]=$nresul;
						$listaterceros[]=$epsnit;	
						$listanombreterceros[]=$epsnom;	
						$listaccs[]=$ccosto;
						$listadetalles[]="Aporte Pension Empleador Mes $meslnomina";
						$listadebitos[]=0;
						$listacreditos[]=$row[7];
						$listatipo[]="PR<->CR";
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
						$con+=1;
					}	
					//ARL
					if($row[10]!=0)
					{
						$epsnit=buscadatofuncionario($row[0],'NUMARL');
						$epsnom=buscadatofuncionario($row[0],'NOMARL');
						$sqlrcp="SELECT DISTINCT concepto FROM humparafiscales_det WHERE codigo='$_POST[parp]' AND CC='$ccosto' AND vigencia='$vigenomina'";
						$respcp=mysql_query($sqlrcp,$linkbd);
						$rowcp =mysql_fetch_row($respcp);
						$sqlrcu="SELECT DISTINCT cuenta, debito, credito FROM conceptoscontables_det WHERE modulo='2' AND tipo='H' AND CC='$ccosto' AND tipocuenta='N' AND codigo='$rowcp[0]' ORDER BY credito";
						$respcu = mysql_query($sqlrcu,$linkbd);
						while ($rowcu =mysql_fetch_row($respcu)) 
						{
							if($rowcu[2]=='S'){$ctaconcepto=$rowcu[0];}
							if($rowcu[1]=='S'){$ctacont=$rowcu[0];}	 
						}
						//Cuenta debito ARL empleador
						$nresul=buscacuenta($ctacont);
						echo "
						<tr class='$iter'>
							<td>$con</td>
							<td>$ctacont</td>
							<td>$nresul</td>
							<td>$epsnit</td>
							<td>$epsnom</td>
							<td>$ccosto</td>
							<td>Aportes ARL Mes $meslnomina</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($row[10],0)."</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
						</tr>";
						$listacuentas[]=$ctacont;
						$listanombrecuentas[]=$nresul;
						$listaterceros[]=$epsnit;	
						$listanombreterceros[]=$epsnom;	
						$listaccs[]=$ccosto;
						$listadetalles[]="Aportes ARL Mes $meslnomina";
						$listadebitos[]=$row[10];
						$listacreditos[]=0;
						$listatipo[]="P6<->DB";
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
						$con+=1;
						//Cuenta credito ARL empleado
						$nresul=buscacuenta($ctaconcepto);
						echo "
						<tr class='$iter'>
							<td>$con</td>
							<td>$ctaconcepto</td>
							<td>$nresul</td>
							<td>$epsnit</td>
							<td>$epsnom</td>
							<td>$ccosto</td>
							<td>Aportes ARL Mes $meslnomina</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($row[10],0)."</td>
						</tr>";
						$listacuentas[]=$ctaconcepto;
						$listanombrecuentas[]=$nresul;
						$listaterceros[]=$epsnit;	
						$listanombreterceros[]=$epsnom;	
						$listaccs[]=$ccosto;
						$listadetalles[]="Aportes ARL Mes $meslnomina";
						$listadebitos[]=0;
						$listacreditos[]=$row[10];
						$listatipo[]="P6<->CR";
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
						$con+=1;
					}	
					//COFREM
					if($row[11]!=0){$listacajacf[$ccosto][]=$row[11];}	
					//SENA
					if($row[12]!=0){$listasena[$ccosto][]=$row[12];}	
					//ICBF
					if($row[13]!=0){$listaicbf[$ccosto][]=$row[13];}	
					//INSTITUTOS TEC
					if($row[14]!=0){$listainstecnicos[$ccosto][]=$row[14];}	
					//ESAP
					if($row[15]!=0){$listaesap[$ccosto][]=$row[15];}	
				}
				$sqlrcc="SELECT id_cc FROM centrocosto WHERE estado='S' ORDER BY CONVERT(id_cc, SIGNED INTEGER)";
				$respcc = mysql_query($sqlrcc,$linkbd);
				while ($rowcc =mysql_fetch_row($respcc)) 
				{
					$totalcajacf=array_sum($listacajacf[$rowcc[0]]);
					$totalsena=array_sum($listasena[$rowcc[0]]);
					$totalicbf=array_sum($listaicbf[$rowcc[0]]);
					$totalinstecnicos=array_sum($listainstecnicos[$rowcc[0]]);
					$totalesap=array_sum($listaesap[$rowcc[0]]);
					//Caja de compensación familiar 
					if($totalcajacf!=0)
					{
						$parafiscal=$_POST[pcajacomp];
						$nomparafiscal=buscatercero($_POST[cajacomp]);
						$nitparafiscal=$_POST[cajacomp];
 						$valparafiscal=$totalcajacf;
						$sqlrcp="SELECT DISTINCT concepto FROM humparafiscales_det WHERE codigo='$parafiscal' AND CC='$ccosto' AND vigencia='$vigenomina'";
						$respcp=mysql_query($sqlrcp,$linkbd);
						$rowcp =mysql_fetch_row($respcp);
						$sqlrcu="SELECT DISTINCT cuenta, debito, credito FROM conceptoscontables_det WHERE modulo='2' AND tipo='H' AND CC='$ccosto' AND tipocuenta='N' AND codigo='$rowcp[0]' ORDER BY credito";
						$respcu = mysql_query($sqlrcu,$linkbd);
						while ($rowcu =mysql_fetch_row($respcu)) 
						{
							if($rowcu[2]=='S'){$ctaconcepto=$rowcu[0];}
							if($rowcu[1]=='S'){$ctacont=$rowcu[0];}	 
						}
						//Cuenta debito Caja de compensación familiar
						$nresul=buscacuenta($ctacont);
						echo "
						<tr class='$iter'>
							<td>$con</td>
							<td>$ctacont</td>
							<td>$nresul</td>
							<td>$nitparafiscal</td>
							<td>$nomparafiscal</td>
							<td>$rowcc[0]</td>
							<td>Aportes Caja Compensación Mes $meslnomina</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($valparafiscal,0)."</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
						</tr>";
						$listacuentas[]=$ctacont;
						$listanombrecuentas[]=$nresul;
						$listaterceros[]=$nitparafiscal;	
						$listanombreterceros[]=$nomparafiscal;	
						$listaccs[]=$rowcc[0];
						$listadetalles[]="Aportes Caja Compensación Mes $meslnomina";
						$listadebitos[]=$valparafiscal;
						$listacreditos[]=0;
						$listatipo[]="P1<->DB";
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
						$con+=1;
						//Cuenta credito Caja de compensación familiar
						$nresul=buscacuenta($ctaconcepto);
						echo "
						<tr class='$iter'>
							<td>$con</td>
							<td>$ctaconcepto</td>
							<td>$nresul</td>
							<td>$nitparafiscal</td>
							<td>$nomparafiscal</td>
							<td>$ccosto</td>
							<td>Aportes Caja Compensación Mes $meslnomina</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($valparafiscal,0)."</td>
						</tr>";
						$listacuentas[]=$ctaconcepto;
						$listanombrecuentas[]=$nresul;
						$listaterceros[]=$nitparafiscal;	
						$listanombreterceros[]=$nomparafiscal;	
						$listaccs[]=$rowcc[0];
						$listadetalles[]="Aportes Caja Compensación Mes $meslnomina";
						$listadebitos[]=0;
						$listacreditos[]=$valparafiscal;
						$listatipo[]="P1<->CR";
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
						$con+=1;
					}
					//ICBF
					if($totalicbf!=0)
					{
						$parafiscal=$_POST[picbf];
						$nomparafiscal=buscatercero($_POST[icbf]);
 						$nitparafiscal=$_POST[icbf];
 						$valparafiscal=$totalicbf;
						$sqlrcp="SELECT DISTINCT concepto FROM humparafiscales_det WHERE codigo='$parafiscal' AND CC='$ccosto' AND vigencia='$vigenomina'";
						$respcp=mysql_query($sqlrcp,$linkbd);
						$rowcp =mysql_fetch_row($respcp);
						$sqlrcu="SELECT DISTINCT cuenta, debito, credito FROM conceptoscontables_det WHERE modulo='2' AND tipo='H' AND CC='$ccosto' AND tipocuenta='N' AND codigo='$rowcp[0]' ORDER BY credito";
						$respcu = mysql_query($sqlrcu,$linkbd);
						while ($rowcu =mysql_fetch_row($respcu)) 
						{
							if($rowcu[2]=='S'){$ctaconcepto=$rowcu[0];}
							if($rowcu[1]=='S'){$ctacont=$rowcu[0];}	 
						}
						//Cuenta debito ICBF
						$nresul=buscacuenta($ctacont);
						echo "
						<tr class='$iter'>
							<td>$con</td>
							<td>$ctacont</td>
							<td>$nresul</td>
							<td>$nitparafiscal</td>
							<td>$nomparafiscal</td>
							<td>$rowcc[0]</td>
							<td>Aportes ICBF Mes $meslnomina</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($valparafiscal,0)."</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
						</tr>";
						$listacuentas[]=$ctacont;
						$listanombrecuentas[]=$nresul;
						$listaterceros[]=$nitparafiscal;	
						$listanombreterceros[]=$nomparafiscal;	
						$listaccs[]=$rowcc[0];
						$listadetalles[]="Aportes ICBF Mes $meslnomina";
						$listadebitos[]=$valparafiscal;
						$listacreditos[]=0;
						$listatipo[]="P2<->DB";
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
						$con+=1;
						//Cuenta credito ICBF
						$nresul=buscacuenta($ctaconcepto);
						echo "
						<tr class='$iter'>
							<td>$con</td>
							<td>$ctaconcepto</td>
							<td>$nresul</td>
							<td>$nitparafiscal</td>
							<td>$nomparafiscal</td>
							<td>$ccosto</td>
							<td>Aportes ICBF Mes $meslnomina</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($valparafiscal,0)."</td>
						</tr>";
						$listacuentas[]=$ctaconcepto;
						$listanombrecuentas[]=$nresul;
						$listaterceros[]=$nitparafiscal;	
						$listanombreterceros[]=$nomparafiscal;	
						$listaccs[]=$rowcc[0];
						$listadetalles[]="Aportes ICBF Mes $meslnomina";
						$listadebitos[]=0;
						$listacreditos[]=$valparafiscal;
						$listatipo[]="P2<->CR";
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
						$con+=1;
					}
					//SENA
					if($totalsena!=0)
					{
						$parafiscal=$_POST[psena];
						$nitparafiscal=$_POST[sena];
						$nomparafiscal=buscatercero($_POST[sena]);
						$valparafiscal=$totalsena;
						$sqlrcp="SELECT DISTINCT concepto FROM humparafiscales_det WHERE codigo='$parafiscal' AND CC='$ccosto' AND vigencia='$vigenomina'";
						$respcp=mysql_query($sqlrcp,$linkbd);
						$rowcp =mysql_fetch_row($respcp);
						$sqlrcu="SELECT DISTINCT cuenta, debito, credito FROM conceptoscontables_det WHERE modulo='2' AND tipo='H' AND CC='$ccosto' AND tipocuenta='N' AND codigo='$rowcp[0]' ORDER BY credito";
						$respcu = mysql_query($sqlrcu,$linkbd);
						while ($rowcu =mysql_fetch_row($respcu)) 
						{
							if($rowcu[2]=='S'){$ctaconcepto=$rowcu[0];}
							if($rowcu[1]=='S'){$ctacont=$rowcu[0];}	 
						}
						//Cuenta debito SENA
						$nresul=buscacuenta($ctacont);
						echo "
						<tr class='$iter'>
							<td>$con</td>
							<td>$ctacont</td>
							<td>$nresul</td>
							<td>$nitparafiscal</td>
							<td>$nomparafiscal</td>
							<td>$rowcc[0]</td>
							<td>Aportes SENA Mes $meslnomina</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($valparafiscal,0)."</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
						</tr>";
						$listacuentas[]=$ctacont;
						$listanombrecuentas[]=$nresul;
						$listaterceros[]=$nitparafiscal;	
						$listanombreterceros[]=$nomparafiscal;	
						$listaccs[]=$rowcc[0];
						$listadetalles[]="Aportes SENA Mes $meslnomina";
						$listadebitos[]=$valparafiscal;
						$listacreditos[]=0;
						$listatipo[]="P3<->DB";
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
						$con+=1;
						//Cuenta credito ICBF
						$nresul=buscacuenta($ctaconcepto);
						echo "
						<tr class='$iter'>
							<td>$con</td>
							<td>$ctaconcepto</td>
							<td>$nresul</td>
							<td>$nitparafiscal</td>
							<td>$nomparafiscal</td>
							<td>$ccosto</td>
							<td>Aportes SENA Mes $meslnomina</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($valparafiscal,0)."</td>
						</tr>";
						$listacuentas[]=$ctaconcepto;
						$listanombrecuentas[]=$nresul;
						$listaterceros[]=$nitparafiscal;	
						$listanombreterceros[]=$nomparafiscal;	
						$listaccs[]=$rowcc[0];
						$listadetalles[]="Aportes SENA Mes $meslnomina";
						$listadebitos[]=0;
						$listacreditos[]=$valparafiscal;
						$listatipo[]="P3<->CR";
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
						$con+=1;
					}
					//Institutos Tecnicos
					if($totalinstecnicos!=0)
					{
						$parafiscal=$_POST[piti];
						$nitparafiscal=$_POST[iti];
						$nomparafiscal=buscatercero($_POST[iti]);
						$valparafiscal=$totalinstecnicos;
						$sqlrcp="SELECT DISTINCT concepto FROM humparafiscales_det WHERE codigo='$parafiscal' AND CC='$ccosto' AND vigencia='$vigenomina'";
						$respcp=mysql_query($sqlrcp,$linkbd);
						$rowcp =mysql_fetch_row($respcp);
						$sqlrcu="SELECT DISTINCT cuenta, debito, credito FROM conceptoscontables_det WHERE modulo='2' AND tipo='H' AND CC='$ccosto' AND tipocuenta='N' AND codigo='$rowcp[0]' ORDER BY credito";
						$respcu = mysql_query($sqlrcu,$linkbd);
						while ($rowcu =mysql_fetch_row($respcu)) 
						{
							if($rowcu[2]=='S'){$ctaconcepto=$rowcu[0];}
							if($rowcu[1]=='S'){$ctacont=$rowcu[0];}	 
						}
						//Cuenta debito Inst tecnicos 
						$nresul=buscacuenta($ctacont);
						echo "
						<tr class='$iter'>
							<td>$con</td>
							<td>$ctacont</td>
							<td>$nresul</td>
							<td>$nitparafiscal</td>
							<td>$nomparafiscal</td>
							<td>$rowcc[0]</td>
							<td>Aportes Inst técnicos Mes $meslnomina</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($valparafiscal,0)."</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
						</tr>";
						$listacuentas[]=$ctacont;
						$listanombrecuentas[]=$nresul;
						$listaterceros[]=$nitparafiscal;	
						$listanombreterceros[]=$nomparafiscal;	
						$listaccs[]=$rowcc[0];
						$listadetalles[]="Aportes Inst técnicos Mes $meslnomina";
						$listadebitos[]=$valparafiscal;
						$listacreditos[]=0;
						$listatipo[]="P4<->DB";
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
						$con+=1;
						//Cuenta credito Inst tecnicos 
						$nresul=buscacuenta($ctaconcepto);
						echo "
						<tr class='$iter'>
							<td>$con</td>
							<td>$ctaconcepto</td>
							<td>$nresul</td>
							<td>$nitparafiscal</td>
							<td>$nomparafiscal</td>
							<td>$ccosto</td>
							<td>Aportes Inst técnicos Mes $meslnomina</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($valparafiscal,0)."</td>
						</tr>";
						$listacuentas[]=$ctaconcepto;
						$listanombrecuentas[]=$nresul;
						$listaterceros[]=$nitparafiscal;	
						$listanombreterceros[]=$nomparafiscal;	
						$listaccs[]=$rowcc[0];
						$listadetalles[]="Aportes Inst técnicos Mes $meslnomina";
						$listadebitos[]=0;
						$listacreditos[]=$valparafiscal;
						$listatipo[]="P4<->CR";
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
						$con+=1;
					}
					//ESAP
					if($totalesap!=0)
					{
						$parafiscal=$_POST[pesap];
  						$nitparafiscal=$_POST[esap];
  						$nomparafiscal=buscatercero($_POST[esap]);
						$valparafiscal=$totalesap;
						$sqlrcp="SELECT DISTINCT concepto FROM humparafiscales_det WHERE codigo='$parafiscal' AND CC='$ccosto' AND vigencia='$vigenomina'";
						$respcp=mysql_query($sqlrcp,$linkbd);
						$rowcp =mysql_fetch_row($respcp);
						$sqlrcu="SELECT DISTINCT cuenta, debito, credito FROM conceptoscontables_det WHERE modulo='2' AND tipo='H' AND CC='$ccosto' AND tipocuenta='N' AND codigo='$rowcp[0]' ORDER BY credito";
						$respcu = mysql_query($sqlrcu,$linkbd);
						while ($rowcu =mysql_fetch_row($respcu)) 
						{
							if($rowcu[2]=='S'){$ctaconcepto=$rowcu[0];}
							if($rowcu[1]=='S'){$ctacont=$rowcu[0];}	 
						}
						//Cuenta debito ESAP
						$nresul=buscacuenta($ctacont);
						echo "
						<tr class='$iter'>
							<td>$con</td>
							<td>$ctacont</td>
							<td>$nresul</td>
							<td>$nitparafiscal</td>
							<td>$nomparafiscal</td>
							<td>$rowcc[0]</td>
							<td>Aportes ESAP Mes $meslnomina</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($valparafiscal,0)."</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
						</tr>";
						$listacuentas[]=$ctacont;
						$listanombrecuentas[]=$nresul;
						$listaterceros[]=$nitparafiscal;	
						$listanombreterceros[]=$nomparafiscal;	
						$listaccs[]=$rowcc[0];
						$listadetalles[]="Aportes ESAP Mes $meslnomina";
						$listadebitos[]=$valparafiscal;
						$listacreditos[]=0;
						$listatipo[]="P5<->DB";
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
						$con+=1;
						//Cuenta credito Inst tecnicos 
						$nresul=buscacuenta($ctaconcepto);
						echo "
						<tr class='$iter'>
							<td>$con</td>
							<td>$ctaconcepto</td>
							<td>$nresul</td>
							<td>$nitparafiscal</td>
							<td>$nomparafiscal</td>
							<td>$ccosto</td>
							<td>Aportes ESAP Mes $meslnomina</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format(0,0)."</td>
							<td style='text-align:right;font-size:10px;'>&nbsp;$".number_format($valparafiscal,0)."</td>
						</tr>";
						$listacuentas[]=$ctaconcepto;
						$listanombrecuentas[]=$nresul;
						$listaterceros[]=$nitparafiscal;	
						$listanombreterceros[]=$nomparafiscal;	
						$listaccs[]=$rowcc[0];
						$listadetalles[]="Aportes ESAP Mes $meslnomina";
						$listadebitos[]=0;
						$listacreditos[]=$valparafiscal;
						$listatipo[]="P5<->CR";
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
						$con+=1;
					}
				}
				echo "
					<tr class='titulos2'>
						<td colspan='4'></td>
						<td colspan='2' style='text-align:right;'>Diferencia:</td>
						<td> $".number_format(array_sum($listadebitos)-array_sum($listacreditos),0,',','.')."</td>
						<td style='text-align:right;'>$".number_format(array_sum($listadebitos),0,',','.')."</td>
					  	<td style='text-align:right;'>$".number_format(array_sum($listacreditos),0,',','.')."</td>
					</tr>
				</table>";			
			?>
		</div>
		<?php
			if($_POST[oculto]==2)
 			{
				$id=$_POST[idliq];
				$sqlr="DELETE FROM comprobante_cab WHERE numerotipo='$id' AND tipo_comp='4'";
				mysql_query($sqlr,$linkbd);
				$sqlr="DELETE FROM comprobante_det WHERE numerotipo='$id' AND tipo_comp='4'";
				mysql_query($sqlr,$linkbd);
   				ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
				$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	  			$lastday = mktime (0,0,0,$_POST[periodo],1,$_POST[vigenomi]);
	 			$sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($id,4,'$fechaf','CAUSACION $primanom MES $meslnomina',0,0,0,0,'1')";
				mysql_query($sqlr,$linkbd);
				for ($x=0;$x<count($listacuentas);$x++) 
	 			{
					$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('4 $id','$listacuentas[$x]','$listaterceros[$x]','$listaccs[$x]','$listadetalles[$x]','','$listadebitos[$x]','$listacreditos[$x]','1', '$_POST[vigenomi]')";	
					mysql_query($sqlr,$linkbd);		
				}
 			}
?>
		</form>
	</body>
</html>