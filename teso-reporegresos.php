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
	<td colspan="3" class="cinta">
		<a href="#" class="mgbt"><img src="imagenes/add2.png" alt="Nuevo" /></a>
		<a href="#" class="mgbt"><img src="imagenes/guardad.png" alt="Guardar" /></a>
		<a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" alt="Buscar" /></a>
		<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
		<a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana"></a>
		<a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png" alt="imprimir"></a>
		<a href="teso-reporegresoscsv.php?tercero=<?php echo $_POST[tercero]?>&fecha1=<?php echo $_POST[fecha]?>&fecha2=<?php echo $_POST[fecha2]?>&retencion=<?php echo $_POST[chkret]?>" target="_blank"><img src="imagenes/csv.png"  class="mgbt" alt="csv"></a>
		<a href="teso-informestesoreria.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
	</td>
</tr>	
</table>
<tr><td colspan="3" class="tablaprin"> 
 <form name="form2" method="post" action="teso-reporegresos.php">
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
        <td class="titulos" colspan="8">:. Buscar Pagos</td>
        <td width="139" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
      </tr>
 <tr  >      
 <td class="saludo1">Tercero:</td>
 <td valign="middle" >
	<input type="text" id="tercero" name="tercero" size="20" onKeyPress="javascript:return solonumeros(event)" 
		  onKeyUp="return tabular(event,this)" onBlur="buscatercero(event)" value="<?php echo $_POST[tercero]?>" onClick="document.getElementById('tercero').focus();document.getElementById('tercero').select();">
		  <input type="hidden" value="0" name="bc">
		  <a href="#" onClick="mypop=window.open('terceros-ventana.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>
 </td>
 <td >
	<input name="ntercero" type="text" id="ntercero" value="<?php echo $_POST[ntercero]?>" size="60" readonly>
</td>
 <td class="saludo1">
  <input type="checkbox" name="chkret" <?php if(!empty($_POST[chkret])) echo "checked='checked'"; ?>>
  Con Retenci&oacute;n
 </td>
        <td  class="saludo1">Fecha Inicial:</td>
        <td><input type="hidden" value="<?php echo $ $vigusu ?>" name="vigencias">
		<input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">         <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/calendario04.png" style="width:20px" align="absmiddle" border="0"></a>        </td>
        <td class="saludo1">Fecha Final: </td>
        <td ><input name="fecha2" type="text" id="fc_1198971546" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha2]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10"> <a href="#" onClick="displayCalendarFor('fc_1198971546');"><img src="imagenes/calendario04.png" style="width:20px" align="absmiddle" border="0"></a>  <input type="button" name="generar" value="Generar" onClick="document.form2.submit()"> <input type="hidden" value="1" name="oculto"></td></tr>                    
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
$crit20="";
$crit21="";
if ($_POST[tercero]!="")
{
$crit3=" and tesoegresos.tercero like '%".$_POST[tercero]."%' ";
$crit4=" and tesoegresosnomina.tercero like '%".$_POST[tercero]."%' ";
$crit5=" and tesopagoterceros.tercero like '%".$_POST[tercero]."%' ";
$crit6=" and tesopagotercerosvigant.tercero like '%".$_POST[tercero]."%' ";
}
if ($_POST[numero]!="")
{
$crit1=" and tesoegresos.id_egreso like '%".$_POST[numero]."%' ";
$crit7=" and tesoegresosnomina.id_egreso like '%".$_POST[numero]."%' ";
$crit8=" and tesopagoterceros.id_PAGO like '%".$_POST[numero]."%' ";
$crit9=" and tesopagotercerosvigant.id_PAGO like '%".$_POST[numero]."%' ";
}

if(!empty($_POST[chkret])){
  $crit20=" and tesoegresos.retenciones>0";
  $crit21=" and tesoegresosnomina.retenciones>0";
}


if ($_POST[nombre]!="")
{
$crit2=" and tesoegresos.concepto like '%".$_POST[nombre]."%'  ";
$crit10=" and tesoegresosnomina.concepto like '%".$_POST[nombre]."%'  ";
$crit11=" and tesopagoterceros.concepto like '%".$_POST[nombre]."%'  ";
$crit12=" and tesopagotercerosvigant.concepto like '%".$_POST[nombre]."%'  ";
}
//sacar el consecutivo 
//$sqlr="select *from pptosideforigen where".$crit1.$crit2." order by pptosideforigen.codigo";
	$sqlr="select *from tesoegresos where tesoegresos.id_egreso>-1 ".$crit1.$crit2.$crit3.$crit20." AND FECHA BETWEEN '$fechaf' AND '$fechaf2' order by tesoegresos.id_egreso DESC";
	$sqlr2="select *from tesoegresosnomina where tesoegresosnomina.id_egreso>-1 ".$crit4.$crit7.$crit10.$crit21." AND FECHA BETWEEN '$fechaf' AND '$fechaf2' order by tesoegresosnomina.id_egreso DESC";
	$sqlr3="select *from tesopagoterceros where tesopagoterceros.id_PAGO>-1 ".$crit5.$crit8.$crit11." AND FECHA BETWEEN '$fechaf' AND '$fechaf2' order by tesopagoterceros.id_PAGO DESC";
	$sqlr4="select *from tesopagotercerosvigant where tesopagotercerosvigant.id_PAGO>-1 ".$crit6.$crit9.$crit12." AND FECHA BETWEEN '$fechaf' AND '$fechaf2' order by tesopagotercerosvigant.id_PAGO DESC";
//echo "<div><div>sqlr:".$sqlr."</div></div>";
$resp = mysql_query($sqlr,$linkbd);
$ntr = mysql_num_rows($resp);
$resp2 = mysql_query($sqlr2,$linkbd);
$ntr2 = mysql_num_rows($resp2);
$resp3 = mysql_query($sqlr3,$linkbd);
$ntr3 = mysql_num_rows($resp3);
$resp4 = mysql_query($sqlr4,$linkbd);
$ntr4 = mysql_num_rows($resp4);
$con=1;

echo "<table class='inicio' align='center' >
  <tr>
	<td colspan='11' class='titulos'>.: Resultados Busqueda:</td>
  </tr>
  <tr>
	<td colspan='11' class='saludo3'>Pagos Encontrados: ".($ntr+$ntr2+$ntr3+$ntr4)."</td>
  </tr>
  <tr>
	<td  class='titulos2'>Egreso</td>
	<td  class='titulos2'>Orden Pago</td>
	<td class='titulos2'>Doc Tercero</td>
	<td class='titulos2'>Tercero</td>
	<td class='titulos2'>Fecha</td>
	<td class='titulos2'>Cheque/Transferencia</td>
	<td class='titulos2'>Valor</td>
	<td class='titulos2'>Valor Pago</td>
	<td class='titulos2'>Retenci&oacute;n</td>
	<td class='titulos2'>Concepto</td>
	<td class='titulos2' width='3%'><center>Estado</td>
  </tr>";	
//echo "nr:".$nr;
$iter='saludo1';
$iter2='saludo2';
 while ($row =mysql_fetch_row($resp)) 
 {
	 $ntr=buscatercero($row[11]);
	 echo "<tr class='$iter'>
	  <td >
		<input type='hidden' name='egresos[]' value='$row[0]'>$row[0]
	  </td>
	  <td >
		<input type='hidden' name='ordenes[]' value='$row[2]'>$row[2]
	  </td>
	  <td >
		<input type='hidden' name='terceros[]' value='$row[11]'>$row[11]
	  </td>
	  <td >
		<input type='hidden' name='nterceros[]' value='$ntr'>$ntr
	  </td>
		<td ><input type='hidden' name='fechas[]' value='$row[3]'>$row[3]
	  </td>
	  <td >
		<input type='hidden' name='cheques[]' value='$row[10]'>$row[10]
	  </td>
	  <td align='right' >
		<input type='hidden' name='valoresb[]' value='$row[5]'>".number_format($row[5],2)."
	  </td>
	  <td align='right' >
		<input type='hidden' name='valores[]' value='$row[7]'>".number_format($row[7],2)."
	  </td>
	  <td align='right' >
		<input type='hidden' name='retenciones[]' value='$row[6]'>".number_format($row[6],2)."
	  </td>
	  <td >
		<input type='hidden' name='conceptos[]' value='EGRESOS $row[8]'>".strtoupper("EGRESOS ".$row[8])."
	  </td>
	  <td >
		<input type='hidden' name='estados[]' value='$row[13]'>".strtoupper($row[13])."
	  </td>
	</tr>";
	 $con+=1;
	 $aux=$iter;
	 $iter=$iter2;
	 $iter2=$aux;
 }
 while ($row2 =mysql_fetch_row($resp2)) 
 {
	 $ntr=buscatercero($row2[11]);
	 echo "<tr class='$iter'>
	  <td >
		<input type='hidden' name='egresos[]' value='$row2[0]'>$row2[0]
	  </td>
	  <td >
		<input type='hidden' name='ordenes[]' value='$row2[2]'>$row2[2]
	  </td>
	  <td >
		<input type='hidden' name='terceros[]' value='$row2[11]'>$row2[11]
	  </td>
	  <td >
		<input type='hidden' name='nterceros[]' value='$ntr'>$ntr
	  </td>
	  <td >
		<input type='hidden' name='fechas[]' value='$row2[3]'>$row2[3]
	  </td>
	  <td >
		<input type='hidden' name='cheques[]' value='$row2[10]'>$row2[10]
	  </td>
	  <td align='right' >
		<input type='hidden' name='valoresb[]' value='$row2[5]'>".number_format($row2[5],2)."
	  </td>
	  <td align='right' >
		<input type='hidden' name='valores[]' value='$row2[7]'>".number_format($row2[7],2)."
	  </td>
	  <td align='right' >
		<input type='hidden' name='retenciones[]' value='$row2[6]'>".number_format($row2[6],2)."
	  </td>
	  <td >
		<input type='hidden' name='conceptos[]' value='EGRESO NOMINA $row2[8]'>".strtoupper("EGRESO NOMINA ".$row2[8])."
	  </td>
	  <td >
		<input type='hidden' name='estados[]' value='$row2[13]'>".strtoupper($row2[13])."
	  </td>
	</tr>";
	 $con+=1;
	 $aux=$iter;
	 $iter=$iter2;
	 $iter2=$aux;
 }
 if(($crit20=="")&&($crit21=="")){
 while ($row3 =mysql_fetch_row($resp3)) 
 {
	 $ntr=buscatercero($row3[1]);
	 echo "<tr class='$iter'>
	  <td >
		<input type='hidden' name='egresos[]' value='$row3[0]'>$row3[0]
	  </td>
	  <td >
		<input type='hidden' name='ordenes[]' value='$row3[0]'>$row3[0]
	  </td>
	  <td >
		<input type='hidden' name='terceros[]' value='$row3[1]'>$row3[1]
	  </td>
	  <td >
		<input type='hidden' name='nterceros[]' value='$ntr'>$ntr
	  </td>
	  <td >
		<input type='hidden' name='fechas[]' value='$row3[10]'>$row3[10]
	  </td>
	  <td >
		<input type='hidden' name='fechas[]' value='$row3[3]'>$row3[3]
	  </td>
	  <td align='right' >
		<input type='hidden' name='valoresb[]' value='$row3[5]'>".number_format($row3[5],2)."
	  </td>
	  <td align='right' >
		<input type='hidden' name='valores[]' value='$row3[5]'>".number_format($row3[5],2)."
	  </td>
	  <td align='right' >
		<input type='hidden' name='retenciones[]' value='0'>".number_format('0',2)."
	  </td>
	  <td >
		<input type='hidden' name='conceptos[]' value='PAGO TERCEROS $row3[7]'>".strtoupper("PAGO TERCEROS".$row3[7])."
	  </td>
	  <td >
		<input type='hidden' name='estados[]' value='$row3[9]'>".strtoupper($row3[9])."
	  </td>
	</tr>";
	 $con+=1;
	 $aux=$iter;
	 $iter=$iter2;
	 $iter2=$aux;
 }
  while ($row4 =mysql_fetch_row($resp4)) 
 {
	 $ntr=buscatercero($row4[1]);
	 echo "<tr class='$iter'>
	  <td >
		<input type='hidden' name='egresos[]' value='$row4[0]'>$row4[0]
	  </td>
	  <td >
		<input type='hidden' name='ordenes[]' value='$row4[0]'>$row4[0]
	  </td>
	  <td >
		<input type='hidden' name='terceros[]' value='$row4[1]'>$row4[1]
	  </td>
	  <td >
		<input type='hidden' name='nterceros[]' value='$ntr'>$ntr
	  </td>
	  <td >
		<input type='hidden' name='fechas[]' value='$row4[10]'>$row4[10]
	  </td>
	  <td >
		<input type='hidden' name='fechas[]' value='$row4[3]'>$row4[3]
	  </td>
	  <td align='right' >
		<input type='hidden' name='valoresb[]' value='$row3[5]'>".number_format($row3[5],2)."
	  </td>
	  <td align='right'>
		<input type='hidden' name='valores[]' value='$row4[5]'>".number_format($row4[5],2)."
	  </td>
	  <td align='right' >
		<input type='hidden' name='retenciones[]' value='0'>".number_format('0',2)."
	  </td>
	  <td >
		<input type='hidden' name='conceptos[]' value='PAGO VIG ANTERIOR $row4[7]'>".strtoupper("PAGO VIG ANTERIOR".$row4[7])."
	  </td>
	  <td >
		<input type='hidden' name='estados[]' value='$row4[9]'>".strtoupper($row4[9])."
	  </td>
	</tr>";	
	 $con+=1;
	 $aux=$iter;
	 $iter=$iter2;
	 $iter2=$aux;
 }
 }
echo"</table>";
}
?></div></form>
</td></tr>     
</table>
</body>
</html>