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
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: SPID - Tesoreria</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js"></script>
        <script type="text/javascript" src="css/calendario.js"></script>
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
function buscacta(e)
 {
if (document.form2.cuenta.value!="")
{
 document.form2.bc.value='1';
 document.form2.submit();
 }
 }
function validar()
{
document.form2.submit();
}
function buscater(e)
 {
if (document.form2.tercero.value!="")
{
 document.form2.bt.value='1';
 document.form2.submit();
 }
 }
function agregardetalle()
{
if(document.form2.numero.value!="" &&  document.form2.valor.value>0 &&  document.form2.banco.value!=""  )
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
vvend=document.getElementById('elimina');
//eli.value=elimina;
vvend.value=variable;
document.form2.submit();
}
}
//************* genera reporte ************
//***************************************
function guardar()
{

if (document.form2.fecha.value!='')
  {
	if (confirm("Esta Seguro de Guardar"))
  	{
  	document.form2.oculto.value=2;
  	document.form2.submit();
  	}
  }
  else{
  alert('Faltan datos para completar el registro');
  	document.form2.fecha.focus();
  	document.form2.fecha.select();
  }
}
function pdf()
{
document.form2.action="teso-pdfconsignaciones.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
}
</script>
<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
	<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("teso");?></tr>
<tr>
  <td colspan="3" class="cinta"><a href="teso-pagonomina.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a><a class="mgbt"><img src="imagenes/guardad.png"/></a><a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a><a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td></tr>	
</table>
 <form name="form2" method="post" action="teso-buscapagonomina-rg.php">
<table  class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="6">:. Buscar Pagos Nomina</td>
        <td width="139" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
      </tr>
      <tr >
        <td width="162" class="saludo1">Numero Pago:</td>
        <td ><input name="numero" type="text" value="" >
        </td>
         <td width="131" class="saludo1">Detalle Pago: </td>
    <td ><input name="nombre" type="text" value="" size="80" ></td>
  
	   
          <input name="oculto" type="hidden" value="1">
        </tr>                       
    </table>    
    <div class="subpantallap" style="height:68.5%; width:99.6%; overflow-x:hidden;">
      <?php
$oculto=$_POST['oculto'];
if($_POST[oculto])
{
$linkbd=conectar_bd();
$crit1=" ";
$crit2=" ";
if ($_POST[numero]!="")
$crit1=" and tesoegresosnomina.id_egreso like '%".$_POST[numero]."%' ";
if ($_POST[nombre]!="")
$crit2=" and tesoegresosnomina.concepto like '%".$_POST[nombre]."%'  ";
//sacar el consecutivo 
//$sqlr="select *from pptosideforigen where".$crit1.$crit2." order by pptosideforigen.codigo";
	$sqlr="select *from tesoegresosnomina where tesoegresosnomina.id_egreso>-1 ".$crit1.$crit2." order by tesoegresosnomina.id_egreso DESC";
//echo "<div><div>sqlr:".$sqlr."</div></div>";
$resp = mysql_query($sqlr,$linkbd);
$ntr = mysql_num_rows($resp);
$con=1;
echo "<table class='inicio' align='center' ><tr><td colspan='11' class='titulos'>.: Resultados Busqueda:</td></tr><tr><td colspan='3'>Pagos Encontrados: $ntr</td></tr><tr><td  class='titulos2'>Egreso</td><td  class='titulos2'>Nomina</td><td class='titulos2'>Nombre</td><td class='titulos2'>Fecha</td><td class='titulos2'>Banco</td><td class='titulos2'>Cuenta</td><td class='titulos2'>Valor</td><td class='titulos2'>Concepto</td><td class='titulos2' width='5%'><center>Estado</td><td class='titulos2' width='5%'><center>Anular</td><td class='titulos2' width='5%'><center>Editar</td></tr>";	
//echo "nr:".$nr;
$iter='saludo1a';
$iter2='saludo2';
 while ($row =mysql_fetch_row($resp)) 
 {
	 $ntr=buscatercero($row[11]);
	 $banco=buscatercero(buscabanco($row[9]));
	 echo "<tr class='$iter'><td>$row[0]</td><td>$row[2]</td><td>$ntr</td><td>$row[3]</td><td>$banco</td><td>$row[12]</td><td>".number_format($row[7],2)."</td><td>".strtoupper($row[8])."</td><td>".strtoupper($row[13])."</td><td style='text-align:center;'><a href='teso-pagonominaver-regrabar.php?idegre=$row[0]'><img src='imagenes/anular.png'></a></td><td style='text-align:center;'><a href='teso-pagonominaver-regrabar.php?idegre=$row[0]'><img src='imagenes/b_edit.png' style='width:18px' title='Editar'></a></td></tr>";
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