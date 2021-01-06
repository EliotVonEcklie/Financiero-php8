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

function redireccion(comprobante){
	location.href="teso-editasinsituacionegreso.php?idrecaudo="+comprobante;
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
			<a href="teso-sinsituacionegreso.php" class="mgbt"><img src="imagenes/add.png" alt="Nuevo" title="Nuevo"/></a>
			<a class="mgbt"><img src="imagenes/guardad.png"/></a>
			<a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a>
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a>
		</td>
	</tr>	
</table>
 <form name="form2" method="post" action="teso-buscasinsituacionegreso.php">
<table  class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="6">:. Buscar Egresos Sin Situacion de Fondos - SSF</td>
        <td width="70" class="cerrar" ><a href="teso-principal.php"> Cerrar</a></td>
      </tr>
      <tr >
        <td width="168" class="saludo1">Numero Egreso:</td>
        <td width="154" ><input name="numero" type="text" value="" >
        </td>
         <td width="144" class="saludo1">Concepto: </td>
    <td width="498" ><input name="nombre" type="text" value="" size="80" ></td>
  
	   
          <input name="oculto" type="hidden" value="1"><input name="var1" type="hidden" value=<?php echo $_POST[var1];?>>
        </tr>                       
    </table>   
    <div class="subpantallap" style="height:68.5%; width:99.6%; overflow-x:hidden;">
     <?php
	 $vigusu=vigencia_usuarios($_SESSION[cedulausu]);
	 $_POST[vigencia]=$vigusu;
	$oculto=$_POST['oculto'];
	if($_POST[oculto]==2)
	{
	
	 $linkbd=conectar_bd();	
	 $sqlr="select * from tesossfegreso_cab where id_orden=$_POST[var1] and vigencia=$_POST[vigencia]";
	 
	 $resp = mysql_query($sqlr,$linkbd);
	 $row=mysql_fetch_row($resp);			
	 //********Comprobante contable en 000000000000
	  $sqlr="update comprobante_cab set total_debito=0,total_credito=0,estado='0' where numerotipo=$row[0] AND tipo_comp=21";
	 // echo $sqlr;
	  mysql_query($sqlr,$linkbd);
	  $sqlr="update comprobante_det set valdebito=0,valcredito=0 where numerotipo=$row[0] AND tipo_comp=21";
	  mysql_query($sqlr,$linkbd);
	
	 //******** RECIBO DE CAJA ANULAR 'N'	 
	  $sqlr="update tesossfegreso_cab set estado='N' where id_orden=$row[0]";
	  mysql_query($sqlr,$linkbd);
	   $sqlr="update pptocomprobante_cab set estado='0' where numerotipo=$row[0] AND tipo_comp=13";
	 // echo $sqlr;
	  mysql_query($sqlr,$linkbd);	  
	}
   ?>
      <?php
	 
$oculto=$_POST['oculto'];

$linkbd=conectar_bd();
$crit1=" ";
$crit2=" ";
if ($_POST[numero]!="")
$crit1=" and tesossfegreso_cab.id_orden  like '%".$_POST[numero]."%' ";
if ($_POST[nombre]!="")
$crit2=" and tesossfegreso_cab.concepto like '%".$_POST[nombre]."%'  ";
//sacar el consecutivo 
//$sqlr="select *from pptosideforigen where".$crit1.$crit2." order by pptosideforigen.codigo";
	$sqlr="select *from tesossfegreso_cab where tesossfegreso_cab.id_orden>-1 ".$crit1.$crit2." order by tesossfegreso_cab.id_orden";

// echo "<div><div>sqlr:".$sqlr."</div></div>";
$resp = mysql_query($sqlr,$linkbd);
$ntr = mysql_num_rows($resp);
$con=1;

echo "<table class='inicio'><tr><td colspan='9' class='titulos'>.: Resultados Busqueda:</td></tr><tr><td class='saludo3' colspan='9'>Recaudos Encontrados: $ntr</td></tr><tr><td class='titulos2'>Codigo</td><td class='titulos2'>Fecha</td><td class='titulos2'>Tercero</td><td class='titulos2'>Descripcion</td><td class='titulos2'>Valor</td><td class='titulos2'>Vigencia</td><td class='titulos2'>Estado</td><td class='titulos2' width='5%'><center>Anular</td><td class='titulos2' width='5%'><center>Ver</td></tr>";	
//echo "nr:".$nr;
$iter='saludo1a';
$iter2='saludo2';
 while ($row =mysql_fetch_row($resp)) 
 {
	 $nter=buscatercero($row[6]);
		if($row[8]=='S'){$imgsem="src='imagenes/sema_verdeON.jpg' title='Activo'";} 	 				  
		if($row[8]=='N'){$imgsem="src='imagenes/sema_rojoON.jpg' title='Anulado'";} 	
	 echo "<tr class='$iter' onDblClick='redireccion($row[0])' ><td>$row[0]</td><td>$row[2]</td><td>$row[6] - $nter</td><td>$row[7]</td><td>".number_format($row[10],2,",",".")."</td><td >$row[3]</td><td style='text-align:center;'><img $imgsem style='width:18px'/>Activo</td>";
	 	 if($row[13]=='S')
		 echo "<td style='text-align:center;'><a href='#'  onClick=eliminar($row[0])><img src='imagenes/anular.png'></a></td>";		 
	 	 if($row[13]=='N')
		 echo "<td class='$iter'>Anulado</td>";	 
	 echo "<td style='text-align:center;'><a href='teso-editasinsituacionegreso.php?idrecaudo=$row[0]'><img src='imagenes/lupa02.png' style='width:18px'></a></td></tr>";
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