<?php //V 1000 12/12/16 ?> 
<?php 
  require"comun.inc"; 
  require"funciones.inc";
  session_start();
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
   $_SESSION["linkset"]=array();
   if($dirfoto=="")
   {
   	$dirfoto="blanco.png";
	}
	$_SESSION["fotousuario"]="fotos/".$dirfoto;
   //******************* menuss ************************
  	  $sqlr="";
   $sqlr="Select DISTINCT (opciones.nom_opcion),opciones.ruta_opcion, opciones.niv_opcion from rol_priv, opciones where rol_priv.id_rol=$niv and opciones.id_opcion=rol_priv.id_opcion group by (opciones.nom_opcion), opciones.ruta_opcion, opciones.niv_opcion order by opciones.orden";
  echo "Quepaso".$sqlr;
    $linkset[$x]="";
	 $res=mysql_query($sqlr,$link);
	while($roww=mysql_fetch_row($res))
    {
	 $_SESSION[linkset][$roww[2]].='<li> <a onClick="location.href=\''.$roww[1].'\'" style="cursor:pointer;">'.$roww[0].'</a></li>';
	}  
 }
}
else
 {
 $link=conectar_bd();
    $_SESSION["linksetno"]=array();
    $niv=$_SESSION["nivel"];
  $sqlr="";
   $sqlr="Select DISTINCT (opciones.nom_opcion),opciones.ruta_opcion, opciones.niv_opcion from rol_priv, opciones where rol_priv.id_rol=$niv and opciones.id_opcion=rol_priv.id_opcion and opciones.modulo=2 group by (opciones.nom_opcion), opciones.ruta_opcion, opciones.niv_opcion order by opciones.orden";
//  echo "sql=".$sqlr;
    $linksetno[$x]="";
	 $res=mysql_query($sqlr,$link);
	while($roww=mysql_fetch_row($res))
    {
	 $_SESSION[linksetno][$roww[2]].='<li> <a onClick="location.href=\''.$roww[1].'\'" style="cursor:pointer;">'.$roww[0].'</a></li>';
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
<title>:: contabilidad</title>
<script>

//Pop-it menu- By Dynamic Drive
//For full source code and more DHTML scripts, visit http://www.dynamicdrive.com
//This credit MUST stay intact for use
var linksets=new Array()
var linkset2=new Array()
linksets= '<?php echo $_SESSION[linkset][0]; ?>';
linkset2[0]=linksets;
//alert("mensaje"+linkset2[0]);
linksets= '<?php echo $_SESSION[linkset][1]; ?>';
linkset2[1]=linksets
linksets= '<?php echo $_SESSION[linkset][2]; ?>'
linkset2[2]=linksets
linksets= '<?php echo $_SESSION[linkset][3]; ?>'
linkset2[3]=linksets
linksets= '<?php echo $_SESSION[linkset][4]; ?>'
linkset2[4]=linksets
</script>
<script>
//************* ver reporte ************
//***************************************
function verep(idfac)
{
  document.form1.oculto.value=idfac;
  document.form1.submit();
  }
</script>
<script>
//************* genera reporte ************
//***************************************
function genrep(idfac)
{
  document.form2.oculto.value=idfac;
  document.form2.submit();
  }
</script>

<link href="css/css2.css" rel="stylesheet" type="text/css" />
<?php titlepag();?>
</head>
<body>
<table>
	<tr><td>
   <div id="menu">          <!-- Navigation -->  
			<ul>  
        <li><a href="principal.php">Inicio</a></li>  
        <li><a href="#" onClick="document.getElementById('maestros').style.display='block';document.getElementById('repor').style.display='none';document.getElementById('herram').style.display='none';document.getElementById('procesos').style.display='none'" class="mgbt">Archivos Maestros</a></li>
<li><a href="#" onClick="document.getElementById('procesos').style.display='block';document.getElementById('repor').style.display='none';document.getElementById('herram').style.display='none';document.getElementById('maestros').style.display='none'" class="mgbt">Procesos</a></li>		
		<li><a href="#" onClick="document.getElementById('herram').style.display='block';document.getElementById('repor').style.display='none';document.getElementById('maestros').style.display='none';document.getElementById('procesos').style.display='none'" class="mgbt">Herramientas</a></li>
        <li><a href="#" onClick="document.getElementById('repor').style.display='block';document.getElementById('herram').style.display='none';document.getElementById('procesos').style.display='none';document.getElementById('maestros').style.display='none'" class="mgbt">Informes</a></li>         
        <li><a href="ayuda.html" target="_blank">Ayuda</a></li>           
  			</ul>  
		</div>
        </td>
        <td rowspan="2"><img src="imagenes/logoconta.png">
		<table class="inicio"><tr ><td  class="saludo1" width="73px">Usuario: </td><td><?php echo $_SESSION[usuario]?></td>    	<td class="saludo1">Perfil: </td><td><?php echo $_SESSION["perfil"];?></td></tr>
		  <tr><td  class="saludo1" width="73px">Fecha ingreso:</td><td> <?php echo " ".$fec=date("Y-m-d");?> </td> <td  class="saludo1">Hora Ingreso: </td><td><?php $hora=time();echo " ".date ( "h:i:s" , $hora ); $hora=date ( "h:i:s" , $hora )?></td></tr>
		  		  <tr>    </tr>
		  <tr>   </tr>
</table>
</td></tr>
	<tr>
	  <td class="tablaprin"></td>
  </tr>

<tr><td colspan="2" class="tablaprin2">
<div id="maestros" style="display:none"><div id="menu2"><ul><li>Archivos Maestros >> </li><script>document.write('<?php echo $_SESSION[linksetno][1];?>')</script></ul></div></div>
<div id="procesos" style="display:none"><div id="menu2"><ul><li>Procesos >> </li><script>document.write('<?php echo $_SESSION[linksetno][2];?>')</script></ul></div></div>
<div id="herram" style="display:none"><div id="menu2"><ul><li>Herramientas >> </li><script>document.write('<?php echo $_SESSION[linksetno][3];?>')</script></ul></div></div>
<div id="repor" style="display:none"><div id="menu2"><ul><li>Informes >> </li><script>document.write('<?php echo $_SESSION[linksetno][4];?>')</script></ul></div></div>
</td></tr>
<tr><td colspan="2" class="tablaprin">  <br /><br />
  <table width="50%"  class="tablaprin" align="center"   >
        <tr>
          <td ></td>
        </tr>
      </table>  
  <br /><br />  </td></tr>
<tr><td></td></tr>      
</table>
</body>
</html>