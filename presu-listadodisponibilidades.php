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
        <script src="css/calendario.js"></script>
        <script src="css/programas.js"></script>
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
//************* genera reporte ************
//***************************************
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
document.form2.action="presu-buscacdp.php";
document.form2.submit();
}
function cleanForm()
{
document.form2.nombre1.value="";
document.form2.nombre2.value="";
document.form2.apellido1.value="";
document.form2.apellido2.value="";
document.form2.documento.value="";
document.form2.codver.value="";
document.form2.telefono.value="";
document.form2.direccion.value="";
document.form2.email.value="";
document.form2.web.value="";
document.form2.celular.value="";
document.form2.razonsocial.value="";
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
          <td colspan="3" class="cinta"><a href="presu-cdp.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a><a class="mgbt"><img src="imagenes/guardad.png"/></a><a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a><a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a><a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png" title="Buscar"/></a><a href="<?php echo "archivos/".$_SESSION[usuario]."listadocdps.csv"; ?>" target="_blank" class="mgbt"><img src="imagenes/csv.png" title="csv"></a></td></tr>	
          </table>
 <form name="form2" method="post" action="presu-listadodisponibilidades.php">
<table width="100%" align="center"  class="inicio" >
      <tr >
        <td class="titulos" colspan="4">:: Buscar .: Disponibilidad Presupuestal </td>
        <td  class="cerrar" ><a href="presu-principal.php"> Cerrar</a></td>
             <input name="oculto" type="hidden" value="1">
    </tr>                       
    <tr  >
    <td width="81" class="saludo1">Fecha Inicial: </td>
    <td width="147" ><input name="fechaini" type="text" id="fc_1198971545" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fechaini]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">
     <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>          </td>
  <td width="141" class="saludo1">Fecha Final: </td>
    <td width="173" ><input name="fechafin" type="text" id="fc_1198971546" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fechafin]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">
      <a href="#" onClick="displayCalendarFor('fc_1198971546');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>          </td>
  </tr>
  <tr>
    <td><input type="hidden" value="1" name="oculto2"></td>
    </tr>
</table>
 
  <div class="subpantallac5" style="height:67%; width:99.6%; overflow-x:hidden;"> 
      <?php
$oculto=$_POST['oculto'];
$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
if($_POST[oculto])
{
$linkbd=conectar_bd();
$crit1=" ";
$crit2=" ";
$crit3=" ";
$crit4=" ";
$crit5=" ";


if ($_POST[vigencia]!="")
$crit1=" and pptocdp.vigencia ='$_POST[vigencia]' ";
if ($_POST[numero]!="")
$crit2=" and pptocdp.consvigencia like '%$_POST[numero]%' ";
if ($_POST[fechaini]!="" and $_POST[fechafin]!="" )
{	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechaini],$fecha);
	$fechai=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fechafin],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];

$crit3=" and pptocdp.fecha between '$fechai' and '$fechaf'  ";
}

//sacar el consecutivo 
//$sqlr="select *from pptosideforigen where".$crit1.$crit2." order by pptosideforigen.codigo";
//if ($_POST[vigencia]!="" and $_POST[numero]!="" and  $_POST[fecha]!="" and  $_POST[solicita]!="" and $_POST[objeto]!="" )
//	$sqlr="select *from pptocdp order by pptocdp.consvigencia";
//else	 
	$sqlr="select *from pptocdp where pptocdp.estado<>'' ".$crit1.$crit2.$crit3." and pptocdp.vigencia=".$vigusu." order by pptocdp.consvigencia";

 echo "<div><div>sqlr:".$sqlr."</div></div>";
$resp = mysql_query($sqlr,$linkbd);
$ntr = mysql_num_rows($resp);
$con=1;
echo "<table class='inicio' align='center' width='80%'><tr><td colspan='11' class='titulos'>.: Resultados Busqueda:</td></tr><tr><td colspan='5'>Disponibilidad Presupuestal Encontrados: $ntr</td></tr><tr><td class='titulos2'>Vigencia</td><td class='titulos2'>CDP</td><td class='titulos2'>Objeto</td><td class='titulos2'>Valor</td><td class='titulos2' >Fecha</td><td class='titulos2'>Estado</td></tr>";	
//echo "nr:".$nr;
$iter='zebra1';
$iter2='zebra2';
$namearch="archivos/".$_SESSION[usuario]."listadocdps.csv";
$Descriptor1 = fopen($namearch,"w+"); 
fputs($Descriptor1,"VIGENCIA;CDP;OBJETO;VALOR;FECHA;ESTADO\r\n");
 while ($row =mysql_fetch_row($resp)) 
 {
	 //$sqlr2="select pptocdp.objeto from pptocdp where pptocdp.consvigencia=$row[2] and pptocdp.vigencia=$row[0]";
	 //$resp2 = mysql_query($sqlr2,$linkbd);
	 //$r2 =mysql_fetch_row($resp2);
	 $nrub=existecuentain($row[12]);
	 $tercero=buscatercero($row[5]);
	 echo "<tr class='$iter'><td >$row[1]</td><td >$row[2]</td><td >$row[7]</td><td >".number_format($row[4],2)."</td><td >".$row[3]."</td><td >$row[5]</td></tr>";
	  fputs($Descriptor1,$row[1].";".$row[2].";".$row[7].";".number_format($row[4],2,",","").";".$row[3].";".$row[5]."\r\n");
	 $con+=1;
	 $aux=$iter;
	 $iter=$iter2;
	 $iter2=$aux;
 }
 fclose($Descriptor1);
 echo"</table>";
}
?></div>
 </form>
</body>
</html>