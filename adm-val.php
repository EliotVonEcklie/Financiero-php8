<?php //V 1000 12/12/16 ?> 
<!--V 1.0 24/02/2015-->
<?php
	require "comun.inc";
	require"funciones.inc";
	require "conversor.php";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
	session_destroy();
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: FINANCIERO</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script src="css/calendario.js"></script> 
        <script type="text/javascript" src="css/programas.js"></script>
<?php titlepag();?>
</head>
<body background="imagenes/fondo.jpg" >
<br><br><br><br>
<div><img src="imagenes/siglas.png" align="absmiddle"><br><br><br><br></div>
<form name="form1" method="post" action="">
<table class="inicio" style="width:32.5%">
<tr><td colspan="2"><img src="imagenes/activar.png"></td><td></td></tr>
<tr><td width="48%" >Usuario:</td><td width="52%" rowspan="3" align="center"  class="iniciop"><img src="imagenes/session.png" width="50" height="50"></td></tr>
<tr><td ><input type="text" name="user"  /></td></tr>
<tr><td>Contrase&ntilde;a:</td></tr>
<tr><td> <input type="password" name="pass"  /></td><td width="52%" rowspan="1" align="center"  class="iniciop"><img src="imagenes/gyc2.png" ></td></tr>
<tr> <td class="saludo1">Fecha Proxima Activacion: </td>
        <td ><input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10" size="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY">   <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>     
        <select name="tipop" onKeyUp="return tabular(event,this)">
        <option value="">Tipo Activacion ...</option>
				  <option value="A" <?php if($_POST[tipop]=='A') echo "SELECTED"?>>Arriendo</option>
  				  <option value="P" <?php if($_POST[tipop]=='P') echo "SELECTED"?>>Venta</option>
                 <option value="N" <?php if($_POST[tipop]=='N') echo "SELECTED"?>>Cancelacion</option> 
		 </select>
        </td></tr>
<tr><td><input type="submit" name="aceptar" value=" Entrar >"/><input type='hidden' name='oculto' id='oculto' value="2"></td></tr>
</table>
</form>
<?php
if($_POST[oculto]=='2')
 {
  $linkbd=conectar_bd();
  $users=$_POST[user];
    $pass=$_POST[pass];
   $sqlr="Select usuarios.nom_usu,roles.nom_rol, usuarios.id_rol, usuarios.id_usu, usuarios.foto_usu, usuarios.usu_usu from usuarios, roles where usuarios.usu_usu='$users' and usuarios.pass_usu='$pass' and usuarios.id_rol=roles.id_rol and usuarios.est_usu='1' and usuarios.id_rol='1'";
//echo $sqlr;
 $res=mysql_query($sqlr,$linkbd);
	while($r=mysql_fetch_row($res))
	{
 	$user=$r[0];
    $perf=$r[1];
    $niv=$r[2];
 	$idusu=$r[3];
	$nick=$r[5];
	$dirfoto=$r[4];
 	}
if ($user != "")
  {
	$fec=date("d/m/Y"); 
	$linkbd=conectar_bd();
  $sqlr="select *from admcon where  id=1 ";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
	{
	 $f1=$row[1];
	 $f2=$row[2];	
	$cadena2=$row[3];
	$estado=$row[4];
	}
  $cadena=$_POST[fecha];	
  $resultado=codifica($cadena,$cadena2);  
  $dec=decodifica($resultado,$cadena2);	
  
 // echo "tipo:".$_POST[tipop];
  if($_POST[tipop]=='A')
   {	   
     $f1=codifica($fec,$cadena2);
	$sqlr='UPDATE  admcon SET estado="A", ini="'.mysql_real_escape_string($f1).'	", fin="'.mysql_real_escape_string($resultado).'"  where  id=1 ';
	//echo $sqlr;
	if(mysql_query($sqlr,$linkbd))
	 echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha ACTIVADO el Sistema hasta:$_POST[fecha]<img src='imagenes/confirm.png' ></center></td></tr></table>";
	}
  if($_POST[tipop]=='P')
   {
	//$f1=codifica($f1,$cadena2);
	$sqlr='UPDATE  admcon SET estado="P", ini="'.mysql_real_escape_string($f1).'	", fin="'.mysql_real_escape_string($resultado).'"  where  id=1 ';
		if(mysql_query($sqlr,$linkbd))
	 echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha ACTIVADO el Sistema hasta:$_POST[fecha]<img src='imagenes/confirm.png' ></center></td></tr></table>";
	}
if($_POST[tipop]=='N')
   {
	$f1=codifica($f1,$cadena2);
	$sqlr='UPDATE  admcon SET estado="N",ini="'.mysql_real_escape_string($f1).'	", fin="'.mysql_real_escape_string($resultado).'"  where  id=1 ';
	if(mysql_query($sqlr,$linkbd))
	 echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha DESACTIVADO el Sistema <img src='imagenes/alert.png' ></center></td></tr></table>";
	}		
 // echo "<br>COMPARAR:$cadena= ".$resultado." - ".$dec;
  }
  else
   {
	?>
    <script>
	//alert("errorrrr");
	window.close();</script>
    <?php   
	}
 }
?>
<br><br><br>
<div class="inicio" ><img src="imagenes/soluciones.png" alt="soluciones estrategicas integrales"> </div>
</body>
</html>
