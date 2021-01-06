<?php //V 1000 12/12/16 ?> 
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
        <meta http-equiv="X-UA-Compatible" content="IE=9"/><title>:: SieS - Presupuesto</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css"/>
        <link href="css/css3.css" rel="stylesheet" type="text/css"/>
        <script type="text/javascript" src="css/programas.js"></script>
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
if (document.form2.documento.value!='')
  {
	if (confirm("Esta Seguro de Guardar"))
  	{
  	document.form2.oculto.value=2;
  	document.form2.submit();
  	}
  }
  else{
  alert('Faltan datos para completar el registro');
  }
 }
function validar(formulario)
{
document.form2.action="presu-buscaconcecontablescausa.php";
document.form2.submit();
}
function cleanForm()
{
document.form2.nombre1.value="";
document.form2.nombre2.value="";
document.form2.apellido1.value="";
document.form2.apellido2.value="";
document.form2.documento.value="";
document.form2.codver.value="";
document.form2.telefono.value="";
document.form2.direccion.value="";
document.form2.email.value="";
document.form2.web.value="";
document.form2.celular.value="";
document.form2.razonsocial.value="";
}
</script>
		<?php titlepag();?>
    </head>
    <body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("presu");?></tr>
       	 	<tr>
          		<td colspan="3" class="cinta"><a href="presu-concecontablesing.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a><a class="mgbt"><img src="imagenes/guardad.png"/></a><a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a><a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
          	</tr>
          </table>	
 <form name="form2" method="post" action="presu-buscaconcecontablesing.php">
<table  class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="4">:: Buscar Concepto Contable Ingreso </td>
        <td class="cerrar" ><a href="presu-principal.php">X Cerrar</a></td>
      </tr>
      <tr >
         <td class="saludo1">Codigo:
        </td>
        <td><input name="documento" type="text" id="documento" value="" size="2" maxlength="2">
		</td>
		<td class="saludo1">Nombre:</td>
        <td><input name="nombre" type="text" value="" size="40">
        <input name="oculto" type="hidden" value="1"> </td>
          <td><center><a href="presu-concecontables.php">Volver Menu</a></center></td>
       </tr>                       
    </table>    
    <div class="subpantalla" style="height:68.5%; width:99.6%; overflow-x:hidden;">
      <?php
$oculto=$_POST['oculto'];
if($_POST[oculto])
{
$linkbd=conectar_bd();
$crit1=" ";
$crit2=" ";
if ($_POST[nombre]!="")
$crit1=" and conceptoscontables.nombre like '%".$_POST[nombre]."%' ";
if ($_POST[documento]!="")
$crit2=" and conceptoscontables.codigo like '%$_POST[documento]%' ";
//sacar el consecutivo 
//$sqlr="select *from pptosideforigen where".$crit1.$crit2." order by pptosideforigen.codigo";
 
	$sqlr="select *from conceptoscontables where conceptoscontables.tipo='I' and conceptoscontables.modulo='3'".$crit1.$crit2." order by conceptoscontables.codigo";
$resp = mysql_query($sqlr,$linkbd);
$ntr = mysql_num_rows($resp);
$con=1;
echo "<table class='inicio' align='center' width='80%'><tr><td colspan='8' class='titulos'>.: Resultados Busqueda:</td></tr><tr><td colspan='5'>Concepto Contable Causacion Encontrados: $ntr</td></tr><tr><td width='5%' class='titulos2'>Codigo</td><td class='titulos2'>Nombre</td><td class='titulos2' width='5%'>Editar</td></tr>";	
//echo "nr:".$nr;
$iter='saludo1';
$iter2='saludo2';
 while ($row =mysql_fetch_row($resp)) 
 {
	 echo "<tr ><td class='$iter'>".strtoupper($row[0])."</td><td class='$iter'>".strtoupper($row[1])."</td><td class='$iter'><a href='presu-editaconcecontablesing.php?is=$row[0]'><center><img src='imagenes/buscarep.png'></center></a></td></tr>";
	 $con+=1;
	 $aux=$iter;
	 $iter=$iter2;
	 $iter2=$aux;
 }
 echo"</table>";
}
?></div>
 </form>
</body>
</html>