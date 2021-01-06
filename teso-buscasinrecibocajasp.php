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
//************* genera reporte ************
//***************************************
function eliminar(idr)
{
	if (confirm("Esta Seguro de Eliminar el Recibo de Caja"))
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
  <td colspan="3" class="cinta"><a href="teso-sinrecibocajasp.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a><a class="mgbt"><img src="imagenes/guardad.png"/></a><a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a><a href="#" class="mgbt" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td></tr>	
  </table>
 <form name="form2" method="post" action="teso-buscasinrecibocajasp.php">
<table  class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="6">:. Buscar Ingresos Servicios</td>
        <td width="70" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
      </tr>
      <tr >
        <td width="168" class="saludo1">Numero Liquidacion:</td>
        <td width="154" ><input name="numero" type="text" value="" >
        </td>
         <td width="144" class="saludo1">Concepto Liquidacion: </td>
    <td width="498" ><input name="nombre" type="text" value="" size="80" ></td>
          <input name="oculto" type="hidden" value="1"><input name="var1" type="hidden" value=<?php echo $_POST[var1];?>>
        </tr>                       
    </table>    
    <div class="subpantallap" style="height:68.5%; width:99.6%; overflow-x:hidden;">
   <?php
	$oculto=$_POST['oculto'];
	if($_POST[oculto]==2)
	{
	 $linkbd=conectar_bd();	
	 $sqlr="select * from tesosinreciboscajasp where id_recibos=$_POST[var1]";
	 $resp = mysql_query($sqlr,$linkbd);
	 $row=mysql_fetch_row($resp);
	 //********Comprobante contable en 000000000000
	  $sqlr="update comprobante_cab set total_debito=0,total_credito=0,estado='0' where tipo_comp='30' and numerotipo=$row[0]";
	  mysql_query($sqlr,$linkbd);
	  $sqlr="update comprobante_det set valdebito=0,valcredito=0 where id_comp='30 $row[0]'";
	  mysql_query($sqlr,$linkbd);
	   $sqlr="update pptocomprobante_cab set estado='0' where tipo_comp='23' and numerotipo=$row[0]";
	  mysql_query($sqlr,$linkbd);
	 //********PREDIAL O RECAUDO SE ACTIVA COLOCAR 'S'
	  
	  if($row[10]=='3')
	   {
 	  $sqlr="update tesosinrecaudossp set estado='S' where id_recaudo=$row[4]";
	  mysql_query($sqlr,$linkbd);
	   } 
	 //******** RECIBO DE CAJA ANULAR 'N'	 
	  $sqlr="update tesosinreciboscajasp set estado='N' where id_recibos=$row[0]";
	  mysql_query($sqlr,$linkbd);
	  $sqlr="select * from pptosinrecibocajappto where idrecibo=$row[0]";
  	  $resp=mysql_query($sqlr,$linkbd);
	  while($r=mysql_fetch_row($resp))
	   {
		$sqlr="update pptocuentaspptoinicial set ingresos=ingresos-$r[3] where cuenta='$r[1]'";
		mysql_query($sqlr,$linkbd);
	   }	
	   $sqlr="delete from pptosinrecibocajappto where idrecibo=$row[0]";
  	  $resp=mysql_query($sqlr,$linkbd); 
	}
   ?>
      <?php
$oculto=$_POST['oculto'];
if($_POST[oculto])
{
$linkbd=conectar_bd();
$crit1=" ";
$crit2=" ";
if ($_POST[numero]!="")
$crit1=" and tesosinreciboscajasp.id_recibos like '%".$_POST[numero]."%' ";
if ($_POST[nombre]!="")
{//$crit2=" and tesorecaudos.concepto like '%".$_POST[nombre]."%'  ";}
}
	$sqlr="select *from tesosinreciboscajasp where tesosinreciboscajasp.estado<>'' ".$crit1.$crit2." order by tesosinreciboscajasp.id_recibos DESC";
	// echo "<div><div>sqlr:".$sqlr."</div></div>";
	$resp = mysql_query($sqlr,$linkbd);
$ntr = mysql_num_rows($resp);
$con=1;

echo "<table class='inicio' align='center' ><tr><td colspan='10' class='titulos'>.: Resultados Busqueda:</td></tr><tr><td colspan='2'>Recibos de Caja Encontrados: $ntr</td></tr><tr><td width='150' class='titulos2'>No Recibo</td><td class='titulos2'>Concepto</td><td class='titulos2'>Fecha</td><td class='titulos2'>Contribuyente</td><td class='titulos2'>Valor</td><td class='titulos2'>No Liquid.</td><td class='titulos2'>Tipo</td><td class='titulos2'>ESTADO</td><td class='titulos2' width='5%'><center>Editar</td></tr>";	
//echo "nr:".$nr;
$iter='saludo1a';
$iter2='saludo2';
$tipos=array('Predial','Industria y Comercio','Otros Recaudos');
 while ($row =mysql_fetch_row($resp)) 
 {
	 $ntercero=buscatercero($row[15]);
	 echo "<tr class='$iter'><td>$row[0]</td><td>$row[17]</td><td>$row[2]</td><td>$row[15] $ntercero</td><td>".number_format($row[8],2)."</td><td >$row[4]</td><td>".$tipos[$row[10]-1]."</td><td>$row[9]</td>";
	
	 echo "<td style='text-align:center;'><a href='teso-sinrecibocajaspver.php?idrecibo=$row[0]&tiporeca=$row[10]'><img src='imagenes/b_edit.png' style='width:18px' title='Editar'></a></td></tr>";
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