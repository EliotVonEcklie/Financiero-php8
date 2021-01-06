<?php //V 1000 12/12/16 ?> 
<?php
  require"comun.inc";
  require"funciones.inc";
  session_start();
  cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
  header("Cache-control: private"); // Arregla IE 6
  date_default_timezone_set("America/Bogota");
  if (!isset($_SESSION["usuario"]))
{
 //*** verificar el username y el pass
 $users=$_POST['user'];
 $pass=$_POST['pass'];
 $link=conectar_bd();
  $sqlr="Select usuarios.nom_usu,roles.nom_rol, usuarios.id_rol, usuarios.id_usu, usuarios.foto_usu, usuarios.usu_usu from usuarios, roles where usuarios.usu_usu='$users' and usuarios.pass_usu='$pass' and usuarios.id_rol=roles.id_rol and usuarios.est_usu='1'";
//echo $sqlr;
 $res=mysql_query($sqlr,$link);
	while($r=mysql_fetch_row($res))
	{
 	$user=$r[0];
    $perf=$r[1];
    $niv=$r[2];
 	$idusu=$r[3];
	$nick=$r[5];
	$dirfoto=$r[4];
 	}
if ($user == "")
  {
   //login incorrecto 
   echo"<br><br><br><br><br><br><br><center><table border='1' cellpadding='0' cellspacing='0' bordercolor='#FFFFFF' width='50%'><tr bgcolor='#000066' colspan='1'><td><center><font color='#FFFFFF' face='Verdana, Arial, Helvetica, sans-serif' size='4' ><b>Contabilidad</b></font></center></td></tr>";
   echo "<TR bgcolor='#F7E39C' colspan='1'><td>";
   die("<center><h3><font color='#FFFFFF' face='Verdana, Arial, Helvetica, sans-serif'>Error: Usuario o contraseña Incorrecta, para volver a intentarlo da <a href=index2.php >click aqui</a></font></h3></center></td></TR></table></center>");
  }
else
  {
   //login correcto
//   session_start();
   $_SESSION["usuario"]=array();
     //session_register("usuario");
   //$usuario=array();
   $_SESSION["usuario"]=$user;
   $_SESSION["perfil"]=$perf;
   $_SESSION["idusuario"]=$idusu;
      $_SESSION["nickusu"]=$nick;
   //session_register("perfil");
   //$perfil="";
   //$perfil=$perf;
   $_SESSION["nivel"]=$niv;
   //session_register("nivel");
   //$nivel="";
   //$nivel=$niv;
//   $niv=$_SESSION["nivel"];
   $_SESSION["linksetin"]=array();
   if($dirfoto=="")
   {
   	$dirfoto="blanco.png";
	}
	$_SESSION["fotousuario"]="fotos/".$dirfoto;
   //******************* menuss ************************
  	  $sqlr="";
   $sqlr="Select DISTINCT (opciones.nom_opcion),opciones.ruta_opcion, opciones.niv_opcion,opciones.comando  from rol_priv, opciones where rol_priv.id_rol=$niv and opciones.id_opcion=rol_priv.id_opcion group by (opciones.nom_opcion), opciones.ruta_opcion, opciones.niv_opcion,opciones.comando  order by opciones.orden";
  echo "Quepaso".$sqlr;
    $linksetin[$x]="";
	 $res=mysql_query($sqlr,$link);
	while($roww=mysql_fetch_row($res))
    {
	 $_SESSION[linksetin][$roww[2]].='<li> <a onClick="location.href=\''.$roww[1].'\'" style="cursor:pointer;">'.$roww[0].' <span style="float:right">'.$roww[3].'</span></a></li>';
	}  
 }
}
else
 {
 $link=conectar_bd();
    $_SESSION["linksetin"]=array();
    $niv=$_SESSION["nivel"];
  $sqlr="";
   $sqlr="Select DISTINCT (opciones.nom_opcion),opciones.ruta_opcion, opciones.niv_opcion,opciones.comando  from rol_priv, opciones where rol_priv.id_rol=$niv and opciones.id_opcion=rol_priv.id_opcion and opciones.modulo=5 group by (opciones.nom_opcion), opciones.ruta_opcion, opciones.niv_opcion ,opciones.comando order by opciones.orden";
//  echo "sql=".$sqlr;
    $linksetin[$x]="";
	 $res=mysql_query($sqlr,$link);
	while($roww=mysql_fetch_row($res))
    {
	 $_SESSION[linksetin][$roww[2]].='<li> <a onClick="location.href=\''.$roww[1].'\'" style="cursor:pointer;">'.$roww[0].' <span style="float:right">'.$roww[3].'</span></a></li>';
//	 echo "<br>".$_SESSION[linkset][$roww[2]];
	}
 }	
//**niveles menu: Administracion (0) - Consultas (1) - Herramientas (2) - Reportes (3)
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
  <head>
    <meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
    <meta http-equiv="X-UA-Compatible" content="IE=9"/>
<title>:: SieS - Almacen</title>

<script>
//************* ver reporte ************
//***************************************
function verep(idfac)
{
  document.form1.oculto.value=idfac;
  document.form1.submit();
  }
//************* genera reporte ************
//***************************************
function genrep(idfac)
{
  document.form2.oculto.value=idfac;
  document.form2.submit();
  }
</script>
<script type="text/javascript" src="css/programas.js"></script>
<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
	<table>
   		<tr><script>barra_imagenes("inve");</script><?php cuadro_titulos();?></tr>	 
		<tr><?php menu_desplegable("inve");?></tr>
	</table>        
</body>
</html>