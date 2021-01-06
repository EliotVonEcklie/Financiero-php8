<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: Spid - Tesoreria</title>
        <script type="text/javascript" src="css/programas.js"></script>
		<script type="text/javascript" src="css/calendario.js"></script>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
		<link href="css/css3.css" rel="stylesheet" type="text/css" />
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
//************* genera reporte ************
//***************************************
function eliminar(idr)
{
	if (confirm("Esta Seguro de Eliminar la liquidacion No "+idr))
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
      <td colspan="3" class="cinta"><a href="teso-egreso.php" accesskey="n" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a><a class="mgbt"><img src="imagenes/guardad.png"/></a><a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a><a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td></tr>	
    </table>
 <form name="form2" method="post" action="teso-buscaegreso-rg.php">
<table  class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="6">:. Buscar Liquidaciones CxP</td>
        <td width="139" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
      </tr>
      <tr >
        <td width="162" class="saludo1">Numero Orden:</td>
        <td ><input name="numero" type="text" value="" >
        </td>
         <td width="131" class="saludo1">Detalle Orden: </td>
    <td ><input name="nombre" type="text" value="" size="80" ></td>
  
	          <input name="oculto" type="hidden" value="1"><input name="var1" type="hidden" value=<?php echo $_POST[var1];?>>
        </tr>                       
    </table>   
    <script>
    document.form2.numero.focus();
	    document.form2.numero.select();
    </script>
     <div class="subpantallap" style="height:68.5%; width:99.6%; overflow-x:hidden;">
      <?php
	  $vigusu=vigencia_usuarios($_SESSION[cedulausu]);
		$_POST[vigencia]=$vigusu;
$oculto=$_POST['oculto'];
	$oculto=$_POST['oculto'];
	if($_POST[oculto]==2)
	{
	 $linkbd=conectar_bd();	
	 $sqlr="select * from tesoordenpago where id_orden=$_POST[var1]";
	 $resp = mysql_query($sqlr,$linkbd);
	 $row=mysql_fetch_row($resp);
	 $rpe=$row[4];
	 $vpa=$row[10];
	 $nop=$row[0];
	 $vigop=$row[3];
	 //********Comprobante contable en 000000000000
	  $sqlr="update comprobante_cab set total_debito=0,total_credito=0,estado='0' where tipo_comp='11' and numerotipo=$row[0]";
	  mysql_query($sqlr,$linkbd);
	  $sqlr="update comprobante_det set valdebito=0,valcredito=0 where id_comp='11 $row[0]'";
	  mysql_query($sqlr,$linkbd);
	 //********PREDIAL O RECAUDO SE ACTIVA COLOCAR 'S'
	  $sqlr="select * from tesoordenpago_det where id_orden=$nop";
  	  $resp=mysql_query($sqlr,$linkbd);
	  while($r=mysql_fetch_row($resp))
	   {
		$sqlr="update pptorp_detalle set saldo=saldo+$r[4] where cuenta='$r[2]' and vigencia='".$vigop."' and consvigencia=$rpe";
		mysql_query($sqlr,$linkbd);
		//	echo "<br>".$sqlr;
	   }	
	   $sqlr="update tesoordenpago  set estado='N' where id_orden=$_POST[var1]";
	  mysql_query($sqlr,$linkbd);	 
	  $sqlr="update pptorp set saldo=saldo+$vpa where vigencia='".$vigop."' and consvigencia=$rpe";
	  mysql_query($sqlr,$linkbd);	 
	}   
//****** 	
if($_POST[oculto])
{
$linkbd=conectar_bd();
$crit1=" ";
$crit2=" ";
if ($_POST[numero]!="")
$crit1=" and tesoordenpago.id_orden like '%".$_POST[numero]."%' ";
if ($_POST[nombre]!="")
$crit2=" and tesoordenpago.conceptorden like '%".$_POST[nombre]."%'  ";
//sacar el consecutivo 
//$sqlr="select *from pptosideforigen where".$crit1.$crit2." order by pptosideforigen.codigo";
	$sqlr="select *from tesoordenpago where tesoordenpago.id_orden>-1 ".$crit1.$crit2." order by tesoordenpago.id_orden DESC";
//echo "<div><div>sqlr:".$sqlr."</div></div>";
$resp = mysql_query($sqlr,$linkbd);
$ntr = mysql_num_rows($resp);
$con=1;
echo "<table class='inicio' align='center' width='99%'><tr><td colspan='9' class='titulos'>.: Resultados Busqueda:</td></tr><tr><td colspan='8'>Liquidaciones Encontrados: $ntr</td></tr><tr><td class='titulos2' width='2%'>Item</td><td class='titulos2' >VIGENCIA</td><td class='titulos2' >N RP</td><td class='titulos2' >DETALLE</td><td class='titulos2' >VALOR</td><td class='titulos2' >FECHA</td><td class='titulos2' width='4%'>ESTADO</td><td class='titulos2'>Anular</td><td class='titulos2'>Ver</td></tr>";	
//echo "nr:".$nr;
$iter='zebra1';
$iter2='zebra2';
 while ($row =mysql_fetch_row($resp)) 
 {
 $detalle=$row[2];
 $ntr=buscatercero($row[11]);
 	 	if ($row[13]=='S')
		$imagen="src='imagenes/confirm.png' title='Activo'";
		if ($row[13]=='P')
		$imagen="src='imagenes/dinero3.png' title='Pago'";
		if ($row[13]=='N')
		$imagen="src='imagenes/cross.png' title='Anulado'";
	 echo "<tr class='$iter'><td>$row[0]</td><td>".strtoupper($row[3])."</td><td>".strtoupper($row[4])."</td><td>".strtoupper($row[7])."</td><td>".number_format($row[10],2)."</td><td>".$row[2]."</td><td style='text-align:center;'><img $imagen style='width:16px'></td>";
	 	 if ($row[13]=='S')
	 echo "<td style='text-align:center;'><a href='#' onClick=eliminar($row[0])><img src='imagenes/anular.png'></a></td>";
	 if ($row[13]=='P' || $row[13]=='N')
	 echo "<td></td>";
	 echo "<td style='text-align:center;'><a href='teso-egreso-regrabar.php?idop=$row[0]'><img src='imagenes/buscarep.png'></a></td></tr>";
	 $con+=1;
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