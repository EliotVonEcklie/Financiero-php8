<?php //V 1000 12/12/16 ?> 
<?php
require "comun.inc";
require "funciones.inc";
//require "encrip.inc";
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<title>:: SieS - Presupuesto</title>
<script src="css/calendario.js">
</script>
<script language="javascript">
var anterior;
</script>
<script> 
function ponprefijo(pref,opc){ 
    opener.document.form2.cuentap.value =pref  ;
	opener.document.form2.ncuentap.value =opc ;
	opener.document.form2.cuentap.focus();
//	opener.document.form2.tercero.select();
    window.close() ;
} 
</script> 
<link href="css/css2.css" rel="stylesheet" type="text/css" />
<?php titlepag();?>
</head>
<body >
<?php
$vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
if(!$_POST[tipo])
$_POST[tipo]=$_GET[ti];
?>
  <form action="" method="post" enctype="multipart/form-data" name="form1">
  <table class="inicio">
    <tr >
      <td height="25" colspan="4" class="titulos" >Buscar CUENTAS PRESUPUESTALES</td>
    </tr>
		<tr>
		  <td colspan="4" class="titulos2" >:&middot; Por Descripcion </td>
		</tr>
				<tr >
				  <td class="saludo1" >:&middot; Numero Cuenta:</td>
				  <td  colspan="3"><input name="numero" type="text" size="30" >
				  <input name="oculto" type="hidden" id="tipo" value="<?php echo $_POST[tipo]?>" >
			      <input name="oculto" type="hidden" id="oculto" value="1" >
			      <input type="submit" name="Submit" value="Buscar" >
			      </td>
			    </tr>
    <tr >
      <td colspan="4" align="center">&nbsp;</td>
      </tr>
  </table>
</form>
    <table class="inicio">
    <tr >
      <td height="25" colspan="5" class="titulos" >Resultados Busqueda </td>
      </tr>
    <tr >
      <td width="32" class="titulos2" >Item</td>
      <td width="76" class="titulos2" >Cuenta </td>
      <td width="140" class="titulos2" >Descripcion</td>	  
      <td width="140" class="titulos2" >Tipo</td>
      <td width="140" class="titulos2" >Estado</td>	  	  
    </tr>
<?php
$oculto=$_POST['oculto'];
$vigusu=vigencia_usuarios($_SESSION[cedulausu]); 
//echo $oculto;

$link=conectar_bd();
  $cond=" (cuenta like'%".$_POST[numero]."%' or nombre like '%".strtoupper($_POST[numero])."%')";
  if($_POST[tipo]=='1')
 $sqlr="Select distinct * from pptocuentas where  clasificacion='ingresos' and".$cond." and vigencia=".$vigusu." order by cuenta";
 else  $sqlr="Select distinct * from pptocuentas where  clasificacion!='ingresos' and".$cond." and vigencia=".$vigusu." order by cuenta";
//echo $sqlr;
$resp = mysql_query($sqlr,$link);			
$co='saludo1';
	 $co2='saludo2';	
	 $i=1;
		while ($r =mysql_fetch_row($resp)) 
	    {
    	 ?><tr class="<?php echo $co ?>" onMouseOver="anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';"
onMouseOut="this.style.backgroundColor=anterior" 
<?php
if ($r[2]=='Auxiliar')
{
?>onClick="javascript:ponprefijo('<?php echo $r[0] ?>','<?php echo  $r[1]?>')"
<?php } ?>
><td><?php echo $i?></td>
    	 <?php echo "<td >".$r[0]."</td>";
     	 echo "<td>".ucwords(strtolower($r[1]))."</td>";
      	 echo "<td>".$r[2]."</td>";
     	 echo "<td>".ucwords(strtolower($r[3]))."</td></tr>";
         $aux=$co;
         $co=$co2;
         $co2=$aux;
		 $i=1+$i;
   		}

$_POST[oculto]="";

?></table>
</div>
</body>
</html>
