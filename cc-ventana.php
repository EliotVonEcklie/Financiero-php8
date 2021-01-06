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
		<title>:: Spid - Contabilidad</title>
        <link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/calendario.js"></script>
<script> 
function ponprefijo(pref,opc){ 
	//alert(pref);
    opener.document.form2.cc.value =pref  ;	
	opener.document.form2.ncc.value =opc ;
    opener.document.form2.cc.focus();
	//opener.document.form2.detalle.select();	
    window.close() ;
} 
</script> 
<?php titlepag();?>
</head>
<body >
  <form action="" method="post" enctype="multipart/form-data" name="form1">
<table  class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="4">:: Buscar Centro Costo</td>
      </tr>
      <tr >
        <td class="saludo1">:: Nombre:
        </td>
        <td><input name="nombre" type="text" value="" size="40">
        </td>
        <td class="saludo1">:: Codigo:
        </td>
        <td><input name="documento" type="text" id="documento" value="">			      <input type="submit" name="Submit" value="Buscar" >
          <input name="oculto" type="hidden" value="1"></td>
       </tr>                       
    </table> 
    <div class="subpantalla" style="height:84.5%; width:99.6%; overflow-x:hidden;">
  	<?php
	$oculto=$_POST['oculto'];
	if($_POST[oculto])
	{
		$linkbd=conectar_bd();
		$crit1=" ";
		$crit2=" ";
		if ($_POST[nombre]!=""){$crit1=" and (centrocosto.nombre like '%".$_POST[nombre]."%' ) ";}
		if ($_POST[documento]!=""){$crit2=" and centrocosto.id_cc like '%$_POST[documento]%' ";}
		//sacar el consecutivo 
		$sqlr="select *from centrocosto where centrocosto.estado='S'".$crit1.$crit2." order by centrocosto.nombre";
		// echo "<div><div>sqlr:".$sqlr."</div></div>";
		$resp = mysql_query($sqlr,$linkbd);
		$ntr = mysql_num_rows($resp);
		$con=1;
		echo "<table class='inicio' align='center' width='99%'><tr><td colspan='8' class='titulos'>.: Resultados Busqueda:</td></tr><tr><td colspan='8'>Centro Costo Encontrados: $ntr</td></tr><tr><td class='titulos2' width='2%'>Item</td><td class='titulos2' width='10%'>Codigo</td><td class='titulos2' width='80%'>Nombre</td><td class='titulos2' width='10%'>Estado</td></tr>";	
		//echo "nr:".$nr;
		$iter='saludo1a';
		$iter2='saludo2';
 		while ($row =mysql_fetch_row($resp)) 
 		{
    		$ncc=$row[1];
	 		echo"<tr class='$iter' style='text-transform:uppercase' onClick=\"javascript:ponprefijo('$row[0]','$ncc')\" onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\">
			<td>$con</td>
			<td>$row[0]</td>
			<td>$row[1]</td>
			<td>$row[2] </td></tr>";
	 $con+=1;
	 $aux=$iter;
	 $iter=$iter2;
	 $iter2=$aux;
 }
 echo"</table>";
}
?>
</div>
</form>
</body>
</html>  
