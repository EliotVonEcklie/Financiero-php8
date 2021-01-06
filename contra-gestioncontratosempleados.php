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
<title>:: Spid</title>
<script src="css/calendario.js">
</script>
<script language="javascript">
var anterior;
</script>
<script> 
function ponprefijo(pref,opc,valor,valor2)
{   
	switch(document.getElementById('indica').value)
	{
		case "1":
			parent.document.form2.tercero.value =pref;
			parent.document.form2.ntercero.value =opc;
			parent.document.form2.dependencia.value =valor;
			parent.document.form2.iddependencia.value =valor2;
			parent.despliegamodal("hidden","0");
			break;
		case "2":
			parent.document.form2.realizado.value =pref;
			parent.document.form2.nrealizado.value =opc;
			parent.document.form2.drealizado.value =valor;
			parent.document.form2.idrealizado.value =valor2;
			parent.despliegamodal("hidden","0");
			break;
		case "3":
			parent.document.form2.revisado.value =pref;
			parent.document.form2.nrevisado.value =opc;
			parent.document.form2.drevisado.value =valor;
			parent.document.form2.idrevisado.value =valor2;
			parent.despliegamodal("hidden","0");
			break;
		case "4":
			parent.document.form2.firmado.value =pref;
			parent.document.form2.nfirmado.value =opc;
			parent.document.form2.dfirmado.value =valor;
			parent.document.form2.idfirmado.value =valor2;
			parent.despliegamodal("hidden","0");
			break;
	}
} 
</script> 
<link href="css/css2.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
		<link href="css/css3.css?<?php echo date('d_m_Y_h_i_s');?>" rel="stylesheet" type="text/css" />
<?php titlepag();?>
</head>
<body>
  <form action="" method="post" enctype="multipart/form-data" name="form1">
  <?php 
  $_POST[indica]=$_GET[ind];
  ?>
<table  class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="4">:: Buscar Empleado</td>
      </tr>
      <tr >
        <td class="saludo1">Nombre o apellidos:
        </td>
        <td><input name="nombre" type="text" value="" size="40">
        </td>
        <td class="saludo1">Documento:
        </td>
        <td><input name="documento" type="text" id="documento" value=""> <input type="submit" name="Submit" value="Buscar" >
          <input name="oculto" type="hidden" value="1"><input name="tobjeto" type="hidden" value="<?php echo $_POST[tobjeto]?>"><input name="tnobjeto" type="hidden" value="<?php echo $_POST[tnobjeto]?>"></td>
       </tr>                       
    </table> 
    <input type="hidden" name="indica" id="indica" value="<?php echo $_POST[indica];?>">
    </form>
      <?php
$oculto=$_POST['oculto'];
$linkbd=conectar_bd();
$crit1=" ";
$crit2=" ";
if ($_POST[nombre]!="")
$crit1=" AND (t.nombre1 like '%".$_POST[nombre]."%' OR t.nombre2 like '%".$_POST[nombre]."%' OR t.apellido1 like '%".$_POST[nombre]."%' OR t.apellido2 like '%".$_POST[nombre]."%' ) ";
if ($_POST[documento]!="")
$crit2=" and t.cedulanit like '%$_POST[documento]%' ";
//sacar el consecutivo 
$sqlr="SELECT t.*, pl.*, pt.* FROM terceros t, planestructura_terceros pt, planaccargos pl WHERE pt.estado='S' AND pt.cedulanit = t.cedulanit AND pl.codcargo = pt.codcargo".$crit1.$crit2." order by t.apellido1, t.apellido2, t.nombre1, t.nombre2";
	// echo "<div><div>sqlr:".$sqlr."</div></div>";
$resp = mysql_query($sqlr,$linkbd);
$ntr = mysql_num_rows($resp);
$con=1;
echo "<table class='inicio' align='center' width='99%'><tr><td colspan='9' class='titulos'>.: Resultados Busqueda:</td></tr><tr><td colspan='9'>Terceros Encontrados: $ntr</td></tr><tr><td class='titulos2' width='2%'>Item</td><td class='titulos2' width='30%'>Dependencia</td><td class='titulos2' width='30%'>CARGO</td><td class='titulos2' width='10%'>PRIMER APELLIDO</td><td class='titulos2' width='10%'>SEGUNDO APELLIDO</td><td class='titulos2' width='10%'>PRIMER NOMBRE</td><td class='titulos2' width='10%'>SEGUNDO NOMBRE</td><td class='titulos2' width='4%'>DOCUMENTO</td></tr>";	
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
   $dependencia=strtoupper(buscarareatrabajo($row[25]));
	 ?><tr class="<?php echo $iter ?>" onClick="javascript:ponprefijo('<?php echo $row[12]?>','<?php echo $ntercero?>','<?php echo $dependencia?>','<?php echo $row[25]?>','<?php echo $_POST[tobjeto]?>','<?php echo $_POST[tnobjeto]?>','<?php echo $_POST[tobjeto2]?>','<?php echo $_POST[tobjeto3]?>')">
	 <?php echo "<td>$con</td><td >".strtoupper($dependencia)."</td><td >".strtoupper($row[24])."</td><td>".strtoupper($row[3])."</td><td>".strtoupper($row[4])."</td><td >".strtoupper($row[1])."</td><td >".strtoupper($row[2])."<td>$row[12] </td></tr>";
	 $con+=1;
	 $aux=$iter;
	 $iter=$iter2;
	 $iter2=$aux;
 }
 echo"</table>";

?>
</body>
</html>
