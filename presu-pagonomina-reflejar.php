<!--V 1001 13/12/2016  ya no borra el valor de los tipo D-->
<?php
	require"comun.inc";
	require"funciones.inc";
	require "conversor.php";
	require "validaciones.inc";
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
        <title>:: SPID - Tesoreria</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
		<script>
			function buscacta(e){if (document.form2.cuenta.value!=""){document.form2.bc.value='1';document.form2.submit();}}
			function validar(){document.form2.submit();}
			function buscaop(e){if (document.form2.orden.value!=""){document.form2.bop.value='1';document.form2.submit();}}
			function agregardetalle()
			{
				if(document.form2.numero.value!="" &&  document.form2.valor.value>0 &&  document.form2.banco.value!=""  )
				{ 
					document.form2.agregadet.value=1;
					document.form2.submit();
 				}
 				else {alert("Falta informacion para poder Agregar");}
			}
			function agregardetalled()
			{
				if(document.form2.retencion.value!="" &&  document.form2.vporcentaje.value!=""  )
				{ 
					document.form2.agregadetdes.value=1;
					document.form2.submit();
				}
				else {alert("Falta informacion para poder Agregar");}
			}
			function marcar(indice,posicion)
			{	
					varcheck=document.getElementsByName('conciliados[]');
					vartipo=document.getElementsByName('tdet[]');
					tipo=vartipo.item(posicion-1).value;
					if(tipo=="N")
					{
						document.getElementById('tipoegreso').value="Nomina";
						for (x=0;x<varcheck.length;x++)
						{
							if((x+1)!=posicion){varcheck.item(x).checked=false;}
						}
					}	
					else
					{
						document.getElementById('tipoegreso').value="Otros";
						for (x=0;x<varcheck.length;x++)
						{
							if(vartipo.item(x).value=="N"){varcheck.item(x).checked=false;}
						}
					}
					if(tipo=="D")
					{
						for (x=0;x<varcheck.length;x++)
						{
							if(vartipo.item(x).value!="D"){varcheck.item(x).checked=false;}
						}
					}
					else
					{
						for (x=0;x<varcheck.length;x++)
						{
							if(vartipo.item(x).value=="D"){varcheck.item(x).checked=false;}
						}
					}
					vtabla=document.getElementById('filas'+indice);
					clase=vtabla.className;
					if(varcheck.item(posicion).checked){vtabla.style.backgroundColor='#3399bb'; }
					else
					{
						e=varcheck.item(posicion).value;
						document.getElementById('filas'+posicion).style.backgroundColor='#ffffff';
					}
					sumarconc();
			}
			function seleplanilla()
			{
				varcheck=document.getElementsByName('conciliados[]');
				vartipo=document.getElementsByName('tdet[]');
				for (x=0;x<varcheck.length;x++)
				{
					if(vartipo.item(x).value!="N" && vartipo.item(x).value!="D"){varcheck.item(x).checked=true;}
					else {varcheck.item(x).checked=false;}
				}
				sumarconc();
			}
			function limpiarsele()
			{
				varcheck=document.getElementsByName('conciliados[]');
				for (x=0;x<varcheck.length;x++){varcheck.item(x).checked=false;}
			}
			function buscater(e){if (document.form2.tercero.value!=""){document.form2.bt.value='1';document.form2.submit();}}
			function sumarconc()
			{
				alert(' este '+indice+' ch '+indice);
				vvigencias=document.getElementsByName('conciliados[]');
				valores=document.getElementsByName('dvalores[]');
				alert(' este '+indice+' ch '+posicion);
				sumacd=0;	
				sumancd=0;
				sumacc=0;
				sumancc=0;
				sumach=0;
				for (x=0;x<vvigencias.length;x++){if(vvigencias.item(x).checked){sumacd=sumacd+parseFloat(valores.item(x).value);sumach=sumach+1;}}
				saldofinal=parseFloat(document.form2.valororden.value); 
				document.form2.valorpagar.value=sumacd;       
				document.form2.saldopagar.value=saldofinal-sumacd;     
				if(sumach>1){document.form2.tercero.value='';document.form2.ntercero.value='';} 
			}
			function eliminar(variable)
			{
				if (confirm("Esta Seguro de Eliminar"))
				{
					document.form2.elimina.value=variable;
					vvend=document.getElementById('elimina');
					vvend.value=variable;
					document.form2.submit();
				}
			}
			function eliminard(variable)
			{
				if (confirm("Esta Seguro de Eliminar"))
				{
					document.form2.eliminad.value=variable;
					vvend=document.getElementById('eliminad');
					vvend.value=variable;
					document.form2.submit();
				}
			}
			function guardar()
			{
				if (document.form2.fecha.value!='' && document.form2.tipop.value!='' && document.form2.banco.value!='' && document.form2.tercero.value!='')
				{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
				else {despliegamodalm('visible','2','Faltan datos para completar el registro');}
			}
			function calcularpago()
			{
				sumacd=0;
				valores=document.getElementsByName('devalores[]');
				for (x=0;x<valores.length;x++){sumacd=sumacd+parseFloat(valores.item(x).value);}	
				document.form2.valorpagar.value=sumacd;       
			}
			function pdf()
			{
				if(document.getElementById('tipoegreso').value=="Nomina") {document.form2.action="pdfegresonominaemp.php";}
				else {document.form2.action="pdfegresonomina.php";}
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function agregaregreso()
			{
				document.form2.agregadetegre.value=1;
				document.form2.tabgroup1.value=3;
				document.form2.submit();
			}
			function despliegamodal2(_valor,scr)
			{
				if(scr=="1"){var url="cuentasbancarias-ventana02.php?tipoc=D&obj01=banco&obj02=nbanco&obj03=&obj04=cb&obj05=ter";}
				if(scr=="2"){var url="cuentasbancarias-ventana02.php?tipoc=C&obj01=banco&obj02=nbanco&obj03=&obj04=cb&obj05=ter";}
				if(scr=="3"){var url="tercerosgral-ventana01.php?objeto=tercero&nobjeto=ntercero&nfoco=cc";}
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else {document.getElementById('ventana2').src=url;}
			}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden") {document.getElementById('ventanam').src="";}
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
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.form2.oculto.value=2;document.form2.submit();break;
					case "2":
						
				}
			}

			function funcionmensaje()
			{
			}
			function excell()
			{
				document.form2.action="hum-pagonominaexcel.php";
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
			<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("teso");?></tr>
			<tr>
  				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='teso-pagonomina.php'" class="mgbt"/><img src="imagenes/guarda.png" title="Guardar" onClick="guardar()" class="mgbt"/><img src="imagenes/busca.png" title="Buscar" onClick="location.href='teso-buscapagonomina.php'" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/print.png" title="Imprimir" onClick="pdf()" class="mgbt"/><img src="imagenes/excel.png" title="Excel" onClick='excell()' class="mgbt"/></td>
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
				$vigencia=date(Y);
				$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
				$vigencia=$vigusu;
				$sqlr="select *from cuentapagar where estado='S' ";
				$res=mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($res)){$_POST[cuentapagar]=$row[1];}
$sqlr="select  sueldo, cajacompensacion, icbf,sena,iti,esap,arp,salud_empleador, salud_empleado, pension_empleador, pension_empleado, sub_alimentacion,aux_transporte,prima_navidad from humparametrosliquida ";
				$resp = mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($resp)) 
				{					 
					$_POST[salmin]=$row[0];
					$_POST[tprimanav]=$row[13];
					$_POST[cajacomp]=$row[1];
					$_POST[icbf]=$row[2];
					$_POST[sena]=$row[3];
					$_POST[iti]=$row[4];
					$_POST[esap]=$row[5];					
					$_POST[arp]=$row[6];					 					 				 					 					 		 			
					$_POST[salud_empleador]=$row[7];		
					$_POST[salud_empleado]=$row[8];
					$_POST[pension_empleador]=$row[9];
					$_POST[pension_empleado]=$row[10];
					$_POST[auxtran]=$row[12];
					$_POST[auxalim]=$row[11];	
				}
				//*********** cuenta origen va al credito y la destino al debito
				if(!$_POST[oculto])
				{
					$sqlr="select *from cuentapagar where estado='S' ";
					$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res)){$_POST[cuentapagar]=$row[1];}
					$sqlr="select *from tesoegresonomina where estado='S' ";
					$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res)){$_POST[cuentapagar]=$row[1];}
					$check1="checked";
 		 			$fec=date("d/m/Y");
					$_POST[fecha]=$fec; 		 		  			 
		 			$_POST[vigencia]=$vigusu; 		
	 				$_POST[egreso]=selconsecutivo('tesoegresosnomina','id_egreso');	 
					$_POST[tempdoc]="";
					$_POST[contadoc]=0;
					$_POST[tipoegreso]="";
				}
				
				switch($_POST[tabgroup1])
				{
					case 1: $check1='checked';break;
					case 2:	$check2='checked';break;
					case 3:	$check3='checked';
				}
			?>
  			<input type="hidden" id="cajacomp" name="cajacomp" value="<?php echo $_POST[cajacomp]?>"/>
			<input type="hidden" id="icbf" name="icbf" value="<?php echo $_POST[icbf]?>"/>
	    	<input type="hidden" id="sena" name="sena" value="<?php echo $_POST[sena]?>"/>
    		<input type="hidden" id="esap" name="esap" value="<?php echo $_POST[esap]?>"/>
			<input type="hidden" id="iti" name="iti" value="<?php echo $_POST[iti]?>"/>           
        	<input type="hidden" id="arp" name="arp" value="<?php echo $_POST[arp]?>"/>
        	<input type="hidden" id="salud_empleador" name="salud_empleador" value="<?php echo $_POST[salud_empleador]?>"/>
        	<input type="hidden" id="salud_empleado" name="salud_empleado" value="<?php echo $_POST[salud_empleado]?>"/>
        	<input type="hidden" id="transp" name="transp" value="<?php echo $_POST[transp]?>"/>
        	<input type="hidden" id="pension_empleador" name="pension_empleador" value="<?php echo $_POST[pension_empleador]?>"/>
        	<input type="hidden" id="pension_empleado" name="pension_empleado" value="<?php echo $_POST[pension_empleado]?>"/>		
		 	<input type="hidden" id="salmin" name="salmin" value="<?php echo $_POST[salmin]?>"/> 
		 	<input type="hidden" id="tprimanav" name="tprimanav" value="<?php echo $_POST[tprimanav]?>"/> 	
        	<input type="hidden" id="auxalim" name="auxalim" value="<?php echo $_POST[auxalim]?>"/> 
			<input type="hidden" id="auxtran" name="auxtran" value="<?php echo $_POST[auxtran]?>"/>    
       		<?php
	    		//***** busca tercero
			 	if($_POST[bt]=='1')
			 	{
			  		$nresul=buscatercero($_POST[tercero]);
			  		if($nresul!=''){$_POST[ntercero]=$nresul;}
			 		else{$_POST[ntercero]="";}
			 	}
				if($_POST[oculto]=='2')
				{
 					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
					$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
					//************CREACION DEL COMPROBANTE CONTABLE ************************
					$sqlr="select count(*) from tesoegresosnomina where id_egreso=$_POST[egreso] and estado ='S'";
					$res=mysql_query($sqlr,$linkbd);
					$row=mysql_fetch_row($res);
					$nreg=$row[0];
					if ($nreg==0)
	 				{
		 				$debitos=array_sum($_POST[devalores]);
						if($_POST[tipop]=='cheque'){
							$sqlr="insert into tesoegresosnomina (id_orden,fecha,vigencia,valortotal,retenciones,valorpago,concepto,banco,cheque, tercero,cuentabanco,estado,pago) values ('$_POST[orden]','$fechaf','$vigusu','$_POST[valorpagar]',0,'$_POST[valorpagar]','$_POST[concepto]', '$_POST[banco]','$_POST[ncheque]','$_POST[tercero]','$_POST[cb]','S','$_POST[tipop]')";  
						}else{
							$sqlr="insert into tesoegresosnomina (id_orden,fecha,vigencia,valortotal,retenciones,valorpago,concepto,banco,cheque, tercero,cuentabanco,estado,pago) values ('$_POST[orden]','$fechaf','$vigusu','$_POST[valorpagar]',0,'$_POST[valorpagar]','$_POST[concepto]', '$_POST[banco]','$_POST[ntransfe]','$_POST[tercero]','$_POST[cb]','S','$_POST[tipop]')";
						}
   						  
						if (!mysql_query($sqlr,$linkbd))
						{
		 					echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue><img src='imagenes\alert.png'>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
		 					echo "Ocurrió el siguiente problema:<br>";
  	 	 					echo "<pre>";
     	 					echo "</pre></center></td></tr></table>";
		 				}
  						else
  		 				{
			 				$ideg=mysql_insert_id();
							$_POST[egreso]=$ideg;				
				 			$sqlr="Select count(*) from  humnomina_prima where id_nom=$_POST[orden]";
							$resp=mysql_query($sqlr,$linkbd);
							$row=mysql_fetch_row($resp);
							$prima=$row[0]; 
		  					echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado el Egreso con Exito <img src='imagenes\confirm.png'></center></td></tr></table>";		 
		  					$sqlr="update tesoegresosnominachequeras set consecutivo=consecutivo+1 where cuentabancaria='$_POST[cb]'  and estado='S'";		  
		  					mysql_query($sqlr,$linkbd); 
		  					$sqlr="insert into tesoegresosnomina_cheque (id_cheque,id_egreso,estado,motivo) values ('$_POST[ncheque]',$ideg,'S','')";
		  					mysql_query($sqlr,$linkbd);
							for($y=0;$y<count($_POST[decuentas]);$y++)								 
				 			{
								$sqlr="insert into tesoegresosnomina_det (id_egreso,id_orden,tipo,tercero,ntercero_det,cuentap,cc,valor,estado, ndes) values ('$ideg','$_POST[orden]','".$_POST[tedet][$y]."','".$_POST[decuentas][$y]."','".$_POST[decuentas][$y]."','".$_POST[derecursos][$y]."','".$_POST[deccs][$y]."','".$_POST[devalores][$y]."','S','".$_POST[idedescuento][$y]."')";
								mysql_query($sqlr,$linkbd);
				 			}
		  					//***********crear el contabilidad
			  				 $sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia, estado) values ('$ideg','17','$fechaf','$_POST[concepto]',0,'$_POST[valorpagar]','$_POST[valorpagar]',0,'1')";
				 			mysql_query($sqlr,$linkbd);
				 			$idcomp=mysql_insert_id();
 			     			$sqlr="insert into  pptocomprobante_cab (numerotipo,tipo_comp,fecha,concepto,vigencia,total_debito,total_credito, diferencia,estado) values('$ideg','10','$fechaf','EGRESO NOMINA $_POST[concepto]',$_POST[vigencia],0,0,0,'1')";
			 	 			mysql_query($sqlr,$linkbd);			
				 			$sqlr="update tesoegresos set id_comp=$idcomp where id_egreso=$ideg ";			 			 
 			     			mysql_query($sqlr,$linkbd);
							for($y=0;$y<count($_POST[decuentas]);$y++)				
				 			{
				 				//***incluye 	PR y N --- discriminar auxilios
								if($_POST[tedet][$y]=='N')
					 			{ 					
									//*** BUSCAR NOMINA
									$vnom=0;
									$vauxali=0;
									$vauxtra=0;	
									if($prima==1)
									{
					 					$vauxali=0;
					 					$vauxtra=0;
									}
									else
									{		
										$sqlrnom="Select auxalim, auxtran, devendias from humnomina_det where id_nom=$_POST[orden] and cedulanit='".$_POST[decuentas][$y]."' and netopagar='".$_POST[devalores][$y]."'";
										$resn = mysql_query($sqlrnom,$linkbd);
										while($rown=mysql_fetch_row($resn))
										{
											$vauxali=$rown[0];
											$vauxtra=$rown[1];
											$salbas=$rown[2];
										}	
									}				
									$vnom=$_POST[devalores][$y]-$vauxali-$vauxtra;
									$vnomp=$salbas;
									if($vnom>0)
					 				{		 
					 					if($prima==1) {$concepto=buscapptovarnom($_POST[tprimanav], $_POST[tedet][$y],$vigusu);}
										else {$concepto=buscapptovarnom($_POST[salmin], $_POST[tedet][$y],$_POST[vigencia]);}
										$contable=concepto_cuentas($concepto,'H',2,$_POST[deccs][$y]);
										$tam=count($contable);
										for($z=0;$z<$tam;$z++)
										{
					 						if($contable[$z][3]=='S' and $contable[$z][1]=='N')
					 						{
												$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('17 $ideg','".$contable[$z][0]."','$_POST[tercero]' ,'".$_POST[deccs][$y]."' , 'Pago SUELDO NOMINA ','', '$vnom',0,'1' ,'$vigusu')";
												mysql_query($sqlr,$linkbd);
												//*** banco ***
												$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito, estado, vigencia) values ('17 $ideg','$_POST[banco]','$_POST[tercero]','".$_POST[deccs][$y]."','Pago Banco SUELDO NOMINA', '$_POST[cheque]  $_POST[ntransfe]',0,".$_POST[devalores][$y].",'1','$vigusu')";					
												mysql_query($sqlr,$linkbd);	
					 						}					 
										}
										$cuentap=buscapptovarnom_ppto($_POST[salmin], $_POST[tedet][$y], $_POST[deccs][$y],$_POST[vigencia]);					
					 					$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia, tipo_comp,numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values('$cuentap','$_POST[tercero]','PAGO SUELDO NOMINA','$vnomp',0,'1','$_POST[vigencia]',10,'$ideg',1,'','','$fechaf')";
					  					mysql_query($sqlr,$linkbd); 
										$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia, tipo_comp,numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values('$cuentap','$_POST[tercero]','PAGO SUELDO NOMINA',0,'$vnomp','1','$_POST[vigencia]',9,'$_POST[orden]',1,'','$ideg','$fechaf')";
					  					mysql_query($sqlr,$linkbd); 
									}
					 				//*****aux alimentacion
					 				if($vauxali>0)
					 				{
					  					$contable=array();	 				
										$concepto=buscapptovarnom($_POST[auxalim], $_POST[tedet][$y],$_POST[vigencia]); 
					 					$contable=concepto_cuentas($concepto,'H',2,$_POST[deccs][$y]); 				
										$tam=count($contable);
										for($z=0;$z<$tam;$z++)
										{
					 						if($contable[$z][3]=='S' and $contable[$z][1]=='N')
						 					{
												$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito, estado, vigencia) values ('17 $ideg','".$contable[$z][0]."','$_POST[tercero]','$_POST[deccs][$y]','Pago AUXILIO ALIMENTACION','', '$vauxali',0,'1' ,'$vigusu')";
												mysql_query($sqlr,$linkbd);
					 	 					}					 
					    				}					 			
					 					$cuentap=buscapptovarnom_ppto($_POST[auxalim], $_POST[tedet][$y], $_POST[deccs][$y],$_POST[vigencia]);	
					 					$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia, tipo_comp,numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values('$cuentap','$_POST[tercero]','PAGO AUXILIO ALIMENTACION','$vauxali',0,'1','$_POST[vigencia]',10,'$ideg',1,'','',$fechaf)";
										mysql_query($sqlr,$linkbd);
										$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia, tipo_comp,numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values('$cuentap','$_POST[tercero]','PAGO AUXILIO ALIMENTACION',0,'$vauxali','1','$_POST[vigencia]',9,'$_POST[orden]',1,'','$ideg',$fechaf)";
					  					mysql_query($sqlr,$linkbd); 
					 				}
					 				//*****aux transporte
					 				if($vauxtra>0)
					 				{
					  					$contable=array();	 				
					 					$concepto=buscapptovarnom($_POST[auxtran], $_POST[tedet][$y],$_POST[vigencia]); 
					 					$contable=concepto_cuentas($concepto,'H',2,$_POST[deccs][$y]); 				
						 				$tam=count($contable);
										for($z=0;$z<$tam;$z++)
										{
					 						if($contable[$z][3]=='S' and $contable[$z][1]=='N')
						 					{
												$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('17 $ideg','".$contable[$z][0]."','$_POST[tercero]','".$_POST[deccs][$y]."','Pago AUXILIO ALIMENTACION','', '$vauxtra',0,'1' ,'$vigusu')";
												mysql_query($sqlr,$linkbd);
					 	 					}					 
					    				}					 			
					 					$cuentap=buscapptovarnom_ppto($_POST[auxtran], $_POST[tedet][$y], $_POST[deccs][$y],$_POST[vigencia]);	
										$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia, tipo_comp,numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values('$cuentap','$_POST[tercero]','PAGO AUXILIO ALIMENTACION','$vauxtra',0,'1','$_POST[vigencia]',10,'$ideg',1,'','',$fechaf)";
										mysql_query($sqlr,$linkbd);
										$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia, tipo_comp,numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values('$cuentap','$_POST[tercero]','PAGO AUXILIO ALIMENTACION',0,'$vauxtra','1','$_POST[vigencia]',9,'$_POST[orden]',1,'','$ideg',$fechaf)";
										mysql_query($sqlr,$linkbd);
					 				}
				   					if($_POST[tedet][$y]=='N')
				    				{
				 						$sqlr="update humnomina_DET set estado='P' WHERE cedulanit='".$_POST[decuentas][$y]."' and id_nom='$_POST[orden]'";
				 						$respr=mysql_query($sqlr,$linkbd);
				    				}											 
									//***FIN PARTE SUELDO  Y AUXILIOS*****
				  				}	
				   				//****SALUD EMPLEADOR ********
				   				if($_POST[tedet][$y]=='SR')
				   				{ 
				  					$cuentap=buscapptovarnom_ppto($_POST[salud_empleador], $_POST[tedet][$y],$_POST[deccs][$y],$_POST[vigencia]);																	                   					$concepto=buscapptovarnom($_POST[salud_empleador], $_POST[tedet][$y],$_POST[vigencia]);
				   					$contable=concepto_cuentas($concepto,'H',2,$_POST[deccs][$y]);
				   					$tam=count($contable);
									for($z=0;$z<$tam;$z++)
									{
					 					if($contable[$z][3]=='S' and $contable[$z][1]=='N')
						 				{
											$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('17 $ideg','".$contable[$z][0]."','$_POST[tercero]','".$_POST[deccs][$y]."','Pago SALUD EMPLEADOR','',".$_POST[devalores][$y].",0,'1','$vigusu')";
											mysql_query($sqlr,$linkbd);
											//**BANCO
											$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('17 $ideg','$_POST[banco]','$_POST[tercero]','".$_POST[deccs][$y]."','Banco SALUD EMPLEADOR','$_POST[cheque]  $_POST[ntransfe]',0,".$_POST[devalores][$y].",'1','$vigusu')";					
											mysql_query($sqlr,$linkbd);	
					 	 				}					 
					    			}					    
				   					$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp, numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values ('$cuentap','".$_POST[decuentas][$y]."','PAGO SALUD EMPLEADOR',".$_POST[devalores][$y].",0,'1','$_POST[vigencia]','10','$ideg',1,'','',$fechaf)";
				    				mysql_query($sqlr,$linkbd); 
									$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp, numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values ('$cuentap','".$_POST[decuentas][$y]."','PAGO SALUD EMPLEADOR',0,".$_POST[devalores][$y].",'1','$_POST[vigencia]','9','$_POST[orden]',1,'','$ideg',$fechaf)";
				    				mysql_query($sqlr,$linkbd);
				    				$sqlr="update `humnomina_saludpension` set estado='P' WHERE tercero='".$_POST[decuentas][$y]."' and id_nom='$_POST[orden]' AND cc='".$_POST[deccs][$y]."' and tipo='".$_POST[tedet][$y]."'";
				    				mysql_query($sqlr,$linkbd);
				   				}//*****FIN SALUD EMPLEADOR
				   				//****PENSION EMPLEADOR ********
				 				if($_POST[tedet][$y]=='PR')
				 				{ 
				 					$cuentap=buscapptovarnom_ppto($_POST[pension_empleador], $_POST[tedet][$y],$_POST[deccs][$y],$_POST[vigencia]);
				 					$concepto=buscapptovarnom($_POST[pension_empleador], $_POST[tedet][$y],$_POST[vigencia]);
				 					$contable=concepto_cuentas($concepto,'H',2,$_POST[deccs][$y]);
				 					$tam=count($contable);
									for($z=0;$z<$tam;$z++)
									{
					 					if($contable[$z][3]=='S' and $contable[$z][1]=='N')
						 				{
											$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('17 $ideg','".$contable[$z][0]."','$_POST[tercero]' ,'".$_POST[deccs][$y]."','Pago PENSION EMPLEADOR','',".$_POST[devalores][$y].",0,'1','$vigusu')";
											mysql_query($sqlr,$linkbd);
											//**BANCO
											$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('17 $ideg','$_POST[banco]','$_POST[tercero]' ,'".$_POST[deccs][$y]."','Banco PENSION EMPLEADOR','$_POST[cheque]  $_POST[ntransfe]',0,".$_POST[devalores][$y].",'1' ,'$vigusu')";					
											mysql_query($sqlr,$linkbd);	
					 	 				}					 
					    			}					    
				   					$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp, numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values ('".$_POST[derecursos][$y]."','".$_POST[decuentas][$y]."','PAGO PENSION EMPLEADOR',".$_POST[devalores][$y].",0,'1', '$_POST[vigencia]',10,'$ideg',1,'','',$fechaf)";
				   					mysql_query($sqlr,$linkbd); 
									$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp, numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values ('".$_POST[derecursos][$y]."','".$_POST[decuentas][$y]."','PAGO PENSION EMPLEADOR',0,".$_POST[devalores][$y].",'1', '$_POST[vigencia]',9,'$_POST[orden]',1,'','$ideg',$fechaf)";
				   					mysql_query($sqlr,$linkbd); 
				    				$sqlr="update `humnomina_saludpension` set estado='P' WHERE tercero='".$_POST[decuentas][$y]."' and id_nom='$_POST[orden]' AND cc='".$_POST[deccs][$y]."' and tipo='".$_POST[tedet][$y]."' and sector='".$_POST[idedescuento][$y]."'";
				    				mysql_query($sqlr,$linkbd);
				   				}//*****FIN PENSION EMPLEADOR
					  			//****SALUD EMPLEADO ********
				 				if($_POST[tedet][$y]=='SE')
				 				{ 
				 					$cuentap=buscapptovarnom_ppto($_POST[salmin], $_POST[tedet][$y],$_POST[deccs][$y],$_POST[vigencia]);
				 					$concepto=buscapptovarnom($_POST[salud_empleado], $_POST[tedet][$y],$_POST[vigencia]);
				 					$contable=concepto_cuentas($concepto,'H',2,$_POST[deccs][$y]);
				 					$tam=count($contable);
									for($z=0;$z<$tam;$z++)
									{
					 					if($contable[$z][3]=='S' and $contable[$z][1]=='N')
						 				{
											$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito, estado, vigencia) values ('17 $ideg','".$contable[$z][0]."','$_POST[tercero]','".$_POST[deccs][$y]."','Pago SALUD EMPLEADO','',".$_POST[devalores][$y].",0,'1','$vigusu')";
											mysql_query($sqlr,$linkbd);//**BANCO
											$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('17 $ideg','$_POST[banco]','$_POST[tercero]','".$_POST[deccs][$y]."','Banco SALUD EMPLEADO','$_POST[cheque]  $_POST[ntransfe]',0,".$_POST[devalores][$y].",'1' ,'$vigusu')";					
											mysql_query($sqlr,$linkbd);	
					 	 				}					 
					    			}					    
				   					$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp, numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values ('$cuentap','".$_POST[decuentas][$y]."','PAGO SALUD EMPLEADO',0,0,'1','$_POST[vigencia]', 10,'$ideg',1,'','','$fechaf')";
				    				mysql_query($sqlr,$linkbd); 
									$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp, numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values ('$cuentap','".$_POST[decuentas][$y]."','PAGO SALUD EMPLEADO',0,0,'1','$_POST[vigencia]', 9,'$_POST[orden]',1,'','$ideg','$fechaf')";
				    				mysql_query($sqlr,$linkbd); 
				    				$sqlr="update `humnomina_saludpension` set estado='P' WHERE tercero='".$_POST[decuentas][$y]."' and id_nom='$_POST[orden]' AND cc='".$_POST[deccs][$y]."' and tipo='".$_POST[tedet][$y]."'";
				    				mysql_query($sqlr,$linkbd);
				  				} //*****FIN SALUD EMPLEADO
				 				//****PENSION EMPLEADO ********
				 				if($_POST[tedet][$y]=='PE')
				 				{ 
				 					$cuentap=buscapptovarnom_ppto($_POST[salmin], $_POST[tedet][$y],$_POST[deccs][$y],$_POST[vigencia]);
				 					$concepto=buscapptovarnom($_POST[pension_empleado], $_POST[tedet][$y],$_POST[vigencia]);
				 					$contable=concepto_cuentas($concepto,'H',2,$_POST[deccs][$y]);
				 					//echo "Cuentap=$cuentap   -    Concepto=$concepto ";
				 					$tam=count($contable);
									for($z=0;$z<$tam;$z++)
									{
					 					if($contable[$z][3]=='S' and $contable[$z][1]=='N')
						 				{
											$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('17 $ideg','".$contable[$z][0]."','$_POST[tercero]' ,'".$_POST[deccs][$y]."','Pago PENSION EMPLEADO','', ".$_POST[devalores][$y].",0,'1' ,'$vigusu')";
											mysql_query($sqlr,$linkbd);//**BANCO
											$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('17 $ideg','$_POST[banco]','$_POST[tercero]' ,'".$_POST[deccs][$y]."','Banco PENSION EMPLEADO','$_POST[cheque]  $_POST[ntransfe]',0,".$_POST[devalores][$y].",'1' ,'$vigusu')";					
											mysql_query($sqlr,$linkbd);	
					 	 				}					  
					   				}					    
				   					$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp, numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values ('$cuentap','".$_POST[decuentas][$y]."','PAGO PENSION EMPLEADO',0,0,'1','$_POST[vigencia]', 10,'$ideg',1,'','',$fechaf)";
				   					mysql_query($sqlr,$linkbd); 
									$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp, numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values ('$cuentap','".$_POST[decuentas][$y]."','PAGO PENSION EMPLEADO',0,0,'1','$_POST[vigencia]', 9,'$_POST[orden]',1,'','$ideg',$fechaf)";
				   					mysql_query($sqlr,$linkbd); 
				    				$sqlr="update humnomina_saludpension set estado='P' WHERE tercero='".$_POST[decuentas][$y]."' and id_nom='$_POST[orden]' AND cc='".$_POST[deccs][$y]."' and tipo='".$_POST[tedet][$y]."'";
				    				mysql_query($sqlr,$linkbd);
				   				}//*****FIN PENSION EMPLEADO
								//DESCUENTOS ******
								if($_POST[tedet][$y]=='D') //***DESCUENTOS
					 			{
					 				$valorp=$_POST[devalores][$y];
					 				$sqlr="SELECT id_retencion FROM humretenempleados WHERE id='".$_POST[idedescuento][$y]."'";
					 				$respr=mysql_query($sqlr,$linkbd);					 
					 				$rret=mysql_fetch_row($respr);
					 				$sqlr="select distinct *from humvariablesretenciones,humvariablesretenciones_det where humvariablesretenciones.codigo ='$rret[0]' and humvariablesretenciones.codigo=humvariablesretenciones_det.codigo ";
					 				$respr=mysql_query($sqlr,$linkbd);
									while ($rowr=mysql_fetch_row($respr)) 
									{						
					  					$ctacont=$rowr[8];	 
					 					if('S'==$rowr[10])
				  						{	
											$debito=$valorlibranza;
											$credito=0;
											$ncppto=buscacuentapres($_POST[derecursos][$y],2);
											$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('17 $ideg','$rowr[8]','$_POST[tercero]','".$_POST[deccs][$y]."','Pago $ncppto','',".$_POST[devalores][$y].", 0,'1','$vigusu')";
											mysql_query($sqlr,$linkbd);
						 				}
				 	 					if('S'==$rowr[9])
				   						{
											$valorp=$_POST[devalores][$y];
											$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('17 $ideg','$_POST[banco]','$_POST[tercero]' ,'".$_POST[deccs][$y]."','Pago Banco $ncppto','$_POST[cheque]  $_POST[ntransfe]',0,'$valorp','1','$vigusu')";					
											mysql_query($sqlr,$linkbd);
										}				 				 						
									}					 					   
									$sqlr="update humnominaretenemp SET estado = 'P' WHERE `id`='".$_POST[idedescuento][$y]."' and id_nom='$_POST[orden]'";
					 				$respr=mysql_query($sqlr,$linkbd);
					 				$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp, numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values ('".$_POST[derecursos][$y]."','".$_POST[decuentas][$y]."','PAGO DESCUENTO EMPLEADO',0,0,'1','$_POST[vigencia]',10,'$ideg',1,'','',$fechaf)";
				    				mysql_query($sqlr,$linkbd); 
									$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp, numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values ('".$_POST[derecursos][$y]."','".$_POST[decuentas][$y]."','PAGO DESCUENTO EMPLEADO',0,0,'1','$_POST[vigencia]',9,'$_POST[orden]',1,'','$ideg',$fechaf)";
				    				mysql_query($sqlr,$linkbd);
				   				}//**** FIN DESCUENTOS *****
								if($_POST[tedet][$y]=='F')
					 			{ 
									$cuentap=buscapptovarnom_ppto($_POST[idedescuento][$y], $_POST[tedet][$y],$_POST[deccs][$y],$_POST[vigencia]);
						 			$concepto=buscapptovarnom($_POST[idedescuento][$y], $_POST[tedet][$y],$vigusu); 
						 			$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp, numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values ('$cuentap', '".$_POST[decuentas][$y]."','PAGO PARAFISCALES ".$_POST[idedescuento][$y]."',".$_POST[devalores][$y].",0,'$_POST[estadoc]','$_POST[vigencia]',10,'$ideg',1,'','',$fechaf)";
				    				mysql_query($sqlr,$linkbd); 
									$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp, numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values ('$cuentap', '".$_POST[decuentas][$y]."','PAGO PARAFISCALES ".$_POST[idedescuento][$y]."',0,".$_POST[devalores][$y].",'$_POST[estadoc]','$_POST[vigencia]',9,'$_POST[orden]',1,'','$ideg',$fechaf)";
				    				mysql_query($sqlr,$linkbd);
					 				$sqlr="update humnomina_parafiscales set estado='P' WHERE id_nom='$_POST[orden]' AND cc='".$_POST[deccs][$y]."' and id_parafiscal='".$_POST[idedescuento][$y]."'";
				    				mysql_query($sqlr,$linkbd);	
									$sqlr="select * from conceptoscontables_det where codigo='$concepto' and modulo='2' and cc='".$_POST[deccs][$y]."' and tipo='H'";	  
									$resc = mysql_query($sqlr,$linkbd);
									while($rowc=mysql_fetch_row($resc))
									{
										if($rowc[7]=='S')
					    				{
						 					if($rowc[3]=='N')
						   					{
												$ncppto=buscacuentapres($_POST[decuentas][$y],2);
	 											$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('17 $ideg','$rowc[4]','$_POST[tercero]' ,'".$_POST[deccs][$y]."' , 'Pago $ncppto','',".$_POST[devalores][$y].",0,'1' ,'$vigusu')";
												mysql_query($sqlr,$linkbd);
						  						if($rowc[3]=='N')
						   						{
													$valorp=$_POST[devalores][$y];
													//***buscar retenciones
						 							//INCLUYE EL CHEQUE
	 												$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito, estado, vigencia) values ('17 $ideg','$_POST[banco]','$_POST[tercero]' ,'".$_POST[deccs][$y]."','Pago Banco $ncppto','$_POST[cheque]  $_POST[ntransfe]',0,'$valorp','1' ,'$vigusu')";					
													mysql_query($sqlr,$linkbd);	
						   						}
						  					}
						 				}
									}	  
								}//***if para saber si es un descuento
					 		}			  			 
		 				}
 					}
 					else
   					{
 						echo "<table class='inicio'><tr><td class='saludo1'><center>No se puede almacenar, ya existe un egreso para esta orden <img src='imagenes\alert.png'></center></td></tr></table>";
  					}
				}//************ FIN DE IF OCULTO************
 				if($_POST[bop]=='1')
			 	{
					if($_POST[orden]!='' )
				 	{
			  			//*** busca detalle cdp
  						$sqlr="select *from humnomina where id_nom=$_POST[orden] and estado='P'";
						$resp = mysql_query($sqlr,$linkbd);
						$row =mysql_fetch_row($resp);
						$_POST[concepto]="Nomina ".$_POST[orden]." Mes ".$row[3]." Vigencia ".$row[7];
						$_POST[tercero]=$row[6];
						$_POST[ntercero]=buscatercero($_POST[tercero]);
						$_POST[valororden]=$row[10];
						$_POST[retenciones]=$row[12];
						$_POST[totaldes]=number_format($_POST[retenciones],2);
						$_POST[bop]="";
						$_POST[vigencia]=$row[7];	
			  		}
			 		else
			 		{
			  			$_POST[cdp]="";
			  			$_POST[detallecdp]="";
			  			$_POST[tercero]="";
			  			$_POST[ntercero]="";
			  			$_POST[bop]="";
			  		}
				}	  		 
        	?>
            
 			<div class="tabsctas" style="height:70.5%; width:99.6%;"> 
   				<div class="tab"> 
       				<input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
	  				<label for="tab-1">Nomina</label>
	   				<div class="content" style="overflow-x:hidden;">
	   					<table class="inicio" align="center" >       
	  						<tr>
	     						<td colspan="6" class="titulos">Comprobante de Egreso</td>
                                <td class="cerrar" style="width:7%;"><a onClick="location.href='teso-principal.php'">&nbsp;Cerrar</a></td>
                          	</tr>
       						<tr>
                            	<td class="saludo1" >No Egreso:</td>
                                <td>
									<input name="vigencia" type="hidden" value="<?php echo $_POST[vigencia]?>" >
									<input name="cuentapagar" type="hidden" value="<?php echo $_POST[cuentapagar]?>" >
									<input name="egreso" type="text" value="<?php echo $_POST[egreso]?>"  onKeyUp="return tabular(event,this)" onKeyDown="mascara(this,'/',patron,true)" onBlur="buscarp(event)" readonly >
								</td>
       							<td class="saludo1">Liquidacion Nomina:</td>
	  							<td >
									<input name="orden" type="text" value="<?php echo $_POST[orden]?>"  onKeyUp="return tabular(event,this)" onBlur="buscaop(event)"  >
									<input type="hidden" value="0" name="bop"> <a href="#" onClick="mypop=window.open('nomina-ventana.php?vigencia=<?php echo $_POST[vigencia]?>','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=900,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>
								</td>
							</tr> 
							<tr>
								<td class="saludo1">Valor Liquidacion:</td>
                                <td>
									<input name="valororden" type="text" id="valororden" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[valororden]?>" readonly>
								</td> 
                                <td class="saludo1">RP:</td>
                                <td><input name="rp" type="text" id="rp" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[rp]?>"  readonly></td>	 
                                <td class="saludo1">Saldo RP:</td>
                                <td><input name="saldopagar" type="text" id="saldopagar" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[saldopagar]?>"  readonly> <input type="hidden" value="1" name="oculto"><input type="hidden" value="0" name="agregadetegre"></td>
                        	</tr>	
      					</table>
      					<?php
      						//***MOSTRAR REGISTRO PRESUPUESTAL
      	  					$_POST[brp]=0;
	  						//*** busca contenido del rp
							$_POST[drcuentas]=array();
							$_POST[drncuentas]=array();
							$_POST[drvalores]=array();
							$_POST[drsaldos]=array();	  
							$_POST[drrecursos]=array();
							$_POST[drnrecursos]=array();	  	  
							$_POST[drubros]=array();	  	  	  
	  						$sqlr="select *from pptorp_detalle where pptorp_detalle.consvigencia=(select pptorp.consvigencia from pptorp where consvigencia='$_POST[rp]' and pptorp.vigencia=$_POST[vigencia] ) and pptorp_detalle.vigencia=$_POST[vigencia]";
	 						$res=mysql_query($sqlr,$linkbd);
							while($r=mysql_fetch_row($res))
	 						{
	  							$consec=$r[0];	  
	  							$_POST[drcuentas][]=$r[3];
	  							$_POST[drvalores][]=$r[5];
	  							$_POST[drsaldos][]=$r[7];
	   							$_POST[drncuentas][]=buscacuentapres($r[3],2);	   
	   							$_POST[drubros][]=$r[3];	   
	   							$ind=substr($r[3],0,1);
			  					if ($ind=='2')
			  						$sqlr="select pptocuentas.futfuentefunc,pptocuentaspptoinicial.saldoscdprp,pptofutfuentefunc.nombre from pptocuentas,pptocuentaspptoinicial,pptofutfuentefunc where pptocuentas.cuenta='$r[3]' and pptocuentas.cuenta=pptocuentaspptoinicial.cuenta and pptocuentas.futfuentefunc=pptofutfuentefunc.codigo";
			 					if ($ind=='3' || $ind=='4')
			  						$sqlr="select pptocuentas.futfuenteinv,pptocuentaspptoinicial.saldoscdprp,pptofutfuenteinv.nombre from pptocuentas,pptocuentaspptoinicial,pptofutfuenteinv where pptocuentas.cuenta='$r[3]' and pptocuentas.cuenta=pptocuentaspptoinicial.cuenta and pptofutfuenteinv.codigo=pptocuentas.futfuenteinv";
			  					$res2=mysql_query($sqlr,$linkbd);
			  					$row=mysql_fetch_row($res2);
    							if($row[1]!='' || $row[1]!=0)
			     				{
				  					$_POST[drrecursos][]=$row[0];
				  					$_POST[drnrecursos][]=$row[2];
				 				}
				 				else
				  				{
				  					$_POST[drrecurso][]="";
				  					$_POST[drnrecurso][]="";
				  				}	 
		 					}
		 				?>
						<table class="inicio">
                            <tr><td colspan="8" class="titulos">Detalle Registro Presupuestal</td></tr>                  
                            <?php
                                if($_POST[todos]==1){$checkt='checked';}
                                else {$checkt='';}
                            ?>
							<tr>
                            	<td class="titulos2">Cuenta</td>
                                <td class="titulos2">Nombre Cuenta</td>
                                <td class="titulos2">Recurso</td>
                                <td class="titulos2">Valor</td>
                                <td class="titulos2">Saldo</td>
                           	</tr>
							<?php
		  						$_POST[totalv]=0;
		  						$_POST[totals]=0;	
		  						$iter="zebra1";
		  						$iter2="zebra2";
		 						for ($x=0;$x<count($_POST[drcuentas]);$x++)
		 						{		
		 							$chk=''; 
									$ch=esta_en_array($_POST[drubros],$_POST[drcuentas][$x]);
									if($ch=='1')
			 						{
			 							$chk="checked";
			 							$_POST[totalv]=$_POST[totalv]+$_POST[drvalores][$x];
			 							$_POST[totals]=$_POST[totals]+$_POST[drsaldos][$x];			 
			 						}			
		 							echo "
									<tr class='$iter'>
		 								<td ><input name='drcuentas[]' value='".$_POST[drcuentas][$x]."' type='hidden' size='40' readonly>".$_POST[drcuentas][$x]."</td>
		 								<td style='text-transform:uppercase'><input name='drncuentas[]' value='".$_POST[drncuentas][$x]."' type='hidden' size='80' readonly>".$_POST[drncuentas][$x]."</td>
		 								<td style='text-transform:uppercase'><input name='drrecursos[]' value='".$_POST[drrecursos][$x]."' type='hidden' ><input name='drnrecursos[]' value='".$_POST[drnrecursos][$x]."' type='hidden' size='40' readonly>".$_POST[drnrecursos][$x]."</td>
		 								<td align='right'><input name='drvalores[]' value='".$_POST[drvalores][$x]."' type='hidden' size='20' readonly>".number_format($_POST[drvalores][$x],2,".",",")."</td>
		 								<td align='right'><input name='drsaldos[]' value='".$_POST[drsaldos][$x]."' type='hidden' size='20'  readonly>".number_format($_POST[drsaldos][$x],2,".",",")."</td>
									</tr>";
		 							$aux=$iter2;
		 							$iter2=$iter;
		 							$iter=$aux;
		 						}
								$resultado = convertir($_POST[totalc]);
								$_POST[letras]=$resultado." PESOS M/CTE";
		 						$_POST[totalvf]=number_format($_POST[totalv],2,".",",");
								$_POST[totalsf]=number_format($_POST[totals],2,".",",");		 
	    						echo "
								<tr class='$iter'>
									<td colspan='2'></td>
									<td style='text-align:right;'>TOTAL:</td>
									<td><input name='totalvf' type='text' value='$_POST[totalvf]' readonly style='text-align:right;'><input name='totalv' type='hidden' value='$_POST[totalv]'></td>
									<td><input name='totalsf' type='text' value='$_POST[totalsf]' readonly style='text-align:right;'><input name='totals' type='hidden' value='$_POST[totals]'></td>
								</tr>
								<tr>
									<td  class='saludo1'>Son:</td> 
									<td colspan='5' class='saludo1'><input name='letras' type='text' value='$_POST[letras]' style='width:100%' class='inpnovisibles'></td>
								</tr>";		
							?>
	   					</table>
	 				</div>
    			</div>
				<input type="hidden" id="tipoegreso" name="tipoegreso" value="<?php echo $_POST[tipoegreso]?>"/> 
				<div class="tab">
       				<input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?>>
       				<label for="tab-2">Detalles</label>
       				<div class="content" style="overflow:hidden;"> 
					<table class="inicio">
	  			 	<tr>
                    	<td colspan="5" class="titulos">Detalle Orden de Pago</td>
                         <td class="titulos" style="text-align:center;width:5%"><input type="button" name="creaegreso" id="creaegreso" value=" Limpiar" onClick="limpiarsele()"></td>
                        <td class="titulos" style="text-align:center;width:7%"><input type="button" name="creaegreso" id="creaegreso" value=" Seleccionar Planilla " onClick="seleplanilla()"></td>
						<td class="titulos" style="text-align:center;width:7%"><input type="button" name="creaegreso" id="creaegreso" value=" Crear Egreso " onClick="agregaregreso()" style="background-color:#36D000 !important;"></td>
                    	<td class="cerrar" style="width:7%;"><a onClick="location.href='teso-principal.php'">&nbsp;Cerrar</a></td>
                    </tr>   
					</table>
					<div class="subpantallac5" style="overflow-x:hidden;">
 				<table class="inicio">
	  			 	         
					<tr>
                    	<td class="titulos2" style="width:6%">No - Tipo</td>
                        <td class="titulos2">Nit</td>
                        <td class="titulos2">Tercero</td>
                        <td class="titulos2">CC</td>
                        <td class="titulos2">Item</td>
                        <td class="titulos2">Cuenta Presupuestal</td>
                        <td class="titulos2" style="width:15%">Valor</td>
                        <td class="titulos2" style="width:4%">-</td>
                   	</tr>
					<?php 		
						if ($_POST[elimina]!='')
		 				{ 
		 					$posi=$_POST[elimina];
		 					unset($_POST[dccs][$posi]);
		 					unset($_POST[dvalores][$posi]);		 
		 					$_POST[dccs]= array_values($_POST[dccs]); 
		 				}	 
		 				if ($_POST[agregadet]=='1')
		 				{
		 					$_POST[dccs][]=$_POST[cc];
		 					$_POST[agregadet]='0';
		  					echo"
		 					<script>
		  						//document.form2.cuenta.focus();	
								document.form2.banco.value='';
								document.form2.nbanco.value='';
								document.form2.banco2.value='';
								document.form2.nbanco2.value='';
								document.form2.cb.value='';
								document.form2.cb2.value='';
								document.form2.valor.value='';	
								document.form2.numero.value='';	
								document.form2.agregadet.value='0';				
								document.form2.numero.select();
								document.form2.numero.focus();	
		 					</script>";
		  				}
		  				$iter='saludo1a';
		  				$iter2='saludo2';
		  				$_POST[totalc]=0;
		  				$veps[]=array();				
						$veps2[]=array();				
						$vafp[]=array();
						$vafp2[]=array();
						$vasec[]=array();
						$varp[]=array();				
						$vcpemp=array();
						$vccemp=array();
		  				$sqlrsape="SELECT * FROM  humnomina_saludpension WHERE  id_nom=$_POST[orden]";
						$ressa = mysql_query($sqlrsape,$linkbd);				 
				 		while($rowsa=mysql_fetch_row($ressa))
				 		{
				 			$ccpersona=$rowsa[4];
				 			//****PARAFISCALES SALUD Y PENSION		
				 			if($rowsa[1]=='SE')
				 			{
						 		$eps=$rowsa[3];
						 		$veps2[$ccpersona][$eps]+=$rowsa[5];
				 			}
				 			if($rowsa[1]=='SR')
				 			{
				 				$eps=$rowsa[3];
				 				$veps[$ccpersona][$eps]+=$rowsa[5];
				 			}
				 			if($rowsa[1]=='PR' ) 
					 		{
				 				$afp=$rowsa[3];
				 				$secter=$rowsa[3];
				 				$vafp[$ccpersona][$secter]+=$rowsa[5];				
					 		}
				 			if($rowsa[1]=='PE' || $rowsa[1]=='FS')
 					 		{
					 			$afp=$rowsa[3];
				   				$vafp2[$ccpersona][$afp]+=$rowsa[5];
				 			}
		 		  		}
						//primera parte de los detalles de la orden de pago DATOS EMPLEADOS
		  				$sqlr="select * from humnomina_det where id_nom=$_POST[orden] and 'P'=(select estado from humnomina where id_nom=$_POST[orden]) ORDER BY cedulanit";
						$dcuentas[]=array();
						$dncuentas[]=array();
						$resp2 = mysql_query($sqlr,$linkbd);
				 		$i=1;
						while($row2=mysql_fetch_row($resp2))
	 					{
				 			$chk="";		
				 			$ccpersona=buscaccnomina($row2[1]);
							//***parafiscales *** aportes ***
							$ctapres=buscavariablepago('01',$ccpersona);
							$vcpemp[$row2[1]]=$ctapres;
							$vccemp[$row2[1]]=$ccpersona;
				 			$ch=esta_en_array($_POST[conciliados], $i);
							if($ch==1){$chk="checked";$tipclase='saludo1v';}	
							else {$tipclase=$iter;}
				  			$ntercero=buscatercero($row2[1]);
				   			$dsb="";
				   			$dsb2="<img src='imagenes/dinerob1.png' title='NO PAGO' style='width:18px;' />";
							if($row2[19]=='P')
					 		{
					 			$dsb=" disabled";					
					 			$dsb2="<img src='imagenes/dinero1.png' title='PAGO' style='width:18px' />";	
			 		 		}	
							echo "
							<input type='hidden' name='codigos[]' value='$row2[1]'/>
							<input type='hidden' name='tdet[]' value='N'/>
							<input type='hidden' name='dcuentas[]' value='$row2[1]'/>
							<input type='hidden' name='dncuentas[]' value='$ntercero'/>
							<input type='hidden' name='dccs[]' value='$ccpersona'/>
							<input type='hidden' name='drecursos[]' value='$ctapres'/>
							<input type='hidden' name='dvalores[]' value='".round($row2[18], 0, PHP_ROUND_HALF_UP)."'/>
							<input type='hidden' name='detalles[]' value='$row2[2]'/>
							<input type='hidden' name='iddescuento[]' value=''/>
							<input type='hidden' name='saldevengado[]' value='$row2[9]'/>
							<input type='hidden' name='valarl[]' value='$row2[30]'/>
							<input type='hidden' name='valsalud[]' value='$row2[10]'/>
							<input type='hidden' name='valpension[]' value='$row2[12]'/>
							<input type='hidden' name='valfondosol[]' value='$row2[14]'/>
							<input type='hidden' name='valdeducciones[]' value='$row2[16]'/>
							<tr class='$tipclase' id='filas$i'>
								<td>$i N</td>
								<td>$row2[1]</td>
								<td>$ntercero</td>
								<td>$ccpersona</td>
								<td>Salario Empleado</td>
								<td>$ctapres</td>
								<td style='text-align:right;'>$ ".number_format(round($row2[18], 0, PHP_ROUND_HALF_UP),2,'.',',')."</td>
								<td><input type='checkbox' name='conciliados[]' value='$i' $chk onClick='marcar($row2[1],$i);'  $dsb  class='defaultcheckbox'>&nbsp;&nbsp;$dsb2</td>
							</tr>";
							$_POST[totalc]=$_POST[totalc]+$row2[18];
		 					$_POST[totalcf]=number_format($_POST[totalc],2,".",",");
		 					$i+=1;
		 					$aux=$iter;
		 					$iter=$iter2;
		 					$iter2=$aux;
	 					}
		 				//SEGUNDA PARTE parte de los detalles de la orden de pago DATOS SALUD A
						$sqlr="select * from centrocosto where estado='S'";
						$rescc=mysql_query($sqlr,$linkbd);
	 					while ($rowcc =mysql_fetch_row($rescc)) 
	 					{		
		  					foreach($veps[$rowcc[0]] as $k => $valrubros)
		   					{
			    				$chk="";	
								$dsb="";
								$dsb2="<img src='imagenes/dinerob1.png' title='NO PAGO' style='width:18px;' />";
			   					$ch=esta_en_array($_POST[conciliados], $i);
								if($ch==1){$chk="checked";}	 			
								$ctapres=buscaparafiscal($_POST[salud_empleador],$rowcc[0],'');  
		 						$ntercero=buscatercero($k);
		   						$estadop=buscanominaparafiscal_estado($_POST[orden],'SR',$k,$rowcc[0],'');
		 			 			if($estadop=='P')
					 			{
					 				$dsb=" disabled";					
					 				$dsb2="<img src='imagenes/dinero1.png' title='PAGO' style='width:18px' />";	
			 		 			}
		 						echo "
								<input type='hidden' name='codigos[]' value='$row2[1]'/>
								<input type='hidden' name='tdet[]' value='SR'/>
								<input type='hidden' name='dcuentas[]' value='$k'/>
								<input type='hidden' name='dncuentas[]' value='$ntercero'/>
								<input type='hidden' name='dccs[]' value='$rowcc[0]'/>
								<input type='hidden' name='drecursos[]' value='$ctapres'/>
								<input type='hidden' name='dvalores[]' value='".round($valrubros, 0, PHP_ROUND_HALF_UP)."'/>
								<input type='hidden' name='detalles[]' value='$row2[2]'>
								<input type='hidden' name='iddescuento[]' value=''>
								<tr class='$iter' id='filas$i'>
		 							<td>$i SR</td>
		 							<td>$k</td>
		 							<td>$ntercero</td>
		 							<td>$rowcc[0]</td>
									<td>Salud Empresa</td>
									<td>$ctapres</td>
									<td style='text-align:right;'>$ ".number_format(round($valrubros, 0, PHP_ROUND_HALF_UP),2,'.',',')."</td>
		 							<td><input type='checkbox' name='conciliados[]' value='$i' $chk onClick='marcar($k,$i);' $dsb class='defaultcheckbox'>&nbsp;&nbsp;$dsb2</td>
								</tr>";
		 						$_POST[totalc]=$_POST[totalc]+$valrubros;
		 						$_POST[totalcf]=number_format($_POST[totalc],2,".",",");
		 						$i+=1;
 		 						$aux=$iter;
		 						$iter=$iter2;
		 						$iter2=$aux;
		   					}
		  				}
		  				//TERCERA PARTE parte de los detalles de la orden de pago SALUD EMPLEADO
		  				$sqlr="select *from centrocosto where estado='S'";
						$rescc=mysql_query($sqlr,$linkbd);
	 					while ($rowcc =mysql_fetch_row($rescc)) 
	 					{		
		  					foreach($veps2[$rowcc[0]] as $k => $valrubros)
		   					{
			    				$chk="";
								$dsb="";
								$dsb2="<img src='imagenes/dinerob1.png' title='NO PAGO' style='width:18px;' />";	
			   					$ch=esta_en_array($_POST[conciliados], $i);
								if($ch==1){$chk="checked";}	 
								$ctapres=buscavariablepago($_POST[salmin],$rowcc[0]);  
		 						$ntercero=buscatercero($k);
		 	 		  			$estadop=buscanominaparafiscal_estado($_POST[orden],'SE',$k,$rowcc[0],'');
		 			 			if($estadop=='P')
								{
					 				$dsb=" disabled";					
					 				$dsb2="<img src='imagenes/dinero1.png' title='PAGO' style='width:18px' />";	
			 		 			}
		 						echo "
								<input type='hidden' name='codigos[]' value='$row2[1]'/>
								<input type='hidden' name='tdet[]' value='SE'/>
								<input type='hidden' name='dcuentas[]' value='$k'/>
								<input type='hidden' name='dncuentas[]' value='".$ntercero."-EO'/>
								<input type='hidden' name='dccs[]' value='$rowcc[0]'/>
								<input type='hidden' name='drecursos[]' value='$ctapres'/>
								<input type='hidden' name='dvalores[]' value='".round($valrubros, 0, PHP_ROUND_HALF_UP)."'/>
								<input type='hidden' name='detalles[]' value='$row2[2]'>
								<input type='hidden' name='iddescuento[]' value=''>
								<tr class='$iter' id='filas$i'>
		 							<td>$i SE</td>
		 							<td>$k</td>
		 							<td>".$ntercero."-EO</td>
		 							<td>$rowcc[0]</td>
									<td>Salud Empleados</td>
		 							<td>$ctapres</td>
		 							<td style='text-align:right;'>$ ".number_format(round($valrubros, 0, PHP_ROUND_HALF_UP),2,'.',',')."</td>
		 							<td><input type='checkbox' name='conciliados[]' value='$i' $chk onClick='marcar($k,$i);' $dsb class='defaultcheckbox'>&nbsp;&nbsp;$dsb2</td>
								</tr>";
		 						$_POST[totalc]=$_POST[totalc]+$valrubros;
								$_POST[totalcf]=number_format($_POST[totalc],2,".",",");
		 						$i+=1;
 		 						$aux=$iter;
		 						$iter=$iter2;
		 						$iter2=$aux;
		   					}
		  				}
		 				//CUARTA PARTE parte de los detalles de la orden de pago PENSION EMPRESA
		 				$sqlr="select *from centrocosto where estado='S'";
						$rescc=mysql_query($sqlr,$linkbd);
	 					while ($rowcc =mysql_fetch_row($rescc)) 
	 	  				{		
		  					foreach($vafp[$rowcc[0]] as $k => $valrubros)
		   					{
			    				$chk="";	
								$dsb="";
								$dsb2="<img src='imagenes/dinerob1.png' title='NO PAGO' style='width:18px;' />";
			 					$ch=esta_en_array($_POST[conciliados], $i);
								if($ch==1){$chk="checked";}	   
								$sectortercero=explode("_",$k);	 
 		 						$ctapres=buscaparafiscal($_POST[pension_empleador],$rowcc[0],$sectortercero[1]);  
		 						$ntercero=buscatercero($sectortercero[0]);
		  						$estadop=buscanominaparafiscal_estado($_POST[orden],'PR',$sectortercero[0],$rowcc[0],$sectortercero[1]);
								
		 			 			if($estadop=='P')
					 			{
					 				$dsb=" disabled";					
					 				$dsb2="<img src='imagenes/dinero1.png' title='PAGO' style='width:18px' />";	
			 		 			}
		 						echo "
								<input type='hidden' name='tdet[]' value='PR'/>
								<input type='hidden' name='dcuentas[]' value='$sectortercero[0]'/>
								<input type='hidden' name='dncuentas[]' value='$ntercero'/>
								<input type='hidden' name='dccs[]' value='$rowcc[0]'/>
								<input type='hidden' name='drecursos[]' value='$ctapres'/>
								<input type='hidden' name='dvalores[]' value='".round($valrubros, 0, PHP_ROUND_HALF_UP)."'/>
								<input type='hidden' name='detalles[]' value='$row2[2]'/>
								<input type='hidden' name='iddescuento[]' value='$sectortercero[1]'/>
								<tr class='$iter' id='filas$i'>
									<td>$i PR</td>
		 							<td>$sectortercero[0]</td>
		 							<td>$ntercero</td>
		 							<td>$rowcc[0]</td>
									<td>Pensión Empresa</td>
		 							<td>$ctapres</td>
		 							<td style='text-align:right;'>$ ".number_format(round($valrubros, 0, PHP_ROUND_HALF_UP),2,'.',',')."</td>
		 							<td><input type='checkbox' name='conciliados[]' value='$i' $chk onClick='marcar($k,$i);' $dsb class='defaultcheckbox'>&nbsp;&nbsp;$dsb2</td>
								</tr>";
		 						$_POST[totalc]=$_POST[totalc]+$valrubros;
		 						$_POST[totalcf]=number_format($_POST[totalc],2,".",",");
		 						$i+=1;
		 						$aux=$iter;
		 						$iter=$iter2;
		 						$iter2=$aux;
		   					}
		 				}
		 				//QUINTA PARTE parte de los detalles de la orden de pago PENSION EMPLEADO
		 				$sqlr="select *from centrocosto where estado='S'";
						$rescc=mysql_query($sqlr,$linkbd);
	 					while ($rowcc =mysql_fetch_row($rescc)) 
	 	  				{		
		  					foreach($vafp2[$rowcc[0]] as $k => $valrubros)
		   					{
			    				$chk="";	
								$dsb="";
								$dsb2="<img src='imagenes/dinerob1.png' title='NO PAGO' style='width:18px;' />";
			 					$ch=esta_en_array($_POST[conciliados], $i);
								if($ch==1){$chk="checked";}	   
		  						$ctapres=buscavariablepago($_POST[salmin],$rowcc[0]);  
		 						$ntercero=buscatercero($k);
		 		  				$estadop=buscanominaparafiscal_estado($_POST[orden],'PE',$k,$rowcc[0],'');
		 			 			if($estadop=='P')
					 			{
					 				$dsb=" disabled";					
					 				$dsb2="<img src='imagenes/dinero1.png' title='PAGO' style='width:18px' />";	
			 		 			}
		 						echo "
								<input type='hidden' name='tdet[]' value='PE'/>
								<input type='hidden' name='dcuentas[]' value='$k'/>
								<input type='hidden' name='dncuentas[]' value='$ntercero'/>
								<input type='hidden' name='dccs[]' value='$rowcc[0]'/>
								<input type='hidden' name='drecursos[]' value='$ctapres'/>
								<input type='hidden' name='dvalores[]' value='".round($valrubros, 0, PHP_ROUND_HALF_UP)."'/>
								<input type='hidden' name='detalles[]' value='$row2[2]'>
								<input type='hidden' name='iddescuento[]' value=''>
								<tr class='$iter' id='filas$i'>
		 							<td>$i PE</td>
		 							<td>$k</td>
		 							<td>$ntercero</td>
		 							<td>$rowcc[0]</td>
									<td>Pensión Empleados</td>
									<td>$ctapres</td>
		 							<td style='text-align:right;'>$ ".number_format(round($valrubros, 0, PHP_ROUND_HALF_UP),2,'.',',')."</td>
		 							<td><input type='checkbox' name='conciliados[]' value='$i' $chk onClick='marcar($k,$i);' $dsb class='defaultcheckbox'>&nbsp;&nbsp;$dsb2</td>
								</tr>";
								$_POST[totalc]=$_POST[totalc]+$valrubros;
		 						$_POST[totalcf]=number_format($_POST[totalc],2,".",",");
		 						$i+=1;
		 						$aux=$iter;
		 						$iter=$iter2;
		 						$iter2=$aux;
		   					}
		 				}		 
		 				//SEXTA PARTE parte de los detalles de la orden de pago DESCUENTOS RETENCIONES Y LIBRANZAS
		 				$sqlrdesc="
						SELECT DISTINCT humnominaretenemp.ID_NOM, humnominaretenemp.ID,humnominaretenemp.CEDULANIT, humnominaretenemp.VALOR, humretenempleados.id ,humretenempleados.id_retencion, humretenempleados.VALORCUOTA, humvariablesretenciones.beneficiario, humnominaretenemp.estado,humretenempleados.DESCRIPCION  
						FROM humnominaretenemp, humretenempleados, humvariablesretenciones 
						WHERE humnominaretenemp.ID=humretenempleados.id AND humretenempleados.id_retencion=humvariablesretenciones.CODIGO and humnominaretenemp.ID_NOM=$_POST[orden]";
		 				$resp2 = mysql_query($sqlrdesc,$linkbd);			 
		 				while($row2=mysql_fetch_row($resp2))
				 		{
							$dsb=" ";					
					 		$dsb2="<img src='imagenes/dinerob1.png' title='NO PAGO' style='width:18px;' />";	
					  		$chk="";	
				 			if($row2[8]=='P')
					 		{
					 			$dsb=" disabled";					
					 			$dsb2="<img src='imagenes/dinero1.png' title='PAGO' style='width:18px' />";	
			 		 		}	
					  		$ch=esta_en_array($_POST[conciliados], $i);
							if($ch==1){$chk="checked";}	
					 		$ntercero=buscatercero($row2[7]);
					 		$valores=$row2[6]; 
		 					echo "
							<input type='hidden' name='tdet[]' value='D'/>
							<input type='hidden' name='dcuentas[]' value='$row2[7]'/>
							<input type='hidden' name='dncuentas[]' value='$ntercero - $row2[9]'/>
							<input type='hidden' name='dccs[]' value='".$vccemp[$row2[2]]."'/>
							<input type='hidden' name='drecursos[]' value='".$vcpemp[$row2[2]]."'/>
							<input type='hidden' name='dvalores[]' value='".round($row2[3], 0, PHP_ROUND_HALF_UP)."'>
							<input type='hidden' name='detalles[]' value='$row2[2]'>
							<input type='hidden' name='iddescuento[]' value='$row2[1]'>
							<tr class='$iter' id='filas$i'>
								<td>$i D</td>
		 						<td>$row2[7]</td>
		 						<td>$ntercero - $row2[9]</td>
		 						<td>".$vccemp[$row2[2]]."</td>
								<td>Descuantos y Libranzas</td>
		 						<td>".$vcpemp[$row2[2]]."</td>
		 						<td style='text-align:right;'>$ ".number_format(round($row2[3], 0, PHP_ROUND_HALF_UP),2,'.',',')."</td>
		 						<td><input type='checkbox' name='conciliados[]' value='$i' $chk onClick='marcar($k,$i);'   $dsb class='defaultcheckbox'>&nbsp;&nbsp;$dsb2</td>
							</tr>";
							$_POST[totalc]=$_POST[totalc]+$valores;
							$_POST[totalcf]=number_format($_POST[totalc],2,".",",");
							$i+=1;
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux;
				 		}
		 				//SEPTIMA PARTE parte de los detalles de la orden de pago PARAFISCALES 
		 				$sqlr="select *from admfiscales where estado='S' and vigencia=$vigusu";
		  				$resp2 = mysql_query($sqlr,$linkbd);			
						while($row2=mysql_fetch_row($resp2))
		 				{
					 		$cajascom=$row2[13];	
							$icbf=$row2[10];	
							$sena=$row2[11];	
							$iti=$row2[12];	
							$esap=$row2[14];
							$arp=$row2[15];						 					 					 					 
						}
		  				$sqlr="select *from humnomina_parafiscales where id_nom=$_POST[orden] ";  
		  		   		$resp2 = mysql_query($sqlr,$linkbd);	
				   		$chk="";	
					   	$dsb="";		
						while($row2=mysql_fetch_row($resp2))
						{
					  		$chk="";	
					   		$dsb="";
				   			$dsb2="<img src='imagenes/dinerob1.png' title='NO PAGO' style='width:18px;' />";
							$sqlrpf="SELECT tipo,porcentaje FROM humparafiscales WHERE codigo='$row2[1]'";
							$rowpf=mysql_fetch_row(mysql_query($sqlrpf,$linkbd));
							if($rowpf[0]='A'){$vatipa="Aporte";} 
							else {$vatipa="Descuento";}
							switch ($row2[1])
					 		{
								// PARTE 7A
						 		case '01':	if($row2[5]=='P')
					 						{
					 							$dsb=" disabled";					
					 							$dsb2="<img src='imagenes/dinero1.png' title='PAGO' style='width:18px' />";	
			 		 						}	
					  						$ch=esta_en_array($_POST[conciliados], $i);
											if($ch==1){$chk="checked";}		
						  					$ctapres=buscaparafiscal('01',$row2[4],''); 
						  					$valores=$row2[3]; 
		 				 					$ntercero=buscatercero($cajascom);
											echo "
											<input type='hidden' name='tdet[]' value='F'/>
											<input type='hidden' name='dcuentas[]' value='$cajascom'/>
											<input type='hidden' name='dncuentas[]' value='$ntercero'/>
											<input type='hidden' name='dccs[]' value='$row2[4]'/>
											<input type='hidden' name='drecursos[]' value='$ctapres'/>
											<input type='hidden' name='dvalores[]' value='".round($valores, 0, PHP_ROUND_HALF_UP)."'/>
											<input type='hidden' name='detalles[]' value='$row2[2]'/>
											<input type='hidden' name='iddescuento[]' value='$row2[1]'/>
											<tr class='$iter'  id='filas$i'>
		 										<td>$i F</td>
		 										<td>$cajascom</td>
		 										<td>$ntercero</td>
		 										<td>$row2[4]</td>
												<td>$vatipa $rowpf[1]%</td>
		 										<td>$ctapres</td>
		 										<td style='text-align:right;'>$ ".number_format(round($valores, 0, PHP_ROUND_HALF_UP),2,'.',',')."</td>
		 										<td><input type='checkbox' name='conciliados[]' value='$i' $chk onClick='marcar($k,$i);' $dsb class='defaultcheckbox'>&nbsp;&nbsp;$dsb2</td>
		 									</tr>";
											$_POST[totalc]=$_POST[totalc]+$valores;
		 									$_POST[totalcf]=number_format($_POST[totalc],2,".",",");
		 									$i+=1;
		  		 							$aux=$iter;
		 									$iter=$iter2;
		 									$iter2=$aux;
						  					break;
								// PARTE 7B
					 			case '02':	$dsb="";
				   							$dsb2="<img src='imagenes/dinerob1.png' title='NO PAGO' style='width:18px;' />";
											if($row2[5]=='P')
					 						{
					 							$dsb=" disabled";					
					 							$dsb2="<img src='imagenes/dinero1.png' title='PAGO' style='width:18px' />";	
			 		 						}	
					  						$ch=esta_en_array($_POST[conciliados], $i);
											if($ch==1) {$chk="checked";}				 
						  					$ctapres=buscaparafiscal('02',$row2[4],''); 
						  					$valores=$row2[3]; 
		 				  					$ntercero=buscatercero($icbf);
		 									echo "
											<input type='hidden' name='tdet[]' value='F'/>
											<input type='hidden' name='dcuentas[]' value='$icbf'/>
											<input type='hidden' name='dncuentas[]' value='$ntercero'/>
											<input type='hidden' name='dccs[]' value='$row2[4]'/>
											<input type='hidden' name='drecursos[]' value='$ctapres'>
											<input type='hidden' name='dvalores[]' value='".round($valores, 0, PHP_ROUND_HALF_UP)."'/>
											<input type='hidden' name='detalles[]' value='$row2[2]'>
											<input type='hidden' name='iddescuento[]' value='$row2[1]'>
											<tr class='$iter'  id='filas$i'>
		 										<td>$i F</td>
		 										<td>$icbf</td>
		 										<td>$ntercero</td>
		 										<td>$row2[4]</td>
												<td>$vatipa $rowpf[1]%</td>
		 										<td>$ctapres</td>
												<td style='text-align:right;'>$ ".number_format(round($valores, 0, PHP_ROUND_HALF_UP),2,'.',',')."</td>
		 										<td><input type='checkbox' name='conciliados[]' value='$i' $chk onClick='marcar($k,$i);' $dsb class='defaultcheckbox'>&nbsp;&nbsp;$dsb2</td>
											</tr>";
											$_POST[totalc]=$_POST[totalc]+$valores;
											$_POST[totalcf]=number_format($_POST[totalc],2,".",","); 
											$i+=1;
											$aux=$iter;
											$iter=$iter2;
											$iter2=$aux;
						  					break;
								// PARTE 7C
						 		case '03':	$dsb="";
				   							$dsb2="<img src='imagenes/dinerob1.png' title='NO PAGO' style='width:18px;' />";
											if($row2[5]=='P')
											{
												$dsb=" disabled";					
												$dsb2="<img src='imagenes/dinero1.png' title='PAGO' style='width:18px' />";	
											}
											$ch=esta_en_array($_POST[conciliados], $i);
											if($ch==1){$chk="checked"; }				
											$ctapres=buscaparafiscal('03',$row2[4],''); 
											$valores=$row2[3]; 
											$ntercero=buscatercero($sena);
											 echo "
											 <input type='hidden' name='tdet[]' value='F'/>
											 <input type='hidden' name='dcuentas[]' value='$sena'/>
											 <input type='hidden' name='dncuentas[]' value='$ntercero'/>
											 <input type='hidden' name='drecursos[]' value='$ctapres'/>
											 <input type='hidden' name='dccs[]' value='$row2[4]'/>
											 <input type='hidden' name='dvalores[]' value='".round($valores, 0, PHP_ROUND_HALF_UP)."'/>
											 <input type='hidden' name='detalles[]' value='$row2[2]'>
											 <input type='hidden' name='iddescuento[]' value='$row2[1]'>
											 <tr class='$iter' id='filas$i'>
												<td>$i F</td>
												<td>$sena</td>
												<td>$ntercero</td>
												<td>$row2[4]</td>
												<td>$vatipa $rowpf[1]%</td>
												<td>$ctapres</td>
												<td style='text-align:right;'>$ ".number_format(round($valores, 0, PHP_ROUND_HALF_UP),2,'.',',')."</td>
												<td><input type='checkbox' name='conciliados[]' value='$i' $chk onClick='marcar($k,$i);' $dsb class='defaultcheckbox'>&nbsp;&nbsp;$dsb2</td>
											</tr>";
											$_POST[totalc]=$_POST[totalc]+$valores;
											$_POST[totalcf]=number_format($_POST[totalc],2,".",",");
											$i+=1;
											$aux=$iter;
											$iter=$iter2;
											$iter2=$aux;
											break;
								// PARTE 7D
						 		case '04':	$dsb="";
				   							$dsb2="<img src='imagenes/dinerob1.png' title='NO PAGO' style='width:18px;' />";
											if($row2[5]=='P')
					 						{
					 							$dsb=" disabled";					
					 							$dsb2="<img src='imagenes/dinero1.png' title='PAGO' style='width:18px' />";	
			 		 						}	
					  						$ch=esta_en_array($_POST[conciliados], $i);
											if($ch==1){$chk="checked";}			
						 					$ctapres=buscaparafiscal('04',$row2[4],''); 
						  					$valores=$row2[3]; 
		 				  					$ntercero=buscatercero($iti);
		 									echo "
											<input type='hidden' name='tdet[]' value='F'/>
											<input type='hidden' name='dcuentas[]' value='$iti'/>
											<input type='hidden' name='dncuentas[]' value='$ntercero'/>
											<input type='hidden' name='dccs[]' value='$row2[4]'/>
											<input type='hidden' name='drecursos[]' value='$ctapres'/>
											<input type='hidden' name='dvalores[]' value='".round($valores, 0, PHP_ROUND_HALF_UP)."'/>
											<input type='hidden' name='detalles[]' value='$row2[2]'/>
											<input type='hidden' name='iddescuento[]' value='$row2[1]'/>
											<tr class='$iter'  id='filas$i'>
		 										<td>$i F</td>
		 										<td>$iti</td>
		 										<td>$ntercero</td>
		 										<td>$row2[4]</td>
												<td>$vatipa $rowpf[1]%</td>
		 										<td>$ctapres</td>
		 										<td style='text-align:right;'>$ ".number_format(round($valores, 0, PHP_ROUND_HALF_UP),2,'.',',')."</td>
		 										<td><input type='checkbox' name='conciliados[]' value='$i' $chk onClick='marcar($k,$i);' $dsb class='defaultcheckbox'>&nbsp;&nbsp;$dsb2</td>
											</tr>";
		 									$_POST[totalc]=$_POST[totalc]+$valores;
		 									$_POST[totalcf]=number_format($_POST[totalc],2,".",",");
		 									$i+=1;
			 		 						$aux=$iter;
											$iter=$iter2;
		 									$iter2=$aux;			 
						  					break; 
								// PARTE 7E   
						 		case '05':	$dsb="";
				   							$dsb2="<img src='imagenes/dinerob1.png' title='NO PAGO' style='width:18px;' />";
											if($row2[5]=='P')
					 						{
					 							$dsb=" disabled";					
					 							$dsb2="<img src='imagenes/dinero1.png' title='PAGO' style='width:18px' />";	
			 		 						}	
					  						$ch=esta_en_array($_POST[conciliados], $i);
											if($ch==1){$chk="checked";}			
						 					$ctapres=buscaparafiscal('05',$row2[4],''); 
						  					$valores=$row2[3]; 
		 				  					$ntercero=buscatercero($esap);
		 									echo "
											<input type='hidden' name='tdet[]' value='F'/>
											<input type='hidden' name='dcuentas[]' value='$esap'/>
											<input type='hidden' name='dncuentas[]' value='$ntercero'/>
											<input type='hidden' name='dccs[]' value='$row2[4]'/>
											<input type='hidden' name='drecursos[]' value='$ctapres'/>
											<input type='hidden' name='dvalores[]' value='".round($valores, 0, PHP_ROUND_HALF_UP)."'/>
											<input type='hidden' name='detalles[]' value='$row2[2]'>
											<input type='hidden' name='iddescuento[]' value='$row2[1]'>
											<tr class='$iter'  id='filas$i'>
		 										<td>$i F</td>
		 										<td>$esap</td>
		 										<td>$ntercero</td>
		 										<td>$row2[4]</td>
												<td>$vatipa $rowpf[1]%</td>
		 										<td>$ctapres</td>
		 										<td style='text-align:right;'>$ ".number_format(round($valores, 0, PHP_ROUND_HALF_UP),2,'.',',')."</td>
		 										<td><input type='checkbox' name='conciliados[]' value='$i' $chk onClick='marcar($k,$i);' $dsb class='defaultcheckbox'>&nbsp;&nbsp;$dsb2</td>
											</tr>";
		 									$_POST[totalc]=$_POST[totalc]+$valores;
		 									$_POST[totalcf]=number_format($_POST[totalc],2,".",",");
		 									$i+=1;
		  		 							$aux=$iter;
		 									$iter=$iter2;
		 									$iter2=$aux;
						  					break; 
								// PARTE 7F
						 		case '06':	$dsb="";
				   							$dsb2="<img src='imagenes/dinerob1.png' title='NO PAGO' style='width:18px;' />";
											if($row2[5]=='P')
					 						{
					 							$dsb=" disabled";					
					 							$dsb2="<img src='imagenes/dinero1.png' title='PAGO' style='width:18px' />";	
			 		 						}			
					   						$ch=esta_en_array($_POST[conciliados], $i);
											if($ch==1){$chk="checked";}	
					 						$ctapres=buscaparafiscal('06',$row2[4],'');  
					 						$ntercero=buscatercero($arp);
					 						$valores=$row2[3]; 
		 									echo "
											<input type='hidden' name='tdet[]' value='F'/>
											<input type='hidden' name='dcuentas[]' value='$arp'/>
											<input type='hidden' name='dncuentas[]' value='$ntercero'/>
											<input type='hidden' name='dccs[]' value='$row2[4]'/>
											<input type='hidden' name='drecursos[]' value='$ctapres'/>
											<input type='hidden' name='dvalores[]' value='".round($valores, 0, PHP_ROUND_HALF_UP)."'/>
											<input type='hidden' name='detalles[]' value='$row2[2]'>
											<input type='hidden' name='iddescuento[]' value='$row2[1]'>
											<tr class='$iter' id='filas$i'>
		 										<td>$i F</td>
		 										<td>$arp</td>
		 										<td>$ntercero</td>
		 										<td>$row2[4]</td>
												<td>$vatipa $rowpf[1]%</td>
		 										<td>$ctapres</td>
		 										<td style='text-align:right;'>$ ".number_format(round($valores, 0, PHP_ROUND_HALF_UP),2,'.',',')."</td>
		 										<td><input type='checkbox' name='conciliados[]' value='$i' $chk onClick='marcar($k,$i);' $dsb class='defaultcheckbox'>&nbsp;&nbsp;$dsb2</td>
											</tr>";
		 									$_POST[totalc]=$_POST[totalc]+$valores;
		 									$_POST[totalcf]=number_format($_POST[totalc],2,".",",");
		 									$i+=1;			
		  		 							$aux=$iter;
		 									$iter=$iter2;
		 									$iter2=$aux;			 
						  					break; 
							}					 
						}		
						$resultado = convertir($_POST[totalc]);
						$_POST[letras]=$resultado." PESOS M/CTE";
	    				echo "
						<tr class='saludo3'>
							<td colspan='4'></td>
							<td style='text-align:right;'>Total:</td>
							<td><input name='totalcf' type='text' value='$_POST[totalcf]' readonly style='text-align:right;'><input name='totalc' type='hidden' value='$_POST[totalc]'></td>
						</tr>
						<tr>
							<td  class='saludo1'>Son:</td>
							<td colspan='5' class='saludo1'><input name='letras' type='text' value='$_POST[letras]' style='width:100%' class='inpnovisibles'></td>
						</tr>";
					?>
       				<script>
        				document.form2.valor.value=<?php echo $_POST[totalc];?>;
        			</script>
	   			</table>
					</div>
                	</div>	
      			</div>
				 
     			<div class="tab">
       				<input type="radio" id="tab-3" name="tabgroup1" value="3" <?php echo $check3;?>>
       				<label for="tab-3">Egreso</label>
       				<div class="content" style="overflow-x:hidden;"> 
	   					<table class="inicio" align="center" >
	   						<tr>
     							<td colspan="6" class="titulos">Comprobante de Egreso</td>
                                <td class="cerrar" style="width:7%;"><a onClick="location.href='teso-principal.php'">&nbsp;Cerrar</a></td>
                         	</tr>
       						<tr>
                            	<td style="width:10%;" class="saludo1">No Egreso:</td>
                                <td style="width:15%;">
									<input name="cuentapagar" type="hidden"  value="<?php echo $_POST[cuentapagar]?>" >
									<input name="egreso" type="text" style="width:35%;" value="<?php echo $_POST[egreso]?>" onKeyUp="return tabular(event,this)" onKeyDown="mascara(this,'/',patron,true)" onBlur="buscarp(event)" readonly ></td>
       	  						<td class="saludo1" style="width:5%;">Fecha: </td>
        						<td style="width:15%;">
									<input id="fc_1198971546" style="width:45%;" name="fecha" type="text" value="<?php echo $_POST[fecha]?>" title="DD/MM/YYYY" maxlength="10" onKeyDown="mascara(this,'/',patron,true)" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)">&nbsp;<a href="#" onClick="displayCalendarFor('fc_1198971546');"> <img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>
								</td>    
       							<td style="width:8%;" class="saludo1">Forma de Pago:</td>
       							<td style="width:40%;">
       								<select name="tipop" onChange="validar();" onKeyUp="return tabular(event,this)">
       									<option value="">Seleccione ...</option>
				  						<option value="cheque" <?php if($_POST[tipop]=='cheque') echo "SELECTED"?>>Cheque</option>
  				  						<option value="transferencia" <?php if($_POST[tipop]=='transferencia') echo "SELECTED"?>>Transferencia</option>
				  					</select>
          						</td>        
       						</tr>
							<tr>      
								<td style="width:10%;" class="saludo1">Tercero:</td>
								<td >
									<input type="text" name="tercero" id="tercero" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo $_POST[tercero]?>" style="width:80%;">&nbsp;
									<a onClick="despliegamodal2('visible','3');"><img src="imagenes/find02.png" style="width:20px;cursor:pointer;"></a>
								</td>
			          			<td colspan="4">
			                    	<input type="text" name="ntercero" id="ntercero" value="<?php echo $_POST[ntercero]?>" style="width:59%" readonly>
			                        <input type="hidden" value="0" name="bt">
			                   	</td>
                       		</tr>
                            <tr>
                            	<td style="width:10%;" class="saludo1">Concepto:</td>
                                <td colspan="3">
									<input style="width:100%;" name="concepto" type="text" value="<?php echo $_POST[concepto]?>" ></td>
                                <td class="saludo1">Valor a Pagar:</td>
                                <td><input name="valorpagar" type="text" id="valorpagar" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[valorpagar]?>"  readonly> </td>
                          	</tr>           
      						<?php 
	 			 			
	  							if($_POST[tipop]=='cheque')//**** if del cheques
	    						{
									echo "<tr>
					  				<td style='width:10%;' class='saludo1'>Cuenta :</td>
				                    <td>
				                    	<input type='text' name='cb' id='cb' value='$_POST[cb]' style='width:80%;'/>&nbsp;
				                    	<a onClick=\"despliegamodal2('visible','2');\"  style='cursor:pointer;' title='Listado Cuentas Bancarias'>	
				                    		<img src='imagenes/find02.png' style='width:20px;'/>
				                    	</a>
				                    </td>
				                    <td colspan='2'>
				        					<input type='text' id='nbanco' name='nbanco' style='width:100%;' value='$_POST[nbanco]'  readonly>
				      				</td>
									<td class='saludo1'>Cheque:</td>
									<td>
										<input type='text' id='ncheque' name='ncheque' value='$_POST[ncheque]' style='width:30%;'>
									</td>
										<input type='hidden' name='banco' id='banco' value='$_POST[banco]'/>
										<input type='hidden' id='ter' name='ter' value='$_POST[ter]'/>
									</tr>";
									if($_POST[cb]!="")
			 						{
										$sqlc="select cheque from tesocheques where cuentabancaria='$_POST[cb]' and estado='S' order by cheque asc";
										$resc = mysql_query($sqlc,$linkbd);
										$rowc =mysql_fetch_row($resc);
										if($rowc[0]!=''){echo "<script>document.form2.ncheque.value='$rowc[0]';</script>";}
			  						}
	     						}//cierre del if de cheques
	  							if($_POST[tipop]=='transferencia')//**** if del transferencias
	    						{
									echo "<tr>
					  				<td style='width:10%;' class='saludo1'>Cuenta :</td>
				                    <td>
				                    	<input type='text' name='cb' id='cb' value='$_POST[cb]' style='width:80%;'/>&nbsp;
				                    	<a onClick=\"despliegamodal2('visible','1');\"  style='cursor:pointer;' title='Listado Cuentas Bancarias'>	
				                    		<img src='imagenes/find02.png' style='width:20px;'/>
				                    	</a>
				                    </td>
				                    <td colspan='2'>
				        					<input type='text' id='nbanco' name='nbanco' style='width:100%;' value='$_POST[nbanco]'  readonly>
				      				<td class='saludo1'>No Transferencia:</td>
									<td >
										<input type='text' id='ntransfe' name='ntransfe' value='$_POST[ntransfe]' style='width:30%;'>
									</td>
										<input type='hidden' name='banco' id='banco' value='$_POST[banco]'/>
										<input type='hidden' id='ter' name='ter' value='$_POST[ter]'/>
									</tr>";
	     						}//cierre del if de transferencia
			 					if($_POST[bt]=='1')//***** busca tercero
			 					{
			  						$nresul=buscatercero($_POST[tercero]);
			  						if($nresul!='')
			   						{
			  							$_POST[ntercero]=$nresul;
  										echo"
			  								<script>
			 								// document.getElementById('cc').focus();document.getElementById('cc').select();
											</script>";
			  						}
			 						else
			 						{
			  							$_POST[ntercero]="";
			  							echo"
			  								<script>
												alert('Tercero Incorrecto o no Existe');								
  		  										document.form2.tercero.value='';	
  		  										document.form2.tercero.focus();	
			  									//document.form2.tercero.focus();			  	
			  								</script>";
			  						}
			 					}
      						?> 	
      					</table>
      					<table class="inicio">
      						<tr>
                            	<td class="titulos2">No /Id Descuento</td>
                                <td class="titulos2">Nit</td>
                                <td class="titulos2">Tercero</td>
                                <td class="titulos2">CC</td>
                                <td class="titulos2">Cta Presupuestal</td>
                                <td class="titulos2">Valor<input type='hidden' name='eliminad' id='eliminad'></td>
                           	</tr>
      						<?php	 
								$totalpagos=0;
								$iter="zebra1";  
								$iter2="zebra2";
								$cutotal=0;
								foreach($_POST[conciliados] as $jp)
		 						{		 		 
		 							$nid=$jp;
		 							$jp-=1;
		 							$ntercero=buscatercero($_POST[dcuentas][$jp]);
		 							$terx=$_POST[dcuentas][$jp];				 
         							if($_POST[tdet][$jp]=='N' || $_POST[tdet][$jp]=='')
		 							{
										echo"
		 									<script>	
		 										document.form2.tercero.value='$terx'; 
		  										document.form2.ntercero.value='$ntercero';     
											</script>";
		 							}
		 							else
		 							{
		 								echo"
			 							<script>	
		  									//document.form2.tercero.value=''; 
		  									//document.form2.ntercero.value='';     
										</script>";
		 							}
									if ($_POST[tdet][$jp]=="N")
									{
										echo "
											<input type='hidden' name='salariodevengado' value='".$_POST[saldevengado][$jp]."'/>
											<input type='hidden' name='valorarl' value='".$_POST[valarl][$jp]."'/>
											<input type='hidden' name='valorsalud' value='".$_POST[valsalud][$jp]."'/>
											<input type='hidden' name='valorpension' value='".$_POST[valpension][$jp]."'/>
											<input type='hidden' name='valorfondosol' value='".$_POST[valfondosol][$jp]."'/>
											<input type='hidden' name='valordeducciones' value='".$_POST[valdeducciones][$jp]."'/>
										";
									}
		 							echo "
									<input type='hidden' name='tedet[]' value='".$_POST[tdet][$jp]."'/>
									<input type='hidden' name='idedescuento[]' value='".$_POST[iddescuento][$jp]."'/>
									<input type='hidden' name='decuentas[]' value='".$_POST[dcuentas][$jp]."'/>
									<input type='hidden' name='ddescuentos[]' value='".$_POST[ddescuentos][$jp]."'/>
									<input type='hidden' name='dencuentas[]' value='".$_POST[dncuentas][$jp]."'/>
									<input type='hidden' name='deccs[]' value='".$_POST[dccs][$jp]."'/>
									<input type='hidden' name='derecursos[]' value='".$_POST[drecursos][$jp]."'/>
									<input type='hidden' name='devalores[]' value='".($_POST[dvalores][$jp])."'>
									<tr class='$iter'>		
										<td>$nid-".$_POST[tdet][$jp]." ".$_POST[iddescuento][$jp]."</td>
										<td>".$_POST[dcuentas][$jp]."</td>
										<td>".$_POST[dncuentas][$jp]."</td>
										<td>".$_POST[dccs][$jp]."</td>
										<td>".$_POST[drecursos][$jp]."</td>
										<td style='text-align:right;'>$ ".number_format($_POST[dvalores][$jp],2,'.',',')."</td>
									</tr>";
		 							$totalpagos=$totalpagos+($_POST[dvalores][$jp]);
		 							$aux=$iter2;
		 							$iter2=$iter;
		 							$iter=$aux;
		 						}		 
								$_POST[valoregreso]=$totalpagos;		
								echo"
        							<script>			
										//calcularpago();
       									document.form2.valorpagar.value='".array_sum($_POST[devalores])."';    
	   									document.form2.valoregreso.value='".array_sum($_POST[devalores])."';    
        							</script>";
								$_POST[letrasegreso]= convertir($totalpagos);
								echo "
								<tr class='$iter' style='text-align:right;font-weight:bold;'>
									<td colspan='5'>Total:</td>
									<td>$ ".number_format($totalpagos,2,'.',',')."</td>
								</tr>
								<input type='hidden' name='letrasegreso' value='$_POST[letrasegreso]'>
								<tr class='titulos2'>
									<td>Son:</td>
									<td colspan='5'>$_POST[letrasegreso]</td>
								</tr>";
							?>
      					</table>
	   				</div>
   				</div> 
				
       		</div>
			<div id="bgventanamodal2">
                <div id="ventanamodal2">
                    <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                    </IFRAME>
                </div>
       	 	</div>	
		</form>
	</body>
</html>