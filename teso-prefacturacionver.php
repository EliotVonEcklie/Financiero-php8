<?php
//Elaborado por Sergio Murillo - Desarrollador
require "comun.inc";
require "funciones.inc";
require "conversor.php";
$linkbd=conectar_bd();
session_start();
cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<title>:: SPID - Tesoreria</title>

<script language="JavaScript1.2">

	function excel(){
		document.form2.action="csvfacturacion.php";
		document.form2.target="_BLANK";
		document.form2.submit(); 
		document.form2.action="";
		document.form2.target="";
	}
	
	function funcionmensaje()
	{
		var codigo = document.getElementById("codigo").value;
		document.location.href = "teso-buscafacturacion.php?cod="+codigo;
	}
	
	function respuestaconsulta(pregunta)
	{
		switch(pregunta)
		{
			case "1":	document.form2.oculto.value=2;
						document.form2.submit();
						break;
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
	
	function despliegamodal2(_valor,v)
	{
		document.getElementById("bgventanamodal2").style.visibility=_valor;
		if(_valor=="hidden"){
			document.getElementById('ventana2').src="";
			document.form2.submit();
		}
		else {
			if(v==1){
				document.getElementById('ventana2').src="registro-ventana02.php?vigencia="+document.form2.vigencia.value;
			}else if(v==2){
				document.getElementById('ventana2').src="tercerosgral-ventana01.php?objeto=tercero&nobjeto=ntercero&nfoco=solicita";
			}else if(v==3){
				document.getElementById('ventana2').src="registro-ventana03.php?vigencia="+document.form2.vigencia.value;
			}
			
		}
	}
	
	function validar()
	{
		var vigini=document.getElementById("vigini").value;
		var vigfin=document.getElementById("vigfin").value;
		if(vigini!="" && vigfin!=""){
			if(vigfin < vigini){
			despliegamodalm('visible','2','La vigencia final no puede ser menor que la inicial');
			}else{
				document.form2.oculto.value='1';
				document.form2.submit();
			}
		}else{
			document.form2.oculto.value='1';
			document.form2.submit();
		}
	
	}

	function pdf()
	{
		document.form2.action="pdffacturacion.php";
		document.form2.target="_BLANK";
		document.form2.submit(); 
		document.form2.action="";
		document.form2.target="";
	}
	function seleccionarTodos(obj)
	{
		var totpredial = document.getElementById("totpredial");
		var totambiental = document.getElementById("totambiental");
		var totbomberil = document.getElementById("totbomberil");
		var total = document.getElementById("totalpred");
		//------ Arreglos de componentes 
		var listpredial = document.getElementsByName("predial[]");
		var listbomberil = document.getElementsByName("bomberil[]");
		var listambiental = document.getElementsByName("ambiental[]");
		var listotal = document.getElementsByName("total[]");
		
		var vartotpredial=0;
		var vartotambiental=0;
		var vartotbomberial=0;
		var vartotal=0;
		
		var checked = obj.checked;
		var checkboxes = document.getElementsByName("seleccion[]");
		if(checked){
			document.getElementById("contadorChecks").value = checkboxes.length;
			for(var i=0; i<checkboxes.length; i++){
				checkboxes.item(i).checked = true;
				vartotpredial += parseFloat(listpredial.item(i).value);
				vartotambiental += parseFloat(listambiental.item(i).value);
				vartotbomberial += parseFloat(listbomberil.item(i).value);
				vartotal += parseFloat(listotal.item(i).value);
			}
		}else{
			document.getElementById("contadorChecks").value = 0;
			for(var i=0; i<checkboxes.length; i++){
				checkboxes.item(i).checked = false;
				vartotpredial = 0;
				vartotambiental = 0;
				vartotbomberial = 0;
				vartotal = 0;
			}
		}
		totpredial.value = vartotpredial;
		totambiental.value = vartotambiental;
		totbomberil.value = vartotbomberial;
		total.value = vartotal;
		
	}
	function asignaValor(obj)
	{
		document.getElementById("vigfin").value = obj.value;
	}
	function acumular(obj,indice)
	{
		var totpredial = document.getElementById("totpredial");
		var totambiental = document.getElementById("totambiental");
		var totbomberil = document.getElementById("totbomberil");
		var total = document.getElementById("totalpred");
		//------ Arreglos de componentes 
		var listpredial = document.getElementsByName("predial[]");
		var listbomberil = document.getElementsByName("bomberil[]");
		var listambiental = document.getElementsByName("ambiental[]");
		var listotal = document.getElementsByName("total[]");
		
		var vartotpredial=parseFloat(totpredial.value);
		var vartotambiental=parseFloat(totambiental.value);
		var vartotbomberial=parseFloat(totbomberil.value);
		var vartotal=parseFloat(total.value);
		
		var valactcontador=parseInt(document.getElementById("contadorChecks").value);
		if(obj){
			document.getElementById("contadorChecks").value = valactcontador + 1;
			vartotpredial += parseFloat(listpredial.item(indice).value);
			vartotambiental +=parseFloat(listambiental.item(indice).value);
			vartotbomberial +=parseFloat(listbomberil.item(indice).value);
			vartotal +=parseFloat(listotal.item(indice).value);
		}else{
			document.getElementById("contadorChecks").value = valactcontador - 1;
			vartotpredial -= parseFloat(listpredial.item(indice).value);
			vartotambiental -=parseFloat(listambiental.item(indice).value);
			vartotbomberial -=parseFloat(listbomberil.item(indice).value);
			vartotal -=parseFloat(listotal.item(indice).value);
		}

		totpredial.value = vartotpredial;
		totambiental.value = vartotambiental;
		totbomberil.value = vartotbomberial;
		total.value = vartotal;
	}
	function acumularPorPredio(indice,objcheck,obj)
	{
		var json = eval(obj);
		var checkboxes = document.getElementsByName("seleccion[]");
		//------ Arreglos de componentes 
		var listpredial = document.getElementsByName("predial[]");
		var listbomberil = document.getElementsByName("bomberil[]");
		var listambiental = document.getElementsByName("ambiental[]");
		var listotal = document.getElementsByName("total[]");
		
		var totpredial = document.getElementById("totpredial");
		var totambiental = document.getElementById("totambiental");
		var totbomberil = document.getElementById("totbomberil");
		var total = document.getElementById("totalpred");
		
		var vartotpredial=parseFloat(listpredial.item(indice).value);
		var vartotambiental=parseFloat(listambiental.item(indice).value);
		var vartotbomberial=parseFloat(listbomberil.item(indice).value);
		var vartotal=parseFloat(listotal.item(indice).value);
		
		var estado=false;
		
		if(objcheck.checked){
			estado=true;
			vartotpredial += parseFloat(json.predial);
			vartotbomberial += parseFloat(json.bomberil);
			vartotambiental += parseFloat(json.ambiental);
			vartotal += parseFloat(json.total);

		}else{
			estado=false;
			vartotpredial -= parseFloat(json.predial);
			vartotbomberial -= parseFloat(json.bomberil);
			vartotambiental -= parseFloat(json.ambiental);
			vartotal -= parseFloat(json.total);
			
		}
		listpredial.item(indice).value = vartotpredial;
		listambiental.item(indice).value = vartotambiental;
		listbomberil.item(indice).value = vartotbomberial;
		listotal.item(indice).value = vartotal;
		if(checkboxes.item(indice).checked){
			totpredial.value = vartotpredial;
			totambiental.value = vartotambiental;
			totbomberil.value = vartotbomberial;
			total.value = vartotal;
		}
		
	
	}
	function guardar()
	{
		var contador = document.getElementById("contadorChecks").value;
		if(contador>0){
			despliegamodalm('visible','4','Esta Seguro de Guardar','1');
			document.form2.submit();
		}else{
			despliegamodalm('visible','2','Debe seleccionar por lo menos un predio');
		}
	}
</script>
<script type="text/javascript" src="jquery-1.11.0.min.js"></script> 
<script src="css/programas.js"></script>
<script src="css/funciones.js"></script>
<script type="text/javascript" src="css/calendario.js"></script>
<link href="css/css2.css" rel="stylesheet" type="text/css" />
<link href="css/css3.css" rel="stylesheet" type="text/css" />
<link href="css/tabs.css" rel="stylesheet" type="text/css" />

<script>
	$(window).load(function () {
		$('#cargando').hide();
	});
</script>

<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
	<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("teso");?></tr>
	<tr>
		<td colspan="3" class="cinta">
			<a href="teso-prefacturacion.php" class="mgbt"><img src="imagenes/add2.png" alt="Nuevo"  border="0" title="Nuevo"/></a> 
			<a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png"  alt="Guardar" title="Guardar"/></a>
			<a href="teso-buscaprefacturacion.php" class="mgbt"> <img src="imagenes/buscad.png"  alt="Buscar" title="Buscar" /></a>
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana" title="Nueva ventana"></a> 
			<a href="#" <?php if($_POST[oculto]==2) { ?> onClick="pdf()" <?php } ?> class="mgbt"> <img src="imagenes/print.png"  alt="Buscar" title="Imprimir"/></a>
			<a href="#" target="_blank" onClick="excel()" class="mgbt"><img src="imagenes/csv.png"  alt="csv" title="csv"></a>
		</td>
</tr>		  
</table>
<tr>
<td colspan="3" class="tablaprin" align="center"> 
<?php
	$vigencia=$_SESSION[vigencia];
	$_POST[codcatastral]  =Array();
	$_POST[terceros] = Array();
	$_POST[nterceros] = Array();
	$_POST[predial] = Array();
	$_POST[ambiental] = Array();
	$_POST[bomberil] = Array();
	$_POST[total] = Array();
	$_POST[rangovig] = Array();
	$_POST[tipo] = Array();
	if(isset($_GET[codigo])){   //Si existe codigo en URL, lo asigna a la variables POST
		$_POST[codigo] = $_GET[codigo];
	}
	if(!empty($_POST[codigo])){
		$sql="SELECT fecha_factura,rangovigencias,totpredial,totbomberil,totambiental,valortotal,tipomov FROM tesoprefacturacion WHERE 	codigo_factura = $_POST[codigo] ";
		$res= mysql_query($sql,$linkbd);
		while($row = mysql_fetch_row($res)){
			$_POST[fechaact] = $row[0];  // Fecha
			$rangos = explode("-" , $row[1]);  // Rangos
			
			$sqls1="SELECT rangovigencia,codcatastral,predial,bomberil,ambiental,valortotal,tercero,tipo FROM tesoprefacturacion_det WHERE codigo_factura='$_POST[codigo]'  ";
			$res1=mysql_query($sqls1,$linkbd);
			while($rows1 = mysql_fetch_row($res)){
				$_POST[rangovig][] = $row[0];
				$_POST[codcatastral][] = $row[1];
				$_POST[predial][] = $row[2];
				$_POST[bomberil][] = $row[3];
				$_POST[ambiental][] = $row[4];
				$_POST[total][] = $row[5];
				$_POST[terceros][] = $row[6];
				$_POST[nterceros][] = buscatercero($row[6]);
				$_POST[tipo][] = $row[7];	
				
			}
			
		}
	}
	

 ?>	
<div id="cargando" style=" position:absolute;left: 46%; bottom: 45%">
		<img src="imagenes/loading.gif" style=" width: 80px; height: 80px"/>
	</div>
<form name="form2" method="post" action="">
	<table class="inicio">
	    <tr>
    	  	<td class="titulos" colspan="11">Proceso de Pre-facturacion</td>
        	<td class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
  		</tr>
		<tr>
      	<tr>
			
			<td class="saludo3" style="width: 10%">Codigo:</td>
			<td style="width:12%;">
			<a href="#" onClick="atrasc()"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a>
			<input name="codigo"  type="text" value="<?php echo $_POST[codigo]?>"  id="codigo" style="width:50%;" readonly/>
			<a href="#" onClick="adelante()"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> 
			</td>
			<td class="saludo3" style="width: 10%">Fecha de facturacion:</td>
			<td style="width:13%;"><input name="fechaact" type="text" value="<?php echo $_POST[fechaact]?>"  id="fc_1198971545" title="DD/MM/YYYY" style="width:80%;" readonly />&nbsp;<a style="cursor:pointer;" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/calendario04.png" style="width:20px;"/></a></td>
        	<td class="saludo3" style="width: 10%">Deuda desde vigencia: </td>
            <td style="width: 7%">
				<select id="vigini" name="vigini" style="width:95%">
					<option value="" >Seleccione...</option>
					<?php
					for($i=1995; $i<date('Y'); $i++){
						if($_POST[vigini] == $i)
							echo "<option value='".$i."' selected>".$i."</option> ";
						else
							echo "<option value='".$i."'>".$i."</option> ";
					}
					?>
				</select>
           	</td>
			<td class="saludo3" style="width: 10%">Deuda hasta vigencia: </td>
            <td style="width: 7%">
				<select id="vigfin" name="vigfin" style="width:95%">
					<?php
					if(empty($_POST[vigfin])){ $_POST[vigfin] = date("Y");}
					for($i=1995; $i<=date('Y'); $i++){
						if($_POST[vigfin] == $i)
							echo "<option value='".$i."' selected>".$i."</option> ";
						else
							echo "<option value='".$i."'>".$i."</option> ";
					}
					?>
				</select>
           	</td>
			<td class="saludo3" style="width: 10%">Zona: </td>
            <td style="width: 15%">
				<select id="zona" name="zona" style="width:95%">
					<option value="">Seleccione...</option>
				</select>
           	</td>
        	<td>
            	<input type="button" name="buscar" value="  Buscar  " onClick="validar()" style="margin-left: 10%">
				<input name="oculto" type="hidden" value="<?php echo $_POST[oculto] ?>">
            </td>
      	</tr>
  	</table>
	<!-- Variables Ocultas Necesarias para ejecutar el metodo de funciones.inc -->
	<input type="hidden" name="basepredial" id="basepredial" value="<?php echo $_POST[basepredial]; ?>" />
	<input type="hidden" name="basepredialamb" id="basepredialamb" value="<?php echo $_POST[basepredialamb]; ?>" />
	<input type="hidden" name="aplicapredial" id="aplicapredial" value="<?php echo $_POST[aplicapredial]; ?>" />
	<input type="hidden" name="vigmaxdescint" id="vigmaxdescint" value="<?php echo $_POST[vigmaxdescint]; ?>" />
	<input type="hidden" name="porcdescint" id="porcdescint" value="<?php echo $_POST[porcdescint]; ?>" />
	<input type="hidden" name="aplicadescint" id="aplicadescint" value="<?php echo $_POST[aplicadescint]; ?>" />
	<input type="hidden" name="fecha" id="fecha" value="<?php echo $_POST[fecha]; ?>" />
	<input type="hidden" name="fechaav" id="fechaav" value="<?php echo $_POST[fechaav]; ?>" />
	<input type="hidden" name="vigencia" id="vigencia" value="<?php echo $_POST[vigencia]; ?>" />
	<input type="hidden" name="tasamora" id="tasamora" value="<?php echo $_POST[tasamora]; ?>" />
	<input type="hidden" name="tasa" id="tasa" value="<?php echo $_POST[tasa]; ?>" />
	<input type="hidden" name="descuento" id="descuento" value="<?php echo $_POST[descuento]; ?>" />
	<input type="hidden" name="catastral" id="catastral" value="<?php echo $_POST[catastral]; ?>" />
	<input type="hidden" name="ntercero" id="ntercero" value="<?php echo $_POST[ntercero]; ?>" />
	<input type="hidden" name="tercero" id="tercero" value="<?php echo $_POST[tercero]; ?>" />
	<input type="hidden" name="direccion" id="direccion" value="<?php echo $_POST[direccion]; ?>" />
	<input type="hidden" name="avaluo2" id="avaluo2" value="<?php echo $_POST[avaluo2]; ?>" />
	<input type="hidden" name="vavaluo" id="vavaluo" value="<?php echo $_POST[vavaluo]; ?>" />
	<input type="hidden" name="tipop" id="tipop" value="<?php echo $_POST[tipop]; ?>" />
	<input type="hidden" name="rangos" id="rangos" value="<?php echo $_POST[rangos]; ?>" />
	<input type="hidden" name="estrato" id="estrato" value="<?php echo $_POST[estrato]; ?>" />
	<input type="hidden" name="var1" id="var1" value="<?php echo $_POST[var1]; ?>" />
	<input type="hidden" name="var2" id="var2" value="<?php echo $_POST[var2]; ?>" />
	<input type="hidden" name="contadorChecks" id="contadorChecks" value="0" />
	
    <div class="subpantallac" style="height:60%; overflow-x:hidden;">
    	<table class="inicio">
      		<tr>
            	<td class="titulos" colspan="16">Predios Encontrados</td>
           	</tr>
      		<tr>
				<td class='titulos2'><input type="checkbox" name="todos" id="todos" onClick="seleccionarTodos(this)" <?php if(!empty($_POST[todos])){ echo "CHECKED"; } ?> /></td>
				<td class='titulos2'><img src='imagenes/plus.gif'></td>
				<td class="titulos2">Vigencias</td>
                <td class="titulos2">Cod Catastral</td>
				<td class="titulos2">ID. Tercero</td>
                <td class="titulos2">Tercero</td>
				<td class="titulos2">Tipo</td>
                <td class="titulos2">Predial</td>
				<td class="titulos2">Sobretasa Bomberial</td>
				<td class="titulos2">Sobretasa Ambiental</td>
				<td class="titulos2">Valor Total</td>
          	</tr>

			<?php
			// --------------------- FUNCIONES -------------------
				function limpiaNumero($numero){
				$num=0;
				$conca="";
				for($i=0;$i<strlen($numero);$i++ ){
					if($numero[$i]!=0){
						break;
					}else{
						$num++;
					}
				}
				return substr($numero,$num)."-".$num;
			}
			// --------------------- FIN / FUNCIONES -------------------
			?>

      		<?php		 	
				ini_set('max_execution_time', 7200);
				
				if(empty($_POST[totpredial])){
					$_POST[totpredial]=0;
				}
				
				if(empty($_POST[totambiental])){
					$_POST[totambiental]=0;
				}
				
				if(empty($_POST[totbomberil])){
					$_POST[totbomberil]=0;
				}
				
				if(empty($_POST[totalpred])){
					$_POST[totalpred]=0;
				}
				//if($_POST[oculto]==1){
					for($i=0; $i< count($_POST[codcatastral]); $i++ ){	
						$arregloFinal=generaReporteSinPagos($_POST[codcatastral][$i],$vigencia);
						$codcasarr=explode("-",limpiaNumero($_POST[codcatastral][$i]));
						$codcas=$codcasarr[0];
						$numceros=$codcasarr[1];
						echo "<tr class='saludo3'>
								<td><input type='checkbox' name='seleccion[]' CHECKED readonly/></td>
								<td class='titulos2'>
									<a onClick='verDetallePreFactura($i, $codcas,$numceros,".json_encode($arregloFinal).")' style='cursor:pointer;'>
										<img id='img".$i."' src='imagenes/plus.gif'>
									</a>
								</td>
								<td><input type='hidden' class='inpnovisibles' name='rangovig[]' value='".$_POST[rangovig][$i]."' readonly/>".$_POST[rangovig][$i]."</td>
								<td><input type='hidden' name='codcatastral[]' value='".$_POST[codcatastral][$i]."'/>".$_POST[codcatastral][$i]."</td>
								<td><input type='hidden' name='terceros[]' value='".$_POST[terceros][$i]."'/>".$_POST[terceros][$i]."</td>
								<td><input type='hidden' name='nterceros[]' value='".$_POST[nterceros][$i]."'/>".$_POST[nterceros][$i]."</td>
								<td><input type='hidden' name='tipo[]' value='".$_POST[tipo][$i]."'/>".$_POST[tipo][$i]."</td>
								<td width='10%'><input type='text' class='inpnovisibles' name='predial[]' value='".$_POST[predial][$i]."' readonly/></td>
								<td width='10%'><input type='text' class='inpnovisibles' name='bomberil[]' value='".$_POST[bomberil][$i]."' readonly/></td>
								<td width='10%'><input type='text' class='inpnovisibles' name='ambiental[]' value='".$_POST[ambiental][$i]."' readonly/></td>
								<td width='10%'><input type='text' class='inpnovisibles' name='total[]' value='".$_POST[total][$i]."' readonly/></td>
							</tr>
							<tr>
								<td align='center'></td>
								<td colspan='13' align='right'>
									<div id='detalle".$i."' style='display:none;'></div>
								</td>
							</tr>";
						}
				//}
			   
			
              ?> 
      	</table>
	</div>  
	
	<div class="subpantallac" style="height:20%; overflow-x:hidden;">
		<table class="inicio">
			<tr class="saludo3">
				<td width="60%"></td>
				<td width="10%"><input type="text" id="totpredial" name="totpredial" value="<?php echo $_POST[totpredial]; ?>" readonly/></td>
				<td width="10%"><input type="text" id="totbomberil" name="totbomberil" value="<?php echo $_POST[totbomberil]; ?>"  readonly/></td>
				<td width="10%"><input type="text" id="totambiental" name="totambiental" value="<?php echo $_POST[totambiental]; ?>" readonly/></td>
				<td width="10%"><input type="text" id="totalpred" name="totalpred" value="<?php echo $_POST[totalpred]; ?>" readonly/></td>
			</tr>
		</table>
	</div>
	<div id="bgventanamodalm" class="bgventanamodalm">
		<div id="ventanamodalm" class="ventanamodalm">
			<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
			</IFRAME>
		</div>
	</div>
	    
</form>
</td></tr>
</table>
</body>
</html>