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
		<title>:: Spid - Gestion Humana</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<script>
			function guardar()
			{
				var validacion01=document.getElementById('nombre').value;
				if (document.getElementById('codigo').value !='' && validacion01.trim()!='' && document.getElementById('dias').value !='')
 				{despliegamodalm('visible','4','Esta Seguro de Guardar','1')}
 				else{despliegamodalm('visible','2','Faltan datos para completar el registro');}
			}
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
			function funcionmensaje(){document.location.href = "hum-periodos.php";}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":	document.getElementById('oculto').value="2";
								document.form2.submit();break;
				}
			}
		</script>
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
    		<tr><script>barra_imagenes("hum");</script><?php cuadro_titulos();?></tr>	 
    		<tr><?php menu_desplegable("hum");?></tr>
			<tr>
  				<td colspan="3" class="cinta"><a href="hum-periodos.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a><a href="#"  onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a><a href="hum-buscaperiodos.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a><a href="#" onClick="mypop=window.open('hum-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"/></a></td>
			</tr>		  
		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
 		<form name="form2" method="post" action="hum-periodos.php">
 			<?php
				if ($_POST[oculto]=="")
				{
					$sqlr="select max(id_periodo) from humperiodos  ";
					$res=mysql_query($sqlr,$linkbd);
					$maximo=0;
					while($r=mysql_fetch_row($res)){$maximo=$r[0];}
					$maximo+=1;
					$_POST[codigo]=$maximo;
				}
			?>
    		<table class="inicio" align="center" >
      			<tr>
        			<td class="titulos" colspan="8">.: Agregar Periodo</td>
                    <td class="cerrar" style="width:7%"><a href="hum-principal.php">&nbsp;Cerrar</a></td>
     		 	</tr>
      			<tr>
	  				<td class="saludo1" style="width:7%">.: Codigo:</td>
        			<td style="width:6%"><input type="text" name="codigo" id="codigo" value="<?php echo $_POST[codigo]?>" style="width:98%" readonly></td>
        			<td class="saludo1" style="width:12%">.: Nombre Periodo:</td>
        			<td style="width:30%"><input type="text" name="nombre" id="nombre" value="<?php echo $_POST[nombre]?>" style="width:99%" onKeyUp="return tabular(event,this)" ></td>
        			<td class="saludo1" style="width:7%">.: D&iacute;as:</td>
        			<td style="width:6%"><input type="text" name="dias" id="dias" value="<?php echo $_POST[dias]?>" onKeyUp="return tabular(event,this)" onKeyPress="javascript:return solonumeros(event)" style="width:98%"></td>
        			<td class="saludo1" style="width:7%">.: Activo:</td>
        			<td>
                    	<select name="estado" id="estado" >
          					<option value="S" >SI</option>
          					<option value="N">NO</option>
        				</select>   
                	</td>
       			</tr>  
    		</table>
            <input type="hidden" name="oculto" id="oculto" value="1"> 
  			<?php
				if($_POST[oculto]=="2")
				{
					$nr="1";
					$sqlr="INSERT INTO humperiodos (id_periodo,nombre,dias,vigencia,estado)VALUES ($_POST[codigo],'".utf8_decode($_POST[nombre])."',$_POST[dias],'".$_SESSION[vigencia]."','$_POST[estado]')";
					if (!mysql_query($sqlr,$linkbd))
						{echo "<script>despliegamodalm('visible','2','Manejador de Errores de la Clase BD humperiodos');</script>";}
					else {echo "<script>despliegamodalm('visible','1','Se ha almacenado con Exito');</script>";}
				}
			?> 
		</form>
	</body>
</html>