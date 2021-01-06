<?php //V 1002 29/12/16 Enviaba estado 3 a la cabecera arreglado.?> 
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
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
        <script type="text/javascript" src="css/calendario.js"></script>
        <script type="text/javascript" src="JQuery/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="JQuery/autoNumeric-master/autoNumeric-min.js"></script>
		<script>
		function adelante()
		{
			if(parseFloat(document.form2.ncomp.value)<parseFloat(document.form2.maximo.value))
			{
				document.form2.oculto.value=1;
				document.form2.ncomp.value=parseFloat(document.form2.ncomp.value)+1;
				document.form2.idcomp.value=parseFloat(document.form2.idcomp.value)+1;
				document.form2.action="presu-cdp-reversarp.php";
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
				document.form2.action="presu-cdp-reversarp.php";
				document.form2.submit();
			}
		}
		function redireccionar1(){
			valorSeleccionado=document.form2.tipomovimiento.value;
			switch(valorSeleccionado){
				case '201': 
				document.location='presu-cdp.php?tipo=201';
				break;
				
				case '401': 
				document.location='presu-cdp-crear.php?tipo=401';
				break;
				
				case '402': 
				document.location='presu-cdp-reversarp.php?tipo=402';
				break;
			}
			
		}

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
					if (document.form2.vigencia.value!='' && document.form2.descripcion.value!='')
				{
					if (confirm("Esta Seguro de Guardar"))
					{
						document.form2.oculto.value='2';
						document.form2.submit();
					}
				}
				else
				{
					alert('Faltan datos para completar el registro');
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
				document.form2.action="presu-cdp-reversarp.php";
				document.form2.submit();
			}
			function validar2(formulario)
			{
				document.form2.chacuerdo.value=2;
				document.form2.action="presu-cdp-reversarp.php";
				document.form2.submit();
			}
			function validarcdp()
			{
				sinpuntitos2('valor','valorvl');
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
			function despliegamodal2(_valor,v)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){
					document.getElementById('ventana2').src="";
					document.form2.submit();
				}
				else {
					if(v==1){
						document.getElementById('ventana2').src="cdp-ventana03.php?vigencia="+document.form2.vigencia.value;
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
				document.location.href = "presu-cdpver.php?is="+numdocar+"&vig="+vigencar;
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
			function llamarventana(obj,pos,val){
				var valor = prompt("Ingrese el valor a reversar: ",val);
				if(valor!=null){
					var valoraux=document.getElementsByName("dgastosaux[]");
					if(valoraux.item(pos).value >= valor){
						obj.value = valor;
						document.form2.oculto.value="3";
						document.form2.submit();
					}else{
						despliegamodalm('visible','2','No puede exceder el saldo del rubro');
					}
					
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
            <tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("presu");?></tr>
        	<tr>
          		<td colspan="3" class="cinta">
					<a><img src="imagenes/add.png" title="Nuevo" onClick="location.href='presu-cdp.php'" class="mgbt"/></a>
					<a><img src="imagenes/guarda.png" title="Guardar" class="mgbt" onClick="guardar()"/></a>
					<a><img src="imagenes/busca.png" title="Buscar" onClick="location.href='presu-buscacdp.php'" class="mgbt"/></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a><img src="imagenes/nv.png" title="Nueva Ventana" onClick="<?php echo paginasnuevas("presu");?>" class="mgbt"></a>
					<a><img <?php if($_POST[oculto]==2) { echo"src='imagenes/print.png' title='Imprimir' onClick='pdf()' class='mgbt'";} else{ echo"src='imagenes/printd.png' class='mgbt1'";}?>/></a>
					<a><img  src="imagenes/iratras.png" title="Atr&aacute;s"  onClick="location.href='presu-gestioncdp.php'" class="mgbt"/></a>
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
 		 		$fec=date("d/m/Y");
		 		$_POST[fecha]=$fec; 	
		 		$_POST[valor]=0; 			 
		 		$_POST[cuentaing]=0;
				$_POST[cuentagas]=0;
 		 		$_POST[cuentaing2]=0;
		 		$_POST[cuentagas2]=0;
				$sqlr="select max(consvigencia) from pptocdp  where pptocdp.saldo!=pptocdp.valor and vigencia=$_POST[vigencia] and pptocdp.estado!='R'";
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
			  		$vsal=consultasaldo($_POST[cuenta],$vigenciai,$vigusu);
			  		$_POST[saldo]=$vsal;
			  		$ind=substr($_POST[cuenta],0,1);
			  		//$reg=substr($_POST[cuenta],0,1);					  	
			 		$criterio="and (pptocuentas.vigencia=".$vigusu." or  pptocuentas.vigenciaf=$vigusu) ";
			 		if ($clasifica=='funcionamiento')
			  		{
			  			$sqlr="select pptocuentas.futfuentefunc,pptocuentas.pptoinicial,pptofutfuentefunc.nombre from pptocuentas,pptofutfuentefunc where pptocuentas.cuenta='$_POST[cuenta]'  and pptocuentas.futfuentefunc=pptofutfuentefunc.codigo ".$criterio;
			 			$_POST[tipocuenta]=2;
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
			  		$res=mysql_query($sqlr,$linkbd);
			  		$row=mysql_fetch_row($res);
			      	if($row[1]!='' || $row[1]!=0)
			     	{
				 		$_POST[cfuente]=$row[0];
				  		$_POST[fuente]=$row[2];
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
			<table class="inicio">
				<tr>
					<td class="titulos" colspan="8">.: Tipo de Movimiento Reversar Parcial </td>
				</tr>
				<tr>
					<td>
						<select name="tipomovimiento" id="tipomovimiento" onKeyUp="return tabular(event,this)" onChange="redireccionar1()" >
							
							<?php 
								$sqlr="select * from tipo_movdocumentos where estado='S' and modulo='3' AND (id='2' OR id='4')";
								$resp = mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($resp)) 
								{
									if($_POST[tipomovimiento]==$row[0].$row[1]){
										echo "<option value='$row[0]$row[1]' SELECTED >$row[0]$row[1]-$row[2]</option>";
									}else{
										echo "<option value='$row[0]$row[1]'>$row[0]$row[1]-$row[2]</option>";
									}
								}
							?>
						</select>
					</td>
				</tr>
			</table>
			<?php
			
			if(!$_POST[oculto])
					{	

					$_POST[vigencia]=$vigusu;

					$sqlr="select consvigencia from pptocdp where vigencia='$vigusu' and pptocdp.valor!=pptocdp.saldo and pptocdp.tipo_mov='201' and NOT(pptocdp.estado='N') order by consvigencia desc";
					$res=mysql_query($sqlr,$linkbd);
					$r=mysql_fetch_row($res);
					
					$_POST[ncomp]='';
					$_POST[idcomp]='';
					$sqlr="select consvigencia from  pptocdp where vigencia='$vigusu' and pptocdp.valor=pptocdp.saldo and pptocdp.tipo_mov='201' and NOT(pptocdp.estado='N') ORDER BY consvigencia DESC";
					$res=mysql_query($sqlr,$linkbd);
					$r=mysql_fetch_row($res);
					$_POST[maximo]=$r[0];
					}
					
					$_POST[solicita]="";
					$_POST[objeto]="";
					$_POST[estadoc]="";
					$sqlr="select distinct *from pptocdp  where pptocdp.vigencia='$vigusu' and pptocdp.consvigencia=$_POST[ncomp] and pptocdp.tipo_mov='201' and NOT(pptocdp.estado='N') and pptocdp.valor!=pptocdp.saldo";
					$res=mysql_query($sqlr,$linkbd); 
						$_POST[agregadet]='';
						$cont=0;
						while ($row=mysql_fetch_row($res)) 
						 {		
						 $_POST[vigencia]=$row[1];
						$_POST[estado]= $row[5];
						 if($row[5]=='S')
						 {
						 $_POST[estadoc]='DISPONIBLE'; 	 
						 $color=" style='background-color:#009900 ;color:#fff'";
						 }
						 if($row[5]=='C')
						 {
						 $_POST[estadoc]='CON REGISTRO'; 	
						 $color=" style='background-color:#00CCFF ; color:#fff'"; 				  
						 }
						 if($row[5]=='N')
						 {
						 $_POST[estadoc]='ANULADO'; 	
						 $color=" style='background-color:#aa0000 ; color:#fff'"; 				  
						 }
						  if($row[5]=='R')
						 {
						 $_POST[estadoc]='REVERSADO'; 	
						 $color=" style='background-color:#aa0000 ; color:#fff'"; 				  
						 }
						$p1=substr($row[3],0,4);
						$p2=substr($row[3],5,2);
						$p3=substr($row[3],8,2);
						$_POST[fecha]=$row[3];	
						ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
							$_POST[fecha]=$fecha[3]."/".$fecha[2]."/".$fecha[1];						 
						 $_POST[solicita]=$row[6];
						 $_POST[objeto]=$row[7];
						 $_POST[numero]=$row[2];
						 }
						if($_POST[oculto]==1){
							 
							$sqlr="select distinct *from  pptocdp_detalle where  pptocdp_detalle.consvigencia=$_POST[ncomp] and pptocdp_detalle.vigencia='".$vigusu."' and pptocdp_detalle.tipo_mov='201' ORDER BY CUENTA ";
							$res=mysql_query($sqlr,$linkbd); 
							$_POST[agregadet]='';
							$cont=0;
							while ($row=mysql_fetch_row($res)) 
							 {				
							 $_POST[dcuentas][$cont]=$row[3];
							 $_POST[dncuentas][$cont]=existecuentain($row[3]);
							 $_POST[dgastos][$cont]=generaSaldoCDPxcuenta($row[2],$row[3],$row[1]);
							 $_POST[dgastosaux][$cont]=generaSaldoCDPxcuenta($row[2],$row[3],$row[1]);
							 $nfuente=buscafuenteppto($row[3],$_POST[vigencia]);
							 $cdfuente=substr($nfuente,0,strpos($nfuente,"_"));
							 $_POST[dcfuentes][]=$cdfuente;
							 $_POST[dfuentes][]=$nfuente;
							 $cont=$cont+1;
							 }
						}
						
						 ?>
						 <form name="form2" method="post" action="">
							<table class="inicio" align="center" width="80%" >
							  <tr >
								<td class="titulos" colspan="8">.: Certificado Disponibilidad Presupuestal </td>
								<td width="73" class="cerrar" ><a href="presu-principal.php">Cerrar</a></td>
							  </tr>
							  <tr  >
								<td style="width:9%;" class="saludo1">N&uacute;mero:</td>
								<td style="width:15%;">
									  
									  <input name="cuentacaja" type="hidden" value="<?php echo $_POST[cuentacaja]?>" >
									  <input name="idcomp" id="idcomp" type="text"  value="<?php echo $_POST[idcomp]?>" onKeyUp="return tabular(event,this) " style="width:50%;" onBlur="validar2()" readonly>
									  <input name="ncomp" type="hidden" value="<?php echo $_POST[ncomp]?>">
									  <a href="#" onClick="despliegamodal2('visible',1);" title="Buscar CDP"><img src="imagenes/find02.png" style="width:20px;"></a> 
									  <input type="hidden" value="s" name="siguiente" >
									  <input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo">
									  <input name="numero" type="hidden" id="numero" value="<?php echo $_POST[numero] ?>" readonly>
								</td>
							  <td style="width:9%;" class="saludo1">Vigencia:</td>
							  <td style="width:10%;"><input style="width:100%;" type="text" name="vigencia" id="vigencia" value="<?php echo $_POST[vigencia] ?>" readonly></td>
							  
							  <td class="saludo1" style="width:9%;">Fecha:        </td>
								<td style="width:10%;">
									<input name="fecha" type="text" id="fecha" title="DD/MM/YYYY"  value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" style="width:75%;" readonly> &nbsp;<a onClick="displayCalendarFor('fecha');"><img src="imagenes/calendario04.png" style="width:20px; cursor:pointer;" title="Calendario"/></a>
									<input type="hidden" name="chacuerdo" value="1">		  </td>
									<td  class="saludo1">Estado</td>
									<td >
										<input name="estadoc" type="text" id="estadoc" value="<?php echo $_POST[estadoc] ?>" <?php echo $color; ?> readonly>
										<input name="estado" type="hidden" id="estado" value="<?php echo $_POST[estado] ?>" ></td>
								</tr>
								<tr>
									<td class="saludo1">Descripcion:</td>
									<td colspan="5"><input name="descripcion" type="text" id="descripcion"onKeyUp="return tabular(event,this)" value="<?php echo $_POST[descripcion]?>" style="width:100%"/> </td>
								</tr>
								<tr>
									<input type="hidden" value="1" id="oculto" name="oculto"/>
									<td colspan="3">
										<input name="solicita" type="hidden" id="solicita" onKeyUp="return tabular(event,this)" style="width:100%;" value="<?php echo $_POST[solicita]?>" readonly></td>
									
									<td  colspan="3">
										<input name="objeto" style="width:100%;" type="hidden" id="objeto" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[objeto]?>" readonly></td>
								</tr>
								</table>
								<?php
								if(!$_POST[oculto])
								{ 
									 ?>
									 <script>
									document.form2.fecha.focus();
									</script>
								<?php
								}
								?>
									<?php
										//**** busca cuenta
										if($_POST[bc]!='')
										{
											$nresul=buscacuentapres($_POST[cuenta],2);
											if($nresul!='')
											{
												$_POST[ncuenta]=$nresul;
									?>
									<script>
										document.getElementById('valor').focus();
										document.getElementById('valor').select();
									</script>
									<?php
									}
									else
									{
												$_POST[ncuenta]="";
									?>
									<script>alert("Cuenta Incorrecta");document.form2.cuenta.focus();</script>
									<?php
											}
										}
									?>
									<table class="inicio" width="99%">
									<tr>
									  <td class="titulos" colspan="5">Detalle CDP</td>
									</tr>
									<tr>
									<td class="titulos2">Cuenta</td>
									<td class="titulos2"><center>Nombre Cuenta </center></td>
									<td class="titulos2"><center>Fuente </center></td>
									<td class="titulos2"><center>Valor </center></td>
									<!-- <td class="titulos2"><img src="imagenes/del.png"><input type='hidden' name='elimina' id='elimina'></td> -->
									</tr>
									<?php 
									$iter1='saludo1a';
									$iter2='saludo2';
									for ($x=0;$x<count($_POST[dcuentas]);$x++)
									{
										$nfuente=buscafuenteppto($_POST[dcuentas][$x],$vigusu);
										$cdfuente=substr($nfuente,0,strpos($nfuente,"_"));
										// echo "cc ".$cdfuente;
										$_POST[dcfuentes][]=$cdfuente;
										$_POST[dfuentes][]=$nfuente;
										echo "<tr class=$iter1 onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\">
												<td style='width:10%;'>
													<input name='dcuentas[]' value='".$_POST[dcuentas][$x]."' type='text' style='width:100%;' readonly class='inpnovisibles'></td>
												<td style='width:32%;'>
													<input name='dncuentas[]' value='".$_POST[dncuentas][$x]."' type='text' style='width:100%;' readonly class='inpnovisibles'></td>
												<td style='width:45%;'>
													<input name='dcfuentes[]' value='".$_POST[dcfuentes][$x]."' type='hidden'>
													<input name='dfuentes[]' value='".utf8_decode($_POST[dfuentes][$x])."' type='text' style='width:100%;' readonly class='inpnovisibles'></td>
												<td style='width:13%;'>
												    <input name='dgastosaux[]' value='".$_POST[dgastosaux][$x]."' type='hidden' >
													<input name='dgastosres[]' value='".$_POST[dgastos][$x]."' type='hidden' >
													<input name='dgastos[]' value='".number_format($_POST[dgastos][$x],2,".",",")."' type='text' style='width:100%;text-align:right;' onDblClick='llamarventana(this,$x,".$_POST[dgastosaux][$x].")' readonly class='inpnovisibles'>
													
												</td>
											</tr>";
											
										$gas=$_POST[dgastos][$x];
										$aux=$iter1;
										$iter1=$iter2;
										$iter2=$aux;
										$gas=$gas;
										$cuentagas=$cuentagas+$gas;
										$_POST[cuentagas2]=$cuentagas;
										$total=number_format($total,2,",","");
										$_POST[cuentagas]=number_format($cuentagas,2,".",",");
										$resultado = convertir($_POST[cuentagas2]);
										$_POST[letras]=$resultado." Pesos";
									 }
									 echo "<tr class='saludo1'><td></td><td colspan='1'></td>
											<td></td>
											<td>
												<input id='cuentagas' style='width:100%;text-align:right;' name='cuentagas' value='$_POST[cuentagas]' readonly class='inpnovisibles'>
												<input id='cuentagas2' name='cuentagas2' value='$_POST[cuentagas2]' type='hidden'>
												<input id='letras' name='letras' value='$_POST[letras]' type='hidden'>
											</td>
										</tr>";
									 echo "<tr><td class='saludo1'>Son:</td><td class='saludo1' colspan= '4'>$resultado</td></tr>";
									?>
									<td style="width:8%;"><input name="numero" type="hidden" id="numero" value="<?php echo $_POST[numero] ?>" style="width:90%;" readonly></td>
									<td colspan="1">
							
										<input type="hidden" name="chacuerdo" value="1">
										<td colspan="3" style="width:40%;"><input type="hidden" name="solicita" id="solicita" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[solicita]?>" style="width:96.5%;"/></td>
										<td colspan="3"><input name="objeto" type="hidden" id="objeto" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[objeto]?>" style="width:100%;"/></td>
								   </td>
									</table>
								<?php
			
							if($_POST[oculto]=='2')
							{
								if($_POST[estadoc]!='REVERSADO')
								{
										$scsolicita=eliminar_comillas($_POST[solicita]);
										$scobjeto=eliminar_comillas($_POST[objeto]);
										ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
										$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];

										$sqlr="insert into pptocdp(vigencia, consvigencia,fecha,valor,estado,solicita,objeto,saldo,tipo_mov,user) values (".$vigusu.",'$_POST[idcomp]','$fechaf','0','R','".$_SESSION["nickusu"]."','$_POST[descripcion]','0','402','".$_SESSION['nickusu']."')";
										mysql_query($sqlr,$linkbd);
										for ($x=0;$x<count($_POST[dcuentas]);$x++)
										{
			

											$sqlr="insert into pptocdp_detalle (vigencia,consvigencia,cuenta,fuente,valor,estado,saldo,saldo_liberado,tipo_mov) values('$vigusu','$_POST[numero]','".$_POST[dcuentas][$x]."','".$_POST[dfuentes][$x]."','".$_POST[dgastosres][$x]."','S','".$_POST[dgastosres][$x]."',0,'402')";

											mysql_query($sqlr,$linkbd);

											$sqlr="update pptocuentaspptoinicial set saldos=saldos+'".$_POST[dgastosres][$x]."' where cuenta='".$_POST[dcuentas][$x]."' and (pptocuentaspptoinicial.vigencia='$_POST[vigencia]' or vigenciaf='$vigusu')";
											mysql_query($sqlr,$linkbd);
											
											$sqlr="update pptocdp set saldo=saldo-'".$_POST[dgastosres][$x]."', estado='R' where consvigencia=$_POST[numero] and  vigencia=".$vigusu." and tipo_mov='201'";
											mysql_query($sqlr,$linkbd);
											
											$sqlr="update pptocdp_detalle set saldo=saldo-'".$_POST[dgastosres][$x]."', estado='R' where consvigencia=$_POST[numero] and  vigencia=".$vigusu." and cuenta='".$_POST[dcuentas][$x]."' and tipo_mov='201'";
											mysql_query($sqlr,$linkbd);
											
										
											
										}
										echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha reversado el CDP con Exito<img src='imagenes\confirm.png'></center></td></tr></table>";	
										//echo "<script>funcionmensaje();</script>";
									
								}
								else
								{
									echo "<script>despliegamodalm('visible','2','CDP ya esta reversado');</script>";
								}
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