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
		<title>:: Spid - Contabilidad</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/programas.js"></script>
<script>
//************* ver reporte ************
//***************************************
function guardar(){if (confirm("Esta Seguro de Guardar")){document.form2.oculto.value=2;document.form2.submit();}}

function buscactac(e){if (document.form2.cuentamiles.value!=""){document.form2.bcc.value='1';document.form2.submit();}}

function buscactace(e){if (document.form2.cuentac.value!=""){document.form2.bcce.value='1';document.form2.submit();}}

function buscactacd(e){if (document.form2.cuentac.value!=""){document.form2.bccd.value='1';document.form2.submit();}}
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
		<td colspan="3" class="cinta">
			<a href="adm-activarcajappal.php" class="mgbt"><img src="imagenes/add.png"  title="Nuevo" /></a>
			<a href="#" onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png" title="Guardar"/></a>
			<a href="adm-usuarios.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" onClick="mypop=window.open('adm-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
		</td>
	</tr>
</table>
<?php
	//echo  "oc".$_POST[oculto];
   if(!$_POST[oculto])
   {
	$sqlr="select valor_inicial from dominios where nombre_dominio='CUENTA_MILES'";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
	{
	 $_POST[cuentamiles]=$row[0];
	 $_POST[ncuentamiles]=buscacuenta($_POST[cuentamiles]);
	}
	//***excedente
	$sqlr="select valor_inicial from dominios where nombre_dominio='CUENTA_EXCEDENTE'";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
	{
	 $_POST[cuentautilidad]=$row[0];
	 $_POST[ncuentautilidad]=buscacuenta($_POST[cuentautilidad]);
	}
	//**** deficit
	$sqlr="select valor_inicial from dominios where nombre_dominio='CUENTA_DEFICIT'";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
	{
	 $_POST[cuentacierre]=$row[0];
	 $_POST[ncuentacierre]=buscacuenta($_POST[cuentacierre]);
	}
	}
?>
    <form name="form2" method="post" action="cont-parametroscierre.php">
    <table class="inicio" >
      <tr >
        <td class="titulos" colspan="4">:: Cajas Principal<br></td><td  class="cerrar" ><a href="cont-principal.php">Cerrar</a></td>
      </tr>
       <tr  >
        <td  class="saludo1">:: Cuenta Caja:
       </td>
        <td ><input id="cuentamiles" name="cuentamiles" type="text" value="<?php echo $_POST[cuentamiles]?>" size="15" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" onBlur="buscactac(event)"  onClick="document.getElementById('cuentamiles').focus();document.getElementById('cuentamiles').select();">
        </td><td><input type="hidden" value="" name="bcc"><a href="#" onClick="mypop=window.open('cuentasgral-ventana.php?vigencia=<?php echo $_SESSION[vigencia]?>&objeto=cuentamiles&nobjeto=ncuentamiles','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a></td><td  ><input id="ncuentamiles"  name="ncuentamiles" type="text" value="<?php echo $_POST[ncuentamiles]?>" size="80" readonly> </td>
        </tr>             
    </table>
    <div class="subpantalla" style="height:68.5%; width:99.6%; overflow-x:hidden;">
    <table class="inicio">
	<tr><td class="titulos" colspan="6">Detalle Concepto</td></tr>
	<tr><td class="titulos2">CC</td><td class="titulos2">Cuenta</td><td class="titulos2">Nombre Cuenta</td><td class="titulos2"><img src="imagenes/del.png" ><input type='hidden' name='elimina' id='elimina'></td></tr>
    </div>
    </form>
  <?php
  if($_POST[bcc]!='')
			 {
			  $nresul=buscacuenta($_POST[cuentamiles]);
			  if($nresul!='')
			   {
			  $_POST[ncuentamiles]=$nresul;
  			  ?>
			  <script>			  
			  document.getElementById('bcc').value='';
			  </script>
			  <?php
			  }
			 else
			 {
			  $_POST[ncuentamiles]="";
			  ?>
			  <script>alert("Cuenta Incorrecta");document.form2.cuentamiles.focus();</script>
			  <?php
			  }
			 } 
	if($_POST[bcce]!='')
			 {
			  $nresul=buscacuenta($_POST[cuentamiles]);
			  if($nresul!='')
			   {
			  $_POST[ncuentamiles]=$nresul;
  			  ?>
			  <script>			  
			  document.getElementById('bcc').value='';
			  </script>
			  <?php
			  }
			 else
			 {
			  $_POST[ncuentamiles]="";
			  ?>
			  <script>alert("Cuenta Incorrecta");document.form2.cuentamiles.focus();</script>
			  <?php
			  }
			 } 		
if($_POST[bccd]!='')
			 {
			  $nresul=buscacuenta($_POST[cuentamiles]);
			  if($nresul!='')
			   {
			  $_POST[ncuentamiles]=$nresul;
  			  ?>
			  <script>			  
			  document.getElementById('bcc').value='';
			  </script>
			  <?php
			  }
			 else
			 {
			  $_POST[ncuentamiles]="";
			  ?>
			  <script>alert("Cuenta Incorrecta");document.form2.cuentamiles.focus();</script>
			  <?php
			  }
			 } 			  
$oculto=$_POST['oculto'];
if($_POST[oculto])
{
?>
<div class="subpantallac">
<?php	
//sacar el consecutivo 
 $sqlr="delete from dominios  where nombre_dominio='CUENTA_MILES' ";
// echo "<div><div>sqlr:".$sqlr."</div></div>";
 if(mysql_query($sqlr,$linkbd))
  {
  $sqlr="insert into dominios (valor_inicial,valor_final,descripcion_valor,nombre_dominio,tipo,descripcion_dominio) values ('$_POST[cuentamiles]','','$_POST[ncuentamiles]','CUENTA_MILES','','Cuenta ajuste a los miles') ";
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
  echo "<table class='inicio'><tr><td class='saludo1'><center>Se han Almacenado los Parametros de Cierre Ajuste a Miles <img src='imagenes/confirm.png'></center></td></tr></table>";
  }
}
else
 {
  echo "<table class='inicio'><tr><td class='saludo1'><center>No Se han Almacenado los Parametros de Cierre: Ajuste a Miles :  - ".mysql_error($linkbd)." <img src='imagenes/alert.png'></center></td></tr></table>";
 }
 //****excedente
 $sqlr="delete from dominios  where nombre_dominio='CUENTA_EXCEDENTE' ";
// echo "<div><div>sqlr:".$sqlr."</div></div>";
 if(mysql_query($sqlr,$linkbd))
  {
  $sqlr="insert into dominios (valor_inicial,valor_final,descripcion_valor,nombre_dominio,tipo,descripcion_dominio) values ('$_POST[cuentautilidad]','','$_POST[ncuentautilidad]','CUENTA_EXCEDENTE','','Cuenta EXCEDENTE DEL EJERCICIO') ";
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
  echo "<table class='inicio'><tr><td class='saludo1'><center>Se han Almacenado los Parametros de Cierre Excedente del Ejercicio <img src='imagenes/confirm.png'></center></td></tr></table>";
  }
}
else
 {
  echo "<table class='inicio'><tr><td class='saludo1'><center>No Se han Almacenado los Parametros de Cierre: Excedente del Ejercicio :  - ".mysql_error($linkbd)." <img src='imagenes/alert.png'></center></td></tr></table>";
 }
  //****DEFICIT
 $sqlr="delete from dominios  where nombre_dominio='CUENTA_DEFICIT' ";
// echo "<div><div>sqlr:".$sqlr."</div></div>";
 if(mysql_query($sqlr,$linkbd))
  {
  $sqlr="insert into dominios (valor_inicial,valor_final,descripcion_valor,nombre_dominio,tipo,descripcion_dominio) values ('$_POST[cuentacierre]','','$_POST[ncuentacierre]','CUENTA_DEFICIT','','Cuenta DEFICIT DEL EJERCICIO') ";
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
  echo "<table class='inicio'><tr><td class='saludo1'><center>Se han Almacenado los Parametros de Cierre Deficit del Ejercicio <img src='imagenes/confirm.png'></center></td></tr></table>";
  }
}
else
 {
  echo "<table class='inicio'><tr><td class='saludo1'><center>No Se han Almacenado los Parametros de Cierre: Deficit del Ejercicio :  - ".mysql_error($linkbd)." <img src='imagenes/alert.png'></center></td></tr></table>";
 }
 ?>
 </div>
 <?php
}
?>
</table>
</body>
</html>