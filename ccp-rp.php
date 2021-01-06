<?php //V 1001 20/12/16 Modificado implementacion de Reversion?> 
<?php //V 1000 12/12/16 ?> 

<!--V 1.0 24/02/2015-->
<?php
	require"comun.inc";
	require"funciones.inc";
	require "conversor.php";
	require"validaciones.inc";
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
		<title>:: SPID - Presupuesto</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="JQuery/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="css/programas.js"></script>
        <script type="text/javascript" src="css/calendario.js"></script>
		<script>

			function guardar()
			{
				var fechabloqueo=document.form2.fechabloq.value;
				var fechadocumento=document.form2.fecha.value;
				var nuevaFecha=fechadocumento.split("/");
				var fechaCompara=nuevaFecha[2]+"-"+nuevaFecha[1]+"-"+nuevaFecha[0];
				if((Date.parse(fechabloqueo)) > (Date.parse(fechaCompara))){
					despliegamodalm('visible','2','Fecha de documento menor que fecha de bloqueo');
				}else{
					var vigencia="<?php echo vigencia_usuarios($_SESSION[cedulausu]) ?>";
					if(vigencia==nuevaFecha[2]){
						if(document.form2.tipomovimiento.value=='201'){
					if(document.form2.saldocdp.value>0){
						if (document.form2.vigencia.value!='' && document.form2.fecha.value!='' && document.form2.tercero.value!='')
					{
						despliegamodalm('visible','4','Esta Seguro de Guardar','1');
					}
					else
					{
						despliegamodalm('visible','2','Faltan datos para completar el registro');
						document.form2.fecha.focus();
						document.form2.fecha.select();
					}
					}else{
						despliegamodalm('visible','2','Falta saldo en el CDP');
					}
					
				}else if(document.form2.tipomovimiento.value=='401' || document.form2.tipomovimiento.value=='402'){
					
					if (document.form2.vigencia.value!='' && document.form2.fecha.value!='' && document.form2.objetorp.value!='')
					{
						despliegamodalm('visible','4','Esta Seguro de REVERSAR','1');
					}
					else
					{
						despliegamodalm('visible','2','Faltan datos para completar el registro');
						document.form2.fecha.focus();
						document.form2.fecha.select();
					}
				}
					}else{
						despliegamodalm('visible','2','La fecha del documento debe coincidir con su vigencia');
					}
					
					
				}
			
				
			}
			function validar(formulario)
			{
				var fec = document.form2.fecha.value;
				if(fec!='')
				{
					document.form2.oculto.value=1;	
					document.form2.action="ccp-rp.php";
					document.form2.submit();
				}
				else
				{
					document.form2.numerocdp.value=-1;	
					despliegamodalm('visible','2','Debe escoger la fecha del registro');
				}
			}
			function pdf()
			{
				document.form2.action="pdfrprecom.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function buscater(e)
		 	{
				if (document.form2.tercero.value!="")
				{
					document.form2.bt.value='1';
					document.form2.oculto.value='0'; 
					document.form2.submit();
				}
		 	}
			function resumar() 
			{ 
 				cali=document.getElementsByName('dcuentas[]');
 				valrubro=document.getElementsByName('dgastos[]');
 				valrubro2=document.getElementsByName('dcdpgastos[]');
 				sumar=0;
 				errores=0;
				// document.form2.todos.checked=chkbox.checked;
				for (var i=0;i < cali.length;i++) 
				{ 
					//alert('si'+i+' '+cali.item(i).value);
					//cali.item(i).checked = true;
					if(parseFloat(valrubro.item(i).value)<=parseFloat(valrubro2.item(i).value))
					{sumar=parseFloat(sumar)+parseFloat(valrubro.item(i).value);}
					else
					{
						despliegamodalm('visible','2','Supera el Valor del Rubro');
						valrubro.item(i).value=valrubro2.item(i).value;
						sumar=parseFloat(sumar)+parseFloat(valrubro.item(i).value);
						errores=errores+1;
					}
					//alert("cabio"+habdesv.item(i).value);
					//alert("cabio"+habdesv.item(i).value);
				} 
				document.form2.cuentagas2.value=sumar;
				document.form2.valorrp.value=sumar;
				document.form2.cuentagas.value=sumar;
				document.form2.oculto.value=0;
				if (errores==0){document.form2.submit();}
			} 
			function despliegamodal2(_valor,v)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){
					document.getElementById('ventana2').src="";
					document.form2.submit();
				}
				else {
					if(v==1){
						document.getElementById('ventana2').src="registro-ventana02.php?vigencia="+document.form2.vigencia.value;
					}else if(v==2){
						document.getElementById('ventana2').src="tercerosgral-ventana01.php?objeto=tercero&nobjeto=ntercero&nfoco=solicita";
					}else if(v==3){
						document.getElementById('ventana2').src="registro-ventana03.php?vigencia="+document.form2.vigencia.value;
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
				var vigencar=document.getElementById('vigencia').value;
				if(document.form2.tipomovimiento.value=='201'){
					var numdocar=document.getElementById('numero').value;
					document.location.href = "ccp-rpver.php?is="+numdocar+"&vig="+vigencar;
				}else{
					var numdocar=document.getElementById('rp').value;
					document.location.href = "ccp-rpver.php?is="+numdocar+"&vig="+vigencar;
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
				}
			}
		</script>
		<?php titlepag();?>
	</head>
	<body >
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("ccpet");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("ccpet");?></tr>
			<tr>
  				<td colspan="3" class="cinta">
					<a onClick="location.href='ccp-rp.php'" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
					<a onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar"/></a>
					<a onClick="location.href='ccp-buscarp.php'" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a onClick="<?php echo paginasnuevas("ccpet");?>" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
					<a href="#" <?php if($_POST[oculto]==2) { ?> onClick="pdf()" <?php } ?> class="mgbt"><img src="imagenes/print.png" title="Imprimir" style="width:29px; height:25px;"></a>
				</td>
			</tr>
     	</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
		<?php
			
 				
			if($_POST[oculto]==''){
				$_POST[tipomovimiento]='201';
			}
			
			/*$valorcontra=busca_cdpcontrato($_POST[numerocdp],$vigusu,'CDP');
			$_POST[ncontrato]=$valorcontra[0];
			$_POST[tercero]=$valorcontra[1];
			$_POST[ntercero]=buscatercero($valorcontra[1]);*/
 			//***** busca tercero
			if($_POST[bt]=='1')
			{
				$nresul=buscatercero($_POST[tercero]);
			  	if($nresul!=''){$_POST[ntercero]=$nresul;}
			 	else{$_POST[ntercero]="";}
			}
			//**** busca cuenta
			if($_POST[bc]!='')
			{
				$nresul=buscacuentapres($_POST[cuenta],2);			
			  	if($nresul!='')
			   	{
			  		$_POST[ncuenta]=$nresul;
			  		$_POST[fuente]=buscafuenteppto($rubro,$vigencia);
			  		$_POST[cfuente]=substr($_POST[fuente],0,count(strpos($_POST[fuente],'_'))-1);
			   	}
			  	else {$_POST[ncuenta]="";}
			}
			if ($_POST[chacuerdo]=='2')
			{
				$_POST[dcuentas]=array();
				$_POST[dncuetas]=array();
				$_POST[dingresos]=array();
				$_POST[dcdpgastos]=array();
				$_POST[dgastos]=array();
				$_POST[diferencia]=0;
				$_POST[cuentagas]=0;
				$_POST[cuentaing]=0;																			
			}	 
			// echo $_POST[tipomovimiento];
		?>
		<form name="form2" method="post" action="#">
		<?php
 			$sesion=$_SESSION[cedulausu];
 			$sqlr="Select dominios.valor_final from usuarios,dominios where usuarios.cc_usu=$sesion and dominios.NOMBRE_DOMINIO='PERMISO_MODIFICA_DOC' and dominios.valor_inicial=usuarios.cc_usu ";
				$resp = mysql_query($sqlr,$linkbd);
				$fechaBloqueo=mysql_fetch_row($resp);
				echo "<input type='hidden' name='fechabloq' id='fechabloq' value='$fechaBloqueo[0]' />";
 		?>
			<table class="inicio">
				<tr>
					<td class="titulos" colspan="8">.: Tipo de Registro Presupuestal </td>
				</tr>
				<tr>
					<td>
						<select name="tipomovimiento" id="tipomovimiento" onKeyUp="return tabular(event,this)" onChange="validar()" >
							<?php 
								$user=$_SESSION[cedulausu];
								$sql="SELECT * from permisos_movimientos WHERE usuario='$user' AND estado='T' ";
								$res=mysql_query($sql,$linkbd);
								$num=mysql_num_rows($res);
								if($num==1){
									$sqlr="select * from tipo_movdocumentos where estado='S' and modulo=3 AND (id='2' OR id='4')";
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
									$sql="SELECT codmov,tipomov from permisos_movimientos WHERE usuario='$user' AND estado='S' AND modulo='3' AND transaccion='PGB' ";
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
				</tr>
			</table>
			<?php
				if($_POST[fecha]=='')
				{
					$_POST[fecha] = date("d/m/Y");
				}
				ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha1);
				$fechaf1=$fecha1[3]."-".$fecha1[2]."-".$fecha1[1];
				$_POST[vigencia]=$fecha1[3];
				$vigencia=$fecha1[3];
				 $vigusu=$fecha1[3];
				 if(isset($_POST[numerocdp])){
					 if(!empty($_POST[numerocdp])){
						// $_POST[saldocdp]=generaSaldoCDP1($_POST[numerocdp],$vigusu,$fechaf1);
	
					 }
				 }
				 if($_POST[oculto]!="")
				{		
					
					$fec=date("d/m/Y");
					//$_POST[fecha]=$fec; 	
					$_POST[valor]=0; 	
					// $_POST[valorrp]=0; 			 
					$_POST[cuentaing]=0;
					$_POST[cuentagas]=0;
					$_POST[cuentaing2]=0;
					$_POST[cuentagas2]=0;
					$sqlr="select max(consvigencia) from ccpet_rp where vigencia=$_POST[vigencia] ";
					$res=mysql_query($sqlr,$linkbd);
					while($r=mysql_fetch_row($res)){
						$maximo=$r[0];
						}
					if(!$maximo){
						$_POST[numero]=1;
					}
					else{
						if($_POST[numero]=='')
							$_POST[numero]=$maximo+1;
					}
				}
			?>
    		<table class="inicio" align="center" width="80%" >
                <tr>
                    <td class="titulos" colspan="7">.: Registro Presupuestal </td>
                    <td class="cerrar" style="width:7%;"><a onClick="location.href='presu-principal.php'">Cerrar</a></td>
                </tr>
                <tr>
                    <td class="saludo1" style="width:2.5cm;">Fecha:</td>
                    <td style="width:15%;">
                        <input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" style="width:80%;"/>&nbsp;<a onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/calendario04.png" style="width:20px; cursor:pointer;" title="Calendario"/></a>
                        <input type="hidden" name="chacuerdo" value="1">
                    </td>
					<td class="saludo1" style="width:2.5cm;">Numero:</td>
					<?php
					if($_POST[tipomovimiento]=='201')
					{
					?>
						<td style="width:15%;"><input type="text" name="numero" id="numero" value="<?php echo $_POST[numero] ?>" style="width:80%;"/></td>
					<?php
					}else if($_POST[tipomovimiento]=='401')
					{
					?>
						<td style="width:15%;">
							<input type="text" name="rp" id="rp" value="<?php echo $_POST[rp] ?>" style="width:80%;" readonly/>
							<a href="#" onClick="despliegamodal2('visible',1);" title="Buscar Registro"><img src="imagenes/find02.png" style="width:20px;"></a>  
						</td>
						<input type="hidden" name="tercero" id="tercero" value="<?php echo $_POST[tercero]?>">
						<input type="hidden" name="cdp" id="cdp" value="<?php echo $_POST[cdp] ?>">
					<?php
					}else if($_POST[tipomovimiento]=='402')
					{
					?>
						<td style="width:15%;">
							<input type="text" name="rp" id="rp" value="<?php echo $_POST[rp] ?>" style="width:80%;" readonly/>
							<a href="#" onClick="despliegamodal2('visible',3);" title="Buscar Registro"><img src="imagenes/find02.png" style="width:20px;"></a>  
						</td>
						<input type="hidden" name="tercero" id="tercero" value="<?php echo $_POST[tercero]?>">
						<input type="hidden" name="cdp" id="cdp" value="<?php echo $_POST[cdp] ?>">
					<?php
					}
					?>
                    <td class="saludo1" style="width:2.5cm;">Vigencia:</td>
                    <td style="width:15%;"><input  type="text" name="vigencia" id="vigencia" value="<?php echo $_POST[vigencia] ?>" style="width:80%;" readonly/> </td>
                    <td rowspan="7" colspan="2" style="background:url(imagenes/siglas.png); background-repeat:no-repeat; background-position:right; background-size: 100% 100%;" ></td>
                </tr>
               	
				<?php
				if($_POST[tipomovimiento]=='201')
				{
				?>
					<tr>
						<td class="saludo1">Contrato:</td>
						<td ><input id="ncontrato" type="text" name="ncontrato" onKeyUp="return tabular(event,this)"  onKeyPress="javascript:return solonumeros(event)"  value="<?php echo $_POST[ncontrato]?>" style="width:80%;" /></td>
						<td class="saludo1">Nomina:</td>
						<td >
							<?php 
								if ($_POST[nomina]=='1'){$chk2='checked';}
								else {$chk2='';}
							?>
							<input type="checkbox" name="nomina" id="nomina" value="1" <?php echo $chk2 ?> onChange="document.form2.submit();"/>
								  
						</td>
						<td class="saludo1" style="width:10%">Destino de compra:</td>
            <td width="21%"> 
							<select name="destcompra" id="destcompra" style="width: 95%">
								<?php
									$sql="SELECT * FROM almdestinocompra WHERE estado='S' ORDER BY codigo";
									$result=mysql_query($sql,$linkbd);
									while($row = mysql_fetch_row($result)){
										if($_POST[destcompra]==$row[0]){
											echo "<option value='$row[0]' SELECTED>$row[1]</option>";
										}else{
											echo "<option value='$row[0]'>$row[1]</option>";
										}
										
									}
								?>
							</select>
						</td> 
					</tr>
					<tr>
						<td class="saludo1">Numero CDP:</td>
						<td>
							<select name="numerocdp" id="numerocdp" onChange="validar()" onKeyUp="return tabular(event,this)" style="width:80%;">
								<option value="-1">Seleccione....</option>
								<?php
									//$sqlr="Select * from pptocdp  where estado='S' and vigencia=$vigusu order by consvigencia";
									if($_POST[nomina]=='1')
									{
										$sqlr="SELECT TB1.* FROM ccpet_cdp TB1, hum_nom_cdp_rp TB2 WHERE TB1.consvigencia=TB2.cdp AND TB2.rp='0' AND TB1.estado='S' AND TB1.vigencia='$vigusu' AND TB2.vigencia='$vigusu' AND TB1.tipo_mov='201' ORDER BY TB1.consvigencia";
									}
									else
									{
										$sqlr = "select tb1.id_cdp, tb1.vigencia, tb1.consvigencia,tb1.fecha,tb1.valor,tb1.estado,tb1.solicita,tb1.objeto,tb1.saldo,tb1.tipo_mov,tb1.user 
										from  ccpet_cdp tb1 
										where  tb1.tipo_mov='201'
										and tb1.vigencia='$vigusu' 
										union all 
										select distinct(p.id_cdp) id_cdp, p.vigencia, p.consvigencia,p.fecha,p.valor,p.estado,p.solicita,p.objeto,p.saldo,p.tipo_mov,p.user
										from ccpet_cdp p , ccpetcdp_detalle pd , pptocuentas p2 
										where  p.vigencia = pd.vigencia 
										and   p.consvigencia = pd.consvigencia 
										and   pd.vigencia  = p2.vigencia 
										and   pd.cuenta  = p2.cuenta 
										and   p2.regalias ='S'
										and   p.tipo_mov ='201'
										and   not exists (select null from ccpet_cdp p3 where p3.vigencia = p.vigencia and p3.consvigencia = p.consvigencia and p3.tipo_mov ='401')
										and   p2.vigenciarg like '%$vigusu%'";
										//$sqlr="SELECT TB1.* FROM pptocdp TB1 WHERE TB1.vigencia='$vigusu' AND TB1.tipo_mov='201' ORDER BY TB1.consvigencia";
									}
										
										$resp = mysql_query($sqlr,$linkbd);
										$valorCDP = 0;
										while ($row =mysql_fetch_row($resp)) 
										{
											$valorCDP = generaSaldoCDP1($row[2],$row[1],$fechaf1);
											if($valorCDP>0){
												if($row[2]==$_POST[numerocdp])
												{
													if ($_POST[oculto]==1)
													{	
														$_POST[solicita]=$row[6];
														$_POST[fechacdp]=$row[3];				 
														ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fechacdp],$fecha);
														$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];	 
														$_POST[fechacdp]=$fechaf;		
														$_POST[vigenciaCDP]=$fecha[1];		 				
														$_POST[objetorp]=$row[7];
														$_POST[valorrp]=$valorCDP;
														$_POST[scdp]=$valorCDP;
														$_POST[saldocdp]=$valorCDP;
													}
													echo "<option value='$row[2]' SELECTED>$row[2]</option>";
												}
												else{echo "<option value='$row[2]'>$row[2]</option>";}
											}
										
										}			
									?> 
							</select>
							<input type="hidden" name="scdp" id="scdp" value="<?php echo $_POST[scdp]; ?>" >
						</td>
						<td class="saludo1">Fecha CDP:</td>
						<td><input name="fechacdp" type="text" id="fc_1198971546" title="DD/MM/YYYY"  value="<?php echo $_POST[fechacdp]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" style="width:80%;" readonly></td>
						<td class="saludo1">Saldo CDP:</td>
						<td><input name="saldocdp" type="text" id="saldocdp"  value="<?php echo $_POST[saldocdp]; ?>"  maxlength="10" style="width:80%;" readonly></td>

					</tr>
					<tr> 
						<td class="saludo1">Tercero:</td>
						<td>
							<input type="text" name="tercero" id="tercero" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo $_POST[tercero]?>" onClick="document.getElementById('tercero').focus();document.getElementById('tercero').select();" style="width:80%">&nbsp;<a onClick="despliegamodal2('visible',2);" title="Listado Terceros"><img src="imagenes/find02.png" style="width:20px;cursor:pointer;"/></a> 
							<input type="hidden" value="0" name="bt">
						</td>
						<td colspan="4">
							<input type="text" name="ntercero" id="ntercero" value="<?php echo $_POST[ntercero]?>" style="width:100%" readonly >
							<input type="hidden" name="vigenciaCDP" id="vigenciaCDP" value="<?php echo $_POST[vigenciaCDP]?>" style="width:100%" readonly >
						</td>
					</tr>
					<tr>
						<td class="saludo1">Solicita:</td>
						<td colspan="5"><input type="text" name="solicita" id="solicita" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[solicita]?>" style="width:100%"/></td>
					</tr>
				<?php
				}
				?>
            	<tr>
                    <td class="saludo1">Objeto:</td>
                    <td colspan="5"><input name="objetorp" type="text" id="objetorp" onKeyUp="return tabular(event,this)" value="<?php echo htmlspecialchars($_POST[objetorp])?>" style="width:100%"/> </td>
                </tr>
                <tr>
                    <td class="saludo1">Valor RP:</td>
                    <td ><input name="valorrp" type="text"  onKeyPress="javascript:return solonumeros(event)" value="<?php echo $_POST[valorrp]?>" style="width:80%" readonly/></td>
                    <td colspan="4"></td>
                </tr>
			</table>
            <input type="hidden" name="oculto" id="oculto" value="<?php echo $_POST[oculto]?>"/>
			<?php
		 		//***** busca tercero
				if($_POST[bt]=='1')
			 	{
			  		$nresul=buscatercero($_POST[tercero]);
			  		if($nresul!='')
			   		{
						
			  			$_POST[ntercero]=$nresul;
  						echo"
						<script>
			  				document.getElementById('solicita').focus();
							document.getElementById('solicita').select();
						</script>";
			 		}
			 		else
			 		{
			  			$_POST[ntercero]="";
			  			echo"
			  			<script>
							despliegamodalm('visible','2','Tercero Incorrecto');
							document.form2.tercero.value='';
							document.form2.tercero.select();
		  					document.form2.tercero.focus();	
			  			</script>";
			  		}
					
				}
			?>
			<?php 
				if($_POST[tipomovimiento]=='201')
				{
			?>
				<div class="subpantalla" style="height:47.5%; width:99.6%; overflow-x:hidden;">   
					<table class="inicio" width="99%">
						<tr><td class="titulos" colspan="7">Detalle RP</td></tr>
						<tr>
							<td class="titulos2" style='width:12%'>Cuenta</td>
							<td class="titulos2">Nombre Cuenta</td>
							<td class="titulos2">Fuente</td>
							<td class="titulos2" style='width:10%'>Valor</td>
						</tr>
						<?php
							if ($_POST[oculto]==1)
							{
								$_POST[dcuentas]=array();
								$_POST[dncuentas]=array();
								$_POST[dgastos]=array();
								$_POST[dfuentes]=array();	
								$_POST[dcfuentes]=array();	
								$saldoscdpdet=array();
								$valorcdpor=array();
								$sqlr="Select * from ccpetcdp_detalle  where vigencia=$_POST[vigenciaCDP] and consvigencia=$_POST[numerocdp] AND tipo_mov='201' order by consvigencia";
								$resp = mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($resp)) 
								{
									 $_POST[dcuentas][]=$row[3];
									$nresul=buscacuentapres($row[3],2);			
									$_POST[dncuentas][]=$nresul;
									$_POST[dgastos][]=round(generaSaldoCDP1($row[2],$_POST[vigenciaCDP],$fechaf1,$row[3]),2);
									$_POST[dcdpgastos][]=round(generaSaldoCDP1($row[2],$_POST[vigenciaCDP],$fechaf1,$row[3]),2);				 
									$nfuente=buscafuenteppto($row[3],$_POST[vigencia]);
									$cdfuente=substr($nfuente,0,strpos($nfuente,"_"));
									$_POST[dcfuentes][]=$cdfuente;
									$_POST[dfuentes][]=$nfuente;
								}
							}
							$co="zebra1";
							$co2="zebra2";		
							$_POST[cuentagas]=0;
							$_POST[cuentagas2]=0;
							$_POST[letras]='';
							for ($x=0;$x< count($_POST[dcuentas]);$x++)
							{
								echo "
								<input type='hidden' name='dcuentas[]' value='".$_POST[dcuentas][$x]."'/>
								<input type='hidden' name='dncuentas[]' value='".$_POST[dncuentas][$x]."'/'>
								<input type='hidden' name='dcfuentes[]' value='".$_POST[dcfuentes][$x]."'/>
								<input type='hidden' name='dfuentes[]' value='".$_POST[dfuentes][$x]."'/>
								<input type='hidden' name='dcdpgastos[]' value='".$_POST[dcdpgastos][$x]."'/>
								<tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\" >
									<td>".$_POST[dcuentas][$x]."</td>
									<td>".$_POST[dncuentas][$x]."</td>
									<td>".$_POST[dfuentes][$x]."</td>
									<td><input type='text' name='dgastos[]' value='".$_POST[dgastos][$x]."' style='text-align:right; width:100%' class='inpnovisibles' onBlur='resumar()' onKeyPress='javascript:return solonumeros(event)' onKeyUp='return tabular(event,this)'/></td>
								</tr>";
								//$cred= $vc[$x]*1;
								$gas=$_POST[dgastos][$x];
								//$cred=number_format($cred,2,".","");
								//$deb=number_format($deb,2,".","");
								$gas=$gas;
								$cuentagas=$cuentagas+$gas;
								$_POST[cuentagas2]=$cuentagas;
								$total=number_format($total,2,",","");
								$_POST[cuentagas]=number_format($cuentagas,2,".",",");
								$resultado = convertir($_POST[cuentagas2]);
								$_POST[letras]=$resultado." PESOS";
								$aux=$co;
								$co=$co2;
								$co2=$aux;
							}
							echo "
							<input type='hidden' id='cuentagas' name='cuentagas' value='$_POST[cuentagas]'/>
							<input type='hidden' id='cuentagas2' name='cuentagas2' value='$_POST[cuentagas2]'/>
							<input type='hidden' id='letras' name='letras' value='$_POST[letras]'/>
							<tr class=$co style='text-align:right;'>
								<td colspan='3'>Total:</td>
								<td>$ $_POST[cuentagas]</td>
							</tr>
							<tr class='titulos2'>
								<td>Son:</td>
								<td colspan= '5'>$_POST[letras]</td>	
							</tr>
							<script>
								//alert('Tercero Incorrecta');document.form2.tercero.select();
								document.form2.valorrp.value=document.form2.cuentagas.value;	
							</script>";
						?>
					</table>
					</div>
			<?php
			}else if($_POST[tipomovimiento]=='401' or $_POST[tipomovimiento]=='402')
			{
			?>
			<div class="subpantalla" style="height:30%; width:99.6%; overflow-x:hidden;">
				<table class="inicio" width="99%">
					<tr>
						<td class="titulos" colspan="5">Detalle RP</td>
					</tr>
					<tr>
						<td class="titulos2" style='width:10%'>Cuenta</td>
						<td class="titulos2">Nombre Cuenta</td>
						<td class="titulos2">Fuente</td>
						<td class="titulos2" style='width:10%'>Valor</td>
					</tr>
					 <?php
						$_POST[dcuentas]=array();
						$_POST[dncuentas]=array();
						$_POST[dgastos]=array();
						$_POST[dfuentes]=array();	
						$_POST[dcfuentes]=array();			 			 			 			 			 		   
						$sqlr="Select * from ccpetrp_detalle  where vigencia='$vigusu' and consvigencia=$_POST[rp] AND tipo_mov='201' order by CUENTA";
						//echo $sqlr;
						$resp = mysql_query($sqlr,$linkbd);
						while ($row =mysql_fetch_row($resp)) 
						{
							$_POST[dcuentas][]=$row[3];
							$nresul=buscacuentapres($row[3],2);			
							$_POST[dncuentas][]=$nresul;				 
							$_POST[dgastos][]=generaSaldoRPxcuenta($_POST[rp],$row[3],$vigusu);
							$nfuente=buscafuenteppto($row[3],$vigusu);
							$cdfuente=substr($nfuente,0,strpos($nfuente,"_"));
							// echo "cc ".$cdfuente;
							$_POST[dcfuentes][]=$cdfuente;
							$_POST[dfuentes][]=$nfuente;
						}
						$co="zebra1";
						$co2="zebra2";						
						for ($x=0;$x< count($_POST[dcuentas]);$x++)
						{
							echo "<tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\" ><td><input name='dcuentas[]' value='".$_POST[dcuentas][$x]."' type='text' style='width:100%' readonly class='inpnovisibles'></td><td ><input name='dncuentas[]' value='".$_POST[dncuentas][$x]."' type='text' style='width:100%' readonly class='inpnovisibles'></td><td><input name='dcfuentes[]' value='".$_POST[dcfuentes][$x]."' type='hidden'><input name='dfuentes[]' value='".$_POST[dfuentes][$x]."' type='text' style='width:100%' readonly class='inpnovisibles'></td><td><input name='dgastos[]' value='".$_POST[dgastos][$x]."' type='text' style='text-align:right; width:100%' onDblClick='llamarventana(this,$x)' readonly class='inpnovisibles'></td></tr>";
			//		 		$cred= $vc[$x]*1;
							$gas=$_POST[dgastos][$x];
			//		 		$cred=number_format($cred,2,".","");
				//	 		$deb=number_format($deb,2,".","");

							$gas=$gas;
							$cuentagas=$cuentagas+$gas;
							$_POST[cuentagas2]=$cuentagas;
							$total=number_format($total,2,",","");
							$_POST[cuentagas]=number_format($cuentagas,2,".",",");
								$resultado = convertir($_POST[cuentagas2]);
							$_POST[letras]=$resultado." PESOS";
							$aux=$co;
							$co=$co2;
							$co2=$aux;
						}
						echo "<tr style='text-align:right;'>
								<td ></td>
								<td colspan='1'></td>
								<td>Total:</td>
								<td class='saludo1'>
									<input id='cuentagas' name='cuentagas' value='$_POST[cuentagas]' readonly class='inpnovisibles' style='text-align:right; width:100%'>
									<input id='cuentagas2' name='cuentagas2' value='$_POST[cuentagas2]' type='hidden'>
								</td>
							</tr>";
						echo "<tr class='titulos2'><td>Son:</td><td colspan= '4'><input id='letras' name='letras' value='$_POST[letras]' type='text' style='width:100%' class='inpnovisibles'></td></tr>";
					?>
				</table>
			</div>
			<?php 
			}
			?>
  				<?php
				// echo $_POST[tipomovimiento];
				if($_POST[tipomovimiento]=='201'){
  					//***************PARTE PARA INSERTAR Y ACTUALIZAR LA INFORMACION CDP y REGISTRO PRESUPUESTAL
					$oculto=$_POST['oculto'];
					if($_POST[oculto]=='2')
					{
						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
						$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
						$bloq=bloqueos($_SESSION[cedulausu],$fechaf);
						if($bloq>=1)
						{	
							$sqlr="select count(*) from ccpet_rp where vigencia='$_POST[vigencia]' and consvigencia=$_POST[numero] AND tipo_mov='201'";
							$res=mysql_query($sqlr,$linkbd);
							while($r=mysql_fetch_row($res))
							{
								$numerorecaudos=$r[0];
							}
	  						if($numerorecaudos==0)
	 						{
 								$nr="1";				
								$totalrp=0;
								$totalrp=array_sum($_POST[dgastos]);
								$_POST[valorrp]=0+$totalrp;
								$sqlr="insert into pptorp_almacen (id_rp,destino,vigencia) values ('$_POST[numero]','".$_POST[destcompra]."','$_POST[vigencia]')";
								mysql_query($sqlr,$linkbd);
								//************** modificacion del presupuesto **************
								$sqlr="insert into ccpet_rp (vigencia,consvigencia,fecha,idcdp,estado,tercero,valor,saldo,contrato,vigenciacdp,tipo_mov,detalle,user) values('$_POST[vigencia]','$_POST[numero]','$fechaf','$_POST[numerocdp]','S','$_POST[tercero]','$_POST[valorrp]','$_POST[valorrp]','$_POST[ncontrato]','$_POST[vigencia]','201','$_POST[objetorp]','".$_SESSION['nickusu']."')";
								if (!mysql_query($sqlr,$linkbd))
								{
									$e =mysql_error(mysql_query($sqlr,$linkbd));
									echo"<script>despliegamodalm('visible','2','No se pudo ejecutar la petici�n: $e');</script>";
								}
  								else
  		 						{
		  							$sqlr="insert into contrasolicitudcdpppto (proceso, ndoc, tipodoc, vigencia, estado) values ('$_POST[ncontrato]','$_POST[numero]','RP','$_POST[vigencia]','S')";
		 							 mysql_query($sqlr,$linkbd);  
		  							
									
									$sqlr="update ccpet_cdp set saldo=saldo-".$_POST[valorrp]." where vigencia=".$vigusu." and consvigencia=$_POST[numerocdp] AND tipo_mov='201'";
									mysql_query($sqlr,$linkbd);
									
									$sqlr="select sum(saldo) from ccpetcdp_detalle where consvigencia=$_POST[numerocdp] and vigencia=$_POST[vigencia] AND tipo_mov='201' ";	
									$res=mysql_query($sqlr,$linkbd);
									$row =mysql_fetch_row($res); 
									
									if($row[0]==$_POST[valorrp]){
										$sqlr="update ccpet_cdp set estado='C' where vigencia=".$vigusu." and consvigencia=$_POST[numerocdp] and tipo_mov='201'";
										mysql_query($sqlr,$linkbd); 
									}
									
									for($x=0;$x<count($_POST[dgastos]);$x++)
			 						{
			 							$sqlr="update ccpet_cuentasccpet_inicial set saldoscdprp=saldoscdprp-".$_POST[dgastos][$x]." where cuenta='".$_POST[dcuentas][$x]."' and (ccpet_cuentasccpet_inicial.vigencia='$_POST[vigencia]' or vigenciaf='$vigusu')";
			 							mysql_query($sqlr,$linkbd); 
										$sqlr="insert into ccpetrp_detalle (vigencia,consvigencia,cuenta,fuente,valor,estado,saldo,saldo_liberado,tipo_mov) values('$_POST[vigencia]','$_POST[numero]','".$_POST[dcuentas][$x]."','".$_POST[dcfuentes][$x]."',".$_POST[dgastos][$x].",'S',".$_POST[dgastos][$x].",0,'201')";
			 							mysql_query($sqlr,$linkbd); 
			 							$sqlr="update ccpetcdp_detalle set saldo=saldo-".$_POST[dgastos][$x]." where  cuenta='".$_POST[dcuentas][$x]."' and consvigencia=$_POST[numerocdp] and  vigencia=".$vigusu." and tipo_mov='201' ";
			  							mysql_query($sqlr,$linkbd);
			  									 
			 						}
			 						if($_POST[nomina]=='1')
			  						{
			 							$sqlr="Insert into humnom_rp (consvigencia,vigencia,estado) values ('$_POST[numero]','$vigusu','S')";
			 							mysql_query($sqlr,$linkbd); 
										$sqlrco ="UPDATE hum_nom_cdp_rp SET rp='$_POST[numero]' WHERE cdp='$_POST[numerocdp]' AND vigencia='$_POST[vigencia]'";
										mysql_query($sqlrco,$linkbd);
			  						}
								 	echo "<script>despliegamodalm('visible','1','Se ha almacenado el Registro Presupuestal con Exito ');</script>"; 
		  						}
								//********* creacion del cdp ****************
	  						}
	  						else{echo"<script>despliegamodalm('visible','2','Ya Existe un Registro Presupuestal con este Numero');</script>";}
						}
						else
						{
							echo"<script>despliegamodalm('visible','2','No Tiene los Permisos para Modificar este Documento');</script>";
						}
					}//*** if de control de guardado
				}else if($_POST[tipomovimiento]=='401' or $_POST[tipomovimiento]=='402')
				{
					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
					$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
					//***************PARTE PARA REVERSAR LA INFORMACION CDP y REGISTRO PRESUPUESTAL
					$oculto=$_POST['oculto'];
					if($_POST[oculto]=='2')
					{
						ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
						$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
						$bloq=bloqueos($_SESSION[cedulausu],$fechaf);
						if($bloq>=1)
						{	
							$nr="1";				
							$totalrp=0;
							$totalrp=array_sum($_POST[dgastos]);
							$_POST[valorrp]=0+$totalrp;
							//************** modificacion del presupuesto **************
									
									$gfecha=getdate();
									$d=$gfecha[mday];
									if($d<10){
										$d="0".$d;
									}
									$m=$gfecha[mon];
									if($m<10){
										$m="0".$m;
									}
									$a=$gfecha[year];
									$gfecha=$a."-".$m."-".$d;
									// echo $gfecha;
								if($_POST[tipomovimiento]=='401'){
									
									$sqlr="insert into ccpet_rp (vigencia,consvigencia,idcdp,estado,fecha,detalle,user,tipo_mov) values (".$vigusu.",'$_POST[rp]','$_POST[cdp]','R','$fechaf','$_POST[objetorp]','".$_SESSION['nickusu']."','401')";
									mysql_query($sqlr,$linkbd);
									$sql="UPDATE ccpet_rp SET estado='R' where consvigencia='$_POST[rp]' AND vigencia='$vigusu'  ";
									mysql_query($sql,$linkbd);
									
								}else if($_POST[tipomovimiento]=='402'){
									
									$sqlr="insert into ccpet_rp (vigencia,consvigencia,idcdp,fecha,detalle,user,tipo_mov) values (".$vigusu.",'$_POST[rp]','$_POST[cdp]','$fechaf','$_POST[objetorp]','".$_SESSION['nickusu']."','402')";
									mysql_query($sqlr,$linkbd);
									// echo $sqlr."<br><br>";
									
								}
							for($x=0;$x<count($_POST[dgastos]);$x++)
							{
								if($_POST[tipomovimiento]=='401'){
									$sqlr="update ccpet_rp set saldo=saldo-".$_POST[dgastos][$x].", estado='RT' where consvigencia=$_POST[rp] and  vigencia=".$vigusu." and tipo_mov='201' ";
									mysql_query($sqlr,$linkbd);
									// echo $sqlr."<br><br>";
									$sqlr="update ccpetrp_detalle set saldo=saldo-".$_POST[dgastos][$x].", estado='RT' where consvigencia=$_POST[rp] and  vigencia=".$vigusu." and cuenta='".$_POST[dcuentas][$x]."' and tipo_mov='201'";
									mysql_query($sqlr,$linkbd);

									$sqlr="insert into ccpetrp_detalle (vigencia,consvigencia,cuenta,fuente,valor,estado,saldo,saldo_liberado,tipo_mov) values('$_POST[vigencia]','$_POST[rp]','".$_POST[dcuentas][$x]."','".$_POST[dcfuentes][$x]."',".$_POST[dgastos][$x].",'S',".$_POST[dgastos][$x].",0,'401')";
									mysql_query($sqlr,$linkbd); 
									// echo $sqlr."<br><br>";
									 
									// // echo $sqlr."<br>";
									 
									
									// echo $sqlr."<br><br>";
									
								}else if($_POST[tipomovimiento]=='402'){
									$sqlr="update ccpet_rp set saldo=saldo-".$_POST[dgastos][$x].", estado='RP' where consvigencia=$_POST[rp] and  vigencia=".$vigusu." and tipo_mov='201' ";
									mysql_query($sqlr,$linkbd);
									// echo $sqlr."<br><br>";
									$sqlr="update ccpetrp_detalle set saldo=saldo-".$_POST[dgastos][$x].", estado='RP' where consvigencia=$_POST[rp] and  vigencia=".$vigusu." and cuenta='".$_POST[dcuentas][$x]."' and tipo_mov='201' ";
									mysql_query($sqlr,$linkbd);
									$sqlr="insert into ccpetrp_detalle (vigencia,consvigencia,cuenta,fuente,valor,estado,saldo,saldo_liberado,tipo_mov) values('$_POST[vigencia]','$_POST[rp]','".$_POST[dcuentas][$x]."','".$_POST[dcfuentes][$x]."',".$_POST[dgastos][$x].",'S',".$_POST[dgastos][$x].",0,'402')";
									mysql_query($sqlr,$linkbd); 
									
								}
								
								$sqlr="update ccpetcdp_detalle set saldo=saldo+".$_POST[dgastos][$x]." where  cuenta='".$_POST[dcuentas][$x]."' and consvigencia=$_POST[cdp] and  vigencia=".$vigusu." and tipo_mov='201' ";
								mysql_query($sqlr,$linkbd);
								// echo $sqlr."<br><br>";
								$sqlr="update ccpet_cdp set estado='S', saldo=saldo+".$_POST[dgastos][$x]." where consvigencia='$_POST[cdp]' and  vigencia='".$vigusu."' and tipo_mov='201'";
								mysql_query($sqlr,$linkbd);
								// echo $sqlr."<br><br>";
								//****modifica el comprobante ppto inicial ******		 
							}
							echo "<script>despliegamodalm('visible','1','Se ha reversado el Registro Presupuestal con Exito ');</script>"; 
		  				}
						else
						{
							echo"<script>despliegamodalm('visible','2','No Tiene los Permisos para Modificar este Documento');</script>";
						}
						// sleep(1);
						echo "<script>funcionmensaje();</script>";
					}//*** if de control de guardado
					
				}
				echo "<script>
						document.form2.oculto.value=1;
				</script>";
			?> 
			
            <div id="bgventanamodal2">
                <div id="ventanamodal2">
                    <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                    </IFRAME>
                </div>
       	 	</div>
    	</form>
	</body>
	<script>
 jQuery(function($){
  var user ="<?php echo $_SESSION[cedulausu]; ?>";
  var bloque='';
  $.post('peticionesjquery/seleccionavigencia.php',{usuario: user},selectresponse);
  

 $('#cambioVigencia').change(function(event) {
   var valor= $('#cambioVigencia').val();
   var user ="<?php echo $_SESSION[cedulausu]; ?>";
   var confirma=confirm('�Realmente desea cambiar la vigencia?');
   if(confirma){
    var anobloqueo=bloqueo.split("-");
    var ano=anobloqueo[0];
    if(valor < ano){
      if(confirm("Tenga en cuenta va a entrar a un periodo bloqueado. Desea continuar")){
        $.post('peticionesjquery/cambiovigencia.php',{valor: valor,usuario: user},updateresponse);
      }else{
        location.reload();
      }

    }else{
      $.post('peticionesjquery/cambiovigencia.php',{valor: valor,usuario: user},updateresponse);
    }
    
   }else{
   	location.reload();
   }
   
 });

 function updateresponse(data){
  json=eval(data);
  if(json[0].respuesta=='2'){
    alert("Vigencia modificada con exito");
  }else if(json[0].respuesta=='3'){
    alert("Error al modificar la vigencia");
  }
  location.reload();
 }
 function selectresponse(data){ 
  json=eval(data);
  $('#cambioVigencia').val(json[0].vigencia);
  bloqueo=json[0].bloqueo;
 }

 }); 
</script>
</html>