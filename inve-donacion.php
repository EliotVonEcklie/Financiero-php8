<?php //V 1000 12/12/16 ?> 
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
		<title>:: Spid - Almacen</title>
       <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
        <script src="JQuery/jquery-2.1.4.min.js"></script>
		 <script type="text/javascript" src="css/calendario.js"></script>
        <script src="JQuery/autoNumeric-master/autoNumeric-min.js"></script>
		<script>
			function despliegamodal2(_valor,_pag)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else if(_pag=="1"){document.getElementById('ventana2').src="inve-greservas-articulos.php";}
				else if(_pag=="2"){document.getElementById('ventana2').src="tercerosalm-ventana.php";}
			}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
			{
				document.getElementById("bgventanamodalm").style.visibility=_valor;
				if(_valor=="hidden")
				{
					document.getElementById('ventanam').src="";
					switch(document.getElementById('valfocus').value)
					{
						case "1":	document.getElementById('articulo').focus();
									document.getElementById('articulo').select();
									break;
						case "2":	document.getElementById('cuenta').focus();
									document.getElementById('cuenta').select();
									break;
					}
					document.getElementById('valfocus').value='0';
				}
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
					case "2":	document.getElementById('oculto').value="3";
								document.form2.submit();break;
				}
			}
			function funcionmensaje(){document.location.href = "inve-donacion.php";}
			function buscater(e)
 			{
				if (document.form2.tercero.value!="")
				{
					document.form2.bt.value='1';
 					document.form2.submit();
 				}
 			}
			function guardar()
			{
				valg01=document.form2.codigo.value;
				valg02=document.form2.fecha.value;
				valg03=document.getElementById('vautorizado').value;
				
				if (valg01!='' && valg02!='' && valg03!=0)
				{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
 				else{despliegamodalm('visible','2','Faltan datos para completar el registro');}
			}
			function guiabuscar(_opc)
			{
				if(_opc==1){if(document.getElementById('articulo').value!=""){document.getElementById('busqueda').value='1';}}
				else{if(document.getElementById('cuenta').value!=""){document.getElementById('busqueda').value='2';}}
				document.form2.submit();
			}

			function eliminar(variable)
			{
				document.form2.elimina.value=variable;
				despliegamodalm('visible','4','Esta Seguro de Eliminar','2');
			}
			function validar(_opc){
				document.form2.submit();
			}
			jQuery(function($){ $('#vautorizadoh').autoNumeric('init',{mDec:'0'});});
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
  				<td colspan="3" class="cinta"><a onClick="location.href='inve-donacion.php'" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a><a onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a><a onClick="location.href='inve-donacionbuscar.php'" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a><a onClick="<?php echo paginasnuevas("inve");?>" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
			</tr>
         </table>
         <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>		  
 		<form name="form2" method="post" action="inve-donacion.php">
        	<input type="hidden" name="valfocus" id="valfocus" value="0"/>
        	<?php
				if ($_POST[oculto]=="")
				{ 
					$sqlr="SELECT MAX(codigo) FROM almdonaciones";
					$resp = mysql_query($sqlr,$linkbd);
					$row =mysql_fetch_row($resp);
					
					$_POST[fecha]=date("Y-m-d");
					$_POST[conarticulos]=0;
					$_POST[codigo]=$row[0]+1;
				}
				
				if($_POST[bt]=='1')//***** busca tercero
			 	{
			  		$nresul=buscatercero($_POST[tercero]);
			 		if($nresul!='')
			   		{
			  			$_POST[ntercero]=$nresul;			 
			  		}
					else{ $_POST[ntercero]="";}
			 	}
				if(!isset($_POST[vautorizadoh]))
					$_POST[vautorizadoh] = 0;
			?>
    		<table class="inicio" align="center" >
    			<tr >
        			<td class="titulos" colspan="6">.: Gesti&oacute;n de Donaciones </td>
	        		<td width="7%" class="cerrar" ><a href="inve-principal.php">Cerrar</a></td>
    			</tr>
      			<tr>
					<td class="saludo1" width="7%">.: Consecutivo:</td>
          			<td valign="middle"  width="8%">
            			<input type="text" id="codigo" name="codigo"  style="width:100%; text-align:center" value="<?php echo $_POST[codigo] ?>" readonly>
         			</td>
          			<td class="saludo1" style="width:10%;"  >.: Fecha Registro:</td>
          			<td style="width:9%"><input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)" maxlength="10" style="width: 85%">&nbsp;<img src="imagenes/calendario04.png" style="width:20px; cursor:pointer;" title="Calendario"  onClick="displayCalendarFor('fc_1198971545');" class="icobut"/><input type="hidden" name="chacuerdo" value="1"></td>
		 			<td class="saludo1" width="8%" >.: Descripci&oacute;n:</td>
          			<td valign="middle"  width="25%" ><input type="text" id="descripcion" name="descripcion" style="width:100%;" onKeyUp="return tabular(event,this)" value="<?php echo $_POST[descripcion]?>"/></td>
	   				<td width="7%">
						
					</td>
       			</tr>
				<tr>
					<td class="saludo1">.: Donante:</td>
					<td valign="middle"  >
						<input type="hidden" name="npbodega" id="npbodega" value="<?php echo $_POST[npbodega]; ?>">
						<input type="hidden" name="ccaux" id="ccaux" value="<?php echo $_POST[ccaux]; ?>">
						<input type="hidden" value="0" name="bt">
            			<input type="text" id="tercero" name="tercero"  style="width:80%; text-align:center" value="<?php echo $_POST[tercero] ?>" onKeyUp="return tabular(event,this)" onBlur="buscater(event)">
						<img src="imagenes/find02.png" onClick="despliegamodal2('visible','2'); " class="icobut" title="Lista de Terceros"/>
         			</td>
					<td valign="middle" colspan="2">
            			<input type="text" id="ntercero" name="ntercero"  style="width:100%; text-align:center" value="<?php echo $_POST[ntercero] ?>" readonly>
         			</td>
					<td class="saludo1">.: Valor autorizado:</td>
					<td valign="middle">
            			<input type="hidden" name="vautorizado" id="vautorizado" value="<?php echo $_POST[vautorizado]?>"/>
                        <input type="text" name="vautorizadoh" id="vautorizadoh" value="<?php echo $_POST[vautorizadoh]?>" style="width:100%;text-align:left;" data-a-dec=',' data-a-sep='.' data-v-min='0' onKeyUp="sinpuntitos('vautorizado','vautorizadoh');"/>
         			</td>
				</tr>

  			</table>
    		<input type="hidden" name="oculto" id="oculto" value="1"> 
            <input type="hidden" name="agregadet" id="agregadet" value="0" >
            <input type="hidden" name="busqueda" id="busqueda" value=""> 
            <input type='hidden' name='elimina' id='elimina'>
			  <?php
		
				if($_POST[oculto]=="2")
				{
					$sqlr="SELECT  pl.codcargo, pl.dependencia FROM terceros t, planestructura_terceros pt, planaccargos pl WHERE pt.estado='S' AND pt.cedulanit = t.cedulanit AND pl.codcargo = pt.codcargo and t.cedulanit='$_SESSION[cedulausu]'";
					$resp = mysql_query($sqlr,$linkbd);
					$row =mysql_fetch_row($resp);
					$cargo=$row[0];
					$dependencia=$row[1];

 					$sqlr="INSERT INTO almdonaciones (codigo,fecha,solicitante,descripcion,tercero,nombretercero,estado,valorautorizado) VALUES ('$_POST[codigo]','$_POST[fecha]', '$_SESSION[cedulausu]','$_POST[descripcion]','$_POST[tercero]','$_POST[ntercero]','S','$_POST[vautorizado]')";
					if (!mysql_query($sqlr,$linkbd)){echo"<script>despliegamodalm('visible','2','Error al almacenar');</script>";}	
					else 
					{
						if ($cont!=0){echo"<script>despliegamodalm('visible','2','Error al almacenar');</script>";}
						else {echo"<script>despliegamodalm('visible','1','Donacion N° $_POST[codigo] solicitada con Exito');</script>";}
					}
				}
			?>
            <div id="bgventanamodal2">
                <div id="ventanamodal2">
                    <IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"> 
                    </IFRAME>
                </div>
       	 	</div>
            <input type="hidden" name="conarticulos" id="conarticulos" value="<?php echo $_POST[conarticulos];?>"> 
 		</form>
	</body>
</html>