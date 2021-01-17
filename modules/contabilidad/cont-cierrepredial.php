<?php //V 1000 12/12/16 ?> 
<!--V 1.0 24/02/2015-->
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
		<title>:: Spid - Contabilidad</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<script>
			function buscactac(e){if (document.form2.cuentamiles.value!=""){document.form2.bcc.value='1';document.form2.submit();}}
			function buscactace(e){if (document.form2.cuentac.value!=""){document.form2.bcce.value='1';document.form2.submit();}}
			function buscactacd(e){if (document.form2.cuentac.value!=""){document.form2.bccd.value='1';document.form2.submit();}}
			function guardar()
			{
				if((document.getElementById('ages').value!="")&&(document.getElementById('cc').value!=""))
				{
					if(document.getElementById('oculto2').value=="1"){despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
					else {despliegamodalm('visible','2','Se debe "Generar" primero');}
				}
				else {despliegamodalm('visible','2','Se debe ingresar vigencia y Centro de Costos');}
			}
			function generar()
			{
				if((document.getElementById('ages').value!="")&&(document.getElementById('cc').value!=""))
				{
					document.getElementById('oculto2').value="1";
					document.form2.gencom.value=1;document.form2.oculto.value=1;document.form2.submit();
				
				}
				else {despliegamodalm('visible','2','Se debe ingresar vigencia y Centro de Costos');}
				
			}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventanam').src="";}
				else
				{
					switch(_tip)
					{
						case "1":
							document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
						case "2":
							document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
						case "3":
							document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
						case "4":
							document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;	
					}
				}
			}
			function funcionmensaje(){}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":
						document.form2.oculto.value=2;
						document.form2.submit();
						break;
				}
			}
			function valcodigo(){document.form2.oculto.value="8";document.form2.submit();}
		</script>
		<?php titlepag();?>
	</head>
	<body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
		<table>
    		<tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
    		<tr><?php menu_desplegable("cont");?></tr>
			<tr>
	  			<td colspan="3" class="cinta">
				<a class="mgbt1"><img src="imagenes/add2.png" /></a>
				<a onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a>
				<a class="mgbt1"><img src="imagenes/buscad.png"/></a>
				<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
				<a onClick="<?php echo paginasnuevas("cont");?>" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
				</td>
          	</tr>
     	</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
		<?php
			$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
			//**** resultado
			$sqlr="select valor_inicial from dominios where nombre_dominio='CUENTA_EMISORA_PREDIAL'";
			$res=mysql_query($sqlr,$linkbd);
			while ($row =mysql_fetch_row($res)) 
			{
	 			$_POST[cuentaemipre]=$row[0];
	 			$_POST[ncuentaemipre]=buscacuenta($_POST[cuentaemipre]);
			}//**** resultado
			$sqlr="select valor_inicial from dominios where nombre_dominio='CUENTA_RECEPTORA_PREDIAL'";
			$res=mysql_query($sqlr,$linkbd);
			while ($row =mysql_fetch_row($res)) 
			{
	 			$_POST[cuentarecpre]=$row[0];
	 			$_POST[ncuentarecpre]=buscacuenta($_POST[cuentarecpre]);
			}//**** resultado
			$sqlr="select valor_inicial from dominios where nombre_dominio='CUENTA_EMISORA_BOMBERIL'";
			$res=mysql_query($sqlr,$linkbd);
			while ($row =mysql_fetch_row($res)) 
			{
	 			$_POST[cuentaemibom]=$row[0];
	 			$_POST[ncuentaemibom]=buscacuenta($_POST[cuentaemibom]);
			}//**** resultado
			$sqlr="select valor_inicial from dominios where nombre_dominio='CUENTA_RECEPTORA_BOMBERIL'";
			$res=mysql_query($sqlr,$linkbd);
			while ($row =mysql_fetch_row($res)) 
			{
	 			$_POST[cuentarecbom]=$row[0];
	 			$_POST[ncuentarecbom]=buscacuenta($_POST[cuentarecbom]);
			}//**** resultado
		?>
    	<form name="form2" method="post" action="cont-cierrepredial.php">
    		<table class="inicio" >     
     			<tr>
        			<td class="titulos" colspan="6">:: Parametros de Traslado Predial y Bomberil</td>
        			<td class="cerrar" style="width:7%;"><a onClick="location.href='cont-principal.php'">Cerrar</a></td>
      			</tr>
      			<tr>
      				<td class="saludo1" >:: Vigencia Cierre:</td>
      				<td>
                    	<select name="ages" id="ages">
      						<option value="">Seleccione...</option>
      						<?php
      							for($x=($vigusu-2);$x<=($vigusu);$x++)
	   							{
		 							if($x==$_POST[ages]){echo "<option value='$x' SELECTED>$x</option>";}
									else {echo "<option value='$x'>$x</option>";}
							   	}
      						?>
      					</select> 
      					<input type="hidden" value="<?php echo $_POST[oculto]?>" name="oculto">
                        <input type="hidden" name="oculto2" id="oculto2" value="<?php echo $_POST[oculto2]?>"/>
      					<input type="hidden" value="<?php echo $_POST[gencom]?>" name="gencom">
                   	</td> 
                	<td class="saludo1">Centro Costo:</td>
	  				<td>
						<select name="cc" id="cc" onKeyUp="return tabular(event,this)">
    						<option value="" >Seleccione...</option>
							<?php
								$sqlr="select * from centrocosto where estado='S'";
								$res=mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($res)) 
				    			{
					 				if($row[0]==$_POST[cc]){echo "<option value=$row[0] SELECTED>$row[0] - $row[1]</option>";}
									else {echo "<option value=$row[0]>$row[0] - $row[1]</option>";}
								}
							?>
   						</select>
					</td>
					<td>
                    	<input type="button" name="genera" value=" Generar " onClick="generar()"> 
                   		<input type="button" name="contabiliza" value=" Contabilizar " onClick="guardar()">
						<input id="cuentaemipre" name="cuentaemipre" type="hidden" value="<?php echo $_POST[cuentaemipre]?>" size="15" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="buscactacu(event)"  onClick="document.getElementById('cuentaemipre').focus();document.getElementById('cuentaemipre').select();" readonly>
        				<input type="hidden" value="" name="bcep"><input id="ncuentaemipre"  name="ncuentaemipre" type="hidden" value="<?php echo $_POST[ncuentaemipre]?>" size="80" readonly>
      					<input id="cuentarecpre" name="cuentarecpre" type="hidden" value="<?php echo $_POST[cuentarecpre]?>" size="15" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="buscactaci(event)"  onClick="document.getElementById('cuentarecpre').focus();document.getElementById('cuentarecpre').select();" readonly>
        				<input type="hidden" value="" name="bcrp"><input id="ncuentarecpre"  name="ncuentarecpre" type="hidden" value="<?php echo $_POST[ncuentarecpre]?>" size="80" readonly>
                        <input id="cuentaemibom" name="cuentaemibom" type="hidden" value="<?php echo $_POST[cuentaemibom]?>" size="15" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="buscactaci(event)"  onClick="document.getElementById('cuentaemibom').focus();document.getElementById('cuentaemibom').select();" readonly>
        				<input type="hidden" value="" name="bccd">
                        <input id="ncuentaemibom"  name="ncuentaemibom" type="hidden" value="<?php echo $_POST[ncuentaemibom]?>" size="80" readonly>				
                        <input id="cuentarecbom" name="cuentarecbom" type="hidden" value="<?php echo $_POST[cuentarecbom]?>" size="15" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="buscactaci(event)"  onClick="document.getElementById('cuentarecbom').focus();document.getElementById('cuentarecbom').select();" readonly>
        				<input type="hidden" value="" name="bccd">
                        <input id="ncuentarecbom" name="ncuentarecbom" type="hidden" value="<?php echo $_POST[ncuentarecbom]?>" size="80" readonly>
                  	</td>
        		</tr>   
    		</table>    
    		<div class="subpantalla" style="height:67.5%; width:99.6%; overflow-x:hidden;">
    			<table class="inicio">
   					<tr><td class="titulos" colspan="7">Resultados Cierre</td></tr>
    				<tr>
                    	<td class="titulos2">Cuenta</td>
                        <td class="titulos2">Nombre Cuenta</td>
                        <td class="titulos2">Tercero</td>
                        <td class="titulos2">Nombre Tercero</td>
                        <td class="titulos2">Debito</td>
                        <td class="titulos2">Credito</td>
                        <td class="titulos2">Saldo</td>
               		</tr>    
  					<?php
  						if($_POST[bcc]!='')
			 			{
			  				$nresul=buscacuenta($_POST[cuentamiles]);
			  				if($nresul!='')
			   				{
			 					$_POST[ncuentamiles]=$nresul;
  			  					echo "<script>document.getElementById('bcc').value='';</script>";
			  				}
							else
			 				{
			 					$_POST[ncuentamiles]="";
			  					echo "<script>alert('Cuenta Incorrecta');document.form2.cuentamiles.focus();</script>";
			  				}
			 			} 
						if($_POST[bcce]!='')
			 			{
			  				$nresul=buscacuenta($_POST[cuentautilidad]);
			  				if($nresul!='')
			   				{
			  					$_POST[ncuentautilidad]=$nresul;
  			  					echo "<script>document.getElementById('bcce').value='';</script>";
			  				}
			 				else
			 				{
			  					$_POST[ncuentautilidad]="";
			  					echo "<script>alert('Cuenta Incorrecta');document.form2.cuentautilidad.focus();</script>";
			  				}
			 			} 		
						if($_POST[bccd]!='')
			 			{
			  				$nresul=buscacuenta($_POST[cuentacierre]);
			  				if($nresul!='')
			   				{
			  					$_POST[ncuentacierre]=$nresul;
  			  					echo "<script> document.getElementById('bccd').value='';</script>";
			 				 }
			 				else
			 				{
			 	 				$_POST[ncuentacierre]="";
			  					echo "<script>alert('Cuenta Incorrecta');document.form2.cuentacierre.focus();</script>";
			  				}
			 			} 			  
						if($_POST[bccde]!='')
			 			{
			  				$nresul=buscacuenta($_POST[cuentacierredef]);
			  				if($nresul!='')
			   				{
			  					$_POST[ncuentacierredef]=$nresul;
  			  					echo "<script>document.getElementById('bccde').value='';</script>";
			  				}
			 				else
			 				{
			 					$_POST[ncuentacierredef]="";
			  					echo "<script>alert('Cuenta Incorrecta');document.form2.cuentacierredef.focus();</script>";
			  				}
			 			} 			  
						$oculto=$_POST['oculto'];
						if($_POST[gencom]==1)
						{
							//**** creamos tabla temporal para almacenar el comprobante 
							$sqlr="create  temporary table usr_session (id int(11),cuenta varchar(20),nombrecuenta varchar(100),tercero varchar(30),cc varchar(4),debito double,credito double)";
							mysql_query($sqlr,$linkbd);
							//*****************************************	
							ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
							$fechaf=$_POST[ages]."-01-01";
							$agetra=$fecha[3];
							$fechafa2=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
							$f1=$fechafa2;	
							ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
							$fechaf2=$_POST[ages]."-12-31";
							$f2=mktime(0,0,0,$fecha[2],$fecha[1],$fecha[3]);
							//********** calcular saldo inicial ***********
							$fechafa=$agetra."-01-01";
							$fechafa2=date('Y-m-d',$fechafa2-((24*60*60)));	
							$co='saludo1a';
							$co2='saludo2';
							$critcons=" and comprobante_det.tipo_comp <> 19 ";	 
							$tsaldant=0;
							$totaldebs=0;
							$totalcreds=0;
							$totalsaldos=0;	 	 
							//*******  MOVIMIENTO PREDIAL
							$cuenta=$_POST[cuentaemipre];
							$ncuenta=buscacuenta($cuenta);
							$cuenta2=$_POST[cuentarecpre];
							$ncuenta2=buscacuenta($cuenta2);	
							$sqlr="select distinct comprobante_det.cuenta, comprobante_det.tercero, sum(comprobante_det.valdebito), sum(comprobante_det.valcredito)  from comprobante_cab,comprobante_det where comprobante_det.tercero like '%$_POST[tercero]%' and comprobante_det.cuenta between '$cuenta' and '$cuenta' and  comprobante_cab.fecha between 	'$fechaf' and '$fechaf2' and comprobante_det.tipo_comp=comprobante_cab.tipo_comp and  comprobante_det.numerotipo=comprobante_cab.numerotipo  and comprobante_cab.estado='1' ".$critcons." AND comprobante_det.centrocosto like '%$_POST[cc]%' group by comprobante_det.cuenta, comprobante_det.tercero order by comprobante_det.cuenta, comprobante_cab.fecha, comprobante_cab.tipo_comp, comprobante_cab.numerotipo,comprobante_det.id_det";
							$res=mysql_query($sqlr,$linkbd);
							$cuentainicial='';
							$saldo=0;
							$i=1;
							echo "<tr class='ejemplo'><td>$cuenta</td><td colspan='6'>".buscacuenta($cuenta)."</td></tr>";
							while($row=mysql_fetch_row($res))
	 						{	 
	 							$saldo=$row[2]-$row[3];
	 							echo "
								<tr class='$co' style='text-transform:uppercase' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\">
								 	<td>$row[0]</td>
								 	<td>".buscacuenta($row[0])."</td>
								 	<td>$row[1]</td>
								 	<td>".buscatercero($row[1])."</td>
								 	<td style='text-align:right;'>$row[2]</td>
								 	<td style='text-align:right;'>$row[3]</td>
								 	<td style='text-align:right;'>$saldo</td></tr>";
 	 							if($saldo!=0)
	 							{
	 	 							if($saldo<0)
		 							{
		  								$sqlr="insert into usr_session (id,cuenta,nombrecuenta,tercero,cc,debito,credito) values($i,'".$cuenta."','".$ncuenta."','$row[1]','01',".abs($saldo).",0)";
		  								mysql_query($sqlr,$linkbd);
	  	  								$sqlr="insert into usr_session (id,cuenta,nombrecuenta,tercero,cc,debito,credito) values($i,'".$cuenta2."','".$ncuenta2."','$row[1]','01',0,".abs($saldo).")";
		  								mysql_query($sqlr,$linkbd);		 
		 							}
	 	 							if($saldo>0)
		 							{
		 								$sqlr="insert into usr_session (id,cuenta,nombrecuenta,tercero,cc,debito,credito) values($i,'".$cuenta2."','".$ncuenta2."','$row[1]','01',".abs($saldo).",0)";
		  								mysql_query($sqlr,$linkbd);
	  	  								$sqlr="insert into usr_session (id,cuenta,nombrecuenta,tercero,cc,debito,credito) values($i,'".$cuenta."','".$ncuenta."','$row[1]','01',0,".abs($saldo).")";
		  								mysql_query($sqlr,$linkbd);		 
		 							}
		 							$i+=1;
								}		 	 
							 	$totaldebs+=$row[2];
							 	$totalcreds+=$row[3];
							 	$totalsaldos+=$saldo;
	  							$aux=$co;
      							$co=$co2;
      							$co2=$aux;
	 						}
	 						echo "<tr class='$co'><td colspan='4' style='text-align:right;'>Totales:</td><td style='text-align:right;'>$totaldebs</td><td style='text-align:right;'>$totalcreds</td><td style='text-align:right;'>$totalsaldos</td></tr>"; 	
	  						$totaldebs=0;
							$totalcreds=0;
							$totalsaldos=0;	
	 						//*********MOVIMIENTO BOMBERIL
	 						$cuenta=$_POST[cuentaemibom];
							$ncuenta=buscacuenta($cuenta);
							$cuenta2=$_POST[cuentarecbom];
							$ncuenta2=buscacuenta($cuenta2);	
							$sqlr="select distinct comprobante_det.cuenta, comprobante_det.tercero, sum(comprobante_det.valdebito), sum(comprobante_det.valcredito)  from comprobante_cab,comprobante_det where comprobante_det.tercero like '%$_POST[tercero]%' and comprobante_det.cuenta between '$cuenta' and '$cuenta' and  comprobante_cab.fecha between 	'$fechaf' and '$fechaf2' and comprobante_det.tipo_comp=comprobante_cab.tipo_comp and  comprobante_det.numerotipo=comprobante_cab.numerotipo  and comprobante_cab.estado='1' ".$critcons." AND comprobante_det.centrocosto like '%$_POST[cc]%' group by comprobante_det.cuenta, comprobante_det.tercero order by comprobante_det.cuenta, comprobante_cab.fecha, comprobante_cab.tipo_comp, comprobante_cab.numerotipo,comprobante_det.id_det";
							$res=mysql_query($sqlr,$linkbd);
							$cuentainicial='';
							$saldo=0;
							echo "<tr class='ejemplo'><td>$cuenta</td><td colspan='6'>".buscacuenta($cuenta)."</td></tr>";
							while($row=mysql_fetch_row($res))
	 						{	 
	  							$saldo=$row[2]-$row[3];
	 							echo "
								<tr class='$co' style='text-transform:uppercase' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\">
								 	<td>$row[0]</td>
								 	<td>".buscacuenta($row[0])."</td>
								 	<td>$row[1]</td>
								 	<td>".buscatercero($row[1])."</td>
								 	<td style='text-align:right;'>$row[2]</td>
								 	<td style='text-align:right;'>$row[3]</td>
								 	<td style='text-align:right;'>$saldo</td></tr>";
 	 							if($saldo!=0)
	 							{
	 	 							if($saldo<0)
		 							{
		  								$sqlr="insert into usr_session (id,cuenta,nombrecuenta,tercero,cc,debito,credito) values($i,'".$cuenta."','".$ncuenta."','$row[1]','01',".abs($saldo).",0)";
		  								mysql_query($sqlr,$linkbd);
	  	  								$sqlr="insert into usr_session (id,cuenta,nombrecuenta,tercero,cc,debito,credito) values($i,'".$cuenta2."','".$ncuenta2."','$row[1]','01',0,".abs($saldo).")";
		  								mysql_query($sqlr,$linkbd);		 
		 							}
	 	 							if($saldo>0)
			 						{
		  								$sqlr="insert into usr_session (id,cuenta,nombrecuenta,tercero,cc,debito,credito) values($i,'".$cuenta2."','".$ncuenta2."','$row[1]','01',".abs($saldo).",0)";
		  								mysql_query($sqlr,$linkbd);
	  	  								$sqlr="insert into usr_session (id,cuenta,nombrecuenta,tercero,cc,debito,credito) values($i,'".$cuenta."','".$ncuenta."','$row[1]','01',0,".abs($saldo).")";
		  								mysql_query($sqlr,$linkbd);		 
		 							}
		 		 					$i+=1;
	 							}		 	 
	  							$totaldebs+=$row[2];
	 							$totalcreds+=$row[3];
	 							$totalsaldos+=$saldo;
	  							$aux=$co;
      							$co=$co2;
      							$co2=$aux;
	 						}	
							echo "<tr class='$co'><td></td><td></td><td></td><td></td><td style='text-align:right;'>$totaldebs</td><td style='text-align:right;'>$totalcreds</td><td style='text-align:right;'>$totalsaldos</td></tr>"; 	 
						}
					?>
				</table> 
			</div>
			<?php
				if($_POST[oculto]==2)
				{
					echo"
					<div class='subpantallac4'>
						<table class='inicio'>";	
					$sqlr="select max(numerotipo) from comprobante_cab where tipo_comp=13 ";
					$res=mysql_query($sqlr,$linkbd);
					while($r=mysql_fetch_row($res)){$maximo=$r[0];}
					$maximo+=1;	
					$sqlr="insert into comprobante_cab (numerotipo, tipo_comp, fecha, concepto, total,total_debito,total_credito,diferencia,estado) values ('$maximo','13','$fechaf2','TRASLADO SALDOS PREDIAL Y BOMBERIL VIGENCIA $_POST[ages]',0,0,0,0,'1')";	
 					if( mysql_query($sqlr,$linkbd))
  					{ 
						$sqlr="select *from usr_session ";
  						$resc=mysql_query($sqlr,$linkbd); 
	  					while($rowc=mysql_fetch_row($resc))
	   					{
	  						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado, vigencia,tipo_comp,numerotipo) values ('13 $maximo', '$rowc[1]', '$rowc[3]','$rowc[4]','TRASLADO SALDO VIGENCIA $_POST[ages]','',$rowc[5],$rowc[6], '1',$_POST[ages],13,$maximo)";
	  						mysql_query($sqlr,$linkbd); 
	   					}
	  					echo "<script>despliegamodalm('visible','3','Se ha almacenado el Comprobante de Cierre con Exito');</script>";
 					}
  					else
  					{
	  					echo "<script>despliegamodalm('visible','2','Manejador de Errores de la Clase BD, No se pudo ejecutar la petición');</script>";
		 				$e =mysql_error($respquery);
  					}
					echo "</table></div>";
				}
			?>
  		</form>
	</body>
</html>