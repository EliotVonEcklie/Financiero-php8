<?php //V 1000 12/12/16 ?> 
<?php
	require "comun.inc";
	require "funciones.inc";
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

		<script>
			//************* ver reporte ************
			//***************************************
			function verep(idfac)
			{
			  	document.form1.oculto.value=idfac;
			  	document.form1.submit();
			}
		
			//************* genera reporte ************
			//***************************************
			function genrep(idfac)
			{
			  	document.form2.oculto.value=idfac;
			  	document.form2.submit();
			}
		
			function buscacta(e)
			{
				if (document.form2.cuenta.value!="")
				{
				 	document.form2.bc.value='1';
				 	document.form2.submit();
				}
			}
			function validar(){
				var x = document.getElementById("tipomov").value;
				document.form2.movimiento.value=x;
				document.form2.submit();
			}
		
			function buscater(e)
			{
				if (document.form2.tercero.value!="")
				{
				 	document.form2.bt.value='1';
				 	document.form2.submit();
				}
			}
		
			function agregardetalle()
			{
				if(document.form2.codingreso.value!="" &&  document.form2.valor.value>0  )
				{ 
					document.form2.agregadet.value=1;
				//			document.form2.chacuerdo.value=2;
					document.form2.submit();
				}
				else {
				 	alert("Falta informacion para poder Agregar");
				}
			}
		
			function eliminar(variable)
			{
				if (confirm("Esta Seguro de Eliminar"))
				{
					document.form2.elimina.value=variable;
					//eli=document.getElementById(elimina);
					vvend=document.getElementById('elimina');
					//eli.value=elimina;
					vvend.value=variable;
					document.form2.submit();
				}
			}
		
			//************* genera reporte ************
			//***************************************
			function guardar()
			{
				ingresos2=document.getElementsByName('dcoding[]');
				if (document.form2.fecha.value!='' && ingresos2.length>0)
				{
					if (confirm("Esta Seguro de Guardar"))
				  	{
				  		document.form2.oculto.value=2;
				  		document.form2.submit();
				  	}
				}
				else{
				  	alert('Faltan datos para completar el registro');
				  	document.form2.fecha.focus();
				  	document.form2.fecha.select();
				}
			}
		
			function pdf()
			{
				document.form2.action="teso-pdfidentificar.php";
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
		
			function buscaing(e)
			{
				if (document.form2.codingreso.value!="")
				{
			 		document.form2.bin.value='1';
			 		document.form2.submit();
			 	}
			}

			function adelante()
			{
				//alert("Balance Descuadrado");
				//document.form2.oculto.value=2;
                //alert(document.form2.maximo.value);
				if(parseFloat(document.form2.idcomp.value)<parseFloat(document.form2.maximo.value))
				{
					//document.form2.oculto.value=1;
					//document.form2.agregadet.value='';
					//document.form2.elimina.value='';
					//document.form2.ncomp.value=parseFloat(document.form2.ncomp.value)+1;
                    
					document.form2.idcomp.value=parseFloat(document.form2.idcomp.value)+1;
					var idcta=document.form2.idcomp.value;
					document.form2.action="";
					location.href="teso-editaidentificar.php?idrecaudo="+idcta+"#";
				}
			}
			function atrasc()
			{
				//document.form2.oculto.value=2;
				if(document.form2.idcomp.value>1)
				{
					//document.form2.oculto.value=1;
					document.form2.idcomp.value=document.form2.idcomp.value-1;
					var idcta=document.form2.idcomp.value;
					location.href="teso-editaidentificar.php?idrecaudo="+idcta+"#";
				}
			}
			function iratras()
			{
				var idcta=document.getElementById('idcomp').value;
				location.href="teso-buscaidentificar.php?idcta="+idcta;
			}
		</script>
		<script src="css/programas.js"></script>
		<script src="css/calendario.js"></script>
		<link href="css/css2.css" rel="stylesheet" type="text/css" />
		<link href="css/css3.css" rel="stylesheet" type="text/css" />
		<link href="css/tabs.css" rel="stylesheet" type="text/css" />
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
		  			<a href="teso-identificar.php" class="mgbt"><img src="imagenes/add.png" alt="Nuevo"  border="0" title="Nuevo"/></a> 
		  			<a class="mgbt" onClick="guardar();"><img src="imagenes/guarda.png"  alt="Guardar" title="Guardar"/></a>
		  			<a href="teso-buscaidentificar.php" class="mgbt"><img src="imagenes/busca.png"  alt="Buscar" title="Buscar"/></a> 
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
		  			<a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana" title="Nueva ventana"></a> 
		  			<a href="#" onClick="pdf()" class="mgbt" ><img src="imagenes/print.png"  alt="Buscar" title="Imprimir"/></a>
		  			<a href="#" onClick="iratras()" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
		  		</td>
			</tr>		  
		</table>
			<tr>
				<td colspan="3" class="tablaprin" align="center"> 
					<?php
						$linkbd=conectar_bd();
						$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
						$vigencia=$vigusu;
						$_POST[vigencia]=$vigencia;
						$sqlr="select valor_inicial,descripcion_valor from dominios where nombre_dominio='INGRESOS_IDENTIFICAR'";
						$res=mysql_query($sqlr,$linkbd);
						while ($row =mysql_fetch_row($res)) 
						{
						 	$_POST[codingreso]=$row[0];
						 	$_POST[ningreso]=$row[1];
						}
					?>	
					<?php
						if(!$_POST[oculto])
						{

							$sqlr="select max(id) from  tesoidentificar";
							$res=mysql_query($sqlr,$linkbd);
							//echo $sqlr;
							$r=mysql_fetch_row($res);
                             $_POST[maximo]=$r[0];
                            
						}
						//*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
						if(!$_POST[oculto])
						{
							$check1="checked";
							$fec=date("d/m/Y");
							$_POST[vigencia]=$vigencia;

							$sqlr="select *from cuentacaja where estado='S' and vigencia=".$vigusu;
							$res=mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($res)) 
							{
							 $_POST[cuentacaja]=$row[1];
							}
							if(!$_POST[oculto])
							{
								$linkbd=conectar_bd();
                                $sqlr="select distinct *from tesoidentificar, tesoidentificar_det   where tesoidentificar.id=$_GET[idrecaudo]  AND tesoidentificar.id=tesoidentificar_det.id_identificar and tesoidentificar_det.id_identificar=$_GET[idrecaudo] and tesoidentificar_det.tipo_mov='201' and tesoidentificar.tipo_mov='201'";
                                if($_POST[movimiento]=='401')
                                {
                                    $sqlr="select distinct *from tesoidentificar, tesoidentificar_det   where tesoidentificar.id=$_GET[idrecaudo]  AND tesoidentificar.id=tesoidentificar_det.id_identificar and tesoidentificar_det.id_identificar=$_GET[idrecaudo] and tesoidentificar_det.tipo_mov='401' and tesoidentificar.tipo_mov='401'";
                                }
								$res=mysql_query($sqlr,$linkbd);
								$cont=0;
								$_POST[idcomp]=$_GET[idrecaudo];	
								$total=0;
								while ($row =mysql_fetch_row($res)) 
								{
									$p1=substr($row[2],0,4);
									$p2=substr($row[2],5,2);
									$p3=substr($row[2],8,2);
									$_POST[fecha]=$p3."/".$p2."/".$p1;	
									$_POST[cc]=$row[8];
									$_POST[dcoding][$cont]=$row[14];			 
									$_POST[banco]=$row[18];	
									$_POST[dnbanco]=buscatercero($row[4]);		 
									$_POST[dncoding][$cont]=buscaingreso($row[14]);
									$_POST[tercero]=$row[7];
                                    $_POST[ntercero]=buscatercero($row[7]);
                                    // $row[7]."<br>";
									$_POST[concepto]=$row[6];
									$total=$total+$row[15]; 
									$_POST[totalc]=$total;
									$_POST[dvalores][$cont]=$row[15];
									$cont=$cont+1;		
								}

								$sqlr="SELECT estado FROM `tesoidentificar` WHERE id=$_GET[idrecaudo]";
								$res=mysql_query($sqlr,$linkbd);		
								$row =mysql_fetch_row($res);
								if($row[0]!="R")
								{
									$_POST[estado]="ACTIVO";
									$_POST[estadoc]="#0CD02A";
								}
								else
								{
									$_POST[estado]="REVERSADO";
									$_POST[estadoc]="#FF0000";
								}
								

								$sqlr="select distinct *from tesoidentificar, tesoidentificar_det ,tesobancosctas   where	 tesobancosctas.ncuentaban= tesoidentificar.ncuentaban  and tesoidentificar.id=$_GET[idrecaudo]  AND tesoidentificar.id=tesoidentificar_det.id_identificar and tesoidentificar_det.id_identificar=$_GET[idrecaudo] and tesoidentificar.tipo_mov='201' and tesoidentificar_det.tipo_mov='201'";	
								$res=mysql_query($sqlr,$linkbd);
								//$cont=0;
								//echo $sqlr;
								//$_POST[idcomp]=$_GET[idrecaudo];	
								//$total=0;
								while ($row =mysql_fetch_row($res)) 
								{	/*$p1=substr($row[2],0,4);
									$p2=substr($row[2],5,2);
									$p3=substr($row[2],8,2);
									$_POST[fecha]=$p3."/".$p2."/".$p1;	
									$_POST[cc]=$row[8];
									$_POST[dcoding][$cont]=$row[13];			 */
									$_POST[banco]=$row[18];	
									$_POST[dnbanco]=buscatercero($row[4]);	
							/*		$_POST[dncoding][$cont]=buscaingreso($row[13]);
									$_POST[tercero]=$row[7];
									$_POST[ntercero]=buscatercero($row[7]);
									$_POST[concepto]=$row[6];
									$total=$total+$row[15]; 
									$_POST[totalc]=$total;
									$_POST[dvalores][$cont]=$row[14];
									$cont=$cont+1;		*/
								}		
							}		 
						}
						switch($_POST[tabgroup1])
						{
							case 1:
								$check1='checked';
							break;
							case 2:
								$check2='checked';
							break;
							case 3:
								$check3='checked';
						}
					?>
					<form name="form2" id="form2" method="post" action=""> 
					 	<?php
					 	//***** busca tercero
							if($_POST[bt]=='1')
							{
							  	$nresul=buscatercero($_POST[tercero]);
							  	if($nresul!='')
							   	{
							  		$_POST[ntercero]=$nresul;
					  			}
							 	else
							 	{
							  		$_POST[ntercero]="";
							  	}
							}
							//******** busca ingreso *****
							//***** busca tercero
							if($_POST[bin]=='1')
							{
								$nresul=buscaingreso($_POST[codingreso]);
								if($nresul!='')
								{
								 	$_POST[ningreso]=$nresul;
					  			}
								else
								{
								  	$_POST[ningreso]="";
								}
							}
								 
					 	?>
					 	<table class="inicio" align="center" >
					     	<tr>
						        <td style="width:95%;" class="titulos" colspan="2">Ingresos Identificados</td>
						        <td style="width:5%;" class="cerrar"><a href="teso-principal.php">Cerrar</a></td>
					      	</tr>
					      	<tr>
					      		<td style="width:80%;">
					      			<table>
					      				<tr>
									        <td style="width:15%; " class="saludo1">Numero Ingreso:</td>
									        <td style="width:20%;">
									        	<a href="#" onClick="atrasc()"><img src="imagenes/back.png" title="anterior" align="absmiddle"></a>
									        	<input name="idcomp" id="idcomp" type="text" value="<?php echo $_POST[idcomp]?>" style="width:70%;"onKeyUp="return tabular(event,this) "  readonly>
									        	<a href="#" onClick="adelante()"><img src="imagenes/next.png" title="siguiente" align="absmiddle"></a> 
									        	<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo">
									        </td>
									  		<td style="width:10%; " class="saludo1">Fecha:</td>
								        	<td style="width:20%;">
								        		<input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" style="width:60%;" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" readonly>
								        		         
								        	</td>
								         	<td style="width:10%;" class="saludo1">Vigencia:</td>
										 	<td style="width:10%;">
										 		<input type="text" id="vigencia" name="vigencia" onKeyPress="javascript:return solonumeros(event)"
										  		onKeyUp="return tabular(event,this)" style="width:40%;" value="<?php echo $_POST[vigencia]?>" onClick="document.getElementById('tipocta').focus();document.getElementById('tipocta').select();" readonly>   
										  	</td>   
										  	<td class="saludo1">Estado:</td>
										  	<td style="width:50%" >
								            	<input type="text" name="estado" value="<?php echo $_POST[estado] ?>" style="width:40%; background-color:<?php echo $_POST[estadoc] ?>; color:white; text-align:center;"  readonly>  
								                <input type="hidden" name="estadoc" value="<?php echo $_POST[estadoc] ?>">
												<select name="tipomov" id="tipomov" style="width:50%;" onKeyUp="return tabular(event,this)" onChange="validar()" style="float:right">
												<?php
													 $codMovimiento='201';
                                                     if(isset($_POST['movimiento'])){
                                                                  if(!empty($_POST['movimiento']))
                                                                      $codMovimiento=$_POST['movimiento'];
                                                              }
                                                      $sql="SELECT tipo_mov FROM tesoidentificar where id=$_POST[idcomp] ORDER BY tipo_mov";
                                     
                                                      $resultMov=mysql_query($sql,$linkbd);
                                                      $movimientos=Array();
                                                      $movimientos["201"]["nombre"]="201-Documento de Creacion";
                                                      $movimientos["201"]["estado"]="";
                                                      $movimientos["401"]["nombre"]="401-Reversion Total";
                                                      $movimientos["401"]["estado"]="";
                                                      while($row = mysql_fetch_row($resultMov)){
                                                          $mov=$movimientos[$row[0]]["nombre"];
                                                          $movimientos[$codMovimiento]["estado"]="selected";
                                                          $state=$movimientos[$row[0]]["estado"];
                                                          echo "<option value='$row[0]' $state>$mov</option>";
                                                      }
                                                      $movimientos[$codMovimiento]["estado"]="";
                                                      echo "<input type='hidden' id='movimiento' name='movimiento' value='$_POST[movimiento]' />";
												?>        
												</select>
												<input name="estado" type="hidden" id="estado" value="<?php echo $_POST[estado] ?>" >
											</td>
								        </tr>
								        <tr>
								         	<td class="saludo1">Recaudado:</td>
								         	<td colspan="3">
								         		<select id="banco" name="banco" onChange="validar()" onKeyUp="return tabular(event,this)" style="width:100%;" >
								         		<option value="">Seleccione....</option>
										  			<?php
														$linkbd=conectar_bd();
														$sqlr="select tesobancosctas.estado,tesobancosctas.cuenta,tesobancosctas.ncuentaban,tesobancosctas.tipo,terceros.razonsocial,tesobancosctas.tercero from tesobancosctas,terceros where tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.estado='S' ";
														$res=mysql_query($sqlr,$linkbd);
														while ($row =mysql_fetch_row($res)) 
														{
															echo "<option value=$row[1] ";
															$i=$row[1];
															$ncb=buscacuenta($row[1]);
															if($i==$_POST[banco])
															{
																echo "SELECTED";
																$_POST[nbanco]=$row[4];
																$_POST[ter]=$row[5];
																$_POST[cb]=$row[2];
															}
															echo ">".substr($ncb,0,70)." - Cuenta ".$row[3]."</option>";	 	 
														}	 	
													?>
								            	</select>
								       			<input name="cb" type="hidden" value="<?php echo $_POST[cb]?>" ><input type="hidden" id="ter" name="ter" value="<?php echo $_POST[ter]?>" >
								       		</td>
								       		<td colspan="4"> 
								       			<input type="text" id="nbanco" name="nbanco" value="<?php echo $_POST[nbanco]?>" style="width:100%;" readonly>
								       		</td>
								        </tr>
								      	<tr>
									        <td  class="saludo1">Concepto Recaudo:</td>
									        <td colspan="7" >
									        	<input name="concepto" type="text" value="<?php echo $_POST[concepto]?>" style="width:100%;"  onKeyUp="return tabular(event,this)" readonly>
									        </td>
									    </tr>  
								      	<tr>
									        <td  class="saludo1">NIT: </td>
									        <td >
									        	<input name="tercero" type="text" value="<?php echo $_POST[tercero]?>"  onKeyUp="return tabular(event,this)" onBlur="buscater(event)" readonly>
									        	
									        </td>
											<td class="saludo1">Contribuyente:</td>
									  		<td colspan="5" style="width:25%;">
									  			<input type="text" id="ntercero" name="ntercero" value="<?php echo $_POST[ntercero]?>" style="width:100%" onKeyUp="return tabular(event,this) "  readonly>
									  			<input type="hidden" value="0" name="bt">
									  			<input type="hidden" id="cb" name="cb" value="<?php echo $_POST[cb]?>" >
									  			<input type="hidden" id="ct" name="ct" value="<?php echo $_POST[ct]?>" >
									  			<input type="hidden" value="1" name="oculto">
									  		</td>
									  		
									 	</tr>
									  	<tr>
									  		<td class="saludo1">Ingreso:</td>
									  		<td style="width:60%;" colspan="3">
									  			<input type="text" id="codingreso" name="codingreso" value="<?php echo $_POST[codingreso]?>" style="width:14%;"  onKeyUp="return tabular(event,this)" onBlur="buscaing(event)" readonly > 
											    <input type="hidden" value="0" name="bin" >
											    <input name="ningreso" type="text" id="ningreso" value="<?php echo $_POST[ningreso]?>" style="width:85%;" readonly>
									    	</td>
									    	<td class="saludo1">Centro Costo:</td>
									  		<td colspan="4">
												<select name="cc"  onChange="validar()" onKeyUp="return tabular(event,this)">
												<?php
													$linkbd=conectar_bd();
													$sqlr="select *from centrocosto where estado='S'";
													$res=mysql_query($sqlr,$linkbd);
													while ($row =mysql_fetch_row($res)) 
													{
														echo "<option value=$row[0] ";
														$i=$row[0];
														if($i==$_POST[cc])
														{
															echo "SELECTED";
														}
														echo ">".$row[0]." - ".$row[1]."</option>";	 	 
													}	 	
												?>
											   </select>
											</td>
											
											
											
								        </tr>
					      			</table>
					      		</td>
					      		<td  colspan="2" style="width:20%; background:url(imagenes/siglas.png); background-repeat:no-repeat; background-position:right; background-size: 100% 100%;" ></td> 
					      	</tr>
					</table>
					     <?php
					        //***** busca tercero
							if($_POST[bt]=='1')
							{
								$nresul=buscatercero($_POST[tercero]);
								if($nresul!='')
								{
								  	$_POST[ntercero]=$nresul;
					  	?>
						<script>document.getElementById('codingreso').focus();document.getElementById('codingreso').select();</script>
						<?php
								}
								else
								{
								  	$_POST[ntercero]="";
						?>
						<script>
							alert("Tercero Incorrecto o no Existe")				   		  	
							document.form2.tercero.focus();	
						</script>
						<?php
								}
							}
								 //*** ingreso
							if($_POST[bin]=='1')
							{
								$nresul=buscaingreso($_POST[codingreso]);
								if($nresul!='')
								{
								  	$_POST[ningreso]=$nresul;
					  	?>
						<script>document.getElementById('valor').focus();document.getElementById('valor').select();</script>
						<?php
								}
								else
								{
								  	$_POST[codingreso]="";
						?>
						<script>alert("Codigo Ingresos Incorrecto");document.form2.codingreso.focus();</script>
						<?php
								}
							}
						?>
					      
					    <div class="subpantalla" style="height:46%">
						   	<table class="inicio">
						   	   	<tr>
					   	      		<td colspan="3" class="titulos">Detalle Identificados</td>
					   	      	</tr>  
								<tr>
									<td class="titulos2">Codigo</td>
									<td class="titulos2">Ingreso</td>
									<td class="titulos2">Valor</td>
								</tr>
								<?php 		
									if ($_POST[elimina]!='')
								 	{ 
								 		//echo "<TR><TD>ENTROS :".$_POST[elimina]."</TD></TR>";
								 		$posi=$_POST[elimina];
								  
								 		unset($_POST[dcoding][$posi]);	
								 		unset($_POST[dncoding][$posi]);			 
										unset($_POST[dvalores][$posi]);			  		 
										$_POST[dcoding]= array_values($_POST[dcoding]); 		 
										$_POST[dncoding]= array_values($_POST[dncoding]); 		 		 
										$_POST[dvalores]= array_values($_POST[dvalores]); 		 		 		 		 		 
								 	}	 
								 	if ($_POST[agregadet]=='1' )
								 	{
								 		$_POST[dcoding][]=$_POST[codingreso];
								 		$_POST[dncoding][]=$_POST[ningreso];			 		
								  		$_POST[dvalores][]=$_POST[valor];
								 		$_POST[agregadet]=0;
								  	?>
									<script>
									  	//document.form2.cuenta.focus();	
										document.form2.valor.value="";	
										document.form2.valor.select();
									  	document.form2.valor.focus();	
									</script>
							         
					         		<?php
							  		}
									$_POST[totalc]=0;
									for ($x=0;$x<count($_POST[dcoding]);$x++)
									{		 
									 	echo "<tr>
									 			<td class='saludo1' style='width:8%;'>
									 				<input name='dcoding[]' value='".$_POST[dcoding][$x]."' type='text' style='width:100%;' readonly>
									 			</td>
									 			<td class='saludo1' style='width:70%;'>
									 				<input name='dncoding[]' value='".$_POST[dncoding][$x]."' type='text' style='width:100%;' readonly>
									 			</td>
									 			<td class='saludo1' style='width:20%;'>
									 				<input name='dvalores[]' value='".$_POST[dvalores][$x]."' type='text' style='width:100%;' readonly>
									 			</td>
									 			
									 		</tr>";
									 	$_POST[totalc]=$_POST[totalc]+$_POST[dvalores][$x];
									 	$_POST[totalcf]=number_format($_POST[totalc],2);
									}
					 				$resultado = convertir($_POST[totalc]);
									$_POST[letras]=$resultado." Pesos";
							 		echo "<tr>
							 				<td></td>
							 				<td class='saludo2'>Total</td>
							 				<td class='saludo1'>
							 					<input name='totalcf' type='text' style='width:100%;' value='$_POST[totalcf]' readonly>
							 					<input name='totalc' type='hidden' value='$_POST[totalc]'>
							 				</td>
							 			</tr>
							 			<tr>
							 				<td class='saludo1'>Son:</td>
							 				<td >
							 					<input name='letras' type='text' value='$_POST[letras]' style='width:100%;' readonly>
							 				</td>
							 			</tr>";
								?> 
						   	</table>
						</div>
						<?php
							if($_POST[oculto]=='2')
							{
									 
							}
						?>
					</form>
				</td>
			</tr>
		</table>
	</body>
</html> 		