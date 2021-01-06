<?php
require"comun.inc";
require"funciones.inc";
session_start();
cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
//**niveles menu: Administracion (0) - Consultas (1) - Herramientas (2) - Reportes (3)
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<title>:: SieS - Activos Fijos</title>
<script>
//************* ver reporte ************
function verep(idfac)
{document.form1.oculto.value=idfac;document.form1.submit();}
//************* genera reporte ************
function genrep(idfac)
{document.form2.oculto.value=idfac;document.form2.submit();}
//************* genera reporte ************
function guardar()
{
if (document.form2.documento.value!='')
  {
	if (confirm("Esta Seguro de Guardar"))
  	{document.form2.oculto.value=2;document.form2.submit();}
  }
  else{alert('Faltan datos para completar el registro');}
 }

function validar(formulario)
{document.form2.action="presu-buscaconcecontablesconpes.php";document.form2.submit();}

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
<script type="text/javascript" src="css/programas.js"></script>
<link href="css/css2.css" rel="stylesheet" type="text/css" />
<link href="css/css3.css" rel="stylesheet" type="text/css" />
<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
	<tr><script>barra_imagenes("acti");</script><?php cuadro_titulos();?></tr>
    <tr><?php menu_desplegable("acti");?></tr>
	<tr>
		<td colspan="3" class="cinta">
			<a href="acti-clasificacion.php	" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a>
			<a class="mgbt"><img src="imagenes/guardad.png" title="Guardar" /></a>
			<a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" onClick="mypop=window.open('acti-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="nueva ventana"></a>
		</td>
	</tr>	
</table>
<form name="form2" method="post" action="acti-buscaclasificacion.php">
<table  class="inicio" align="center" >
	<tr >
        <td class="titulos" colspan="4">:: Buscar Clasificacion </td>
        <td class="cerrar" ><a href="acti-principal.php">Cerrar</a></td>
	</tr>
	<tr >
		<td class="saludo1">Codigo:</td>
        <td><input name="documento" type="text" id="documento" value="" size="2" maxlength="2"></td>
		<td class="saludo1">Nombre:</td>
        <td><input name="nombre" type="text" value="" size="40"><input name="oculto" type="hidden" value="1"> </td>
	</tr>                       
</table>    
</form>
<div class="subpantallac5">
	<?php
	$oculto=$_POST['oculto'];
	if($_POST[oculto])
	{
		$linkbd=conectar_bd();
		$crit1=" ";
		$crit2=" ";
		if ($_POST[nombre]!="")
			$crit1=" and acticlasificacion.nombre like '%".$_POST[nombre]."%' ";
		if ($_POST[documento]!="")
			$crit2=" and acticlasificacion.codigo like '%$_POST[documento]%' ";
			$sqlr="select *from acticlasificacion  where acticlasificacion.estado<>'' ".$crit1.$crit2." order by acticlasificacion.codigo";
			//echo $sqlr;
		$resp = mysql_query($sqlr,$linkbd);
		$ntr = mysql_num_rows($resp);
		$con=1;
		echo "<table class='inicio' align='center' width='80%'><tr><td colspan='8' class='titulos'>.: Resultados Busqueda:</td></tr><tr><td colspan='5'>Concepto Contable Causacion Encontrados: $ntr</td></tr><tr><td width='5%' class='titulos2'>Codigo</td><td class='titulos2' width='85%'>Nombre</td><td class='titulos2'>No Deprecia</td><td class='titulos2'>A&ntilde;os Depreciacion</td><td class='titulos2'>Estado</td><td class='titulos2' width='5%'>Editar</td></tr>";	
		$iter='saludo1';
		$iter2='saludo2';
		while ($row =mysql_fetch_row($resp)) 
		{
			echo "<tr ><td class='$iter'>".strtoupper($row[0])."</td><td class='$iter'>".strtoupper($row[1])."</td><td class='$iter'>$row[2]</td><td class='$iter'>$row[3]</td><td class='$iter'>$row[4]</td><td class='$iter'><a href='acti-editarclasificacion.php?is=$row[0]'><center><img src='imagenes/buscarep.png'></center></a></td></tr>";
			$con+=1;
			$aux=$iter;
			$iter=$iter2;
			$iter2=$aux;
		}
		echo"</table>";
	}
	?>
</div>
<br><br>
</body>
</html>