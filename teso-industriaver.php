<?php //V 1000 12/12/16 ?> 
<?php
	require "comun.inc";
	require "funciones.inc";
	require "conversor.php";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	header("Content-Type: text/html;charset=iso-8859-1");
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
        <script type="text/javascript" src="JQuery/alphanum/jquery.alphanum.js"></script>
		<script>
			function cambioid()
			{
				var numdocar=document.getElementById('idcomp').value;
				document.location.href = "teso-industriaver.php?idrecaudo="+numdocar+"&scrtop=0&totreg=1&altura=432&numpag=1&limreg=10&filtro=#";
			} 
			function cambiopg(tipmov,v2,v3,v4,v5,v6)
			{
				var numdocar=document.getElementById('idcomp').value;
				var nummenor=document.getElementById('minimo').value;
				var nummayor=document.getElementById('maximo').value;
				if(tipmov=="atras" && nummenor<numdocar)
				{
					numdocar=parseInt(numdocar)-parseInt(1);
					document.location.href = "teso-industriaver.php?idrecaudo="+numdocar+"&scrtop=0&totreg=1&altura=432&numpag=1&limreg=10&filtro=#";
				}
				else if(tipmov=="adelante" && nummayor>numdocar)
				{
					numdocar=parseInt(numdocar)+parseInt(1);
					document.location.href = "teso-industriaver.php?idrecaudo="+numdocar+"&scrtop=0&totreg=1&altura=432&numpag=1&limreg=10&filtro=#";
				}
			}
			function validar(){document.form2.submit();}
			
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventanam').src="";}
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
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else 
				{
					switch(_nomve)
					{
						case "1":	document.getElementById('ventana2').src="registro-ventana01.php?vigencia="+_vaux;break;
						case "2":	document.getElementById('ventana2').src="tercerosgral-ventana05.php?objeto=tercero&nobjeto=ntercero&tnfoco=detallegreso";break;
						case "3":	document.getElementById('ventana2').src="ciiu-ventana01.php";break;
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
			<tr>
  				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='teso-industria.php'" class="mgbt"/><img src="imagenes/guardad.png" class="mgbt1"/><img src="imagenes/busca.png" title="Buscar" onClick="location.href='teso-buscaindustria.php'" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" class="mgbt" onClick="<?php echo paginasnuevas("teso");?>"/><img src="imagenes/print.png" title="Imprimir" class="mgbt" onClick="pdf()"/></td>
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
                //*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
                if(!$_POST[oculto])
                {
					$sqlr="SELECT fecha,vigencia,ageliquidado,tipo,tercero,estado,ncuotas,numcorreccion,consorciounion, actividadespat,nestablecimientos FROM tesoindustria WHERE id_industria=$_GET[idrecaudo]";
                    $res=mysql_query($sqlr,$linkbd);
					$row=mysql_fetch_row($res);
					$_POST[fecha]=$row[0];
					$_POST[idcomp]=$_GET[idrecaudo];
                    $_POST[vigencia]=$row[1];
                    $_POST[ageliquida]=$row[2];
					$_POST[tipomov]=$row[3];
					$_POST[tercero]=$row[4];
					$nresul=buscatercero($_POST[tercero]);
					$_POST[ntercero]=$nresul;
					$sqlrter="SELECT direccion,telefono,celular,email,depto,mnpio,regimen,id_tercero FROM terceros WHERE cedulanit='$_POST[tercero]' AND estado='S'";
					$rester=mysql_query($sqlrter,$linkbd);
					$rowter=mysql_fetch_row($rester);
					$_POST[direccion]=$rowter[0];	 	 
					$_POST[telefono]=$rowter[1];	 	 	 
					$_POST[celular]=$rowter[2];	 	 	 
					$_POST[email]=$rowter[3];	 	 	 
					$_POST[dpto]=$rowter[4];	 	 	 	 	 	 
					$_POST[mnpio]=$rowter[5];	 	 	 	 	 	 	 
					$_POST[regimen]=$rowter[6];
					$_POST[idterc]=$rowter[7];
					$_POST[estadop]=$row[5];
					$_POST[ncuotas]=$row[6];
					if($_POST[tipomov]==3){$_POST[ncorreccion]=$row[7];}
					if($row[8]=='S'){$_POST[consorcio]=1;}
					else {$_POST[consorcio]=0;}
                    if($row[9]=='S'){$_POST[actipataut]=1;}
					else {$_POST[actipataut]=0;}
					$_POST[nestable]=$row[10];
					$sqlr="SELECT formulario_id08,formulario_id09,formulario_id10,formulario_id11,formulario_id12,formulario_id13,formulario_id14, formulario_id15,formulario_id16,formulario_id17,formulario_id18,formulario_id19 FROM tesoindustria_gra WHERE id_industria=$_GET[idrecaudo]";
                    $res=mysql_query($sqlr,$linkbd);
					$row=mysql_fetch_row($res);
					$_POST[id08]=$row[0];
					$_POST[id09]=$row[1];
					$_POST[id10]=$row[2];
					$_POST[id11]=$row[3];
					$_POST[id12]=$row[4];
					$_POST[id13]=$row[5];
					$_POST[id14]=$row[6];
					$_POST[id15]=$row[7];
					$_POST[id16]=$row[8];
					$_POST[id17]=$row[9];
					$_POST[id18]=$row[10];
					$_POST[id19]=$row[11];
					$sqlr="SELECT codigociiu,tarifa,ingreso,valor FROM tesoindustria_ciiu WHERE id_industria=$_GET[idrecaudo]";
               		$res=mysql_query($sqlr,$linkbd);
                	while($row=mysql_fetch_row($res))
					{
						$_POST[dciiu][]=$row[0];
						$_POST[dtarifas][]=$row[1];
						$_POST[dingresoact][]=$row[2];
						$_POST[dvalores][]=$row[3];
						$sqlrna="SELECT * FROM codigosciiu WHERE codigo='$row[0]'";
                    	$resna=mysql_query($sqlrna,$linkbd);
                    	$rowna=mysql_fetch_row($resna);
						$_POST[dnciiu][]=$rowna[1];
					}
					$sqlr="SELECT industria,avisos,formulario_id22,bomberil,formulario_id24,formulario_id25,formulario_id26,retenciones, formulario_id28,antivigant,antivigact,sanciones,formulario_id32,valortotal,saldofavor,formulario_id36,formulario_id36a,formulario_id36b, formulario_id36c,vadescuento,formulario_id37,formulario_id37a,formulario_id37b,formulario_id37c,formulario_id37p,formulario_id38, formulario_id39,totalpagar FROM tesoindustria_det WHERE id_industria=$_GET[idrecaudo]";
                    $res=mysql_query($sqlr,$linkbd);
					$row=mysql_fetch_row($res);
					$_POST[industria]=$row[0];
					$_POST[id21]=$_POST[avisos]=$row[1];
					$_POST[id22]=$row[2];
					$_POST[id23]=$_POST[bomberil]=$row[3];
					$_POST[id24]=$row[4];
					$_POST[id25]=$row[5];
					$_POST[id26]=$row[6];
					$_POST[id27]=$_POST[retenciones]=$row[7];
					$_POST[id28]=$row[8];
					$_POST[id29]=$_POST[antivigant]=$row[9];
					$_POST[id30]=$_POST[antivigact]=$row[10];
					$_POST[id31]=$_POST[sanciones]=$row[11];
					$_POST[id32]=$row[12];
					$_POST[id33]=$_POST[id35]=$_POST[valortotal]=$row[13];
					$_POST[id34]=$_POST[saldofavor]=$row[14];
					$_POST[id36]=$row[15];
					$_POST[id36a]=$row[16];
					$_POST[id36b]=$row[17];
					$_POST[id36c]=$row[18];
					$_POST[id36p]=$_POST[descuento]=$row[19];
					$_POST[id37]=$_POST[intereses]=$row[20];
					$_POST[id37a]=$row[21];
					$_POST[id37b]=$row[22];
					$_POST[id37c]=$row[23];
					$_POST[id37p]=$row[24];
					$_POST[id38]=$row[25];
					$_POST[id39]=$row[26];
					$_POST[id40]=$_POST[saldopagar]=$row[27];
					$sqlr="SELECT ddescuentos,dndescuentos,dporcentajes,ddesvalores FROM tesoindustria_san WHERE id_industria=$_GET[idrecaudo]";
               		$res=mysql_query($sqlr,$linkbd);
                	while($row=mysql_fetch_row($res))
					{
						$_POST[ddescuentos][]=$row[0];
						$_POST[dndescuentos][]=$row[1];
						$_POST[dporcentajes][]=$row[2];
						$_POST[ddesvalores][]=$row[3];
					}
					$sqlr="SELECT MIN(id_industria), MAX(id_industria) FROM tesoindustria ORDER BY id_industria";
					$res=mysql_query($sqlr,$linkbd);
					$r=mysql_fetch_row($res);
					$_POST[minimo]=$r[0];
					$_POST[maximo]=$r[1];
					$_POST[tabgroup1]=1;
                }
                switch($_POST[tabgroup1])
                {
                    case 1:	$check1='checked';break;
                    case 2:	$check2='checked';break;
					case 3:	$check3='checked';break;
					case 4:	$check4='checked';break;
					case 5:	$check5='checked';break;
                    case 6:	$check6='checked';
                }
            ?>
            <input type="hidden" name="estadop" id="estadop" value="<?php echo $_POST[estadop];?>"/>
            <input type="hidden" name="tipomov" id="tipomov" value="<?php echo $_POST[tipomov];?>"/>
            <input type="hidden" name="maximo" id="maximo" value="<?php echo $_POST[maximo]?>"/>
            <input type="hidden" name="minimo" id="minimo"value="<?php echo $_POST[minimo]?>"/>
            <div class="tabsic" style="height:52%; width:99.6%;">
            	<div class="tab">
                    <input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?>/>
                    <label for="tab-1">Contribuyente</label>
                    <div class="content">
                    	<input type="hidden" name="salariomin" value="<?php echo $_POST[salariomin]?>"/>
                        <input type="hidden" name="idterc" id="idterc" value="<?php echo $_POST[idterc];?>"/>
                    	<table class="inicio" align="center" >
                            <tr >
                                <td class="titulos" colspan="12">Liquidar Industria y Comercio</td>
                                <td class="cerrar" style="width:7%" onClick="location.href='hum-principal.php'">Cerrar</td>
                            </tr>
                            <tr>
                                <td class="saludo1" style="width:3cm;">.: N&uacute;mero:</td>
                                <td style="width:12%;">
                                    <img src="imagenes/back.png"  onClick="cambiopg(<?php echo "'atras','$scrtop','$numpag','$limreg','$filtro','$prev'";?>)" title="Anterior" class="icobut"/>&nbsp;<input type="text" name="idcomp" id="idcomp" style="width:30%;" value="<?php echo $_POST[idcomp]?>" onKeyPress="javascript:return solonumeros(event)" onChange="cambioid(this)" />&nbsp;<img src="imagenes/next.png" title="Siguiente" class="icobut" onClick="cambiopg(<?php echo "'adelante','$scrtop','$numpag','$limreg','$filtro','$next'";?>)" />
                                </td>
                                <td class="saludo1" style="width:3cm;">.: Fecha:</td>
                                <td style="width:12%;"><input type="date" name="fecha" style="width:100%;" value="<?php echo $_POST[fecha]?>" id="fecha"  readonly/></td>
                                <td class="saludo1" style="width:3cm;">.: Cuotas:</td>
                                <td style="width:12%">
                                    <select name="ncuotas" id="ncuotas" onKeyUp="return tabular(event,this)" style="height:22px;width:100%">
                                    	<?php
											switch($_POST[ncuotas])
											{
												case 1:	echo"<option value='1' SELECTED>1</option>";break;
												case 2:	echo"<option value='2' SELECTED>2</option>";break;
											}
                                        ?>
                                    </select>
                                </td>
                                <td class="saludo1" style="width:3cm;">.: Año Liquidar:</td>
                                <td style="width:12%" >
                                    <input type="text" id="ageliquida" name="ageliquida" value="<?php echo $_POST[ageliquida]?>" style="width:100%" readonly/>      
                                    <input type="hidden" id="vigencia" name="vigencia" value="<?php echo $_POST[vigencia]?>" >
                                </td>
                                <td></td>
                                <td rowspan="6"></td>
                            </tr>
                            <tr>
                                <td class="saludo1">.: NIT/Cedula:</td>
                                <td >
									<input type="text" id="tercero" name="tercero" style="width:100%" value="<?php echo $_POST[tercero]?>" readonly/></td>
                                <td class="saludo1">.: Contribuyente:</td>
                                <td colspan="5"><input type="text" id="ntercero" name="ntercero" style="width:100%" value="<?php echo $_POST[ntercero]?>"onKeyUp="return tabular(event,this)" readonly></td>
                    			<td style="width:1.5cm;"></td>
                            </tr>
							<tr>
                       			<td class="saludo1">.: Direcci&oacute;n:</td>
                                <td colspan="7"><input type="text" id="direccion" name="direccion" style="width:100%" value="<?php echo $_POST[direccion]?>"onKeyUp="return tabular(event,this)" readonly></td>
                            </tr>
                            <tr>
                       			<td class="saludo1">.: Dpto :</td>
                                <td>
                                    <select name="dpto" id="dpto" onChange="validar()" style="height:22px;width:100%">
                                        <?php
                                            $sqlr="SELECT * FROM danedpto ORDER BY nombredpto";
                                            $resp = mysql_query($sqlr,$linkbd);
                                            while ($row =mysql_fetch_row($resp)) 
                                            {if($row[1]==$_POST[dpto]){echo "<option value=$row[1] SELECTED>$row[2]</option>";}}
                                        ?>
                                    </select>
                                </td>
                                <td class="saludo1">.: Municipio :</td>
                                <td>
                                    <select name="mnpio" id="mnpio" style="height:22px;width:100%">
                                        <?php
                                            $sqlr="SELECT * FROM danemnpio WHERE danemnpio.danedpto='$_POST[dpto]' ORDER BY nom_mnpio";
                                            $resp = mysql_query($sqlr,$linkbd);
                                            while ($row =mysql_fetch_row($resp)) 
                                            {if($row[2]==$_POST[mnpio]){echo "<option value=$row[2] SELECTED>$row[3]</option>";}}
                                        ?>        
                                    </select> 
                                </td>
                                <td class="saludo1">.: Telefono:</td>
                                <td><input type="text" name="telefono" id="telefono" value="<?php echo $_POST[telefono]?>" style="width:100%;" onKeyUp="return tabular(event,this)" readonly/></td>
                                <td class="saludo1">.: Celular:</td>
                                <td><input type="text" name="celular" id="celular" value="<?php echo $_POST[celular]?>" style="width:100%;" onKeyUp="return tabular(event,this)" readonly/></td>
                            </tr>
                            <tr>
                            	<td class="saludo1">.: E-mail:</td>
        						<td colspan="3"><input type="text" name="email" id="email" value="<?php echo $_POST[email]?>" style="width:100%;" onKeyUp="return tabular(event,this)" readonly></td>
                                <td colspan="4"  > 
                        			.: Es consorcio o Uni&oacute;n Temp. :&nbsp;<input type="checkbox" name="consorcio" id="consorcio" class="defaultcheckbox" value="<?php echo $_POST[consorcio];?>" <?php if($_POST[consorcio]==1){echo "checked";}?> disabled/>&nbsp;&nbsp;
                        			.: Realiza actividades a trav&eacute;s de Pat. Aut.:&nbsp;<input type="checkbox" name="actipataut" id="actipataut" class="defaultcheckbox" value="<?php echo $_POST[actipataut];?>" <?php if($_POST[actipataut]==1){echo "checked";}?> disabled/>
                       
        			</td>
                            </tr>
                            <tr>
                            	<td class="saludo1" >.: Regimen:</td>
                                <td>
                                    <select name="regimen" id="regimen" style="height:22px;width:100%;">
                                        <?php
                                            $sqlr="Select * from regimen where estado='1' order by id_regimen";
                                            $resp = mysql_query($sqlr,$linkbd);
                                            while ($row =mysql_fetch_row($resp)) 
                                            { if("$row[0]"==$_POST[regimen]){echo "<option value='$row[0]' SELECTED>$row[1]</option>";}} 
                                        ?>
                                    </select>
                                </td>
                            	<td class="saludo1">.: Establecimientos:</td>
                                <td><input type="text" name="nestable" id="nestable" value="<?php echo $_POST[nestable]?>" style="width:100%;" readonly/></td>
                               	<td class="saludo1" >.: Tipo:</td>
                                <td>
                                    <select name="tipomov" id="tipomov" onChange="validar();" onKeyUp="return tabular(event,this)" style="height:22px; width:100%">						<?php
											switch($_POST[tipomov])
											{
												case 2:	echo"<option value='2' SELECTED>Solo Pago</option>";break;
												case 3:	echo"<option value='3' SELECTED>Correcci&oacute;n</option>";break;
												case 4:	echo"<option value='4' SELECTED>Clausura</option>";break;
												case 5:	echo"<option value='5' SELECTED>Vigencia Anterior</option>";break;
												case 6:	echo"<option value='6' SELECTED>Declaraci&oacute;n Inicial</option>";break;
											}
                                        ?>
                                    </select>
                                </td> 
                                <?php
									if($_POST[tipomov]=='3')
									{
										echo"<td class='saludo1'>.: No. Correci&oacute;n:</td>
										<td><input type='text' name='ncorreccion' id='ncorreccion' style='width:100%;' value='$_POST[ncorreccion]' readonly/></td>
										";
									}
								?>
                            </tr>
                        </table>
                        <input type="hidden" value="0" name="bt"><input type="hidden" id="cb" name="cb" value="<?php echo $_POST[cb]?>" >
                        <input type="hidden" id="ct" name="ct" value="<?php echo $_POST[ct]?>" >	  
                       <input type="hidden" name="oculto" id="oculto" value="1">
                	</div>
                </div>
                <div class="tab">
                    <input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?> >
                    <label for="tab-2">Base Gravable</label>
                    <div class="content">
                        <table class="inicio" align="center" >
                            <tr >
                                <td class="titulos" colspan="12">Liquidar Industria y Comercio</td>
                                <td class="cerrar" style="width:7%;"><a onClick="location.href='teso-principal.php'">&nbsp;Cerrar</a></td>
                            </tr>
                            <tr>
                   				<td class="saludo1" style="width:50%;">.: TOTAL INGRESOS ORDINARIOS Y EXTRAORDINARIOS DEL PERIODO EN TODO EL PA&Iacute;S:</td>
                                <td style="width:12%;"><input type="text" name="id08" id="id08" style="width:100%;" value="<?php echo $_POST[id08]?>" onKeyUp="return tabular(event,this)" onChange="validar();"/></td>
                         	</tr>
                            <tr>
                            	<td class="saludo1" style="width:50%;">.: MENOS INGRESOS FUERA DE ESTE MUNICIPIO O DISTRITO:</td>
                                <td style="width:12%;"><input type="text" name="id09" id="id09" style="width:100%;" value="<?php echo $_POST[id09]?>" onKeyUp="return tabular(event,this)" onChange="validar();"/></td>
                           	</tr>
                            <tr>
                            	<td class="saludo1" style="width:50%;">.: TOTAL INGRESOS ORDINARIOS Y EXTRAORDINARIOS EN ESTE MUNICIPIO:</td>
                                <?php $_POST[id10]=$_POST[id08]-$_POST[id09]?>
                                <td style="width:12%;"><input type="text" name="id10" id="id10" style="width:100%;" value="<?php echo $_POST[id10]?>" onKeyUp="return tabular(event,this)" readonly/></td>
                            </tr>
                            <tr>
                   				<td class="saludo1" style="width:50%;">.: MENOS INGRESOS POR DEVOLUCIONES, REBAJAS, DESCUENTOS:</td>
                                <td style="width:12%;"><input type="text" name="id11" id="id11" style="width:100%;" value="<?php echo $_POST[id11]?>" onKeyUp="return tabular(event,this)" onChange="validar();"/></td>
                         	</tr>
                            <tr>
                   				<td class="saludo1" style="width:50%;">.: MENOS INGRESOS POR EXPORTACIONES:</td>
                                <td style="width:12%;"><input type="text" name="id12" id="id12" style="width:100%;" value="<?php echo $_POST[id12]?>" onKeyUp="return tabular(event,this)" onChange="validar();"/></td>
                         	</tr>
                      		<tr>
                   				<td class="saludo1" style="width:50%;">.: MENOS INGRESOS POR VENTA DE ACTIVOS FIJOS:</td>
                                <td style="width:12%;"><input type="text" name="id13" id="id13" style="width:100%;" value="<?php echo $_POST[id13]?>" onKeyUp="return tabular(event,this)" onChange="validar();"/></td>
                         	</tr>
                            <tr>
                   				<td class="saludo1" style="width:50%;">.: MENOS INGRESOS POR ACTIVIDADES EXCLUIDAS O NO SUJETAS Y OTROS INGRESOS NO GRAVADOS:</td>
                                <td style="width:12%;"><input type="text" name="id14" id="id14" style="width:100%;" value="<?php echo $_POST[id14]?>" onKeyUp="return tabular(event,this)" onChange="validar();"/></td>
                         	</tr>
                            <tr>
                   				<td class="saludo1" style="width:50%;">.: MENOS INGRESOS POR OTRAS ACTIVIDADES EXENTAS EN ESTE MUNICIPIO (POR ACUERDO):</td>
                                <td style="width:12%;"><input type="text" name="id15" id="id15" style="width:100%;" value="<?php echo $_POST[id15]?>" onKeyUp="return tabular(event,this)" onChange="validar();"/></td>
                         	</tr>
                            <?php $_POST[id16]=(($_POST[id08]-$_POST[id09])-($_POST[id11]+$_POST[id12]+$_POST[id13]+$_POST[id14]+$_POST[id15]))?>
                           	<tr>
                            	<td class="saludo1" style="width:50%;">.: TOTAL INGRESOS GRAVABLES:</td>
                                <td style="width:12%;"><input type="text" name="id16" id="id16" style="width:100%;" value="<?php echo $_POST[id16]?>" onKeyUp="return tabular(event,this)"  readonly/></td>
                            </tr>
                     	</table>
                    </div>
             	</div>
                <div class="tab">
                	<input type="radio" id="tab-3" name="tabgroup1" value="3" <?php echo $check3;?> >
                	<label for="tab-3">Actividades Gravadas</label>
                	<div class="content">
                    	<table class="inicio" align="center" >
                        	 <tr >
                                <td class="titulos" colspan="12">Liquidar Industria y Comercio</td>
                                <td class="cerrar" style="width:7%;"><a onClick="location.href='teso-principal.php'">&nbsp;Cerrar</a></td>
                            </tr>
                            <tr>
                                <td class="titulos2" style="width:10%">C&oacute;digo</td>
                                <td class="titulos2" >Actividad</td>
                                <td class="titulos2" style="width:15%">Ingreso Actividad</td>
                                <td class="titulos2" style="width:12%">Tarifa x mil</td>
                                <td class="titulos2" style="width:15%">Valor</td>
                                <td class="titulos2" style="width:5%"><img src="imagenes/del.png"></td>
                            </tr>
                            <?php
                                $totaldes=0;
								$iter="zebra1";
								$iter2="zebra2";
                                for ($x=0;$x<count($_POST[dciiu]);$x++)
                                {		 
                                    echo"
                                    <input type='hidden' name='dciiu[]' value='".$_POST[dciiu][$x]."'/>
                                    <input type='hidden' name='dnciiu[]' value='".$_POST[dnciiu][$x]."'/>
                                    <input type='hidden' name='dingresoact[]' value='".$_POST[dingresoact][$x]."'/>
                                    <input type='hidden' name='dtarifas[]' value='".$_POST[dtarifas][$x]."'/>
                                    <input type='hidden' name='dvalores[]' value='".$_POST[dvalores][$x]."'>
                                    <tr class='$iter'>
                                        <td>".$_POST[dciiu][$x]."</td>
                                        <td>".$_POST[dnciiu][$x]."</td>
                                        <td style='text-align:right;'>$ ".number_format($_POST[dingresoact][$x],0,',','.')."&nbsp;</td>
                                        <td style='text-align:right;'>".$_POST[dtarifas][$x]."&nbsp;</td>	 
                                        <td style='text-align:right;'>$ ".number_format($_POST[dvalores][$x],0,',','.')."&nbsp;</td>		 
                                        <td><a href='#' onclick='eliminardact($x)'><img src='imagenes/del.png'></a></td>
                                    </tr>";
									$aux=$iter;
									$iter=$iter2;
									$iter2=$aux;
                                    $totaldes=$totaldes+($_POST[dvalores][$x]);
                                }
								echo"
									<tr class='titulos2'>
									 <td colspan='2' style='text-align:right;'>TOTAL INGRESO</td>
									 <td $colort $tituro>$ ".number_format(array_sum($_POST[dingresoact]),0,',','.')."&nbsp;</td>
									 <td style='text-align:right;'>.: TOTAL IMPUESTO:</td>
									 <td style='text-align:right;'>$ ".number_format($totaldes,0,',','.')."&nbsp;</td>
									</tr>";		 
                            ?>
                            <input type="hidden" name="id17" id="id17" style="width:100%;" value="<?php echo $totaldes?>" onKeyUp="return tabular(event,this)"  readonly/>
                        </table>
                        <table class="inicio">
                			<tr>
                            	<td class="saludo1" style="width:20%;">.: GENERACIÓN DE ENERGIA:</td>
                                <td class="saludo1" style="width:20%;">Capacidad Instalada (kw):</td>
                                <td style="width:12%;"><input type="text" name="id18" id="id18" style="width:100%;" value="<?php echo $_POST[id18]?>" onKeyUp="return tabular(event,this)"/></td>
                                <td class="saludo1" style="width:20%;">.: IMP LEY 56 DE 1981:</td>
                                <td style="width:12%;"><input type="text" name="id19" id="id19" style="width:100%;" value="<?php echo $_POST[id19]?>" onKeyUp="return tabular(event,this)" onChange="validar();"/></td>
                            </tr>
                     	</table>
                    </div>
                </div>
                <div class="tab">
                    <input type="radio" id="tab-4" name="tabgroup1" value="4" <?php echo $check4;?> >
                    <label for="tab-4">Liquidaci&oacute;n Privada</label>
                    <div class="content">
                        <table class="inicio" align="center" >
                            <tr >
                                <td class="titulos" colspan="12">Liquidar Industria y Comercio</td>
                                <td class="cerrar" style="width:7%;"><a onClick="location.href='teso-principal.php'">&nbsp;Cerrar</a></td>
                            </tr>
                            <tr>
                   				<td class="saludo1" style="width:50%;">.: TOTAL IMPUESTO DE INDUSTRIA Y COMERCIO:</td>
                                <td style="width:12%;"><input type="text" name="id20" id="id20" style="width:100%;" value="<?php echo $_POST[industria]?>" readonly/></td>
                                <td></td>
                         	</tr>
                            <tr>
                   				<td class="saludo1" style="width:50%;">.: IMPUESTO DE AVISOS Y TABLEROS:</td>
                                <td style="width:12%;"><input type="text" name="id21" id="id21" style="width:100%;" value="<?php echo $_POST[id21]?>" readonly/></td>
                                <td></td>
                         	</tr>
                         	<tr>
                   				<td class="saludo1" style="width:50%;">.: PAGO POR UNIDADES COMERCIALES ADICIONALES DEL SECTOR FINANCIERO:</td>
                                <td style="width:12%;"><input type="text" name="id22" id="id22" style="width:100%;" value="<?php echo $_POST[id22]?>" readonly/></td>
                                <td></td>
                         	</tr>
                            <tr>
                   				<td class="saludo1" style="width:50%;">.: SOBRETASA BOMBERIL Ac 018 de Dic/2016, articulo No. 75:</td>
                                <td style="width:12%;"><input type="text" name="id23" id="id23" style="width:100%;" value="<?php echo $_POST[id23]?>" readonly/></td>
                                <td></td>
                         	</tr>
                            <tr>
                   				<td class="saludo1" style="width:50%;">.: SOBRETASA DE SEGURIDAD (Ley 1421 de 2011):</td>
                                <td style="width:12%;"><input type="text" name="id24" id="id24" style="width:100%;" value="<?php echo $_POST[id24]?>" readonly/></td>
                                <td></td>
                         	</tr>
                            <tr>
                   				<td class="saludo1" style="width:50%;">.: TOTAL IMPUESTO A CARGO:</td>
                                <td style="width:12%;"><input type="text" name="id25" id="id25" style="width:100%;" value="<?php echo $_POST[id25]?>" readonly/></td>
                                <td></td>
                         	</tr>
                            <tr>
                   				<td class="saludo1" style="width:50%;">.: MENOS VALOR DE EXENCI&Oacute;N O EXONERACI&Oacute;N SOBRE EL IMPUESTO Y NO SOBRE LOS INGRESOS:</td>
                                <td style="width:12%;"><input type="text" name="id26" id="id26" style="width:100%;" value="<?php echo $_POST[id26]?>" readonly/></td>
                                <td></td>
                         	</tr>
                            <tr>
                   				<td class="saludo1" style="width:50%;">.: MENOS RETENCIONES que le practicaron a favor de este municipio o distrito en este periodo:</td>
                                <td style="width:12%;"><input type="text" name="id27" id="id27" style="width:100%;" value="<?php echo $_POST[id27]?>" readonly/></td>
                                <td></td>
                         	</tr>
                            <tr>
                   				<td class="saludo1" style="width:50%;">.: MENOS AUTORRETENCIONES practicadas a favor de este municipio o distrito en este periodo:</td>
                                <td style="width:12%;"><input type="text" name="id28" id="id28" style="width:100%;" value="<?php echo $_POST[id28]?>" readonly/></td>
                                <td></td>
                         	</tr>
                            <tr>
                   				<td class="saludo1" style="width:50%;">.: MENOS ANTICIPO LIQUIDADO EN EL A&Ntilde;O ANTERIOR:</td>
                                <td style="width:12%;"><input type="text" name="id29" id="id29" style="width:100%;" value="<?php echo $_POST[id29]?>" readonly/></td>
                                <td></td>
                         	</tr>
                            <tr>
                   				<td class="saludo1" style="width:50%;">.: ANTICIPO DEL AÑO SIGUIENTE  (Si existe, liquide porcentaje según Acuerdo Municipal o distrital):</td>
                                <td style="width:12%;"><input type="text" name="id30" id="id30" style="width:100%;" value="<?php echo $_POST[id30]?>" readonly/></td>
                         	</tr>
                            <tr>
                   				<td class="saludo1" style="width:50%;">.: SANCIONES:</td>
                                <td style="width:12%;"><input type="text" name="id31" id="id31" style="width:100%;" value="<?php echo $_POST[id31]?>" readonly/></td>
                                <td></td>
                         	</tr>
                           	<tr>
                   				<td class="saludo1" style="width:50%;">.: MENOS SALDO A FAVOR DEL PERIODO ANTERIOR SIN SOLICITUD DE DEVOLUCI&Oacute;N O COMPENSACI&Oacute;N:</td>
                                <td style="width:12%;"><input type="text" name="id32" id="id32" style="width:100%;" value="<?php echo $_POST[id32]?>" readonly/></td>
                                <td></td>
                         	</tr>
                            <tr>
                   				<td class="saludo1" style="width:50%;">.: TOTAL SALDO A CARGO:</td>
                                <td style="width:12%;"><input type="text" name="id33" id="id33" style="width:100%;" value="<?php echo $_POST[id33]?>" readonly/></td>
                                <td></td>
                         	</tr>
                            <tr>
                   				<td class="saludo1" style="width:50%;">.: TOTAL SALDO A FAVOR:</td>
                                <td style="width:12%;"><input type="text" name="id34" id="id34" style="width:100%;" value="<?php echo $_POST[id34]?>" readonly/></td>
                                <td></td>
                         	</tr>
                            <tr>
                   				<td class="saludo1" style="width:50%;">.: VALOR A PAGAR:</td>
                                <td style="width:12%;"><input type="text" name="id35" id="id35" style="width:100%;" value="<?php echo $_POST[id35]?>" readonly/></td>
                                <td></td>
                         	</tr>
                      		<tr>
                   				<td class="saludo1" style="width:50%;">.: DESCUENTO INDUSTRIA Y COMERCIO:</td>
                                <td style="width:12%;"><input type="text" name="id36a" id="id36a" style="width:100%;" value="<?php echo $_POST[id36a]?>" readonly/></td>
                                 <td></td>
                         	</tr>
                            <tr>
                   				<td class="saludo1" style="width:50%;">.: DESCUENTO AVISOS Y TABLEROS:</td>
                                <td style="width:12%;"><input type="text" name="id36b" id="id36b" style="width:100%;" value="<?php echo $_POST[id36b]?>" readonly/></td>
                                 <td></td>
                         	</tr>
                            <tr>
                   				<td class="saludo1" style="width:50%;">.: DESCUENTO BOMBERIL:</td>
                                <td style="width:12%;"><input type="text" name="id36c" id="id36c" style="width:100%;" value="<?php echo $_POST[id36c]?>" readonly/></td>
                                 <td></td>
                         	</tr>
                          	<tr>
                   				<td class="saludo1" style="width:50%;">.: DESCUENTO POR PRONTO PAGO (Si existe, liquídelo según el Acuerdo Municipal o distrital):</td>
                                <td style="width:12%;"><input type="text" name="id36" id="id36" style="width:100%;" value="<?php echo $_POST[id36]?>" readonly/></td>
                                <td><input type="text" name="id36p" id="id36p" value="<?php echo $_POST[id36p]?>" style="width:1.5cm;" readonly/>%</td>
                         	</tr>
                            <tr>
                   				<td class="saludo1" style="width:50%;">.: INTERESES INDUSTRIA Y COMERCIO:</td>
                                <td style="width:12%;"><input type="text" name="id37a" id="id37a" style="width:100%;" value="<?php echo $_POST[id37a]?>" readonly/></td>
                                 <td></td>
                         	</tr>
                            <tr>
                   				<td class="saludo1" style="width:50%;">.: INTERESES AVISOS Y TABLEROS:</td>
                                <td style="width:12%;"><input type="text" name="id37b" id="id37b" style="width:100%;" value="<?php echo $_POST[id37b]?>" readonly/></td>
                                 <td></td>
                         	</tr>
                            <tr>
                   				<td class="saludo1" style="width:50%;">.: INTERESES BOMBERIL:</td>
                                <td style="width:12%;"><input type="text" name="id37c" id="id37c" style="width:100%;" value="<?php echo $_POST[id37c]?>" readonly/></td>
                                 <td></td>
                         	</tr>
                            <tr>
                   				<td class="saludo1" style="width:50%;">.: INTERESES DE MORA:</td>
                                <td style="width:12%;"><input type="text" name="id37" id="id37" style="width:100%;" value="<?php echo $_POST[id37]?>" readonly/></td>
                                <td><input type="text" name="id37p" id="id37p"value="<?php echo $_POST[id37p]?>" style="width:1.5cm;" readonly/>%</td>
                         	</tr>
                            <tr>
                   				<td class="saludo1" style="width:50%;">.: TOTAL A PAGAR:</td>
                                <td style="width:12%;"><input type="text" name="id38" id="id38" style="width:100%;" value="<?php echo $_POST[id38]?>" readonly/></td>
                                <td></td>
                         	</tr>
                            <tr>
                   				<td class="saludo1" style="width:50%;">.: LIQUIDE EL VALOR DEL PAGO VOLUNTARIO:</td>
                                <td style="width:12%;"><input type="text" name="id39" id="id39" style="width:100%;" value="<?php echo $_POST[id39]?>" readonly/></td>
                                <td></td>
                         	</tr>
                            <tr>
                   				<td class="saludo1" style="width:50%;">.: TOTAL A PAGAR CON PAGO VOLUNTARIO :</td>
                                <td style="width:12%;"><input type="text" name="id40" id="id40" style="width:100%;" value="<?php echo $_POST[id40]?>" readonly/></td>
                                <td></td>
                         	</tr>
                       	</table>
                  	</div>
             	</div>
                <div class="tab">
                    <input type="radio" id="tab-5" name="tabgroup1" value="5" <?php echo $check5;?> >
                    <label for="tab-5">Sanciones</label>
                    <div class="content"> 
                        <table class="inicio" align="center" >
                            <tr >
                                <td class="titulos" colspan="3">Sanciones</td>
                                <td class="cerrar" style="width:7%;"><a onClick="location.href='teso-principal.php'">&nbsp;Cerrar</a></td>
                            </tr>
                            <tr class="titulos2">
                                <td>Sancion</td>
                                <td>%</td>
                                <td>Valor</td>
                                <td></td>
                            </tr>
                            <?php
                                $iter="zebra1";
								$iter2="zebra2";
                                for ($x=0;$x<count($_POST[ddescuentos]);$x++)
                                {		 
                                    echo"
                                    <input type='hidden' name='dndescuentos[]' value='".$_POST[dndescuentos][$x]."'/>
                                    <input type='hidden' name='ddescuentos[]' value='".$_POST[ddescuentos][$x]."'/>
                                    <input type='hidden' name='dporcentajes[]' value='".$_POST[dporcentajes][$x]."'/>
                                    <input type='hidden' name='ddesvalores[]' value='".$_POST[ddesvalores][$x]."'/>
                                    <tr class='$iter'>
                                        <td>".$_POST[dndescuentos][$x]."</td>
                                        <td>".$_POST[dporcentajes][$x]."</td>
                                        <td>".$_POST[ddesvalores][$x]."</td>
                                        <td></td>
                                    </tr>";
									$aux=$iter;
									$iter=$iter2;
									$iter2=$aux;
                                }		 
                            ?>
                        </table>
                    </div>
                </div>       
            </div>
            <table class="inicio">
                <tr><td colspan="8" class="titulos">Liquidacion Privada</td></tr>          
                <input type="hidden" name="industria" id="industria" value="<?php echo $_POST[industria];?>"/> 
                <input type="hidden" name="avisos" id="avisos" value="<?php echo $_POST[avisos];?>"/> 
                <input type="hidden" name="antivigact" id="antivigact" value="<?php echo $_POST[antivigact];?>"/>
                <input type="hidden" name="antivigant" id="antivigant" value="<?php echo $_POST[antivigant];?>" >
                <input type="hidden" name="retenciones" id="retenciones" value="<?php echo $_POST[retenciones];?>"/>
                <input type="hidden" name="sanciones" id="sanciones" value="<?php echo $_POST[sanciones];?>"/>  
                <input type="hidden" name="bomberil" id="bomberil" value="<?php echo $_POST[bomberil];?>"/> 
                <input type="hidden" name="valortotal" id="valortotal" value="<?php echo $_POST[valortotal];?>"/> 
                <input type="hidden" name="intereses" id="intereses" value="<?php echo $_POST[intereses];?>"/>
                <input type="hidden" name="descuento" id="descuento" value="<?php echo $_POST[descuento];?>"/>   
                <input type="hidden" name="saldopagar" id="saldopagar" value="<?php echo $_POST[saldopagar];?>"/>
                <input type="hidden" name="saldofavor" id="saldofavor" value="<?php echo $_POST[saldofavor];?>"/>
           		<input type="hidden" name="descuentost" id="descuentost" value="<?php echo $_POST[descuentost]?>"/>
               	<input type="hidden" name="descuenindus" id="descuenindus" value="<?php echo $_POST[descuenindus]?>"/>
            	<input type="hidden" name="descuenaviso" id="descuenaviso" value="<?php echo $_POST[descuenaviso]?>"/>
                <tr>
                    <td class="saludo1">Industria y Comercio</td>
                    <td class="saludo2" style="text-align:right;">$<?php echo number_format($_POST[industria],0,',','.');?>&nbsp;&nbsp;</td>
                    <td class="saludo1">Avisos y Tableros</td>
                    <td class="saludo2" style="text-align:right;">$<?php echo number_format($_POST[avisos],0,',','.');?>&nbsp;&nbsp;</td>
                    <td class="saludo1">Anticipo Vigencia Actual</td>
                    <td class="saludo2" style="text-align:right;">$<?php echo number_format($_POST[antivigact],0,',','.');?>&nbsp;&nbsp;</td>
                    <td class="saludo1">Anticipo Vigencia Anterior</td>
                    <td class="saludo2" style="text-align:right;">$<?php echo number_format($_POST[antivigant],0,',','.');?>&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td class="saludo1">Retenciones</td>
                    <td class="saludo2" style="text-align:right;">$<?php echo number_format($_POST[retenciones],0,',','.');?>&nbsp;&nbsp;</td>
                    <td class="saludo1">Sanciones</td>
                    <td class="saludo2" style="text-align:right;">$<?php echo number_format($_POST[sanciones],0,',','.');?>&nbsp;&nbsp;</td>
                    <td class="saludo1">Recargo Bomberil</td>
                    <td class="saludo2" style="text-align:right;">$<?php echo number_format($_POST[bomberil],0,',','.');?>&nbsp;&nbsp;</td>
                    <td class="saludo1">Valor Total</td>
                    <td class="saludo2" style="text-align:right;">$<?php echo number_format($_POST[valortotal],0,',','.');?>&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td class="saludo1">Intereses</td>
                    <td class="saludo2" style="text-align:right;">$<?php echo number_format($_POST[intereses],0,',','.');?>&nbsp;&nbsp;</td>
                    <td class="saludo1">Descuento (%)</td>
                    <td class="saludo2" style="text-align:right;"><?php echo $_POST[descuento];?>%&nbsp;&nbsp;</td>
                    <td class="saludo1">Saldo a Pagar</td>
                    <td class="saludo2" style="text-align:right;">$<?php echo number_format($_POST[saldopagar],0,',','.');?>&nbsp;&nbsp;</td>
                    <td class="saludo1">Saldo a Favor</td>
                    <td class="saludo2" style="text-align:right;">$<?php echo number_format($_POST[saldofavor],0,',','.');?>&nbsp;&nbsp;</td>
                </tr> 
                <?php 		
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
			<div id="bgventanamodal2">
                <div id="ventanamodal2">
                    <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                    </IFRAME>
                </div>
       	 	</div> 
		</form>
	</body>
</html>