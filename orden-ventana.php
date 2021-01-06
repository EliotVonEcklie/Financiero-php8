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
<title>:: SieS</title>
<script src="css/programas.js"></script>
<script src="css/calendario.js">
</script>
<script language="javascript">
var anterior;
</script>
<script> 
function ponprefijo(idrp,idcdp,det,valor,saldo,tercero){ 
//alert(pref);
    opener.document.form2.rp.value =idrp  ;
	opener.document.form2.cdp.value =idcdp ;
	opener.document.form2.detallecdp.value =det ;	
	opener.document.form2.valorrp.value =valor ;	
	opener.document.form2.saldorp.value =saldo ;
	opener.document.form2.valor.value =saldo ;	
	opener.document.form2.tercero.value =tercero ;	
	opener.document.form2.rp.focus();	
//	opener.document.form2.cc.select();
    window.close() ;
} 
</script> 
<link href="css/css2.css" rel="stylesheet" type="text/css" />
<?php titlepag();?>
</head>
<body >
  <form action="" method="post" enctype="multipart/form-data" name="form1">
<table  class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="4">:: Buscar Registro</td>
      </tr>
      <tr >
        <td class="saludo1">:: Numero Registro:
        </td>
        <td><input name="numero" type="text" value="" size="40" onKeyPress="javascript:return solonumeros(event)">
        </td>
		<td><input type="submit" name="Submit" value="Buscar" >
	        <input name="vigencia" type="hidden" value="<?php echo $_GET[vigencia]?>">
          <input name="oculto" type="hidden" value="1"></td>
       </tr>                       
    </table> </form>
      <?php
$oculto=$_POST['oculto'];
if($_POST[oculto])
{
$linkbd=conectar_bd();
$crit1=" ";
$crit2=" ";
if ($_POST[numero]!="")
$crit1=" and (pptorp.consvigencia like '%".$_POST[numero]."%') ";
$crit2=" and  pptorp.vigencia=$_POST[vigencia]";
//sacar el consecutivo 
$sqlr="select pptorp.vigencia,pptorp.consvigencia,pptocdp.objeto,pptorp.estado,pptocdp.consvigencia,pptorp.valor,pptorp.saldo,pptorp.tercero from pptorp,pptocdp where pptorp.estado='S' and pptorp.idcdp=pptocdp.consvigencia ".$crit1.$crit2."  order by pptorp.vigencia,pptorp.consvigencia,pptocdp.objeto,pptorp.estado";
 //echo "<div><div>sqlr:".$sqlr."</div></div>";
$resp = mysql_query($sqlr,$linkbd);
$ntr = mysql_num_rows($resp);
$con=1;
echo "<table class='inicio' align='center' width='99%'><tr><td colspan='8' class='titulos'>.: Resultados Busqueda:</td></tr><tr><td colspan='8'>Registros Presupuestales Encontrados: $ntr</td></tr><tr><td class='titulos2' width='2%'>Item</td><td class='titulos2' width='30%'>VIGENCIA</td><td class='titulos2' width='10%'>N° RP</td><td class='titulos2' width='10%'>DETALLE</td><td class='titulos2' width='4%'>ESTADO</td></tr>";	
//echo "nr:".$nr;
$iter='saludo1';
$iter2='saludo2';
 while ($row =mysql_fetch_row($resp)) 
 {
 $detalle=$row[2];
	 ?><tr onClick="javascript:ponprefijo('<?php echo $row[1] ?>','<?php echo  $row[4] ?>','<?php echo  $detalle ?>','<?php echo  $row[5] ?>','<?php echo  $row[6] ?>','<?php echo  $row[7] ?>')">
	 <?php echo "<td class='$iter'>$con</td><td class='$iter'>".strtoupper($row[0])."</td><td class='$iter'>".strtoupper($row[1])."</td><td class='$iter'>".strtoupper($row[2])."</td><td class='$iter'>".strtoupper($row[3])."</td></tr>";
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
