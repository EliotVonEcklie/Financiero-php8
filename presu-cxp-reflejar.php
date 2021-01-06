<?php //V 1001 20/12/16 Modificado implementacion de Reversion?> 
<?php //V 1000 12/12/16 ?> 
<!--V 1.0 24/02/2015-->
<?php
	require"comun.inc";
	require"funciones.inc";
	require"validaciones.inc";
	require "conversor.php";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
 	$linkbd=conectar_bd();
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: SPID - Presupuesto</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <link href="css/tabs.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
        <script type="text/javascript" src="css/calendario.js"></script>
		<script>
			function buscacta(e){if (document.form2.cuenta.value!=""){document.form2.bc.value='1';document.form2.submit();}}
			function validar(){document.form2.submit();}
			function buscarp(e){if (document.form2.rp.value!=""){document.form2.brp.value='1';document.form2.submit();}}
			function agregardetalle()
			{
				if(document.form2.numero.value!="" &&  document.form2.valor.value>0 &&  document.form2.banco.value!=""  )
				{ 
					document.form2.agregadet.value=1;
					//document.form2.chacuerdo.value=2;
					document.form2.submit();
				}
				else {alert("Falta informacion para poder Agregar");}
			}
			function agregardetalled()
			{
				if(document.form2.retencion.value!="" &&  document.form2.vporcentaje.value!=""  )
				{ 
					document.form2.agregadetdes.value=1;
					//document.form2.chacuerdo.value=2;
					document.form2.submit();
				}
				else {alert("Falta informacion para poder Agregar");}
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
			function eliminard(variable)
			{
				if (confirm("Esta Seguro de Eliminar"))
				{
					document.form2.eliminad.value=variable;
					//eli=document.getElementById(elimina);
					vvend=document.getElementById('eliminad');
					//eli.value=elimina;
					vvend.value=variable;
					document.form2.submit();
				}
			}
			function guardar()
			{
				if (document.form2.fecha.value!='')
					{if (confirm("Esta Seguro de Guardar")){document.form2.oculto.value=2;document.form2.submit();}}
				else
				{
					alert('Faltan datos para completar el registro');
					document.form2.fecha.focus();
					document.form2.fecha.select();
				}
			}
			function calcularpago()
			 {
				//alert("dddadadad");
				valorp=document.form2.valor.value;
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
			function adelante()
			{
				if(parseFloat(document.form2.ncomp.value)<parseFloat(document.form2.maximo.value))
				{
					document.form2.oculto.value=1;
					document.form2.ncomp.value=parseFloat(document.form2.ncomp.value)+1;
					document.form2.idcomp.value=parseFloat(document.form2.idcomp.value)+1;
					var idcta=document.getElementById('idcomp').value;
					document.form2.action="presu-cxp-reflejar.php?idcta="+idcta;
					document.form2.submit();
				}
			}
			function atrasc()
			{
				if(document.form2.ncomp.value>1)
				{
					document.form2.oculto.value=1;
					document.form2.ncomp.value=document.form2.ncomp.value-1;
					document.form2.idcomp.value=document.form2.idcomp.value-1;
					var idcta=document.getElementById('idcomp').value;
					document.form2.action="presu-cxp-reflejar.php?idop="+idcta;
					document.form2.submit();
				}
			}
			function iratras()
			{
				var idcta=document.getElementById('idcomp').value;
				location.href="teso-buscaegreso.php?idcta="+idop+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
        <?php $numpag=$_GET[numpag];$limreg=$_GET[limreg];$scrtop=27*$totreg;?>
		<table>
			<tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("presu");?></tr>
			<tr>
  				<td colspan="3" class="cinta">
					<a class="mgbt" href="#" >
						<img src="imagenes/add2.png" alt="Nuevo"  border="0" />
					</a> 
					<a class="mgbt" href="#" onClick="#">
						<img src="imagenes/guardad.png"  alt="Guardar" />
					</a> 
					<a class="mgbt" href="presu-rpver-reflejar.php"> 
						<img src="imagenes/busca.png"  alt="Buscar" />
					</a> 
					<a class="mgbt" href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();">
						<img src="imagenes/nv.png" alt="nueva ventana">
					</a> 
					<a class="mgbt" href="#" onClick="guardar()">
						<img src="imagenes/reflejar1.png"  alt="Reflejar" style="width:24px;" />
					</a> 
					<a class="mgbt" href="#"onClick="pdf()"> 
						<img src="imagenes/print.png"  alt="Buscar" />
					</a> 
					<a class="mgbt" href="presu-reflejardocs.php">
						<img src="imagenes/iratras.png" alt="nueva ventana">
					</a>
				</td>
			</tr>		  
		</table>
        <form name="form2" method="post" action=""> 
			<?php
                $vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
                $vigencia=$vigusu;
                //*********** cuenta origen va al credito y la destino al debito
                if($_GET[idopc]!=""){echo "<script>document.getElementById('codrec').value=$_GET[idop];</script>";}
                if(!$_POST[oculto])
                {
                    $sqlr="select *from cuentapagar where estado='S' ";
                    $res=mysql_query($sqlr,$linkbd);
                    while ($row =mysql_fetch_row($res)){
						$_POST[cuentapagar]=$row[1];
					}
                    $sqlr="select * from tesoordenpago ORDER BY id_orden DESC";
                    $res=mysql_query($sqlr,$linkbd);
                    $r=mysql_fetch_row($res);
                    $_POST[maximo]=$r[0];
					$_POST[codreg]=$r[0];
                    if ($_POST[codrec]!="" || $_GET[idop]!="")
                    {
                        if($_POST[codrec]!="")
						{
							$sqlr="select * from tesoordenpago where id_orden='$_POST[codrec]'";
						}
                        else
						{
							$sqlr="select * from tesoordenpago where id_orden='$_GET[idop]'";
						}
                    }
                    else{$sqlr="select * from tesoordenpago ORDER BY id_orden DESC";}
                    $res=mysql_query($sqlr,$linkbd);
                    $r=mysql_fetch_row($res);
                    $_POST[ncomp]=$r[0];
                    $_POST[idcomp]=$r[0];	
                    $_POST[vigencia]=$r[3]; 		
                    $check1="checked"; 
                    $fec=date("d/m/Y");
                }
                // $_POST[fecha]=$fec; 		 		  			 
                //$_POST[valor]=0;
                //$_POST[valorcheque]=0;
                //$_POST[valorretencion]=0;
                //$_POST[valoregreso]=0;
                //$_POST[totaldes]=0;
                $sqlr="select * from tesoordenpago where id_orden=".$_POST[ncomp];
                $res=mysql_query($sqlr,$linkbd);
                $consec=0;
                while($r=mysql_fetch_row($res))
                {
                    $_POST[fecha]=$r[2];
                    $_POST[compcont]=$r[1];
                    $consec=$r[0];	  
                    $_POST[rp]=$r[4];
                    $_POST[estado]=$r[13];                    
                    $_POST[estadoc]=$r[3];
                }
                ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
                $fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
                $_POST[fecha]=$fechaf;
                switch($_POST[tabgroup1])
                {
                    case 1:	$check1='checked';break;
                    case 2:	$check2='checked';break;
                    case 3:	$check3='checked';
                }
				if($_POST[oculto]!='2')
				{
					$sqlr="select * from tesoordenpago where id_orden=$_POST[idcomp] ";
					$res=mysql_query($sqlr,$linkbd);
					while($r=mysql_fetch_row($res))
					{
	 					$_POST[fecha]=$r[2];
	  					$_POST[idcomp]=$r[0];
	 					ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
						$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
	 					$_POST[fecha]=$fechaf;	
	 					$_POST[rp]=$r[4];
	 					$_POST[base]=$r[14];
	 					$_POST[iva]=$r[15];
	 		 			$_POST[vigencia]=$r[3]; 		
	 		 			$_POST[estado]=$r[13];
			  		  	$_POST[estadoc]=$r[13];
					}
			 		$nresul=buscaregistro($_POST[rp],$_POST[vigencia]);
			  		$_POST[cdp]=$nresul;
			  		//*** busca detalle cdp
  					$sqlr="select pptorp.vigencia,pptorp.consvigencia,pptocdp.objeto,pptorp.estado,pptocdp.consvigencia,pptorp.valor,pptorp.saldo, pptorp.tercero,pptocdp.objeto from pptorp, pptocdp where pptorp.estado='S' and pptocdp.consvigencia=$_POST[cdp] and pptorp.idcdp=pptocdp.consvigencia and pptorp.consvigencia=".$_POST[rp]." and pptorp.vigencia=$_POST[vigencia] and pptorp.idcdp=pptocdp.consvigencia and pptocdp.vigencia=$_POST[vigencia] order by pptorp.vigencia,pptorp.consvigencia,pptocdp.objeto,pptorp.estado";
					$resp = mysql_query($sqlr,$linkbd);
					$row =mysql_fetch_row($resp);
					$_POST[detallecdp]=$row[2];
					$sqlr="Select *from tesoordenpago where id_orden=".$_POST[idcomp];
					$resp = mysql_query($sqlr,$linkbd);
					$row =mysql_fetch_row($resp);
					$_POST[tercero]=$row[6];
					$_POST[ntercero]=buscatercero($_POST[tercero]);
					$_POST[valorrp]=$row[8];
					$_POST[saldorp]=$row[9];
					//$_POST[cdp]=$row[4];
					$_POST[valor]=$row[10];				
					$_POST[cc]=$row[5];				
					$_POST[detallegreso]=$row[7];
					$_POST[valoregreso]=$_POST[valor];
					$_POST[valorretencion]=$row[12];
					$_POST[valorcheque]=$_POST[valoregreso]-$_POST[valorretencion];
					$_POST[base]=$row[14];
					$_POST[iva]=$row[15];
					//$_POST[valorcheque]=number_format($_POST[valorcheque],2);
				}
 			?>
			<?php
		//echo count($_POST[dcuentas]);
			
			?>	
 			<div class="tabs">
   				<div class="tab">
       				<input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
	   				<label for="tab-1">Liquidacion CxP</label>
	   				<div class="content" style="overflow-x:hidden;">
    					<table class="inicio" align="center" >
      						<tr >
       							<td class="titulos" colspan="7" >Liquidacion CxP</td>
                                <td class="cerrar" style='width:7%'><a href="teso-principal.php">&nbsp;Cerrar</a></td>
      						</tr>
      						<tr>
								<td class="saludo1" style="width:2.6cm;">Numero CxP:</td>
        						<td style="width:20%;"> 
        							<a href="#" onClick="atrasc()"><img src="imagenes/back.png" title="anterior" align="absmiddle"></a>
            						<input type="text" id="idcomp" name="idcomp" value="<?php echo $_POST[idcomp]?>" style="width:40%;" onChange="location.href='presu-cxp-reflejar.php?idop='+document.form2.idcomp.value;">
           							<input type="hidden" id="ncomp" name="ncomp" value="<?php echo $_POST[ncomp]?>">
            						<input type="hidden" name="compcont" value="<?php echo $_POST[compcont]?>">
            						<a href="#" onClick="adelante()"><img src="imagenes/next.png" title="siguiente" align="absmiddle"></a> 
            						<input type="hidden" value="a" name="atras" ><input type="hidden" value="s" name="siguiente" >
            						<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo">
            						<input type="hidden" value="<?php echo $_POST[codrec]?>" name="codrec" id="codrec">
       							</td>
	  							<td class="saludo1" style="width:3.1cm;">Fecha: </td>
        						<td style="width:10%;"><input type="text" name="fecha" value="<?php echo $_POST[fecha]?>" style='width:100%' id="fc_1198971545"  readonly></td>
	  							<td class="saludo1" style="width:3cm;">Vigencia: </td>
        						<td style="width:17%;">
                                	<input type="text" name="vigencia" value="<?php echo $_POST[vigencia]?>" style='width:50%' readonly>
        							<input type="hidden" name="estadoc" value="<?php echo $_POST[estadoc]?>" > 
                                    <input type="hidden" name="estado" value="<?php echo $_POST[estado]?>" > 
                               	</td>
                                <td rowspan="7" colspan="2" style="background:url(imagenes/factura03.png); background-repeat:no-repeat; background-position:right; background-size: 90% 95%"></td>
                            </tr>
							<tr>
        						<td class="saludo1">Registro: </td>
        						<td>
                            		<input type="text"name="rp" value="<?php echo $_POST[rp]?>" style="width:80%;" readonly />
                                	<input type="hidden" value="0" name="brp"/>
                  				</td> 
                  				<td class="saludo1">Estado: </td>
                  				<?php 
	                  				if($_POST[estado]=="S"){
				                    	$valuees="ACTIVO";
				                    	$stylest="width:100%; background-color:#0CD02A; color:white; text-align:center;";
				                    }else if($_POST[estado]=="N"){
				                    	$valuees="ANULADO";
				                    	$stylest="width:100%; background-color:#FF0000; color:white; text-align:center;";
				                    }else if($_POST[estado]=="P"){
				                    	$valuees="PAGO";
				                    	$stylest="width:100%; background-color:#0404B4; color:white; text-align:center;";
				                    }else if($_POST[estado]=="R"){
				                    	$valuees="REVERSADO";
				                    	$stylest="width:100%; background-color:#FF0000; color:white; text-align:center;";
				                    }

				                    echo "<td><input type='text' name='estado' id='estado' value='$valuees' style='$stylest' readonly /></td>";
                  				?>
                  				

                            </tr>
                           	<tr>
	  							<td class="saludo1">CDP:</td>
	  							<td><input type="text" id="cdp" name="cdp" value="<?php echo $_POST[cdp]?>" style="width:80%;" readonly></td>
	  							<td class="saludo1">Detalle RP:</td>
	  							<td colspan="3"><input type="text" id="detallecdp" name="detallecdp" value="<?php echo $_POST[detallecdp]?>" style='width:100%' readonly></td>
	  						</tr> 
	  						<tr>
	  							<td class="saludo1">Centro Costo:</td>
	  							<td>
									<select name="cc" onChange="validar()" onKeyUp="return tabular(event,this)" style="width:100%;text-transform:uppercase;">
										<?php
                                            $sqlr="select *from centrocosto where estado='S'";
                                            $res=mysql_query($sqlr,$linkbd);
                                            while ($row =mysql_fetch_row($res)) 
                                            {if("$row[0]"==$_POST[cc]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}}	 	
                                        ?>
   									</select>
	 							</td>
	     						<td class="saludo1">Tercero:</td>
          						<td><input id="tercero" type="text" name="tercero" style='width:100%' onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo $_POST[tercero]?>" readonly></td>
          						<td colspan="2"><input id="ntercero" name="ntercero" type="text" value="<?php echo $_POST[ntercero]?>" style='width:100%' readonly></td>
                         	</tr>
          					<tr>
                            	<td class="saludo1">Detalle CxP:</td>
          						<td colspan="5"><input type="text" id="detallegreso" name="detallegreso" value="<?php echo $_POST[detallegreso]?>" style='width:100%' readonly></td>
                          	</tr>
	  						<tr>
      							<td class="saludo1">Valor RP:</td>
      							<td><input type="text" id="valorrp" name="valorrp" value="<?php echo $_POST[valorrp]?>" style='width:95%' readonly></td>
      							<td class="saludo1">Saldo RP:</td>
      							<td><input type="text" id="saldorp" name="saldorp"  value="<?php echo $_POST[saldorp]?>" style='width:95%' readonly></td>
                           	</tr>
                          	<tr>
	  							<td class="saludo1" >Valor a Pagar:</td>
      							<td><input type="text" id="valor" name="valor" value="<?php echo $_POST[valor]?>" style='width:95%'  onChange='calcularpago()' readonly> 
								<input type="hidden" value="1" name="oculto" id="oculto"></td>
      							<td class="saludo1" >Base:</td>
      							<td><input type="text" id="base" name="base" value="<?php echo $_POST[base]?>" style='width:95%' onKeyUp="return tabular(event,this)"  readonly></td>
      							<td class="saludo1" >Iva:</td>
      							<td><input type="text" id="iva" name="iva" value="<?php echo $_POST[iva]?>" style='width:100%' onKeyUp="return tabular(event,this)" onChange='calcularpago()' readonly> </td>
                        	</tr>
      					</table>
      					<?php
	  						if(!$_POST[oculto]){echo "<script>document.form2.fecha.focus();document.form2.fecha.select();</script>";}
		 					//***** busca tercero
								$sqlr="select idcdp from pptorp where consvigencia=$_POST[rp] and vigencia=$_POST[vigencia]";
								// echo $sqlr."<br>";
								$res=mysql_query($sqlr,$linkbd);
								$row=mysql_fetch_row($res);
			 				 	// $nresul=buscaregistro($_POST[rp],$_POST[vigencia]);
								$nresul=$row[0];
								$sqlr="select objeto from pptocdp where consvigencia=$nresul and vigencia=$_POST[vigencia]";
								// echo $sqlr;
								$res=mysql_query($sqlr,$linkbd);
								$row=mysql_fetch_row($res);
								
			  					if($nresul!='')
			   					{
			  						// $_POST[cdp]=$nresul;
									// $_POST[detallecdp]=$row[0];
  									echo"<script>document.form2.cdp.value=".$nresul.";
												document.form2.detallecdp.value=".$row[0].";
									</script>";
			  					}
			 					else
			 					{
			  						$_POST[cdp]="";
			  						echo"
			  						<script>
				 						alert('Registro Presupuestal Incorrecto');
				 						document.form2.rp.select();
		  								//document.form2.rp.focus();	
			  						</script>";
			  					}
								// echo $_POST[cdp];
			 				
						?>
	  				</div>
    			</div>
				<div class="tab">
       				<input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?>>
       				<label for="tab-2">Retenciones</label>
       				<div class="content" style="overflow-x:hidden;"> 
     					<table class="inicio" style="overflow:scroll">
        					<tr>
                            	<td class="titulos">Descuento</td>
                                <td class="titulos">%</td>
                                <td class="titulos">Valor</td>
                                
                          	</tr>
      						<?php
								$totaldes=0;
								$sqlr="select *from tesoordenpago_retenciones where id_orden=".$_POST[idcomp];
								$res=mysql_query($sqlr,$linkbd);
								$iter='saludo1a';
								$iter2='saludo2';
								while ($row=mysql_fetch_row($res))
		 						{		 
		 							$sqlr="select *from tesoretenciones where id='$row[0]'";
									$res2=mysql_query($sqlr,$linkbd);
									$row2 =mysql_fetch_row($res2);
		 							echo "
									<input type='hidden' name='dndescuentos[]' value='$row2[2]'/ >
									<input type='hidden' name='ddescuentos[]' value='$row[0]'/>
									<input type='hidden' name='dporcentajes[]' value='$row[2]'/>
									<input type='hidden' name='ddesvalores[]' value='$row[3]'/>
									<tr class='$iter' style='text-transform:uppercase' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\">
										<td>$row2[2]</td>
										<td style='text-align:right;'>$row[2] %</td>
										<td style='text-align:right;'>$ $row[3]</td>
									</tr>";
									//echo "<td class='saludo2'><input name='ddesvalores[]' value='".$_POST[ddesvalores][$x]."' type='text' size='15'></td><td class='saludo2'><a href='#' onclick='eliminard($x)'><img src='imagenes/del.png'></a></td></tr>";
		 							$totaldes=$totaldes+$row[3];
									$aux=$iter;
									$iter=$iter2;
									$iter2=$aux;
		 						}		 
								echo"
        						<script>
        							document.form2.totaldes.value=<?php echo $totaldes;?>;		
									calcularpago();
									//document.form2.valorretencion.value=$totaldes;
        						</script>";
							?>
       					 </table>
	   				</div>
   				</div>
    			<div class="tab">
       				<input type="radio" id="tab-3" name="tabgroup1" value="3" <?php echo $check3;?>>
       				<label for="tab-3">Cuenta por Pagar</label>
       				<div class="content" style="overflow-x:hidden;"> 
	   					<table class="inicio" align="center" >
	   						<tr>
                            	<td colspan="6" class="titulos">Cheque</td>
                                <td width="108" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
                         	</tr>
							<tr>
	  							<td class="saludo1">Cuenta Contable:</td>
	  							<td >
	    							<input name="cuentapagar" type="text" value="<?php echo $_POST[cuentapagar]?>" size="25"  readonly> 
									<input name="cb" type="hidden" value="<?php echo $_POST[cb]?>" >
                                    <input type="hidden" id="ter" name="ter" value="<?php echo $_POST[ter]?>" >
                              	</td>
	  						</tr> 
	  						<tr>
	  							<td class="saludo1">Valor Orden de Pago:</td>
                                <td><input type="text" id="valoregreso" name="valoregreso" value="<?php echo $_POST[valoregreso]?>" size="20" onKeyUp="return tabular(event,this)" readonly></td>
                                <td class="saludo1">Valor Retenciones:</td>
                                <td><input type="text" id="valorretencion" name="valorretencion" value="<?php echo $_POST[valorretencion]?>" size="20" onKeyUp="return tabular(event,this)" readonly></td>
                                <td class="saludo1">Valor Cta Pagar:</td>
                                <td><input type="text" id="valorcheque" name="valorcheque" value="<?php echo $_POST[valorcheque]?>" size="20" onKeyUp="return tabular(event,this)" readonly></td>
                         	</tr>	
      					</table>
	   				</div>
	 			</div>	 
			</div>
	  		<div class="subpantallac4" style="height:36.8%; width:99.6%; overflow-x:hidden;">
     			<?php
	  				//*** busca contenido del rp
	  				$_POST[dcuentas]=array();
  	  				$_POST[dncuentas]=array();
	  				$_POST[dvalores]=array();
					$_POST[drecursos]=array();
	  				$sqlr="select * from tesoordenpago_det where id_orden=$_POST[idcomp]";
	  				$res=mysql_query($sqlr,$linkbd);
					while($r=mysql_fetch_row($res))
	 				{
						$consec=$r[0];	  
	 					$_POST[dcuentas][]=$r[2];
	 					$_POST[dvalores][]=$r[4];
	   					$_POST[dncuentas][]=buscacuentapres($r[2],2);
						$_POST[drecursos][]=buscafuenteppto($r[2],$_POST[vigencia]);
						// echo count($_POST[drecursos]);
	 				}
					
	  			?>
	   			<table class="inicio">
	   				<tr><td colspan="4" class="titulos">Detalle Orden de Pago</td></tr>                  
					<tr>
                    	<td class="titulos2" style='width:15%'>Cuenta</td>
                        <td class="titulos2">Nombre Cuenta</td>
                        <td class="titulos2" style='width:35%'>Recurso</td>
                        <td class="titulos2" style='width:10%'>Valor</td>
                 	</tr>
		  			<?php
		  				$_POST[totalc]=0;
						$iter='saludo1a';
		 				$iter2='saludo2';
		 				for ($x=0;$x<count($_POST[dcuentas]);$x++)
		 				{		 		
		 					echo "
							<input type='hidden' name='dcuentas[]' value='".$_POST[dcuentas][$x]."'/>
							<input type='hidden' name='dncuentas[]' value='".$_POST[dncuentas][$x]."'/>
							<input type='hidden' name='drecursos[]' value='".$_POST[drecursos][$x]."'/>
							<input type='hidden' name='dvalores[]' value='".$_POST[dvalores][$x]."'/>
							<tr class='$iter'>
		 						<td>".$_POST[dcuentas][$x]."</td>
		 						<td >".$_POST[dncuentas][$x]."</td>
		 						<td >".$_POST[drecursos][$x]."</td>
		 						<td style='text-align:right;'>$ ".number_format($_POST[dvalores][$x],$_SESSION["ndecimales"],$_SESSION["spdecimal"],$_SESSION["spmillares"])."</td>
		 					</tr>";
		 					$_POST[totalc]=$_POST[totalc]+$_POST[dvalores][$x];
							$_POST[totalcf]=number_format($_POST[totalc],$_SESSION["ndecimales"],$_SESSION["spdecimal"],$_SESSION["spmillares"]);
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux;
		 				}
						$resultado = convertir($_POST[totalc]);
						$_POST[letras]=$resultado." PESOS M/CTE";
	    				echo "
						<input type='hidden' name='totalcf' value='$_POST[totalcf]'/>
						<input type='hidden' name='totalc' value='$_POST[totalc]'/>
						<input type='hidden' name='letras' value='$_POST[letras]' >
						<tr class='$iter' style='text-align:right;font-weight:bold;'>
							<td colspan='3'>Total:</td>
							<td>$ $_POST[totalcf]</td>
						</tr>
						<tr class='titulos2'>
							<td >Son:</td>
							<td colspan='3'>$_POST[letras]</td>
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
	 			$fecha=split("/",$_POST[fecha]);
				$fechaf=$fecha[2]."-".$fecha[1]."-".$fecha[0];
				//echo $fechaf;
				$bloq=bloqueos($_SESSION[cedulausu],$fechaf);	
				if($_POST[estado]=='S'){$estadof=1;}
				if($_POST[estado]=='N'){$estadof=0;}
				if(($_POST[estado]=='R')){$estadof=2;$tm='401';$estadoff=2;}
				if($_POST[estado]=='C'){$estadof=4;}
				if($_POST[estado]=='P'){$estadof=4;}
				if($bloq>=1)
				{
					$consec=$_POST[idcomp];
					// echo "consec".$consec;
					$sqlr="delete from pptocomprobante_cab where numerotipo=$consec and tipo_comp=8";
					mysql_query($sqlr,$linkbd);	
					// echo $sqlr."<br>";
					$sqlr="delete from pptocomprobante_det where numerotipo=$consec and tipo_comp=8 and valcredito=0";
					mysql_query($sqlr,$linkbd);	
					// echo $sqlr."<br>";
					$sqlr="insert into  pptocomprobante_cab (numerotipo,tipo_comp,fecha,concepto,vigencia,total_debito,total_credito, diferencia,estado) values($consec,8,'$fechaf','Cuenta por Pagar',$_POST[vigencia],0,0,0,'$estadof')";
					// echo $sqlr."<br>";
					mysql_query($sqlr,$linkbd);	
					$sqlr="delete from pptocomprobante_det where numerotipo='$_POST[rp]' and tipo_comp=7 and valcredito=0 and doc_receptor='0' and tipomovimiento=$tm";
					mysql_query($sqlr,$linkbd);	
					$sqlr="delete from pptocomprobante_det where numerotipo='$consec' and tipo_comp=8 and valdebito=0 and doc_receptor='0' and tipomovimiento=$tm";
					mysql_query($sqlr,$linkbd);
					for($x=0;$x<count($_POST[dcuentas]);$x++)
					{	
						$sqlr="delete from pptocomprobante_det where numerotipo='$_POST[rp]' and tipo_comp=7 and valdebito=0 and cuenta='".$_POST[dcuentas][$x]."' and doc_receptor=$consec";
						// echo $sqlr;
						mysql_query($sqlr,$linkbd);	
						$sqlr="delete from pptocomprobante_det where numerotipo='$_POST[rp]' and tipo_comp=7 and valdebito=0 and doc_receptor=0";
						// echo $sqlr;
						mysql_query($sqlr,$linkbd);	
						$sqlr="delete from pptocomprobante_det where numerotipo='$_POST[rp]' and tipo_comp=7 and valcredito=0 and doc_receptor=$consec and tipomovimiento=$tm and cuenta='".$_POST[dcuentas][$x]."'";
						// echo $sqlr;
						mysql_query($sqlr,$linkbd);
						$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia ,tipo_comp,numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values('".$_POST[dcuentas][$x]."','".$_POST[tercero]."','CXP ',".$_POST[dvalores][$x].",0,$estadof,'$_POST[vigencia]',8,'$consec','201','$_POST[cc]','','$fechaf')";
						mysql_query($sqlr,$linkbd); 
						// echo $sqlr."<br>";
						$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia ,tipo_comp,numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values('".$_POST[dcuentas][$x]."','".$_POST[tercero]."','CXP ',0,".$_POST[dvalores][$x].",$estadof,'$_POST[vigencia]',7,'$_POST[rp]','201','$_POST[cc]',$consec,'$fechaf')";
						mysql_query($sqlr,$linkbd); 
						// echo $sqlr."<br>";
						if($_POST[estado]=='R'){
							$sqlr="select valor from tesoordenpago_det_r where id_orden=$consec and vigencia=$_POST[vigencia] and cuenta='".$_POST[dcuentas][$x]."'";
							$res=mysql_query($sqlr,$linkbd);
							$valor=mysql_fetch_row($res);
							// echo $sqlr;
							$sqlr="delete from pptocomprobante_det where numerotipo='$_POST[numerocdp]' and tipo_comp=8 and valcredito=0 and cuenta='".$_POST[dcuentas][$x]."' and doc_receptor='$_POST[numero]' and tipomovimiento=$tm and valcredito='".$_POST[dgastos][$x]."'";
							mysql_query($sqlr,$linkbd);
																
							
							$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia, tipo_comp,numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values('".$_POST[dcuentas][$x]."','$_POST[tercero]','".$_POST[dfuentes][$x]."',0,".$valor[0].",$estadoff,'$_POST[vigencia]',8,'$consec',$tm,'','','$fechaf')";
							// echo $sqlr."<br>";
							mysql_query($sqlr,$linkbd); 
							
							$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia, tipo_comp,numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values('".$_POST[dcuentas][$x]."','$_POST[tercero]','".$_POST[dfuentes][$x]."',".$valor[0].",0,$estadoff,'$_POST[vigencia]',7,'$_POST[rp]',$tm,'','$consec','$fechaf')";
							// echo $sqlr."<br>";
							mysql_query($sqlr,$linkbd);
						}
						
					}
					echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha reflejado la cuenta por pagar con Exito <img src='imagenes\confirm.png'></center></td></tr></table>";
		 		}
  				else 
				{
					echo "<div class='inicio'><img src='imagenes\alert.png'> No Tiene los Permisos para Modificar este Documento</div>";
				}
  				//****fin if bloqueo  
			}//************ FIN DE IF OCULTO************
		
			?>
</form>
 </td></tr>  
</table>
</body>
</html>	 