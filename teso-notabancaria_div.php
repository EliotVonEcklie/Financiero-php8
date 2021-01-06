
 <form name="form2" method="post" action=""> 
 
			<?php
				$vigencia=date(Y);
				$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
				$vigencia=$vigusu;
				if(!$_POST[oculto])
				{
					$_POST["idcomp"]="";
					$_POST["concepto"]="";
	 				$fec=date("d/m/Y");
	 				$_POST[fecha]=$fec; 		 		  			 
		 			$_POST[vigencia]=$vigusu; 		
					$sqlr="select max(id_notaban) from tesonotasbancarias_cab";
					$res=mysql_query($sqlr,$linkbd);
					$consec=0;
					while($r=mysql_fetch_row($res)){ $consec=$r[0];}
	 				$consec+=1;
	 				$_POST[idcomp]=$consec;		 
					$_POST[vigencia]=$vigusu;
			
//echo "oculto:".$_POST[oculto]." Elimina:".$_POST[elimina]."  agrega:".$_POST[agregadet];
	  $_POST[dccs]=array();
  	  $_POST[ddocban]=array();
	  $_POST[dcts]=array();
	  $_POST[dbancos]=array();
  	  $_POST[dgbancarios]=array();
	  $_POST[dngbancarios]=array();
	  $_POST[dnbancos]=array();
  	  $_POST[dcbs]=array();
	  $_POST[dvalores]=array();
	  $_POST[drps]=array();
	  $_POST[drubros]=array();
				}
			?>
  			<table class="inicio" align="center" >
      			<tr >
        			<td class="titulos" style="width:95%;" colspan="2"> Nota Bancaria </td>
         			<td  style="width:5%;"><label class="boton02" onClick="location.href='teso-principal.php'">Cerrar</label></td>
      			</tr>
      			<tr>
      				<td style="width:80%;">
      					<table>
      						<tr  >    
			        			<td style="width:12%;" class="saludo1" >Numero Comp:</td>
			        			<td style="width:20%" >
			        				<input type="text" name="idcomp" id="idcomp" style="width:30%" value="<?php echo $_POST[idcomp]?>" readonly>
			            			<input id="vigencia" name="vigencia" style="width:30%" type="text" value="<?php echo $_POST[vigencia] ?>" readonly>
			       				</td>
			        			<td style="width:5%;" class="saludo1">Fecha:</td>
			        			<td style="width:32%">
			        				<input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" style="width:20%" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">&nbsp;<a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>          
			       				</td>    
			        			<td style="width:23%"></td>
			   				</tr>
			    			<tr>
			        			<td style="width:12%;"class="saludo1">Concepto Nota:</td>
			       				<td colspan="3" >
			       					<input type="text" name="concepto" id="concepto" value="<?php echo $_POST[concepto]?>" style="width:100%" onKeyUp="return tabular(event,this)" >
									   <input id="conceptoh" name="conceptoh" type="hidden" value="<?php echo $_POST[conceptoh]?>" >
			       				</td>
							</tr>
			    			<tr>
			    				<td style="width:12%;"class="saludo1">Centro Costo:</td>
			        			<td style="width:20%;">
									<select name="cc" onChange="validar()" onKeyUp="return tabular(event,this)" style="width:100%">
										<?php
			                                $sqlr="select *from centrocosto where estado='S'";
			                                $res=mysql_query($sqlr,$linkbd);
			                                while ($row =mysql_fetch_row($res)){
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
			    			<tr>
				  				<td style="width:12%;"class="saludo1">Cuenta Bancaria:</td>
			                    <td style="width:20%;">
			                    	<input type='text' name='cb' id='cb' value="<?php echo $_POST[cb];?>" style='width:80%'/>&nbsp;
			                    	<a onClick="despliegamodal2('visible','1','');"  style='cursor:pointer;' title='Listado Cuentas Bancarias'>	
			                    		<img src='imagenes/find02.png' style='width:20px;'/>
			                    	</a>
			                    </td>
			                    <td colspan="2">
			        					<input type="text" id="nbanco" name="nbanco" value="<?php echo $_POST[nbanco]?>" style="width:100%" readonly>
			      				</td>
			                            <input type='hidden' name='banco' id='banco' value="<?php echo $_POST[banco];?>"/>
			                            <input type="hidden" id="ct" name="ct" value="<?php echo $_POST[ct]?>"/>
							</tr> 
							<tr>
				    			<td style="width:12%;" class="saludo1">Doc. Banco:</td>
			        			<td style="width:25%;">
			        				<input name="numero" type="text" value="<?php echo $_POST[numero]?>" style="width:100%" onKeyUp="return tabular(event,this)">        </td>
								<td style="width:12%;" class="saludo1">Gasto Bancario:</td>
			       				<td >
									<select name="gastobancario"  onChange="validar()" onKeyUp="return tabular(event,this)">
			                			<option value="">Seleccione ....</option>
			                			<?php
												$sqlr="select *from tesogastosbancarios where estado='S'";
												$res=mysql_query($sqlr,$linkbd);
												while ($row =mysql_fetch_row($res)){
													echo "<option value=$row[0] ";
													$i=$row[0];
										
													 if($i==$_POST[gastobancario])
														{
														 echo "SELECTED";
														 $_POST[ngastobancario]=$row[0]." - ".$row[2]." - ".$row[1];
														 }
													echo ">".$row[0]." - ".$row[2]." - ".$row[1]."</option>";	 	 
												}	 	
											?>
			   							</select>
			            				<input type="hidden" id="ngastobancario" name="ngastobancario" value="<?php echo $_POST[ngastobancario]?>" >
				 					</td>	 
			   				</tr>
			    			<tr>
								<td style="width:11%;" class="saludo1">Registro:</td>
									<td style="width:15%;">
										<input id="rp" name="rp" type="text" style="width:80%;" value="<?php echo $_POST[rp]?>"  onKeyUp="return tabular(event,this)" onBlur="cargarubroGB()" >
										<input type="hidden" value="0" name="brp">
										<a href="#" onClick="despliegamodal2('visible','2','<?php echo $_POST[vigencia]?>');">
										<img src="imagenes/buscarep.png" align="absmiddle" border="0">
										</a>
									</td>
									<td style="width:11%;" class="saludo1">Valor RP:</td>
	  									<td style="width:15%;">
	  										<input type="text" id="valorrp" name="valorrp" style="width:90%;" value="<?php echo $_POST[valorrp]?>" onKeyUp="return tabular(event,this)" readonly>
	  									</td>
									</td>	  										        
								</td>							
							</tr>
							<tr>
							<td style="width:11%;" class="saludo1">Rubro:</td>
							<td>
							<select id="rubros" name="rubros">
							</select>
							</td>
							</tr>
								<tr>
				   					<td style="width:12%;" class="saludo1">Valor:</td>
				   					<td style="width:20%;">
			        					<input type="text" id="valor" name="valor" value="<?php echo $_POST[valor]?>"  onKeyUp="return tabular(event,this)"> 
			                            <input type="hidden" name="vlvalor" id="vlvalor" onKeyUp="return tabular(event,this);" value="<?php echo $_POST[vlvalor]; ?>" style='text-align:right;width:60%;'/>
			                        </td>
			                        <td style="padding-bottom:4px">
									<em name="agregar" id="agregar" class="botonflecha" onClick="agregardetalle();">Agregar</em>
			            				
			            				<input type="hidden" value="0" name="agregadet">
			            				<input type="hidden" value="1" name="oculto" id="oculto"><input type="hidden" value="<?php echo $_POST[cuentacaja] ?>" name="cuentacaja">	
			       					</td>
			   					</tr> 
      					</table>
      				</td>
      				<td colspan="3" style="width:20%; background:url(imagenes/siglas.png); background-repeat:no-repeat; background-position:right; background-size: 100% 100%;" ></td>  
      			</tr>
			</table>
				<div class="subpantallac4" style="height:48.5%; width:99.6%; overflow-x:hidden;">
					<table class="inicio">
						<tr><td colspan="9" class="titulos">Detalle Gastos Bancarios</td></tr>                  
                        <tr>
                   			<td class="titulos2">CC</td>
                            <td class="titulos2">Doc Bancario</td>
                            <td class="titulos2">Cuenta Bancaria</td>
                            <td class="titulos2">Banco</td>
                            <td class="titulos2">Gasto Bancario</td>
                            <td class="titulos2">Valor</td>
							<td class="titulos2">RP / Compromiso</td>
							<td class="titulos2">Rubro Presupuesto</td>
                            <td class="titulos2"><img src="imagenes/del.png"><input type='hidden' name='elimina' id='elimina'></td>
                        </tr>
						<?php 		
							if ($_POST[elimina]!='')
							{ 
								$posi=$_POST[elimina];
		 						unset($_POST[dccs][$posi]);
								unset($_POST[ddocban][$posi]);
								unset($_POST[dbancos][$posi]);
								unset($_POST[dnbancos][$posi]);
								unset($_POST[dgbancarios][$posi]);	
								unset($_POST[dngbancarios][$posi]);		 
								unset($_POST[dcbs][$posi]);	
								unset($_POST[dcts][$posi]);			 
								unset($_POST[dvalores][$posi]);	
								unset($_POST[drps][$posi]);			 
								unset($_POST[drubros][$posi]);			  
								$_POST[dccs]= array_values($_POST[dccs]); 
								$_POST[ddocban]= array_values($_POST[ddocban]);  
								$_POST[dbancos]= array_values($_POST[dbancos]); 
								$_POST[dnbancos]= array_values($_POST[dnbancos]); 
								$_POST[dgbancarios]= array_values($_POST[dgbancarios]); 
								$_POST[dngbancarios]= array_values($_POST[dngbancarios]); 		 
								$_POST[dcbs]= array_values($_POST[dcbs]); 		 
								$_POST[dcts]= array_values($_POST[dcts]); 		 		 
								$_POST[dvalores]= array_values($_POST[dvalores]); 
								$_POST[drps]= array_values($_POST[drps]); 		 
								$_POST[drubros]= array_values($_POST[drubros]); 			 		 		 		 		 
		 					}	 
		 					if ($_POST[agregadet]=='1')
		 					{
								 
								$totsaldo=generaSaldoRPxcuenta($_POST[rp],$_POST[rubros],$_POST[vigencia]);
								//echo "saldo".$totsaldo;
								if($_POST[rp]!='' && $totsaldo<=$_POST[valor])
								{
									?>
									<script>
									//alert("error");
									swal('SPID','El valor del rubro excede el saldo disponiblle','error');
									</script>
									<?php
								}
								else
								{
									$_POST[dccs][]=$_POST[cc];
									$_POST[ddocban][]=$_POST[numero];			 
									$_POST[dbancos][]=$_POST[banco];		 
									$_POST[dnbancos][]=$_POST[nbanco];	
									$_POST[dgbancarios][]=$_POST[gastobancario];		
									$_POST[dngbancarios][]=$_POST[ngastobancario];				  
									$_POST[dcbs][]=$_POST[cb];
									$_POST[dcts][]=$_POST[ct];
									$_POST[dvalores][]=$_POST[valor];
									$_POST[drps][]=$_POST[rp];
									$_POST[drubros][]=$_POST[rubros];
									$_POST[agregadet]=0;
								}
		  					}
		  					$_POST[totalc]=0;
							$iter='saludo1a';
							$iter2='saludo2';
							$_POST[banban]=count($_POST[dbancos]);
							for ($x=0;$x<count($_POST[dbancos]);$x++)
							{		 
								echo"
								<input type='hidden' name='dccs[]' value='".$_POST[dccs][$x]."'/>
								<input type='hidden' name='ddocban[]' value='".$_POST[ddocban][$x]."'/>
								<input type='hidden' name='dcts[]' value='".$_POST[dcts][$x]."'/>
								<input type='hidden' name='dbancos[]' value='".$_POST[dbancos][$x]."'/>
								<input type='hidden' name='dcbs[]' value='".$_POST[dcbs][$x]."'>
								<input type='hidden' name='dnbancos[]' value='".$_POST[dnbancos][$x]."'/>
								<input type='hidden' name='dngbancarios[]' value='".$_POST[dngbancarios][$x]."'/>
								<input type='hidden' name='dgbancarios[]' value='".$_POST[dgbancarios][$x]."'/>
								<input type='hidden' name='dvalores[]' value='".$_POST[dvalores][$x]."'/>
								<input type='hidden' name='drps[]' value='".$_POST[drps][$x]."'/>
								<input type='hidden' name='drubros[]' value='".$_POST[drubros][$x]."'/>
								<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor; this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\">
		 							<td>".$_POST[dccs][$x]."</td>
									<td>".$_POST[ddocban][$x]."</td>
									<td>".$_POST[dcbs][$x]."</td>
									<td>".$_POST[dnbancos][$x]."</td>
									<td>".$_POST[dngbancarios][$x]."</td>
									<td>".$_POST[dvalores][$x]."</td>
									<td>".$_POST[drps][$x]."</td>
									<td>".$_POST[drubros][$x]."</td>
									<td class='saludo2'><a href='#' onclick='eliminar($x)'><img src='imagenes/del.png'></a></td>
								</tr>";
		 						$_POST[totalc]=$_POST[totalc]+$_POST[dvalores][$x];
								$_POST[totalcf]=number_format($_POST[totalc],2,".",",");
								$aux=$iter;
								$iter=$iter2;
								$iter2=$aux;
							}
 							$resultado = convertir($_POST[totalc]);
							$_POST[letras]=$resultado." Pesos";
							echo "
							<tr class='$iter' style='text-align:right;font-weight:bold;'>
								<td colspan='4'></td>
								<td>Total</td>
								<td>
									<input name='totalcf' type='hidden' value='$_POST[totalcf]'>
									<input name='totalc' type='hidden' value='$_POST[totalc]'>
									$_POST[totalcf]
								</td>
							</tr>
							<tr class='titulos2'>
								<td>Son:</td>
								<td colspan='8'>
									<input name='letras' type='hidden' value='$_POST[letras]' size='90'>
									$_POST[letras]
								</td>
							</tr>";
						?> 
	   				</table>
            	</div>
      			<input type="hidden" name="banban" id="banban" value="<?php echo $_POST[banban];?>"/>
	  			<?php
					if($_POST[oculto]=='2')
					{
						$p1=substr($_POST[fecha],0,2);
						$p2=substr($_POST[fecha],3,2);
						$p3=substr($_POST[fecha],6,4);
						$fechaf=$p3."-".$p2."-".$p1;	
						$bloq=bloqueos($_SESSION[cedulausu],$fechaf);	
						$bancotador=0;
						if($bloq>=1)
						{
 							ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
							$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
							$consec=0;
							$sqlr="insert into tesonotasbancarias_cab (id_comp,fecha,vigencia,estado,concepto,tipo_mov,user) values(0,'$fechaf',".$_POST[vigencia].",'S','".$_POST[concepto]."','201','".$_SESSION['nickusu']."')";	  
							mysql_query($sqlr,$linkbd);
							$idconsig=mysql_insert_id();
							$consec=$idconsig;
							//*********************CREACION DEL COMPROBANTE CONTABLE ***************************	
							//***busca el consecutivo del comprobante contable
							//***cabecera comprobante
	 						$sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($consec,9,'$fechaf','$_POST[concepto]',0,$_POST[totalc],$_POST[totalc],0,'1')";
							mysql_query($sqlr,$linkbd);
							$idcomp=mysql_insert_id();
							echo "<input type='hidden' name='ncomp' value='$idcomp'>";
							//******************* DETALLE DEL COMPROBANTE CONTABLE *********************
							for($x=0;$x<count($_POST[dbancos]);$x++)
	 						{	 
	 							//** Busca  Gastos Bancarios ****
								$sqlr="select tesogastosbancarios_det.*,tesogastosbancarios.tipo from tesogastosbancarios_det,tesogastosbancarios where tesogastosbancarios_det.tipoconce='GB' and tesogastosbancarios_det.modulo='4' and tesogastosbancarios_det.codigo='".$_POST[dgbancarios][$x]."' and tesogastosbancarios_det.estado='S' and tesogastosbancarios_det.vigencia='$_POST[vigencia]' and tesogastosbancarios_det.codigo=tesogastosbancarios.codigo";
								//	echo "$sqlr";
								$res=mysql_query($sqlr,$linkbd);
								while($r=mysql_fetch_row($res))
	 							{
									//******Busca el concepto contable de los gastos bancarios
									$sq="select fechainicial from conceptoscontables_det where codigo=".$r[2]." and modulo='4' and tipo='GB' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
									$re=mysql_query($sq,$linkbd);
									while($ro=mysql_fetch_assoc($re))
									{
										$_POST[fechacausa]=$ro["fechainicial"];
									}
									$sqlr="select * from conceptoscontables_det where conceptoscontables_det.codigo=".$r[2]." and conceptoscontables_det.tipo='GB' and conceptoscontables_det.modulo='4' and conceptoscontables_det.cc=".$_POST[dccs][$x]." and conceptoscontables_det.estado='S' and conceptoscontables_det.fechainicial='".$_POST[fechacausa]."'";
									$res2=mysql_query($sqlr,$linkbd);
									while($r2=mysql_fetch_row($res2))
	 								{
		 								if($r[8]=='G')//*****SI ES DE GASTO *****
		  								{
		 									if($r2[3]=='N')//**** NOTA  BANCARIA DETALLE CONTABLE*****
		   									{
												$sqlr2="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('9 $consec','$r2[4]','".$_POST[dcts][$x]."','".$_POST[dccs][$x]."','Doc Banco ".$_POST[ddocban][$x]."','',".$_POST[dvalores][$x].",0,'1','".$_POST[vigencia]."')";
												mysql_query($sqlr2,$linkbd);  
												$sqlr2="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('9 $consec','".$_POST[dbancos][$x]."','".$_POST[dcts][$x]."','".$_POST[dccs][$x]."','Doc Banco ".$_POST[ddocban][$x]."','',0,".$_POST[dvalores][$x].",'1','".$_POST[vigencia]."')";
												mysql_query($sqlr2,$linkbd);
												$sqlr="";
												if($_POST[drubros][$x]!='')
			  									{
													$sqlr="insert into pptonotasbanppto  (cuenta,idrecibo,valor,vigencia,rp) values ('".$_POST[drubros][$x]."',$consec,".$_POST[dvalores][$x].",'".$_POST[vigencia]."','".$_POST[drps][$x]."')";				
													mysql_query($sqlr,$linkbd);
													// echo $sqlr."<br>";
			 									}
		   									}
		  									if($r2[3]=='B')
		  									{
												//*** Cuenta BANCO **
												
		  									}
										}//*****FIN GASTO
		 								if($r[8]=='I')//*****SI ES DE INGRESO *****
		  								{
		  									if($r2[3]=='N')//**** NOTA  BANCARIA DETALLE CONTABLE*****
		   									{
												$sqlr2="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('9 $consec','".$r2[4]."','".$_POST[dcts][$x]."','".$_POST[dccs][$x]."','Doc Banco ".$_POST[ddocban][$x]."','',0,".$_POST[dvalores][$x].",'1','".$_POST[vigencia]."')";
												mysql_query($sqlr2,$linkbd);  
												$sqlr2="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('9 $consec','".$_POST[dbancos][$x]."','".$_POST[dcts][$x]."','".$_POST[dccs][$x]."','Doc Banco ".$_POST[ddocban][$x]."','',".$_POST[dvalores][$x].",0,'1','".$_POST[vigencia]."')";
												mysql_query($sqlr2,$linkbd);
												$sqlr="";
												if($r[5]!='')
			  									{
													$sqlr="insert into pptonotasbanppto  (cuenta,idrecibo,valor,vigencia,rp) values ('$r[5]',$consec,".$_POST[dvalores][$x].",'".$_POST[vigencia]."','".$_POST[drps][$x]."')";				
													mysql_query($sqlr,$linkbd);
													// echo $sqlr."<br>";
			  									}
		   									}
		  									if($r2[3]=='B')
		  									{
												//*** Cuenta BANCO **
												
		  									}
										}//*****FIN INGRESO	
	 								}
								}
							}	
							//************ insercion de cabecera consignaciones ************
							//************** insercion de consignaciones **************
							for($x=0;$x<count($_POST[dbancos]);$x++)
	 						{
								$sqlr="insert into tesonotasbancarias_det(id_notabancab,fecha,docban,cc,ncuentaban,tercero,gastoban,cheque,valor, estado,rp,rubro) values($idconsig,'$fechaf','".$_POST[ddocban][$x]."','".$_POST[dccs][$x]."','".$_POST[dcbs][$x]."','".$_POST[dcts][$x]."','".$_POST[dgbancarios][$x]."','',".$_POST[dvalores][$x].",'S','".$_POST[drps][$x]."','".$_POST[drubros][$x]."')";	  
								if (!mysql_query($sqlr,$linkbd))
								{
	 								echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petici�n: <br><font color=red><b>$sqlr</b></font></p>";
	 								echo "Ocurri� el siguiente problema:<br>";
  									echo "<pre>";
     								echo "</pre></center></td></tr></table>";
								}
  								else
  		 						{
		  							$bancotador=1;
		  						}
							}
							if($bancotador==1)
							{{echo "<script>despliegamodalm('visible','1','Se ha almacenado la Nota Bancaria con Exito');</script>";}}	  
 						} 
					}
				?>	
          	<script type="text/javascript">$('#concepto').alphanum({allow: '.-_:'});</script>
        	