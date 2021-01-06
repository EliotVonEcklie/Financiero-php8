<?php //V 1001 17/12/2016 ?>
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
		<title>:: Spid - Control de Activos</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
        <script type='text/javascript' src='JQuery/jquery-2.1.4.min.js'></script>
        <script type="text/javascript" src="JQuery/alphanum/jquery.alphanum.js"></script>
        <script type="text/javascript" src="css/calendario.js"></script>
        <?php titlepag();?>
		<script>
        	function guardar()
			{
				var validacion01=document.getElementById('codigo').value;
				var validacion02=document.getElementById('descrip').value;
				var validacion03=document.getElementById('fc_1198971545').value;
				var validacion04=document.getElementById('tipo').value;
				if((validacion01.trim()!='')&&(validacion02.trim()!='')&&(validacion03.trim()!='')&&(validacion04.trim()!='')){
					despliegamodalm('visible','4','Esta Seguro de Guardar','1');
				}
				else {
					despliegamodalm('visible','2','Falta informacion para Crear la Orden');
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
				document.location.href = "acti-montajes.php";
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
			
			function validar(){document.form2.submit();}
			function validar2(formulario)
			{
				document.form2.action="acti-montajes.php";
				document.form2.submit();
			}
			
        </script>

		<script type="text/javascript">
		function adelante(scrtop, numpag, limreg, filtro, next){
			var maximo=document.getElementById('maximo').value;
			var actual=document.getElementById('codigo').value;
			if(parseFloat(maximo)>parseFloat(actual)){
				document.getElementById('oculto').value='1';
				document.getElementById('codigo').value=next;
				var idcta=document.getElementById('codigo').value;
				document.form2.action="teso-editaingresos.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
				document.form2.submit();
			}
		}
		
			
		function atrasc(scrtop, numpag, limreg, filtro, prev){
			var minimo=document.getElementById('minimo').value;
			var actual=document.getElementById('codigo').value;
			if(parseFloat(minimo)<parseFloat(actual)){
				document.getElementById('oculto').value='1';
				document.getElementById('codigo').value=prev;
				var idcta=document.getElementById('codigo').value;
				document.form2.action="teso-editaingresos.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
				document.form2.submit();
			}
		}			
			
		function iratras(){
			location.href="acti-gestiondelosactivos.php";
		}
		</script>

	</head>
	<body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
		<table>
    		<tr><script>barra_imagenes("acti");</script><?php cuadro_titulos();?></tr>	 
    		<tr><?php menu_desplegable("acti");?></tr>
			<tr>
  				<td colspan="3" class="cinta">
	  				<a onClick="location.href='acti-montajes.php'" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
	  				<a onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a>
	  				<a onClick="location.href='acti-buscamontajes.php'" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
	  				<a onClick="mypop=window.open('acti-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
  					<a onclick="iratras()" class="mgbt"><img src="imagenes/iratras.png" title="AtrÃ¡s"></a>
  				</td>
           	</tr>
		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
  		<form name="form2" method="post" action="acti-montajes.php">
            <table class="inicio" align="center" style='margin-top: 5px;'>
                <tr>
                    <td class="titulos" colspan="4">.: Agregar Orden</td>
                    <td class="cerrar" style="width:7%;" ><a onClick="location.href='acti-principal.php'">&nbsp;Cerrar</a></td>
                </tr>
                <tr>
                    <td class="saludo1" style="width:8%;">.: Orden:</td>
                    <td style="width:13%;">
                    <?php 
                    	$sqlr="SELECT * FROM acti_montajes ORDER BY orden DESC";
						$res=mysql_query($sqlr,$linkbd);
						if(mysql_num_rows($res)!=0){
							$wid=mysql_fetch_array($res);
							$numId=$wid[0]+1;
						}
						else{$numId=1;}
                    ?>
						<a href="#" onClick="atrasc(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $prev; ?>)">
				        	<img src="imagenes/back.png" alt="anterior" align="absmiddle">
				        </a>
						<input type="text" name="codigo" id="codigo" value="<?php echo $numId ?>" style="width:70%;" readonly />
						<a href="#" onClick="adelante(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $next; ?>)">
							<img src="imagenes/next.png" alt="siguiente" align="absmiddle">
						</a>
					</td>
					<td class="saludo1" style="width:8%;">Fecha:</td>
					<td>
						<input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">         <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>        
						<input type="hidden" name="chacuerdo" value="1">
					</td>
                </tr>  
            </table>
            <input type="hidden" name="oculto" id="oculto" value="1"/>
            <input type="hidden" name="valfocus" id="valfocus" value="<?php echo $_POST[valfocus]; ?>"/>

	<table class="inicio" style='margin-top: 5px;'>
		<tr><td colspan="4" class="titulos2">Crear Detalle Orden</td></tr>	
		<tr>
			<td class="saludo1" style="width:10%">Descripci&oacute;n:</td>
			<td style="width:90%;" colspan="5">
				<textarea name="descrip" id="descrip" style="width:95%;" rows="5"><?php echo $_POST[descrip]; ?></textarea>
			</td>    
		</tr>
		<tr>
			<td class="saludo1" style="width:10%">Clase:</td>
			<td style="width:40%">
				<select id="clasificacion" name="clasificacion" onChange="document.form2.submit()" style="width:90%">
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
				<select id="grupo" name="grupo" onChange="document.form2.submit()" style="width:90%">
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
				<select id="tipo" name="tipo" onChange="document.form2.submit()" style="width:90%">
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
			<td class="saludo1" style="width:10%">Disposici&oacute;n de los Activos:</td>
			<td style="width:40%">
				<select id="dispactivos" name="dispactivos" onKeyUp="return tabular(event,this)" style="width: 90%;">
				<?php
					$sqlr="SELECT * from acti_disposicionactivos where estado='S' AND id='4'";
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
		<tr>
			<td class="saludo1" style='width:10%'>Secretar&iacute;a Responsable:</td>
        	<td style='width:40%'>
				<select name="ubicacion" onChange="validar()" style="width:90%">
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
        	<td class="saludo1" style='width:10%'>Supervisor:</td>
           	<td style='width:40%'>
				<input name="supervisor" id="supervisor" type="text"  value="<?php echo $_POST[supervisor]?>" onKeyUp="return tabular(event,this) " style="width:90%;" onBlur="validar2()">
          	</td>
		</tr>		
	</table>

	<div class="subpantallac" style="height:49.5%; width:99.6%;">
		<table class="inicio" id="tabla-activo-det" name="tabla-activo-det">
			<tr>
				<td class="titulos" colspan="15">Detalle Costos</td>
			</tr>
			<tr>
				<td class="titulos2">Documento</td>
				<td class="titulos2">Fecha</td>
				<td class="titulos2">Concepto</td>
				<td class="titulos2">Valor</td>
			</tr>
		</table>
	</div>
	<?php
	if($_POST[oculto]=="2")
	{	
		$fecha=cambiar_fecha($_POST[fecha]);
//		echo $fecha;
		$sqlr="INSERT INTO acti_montajes (orden, fecha, descripcion, supervisor, secretaria, clase, grupo, tipo, disposicion, estado) VALUES ('$_POST[codigo]', '$fecha', '$_POST[descrip]', '$_POST[supervisor]', '$_POST[ubicacion]', '$_POST[clasificacion]', '$_POST[grupo]', '$_POST[tipo]', '4', 'S')";
		if (!mysql_query($sqlr,$linkbd)){
			echo "<script>despliegamodalm('visible','2','No se pudo ejecutar la petición');</script>";
		}
		else {
			echo "<script>despliegamodalm('visible','1','Se ha almacenado con Exito');</script>";
		}
	}
	?>
		</form>
	</body>
</html>