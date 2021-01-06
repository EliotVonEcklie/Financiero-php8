<?php //V 1001 17/12/16 ?>
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
    <script type='text/javascript' src='JQuery/jquery-2.1.4.min.js'></script>
    <script type="text/javascript" src="css/calendario.js"></script>
    <script type="text/javascript" src="css/programas.js"></script>

	<script>
       	function guardar()
		{
			var validacion03=document.getElementById('fc_1198971546').value;
			var validacion01=document.getElementById('docgen').value;
			var validacion02=document.getElementById('origen').value;
			if((validacion01.trim()!='')&&(validacion02.trim()!='')&&(validacion03.trim()!='')){
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
			document.location.href = "acti-depreciarindiv.php";
		}
			
		function respuestaconsulta(pregunta, variable)
		{
			switch(pregunta)
			{
				case "1":
					document.form2.oculto.value="2";
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
				<a href="acti-correcdeterioro.php" class="mgbt"><img src="imagenes/add.png"  title="Nuevo"/></a>
				<a href="#"  onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png"  title="Guardar" /></a>
				<a href="acti-buscacorrecdeterioro.php" class="mgbt"><img src="imagenes/busca.png"  title="Buscar"/></a>
				<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
				<a href="#" onClick="mypop=window.open('acti-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a> 
  				<a onclick="iratras()" class="mgbt"><img src="imagenes/iratras.png" title="AtrÃ¡s"></a>
			</td>
		</tr>
	</table>
	<?php
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
?>
    <div id="bgventanamodalm" class="bgventanamodalm">
        <div id="ventanamodalm" class="ventanamodalm">
            <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"></IFRAME>
		</div>
	</div>
 
	<form name="form2" method="post" action=""> 
		<?php //**** busca cuenta
/*           	$sqlr="SELECT * FROM acticrearact ORDER BY codigo DESC";
			$res=mysql_query($sqlr,$linkbd);
			if(mysql_num_rows($res)!=0){
				$wid=mysql_fetch_array($res);
				$_POST[orden]=$wid[0]+1;
			}
			else{$_POST[orden]=1;}*/
		 ?>
    
		<table class="inicio" align="center"  >
			<tr>
				<td class="titulos" colspan="10">.: Gestion de Activos - Depreciaci&oacute;n Individual</td>
				<td class="cerrar" width="7%"><a href="acti-principal.php">Cerrar</a></td>
			</tr>
			<tr>
				<td class="saludo1" width="8%">Documento:</td>
				<td valign="middle" width="9%" >
					<input type="text" id="codigo" name="codigo" style="width:80%; text-align:center;" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[orden]?>" readonly>
					<input type="hidden" id="consecutivo" name="consecutivo" value="<?php echo $_POST[consecutivo]?>" readonly>
				</td>
				<td class="saludo1" width="6%">Fecha:</td>
				<td width="10%">
					<input name="fecdoc" type="text" id="fecdoc" title="DD/MM/YYYY" value="<?php echo $_POST[fecdoc]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)" maxlength="10" style="width:60%;" readonly >
					<a href="#" onClick="displayCalendarFor('fecdoc');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>
				</td>
				<td class="saludo1" width="10%">Placa:</td>
				<td valign="middle" width="10%">
					<input name="placa" type="text" id="placa" style="width:90%; text-align:center;" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[placa]; ?>" >
				</td>
				<td class="saludo1" width="10%">Serial:</td>
				<td valign="middle" width="10%">
					<input name="serbus" type="text" id="serbus" style="width:90%; text-align:center;" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[serbus]; ?>" >
				</td>
				<td width="10%">
					<input type="submit" name="buscact" value="  Buscar Activo " >
				</td>
				<td width="10%">
					<a style="cursor:pointer;" onClick="despliegamodal2('visible',1);"> B&uacute;squeda Avanzada</a>
				</td>
			</tr>
		</table>
		<table class="inicio">
		<tr><td colspan="10" class="titulos2">Origen del Activo</td></tr>
			<tr>
				<td class="saludo1">Orden:</td>
				<td valign="middle" >
					<input type="text" id="orden" name="orden" style="width:50%; text-align:center;" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[orden]?>" readonly>
					<input type="hidden" id="consecutivo" name="consecutivo" value="<?php echo $_POST[consecutivo]?>" readonly>
				</td>
				<td class="saludo1">Fecha:</td>
				<td>
					<input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)" maxlength="10" readonly >
					<input type="hidden" name="chacuerdo" value="1">
				</td>
				<td class="saludo1">Origen:</td>
				<td>
				<select id="origen" name="origen" style="width:90%" disabled="disabled" >
					<option value="">...</option>
					<?php
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
					?>
				</select>
				</td>
				<td class="saludo1">Documento:</td>
				<td>
					<input name="docgen" type="text" id="docgen" size="10" value="<?php echo $_POST[docgen]; ?>" onKeyUp="return tabular(event,this)" readonly >
				</td>
				<td class="saludo1">Valor:</td>
				<td valign="middle" >
					<input name="valdoc" type="text" id="valdoc" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[valdoc]?>" size="20" readonly="readonly" style="text-align:right;" >
				</td>         	    
			</tr>          
		</table>    
		<table class="inicio">
		<tr><td colspan="6" class="titulos2">Detalle Activo Fijo</td></tr>
		<tr>
			<td class="saludo1" style="width:10%">Clase:</td>
			<td style="width:40%">
				<select id="clasificacion" name="clasificacion" style="width:90%" disabled="disabled" >
					<option value="">...</option>
					<?php
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
					?>
				</select>
			</td>    
			<td class="saludo1">Grupo:</td>
			<td>
				<select id="grupo" name="grupo" style="width:90%" disabled="disabled" >
					<option value="">...</option>
					<?php
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
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td class="saludo1" style="width:10%">Tipo:</td>
			<td style="width:40%">
				<select id="tipo" name="tipo" style="width:90%" disabled="disabled" >
					<option value="">...</option>
					<?php
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
					?>
				</select>
			</td>    
			<td class="saludo1">Prototipo:</td>
			<td>
				<select id="prototipo" name="prototipo" style="width:90%" disabled="disabled" >
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
			<td class="saludo1">Area:</td>
			<td>
				<select id="area" name="area" style="width:90%" disabled="disabled" >
					<option value="">...</option>
					<?php
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
					?>
				</select>
			</td>   
			<td class="saludo1">Ubicacion:</td>
			<td>
				<select name="ubicacion" style="width:90%" disabled="disabled" >
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
				<select name="cc" style="width:90%" disabled="disabled" >
					<option value="">...</option>
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
				<select id="dispactivos" name="dispactivos" style="width: 90%;" disabled="disabled" >
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
    <script>
	//creaplaca()
	</script>
    <table class="inicio">
		<tr>
			<td colspan="8" class="titulos2">Activo Fijo</td>
		</tr>
    	<tr>
    		<td class="saludo1" style="width:10%">Nombre:</td>
    		<td style="width:40%" colspan="3">
				<input type="text" id="nombre" name="nombre" onKeyUp="return tabular(event,this)"  style="width:100%; text-transform:uppercase;" value="<?php echo $_POST[nombre]?>" readonly>
			</td>
    		<td class="saludo1" style="width:10%">Ref:</td>
    		<td style="width:15%">
				<input type="text" id="referencia" name="referencia" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[referencia]?>" readonly>
			</td>
    		<td class="saludo1" style="width:10%">Modelo:</td>
    		<td style="width:15%">
				<input type="text" id="modelo" name="modelo" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[modelo]?>" readonly>
			</td>
		</tr>
		<tr>
			<td class="saludo1" style="width:10%">Serial:</td>
			<td style="width:15%">
				<input type="text" id="serial" name="serial" onKeyUp="return tabular(event,this)" style="width:100%" value="<?php echo $_POST[serial]?>" readonly>
			</td>
			<td class="saludo1" style="width:10%">Unidad Medida:</td>
			<td style="width:15%">
				<select name="unimed" id="unimed" style="width:100%" disabled="disabled">
				   <option value="" >Seleccione...</option>
		           <option value="1" <?php if($_POST[unimed]=='1') echo "SELECTED"; ?>>Unidad</option>
		    	   <option value="2" <?php if($_POST[unimed]=='2') echo "SELECTED"; ?>>Juego</option>
		  		</select>
	  		</td>
      		<td class="saludo1">Fecha Compra: </td>
        	<td>
				<input name="fechac" type="text" value="<?php echo $_POST[fechac]?>" maxlength="10" size="15" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971547" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" readonly>
			</td>
			<td class="saludo1">Fecha Activacion:</td>
			<td>
				<input name="fechact" type="text" id="fc_1198971546" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fechact]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" readonly> 
			</td>
  		</tr>
      	<tr>
        	<td class="saludo1"  style="width:1%">Depreciacion en Bloque:</td>
          	<td valign="middle" >
	        	<input type="checkbox" id="chkdep" name="chkdep" onClick="valDep()">
	        	<input type="hidden" id="valdep" name="valdep" value="<?php echo $_POST[valdep]?>" >
        	</td>
        	<td class="saludo1">Depreciacion Individual:</td>
          	<td valign="middle" >
	        	<input type="text" id="agedep" name="agedep" size="5" value="<?php echo $_POST[agedep]?>" style="text-align:center;" readonly >
				A&ntilde;os
        	</td>
			<td class="saludo1">Estado:</td>
			<td>
				<select name="estadoact" id="estadoact" disabled="disabled" >
					<option value="" >Seleccione...</option>
					<option value="bueno" <?php if($_POST[estadoact]=='bueno') echo "SELECTED"; ?>>Bueno</option>
					<option value="regular" <?php if($_POST[estadoact]=='regular') echo "SELECTED"; ?>>Regular</option>
					<option value="malo" <?php if($_POST[estadoact]=='malo') echo "SELECTED"; ?>>Malo</option>
				</select>
			</td>
	  		<td class="saludo1">Valor Inicial:</td>
	  		<td>
	  			<input type="text" name="valor" id="valor"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="puntitos(this,this.value.charAt(this.value.length-1))" value='<?php echo $_POST[valor]?>' style="text-align:right;" readonly> 
	  			<input type="hidden" value="<?php echo $_POST[oculto] ?>" name="oculto" id="oculto" >
  			</td>
		</tr>
		<tr>
			<td class="saludo1">Foto:</td>
			<td><!--VER FOTO, FALTA COLOCAR ICONO PARA VISUALIZAR IMAGEN --></td>
	 		<td colspan="4"></td>
			<td class="saludo1">Valor por Depreciar:</td>
			<td valign="middle" >
				<input name="saldo" type="text" id="saldo" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[saldo]; ?>" size="20" readonly="readonly" >
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
				<input type="text" id="uperiodo" name="uperiodo" onKeyUp="return tabular(event,this)"  style="width:90%;" value="<?php echo $_POST[uperiodo]?>" readonly>
			</td>
    		<td class="saludo1" style="width:5%">A&ntilde;o:</td>
    		<td style="width:5%">
				<input type="text" id="uanio" name="uanio" onKeyUp="return tabular(event,this)" style="width:90%" value="<?php echo $_POST[uanio]?>" readonly>
			</td>
    		<td class="saludo1" style="width:10%">Depreciar Hasta:</td>
    		<td style="width:10%">
				<select name="periodo" id="periodo" onChange="validar()" style="width:90%" >
					<option value="-1">Seleccione ....</option>
					<?php
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
					?>
				</select> 
			</td>
    		<td class="saludo1" style="width:5%">A&ntilde;o:</td>
    		<td style="width:5%">
				<input name="vigdep" type="text" id="vigdep" value="<?php echo $_POST[vigdep]?>" style="width:90%" maxlength="4">
			</td>
    		<td class="saludo1" style="width:10%">Nuevo Valor:</td>
    		<td style="width:10%">
				<input name="nueval" type="text" id="nueval" value="<?php echo $_POST[nueval]?>" style="width:90%; text-align:right;" readonly >
			</td>
    		<td style="width:10%">
				<input type="submit" name="calcular" value="  Calcular " >
			</td>
		</tr>
    </table>    

</form>
	<?php 
	//********** GUARDAR EL COMPROBANTE ***********
	if($_POST[oculto]=='2')	{
		?>
		<script>
		//creaplaca()
		</script>
    <?php
		//rutina de guardado cabecera
		$linkbd=conectar_bd();
		$sqlr="select *from configbasica where estado='S'";
		//echo $sqlr;
		$res=mysql_query($sqlr,$linkbd);
		while($row=mysql_fetch_row($res)) {
		  	$nit=$row[0];
		  	$rs=$row[1];
	 	}
		
		$_POST[valor]=str_replace(".","",$_POST[valor]);
		ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
		$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	//	$sqlr="insert into acticrearact (codigo, fechareg, origen, documento, valor, estado) values ('$_POST[orden]', '$fechaf', '$_POST[origen]','$_POST[docgen]','$_POST[valdoc]', 'S')";
		/*if(!mysql_query($sqlr,$linkbd)) {
			echo "<script>despliegamodalm('visible','2','No se pudo ejecutar la petición');</script>";
		} else*/{
			echo "<script>despliegamodalm('visible','1','Se ha almacenado con Exito');</script>";
		  	/*$consec=0;
		  	$sqlr="Select max(numerotipo) from comprobante_cab where tipo_comp=23  ";
		  	$res=mysql_query($sqlr,$linkbd);
		  	while($r=mysql_fetch_row($res)){
		  		$consec=$r[0];	  
		 	}
		 	$consec+=1;
		  	$sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($consec ,23,'$fechaf','CREACION ACTIVO FIJO $_POST[placa]',0,$_POST[valor],$_POST[valor],0,'1')";
		 	mysql_query($sqlr,$linkbd);
	 	if(!mysql_query($sqlr,$linkbd)) {
			echo "<table class='inicio'><tr><td class='saludo1'><center>No se ha creado el comprobante contable, <img src='imagenes\alert.png'> Error:".mysql_error()."</center></td></tr></table>";
		} else{
			//**** detalle del comp contable
			$torigen=substr($_POST[origen],0,1);
			$origen=substr($_POST[origen],2);
			if($torigen=='A'){
			   $sqlr="Select * from almdestinocompra_det where codigo='$origen' AND CC='$_POST[cc]'";
		 	   $resp = mysql_query($sqlr,$link);
			   	while ($row =mysql_fetch_row($resp)) {
					$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('23 $consec','".$row[3]."','".$nit."','".$_POST[cc]."','Cta Destino compra ".$origen."','',0,".$_POST[valor].",'1','".$vigusu."')";
					//	echo "$sqlr <br>";
					mysql_query($sqlr,$linkbd);  
				}
		 	}
			if($torigen=='F'){
				$sqlr="Select * from actiorigenes_det where  codigo='$origen' AND CC='$_POST[cc]'";
				// echo $sqlr;
	 			$resp = mysql_query($sqlr,$link);
			    while ($row =mysql_fetch_row($resp)) {
					$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('23 $consec','".$row[3]."','".$nit."','".$_POST[cc]."','Cta Origen ".$origen."','',0,".$_POST[valor].",'1','".$vigusu."')";
					//	echo "$sqlr <br>";
					mysql_query($sqlr,$linkbd);  				
				}							
		 	}		
		 	//****cuenta credito detalle
   		   $sqlr="Select * from acticlasificacion_DET where codigo='$_POST[clasificacion]' AND CC='$_POST[cc]'";
			// echo $sqlr;
 			$resp = mysql_query($sqlr,$link);
		    while ($row =mysql_fetch_row($resp)) {
				$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('23 $consec','".$row[4]."','".$nit."','".$_POST[cc]."','Cta Clasificacion Activo ".$_POST[clasificacion]."','',".$_POST[valor].",0,'1','".$vigusu."')";
				//	echo "$sqlr <br>";
				mysql_query($sqlr,$linkbd);  				
			}
		 	//*********	 
		  	}*/
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