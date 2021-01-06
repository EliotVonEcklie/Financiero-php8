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
		<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: SPID - Gestion Humana</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js"></script>
		<style>
			/*boton1*/
			.swparafiscal
			{position: relative; width: 71px;-webkit-user-select:none;-moz-user-select:none;-ms-user-select: none;}
			.swparafiscal-checkbox {display: none;}
			.swparafiscal-label 
			{display: block;overflow: hidden;cursor: pointer;border: 2px solid #DDE6E2;border-radius: 20px;}
			.swparafiscal-inner 
			{display: block;width: 200%;margin-left: -100%;transition: margin 0.3s ease-in 0s;}
			.swparafiscal-inner:before, .swparafiscal-inner:after 
			{display: block;float: left;width: 50%;height: 23px;padding: 0;line-height: 23px;font-size: 14px;color: white;font-family: Trebuchet, Arial, sans-serif;font-weight: bold;box-sizing: border-box;}
			.swparafiscal-inner:before 
			{content: "SI";padding-left: 10px;background-color: #51C3E0;color: #FFFFFF;}
			.swparafiscal-inner:after 
			{content: "NO";padding-right: 10px;background-color: #EEEEEE; color: #999999;text-align: right;}
			.swparafiscal-switch 
			{display: block;width: 17px;margin: 3px;background: #FFFFFF;position: absolute;top: 0;bottom: 0;right: 44px;border: 2px solid #DDE6E2;border-radius: 20px;transition: all 0.3s ease-in 0s;}
			.swparafiscal-checkbox:checked + .swparafiscal-label .swparafiscal-inner {margin-left: 0;}
			.swparafiscal-checkbox:checked + .swparafiscal-label .swparafiscal-switch {right: 0px;}
			/*boton2*/
			.swprovision
			{position: relative; width: 71px;-webkit-user-select:none;-moz-user-select:none;-ms-user-select: none;}
			.swprovision-checkbox {display: none;}
			.swprovision-label 
			{display: block;overflow: hidden;cursor: pointer;border: 2px solid #DDE6E2;border-radius: 20px;}
			.swprovision-inner 
			{display: block;width: 200%;margin-left: -100%;transition: margin 0.3s ease-in 0s;}
			.swprovision-inner:before, .swprovision-inner:after 
			{display: block;float: left;width: 50%;height: 23px;padding: 0;line-height: 23px;font-size: 14px;color: white;font-family: Trebuchet, Arial, sans-serif;font-weight: bold;box-sizing: border-box;}
			.swprovision-inner:before 
			{content: "SI";padding-left: 10px;background-color: #51C3E0;color: #FFFFFF;}
			.swprovision-inner:after 
			{content: "NO";padding-right: 10px;background-color: #EEEEEE; color: #999999;text-align: right;}
			.swprovision-switch 
			{display: block;width: 17px;margin: 3px;background: #FFFFFF;position: absolute;top: 0;bottom: 0;right: 44px;border: 2px solid #DDE6E2;border-radius: 20px;transition: all 0.3s ease-in 0s;}
			.swprovision-checkbox:checked + .swprovision-label .swprovision-inner {margin-left: 0;}
			.swprovision-checkbox:checked + .swprovision-label .swprovision-switch {right: 0px;}
			/*boton3*/
			.swsalud
			{position: relative; width: 71px;-webkit-user-select:none;-moz-user-select:none;-ms-user-select: none;}
			.swsalud-checkbox {display: none;}
			.swsalud-label 
			{display: block;overflow: hidden;cursor: pointer;border: 2px solid #DDE6E2;border-radius: 20px;}
			.swsalud-inner 
			{display: block;width: 200%;margin-left: -100%;transition: margin 0.3s ease-in 0s;}
			.swsalud-inner:before, .swsalud-inner:after 
			{display: block;float: left;width: 50%;height: 23px;padding: 0;line-height: 23px;font-size: 14px;color: white;font-family: Trebuchet, Arial, sans-serif;font-weight: bold;box-sizing: border-box;}
			.swsalud-inner:before 
			{content: "SI";padding-left: 10px;background-color: #51C3E0;color: #FFFFFF;}
			.swsalud-inner:after 
			{content: "NO";padding-right: 10px;background-color: #EEEEEE; color: #999999;text-align: right;}
			.swsalud-switch 
			{display: block;width: 17px;margin: 3px;background: #FFFFFF;position: absolute;top: 0;bottom: 0;right: 44px;border: 2px solid #DDE6E2;border-radius: 20px;transition: all 0.3s ease-in 0s;}
			.swsalud-checkbox:checked + .swsalud-label .swsalud-inner {margin-left: 0;}
			.swsalud-checkbox:checked + .swsalud-label .swsalud-switch {right: 0px;}
			/*boton4*/
			.swpension
			{position: relative; width: 71px;-webkit-user-select:none;-moz-user-select:none;-ms-user-select: none;}
			.swpension-checkbox {display: none;}
			.swpension-label 
			{display: block;overflow: hidden;cursor: pointer;border: 2px solid #DDE6E2;border-radius: 20px;}
			.swpension-inner 
			{display: block;width: 200%;margin-left: -100%;transition: margin 0.3s ease-in 0s;}
			.swpension-inner:before, .swpension-inner:after 
			{display: block;float: left;width: 50%;height: 23px;padding: 0;line-height: 23px;font-size: 14px;color: white;font-family: Trebuchet, Arial, sans-serif;font-weight: bold;box-sizing: border-box;}
			.swpension-inner:before 
			{content: "SI";padding-left: 10px;background-color: #51C3E0;color: #FFFFFF;}
			.swpension-inner:after 
			{content: "NO";padding-right: 10px;background-color: #EEEEEE; color: #999999;text-align: right;}
			.swpension-switch 
			{display: block;width: 17px;margin: 3px;background: #FFFFFF;position: absolute;top: 0;bottom: 0;right: 44px;border: 2px solid #DDE6E2;border-radius: 20px;transition: all 0.3s ease-in 0s;}
			.swpension-checkbox:checked + .swpension-label .swpension-inner {margin-left: 0;}
			.swpension-checkbox:checked + .swpension-label .swpension-switch {right: 0px;}
			/*boton5*/
			.swarl
			{position: relative; width: 71px;-webkit-user-select:none;-moz-user-select:none;-ms-user-select: none;}
			.swarl-checkbox {display: none;}
			.swarl-label 
			{display: block;overflow: hidden;cursor: pointer;border: 2px solid #DDE6E2;border-radius: 20px;}
			.swarl-inner 
			{display: block;width: 200%;margin-left: -100%;transition: margin 0.3s ease-in 0s;}
			.swarl-inner:before, .swarl-inner:after 
			{display: block;float: left;width: 50%;height: 23px;padding: 0;line-height: 23px;font-size: 14px;color: white;font-family: Trebuchet, Arial, sans-serif;font-weight: bold;box-sizing: border-box;}
			.swarl-inner:before 
			{content: "SI";padding-left: 10px;background-color: #51C3E0;color: #FFFFFF;}
			.swarl-inner:after 
			{content: "NO";padding-right: 10px;background-color: #EEEEEE; color: #999999;text-align: right;}
			.swarl-switch 
			{display: block;width: 17px;margin: 3px;background: #FFFFFF;position: absolute;top: 0;bottom: 0;right: 44px;border: 2px solid #DDE6E2;border-radius: 20px;transition: all 0.3s ease-in 0s;}
			.swarl-checkbox:checked + .swarl-label .swarl-inner {margin-left: 0;}
			.swarl-checkbox:checked + .swarl-label .swarl-switch {right: 0px;}
		</style>
		<script>
			function buscactap(e){if (document.form2.cuentap.value!=""){document.form2.bcp.value='1';document.form2.submit();}}
			function validar(){document.form2.submit();}
			function agregardetalle()
			{
				if(document.getElementById('concecont').value!="-1" )
				{document.form2.agregadet.value=1;document.form2.submit();}
 				else {despliegamodalm('visible','2','Falta información para poder Agregar Detalle');}
			}
			function eliminar(variable)
			{
				document.form2.elimina.value=variable;
				despliegamodalm('visible','4','Esta Seguro de Eliminar Detalle','1');
			}
			function guardar()
			{
				var validacion01=document.getElementById('nombre').value;
				if (document.form2.codigo.value!='' && validacion01.trim()!='' && document.getElementById('condeta').value != "0")
 				{despliegamodalm('visible','4','Esta Seguro de Guardar','2')}
 				else{despliegamodalm('visible','2','Faltan datos para completar el registro');}
			}
			function despliegamodal2(_valor)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else 
				{document.getElementById('ventana2').src="scuentasppto-ventana01.php?ti=2";}
			}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden")
				{
					document.getElementById('ventanam').src="";
					if (document.getElementById('valfocus').value!="0")
					{
						document.getElementById('valfocus').value='0';
						document.getElementById('cuentap').focus();
						document.getElementById('cuentap').select();
					}
				}
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
			function funcionmensaje(){document.location.href = "";}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.getElementById('oculto').value="6";
								document.form2.submit();break;
					case "2":	document.form2.oculto.value=2;
								document.form2.submit();break;
				}
			}
			function cambiocheck(id)
			{
				switch(id)
				{
					case "1":	if(document.getElementById('idswparafiscal').value=='S'){document.getElementById('idswparafiscal').value='N';}
								else{document.getElementById('idswparafiscal').value='S';}
								break;
					case "2":	if(document.getElementById('idswprovision').value=='S'){document.getElementById('idswprovision').value='N';}
								else{document.getElementById('idswprovision').value='S';}
								break;
					case "3":	if(document.getElementById('idswsalud').value=='S'){document.getElementById('idswsalud').value='N';}
								else{document.getElementById('idswsalud').value='S';}
								break;
					case "4":	if(document.getElementById('idswpension').value=='S'){document.getElementById('idswpension').value='N';}
								else{document.getElementById('idswpension').value='S';}
								break;
					case "5":	if(document.getElementById('idswarl').value=='S'){document.getElementById('idswarl').value='N';}
								else{document.getElementById('idswarl').value='S';}
								break;
				}
				document.form2.submit();
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("hum");</script><?php cuadro_titulos();?></tr>
			<tr><?php menu_desplegable("hum");?></tr>
			<tr>
				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='hum-variablesnomina.php'" class="mgbt"/><img src="imagenes/guarda.png"  title="Guardar" onClick="guardar();" class="mgbt"/><img src="imagenes/busca.png"  title="Buscar"  onClick="location.href='hum-buscavariablesnomina.php'" class="mgbt"/><img src="imagenes/nv.png" title="nueva ventana" onClick="mypop=window.open('hum-principal.php','','');mypop.focus();" class="mgbt"></td>
			</tr>
		</table>
		<div id="bgventanamodalm" class="bgventanamodalm">
			<div id="ventanamodalm" class="ventanamodalm">
				<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
				</IFRAME>
			</div>
		</div>
		<?php
			if($_POST[oculto]==""){$_POST[condeta]="0";}
			$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
			$vigencia=$vigusu;
			if(!$_POST[oculto])
			{
				$fec=date("d/m/Y");
				$_POST[fecha]=$fec;
				$_POST[tipo]='S';
				$_POST[valoradicion]=0;
				$_POST[valorreduccion]=0;
				$_POST[valortraslados]=0;
				$_POST[valor]=0;
				$sqlr="SELECT MAX(RIGHT(codigo,2)) FROM humvariables ORDER BY codigo Desc";
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
				$_POST[codigo]=$row[0]+1;
				if(strlen($_POST[codigo])==1){$_POST[codigo]='0'.$_POST[codigo];}
			}
		?>
		<form name="form2" method="post" action="">
			<input type="hidden" name="valfocus" id="valfocus" value="1"/>
			<table class="inicio" align="center" >
				<tr>
					<td class="titulos" colspan="10">.: Agregar Variable de Pago</td>
					<td style="width:7%"><label class="boton02" onClick="location.href='hum-principal.php'">Cerrar</label></td>
				</tr>
				<tr>
					<td class="tamano01" style="width:3cm;">Codigo:</td>
					<td style="width:5%;"><input type="text" name="codigo" id="codigo" value="<?php echo $_POST[codigo]?>" maxlength="2" style="width:98%" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" class="tamano02" readonly></td>
					<td class="tamano01" style="width:4cm;">Nombre Ingreso:</td>
					<td colspan="7"><input type="text"  name="nombre" id="nombre" value="<?php echo $_POST[nombre]?>" style="width:100%;" onKeyUp="return tabular(event,this)" class="tamano02"/></td>
				</tr>
				<tr>
					<td class="tamano01">Paga Salud:</td>
					<td >
						<div class="swsalud">
							<input type="checkbox" name="swsalud" class="swsalud-checkbox" id="idswsalud" value="<?php echo $_POST[swsalud];?>" <?php if($_POST[swsalud]=='S'){echo "checked";}?> onChange="cambiocheck('3');"/>
							<label class="swsalud-label" for="idswsalud">
								<span class="swsalud-inner"></span>
								<span class="swsalud-switch"></span>
							</label>
						</div>
					</td>
					<td class="tamano01">Paga Pensi&oacute;n:</td>
					<td style="width:10%;">
						<div class="swpension">
							<input type="checkbox" name="swpension" class="swpension-checkbox" id="idswpension" value="<?php echo $_POST[swpension];?>" <?php if($_POST[swpension]=='S'){echo "checked";}?> onChange="cambiocheck('4');"/>
							<label class="swpension-label" for="idswpension">
								<span class="swpension-inner"></span>
								<span class="swpension-switch"></span>
							</label>
						</div>
					</td>
					<td class="tamano01" style="width:3cm;">Paga ARL:</td>
					<td style="width:10%;">
						<div class="swarl">
							<input type="checkbox" name="swarl" class="swarl-checkbox" id="idswarl" value="<?php echo $_POST[swarl];?>" <?php if($_POST[swarl]=='S'){echo "checked";}?> onChange="cambiocheck('5');"/>
							<label class="swarl-label" for="idswarl">
								<span class="swarl-inner"></span>
								<span class="swarl-switch"></span>
							</label>
						</div>
					</td>
					<td class="tamano01" style="width:3cm;">Paga Parafiscales:</td>
					<td style="width:10%;">
						<div class="swparafiscal">
							<input type="checkbox" name="swparafiscal" class="swparafiscal-checkbox" id="idswparafiscal" value="<?php echo $_POST[swparafiscal];?>" <?php if($_POST[swparafiscal]=='S'){echo "checked";}?> onChange="cambiocheck('1');"/>
							<label class="swparafiscal-label" for="idswparafiscal">
								<span class="swparafiscal-inner"></span>
								<span class="swparafiscal-switch"></span>
							</label>
						</div>
					</td>
					<td class="tamano01" style="width:3cm;">Provisiona:</td>
					<td style="width:10%;">
						<div class="swprovision">
							<input type="checkbox" name="swprovision" class="swprovision-checkbox" id="idswprovision" value="<?php echo $_POST[swprovision];?>" <?php if($_POST[swprovision]=='S'){echo "checked";}?> onChange="cambiocheck('2');"/>
							<label class="swprovision-label" for="idswprovision">
								<span class="swprovision-inner"></span>
								<span class="swprovision-switch"></span>
							</label>
						</div>
					</td>
					<td></td>
				</tr>
				<tr>
					<td class="tamano01">Concepto Contable: </td>
					<td colspan="3" >
						<select name="concecont" id="concecont" onChange="validar();" style="width:100%;" class="tamano02">
							<option value="-1">Seleccione ....</option>
							<?php
								$sqlr="SELECT * FROM conceptoscontables WHERE modulo='2' AND tipo='H' ORDER BY codigo";
								$resp = mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($resp))
								{
									if($row[0]==$_POST[concecont])
									{
										echo "<option value='$row[0]' SELECTED>$row[0] - $row[3] - $row[1]</option>";
										$_POST[concecontnom]="$row[0] - $row[3] - $row[1]";
									}
									else{echo "<option value='$row[0]'>$row[0] - $row[3] - $row[1]</option>";}
								}
							?>
						</select>
						<input type="hidden" name="concecontnom" id="concecontnom" value="<?php echo $_POST[concecontnom]?>">
					</td>	 
				</tr>
			</table>
			<input type="hidden" name="oculto" id="oculto"  value="1">
			<table class="inicio">
				<tr><td colspan="6" class="titulos">Agregar Detalle Variable de Pago</td></tr>
				<tr>
					<td class="tamano01" style="width:15%;">Cuenta presupuestal: </td>
					<td colspan="1"  valign="middle" style="width:15%;"><input type="text" id="cuentap" name="cuentap" class="tamano02" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="buscactap(event)" value="<?php echo $_POST[cuentap]?>" style="width:80%;"/><input type="hidden" value="" name="bcp" id="bcp"/>&nbsp;<img class="icobut" src="imagenes/find02.png"  title="Listado Cuentas" onClick="despliegamodal2('visible','2');"/></td>
					<td><input type="text" name="ncuentap" id="ncuentap" value="<?php echo $_POST[ncuentap]?>" style="width:100%;" class="tamano02" readonly/></td>
				<tr>
					<td class="tamano01">CC:</td>
					<td >
						<select name="cc" onChange="validar()" onKeyUp="return tabular(event,this)" class="tamano02" style="width: 100%">
							<?php
								$sqlr="select *from centrocosto where estado='S'";
								$res=mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($res)) 
								{
									if($row[0]==$_POST[cc]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
									else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
								}
							?>
						</select>
						
					</td>
					<td style="padding-bottom:5px"><em class="botonflecha" onClick="agregardetalle()">Agregar</em></td>
					<input type="hidden" value="0" name="agregadet">
				</tr>
			</table>
			<?php
				//**** busca cuenta
				if($_POST[bcp]!='')
				{
					$nresul=buscacuentapres($_POST[cuentap],2);
					if($nresul!='')
					{
						echo"
							<script>
								document.getElementById('bcp').value='';
								document.getElementById('ncuentap').value='$nresul';
								document.getElementById('concecont').focus();
							</script>";
					}
					else
					{
						echo "<script>document.getElementById('valfocus').value='3';despliegamodalm('visible','2','Cuenta Incorrecta');</script>";
					}
				}
			?>
			<div class="subpantalla" style="height:40.5%; width:99.5%;overflow-x:hidden;">
				<table class="inicio">
					<tr><td class="titulos" colspan="7">Detalle Variable - Parametrizacion</td></tr>
					<tr>
						<td class="titulos2" style="width:5%;">CC</td>
						<td class="titulos2" style="width:15%;">Cta Presupuestal</td>
						<td class="titulos2">Nombre Cuenta</td>
						<td class="titulos2" style="width:10%;">Concepto Contable</td>
						<td class="titulos2">Nombre Concepto</td>
						<td class="titulos2" style="width:3%;text-align:center;"><img src="imagenes/del.png"/></td>
					</tr>
					<input type='hidden' name='elimina' id='elimina'>
					<?php
						if ($_POST[oculto]=='6')
						{ 
							$posi=$_POST[elimina];
							unset($_POST[dccs][$posi]);
							unset($_POST[dcuentas][$posi]);
							unset($_POST[dncuentas][$posi]);
							unset($_POST[dcuentasp][$posi]);
							unset($_POST[dncuentasp][$posi]);
							unset($_POST[dconceptos][$posi]);
							unset($_POST[dnconceptos][$posi]);
							$_POST[dccs]= array_values($_POST[dccs]);
							$_POST[dcuentasp]= array_values($_POST[dcuentasp]);
							$_POST[dncuentasp]= array_values($_POST[dncuentasp]);
							$_POST[dcuentas]= array_values($_POST[dcuentas]);
							$_POST[dncuentas]= array_values($_POST[dncuentas]);
							$_POST[dconceptos]= array_values($_POST[dconceptos]);
							$_POST[dnconceptos]= array_values($_POST[dnconceptos]);
						}
						if ($_POST[agregadet]=='1')
						{
							$cuentacred=0;
							$cuentadeb=0;
							$diferencia=0;
							$_POST[dccs][]=$_POST[cc];
							$_POST[dcuentasp][]=$_POST[cuentap];
							$_POST[dncuentasp][]=$_POST[ncuentap];
							$_POST[dcuentas][]=$_POST[cuenta];
							$_POST[dncuentas][]=$_POST[ncuenta];
							$_POST[dconceptos][]=$_POST[concecont];
							$_POST[dnconceptos][]=$_POST[concecontnom];
							$_POST[dvalores][]=$_POST[valor];	
							$_POST[agregadet]=0;
							echo"
								<script>
									document.form2.cuentap.value='';
									document.form2.ncuentap.value='';
									document.form2.cuenta.value='';
									document.form2.ncuenta.value='';
									document.form2.cuentap.value='';
									document.form2.cuentap.select();
							</script>";
						}
						$iter='saludo1a';
						$iter2='saludo2';
						$cdtll=count($_POST[dcuentasp]);
						$_POST[condeta]=$cdtll;
						for ($x=0;$x< $cdtll;$x++)
						{
							echo "
							<input type='hidden' name='dccs[]' value='".$_POST[dccs][$x]."'/>
							<input type='hidden' name='dcuentasp[]' value='".$_POST[dcuentasp][$x]."'/>
							<input type='hidden' name='dncuentasp[]' value='".$_POST[dncuentasp][$x]."'/>
							<input type='hidden' name='dconceptos[]' value='".$_POST[dconceptos][$x]."'/>
							<input type='hidden' name='dnconceptos[]' value='".$_POST[dnconceptos][$x]."'/>
							<tr class='$iter'>
								<td>".$_POST[dccs][$x]."</td>
								<td>".$_POST[dcuentasp][$x]."</td>
								<td>".$_POST[dncuentasp][$x]."</td>
								<td>".$_POST[dconceptos][$x]."</td>
								<td>".$_POST[dnconceptos][$x]."</td>
								<td style='text-align:center;'><img src='imagenes/del.png' onclick='eliminar($x)' class='icomen1'/></td>
							</tr>";
							$aux=$iter;
							$iter=$iter2;
							$iter2=$aux;
						}
					?>
					<tr></tr>
				</table>	
			</div>
			<input type="hidden" name="condeta" id="condeta" value="<?php echo $_POST[condeta];?>"/>
			<?php
				$oculto=$_POST['oculto'];
				if($_POST[oculto]=='2')
				{
					if ($_POST[nombre]!="")
					{
						$nr="1";
						if($_POST[swparafiscal]=="" || $_POST[swparafiscal]=="N"){$valswparafiscal='N';}
						else{$valswparafiscal='S';}
						if($_POST[swprovision]=="" || $_POST[swprovision]=="N"){$valswprovision='N';}
						else{$valswprovision='S';}
						if($_POST[swsalud]=="" || $_POST[swsalud]=="N"){$valswsalud='N';}
						else{$valswsalud='S';}
						if($_POST[swpension]=="" || $_POST[swpension]=="N"){$valswpesion='N';}
						else{$valswpesion='S';}
						if($_POST[swarl]=="" || $_POST[swarl]=="N"){$valswarl='N';}
						else{$valswarl='S';}
						$sqlr="INSERT INTO humvariables (codigo,nombre,pparafiscal,estado,provision,psalud,ppension,parl,concepto) VALUES ('$_POST[codigo]','".iconv($_SESSION["VERCARPHPINI"], $_SESSION["VERCARPHPFIN"]."//TRANSLIT",$_POST[nombre])."','$valswparafiscal' ,'S','$valswprovision','$valswsalud','$valswpesion','$valswarl','$_POST[concecont]')";
						if (!mysql_query($sqlr,$linkbd))
						{
							echo "<script>despliegamodalm('visible','2','Manejador de Errores de la Clase BD humvariables, No se pudo ejecutar la petición');</script>";
						}
						else
						{
							//****COMPUESTO	
							for($x=0;$x<count($_POST[dcuentasp]);$x++)
							{
								$sqlr="INSERT INTO humvariables_det (codigo,concepto,modulo,tipoconce,cc,cuentacon,cuentapres,estado,vigencia)VALUES ('$_POST[codigo]','".$_POST[dconceptos][$x]."','2', 'C', '".$_POST[dccs][$x]."', '".$_POST[dcuentas][$x]."' ,'".$_POST[dcuentasp][$x]."','S', '$vigusu')";
								if (!mysql_query($sqlr,$linkbd))
								{
									echo "<script>despliegamodalm('visible','2','Manejador de Errores de la Clase BD humvariables_det, No se pudo ejecutar la petición');</script>";

								}
								else{echo "<script>despliegamodalm('visible','3','Se ha almacenado la Variable con Exito');</script>";}
							}//***** fin del for	
						}
					}
					else {echo "<script>despliegamodalm('visible','2','Falta informacion para Crear la Variable');</script>";}
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