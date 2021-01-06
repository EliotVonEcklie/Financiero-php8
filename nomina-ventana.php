<?php //V 1000 12/12/16 ?> 
<!--V 1.0 24/02/2015-->
<?php 
	require "comun.inc";
	require"funciones.inc";
?>
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
        <title>:: SieS</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/programas.js"></script>
        <script type="text/javascript" src="css/calendario.js"></script>
<script> 
function ponprefijo(nomina,registro){ 
//alert(pref);
    opener.document.form2.orden.value =nomina  ;
	opener.document.form2.rp.value =registro ;
	opener.document.form2.orden.focus();	
//	opener.document.form2.cc.select();
    window.close() ;
} 
</script> 
<?php titlepag();?>
</head>
<body >
  <form action="" method="post" enctype="multipart/form-data" name="form1">
<table  class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="4">:: Buscar Nomina</td>
      </tr>
      <tr >
        <td class="saludo1">:: Numero Nomina:
        </td>
        <td><input name="numero" type="text" value="" size="40" onKeyPress="javascript:return solonumeros(event)">
        </td>
		<td><input type="submit" name="Submit" value="Buscar" >
	        <input name="vigencia" type="hidden" value="<?php echo $_GET[vigencia]?>">
          <input name="oculto" type="hidden" value="1"></td>
       </tr>                       
    </table> 
    <div class="subpantalla" style="height:85.5%; width:99.6%; overflow-x:hidden;">
	<?php
	//$oculto=$_POST['oculto'];
	//if($_POST[oculto])
	{
		$linkbd=conectar_bd();
		$crit1=" ";
		$crit2=" ";
		if ($_POST[numero]!=""){$crit1=" and (id_nom like '%".$_POST[numero]."%') ";}
		$sqlr="select id_nom, id_rp, FECHA, ESTADO from humnomina_aprobado where estado='S'  ".$crit1.$crit2."  order by id_nom desc";
		$resp = mysql_query($sqlr,$linkbd);
		$ntr = mysql_num_rows($resp);
		$con=1;
		echo "<table class='inicio' align='center' width='99%'><tr><td colspan='8' class='titulos'>.: Resultados Busqueda:</td></tr><tr><td colspan='8'>Liquidaciones de Nomina Encontrados: $ntr</td></tr><tr><td class='titulos2' width='2%'>Item</td><td class='titulos2' width='30%'>Nomina</td><td class='titulos2' width='10%'>N° RP</td><td class='titulos2' width='10%'>FECHA</td><td class='titulos2' width='4%'>ESTADO</td></tr>";	
		$iter='saludo1a';
		$iter2='saludo2';
 		while ($row =mysql_fetch_row($resp)) 
 		{
 			$detalle=$row[2];
	 		echo"<tr class='$iter' onClick=\"javascript:ponprefijo('$row[0]','$row[1]')\" onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\" >
			<td>$con</td>
			<td>$row[0]</td>
			<td>$row[1]</td>
			<td>$row[2]</td>
			<td style='text-transform:uppercase;text-align:center;'>$row[3]</td></tr>";
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
