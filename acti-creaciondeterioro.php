<?php //V 1001 17/12/2016 ?>
<?php
	require "comun.inc";
	require "funciones.inc";
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
		<title>:: Contabilidad</title>
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
			function despliegamodalm(_valor,_tip,mensa,pregunta, variable)
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
				document.location.href = "acti-creaciondeterioro.php";
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
						document.form2.eliminadet.value=variable;
						document.form2.submit();
						break;
				}
			}
			function validar2(formulario)
			{
				if(document.form2.fecha1.value!=''){
					if ((document.form2.cuentadebito.value.substr(0,1)==3)||(document.form2.cuentadebito.value.substr(0,1)==5)) {
						document.form2.action="acti-creaciondeterioro.php";
						document.form2.ncuen.value=1;
						document.form2.submit();
					}else{
						document.form2.cuentadebito.value='';
						document.form2.ncuentadebito.value='';
						despliegamodalm('visible','2','Cuenta no Soportada.');
					}
				}else{
					document.form2.cuentadebito.value='';
					document.form2.ncuentadebito.value='';
					despliegamodalm('visible','2','Ingrese la Fecha Inicial');
				}
				
			}
			function validar3(formulario)
			{
				if(document.form2.fecha1.value!=''){
					if (document.form2.cuentacredito.value.substr(0,1)==1) {
						document.form2.action="acti-creaciondeterioro.php";
						document.form2.ncuen1.value=1;
						document.form2.submit();
					}else{
						document.form2.cuentacredito.value='';
						document.form2.ncuentacredito.value='';
						despliegamodalm('visible','2','Cuenta no Soportada.');
					}
				}else{
					document.form2.cuentacredito.value='';
					document.form2.ncuentacredito.value='';
					despliegamodalm('visible','2','Ingrese la Fecha Inicial');
				}
				
			}
			function despliegamodal2(_valor,v)
			{
				if(document.form2.fecha1.value!='')
				{
					document.getElementById("bgventanamodal2").style.visibility=_valor;
					if(_valor=="hidden"){
						document.getElementById('ventana2').src="";
						document.form2.submit();
					}
					else {
						if(v==1){
							document.getElementById('ventana2').src="cuentas-ventanad1.php?fecha="+document.form2.fecha1.value;
						}
						else if(v==2)
						{
							document.getElementById('ventana2').src="cuentas-ventanad2.php?fecha="+document.form2.fecha1.value;
						}
					}	
				}
				else 
				{
					despliegamodalm('visible','2','Ingrese la Fecha Inicial');
				}
				
			}
			
			function valcodigo(){
				document.form2.oculto.value="8";document.form2.submit();
			}
        </script>

        <script type="text/javascript">
			function agregarDetalle()
			{
				if(document.form2.cuentadebito.value!="" && document.form2.cuentacredito.value!="" && document.form2.fecha1.value!="" )
				{ 
					document.form2.agregadet.value=1;
					document.form2.submit();
 				}
 				else {
           			despliegamodalm('visible','2','Falta informacion para poder Agregar');
				}
			}

			function eliminarDetalle(variable){
				despliegamodalm('visible','5','Esta Seguro de Eliminar','2',variable);
			}
			
			function validarFecha(){
				var fecha =	$("#fecha1").val();
				var valfec = $("#valfec").val();
				if(valfec!=""){
					var a1 = fecha.split('/');
					var a2 = valfec.split('/');
					if(a1[2]!=a2[2]){
						if(((a1[2]>2017)&&(a2[2]<2018))||((a1[2]<2018)&&(a2[2]>2017))){
							$("#cuentadebito").val('');
							$("#cuentacredito").val('');
							$("#dispactivos").val('1');
							$("#cc").val('1');
						}
					}
				}
				$("#valfec").val(fecha);
			}

        </script>
		<script type="text/javascript">
			function iratras(){
				location.href="acti-concecontables.php";
			}
		</script>

	</head>
	<body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
		<table>
    		<tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
    		<tr><?php menu_desplegable("cont");?></tr>
			<tr>
  				<td colspan="3" class="cinta">
	  				<a onClick="location.href='acti-creaciondeterioro.php'" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
	  				<a onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a>
	  				<a onClick="location.href='acti-buscadeterioro.php'" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
	  				<a onClick="mypop=window.open('cont-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
  					<a onclick="iratras()" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
  				</td>
           	</tr>
		</table>
		<?php
			$_POST[bandera_debito] = true;
			$_POST[bandera_credito] = true;
			if($_POST[ncuen]==1)
			{
				if(!empty($_POST[cuentadebito]))
				{
					$sqlr="SELECT distinct nombre from cuentasnicsp where  cuenta like'%".$_POST[cuentadebito]."%' order by cuenta";
					$res=mysql_query($sqlr,$linkbd);
					$row = mysql_fetch_row($res);
					$_POST[ncuentadebito]=$row[0];
					if ($_POST[ncuentadebito]=='') $_POST[bandera_debito] = false;
				}
				else
				{
					$_POST[ncuentadebito]="";
				}
			}
			if($_POST[ncuen1]==1)
			{
				if(!empty($_POST[cuentacredito]))
				{
					$sqlr="SELECT distinct nombre from cuentasnicsp where  cuenta like'%".$_POST[cuentacredito]."%' order by cuenta";
					$res=mysql_query($sqlr,$linkbd);
					$row = mysql_fetch_row($res);
					$_POST[ncuentacredito]=$row[0];
					if ($_POST[ncuentacredito]=='') $_POST[bandera_credito] = false;
				}
				else
				{
					$_POST[ncuentacredito]="";
				}
			}
		?>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
  		<form name="form2" method="post" action="acti-creaciondeterioro.php">
            <table class="inicio" align="center" style='margin-top: 5px;'>
                <tr>
                    <td class="titulos" colspan="10">.: Agregar Activo</td>
                    <td class="cerrar" style="width:4%;" ><a onClick="location.href='acti-principal.php'">&nbsp;Cerrar</a></td>
                </tr>
                <tr>
                    <td class="saludo1" style="width:3%;">.: Codigo:</td>
                    <td style="width:2%;">
                    <?php 
                    	$sqlr="SELECT * FROM acti_deterioro_cab";
						$res=mysql_query($sqlr,$linkbd);
						$numId = mysql_num_rows($res);
						$numId++;
                    ?>
                    <input type="text" name="codigo" id="codigo" value="<?php echo $numId ?>" style="width:100%;" readonly /></td>
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
										$_POST[nombre] = $row[1];
									}
									echo ">".$row[0].' - '.strtoupper($row[1])."</option>";	  

								}
							?>
						</select>
						<input type="hidden" name="nombre" id="nombre" value="<?php echo $_POST[nombre]?>" onKeyUp="return tabular(event,this)"/>
             		</td>
             		<td class="saludo1" style="width:3%;">.: Activo:</td>
                    <td style="width:2%">
                        <select name="estado" id="estado" style="width:100%;">
                            <option value="S" <?php if ($_POST[estado]=="S"){echo "selected";}?>>SI</option>
                            <option value="N" <?php if ($_POST[estado]=="N"){echo "selected";}?>>NO</option>
                        </select>   
                 	</td>
    
                </tr>  
            </table>
            <input type="hidden" name="oculto" id="oculto" value="1"/>
            <input type="hidden" name="valfocus" id="valfocus" value="1"/> 
            <input type="hidden" name="valfec" id="valfec" value="<?php echo $_POST['valfec']; ?>"/>

	<table class="inicio" style='margin-top: 5px;'>
		<tr><td colspan="10" class="titulos2">Crear Detalle Clasificacion</td></tr>	
		<tr>    
			<td class="saludo1" style="width:10%">Fecha Inicial:</td>
			<td style="width:10%;">
				<input name="fecha1" id="fecha1" type="text" id="fecha1" title="DD/MM/YYYY" style="width:75%;" value="<?php echo $_POST[fecha1]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)" onblur="validarFecha()"  maxlength="10" tabindex="2"/>&nbsp;<a href="#" onClick="displayCalendarFor('fecha1');" tabindex="3" title="Calendario"><img src="imagenes/calendario04.png" align="absmiddle" style="width:20px;"></a>
			</td>
			<td></td>
			<td class="saludo1"style="width:5%">CC:</td>
			<td colspan="2">
				<select name="cc" id="cc" onKeyUp="return tabular(event,this)" onChange="validar()" style="width:100%">
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
		</tr>
		<tr>
        	<td class="saludo1" style='width:10%%'>Cuenta Debito Deterioro:</td>
           	<td style='width:10%'>
				<input name="cuentadebito" id="cuentadebito" type="text"  value="<?php echo $_POST[cuentadebito]?>" onKeyUp="return tabular(event,this) " style="width:75%;" onBlur="validar2()">
				<input name="cuentadebito_" type="hidden" value="<?php echo $_POST[cuentadebito_]?>">&nbsp;<img src="imagenes/find02.png" style="width:20px;" onClick="despliegamodal2('visible',2);" title="Buscar cuenta" class="icobut" />
				<input type="hidden" name="ncuen" value="<?php echo $_POST[ncuen]; ?>" />
          	</td>
            <td style='width:25%'>
            	<?php
            		$width = 100;
            		$cadena = '';
            		if(!$_POST[bandera_debito]){
            			$width = 90;
            			$cadena = '<img src="imagenes/crear_cuenta.png" style="width:20px;" onClick="mypop=window.open(\'cont-cuentasaddnicsp.php\',\'\',\'\');mypop.focus();" title="Crear cuenta" class="icobut" />';
            		} 
            	?>
            	<input name="ncuentadebito" type="text" id="ncuentadebito" value="<?php echo $_POST[ncuentadebito]?>" style='width:<?php echo $width;?>%' readonly>
            	<?php echo $cadena;?>
        	</td>
        	<td class="saludo1" style='width:10%'>Cuenta Credito Deterioro:</td>
        	<td style='width:10%'>
				<input name="cuentacredito" id="cuentacredito" type="text"  value="<?php echo $_POST[cuentacredito]?>" onKeyUp="return tabular(event,this) " style="width:75%;" onBlur="validar3()">
				<input name="cuentacredito_" type="hidden" value="<?php echo $_POST[cuentacredito_]?>">&nbsp;<img src="imagenes/find02.png" style="width:20px;" onClick="despliegamodal2('visible',1);" title="Buscar cuenta" class="icobut" />
				<input type="hidden" name="ncuen1" value="<?php echo $_POST[ncuen1]; ?>"
      		</td>
          	<td style='width:25%'>
          		<?php
            		$width = 100;
            		$cadena = '';
            		if(!$_POST[bandera_credito]){
            			$width = 90;
            			$cadena = '<img src="imagenes/crear_cuenta.png" style="width:20px;" onClick="mypop=window.open(\'cont-cuentasaddnicsp.php\',\'\',\'\');mypop.focus();" title="Crear cuenta" class="icobut" />';
            		} 
            	?>
          		<input id="ncuentacredito" name="ncuentacredito" type="text" value="<?php echo $_POST[ncuentacredito]?>" style='width:<?php echo $width;?>%' readonly>
          		<?php echo $cadena;?>
      		</td>
      		<td>
	 			<input type="button" name="agrega" id="agrega" value="Agregar" onclick="agregarDetalle()">
	 			<input type="hidden" value="0" id="agregadet" name="agregadet">
	 			<input type="hidden" id="eliminadet" name="eliminadet">
			</td>
		</tr>
		
        
	</table>

		<?php
		$placa = $_POST[clasificacion].$_POST[grupo].$_POST[tipo];
	if ($_POST[eliminadet]!='')
    { 
        $posi=$_POST[eliminadet];
        unset($_POST[dfecha][$posi]);
        unset($_POST[dcc][$posi]);
        unset($_POST[dtipo][$posi]);
        unset($_POST[ddebito][$posi]);
        unset($_POST[dndebito][$posi]);		 
        unset($_POST[dcredito][$posi]);
        unset($_POST[dncredito][$posi]);		 
        $_POST[dfecha]= array_values($_POST[dfecha]); 
        $_POST[dcc]= array_values($_POST[dcc]); 
        $_POST[dtipo]= array_values($_POST[dtipo]); 		 
        $_POST[ddebito]= array_values($_POST[ddebito]);
        $_POST[dndebito]= array_values($_POST[dndebito]); 		 		 
        $_POST[dcredito]= array_values($_POST[dcredito]); 		 		 
        $_POST[dncredito]= array_values($_POST[dncredito]); 		 		 
    }	 
	if ($_POST[agregadet]=='1')
    {
		$_POST[dfecha][]=$_POST[fecha1];
        $_POST[dcc][]=$_POST[cc];
        $_POST[dtipo][]=$placa;
        $_POST[ddebito][]=$_POST[cuentadebito];
        $_POST[dndebito][]=$_POST[ncuentadebito];
        $_POST[dcredito][]=$_POST[cuentacredito];
        $_POST[dncredito][]=$_POST[ncuentacredito];
        echo"<script>
			$('#cuentadebito').val('');
			$('#cuentacredito').val('');
			$('#ncuentadebito').val('');
			$('#ncuentacredito').val('');
			$('#cc').val('01');
			$('#fecha1').val('');
		</script>";
    }
	?>

	<div class="subpantallac" style="height:49.5%; width:99.6%;">
		<table class="inicio" id="tabla-activo-det" name="tabla-activo-det">
			<tr>
				<td class="titulos" colspan="15">Detalle Activos</td>
			</tr>
			<tr>
				<td class="titulos2">Fecha Ini.</td>
				<td class="titulos2">Cc</td>
				<td class="titulos2">tipo</td>
				<td class="titulos2">Disp. Activos</td>
				<td class="titulos2">Cuenta Debito:</td>
				<td class="titulos2">Nombre Cuenta</td>
				<td class="titulos2">Cuenta Credito:</td>
				<td class="titulos2">Nombre Cuenta</td>

				<td class="titulos2">
					<img src="imagenes/del.png" ><input type='hidden' name='elimina' id='elimina'>
				</td>
			</tr>
            <?php
            for ($x=0;$x<count($_POST[dcc]);$x++)
            {		 
    		 	if ($x%2==0) {
    		 		$style = "zebra1";
    		 	}else{
    		 		$style = "zebra2";
    		 	}
                echo"<input type='hidden' name='dfecha[]' value='".$_POST[dfecha][$x]."'/>
                <input type='hidden' name='dcc[]' value='".$_POST[dcc][$x]."'/>
                <input type='hidden' name='dtipo[]' value='".$_POST[dtipo][$x]."'/>
                <input type='hidden' name='ddebito[]' value='".$_POST[ddebito][$x]."'/>
                <input type='hidden' name='dndebito[]' value='".$_POST[dndebito][$x]."'>
                <input type='hidden' name='dcredito[]' value='".$_POST[dcredito][$x]."'/>
                <input type='hidden' name='dncredito[]' value='".$_POST[dncredito][$x]."'>
                <tr>
					<td class='$style'>".$_POST[dfecha][$x]."</td>
                    <td class='$style'>".$_POST[dcc][$x]."</td>
                    <td class='$style'>".$_POST[dtipo][$x]."</td>
                    <td class='$style'>0</td>
                    <td class='$style'>".$_POST[ddebito][$x]."</td>	 
                    <td class='$style'>".$_POST[dndebito][$x]."</td>		 
                    <td class='$style'>".$_POST[dcredito][$x]."</td>	 
                    <td class='$style'>".$_POST[dncredito][$x]."</td>		 
                    <td class='$style'><a href='#' onclick='eliminarDetalle($x)'><img src='imagenes/del.png'></a></td>
				</tr>";
            }		 
            ?>
		</table>
	</div>
  			<?php
				if($_POST[oculto]=="2")
				{	
					$sqlr="INSERT INTO acti_deterioro_cab (id,nombre,estado) VALUES ('$_POST[codigo]','$_POST[nombre]','$_POST[estado]')";
//					echo $sqlr;
					if (!mysql_query($sqlr,$linkbd)){
						echo "<script>despliegamodalm('visible','2','No se pudo ejecutar la petición');</script>";
					}
					else {
						for ($x=0;$x<count($_POST[dcc]);$x++){
							$nfecha=cambiar_fecha($_POST[dfecha][$x]);
							
							$sqlr11="INSERT INTO acti_deterioro_det (id,id_cab,fechainicial,cuenta_debito,cuenta_credito,disposicion_activos,centro_costos,estado,tipo) VALUES (".($x+1).",'".$_POST[codigo]."','".$nfecha."','".$_POST[ddebito][$x]."','".$_POST[dcredito][$x]."','0','".$_POST[dcc][$x]."','S','".$_POST[dtipo][$x]."');";
							//echo $sqlr11.'<br>';
							if (!mysql_query($sqlr11,$linkbd)){
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
       		<script type="text/javascript">
       			function validar_cuentas(){
					if (document.form2.cuentadebito.value!='') {
						if ((document.form2.cuentadebito.value.substr(0,1)==3)||(document.form2.cuentadebito.value.substr(0,1)==5)) {}else{
							document.form2.cuentadebito.value='';
							document.form2.ncuentadebito.value='';
							despliegamodalm('visible','2','Cuenta no Soportada.');
						}
					}
					if (document.form2.cuentacredito.value!='') {
						if (document.form2.cuentacredito.value.substr(0,1)==1) {}else{
							document.form2.cuentacredito.value='';
							document.form2.ncuentacredito.value='';
							despliegamodalm('visible','2','Cuenta no Soportada.');
						}
					}
				} 
       			validar_cuentas();
       		</script>
			<div id="bgventanamodal2">
                <div id="ventanamodal2">
                    <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                    </IFRAME>
                </div>
       	 	</div>
		</form>
	</body>
</html>