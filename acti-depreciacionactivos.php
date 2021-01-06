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
				var validacion02=document.getElementById('nombre').value;
				if((validacion01.trim()!='')&&(validacion02.trim()!='')){
					despliegamodalm('visible','4','Esta Seguro de Guardar','1');
				}
				else {
					despliegamodalm('visible','2','Falta informacion para Crear Activos');
				}
	 		}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
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
					}
				}
			}
			
			function funcionmensaje(){
				document.location.href = "acti-creaciondepreciacionactivos.php";
			}
			
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":
						document.form2.oculto.value="2";
						document.form2.submit();
						break;
				}
			}
			
			function valcodigo(){
				document.form2.oculto.value="8";document.form2.submit();
			}
			function eliminar(){
				
			}
        </script>

        <script type="text/javascript">
        	$(document).ready(function() {
		    	$("#agrega").click(function(event) {

		    		var cuentact = $("#cuentact").val();
		    		var cuentarecuperacion = $("#cuentarecuperacion").val();
		    		var cuentaper = $("#cuentaper").val();
		    		var cuentaretiro = $("#cuentaretiro").val();

		    		var ncuentact = $("#ncuentact").val();
		    		var ncuentarecuperacion = $("#ncuentarecuperacion").val();
		    		var ncuentaper = $("#ncuentaper").val();
		    		var ncuentaretiro = $("#ncuentaretiro").val();

		    		var dispactivos = $("#dispactivos").val();
		    		var cc = $("#cc").val();

		    		var fecha1 = $("#fecha1").val();
		    		var fecha2 = $("#fecha2").val();


		    		if (fecha1 != "" && fecha2!="" && nombre != "" && cuentact!="" && cuentarecuperacion!="" && cuentaper!="" && cuentaretiro!="" && dispactivos!="" && cc!="") {
			    		//var tds=$("#tabla-activo-det tr:first td").length;
		    		 	var tds=15;
		    		 	var trs=$("#tabla-activo-det tr").length;
		    		 	console.log(trs);
		    		 	var separador="";
		    		 	if (trs > 2) {
		    		 		separador="|@@@|";
		    		 	}

		    		 	$("#veccuentact").val($("#veccuentact").val()+separador+cuentact);
		    		 	$("#veccuentarecuperacion").val($("#veccuentarecuperacion").val()+separador+cuentarecuperacion);
		    		 	$("#veccuentaper").val($("#veccuentaper").val()+separador+cuentaper);
		    		 	$("#veccuentaretiro").val($("#veccuentaretiro").val()+separador+cuentaretiro);
		    		 	$("#vecdispactivos").val($("#vecdispactivos").val()+separador+dispactivos);
		    		 	$("#veccc").val($("#veccc").val()+separador+cc);
		    		 	$("#vecfecha1").val($("#vecfecha1").val()+separador+fecha1);
		    		 	$("#vecfecha2").val($("#vecfecha2").val()+separador+fecha2);
		    		 	
		    		 	var style;
		    		 	if ((trs%2)==0) {
		    		 		style = "zebra1";
		    		 	}else{
		    		 		style = "zebra2";
		    		 	}
		    		 	var filadetalle="filadetalle"+(trs-1);
		    		 	var nuevaFila="<tr class='"+style+"' id='"+filadetalle+"'>";
		                // añadimos las columnas
		                nuevaFila+="<td align='center' >"+cc+"</td>";
		                nuevaFila+="<td align='center' >"+dispactivos+"</td>";

		                nuevaFila+="<td>"+fecha1+"</td>";
		                nuevaFila+="<td>"+fecha2+"</td>";

		                nuevaFila+="<td>"+cuentact+"</td>";
		                nuevaFila+="<td>"+ncuentact+"</td>";

		                nuevaFila+="<td>"+cuentarecuperacion+"</td>";
		                nuevaFila+="<td>"+ncuentarecuperacion+"</td>";

		                nuevaFila+="<td>"+cuentaper+"</td>";
		                nuevaFila+="<td>"+ncuentaper+"</td>";

		                nuevaFila+="<td>"+cuentaretiro+"</td>";
		                nuevaFila+="<td>"+ncuentaretiro+"</td>";
		            	nuevaFila+="<td><a href='#' onclick='eliminar()'><img src='imagenes/del.png' ></a></td>";
			            // Añadimos una columna con el numero total de columnas.
			            // Añadimos uno al total, ya que cuando cargamos los valores para la
			            // columna, todavia no esta añadida
			            nuevaFila+="</tr>";
			            $("#tabla-activo-det").append(nuevaFila);

	            	}else{
	            		alert("Ingrese todo los datos");
	            	}
		    	});        		
        	});
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
	  				<a onClick="location.href='acti-creaciondepreciacionactivos.php'" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
	  				<a onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a>
	  				<a onClick="location.href='acti-buscadepreciacionactivos.php'" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
	  				<a onClick="mypop=window.open('acti-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
  				</td>
           	</tr>
		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
  		<form name="form2" method="post" action="acti-creaciondepreciacionactivos.php">
            <table class="inicio" align="center" style='margin-top: 5px;'>
                <tr>
                    <td class="titulos" colspan="6">.: Agregar Activo</td>
                    <td class="cerrar" style="width:7%;" ><a onClick="location.href='acti-principal.php'">&nbsp;Cerrar</a></td>
                </tr>
                <tr>
                    <td class="saludo1" style="width:8%;">.: Codigo:</td>
                    <td style="width:13%;">
                    <?php 
                    	$sqlr="SELECT * FROM acti_activos_cab";
						$res=mysql_query($sqlr,$linkbd);
						$numId = mysql_num_rows($res);
						$numId++;
                    ?>
                    <input type="text" name="codigo" id="codigo" value="<?php echo $numId ?>" style="width:100%;" readonly /></td>
                    <td class="saludo1" style="width:15%;">.: Nombre:</td>
                    <td><input type="text" name="nombre" id="nombre" value="<?php echo $_POST[nombre]?>" style="width:100%;" onKeyUp="return tabular(event,this)"/></td>
             
                    <td class="saludo1">.: Activo:</td>
                    <td>
                        <select name="estado" id="estado" style="width:100%;">
                            <option value="S" <?php if ($_POST[estado]=="S"){echo "selected";}?>>SI</option>
                            <option value="N" <?php if ($_POST[estado]=="N"){echo "selected";}?>>NO</option>
                        </select>   
                 </td>
                </tr>  
            </table>
            <input type="hidden" name="oculto" id="oculto" value="1"/>

            <input type="hidden" name="veccuentact" id="veccuentact"/>
            <input type="hidden" name="veccuentarecuperacion" id="veccuentarecuperacion"/>
            <input type="hidden" name="veccuentaper" id="veccuentaper"/>
            <input type="hidden" name="veccuentaretiro" id="veccuentaretiro"/>
            <input type="hidden" name="vecdispactivos" id="vecdispactivos"/>
            <input type="hidden" name="veccc" id="veccc"/>
            <input type="hidden" name="vecfecha1" id="vecfecha1"/>
            <input type="hidden" name="vecfecha2" id="vecfecha2"/>

            <input type="hidden" name="valfocus" id="valfocus" value="1"/> 

	<table class="inicio" style='margin-top: 5px;'>
		<tr><td colspan="6" class="titulos2">Crear Detalle Clasificacion</td></tr>	
			
		<tr>        
        	<td class="saludo1" style='width:10%'>Cuenta Debito Depreciacion:</td>
           	<td style='width:10%'>
           		<input type="text" id="cuentarecuperacion" name="cuentarecuperacion"  onKeyPress="javascript:return solonumeros(event)" 
              		onKeyUp="return tabular(event,this)" onBlur="buscacta('3')" value="<?php echo $_POST[cuentarecuperacion]?>" onClick="document.getElementById('cuentarecuperacion').focus();document.getElementById('cuentact').select();" style='width:80%'>
              	<input type="hidden" value="0" name="bcrecu">
              	<a href="#" onClick="mypop=window.open('cuentasgral-ventana.php?objeto=cuentarecuperacion&nobjeto=ncuentarecuperacion','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();">
              	&nbsp;<img src="imagenes/buscarep.png" style='width:16px'>
              	</a>
          	</td>
            <td style='width:30%'>
            	<input name="ncuentarecuperacion" type="text" id="ncuentarecuperacion" value="<?php echo $_POST[ncuentarecuperacion]?>" style='width:100%' readonly>
        	</td>
			<td class="saludo1" style='width:10%'>Cuenta Credito Depreciacion:</td>
        	<td style='width:10%'>
        		<input type="text" id="cuentaretiro" name="cuentaretiro"  onKeyPress="javascript:return solonumeros(event)" 
              		onKeyUp="return tabular(event,this)" onBlur="buscacta('4')" value="<?php echo $_POST[cuentaretiro]?>" onClick="document.getElementById('cuentaretiro').focus();document.getElementById('cuentaretiro').select();" style='width:80%'>
          		<input type="hidden" value="0" name="bcret">
          		<a href="#" onClick="mypop=window.open('cuentasgral-ventana.php?objeto=cuentaretiro&nobjeto=ncuentaretiro','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();">
          		&nbsp;<img src="imagenes/buscarep.png" style='width:16px'>
          		</a>
      		</td>
          	<td style='width:30%'>
          		<input id="ncuentaretiro" name="ncuentaretiro" type="text" value="<?php echo $_POST[ncuentaretiro]?>" style='width:100%' readonly>
      		</td>
		</tr>
		<tr>
			<td class="saludo1">Disposicion de los Activos:</td>
    		<td colspan="2">
				<select id="dispactivos" name="dispactivos" onKeyUp="return tabular(event,this)" style="width: 100%;">
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
			<td class="saludo1" style="width:10%">Fehca Inicial:</td>
			<td style="width:10%;">
				<input name="fecha1" id="fecha1" type="text" id="fecha1" title="YYYY-MM-DD" style="width:75%;" value="<?php echo $_POST[fecha1]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" tabindex="2"/>&nbsp;<a href="#" onClick="displayCalendarFor('fecha1');" tabindex="3" title="Calendario"><img src="imagenes/calendario04.png" align="absmiddle" style="width:20px;"></a>
			</td>    		
        </tr>
        <tr>
			<td class="saludo1">Centro de Costos:</td>
    		<td colspan="2">
				<select id="cc" name="cc" onKeyUp="return tabular(event,this)" style="width: 100%;">
				<?php
					$sqlr="SELECT * from centrocosto where estado='S'";
					$res=mysql_query($sqlr,$linkbd);
					while ($row =mysql_fetch_row($res)){
						echo "<option value=$row[0] ";
						$i=$row[0];
					 	if($i==$_POST[cc]){
							echo "SELECTED";
						}
						echo ">".$row[0]." - ".$row[1]."</option>";	 	 
					}	 	
				?>
	   			</select>
	 		</td>

			<td class="saludo1" style="width:10%;">Fecha Final:</td>
			<td style="width:10%;">
				<input name="fecha2" id="fecha2" type="text" id="fecha2" title="YYYY-MM-DD" style="width:75%;" value="<?php echo $_POST[fecha2]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" tabindex="2"/>&nbsp;<a href="#" onClick="displayCalendarFor('fecha2');" tabindex="3" title="Calendario"><img src="imagenes/calendario04.png" align="absmiddle" style="width:20px;"></a>
			</td>


	 		<td>
	 			<input type="button" name="agrega" id="agrega" value="Agregar">
	 			<input type="hidden" value="0" name="agregadet">
 			</td>
        </tr>
	</table>

	<div class="subpantallac" style="height:49.5%; width:99.6%;">
		<table class="inicio" id="tabla-activo-det" name="tabla-activo-det">
			<tr>
				<td class="titulos" colspan="15">Detalle Activos</td>
			</tr>
			<tr>
				<td class="titulos2">CC</td>
				<td class="titulos2">Disp. Activos</td>

				<td class="titulos2">Fecha Ini.</td>
				<td class="titulos2">Fecha Fin.</td>
				
				<td class="titulos2">Cuenta Debito Depreciacion</td>
				<td class="titulos2">Nombre Cuenta</td>
				
				<td class="titulos2">Cuenta Credito Depreciacion</td>
				<td class="titulos2">Nombre Cuenta</td>

		

				<td class="titulos2">
					<img src="imagenes/del.png" ><input type='hidden' name='elimina' id='elimina'>
				</td>
			</tr>
		</table>
	</div>
  			<?php
  				echo $_POST[oculto];
				if($_POST[oculto]=="2")
				{	
					$sqlr="INSERT INTO acti_activos_cab (nombre,estado) VALUES ('$_POST[nombre]','$_POST[estado]')";
					//echo $sqlr;
					if (!mysql_query($sqlr,$linkbd)){
						echo "<script>despliegamodalm('visible','2','No se pudo ejecutar la petición');</script>";
					}
					else {
						$veccuentact = explode("|@@@|", $_POST[veccuentact]);
						$veccuentarecuperacion = explode("|@@@|", $_POST[veccuentarecuperacion]);
						$veccuentaper = explode("|@@@|", $_POST[veccuentaper]);
						$veccuentaretiro = explode("|@@@|", $_POST[veccuentaretiro]);
						$vecdispactivos = explode("|@@@|", $_POST[vecdispactivos]);
						$veccc = explode("|@@@|", $_POST[veccc]);
						$vecfecha1 = explode("|@@@|", $_POST[vecfecha1]);
						$vecfecha2 = explode("|@@@|", $_POST[vecfecha2]);
						for ($i=0; $i < count($veccuentact); $i++) { 
							# code...
						
							$sqlr="INSERT INTO acti_activos_det (id_cab,fechainicial,fechafinal,cuenta_activo,cuenta_perdida,cuenta_recuperacion,cuenta_retiro,disposicion_activos,centro_costos) 
							VALUES ('$_POST[codigo]','$vecfecha1[$i]','$vecfecha2[$i]','$veccuentact[$i]','$veccuentaper[$i]','$veccuentarecuperacion[$i]','$veccuentaretiro[$i]','$vecdispactivos[$i]','$veccc[$i]')";
							echo $sqlr;
							if (!mysql_query($sqlr,$linkbd)){
								echo "<script>despliegamodalm('visible','2','No se pudo ejecutar la petición');</script>";
							}else{
								echo "<script>despliegamodalm('visible','1','Se ha almacenado con Exito');</script>";
							}
						}
					}
				}
			?>
        	<script type="text/javascript">$('#nombre').alphanum({allow: ''});</script>
       		<script type="text/javascript">$('#codigo').numeric({allowThouSep: false,allowDecSep: false,allowMinus: false,maxDigits: 2});</script> 
		</form>
	</body>
</html>