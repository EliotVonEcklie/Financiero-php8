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
		<title>:: SPID - Control de Activos</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
		<link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<script>
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventanam').src="";}
				else
				{
					switch(_tip)
					{
						case "1":	document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
						case "2":	document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
						case "3":	document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
						case "4":	document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;	
					}
				}
			}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.getElementById('oculto').value="2";
								document.form2.submit();break;
				}
			}
			function funcionmensaje(){document.location.href = "acti-tipomov.php";}
			function guardar()
			{
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
			function validar(){
			//   alert("Balance Descuadrado");
				document.form2.submit();
			}

			function validar2(){
			//   alert("Balance Descuadrado");
			document.form2.oculto.value=2;
			document.form2.action="acti-tipomov.php";
			document.form2.submit();
			}
			function rever()
			{document.getElementById('nomrev').value=document.getElementById('nombre').value;}
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
			<a href="acti-tipomov.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" border="0" /></a>
			<a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a>
			<a href="acti-buscatipomov.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" border="0" /></a>
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" onClick="mypop=window.open('acti-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
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
 			$vigencia=date(Y);
		  $sqlr="select MAX(RIGHT(codigo,2)) from acti_tipomov where tipom='$_POST[tipom]' order by codigo Desc";
		  $res=mysql_query($sqlr,$linkbd);
		  $row=mysql_fetch_row($res);
		  $_POST[numero]=$row[0]+1;
		  $_POST[numrev]=$row[0]+1;
		 
		  if(strlen($_POST[numero])==1)
		   {
			   $_POST[numero]='0'.$_POST[numero];
			 $_POST[numrev]='0'.$_POST[numrev];
			}
			
			//echo "oc".$_POST[oculto];
		if($_POST[oculto]=="")
		{
 		 $fec=date("d/m/Y");
		 $_POST[fecha]=$fec; 	
 	 	 $_POST[vigencia]=$vigencia;
		 $_POST[valoradicion]=0;
		 $_POST[valorreduccion]=0;
		 $_POST[valortraslados]=0;		 		  			 
		 $_POST[valor]=0;		 
		  $sqlr="select MAX(RIGHT(codigo,2)) from acti_tipomov where tipom='1' order by codigo Desc";
		 //echo $sqlr;
		  $res=mysql_query($sqlr,$linkbd);
		  $row=mysql_fetch_row($res);
		  $_POST[numero]=$row[0]+1;
		   $_POST[numrev]=$row[0]+1;
		  if(strlen($_POST[numero])==1)
		   {
			   $_POST[numero]='0'.$_POST[numero];
				$_POST[numrev]='0'.$_POST[numrev];
			}
}
?>

<?php //**** busca cuenta
  			if($_POST[bc]=='1')
			 {
			  $nresul=buscacuenta($_POST[cuenta]);
			  if($nresul!=''){ $_POST[ncuenta]=$nresul;}
			 else{$_POST[ncuenta]="";}
			 }
			  //**** busca centro costo
  			if($_POST[bcc]=='1')
			 {
			  $nresul=buscacentro($_POST[cc]);
			  if($nresul!=''){ $_POST[ncc]=$nresul;}
			 else{$_POST[ncc]="";}
			 }
			 ?>
    <table class="inicio" align="center"  >
      <tr >
        <td class="titulos" colspan="8">.: Tipo Movimiento</td>
        <td class="cerrar" style="width:7%;" ><a href="acti-principal.php">&nbsp;Cerrar</a></td>
      </tr>
      <tr>
      	<td class="saludo1">Tipo Mov.:</td><td><select name="tipom" onChange="validar()">
		   <option value="1" <?php if($_POST[tipom]=='1') echo "SELECTED"; ?>>1 - Entrada</option>
          <option value="2" <?php if($_POST[tipom]=='2') echo "SELECTED"; ?>>2 - Salida</option>
		  </select>  </td>
		<td  class="saludo1">Codigo Tipo Mov.:</td>
        <td valign="middle" ><input type="text" id="codtipomov" name="codtipomov" size="10"  value="<?php if($_POST[tipom]=="") echo 1; else echo $_POST[tipom]; ?>"  readonly=readonly></td>
        
        <td  class="saludo1">Codigo:</td>
          <td  valign="middle" ><input type="text" id="numero" name="numero" size="10" onKeyPress="javascript:return solonumeros(event)" 
		  onKeyUp="return tabular(event,this)" value="<?php echo $_POST[numero]?>" onClick="document.getElementById('numero').focus();document.getElementById('numero').select();" readonly=readonly></td>
		 <td width="119" class="saludo1">Nombre:</td>
          <td  valign="middle" ><input type="text" id="nombre" name="nombre" size="80" 
		  onKeyUp="return tabular(event,this)" value="<?php echo $_POST[nombre]?>" onClick="document.getElementById('acuerdo').focus();document.getElementById('acuerdo').select();"  onkeydown="rever()" onChange="rever()" >	</td>
	    </tr>
        <tr>
        <td></td><td></td>		<td  class="saludo1">Codigo Tipo Mov.:</td>
          <td valign="middle" ><input type="text" id="codtipomov" name="codtipomov" size="10"  value="<?php if($_POST[tipom]=="")echo 3; else echo $_POST[tipom]+2; ?>"  readonly=readonly></td>
    
        <td width="119" class="saludo1">Codigo Reversi&oacute;n:</td>
          <td  valign="middle" ><input type="text" id="numrev" name="numrev" size="10"  value="<?php echo $_POST[numrev]?>"  readonly=readonly></td>
		
        <td width="119" class="saludo1">Nombre Reversi&oacute;n:</td>
          <td  valign="middle" ><input type="text" id="nomrev" name="nomrev" size="80" 
		   value="<?php echo $_POST[nomrev]?>" readonly=readonly> </td>
        
        </tr>
    </table>	
	<input type="hidden" name="oculto" id="oculto" value="1" >
</form>
	<?php 
	//********** GUARDAR EL COMPROBANTE ***********
	if($_POST[oculto]=='2')	
		{
		//rutina de guardado cabecera
		$linkbd=conectar_bd();
		ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
		$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
		$sqlr="insert into acti_tipomov (codigo,tipom,nombre,estado) values ('$_POST[numero]','$_POST[tipom]','$_POST[nombre]','S')";
		if (!mysql_query($sqlr,$linkbd)){
			echo"<script>despliegamodalm('visible','2',''Error no se almaceno');</script>";
		}	
		else {
			$sqlr="insert into acti_tipomov (codigo,tipom,nombre,estado) values ('$_POST[numero]','".($_POST[tipom]+2)."','$_POST[nombre]','S')";
			if (!mysql_query($sqlr,$linkbd)){echo"<script>despliegamodalm('visible','2',''Error no se almaceno');</script>";}
			else {echo"<script>despliegamodalm('visible','1','Se ha Almacenado con Exito el Tipo de Movimiento');</script>";}
		}
	}
	?>	
</td></tr>     
</table>
</body>
</html>