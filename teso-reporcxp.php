<?php //V 1000 12/12/16 ?> 
<?php
require"comun.inc";
require"funciones.inc";
session_start();
cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<title>:: SPID - Tesoreria</title>

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
<script>
function buscacta(e)
 {
if (document.form2.cuenta.value!="")
{
 document.form2.bc.value='1';
 document.form2.submit();
 }
 }
</script>
<script language="JavaScript1.2">
function validar()
{
document.form2.submit();
}
</script>
<script>
function buscatercero(e)
 {
if (document.form2.tercero.value!="")
{
 document.form2.bc.value='1';
 document.form2.submit();
 }
 }
</script>
<script>
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
</script>
<script>
//************* genera reporte ************
//***************************************
function eliminar(idr)
{
	if (confirm("Esta Seguro de Eliminar El Egreso No "+idr))
  	{
  	document.form2.oculto.value=2;
  	document.form2.var1.value=idr;
	document.form2.submit();
  	}
}
</script>
<script>
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
</script>
<script>
function pdf()
{
document.form2.action="pdfreporegresos.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
}
</script>
<script src="css/programas.js"></script>
<script src="css/calendario.js"></script>
<link href="css/css2.css" rel="stylesheet" type="text/css" />
<link href="css/css3.css" rel="stylesheet" type="text/css" />
<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
	<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("teso");?></tr>
<tr>
  <td colspan="3" class="cinta"><a href="#" ><img src="imagenes/add2.png" alt="Nuevo" /></a> <img src="imagenes/guardad.png" alt="Guardar" /> <a onClick="document.form2.submit();" href="#"><img src="imagenes/busca.png" alt="Buscar" /></a> <a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" alt="nueva ventana"></a>  <a href="#" onClick="pdf()"><img src="imagenes/print.png" alt="imprimir"></a> <a href="<?php echo "archivos/".$_SESSION[usuario]."-reporteegresos.csv"; ?>" target="_blank"><img src="imagenes/csv.png"  alt="csv"></a></td></tr>	
</table>
<tr><td colspan="3" class="tablaprin"> 
 <form name="form2" method="post" action="teso-reporcxp.php">
 <?php
 if($_POST[bc]=='1')
			 {
			  $nresul=buscatercero($_POST[tercero]);
			  if($nresul!='')
			   {
			  $_POST[ntercero]=$nresul;
  	
			  }
			 else
			 {
			  $_POST[ntercero]="";
			  }
			 }
 ?>
<table  class="inicio" align="center" >

      <tr >
        <td class="titulos" colspan="8">:. Buscar Cuentas Por Pagar</td>
        <td width="139" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
      </tr>
 <tr  >      
 <td class="saludo1">Tercero:</td>
 <td valign="middle" ><input type="text" id="tercero" name="tercero" size="20" onKeyPress="javascript:return solonumeros(event)" 
		  onKeyUp="return tabular(event,this)" onBlur="buscatercero(event)" value="<?php echo $_POST[tercero]?>" onClick="document.getElementById('tercero').focus();document.getElementById('tercero').select();"><input type="hidden" value="0" name="bc"><a href="#" onClick="mypop=window.open('terceros-ventana.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>  </td><td ><input name="ntercero" type="text" id="ntercero" value="<?php echo $_POST[ntercero]?>" size="70" readonly></td>      
        <td  class="saludo1">Fecha Inicial:</td>
        <td><input type="hidden" value="<?php echo $ $vigusu ?>" name="vigencias"><input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">         <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>        </td>
        <td class="saludo1">Fecha Final: </td>
        <td ><input name="fecha2" type="text" id="fc_1198971546" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha2]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10"> <a href="#" onClick="displayCalendarFor('fc_1198971546');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>  <input type="button" name="generar" value="Generar" onClick="document.form2.submit()"> <input type="hidden" value="1" name="oculto"></td></tr>                    
	<?php 
			if($_POST[bc]=='1')
			 {
			  $nresul=buscatercero($_POST[tercero]);
			  if($nresul!='')
			   {
			  $_POST[ntercero]=$nresul;
  			  ?>
			  <script>
			  document.form2.fecha.focus();document.form2.fecha.select();</script>
			  <?php
			  }
			 else
			 {
			  $_POST[ntercero]="";
			  ?>
			  <script>alert("Tercero Incorrecta");document.form2.tercero.focus();</script>
			  <?php
			  }
			 }
			 ?>
	</table>  
    <div class="subpantallap">
      <?php	  
$oculto=$_POST['oculto'];
if($_POST[oculto])
{
$linkbd=conectar_bd();
ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
	$fechaf2=$fecha[3]."-".$fecha[2]."-".$fecha[1];	
$crit1=" ";
$crit2=" ";
if ($_POST[tercero]!="")
{
$crit3=" and tesoegresos.tercero like '%".$_POST[tercero]."%' ";
}
if ($_POST[numero]!="")
{
$crit1=" and tesoegresos.id_egreso like '%".$_POST[numero]."%' ";
}
if ($_POST[nombre]!="")
{
$crit2=" and tesoegresos.concepto like '%".$_POST[nombre]."%'  ";
}
//sacar el consecutivo 
//$sqlr="select *from pptosideforigen where".$crit1.$crit2." order by pptosideforigen.codigo";
	$sqlr="select *from tesoordenpago where tesoordenpago.id_orden>-1 ".$crit1.$crit2.$crit3." AND FECHA BETWEEN '$fechaf' AND '$fechaf2' order by tesoegresos.id_egreso DESC";
	
//echo "<div><div>sqlr:".$sqlr."</div></div>";
$resp = mysql_query($sqlr,$linkbd);
$ntr = mysql_num_rows($resp);

$con=1;
$namearch="archivos/".$_SESSION[usuario]."-reporteegresos.csv";
$Descriptor1 = fopen($namearch,"w+"); 
fputs($Descriptor1,"EGRESO;ORDEN PAGO;Doc Tercero;TERCERO;FECHA;VALOR;VALOR PAGO;CONCEPTO;ESTADO\r\n");
echo "<table class='inicio' align='center' ><tr><td colspan='9' class='titulos'>.: Resultados Busqueda:</td></tr><tr><td colspan='9' class='saludo3'>Pagos Encontrados: ".($ntr+$ntr2+$ntr3+$ntr4)."</td></tr><tr><td  class='titulos2'>Egreso</td><td  class='titulos2'>Orden Pago</td><td class='titulos2'>Doc Tercero</td><td class='titulos2'>Tercero</td><td class='titulos2'>Fecha</td><td class='titulos2'>Valor</td><td class='titulos2'>Valor Pago</td><td class='titulos2'>Concepto</td><td class='titulos2' width='3%'><center>Estado</td></tr>";	
//echo "nr:".$nr;
$iter='saludo1';
$iter2='saludo2';
 while ($row =mysql_fetch_row($resp)) 
 {
	 $ntr=buscatercero($row[11]);
	 echo "<tr class='$iter'><td ><input type='hidden' name='egresos[]' value='$row[0]'>$row[0]</td><td ><input type='hidden' name='ordenes[]' value='$row[2]'>$row[2]</td><td ><input type='hidden' name='terceros[]' value='$row[11]'>$row[11]</td><td ><input type='hidden' name='nterceros[]' value='$ntr'>$ntr</td><td ><input type='hidden' name='fechas[]' value='$row[3]'>$row[3]</td><td ><input type='hidden' name='valoresb[]' value='$row[5]'>".number_format($row[5],2)."</td><td ><input type='hidden' name='valores[]' value='$row[7]'>".number_format($row[7],2)."</td><td ><input type='hidden' name='conceptos[]' value='EGRESOS $row[8]'>".strtoupper("EGRESOS ".$row[8])."</td><td ><input type='hidden' name='estados[]' value='$row[13]'>".strtoupper($row[13])."</td></tr>";
	 $con+=1;
	 $aux=$iter;
	 $iter=$iter2;
	 $iter2=$aux;
  fputs($Descriptor1,$row[0].";".$row[2].";".$row[11].";".$ntr.";".$row[3].";".number_format($row[5],2,".","").";".number_format($row[7],2,".","").";".strtoupper("EGRESO ".$row[8]).";".strtoupper($row[13])."\r\n");
 }
 
 fclose($Descriptor1);
 echo"</table>";
}
?></div></form>
</td></tr>     
</table>
</body>
</html>