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
		<title>:: Spid - Donacion de Activos</title>
		<link href="css/css2.css" rel="stylesheet" type="text/css" />
		<link href="css/css3.css" rel="stylesheet" type="text/css" />
		<link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="botones.js"></script>
		<script type='text/javascript' src='JQuery/jquery-2.1.4.min.js'></script>
		<script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
		<script src="JQuery/autoNumeric-master/autoNumeric-min.js"></script>
        <?php titlepag();?>
		<script>
		
			function guiabuscar(){
				document.form2.submit();
			}
			
        	function guardar()
			{
				var validacion01=document.getElementById('codigo').value;
				var validacion03=document.getElementById('fc_1198971545').value;
				var validacion07=document.getElementById('ndocum').value;
				var clases = document.getElementsByName('dclase[]');
				
				var valorActo = (parseFloat)(document.getElementById("valor").value);
				var valorOrden = (parseFloat)(document.getElementById("valortotal").value);
				
				if((validacion01.trim()!='')&&(validacion03.trim()!='')&&(validacion07.trim()!='')&&(clases.length > 0)){
					despliegamodalm('visible','4','Esta Seguro de Guardar','1');
				}
				else if(valorActo < valorOrden){
					despliegamodalm('visible','2','El valor total de la orden no puede superar el del acto');
				}
				else{
					despliegamodalm('visible','2','Falta informacion para Crear la Orden');
				}
	 		}
			
			function agregardetalle()
			{
				var valores = document.getElementsByName('dvalor[]');
				var validacion01=document.getElementById('codigo').value;
				var validacion02=document.getElementById('descrip').value;
				var validacion03=document.getElementById('fc_1198971545').value;
				var validacion04=document.getElementById('tipo').value;
				var validacion05=(parseFloat)(document.getElementById('valord').value);
				var validacion06=(parseFloat)(document.getElementById('valor').value);
				var validacion07=document.getElementById('ndocum').value;
				var validacion08=document.getElementById('cc').value;
				var sum = 0;
				for(var i = 0; i< valores.length; i++){
					sum +=(parseFloat)(valores.item(i).value);
				}
				
				if((validacion01.trim()!='')&&(validacion02.trim()!='')&&(validacion03.trim()!='')&&(validacion04.trim()!='')&&(validacion07.trim()!='')&&(validacion08!='')&&(validacion05!='')){
					if(validacion05!=0){
						var total = sum+validacion05;
						if((total<=validacion06)){
							sinpuntitos('valaux','valor');
							document.form2.agregadet.value=1;
							document.form2.submit();
						}else{
							despliegamodalm('visible','2','No puede exceder el valor total del acto');
						}
					}else{
						despliegamodalm('visible','2','El valor debe ser diferente de cero');
					}
					
					
				}
				else {
					despliegamodalm('visible','2','Falta informacion para poder Agregar');
				}
			}
			
			function eliminar(variable)
			{
				despliegamodalm('visible','5','Esta Seguro de Eliminar','2',variable);
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
							document.getElementById('ventanam').src="acti-ventana-recuperacion.php";break;
					}
				}
			}
			
			function funcionmensaje(){
				document.location.href = "acti-editardonaciones.php?idcta="+document.getElementById('codigo').value
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
						vvend=document.getElementById('elimina');
						vvend.value=variable;
						document.form2.submit();
						break;
				}
			}
			
			function validar(){
				document.form2.submit();
			}
			function validarl(){
				vaciar();
				document.form2.submit();
			}
			function vaciar(){
				document.form2.codigo.value="";
				document.form2.valor.value="";
				document.form2.fecha.value="";
				document.form2.submit();
			}
			
			function validar2(formulario)
			{
				document.form2.action="acti-donaciones.php";
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
				document.form2.action="acti-editardonaciones.php?idcta="+idcta;
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
				document.form2.action="acti-editardonaciones.php?idcta="+idcta;
				document.form2.submit();
			}
		}
		
		function iratras(){
			location.href="acti-gestiondelosactivos.php";
		}
		
		</script>
		<script>
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
					if(v=='01')
					{
						document.getElementById('ventana2').src="activentana-donacion.php";
					}else if(v == '02'){
						document.getElementById('ventana2').src="acti-ventana-recuperacion.php";
					}
				}
			}
			else{
				despliegamodalm('visible','2','Seleccione el Origen del Activo');
			}
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
	  				<a onClick="location.href='acti-donaciones.php'" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
	  				<a onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a>
	  				<a onClick="location.href='acti-buscadonaciones.php'" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
	  				<a onClick="mypop=window.open('acti-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
  					<a onclick="iratras()" class="mgbt"><img src="imagenes/iratras.png" title="AtrÃ¡s"></a>
  				</td>
           	</tr>
		</table>
		<?php
		if($_POST[oculto]==""){
			$_POST[tipomov]='1';
			$_POST[fecha]=date('d/m/Y');
		}
		
		ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
		$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
		if(!isset($_POST[valord])){
			$_POST[valord] = 0;
		}
		
		if(!isset($_POST[valor])){
			$_POST[valor] = 0;
			$_POST[valaux] = 0;
		}
		?>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
  		<form name="form2" method="post" action="acti-donaciones.php">
			<table class="inicio">
				<tr>
					<td class="titulos" style="width:100%;">.: Tipo de Movimiento:
                        <input type="hidden" name="oculto" id="oculto" value="1"/>
						<select name="tipomov" id="tipomov" onChange="validarl()"  style="width:20%;" >
                            <option value="-1">Seleccione ....</option>
                            <option value="1" <?php if($_POST[tipomov]=='1') echo "SELECTED"; ?>>1 - Entrada</option>
                            <option value="3" <?php if($_POST[tipomov]=='3') echo "SELECTED"; ?>>3 - Reversi&oacute;n de Entrada</option>
                        </select>
            			<input type="hidden" name="sw"  id="sw" value="<?php echo $_POST[tipomov] ?>" />
				</td>
				<td style="width:80%;">
				</td>
				</tr>
			</table>
			<?php
			if($_POST[tipomov]=='1'){
			?>
            <table class="inicio" align="center" style='margin-top: 5px;'>
                <tr>
                    <td class="titulos" colspan="9">.: Agregar Orden</td>
                    <td class="cerrar" style="width:7%;" ><a onClick="location.href='acti-principal.php'">&nbsp;Cerrar</a></td>
                </tr>
                <tr>
                    <td class="saludo1" style="width:8%;">.: Orden:</td>
                    <td style="width:8%;">
                    <?php 
                    	$sqlr="SELECT * FROM acti_recuperaciones_cab ORDER BY id DESC";
						$res=mysql_query($sqlr,$linkbd);
						if(mysql_num_rows($res)!=0){
							$wid=mysql_fetch_array($res);
							$numId=$wid[0]+1;
						}
						else{$numId=1;}
                    ?>
						<input type="text" name="codigo" id="codigo" value="<?php echo $numId ?>" style="width:90%;" readonly />
						<input type="hidden" name="tercero" id="tercero" value="<?php echo $_POST[tercero]; ?>" />
					</td>
					<td class="saludo1" style="width:8%;">Fecha:</td>
					<td>
						<input type="text" name="fecha" id="fc_1198971545" title="DD/MM/YYYY" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)" maxlength="10" style="width: 70%"/>&nbsp;<img src="imagenes/calendario04.png" title="Calendario"  onClick="displayCalendarFor('fc_1198971545');" class="icobut" />       
						<input type="hidden" name="chacuerdo" value="1">
					</td>
					<td class='saludo1' style='width:6%;'>Documento</td>
					<td style="width:12%;">
						<input type="text" name="docum" id="docum" value="<?php echo $_POST[docum]; ?>" onKeyPress="javascript:return solonumeros(event)" onBlur="guiabuscar()" style="width:80%"/>&nbsp;<img class="icobut" src="imagenes/find02.png"  title="Lista de Actos de Recuperacion" onClick="despliegamodal2('visible','02');"/></td>
					<td style="width:20%"><input type="text" name="ndocum" id="ndocum" value="<?php echo $_POST[ndocum]; ?>" style="width:100%;text-transform:uppercase" readonly/></td>
					<td class="saludo1">Valor:</td>
					<td>
						<input type="text" name="valor" id="valor" onKeyPress="javascript:return solonumeros(event)" onKeyUp="puntitos(this,this.value.charAt(this.value.length-1))" value="<?php echo $_POST[valor]?>" style="text-align:right; width: 100%" readonly>
						<input type="hidden" value='<?php echo $_POST[valaux]?>' name="valaux" id="valaux">
					</td>
                </tr>  
            </table>
            <input type="hidden" name="valfocus" id="valfocus" value="<?php echo $_POST[valfocus]; ?>"/>
			<table class="inicio" style='margin-top: 5px;'>
				<tr><td colspan="7" class="titulos2">Crear Detalle Orden</td></tr>	
				<tr>
					<td class="saludo1" style="width:10%">Descripci&oacute;n:</td>
					<td style="width:90%;" colspan="7">
						<textarea name="descrip" id="descrip" style="width:100%;" rows="5"><?php echo $_POST[descrip]; ?></textarea>
					</td>    
				</tr>
				<tr>
					<td class="saludo1" style="width:10%">Clase:</td>
					<td style="width:40%">
						<select id="clasificacion" name="clasificacion" onChange="document.form2.submit()" style="width:90%" >
							<option value="">...</option>
							<?php
							$linkbd=conectar_bd();
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
					<td class="saludo1">Grupo:</td>
					<td colspan="4">
						<select id="grupo" name="grupo" onChange="document.form2.submit()" style="width:100%">
							<option value="">...</option>
							<?php
							$linkbd=conectar_bd();
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
				</tr>
				<tr>
					<td class="saludo1" style="width:10%">Tipo:</td>
					<td style="width:40%">
						<select id="tipo" name="tipo" onChange="document.form2.submit()" style="width:90%">
							<option value="">...</option>
							<?php
							$linkbd=conectar_bd();
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
					<td class="saludo1" style="width:10%">Disposici&oacute;n de los Activos:</td>
					<td colspan="4">
						<select id="dispactivos" name="dispactivos" onKeyUp="return tabular(event,this)" style="width: 100%;">
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
				<tr>
					<td class="saludo1" style='width:10%'>Secretar&iacute;a Responsable:</td>
					<td style='width:40%'>
						<select name="ubicacion" id="ubicacion" onChange="validar()" style="width:90%">
							<option value="">...</option>
							<?php
							$linkbd=conectar_bd();
							$sqlr="Select * from actiubicacion where estado='S'";
							$resp = mysql_query($sqlr,$linkbd);
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
					<td style='width:20%'>
						<input name="supervisor" id="supervisor" type="text"  value="<?php echo $_POST[supervisor]?>" onKeyUp="return tabular(event,this) " style="width:100%;">
					</td>
					<td class="saludo1" style='width:10%'>Valor:</td>
					<td >
					<td >
						<input name="valord" id="valord" type="text"  value="<?php echo $_POST[valord]?>" onKeyPress="javascript:return solonumeros(event)"  style="width:100%;">
					</td>
	
				</tr>
				<tr>
				<td class="saludo1" style='width:10%'>Centro de costo:</td>
				<td>
					<select name="cc" id="cc" onKeyUp="return tabular(event,this)" onChange="validar()" style="width:70%">
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
					<input type="button" name="agrega" value="  Agregar Activo " onClick="agregardetalle()" style="width: 20%">
					<input type="hidden" value="0" name="agregadet">
					<input type="hidden" value="0" name="valortotal" id="valortotal">
				</td>
				</tr>
			</table>
			<?php 
			if ($_POST[elimina]!='')
			{ 		 
				$posi=$_POST[elimina];
				unset($_POST[ddescrip][$posi]);
				unset($_POST[dclase][$posi]);
				unset($_POST[dgrupo][$posi]);
				unset($_POST[dtipo][$posi]);
				unset($_POST[ddispo][$posi]);
				unset($_POST[dsecrerespon][$posi]);
				unset($_POST[dsupervi][$posi]);
				unset($_POST[dvalor][$posi]);
				unset($_POST[dcc][$posi]);
				$_POST[ddescrip]= array_values($_POST[ddescrip]);
				$_POST[dclase]= array_values($_POST[dclase]);
				$_POST[dgrupo]= array_values($_POST[dgrupo]);
				$_POST[dtipo]= array_values($_POST[dtipo]);
				$_POST[ddispo]= array_values($_POST[ddispo]);
				$_POST[dsecrerespon]= array_values($_POST[dsecrerespon]);
				$_POST[dsupervi]= array_values($_POST[dsupervi]);
				$_POST[dvalor]= array_values($_POST[dvalor]);
				$_POST[dcc]= array_values($_POST[dcc]);
				$_POST[con]=$_POST[con]-1;
			}
			if ($_POST[agregadet]=='1')
			{
				$_POST[ddescrip][]=$_POST[descrip];
				$_POST[dclase][]=$_POST[clasificacion];
				$_POST[dgrupo][]=$_POST[grupo];
				$_POST[dtipo][]=$_POST[tipo];
				$_POST[ddispo][]=$_POST[dispactivos];
				$_POST[dsecrerespon][]=$_POST[ubicacion];
				$_POST[dsupervi][]=$_POST[supervisor];
				$_POST[dvalor][]=$_POST[valord];
				$_POST[dcc][]=$_POST[cc];
				$_POST[con]=$_POST[con]+1;
				$_POST[agregadet]=0;
				echo"<script>
					$('#descrip').val('');
					$('#clasificacion').val('');
					$('#grupo').val('');
					$('#tipo').val('');
					$('#dispactivos').val('');
					$('#ubicacion').val('');
					$('#supervisor').val('');
					$('#cc').val('');
					$('#valord').val('0');
				</script>";
			}?>
			<div class="subpantallac" style="height:30%; width:99.6%;">
				<table class="inicio" id="tabla-activo-det" name="tabla-activo-det">
					<tr>
						<td class="titulos" colspan="15">Detalle Costos</td>
					</tr>
					<tr>
						<td class="titulos2" style="width:35%">Descripcion</td>
						<td class="titulos2">Clase</td>
						<td class="titulos2">grupo</td>
						<td class="titulos2">tipo</td>
						<td class="titulos2">disposicion</td>
						<td class="titulos2">Secr. Responsable</td>
						<td class="titulos2" style="width:22%">Supervisor</td>
						<td class="titulos2" >CC</td>
						<td class="titulos2" style="width:10%">valor</td>
						<td class="titulos2" style="width:5%"><img src="imagenes/del.png" ><input type='hidden' name='elimina' id='elimina'></td>
					</tr>
					<?php
					$iter='zebra1';
					$iter2='zebra2';
					$aux='';
					$valact = 0;
					for ($x=0;$x< count($_POST[dclase]);$x++)
					{
						echo "<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
							onMouseOut=\"this.style.backgroundColor=anterior\" >
							<td style='width:7%'><input name='ddescrip[]' value='".$_POST[ddescrip][$x]."' type='text' class='inpnovisibles' style='width:100%' readonly></td>
							<td style='width:2%'><input name='dclase[]' value='".$_POST[dclase][$x]."' type='text' style='width:100%' class='inpnovisibles' readonly></td>
							<td style='width:2%'><input name='dgrupo[]' value='".$_POST[dgrupo][$x]."' type='text' style='width:100%' class='inpnovisibles' readonly></td>
							<td style='width:2%'><input name='dtipo[]' value='".$_POST[dtipo][$x]."' type='text' style='width:100%' class='inpnovisibles' readonly></td>
							<td style='width:5%'><input name='ddispo[]' value='".$_POST[ddispo][$x]."' type='text' style='width:100%' class='inpnovisibles' readonly></td>
							<td style='width:5%'><input name='dsecrerespon[]' value='".$_POST[dsecrerespon][$x]."' type='text' style='width:100%' class='inpnovisibles' readonly></td>
							<td style='width:5%'><input name='dsupervi[]' value='".$_POST[dsupervi][$x]."' type='text' style='width:100%' class='inpnovisibles' readonly></td>
							<td style='width:3%'><input name='dcc[]' value='".$_POST[dcc][$x]."' type='text' style='width:100%' class='inpnovisibles' readonly></td>
							<td style='width:5%'><input name='dvalor[]' value='".$_POST[dvalor][$x]."' type='text' style='width:100%' class='inpnovisibles' readonly></td>
							<td style='text-align:center;'><a href='#' onclick='eliminar($x)'><img src='imagenes/del.png'></a></td></tr>";
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
						$valact=+$_POST[dvalor][$x];
					}
					echo "<script>document.getElementById('valortotal').value= $valact; </script>";
					?>
					<tr><td colspan="8"></td><td>$ <?php echo number_format($valact,2); ?></td></tr>
				</table>
			</div>
			<?php
		}else{
			if($_POST[cont]==""){
				$_POST[codigo]="";
				$_POST[cont]=1;
			};
			?>
			
			<table class="inicio" align="center" style='margin-top: 5px;'>
                <tr>
                    <td class="titulos" colspan="6">.: Documento a Reversar</td>
                    <td class="cerrar" style="width:7%;" ><a onClick="location.href='acti-principal.php'">&nbsp;Cerrar</a></td>
                </tr>
                <tr>
                    <td class="saludo1" style="width:8%;">.: Orden:</td>
                    <td style="width:13%;">
                    	<input type="text" name="codigo" id="codigo" value="<?php echo $_POST[codigo] ?>" style="width:70%;" readonly />
						<input type="hidden" name="cont" id="cont" value="<?php echo $_POST[cont] ?>" style="width:70%;" readonly />
						<a href="#" onClick="despliegamodal2('visible','01');" title="Buscar Donacion"><img src="imagenes/find02.png" style="width:20px;"></a>
					</td>
					<td class="saludo1" style="width:8%;">Fecha:</td>
					<td>
						<input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" size="25%" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" readonly>    
						<input type="hidden" name="chacuerdo" value="1">
					</td>
					<td class="saludo1">Valor:</td>
					<td>
						<input type="text" name="valor" id="valor" onKeyPress="javascript:return solonumeros(event)" onKeyUp="puntitos(this,this.value.charAt(this.value.length-1))" size="25%" value='<?php echo $_POST[valor]?>' style="text-align:right;" readonly>
						<input type="hidden" value='<?php echo $_POST[valaux]?>' name="valaux" id="valaux">
					</td>
                </tr>  
            </table>

			<div class="subpantallac" style="height:63%; width:99.6%;">
				<table class="inicio" id="tabla-activo-det" name="tabla-activo-det">
					<tr>
						<td class="titulos" colspan="15">Detalle Costos</td>
					</tr>
					<tr>
						<td class="titulos2" style="width:35%">Descripcion</td>
						<td class="titulos2">Clase</td>
						<td class="titulos2">grupo</td>
						<td class="titulos2">tipo</td>
						<td class="titulos2">disposicion</td>
						<td class="titulos2">Secr. Responsable</td>
						<td class="titulos2" style="width:22%">Supervisor</td>
						<td class="titulos2" style="width:10%">valor</td>
						<td class="titulos2" style="width:5%"><img src="imagenes/del.png" ><input type='hidden' name='elimina' id='elimina'></td>
					</tr>
					<?php
					$iter='zebra1';
					$iter2='zebra2';
					$aux='';
					for ($x=0;$x< count($_POST[dclase]);$x++)
					{
						echo "<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
							onMouseOut=\"this.style.backgroundColor=anterior\" >
							<td style='width:10%'><input name='ddescrip[]' value='".$_POST[ddescrip][$x]."' type='text' class='inpnovisibles' style='width:100%' readonly></td>
							<td style='width:2%'><input name='dclase[]' value='".$_POST[dclase][$x]."' type='text' style='width:100%' class='inpnovisibles' readonly></td>
							<td style='width:2%'><input name='dgrupo[]' value='".$_POST[dgrupo][$x]."' type='text' style='width:100%' class='inpnovisibles' readonly></td>
							<td style='width:2%'><input name='dtipo[]' value='".$_POST[dtipo][$x]."' type='text' style='width:100%' class='inpnovisibles' readonly></td>
							<td style='width:5%'><input name='ddispo[]' value='".$_POST[ddispo][$x]."' type='text' style='width:100%' class='inpnovisibles' readonly></td>
							<td style='width:5%'><input name='dsecrerespon[]' value='".$_POST[dsecrerespon][$x]."' type='text' style='width:100%' class='inpnovisibles' readonly></td>
							<td style='width:5%'><input name='dsupervi[]' value='".$_POST[dsupervi][$x]."' type='text' style='width:100%' class='inpnovisibles' readonly></td>
							<td style='width:5%'><input name='dvalor[]' value='".$_POST[dvalor][$x]."' type='text' style='width:100%' class='inpnovisibles' readonly></td>
							<td style='text-align:center;'><a href='#' onclick=''><img src='imagenes/del.png'></a></td></tr>";
						$aux=$iter;
						$iter=$iter2;
						$iter2=$aux;
						$valact=+$_POST[dvalor][$x];
					}
					?>
				</table>
			</div>
			<?php
		}
			if($_POST[oculto]=="2")
			{	
				$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
				if($_POST[tipomov]==1){
					$fecha=cambiar_fecha($_POST[fecha]);
					$sqlr="INSERT INTO acti_recuperaciones_cab (id, valor, fecha, estado, tipo_mov, acto) VALUES ('$_POST[codigo]','".$valact."','$fecha','S','101','$_POST[docum]')";
					mysql_query($sqlr,$linkbd);
					//Contabilidad en cabecera
					
					$totaldebito = 0;
					$totalcredito = 0;
					for ($x=0;$x<count($_POST[dclase]);$x++)
					{
						$sqlr="INSERT INTO acti_recuperaciones (idcab ,fecha, descripcion, supervisor, secretaria, clase, grupo, tipo, disposicion, valor, estado, tipo_mov,cc) VALUES ('$_POST[codigo]', '$fecha', '".$_POST[ddescrip][$x]."', '".$_POST[dsupervi][$x]."', '".$_POST[dsecrerespon][$x]."', '".$_POST[dclase][$x]."', '".$_POST[dgrupo][$x]."', '".$_POST[dtipo][$x]."', '".$_POST[ddispo][$x]."', '".($_POST[dvalor][$x])."', 'S','101','".$_POST[dcc][$x]."')";
						if (!mysql_query($sqlr,$linkbd)){
							echo "<script>despliegamodalm('visible','2','No se pudo ejecutar la petición');</script>";
						}
						else {
							echo "<script>despliegamodalm('visible','1','Se ha almacenado con Exito');</script>";
						}
						//Afectacion contable
						$tipo = $_POST[dclase][$x].$_POST[dgrupo][$x].$_POST[dtipo][$x];
						$sql = "SELECT cuenta_activo,cuenta_recuperacion FROM acti_activos_det WHERE tipo = '".$tipo."' AND estado='S' AND disposicion_activos='".$_POST[ddispo][$x]."' AND fechainicial = (SELECT MAX(T3.fechainicial) FROM acti_activos_det T3 WHERE  T3.id=acti_activos_det.id AND T3.centro_costos = '".$_POST[dcc][$x]."' AND T3.estado='S' AND T3.fechainicial<='".$fechaf."')";
						//echo $sql;
						$res = mysql_query($sql,$linkbd);
						while($row = mysql_fetch_row($res)){
							//Debito
							$sql_cred = "INSERT INTO comprobante_det(id_comp,cuenta,tercero,centrocosto,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) VALUES ('74 $_POST[codigo]','$row[0]','$_POST[tercero]','".$_POST[dcc][$x]."','COMPROBANTES DE RECUPERACION','".$_POST[dvalor][$x]."','0','1','$vigusu','74','$_POST[codigo]')";
							mysql_query($sql_cred,$linkbd);
							//Credito
							$sql_deb = "INSERT INTO comprobante_det(id_comp,cuenta,tercero,centrocosto,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) VALUES ('74 $_POST[codigo]','$row[1]','$_POST[tercero]','".$_POST[dcc][$x]."','COMPROBANTES DE RECUPERACION','0','".$_POST[dvalor][$x]."','1','$vigusu','74','$_POST[codigo]')";
							mysql_query($sql_deb,$linkbd);
						}
						$totaldebito+=((double)($_POST[dvalor][$x]));
						$totalcredito+=((double)($_POST[dvalor][$x]));
						
					}
				$sql_cab = "INSERT INTO 
					comprobante_cab(numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) VALUES ('$_POST[codigo]','74','$fechaf','COMPROBANTE DE RECUPERACION',0,$totaldebito,$totalcredito,0,'S')";
					mysql_query($sql_cab,$linkbd);	
					
				}
				if($_POST[tipomov]==3){
					$fecha=cambiar_fecha($_POST[fecha]);
					$sqlr="UPDATE acti_recuperaciones_cab SET estado='R' , tipo_mov='301' WHERE acti_donaciones_cab.id='$_POST[codigo]'";
					mysql_query($sqlr,$linkbd);
					$sqlr="UPDATE acti_recuperaciones SET estado='R' , tipo_mov='301' WHERE acti_donaciones.id='$_POST[codigo]'";
					if (!mysql_query($sqlr,$linkbd)){
						echo "<script>despliegamodalm('visible','2','No se pudo ejecutar la petición');</script>";
					}
					else {
						echo "<script>despliegamodalm('visible','1','Se ha almacenado con Exito');</script>";
					}
				}
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