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
<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
	 	<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
        <meta http-equiv="X-UA-Compatible" content="IE=9"/>
		<title>:: SPID - Presupuesto</title>
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <link href="css/css3.css" rel="stylesheet" type="text/css" />
        <script src="css/calendario.js"></script>
        <script src="css/programas.js"></script>
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
		<?php titlepag();?>
    </head>
    <body>
        <IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
        <span id="todastablas2"></span>
        <table>
            <tr><script>barra_imagenes("presu");</script><?php cuadro_titulos();?></tr>	 
            <tr><?php menu_desplegable("presu");?></tr>
        	<tr>
          		<td colspan="3" class="cinta"><a href="#" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a><a href="#" class="mgbt" onClick="document.form2.submit();"><img src="imagenes/guarda.png" title="Guardar" /></a><a href="#" onClick="document.form2.submit()" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a><a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png" title="imprimir"></a><a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a></td>
			</tr>
        </table>
 <form name="form2" method="post" action="presu-auxiliarcuenta.php">
    <table  align="center" class="inicio" >
      <tr >
        <td class="titulos" colspan="11">.: Auxilar por Cuenta</td><td width="8%" class="cerrar"><a href="cont-principal.php"> Cerrar</a></td>
      </tr>
      <tr  >
        <td class="saludo1">Cuenta:          </td>
          <td width="110" valign="middle" ><input type="text" id="cuenta" name="cuenta" size="8" onKeyPress="javascript:return solonumeros(event)" 
		  onKeyUp="return tabular(event,this)" onBlur="buscacta(event)" value="<?php echo $_POST[cuenta]?>" onClick="document.getElementById('cuenta').focus();document.getElementById('cuenta').select();"><input type="hidden" value="0" name="bc"><a href="#" onClick="mypop=window.open('cuentas-ventana.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>  </td><td width="486"><input name="ncuenta" type="text" value="<?php echo $_POST[ncuenta]?>" size="70" readonly> <input name="oculto" type="hidden" value="1"> </td>    
        <td width="10%" class="saludo1">Fecha Inicial:</td>
        <td width="13%"><input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">         <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>        </td>
        <td width="9%" class="saludo1">Fecha Final: </td>
        <td width="13%"><input name="fecha2" type="text" id="fc_1198971546" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha2]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">         <a href="#" onClick="displayCalendarFor('fc_1198971546');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>        </td></tr>
       <tr> <td class="saludo1" >Cuenta Inicial: </td>
        <td ></td>
        <td class="saludo1" >Cuenta Final: </td>
		<td ></td>
        <td ><input type="button" name="generar" value="Generar" onClick="document.form2.submit()"></td>
       </tr>  
	   <tr><td></td></tr>                  
    </table>
    
	<div class="subpantallac5" style="height:61.4%; width:99.6%; overflow-x:hidden;">
  <?php
  //**** para sacar la consulta del balance se necesitan estos datos ********
  //**** nivel, mes inicial, mes final, cuenta inicial, cuenta final, cc inicial, cc final  
$oculto=$_POST['oculto'];
if($_POST[oculto])
{
	$sumad=0;
	$sumac=0;	
ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha2],$fecha);
	$fechaf2=$fecha[3]."-".$fecha[2]."-".$fecha[1];	
  echo "<table class='inicio' ><tr><td colspan='8' class='titulos'>Auxiliar por Cuenta</td></tr>";
	 $nc=buscacuenta($_POST[cuenta]);
  echo "<tr><td class='saludo3'>Cuenta:</td><td class='saludo3'>$_POST[cuenta]</td><td class='saludo3' colspan='4'>$nc</td></tr>";
  echo "<tr><td class='titulos2'>CUENTA</td><td class='titulos2'>PRESUPUESTO INICIAL</td><td class='titulos2'>PRESUPUESTO DEFINITIVO</td><td class='titulos2'>SALDO CDP</td><td class='titulos2'>SALDO RP</td><td class='titulos2'>CXP</td><td class='titulos2'>INGRESOS</td><td class='titulos2'>PAGOS</td></tr>";
$linkbd=conectar_bd();
$sqlr="select * from pptocuentaspptoinicial where vigencia='".$_SESSION[vigencia]."' and estado='S' order by CUENTA";
//echo $sqlr;
$res=mysql_query($sqlr,$linkbd);
while($row=mysql_fetch_row($res))
 {
	 $sqlr="select *from tipo_comprobante where codigo=$row[2]";
	 //echo $sqlr;
	 $res2=mysql_query($sqlr);
	 $row2=mysql_fetch_row($res2);
	 $nt=buscatercero($row[13]);
  echo "<tr><td class='saludo3'>$row[0]</td><td class='saludo3'>$row[3]</td><td class='saludo3'>$row[5]</td><td class='saludo3'>$row[6]</td><td class='saludo3'>$row[7]</td><td class='saludo3'>".number_format($row[9],2)."</td><td class='saludo3'>".number_format($row[10],2)."</td><td class='saludo3'>".number_format($row[11],2)."</td></tr>";
 	$sumad+=$row[17];
	$sumac+=$row[18];
 }
 echo "<tr><td colspan='5'></td><td>Totales:</td><td class='saludo1'>$".number_format($sumad,2)."</td><td class='saludo1'>$".number_format($sumac,2)."</td></tr>";
}
?> 
</div></form></td></tr>
<tr><td></td></tr>      
</table>

</body>
</html>