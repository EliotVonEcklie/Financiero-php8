<?php //V 1000 12/12/16 ?> 
<!--V 1.0 24/02/2015-->
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
		<title>:: SieS - Contabilidad</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/calendario.js"></script>
        <script type="text/javascript" src="css/programas.js"></script>
<script>
function ponprefijo(pref,opc,objeto,nobjeto)
{ 
	//alert(pref+" "+opc+" "+ objeto+" "+nobjeto);
    opener.document.getElementById(''+objeto).value =pref  ;
	opener.document.getElementById(''+nobjeto).value =opc ;
	//opener.document.form2.cuenta.focus();
	//opener.document.form2.tercero.select();
    window.close() ;
} 
</script> 

<?php titlepag();?>
</head>
<body >
				
  <form action="" method="post" enctype="multipart/form-data" name="form1">
  <?php 
  if($_POST[oculto]==''){
	
	  $_POST[objeto1]=$_GET[objeto];
	  $_POST[nobjeto1]=$_GET[nobjeto];
  }
  ?>
  <table class="inicio">
    <tr >
      <td height="25" colspan="4" class="titulos" >Buscar CUENTAS </td>
    </tr>
		<tr>
		  <td colspan="4" class="titulos2" >:&middot; Por Descripcion </td>
		</tr>
				<tr >
				  <td class="saludo1" >:&middot; Numero Cuenta:</td>
				  <td  colspan="3"><input name="numero" type="text" size="30" >
			      <input name="oculto" type="hidden" id="oculto" value="1" >
			      <input type="submit" name="Submit" value="Buscar" >
			      </td>
			    </tr>
    <tr >
      <td colspan="4" align="center">&nbsp;</td>
      </tr>
  </table>
  <div class="subpantalla" style="height:76.5%; width:99.6%; overflow-x:hidden;">
    <table class="inicio">
    <tr >
      <td height="25" colspan="5" class="titulos" >Resultados Busqueda </td>
      </tr>
    <tr >
      <td style='width:4%'  class="titulos2" >Item</td>
      <td style='width:12%'class="titulos2" >Cuenta </td>
      <td class="titulos2" >Descripcion</td>
      <td style='width:14%'class="titulos2" >Tipo</td>
      <td style='width:6%' class="titulos2" >Estado</td>	  	  
    </tr>
	<script>document.form1.numero.focus();</script>
	<input type="hidden" id="objeto1" name="objeto1" value="<?php echo $_POST[objeto1]?>"/>
	<input type="hidden" id="nobjeto1" name="nobjeto1" value="<?php echo $_POST[nobjeto1]?>"/>
	<?php
	//$oculto=$_POST['oculto'];
	//if($oculto!="")
	{
		$link=conectar_bd();
  		$cond=" cuenta like'%".$_POST[numero]."%' or nombre like '%".strtoupper($_POST[numero])."%'";
		$sqlr="Select distinct * from cuentasnicsp where".$cond." order by cuenta";
		$resp = mysql_query($sqlr,$link);			
		$co='saludo1a';
	 	$co2='saludo2';	
	 	$i=1;
		while ($r =mysql_fetch_row($resp)) 
	    {
    		echo "<tr class='$co'  onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase' ";
			if ($r[5]=='Auxiliar')
			{echo "onClick=\"javascript:ponprefijo('$r[0]','$r[1]','$_POST[objeto1]','$_POST[nobjeto1]')\"";}
			echo"><td>$i</td>
			<td>$r[0]</td>
			<td>$r[1]</td>
			<td>$r[5]</td>
			<td style='text-align:center;'>$r[6]</td></tr>";
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
</form>
</body>
</html>
