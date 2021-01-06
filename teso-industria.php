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
			function consultaciiu(e)
 			{
				if (document.form2.ciiu.value!="")
				{
 					document.form2.bci.value='1';
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
			function guardar()
			{
				if (document.form2.fecha.value!='' && document.form2.tercero.value!='')
				{
					if (document.form2.id16.value!='' && document.form2.id16.value!=0)
					{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
					else {despliegamodalm('visible','2','Faltan diligenciar los datos de la Base Gravable');}
				}
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
					document.form2.agregadetdes2.value=1;
					document.form2.submit();
 				}
 				else {alert("Falta informacion para poder Agregar");}
			}
			function eliminardact2(variable)
			{
				if (confirm("Esta Seguro de Eliminar"))
  				{
					document.form2.eliminadac2.value=variable;
					document.form2.submit();
				}
			}
			function verificacheckfull(nomcheck)
			{
				if (document.getElementById(''+nomcheck).checked == false)
				{
					document.getElementById(''+nomcheck).value="0";
					document.getElementById(''+nomcheck).checked=false;
				}
				else 
				{
					document.getElementById(''+nomcheck).value="1";
					document.getElementById(''+nomcheck).checked=true;
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
					$_POST[sambom]='S';
					$_POST[tabgroup1]=1;
					$_POST[tpcalculo]=1;
					$_POST[id08]=$_POST[id09]=$_POST[id11]=$_POST[id12]=$_POST[id13]=$_POST[id14]=$_POST[id15]=$_POST[id18]=$_POST[id19]=$_POST[id22]=$_POST[id23]=$_POST[id24]=$_POST[id26]=$_POST[id27]=$_POST[id28]=$_POST[id29]=$_POST[id30]=$_POST[id32]=$_POST[id36]=$_POST[id36a]=$_POST[id36b]=$_POST[id36c]=$_POST[id36p]=$_POST[id37]=$_POST[id37a]=$_POST[id37b]=$_POST[id37c]=$_POST[id37p]=$_POST[id39]=0;
                    $sqlr="SELECT valor_inicial FROM dominios WHERE nombre_dominio='CUENTA_CAJA'";
                    $res=mysql_query($sqlr,$linkbd);
                    while ($row =mysql_fetch_row($res)){$_POST[cuentacaja]=$row[0];}
                    $sqlr="SELECT tmindustria,desindustria,desavisos,desbomberil,intindustria,intavisos,intbomberil FROM tesoparametros";
                    $res=mysql_query($sqlr,$linkbd);
                    while ($row =mysql_fetch_row($res))
					{
						$_POST[salariomin]=$row[0];
						$_POST[descunidos]="$row[1]$row[2]$row[3]";
						$_POST[intecunidos]="$row[4]$row[5]$row[6]";
					}
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
					case 3:	$check3='checked';break;
					case 4:	$check4='checked';break;
					case 5:	$check5='checked';break;
                    case 6:	$check6='checked';
                }
                if($_POST[sinavisos]==1){$chkav=" checked ";}
                else {$chkav=" ";}
                if($_POST[bt]=='1')//***** busca tercero
                {
					$nresul=buscatercero($_POST[tercero]);
                    if($nresul!='')
					{
						$_POST[ntercero]=$nresul;
						$sqlr="SELECT direccion,telefono,celular,email,depto,mnpio,regimen,id_tercero FROM terceros WHERE cedulanit='$_POST[tercero]' AND estado='S'";
						$res=mysql_query($sqlr,$linkbd);
						$row=mysql_fetch_row($res);
						$_POST[direccion]=$row[0];	 	 
						$_POST[telefono]=$row[1];	 	 	 
						$_POST[celular]=$row[2];	 	 	 
						$_POST[email]=$row[3];	 	 	 
						$_POST[dpto]=$row[4];	 	 	 	 	 	 
						$_POST[mnpio]=$row[5];	 	 	 	 	 	 	 
						$_POST[regimen]=$row[6];
						$_POST[idterc]=$row[7];
					}
                    else {$_POST[ntercero]="";}
                }
                if($_POST[bci]=='1')
                {
                    $sqlr="select * from codigosciiu where codigosciiu.codigo='$_POST[ciiu]'";
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
            <input type="hidden" name="descunidos" id="descunidos" value="<?php echo $_POST[descunidos];?>"/>
            <input type="hidden" name="intecunidos" id="intecunidos" value="<?php echo $_POST[intecunidos];?>"/>
            <div class="tabsic" style="height:52%; width:99.6%;">
            	<div class="tab">
                    <input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
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
                             <td class="saludo1" style="width:3cm;">.: Calculos:</td>
                             <td>
                             	<select name="tpcalculo" id="tpcalculo">
                                	<option value='1' <?php if($_POST[tpcalculo]=='1'){echo'SELECTED';}?>>Autom&aacute;ticos</option>
                                    <option value='2' <?php if($_POST[tpcalculo]=='2'){echo'SELECTED';}?>>Manuales</option>
                                </select>
                             </td>
                            </tr>
                            <tr>
                                <td class="saludo1" style="width:3cm;">.: N&uacute;mero:</td>
                                <td style="width:12%;">
                                    <input type="text" name="idcomp" id="idcomp" style="width:100%;" value="<?php echo $_POST[idcomp]?>" onKeyUp="return tabular(event,this)"  readonly/>
                                </td>
                                <td class="saludo1" style="width:3cm;">.: Fecha:</td>
                                <td style="width:12%;"><input  type="text" name="fecha" style="width:80%;" value="<?php echo $_POST[fecha]?>" maxlength="10"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" readonly>&nbsp;<img src="imagenes/calendario04.png" class="icobut" onClick="displayCalendarFor('fc_1198971545');"/></td>
                                <td class="saludo1" style="width:3cm;">.: Cuotas:</td>
                                <td style="width:12%">
                                    <select name="ncuotas" id="ncuotas" onKeyUp="return tabular(event,this)" style="height:22px;width:100%">
                                        <option value="1" <?php if($_POST[ncuotas]=='1') echo "SELECTED"; ?>>1</option>
                                        <option value="2" <?php if($_POST[ncuotas]=='2') echo "SELECTED"; ?>>2</option> 
                                    </select>
                                </td>
                                <td class="saludo1" style="width:3cm;">.: Año Liquidar:</td>
                                <td style="width:12%" >
                                    <input type="text" id="ageliquida" name="ageliquida" value="<?php echo $_POST[ageliquida]?>" maxlength="4" style="width:100%">      
                                    <input type="hidden" id="vigencia" name="vigencia" value="<?php echo $_POST[vigencia]?>" >
                                </td>
                                <td></td>
                                <td rowspan="6"></td>
                            </tr>
                            <tr>
                                <td class="saludo1">.: NIT/Cedula:</td>
                                <td >
									<input id="tercero" type="text" name="tercero" style="width:80%" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo $_POST[tercero]?>">&nbsp;<img src="imagenes/find02.png" class="icobut" onClick="despliegamodal2('visible','2')"/></td>
                                <td class="saludo1">.: Contribuyente:</td>
                                <td colspan="5"><input type="text" id="ntercero" name="ntercero" style="width:100%" value="<?php echo $_POST[ntercero]?>"onKeyUp="return tabular(event,this)" readonly></td>
                                 <?php
									if($_POST[ntercero]==""){$editer=" class='icobut1' src='imagenes/usereditd.png'";}
									else{$editer=" class='icobut' src='imagenes/useredit.png' onClick=\"mypop=window.open('teso-editaterceros.php?idter=$_POST[idterc]','','');mypop.focus();\"";}
								?>
                    			<td style="width:1.5cm;">&nbsp;<img class="icobut" src="imagenes/usuarion.png" title="Crear Tercero" onClick="mypop=window.open('teso-buscaterceros.php','','');mypop.focus();"/>&nbsp;<img <?php echo $editer; ?> title="Editar Tercero" /></td>
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
                        			.: Es consorcio o Uni&oacute;n Temp. :&nbsp;<input type="checkbox" name="consorcio" id="consorcio" class="defaultcheckbox" value="<?php echo $_POST[consorcio];?>" onClick="verificacheckfull(this.id);" <?php if(isset($_REQUEST['consorcio'])){echo "checked";} ?>/>&nbsp;&nbsp;
                        			.: Realiza actividades a trav&eacute;s de Pat. Aut.:&nbsp;<input type="checkbox" name="actipataut" id="actipataut" class="defaultcheckbox" value="<?php echo $_POST[actipataut];?>" onClick="verificacheckfull(this.id);" <?php if(isset($_REQUEST['actipataut'])){echo "checked";} ?>/> 
                       
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
                                <td><input type="text" name="nestable" id="nestable" value="<?php echo $_POST[nestable]?>" style="width:100%;" onKeyUp="return tabular(event,this)"/></td>
                               	<td class="saludo1" >.: Tipo:</td>
                                <td>
                                    <select name="tipomov" id="tipomov" onChange="validar();" onKeyUp="return tabular(event,this)" style="height:22px; width:100%">
                                        <option value="2" <?php if($_POST[tipomov]=='2') echo "SELECTED"; ?>>Solo Pago</option>
                                        <option value="3" <?php if($_POST[tipomov]=='3') echo "SELECTED"; ?>>Correcci&oacute;n</option>
                                        <option value="4" <?php if($_POST[tipomov]=='4') echo "SELECTED"; ?>>Clausura</option>
                                        <option value="5" <?php if($_POST[tipomov]=='5') echo "SELECTED"; ?>>Vigencia Anterior</option>
                                        <option value="6" <?php if($_POST[tipomov]=='6') echo "SELECTED"; ?>>Declaraci&oacute;n Inicial</option>
                                    </select>
                                </td> 
                                <?php
									if($_POST[tipomov]=='3')
									{
										echo"<td class='saludo1'>.: No. Correci&oacute;n:</td>
										<td><input type='text' name='ncorreccion' id='ncorreccion' style='width:100%;' value='$_POST[ncorreccion]'/></td>
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
                                <?php $_POST[id10]=$_POST[id08]-$_POST[id09];?>
                                <td style="width:12%;"><input type="text" name="id10" id="id10" style="width:100%;" value="<?php echo $_POST[id10]?>" onKeyUp="return tabular(event,this)"  readonly/></td>
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
                            <?php $_POST[id16]=(($_POST[id08]-$_POST[id09])-($_POST[id11]+$_POST[id12]+$_POST[id13]+$_POST[id14]+$_POST[id15]));?>
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
                                <td class="saludo1" style="width:3cm;">Ing Gravables:</td>
                                <td  style="width:15%;"><input type="text" id="ingreso" name="ingreso" value="<?php echo $_POST[ingreso]?>" onKeyUp="return tabular(event,this)" style="width:100%"/></td>
                                <td class="saludo1" style="width:3cm;">Acti Economica:</td>
                                <td colspan="2"  style="width:12%;">
                                    <input type="text" name="ciiu" value="<?php echo $_POST[ciiu]?>" onKeyUp="return tabular(event,this) " onBlur="consultaciiu()"  style="width:40%;">
                                    <input type="hidden" name="tciiu" value="<?php echo $_POST[tciiu]?>" >
                                    <input type="hidden" name="nciiu" value="<?php echo $_POST[nciiu]?>" > 
                                    <input type="hidden" value="0" name="bci">&nbsp;<img src="imagenes/find02.png" class="icobut" onClick="despliegamodal2('visible','3')"/>
                                </td>
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
							if($_POST[tpcalculo]=='1'){$vareditar="readonly";}
							else {$vareditar2="readonly";}
                        ?>
                        <table class="inicio">
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
								if((($_POST[id08]-$_POST[id09])-($_POST[id11]+$_POST[id12]+$_POST[id13]+$_POST[id14]+$_POST[id15])) == array_sum($_POST[dingresoact]))
								{$colort="style='background-color:#74FF7B;text-align:right;'";$tituro="";}
								else{$colort="style='background-color:#ED0000;text-align:right;'";$tituro="title='Total Ingresos Gravables $ ".number_format($_POST[id16],0,',','.')."'";}

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
                        <?php
							if($_POST[tpcalculo]=='1')
							{
								$_POST[industria]=(round((ceil(($totaldes+ $_POST[id19])))/1000,0)*1000);
								$minima=0;
								if(($_POST[industria])<=($_POST[salariomin]))//****cuando hay valor minimo
								{
									$_POST[industria]=$_POST[salariomin];
									$minima=1;
								}
							}
						?>
                    </div>
                </div>
                <div class="tab">
                    <input type="radio" id="tab-4" name="tabgroup1" value="4" <?php echo $check4;?> >
                    <label for="tab-4">Liquidaci&oacute;n Privada</label>
                    <div class="content">
                    	<?php
							if($_POST[tpcalculo]=='1')
							{
								$sqlr="select *from tesoingresos_det where codigo='02' and vigencia='$vigusu'";
								$res=mysql_query($sqlr,$linkbd);
								while($row=mysql_fetch_row($res))
								{
									if($row[2]=='05'){$_POST[avisos]=round((ceil($row[5]*($_POST[industria]/100)))/1000,0)*1000;}
									if ($_POST[sinavisos]!= 1)
									{$_POST[id21]=$_POST[avisos];$valavisos=$_POST[avisos];} else {$_POST[id21]="0";$valavisos=0;}
									if ($_POST[acbom]=='S')
									{
										if($row[2]=='06')
										{
											$_POST[bomberil]=round((ceil($row[5]*($_POST[industria]/100)))/1000,0)*1000;
											$_POST[id23]=round((ceil($row[5]*($_POST[industria]/100)))/1000,0)*1000;
										}  
									}
									else {$_POST[id23]=$_POST[bomberil]=$_POST[id23];}
								}
							}
							else
							{
								$_POST[id21]=$valavisos=$_POST[avisos]=$_POST[id21];
								$_POST[id23]=$_POST[bomberil]=$_POST[id23];
							}
						?>
                        <table class="inicio" align="center" >
                            <tr >
                                <td class="titulos" colspan="12" style=" font-family:'fuentemenu' ;">Liquidar Industria y Comercio</td>
                                <td class="cerrar" style="width:7%;"><a onClick="location.href='teso-principal.php'">&nbsp;Cerrar</a></td>
                            </tr>
                            <tr>
                   				<td class="saludo1" style="width:50%;">.: TOTAL IMPUESTO DE INDUSTRIA Y COMERCIO:</td>
                                <td style="width:12%;"><input type="text" name="id20" id="id20" style="width:100%;" value="<?php if($_POST[tpcalculo]=='1'){echo $_POST[industria];} else {echo $_POST[id20];$_POST[industria]=$_POST[id20];}?>" onKeyUp="return tabular(event,this)" onChange="validar();" <?php echo $vareditar;?>/></td>
                                <td></td>
                         	</tr>
                            <tr>
                   				<td class="saludo1" style="width:50%;">.: IMPUESTO DE AVISOS Y TABLEROS:</td>
                                <td style="width:12%;"><input type="text" name="id21" id="id21" style="width:100%;" value="<?php echo $_POST[id21]?>" onKeyUp="return tabular(event,this)" onChange="validar();" <?php echo $vareditar;?>/></td>
                                <td><span class="saludo3"><input class="defaultcheckbox" type="checkbox" name="sinavisos" value="1" <?php echo $chkav;?> onClick="validar()">Sin Avisos</span></td>
                         	</tr>
                         	<tr>
                   				<td class="saludo1" style="width:50%;">.: PAGO POR UNIDADES COMERCIALES ADICIONALES DEL SECTOR FINANCIERO:</td>
                                <td style="width:12%;"><input type="text" name="id22" id="id22" style="width:100%;" value="<?php echo $_POST[id22]?>" onKeyUp="return tabular(event,this)" onChange="validar();" /></td>
                                <td></td>
                         	</tr>
                           	<?php if($_POST[acbom]=='S' && $_POST[tpcalculo]=='1'){$actibombe="readonly";} else {$actibombe="";}?>
                            <tr>
                   				<td class="saludo1" style="width:50%;">.: SOBRETASA BOMBERIL Ac 018 de Dic/2016, articulo No. 75:</td>
                                <td style="width:12%;"><input type="text" name="id23" id="id23" style="width:100%;" value="<?php echo $_POST[id23]?>" onKeyUp="return tabular(event,this)" onChange="validar();" <?php echo $actibombe; ?>/></td>
                                <td>
                                    <select name="acbom" id="acbom" onKeyUp="return tabular(event,this)" onChange="validar();">
                                    	<option value="S" <?php if($_POST[acbom]=='S') echo "SELECTED"; ?>>Automatica</option> 
                                        <option value="N" <?php if($_POST[acbom]=='N') echo "SELECTED"; ?>>Manual</option>
                                    </select>
                                </td>
                         	</tr>
                            <tr>
                   				<td class="saludo1" style="width:50%;">.: SOBRETASA DE SEGURIDAD (Ley 1421 de 2011):</td>
                                <td style="width:12%;"><input type="text" name="id24" id="id24" style="width:100%;" value="<?php echo $_POST[id24]?>" onKeyUp="return tabular(event,this)" onChange="validar();" /></td>
                                <td></td>
                         	</tr>
                            <?php $_POST[id25]=$_POST[industria]+$valavisos+$_POST[id23]+$_POST[id22]+$_POST[id24];?>
                            <tr>
                   				<td class="saludo1" style="width:50%;">.: TOTAL IMPUESTO A CARGO:</td>
                                <td style="width:12%;"><input type="text" name="id25" id="id25" style="width:100%;" value="<?php echo $_POST[id25]?>" onKeyUp="return tabular(event,this)" onChange="validar();" readonly/></td>
                                <td></td>
                         	</tr>
                            <tr>
                   				<td class="saludo1" style="width:50%;">.: MENOS VALOR DE EXENCI&Oacute;N O EXONERACI&Oacute;N SOBRE EL IMPUESTO Y NO SOBRE LOS INGRESOS:</td>
                                <td style="width:12%;"><input type="text" name="id26" id="id26" style="width:100%;" value="<?php echo $_POST[id26]?>" onKeyUp="return tabular(event,this)" onChange="validar();" /></td>
                                <td></td>
                         	</tr>
                            
                            <?php
								
								if($_POST[id27]!=0){$_POST[retenciones]=$_POST[id27];}
								else{$_POST[retenciones]=$_POST[id27]=0;}
							?>
                            <tr>
                   				<td class="saludo1" style="width:50%;">.: MENOS RETENCIONES que le practicaron a favor de este municipio o distrito en este periodo:</td>
                                <td style="width:12%;"><input type="text" name="id27" id="id27" style="width:100%;" value="<?php echo $_POST[id27]?>" onKeyUp="return tabular(event,this)" onChange="validar();" /></td>
                                <td></td>
                         	</tr>
                            <tr>
                   				<td class="saludo1" style="width:50%;">.: MENOS AUTORRETENCIONES practicadas a favor de este municipio o distrito en este periodo:</td>
                                <td style="width:12%;"><input type="text" name="id28" id="id28" style="width:100%;" value="<?php echo $_POST[id28]?>" onKeyUp="return tabular(event,this)"onBlur="validar()" /></td>
                                <td></td>
                         	</tr>
                             <?php
								if($_POST[id29]!=0){$_POST[antivigant]=$_POST[id29];}
								else{$_POST[antivigant]=$_POST[id29]=0;}
							?>
                            <tr>
                   				<td class="saludo1" style="width:50%;">.: MENOS ANTICIPO LIQUIDADO EN EL A&Ntilde;O ANTERIOR:</td>
                                <td style="width:12%;"><input type="text" name="id29" id="id29" style="width:100%;" value="<?php echo $_POST[id29]?>" onKeyUp="return tabular(event,this)" onChange="validar();" /></td>
                                <td></td>
                         	</tr>
                            <?php
								if($_POST[id30]!=0){$_POST[antivigact]=$_POST[id30];}
								else{$_POST[antivigact]=$_POST[id30]=0;}
							?>
                             <tr>
                   				<td class="saludo1" style="width:50%;">.: ANTICIPO DEL AÑO SIGUIENTE  (Si existe, liquide porcentaje según Acuerdo Municipal o distrital):</td>
                                <td style="width:12%;"><input type="text" name="id30" id="id30" style="width:100%;" value="<?php echo $_POST[id30]?>" onKeyUp="return tabular(event,this)" onChange="validar();" /></td>
                         	</tr>
                            <?php 
								if($_POST[tpcalculo]=='2'){$_POST[id31]=$_POST[sanciones]=$_POST[id31];}
								
								if($_POST[sambom]=='S'){$actisam="readonly";} else {$actisam="";}
							?>
                            <tr>
                   				<td class="saludo1" style="width:50%;">.: SANCIONES:</td>
                                <td style="width:12%;"><input type="text" name="id31" id="id31" style="width:100%;" value="<?php echo $_POST[id31]?>" onKeyUp="return tabular(event,this)" onBlur="validar();" <?php echo $actisam; ?>/></td>
                                <td>
                                    <select name="sambom" id="sambom" onKeyUp="return tabular(event,this)" onChange="validar();">
                                    	<option value="S" <?php if($_POST[sambom]=='S') echo "SELECTED"; ?>>Automatica</option> 
                                        <option value="N" <?php if($_POST[sambom]=='N') echo "SELECTED"; ?>>Manual</option>
                                    </select>
                                </td>
                         	</tr>
                           	<tr>
                   				<td class="saludo1" style="width:50%;">.: MENOS SALDO A FAVOR DEL PERIODO ANTERIOR SIN SOLICITUD DE DEVOLUCI&Oacute;N O COMPENSACI&Oacute;N:</td>
                                <td style="width:12%;"><input type="text" name="id32" id="id32" style="width:100%;" value="<?php echo $_POST[id32]?>" onKeyUp="return tabular(event,this)" onChange="validar();" /></td>
                                <td></td>
                         	</tr>
                            <?php 
								$sumtotal=$_POST[id25]-$_POST[id26]-$_POST[id27]-$_POST[id28]-$_POST[id29]+$_POST[id30]+$_POST[id31]-$_POST[id32];
								if($sumtotal>=0){$_POST[id33]=$_POST[id35]=$_POST[valortotal]=$sumtotal;$_POST[id34]=$_POST[saldofavor]=0;}
								else{$_POST[id34]=$_POST[saldofavor]=$sumtotal;$_POST[id33]=$_POST[id35]=$_POST[valortotal]=0;}
							?>
                            <tr>
                   				<td class="saludo1" style="width:50%;">.: TOTAL SALDO A CARGO:</td>
                                <td style="width:12%;"><input type="text" name="id33" id="id33" style="width:100%;" value="<?php echo $_POST[id33]?>" onKeyUp="return tabular(event,this)" readonly/></td>
                                <td></td>
                         	</tr>
                            <tr>
                   				<td class="saludo1" style="width:50%;">.: TOTAL SALDO A FAVOR:</td>
                                <td style="width:12%;"><input type="text" name="id34" id="id34" style="width:100%;" value="<?php echo $_POST[id34]?>" onKeyUp="return tabular(event,this)" readonly/></td>
                                <td></td>
                         	</tr>
                            <tr>
                   				<td class="saludo1" style="width:50%;">.: VALOR A PAGAR:</td>
                                <td style="width:12%;"><input type="text" name="id35" id="id35" style="width:100%;" value="<?php echo $_POST[id35]?>" onKeyUp="return tabular(event,this)" readonly/></td>
                                <td></td>
                         	</tr>
                            <?php
								if($_POST[tpcalculo]=='1')
								{
									if($_POST[id36p]!=0)
									{
										$_POST[descuento]=$_POST[id36p];								
										switch($_POST[descunidos])
										{
											case 'NNN':	$_POST[id36a]=$_POST[id36b]=$_POST[id36c]=0;break;
											case 'SNN':	$_POST[id36a]=($_POST[id20]*$_POST[id36p])/100;
														$_POST[id36b]=$_POST[id36c]=0;break;
											case 'SSN':	$_POST[id36a]=($_POST[id20]*$_POST[id36p])/100;
														$_POST[id36b]=($_POST[id21]*$_POST[id36p])/100;
														$_POST[id36c]=0;break;
											case 'SNS':	$_POST[id36a]=($_POST[id20]*$_POST[id36p])/100;
														$_POST[id36b]=0;
														$_POST[id36c]=($_POST[id23]*$_POST[id36p])/100;break;
											case 'SSS':	$_POST[id36a]=($_POST[id20]*$_POST[id36p])/100;
														$_POST[id36b]=($_POST[id21]*$_POST[id36p])/100;
														$_POST[id36c]=($_POST[id23]*$_POST[id36p])/100;break;
											case 'NSS':	$_POST[id36a]=0;
														$_POST[id36b]=($_POST[id21]*$_POST[id36p])/100;
														$_POST[id36c]=($_POST[id23]*$_POST[id36p])/100;break;
											case 'NSN':	$_POST[id36a]=$_POST[id36c]=0;
														$_POST[id36b]=($_POST[id21]*$_POST[id36p])/100;break;
											case 'NNS':	$_POST[id36a]=$_POST[id36b]=0;
														$_POST[id36c]=($_POST[id23]*$_POST[id36p])/100;break;
										}
									}
									else {$_POST[descuento]=$_POST[id36a]=$_POST[id36b]=$_POST[id36c]=0;}
								}
							?>
                      		<tr>
                   				<td class="saludo1" style="width:50%;">.: DESCUENTO INDUSTRIA Y COMERCIO:</td>
                                <td style="width:12%;"><input type="text" name="id36a" id="id36a" style="width:100%;" value="<?php echo $_POST[id36a]?>" <?php echo "$vareditar  onChange='validar();'";?>/></td>
                                 <td></td>
                         	</tr>
                            <tr>
                   				<td class="saludo1" style="width:50%;">.: DESCUENTO AVISOS Y TABLEROS:</td>
                                <td style="width:12%;"><input type="text" name="id36b" id="id36b" style="width:100%;" value="<?php echo $_POST[id36b]?>" <?php echo "$vareditar  onChange='validar();'";?>/></td>
                                 <td></td>
                         	</tr>
                            <tr>
                   				<td class="saludo1" style="width:50%;">.: DESCUENTO BOMBERIL:</td>
                                <td style="width:12%;"><input type="text" name="id36c" id="id36c" style="width:100%;" value="<?php echo $_POST[id36c]?>" <?php echo "$vareditar  onChange='validar();'";?>/></td>
                                 <td></td>
                         	</tr>
                            <?php $_POST[id36]=$_POST[id36a]+$_POST[id36b]+$_POST[id36c];?>
                             <tr>
                   				<td class="saludo1" style="width:50%;">.: DESCUENTO POR PRONTO PAGO (Si existe, liquídelo según el Acuerdo Municipal o distrital):</td>
                                <td style="width:12%;"><input type="text" name="id36" id="id36" style="width:100%;" value="<?php echo $_POST[id36]?>" onKeyUp="return tabular(event,this)" readonly/></td>
                                <td><input type="number" name="id36p" id="id36p" min="0" max="100" step="any" value="<?php echo $_POST[id36p]?>" onChange="validar();" style="width:1.5cm;" <?php echo $vareditar2;?>/>%</td>
                         	</tr>
                            <?php
								if($_POST[tpcalculo]=='1')
								{
									if($_POST[id37p]!=0)
									{
										switch($_POST[intecunidos])
										{
											case 'NNN':	$_POST[id37a]=$_POST[id37b]=$_POST[id37c]=0;break;
											case 'SNN':	$_POST[id37a]=($_POST[id20]*$_POST[id37p])/100;
														$_POST[id37b]=$_POST[id37c]=0;break;
											case 'SSN':	$_POST[id37a]=($_POST[id20]*$_POST[id37p])/100;
														$_POST[id37b]=($_POST[id21]*$_POST[id37p])/100;
														$_POST[id37c]=0;break;
											case 'SNS':	$_POST[id37a]=($_POST[id20]*$_POST[id37p])/100;
														$_POST[id37b]=0;
														$_POST[id37c]=($_POST[id23]*$_POST[id37p])/100;break;
											case 'SSS':	$_POST[id37a]=($_POST[id20]*$_POST[id37p])/100;
														$_POST[id37b]=($_POST[id21]*$_POST[id37p])/100;
														$_POST[id37c]=($_POST[id23]*$_POST[id37p])/100;break;
											case 'NSS':	$_POST[id37a]=0;
														$_POST[id37b]=($_POST[id21]*$_POST[id37p])/100;
														$_POST[id37c]=($_POST[id23]*$_POST[id37p])/100;break;
											case 'NSN':	$_POST[id37a]=$_POST[id37c]=0;
														$_POST[id37b]=($_POST[id21]*$_POST[id37p])/100;break;
											case 'NNS':	$_POST[id37a]=$_POST[id36b]=0;
														$_POST[id37c]=($_POST[id23]*$_POST[id37p])/100;break;
										}
									}
									else {$_POST[intereses]=$_POST[id37a]=$_POST[id37b]=$_POST[id37c]=0;}
								}
								else{$_POST[id37]=$_POST[intereses]=$_POST[id37a]+$_POST[id37b]+$_POST[id37c];}
							?>
                            <tr>
                   				<td class="saludo1" style="width:50%;">.: INTERESES INDUSTRIA Y COMERCIO:</td>
                                <td style="width:12%;"><input type="text" name="id37a" id="id37a" style="width:100%;" value="<?php echo $_POST[id37a]?>" <?php echo "$vareditar  onChange='validar();'";?>/></td>
                                 <td></td>
                         	</tr>
                            <tr>
                   				<td class="saludo1" style="width:50%;">.: INTERESES AVISOS Y TABLEROS:</td>
                                <td style="width:12%;"><input type="text" name="id37b" id="id37b" style="width:100%;" value="<?php echo $_POST[id37b]?>" <?php echo "$vareditar  onChange='validar();'";?>/></td>
                                 <td></td>
                         	</tr>
                            <tr>
                   				<td class="saludo1" style="width:50%;">.: INTERESES BOMBERIL:</td>
                                <td style="width:12%;"><input type="text" name="id37c" id="id37c" style="width:100%;" value="<?php echo $_POST[id37c]?>" <?php echo "$vareditar  onChange='validar();'";?>/></td>
                                 <td></td>
                         	</tr>
                               
                             <?php
							 	if($_POST[tpcalculo]=='1')
								{
									if($_POST[id37p]!=0){$_POST[intereses]=$_POST[id37]=$_POST[id37a]+$_POST[id37b]+$_POST[id37c];$modinter="readonly";}
									else {$_POST[intereses]=$_POST[id37]; $modinter="";}
								}
							?>
                            <tr>
                   				<td class="saludo1" style="width:50%;">.: INTERESES DE MORA:</td>
                                <td style="width:12%;"><input type="text" name="id37" id="id37" style="width:100%;" value="<?php echo $_POST[id37]?>" onKeyUp="return tabular(event,this)" onChange="validar();" <?php echo $modinter;?>/></td>
                                <td><input type="number" name="id37p" id="id37p" min="0" max="100" step="any" value="<?php echo $_POST[id37p]?>" onChange="validar();" style="width:1.5cm;" <?php echo $vareditar2;?>/>%</td>
                         	</tr>
                            <?php $_POST[id38]=round($_POST[id35]-$_POST[id36]+$_POST[id37],-3,PHP_ROUND_HALF_UP);;?>
                            <tr>
                   				<td class="saludo1" style="width:50%;">.: TOTAL A PAGAR:</td>
                                <td style="width:12%;"><input type="text" name="id38" id="id38" style="width:100%;" value="<?php echo $_POST[id38]?>" onKeyUp="return tabular(event,this)" readonly/></td>
                                <td></td>
                         	</tr>
                            <tr>
                   				<td class="saludo1" style="width:50%;">.: LIQUIDE EL VALOR DEL PAGO VOLUNTARIO:</td>
                                <td style="width:12%;"><input type="text" name="id39" id="id39" style="width:100%;" value="<?php echo $_POST[id39]?>" onKeyUp="return tabular(event,this)" onChange="validar();" /></td>
                                <td></td>
                         	</tr>
                            <?php $_POST[id40]=$_POST[saldopagar]=$_POST[id38]+$_POST[id39];?>
                            <tr>
                   				<td class="saludo1" style="width:50%;">.: TOTAL A PAGAR CON PAGO VOLUNTARIO :</td>
                                <td style="width:12%;"><input type="text" name="id40" id="id40" style="width:100%;" value="<?php echo $_POST[id40]?>" onKeyUp="return tabular(event,this)" readonly/></td>
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
                                                    $_POST[nsancion]=$row[1]." - ".$row[2];
                                                    //$_POST[vporcentaje]=($_POST[industria]*$_POST[porcentaje])/100;
                                                }
                                                else{echo "<option value='$row[0]'>$row[1] - $row[2]</option>";}
                                            }	 	
                                        ?>
                                    </select>
                                    <input type="hidden" value="<?php echo $_POST[nsancion]?>" name="nsancion">
                                </td>
                                <td class="saludo1">%</td>
                                <td><input id="porcentaje" name="porcentaje" type="text" size="5" value="<?php echo $_POST[porcentaje]?>" readonly>%</td>
                                <td class="saludo1">Valor:</td>
                                <td><input id="vporcentaje" name="vporcentaje" type="text" value="<?php echo $_POST[vporcentaje]?>"/></td>
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
                                    <input type='hidden' name='ddesvalores[]' value='".$_POST[ddesvalores][$x]."'/>
                                    <tr>
                                        <td class='saludo2'>".$_POST[dndescuentos][$x]."</td>
                                        <td class='saludo2'>".$_POST[dporcentajes][$x]."</td>
                                        <td class='saludo2'>".$_POST[ddesvalores][$x]."</td>
                                        <td class='saludo2'><a href='#' onclick=' eliminardact2($x)'><img src='imagenes/del.png'></a></td>
                                    </tr>";
                                    $totaldes=$totaldes+$_POST[ddesvalores][$x];
                                }		 
                                echo"
                                <script>
                                    document.form2.totaldes.value='".ceil($totaldes)."';	
                                    calcularpago();
                                </script>";
								if($_POST[tpcalculo]=='1')
								{echo array_sum($_POST[ddesvalores]);
									if(array_sum($_POST[ddesvalores])>0)
									{
										echo $_POST[sambom];
										if($_POST[sambom]=='S'){$_POST[id31]=$_POST[sanciones]=array_sum($_POST[ddesvalores]);}
										$sumtotal=$_POST[id25]-$_POST[id26]-$_POST[id27]-$_POST[id28]-$_POST[id29]+$_POST[id30]+$_POST[id31]-$_POST[id32];
										if($sumtotal>=0){$_POST[id33]=$_POST[id35]=$sumtotal;$_POST[id34]=$_POST[saldofavor]=0;}
										else{$_POST[id34]=$_POST[saldofavor]=$sumtotal;$_POST[id33]=$_POST[id35]=0;}
										$_POST[id38]=round($_POST[id35]-$_POST[id36]+$_POST[id37],-3,PHP_ROUND_HALF_UP);
										$_POST[id40]=$_POST[saldopagar]=$_POST[id38]+$_POST[id39];
										
										echo" 
											<script>
												document.form2.id31.value='$_POST[id31]';
												document.form2.id33.value='$_POST[id33]';
												document.form2.id34.value='$_POST[id34]';
												document.form2.id35.value='$_POST[id35]';
												document.form2.id38.value='$_POST[id38]';
												document.form2.id40.value='$_POST[id40]';
											</script>";
									}
									else{echo"<script>document.form2.id31.value='$_POST[id31]';</script>";}
								}
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
                   	if($_POST[tpcalculo]=='1')
				   	{
                   		$limite=$_POST[salariomin];
                    	if($_POST[sinavisos]==1 )		 
						{			   
							if($minima==1)
							{
								$_POST[industria]=$_POST[industria]+$_POST[avisos]+$_POST[id19];
								$_POST[avisos]=0;
							}
							else {$_POST[avisos]=0;}
						}
				   	}
                ?> 
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
            <?php
                if($_POST[oculto]=='2')
                {
					preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $_POST[fecha],$fecha);
                    $fechaf="$fecha[3]-$fecha[2]-$fecha[1]";
					if(($_POST[id36a]+$_POST[id36b]+$_POST[id36c])>0)
					{
						$totalica=$_POST[industria]-$_POST[id36a];
						$totalbombe=$_POST[bomberil]-$_POST[id36c];
						$totalavisos=$_POST[avisos]-$_POST[id36b];
						$totaldesica=$_POST[id36a];
					}
					else
					{
						$totalica=$_POST[industria]-$_POST[id36];
						$totalbombe=$_POST[bomberil];
						$totalavisos=$_POST[avisos];
						$totaldesica=$_POST[id36];
					}
					$sumtop=$_POST[industria]+$_POST[avisos]+$_POST[bomberil]-$_POST[id36]-$_POST[antivigant]-$_POST[retenciones];
					$desindustriant=$desavisosant=$desbomberilant=0;
					if ($_POST[antivigant]>0 && $sumtop>=0)
					{
						$desindustriant=$_POST[industria]-$_POST[antivigant];
						if ($desindustriant<0)
						{
							$desindustriant=$_POST[industria];
							$desavisosant=$desindustriant+$_POST[avisos]-$_POST[antivigant];
							if($desavisosant<0)
							{
								$desavisosant=$_POST[avisos];
								$desbomberilant=$desindustriant+$desavisosant+$_POST[bomberil]-$_POST[antivigant];
								if($desbomberilant<0){$desbomberilant=0;}
								else{$desbomberilant=$_POST[antivigant]-$_POST[industria]-$_POST[avisos];}
							}
							else{$desavisosant=$_POST[antivigant]-$_POST[industria];}
						}
						else {$desindustriant=$_POST[antivigant];}
					}
					$nter=buscatercero($_POST[tercero]);
					if((float)$_POST[id37]>0)
					{
						$intetodos=(float)$_POST[id37a]+(float)$_POST[id37b]+(float)$_POST[id37c];
						if($intetodos>0)
						{
							$indinteres=(float)$_POST[id37a];
							$aviinteres=(float)$_POST[id37b];
							$bominteres=(float)$_POST[id37c];
						}
						else
						{
							$indinteres=(float)$_POST[id37];
							$aviinteres=0;
							$bominteres=0;
						}
					}
					$consec=selconsecutivo("tesoindustria","id_industria");
                    $_POST[idcomp]=$consec;	
					$idliquidacion=$_POST[idcomp];
					if( $_POST[consorcio]==1){$n1check='S';}
					else {$n1check='N';}
					if( $_POST[actipataut]==1){$n2check='S';}
					else {$n2check='N';}
                    //*********************CREACION DE LA LIQUIDACION ***************************
                    $sqlr="INSERT INTO tesoindustria (id_industria,fecha,vigencia,ageliquidado,tipo,tercero,valortotal,estado,ncuotas,pagos, numcorreccion,consorciounion,actividadespat,nestablecimientos,tipo_mov,tipcalculo) VALUES ('$_POST[idcomp]','$fechaf','$vigusu', '$_POST[ageliquida]', '$_POST[tipomov]','$_POST[tercero]','$_POST[id40]','S','$_POST[ncuotas]','0','$_POST[ncorreccion]','$n1check','$n2check', '$_POST[nestable]','101', '$_POST[tpcalculo]')";
                    if (!mysql_query($sqlr,$linkbd))
                    {echo "<script>despliegamodalm('visible','2','No se pudo ejecutar la petición Error al cargar T1');</script>";}
                    else
                    {
						$consecgra=selconsecutivo("tesoindustria_gra","idgravable");
						$sqlr="INSERT INTO tesoindustria_gra (idgravable,id_industria,formulario_id08,formulario_id09,formulario_id10, formulario_id11,formulario_id12,formulario_id13,formulario_id14,formulario_id15,formulario_id16,formulario_id17,formulario_id18,formulario_id19, 	estado) VALUES ('$consecgra','$_POST[idcomp]','$_POST[id08]','$_POST[id09]','$_POST[id10]','$_POST[id11]','$_POST[id12]','$_POST[id13]', '$_POST[id14]','$_POST[id15]','$_POST[id16]','$_POST[id17]','$_POST[id18]','$_POST[id19]','S')";
						if (!mysql_query($sqlr,$linkbd))
						 {echo "<script>despliegamodalm('visible','2','No se pudo ejecutar la petición Error al cargar T2');</script>";}
                        //*******************CREACION DEL DETALLE ***************
                        $sqlr="INSERT INTO tesoindustria_det (id_industria,industria,avisos,formulario_id22,bomberil,formulario_id24, formulario_id25,formulario_id26,retenciones,formulario_id28,antivigant,antivigact,sanciones,formulario_id32,valortotal,saldofavor,formulario_id36, formulario_id36a,formulario_id36b,formulario_id36c,vadescuento,formulario_id37,formulario_id37a,formulario_id37b,formulario_id37c,formulario_id37p, formulario_id38,formulario_id39,totalpagar) values ('$_POST[idcomp]','$_POST[id20]','$_POST[id21]','$_POST[id22]','$_POST[id23]','$_POST[id24]', '$_POST[id25]','$_POST[id26]','$_POST[id27]', '$_POST[id28]', '$_POST[id29]','$_POST[id30]','$_POST[id31]','$_POST[id32]','$_POST[id33]', '$_POST[id34]','$_POST[id36]','$_POST[id36a]','$_POST[id36b]','$_POST[id36c]','$_POST[id36p]','$_POST[id37]','$_POST[id37a]','$_POST[id37b]', '$_POST[id37c]','$_POST[id37p]','$_POST[id38]','$_POST[id39]','$_POST[id40]')";
                      	if (!mysql_query($sqlr,$linkbd))
						{echo "<script>despliegamodalm('visible','2','No se pudo ejecutar la petición Error al cargar T3');</script>";}
                        //***********ALMACENAMIENTO DE LOS CIIU ************************
                        for ($x=0;$x<count($_POST[dciiu]);$x++)
                        {		
                            $sqlr="INSERT INTO tesoindustria_ciiu(id_industria,codigociiu,tarifa,ingreso,valor,estado,id,vigencia) VALUES  ('$idliquidacion','".$_POST[dciiu][$x]."','".$_POST[dtarifas][$x]."','".$_POST[dingresoact][$x]."','".$_POST[dvalores][$x]."','S','$x','$_POST[ageliquida]')";
                            mysql_query($sqlr,$linkbd);
                        }
						//***********ALMACENAMIENTO DESCUENTOS ************************
						for ($x=0;$x<count($_POST[ddescuentos]);$x++)
						{	
							$consecsan=selconsecutivo("tesoindustria_san","idsanciones");
							$sqlr="INSERT INTO tesoindustria_san(idsanciones,id_industria,ddescuentos,dndescuentos,dporcentajes,ddesvalores,estado) VALUES  ('$consecsan','$idliquidacion','".$_POST[ddescuentos][$x]."','".$_POST[dndescuentos][$x]."','".$_POST[dporcentajes][$x]."','".$_POST[ddesvalores][$x]."','S')";
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
							switch($row[2])
							{
								case '00': //************Sanciones
								{
									if($_POST[id31]>0)
									{
										$sqlr2="SELECT * FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='00' AND tipo='C' AND fechainicial=(SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='00' AND tipo='C' AND fechainicial<='$fechaf')";
										$res2=mysql_query($sqlr2,$linkbd);
										while($row2=mysql_fetch_row($res2))
										{
											if($row2[3]=='N')
											{				 					  		
												if($row2[6]=='S')
												{				 
													$valordeb=$_POST[id31];
													$valorcred=0;
												}
												else
												{				 
													$valorcred=$_POST[id31];
													$valordeb=0;
												}					 
												$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('3 $idliquidacion', '$row2[4]','$_POST[tercero]','$row2[5]','Sanciones Industria Y Comercio $_POST[ageliquida]','','$valordeb','$valorcred','1','$_POST[vigencia]')";
												mysql_query($sqlr,$linkbd);	 						
											}						
										}
									}
								}break;
								case '04'://*****industria
								{
									$sqlr2="SELECT * FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='04' AND tipo='C' AND fechainicial=(SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='04' AND tipo='C' AND fechainicial<='$fechaf')";
									$res2=mysql_query($sqlr2,$linkbd);
									while($row2=mysql_fetch_row($res2))
									{
										if($row2[3]=='N')
										{				 					  		
											if($row2[6]=='S')
											{				 
												$valordeb=$_POST[industria];
												$valorcred=0;
											}
											else
											{				 
												$valorcred=$_POST[industria];
												$valordeb=0;
											}				
											$sqlr="insert into comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) values ('3 $idliquidacion', '$row2[4]','$_POST[tercero]', '$row2[5]','Industria y Comercio $_POST[ageliquida]','','$valordeb', '$valorcred','1','$_POST[vigencia]')";
											mysql_query($sqlr,$linkbd);	
											if($row2[6]=='S')
											{
												if($totaldesica>0)//descuento Industria
												{
													$sqlry="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) VALUES ('3 $idliquidacion','$row2[4]','$_POST[tercero]','$row2[5]','Descuento Industria y Comercio $_POST[ageliquida]','','0','$totaldesica','1','$_POST[vigencia]')";
													mysql_query($sqlry,$linkbd);
												}
												if($_POST[antivigact]>0)//anticipo vigencia actual
												{
													$sqlry="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) VALUES ('3 $idliquidacion','$row2[4]','$_POST[tercero]','$row2[5]','Anticipo vigencia Actual','','0', '$_POST[antivigact]','1','$_POST[vigencia]')";
												mysql_query($sqlry,$linkbd);
												}/*
												if($_POST[antivigant]>0)//anticipo vigencia Anterior
												{
													$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) VALUES ('3 $idliquidacion','$row2[4]','$_POST[tercero]','$row2[5]','Anticipo vigencia Anterior','','0', '$desindustriant','1','$_POST[vigencia]')";
													mysql_query($sqlr,$linkbd);	 
												}
												if($_POST[retenciones]>0)//retenciones
												{
													$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) VALUES ('3 $idliquidacion','$row2[4]','$_POST[tercero]','$row2[5]','Retenciones Industria y Comercio','','0', '$_POST[retenciones]','1', '$_POST[vigencia]')";
													mysql_query($sqlr,$linkbd);	 
												}
												if($sumtop<0)
												{
													$sqlry="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) VALUES ('3 $idliquidacion','$row2[4]','$_POST[tercero]','$row2[5]','Cruce ICA con el saldo del contribuyente', '','0','$totalica','1','$_POST[vigencia]')";
													mysql_query($sqlry,$linkbd);
												}*/
											}
										}
									}//
								}break;
								case '05'://************avisos
								{
									if($_POST[avisos]>0)
									{
										$sqlr2="SELECT * FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='05' AND tipo='C' AND fechainicial=(SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='05' AND tipo='C' AND fechainicial<='$fechaf')";
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
												else
												{				 
													$valorcred=$_POST[avisos];
													$valordeb=0;
												}					 
												$sqlr="INSERT INTO comprobante_det (id_comp, cuenta, tercero, centrocosto, detalle, cheque, valdebito, valcredito, estado, vigencia) VALUES ('3 $idliquidacion', '$row2[4]','$_POST[tercero]','$row2[5]','Avisos y Tableros $_POST[ageliquida]','','$valordeb', '$valorcred','1','$_POST[vigencia]')";
												mysql_query($sqlr,$linkbd);	 
												if($row2[6]=='S')
												{
													if ($_POST[id36b]>0)
													{
														$sqlry="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) VALUES ('3 $idliquidacion','$row2[4]','$_POST[tercero]','$row2[5]','Descuento Avisos y Tableros $_POST[ageliquida]','', '0','$_POST[id36b]','1','$_POST[vigencia]')";
														mysql_query($sqlry,$linkbd);
													}/*
													if($desavisosant>0)
													{
														$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito, estado,vigencia) VALUES ('3 $idliquidacion','$row2[4]','$_POST[tercero]', '$row2[5]','Anticipo vigencia Anterior','','0', '$desavisosant','1', '$_POST[vigencia]')";
														mysql_query($sqlr,$linkbd);	 
													}
													if($sumtop<0)
													{
														$sqlry="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) VALUES ('3 $idliquidacion','$row2[4]','$_POST[tercero]','$row2[5]','Cruce Avisos con el saldo del contribuyente', '','0','$totalavisos','1','$_POST[vigencia]')";
														mysql_query($sqlry,$linkbd);
													}*/
												}
											}						
										}
									}
								}break;
								case '06'://*********bomberil ********
								{
									if($_POST[bomberil]>0)
									{
										$sqlr2="SELECT * FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='06' AND tipo='C' AND fechainicial=(SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='06' AND tipo='C' AND fechainicial<='$fechaf')";
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
												else
												{				 
													$valorcred=$_POST[bomberil];
													$valordeb=0;
												}					 
												$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) VALUES ('3 $idliquidacion','$row2[4]','$_POST[tercero]','$row2[5]','Bomberil $_POST[ageliquida]','','$valordeb', '$valorcred','1','$_POST[vigencia]')";
												mysql_query($sqlr,$linkbd);	 
												if($row2[6]=='S')
												{
													if ($_POST[id36c]>0)
													{
														$sqlry="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) VALUES ('3 $idliquidacion','$row2[4]','$_POST[tercero]','$row2[5]','Descuentos Bomberil $_POST[ageliquida]', '','0', '$_POST[id36c]','1','$_POST[vigencia]')";
														mysql_query($sqlry,$linkbd);
													}/*
													if($desbomberilant>0)
													{
														$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito, estado,vigencia) VALUES ('3 $idliquidacion','$row2[4]','$_POST[tercero]', '$row2[5]','Anticipo vigencia Anterior','','0', '$desbomberilant','1', '$_POST[vigencia]')";
														mysql_query($sqlr,$linkbd);	 
													}
													if($sumtop<0)
													{
														$sqlry="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) VALUES ('3 $idliquidacion','$row2[4]','$_POST[tercero]','$row2[5]','Cruce Bomberil con el saldo del contribuyente', '','0','$totalbombe','1','$_POST[vigencia]')";
														mysql_query($sqlry,$linkbd);
													}*/
												}
											}						
										}
									}
								}break;
								case 'P04'://*****INTERESES BOMBERIL
								{
									if($bominteres>0)
									{
										$sqlr2="SELECT * FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='P04' AND tipo='C' AND fechainicial=(SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='P04' AND tipo='C' AND fechainicial<='$fechaf')";
										$res2=mysql_query($sqlr2,$linkbd);
										while($row2=mysql_fetch_row($res2))
										{
											if($row2[3]=='N')
											{				 					  		
												if($row2[6]=='S')
												{				 
													$valordeb=$bominteres;
													$valorcred=0;
												}
												else
												{				 
													$valorcred=$bominteres;
													$valordeb=0;
												}				
												$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('3 $idliquidacion','$row2[4]','$_POST[tercero]', '$row2[5]','Intereses Bomberil $_POST[ageliquida]','', '$valordeb','$valorcred','1','$_POST[vigencia]')";
												mysql_query($sqlr,$linkbd);	
											}
										}
									}
								}break;
								case 'P10'://descuentos sobretasa bomberil
								{
									if($_POST[id36c]>0)
									{
										$sqlr2="SELECT * FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='P10' AND tipo='C' AND fechainicial=(SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='P10' AND tipo='C' AND fechainicial<='$fechaf')";
										$res2=mysql_query($sqlr2,$linkbd);
										while($row2=mysql_fetch_row($res2))
										{
											if($row2[3]=='N')
											{
												if($row2[6]=='N')
												{				 
													$valordeb=$_POST[id36c];
													$valorcred=0;
													$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito, estado,vigencia) VALUES ('3 $idliquidacion','$row2[4]','$_POST[tercero]','$row2[5]','Descuentos Bomberil','','$valordeb', '$valorcred','1','$_POST[vigencia]')";
													mysql_query($sqlr,$linkbd);	
												}
											}
										}
									}
								}break; 
								case 'P11B'://RETENCIONES INDUSTRIA Y COMERCIO 
								{ 
									if($_POST[retenciones]>0)
									{
										$sqlr2="SELECT * FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='P11' AND tipo='C' AND fechainicial=(SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='P11' AND tipo='C' AND fechainicial<='$fechaf')";
										$res2=mysql_query($sqlr2,$linkbd);
										while($row2=mysql_fetch_row($res2))
										{
											if($row2[3]=='N')
											{
												if($row2[6]=='S')
												{	
													if($sumtop<0)//si el total es negativo
													{
														if($_POST[industria]>0)
														{
															$sqlry="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) VALUES ('3 $idliquidacion','$row2[4]','$_POST[tercero]','$row2[5]','Cruce RETENCIONES ICA con el saldo del contribuyente','','$totalica','0','1','$_POST[vigencia]')";
															mysql_query($sqlry,$linkbd);	 
														}
														if($_POST[bomberil]>0)
														{
															$sqlry="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('3 $idliquidacion','$row2[4]','$_POST[tercero]','$row2[5]','Cruce RETENCIONES Bomberil con el saldo del contribuyente','','$totalbombe','0','1','$_POST[vigencia]')";
															mysql_query($sqlry,$linkbd);	
														}
														if($_POST[avisos]>0)
														{
															$sqlry="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('3 $idliquidacion','$row2[4]','$_POST[tercero]','$row2[5]','Cruce RETENCIONES Avisos con el saldo del contribuyente','','$totalavisos','0','1', '$_POST[vigencia]')";
															mysql_query($sqlry,$linkbd);	
														}
													}
													else
													{
														$valordeb=$_POST[retenciones];			 
														$valorcred=0;
														$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) VALUES ('3 $idliquidacion','$row2[4]','$_POST[tercero]','$row2[5]','Retenciones Industria y Comercio','','$valordeb','$valorcred', '1', '$_POST[vigencia]')";
														mysql_query($sqlr,$linkbd);
													}
												}
											}
										}
									}
								} break;
								case 'P12'://Anticipo vigencia Actual
								{
									if($_POST[antivigact]>0)
									{
										$sqlr2="SELECT * FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='P12' AND tipo='C' AND fechainicial=(SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='P12' AND tipo='C' AND fechainicial<='$fechaf')";
										$res2=mysql_query($sqlr2,$linkbd);
										while($row2=mysql_fetch_row($res2))
										{
											if($row2[3]=='N')
											{
												if($row2[6]=='N')
												{	
													$valordeb=$_POST[antivigact];			 
													$valorcred=0;
													$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) VALUES ('3 $idliquidacion','$row2[4]','$_POST[tercero]','$row2[5]','Anticipo vigencia Actual','', '$valordeb','$valorcred','1','$_POST[vigencia]')";
													mysql_query($sqlr,$linkbd);	
												}
											}
										}
									}
								}break;	
								case 'P13B'://Anticipo vigencia Anterior
								{
									if($_POST[antivigant]>0)
									{
										$sqlr2="SELECT * FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='P13' AND tipo='C' AND fechainicial=(SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='P13' AND tipo='C' AND fechainicial<='$fechaf')";
										$res2=mysql_query($sqlr2,$linkbd);
										while($row2=mysql_fetch_row($res2))
										{
											if($row2[3]=='N')
											{
												if($row2[6]=='N')
												{				 
													if($sumtop<0)//si el total es negativo
													{
														if($_POST[industria]>0)
														{
															$sqlry="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) VALUES ('3 $idliquidacion','$row2[4]','$_POST[tercero]','$row2[5]','Cruce  ICA con el saldo del contribuyente', '','$totalica','0','1', '$_POST[vigencia]')";
															mysql_query($sqlry,$linkbd);	 
														}
														if($_POST[bomberil]>0)
														{
															$sqlry="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) VALUES ('3 $idliquidacion','$row2[4]','$_POST[tercero]','$row2[5]','Cruce Bomberil con el saldo del contribuyente','','$totalbombe','0','1', '$_POST[vigencia]')";
															mysql_query($sqlry,$linkbd);	
														}
														if($_POST[avisos]>0)
														{
															$sqlry="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito, valcredito, estado, vigencia) VALUES ('3 $idliquidacion','$row2[4]','$_POST[tercero]','$row2[5]','Cruce Avisos con el saldo del contribuyente','','$totalavisos','0','1', '$_POST[vigencia]')";
															mysql_query($sqlry,$linkbd);	
														}
													}
													else
													{
														$valordeb=$_POST[antivigant];
														$valorcred=0;
														$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) VALUES ('3 $idliquidacion','$row2[4]','$_POST[tercero]', '$row2[5]','Anticipo vigencia Anterior','', '$valordeb','$valorcred','1', '$_POST[vigencia]')";
														mysql_query($sqlr,$linkbd);	 
													}
												}
											}
										}
									}
								}break;	
								case 'P14'://descuento industria y comercio
								{
									if($totaldesica>0)
									{
										$sqlr2="SELECT * FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='P14' AND tipo='C' AND fechainicial=(SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='P14' AND tipo='C' AND fechainicial<='$fechaf')";
										$res2=mysql_query($sqlr2,$linkbd);
										while($row2=mysql_fetch_row($res2))
										{
											if($row2[3]=='N')
											{
												if($row2[6]=='S')
												{				 
													$valordeb=$totaldesica;
													$valorcred=0;
													$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito, estado,vigencia) VALUES ('3 $idliquidacion','$row2[4]','$_POST[tercero]','$row2[5]','Descuento Industria y Comercio','','$valordeb', '$valorcred','1', '$_POST[vigencia]')";
													mysql_query($sqlr,$linkbd);	 
												}
											}
										}
									}
								}break;
								case 'P15'://descuento avisos y tableros
								{
									if($_POST[id36b]>0)
									{
										$sqlr2="SELECT * FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='P15' AND tipo='C' AND fechainicial=(SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='P15' AND tipo='C' AND fechainicial<='$fechaf')";
										$res2=mysql_query($sqlr2,$linkbd);
										while($row2=mysql_fetch_row($res2))
										{
											if($row2[3]=='N')
											{
												if($row2[6]=='S')
												{				 
													$valordeb=$_POST[id36b];
													$valorcred=0;
													$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) VALUES ('3 $idliquidacion','$row2[4]','$_POST[tercero]','$row2[5]','Descuento Avisos y Tableros','','$valordeb', '$valorcred','1', '$_POST[vigencia]')";
													mysql_query($sqlr,$linkbd);	 
												}
											}
										}
									}
								}break;
								case 'P16'://*****INTERESES INDUSTRIA
								{
									if($indinteres>0)
									{
										$sqlr2="SELECT * FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='P16' AND tipo='C' AND fechainicial=(SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='P16' AND tipo='C' AND fechainicial<='$fechaf')";
										$res2=mysql_query($sqlr2,$linkbd);
										while($row2=mysql_fetch_row($res2))
										{
											if($row2[3]=='N')
											{				 					  		
												if($row2[6]=='S')
												{				 
													$valordeb=$indinteres;
													$valorcred=0;
												}
												else
												{				 
													$valorcred=$indinteres;
													$valordeb=0;
												}				
												$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) VALUES ('3 $idliquidacion','$row2[4]','$_POST[tercero]','$row2[5]','Intereses Industria y Comercio $_POST[ageliquida]', '','$valordeb','$valorcred','1','$_POST[vigencia]')";
												mysql_query($sqlr,$linkbd);	
											}
										}
									}
								}break;
								case 'P17'://*****INTERESES AVISOS Y TABLEROS
								{
									if($aviinteres>0)
									{
										$sqlr2="SELECT * FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='P17' AND tipo='C' AND fechainicial=(SELECT MAX(fechainicial) FROM conceptoscontables_det WHERE estado='S' AND modulo='4' AND codigo='P17' AND tipo='C' AND fechainicial<='$fechaf')";
										$res2=mysql_query($sqlr2,$linkbd);
										while($row2=mysql_fetch_row($res2))
										{
											if($row2[3]=='N')
											{				 					  		
												if($row2[6]=='S')
												{				 
													$valordeb=$aviinteres;
													$valorcred=0;
												}
												else
												{				 
													$valorcred=$aviinteres;
													$valordeb=0;
												}				
												$sqlr="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) VALUES ('3 $idliquidacion','$row2[4]','$_POST[tercero]','$row2[5]','Intereses Avisos y Tableros $_POST[ageliquida]','', '$valordeb','$valorcred','1','$_POST[vigencia]')";
												mysql_query($sqlr,$linkbd);	
											}
										}
									}
								}break;
							}
						}
						echo "<script>despliegamodalm('visible','1','La liquidación de industria y comercio se creo correctamente');</script>";
                    }//**** FIN DEL ELSE DE PRIMERA SQL GUARDA LIQUIDACION ***********************   
                }
            ?>	
			<div id="bgventanamodal2">
                <div id="ventanamodal2">
                    <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                    </IFRAME>
                </div>
       	 	</div> 
            <script type="text/javascript">$('#nestable').numeric({allowThouSep: false,allowDecSep: false,allowMinus: false});</script>
            <script type="text/javascript">$('#ageliquida').numeric({allowThouSep: false,allowDecSep: false,allowMinus: false});</script>
            <script type="text/javascript">$('#tercero').numeric({allowThouSep: false,allowDecSep: false,allowMinus: false});</script>
            <script type="text/javascript">$('#ncorreccion').numeric({allowThouSep: false,allowDecSep: false,allowMinus: false});</script>
            <script type="text/javascript">$('#ingreso').numeric({allowThouSep: false,allowDecSep: false,allowMinus: false});</script>
            <script type="text/javascript">$('#id08').numeric({allowThouSep: true,allowDecSep: false,allowMinus: false});</script>
            <script type="text/javascript">$('#id09').numeric({allowThouSep: true,allowDecSep: false,allowMinus: false});</script>
            <script type="text/javascript">$('#id11').numeric({allowThouSep: true,allowDecSep: false,allowMinus: false});</script>
            <script type="text/javascript">$('#id12').numeric({allowThouSep: true,allowDecSep: false,allowMinus: false});</script>
            <script type="text/javascript">$('#id13').numeric({allowThouSep: true,allowDecSep: false,allowMinus: false});</script>
            <script type="text/javascript">$('#id14').numeric({allowThouSep: true,allowDecSep: false,allowMinus: false});</script>
            <script type="text/javascript">$('#id15').numeric({allowThouSep: true,allowDecSep: false,allowMinus: false});</script>
            <script type="text/javascript">$('#id18').numeric({allowThouSep: true,allowDecSep: false,allowMinus: false});</script>
            <script type="text/javascript">$('#id19').numeric({allowThouSep: true,allowDecSep: false,allowMinus: false});</script>
            <script type="text/javascript">$('#id22').numeric({allowThouSep: true,allowDecSep: false,allowMinus: false});</script>
            <script type="text/javascript">$('#id23').numeric({allowThouSep: true,allowDecSep: false,allowMinus: false});</script>
            <script type="text/javascript">$('#id24').numeric({allowThouSep: true,allowDecSep: false,allowMinus: false});</script>
            <script type="text/javascript">$('#id26').numeric({allowThouSep: true,allowDecSep: false,allowMinus: false});</script>
			<script type="text/javascript">$('#id27').numeric({allowThouSep: true,allowDecSep: false,allowMinus: false});</script>
            <script type="text/javascript">$('#id28').numeric({allowThouSep: true,allowDecSep: false,allowMinus: false});</script>
            <script type="text/javascript">$('#id29').numeric({allowThouSep: true,allowDecSep: false,allowMinus: false});</script>
            <script type="text/javascript">$('#id30').numeric({allowThouSep: true,allowDecSep: false,allowMinus: false});</script>
            <script type="text/javascript">$('#id32').numeric({allowThouSep: true,allowDecSep: false,allowMinus: false});</script>
            <script type="text/javascript">$('#id34').numeric({allowThouSep: true,allowDecSep: false,allowMinus: false});</script>
            <script type="text/javascript">$('#id35').numeric({allowThouSep: true,allowDecSep: false,allowMinus: false});</script>
            <script type="text/javascript">$('#id37').numeric({allowThouSep: true,allowDecSep: false,allowMinus: false});</script>
            <script type="text/javascript">$('#id39').numeric({allowThouSep: true,allowDecSep: false,allowMinus: false});</script>
		</form>
	</body>
</html>