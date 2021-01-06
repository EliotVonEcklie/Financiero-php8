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
		<title>:: Spid - Administracion</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js"></script>

<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
   	<tr><script>barra_imagenes("adm");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("adm");?></tr>
<tr>
  <td colspan="3" class="cinta"><a class="mgbt"><img src="imagenes/add2.png"/></a><a href="#" onClick="document.form2.submit();" class="mgbt"><img src="imagenes/guarda.png" title="Guardar"/></a><a class="mgbt"><img src="imagenes/buscad.png"/></a><a href="#" onClick="mypop=window.open('adm-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td></tr></table>
    <form name="form2" method="post" action="adm-cambiacontra.php">
    <table width="40%" class="inicio" >
      <tr>
        <td class="titulos" colspan="4" style='width:93%'>:: Cambiar Contrase&ntilde;a</td><td class="cerrar" style='width:7%'><a href="adm-principal.php">Cerrar</a></td>
      </tr>
      <tr>
      <td class="saludo1" style='width:17%'>:: Usuario Activo:</td><td><input name="usu" size="30" value="<?php echo $_SESSION[usuario]; ?>" readonly ></td>
      <td class="saludo1">:: Perfil:</td><td><input name="rolu" size="50" value="<?php echo $_SESSION[perfil]; ?>" readonly ></td>
      </tr>
      <tr>
        <td class="saludo1">:: Digite Contraseña Anterior:
        </td>
        <td><input name="anterior" type="password" value="<?php echo $_POST[anterior]?>" size="30">
        </td>
       </tr> 
      <tr >
        <td  class="saludo1">:: Digite Contraseña Nueva:
        </td>
        <td><input name="nueva1" type="password" value="<?php echo $_POST[nueva1]?>" size="30">
        </td>
       </tr>              
      <tr >
        <td  class="saludo1">:: Confirme Contraseña Nueva:
        </td>
        <td>
        <input name="nueva2" type="password" value="<?php echo $_POST[nueva2]?>" size="30"><input name="oculto" type="hidden" value="1">
        </td>
       </tr> 
    </table>
    </form>
  <?php
$oculto=$_POST['oculto'];
if($_POST[oculto])
{
$linkbd=conectar_bd();
$contra1=$_POST['anterior'];
$contra2=$_POST['nueva1'];
$contra3=$_POST['nueva2'];
//sacar el consecutivo 
 $sqlr="select *from usuarios  where id_usu=$_SESSION[idusuario] ";
// echo "<div><div>sqlr:".$sqlr."</div></div>";
$resp = mysql_query($sqlr,$linkbd);
  $row =mysql_fetch_row($resp);
  $origpass=$row[4];  
if (($contra2==$contra3) && ($contra1==$origpass))
{
  $sqlr="update usuarios set pass_usu='$contra2' where id_usu=$_SESSION[idusuario] ";
  if (!mysql_query($sqlr,$linkbd))
	{
	 echo "<table class='inicio'><tr><td class='saludo1'><center><font color=blue>Manejador de Errores de la Clase BD<br><font size=1></font></font><br><p align=center>No se pudo ejecutar la petición: <br><font color=red><b>$sqlr</b></font></p>";
	// $e = mysql_error($respquery);
	 echo "Ocurrió el siguiente problema:<br>";
  	 //echo htmlentities($e['message']);
  	 echo "<pre>";
     //echo htmlentities($e['sqltext']);
     //printf("\n%".($e['offset']+1)."s", "^");
     echo "</pre></center></td></tr></table>";
	}
  else
  {
  echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha Actualizado la Contraseña con Exito <img src='imagenes/confirm.png'></center></td></tr></table>";
  }
}
else
 {
	 echo "<table class='inicio'><tr><td class='saludo1'><center>Los datos son incorrectos, Intente de nuevo <img src='imagenes/alert.png'></center></td></tr></table>";
 }
}
?>
</body>
</html>