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
        <script type="text/javascript" src="JQuery/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="JQuery/autoNumeric-master/autoNumeric-min.js"></script>
		<script>
			jQuery(function($){ $('#vltmindustria').autoNumeric('init');});
			function consultaciiu(e)
 			{
				if (document.form2.ciiu.value!="")
				{
 					document.form2.bci.value='1';
 					document.form2.submit();
				 }
 			}
			function buscacta(e)
 			{
				if (document.form2.cuenta.value!="")
				{
 					document.form2.bc.value='1';
 					document.form2.submit();
 				}
 			}
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
				if(document.form2.numero.value!="" &&  document.form2.valor.value>0 &&  document.form2.banco.value!=""  )
				{ 
					document.form2.agregadet.value=1;
					document.form2.submit();
 				}
 				else {alert("Falta informacion para poder Agregar");}
			}
			function eliminar(variable)
			{
				if (confirm("Esta Seguro de Eliminar"))
  				{
					document.form2.elimina.value=variable;
					document.form2.submit();
				}
			}
			
			function guardar()
			{
				if (document.form2.fecha.value!='' && document.form2.tercero.value!='')
				{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
				else
				{
					despliegamodalm('visible','2','Faltan datos para completar el registro');
					document.form2.fecha.focus();
					document.form2.fecha.select();
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
									document.getElementById('ncuenta').value='';
									document.getElementById('fuente').value='';
									document.getElementById('saldo').value=0;
									document.getElementById('cuenta').focus();
									document.getElementById('cuenta').select();
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
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.form2.oculto.value="2";
								document.form2.submit();
								document.form2.action="pdfcdp.php";
								break;
					case "2": 	document.form2.chacuerdo.value=2;
								document.form2.oculto.value="3";
								document.form2.submit();
								break;
				}
			}
			function funcionmensaje()
			{
				var numdocar=document.getElementById('idcomp').value;
				//var vigencar=document.getElementById('vigencia').value;
				document.location.href = "teso-industriaver.php?idrecaudo="+numdocar+"&scrtop=0&totreg=1&altura=432&numpag=1&limreg=10&filtro=#";
			}
			function pdf()
			{
				document.form2.action="teso-pdfindustria.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
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
					}
				}
			}
			function agregardetalled()
			{
				if(document.form2.ingreso.value!="" &&  document.form2.ciiu.value!=""  )
				{ 
					document.form2.agregadetdes.value=1;
					document.form2.submit();
 				}
 				else {alert("Falta informacion para poder Agregar");}
			}
			function eliminardact(variable)
			{
				if (confirm("Esta Seguro de Eliminar"))
  				{
					document.form2.eliminadac.value=variable;
					document.form2.submit();
				}
			}
			function agregardetalled2()
			{
				if(document.form2.ingreso.value!="" )
				{ 
					document.form2.agregadetdes.value=1;
					document.form2.submit();
 				}
 				else {alert("Falta informacion para poder Agregar");}
			}
			function eliminardact2(variable)
			{
				if (confirm("Esta Seguro de Eliminar"))
  				{
					document.form2.eliminadac.value=variable;
					document.form2.submit();
				}
			}
			function sumarindustria()
			{
				indus=document.getElementById('industria').value;
				avis=document.getElementById('avisos').value;
				retencion=document.getElementById('retenciones').value;
				sancion=document.getElementById('sanciones').value;
				bomber=document.getElementById('bomberil').value;
				valtot=document.getElementById('valortotal').value;
				interes=document.getElementById('intereses').value;
				saldopago=document.getElementById('saldopagar').value;
				antvigac=document.getElementById('antivigact').value;
				antvigan=document.getElementById('antivigant').value;
				desc=document.getElementById('descuento').value;
				desct=document.getElementById('descuentost').value;
				if(indus.trim()==''){document.getElementById('industria').value=0;}
				if(avis.trim()==''){document.getElementById('avisos').value=0;}
				if(retencion.trim()==''){document.getElementById('retenciones').value=0;}
				if(sancion.trim()==''){document.getElementById('sanciones').value=0;}
				if(bomber.trim()==''){document.getElementById('bomberil').value=0;}
				if(valtot.trim()==''){document.getElementById('valortotal').value=0;}
				if(interes.trim()==''){document.getElementById('intereses').value=0;}
				if(saldopago.trim()==''){document.getElementById('saldopagar').value=0;}
				if(antvigac.trim()==''){document.getElementById('antivigact').value=0;}
				if(antvigan.trim()==''){document.getElementById('antivigant').value=0;}
				if(desc.trim()==''){document.getElementById('descuento').value=0;}
				if(desct.trim()==''){document.getElementById('descuentost').value=0;}
				document.getElementById('descuenindus').value=(parseFloat(indus)*(parseFloat(desc)/100));
				document.getElementById('descuenaviso').value=(parseFloat(avis)*(parseFloat(desc)/100));
				descuento=(parseFloat(indus)*(parseFloat(desc)/100));
				descuento=descuento+(parseFloat(avis)*(parseFloat(desc)/100));
				document.getElementById('descuentost').value=descuento;
				acum=parseFloat(indus)-descuento+parseFloat(antvigac)-parseFloat(antvigan)+parseFloat(avis)-parseFloat(retencion)+parseFloat(sancion)+parseFloat(bomber)+parseFloat(valtot)+parseFloat(interes);
				acumhp=Math.round(acum/1000);
				acum=acumhp*1000;
				if(acumhp!=acum/1000){acumhp++;}
				if(acum<0)
				{
					document.getElementById('saldopagar').value=0;
					document.getElementById('saldofavor').value=(parseFloat(acum)*-1);
				}
				if(acum>=0)
				{
					document.getElementById('saldopagar').value=(parseFloat(acum));
					document.getElementById('saldofavor').value=0;
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
					<a><img src="imagenes/add.png" title="Nuevo" class="mgbt" onClick="location.href='teso-industria.php'"/></a>
					<a><img src="imagenes/guarda.png" title="Guardar" class="mgbt" onClick="guardar()"/></a>
					<a><img src="imagenes/busca.png" title="Buscar" class="mgbt" onClick="location.href='teso-buscaindustria.php'"/></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a><img src="imagenes/nv.png" title="Nueva Ventana" class="mgbt" onClick="<?php echo paginasnuevas("teso");?>"/></a>
					<a><img src="imagenes/print.png" title="Imprimir" class="mgbt" onClick="pdf()"/></a>
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
                $vigencia=$vigusu;
                //*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
                if(!$_POST[oculto])
                {
                    $check1="checked";
                    $chkav=" ";
                    $fec=date("d/m/Y");
                    $_POST[vigencia]=$vigencia;
                    $_POST[ageliquida]=$vigencia;
                    $_POST[industria]=0;
                    $_POST[avisos]=0;
                    $_POST[sanciones]=0;
                    $_POST[retenciones]=0;
                    $_POST[bomberil]=0;		
                    $_POST[valortotal]=0;	
                    $_POST[intereses]=0;	
                    $_POST[antivigact]=0;
                    $_POST[antivigant]=0;
                    $_POST[saldopagar]=0;	
					$_POST[descuento]=0;
					$_POST[descuentost]=0;
					$_POST[acbom]='S';
                    $sqlr="select valor_inicial from dominios where nombre_dominio='CUENTA_CAJA'";
                    $res=mysql_query($sqlr,$linkbd);
                    while ($row =mysql_fetch_row($res)){$_POST[cuentacaja]=$row[0];}
                    $sqlr="select tmindustria from tesoparametros";
                    $res=mysql_query($sqlr,$linkbd);
                    while ($row =mysql_fetch_row($res)){$_POST[salariomin]=$row[0];}
                    $consec=selconsecutivo("tesoindustria","id_industria");
                    $_POST[idcomp]=$consec;	
                    $fec=date("d/m/Y");
                    $_POST[fecha]=$fec; 		 		  			 
                    $_POST[valor]=0;		 
                }
                switch($_POST[tabgroup1])
                {
                    case 1:	$check1='checked';break;
                    case 2:	$check2='checked';break;
                    case 3:	$check3='checked';
                }
                if($_POST[sinavisos]==1){$chkav=" checked ";}
                else {$chkav=" ";}
                if($_POST[bt]=='1')//***** busca tercero
                {
                    $nresul=buscatercero($_POST[tercero]);
                    if($nresul!=''){$_POST[ntercero]=$nresul;}
                    else {$_POST[ntercero]="";}
                }
                if($_POST[bci]=='1')
                {
                    $sqlr="select *from codigosciiu where codigosciiu.codigo='$_POST[ciiu]'";
                    $res=mysql_query($sqlr,$linkbd);
                    $row=mysql_fetch_row($res);
                    $nresul=$row[1];			  	  
                    if($nresul!='')
                    {
                        $_POST[nciiu]=$nresul;
                        $_POST[tciiu]=$row[2];  			
                    }
                    else
                    {
                        $_POST[nciiu]="";
                        $_POST[tciiu]="";
                    }
                }
            ?>
            <div class="tabsic">
                <div class="tab">
                    <input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
                    <label for="tab-1">Base</label>
                    <div class="content">
                        <table class="inicio" align="center" >
                            <tr >
                                <td class="titulos" colspan="12">Liquidar Industria y Comercio</td>
                                <td class="cerrar" style="width:7%;"><a onClick="location.href='teso-principal.php'">&nbsp;Cerrar</a></td>
                            </tr>
                            <tr>
                                <td class="saludo1" >N&uacute;mero:</td>
                                <td>
                                    <input name="salariomin" type="hidden" size="5" value="<?php echo $_POST[salariomin]?>" >
                                    <input name="idcomp" id="idcomp" type="text" size="5" value="<?php echo $_POST[idcomp]?>" onKeyUp="return tabular(event,this) "  readonly>
                                </td>
                                <td class="saludo1">Fecha:</td>
                                <td><input  type="text" name="fecha" value="<?php echo $_POST[fecha]?>" maxlength="10" size="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" readonly>&nbsp;<img src="imagenes/calendario04.png" class="icoop" onClick="displayCalendarFor('fc_1198971545');"/></td>
                                <td width="116" class="saludo1" >Tipo:</td>
                                <td width="110" >
                                    <select name="tipomov" id="tipomov" onKeyUp="return tabular(event,this)" >
                                        <option value="2" <?php if($_POST[tipomov]=='2') echo "SELECTED"; ?>>Normal</option>
                                        <option value="3" <?php if($_POST[tipomov]=='3') echo "SELECTED"; ?>>Correccion</option>
                                        <option value="4" <?php if($_POST[tipomov]=='4') echo "SELECTED"; ?>>Clausura</option>
                                        <option value="5" <?php if($_POST[tipomov]=='5') echo "SELECTED"; ?>>Vigencia Anterior</option>
                                    </select>
                                </td>  
                                <td width="92" class="saludo1">Año Liquidar:</td>
                                <td width="42">
                                    <input type="text" id="ageliquida" name="ageliquida" size="4" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  value="<?php echo $_POST[ageliquida]?>" onClick="document.getElementById('tipocta').focus(); document.getElementById('tipocta').select();" maxlength="4" >      
                                    <input type="hidden" id="vigencia" name="vigencia" value="<?php echo $_POST[vigencia]?>" >
                                </td>
                                <td class="saludo1">Cuotas:</td>
                                <td>
                                    <select name="ncuotas" id="ncuotas" onKeyUp="return tabular(event,this)" >
                                        <option value="1" <?php if($_POST[ncuotas]=='1') echo "SELECTED"; ?>>1</option>
                                        <option value="2" <?php if($_POST[ncuotas]=='2') echo "SELECTED"; ?>>2</option> 
                                    </select>
                                </td>
                                 <td class="saludo1">Bomberil:</td>
                                <td>
                                    <select name="acbom" id="acbom" onKeyUp="return tabular(event,this)" >
                                    	<option value="S" <?php if($_POST[acbom]=='S') echo "SELECTED"; ?>>Automatica</option> 
                                        <option value="N" <?php if($_POST[acbom]=='N') echo "SELECTED"; ?>>Manual</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="saludo1">NIT/Cedula: </td>
                                <td style="width:10%">
									<input id="tercero" type="text" name="tercero" style="width:80%" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo $_POST[tercero]?>">&nbsp;<img src="imagenes/find02.png" class="icoop" onClick="despliegamodal2('visible','2')"/></td>
                                <td class="saludo1">Contribuyente:</td>
                                <td>
                                    <input type="text" id="ntercero" name="ntercero" value="<?php echo $_POST[ntercero]?>" size="50" onKeyUp="return tabular(event,this) "  readonly>
                                    <input type="hidden" value="0" name="bt"><input type="hidden" id="cb" name="cb" value="<?php echo $_POST[cb]?>" ><input type="hidden" id="ct" name="ct" value="<?php echo $_POST[ct]?>" >	  
                                    <input type="hidden" name="oculto" id="oculto" value="1">
                                </td>	 
                                <td class="saludo1" width="30px">Ing Gravables:</td>
                                <td style="10%">
									<input type="text" id="ingreso" name="ingreso" style="100%" value="<?php echo $_POST[ingreso]?>" onKeyUp="return tabular(event,this)" ></td>
                                <td class="saludo1">Acti Economica:</td>
                                <td colspan="2">
                                    <input type="text" name="ciiu" value="<?php echo $_POST[ciiu]?>" size="5" onKeyUp="return tabular(event,this) " onBlur="consultaciiu()">
                                    <input type="hidden" name="tciiu" value="<?php echo $_POST[tciiu]?>" >
                                    <input type="hidden" name="nciiu" value="<?php echo $_POST[nciiu]?>" > 
                                    <input type="hidden" value="0" name="bci">&nbsp;<img src="imagenes/find02.png" class="icoop" onClick="mypop=window.open('ciiu-ventana.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=900,height=500px');mypop.focus();">
                                </td>
                                <td colspan="1"><span class="saludo3"><input type="checkbox" name="sinavisos" value="1" <?php echo $chkav;?> onClick="validar()">Sin Avisos</span></td>
                                <td colspan="1">
                                    <input  type="button" name="agregact" id="agregact" value="Agregar" onClick="agregardetalled()"/>
                                    <input type="hidden" value="0" name="agregadetdes"/>
                                    <input type='hidden' name='eliminadac' id='eliminadac'/>
                                     <input type="hidden" value="0" name="agregadetdes2"/>
                                    <input type='hidden' name='eliminadac2' id='eliminadac2'/>
                                </td>
                            </tr>
                        </table>
                        <?php 	
                            if ($_POST[eliminadac]!='')
                            { 
                                $posi=$_POST[eliminadac];
                                 unset($_POST[dciiu][$posi]);
                                 unset($_POST[dnciiu][$posi]);
                                 unset($_POST[dtarifas][$posi]);
                                 unset($_POST[dingresoact][$posi]);
                                 unset($_POST[dvalores][$posi]);		 
                                 $_POST[dciiu]= array_values($_POST[dciiu]); 
                                 $_POST[dnciiu]= array_values($_POST[dnciiu]); 
                                 $_POST[dtarifas]= array_values($_POST[dtarifas]); 
                                 $_POST[dingresoact]= array_values($_POST[dingresoact]); 		 
                                 $_POST[dvalores]= array_values($_POST[dvalores]); 		 		 
                            }	 
                            if ($_POST[agregadetdes]=='1')
                            {
                                $_POST[dciiu][]=$_POST[ciiu];
                                $_POST[dnciiu][]=$_POST[nciiu];
                                $_POST[dtarifas][]=$_POST[tciiu];
                                $_POST[dingresoact][]=$_POST[ingreso];
                                $_POST[dvalores][]=($_POST[tciiu]/1000)*$_POST[ingreso];
                                echo"
                                <script>
                                    document.form2.tciiu.value=0;
                                    document.form2.ciiu.value='';	
                                    document.form2.nciiu.value='';	
                                    document.form2.ingreso.value=0;			
                                </script>";
                            }
                            if($_POST[bt]=='1')//***** busca tercero
                            {
                                $nresul=buscatercero($_POST[tercero]);
                                if($nresul!='')
                                {
                                    $_POST[ntercero]=$nresul;
                                    echo"
                                    <script>
                                        document.getElementById('ingreso').focus();
                                        document.getElementById('ingreso').select();
                                    </script>";
                                }
                                else
                                {
                                    $_POST[ntercero]="";
                                    echo"
                                    <script>
                                        alert('Cuenta Incorrecta');
                                        document.form2.tercero.select();
                                        document.form2.tercero.focus();	
                                    </script>";
                                }
                            }
                            if($_POST[bci]=='1')
                            {
                                $sqlr="select *from codigosciiu where codigosciiu.codigo='$_POST[ciiu]'";
                                $res=mysql_query($sqlr,$linkbd);
                                $row=mysql_fetch_row($res);
                                $nresul=$row[1];			  	  
                                if($nresul!='')
                                {
                                    $_POST[nciiu]=$nresul;
                                    $_POST[tciiu]=$row[2];
                                    echo"
                                    <script>
                                        document.form2.nciiu.value='$nresul';
                                        document.form2.tciiu.value='$row[2]';
                                        document.getElementById('agregact').focus();
                                    </script>";
                                }
                                else
                                {
                                    $_POST[nciiu]="";
                                    echo"
                                    <script>
                                        alert('Codigo Ciiu Incorrecto');
                                        document.form2.ciiu.select();
                                        document.form2.ciiu.focus();	
                                    </script>";
                                }
                            }
                        ?>
                        <table class="inicio">
                            <tr>
                                <td class="titulos2">C&oacute;digo</td>
                                <td class="titulos2">Actividad</td>
                                <td class="titulos2">Ingreso Actividad</td>
                                <td class="titulos2">Tarifa x mil</td>
                                <td class="titulos2">Valor</td>
                                <td class="titulos2"><img src="imagenes/del.png"></td>
                            </tr>
                            <?php
                                $totaldes=0;
                                for ($x=0;$x<count($_POST[dciiu]);$x++)
                                {		 
                                    echo"
                                    <input type='hidden' name='dciiu[]' value='".$_POST[dciiu][$x]."'/>
                                    <input type='hidden' name='dnciiu[]' value='".$_POST[dnciiu][$x]."'/>
                                    <input type='hidden' name='dingresoact[]' value='".$_POST[dingresoact][$x]."'/>
                                    <input type='hidden' name='dtarifas[]' value='".$_POST[dtarifas][$x]."'/>
                                    <input type='hidden' name='dvalores[]' value='".$_POST[dvalores][$x]."'>
                                    <tr>
                                        <td class='saludo2'>".$_POST[dciiu][$x]."</td>
                                        <td class='saludo2'>".$_POST[dnciiu][$x]."</td>
                                        <td class='saludo2'>".$_POST[dingresoact][$x]."</td>
                                        <td class='saludo2'>".$_POST[dtarifas][$x]."</td>	 
                                        <td class='saludo2'>".$_POST[dvalores][$x]."</td>		 
                                        <td class='saludo2'><a href='#' onclick='eliminardact($x)'><img src='imagenes/del.png'></a></td>
                                    </tr>";
                                    $totaldes=$totaldes+($_POST[dvalores][$x]);
                                }		 
                                $_POST[industria]=(round((ceil(($totaldes)))/1000,0)*1000);
                                $minima=0;
                                if(($_POST[industria])<=($_POST[salariomin]))//****cuando hay valor minimo
                                {
                                    $_POST[industria]=$_POST[salariomin];
                                    $minima=1;
                                }
                            ?>
                        </table>
                    </div>
                </div>
                <div class="tab">
                    <input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?> >
                    <label for="tab-2">Sanciones</label>
                    <div class="content"> 
                        <table class="inicio" align="center" >
                            <tr >
                                <td class="titulos" colspan="8">Sanciones</td>
                                <td class="cerrar" style="width:7%;"><a onClick="location.href='teso-principal.php'">&nbsp;Cerrar</a></td>
                            </tr>
                            <tr>
                                <td class="saludo1">Sancion:</td>
                                <td>
                                    <select name="sancion" onChange="validar()" onKeyUp="return tabular(event,this)">
                                        <option value="">Seleccione ...</option>
                                        <?php
                                            $sqlr="select *from tesosanciones where estado='S'";
                                            $res=mysql_query($sqlr,$linkbd);
                                            while ($row =mysql_fetch_row($res)) 
                                            {
                                                if("$row[0]"==$_POST[sancion])
                                                {
                                                    echo "<option value='$row[0]' SELECTED>$row[1] - $row[2]</option>";
                                                    $_POST[porcentaje]=$row[4];
                                                    $_POST[nretencion]=$row[1]." - ".$row[2];
                                                    $_POST[vporcentaje]=($_POST[industria]*$_POST[porcentaje])/100;
                                                }
                                                else{echo "<option value='$row[0]'>$row[1] - $row[2]</option>";}
                                            }	 	
                                        ?>
                                    </select>
                                    <input type="hidden" value="<?php echo $_POST[nsancion]?>" name="nretencion">
                                </td>
                                <td class="saludo1">%</td>
                                <td><input id="porcentaje" name="porcentaje" type="text" size="5" value="<?php echo $_POST[porcentaje]?>" readonly>%</td>
                                <td class="saludo1">Valor:</td><td><input id="vporcentaje" name="vporcentaje" type="text" size="10" value="<?php echo $_POST[vporcentaje]?>" readonly></td>
                                <td class="saludo1">Total Sanciones:</td>
                                <td>
                                    <input id="totaldes" name="totaldes" type="text" size="10" value="<?php echo $_POST[totaldes]?>" readonly>
                                    <input type="button" name="agregard" id="agregard" value="   Agregar   " onClick="agregardetalled2()" ><input type="hidden" value="0" name="agregadetsan">
                                </td>
                            </tr>
                        </table>
                        <?php 		
                            if ($_POST[eliminadac2]!='')
                            { 
                                $posi=$_POST[eliminadac2];
                                 unset($_POST[ddescuentos][$posi]);
                                 unset($_POST[dndescuentos][$posi]);
                                 unset($_POST[dporcentajes][$posi]);
                                 unset($_POST[ddesvalores][$posi]);
                                 $_POST[ddescuentos]= array_values($_POST[ddescuentos]); 
                                 $_POST[dndescuentos]= array_values($_POST[dndescuentos]); 
                                 $_POST[dporcentajes]= array_values($_POST[dporcentajes]); 
                                 $_POST[ddesvalores]= array_values($_POST[ddesvalores]); 		 
                            }	 
                            if ($_POST[agregadetdes2]=='1')
                            {
                                $_POST[ddescuentos][]=$_POST[sancion];
                                $_POST[dndescuentos][]=$_POST[nsancion];
                                $_POST[dporcentajes][]=$_POST[porcentaje];
                                $_POST[ddesvalores][]=$_POST[vporcentaje];
                                $_POST[agregadetdes2]='0';
                                echo"
                                <script>
                                    document.form2.porcentaje.value=0;
                                    document.form2.vporcentaje.value=0;	
                                    document.form2.retencion.value='';	
                                </script>";
                            }
                        ?>
                        <table class="inicio">
                            <tr>
                                <td class="titulos">Sancion</td>
                                <td class="titulos">%</td>
                                <td class="titulos">Valor</td>
                                <td class="titulos2"><img src="imagenes/del.png" ><input type='hidden' name='eliminad' id='eliminad'></td>
                            </tr>
                            <?php
                                $totaldes=0;
                                for ($x=0;$x<count($_POST[ddescuentos]);$x++)
                                {		 
                                    echo"
                                    <input type='hidden' name='dndescuentos[]' value='".$_POST[dndescuentos][$x]."'/>
                                    <input type='hidden' name='ddescuentos[]' value='".$_POST[ddescuentos][$x]."'/>
                                    <input type='hidden' name='dporcentajes[]' value='".$_POST[dporcentajes][$x]."'/>
                                    <input type='hidden' name='ddesvalores[]' value='".(($_POST[dporcentajes][$x]*$_POST[valor])/100)."'/>
                                    <tr>
                                        <td class='saludo2'>".$_POST[dndescuentos][$x]."</td>
                                        <td class='saludo2'>".$_POST[dporcentajes][$x]."</td>
                                        <td class='saludo2'>".(($_POST[dporcentajes][$x]*$_POST[valor])/100)."</td>
                                        <td class='saludo2'><a href='#' onclick=' eliminardact($x)'><img src='imagenes/del.png'></a></td>
                                    </tr>";
                                    $totaldes=$totaldes+$_POST[ddesvalores][$x];
                                }		 
                                echo"
                                <script>
                                    document.form2.totaldes.value='".ceil($totaldes)."';	
                                    calcularpago();
                                </script>";
                            ?>
                        </table>
                    </div>
                </div>       
            </div>
            <table class="inicio">
                <tr>
                    <td colspan="8" class="titulos">Liquidacion Privada</td>
               </tr>          
                <?php
                    //*************BUSCAR EL CONCEPTO CONTABLE DEL INGRESO INDUSTRIA Y COMERCIO *****************
                    $sqlr="select *from tesoingresos_det where codigo='02' and vigencia='$vigusu'";
                    $res=mysql_query($sqlr,$linkbd);
                    while($row=mysql_fetch_row($res))
                    {
                        if($row[2]=='05'){$_POST[avisos]=round((ceil($row[5]*($_POST[industria]/100)))/1000,0)*1000;}
						if ($_POST[acbom]=='S')
						{
                        if($row[2]=='06'){$_POST[bomberil]=round((ceil($row[5]*($_POST[industria]/100)))/1000,0)*1000;}  
						}
                    }
                    $limite=$_POST[salariomin];
                    if($_POST[sinavisos]==1 )		 
                    {			   
                        if($minima==1)
                        {
                            $_POST[industria]=$_POST[industria]+$_POST[avisos];
                            $_POST[avisos]=0;
                        }
                        else {$_POST[avisos]=0;}
                    }
                    $sumacuenta=0;
					$sumdescuento=(($_POST[industria]*($_POST[descuento]/100)))+(($_POST[avisos]*($_POST[descuento]/100)));
					$_POST[descuentost]=$sumdescuento;
                    $sumacuenta=$_POST[industria]+$_POST[antivigact]-$_POST[antivigant]+$_POST[avisos]-$_POST[retenciones]+$_POST[sanciones]+$_POST[bomberil]+$_POST[valortotal]+$_POST[intereses]+$_POST[valortotal]-$sumdescuento;
                    if($sumacuenta<0)
                    {
                        $_POST[saldopagar]=0;
                        $_POST[saldofavor]=abs(round($sumacuenta,-3));
                    }
                    if($sumacuenta>=0)
                    {
                        $_POST[saldopagar]=abs(round($sumacuenta,-3));
                        $_POST[saldofavor]=0;
                    }
                ?>          
                <tr>
                    <td class="saludo1">Industria y Comercio</td>
                    <td class="saludo2">
                    <input type="text" id="industria" name="industria"  value="<?php echo $_POST[industria]?>" onBlur="sumarindustria()" />
                    	<input type="hidden" name="vltmindustria" id="vltmindustria" data-a-sign="$" data-a-dec="," data-a-sep="." data-v-min='0' onKeyUp="sinpuntitos('tmindustria','vltmindustria');return tabular(event,this);" value="<?php echo $_POST[vltmindustria]; ?>" style='text-align:right;' />
                   	</td>
                    
                    
                    <td class="saludo1">Avisos y Tableros</td>
                    <td class="saludo2"><input id="avisos" name="avisos" type="text" onBlur="sumarindustria()" value="<?php echo $_POST[avisos]?>"></td>
                    <td class="saludo1">Anticipo Vigencia Actual</td>
                    <td class="saludo2"><input id="antivigact" name="antivigact" type="text" onBlur="sumarindustria()" value="<?php echo $_POST[antivigact]?>" ></td>
                    <td class="saludo1">Anticipo Vigencia Anterior</td>
                    <td class="saludo2"><input id="antivigant" name="antivigant" type="text" onBlur="sumarindustria()" value="<?php echo $_POST[antivigant]?>" ></td>
                </tr>
                <tr>
                    <td class="saludo1">Retenciones</td>
                    <td class="saludo2"><input id="retenciones" name="retenciones" type="text" onBlur="sumarindustria()" value="<?php echo $_POST[retenciones]?>" ></td>
                    <td class="saludo1">Sanciones</td>
                    <td class="saludo2"><input type="text" id="sanciones" name="sanciones" value="<?php echo $_POST[sanciones]?>" onBlur="sumarindustria()"></td>
                    <td class="saludo1">Recargo Bomberil</td>
                    <td class="saludo2"><input id="bomberil" name="bomberil" type="text" onBlur="sumarindustria()" value="<?php echo $_POST[bomberil]?>" ></td>
                    <td class="saludo1">Valor Total</td>
                    <td class="saludo2"><input id="valortotal" name="valortotal" type="text" onBlur="sumarindustria()" value="<?php echo $_POST[valortotal]?>" readonly></td>
                </tr>
                <tr>
                    <td class="saludo1">Intereses</td>
                    <td class="saludo2"><input type="text" id="intereses" name="intereses" value="<?php echo $_POST[intereses]?>" onBlur="sumarindustria()"></td>
                    <td class="saludo1">Descuento (%)</td>
                    <td class="saludo2"><input type="text" id="descuento" name="descuento" value="<?php echo $_POST[descuento]?>" onBlur="document.form2.submit()"></td>
                    <td class="saludo1">Saldo a Pagar</td>
                    <td class="saludo2"><input id="saldopagar" name="saldopagar" type="text" onBlur="sumarindustria()" value="<?php echo number_format($_POST[saldopagar],2,'.','')?>" readonly></td>
                    <td class="saludo1">Saldo a Favor</td>
                    <td class="saludo2"><input id="saldofavor" name="saldofavor" type="text" onBlur="sumarindustria()" value="<?php echo number_format($_POST[saldofavor],2,'.','')?>" readonly></td>
                    <input type="hidden" name="descuentost" id="descuentost" value="<?php echo $_POST[descuentost]?>"/>
                    <input type="hidden" name="descuenindus" id="descuenindus" value="<?php echo $_POST[descuenindus]?>"/>
                    <input type="hidden" name="descuenaviso" id="descuenaviso" value="<?php echo $_POST[descuenaviso]?>"/>
                </tr> 
                <script>sumarindustria();</script>
                <?php 		
                    if ($_POST[elimina]!='')
                    { 
                        $posi=$_POST[elimina];
                        unset($_POST[dccs][$posi]);
                        unset($_POST[dconsig][$posi]);
                        unset($_POST[dbancos][$posi]);
                        unset($_POST[dnbancos][$posi]);		 
                        unset($_POST[dcbs][$posi]);	
                        unset($_POST[dcts][$posi]);			 
                        unset($_POST[dvalores][$posi]);			  
                        $_POST[dccs]= array_values($_POST[dccs]); 
                        $_POST[dconsig]= array_values($_POST[dconsig]);  
                        $_POST[dbancos]= array_values($_POST[dbancos]); 
                        $_POST[dnbancos]= array_values($_POST[dnbancos]); 
                        $_POST[dcbs]= array_values($_POST[dcbs]); 		 
                        $_POST[dcts]= array_values($_POST[dcts]); 		 		 
                        $_POST[dvalores]= array_values($_POST[dvalores]); 		 		 		 		 		 
                    }	 
                    if ($_POST[agregadet]=='1')
                    {
                        $_POST[dccs][]=$_POST[cc];
                        $_POST[dconsig][]=$_POST[numero];			 
                        $_POST[dbancos][]=$_POST[banco];		 
                        $_POST[dnbancos][]=$_POST[nbanco];		 
                        $_POST[dcbs][]=$_POST[cb];
                        $_POST[dcts][]=$_POST[ct];
                        $_POST[dvalores][]=$_POST[valor];
                        $_POST[agregadet]=0;
                        echo"
                        <script>
                            document.form2.banco.value='';
                            document.form2.nbanco.value='';
                            document.form2.cb.value='';
                            document.form2.valor.value='';	
                            document.form2.numero.value='';				
                            document.form2.numero.select();
                            document.form2.numero.focus();	
                        </script>";
                    }
                    $_POST[totalc]=0;
                    for ($x=0;$x<count($_POST[dbancos]);$x++)
                    {		 
                        echo "
                        <input type='hidden' name='dccs[]' value='".$_POST[dccs][$x]."'/>
                        <tr>
                            <td class='saludo2'>".$_POST[dccs][$x]."</td>
                            <td class='saludo2'><input name='dconsig[]' value='".$_POST[dconsig][$x]."' type='text' ></td>
                            <td class='saludo2'><input name='dcts[]' value='".$_POST[dcts][$x]."' type='hidden' ><input name='dbancos[]' value='".$_POST[dbancos][$x]."' type='hidden' ><input name='dcbs[]' value='".$_POST[dcbs][$x]."' type='text' size='45'></td>
                            <td class='saludo2'><input name='dnbancos[]' value='".$_POST[dnbancos][$x]."' type='text' size='50'></td>
                            <td class='saludo2'><input name='dvalores[]' value='".$_POST[dvalores][$x]."' type='text' size='15'></td>
                            <td class='saludo2'><input type='checkbox' name='liquidaciones' value='1'></td>
                        </tr>";
                        $_POST[totalc]=$_POST[totalc]+$_POST[dvalores][$x];
                        $_POST[totalcf]=number_format($_POST[totalc],2,".",",");
                    }
                    $resultado = convertir($_POST[saldopagar]);
                    $_POST[letras]=$resultado." PESOS M/CTE";
                    echo "
					<input type='hidden' name='letras' value='$_POST[letras]'/>
					<tr class='titulos2'>
						<td>Son:</td>
						<td colspan='7'>$_POST[letras]</td>
					</tr>";
                ?> 
            </table>	
            <?php
                if($_POST[oculto]=='2')
                {
                    ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
                    $fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
					$consec=selconsecutivo("tesoindustria","id_industria");
                    $_POST[idcomp]=$consec;	
					$idliquidacion=$_POST[idcomp];
                    //*********************CREACION DE LA LIQUIDACION ***************************
                    $sqlr="insert into tesoindustria (id_industria,fecha,vigencia,ageliquidado,tipo,tercero,valortotal,estado,ncuotas,pagos) values ('$_POST[idcomp]','$fechaf','$vigusu','$_POST[ageliquida]','$_POST[tipomov]','$_POST[tercero]',$_POST[saldopagar],'S',$_POST[ncuotas],0)";
                    if (!mysql_query($sqlr,$linkbd))
                    {
                        echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue><img src='imagenes\alert.png'>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
                        echo "Ocurrió el siguiente problema:<br>";
                        echo "<pre>";
                        echo "</pre></center></td></tr></table>";
                    }
                    else
                    {
                        //*******************CREACION DEL DETALLE ***************
                        $sqlr="insert into tesoindustria_det (id_industria,industria,avisos,bomberil,retenciones,sanciones,intereses,valortotal, totalpagar,estado,antivigant,antivigact,saldofavor,vadescuento,valordescuento) values ('$idliquidacion','$_POST[industria]','$_POST[avisos]', '$_POST[bomberil]','$_POST[retenciones]','$_POST[sanciones]','$_POST[intereses]','$_POST[valortotal]','$_POST[saldopagar]','S','$_POST[antivigant]', '$_POST[antivigact]','$_POST[saldofavor]','$_POST[descuento]','$_POST[descuentost]')";
                        mysql_query($sqlr,$linkbd);
                        //***********ALMACENAMIENTO DE LOS CIIU ************************
                        for ($x=0;$x<count($_POST[dciiu]);$x++)
                        {		
                            $sqlr="insert into tesoindustria_ciiu(id_industria,codigociiu,tarifa,ingreso,valor,estado,id,vigencia) values  ($idliquidacion,'".$_POST[dciiu][$x]."',".$_POST[dtarifas][$x].",".$_POST[dingresoact][$x].",".$_POST[dvalores][$x].",'S','$x','$_POST[ageliquida]')";
                            mysql_query($sqlr,$linkbd);
                        }
                        $nter=buscatercero($_POST[tercero]);
                        //*********************CREACION DEL COMPROBANTE CONTABLE ***************************
                        $sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($idliquidacion,3,'$fechaf','INDUSTRIA Y COMERCIO $_POST[ageliquida] - $nter ',0,$_POST[saldopagar],$_POST[saldopagar],0,'1')";
                        mysql_query($sqlr,$linkbd);
                        //*******************DETALLE DEL COMPROBANTE CONTABLE *****************************
                        //*************BUSCAR EL CONCEPTO CONTABLE DEL INGRESO INDUSTRIA Y COMERCIO *****************
                        $sqlr="select *from tesoingresos_det where codigo='02' and vigencia=$vigusu";
                        $res=mysql_query($sqlr,$linkbd);
                        while($row=mysql_fetch_row($res))
                        {
                            if($row[2]=='04') //*****industria
                            {
								$sq="select fechainicial from conceptoscontables_det where codigo='04' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
								$re=mysql_query($sq,$linkbd);
								while($ro=mysql_fetch_assoc($re))
								{
									$_POST[fechacausa]=$ro["fechainicial"];
								}
                                $sqlr2="Select * from conceptoscontables_det where estado='S' and modulo='4' AND codigo='04' and tipo='C' and fechainicial='".$_POST[fechacausa]."'";
                                $res2=mysql_query($sqlr2,$linkbd);
                                while($row2=mysql_fetch_row($res2))
                                {
                                    if($row2[3]=='N')
                                    {				 					  		
                                        if($row2[6]=='S')
                                        {				 
                                            //$valordeb=$_POST[industria]+$_POST[sanciones]-$_POST[retenciones];
											$valordeb=$_POST[industria]+$_POST[sanciones];
											$valorcred=0;
											$valorcred2=($_POST[retenciones]+$_POST[antivigant])-$_POST[antivigact];
											if ($valorcred2>=0)
											{
												$sqlry="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('3 $idliquidacion', '$row2[4]','$_POST[tercero]', '$row2[5]','Industria y Comercio $_POST[ageliquida]','','0', '$valorcred2','1','$_POST[vigencia]')";
											}
											else
											{
												$valorcred2=abs($valorcred2);
												$sqlry="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('3 $idliquidacion', '$row2[4]','$_POST[tercero]', '$row2[5]','Industria y Comercio $_POST[ageliquida]','','0', '$valorcred2','1','$_POST[vigencia]')";
											}
											mysql_query($sqlry,$linkbd);
                                        }
                                        if($row2[6]=='N')
                                        {				 
                                            //$valorcred=$_POST[industria]+$_POST[sanciones]-$_POST[retenciones];
											$valorcred=$_POST[industria]+$_POST[sanciones];
                                            $valordeb=0;
                                        }				
                                        $sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito, estado,vigencia) values ('3 $idliquidacion', '$row2[4]','$_POST[tercero]', '$row2[5]','Industria y Comercio $_POST[ageliquida]','','$valordeb', $valorcred,'1','$_POST[vigencia]')";
                                        mysql_query($sqlr,$linkbd);	 
                                    }
                                }
                            }
                            if($row[2]=='05')//************avisos
                            {
								if($_POST[avisos]>0)
								{
									$sq="select fechainicial from conceptoscontables_det where codigo='05' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
									$re=mysql_query($sq,$linkbd);
									while($ro=mysql_fetch_assoc($re))
									{
										$_POST[fechacausa]=$ro["fechainicial"];
									}
									$sqlr2="SELECT * FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='05' AND tipo='C' and fechainicial='".$_POST[fechacausa]."'";
									$res2=mysql_query($sqlr2,$linkbd);
									while($row2=mysql_fetch_row($res2))
									{
										if($row2[3]=='N')
										{				 					  		
											if($row2[6]=='S')
											{				 
												$valordeb=$_POST[avisos];
												$valorcred=0;
											}
											if($row2[6]=='N')
											{				 
												$valorcred=$_POST[avisos];
												$valordeb=0;
											}					 
											$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) VALUES('3 $idliquidacion','$row2[4]','$_POST[tercero]','$row2[5]','Avisos y Tableros $_POST[ageliquida]','','$valordeb', '$valorcred','1','$_POST[vigencia]')";
											mysql_query($sqlr,$linkbd);	 						
										}						
									}
								}
                            }
                            if($row[2]=='06') //*********bomberil ********
                            {
								if($_POST[bomberil]>0)
								{
									$sq="select fechainicial from conceptoscontables_det where codigo='06' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
									$re=mysql_query($sq,$linkbd);
									while($ro=mysql_fetch_assoc($re))
									{
										$_POST[fechacausa]=$ro["fechainicial"];
									}
									$sqlr2="SELECT * FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='06' AND tipo='C' and fechainicial='".$_POST[fechacausa]."'";
									$res2=mysql_query($sqlr2,$linkbd);
									while($row2=mysql_fetch_row($res2))
									{
										if($row2[3]=='N')
										{				 					  		
											if($row2[6]=='S')
											{				 
												$valordeb=$_POST[bomberil];
												$valorcred=0;
											}
											if($row2[6]=='N')
											{				 
												$valorcred=$_POST[bomberil];
												$valordeb=0;
											}					 
											$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) VALUES ('3 $idliquidacion','$row2[4]','$_POST[tercero]','$row2[5]','Bomberil $_POST[ageliquida]','','$valordeb','$valorcred','1', '$_POST[vigencia]')";
											mysql_query($sqlr,$linkbd);	 						
										}						
									}
								}
                            } 
							if($row[2]=='P11') //RETENCIONES INDUSTRIA Y COMERCIO 
							{
								if($_POST[retenciones]>0)
								{
									$sq="select fechainicial from conceptoscontables_det where codigo='P11' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
									$re=mysql_query($sq,$linkbd);
									while($ro=mysql_fetch_assoc($re))
									{
										$_POST[fechacausa]=$ro["fechainicial"];
									}
									$sqlr2="SELECT * FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='P11' AND tipo='C' and fechainicial='".$_POST[fechacausa]."'";
									$res2=mysql_query($sqlr2,$linkbd);
									while($row2=mysql_fetch_row($res2))
									{
										if($row2[3]=='N')
										{
											if($row2[6]=='S')
											{	
												$valordeb=$_POST[retenciones];			 
												$valorcred=0;
											}
											else
											{				 
												$valorcred=$_POST[retenciones];
												$valordeb=0;
											}
											$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) VALUES ('3 $idliquidacion','$row2[4]','$_POST[tercero]','$row2[5]','Retenciones Industria y Comercio','','$valordeb','$valorcred', '1', '$_POST[vigencia]')";
											mysql_query($sqlr,$linkbd);	 		
										}
									}
								}
							} 
							if($row[2]=='P12') //Anticipo vigencia Actual
							{
								if($_POST[antivigact]>0)
								{
									$sq="select fechainicial from conceptoscontables_det where codigo='P12' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
									$re=mysql_query($sq,$linkbd);
									while($ro=mysql_fetch_assoc($re))
									{
										$_POST[fechacausa]=$ro["fechainicial"];
									}
									$sqlr2="SELECT * FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='P12' AND tipo='C' and fechainicial='".$_POST[fechacausa]."'";
									$res2=mysql_query($sqlr2,$linkbd);
									while($row2=mysql_fetch_row($res2))
									{
										if($row2[3]=='N')
										{
											if($row2[6]=='S')
											{	
												$valordeb=$_POST[antivigact];			 
												$valorcred=0;
											}
											else
											{				 
												$valorcred=$_POST[antivigact];
												$valordeb=0;
											}
											$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) VALUES ('3 $idliquidacion','$row2[4]','$_POST[tercero]','$row2[5]','Anticipo vigencia Actual','','$valordeb','$valorcred','1', '$_POST[vigencia]')";
											mysql_query($sqlr,$linkbd);	 		
										}
									}
								}
							} 
							if($row[2]=='P13') //Anticipo vigencia Anterior
							{
								if($_POST[antivigant]>0)
								{
									$sq="select fechainicial from conceptoscontables_det where codigo='P13' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
									$re=mysql_query($sq,$linkbd);
									while($ro=mysql_fetch_assoc($re))
									{
										$_POST[fechacausa]=$ro["fechainicial"];
									}
									$sqlr2="SELECT * FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='P13' AND tipo='C' and fechainicial='".$_POST[fechacausa]."'";
									$res2=mysql_query($sqlr2,$linkbd);
									while($row2=mysql_fetch_row($res2))
									{
										if($row2[3]=='N')
										{
											if($row2[6]=='S')
											{				 
												$valordeb=$_POST[antivigant];
												$valorcred=0;
											}
											else
											{				 
												$valorcred=$_POST[antivigant];
												$valordeb=0;
											}
											$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) VALUES ('3 $idliquidacion','$row2[4]','$_POST[tercero]','$row2[5]','Anticipo vigencia Anterior','','$valordeb','$valorcred','1', '$_POST[vigencia]')";
											mysql_query($sqlr,$linkbd);	 		
										}
									}
								}
							}
							if($row[2]=='P14') //descuento industria y comercio
							{
								if($_POST[descuenindus]>0)
								{
									$sq="select fechainicial from conceptoscontables_det where codigo='P14' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
									$re=mysql_query($sq,$linkbd);
									while($ro=mysql_fetch_assoc($re))
									{
										$_POST[fechacausa]=$ro["fechainicial"];
									}
									$sqlr2="SELECT * FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='P14' AND tipo='C' and fechainicial='".$_POST[fechacausa]."'";
									$res2=mysql_query($sqlr2,$linkbd);
									while($row2=mysql_fetch_row($res2))
									{
										if($row2[3]=='N')
										{
											if($row2[6]=='S')
											{				 
												$valordeb=$_POST[descuenindus];
												$valorcred=0;
											}
											else
											{				 
												$valorcred=$_POST[descuenindus];
												$valordeb=0;
											}
											$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) VALUES ('3 $idliquidacion','$row2[4]','$_POST[tercero]','$row2[5]','Descuento Industria y Comercio','','$valordeb','$valorcred','1', '$_POST[vigencia]')";
											mysql_query($sqlr,$linkbd);	 		
										}
									}
								}
							}
                        	if($row[2]=='P15') //descuento avisos y tableros
							{
								if($_POST[descuenindus]>0)
								{
									$sq="select fechainicial from conceptoscontables_det where codigo='P15' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
									$re=mysql_query($sq,$linkbd);
									while($ro=mysql_fetch_assoc($re))
									{
										$_POST[fechacausa]=$ro["fechainicial"];
									}
									$sqlr2="SELECT * FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='P15' AND tipo='C' and fechainicial='".$_POST[fechacausa]."'";
									$res2=mysql_query($sqlr2,$linkbd);
									while($row2=mysql_fetch_row($res2))
									{
										if($row2[3]=='N')
										{
											if($row2[6]=='S')
											{				 
												$valordeb=$_POST[descuenaviso];
												$valorcred=0;
											}
											else
											{				 
												$valorcred=$_POST[descuenaviso];
												$valordeb=0;
											}
											$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito, estado,vigencia) VALUES ('3 $idliquidacion','$row2[4]','$_POST[tercero]','$row2[5]','Descuento Avisos y Tableros','','$valordeb','$valorcred','1', '$_POST[vigencia]')";
											mysql_query($sqlr,$linkbd);	 		
										}
									}
								}
							}
							if($row[2]=='P16') //intereses avisos y tableros
							{
								if($_POST[intereses]>0)
								{
									$sq="select fechainicial from conceptoscontables_det where codigo='P16' and modulo='4' and tipo='C' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
									$re=mysql_query($sq,$linkbd);
									while($ro=mysql_fetch_assoc($re))
									{
										$_POST[fechacausa]=$ro["fechainicial"];
									}
									$sqlr2="SELECT * FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='P16' AND tipo='C' and fechainicial='".$_POST[fechacausa]."'";
									$res2=mysql_query($sqlr2,$linkbd);
									while($row2=mysql_fetch_row($res2))
									{
										if($row2[3]=='N')
										{
											if($row2[6]=='S')
											{				 
												$valordeb=$_POST[intereses];
												$valorcred=0;
											}
											else
											{				 
												$valorcred=$_POST[intereses];
												$valordeb=0;
											}
											$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito, estado,vigencia) VALUES ('3 $idliquidacion','$row2[4]','$_POST[tercero]','$row2[5]','Intereses Industria y Comercio','','$valordeb','$valorcred','1', '$_POST[vigencia]')";
											mysql_query($sqlr,$linkbd);	 		
										}
									}
								}
							}////aqui
						}
                    }//**** FIN DEL ELSE DE PRIMERA SQL GUARDA LIQUIDACION ***********************   
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