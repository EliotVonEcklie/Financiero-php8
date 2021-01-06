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
  <td colspan="3" class="cinta"><a href="adm-areas.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a><a href="#"  onClick="document.form2.submit();" class="mgbt"><img src="imagenes/guarda.png" title="Guardar"/></a><a href="adm-buscaareas.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a><a href="#" onClick="mypop=window.open('adm-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td></tr></table>
<?php
if(!$_POST[oculto])
{
$sqlr="Select *from admareas where id_cc=$_GET[idtipocom]";
$res=mysql_query($sqlr,$linkbd);
while($row=mysql_fetch_row($res))
  {
   $_POST[idcomp]=$row[0];
   $_POST[nombre]=$row[1];
   $_POST[estado]=$row[2];
   $_POST[codigo]=$row[0];
  }
}
?>
 <form name="form2" method="post" action="adm-editarareas.php">
    <table class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="6" style='width:93%'>.: Editar areas</td><td class="cerrar" style='width:7%'><a href="adm-principal.php">Cerrar</a></td>
      </tr>
      <tr  >
	    <td class="saludo1">Codigo:
        </td>
        <td><input name="codigo" type="text" value="<?php echo $_POST[codigo]?>" size="2" maxlength="2" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)">
        </td>
        <td class="saludo1">Nombre:
        </td>
        <td><input name="nombre" type="text" value="<?php echo $_POST[nombre]?>" size="80"  onKeyUp="return tabular(event,this)">
        </td>
        <td class="saludo1">Activo:
        </td>
        <td><select name="estado" id="estado">
          <option value="S" <?php if($_POST[estado]=='S') echo "selected" ?>>SI</option>
          <option value="N" <?php if($_POST[estado]=='N') echo "selected" ?>>NO</option>
        </select>   <input name="oculto" type="hidden" value="1">  <input name="idcomp" type="hidden" value="<?php echo $_POST[idcomp]?>" >   </td>
       </tr>                  
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
 $sqlr="update admareas set nombre='".$_POST[nombre]."',estado='$_POST[estado]',id_cc='$_POST[codigo]' where id_cc='$_POST[idcomp]'";
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
  echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha actualizado con Exito <img src='imagenes\confirm.png' ></center></td></tr></table>";
  }
 }
else
 {
  echo "<table><tr><td class='saludo1'><center>Falta informacion para Crear la Area <img src='imagenes\alert.png' ></center></td></tr></table>";
 }
}
?> 
</body>
</html>