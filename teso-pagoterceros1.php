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
        <script type="text/javascript" src="css/programas.js"></script>
        <script type="text/javascript" src="css/calendario.js"></script>
		<script>
			function validar(){document.form2.submit();}
			function agregardetalled()
			{
				if(document.form2.retencion.value!="")
				{ 
					document.form2.agregadetdes.value=1;
					document.form2.submit();
 				}
 				else {despliegamodalm('visible','2','Falta informacion para poder Agregar');}
			}
			function eliminard(variable)
			{
				document.form2.eliminad.value=variable;
				document.form2.submit();
			}
			function guardar()
			{
				if (document.form2.fecha.value!='' && document.form2.tercero.value!='' && document.form2.banco.value!='')
  				{
					despliegamodalm('visible','4','Esta Seguro de Guardar','2');
				}
  				else
				{
  					despliegamodalm('visible','2','Faltan datos para completar el registro');
  					document.form2.fecha.focus();
  					document.form2.fecha.select();
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
				document.form2.action="pdfpagoterceros.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function buscater(e)
 			{
				if (document.form2.tercero.value!="")
				{
 					document.form2.bt.value='1';
 					document.form2.submit();
 				}
 			}
			function despliegamodal2(_valor,scr)
			{
				//alert("Hola"+scr);
				if(scr=="1"){
					var url="cuentasbancarias-ventana02.php?tipoc=D&obj01=banco&obj02=nbanco&obj03=&obj04=cb&obj05=ter";
				}
				if(scr=="2"){
					var url="cuentasbancarias-ventana02.php?tipoc=C&obj01=banco&obj02=nbanco&obj03=&obj04=cb&obj05=ter";
				}
				if(scr=="3"){
					var url="tercerosgral-ventana01.php?objeto=tercero&nobjeto=ntercero&nfoco=cc";
				}
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden")
				{
					document.getElementById('ventana2').src="";
				}
				else 
				{
					document.getElementById('ventana2').src=url;
				}
			}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden")
				{
					document.getElementById('ventanam').src="";
					switch(document.getElementById('valfocus').value)
					{
						case "1":	document.getElementById('valfocus').value='';
									document.getElementById('tercero').focus();
									document.getElementById('tercero').select();
									break;
						case "2":	document.getElementById('valfocus').value='';
									document.getElementById('banco').value='';
									document.getElementById('banco').focus();
									document.getElementById('banco').select();
					}
				}
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
			function funcionmensaje()
			{
				var numdocar=document.getElementById('idcomp').value;
				document.location.href = "teso-editapagoterceros.php?idpago="+numdocar;
			}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.form2.oculto.value='3';
								document.form2.submit();
								break;
					case "2":	document.form2.oculto.value='2';
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
			<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("teso");?></tr>
			<tr>
  				<td colspan="3" class="cinta">
					<a onClick="location.href='teso-pagoterceros1.php'" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
					<a onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a>
					<a class="mgbt" onClick="location.href='teso-buscapagoterceros.php'" ><img src="imagenes/busca.png" title="Buscar"/></a>
					<a onClick="<?php echo paginasnuevas("teso");?>" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
					<a class="mgbt1"><img src="imagenes/printd.png" style="width:29px;height:25px;"/></a>
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
        	<input type="hidden" name="valfocus" id="valfocus" value=""/> 
			<?php
				$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
				//$_POST[vigencia]=$vigusu;
				$vigencia=$vigusu;
  				$vact=$vigencia;  
	 			$sqlr="select max(id_pago) from tesopagoterceros";
				$res=mysql_query($sqlr,$linkbd);
				$consec=0;
				while($r=mysql_fetch_row($res)){$consec=$r[0];}
	 			$consec+=1;
	 			$_POST[idcomp]=$consec;	
	  			//*********** cuenta origen va al credito y la destino al debito
				if(!$_POST[oculto])
				{
					$sqlr="select *from cuentapagar where estado='S' ";
					$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res)){$_POST[cuentapagar]=$row[1];}
					$sqlr="select valor_inicial from dominios where nombre_dominio='CUENTA_MILES'";
					$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res)){$_POST[cuentamiles]=$row[0];}
					$check1="checked";
 		 			$fec=date("d/m/Y");
		 			$_POST[fecha]=$fec; 		 		  			 
					//$_POST[valor]=0;
					//$_POST[valorcheque]=0;
					//$_POST[valorretencion]=0;
					//$_POST[valoregreso]=0;
					//$_POST[totaldes]=0;
		 			$_POST[vigencia]=$_POST[vigencias]; 		
		 			$sqlr="select max(id_pago) from tesopagoterceros";
					$res=mysql_query($sqlr,$linkbd);
					$consec=0;
					while($r=mysql_fetch_row($res)){$consec=$r[0];}
	 				$consec+=1;
	 				$_POST[idcomp]=$consec;		 
				}
 				$meses=array('','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
  				if($_POST[bt]=='1')
			 	{
			  		$nresul=buscatercero($_POST[tercero]);
			 		if($nresul!=''){$_POST[ntercero]=$nresul;}
			 		else {$_POST[ntercero]="";}
			 	}	
 			?>
	   		<table class="inicio" style="width:99.6%;">
	   			<tr>
	     			<td colspan="2"  style="width:95%;"class="titulos">Pago Terceros - Otros Pagos</td>
                    <td class="cerrar" style="width:5%;"><a onClick="location.href='teso-principal.php'">&nbsp;Cerrar</a></td>
             	</tr>
       			<tr>
       				<td style="width:80%;">
       					<table>
       						<tr> 
			                	<td class="saludo1" style="width:15%;">Numero Pago:</td>
			        			<td style="width:16%;">
			                    	<input type="hidden" name="cuentamiles" value="<?php echo $_POST[cuentamiles]?>" readonly>
			                        <input type="text" name="idcomp" id="idcomp" value="<?php echo $_POST[idcomp]?>" readonly>
			                  	</td>
				  				<td class="saludo1" style="width:2cm;">Fecha: </td>
			        			<td style="width:25%;">
								<input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" style="width:60%;">&nbsp;<a onClick="displayCalendarFor('fc_1198971545');" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px; cursor:pointer"></a></td>
				  				<td class="saludo1" style="width:10%;">Vigencia: </td>
			        			<td style="width:25%;"><input name="vigencia" type="text" style="width:20%;" value="<?php echo $_POST[vigencia]?>" maxlength="2"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly> </td>
				  				
			              	</tr>
			       			<tr>
			                	<td style="width:15%;" class="saludo1">Forma de Pago:</td>
			       				<td >
			       					<select name="tipop" onChange="validar();" style="width:100%;">
			       						<option value="">Seleccione ...</option>
							 			<option value="cheque" <?php if($_POST[tipop]=='cheque') echo "SELECTED"?>>Cheque</option>
			  				  			<option value="transferencia" <?php if($_POST[tipop]=='transferencia') echo "SELECTED"?>>Transferencia</option>
										<option value="caja" <?php if($_POST[tipop]=='caja') echo "SELECTED"?>>Caja</option>
							  		</select>
			          			</td>
			       				<td class="saludo1">Mes:</td>
			       				<td style="width:25%;">
			       					<select name="mes" onChange="validar()" style="width:55%;">
			       						<option value="">Seleccione ...</option>
			         					<?php
					   						for($x=1;$x<=12;$x++)
					    					{
					 							echo"<option value='$x'"; 
												if($_POST[mes]==$x) {echo " SELECTED>";}
												else {echo">";}
												echo "$meses[$x]</option>";
											}
					  					 ?>  
			          				</select> 
									<select name="vigencias" id="vigencias" onChange="validar()" style="width:40%;">
			      						<option value="">Sel..</option>
				  						<?php	  
			     							for($x=$vact;$x>=$vact-2;$x--)
				  							{
					 							if($x==$_POST[vigencias]){echo "<option value='$x' SELECTED>$x</option>";}
												else {echo "<option value='$x'>$x</option>";}
											}
				  						?>
			      					</select> 
			          			</td>           
			       			</tr>
			         		<?php 
								//**** if del cheques
								if($_POST[tipop]=='cheque')
								{
									// echo"    
									// <tr>
										// <td class='saludo1'>Cuenta Bancaria:</td>
										// <td >
											// <select id='banco' name='banco' onChange='validar()' onKeyUp='return tabular(event,this)' style='width:100%;'>
											// <option value=''>Seleccione....</option>";
									// $sqlr="select tesobancosctas.estado,tesobancosctas.cuenta,tesobancosctas.ncuentaban,tesobancosctas.tipo,terceros.razonsocial, tesobancosctas.tercero from tesobancosctas,terceros where tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.estado='S' ";
									// $res=mysql_query($sqlr,$linkbd);
									// while ($row =mysql_fetch_row($res)) 
									// {
										// if("$row[1]"==$_POST[banco])
										// {
											// echo "<option value='$row[1]' SELECTED>$row[2] - Cuenta $row[3]</option>";
											// $_POST[nbanco]=$row[4];
											// $_POST[ter]=$row[5];
											// $_POST[cb]=$row[2];
										 // }
									  // echo "<option value='$row[1]'>$row[2] - Cuenta $row[3]</option>";	 	 
									// }	
									// echo"</select>"; 
									echo "<tr>
					  				<td class='saludo1'>Cuenta :</td>
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
										<input type='text' id='ncheque' name='ncheque' value='$_POST[ncheque]' style='width:100%;'>
									</td>
										<input type='hidden' name='banco' id='banco' value='$_POST[banco]'/>
										<input type='hidden' id='ter' name='ter' value='$_POST[ter]'/>
									</tr>";
									$sqlr="select count(*) from tesochequeras where banco='$_POST[ter]' and cuentabancaria='$_POST[cb]' and estado='S' ";
									$res2=mysql_query($sqlr,$linkbd);
									$row2 =mysql_fetch_row($res2);
									if($row2[0]<=0 && $_POST[oculto]!='' && $_POST[banco]!='')
						  			{
						  				// echo "
									 	// <script>
											// document.getElementById('valfocus').value='2';
											// despliegamodalm('visible','2','No existe una chequera activa para esta Cuenta');
										// </script>";
						  				// $_POST[nbanco]="";
						  				// $_POST[ncheque]="";
						  			}
						 			else
						   			{
						    			$sqlr="select * from tesochequeras where banco='$_POST[ter]' and cuentabancaria='$_POST[cb]' and estado='S' ";
										$res2=mysql_query($sqlr,$linkbd);
										$row2 =mysql_fetch_row($res2);
										//$_POST[ncheque]=$row2[6];
						   			}
									// echo"
											// <input name='cb' type='hidden' value='$_POST[cb]'>
											// <input type='hidden' id='ter' name='ter' value='$_POST[ter]'>
										// </td>
										// <td colspan='2'><input type='text' id='nbanco' name='nbanco' value='$_POST[nbanco]' style='width:100%;' readonly></td>
										// <td class='saludo1'>Cheque:</td>
										// <td><input type='text' id='ncheque' name='ncheque' value='$_POST[ncheque]' style='width:100%;'></td>
					  				// </tr>";
									if($_POST[cb]!=''){
										$sqlc="select cheque from tesocheques where cuentabancaria='$_POST[cb]' and estado='S' order by cheque asc";
										//echo $sqlc;
										$resc = mysql_query($sqlc,$linkbd);
										$rowc =mysql_fetch_row($resc);
										//echo "cheque: ".$rowc[0];
										if($rowc[0]==''){
											// echo "<script>
													// document.form2.ncheque.value='';
													// despliegamodalm('visible','2','Esta cuenta no tiene chequera registrada');
													// document.form2.ncheque.disabled=true;
												// </script>";
										}else{
											echo "<script>document.form2.ncheque.value='".$rowc[0]."';</script>";
										}
									}	
				    			}//cierre del if de cheques
				  				//**** if del transferencias
				  				if($_POST[tipop]=='transferencia')
				    			{
				  					// echo"
			      					// <tr>
				  						// <td class='saludo1'>Cuenta Bancaria:</td>
				  						// <td>
				     						// <select id='banco' name='banco' onChange='validar()' onKeyUp='return tabular(event,this)' style='width:100%;'>
				      						// <option value=''>Seleccione....</option>";
									// $sqlr="select tesobancosctas.estado,tesobancosctas.cuenta,tesobancosctas.ncuentaban,tesobancosctas.tipo, terceros.razonsocial,tesobancosctas.tercero from tesobancosctas,terceros where tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.estado='S' ";
									// $res=mysql_query($sqlr,$linkbd);
									// while ($row =mysql_fetch_row($res)) 
							    	// {
								 		// if("$row[1]"==$_POST[banco])
						 				// {
											// echo "<option value='$row[1]' SELECTED>$row[2]- Cuenta $row[3]</option>";
									 		// $_POST[nbanco]=$row[4];
									  		// $_POST[ter]=$row[5];
									 		// $_POST[cb]=$row[2];
									 	// }
								  		// else {echo "<option value='$row[1]'>$row[2]- Cuenta $row[3]</option>";} 	 
									// }	 	
			            			// echo"</select>";
									echo "<tr>
					  				<td class='saludo1'>Cuenta :</td>
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
										<input type='text' id='ntransfe' name='ntransfe' value='$_POST[ntransfe]' style='width:100%;'>
									</td>
										<input type='hidden' name='banco' id='banco' value='$_POST[banco]'/>
										<input type='hidden' id='ter' name='ter' value='$_POST[ter]'/>
									</tr>";
									/*$sqlr="select count(*) from tesochequeras where banco=$_POST[ter] and cuentabancaria='$_POST[cb]' and estado='S' ";
									$res2=mysql_query($sqlr,$linkbd);
									$row2 =mysql_fetch_row($res2);
									if($row2[0]<=0 && $_POST[oculto]!='')
						  			{
						   				echo "<script>alert('No existe una chequera activa para esta Cuenta');document.form2.banco.value=''; document.form2.banco.focus();</script>";
						  				$_POST[nbanco]="";
						  				$_POST[ncheque]="";
						  			}
						  			else
						   			{
						    			$sqlr="select * from tesochequeras where banco=$_POST[ter] and cuentabancaria='$_POST[cb]' and estado='S' ";
										$res2=mysql_query($sqlr,$linkbd);
										$row2 =mysql_fetch_row($res2);
						   				$_POST[ncheque]=$row2[6];
						   			}*/
									// echo"
											// <input name='cb' type='hidden' value='$_POST[cb]'>
											// <input type='hidden' id='ter' name='ter' value='$_POST[ter]'>
										// </td>
										// <td colspan='2'><input type='text' id='nbanco' name='nbanco' value='$_POST[nbanco]' style='width:100%;' readonly></td>
										// <td class='saludo1'>No Transferencia:</td>
										// <td ><input type='text' id='ntransfe' name='ntransfe' value='$_POST[ntransfe]' style='width:100%;'></td>
				  					// </tr>";
				     			}//cierre del if de cheques  
								if($_POST[tipop]=='caja')
				    			{
				  					$sqlr="select cuentacaja from tesoparametros where estado='S'";
									$res=mysql_query($sqlr,$linkbd);
									$row =mysql_fetch_row($res);
									$_POST[banco]=$row[0];
									// echo $_POST[banco];
									
									echo "
										<input type='hidden' name='cb' id='cb' value='$_POST[cb]' style='width:80%;'/>
										<input type='hidden' id='nbanco' name='nbanco' style='width:100%;' value='$_POST[nbanco]'  readonly>
										<input type='hidden' id='ntransfe' name='ntransfe' value='$_POST[ntransfe]' style='width:100%;'>
										<input type='hidden' name='banco' id='banco' value='$_POST[banco]'/>
										<input type='hidden' id='ter' name='ter' value='$_POST[ter]'/>";
									
				     			}//cierre del if de cheques  
								
			      			?> 
							<tr> 
			      				<td style="width:15%;" class="saludo1">Tercero:</td>
			          			<td >
									<input type="text" name="tercero" id="tercero" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo $_POST[tercero]?>" style="width:80%;">&nbsp;
									<a onClick="despliegamodal2('visible','3');"><img src="imagenes/find02.png" style="width:20px;cursor:pointer;"></a>
								</td>
			          			<td colspan="2">
			                    	<input type="text" name="ntercero" id="ntercero" value="<?php echo $_POST[ntercero]?>" style="width:100%" readonly>
			                        <input type="hidden" value="0" name="bt">
			                   	</td>
			                 	<td style="width:10%;"  class="saludo1">Centro Costo:</td>
			                	<td style="width:20%;">
									<select name="cc" id="cc"  onChange="validar()" onKeyUp="return tabular(event,this)" style="width:100%;">
										<?php
											$sqlr="select *from centrocosto where estado='S'";
											$res=mysql_query($sqlr,$linkbd);
											while ($row =mysql_fetch_row($res)) 
							    			{
								 				if("$row[0]"==$_POST[cc]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
												else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
											}	 	
										?>
			   						</select>
				 				</td>
			     			</tr>
			          		<tr>
			        			<td style="width:15%;" class="saludo1">Concepto</td>
			                    <td colspan="3"><input type="text" name="concepto" value="<?php echo $_POST[concepto]?>" style="width:100%;"></td> 
			          	  		<td style="width:10%;" class="saludo1">Valor a Pagar:</td>
			                    <td style="width:20%;"><input name="valorpagar" type="text" id="valorpagar" onKeyUp="return tabular(event,this)" value="<?php echo round($_POST[valorpagar],0) ?>" style='text-align:right; width: 100%;' readonly></td>
			            	</tr>
			      			<tr>
			                	<td style="width:15%;" class="saludo1">Retenciones e Ingresos:</td>
								<td colspan="3">
									<select name="retencion"  onChange="validar()" onKeyUp="return tabular(event,this)" style="width:80%;">
										<option value="">Seleccione ...</option>
										<?php
											//PARA LA PARTE CONTABLE SE TOMA DEL DETALLE DE LA PARAMETRIZACION LAS CUENTAS QUE INICIAN EN 2********************	
											// $sqlr="SELECT TB3.* FROM tesoretenciones TB3 WHERE TB3.estado='S' AND TB3.terceros='1' AND TB3.id NOT IN(SELECT TB1.movimiento FROM tesopagoterceros_det TB1, tesopagoterceros TB2 WHERE TB1.id_pago=TB2.id_pago AND TB1.tipo='R' AND TB2.anos='$_POST[vigencias]' AND TB2.mes='$_POST[mes]')";
											// $res=mysql_query($sqlr,$linkbd);
											// while ($row =mysql_fetch_row($res)) 
							    			// {
								 				// if('R-'."$row[0]"==$_POST[retencion])
						 						// {	
									 				// echo "<option value='R-$row[0]' SELECTED>R - $row[1] - $row[2]</option>";
									  				// $_POST[nretencion]='R - '.$row[1]." - ".$row[2];
									 			// }
												// else{echo "<option value='R-$row[0]'>R - $row[1] - $row[2]</option>";}
											// }	
											// $sqlr="SELECT TB3.* FROM tesoingresos TB3 WHERE TB3.estado='S' AND TB3.terceros='1' AND TB3.codigo NOT IN(SELECT TB1.movimiento FROM tesopagoterceros_det TB1, tesopagoterceros TB2 WHERE TB1.id_pago=TB2.id_pago AND TB1.tipo='I' AND TB2.anos='$_POST[vigencias]' AND TB2.mes='$_POST[mes]')"; 
											// //$sqlr="select *from tesoingresos where estado='S' and terceros='1'";
											// $res=mysql_query($sqlr,$linkbd);
											// while ($row =mysql_fetch_row($res)) 
							   				// {
								 				// if('I-'."$row[0]"==$_POST[retencion])
						 						// {
									 				// echo "<option value='I-$row[0]' SELECTED>I - $row[1] - $row[2]</option>";
									 				// $_POST[nretencion]='I - '.$row[1]." - ".$row[2];
												// }
								 				// else{echo "<option value='I-$row[0]'>I - $row[1] - $row[2]</option>";}
											// }	 	
											//PARA LA PARTE CONTABLE SE TOMA DEL DETALLE DE LA PARAMETRIZACION LAS CUENTAS QUE INICIAN EN 2**********************	
											$linkbd=conectar_bd();
											$sqlr="select *from tesoretenciones where estado='S' and id='13' order by codigo";
											$res=mysql_query($sqlr,$linkbd);
											while ($row =mysql_fetch_row($res)) 
											{
												echo "<option value='R-$row[0]' ";
												$i=$row[0];
												if('R-'.$i==$_POST[retencion])
												{
													echo "SELECTED";
													$_POST[nretencion]='R - '.$row[1]." - ".$row[2];
												}
												echo ">R - ".$row[1]." - ".$row[2]."</option>";	
												$reten[]= 'R-'.$row[0]; 
												$nreten[]= 'R - '.$row[1]." - ".$row[2];
											}	 	
											$sqlr="select *from tesoingresos where estado='S' and terceros='1' order by codigo";
											$res=mysql_query($sqlr,$linkbd);
											while ($row =mysql_fetch_row($res)) 
											{
												echo "<option value='I-$row[0]' ";
												$i=$row[0];
												if('I-'.$i==$_POST[retencion])
												{
													echo "SELECTED";
													$_POST[nretencion]='I - '.$row[1]." - ".$row[2];
												}
												echo ">I - $row[0] - ".$row[1]." - ".$row[2]."</option>";	 	
												$reten[]= 'I-'.$row[0]; 
												$nreten[]= 'I - '.$row[1]." - ".$row[2]; 
											}	 	
										?>
			   						</select>&nbsp;&nbsp;
			                    	<input type="hidden" value="<?php echo $_POST[nretencion]?>" name="nretencion">
			                        <input type="hidden" value="1" name="oculto" id="oculto">
									<input type="button" name="agregard" id="agregard" value="   Agregar   " onClick="agregardetalled()" >
			                        <input type="hidden" value="0" name="agregadetdes"></td>
			        			<td style="width:10%;" class="saludo1">Ajuste Miles:&nbsp;
			        				<input type="checkbox" name="ajuste" id="ajuste"  value="1" onClick="document.form2.submit()" <?php  if($_POST[ajuste]==1) echo "checked"; ?> class="defaultcheckbox">
			        			</td>
			                    <td style="width:25%;">
			                    	<input name="valorpagarmil" type="text" id="valorpagarmil" onKeyUp="return tabular(event,this)" value="<?php echo round($_POST[valorpagarmil],0) ?>" style='text-align:right; width: 49%;' readonly>
			                    	<input name="diferencia" type="text" id="diferencia" onKeyUp="return tabular(event,this)" value="<?php echo round($_POST[diferencia],0) ?>" style='text-align:right; width: 49%;' readonly></td>
			          		</tr>
			                <?php if ($_POST[tipop]==''){
			                //echo"<tr style='height:20;'><tr>";
			                	}?>	
       					</table>
       				</td>
       				<td colspan="3" style="width:20%; background:url(imagenes/siglas.png); background-repeat:no-repeat; background-position:right; background-size: 100% 100%;" ></td>  
       			</tr>
      		</table>
			<div class="subpantallac3" style="height:22.5%; width:99.4%; overflow-x:hidden;">
       			<table class="inicio" style="overflow:scroll">
       				<?php 	
						if ($_POST[eliminad]!='')
		 				{ 
		 					$posi=$_POST[eliminad];
		 					unset($_POST[ddescuentos][$posi]);
							unset($_POST[dndescuentos][$posi]);
		 					$_POST[ddescuentos]= array_values($_POST[ddescuentos]); 
		 					$_POST[dndescuentos]= array_values($_POST[dndescuentos]); 
		 				}	 
		 				if ($_POST[agregadetdes]=='1')
		 				{
							if (!in_array($_POST[retencion], $_POST[ddescuentos])) 
							{
								$_POST[ddescuentos][]=$_POST[retencion];
								$_POST[dndescuentos][]=$_POST[nretencion];
								$_POST[agregadetdes]='0';
							}
							else {echo"<script>despliegamodalm('visible','2','La Retenci�n o Ingreso ya esta en la Lista');</script>";}
							echo"
							<script>
								document.form2.porcentaje.value=0;
								//document.form2.vporcentaje.value=0;	
								document.form2.retencion.value='';	
							</script>";
		 				}
		  			?>
        			<tr>
                    	<td class="titulos">Retenciones e Ingresos</td>
                        <td class="titulos2" style="width:8%;text-align:center;">Eliminar</td>
                  	</tr>
                    <input type='hidden' name='eliminad' id='eliminad'>
      				<?php
						$totaldes=0;
						$co="saludo1a";
		  				$co2="saludo2";
						for ($x=0;$x<count($_POST[ddescuentos]);$x++)
		 				{		 
		 					echo "
							<input type='hidden' name='dndescuentos[]' value='".$_POST[dndescuentos][$x]."'/>
							<input type='hidden' name='ddescuentos[]' value='".$_POST[ddescuentos][$x]."'/>
							<tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\">
								<td>".$_POST[dndescuentos][$x]."</td>
								<td style='text-align:center;'><a onclick='eliminard($x)'><img src='imagenes/del.png' style='cursor:pointer;'></a></td>
							</tr>";	
							$aux=$co;
							$co=$co2;
							$co2=$aux;
		 				}		 
						$_POST[valorretencion]=$totaldes;
						echo"
        				<script>
        					document.form2.totaldes.value='totaldes';		
       						document.form2.valorretencion.value='$totaldes';
        				</script>";
						$_POST[valorcheque]=$_POST[valoregreso]-$_POST[valorretencion];
					?>
        		</table>
         		<?php
           			//***** busca tercero
			 		if($_POST[bt]=='1')
			 		{
			 			$nresul=buscatercero($_POST[tercero]);
			  			if($nresul!='')
			   			{
			  				$_POST[ntercero]=$nresul;
  							echo" 
							<script>
			  					document.getElementById('retencion').focus();
								document.getElementById('retencion').select();
							</script>";
			  			}
			 			else
			 			{
			  				$_POST[ntercero]="";
			 				echo"
			  				<script>
								document.getElementById('valfocus').value='1';
								despliegamodalm('visible','2','Tercero Incorrecto o no Existe');
			  				</script>";
			 			}
			 		}
			 	?>     
			</div>        
	  		<div class="subpantallac" style="height:22.5%; width:99.4%; overflow-x:hidden;">
       			<table class="inicio" >
        			<tr>
                    	<td class="titulos">Retenciones / Ingresos</td>
                        <td class="titulos">Contabilidad</td>
                        <td class="titulos">Valor</td>
                  	</tr>        
      				<?php
						$_POST[mddescuentos]=array();
						$_POST[mtdescuentos]=array();		
						$_POST[mddesvalores]=array();
						$_POST[mddesvalores2]=array();		
						$_POST[mdndescuentos]=array();
						$_POST[mdctas]=array();		
						$totalpagar=0;
						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
						$fechaf1=$fecha[3]."-".$fecha[2]."-".$fecha[1];
						//**** buscar movimientos
						for ($x=0;$x<count($_POST[ddescuentos]);$x++)
		 				{	
		 					$tm=strlen($_POST[ddescuentos][$x]);
							//********** RETENCIONES *********
							if(substr($_POST[ddescuentos][$x],0,1)=='R')
		  					{
								$query="SELECT conta_pago FROM tesoparametros";
								$resultado=mysql_query($query,$linkbd);
								$arreglo=mysql_fetch_row($resultado);
								if(substr($_POST[ddescuentos][$x],2,$tm-2)=='34')
								{
									$sqlrete="SELECT SUM(valorretencion) FROM hum_retencionesfun WHERE tiporetencion='34' AND vigencia='$_POST[vigencias]' AND mes='$_POST[mes]' AND estadopago='N'";
									$resrete = mysql_query($sqlrete,$linkbd);
									$rowrete =mysql_fetch_row($resrete);
									$vpor=100;
									$_POST[mtdescuentos][]='R';
									$_POST[mddesvalores][]=$rowrete[0]*($vpor/100);
									$_POST[mddesvalores2][]=$rowrete[0]*($vpor/100);
									$_POST[mddescuentos][]=35;
									$_POST[mdctas][]=243615001;
									$_POST[mdndescuentos][]=buscaretencion(34);
									$totalpagar+=$rowrete[0]*($vpor/100);
								}
								$query="SELECT conta_pago FROM tesoparametros";
								$resultado=mysql_query($query,$linkbd);
								$arreglo=mysql_fetch_row($resultado);
								$opcion=$arreglo[0];
								if($opcion=='1')
								{
                                    $sqlr="select tesoordenpago_retenciones.id_retencion, sum(tesoordenpago_retenciones.valor),tesoordenpago.base,tesoordenpago.iva,tesoordenpago.id_orden from tesoordenpago, tesoordenpago_retenciones where MONTH(tesoordenpago.fecha)='$_POST[mes]' AND YEAR(tesoordenpago.fecha)='".$_POST[vigencias]."' and tesoordenpago_retenciones.id_retencion='".substr($_POST[ddescuentos][$x],2,$tm-2)."' and tesoordenpago.id_orden=tesoordenpago_retenciones.id_orden AND tesoordenpago.estado!='R' AND tesoordenpago.tipo_mov='201' order BY tesoordenpago.id_orden";
									$res=mysql_query($sqlr,$linkbd);		 
									while ($row =mysql_fetch_row($res)) 
									{
										$sqlr="select *from tesoretenciones_det where codigo='$row[0]' ORDER BY porcentaje ASC";
										//echo $sqlr;
										$res2=mysql_query($sqlr,$linkbd);
										$row2=mysql_fetch_row($res2);	
										//while($row2 =mysql_fetch_row($res2))
										//{
											$rest=substr($row2[6],-2);
											$sq="select fechainicial from conceptoscontables_det where codigo='$row2[4]' and modulo='$row2[5]' and tipo='$rest' and fechainicial<'$fechaf1' and cuenta!='' order by fechainicial asc";
											$re=mysql_query($sq,$linkbd);
											while($ro=mysql_fetch_assoc($re))
											{
												$_POST[fechacausa]=$ro["fechainicial"];
											}
											$sqlr="select * from conceptoscontables_det where codigo='$row2[4]' and modulo='$row2[5]' and tipo='$rest' and fechainicial='".$_POST[fechacausa]."'";
											$rst=mysql_query($sqlr,$linkbd);
											$row1=mysql_fetch_assoc($rst);
											if(substr($row1['cuenta'],0,1)==2)
											{ 
												$vpor=$row2[7];
												$_POST[mtdescuentos][]='R';
												$_POST[mddesvalores][]=$row[1]*($vpor/100);
												$_POST[mddesvalores2][]=$row[1]*($vpor/100);		   
												$_POST[mddescuentos][]=$row[0];
												$_POST[mdctas][]=$row1['cuenta'];		   
												$_POST[mdndescuentos][]=buscaretencion($row[0]);
												$totalpagar+=$row[1]*($vpor/100);
											}
										//}
									}
								}
								else
								{
									$sqlr="select tesoordenpago_retenciones.id_retencion, sum(tesoordenpago_retenciones.valor) from tesoordenpago, tesoordenpago_retenciones,tesoegresos where tesoegresos.id_orden=tesoordenpago.id_orden  and tesoegresos.estado='S' and MONTH(tesoegresos.fecha)='$_POST[mes]' and YEAR(tesoegresos.fecha)='".$_POST[vigencias]."' and tesoordenpago_retenciones.id_retencion='".substr($_POST[ddescuentos][$x],2,$tm-2)."' and tesoordenpago.id_orden=tesoordenpago_retenciones.id_orden AND tesoordenpago.tipo_mov='201' group by tesoordenpago_retenciones.id_retencion";
									//echo $sqlr;
									$res=mysql_query($sqlr,$linkbd);		 
									while ($row =mysql_fetch_row($res)) 
									{
										$sqlr="select *from tesoretenciones_det where codigo='$row[0]'";
										//echo $sqlr;
										$res2=mysql_query($sqlr,$linkbd);	
										while($row2 =mysql_fetch_row($res2))
										{
											$rest=substr($row2[6],-2);
											$sq="select fechainicial from conceptoscontables_det where codigo='$row2[4]' and modulo='$row2[5]' and tipo='$rest' and fechainicial<'$fechaf1' and cuenta!='' order by fechainicial asc";
											$re=mysql_query($sq,$linkbd);
											while($ro=mysql_fetch_assoc($re))
											{
												$_POST[fechacausa]=$ro["fechainicial"];
											}
											$sqlr="select * from conceptoscontables_det where codigo='$row2[4]' and modulo='$row2[5]' and tipo='$rest' and fechainicial='".$_POST[fechacausa]."'";
											$rst=mysql_query($sqlr,$linkbd);
											$row1=mysql_fetch_assoc($rst);
											if(substr($row1['cuenta'],0,1)==2)
											{ 
												$vpor=$row2[7];
												$_POST[mtdescuentos][]='R';
												$_POST[mddesvalores][]=$row[1]*($vpor/100);
												$_POST[mddesvalores2][]=$row[1]*($vpor/100);		   
												$_POST[mddescuentos][]=$row[0];
												$_POST[mdctas][]=$row1['cuenta'];		   
												$_POST[mdndescuentos][]=buscaretencion($row[0]);
												$totalpagar+=$row[1]*($vpor/100);
											}
										}
									}
								}
							}
							//****** INGRESOS *******
							
							if(substr($_POST[ddescuentos][$x],0,1)=='I')
		  					{
								
								//	$sqlr="select  tesorecaudos_det.ingreso, sum(tesorecaudos_det.valor), tesoreciboscaja.cuentabanco, tesoreciboscaja.cuentacaja from tesorecaudos, tesorecaudos_det,tesoreciboscaja where tesorecaudos.estado='P' and MONTH(tesoreciboscaja.fecha)='$_POST[mes]' and YEAR(tesoreciboscaja.fecha)='".$_POST[vigencias]."' and tesorecaudos_det.ingreso='".substr($_POST[ddescuentos][$x],2,$tm-2)."' and tesorecaudos.id_recaudo=tesorecaudos_det.id_recaudo and tesorecaudos.id_recaudo=tesoreciboscaja.id_recaudo and tesoreciboscaja.tipo=3";
								$sqlr="select tesoreciboscaja_det.ingreso, sum(tesoreciboscaja_det.valor), tesoreciboscaja.cuentabanco, tesoreciboscaja.cuentacaja from  tesoreciboscaja_det,tesoreciboscaja where tesoreciboscaja.estado='S' and MONTH(tesoreciboscaja.fecha)='$_POST[mes]' and YEAR(tesoreciboscaja.fecha)='".$_POST[vigencias]."' and tesoreciboscaja_det.ingreso='".substr($_POST[ddescuentos][$x],2,$tm-2)."' and tesoreciboscaja_det.id_recibos=tesoreciboscaja.id_recibos group by tesoreciboscaja_det.ingreso";
		                  		$res=mysql_query($sqlr,$linkbd);		 
								while ($row =mysql_fetch_row($res)) 
	    						{
		 							$sqlr="select * from  tesoingresos_det where codigo='$row[0]' and vigencia='$_POST[vigencias]'";
		  							$res2=mysql_query($sqlr,$linkbd);	
		  							while($row2 =mysql_fetch_row($res2))
		   							{
										$sq="select fechainicial from conceptoscontables_det where codigo='$row2[2]' and modulo='4' and tipo='C' and fechainicial<'$fechaf1' and cuenta!='' order by fechainicial asc";
										//echo $sq;
										$re=mysql_query($sq,$linkbd);
										while($ro=mysql_fetch_assoc($re))
										{
											$_POST[fechacausa]=$ro["fechainicial"];
										}
		   								$sqlr="select *from  conceptoscontables_det where codigo='$row2[2]' and modulo='4' and tipo='C' and fechainicial='".$_POST[fechacausa]."'";
		  								$res3=mysql_query($sqlr,$linkbd);	
		   								while($row3 =mysql_fetch_row($res3))
		   								{
		   									if(substr($row3[4],0,1)=='2')
		    								{
		   										$vpor=$row2[5];
		   										$_POST[mtdescuentos][]='I';
	   	   										$_POST[mddesvalores][]=$row[1]*($vpor/100);
		   										$_POST[mddesvalores2][]=$row[1]*($vpor/100);		   
												$_POST[mddescuentos][]=$row[0];
											   	$_POST[mdctas][]=$row3[4];
											   	$_POST[mdndescuentos][]=buscaingreso($row[0]);
											   	$totalpagar+=$row[1]*($vpor/100);		   
											   	//$nv=buscaingreso($row[0]);
											   	//echo "ing:$nv";
											}
		   								}
		  							}
		 						}
							}
							//****** RECAUDO TRANSFERENCIAS *******
							$sqlr="select tesorecaudotransferencia_det.ingreso, sum(tesorecaudotransferencia_det.valor), tesorecaudotransferencia.banco,tesorecaudotransferencia.ncuentaban from  tesorecaudotransferencia_det,tesorecaudotransferencia where tesorecaudotransferencia.estado='S' and MONTH(tesorecaudotransferencia.fecha)='$_POST[mes]' and YEAR(tesorecaudotransferencia.fecha)='".$_POST[vigencias]."' and tesorecaudotransferencia_det.ingreso='".substr($_POST[ddescuentos][$x],2,$tm-2)."' and tesorecaudotransferencia_det.id_recaudo=tesorecaudotransferencia.id_recaudo group by tesorecaudotransferencia_det.ingreso";
							
		 					$res=mysql_query($sqlr,$linkbd);		 
							while ($row =mysql_fetch_row($res)) 
	    					{
		 						$sqlr="select *from  tesoingresos_det where codigo='$row[0]' and vigencia='$_POST[vigencias]'";
		  						$res2=mysql_query($sqlr,$linkbd);	
		  						while($row2 =mysql_fetch_row($res2))
		   						{
									$sq="select fechainicial from conceptoscontables_det where codigo='$row2[2]' and modulo='4' and tipo='C' and fechainicial<'$fechaf1' and cuenta!='' order by fechainicial asc";
									//echo $sq;
									$re=mysql_query($sq,$linkbd);
									while($ro=mysql_fetch_assoc($re))
									{
										$_POST[fechacausa]=$ro["fechainicial"];
									}
		  							$sqlr="select *from  conceptoscontables_det where codigo='$row2[2]' and modulo='4' and tipo='C' and fechainicial='".$_POST[fechacausa]."'";
		  							$res3=mysql_query($sqlr,$linkbd);	
		   							while($row3 =mysql_fetch_row($res3))
		   							{
		   								if(substr($row3[4],0,1)=='2')
		    							{
									  		$vpor=$row2[5];
									   		$_POST[mtdescuentos][]='I';
									   		$_POST[mddesvalores][]=$row[1]*($vpor/100);
									   		$_POST[mddesvalores2][]=$row[1]*($vpor/100);		   
									   		$_POST[mddescuentos][]=$row[0];
		   									$_POST[mdctas][]=$row3[4];
		   									$_POST[mdndescuentos][]=buscaingreso($row[0]);
		   									$totalpagar+=$row[1]*($vpor/100);		   
		   									//$nv=buscaingreso($row[0]);
		   									//echo "ing:$nv";
										}
		  							}
		  						}
		 					}		
							//*****INGRESOS PROPIOS
		 					$sqlr="select tesosinreciboscaja_det.ingreso, sum(tesosinreciboscaja_det.valor),tesosinreciboscaja.cuentabanco, tesosinreciboscaja.cuentacaja from  tesosinreciboscaja_det,tesosinreciboscaja where tesosinreciboscaja.estado='S' and MONTH(tesosinreciboscaja.fecha)='$_POST[mes]' and YEAR(tesosinreciboscaja.fecha)='".$_POST[vigencias]."' and tesosinreciboscaja_det.ingreso='".substr($_POST[ddescuentos][$x],2,$tm-2)."' and tesosinreciboscaja_det.id_recibos=tesosinreciboscaja.id_recibos group by  tesosinreciboscaja_det.ingreso ";
		 					$res=mysql_query($sqlr,$linkbd);		 
							while ($row =mysql_fetch_row($res)) 
	    					{
								
		 						$sqlr="select *from  tesoingresos_det where codigo='$row[0]' and vigencia='$_POST[vigencias]'";
		  						$res2=mysql_query($sqlr,$linkbd);	
		  						//echo "$row[0] - ".$sqlr;
		  						while($row2 =mysql_fetch_row($res2))
		   						{
									$sq="select fechainicial from conceptoscontables_det where codigo='$row2[2]' and modulo='4' and tipo='C' and fechainicial<'$fechaf1' and cuenta!='' order by fechainicial asc";
									//echo $sq;
									$re=mysql_query($sq,$linkbd);
									while($ro=mysql_fetch_assoc($re))
									{
										$_POST[fechacausa]=$ro["fechainicial"];
									}
		   							$sqlr="select *from  conceptoscontables_det where codigo='$row2[2]' and modulo='4' and tipo='C' and fechainicial='".$_POST[fechacausa]."' group by cuenta";
		  							$res3=mysql_query($sqlr,$linkbd);	
		  							while($row3 =mysql_fetch_row($res3))
		   							{
		   								if(substr($row3[4],0,1)=='2')
		    							{
		   									$vpor=$row2[5];
		   									$_POST[mtdescuentos][]='I';
	   	   									$_POST[mddesvalores][]=$row[1]*($vpor/100);
		   									$_POST[mddesvalores2][]=$row[1]*($vpor/100);		   
		   									$_POST[mddescuentos][]=$row[0];
		   									$_POST[mdctas][]=$row3[4];
		   									$_POST[mdndescuentos][]=buscaingreso($row[0]);
		   									$totalpagar+=$row[1]*($vpor/100);		   
										}
		   							}
		  						}
		 					}
						}//********************************
						$co="saludo1a";
		  				$co2="saludo2";
						for ($x=0;$x<count($_POST[mddescuentos]);$x++)
		 				{		 
		 					echo "
							<input type='hidden' name='mdndescuentos[]' value='".$_POST[mdndescuentos][$x]."'/>
							<input type='hidden' name='mddescuentos[]' value='".$_POST[mddescuentos][$x]."'/>
							<input type='hidden' name='mtdescuentos[]' value='".$_POST[mtdescuentos][$x]."'/>
							<input type='hidden' name='mdctas[]' value='".$_POST[mdctas][$x]."'/>
							<input type='hidden' name='mddesvalores[]' value='".round($_POST[mddesvalores][$x],0)."'/>
							<input type='hidden' name='mddesvalores2[]' value='".number_format($_POST[mddesvalores2][$x],0)."'/>
							<tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\">
								<td>".$_POST[mdndescuentos][$x]."</td>
								<td>".$_POST[mdctas][$x]."</td>
								<td style='text-align:right;'>$ ".number_format($_POST[mddesvalores2][$x],0)."</td>
							</tr>";
							$aux=$co;
							$co=$co2;
							$co2=$aux;
		 				}		 
		 				$vmil=0;
						if($_POST[ajuste]=='1'){$vmil=round($totalpagar,-3);}
		  				else {$vmil=$totalpagar;}
						$resultado = convertir(round($vmil,0));
						$_POST[letras]=$resultado." PESOS M/CTE";
		 				echo "
						<input type='hidden' name='totalpago2' value='".round($totalpagar,0)."'/>
						<input type='hidden' name='totalpago' value='".number_format($totalpagar,0)."'/>
						<input type='hidden' name='letras' value='$_POST[letras]'/>
						<tr class='$co' style='text-align:right;'>
							<td colspan='2'>Total:</td>
							<td>$ ".number_format($totalpagar,0)."</td>
						</tr>
						<tr class='titulos2'><td colspan='3'>Son: $_POST[letras]</td>";
						$dif=$vmil-$totalpagar;
						echo"
        				<script>
       						document.form2.valorpagar.value='".round($totalpagar,0)."';	
        					document.form2.valorpagarmil.value='$vmil';	
							document.form2.diferencia.value='".round($dif,0)."';//calcularpago();
        				</script>";
					?>
        		</table>
	   		</div>
        	<?php	  
				if($_POST[oculto]=='2')
				{
					$sqlr="select max(tesopagoterceros.id_pago) from tesopagoterceros" ;
					$res=mysql_query($sqlr,$linkbd);
					while($r=mysql_fetch_row($res)){$consec=$r[0];}
	 				$consec+=1;
					$_POST[idcomp]=$consec;
					//**verificacion de guardado anteriormente *****
					$sqlr="select count(*) from tesopagoterceros where id_pago=$_POST[idcomp] ";
					$res=mysql_query($sqlr,$linkbd);
					$numerorecaudos=0;
					while($r=mysql_fetch_row($res)){$numerorecaudos=$r[0];}
					if($numerorecaudos==0)
	 				{
						$sqlr="update tesocheques set estado='P', destino='PAGO_TERCERO', idcomp='$_POST[idcomp]' where cuentabancaria='$_POST[cb]' and cheque='$_POST[ncheque]'";
		 				mysql_query($sqlr,$linkbd);
 						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
						$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	 					$sqlr="delete from comprobante_cab where tipo_comp=12 and numerotipo=$_POST[idcomp] ";
						mysql_query($sqlr,$linkbd);
						//************CREACION DEL COMPROBANTE CONTABLE ************************
						$sqlr="insert into tesopagoterceros (id_pago,tercero,banco,cheque,transferencia,valor,mes,concepto,cc,estado,fecha,ajuste, anos) values ($_POST[idcomp],'$_POST[tercero]','$_POST[banco]', '$_POST[ncheque]','$_POST[ntransfe]',$totalpagar,'$_POST[mes]','$_POST[concepto]', '$_POST[cc]','S','$fechaf', '$_POST[ajuste]','$_POST[vigencias]')";
						mysql_query($sqlr,$linkbd);
						//***busca el consecutivo del comprobante contable
						$sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($_POST[idcomp] ,12,'$fechaf','$_POST[concepto]',0,$totalpagar,$totalpagar,0,'1')";
						mysql_query($sqlr,$linkbd);
						for ($x=0;$x<count($_POST[mddescuentos]);$x++)
	 					{		
							$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado, vigencia) values ('12 $_POST[idcomp]','".$_POST[mdctas][$x]."','".$_POST[tercero]."','".$_POST[cc]."','PAGO RECAUDO A TERCERO MES ".$meses[$_POST[mes]]."','$_POST[ncheque]$_POST[ntransfe]',".$_POST[mddesvalores][$x].",0,'1','".$_POST[vigencias]."')";
							mysql_query($sqlr,$linkbd);  
		 					//*** Cuenta BANCO **
							$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado, vigencia) values ('12 $_POST[idcomp]','".$_POST[banco]."','".$_POST[tercero]."','".$_POST[cc]."','PAGO RECAUDO A TERCERO MES ".$meses[$_POST[mes]]."','$_POST[ncheque]$_POST[ntransfe]',0,".$_POST[mddesvalores][$x].",'1','".$_POST[vigencias]."')";
							mysql_query($sqlr,$linkbd);
							$sqlr="insert into tesopagoterceros_det(`id_pago`, `movimiento`, `tipo`, `valor`, `cuenta`, `estado`) values ($_POST[idcomp],'".$_POST[mddescuentos][$x]."','".$_POST[mtdescuentos][$x]."',".$_POST[mddesvalores][$x].",'".$_POST[mdctas][$x]."','S')";
							mysql_query($sqlr,$linkbd);					  
	  					}
	  					if($_POST[diferencia]<>0)
	 					{
		 					if($_POST[diferencia]>0)
		 					{
			 					$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado, vigencia) values ('12 $_POST[idcomp]','".$_POST[cuentamiles]."','".$_POST[tercero]."','".$_POST[cc]."','AJUSTE MIL PAGO RECAUDO A TERCERO MES ".$meses[$_POST[mes]]."','$_POST[ncheque]$_POST[ntransfe]',".$_POST[diferencia].",0,'1','".$_POST[vigencias]."')";
								mysql_query($sqlr,$linkbd);  
		 						//*** Cuenta BANCO **
								$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado, vigencia) values ('12 $_POST[idcomp]','".$_POST[banco]."','".$_POST[tercero]."','".$_POST[cc]."','AJUSTE MIL PAGO RECAUDO A TERCERO MES ".$meses[$_POST[mes]]."','$_POST[ncheque]$_POST[ntransfe]',0,".abs($_POST[diferencia]).",'1','".$_POST[vigencias]."')";
								mysql_query($sqlr,$linkbd);
		 					}
		 					if($_POST[diferencia]<0)
		 					{
								$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado, vigencia) values ('12 $_POST[idcomp]','".$_POST[cuentamiles]."','".$_POST[tercero]."','".$_POST[cc]."','AJUSTE MIL PAGO RECAUDO A TERCERO MES ".$meses[$_POST[mes]]."','$_POST[ncheque]$_POST[ntransfe]',0,".abs($_POST[diferencia]).",'1','".$_POST[vigencias]."')";
								mysql_query($sqlr,$linkbd);  
		 						//*** Cuenta BANCO **
								$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado, vigencia) values ('12 $_POST[idcomp]','".$_POST[banco]."','".$_POST[tercero]."','".$_POST[cc]."','AJUSTE MIL PAGO RECAUDO A TERCERO MES ".$meses[$_POST[mes]]."','$_POST[ncheque]$_POST[ntransfe]',".abs($_POST[diferencia]).",0,'1','".$_POST[vigencias]."')";
								mysql_query($sqlr,$linkbd); 
		 					}
						}
						echo"<script>despliegamodalm('visible','1','Se ha almacenado el Recaudo a Terceros con Exito');</script>";
	 				}//*** if de guardado
	 				else {echo"<script>despliegamodalm('visible','2',Ya Se ha almacenado un documento con ese consecutivo');</script>";}		
				}
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