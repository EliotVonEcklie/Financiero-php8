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
				var validacion01=document.getElementById('periodo').value;
				if((validacion01.trim()!='')){
					despliegamodalm('visible','4','Esta Seguro de Guardar','1');
				}
				else {
					despliegamodalm('visible','2','Seleccione un MES para realizar la Depreciación');
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
				document.location.href = "acti-salidas.php";
			}

			
			function respuestaconsulta(pregunta, variable)
			{
				switch(pregunta)
				{
					case "1":
						document.form2.oculto.value=2;
						document.form2.listar.value=2;
						document.form2.submit();						
						break;
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
						document.getElementById('ventana2').src="actibus-ventana.php";
					}
				}
			}

			function validar(){document.form2.submit();}

			function buscaract()
			{
				document.form2.listar.value=2;
				document.form2.oculto.value=1;
				document.form2.submit();
			}

			function calcularact()
			{
				if($('#tabact >tbody >tr').length > 3){
					document.form2.listar.value=3;
					document.form2.oculto.value=1;
					document.form2.submit();
				}
				else{
					despliegamodalm('visible','2','No Hay Activos para Calcular la Depreciacion');
				}
			}
			
			function iratras(){
				location.href="acti-gestiondelosactivos.php";
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
				<a href="acti-depreciaractivos.php" class="mgbt"><img src="imagenes/add.png"  title="Nuevo"/></a>
				<a href="#"  onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png"  title="Guardar" /></a>
				<a href="acti-buscagestionactivos.php" class="mgbt"><img src="imagenes/busca.png"  title="Buscar"/></a>
				<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
				<a href="#" onClick="mypop=window.open('acti-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a>
				<a onclick="iratras()" class="mgbt"><img src="imagenes/iratras.png" title="AtrÃ¡s"></a>
			</td>
		</tr>
	</table>
	<?php
	$vigencia=date(Y);
	$vs=" ";
	if(!$_POST[oculto])
	{
		$fec=date("d/m/Y");
		$_POST[fecha]=$fec; 	
 	 	$_POST[vigencia]=$vigencia;
		$_POST[vigdep]=$vigencia;		 	  			 
		$_POST[valor]=0;	
		$vs=" style=visibility:visible";	 		 
	} 				  
	?>
    <div id="bgventanamodalm" class="bgventanamodalm">
        <div id="ventanamodalm" class="ventanamodalm">
            <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"></IFRAME>
		</div>
	</div>
	<form name="form2" method="post" action=""> 
		<table class="inicio" align="center"  >
			<tr>
				<td class="titulos" colspan="11">.: Gestion de Activos - Salidas</td>
				<td  class="cerrar" ><a href="acti-principal.php">Cerrar</a></td>
			</tr>
			<tr>
				<td class="saludo1">Documento:</td>
				<td valign="middle" >
					<input name="codigo" type="text" id="codigo" size="10" value="<?php echo $_POST[codigo]; ?>" onKeyUp="return tabular(event,this)" readonly />         
				</td>
				<td class="saludo1">Fecha:</td>
				<td valign="middle" >
					<input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">         
					<a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>        <input type="hidden" name="chacuerdo" value="1">		  
				</td>
				<td class="saludo1">Tipo de Movimiento</td>
				<td valign="middle" >
					<select id="tipom" name="tipom" onChange="document.form2.submit()">
						<?php
						if(($_POST[tipom]==2)||($_POST[tipom]=="")){
							echo "<option value='2' SELECTED >SALIDAS</option>";	  
							echo "<option value='4' >REVERSION SALIDAS</option>";	  
						}
						else{
							echo "<option value='2' >SALIDAS</option>";	  
							echo "<option value='4' SELECTED >REVERSION SALIDAS</option>";	  
						}
						?>
					</select>
				</td> 
				<td class="saludo1">Movimiento:</td>
				<td valign="middle" >
					<select id="movim" name="movim" onChange="document.form2.submit()">
						<?php
						$link=conectar_bd();
						if($_POST[tipom]=="") $_POST[tipom]=2;
						$sqlr="SELECT * FROM acti_tipomov WHERE estado='S' AND tipom='$_POST[tipom]' ORDER BY tipom, codigo";
						$resp = mysql_query($sqlr,$link);
						while ($row =mysql_fetch_row($resp)) 
						{
							echo "<option value='$row[1]$row[0]'";
							$i=$row[1].$row[0];
							if($i==$_POST[movim])
							{
								echo "SELECTED";
							}
							echo ">".$row[1].$row[0].' - '.$row[2]."</option>";	  
						}
						?>
					</select>
				</td> 
			</tr>
		</table>    
		<?php
		//DEPRECIACION INICIAL
		if($_POST[movim]=='207'){
			echo'<table class="inicio" align="center"  >
				<tr>
					<td class="titulos" colspan="12">.: Depreciaci&oacute;n Inicial</td>
				</tr>
				<tr>
					<td class="saludo1">Clasificaci&oacute;n</td>
					<td valign="middle" >
						<select id="clasificacion" name="clasificacion" onChange="document.form2.submit()">
							<option value="">Todos ...</option>';
							$link=conectar_bd();
							$sqlr="Select * from acti_tipo_cab where estado='S'";
							$resp = mysql_query($sqlr,$link);
							while ($row =mysql_fetch_row($resp)) 
							{
								echo '<option value="$row[0]"';
								$i=$row[0];
								if($i==$_POST[clasificacion])
								{
									echo 'SELECTED';
									$_POST[agedep]=$row[3];
								}
								echo '>'.$row[0].' - '.$row[1].'</option>';	  
							}
						echo'</select>
					</td> 
					<td class="saludo1" colspan="1">Mes:</td>
					<td>
						<select name="periodo" id="periodo" onChange="validar()"  >
							<option value="-1">Seleccione ....</option>';
							$sqlr="Select * from meses where estado='S'";
							$resp = mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($resp)) 
							{
								$i=$row[0];
								echo '<option value="$row[0]"';
								if($i==$_POST[periodo])
								{
									echo 'SELECTED';
								}
								echo ' >'.$row[1].'</option>';	  
							}   
						echo'</select> 
					</td>
					<td class="saludo1" colspan="1">Vigencia:</td>
					<td>
						<input name="vigdep" type="text" id="vigdep" value="'.$_POST[vigdep].'" size="4" maxlength="4">
						<input name="oculto" type="hidden" value="1">
						<input name="listar" type="hidden" value="1">
					</td>
					<td>
						<input type="button" name="buscar" value="Buscar" onClick="buscaract()">
					</td>
				</tr>
			</table>
			<div class="subpantalla" style="height:66.5%; width:99.6%; overflow-x:hidden;">
			<table class="inicio">
				<tr><td class="titulos" colspan="12">Listado de Activos - Depreciaci&oacute;n Inicial</td></tr>
				<tr>
					<td class="titulos2">No</td>
					<td class="titulos2">Placa</td>
					<td class="titulos2">Fecha Activacion</td>
					<td class="titulos2">Nombre</td>
					<td class="titulos2">Tipo</td>
					<td class="titulos2">Valor</td>
					<td class="titulos2">Valor Depreciado</td>
					<td class="titulos2">Valor por Depreciar</td>
					<td class="titulos2">Valor Depreciacion Mensual</td>
					<td class="titulos2">Meses Depreciacion</td>
					<td class="titulos2">Meses Depreciados</td>
					<td class="titulos2">Fecha Ultima Depre</td>
				</tr>';
				if($_POST[listar]=='2')
				{
					if($_POST[clasificacion]!=''){$criterio=" and clasificacion='$_POST[clasificacion]'";}
					$fechadep=$_POST[vigdep].'-'.$_POST[periodo].'-01';
					$sqlr="SELECT acticrearact_det.*, acti_tipo_cab.* FROM acticrearact_det INNER JOIN acti_tipo_cab ON acticrearact_det.tipo=acti_tipo_cab.id WHERE acticrearact_det.estado='S' ORDER BY acticrearact_det.placa";
					$resp = mysql_query($sqlr,$linkbd);
					$con=1;
					$co="zebra1";
					$co2='zebra2';
	//				echo $sqlr;
	//				$cuentas[]=array();
					if(strlen($_POST[periodo])<=1)
						$pe='0'.$_POST[periodo];
					else
						$pe=$_POST[periodo];
					$fechacorte=$_POST[vigdep].'-'.$pe.'-30';
					$x=0;
					while ($row =mysql_fetch_row($resp)) 
					{
		/*				$cuentas[$row[9]][0]=$row[9];
						$cuentas[$row[9]][1]+=$row[21];	
						$cuentas[$row[9]][2]=$row[14];		 		 */
						$agesdep=$row[16];
						$fechareg=$row[8];			
						$meses=diferenciamesesfechas($fechareg,$fechacorte);
						$valordep=0;
						$valoract=$row[15];
						$valdepmen=$row[21];
						if($meses<$agesdep)
						{
							if (0>diferenciamesesfechas_f3($fechareg,$fechacorte)){$mesesdep=0;$fechadep="";$valordep=0;}
							else
							{ 
								$mesesdep=$meses;
								$fechadep=sumamesesfecha($row[8],$mesesdep);	
								$valordep=$mesesdep*$valdepmen;
							}
						}
						else
						{
							$mesesdep=$agesdep;  
							$fechadep=sumamesesfecha($row[8],$mesesdep);
							$valordep=$mesesdep*$valdepmen;
						}		  
						$valxdep=round($valoract-$valordep,2);
						//arreglo
						$_POST[dplaca][$x]=$row[1];
						$_POST[dfecact][$x]=$row[8];
						$_POST[dnombre][$x]=$row[2];
						$_POST[dtipo][$x]=$row[27];
						$_POST[dntipo][$x]=$row[30];		 
						$_POST[dvalact][$x]=$valoract;
						$_POST[dvaldep][$x]=$valordep;		 
						$_POST[dvalx][$x]=$valxdep;
						$_POST[dvalmen][$x]=$valdepmen;	 
						$_POST[dages][$x]=$agesdep;		 		 
						$_POST[dmesdep][$x]=$mesesdep;		 		 
						$_POST[dfecdep][$x]=$fechadep;		 		 
						//fin arreglo
						echo "<tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\" >
							<td style='width:3%'>$con</td>
							<td style='width:10%'>
								<input name='dplaca[]' value='".$_POST[dplaca][$x]."' type='text' style='width:100%' class='inpnovisibles' readonly>
							</td>
							<td style='width:7%'>
								<input name='dfecact[]' value='".cambiar_fecha($_POST[dfecact][$x])."' type='text' style='width:100%' class='inpnovisibles' readonly>
							</td>
							<td style='width:18%'>
								<input name='dnombre[]' value='".$_POST[dnombre][$x]."' type='text' style='width:100%' class='inpnovisibles' readonly>
							</td>
							<td style='width:15%'>
								<input name='dtipo[]' value='".$_POST[dtipo][$x]."' type='hidden'>
								<input name='dntipo[]' value='".$_POST[dntipo][$x]."' type='text' style='width:100%' class='inpnovisibles' readonly>
							</td>
							<td style='width:10%'>
								<input name='dvalact[]' value='".number_format($_POST[dvalact][$x],2,',','.')."' type='text' style='width:100%; text-align:right;' class='inpnovisibles' readonly>
							</td>
							<td style='width:7%'>
								<input name='dvaldep[]' value='".number_format($_POST[dvaldep][$x],2,',','.')."' type='text' style='width:100%; text-align:right;' class='inpnovisibles' readonly>
							</td>
							<td style='width:10%'>
								<input name='dvalx[]' value='".number_format($_POST[dvalx][$x],2,',','.')."' type='text' style='width:100%; text-align:right;' class='inpnovisibles' readonly>
							</td>
							<td style='width:7%'>
								<input name='dvalmen[]' value='".number_format($_POST[dvalmen][$x],2,',','.')."' type='text' style='width:100%; text-align:right;' class='inpnovisibles' readonly>
							</td>
							<td style='width:3%'>
								<input name='dages[]' value='".$_POST[dages][$x]."' type='text' style='width:100%; text-align:center;' class='inpnovisibles' readonly>
							</td>
							<td style='width:3%'>
								<input name='dmesdep[]' value='".$_POST[dmesdep][$x]."' type='text' style='width:100%; text-align:center;' class='inpnovisibles' readonly>
							</td>
							<td style='width:7%'>
								<input name='dfecdep[]' value='".cambiar_fecha($_POST[dfecdep][$x])."' type='text' style='width:100%' class='inpnovisibles' readonly>
							</td>
						</tr>";					
						$con+=1;
						$aux=$co;
						$co=$co2;
						$co2=$aux;		 
						$x++;
					}						 	
				}
				if($_POST[oculto]==2)
				{
					$sqlr="INSERT INTO acti_deprecia_inicial (codigo, fecha, mes, vigencia, clasificacion, estado) VALUES ('".$_POST[$codigo]."', '".cambiar_fecha($_POST[$fecha])."', '".$pe."', ".$_POST[$vigdep]."', ".$_POST[$clasificacion]."', 'S')";
					mysql_query($sqlr,$linkbd);
					for($x=0;$x<count($_POST[dplaca]);$x++){
						$sqlr3="INSERT INTO acti_deprecia_inicial_det (codigo, placa, fechact, nombre, clasificacion, valor, valdep, valxdep, valdepmen, meses, mesdep, ultdep, estado) VALUES ('".$_POST[$codigo]."', '".$_POST[$dplaca][$x]."', '".cambiar_fecha($_POST[$dfecact][$x])."', '".$_POST[$dnombre][$x]."', '".$_POST[$dtipo][$x]."', '".$_POST[$dvalact][$x]."', '".$_POST[$dvaldep][$x]."', '".$_POST[$dvalx][$x]."', ".$_POST[$dvalmen][$x].", ".$_POST[$dages][$x].", ".$_POST[$dmesdep][$x].", '".cambiar_fecha($_POST[$dfecdep][$x])."')";
						mysql_query($sqlr3,$linkbd);
						//actualiza activo
						$salmes=$_POST[dages][$x]-$_POST[$dmesdep][$x];
						$sqlr2="UPDATE acticrearact_det SET mesesdepacum='".$_POST[$dmesdep][$x]."', saldomesesdep='".$salmes."', valdepact='".$_POST[$dvaldep][$x]."', saldodepact='".$_POST[$dvalx][$x]."', fechaultdep='".$_POST[$dfecdep][$x]."' WHERE placa='".$_POST[$dplaca][$x]."'";
						mysql_query($sqlr2,$linkbd);
					}
				}
			echo'<table>
			</div>';
		}
		//DEPRECIACION INDIVIDUAL
		elseif($_POST[movim]=='204'){
			$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
			$_POST[vigdep]=$vigusu;		 	  			 
			$linkbd=conectar_bd();
			if(isset($_POST[buscact])){
				if(isset($_POST[placa])){
					$sqlr="SELECT acticrearact_det.*, acticrearact.* FROM acticrearact_det INNER JOIN acticrearact ON acticrearact_det.codigo=acticrearact.codigo WHERE acticrearact_det.placa='$_POST[placa]'";
					//echo $sqlr;
					$res=mysql_query($sqlr, $linkbd);
					if(mysql_num_rows($res)!=0){
						$row=mysql_fetch_array($res);
						$_POST[orden]=$row[0];
						$_POST[placa]=$row[1];
						$_POST[nombre]=$row[2];
						$_POST[referencia]=$row[3];
						$_POST[modelo]=$row[4];
						$_POST[serial]=$row[5];
						$_POST[unimed]=$row[6];
						$_POST[fechac]=cambiar_fecha($row[7]);
						$_POST[fechact]=cambiar_fecha($row[8]);
						$_POST[clasificacion]=$row[9];
						$origen=$row[10];
						$_POST[area]=$row[11];
						$_POST[ubicacion]=$row[12];
						$_POST[grupo]=$row[13];
						$_POST[cc]=$row[14];
						$_POST[dispactivos]=$row[15];
						$_POST[valor]=$row[16];
						$_POST[estadoact]=$row[23];
						$bloque=$row[27];
						$_POST[tipo]=$row[28];
						$_POST[prototipo]=$row[29];
						$_POST[fecha]=cambiar_fecha($row[31]);
						$_POST[docgen]=$row[33];
						$_POST[valdoc]=$row[34];
					}
					else{
						echo "<script>despliegamodalm('visible','1','No hay Registros que Coincidan con su Criterio de Busqueda');</script>";
					}
				}
				else{
					echo "<script>despliegamodalm('visible','1','Ingrese la Informacion de la Placa del Activo');</script>";
				}
			}
			echo'<table class="inicio" align="center"  >
				<tr>
					<td class="titulos" colspan="11">.: Depreciaci&oacute;n Individual</td>
				</tr>
				<tr>
					<td class="saludo1" width="8%">Documento:</td>
					<td valign="middle" width="9%" >
						<input type="text" id="codigo" name="codigo" style="width:80%; text-align:center;" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" value="'.$_POST[codigo].'" readonly>
					</td>
					<td class="saludo1" width="6%">Fecha:</td>
					<td width="10%">
						<input name="fecdoc" type="text" id="fecdoc" title="DD/MM/YYYY" value="'.$_POST[fecdoc].'" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,\'/\',patron,true)" maxlength="10" style="width:60%;" readonly >
						<a href="#" onClick="displayCalendarFor(\'fecdoc\');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>
					</td>
					<td class="saludo1" width="10%">Placa:</td>
					<td valign="middle" width="10%">
						<input name="placa" type="text" id="placa" style="width:90%; text-align:center;" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" value="'.$_POST[placa].'" >
					</td>
					<td class="saludo1" width="10%">Serial:</td>
					<td valign="middle" width="10%">
						<input name="serbus" type="text" id="serbus" style="width:90%; text-align:center;" onKeyUp="return tabular(event,this)" value="'.$_POST[serbus].'" >
					</td>
					<td width="10%">
						<input type="submit" name="buscact" value="  Buscar Activo " >
					</td>
					<td width="10%">
						<a style="cursor:pointer;" onClick="despliegamodal2(\'visible\',1);"> B&uacute;squeda Avanzada</a>
					</td>
				</tr>
			</table>
			<table class="inicio">
				<tr><td colspan="10" class="titulos2">Origen del Activo</td></tr>
				<tr>
					<td class="saludo1">Orden:</td>
					<td valign="middle" >
						<input type="text" id="orden" name="orden" style="width:50%; text-align:center;" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" value="'.$_POST[orden].'" readonly>
					</td>
					<td class="saludo1">Fecha:</td>
					<td>
						<input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" size="10" value="'.$_POST[fecha].'" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,\'/\',patron,true)" maxlength="10" readonly >
						<input type="hidden" name="chacuerdo" value="1">
					</td>
					<td class="saludo1">Origen:</td>
					<td>
					<select id="origen" name="origen" style="width:90%" disabled="disabled" >
						<option value="">...</option>';
						if($origen!=""){
							$arr=explode('-',$origen);
							$cod=trim($arr[1]);
							if(substr($origen,0,1)=='A'){
								$sqlb="SELECT nombre FROM almdestinocompra WHERE codigo='$cod'";
							}
							else{
								$sqlb="SELECT nombre FROM actiorigenes WHERE codigo='$cod'";
							}
							$resb=mysql_query($sqlb,$linkbd);
							$worg =mysql_fetch_row($resb);
							echo "<option value='".$origen."' selected='selected'>".$origen." - ".$worg[0]."</option>";	  
						}
					echo'</select>
					</td>
					<td class="saludo1">Documento:</td>
					<td>
						<input name="docgen" type="text" id="docgen" size="10" value="'.$_POST[docgen].'" onKeyUp="return tabular(event,this)" readonly >
					</td>
					<td class="saludo1">Valor:</td>
					<td valign="middle" >
						<input name="valdoc" type="text" id="valdoc" onKeyUp="return tabular(event,this)" value="'.$_POST[valdoc].'" size="20" readonly="readonly" style="text-align:right;" >
					</td>         	    
				</tr>          
			</table>    
			<table class="inicio">
				<tr><td colspan="6" class="titulos2">Detalle Activo Fijo</td></tr>
				<tr>
					<td class="saludo1" style="width:10%">Clase:</td>
					<td style="width:40%">
						<select id="clasificacion" name="clasificacion" style="width:90%" disabled="disabled" >
							<option value="">...</option>';
							$link=conectar_bd();
							$sqlr="SELECT * from acti_clase where estado='S'";
							$resp = mysql_query($sqlr,$link);
							while ($row =mysql_fetch_row($resp)) 
							{
								echo "<option value=$row[0] ";
								$i=$row[0];
								if($i==$_POST[clasificacion])
								{
									echo "SELECTED";
									$_POST[agedep]=$row[3];
								}
								echo ">".$row[0].' - '.$row[1]."</option>";	  
							}
						echo'</select>
					</td>    
					<td class="saludo1">Grupo:</td>
					<td>
						<select id="grupo" name="grupo" style="width:90%" disabled="disabled" >
							<option value="">...</option>';
							$link=conectar_bd();
							$sqlr="SELECT * from acti_grupo where estado='S' and id_clase='$_POST[clasificacion]'";
							$resp = mysql_query($sqlr,$link);
							while ($row =mysql_fetch_row($resp)) 
							{
								echo "<option value=$row[0] ";
								$i=$row[0];
								if($i==$_POST[grupo])
								{
									echo "SELECTED";
								}
								echo ">".$row[0].' - '.$row[2]."</option>";	  
							}
						echo'</select>
					</td>
				</tr>
				<tr>
					<td class="saludo1" style="width:10%">Tipo:</td>
					<td style="width:40%">
						<select id="tipo" name="tipo" style="width:90%" disabled="disabled" >
							<option value="">...</option>';
							$link=conectar_bd();
							$sqlr="SELECT * from acti_tipo_cab where estado='S'";
							$resp = mysql_query($sqlr,$link);
							while ($row =mysql_fetch_row($resp)) 
							{
								echo "<option value=$row[0] ";
								$i=$row[0];
								if($i==$_POST[tipo])
								{
									echo "SELECTED";
									$_POST[agedep]=$row[3];
								}
								echo ">".$row[0].' - '.$row[1]."</option>";	  
							}
						echo'</select>
					</td>    
					<td class="saludo1">Prototipo:</td>
					<td>
						<select id="prototipo" name="prototipo" style="width:90%" disabled="disabled" >
							<option value="">...</option>';
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
						echo'</select>
					</td>
				</tr>
				<tr>
					<td class="saludo1">Area:</td>
					<td>
						<select id="area" name="area" style="width:90%" disabled="disabled" >
							<option value="">...</option>';
							$link=conectar_bd();
							$sqlr="Select * from admareas,actiareasact where actiareasact.id_cc=admareas.id_cc and admareas.estado='S'";
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
						echo'</select>
					</td>   
					<td class="saludo1">Ubicacion:</td>
					<td>
						<select name="ubicacion" style="width:90%" disabled="disabled" >
							<option value="">...</option>';
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
						echo'</select>
					</td> 
				</tr>
				<tr>
					<td class="saludo1">CC:</td>
					<td>
						<select name="cc" style="width:90%" disabled="disabled" >
							<option value="">...</option>';
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
						echo'</select>
					</td>
					<td class="saludo1">Disposici&oacute;n de los Activos:</td>
					<td>
						<select id="dispactivos" name="dispactivos" style="width: 90%;" disabled="disabled" >
							<option value="">...</option>';
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
						echo'</select>
					</td>
				</tr>
			</table>
			<table class="inicio">
				<tr>
					<td colspan="8" class="titulos2">Activo Fijo</td>
				</tr>
				<tr>
					<td class="saludo1" style="width:10%">Nombre:</td>
					<td style="width:40%" colspan="3">
						<input type="text" id="nombre" name="nombre" onKeyUp="return tabular(event,this)"  style="width:100%; text-transform:uppercase;" value="'.$_POST[nombre].'" readonly>
					</td>
					<td class="saludo1" style="width:10%">Ref:</td>
					<td style="width:15%">
						<input type="text" id="referencia" name="referencia" onKeyUp="return tabular(event,this)" value="'.$_POST[referencia].'" readonly>
					</td>
					<td class="saludo1" style="width:10%">Modelo:</td>
					<td style="width:15%">
						<input type="text" id="modelo" name="modelo" onKeyUp="return tabular(event,this)" value="'.$_POST[modelo].'" readonly>
					</td>
				</tr>
				<tr>
					<td class="saludo1" style="width:10%">Serial:</td>
					<td style="width:15%">
						<input type="text" id="serial" name="serial" onKeyUp="return tabular(event,this)" style="width:100%" value="'.$_POST[serial].'" readonly>
					</td>
					<td class="saludo1" style="width:10%">Unidad Medida:</td>
					<td style="width:15%">
						<select name="unimed" id="unimed" style="width:100%" disabled="disabled">
						   <option value="" >Seleccione...</option>
						   <option value="1" '; if($_POST[unimed]=='1') echo "SELECTED"; echo'>Unidad</option>
						   <option value="2" '; if($_POST[unimed]=='2') echo "SELECTED"; echo'>Juego</option>
						</select>
					</td>
					<td class="saludo1">Fecha Compra: </td>
					<td>
						<input name="fechac" type="text" value="'.$_POST[fechac].'" maxlength="10" size="15" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971547" onKeyDown="mascara(this,\'/\',patron,true)" title="DD/MM/YYYY" readonly>
					</td>
					<td class="saludo1">Fecha Activacion:</td>
					<td>
						<input name="fechact" type="text" id="fc_1198971546" title="DD/MM/YYYY" size="10" value="'.$_POST[fechact].'" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,\'/\',patron,true)"  maxlength="10" readonly> 
					</td>
				</tr>
				<tr>
					<td class="saludo1"  style="width:1%">Depreciacion en Bloque:</td>
					<td valign="middle" >
						<input type="checkbox" id="chkdep" name="chkdep" onClick="valDep()">
						<input type="hidden" id="valdep" name="valdep" value="'.$_POST[valdep].'" >
					</td>
					<td class="saludo1">Depreciacion Individual:</td>
					<td valign="middle" >
						<input type="text" id="agedep" name="agedep" size="5" value="'.$_POST[agedep].'" style="text-align:center;" readonly >
						A&ntilde;os
					</td>
					<td class="saludo1">Estado:</td>
					<td>
						<select name="estadoact" id="estadoact" disabled="disabled" >
							<option value="" >Seleccione...</option>
							<option value="bueno"'; if($_POST[estadoact]=='bueno') echo "SELECTED"; echo'>Bueno</option>
							<option value="regular"'; if($_POST[estadoact]=='regular') echo "SELECTED"; echo'>Regular</option>
							<option value="malo"'; if($_POST[estadoact]=='malo') echo "SELECTED"; echo'>Malo</option>
						</select>
					</td>
					<td class="saludo1">Valor Inicial:</td>
					<td>
						<input type="text" name="valor" id="valor" onKeyPress="javascript:return solonumeros(event)" onKeyUp="puntitos(this,this.value.charAt(this.value.length-1))" value="'.$_POST[valor].'" style="text-align:right;" readonly> 
						<input type="hidden" value="'.$_POST[oculto].'" name="oculto" id="oculto" >
					</td>
				</tr>
				<tr>
					<td class="saludo1">Foto:</td>
					<td><!--VER FOTO, FALTA COLOCAR ICONO PARA VISUALIZAR IMAGEN --></td>
					<td colspan="4"></td>
					<td class="saludo1">Valor por Depreciar:</td>
					<td valign="middle" >
						<input name="saldo" type="text" id="saldo" onKeyUp="return tabular(event,this)" value="'.$_POST[saldo].'" size="20" readonly="readonly" >
					</td>         	    
				</tr>
			</table>    
			<table class="inicio">
				<tr>
					<td colspan="11" class="titulos2">Depreciaci&oacute;n:</td>
				</tr>
				<tr>
					<td class="saludo1" style="width:10%">&Uacute;ltima Depreciaci&oacute;n:</td>
					<td style="width:10%">
						<input type="text" id="uperiodo" name="uperiodo" onKeyUp="return tabular(event,this)"  style="width:90%;" value="'.$_POST[uperiodo].'" readonly>
					</td>
					<td class="saludo1" style="width:5%">A&ntilde;o:</td>
					<td style="width:5%">
						<input type="text" id="uanio" name="uanio" onKeyUp="return tabular(event,this)" style="width:90%" value="'.$_POST[uanio].'" readonly>
					</td>
					<td class="saludo1" style="width:10%">Depreciar Hasta:</td>
					<td style="width:10%">
						<select name="periodo" id="periodo" onChange="validar()" style="width:90%" >
							<option value="-1">Seleccione ....</option>';
							$sqlr="Select * from meses where estado='S' ";
							$resp = mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($resp)) 
							{
								$i=$row[0];
								echo "<option value=$row[0] ";
								if($i==$_POST[periodo])
								{
									echo "SELECTED";
								}
								echo " >".$row[1]."</option>";	  
							}   
						echo'</select> 
					</td>
					<td class="saludo1" style="width:5%">A&ntilde;o:</td>
					<td style="width:5%">
						<input name="vigdep" type="text" id="vigdep" value="'.$_POST[vigdep].'" style="width:90%" maxlength="4">
					</td>
					<td class="saludo1" style="width:10%">Nuevo Valor:</td>
					<td style="width:10%">
						<input name="nueval" type="text" id="nueval" value="'.$_POST[nueval].'" style="width:90%; text-align:right;" readonly >
					</td>
					<td style="width:10%">
						<input type="submit" name="calcular" value="  Calcular " >
					</td>
				</tr>
			</table>';
		}
		//DEPRECIACION EN GRUPO
		elseif($_POST[movim]=='205'){
			echo'<table class="inicio" align="center">
				<tr >
					<td class="titulos" colspan="12">.: Gestion de Activos - Depreciar en Grupo</td>
				</tr>
				<tr>
					<td class="saludo1">Documento:</td>
					<td valign="middle" >
						<input name="codigo" type="text" id="codigo" size="10" value="'.$_POST[codigo].'" onKeyUp="return tabular(event,this)" readonly />         
					</td>
					<td class="saludo1">Fecha:</td>
					<td valign="middle" >
						<input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" size="10" value="'.$_POST[fecha].'" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,\'/\',patron,true)"  maxlength="10">         
						<a href="#" onClick="displayCalendarFor(\'fc_1198971545\');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>        
						<input type="hidden" name="chacuerdo" value="1">		  
					</td>        
					<td class="saludo1">Clasificaci&oacute;n</td>
					<td valign="middle" >
						<select id="clasificacion" name="clasificacion" onChange="document.form2.submit()">
							<option value="">Todos ...</option>';
							$link=conectar_bd();
							$sqlr="Select * from acti_tipo_cab where estado='S'";
							$resp = mysql_query($sqlr,$link);
							while ($row =mysql_fetch_row($resp)) 
							{
								echo "<option value=$row[0] ";
								$i=$row[0];
								if($i==$_POST[clasificacion])
								{
									echo "SELECTED";
									$_POST[agedep]=$row[3];
								}
								echo ">".$row[0].' - '.$row[1]."</option>";	  
							}
						echo'</select>
					</td> 
					<td class="saludo1" colspan="1">Mes:</td>
					<td>
						<select name="periodo" id="periodo" onChange="validar()"  >
							<option value="-1">Seleccione ....</option>';
							$sqlr="Select * from meses where estado='S' ";
							$resp = mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($resp)) 
							{
								$i=$row[0];
								echo "<option value=$row[0] ";
								if($i==$_POST[periodo])
								{
									echo "SELECTED";
								}
								echo " >".$row[1]."</option>";	  
							}   
						echo'</select> 
					</td>
					<td class="saludo1" colspan="1">Vigencia:</td>
					<td>
						<input name="vigdep" type="text" id="vigdep" value="'.$_POST[vigdep].'" size="4" maxlength="4">
						<input name="oculto" type="hidden" value="1">
						<input name="listar" type="hidden" value="1">
					</td>
					<td>
						<input type="button" name="buscar" value="Buscar" onClick="buscaract()">
						<input type="button" name="buscar" value="Calcular" onClick="calcularact()">
					</td>
				</tr>          
			</table>    
			<div class="subpantalla" style="height:67.5%; width:99.6%; overflow-x:hidden;">
				<table class="inicio" id="tabact">
					<tr><td class="titulos" colspan="12">Listado de Activos - Depreciar</td></tr>
					<tr>
						<td class="titulos2">No</td>
						<td class="titulos2">Placa</td>
						<td class="titulos2">Fecha Activacion</td>
						<td class="titulos2">Nombre</td>
						<td class="titulos2">Clasificacion</td>
						<td class="titulos2">Valor</td>
						<td class="titulos2">Valor Depreciado</td>
						<td class="titulos2">Valor por Depreciar</td>
						<td class="titulos2">Valor Depreciacion Mensual</td>
						<td class="titulos2">Meses Depreciacion</td>
						<td class="titulos2">Meses Depreciados</td>
						<td class="titulos2">Fecha Ultima Dep</td>
					</tr>';
					if($_POST[listar]=='2')
					{
						if($_POST[clasificacion]!='')
						{
							$criterio=" and clasificacion='$_POST[clasificacion]'";
						}
						$linkbd=conectar_bd();
						$fechadep=$_POST[vigdep].'-'.$_POST[periodo].'-01';
						$criterio2=" and fechaultdep<$fechadep"; 
						$sqlr="SELECT * FROM acticrearact_det WHERE estado='S' AND mesesdepacum < nummesesdep AND fechact <= '".$fechadep."' ".$criterio." ORDER BY placa";
						$resp = mysql_query($sqlr,$linkbd);
						$con=1;
						$co="zebra1";
						$co2='zebra2';
					 // echo $sqlr;
						$cuentas[]=array();
						$sumatotdep=0;
						while ($row =mysql_fetch_row($resp)) 
						{
							$cuentas[$row[27]][0]=$row[27];
							$cuentas[$row[27]][1]+=$row[21];	
							$cuentas[$row[27]][2]=$row[14];
							$cuentas[$row[27]][3]=$row[1];		 
							$sqlr="SELECT * FROM acti_tipo_cab WHERE id='$row[27]' AND estado='S'";
							//echo $sqlr;
							$resp2 = mysql_query($sqlr,$linkbd);
							$row2 =mysql_fetch_row($resp2);	
							$agesdep=$row2[3]*12;					
							//arreglo
							$_POST[dplaca][$x]=$row[1];
							$_POST[dfecact][$x]=$row[8];
							$_POST[dnombre][$x]=$row[2];
							$_POST[dtipo][$x]=$row[27];
							$_POST[dntipo][$x]=$row2[1];
							$_POST[dvalact][$x]=$row[15];
							$_POST[dvaldep][$x]=$row[15]-$row[20];		 
							$_POST[dvalx][$x]=$row[20];
							$_POST[dvalmen][$x]=$row[21];	 
							$_POST[dages][$x]=$agesdep;		 		 
							$_POST[dmesdep][$x]=$row[17];		 		 
							$_POST[dfecdep][$x]=$row[25];		 		 
							echo "<tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\" >
								<td style='width:3%'>$con</td>
								<td style='width:10%'>
									<input name='dplaca[]' value='".$_POST[dplaca][$x]."' type='text' style='width:100%' class='inpnovisibles' readonly>
								</td>
								<td style='width:7%'>
									<input name='dfecact[]' value='".cambiar_fecha($_POST[dfecact][$x])."' type='text' style='width:100%' class='inpnovisibles' readonly>
								</td>
								<td style='width:18%'>
									<input name='dnombre[]' value='".$_POST[dnombre][$x]."' type='text' style='width:100%' class='inpnovisibles' readonly>
								</td>
								<td style='width:15%'>
									<input name='dtipo[]' value='".$_POST[dtipo][$x]."' type='hidden'>
									<input name='dntipo[]' value='".$_POST[dntipo][$x]."' type='text' style='width:100%' class='inpnovisibles' readonly>
								</td>
								<td style='width:10%'>
									<input name='dvalact[]' value='".number_format($_POST[dvalact][$x],2,',','.')."' type='text' style='width:100%; text-align:right;' class='inpnovisibles' readonly>
								</td>
								<td style='width:7%'>
									<input name='dvaldep[]' value='".number_format($_POST[dvaldep][$x],2,',','.')."' type='text' style='width:100%; text-align:right;' class='inpnovisibles' readonly>
								</td>
								<td style='width:10%'>
									<input name='dvalx[]' value='".number_format($_POST[dvalx][$x],2,',','.')."' type='text' style='width:100%; text-align:right;' class='inpnovisibles' readonly>
								</td>
								<td style='width:7%'>
									<input name='dvalmen[]' value='".number_format($_POST[dvalmen][$x],2,',','.')."' type='text' style='width:100%; text-align:right;' class='inpnovisibles' readonly>
								</td>
								<td style='width:3%'>
									<input name='dages[]' value='".$_POST[dages][$x]."' type='text' style='width:100%; text-align:center;' class='inpnovisibles' readonly>
								</td>
								<td style='width:3%'>
									<input name='dmesdep[]' value='".$_POST[dmesdep][$x]."' type='text' style='width:100%; text-align:center;' class='inpnovisibles' readonly>
								</td>
								<td style='width:7%'>
									<input name='dfecdep[]' value='".cambiar_fecha($_POST[dfecdep][$x])."' type='text' style='width:100%' class='inpnovisibles' readonly>
								</td>
							</tr>";					
							$con+=1;
							$aux=$co;
							$co=$co2;
							$co2=$aux;
							$sumatotdep+=$row[21];
						}		
						echo "<tr class='$co'>
							<td colspan='2'>Totales</td>
							<td></td><td></td><td></td><td></td><td></td><td></td>
							<td style='text-align:right;'>".number_format($sumatotdep,2)."</td><td></td><td></td><td></td>
						</tr>";	
					}
					//CALCULAR Depreciacion
					elseif($_POST[listar]=='3')
					{
						if($_POST[clasificacion]!='')
						{
							$criterio=" and clasificacion='$_POST[clasificacion]'";
						}
						$linkbd=conectar_bd();
						$fechadep=$_POST[vigdep].'-'.$_POST[periodo].'-01';
						$criterio2=" and fechaultdep<$fechadep"; 
						$sqlr="SELECT * FROM acticrearact_det WHERE estado='S' AND mesesdepacum < nummesesdep AND fechact <= '".$fechadep."' ".$criterio." ORDER BY placa";
						$resp = mysql_query($sqlr,$linkbd);
						$con=1;
						$co="zebra1";
						$co2='zebra2';
					 // echo $sqlr;
						$cuentas[]=array();
						$sumatotdep=0;
						if(strlen($_POST[periodo])<=1)
							$pe='0'.$_POST[periodo];
						else
							$pe=$_POST[periodo];
						$fechacorte=$_POST[vigdep].'-'.$pe.'-30';
						$valmes=0;
						while ($row =mysql_fetch_row($resp)) 
						{
							$cuentas[$row[27]][0]=$row[27];
							$cuentas[$row[27]][1]+=$row[21];	
							$cuentas[$row[27]][2]=$row[14];
							$cuentas[$row[27]][3]=$row[1];		 
							$sqlr="SELECT * FROM acti_tipo_cab WHERE id='$row[27]' AND estado='S'";
							//echo $sqlr;
							$resp2 = mysql_query($sqlr,$linkbd);
							$row2 =mysql_fetch_row($resp2);	
							$agesdep=$row2[3]*12;					
							//depreciacion
							$fechareg=$row[8];			
							$meses=diferenciamesesfechas($fechareg,$fechacorte);
							if($meses<2){
								$valordep=0;
								$valoract=$row[15];
								$valdepmen=$row[21];
								if($meses<$agesdep)
								{
									if (0>diferenciamesesfechas_f3($fechareg,$fechacorte)){$mesesdep=0;$fechadep="";$valordep=0;}
									else
									{ 
										$mesesdep=$meses;
										$fechadep=sumamesesfecha($row[8],$mesesdep);	
										$valordep=$mesesdep*$valdepmen;
									}
								}
								else
								{
									$mesesdep=$agesdep;  
									$fechadep=sumamesesfecha($row[8],$mesesdep);
									$valordep=$mesesdep*$valdepmen;
								}		  
								$valxdep=round($valoract-$valordep,2);
								//arreglo
								$_POST[dplaca][$x]=$row[1];
								$_POST[dfecact][$x]=$row[8];
								$_POST[dnombre][$x]=$row[2];
								$_POST[dtipo][$x]=$row[27];
								$_POST[dntipo][$x]=$row2[1];
								$_POST[dvalact][$x]=$valoract;
								$_POST[dvaldep][$x]=$valordep;		 
								$_POST[dvalx][$x]=$valxdep;
								$_POST[dvalmen][$x]=$valdepmen;	 
								$_POST[dages][$x]=$agesdep;		 		 
								$_POST[dmesdep][$x]=$mesesdep;		 		 
								$_POST[dfecdep][$x]=$fechadep;		 		 
								echo "<tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\" >
									<td style='width:3%'>$con</td>
									<td style='width:10%'>
										<input name='dplaca[]' value='".$_POST[dplaca][$x]."' type='text' style='width:100%' class='inpnovisibles' readonly>
									</td>
									<td style='width:7%'>
										<input name='dfecact[]' value='".cambiar_fecha($_POST[dfecact][$x])."' type='text' style='width:100%' class='inpnovisibles' readonly>
									</td>
									<td style='width:18%'>
										<input name='dnombre[]' value='".$_POST[dnombre][$x]."' type='text' style='width:100%' class='inpnovisibles' readonly>
									</td>
									<td style='width:15%'>
										<input name='dtipo[]' value='".$_POST[dtipo][$x]."' type='hidden'>
										<input name='dntipo[]' value='".$_POST[dntipo][$x]."' type='text' style='width:100%' class='inpnovisibles' readonly>
									</td>
									<td style='width:10%'>
										<input name='dvalact[]' value='".number_format($_POST[dvalact][$x],2,',','.')."' type='text' style='width:100%; text-align:right;' class='inpnovisibles' readonly>
									</td>
									<td style='width:7%'>
										<input name='dvaldep[]' value='".number_format($_POST[dvaldep][$x],2,',','.')."' type='text' style='width:100%; text-align:right;' class='inpnovisibles' readonly>
									</td>
									<td style='width:10%'>
										<input name='dvalx[]' value='".number_format($_POST[dvalx][$x],2,',','.')."' type='text' style='width:100%; text-align:right;' class='inpnovisibles' readonly>
									</td>
									<td style='width:7%'>
										<input name='dvalmen[]' value='".number_format($_POST[dvalmen][$x],2,',','.')."' type='text' style='width:100%; text-align:right;' class='inpnovisibles' readonly>
									</td>
									<td style='width:3%'>
										<input name='dages[]' value='".$_POST[dages][$x]."' type='text' style='width:100%; text-align:center;' class='inpnovisibles' readonly>
									</td>
									<td style='width:3%'>
										<input name='dmesdep[]' value='".$_POST[dmesdep][$x]."' type='text' style='width:100%; text-align:center;' class='inpnovisibles' readonly>
									</td>
									<td style='width:7%'>
										<input name='dfecdep[]' value='".cambiar_fecha($_POST[dfecdep][$x])."' type='text' style='width:100%' class='inpnovisibles' readonly>
									</td>
								</tr>";					
								$con+=1;
								$aux=$co;
								$co=$co2;
								$co2=$aux;
								$sumatotdep+=$row[21];
							}
							else{
								$valmes=1;
							}
						}		
						echo "<tr class='$co'>
							<td colspan='2'>Totales</td>
							<td></td><td></td><td></td><td></td><td></td><td></td>
							<td style='text-align:right;'>".number_format($sumatotdep,2)."</td><td></td><td></td><td></td>
						</tr>";
						if($valmes==1){
							echo "<script>despliegamodalm('visible','2','Hay Activos con mas de Un (1) mes Sin Depreciacion');</script>";
						}
					}
				echo'</table>
			</div>';
			//********** GUARDAR EL COMPROBANTE ***********
			// echo "oculto".$_POST[oculto];
			if($_POST[oculto]=='2')	
			{
			//rutina de guardado cabecera
				$linkbd=conectar_bd();
				ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
				$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
				$bloq=bloqueos($_SESSION[cedulausu],$fechaf);	
				if($bloq>=1)
				{		
					$sqlr="select MAX(numerotipo) from comprobante_cab WHERE tipo_comp=22 ";
					// echo $sqlr;
					$res=mysql_query($sqlr);
					$row=mysql_fetch_row($res);
					$consec=$row[0]+1;		  
					$lastday = mktime (0,0,0,$_POST[periodo],1,$_POST[vigdep]);
					$ultdiadep=$_POST[vigdep]."-".$_POST[periodo]."-01";
					$sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($consec,22,'$fechaf','DEPRECIACION ACTIVOS MES ".strtoupper(strftime("%B",$lastday))."',0,0,0,0,'1')";
					mysql_query($sqlr,$linkbd);
					//	echo "<br>$sqlr ";
					$idcomp=mysql_insert_id();
					$total=0;
					foreach($cuentas as $k)
					{
						if($k[0]!='')
						{
							$sqlr2="update acticrearact set  mesesdepacum=mesesdepacum+1, saldomesesdep=saldomesesdep-1, valdepact=valdepact+valdepmen, saldodepact=saldodepact-valdepmen, fechaultdep='$ultdiadep'  where clasificacion='".$k[0]."' AND  mesesdepacum < nummesesdep and fechact <= '".$fechadep."'";
							mysql_query($sqlr2,$linkbd);
							echo "<div class='saludo1'>Clasificacion:".$k[0]."   Valor Depreciar:".$k[1]."</div>";
							//  echo "<br>$sqlr2"; 	
							//echo "<br>".$k[0]."  =  ".$k[1];
							$sqlr="select * from acticlasificacion_det where codigo='".$k[0]."' and cc='".$k[2]."'";
							//echo $sqlr;
							$resp = mysql_query($sqlr,$linkbd);
							while ($row =mysql_fetch_row($resp)) 
							{
								//echo "<br> $_POST[periodo]  ".strftime("%B",$lastday)." cuenta deb:".$row[2]." cuenta cred:".$row[3];
								$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('22 $consec','".$row[2]."','".$_POST[ccemp][$x]."','".$k[2]."','DEPRECIACION ACTIVOS CLASIF. ".$k[0]."  MES ".strtoupper(strftime('%B',$lastday))." de $_POST[vigdep]','',".round($k[1],0).",0,'1','".$_POST[vigdep]."')";
								mysql_query($sqlr,$linkbd);
								//echo "<br>".$sqlr;
								$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('22 $consec','".$row[3]."','".$_POST[ccemp][$x]."','".$k[2]."','DEPRECIACION ACTIVOS CLASIF. ".$k[0]."  MES ".strtoupper(strftime('%B',$lastday))." de $_POST[vigdep]','',0,".round($k[1],0).",'1','".$_POST[vigdep]."')";
								mysql_query($sqlr,$linkbd);
								//	echo "<br>".$sqlr;
								$total+=$k[1];
							}
						}			
					}
					//$total=array_sum($k[1]); 	  
					//
					//echo "t:".$total;
					// $sqlr="insert into actidepactivo_cab (`id_dep`, `age`, `mes`, `fecha`, `valordep`, `estado`) values ($consec,'$_POST[vigdep]','$_POST[periodo]','$_POST[fecha]',,)";			
					/*$_POST[valor]=str_replace(".","",$_POST[valor]);
					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
					$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
					ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechact],$fecha);
					$fechafact=$fecha[3]."-".$fecha[2]."-".$fecha[1];
					$nmesesdep=$_POST[agedep]/12;
					$vmendep=$_POST[valor]/$nmesesdep;
					$sqlr="insert into actidepactivo (`placa`, age, `mes`,  `fecha`, `valordep`, `estado`) values ('$_POST[consecutivo]','$_POST[placa]', '$_POST[nombre]', '$_POST[referencia]','$_POST[modelo]','$_POST[serial]', '$_POST[unimed]','$fechaf', '$fechafact','$_POST[clasificacion]','$_POST[origen]','$_POST[area]','$_POST[ubicacion]','$_POST[grupo]','$_POST[cc]',$_POST[valor],$nmesesdep,0,$nmesesdep,$_POST[valor],$_POST[valor],$vmendep,'S')";
					echo $sqlr;
					if(!mysql_query($sqlr,$linkbd))
					 {
					  echo "<table class='inicio'><tr><td class='saludo1'><center>No Se ha Almacenado el Nuevo Activo, <img src='imagenes\alert.png'> Error:".mysql_error()."</center></td></tr></table>";
					 }
					 else
					 {
					  echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha Almacenado con Exito el Nuevo Activo <img src='imagenes\confirm.png'></center></td></tr></table>";
					 
					 }*/
				}
			}
			
		}
		//CORRECCION POR DETERIORO
		elseif($_POST[movim]=='206'){
			$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
			$_POST[vigdep]=$vigusu;		 	  			 
			$linkbd=conectar_bd();
			if(isset($_POST[buscact])){
				if(isset($_POST[placa])){
					$sqlr="SELECT acticrearact_det.*, acticrearact.* FROM acticrearact_det INNER JOIN acticrearact ON acticrearact_det.codigo=acticrearact.codigo WHERE acticrearact_det.placa='$_POST[placa]'";
					//echo $sqlr;
					$res=mysql_query($sqlr, $linkbd);
					if(mysql_num_rows($res)!=0){
						$row=mysql_fetch_array($res);
						$_POST[orden]=$row[0];
						$_POST[placa]=$row[1];
						$_POST[nombre]=$row[2];
						$_POST[referencia]=$row[3];
						$_POST[modelo]=$row[4];
						$_POST[serial]=$row[5];
						$_POST[unimed]=$row[6];
						$_POST[fechac]=cambiar_fecha($row[7]);
						$_POST[fechact]=cambiar_fecha($row[8]);
						$_POST[clasificacion]=$row[9];
						$origen=$row[10];
						$_POST[area]=$row[11];
						$_POST[ubicacion]=$row[12];
						$_POST[grupo]=$row[13];
						$_POST[cc]=$row[14];
						$_POST[dispactivos]=$row[15];
						$_POST[valor]=$row[16];
						$_POST[estadoact]=$row[23];
						$bloque=$row[27];
						$_POST[tipo]=$row[28];
						$_POST[prototipo]=$row[29];
						$_POST[fecha]=cambiar_fecha($row[31]);
						$_POST[docgen]=$row[33];
						$_POST[valdoc]=$row[34];
					}
					else{
						echo "<script>despliegamodalm('visible','1','No hay Registros que Coincidan con su Criterio de Busqueda');</script>";
					}
				}
				else{
					echo "<script>despliegamodalm('visible','1','Ingrese la Informacion de la Placa del Activo');</script>";
				}
			}
			echo'<table class="inicio" align="center"  >
				<tr>
					<td class="titulos" colspan="11">.: Correcci&oacute;n por Deterioro</td>
				</tr>
				<tr>
					<td class="saludo1" width="8%">Documento:</td>
					<td valign="middle" width="9%" >
						<input type="text" id="codigo" name="codigo" style="width:80%; text-align:center;" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" value="'.$_POST[codigo].'" readonly>
					</td>
					<td class="saludo1" width="6%">Fecha:</td>
					<td width="10%">
						<input name="fecdoc" type="text" id="fecdoc" title="DD/MM/YYYY" value="'.$_POST[fecdoc].'" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,\'/\',patron,true)" maxlength="10" style="width:60%;" readonly >
						<a href="#" onClick="displayCalendarFor(\'fecdoc\');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>
					</td>
					<td class="saludo1" width="10%">Placa:</td>
					<td valign="middle" width="10%">
						<input name="placa" type="text" id="placa" style="width:90%; text-align:center;" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" value="'.$_POST[placa].'" >
					</td>
					<td class="saludo1" width="10%">Serial:</td>
					<td valign="middle" width="10%">
						<input name="serbus" type="text" id="serbus" style="width:90%; text-align:center;" onKeyUp="return tabular(event,this)" value="'.$_POST[serbus].'" >
					</td>
					<td width="10%">
						<input type="submit" name="buscact" value="  Buscar Activo " >
					</td>
					<td width="10%">
						<a style="cursor:pointer;" onClick="despliegamodal2(\'visible\',1);"> B&uacute;squeda Avanzada</a>
					</td>
				</tr>
			</table>
			<table class="inicio">
				<tr><td colspan="10" class="titulos2">Origen del Activo</td></tr>
				<tr>
					<td class="saludo1">Orden:</td>
					<td valign="middle" >
						<input type="text" id="orden" name="orden" style="width:50%; text-align:center;" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" value="'.$_POST[orden].'" readonly>
					</td>
					<td class="saludo1">Fecha:</td>
					<td>
						<input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" size="10" value="'.$_POST[fecha].'" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,\'/\',patron,true)" maxlength="10" readonly >
						<input type="hidden" name="chacuerdo" value="1">
					</td>
					<td class="saludo1">Origen:</td>
					<td>
					<select id="origen" name="origen" style="width:90%" disabled="disabled" >
						<option value="">...</option>';
						if($origen!=""){
							$arr=explode('-',$origen);
							$cod=trim($arr[1]);
							if(substr($origen,0,1)=='A'){
								$sqlb="SELECT nombre FROM almdestinocompra WHERE codigo='$cod'";
							}
							else{
								$sqlb="SELECT nombre FROM actiorigenes WHERE codigo='$cod'";
							}
							$resb=mysql_query($sqlb,$linkbd);
							$worg =mysql_fetch_row($resb);
							echo "<option value='".$origen."' selected='selected'>".$origen." - ".$worg[0]."</option>";	  
						}
					echo'</select>
					</td>
					<td class="saludo1">Documento:</td>
					<td>
						<input name="docgen" type="text" id="docgen" size="10" value="'.$_POST[docgen].'" onKeyUp="return tabular(event,this)" readonly >
					</td>
					<td class="saludo1">Valor:</td>
					<td valign="middle" >
						<input name="valdoc" type="text" id="valdoc" onKeyUp="return tabular(event,this)" value="'.$_POST[valdoc].'" size="20" readonly="readonly" style="text-align:right;" >
					</td>         	    
				</tr>          
			</table>    
			<table class="inicio">
				<tr><td colspan="6" class="titulos2">Detalle Activo Fijo</td></tr>
				<tr>
					<td class="saludo1" style="width:10%">Clase:</td>
					<td style="width:40%">
						<select id="clasificacion" name="clasificacion" style="width:90%" disabled="disabled" >
							<option value="">...</option>';
							$link=conectar_bd();
							$sqlr="SELECT * from acti_clase where estado='S'";
							$resp = mysql_query($sqlr,$link);
							while ($row =mysql_fetch_row($resp)) 
							{
								echo "<option value=$row[0] ";
								$i=$row[0];
								if($i==$_POST[clasificacion])
								{
									echo "SELECTED";
									$_POST[agedep]=$row[3];
								}
								echo ">".$row[0].' - '.$row[1]."</option>";	  
							}
						echo'</select>
					</td>    
					<td class="saludo1">Grupo:</td>
					<td>
						<select id="grupo" name="grupo" style="width:90%" disabled="disabled" >
							<option value="">...</option>';
							$link=conectar_bd();
							$sqlr="SELECT * from acti_grupo where estado='S' and id_clase='$_POST[clasificacion]'";
							$resp = mysql_query($sqlr,$link);
							while ($row =mysql_fetch_row($resp)) 
							{
								echo "<option value=$row[0] ";
								$i=$row[0];
								if($i==$_POST[grupo])
								{
									echo "SELECTED";
								}
								echo ">".$row[0].' - '.$row[2]."</option>";	  
							}
						echo'</select>
					</td>
				</tr>
				<tr>
					<td class="saludo1" style="width:10%">Tipo:</td>
					<td style="width:40%">
						<select id="tipo" name="tipo" style="width:90%" disabled="disabled" >
							<option value="">...</option>';
							$link=conectar_bd();
							$sqlr="SELECT * from acti_tipo_cab where estado='S'";
							$resp = mysql_query($sqlr,$link);
							while ($row =mysql_fetch_row($resp)) 
							{
								echo "<option value=$row[0] ";
								$i=$row[0];
								if($i==$_POST[tipo])
								{
									echo "SELECTED";
									$_POST[agedep]=$row[3];
								}
								echo ">".$row[0].' - '.$row[1]."</option>";	  
							}
						echo'</select>
					</td>    
					<td class="saludo1">Prototipo:</td>
					<td>
						<select id="prototipo" name="prototipo" style="width:90%" disabled="disabled" >
							<option value="">...</option>';
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
						echo'</select>
					</td>
				</tr>
				<tr>
					<td class="saludo1">Area:</td>
					<td>
						<select id="area" name="area" style="width:90%" disabled="disabled" >
							<option value="">...</option>';
							$link=conectar_bd();
							$sqlr="Select * from admareas,actiareasact where actiareasact.id_cc=admareas.id_cc and admareas.estado='S'";
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
						echo'</select>
					</td>   
					<td class="saludo1">Ubicacion:</td>
					<td>
						<select name="ubicacion" style="width:90%" disabled="disabled" >
							<option value="">...</option>';
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
						echo'</select>
					</td> 
				</tr>
				<tr>
					<td class="saludo1">CC:</td>
					<td>
						<select name="cc" style="width:90%" disabled="disabled" >
							<option value="">...</option>';
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
						echo'</select>
					</td>
					<td class="saludo1">Disposici&oacute;n de los Activos:</td>
					<td>
						<select id="dispactivos" name="dispactivos" style="width: 90%;" disabled="disabled" >
							<option value="">...</option>';
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
						echo'</select>
					</td>
				</tr>
			</table>
			<table class="inicio">
				<tr>
					<td colspan="8" class="titulos2">Activo Fijo</td>
				</tr>
				<tr>
					<td class="saludo1" style="width:10%">Nombre:</td>
					<td style="width:40%" colspan="3">
						<input type="text" id="nombre" name="nombre" onKeyUp="return tabular(event,this)"  style="width:100%; text-transform:uppercase;" value="'.$_POST[nombre].'" readonly>
					</td>
					<td class="saludo1" style="width:10%">Ref:</td>
					<td style="width:15%">
						<input type="text" id="referencia" name="referencia" onKeyUp="return tabular(event,this)" value="'.$_POST[referencia].'" readonly>
					</td>
					<td class="saludo1" style="width:10%">Modelo:</td>
					<td style="width:15%">
						<input type="text" id="modelo" name="modelo" onKeyUp="return tabular(event,this)" value="'.$_POST[modelo].'" readonly>
					</td>
				</tr>
				<tr>
					<td class="saludo1" style="width:10%">Serial:</td>
					<td style="width:15%">
						<input type="text" id="serial" name="serial" onKeyUp="return tabular(event,this)" style="width:100%" value="'.$_POST[serial].'" readonly>
					</td>
					<td class="saludo1" style="width:10%">Unidad Medida:</td>
					<td style="width:15%">
						<select name="unimed" id="unimed" style="width:100%" disabled="disabled">
						   <option value="" >Seleccione...</option>
						   <option value="1" '; if($_POST[unimed]=='1') echo "SELECTED"; echo'>Unidad</option>
						   <option value="2" '; if($_POST[unimed]=='2') echo "SELECTED"; echo'>Juego</option>
						</select>
					</td>
					<td class="saludo1">Fecha Compra: </td>
					<td>
						<input name="fechac" type="text" value="'.$_POST[fechac].'" maxlength="10" size="15" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971547" onKeyDown="mascara(this,\'/\',patron,true)" title="DD/MM/YYYY" readonly>
					</td>
					<td class="saludo1">Fecha Activacion:</td>
					<td>
						<input name="fechact" type="text" id="fc_1198971546" title="DD/MM/YYYY" size="10" value="'.$_POST[fechact].'" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,\'/\',patron,true)"  maxlength="10" readonly> 
					</td>
				</tr>
				<tr>
					<td class="saludo1"  style="width:1%">Depreciacion en Bloque:</td>
					<td valign="middle" >
						<input type="checkbox" id="chkdep" name="chkdep" onClick="valDep()">
						<input type="hidden" id="valdep" name="valdep" value="'.$_POST[valdep].'" >
					</td>
					<td class="saludo1">Depreciacion Individual:</td>
					<td valign="middle" >
						<input type="text" id="agedep" name="agedep" size="5" value="'.$_POST[agedep].'" style="text-align:center;" readonly >
						A&ntilde;os
					</td>
					<td class="saludo1">Estado:</td>
					<td>
						<select name="estadoact" id="estadoact" disabled="disabled" >
							<option value="" >Seleccione...</option>
							<option value="bueno"'; if($_POST[estadoact]=='bueno') echo "SELECTED"; echo'>Bueno</option>
							<option value="regular"'; if($_POST[estadoact]=='regular') echo "SELECTED"; echo'>Regular</option>
							<option value="malo"'; if($_POST[estadoact]=='malo') echo "SELECTED"; echo'>Malo</option>
						</select>
					</td>
					<td class="saludo1">Valor Inicial:</td>
					<td>
						<input type="text" name="valor" id="valor" onKeyPress="javascript:return solonumeros(event)" onKeyUp="puntitos(this,this.value.charAt(this.value.length-1))" value="'.$_POST[valor].'" style="text-align:right;" readonly> 
						<input type="hidden" value="'.$_POST[oculto].'" name="oculto" id="oculto" >
					</td>
				</tr>
				<tr>
					<td class="saludo1">Foto:</td>
					<td><!--VER FOTO, FALTA COLOCAR ICONO PARA VISUALIZAR IMAGEN --></td>
					<td colspan="4"></td>
					<td class="saludo1">Valor por Depreciar:</td>
					<td valign="middle" >
						<input name="saldo" type="text" id="saldo" onKeyUp="return tabular(event,this)" value="'.$_POST[saldo].'" size="20" readonly="readonly" >
					</td>         	    
				</tr>
			</table>    
			<table class="inicio">
				<tr>
					<td colspan="12" class="titulos2">Correcci&oacute;n:</td>
				</tr>
				<tr>
					<td class="saludo1" style="width:10%">&Uacute;ltima Depreciaci&oacute;n:</td>
					<td style="width:10%">
						<input type="text" id="uperiodo" name="uperiodo" onKeyUp="return tabular(event,this)"  style="width:90%;" value="'.$_POST[uperiodo].'" readonly>
					</td>
					<td class="saludo1" style="width:5%">A&ntilde;o:</td>
					<td style="width:5%">
						<input type="text" id="uanio" name="uanio" onKeyUp="return tabular(event,this)" style="width:90%" value="'.$_POST[uanio].'" readonly>
					</td>
					<td class="saludo1" style="width:10%">Corregir en:</td>
					<td class="saludo1" style="width:2%">%</td>
					<td style="width:5%">
						<input type="text" id="cpor" name="cpor" onKeyUp="return tabular(event,this)" style="width:90%; text-align:center;" value="'.$_POST[cpor].'" maxlength="3" >
					</td>
					<td class="saludo1" style="width:2%">$</td>
					<td style="width:10%">
						<input name="cpes" type="text" id="cpes" value="'.$_POST[cpes].'" style="width:90%; text-align:right;" >
					</td>
					<td class="saludo1" style="width:10%">Nuevo Valor:</td>
					<td style="width:10%">
						<input name="nueval" type="text" id="nueval" value="'.$_POST[nueval].'" style="width:90%; text-align:right;" readonly >
					</td>
					<td style="width:10%">
						<input type="submit" name="calcular" value="  Calcular " >
					</td>
				</tr>
			</table>';
		}
		?>
	</form>
	<div id="bgventanamodal2">
        <div id="ventanamodal2">
            <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
            </IFRAME>
        </div>
 	</div>
</body>
</html>