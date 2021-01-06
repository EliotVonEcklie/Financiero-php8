<?php //V 1003 29/12/16 No colocaba estado 2 a los detalles de la reversion.?> 
<?php
	error_reporting(0);
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
		<title>:: SPID - Tesoreria</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
		<link href="css/css3.css" rel="stylesheet" type="text/css" />
		<link href="css/tabs.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="JQuery/jquery-2.1.4.min.js"></script>
		<script>
			function refrescar(){
				document.form2.rp.value=''; 
				document.form2.cdp.value=''; 
				document.form2.detallecdp.value='';
				document.form2.cc.value='';
				document.form2.tercero.value='';
				document.form2.ntercero.value='';
				document.form2.detallegreso.value='';
				document.form2.valorrp.value='';
				document.form2.saldorp.value='';
				document.form2.pvigant.value=0;
				document.form2.valor.value=0;
				document.form2.base.value='';
				document.form2.iva.value='';
				document.form2.totalc.value='';
				document.form2.totalcf.value='';
				document.form2.valorcheque.value='';
				document.form2.cambio.value='1';
				document.form2.valoregreso.value=0;
				document.form2.valorretencion.value=0;
				document.form2.valorcheque.value=0;
				document.form2.submit();
			}
			function buscacta(e)
 			{
				if (document.form2.cuenta.value!="")
				{
				 	document.form2.bc.value='1';
 					document.form2.submit();
				}
 			}
			function validar(){
				document.form2.submit();

			}
			function validar2(){
				document.form2.cxpo.value=1;
				document.form2.tipomovimiento.value='401';
				document.form2.submit();
				
			}
			function buscarp(e)
 			{
				
				if (document.form2.rp.value!="")
				{
						
					document.form2.brp.value='1';
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
 				else {alert("Falta informacion para poder Agregar"); }
			}
			function agregardetalled()
			{
				if(document.form2.retencion.value!="" &&  document.form2.vporcentaje.value!=""  )
				{ 
					document.form2.agregadetdes.value=1;
					document.form2.submit();
				}
				else {alert("Falta informacion para poder Agregar");}
			}
			function eliminar(variable)
			{
				if (confirm("Esta Seguro de Eliminar"))
  				{
					document.form2.elimina.value=variable;
					vvend=document.getElementById('elimina');
					vvend.value=variable;
					document.form2.submit();
				}
			}
			function eliminard(variable)
			{
				if (confirm("Esta Seguro de Eliminar"))
  				{
					document.form2.eliminad.value=variable;
					vvend=document.getElementById('eliminad');
					vvend.value=variable;
					document.form2.submit();
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
						
						if(document.form2.tipomovimiento.value=='201'){
							
							var saldo=parseInt(document.form2.saldorp.value);
							var valcxp=parseInt(document.form2.valor.value);
							if(saldo<valcxp){
								despliegamodalm('visible','2','La orden de pago excede el saldo del RP');
							}else{
								
								if(saldo<=0){
								despliegamodalm('visible','2','No hay saldo en dicho registro');
								}else{
									if( document.form2.fecha.value!='' && document.form2.destino.value!='' && document.form2.cc.value!='' && document.form2.medioDePago.value!='-1')
									{
										despliegamodalm('visible','4','Esta Seguro de Guardar','1');					
									}
									else {despliegamodalm('visible','2','Falta informacion para Crear la Cuenta');}
								}
						}
						
					
				}else{
					if( document.form2.cxp.value!='')
					{
						despliegamodalm('visible','4','Esta Seguro de Guardar','1');					
					}
					else 
					{
						despliegamodalm('visible','2','Falta informacion para Crear la Cuenta');
					}
				}
						}else{
							despliegamodalm('visible','2','La fecha del documento debe coincidir con su vigencia');
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
				if(document.form2.tipomovimiento.value=='201'){
					var _cons=document.getElementById('idcomp').value;
					document.location.href = "teso-egresover.php?idop="+_cons+"&scrtop=0&numpag=1&limreg=10&filtro=#";
				}else{
					var _cons=document.getElementById('cxp').value;
					document.location.href = "teso-egresover.php?idop="+_cons+"&scrtop=0&numpag=1&limreg=10&filtro=#";
				}
			}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	
							document.form2.oculto.value='2';
								document.form2.submit();break;
				}
			}
			
			function calcularpago()
 			{
				pvig=parseFloat(document.form2.sumarbase.value);
				pvig2=parseFloat(document.form2.pvigant.value);
				valorp=document.form2.valor.value;
				document.form2.base.value=parseFloat(valorp)+parseFloat(pvig)+parseFloat(pvig2)-parseFloat(document.form2.iva.value);
				descuentos=document.form2.totaldes.value;
				valorc=valorp-descuentos;
				document.form2.valorcheque.value=valorc;
				document.form2.valoregreso.value=valorp;
				document.form2.valorretencion.value=descuentos;	
	  			document.form2.submit();
 			}
			function pdf()
			{
				document.form2.action="pdfcxp.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
			}
			function sumapagosant() 
			{ 
 				cali=document.getElementsByName('pagos[]');
				valrubro=document.getElementsByName('pvalores[]');
 				sumar=0;
				for (var i=0;i < cali.length;i++) 
				{ 
					if (cali.item(i).checked == true)
					{
						sumar=parseInt(sumar)+parseInt(valrubro.item(i).value);
					}
				} 
				pvig=parseInt(document.form2.pvigant.value);
				document.form2.sumarbase.value=sumar+pvig;	
				document.getElementById("sumarbase2").value=sumar+pvig;	
	 			resumar();
			} 
			
			function resumar() 
			{ 
				cali=document.getElementsByName('rubros[]');
			 	valrubro=document.getElementsByName('dvalores[]');
			 	sumar=0;
				for (var i=0;i < cali.length;i++) 
				{ 
					if (cali.item(i).checked == true){sumar=parseInt(sumar)+parseInt(valrubro.item(i).value);}
				} 
				if(document.form2.regimen.value==1){
					$d=0;
					iva1=sumar-(sumar/1.19);
					document.form2.iva.value=parseInt(iva1);
					iva2=document.form2.sumarbase.value-(document.form2.sumarbase.value/1.19);
					//alert(iva2);
					document.form2.iva.value=parseInt(document.form2.iva.value)+parseInt(iva2);
				}
			 	else {
			 		document.form2.iva.value=0;
			 	}	
				//alert(sumar);
				
				//alert(document.form2.iva.value);
				document.form2.base.value=sumar-document.form2.iva.value+parseInt(document.form2.sumarbase.value);	
				document.form2.totalc.value=sumar;
				document.form2.valor.value=sumar;
				document.form2.valoregreso.value=sumar;
				document.form2.valorcheque.value=document.form2.valor.value-document.form2.valorretencion.value;	
				document.form2.submit();	
			} 
			function checkinicios()
			{
 				cali=document.getElementsByName('inicios[]');
				for (var i=0;i < cali.length;i++) 
 				{ 
					if (document.getElementById("inicia").checked == true) 
					{
	 					cali.item(i).checked = true;
 	 					document.getElementById("inicia").value=1;	 
					}
					else
					{
						cali.item(i).checked = false;
    					document.getElementById("inicia").value=0;
					}
 				}
				document.form2.submit();
			}
			function checktodos()
			{
 				cali=document.getElementsByName('rubros[]');
 				valrubro=document.getElementsByName('dvalores[]');
				for (var i=0;i < cali.length;i++) 
 				{ 
					if (document.getElementById("todos").checked == true) 
					{
	 					cali.item(i).checked = true;
 	 					document.getElementById("todos").value=1;	 
					}
					else
					{
						cali.item(i).checked = false;
    					document.getElementById("todos").value=0;
					}
 				}	
 				resumar() ;
			}
			function buscater(e)
 			{ 
				if (document.form2.tercero.value!="")
				{
					document.form2.bt.value='1';
 					document.form2.submit();
 				}
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
						case "3":	document.getElementById('ventana2').src="reversar-cxp.php?vigencia="+_vaux;break;
						case "4":	document.getElementById('ventana2').src="ventana-servicio.php?vigencia="+_vaux;break;
					}
				}
			}
			function sumatotal(pos){
				var posicion=pos;
				document.getElementById("ccambio").value='1';
				document.form2.brp.value='1';
				var vectorpos=document.getElementsByName("poscheck[]");
				var valor=document.getElementsByName("valauto[]");
				var valitem=valor.item(posicion).value;
				var items=document.getElementsByName("agrega[]");
				var itembool=items.item(posicion).checked;
				if(itembool==true){
					vectorpos.item(pos).value='1';
					document.getElementById("sumarauto").value=parseFloat(document.getElementById("sumarauto").value)+parseFloat(valitem);
					document.getElementById("saldoauto").value=parseFloat(document.getElementById("saldoauto").value)-parseFloat(valitem);
				}else{
					vectorpos.item(pos).value='0';
					document.getElementById("sumarauto").value=parseFloat(document.getElementById("sumarauto").value)-parseFloat(valitem);
					document.getElementById("saldoauto").value=parseFloat(document.getElementById("saldoauto").value)+parseFloat(valitem);
				}
				document.getElementById("bservi").value='';
				document.form2.submit();
				
			}
			function direccionaCuentaGastos(row){
			//alert (row);
			window.open("presu-editarcuentaspasiva.php?idcta="+row);
			}
			function excel()
			{
				document.form2.action="teso-egresoregistrosexcel.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
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
			<tr class="cinta">
  				<td colspan="3" class="cinta">
					<a href="teso-egreso.php" accesskey="n" class="mgbt"><img src="imagenes/add.png" title="Nuevo" border="0" /></a>
					<a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a>
					<a href="teso-buscaegreso.php" accesskey="b" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" class="mgbt" onClick="<?php echo paginasnuevas("teso");?>"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
					<a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png"  style="width:29px;height:25px;" title="Imprimir" /></a>
					<a href="#" onClick="excel()" class="mgbt"><img src="imagenes/excel.png" title="Excel"/></a>
					<a href="teso-gestionpago.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
				</td>
			</tr>
		</table>
		<?php
			$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
			//*********** cuenta origen va al credito y la destino al debito
			if(!$_POST[oculto])
			{
				$_POST[vigencia]=$vigusu;
				$_POST[valauto]=Array();
				$_POST[salauto]=Array();
				$_POST[agrega]=Array();
				$_POST[selectipo]="rp";
				$sqlr="select *from cuentapagar where estado='S' ";
				$res=mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($res)){$_POST[cuentapagar]=$row[1];}
				$_POST[pvigant]=0;
				$check1="checked";
 		 		$fec=date("d/m/Y");
		 		$_POST[fecha]=$fec; 		 		  			 
		 		$_POST[vigencia]=$vigusu; 		
		 		$sqlr="select max(numerotipo) from comprobante_cab where tipo_comp='11' ";
				$res=mysql_query($sqlr,$linkbd);
				$consec=0;
				while($r=mysql_fetch_row($res)){$consec=$r[0];}
	 			$consec+=1;
	 			$_POST[idcomp]=$consec;	
				$sqlr="select max(id_orden) from tesoordenpago";
				$res=mysql_query($sqlr,$linkbd);
				$consec=0;
				while($r=mysql_fetch_row($res)){$consec=$r[0];}
	 			$consec+=1;
	 			$_POST[idcomp]=$consec;
				if($_POST[cxpo]!=1)$_POST[tipomovimiento]='201';
			}
			switch($_POST[tabgroup1])
			{
				case 1:	$check1='checked';break;
				case 2: $check2='checked';break;
				case 3: $check3='checked';break;
				case 4: $check4='checked';break;
				case 5: $check5='checked';break;
				case 6: $check6='checked';break;
			}
			if($_POST[anticipo]=='S'){
				$chkant=' checked ';
				//$_POST[reado]='readonly';
				}
			
		?>
		<div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; "> 
                </IFRAME>
            </div>
        </div>
 		<form name="form2" method="post" action=""> 
 		<?php
 			$sesion=$_SESSION[cedulausu];
 			$sqlr="Select dominios.valor_final from usuarios,dominios where usuarios.cc_usu=$sesion and dominios.NOMBRE_DOMINIO='PERMISO_MODIFICA_DOC' and dominios.valor_inicial=usuarios.cc_usu ";
				$resp = mysql_query($sqlr,$linkbd);
				$fechaBloqueo=mysql_fetch_row($resp);
				echo "<input type='hidden' name='fechabloq' id='fechabloq' value='".$fechaBloqueo[0]."' />";
 		?>
			<table class="inicio">
				<tr>
					<td class="titulos" style="width:100%;">.: Tipo de Movimiento 
						<input type="hidden" value="1" name="oculto" id="oculto">
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
									$sql="SELECT codmov,tipomov from permisos_movimientos WHERE usuario='$user' AND estado='S' AND modulo='4' AND transaccion='TPA' ";
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
 			<?php
				$_POST[destino]='00';
				if($_POST[cambio]=='1'){
					unset($_POST[dcuentas]);
					unset($_POST[dncuentas]);
					unset($_POST[drecursos]);
					unset($_POST[dnrecursos]);
					unset($_POST[dvalores]);
					unset($_POST[dvaloresoc]);
					unset($_POST[dvaloresoc]);
					unset($_POST[pcxp]);
					unset($_POST[pfecha]);
					unset($_POST[prp]);
					unset($_POST[pter]);
					unset($_POST[pvalores]);
					unset($_POST[pagos]);
					unset($_POST[ddescuentos]);
					unset($_POST[dndescuentos]);
					unset($_POST[dporcentajes]);
					unset($_POST[ddesvalores]);
					$_POST[cambio]='';
				}
				if($_POST[bservi]=='1'){
					$sql="SELECT SUM(valor) FROM inv_servicio_det WHERE codcompro='$_POST[servicio]' AND estado='S' AND liberado='1' ";
					$res=mysql_query($sql,$linkbd);
					$fila=mysql_fetch_row($res);
					$_POST[sumarauto]=$fila[0];
					$_POST[saldoauto]=0;
					//************
					$sql="SELECT contrasoladquisiciones.coddestcompra FROM contracontrato,inv_servicio,contrasoladquisiciones WHERE inv_servicio.codcompro='$_POST[servicio]' AND contracontrato.id_contrato=inv_servicio.idproceso AND inv_servicio.vigencia='$_POST[vigencia]' AND ! ( inv_servicio.estado =  'R'
OR inv_servicio.estado =  'P' ) AND contracontrato.codsolicitud=contrasoladquisiciones.codsolicitud AND contrasoladquisiciones.estado='S' ";
					$res=mysql_query($sql,$linkbd);
					$row=mysql_fetch_row($res);
					$_POST[destino]=$row[0];
				}
 				if($_POST[brp]=='1' )
			 	{
			  		$nresul=buscaregistro($_POST[rp],$_POST[vigencia]);
					$sqlr="select idcdp,vigenciacdp from pptorp where consvigencia=$_POST[rp] and vigencia=$_POST[vigencia] and tipo_mov='201' "; 
					
					//echo $sqlr;
					$resp = mysql_query($sqlr,$linkbd);
					$row =mysql_fetch_row($resp);
			  		if($nresul!='|1')
			   		{
			  			$_POST[cdp]=$row[0];
			  			$vigencia=$_SESSION[vigencia];
			  			//*** busca detalle cdp
  						$sqlr="select pptorp.vigencia,pptorp.consvigencia,pptocdp.objeto,pptorp.estado,pptocdp.consvigencia, pptorp.valor,pptorp.saldo,pptorp.tercero, pptocdp.objeto from pptorp,pptocdp where pptocdp.consvigencia=$_POST[cdp] and pptorp.idcdp=pptocdp.consvigencia and pptorp.consvigencia=".$_POST[rp]." and pptorp.vigencia=$_POST[vigencia] and pptorp.idcdp=pptocdp.consvigencia and pptocdp.vigencia='$row[1]' and pptorp.tipo_mov='201' and pptocdp.tipo_mov='201' order  by pptorp.vigencia,pptorp.consvigencia,pptocdp.objeto,pptorp.estado";
						$resp = mysql_query($sqlr,$linkbd);
						$row =mysql_fetch_row($resp);
						$_POST[detallecdp]=$row[2];
						$_POST[tercero]=$row[7];
						$_POST[ntercero]=buscatercero($_POST[tercero]);
						$_POST[regimen]=buscaregimen($_POST[tercero]);			
						$_POST[valorrp]=$row[5];
						$_POST[saldorp]=generaSaldoRP($_POST[rp],$_POST[vigencia]);
						if(isset($_POST[sumarauto]) && !empty($_POST[sumarauto]) ){
							$_POST[valor]=$_POST[sumarauto];
						}else{
							$_POST[valor]=generaSaldoRP($_POST[rp],$_POST[vigencia]);
						}
						
						if($_POST[regimen]==1){$_POST[iva]=round($_POST[valor]-$_POST[valor]/(1.19),1);}
				 		else {$_POST[iva]=0;}
				 					
				 		$_POST[base]=$_POST[valor]-$_POST[iva];	
						$_POST[detallegreso]=$row[8];
						$_POST[valoregreso]=$_POST[valor];
						$_POST[valorretencion]=$_POST[totaldes];
						$_POST[valorcheque]=$_POST[valoregreso]-$_POST[valorretencion];
						$_POST[valorcheque]=number_format($_POST[valorcheque],2);				
			  		}
			 		else
					{
						$_POST[cdp]="";
					  	$_POST[detallecdp]="";
					  	$_POST[tercero]="";
					  	$_POST[ntercero]="";
					}
				}
			 	if($_POST[bt]=='1')//***** busca tercero
			 	{
			  		$nresul=buscatercero($_POST[tercero]);
			  		$_POST[regimen]=buscaregimen($_POST[tercero]);	
			 		if($nresul!='')
			   		{
			  			$_POST[ntercero]=$nresul;
  						if($_POST[regimen]==1){$_POST[iva]=round($_POST[valor]-$_POST[valor]/(1.19),1);	}
				 		else{$_POST[iva]=0;}	
				 		$_POST[base]=$_POST[valor]-$_POST[iva];				 
			  		}
					else{ $_POST[ntercero]="";}
			 	}
				if(isset($_POST[anticipo]) && $_POST[anticipo]=="S")
				{
					//$_POST[reado]='readonly';
					$_POST[iva]=0;
				}
 			?>
 		<?php
			if($_POST[tipomovimiento]=='201')
			{
		?>
		<div class="tabs" style="height:68%; width:99.7%">
   				<div class="tab" >
       				<input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
	   				<label for="tab-1">Liquidacion CxP</label>
	   				<div class="content" style="overflow-x:hidden;">
    					<table class="inicio" align="center" >
      						<tr>
        						<td class="titulos" colspan="7">Liquidacion CxP</td>
                                <td class="cerrar" style="width:7%" onClick="location.href='teso-principal.php'">Cerrar</td>
      						</tr>
      						<tr>
		        				<td class="saludo1" style="width:2.6cm;">Numero CxP:</td>
        						<td style="width:20%;">
                                	<input type="text" name="idcomp" id="idcomp" value="<?php echo $_POST[idcomp]?>" style="width:40%;" readonly/> 
                                    <span class="saludo3">Anticipo: <input class="defaultcheckbox" type="checkbox" name="anticipo" value="S" onChange="validar()" <?php echo $chkant; ?>/></span>
                              	</td>
	  							<td class="saludo1" style="width:3.1cm;">Fecha:</td>
       							<td style="width:12%;"><input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" style="width:80%;" title="DD/MM/YYYY"/>&nbsp;<a href="#" onClick="displayCalendarFor('fc_1198971545');" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px;"/></a></td>
	  							<td class="saludo1" style="width:3cm;">Medio de pago: </td>
        						<td style="width:14%;">
									<select name="medioDePago" id="medioDePago" onKeyUp="return tabular(event,this)" style="width:80%">
										<option value="-1" <?php if(($_POST[medioDePago]=='-1')) echo "SELECTED"; ?>>Seleccione...</option>
         								<option value="1" <?php if(($_POST[medioDePago]=='1')) echo "SELECTED"; ?>>Con SF</option>
          								<option value="2" <?php if($_POST[medioDePago]=='2') echo "SELECTED"; ?>>Sin SF</option>         
        							</select>
									<input type="hidden" name="vigencia"  value="<?php echo $_POST[vigencia]?>" onKeyUp="return tabular(event,this)" readonly/>
								</td>
                                <td rowspan="7" colspan="2" style="background:url(imagenes/factura03.png); background-repeat:no-repeat; background-position:right; background-size: 90% 95%"></td>
 							</tr>
        					<tr>
							<td class="saludo1">Tipo de Entrada:</td>
	  							<td>
									<select name="selectipo"  onChange="refrescar()" onKeyUp="return tabular(event,this)" style="width:100%;">
										<option value="rp" <?php if($_POST[selectipo]=="rp"){echo "SELECTED"; } ?> >Registro Presupuestal</option>
										<option value="servicio" <?php if($_POST[selectipo]=="servicio"){echo "SELECTED"; } ?>>Entrada de Servicio</option>
	   								</select>
								</td>
								<input type="hidden" name="cambio" id="cambio" value="<?php echo $_POST[cambio]; ?>" />
								<input type="hidden" name="bservi" id="bservi" value="<?php echo $_POST[bservi]; ?>" />
							    <input type="hidden" name="ccambio" id="ccambio" value="<?php echo $_POST[ccambio]; ?>" />
								<input type="hidden" name="destino" id="destino" value="<?php echo $_POST[destino]; ?>" />
								<!--
        						<td class="saludo1">Destino Compra:</td>
	  							<td>
									<select name="destino"  onChange="validar()" onKeyUp="return tabular(event,this)" style="width:100%;">
										
										<?php
										/*
											$sqlr="select *from almdestinocompra where estado='S' order by codigo	";
											$res=mysql_query($sqlr,$linkbd);
											while ($row =mysql_fetch_row($res)) 
		    								{
		 										if("$row[0]"==$_POST[destino]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
												else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
											}
										*/											
										?>
	   								</select>
								</td> 
								 !-->	
								<td  class="saludo1"><?php if($_POST[selectipo]=='rp' ){echo "Registro: "; }else{echo "Servicio: "; }  ?></td>
        						<td>
								<?php
							  if($_POST[selectipo]=='rp' ){
								 ?>								
                                	<input type="text" name="rp" id="rp" value="<?php echo $_POST[rp]?>" onKeyUp="return tabular(event,this)" onBlur="buscarp(event)" style="width:80%;" />
								  <?php
							    }else{
									?>
									<input type="text" name="servicio" id="servicio" value="<?php echo $_POST[servicio]?>" onKeyUp="return tabular(event,this)" onBlur="buscarp(event)" style="width:80%;" / readonly>
								    <input type="hidden" name="rp" id="rp" value="<?php echo $_POST[rp]?>">
								    <?php
							      }
									?>
									<input type="hidden" value="0" name="brp">
                                    <a href="#" onClick="despliegamodal2('visible','<?php if($_POST[selectipo]=='rp' ){echo "1"; }else{echo "4"; }  ?>','<?php echo $_POST[vigencia]?>');" title="Buscar Registro"><img src="imagenes/find02.png" style="width:20px;"></a>       
                             	</td>								 
        						<td  class="saludo1">Causacion Contable:</td>
                                <td>
                                	<select name="causacion" id="causacion" onKeyUp="return tabular(event,this)" style="width:80%">
         								<option value="1" <?php if(($_POST[causacion]=='1') && ($_POST[destino]!='00')) echo "SELECTED"; ?>>Si</option>
          								<option value="2" <?php if($_POST[causacion]=='2') echo "SELECTED"; ?>>No</option>         
        							</select>
                               	</td>
                        	
        						
                           	</tr>
        					<tr>
	  							<td class="saludo1">CDP:</td>
	  							<td><input type="text" id="cdp" name="cdp" value="<?php echo $_POST[cdp]?>" style="width:80%;" readonly></td>
	  							<td class="saludo1">Detalle RP:</td>
	  							<td colspan="3"><input type="text" id="detallecdp" name="detallecdp" value="<?php echo $_POST[detallecdp]?>" style="width:100%;" readonly></td>
	  						</tr> 
	  						<tr>
	  							<td class="saludo1">Centro Costo:</td>
	  							<td>
									<select name="cc"  onChange="validar()" onKeyUp="return tabular(event,this)" style="width:100%;">
										<option value="">Seleccione ...</option>
										<?php
                                            $sqlr="select *from centrocosto where estado='S' order by id_cc	";
                                            $res=mysql_query($sqlr,$linkbd);
                                            while ($row =mysql_fetch_row($res)) 
                                            {
                                                if("$row[0]"==$_POST[cc]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
                                                else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
                                            }	 	
                                        ?>
  									</select>
	 							</td>
	    						<td class="saludo1">Tercero:</td>
          						<td>
									<input type="text" id="tercero" name="tercero" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo $_POST[tercero]?>" style="width:80%;">
									<input type="hidden" value="0" name="bt">&nbsp;<a href="#" onClick="despliegamodal2('visible','2')"><img src="imagenes/find02.png" style="width:20px;"></a></td>
          						<td colspan="2">
									<input type="text" id="ntercero"  name="ntercero" value="<?php echo $_POST[ntercero]?>" style="width:100%;" readonly>
								</td>
                      		</tr>
          					<tr>
                            	<td class="saludo1">Detalle CxP:</td>
                                <td colspan="5"><input type="text" id="detallegreso" name="detallegreso" value="<?php echo $_POST[detallegreso]?>" style="width:100%;"></td>
                          	</tr>
	  						<tr>
                            	<td class="saludo1">Valor RP:</td>
                                <td><input type="text" id="valorrp" name="valorrp" value="<?php echo $_POST[valorrp]?>"  onKeyUp="return tabular(event,this)" style="width:80%;" readonly></td>
                                <td class="saludo1">Saldo:</td>
                                <td><input type="text" id="saldorp" name="saldorp"  value="<?php echo $_POST[saldorp]?>"  onKeyUp="return tabular(event,this)" readonly>
                                </td>
                                <td class="saludo1" >Pagos Vig Anterior:</td>
                                <td><input type="text" id="pvigant" name="pvigant" value="<?php echo $_POST[pvigant]?>" onKeyUp="return tabular(event,this)" onBlur='sumapagosant()' style="width:100%;"></td>
                         	</tr>
      						<tr>
	  							<td class="saludo1" >Valor a Pagar:</td>
                                <td><input class='inputnum' type="text" id="valor" name="valor" value="<?php echo $_POST[valor]?>" style="width:80%;" readonly> </td>
                                <td class="saludo1" >Base:</td>
                                <td><input type="text" id="base" name="base" value="<?php echo $_POST[base]?>" onKeyUp="return tabular(event,this)" onChange='calcularpago()' readonly> </td>
                                <td class="saludo1" >Iva:</td>
                                <td><input type="text" id="iva" name="iva" value="<?php echo $_POST[iva]?>" onKeyUp="return tabular(event,this)" onChange='calcularpago()' onBlur="calcularpago()" style="width:100%;" ><input type="hidden" id="regimen" name="regimen" value="<?php echo $_POST[regimen]?>">
								<input type="hidden" name="reado" id="reado" value="<?php echo $_POST[reado]; ?>"></td>
                          	</tr>
     					</table>
	  				<div class="subpantallac6" style="width:99.6%; height:52%; overflow-x:hidden;">
      					<?php
							$sqldestino = "SELECT * FROM pptorp_almacen WHERE id_rp='$_POST[rp]' AND vigencia='$_POST[vigencia]'";
							$resdestino = mysql_query($sqldestino,$linkbd);
							$rowdestino = mysql_fetch_row($resdestino);
							$_POST[destcompra] = $rowdestino[1];
	  						if($_POST[brp]=='1')
	  						{
		 		 				//$_POST[brp]=0;
	  							//*** busca contenido del rp
								$_POST[dcuentas]=array();
								$_POST[dregalias]=array();
							  	$_POST[dncuentas]=array();
							  	$_POST[dvalores]=array();
							  	$_POST[dvaloresoc]=array();	  
							  	$_POST[drecursos]=array();
							  	$_POST[rubros]=array();	  	  	  
							  	$_POST[dnrecursos]=array();
								$_POST[inicios]=array();
	  							$sqlr="select *from pptorp_detalle where pptorp_detalle.consvigencia=(select pptorp.consvigencia from pptorp where consvigencia=".$_POST[rp]." and pptorp.vigencia=$_POST[vigencia] and pptorp.tipo_mov='201') and pptorp_detalle.vigencia=$_POST[vigencia] and pptorp_detalle.tipo_mov='201' ";
								$res=mysql_query($sqlr,$linkbd);
								while($r=mysql_fetch_row($res))
	 							{
	  								$consec=$r[0];	  
	  								$_POST[dcuentas][]=$r[3];
									if(isset($_POST[sumarauto]) && !empty($_POST[sumarauto])){
										$totsaldo=generaSaldoRPxcuenta($r[2],$r[3],$_POST[vigencia]);
										$saldo=$_POST[sumarauto];
										if($saldo>0 ){
											if($totsaldo>=$_POST[sumarauto]){
												$_POST[dvalores][]=$_POST[sumarauto];
												$saldo=0;
											}else{
												$_POST[dvalores][]=$totsaldo;
												$saldo=$saldo-$totsaldo;
											}
										}else{
											$_POST[dvalores][]=0;
										}
										
									}else{
										$_POST[dvalores][]=generaSaldoRPxcuenta($r[2],$r[3],$_POST[vigencia]);
									}
	  								
 									$_POST[dvaloresoc][]=$r[5];  
	   								$_POST[dncuentas][]=buscacuentapres($r[3],2);	   
	   								$_POST[rubros][]=$r[3];	
									$_POST[inicios][]=$r[3];
	   	 							$nfuente=buscafuenteppto($r[3],$_POST[vigencia]);
			  	 					$cdfuente=substr($nfuente,0,strpos($nfuente,"_"));
					  				$_POST[drecursos][]=$cdfuente;
					  				$_POST[dnrecursos][]=$nfuente;				 
		 						}
								//$_POST[brp]=0;
								//$_POST[ccambio]=0;
	  						}
	  					?>
	   					<table class="inicio">
	   						<tr><td colspan="8" class="titulos">Detalle Orden de Pago</td></tr>                  
      					 	<?php
	   							if($_POST[todos]==1){$checkt='checked';}
								else {$checkt='';}
	   							if($_POST[inicia]==1){$checkint='checked';}
								else {$checkint='';}
							?>
							<tr>
								<td class="titulos2"><input type="checkbox" id="inicia" name="inicia" onClick="checkinicios()" value="<?php echo $_POST[inicia]?>" <?php echo $checkint ?>/></td>
                            	<td class="titulos2">Cuenta</td>
                                <td class="titulos2">Nombre Cuenta</td>
                                <td class="titulos2">Recurso</td>
                                <td class="titulos2">Valor</td>
                                <td class="titulos2"><input type="checkbox" id="todos" name="todos" onClick="checktodos()" value="<?php echo $_POST[todos]?>" <?php echo $checkt ?>/><input type='hidden' name='elimina' id='elimina'  ></td>
								<input type="hidden" name="destcompra" id="destcompra" value="<?php echo $_POST[destcompra] ?>">
                        	</tr>
							<?php
		  						$_POST[totalc]=0;
								$_POST[token]=0;
								$iter='saludo1a';
								$iter2='saludo2';
		 						for ($x=0;$x<count($_POST[dcuentas]);$x++)
		 						{	
									$chs='';
		 							$chk='';
									// echo "a".$_POST[dcuentas][$x];
									$ck=esta_en_array($_POST[inicios],$_POST[dcuentas][$x]);
									$ch=esta_en_array($_POST[rubros],$_POST[dcuentas][$x]);
									if($ch=='1')
			 						{
			 							$chk="checked";
										$_POST[totalc]=$_POST[totalc]+$_POST[dvalores][$x];
																			
					 				}
									if($ck=='1')
									{
			 							$chs="checked";
										$_POST[token]=$_POST[token]+$_POST[dvalores][$x];
																			
									 }
									 $sql1="SELECT regalias FROM pptocuentas WHERE cuenta='".$_POST[dcuentas][$x]."' AND (vigencia='$vigusu'or vigenciaf='$vigusu')";
									$rst1=mysql_query($sql1,$linkbd);
									$ar=mysql_fetch_row($rst1);
								 	echo "
									<input type='hidden' name='dcuentas[]' value='".$_POST[dcuentas][$x]."'/>
									<input type='hidden' name='dregalias[]' value='".$ar[0]."'/>
									<input type='hidden' name='dncuentas[]' value='".$_POST[dncuentas][$x]."'/>
									<input type='hidden' name='drecursos[]' value='".$_POST[drecursos][$x]."'/>
									<input type='hidden' name='dnrecursos[]' value='".$_POST[dnrecursos][$x]."'/>
									<input type='hidden' name='dvalores[]' value='".$_POST[dvalores][$x]."'/>
									<input type='hidden' name='dvaloresoc[]' value='".$_POST[dvaloresoc][$x]."'/>
									<tr  class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
				onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase'>
										<td style='width:3%;'><input type='checkbox' name='inicios[]' value='".$_POST[dcuentas][$x]."' onClick='submit()' $chs></td>
										<td style='width:10%;'>".$_POST[dcuentas][$x]."</td>
										<td style='width:30%;'>".$_POST[dncuentas][$x]."</td>
										<td style='width:40%;'>".$_POST[dnrecursos][$x]."</td>
										<td style='text-align:right;width:10%;' "; if($ch=='1'){echo "onDblClick='llamarventanaegre(this,$x);'";} echo" >$ ".number_format($_POST[dvalores][$x],2,'.',',')."</td>
		 								<td style='width:3%;'><input type='checkbox' name='rubros[]' value='".$_POST[dcuentas][$x]."' onClick='resumar()' $chk></td>
									</tr>";
									$aux=$iter;
								 	$iter=$iter2;
								 	$iter2=$aux;

		 						}
								$resultado = convertir($_POST[totalc]);
								$_POST[letras]=$resultado." PESOS M/CTE";
		 						$_POST[totalcf]=number_format($_POST[totalc],2,".",",");
	    						echo "
								<input type='hidden' name='totalcf' value='$_POST[totalcf]'/>
								<input type='hidden' name='totalc' value='$_POST[totalc]'/>
								<input type='hidden' name='letras' value='$_POST[letras]'/>
								<tr class='$iter' style='text-align:right;'>
									<td colspan='3'>Total:</td>
									<td>$ $_POST[totalcf]</td>
								</tr>
								<tr class='titulos2'>
									<td>Son:</td> 
									<td colspan='5'>$_POST[letras]</td>
								</tr>";
							?>
        					<script>
								document.form2.valor.value=<?php echo round($_POST[totalc],2);?>;
								document.form2.valoregreso.value=<?php echo round($_POST[totalc],2);?>;		
								document.form2.valorcheque.value=document.form2.valor.value-document.form2.valorretencion.value;		
        					</script>
	   					</table>
					</div>
      				<?php
	  					if(!$_POST[oculto]){echo" <script> document.form2.fecha.focus();document.form2.fecha.select();</script>";}
					 	//***** busca tercero
			 			if($_POST[brp]=='1' )
			 			{
			  				$nresul=buscaregistro($_POST[rp],$_POST[vigencia]);
			  				if($nresul!='')
			   				{
			  					$_POST[cdp]=$nresul;
  								echo"<script>document.getElementById('cc').focus(); document.getElementById('cc').select();</script>";
			  				}
			 				else
			 				{
			  					$_POST[cdp]="";
			 					echo"<script>alert('Registro Presupuestal Incorrecto');document.form2.rp.select();</script>";
			  				}
			 			}
			  			if($_POST[bt]=='1')
			 			{
			  				$nresul=buscatercero($_POST[tercero]);
			  				$_POST[regimen]=buscaregimen($_POST[tercero]);	
			  				if($nresul!='')
			   				{
			  					$_POST[ntercero]=$nresul;
			  					if($_POST[regimen]==1){$_POST[iva]=round($_POST[valor]-$_POST[valor]/(1.19),1);}	
					 			else {$_POST[iva]=0;}	
				 				$_POST[base]=$_POST[valor]-$_POST[iva];
  								echo"
								<script>
									document.getElementById('detallegreso').focus();
									document.getElementById('detallegreso').select();
								</script>";
			  				}
			 				else
			 				{
			 		 			$_POST[ntercero]="";
			  					echo"<script>alert('Tercero Incorrecto o no Existe');document.getElementById('tercero').value='';document.form2.tercero.focus();</script>";
			 				}
						}
					?>
	  			</div>
			</div>
			
				<div class="tab">
       			<input type="radio" id="tab-5" name="tabgroup1" value="5" <?php echo $check5;?> >
	   			<label for="tab-5">Pagos Autorizados</label>
	   			<div class="content" >
       				<table class="inicio" >
					<tr >
        					<td class="titulos" colspan="8" >Pagos Autorizados - Puede Seleccionar Parcialmente Los Pagos Autorizados</td>
      				</tr>
					
					<td style="width: 70% !important" valign="top" >
					<table class="inicio" align="center" style="width: 98%; margin: auto !important">
					
      					<tr>
							<td class="titulos2" style="width: 10%"></td>
							<td class="titulos2" style="width: 15%">No. Pago</td>
							<td class="titulos2" style="width: 15%">No. Servicio</td>
                            <td class="titulos2" style="width: 30%">Valor Autorizado</td>
							<td class="titulos2" style="width: 30%">Saldo</td>
                            <td class="titulos2" style="width: 10%"></td>
                     	</tr>
      					<?php
							
	  						if($_POST[selectipo]=='servicio')
			 				{
								
								
	 							$sqlr="SELECT inv_servicio_det.codcompro,inv_servicio_det.valor,inv_servicio_det.numpago,inv_servicio_det.estado FROM inv_servicio,inv_servicio_det WHERE inv_servicio.codcompro=inv_servicio_det.codcompro AND !(inv_servicio.estado='R' OR inv_servicio.estado='P') AND inv_servicio.vigencia='$_POST[vigencia]' AND  inv_servicio.codcompro='$_POST[servicio]' AND inv_servicio_det.liberado='1' ORDER BY inv_servicio_det.numpago ASC";
								//echo $sqlr;
								$co='saludo1';
	  							$co2='saludo2';
	 							$sumaservicio=0;
	  							$res=mysql_query($sqlr,$linkbd);
								$i=1;
								$pos=0;
								while ($row =mysql_fetch_row($res)) 
								{
									$habilita="";
									$check="";
									if(isset($_POST[poscheck][$pos])){
										if($_POST[poscheck][$pos]=='1' || $_POST[poscheck][$pos]==''){
										$check="CHECKED";
										}else{
										$check="";
										}
									}else{
										$check="CHECKED";
									}
									if($row[3]=='P'){
										$habilita="disabled";
										$_POST[bloqueos][$pos]='1';
										$check="";
									}else{
										$_POST[bloqueos][$pos]='0';
									}
	    							echo "<tr class='$co'>";
									echo "<td>$i</td>";
									echo "<td>$row[0] <input type='hidden' name='posicion[]' value='".$row[2]."' />   </td>";
									echo "<td><input name='valauto[]' type='hidden' value='$row[1]' /> $ ".number_format($row[1],2,',','.')."</td>";
									echo "<td><input name='salauto[]' type='hidden' value='0' /> $ ".number_format(0,2,',','.')."<input type='hidden' name='bloqueos[]' value='".$_POST[bloqueos][$pos]."' /> </td>";
									echo "<td><input type='checkbox' name='agrega[]' onChange='sumatotal($pos)' $check $habilita/> <input type='hidden' name='poscheck[]' value='".$_POST[poscheck][$pos]."' /></td>";
									echo "</tr>";
									$aux=$co;
									$co=$co2;
									$co2=$aux;
									$i+=1;
									$pos+=1;
								}
							}
						
							echo "
							<tr class='$co'>
								<td class='saludo1' align='right' colspan='2'>Total Pago:</td>
								<td align='right'><input id='sumarauto' name='sumarauto' type='hidden' value='".$_POST[sumarauto]."' ><input id='sumarauto2' name='sumarauto2' type='text' value=' $ ".number_format($_POST[sumarauto],2,',','.')."' readonly style='text-align:right; width: 100%'></td><td align='right'><input id='saldoauto' name='saldoauto' type='hidden' value='".$_POST[saldoauto]."'><input id='saldoauto2' name='saldoauto2' type='text' value=' $ ".number_format($_POST[saldoauto],2,',','.')."' readonly style='text-align:right;width: 100%'></td>
							</tr>";
	  					?> 
					</table>
					</td>
					<td style="border: 1px dashed gray; border-radius: 8px">
					<center>
					<img src="imagenes/contrato.png" title="Contrato" style="width: 120px; height: 120px" />
					</center;
					</td>
      					     
      				</table>
       			</div>
     		</div> 
			
			
    		<div class="tab">
       			<input type="radio" id="tab-4" name="tabgroup1" value="4" <?php echo $check4;?> >
	   			<label for="tab-4">Pagos Anteriores</label>
	   			<div class="content" >
       				<table class="inicio" align="center" >
      					<tr >
        					<td class="titulos" colspan="8" >Pagos Anteriores - Seleccione para Agregar Valor a la Base de Retencion</td>
      					</tr>
      					<tr>
                        	<td class="titulos2" >No CxP</td>
                            <td class="titulos2" >Fecha</td>
                            <td class="titulos2" >RP</td>
                            <td class="titulos2" >Tercero</td>
                            <td class="titulos2" >Valor</td>
                            <td class="titulos2" ><center>-</center></td>
                     	</tr>
      					<?php
						
	  						if($_POST[brp]=='1' )
			 				{
	 							$sqlr="select id_orden, fecha, id_rp,tercero,base from tesoordenpago where estado<>'N' and vigencia='$vigusu' and id_rp='$_POST[rp]' and tipo_mov='201' ";
	  							
								$co='saludo1';
	  							$co2='saludo2';
	 							$sumabase=0;
	  							$res=mysql_query($sqlr,$linkbd);
	  							$contpcxp=0;
								while ($row =mysql_fetch_row($res)) 
								{
	    							$valoranterior=0;
									$chkpag=''; 
									$sqlr="select sum(valor) from tesoordenpago_bases where id_ordenbase=$row[0]";
									$res2=mysql_query($sqlr,$linkbd);
									$row2 =mysql_fetch_row($res2); 
	    							$valoranterior=$row2[0];
	    							$ch=esta_en_array($_POST[pagos],$row[0]);
									if($ch=='1')
			 						{
			 							$chkpag="checked";
										$sumabase+=$row[4]-$valoranterior;
			 						}
			 						$pago_ant=0;
									$sqlr="select sum(valor) from tesoordenpago_det where id_orden='$row[0]' and tipo_mov='201' ";
									$resd=mysql_query($sqlr,$linkbd);
									while ($rowd =mysql_fetch_row($resd)){$pago_ant=$rowd[0];}
									$nvalor= $pago_ant-$valoranterior;
									echo "
									<tr class='$co'>
										<td><input type='hidden' name='pcxp[]' value=".$row[0]." >$row[0]</td>
										<td><input type='hidden' name='pfecha[]' value=".$row[1]." >$row[1]</td>
										<td><input type='hidden' name='prp[]' value=".$row[2]." >$row[2]</td>
										<td><input type='hidden' name='pter[]' value=".$row[3]." >$row[3] - ".buscatercero($row[3])."</td>
										<td align='right'><input type='text' name='pvalores[]' value=".$nvalor." onKeyPress='javascript:return solonumeros(event)' onBlur='sumapagosant()' style='text-align:right'></td>
										<td>
											<center>
												<input type='checkbox' name='pagos[]' name='pagos[]' value='".$row[0]."' $chkpag onClick='sumapagosant()' >
											</center>
										</td>
									</tr>";	
									$aux=$co;
									$co=$co2;
									$co2=$aux;
									$contpcxp+=1;
								}
							}
							else
		 					{
		  						$co='saludo1';
	  							$co2='saludo2';
	   							$sumabase=0;
								for ($x=0;$x<count($_POST[pvalores]);$x++)
		 						{	
		 							$valoranterior=0;
		 							$chkpag='';
			 						$ch=esta_en_array($_POST[pagos],$_POST[pcxp][$x]);
									if($ch=='1')
			 						{
			 							$chkpag="checked";
			 							$sumabase+=$_POST[pvalores][$x]-$valoranterior;
			 						}

									$nvalor= $_POST[pvalores][$x]-$valoranterior;			
									echo "
									<tr class='$co'>
										<td><input type='hidden' name='pcxp[]' value=".$_POST[pcxp][$x]." >".$_POST[pcxp][$x]."</td>
										<td><input type='hidden' name='pfecha[]' value=".$_POST[pfecha][$x]." >".$_POST[pfecha][$x]."</td>
										<td><input type='hidden' name='prp[]' value=".$_POST[prp][$x]." >".$_POST[prp][$x]."</td>
										<td><input type='hidden' name='pter[]' value=".$_POST[pter][$x]." >".$_POST[pter][$x]." - ".buscatercero($_POST[pter][$x])."</td>
										<td align='right'><input type='text' name='pvalores[]' value=".$_POST[pvalores][$x]." onKeyPress='javascript:return solonumeros(event)' onBlur='sumapagosant()' style='text-align:right'></td>
										<td><center><input type='checkbox' name='pagos[]' name='pagos[]' value='".$_POST[pcxp][$x]."' $chkpag onClick='sumapagosant()' ></center></td>
									</tr>";	
									$aux=$co;
									$co=$co2;
									$co2=$aux;
		  						}
		 					}
							echo "
							<tr class='$co'>
								<td class='saludo1' align='right' colspan='4'>Suma Base:</td>
								<td align='right'><input id='sumarbase' name='sumarbase' type='hidden' value='$sumabase' readonly style='text-align:right'><input id='sumarbase2' name='sumarbase2' type='text' value='".number_format($sumabase,2)."' readonly style='text-align:right'></td>
							</tr>";
	  					?>      
      				</table>
       			</div>
     		</div>  
			<div class="tab">
       			<input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?> >
       			<label for="tab-2">Retenciones</label>
       			<div class="content" style="overflow-x:hidden;"> 
				   <?php
				   if ($_POST[manual]=="0") 
				   {
					   $coloracti="#C00";
				   }
				   else
				   {
					   $coloracti="#0F0";
				   }
				   ?>
	   				<table class="inicio" align="center" >
      					<tr >
        					<td class="titulos" colspan="10">Retenciones</td>
                            <td class="cerrar" style="width:7%;"><a href="teso-principal.php">&nbsp;Cerrar</a></td>
     	 				</tr>
						<tr>
                        	<td class="saludo1" style="width:12%;">Retencion y Descuento:</td>
							<td>
								<select name="retencion"  onChange="validar()" onKeyUp="return tabular(event,this)">
									<option value="">Seleccione ...</option>
									<?php
										$sqlr="select *from tesoretenciones where estado='S'";
										$res=mysql_query($sqlr,$linkbd);
										while ($row =mysql_fetch_row($res)) 
				    					{
					 						if("$row[0]"==$_POST[retencion])
			 								{
						 						echo "<option value='$row[0]' SELECTED>$row[1] - $row[2]</option>";
						  						$_POST[porcentaje]=$row[5];
						  						$_POST[nretencion]=$row[1]." - ".$row[2];
						  						if($_POST[porcentaje]>0)
						   						{
													if($_POST[manual]!="0")
													{
														if($row[7]!='1'){$_POST[vporcentaje]=round(($_POST[base]*$_POST[porcentaje])/100);}
														else {$_POST[vporcentaje]=round(($_POST[iva]*$_POST[porcentaje])/100); }
														$ro='readonly';
													}
						  						}
												else
												{
													$ro='';
						  							if($_POST[vporcentaje]==0){$ro='';}
							 						else {$ro='readonly';}
						     					} 
						 					}
					 						else {echo "<option value='$row[0]'>$row[1] - $row[2]</option>";} 	 
										}	 	
									?>
   								</select>
                                <input type="hidden" value="<?php echo $_POST[nretencion]?>" name="nretencion">
							</td>
                            <td style="width:8%;" class="saludo1">Automatico:</td>
							<td style="width:10%;">
								<input type="hidden" id="contador" name="contador"  value="<?php echo $_POST[contador]; ?>" >
								
								<input type="hidden" id="oculto12" name="oculto12"  value="<?php echo $_POST[oculto12]; ?>">
								<input type="hidden" name="estado"  value="<?php echo $_POST[estado]; ?>" >
								<?php 
								$valuees="ACTIVO";
								$stylest="width:100%; background-color:#0CD02A ;color:#fff; text-align:center;";	
								echo "<input type='hidden' name='estado' id='estado' value='$valuees' style='$stylest' readonly />";		
								?>
								<input type='range' name='manual' id="manual" value='<?php echo $_POST[manual]?>' min ='0' max='1' step ='1' style='background: <?php echo $coloracti; ?>; width:100%;position: relative;float: left;' onChange='validar()'/></td>
							</td>
                            <td style="width:6%;"><input id="porcentaje" name="porcentaje" type="text" size="5" value="<?php echo $_POST[porcentaje]?>" readonly>%</td>

							<td class="saludo1" style="width:4%;">Valor:</td>
							<td>
								<input class='inputnum' id="vporcentaje" name="vporcentaje" type="text" size="10" value="<?php echo $_POST[vporcentaje]?>" <?php echo $ro; ?>>
							</td>
                            <td class="saludo1" style="width:8%;">Total Descuentos:</td>
                            <td style="width:15%;">
                            	<input class='inputnum' id="totaldes" name="totaldes" type="text" size="10" value="<?php echo $_POST[totaldes]?>" readonly>
        						<input type="button" name="agregard" id="agregard" value="   Agregar   " onClick="agregardetalled()" ><input type="hidden" value="0" name="agregadetdes">
                         	</td>
						</tr>
        				<?php 	
							$_POST[valoregreso]=$_POST[valor];
							$_POST[valorretencion]=$_POST[totaldes];
							$_POST[valorcheque]=$_POST[valoregreso]-$_POST[valorretencion];
							if ($_POST[eliminad]!='')
		 					{ 
		 						$posi=$_POST[eliminad];
		 						unset($_POST[ddescuentos][$posi]);
		 						unset($_POST[dndescuentos][$posi]);
		 						unset($_POST[dporcentajes][$posi]);
		 						unset($_POST[ddesvalores][$posi]);
		 						unset($_POST[dmanual][$posi]);
		 						$_POST[ddescuentos]= array_values($_POST[ddescuentos]); 
		 						$_POST[dndescuentos]= array_values($_POST[dndescuentos]); 
		 						$_POST[dporcentajes]= array_values($_POST[dporcentajes]); 
		 						$_POST[ddesvalores]= array_values($_POST[ddesvalores]); 		 
		 						$_POST[dmanual]= array_values($_POST[dmanual]); 		 
		 					}	 
		 					if ($_POST[agregadetdes]=='1')
		 					{
		 						$_POST[ddescuentos][]=$_POST[retencion];
								$_POST[dndescuentos][]=$_POST[nretencion];
								$_POST[dporcentajes][]=$_POST[porcentaje];
		 						$_POST[ddesvalores][]=$_POST[vporcentaje];
		 						$_POST[dmanual][]=$_POST[manual];
		 						$_POST[agregadetdes]='0';
		 						echo"
		 						<script>
         							document.form2.porcentaje.value=0;
        							document.form2.vporcentaje.value=0;	
									document.form2.retencion.value='';	
        						</script>";
		 					}
		  				?>
       				</table>
         			<table class="inicio" style="overflow:scroll">
        				<tr>
                        	<td class="titulos">Descuento</td>
                            <td class="titulos">%</td>
                            <td class="titulos">Valor</td>
                            <td class="titulos2"><img src="imagenes/del.png" ><input type='hidden' name='eliminad' id='eliminad'></td>
                     	</tr>
      					<?php
							$totaldes=0;
							for ($x=0;$x<count($_POST[ddescuentos]);$x++)
		 					{		 		 
		 						echo "
								<input type='hidden' name='dndescuentos[]' value='".$_POST[dndescuentos][$x]."'>
								<input type='hidden' name='ddescuentos[]' value='".$_POST[ddescuentos][$x]."' >
								<input type='hidden' name='dporcentajes[]' value='".$_POST[dporcentajes][$x]."'>
								<input type='hidden' name='ddesvalores[]' value='".($_POST[ddesvalores][$x])."'>
								<input type='hidden' name='dmanual[]' value='".($_POST[dmanual][$x])."'>
								<tr>
									<td class='saludo2'>".$_POST[dndescuentos][$x]."</td>
		 							<td class='saludo2'>".$_POST[dporcentajes][$x]."</td>
		 							<td class='saludo2'>".($_POST[ddesvalores][$x])."</td>
									<td class='saludo2'><a href='#' onclick='eliminard($x)'><img src='imagenes/del.png'></a></td>
								</tr>";
		 						$totaldes=$totaldes+($_POST[ddesvalores][$x])	;
		 					}		 
							$_POST[valorretencion]=$totaldes;
							echo"
        					<script>
        						document.form2.totaldes.value='$totaldes';		
      							document.form2.valorretencion.value='$totaldes';
        					</script>";
							$_POST[valorcheque]=$_POST[valoregreso]-$_POST[valorretencion];
						?>
        			</table>
	   			</div>
   			</div>
			<div class="tab">
       			<input type="radio" id="tab-3" name="tabgroup1" value="3" <?php echo $check3;?>>
       			<label for="tab-3">Cuenta por Pagar</label>
       			<div class="content" style="overflow-x:hidden;"> 
	   				<table class="inicio" align="center" >
	   					<tr>
                        	<td colspan="6" class="titulos">Cheque</td>
                        	<td class="cerrar"><a href="teso-principal.php">&nbsp;Cerrar</a></td>
                        </tr>
						<tr colspan="3">
	  						<td class="saludo1" style="width:10%;">Cuenta Contable:</td>
	  						<td>
	    						<input name="cuentapagar" type="text" value="<?php echo $_POST[cuentapagar]?>"  readonly> 
								<input name="cb" type="hidden" value="<?php echo $_POST[cb]?>" ><input type="hidden" id="ter" name="ter" value="<?php echo $_POST[ter]?>" >
                         	</td>
							<td class="saludo1" style="width:10%;">Valor Retenciones:</td>
                            <td><input type="text" id="valorretencion" name="valorretencion"  value="<?php echo $_POST[valorretencion]?>" onKeyUp="return tabular(event,this)" readonly></td>
	  					</tr> 
	  					<tr>
	  						<td class="saludo1">Valor Orden de Pago:</td>
                            <td><input type="text" id="valoregreso" name="valoregreso" value="<?php echo $_POST[valoregreso]?>"  onKeyUp="return tabular(event,this)" readonly></td>
                            
                            <td class="saludo1">Valor Cta Pagar:</td>
                            <td><input class='inputnum' type="text" id="valorcheque" name="valorcheque" value="<?php echo $_POST[valorcheque]?>" size="20" onKeyUp="return tabular(event,this)" readonly></td>
                     	</tr>	
      				</table>
	   			</div>
	 		</div>
			<?php
				$_POST[sinConta]=array();
				$nametab='';
				for($x=0;$x<count($_POST[dcuentas]);$x++)
				{
					$sq = "SELECT regalias FROM pptocuentas WHERE cuenta='".$_POST[dcuentas][$x]."'"; 
					$r = mysql_query($sq, $linkbd);
					$row = mysql_fetch_row($r);
					if($row[0]=='S')
					{
						$sqlr="SELECT codconcecausa FROM pptocuentas WHERE cuenta='".$_POST[dcuentas][$x]."' and (vigencia='$_POST[vigencia]' or vigenciaf='$_POST[vigencia]')";
					}
					else
					{
						$sqlr="SELECT codconcecausa FROM pptocuentas WHERE cuenta='".$_POST[dcuentas][$x]."' and vigencia='$_POST[vigencia]'";
					}
					$res=mysql_query($sqlr,$linkbd);
					$row=mysql_fetch_row($res);
					if($row[0]=='' || $row[0]=='-1')
					{
						$_POST[sinConta][]=$_POST[dcuentas][$x];
						$nametab="tabgroup1";
					}
				}
					if(count($_POST[sinConta])!='0')
					{
					?>
						<div class="tab">
							<input type="radio" id="tab-6" name="tabgroup1" value="6" <?php echo $check6;?>>
							<label for="tab-6" style="background-color: #D93C31; color: white;">Sin Contabilidad</label>
							<div class="content" style="overflow-x:hidden;"> 
								<table class="inicio">
									<tr><td colspan="8" class="titulos">Parametrizar Progranacion Contable</td></tr>                  
									
									<tr>
										<td class="titulos2">Cuenta</td>
										<td class="titulos2">Nombre Cuenta</td>
										<td class="titulos2">Valor</td>
										<td class="titulos2">Ir a Parametrizar</td>
									</tr>
									<?php
										$iter='saludo1a';
										$iter2='saludo2';
										for ($x=0;$x<count($_POST[sinConta]);$x++)
										{
											echo "
											<tr  class='$iter' style=\"cursor: hand\" ondblclick=\"direccionaCuentaGastos('".$_POST[sinConta][$x]."')\"  onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
						onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase'>
												<td style='width:10%;'>".$_POST[sinConta][$x]."</td>
												<td style='width:50%;'>".$_POST[dncuentas][$x]."</td>
												<td style='text-align:right;width:10%;' "; echo" >$ ".number_format($_POST[dvalores][$x],2,'.',',')."</td>
												<td style='width:5%;'><center><img src=\"imagenes/crear_cuenta.png\" style=\"width:20px;\" onClick=\"direccionaCuentaGastos('".$_POST[sinConta][$x]."')\" /></center></td>
												</tr>";
											$aux=$iter;
											$iter=$iter2;
											$iter2=$aux;
										}
									?>
									<tr class='titulos2'>
											<td><h2 style="padding-top:10px;">Nota:</h2></td> 
											<td colspan='5'><h2 style="padding-top:10px; color: #F3463A;">Consulte con el Contador de la entidad, o parametrice con un click.</h2></td>
									</tr>
								</table>
							</div>
						</div>
						<?php
					}
				
			?>
		</div>
		<?php
			}
			else
			{
		?>
		<table class="inicio">
			<tr>
				<td class="titulos" colspan="6">.: Documento a Reversar</td>
			</tr>
			<tr>
				<td class="saludo1" style="width:10%;">N&uacute;mero CxP:</td>
				<td style="width:13%;">
					<input type="hidden" name="cxpo" id="cxpo" value="<?php echo $_POST[cxpo]?>" readonly>
					<input type="text" name="cxp" id="cxp" value="<?php echo $_POST[cxp]; ?>" style="width:80%;" onKeyUp="return tabular(event,this)" onBlur="validar2()" readonly>
					<a href="#" onClick="despliegamodal2('visible','3','<?php echo $_POST[vigencia]?>');" title="Buscar CxP"><img src="imagenes/find02.png" style="width:20px;"></a>
				</td>
				<td class="saludo1" style="width:10%;">Fecha:</td>
				<td style="width:10%;">
					<input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" style="width:80%;" title="DD/MM/YYYY"/>&nbsp;<a href="#" onClick="displayCalendarFor('fc_1198971545');" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px;"/></a>
				</td>
				<td class="saludo1" style="width:10%;">Descripcion: </td>
				<td style="width:60%;" colspan="3">
					<input type="text" name="descripcion" id="descripcion" value="<?php echo $_POST[descripcion]?>" style="width:100%;">
				</td>
			</tr>	
			<tr>
				<td class="saludo1">Tipo de entrada</td>
				<td>
				<?php
					if(isset($_POST[cxp])){
						if(!empty($_POST[cxp])){
							$sql="SELECT 1 FROM inv_servicio_cxp WHERE cxp='$_POST[cxp]' ";
							$res=mysql_query($sql,$linkbd);
							$num=mysql_num_rows($res);
							if($num==0){
								$_POST[selectipo]="rp";
								echo "<script>document.getElementById('selectipo').value='rp'; </script>";
							}else{
								$_POST[selectipo]="servicio";
								echo "<script>document.getElementById('selectipo').value='servicio'; </script>";
							}
						}
					}
				?>
				<select name="selectipo"  onChange="refrescar()" onKeyUp="return tabular(event,this)" style="width:94%;">
					<option value="rp" <?php if($_POST[selectipo]=="rp"){echo "SELECTED"; } ?> >Registro Presupuestal</option>
					<option value="servicio" <?php if($_POST[selectipo]=="servicio"){echo "SELECTED"; } ?>>Entrada de Servicio</option>
				</select>
				</td>
				<td class="saludo1">No. RP: </td>
				<td><input type="text" name="rp" id="rp" value="<?php echo $_POST[rp];?>" readonly></td>
				<td class="saludo1">Valor CxP: </td>
				<td><input type="text" name="valorcxp" id="valorcxp" value="<?php echo $_POST[valorcxp];?>" readonly></td>
			</tr>
		</table> 
		<div class="subpantallac6" style="width:99.6%; height:52%; overflow-x:hidden;">
			<?php
				if($_POST[cxp]!='')
				{
					if($_POST[tipomovimiento]=='201'){

						$_POST[dcuentas]=array();
						$_POST[dncuentas]=array();
						$_POST[dvalores]=array();
						$_POST[dvaloresoc]=array();	  
						$_POST[drecursos]=array();
						$_POST[rubros]=array();	  	  	  
						$_POST[dnrecursos]=array();	  	  
						$sqlr="select *from pptorp_detalle where pptorp_detalle.consvigencia=$_POST[rp] and pptorp_detalle.vigencia=$_POST[vigencia] where tipo_mov='201' ";
						
						$res=mysql_query($sqlr,$linkbd);
						while($r=mysql_fetch_row($res))
						{
							$consec=$r[0];	  
							$_POST[dcuentas][]=$r[3];
						    $_POST[dvalores][]=generaSaldoRPxcuenta($r[2],$r[3],$_POST[vigencia]);		
							$_POST[dvaloresoc][]=generaSaldoRPxcuenta($r[2],$r[3],$_POST[vigencia]);	  
							$_POST[dncuentas][]=buscacuentapres($r[3],2);	   
							$_POST[rubros][]=$r[3];	   
							$nfuente=buscafuenteppto($r[3],$_POST[vigencia]);
							$cdfuente=substr($nfuente,0,strpos($nfuente,"_"));
							$_POST[drecursos][]=$cdfuente;
							$_POST[dnrecursos][]=$nfuente;				 
						}
					}else if($_POST[tipomovimiento]=='401'){
						//$_POST[brp]=0;
						//*** busca contenido del rp
						$_POST[dcuentas]=array();
						$_POST[dncuentas]=array();
						$_POST[dvalores]=array();
						$_POST[dvaloresoc]=array();	  
						$_POST[drecursos]=array();
						$_POST[rubros]=array();	  	  	  
						$_POST[dnrecursos]=array();	  	  
						$sqlr="select * from tesoordenpago_det where id_orden=$_POST[cxp] and tipo_mov='201' ";
						// echo $sqlr;
						$res=mysql_query($sqlr,$linkbd);
						while($r=mysql_fetch_row($res))
						{
							$consec=$r[1];	  
							$_POST[dcuentas][]=$r[2];
							$_POST[dvalores][]=$r[4];
							$_POST[dvaloresoc][]=$r[4];	  
							$_POST[dncuentas][]=buscacuentapres($r[2],2);	   
							$_POST[rubros][]=$r[2];	   
							$nfuente=buscafuenteppto($r[2],$_POST[vigencia]);
							$cdfuente=substr($nfuente,0,strpos($nfuente,"_"));
							$_POST[drecursos][]=$cdfuente;
							$_POST[dnrecursos][]=$nfuente;
						}
					}
				}
				$sqlrT = "SELECT cc, tercero FROM tesoordenpago WHERE id_orden=$_POST[cxp] AND tipo_mov='201'";
				$resT=mysql_query($sqlrT,$linkbd);
				$rowT = mysql_fetch_row($resT);
				$_POST[ccR] = $rowT[0];
				$_POST[terceroR] = $rowT[1];
			?>
			<table class="inicio">
				<tr><td colspan="8" class="titulos">Detalle Orden de Pago</td></tr>                  
				<?php
					if($_POST[todos]==1){$checkt='checked';}
					else {$checkt='';}
					if($_POST[inicios]==1){$checkint='checked';}
					else {$checkint='';}
					?>
				<tr>
					<td class="titulos2">Cuenta</td>
					<td class="titulos2">Nombre Cuenta</td>
					<td class="titulos2">Recurso</td>
					<td class="titulos2">Valor</td>
				</tr>
				<?php
					$_POST[totalc]=0;
					$iter='saludo1a';
					$iter2='saludo2';
					for ($x=0;$x<count($_POST[dcuentas]);$x++)
					{		
						$chk=''; 
						// echo "a".$_POST[dcuentas][$x];
						$ch=esta_en_array($_POST[rubros],$_POST[dcuentas][$x]);
						if($ch=='1')
						{
							$chk=" checked";
							$_POST[totalc]=$_POST[totalc]+$_POST[dvalores][$x];	
						}
						
						echo "
						<input type='hidden' name='dcuentas[]' value='".$_POST[dcuentas][$x]."'/>
						<input type='hidden' name='dncuentas[]' value='".$_POST[dncuentas][$x]."'/>
						<input type='hidden' name='drecursos[]' value='".$_POST[drecursos][$x]."'/>
						<input type='hidden' name='dnrecursos[]' value='".$_POST[dnrecursos][$x]."'/>
						<input type='hidden' name='dvalores[]' value='".$_POST[dvalores][$x]."'/>
						<input type='hidden' name='dvaloresoc[]' value='".$_POST[dvaloresoc][$x]."'/>
						<tr  class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
	onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase'>
							<td style='width:10%;'>".$_POST[dcuentas][$x]."</td>
							<td style='width:30%;'>".$_POST[dncuentas][$x]."</td>
							<td style='width:40%;'>".$_POST[dnrecursos][$x]."</td>
							<td style='text-align:right;width:10%;' "; if($ch=='1'){echo "onDblClick='llamarventanaegre(this,$x);'";} echo" >$ ".number_format($_POST[dvalores][$x],2,'.',',')."</td>
						</tr>";
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
					}
					$resultado = convertir($_POST[totalc]);
					$_POST[letras]=$resultado." PESOS M/CTE";
					$_POST[totalcf]=number_format($_POST[totalc],2,".",",");
					echo "
					<input type='hidden' name='totalcf' value='$_POST[totalcf]'/>
					<input type='hidden' name='totalc' value='$_POST[totalc]'/>
					<input type='hidden' name='letras' value='$_POST[letras]'/>
					<input type='hidden' name='ccR' value='$_POST[ccR]'/>
					<input type='hidden' name='terceroR' value='$_POST[terceroR]'/>
					<tr class='$iter' style='text-align:right;'>
						<td colspan='3'>Total:</td>
						<td>$ $_POST[totalcf]</td>
					</tr>
					<tr class='titulos2'>
						<td>Son:</td> 
						<td colspan='5'>$_POST[letras]</td>
					</tr>";
				?>
				<script>
					document.form2.valor.value=<?php echo $_POST[totalc];?>;
					document.form2.valoregreso.value=<?php echo $_POST[totalc];?>;		
					document.form2.valorcheque.value=document.form2.valor.value-document.form2.valorretencion.value;		
				</script>
			</table>
		</div>
		<?php 
			}
		?>
 		<?php
		//echo count($_POST[dcuentas]);
			if($_POST[oculto]=='2')
			{
	 			ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
				$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
				$vigenciaReversion = $fecha[3];
				$bloq=bloqueos($_SESSION[cedulausu],$fechaf);
				$query="SELECT conta_pago FROM tesoparametros";
				$resultado=mysql_query($query,$linkbd);
				$arreglo=mysql_fetch_row($resultado);
				$opcion=$arreglo[0];
				$vigencia=$_POST[vigencia];
				if($bloq>=1)
				{
	 				if($_POST[tipomovimiento]=='201'){
						
						$sqlr="select count(*) from tesoordenpago where id_orden=$_POST[idcomp] and tipo_mov='201' ";
						$res=mysql_query($sqlr,$linkbd);
						while($r=mysql_fetch_row($res)){$numerorecaudos=$r[0];}
						if($numerorecaudos==0)
						{ 
							//***********ACTUALIZAR PAGOS ENTRADA SERVICIO
							
							//************CREACION DEL COMPROBANTE CONTABLE ************************
							//***busca el consecutivo del comprobante contable
							$consec=0;
							$sqlr6="select max(id_orden) from  tesoordenpago ";
							$res1=mysql_query($sqlr6,$linkbd);
							while($r=mysql_fetch_row($res1)){$consec=$r[0]; }
							$consec+=1;
									if($_POST[selectipo]=='servicio'){
									$aumenta=0;
									$pagos="";
									for($i=0;$i<count($_POST[posicion]);$i++ ){
										if(isset($_POST[poscheck][$i])){
											if(($_POST[poscheck][$i]=='' || $_POST[poscheck][$i]=='1') && $_POST[bloqueos][$i]!='1'){
												$sql="UPDATE inv_servicio_det SET estado='P' WHERE codcompro='$_POST[servicio]' AND numpago='".$_POST[posicion][$i]."' ";
												mysql_query($sql,$linkbd);
												$aumenta++;
												$pagos.=($_POST[posicion][$i].",");
											}
											
											}
									}
									$pagos=substr($pagos,0,-1);
									$sql="UPDATE inv_servicio SET numpagosok=numpagosok+$aumenta WHERE codcompro='$_POST[servicio]' ";
									mysql_query($sql,$linkbd);
									$sql="INSERT INTO inv_servicio_cxp(codcompro,cxp,pagos,total) VALUES ('$_POST[servicio]','$consec','$pagos','$_POST[sumarauto]')";
									mysql_query($sql,$linkbd);
								
									$sql="SELECT numpagosauto,numpagosok FROM inv_servicio WHERE codcompro='$_POST[servicio]'";
									$res=mysql_query($sql,$linkbd);
									$fila=mysql_fetch_row($res);
									if($fila[0] == $fila[1]){
										$sql="UPDATE inv_servicio SET estado='P'  WHERE codcompro='$_POST[servicio]'";
										mysql_query($sql,$linkbd);
										}	
									}
									$arreglocuenta=Array();
									for($j=0;$j<count($_POST[dcuentas]); $j++)
									{
										if($opcion=="1")
										{
											$valneto=0;
											if($_POST[valor]>0)
											{
												for($x=0;$x<count($_POST[dndescuentos]);$x++)
												{	
													$dd=$_POST[ddescuentos][$x];
	
													$sqlr="select * from tesoretenciones_det,tesoretenciones where tesoretenciones_det.codigo=tesoretenciones.id and tesoretenciones.id='".$dd."'";
													//echo $sqlr."<br>";
													$resdes=mysql_query($sqlr,$linkbd);
													$valordes=0;
													while($rowdes=mysql_fetch_assoc($resdes))
													{		
														$codigoRetencion=0;
														$rest=0;
														$val2=0;
														$codigoCausa=0;
														if ($_POST[medioDePago]!='1' && ($rowdes['terceros']!='1' || $rowdes['tipo']=='C'))
														{
															$codigoRetencion = $rowdes['conceptosgr'];
															$codigoCausa = $rowdes['conceptocausa'];
															if($codigoCausa == '-1' )
															{
																if($codigoRetencion == "-1")
																{
																	$rest=substr($rowdes['tipoconce'],-2);
																	$codigoRetencion = $rowdes['conceptoingreso'];
																	$val2=$rowdes['porcentaje'];
																	//echo "$rest - $val2 <br>";
																}
																else
																{
																	$rest='SR';
																	$codigoRetencion = $rowdes['conceptosgr'];
																	$val2=$rowdes['porcentaje'];
																}
															}
															elseif($rowdes['tipo'] == 'S')
															{
																$codigoRetencion = $rowdes['conceptoingreso'];
																$rest=substr($rowdes['tipoconce'],-2);
																$val2=$rowdes['porcentaje'];
															}
															else
															{
																continue;
															}
														}
														else
														{
															$codigoIngreso = $rowdes['conceptoingreso'];
															if($codigoIngreso != "-1")
															{
																$codigoRetencion = $rowdes['conceptoingreso'];
																$rest=substr($rowdes['tipoconce'],-2);
																$val2=$rowdes['porcentaje'];
															}
														}
														$valordes=0;
														if($_POST[iva]>0 && $rowdes['terceros']==1)
														{
															$val1=$_POST[dvalores][$j];
															$val3=$_POST[ddesvalores][$x];
															$valordes=round(($val1/$_POST[valor])*($val2/100)*$val3,0);
														}
														else
														{
															$val1=$_POST[dvalores][$j];
															$val3=$_POST[ddesvalores][$x];
															$valordes=round(($val1/$_POST[valor])*($val2/100)*$val3,0);
														}
														$arreglocuenta[$_POST[dcuentas][$j]]+=$valordes;
														$nomDescuento=$_POST[dndescuentos][$x];
														$cc=$_POST[cc];
														$tercero=$_POST[tercero];
														//concepto contable //********************************************* */
														$sq="select fechainicial from conceptoscontables_det where codigo='$codigoRetencion' and modulo='".$rowdes['modulo']."' and tipo='$rest' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
														$re=mysql_query($sq,$linkbd);
														while($ro=mysql_fetch_assoc($re))
														{
															$_POST[fechacausa]=$ro["fechainicial"];
														}
														$sqlr="select * from conceptoscontables_det where codigo='$codigoRetencion' and modulo='".$rowdes['modulo']."' and cc='$cc' and tipo='$rest' and fechainicial='".$_POST[fechacausa]."'";
														$rst=mysql_query($sqlr,$linkbd);
														$row1=mysql_fetch_assoc($rst);
														//TERMINA BUSQUEDA CUENTA CONTABLE////////////////////////
														if($row1['cuenta']!='' && $valordes>0)
														{
															$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito, valcredito, estado, vigencia) values ('11 $consec','".$row1['cuenta']."','".$tercero."' ,'".$cc."' , 'Descuento ".$nomDescuento."','',0,".$valordes.",'1' ,'".$vigencia."')";
															$valneto+=$valordes;
															mysql_query($sqlr,$linkbd);
														}
														if($rowdes['conceptocausa']!='-1' && $_POST[medioDePago]=='1')
														{
															//concepto contable //********************************************* */
															$rest=substr($rowdes['tipoconce'],0,2);
															$sq="select fechainicial from conceptoscontables_det where codigo='".$rowdes['conceptocausa']."' and modulo='".$rowdes['modulo']."' and tipo='$rest' and fechainicial<'$fechaf' and cuenta!='' order by fechainicial asc";
															
															$re=mysql_query($sq,$linkbd);
															while($ro=mysql_fetch_assoc($re))
															{
																$_POST[fechacausa]=$ro["fechainicial"];
															}
															$sqlr="select * from conceptoscontables_det where codigo='".$rowdes['conceptocausa']."' and modulo='".$rowdes['modulo']."' and cc='$cc' and tipo='$rest' and fechainicial='".$_POST[fechacausa]."'";
															$rst=mysql_query($sqlr,$linkbd);
															$row1=mysql_fetch_assoc($rst);
															//cuenta puente
															if($row1['cuenta']!='' && $valordes>0)
															{
																$sqlr3="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito, valcredito, estado, vigencia) values ('11 $consec','".$row1['cuenta']."','".$tercero."' ,'".$cc."' , 'Descuento ".$nomDescuento."','',".$valordes.",0,'1' ,'".$vigencia."')";
																mysql_query($sqlr3,$linkbd);
																$sqlr4="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle, cheque,valdebito, valcredito, estado, vigencia) values ('11 $consec','".$row1['cuenta']."','".$tercero."' ,'".$cc."' , 'Descuento ".$nomDescuento."','',0,".$valordes.",'1' ,'".$vigencia."')";
																mysql_query($sqlr4,$linkbd);
																$sq="SELECT cuentapres FROM tesoretenciones_det_presu WHERE id_retencion='".$rowdes['id']."'"; 
																$rs=mysql_query($sq,$linkbd);
																while($rw1=mysql_fetch_row($rs))
																{
																	$ideg=$_POST[idcomp];
																	//*** afectacion pptal DESCUENTOS
																	if($rw1[0]!='')
																	{
																		$sql="insert into pptoretencionpago(cuenta,idrecibo,valor,vigencia,tipo) values ('".$rw1[0]."',$consec,$valordes,'$vigusu','orden')";
																		mysql_query($sql,$linkbd); 	
																	}
																}
																
															}
															
														}
													}
												}
											}
										}						
									}
	
							
							if($_POST[causacion]=='2')
							{
								$_POST[detallegreso]="ESTE DOCUMENTO NO REQUIERE CAUSACION CONTABLE - ".$_POST[detallegreso];
							}
							//***cabecera comprobante CXP LIQUIDADA
							$sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia, estado) values ($consec,11,'$fechaf','$_POST[detallegreso]',0,$_POST[totalc],$_POST[totalc],0,'1')";
							mysql_query($sqlr,$linkbd);
							$idcomp=mysql_insert_id();
							$_POST[idcomp]=$idcomp;
							echo "<input type='hidden' name='ncomp' value='$idcomp'>";

							
							if($_POST[causacion]!='2')
							{
								//******************* DETALLE DEL COMPROBANTE CONTABLE  *********************
								for ($y=0;$y<count($_POST[rubros]);$y++)
								{	
									for($x=0;$x<count($_POST[dcuentas]);$x++)
									{
										if($_POST[dcuentas][$x]==$_POST[rubros][$y])
										{
											//***BUSCAR CUENTA PPTAL ***************
											if($_POST[dregalias][$x]=='S')
											{$numvigencia="(vigencia='$_POST[vigencia]' OR vigencia='".($_POST[vigencia] - 1)."')";}
											else {$numvigencia="vigencia='$_POST[vigencia]'";}
											$sqlr="select codconcepago,codconcecausa,nomina from pptocuentas where cuenta='".$_POST[dcuentas][$x]."' and $numvigencia";
											$resp=mysql_query($sqlr,$linkbd);
											//******ACTUALIZACION DE CUENTA PPTAL CUENTAS X PAGAR ************			
											while($row=mysql_fetch_row($resp))
											{
												$concepto=$row[0];
												$concepto2=$row[1];
												$cuentas=concepto_cuentas($concepto,'P',3,$_POST[cc],$fechaf);   
												$tam=count($cuentas);
												for($cta=0;$cta<$tam;$cta++)
												{   
													$ctacon=$cuentas[$cta][0];
													if ($cuentas[$cta][1]=='N' && $cuentas[$cta][2]=='S')
													{
														$ncuent=buscacuenta($ctacon);								  
														if ($_POST[dvalores][$x]>0 && $ncuent!='')
														{
															if($arreglocuenta[$_POST[dcuentas][$x]]>0)
															{
																$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito, valcredito,estado,vigencia) values ('11 $consec','$ctacon','$_POST[tercero]','$_POST[cc]','Causacion ".$_POST[dncuentas][$x]."','','".$arreglocuenta[$_POST[dcuentas][$x]]."','0','1', '$_POST[vigencia]')";
																mysql_query($sqlr,$linkbd);
															}
															$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('11 $consec','".$ctacon."','".$_POST[tercero]."','".$_POST[cc]."','Causacion ".$_POST[dncuentas][$x]."','',0,'".$_POST[dvalores][$x]."','1','".$vigusu."')";
															mysql_query($sqlr,$linkbd);
														}
													}		
													if ($cuentas[$cta][1]=='N' && $cuentas[$cta][3]=='S')
													{
														$ncuent=buscacuenta($ctacon);

														if ($_POST[dvalores][$x]>0 && $ncuent!='')
														{					
															$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('11 $consec','".$ctacon."','".$_POST[tercero]."','".$_POST[cc]."','Causacion ".$_POST[dncuentas][$x]."','',".$_POST[dvalores][$x].",0,'1','".$vigusu."')";
															mysql_query($sqlr,$linkbd);
														}
													}
													
												}
												//CONCEPTO DE PAGO******
												$cuentas=array();
												if($_POST[destcompra]=='01')
												{
													$sqlr="select ccontable from almdestinocompra_det where codigo='".$_POST[destcompra]."'" ;
													$respa=mysql_query($sqlr,$linkbd);   
													$rowa=mysql_fetch_row($respa);
													$cuentas=concepto_cuentas($rowa[0],'AT',5,$_POST[cc],$fechaf);
													$tam=count($cuentas);
													for($cta=0;$cta<$tam;$cta++)
													{
														$ctacon=$cuentas[$cta][0];
														if ($cuentas[$cta][1]=='N' && $cuentas[$cta][3]=='S')
														{
															$ncuent=buscacuenta($ctacon);
															if ($_POST[dvalores][$x]>0 && $ncuent!='')
															{
																$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('11 $consec','".$ctacon."','".$_POST[tercero]."','".$_POST[cc]."','Causacion ".$_POST[dncuentas][$x]."','',".$_POST[dvalores][$x].",0,'1','".$_POST[vigencia]."')";
																mysql_query($sqlr,$linkbd);
															}
														}		
														if ($cuentas[$cta][1]=='N' && $cuentas[$cta][2]=='S')
														{
															$ncuent=buscacuenta($ctacon);
															if ($_POST[dvalores][$x]>0 && $ncuent!='')
															{					
																$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('11 $consec','".$ctacon."','".$_POST[tercero]."','".$_POST[cc]."','Causacion ".$_POST[dncuentas][$x]."','',0,".$_POST[dvalores][$x].",'1','".$_POST[vigencia]."')";
																mysql_query($sqlr,$linkbd);
															}
														}	
													}
												}
												elseif($_POST[destcompra]=='02')
												{
													$sqlr="select ccontable from almdestinocompra_det where codigo='".$_POST[destcompra]."'" ;
													$respa=mysql_query($sqlr,$linkbd);   
													$rowa=mysql_fetch_row($respa);
													$cuentas=concepto_cuentas($rowa[0],'CT',5,$_POST[cc],$fechaf);
													$tam=count($cuentas);
													for($cta=0;$cta<$tam;$cta++)
													{
														$ctacon=$cuentas[$cta][0];
														if ($cuentas[$cta][1]=='N' && $cuentas[$cta][3]=='S')
														{
															$ncuent=buscacuenta($ctacon);
															if ($_POST[dvalores][$x]>0 && $ncuent!='')
															{
																$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('11 $consec','".$ctacon."','".$_POST[tercero]."','".$_POST[cc]."','Causacion ".$_POST[dncuentas][$x]."','',".$_POST[dvalores][$x].",0,'1','".$_POST[vigencia]."')";
																mysql_query($sqlr,$linkbd);
															}
														}		
														if ($cuentas[$cta][1]=='N' && $cuentas[$cta][2]=='S')
														{
															$ncuent=buscacuenta($ctacon);
															if ($_POST[dvalores][$x]>0 && $ncuent!='')
															{					
																$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('11 $consec','".$ctacon."','".$_POST[tercero]."','".$_POST[cc]."','Causacion ".$_POST[dncuentas][$x]."','',0,".$_POST[dvalores][$x].",'1','".$_POST[vigencia]."')";
																mysql_query($sqlr,$linkbd);
															}
														}	
													}
												}
												else 
												{
													$cuentas=concepto_cuentas($concepto2,'C',3,$_POST[cc],$fechaf);
													$tam=count($cuentas);
													for($cta=0;$cta<$tam;$cta++)
													{   
														$ctacon=$cuentas[$cta][0];
														if ($cuentas[$cta][1]=='N' && $cuentas[$cta][3]=='S')
														{
															$ncuent=buscacuenta($ctacon);								  
															if ($_POST[dvalores][$x]>0 && $ncuent!='')
															{
																$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia) values ('11 $consec','".$ctacon."','".$_POST[tercero]."','".$_POST[cc]."','Causacion ".$_POST[dncuentas][$x]."','',0,".$_POST[dvalores][$x].",'1','".$vigusu."')";
																mysql_query($sqlr,$linkbd);
															}
														}		
														if ($cuentas[$cta][1]=='N' && $cuentas[$cta][2]=='S')
														{
															$ncuent=buscacuenta($ctacon);								  
															if ($_POST[dvalores][$x]>0 && $ncuent!='')
															{					
																$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('11 $consec','".$ctacon."','".$_POST[tercero]."','".$_POST[cc]."','Causacion ".$_POST[dncuentas][$x]."','',".$_POST[dvalores][$x].",0,'1','".$vigusu."')";
																mysql_query($sqlr,$linkbd);
															}
														}	
													}	
												}  					
											}
											
										}
									}
								}//**************FIN DE CONTABILIDAD

							}
							
							for ($y=0;$y<count($_POST[rubros]);$y++)//**************PPTO AFECTAR LAS CUENTAS PPTALES CAMPO CxP
							{
								for($x=0;$x<count($_POST[dcuentas]);$x++)
								{	
									if($_POST[dcuentas][$x]==$_POST[rubros][$y])
									{
										$sqlr2="update pptorp_detalle set saldo=saldo-".$_POST[dvalores][$x]." where cuenta='".$_POST[dcuentas][$x]."' and consvigencia=".$_POST[rp]." and vigencia=".$vigusu." and tipo_mov='201'";
										$res2=mysql_query($sqlr2,$linkbd); 
									}
								}
							}
							//***ACTUALIZACION  DEL REGISTRO
							$sqlr="update pptorp set saldo=saldo-".$_POST[valoregreso]." where consvigencia=".$_POST[rp]." and vigencia=".$vigusu." and tipo_mov='201' ";
							$res=mysql_query($sqlr,$linkbd); 
							
							$sqlr="select saldo from pptorp where consvigencia=".$_POST[rp]." and vigencia=".$vigusu." and tipo_mov='201'";
							// echo $sqlr."<br>";
							$res=mysql_query($sqlr,$linkbd); 
							$row=mysql_fetch_row($res);
							// echo $row[0];
							if($row[0]==0){
								$sqlr="update pptorp set estado='S' where consvigencia=".$_POST[rp]." and vigencia=".$vigusu." and tipo_mov='201' ";
								$res=mysql_query($sqlr,$linkbd); 
							}
							//*******INCIO DE TABLAS DE TESORERIA **************
							//**** ENCABEZADO ORDEN DE PAGO
							$sqlr="insert into tesoordenpago (id_comp,fecha,vigencia,id_rp,cc,tercero,conceptorden,valorrp,saldo,valorpagar, cuentapagar,valorretenciones,estado,base,iva,anticipo,user,tipo_mov,medio_pago) values($idcomp,'$fechaf',".$vigusu.",$_POST[rp],'$_POST[cc]','$_POST[tercero]','$_POST[detallegreso]',$_POST[valorrp],$_POST[saldorp],$_POST[totalc],'$_POST[cuentapagar]',$_POST[totaldes],'S','$_POST[base]','$_POST[iva]','$_POST[anticipo]','".$_SESSION['nickusu']."','201','$_POST[medioDePago]')";	  
							mysql_query($sqlr,$linkbd);
							$idorden=mysql_insert_id();
							//****** DETALLE ORDEN DE PAGO
							for ($y=0;$y<count($_POST[rubros]);$y++)
							{	
								for($x=0;$x<count($_POST[dcuentas]);$x++)
								{
									if($_POST[dcuentas][$x]==$_POST[rubros][$y])
									{
										$sqlr="insert into tesoordenpago_det (id_orden,cuentap,cc,valor,estado,tipo_mov) values ($idorden,'".$_POST[dcuentas][$x]."','".$_POST[cc]."',".$_POST[dvalores][$x].",'S','201')";
										if (!mysql_query($sqlr,$linkbd))
										{
											echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue><img src='imagenes\alert.png'>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
											echo "Ocurrió el siguiente problema:<br>";
											echo "<pre>";
											echo "</pre></center></td></tr></table>";
										}
										else
										{
										  echo "<script>despliegamodalm('visible','1','Se ha almacenado la Orden de Pago con Exito');</script>";

											echo"
												<script>
													document.form2.numero.value='';
													document.form2.valor.value=0;
													document.form2.oculto.value=1;
												</script>";	
										}
									}
								}
							}
							//****CUENTA POR PAGAR - DESTINO COMPRA
							$sqlr="insert into tesoordenpago_almacen (id_orden,destino,vigencia) values ($idorden,'".$_POST[destino]."',$vigusu)";
							mysql_query($sqlr,$linkbd);
							//****** ORDEN PAGO BASES RETENCION ****
							for($x=0;$x<count($_POST[pcxp]);$x++)
							{
								$ch=esta_en_array($_POST[pagos],$_POST[pcxp][$x]);
								if($ch=='1')
								{
									$sqlr="insert into tesoordenpago_bases (id_orden,id_ordenbase,valor,vigencia) values ($idorden,".$_POST[pcxp][$x].",".$_POST[pvalores][$x].",'".$vigusu."')";
									mysql_query($sqlr,$linkbd);
								}
							}

							$causacion="";
							$estado="";
							if($opcion=="1"){
								$causacion="orden"; 
								$estado="S"; 
							}else if($opcion=="2"){
								$causacion="egreso"; 
								$estado="N"; 
							}

							//****** RETENCIONES ORDEN DE PAGO 
							for($x=0;$x<count($_POST[ddescuentos]);$x++)
							{
								$sqlr="insert into tesoordenpago_retenciones_manual_automatico (id_orden,id_retencion,automatico) values ($idorden,'".$_POST[ddescuentos][$x]."','".$_POST[dmanual][$x]."')";
								mysql_query($sqlr,$linkbd);
								
								$sqlr="insert into tesoordenpago_retenciones (id_retencion,id_orden,porcentaje,valor,estado,causacion,pasa_ppto) values ('".$_POST[ddescuentos][$x]."',$idorden,'".$_POST[dporcentajes][$x]."',".$_POST[ddesvalores][$x].",'S','$causacion','$estado')";
								
								
								if (!mysql_query($sqlr,$linkbd))
								{
									echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue><img src='imagenes\alert.png'>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
									echo "Ocurrió el siguiente problema:<br>";
									echo "<pre>";
									echo "</pre></center></td></tr></table>";
								}
								else
								{
				
									echo"
										<script>
											document.form2.numero.value='';
											document.form2.valor.value=0;
											document.form2.oculto.value=1;
											document.form2.fecha.focus();
											document.form2.fecha.select();
										</script>";
								}

								
							}
						}
					}
					else
					{
						
						if($_POST[selectipo]=='servicio'){
						$sql="SELECT codcompro,pagos FROM inv_servicio_cxp WHERE cxp='$_POST[cxp]' ";	
						$res=mysql_query($sql,$linkbd);
						$codcomp=-1;
						$pagosok=0;
						while($row = mysql_fetch_row($res)){
							$codcomp=$row[0];
							$arreglopagos=explode(",",$row[1]);
							for($i=0;$i<count($arreglopagos);$i++ ){
								$pagosok++;
								$sql="UPDATE inv_servicio_det SET estado='S' WHERE  codcompro='$row[0]' AND numpago='".$arreglopagos[$i]."' ";
								mysql_query($sql,$linkbd);
								$sql="UPDATE inv_servicio_cxp SET estado='S' WHERE  cxp='$_POST[cxp]'  ";
								mysql_query($sql,$linkbd);
							}
							
						 }
							 if($codcomp!=-1){
								$sql="UPDATE inv_servicio SET numpagosok=numpagosok-$pagosok ,estado='A' WHERE codcompro='$codcomp' ";	
								mysql_query($sql,$linkbd);
							}
						}
						
								
						$sqlr="DELETE FROM comprobante_cab where numerotipo='$_POST[cxp]' and tipo_comp='11'";
						mysql_query($sqlr,$linkbd);
						$sqlr="DELETE FROM comprobante_det where numerotipo='$_POST[cxp]' and tipo_comp='11'";
						mysql_query($sqlr,$linkbd);
						
						$sqlr="update pptorp set valor=$_POST[valorcxp], saldo=$_POST[valorcxp] where consvigencia='$_POST[rp]' and vigencia='$_POST[vigencia]' and tipo_mov='201'";
						// echo $sqlr;
						mysql_query($sqlr,$linkbd);
						$sqlr="update tesoordenpago set estado='R' where id_orden='$_POST[cxp]' and tipo_mov='201' ";
						mysql_query($sqlr,$linkbd);
						$sqlr="update tesoordenpago_det set estado='R' where id_orden='$_POST[cxp]' and tipo_mov='201' ";
						mysql_query($sqlr,$linkbd);
						$sqlr="update tesoordenpago_retenciones set estado='R' where id_orden='$_POST[cxp]'";
						mysql_query($sqlr,$linkbd);
						for ($x=0;$x<count($_POST[dcuentas]);$x++)
						{		
							$sqlr="update pptorp_det set valor=$_POST[dvalores][$x] where consvigencia='$_POST[rp]' and vigencia='$_POST[vigencia]' and tipo_mov='201'";
							mysql_query($sqlr,$linkbd);
						}
						
						//$sqlr="insert into tesoordenpago_cab_r (id_orden,id_rp,vigencia,detalle,fecha,fecha_doc,user) values ('$_POST[cxp]','$_POST[rp]','$_POST[vigencia]','$_POST[descripcion]','$fechaf','$gfecha','".$_SESSION['nickusu']."')";	

						$sqlr="insert into tesoordenpago(id_orden,fecha,vigencia,id_rp,cc,tercero,conceptorden,user,tipo_mov,estado) values ('$_POST[cxp]','$fechaf','$vigenciaReversion','$_POST[rp]','$_POST[ccR]','$_POST[terceroR]','$_POST[descripcion]','".$_SESSION['nickusu']."','401','R')";
						mysql_query($sqlr,$linkbd);						
						
						for($x=0;$x<count($_POST[dcuentas]);$x++)
						{
							//$sqlr="insert into tesoordenpago_det_r (id_orden,vigencia,cuenta,fuente,valor) values ('$_POST[cxp]','$_POST[vigencia]','".$_POST[dcuentas][$x]."','".$_POST[drecursos][$x]."','".$_POST[dvalores][$x]."')";	
							$sqlr="insert into tesoordenpago_det(id_orden,cuentap,valor,vigencia,fuente,tipo_mov,estado) values('$_POST[cxp]','".$_POST[dcuentas][$x]."','".$_POST[dvalores][$x]."','$_POST[vigencia]','".$_POST[drecursos][$x]."','401','R')";
							mysql_query($sqlr,$linkbd);
						}
						
						/*
						$sqlr="select * from comprobante_det where numerotipo=$_POST[cxp] and tipo_comp=11 and vigencia=$_POST[vigencia]";
						$res=mysql_query($sqlr,$linkbd);
						while($row=mysql_fetch_row($res)){
							if($row[7]!=0){
								$sqlr1="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values ('$row[1]','$row[2]','$row[3]','$row[4]','REVERSADO','$row[6]',0,'$row[7]','$row[9]','$row[10]','$row[11]','$row[12]')";
								mysql_query($sqlr1,$linkbd);
								// echo $sqlr1."<br>";
							}
							if($row[8]!=0){
								$sqlr1="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque, valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values ('$row[1]','$row[2]','$row[3]','$row[4]','REVERSADO','$row[6]','$row[8]',0,'$row[9]','$row[10]','$row[11]','$row[12]')";
								mysql_query($sqlr1,$linkbd);
								// echo $sqlr1."<br>";
							}
						}*/
						
						for ($y=0;$y<count($_POST[rubros]);$y++)//**************PPTO AFECTAR LAS CUENTAS PPTALES CAMPO CxP
							{
								for($x=0;$x<count($_POST[dcuentas]);$x++)
								{	
									if($_POST[dcuentas][$x]==$_POST[rubros][$y])
									{
										$sqlr2="update pptorp_detalle set saldo=saldo+".$_POST[dvalores][$x]." where cuenta='".$_POST[dcuentas][$x]."' and consvigencia=".$_POST[rp]." and vigencia=".$vigusu." and tipo_mov='201' ";
										$res2=mysql_query($sqlr2,$linkbd); 
									}
								}
							}
						echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha reversado la CxP con Exito <img src='imagenes\confirm.png'></center></td></tr></table>";
						echo "<script>funcionmensaje();</script>";
					}
	 			}
  				else 
				{
					echo "<div class='inicio'><img src='imagenes\alert.png'> No Tiene los Permisos para Modificar este Documento</div>";
				}
  				//****fin if bloqueo  
			}//************ FIN DE IF OCULTO************
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