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
function buscater(e)
 {
if (document.form2.tercero.value!="")
{
 document.form2.bt.value='1';
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
document.form2.action="teso-pdfconsignaciones.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
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
  <td colspan="3" class="cinta">
  <a href="#" class="mgbt"><img src="imagenes/add2.png" alt="Nuevo" title="Nuevo"/></a>
  <a href="#" class="mgbt"><img src="imagenes/guardad.png" alt="Guardar" title="Guardar" /></a>
  <a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" alt="Buscar" title="Buscar"/></a> 
  <a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana" title="Nueva ventana"></a>  
  <a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png" alt="imprimir" title="Imprimir"></a> 
  <a href="<?php echo "archivos/".$_SESSION[usuario]."-reportecontribuyente.csv"; ?>" target="_blank" class="mgbt"><img src="imagenes/csv.png"  alt="csv" title="csv"></a>
  <a href="teso-informestesoreria.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
  </td></tr>	
</table>
<tr><td colspan="3" class="tablaprin"> 
 <form name="form2" method="post" action="teso-reporcontribuyente.php">
 <?php
 $vigusu=vigencia_usuarios($_SESSION[cedulausu]);
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
        <td class="titulos" colspan="8">:. Reporte contribuyente:</td>
        <td width="139" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
      </tr>
 <tr  >    
 <td  class="saludo1" style="width:6%;">Tercero:</td>
          <td  valign="middle" style="width:10%;">
				<input type="text" id="tercero" name="tercero" 	onKeyPress="javascript:return solonumeros(event)" 
		  onKeyUp="return tabular(event,this)" onBlur="buscatercero(event)" style="width:80%;" value="<?php echo $_POST[tercero]?>" onClick="document.getElementById('tercero').focus();document.getElementById('tercero').select();">
		  <input type="hidden" value="0" name="bc"><a href="#" onClick="mypop=window.open('terceros-ventana.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>  </td>
		  <td style="width:20%;">
				<input name="ntercero" type="text" id="ntercero" value="<?php echo $_POST[ntercero]?>" style="width:100%;" readonly> <input name="oculto" type="hidden" value="1"> </td>     
        <td  class="saludo1">Fecha Inicial:</td>
        <td>
				<input type="hidden" value="<?php echo $ $vigusu ?>" name="vigencias">
				<input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">
				<a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/calendario04.png" style="width:20px" align="absmiddle" border="0"></a>        </td>
        <td  class="saludo1">Fecha Final: </td>
        <td>
				<input name="fecha2" type="text" id="fc_1198971546" title="DD/MM/YYYY"  value="<?php echo $_POST[fecha2]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10"> 
				<a href="#" onClick="displayCalendarFor('fc_1198971546');"><img src="imagenes/calendario04.png" style="width:20px" align="absmiddle" border="0"></a>  
				<input type="button" name="generar" value="Generar" onClick="document.form2.submit()"> <input type="hidden" value="1" name="oculto"></td></tr>                 
    </table>    
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
    </form> <div class="subpantallap">
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
//**** EGRESOS
if ($_POST[tercero]!="")
$crit1=" and tesoegresos.tercero like '%".$_POST[tercero]."%' ";
if ($_POST[nombre]!="")
$crit2=" and tesoegresos.concepto like '%".$_POST[nombre]."%'  ";
//sacar el consecutivo 
//$sqlr="select *from pptosideforigen where".$crit1.$crit2." order by pptosideforigen.codigo";
	$sqlr="select *from tesoegresos where tesoegresos.id_egreso>-1 ".$crit1.$crit2." AND FECHA BETWEEN '$fechaf' AND '$fechaf2' and estado!='N' order by tesoegresos.id_egreso DESC";

//echo "<div><div>sqlr:".$sqlr."</div></div>";
$resp = mysql_query($sqlr,$linkbd);
$ntr = mysql_num_rows($resp);
	//****** FIN SQL EGRESOS
//**** EGRESOS NOMINA
if ($_POST[tercero]!="")
$crit1=" and tesoegresosnomina.tercero like '%".$_POST[tercero]."%' ";
if ($_POST[nombre]!="")
$crit2=" and tesoegresosnomina.concepto like '%".$_POST[nombre]."%'  ";
//sacar el consecutivo 
//$sqlr="select *from pptosideforigen where".$crit1.$crit2." order by pptosideforigen.codigo";
	$sqlr="select *from tesoegresosnomina where tesoegresosnomina.id_egreso>-1 ".$crit1.$crit2." AND FECHA BETWEEN '$fechaf' AND '$fechaf2' and estado!='N' order by tesoegresosnomina.id_egreso DESC";
//echo "<div><div>sqlr:".$sqlr."</div></div>";
$resp2 = mysql_query($sqlr,$linkbd);
$ntr2 = mysql_num_rows($resp2);
	//****** FIN SQL EGRESOS NOMINA
	$ntr+=$ntr2;
$con=1;
	 $namearch="archivos/".$_SESSION[usuario]."-reportecontribuyente.csv";
$Descriptor1 = fopen($namearch,"w+"); 
fputs($Descriptor1,"TIPO;No MOV;ORDEN PAGO;Doc Tercero;TERCERO;FECHA;VALOR;CONCEPTO;ESTADO\r\n");
echo "<table class='inicio' align='center' ><tr><td colspan='9' class='titulos'>.: Resultados Busqueda:</td></tr><tr><td colspan='9' class='saludo3'>Pagos Encontrados: $ntr</td></tr><tr><td  class='titulos2'>TIPO</td><td  class='titulos2'>No Mov</td><td  class='titulos2'>Orden Pago</td><td class='titulos2'>Doc Tercero</td><td class='titulos2'>Tercero</td><td class='titulos2'>Fecha</td><td class='titulos2'>Valor</td><td class='titulos2'>Concepto</td><td class='titulos2' width='3%'><center>Estado</td></tr>";	
//echo "nr:".$nr;
$iter='saludo1';
$iter2='saludo2';
//**** egresos
 while ($row =mysql_fetch_row($resp)) 
 {
	 $ntr=buscatercero($row[11]);
	 echo "<tr class='$iter'><td >EGRESOS</td><td >$row[0]</td><td >$row[2]</td><td >$row[11]</td><td >$ntr</td><td >$row[3]</td><td >".number_format($row[7],2)."</td><td >".strtoupper($row[8])."</td><td >".strtoupper($row[13])."</td></tr>";
	 $con+=1;
	 $aux=$iter;
	 $iter=$iter2;
	 $iter2=$aux;
  fputs($Descriptor1,"EGRESOS;".$row[0].";".$row[2].";".$row[11].";".$ntr.";".$row[3].";".number_format($row[7],2,",","").";".strtoupper($row[8]).";".strtoupper($row[13])."\r\n");
 }
 //**** egresos nomina
  while ($row =mysql_fetch_row($resp2)) 
 {
	 $ntr=buscatercero($row[11]);
	 echo "<tr class='$iter'><td >EGRESOS NOMINA</td><td >$row[0]</td><td >$row[2]</td><td >$row[11]</td><td >$ntr</td><td >$row[3]</td><td >".number_format($row[7],2)."</td><td >".strtoupper($row[8])."</td><td >".strtoupper($row[13])."</td></tr>";
	 $con+=1;
	 $aux=$iter;
	 $iter=$iter2;
	 $iter2=$aux;
  fputs($Descriptor1,"EGRESOS NOMINA;".$row[0].";".$row[2].";".$row[11].";".$ntr.";".$row[3].";".number_format($row[7],2,",","").";".strtoupper($row[8]).";".strtoupper($row[13])."\r\n");
 }
 
 fclose($Descriptor1);
 echo"</table>";
}
?></div>
</td></tr>     
</table>
</body>
</html>