<!--V 1.0 24/02/2015-->
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
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
		<link href="css/css3.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
		<script type='text/javascript' src='JQuery/jquery-2.1.4.min.js'></script>
		<script>
			function guardar()
			{
				despliegamodalm('visible','4','Esta Seguro de Guardar','1');
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
						case "6":
							document.getElementById('ventanam').src="ventana-consulta2.php?titulos="+mensa+"&idresp="+pregunta;
						break;
					}
				}
			}

			function despliegamodal2(_valor,_tip)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){
					document.getElementById('ventana2').src="";
					document.form2.submit();
				}else {
					switch(_tip)
					{	
						case "1":
							var placa = document.form2.placa_buscada.value;
							document.getElementById('ventana2').src="ventana-activos.php?placa="+placa;
						break;
					}
				}
				
			}	
					

			function eliminarDetalle(variable){
				despliegamodalm('visible','5','Esta Seguro de Eliminar','2',variable);
			}
				
			function funcionmensaje(){
				document.location.href = "acti-deterioro.php";
			}
				
			function respuestaconsulta(pregunta, variable)
			{
				if(pregunta=='N'||pregunta=='S'){
					switch(variable)
					{
						case "3":
							if(pregunta=='S'){
								agregaDetalle(1);
							}else{
								agregaDetalle(0);
							}
						break;
					}
				}else{
					switch(pregunta)
					{
						case "1":
							document.form2.oculto.value="2";
							document.form2.submit();
							break;
						case "2":
							document.form2.eliminadet.value=variable;
							document.form2.submit();
							break;
					}
				}
				
			}
			
			function validar(){document.form2.submit();}

			function iratras(){
				location.href="acti-gestiondelosactivos.php";
			}

			function agregarDetalle()
			{
				if(document.form2.tipo_deterioro.value=="2" && document.form2.valor_deterioro.value=="100"){
					despliegamodalm('visible','6','Desea Conservar el Valor de Salvamento','3');
				}else{
					agregaDetalle(0);
				}
			}	

			function agregaDetalle(valor)
			{
				if(document.form2.nombre.value!="" && document.form2.cod.value!="" && document.form2.fecha1.value!="" )
				{ 
					document.form2.salvamento.value=valor;
					document.form2.agregadet.value=1;
					document.form2.submit();
 				}
 				else {
           			despliegamodalm('visible','2','Falta informacion para poder Agregar');
				}
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
				<a href="acti-deterioro.php" class="mgbt"><img src="imagenes/add.png"  title="Nuevo"/></a>
				<a href="#"  onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png"  title="Guardar" /></a>
				<a href="#" class="mgbt"><img src="imagenes/busca.png"  title="Buscar"/></a>
				<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
				<a href="#" onClick="mypop=window.open('acti-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a>
				<a onclick="iratras()" class="mgbt"><img src="imagenes/iratras.png" title="Atrás"></a>
			</td>
		</tr>
	</table>
	<?php
	$vigencia=date(Y);
	$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
	$vs=" ";
	if(!$_POST[oculto])
	{
 	 	$_POST[vigencia]=$vigusu;
		$_POST[vigdep]=$vigencia;
		$fec=date("d/m/Y");
		$_POST[fecha1]=$fec; 
		$vs=" style=visibility:visible";	 		 
	} 				  
	?>
    <div id="bgventanamodalm" class="bgventanamodalm">
        <div id="ventanamodalm" class="ventanamodalm">
            <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"></IFRAME>
		</div>
	</div>
	<form name="form2" method="post" action=""> 
			<table class="inicio" align="center" style='margin-top: 5px;'>
                <tr>
                    <td class="titulos" colspan="10">.: Gestion de Activos - Deterioro</td>
                    <td class="cerrar" style="width:4%;" ><a onClick="location.href='acti-principal.php'">&nbsp;Cerrar</a></td>
                </tr>
                <tr>
                	<td class="saludo1" style="width:3%;">.: Codigo:</td>
                    <td style="width:2%;">
                    <?php 
                    	$sqlr="SELECT * FROM actdeterioro_cab ORDER BY cod DESC";
						$res=mysql_query($sqlr,$linkbd);
						if(mysql_num_rows($res)!=0){
							$rid = mysql_fetch_array($res);
							$numId=$rid[0]+1;
						}
						else{
							$numId=1;
						}
                    ?>
                    <input type="text" name="cod" id="cod" value="<?php echo $numId ?>" style="width:100%;" readonly /></td>
                	<td class="saludo1" style="width:7%;">.: Tipo de Movimiento:</td>
             		<td style="width:10%">
						<select name="tipomovimiento" id="tipomovimiento" onKeyUp="return tabular(event,this)" onChange="validar()" style="width:100%;" >
							<?php 
								$sqlr="select * from acti_tipomov where estado='S' AND (tipom='2' OR tipom='4')";
								$resp = mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($resp)) 
								{
									if ($row[0]=='01') {
										switch($row[1]){
											case 1: $nomb = "ENTRADA";break;
											case 2: $nomb = "SALIDA";break;
											case 3: $nomb = "REV.ENTRADA";break;
											case 4: $nomb = "REV.SALIDA";break;
										}
										if($_POST[tipomovimiento]==$row[1].$row[0]){
											echo "<option value='$row[1]$row[0]' SELECTED >$row[1]$row[0]-$row[2]-$nomb</option>";
										}else{
											echo "<option value='$row[1]$row[0]'>$row[1]$row[0]-$row[2]-$nomb</option>";
										}
									}
									
								}
							?>
						</select>
					</td>
                    <td class="saludo1" style="width:3%;">.: Clase:</td>
                    <td style="width:10%">
						<select id="clasificacion" name="clasificacion" onChange="document.form2.submit()" style="width:100%">
							<option value="">...</option>
							<?php
							$sqlr="SELECT * from actipo where niveluno='0' and estado='S'";
							$resp = mysql_query($sqlr,$linkbd);
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
					<td class="saludo1" style="width:3%;">.: Grupo:</td>
					<td style="width:10%">
						<select id="grupo" name="grupo" onChange="document.form2.submit()" style="width:100%">
							<option value="">...</option>
							<?php
							$sqlr="SELECT * from actipo where niveluno='$_POST[clasificacion]' and estado='S'";
							$resp = mysql_query($sqlr,$linkbd);
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
					<td class="saludo1" style="width:3%;">.: Tipo:</td>
             		<td style="width:10%">
             			<select id="tipo" name="tipo" onChange="document.form2.submit()" style="width:100%">
							<option value="">...</option>
							<?php
								$sqlr="SELECT * from actipo where niveluno='$_POST[grupo]' and niveldos='$_POST[clasificacion]' and estado='S'";
								$resp = mysql_query($sqlr,$linkbd);
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
                </tr>  
            </table>
            <?php 
            	$_POST[placa_buscada] = $_POST[clasificacion].$_POST[grupo].$_POST[tipo].'...'; 
				if ($_POST[tipo_deterioro]=="1"){
					$_POST[deterioro] = $_POST[valor_deterioro];
				}else{
					$_POST[deterioro] = $_POST[valor]*($_POST[valor_deterioro]/100);
				}
            ?>

			<table class="inicio" align="center" >
				<tr>
					<td class="titulos" colspan="6"> Activo </td>
				</tr>
					<td class="saludo1" style="width:3.1cm;">Placa Buscada:</td>
					<td style="width:7%;">
						<input name="placa_buscada" id="placa_buscada" type="text" value="<?php echo $_POST[placa_buscada]; ?>" onKeyUp="return tabular(event,this)" style="width: 40%"/>
		          	</td>
		          	<td class="saludo1" style="width:3cm;">Fecha Reg.:</td>
		          	<td style="width:25%">
        				<input name="fecha1" id="fecha1" type="text" id="fecha1" title="DD/MM/YYYY" style="width:53%;" value="<?php echo $_POST[fecha1]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)" maxlength="10" tabindex="2"/>&nbsp;<a href="#" onClick="displayCalendarFor('fecha1');" tabindex="3" title="Calendario"><img src="imagenes/calendario04.png" align="absmiddle" style="width:20px;"></a>
       				</td>  
		            <td rowspan="8" colspan="2" style="background:url(imagenes/siglas.png); background-repeat:no-repeat; background-position:left; background-size: 90% 95%"></td>
				</tr>
				
				<tr>
					<td  class="saludo1" style="width:2.6cm;">Tipo Deterioro:</td>
					<td style="width: 20%">
						<select name="tipo_deterioro" id="tipo_deterioro" onchange="document.form2.submit();" onkeyup="return tabular(event,this)" style="width:100%;">
							<option value="">...</option>
							<option value="1" <?php if ($_POST[tipo_deterioro]=="1"){echo "selected";}?>>Valor</option>
							<option value="2" <?php if ($_POST[tipo_deterioro]=="2"){echo "selected";}?>>Porcentaje</option>						
						</select>
					</td>
					<td colspan="2">
						<?php 
							$width=71;
							$cadena='';
							$cadena2='';
							if ($_POST[tipo_deterioro]=="2"){
								$width=65;
								$cadena='%';
							}elseif ($_POST[tipo_deterioro]=="1") {
								$width=60;
								$cadena2='$';
								$cadena='.00';
							}
						?>
						<?php echo $cadena2; ?>
						<input name="valor_deterioro" type="text" style="width:<?php echo $width; ?>%;" id="valor_deterioro" onBlur="document.form2.submit();" value="<?php echo $_POST[valor_deterioro]; ?>" onKeyUp="return tabular(event,this)" />
						<?php echo $cadena; ?>
					</td>
				</tr>
				<tr>
					<td class="saludo1" style="width:2.6cm;">Buscar Activo:</td>
					<td style="width:20%;">
						<input name="codigo" id="codigo" type="text" value="<?php echo $_POST[codigo]; ?>" onKeyUp="return tabular(event,this)" style="width: 70%"/>&nbsp;&nbsp;&nbsp;
                    	<a onClick="despliegamodal2('visible','1');"  style='cursor:pointer;' title='Listado Activos'>	
                    		<img src='imagenes/find02.png' style='width:20px;'/>
                    	</a>
                    </td>
                    <td colspan="2">
                    	<input name="nombre" type="text" style="width:80%;" id="nombre" value="<?php echo $_POST[nombre]; ?>" onKeyUp="return tabular(event,this)" readonly /> 
      				</td>
				</tr>
				<tr>
					<td class="saludo1" style="width:2.6cm;">Placa Activo:</td>
					<td style="width:20%;">
						<input name="placa" id="placa" type="text" value="<?php echo $_POST[placa]; ?>" style="width:100%"  readonly /> 
       				</td>
       				<td class="saludo1" style="width:3.1cm;">Valor Activo:</td>
       				<td colspan="1">
       					<input name="valor" id="valor" data-a-sign="$" data-a-dec="," data-a-sep="." data-v-min='0' type="text" value="<?php echo $_POST[valor]; ?>" style="text-align:right;width:72%" onKeyUp="sinpuntitos('valor','valor');return tabular(event,this);" readonly /> 
       				</td>
				</tr>
				<tr>
					<td class="saludo1" style="width:2.6cm;">V. Deterioro:</td>
					<td style="width:20%;">
                    	<input type="text" name="deterioro" id="deterioro" data-a-sign="$" data-a-dec="," data-a-sep="." data-v-min='0' onKeyUp="return tabular(event,this);" value="<?php echo $_POST[deterioro]; ?>" style='text-align:right;width:100%;' readonly/>
       				</td>
       				 <td>
        				<input type="button" name="agregar" id="agregar" value="   Agregar   " onClick="agregarDetalle()" >
        				<input type="hidden" value="0" id="agregadet" name="agregadet">
						<input type="hidden" id="eliminadet" name="eliminadet">
						<input type="hidden" id="oculto" name="oculto">
						<input name="fecha" id="fecha" type="hidden" value="<?php echo $_POST[fecha]; ?>"  readonly />    
						<input name="estado" id="estado" type="hidden" value="<?php echo $_POST[estado]; ?>" readonly /> 
						<input name="cc" id="cc" type="hidden" value="<?php echo $_POST[cc]; ?>" readonly /> 
						<input name="salvamento" id="salvamento" type="hidden"/> 
   					</td>
				</tr>
     		</table>
		<?php
			if ($_POST[eliminadet]!='')
		    { 
		        $posi=$_POST[eliminadet];
		        unset($_POST[dcodigo][$posi]);
		        unset($_POST[dfecha][$posi]);
		        unset($_POST[dnombre][$posi]);
		        unset($_POST[dvalor][$posi]);
		        unset($_POST[destado][$posi]);		 
		        unset($_POST[dplaca][$posi]);
		        unset($_POST[dvalor_deterioro][$posi]);		
		        unset($_POST[dtipo_deterioro][$posi]);
		        unset($_POST[dsalvamento][$posi]); 
		        unset($_POST[dcc][$posi]);
		        $_POST[dcodigo]= array_values($_POST[dcodigo]); 
		        $_POST[dfecha]= array_values($_POST[dfecha]); 
		        $_POST[dnombre]= array_values($_POST[dnombre]); 		 
		        $_POST[dvalor]= array_values($_POST[dvalor]);
		        $_POST[destado]= array_values($_POST[destado]); 		 		 
		        $_POST[dplaca]= array_values($_POST[dplaca]); 		 		 
		        $_POST[dvalor_deterioro]= array_values($_POST[dvalor_deterioro]); 	
		        $_POST[dtipo_deterioro]= array_values($_POST[dtipo_deterioro]); 
		        $_POST[dsalvamento]= array_values($_POST[dsalvamento]); 	
		        $_POST[dcc]= array_values($_POST[dcc]); 	 		 
		    }	 
			if ($_POST[agregadet]=='1')
		    {
				$_POST[dcodigo][]=$_POST[codigo];
				$_POST[dfecha][]=$_POST[fecha1];
				$_POST[dnombre][]=$_POST[nombre];
				$_POST[dvalor][]=$_POST[valor];
				$_POST[destado][]=$_POST[estado];
				$_POST[dplaca][]=$_POST[placa];
				$_POST[dvalor_deterioro][]=$_POST[deterioro];
				$_POST[dtipo_deterioro][]=$_POST[tipo_deterioro];
				$_POST[dsalvamento][]=$_POST[salvamento];
				$_POST[dcc][]=$_POST[cc];
		        echo"<script>
					$('#codigo').val('');
					$('#nombre').val('');
					$('#valor').val('');
					$('#estado').val('');
					$('#placa').val('');
					$('#valor_deterioro').val('');
					$('#deterioro').val('');
					$('#cc).val('');
				</script>";
		    }
		?>
		<div class="subpantallac" style="height:47.5%; width:99.6%;">
		<table class="inicio" id="tabla-activo-det" name="tabla-activo-det">
			<tr>
				<td class="titulos" colspan="15">Detalle Activos</td>
			</tr>
			<tr>
				<td class="titulos2">Codigo</td>
				<td class="titulos2">Fecha Reg.</td>
				<td class="titulos2">Placa</td>
				<td class="titulos2">Nombre</td>
				<td class="titulos2">Valor:</td>
				<td class="titulos2">Valor Deterioro</td>

				<td class="titulos2">
					<img src="imagenes/del.png" ><input type='hidden' name='elimina' id='elimina'>
				</td>
			</tr>
			<?php
            for ($x=0;$x<count($_POST[dcodigo]);$x++)
            {		 
    		 	if ($x%2==0) {
    		 		$style = "zebra1";
    		 	}else{
    		 		$style = "zebra2";
    		 	}
                echo"<input type='hidden' name='dcodigo[]' value='".$_POST[dcodigo][$x]."'/>
                <input type='hidden' name='dfecha[]' value='".$_POST[dfecha][$x]."'/>
                <input type='hidden' name='dplaca[]' value='".$_POST[dplaca][$x]."'/>
                <input type='hidden' name='dnombre[]' value='".$_POST[dnombre][$x]."'/>
                <input type='hidden' name='dvalor[]' value='".$_POST[dvalor][$x]."'>
                <input type='hidden' name='dvalor_deterioro[]' value='".$_POST[dvalor_deterioro][$x]."'/>
                <input type='hidden' name='destado[]' value='".$_POST[destado][$x]."'>
                <input type='hidden' name='dtipo_deterioro[]' value='".$_POST[dtipo_deterioro][$x]."'>
                <input type='hidden' name='dsalvamento[]' value='".$_POST[dsalvamento][$x]."'>
                <tr>
					<td class='$style'>".$_POST[dcodigo][$x]."</td>
                    <td class='$style'>".$_POST[dfecha][$x]."</td>
                    <td class='$style'>".$_POST[dplaca][$x]."</td>
                    <td class='$style'>".$_POST[dnombre][$x]."</td>	 
                    <td class='$style'>".$_POST[dvalor][$x]."</td>		 
                    <td class='$style'>".$_POST[dvalor_deterioro][$x]."</td>		 
                    <td class='$style'><a href='#' onclick='eliminarDetalle($x)'><img src='imagenes/del.png'></a></td>
				</tr>";
            }		 
            ?>
			</table>
		</div>
		<?php
			if($_POST[oculto]=="2")
			{	
				$nfecha=cambiar_fecha($_POST[fecha1]);
				$bloq=bloqueos($_SESSION[cedulausu],$nfecha);	
				if($bloq>=1){
					//*********************CREACION DEL COMPROBANTE CONTABLE ***************************
					//***cabecera comprobante
					$sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($_POST[cod],79,'$nfecha','".strtoupper($_POST[dnombre][0])."',0,'".$_POST[dvalor_deterioro][0]."','".$_POST[dvalor_deterioro][0]."',0,'1')";
					//mysql_query($sqlr,$linkbd);
					$idcomp = view($sqlr,'id');
					//$idcomp=mysql_insert_id();
					echo "<input type='hidden' name='ncomp' value='$idcomp'>";
					//***cabecera activo deterioro
					$sqlr="INSERT INTO actdeterioro_cab (cod,fechareg,nombre,tipo_mov,estado) VALUES ('$_POST[cod]','$nfecha','".$_POST[dnombre][0]."','$_POST[tipomovimiento]','".$_POST[destado][0]."')";
					if (!view($sqlr,'confirm')){
						echo "<script>despliegamodalm('visible','2','No se pudo ejecutar la petición');</script>";
					}
					else {
						//******************* DETALLE DEL COMPROBANTE CONTABLE *********************
						for ($x=0;$x<count($_POST[dcodigo]);$x++){
							//**** Buscar cuentas por placa
							$subplaca = substr($_POST[dplaca][$x], 0, -4); 
							$datos_cuentas = view("SELECT * FROM `acti_deterioro_det` WHERE tipo='$subplaca' AND centro_costos='".$_POST[dcc][$x]."'");
							$tercero = view("SELECT nit FROM `configbasica` LIMIT 1");
							//**** Inserto Detalles del comprobante
		 					$sqlrd="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito, estado,vigencia,tipo_comp,numerotipo,numacti) VALUES ('79 $_POST[cod]','$datos_cuentas[0][cuenta_debito]','$tercero[0][nit]','".$_POST[dcc][$x]."','Deterioro ".strtoupper($_POST[dnombre][$x])."','',".$_POST[dvalor_deterioro][$x].",0,'1','".$_POST[vigencia]."',79,$_POST[cod]),".$_POST[dplaca][$x];
		 					view($sqlrd);
		 					$sqlrd="INSERT INTO comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito, estado,vigencia,tipo_comp,numerotipo,numacti) VALUES ('79 $_POST[cod]','$datos_cuentas[0][cuenta_credito]','$tercero[0][nit]','".$_POST[dcc][$x]."','Deterioro ".strtoupper($_POST[dnombre][$x])."','',0,".$_POST[dvalor_deterioro][$x].",'1','".$_POST[vigencia]."',79,$_POST[cod]),".$_POST[dplaca][$x];
		 					view($sqlrd);

		 					//***Detalle activo deterioro
							$sqlr11="INSERT INTO actdeterioro_det (cod_cab,cod,nombre,placa,deterioro,valor,salvamento) VALUES ('".$_POST[cod]."','".$_POST[dcodigo][$x]."','".$_POST[dnombre][$x]."','".$_POST[dplaca][$x]."','".$_POST[dtipo_deterioro][$x]."','".$_POST[dvalor_deterioro][$x]."','".$_POST[dsalvamento][$x]."')";
							//echo $sqlr11.'<br>';
							if (!view($sqlr11,'confirm')){
								echo "<script>despliegamodalm('visible','2','No se pudo ejecutar la petición');</script>";
							}else{
								echo "<script>despliegamodalm('visible','1','Se ha almacenado con Exito');</script>";
							}
						}
					}
				}else {echo"<script>despliegamodalm('visible','2','No Tiene los Permisos para Modificar este Documento');</script>";}
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