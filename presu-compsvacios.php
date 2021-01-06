<?php //V 1000 12/12/16 ?> 
<?php
require"comun.inc";
require"funciones.inc";
session_start();
//**niveles menu: Administracion (0) - Consultas (1) - Herramientas (2) - Reportes (3)
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<title>:: Spid - Presupuesto</title>
<script>
//************* ver reporte ************
//***************************************
function verep(idfac)
{
  document.form1.oculto.value=idfac;
  document.form1.submit();
  }
//************* genera reporte ************
//***************************************
function genrep(idfac)
{
  document.form2.oculto.value=idfac;
  document.form2.submit();
  }
function pdf()
{
document.form2.action="pdfbalance.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
}
</script>
<script type="text/javascript" src="css/calendario.js"></script>
<script type="text/javascript" src="css/programas.js"></script>
<link href="css/css2.css" rel="stylesheet" type="text/css" />
<link href="css/css3.css" rel="stylesheet" type="text/css" />
<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
    <tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
    <tr><?php menu_desplegable("presu");?></tr>	
	<tr class="cinta">
	  	<td colspan="3" class="cinta">
			<a href="#" class="mgbt"><img src="imagenes/add2.png"  alt="Nuevo" title="Nuevo"/></a> 
			<a href="#" class="mgbt" ><img src="imagenes/guardad.png" alt="Guardar" /></a>
			<a href="#" class="mgbt" onClick="document.form2.submit()"> <img src="imagenes/busca.png" alt="Buscar" title="Buscar"/></a> 
			<a href="#" class="mgbt" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" alt="nueva ventana" title="Nueva Ventana"></a> 
			<a href="presu-estadocomprobantes.php" class="mgbt"><img src="imagenes/iratras.png" title="Retornar"></a>
	  	</td>
  	</tr>
</table>
<tr>
	<td colspan="3" class="tablaprin"> 
 	<form name="form2" method="post" action="presu-compsvacios.php"> 
  	<table  align="center" class="inicio" >
      <tr >
        <td class="titulos" colspan="8" >.: Comprobantes Vacios</td>
        <td  class="cerrar"><a href="presu-principal.php">Cerrar</a></td>
      </tr>
      <tr>
       <td class="saludo1" >Mes Inicial:</td>
        <td><input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">         <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>        </td>
        <td class="saludo1">Mes Final: </td>
        <td><input name="fecha2" type="text" id="fc_1198971546" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha2]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">         <a href="#" onClick="displayCalendarFor('fc_1198971546');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a> <input name="oculto" type="hidden" value="1" >        </td><td  class="saludo1" >Tipo Comprobante:          </td>
          <td  ><select name="tipocomprobante" onKeyUp='return tabular(event,this)' onChange="validar()">
		  <option value="">Seleccion Tipo Comprobante</option>	  
		   <?php
		   $link=conectar_bd();
  		   $sqlr="Select * from pptotipo_comprobante  where estado='S' order by nombre";
			// echo $sqlr;
		 		$resp = mysql_query($sqlr,$link);
				while ($row =mysql_fetch_row($resp)) 
				{
				$i=$row[3];
				echo "<option value=$row[3] ";
				if($i==$_POST[tipocomprobante])
			 	{
				 $_POST[ntipocomp]=$row[1];
				 echo "SELECTED";
				 }
				echo " >".$row[1]."</option>";	  
			     }			
		  ?>
		  </select></td><td ><input type="button" name="generar" value="Generar" onClick="document.form2.submit()"></td>
</tr></table>
<div class="subpantalla" style="height:68%; width:99.6%; overflow-x:hidden;">
  <?php
  $vigusu=vigencia_usuarios($_SESSION[cedulausu]);
  if($_POST['oculto'])
  {
	$crit1="";
	if($_POST[tipocomprobante]!="")
	{
	$crit1=" and pptocomprobante_cab.tipo_comp like '$_POST[tipocomprobante]'";
	}  
  ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf1=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
	$fechaf2=$fecha[3]."-".$fecha[2]."-".$fecha[1];
  //**** para sacar la consulta del balance se necesitan estos datos ********
  //**** nivel, mes inicial, mes final, cuenta inicial, cuenta final, cc inicial, cc final  
$oculto=$_POST['oculto'];
	$sumad=0;
	$sumac=0;	
	$co="zebra1";
	$co2="zebra2";
	$sqlr="select distinct pptocomprobante_det.id_det,pptocomprobante_cab.tipo_comp, pptocomprobante_cab.numerotipo, pptocomprobante_cab.fecha, pptocomprobante_cab.concepto, sum(pptocomprobante_det.valdebito), sum(pptocomprobante_det.valcredito) from pptocomprobante_cab,pptocomprobante_det where pptocomprobante_cab.fecha between '$fechaf1' and '$fechaf2' and pptocomprobante_det.tipo_comp=pptocomprobante_cab.tipo_comp AND pptocomprobante_det.numerotipo=pptocomprobante_cab.numerotipo  and pptocomprobante_cab.estado='1' ".$crit1." group by pptocomprobante_det.id_det,pptocomprobante_cab.tipo_comp, pptocomprobante_cab.numerotipo order by pptocomprobante_cab.tipo_comp, pptocomprobante_cab.numerotipo";	
ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
	$fechaf2=$fecha[3]."-".$fecha[2]."-".$fecha[1];	
  echo "<table class='inicio' ><tr><td colspan='9' class='titulos'>COMPROBANTES Vacios</td></tr>";
	 $nc=buscacuenta($_POST[cuenta]);
  echo "<tr><td class='titulos2'>TIPO COMPROBANTE</td><td class='titulos2' >COMPROBANTE</td><td class='titulos2'>FECHA</td><td class='titulos2'>CONCEPTO</td><td class='titulos2'>DEBITO</td><td class='titulos2'>CREDITO</td></tr>";
$linkbd=conectar_bd();
//echo $sqlr;
/*$res=mysql_query($sqlr,$linkbd);

while($row=mysql_fetch_row($res))
 {
	 if($row[5]!= $row[6])
	  {
	 $sqlr="select *from pptotipo_comprobante where codigo=$row[1]";
	 //echo $sqlr;
	 $res2=mysql_query($sqlr);
	 $row2=mysql_fetch_row($res2);
  echo "<tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase'><td >$row2[1]</td><td >$row[2]</td><td >$row[3]</td><td >$row[4]</td><td >".number_format($row[5],2)."</td><td>".number_format($row[6],2)."</td></tr>";
 	$sumad+=$row[5];
	$sumac+=$row[6];
	 $aux=$co;
		 $co=$co2;
		 $co2=$aux;
	  }
 }*/
 $sqlr="SELECT DISTINCT pptocomprobante_det.id_comp,pptocomprobante_cab.tipo_comp, pptocomprobante_cab.numerotipo, pptocomprobante_cab.fecha, pptocomprobante_cab.concepto,pptocomprobante_det.valdebito, pptocomprobante_det.valcredito,pptocomprobante_det.CUENTA from pptocomprobante_cab,pptocomprobante_det where pptocomprobante_cab.fecha between '$fechaf1' and '$fechaf2' and pptocomprobante_det.tipo_comp=pptocomprobante_cab.tipo_comp AND pptocomprobante_det.numerotipo=pptocomprobante_cab.numerotipo and pptocomprobante_cab.estado='1' AND pptocomprobante_det.CUENTA='' ".$crit1." group by pptocomprobante_det.id_comp,pptocomprobante_cab.tipo_comp, pptocomprobante_cab.numerotipo order by pptocomprobante_cab.tipo_comp, pptocomprobante_cab.numerotipo";
 $res=mysql_query($sqlr,$linkbd);
  while($row=mysql_fetch_row($res))
  {
	 $sqlr="select *from pptotipo_comprobante where codigo=$row[1]";
	 //echo $sqlr;
	 $res2=mysql_query($sqlr);
	 $row2=mysql_fetch_row($res2);
	echo "<tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase'><td >$row2[1]</td><td >$row[2]</td><td >$row[3]</td><td >$row[4] - CUENTA NO EXISTE '$row[7]' </td><td align='right'>".number_format($row[5],2)."</td><td align='right'>".number_format($row[6],2)."</td></tr>"; 
	$sumad+=$row[5];
	$sumac+=$row[6];
	 $aux=$co;
		 $co=$co2;
		 $co2=$aux;
  }
  
   $sqlr="SELECT pptocomprobante_cab.tipo_comp, pptocomprobante_cab.numerotipo, pptocomprobante_cab.fecha, pptocomprobante_cab.concepto,count(pptocomprobante_det.CUENTA),pptocomprobante_cab.estado from pptocomprobante_cab left join pptocomprobante_det  on pptocomprobante_det.tipo_comp=pptocomprobante_cab.tipo_comp AND pptocomprobante_det.numerotipo=pptocomprobante_cab.numerotipo where  pptocomprobante_cab.fecha between '$fechaf1' and '$fechaf2' and pptocomprobante_cab.estado='1' ".$crit1." group by  pptocomprobante_cab.tipo_comp, pptocomprobante_cab.numerotipo order by pptocomprobante_cab.tipo_comp, pptocomprobante_cab.numerotipo";
 //  echo $sqlr;
 $res=mysql_query($sqlr,$linkbd);
 while($row=mysql_fetch_row($res))
  {
   if($row[4]<=0)
   {
    $sqlr="select *from pptotipo_comprobante where codigo=$row[0]";
	 //echo $sqlr;
	 $res2=mysql_query($sqlr);
	 $row2=mysql_fetch_row($res2);
     $tipoc=$row2[1];
	if($row[5]==1)
	$estado="ACTIVO";
	else
	$estado="PASIVO";	
	echo "<tr class='$co' onMouseOver=\"anterior=this.style.backgroundColor;this.style.backgroundColor='#40b3ff';\"
onMouseOut=\"this.style.backgroundColor=anterior\" style='text-transform:uppercase'><td >$tipoc</td><td >$row[1]</td><td >$row[2]</td><td>EL COMPROBANTE NO TIENE MOVIMIENTOS - Estado: $estado</td><td align='right'>".number_format($row[6],2)."</td><td align='right'>".number_format($row[6],2)."</td></tr>"; 
	 $aux=$co;
		 $co=$co2;
		 $co2=$aux;
   }
  }
   
 echo "<tr>
 <td class='titulos2' align='center' colspan='4'>TOTALES:</td>
 <td class='titulos2' align='right'>$".number_format($sumad,2)."</td>
 <td class='titulos2' align='right'>$".number_format($sumac,2)."</td>
 </tr>
 </table>";
  }
?> 
</div>
</table></form>
</body>
</html>