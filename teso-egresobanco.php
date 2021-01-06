<?php //V 1002 26/12/16 Modificado implementacion de Reversion?> 
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
       	<link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <link href="css/tabs.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="JQuery/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
		<script>
			function despliegamodal2(_valor,_num)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else 
				{
					switch(_num)
					{
						case '1':	document.getElementById('ventana2').src="ordenpago-ventana1.php?vigencia="+document.form2.vigencia.value;break;
						case '2':	document.getElementById('ventana2').src="cuentasbancarias-ventana01.php?tipoc=C";break;
						case '3':	document.getElementById('ventana2').src="cuentasbancarias-ventana01.php?tipoc=D";break;
						case '4':	document.getElementById('ventana2').src="reversar-egreso.php?vigencia="+document.form2.vigencia.value;break;
					}
				}
			}
			function validar(){
				document.form2.submit();}
			function validar2(){
				document.form2.egresoo.value=1;
				document.form2.submit();
				}
			function buscaop(e)
 			{
				if (document.form2.orden.value!="")
				{
 					document.form2.bop.value='1';
 					document.form2.submit();
 				}
 			}
			function guardar()
			{

					var fechabloqueo=document.form2.fechabloq.value;
					var fechadocumento=document.form2.fecha.value;
					var nuevaFecha=fechadocumento.split("/");
					var fechaCompara=nuevaFecha[2]+"-"+nuevaFecha[1]+"-"+nuevaFecha[0];
					var validacion01=document.form2.orden.value;
					if((Date.parse(fechabloqueo)) > (Date.parse(fechaCompara))){
						despliegamodalm('visible','2','Fecha de documento menor que fecha de bloqueo');
					}else{
						var vigencia="<?php echo vigencia_usuarios($_SESSION[cedulausu]) ?>";
						
					if(document.form2.tipomovimiento.value=='201'){
					var saldo=parseInt(document.form2.saldocxp.value);
					if(saldo<=0){
						despliegamodalm('visible','2','No hay saldo en dicha orden de pago');
					}else{

					if((validacion01.trim()!='') && document.getElementById('tipop').value!='' && document.form2.fecha.value!='')
					{
						// alert("tipo 1.1");
						if(document.getElementById('tipop').value=='cheque')
						{
							var validacion02=document.getElementById('ncheque').value;
							if ((validacion02.trim()!='')&& document.getElementById('nbanco').value!='')
							{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
							else {despliegamodalm('visible','2','Falta informacion para Crear la Cuenta');}
						}
						else if(document.getElementById('tipop').value=='transferencia')
						{
							var validacion02=document.getElementById('ntransfe').value;
							if ((validacion02.trim()!='')&& document.getElementById('nbanco').value!='')
							{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
							else {despliegamodalm('visible','2','Falta informacion para Crear la Cuenta');}
						}
						else {despliegamodalm('visible','2','Falta informacion para Crear la Cuenta');}
					}
					else {despliegamodalm('visible','2','Falta informacion para Crear la Cuenta');}
					}

				}else{
					despliegamodalm('visible','4','Esta Seguro de Guardar','1');
				}
						
					}

					
				
				
				
			}
			
			
			function calcularpago()
 			{
				valorp=document.form2.valor.value;
				descuentos=document.form2.totaldes.value;
				valorc=valorp-descuentos;
				document.form2.valorcheque.value=valorc;
				document.form2.valoregreso.value=valorp;
				document.form2.valorretencion.value=descuentos;
 			}
			function pdf()
			{
				document.form2.action="pdfegreso.php";
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
			function funcionmensaje()
			{
				var _cons=document.getElementById('egreso').value;
				document.location.href = "teso-girarchequesver.php?idegre="+_cons+"&scrtop=0&numpag=1&limreg=10&filtro1=&filtro2=";
			}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	
						// alert("case 1");
						document.form2.oculto.value='2';
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
		<table >
			<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("teso");?></tr>
			<tr>
  				<td colspan="3" class="cinta">
					<a onClick="location.href='teso-girarcheques.php'" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
					<a onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar"/></a>
					<a class="mgbt" onClick="location.href='teso-buscagirarcheques.php'" ><img src="imagenes/busca.png" title="Buscar"/></a>
					<a onClick="<?php echo paginasnuevas("teso");?>" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
					<a class="mgbt"><img src="imagenes/printd.png" /></a>
					<a href="teso-gestionpago.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
				</td>
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
                $vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
                $sesion=$_SESSION[cedulausu];
 				$sqlr="Select dominios.valor_final from usuarios,dominios where usuarios.cc_usu=$sesion and dominios.NOMBRE_DOMINIO='PERMISO_MODIFICA_DOC' and dominios.valor_inicial=usuarios.cc_usu ";
				$resp = mysql_query($sqlr,$linkbd);
				$fechaBloqueo=mysql_fetch_row($resp);
				echo "<input type='hidden' name='fechabloq' id='fechabloq' value='$fechaBloqueo[0]' />";
                $vigencia=$vigusu;
                $_POST[saldocxp]=generaSaldoCXP($_POST[orden],$vigencia);
                $sqlr="select *from cuentapagar where estado='S' ";
                $res=mysql_query($sqlr,$linkbd);
                while ($row =mysql_fetch_row($res)){$_POST[cuentapagar]=$row[1];}
                //*********** cuenta origen va al credito y la destino al debito
                if(!$_POST[oculto])
                {
                    $sqlr="select *from cuentapagar where estado='S' ";
                    $res=mysql_query($sqlr,$linkbd);
                    while ($row =mysql_fetch_row($res)){$_POST[cuentapagar]=$row[1];}
                    $sqlr="select *from tesoegresos where estado='S' and tipo_mov='201' and vigencia=$vigusu";
                    $res=mysql_query($sqlr,$linkbd);
                    while ($row =mysql_fetch_row($res)){$_POST[cuentapagar]=$row[1];}
                    $check1="checked";
                    $fec=date("d/m/Y");
                    $_POST[fecha]=$fec; 		 		  			 
					$_POST[vigencia]=$vigusu; 	
					
					$sqlr="select max(id_egreso) from tesoegresos";
					$res=mysql_query($sqlr,$linkbd);
					$row =mysql_fetch_row($res);
                    $_POST[egreso]=$row[0]+1;	
					if($_POST[egresoo]!=1){
						$_POST[tipomovimiento]='201';
						$_POST[tabgroup1]=1;
						$_POST[orden]='';
						unset($_POST[dcuentas]);
						unset($_POST[dncuentas]);
						unset($_POST[drecursos]);
						unset($_POST[dvalores]);
					}
                }
                switch($_POST[tabgroup1])
                {
                    case 1:	$check1='checked';break;
                    case 2:	$check2='checked';break;
                    case 3:	$check3='checked';
                }
		
 				if($_POST[bop]=='1')
			 	{
				 	if($_POST[orden]!='' )
				 	{	

				 		$vigencia=date(Y);
			  			//*** busca detalle cdp
  						$sqlr="select * from tesoordenpago where id_orden=$_POST[orden] and estado='S' and vigencia=$vigusu and tipo_mov='201' ";
						$resp = mysql_query($sqlr,$linkbd);
						$row =mysql_fetch_row($resp);
						$_POST[concepto]=$row[7];
						$_POST[tercero]=$row[6];
						$_POST[ntercero]=buscatercero($_POST[tercero]);
						$_POST[tercerocta]=buscatercero_cta($_POST[tercero]);
						$_POST[valororden]=$row[10];
						
						$_POST[retenciones]=$row[12];
						$_POST[cc]=$row[5];
						$_POST[vigenciaop]=$row[3];
						$_POST[totaldes]=number_format($_POST[retenciones],2);
						$_POST[valorpagar]=$_POST[valororden]-$_POST[retenciones];
						$_POST[base]=$row[14];
						$_POST[iva]=$row[15];
						$_POST[bop]="";
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
			<table class="inicio">
				<tr>
					<td class="titulos" style="width:100%;">.: Tipo de Movimiento 
						<input type="hidden" value="1" name="oculto" id="oculto">
					
						<select name="tipomovimiento" id="tipomovimiento" onKeyUp="return tabular(event,this)" onChange="validar()" style="width:20%;" >
							<?php 
								$sqlr="select * from tipo_movdocumentos where estado='S' and modulo='4'";
								$resp = mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($resp)) 
								{
									if($row[0]!=3){
										if($_POST[tipomovimiento]==$row[0].$row[1]){
											echo "<option value='$row[0]$row[1]' SELECTED >$row[0]$row[1]-$row[2]</option>";
										}else{
											echo "<option value='$row[0]$row[1]'>$row[0]$row[1]-$row[2]</option>";
										}
									}
								}
								
							?>
						</select>
					</td>
					<td style="width:80%;">
					</td>
				</tr>
			</table>
 			<?php if($_POST[tipomovimiento]=='201'){?>  
			<div class="tabsic" style="height:36%; width:99.6%;"> 
   				<div class="tab"> 
       				<input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
	  				<label for="tab-1">Egreso</label>
	   				<div class="content" style="overflow-x:hidden;">
	   					<table class="inicio" align="center" >
	   						<tr>
	     						<td colspan="7" class="titulos">Comprobante de Egreso</td>
                                <td class="cerrar" style="width:7%;"><a onClick="location.href='teso-principal.php'">&nbsp;Cerrar</a></td>
                         	</tr>
       						<tr>
                            	<td class="saludo1" style="width:2.7cm;">N&deg; Egreso:</td>
                                <td style="width:16%">
                                	<input type="hidden" name="cuentapagar" value="<?php echo $_POST[cuentapagar]?>" > 
                                    <input type="text" name="egreso" id="egreso" value="<?php echo $_POST[egreso]?>" onKeyUp="return tabular(event,this)" onBlur="buscarp(event)" style="width:56%" readonly >
                                    <input type="text" name="vigencia" value="<?php echo $_POST[vigencia]?>" onKeyUp="return tabular(event,this)" style="width:22%;" readonly>
                              	</td>
       	  						<td class="saludo1" style="width:2cm;">Fecha: </td>
        						<td style="width:20%"><input type="text" id="fc_1198971545" name="fecha" value="<?php echo $_POST[fecha]?>" title="DD/MM/YYYY" maxlength="10" onKeyDown="mascara(this,'/',patron,true)" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" style="width:60%">&nbsp;<a href="#" onClick="displayCalendarFor('fc_1198971545');" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px;" ></a></td>       
       							<td class="saludo1" style="width:2.8cm;">Forma de Pago:</td>
       							<td style="width:14%">
       								<select name="tipop" id="tipop" onChange="validar();" onKeyUp="return tabular(event,this)" style="width:100%">
       									<option value="">Seleccione ...</option>
				  						<option value="cheque" <?php if($_POST[tipop]=='cheque') echo "SELECTED"?>>Cheque</option>
  				  						<option value="transferencia" <?php if($_POST[tipop]=='transferencia') echo "SELECTED"?>>Transferencia</option>
				  					</select> 
                                 </td>
                                 <td rowspan="7" colspan="2" style="background:url(imagenes/cheque04.png); background-repeat:no-repeat; background-position:right; background-size: 90% 90%"></td>
       						</tr>
							<tr>  
                            	<td class="saludo1">N&deg; Orden Pago:</td> 
	  							<td>
                                	<input type="text" name="orden" id="orden" value="<?php echo $_POST[orden]?>" onKeyUp="return tabular(event,this)" onBlur="buscaop(event)"  style="width:80%">
                                    <input type="hidden" value="0" name="bop">&nbsp;<a onClick="despliegamodal2('visible','1');" style="cursor:pointer;" title="Listado Ordenes Pago"><img src="imagenes/find02.png" style="width:20px;"/></a></td>
                               	<td class="saludo1">Vigencia:</td>
                              	<td><input type="text" name="vigenciaop"  value="<?php echo $_POST[vigenciaop]?>" onKeyUp="return tabular(event,this)" readonly style="width:60%"></td>
                         	</tr>
                            <tr>
     							<td class="saludo1">Tercero:</td>
          						<td ><input id="tercero" type="text" name="tercero"  onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo $_POST[tercero]?>" style="width:80%" readonly></td>
           						<td colspan="2"><input name="ntercero" type="text" value="<?php echo $_POST[ntercero]?>" style="width:100%" readonly></td>
                                <td class="saludo1">Cuenta:</td>
                                <td><input name="tercerocta" type="text" value="<?php echo $_POST[tercerocta]?>" style="width:100%" readonly></td>
                         	</tr>
							<tr>
                            	<td class="saludo1">Concepto:</td>
                                <td colspan="5"><textarea id="concepto" name="concepto" style="width:100%; height:40px;resize:none;background-color:#E6F7FF;color:#333;border-color:#ccc;" readonly><?php echo $_POST[concepto];?></textarea></td>
                          	</tr>           
     				 		<?php 
	 	 						if($_POST[tipop]=='cheque') //**** if del cheques
	   			 				{
									if($_POST[escuentas]=='' || $_POST[escuentas]=='tran')
									{
										$_POST[escuentas]='che';
										$_POST[cb]='';
										$_POST[nbanco]='';
										$_POST[banco]='';
										$_POST[tcta]='';
										$_POST[ter]='';
										$_POST[ncheque]='';
									}
	  								echo" 
           							<tr>
	  									<td class='saludo1'>Cuenta Bancaria:</td>
	  									<td>
											<input type='text' name='cb' id='cb' value='$_POST[cb]' style='width:80%'/>
	     								&nbsp;<a onClick=\"despliegamodal2('visible','2');\"  style='cursor:pointer;' title='Listado Cuentas Bancarias'><img src='imagenes/find02.png' style='width:20px;'/></a>
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
									if($_POST[escuentas]=='' || $_POST[escuentas]=='che')
									{
										$_POST[escuentas]='tran';
										$_POST[cb]='';
										$_POST[nbanco]='';
										$_POST[banco]='';
										$_POST[tcta]='';
										$_POST[ter]='';
										$_POST[ntransfe]='';
									}
	  								echo"
      								<tr>
	  									<td class='saludo1'>Cuenta Bancaria:</td>
	  									<td>
                                            <input type='text' name='cb' id='cb' value='$_POST[cb]' style='width:80%'/>
	     								&nbsp;<a onClick=\"despliegamodal2('visible','3');\"  style='cursor:pointer;' title='Listado Cuentas Bancarias'><img src='imagenes/find02.png' style='width:20px;'/></a>
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
	  							<td class="saludo1">Valor Orden:</td>
                                <td><input name="valororden" type="text" id="valororden" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[valororden]?>" style="width:80%" readonly></td>	  
                                <td class="saludo1">Retenciones:</td>
                                <td><input name="retenciones" type="text" id="retenciones" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[retenciones]?>" readonly></td>	  
                                <td class="saludo1">Valor a Pagar:</td>
                                <td ><input name="valorpagar" type="text" id="valorpagar" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[valorpagar]?>" style="width:100%" readonly> </td>
                                
                         	</tr>	
                            <tr>
                            	<td class="saludo1" >Base:</td>
                                <td><input type="text" id="base" name="base" value="<?php echo $_POST[base]?>"  onKeyUp="return tabular(event,this)" onChange='calcularpago()' style="width:80%" readonly> </td>
                                <td class="saludo1" >Iva:</td>
                                <td><input type="text" id="iva" name="iva" value="<?php echo $_POST[iva]?>" onKeyUp="return tabular(event,this)" onChange='calcularpago()' readonly> <input type="hidden" id="regimen" name="regimen" value="<?php echo $_POST[regimen]?>" > <input type="hidden" id="cc" name="cc" value="<?php echo $_POST[cc]?>" ></td>
                                <td class="saludo1">Saldo Orden:</td>
                                <td ><input name="saldocxp" id="saldocxp" value="<?php echo $_POST[saldocxp]?>" type="text"  readonly/> </td>
                            </tr>
      					</table>
	 				</div>
     			</div>
                <input type="hidden" name="escuentas" id="escuentas" value="<?php echo $_POST[escuentas];?>"/>
     			<div class="tab">
       				<input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?>>
       				<label for="tab-2">Retenciones</label>
       				<div class="content" style="overflow-x:hidden;"> 
         				<table class="inicio" style="overflow:scroll">
         					<tr><td class="titulos" colspan="3">Retenciones</td></tr>
        					<tr>
                            	<td class="titulos2">Descuento</td>
                                <td class="titulos2">%</td>
                                <td class="titulos2">Valor</td>
                         	</tr>
                            <input type="hidden" id="totaldes" name="totaldes" value="<?php echo $_POST[totaldes]?>" readonly>
							
      						<?php
								if ($_POST[oculto]!='')
		 						{
									
									$totaldes=0;
									$_POST[dndescuentos]=array();
									$_POST[ddescuentos]=array();
									$_POST[dporcentajes]=array();				
									$_POST[ddesvalores]=array();

									$gdndescuentos=array();
									$gddescuentos=array();
									$gdporcentajes=array();				
									$gddesvalores=array();	
									$sqlr="select *from tesoordenpago_retenciones where id_orden=$_POST[orden] and estado='S'";
									
									$resd=mysql_query($sqlr,$linkbd);
									$iter='saludo1a';
									$iter2='saludo2';
									$cr=0;
									while($rowd=mysql_fetch_row($resd))
									{	
										$sqlr2="SELECT *from tesoretenciones where id=".$rowd[0];	 
		 								$resd2=mysql_query($sqlr2,$linkbd);
		  								$rowd2=mysql_fetch_row($resd2);
										$gdndescuentos[$cr]="$rowd2[1] - $rowd2[2]";
										$gddescuentos[$cr]=$rowd2[1];
										$gdporcentajes[$cr]=$rowd[2];				
										$gddesvalores[$cr]=round($rowd[3],0);	

		 								echo "
										<input type='hidden' name='dndescuentos[]' value='$rowd2[1] - $rowd2[2]'/>
										<input type='hidden' name='ddescuentos[]' value='$rowd2[1]'/>
										<input type='hidden' name='dporcentajes[]' value='$rowd[2]'/>
										<input type='hidden' name='ddesvalores[]' value='".round($rowd[3],0)."'/>
										<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor; this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\">
											<td>$rowd2[1] - $rowd2[2]</td>
											<td style='width:10%;'>$rowd[2]</td>
											<td style='text-align:right;width:15%;'>$ ".number_format(round($rowd[3],0),$_SESSION["ndecimales"],$_SESSION["spdecimal"],$_SESSION["spmillares"])."</td>
										</tr>";
										$totaldes=$totaldes+($rowd[3]);
										$aux=$iter;
										$iter=$iter2;
										$iter2=$aux;
										$cr=$cr+1;
		 							}
									//echo "<br>c: ".count($gdndescuentos);
									$_POST[contrete]=$cr;
		 						}
								echo"
								<tr class='$iter' style='text-align:right;font-weight:bold;'>
                                	<td colspan='2'>Total:</td>
                            	 	<td>$ $_POST[totaldes]</td>
                           		</tr>";
							echo"<script>document.form2.totaldes.value='$totaldes';calcularpago();</script>";
							?>
							<input type='hidden' name='contrete' value="<?php echo $_POST[contrete] ?>" />
        				</table>
						
	   				</div>
  			 	</div> 
			</div> 
			<?php }if($_POST[tipomovimiento]=='401'){?>
			<table class="inicio">
				<tr>
					<td class="titulos" colspan="6">.: Documento a Reversar</td>
				</tr>
				<tr>
					<td class="saludo1" style="width:10%;">Número Egreso:</td>
					<td style="width:10%;">
						<input type="hidden" name="egresoo" id="egresoo" value="<?php echo $_POST[egresoo]?>">
						<input type="text" name="egreso" id="egreso" value="<?php echo $_POST[egreso]; ?>" style="width:80%;" onKeyUp="return tabular(event,this)" onBlur="validar2()" readonly>
						<a href="#" onClick="despliegamodal2('visible','4','<?php echo $_POST[vigencia]?>');" title="Buscar CxP"><img src="imagenes/find02.png" style="width:20px;"></a>
						<input type="hidden" name="vigencia" value="<?php echo $_POST[vigencia]?>">
					</td>
					<td class="saludo1" style="width:10%;">Fecha:</td>
					<td style="width:10%;">
						<input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" style="width:80%;" title="DD/MM/YYYY"/>&nbsp;<a href="#" onClick="displayCalendarFor('fc_1198971545');" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px;"/></a>
					</td>
					<td class="saludo1" style="width:10%;">Descripcion</td>
					<td style="width:60%;" colspan="3">
						<input type="text" name="descripcion" id="descripcion" value="<?php echo $_POST[descripcion]?>" style="width:100%;">
					</td>
				</tr>	
				<tr>
					<td class="saludo1">N° CxP</td>
					<td><input type="text" name="orden" id="orden" value="<?php echo $_POST[orden];?>" readonly></td>
					<td class="saludo1">Valor Egreso</td>
					<td><input type="text" name="valoregreso" id="valoregreso" value="<?php echo $_POST[valoregreso];?>" readonly></td>
				</tr>
			</table>
			<?php }?>
			<div class="subpantallac4" style="height:35%; width:99.6%; overflow-x:hidden;">
 				<table class="inicio">
	   				<tr><td colspan="8" class="titulos">Detalle Orden de Pago</td></tr>                  
					<tr>
                        <td class="titulos2" style="width:15%;">Cuenta</td>
                        <td class="titulos2">Nombre Cuenta</td>
                        <td class="titulos2">Recurso</td>
                        <td class="titulos2" style="width:15%;">Valor</td>
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
		  				$_POST[totalc]=0;
		  				$sqlr="select * from tesoordenpago_det where id_orden=$_POST[orden] and estado='S' and tipo_mov='201'";
						// echo $sqlr;
						$dcuentas[]=array();
						$dncuentas[]=array();
						$_POST[drecursos]=array();
						$_POST[dnrecursos]=array();	
						$resp2 = mysql_query($sqlr,$linkbd);
						$iter='saludo1a';
						$iter2='saludo2';
						
						while($row2=mysql_fetch_row($resp2))
						{
				  			$nombre=buscacuentapres($row2[2],2);
				  			$nfuente=buscafuenteppto($row2[2],$_POST[vigencia]);
			  				$cdfuente=substr($nfuente,0,strpos($nfuente,"_"));
							$_POST[drecursos][]=$nfuente;
		 					echo "
							<input type='hidden' name='dcuentas[]' value='$row2[2]'/>
							<input type='hidden' name='dncuentas[]' value='$nombre'/>
							<input type='hidden' name='drecursos[]' value='$nfuente'/>
							<input type='hidden' name='dvalores[]' value='$row2[4]'/>
							<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor; this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\">
								<td >$row2[2]</td>
								<td >$nombre</td>
								<td>$nfuente</td>
								<td style='text-align:right;' onDblClick='llamarventanaegre(this,$x);'>".number_format($row2[4],$_SESSION["ndecimales"],$_SESSION["spdecimal"],$_SESSION["spmillares"])."</td>
							</tr>";
							$_POST[totalc]=$_POST[totalc]+$row2[4];
							$_POST[totalcf]=number_format($_POST[totalc],$_SESSION["ndecimales"],$_SESSION["spdecimal"],$_SESSION["spmillares"]);
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux;
		 				}
						$resultado = convertir($_POST[valorpagar]);
						$_POST[letras]=$resultado." PESOS M/CTE";
	  					echo "
						<input type='hidden' name='totalcf' value='$_POST[totalcf]'/>
						<input type='hidden' name='totalc' value='$_POST[totalc]'/>
						<input name='letras' type='hidden' value='$_POST[letras]'/>
						<tr class='$iter' style='text-align:right;font-weight:bold;'>
							<td colspan='3'>Total:</td>
							<td>$_POST[totalcf]</td>
						</tr>
						<tr class='titulos2'>
							<td>Son:</td> 
							<td colspan='5'>$_POST[letras]</td>
						</tr>";
					?>
        			<script>
        				document.form2.valor.value=<?php echo $_POST[totalc];?>;
						//calcularpago();
        			</script>
	   			</table>
        	</div>	
        	<?php
			
				if($_POST[oculto]=='2')
				{
					$query="SELECT conta_pago FROM tesoparametros";
					$resultado=mysql_query($query,$linkbd);
					$arreglo=mysql_fetch_row($resultado);
					$opcion=$arreglo[0];
					if($_POST[tipomovimiento]=='201'){
						// echo "hola";
						$_POST[egreso]=selconsecutivo('tesoegresos','id_egreso');
						echo "<script>document.getElementById('egreso').value=".$_POST[egreso].";</script>";
						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
						$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
						$bloq=bloqueos($_SESSION[cedulausu],$fechaf);	
						if($_POST[tipop]=='cheque'){$vartipos=$_POST[ncheque];}
						if($_POST[tipop]=='transferencia'){$vartipos=$_POST[ntransfe];}
						if($bloq>=1)
						{	
							// echo "hola 1";
							//************CREACION DEL COMPROBANTE CONTABLE ************************
							$sqlr="select count(*) from tesoegresos where id_orden=$_POST[orden] and estado ='S'";
							$res=mysql_query($sqlr,$linkbd);
							$row=mysql_fetch_row($res);
							$nreg=$row[0];
							if ($nreg==0)
							{
								$sqlr="insert into tesoegresos (id_egreso,id_orden,fecha,vigencia,valortotal,retenciones,valorpago,concepto,banco,cheque, tercero, cuentabanco,estado,pago,tipo_mov) values ('$_POST[egreso]','$_POST[orden]','$fechaf','$vigusu','$_POST[valororden]','$_POST[retenciones]', '$_POST[valorpagar]','$_POST[concepto]','$_POST[banco]','$vartipos','$_POST[tercero]','$_POST[cb]','S','$_POST[tipop]','201')"; 

								if (!mysql_query($sqlr,$linkbd))
								{
									echo "<script>despliegamodalm('visible','2','Manejador de Errores de la Clase BD, No se pudo ejecutar la petición');</script>";
								}
								else
								{
									$query="update tesoordenpago_retenciones set pasa_ppto='S' WHERE id_orden=".$_POST[orden];
									mysql_query($query,$linkbd);
									$ideg=$_POST[egreso];
									$sqlr="update tesochequeras set consecutivo=consecutivo+1 where cuentabancaria='$_POST[cb]'  and estado='S'";
									mysql_query($sqlr,$linkbd);
									$sqlr="update tesocheques set estado='P', destino='EGRESO', idcomp='$_POST[egreso]' where cuentabancaria='$_POST[cb]' and cheque='$_POST[ncheque]'";
									mysql_query($sqlr,$linkbd);
									//ppto
									 $sqlr="insert into  pptocomprobante_cab (numerotipo,tipo_comp,fecha,concepto,vigencia,total_debito,total_credito, diferencia,estado) values($ideg,17,'$fechaf','DESCUENTOS EGRESO',$_POST[vigencia],$_POST[valorpagar],0,0,'1')";
									 
									mysql_query($sqlr,$linkbd);
									$sqlr="insert into  pptocomprobante_cab (numerotipo,tipo_comp,fecha,concepto,vigencia,total_debito,total_credito, diferencia,estado) values($ideg,11,'$fechaf','EGRESO ',$_POST[vigenciaop],$_POST[valorpagar],0,0,'1')";
									mysql_query($sqlr,$linkbd);	
									$sqlr="insert into tesoegresos_cheque (id_cheque,id_egreso,estado,motivo) values ('$vartipos',$ideg,'S','')";
									mysql_query($sqlr,$linkbd);
									$sqlr="update tesoordenpago set estado='P' where id_orden=$_POST[orden] and estado='S' and tipo_mov='201' ";
									mysql_query($sqlr,$linkbd);
									//*****hacer la afectacion presupuestal
									$sqlr="select *from tesoordenpago_det where id_orden=$_POST[orden] and tipo_mov='201'";
									//echo "1 $sqlr <br> ";
									$resp2 = mysql_query($sqlr,$linkbd);
									while($row2=mysql_fetch_row($resp2))
									{
										$sqlr="insert into pptorecibopagoppto  (cuenta,idrecibo,valor,vigencia) values ('$row2[2]','$ideg','$row2[4]', '$vigusu')";	
										//echo "2 $sqlr <br> ";
										mysql_query($sqlr,$linkbd);
										$sqlr="UPDATE  pptocuentaspptoinicial SET pagos=pagos+$row2[4] where (vigencia='$vigusu' or vigenciaf='$vigusu') and cuenta='$row2[2]' and vigenciaf='$vigusu'";				
										mysql_query($sqlr,$linkbd);
										$sqlr="UPDATE  pptocuentaspptoinicial SET cxp=cxp-$row2[4] where (vigencia='$vigusu' or vigenciaf='$vigusu') and cuenta='$row2[2]' and vigenciaf='$vigusu'";				
										mysql_query($sqlr,$linkbd);
										$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp, numerotipo, tipomovimiento,uniejecutora,doc_receptor,fecha) values('".$row2[2]."','".$_POST[tercero]."',' EGRESO ',".$row2[4].",0,1,'$_POST[vigencia]',11,'$ideg','201','','','$fechaf')";
										mysql_query($sqlr,$linkbd); 
										$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp, numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values('".$row2[2]."','".$_POST[tercero]."',' EGRESO ',0,".$row2[4].",1,'$_POST[vigencia]',8,'$_POST[orden]','201','','$ideg','$fechaf')";
										mysql_query($sqlr,$linkbd); 									
									}
									//***********crear el contabilidad
									$sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($ideg,6,'$fechaf','$_POST[concepto]',0, $_POST[valororden],$_POST[valororden],0,'1')";
									mysql_query($sqlr,$linkbd);
									$idcomp=selconsecutivo('comprobante_cab','id_comp');
									$sqlr="update tesoegresos set id_comp=$idcomp where id_egreso=$ideg and tipo_mov='201' ";			 			 
									mysql_query($sqlr,$linkbd);
									$sqlr="select *from tesoordenpago_det where id_orden=$_POST[orden] and tipo_mov='201' ";
									//echo "3 $sqlr <br> ";
									$resp2 = mysql_query($sqlr,$linkbd);
									while($row2=mysql_fetch_row($resp2))
									{
										$sqlr="select codconcepago from pptocuentas where cuenta='$row2[2]' and (vigencia='$vigusu' or vigenciaf='$vigusu')";
										//echo "4 $sqlr <br> ";	  
										$resp = mysql_query($sqlr,$linkbd);
										while($rowp=mysql_fetch_row($resp))
										{
											$sqlr="select * from conceptoscontables_det where codigo='$rowp[0]' and modulo='3' and cc='$row2[3]' and tipo='P'";	
											//echo "5 $sqlr <br> ";
											$resc = mysql_query($sqlr,$linkbd);
											while($rowc=mysql_fetch_row($resc))
											{
												if($rowc[3]=='N')
												{
													$ncppto=buscacuentapres($row2[2],2);
													$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito, estado, vigencia) values ('6 $ideg','$rowc[4]','$_POST[tercero]','$row2[3]','Pago $ncppto','','$row2[4]',0,'1' ,'$vigusu')";
													//echo "6 $sqlr </br>";
													mysql_query($sqlr,$linkbd);
												}
												if($rowc[3]=='B')
												{
												  $valopb=$row2[4];
													//***buscar retenciones
													//	echo "<br>c:".count($_POST[ddescuentos]);
												  if($opcion=="2"){
													 if($row2[4]>0)
													   {	
														//echo "Hola 0  ";
														for($x=0;$x<$_POST[contrete];$x++)
														{	
															//echo "Hola 1  ";
															//  $sqlr="select *from tesoretenciones_det inner join tesoretenciones on tesoretenciones_det.codigo=tesoretenciones.id where tesoretenciones.codigo='".$_POST[ddescuentos][$x]."'";
															$sqlr="select * from tesoretenciones_det,tesoretenciones where tesoretenciones_det.codigo=tesoretenciones.id and tesoretenciones.codigo='".$gddescuentos[$x]."' and tesoretenciones_det.vigencia='$vigusu'";
															//echo "1 $sqlr <br> ";
															$resdes=mysql_query($sqlr);
															$valordes=0;
															while($rowdes=mysql_fetch_row($resdes))
															{		
																//echo "Hola 2  ";
																if($_POST[iva]>0 && $rowdes[14]==1)
																{
																	//echo "Hola 3  ";
																	//$valordes=$_POST[ddesvalores][$x];
																	//$valordes=round($_POST[ddesvalores][$x]*($rowdes[4]/100),0);
																	//$valordes=round($row2[4]*($rowdes[4]/100),0);
																	//$valordes=round(($row2[4]*($rowdes[4]/100)*($rowdes[13]/100)),0);	
																	//$valordes=round($_POST[iva]*($rowdes[4]/100),0);	
																	$valordes=round(($row2[4]/$_POST[valororden])*($rowdes[4]/100)*$gddesvalores[$x],0);
																	//echo "round(($row2[4]/$_POST[valororden])*($rowdes[4]/100)* ".$_POST[ddesvalores][$x].",0) ";
																	//echo "round($_POST[iva]*($rowdes[4]/100),0) ";
																	//$valordes=round($_POST[ddesvalores][$x]*($rowdes[4]/100),0);
																}
																else
																{
																	//echo "Hola 4   ";
																	//$valordes=($_POST[ddesvalores][$x]);
																	//$valordes=round(($_POST[ddesvalores][$x])*($rowdes[4]/100),0);
																	//$valordes=round(($row2[4])*($rowdes[4]/100),0);
																	//$valordes=round(($row2[4]*($rowdes[4]/100)*($rowdes[13]/100)),0);	
																	$valordes=round(($row2[4]/$_POST[valororden])*($rowdes[4]/100)*$gddesvalores[$x],0);	
																	//echo "round(($row2[4]/$_POST[valororden])*($rowdes[4]/100)* ".$_POST[ddesvalores][$x].",0) ";
																}	
																$valopb-= $valordes; 
																$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito, valcredito, estado, vigencia) values ('6 $ideg','".$rowdes[2]."','".$_POST[tercero]."' ,'".$row2[3]."' , 'Descuento ".$gdndescuentos[$x]."','',0,".$valordes.",'1' ,'".$vigusu."')";
																
																mysql_query($sqlr,$linkbd);
																//cuenta puente
																//echo "rowdes 6 $rowdes[6]";
																if($rowdes[6]!='')
																{
																	//echo "Hola 5  ";
																	$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito, valcredito, estado, vigencia) values ('6 $ideg','".$rowdes[6]."','".$_POST[tercero]."' ,'".$row2[3]."' , 'Descuento ".$gdndescuentos[$x]."','',".$valordes.",0,'1' ,'".$vigusu."')";
																	mysql_query($sqlr,$linkbd);
																	$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito, valcredito, estado, vigencia) values ('6 $ideg','".$rowdes[6]."','".$_POST[tercero]."' ,'".$row2[3]."' , 'Descuento ".$gdndescuentos[$x]."','',0,".$valordes.",'1' ,'".$vigusu."')";
																	mysql_query($sqlr,$linkbd);
																	//echo "Valores $valordes";
																	if($valordes>0)
																	{
																		
																		//*** afectacion pptal DESCUENTOS
																		$sql="insert into pptoretencionpago(cuenta,idrecibo,valor,vigencia) values ('".$rowdes[3]."',$ideg,$valordes,'$vigusu')";
																		mysql_query($sql,$linkbd); 	
																		
																	}
																}
															}	// ** FIn while				  
														}	//**FIn for																 
													}	  // ** Fin if
													}  //** FIn if
													
													//INCLUYE EL CHEQUE
													if($rowc[3]=='B' && $row2[4]>0)
													{
														$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('6 $ideg','".$_POST[banco]."','".$_POST[tercero]."' ,'".$row2[3]."' , 'Pago Banco ".$ncppto."','$_POST[cheque]  $_POST[ntransfe]',0,".$valopb.",'1' ,'".$vigusu."')";	
														//echo "5 $sqlr </br>";														
														mysql_query($sqlr,$linkbd);
													}
												}
											}	  
										}
									}

									echo "<script>despliegamodalm('visible','1','Se ha almacenado el Egreso con Exito');</script>";
								}
							}
							else {echo "<script>despliegamodalm('visible','2','No se puede almacenar, ya existe un egreso para esta orden');</script>";}
						}
						else {echo "<script>despliegamodalm('visible','2',' No Tiene los Permisos para Modificar este Documento');</script>";}
					}
					if($_POST[tipomovimiento]=='401'){
						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
						$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
						$gfecha=getdate();
						$d=$gfecha[mday];
						if($d<10){
							$d="0".$d;
						}
						$m=$gfecha[mon];
						if($m<10){
							$m="0".$m;
						}
						$a=$gfecha[year];
						$gfecha=$a."-".$m."-".$d;
						$sqlr="select * from tesoegresos where id_egreso=$_POST[egreso] and vigencia=$vigusu";
	 					$resp = mysql_query($sqlr,$linkbd);
	 					$row=mysql_fetch_row($resp);
		 				$op=$row[2];
	 					$vpa=$row[7];
	 					//********Comprobante contable en 000000000000
	  					$sqlr="update comprobante_cab set estado='0' where tipo_comp='6' and numerotipo=$row[0]";
	  					mysql_query($sqlr,$linkbd);
	  					$sqlr="update pptocomprobante_cab set estado='2' where tipo_comp='11' and numerotipo=$row[0]";
	 					mysql_query($sqlr,$linkbd);
	 					//********RETENCIONES
 	 					$sqlr="delete from pptoretencionpago where idrecibo=$row[0] and vigencia='".$_SESSION[vigencia]."'";
	 					mysql_query($sqlr,$linkbd);
   	 					$sqlr="delete from pptorecibopagoppto where idrecibo=$row[0] and vigencia='".$_SESSION[vigencia]."'";
	 					mysql_query($sqlr,$linkbd);
	   					$sqlr="update tesoordenpago  set estado='S' where id_orden=$op and tipo_mov='201' ";
	  					mysql_query($sqlr,$linkbd);	 
	   					$sqlr="update tesoegresos set estado='R' where id_egreso=$_POST[egreso] and tipo_mov='201' ";
	  					mysql_query($sqlr,$linkbd);
						
						//$sqlr="insert into tesoegresos_cab_r (id_egreso,id_orden,vigencia,detalle,fecha,fecha_doc,user) values ('$_POST[egreso]','$op','$_POST[vigencia]','$_POST[descripcion]','$fechaf','$gfecha','".$_SESSION['nickusu']."')";	

	$sqlr="insert into tesoegresos(id_egreso,id_orden,fecha,vigencia,concepto,user,tipo_mov) values ('$_POST[egreso]','$op','$fechaf','$_POST[vigencia]','$_POST[descripcion]','".$_SESSION['nickusu']."','401')";

						
						mysql_query($sqlr,$linkbd);						
						
						for($x=0;$x<count($_POST[dcuentas]);$x++)
						{
							$sqlr="insert into tesoegresos_det (id_egreso,vigencia,cuenta,fuente,valor,tipo_mov) values ('$_POST[egreso]','$_POST[vigencia]','".$_POST[dcuentas][$x]."','".$_POST[drecursos][$x]."','".$_POST[dvalores][$x]."','401')";	

							mysql_query($sqlr,$linkbd);
						}
					
						$sqlr="select * from comprobante_det where numerotipo=$_POST[egreso] and tipo_comp=6 and vigencia=$_POST[vigencia]";
						// echo $sqlr."<br>";
						$res=mysql_query($sqlr,$linkbd);
						while($row=mysql_fetch_row($res)){
							if($row[7]!=0){
								$sqlr1="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values ('$row[1]','$row[2]','$row[3]','$row[4]','REVERSADO','$row[6]',0,'$row[7]','$row[9]','$row[10]','$row[11]','$row[12]')";
								mysql_query($sqlr1,$linkbd);
								// echo $sqlr1."<br>";
							}
							if($row[8]!=0){
								$sqlr1="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values ('$row[1]','$row[2]','$row[3]','$row[4]','REVERSADO','$row[6]','$row[8]',0,'$row[9]','$row[10]','$row[11]','$row[12]')";
								mysql_query($sqlr1,$linkbd);
								// echo $sqlr1."<br>";
							}
						}
						$sqlr="select * from pptocomprobante_det where numerotipo=$_POST[egreso] and tipo_comp=11 and vigencia=$_POST[vigencia]";
						$res=mysql_query($sqlr,$linkbd);
						while($row=mysql_fetch_row($res)){
							if($row[4]!=0){
								$sqlr1="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia ,tipo_comp,numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values('$row[1]','$row[2]','$row[3]','0','$row[4]','2','$row[7]','$row[8]','$row[9]','401','$row[11]','','$row[13]')";
								mysql_query($sqlr1,$linkbd); 
								// echo $sqlr1."<br>";
							
								$sqlr1="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia ,tipo_comp,numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values('$row[1]','$row[2]','$row[3]','$row[4]','0','2','$row[7]','8','$_POST[orden]','401','$row[11]','$_POST[egreso]','$fechaf')";
								mysql_query($sqlr1,$linkbd);
								// echo $sqlr1."<br>";
							}
						}
						echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha reversado el Egreso con Exito <img src='imagenes\confirm.png'></center></td></tr></table><script>funcionmensaje();</script>";
					}
  					//****fin if bloqueo  
				}//************ FIN DE IF  	************
				//echo "<br>c: $gddesvalores[0]";
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