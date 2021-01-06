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
		<title>:: Spid - Activos Fijos</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type='text/javascript' src='JQuery/jquery-2.1.4.min.js'></script>
        <script type="text/javascript" src="css/calendario.js"></script>
        <script type="text/javascript" src="css/programas.js"></script>
<script>
	function guardar()
	{
		if (document.form2.numero.value!='' && document.form2.nombre.value!='')
		{
			despliegamodalm('visible','4','Esta Seguro de Guardar','1');
		}
		else
		{
			despliegamodalm('visible','2','Falta informacion para Crear el Tipo');
			document.form2.numero.focus();
			document.form2.numero.select();
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
		if($('#tabact >tbody >tr').length < 3){
			if( true){
				document.form2.agregadet.value=1;
				document.form2.submit();
			}
			else {
				despliegamodalm('visible','2','Falta informacion para poder Agregar');
			}
		}
		else{
			despliegamodalm('visible','2','No se Puede Agregar mas de 1 Registro');
		}
	}

	function eliminar(variable)
	{
		despliegamodalm('visible','5','Esta Seguro de Eliminar','2',variable);
	}

	function buscacta(objeto)
	{
		if(objeto=='1'){if (document.form2.cuentadeb.value!=""){document.form2.bcd.value='1';document.form2.submit();}}
		if(objeto=='2'){if (document.form2.cuentacred.value!=""){document.form2.bccr.value='1';document.form2.submit();}}
		if(objeto=='3'){if (document.form2.cuentact.value!=""){document.form2.bca.value='1';document.form2.submit();}}
		if(objeto=='4'){if (document.form2.cuentaper.value!=""){document.form2.bcp.value='1';document.form2.submit();}}
	}

	function deprec()
	{
		var campo = document.getElementById('agedep');
		if (document.form2.deprecia.checked==true){
			campo.readOnly=true;
			document.form2.deprecia2.value="S";
		}else{
			campo.readOnly=false;
			document.form2.deprecia2.value="N";
			document.form2.agedep.value=0;
		}
	}
	
	function valDep()
	{
		if($('#deprecia').is(":checked")){
			$('#agedep').attr('readonly','readonly');
			$('#agedep').val('');
			$('#deprecia2').val('S');
		}
		else{
			$('#agedep').removeAttr('readonly');
			$('#deprecia2').val('N');
		}
	}


	 function validar2()
	{
		//alert("Balance Descuadrado");
		document.form2.oculto.value=2;
		document.form2.action="presu-concecontablesconpes.php";
		document.form2.submit();
	}

	function validar(){document.form2.submit();}



	function despliegamodal2(_valor,scr){
		//alert("Hola"+scr);
		if(scr=="1"){
			var url="ventana-activo.php?obj01=activo&obj02=nactivo&tipo=activos";
		}
		if(scr=="2"){
			var url="ventana-activo.php?obj01=depreciacion&obj02=ndepreciacion&tipo=depreciacion";
		}
		if(scr=="3"){
			var url="ventana-activo.php?obj01=deterioro&obj02=ndeterioro&tipo=deterioro";
		}
		document.getElementById("bgventanamodal2").style.visibility=_valor;
		if(_valor=="hidden"){
			document.getElementById('ventana2').src="";
		}else {
			document.getElementById('ventana2').src=url;
		}
	}


	function iratras(id){
		location.href="acti-buscatipo.php?id="+id;
	}
	function atras(id){
		id-=1;
		if (id!=0) {
			location.href="acti-editartipo.php?id="+id;
		}
	}
	
	function adelante(id, maximoCab){
		id++;
		if (id<=maximoCab) {
			location.href="acti-editartipo.php?id="+id;
		}

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
			<a href="acti-tipo.php" class="mgbt"><img src="imagenes/add.png"  title="Nuevo"/></a>
			<a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a>
			<a href="acti-buscatipo.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a>
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" onClick="mypop=window.open('acti-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
			<a href="#" onclick='iratras("<?php echo $_GET[id] ?>")' class="mgbt"><img src="imagenes/iratras.png" title="Atrás"></a>
		</td>
	</tr>
</table>
<?php
$vigencia=date(Y);
$linkbd=conectar_bd();
 ?>	
<?php
//echo "oc:".$_POST[oculto];

$sqlr="SELECT MAX(id) from acti_tipo_cab";
$res=mysql_query($sqlr);
$row =mysql_fetch_row($res);
$maximoCab=$row[0];

if($_POST[oculto]=='')
{
	$fec=date("d/m/Y");
	$_POST[fecha]=$fec; 	
	$_POST[vigencia]=$vigencia;
	$_POST[agedep]=0;
	$_POST[valorreduccion]=0;
	$_POST[valortraslados]=0;		 		  			 
	$_POST[valor]=0;		 
	$sqlr="SELECT * from acti_tipo_cab where id=$_GET[id]";
	// echo $sqlr;
	$res=mysql_query($sqlr);
	$row=mysql_fetch_row($res);

	$_POST[numero] = $row[0];
	$_POST[nombre] = $row[1];
	$_POST[deprecia2] = $row[2];
	$_POST[agedep] = $row[3];
	$checked='';
	if ($_POST[deprecia2]=='S') {
		$checked = 'checked="checked"';

	}

	if(strlen($_POST[numero])==1){
		$_POST[numero]='0'.$_POST[numero];
	}

	

	$sqlr2="SELECT * from acti_tipo_det where id_cab=$_GET[id]";
	// echo $sqlr;
	$res2=mysql_query($sqlr2);
	$x=0;
	while ($row2 =mysql_fetch_row($res2)){

		$_POST[dccs][$x] = $row2[0];
		$_POST[dcuentasdeb][$x] = $row2[2];
		$_POST[dcuentascred][$x] = $row2[3];
		$_POST[dcuentasact][$x] = $row2[4];

		$sqlr3="SELECT * from acti_activos_cab where id=$row2[2]";
		$res3=mysql_query($sqlr3);
		$row3 =mysql_fetch_row($res3);
		$_POST[dncuentasdeb][$x] = $row3[1];

		$sqlr4="SELECT * from acti_depreciacionactivos_cab where id=$row2[3]";
		$res4=mysql_query($sqlr4);
		$row4 =mysql_fetch_row($res4);
		$_POST[dncuentascred][$x] = $row4[1];

		$sqlr5="SELECT * from acti_deterioro_cab where id=$row2[4]";
		$res5=mysql_query($sqlr5);
		$row5 =mysql_fetch_row($res5);
		$_POST[dncuentasact][$x] = $row5[1];

		$x++;
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

    <table class="inicio" align="center"  >
      	<tr>
        	<td class="titulos" colspan="9" style='width:90%'>.: Tipo</td>
        	<td  class="cerrar" style='width:10%'><a href="acti-principal.php">&nbsp;&nbsp;Cerrar</a></td>
      	</tr>
      	<tr>
			<td class="saludo1" style='width:10%'>Codigo:</td>
          	<td  style='width:10%'>
          		<a onclick='atras("<?php echo $_GET[id] ?>")' style="cursor:pointer;"><img src="imagenes/back.png" alt="siguiente" align="absmiddle"></a>
          		<input type="text" id="numero" name="numero" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[numero]?>" onClick="document.getElementById('numero').focus();document.getElementById('numero').select();" style='width:65%' readonly>
          		<a onclick='adelante("<?php echo $_GET[id] ?>","<?php echo $maximoCab ?>")' style="cursor:pointer;"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a>
      		</td>
		 	<td class="saludo1" style='width:10%'>Nombre:</td>
          	<td style='width:36%'><input type="text" id="nombre" name="nombre" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[nombre]?>" onClick="document.getElementById('acuerdo').focus();document.getElementById('acuerdo').select();" style='width:95%'></td>
          	<td class="saludo1" style='width:10%'>Deprecia:</td>
            <td style='width:4%'>
            	<input id="deprecia" name="deprecia" type="checkbox" onclick="valDep()" <?php echo $checked; ?> >
            	<input type="hidden" name="deprecia2" id="deprecia2" value="<?php $_POST[deprecia2] ?>">
        	</td>
			<td class="saludo1" style='width:10%'>Meses Depreciacion:</td>
	  		<td colspan="2" style='width:5%'><input type="text" id="agedep" name="agedep" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[agedep]?>" onClick="document.getElementById('agedep').focus();document.getElementById('agedep').select();" style='width:80%'></td>          
		</tr>
    </table>
	<table class="inicio">
		<tr><td colspan="6" class="titulos2">Crear Detalle</td></tr>	
		<tr>
        	<td class="saludo1" style='width:10%'>Activos:</td>
			<td style='width:10%'>
				<input type="text" id="activo" name="activo" onKeyPress="javascript:return solonumeros(event)" 
              	onKeyUp="return tabular(event,this)" onBlur="buscacta('1')" value="<?php echo $_POST[activo]?>" onClick="document.getElementById('activo').focus();document.getElementById('activo').select();" style='width:80%'>
              	<a href="#" onClick="despliegamodal2('visible','1')"><img src="imagenes/find02.png" style='width:16px'></a>  
              	<input type="hidden" value="0" name="bcd">
          	</td>
      		<td style='width:30%'><input id="nactivo" name="nactivo" type="text" value="<?php echo $_POST[nactivo]?>" style='width:100%' readonly></td>
         	
		</tr>
		<tr>
         	<td class="saludo1" style='width:10%'>Depreciacion:</td>
          	<td style='width:10%'><input type="text" id="depreciacion" name="depreciacion"  onKeyPress="javascript:return solonumeros(event)" 
			  onKeyUp="return tabular(event,this)" onBlur="buscacta('2')" value="<?php echo $_POST[depreciacion]?>" onClick="document.getElementById('depreciacion').focus();document.getElementById('depreciacion').select();" style='width:80%'><input type="hidden" value="0" name="bccr"><a href="#" onClick="despliegamodal2('visible','2')">&nbsp;<img src="imagenes/find02.png" style='width:16px'></a>  </td>
          	<td style='width:30%'>
          		<input id="ndepreciacion" name="ndepreciacion" type="text" value="<?php echo $_POST[ndepreciacion]?>" style='width:100%' readonly>
      		</td> 
		</tr>
		<tr>
        	<td class="saludo1">Deterioro:</td>
           	<td>
           		<input type="text" id="deterioro" name="deterioro"  onKeyPress="javascript:return solonumeros(event)" 
              onKeyUp="return tabular(event,this)" onBlur="buscacta('3')" value="<?php echo $_POST[deterioro]?>" onClick="document.getElementById('deterioro').focus();document.getElementById('deterioro').select();" style='width:80%'><input type="hidden" value="0" name="bca"><a href="#" onClick="despliegamodal2('visible','3')">&nbsp;<img src="imagenes/find02.png" style='width:16px'></a>
          	</td>
          	<td>
          		<input name="ndeterioro" type="text" id="ndeterioro" value="<?php echo $_POST[ndeterioro]?>" style='width:100%' readonly>
      		</td>
      		<td>
	 			<input type="button" name="agrega" value="  Agregar  " onClick="agregardetalle()" >
				<input type="hidden" value="0" name="agregadet"> 
				<input type="hidden" id="oculto" name="oculto" value="0">
 			</td>
	 		
        </tr>
		
		 		  
	</table>
	<div class="subpantallac" style="height:49.5%; width:99.6%;">
	<table class="inicio" id="tabact">
		<tr>
			<td class="titulos" colspan="10">Detalles</td>
		</tr>
		<tr>
			<td class="titulos2">Item</td>
			<td class="titulos2">Activo</td>
			<td class="titulos2">Nombre Activo</td>
			<td class="titulos2">Depreciacion</td>
			<td class="titulos2">Nombre Depreciacion</td>
			<td class="titulos2">Deterioro</td>
			<td class="titulos2">Nombre Deterioro</td>
			<td class="titulos2"><img src="imagenes/del.png" ><input type='hidden' name='elimina' id='elimina'></td>
		</tr>
	<?php	
	//echo "<br>posic:".$_POST[elimina];		 
	if ($_POST[elimina]!=''){ 		 
	 	$posi=$_POST[elimina];
		// echo "<br>posic:".$_POST[elimina];
		unset($_POST[dcuentasdeb][$posi]);
 		unset($_POST[dncuentasdeb][$posi]);
		unset($_POST[dcuentascred][$posi]);
		unset($_POST[dncuentascred][$posi]);
  		unset($_POST[dcuentasper][$posi]);
 		unset($_POST[dncuentasper][$posi]);
		unset($_POST[dcuentasact][$posi]);
 		unset($_POST[dncuentasact][$posi]);		 
		unset($_POST[dccs][$posi]);		 	 
		$_POST[dcuentasdeb]= array_values($_POST[dcuentasdeb]); 
		$_POST[dncuentasdeb]= array_values($_POST[dncuentasdeb]); 	
		$_POST[dcuentascred]= array_values($_POST[dcuentascred]); 
		$_POST[dncuentascred]= array_values($_POST[dncuentascred]); 	
		$_POST[dcuentasper]= array_values($_POST[dcuentasper]); 
		$_POST[dncuentasper]= array_values($_POST[dncuentasper]); 	
		$_POST[dcuentasact]= array_values($_POST[dcuentasact]); 
		$_POST[dncuentasact]= array_values($_POST[dncuentasact]); 	
		 	 		 
		$_POST[dccs]= array_values($_POST[dccs]); 
		/*echo $_POST[dccs][0];

		$elimnarSQL=" id_cab='$_POST[numero]'";
		for($x=0;$x<count($_POST[dccs]);$x++) {
  			$elimnarSQL=$elimnarSQL.' AND id!='.$_POST[dccs][$x];
  		}
		$sqlr="DELETE FROM acti_tipo_det WHERE $elimnarSQL";
		$res=mysql_query($sqlr,$linkbd);*/
	}
	
	if ($_POST[agregadet]=='1')
		 {
		  $cuentacred=0;
		  $cuentadeb=0;
		  $diferencia=0;
		 $_POST[dcuentasdeb][]=$_POST[activo];
		 $_POST[dncuentasdeb][]=$_POST[nactivo];
		 $_POST[dcuentascred][]=$_POST[depreciacion];
		 $_POST[dncuentascred][]=$_POST[ndepreciacion];		 
		 $_POST[dcuentasact][]=$_POST[deterioro];
		 $_POST[dncuentasact][]=$_POST[ndeterioro];		 
		 $_POST[dcuentasper][]=$_POST[cuentaper];
		 $_POST[dncuentasper][]=$_POST[ncuentaper];	 
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
		 $iter='zebra1';
		 $iter2='zebra2';
		 for ($x=0;$x< count($_POST[dcuentasdeb]);$x++)
		 {
		 	echo "<tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
				onMouseOut=\"this.style.backgroundColor=anterior\" >
			 <td><input name='dccs[]' value='".($x+1)."' type='text' size='1' class='inpnovisibles' readonly></td>
			 <td><input name='dcuentasdeb[]' value='".$_POST[dcuentasdeb][$x]."' type='text' size='6' class='inpnovisibles' readonly></td>
			 <td><input name='dncuentasdeb[]' value='".$_POST[dncuentasdeb][$x]."' type='text' size='50' class='inpnovisibles' readonly></td>
			 <td><input name='dcuentascred[]' value='".$_POST[dcuentascred][$x]."' type='text' size='6' class='inpnovisibles' readonly></td>
			 <td><input name='dncuentascred[]' value='".$_POST[dncuentascred][$x]."' type='text' size='50' class='inpnovisibles' readonly></td>
			 <td><input name='dcuentasact[]' value='".$_POST[dcuentasact][$x]."' type='text' size='6' class='inpnovisibles' readonly></td>
			 <td><input name='dncuentasact[]' value='".$_POST[dncuentasact][$x]."' type='text' size='50' class='inpnovisibles' readonly></td>
			 <td style='text-align:center;'><a href='#' onclick='eliminar($x)'><img src='imagenes/del.png'></a></td></tr>";
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
	if($_POST[oculto]=='2')	
	{
		//rutina de guardado cabecera
		$linkbd=conectar_bd();
		ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
		$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
		$sqlr="UPDATE acti_tipo_cab SET nombre='$_POST[nombre]',deprecia='$_POST[deprecia2]',anios_depreciacion='$_POST[agedep]' WHERE id='$_POST[numero]'";

		//echo $sqlr.'<br>';
		if(!mysql_query($sqlr,$linkbd))
		{
			echo "<script>despliegamodalm('visible','3','No se pudo ejecutar la petición');</script>";
  		}
		else
		{
			echo "<script>despliegamodalm('visible','3','Se ha modificado con Exito el Tipo');</script>";
	  		//$elimnarSQL=" id_cab='$_POST[numero]'";
		  	
		  	$sqlr="DELETE FROM acti_tipo_det WHERE id_cab='$_POST[numero]'";
			$res=mysql_query($sqlr,$linkbd);
	  		for($x=0;$x<count($_POST[dccs]);$x++) {
	  			//$elimnarSQL=$elimnarSQL.' AND id!='.$_POST[dccs][$x];
			 	$sqlr="INSERT into acti_tipo_det(id,id_cab,creacion_activo,depreciacion_activo,deterioro_activo,estado) values ('".$_POST[dccs][$x]."','$_POST[numero]', '".$_POST[dcuentasdeb][$x]."','".$_POST[dcuentascred][$x]."', '".$_POST[dcuentasact][$x]."','S')";
			  	$res=mysql_query($sqlr,$linkbd);
			  	//echo $elimnarSQL.'<br>';
			}
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