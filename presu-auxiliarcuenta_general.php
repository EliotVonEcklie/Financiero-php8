<?php //V 1000 12/12/16 ?> 
<?php
	require"comun.inc";
	require"funciones.inc";
	session_start();
	$linkbd=conectar_bd();	
	cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
	header("Cache-control: private"); // Arregla IE 6
	date_default_timezone_set("America/Bogota");
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: SPID - Presupuesto</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css"/>
        <script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
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
document.form2.action="pdfauxiliaringpres.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
}
function buscacta(e)
 {
if (document.form2.cuenta.value!="")
{
 document.form2.bc.value=2;
 document.form2.submit();
 }
 }

function excell()
{
document.form2.action="presu-auxiliarcuenta2excel.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
}
</script>
		<?php titlepag();?>
	</head>
	<body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
            <span id="todastablas2"></span>
            <table>
                <tr><script>barra_imagenes("plan");</script><?php cuadro_titulos();?></tr>	 
                <tr><?php menu_desplegable("plan");?></tr>
                <tr>
  					<td colspan="3" class="cinta"><a href="#" class="mgbt"><img src="imagenes/add.png" title="Nuevo"/></a><a href="#" class="mgbt"  onClick="document.form2.submit();"><img src="imagenes/guarda.png" title="Guardar" /></a><a href="#" onClick="document.form2.submit()" class="mgbt"><img src="imagenes/busca.png" title="Buscar"/></a><a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a><a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png" title="imprimir"></a><a href="#" onClick="excell()" class="mgbt"><img src="imagenes/excel.png" title="excel"></a></td>
      		</tr>
		</table>
 <form name="form2" method="post" action="presu-auxiliarcuenta.php">
 <?php
 $vigusu=vigencia_usuarios($_SESSION[cedulausu]);
$_POST[vigencia]=$vigusu;
 if($_POST[bc]!='')
			 {
			  $nresul=buscacuentapres($_POST[cuenta],2);			
			  if($nresul!='')
			   {
			  $_POST[ncuenta]=$nresul;
   			  $linkbd=conectar_bd();
			  $sqlr="select *from pptocuentaspptoinicial where cuenta=$_POST[cuenta] and vigencia=".$vigusu;
			  $res=mysql_query($sqlr,$linkbd);
			  $row=mysql_fetch_row($res);
			  $_POST[valor]=$row[5];		  
			  $_POST[valor2]=$row[5];		  			  
			   }
			  else
			  {
			   $_POST[ncuenta]="";	
			   }
			 }
 ?>
    <table  align="center" class="inicio" >
      <tr >
        <td class="titulos" colspan="8">.: Auxilar por Cuenta Egresos</td>
        <td width="" class="cerrar"><a href="presu-principal.php">Cerrar</a></td>
      </tr>
      <tr  >
        <td  class="saludo1">Cuenta:          </td>
          <td  valign="middle" ><input type="text" id="cuenta" name="cuenta" size="8" onKeyPress="javascript:return solonumeros(event)" 
		  onKeyUp="return tabular(event,this)" onBlur="buscacta(event)" value="<?php echo $_POST[cuenta]?>" onClick="document.getElementById('cuenta').focus();document.getElementById('cuenta').select();"><input type="hidden" value="0" name="bc"><a href="#" onClick="mypop=window.open('cuentasppto-ventana.php?ti=2','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>  </td><td width="367"><input name="ncuenta" type="text" value="<?php echo $_POST[ncuenta]?>" size="65" readonly> <input name="oculto" type="hidden" value="1"> </td>    
        <td  class="saludo1">Fecha Inicial:</td>
        <td ><input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">         <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>        </td>
        <td class="saludo1">Fecha Final: </td>
        <td ><input name="fecha2" type="text" id="fc_1198971546" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha2]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">         <a href="#" onClick="displayCalendarFor('fc_1198971546');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>       <input type="button" name="generar" value="Generar" onClick="document.form2.submit()"> <input type="hidden" value="1" name="oculto"> </td></tr>      
    </table>
    <?php
			//**** busca cuenta
			if($_POST[bc]!='')
			 {
			  $nresul=buscacuentapres($_POST[cuenta],2);
			  if($nresul!='')
			   {
			  $_POST[ncuenta]=$nresul;
			  $linkbd=conectar_bd();
			  $sqlr="select *from pptocuentaspptoinicial where cuenta=$_POST[cuenta] and vigencia=".$vigusu;
			  $res=mysql_query($sqlr,$linkbd);
			  $row=mysql_fetch_row($res);
			  $_POST[valor]=$row[5];		  
			  $_POST[valor2]=$row[5];		  			  

  			  ?>
			  <script>
			  document.form2.fecha.focus();
			  document.form2.fecha.select();
			  </script>
			  <?php
			  }
			 else
			 {
			  $_POST[ncuenta]="";
			  ?>
			  <script>alert("Cuenta Incorrecta");document.form2.cuenta.focus();</script>
			  <?php
			  }
			 }
			 ?>
    
	<div class="subpantallap" style="height:67%; width:99.8%; overflow-x:hidden;">
  <?php
  //**** para sacar la consulta del balance se necesitan estos datos ********
  //**** nivel, mes inicial, mes final, cuenta inicial, cuenta final, cc inicial, cc final  
$oculto=$_POST['oculto'];
if($_POST[oculto])
{
	$_POST[tiporec]=array();
//		$_POST[valrec]=array();
$tots=0;
	$sumad=0;
	$sumac=0;	
ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
	$fechaf2=$fecha[3]."-".$fecha[2]."-".$fecha[1];	
//$ti=substr($_POST[cuenta],0,1);
$ti=1;
  echo "<table class='inicio' ><tr><td colspan='6' class='titulos'>Auxiliar por Cuenta</td></tr>";
  echo "<tr><td class='titulos2'>TIPO COMPROBANTE</td><td class='titulos2'>No COMPROBANTE</td><td class='titulos2'>FECHA</td><td class='titulos2'>TERCERO</td><td class='titulos2'>AUMENTA</td><td class='titulos2'>DISMINUYE</td></tr>";
	 //$nc=buscacuentap($_POST[cuenta]);
$linkbd=conectar_bd();
$iter='zebra1';
$iter2='zebra2';
 	//******* INGRESOS SSF
	//*** todos los ingresos ***
	 $sqlr3="SELECT DISTINCT
			  pptocomprobante_det.cuenta,
			  pptocomprobante_det.valdebito,
			  pptocomprobante_det.valcredito,
			  pptocomprobante_det.tipo_comp, pptocomprobante_cab.numerotipo,
			  pptocomprobante_cab.fecha,pptocomprobante_det.tercero 
		 FROM pptocomprobante_det, pptocomprobante_cab, pptotipo_comprobante
		WHERE pptocomprobante_cab.tipo_comp = pptocomprobante_det.tipo_comp
			  AND pptocomprobante_det.numerotipo = pptocomprobante_cab.numerotipo
			  AND pptocomprobante_cab.estado = 1
			  AND (   pptocomprobante_det.valdebito > 0
				   OR pptocomprobante_det.valcredito > 0)			   
				   AND
				   pptocomprobante_cab.VIGENCIA=$vigusu
				   and  pptocomprobante_det.VIGENCIA=$vigusu
			  AND pptocomprobante_cab.fecha BETWEEN '$fechaf' AND '$fechaf2'
			  AND pptocomprobante_cab.tipo_comp = pptotipo_comprobante.codigo 			  		   
			  AND pptocomprobante_det.cuenta = '".$_POST[cuenta]."' 			  
	   ORDER BY  pptocomprobante_cab.tipo_comp, pptocomprobante_det.cuenta, pptocomprobante_cab.fecha";
	   //echo $sqlr3;
	 $res=mysql_query($sqlr3,$linkbd);
	 $subt=0;
	 $tipocomp="";
	 while($row =mysql_fetch_row($res))
	 {	
	 $tercero=buscatercero($row[6]);
	 $nomcomp=buscacomprobanteppto($row[3]);
	 //echo "d";
	 if($tipocomp=="")
	 {
	 $tipocomp=$nomcomp;
	 }
	 else
	 {
	 if($tipocomp!=$nomcomp)
	  {
		echo "<tr class='saludo1'><td colspan='3'></td><td colspan='1'>Subtotal $tipocomp</td><td>$".number_format($subt,2)."</td></tr>";
	   $tipocomp=$nomcomp;
	   $subt=0;
	  }
	  else
	  {
	   //$subt+=$row[1];
	  }	 
	 }
	 
  echo "<tr class='$iter'>
  <td ><input type='hidden' name='tiporec[]' value='$nomcomp'>$nomcomp</td>
  <td ><input type='hidden' name='nrec[]' value='$row[4]'>$row[4]</td>
  <td ><input type='hidden' name='fecrec[]' value='$row[5]'>$row[5]</td>
  <td ><input type='hidden' name='terrec[]' value='$tercero'>".$tercero."</td>
  <td ><input type='hidden' name='valrec[]' value='$row[1]'>".number_format($row[1],2)."</td>
  <td ><input type='hidden' name='valrec2[]' value='$row[2]'>".number_format($row[2],2)."</td></tr>";	 
	 $tots+=$row[1];
 	 $tots2+=$row[2];	
 	  $subt+=$row[1];
	 $aux=$iter;
	 $iter=$iter2;
	 $iter2=$aux;
 	 } 
 $sumad=0;
//echo "<tr><td colspan='4'></td><td>Total:</td><td class='saludo1'>$".number_format( array_sum($_POST[valrec]),2)."</td></tr>";
echo "<tr class='saludo1'><td colspan='3'></td><td>Total $tipocomp:</td><td >$".number_format($subt,2)."</td></tr>";
}
?> 
</div></form></td></tr>
</table>
</body>
</html>