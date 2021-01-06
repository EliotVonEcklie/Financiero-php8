<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
//**niveles menu: Administracion (0) - Consultas (1) - Herramientas (2) - Reportes (3)
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
<title>:: SPID - Almacen</title>
<script>
	//**************FUNCIONES*********
	function despliegamodalm(_valor,_tip,mensa,pregunta,variable){
		document.getElementById("bgventanamodalm").style.visibility=_valor;
		if(_valor=="hidden"){
			document.getElementById('ventanam').src="";
			if(document.getElementById('valfocus').value=="2"){
				document.getElementById('valfocus').value='1';
				document.getElementById('documento').focus();
				document.getElementById('documento').select();
			}
		}
		else{
			switch(_tip){
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
	function respuestaconsulta(pregunta, variable){
		switch(pregunta){
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
//************* guardar ************
	function guardar(){
		var validacion00=document.getElementById('numero').value;
		var validacion01=document.getElementById('nombre').value;
		if((validacion00.trim()!='')&&(validacion01.trim()!='')){
			despliegamodalm('visible','4','Esta Seguro de Guardar','1');
		}
		else{
			document.form2.numero.focus();
			document.form2.numero.select();
			despliegamodalm('visible','2','Faltan Datos para Completar el Registro');
		}
	}

	function agregardetalle(){
		var validacion00=document.getElementById('cc').value;
		var validacion01=document.getElementById('nombre').value;
		if((validacion00.trim()!='')&&(validacion01.trim()!='')){
			document.form2.agregadet.value=1;
			document.form2.submit();
		}
		else{
			despliegamodalm('visible','2','Faltan Información para poder Agregar');
		}
	}

	function eliminar(variable){
		despliegamodalm('visible','5','Esta Seguro de Eliminar','2',variable);
	}


//************* ver reporte ************
//***************************************
function verep(idfac)
{
  document.form1.oculto.value=idfac;
  document.form1.submit();
  }

//************* genera reporte ************
//***************************************
function genrep(idfac)
{
  document.form2.oculto.value=idfac;
  document.form2.submit();
  }

//************* genera reporte ************
//***************************************

function clasifica(formulario)
{
//document.form2.action="presu-recursos.php";
document.form2.submit();
}


function buscacc(e){
	if (document.form2.cc.value!=""){
 		document.form2.bcc.value='1';
 		document.form2.submit();
 	}
}

function validar2()
{
//   alert("Balance Descuadrado");
document.form2.oculto.value=2;
document.form2.action="inve-destinocompra.php";
document.form2.submit();
}

function validar()
{
document.form2.submit();
}
</script>
<script type="text/javascript" src="css/calendario.js"></script>
<script type="text/javascript" src="css/programas.js"></script>
<link href="css/css2.css" rel="stylesheet" type="text/css" />
<link href="css/css3.css" rel="stylesheet" type="text/css" /><link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
    <tr><script>barra_imagenes("inve");</script><?php cuadro_titulos();?></tr>	 
    <tr><?php menu_desplegable("inve");?></tr>
    <tr>
  <td colspan="3" class="cinta"><a href="inve-destinocompra.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" border="0" /></a><a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a><a href="inve-buscadestinocompra.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" border="0" /></a><a href="#" onClick="mypop=window.open('inve-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a></td>
</tr></table>
<tr><td colspan="3" class="tablaprin"> 
<?php
$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
$vigencia=$vigusu;
$linkbd=conectar_bd();
?>	
<?php
if(!$_POST[oculto]){
	$fec=date("d/m/Y");
	$_POST[fecha]=$fec; 	
 	$_POST[vigencia]=$vigencia;
	$_POST[valoradicion]=0;
	$_POST[valorreduccion]=0;
	$_POST[valortraslados]=0;		 		  			 
	$_POST[valor]=0;		 
	$sqlr="select MAX(RIGHT(codigo,2)) from almdestinocompra order by codigo Desc";
	//echo $sqlr;
	$res=mysql_query($sqlr,$linkbd);
	$row=mysql_fetch_row($res);
	$_POST[numero]=$row[0]+1;
	if(strlen($_POST[numero])==1){
	   $_POST[numero]='0'.$_POST[numero];
	}
}
?>
<div id="bgventanamodalm" class="bgventanamodalm">
	<div id="ventanamodalm" class="ventanamodalm">
    	<IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
		</IFRAME>
	</div>
</div>
<form name="form2" method="post" action=""> 
<?php //**** busca cuenta
if($_POST[bc]=='1'){
	$nresul=buscacuenta($_POST[cuenta]);
	if($nresul!=''){
		$_POST[ncuenta]=$nresul;
	}
	else{
  		$_POST[ncuenta]="";
  	}
}
//**** busca centro costo
if($_POST[bcc]=='1'){
	$nresul=buscacentro($_POST[cc]);
	if($nresul!=''){
  		$_POST[ncc]=$nresul;
  	}
 	else{
  		$_POST[ncc]="";
  	}
}
?>
    <table class="inicio" align="center"  >
      <tr >
        <td class="titulos" colspan="8">.: Destino Compra </td>
        <td width="61" class="cerrar" ><a href="inve-principal.php">Cerrar</a></td>
      </tr>
      <tr  >
		<td width="119" class="saludo1">Codigo:</td>
          <td width="197" valign="middle" ><input type="text" id="numero" name="numero" size="10" onKeyPress="javascript:return solonumeros(event)" 
		  onKeyUp="return tabular(event,this)" value="<?php echo $_POST[numero]?>" onClick="document.getElementById('numero').focus();document.getElementById('numero').select();"></td>
		 <td width="119" class="saludo1">Nombre:</td>
          <td width="197" valign="middle" ><input type="text" id="nombre" name="nombre" size="80" 
		  onKeyUp="return tabular(event,this)" value="<?php echo $_POST[nombre]?>" onClick="document.getElementById('acuerdo').focus();document.getElementById('acuerdo').select();"></td>
	    </tr>
    </table>	
	<table class="inicio">
	<tr><td colspan="4" class="titulos2">Destino Compra</td></tr>
	
	<tr>
    	<td class="saludo1">Concepto Contable: </td>
       	<td colspan="1"  valign="middle" >
       		<select name="concecont" id="concecont" onChange="validar()">
				<option value="-1">Seleccione ....</option>
					<?php
				 	$sqlr="Select * from conceptoscontables  where modulo='5' and tipo='A' order by codigo";
	 				$resp = mysql_query($sqlr,$linkbd);
					while($row =mysql_fetch_row($resp)){
						$i=$row[0];
						echo "<option value=$row[0] ";
						if($i==$_POST[concecont]){
			 				echo "SELECTED";
			 				$_POST[concecontnom]=$row[0]." - ".$row[3]." - ".$row[1];
			 			}
						echo " >".$row[0]." - ".$row[3]." - ".$row[1]."</option>";	  
		     		}   
					?>
	  		</select>
			<input name="concecontnom" type="text" value="<?php echo $_POST[concecontnom]?>" size="50" readonly>
       	</td>	   
	    <td class="saludo1">CC:</td><td colspan="2">
			<select id="cc" name="cc"  onChange="validar()" onKeyUp="return tabular(event,this)">
				<?php
				$linkbd=conectar_bd();
				$sqlr="select *from centrocosto where estado='S'";
				$res=mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($res)){
					echo "<option value=$row[0] ";
					$i=$row[0];
					if($i==$_POST[cc]){
						echo "SELECTED";
						$_POST[ncc]=$row[1];
					}
					echo ">".$row[0]." - ".$row[1]."</option>";	 	 
				}	 	
				?>
   			</select>
			<input name="ncc" type="hidden" value="<?php echo $_POST[ncc]?>">
	 	</td>
		<td>
        	<input type="button" name="agrega" value="  Agregar  " onClick="agregardetalle()" >
            <input type="hidden" value="0" name="agregadet">
		  	<?php
				if(!$_POST[oculto]){
		 	?>
			<script>
    			//document.form2.cc.focus();
			</script>	
			<?php
			}
	 		//*** centro  costo
			if($_POST[bcc]=='1'){
				$nresul=buscacentro($_POST[cc]);
			  	if($nresul!=''){
			  		$_POST[ncc]=$nresul;
  			  		?>
			  		<script>
			  			document.getElementById('cuenta2').focus();document.getElementById('cuenta2').select();
                 	</script>
			  		<?php
			  	}
			 	else{
			  		$_POST[ncc]="";
			  		?>
			  		<script>alert("Centro de Costos Incorrecto");document.form2.cc.focus();</script>
			  		<?php
			  	}	
			}
			?>
		 	<input type="hidden" value="0" name="oculto">	
		</td>
	</tr>
</table>
<div class="subpantallac" style="height:76.5%; width:99.6%">
<table class="inicio">
	<tr>
    	<td class="titulos" colspan="6">Detalle Destino Compra</td>
   	</tr>
	<tr>
    	<td class="titulos2">CC</td>
    	<td class="titulos2">Centro de Costo</td>
        <td class="titulos2">Concepto Contable</td>
        <td class="titulos2">Nombre Concepto</td>
        <td class="titulos2"><img src="imagenes/del.png" ><input type='hidden' name='elimina' id='elimina'></td>
   	</tr>
	<?php			 
	if ($_POST[elimina]!=''){ 
 		$posi=$_POST[elimina];
		unset($_POST[nccs][$posi]);
		unset($_POST[dccs][$posi]);
		unset($_POST[dconcecont][$posi]);		 		 		 		 		 
		unset($_POST[dnconcecont][$posi]);		 
		$_POST[dconcecont]= array_values($_POST[dconcecont]); 
		$_POST[dnconcecont]= array_values($_POST[dnconcecont]); 		 		 
		$_POST[nccs]= array_values($_POST[nccs]); 
		$_POST[dccs]= array_values($_POST[dccs]); 
 	}
	
	if($_POST[agregadet]=='1'){
		$_POST[dconcecont][]=$_POST[concecont];
		$_POST[dnconcecont][]=$_POST[concecontnom];
	 	$_POST[nccs][]=$_POST[ncc];		 
	 	$_POST[dccs][]=$_POST[cc];		 
		$_POST[agregadet]=0;
	?>
	<script>
		//document.form2.cuenta.focus();	
		document.form2.cc.select();
		document.form2.cc.value="";
	</script>
	<?php
	}
	for($x=0;$x< count($_POST[dconcecont]);$x++){
		echo "<tr>
			<td class='saludo2'>
				<input name='dccs[]' value='".$_POST[dccs][$x]."' type='text' size='2'>
			</td>
			<td class='saludo2'>
				<input name='nccs[]' value='".$_POST[nccs][$x]."' type='text' size='70'>
			</td>
			<td class='saludo2'>
				<input name='dconcecont[]' value='".$_POST[dconcecont][$x]."' type='text' size='8' readonly>
			</td>
			<td class='saludo2'>
				<input name='dnconcecont[]' value='".$_POST[dnconcecont][$x]."' type='text' size='70' readonly>
			</td>
			<td class='saludo2'>
				<a href='#' onclick='eliminar($x)'><img src='imagenes/del.png'></a></td>
			</tr>";
		 }	 
		 ?>
</table>
</div>
</form>
	<?php 
	//********** GUARDAR EL COMPROBANTE ***********
	if($_POST[oculto]=='2'){
		//rutina de guardado cabecera
		$sqlr="insert into almdestinocompra (codigo,nombre,estado) values ('$_POST[numero]','$_POST[nombre]','S')";
		if(!mysql_query($sqlr,$linkbd)){
			echo"<script>despliegamodalm('visible','2','Error no se almaceno');</script>";
		}
		else{
			//**** crear el detalle del concepto
			for($x=0;$x<count($_POST[dconcecont]);$x++)
			{
				$idtabla=selconsecutivo('almdestinocompra_det','id_det');
		  		$sqlr="insert into almdestinocompra_det (id_det,codigo,tipocuenta,cc,ccontable,vigencia,estado) values ('$idtabla','$_POST[numero]','N','".$_POST[dccs][$x]."','".$_POST[dconcecont][$x]."','".$vigencia."','S')";
		  		$res=mysql_query($sqlr,$linkbd);
		 	}
			echo"<script>despliegamodalm('visible','1','Se ha almacenado el Destino Compra con Exito');</script>";
		}	
	}
	?>	
</td></tr>     
</table>
</body>
</html>