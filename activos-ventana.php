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
		<title>:: Spid - Activos Fijos</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="css/calendario.js"></script>
<script> 
function ponprefijo(pref,opc,cc,area,ubicacion,prototipo,disposicion,objeto,nobjeto,objeto2,objeto3,objeto4,objeto5,objeto6){ 
    opener.document.getElementById(''+objeto).value =pref;
	opener.document.getElementById(''+nobjeto).value =opc;
	opener.document.getElementById(''+objeto2).value =cc;
	opener.document.getElementById(''+objeto3).value =area;
	opener.document.getElementById(''+objeto4).value =ubicacion;
	opener.document.getElementById(''+objeto5).value =prototipo;
	opener.document.getElementById(''+objeto6).value =disposicion;
	opener.document.form2.submit();	
    window.close() ;
} 
function buscar()
{
	document.form2.oculto.value=1;
	document.form2.submit();
}
</script> 
<?php titlepag();?>
</head>
<body >
  <form action="" method="post" enctype="multipart/form-data" name="form1">
  <?php
  if($_POST[oculto]=="" || $_POST[oculto]==1)
  {
  $_POST[tobjeto]=$_GET[objeto];
  $_POST[tnobjeto]=$_GET[nobjeto];
  $_POST[tobjeto2]=$_GET[objeto2];
  $_POST[tobjeto3]=$_GET[objeto3];
  $_POST[tobjeto4]=$_GET[objeto4];  
  $_POST[tobjeto5]=$_GET[objeto5];  
  $_POST[tobjeto6]=$_GET[objeto6];  
  }
  ?>
<table  class="inicio" align="center" >
	<tr >
        <td class="titulos" colspan="4">:: Buscar Activo Fijo</td>
	</tr>
	<tr >
        <td class="saludo1">:: Nombre:</td>
        <td><input name="nombre" type="text" value="" size="40"></td>
        <td class="saludo1">:: Placa:</td>
        <td>
			<input name="documento" type="text" id="documento" value=""> 
			<input type="submit" name="Submit" value="Buscar" onClick="buscar()">
			<input name="oculto" type="hidden" value="1">
			<input name="tobjeto" type="hidden" value="<?php echo $_POST[tobjeto]?>">
			<input name="tnobjeto" type="hidden" value="<?php echo $_POST[tnobjeto]?>">
			<input name="tobjeto2" type="hidden" value="<?php echo $_POST[tobjeto2]?>">
			<input name="tobjeto3" type="hidden" value="<?php echo $_POST[tobjeto3]?>">
			<input name="tobjeto4" type="hidden" value="<?php echo $_POST[tobjeto4]?>">
			<input name="tobjeto5" type="hidden" value="<?php echo $_POST[tobjeto5]?>">
			<input name="tobjeto6" type="hidden" value="<?php echo $_POST[tobjeto6]?>">
		</td>
	</tr>                       
</table> 
    <div class="subpantalla" style="height:84.5%; width:99.6%; overflow-x:hidden;">
  	<?php
	$oculto=$_POST[oculto];
	if($_POST[oculto]=="" || $_POST[oculto]==1)
	{
		$linkbd=conectar_bd();
		$crit1=" ";
		$crit2=" ";
		if ($_POST[nombre]!=""){$crit1=" and acticrearact_det.nombre like '%".$_POST[nombre]."%' ";}
		if ($_POST[documento]!=""){$crit2=" and acticrearact_det.placa like '%".$_POST[documento]."%' ";}
		//sacar el consecutivo 
		$sqlr="select * from acticrearact_det where acticrearact_det.estado='S'".$crit1.$crit2." order by acticrearact_det.nombre";
		// echo "<div><div>sqlr:".$sqlr."</div></div>";
		$resp = mysql_query($sqlr,$linkbd);
		$ntr = mysql_num_rows($resp);
		$con=1;
		echo "<table class='inicio' align='center' width='99%'><tr><td colspan='8' class='titulos'>.: Resultados Busqueda:</td></tr><tr><td colspan='8'>Activos Fijos Encontrados: $ntr</td></tr><tr><td class='titulos2' width='2%'>Item</td><td class='titulos2' width='10%'>Placa</td><td class='titulos2' width='80%'>Nombre</td><td class='titulos2' width='80%'>Centro Costo</td><td class='titulos2' width='80%'>Area</td><td class='titulos2' width='80%'>Ubicacion</td><td class='titulos2' width='10%'>Estado</td></tr>";	
		//echo "nr:".$nr;
		$iter='saludo1a';
		$iter2='saludo2';
 		while ($row =mysql_fetch_row($resp)) 
 		{
    		$ncc=$row[2];
			echo"<tr class='$iter' style='text-transform:uppercase' onClick=\"javascript:ponprefijo('$row[1]','$ncc','$row[14]','$row[11]','$row[12]','$row[28]','$row[30]','$_POST[tobjeto]','$_POST[tnobjeto]','$_POST[tobjeto2]','$_POST[tobjeto3]','$_POST[tobjeto4]','$_POST[tobjeto5]','$_POST[tobjeto6]')\" onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\" onMouseOut=\"this.style.backgroundColor=anterior\">
			<td>$con</td>
			<td>$row[1]</td>
			<td>$ncc</td>
			<td>$row[14]</td>
			<td>$row[11]</td>
			<td>$row[12]</td>
			<td>$row[24] </td></tr>";
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