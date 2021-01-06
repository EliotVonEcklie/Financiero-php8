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
		<title>:: SieS - Tesoreria</title>
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
document.form2.action="teso-pdftraslados.php";
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
  <td colspan="3" class="cinta"><a href="teso-traslados.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a><a class="mgbt"><img src="imagenes/guardad.png"/></a><a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a><a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" alt="nueva ventana"></a></td></tr>	
  </table>
 <form name="form2" method="post" action="teso-corrigetraslados.php">
<table  class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="6">:. Buscar Traslados de Bancos </td>
        <td width="139" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
      </tr>
      <tr >
        <td width="162" class="saludo1">Numero Comprobante:</td>
        <td width="179"><input name="numero" type="text" value="" size="15">
        </td>
         <td width="131" class="saludo1">Fecha Inicial: </td>
    <td width="131" ><input name="fechaini" type="text" id="fc_1198971545" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fechaini]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">
        <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>          </td>
  <td width="147" class="saludo1">Fecha Final: </td>
    <td width="149" ><input name="fechafin" type="text" id="fc_1198971546" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fechafin]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">
        <a href="#" onClick="displayCalendarFor('fc_1198971546');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>          </td>
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

//sacar el consecutivo 
//$sqlr="select *from pptosideforigen where".$crit1.$crit2." order by pptosideforigen.codigo";
	$sqlr="select *from  comprobante_cab,tesotraslados_cab where comprobante_cab.numerotipo=tesotraslados_cab.id_consignacion and comprobante_cab.tipo_comp='10'".$crit1.$crit2." order by comprobante_cab.numerotipo";

 echo "<div><div>sqlr:".$sqlr."</div></div>";
$resp = mysql_query($sqlr,$linkbd);
$ntr = mysql_num_rows($resp);
$con=1;

echo "<table class='inicio' align='center' ><tr><td colspan='6' class='titulos'>.: Resultados Busqueda:</td></tr><tr><td colspan='2'>Comprobante de Consignación Encontrados: $ntr</td></tr><tr><td width='150' class='titulos2'>Numero Comprobante</td><td class='titulos2'>Fecha</td><td class='titulos2'>Concepto Traslado</td><td width='15%' class='titulos2'>Estado</td><td class='titulos2' width='5%'><center>Anular</td><td class='titulos2' width='5%'><center>Editar</td></tr>";	
//echo "nr:".$nr;
$iter='saludo1';
$iter2='saludo2';
 while ($row =mysql_fetch_row($resp)) 
 {
	 echo "<tr ><td class='$iter'>$row[1]</td><td class='$iter'>$row[12]</td><td class='$iter'>$row[15]</td><td class='$iter'>$row[14]</td><td class='$iter'><a href='#'><center><img src='imagenes/anular.png'></center></a></td><td class='$iter'><a href='teso-editatraslados.php?idr=$row[0]&dc=$row[1]'><center><img src='imagenes/buscarep.png'></center></a></td></tr>";
	 $sqlr2="update tesotraslados_cab set id_comp=$row[0] where id_consignacion=$row[1]";
	 mysql_query($sqlr2,$linkbd);
	 echo "<br>$sqlr2";
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