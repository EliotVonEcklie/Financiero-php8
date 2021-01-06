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
		<link href="css/css2.css" rel="stylesheet" type="text/css" />
		<link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
        <script type="text/javascript" src="css/calendario.js"></script>
        <script type="text/javascript" src="JQuery/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="JQuery/autoNumeric-master/autoNumeric-min.js"></script>
		<script>
			function validar(){document.form2.submit();}
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
					document.form2.submit();
 				}
 				else {alert("Falta informacion para poder Agregar");}
			}
			function eliminar(variable)
			{
				document.form2.elimina.value=variable;
				despliegamodalm('visible','4','Esta Seguro de Eliminar','1');
			}
			function guardar()
			{
				ingresos2=document.getElementsByName('dcoding[]');
				var validacion01=document.getElementById('concepto').value;
				var validacion02=document.getElementById('ntercero').value;
				if (document.form2.fecha.value!='' && ingresos2.length>0 && (validacion01.trim()!='') && (validacion02.trim()!=''))
  				{despliegamodalm('visible','4','Esta Seguro de Guardar','2');}
				else
				{
  					despliegamodalm('visible','2',"Falta informaci�n para poder guardar")
  					document.form2.fecha.focus();
  					document.form2.fecha.select();
  				}
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
			function despliegamodal2(_valor,_nvent)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else 
				{
					if(_nvent=='1')
					{document.getElementById('ventana2').src="tercerosgral-ventana01.php?objeto=tercero&nobjeto=ntercero&nfoco=codingreso";}
					else if(_nvent=='2')
                    {
                        document.getElementById('ventana2').src = "cuentasbancarias-ventana02.php?tipoc=D&obj01=banco&obj02=nbanco&obj03=&obj04=cb&obj05=ter";
                    }
                    else
					{document.getElementById('ventana2').src="ingresosgral-ventana01.php?objeto=codingreso&nobjeto=ningreso&nfoco=cc&ti=I&modulo=4";}
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
									document.getElementById('codingreso').focus();
									document.getElementById('codingreso').select();
									break;
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
				document.location.href = "teso-editarecaudotransferenciaprivado.php?idrecaudo="+numdocar;
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
			jQuery(function($){ $('#valorvl').autoNumeric('init');});
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
					<a onClick="location.href='teso-recaudotransferenciaprivado.php'" class="mgbt"><img src="imagenes/add.png" title="Nuevo"  border="0"/></a>
					<a onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a>
					<a onClick="location.href='teso-buscarecaudotransferenciaprivado.php'" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
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
                $vigencia=$vigusu;
                $_POST[vigencia]=$vigencia;
                //*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
                if(!$_POST[oculto])
                {
                    $check1="checked";
                    $fec=date("d/m/Y");
                    $_POST[vigencia]=$vigencia;
                    $sqlr="select valor_inicial from dominios where nombre_dominio='CUENTA_CAJA'";
                    $res=mysql_query($sqlr,$linkbd);
                    while ($row =mysql_fetch_row($res)) {$_POST[cuentacaja]=$row[0];}
                    /*$sqlr="select max(numerotipo) from comprobante_cab where tipo_comp='2' and EXTRACT(YEAR FROM fecha)=".$_SESSION["vigencia"];
                    $res=mysql_query($sqlr,$linkbd);
                    $consec=0;
                    while($r=mysql_fetch_row($res))
                     {
                      $consec=$r[0];	  
                     }
                     $consec+=1;*/
                    $sqlr="select max(id_recaudo) from tesorecaudotransferenciaprivado ";
                    $res=mysql_query($sqlr,$linkbd);
                    $consec=0;
                    while($r=mysql_fetch_row($res)){$consec=$r[0];}
                    $consec+=1;
                    $_POST[idcomp]=$consec;	
                    $fec=date("d/m/Y");
                    $_POST[fecha]=$fec; 		 		  			 
                    $_POST[valor]=0;		 
                }
 			?>
			<table class="inicio" style="width:99.6%">
                <tr >
                    <td class="titulos" colspan="7">Liquidar Recaudos Transferencias</td>
                    <td class="cerrar" style="width:7%;"><a onClick="location.href='teso-principal.php'">&nbsp;Cerrar</a></td>
                </tr>
                <tr>
                    <td class="saludo1" style="width:4cm;" >Numero Liquidacion:</td>
                    <td style="width:16%;"><input type="text" name="idcomp" id="idcomp" value="<?php echo $_POST[idcomp]?>" onKeyUp="return tabular(event,this)" style="width:80%;" readonly/></td>
                    <td class="saludo1" style="width:4cm;">Fecha:</td>
                    <td style="width:15%;"><input type="text" name="fecha" id="fc_1198971545" title="DD/MM/YYYY" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this)" onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">&nbsp;<a onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/calendario04.png" style="width:20px; cursor:pointer"/></a></td>
					<td class="saludo1" style="width:3cm;">Medio de pago: </td>
					<td style="width:14%;">
						<select name="medioDePago" id="medioDePago" onKeyUp="return tabular(event,this)" style="width:80%">
							<option value="1" <?php if(($_POST[medioDePago]=='1')) echo "SELECTED"; ?>>Con SF</option>
							<option value="2" <?php if($_POST[medioDePago]=='2') echo "SELECTED"; ?>>Sin SF</option>         
						</select>
						<input type="hidden" name="vigencia"  value="<?php echo $_POST[vigencia]?>" onKeyUp="return tabular(event,this)" readonly/>
					</td>
                    <td rowspan="6" colspan="2" style="background:url(imagenes/siglas.png); background-repeat:no-repeat; background-position:right; background-size: 100% 100%;" ></td>
              	</tr>
                <tr>
                    <td  class="saludo1">Vigencia:</td>
                    <td><input type="text" id="vigencia" name="vigencia" value="<?php echo $_POST[vigencia]?>" style="width:80%;" readonly/></td>
                    <td class="saludo1">Causacion Contable:</td>
                    <td>
                        <select name="causacion" id="causacion" onKeyUp="return tabular(event,this)"  disabled>
                            <option value="1" <?php if($_POST[causacion]=='1') echo "SELECTED"; ?>>Si</option>
                            <option value="2" <?php if($_POST[causacion]=='2') echo "SELECTED"; ?>>No</option>         
                        </select>
                    </td>    
                </tr>
                <tr>
                    <td  class="saludo1">Concepto Recaudo:</td>
                    <td colspan="5"><input type="text" name="concepto" id="concepto" value="<?php echo $_POST[concepto]?>" onKeyUp="return tabular(event,this)" style="width:95.8%;"/></td>
                </tr>  
                <tr>
                    <td  class="saludo1">NIT: </td>
                    <td ><input type="text" name="tercero" id="tercero" value="<?php echo $_POST[tercero]?>" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" style="width:80%;"/>&nbsp;<a onClick="despliegamodal2('visible','1');" title="Listado Contribuyentes"><img src="imagenes/find02.png" style="width:20px;cursor:pointer;"/></a></td>
                    <td class="saludo1">Contribuyente:</td>
                    <td colspan="3">
                        <input type="text" id="ntercero" name="ntercero" value="<?php echo $_POST[ntercero]?>" onKeyUp="return tabular(event,this)" style="width:93%;" readonly>
                        <input type="hidden" value="0" name="bt">
                        <input type="hidden" id="ct" name="ct" value="<?php echo $_POST[ct]?>" >
                        <input type="hidden" name="oculto" id="oculto" value="1" >
                  	</td>
            	</tr>
                <tr>
                    <td class="saludo1">Recaudado:</td>
                    <td style="width:10%;">
                        <!--
                        <select id="banco" name="banco"  onChange="validar()" onKeyUp="return tabular(event,this)">
                        <option value="">Seleccione....</option>
                        <?php
                                $linkbd = conectar_bd();
                                $sqlr = "select tesobancosctas.estado, tesobancosctas.cuenta, tesobancosctas.ncuentaban, tesobancosctas.tipo, terceros.razonsocial, tesobancosctas.tercero from tesobancosctas,terceros where tesobancosctas.tercero=terceros.cedulanit and tesobancosctas.estado='S' ";
                                $res = mysql_query($sqlr, $linkbd);
                                while ($row = mysql_fetch_row($res))
                                {
                                    echo "<option value=$row[1] ";
                                    $i = $row[1];
                                    $ncb = buscacuenta($row[1]);
                                    if ($i == $_POST[banco])
                                    {
                                        echo "SELECTED";
                                        $_POST[nbanco] = $row[4];
                                        $_POST[ter] = $row[5];
                                        $_POST[cb] = $row[2];
                                    }
                                    echo ">" . substr($ncb, 0, 70) . " - Cuenta " . $row[3] . "</option>";
                                }
                            ?>
                        </select>-->
                        <input type="text" name="cb" id="cb" value="<?php echo $_POST[cb]; ?>"
                                style="width:80%;"/>&nbsp;
                        <a onClick="despliegamodal2('visible','2');" style="cursor:pointer;"
                            title="Listado Cuentas Bancarias">
                            <img src='imagenes/find02.png' style='width:20px;'/>
                        </a>
                        <input name="banco" id="banco" type="hidden"
                                value="<?php echo $_POST[banco] ?>">
                        <input type="hidden" id="ter" name="ter" value="<?php echo $_POST[ter] ?>">
                    </td>
                    <td colspan="4">
                        <input type="text" id="nbanco" name="nbanco"
                                value="<?php echo $_POST[nbanco] ?>" style="width:95%;" readonly>
                    </td>
                </tr>
               	<tr>
             		<td class="saludo1">Ingreso:</td>
        			<td>
                   		<input type="text" id="codingreso" name="codingreso" value="<?php echo $_POST[codingreso]?>"  onKeyUp="return tabular(event,this)" onBlur="buscaing(event)" style="width:80%;">&nbsp;<a onClick="despliegamodal2('visible','3');" title="Listado de Ingresos"><img src="imagenes/find02.png" style="width:20px;cursor:pointer;"/></a>
                       	<input type="hidden" value="0" name="bin">
                  	</td> 
                    <td colspan="4"><input type="text" name="ningreso" id="ningreso" value="<?php echo $_POST[ningreso]?>" style="width:94.6%;" readonly></td>
             	</tr>
                <tr>
               		<td class="saludo1">Centro Costo:</td>
                	<td>
                   		<select name="cc" id="cc" onChange="validar()" onKeyUp="return tabular(event,this)">
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
                    <td class="saludo1" >Valor:</td>
                    <td>
                    	<input type="hidden" id="valor" name="valor" value="<?php echo $_POST[valor]?>"/>
                        <input type="text" name="valorvl" id="valorvl" data-a-dec="<?php echo $_SESSION["spdecimal"];?>" data-a-sep="<?php echo $_SESSION["spmillares"];?>" data-v-min='0' onKeyUp="sinpuntitos2('valor','valorvl');return tabular(event,this);" value="<?php echo $_POST[valorvl]; ?>" style='text-align:right; width:60%;' style=""/>
                   		<input type="button" name="agregact" value="Agregar" onClick="agregardetalle()"><input type="hidden" name="agregadet"/>
                  	</td>
              	</tr>
			</table>
       		<?php
           	//***** busca tercero
				if($_POST[bt]=='1')
			 	{
			  		$nresul=buscatercero($_POST[tercero]);
			  		if($nresul!='')
			   		{
  						echo"
						<script>
							document.getElementById('ntercero').value='$nresul';
			  				document.getElementById('codingreso').focus();
							document.getElementById('codingreso').select();
						</script>";
			  		}
			 		else
			 		{
			  			echo"
			  			<script>
							document.getElementById('ntercero').value='';
							document.getElementById('valfocus').value='1';
							despliegamodalm('visible','2','Tercero Incorrecto o no Existe.');
			  			</script>";
			  		}
			 	}
			 	//*** ingreso
			 	if($_POST[bin]=='1')
			 	{
			  		$nresul=buscaingreso($_POST[codingreso]);
			  		if($nresul!='')
			   		{
  			  			echo"
			  			<script>
							document.getElementById('ningreso').value='$nresul';
			  				document.getElementById('cc').focus();
							document.getElementById('cc').select();
						</script>";
			  		}
			 		else
			 		{
			  			echo"
			  			<script>
							document.getElementById('ningreso').value='';
							document.getElementById('valfocus').value='2';
							despliegamodalm('visible','2','Codigo Ingresos Incorrecto.');
						</script>";
			  		}
			 	}
			?>      
     		<div class="subpantalla"  style="height:47.3%; width:99.4%; overflow-x:hidden;" id="divdet">
	   			<table class="inicio">
	   	   			<tr><td colspan="4" class="titulos">Detalle  Recaudos Transferencia</td></tr>                  
					<tr>
                    	<td class="titulos2" style="width:10%;">Codigo</td>
                        <td class="titulos2">Ingreso</td>
                        <td class="titulos2" style="width:15%;">Valor</td>
                        <td class="titulos2" style="width:5%;">Eliminar</td>
                  	</tr>
                    <input type='hidden' name='elimina' id='elimina'>
					<?php
						if ($_POST[oculto]=='3')
		 				{
		 					$posi=$_POST[elimina];
							unset($_POST[dcoding][$posi]);	
							unset($_POST[dncoding][$posi]);			 
							unset($_POST[dvalores][$posi]);			  		 
							$_POST[dcoding]= array_values($_POST[dcoding]); 		 
							$_POST[dncoding]= array_values($_POST[dncoding]); 		 		 
							$_POST[dvalores]= array_values($_POST[dvalores]); 		 		 		 		 		 
						}
						if ($_POST[agregadet]=='1')
						{
							$_POST[dcoding][]=$_POST[codingreso];
							$_POST[dncoding][]=$_POST[ningreso];			 		
							$_POST[dvalores][]=$_POST[valor];
							$_POST[agregadet]=0;
							echo"
		 					<script>
								document.form2.codingreso.value='';
								document.form2.ningreso.value='';	
								document.form2.valor.value='';	
								document.form2.valorvl.value='';				
								document.form2.codingreso.select();
								document.form2.codingreso.focus();	
							</script>";
		  				}
		  				$_POST[totalc]=0;
						$co="saludo1a";
		  				$co2="saludo2";
		 				for ($x=0;$x<count($_POST[dcoding]);$x++)
		 				{		 
		 					echo "
							<input type='hidden' name='dcoding[]' value='".$_POST[dcoding][$x]."'/>
							<input type='hidden' name='dncoding[]' value='".$_POST[dncoding][$x]."'/>
							<input type='hidden' name='dvalores[]' value='".$_POST[dvalores][$x]."'/>
							<tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\">
								<td>".$_POST[dcoding][$x]."</td>
								<td>".$_POST[dncoding][$x]."</td>
								<td style='text-align:right;'>$ ".number_format($_POST[dvalores][$x],2)."</td>
								<td style='text-align:center;'><a onclick='eliminar($x)'><img src='imagenes/del.png' style='cursor:pointer;'></a></td>
							</tr>";
		 					$_POST[totalc]=$_POST[totalc]+$_POST[dvalores][$x];
		 					$_POST[totalcf]=number_format($_POST[totalc],2);
							$totalg=number_format($_POST[totalc],2,'.','');
							$aux=$co;
							$co=$co2;
							$co2=$aux;
		 				}
						if ($_POST[totalc]!='' && $_POST[totalc]!=0){$_POST[letras] = convertirdecimal($totalg,'.');}
						else{$_POST[letras]=''; $_POST[totalcf]=0;}
		 				echo "
						<input type='hidden' name='totalcf' value='$_POST[totalcf]'>
						<input type='hidden' name='totalc' value='$_POST[totalc]'>
						<input type='hidden' name='letras' value='$_POST[letras]'>
						<tr class='$co' style='text-align:right;'>
							<td colspan='2'>Total:</td>
							<td>$ $_POST[totalcf]</td>
							<td></td>
						</tr>
						<tr class='titulos2'>
							<td >Son:</td>
							<td colspan='3' >$_POST[letras]</td>
						</tr>";
					?> 
	  			</table>
        	</div>
	  		<?php
				if($_POST[oculto]=='2')
				{
					$sqlr="select count(*) from tesorecaudotransferenciaprivado where id=$_POST[idcomp]";
					$res=mysql_query($sqlr,$linkbd);
					//echo $sqlr;
					while($r=mysql_fetch_row($res)){$numerorecaudos=$r[0]; }
	  				if($numerorecaudos==0)
	   				{ 	
 						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
						$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
						//*********************CREACION DEL COMPROBANTE CONTABLE ***************************
						//***busca el consecutivo del comprobante contable
						$consec=0;
						$sqlr="select max(numerotipo) from comprobante_cab where tipo_comp='37' ";
						$res=mysql_query($sqlr,$linkbd);
						while($r=mysql_fetch_row($res)){$consec=$r[0];}
	 					$consec=$_POST[idcomp];
						//***cabecera comprobante
						if($_POST[causacion]=='2'){$_POST[concepto]="ESTE DOCUMENTO NO REQUIERE CAUSACION CONTABLE - ".$_POST[concepto];}
				 		$sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($consec,37,'$fechaf','".strtoupper($_POST[concepto])."',0,$_POST[totalc],$_POST[totalc],0,'1')";
						mysql_query($sqlr,$linkbd);
						$idcomp=mysql_insert_id();
						echo "<input type='hidden' name='ncomp' value='$idcomp'>";
						if($_POST[causacion]!='2')
						{
							//******************* DETALLE DEL COMPROBANTE CONTABLE *********************
							for($x=0;$x<count($_POST[dcoding]);$x++)
	 						{
		 						//***** BUSQUEDA INGRESO ********
								$sqlri="Select * from tesoingresos_det where codigo='".$_POST[dcoding][$x]."'  and vigencia=$vigusu";
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
		 							$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='$rowi[2]' and tipo='C' and fechainicial='".$_POST[fechacausa]."'";
	 	 							$resc=mysql_query($sqlrc,$linkbd);	  
									while($rowc=mysql_fetch_row($resc))
		 							{
			  							$porce=$rowi[5];
			 							if($_POST[cc]==$rowc[5])
			 							{
											if($rowc[3]=='N')
			  								{				
			   									if($rowc[7]=='S')
			   									{
                                                    
                                                    $valorcred = $_POST[dvalores][$x] * ($porce / 100);
                                                    $valordeb = 0;

                                                    $sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('37 $consec','".$rowc[4]."','".$_POST[tercero]."','".$_POST[cc]."','Recaudo Transferencia".strtoupper($_POST[dncoding][$x])."','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
                                                    mysql_query($sqlr,$linkbd); 
                                                    
                                                    $sqlr = "insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('37 $consec','" . $_POST[banco] . "','" . $_POST[tercero] . "','" . $_POST[cc] . "','Recaudo Transferencia" . strtoupper($_POST[dncoding][$x]) . "',''," . $valorcred . "," . $valordeb . ",'1','" . $_POST[vigencia] . "')";
                                                    mysql_query($sqlr, $linkbd);
			   									}
			  								}			   
										}
		 							}
		 						}
	 						}
						}	
						//************ insercion de cabecera recaudos ************
						$sqlr="insert into tesorecaudotransferenciaprivado (idcomp,fecha,vigencia,banco,ncuentaban,concepto,tercero,cc,valortotal, estado,medio_pago) values($idcomp,'$fechaf','".$_POST["vigencia"]."','$_POST[ter]','$_POST[cb]','".strtoupper($_POST[concepto])."','$_POST[tercero]','$_POST[cc]','$_POST[totalc]','S','$_POST[medioDePago]')";	  
						mysql_query($sqlr,$linkbd);
						$idrec=mysql_insert_id();
						//************** insercion de consignaciones **************
						for($x=0;$x<count($_POST[dcoding]);$x++)
	 					{
							$sqlr="insert into tesorecaudotransferenciaprivado_det (id_recaudo,ingreso,valor,estado) values($idrec,'".$_POST[dcoding][$x]."',".$_POST[dvalores][$x].",'S')";	  
							if (!mysql_query($sqlr,$linkbd))
							{
	 							$e =mysql_error(mysql_query($sqlr,$linkbd));
                        		echo"<script>despliegamodalm('visible','2','No se pudo ejecutar la petici�n: $e');</script>";
							}
  							else{
								  echo"<script>despliegamodalm('visible','1','Se ha almacenado el Recaudo con Exito');</script>";
								}
						}	 
	  				}
	   				else {echo"<script>despliegamodalm('visible','2','Ya Existe un Recibo con este numero');</script>";}
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