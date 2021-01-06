<?php //V 1000 12/12/16 ?> 
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
	$filtro="'".$_GET['filtro']."'";
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
<title>:: SPID - Almacen</title>
<script>
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
				document.getElementById('oculto').value="7";
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
			despliegamodalm('visible','2','Faltan Informaci�n para poder Agregar');
		}
	}

	function eliminar(variable){
		despliegamodalm('visible','5','Esta Seguro de Eliminar','2',variable);
	}

//************* genera reporte ************
//***************************************

	function validar(){
		document.getElementById('oculto').value="7";
		document.form2.submit();
	}	
</script>
<script type="text/javascript" src="css/programas.js"></script>
<script type="text/javascript" src="css/calendario.js"></script>
<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script>
			function adelante(scrtop, numpag, limreg, filtro, next){
				var maximo=document.getElementById('maximo').value;
				var actual=document.getElementById('numero').value;
				if(parseFloat(maximo)>parseFloat(actual)){
					document.getElementById('oculto').value='1';
					document.getElementById('numero').value=next;
					var idcta=document.getElementById('numero').value;
					document.form2.action="inve-editadestinocompra.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					document.form2.submit();
				}
			}
		
			function atrasc(scrtop, numpag, limreg, filtro, prev){
				var minimo=document.getElementById('minimo').value;
				var actual=document.getElementById('numero').value;
				if(parseFloat(minimo)<parseFloat(actual)){
					document.getElementById('oculto').value='1';
					document.getElementById('numero').value=prev;
					var idcta=document.getElementById('numero').value;
					document.form2.action="inve-editadestinocompra.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
					document.form2.submit();
				}
			}
		
			function iratras(scrtop, numpag, limreg, filtro){
				var idcta=document.getElementById('numero').value;
				location.href="inve-buscadestinocompra.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg+"&filtro="+filtro;
			}
		</script>
<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
        <?php
		$numpag=$_GET[numpag];
		$limreg=$_GET[limreg];
		$scrtop=26*$totreg;
		?>
<table>
    <tr><script>barra_imagenes("inve");</script><?php cuadro_titulos();?></tr>	 
    <tr><?php menu_desplegable("inve");?></tr>
    <tr>
  <td colspan="3" class="cinta"><a href="inve-destinocompra.php" class="mgbt"><img src="imagenes/add.png"  title="Nuevo" border="0" /></a><a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a><a href="inve-buscadestinocompra.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" border="0" /></a><a href="#" onClick="mypop=window.open('inve-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a><a href="#" onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>)" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a></td>
</tr>
</table>
<tr><td colspan="3" class="tablaprin"> 
<?php
//$vigencia=date(Y);
//$linkbd=conectar_bd();
 ?>	
<?php
			if ($_GET[is]!=""){echo "<script>document.getElementById('codrec').value=$_GET[is];</script>";}
			$sqlr="select MIN(CONVERT(codigo, SIGNED INTEGER)), MAX(CONVERT(codigo, SIGNED INTEGER)) from almdestinocompra ORDER BY CONVERT(codigo, SIGNED INTEGER)";
			$res=mysql_query($sqlr,$linkbd);
			$r=mysql_fetch_row($res);
			$_POST[minimo]=$r[0];
			$_POST[maximo]=$r[1];
			if($_POST[oculto]==""){
				if ($_POST[codrec]!="" || $_GET[is]!=""){
					if($_POST[codrec]!=""){
						$sqlr="select *from almdestinocompra where codigo='$_POST[codrec]'";
					}
					else{
						$sqlr="select *from almdestinocompra where codigo ='$_GET[is]'";
					}
				}
				else{
					$sqlr="select * from  almdestinocompra ORDER BY CONVERT(codigo, SIGNED INTEGER) DESC";
				}
				$res=mysql_query($sqlr,$linkbd);
				$row=mysql_fetch_row($res);
			   	$_POST[numero]=$row[0];
			}

if(($_POST[oculto]!="2")&&($_POST[oculto]!="7")){
	$linkbd=conectar_bd();
	$sqlr="select *from almdestinocompra where almdestinocompra.codigo='$_POST[numero]'  ";
	//echo $sqlr;
	$res=mysql_query($sqlr,$linkbd); 
	while ($row=mysql_fetch_row($res)){
		$_POST[nombre]=$row[1];
		$_POST[numero]=$row[0];
	}
}

if(($_POST[oculto]!="7")){
	$sqlr="select *from  almdestinocompra_det  where almdestinocompra_det.codigo='$_POST[numero]' ";
//echo $sqlr;
	$res=mysql_query($sqlr,$linkbd); 
	$cont=0;
	while($row=mysql_fetch_row($res)){
		//$_POST[nombre]=$row[1];
		//$_POST[numero]=$row[0];
		$_POST[dcuentas][$cont]=$row[3];
		$_POST[dccs][$cont]=$row[4];
		$_POST[nccs][$cont]=buscacentro($row[4]);
		$_POST[dconcecont][$cont]=$row[5];
		
		$sqlr="select nombre from  conceptoscontables where modulo='5' and (tipo='AT' or tipo='CT') and conceptoscontables.codigo='$row[5]'";
		
		$r=mysql_query($sqlr,$linkbd); 
		while ($rw=mysql_fetch_row($r)){
			$_POST[dnconcecont][$cont]=$rw[0];
		}
	
		$_POST[vigencia][$cont]=$row[6];
		$cont=$cont+1;
	}
}
			//NEXT
			$sqln="select *from almdestinocompra WHERE codigo > '$_POST[numero]' ORDER BY codigo ASC LIMIT 1";
			$resn=mysql_query($sqln,$linkbd);
			$row=mysql_fetch_row($resn);
			$next="'".$row[0]."'";
			//PREV
			$sqlp="select *from almdestinocompra WHERE codigo < '$_POST[numero]' ORDER BY codigo DESC LIMIT 1";
			$resp=mysql_query($sqlp,$linkbd);
			$row=mysql_fetch_row($resp);
			$prev="'".$row[0]."'";

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
	$nresul=buscacuentapres($_POST[cuenta2],2);
	if($nresul!=''){
  		$_POST[ncuenta2]=$nresul;
  	}
	else{
		$_POST[ncuenta2]="";
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
        <td class="titulos" colspan="8">.: Editar Destino Compra</td>
        <td width="61" class="cerrar" ><a href="inve-principal.php">Cerrar</a></td>
      </tr>
      <tr  >
		<td width="119" class="saludo1">Codigo:</td>
          <td style="width:15%" valign="middle" >
	        	    	<a href="#" onClick="atrasc(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $prev; ?>)"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a> 
          	<input type="text" id="numero" name="numero" style="width:50%" onKeyPress="javascript:return solonumeros(event)" 
		  onKeyUp="return tabular(event,this)" value="<?php echo $_POST[numero]?>" onClick="document.getElementById('numero').focus();document.getElementById('numero').select();">
	    	            <a href="#" onClick="adelante(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>, <?php echo $filtro; ?>, <?php echo $next; ?>)"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> 
						<input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo" id="maximo">
						<input type="hidden" value="<?php echo $_POST[minimo]?>" name="minimo" id="minimo">
						<input type="hidden" value="<?php echo $_POST[codrec]?>" name="codrec" id="codrec">
         	</td>
		 <td width="119" class="saludo1">Nombre:</td>
          <td width="197" valign="middle" ><input type="text" id="nombre" name="nombre" size="80" 
		  onKeyUp="return tabular(event,this)" value="<?php echo $_POST[nombre]?>" onClick="document.getElementById('acuerdo').focus();document.getElementById('acuerdo').select();"></td>
    </tr>
</table>
<table class="inicio">
	<tr>
    	<td colspan="6" class="titulos2">Crear Detalle Destino Compra</td>
   	</tr>
	<tr>
		<td  class="saludo1">Concepto Contable: </td>
        <td colspan="1"  valign="middle" >
       		<select name="concecont" id="concecont" onChange="validar()">
				<option value="-1">Seleccione ....</option>
					<?php
				 	$sqlr="Select * from conceptoscontables  where modulo='5' and (tipo='AT' or tipo='CT') order by codigo";
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
        	<input type="button" name="agrega" value="  Agregar  " onClick="agregardetalle()" ><input type="hidden" value="0" name="agregadet">
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
		  	<input type="hidden" value="0" name="oculto" id="oculto">	
		</td>
	</tr>
</table>
<div class="subpantallac" style="height:76.5%; width:99.6%">
<table class="inicio">
	<tr>
    	<td class="titulos" colspan="7">Detalle Destino Compra</td>
   	</tr>
	<tr>
    	<td class="titulos2">CC</td>
        <td class="titulos2">Centro de Costos</td>
        <td class="titulos2">Codigo Concepto Contable</td>
        <td class="titulos2">Concepto Contable</td>
        <td class="titulos2"><img src="imagenes/del.png" ><input type='hidden' name='elimina' id='elimina'></td>
   	</tr>
	<?php
	if ($_POST[elimina]!=''){ 
		$posi=$_POST[elimina];
		unset($_POST[nccs][$posi]);
		unset($_POST[dccs][$posi]);
		unset($_POST[dconcecont][$posi]);
		unset($_POST[dnconcecont][$posi]);
		$_POST[nccs]= array_values($_POST[nccs]); 
		$_POST[dccs]= array_values($_POST[dccs]); 
		$_POST[dconcecont]= array_values($_POST[dconcecont]); 
		$_POST[dnconcecont]= array_values($_POST[dnconcecont]); 		 
	 }
	
	if($_POST[agregadet]=='1'){
		$cuentacred=0;
		$cuentadeb=0;
		$diferencia=0;
	 	$_POST[nccs][]=$_POST[ncc];		 
		$_POST[dccs][]=$_POST[cc];		 
		$_POST[dconcecont][]=$_POST[concecont];
		$_POST[dnconcecont][]=$_POST[concecontnom];
	 	$_POST[agregadet]=0;
		?>
	 	<script>
			//document.form2.cuenta.focus();	
			document.form2.cc.select();
			document.form2.cc.value="";
		</script>
	<?php
	}
	$iter='saludo1a';
	$iter2='saludo2';
	for ($x=0;$x< count($_POST[dconcecont]);$x++){
		echo "
		<input name='dccs[]' value='".$_POST[dccs][$x]."' type='hidden' size='2'>
		<input name='nccs[]' value='".$_POST[nccs][$x]."' type='hidden' size='70'>
		<input name='dconcecont[]' value='".$_POST[dconcecont][$x]."' type='hidden' size='8' readonly>
		<input name='dnconcecont[]' value='".$_POST[dnconcecont][$x]."' type='hidden' size='50' readonly>
		<tr class='$iter'>
			<td>".$_POST[dccs][$x]."</td>
			<td>".$_POST[nccs][$x]."</td>
			<td>".$_POST[dconcecont][$x]."</td>
			<td>".$_POST[dnconcecont][$x]."</td>
			<td>
				<a href='#' onclick='eliminar($x)'><img src='imagenes/del.png'></a>
			</td>
		</tr>";
		$aux=$iter;
		$iter=$iter2;
		$iter2=$aux;
	}	 
	?>
</table>
</div>
</form>
<?php 
//********** GUARDAR EL COMPROBANTE ***********
if($_POST[oculto]=='2'){
	//rutina de guardado cabecera
	$linkbd=conectar_bd();
	$sqlr="delete from almdestinocompra_det where codigo='".$_POST[numero]."' ";	 
	mysql_query($sqlr,$linkbd);
	$sqlr="delete from almdestinocompra where codigo='".$_POST[numero]."' ";	 
	mysql_query($sqlr,$linkbd);
			
	$sqlr="insert into almdestinocompra (codigo,nombre,estado) values ('$_POST[numero]','$_POST[nombre]','S')";
	//echo $sqlr;
	if(!mysql_query($sqlr,$linkbd)){
		echo"<script>despliegamodalm('visible','2','Error no se almaceno');</script>";
	}
	else{
		echo"<script>despliegamodalm('visible','1','Se ha Actualizado el Destino Compra con Exito');</script>";
		//**** crear el detalle del concepto
		for($x=0;$x<count($_POST[dconcecont]);$x++)
		{
			$idtabla=selconsecutivo('almdestinocompra_det','id_det');
			$sqlr="insert into almdestinocompra_det (id_det,codigo,tipocuenta,cc,ccontable,vigencia,estado) values ('$idtabla','$_POST[numero]', 'N','".$_POST[dccs][$x]."','".$_POST[dconcecont][$x]."','".$vigencia."','S')";
		  	$res=mysql_query($sqlr,$linkbd);
		}
	}
}
?>	
</td></tr>     
</table>
</body>
</html>