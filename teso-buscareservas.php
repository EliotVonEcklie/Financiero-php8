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
function redirecciona(id){
	window.location.href ='teso-reservasver.php?id='+id;
}
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
//************* genera reporte ************
//***************************************
function eliminar(idr)
{
	if (confirm("Esta Seguro de Eliminar el Recaudo Transferencia "+idr))
  	{
  	document.form2.oculto.value=2;
  	document.form2.var1.value=idr;
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
		<td colspan="3" class="cinta">
			<a href="teso-reservas.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a>
			<a class="mgbt"><img src="imagenes/guardad.png"/></a>
			<a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a>
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
		</td>
	</tr>	
</table>
<form name="form2" method="post" action="teso-buscareservas.php">
	<table  class="inicio" align="center" >
		<tr >
			<td class="titulos" colspan="6">:. Buscar Reservas</td>
			<td width="70" class="cerrar" ><a href="teso-principal.php"> Cerrar</a></td>
		</tr>
		<tr >
			<td width="10" class="saludo1">Numero Reserva:</td>
			<td width="154" >
				<input name="numero" type="text" value="" >
			</td>
			<input name="oculto" type="hidden" value="1">
			<input name="var1" type="hidden" value=<?php echo $_POST[var1];?>>
        </tr>                       
    </table>    
    <div class="subpantallap" style="height:68.5%; width:99.6%; overflow-x:hidden;">
    
    
    <?php
		$oculto=$_POST['oculto'];
		$linkbd=conectar_bd();
		$crit1=" ";
		$crit2=" ";
		if ($_POST[numero]!="")
		$crit1=" and pptoreservas.consvigencia  like '%".$_POST[numero]."%'";
		$sqlr="select * from pptoreservas where pptoreservas.consvigencia>-1 ".$crit1." order by pptoreservas.consvigencia desc";
		// echo "<div><div>sqlr:".$sqlr."</div></div>";
		$resp = mysql_query($sqlr,$linkbd);
		$ntr = mysql_num_rows($resp);
		$con=1;

		echo "
		<table class='inicio' align='center' >
			<tr>
				<td colspan='8' class='titulos'>.: Resultados Busqueda:</td>
			</tr>
			<tr>
			<td colspan='2'>Recaudos Encontrados: $ntr</td>
			</tr>
			<tr>
				<td class='titulos2' style='width:8%'>Consecutivo</td>
				<td class='titulos2'>Objeto</td>
				<td class='titulos2' style='width:8%'>Fecha</td>
				<td class='titulos2' style='width:10%'>Valor</td>
				<td class='titulos2' style='width:8%'>Estado</td>
				<td class='titulos2' >Ver</td>
			</tr>";	
		//echo "nr:".$nr;
		$iter='zebra1';
		$iter2='zebra2';
		while ($row =mysql_fetch_row($resp)) 
		{
			$nter=buscatercero($row[7]);
			if($row[4]=='S'){$imgsem="src='imagenes/sema_verdeON.jpg' title='Activo'"; 	}			  
			if($row[4]=='N'){$imgsem="src='imagenes/sema_rojoON.jpg' title='Anulado'";}	
			echo "<tr class='$iter' onDblClick='redirecciona($row[1])'>
					<td>$row[1]</td>
					<td>$row[5]</td>
					<td>$row[2]</td>
					<td style='text-align:right;'>".number_format($row[3],2)."</td>
					<td style='text-align:center;'><img $imgsem style='width:18px'/></td>
					<td><a href='teso-reservasver.php?id=$row[1]'><center><img src='imagenes/buscarep.png'></center></a></td>
				</tr>";
			$con+=1;
			$aux=$iter;
			$iter=$iter2;
			$iter2=$aux;
		}
		echo"</table>";
		
?></div>
</form> 
</body>
</html>