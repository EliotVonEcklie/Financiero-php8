<?php
	header('Content-Type: text/html; charset=ISO-8859-1'); 
	require"comun.inc";
	require"funciones.inc";
	require"validaciones.inc";
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
		<title>:: SPID - Presupuesto</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
        <script type="text/javascript" src="css/calendario.js?<?php echo date('d_m_Y_h_i_s');?>"></script>
        <script type="text/javascript" src="JQuery/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="JQuery/autoNumeric-master/autoNumeric-min.js"></script>
		<script>
		function redireccionar1(){
			
			valorSeleccionado=document.form2.tipomovimiento.value;
			switch(valorSeleccionado){
				case '201': 
				document.location='ccp-cdp.php?tipo=201';
				break;
				
				case '401': 
				document.location='ccp-cdp-crear.php?tipo=401';
				break;
				
				case '402': 
				document.location='ccp-cdp-reversarp.php?tipo=402';
				break;
			}
		}
		function redireccionardestino()
		{
			valordir=document.form2.destinocdp.value;
			switch(valordir)
			{
				case '1':
				document.location='ccp-cdpcontra.php?vdir=1';
				break;

				case '2':
				document.location='ccp-cdp.php?vdir=2';
				break;

				case '3':
				document.location='ccp-cdpnomina.php?vdir=3';
				break;
			}
		}
		function adelante()
		{
			if(parseFloat(document.form2.ncomp.value)<parseFloat(document.form2.maximo.value))
			{
				document.form2.oculto.value=1;
				document.form2.ncomp.value=parseFloat(document.form2.ncomp.value)+1;
				document.form2.idcomp.value=parseFloat(document.form2.idcomp.value)+1;
				document.form2.action="ccp-cdp.php";
				document.form2.submit();
			}
		}
		
		function atrasc()
		{
			if(document.form2.ncomp.value>1)
			{
				document.form2.oculto.value=1;
				document.form2.ncomp.value=document.form2.ncomp.value-1;
				document.form2.idcomp.value=document.form2.idcomp.value-1;
				document.form2.action="ccp-cdp.php";
				document.form2.submit();
			}
		}
		function redireccionar(){
			window.locationf="ccp-cdp-crear.php";
		}
			function guardar()
			{
				var fechabloqueo=document.form2.fechabloq.value;
				var fechadocumento=document.form2.fecha.value;
				var nuevaFecha=fechadocumento.split("/");
				var fechaCompara=nuevaFecha[2]+"-"+nuevaFecha[1]+"-"+nuevaFecha[0];
				var validacion00=document.form2.solicita.value;
				if((Date.parse(fechabloqueo)) > (Date.parse(fechaCompara))){
					despliegamodalm('visible','2','Fecha de documento menor que fecha de bloqueo');
				}else{
				var vigencia="<?php echo vigencia_usuarios($_SESSION[cedulausu]) ?>";
				if(vigencia==nuevaFecha[2]){
					if (document.form2.vigencia.value!='' && document.form2.fecha.value!='' && validacion00.trim()!='')
				{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
				else
				{
					despliegamodalm('visible','2','Faltan datos para completar el registro');
					document.form2.fecha.focus();
					document.form2.fecha.select();
				}
				}else{
					despliegamodalm('visible','2','La fecha del documento debe coincidir con su vigencia');
				}	
				
					
				}

				
			}
			function validar(formulario)
			{
				
				document.form2.action="ccp-cdp.php";
				document.form2.submit();
			}
			function validar2(formulario)
			{
				document.form2.chacuerdo.value=2;
				document.form2.action="ccp-cdp.php";
				document.form2.submit();
			}
			function validarcdp()
			{
				sinpuntitos3('valor','valorvl',document.form2.cadecimal.value);
				valorp=document.getElementById("valor").value;
				nums=valorp;		
				if(nums<0 || nums> parseFloat(document.form2.saldo.value))
				{
					despliegamodalm('visible','2','Valor Superior al Disponible '+document.form2.saldo.value);
					document.form2.cuenta.select();
					document.form2.cuenta.focus();
					msg=0;
				}
				else{msg=1;}
				return msg;
			}
			function buscacta(e)
			{
				if (document.form2.cuenta.value!="")
				{
					document.form2.bc.value=2;
					document.form2.submit();
				}
			}
			function agregardetalle()
			{
				//document.form2.bc.value=2;
				if(document.form2.cuenta.value!="" &&  document.form2.fuente.value!="" && parseFloat(document.form2.valor.value) >=0 )
				{ 
					$resp=validarcdp();
					if($resp==1)
					{
						document.form2.agregadet.value=1;
						//document.form2.chacuerdo.value=2;
						document.form2.submit();
					}	
				}
				else {despliegamodalm('visible','2','Falta informacion para poder Agregar');}
			}
			function eliminar(variable)
			{
				document.getElementById('elimina').value=variable;
				despliegamodalm('visible','4','Esta Seguro de Eliminar','2');
			}
			function pdf()
			{
				document.form2.action="pdfcdispre.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function capturaTecla(e)
			{ 
				var tcl = (document.all)?e.keyCode:e.which;
				if (tcl==115)
				{
					alert(tcl);
					return tabular(e,elemento);
				}
			}
			function despliegamodal2(_valor,ventana)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){
					document.getElementById('ventana2').src="";
				}
				else {
					if(ventana==1){
						document.getElementById('ventana2').src="cuentasppto-ventana01.php?ti=2";
					}else if(ventana==2){
						document.getElementById('ventana2').src="cdp-reversar-ventana.php";
					}else if(ventana==3){
						document.getElementById('ventana2').src="contra-soladquisicionesproyectos.php";
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
			function funcionmensaje()
			{
				var numdocar=document.getElementById('numero').value;
				var vigencar=document.getElementById('vigencia').value;
				document.location.href = "ccp-cdpver.php?is="+numdocar+"&vig="+vigencar;
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
			jQuery(function($){ $('#valorvl').autoNumeric('init');});
		</script>
		<?php titlepag();?>
    </head>
    <body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("ccpet");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("ccpet");?></tr>
        	<tr>
          		<td colspan="3" class="cinta">
					<a><img src="imagenes/add.png" title="Nuevo" onClick="location.href='ccp-cdp.php'" class="mgbt"/></a>
					<a><img src="imagenes/guarda.png" title="Guardar" class="mgbt" onClick="guardar()"/></a>
					<a><img src="imagenes/busca.png" title="Buscar"  onClick="location.href='ccp-buscacdp.php'" class="mgbt"/></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a><img src="imagenes/nv.png" title="Nueva Ventana" onClick="<?php echo paginasnuevas("ccpet");?>" class="mgbt"/></a>
					<a><img <?php if($_POST[oculto]==2) {echo"src='imagenes/print.png' title='Imprimir' onClick='pdf()' class='mgbt' style='width:29px;'";} else {echo"src='imagenes/printd.png' class='mgbt1' style='width:29px;'";}?>/></a><a href="ccp-gestioncdp.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>

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
			//$vigencia=date(Y);
			$vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
			$_POST[vigencia]=vigencia_usuarios($_SESSION[cedulausu]); 
			$vigencia=$vigusu;
			if($_POST[oculto]=='')
			{
		 		//$_POST[vigencia]=$_SESSION[vigencia]; 
				$_POST[tipomovimiento]=$_GET[tipo];
				$_POST[destinocdp]=$_GET[vdir];
 		 		$fec=date("d/m/Y");
		 		$_POST[fecha]=$fec; 	
		 		$_POST[valor]=0; 			 
		 		$_POST[cuentaing]=0;
				$_POST[cuentagas]=0;
 		 		$_POST[cuentaing2]=0;
				$_POST[cadecimal]=$_SESSION["spdecimal"];
				$sqlr="select max(consvigencia) from pptocdp where vigencia=$_POST[vigencia] and tipo_mov='201'";
				$res=mysql_query($sqlr,$linkbd);
				while($r=mysql_fetch_row($res)){$maximo=$r[0];}
				if(!$maximo){$_POST[numero]=1;}
	  			else{$_POST[numero]=$maximo+1;}
			} 
			//**** busca cuenta
			if($_POST[bc]!='')
			{
				//$tipo=substr($_POST[cuenta],0,1);			
			  	$nresul=buscacuentapres($_POST[cuenta],2);			
			  	if($nresul!='')
			   	{
			  		$_POST[ncuenta]=$nresul;
			  		//$sqlr="select *from pptocuentaspptoinicial where cuenta='$_POST[cuenta]' and vigencia=".$_POST[vigencia];
 			  		$sqlr="select *from pptocuentas where cuenta='$_POST[cuenta]' and (vigencia=".$vigusu." or   vigenciaf=$vigusu)";
			  		$res=mysql_query($sqlr,$linkbd);
			  		$row=mysql_fetch_row($res);
			  		$_POST[valor]=0;		  
			  		//$_POST[saldo]=$row[6];	
			  		$vigenciai=$row[25];
			  		$clasifica=$row[29];
			  		//echo $_POST[cuenta].'  '.$vigenciai.'   '.$vigusu.'<br>';
			  		$vsal=generaSaldo($_POST[cuenta],$vigenciai,$vigusu);
			  		//echo '------------->'.$vsal.'<br>';
			  		$_POST[saldo]=round($vsal,2);
			  		$_POST[calculado]="$".number_format(generaSaldo($_POST[cuenta],$vigenciai,$vigusu),2,',','.');
			  		$ind=substr($_POST[cuenta],0,1);
			  		//$reg=substr($_POST[cuenta],0,1);					  	
			 		$criterio="and (pptocuentas.vigencia=".$vigusu." or  pptocuentas.vigenciaf=$vigusu) ";
			 		if ($clasifica=='funcionamiento')
			  		{
			  			$sqlr="select pptocuentas.futfuentefunc,pptocuentas.pptoinicial,pptofutfuentefunc.nombre from pptocuentas,pptofutfuentefunc where pptocuentas.cuenta='$_POST[cuenta]'  and pptocuentas.futfuentefunc=pptofutfuentefunc.codigo ".$criterio;
			 			$_POST[tipocuenta]=2;
						// echo $sqlr;
			  		}
			  		if ($clasifica=='deuda' )
			 		{
						$sqlr="select pptocuentas.futfuenteinv,pptocuentas.pptoinicial,pptofutfuenteinv.nombre from pptocuentas,pptofutfuenteinv where pptocuentas.cuenta='$_POST[cuenta]' and pptofutfuenteinv.codigo=pptocuentas.futfuenteinv ".$criterio;
			  			$_POST[tipocuenta]=3;
			 		}
			  		if ($clasifica=='inversion')
			  		{
						$sqlr="select pptocuentas.futfuenteinv,pptocuentas.pptoinicial,pptofutfuenteinv.nombre from pptocuentas,pptofutfuenteinv where pptocuentas.cuenta='$_POST[cuenta]' and pptofutfuenteinv.codigo=pptocuentas.futfuenteinv ".$criterio;
			  			$_POST[tipocuenta]=4;
			  		}
			  		if ($clasifica=='sgr-gastos')
			  		{
						$sqlr="select pptocuentas.futfuenteinv,pptocuentas.pptoinicial from pptocuentas where pptocuentas.cuenta='$_POST[cuenta]'  ".$criterio;
			 			$_POST[tipocuenta]=6;
			  		}
	
			  		$res=mysql_query($sqlr,$linkbd);
			  		$row=mysql_fetch_row($res);
			      	if($row[1]!='' || $row[1]!=0)
			     	{
				 		$_POST[cfuente]=$row[0];
				  		$_POST[fuente]=buscafuenteppto($_POST[cuenta],$vigusu);
				  		$_POST[valor]=0;			  
				 	}
				 	else
				  	{
					 	$_POST[cfuente]="";
	  			   		$_POST[fuente]=""; 
				  		
				  	}  
			   	}
			  	else
			  	{
			  		$_POST[ncuenta]="";	
			   		$_POST[fuente]="";				   
			   		$_POST[cfuente]="";				   			   
			   		$_POST[valor]="";
			   		
			   	}
			}
			
		$sqlv="select *from dominios where nombre_dominio='VIGENCIA_PD' and tipo='S'";
		$resv=mysql_query($sqlv,$linkbd);
		$wv=mysql_fetch_row($resv);
		$_POST[vigenciaini]=$wv[0];
		$_POST[vigenciafin]=$wv[1];
		?>
 		<form name="form2" method="post" action="">
 			<?php
 			$sesion=$_SESSION[cedulausu];
 			$sqlr="Select dominios.valor_final from usuarios,dominios where usuarios.cc_usu=$sesion and dominios.NOMBRE_DOMINIO='PERMISO_MODIFICA_DOC' and dominios.valor_inicial=usuarios.cc_usu ";
				$resp = mysql_query($sqlr,$linkbd);
				$fechaBloqueo=mysql_fetch_row($resp);
				echo "<input type='hidden' name='fechabloq' id='fechabloq' value='$fechaBloqueo[0]' />";
 			?>
        	<input type="hidden" name="valfocus" id="valfocus" value="0"/>
            <input type="hidden" name="cadecimal" id="cadecimal" value="<?php echo $_POST[cadecimal];?>"/>
			<table class="inicio">
				<tr>
					<td class="titulos" colspan="8">.: Tipo de Movimiento Disponibilidad Presupuestal </td>
				</tr>
				<tr>
					<td style="width:30%">
						<select name="tipomovimiento" id="tipomovimiento"  onChange="redireccionar1()" >
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
									$sql="SELECT codmov,tipomov from permisos_movimientos WHERE usuario='$user' AND estado='S' AND modulo='3' AND transaccion='PGA' ";
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
					<td class="saludo1" style="width:6.5%;">
							CDP
					</td>
					<td>
						<select name="destinocdp" id="destinocdp" onChange="redireccionardestino()">
							<option value="1" <?php if($_POST[destinocdp]=='1') echo "SELECTED"; ?>>CDP Contratacion</option>
			         		<option value="2" <?php if($_POST[destinocdp]=='2') echo "SELECTED"; ?>>CDP Basico</option>
			         		<option value="3" <?php if($_POST[destinocdp]=='3') echo "SELECTED"; ?>>CDP Nomina</option>
						</select>
					</td>
				</tr>
			</table>
			
    		<table class="inicio">
                <tr>
                    <td class="titulos" colspan="8">.: Certificado Disponibilidad Presupuestal </td>
                    <td class="cerrar" style="width:7%;"><a onClick="location.href='ccp-principal.php'">Cerrar</a></td>
                </tr>
                <tr>
                    <td class="saludo1" style="width:7%;">Vigencia:</td>
                    <td style="width:8%;"><input type="text" name="vigencia" id="vigencia" value="<?php echo $_POST[vigencia] ?>" style="width:90%;" readonly></td>
                    <td class="saludo1" style="width:7%;;">N&uacute;mero:</td>
                    <td style="width:8%;"><input name="numero" type="text" id="numero" value="<?php echo $_POST[numero] ?>" style="width:90%;" readonly></td>
                    <td  class="saludo1" style="width:2cm;">Fecha:</td>
                    <td colspan="1">
                        <input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)" maxlength="10">&nbsp;<img src="imagenes/calendario04.png" style="width:20px; cursor:pointer;" title="Calendario"  onClick="displayCalendarFor('fc_1198971545');" class="icobut"/>
                        <input type="hidden" name="chacuerdo" value="1">		  
                   </td>
                </tr>
                <tr>
                    <input type="hidden" value="1" name="oculto">
                    <td class="saludo1">Solicita:</td>
                    <td colspan="3" style="width:40%;"><input type="text" name="solicita" id="solicita" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[solicita]?>" style="width:96.5%;"/></td>
                    <td class="saludo1">Objeto:</td>
                    <td colspan="3"><input name="objeto" type="text" id="objeto" onKeyUp="return tabular(event,this)" value="<?php echo htmlspecialchars($_POST[objeto])?>" style="width:100%;"/></td>
                </tr>
			</table>
			<input type="hidden" name="vigenciaini" value="<?php echo $_POST[vigenciaini] ?>">
            <input type="hidden" name="vigenciafin" value="<?php echo $_POST[vigenciafin] ?>">
            <table class="inicio">
                <tr><td colspan="8" class="titulos">Cuentas</td></tr>
                <tr>
                    <td class="saludo1" style="width:10%;"> Tipo de Gasto:</td>
                    <td> 
                        <select name="tipocuenta" id="tipocuenta" onKeyUp="return tabular(event,this)" onChange="validar()" >
                            <option value="2" <?php if($_POST[tipocuenta]=='2') echo "SELECTED"; ?>>Funcionamiento</option>
                            <option value="3" <?php if($_POST[tipocuenta]=='3') echo "SELECTED"; ?>>Deuda</option>
                            <option value="4" <?php if($_POST[tipocuenta]=='4') echo "SELECTED"; ?>>Inversion</option>
                            <option value="5" <?php if($_POST[tipocuenta]=='5') echo "SELECTED"; ?>>Reservas</option>
                            <option value="6" <?php if($_POST[tipocuenta]=='6') echo "SELECTED"; ?>>Sgr-Gastos</option>
                        </select>
                    </td>
                
                <?php 
                    if($_POST[tipocuenta]==4 || $_POST[tipocuenta]==6)
                    {
						echo "
							<td class='saludo1'>Nombre</td>
							<td>
								<input type='text' name='codigoproy' id='codigoproy' value='".$_POST[codigoproy]."'>
								<a href='#' onClick=\"despliegamodal2('visible','3');\"><img src='imagenes/find02.png' style='width:20px;cursor:pointer;'/></a>
							</td>
							<td colspan='3'>
								<input type='text' name='nproyecto' id='nproyecto' value='".$_POST[nproyecto]."' style='width:100%;'>
								<input type='hidden' name='conproyec' id='conproyec' value='".conproyec."'>
							</td>
						</tr>";
						$sqln="SELECT nombre, orden FROM plannivelespd WHERE inicial='$_POST[vigenciaini]' AND final='$_POST[vigenciafin]' ORDER BY orden";
						$resn=mysql_query($sqln,$linkbd);
						$n=0; $j=0;
						while($wres=mysql_fetch_array($resn)){
							if (strcmp($wres[0],'INDICADORES')!=0){
								if($wres[1]==1) $buspad='';
								elseif($_POST[arrpad][($j-1)]!="")
									$buspad=$_POST[arrpad][($j-1)];
								else
									$buspad='';
								if($n==0){echo"<tr>";}
								echo"<td class='saludo1'>".strtoupper($wres[0])."</td>
								<td colspan='3'>
									<select name='niveles[$j]'  onChange='validar()' onKeyUp='return tabular(event,this)' style='width:100%;'>
										<option value=''>Seleccione....</option>";
										$sqlr="SELECT * FROM presuplandesarrollo WHERE padre='$buspad' AND vigencia='$_POST[vigenciaini]' AND vigenciaf='$_POST[vigenciafin]' ORDER BY codigo";
										$res=mysql_query($sqlr,$linkbd);
										while ($row =mysql_fetch_row($res)) 
										{
											if($row[0]==$_POST[niveles][$j]){
												$_POST[arrpad][$j]=$row[0];
												$_POST[codmet]=$row[0];
												$_POST[nommet]=$row[1];
												echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";
											}
											else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}	 
										}	
									echo"</select>
									<input type='hidden' name='arrpad[$j]' value='".$_POST[arrpad][$j]."' >
									<input type='hidden' name='codmet' value='".$_POST[codmet]."' >
									<input type='hidden' name='nommet' value='".$_POST[nommet]."' >
								</td>";
								$n++;
								if($n>1){$n=0;echo"</tr>";}
								$j++;
							}
						}
                    }// **** fin de if de inversion
					else{echo "</tr>";}
                ?> 
                <tr>  
                    <td  class="saludo1">Cuenta:</td>
                    <td style="width:15%"><input type="text" id="cuenta" name="cuenta" onKeyUp="return tabular(event,this)" onBlur="buscacta(event)" value="<?php echo $_POST[cuenta]?>" onClick="document.getElementById('cuenta').focus();document.getElementById('cuenta').select();" style="width:80%;"/><input type="hidden" value="" name="bc" id="bc">&nbsp;<img src="imagenes/find02.png" style="width:20px;cursor:pointer;" class="icobut" onClick="despliegamodal2('visible',1);" title="Listado de Cuentas"></td>
                    <td colspan="3" style="width:30%"><input type="text" name="ncuenta" id="ncuenta"  value="<?php echo $_POST[ncuenta]?>" style="width:100%" readonly></td>
                    <td class="saludo1" style="width:8%;">Fuente:</td>
                    <td>
                        <input type="text" name="fuente" id="fuente" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[fuente] ?>" style="width:83%;"  readonly>
                        <input type="hidden" name="cfuente" value="<?php echo $_POST[cfuente] ?>">
                    </td>
                </tr>
                <tr> 
                    <td class="saludo1">Valor:</td>
                    <td>
                        <input type="hidden" name="valor" id="valor" value="<?php echo $_POST[valor]?>" /> 
                        <input type="text" name="valorvl" id="valorvl" data-a-sign="$" data-a-dec="<?php echo $_SESSION["spdecimal"];?>" data-a-sep="<?php echo $_SESSION["spmillares"];?>" data-v-min='0' onKeyUp="sinpuntitos3('valor','valorvl','".$_SESSION["spdecimal"]."');return tabular(event,this);" value="<?php echo $_POST[valorvl]; ?>" style='width:80%;text-align:right;' />
                    </td>		  
                    <td class="saludo1">Saldo:</td>
                    <td><input type="text" name="saldo"  id="saldo" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[saldo]?>" $state readonly>
                 

                        <input type="button" name="agregar" id="agregar" value="   Agregar   " onClick="agregardetalle()" >
                        <input type="hidden" value="0" name="agregadet">
                    </td>

                </tr>  
            </table>
			<div class="subpantallac2" style="height:40%; width:99.6%; overflow-x:hidden;">
                <table class="inicio" width="99%">
                <tr><td class="titulos" colspan="6">Detalle CDP</td></tr>
                <tr>
                    <td class="titulos2" style="width:8%">Cuenta</td>
                    <td class="titulos2" style="width:20%">Nombre Cuenta</td>
                    <td class="titulos2">Fuente</td>
                    <td class="titulos2" style="width:20%">Meta</td>
                    <td class="titulos2" style="width:12%">Valor</td>
                    <td class="titulos2" style="width:5%">Eliminar</td>
                </tr>
                <?php 
                    if ($_POST[oculto]=='3')
                    { 
                        $posi=$_POST[elimina];
                        //echo "<TR><TD>ENTROS :".$_POST[elimina]." $posi</TD></TR>";
                        $cuentagas=0;
                        $cuentaing=0;
                        $diferencia=0;
                        // array_splice($_POST[dcuentas],$posi, 1);
                        unset($_POST[dcuentas][$posi]);
                        unset($_POST[dncuentas][$posi]);
                        unset($_POST[dgastos][$posi]);		 		 		 		 		 
                        unset($_POST[dcfuentes][$posi]);		 		 
                        unset($_POST[dfuentes][$posi]);		 
                        unset($_POST[dmetas][$posi]);	
                        unset($_POST[dnmetas][$posi]);			 
                        $_POST[dcuentas]= array_values($_POST[dcuentas]); 
                        $_POST[dncuentas]= array_values($_POST[dncuentas]); 
                        $_POST[dgastos]= array_values($_POST[dgastos]); 
                        $_POST[dfuentes]= array_values($_POST[dfuentes]); 		 		 		 		 
                        $_POST[dcfuentes]= array_values($_POST[dcfuentes]); 	
                        $_POST[dmetas]= array_values($_POST[dmetas]); 	
                        $_POST[dnmetas]= array_values($_POST[dnmetas]); 			 		 	 	
                        $_POST[elimina]='';	 		 		 		 
                    }	 
                    if ($_POST[agregadet]=='1')
                    {			
                        $ch=esta_en_array($_POST[dcuentas],$_POST[cuenta]);
                        if($ch!='1')
                        {			 
                            $cuentagas=0;
                            $cuentaing=0;
                            $diferencia=0;
                            $_POST[dcuentas][]=$_POST[cuenta];
                            $_POST[dncuentas][]=$_POST[ncuenta];
                            $_POST[dfuentes][]=$_POST[fuente];
                            $_POST[dcfuentes][]=$_POST[cfuente];		 
                            $_POST[valor]=$_POST[valor];
                            $_POST[dgastos][]=$_POST[valor];
                            $_POST[dmetas][]=$_POST[codmet];		 
                            $_POST[dnmetas][]=$_POST[nommet];		 		 
                            $_POST[agregadet]=0;
                            echo"
                                <script>
                                    document.form2.cuenta.value='';
                                    //document.form2.meta.value='';	
                                    //document.form2.nmeta.value='';								
                                    document.form2.ncuenta.value='';
                                    document.form2.fuente.value='';
                                    document.form2.cfuente.value='';
                                    document.form2.valor.value=0;
                                    document.form2.valorvl.value='';	
                                    document.form2.saldo.value='';			
                                    document.form2.cuenta.focus();	
                                </script>";
                        }
                        else {echo"<script>despliegamodalm('visible','2','Ya existe este Rubro en el CDP');</script>";}
                    }
                ?>
                <input type='hidden' name='elimina' id='elimina'>
                <?php
                    // echo "<TR><TD>t :".count($_POST[dcuentas])."</TD></TR>";
					$co="saludo1a";
		  			$co2="saludo2";
					$_POST[cuentagas]=0;
                    for ($x=0;$x<count($_POST[dcuentas]);$x++)
                    {
                        echo "
                        <input type='hidden' name='dcuentas[]' value='".$_POST[dcuentas][$x]."'/>
                        <input type='hidden' name='dncuentas[]' value='".$_POST[dncuentas][$x]."'/>
                        <input type='hidden' name='dcfuentes[]' value='".$_POST[dcfuentes][$x]."'/>
                        <input type='hidden' name='dfuentes[]' value='".$_POST[dfuentes][$x]."'/>
                        <input type='hidden' name='dmetas[]' value='".$_POST[dmetas][$x]."'/>
                        <input type='hidden' name='dnmetas[]' value='".$_POST[dnmetas][$x]."'/>
                        <input type='hidden' name='dgastos[]' value='".$_POST[dgastos][$x]."'/>
                        <tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\">
                            <td>".$_POST[dcuentas][$x]."</td>
                            <td>".$_POST[dncuentas][$x]."</td>
                            <td>".$_POST[dfuentes][$x]."</td>
                            <td>".$_POST[dnmetas][$x]."</td>
                            <td style='text-align:right;' onDblClick='llamarventana(this,$x)'>$ ".number_format($_POST[dgastos][$x],2,$_SESSION["spdecimal"],$_SESSION["spmillares"])."</td>
                            <td style='text-align:center;'><a style='cursor:pointer' onclick='eliminar($x)'><img src='imagenes/del.png'></a></td>
                        </tr>";
						$aux=$co;
						$co=$co2;
		 				$co2=$aux;
                        $gas=$_POST[dgastos][$x];
                        $gas=$gas;
                        $_POST[cuentagas]=$_POST[cuentagas]+$gas;
                        $resultado = convertir($_POST[cuentagas]);
                        $_POST[letras]=$resultado." Pesos";
                    }
                    echo "
					<input type='hidden' id='cuentagas' name='cuentagas' value='$_POST[cuentagas]'/>
					<input type='hidden' id='letras' name='letras' value='$_POST[letras]'/>
                    <tr class='$iter' style='text-align:right;'>
                        <td colspan='4'>Total:</td>
                        <td>$ ".number_format($_POST[cuentagas],2,$_SESSION["spdecimal"],$_SESSION["spmillares"])."</td>
                    </tr>
                    <tr class='titulos2'>
						<td>Son:</td>
						<td colspan='5'>$resultado</td>
					</tr>";
                ?>
            	</table>
				<?php
                     //***************PARTE PARA INSERTAR Y ACTUALIZAR LA INFORMACION
                    if($_POST[oculto]=='2')
                    {
                        $scsolicita=eliminar_comillas($_POST[solicita]);
                        $scobjeto=$_POST[objeto];
                        ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
                        $fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
                        $bloq=bloqueos($_SESSION[cedulausu],$fechaf);
                        if($bloq>=1)
                        {
                            $sqlr="select count(*) from pptocdp where vigencia='$_POST[vigencia]' and consvigencia=$_POST[numero]";
                            $res=mysql_query($sqlr,$linkbd);
                            while($r=mysql_fetch_row($res)){$numerorecaudos=$r[0];}
                            if($numerorecaudos==0)
                            {
                                $nr="1";	 	
                                //************** modificacion del presupuesto **************
                                $sqlr="INSERT INTO pptocdp (vigencia,consvigencia,fecha,valor,estado,solicita,objeto,saldo,tipo_mov,user) values('$_POST[vigencia]','$_POST[numero]', '$fechaf','$_POST[cuentagas]','S','$scsolicita','$scobjeto','$_POST[cuentagas]','201','".$_SESSION['nickusu']."')";
								
                                if (!mysql_query($sqlr,$linkbd))
                                {
                                    $e =mysql_error(mysql_query($sqlr,$linkbd));
                                    echo"<script>despliegamodalm('visible','2','No se pudo ejecutar la petición: ');</script>";
                                }
                                else
                                {
                                   
                                    for ($x=0;$x<count($_POST[dcuentas]);$x++)
                                    {

                                        $sqlr="update pptocuentaspptoinicial set saldos=saldos-".$_POST[dgastos][$x]." where cuenta='".$_POST[dcuentas][$x]."' and (vigencia=$vigusu or vigenciaf=$vigusu)";
                                        $res=mysql_query($sqlr,$linkbd); 
                                        $sqlr="INSERT INTO pptocdp_detalle (vigencia,consvigencia,cuenta,fuente,valor,estado,saldo,saldo_liberado,tipo_mov) values('$_POST[vigencia]','$_POST[numero]','".$_POST[dcuentas][$x]."','".$_POST[dcfuentes][$x]."','".$_POST[dgastos][$x]."','S','".$_POST[dgastos][$x]."',0,'201')";
                                        $res=mysql_query($sqlr,$linkbd);
                                        $sqlr="INSERT INTO presucdpplandesarrollo (id_cdp,vigencia,codigo_meta,fecha,tipogasto,rubro) values($_POST[numero],$_POST[vigencia],'".$_POST[dmetas][$x]."','$fechaf',$_POST[tipocuenta],'".$_POST[dcuentas][$x]."')";
                                        mysql_query($sqlr,$linkbd);  
                                        //****crea comprobante presupuesto  cdp
                                      
										//echo $sqlr;
									
										
										
                                        echo "<script>despliegamodalm('visible','1','Se ha almacenado el CDP con Exito');</script>";
                                    }
									$sqlr="INSERT INTO pptosaldocdp (cdp,saldo,vigencia) values('$_POST[numero]','$_POST[cuentagas]','$_POST[vigencia]')";
									mysql_query($sqlr,$linkbd);
                                }
								 
                            }
							
                            else{echo"<script>despliegamodalm('visible','2','Ya Existe un CDP con este Numero');</script>";}
                        }
                        else
                        {echo"<script>despliegamodalm('visible','2',' No Tiene los Permisos para Modificar este Documento');</script>";
                    }
                 }//*** if de control de guardado
            ?> 
    </div>        
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
   var confirma=confirm('¿Realmente desea cambiar la vigencia?');
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