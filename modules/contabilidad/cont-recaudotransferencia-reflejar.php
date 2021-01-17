<?php //V 1000 12/12/16 ?> 
<?php
	require "comun.inc";
	require "funciones.inc";
	require "conversor.php"; //esto es un comentario
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
	header("Content-Type: text/html;charset=iso-8859-1");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: SPID - Contabilidad</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/calendario.js"></script>
        <script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="JQuery/jquery-2.1.4.min.js"></script>
		<script>
			function validar(){document.form2.submit();}	
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
				else
				{
					alert('Faltan datos para completar el registro');
					document.form2.fecha.focus();
					document.form2.fecha.select();
				}
			}
			function pdf()
			{
				document.form2.action="teso-pdfrecaudostrans.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function despliegamodal2(_valor)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden")
				{
					document.getElementById('ventana2').src="";
				}
				else 
				{
					document.getElementById('ventana2').src="ingresos-ventana.php?ti=I&modulo=4";
				}
			}
			function adelante()
			{
				var maximo=document.form2.maximo.value;
				//alert(maximo);
				var actual=document.form2.idcomp.value;
				if(parseFloat(maximo)>parseFloat(actual))
				{
					var idcta=parseFloat(document.form2.idcomp.value)+1;
					location.href="cont-recaudotransferencia-reflejar.php?idrecaudo="+idcta;
				}
			}
			function atrasc()
			{
				var actual=document.form2.idcomp.value;
				if(0<parseFloat(actual))
				{
					var idcta=document.form2.idcomp.value-1;
					location.href="cont-recaudotransferencia-reflejar.php?idrecaudo="+idcta;
				}
			}		
			function iratras()
			{
				var idcomp=document.form2.idcomp.value;
				location.href="cont-reflejardocs.php";
			}
			function validar2()
			{
				document.form2.oculto.value=1;
				document.form2.ncomp.value=document.form2.idcomp.value;
				document.form2.action="cont-recaudotransferencia-reflejar.php";
				document.form2.submit();
			}
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
					<a><img src="imagenes/add2.png" class="mgbt1" /></a>
					<a><img src="imagenes/guardad.png"  class="mgbt1"/></a>
					<a class="mgbt1"><img src="imagenes/buscad.png" /></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();"/></a>
					<a><img src="imagenes/reflejar1.png" title="Reflejar" class="mgbt" onclick="guardar()"/></a>
					<a><img src="imagenes/iratras.png" title="Atr&aacute;s" onClick="iratras()" class="mgbt"></a>
				</td>
			</tr>		  
		</table>
		<form name="form2" method="post" action=""> 
			<?php
				if($_GET[consecutivo]=='' && $_POST[idcomp]=='')
				{
					$sqlr="SELECT * FROM tesorecaudotransferencia WHERE 1 ORDER BY id_recaudo DESC";	
					$res=mysql_query($sqlr,$linkbd);
					$row =mysql_fetch_row($res);
					$_POST[idcomp]=$row[0]; 
				}
				//echo  "hola";
				//$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
				//$vigencia=$vigusu;
				//$_POST[vigencia]=$vigencia;
	 			//*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
				
					$fec=date("d/m/Y");
					if($_POST[idcomp] != '')
					{
						$sqlr="select distinct *from tesorecaudotransferencia, tesorecaudotransferencia_det   where	  tesorecaudotransferencia.id_recaudo=$_POST[idcomp]  AND tesorecaudotransferencia.ID_recaudo=tesorecaudotransferencia_det.ID_recaudo and tesorecaudotransferencia_det.id_recaudo=$_POST[idcomp]";
						$res=mysql_query($sqlr,$linkbd);
						$cont=0;	
						$total=0;
					}
					if($_GET[consecutivo]!='')
					{
						$sqlr="select distinct *from tesorecaudotransferencia, tesorecaudotransferencia_det   where	  tesorecaudotransferencia.id_recaudo=$_GET[consecutivo]  AND tesorecaudotransferencia.ID_recaudo=tesorecaudotransferencia_det.ID_recaudo and tesorecaudotransferencia_det.id_recaudo=$_GET[consecutivo]";	
						$res=mysql_query($sqlr,$linkbd);
						$cont=0;
						$_POST[idcomp]=$_GET[consecutivo];	
						$total=0;
					}
					if($_GET[idrecaudo]!='')
					{
						$sqlr="select distinct *from tesorecaudotransferencia, tesorecaudotransferencia_det   where	  tesorecaudotransferencia.id_recaudo=$_GET[idrecaudo]  AND tesorecaudotransferencia.ID_recaudo=tesorecaudotransferencia_det.ID_recaudo and tesorecaudotransferencia_det.id_recaudo=$_GET[idrecaudo]";
						$res=mysql_query($sqlr,$linkbd);
						$cont=0;
						$_POST[idcomp]=$_GET[idrecaudo];	
						$total=0;
					}
					while ($row =mysql_fetch_row($res)) 
					{
						$p1=substr($row[2],0,4);
						$p2=substr($row[2],5,2);
						$p3=substr($row[2],8,2);
						$_POST[vigencia]=$row[3];
						$_POST[fecha]=$p3."/".$p2."/".$p1;	
						$_POST[cc]=$row[8];
						$_POST[liquidacion]=$row[1];
						$_POST[dcoding][$cont]=$row[15];			 
						$_POST[banco]=$row[4];		 
						$_POST[dnbanco]=buscatercero($row[4]);		 
						$_POST[dncoding][$cont]=buscaingreso($row[15]);
						$_POST[tercero]=$row[7];
						$_POST[ntercero]=buscatercero($row[7]);
						$_POST[concepto]=$row[6];
						$total=$total+$row[16]; 
						$_POST[totalc]=$total;
						$_POST[dvalores][$cont]=$row[16];
						$_POST[estadoc]=$row[10];
						if($_POST[oculto]!='2')
						{
							$_POST[medioDePagosgr]=$row[12];
						}
						$cont=$cont+1;		
					}
					$sqlr="select distinct *from tesorecaudotransferencialiquidar where tesorecaudotransferencialiquidar.id_recaudo = $_POST[liquidacion]";	
					$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res)) 
					{
						$_POST[medioDePago]=$row[11];			 
					}

					$sqlr="select *from cuentacaja where estado='S' and vigencia=$_POST[vigencia]";
					$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res)){$_POST[cuentacaja]=$row[1];}
					
					if($_GET[consecutivo]!='')
					{
						$sqlr="select distinct *from tesorecaudotransferencia, tesorecaudotransferencia_det,tesobancosctas   where	 tesobancosctas.ncuentaban= tesorecaudotransferencia.ncuentaban  and tesorecaudotransferencia.id_recaudo=$_GET[consecutivo]  AND tesorecaudotransferencia.ID_recaudo=tesorecaudotransferencia_det.ID_recaudo and tesorecaudotransferencia_det.id_recaudo=$_GET[consecutivo]";	
						$res=mysql_query($sqlr,$linkbd);
						while ($row =mysql_fetch_row($res)) 
						{	
							$_POST[banco]=$row[18];		 
							$_POST[dnbanco]=buscatercero($row[4]);		 
						}	
					}	
					if($_GET[idrecaudo]!='')
					{
						$sqlr="select distinct *from tesorecaudotransferencia, tesorecaudotransferencia_det,tesobancosctas   where	 tesobancosctas.ncuentaban= tesorecaudotransferencia.ncuentaban  and tesorecaudotransferencia.id_recaudo=$_GET[idrecaudo]  AND tesorecaudotransferencia.ID_recaudo=tesorecaudotransferencia_det.ID_recaudo and tesorecaudotransferencia_det.id_recaudo=$_GET[idrecaudo]";
						$res=mysql_query($sqlr,$linkbd);
						while ($row =mysql_fetch_row($res)) 
						{	
							$_POST[banco]=$row[18];		 
							$_POST[dnbanco]=buscatercero($row[4]);		 
						}	
					}

					if($_POST[idcomp]!='')
					{
						$sqlr="select distinct *from tesorecaudotransferencia, tesorecaudotransferencia_det,tesobancosctas   where	 tesobancosctas.ncuentaban= tesorecaudotransferencia.ncuentaban  and tesorecaudotransferencia.id_recaudo=$_POST[idcomp]  AND tesorecaudotransferencia.ID_recaudo=tesorecaudotransferencia_det.ID_recaudo and tesorecaudotransferencia_det.id_recaudo=$_POST[idcomp]";
						$res=mysql_query($sqlr,$linkbd);
						while ($row =mysql_fetch_row($res)) 
						{	
							$_POST[banco]=$row[18];		 
							$_POST[dnbanco]=buscatercero($row[4]);		 
						}	
					}
				
				$sql = "SELECT id_recaudo FROM `tesorecaudotransferencia` where 1 order by id_recaudo desc";
				$res=mysql_query($sql,$linkbd);
				$row =mysql_fetch_row($res);
				$_POST[maximo]=$row[0];
 			?>
    		<table class="inicio" align="center" >
      			<tr>
        			<td class="titulos" colspan="8"> Recaudos Transferencias</td>
        			<td  class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
      			</tr>
      			<tr>
        			<td style="width:10%;" class="saludo1" >No Recaudo:</td>
        			<td style="width:10%;">&nbsp;<img class="icobut" src="imagenes/back.png" title="anterior" onClick="atrasc()"/>&nbsp;<input type="text" name="idcomp" id="idcomp" value="<?php echo $_POST[idcomp]?>" onKeyUp="return tabular(event,this) "  onBlur="validar2()"  style="width:50%;" />&nbsp;<img class="icobut" src="imagenes/next.png" title="siguiente" onClick="adelante()"/></td>
            		<input name="ncomp" type="hidden" value="<?php echo $_POST[ncomp]?>">
            		<input type="hidden" value="a" name="atras" >
        			<input type="hidden" value="s" name="siguiente" >
        			<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo">
        			<script>
        				$("#idcomp").keypress(function(e) {
						var id = $("#idcomp").val();
				   		if(e.which == 13) { location.href="cont-recaudotransferencia-reflejar.php?idrecaudo="+id; }
						});
        			</script>
					<td style="width:7%;" class="saludo1">Liquidacion:</td>
					<td style="width:15%;"><input type="text"  name="liquidacion"  value="<?php echo $_POST[liquidacion]?>" style="width:40%;" onKeyUp="return tabular(event,this)"  readonly/><input type="hidden" name="estadoc" value="<?php echo $_POST[estadoc]?>" onKeyUp="return tabular(event,this)" readonly/>&nbsp;
						<?php 
                            if($_POST[estadoc]=="S"){
                                $valuees="ACTIVO";
                                $stylest="width:40%; background-color:#0CD02A; color:white; text-align:center;";
                            }else if($_POST[estadoc]=="N"){
                                $valuees="ANULADO";
                                $stylest="width:40%; background-color:#FF0000; color:white; text-align:center;";
                            }else if($_POST[estadoc]=="P"){
                                $valuees="PAGO";
                                $stylest="width:100%; background-color:#0404B4; color:white; text-align:center;";
                            }
                            echo "<input type='text' name='estado' id='estado' value='$valuees' style='$stylest' readonly />";
                        ?>
					</td>   
	  				<td style="width:7%;" class="saludo1">Fecha:</td>
        			<td style="width:20%;" ><input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" value="<?php echo $_POST[fecha]; ?>" style="width:50%;" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" readonly></td>
         			<td  class="saludo1">Vigencia:</td>
		  			<td><input type="text" id="vigencia" name="vigencia" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  value="<?php echo $_POST[vigencia]?>" onClick="document.getElementById('tipocta').focus();document.getElementById('tipocta').select();" readonly/></td>
				</tr>
        		<tr>
					<?php
					if($_POST[medioDePago] != 2)
					{
						?>
						<td style="width:10%;" class="saludo1">Recaudado:</td>
						<td colspan="3"> 
							<select id="banco" name="banco" style="width:100%;"/>
								<?php
									$sqlr="select tesobancosctas.estado, tesobancosctas.cuenta, tesobancosctas.ncuentaban, tesobancosctas.tipo, terceros.razonsocial, tesobancosctas.tercero from tesobancosctas,terceros where tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.estado='S' order by tesobancosctas.cuenta";
									$res=mysql_query($sqlr,$linkbd);
									while ($row =mysql_fetch_row($res)) 
									{
										$ncb=buscacuenta($row[1]);
										if($row[1]==$_POST[banco])
										{
											echo "<option value='$row[1]' SELECTED>$row[1]-".substr($ncb,0,70)." - Cuenta $row[3]</option>";
											$_POST[nbanco]=$row[4];
											$_POST[ter]=$row[5];
											$_POST[cb]=$row[2];
										}
									}	 	
								?>
							</select>
							<input type="hidden" name="cb" value="<?php echo $_POST[cb]?>"/>
							<input type="hidden" id="ter" name="ter" value="<?php echo $_POST[ter]?>"/>           
						</td>
						<td colspan="4"><input type="text" id="nbanco" name="nbanco" style="width:100%;" value="<?php echo $_POST[nbanco]?>" readonly/></td>
						<?php
					}
					else
					{
						$regalias = "MEDIO PAGO SSF";
						?>
						<td class="saludo1">Recaudo: </td>
						<td colspan="5"> 
							<input type="text" id="regalias" value="<?php echo $regalias;?>" style="width:100%;" readonly>
						</td>
						<td style="width:8%;" class="saludo1">Medio de Pago:</td>
							<td style="width:10%;">
								<select name="medioDePagosgr" id="medioDePagosgr" style="width:100%;">
									<option value="">No contabiliza </option>
									<?php
										$linkbd=conectar_bd();
										$sqlr="select *from tesomediodepago where estado='S'";
										$res=mysql_query($sqlr,$linkbd);
										while ($row =mysql_fetch_row($res)) 
										{
											echo "<option value=$row[0] ";
											$i=$row[0];
											if($i==$_POST[medioDePagosgr])
											{
												echo "SELECTED";
											}
											echo ">".$row[0]." - ".$row[1]."</option>";	 	 
										}	 	
									?>
								</select>
							</td>
						<?php
					}
					?>
        		</tr>
      			<tr>
       	 			<td style="width:10%;" class="saludo1">Concepto Recaudo:</td>
        			<td colspan="3"><input name="concepto" type="text" value="<?php echo $_POST[concepto]?>" style="width:100%;" readonly/></td>
        			<td style="width:7%;" class="saludo1">NIT: </td>
        			<td style="width:20%;"><input name="tercero" type="text" value="<?php echo $_POST[tercero]?>" style="width:80%;" readonly/></td>
					<td style="width:7%;" class="saludo1">Contribuyente:</td>
	  				<td><input type="text" id="ntercero" name="ntercero" value="<?php echo $_POST[ntercero]?>" style="width:100%;" readonly/></td>
	    		</tr> 
    		</table>
	  		<input type="hidden" id="cb" name="cb" value="<?php echo $_POST[cb]?>"/>
	  		<input type="hidden" id="ct" name="ct" value="<?php echo $_POST[ct]?>"/>
            <input type="hidden" id="cc" name="cc" value="<?php echo $_POST[cc]?>"/>
        	<input type="hidden"  name="oculto" id="oculto" value="1"/>
    		<div class="subpantalla">
	   			<table class="inicio">
                    <tr><td colspan="4" class="titulos">Detalle  Recaudos Transferencia</td></tr>                  
                    <tr class="titulos2">
                        <td >Codigo</td>
                        <td>Ingreso</td>
                        <td>Valor</td>				
                    </tr>
                    <?php 		
                        $_POST[totalc]=0;
                        for ($x=0;$x<count($_POST[dcoding]);$x++)
                        {		 
                            echo "
                            <input type='hidden' name='dcoding[]' value='".$_POST[dcoding][$x]."'/>
                            <input type='hidden' name='dncoding[]' value='".$_POST[dncoding][$x]."'/>
                            <input type='hidden' name='dvalores[]' value='".$_POST[dvalores][$x]."'/'>
                            <tr class='saludo1a'>
                                <td style='width:5%;' >".$_POST[dcoding][$x]."</td>
                                <td>".$_POST[dncoding][$x]."</td>
                                <td style='width:15%;text-align:right;'>$ ".number_format($_POST[dvalores][$x],2,'.',',')."</td>
                            </tr>";
                            $_POST[totalc]=$_POST[totalc]+$_POST[dvalores][$x];
                            $_POST[totalcf]=number_format($_POST[totalc],2);
                         }
                        $resultado = convertir($_POST[totalc]);
                        $_POST[letras]=$resultado." Pesos";
                        echo "
                        <input type='hidden' name='totalcf' value='$_POST[totalcf]'/>
                        <input type='hidden' name='totalc' value='$_POST[totalc]'/>
                        <input type='hidden' name='letras' value='$_POST[letras]'/>
                        <tr class='saludo2'>
                            <td colspan='2' style='text-align:right;'>Total:</td>
                            <td style='text-align:right;'>$ ".number_format($_POST[totalc],2,'.',',')."</td>
                        </tr>
                        <tr class='titulos2'>
                            <td>Son:</td>
                            <td colspan='2'>$_POST[letras]</td>
                        </tr>";
                    ?> 
	   			</table>
			</div>
	  		<?php
			if($_POST[oculto]=='2')
			{
 				ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
				$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
				//*********************CREACION DEL COMPROBANTE CONTABLE ***************************
				$sqlr="DELETE from comprobante_cab where numerotipo='$_POST[idcomp]' and tipo_comp='14'";
				mysql_query($sqlr,$linkbd);	
				//***busca el consecutivo del comprobante contable
				$consec=$_POST[idcomp];
				if ($_POST[estadoc]=='S'){$esta=1;}
				else {$esta=0;}
				//***cabecera comprobante
	 			$sqlr="INSERT into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($consec,14,'$fechaf','".strtoupper($_POST[concepto])."',0,$_POST[totalc],$_POST[totalc],0,'$esta')";
				mysql_query($sqlr,$linkbd);	
				$idcomp=mysql_insert_id();
				$sqlr="DELETE from comprobante_det where id_comp=14 and numerotipo=$_POST[idcomp]";
				mysql_query($sqlr,$linkbd);
				//******************* DETALLE DEL COMPROBANTE CONTABLE *********************
				if($_POST[medioDePago] != 2)
				{
					for($x=0;$x<count($_POST[dcoding]);$x++)
					{
						//***** BUSQUEDA INGRESO ********
						$sqlri="SELECT * from tesoingresos_det where codigo='".$_POST[dcoding][$x]."' and vigencia=$_POST[vigencia]";
						$resi=mysql_query($sqlri,$linkbd);
						while($rowi=mysql_fetch_row($resi))
						{
							//**** busqueda concepto contable*****
							$sq="select fechainicial from conceptoscontables_det where codigo='$rowi[2]' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
							$re=mysql_query($sq,$linkbd);
							while($ro=mysql_fetch_assoc($re))
							{
								$_POST[fechacausa]=$ro["fechainicial"];
							}
							$sqlrc="SELECT * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C' and fechainicial='".$_POST[fechacausa]."'";
							$resc=mysql_query($sqlrc,$linkbd);	  
							//echo "con: $sqlrc <br>";	      
							while($rowc=mysql_fetch_row($resc))
							{
								$porce=$rowi[5];
								if($rowc[6]=="S")
								{
										$valorcred=$_POST[dvalores][$x]*($porce/100);
										$valordeb=0;
										$sqlr="INSERT into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito, estado,vigencia) values ('14 $consec','$rowc[4]','$_POST[tercero]','$_POST[cc]','Recaudo Transferencia".strtoupper($_POST[dncoding][$x])."','', '$valordeb','$valorcred','$esta','$_POST[vigencia]')";
										mysql_query($sqlr,$linkbd);
										$valordeb=$_POST[dvalores][$x]*($porce/100);
										$valorcred=0; 
										$sqlr="INSERT into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('14 $consec','$_POST[banco]','$_POST[tercero]', '$_POST[cc]','Recaudo Transferencia".strtoupper($_POST[dncoding][$x])."','','$valordeb','$valorcred','$esta','$_POST[vigencia]')";
										mysql_query($sqlr,$linkbd);
								}
							}
						}
					}
				}
				elseif($_POST[medioDePagosgr]!='')
				{
					$sqlr = "UPDATE tesorecaudotransferencia SET mediopago='$_POST[medioDePagosgr]' WHERE id_recaudo=$_POST[idcomp]";
					mysql_query($sqlr,$linkbd);

					for($x=0;$x<count($_POST[dcoding]);$x++)
					{
						//***** BUSQUEDA INGRESO ********
						$sqlri="Select * from tesoingresos_det where codigo='".$_POST[dcoding][$x]."'  and vigencia=$_POST[vigencia]";
						$resi=mysql_query($sqlri,$linkbd); 
						while($rowi=mysql_fetch_row($resi))
						{
							//**** busqueda concepto contable*****
							$sq="select fechainicial from conceptoscontables_det where codigo='".$rowi[2]."' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
							$re=mysql_query($sq,$linkbd);
							while($ro=mysql_fetch_assoc($re))
							{
								$_POST[fechacausa]=$ro["fechainicial"];
							}
							$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo=".$rowi[2]." and tipo='C' and fechainicial='".$_POST[fechacausa]."'";
							$resc=mysql_query($sqlrc,$linkbd);	  
							//	echo "con: $sqlrc <br>";	      
							while($rowc=mysql_fetch_row($resc))
							{
								$porce=$rowi[5];
								if($_POST[cc]==$rowc[5])
								{
									if($rowc[6]=='S')
									{
										$valorcred=$_POST[dvalores][$x]*($porce/100);
										$valordeb=0;
										$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('14 $consec','".$rowc[4]."','".$_POST[tercero]."','".$_POST[cc]."','Recaudo Transferencia".strtoupper($_POST[dncoding][$x])."','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
										mysql_query($sqlr,$linkbd);
										//echo "<br>".$sqlr;
										$valordeb=$_POST[dvalores][$x]*($porce/100);
										$valorcred=0;
										$sqlrMedioPago = "SELECT cuentacontable FROM tesomediodepago WHERE id='$_POST[medioDePagosgr]' AND estado='S'";
										$resMedioPago=mysql_query($sqlrMedioPago,$linkbd);
										$rowMedioPago=mysql_fetch_row($resMedioPago);
										$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('14 $consec','".$rowMedioPago[0]."','".$_POST[tercero]."','".$_POST[cc]."','Recaudo Transferencia".strtoupper($_POST[dncoding][$x])."','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
										mysql_query($sqlr,$linkbd);

										$sqlrBanco="select tesobancosctas.estado, tesobancosctas.cuenta, tesobancosctas.ncuentaban, tesobancosctas.tipo, terceros.razonsocial, tesobancosctas.tercero from tesobancosctas,terceros where tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.cuenta='$rowMedioPago[0]' and tesobancosctas.estado='S' ";
										$resBanco=mysql_query($sqlrBanco,$linkbd);
										$rowBanco =mysql_fetch_row($resBanco);
										$_POST[nbanco]=$rowBanco[4];
										$_POST[ter]=$rowBanco[5];
										$_POST[cb]=$rowBanco[2];
										$vi=$_POST[dvalores][$x]*($porce/100);
									}
								}
							}
						}
					}
				}
				else
				{
					$sqlr = "UPDATE tesorecaudotransferencia SET mediopago='' WHERE id_recaudo=$_POST[idcomp]";
					mysql_query($sqlr,$linkbd);
				}
				//************ insercion de cabecera recaudos ************
	//************** insercion de consignaciones **************
	echo "<table  class='inicio'><tr><td class='saludo1'><center>Se ha reflejado el Recaudo con Exito <img src='imagenes/confirm.png'></center></td></tr></table>";
}
?>	

		<div id="bgventanamodal2">
            <div id="ventanamodal2">
                <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                </IFRAME>
            </div>
       	</div>	
		</form>
 </td></tr>
</table>
	</body>
</html> 		