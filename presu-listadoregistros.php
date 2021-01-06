<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	require "conversor.php";
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
		<title>:: Spid - Presupuesto</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
<script>

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
document.form2.action="presu-buscarp.php";
document.form2.submit();
}
function excell()
{
document.form2.action="presu-listadoregistrosexcel.php";
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
        <tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
        <tr><?php menu_desplegable("presu");?></tr>
    <tr>
      <td colspan="3" class="cinta"><a href="presu-rp.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a><a class="mgbt"><img src="imagenes/guardad.png" /></a><a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a><a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a><a onClick="pdf()" class="mgbt"><img src="imagenes/print.png"  title="Buscar" /></a><a class="mgbt" onClick="excell()" class="mgbt"><img src="imagenes/excel.png"  title="excel"></a></td></tr>	
      </table>

 <form name="form2" method="post" action="presu-listadoregistros.php">
<table width="100%" align="center"  class="inicio" >
      <tr >
        <td class="titulos" colspan="5">:: Buscar .: Registro Presupuestal </td>
        <td  class="cerrar" ><a href="presu-principal.php"> Cerrar</a></td>
             <input name="oculto" type="hidden" value="1">
    </tr>                       
    <tr  >
		<td class="saludo1" style="width:3cm;">Fecha Inicial: </td>
		<td  style="width:15%;"><input name="fechaini" type="text" id="fc_1198971545" title="DD/MM/YYYY" value="<?php echo $_POST[fechaini]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" style="width:80%;">&nbsp;<a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/calendario04.png" style="width:20px;"></a> </td>
		<td class="saludo1" style="width:3cm;">Fecha Final: </td>
		<td style="width:15%;"><input name="fechafin" type="text" id="fc_1198971546" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fechafin]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10" style="width:80%;">&nbsp;<a href="#" onClick="displayCalendarFor('fc_1198971546');"><img src="imagenes/calendario04.png" style="width:20px;"></a></td>
		<td><input type="button" name="Buscar" value="   Buscar   " onClick="document.form2.submit()"> </td>
  </tr>
  <tr>
    <td><input type="hidden" value="1" name="oculto2"></td>
    </tr>
</table>
 
  <div class="subpantallac5" style="height:67%; width:99.6%; overflow-x:hidden;">
      <?php
	   $vigusu=vigencia_usuarios($_SESSION[cedulausu]);
$oculto=$_POST['oculto'];
if($_POST[oculto])
{
$linkbd=conectar_bd();
$crit1=" ";
$crit2=" ";
$crit3=" ";
$crit4=" ";
$crit5=" ";


if ($_POST[vigencia]!="")
$crit1=" and pptorp.vigencia ='$_POST[vigencia]' ";
if ($_POST[numero]!="")
$crit2=" and pptorp.consvigencia like '%$_POST[numero]%' ";
if ($_POST[fechaini]!="" and $_POST[fechafin]!="" )
{	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechaini],$fecha);
	$fechai=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechafin],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];

$crit3=" and pptorp.fecha between '$fechai' and '$fechaf'  ";
}

//sacar el consecutivo 
//$sqlr="select *from pptosideforigen where".$crit1.$crit2." order by pptosideforigen.codigo";
//if ($_POST[vigencia]!="" and $_POST[numero]!="" and  $_POST[fecha]!="" and  $_POST[solicita]!="" and $_POST[objeto]!="" )
//	$sqlr="select *from pptocdp order by pptocdp.consvigencia";
//else	 
	$sqlr="select *from pptorp  where pptorp.estado<>'' ".$crit1.$crit2.$crit3." and pptorp.vigencia=".$vigusu." order by pptorp.consvigencia";

 //echo "<div><div>sqlr:".$sqlr."</div></div>";
$resp = mysql_query($sqlr,$linkbd);
$ntr = mysql_num_rows($resp);
$con=1;
echo "
<table class='inicio' align='center' width='80%'>
	<tr><td colspan='11' class='titulos'>.: Resultados Busqueda:</td></tr>
	<tr><td colspan='5'>Registro Presupuestal Encontrados: $ntr</td></tr>
	<tr>
		<td class='titulos2'>Vigencia</td>
		<td class='titulos2'>RP</td>
		<td class='titulos2'>CDP</td>
		<td class='titulos2'>Objeto</td>
		<td class='titulos2'>Documento</td>
		<td class='titulos2'>Tercero</td>
		<td class='titulos2'>Valor</td>
		<td class='titulos2' >Fecha</td>
		<td class='titulos2'>Estado</td>
		<td class='titulos2' >Saldo Pagar</td>
		<td class='titulos2' >Contrato</td>
	</tr>";	
//echo "nr:".$nr;
$iter='saludo1a';
$iter2='saludo2';
 while ($row =mysql_fetch_row($resp)) 
 {
	 $sqlr2="select pptocdp.objeto from pptocdp where pptocdp.consvigencia=$row[2] and pptocdp.vigencia=$row[0]";
	 $resp2 = mysql_query($sqlr2,$linkbd);
	 $r2 =mysql_fetch_row($resp2);
	 $nrub=existecuentain($row[12]);
	 $tercero=buscatercero($row[5]);
	 echo "
	 <tr class='$iter' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase;' >
		<td>$row[0]</td>
		<td>$row[1]</td>
		<td>$row[2]</td>
		<td style='text-align:justify;padding-right:0.5em;'>$r2[0]</td>
		<td>".number_format($row[5],0,',','.')."</td>
		<td style='width:15%;'>$tercero</td>
		<td style='text-align:right; width:10%;'>$ ".number_format($row[6],2,',','.')."</td>
		<td style='text-align:center; width:7%;'>".date('d-m-Y',strtotime($row[4]))."</td>
		<td>$row[3]</td>
		<td style='text-align:right; width:10%;'>$ ".number_format($row[7],2,',','.')."</td>
		<td>$row[8]</td>
	</tr>";
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