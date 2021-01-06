<!--V 1.0 24/02/2015-->
<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
	$scroll=$_GET['scrtop'];
	$totreg=$_GET['totreg'];
	$idcta=$_GET['idcta'];
	$altura=$_GET['altura'];
	$filtro="'".$_GET['idcta']."'";
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Spid - Activos Fijos</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
		<link href="css/tabs.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/calendario.js"></script>
		<script type='text/javascript' src='JQuery/jquery-2.1.4.min.js'></script>
		<script type="text/javascript" src="css/programas.js"></script>

	<script>
	
		function redirecciona(){
			var acto = document.getElementById("docum").value;
			window.open("acti-recuperacionedita.php?codi="+acto);
		}
		
       	function guardar()
		{
			var validacion03=document.getElementById('fc_1198971546').value;
			if(validacion03.trim()!=''){
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
					if(v=='01'){
						document.getElementById('ventana2').src="activentana-compra-activos.php";
					}
					else if(v=='02')
					{
						document.getElementById('ventana2').src="activentana-construccion.php";
					}
					else if(v=='03')
					{
						document.getElementById('ventana2').src="activentana-montaje.php";
					}
					else if(v=='04')
					{
						document.getElementById('ventana2').src="activentana-donacion.php";
					}
					else if(v=='05')
					{
						document.getElementById('ventana2').src="activentana-donacion.php";
					}
					else if(v=='07')
					{
						document.getElementById('ventana2').src="activentana-otros.php";
					}
					else if(v=='4')
					{
						document.getElementById('ventana2').src="reservar-activo.php";
					}
				}
			}
			else{
				despliegamodalm('visible','2','Seleccione el Origen del Activo');
			}
		}	
		function funcionmensaje(){
			document.location.href = "acti-creacionactivos.php";
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
					//eli=document.getElementById(elimina);
					vvend=document.getElementById('elimina');
					//eli.value=elimina;
					vvend.value=variable;
					document.form2.submit();
					break;
			}
		}
		
		function agregardetalle()
		{
			if(document.form2.origen.value!="" && document.form2.clasificacion.value!="" && document.form2.grupo.value!="" && document.form2.tipo.value!="" && document.form2.fechact.value!="" )
			{ 
				document.form2.agregadet.value=1;
				document.form2.submit();
			}
			else {
				despliegamodalm('visible','2','Falta informacion para poder Agregar');
			}
		}

		function eliminar(variable)
		{
			despliegamodalm('visible','5','Esta Seguro de Eliminar','2',variable);
		}


		function clasifica(formulario)
		{
			//document.form2.action="presu-recursos.php";
			document.form2.submit();
		}

		function buscacta(e){if (document.form2.cuenta.value!=""){document.form2.bc.value='1';document.form2.submit();}}

		function buscacc(e){if (document.form2.cc.value!=""){document.form2.bcc.value='1';document.form2.submit();}}

		function validar2()
		{
			document.form2.oculto.value=2;
			document.form2.action="";
			document.form2.submit();
		}

		function validar(){document.form2.submit();}

		function creaplaca()
		{
			if($('#tabact >tbody >tr').length > 2){
				clasi=document.getElementById("clasificacion").value;	
				grup=document.getElementById("grupo").value;	
				cons=document.getElementById("consecutivo").value;	;
				document.getElementById("placa").value=clasi+''+grup+''+cons;
				//document.form2.submit();
			}
		}

		function valDep()
		{
			if($('#chkdep').is(":checked")){
				$('#agedep').attr('readonly','readonly');
				$('#agedep').val('0');
				$('#valdep').val('1');
			}
			else{
				$('#agedep').removeAttr('readonly');
				$('#valdep').val('0');
			}
		}
	</script>
	<script>
		function adelante(next){
			var maximo=document.getElementById('maximo').value;
			var actual=document.getElementById('codigo').value;
			if(parseFloat(maximo)>parseFloat(actual)){
				document.getElementById('oculto').value='1';
				document.getElementById('codigo').value=next;
				var idcta=document.getElementById('codigo').value;
				vaciar();
				document.form2.action="acti-editardonaciones.php?idcta="+idcta;
				document.form2.submit();
			}
		}
		
			
		function atrasc(prev){
			var minimo=document.getElementById('minimo').value;
			var actual=document.getElementById('codigo').value;
			if(parseFloat(minimo)<parseFloat(actual)){
				document.getElementById('oculto').value='1';
				document.getElementById('codigo').value=prev;
				var idcta=document.getElementById('codigo').value;
				vaciar();
				document.form2.action="acti-editardonaciones.php?idcta="+idcta;
				document.form2.submit();
			}
		}
		function iratras(scrtop, numpag, limreg, clase){
			var idcta=document.getElementById('codigo').value;
			location.href="acti-buscadonaciones.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&clase="+clase;
		}
    </script>
	<script>
		function pdf()
		{
			document.form2.action="pdfactivos.php";
			document.form2.target="_BLANK";
			document.form2.submit();
			document.form2.action="";
			document.form2.target="";
		}
	</script>
	<script>
		function excell()
		{
				document.form2.action="gestionactivosexcel.php";
				document.form2.target="_BLANK";
				document.form2.submit(); 
				document.form2.action="";
				document.form2.target="";
		}
	</script>
	<script>
		function marcar(objeto,posicion)
		{	
			if(objeto.checked){
				vaciar();
				var pagoscheck=document.getElementsByName('pagosselec[]');
				var val=document.getElementsByName('dvalor[]');
				var fec=document.getElementsByName('dfecha[]');
				var des=document.getElementsByName('ddescrip[]');
				var cla=document.getElementsByName('dclasificacion[]');
				var gru=document.getElementsByName('dgrupo[]');
				var tip=document.getElementsByName('dtipo[]');
				var dis=document.getElementsByName('ddispactivos[]');
				var ubi=document.getElementsByName('dubicacion[]');
				var sup=document.getElementsByName('dsupervisor[]');
				document.form2.valor.value=val.item(posicion).value
				document.form2.clasificacion.value=cla.item(posicion).value
				document.form2.grupo.value=gru.item(posicion).value
				document.form2.tipo.value=tip.item(posicion).value
				document.form2.fecha.value=fec.item(posicion).value
				document.form2.ubicacion.value=ubi.item(posicion).value
				document.form2.supervisor.value=sup.item(posicion).value
				document.form2.dispactivos.value=dis.item(posicion).value
				document.form2.descrip.value=des.item(posicion).value
			}
			document.form2.submit();
		}
	
	</script>
	<script>
		function vaciar(){
				document.form2.valor.value=''
				document.form2.fecha.value=''
				document.form2.descrip.value=''
				document.form2.tipo.value=''
				document.form2.grupo.value=''
				document.form2.clasificacion.value=''
				document.form2.dispactivos.value=''
				document.form2.ubicacion.value=''
				document.form2.supervisor.value=''
		}
	</script>
	<?php titlepag();?>
	</head>
	<body>
	<?php
	if($_POST[oculto]==""){
		unset($_POST[dfecha]);
		unset($_POST[dvalor]);
		unset($_POST[ddescrip]);
		unset($_POST[dclasificacion]);
		unset($_POST[dgrupo]);
		unset($_POST[dtipo]);
		unset($_POST[ddispactivos]);
		unset($_POST[dubicacion]);
		unset($_POST[dsupervisor]);		 
	}
	?>	
	<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
	<span id="todastablas2"></span>
        <?php
			$numpag=$_GET[numpag];
			$limreg=$_GET[limreg];
			$scrtop=26*$totreg;
		?>	
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
		$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
		$vigencia=$vigusu;
		$linkbd=conectar_bd();
		?>
		<?php
		$sqlr="SELECT * from  acti_recuperaciones_cab ORDER BY id ASC";
		$res=mysql_query($sqlr,$linkbd);
		$r=mysql_fetch_row($res);
		$_POST[minimo]=$r[0];
				
		$sqlr="SELECT * from  acti_recuperaciones_cab ORDER BY id DESC";
		$res=mysql_query($sqlr,$linkbd);
		$r=mysql_fetch_row($res);
		$_POST[maximo]=$r[0];
		$_POST[codigo]=$r[0];
		$_POST[tipo_mov]=$r[4];
		$_POST[fecha] = $r[2];
		$_POST[docum] = $r[5];
		$_POST[valor] = $r[1];
		$_POST[valaux] = $r[1];
		
		$sqlr = "SELECT motivo FROM actiactorecuperacion WHERE id = ".$_POST[docum];
		$res = mysql_query($sqlr,$linkbd);
		$r=mysql_fetch_row($res);
		$_POST[ndocum] = $r[0];
		
		
		if(($_POST[oculto]!="2")&&($_POST[oculto]!="7")){
			unset($_POST[id]);
			unset($_POST[dfecha]);
			unset($_POST[dvalor]);
			unset($_POST[ddescrip]);
			unset($_POST[dclasificacion]);
			unset($_POST[dgrupo]);
			unset($_POST[dtipo]);
			unset($_POST[ddispactivos]);
			unset($_POST[dubicacion]);
			unset($_POST[dsupervisor]);
			unset($_POST[dcc]);
			$sqlr="select * from acti_recuperaciones where idcab='$_GET[idcta]'";
			//echo $sqlr;
			// and tipo_mov='101'";
			$i=0;
			$res=mysql_query($sqlr,$linkbd);
			while($row=mysql_fetch_assoc($res)){
				$_POST[id][$i]=$row["id"];
				$_POST[dfecha][$i]=$row["fecha"];
				$_POST[dvalor][$i]=$row["valor"];
				$_POST[ddescrip][$i]=$row["descripcion"];
				$_POST[dclasificacion][$i]=$row["clase"];
				$_POST[dgrupo][$i]=$row["grupo"];
				$_POST[dtipo][$i]=$row["tipo"];
				$_POST[ddispactivos][$i]=$row["disposicion"];
				$_POST[dubicacion][$i]=$row["secretaria"];
				$_POST[dsupervisor][$i]=$row["supervisor"];
				$_POST[dcc][$i]=$row["cc"];
				$i++;
			}
		}
		$sqlr="select * from acti_recuperaciones_cab where id='$_GET[idcta]'";
		$res=mysql_query($sqlr,$linkbd);
		$row=mysql_fetch_row($res);
		$_POST[codigo]=$row[0]; 		 
		
		$sqlr="SELECT * from  acti_recuperaciones_cab where id < $_POST[codigo] ORDER BY id DESC";
		$res=mysql_query($sqlr,$linkbd);
		$r=mysql_fetch_row($res);
		$_POST[antes]=$r[0];
		
		$sqlr="SELECT * from  acti_recuperaciones_cab where id > $_POST[codigo] ORDER BY id ASC";
		$res=mysql_query($sqlr,$linkbd);
		$r=mysql_fetch_row($res);
		$_POST[despu]=$r[0];
		
		?>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
  		<form name="form2" method="post" action="">
		<?php //**** busca cuenta
  			if($_POST[bc]=='1')
			{
			  $nresul=buscacuenta($_POST[cuenta]);
			  if($nresul!='')
			   {
			  $_POST[ncuenta]=$nresul;
  	
			  }
			 else
			 {
			  $_POST[ncuenta]="";
			  }
			}
			  //**** busca centro costo
  			if($_POST[bcc]=='1')
			{
			  $nresul=buscacentro($_POST[cc]);
			  if($nresul!='')
			   {
			  $_POST[ncc]=$nresul;
  	
			  }
			 else
			 {
			  $_POST[ncc]="";
			  }
			}
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
						<input type="text" name="docum" id="docum" value="<?php echo $_POST[docum]; ?>" onKeyPress="javascript:return solonumeros(event)" style="width:80%" readonly/>&nbsp;<img class="icobut" src="imagenes/find02.png"  title="Acto de Recuperacion" onClick="redirecciona();"/></td>
					<td style="width:20%"><input type="text" name="ndocum" id="ndocum" value="<?php echo $_POST[ndocum]; ?>" style="width:100%;text-transform:uppercase" readonly/></td>
					<td class="saludo1">Valor:</td>
					<td>
						<input type="text" name="valor" id="valor" onKeyPress="javascript:return solonumeros(event)" onKeyUp="puntitos(this,this.value.charAt(this.value.length-1))" value="<?php echo $_POST[valor]?>" style="text-align:right; width: 100%" readonly>
						<input type="hidden" value='<?php echo $_POST[valaux]?>' name="valaux" id="valaux">
					</td>
                </tr>  
            </table>
            <input type="hidden" name="oculto" id="oculto" value="1"/>
            <input type="hidden" name="valfocus" id="valfocus" value="<?php echo $_POST[valfocus]; ?>"/>
			<input type="hidden" value='<?php echo $_POST[idd]?>' name="idd" id="idd">

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
				</td>
				</tr>
			</table>
			</div>
		</div>
	</div>
	<div class="subpantallac" style="height:23.5%; width:99.6%;">
	<table class="inicio" id="tabact">
		<tr>
			<td class="titulos" colspan="11">Detalles</td>
		</tr>
		<tr>
			<td class="titulos2" style="width:5%">-</td>
			<td class="titulos2" style="width:35%">Descripcion</td>
			<td class="titulos2">Clase</td>
			<td class="titulos2">grupo</td>
			<td class="titulos2">tipo</td>
			<td class="titulos2">disposicion</td>
			<td class="titulos2">Secr. Responsable</td>
			<td class="titulos2" style="width:22%">Supervisor</td>
			<td class="titulos2" >CC</td>
			<td class="titulos2" style="width:10%">valor</td>
			<td class="titulos2" style="width:5%;text-align:center;"><img src="imagenes/del.png" ><input type='hidden' name='elimina' id='elimina'></td>
		</tr>
	<?php	
	//echo "<br>posic:".$_POST[elimina];		 
	if ($_POST[elimina]!='')
	 { 		 
		// echo "<br>posic:".$_POST[elimina];
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
	}
		$iter='zebra1';
		$iter2='zebra2';
		$gtotal=0;
		for ($x=0;$x< count($_POST[dfecha]);$x++)
		{
			$chk='';
			$ch=esta_en_array($_POST[pagosselec], $_POST[id][$x]);
			if($ch==1 || $_POST[actcheck]==1)
			{
				$chk="checked";
			}		
			echo "<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
				onMouseOut=\"this.style.backgroundColor=anterior\" >
				<td><input type='radio' name='pagosselec[]' value='".$_POST[id][$x]."' $chk onClick='marcar(this,$x);' class='defaultcheckbox'>&nbsp;&nbsp;$dsb2</td>
				<td style='width:2%'><input name='ddescrip[]' value='".$_POST[ddescrip][$x]."' type='text' style='width:100%' class='inpnovisibles' readonly></td>
				<td style='width:2%'><input name='dclasificacion[]' value='".$_POST[dclasificacion][$x]."' type='text' style='width:100%' class='inpnovisibles' readonly></td>
				<td style='width:2%'><input name='dgrupo[]' value='".$_POST[dgrupo][$x]."' type='text' style='width:100%' class='inpnovisibles' readonly></td>
				<td style='width:5%'><input name='dtipo[]' value='".$_POST[dtipo][$x]."' type='text' style='width:100%' class='inpnovisibles' readonly></td>
				<td style='width:5%'><input name='ddispactivos[]' value='".$_POST[ddispactivos][$x]."' type='text' style='width:100%' class='inpnovisibles' readonly></td>
				<td style='width:5%'><input name='dubicacion[]' value='".$_POST[dubicacion][$x]."' type='text' style='width:100%' class='inpnovisibles' readonly></td>
				<td style='width:10%'><input name='dsupervisor[]' value='".$_POST[dsupervisor][$x]."' type='text' style='width:100%' class='inpnovisibles' readonly>	<input name='dfecha[]' value='".$_POST[dfecha][$x]."' type='hidden' class='inpnovisibles' style='width:100%' readonly></td>
				<td style='width:3%'><input name='dcc[]' value='".$_POST[dcc][$x]."' type='text' style='width:100%' class='inpnovisibles' readonly></td>
				<td style='width:2%'><input name='dvalor[]' value='".$_POST[dvalor][$x]."' type='text' style='width:100%' class='inpnovisibles' readonly></td>
				<td style='text-align:center;'><a href='#' onclick='eliminar($x)'><img src='imagenes/del.png'></a></td></tr>";
				$aux=$iter;
				$iter=$iter2;
				$iter2=$aux;
				$valact=str_replace(',','.',str_replace('.','',$_POST[dvalor][$x]));
				$gtotal+=$valact;
		}	 
			echo "<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
				onMouseOut=\"this.style.backgroundColor=anterior\" >
				<td colspan='9'>TOTAL ACTIVOS ($)</td>
				<td style='width:2%'><input name='totact' value='".number_format($gtotal,2,',','.')."' type='text' style='width:100%; text-align:right;' class='inpnovisibles' readonly></td>
			</tr>";
		 ?>
	</table>
	</div>
	</form>
	<?php 
	//********** GUARDAR EL COMPROBANTE ***********
	if($_POST[oculto]=='2'){
		$linkbd=conectar_bd();
		$_POST[valor]=str_replace(".","",$_POST[valor]);
		ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
		$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
		ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechact],$fecha);
		$fechafact=$fecha[3]."-".$fecha[2]."-".$fecha[1];
		$nmesesdep=$_POST[agedep]*12;
		$vmendep=$_POST[valor]/$nmesesdep;
		$sqlr="UPDATE acticrearact_det SET nummesesdep='".$_POST[agedep]."', bloque='".$_POST[valdep]."' WHERE placa='$_POST[placa]'";
		if(!mysql_query($sqlr,$linkbd))
		 {
		  echo "<table class='inicio'><tr><td class='saludo1'><center>No Se ha Almacenado el Nuevo Activo, <img src='imagenes\alert.png'> Error:".mysql_error()."</center></td></tr></table>";
		 }
		 else
		 {
		  echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha Actualizado con Exito el Nuevo Activo <img src='imagenes\confirm.png'></center></td></tr></table>";		
		 }
	   }
	?>	
</td></tr>     
</table>
</body>
</html>