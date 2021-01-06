<?php //V 1000 12/12/16 ?> 
<!--V 1.0 24/02/2015-->
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
		<title>:: Spid - Presupuesto</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
<script>
function guardar()
{
	if (document.form2.nombre.value!='')
  		{if (confirm("Esta Seguro de Guardar")){document.form2.oculto.value=2;document.form2.submit();}}
  	else{alert('Faltan datos para completar el registro');}
}
</script>
		<?php titlepag();?>
	</head>
	<body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("presu");?></tr>
        	<tr>
          		<td colspan="3" class="cinta"><a href="presu-agregaviggasto.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a><a href="#"  onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a><a href="presu-buscaviggasto.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a><a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a><a href="presu-datosbasicoscgr.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a></td>
        	</tr>
        </table>
 <form name="form2" method="post" action="">
    <table class="inicio" align="center"  >
      <tr >
        <td class="titulos" colspan="4" style='width:93%'>.: Agregar Vigencia Gasto C.G.R.</td><td class="cerrar" style='width:7%'><a href="presu-principal.php">Cerrar</a></td>
      </tr>
      <tr  >
	  <td class="saludo1">Codigo:
        </td>
        <td><input name="codigo" type="text" value="<?php echo $_POST[codigo]?>" maxlength="2" size="2" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)">
        </td>
        <td class="saludo1">Nombre:
        </td>
        <td><input name="nombre" type="text" value="<?php echo $_POST[nombre]?>" size="100" onKeyUp="return tabular(event,this)"><input type="hidden" name="oculto" value="1">
        </td>
       </tr>  
	   <tr><td></td></tr>                  
    </table>
    </form>
  <?php
$oculto=$_POST['oculto'];
if($_POST[oculto])
{
$linkbd=conectar_bd();
if ($_POST[nombre]!="")
 {
 $nr="1";
 $sqlr="INSERT INTO pptosidefgasto (codigo,nombre)VALUES ('$_POST[codigo]','".$_POST[nombre]."')";
 //echo "sqlr:".$sqlr;
  if (!mysql_query($sqlr,$linkbd))
	{
	 echo "<table><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
//	 $e =mysql_error($respquery);
	 echo "Ocurrió el siguiente problema:<br>";
  	 //echo htmlentities($e['message']);
  	 echo "<pre>";
     ///echo htmlentities($e['sqltext']);
    // printf("\n%".($e['offset']+1)."s", "^");
     echo "</pre></center></td></tr></table>";
	}
  else
  {
  echo "<table><tr><td class='saludo1'><center><h2>Se ha almacenado con Exito</h2></center></td></tr></table>";
  }
 }
else
 {
  echo "<table><tr><td class='saludo1'><center><H2>Falta informacion para Crear el Recurso</H2></center></td></tr></table>";
 }
}
?> <br><br>
</td></tr>     
</table>
</body>
</html>