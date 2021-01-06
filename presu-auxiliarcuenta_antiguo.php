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
        <link href="css/css3.css" rel="stylesheet" type="text/css"/>
        <script type="text/javascript" src="css/calendario.js"></script>
		<script type="text/javascript" src="css/programas.js"></script>
<script>
function buscacta(e)
 {
if (document.form2.cuenta.value!="")
{
 document.form2.bc.value=2;
 document.form2.submit();
 }
 }
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
document.form2.action="pdfauxiliargaspres.php";
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
  				<td colspan="3" class="cinta"><a href="#" class="mgbt"><img src="imagenes/add.png" title="Nuevo" /></a><a href="#" onClick="document.form2.submit();" class="mgbt"><img src="imagenes/guarda.png" title="Guardar" /></a><a href="#" onClick="document.form2.submit()" class="mgbt"><img src="imagenes/busca.png" title="Buscar" /></a><a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();" class="mgbt"><img src="imagenes/nv.png" title="Nueva Ventana"></a><a href="#" onClick="pdf()" class="mgbt"><img src="imagenes/print.png" title="imprimir"></a></td>
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
        <td class="titulos" colspan="10">.: Auxilar por Cuenta Gastos</td>
        <td width="70" class="cerrar"><a href="presu-principal.php">Cerrar</a></td>
      </tr>
      <tr  >
        <td width="66" class="saludo1">Cuenta:          </td>
          <td width="42" valign="middle" ><input type="text" id="cuenta" name="cuenta" size="8" onKeyPress="javascript:return solonumeros(event)" 
		  onKeyUp="return tabular(event,this)" onBlur="buscacta(event)" value="<?php echo $_POST[cuenta]?>" onClick="document.getElementById('cuenta').focus();document.getElementById('cuenta').select();"><input type="hidden" value="0" name="bc"><a href="#" onClick="mypop=window.open('cuentasppto-ventana.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>  </td><td width="381"><input name="ncuenta" type="text" value="<?php echo $_POST[ncuenta]?>" size="70" readonly> <input name="oculto" type="hidden" value="1"> </td>    
        <td width="90" class="saludo1">Fecha Inicial:</td>
        <td width="93"><input name="fecha" type="text" id="fc_1198971545" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">         <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>        </td>
        <td width="83" class="saludo1">Fecha Final: </td>
        <td width="166"><input name="fecha2" type="text" id="fc_1198971546" title="DD/MM/YYYY" size="10" value="<?php echo $_POST[fecha2]; ?>" onKeyUp="return tabular(event,this) " onKeyDown="mascara(this,'/',patron,true)"  maxlength="10">         <a href="#" onClick="displayCalendarFor('fc_1198971546');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>    <input type="button" name="generar" value="Generar" onClick="document.form2.submit()"> <input type="hidden" value="1" name="oculto">    </td></tr>      
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
	<div class="subpantallap" style="height:65%; width:99.8%; overflow-x:hidden;" >
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
$ti=substr($_POST[cuenta],0,1);
  echo "<table class='inicio' ><tr><td colspan='6' class='titulos'>Auxiliar por Cuenta</td></tr>";
	 //$nc=buscacuentap($_POST[cuenta]);
$linkbd=conectar_bd();
if($ti>='2')
{
	 $nt=buscacuentapres($_POST[cuenta],2);
 echo "<tr><td class='saludo3' width='8%'>Cuenta:</td><td class='saludo3'>$_POST[cuenta]</td><td class='saludo3' colspan='4'>$nt</td></tr>";
  echo "<tr><td class='titulos2'>Movimiento</td><td class='titulos2'>No</td><td class='titulos2'>FECHA</td><td class='titulos2'>TERCERO</td><td class='titulos2'>DESCRIPCION</td><td class='titulos2' >Valor</td></tr>";
//*****PRESUPUESTO INICIAL **********  
  $sqlr="Select cuenta, sum(valor)  from pptocuentaspptoinicial where Cuenta='$_POST[cuenta]' and pptocuentaspptoinicial.vigencia='".$vigusu."'";
	 $resi=mysql_query($sqlr,$linkbd);
	 //$rowi=mysql_fetch_row($resi);
	 while($rowi=mysql_fetch_row($resi))
	  {
	   echo "<tr><td class='saludo3'><input type='hidden' name='tiporec[]' value='PRESUPUESTO INICIAL'>PRESUPUESTO INICIAL</td><td class='saludo3'><input type='hidden' name='nrec[]' value=''></td><td class='saludo3'><input type='hidden' name='fecrec[]' value=''></td><td class='saludo3'><input type='hidden' name='terrec[]' value=''></td><td class='saludo3'><input type='hidden' name='desc[]' value='PRESUPUESTO INCIAL'>PRESUPUESTO INCIAL</td><td class='saludo3'><input type='hidden' name='valrec[]' value='$rowi[1]'>".number_format($rowi[1],2)."</td></tr>";
	  }
	  //***** ADICIONES **********  
  	 if(substr($_POST[cuenta],0,1)!='R')
	 {
  $sqlr="Select cuenta, fecha,VALOR  from pptoadiciones where pptoadiciones.Cuenta='$_POST[cuenta]'  and pptoadiciones.vigencia='".$vigusu."'";
	 $resi=mysql_query($sqlr,$linkbd);
	 }
	// echo $sqlr;
	 //$rowi=mysql_fetch_row($resi);
	 while($rowi=mysql_fetch_row($resi))
	  {
	   echo "<tr><td class='saludo3'><input type='hidden' name='tiporec[]' value='ADICION'>ADICIONES</td><td class='saludo3'><input type='hidden' name='nrec[]' value=''></td><td class='saludo3'><input type='hidden' name='fecrec[]' value='$rowi[1]'>$rowi[1]</td><td class='saludo3'><input type='hidden' name='terrec[]' value=''></td><td class='saludo3'><input type='hidden' name='desc[]' value='ADICIONES'>ADICIONES</td><td class='saludo3'><input type='hidden' name='valrec[]' value='$rowi[2]'>".number_format($rowi[2],2)."</td></tr>";
	  }		
	  
	    //***** REDUCCIONES **********  
  $sqlr="Select cuenta, fecha,VALOR  from pptoreducciones where pptoreducciones.Cuenta='$_POST[cuenta]'  and pptoreducciones.vigencia='".$vigusu."'";
	 $resi=mysql_query($sqlr,$linkbd);
	// echo $sqlr;
	 //$rowi=mysql_fetch_row($resi);
	 while($rowi=mysql_fetch_row($resi))
	  {
	   echo "<tr><td class='saludo3'><input type='hidden' name='tiporec[]' value='REDUCCIONES'>REDUCCIONES</td><td class='saludo3'><input type='hidden' name='nrec[]' value=''></td><td class='saludo3'><input type='hidden' name='fecrec[]' value='$rowi[1]'>$rowi[1]</td><td class='saludo3'><input type='hidden' name='terrec[]' value=''></td><td class='saludo3'><input type='hidden' name='desc[]' value='ADICIONES'>REDUCCIONES</td><td class='saludo3'><input type='hidden' name='valrec[]' value='$rowi[2]'>".number_format($rowi[2],2)."</td></tr>";
	  }
	    //***** CREDITOS **********  
  $sqlr="Select cuenta, fecha,VALOR  from pptotraslados where pptotraslados.Cuenta='$_POST[cuenta]' AND tipo='C' and pptotraslados.vigencia='".$vigusu."'";
	 $resi=mysql_query($sqlr,$linkbd);
	// echo $sqlr;
	 //$rowi=mysql_fetch_row($resi);
	 while($rowi=mysql_fetch_row($resi))
	  {
	   echo "<tr><td class='saludo3'><input type='hidden' name='tiporec[]' value='CREDITOS'>CREDITOS</td><td class='saludo3'><input type='hidden' name='nrec[]' value=''></td><td class='saludo3'><input type='hidden' name='fecrec[]' value='$rowi[1]'>$rowi[1]</td><td class='saludo3'><input type='hidden' name='terrec[]' value=''></td><td class='saludo3'><input type='hidden' name='desc[]' value='CREDITOS'>CREDITOS</td><td class='saludo3'><input type='hidden' name='valrec[]' value='$rowi[2]'>".number_format($rowi[2],2)."</td></tr>";
	  }
	    //***** CONTRACREDITOS **********  
  $sqlr="Select cuenta, fecha,VALOR  from pptotraslados where pptotraslados.Cuenta='$_POST[cuenta]' AND tipo='R'  and pptotraslados.vigencia='".$vigusu."'";
	 $resi=mysql_query($sqlr,$linkbd);
	// echo $sqlr;
	 //$rowi=mysql_fetch_row($resi);
	 while($rowi=mysql_fetch_row($resi))
	  {
	   echo "<tr><td class='saludo3'><input type='hidden' name='tiporec[]' value='CONTRACREDITOS'>CONTRACREDITOS</td><td class='saludo3'><input type='hidden' name='nrec[]' value=''></td><td class='saludo3'><input type='hidden' name='fecrec[]' value='$rowi[1]'>$rowi[1]</td><td class='saludo3'><input type='hidden' name='terrec[]' value=''></td><td class='saludo3'><input type='hidden' name='desc[]' value='CONTRACREDITOS'>CONTRACREDITOS</td><td class='saludo3'><input type='hidden' name='valrec[]' value='$rowi[2]'>".number_format($rowi[2],2)."</td></tr>";
	  }	  	  
//*****PRESUPUESTO DEFINITIVO **********  
  $sqlr="Select cuenta, sum(pptodef)  from pptocuentaspptoinicial where Cuenta='$_POST[cuenta]' and pptocuentaspptoinicial.vigencia='".$vigusu."'";
	 $resi=mysql_query($sqlr,$linkbd);
	 //$rowi=mysql_fetch_row($resi);
	 while($rowi=mysql_fetch_row($resi))
	  {
	   echo "<tr><td class='saludo3'><input type='hidden' name='tiporec[]' value='PRESUPUESTO DEFINITIVO'>PRESUPUESTO DEFINITIVO</td><td class='saludo3'><input type='hidden' name='nrec[]' value=''></td><td class='saludo3'><input type='hidden' name='fecrec[]' value=''></td><td class='saludo3'><input type='hidden' name='terrec[]' value=''></td><td class='saludo3'><input type='hidden' name='desc[]' value='PRESUPUESTO DEFINITIVO'>PRESUPUESTO DEFINITIVO</td><td class='saludo3'><input type='hidden' name='valrec[]' value='$rowi[1]'>".number_format($rowi[1],2)."</td></tr>";
	  }	  
	    
//****CDP *********	
$sqlr="select * from pptocdp_detalle,pptocdp where pptocdp.estado!='N' and pptocdp.consvigencia=pptocdp_detalle.consvigencia and pptocdp_detalle.vigencia='".$vigusu."' and pptocdp.vigencia='".$vigusu."' and pptocdp.fecha between '$fechaf' and '$fechaf2' and  pptocdp_detalle.cuenta='$_POST[cuenta]' order by pptocdp.consvigencia";	
 $sumad=0;
//echo $sqlr;
$res=mysql_query($sqlr,$linkbd);
while($row=mysql_fetch_row($res))
 {
  echo "<tr><td class='saludo3'><input type='hidden' name='tiporec[]' value='CDP'>CDP</td><td class='saludo3'><input type='hidden' name='nrec[]' value='$row[2]'>$row[2]</td><td class='saludo3'><input type='hidden' name='fecrec[]' value='$row[11]'>$row[11]</td><td class='saludo3'><input type='hidden' name='terrec[]' value='$row[12]'>$row[12]</td><td class='saludo3'><input type='hidden' name='desc[]' value='$row[16]'>".strtoupper($row[16])."</td><td class='saludo3'><input type='hidden' name='valrec[]' value='".($row[5]-$row[8])."'>".number_format(($row[5]-$row[8]),2)."</td></tr>";
 	$sumad+=($row[5]-$row[8]);
 }	
  echo "<tr><td colspan='4'></td><td>Totales:</td><td class='saludo1'>$".number_format($sumad,2)."</td></tr>";
 $sumad=0;
//****RP *********	
$sqlr="select * from pptorp_detalle,pptorp where pptorp.estado!='N' and pptorp.consvigencia=pptorp_detalle.consvigencia and pptorp_detalle.vigencia='".$vigusu."' and pptorp.vigencia='".$vigusu."' and pptorp.fecha between '$fechaf' and '$fechaf2' and  pptorp_detalle.cuenta='$_POST[cuenta]' order by pptorp.consvigencia";
//echo $sqlr;
$res=mysql_query($sqlr,$linkbd);
while($row=mysql_fetch_row($res))
 {
  echo "<tr><td class='saludo3'><input type='hidden' name='tiporec[]' value='RP'>RP</td><td class='saludo3'><input type='hidden' name='nrec[]' value='$row[2]'>$row[2]</td><td class='saludo3'><input type='hidden' name='fecrec[]' value='$row[12]'>$row[12]</td><td class='saludo3'><input type='hidden' name='terrec[]' value='$row[13]'>$row[13]</td><td class='saludo3'><input type='hidden' name='desc[]' value='".strtoupper(buscatercero($row[14]))." - CDP No $row[11]'>".strtoupper(buscatercero($row[14]))." - CDP No $row[11]</td><td class='saludo3'><input type='hidden' name='valrec[]' value='$row[5]-$row[8]'>".number_format($row[5]-$row[8],2)."</td></tr>";
 	$sumad+=($row[5]-$row[8]);
 } 
  echo "<tr><td colspan='4'></td><td>Totales:</td><td class='saludo1'>$".number_format($sumad,2)."</td></tr>";
//****CUENTAS X PAGAR *********	
$sumad=0;
$cpn=0;
$sqlr="select * from tesoegresosnomina_det,tesoegresosnomina where tesoegresosnomina.estado!='N' and tesoegresosnomina.id_egreso=tesoegresosnomina_det.id_egreso and tesoegresosnomina.vigencia='".$vigusu."' and tesoegresosnomina.fecha between '$fechaf' and '$fechaf2' and  tesoegresosnomina_det.cuentap='$_POST[cuenta]' order by tesoegresosnomina.id_egreso";
//echo $sqlr;
$res=mysql_query($sqlr,$linkbd);
while($row=mysql_fetch_row($res))
 {
  echo "<tr><td class='saludo3'><input type='hidden' name='tiporec[]' value='LIQUIDACION NOMINA'>LIQUIDACION NOMINA</td><td class='saludo3'><input type='hidden' name='nrec[]' value='$row[2]'>$row[2]</td><td class='saludo3'><input type='hidden' name='fecrec[]' value='$row[13]'>$row[13]</td><td class='saludo3'><input type='hidden' name='terrec[]' value='$row[22]'>$row[22]</td><td class='saludo3'><input type='hidden' name='desc[]' value='$row[5]'>".strtoupper($row[5])."</td><td class='saludo3'><input type='hidden' name='valrec[]' value='$row[8]'>".number_format($row[8],2)."</td></tr>";
 	$cpn+=$row[8];
	$sumad+=$row[8];
 } 
echo "<tr><td colspan='4'></td><td>Totales:</td><td class='saludo1'>$".number_format($sumad,2)."</td></tr>";
$sumad=0;
$sqlr="select * from tesoordenpago_det,tesoordenpago where tesoordenpago.estado!='N' and tesoordenpago.id_orden=tesoordenpago_det.id_orden and tesoordenpago.vigencia='".$vigusu."' and tesoordenpago.fecha between '$fechaf' and '$fechaf2' and  tesoordenpago_det.cuentap='$_POST[cuenta]' and tesoordenpago_det.valor>0 order by tesoordenpago.id_orden";
//echo $sqlr;
$res=mysql_query($sqlr,$linkbd);
while($row=mysql_fetch_row($res))
 {
  echo "<tr><td class='saludo3'><input type='hidden' name='tiporec[]' value='Cuenta Por Pagar'>Cuenta Por Pagar</td><td class='saludo3'><input type='hidden' name='nrec[]' value='$row[1]'>$row[1]</td><td class='saludo3'><input type='hidden' name='fecrec[]' value='$row[8]'>$row[8]</td><td class='saludo3'><input type='hidden' name='terrec[]' value='$row[12]'>$row[12]</td><td class='saludo3'><input type='hidden' name='desc[]' value='$row[13]'>".strtoupper($row[13])."</td><td class='saludo3'><input type='hidden' name='valrec[]' value='$row[4]'>".number_format($row[4],2)."</td></tr>";
 	$sumad+=$row[4];
 }
  echo "<tr><td colspan='4'></td><td>Totales:</td><td class='saludo1'>$".number_format($sumad,2)."</td></tr>";
//****EGRESOS *********	
$sumad=0;
$sqlr="select * from tesoordenpago_det,tesoordenpago,tesoegresos where tesoordenpago.estado!='N' and tesoordenpago.id_orden=tesoordenpago_det.id_orden and tesoordenpago.vigencia='".$vigusu."' and tesoordenpago.fecha between '$fechaf' and '$fechaf2' and  tesoordenpago_det.cuentap='$_POST[cuenta]' and tesoegresos.id_orden=tesoordenpago.id_orden and tesoordenpago_det.valor>0  order by tesoordenpago.id_orden";
//echo $sqlr;
$res=mysql_query($sqlr,$linkbd);
while($row=mysql_fetch_row($res))
 {
  echo "<tr><td class='saludo3'><input type='hidden' name='tiporec[]' value='Egresos'>Egresos</td><td class='saludo3'><input type='hidden' name='nrec[]' value='$row[1]'>$row[1]</td><td class='saludo3'><input type='hidden' name='fecrec[]' value='$row[25]'>$row[25]</td><td class='saludo3'><input type='hidden' name='terrec[]' value='$row[12]'>$row[12]</td><td class='saludo3'><input type='hidden' name='desc[]' value='$row[13]'>".strtoupper($row[13])."</td><td class='saludo3'><input type='hidden' name='valrec[]' value='$row[4]'>".number_format($row[4],2)."</td></tr>";
 	$sumad+=$row[4];
 } 
  echo "<tr><td colspan='4'></td><td>Totales:</td><td class='saludo1'>$".number_format($sumad,2)."</td></tr>";
//****EGRESOS NOMINA*********	
$sumad=0;
$sqlr="select * from pptorecibopagoegresoppto,tesoegresosnomina where tesoegresosnomina.estado!='N' and tesoegresosnomina.id_egreso=pptorecibopagoegresoppto.idRECIBO and tesoegresosnomina.vigencia='".$vigusu."' and tesoegresosnomina.fecha between '$fechaf' and '$fechaf2' and  pptorecibopagoegresoppto.cuenta='$_POST[cuenta]' order by tesoegresosnomina.id_egreso";
//echo $sqlr;
$res=mysql_query($sqlr,$linkbd);
while($row=mysql_fetch_row($res))
 {
  echo "<tr><td class='saludo3'><input type='hidden' name='tiporec[]' value='Egresos NOMINA'>Egresos NOMINA</td><td class='saludo3'><input type='hidden' name='nrec[]' value='$row[1]'>$row[1]</td><td class='saludo3'><input type='hidden' name='fecrec[]' value='$row[13]'>$row[13]</td><td class='saludo3'><input type='hidden' name='terrec[]' value='$row[22]'>$row[22]</td><td class='saludo3'><input type='hidden' name='desc[]' value='$row[5]'>".strtoupper($row[5])."</td><td class='saludo3'><input type='hidden' name='valrec[]' value='$row[3]'>".number_format($row[3],2)."</td></tr>";
 	$sumad+=$row[3];
 } 
  echo "<tr><td colspan='4'></td><td>Totales:</td><td class='saludo1'>$".number_format($sumad,2)."</td></tr>";

 //**** NOTAS BANCARIAS ***
 $sumad=0;
 $sqlr="select distinct * from pptonotasbanppto, tesonotasbancarias_cab where pptonotasbanppto.cuenta='$_POST[cuenta]' AND tesonotasbancarias_cab.id_notaban=pptonotasbanppto.idrecibo and pptonotasbanppto.vigencia='".$vigusu."' and tesonotasbancarias_cab.fecha between '$fechaf' and '$fechaf2' ORDER BY pptonotasbanppto.idrecibo";
	 $nt=buscacuentapres($_POST[cuenta],1);
//	echo $sqlr;
$res=mysql_query($sqlr,$linkbd);
while($row=mysql_fetch_row($res))
 {
	// $sqlr="select *from tipo_comprobante where codigo=$row[2]";
	 //echo $sqlr;
	 //$res2=mysql_query($sqlr);
	// $row2=mysql_fetch_row($res2);
$tipor=array('','Predial','Industria y Comercio','Otros Recaudos');
  echo "<tr><td class='saludo3'><input type='hidden' name='tiporec[]' value='NOTAS BANCARIAS'>NOTAS BANCARIAS</td><td class='saludo3'><input type='hidden' name='nrec[]' value='$row[2]'>$row[2]</td><td class='saludo3'><input type='hidden' name='fecrec[]' value='$row[7]'>$row[7]</td><td class='saludo3'><input type='hidden' name='terrec[]' value='NOTAS BANCARIAS $row[2]'>NOTAS BANCARIAS $row[2]</td><td class='saludo3'><input type='hidden' name='valrec[]' value='$row[3]'>".number_format($row[3],2)."</td></tr>";
 	$sumad+=$row[3];
 }
 echo "<tr><td colspan='4'></td><td>Totales:</td><td class='saludo1'>$".number_format($sumad,2)."</td></tr>";
 //**** SSF ***
 $sumad=0;
 $sqlr="select distinct * from pptoegressf, tesossfegreso_cab where pptoegressf.cuenta='$_POST[cuenta]' AND tesossfegreso_cab.id_orden=pptoegressf.idrecibo and pptoegressf.vigencia='".$vigusu."' and tesossfegreso_cab.fecha between '$fechaf' and '$fechaf2' ORDER BY pptoegressf.idrecibo";
	 $nt=buscacuentapres($_POST[cuenta],1);
//	echo $sqlr;
$res=mysql_query($sqlr,$linkbd);
while($row=mysql_fetch_row($res))
 {
	// $sqlr="select *from tipo_comprobante where codigo=$row[2]";
	 //echo $sqlr;
	 //$res2=mysql_query($sqlr);
	// $row2=mysql_fetch_row($res2);
$tipor=array('','Predial','Industria y Comercio','Otros Recaudos');
  echo "<tr><td class='saludo3'><input type='hidden' name='tiporec[]' value='EGRESOS SSF'>EGRESOS SSF</td><td class='saludo3'><input type='hidden' name='nrec[]' value='$row[2]'>$row[2]</td><td class='saludo3'><input type='hidden' name='fecrec[]' value='$row[7]'>$row[7]</td><td class='saludo3'><input type='hidden' name='terrec[]' value='$row[11]".buscatercero($row[11])."'>$row[11] ".buscatercero($row[11])."</td><td class='saludo3'><input type='hidden' name='name='desc[]' value='EGRESO SSF $row[2]'>EGRESO SSF $row[2]</td><td class='saludo3'><input type='hidden' name='valrec[]' value='$row[3]'>".number_format($row[3],2)."</td></tr>";
 	$sumad+=$row[3];
 }
 echo "<tr><td colspan='4'></td><td>Totales:</td><td class='saludo1'>$".number_format($sumad,2)."</td></tr>";
}
}
?> 
</div></form></td></tr> 
</table>
</body>
</html>