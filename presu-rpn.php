<?php //V 1001 20/12/16 Modificado implementacion de Reversion?> 
<?php //V 1000 12/12/16 ?> 

<!--V 1.0 24/02/2015-->
<?php
	require"comun.inc";
	require"funciones.inc";
	require "conversor.php";
	require "validaciones.inc";
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
				}else if(document.form2.tipomovimiento.value=='401' || document.form2.tipomovimiento.value=='402'){
					if (document.form2.vigencia.value!='' && document.form2.fecha.value!='' && document.form2.objeto.value!='')
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
				document.form2.oculto.value=1;	
				document.form2.action="presu-rpn.php";
				document.form2.submit();
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
					document.location.href = "presu-rpver.php?is="+numdocar+"&vig="+vigencar;
				}else{
					var numdocar=document.getElementById('rp').value;
					document.location.href = "presu-rpver.php?is="+numdocar+"&vig="+vigencar;
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
			<tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("presu");?></tr>
			<tr>
  				<td colspan="3" class="cinta">
				<a onClick="location.href='presu-rpn.php'" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
				<a onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar"/></a>
				<a onClick="location.href='presu-buscarp.php'" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a>
				<a onClick="<?php echo paginasnuevas("presu");?>" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
				<a href="#" <?php if($_POST[oculto]==2) { ?> onClick="pdf()" <?php } ?> class="mgbt"><img src="imagenes/print.png" title="Imprimir" style="width:29px; height:25px;"></a></td>
			</tr>
     	</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
		<?php
			$vigencia=date(Y);
 			$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
 			if(isset($_POST[numerocdp])){
 				if(!empty($_POST[numerocdp])){
 					$_POST[saldocdp]=generaSaldoCDP($_POST[numerocdp],$vigusu);

 				}
 			}
			if($_POST[oculto]==''){
				$_POST[tipomovimiento]='201';
			}
			if($_POST[oculto]!="")
			{		
				$_POST[vigencia]=$vigusu;
 		 		$fec=date("d/m/Y");
		 		//$_POST[fecha]=$fec; 	
		 		$_POST[valor]=0; 	
		  		// $_POST[valorrp]=0; 			 
		 		$_POST[cuentaing]=0;
		 		$_POST[cuentagas]=0;
 		 		$_POST[cuentaing2]=0;
		 		$_POST[cuentagas2]=0;
				$sqlr="select max(consvigencia) from pptorp where vigencia=$_POST[vigencia] ";
				$res=mysql_query($sqlr,$linkbd);
				while($r=mysql_fetch_row($res)){
					$maximo=$r[0];
					}
				if(!$maximo){
					$_POST[numero]=1;
				}
	 			else{
					$_POST[numero]=$maximo+1;
				}
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
								$sqlr="select * from tipo_movdocumentos where estado='S' and modulo=3";
								$resp = mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($resp)) 
								{
									if($_POST[tipomovimiento]==$row[0].$row[1])
									{echo "<option value='$row[0]$row[1]' SELECTED>$row[0]$row[1]-$row[2]</option>";}
									else {echo "<option value='$row[0]$row[1]'>$row[0]$row[1]-$row[2]</option>";}
								}
								
							?>
						</select>
					</td>
				</tr>
			</table>
    		<table class="inicio" align="center" width="80%" >
                <tr>
                    <td class="titulos" colspan="7">.: Registro Presupuestal de Nomina</td>
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
						<td style="width:15%;"><input type="text" name="numero" id="numero" value="<?php echo $_POST[numero] ?>" style="width:80%;" readonly/></td>
					<?php
					}else if($_POST[tipomovimiento]=='401')
					{
					?>
						<td style="width:15%;">
							<input type="text" name="rp" id="rp" value="<?php echo $_POST[rp] ?>" style="width:80%;"/>
							<a href="#" onClick="despliegamodal2('visible',1);" title="Buscar Registro"><img src="imagenes/find02.png" style="width:20px;"></a>  
						</td>
						<input type="hidden" name="tercero" id="tercero" value="<?php echo $_POST[tercero]?>">
						<input type="hidden" name="cdp" id="cdp" value="<?php echo $_POST[cdp] ?>">
					<?php
					}else if($_POST[tipomovimiento]=='402')
					{
					?>
						<td style="width:15%;">
							<input type="text" name="rp" id="rp" value="<?php echo $_POST[rp] ?>" style="width:80%;"/>
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
						<td class="saludo1">Numero CDP:</td>
						<td>
							<select name="numerocdp" id="numerocdp" onChange="validar()" onKeyUp="return tabular(event,this)" style="width:80%;">
								<option value="-1">Seleccione....</option>
								<?php
									$sqlr="
									SELECT TB1.* 
									FROM pptocdp TB1, hum_nom_cdp_rp TB2 
									WHERE TB1.consvigencia=TB2.cdp AND TB2.rp='0' AND TB1.estado='S' AND TB1.vigencia='$vigusu' AND TB1.tipo_mov='201' AND TB2.vigencia='$vigusu' 
									ORDER BY TB1.consvigencia";
									$resp = mysql_query($sqlr,$linkbd);
									while ($row =mysql_fetch_row($resp)) 
									{
										if("$row[2]"==$_POST[numerocdp])
										{
											if ($_POST[oculto]==1)
											{	
												$_POST[solicita]=$row[6];
												$_POST[fechacdp]=$row[3];				 
												ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fechacdp],$fecha);
												$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];	 
												$_POST[fechacdp]=$fechaf;				 				
												$_POST[objeto]=$row[7];
												$_POST[valorrp]=$$_POST[saldocdp];
												$_POST[scdp]=$row[4];
											}
											echo "<option value='$row[2]' SELECTED>$row[2]</option>";
										}
										else{echo "<option value='$row[2]'>$row[2]</option>";}
									}			
								?>
							</select> 
							<input type="hidden" name="scdp" id="scdp" value="<?php echo $_POST[scdp]; ?>" >
						</td>
						<td class="saludo1">Fecha CDP:</td>
						<td><input name="fechacdp" type="text" id="fc_1198971546" title="DD/MM/YYYY"  value="<?php echo $_POST[fechacdp]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" style="width:80%;" readonly></td>
					</tr>
					<tr> 
						<td class="saludo1">Tercero:</td>
						<td>
							<input type="text" name="tercero" id="tercero" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo $_POST[tercero]?>" onClick="document.getElementById('tercero').focus();document.getElementById('tercero').select();" style="width:80%">&nbsp;<a onClick="despliegamodal2('visible',2);" title="Listado Terceros"><img src="imagenes/find02.png" style="width:20px;cursor:pointer;"/></a> 
							<input type="hidden" value="0" name="bt">
						</td>
						<td colspan="4">
							<input type="text" name="ntercero" id="ntercero" value="<?php echo $_POST[ntercero]?>" style="width:100%" readonly >
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
                    <td class="saludo1">Descripcion:</td>
                    <td colspan="5"><input name="objeto" type="text" id="objeto"onKeyUp="return tabular(event,this)" value="<?php echo htmlspecialchars($_POST[objeto])?>" style="width:100%"/> </td>
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
								$sqlr="Select * from pptocdp_detalle  where estado='S' and vigencia=$_POST[vigencia] and consvigencia=$_POST[numerocdp] and tipo_mov='201'  order by consvigencia";
								$resp = mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($resp)) 
								{
									 $_POST[dcuentas][]=$row[3];
									$nresul=buscacuentapres($row[3],2);			
									$_POST[dncuentas][]=$nresul;				 
									$_POST[dgastos][]=$row[7];
									$_POST[dcdpgastos][]=$row[7];				 
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
						$sqlr="Select * from pptorp_detalle  where vigencia='$vigusu' and consvigencia=$_POST[rp] and tipo_mov='201'  order by CUENTA";
						//echo $sqlr;
						$resp = mysql_query($sqlr,$linkbd);
						while ($row =mysql_fetch_row($resp)) 
						{
							$_POST[dcuentas][]=$row[3];
							$nresul=buscacuentapres($row[3],2);			
							$_POST[dncuentas][]=$nresul;				 
							$_POST[dgastos][]=$row[7];
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
							$sqlr="select count(*) from pptorp where vigencia='$_POST[vigencia]' and consvigencia=$_POST[numero]";
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
								//************** modificacion del presupuesto **************
								$sqlr="insert into pptorp (vigencia,consvigencia,fecha,idcdp,estado,tercero,valor,saldo,contrato,tipo_mov) values('$_POST[vigencia]','$_POST[numero]','$fechaf','$_POST[numerocdp]','S','$_POST[tercero]','$_POST[valorrp]','$_POST[valorrp]','$_POST[ncontrato]','201')";
								if (!mysql_query($sqlr,$linkbd))
								{
									$e =mysql_error(mysql_query($sqlr,$linkbd));
									echo"<script>despliegamodalm('visible','2','No se pudo ejecutar la petición: $e');</script>";
								}
  								else
  		 						{
		  							$sqlr="insert into contrasolicitudcdpppto (proceso, ndoc, tipodoc, vigencia, estado) values ('$_POST[ncontrato]','$_POST[numero]','RP','$_POST[vigencia]','S')";
		 							 mysql_query($sqlr,$linkbd);  
		  							 $sqlr="insert into  pptocomprobante_cab (numerotipo,tipo_comp,fecha,concepto,vigencia,total_debito, total_credito,diferencia,estado) values('$_POST[numero]',7,'$fechaf','$_POST[solicita] - $_POST[objeto]','$_POST[vigencia]','$_POST[cuentagas2]','$_POST[cuentagas2]',0,1)";
		   							mysql_query($sqlr,$linkbd); 
									
									$sqlr="update pptocdp set saldo=saldo-".$_POST[valorrp]." where vigencia='$vigusu' and consvigencia='$_POST[numerocdp]' and tipo_mov='201'";
									mysql_query($sqlr,$linkbd);
									
									$sqlr="select sum(saldo) from pptocdp_detalle where consvigencia='$_POST[numerocdp]' and vigencia='$_POST[vigencia]' and tipo_mov='201'";	
									$res=mysql_query($sqlr,$linkbd);
									$row =mysql_fetch_row($res); 
									
									if($row[0]==$_POST[valorrp]){
										$sqlr="update pptocdp set estado='C' where vigencia='$vigusu' and consvigencia='$_POST[numerocdp]' and tipo_mov='201'";
										mysql_query($sqlr,$linkbd); 
									}
									
									for($x=0;$x<count($_POST[dgastos]);$x++)
			 						{
			 							$sqlr="update pptocuentaspptoinicial set saldoscdprp=saldoscdprp-".$_POST[dgastos][$x]." where cuenta='".$_POST[dcuentas][$x]."' and (pptocuentaspptoinicial.vigencia='$_POST[vigencia]' or vigenciaf='$vigusu')";
			 							mysql_query($sqlr,$linkbd); 
										$sqlr="insert into pptorp_detalle (vigencia,consvigencia,cuenta,fuente,valor,estado,saldo,saldo_liberado,tipo_mov) values('$_POST[vigencia]','$_POST[numero]','".$_POST[dcuentas][$x]."','".$_POST[dcfuentes][$x]."',".$_POST[dgastos][$x].",'S',".$_POST[dgastos][$x].",0,'201')";
			 							mysql_query($sqlr,$linkbd); 
			 							$sqlr="update pptocdp_detalle set saldo=saldo-".$_POST[dgastos][$x]." where  cuenta='".$_POST[dcuentas][$x]."' and consvigencia=$_POST[numerocdp] and  vigencia=".$vigusu." and tipo_mov='201' ";
			  							mysql_query($sqlr,$linkbd);
			  							$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia, tipo_comp,numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values('".$_POST[dcuentas][$x]."','$_POST[tercero]','".$_POST[dfuentes][$x]."',".$_POST[dgastos][$x].",0,1,'$_POST[vigencia]', 7,'$_POST[numero]','201','1','','$fechaf')";
	 	  								mysql_query($sqlr,$linkbd); 
										$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia, tipo_comp,numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values('".$_POST[dcuentas][$x]."','$_POST[tercero]','".$_POST[dfuentes][$x]."',0,".$_POST[dgastos][$x].",1,'$_POST[vigencia]', 6,'$_POST[numerocdp]','201','1','$_POST[numero]','$fechaf')";
	 	  								mysql_query($sqlr,$linkbd); 
		  								//****modifica el comprobante ppto inicial ******		 
			 						}
			 						$sqlr="INSERT INTO humnom_rp (consvigencia,vigencia,estado) values ('$_POST[numero]','$vigusu','S')";
			 						mysql_query($sqlr,$linkbd); 
									$sqlrco ="UPDATE hum_nom_cdp_rp SET rp='$_POST[numero]' WHERE cdp='$_POST[numerocdp]' AND vigencia='$_POST[vigencia]'";
									mysql_query($sqlrco,$linkbd);
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
									$sqlr="update pptocomprobante_cab set estado=2 where numerotipo=$_POST[rp] and tipo_comp=7";
									mysql_query($sqlr,$linkbd);
									//$sqlr="insert into pptorp_cab_r (vigencia,consvigencia,idcdp,detalle,user,fecha,tipo_mov,fechadoc) values (".$vigusu.",'$_POST[rp]','$_POST[cdp]','$_POST[objeto]','".$_SESSION['nickusu']."','$gfecha','401','$fechaf')";

									$sqlr="insert into pptorp (vigencia,consvigencia,idcdp,estado,fecha,detalle,user,tipo_mov) values (".$vigusu.",'$_POST[rp]','$_POST[cdp]','R','$gfecha','$_POST[objeto]','".$_SESSION['nickusu']."','401')";


									mysql_query($sqlr,$linkbd);
									// echo $sqlr."<br><br>";
								}else if($_POST[tipomovimiento]=='402'){
									// $sqlr="update pptocomprobante_cab set estado=3 where numerotipo=$_POST[rp] and tipo_comp=7";
									// mysql_query($sqlr,$linkbd);
									//$sqlr="insert into pptorp_cab_r (vigencia,consvigencia,idcdp,detalle,user,fecha,tipo_mov,fechadoc) values (".$vigusu.",'$_POST[rp]','$_POST[cdp]','$_POST[objeto]','".$_SESSION["nickusu"]."','$gfecha','402','$fechaf')";

									$sqlr="insert into pptorp (vigencia,consvigencia,idcdp,estado,fecha,detalle,user,tipo_mov) values (".$vigusu.",'$_POST[rp]','$_POST[cdp]','R','$gfecha','$_POST[objeto]','".$_SESSION['nickusu']."','402')";
									mysql_query($sqlr,$linkbd);
									// echo $sqlr."<br><br>";
									
								}
							for($x=0;$x<count($_POST[dgastos]);$x++)
							{
								if($_POST[tipomovimiento]=='401'){
									$sqlr="update pptorp set saldo=saldo-".$_POST[dgastos][$x].", estado='RT' where consvigencia=$_POST[rp] and  vigencia=".$vigusu." AND tipo_mov='201' ";
									mysql_query($sqlr,$linkbd);
									// echo $sqlr."<br><br>";
									$sqlr="update pptorp_detalle set saldo=saldo-".$_POST[dgastos][$x].", estado='RT' where consvigencia=$_POST[rp] and  vigencia=".$vigusu." and cuenta='".$_POST[dcuentas][$x]."' AND tipo_mov='201'";
									mysql_query($sqlr,$linkbd);
									//$sqlr="insert into pptorp_det_r (vigencia,consvigencia,cuenta,fuente,valor,estado,saldo,saldo_liberado,tipo_mov) values('$_POST[vigencia]','$_POST[rp]','".$_POST[dcuentas][$x]."','".$_POST[dcfuentes][$x]."',".$_POST[dgastos][$x].",'S',".$_POST[dgastos][$x].",0,'401')";

									$sqlr="insert into pptorp_detalle (vigencia,consvigencia,cuenta,fuente,valor,estado,saldo,saldo_liberado,tipo_mov) values('$_POST[vigencia]','$_POST[rp]','".$_POST[dcuentas][$x]."','".$_POST[dcfuentes][$x]."',".$_POST[dgastos][$x].",'S',".$_POST[dgastos][$x].",0,'401')";

									mysql_query($sqlr,$linkbd); 
									// echo $sqlr."<br><br>";
									// $sqlr="update pptocomprobante_det set estado='401' where cuenta='".$_POST[dcuentas][$x]."' and vigencia='$_POST[vigencia]' and tipo_comp=6 and numerotipo='$_POST[numero]'";
									// // echo $sqlr."<br>";
									// mysql_query($sqlr,$linkbd); 
									$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia, tipo_comp,numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values('".$_POST[dcuentas][$x]."','$_POST[tercero]','".$_POST[dfuentes][$x]."',0,".$_POST[dgastos][$x].",'2','$_POST[vigencia]', 7,'$_POST[rp]','401','1','','$fechaf')";
									mysql_query($sqlr,$linkbd); 
									// echo $sqlr."<br><br>";
									$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia, tipo_comp,numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values('".$_POST[dcuentas][$x]."','$_POST[tercero]','".$_POST[dfuentes][$x]."',".$_POST[dgastos][$x].",0,1,'$_POST[vigencia]', 6,'$_POST[cdp]','401','1','$_POST[rp]','$fechaf')";
									mysql_query($sqlr,$linkbd);
								}else if($_POST[tipomovimiento]=='402'){
									$sqlr="update pptorp set saldo=saldo-".$_POST[dgastos][$x].", estado='RP' where consvigencia=$_POST[rp] and  vigencia=".$vigusu." AND tipo_mov='201' ";
									mysql_query($sqlr,$linkbd);
									// echo $sqlr."<br><br>";
									$sqlr="update pptorp_detalle set saldo=saldo-".$_POST[dgastos][$x].", estado='RP' where consvigencia=$_POST[rp] and  vigencia=".$vigusu." and cuenta='".$_POST[dcuentas][$x]."' AND tipo_mov='201' ";
									mysql_query($sqlr,$linkbd);
									//$sqlr="insert into pptorp_det_r (vigencia,consvigencia,cuenta,fuente,valor,estado,saldo,saldo_liberado,tipo_mov) values('$_POST[vigencia]','$_POST[rp]','".$_POST[dcuentas][$x]."','".$_POST[dcfuentes][$x]."',".$_POST[dgastos][$x].",'S',".$_POST[dgastos][$x].",0,'402')";
									$sqlr="insert into pptorp_detalle (vigencia,consvigencia,cuenta,fuente,valor,estado,saldo,saldo_liberado,tipo_mov) values('$_POST[vigencia]','$_POST[rp]','".$_POST[dcuentas][$x]."','".$_POST[dcfuentes][$x]."',".$_POST[dgastos][$x].",'S',".$_POST[dgastos][$x].",0,'402')";
									mysql_query($sqlr,$linkbd); 
									// echo $sqlr."<br><br>";
									// $sqlr="update pptocomprobante_det set estado='3' where cuenta='".$_POST[dcuentas][$x]."' and vigencia='$_POST[vigencia]' and tipo_comp=6 and numerotipo='$_POST[numero]'";
									// // echo $sqlr."<br>";
									// mysql_query($sqlr,$linkbd); 
									$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia, tipo_comp,numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values('".$_POST[dcuentas][$x]."','$_POST[tercero]','".$_POST[dfuentes][$x]."',0,'".$_POST[dgastos][$x]."',3,'$_POST[vigencia]', 7,'$_POST[rp]','402','1','','$fechaf')";
									mysql_query($sqlr,$linkbd); 
									// echo $sqlr."<br><br>";
									$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia, tipo_comp,numerotipo,tipomovimiento,uniejecutora,doc_receptor,fecha) values('".$_POST[dcuentas][$x]."','$_POST[tercero]','".$_POST[dfuentes][$x]."',".$_POST[dgastos][$x].",0,1,'$_POST[vigencia]', 6,'$_POST[cdp]','402','1','$_POST[rp]','$fechaf')";
									mysql_query($sqlr,$linkbd);
									// echo $sqlr."<br><br>";
								}
								
								$sqlr="update pptocdp_detalle set saldo=saldo+".$_POST[dgastos][$x]." where  cuenta='".$_POST[dcuentas][$x]."' and consvigencia=$_POST[cdp] and  vigencia=".$vigusu." and tipo_mov='201'";
								mysql_query($sqlr,$linkbd);
								// echo $sqlr."<br><br>";
								$sqlr="update pptocdp set estado='S', saldo=saldo+".$_POST[dgastos][$x]." where consvigencia='$_POST[cdp]' and  vigencia='".$vigusu."' and tipo_mov='201'";
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
</html>