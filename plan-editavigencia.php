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
		<title>:: SPID - Administracion</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
		<link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type='text/javascript' src='css/programas.js'></script>
		<script>
			function guardar(idfac)
			{
				if (document.form2.vigenciai.value!='' && document.form2.vigenciai.value!='')
			  	{
					if (confirm("Esta Seguro de Guardar")){document.form2.oculto.value="2";document.form2.submit();}
			  	}
			  	else {alert("No hay vigencia nueva seleccionada");}
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
			function funcionmensaje(){document.location.href = "plan-vigencia.php";}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.form2.oculto.value="2";document.form2.submit();break;
				}
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
    		<tr><script>barra_imagenes("plan");</script><?php cuadro_titulos();?></tr>	 
   			<tr><?php menu_desplegable("plan");?></tr>
			<tr>
  				<td colspan="3" class="cinta"><a href="plan-vigencia.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a><a href="#"  onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a><a class="mgbt"><img src="imagenes/buscad.png" /></a><a href="#" onClick="mypop=window.open('plan-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
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
                if(!$_POST[oculto])
                {
                    $sqlr="select *from DOMINIOS where NOMBRE_DOMINIO='VIGENCIA_PD' and tipo='S'";
                    $res=mysql_query($sqlr,$linkbd);
                    while($r=mysql_fetch_row($res))
                    {
                        $_POST[vigenciaacti]=$r[0];
                        $_POST[vigenciaactf]=$r[1];
                    }
                }
            ?>
  			<table class="inicio" align="center" >
    			<tr>
      				<td class="titulos" colspan="4">Crear Vigencia  PD</td>
                    <td class="cerrar" style="width:7%;" ><a href="plan-principal.php">&nbsp;Cerrar</a></td>
    			</tr>
      			<tr>
      				<td class="saludo1" style="width:5cm;">Vigencia Activa:</td>
      				<td colspan="3"><input name="vigenciaacti" type="text" id="vigenciaacti" size="5" value="<?php echo $_POST[vigenciaacti]?>" readonly>&nbsp;-&nbsp;<input name="vigenciaactf" type="text" id="vigenciaactf" size="5" value="<?php echo $_POST[vigenciaactf]?>" readonly></td>
    			</tr>
    			<tr>
      				<td class="saludo1" style="width:5cm;">Nueva Vigencia Inicial:</td>
      				<td style="width:15%;"><input name="vigenciai" type="text" id="vigenciai" size="5" value="<?php echo $_POST[vigenciai]?>" onKeyPress="javascript:return solonumeros(event)"></td>
      				<td  class="saludo1" style="width:5cm;">Nueva Vigencia Final:</td>
      				<td><input name="vigenciaf" type="text" id="vigenciaf" size="5" value="<?php echo $_POST[vigenciaf]?>" onKeyPress="javascript:return solonumeros(event)"></td>
    			</tr>   
 			</table>
  			<input type="hidden" name="oculto" id="oculto" value="1">
      		<?php
				if($_POST[oculto]==2)
				{
					$sqlr="select count(*) from dominios where nombre_dominio='VIGENCIA_PD' and  ('$_POST[vigenciai]' between valor_inicial and valor_final or '$_POST[vigenciaf]' between valor_inicial and valor_final)";
					$resp=mysql_query($sqlr,$linkbd);
					$nreg=mysql_fetch_row($resp);
					if($nreg[0]<=0)
					{
						$sqlr="update DOMINIOS set tipo='N' where NOMBRE_DOMINIO='VIGENCIA_PD' and tipo='S'";
						mysql_query($sqlr,$linkbd);
						$sqlr="insert into DOMINIOS (valor_inicial,valor_final,descripcion_valor, nombre_dominio,tipo,descripcion_dominio) values ('$_POST[vigenciai]','$_POST[vigenciaf]','VIGENCIAS','VIGENCIA_PD','S','VIGENCIAS PLAN DE DESARROLLO')";
						if(!mysql_query($sqlr,$linkbd))
  							{echo"<script>despliegamodalm('visible','2','Error no se pudo actualizar $sqlr');</script>";}
  						else
  							{echo"<script>despliegamodalm('visible','1','Se ha Actualizado con Exito: Vigencia $_POST[vigenciai] -  $_POST[vigenciaf] ');</script>";}
					}
					else
						{echo"<script>despliegamodalm('visible','2','Error, ya existe una vigencia con estos valores');</script>";}

				}
			?>
		</form>
	</body>
</html>