<?php //V 1000 12/12/16 ?> 
<?php
require "comun.inc";
require"funciones.inc";
//require "encrip.inc";
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
  <head>
    <meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
    <meta http-equiv="X-UA-Compatible" content="IE=9"/>
<title>:: Siip - Tesoreria</title>
<script src="css/calendario.js">
</script>
<script language="javascript">
var anterior;
</script>
<script> 
function ponprefijo(pref,opc){ 
//alert(pref);
      /*opener.document.form2.codingreso.value =pref;	
      opener.document.form2.ningreso.value =opc;
      opener.document.form2.codingreso.focus();*/

//    opener.document.form2.detalle.select();	
    //window.close() ;
      parent.document.form2.codingreso.value =pref; 
      parent.document.form2.ningreso.value =opc
      parent.despliegamodal2("hidden");
} 
</script> 
<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
<?php titlepag();?>
</head>
<body >
<?php
if(!$_POST[tipo])
{
$_POST[tipo]=$_GET[ti];
$_POST[modulo]=$_GET[modulo];
}
?>
  <form action="" method="post" enctype="multipart/form-data" name="form1">
<table  class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="4">:: Buscar Ingresos</td>
		<td style="width:7%" class="cerrar" ><a onClick="parent.despliegamodal2('hidden');" style="cursor:pointer;">Cerrar</a></td>
      </tr>
      <tr >
        <td class="saludo1">:: Nombre:
        </td>
        <td><input name="nombre" type="text" value="" size="40">
        </td>
        <td class="saludo1">:: Codigo:
        </td>
        <td><input name="documento" type="text" id="documento" value=""> <input type="submit" name="Submit" value="Buscar" >
          <input name="oculto" type="hidden" value="1"><input name="tipo" type="hidden" value="<?php echo $_POST[tipo]?>"><input name="modulo" type="hidden" value="<?php echo $_POST[modulo]?>"></td>
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
$crit1=" and (tesoingresos.nombre like '%".$_POST[nombre]."%' ) ";
if ($_POST[documento]!="")
$crit2=" and tesoingresos.codigo like '%$_POST[documento]%' ";
//sacar el consecutivo 
$sqlr="select *from tesoingresos where tesoingresos.estado='S'".$crit1.$crit2."  order by tesoingresos.codigo";
	// echo "<div><div>sqlr:".$sqlr."</div></div>";
$resp = mysql_query($sqlr,$linkbd);
$ntr = mysql_num_rows($resp);
$con=1;
echo "<table class='inicio' align='center' width='99%'><tr><td colspan='8' class='titulos'>.: Resultados Busqueda:</td></tr><tr><td colspan='8'>Ingresos Encontrados: $ntr</td></tr><tr><td class='titulos2' width='2%'>Item</td><td class='titulos2' width='10%'>Codigo</td><td class='titulos2' width='80%'>Nombre</td><td class='titulos2' width='10%'>Tipo</td><td class='titulos2' width='10%'>Estado</td></tr>";	
//echo "nr:".$nr;
$iter='saludo1';
$iter2='saludo2';
 while ($row =mysql_fetch_row($resp)) 
 {
    $ncc=$row[1];
	 ?><tr onClick="javascript:ponprefijo('<?php echo $row[0] ?>','<?php echo  $ncc ?>')">
	 <?php echo "<td class='$iter'>$con</td><td class='$iter'>".strtoupper($row[0])."</td><td class='$iter'>".strtoupper($row[1])."</td><td class='$iter'>$row[2] </td><td class='$iter'>$row[3] </td></tr>";
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
