<?php //V 1000 12/12/16 ?> 
<?php
  require"comun.inc";
  require"funciones.inc";
  sesion();
  $_SESSION["usuario"] ;
  $_SESSION["perfil"] ;
  $_SESSION["linkset"] ;
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
<table>
	<tr><td>
     <div id="menu">          <!-- Navigation -->  
			<ul>  
        <li><a href="principal.php">Inicio</a></li>  
        <li><a href="#" onClick="document.getElementById('admini').style.display='block';document.getElementById('herram').style.display='none';document.getElementById('repor').style.display='none';document.getElementById('maestros').style.display='none';document.getElementById('procesos').style.display='none'">Administracion</a></li>  
        <li><a href="#" onClick="document.getElementById('maestros').style.display='block';document.getElementById('admini').style.display='none';document.getElementById('repor').style.display='none';document.getElementById('herram').style.display='none';document.getElementById('procesos').style.display='none'">Archivos Maestros</a></li>
<li><a href="#" onClick="document.getElementById('procesos').style.display='block';document.getElementById('admini').style.display='none';document.getElementById('repor').style.display='none';document.getElementById('herram').style.display='none';document.getElementById('maestros').style.display='none'">Procesos</a></li>		
		<li><a href="#" onClick="document.getElementById('herram').style.display='block';document.getElementById('admini').style.display='none';document.getElementById('repor').style.display='none';document.getElementById('maestros').style.display='none';document.getElementById('procesos').style.display='none'">Herramientas</a></li>
        <li><a href="#" onClick="document.getElementById('repor').style.display='block';document.getElementById('herram').style.display='none';document.getElementById('admini').style.display='none';document.getElementById('procesos').style.display='none';document.getElementById('maestros').style.display='none'">Informes</a></li>         
        <li><a href="ayuda.html" target="_blank">Ayuda</a></li>           
        <li><a href="principal.php">Salir</a></li>  
  			</ul>  
		</div>
        </td>
        <td><img src="imagenes/logoconta.png">
		<table class="inicio"><tr ><td width="219" >Usuario: <?php echo $_SESSION[usuario]?></td></tr>
		  <tr>
    	<td>Perfil: <?php echo $_SESSION["perfil"];?></td>  </tr>
		  <tr>    <td >Fecha ingreso: <?php echo " ".$fec=date("Y-m-d");?> </td></tr>
		  <tr>    <td >Hora Ingreso: <?php $hora=time();echo " ".date ( "h:i:s" , $hora ); $hora=date ( "h:i:s" , $hora )?></td></tr>
</table>
</td></tr>
<tr><td colspan="2" class="tablaprin2">
<div id="admini" style="display:none"><div id="menu2"><ul><li>Administracion >> </li><script>document.write('<?php echo $_SESSION[linksetco][0];?>')</script></ul></div></div>
<div id="maestros" style="display:none"><div id="menu2"><ul><li>Archivos Maestros >> </li><script>document.write('<?php echo $_SESSION[linksetco][1];?>')</script></ul></div></div>
<div id="procesos" style="display:none"><div id="menu2"><ul><li>Procesos >> </li><script>document.write('<?php echo $_SESSION[linksetco][2];?>')</script></ul></div></div>
<div id="herram" style="display:none"><div id="menu2"><ul><li>Herramientas >> </li><script>document.write('<?php echo $_SESSION[linksetco][3];?>')</script></ul></div></div>
<div id="repor" style="display:none"><div id="menu2"><ul><li>Informes >> </li><script>document.write('<?php echo $_SESSION[linksetco][4];?>')</script></ul></div></div>
</td></tr>
<tr>
  <td colspan="2" class="tablaprin2"><a href="#" onClick="addperfiles.php"><img src="imagenes/add2.png" width="50" height="50" alt="Nuevo" /></a>  <a href="#" onClick="document.form2.submit();" ><img src="imagenes/guarda.png" width="50" height="50" alt="Guardar"/></a> <a href="cont-perfiles.php"><img src="imagenes/busca.png" width="50" height="50" alt="Buscar" /></a> <a href="#" onClick="mypop=window.open('cont-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" alt="nueva ventana"></a></td></tr></table>
<tr><td colspan="2" class="tablaprin">  <br />
 <?php
	if ($_POST[oculto]=="")
	{
  $linkbd=conectar_bd();
  $sqlr="select *from roles where id_rol=$_GET[idrol]";
$resp = mysql_query($sqlr,$linkbd);
$fila =mysql_fetch_row($resp);
 // $fila = oci_fetch_array($resp,OCI_BOTH);
  $cr=$fila[0];
  $nombre=$fila[1];
  $des=$fila[3];
  desconectar_bd();
   }
  else
   {
	$cr=$_POST[codigo];
  $nombre=$_POST[nombre];
  $des=$_POST[valor];
	}
if ($_POST[oculto]=="")
{
?>
<form name="form2" method="post" action="">
  <table width="60%" class="inicio" align="center" >
    <tr >
      <td class="titulos" colspan="2">:: Informacion Perfil</td>
    </tr>
    <tr >
      <td >:&middot; Nombre:      </td>
      <td><input name="nombre" type="text" id="nombre" size="45" value="<?php echo $nombre ?>"></td>
    </tr>
    <tr >
      <td >:&middot; Descripcion: </td>
      <td><input name="valor" type="text" id="valor" size="70" value="<?php echo $des ?>">        <input name="oculto" type="hidden" id="oculto" value="1">
        <input name="codigo" type="hidden" id="codigo" value="<?php echo $cr ?>"></td>
    </tr>
      </table>
  	<?php
echo " <table width='50%'  class='inicio' align='center'>";//*****tabla de Privilegios *****
echo " <tr class='titulos'><td height='25' colspan='4'>:: Privilegios del Perfil ";
echo "</td></tr>";
echo "<tr >";
echo "<td class='titulos2' width='40'><center>Item</center></td>";
echo "<td class='titulos2' width='430'>Nombre </td>";
echo "<td class='titulos2' width='50' height='25'><center> Sel </center></td></tr>";
$linkbd=conectar_bd();
//********Sacar los privilegios****
$_SESSION[idexacli]=array();
$_SESSION[valexacli]=array();
	$sqlr="Select *from opciones order by nom_opcion";
	$sqlr2="select ROL_PRIV.ID_opcion, opciones.NOM_opcion,ROL_PRIV.ID_opcion,ROLES.ID_ROL, ROL_PRIV.ID_ROL from	ROLES,ROL_PRIV,opciones where ROL_PRIV.ID_opcion=opciones.id_opcion "; 
     $sqlr2=$sqlr2."and	 ROLES.ID_ROL=rol_priv.id_rol and ROL_PRIV.ID_ROL=$cr";
	$iter='fila1';
$iter2='fila2';
//	echo "$sqlr2";
$resp = mysql_query($sqlr2,$linkbd);	
//$resp = oci_parse ($linkbd, $sqlr2);
//oci_execute ($resp);
$i=0;
while ($row = mysql_fetch_row($resp)) 
 {
 $_SESSION[idexacli][$i]=$row[0];
 $_SESSION[valexacli][$i]=$row[1];
 $i+=1;
 }
//oci_free_statement($resp);
$resp = mysql_query($sqlr,$linkbd);
//$resp = oci_parse ($linkbd, $sqlr);
//oci_execute ($resp);
$i=1;
while ($row =  mysql_fetch_row($resp)) 
 {
  echo "<tr ><td id='$iter'><center>$i</center></td>";
$i+=1;
  echo "<td id='$iter'>$row[1]</td>";
  if (!esta_en_array($_SESSION[idexacli],$row[0]))
  { 
   echo "<td id='$iter'><center><input type='checkbox' name=tabla[] value='$row[0]' "; 
   echo"></td></tr>";
  }
   else
   {
  $pos=pos_en_array($_SESSION[idexacli],$row[0]);
  $valor=$_SESSION[idexacli][$pos];
   echo "<td id='$iter'><center><input type='checkbox' name=tabla[] value='$row[0]'"; 
  echo " checked ></td></tr>"; //***** para cuando se registre las sesiones y las variables de sesion
  echo "</td></tr>";
   }
  $aux=$iter;
  $iter=$iter2;
  $iter2=$aux; 
 }
echo "</table>";
	?>
</form>
<?php
}
$oculto=$_POST['oculto'];
if($oculto!="")
{
/*$i=1;
Foreach ($_POST[tabla] as $id)
{
$vd2=$id;
$v[$i]=$vd2;
$i+=1;
}*/
$linkbd=conectar_bd();
$sqlr="update roles set nom_rol='$_POST[nombre]',desc_rol='$_POST[valor]' where id_rol=$_POST[codigo]";
$resp = mysql_query($sqlr,$linkbd);
//$resp=oci_parse ($linkbd, $sqlr);
//oci_execute ($resp);
//sacar el consecutivo 
$sqlr="Delete from rol_priv where id_rol=$_POST[codigo]";
//$resp=oci_parse ($linkbd, $sqlr);
//oci_execute ($resp);
//echo "$sqlr<br>";
$resp = mysql_query($sqlr,$linkbd);
$i=1;
Foreach ($_POST[tabla] as $id)//For ($i=1;$i<=count($v);$i++)
{
  $sqlr="Select MAX(id_rolpri) from rol_priv ";
		//$statement = oci_parse ($linkbd, $sqlr);
		//oci_execute ($statement);
	$statement = mysql_query($sqlr,$linkbd);
		$nr=0;
		//while ($row = oci_fetch_array ($statement, OCI_BOTH)) 
		 while ($row =mysql_fetch_row($resp)) 
		 {
		  $nr=$row[0]+1;
		 }
		if ($nr==0)
		{
		  $nr=1;
		}
//		oci_free_statement($statement);
$vd2=$id;
$v[$i]=$vd2;
$sqlr="insert into rol_priv (id_rol,id_opcion,est_rolpriv) values($_POST[codigo],$v[$i],'1')";
//$resp=oci_parse ($linkbd, $sqlr);
//oci_execute ($resp);
//echo $sqlr."<br>";
$resp = mysql_query($sqlr,$linkbd);
$i+=1;
}
echo "<table class='tablaprin'><tr><td class='saludo1'><center><h2>Se ha Actualizado con Exito</h2></center></td></tr></table>";
//oci_free_statement($resp);
//oci_close($linkdb);
}
?>
</td></tr>
<tr><td><div><img src="imagenes/ingelsisltda.png" /></div></td></tr>      
</table>
</body>
</html>