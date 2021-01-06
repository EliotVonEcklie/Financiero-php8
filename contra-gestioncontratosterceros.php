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
<title>:: SieS</title>
<script src="css/calendario.js">
</script>
<script language="javascript">
var anterior;
</script>
<script> 
function ponprefijo(pref,opc){ 
//alert(pref);
    parent.document.form2.idcontratista.value =pref ;
	parent.document.form2.ncontratista.value =opc ;
	parent.document.form2.idcontratista.focus();
	parent.despliegamodal("hidden");

} 
</script> 
<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
<?php titlepag();?>
</head>
<body >
  <form action="" method="post" enctype="multipart/form-data" name="form1">
<table  class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="4">:: Buscar Contratista</td>
      </tr>
      <tr >
        <td class="saludo1">Nombre o apellidos:
        </td>
        <td><input name="nombre" type="text" value="" size="40">
        </td>
        <td class="saludo1">Documento:
        </td>
        <td><input name="documento" type="text" id="documento" value="">			      <input type="submit" name="Submit" value="Buscar" >
          <input name="oculto" type="hidden" value="1"></td>
       </tr>                       
    </table> </form>
      <?php
$oculto=$_POST['oculto'];
$linkbd=conectar_bd();
$crit1=" ";
$crit2=" ";
if ($_POST[nombre]!="")
$crit1=" and (terceros.nombre1 like '%".$_POST[nombre]."%' or terceros.nombre2 like '%".$_POST[nombre]."%' or terceros.apellido1 like '%".$_POST[nombre]."%' or terceros.apellido2 like '%".$_POST[nombre]."%' or terceros.razonsocial like '%".$_POST[nombre]."%') ";
if ($_POST[documento]!="")
$crit2=" and terceros.cedulanit like '%$_POST[documento]%' ";
//sacar el consecutivo 
$sqlr="select *from terceros where terceros.estado='S' ".$crit1.$crit2." order by terceros.apellido1,terceros.apellido2,terceros.nombre1,terceros.nombre2";
// echo "<div><div>sqlr:".$sqlr."</div></div>";
$resp = mysql_query($sqlr,$linkbd);
$ntr = mysql_num_rows($resp);
$con=1;
echo "<table class='inicio' align='center' width='99%'><tr><td colspan='8' class='titulos'>.: Resultados Busqueda:</td></tr><tr><td colspan='8'>Terceros Encontrados: $ntr</td></tr><tr><td class='titulos2' width='2%'>Item</td><td class='titulos2' width='30%'>RAZON SOCIAL</td><td class='titulos2' width='10%'>PRIMER APELLIDO</td><td class='titulos2' width='10%'>SEGUNDO APELLIDO</td><td class='titulos2' width='10%'>PRIMER NOMBRE</td><td class='titulos2' width='10%'>SEGUNDO NOMBRE</td><td class='titulos2' width='4%'>DOCUMENTO</td></tr>";	
//echo "nr:".$nr;
$iter='saludo1';
$iter2='saludo2';
 while ($row =mysql_fetch_row($resp)) 
 {
   if ($row[11]=='31')
   {
   $ntercero=$row[5];
   }
   else {
      $ntercero=$row[3].' '.$row[4].' '.$row[1].' '.$row[2];
   }
	 ?><tr onClick="javascript:ponprefijo('<?php echo $row[12] ?>','<?php echo  $ntercero ?>')">
	 <?php echo "<td class='$iter'>$con</td><td class='$iter'>".strtoupper($row[5])."</td><td class='$iter'>".strtoupper($row[3])."</td><td class='$iter'>".strtoupper($row[4])."</td><td class='$iter'>".strtoupper($row[1])."</td><td class='$iter'>".strtoupper($row[2])."<td class='$iter'>$row[12] </td></tr>";
	 $con+=1;
	 $aux=$iter;
	 $iter=$iter2;
	 $iter2=$aux;
 }
 echo"</table>";
?>
</body>
</html>
