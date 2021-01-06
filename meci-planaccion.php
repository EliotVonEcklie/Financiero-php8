<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
//**niveles menu: Administracion (0) - Consultas (1) - Herramientas (2) - Reportes (3)
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
<title>:: Spid - Calidad</title>
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
//************* genera reporte ************
//***************************************
function guardar()
{
if (document.form2.codigo.value!='' && document.form2.nombre.value!='')
  {
	if (confirm("Esta Seguro de Guardar"))
  	{
  	document.form2.oculto.value=2;
  	document.form2.submit();
  	}
  }
  else{
  alert('Faltan datos para completar el registro');
  	document.form2.nombre.focus();
  	document.form2.nombre.select();
  }
 }

function agregardetalle()
{
if(document.form2.nombredet.value!="" )
{ 
				document.form2.agregadet.value=1;
	//			document.form2.chacuerdo.value=2;
				document.form2.submit();
 }
 else {
 alert("Falta informacion para poder Agregar");
 }
}

function eliminar(variable)
{
if (confirm("Esta Seguro de Eliminar"))
  {
document.form2.elimina.value=variable;
//eli=document.getElementById(elimina);
document.getElementById('elimina').value=variable;
//eli.value=elimina;
//vvend.value=variable;
document.form2.submit();
}
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
	<tr><script>barra_imagenes("meci");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("meci");?></tr>
        <tr>
  <td colspan="3" class="cinta"><a href="meci-varaccion.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" border="0" /></a><a href="#" onClick="guardar()" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a><a href="meci-buscavaraccion.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" border="0" /></a><a href="#" onClick="mypop=window.open('meci-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a></td>
</tr></table>
 <tr> 
 <td colspan="3"> 
 <form name="form2" method="post"> 
 <?php
    $vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
   $linkbd=conectar_bd(); 
 		if($_POST[oculto]=="")
		{
		$sqlr="Select max(id) from calvaraccion  ";
		$resp = mysql_query($sqlr,$linkbd);
	    while ($row =mysql_fetch_row($resp))
		{
			$mx=$row[0];
		}
		$_POST[codigo]=$mx+1;
		}
 
 ?>
   <table class="inicio" >
   <tr>
     <td class="titulos" colspan="4">Crear Variable Plan Accion</td><td class="cerrar" ><a href="meci-principal.php">Cerrar</a></td></tr>
   <tr><td class="saludo1">Codigo:</td><td><input name="codigo" type="text" value="<?php echo $_POST[codigo]?>" size="4"></td><td class="saludo1">Nombre</td><td><input name="nombre" value="<?php echo $_POST[nombre]?>" size="50"><input type="hidden" name="oculto" value="1"></td></tr>
   <tr>
   <td class="saludo1">Estado</td><td> <select name="estado" id="estado" onKeyUp="return tabular(event,this)" >
          <option value="S" <?php if($_POST[estado]=='S') echo "SELECTED"; ?>>Activo</option>
          <option value="N" <?php if($_POST[estado]=='N') echo "SELECTED"; ?>>Inactivo</option>
        </select></td>
   </tr>
   </table>
<table class="inicio" >
 <tr>
 <td class="titulos" colspan="6">Agregar Detalles Variable Plan Accion</td></tr>
 <tr>
 <td class="saludo1">Id:</td><td><input name="iddet" id="iddet" type="text" size="4" ></td>
 <td class="saludo1">Nombre:</td><td><input name="nombredet" id="nombredet" type="text" size="50" ></td>
 <td class="saludo1">Archivo Adjunto Obligatorio:</td><td><select name="adjuntodet" id="adjuntodet" onKeyUp="return tabular(event,this)" >
           <option value="N" <?php if($_POST[adjuntodet]=='N') echo "SELECTED"; ?>>No (N)</option>
          <option value="S" <?php if($_POST[adjuntodet]=='S') echo "SELECTED"; ?>>Si (S)</option>
        </select> <input type="button" name="agregar" id="agregar" value="   Agregar   " onClick="agregardetalle()" ><input type="hidden" value="0" name="agregadet"></td>
 </tr>
 </table>     
 <table class="inicio" >
   <tr>
    <td class="titulos" colspan="4">Detalle Variables Plan de Accion</td>
   </tr>
	<tr>
	<td class="titulos2">No</td><td class="titulos2">Nombre Variable</td><td class="titulos2">Archivo Adjunto Obligatorio</td><td class="titulos2"><img src="imagenes/del.png"><input type='hidden' name='elimina' id='elimina'></td>
   </tr>    
   <?php 
		if ($_POST[elimina]!='')
		 { 
		 $posi=$_POST[elimina];
		 //echo "<TR><TD>ENTROS :".$_POST[elimina]." $posi</TD></TR>";
		  $cuentagas=0;
		  $cuentaing=0;
		   $diferencia=0;
		  // array_splice($_POST[dcuentas],$posi, 1);
		 unset($_POST[dids][$posi]);
 		 unset($_POST[dnvars][$posi]);
		 unset($_POST[dadjs][$posi]);		 		 		 		 		 
		 $_POST[dids]= array_values($_POST[dids]); 
		 $_POST[dnvars]= array_values($_POST[dnvars]); 
		 $_POST[dadjs]= array_values($_POST[dadjs]); 
		 $_POST[elimina]='';	 		 		 		 
		 }	 
		 if ($_POST[agregadet]=='1')
		 {
		 $_POST[dids][]=$_POST[iddet];
		 $_POST[dnvars][]=$_POST[nombredet];
		 $_POST[dadjs][]=$_POST[adjuntodet]; 		 
		 $_POST[agregadet]=0;
		  ?>
		 <script>
		  		//document.form2.cuenta.focus();	
				document.form2.nombredet.value="";
				//document.form2.cuenta.select();
		  		document.form2.nombredet.focus();	
		 </script>
		<?php
		  }

		for ($x=0;$x<count($_POST[dnvars]);$x++)
		 {		 
		 echo "<tr><td class='saludo2'><input name='dids[]' value='".$_POST[dids][$x]."' type='text' size='5' readonly></td><td class='saludo2'><input name='dnvars[]' value='".$_POST[dnvars][$x]."' type='text' size='80' readonly></td><td class='saludo2'><input name='dadjs[]' value='".$_POST[dadjs][$x]."' type='text' size=3 readonly></td><td class='saludo2'><a href='#' onclick='eliminar($x)'><img src='imagenes/del.png'></a></td></tr>";
		 }
		  ?>
                 
  </table>      
 <?php  
 //********guardar
 if($_POST[oculto]=="2")
	{
	$sqlr="insert into calvaraccion (nombre,estado) values ('$_POST[nombre]','$_POST[estado]') ";	
	if (!mysql_query($sqlr,$linkbd))
		{
		 echo "<script>alert('ERROR EN LA CREACION DE LA VARIABLE DEL PLAN DE ACCION');document.form2.nombre.focus();</script>";
		 echo $sqlr;
		}
		  else
		  {
			$nid=mysql_insert_id($linkbd);
		   echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha almacenado la Variable del Plan de Accion con Exito <img src='imagenes\confirm.png'></center></td></tr></table>";
		   for ($x=0;$x<count($_POST[dnvars]);$x++)
		 	{
			 $sqlr="insert into calvaraccion_det (id_varaccion, nombre,id_det, adjunto,estado) values ($nid, '".$_POST[dnvars][$x]."','".$_POST[dids][$x]."','".$_POST[dadjs][$x]."','S') ";	
			 mysql_query($sqlr,$linkbd);
			}
		  }
	}
 ?>
 </form>       
 </td>       
 </tr>       
	</table>
</body>
</html>