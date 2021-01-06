<?php //V 1001 17/12/16 ?>
<?php
error_reporting(0);
include_once ($_SERVER['DOCUMENT_ROOT'].'/financiero/dirs.php');
require "comun.inc";
require "funciones.inc";
require "conversor.php";
require "validaciones.inc";
require_once "teso-funciones.php";
session_start();
$linkbd=conectar_bd();	
cargarcodigopag(@$_GET[codpag],$_SESSION["nivel"]);
header("Cache-control: private"); // Arregla IE 6
date_default_timezone_set("America/Bogota");


?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
    <meta http-equiv="X-UA-Compatible" content="IE=9"/>
	<title>:: Spid - Activos Fijos</title>
    <link href="css/css2.css" rel="stylesheet" type="text/css" />
    <link href="css/css3.css" rel="stylesheet" type="text/css" />
	<link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="botones.js"></script>
    <script type='text/javascript' src='JQuery/jquery-2.1.4.min.js'></script>
    <script type="text/javascript" src="css/calendario.js"></script>
    <script type="text/javascript" src="css/programas.js"></script>
	<script type="text/javascript" src="css/sweetalert.js"></script>
<script type="text/javascript" src="css/sweetalert.min.js"></script>
<script type="text/javascript" src="css/funciones.js"></script>
	<script src="JQuery/autoNumeric-master/autoNumeric-min.js"></script>
	<link href="css/sweetalert.css" rel="stylesheet" type="text/css" />
	<script>
       	function guardar()
		{
			if(document.getElementById('tipomov').value=='1')
			{
				var validacion03=document.getElementById('fc_1198971546').value;
				var validacion01=document.getElementById('docgen').value;
				var validacion02=document.getElementById('origen').value;
				var validacion04=document.getElementById('orden').value;
				var filas = $('#tabact >tbody >tr').length;
				if((validacion02.trim()!='')&&(validacion03.trim()!='')&&(validacion04.trim()!='')&&(filas>=1)){
					despliegamodalm('visible','4','Esta Seguro de Guardar','1');
				}
				else {
					despliegamodalm('visible','2','Falta informacion para Crear Activos');
				}
			}
			else
			{
				var validacion01=document.getElementById('descripcion').value;
				var validacion02=document.getElementById('orden').value;
				if((validacion01.trim()!='')&&(validacion02.trim()!='')){
					despliegamodalm('visible','4','Esta Seguro de Guardar','1');
				}
				else {
					despliegamodalm('visible','2','Falta informacion para Crear Activos');
				}
			}
 		}
			
		function despliegamodalm(_valor,_tip,mensa,pregunta,variable)
		{
			document.getElementById("bgventanamodalm").style.visibility=_valor;
			if(_valor=="hidden")
			{
				document.getElementById('ventanam').src="";
				if(document.getElementById('valfocus').value=="2")
				{
					document.getElementById('valfocus').value='1';
					document.getElementById('codigo').focus();
					document.getElementById('codigo').select();
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
					case "5":
						document.getElementById('ventanam').src="ventana-elimina1.php?titulos="+mensa+"&idresp="+pregunta+"&variable="+variable;break;	
				}
			}
		}
			
		
		function funcionmensaje(){
			document.location.href = "acti-editargestionactivos.php?clase="+document.getElementById('orden').value
		}
			
		function respuestaconsulta(pregunta, variable)
		{
			switch(pregunta)
			{
				case "1":
					document.form2.oculto.value="2";
					document.form2.submit();
					break;
				case "2":
					document.form2.elimina.value=variable;
					//eli=document.getElementById(elimina);
					vvend=document.getElementById('elimina');
					//eli.value=elimina;
					vvend.value=variable;
					document.form2.submit();
					break;
			}
		}

		function despliegamodal2(_valor,v)
		{
			if(v!='')
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){
					document.getElementById('ventana2').src="";
					document.form2.submit();
				}
				else {
					if(v=='T'){	document.getElementById('ventana2').src="terceros-ventana1.php";}
					if(v=='01'){
						document.getElementById('ventana2').src="activentana-compra-activos.php";
					}
					else if(v=='02')
					{
						document.getElementById('ventana2').src="activentana-construccion.php";
					}
					else if(v=='03')
					{
						document.getElementById('ventana2').src="activentana-montaje.php";
					}
					else if(v=='04')
					{
						document.getElementById('ventana2').src="activentana-donacion.php";
					}
					else if(v=='05')
					{
						document.getElementById('ventana2').src="activentana-donacion.php";
					}
					else if(v=='07')
					{
						document.getElementById('ventana2').src="activentana-otros.php";
					}
					else if(v=='4')
					{
						document.getElementById('ventana2').src="reservar-activo.php";
					}
					
				}
			}
			else{
				despliegamodalm('visible','2','Seleccione el Origen del Activo');
			}
		}
				
		function agregardetalle()
		{
			if(document.form2.origen.value!="" && document.form2.clasificacion.value!="" && document.form2.grupo.value!="" && document.form2.tipo.value!="" && document.form2.fechact.value!="")
			{
				//if(parseFloat(document.form2.valor.value)<=parseFloat(document.form2.saldo.value))
				//{
					document.form2.agregadet.value=1;
					document.form2.submit();
				//}
				//else
				//{
				//	despliegamodalm('visible','2','El valor supera el saldo disponible');
				//}
			}
			else {
				despliegamodalm('visible','2','Falta informacion para poder Agregar');
			}
			despliegamodalm("hidden");
		}

		function eliminar(variable)
		{
			despliegamodalm('visible','5','Esta Seguro de Eliminar','2',variable);
		}


		function clasifica(formulario)
		{
			//document.form2.action="presu-recursos.php";
			document.form2.submit();
		}

		function buscacta(e){if (document.form2.cuenta.value!=""){document.form2.bc.value='1';document.form2.submit();}}

		function buscacc(e){if (document.form2.cc.value!=""){document.form2.bcc.value='1';document.form2.submit();}}

		function validar2(ind = '')
		{
			limpiar(ind);
			document.form2.submit();
		}
		
		function limpiar(ind='')
		{
			switch(ind)
			{
				case 1:
					document.getElementById('grupo').value='';
					document.getElementById('tipo').value='';
				break;
				case 2:
					document.getElementById('tipo').value='';
				break;
			}
			if(ind!=3)
				document.getElementById('prototipo').value='';
			document.getElementById('area').value='';
			document.getElementById('ubicacion').value='';
			document.getElementById('dispactivos').value='';
			document.getElementById('cc').value='';
			document.getElementById('nombre').value='';
			document.getElementById('referencia').value='';
			document.getElementById('modelo').value='';
			document.getElementById('serial').value='';
			document.getElementById('unimed').value='';
			document.getElementById('estadoact').value='';
			document.getElementById('valor1').value='';
			document.getElementById('foto').value='';
			document.getElementById('ficha').value='';
			document.getElementById('saldo2').value='';
			document.getElementById('placa').value='';
			document.getElementById('tercero').value='';
			document.getElementById('ntercero').value='';
		}
		function validar(){			
					if($("#tipomov").val()=='1')
					{
						$("#oculto").val("");
					}
					if($("#tipomov").val()=='3')
					{
						$("#oculto").val("0");
					}	
			document.form2.submit();
			}
		function validar_origen(){
			$('#docgen').val('');
			document.form2.submit();
		}

		function valDep()
		{
			if($('#chkdep').is(":checked")){
				$('#agedep1').attr('readonly','readonly');
				$('#agedep1').val('0');
				$('#valdep').val('1');
				$('#valdep').attr('checked',true);
			}
			else{
				$('#agedep1').removeAttr('readonly');
				$('#valdep').val('0');
			}
		}

		function marcar(objeto,posicion)
		{	
			var pagoscheck=document.getElementsByName('pagosselec[]');
			var valasignado=document.getElementsByName('dvalores[]');
			var valdisponible=document.getElementsByName('dvdisponible[]');
			if(objeto.checked){pagoscheck.item(posicion).checked=true;}
			else 
			{
				if (parseFloat(valasignado.item(posicion).value) == parseFloat(valdisponible.item(posicion).value)){pagoscheck.item(posicion).checked=false;}	
				else{pagoscheck.item(posicion).checked=true;}	
			}
		}
		
		function iratras(){
			location.href="acti-gestiondelosactivos.php";
		}

		function sumaTotal()
		{
			var elementos = document.getElementsByName('dvalor[]');
			document.getElementById('totact').value=0;
			var suma=0;
			elementos.forEach (function(numero){
					suma =  suma + parseInt(numero.value);
				});

			/**
			* Number.prototype.format(n, x, s, c)
			* 
			* @param integer n: length of decimal
			* @param integer x: length of whole part
			* @param mixed   s: sections delimiter
			* @param mixed   c: decimal delimiter
			*/
			Number.prototype.format = function(n, x, s, c) {
				var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
					num = this.toFixed(Math.max(0, ~~n));

				return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));
			};
			
			document.getElementById('totact').value=suma.format(2, 3, '.', ',');;
		}
	</script>
	<?php titlepag();?>
</head>
<body>
	<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
	<span id="todastablas2"></span>
	<table>
		<tr><script>barra_imagenes("acti");</script><?php cuadro_titulos();?></tr>
    	<tr><?php menu_desplegable("acti");?></tr>
		<tr>
			<td colspan="3" class="cinta">
				<a href="acti-gestionactivos.php" class="mgbt"><img src="imagenes/add.png"  title="Nuevo"/></a>
				<a href="#"  onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png"  title="Guardar" /></a>
				<a href="acti-buscagestionactivos.php" class="mgbt"><img src="imagenes/busca.png"  title="Buscar"/></a>
				<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
				<a href="#" onClick="mypop=window.open('acti-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a> 
  				<a onclick="iratras()" class="mgbt"><img src="imagenes/iratras.png" title="AtrÃ¡s"></a>
			</td>
		</tr>
	</table>
	<?php
	$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
	$vigencia=$vigusu;
	$linkbd=conectar_bd();
	if($_POST[oculto]=="")
	{
		$_POST[valdep]="1";
		$_POST[agedep1]="0";
		echo"<script>valDep();</script>";
		$_POST[tipomov]='1';
		$_POST[oculto]=0;
		$_POST[tabgroup1]=1;
		$_POST[actcheck]=0;
	}
	switch($_POST[tabgroup1])
	{
		case 1:	$check1='checked';break;
		case 2:	$check2='checked';break;
		case 3:	$check3='checked';break;
	}
	if(!$_POST[fecha])
	{
 		$fec=date("d/m/Y");
		$_POST[fecha]=$fec; 	
 	 	$_POST[vigencia]=$vigencia;		 	  			 
	//	$_POST[valor]=0;		 		 
	}
 	$sqlr="select MAX(codigo) from acticrearact WHERE clasificacion='$_POST[clasificacion]' AND grupo='$_POST[grupo]' order by codigo Desc";
	$res=mysql_query($sqlr);
	$row=mysql_fetch_row($res);
	$_POST[consecutivo]=$row[0]+1;
	
	$numpla=0;
	if(count($_POST[dclase])>0){
		for($i=0;$i<count($_POST[dclase]);$i++){
			if(($_POST[clasificacion]==$_POST[dclase][$i])&&($_POST[grupo]==$_POST[grupo][$i])&&($_POST[tipo]==$_POST[dtipo][$i]))
				$numpla=$_POST[dplaca][$i];
		}
	}

	if($numpla>0){
		$numpla=substr($numpla,6,13);
		$idpla=(int) $numpla;
		$_POST[consecutivo]=$idpla+1;
	}
	
  //	$_POST[consecutivo]=retornar_codigo($_POST[consecutivo],7);
 	//$ta=$_POST[clasificacion].retornar_codigo($_POST[grupo],2).retornar_codigo($_POST[tipo],3).$_POST[consecutivo];
//	$_POST[placa]='87784';
	
?>
    <div id="bgventanamodalm" class="bgventanamodalm">
        <div id="ventanamodalm" class="ventanamodalm">
            <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"></IFRAME>
		</div>
	</div>
 
	<form name="form2" method="post" enctype="multipart/form-data"> 
		<?php //**** busca cuenta
  			if($_POST[bc]=='1')
			 {
			  $nresul=buscacuenta($_POST[cuenta]);
			  if($nresul!='')
			   {
			  $_POST[ncuenta]=$nresul;
  	
			  }
			 else
			 {
			  $_POST[ncuenta]="";
			  }
			 }
			  //**** busca centro costo
  			if($_POST[bcc]=='1')
			 {
			  $nresul=buscacentro($_POST[cc]);
			  if($nresul!='')
			   {
			  $_POST[ncc]=$nresul;
  	
			  }
			 else
			 {
			  $_POST[ncc]="";
			  }
			 }
		 ?>
		<table class="inicio">
			<tr>
				<td class="titulos" style="width:100%;">.: Tipo de Movimiento:
                        <select name="tipomov" id="tipomov" onChange="validar()"  style="width:20%;" >
                            <option value="-1">Seleccione ....</option>
                            <option value="1" <?php if($_POST[tipomov]=='1') echo "SELECTED"; ?>>1 - Entrada</option>
                            <option value="3" <?php if($_POST[tipomov]=='3') echo "SELECTED"; ?>>3 - Reversi&oacute;n de Entrada</option>
                        </select>
            			<input type="hidden" name="sw"  id="sw" value="<?php echo $_POST[tipomov] ?>" />
					
					
					<?php
						//echo $_POST[tipomovimiento]."hola";
					?>
				</td>
				<td style="width:80%;">
				</td>
			</tr>
		</table>
		<?php if($_POST[tipomov]=='1'){
		
		if(!$_POST[oculto])
		{$_POST[orden]='';
			$sqlr="SELECT * FROM acticrearact ORDER BY codigo DESC";
			$res=mysql_query($sqlr,$linkbd);
			if(mysql_num_rows($res)!=0)
			{
				$wid=mysql_fetch_array($res);
				$_POST[orden]=$wid[0]+1;
			}
			else{$_POST[orden]=1;}
			if($_POST[orden]!='0')
			{
				$_POST[tipomovimiento]='101';
			}
		}
		?>
		<table class="inicio" align="center"  >
			<tr>
				<td class="titulos" colspan="12">.: Gestion de Activos - Activar</td>
				<td class="cerrar"><a href="acti-principal.php">Cerrar</a></td>
			</tr>
			<tr>
				<td class="saludo1">Orden:</td>
				<td valign="middle" >
					<input type="text" id="orden" name="orden" style="width:50%; text-align:center;" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[orden]?>" readonly>
					<input type="hidden" id="consecutivo" name="consecutivo" value="<?php echo $_POST[consecutivo]?>" readonly>
				</td>
				<td class="saludo1">Fecha:</td>
				<td>
					<input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">&nbsp;<img src="imagenes/calendario04.png" style="width:20px; cursor:pointer;" title="Calendario"  onClick="displayCalendarFor('fc_1198971545');" class="icobut"/>
					<input type="hidden" name="chacuerdo" value="1">
				</td>
				<td class="saludo1">Origen:</td>
				<td>
				<select id="origen" name="origen" onChange="validar_origen()" style="width:90%">
					<option value="">...</option>
					<?php
					$link=conectar_bd();
					$sqlr="Select * from acti_tipomov where estado='S' and codigo!='06' and tipom=$_POST[tipomov]";
		 			$resp = mysql_query($sqlr,$link);
				    while ($row =mysql_fetch_row($resp)) 
				    {
						echo "<option value='".$row[0]."'";
						$i="".$row[0];
						if($i==$_POST[origen])
			 			{
							echo "SELECTED";
						}
						echo ">".$row[0].' - '.strtoupper($row[2])."</option>";	  
					}
					?>
				</select>
				</td>
				<td class="saludo1">Documento:</td>
				<td>
					<input type="hidden" id="actcheck" name="actcheck" value="<?php echo $_POST[actcheck] ?>">
					<input name="docgen" type="text" id="docgen" size="10" value="<?php echo $_POST[docgen]; ?>" onKeyUp="return tabular(event,this)" onBlur="guiabuscar1('1');">
					<?php
					$busdoc="'".$_POST[origen]."'";
					echo'<img src="imagenes/find02.png" style="width:20px;" onClick="despliegamodal2(\'visible\','.$busdoc.');" title="Buscar Documento" class="icobut" />';
					?>
				</td>
				<td class="saludo1">Valor:</td>
				<td valign="middle" >
					<input name="valdoc" type="text" id="valdoc" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[valdoc]?>" size="20" readonly="readonly" style="text-align:right;" >
				</td>         	    
			</tr>          
		</table>  
		<div class="tabs" style="min-height: 190px !important;">
			<div class="tab">
				<input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
				<label for="tab-1">Articulos</label>
				<div class="content" style="overflow-x:hidden; height:170px;">
					<table class="inicio">
						<tr><td colspan="6" class="titulos2">Crear Detalle Activo Fijo</td></tr>
						<tr>
							<td class="saludo1" style="width:10%">Clase:</td>
							<td style="width:40%">
								<select id="clasificacion" name="clasificacion" onChange="validar2(1)" style="width:90%">
									<option value="">...</option>
									<?php
									$link=conectar_bd();
									$sqlr="SELECT * from actipo where niveluno='0' and estado='S'";
									$resp = mysql_query($sqlr,$link);
									while ($row =mysql_fetch_row($resp)) 
									{
										echo "<option value=$row[0] ";
										$i=$row[0];
										if($i==$_POST[clasificacion])
										{
											echo "SELECTED";
										}
										echo ">".$row[0].' - '.strtoupper($row[1])."</option>";	  
									}
									?>
								</select>
							</td>    
							<td class="saludo1">Grupo:</td>
							<td>
								<select id="grupo" name="grupo" onChange="validar2(2)" style="width:90%">
									<option value="">...</option>
									<?php
									$link=conectar_bd();
									$sqlr="SELECT * from actipo where niveluno='$_POST[clasificacion]' and estado='S'";
									$resp = mysql_query($sqlr,$link);
									while ($row=mysql_fetch_row($resp)) 
									{
										echo "<option value=$row[0] ";
										$i=$row[0];
										if($i==$_POST[grupo])
										{
											echo "SELECTED";
										}
										echo ">".$row[0].' - '.strtoupper($row[1])."</option>";	  
									}
									?>
								</select>
				
							</td>
						</tr>
						<tr>
							<td class="saludo1" style="width:10%">Tipo:</td>
							<td style="width:40%">
								<select id="tipo" name="tipo" onChange="validar2()" style="width:90%">
									<option value="">...</option>
									<?php
									$link=conectar_bd();
									$sqlr="SELECT * from actipo where niveluno='$_POST[grupo]' and niveldos='$_POST[clasificacion]' and estado='S'";
									$resp = mysql_query($sqlr,$link);
									while ($row =mysql_fetch_row($resp)) 
									{
										echo "<option value=$row[0] ";
										$i=$row[0];
										if($i==$_POST[tipo])
										{
											echo "SELECTED";
										}
										echo ">".$row[0].' - '.strtoupper($row[1])."</option>";	  
									}
									?>
								</select>
							</td> 
							<td class="saludo1">Prototipo:</td>
							<td>
								<select id="prototipo" name="prototipo" onChange="validar2(3)" style="width:90%">
									<option value="">...</option>
									<?php
									$link=conectar_bd();
									$sqlr="SELECT * from acti_prototipo where estado='S'";
									$resp = mysql_query($sqlr,$link);
									while ($row =mysql_fetch_row($resp)) 
									{
										echo "<option value=$row[0] ";
										$i=$row[0];
										if($i==$_POST[prototipo])
										{
											echo "SELECTED";
										}
										echo ">".$row[0].' - '.$row[1]."</option>";	  
									}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td class="saludo1">Dependencia:</td>
							<td>
								<select id="area" name="area" style="width:90%">
									<option value="">...</option>
									<?php
									$link=conectar_bd();
									$sqlr="Select * from planacareas where planacareas.estado='S'";
									$resp = mysql_query($sqlr,$link);
									while ($row =mysql_fetch_row($resp)) 
									{
										echo "<option value=$row[0] ";
										$i=$row[0];
										if($i==$_POST[area])
										{
											echo "SELECTED";
										}
										echo ">".$row[0].' - '.$row[1]."</option>";	  
									}
									?>
								</select>
							</td>   
							<td class="saludo1">Ubicacion:</td>
							<td>
								<select name="ubicacion" id="ubicacion" style="width:90%">
									<option value="">...</option>
									<?php
									$link=conectar_bd();
									$sqlr="Select * from actiubicacion where estado='S'";
									$resp = mysql_query($sqlr,$link);
									while ($row =mysql_fetch_row($resp)) 
									{
										echo "<option value=$row[0] ";
										$i=$row[0];
										if($i==$_POST[ubicacion])
										{
											echo "SELECTED";
										}
										echo ">".$row[0].' - '.$row[1]."</option>";	  
									}
									?>
								</select>
							</td> 
						</tr>
						<tr>
							<td class="saludo1">CC:</td>
							<td>
								<select name="cc" id="cc" onKeyUp="return tabular(event,this)" style="width:90%">
									<?php
									$linkbd=conectar_bd();
									$sqlr="select *from centrocosto where estado='S'";
									$res=mysql_query($sqlr,$linkbd);
									while ($row =mysql_fetch_row($res)) 
									{
										echo "<option value=$row[0] ";
										$i=$row[0];
										if($i==$_POST[cc])
										{
											echo "SELECTED";
										}
										echo ">".$row[0]." - ".$row[1]."</option>";	 	 
									}	 	
									?>
								</select>
							</td>
							<td class="saludo1">Disposici&oacute;n de los Activos:</td>
							<td>
								<select id="dispactivos" name="dispactivos" onKeyUp="return tabular(event,this)" style="width: 90%;">
									<option value="">...</option>
									<?php
									$sqlr="SELECT * from acti_disposicionactivos where estado='S'";
									$res=mysql_query($sqlr,$linkbd);
									while ($row =mysql_fetch_row($res)){
										echo "<option value=$row[0] ";
										$i=$row[0];
										if($i==$_POST[dispactivos]){
											echo "SELECTED";
										}
										echo ">".$row[0]." - ".$row[1]."</option>";	 	 
									}	 	
									?>
								</select>
							</td>
						</tr>
					</table>
					<?php	 
					if ($_POST[elimina]!='')
					{ 		 
						$posi=$_POST[elimina];
						unset($_POST[dplaca][$posi]);		 
						unset($_POST[dclase][$posi]);
						unset($_POST[dgrupo][$posi]);
						unset($_POST[dtipo][$posi]);
						unset($_POST[dproto][$posi]);
						unset($_POST[darea][$posi]);
						unset($_POST[dubi][$posi]);
						unset($_POST[dccs][$posi]);		 	 
						unset($_POST[ddispo][$posi]);		 	 
						unset($_POST[dfecact][$posi]);
						unset($_POST[dnombre][$posi]);
						unset($_POST[dref][$posi]);
						unset($_POST[dmodelo][$posi]);
						unset($_POST[dserial][$posi]);
						unset($_POST[dumed][$posi]);
						unset($_POST[dfecom][$posi]);
						unset($_POST[dvalor][$posi]);
						unset($_POST[dbloq][$posi]);
						unset($_POST[danio][$posi]);
						unset($_POST[destado][$posi]);
						unset($_POST[dfoto][$posi]);
						unset($_POST[dficha][$posi]);
						unset($_POST[dterceros][$posi]);
						$_POST[dplaca]= array_values($_POST[dplaca]); 	
						$_POST[dclase]= array_values($_POST[dclase]); 
						$_POST[dgrupo]= array_values($_POST[dgrupo]); 	
						$_POST[dtipo]= array_values($_POST[dtipo]); 
						$_POST[dproto]= array_values($_POST[dproto]); 	
						$_POST[darea]= array_values($_POST[darea]); 
						$_POST[dubi]= array_values($_POST[dubi]); 	
						$_POST[dccs]= array_values($_POST[dccs]); 
						$_POST[ddispo]= array_values($_POST[ddispo]); 
						$_POST[dfecact]= array_values($_POST[dfecact]); 
						$_POST[dnombre]= array_values($_POST[dnombre]); 
						$_POST[dref]= array_values($_POST[dref]); 
						$_POST[dmodelo]= array_values($_POST[dmodelo]); 
						$_POST[dserial]= array_values($_POST[dserial]); 
						$_POST[dumed]= array_values($_POST[dumed]); 
						$_POST[dfecom]= array_values($_POST[dfecom]); 
						$_POST[dvalor]= array_values($_POST[dvalor]); 
						$_POST[dbloq]= array_values($_POST[dbloq]); 
						$_POST[danio]= array_values($_POST[danio]); 
						$_POST[destado]= array_values($_POST[destado]); 
						$_POST[dfoto]= array_values($_POST[dfoto]); 
						$_POST[dficha]= array_values($_POST[dficha]); 
						$_POST[dterceros]= array_values($_POST[dterceros]); 
						$_POST[saldo]=$_POST[saldo]+str_replace(".","",$_POST[valor]);
					}
	
					if ($_POST[agregadet]=='1')
					{
						if($_POST[valdep]==''){$_POST[valdep]=0;}
						$_POST[dclase][]=$_POST[clasificacion];
						$_POST[dgrupo][]=$_POST[grupo];
						$_POST[dtipo][]=$_POST[tipo];
						$_POST[dproto][]=$_POST[prototipo];		 
						$_POST[dfecact][]=$_POST[fechact];
						$_POST[dplaca][]=$_POST[placa];		 
						$_POST[darea][]=$_POST[area];
						$_POST[dubi][]=$_POST[ubicacion];	 
						$_POST[dccs][]=$_POST[cc];		 		 
						$_POST[ddispo][]=$_POST[dispactivos];		 		 
						$_POST[dnombre][]=$_POST[nombre];		 		 
						$_POST[dmodelo][]=$_POST[modelo];		 		 
						$_POST[dref][]=$_POST[referencia];		 		 
						$_POST[dserial][]=$_POST[serial];		 		 
						$_POST[dumed][]=$_POST[unimed];		 		 
						$_POST[dfecom][]=$_POST[fechac];		 		 
						$_POST[dvalor][]=$_POST[valor];
						$_POST[dbloq][]=$_POST[valdep];		 		 
						$_POST[danio][]=$_POST[agedep1];		 		 
						$_POST[destado][]=$_POST[estadoact];		 		 
						$_POST[dfoto][]=$_POST[foto];
						$_POST[dficha][]=$_POST[ficha];	
						$_POST[dterceros][]=$_POST[tercero];	
						$_POST[agregadet]=0;
						$_POST[valdep]=1;
						$_POST[agedep1]=0;
						$_POST[saldo]=$_POST[saldo]-str_replace(".","",$_POST[valor]);
						echo"<script>
							$('#placa').val('');
							$('#nombre').val('');
							$('#modelo').val('');
							$('#referencia').val('');
							$('#serial').val('');
							$('#unimed').val('');
							$('#fc_1198971547').val('');
							$('#valor').val('');
							$('#estadoact').val('');
							$('#foto').val('');
							$('#ficha').val('');
						</script>";
					}
					?>   
				</div>
			</div>
			<div class="tab">
				<input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?>>
				<label for="tab-2">Informacion Actvo Fijo</label>
				<div class="content" style="overflow-x:hidden; height:170px">
					<table class="inicio">
						<tr>
							<td colspan="13" class="titulos2">Informacion Activo Fijo</td>
						</tr>
						<tr>
							<td style="width:10%" class="saludo1">Nombre:</td>
							<td colspan="5">
								<input type="text" id="nombre" name="nombre" style="width:86.5%" onKeyUp="return tabular(event,this)"  style="text-transform:uppercase;" value="<?php echo $_POST[nombre]?>">
							</td>
							
							<td style="width:8%" class="saludo1">Ref:</td>
							<td style="width:8%">
								<input type="text" id="referencia" name="referencia" style="width:61%" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[referencia]?>">
							</td>
							<td class="saludo1" >Modelo:</td>
							<td >
								<input type="text" id="modelo" name="modelo" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[modelo]?>">
							</td>
							</tr>
						<tr>
							<td class="saludo1">Serial:</td>
							<td style="width:10%">
								<input type="text" id="serial" name="serial" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[serial]?>">
							</td>
							<td>
							</td>
							<td style="width:10%" class="saludo1">Fecha Compra: </td>
							<td style="width:8%">
								<input name="fechac" type="text" value="<?php echo $_POST[fechac]?>" maxlength="10" size="15" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971547" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY">&nbsp;<img src="imagenes/calendario04.png" style="width:20px; cursor:pointer;" title="Calendario"  onClick="displayCalendarFor('fc_1198971547');" class="icobut"/>
							</td>
							<td></td>
							<td class="saludo1">Fecha Activacion:</td>
							<td>
								<input name="fechact" type="text" id="fc_1198971546" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fechact]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">&nbsp;<img src="imagenes/calendario04.png" style="width:20px; cursor:pointer;" title="Calendario"  onClick="displayCalendarFor('fc_1198971546');" class="icobut"/>
							</td>
							<td class="saludo1">Unidad Medida:</td>
							<td>
								<select name="unimed" id="unimed">
								   <option value="" >Seleccione...</option>
								   <option value="1" <?php if($_POST[unimed]=='1') echo "SELECTED"; ?>>Unidad</option>
								   <option value="2" <?php if($_POST[unimed]=='2') echo "SELECTED"; ?>>Juego</option>
								   <option value="3" <?php if($_POST[unimed]=='3') echo "SELECTED"; ?>>Caja</option>
								</select>
							</td>
						</tr>
						<tr>
							<td class="saludo1" >Depreciacion en Bloque:</td>
							<td valign="middle" >
								<input type="checkbox" id="chkdep" name="chkdep" onClick="valDep()" <?php if ($_POST[valdep]==1) {echo ' checked="checked"';} ?>>
								<input type="hidden" id="valdep" name="valdep" value="<?php echo $_POST[valdep]?>" >
							</td>
							<td>
							</td>
							<td class="saludo1">Depreciacion Individual:</td>
							<td valign="middle" >
								<input type="text" id="agedep1" name="agedep1" size="5" value="<?php echo $_POST[agedep1]?>" onKeyUp="return tabular(event,this)" style="text-align:center;" readonly>
								Meses
							</td>
							<td></td>
							<td class="saludo1">Estado:</td>
							<td>
								<select name="estadoact" id="estadoact">
									<option value="" >Seleccione...</option>
									<option value="bueno" <?php if($_POST[estadoact]=='bueno') echo "SELECTED"; ?>>Bueno</option>
									<option value="regular" <?php if($_POST[estadoact]=='regular') echo "SELECTED"; ?>>Regular</option>
									<option value="malo" <?php if($_POST[estadoact]=='malo') echo "SELECTED"; ?>>Malo</option>
								</select>
							</td>
							<td class="saludo1">Valor:</td>
							<td>
								<input type="text" name="valor1" id="valor1" onKeyPress="javascript:return solonumeros(event)" onBlur="sinpuntitos('valor','valor1')" onKeyUp="puntitos(this,this.value.charAt(this.value.length-1))" value='<?php echo $_POST[valor1]?>' style="text-align:right;"> 
								<input type="hidden" value="<?php echo $_POST[valor] ?>" name="valor" id="valor" >
								<input type="hidden" value="<?php echo $_POST[oculto] ?>" name="oculto" id="oculto" >
							</td>
						</tr>
						<tr>
							<td class="saludo1">Foto:</td>
							<td>
								<input type="text" name="foto" id="foto" value="<?php echo $_POST[foto]?>" readonly> 
								<input type="hidden" name="patharchivosec" id="patharchivosec" value="<?php echo $_POST[patharchivosec] ?>" />
							</td>
							<td style="width:3%">
								<div class='upload'> 
									<input type="file" name="plantillaadest" onChange="document.form2.submit();" />
									<img src="imagenes/upload01.png" style="width:18px" title="Cargar" /> 
								</div> 
							</td>
							<td class="saludo1">Ficha Tecnica:</td>
							<td>
								<input type="text" name="ficha" id="ficha" value="<?php echo $_POST[ficha]?>" readonly> 
								<input type="hidden" name="patharchivosec" id="patharchivosec" value="<?php echo $_POST[patharchivosec] ?>" />
							</td>
							<td style="width:3%">
								<div class='upload'> 
									<input type="file" name="plantillaadsec" onChange="document.form2.submit();" />
									<img src="imagenes/upload01.png" style="width:18px" title="Cargar" /> 
								</div> 
							</td>
							<td class="saludo1">Saldo:</td>
							<td valign="middle" >
								<input name="saldo2" id="saldo2" type="text" id="saldo2" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[valdoc]; ?>" onBlur="sinpuntitos('saldo','saldo2')" readonly="readonly" >
								<input name="saldo" type="hidden" id="saldo" value="<?php echo $_POST[saldo]; ?>" >
							</td> 
							<td class="saludo1">Placa:</td>
							<td>
								<?php 
									$gru=$_POST[grupo];
									$cla=$_POST[clasificacion];
									$tip=$_POST[tipo];
									$auxil=$cla.''.$gru.''.$tip;
									$sqlpl="SELECT MAX(SUBSTR(placa,7,4)*1) FROM acticrearact_det WHERE SUBSTR(placa,1,6) LIKE '$auxil%' AND tipo_mov='101'  ORDER BY placa ASC";
									$respl=mysql_query($sqlpl,$linkbd);
									$rpn=mysql_num_rows($respl);									
										$rpl=mysql_fetch_row($respl);
										$nconsec=$rpl[0]+1;
										$contadorcons=$nconsec;
										$precon=$auxil.substr("000".$contadorcons,-4);
										while(1==esta_en_array($_POST[dplaca],$precon))
										{
										$contadorcons+=1;
										$precon=$auxil.substr("000".$contadorcons,-4);
										}										
										$nconsec=substr("000".$contadorcons,-4);								
									/**** codigo anterior */
									// $rpl=mysql_fetch_row($respl);
									// if(($auxil.'0001'==$rpl[$rpn-1]) && (count($_POST[dplaca])==0)){
									// 	$auxil=$auxil.''.substr("$rpl[0]",-4)+1;
									// }else{	
									// 	$conta=count($_POST[dplaca]);
									// 	if((count($_POST[dplaca])!=0)&&($auxil==substr($_POST[dplaca][$conta-1],0,-4))){
									// 		$auxil=$auxil.''.substr($_POST[dplaca][$conta-1],-4)+1;
									// 	}else{
									// 		if($auxil.'0001'==$rpl[$rpn-1]){
									// 			$auxil=$auxil.''.substr("$rpl[0]",-4)+1;
									// 		}else{
									// 			$auxil=$auxil.'0001';
									// 		}
									// 	}
									// }
									/***fin codigo anterior */
									$_POST[placa]=$auxil.$nconsec;
								?>
								<input name="placa" id="placa" type="text" value="<?php echo $_POST[placa]; ?>" readonly></td>
						</tr>
						<tr><td class="saludo1" style="width:8%;">Responsable:</td>
          					<td style="width:12%;" colspan='2'><input type="text" id="tercero" name="tercero" style="width:80%;" onKeyUp="return tabular(event,this)" onBlur="bterceros('tercero','ntercero')" value="<?php echo $_POST[tercero]?>"onKeyDown="llamadoesc(event,'2')"><input type="hidden" value="0" name="bt" id="bt">
           					 <a onClick="despliegamodal2('visible','T');" style='cursor:pointer;'><img src="imagenes/find02.png" style="width:20px;"></a></td>
          					<td colspan='3'><input type="text" name="ntercero" id="ntercero" value="<?php echo $_POST[ntercero]?>" style="width:100%" readonly/></td>
							<td>
								<input type="button" name="agrega" value="  Agregar Activo " onClick="agregardetalle()">
								<input type="hidden" value="0" name="agregadet"> 
							</td></tr>
					</table>
				</div>
			</div>
			<div class="tab">
				<input type="radio" id="tab-3" name="tabgroup1" value="3" <?php echo $check3;?>>
				<label for="tab-3">Rubros</label>
				<div class="content" style="overflow-x:hidden; height:150px;">
					<table class="inicio">
						<tr><td colspan="6" class="titulos">Detalle Orden de Pago</td></tr>                  
						<tr>
							<td class="titulos2" style='width:15%'>Cuenta</td>
							<td class="titulos2">Nombre Cuenta</td>
							<td class="titulos2" style='width:35%'>Recurso</td>
							<td class="titulos2" style='width:10%'>Valor Asignado</td>
							<td class="titulos2" style='width:10%'>Saldo Disponible</td>
							<td class="titulos2" style='width:3%'>-</td>
							<input id="vigenciaorden" name="vigenciaorden" type="hidden" value="<?php echo $_POST[vigenciaorden]?>">
						</tr>
						<?php
							if($_POST[docgen]!='')
							{
								$sqlsal="SELECT ACD.valor FROM acticrearact_det ACD, acticrearact ACT WHERE ACT.documento='$_POST[docgen]' AND ACD.codigo=ACT.codigo AND ACT.tipo_mov='101' AND ACD.vigencia='$vigusu' AND ACD.estado='S'";
								$resal=mysql_query($sqlsal,$linkbd);
								$c=0;
								while($rsal=mysql_fetch_row($resal)){$sum+=$rsal[$c];$c++;}
								$sumvalortotal=array_sum(str_replace(".","",$_POST[dvalor]));
								$sumvalortotalaux=$sumvalortotal+$sum;
								$_POST[totalc]=0;
								$x=0;
								$iter='saludo1a';
								$iter2='saludo2';
								$sqlropd="SELECT id_cdpdetalle,cuenta,valor FROM pptorp_detalle  WHERE consvigencia = '$_POST[docgen]' AND tipo_mov='201' AND vigencia='$vigusu' ORDER BY id_cdpdetalle";
								$resopd=mysql_query($sqlropd,$linkbd);
								while($rowopd=mysql_fetch_row($resopd))
								{	
									$descuenta=buscaNombreCuenta($rowopd[1],$_POST[vigenciaorden]); 
									$desrecursos=buscafuenteppto($rowopd[1],$_POST[vigenciaorden]);	
									$chk='';
									$ch=esta_en_array($_POST[pagosselec], $rowopd[0]);
									if($ch==1 || $_POST[actcheck]==1)
									{
										$chk="checked";
										if(($rowopd[2]-$sumvalortotalaux)>0){$valdisponible=$rowopd[2]-$sumvalortotalaux;$sumvalortotalaux=0;}
										else{$valdisponible=0;$sumvalortotalaux=$sumvalortotalaux-$rowopd[2];}
									}	
									else{$valdisponible=$rowopd[2];}
									echo "
									<input type='hidden' name='dcuentas[]' value='$rowopd[1]'/>
									<input type='hidden' name='dncuentas[]' value='$descuenta'/>
									<input type='hidden' name='drecursos[]' value='$desrecursos'/>
									<input type='hidden' name='dvalores[]' value='$rowopd[2]'/>
									<input type='hidden' name='dvdisponible[]' value='$valdisponible'/>
									<input type='hidden' name='dopdcc[]' value='$rowopd[3]'/>
									<input type='hidden' name='codigoid[]' value='$rowopd[0]'/>
									<tr class='$iter'>
										<td>$rowopd[1]</td>
										<td >$descuenta</td>
										<td >$desrecursos</td>
										<td style='text-align:right;'>$ ".number_format($rowopd[2],0,',','.')."</td>
										<td style='text-align:right;'>$ ".number_format($valdisponible,0,',','.')."</td>
										<td><input type='checkbox' name='pagosselec[]' value='$rowopd[0]' $chk onClick='marcar(this,$x);' class='defaultcheckbox'>&nbsp;&nbsp;$dsb2</td>
									</tr>";
									$_POST[totalc]=$_POST[totalc]+$rowopd[2];
									$_POST[totalcf]=number_format($_POST[totalc],$_SESSION["ndecimales"],$_SESSION["spdecimal"],$_SESSION["spmillares"]);
									$aux=$iter;
									$iter=$iter2;
									$iter2=$aux;
									$x++;
									$ayuda+=$valdisponible;
								}
								echo"<script>document.form2.saldo2.value='".number_format($ayuda,0,',','.')."'</script>";
								echo"<script>document.form2.saldo.value='$ayuda'</script>";
							}
						?>
					</table>
					
				</div>
			</div>
		</div>
					<?php }if($_POST[tipomov]=='3'){
					if(!$_POST[oculto])
					$_POST[orden]='';?>
					<table class="inicio">
						<tr>
							<td class="titulos" colspan="6">.: Documento a Reversar</td>
						</tr>
						<tr>
							<td class="saludo1" style="width:10%;">Numero de Activo:</td>
							<td style="width:10%;">
								<input type="text" name="orden" id="orden" value="<?php echo $_POST[orden]; ?>" style="width:80%;" onKeyUp="return tabular(event,this)" onBlur="validar2()" readonly>
								<a href="#" onClick="despliegamodal2('visible','4');" title="Buscar Activo"><img src="imagenes/find02.png" style="width:20px;"></a>
								<input type="hidden" name="vigencia" value="<?php echo $_POST[vigencia]?>">
							</td>
							<td class="saludo1" style="width:10%;">Fecha:</td>
							<td style="width:10%;">
								<input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" style="width:80%;" title="DD/MM/YYYY"/>&nbsp;<a href="#" onClick="displayCalendarFor('fc_1198971545');" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px;"/></a>
							</td>
							<td class="saludo1" style="width:10%;">Descripcion</td>
							<td style="width:60%;" colspan="3">
								<input type="text" name="descripcion" id="descripcion" value="<?php echo $_POST[descripcion]?>" style="width:100%;">
								<input type="hidden" value="<?php echo $_POST[oculto] ?>" name="oculto" id="oculto" >
								<input type="hidden" name="valfocus" id="valfocus" value="<?php echo $_POST[valfocus]; ?>"/>
							</td>
						</tr>	
						<tr>
							<td class="saludo1">Valor Activo</td>
							<td><input type="text" name="valoracti" id="valoracti" value="<?php echo $_POST[valoracti];?>" readonly></td>
						</tr>
						<?php
						if(($_POST[oculto]!="2")&&($_POST[oculto]!="7"))
						{
								$_POST[dplaca]=array();		 
								$_POST[dnombre]=array();			 
								$_POST[dref]=array();			 
								$_POST[dmodelo]=array();			 
								$_POST[dserial]=array();		 
								$_POST[dumed]=array();			 
								$_POST[dfecom]=array();			 
								$_POST[dfecact]=array();			 
								$_POST[dclase]=array();			 
								$_POST[darea]=array();		 
								$_POST[dubi]=array();		 
								$_POST[dgrupo]=array();		 
								$_POST[dccs]=array();			 
								$_POST[ddispo]=array();		 
								$_POST[dvalor]=array();		 
								$_POST[destado]=array();	 
								$_POST[dfoto]=array();		 
								$_POST[dbloq]=array();			 
								$_POST[danio]=array();			 
								$_POST[dtipo]=array();			 
								$_POST[dproto]=array();	
								$_POST[dficha]=array();	
								$_POST[dterceros]=array();	
							$sqlr="select acticrearact_det.* , (select tercero from acticrearact_det_responsable where acticrearact_det.placa=acticrearact_det_responsable.placa and acticrearact_det_responsable.estado='S') as responsable from acticrearact_det where codigo='$_POST[orden]'";
							$i=0;
							$res=mysql_query($sqlr,$linkbd);
							while($row=mysql_fetch_assoc($res))
							{
								$_POST[dplaca][$i]=$row["placa"];		 
								$_POST[dnombre][$i]=$row["nombre"];		 
								$_POST[dref][$i]=$row["referencia"];		 
								$_POST[dmodelo][$i]=$row["modelo"];		 
								$_POST[dserial][$i]=$row["serial"];		 
								$_POST[dumed][$i]=$row["unidadmed"];		 
								$_POST[dfecom][$i]=$row["fechacom"];		 
								$_POST[dfecact][$i]=$row["fechact"];		 
								$_POST[dclase][$i]=$row["clasificacion"];		 
								$_POST[darea][$i]=$row["area"];		 
								$_POST[dubi][$i]=$row["ubicacion"];		 
								$_POST[dgrupo][$i]=$row["grupo"];		 
								$_POST[dccs][$i]=$row["cc"];		 
								$_POST[ddispo][$i]=$row["valor"];		 
								$_POST[dvalor][$i]=$row["valor"];		 
								$_POST[destado][$i]=$row["estado"];		 
								$_POST[dfoto][$i]=$row["foto"];		 
								$_POST[dbloq][$i]=$row["bloque"];		 
								$_POST[danio][$i]=$row["nummesesdep"];		 
								$_POST[dtipo][$i]=$row["tipo"];		 
								$_POST[dproto][$i]=$row["prototipo"];
								$_POST[dficha][$i]=$row["ficha"];
								//****tercero responsable */
								$_POST[dterceros][$i]=$row["responsable"];
								$i++;
							}
						}
						?>
					</table>
					<?php }?>
					<div class="subpantallac" style="height:30%; width:99.6%;">
						<table class="inicio" id="tabact">
							<tr>
								<td class="titulos" colspan="25">Detalles</td>
							</tr>
							<tr>
								<td class="titulos2" style="width:7%">Placa</td>
								<td class="titulos2" style="width:2%">Clase</td>
								<td class="titulos2" style="width:2%">Grupo</td>
								<td class="titulos2" style="width:3%">Tipo</td>
								<td class="titulos2" style="width:5%">Prototipo</td>
								<td class="titulos2" style="width:5%">Dependencia</td>
								<td class="titulos2" style="width:5%">Ubicacion</td>
								<td class="titulos2" style="width:5%">C.C</td>
								<td class="titulos2" style="width:5%">Disposici&oacute;n</td>
								<td class="titulos2" style="width:5%">Activacion</td>
								<td class="titulos2" style="width:10%">Nombre</td>
								<td class="titulos2" style="width:5%">Referencia</td>
								<td class="titulos2" style="width:5%">Modelo</td>
								<td class="titulos2" style="width:5%">Serial</td>
								<td class="titulos2" style="width:4%">U.Medida</td>
								<td class="titulos2" style="width:6%">Compra</td>
								<td class="titulos2" style="width:2%">Dep Bloque</td>
								<td class="titulos2" style="width:5%">Estado</td>
								<td class="titulos2" style="width:10%">Valor</td>
								<td class="titulos2" style="width:1%">Foto</td>
								<td class="titulos2" style="width:1%">Ficha</td>
								<td class="titulos2" style="width:5%">Responsable</td>
								<td class="titulos2" style="width:5%"><img src="imagenes/del.png" ><input type='hidden' name='elimina' id='elimina'></td>
							</tr>
							<?php	
							if (is_uploaded_file($_FILES['plantillaadest']['tmp_name'])) 
							{
								$rutaad="informacion/proyectos/temp/";
								$nomarchivo=$_FILES['plantillaadest']['name'];
								?><script>document.getElementById('foto').value='<?php echo $_FILES['plantillaadest']['name'];?>';document.getElementById('patharchivoest').value='<?php echo $_FILES['plantillaadest']['name'];?>';</script><?php 
								copy($_FILES['plantillaadest']['tmp_name'], $rutaad.$_FILES['plantillaadest']['name']);
							}
							if (is_uploaded_file($_FILES['plantillaadsec']['tmp_name'])) 
							{
								$rutaad="informacion/proyectos/temp/";
								$nomarchivo=$_FILES['plantillaadsec']['name'];
								?><script>document.getElementById('ficha').value='<?php echo $_FILES['plantillaadsec']['name'];?>';document.getElementById('patharchivosec').value='<?php echo $_FILES['plantillaadsec']['name'];?>';</script><?php 
								copy($_FILES['plantillaadsec']['tmp_name'], $rutaad.$_FILES['plantillaadsec']['name']);
							}
							$iter='zebra1';
							$iter2='zebra2';
							$gtotal=0;
							for ($x=0;$x< count($_POST[dclase]);$x++)
							{
								echo "<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
									onMouseOut=\"this.style.backgroundColor=anterior\" >
								 <td style='width:8%'>
									<input name='dplaca[]' value='".$_POST[dplaca][$x]."' type='text' class='inpnovisibles' style='width:100%' readonly>
								</td>
								 <td style='width:1%'><input id='dclase[]' name='dclase[]' value='".$_POST[dclase][$x]."' type='text' style='width:100%' class='inpnovisibles' readonly></td>
								 <td style='width:2%'><input id='dgrupo[]' name='dgrupo[]' value='".$_POST[dgrupo][$x]."' type='text' style='width:100%' class='inpnovisibles' readonly></td>
								 <td style='width:2%'><input id='dtipo[]' name='dtipo[]' value='".$_POST[dtipo][$x]."' type='text' style='width:100%' class='inpnovisibles' readonly></td>
								 <td style='width:2%'><input id='dproto[]' name='dproto[]' value='".$_POST[dproto][$x]."' type='text' style='width:100%' class='inpnovisibles' readonly></td>
								 <td style='width:5%'><input id='darea[]' name='darea[]' value='".$_POST[darea][$x]."' type='text' style='width:100%' class='inpnovisibles' ></td>
								 <td style='width:5%'><input id='dubi[]' name='dubi[]' value='".$_POST[dubi][$x]."' type='text' style='width:100%' class='inpnovisibles' ></td>
								 <td style='width:5%'><input id='dccs[]' name='dccs[]' value='".$_POST[dccs][$x]."' type='text' style='width:100%' class='inpnovisibles' ></td>
								 <td style='width:5%'><input id='ddispo[]' name='ddispo[]' value='".$_POST[ddispo][$x]."' type='text' style='width:100%' class='inpnovisibles' ></td>
								 <td style='width:6%'><input id='dfecact[]' name='dfecact[]' value='".$_POST[dfecact][$x]."' type='text' style='width:100%' class='inpnovisibles' ></td>
								 <td style='width:10%'><input id='dnombre[]' name='dnombre[]' value='".$_POST[dnombre][$x]."' type='text' style='width:100%' class='inpnovisibles' ></td>
								 <td style='width:5%'><input id='dref[]' name='dref[]' value='".$_POST[dref][$x]."' type='text' style='width:100%' class='inpnovisibles' ></td>
								 <td style='width:5%'><input id='dref[]' name='dmodelo[]' value='".$_POST[dmodelo][$x]."' type='text' style='width:100%' class='inpnovisibles' ></td>
								 <td style='width:5%'><input id='dref[]' name='dserial[]' value='".$_POST[dserial][$x]."' type='text' style='width:100%' class='inpnovisibles' ></td>
								 <td style='width:4%'><input id='dref[]' name='dumed[]' value='".$_POST[dumed][$x]."' type='text' style='width:100%' class='inpnovisibles' ></td>
								 <td style='width:6%'><input id='dref[]' name='dfecom[]' value='".$_POST[dfecom][$x]."' type='text' style='width:100%' class='inpnovisibles' >
								 <input id='dref[]' name='danio[]' value='".$_POST[danio][$x]."' type='hidden' style='width:100%' class='inpnovisibles' readonly></td>
								 <td style='width:2%'><input id='dref[]' name='dbloq[]' value='".$_POST[dbloq][$x]."' type='text' style='width:100%' class='inpnovisibles' readonly></td>
								 <td style='width:5%'><input id='dref[]' name='destado[]' value='".$_POST[destado][$x]."' type='text' style='width:100%' class='inpnovisibles' ></td>
								 <td style='width:10%'><input id='dref[]' name='dvalor[]' value='".$_POST[dvalor][$x]."' type='text' style='width:100%; text-align:right;' onBlur='sumaTotal()' class='inpnovisibles'></td>
								 <td style='width:1%'><input id='dref[]' name='dfoto[]' value='".$_POST[dfoto][$x]."' type='text' style='width:100%' class='inpnovisibles' readonly></td>
								 <td style='width:1%'><input id='dref[]' name='dficha[]' value='".$_POST[dficha][$x]."' type='text' style='width:100%' class='inpnovisibles' readonly></td>
								 <td style='width:5%'><input id='dterceros[]' name='dterceros[]' value='".$_POST[dterceros][$x]."' type='text' style='width:100%' class='inpnovisibles' readonly></td>
								 <td style='text-align:center;'><a href='#' onclick='eliminar($x)'><img src='imagenes/del.png'></a></td></tr>";
								 $aux=$iter;
								 $iter=$iter2;
								 $iter2=$aux;
								 $valact=str_replace(',','.',str_replace('.','',$_POST[dvalor][$x]));
								 $gtotal+=$valact;
							}
							echo "<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
									onMouseOut=\"this.style.backgroundColor=anterior\" >
									<td colspan='18'>TOTAL ACTIVOS ($)</td>
									<td style='width:2%'>
									<input name='totact' id='totact' value='".number_format($gtotal,2,',','.')."' type='text' style='width:100%; text-align:right;' class='inpnovisibles' readonly>
									</td>
								</tr>";
							?>
						</table>
					</div>
				
	</form>
	<?php 
	//********** GUARDAR EL COMPROBANTE ***********
	if($_POST[oculto]=='2')
	{
		//rutina de guardado cabecera
		$linkbd=conectar_bd();
		$sqlr="select *from configbasica where estado='S'";
		//echo $sqlr;
		$res=mysql_query($sqlr,$linkbd);
		while($row=mysql_fetch_row($res)) 
		{
		  	$nit=$row[0];
		  	$rs=$row[1];
	 	}
		if($_POST[tipomov]=='1')
		{
			$tipomovimiento='101';
			$testado='S';
			$estadc=1;
		}
		elseif($_POST[tipomov]='3')
		{
			$estadc=0;
			$tipomovimiento='301';
			$testado='R';
			$sqlr1="UPDATE acticrearact set estado='R' where codigo='$_POST[orden]' and tipo_mov='101'";
			mysql_query($sqlr1,$linkbd);
			$sqlr1="UPDATE acticrearact_det set estado='R' where codigo='$_POST[orden]' and tipo_mov='101'";
			mysql_query($sqlr1,$linkbd);
			$_POST[valor]=$_POST[valoracti];
		}
		$_POST[valor]=str_replace(".","",$_POST[valor]);
		ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
		$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
		$sqlr="insert into acticrearact(codigo, fechareg, origen, documento, valor, estado,tipo_mov) values ('$_POST[orden]', '$fechaf', '$_POST[origen]','$_POST[docgen]','$_POST[valdoc]', '$testado','$tipomovimiento')";
		//echo $sqlr;
		if(!mysql_query($sqlr,$linkbd)) 
		{
			echo "<script>despliegamodalm('visible','2','No se pudo ejecutar la petición');</script>";
		} 
		else
		{
			for ($x=0;$x< count($_POST[dclase]);$x++)
			{
				ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[dfecact][$x],$fecha);
				$fechafact=$fecha[3]."-".$fecha[2]."-".$fecha[1];
				ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[dfecom][$x],$fecha);
				$fechafcom=$fecha[3]."-".$fecha[2]."-".$fecha[1];
				$valact=str_replace(',','.',str_replace('.','',$_POST[dvalor][$x]));

				$nmesesdep=$_POST[danio][$x];
				if($nmesesdep==0) $nmesesdep==1;
				$vmendep=$valact/$nmesesdep;
				
				$sqlr="insert into acticrearact_det (codigo, placa, nombre, referencia, modelo, serial, unidadmed, fechacom, fechact, clasificacion, origen, area, ubicacion, grupo, cc, valor, mesesdepacum, saldomesesdep,valdepact, saldodepact, valdepmen, estadoactivo, foto, estado, fechaultdep, bloque, tipo, prototipo,ficha,dispoact,tipo_mov,vigencia) values ('$_POST[orden]','".$_POST[dplaca][$x]."', '".$_POST[dnombre][$x]."', '".$_POST[dref][$x]."','".$_POST[dmodelo][$x]."','".$_POST[dserial][$x]."', '".$_POST[dumed][$x]."','$fechafcom', '$fechafact','".$_POST[dclase][$x]."', '$_POST[origen]','".$_POST[darea][$x]."','".$_POST[dubi][$x]."','".$_POST[dgrupo][$x]."','".$_POST[dccs][$x]."',$valact,0,$nmesesdep,0,$valact,'$vmendep','".$_POST[destado][$x]."','".$_POST[dfoto][$x]."','$testado','','".$_POST[dbloq][$x]."','".$_POST[dtipo][$x]."','".$_POST[dproto][$x]."','".$_POST[dficha][$x]."','".$_POST[ddispo][$x]."','$tipomovimiento','".$vigusu."')";
				//echo $sqlr;
				mysql_query($sqlr,$linkbd);
				/*** crear responsable */
				$sqlr="insert into acticrearact_det_responsable (tercero,placa,estado) value ('".$_POST[dterceros][$x]."','".$_POST[dplaca][$x]."','S')";
				mysql_query($sqlr,$linkbd);
				/** */
			}
			//echo "<script>despliegamodalm('visible','1','Se ha almacenado con Exito');</script>";
			 $consec=$_POST[orden];
			 if($_POST[tipomov]=='1')
				{
			  $sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($consec,70,'$fechaf','CREACION ACTIVO FIJO $_POST[placa]',0,$_POST[valor],$_POST[valor],0,'1')";
			  
				}
				if($_POST[tipomov]=='3')
				{
				$sqlr="update comprobante_cab set estado='0' where numerotipo=$consec and tipo_comp=70";
				}
				//echo $sqlr;
			if(!mysql_query($sqlr,$linkbd)) 
			{
				echo "<table class='inicio'><tr><td class='saludo1'><center>No se ha creado el comprobante contable, <img src='imagenes\alert.png'> Error:".mysql_error().$sqlr."</center></td></tr></table>";
			}
			else
			{
				//**** detalle del comp contable
				$torigen=substr($_POST[origen],0,1);
				$origen=substr($_POST[origen],2);
				for ($x=0;$x< count($_POST[dclase]);$x++)
				{
					if($_POST[origen]=='07')
					{
						$fechaBase = cambiarFormatoFecha($_POST[fecha]);
						$cuentaCredito = buscaCuentaContable('01','CT',"$_POST[cc]",5,$fechaBase);
						if($cuentaCredito["cuenta"]!='')
						{
							/**** concepto contable */
							$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('70 $consec','".$cuentaCredito["cuenta"]."','".$nit."','".$_POST[cc]."','Cta Destino compra ".$origen."','',0,".$_POST[valor].",'$estadc','".$vigusu."')";
							//	echo "$sqlr <br>";
							mysql_query($sqlr,$linkbd); 
							
						}						
						$sqlr="Select * from acti_activos_det where disposicion_activos='".$_POST[ddispo][$x]."' AND centro_costos='$_POST[cc]' and tipo like '".substr($_POST[dplaca][$x],0,6)."'";
						$resp = mysql_query($sqlr,$link);
						//echo $sqlr;
						while ($row =mysql_fetch_row($resp)) 
						{
							$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('70 $consec','".$row[3]."','".$nit."','".$_POST[cc]."','Cta Clasificacion Activo ".$_POST[clasificacion]."','',".$_POST[valor].",0,'$estadc','".$vigusu."')";
							//echo "$sqlr <br>";
							mysql_query($sqlr,$linkbd);  				
						}
					}
				}
		  	}echo "<script>despliegamodalm('visible','1','Se ha almacenado el Detalle del Ingreso con Exito');</script>";
		}
	}
	?>	
</td></tr>     
</table>
		<div id="bgventanamodal2">
            <div id="ventanamodal2">
                <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                </IFRAME>
            </div>
   	 	</div>
</body>
</html>