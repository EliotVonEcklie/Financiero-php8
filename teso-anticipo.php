<?php //V 1001 20/12/16?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	require "conversor.php";
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
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
		<link href="css/css3.css" rel="stylesheet" type="text/css" />
		<link href="css/tabs.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
		<script>
			function buscacta(e)
 			{
				if (document.form2.cuenta.value!="")
				{
				 	document.form2.bc.value='1';
 					document.form2.submit();
				}
 			}
			function validar(){document.form2.submit();}
			function validar2(){
				document.form2.cxpo.value=1;
				document.form2.tipomovimiento.value='401';
				document.form2.submit();
				
			}
			function buscarp(e)
 			{
				
				if (document.form2.rp.value!="")
				{
						
					document.form2.brp.value='1';
					document.form2.submit();
 				}
 			}
			function agregardetalle()
			{
				if(document.form2.numero.value!="" &&  document.form2.valor.value>0 &&  document.form2.banco.value!=""  )
				{ 
					document.form2.agregadet.value=1;
					document.form2.submit();
				}
 				else {alert("Falta informacion para poder Agregar"); }
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

				if(document.form2.tipomovimiento.value=='201'){
					if( document.form2.fecha.value!='' && document.form2.destino.value!='' && document.form2.cc.value!='')
					{
						despliegamodalm('visible','4','Esta Seguro de Guardar','1');					
					}
					else {despliegamodalm('visible','2','Falta informacion para Crear la Cuenta');}
				}else{
					if( document.form2.cxp.value!='')
					{
						despliegamodalm('visible','4','Esta Seguro de Guardar','1');					
					}
					else 
					{
						despliegamodalm('visible','2','Falta informacion para Crear la Cuenta');
					}
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
			function funcionmensaje()
			{
				if(document.form2.tipomovimiento.value=='201'){
					var _cons=document.getElementById('idcomp').value;
					document.location.href = "teso-egresover.php?idop="+_cons+"&scrtop=0&numpag=1&limreg=10&filtro=#";
				}else{
					var _cons=document.getElementById('cxp').value;
					document.location.href = "teso-egresover.php?idop="+_cons+"&scrtop=0&numpag=1&limreg=10&filtro=#";
				}
			}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	
							document.form2.oculto.value='2';
								document.form2.submit();break;
				}
			}
			
			function calcularpago()
 			{
				pvig=parseFloat(document.form2.sumarbase.value);
				pvig2=parseFloat(document.form2.pvigant.value);
				valorp=document.form2.valor.value;
				document.form2.base.value=parseFloat(valorp)+parseFloat(pvig)+parseFloat(pvig2)-parseFloat(document.form2.iva.value);
				descuentos=document.form2.totaldes.value;
				valorc=valorp-descuentos;
				document.form2.valorcheque.value=valorc;
				document.form2.valoregreso.value=valorp;
				document.form2.valorretencion.value=descuentos;	
	  			document.form2.submit();
 			}
			function pdf()
			{
				document.form2.action="pdfcxp.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function sumapagosant() 
			{ 
 				cali=document.getElementsByName('pagos[]');
				valrubro=document.getElementsByName('pvalores[]');
 				sumar=0;
				for (var i=0;i < cali.length;i++) 
				{ 
					if (cali.item(i).checked == true)
					{
						sumar=parseInt(sumar)+parseInt(valrubro.item(i).value);
					}
				} 
				pvig=parseInt(document.form2.pvigant.value);
				document.form2.sumarbase.value=sumar+pvig;	
				document.getElementById("sumarbase2").value=sumar+pvig;	
	 			resumar();
			} 
			function resumar() 
			{ 
				cali=document.getElementsByName('rubros[]');
			 	valrubro=document.getElementsByName('dvalores[]');
			 	sumar=0;
				for (var i=0;i < cali.length;i++) 
				{ 
					if (cali.item(i).checked == true){sumar=parseInt(sumar)+parseInt(valrubro.item(i).value);}
				} 
				if(document.form2.regimen.value==1){
					$d=0;
					iva1=sumar-(sumar/1.16);
					document.form2.iva.value=parseInt(iva1);
					iva2=document.form2.sumarbase.value-(document.form2.sumarbase.value/1.16);
					//alert(iva2);
					document.form2.iva.value=parseInt(document.form2.iva.value)+parseInt(iva2);
				}
			 	else {
			 		document.form2.iva.value=0;
			 	}	
				//alert(sumar);
				
				//alert(document.form2.iva.value);
				document.form2.base.value=sumar-document.form2.iva.value+parseInt(document.form2.sumarbase.value);	
				document.form2.totalc.value=sumar;
				document.form2.valor.value=sumar;
				document.form2.valoregreso.value=sumar;
				document.form2.valorcheque.value=document.form2.valor.value-document.form2.valorretencion.value;	
				document.form2.submit();	
			} 
			function checktodos()
			{
 				cali=document.getElementsByName('rubros[]');
 				valrubro=document.getElementsByName('dvalores[]');
				for (var i=0;i < cali.length;i++) 
 				{ 
					if (document.getElementById("todos").checked == true) 
					{
	 					cali.item(i).checked = true;
 	 					document.getElementById("todos").value=1;	 
					}
					else
					{
						cali.item(i).checked = false;
    					document.getElementById("todos").value=0;
					}
 				}	
 				resumar() ;
			}
			function buscater(e)
 			{
				if (document.form2.tercero.value!="")
				{
					document.form2.bt.value='1';
 					document.form2.submit();
 				}
 			}
			function despliegamodal2(_valor,_nomve,_vaux)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){
					document.getElementById('ventana2').src="";
					}
				else 
				{
					switch(_nomve)
					{
						case "1":	document.getElementById('ventana2').src="registro-ventana01.php?vigencia="+_vaux;break;
						case "2":	document.getElementById('ventana2').src="tercerosgral-ventana01.php?objeto=tercero&nobjeto=ntercero&tnfoco=detallegreso";break;
						case "3":	document.getElementById('ventana2').src="reversar-cxp.php?vigencia="+_vaux;break;
						case '4':	document.getElementById('ventana2').src="cuentasbancarias-ventana01.php?tipoc=C";break;
						case '5':	document.getElementById('ventana2').src="cuentasbancarias-ventana01.php?tipoc=D";break;
					}
				}
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
			<tr class="cinta">
  				<td colspan="3" class="cinta">
					<a href="teso-egreso.php" accesskey="n" class="mgbt"><img src="imagenes/add.png" title="Nuevo" border="0" /></a>
					<a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a>
					<a href="teso-buscaegreso.php" accesskey="b" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a>
					<a href="#" class="mgbt" onClick="<?php echo paginasnuevas("teso");?>"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
					<a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png"  style="width:29px;height:25px;" title="Imprimir" /></a>
					<a href="teso-gestionpago.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
				</td>
			</tr>
		</table>
		<?php
			$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
			$_POST[vigencia]=$vigusu;
	  		//*********** cuenta origen va al credito y la destino al debito
			if(!$_POST[oculto])
			{
				
				$_POST[pvigant]=0;
				$check1="checked";
 		 		$fec=date("d/m/Y");
		 		$_POST[fecha]=$fec; 		 		  			 
		 		$_POST[vigencia]=$vigusu; 		
		 		$sqlr="select max(numerotipo) from comprobante_cab where tipo_comp='11' ";
				$res=mysql_query($sqlr,$linkbd);
				$consec=0;
				while($r=mysql_fetch_row($res)){$consec=$r[0];}
	 			$consec+=1;
	 			$_POST[idcomp]=$consec;	
				$sqlr="select max(id_orden) from tesoordenpago";
				$res=mysql_query($sqlr,$linkbd);
				$consec=0;
				while($r=mysql_fetch_row($res)){$consec=$r[0];}
	 			$consec+=1;
	 			$_POST[idcomp]=$consec;
				if($_POST[cxpo]!=1)$_POST[tipomovimiento]='201';
			}
			switch($_POST[tabgroup1])
			{
				case 1:	$check1='checked';break;
				case 2: $check2='checked';break;
				case 3: $check3='checked';break;
				case 4: $check4='checked';break;
			}
			if($_POST[anticipo]=='S'){
				$chkant=' checked ';
				//$_POST[reado]='readonly';
				}
			
		?>
		<div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
 		<form name="form2" method="post" action=""> 
			
 			<?php
 				if($_POST[brp]=='1')
			 	{
			  		$nresul=buscaregistro($_POST[rp],$_POST[vigencia]);
					$sqlr="select idcdp from pptorp where consvigencia=$_POST[rp] and vigencia=$_POST[vigencia]"; 
					
					//echo $sqlr;
					$resp = mysql_query($sqlr,$linkbd);
					$row =mysql_fetch_row($resp);
			  		if($nresul!='')
			   		{
			  			$_POST[cdp]=$row[0];
			  			//*** busca detalle cdp
  						$sqlr="select pptorp.vigencia,pptorp.consvigencia,pptocdp.objeto,pptorp.estado,pptocdp.consvigencia, pptorp.valor,pptorp.saldo,pptorp.tercero, pptocdp.objeto from pptorp,pptocdp where pptorp.estado='S' and pptocdp.consvigencia=$_POST[cdp] and pptorp.idcdp=pptocdp.consvigencia and pptorp.consvigencia=".$_POST[rp]." and pptorp.vigencia=$_POST[vigencia] and pptorp.idcdp=pptocdp.consvigencia and pptocdp.vigencia=$vigusu  order  by pptorp.vigencia,pptorp.consvigencia,pptocdp.objeto,pptorp.estado";
						//echo $sqlr;
						$resp = mysql_query($sqlr,$linkbd);
						$row =mysql_fetch_row($resp);
						$_POST[detallecdp]=$row[2];
						$_POST[tercero]=$row[7];
						$_POST[ntercero]=buscatercero($_POST[tercero]);
						$_POST[regimen]=buscaregimen($_POST[tercero]);			
						$_POST[valorrp]=$row[5];
						$_POST[saldorp]=$row[6];
						$_POST[valor]=$row[6];
						if($_POST[regimen]==1){$_POST[iva]=round($_POST[valor]-$_POST[valor]/(1.16),1);}
				 		else {$_POST[iva]=0;}			
				 		$_POST[base]=$_POST[valor]-$_POST[iva];				 
						$_POST[detallegreso]=$row[8];
						$_POST[valoregreso]=$_POST[valor];
						$_POST[valorretencion]=$_POST[totaldes];
						$_POST[valorcheque]=$_POST[valoregreso]-$_POST[valorretencion];
						$_POST[valorcheque]=number_format($_POST[valorcheque],2);				
			  		}
			 		else
					{
						$_POST[cdp]="";
					  	$_POST[detallecdp]="";
					  	$_POST[tercero]="";
					  	$_POST[ntercero]="";
					}
				}
			 	if($_POST[bt]=='1')//***** busca tercero
			 	{
			  		$nresul=buscatercero($_POST[tercero]);
			  		$_POST[regimen]=buscaregimen($_POST[tercero]);	
			 		if($nresul!='')
			   		{
			  			$_POST[ntercero]=$nresul;
  						if($_POST[regimen]==1){$_POST[iva]=round($_POST[valor]-$_POST[valor]/(1.16),1);	}
				 		else{$_POST[iva]=0;}	
				 		$_POST[base]=$_POST[valor]-$_POST[iva];				 
			  		}
					else{ $_POST[ntercero]="";}
			 	}
				if(isset($_POST[anticipo]) && $_POST[anticipo]=="S")
				{
					//$_POST[reado]='readonly';
					$_POST[iva]=0;
				}
 			?>
 		
		<div class="tabs" style="height:68%; width:99.7%">
   				<div class="tab" >
       				<input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
	   				<label for="tab-1">Liquidacion Anticipo</label>
	   				<div class="content" style="overflow-x:hidden;">
    					<table class="inicio" align="center" >
      						<tr>
        						<td class="titulos" colspan="7">Liquidacion Anticipo</td>
                                <td class="cerrar" style="width:7%;"><a href="teso-principal.php">&nbsp;Cerrar</a></td>
      						</tr>
      						<tr>
		        				<td class="saludo1" style="width:2.6cm;">Numero Anticipo:</td>
        						<td style="width:20%;">
                                	<input type="text" name="idcomp" id="idcomp" value="<?php echo $_POST[idcomp]?>" style="width:40%;" readonly/> 
                                    <span class="saludo3">Anticipo: <input class="defaultcheckbox" type="checkbox" name="anticipo" value="S" onChange="validar()" disabled checked/></span>
                              	</td>
	  							<td class="saludo1" style="width:3.1cm;">Fecha:</td>
       							<td style="width:12%;"><input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" style="width:80%;" title="DD/MM/YYYY"/>&nbsp;<a href="#" onClick="displayCalendarFor('fc_1198971545');" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px;"/></a></td>
	  							<td class="saludo1" style="width:3cm;">Vigencia: </td>
        						<td style="width:14%;"><input type="text" name="vigencia"  value="<?php echo $_POST[vigencia]?>" onKeyUp="return tabular(event,this)" readonly/></td>
                                <td rowspan="7" colspan="2" style="background:url(imagenes/factura03.png); background-repeat:no-repeat; background-position:right; background-size: 90% 95%"></td>
 							</tr>
        					<tr>
        						<input type="hidden" name="causacion" id="causacion" value="1" >
                               
                        	
        						<td  class="saludo1">Registro:</td>
        						<td>
                                	<input type="text" name="rp" id="rp" value="<?php echo $_POST[rp]?>" onKeyUp="return tabular(event,this)" onBlur="buscarp(event)" style="width:80%;" />
									
									<input type="hidden" value="0" name="brp">
                                    <a href="#" onClick="despliegamodal2('visible','1','<?php echo $_POST[vigencia]?>');" title="Buscar Registro"><img src="imagenes/find02.png" style="width:20px;"></a>       
                             	</td>
								<td class="saludo1">Cuenta Contable</td>
								<td>
									<select name="cuenta" id="cuenta" onChange="validar()" value="<?php echo $_POST[cuenta]?>">
									<option value="1"> Seleccione </option>
									<?php 
										$sqlr="select c.cuenta,c1.nombre from conceptoscontables_det c ,conceptoscontables c1 where c1.modulo=c.modulo and c.modulo=4 and c.tipo=c1.tipo and c1.tipo='AN'";
										
										$res=mysql_query($sqlr,$linkbd);
										while($row=mysql_fetch_row($res)){
											if($row[0]==$_POST[cuenta]){
												echo "<option value='$row[0]' SELECTED> $row[0]-$row[1]</option>";
											}else{
												echo "<option value='$row[0]'> $row[0]-$row[1]</option>";
											}
											$_POST[cuentapagar]=$_POST[cuenta];
										}
									?>
									</select>
								</td>
								<td class="saludo1" style="width:2.8cm;">Forma de Pago:</td>
       							<td style="width:14%">
									 
       								<select name="tipop" id="tipop" onChange="validar();" onKeyUp="return tabular(event,this)" style="width:100%">
       									<option value="">Seleccione ...</option>
				  						<option value="cheque" <?php if($_POST[tipop]=='cheque') echo "SELECTED"?>>Cheque</option>
  				  						<option value="transferencia" <?php if($_POST[tipop]=='transferencia') echo "SELECTED"?>>Transferencia</option>
				  					</select> 
                                 </td>
                           	</tr>
							
							<?php 
							// echo "Escuentas".$_POST[escuentas];
	 	 						if($_POST[tipop]=='cheque') //**** if del cheques
	   			 				{
									
	  								echo" 
           							<tr>
	  									<td class='saludo1'>Cuenta Bancaria:</td>
	  									<td>
											<input type='text' name='cb' id='cb' value='$_POST[cb]' style='width:80%'/>
	     								&nbsp;<a onClick=\"despliegamodal2('visible','4');\"  style='cursor:pointer;' title='Listado Cuentas Bancarias'><img src='imagenes/find02.png' style='width:20px;'/></a>
                                  		</td>
                                    	<td colspan='2'><input type='text' id='nbanco' name='nbanco' value='$_POST[nbanco]' style='width:100%' readonly></td>
										<td class='saludo1'>Cheque:</td>
                                        <td>
											<input type='text' id='ncheque' name='ncheque' value='$_POST[ncheque]' style='width:100%'/>
											<input type='hidden' id='nchequeh' name='nchequeh' value='$_POST[nchequeh]'/>
										</td>
	  								</tr>
                                    <input type='hidden' name='banco' id='banco' value='$_POST[banco]'/>
                                    <input type='hidden' name='tcta' id='tcta' value='$_POST[tcta]'/>
                                   	<input type='hidden' name='ter' id='ter' value='$_POST[ter]'/>";
								//-----------Asignacion del consecutivo de cheque----------------------------
								if($_POST[cb]!=''){
									$sqlc="select cheque from tesocheques where cuentabancaria='$_POST[cb]' and estado='S' order by cheque asc";
									//echo $sqlc;
									$resc = mysql_query($sqlc,$linkbd);
									$rowc =mysql_fetch_row($resc);
									//echo "cheque: ".$rowc[0];
									if($rowc[0]==''){
										
									}else{
										echo "<script>document.form2.ncheque.value='".$rowc[0]."';</script>";
									}
								}	
									
									
	    						}//cierre del if de cheques
	  							if($_POST[tipop]=='transferencia')//**** if del transferencias
	    						{
									
	  								echo"
      								<tr>
	  									<td class='saludo1'>Cuenta Bancaria:</td>
	  									<td>
                                            <input type='text' name='cb' id='cb' value='$_POST[cb]' style='width:80%'/>
	     								&nbsp;<a onClick=\"despliegamodal2('visible','5');\"  style='cursor:pointer;' title='Listado Cuentas Bancarias'><img src='imagenes/find02.png' style='width:20px;'/></a>
                                      	</td>
                                       	<td colspan='2'><input type='text' id='nbanco' name='nbanco' value='$_POST[nbanco]' style='width:100%' readonly></td>
										<td class='saludo1'>No Transferencia:</td>
                                        <td><input type='text' id='ntransfe' name='ntransfe' value='$_POST[ntransfe]' style='width:100%'></td>
	  								</tr>
									<input type='hidden' name='banco' id='banco' value='$_POST[banco]'/>
                                   	<input type='hidden' name='tcta' id='tcta' value='$_POST[tcta]'/>
                                   	<input type='hidden' name='ter' id='ter' value='$_POST[ter]'/>";
	     						}//cierre del if de cheques
      						?>
        					<tr>
	  							<td class="saludo1">CDP:</td>
	  							<td><input type="text" id="cdp" name="cdp" value="<?php echo $_POST[cdp]?>" style="width:80%;" readonly></td>
	  							<td class="saludo1">Detalle RP:</td>
	  							<td colspan="3"><input type="text" id="detallecdp" name="detallecdp" value="<?php echo $_POST[detallecdp]?>" style="width:100%;" readonly></td>
	  						</tr> 
	  						<tr>
	  							<td class="saludo1">Centro Costo:</td>
	  							<td>
									<select name="cc"  onChange="validar()" onKeyUp="return tabular(event,this)" style="width:100%;">
										<option value="">Seleccione ...</option>
										<?php
                                            $sqlr="select *from centrocosto where estado='S' order by id_cc	";
                                            $res=mysql_query($sqlr,$linkbd);
                                            while ($row =mysql_fetch_row($res)) 
                                            {
                                                if("$row[0]"==$_POST[cc]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
                                                else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
                                            }	 	
                                        ?>
  									</select>
	 							</td>
	    						<td class="saludo1">Tercero:</td>
          						<td>
									<input type="text" id="tercero" name="tercero" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo $_POST[tercero]?>" style="width:80%;">
									<input type="hidden" value="0" name="bt">&nbsp;<a href="#" onClick="despliegamodal2('visible','2')"><img src="imagenes/find02.png" style="width:20px;"></a></td>
          						<td colspan="2">
									<input type="text" id="ntercero"  name="ntercero" value="<?php echo $_POST[ntercero]?>" style="width:100%;" readonly>
								</td>
                      		</tr>
          					<tr>
                            	<td class="saludo1">Detalle CxP:</td>
                                <td colspan="5"><input type="text" id="detallegreso" name="detallegreso" value="<?php echo $_POST[detallegreso]?>" style="width:100%;"></td>
                          	</tr>
	  						<tr>
                            	<td class="saludo1">Valor RP:</td>
                                <td><input type="text" id="valorrp" name="valorrp" value="<?php echo $_POST[valorrp]?>"  onKeyUp="return tabular(event,this)" style="width:80%;" readonly></td>
                                <td class="saludo1">Saldo:</td>
                                <td><input type="text" id="saldorp" name="saldorp"  value="<?php echo $_POST[saldorp]?>"  onKeyUp="return tabular(event,this)" readonly></td>
                                <td class="saludo1" >Pagos Vig Anterior:</td>
                                <td><input type="text" id="pvigant" name="pvigant" value="<?php echo $_POST[pvigant]?>" onKeyUp="return tabular(event,this)" onBlur='sumapagosant()' style="width:100%;"></td>
                         	</tr>
      						<tr>
	  							<td class="saludo1" >Valor a Pagar:</td>
                                <td><input class='inputnum' type="text" id="valor" name="valor" value="<?php echo $_POST[valor]?>" style="width:80%;" readonly> </td>
                                <td class="saludo1" >Base:</td>
                                <td><input type="text" id="base" name="base" value="<?php echo $_POST[base]?>" onKeyUp="return tabular(event,this)" onChange='calcularpago()' readonly> </td>
                                <td class="saludo1" >Iva:</td>
                                <td><input type="text" id="iva" name="iva" value="<?php echo $_POST[iva]?>" onKeyUp="return tabular(event,this)" onChange='calcularpago()' onBlur="calcularpago()" style="width:100%;" ><input type="hidden" id="regimen" name="regimen" value="<?php echo $_POST[regimen]?>">
								<input type="hidden" name="reado" id="reado" value="<?php echo $_POST[reado]; ?>"></td>
                          	</tr>
     					</table>
	  				<div class="subpantallac6" style="width:99.6%; height:52%; overflow-x:hidden;">
      					<?php
	  						if($_POST[brp]=='1')
	  						{
		 		 				//$_POST[brp]=0;
	  							//*** busca contenido del rp
	 		 					$_POST[dcuentas]=array();
							  	$_POST[dncuentas]=array();
							  	$_POST[dvalores]=array();
							  	$_POST[dvaloresoc]=array();	  
							  	$_POST[drecursos]=array();
							  	$_POST[rubros]=array();	  	  	  
							  	$_POST[dnrecursos]=array();	  	  
	  							$sqlr="select *from pptorp_detalle where pptorp_detalle.consvigencia=(select pptorp.consvigencia from pptorp where consvigencia=".$_POST[rp]." and pptorp.vigencia=$_POST[vigencia] ) and pptorp_detalle.vigencia=$_POST[vigencia]";
	  							$res=mysql_query($sqlr,$linkbd);
								while($r=mysql_fetch_row($res))
	 							{
	  								$consec=$r[0];	  
	  								$_POST[dcuentas][]=$r[3];
	  								$_POST[dvalores][]=$r[7];
 									$_POST[dvaloresoc][]=$r[7];	  
	   								$_POST[dncuentas][]=buscacuentapres($r[3],2);	   
	   								$_POST[rubros][]=$r[3];	   
	   	 							$nfuente=buscafuenteppto($r[3],$_POST[vigencia]);
			  	 					$cdfuente=substr($nfuente,0,strpos($nfuente,"_"));
					  				$_POST[drecursos][]=$cdfuente;
					  				$_POST[dnrecursos][]=$nfuente;				 
		 						}
	  						}
	  					?>
	   					<table class="inicio">
	   						<tr><td colspan="8" class="titulos">Detalle Orden de Pago</td></tr>                  
      					 	<?php
	   							if($_POST[todos]==1){$checkt='checked';}
								else {$checkt='';}
	   						?>
							<tr>
                            	<td class="titulos2">Cuenta</td>
                                <td class="titulos2">Nombre Cuenta</td>
                                <td class="titulos2">Recurso</td>
                                <td class="titulos2">Valor</td>
                                <td class="titulos2"><input type="checkbox" id="todos" name="todos" onClick="checktodos()" value="<?php echo $_POST[todos]?>" <?php echo $checkt ?>/><input type='hidden' name='elimina' id='elimina'  ></td>
                        	</tr>
							<?php
		  						$_POST[totalc]=0;
								$iter='saludo1a';
								$iter2='saludo2';
		 						for ($x=0;$x<count($_POST[dcuentas]);$x++)
		 						{		
		 							$chk=''; 
									// echo "a".$_POST[dcuentas][$x];
									$ch=esta_en_array($_POST[rubros],$_POST[dcuentas][$x]);
									if($ch=='1')
			 						{
			 							$chk=" checked";
			 							$_POST[totalc]=$_POST[totalc]+$_POST[dvalores][$x];	
					 				}
								 	echo "
									<input type='hidden' name='dcuentas[]' value='".$_POST[dcuentas][$x]."'/>
									<input type='hidden' name='dncuentas[]' value='".$_POST[dncuentas][$x]."'/>
									<input type='hidden' name='drecursos[]' value='".$_POST[drecursos][$x]."'/>
									<input type='hidden' name='dnrecursos[]' value='".$_POST[dnrecursos][$x]."'/>
									<input type='hidden' name='dvalores[]' value='".$_POST[dvalores][$x]."'/>
									<input type='hidden' name='dvaloresoc[]' value='".$_POST[dvaloresoc][$x]."'/>
									<tr  class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
				onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase'>
										<td style='width:10%;'>".$_POST[dcuentas][$x]."</td>
										<td style='width:30%;'>".$_POST[dncuentas][$x]."</td>
										<td style='width:40%;'>".$_POST[dnrecursos][$x]."</td>
										<td style='text-align:right;width:10%;' "; if($ch=='1'){echo "onDblClick='llamarventanaegre(this,$x);'";} echo" >$ ".number_format($_POST[dvalores][$x],2,'.',',')."</td>
		 								<td style='width:3%;'><input type='checkbox' name='rubros[]' value='".$_POST[dcuentas][$x]."' onClick='resumar()' $chk></td>
									</tr>";
									$aux=$iter;
								 	$iter=$iter2;
								 	$iter2=$aux;
		 						}
								$resultado = convertir($_POST[totalc]);
								$_POST[letras]=$resultado." PESOS M/CTE";
		 						$_POST[totalcf]=number_format($_POST[totalc],2,".",",");
	    						echo "
								<input type='hidden' name='totalcf' value='$_POST[totalcf]'/>
								<input type='hidden' name='totalc' value='$_POST[totalc]'/>
								<input type='hidden' name='letras' value='$_POST[letras]'/>
								<tr class='$iter' style='text-align:right;'>
									<td colspan='3'>Total:</td>
									<td>$ $_POST[totalcf]</td>
								</tr>
								<tr class='titulos2'>
									<td>Son:</td> 
									<td colspan='5'>$_POST[letras]</td>
								</tr>";
							?>
        					<script>
								document.form2.valor.value=<?php echo $_POST[totalc];?>;
								document.form2.valoregreso.value=<?php echo $_POST[totalc];?>;		
								document.form2.valorcheque.value=document.form2.valor.value-document.form2.valorretencion.value;		
        					</script>
	   					</table>
					</div>
      				<?php
	  					if(!$_POST[oculto]){echo" <script> document.form2.fecha.focus();document.form2.fecha.select();</script>";}
					 	//***** busca tercero
			 			if($_POST[brp]=='1')
			 			{
			  				$nresul=buscaregistro($_POST[rp],$_POST[vigencia]);
			  				if($nresul!='')
			   				{
			  					$_POST[cdp]=$nresul;
  								echo"<script>document.getElementById('cc').focus(); document.getElementById('cc').select();</script>";
			  				}
			 				else
			 				{
			  					$_POST[cdp]="";
			 					echo"<script>alert('Registro Presupuestal Incorrecto');document.form2.rp.select();</script>";
			  				}
			 			}
			  			if($_POST[bt]=='1')
			 			{
			  				$nresul=buscatercero($_POST[tercero]);
			  				$_POST[regimen]=buscaregimen($_POST[tercero]);	
			  				if($nresul!='')
			   				{
			  					$_POST[ntercero]=$nresul;
			  					if($_POST[regimen]==1){$_POST[iva]=round($_POST[valor]-$_POST[valor]/(1.16),1);}	
					 			else {$_POST[iva]=0;}	
				 				$_POST[base]=$_POST[valor]-$_POST[iva];
  								echo"
								<script>
									document.getElementById('detallegreso').focus();
									document.getElementById('detallegreso').select();
								</script>";
			  				}
			 				else
			 				{
			 		 			$_POST[ntercero]="";
			  					echo"<script>alert('Tercero Incorrecto o no Existe');document.form2.tercero.focus();</script>";
			 				}
						}
					?>
	  			</div>
			</div>
			<div class="tab">
       			<input type="radio" id="tab-3" name="tabgroup1" value="3" <?php echo $check3;?>>
       			<label for="tab-3">Anticipo</label>
       			<div class="content" style="overflow-x:hidden;"> 
	   				<table class="inicio" align="center" >
	   					<tr>
                        	<td colspan="6" class="titulos">Cheque</td>
                        	<td class="cerrar"><a href="teso-principal.php">&nbsp;Cerrar</a></td>
                        </tr>
						<tr colspan="3">
	  						<td class="saludo1" style="width:10%;">Cuenta Contable:</td>
	  						<td>
	    						<input name="cuentapagar" type="text" value="<?php echo $_POST[cuentapagar]?>"  readonly> 
								
                         	</td>
	  					</tr> 
	  					<tr>
	  						<td class="saludo1">Valor Orden de Pago:</td>
                            <td><input type="text" id="valoregreso" name="valoregreso" value="<?php echo $_POST[valoregreso]?>"  onKeyUp="return tabular(event,this)" readonly></td>
                            
                            <td class="saludo1">Valor Anticipo:</td>
                            <td><input class='inputnum' type="text" id="valorcheque" name="valorcheque" value="<?php echo $_POST[valorcheque]?>" size="20" onKeyUp="return tabular(event,this)" readonly></td>
                     	</tr>	
      				</table>
	   			</div>
	 		</div>
		</div>
 		<?php
		//echo count($_POST[dcuentas]);
			if($_POST[oculto]=='2')
			{
	 			
  				
			}//************ FIN DE IF OCULTO************
			?>	
            <div id="bgventanamodal2">
                <div id="ventanamodal2">
                    <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                    </IFRAME>
                </div>
       	 	</div>  
		</form>
	</body>
</html>	 