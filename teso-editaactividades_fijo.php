<?php //V 1000 12/12/16 ?> 
<?php
require"comun.inc";
require"funciones.inc";
session_start();
cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
//**niveles menu: Administracion (0) - Consultas (1) - Herramientas (2) - Reportes (3)
 	$linkbd=conectar_bd();
	$scroll=$_GET['scrtop'];
	$totreg=$_GET['totreg'];
	$idcta=$_GET['idcta'];
	$altura=$_GET['altura'];
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<title>:: SPID - Contabilidad</title>

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
<script type="text/javascript" src="css/programas.js"></script>
<link href="css/css2.css" rel="stylesheet" type="text/css" />
<link href="css/css3.css" rel="stylesheet" type="text/css" />
		<script>
			function iratras(scrtop, numpag, limreg){
				var idcta=document.getElementById('codigo').value;
				location.href="teso-buscaactividades_fijo.php?idcta="+idcta+"&scrtop="+scrtop+"&numpag="+numpag+"&limreg="+limreg;
			}
		</script>
<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
        <?php
		$numpag=$_GET[numpag];
		$limreg=$_GET[limreg];
		$scrtop=26*$totreg;
		?>
<table>
    <tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
    <tr><?php menu_desplegable("teso");?></tr>
<tr>
  <td colspan="3" class="cinta"><a href="teso-actividades_fijo.php" ><img src="imagenes/add.png"  alt="Nuevo" /></a> <a href="#"  onClick="document.form2.submit();"><img src="imagenes/guarda.png" alt="Guardar" /></a><a href="teso-buscaactividades_fijo.php"> <img src="imagenes/busca.png" alt="Buscar" /></a><a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" alt="nueva ventana"></a><a href="#" onClick="iratras(<?php echo $scrtop; ?>, <?php echo $numpag; ?>, <?php echo $limreg; ?>)" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a></td></tr>
	</table>
<tr><td colspan="3" class="tablaprin"> 
<?php
if(!$_POST[oculto])
{
$linkbd=conectar_bd();
$sqlr="Select *from codigosciiu_fijos where codigo='$_GET[idtipocom]'";
$res=mysql_query($sqlr,$linkbd);
//echo $sqlr;
while($row=mysql_fetch_row($res))
  {
   $_POST[codigo]=$row[0];
   $_POST[nombre]=$row[1];
   $_POST[porcentaje]=$row[2];
  }
}
?>
 <form name="form2" method="post" action="teso-editaactividades_fijo.php">
    <table class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="5">.: Editar Actividades Valor Fijo</td><td class="cerrar"><a href="teso-principal.php">Cerrar</a></td>
      </tr>
      <tr  >
	    <td>Codigo:
        </td>
        <td><input name="codigo" id="codigo" type="text" value="<?php echo $_POST[codigo]?>" size="2" maxlength="2" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)">
        </td>
        <td>Nombre:
        </td>
        <td><input name="nombre" type="text" value="<?php echo $_POST[nombre]?>" size="80"  onKeyUp="return tabular(event,this)">
        </td>
        <td>Activo:
        </td>
        <td><input name="porcentaje" id="porcentaje" type="text" value="<?php echo $_POST[porcentaje]?>" > <input name="oculto" type="hidden" value="1">  <input name="idcomp" type="hidden" value="<?php echo $_POST[idcomp]?>" >   </td>
       </tr>  
	   <tr><td></td></tr>                  
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
 $sqlr="update codigosciiu_fijos set nombre='".$_POST[nombre]."',porcentaje=$_POST[porcentaje],codigo='$_POST[codigo]' where codigo='$_POST[codigo]'";
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
  echo "<table><tr><td class='saludo1'><center><h2>Se ha actualizado con Exito</h2></center></td></tr></table>";
  }
 }
else
 {
  echo "<table><tr><td class='saludo1'><center><H2>Falta informacion para Crear el Comprobante</H2></center></td></tr></table>";
 }
}
?> </td></tr>
<tr><td></td></tr>      
</table>
</body>
</html>