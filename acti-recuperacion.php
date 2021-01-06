<?php //V 1000 12/12/16 ?> 
<?php
  	require"comun.inc";
  	require"funciones.inc"; 
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
		<title>:: Spid - Activos Fijos</title>
		<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css"/>
		<script type="text/javascript" src="css/programas.js"></script>
		<script src="JQuery/jquery-2.1.4.min.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
		<script src="JQuery/autoNumeric-master/autoNumeric-min.js"></script>
		<script>
			function despliegamodal2(_valor,_pag,cod01,cod02)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else if(_pag=="1"){document.getElementById('ventana2').src="inve-greservas-articulos.php";}
				else if(_pag=="2")
				{
					var nompag="tercerosalm-ventana01.php?objeto="+cod01+"&nobjeto="+cod02;
					document.getElementById('ventana2').src=nompag;
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
						case "1":	document.getElementById('articulo').focus();
									document.getElementById('articulo').select();
									break;
						case "2":	document.getElementById('cuenta').focus();
									document.getElementById('cuenta').select();
									break;
					}
					document.getElementById('valfocus').value='0';
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
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.getElementById('oculto').value="2";
								document.form2.submit();break;
					case "2":	document.getElementById('tipoelimina').value="1";
								document.form2.submit();break;
					case "3":	document.getElementById('tipoelimina').value="2";
								document.form2.submit();break;
				}
			}
			function funcionmensaje()
			{
				var codig=document.form2.codigo.value;
				document.location.href = "inve-donacionentradaedita.php?codi="+codig;
			}
			function buscater(tipo)
 			{
				switch(tipo)
				{
					case '01':
						if (document.form2.tercero.value!=""){document.form2.bt.value='1';document.form2.submit();}
						break;
					case '02':
						if (document.form2.tercerop.value!=""){document.form2.bt.value='2';document.form2.submit();}
						break;
				}
 			}
			function guardar()
			{
				valg01=document.form2.codigo.value;
				valg02=document.form2.fecha.value;
				valg03=document.form2.ntercero.value;
				valg04=document.form2.valort.value;
				valg05=document.form2.ciudad.value;
				valg06=document.form2.lugarfi.value;
				valg07=document.form2.motivo.value;
				if (valg01!='' && valg02!='' && valg03!='' && valg04!='' && valg05!='' && valg06!='' && valg07!='')
				{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
 				else{despliegamodalm('visible','2','Faltan datos para completar el registro');}
			}
			function agregardetalle(tipo)
			{
				switch(tipo)
				{
					case '01':	
						val01=document.getElementById('tercerop').value;
						val02=document.getElementById('ntercerop').value;
						val03=document.getElementById('cargop').value;
						if(val01!="" && val02!="" && val03!=""){document.form2.agregadet.value='01';document.form2.submit();}
						else {despliegamodalm('visible','2','Falta información para poder Agregar Participante');}
						break;
						case '02':	
						val01=document.getElementById('descripcion').value;
						val02=document.getElementById('unimedida').value;
						val03=document.getElementById('cantidad').value;
						val04=document.getElementById('valor').value;
						val05=document.getElementById('estado').value;
						if(val01!="" && val02!="" && val03!="" && val04!="" && val05!="")
						{document.form2.agregadet.value='02';document.form2.submit();}
						else {despliegamodalm('visible','2','Falta información para poder Agregar Activo');}
						break;
				}
			}
			function eliminar(posi,tipo)
			{
				document.form2.elimina.value=posi;
				despliegamodalm('visible','4','Esta Seguro de Eliminar','2');
			}
			function validar(_opc){
				document.form2.submit();
			}
			jQuery(function($){ $('#nreservav').autoNumeric('init',{mDec:'0'});});
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
  				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='acti-recuperacion.php'" class="mgbt"/><img src="imagenes/guarda.png" title="Guardar" onClick="guardar();" class="mgbt"/><img src="imagenes/busca.png" title="Buscar" onClick="location.href='acti-recuperacionbuscar.php'" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" onClick="<?php echo paginasnuevas("inve");?>" class="mgbt"><img src="imagenes/printd.png" class="mgbt"/></td>
			</tr>
         </table>
         <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>		  
 		<form name="form2" method="post" action="acti-recuperacion.php">
        	<input type="hidden" name="valfocus" id="valfocus" value="0"/>
        	<?php
				if ($_POST[oculto]=="")
				{ 
					$_POST[codigo]=selconsecutivo('actiactorecuperacion','id');
					$_POST[fecha]=date("d/m/Y");
					$_POST[tabgroup1]=1;
					$sqlr="SELECT nit, razonsocial FROM configbasica WHERE estado='S'";
					$res = mysql_query($sqlr,$linkbd);
					$alcaldia = mysql_fetch_row($res);
					$_POST[tercero] = $alcaldia[0];
					$_POST[ntercero] = $alcaldia[1];
				}
				if($_POST[bt]=='1')
			 	{
			  		$nresul=buscatercero($_POST[tercero]);
			 		if($nresul!=''){$_POST[ntercero]=$nresul;}
					else{ $_POST[ntercero]="";}
			 	}
				if($_POST[bt]=='2')
			 	{
			  		$nresul=buscatercero($_POST[tercerop]);
			 		if($nresul!=''){$_POST[ntercerop]=$nresul;}
					else{ $_POST[ntercerop]="";}
			 	}
				switch($_POST[tabgroup1])
				{
					case 1:	$check1='checked';break;
					case 2:	$check2='checked';break;
				}
			?>
			<table class="inicio" align="center" >
				<tr >
					<td class="titulos" colspan="7">.: Acto Administrativo de Acuerdo de Recuperaci&oacute;n </td>
					<td class="cerrar" style="width:7%" onClick="location.href='acti-principal.php'">Cerrar</td>
				</tr>
				<tr>
					<td class="saludo1" style="width:8%;" >.: Consecutivo:</td>
					<td style="width:10%;"><input type="text" id="codigo" name="codigo" style="width:100%; text-align:center" value="<?php echo $_POST[codigo] ?>" readonly/></td>
					<td class="saludo1" style="width:9%;">.: Fecha Registro:</td>
					<td style="width:13%"><input type="text" name="fecha" id="fc_1198971545" title="DD/MM/YYYY" value="<?php echo $_POST[fecha];?>" onKeyUp="return tabular(event,this)" onKeyDown="mascara(this,'/',patron,true)" maxlength="10" style="width: 80%">&nbsp;<img src="imagenes/calendario04.png" title="Calendario" onClick="displayCalendarFor('fc_1198971545');" class="icobut"/></td>
					<td class="saludo1" style="width:10%;"  >.: Tercero:</td>
					<td style="width:12%;"><input type="text" id="tercero" name="tercero"  style="width:100%; text-align:center" value="<?php echo $_POST[tercero] ?>" onKeyUp="return tabular(event,this)" readonly/></td>
					<td><input type="text" id="ntercero" name="ntercero" style="width:100%; text-align:center" value="<?php echo $_POST[ntercero] ?>" readonly></td>
				</tr>
				<tr>
                	<td class="saludo1" >.: Valor Total:</td>
					<td ><input type="text" id="valort" name="valort"  style="width:100%;" value="<?php echo $_POST[valort] ?>" /></td>
					<td class="saludo1" >.: Ciudad:</td>
					<td ><input type="text" id="ciudad" name="ciudad"  style="width:100%;" value="<?php echo $_POST[ciudad] ?>" /></td>
					<td class="saludo1" >.: Lugar f&iacute;sico:</td>
					<td colspan="2"><input type="text" id="lugarfi" name="lugarfi"  style="width:100%;" value="<?php echo $_POST[lugarfi] ?>" /></td>
				</tr>
                <tr>
					<td class="saludo1" >.: Motivo:</td>
					<td colspan="6"><input type="text" id="motivo" name="motivo" style="width:100%;" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[motivo]?>"/></td>
				</tr>
				<tr>
					<td class="saludo1" >.: Otros Detalles:</td>
					<td colspan="6"><input type="text" id="otdetalles" name="otdetalles" style="width:100%;" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[otdetalles]?>"/></td>
				</tr>
			</table>
			<div class="tabscontra" style="height:54%; width:99.6%"> 
				<div class="tab">
					<input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?>/>
					<label for="tab-1">Participantes</label>
					<div class="content" style="overflow:hidden">
						<table class='inicio' align='center' width='99%' >
							<tr>
								<td class="saludo1" style="width:10%;"  >.: Terceros:</td>
								<td style="width:12%;"><input type="text" id="tercerop" name="tercerop"  style="width:80%; text-align:center;" value="<?php echo $_POST[tercerop] ?>" onKeyUp="return tabular(event,this)" onBlur="buscater('02')"/>&nbsp;<img src="imagenes/find02.png" onClick="despliegamodal2('visible','2','tercerop','ntercerop'); " class="icobut" title="Lista de Terceros"/></td>
								<td style="width:40%;"><input type="text" id="ntercerop" name="ntercerop" style="width:100%; text-align:center;" value="<?php echo $_POST[ntercerop] ?>" readonly/></td>
								<td><em class="botonflecha" onClick="agregardetalle('01')">Agregar</em></td>
							</tr>
                            <tr>
                            	<td class="saludo1">.: Cargo</td>
                                <td colspan="2"><input type="text" id="cargop" name="cargop" style="width:100%;" value="<?php echo $_POST[cargop] ?>"/></td>
                            </tr>
						</table>
						<div class="subpantalla" style="height:79%; width:99.5%;overflow-x:hidden;">
							<table class='inicio' align='center' width='99%' >
								<tr><td class="titulos" colspan="5">Participantes Inscritos</td></tr>
								<tr>
									<td class="titulos2" style="width:5%;">N°</td>
									<td class="titulos2" style="width:10%;">Documento</td>
									<td class="titulos2" style="width:35%;">Nombre</td>
									<td class="titulos2" >Cargo</td>
									<td class="titulos2" style="width:5%;">Eliminar</td>
								</tr>
								<?php
									if ($_POST[tipoelimina]=='1')
									{ 
										$posi=$_POST[elimina];
										unset($_POST[agtercerop][$posi]);
										unset($_POST[agntercerop][$posi]);
										unset($_POST[agcargop][$posi]);
										$_POST[agtercerop]= array_values($_POST[agtercerop]); 
										$_POST[agntercerop]= array_values($_POST[agntercerop]); 
										$_POST[agcargop]= array_values($_POST[agcargop]); 
										$_POST[elimina]='';
										$_POST[tipoelimina]='';
									}
									if ($_POST[agregadet]=='01')
									{
										$_POST[agtercerop][]=$_POST[tercerop];
										$_POST[agntercerop][]=$_POST[ntercerop];
										$_POST[agcargop][]=$_POST[cargop]; 
										$_POST[agregadet]=0;
										echo "
										<script>
											document.getElementById('tercerop').value='';
											document.getElementById('ntercerop').value='';
											document.getElementById('cargop').value='';
										</script>";
									}
									$iter='saludo1a';
									$iter2='saludo2';
									$conparti=count($_POST[agtercerop]);
									for ($x=0;$x<$conparti;$x++)
									{		 
										echo "
										<input type='hidden' name='agtercerop[]' value='".$_POST[agtercerop][$x]."'/>
										<input type='hidden' name='agntercerop[]' value='".$_POST[agntercerop][$x]."'/>
										<input type='hidden' name='agcargop[]' value='".$_POST[agcargop][$x]."'/>
										<tr class='$iter'>
											<td>".($x+1)."</td>
											<td>".$_POST[agtercerop][$x]."</td>
											<td>".$_POST[agntercerop][$x]."</td>
											<td >".$_POST[agcargop][$x]."</td>
											<td style='text-align:center;' onclick=\"eliminar($x,'2')\"><img src='imagenes/del.png' class='icoop'></td>
										</tr>";
										$aux=$iter;
										$iter=$iter2;
										$iter2=$aux;
									}
								?>
							</table>
						</div>
					</div>
				</div>
				<div class="tab">
					<input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?>/>
					<label for="tab-2">Activos</label>
					<div class="content" style="overflow:hidden">
						<table class='inicio' align='center' width='99%'>
							<tr>
								<td class="saludo1" style="width:8%;">.: Descripci&oacute;n:</td>
								<td style="width:30%;" colspan="3"><input type="text" id="descripcion" name="descripcion" style="width:100%;" value="<?php echo $_POST[descripcion] ?>"/></td>
								<td class="saludo1" style="width:10%;">.: Unidad de Medida:</td>
								<td style="width:20%;"><input type="text" id="unimedida" name="unimedida" style="width:100%;" value="<?php echo $_POST[unimedida];?>"/></td>
								<td><em class="botonflecha" onClick="agregardetalle('02')">Agregar</em></td>
							</tr>
							<tr>
								<td class="saludo1">.: Cantidad:</td>
								<td style="width:10%;"><input type="text" id="cantidad" name="cantidad" style="width:100%;" value="<?php echo $_POST[cantidad];?>" onKeyPress="javascript:return solonumeros(event)"/></td>
								<td class="saludo1" style="width:7%;">.: Valor:</td>
								<td ><input type="text" id="valor" name="valor" style="width:100%;" value="<?php echo $_POST[valor];?>" onKeyPress="javascript:return solonumeros(event)"/></td>
								<td class="saludo1">.: Estado:</td>
								<td>
									<select name="estado" id="estado" style="width:100%;">
										<option value="">Seleccione ....</option>
										<option value="N" <?php if($_POST[estado]=='N'){echo "SELECTED";}?>>NUEVO</option>
										<option value="U" <?php if($_POST[estado]=='U'){echo "SELECTED";}?>>USADO</option>
									</select>
								</td>
							</tr>
						</table>
						<div class="subpantalla" style="height:79%; width:99.5%;overflow-x:hidden;">
							<table class='inicio' align='center' width='99%' >
								<tr><td class="titulos" colspan="7">Articulos Contenidos en el Acta</td></tr>
								<tr>
									<td class="titulos2" style="width:5%;">N°</td>
									<td class="titulos2" >Descripci&oacute;n</td>
									<td class="titulos2" style="width:15%;">Unidad de Medida</td>
									<td class="titulos2" style="width:10%;">Catidad</td>
                                    <td class="titulos2" style="width:10%;">Valor</td>
                                    <td class="titulos2" style="width:10%;">Estado</td>
									<td class="titulos2" style="width:5%;">Eliminar</td>
								</tr>
                                <?php
									if ($_POST[tipoelimina]=='2')
									{ echo "hola";
										$posi=$_POST[elimina];
										unset($_POST[agdescripcion][$posi]);
										unset($_POST[agunimedida][$posi]);
										unset($_POST[agcantidad][$posi]);
										unset($_POST[agvalor][$posi]);
										unset($_POST[agestado][$posi]);
										$_POST[agdescripcion]= array_values($_POST[agdescripcion]); 
										$_POST[agunimedida]= array_values($_POST[agunimedida]); 
										$_POST[agcantidad]= array_values($_POST[agcantidad]); 
										$_POST[agvalor]= array_values($_POST[agvalor]); 
										$_POST[agestado]= array_values($_POST[agestado]); 
										$_POST[elimina]='';
										$_POST[tipoelimina]='';
									}
									if ($_POST[agregadet]=='02')
									{
										$_POST[agdescripcion][]=$_POST[descripcion];
										$_POST[agunimedida][]=$_POST[unimedida];
										$_POST[agcantidad][]=$_POST[cantidad]; 
										$_POST[agvalor][]=$_POST[valor];
										$_POST[agestado][]=$_POST[estado]; 
										$_POST[agregadet]=0;
										echo "
										<script>
											document.getElementById('descripcion').value='';
											document.getElementById('unimedida').value='';
											document.getElementById('cantidad').value='';
											document.getElementById('valor').value='';
											document.getElementById('estado').value='';
										</script>";
									}
									$iter='saludo1a';
									$iter2='saludo2';
									$conparti2=count($_POST[agdescripcion]);
									for ($x=0;$x<$conparti2;$x++)
									{		 
										echo "
										<input type='hidden' name='agdescripcion[]' value='".$_POST[agdescripcion][$x]."'/>
										<input type='hidden' name='agunimedida[]' value='".$_POST[agunimedida][$x]."'/>
										<input type='hidden' name='agcantidad[]' value='".$_POST[agcantidad][$x]."'/>
										<input type='hidden' name='agvalor[]' value='".$_POST[agvalor][$x]."'/>
										<input type='hidden' name='agestado[]' value='".$_POST[agestado][$x]."'/>";
										if($_POST[agestado][$x]=='U'){$mdestado="Usado";}
										else{$mdestado="Nuevo";}
										echo "
										<tr class='$iter'>
											<td>".($x+1)."</td>
											<td>".$_POST[agdescripcion][$x]."</td>
											<td>".$_POST[agunimedida][$x]."</td>
											<td>".$_POST[agcantidad][$x]."</td>
											<td>".$_POST[agvalor][$x]."</td>
											<td>$mdestado</td>
											<td style='text-align:center;' onclick=\"eliminar($x,'3')\"><img src='imagenes/del.png' class='icoop'></td>
										</tr>";
										$aux=$iter;
										$iter=$iter2;
										$iter2=$aux;
									}
								?>
                            </table>
						</div>
                        
					</div>
				</div>
			</div>
			<input type="hidden" name="oculto" id="oculto" value="1"/> 
			<input type="hidden" name="agregadet" id="agregadet" value="0"/>
			<input type='hidden' name='elimina' id='elimina' value=""/>
			<input type='hidden' name='tipoelimina' id='tipoelimina' value=""/>
			<input type='hidden' name='bt' id='bt' value=""/>
            
			  <?php
				if($_POST[oculto]=="2")
				{
					$cons=selconsecutivo('actiactorecuperacion','id');
					preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $_POST[fecha],$fecha);
					$fechaf="$fecha[3]-$fecha[2]-$fecha[1]";
 					$sqlr="INSERT INTO actiactorecuperacion (id,fecha,docdonante,nomdonante,valortotal,ciudad,lugarfisico,motivo,otrosdetalles,estado) VALUES ('$cons','$fechaf','$_POST[tercero]', '$_POST[ntercero]','$_POST[valort]','$_POST[ciudad]','$_POST[lugarfi]','$_POST[motivo]','$_POST[otdetalles]','A')";
					if (!mysql_query($sqlr,$linkbd)){echo"<script>despliegamodalm('visible','2','Error al almacenar');</script>";}	
					else 
					{
						$cont=0;
						$contx=count($_POST[agtercerop]);
						for ($x=0;$x<$contx;$x++)
						{
							$consp=selconsecutivo('actiactorecuperacionpartici','id');
							$sqlr="INSERT INTO actiactorecuperacionpartici (id,idacto,documento,nombre,cargo,estado) VALUES ('$consp','$cons','".$_POST[agtercerop][$x]."','".$_POST[agntercerop][$x]."','".$_POST[agcargop][$x]."','S')";
							if (!mysql_query($sqlr,$linkbd)){$cont=$cont+1;}
						}
						$cont2=0;
						$contx=count($_POST[agdescripcion]);
						for ($x=0;$x<$contx;$x++)
						{
							$consa=selconsecutivo('actiactorecuperacionarticu','id');
							$sqlr="INSERT INTO actiactorecuperacionarticu (id,idacto,descripcion,unumedida,cantidad,valor,estadou,estado) VALUES ('$consa','$cons','".$_POST[agdescripcion][$x]."','".$_POST[agunimedida][$x]."','".$_POST[agcantidad][$x]."','".$_POST[agvalor][$x]."','".$_POST[agestado][$x]."','S')";
							if (!mysql_query($sqlr,$linkbd)){$cont2=$cont2+1;}
						}
						
						if ($cont!=0){echo"<script>despliegamodalm('visible','2','Error al almacenar Participantes');</script>";}
						elseif ($cont2!=0){echo"<script>despliegamodalm('visible','2','Error al almacenar Articulos');</script>";}
						if($cont!=0 || $cont2!=0)
						{
							$sqlr ="DELETE FROM actiactorecuperacion WHERE id='$cons'";
							mysql_query($sqlr,$linkbd);
							$sqlr ="DELETE FROM actiactorecuperacionpartici WHERE idacto='$cons'";
							mysql_query($sqlr,$linkbd);
							$sqlr ="DELETE FROM actiactorecuperacionarticu WHERE idacto='$cons'";
							mysql_query($sqlr,$linkbd);
						}
						else {echo"<script>despliegamodalm('visible','1','Donacion N° $_POST[codigo] solicitada con Exito');</script>";}
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
</html>