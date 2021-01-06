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
		<link href="css/tabs.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="JQuery/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="JQuery/autoNumeric-master/autoNumeric-min.js"></script>
		<script>
			function validar(){
				document.form2.oculto="";
				document.form2.submit();}
			function validar2()
			{
				document.form2.oculto="1";
				document.form2.submit();
				
			}
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
				if(document.form2.tipomovimiento.value=='201')
				{
					ingresos2=document.getElementsByName('dselvigencias[]');
					var validacion00=document.form2.concepto.value;
					if (document.form2.fecha.value!='' && ingresos2.length>0 && validacion00.trim()!='' && document.form2.ntercero.value!='' && document.form2.modorec.value!='')
					{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
					else
					{
						despliegamodalm('visible','2','Faltan datosss para completar el registro');
						document.form2.fecha.focus();
						document.form2.fecha.select();
					}
				}
				else
				{
					var validacion00=document.form2.descripcion.value;
					if (document.form2.fecha.value!='' && validacion00.trim()!='')
					{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
					else
					{
						despliegamodalm('visible','2','Faltan datoss para completar el registro');
						document.form2.fecha.focus();
						document.form2.fecha.select();
					}
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
			function buscaracuerdo(e)
 			{
				if (document.form2.codacuerdo.value!="")
				{
 					document.form2.bin.value='1';
 					document.form2.submit();
				}
 			}
			 function valorsaldo()
			 {
				 document.form2.valors.value='1';
				 document.form2.submit();
			 }
			function buscavigencias(objeto,posicion)
			{
				vvigencias=document.getElementsByName('dselvigencias[]');
				totalceldas=vvigencias.length;
				if(objeto.checked)
				{
					for(x=0;x<=posicion;x++)
					{
						vvigencias.item(x).check=true;
						
					}
				}
				else 
				{
					for(x=posicion;x<totalceldas;x++)
					{
						vvigencias.item(x).checked=false;
					}
				}
			}
			function despliegamodal2(_valor,_num)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else 
				{
					switch(_num)
					{
						case '1':	document.getElementById('ventana2').src="tercerosgral-ventana01.php?objeto=tercero&nobjeto=ntercero&nfoco=codingreso";break;
						case '2':	document.getElementById('ventana2').src="abonos-ventana.php";break;
						case '3':	document.getElementById('ventana2').src="#";break;
						case '4':	document.getElementById('ventana2').src="reversar-abono.php";break;
						case '5':	document.getElementById('ventana2').src="cuentasbancarias-ventana02.php?tipoc=D&obj01=banco&obj02=nbanco&obj03=&obj04=cb&obj05=ter";break;
					}
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
				if(document.form2.tipomovimiento.value=='201')
				{
					var numdocar=document.getElementById('idcomp').value;
					document.location.href = "teso-editaabono.php?idabono="+numdocar;
				}
				else
				{
					var numdocar=document.getElementById('idabono').value;
					document.location.href = "teso-editaabono.php?idabono="+numdocar;
				}
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
					<a onClick="location.href='teso-abonoacuerdopredial.php'" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
					<a class="mgbt" onClick="guardar()"><img src="imagenes/guarda.png" title="Guardar"/></a>
					<a onClick="location.href='teso-buscaabonos.php'"  class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a class="mgbt" onClick="<?php echo paginasnuevas("teso");?>"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
					<a class="mgbt1"><img src="imagenes/printd.png" style="width:29px;height:25px;"/></a>
					<a href="teso-gestioncobroporcuotas.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
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
			<input type="hidden" name="valors" value="0">
			<input type="hidden" name="oculto" id="oculto" value="0"/>
			<?php
                $vigencia=date(Y);
                $vigusu=vigencia_usuarios($_SESSION[cedulausu]);
				//*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
                if($_POST[oculto]=="")
                {
					$_POST[tipomovimiento]="201";
                    $check1="checked";
                    $sqlr="select max(id_abono) from tesoabono ";
                    $res=mysql_query($sqlr,$linkbd);
                    $consec=0;
                    while($r=mysql_fetch_row($res)){$consec=$r[0];}
                    $consec+=1;
                    $_POST[idcomp]=$consec;	
                    $fec=date("d/m/Y");
                    $_POST[fecha]=$fec; 		 		  			 
					$_POST[valor]=0;	
					$_POST[saldo]=0;	
                }
 				//***** busca tercero
			 	if($_POST[bt]=='1')
			 	{
			  		$nresul=buscatercero($_POST[tercero]);
			  		if($nresul!=''){$_POST[ntercero]=$nresul;}
				 	else{$_POST[ntercero]="";}
				 }
				 if($_POST[valors]=='1')
				 {
					$_POST[saldo]=$_POST[valor];
				 }
				 if($_POST[bin]=='1')
				 {
					$sqlr="SELECT codcatastral FROM tesoacuerdopredial WHERE estado='S' AND idacuerdo='$_POST[codacuerdo]'";
					$res=mysql_query($sqlr,$linkbd);
					$row=mysql_fetch_row($res);
					$_POST[codcatastral]=$row[0];
				 }
				 $sqlr="SELECT * FROM tesoabono WHERE idacuerdo='$_POST[codacuerdo]' AND estado='S'";
				 $res=mysql_query($sqlr);
				 $saldoanterior=0;
				 while($row=mysql_fetch_assoc($res))
				 {
					$sql="SELECT SUM(valor) FROM tesoabono_det WHERE id_abono='".$row['id_abono']."' AND estado='S'";
					$rs=mysql_query($sql);
					$rw=mysql_fetch_row($rs);
					$saldoanterior=$saldoanterior+$row["valortotal"]-$rw[0];
				 }
				 $_POST[saldoant]=$saldoanterior;
			?>
			<table class="inicio">
				<tr>
					<td class="titulos" style="width:100%;">.: Tipo de Movimiento 					
						<select name="tipomovimiento" id="tipomovimiento" onKeyUp="return tabular(event,this)" onChange="validar()" style="width:20%;" >
							<?php 
								$user=$_SESSION[cedulausu];
								$sql="SELECT * from permisos_movimientos WHERE usuario='$user' AND estado='T' ";
								$res=mysql_query($sql,$linkbd);
								$num=mysql_num_rows($res);
								if($num==1){
									$sqlr="select * from tipo_movdocumentos where estado='S' and modulo=4 AND (id='2' OR id='4')";
									$resp = mysql_query($sqlr,$linkbd);
									while ($row =mysql_fetch_row($resp)) 
									{
										if($_POST[tipomovimiento]==$row[0].$row[1]){
											echo "<option value='$row[0]$row[1]' SELECTED >$row[0]$row[1]-$row[2]</option>";
										}else{
											echo "<option value='$row[0]$row[1]'>$row[0]$row[1]-$row[2]</option>";
										}
									}
								}else{
									$sql="SELECT codmov,tipomov from permisos_movimientos WHERE usuario='$user' AND estado='S' AND modulo='4' AND transaccion='TPB' ";
									$res=mysql_query($sql,$linkbd);
									while($row = mysql_fetch_row($res)){
										if($_POST[tipomovimiento]==$row[0]){
											echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";
										}else{
											echo "<option value='$row[0]'>$row[0] - $row[1]</option>";
										}
										
									}
								}
								
							?>
						</select>
					</td>
					<td style="width:80%;">
					</td>
				</tr>
			</table>
			<?php if($_POST[tipomovimiento]=='201'){?>
    		<table class="inicio" style="width:99.7%">
      			<tr >
        			<td class="titulos" colspan="8">Abono Acuerdo Predial Por Cuotas</td>
        			<td class="cerrar" style="width:7%"><a onClick="location.href='teso-principal.php'">&nbsp;Cerrar</a></td>
      			</tr>
      			<tr>
       		 		<td class="saludo1" style="width:3.5cm;">N&uacute;mero Abono:</td>
        			<td style="width:15%;"><input type="text"  name="idcomp" id="idcomp" value="<?php echo $_POST[idcomp]?>" onKeyUp="return tabular(event,this)" style="width:80%;" readonly/></td>
	  				<td class="saludo1" style="width:2%;">Fecha:</td>
        			<td style="width:10%;">
                    	<input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY"  value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this)" onKeyDown="mascara(this,'/',patron,true)" maxlength="10" style="width:80%;"/>&nbsp;<a onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/calendario04.png" style="width:20px; cursor:pointer"/></a>
                   	</td>
					<td class="saludo1" style="width:2%">Saldo Ant: </td>
					<td>
				 		<input type="text" name="saldoant" id="saldoant" value="<?php echo $_POST[saldoant] ?>" readonly>
					</td>
                   <td rowspan="4" colspan="2" style="background:url(imagenes/siglas.png); background-repeat:no-repeat; background-position:right; background-size: 100% 100%;" ></td>  
				   <td></td>
        		</tr>
      			<tr>
        			<td class="saludo1">Concepto abono:</td>
        			<td colspan="3" ><input type="text" name="concepto" id="concepto" value="<?php echo $_POST[concepto]?>"  onKeyUp="return tabular(event,this)" style="width:100%;"/></td>
					<td class="saludo1">Recaudado en:</td>
                    <td>
                    	<select name="modorec" id="modorec" onKeyUp="return tabular(event,this)" onChange="validar()" style="width:100%;">
							<option value="">Seleccione ...</option>
          					<option value="banco" <?php if($_POST[modorec]=='banco') echo "SELECTED"; ?>>Banco</option>
		 					<option value="caja" <?php if($_POST[modorec]=='caja') echo "SELECTED"; ?>>Caja</option>         
        				</select>
                   	</td>
              	</tr>  
				  <?php
					if ($_POST[modorec]=='banco')
					{
						echo"
						<tr>
							<td class='saludo1'>Cuenta :</td>
							<td>
								<input type='text' name='cb' id='cb' value='$_POST[cb]' style='width:80%;'/>&nbsp;
								<a onClick=\"despliegamodal2('visible','5');\"  style='cursor:pointer;' title='Listado Cuentas Bancarias'>	
									<img src='imagenes/find02.png' style='width:20px;'/>
								</a>
							</td>
							<td colspan='4'>
									<input type='text' id='nbanco' name='nbanco' style='width:100%;' value='$_POST[nbanco]'  readonly>
							</td>
									<input type='hidden' name='banco' id='banco' value='$_POST[banco]'/>
									<input type='hidden' id='ter' name='ter' value='$_POST[ter]'/></td>
						</tr>";
					}
				?> 
      			<tr>
        			<td class="saludo1">Documento: </td>
        			<td><input  type="text" name="tercero" id="tercero" value="<?php echo $_POST[tercero]?>" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" style="width:80%;" />&nbsp;<a onClick="despliegamodal2('visible','1');" title="Listado Terceros"><img src="imagenes/find02.png" style="width:20px;cursor:pointer;"/></a></td>
			  		<td class="saludo1">Contribuyente:</td>
	  				<td colspan="3" >
                		<input type="text" id="ntercero" name="ntercero" value="<?php echo $_POST[ntercero]?>" onKeyUp="return tabular(event,this)" style="width:100%;" readonly>
                        <input type="hidden" value="0" name="bt"/>
                        <input type="hidden" id="ct" name="ct" value="<?php echo $_POST[ct]?>"/>
						
                        <input type="hidden" name="cobrorecibo" value="<?php echo $_POST[cobrorecibo]?>" >
                        <input type="hidden" name="vcobrorecibo" value="<?php echo $_POST[vcobrorecibo]?>" >
                        <input type="hidden" name="tcobrorecibo" value="<?php echo $_POST[tcobrorecibo]?>" > 
					</td>
      			</tr>
	  			<tr>
                    <td class="saludo1">Num acuerdo:</td>
                    <td ><input type="text" id="codacuerdo" name="codacuerdo" value="<?php echo $_POST[codacuerdo]?>" onKeyUp="return tabular(event,this)" onBlur="buscaracuerdo(event)" style="width:80%;">&nbsp;<a onClick="despliegamodal2('visible','2');" title="Listado de Acuerdos"><img src="imagenes/find02.png" style="width:20px;cursor:pointer;"/></a><input type="hidden" value="0" name="bin"></td>
                    <td colspan="2"><input type="text" name="codcatastral" id="codcatastral" value="<?php echo $_POST[codcatastral]?>" style="width:100%;" readonly></td>
                    <td class="saludo1" style="width:6%">Valor:</td>
                    <td style="width:10%">
						<input type="hidden" id="valor" name="valor" value="<?php echo $_POST[valor]?>" >
						<input type="text" name="valorvl" id="valorvl" data-a-sign="$" data-a-dec="<?php echo $_SESSION["spdecimal"];?>" data-a-sep="<?php echo $_SESSION["spmillares"];?>" data-v-min='0' onKeyUp="sinpuntitos2('valor','valorvl');return tabular(event,this);" onBlur="valorsaldo()" value="<?php echo $_POST[valorvl]; ?>" style='text-align:right;' />
						<input type="hidden" name="saldo" value="<?php echo $_POST[saldo]; ?>">
						
                    </td>
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
                            document.getElementById('codacuerdo').focus();
                            document.getElementById('codacuerdo').select();
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
				 
            ?>
            <div class="subpantallac7" style="height:46%; width:99.5%; overflow-x:hidden;">
                <table class="inicio">
                    <tr><td colspan="12" class="titulos">Detalles Acuerdos Predial</td></tr>                  
                    <tr>
                        <td class="titulos2">Vigencia</td>
                        <td class="titulos2">Predial</td>
                        <td class="titulos2">Tasa</td>
						<td class="titulos2">Interes Predial</td>
						<td class="titulos2">Descuento Interes</td>
						<td class="titulos2">Bomberil</td>
						<td class="titulos2">Interes Bomberil</td>
						<td class="titulos2">Ambiente</td>
						<td class="titulos2">Interes Ambiente</td>
						<td class="titulos2">Descuento</td>
						<td class="titulos2">Valor total</td> 
                        <td class="titulos2" style="width:5%">Sel.</td>
                        <input type='hidden' name='elimina' id='elimina'/>
                 	</tr>
						<?php 
							$xpm=0;
							$chk='';
							$ch=esta_en_array($_POST[dselvigencias], $r[0]);
							if($ch==1){$chk=" checked";}
							$iter='zebra1';
							$iter2='zebra2';	
							$varcol=$co;
							$chek=" checked";
							$sqlr="SELECT *FROM tesoacuerdopredial_det WHERE idacuerdo='$_POST[codacuerdo]' AND estado='P'";
							$res=mysql_query($sqlr,$linkbd);
							while($row=mysql_fetch_assoc($res))
							{
								
								echo "
									<tr class='$iter' style='background-color:#4BCADC'>
										<td>".$row['vigencia']."</td>
										<td style='text-align:right;'>$ ".$row['predial']."</td>
										<td>".$row['tasa']."</td>
										<td style='text-align:right;'>$ ".$row['intpredial']."</td>
										<td style='text-align:right;'>$ ".$row['descuenint']."</td>
										<td style='text-align:right;'>$ ".$row['bomberil']."</td>
										<td style='text-align:right;'>$ ".$row['intbomberil']."</td>
										<td style='text-align:right;'>$ ".$row['ambiente']."</td>
										<td style='text-align:right;'>$ ".$row['intambiente']."</td>
										<td style='text-align:right;'>$ ".$row['descuento']."</td>
										<td style='text-align:right;'>$ ".$row['valtotal']."</td>
										<td><input type='checkbox' value='".$row['vigencia']."' disabled $chek>Pago</td>
									</tr>";
								$aux=$iter;
								$iter=$iter2;
								$iter2=$aux;
							}
							$sqlr="SELECT *FROM tesoacuerdopredial_det WHERE idacuerdo='$_POST[codacuerdo]' AND estado='S'";
							$res=mysql_query($sqlr,$linkbd);
							while($row=mysql_fetch_assoc($res))
							{
								$sq="SELECT avaluos FROM tesoprediosavaluos WHERE codigocatastral='$_POST[codcatastral]' and vigencia='".$row['vigencia']."'";
								$rs=mysql_query($sq,$linkbd);
								$rw=mysql_fetch_assoc($rs);
								echo "
									<input type='hidden' name='dvigencias[]' value='".$row['vigencia']."' />
									<input type='hidden' name='davaluos[]' value='".$rw[0]."' />
									<input type='hidden' name='dpredial[]' value='".$row['predial']."'/>
									<input type='hidden' name='dtasa[]' value='".$row['tasa']."'/>
									<input type='hidden' name='dintpredial[]' value='".$row['intpredial']."'/>
									<input type='hidden' name='ddescuenint[]' value='".$row['descuenint']."'/>
									<input type='hidden' name='dbomberil[]' value='".$row['bomberil']."'/>
									<input type='hidden' name='dintbomberil[]' value='".$row['intbomberil']."'/>
									<input type='hidden' name='dambiente[]' value='".$row['ambiente']."'/>
									<input type='hidden' name='dintambiente[]' value='".$row['intambiente']."'/>
									<input type='hidden' name='ddescuento[]' value='".$row['descuento']."'/>
									<input type='hidden' name='dvaltotal[]' value='".$row['valtotal']."'/>
									<tr class='$iter' name='colorcheck[]'>
										<td>".$row['vigencia']."</td>
										<td style='text-align:right;'>$ ".$row['predial']."</td>
										<td>".$row['tasa']."</td>
										<td style='text-align:right;'>$ ".$row['intpredial']."</td>
										<td style='text-align:right;'>$ ".$row['descuenint']."</td>
										<td style='text-align:right;'>$ ".$row['bomberil']."</td>
										<td style='text-align:right;'>$ ".$row['intbomberil']."</td>
										<td style='text-align:right;'>$ ".$row['ambiente']."</td>
										<td style='text-align:right;'>$ ".$row['intambiente']."</td>
										<td style='text-align:right;'>$ ".$row['descuento']."</td>
										<td style='text-align:right;'>$ ".$row['valtotal']."</td>
										<td><input type='checkbox' name='dselvigencias[]' value='".$row['vigencia']."' onClick='buscavigencias(this,$xpm)' $chk></td>
									</tr>";
								$_POST[tasa]=$row['tasa'];
								$aux=$iter;
								$iter=$iter2;
								$iter2=$aux;
								$xpm=$xpm+1;
							}
							?>
								<script>
									vvigencias=document.getElementsByName('dselvigencias[]');
									vtotal=document.getElementsByName("dvaltotal[]"); 
									trcheck=document.getElementsByName('colorcheck[]');
									valabono=parseFloat(document.form2.saldo.value) + parseFloat(document.form2.saldoant.value);
									totalceldas=vvigencias.length;
									for(x=0;x<=totalceldas;x++)
									{

										if(parseFloat(vtotal.item(x).value)>valabono)
										{
											vvigencias.item(x).disabled=true;
											valabono=0;
										}
										else
										{
											valabono=valabono-vtotal.item(x).value;
											trcheck.item(x).style.backgroundColor='#2ECC71';
										}
											
									}
								</script>
                </table>
            </div>
			<?php }if($_POST[tipomovimiento]=='401'){?>
				<table class="inicio">
				<tr>
					<td class="titulos" colspan="6">.: Documento a Reversar</td>
				</tr>
				<tr> 
					<td class="saludo1" style="width:10%;">Numero Abono:</td>
					<td style="width:10%;">
						<input type="hidden" name="nabono" id="nabono" value="<?php echo $_POST[nabono]?>">
						<input type="text" name="idabono" id="idabono" value="<?php echo $_POST[idabono]; ?>" style="width:80%;" onKeyUp="return tabular(event,this)" onBlur="validar2()" readonly>
						<a href="#" onClick="despliegamodal2('visible','4','<?php echo $_POST[vigencia]?>');" title="Buscar CxP"><img src="imagenes/find02.png" style="width:20px;"></a>
						<input type="hidden" name="vigencia" value="<?php echo $_POST[vigencia]?>">
					</td>
					<td class="saludo1" style="width:10%;">Fecha:</td>
					<td style="width:10%;">
						<input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" style="width:80%;" title="DD/MM/YYYY"/>&nbsp;<a href="#" onClick="displayCalendarFor('fc_1198971545');" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px;"/></a>
					</td>
					<td class="saludo1" style="width:10%;">Descripcion</td>
					<td style="width:60%;" colspan="3">
						<input type="text" name="descripcion" id="descripcion" value="<?php echo $_POST[descripcion]?>" style="width:100%;">
					</td>
				</tr>	
				<tr>
					<td class="saludo1">No Acuerdo Predial: </td>
					<td><input type="text" name="codigoacuerdo" id="codigoacuerdo" value="<?php echo $_POST[codigoacuerdo];?>" readonly></td>
					<td class="saludo1">Valor Abono</td>
					<td><input type="text" name="valortot" id="valortot" value="<?php echo $_POST[valortot];?>" readonly>
				</tr>
			</table>
			<div class="subpantallac7" style="height:56.3%; width:99.5%; overflow-x:hidden;">
                <table class="inicio">
                    <tr><td colspan="12" class="titulos">Detalles Acuerdos Predial</td></tr>                  
                    <tr>
                        <td class="titulos2">Vigencia</td>
                        <td class="titulos2">Predial</td>
                        <td class="titulos2">Tasa</td>
						<td class="titulos2">Interes Predial</td>
						<td class="titulos2">Descuento Interes</td>
						<td class="titulos2">Bomberil</td>
						<td class="titulos2">Interes Bomberil</td>
						<td class="titulos2">Ambiente</td>
						<td class="titulos2">Interes Ambiente</td>
						<td class="titulos2">Descuento</td>
						<td class="titulos2">Valor total</td> 
                        <td class="titulos2" style="width:5%">Sel.</td>
                        <input type='hidden' name='elimina' id='elimina'/>
                 	</tr>
                        <?php 
                            $iter='zebra1';
                            $iter2='zebra2';
                            $chek=" checked";
                            $sqlr1="SELECT *from tesoabono_det WHERE id_abono='$_POST[idabono]'";
                            $res1=mysql_query($sqlr1);
                            while($row1=mysql_fetch_assoc($res1))
                            {
                                $sqlr="SELECT *FROM tesoacuerdopredial_det WHERE idacuerdo='$_POST[codigoacuerdo]' AND estado='P' AND vigencia='".$row1['vigencia']."'";
                                $res=mysql_query($sqlr,$linkbd);
                                $row=mysql_fetch_assoc($res);
                                echo "
                                    <input type='hidden' name='dvigenciasr[]' value='".$row['vigencia']."' />
                                    <input type='hidden' name='davaluos[]' value='".$rw[0]."' />
                                    <input type='hidden' name='codcatastral' value='".$row1['codcatastral']."' />
                                    <input type='hidden' name='dpredial[]' value='".$row['predial']."'/>
                                    <input type='hidden' name='dtasa[]' value='".$row['tasa']."'/>
                                    <input type='hidden' name='dintpredial[]' value='".$row['intpredial']."'/>
                                    <input type='hidden' name='ddescuenint[]' value='".$row['descuenint']."'/>
                                    <input type='hidden' name='dbomberil[]' value='".$row['bomberil']."'/>
                                    <input type='hidden' name='dintbomberil[]' value='".$row['intbomberil']."'/>
                                    <input type='hidden' name='dambiente[]' value='".$row['ambiente']."'/>
                                    <input type='hidden' name='dintambiente[]' value='".$row['intambiente']."'/>
                                    <input type='hidden' name='ddescuento[]' value='".$row['descuento']."'/>
                                    <input type='hidden' name='dvaltotal[]' value='".$row['valtotal']."'/>

									<tr class='$iter' style='background-color:#4BCADC'>
										<td>".$row['vigencia']."</td>
										<td style='text-align:right;'>$ ".$row['predial']."</td>
										<td>".$row['tasa']."</td>
										<td style='text-align:right;'>$ ".$row['intpredial']."</td>
										<td style='text-align:right;'>$ ".$row['descuenint']."</td>
										<td style='text-align:right;'>$ ".$row['bomberil']."</td>
										<td style='text-align:right;'>$ ".$row['intbomberil']."</td>
										<td style='text-align:right;'>$ ".$row['ambiente']."</td>
										<td style='text-align:right;'>$ ".$row['intambiente']."</td>
										<td style='text-align:right;'>$ ".$row['descuento']."</td>
										<td style='text-align:right;'>$ ".$row['valtotal']."</td>
										<td><input type='checkbox' name='dselvigenciasr[]' value='".$row['vigencia']."' disabled $chek>Pago</td>
									</tr>";
								$aux=$iter;
								$iter=$iter2;
								$iter2=$aux;

                            }	
						?>
                </table>
            </div>
			<?php }
				if($_POST[oculto]=='2')
				{
 					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
					$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
					$vigAcuerdo = $fecha[3];
					$bloq=bloqueos($_SESSION[cedulausu],$fechaf);	
					if($bloq>=1)
					{
						if($_POST[tipomovimiento]=='201')
						{
							$sql="INSERT INTO comprobante_cab(numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) VALUES ('$_POST[idcomp]','34','$fechaf','$_POST[concepto]','0','".round($_POST[valor])."','".round($_POST[valor])."','0','1')";
							view($sql);
							//COMPROBANTE DEBITO
							$sql="INSERT INTO comprobante_det(id_comp,cuenta,tercero,centrocosto,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) VALUES ('34 $_POST[idcomp]','".$_POST[banco]."','".$_POST[tercero]."','01','$_POST[concepto]','".$_POST[valor]."',0,1,'$vigAcuerdo','34','$_POST[idcomp]')";
							view($sql);
							
							$sq = "select cuentapuente from tesoparametros";
							$row = view($sq);
							//COMPROBANTE CREDITO
							$sql="INSERT INTO comprobante_det(id_comp,cuenta,tercero,centrocosto,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) VALUES ('34 $_POST[idcomp]','".$row[0][cuentapuente]."','".$_POST[tercero]."','01','$_POST[concepto]',0,'".$_POST[valor]."',1,'$vigAcuerdo','34','$_POST[idcomp]')";
							view($sql);


							for ($y=0;$y<count($_POST[dselvigencias]);$y++)
							{
								for($x=0;$x<count($_POST[dvigencias]);$x++)
								{
									if($_POST[dvigencias][$x]==$_POST[dselvigencias][$y])
									{
										$_POST[totliquida]=$_POST[totliquida]+$_POST[dvaltotal][$x];
										$_POST[totpredial]=$_POST[totpredial]+$_POST[dpredial][$x];
										$_POST[totbomb]=$_POST[totbomb]+$_POST[dbomberil][$x];
										$_POST[totamb]=$_POST[totamb]+$_POST[dambiente][$x];
										$_POST[intpredial]=$_POST[intpredial]+$_POST[dintpredial][$x];
										$_POST[intbomb]=$_POST[intbomb]+$_POST[dintbomberil][$x];
										$_POST[intamb]=$_POST[intamb]+$_POST[dintambiente][$x];
										$ageliqui=$ageliqui." ".$_POST[dselvigencias][$y];
									}
								}		 
							}
							$_POST[totint]=$_POST[intpredial]+$_POST[intbomb]+$_POST[intamb];
							$_POST[numpredial]=0;
							if($_POST[totliquida]>'0')
							{
								$_POST[numpredial]=selconsecutivo('tesoliquidapredial','idpredial');
								$sqlr="insert into tesoliquidapredial (idpredial,codigocatastral,fecha,vigencia,tercero,tasamora,descuento,tasapredial,totaliquida,totalpredial,totalbomb,totalmedio,totalinteres, intpredial, intbomb,intmedio,totaldescuentos,concepto,estado,ord,tot) values ('$_POST[numpredial]','$_POST[codcatastral]','$fechaf','$vigusu', '$_POST[tercero]','','','$_POST[tasa]','$_POST[totliquida]','$_POST[totpredial]', '$_POST[totbomb]','$_POST[totamb]','$_POST[totint]','$_POST[intpredial]','$_POST[intbomb]','$_POST[intamb]','$_POST[totdesc]','".utf8_decode("A�os Liquidados:".$ageliqui)."','S','001','001')";
								mysql_query($sqlr,$linkbd);
							}
							//*********************CREACION DEL COMPROBANTE ABONO ***************************
							if($_POST[modorec]=='caja')
							{				 
								$cuentacb=$_POST[cuentacaja];
								$cajas=$_POST[cuentacaja];
								$cbancos="";
							}
							if($_POST[modorec]=='banco')
							{
								$cuentacb=$_POST[banco];				
								$cajas="";
								$cbancos=$_POST[banco];
							}	  
							$sqlr="INSERT INTO tesoabono(id_abono,idacuerdo,fecha,tercero,valortotal,concepto,estado,tipomovimiento,cierre,recaudado,cuentacaja,cuentabanco) VALUES ('$_POST[idcomp]','$_POST[codacuerdo]','$fechaf','$_POST[tercero]','$_POST[valor]','$_POST[concepto]','S','201','$_POST[numpredial]','$_POST[modorec]','$cajas','$cbancos')";
							if(!mysql_query($sqlr,$linkbd))
							{echo "<script>despliegamodalm('visible','2','No Se ha podido Liquidar el Predial');</script>";}
							else
							{
								$idp=$_POST[numpredial]; 
								echo "<input name='idpredial' value='$idp' type='hidden' >";
								$idcomp=mysql_insert_id();
								$generaLiquidacion=0;
								for ($y=0;$y<count($_POST[dselvigencias]);$y++)
								{
									for($x=0;$x<count($_POST[dvigencias]);$x++)
									{
										if($_POST[dvigencias][$x]==$_POST[dselvigencias][$y])
										{
											$sqlr="INSERT INTO tesoabono_det(id_abono,vigencia,codcatastral,valor,estado,tipomovimiento) VALUES('$_POST[idcomp]','".$_POST[dvigencias][$x]."','$_POST[codcatastral]','".$_POST[dvaltotal][$x]."','S','201')";
											mysql_query($sqlr,$linkbd);
											$sqlr="UPDATE tesoacuerdopredial_det SET estado='P' WHERE idacuerdo='$_POST[codacuerdo]' AND vigencia='".$_POST[dvigencias][$x]."'";
											mysql_query($sqlr,$linkbd);

											$sqlr="insert into tesoliquidapredial_det (idpredial,vigliquidada,avaluo,tasav,predial,intpredial,bomberil, intbomb,medioambiente,intmedioambiente,descuentos,totaliquidavig,estado) values ('$idp','".$_POST[dvigencias][$x]."','".$_POST[davaluos][$x]."','".$_POST[dtasa][$x]."','".$_POST[dpredial][$x]."','".$_POST[dintpredial][$x]."','".$_POST[dbomberil][$x]."','".$_POST[dintbomberil][$x]."','".$_POST[dambiente][$x]."','".$_POST[dintambiente][$x]."','".$_POST[ddescuentos][$x]."','".$_POST[dvaltotal][$x]."','S')";
											mysql_query($sqlr,$linkbd);
											$generaLiquidacion = 1;
										}
									}		 
								}
								if($generaLiquidacion==1)
									echo "<script>despliegamodalm('visible','1','Se ha almacenado el abono con Exito, Liquidacion que genero es $idp');</script>";
								else
									echo "<script>despliegamodalm('visible','1','Se ha almacenado el abono con Exito');</script>";
							} 
						}
						elseif($_POST[tipomovimiento]=='401')
						{
							$sqlr="UPDATE tesoabono SET estado='R' WHERE id_abono='$_POST[idabono]' AND tipomovimiento='201'";
							mysql_query($sqlr,$linkbd);
							$sqlr="INSERT INTO tesoabono(id_abono,idacuerdo,fecha,tercero,valortotal,concepto,estado,tipomovimiento) VALUES ('$_POST[idabono]','$_POST[codigoacuerdo]','$fechaf','','$_POST[valortot]','$_POST[descripcion]','R','401')";
							if(!mysql_query($sqlr,$linkbd))
							{echo "<script>despliegamodalm('visible','2','No Se ha podido Liquidar el Predial');</script>";}
							else
							{
								$idcomp=mysql_insert_id();
								for($x=0;$x<count($_POST[dvigenciasr]);$x++)
								{
									$sqlr="INSERT INTO tesoabono_det(id_abono,vigencia,codcatastral,valor,estado,tipomovimiento) VALUES('$_POST[idabono]','".$_POST[dvigenciasr][$x]."','','".$_POST[dvaltotal][$x]."','R','201')";
									mysql_query($sqlr,$linkbd);
									$sqlr="UPDATE tesoabono_det SET estado='R' WHERE id_abono='$_POST[idabono]' AND vigencia='".$_POST[dvigenciasr][$x]."'";
									mysql_query($sqlr,$linkbd);
									$sqlr="UPDATE tesoacuerdopredial_det SET estado='S' WHERE idacuerdo='$_POST[codigoacuerdo]' AND vigencia='".$_POST[dvigenciasr][$x]."'";
									mysql_query($sqlr,$linkbd);
								}	
								echo "<script>despliegamodalm('visible','1','Se ha almacenado el abono con Exito');</script>";
							}
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