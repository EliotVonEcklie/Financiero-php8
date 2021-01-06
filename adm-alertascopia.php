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
        <script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
<script>
function checktodos()
{
 	cali=document.getElementsByName('bloqueados[]');
 	for (var i=0;i < cali.length;i++) 
 	{ 
		if (document.getElementById("todos").checked == true) {cali.item(i).checked = true;document.getElementById("todos").value=1;}
		else{cali.item(i).checked = false;document.getElementById("todos").value=0;}
 	}	
}

function guardar(){if (confirm("Esta Seguro de Guardar")){document.form2.oculto.value=2;document.form2.submit();}}
</script>
<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
   	<tr><script>barra_imagenes("adm");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("adm");?></tr>
<tr>
  <td colspan="3" class="cinta"><a href="adm-alertascopia.php" class="mgbt"><img src="imagenes/add.png"  title="Nuevo" /></a><a href="#" onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png"  title="Guardar" /></a><a href="#" onClick="document.form2.submit();" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a><a href="#" onClick="mypop=window.open('adm-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td></tr></table>
 <form name="form2" method="post" action="">
 <?php
 if (!$_POST[oculto])
 {
  $sqlr="select valor_inicial from dominios where dominios.nombre_dominio='HORA_ALERTA'";
	$resp = mysql_query($sqlr,$linkbd);
	$fila =mysql_fetch_row($resp);
	//ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fila[0],$fecha);
	//$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
	$_POST[horac]=$fila[0];
	$fecha=preg_split('/:/',$fila[0]);
	$chekt=" checked ";
	//echo "h".$fecha[0]." m".$fecha[1];
	$_POST[hora]=$fecha[0];
	$_POST[minutos]=$fecha[1];
 }
 ?>
  <table  class="inicio" align="center">
    <tr >
      <td class="titulos" colspan="2">:: Configurar Alertas Copia de Seguridad</td>
    </tr>
    <tr >
      <td class="saludo3">:&middot; Hora Alerta Programada:</td>
      <td width="80%" ><select name="hora" >
      <option value="">Hora..</option>
      <?php
	  for($x=0;$x<=23;$x++)
	   {
		  $t=""; 
  	   	 $t="0".$x;
		 echo "<option value='".substr($t,-2)."'";
		 if($_POST[hora]==substr($t,-2))
		  {
			echo " SELECTED ";  
		  }
		 echo ">".substr($t,-2)."</option>";
		}
	  ?>
      </select> : <select name="minutos" >
      <option value="">Minutos..</option>
      <?php
	  for($x=0;$x<=59;$x++)
	   {
		   		  $t="0".$x;
		 echo "<option value='".substr($t,-2)."'";  
		 if($_POST[minutos]==substr($t,-2))
		  {
			echo " SELECTED ";  
		  }
		 echo ">".substr($t,-2)."</option>";
		}
	  ?>
      </select><input name="horac" type="hidden" id="horac" value="<?php echo $_POST[horac]?>">   <input name="oculto" type="hidden" id="oculto" value="1"> </td>
    </tr>
  </table>
  <?php
$oculto=$_POST['oculto'];
if($_POST[oculto]=='2')
 {
	  echo "<div class='subpantallac3'>";
	  $sqlr="delete from  dominios where dominios.NOMBRE_DOMINIO='ALERTA_USUARIOS'";
	  mysql_query($sqlr,$linkbd);	  
	 // ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fechas);
	  $fechan=$_POST[hora].":".$_POST[minutos];
	  $sqlr="update  dominios set dominios.valor_inicial='$fechan'  where dominios.NOMBRE_DOMINIO='HORA_ALERTA'";
	   if(!mysql_query($sqlr,$linkbd))
	   echo "<table class='inicio'><tr><td class='saludo1'><center>No se ha Actualizado la Hora de Activacion de la Alerta ".$fechan." Error: ".mysql_error($linkbd)." <img src='imagenes/alert.png'></center></td></tr></table>";
	   else
	   echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha Actualizado la Hora de Activacion de la Alerta ".$fechan." <img src='imagenes/confirm.png'></center></td></tr></table>";
	 $tam=count($_POST[id]);	 
	 for ($x=0;$x<$tam;$x++)
	  {
		 if(!esta_en_array($_POST[bloqueados],$_POST[id][$x]))	  
		  $fechad=$_POST[fechau][$x];
		 else
		  $fechad=$_POST[fecha];
		  ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $fechad,$fechas);
	  // $fechad=$fechas[3]."-".$fechas[2]."-".$fechas[1];
	   $sqlr="insert into dominios (dominios.valor_inicial,dominios.valor_final,dominios.NOMBRE_DOMINIO) values ('$fechan','".$_POST[id][$x]."','ALERTA_USUARIOS')";
	   if(!mysql_query($sqlr,$linkbd))
	    {
		echo "<table class='inicio'><tr><td class='saludo1'><center>No se ha Actualizado la Fecha de Bloqueo del Usuario ".$_POST[nombres][$x]." Error: ".mysql_error($linkbd)." <img src='imagenes/alert.png'></center></td></tr></table>";
		}
	   else
	    {
		 echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha Actualizado la Fecha de Bloqueo del Usuario ".$_POST[nombres][$x]." <img src='imagenes/confirm.png'></center></td></tr></table>";	
		}
	  }
	  echo "</div>";
 }
?>
<div class="subpantalla" style="height:68.5%; width:99.6%; overflow-x:hidden;">
<table  class="inicio" align="center">
<tr><td class="titulos" colspan="7">:: Usuarios </td></tr>
<tr><td class="titulos2">Id</td><td class="titulos2">Nombre</td><td class="titulos2">Documento</td><td class="titulos2">Usuario</td><td class="titulos2">Perfil</td><td class="titulos2"><center>Activar Gral<input id="todos" type="checkbox" name="todos" value="1" onClick="checktodos()" <?php echo $chekt;  ?>></center></td></tr>
<?php
 $linkbd=conectar_bd();
$sqlr="Select usuarios.usu_usu,usuarios.cc_usu, roles.nom_rol from usuarios, roles where usuarios.id_rol=roles.id_rol";
$resp = mysql_query($sqlr,$linkbd);
$i=1;
$idf=1198971546;
$co="saludo1a";
$co2="saludo2";
while($r =mysql_fetch_row($resp))
 {
 $idf+=1;
 ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $r[2],$fecha);
 $fechab=$fecha[3]."/".$fecha[2]."/".$fecha[1];
 $chk="";
  $esta=buscadominio("ALERTA_USUARIOS",$r[0]);
  //$esta=buscadominio("ALERTA_USUARIOS",$r[0]);
  if(esta_en_array($_POST[bloqueados],$r[0]) || !$_POST[oculto])	  
		  $chk=" checked ";
 echo "<tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\" >
 <td><input type='hidden' name='id[]' value='$r[0]'>$i</td><td><input type='hidden' name='nombres[]' value='$r[0]'>$r[0]</td><td>$r[1]</td><td>$r[0]</td><td>$r[4]</td><td><center><input type='checkbox' name='bloqueados[]' value='$r[0]' ".$chk."></center></td></tr>";
  	 $i+=1;
 	 $aux=$co;
	 $co=$co2;
	 $co2=$aux;
 }
?>
</table>
</div>
</form>      
</body>
</html>