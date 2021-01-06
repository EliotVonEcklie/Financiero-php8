<?php //V 1000 12/12/16 ?> 
<?php
require "comun.inc";
require"funciones.inc";
//require "encrip.inc";
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<title>SPID- Servicios Publicos</title>

<script language="javascript">
var anterior;

function ponprefijo(pref,opc,objeto,nobjeto){   
	opener.document.getElementById(''+objeto).value =pref  ;
	opener.document.getElementById(''+nobjeto).value =opc  ;
//	opener.document.form2.nobjeto.value =opc ;
	//opener.document.form2.tercero.focus();	
//	opener.document.form2.cc.select();
    window.close() ;
} 
</script> 
<script type="text/javascript" src="css/calendario.js"></script>
<link href="css/css2.css" rel="stylesheet" type="text/css" />
<?php titlepag();?>
</head>
<body >
  <form action="" method="post" enctype="multipart/form-data" name="form1">
  <?php
  if($_POST[oculto]=="")
  {
  $_POST[tobjeto]=$_GET[objeto];
  $_POST[tnobjeto]=$_GET[nobjeto];
  $_POST[tserv]=$_GET[servicio];
  }
  ?>
<table  class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="4">:: Buscar Tercero</td>
      </tr>
      <tr >
        <td class="saludo1">Nombre o apellidos:
        </td>
        <td><input name="nombre" type="text" value="" size="40">
        </td>
        <td class="saludo1">Documento:
        </td>
        <td><input name="documento" type="text" id="documento" value="">			      <input type="submit" name="Submit" value="Buscar" >
          <input name="oculto" type="hidden" value="1"><input name="tserv" type="hidden" value="<?php echo $_POST[tserv]?>"><input name="tobjeto" type="hidden" value="<?php echo $_POST[tobjeto]?>"><input name="tnobjeto" type="hidden" value="<?php echo $_POST[tnobjeto]?>"></td>
       </tr>                       
    </table> </form>
      <?php
$oculto=$_POST['oculto'];
if($_POST[oculto])
{
$linkbd=conectar_bd();
$crit1=" ";
$crit2=" ";
if ($_POST[nombre]!="")
$crit1=" and (terceros.nombre1 like '%".$_POST[nombre]."%' or terceros.nombre2 like '%".$_POST[nombre]."%' or terceros.apellido1 like '%".$_POST[nombre]."%' or terceros.apellido2 like '%".$_POST[nombre]."%' or terceros.razonsocial like '%".$_POST[nombre]."%' or terceros.cedulanit like '%$_POST[documento]%) ";
if ($_POST[documento]!="")
$crit2=" and terceros_servicios.cedulanit like '%$_POST[documento]%' ";
//sacar el consecutivo 
$sqlr="select terceros.razonsocial,terceros.apellido1,terceros.apellido2,terceros.nombre1,terceros.nombre2, terceros.cedulanit, terceros_servicios.consecutivo, terceros.tipodoc from terceros, terceros_servicios where terceros_servicios.cedulanit=terceros.cedulanit and terceros_servicios.servicio like '%$_POST[tserv]%' and terceros.estado='S'".$crit1.$crit2." order by terceros.apellido1,terceros.apellido2,terceros.nombre1,terceros.nombre2";
//	echo "<div><div>sqlr:".$sqlr."</div></div>";
$resp = mysql_query($sqlr,$linkbd);
$ntr = mysql_num_rows($resp);
$con=1;
echo "<table class='inicio' align='center' width='99%'><tr><td colspan='10' class='titulos'>.: Resultados Busqueda:</td></tr><tr><td colspan='8'>Terceros Encontrados: $ntr</td></tr><tr><td class='titulos2' width='2%'>Item</td><td class='titulos2' width='30%'>CODIGO CLIENTE</td><td class='titulos2' width='30%'>SERVICIO</td><td class='titulos2' width='30%'>RAZON SOCIAL</td><td class='titulos2' width='10%'>PRIMER APELLIDO</td><td class='titulos2' width='10%'>SEGUNDO APELLIDO</td><td class='titulos2' width='10%'>PRIMER NOMBRE</td><td class='titulos2' width='10%'>SEGUNDO NOMBRE</td><td class='titulos2' width='4%'>DOCUMENTO</td></tr>";	
//echo "nr:".$nr;
$iter='saludo1';
$iter2='saludo2';
 while ($row =mysql_fetch_row($resp)) 
 {
   if ($row[7]=='31')
   {
   $ntercero=$row[0];
   }
   else {
      $ntercero=$row[1].' '.$row[2].' '.$row[3].' '.$row[4];
   }
	 ?><tr onClick="javascript:ponprefijo('<?php echo $row[6] ?>','<?php echo  $row[5]." - ".$ntercero ?>','<?php echo  $_POST[tobjeto] ?>','<?php echo  $_POST[tnobjeto] ?>')">
	 <?php echo "<td class='$iter'>$con</td><td class='$iter'>".strtoupper($row[6])."</td><td class='$iter'>".strtoupper($_POST[tserv])."</td><td class='$iter'>".strtoupper($row[0])."</td><td class='$iter'>".strtoupper($row[1])."</td><td class='$iter'>".strtoupper($row[2])."</td><td class='$iter'>".strtoupper($row[3])."</td><td class='$iter'>".strtoupper($row[4])."<td class='$iter'>$row[5] </td></tr>";
	 $con+=1;
	 $aux=$iter;
	 $iter=$iter2;
	 $iter2=$aux;
 }
 echo"</table>";
}
?>
</body>
</html>
