<?php
ob_end_clean();
//dorado18//
function datosiniciales()
{
	$datin[0] = 'dorado18';
	$datin[1] = 'localhost'; 
	$datin[2] = 'spid';
	$datin[3] = 'spidsoftware';
	return $datin;
}	
function sesion()
{
	//date_default_timezone_set("America/Bogota");
	session_start();
	/*$inactivo=18000;
	if(isset($_SESSION["tiempo"]))
	{
	 	$vida=time()-$_SESSION["tiempo"];
	 	if($vida>$inactivo)
	 	{
	 		session_destroy();
			header("Location: index2.php");
	 	}
	}
	$_SESSION["tiempo"]=time();*/
	/*//pregunta si se ha inicado por la principal
	if (!isset($_SESSION["usuario"]))
		die("<br><br><br><div style='background-color:#0555aa;color:fff';><h4><img src='imagenes/gyc.png'  align='middle' >&nbsp;&nbsp;<img src='imagenes/pagar.png' widht='100' height='100' align='middle'  >&nbsp;&nbsp; &iexcl;&iexcl;&iexcl; SESION CADUCADA, VUELVA A INGRESAR EL USUARIO Y CONTRASEÑA  &nbsp;&nbsp; <img src='imagenes/alert.png' align='middle'  ></h4></div>");	*/
}
function conectar_bd()
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	return $conexion;
}
function conectar()
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
		if(!mysql_select_db($datin[0]))
		die("no se puede seleccionar bd");
	return $conexion;
}
function desconectar_bd(){mysql_close();}
function esta_en_array($objetos, $elemento)
{
	$i=0;
$encontrado=false;
//echo "N: ".count($objetos);
  while(($i<count($objetos))&& !$encontrado)
 {

 //echo  "<br>".$objetos[$i]." ".$elemento." ".$encontrado;	
if(0==strcmp($objetos[$i],$elemento))
{$encontrado=1;
	//echo  "<br>".$objetos[$i]." ".$elemento." ".$encontrado;	
}
  $i++;
 }
return $encontrado;
}
function pos_en_array($objetos, $elemento)
{
$i=0;
 while(($i<count($objetos))&& !$encontrado)
 {
//echo "C:".$objetos[$i];	 
  if ($objetos[$i]==$elemento)
    { $pos=$i; }
  $i++;
 }
return $pos;
}
function titlepag()
{
	echo '<link rel="shortcut icon" href="favicon.ico"/>';
}
function validasusuarioypass($usuario,$passw)
{
	$datin=datosiniciales();
	if(!($conexion=mysql_connect($datin[1],$datin[2],$datin[3])))
	die("no se puede conectar");
	if(!mysql_select_db($datin[0]))
	die("no se puede seleccionar bd");
	$sqlr="SELECT us.nom_usu FROM usuarios us, roles ro WHERE us.usu_usu='$usuario' AND us.pass_usu='$passw' AND us.id_rol=ro.id_rol AND us.est_usu='1'";
	$res=mysql_query($sqlr,$conexion);
	$r=mysql_fetch_row($res);
	return $r[0];
}
?>