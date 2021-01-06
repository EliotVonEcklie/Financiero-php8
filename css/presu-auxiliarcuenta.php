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
<title>:: SPID - Presupuesto</title>
<script>
function buscacta(e)
 {
if (document.form2.cuenta.value!="")
{
 document.form2.bc.value=2;
 document.form2.submit();
 }
 }
</script>
<script>
//************* ver reporte ************
//***************************************
function verep(idfac)
{
  document.form1.oculto.value=idfac;
  document.form1.submit();
  }
</script>
<script>
//************* genera reporte ************
//***************************************
function genrep(idfac)
{
  document.form2.oculto.value=idfac;
  document.form2.submit();
  }
</script>
<script>
function pdf()
{
document.form2.action="pdfauxiliargaspres.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
}
</script>
<script src="css/calendario.js"></script>
<script src="css/programas.js"></script>
<link href="css/css2.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table>
	<tr>
		<td><img src="imagenes/logopresu.png"></td><td><img src="imagenes/entidad.png"></td>
		<td><table class="inicio">
			<tr>
				<td  class="saludo1" >Usuario: </td><td><?php echo $_SESSION[usuario]?></td>
				<td class="saludo1">Perfil: </td><td><?php echo $_SESSION["perfil"];?></td>
			</tr>
			<tr>
				<td  class="saludo1" >Fecha ingreso:</td>
				<td> <?php echo " ".$fec=date("Y-m-d");?> </td>
				<td  class="saludo1">Hora Ingreso: </td>
				<td><?php $hora=time();echo " ".date ( "h:i:s" , $hora ); $hora=date ( "h:i:s" , $hora )?></td>
			</tr>
		</table></td>
	</tr>
	<tr>
		<td colspan="3">
		<!-- Navigation -->  
			<ul class="mi-menu">  
				<li><a href="principal.php">Inicio</a></li>  
				<li><a href="#">Archivos Maestros</a><ul><script>document.write('<?php echo $_SESSION[linksetpr][1];?>')</script></ul></li>
				<li><a href="#">Proceso Ingreso </a><ul><script>document.write('<?php echo $_SESSION[linksetpr][2];?>')</script></ul></li>	
				<li><a href="#">Proceso Gastos </a><ul><script>document.write('<?php echo $_SESSION[linksetpr][3];?>')</script></ul></li>	
				<li><a href="#">Reportes</a><ul><script>document.write('<?php echo $_SESSION[linksetpr][4];?>')</script></ul></li>         
				<li><a href="#">Herramientas</a><ul><script>document.write('<?php echo $_SESSION[linksetpr][5];?>')</script></ul></li>		
				<li><a href="ayuda.html" target="_blank">Ayuda</a></li>           
  			</ul>  
        </td>
	</tr>
	<tr>
		<td colspan="3" class="cinta">
			<a href="#" ><img src="imagenes/add.png"  alt="Nuevo" /></a>
			<a href="#"  onClick="document.form2.submit();"><img src="imagenes/guarda.png" alt="Guardar" /></a>
			<a href="#" onClick="document.form2.submit()"> <img src="imagenes/busca.png" alt="Buscar" /></a>
			<a onClick="mypop=window.open('plan-agenda.php','','');mypop.focus()" class="mgbt"><img src="imagenes/agenda1.png" title="Agenda" /></a>
			<a href="#" onClick="mypop=window.open('presu-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" alt="nueva ventana"></a>
			<a href="#" onClick="pdf()"><img src="imagenes/print.png" alt="imprimir"></a>
		</td>
	</tr>
</table>
<tr><td colspan="3" class="tablaprin"> 
 <form name="form2" method="post" action="presu-auxiliarcuenta.php">
 <?php
 if($_POST[bc]!='')
			 {
			  $nresul=buscacuentapres($_POST[cuenta],2);			
			  if($nresul!='')
			   {
			  $_POST[ncuenta]=$nresul;
   			  $linkbd=conectar_bd();
			  $sqlr="select *from pptocuentaspptoinicial where cuenta=$_POST[cuenta] and vigencia=".$_SESSION[vigencia];
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
		  onKeyUp="return tabular(event,this)" onBlur="buscacta(event)" value="<?php echo $_POST[cuenta]?>" onClick="document.getElementById('cuenta').focus();document.getElementById('cuenta').select();"><input type="hidden" value="0" name="bc"><a href="#" onClick="mypop=window.open('cuentasppto-ventana.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>  </td><td width="381"><input name="ncuenta" type="text" value="<?php echo $_POST[ncuenta]?>" size="70" readonly=""> <input name="oculto" type="hidden" value="1"> </td>    
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
			  $sqlr="select *from pptocuentaspptoinicial where cuenta=$_POST[cuenta] and vigencia=".$_SESSION[vigencia];
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
	<div class="subpantallap">
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
  $sqlr="Select cuenta, sum(valor)  from pptocuentaspptoinicial where Cuenta='$_POST[cuenta]' and pptocuentaspptoinicial.vigencia='".$_SESSION[vigencia]."'";
	 $resi=mysql_query($sqlr,$linkbd);
	 //$rowi=mysql_fetch_row($resi);
	 while($rowi=mysql_fetch_row($resi))
	  {
	   echo "<tr><td class='saludo3'><input type='hidden' name='tiporec[]' value='PRESUPUESTO INICIAL'>PRESUPUESTO INICIAL</td><td class='saludo3'><input type='hidden' name='nrec[]' value=''></td><td class='saludo3'><input type='hidden' name='fecrec[]' value=''></td><td class='saludo3'><input type='hidden' name='terrec[]' value=''></td><td class='saludo3'><input type='hidden' name='desc[]' value='PRESUPUESTO INCIAL'>PRESUPUESTO INCIAL</td><td class='saludo3'><input type='hidden' name='valrec[]' value='$rowi[1]'>".number_format($rowi[1],2)."</td></tr>";
	  }
	  //***** ADICIONES **********  
  $sqlr="Select cuenta, fecha,VALOR  from pptoadiciones where pptoadiciones.Cuenta='$_POST[cuenta]'  and pptoadiciones.vigencia='".$_SESSION[vigencia]."'";
	 $resi=mysql_query($sqlr,$linkbd);
	// echo $sqlr;
	 //$rowi=mysql_fetch_row($resi);
	 while($rowi=mysql_fetch_row($resi))
	  {
	   echo "<tr><td class='saludo3'><input type='hidden' name='tiporec[]' value='ADICION'>ADICIONES</td><td class='saludo3'><input type='hidden' name='nrec[]' value=''></td><td class='saludo3'><input type='hidden' name='fecrec[]' value='$rowi[1]'>$rowi[1]</td><td class='saludo3'><input type='hidden' name='terrec[]' value=''></td><td class='saludo3'><input type='hidden' name='desc[]' value='ADICIONES'>ADICIONES</td><td class='saludo3'><input type='hidden' name='valrec[]' value='$rowi[2]'>".number_format($rowi[2],2)."</td></tr>";
	  }		
	    //***** REDUCCIONES **********  
  $sqlr="Select cuenta, fecha,VALOR  from pptoreducciones where pptoreducciones.Cuenta='$_POST[cuenta]'  and pptoreducciones.vigencia='".$_SESSION[vigencia]."'";
	 $resi=mysql_query($sqlr,$linkbd);
	// echo $sqlr;
	 //$rowi=mysql_fetch_row($resi);
	 while($rowi=mysql_fetch_row($resi))
	  {
	   echo "<tr><td class='saludo3'><input type='hidden' name='tiporec[]' value='REDUCCIONES'>REDUCCIONES</td><td class='saludo3'><input type='hidden' name='nrec[]' value=''></td><td class='saludo3'><input type='hidden' name='fecrec[]' value='$rowi[1]'>$rowi[1]</td><td class='saludo3'><input type='hidden' name='terrec[]' value=''></td><td class='saludo3'><input type='hidden' name='desc[]' value='ADICIONES'>REDUCCIONES</td><td class='saludo3'><input type='hidden' name='valrec[]' value='$rowi[2]'>".number_format($rowi[2],2)."</td></tr>";
	  }
	    //***** CREDITOS **********  
  $sqlr="Select cuenta, fecha,VALOR  from pptotraslados where pptotraslados.Cuenta='$_POST[cuenta]' AND tipo='C' and pptotraslados.vigencia='".$_SESSION[vigencia]."'";
	 $resi=mysql_query($sqlr,$linkbd);
	// echo $sqlr;
	 //$rowi=mysql_fetch_row($resi);
	 while($rowi=mysql_fetch_row($resi))
	  {
	   echo "<tr><td class='saludo3'><input type='hidden' name='tiporec[]' value='CREDITOS'>CREDITOS</td><td class='saludo3'><input type='hidden' name='nrec[]' value=''></td><td class='saludo3'><input type='hidden' name='fecrec[]' value='$rowi[1]'>$rowi[1]</td><td class='saludo3'><input type='hidden' name='terrec[]' value=''></td><td class='saludo3'><input type='hidden' name='desc[]' value='CREDITOS'>CREDITOS</td><td class='saludo3'><input type='hidden' name='valrec[]' value='$rowi[2]'>".number_format($rowi[2],2)."</td></tr>";
	  }
	    //***** CONTRACREDITOS **********  
  $sqlr="Select cuenta, fecha,VALOR  from pptotraslados where pptotraslados.Cuenta='$_POST[cuenta]' AND tipo='R'  and pptotraslados.vigencia='".$_SESSION[vigencia]."'";
	 $resi=mysql_query($sqlr,$linkbd);
	// echo $sqlr;
	 //$rowi=mysql_fetch_row($resi);
	 while($rowi=mysql_fetch_row($resi))
	  {
	   echo "<tr><td class='saludo3'><input type='hidden' name='tiporec[]' value='CONTRACREDITOS'>CONTRACREDITOS</td><td class='saludo3'><input type='hidden' name='nrec[]' value=''></td><td class='saludo3'><input type='hidden' name='fecrec[]' value='$rowi[1]'>$rowi[1]</td><td class='saludo3'><input type='hidden' name='terrec[]' value=''></td><td class='saludo3'><input type='hidden' name='desc[]' value='CONTRACREDITOS'>CONTRACREDITOS</td><td class='saludo3'><input type='hidden' name='valrec[]' value='$rowi[2]'>".number_format($rowi[2],2)."</td></tr>";
	  }	  	  
//*****PRESUPUESTO DEFINITIVO **********  
  $sqlr="Select cuenta, sum(pptodef)  from pptocuentaspptoinicial where Cuenta='$_POST[cuenta]' and pptocuentaspptoinicial.vigencia='".$_SESSION[vigencia]."'";
	 $resi=mysql_query($sqlr,$linkbd);
	 //$rowi=mysql_fetch_row($resi);
	 while($rowi=mysql_fetch_row($resi))
	  {
	   echo "<tr><td class='saludo3'><input type='hidden' name='tiporec[]' value='PRESUPUESTO DEFINITIVO'>PRESUPUESTO DEFINITIVO</td><td class='saludo3'><input type='hidden' name='nrec[]' value=''></td><td class='saludo3'><input type='hidden' name='fecrec[]' value=''></td><td class='saludo3'><input type='hidden' name='terrec[]' value=''></td><td class='saludo3'><input type='hidden' name='desc[]' value='PRESUPUESTO DEFINITIVO'>PRESUPUESTO DEFINITIVO</td><td class='saludo3'><input type='hidden' name='valrec[]' value='$rowi[1]'>".number_format($rowi[1],2)."</td></tr>";
	  }	  
//****CDP *********	
$sqlr="select * from pptocdp_detalle,pptocdp where pptocdp.estado!='N' and pptocdp.consvigencia=pptocdp_detalle.consvigencia and pptocdp_detalle.vigencia='".$_SESSION[vigencia]."' and pptocdp.vigencia='".$_SESSION[vigencia]."' and pptocdp.fecha between '$fechaf' and '$fechaf2' and  pptocdp_detalle.cuenta='$_POST[cuenta]' order by pptocdp.consvigencia";	
 $sumad=0;
echo $sqlr;
$res=mysql_query($sqlr,$linkbd);
while($row=mysql_fetch_row($res))
 {
  echo "<tr><td class='saludo3'><input type='hidden' name='tiporec[]' value='CDP'>CDP</td><td class='saludo3'><input type='hidden' name='nrec[]' value='$row[2]'>$row[2]</td><td class='saludo3'><input type='hidden' name='fecrec[]' value='$row[11]'>$row[11]</td><td class='saludo3'><input type='hidden' name='terrec[]' value='$row[12]'>$row[12]</td><td class='saludo3'><input type='hidden' name='desc[]' value='$row[15]'>".strtoupper($row[15])."</td><td class='saludo3'><input type='hidden' name='valrec[]' value='$row[5]'>".number_format($row[5],2)."</td></tr>";
 	$sumad+=$row[5];
 }	
  echo "<tr><td colspan='3'></td><td>Totales:</td><td class='saludo1'>$".number_format($sumad,2)."</td></tr>";
 $sumad=0;
//****RP *********	
$sqlr="select * from pptorp_detalle,pptorp where pptorp.estado!='N' and pptorp.consvigencia=pptorp_detalle.consvigencia and pptorp_detalle.vigencia='".$_SESSION[vigencia]."' and pptorp.vigencia='".$_SESSION[vigencia]."' and pptorp.fecha between '$fechaf' and '$fechaf2' and  pptorp_detalle.cuenta='$_POST[cuenta]' order by pptorp.consvigencia";
echo $sqlr;
$res=mysql_query($sqlr,$linkbd);
while($row=mysql_fetch_row($res))
 {
  echo "<tr><td class='saludo3'><input type='hidden' name='tiporec[]' value='RP'>RP</td><td class='saludo3'><input type='hidden' name='nrec[]' value='$row[2]'>$row[2]</td><td class='saludo3'><input type='hidden' name='fecrec[]' value='$row[12]'>$row[12]</td><td class='saludo3'><input type='hidden' name='terrec[]' value='$row[13]'>$row[13]</td><td class='saludo3'><input type='hidden' name='desc[]' value='".strtoupper(buscatercero($row[13]))." - CDP No $row[10]'>".strtoupper(buscatercero($row[13]))." - CDP No $row[10]</td><td class='saludo3'><input type='hidden' name='valrec[]' value='$row[5]'>".number_format($row[5],2)."</td></tr>";
 	$sumad+=$row[5];
 } 
  echo "<tr><td colspan='3'></td><td>Totales:</td><td class='saludo1'>$".number_format($sumad,2)."</td></tr>";
//****CUENTAS X PAGAR *********	
$sumad=0;
$sqlr="select * from tesoordenpago_det,tesoordenpago where tesoordenpago.estado!='N' and tesoordenpago.id_orden=tesoordenpago_det.id_orden and tesoordenpago.vigencia='".$_SESSION[vigencia]."' and tesoordenpago.fecha between '$fechaf' and '$fechaf2' and  tesoordenpago_det.cuentap='$_POST[cuenta]' and tesoordenpago_det.valor>0 order by tesoordenpago.id_orden";
//echo $sqlr;
$res=mysql_query($sqlr,$linkbd);
while($row=mysql_fetch_row($res))
 {
  echo "<tr><td class='saludo3'><input type='hidden' name='tiporec[]' value='Cuenta Por Pagar'>Cuenta Por Pagar</td><td class='saludo3'><input type='hidden' name='nrec[]' value='$row[1]'>$row[1]</td><td class='saludo3'><input type='hidden' name='fecrec[]' value='$row[8]'>$row[8]</td><td class='saludo3'><input type='hidden' name='terrec[]' value='$row[12]'>$row[12]</td><td class='saludo3'><input type='hidden' name='desc[]' value='$row[13]'>".strtoupper($row[13])."</td><td class='saludo3'><input type='hidden' name='valrec[]' value='$row[4]'>".number_format($row[4],2)."</td></tr>";
 	$sumad+=$row[4];
 }
  echo "<tr><td colspan='3'></td><td>Totales:</td><td class='saludo1'>$".number_format($sumad,2)."</td></tr>";
//****EGRESOS *********	
$sumad=0;
$sqlr="select * from tesoordenpago_det,tesoordenpago,tesoegresos where tesoordenpago.estado!='N' and tesoordenpago.id_orden=tesoordenpago_det.id_orden and tesoordenpago.vigencia='".$_SESSION[vigencia]."' and tesoordenpago.fecha between '$fechaf' and '$fechaf2' and  tesoordenpago_det.cuentap='$_POST[cuenta]' and tesoegresos.id_orden=tesoordenpago.id_orden and tesoordenpago_det.valor>0  order by tesoordenpago.id_orden";
//echo $sqlr;
$res=mysql_query($sqlr,$linkbd);
while($row=mysql_fetch_row($res))
 {
  echo "<tr><td class='saludo3'><input type='hidden' name='tiporec[]' value='Egresos'>Egresos</td><td class='saludo3'><input type='hidden' name='nrec[]' value='$row[1]'>$row[1]</td><td class='saludo3'><input type='hidden' name='fecrec[]' value='$row[25]'>$row[25]</td><td class='saludo3'><input type='hidden' name='terrec[]' value='$row[12]'>$row[12]</td><td class='saludo3'><input type='hidden' name='desc[]' value='$row[13]'>".strtoupper($row[13])."</td><td class='saludo3'><input type='hidden' name='valrec[]' value='$row[4]'>".number_format($row[4],2)."</td></tr>";
 	$sumad+=$row[4];
 } 
  echo "<tr><td colspan='3'></td><td>Totales:</td><td class='saludo1'>$".number_format($sumad,2)."</td></tr>";
//****EGRESOS NOMINA*********	
$sumad=0;
$sqlr="select * from tesoegresosnomina_det,tesoegresosnomina where tesoegresosnomina.estado!='N' and tesoegresosnomina.id_egreso=tesoegresosnomina_det.id_egreso and tesoegresosnomina.vigencia='".$_SESSION[vigencia]."' and tesoegresosnomina.fecha between '$fechaf' and '$fechaf2' and  tesoegresosnomina_det.cuentap='$_POST[cuenta]' order by tesoegresosnomina.id_egreso";
//echo $sqlr;
$res=mysql_query($sqlr,$linkbd);
while($row=mysql_fetch_row($res))
 {
  echo "<tr><td class='saludo3'><input type='hidden' name='tiporec[]' value='Egresos NOMINA'>Egresos NOMINA</td><td class='saludo3'><input type='hidden' name='nrec[]' value='$row[1]'>$row[1]</td><td class='saludo3'><input type='hidden' name='fecrec[]' value='$row[14]'>$row[14]</td><td class='saludo3'><input type='hidden' name='terrec[]' value='$row[22]'>$row[22]</td><td class='saludo3'><input type='hidden' name='desc[]' value='$row[5]'>".strtoupper($row[5])."</td><td class='saludo3'><input type='hidden' name='valrec[]' value='$row[8]'>".number_format($row[8],2)."</td></tr>";
 	$sumad+=$row[4];
 } 
  echo "<tr><td colspan='3'></td><td>Totales:</td><td class='saludo1'>$".number_format($sumad,2)."</td></tr>";

 //**** NOTAS BANCARIAS ***
 $sumad=0;
 $sqlr="select distinct * from pptonotasbanppto, tesonotasbancarias_cab where pptonotasbanppto.cuenta='$_POST[cuenta]' AND tesonotasbancarias_cab.id_notaban=pptonotasbanppto.idrecibo and pptoretencionpago.vigencia='".$_SESSION[vigencia]."' and tesonotasbancarias_cab.fecha between '$fechaf' and '$fechaf2' ORDER BY pptonotasbanppto.idrecibo";
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
 echo "<tr><td colspan='3'></td><td>Totales:</td><td class='saludo1'>$".number_format($sumad,2)."</td></tr>";
}
}
?> 
</div></form></td></tr> 
</table>
</body>
</html>