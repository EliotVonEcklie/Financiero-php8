<?php //V 1000 12/12/16 ?> 
<?php
require "comun.inc";
require "funciones.inc";
session_start();
cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<title>:: IDEAL 10</title>

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
	<tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("presu");?></tr>
	<tr>
	<td colspan="3" class="cinta">
		<a href="#" class="mgbt"><img src="imagenes/add2.png" alt="Nuevo" /></a>
		<a href="#" class="mgbt"><img src="imagenes/guardad.png" alt="Guardar" /></a>
		<a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" alt="Buscar" /></a>
		<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
		<a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana"></a>
		<a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png" alt="imprimir"></a>
		<a href="teso-reporegresosexcel.php?tercero=<?php echo $_POST[tercero]?>&fecha1=<?php echo $_POST[fecha]?>&fecha2=<?php echo $_POST[fecha2]?>&retencion=<?php echo $_POST[chkret]?>" target="_blank"><img src="imagenes/excel.png"  class="mgbt" alt="csv"></a>
		<a href="presu-librosppto.php" class="mgbt"><img src="imagenes/iratras.png" title="Atr&aacute;s"></a>
	</td>
</tr>	
</table>
<tr><td colspan="3" class="tablaprin"> 
 <form name="form2" method="post" action="presu-rptegresos.php">
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
 
            <td class="saludo1" style="width:3.1cm;">Fecha Inicial:</td>
            <td style="width:12%;"><input name="fecha"  type="text" value="<?php echo $_POST[fecha]?>" maxlength="10"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" style="width:80%;" title="DD/MM/YYYY"/>&nbsp;<a href="#" onClick="displayCalendarFor('fc_1198971545');" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px;"/></a></td>
            <td class="saludo1" style="width:3.1cm;">Fecha Final:</td>
            <td style="width:12%;"><input name="fecha2" type="text" value="<?php echo $_POST[fecha2]?>" maxlength="10"  onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971546" onKeyDown="mascara(this,'/',patron,true)" style="width:80%;" title="DD/MM/YYYY"/>&nbsp;<a href="#" onClick="displayCalendarFor('fc_1198971546');" title="Calendario"><img src="imagenes/calendario04.png" style="width:20px;"/></a></td>
            <td>
                <input type="button" name="bboton" onClick="document.form2.submit()" value="&nbsp;&nbsp;Generar&nbsp;&nbsp;" />
                <input type="hidden" value="1" name="oculto">
            </td>
        </tr>                    
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

}
if ($_POST[numero]!="")
{
$crit1=" and tesoegresos.id_egreso like '%".$_POST[numero]."%' ";

}

if(!empty($_POST[chkret])){
  $crit20=" and tesoegresos.retenciones>0";
}


if ($_POST[nombre]!="")
{
	$crit2=" and tesoegresos.concepto like '%".$_POST[nombre]."%'  ";
}

//sacar el consecutivo 
//$sqlr="select *from pptosideforigen where".$crit1.$crit2." order by pptosideforigen.codigo";
	$sqlr="select *from tesoegresos where tesoegresos.id_egreso>-1 ".$crit1.$crit2.$crit3.$crit20." AND FECHA BETWEEN '$fechaf' AND '$fechaf2' order by tesoegresos.id_egreso DESC";
	
//echo "<div><div>sqlr:".$sqlr."</div></div>";
$resp = mysql_query($sqlr,$linkbd);
$ntr = mysql_num_rows($resp);

$con=1;

echo "<table class='inicio' align='center' >
  <tr>
	<td colspan='11' class='titulos'>.: Resultados Busqueda:</td>
  </tr>
  <tr>
	<td colspan='11' class='saludo3'>Pagos Encontrados: ".($ntr)."</td>
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
 
echo"</table>";
}
?></div></form>
</td></tr>     
</table>
</body>
</html>