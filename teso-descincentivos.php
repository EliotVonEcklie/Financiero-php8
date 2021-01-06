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
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: SPID - Tesoreria</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
		<script>
			function despliegamodal2(_valor)
			{
				document.getElementById("bgventanamodal2").style.visibility=_valor;
				if(_valor=="hidden"){document.getElementById('ventana2').src="";}
				else {document.getElementById('ventana2').src="cuentas-ventana01.php";}
			}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
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
					}
				}
			}
			
			function funcionmensaje(){document.location.href = "";}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":
						document.form2.oculto.value=2;
						document.form2.submit();
						break;
				}
			}
			function buscacta(e)
 			{
				if (document.form2.cuenta.value!="")
				{
 					document.form2.bc.value='1';
 					document.form2.submit();
 				}
 			}
			function validar(){document.form2.submit();}
			function guardar()
			{
				var validacion01=document.form2.nombre.value;
				var validacion02=document.form2.ingreso.value;
				var validacion03=document.form2.cuenta.value;
				var validacion04=document.form2.codigo.value;
				if (validacion01.trim()!='' && validacion02.trim()!='' && validacion03.trim()!='' && validacion04.trim()!='')
  				{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
  				else {despliegamodalm('visible','2','Falta información para guardar');}
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
			<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
			<tr><?php menu_desplegable("teso");?></tr>
			<tr>
  				<td colspan="3" class="cinta"><img src="imagenes/add.png" title="Nuevo" onClick="location.href='teso-descincentivos.php'" class="mgbt"/><img src="imagenes/guarda.png" title="Guardar" onClick="guardar()" class="mgbt"/><img src="imagenes/busca.png" title="Buscar" onClick="location.href='teso-buscadescincentivos.php'" class="mgbt"/><img src="imagenes/nv.png" title="Nueva Ventana" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"></td>
			</tr>		  
		</table>
		<?php
			$vigencia=date(Y);
			$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
			$vigencia=$vigusu;
			if(!$_POST[oculto])
			{
		 		$_POST[porcentaje1]=0;
		 		$_POST[porcentaje2]=0;
		 		$_POST[porcentaje3]=0;		
				$_POST[porcentaje4]=0; 	
				$_POST[porcentaje5]=0; 
				$_POST[porcentaje6]=0; 	  			 
		 		$_POST[valor]=0;		 
			}
		?>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
		<form name="form2" method="post" action="">
 			<?php 
				//**** busca cuenta
  				if($_POST[bc]!='')
			 	{
			  		$nresul=buscacuenta($_POST[cuenta]);			
			  		if($nresul!=''){$_POST[ncuenta]=$nresul;}
			  		else {$_POST[ncuenta]="";}
			 	}
			 ?>
    		<table class="inicio" align="center" >
      			<tr >
        			<td class="titulos" colspan="8"> Parametrizar Descuento Incentivo</td>
                    <td class="cerrar" style="width:7%" onClick="location.href='teso-principal.php'">Cerrar</td>
      			</tr>
      			<tr>
	  				<td  class="saludo1">Codigo:</td>
        			<td style="width:5%;"><input type="text" name="codigo" value="<?php echo $_POST[codigo]?>" maxlength="2" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"></td>
	        		<td  class="saludo1">Nombre:</td>
	        		<td style="width:30%;"><input name="nombre" type="text" value="<?php echo $_POST[nombre]?>" onKeyUp="return tabular(event,this)" style="width:100%;"></td>
					<td  class="saludo1">Ingreso:</td>
					<td>        
					<td>        
						<select name="ingreso" style="width:65%;" onKeyUp="return tabular(event,this)">
							<option value="">Seleccione....</option>
							<?php
								$sqlr="select * from tesoingresos where estado='S'";
								$res=mysql_query($sqlr,$linkbd);
								while ($row =mysql_fetch_row($res)) 
				    			{
					 				if($row[0]==$_POST[ingreso]){echo "<option value='$row[0]' SELECTED>$row[0] - $row[1]</option>";}
									else {echo "<option value='$row[0]'>$row[0] - $row[1]</option>";}
								}	 	
							?>
   						</select>
    				</td>   
    			</tr> 
    		</table>
			<table class="inicio">
	   			<tr><td colspan="5" class="titulos">Cuenta Contable </td></tr>                  
				<tr>
					<td  class="saludo1">Cuenta Contable: </td>
          			<td colspan="2"  valign="middle" style="width:15%;"><input type="text" id="cuenta" name="cuenta"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="buscacta(event)" value="<?php echo $_POST[cuenta]?>" onClick="document.getElementById('cuenta').focus();document.getElementById('cuenta').select();">&nbsp;<img class="icobut" src="imagenes/find02.png"  title="Listado de Cuentas" onClick="despliegamodal2('visible');"></td>
                    <input type="hidden" value="0" name="bc">
          			<td width="76%" ><input name="ncuenta" type="text" value="<?php echo $_POST[ncuenta]?>" readonly></td>
	    		</tr>
			</table>
			<table class="inicio">
				<tr><td class="titulos" colspan="4">Fechas y Valores</td></tr>
				<tr>
					<td style="width:9%;" class="saludo1">Fecha Limite 1:</td>
					<td style="width:14%;"><input name="fecha1" type="text" id="fc_1198971545" title="DD/MM/YYYY" value="<?php echo $_POST[fecha1]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" style="width:80%;"/>&nbsp;<img src="imagenes/calendario04.png" onClick="displayCalendarFor('fc_1198971545');" class="icobut" title="Calendario"/></td>
					<td style="width:6%;" class="saludo1">Porcentaje:</td>
					<td><input id="porcentaje1" name="porcentaje1" type="text" value="<?php echo $_POST[porcentaje1]?>" onKeyUp="return tabular(event,this)" style="width:5%;" onKeyPress="javascript:return solonumeros(event)"/>%</td>
				</tr>
				<tr>
					<td style="width:9%;" class="saludo1">Fecha Limite 2:</td>
					<td style="width:14%;"><input name="fecha2" type="text" id="fc_1198971546" title="DD/MM/YYYY"  value="<?php echo $_POST[fecha2]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" style="width:80%;"/>&nbsp;<img src="imagenes/calendario04.png" onClick="displayCalendarFor('fc_1198971546');" class="icobut" title="Calendario"/></td>
					<td style="width:6%;" class="saludo1">Porcentaje:</td>
					<td><input id="porcentaje2" name="porcentaje2" type="text" value="<?php echo $_POST[porcentaje2]?>" onKeyUp="return tabular(event,this)" style="width:5%;" onKeyPress="javascript:return solonumeros(event)"/>%</td>
				</tr>
				<tr>
		  			<td style="width:9%;" class="saludo1">Fecha Limite 3:</td>
		  			<td style="width:14%;"><input name="fecha3" type="text" id="fc_1198971547" title="DD/MM/YYYY"  value="<?php echo $_POST[fecha3]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" style="width:80%;"/>&nbsp;<img src="imagenes/calendario04.png" onClick="displayCalendarFor('fc_1198971547');" class="icobut" title="Calendario"/></td>
		  			<td style="width:6%;" class="saludo1">Porcentaje:</td>
		  			<td><input id="porcentaje3" name="porcentaje3" type="text" value="<?php echo $_POST[porcentaje3]?>" onKeyUp="return tabular(event,this)" style="width:5%;" onKeyPress="javascript:return solonumeros(event)"/>%</td>
				</tr>
                <tr>
		  			<td style="width:9%;" class="saludo1">Fecha Limite 4:</td>
		  			<td style="width:14%;"><input type="text" name="fecha4" id="fc_1198971548" title="DD/MM/YYYY"  value="<?php echo $_POST[fecha4]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" style="width:80%;"/>&nbsp;<img src="imagenes/calendario04.png" onClick="displayCalendarFor('fc_1198971548');" class="icobut" title="Calendario"/></td>
		  			<td style="width:6%;" class="saludo1">Porcentaje:</td>
		  			<td><input type="text" id="porcentaje4" name="porcentaje4" value="<?php echo $_POST[porcentaje4]?>" onKeyUp="return tabular(event,this)" style="width:5%;" onKeyPress="javascript:return solonumeros(event)"/>%</td>
				</tr>
                <tr>
		  			<td style="width:9%;" class="saludo1">Fecha Limite 5:</td>
		  			<td style="width:14%;"><input type="text" name="fecha5" id="fc_1198971549" title="DD/MM/YYYY"  value="<?php echo $_POST[fecha5]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" style="width:80%;"/>&nbsp;<img src="imagenes/calendario04.png" onClick="displayCalendarFor('fc_1198971549');" class="icobut" title="Calendario"/></td>
		  			<td style="width:6%;" class="saludo1">Porcentaje:</td>
		  			<td><input type="text" id="porcentaje5" name="porcentaje5" value="<?php echo $_POST[porcentaje5]?>" onKeyUp="return tabular(event,this)" style="width:5%;" onKeyPress="javascript:return solonumeros(event)"/>%</td>
				</tr>
                <tr>
		  			<td style="width:9%;" class="saludo1">Fecha Limite 6:</td>
		  			<td style="width:14%;"><input type="text" name="fecha6" id="fc_1198971550" title="DD/MM/YYYY"  value="<?php echo $_POST[fecha6]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" style="width:80%;"/>&nbsp;<img src="imagenes/calendario04.png" onClick="displayCalendarFor('fc_1198971550');" class="icobut" title="Calendario"/></td>
		  			<td style="width:6%;" class="saludo1">Porcentaje:</td>
		  			<td><input type="text" id="porcentaje6" name="porcentaje6" value="<?php echo $_POST[porcentaje6]?>" onKeyUp="return tabular(event,this)" style="width:5%;" onKeyPress="javascript:return solonumeros(event)"/>%</td>
				</tr>
                
				<input name="oculto" type="hidden" value="1">
    		</table>
  			<?php
				if($_POST[oculto]=='2')
				{
					$sqlr="select *from tesodescuentoincentivo where tesodescuentoincentivo.vigencia=$vigusu";
					$resp=(mysql_query($sqlr,$linkbd));
					$ntr = mysql_num_rows($resp);
					if ($ntr>0){echo"<script>despliegamodalm('visible','2','Ya existe descuento incentivo para esta vigencia');</script>";}	
					else	
 					{
						if ($_POST[nombre]!="" and $_POST[codigo]!="" and $_POST[ingreso] )
		 				{
 							$a=date(Y);
							$fecini=$a."-01-01";
							ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha1],$fecha);
							$fechaf1=$fecha[3]."-".$fecha[2]."-".$fecha[1]; 
							if($_POST[fecha2]!='')
							{
								ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
								$fechaf2=$fecha[3]."-".$fecha[2]."-".$fecha[1]; 
								$fechai2=$fechaf1;
							}
							else{$fechaf2='0000-00-00';$fechai2='0000-00-00';}
							if($_POST[fecha3]!='')
							{
								ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha3],$fecha);
								$fechaf3=$fecha[3]."-".$fecha[2]."-".$fecha[1]; 
								$fechai3=$fechaf2;
							}
							else{$fechaf3='0000-00-00';$fechai3='0000-00-00';}
							if($_POST[fecha4]!='')
							{
								ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha4],$fecha);
								$fechaf4=$fecha[3]."-".$fecha[2]."-".$fecha[1]; 
								$fechai4=$fechaf3;
							}
							else{$fechaf4='0000-00-00';$fechai4='0000-00-00';}
							if($_POST[fecha5]!='')
							{
								ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha5],$fecha);
								$fechaf5=$fecha[3]."-".$fecha[2]."-".$fecha[1];
								$fechai5=$fechaf4;
							}
							else{$fechaf5='0000-00-00';$fechai5='0000-00-00';}
							if($_POST[fecha6]!='')
							{
								ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha6],$fecha);
								$fechaf6=$fecha[3]."-".$fecha[2]."-".$fecha[1];
								$fechai6=$fechaf5;
							}
							else{$fechaf6='0000-00-00';$fechai6='0000-00-00';}
							$nr="1";
 							$sqlr="INSERT INTO tesodescuentoincentivo (ingreso,valordesc1,valordesc2,valordesc3,estado,vigencia,fechaini1,fechaini2, fechaini3,fechafin1,fechafin2,fechafin3,cuenta,codigo,nombre,valordesc4,valordesc5,valordesc6,fechaini4,fechafin4,fechaini5,fechafin5,fechaini6, fechafin6)VALUES ('$_POST[ingreso]','$_POST[porcentaje1]','$_POST[porcentaje2]','$_POST[porcentaje3]','S','$vigusu','$fecini','$fechaf1','$fechai2', '$fechaf2','$fechai3','$fechaf3','$_POST[cuenta]','$_POST[codigo]','$_POST[nombre]','$_POST[porcentaje4]','$_POST[porcentaje5]', '$_POST[porcentaje6]','$fechai4','$fechaf4','$fechai5','$fechaf5','$fechai6','$fechaf6')";
  							if (!mysql_query($sqlr,$linkbd))
							{
	 							echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
	 							echo "Ocurrió el siguiente problema:<br>";
  	 							echo "<pre>";
     							echo "</pre></center></td></tr></table>";
							}
  							else
  							{echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado con Exito</center></td></tr></table>";}
 						}
						else {echo "<script>despliegamodalm('visible','2','Error Información Incompleta');</script>";}
					}
				}
			?> 
		</form>
 		<div id="bgventanamodal2">
			<div id="ventanamodal2">
				<IFRAME  src="" name="buster" marginWidth=0 marginHeight=0 frameBorder=0 id="ventana2" frameSpacing=0 style="left:500px; width:900px; height:500px; top:200;"></IFRAME>
        	</div>
		</div>
	</body>
</html>