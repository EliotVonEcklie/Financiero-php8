<?php //V 1001 17/12/2016 ?>
<?php
	require "comun.inc";
	require "funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
	$scroll=$_GET['scrtop'];
	$totreg=$_GET['totreg'];
	$idcta=$_GET['idcta'];
	$altura=$_GET['altura'];
	$filtro="'".$_GET['clase']."'";
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
				/*
				var validacion01=document.getElementById('nombre').value;
				if(validacion01.trim()!=''){*/
					despliegamodalm('visible','4','Esta Seguro de Modificar','1');
					/*
				}else {
					despliegamodalm('visible','2','Falta informacion para modificar la clase');
				}*/
	 		}
			function despliegamodalm(_valor,_tip,mensa,pregunta, variable)
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
						case "5":
							document.getElementById('ventanam').src="ventana-elimina1.php?titulos="+mensa+"&idresp="+pregunta+"&variable="+variable;break;	
					}
				}
			}
			function funcionmensaje(){}
			function respuestaconsulta(pregunta, variable)
			{
				switch(pregunta)
				{
					case "1":
						document.getElementById('oculto').value='2';
						document.form2.submit();
						break;
					case "2":
						document.getElementById('oculto').value='7';
						document.form2.eliminadet.value=variable;
						document.form2.submit();
						break;
				}
			}
        </script>
		<script>

			function adelante(idproceso,scrtop,totreg,altura,numpag,limreg,clase, maximo){
					document.getElementById('oculto').value='1';
					clase=parseInt(clase)+1;
					if (parseInt(clase)<=parseInt(maximo)) {
						$("#tabla-activo-det tr").remove();
						document.form2.action="acti-editadepreciacionactivos.php?idproceso="+idproceso+"&scrtop="+scrtop+"&totreg="+totreg+"&altura="+altura+"&numpag="+numpag+"&limreg="+limreg+"&clase="+clase;
						document.form2.submit();
					}
			}
		
			function atrasc(idproceso,scrtop,totreg,altura,numpag,limreg,clase){
				document.getElementById('oculto').value='1';
				clase=parseInt(clase)-1;
				if (clase!='0') {
					$("#tabla-activo-det tr").remove();
				document.form2.action="acti-editadepreciacionactivos.php?idproceso="+idproceso+"&scrtop="+scrtop+"&totreg="+totreg+"&altura="+altura+"&numpag="+numpag+"&limreg="+limreg+"&clase="+clase;
				document.form2.submit();
			}
			}

			function iratras(scrtop, numpag, limreg, clase){
				var idcta=document.getElementById('codigo').value;
				location.href="acti-buscadepreciacionactivos.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&clase="+clase;
			}

			function validar2(formulario)
			{
				if(document.form2.fecha1.value!=''){
					if ((document.form2.cuentadebito.value.substr(0,1)==3)||(document.form2.cuentadebito.value.substr(0,1)==5)) {
						document.form2.action="acti-editadepreciacionactivos.php?idproceso=<?php echo $_GET[idproceso] ?>&scrtop=<?php echo $_GET[scrtop] ?>&totreg=<?php echo $_GET[totreg] ?>&altura=<?php echo $_GET[altura] ?>&numpag=<?php echo $_GET[numpag] ?>&limreg=<?php echo $_GET[limreg] ?>&clase=<?php echo $_GET[clase] ?>";
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
						document.form2.action="acti-editadepreciacionactivos.php?idproceso=<?php echo $_GET[idproceso] ?>&scrtop=<?php echo $_GET[scrtop] ?>&totreg=<?php echo $_GET[totreg] ?>&altura=<?php echo $_GET[altura] ?>&numpag=<?php echo $_GET[numpag] ?>&limreg=<?php echo $_GET[limreg] ?>&clase=<?php echo $_GET[clase] ?>";
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

	</head>
	<body>

		<input type="hidden" name="desactivar" id="desactivar">
		<input type="hidden" name="desactivarestado" id="desactivarestado">
			<?php
			if($_POST[oculto]=="1"){
				unset($_POST[dfecha]);
				unset($_POST[dcc]);
				unset($_POST[dactivos]);
				unset($_POST[ddebito]);
				unset($_POST[dcredito]);		 
				unset($_POST[dndebito]);
				unset($_POST[dncredito]);		 
			}
			?> 
		<input type="hidden" name="oculto2" id="oculto2" value="<?php echo $_POST[oculto2] ?>">
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <?php
			$numpag=$_GET[numpag];
			$limreg=$_GET[limreg];
			$scrtop=26*$totreg;
		?>
		<table>
            <tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>
            <tr><?php menu_desplegable("cont");?></tr>
			<tr>
  				<td colspan="3" class="cinta">
  					<a onClick="location.href='acti-creaciondepreciacionactivos.php'" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a>
  					<a onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a>
  					<a onClick="location.href='acti-buscadepreciacionactivos.php'" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
					<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
  					<a onClick="mypop=window.open('cont-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
  					<a onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>)" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
				</td>
        	</tr>
    	</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
		<form name="form2" method="post" action="">
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



			if ($_GET[idtipocom]!=""){echo "<script>document.getElementById('codrec').value=$_GET[idtipocom];</script>";}
			$sqlr="SELECT * from  acti_depreciacionactivos_cab ORDER BY id DESC";
			$res=mysql_query($sqlr,$linkbd);
			$r=mysql_fetch_row($res);

			$_POST[maximo]=$r[0];
			if(!$_POST[oculto])	{
				if ($_POST[codrec]!="" || $_GET[idtipocom]!=""){
					if($_POST[codrec]!=""){
						$sqlr="SELECT * from acti_depreciacionactivos_det where id_cab=$_GET[clase] AND id='$_POST[codrec]'";
					}
					else{
						$sqlr="SELECT * from acti_depreciacionactivos_det where id_cab=$_GET[clase] AND id ='$_GET[idtipocom]'";
					}
				}
				else{
					if ($_GET[idproceso]=='') {
						$sqlr="SELECT * from  acti_depreciacionactivos_det where id_cab=$_GET[clase] ORDER BY id";		
					}else{
						$sqlr="SELECT * from  acti_depreciacionactivos_det where id_cab=$_GET[clase] AND  id='$_GET[idproceso]' ORDER BY id DESC";
					}
				}
				//echo $sqlr;
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
			   	//$_POST[idcomp]=$row[0];
			}

			if(($_POST[oculto]!="2")&&($_POST[oculto]!="7")){
				$sqlr="SELECT * from acti_depreciacionactivos_det where id_cab=$_GET[clase]";
				//echo "<br>".$sqlr;
				$res=mysql_query($sqlr,$linkbd);
				$i=0;
				while($row=mysql_fetch_row($res)){
													
					$_POST[idcomp][$i]=$row[0];
					$_POST[codigo][$i]=$row[0];

					$_POST[dfecha][$i]=cambiar_fecha($row[2]);
					$_POST[ddebito][$i]=$row[3];
					$_POST[dcredito][$i]=$row[4];

					$_POST[dcc][$i]=$row[6];
					$_POST[dtipo][$i]=$row[8];
					$_POST[dactivos][$i]=$row[5];
					

					$anio=date('Y',strtotime($_POST[dfecha][$i]));
					if($anio>2016){
						$sqlr1="SELECT nombre from cuentasnicsp where cuenta='$row[3]'";
						$res1=mysql_query($sqlr1,$linkbd);
						$row1=mysql_fetch_row($res1);
						$_POST[dndebito][$i]=$row1[0];
						$sqlr2="SELECT nombre from cuentasnicsp where cuenta='$row[4]'";
						$res2=mysql_query($sqlr2,$linkbd);
						$row2=mysql_fetch_row($res2);
						$_POST[dncredito][$i]=$row2[0];
					}
					else{
						$sqlr1="SELECT nombre from cuentas where cuenta='$row[3]'";
						$res1=mysql_query($sqlr1,$linkbd);
						$row1=mysql_fetch_row($res1);
						$_POST[dndebito][$i]=$row1[0];
						$sqlr2="SELECT nombre from cuentas where cuenta='$row[4]'";
						$res2=mysql_query($sqlr2,$linkbd);
						$row2=mysql_fetch_row($res2);
						$_POST[dncredito][$i]=$row2[0];
					}

					$i++;
				}

				$sqlr="SELECT nombre,estado FROM acti_depreciacionactivos_cab WHERE id=$_GET[clase]";
              	$res = mysql_query($sqlr,$linkbd);
              	$row=mysql_fetch_row($res);
              	$_POST[nombreactivo]=$row[0];
              	$_POST[estado]=$row[1];

			}
			//NEXT
			$sqln="SELECT *from acti_depreciacionactivos_det where id_cab=$_GET[clase] AND id > '$_POST[idcomp]' ORDER BY id ASC LIMIT 1";
			$resn=mysql_query($sqln,$linkbd);
			$row=mysql_fetch_row($resn);
			$next=$row[0];
			//PREV
			$sqlp="SELECT *from acti_depreciacionactivos_det where id_cab=$_GET[clase] AND id < '$_POST[idcomp]' ORDER BY id DESC LIMIT 1";
			$resp=mysql_query($sqlp,$linkbd);
			$row=mysql_fetch_row($resp);
			$prev=$row[0];
			//PLACA
			$placa = $_POST[dtipo][0];
			$_POST[clasificacion] = $placa[0];
			$_POST[grupo] = $placa[1].$placa[2];
			$_POST[tipo] = $placa[3].$placa[4].$placa[5];
			?>
    		
    		<table class="inicio" align="center" style='margin-top: 5px;'>
                <tr>
                    <td class="titulos" colspan="12">.: Editar el Activo</td>
                </tr>
                <tr>
                	<td class="saludo1"  style="width:3%;">Codigo:</td>
                  	<td class="saludo1"  style="width:4%;"> 
                  		<a onclick='atrasc("<?php echo $_GET[idproceso] ?>", "<?php echo $_GET[scrtop] ?>", "<?php echo $_GET[totreg] ?>", "<?php echo $_GET[altura] ?>", "<?php echo $_GET[numpag] ?>", "<?php echo $_GET[limreg] ?>","<?php echo $_GET[clase] ?>")' style="cursor:pointer;">
                  			<img src="imagenes/back.png" alt="siguiente" align="absmiddle">
              			</a>
                  		
                  		<input type="text" id="codigo" name="codigo" value="<?php echo $_GET[clase]?>" style='width:50%' readonly>
              			
              			<a onclick='adelante("<?php echo $_GET[idproceso] ?>", "<?php echo $_GET[scrtop] ?>", "<?php echo $_GET[totreg] ?>", "<?php echo $_GET[altura] ?>", "<?php echo $_GET[numpag] ?>", "<?php echo $_GET[limreg] ?>","<?php echo $_GET[clase] ?>", "<?php echo $_POST[maximo] ?>")' style="cursor:pointer;"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a>
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
								$sqlr="SELECT * from actipo where niveluno='$_POST[grupo]' and niveldos='$_POST[clasificacion]' and estado='S' and deprecia<>'0'";
								$resp = mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($resp)) 
								{
									echo "<option value=$row[0] ";
									$i=$row[0];
									if($i==$_POST[tipo])
									{
										echo "SELECTED";
										//$_POST[nombre] = $row[1];
									}
									echo ">".$row[0].' - '.strtoupper($row[1])."</option>";	  

								}
							?>
						</select>
						<input type="hidden" id="nombreactivo" name="nombreactivo" value="<?php echo $_POST[nombreactivo]?>">
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
            <input type="hidden" name="valfec" id="valfec" value="<?php echo $_POST['valfec']; ?>"/>


    		<table class="inicio" style='margin-top: 5px;'>
				<tr>
					<td colspan="11" class="titulos">Crear Detalle Clasificacion</td>
				</tr>	
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
			<td class="saludo1" style='width:10%%'>Cuenta Debito Depreciacion:</td>
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
			<td class="saludo1" style='width:10%'>Cuenta Credito Depreciacion:</td>
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
			$('#tipo').val('');
			$('#cc').val('01');
			$('#fecha1').val('');
		</script>";
    }
	?>
			<div class="subpantalla" style="height:35%; width:99.6%; overflow-x:scroll;">

				<table class="inicio" id="tabla-activo-det">
                    <tr><td class="titulos" colspan="13">Activos</td></tr>
                    <tr>
						
                        <td class="titulos2" style="width: 10px;">Fecha Ini.</td>
						<td class="titulos2">Cc</td>
                        <td class="titulos2" style='width: 10px;'>Tipo</td>
                        <td class="titulos2" style="width: 10px;">Disp.</td>
                        <td class="titulos2" style="width: 10px;">Cuent Debito</td>
                        <td class="titulos2" style="width: 10px;">Nombre Cuenta</td>
                        <td class="titulos2" style="width: 10px;">Cuenta Credito</td>
                        <td class="titulos2" style="width: 10px;">Nombre Cuenta</td>

                        <td class="titulos2" style="width: 10px;"><img src="imagenes/del.png"></td>
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
					$sqlr="UPDATE acti_depreciacionactivos_cab SET nombre='$_POST[nombreactivo]', estado='$_POST[estado]' WHERE id='$_POST[codigo]'";
					//echo $sqlr;
					if (!mysql_query($sqlr,$linkbd)){
						echo "<script>despliegamodalm('visible','2','No se pudo ejecutar la petici�n');</script>";
					}
					else {
						$sqld="DELETE FROM acti_depreciacionactivos_det WHERE id_cab='$_POST[codigo]'";
						mysql_query($sqld,$linkbd);
						for ($x=0;$x<count($_POST[dcc]);$x++){
							$nfecha=cambiar_fecha($_POST[dfecha][$x]);
							$sqlr11="INSERT INTO acti_depreciacionactivos_det (id,id_cab,fechainicial,cuenta_debito,cuenta_credito,disposicion_activos,centro_costos,estado,tipo) VALUES (".($x+1).",'".$_POST[codigo]."','".$nfecha."','".$_POST[ddebito][$x]."','".$_POST[dcredito][$x]."','0','".$_POST[dcc][$x]."','S','".$_POST[dtipo][$x]."')";
							//echo $sqlr11.'<br>';
							if (!mysql_query($sqlr11,$linkbd)){
								echo "<script>despliegamodalm('visible','2','No se pudo ejecutar la petici�n');</script>";
							}else{
								echo "<script>despliegamodalm('visible','1','Se ha almacenado con Exito');</script>";
							}
						}
					}
				}
			?>

            <input type="hidden" name="oculto" id="oculto" value="<?php echo $_POST[oculto]; ?>"/>  
            
  			
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