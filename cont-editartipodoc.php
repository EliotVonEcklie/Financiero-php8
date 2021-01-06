<!--V 1.0 24/02/2015-->
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
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Spid - Contabilidad</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
		<script>
        	function guardar()
			{
				var validacion01=document.getElementById('nombre').value;
				if(validacion01.trim()!=''){despliegamodalm('visible','4','Esta Seguro de Modificar','1');}
				else {despliegamodalm('visible','2','Falta informacion para Crear el Comprobante');}
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
			function funcionmensaje(){}
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
        </script>
		<script>
			function iratras(scrtop, numpag, limreg){
				var idcta=document.getElementById('idcomp').value;
				location.href="cont-buscatipodoc.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg;
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
            <tr><script>barra_imagenes("cont");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("cont");?></tr>
			<tr>
  				<td colspan="3" class="cinta">
					<a href="cont-tipodoc.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a>
					<a href="#" onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a>
					<a href="cont-buscatipodoc.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
					<a href="#" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva ventana"></a>
					<a href="" onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
					<a href="#" onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>)" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
				</td>
      		</tr>
  		</table>
		<div id="bgventanamodalm" class="bgventanamodalm">
            <div id="ventanamodalm" class="ventanamodalm">
                <IFRAME src="" name="ventanam" marginWidth=0 marginHeight=0 frameBorder=0 id="ventanam" frameSpacing=0 style=" width:700px; height:130px; top:200; overflow:hidden;"> 
                </IFRAME>
            </div>
        </div>
		<?php
			if(!$_POST[oculto]=="2")
			{
				$sqlr="Select *from tipo_comprobante where id_tipo=$_GET[idtipocom]";
				$res=mysql_query($sqlr,$linkbd);
				while($row=mysql_fetch_row($res))
			 	{
			  		$_POST[idcomp]=$row[0];
			   		$_POST[nombre]=$row[1];
			  	 	$_POST[estado]=$row[2];
			   		$_POST[codigo]=$row[3];
			   		$_POST[fijo]=$row[4];
					$_POST[categoria]=$row[5];
			  	}
			}
		?>
 		<form name="form2" method="post" action="cont-editartipodoc.php">
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
								if($_POST[categoria]==$row[0]){
									echo "<option value='$row[0]' selected>$row[1]</option>";
								}else{
									echo "<option value='$row[0]'>$row[1]</option>";
								}
								
							}
							?>
							
                        </select>   
                    </td>
                </tr> 				
    		</table>
            <input name="oculto" id="oculto" type="hidden" value="1">  
            <input name="idcomp" id="idcomp" type="hidden" value="<?php echo $_POST[idcomp]?>" >
            <?php
                if($_POST[oculto])
                {
                    $sqlr="update tipo_comprobante set nombre='$_POST[nombre]',estado='$_POST[estado]',codigo='$_POST[codigo]',id_cat=$_POST[categoria] where id_tipo=$_POST[idcomp]";
                    if (!mysql_query($sqlr,$linkbd)){echo "<script>despliegamodalm('visible','2','No se pudo ejecutar la petición');</script>";}
                    else {echo "<script>despliegamodalm('visible','3','Se ha actualizado con Exito');</script>";}
                 }
            ?> 
		</form>
	</body>
</html>