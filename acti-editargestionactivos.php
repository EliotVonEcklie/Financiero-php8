<!--V 1.0 24/02/2015-->
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
	$scroll=$_GET['scrtop'];
	$totreg=$_GET['totreg'];
	$idcta=$_GET['clase'];
	$altura=$_GET['altura'];
	$filtro="'".$_GET['clase']."'";
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
<script type="text/javascript" src="css/calendario.js"></script>
		<script type='text/javascript' src='JQuery/jquery-2.1.4.min.js'></script>
		<script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/sweetalert.js"></script>
<script type="text/javascript" src="css/sweetalert.min.js"></script>
<script type="text/javascript" src="css/funciones.js"></script>
	
	<link href="css/sweetalert.css" rel="stylesheet" type="text/css" />
		<script>
			function guardar()
			{
				var validacion03=document.getElementById('fc_1198971545').value;
				if(validacion03.trim()!=''){
					despliegamodalm('visible','4','Esta Seguro de Guardar','1');
				}
				else {
					despliegamodalm('visible','2','Falta informacion para Crear Activos');
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
						document.getElementById('orden').focus();
						document.getElementById('orden').select();
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
			function despliegamodal2(_valor,v)
			{
				//alert("dd"+v);
				if(v!='')
				{
					//alert("dd"+_valor);
					document.getElementById("bgventanamodal2").style.visibility=_valor;
					if(_valor=="hidden"){
					//	alert("fe"+v);
						document.getElementById('ventana2').src="";
						document.form2.submit();
					}
					else {
						//alert("dd"+v);
						if(v=='T')	{document.getElementById('ventana2').src="terceros-ventana1.php";}
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
			function funcionmensaje()
			{
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
			function agregardetalle()
			{
				if(document.form2.origen.value!="" && document.form2.clasificacion.value!="" && document.form2.grupo.value!="" && document.form2.tipo.value!="" && document.form2.fechact.value!="" )
				{ 
					document.form2.agregadet.value=1;
					document.form2.submit();
				}
				else {
					despliegamodalm('visible','2','Falta informacion para poder Agregar');
				}
			}
			function eliminar(variable){despliegamodalm('visible','5','Esta Seguro de Eliminar','2',variable);}
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
				document.form2.oculto.value="7";
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
				document.getElementById('valdoc').value='';
				document.getElementById('foto').value='';
				document.getElementById('ficha').value='';
				document.getElementById('saldo').value='';
				document.getElementById('placa').value='';
				document.getElementById('tercero').value='';
				document.getElementById('ntercero').value='';
				document.getElementById('valdep').value='1';
			}
			function validar(){document.form2.submit();}
			function creaplaca()
			{
				if($('#tabact >tbody >tr').length > 2){
					clasi=document.getElementById("clasificacion").value;	
					grup=document.getElementById("grupo").value;	
					cons=document.getElementById("consecutivo").value;	;
					document.getElementById("placa").value=clasi+''+grup+''+cons;
					//document.form2.submit();
				}
			}
			function valDep()
			{
				if($('#chkdep').is(":checked")){
					$('#agedep').attr('readonly','readonly');
					$('#agedep').val('0');
					$('#valdep').val('1');
				}
				else{
					$('#agedep').removeAttr('readonly');
					$('#valdep').val('0');
				}
			}
			function adelante(scrtop,totreg,altura,numpag,limreg,clase, maximo)
			{
				vaciar();
				document.getElementById('oculto').value='1';
				clase=parseInt(clase)+1;
				if (parseInt(clase)<=parseInt(maximo)) 
				{
					document.form2.action="acti-editargestionactivos.php?scrtop="+scrtop+"&totreg="+totreg+"&altura="+altura+"&numpag="+numpag+"&limreg="+limreg+"&clase="+clase;
					document.form2.submit();
				}
			}
			function atrasc(scrtop,totreg,altura,numpag,limreg,clase)
			{
				vaciar();
				document.getElementById('oculto').value='1';
				clase=parseInt(clase)-1;
				if (clase!='0') 
				{
					document.form2.action="acti-editargestionactivos.php?scrtop="+scrtop+"&totreg="+totreg+"&altura="+altura+"&numpag="+numpag+"&limreg="+limreg+"&clase="+clase;
					document.form2.submit();
				}
			}
			function iratras(scrtop='', numpag='', limreg='', clase='')
			{
				var idcta=document.getElementById('orden').value;
				location.href="acti-buscagestionactivos.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&clase="+clase;
			}
			function pdf()
			{
				document.form2.action="pdfactivos.php";
				document.form2.target="_BLANK";
				document.form2.submit();
				document.form2.action="";
				document.form2.target="";
			}
			function excell()
			{
					document.form2.action="gestionactivosexcel.php";
					document.form2.target="_BLANK";
					document.form2.submit(); 
					document.form2.action="";
					document.form2.target="";
			}
			function marcar(objeto,posicion)
			{	
				if(objeto.checked)
				{
					vaciar();
					var pagoscheck=document.getElementsByName('pagosselec[]');
					var pla=document.getElementsByName('dplaca[]');
					var cla=document.getElementsByName('dclase[]');
					var gru=document.getElementsByName('dgrupo[]');
					var tip=document.getElementsByName('dtipo[]');
					var pro=document.getElementsByName('dproto[]');
					var are=document.getElementsByName('darea[]');
					var ubi=document.getElementsByName('dubi[]');
					var ccs=document.getElementsByName('dccs[]');
					var dis=document.getElementsByName('ddispo[]');
					var fea=document.getElementsByName('dfecact[]');
					var nom=document.getElementsByName('dnombre[]');
					var ref=document.getElementsByName('dref[]');
					var mod=document.getElementsByName('dmodelo[]');
					var ser=document.getElementsByName('dserial[]');
					var ume=document.getElementsByName('dumed[]');
					var fec=document.getElementsByName('dfecom[]');
					var ani2=document.getElementsByName('dbloq[]');
					var ani=document.getElementsByName('danio[]');
					var est=document.getElementsByName('destado[]');
					var val=document.getElementsByName('dvalor[]');
					var fot=document.getElementsByName('dfoto[]');
					var fic=document.getElementsByName('dficha[]');
					var terc=document.getElementsByName('dterceros[]');
					document.getElementsByName('tabgroup1').value=2;
					document.form2.clasificacion.value=cla.item(posicion).value
					document.form2.placa.value=pla.item(posicion).value
					document.form2.tipo.value=tip.item(posicion).value
					document.form2.grupo.value=gru.item(posicion).value
					document.form2.prototipo.value=pro.item(posicion).value
					document.form2.ubicacion.value=ubi.item(posicion).value
					document.form2.area.value=are.item(posicion).value
					document.form2.dispactivos.value=dis.item(posicion).value
					document.form2.cc.value=ccs.item(posicion).value
					document.form2.fechact.value=fea.item(posicion).value
					document.form2.nombre.value=nom.item(posicion).value
					document.form2.referencia.value=ref.item(posicion).value
					document.form2.modelo.value=mod.item(posicion).value
					document.form2.serial.value=ser.item(posicion).value
					document.form2.unimed.value=ume.item(posicion).value
					document.form2.fechac.value=fec.item(posicion).value
					document.form2.estadoact.value=est.item(posicion).value
					document.form2.valor.value=val.item(posicion).value
					document.form2.foto.value=fot.item(posicion).value
					document.form2.ficha.value=fic.item(posicion).value
					document.form2.tercero.value=terc.item(posicion).value
					bterceros('tercero','ntercero');
					document.form2.valdep.value=ani2.item(posicion).value
					document.form2.agedep.value=ani.item(posicion).value
					if(ani2.item(posicion).value=='1'){$('#chkdep').attr('checked',true);}
					else{$('#chkdep').attr('checked',false);}
					pagoscheck.item(posicion).checked=true;
					valDep();
				}
				else 
				{
					if (parseFloat(valasignado.item(posicion).value) == parseFloat(valdisponible.item(posicion).value)){pagoscheck.item(posicion).checked=false;}	
					else{pagoscheck.item(posicion).checked=true;}	
				}
				document.form2.submit();
			}
			function vaciar()
			{
				document.form2.clasificacion.value=''
				document.form2.tipo.value=''
				document.form2.grupo.value=''
				document.form2.prototipo.value=''
				document.form2.ubicacion.value=''
				document.form2.area.value=''
				document.form2.dispactivos.value=''
				document.form2.cc.value=''
				document.form2.fechact.value=''
				document.form2.nombre.value=''
				document.form2.referencia.value=''
				document.form2.modelo.value=''
				document.form2.serial.value=''
				document.form2.unimed.value=''
				document.form2.fechac.value=''
				document.form2.valdep.value=''
				document.form2.agedep.value=''
				document.form2.estadoact.value=''
				document.form2.valor.value=''
				document.form2.foto.value=''
				document.form2.ficha.value=''
				document.form2.tercero.value=''
				document.form2.ntercero.value=''
				document.form2.placa.value=''
			}
			function acta()
			{
				

				document.form2.action="pdfactaactivo.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
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
				//alert(suma);
				var comparaValorRp = comparaValoresConRp(suma);
				if(comparaValorRp)
				{
					document.getElementById('totact').value=suma.format(2, 3, '.', ',');
				}
				else
				{
					despliegamodalm('visible','2','El valor total de los activos superan el valor del RP.');
				}
			}
			function comparaValoresConRp(suma)
			{
				var valorRp = document.getElementById('valdoc').value;
				if(valorRp >= suma)
				{
					return true;
				}
				else
				{
					return false;
				}
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<?php
			if($_POST[oculto]=="")
			{
				$_POST[tabgroup1]=1;
				$_POST[valdep]="1";
			}
			if($_POST[oculto]=="1")
			{
				unset($_POST[dfecha]);
				unset($_POST[dcc]);
				unset($_POST[dactivos]);
				unset($_POST[dactiva]);
				unset($_POST[dnactiva]);		 
				unset($_POST[drecup]);
				unset($_POST[dnrecup]);		 
				unset($_POST[dper]);
				unset($_POST[dnper]);		 
				unset($_POST[dret]);
				unset($_POST[dnret]);		 
			}
		?> 
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<?php
			$numpag=$_GET[numpag];
			$limreg=$_GET[limreg];
			$scrtop=26*$totreg;
		?>
		<table>
			<tr><script>barra_imagenes("acti");</script><?php cuadro_titulos();?></tr>
			<tr><?php menu_desplegable("acti");?></tr>
			<tr>
				<td colspan="3" class="cinta"><img src="imagenes/add.png"  title="Nuevo" onClick="location.href='acti-gestionactivos.php'" class="mgbt"/><img src="imagenes/guarda.png" title="Guardar" onClick="guardar()" class="mgbt"/><img src="imagenes/busca.png"  title="Buscar" onClick="location.href='acti-buscagestionactivos.php'" class="mgbt"/><img src="imagenes/agenda1.png" onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt" title="Agenda"/><img src="imagenes/nv.png" onClick="mypop=window.open('acti-principal.php','','');mypop.focus();" class="mgbt" title="Nueva Ventana"/><img src="imagenes/print.png" title="Reporte Pdf" onClick="pdf()" class="mgbt"/><img src="imagenes/excel.png"  title="Reporte Excel" class="mgbt" onClick="excell();"/><img src="imagenes/iratras.png" title="Atr&aacute;s" onClick="iratras(<?php echo "$scrtop, $numpag, $limreg, $filtro";?>)" class="mgbt"/></td>
			</tr>
		</table>
		<?php
			$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
			$vigencia=$vigusu;
			$linkbd=conectar_bd();
			$sqlr="SELECT * from  acticrearact ORDER BY codigo DESC";
			$res=mysql_query($sqlr,$linkbd);
			$r=mysql_fetch_row($res);
			$_POST[maximo]=$r[0];
			$_POST[tipo_mov]=$r[6];
			if(($_POST[oculto]!="2")&&($_POST[oculto]!="7"))
			{
				unset($_POST[dplaca]);
				unset($_POST[dnombre]);
				unset($_POST[dref]);
				unset($_POST[dmodelo]);
				unset($_POST[dserial]);
				unset($_POST[dumed]);
				unset($_POST[dfecom]);
				unset($_POST[dfecact]);
				unset($_POST[dclase]);
				unset($_POST[darea]);
				unset($_POST[dubi]);
				unset($_POST[dgrupo]);
				unset($_POST[dccs]);
				unset($_POST[ddispo]);
				unset($_POST[dvalor]);
				unset($_POST[destado]);
				unset($_POST[dfoto]);
				unset($_POST[dbloq]);
				unset($_POST[dtipo]);
				unset($_POST[dproto]);
				unset($_POST[dficha]);
				unset($_POST[dterceros]);
				
				//$sqlr="select * from acticrearact_det where codigo='$_GET[clase]' and tipo_mov='101'";
				$sqlr="select acticrearact_det.* from acticrearact_det where codigo='$_GET[clase]' and tipo_mov='101'";
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
					$_POST[danio][$i]=$row["nummesesdep"];		 
					$_POST[dubi][$i]=$row["ubicacion"];		 
					$_POST[dgrupo][$i]=$row["grupo"];		 
					$_POST[dccs][$i]=$row["cc"];		 
					$_POST[ddispo][$i]=$row["dispoact"];		 
					$_POST[dvalor][$i]=$row["valor"];		 
					$_POST[destado][$i]=$row["estadoactivo"];	 
					$_POST[dfoto][$i]=$row["foto"];		 
					$_POST[dbloq][$i]=$row["bloque"];		 
					$_POST[dtipo][$i]=$row["tipo"];		 
					$_POST[dproto][$i]=$row["prototipo"];
					$_POST[dficha][$i]=$row["ficha"];
					$_POST[dterceros][$i]=$row["responsable"];
					$i++;
				}
			}
			switch($_POST[tabgroup1])
			{
				case 1:	$check1='checked';break;
				case 2:	$check2='checked';break;
			}
			$sqlr="select * from acticrearact where codigo='$_GET[clase]'";
			$res=mysql_query($sqlr,$linkbd);
			$row=mysql_fetch_row($res);
			$_POST[orden]=$row[0];		 
			$_POST[fecha]=$row[1];		 
			$_POST[origen]=$row[2];		 
			$_POST[docgen]=$row[3];		 
			$_POST[valdoc]=$row[4];		 		 
		?>
		<div id="bgventanamodalm" class="bgventanamodalm">
			<div id="ventanamodalm" class="ventanamodalm">
				<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"></IFRAME>
			</div>
		</div>
		<form name="form2" method="post" action=""> 
			<?php 
  				if($_POST[bc]=='1')//**** busca cuenta
				{
					$nresul=buscacuenta($_POST[cuenta]);
					if($nresul!='') {$_POST[ncuenta]=$nresul;}
					else{$_POST[ncuenta]="";}
				}
				if($_POST[bcc]=='1')//**** busca centro costo
				{
					$nresul=buscacentro($_POST[cc]);
					if($nresul!=''){$_POST[ncc]=$nresul;}
					else {$_POST[ncc]="";}
				}
			?>
		<table class="inicio" align="center"  >
			<tr>
				<td class="titulos" colspan="10">.: Gestion de Activos - Activar</td>
                <td class="cerrar" style="width:7%" onClick="location.href='acti-principal.php'">Cerrar</td>
			</tr>
			<tr>
				<td class="saludo1">Orden:</td>
				<td valign="middle" >
               		<a onclick='atrasc("<?php echo $_GET[scrtop] ?>", "<?php echo $_GET[totreg] ?>", "<?php echo $_GET[altura] ?>", "<?php echo $_GET[numpag] ?>", "<?php echo $_GET[limreg] ?>","<?php echo $_GET[clase] ?>")' style="cursor:pointer;">
               			<img src="imagenes/back.png" alt="siguiente" align="absmiddle">
           			</a>
					<input type="text" id="orden" name="orden" style="width:50%; text-align:center;" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[orden]?>" readonly>
					<input type="hidden" id="consecutivo" name="consecutivo" value="<?php echo $_POST[consecutivo]?>" readonly>
					<input type="hidden" id="vigencia" name="vigencia" value="<?php echo $_POST[vigencia]=$vigusu; ?>" readonly>
           			<a onclick='adelante("<?php echo $_GET[scrtop] ?>", "<?php echo $_GET[totreg] ?>", "<?php echo $_GET[altura] ?>", "<?php echo $_GET[numpag] ?>", "<?php echo $_GET[limreg] ?>","<?php echo $_GET[clase] ?>", "<?php echo $_POST[maximo] ?>")' style="cursor:pointer;"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a>
				</td>
				<td>
	 				<select name="tipomov" id="tipomov" onKeyUp="return tabular(event,this)" onChange="validar()">
						<?php
							$codMovimiento='101';
							if(isset($_POST['movimiento']))
							{
								if(!empty($_POST['movimiento']))
									$codMovimiento=$_POST['movimiento'];
							}
							$sql="SELECT tipo_mov FROM acticrearact where codigo=$_POST[orden] ORDER BY tipo_mov";
							$resultMov=mysql_query($sql,$linkbd);
							$movimientos=Array();
							$movimientos["101"]["nombre"]="101-Documento de Creacion";
							$movimientos["101"]["estado"]="";
							$movimientos["301"]["nombre"]="301-Reversion Total";
							$movimientos["301"]["estado"]="";
							while($row = mysql_fetch_row($resultMov))
							{
								$mov=$movimientos[$row[0]]["nombre"];
								$movimientos[$codMovimiento]["estado"]="selected";
								$state=$movimientos[$row[0]]["estado"];
								echo "<option value='$row[0]' $state>$mov</option>";
							}
							$movimientos[$codMovimiento]["estado"]="";
							echo "<input type='hidden' id='movimiento' name='movimiento' value='$_POST[movimiento]' readonly/>";
						?>
					</select>
	 			</td>
				<td class="saludo1">Fecha:</td>
				<td>
					<input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" readonly />         <a href="#" onClick="displayCalendarFor('fc_1198971545');"></a>        
					<input type="hidden" name="chacuerdo" value="1">
				</td>
				<td class="saludo1">Origen:</td>
				<td>
				<input type="hidden" name="origen" id="origen" value="<?php echo $_POST[origen];?>">
				<select id="origen1" name="origen1" onChange="validar()" style="width:90%">
					<?php
					$link=conectar_bd();
					$tipo=substr($_POST[tipo_mov],1);
					$sqlr="Select * from acti_tipomov where estado='S' and codigo='$_POST[origen]' and codigo!='06' and tipom=$tipo";
		 			$resp = mysql_query($sqlr,$link);
				    while ($row =mysql_fetch_row($resp)) 
				    {
						if($row[0]==$_POST[origen]){echo "<option value='$row[0]'SELECTED>$row[0] - $row[2]</option>";}
						else{echo "<option value='$row[0]'>$row[0] - $row[2]</option>";}
					}
					?>
				</select>
				</td>
				<td class="saludo1">Documento:</td>
				<td>
					<input name="docgen" type="text" id="docgen" size="10" value="<?php echo $_POST[docgen]; ?>" onKeyUp="return tabular(event,this)" readonly />
					<?php
					$busdoc="'".$_POST[origen]."'";
					echo'<img src="imagenes/find02.png" style="width:20px;" onClick="despliegamodal2(\'visible\','.$busdoc.');" title="Buscar Documento" class="icobut" />';
					?>
				</td>
				<td class="saludo1">Valor:</td>
				<td valign="middle" >
					<input type="text" name="valdoc"  id="valdoc" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[valdoc];?>" size="20" style="text-align:right;" readonly />
					<?php
					$sqlsal="SELECT ACD.valor FROM acticrearact_det ACD, acticrearact ACT WHERE ACT.documento='$_POST[docgen]' AND ACD.codigo=ACT.codigo AND ACT.tipo_mov='101' AND ACD.vigencia='$vigusu' AND ACD.estado='S'";
					$resal=mysql_query($sqlsal,$linkbd);
					$sum=0;
					$c=0;
					while($rsal=mysql_fetch_row($resal)){$sum+=$rsal[$c];$c;}
					$_POST[saldo]=$_POST[valdoc]-$sum;
					?>
				</td>         	    
			</tr>          
		</table>   
		<div class="tabs" style="min-height: 190px !important;">
			<div class="tab">
				<input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
				<label for="tab-1">Clasificacion</label>
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
			</div>
		</div>
		<div class="tab">
			<input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?>>
			<label for="tab-2">Informacion Actvo Fijo</label>
			<div class="content" style="overflow-x:hidden; height:170px">
				<table class="inicio">
					<tr>
						<td colspan="10" class="titulos2">Informacion Activo Fijo</td>
					</tr>
					<tr>
						<td style="width:10%" class="saludo1">Nombre:</td>
						<td colspan="5">
							<input type="text" id="nombre" name="nombre" style="width:86.5%" onKeyUp="return tabular(event,this)"  style="text-transform:uppercase;" value="<?php echo $_POST[nombre]?>" />
						</td>
						
						<td style="width:8%" class="saludo1">Ref:</td>
						<td style="width:8%">
							<input type="text" id="referencia" name="referencia" style="width:61%" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[referencia]?>"/>
						</td>
						<td class="saludo1" >Modelo:</td>
						<td >
							<input type="text" id="modelo" name="modelo" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[modelo]?>"/>
						</td>
					</tr>
					<tr>
						<td class="saludo1">Serial:</td>
						<td style="width:10%">
							<input type="text" id="serial" name="serial" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[serial]?>"/>
						</td>
						<td>
						</td>
						<td style="width:10%" class="saludo1">Fecha Compra: </td>
						<td style="width:8%">
							<input name="fechac" type="text" value="<?php echo $_POST[fechac]?>" maxlength="10" size="15" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971547" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY"/>&nbsp;<img src="imagenes/calendario04.png" style="width:20px; cursor:pointer;" title="Calendario"  onClick="displayCalendarFor('fc_1198971547');" class="icobut"/>
						</td>
						<td></td>
						<td class="saludo1">Fecha Activacion:</td>
						<td>
							<input name="fechact" type="text" id="fc_1198971546" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fechact]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10"/>&nbsp;<img src="imagenes/calendario04.png" style="width:20px; cursor:pointer;" title="Calendario"  onClick="displayCalendarFor('fc_1198971546');" class="icobut"/>
						</td>
						<td class="saludo1">Unidad Medida:</td>
						<td>
							<select name="unimed" id="unimed">
							   <option value="" >Seleccione...</option>
							   <option value="1" <?php if($_POST[unimed]=='1') echo "SELECTED"; ?>>Unidad</option>
							   <option value="2" <?php if($_POST[unimed]=='2') echo "SELECTED"; ?>>Juego</option>
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
							<input type="text" id="agedep" name="agedep" size="5" value="<?php echo $_POST[agedep]?>" style="text-align:center;" />
							Meses
							<?php echo"<script>valDep();</script>";?>
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
							<input type="text" name="valor1" id="valor1" onBlur="sinpuntitos('valor','valor1')" onKeyPress="javascript:return solonumeros(event)" onKeyUp="puntitos(this,this.value.charAt(this.value.length-1))" value='<?php echo $_POST[valor1]?>' style="text-align:right;"/> 
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
							<input name="saldo" type="text" id="saldo" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[saldo]; ?>" readonly />
							
						</td>
					</tr>
					<tr>
						<td class="saludo1">Placa:</td>
							<td valign="middle" >
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
								
								/***fin codigo anterior */
								$_POST[placa]=$auxil.$nconsec;
							?>
							<input name="placa" id="placa" type="text" value="<?php echo $_POST[placa]; ?>" readonly></td>
						</td>
						<td></td><td class="saludo1" style="width:8%;">Responsable:</td>
          					<td style="width:12%;" colspan='2'><input type="text" id="tercero" name="tercero" style="width:80%;" onKeyUp="return tabular(event,this)" onBlur="bterceros('tercero','ntercero')" value="<?php echo $_POST[tercero]?>"onKeyDown="llamadoesc(event,'2')"><input type="hidden" value="0" name="bt" id="bt">
           					 <a onClick="despliegamodal2('visible','T');" style='cursor:pointer;'><img src="imagenes/find02.png" style="width:20px;"></a></td>
          					<td colspan='2'><input type="text" name="ntercero" id="ntercero" value="<?php echo $_POST[ntercero]?>" style="width:100%" readonly/></td>
						<td>
							<input type="button" name="agrega" value="Agregar Activo" onClick="agregardetalle()">
							<input type="hidden" value="0" name="agregadet"> 
							<input name="actuaresponsable" id="actuaresponsable" type="button" value="Actualizar Responsable" onClick="actualizaresponsable('placa','tercero')" >
							
						</td>
						<td>
							<input name="generaracta" id="generaracta" type="button" value="Generar Acta"  onClick="acta()" >
						</td>
					</tr>
				</table>    
			</div>
		</div>
	</div>
	<div class="subpantallac" style="height:35%; width:99.6%;">
	<table class="inicio" id="tabact">
		<tr>
			<td class="titulos" colspan="24">Detalles</td>
		</tr>
		<tr>
			<td class="titulos2" style="width:7%">Placa</td>
			<td class="titulos2" style="width:2%">Clase</td>
			<td class="titulos2" style="width:2%">Grupo</td>
			<td class="titulos2" style="width:3%">Tipo</td>
			<td class="titulos2" style="width:5%">Prototipo</td>
			<td class="titulos2" style="width:2%">Dependencia</td>
			<td class="titulos2" style="width:5%">Ubicacion</td>
			<td class="titulos2" style="width:2%">C.C</td>
			<td class="titulos2" style="width:5%">Disposici&oacute;n</td>
			<td class="titulos2" style="width:5%">Activacion</td>
			<td class="titulos2" style="width:10%">Nombre</td>
			<td class="titulos2" style="width:5%">Referencia</td>
			<td class="titulos2" style="width:5%">Modelo</td>
			<td class="titulos2" style="width:5%">Serial</td>
			<td class="titulos2" style="width:4%">U.Medida</td>
			<td class="titulos2" style="width:6%">Compra</td>
			<td class="titulos2" style="width:5%">Dep Bloque</td>
			<td class="titulos2" style="width:5%">Estado</td>
			<td class="titulos2" style="width:10%">Valor</td>
			<td class="titulos2" style="width:1%">Foto</td>
			<td class="titulos2" style="width:1%">Ficha</td>
			<td class="titulos2" style="width:5%">Responsable</td>
			<td class="titulos2" style="width:5%"><img src="imagenes/del.png" ><input type='hidden' name='elimina' id='elimina'></td>
		</tr>
	<?php	
	//echo "<br>posic:".$_POST[elimina];		 
	if ($_POST[elimina]!='')
	 { 		 
		 $posi=$_POST[elimina];
		// echo "<br>posic:".$_POST[elimina];
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
	}
	
	if ($_POST[agregadet]=='1')
	{
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
		$_POST[danio][]=$_POST[agedep];		 		 
		$_POST[destado][]=$_POST[estadoact];		 		 
		$_POST[dfoto][]=$_POST[foto];	
		$_POST[dficha][]=$_POST[ficha];
		$_POST[dterceros][]=$_POST[tercero];
		$_POST[agregadet]=0;
		echo"<script>
			$('#placa').val('');
			$('#nombre').val('');
			$('#modelo').val('');
			$('#referencia').val('');
			$('#cc').val('');
			$('#serial').val('');
			$('#unimed').val('');
			$('#fc_1198971547').val('');
			$('#valor').val('');
			$('#valdep').val('');
			$('#agedep').val('');
			$('#estadoact').val('');
			$('#foto').val('');
			$('#ficha').val('');
		</script>";
		 
	}
		$iter='zebra1';
		$iter2='zebra2';
		$gtotal=0;
		for ($x=0;$x< count($_POST[dclase]);$x++)
		{
			if($_POST[dfoto][$x]!='')
			{
				$rutaarchivo="informacion/proyectos/temp/".$_POST[dfoto][$x];
				$imagen="imagenes/descargar.png";
				$target1='_blank';
			}else
			{
				$rutaarchivo="#";
				$imagen="imagenes/descargard.png";
				$target1='';
			}
			if($_POST[dficha][$x]!='')
			{
				$rutaarchivoficha="informacion/proyectos/temp/".$_POST[dficha][$x];
				$imagenf="imagenes/descargar.png";
				$target12='_blank';
			}else
			{
				$rutaarchivoficha="#";
				$imagenf="imagenes/descargard.png";
				$target12='';
			}
			$chk='';
			$ch=esta_en_array($_POST[pagosselec], $_POST[dplaca][$x]);
			if($ch==1 || $_POST[actcheck]==1)
			{
				$chk="checked";
			}		
			echo "<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
				onMouseOut=\"this.style.backgroundColor=anterior\" >
				<td style='width:10%'><input name='dplaca[]' value='".$_POST[dplaca][$x]."' type='text' class='inpnovisibles' style='width:100%' readonly></td>
				<td style='width:1%'><input name='dclase[]' value='".$_POST[dclase][$x]."' type='text' style='width:100%' class='inpnovisibles' readonly></td>
				<td style='width:2%'><input name='dgrupo[]' value='".$_POST[dgrupo][$x]."' type='text' style='width:100%' class='inpnovisibles' readonly></td>
				<td style='width:2%'><input name='dtipo[]' value='".$_POST[dtipo][$x]."' type='text' style='width:100%' class='inpnovisibles' readonly></td>
				<td style='width:2%'><input name='dproto[]' value='".$_POST[dproto][$x]."' type='text' style='width:100%' class='inpnovisibles' readonly></td>
				<td style='width:2%'><input name='darea[]' value='".$_POST[darea][$x]."' type='text' style='width:100%' class='inpnovisibles' ></td>
				<td style='width:5%'><input name='dubi[]' value='".$_POST[dubi][$x]."' type='text' style='width:100%' class='inpnovisibles'></td>
				<td style='width:2%'><input name='dccs[]' value='".$_POST[dccs][$x]."' type='text' style='width:100%' class='inpnovisibles'></td>
				<td style='width:5%'><input name='ddispo[]' value='".$_POST[ddispo][$x]."' type='text' style='width:100%' class='inpnovisibles'></td>
				<td style='width:6%'><input name='dfecact[]' value='".$_POST[dfecact][$x]."' type='text' style='width:100%' class='inpnovisibles' ></td>
				<td style='width:10%'><input name='dnombre[]' value='".$_POST[dnombre][$x]."' type='text' style='width:100%' class='inpnovisibles' ></td>
				<td style='width:5%'><input name='dref[]' value='".$_POST[dref][$x]."' type='text' style='width:100%' class='inpnovisibles'></td>
				<td style='width:5%'><input name='dmodelo[]' value='".$_POST[dmodelo][$x]."' type='text' style='width:100%' class='inpnovisibles'></td>
				<td style='width:5%'><input name='dserial[]' value='".$_POST[dserial][$x]."' type='text' style='width:100%' class='inpnovisibles'></td>
				<td style='width:5%'><input name='dumed[]' value='".$_POST[dumed][$x]."' type='text' style='width:100%' class='inpnovisibles'></td>
				<td style='width:5%'><input name='dfecom[]' value='".$_POST[dfecom][$x]."' type='text' style='width:100%' class='inpnovisibles'><input name='danio[]' value='".$_POST[danio][$x]."' type='hidden' style='width:100%' class='inpnovisibles' readonly></td>
				<td style='width:2%'><input name='dbloq[]' value='".$_POST[dbloq][$x]."' type='text' style='width:100%' class='inpnovisibles' readonly></td>
				<td style='width:5%'><input name='destado[]' value='".$_POST[destado][$x]."' type='text' style='width:100%' class='inpnovisibles'></td>
				<td style='width:10%'><input name='dvalor[]' value='".$_POST[dvalor][$x]."' type='text' onBlur='sumaTotal()' style='width:100%; text-align:right;' class='inpnovisibles'></td>
				<td style='width:1%'><input name='dfoto[]' value='".$_POST[dfoto][$x]."' type='hidden' style='width:100%' class='inpnovisibles' readonly><a href='$rutaarchivo' target='$target1' ><img src='$imagen'  title='(Descargar)' ></td>
				<td style='width:1%'><input name='dficha[]' value='".$_POST[dficha][$x]."' type='hidden' style='width:100%' class='inpnovisibles' readonly><a href='$rutaarchivoficha' target='$target12' ><img src='$imagenf'  title='(Descargar)' ></td>
				<td style='width:5%'><input name='dterceros[]' value='".$_POST[dterceros][$x]."' type='text' style='width:100%' class='inpnovisibles' readonly></td>
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
				<td style='width:2%'><input name='totact' id='totact' value='".number_format($gtotal,2,',','.')."' type='text' style='width:100%; text-align:right;' class='inpnovisibles' readonly></td>
			</tr>";
		 ?>
	</table>
	</div>
	</form>
	<?php 
	//********** GUARDAR EL COMPROBANTE ***********
	if($_POST[oculto]=='2'){

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
		if($_POST[tipomov]=='101')
		{
			$tipomovimiento='101';
			$testado='S';
			$estadc=1;
		}
		elseif($_POST[tipomov]='301')
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
		$sqlrActualizar = "UPDATE acticrearact SET valor='$_POST[valdoc]' WHERE codigo='$_POST[orden]' and tipo_mov='101'";
		if(!mysql_query($sqlrActualizar,$linkbd)) 
		{
			echo "<script>despliegamodalm('visible','2','No se pudo ejecutar la petición');</script>";
		}
		else
		{
			$sqlrEliminaDetAct = "DELETE FROM acticrearact_det WHERE codigo='$_POST[orden]'";
			mysql_query($sqlrEliminaDetAct,$linkbd);
			
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
				mysql_query($sqlr,$linkbd);
				/*** crear responsable */
				$sqlr="insert into acticrearact_det_responsable (tercero,placa,estado) value ('".$_POST[dterceros][$x]."','".$_POST[dplaca][$x]."','S')";
				mysql_query($sqlr,$linkbd);
				/** */
			}
			$consec=$_POST[orden];
			if($_POST[tipomov]=='1')
			{
				$torigen=substr($_POST[origen],0,1);
				$origen=substr($_POST[origen],2);
				$sqlrEliminarCab = "DELETE FROM comprobante_det WHERE tipo_comp='70' AND numerotipo='$consec'";
				mysql_query($sqlrEliminarCab,$linkbd);
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
			}
			if($_POST[tipomov]=='3')
			{
				$sqlr="update comprobante_cab set estado='0' where numerotipo=$consec and tipo_comp=70";
			}
			if(!mysql_query($sqlr,$linkbd)) 
			{
				echo "<table class='inicio'><tr><td class='saludo1'><center>No se ha creado el comprobante contable, <img src='imagenes\alert.png'> Error:".mysql_error().$sqlr."</center></td></tr></table>";
			}
			else
			{
				echo "<script>despliegamodalm('visible','1','Se ha almacenado el Detalle del Ingreso con Exito');</script>";
			}
		}


		$linkbd=conectar_bd();
		$_POST[valor]=str_replace(".","",$_POST[valor]);
		ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
		$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
		ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechact],$fecha);
		$fechafact=$fecha[3]."-".$fecha[2]."-".$fecha[1];
		$nmesesdep=$_POST[agedep]*12;
		$vmendep=$_POST[valor]/$nmesesdep;
		$sqlr="UPDATE acticrearact_det SET nummesesdep='".$_POST[agedep]."', bloque='".$_POST[valdep]."' WHERE placa='$_POST[placa]'";
		if(!mysql_query($sqlr,$linkbd))
		 {
		  echo "<table class='inicio'><tr><td class='saludo1'><center>No Se ha Almacenado el Nuevo Activo, <img src='imagenes\alert.png'> Error:".mysql_error()."</center></td></tr></table>";
		 }
		 else
		 {
		  echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha Actualizado con Exito el Nuevo Activo <img src='imagenes\confirm.png'></center></td></tr></table>";		
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