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
		<title>:: Spid - Contabilidad</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
        <script type='text/javascript' src='JQuery/jquery-2.1.4.min.js'></script>
        <script type="text/javascript" src="JQuery/alphanum/jquery.alphanum.js"></script>
		<script>
        	function guardar()
			{
				var validacion01=document.getElementById('codigo').value;
				var validacion02=document.getElementById('nombre').value;
				if((validacion01.trim()!='')&&(validacion02.trim()!='')&&(document.getElementById('tipo').value!=""))
					{despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
				else {despliegamodalm('visible','2','Falta informacion para Crear el Centro Costo');}
	 		}
			function despliegamodalm(_valor,_tip,mensa,pregunta)
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
					}
				}
			}
			function funcionmensaje(){document.location.href = "cont-centrocostos.php";}
			function respuestaconsulta(pregunta)
			{
				switch(pregunta)
				{
					case "1":
						document.form2.oculto.value="2";
						document.form2.submit();
						break;
				}
			}
			function valcodigo(){document.form2.oculto.value="8";document.form2.submit();}
        </script>
	</head>
	<body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
		<table>
    		<tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
    		<tr><?php menu_desplegable("cont");?></tr>
			<tr>
  				<td colspan="3" class="cinta">
					<a onClick="location.href='cont-centrocostos.php'" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
					<a onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a>
					<a onClick="location.href='cont-buscacentrocosto.php'" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
					<a href="" onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a onClick="<?php echo paginasnuevas("cont");?>" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
				</td>
           	</tr>
		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
  		<form name="form2" method="post" action="cont-centrocostos.php">
            <table class="inicio" align="center">
                <tr>
                    <td class="titulos" colspan="6">.: Agregar Centro Costos</td>
                    <td class="cerrar" style="width:7%;" ><a onClick="location.href='cont-principal.php'">&nbsp;Cerrar</a></td>
                </tr>
                <tr>
                    <td class="saludo1" style="width:8%;">.: Codigo:</td>
                    <td style="width:13%;"><input type="text" name="codigo" id="codigo" value="<?php echo $_POST[codigo]?>" style="width:98%;" onKeyUp="return tabular(event,this)" onBlur="valcodigo();"/></td>
                    <td class="saludo1" style="width:15%;">.: Nombre Centro Costo:</td>
                    <td><input type="text" name="nombre" id="nombre" value="<?php echo $_POST[nombre]?>" style="width:80%;" onKeyUp="return tabular(event,this)"/></td>
                </tr>
                <tr>
                    <td class="saludo1" style="width:8%;">.: Tipo:</td>
                    <td>
                        <select name="tipo" id="tipo" style="width:98%;">
                            <option value="" >Seleccione...</option>
                            <option value="S" <?php if ($_POST[tipo]=="S"){echo "selected";}?>>Entidad</option>
                            <option value="N" <?php if ($_POST[tipo]=="N"){echo "selected";}?>>Externo</option>
                        </select> 
                    </td>
                    <td class="saludo1">.: Activo:</td>
                    <td>
                        <select name="estado" id="estado" style="width:8%;">
                            <option value="S" <?php if ($_POST[estado]=="S"){echo "selected";}?>>SI</option>
                            <option value="N" <?php if ($_POST[estado]=="N"){echo "selected";}?>>NO</option>
                        </select>   
                 </td>
                </tr>  
            </table>
            <input type="hidden" name="oculto" id="oculto" value="1"/>
            <input type="hidden" name="valfocus" id="valfocus" value="1"/> 
  			<?php
				if($_POST[oculto]=="8")
				{
					$sqlr="SELECT * FROM centrocosto WHERE id_cc='$_POST[codigo]'";
					$res=mysql_query($sqlr,$linkbd);
					$ntr = mysql_num_rows($res);
					if($ntr>0)
						echo"
							<script>
								despliegamodalm('visible','2','Este codigo ya existe');
								document.getElementById('valfocus').value='2';
							</script>";
				}
				if($_POST[oculto]=="2")
				{
					$sqlr="INSERT INTO centrocosto (id_cc,nombre,estado,entidad)VALUES ('$_POST[codigo]','$_POST[nombre]','$_POST[estado]', '$_POST[tipo]')";
					if (!mysql_query($sqlr,$linkbd)){echo "<script>despliegamodalm('visible','2','No se pudo ejecutar la petici�n');</script>";}
					else {echo "<script>despliegamodalm('visible','1','Se ha almacenado con Exito');</script>";}
				}
			?>
        	<script type="text/javascript">$('#nombre').alphanum({allow: ''});</script>
       		<script type="text/javascript">$('#codigo').numeric({allowThouSep: false,allowDecSep: false,allowMinus: false,maxDigits: 2});</script> 
		</form>
	</body>
</html>