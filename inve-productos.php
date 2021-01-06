<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require "funciones.inc";
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
<title>:: Spid - Almacen</title>
<script >
function validar()
{
//document.form2.action="contra-terceros.php";
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

if (document.form1.precodigo.value!='' && document.form1.codigo.value!='' && document.form1.ncodigo.value!='')
  {
	if (confirm("Esta Seguro de Guardar"))
  	{
  	document.form1.oculto.value=2;
  	document.form1.submit();
  	}
  }
  else{
  alert('Faltan datos para completar');
  	document.form1.codigo.focus();
  	document.form1.codigo.select();
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
    <tr><script>barra_imagenes("inve");</script><?php cuadro_titulos();?></tr>	 
    <tr><?php menu_desplegable("inve");?></tr>
    <tr>
  <td colspan="3" class="cinta"><a href="inve-productos.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" border="0" /></a><a href="#"  onClick="guardar();" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a><a href="inve-buscaarticulos.php" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a><a href="#" onClick="mypop=window.open('inve-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a></td>
</tr>		  
</table>
<tr><td colspan="3" class="tablaprin" align="center"> 

<form name="form1" method="post">
 <table class="inicio" >
 <tr>
 <td colspan="4" class="titulos">Crear Productos y Servicios</td>
 <td class="cerrar" ><a href="inve-articulos.php">Cerrar</a></td></tr>
<tr><td class="saludo1"><?php $dominio='UNSPSC' ; $clasificacion=buscadominiov2($dominio,'1'); echo strtoupper($clasificacion);?></td><td>
<select name="grupo" onChange="validar()">
<option value=''>Seleccione ...</option>
 <?php
		   $linkbd=conectar_bd();
		   $sqlr="Select * from productospaa  where tipo='1'  and estado='S' order by tipo,codigo asc";
			// echo $sqlr;
		 		$resp = mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=$row[0];
				echo "<option value=$row[0] ";
				if($i==$_POST[grupo])
			 	{
				 echo "SELECTED";
				 }
				echo " >".$row[0]." - ".substr($row[1],0,80)."</option>";	  
			     }			
		  ?>
</select>
</td>
<td class="saludo1"><?php $dominio='UNSPSC' ; $clasificacion=buscadominiov2($dominio,'2'); echo strtoupper($clasificacion);?></td><td>
<select name="segmento" onChange="validar()">
<option value=''>Seleccione ...</option>
 <?php
		   $linkbd=conectar_bd();
		   $sqlr="Select * from productospaa  where tipo='2' and padre='$_POST[grupo]' and estado='S' order by tipo,codigo asc";
			// echo $sqlr;
		 		$resp = mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=$row[0];
				echo "<option value=$row[0] ";
				if($i==$_POST[segmento])
			 	{
				 echo "SELECTED";
				 }
				echo " >".$row[0]." - ".substr($row[1],0,80)."</option>";	  
			     }			
		  ?>
</select>
</td></tr>
<tr><td class="saludo1"><?php $dominio='UNSPSC' ; $clasificacion=buscadominiov2($dominio,'3'); echo strtoupper($clasificacion);?></td><td>
<select name="familia" onChange="validar()">
<option value=''>Seleccione ...</option>
 <?php
		   $linkbd=conectar_bd();
		   $sqlr="Select * from productospaa  where tipo='3' and padre='$_POST[segmento]' and estado='S' order by tipo,codigo asc";
			// echo $sqlr;
		 		$resp = mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=$row[0];
				echo "<option value=$row[0] ";
				if($i==$_POST[familia])
			 	{
				 echo "SELECTED";
				 }
				echo " >".$row[0]." - ".substr($row[1],0,80)."</option>";	  
			     }			
		  ?>
</select>
</td><td class="saludo1"><?php $dominio='UNSPSC' ; $clasificacion=buscadominiov2($dominio,'4'); echo strtoupper($clasificacion);?></td><td>
<select name="clases" onChange="validar()">
<option value=''>Seleccione ...</option>
		 <?php
		   $linkbd=conectar_bd();
		   $sqlr="Select * from productospaa  where tipo='4' and padre='$_POST[familia]' and estado='S' order by tipo,codigo asc";
			// echo $sqlr;
		 		$resp = mysql_query($sqlr,$linkbd);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=$row[0];
				echo "<option value=$row[0] ";
				if($i==$_POST[clases])
			 	{
				 echo "SELECTED";
				 $_POST[precodigo]=substr($_POST[clases],0,(strlen($_POST[clases])-2));
				 } 				 
				echo " >".$row[0]." - ".substr($row[1],0,80)."</option>";	  
			     }			
		  ?>
</select>
</td></tr>
 <tr><td class="saludo1">Pre-Codigo:</td><td>
 <input type="text" size='6'  name="precodigo" value="<?php echo $_POST[precodigo]?>" readonly> <input type="text" size='2'  name="codigo" value="<?php echo $_POST[codigo]?>" onBlur="documen.form1.submit()" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" maxlength="2"> </td><td class="saludo1">Nombre Producto</td><td><input type="text" size='70'  name="ncodigo" value="<?php echo $_POST[ncodigo]?>"><input name="oculto" type="hidden" value="1"> 
  <?php
  $linkbd=conectar_bd();
  $prec=$_POST[precodigo].''.$_POST[codigo];
  $sqlr="Select count(*) from productospaa  where tipo='5' and codigo='$prec' and estado='S' ";
			 //echo $sqlr;
		 		$resp = mysql_query($sqlr,$linkbd);		
				while ($row =mysql_fetch_row($resp)) 
				{
				 $c=$row[0];
				}
 if ($c>=1)
  {
	?>
    <script>
    alert("EL codigo "+<?php echo $prec ?>+" ya esta asignado a otro producto");
	document.form1.codigo.value='';
	document.form1.codigo.focus();
    </script>
    <?php  
  }
 ?>
 </td></tr>
 </table>
 <?php
 if($_POST[oculto]=='2')
  {	 
  $prec=$_POST[precodigo].''.$_POST[codigo];		  
  $linkbd=conectar_bd();
  $sqlr="insert into productospaa  (codigo,nombre,tipo,padre,estado,sistema) values('$prec','$_POST[ncodigo]','5','$_POST[precodigo]','S','N')";
 if(!mysql_query($sqlr,$linkbd))
		 {
		  echo "<table class='inicio'><tr><td class='saludo1'><center>No Se ha Almacenado el Producto, <img src='imagenes\alert.png'> Error:".mysql_error()."</center></td></tr></table>";
		 }
		 else
		 {
		  echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha Almacenado con Exito el Producto $prec - $_POST[ncodigo] <img src='imagenes\confirm.png'></center></td></tr></table>";
		 }
  }
 ?>
 </form>
  </td></tr>
<tr><td></td></tr>      
</table>
</body>
</html>