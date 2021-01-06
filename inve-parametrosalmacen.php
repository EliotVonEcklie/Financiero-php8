<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	header("Content-Type: text/html;charset=iso-8859-1");
	date_default_timezone_set("America/Bogota");
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: SPID - Almacen</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
		<link href="css/tabs.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
        <script type="text/javascript" src="JQuery/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="JQuery/autoNumeric-master/autoNumeric-min.js"></script>
		<script>
			jQuery(function($){ $('#vltmindustria').autoNumeric('init');});
			function funcionmensaje(){}
			function despliegamodalm(_valor,_tip,mensa,pregunta, variable)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden"){
					document.getElementById('ventanam').src="";
				}
				else{
					switch(_tip)
					{
						case "1":	document.getElementById('ventanam').src="ventana-mensaje1.php?titulos="+mensa;break;
						case "2":	document.getElementById('ventanam').src="ventana-mensaje3.php?titulos="+mensa;break;
						case "3":	document.getElementById('ventanam').src="ventana-mensaje2.php?titulos="+mensa;break;
						case "4":	document.getElementById('ventanam').src="ventana-consulta1.php?titulos="+mensa+"&idresp="+pregunta;break;	
						case "5":	document.getElementById('ventanam').src="ventana-elimina1.php?titulos="+mensa+"&idresp="+pregunta+"&variable="+variable;break;	
					}
				}
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
			
			function guardar()
			{
				var val01 = document.getElementById("cuenta").value;
				var val02 = document.getElementById("ncuenta").value;
				if(val01.trim() != '' && val02.trim() !='' )
					despliegamodalm('visible','4','Esta Seguro de Guardar','1','0');
				else
					despliegamodalm('visible','2','Faltan registros para actualizar');
			}
			
			function buscacta(event){
				document.form2.bc.value = '1';
				document.form2.oculto.value = '1';
				document.form2.submit();
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("inve");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("inve");?></tr>
   			<tr>
  				<td colspan="3" class="cinta">
				<a><img src="imagenes/add.png" title="Nuevo" onclick="location.href='inve-parametrosalmacen.php'" class="mgbt"/></a>
				<a><img src="imagenes/guarda.png" title="Guardar" class="mgbt" onClick="guardar()" /></a>
				<a><img src="imagenes/buscad.png" class="mgbt1"/></a>
				<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
				<a><img src="imagenes/nv.png" title="Nueva Ventana" onClick="mypop=window.open('inve-principal.php','','');mypop.focus();" class="mgbt"/></a>
				</td>
    		</tr>
    	</table>	
		<div id="bgventanamodal2">
			<div id="ventanamodal2">
				<IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
				</IFRAME>
			</div>
		</div>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>		
		<form name="form2" method="post" >
			<input type="hidden" name="valfocus" id="valfocus" value="0"/>
			<?php
 				$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
				if($_POST[oculto]=="")
				{
  					$_POST[diacorte]=1;
					$_POST[tabgroup1]=1;
					$sql="SELECT cuentapatrimonio FROM almparametros";
					$res = mysql_query($sql,$linkbd);
					$row = mysql_fetch_row($res);
					$_POST[cuenta] = $row[0];
					$_POST[ncuenta] = buscacuenta($row[0]);
 				}
				switch($_POST[tabgroup1])
                {
                    case 1:	$check1='checked';break;
                    case 2:	$check2='checked';break;
                    case 3:	$check3='checked';
                }
				if($_POST[bc]=='1'){
					$_POST[ncuenta] = buscacuenta($_POST[cuenta]);
					$_POST[bc] = '0';
				}
			?>
			<div class="tabsic" style="height:68%; width:99.6%;"> 
			<div class="tab"> 
       		<input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
	  		<label for="tab-1">Almacen</label>
			<div class="content" width="100%" style="overflow-y:hidden;">
  			<table width="160%" class="inicio" align="center" >
    			<tr>
      				<td class="titulos" colspan="8">Parametrizacion</td>
                    <td class="cerrar" style="width:7%" onClick="location.href='teso-principal.php'">Cerrar</td>
    			</tr>
 
 
				<tr>                	
					<td style="width:15%;" class="saludo1">Cuenta Patrimonio:</td>
          			<td style="width:13%;">
                    	<input type="text" id="cuenta" name="cuenta" style="width:80%;" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="buscacta(event)" value="<?php echo $_POST[cuenta]?>" onClick="document.getElementById('cuenta').focus();document.getElementById('cuenta').select();" placeholder='cuenta contable' onKeyDown="llamarventanacta(event)"/>&nbsp;<a href="#" onClick="mypop=window.open('cuentas-ventanageneral.php?objeto=cuenta&nobjeto=ncuenta','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>
         			</td>
                    <td colspan="4">
                        <input name="ncuenta" id="ncuenta" type="text" style="width:100%;" value="<?php echo $_POST[ncuenta]?>" readonly/>
                  	</td>
               	</tr>

      		</table>
     		<input type="hidden" value="<?php echo $_POST[oculto]; ?>" name="oculto" id="oculto">
            <input type="hidden" value="0" name="bc">
			</div>
			</div>
			</div>
      		<?php
	
				$oculto=$_POST[oculto];
				if($oculto=="2")
				{
					$fecha = date('Y-m-d');
					$sql = "DELETE FROM almparametros";
					if(mysql_query($sql,$linkbd)){
						$sql = "INSERT INTO almparametros(fecha,cuentapatrimonio,cuentaorigen) VALUES ('$fecha','$_POST[cuenta]','')";
						if(mysql_query($sql,$linkbd)){
							echo"<script>
						despliegamodalm('visible','1','Se han actualizado los parametros con exito');
					</script>";
						}else{
							echo "<script>despliegamodalm('visible','2','Error al actualizar los parametros');</script>";
						}
					}else{
						echo "<script>despliegamodalm('visible','2','Error al actualizar los parametros');</script>";
					}

					
				}
			?>
		</form>
	</body>
</html>