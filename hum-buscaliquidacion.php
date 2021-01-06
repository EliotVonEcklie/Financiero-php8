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
<title>:: Spid - Gestion Humana</title>

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
document.form2.action="teso-pdfconsignaciones.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
}
</script>
<script type="text/javascript" src="css/calendario.js"></script>
<script type="text/javascript" src="css/programas.js"></script>
<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
    <tr><script>barra_imagenes("hum");</script><?php cuadro_titulos();?></tr>	 
    <tr><?php menu_desplegable("hum");?></tr>
<tr>
  <td colspan="3" class="cinta"><a href="hum-liquidarnomina.php" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a><img src="imagenes/guardad.png" title="Guardar" /><a onClick="document.form2.submit();" href="#" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a></td></tr>	
</table><tr><td colspan="3" class="tablaprin"> 
 <form name="form2" method="post" action="hum-buscaliquidacion.php">
<table  class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="6">:. Buscar Liquidacion </td>
        <td width="139" class="cerrar" ><a href="hum-principal.php">Cerrar</a></td>
      </tr>
      <tr >
        <td width="162" class="saludo1">Liquidacion:</td>
        <td ><input name="numero" type="text" value="" >       	   
          <input name="oculto" type="hidden" value="1"></td>
        </tr>                       
    </table>    </form> <div class="subpantalla">
      <?php
$oculto=$_POST['oculto'];
	if($_POST[oculto]==2)
	{
	 $linkbd=conectar_bd();	
	 $sqlr="select * from tesoreciboscaja where id_recibos=$_POST[var1]";
	 $resp = mysql_query($sqlr,$linkbd);
	 $row=mysql_fetch_row($resp);
	 //********Comprobante contable en 000000000000
	  $sqlr="update comprobante_cab set total_debito=0,total_credito=0,estado='0' where tipo_comp='5' and numerotipo=$row[0]";
	  mysql_query($sqlr,$linkbd);
	  //echo $sqlr;
	  $sqlr="update comprobante_det set valdebito=0,valcredito=0 where id_comp='5 $row[0]'";
	  mysql_query($sqlr,$linkbd);
	 //********PREDIAL O RECAUDO SE ACTIVA COLOCAR 'S'
	  if($row[10]=='1')
	   {
	  $sqlr="update tesoliquidapredial set estado='S' where id_predial=$row[4]";
	  mysql_query($sqlr,$linkbd);
	   }
	  if($row[10]=='2')
	   {
	  $sqlr="update tesoindustria set estado='S' where id_industria=$row[4]";
	  mysql_query($sqlr,$linkbd);		 
	   }
	  if($row[10]=='3')
	   {
 	  $sqlr="update tesorecaudos set estado='S' where id_recaudo=$row[4]";
	  mysql_query($sqlr,$linkbd);
	   } 
	 //******** RECIBO DE CAJA ANULAR 'N'	 
	  $sqlr="update tesoreciboscaja set estado='N' where id_recibos=$row[0]";
	  mysql_query($sqlr,$linkbd);
	  $sqlr="select * from pptorecibocajappto where idrecibo=$row[0]";
  	  $resp=mysql_query($sqlr,$linkbd);
	  while($r=mysql_fetch_row($resp))
	   {
		$sqlr="update pptocuentaspptoinicial set ingresos=ingresos-$r[3] where cuenta='$r[1]'";
		mysql_query($sqlr,$linkbd);
	   }	
	   $sqlr="delete from pptorecibocajappto where idrecibo=$row[0]";
  	  $resp=mysql_query($sqlr,$linkbd); 
	}

if($_POST[oculto])
{
$linkbd=conectar_bd();
$crit1=" ";
$crit2=" ";
if ($_POST[numero]!="")
$crit1=" and humnomina.id_nom like '%".$_POST[numero]."%' ";
//$sqlr="select *from pptosideforigen where".$crit1.$crit2." order by pptosideforigen.codigo";
	$sqlr="select *from humnomina where humnomina.estado!=''".$crit1." order by humnomina.id_nom";
// echo "<div><div>sqlr:".$sqlr."</div></div>";
$resp = mysql_query($sqlr,$linkbd);
$ntr = mysql_num_rows($resp);
$con=1;
echo "<table class='inicio' align='center' ><tr><td colspan='6' class='titulos'>.: Resultados Busqueda:</td></tr><tr><td colspan='2'>Liquidaciones Encontradas: $ntr</td></tr><tr><td class='titulos2'>No Liquidacion</td><td class='titulos2'>Fecha</td><td class='titulos2'>Mes</td><td class='titulos2' ><center>Estado</td><td class='titulos2'><center>Borrar</td><td class='titulos2' ><center>Editar</td></tr>";	
//echo "nr:".$nr;
$iter='saludo1';
$iter2='saludo2';
 while ($row =mysql_fetch_row($resp)) 
 {
	 $sqlr2="select count(*) from humnomina_aprobado where humnomina_aprobado.estado='S' and humnomina_aprobado.id_nom='$row[0]' ";
$resp2 = mysql_query($sqlr2,$linkbd);
	 $row2 =mysql_fetch_row($resp2);
	 $conc=$row2[0];
	 echo "<tr ><td class='$iter'>$row[0]</td><td class='$iter'>$row[1]</td><td class='$iter'>$row[3]</td><td class='$iter'>$row[8]</td><td class='$iter'>";
	 if($row2[0]==0)
	  echo "<a href='#'><center><img src='imagenes/anular.png'></center></a></td>";
	  else
	  echo "<a href='#'><center>APROBADA</center></a></td>";
	 echo "<td class='$iter'><a href='hum-editavariablesnomina.php?idr=$row[0]'><center><img src='imagenes/buscarep.png'></center></a></td></tr>";
	 $con+=1;
	 $aux=$iter;
	 $iter=$iter2;
	 $iter2=$aux;
	
 }
 echo"</table>";
}
?></div>
</td></tr>     
</table>
</body>
</html>