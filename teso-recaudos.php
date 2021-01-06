<?php //V 1000 12/12/16 ?> 
<?php
	require "comun.inc";
	require "funciones.inc";
	require "conversor.php";
	//session_start();
	sesion();
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
			function agregardetalle()
			{
				if(document.form2.codingreso.value!="" &&  document.form2.valor.value!="")
				{ 
					document.form2.agregadet.value=1;
					document.form2.submit();
				}
 				else {despliegamodalm('visible','2','Falta informacion para poder Agregar');}
			}
			function eliminar(variable)
			{
				document.form2.elimina.value=variable;
				despliegamodalm('visible','4','Esta Seguro de Eliminar','2');
			}
			function guardar()
			{
				
				ingresos2=document.getElementsByName('dcoding[]');
				
				var validacion00=document.form2.concepto.value;
				if (document.form2.fecha.value!='' && ingresos2.length>0 && validacion00.trim()!='' && document.form2.ntercero.value!='')
  				{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
  				else
				{
  					despliegamodalm('visible','2','Faltan datos para completar el registro');
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
			function despliegamodal2(_valor,_tip)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else 
				{
					if(_tip=='1')
					{document.getElementById('ventana2').src="tercerosgral-ventana01.php?objeto=tercero&nobjeto=ntercero&nfoco=codingreso";}
					else
					{document.getElementById('ventana2').src="ingresos-ventana01.php?ti=I&modulo=4";}
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
						case "1":	document.getElementById('valfocus').value='0';
									document.getElementById('ntercero').value='';
									document.getElementById('tercero').select();
									document.getElementById('tercero').focus();
									break;
						case "2":	document.getElementById('valfocus').value='0';
									document.getElementById('ningreso').value='';
									document.getElementById('codingreso').select();
									document.getElementById('codingreso').focus();
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
				document.location.href = "teso-editarecaudos.php?idrecaudo="+numdocar;
			}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.form2.oculto.value=2;
								document.form2.submit();
								document.form2.action="pdfcdp.php";
								break;
					case "2": 	document.form2.oculto.value="3";
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
					<a onClick="location.href='teso-recaudos.php'" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
					<a class="mgbt" onClick="guardar()"><img src="imagenes/guarda.png" title="Guardar"/></a>
					<a onClick="location.href='teso-buscarecaudos.php'"  class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a class="mgbt" onClick="<?php echo paginasnuevas("teso");?>"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
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
        	<input type="hidden" name="valfocus" id="valfocus" value="0"/>
			<?php
                $vigencia=date(Y);
                $vigusu=vigencia_usuarios($_SESSION[cedulausu]);
                //*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
                if($_POST[oculto]=="")
                {
                    $_POST[dcoding]= array(); 		 
                    $_POST[dncoding]= array(); 		 
                    $_POST[dvalores]= array();
                    $check1="checked";
                    $fec=date("d/m/Y");
                    $_POST[vigencia]=$vigusu;
                    $sqlr="select * from cuentacaja where estado='S' and vigencia=".$vigusu;
                    $res=mysql_query($sqlr,$linkbd);
                    while ($row =mysql_fetch_row($res)) {$_POST[cuentacaja]=$row[1];}
                    /*$sqlr="select valor_inicial,valor_final, tipo from dominios where nombre_dominio='COBRO_RECIBOS' AND descripcion_valor='$vigusu' and  tipo='S'";	
                    $res=mysql_query($sqlr,$linkbd);
                    while ($row =mysql_fetch_row($res)) 
                    {
                         $_POST[cobrorecibo]=$row[0]; 
                         $_POST[vcobrorecibo]=$row[1];
                         $_POST[tcobrorecibo]=$row[2];	 
                        // echo $sqlr;
                    }
                    if($_POST[tcobrorecibo]=='S')
                    {	 
                        $_POST[dcoding][]=$_POST[cobrorecibo];
                        $_POST[dncoding][]=buscaingreso($_POST[cobrorecibo])." ".$vigusu;			 		
                        $_POST[dvalores][]=$_POST[vcobrorecibo];
                        // echo $sqlr;
                     }*/
                    /*$sqlr="select max(numerotipo) from comprobante_cab where tipo_comp='2' and EXTRACT(YEAR FROM fecha)=".$_SESSION["vigencia"];
                    $res=mysql_query($sqlr,$linkbd);
                    $consec=0;
                    while($r=mysql_fetch_row($res)){$consec=$r[0];}
                    $consec+=1;*/
                    $sqlr="select max(id_recaudo) from tesorecaudos ";
                    $res=mysql_query($sqlr,$linkbd);
                    $consec=0;
                    while($r=mysql_fetch_row($res)){$consec=$r[0];}
                    $consec+=1;
                    $_POST[idcomp]=$consec;	
                    $fec=date("d/m/Y");
                    $_POST[fecha]=$fec; 		 		  			 
                    $_POST[valor]=0;
                    $_POST[ivaGravado] = '';
                }
 				//***** busca tercero
			 	if($_POST[bt]=='1')
			 	{
			  		$nresul=buscatercero($_POST[tercero]);
			  		if($nresul!=''){$_POST[ntercero]=$nresul;}
				 	else{$_POST[ntercero]="";}
			 	}
				//******** busca ingreso *****
				//***** busca tercero
			 	if($_POST[bin]=='1')
			 	{
			  		$nresul=buscaingreso($_POST[codingreso]);
			  		if($nresul!='')
			   		{
			 			$_POST[ningreso]=$nresul;
  			  			$_POST[valor]=buscaingreso_valor($_POST[codingreso]);
  			  			$_POST[ivaGravado] = buscaingreso_gravado($_POST[codingreso]);
			  		}
			 		else
			 		{
			  			$_POST[ningreso]="";
  			  			$_POST[valor]="";
  			  			$_POST[ivaGravado] = '';
			 		}
			 	}
			?>
    		<table class="inicio" style="width:99.7%">
      			<tr >
        			<td class="titulos" colspan="9">Liquidar Recaudos</td>
        			<td class="cerrar" style="width:7%"><a onClick="location.href='teso-principal.php'">&nbsp;Cerrar</a></td>
      			</tr>
      			<tr>
       		 		<td class="saludo1" style="width:12%;">N&uacute;mero Liquidaci&oacute;n:</td>
        			<td style="width:15%;"><input type="text"  name="idcomp" id="idcomp" value="<?php echo $_POST[idcomp]?>" onKeyUp="return tabular(event,this)" style="width:80%;" readonly/></td>
	  				<td class="saludo1" style="width:2.5cm;">Fecha:</td>
        			<td style="width:20%;">
                    	<input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY"  value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this)" onKeyDown="mascara(this,'/',patron,true)" maxlength="10" style="width:80%;"/>&nbsp;<a onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/calendario04.png" style="width:20px; cursor:pointer"/></a>
                   	</td>
         			<td class="saludo1" style="width:1.5cm;">Vigencia:</td>
		  			<td style="width:10%;"><input type="text" id="vigencia" name="vigencia" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[vigencia]?>" onClick="document.getElementById('tipocta').focus();document.getElementById('tipocta').select();" style="width:70%;" readonly/></td>
        		</tr>
      			<tr>
        			<td class="saludo1">Concepto Liquidaci&oacute;n:</td>
        			<td colspan="8" ><input type="text" name="concepto" id="concepto" value="<?php echo $_POST[concepto]?>"  onKeyUp="return tabular(event,this)" style="width:100%;"/></td>
              	</tr>  
      			<tr>
        			<td class="saludo1">Documento: </td>
        			<td><input  type="text" name="tercero" id="tercero" value="<?php echo $_POST[tercero]?>" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" style="width:80%;" />&nbsp;<a onClick="despliegamodal2('visible','1');" title="Listado Terceros"><img src="imagenes/find02.png" style="width:20px;cursor:pointer;"/></a></td>
			  		<td class="saludo1">Contribuyente:</td>
	  				<td colspan="6">
                		<input type="text" id="ntercero" name="ntercero" value="<?php echo $_POST[ntercero]?>" onKeyUp="return tabular(event,this)" style="width:100%;" readonly>
                        <input type="hidden" value="0" name="bt"/>
                        <input type="hidden" id="cb" name="cb" value="<?php echo $_POST[cb]?>"/>
                        <input type="hidden" id="ct" name="ct" value="<?php echo $_POST[ct]?>"/>
                        <input type="hidden" name="oculto" id="oculto" value="1"/>
                        <input type="hidden" name="cobrorecibo" value="<?php echo $_POST[cobrorecibo]?>" >
                        <input type="hidden" name="vcobrorecibo" value="<?php echo $_POST[vcobrorecibo]?>" >
                        <input type="hidden" name="tcobrorecibo" value="<?php echo $_POST[tcobrorecibo]?>" > 
					</td>
      			</tr>
	  			<tr>
                    <td class="saludo1">Cod Ingreso:</td>
                    <td ><input type="text" id="codingreso" name="codingreso" value="<?php echo $_POST[codingreso]?>" onKeyUp="return tabular(event,this)" onBlur="buscaing(event)" style="width:80%;">&nbsp;<a onClick="despliegamodal2('visible','2');" title="Listado de Ingresos"><img src="imagenes/find02.png" style="width:20px;cursor:pointer;"/></a>
					<input type="hidden" id="bin" value="<?php echo $_POST[bin] ?>" name="bin"></td>
                    <td colspan="2"><input type="text" name="ningreso" id="ningreso" value="<?php echo $_POST[ningreso]?>" style="width:100%;" readonly></td>
					<?php 
					if($_POST[valor]>0)
					{
					?>
						<td class="saludo1">Cantidad:</td>
						<td>
                            <input type="hidden" id="valor" name="valor" value="<?php echo $_POST[valor]?>" >
                            <input type="text" name="valorcant" id="valorcant" value="<?php echo $_POST[valorcant]; ?>" style='width:98%;text-align:right;' />
                        </td>
                            <?php
                                if($_POST[ivaGravado] == 'S')
                                {
                                    ?>
                                    <td class="saludo1">Porcentaje iva:</td>
                                    <td>
                                        <input type="hidden" id="ivaGravado" name="ivaGravado" value="<?php echo $_POST[ivaGravado] ?>">
                                        <input type="text" id="porcentaje" name="porcentaje" value="<?php $_POST[porcentaje] ?>">
                                    </td>
                                    <?php
                                }
					}
					else
					{
					?>
                        <td class="saludo1">Valor:</td>
                        <td>
                            <input type="hidden" id="valor" name="valor" value="<?php echo $_POST[valor]?>" >
                            <input type="text" name="valorvl" id="valorvl" data-a-sign="$" data-a-dec="<?php echo $_SESSION["spdecimal"];?>" data-a-sep="<?php echo $_SESSION["spmillares"];?>" data-v-min='0' onKeyUp="sinpuntitos2('valor','valorvl');return tabular(event,this);" value="<?php echo $_POST[valorvl]; ?>" style='width:98%;text-align:right;' />
                        </td>
                        <?php
                        if($_POST[ivaGravado] == 'S')
                        {
                            ?>
                            <td class="saludo1">Porcentaje iva:</td>
                            <td>
                                <input type="hidden" id="ivaGravado" name="ivaGravado" value="<?php echo $_POST[ivaGravado] ?>">
                                <input type="text" id="porcentaje" name="porcentaje" value="<?php $_POST[porcentaje] ?>">
                            </td>
                            <?php
                        }
					}
					?>
                    <td><input  type="button" name="agregact" value="Agregar" onClick="agregardetalle()"><input type="hidden" value="0" name="agregadet"></td>
          		</tr>
			</table>
			<?php
                if($_POST[bt]=='1')//***** busca tercero
                {
                    $nresul=buscatercero($_POST[tercero]);
                    if($nresul!='')
                    {
                        $_POST[ntercero]=$nresul;
                        echo" 
                        <script> 
                            document.getElementById('codingreso').focus();
                            document.getElementById('codingreso').select();
                        </script>";
                    }
                    else
                    {
                        $_POST[ntercero]="";
                        echo"
                        <script>
                            document.getElementById('valfocus').value='1';
                            despliegamodalm('visible','2','Tercero Incorrecto');			   		  	
                        </script>";
                    }
                 }
                 if($_POST[bin]=='1')//*** ingreso
                 {
                    $nresul=buscaingreso($_POST[codingreso]);
                    if($nresul!='')
                    {
                        $_POST[ningreso]=$nresul;
						$_POST[valor]=buscaingreso_valor($_POST[codingreso]);
                        echo"
						<script>
                            document.getElementById('valorvl').focus();
							document.getElementById('valorvl').select();
							document.getElementById('valor').value='".$_POST[valor]."';
							document.getElementById('bin').value='0';
                        </script>";
                    }
                    else
                    {
                        $_POST[codingreso]="";
                        echo"
                        <script>
                            document.getElementById('valfocus').value='2';
                            despliegamodalm('visible','2','Codigo Ingresos Incorrecto');
                        </script>";
                    }
                }
            ?>
            <div class="subpantallac7" style="height:56.3%; width:99.5%; overflow-x:hidden;">
                <table class="inicio">
                    <tr><td colspan="4" class="titulos">Detalle Liquidaci&oacute;n Recaudos </td></tr>                  
                    <tr>
                        <td class="titulos2" style="width:10%">Codigo</td>
                        <td class="titulos2">Ingreso</td>
                        <td class="titulos2" style="width:15%">Valor</td>
                        <td class="titulos2" style="width:5%">Eliminar</td>
                        <input type='hidden' name='elimina' id='elimina'/>
                 	</tr>
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
								if($_POST[valorcant]>0)
								{
									$_POST[valor]=$_POST[valor]*$_POST[valorcant];
								}
                                $valorIvaGravado = 0;
                                if($_POST[porcentaje] > 0)
                                {
                                    $valorIvaGravado = round(($_POST[valor] * ($_POST[porcentaje] / 100)), 0);
                                    $_POST[valor] = $_POST[valor] - $valorIvaGravado;
                                }
								
                                $_POST[dcoding][]=$_POST[codingreso];
                                $_POST[dncoding][]=$_POST[ningreso];	
                                //$_POST[valor]=str_replace(".","",$_POST[valor]);		 		
                                $_POST[dvalores][]=$_POST[valor];

                                if($_POST[porcentaje] > 0)
                                {
                                    $_POST[dcoding][]='P08';
                                    $_POST[dncoding][]='IVA GRAVADO';
                                    $_POST[dvalores][]=$valorIvaGravado;
                                    $_POST[porcentaje] = 0;
                                }
                                $_POST[agregadet]=0;
                                echo"
                                <script>
                                    //document.form2.cuenta.focus();	
                                    document.form2.codingreso.value='';
                                    document.form2.valor.value='';	
                                    document.form2.ningreso.value='';
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
								$_POST[totalcf]=number_format($_POST[totalc],2,'.','');
								$totalg=number_format($_POST[totalc],2,'.','');
								$aux=$co;
								$co=$co2;
								$co2=$aux;
                            }
                            //$resultado = convertir((int)$_POST[totalc]);
							if ($_POST[totalc]!='' && $_POST[totalc]!=0){$_POST[letras] = convertirdecimal($totalg,'.');}
							else{$_POST[letras]=''; $_POST[totalcf]=0;}
                            echo "
                            <input type='hidden' name='totalcf' value='$_POST[totalcf]'/>
                            <input type='hidden' name='totalc' value='$_POST[totalc]'/>
                            <input type='hidden' name='letras' value='$_POST[letras]'/>
                            <tr class='$co' style='text-align:right;'>
                                <td colspan='2'>Total</td>
                                <td>$ $_POST[totalcf]</td>
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
 					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
					$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
					$bloq=bloqueos($_SESSION[cedulausu],$fechaf);	
					if($bloq>=1)
					{
						//*********************CREACION DEL COMPROBANTE CONTABLE ***************************
						//***busca el consecutivo del comprobante contable
						$consec=0;
						$sqlr="select max(id_recaudo) from tesorecaudos" ;
						//echo $sqlr;
						$res=mysql_query($sqlr,$linkbd);
						while($r=mysql_fetch_row($res)){$consec=$r[0];}
	 					$consec+=1;
						//***cabecera comprobante
	 					$sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($consec,2,'$fechaf','".strtoupper($_POST[concepto])."',0,$_POST[totalc],$_POST[totalc],0,'1')";
						mysql_query($sqlr,$linkbd);
						$idcomp=mysql_insert_id();
						echo "<input type='hidden' name='ncomp' value='$idcomp'>";
						//******************* DETALLE DEL COMPROBANTE CONTABLE *********************
                        $cuentaCredito = '';
						for($x=0;$x<count($_POST[dcoding]);$x++)
	 					{
		 					//***** BUSQUEDA INGRESO ********
							$sqlri="Select * from tesoingresos_det where codigo='".$_POST[dcoding][$x]."' and vigencia=$vigusu";
	 						$resi=mysql_query($sqlri,$linkbd);
								// echo "$sqlri <br>";	    
							while($rowi=mysql_fetch_row($resi))
		 					{
	    						//**** busqueda concepto contable*****
								$sq="select fechainicial from conceptoscontables_det where codigo=".$rowi[2]." and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
								$re=mysql_query($sq,$linkbd);
								// echo "con: $sq <br>";
								while($ro=mysql_fetch_assoc($re))
								{
									$_POST[fechacausa]=$ro["fechainicial"];
								}
		 						$sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo=".$rowi[2]." and tipo='C' and fechainicial='".$_POST[fechacausa]."'";
	 	 						$resc=mysql_query($sqlrc,$linkbd);	  
		 							// echo "con: $sqlrc <br>";	      
								while($rowc=mysql_fetch_row($resc))
		 						{
			  						$porce=$rowi[5];
                                    $valorcred=0;
									if($rowc[6]=='S')
			  						{
										$valordeb=$_POST[dvalores][$x]*($porce/100);

                                        $cuentaCredito = $rowc[4];

			 						}
			  						else
			   						{
                                        if($_POST[dcoding][$x] == 'P08')
                                        {
                                            $valordeb=$_POST[dvalores][$x]*($porce/100);
                                            $sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito, estado,vigencia) values ('2 $consec','".$cuentaCredito."','".$_POST[tercero]."','".$rowc[5]."','Causacion ".strtoupper($_POST[dncoding][$x])."','',".$valordeb.",'0','1','".$_POST[vigencia]."')";
                                            mysql_query($sqlr,$linkbd);
                                        }

										$valorcred=$_POST[dvalores][$x]*($porce/100);
										$valordeb=0;				   
			   						}
									$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito, estado,vigencia) values ('2 $consec','".$rowc[4]."','".$_POST[tercero]."','".$rowc[5]."','Causacion ".strtoupper($_POST[dncoding][$x])."','',".$valordeb.",".$valorcred.",'1','".$_POST[vigencia]."')";
									mysql_query($sqlr,$linkbd);
									//echo "Conc: $sqlr <br>";
		 						}
							}
						}	
						//************ insercion de cabecera recaudos ************
						$sqlr="insert into tesorecaudos (id_comp,fecha,vigencia,tercero,valortotal,concepto,estado) values($idcomp,'$fechaf',".$vigusu.",'$_POST[tercero]','$_POST[totalc]','".strtoupper($_POST[concepto])."','S')";	  
						mysql_query($sqlr,$linkbd);
						$idrec=mysql_insert_id();
						
						//************** insercion de consignaciones **************
						for($x=0;$x<count($_POST[dcoding]);$x++)
	 					{
							$sqlr="insert into tesorecaudos_det (id_recaudo,ingreso,valor,estado) values($idrec,'".$_POST[dcoding][$x]."',".$_POST[dvalores][$x].",'S')";	  
							if (!mysql_query($sqlr,$linkbd))
							{
								$e =mysql_error(mysql_query($sqlr,$linkbd));
                                echo"<script>despliegamodalm('visible','2','No se pudo ejecutar la petici�n: $e');</script>";
							}
  							else {echo "<script>despliegamodalm('visible','1','Se ha almacenado el Recaudo con Exito');</script>";}
						}	 
	  				}
  					else {echo"<script>despliegamodalm('visible','2','No Tiene los Permisos para Modificar este Documento');</script>";}
  					//****fin if bloqueo   
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