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
<title>:: SPID - Servicios Publicos</title>
<script src="css/calendario.js">
</script>
<script language="javascript">
var anterior;
</script>
<script> 
function ponprefijo(pref,opc){ 
//alert(pref);
    opener.document.form2.medidor.value =pref  ;
//	opener.document.form2.ncuenta.value =opc ;
	opener.document.form2.medidor.focus();
//	opener.document.form2.tercero.select();
		
    window.close() ;
} 
</script> 
<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
<?php titlepag();?>
</head>
<body >
  <form action="" method="post" enctype="multipart/form-data" name="form1">
  <table class="inicio">
    <tr >
      <td height="25" colspan="4" class="titulos" >Buscar Medidores </td>
    </tr>
		<tr>
		  <td colspan="4" class="titulos2" >:&middot; Por Descripcion </td>
		</tr>
				<tr >
				  <td class="saludo1" >:&middot; Numero Codigo o Descripcion:</td>
				  <td  colspan="3"><input name="numero" type="text" size="30" >
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
      <td height="25" colspan="6" class="titulos" >Resultados Busqueda </td>
      </tr>
    <tr >
      <td width="32" class="titulos2" >Item</td>
      <td width="76" class="titulos2" >Codigo </td>
      <td width="140" class="titulos2" >Descripcion</td>
      <td width="140" class="titulos2" >Ref</td>
      <td width="140" class="titulos2" >Medida</td>
      <td width="140" class="titulos2" >Estado</td>	  	  
    </tr>
	<?php
$oculto=$_POST['oculto'];
//echo $oculto;
if($oculto!="")
{
$link=conectar_bd();
if($_POST[numero]!="")
  $cond="and codigo like'%".$_POST[numero]."%' or descripcion like '%".strtoupper($_POST[numero])."%'";
 $sqlr="Select distinct * from servmedidores where estado='S' and (cliente IS NULL or  cliente='')".$cond." order by codigo";
//echo $sqlr;
$resp = mysql_query($sqlr,$link);			
$co='saludo1';
	 $co2='saludo2';	
	 $i=1;
		while ($r =mysql_fetch_row($resp)) 
	    {
    	 ?><tr class="<?php echo $co ?>" onMouseOver="anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';"
onMouseOut="this.style.backgroundColor=anterior" 
onClick="javascript:ponprefijo('<?php echo $r[0] ?>','<?php echo  $r[1]?>')"
><td><?php echo $i?></td>
    	 <?php echo "<td >".$r[0]."</td>";
     	 echo "<td>".ucwords(strtolower($r[1]))."</td>";
      	 echo "<td>".$r[5]."</td>";
     	 echo "<td>".ucwords(strtolower($r[6]))."</td><td>".ucwords(strtolower($r[9]))."</td></tr>";
         $aux=$co;
         $co=$co2;
         $co2=$aux;
		 $i=1+$i;
   		}

$_POST[oculto]="";
}
?>
</table>
</div>
</body>
</html>
