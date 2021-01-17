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
		<title>:: SieS - Contabilidad</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<script>
			function guardar()
			{
				var validacion01=document.getElementById('codigo').value;
				var validacion02=document.getElementById('nombre').value;
				if((validacion01.trim()!='')&&(validacion02.trim()!='')){despliegamodalm('visible','4','Esta Seguro de Guardar','1');}
				else {despliegamodalm('visible','2','Falta informacion para Crear el Comprobante');}
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
			function funcionmensaje(){document.location.href = "cont-tipodoc.php";}
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
		<?php titlepag();?>
	</head>
	<body>
		<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
		<span id="todastablas2"></span>
		<table>
    		<tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
    		<tr><?php menu_desplegable("cont");?></tr>
			<tr>
  				<td colspan="4" class="cinta">
					<a href="cont-tipodoc.php" class="mgbt"><img src="imagenes/add.png"  title="Nuevo" /></a>
					<a href="#"  onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a>
					<a href="cont-buscatipodoc.php" class="mgbt"> <img src="imagenes/busca.png" title="Buscar" /> </a>
					<a href="" onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" title="nueva ventana"></a>
				</td>
         	</tr>
		</table>
        <div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
 		<form name="form2" method="post" action="cont-tipodoc.php">
    		<table class="inicio" align="center" >
                <tr>
                    <td class="titulos" colspan="6" >.: Agregar Tipo Comprobante</td>
                    <td class="cerrar"><a href="cont-principal.php">Cerrar</a></td>
                </tr>
                <tr>
                    <td class="saludo1" style="width:8%;">.: Codigo:</td>
                    <td style="width:10%;"><input type="text" name="codigo" id="codigo" value="<?php echo $_POST[codigo]?>" style="width:99%;" onBlur="valcodigo();"></td>
                    <td class="saludo1" style="width:17%;">.: Nombre Comprobante:</td>
                    <td ><input type="text" name="nombre" id="nombre" value="<?php echo $_POST[nombre]?>" style="width:99.5%"></td>
                    <td class="saludo1" style="width:8%;">.: Activo:</td>
                    <td style="width:15%;">
                        <select name="estado" id="estado" style="width:100%;">
                            <option value="S" <?php if ($_POST[estado]=='S'){  echo "SELECTED";}?>>SI</option>
                            <option value="N" <?php if ($_POST[estado]=='N'){  echo "SELECTED";}?>>NO</option>
                        </select>   
                    </td>
                </tr> 
				<tr>
                   <td class="saludo1" colspan="4" style="background-color: white"></td>
                    <td class="saludo1" style="width:8%;" >.: Categoria:</td>
                    <td style="width:15%;">
                        <select name="categoria" id="categoria" style="width:100%;">
						<option value="">.: Seleccione la categoria</option> 
                            <?php
							$sql="select * from categoria_compro WHERE estado='S' ORDER BY id";
							$result=mysql_query($sql,$linkbd);
							while($row = mysql_fetch_array($result)){
								echo "<option value='$row[0]' >$row[1]</option>";
							}
							?>
							
                        </select>   
                    </td>
                </tr> 				
    		</table>
            <input type="hidden" name="oculto"  value="1"> 
            <input type="hidden" name="valfocus" id="valfocus" value="1"/> 
            <?php
               	if($_POST[oculto]=="8")
				{
					$sqlr="SELECT * FROM tipo_comprobante WHERE codigo='$_POST[codigo]'";
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
                    if ($_POST[nombre]!="")
                    {
						$mxa=selconsecutivo('tipo_comprobante','id_tipo');
                        $sqlr="INSERT INTO tipo_comprobante (id_tipo,nombre,estado,codigo,fijo,id_cat) VALUES ('mxa','$_POST[nombre]','$_POST[estado]', '$_POST[codigo]','N','$_POST[categoria]')";
                        if (!mysql_query($sqlr,$linkbd)){echo "<script>despliegamodalm('visible','2','No se pudo ejecutar la petición');</script>";}
                        else {echo "<script>despliegamodalm('visible','1','Se ha almacenado con Exito');</script>";}
                    }
                }
            ?> 
		</form>
	</body>
</html>