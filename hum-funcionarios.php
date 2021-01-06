<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	header("Content-Type: text/html;charset=iso-8859-1");
	date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-type" content="text/html; charset=iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Spid - Gesti&oacute;n Humana</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/calendario.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
		<script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
        <script>
			function despliegamodal2(_valor,_num)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else 
				{
					switch(_num)
					{
						case '0':	document.getElementById('ventana2').src="cargosadministrativos-ventana01.php";break;
						case '1':	document.getElementById('ventana2').src="tercerosgral-ventana04.php?objeto=tercero&nobjeto=ntercero&nfoco=tercero&valsub=SI"; break;
						case '2':	document.getElementById('ventana2').src="tercerosgral-ventana01.php?objeto=eps&nobjeto=neps&nfoco=arp";break;
						case "3":	document.getElementById('ventana2').src="tercerosgral-ventana01.php?objeto=arp&nobjeto=narp&nfoco=afp";break;
						case "4":	document.getElementById('ventana2').src="tercerosgral-ventana01.php?objeto=afp&nobjeto=nafp&nfoco=fondocesa";break;
						case "5":	document.getElementById('ventana2').src="tercerosgral-ventana01.php?objeto=fondocesa&nobjeto=nfondocesa&nfoco=cargo";break;
						case "6":	document.getElementById('ventana2').src="nivelsalarial-ventana01.php";break;
					}
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
						case "1":	document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
						case "2":	document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
						case "3":	document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
						case "4":	document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;	
					}
				}
			}
			function funcionmensaje()
			{
				var _cons=document.getElementById('idfunc').value;
				document.location.href = "hum-funcionarioseditar.php?idfun="+_cons+"&scrtop=0&numpag=1&limreg=10&filtro1=&filtro2=";
			}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.form2.oculto.value='2';document.form2.submit();break;
				}
			}
			function validar(){document.form2.submit();}
			function buscar(_num)
			{
				switch(_num)
				{
					case "1":	
						var validacion01=document.getElementById('tercero').value;
						if (validacion01.trim()!='')
						{
							document.getElementById('vbuscar').value="1";
							document.form2.submit();
							break;
						}
						else
						{
							document.getElementById('ntercero').value=""
							document.getElementById('direccion').value="";
							document.getElementById('telefono').value="";
							document.getElementById('celular').value="";
							document.getElementById('email').value="";
							break;
						}
				}
			}
			function guardar()
			{
				if ((document.form2.fechain.value!='' && existeFecha(document.form2.fechain.value))  && (document.form2.fechaeps.value!='' && existeFecha(document.form2.fechaeps.value)) && (document.form2.fechaarl.value!='' && existeFecha(document.form2.fechaarl.value))  && document.form2.nomcargoad.value!='' && document.form2.ntercero.value!=''  && document.form2.neps.value!='' && document.form2.narp.value!='' && document.form2.nivsal.value!='' && document.form2.numcc.value!='')
				{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
  				else {despliegamodalm('visible','2','Faltan datos para completar el registro');}
			}
		</script>
		<?php titlepag(); ?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
    		<tr><script>barra_imagenes("hum");</script><?php cuadro_titulos();?></tr>	 
    		<tr><?php menu_desplegable("hum");?></tr>
			<tr>
  				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='hum-funcionarios.php'" class="mgbt"/><img src="imagenes/guarda.png" title="Guardar" onClick="guardar()" class="mgbt"/><img src="imagenes/busca.png" title="Buscar" onClick="location.href='hum-funcionariosbuscar.php'" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" onClick="<?php echo paginasnuevas("hum");?>" class="mgbt"><img src='imagenes/iratras.png' title='Men&uacute; Nomina' onClick="location.href='hum-menunomina.php'" class='mgbt'></td>
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
				if ($_POST[vbuscar]=="1")
				{
					$sqlr="SELECT nombre1,nombre2,apellido1,apellido2,direccion,telefono,celular,email,id_tercero FROM terceros where cedulanit='$_POST[tercero]' AND estado='S'";
					$res=mysql_query($sqlr,$linkbd);
					while($r=mysql_fetch_row($res))
					{
						if ($r[3]!="" && $r[1]!=""){$_POST[ntercero]="$r[2] $r[3] $r[0] $r[1]";}
						elseif($r[3]!=""){$_POST[ntercero]="$r[2] $r[3] $r[0]";}
						elseif($r[1]!=""){$_POST[ntercero]="$r[2] $r[0] $r[1]";}
						else {$_POST[ntercero]="$r[2] $r[0]";}
						if($r[4]!=""){$_POST[direccion]=$r[4];}
						else {$_POST[direccion]="SIN DIRECCION DIGITADA";}
						if($r[5]!=""){$_POST[telefono]=$r[5];}
						else{$_POST[telefono]="SIN NUMERO TELEFONICO";}
						if($r[6]!=""){$_POST[celular]=$r[6];}
						else{$_POST[celular]="SIN NUMERO CELULAR";}
						if($r[7]!=""){$_POST[email]=$r[7];}
						else{$_POST[email]="SIN CORREO ELECTRONICO";}
						$_POST[idterc]=$r[8];
					}
					$sqlr00="SELECT T1.codcargo,T1.nombrecargo,T1.clasificacion FROM planaccargos T1, planestructura_terceros T2  WHERE T1.estado = 'S' AND T1.codcargo=T2.codcargo AND T2.cedulanit='$_POST[tercero]' AND T1.estado='S' AND T2.estado='S'";
					$resp00 = mysql_query($sqlr00,$linkbd);
					$row00=mysql_fetch_row($resp00);
					$sqlr01="SELECT nombre,valor FROM humnivelsalarial WHERE id_nivel='$row00[2]'";
					$resp01 = mysql_query($sqlr01,$linkbd);
					$row01=mysql_fetch_row($resp01);
					$_POST[idcargoad]=$row00[0];
					$_POST[nomcargoad]=$row00[1];
					$_POST[cargo]=$row00[2];
					$_POST[nivsal]=$row01[0];
					$_POST[asigbas]=$row01[1];
					$_POST[asigbas2]="$ ".number_format($row01[1], 0, ',', '.');
				}
			?>
        	<table class="inicio">
      			<tr>
        			<td class="titulos" colspan="7">.: Ingresar Funcionario Nuevo</td>
                    <td class="cerrar" style="width:7%" onClick="location.href='hum-principal.php'">Cerrar</td>
      			</tr>
                <tr>
                	<td class="saludo1" style="width:3cm;">.: Fecha Ingreso:</td>
        			<td><input type="text" name="fechain" id="fc_1198971547" value="<?php echo $_POST[fechain]?>" maxlength="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" style="width:80%;"/>&nbsp;<img src="imagenes/calendario04.png" onClick="displayCalendarFor('fc_1198971547');" class="icobut" title="Calendario"/></td>
                	<td class="saludo1">.: Cargo:</td>
                    <td colspan="2"><input type="text" name="nomcargoad" id="nomcargoad" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[nomcargoad]?>" style="width:100%" readonly></td>
                    <td><img class="icobut" src="imagenes/find02.png"  title="Lista de Cargos" onClick="despliegamodal2('visible','0');"/>&nbsp;<img class="icobut" src="imagenes/ladd.png" title="Agregar Cargo" onClick="mypop=window.open('adm-cargosadmguardar.php','','');mypop.focus();"/></td>
                    <td rowspan="11" style="border:double;"></td>
                </tr>
                <input type="hidden" name="idcargoad" id="idcargoad" value="<?php echo $_POST[idcargoad]?>"/>
                <tr>
     				<td class="saludo1">.: Tercero:</td>
          			<td style="width:15%;"><input type="text" name="tercero" id="tercero" onKeyUp="return tabular(event,this)" onBlur="buscar('1')" value="<?php echo $_POST[tercero]?>" style="width:80%">&nbsp;<img class="icobut" src="imagenes/find02.png"  title="Listado Terceros" onClick="despliegamodal2('visible','1');"/></td>
           			<td style="width:50%;" colspan="3"><input type="text" name="ntercero" id="ntercero" value="<?php echo $_POST[ntercero]?>" style="width:100%" readonly></td>
                    <?php
						if($_POST[ntercero]==""){$editer=" class='icobut1' src='imagenes/usereditd.png'";}
						else{$editer=" class='icobut' src='imagenes/useredit.png' onClick=\"mypop=window.open('hum-terceroseditar01.php?idter=$_POST[idterc]','','');mypop.focus();\"";}
					?>
                    <td style="width:1.5cm;">&nbsp;<img class="icobut" src="imagenes/usuarion.png" title="Crear Tercero" onClick="mypop=window.open('hum-terceros01.php','','');mypop.focus();"/>&nbsp;<img <?php echo $editer; ?> title="Editar Tercero" /></td>
              	</tr>
                <tr>
        			<td class="saludo1">.: Direcci&oacute;n:</td>
        			<td colspan="5"><input type="text" name="direccion" id="direccion" value="<?php echo $_POST[direccion]?>" style="width:100%;" readonly/></td>
               	</tr>
                <tr>
         			<td class="saludo1">.: Telefono:</td>
        			<td><input type="text" name="telefono" id="telefono" value="<?php echo $_POST[telefono]?>" style="width:100%;" readonly/></td>
		 			<td class="saludo1" style="width:10%;">.: Celular:</td>
        			<td colspan="3"><input type="text" name="celular" id="celular" value="<?php echo $_POST[celular]?>" style="width:100%;" readonly/></td>
      	 		</tr>
                <tr>
        			<td class="saludo1">.: E-mail:</td>
        			<td colspan="5"><input type="text" name="email" id="email" value="<?php echo $_POST[email]?>" style="width:100%;" readonly/></td>
                </tr>
                <tr>
              		<td class="saludo1">.: Cuenta:</td>
            		<td><input type="text" name="tercerocta" id="tercerocta" value="<?php echo $_POST[tercerocta]?>" style="width:100%"/></td>
                    <td class="saludo1">.: Banco:</td>
                    <td colspan="3">
                    	<select name="bancocta" id="bancocta" style='text-transform:uppercase; width:70%; height:22px;'>
                        	<option value="">....</option>
                            <?php
                                $sqlr="SELECT codigo, nombre FROM hum_bancosfun WHERE estado='S' ORDER BY CONVERT(codigo, SIGNED INTEGER)";
                                $resp = mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($resp)) 
                                {
                                    if($row[0]==$_POST[bancocta]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
                                    else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}	  
                                }
                            ?>
                        </select>
                        &nbsp;<img class="icobut" src="imagenes/ladd.png" title="Crear Banco" onClick="mypop=window.open('hum-bancos.php','','');mypop.focus();"/>&nbsp;<img class="icorot" src="imagenes/reload.png" title="Actualizar Lista Bancos" onClick="document.form2.submit();"/>
                    </td>
      			</tr>	
                <tr>
                	<td class="saludo1">.: EPS:</td>
            		<td><input type="text" name="eps" id="eps" value="<?php echo $_POST[eps]?>" onKeyUp="return tabular(event,this)" style="width:80%;" onBlur="buscar('2')"/>&nbsp;<img class="icobut" src="imagenes/find02.png" onClick="despliegamodal2('visible','2');" title="Lista"/></td>
                    <td colspan="2"><input type="text" id="neps" name="neps" value="<?php echo $_POST[neps]?>" onKeyUp="return tabular(event,this)"  style="width:100%;" readonly/></td>
                    <td><input type="text" name="fechaeps" id="fc_1198971548" value="<?php echo $_POST[fechaeps]?>" maxlength="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" style="width:100%;"/></td>
                    <td><img src="imagenes/calendario04.png" onClick="displayCalendarFor('fc_1198971548');" class="icobut" title="Fecha Ingreso EPS"/></td>
                </tr>
                <tr>
                	<td class="saludo1">.: ARL: </td>
        			<td><input type="text" name="arp" id="arp" value="<?php echo $_POST[arp]?>" onKeyUp="return tabular(event,this)" style="width:80%;" onBlur="buscar('3')"/>&nbsp;<img class="icobut" src="imagenes/find02.png" onClick="despliegamodal2('visible','3');" title="Lista"/></td>
                    <td colspan="2"><input type="text" id="narp" name="narp" value="<?php echo $_POST[narp]?>" onKeyUp="return tabular(event,this)" style="width:100%;" readonly></td>
                    <td><input type="text" name="fechaarl" id="fc_1198971549" value="<?php echo $_POST[fechaarl]?>" maxlength="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" style="width:100%;"/></td>
                    <td><img src="imagenes/calendario04.png" onClick="displayCalendarFor('fc_1198971549');" class="icobut" title="Fecha Ingreso ARL"/></td>
                </tr>
                <tr>
                	<td class="saludo1">.: AFP:</td>
        			<td><input type="text" id="afp" name="afp" value="<?php echo $_POST[afp]?>" onKeyUp="return tabular(event,this)" style="width:80%;" onBlur="buscar('4')"/>&nbsp;<img class="icobut" src="imagenes/find02.png" onClick="despliegamodal2('visible','4');" /></td>
                  	<td colspan="2"><input type="text" name="nafp" id="nafp"  value="<?php echo $_POST[nafp]?>" onKeyUp="return tabular(event,this)" style="width:100%;" readonly></td>
                    <td><input type="text" name="fechaafp" id="fc_1198971550" value="<?php echo $_POST[fechaafp]?>" maxlength="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" style="width:100%;"/></td>
                    <td><img src="imagenes/calendario04.png" onClick="displayCalendarFor('fc_1198971550');" class="icobut" title="Fecha Ingreso AFP"/></td>
                </tr>
                <tr>
                	<td class="saludo1">.: Fondo Cesantias:</td>
        			<td ><input type="text" id="fondocesa" name="fondocesa" value="<?php echo $_POST[fondocesa]?>" onKeyUp="return tabular(event,this)" style="width:80%;" onBlur="buscar('5')"/>&nbsp;<img class="icobut" src="imagenes/find02.png" title="Lista" onClick="despliegamodal2('visible','5');"></td>
                    <td colspan="2"><input id="nfondocesa" name="nfondocesa" type="text" value="<?php echo $_POST[nfondocesa]?>" onKeyUp="return tabular(event,this)" style="width:100%;" readonly></td>
                    <td><input type="text" name="fechafdc" id="fc_1198971551" value="<?php echo $_POST[fechafdc]?>" maxlength="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" style="width:100%;"/></td>
                    <td><img src="imagenes/calendario04.png" onClick="displayCalendarFor('fc_1198971551');" class="icobut" title="Fecha Ingreso Fondo Cesantias"/></td>
                </tr>
                <tr>
 					<td class="saludo1">.: Escala:</td>
        			<td><input type="text" name="cargo" id="cargo" value="<?php echo $_POST[cargo]?>" style="width:80%;" readonly/></td>
                   	<td colspan="2"><input type="text" name="nivsal" id="nivsal" value="<?php echo $_POST[nivsal]?>" style="width:100%;" readonly></td>
                    <td style="width:10%;"><input type="text" name="asigbas2" id="asigbas2" value="<?php echo $_POST[asigbas2]?>" style="width:100%;" readonly/></td>
                    <input type="hidden" name="asigbas" id="asigbas" value="<?php echo $_POST[asigbas]?>"/>
				</tr>
                <tr>
                	<td class="saludo1">.: Periodo:</td>
                    <td>
                    	<select name="tperiodo" id="tperiodo" style="width:80%;">
				  			<option value="-1">Seleccione ....</option>
                            <option value="30"<?php if($_POST[tperiodo]==30){echo"SELECTED";}?>>MENSUAL</option>
                            <option value="15"<?php if($_POST[tperiodo]==15){echo"SELECTED";}?>>QUINCENAL</option>
		  				</select>
                    </td>
                	<td class="saludo1">.: Centro de Costo:</td>
                    <td colspan="2">
                    	<select name="numcc" id="numcc" style='text-transform:uppercase; width:70%; height:22px;'>
                        	<option value="">....</option>
                            <?php
                                $sqlr="SELECT id_cc, nombre FROM centrocosto WHERE estado='S' ORDER BY CONVERT(id_cc, SIGNED INTEGER)";
                                $resp = mysql_query($sqlr,$linkbd);
                                while ($row =mysql_fetch_row($resp)) 
                                {
                                    if($row[0]==$_POST[numcc])
									{
										echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";
										$_POST[nomcc]=$row[1];
									}
                                    else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}	  
                                }
                            ?>
                        </select>
                        &nbsp;<img class="icobut" src="imagenes/ladd.png" title="Crear Centro de Costo" onClick="mypop=window.open('cont-buscacentrocosto.php','','');mypop.focus();"/>&nbsp;<img class="icorot" src="imagenes/reload.png" title="Actualizar Lista Centro de Costo" onClick="document.form2.submit();"/>
                        <input type="hidden" name="nomcc" id="nomcc" value="<?php echo $_POST[nomcc];?>"/>
                    </td>
                </tr>
            	<tr>
     				<td class="saludo1">.: Pago Cesantias:</td>
        			<td>
            			<select name="pagces" id="pagces" style="width:80%;">
                			<option value="" <?php if($_POST[pagces]==""){echo "SELECTED";} ?>> ...</option>
                			<option value="A" <?php if($_POST[pagces]=="A"){echo "SELECTED";} ?>> Anual</option>
                			<option value="M" <?php if($_POST[pagces]=="M"){echo "SELECTED";} ?>> Mensual</option>
						</select>
        			</td>
                    <td class="saludo1">.: Nivel ARL:</td>
					<td>
						<select name="nivelarl" id="nivelarl" style="width:100%;">
							<?php
								$sqlr="SELECT id,codigo,tarifa,detalle FROM hum_nivelesarl WHERE estado='S' ORDER BY id";
								$resp = mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($resp)) 
								{
									if($row[0]==$_POST[nivelarl])
									{
										echo "<option value='$row[0]' SELECTED>Nivel $row[1] ($row[2]) - $row[3]</option>";
									}
									else {echo "<option value='$row[0]'>Nivel $row[1] ($row[2]) - $row[3]</option>";}	  
								}
							?>
						</select>
					</td>
                </tr> 
          	</table>
            <input type="hidden" name="oculto" id="oculto" value="1"/>
            <input type="hidden" name="vbuscar" id="vbuscar" value="0"/>
            <input type="hidden" name="idterc" id="idterc" value="<?php echo $_POST[idterc];?>"/>
            <input type="hidden" name="idfunc" id="idfunc" value="<?php echo $_POST[idfunc];?>"/>
            <?php
				if($_POST[oculto]==2)
				{
					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechain],$fecha);
					$fechaini="$fecha[3]-$fecha[2]-$fecha[1]";	
					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechaeps],$fecha);
					$fechainieps="$fecha[3]-$fecha[2]-$fecha[1]";	
					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechaarl],$fecha);
					$fechainiarl="$fecha[3]-$fecha[2]-$fecha[1]";	
					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechafdc],$fecha);
					$fechainifdc="$fecha[3]-$fecha[2]-$fecha[1]";
					if($_POST[fechaafp]!="")
					{
						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechaafp],$fecha);
						$fechainiafp="$fecha[3]-$fecha[2]-$fecha[1]";
					}
					else{$fechainiafp="0000-00-00";}
					$idfuncionario=selconsecutivo('hum_funcionarios','codfun');
					echo"<script>document.getElementById('idfunc').value='$idfuncionario'</script>;";
					$sqlr="INSERT INTO hum_funcionarios (codfun,item,descripcion,valor,fechain,fechasal,estado) VALUES 
					('$idfuncionario','IDCARGO','$_POST[idcargoad]','1','$fechaini','0000-00-00','S'),
					('$idfuncionario','NOMCARGO','$_POST[nomcargoad]','2','$fechaini','0000-00-00','S'),
					('$idfuncionario','IDESCALA','$_POST[cargo]','3','$fechaini','0000-00-00','S'),
					('$idfuncionario','INOMESCALA','$_POST[nivsal]','4','$fechaini','0000-00-00','S'),
					('$idfuncionario','VALESCALA','$_POST[asigbas]','5','$fechaini','0000-00-00','S'),
					('$idfuncionario','DOCTERCERO','$_POST[tercero]','6','$fechaini','0000-00-00','S'),
					('$idfuncionario','NOMTERCERO','$_POST[ntercero]','7','$fechaini','0000-00-00','S'),
					('$idfuncionario','DIRTERCERO','$_POST[direccion]','8','$fechaini','0000-00-00','S'),
					('$idfuncionario','TELTERCERO','$_POST[telefono]','9','$fechaini','0000-00-00','S'),
					('$idfuncionario','CELTERCERO','$_POST[celular]','10','$fechaini','0000-00-00','S'),
					('$idfuncionario','EMATERCERO','$_POST[email]','11','$fechaini','0000-00-00','S'),
					('$idfuncionario','NUMCUENTA','$_POST[tercerocta]','12','$fechaini','0000-00-00','S'),
					('$idfuncionario','NOMCUENTA','$_POST[bancocta]','13','$fechaini','0000-00-00','S'),
					('$idfuncionario','NUMEPS','$_POST[eps]','14','$fechainieps','0000-00-00','S'),
					('$idfuncionario','NOMEPS','$_POST[neps]','15','$fechainieps','0000-00-00','S'),
					('$idfuncionario','NUMARL','$_POST[arp]','16','$fechainiarl','0000-00-00','S'),
					('$idfuncionario','NOMARL','$_POST[narp]','17','$fechainiarl','0000-00-00','S'),
					('$idfuncionario','NUMAFP','$_POST[afp]','18','$fechainiafp','0000-00-00','S'),
					('$idfuncionario','NOMAFP','$_POST[nafp]','19','$fechainiafp','0000-00-00','S'),
					('$idfuncionario','NUMFDC','$_POST[fondocesa]','20','$fechainiafp','0000-00-00','S'),
					('$idfuncionario','NOMFDC','$_POST[nfondocesa]','21','$fechainiafp','0000-00-00','S'),
					('$idfuncionario','NUMCC','$_POST[numcc]','22','$fechaini','0000-00-00','S'),
					('$idfuncionario','NOMCC','$_POST[nomcc]','23','$fechaini','0000-00-00','S'),
					('$idfuncionario','PERLIQ','$_POST[tperiodo]','24','$fechaini','0000-00-00','S'),
					('$idfuncionario','TPCESANTIAS','$_POST[pagces]','25','$fechaini','0000-00-00','S'),
					('$idfuncionario','ESTGEN','S','26','$fechaini','0000-00-00','S'),
					('$idfuncionario','NIVELARL','$_POST[nivelarl]','27','$fechaini','0000-00-00','S')"; 
					if (!mysql_query($sqlr,$linkbd))
					{
						$e =mysql_error(mysql_query($sqlr,$linkbd));
						echo"<script>despliegamodalm('visible','2','No se pudo ejecutar la petición: $e');</script>";
					}
  					else {echo "<script>despliegamodalm('visible','1','Se ha almacenado el funcionario con Exito');</script>";}
				}
            ?>
		</form>
        <div id="bgventanamodal2">
			<div id="ventanamodal2">
				<IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"></IFRAME>
        	</div>
		</div>
    </body>
</html>