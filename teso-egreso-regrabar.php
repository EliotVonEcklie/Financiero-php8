<?php //V 1000 12/12/16 ?> 
<?php
require"comun.inc";
require"funciones.inc";
require "conversor.php";
session_start();
cargarcodigopag($_GET[codpag],$_SESSION["nivel"]);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<title>:: SPID - Tesoreria</title>
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
function buscacta(e)
 {
if (document.form2.cuenta.value!="")
{
 document.form2.bc.value='1';
 document.form2.submit();
 }
 }
</script>
<script language="JavaScript1.2">
function validar()
{

document.form2.submit();
}
</script>
<script>
function buscarp(e)
 {
if (document.form2.rp.value!="")
{
 document.form2.brp.value='1';
 document.form2.submit();
 }
 }
</script>
<script>
function agregardetalle()
{
if(document.form2.numero.value!="" &&  document.form2.valor.value>0 &&  document.form2.banco.value!=""  )
{ 
				document.form2.agregadet.value=1;
	//			document.form2.chacuerdo.value=2;
				document.form2.submit();
 }
 else {
 alert("Falta informacion para poder Agregar");
 }
}
</script>
<script>
function agregardetalled()
{
if(document.form2.retencion.value!="" &&  document.form2.vporcentaje.value!=""  )
{ 
				document.form2.agregadetdes.value=1;
	//			document.form2.chacuerdo.value=2;
				document.form2.submit();
 }
 else {
 alert("Falta informacion para poder Agregar");
 }
}
</script>
<script>
function eliminar(variable)
{
if (confirm("Esta Seguro de Eliminar"))
  {
document.form2.elimina.value=variable;
//eli=document.getElementById(elimina);
vvend=document.getElementById('elimina');
//eli.value=elimina;
vvend.value=variable;
document.form2.submit();
}
}
</script>
<script>
function eliminard(variable)
{
if (confirm("Esta Seguro de Eliminar"))
  {
document.form2.eliminad.value=variable;
//eli=document.getElementById(elimina);
vvend=document.getElementById('eliminad');
//eli.value=elimina;
vvend.value=variable;
document.form2.submit();
}
}
</script>
<script>
//************* genera reporte ************
//***************************************
function guardar()
{

if (document.form2.fecha.value!='')
  {
	if (confirm("Esta Seguro de Guardar"))
  	{
  	document.form2.oculto.value=2;
  	document.form2.submit();
  	}
  }
  else{
  alert('Faltan datos para completar el registro');
  	document.form2.fecha.focus();
  	document.form2.fecha.select();
  }
}
</script>
<script>
function calcularpago()
 {
	//alert("dddadadad");
	valorp=document.form2.valor.value;
	descuentos=document.form2.totaldes.value;
	valorc=valorp-descuentos;
	document.form2.valorcheque.value=valorc;
	document.form2.valoregreso.value=valorp;
	document.form2.valorretencion.value=descuentos;	
	  	document.form2.submit();
 }
</script>
<script>
function pdf()
{
document.form2.action="pdfcxp.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
}
</script>
<script language="JavaScript1.2">
function adelante()
{
//   alert("Balance Descuadrado");
//document.form2.oculto.value=2;
if(parseFloat(document.form2.ncomp.value)<parseFloat(document.form2.maximo.value))
 {
document.form2.oculto.value=1;
//document.form2.agregadet.value='';
//document.form2.elimina.value='';
document.form2.ncomp.value=parseFloat(document.form2.ncomp.value)+1;
document.form2.idcomp.value=parseFloat(document.form2.idcomp.value)+1;
document.form2.action="teso-egreso-regrabar.php";
document.form2.submit();
}
}
</script>
<script language="JavaScript1.2">
function atrasc()
{

//document.form2.oculto.value=2;
if(document.form2.ncomp.value>1)
 {

document.form2.oculto.value=1;
//document.form2.agregadet.value='';
//document.form2.elimina.value='';
document.form2.ncomp.value=document.form2.ncomp.value-1;
document.form2.idcomp.value=document.form2.idcomp.value-1;
document.form2.action="teso-egreso-regrabar.php";
document.form2.submit();
 }
}
</script>
<script language="JavaScript1.2">
function validar2()
{
//   alert("Balance Descuadrado");
document.form2.oculto.value=1;
document.form2.ncomp.value=document.form2.idcomp.value;
//document.form2.agregadet.value='';
//document.form2.elimina.value='';
document.form2.action="teso-egreso-regrabar.php";
document.form2.submit();
}
</script>
<script src="css/programas.js"></script>
<script src="css/calendario.js"></script>
<link href="css/css2.css" rel="stylesheet" type="text/css" />
<link href="css/css3.css" rel="stylesheet" type="text/css" />
<link href="css/tabs.css" rel="stylesheet" type="text/css" />
<?php titlepag();?>
</head>
<body>
<IFRAME src="alertas.php" name="alertas" id="alertas" style="display:none"></IFRAME>
<span id="todastablas2"></span>
<table>
	<tr><script>barra_imagenes("teso");</script><?php cuadro_titulos();?></tr>	 
	<tr><?php menu_desplegable("teso");?></tr>
<tr>
  <td colspan="3" class="cinta"><a href="#" ><img src="imagenes/add2.png" alt="Nuevo"  border="0" /></a> <a href="#"  onClick="guardar()"><img src="imagenes/guarda.png"  alt="Guardar" /></a><a href="teso-buscaegreso-rg.php"> <img src="imagenes/busca.png"  alt="Buscar" border="0" /></a> <a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" alt="nueva ventana"></a>  <a href="#" onClick="pdf()"> <img src="imagenes/print.png"  alt="Buscar" /></a> <a href="teso-actualizardocs.php"><img src="imagenes/iratras.png" alt="nueva ventana"></a></td>
</tr>		  
</table>
<tr><td colspan="3" class="tablaprin" align="center"> 
<?php
$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
$vigencia=$vigusu;

 ?>	
<?php
	  //*********** cuenta origen va al credito y la destino al debito
if(!$_POST[oculto])
{
	
	$linkbd=conectar_bd();
	$sqlr="select *from cuentapagar where estado='S' ";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
	{
	 $_POST[cuentapagar]=$row[1];
	}

$link=conectar_bd();
$sqlr="select * from tesoordenpago ORDER BY id_orden DESC";
$res=mysql_query($sqlr,$link);
//echo $sqlr;
	$r=mysql_fetch_row($res);
	 $_POST[maximo]=$r[0];
	 $_POST[ncomp]=$_POST[maximo];
		$check1="checked"; 
 		 $fec=date("d/m/Y");
	 	if($_GET[idop]!="")
		{	
		  $_POST[ncomp]=$_GET[idop];
		}
//		 $_POST[fecha]=$fec; 		 		  			 
		//$_POST[valor]=0;
		//$_POST[valorcheque]=0;
		//$_POST[valorretencion]=0;
		//$_POST[valoregreso]=0;
		//$_POST[totaldes]=0;
		 $vigusu=$vigusu; 		
		$sqlr="select * from tesoordenpago where id_orden=".$_POST[ncomp];
		$res=mysql_query($sqlr,$linkbd);
		$consec=0;
		while($r=mysql_fetch_row($res))
		 {
		 $_POST[fecha]=$r[2];
		 $_POST[compcont]=$r[1];
		  $consec=$r[0];	  
		  $_POST[rp]=$r[4];
  		  $_POST[estado]=$r[13];
		  		  $_POST[estadoc]=$r[13];
	 	}
	 	$_POST[idcomp]=$consec;	
		ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
		$_POST[fecha]=$fechaf;
}
switch($_POST[tabgroup1])
{
case 1:
$check1='checked';
break;
case 2:
$check2='checked';
break;
case 3:
$check3='checked';
}
?>
 <form name="form2" method="post" action=""> 
 <?php
  $link=conectar_bd();
$sqlr="select * from tesoordenpago where id_orden=$_POST[idcomp] ";
$res=mysql_query($sqlr,$link);
//echo $sqlr;
	while($r=mysql_fetch_row($res))
	{
	 $_POST[fecha]=$r[2];
//	  $_POST[idcomp]=$r[0];	  
	  ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."/".$fecha[2]."/".$fecha[1];
	 $_POST[fecha]=$fechaf;	
	 $_POST[rp]=$r[4];
	 		  $_POST[estado]=$r[13];
			  		  $_POST[estadoc]=$r[13];
	}
			  $nresul=buscaregistro($_POST[rp],$vigusu);
			  $_POST[cdp]=$nresul;
			  //*** busca detalle cdp
			  $linkbd=conectar_bd();
  				$sqlr="select pptorp.vigencia,pptorp.consvigencia,pptocdp.objeto,pptorp.estado,pptocdp.consvigencia,pptorp.valor,pptorp.saldo,pptorp.tercero, pptocdp.objeto from pptorp,pptocdp where pptorp.estado='S' and pptocdp.consvigencia=$_POST[cdp] and pptorp.idcdp=pptocdp.consvigencia and pptorp.consvigencia=".$_POST[rp]." and pptorp.vigencia=$vigusu and pptorp.idcdp=pptocdp.consvigencia and pptocdp.vigencia=$vigusu order by pptorp.vigencia,pptorp.consvigencia,pptocdp.objeto,pptorp.estado";
				//echo $sqlr;
				$resp = mysql_query($sqlr,$linkbd);
				$row =mysql_fetch_row($resp);
				$_POST[detallecdp]=$row[2];
				$sqlr="Select *from tesoordenpago where id_orden=".$_POST[idcomp];
				$resp = mysql_query($sqlr,$linkbd);
				$row =mysql_fetch_row($resp);
				$_POST[tercero]=$row[6];
				$_POST[ntercero]=buscatercero($_POST[tercero]);
				$_POST[valorrp]=$row[8];
				$_POST[saldorp]=$row[9];
				$_POST[cdp]=$row[4];
				$_POST[valor]=$row[10];
				if($_POST[oculto]!='2')
				{
				$_POST[cc]=$row[5];				
				}
				$_POST[detallegreso]=$row[7];
				$_POST[valoregreso]=$_POST[valor];
				$_POST[valorretencion]=$row[12];
				$_POST[base]=$row[14];
				 $_POST[iva]=$row[15];
				$_POST[valorcheque]=$_POST[valoregreso]-$_POST[valorretencion];
				//$_POST[valorcheque]=number_format($_POST[valorcheque],2);								
 ?>
 <div class="tabsic">
   <div class="tab">
       <input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
	   <label for="tab-1">Liquidacion CxP</label>
	   <div class="content">
    <table class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="10">Liquidacion CxP</td><td width="118" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
      </tr>
      <tr >
		        <td width="108" class="saludo1" >Numero CxP:</td>
        <td > <a href="#" onClick="atrasc()"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a><input name="idcomp" type="text" size="5" value="<?php echo $_POST[idcomp]?>" onBlur="validar2()" onKeyPress="javascript:return solonumeros(event)"  onKeyUp="return tabular(event,this)"><input name="ncomp" type="hidden" value="<?php echo $_POST[ncomp]?>"><input name="compcont" type="hidden" value="<?php echo $_POST[compcont]?>"><a href="#" onClick="adelante()"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> <input type="hidden" value="a" name="atras" ><input type="hidden" value="s" name="siguiente" ><input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo"></td>
	  <td class="saludo1">Fecha: </td>
        <td ><input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10" size="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY" readonly>   <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>     </td>
	  <td width="85"  class="saludo1">Vigencia: </td>
        <td width="244" ><input name="vigencia" type="text" value="<?php echo $vigusu?>" maxlength="2" size="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly> <input name="estadoc" type="text" value="<?php echo $_POST[estadoc]?>" readonly > <input name="estado" type="hidden" value="<?php echo $_POST[estado]?>"></td><td  class="saludo1">Causacion Contable:</td><td><select name="causacion" id="causacion" onKeyUp="return tabular(event,this)"  >
         <option value="1" <?php if($_POST[causacion]=='1') echo "SELECTED"; ?>>Si</option>
          <option value="2" <?php if($_POST[causacion]=='2') echo "SELECTED"; ?>>No</option>         
        </select></td>
<tr>
        <td  class="saludo1">Registro:
        </td>
        <td><input name="rp" type="text" value="<?php echo $_POST[rp]?>" size="10" onKeyUp="return tabular(event,this)" onBlur="buscarp(event)" readonly ><input type="hidden" value="0" name="brp">
            <a href="#" onClick="mypop=window.open('registro-ventana.php?vigencia=<?php echo $vigusu?>','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=900,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a></td>
	  <td class="saludo1">CDP:</td>
	  <td>
<input type="text" id="cdp" name="cdp" value="<?php echo $_POST[cdp]?>" size="10" readonly></td>
	  <td class="saludo1">Detalle RP:</td>
	  <td colspan="4">
<input type="text" id="detallecdp" name="detallecdp" value="<?php echo $_POST[detallecdp]?>" size="80" readonly></td>
	  </tr> 
	  <tr>
	  <td class="saludo1">Centro Costo:</td>
	  <td>
	<select name="cc"  onChange="" onKeyUp="return tabular(event,this)">
	<?php
	$linkbd=conectar_bd();
	$sqlr="select *from centrocosto where estado='S'";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
				    {
					echo "<option value=$row[0] ";
					$i=$row[0];
		
					 if($i==$_POST[cc])
			 			{
						 echo "SELECTED";
						 }
					  echo ">".$row[0]." - ".$row[1]."</option>";	 	 
					}	 	
	?>
   </select>
	 </td>
	     <td class="saludo1">Tercero:</td>
          <td  ><input id="tercero" type="text" name="tercero" size="15" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo $_POST[tercero]?>"><a href="#" onClick="mypop=window.open('terceros-ventana.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=900,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>
           </td>
          <td colspan="2"><input  id="ntercero"  name="ntercero" type="text" value="<?php echo $_POST[ntercero]?>" size="70" readonly></td></tr>
          <tr><td class="saludo1">Detalle Orden de Pago:</td><td colspan="6">
<input type="text" id="detallegreso" name="detallegreso" value="<?php echo $_POST[detallegreso]?>" size="158"  ></td></tr>
	  <tr><td class="saludo1">Valor RP:</td><td><input type="text" id="valorrp" name="valorrp" value="<?php echo $_POST[valorrp]?>" size="15" onKeyUp="return tabular(event,this)" readonly></td><td class="saludo1">Saldo RP:</td><td><input type="text" id="saldorp" name="saldorp"  value="<?php echo $_POST[saldorp]?>" size="15" onKeyUp="return tabular(event,this)" readonly></td>
	  <td class="saludo1" >Valor a Pagar:</td><td><input type="text" id="valor" name="valor" value="<?php echo $_POST[valor]?>" size="15" onKeyUp="return tabular(event,this)" onChange='calcularpago()' readonly> <input type="hidden" value="1" name="oculto"></td><td class="saludo1" >Base:</td><td><input type="text" id="base" name="base" value="<?php echo $_POST[base]?>" size="15" onKeyUp="return tabular(event,this)"  readonly> </td><td class="saludo1" >Iva:</td><td><input type="text" id="iva" name="iva" value="<?php echo $_POST[iva]?>" size="15" onKeyUp="return tabular(event,this)"  readonly> </td></tr>
      </table>
      <?php
	  if(!$_POST[oculto])
	   {
		?>
         <script>
			  document.form2.fecha.focus();
			 document.form2.fecha.select();</script>
        <?php   
		}
	  ?>
      <?php
		 //***** busca tercero
			 if($_POST[brp]=='1')
			 {
			  $nresul=buscaregistro($_POST[rp],$vigusu);
			  if($nresul!='')
			   {
			  $_POST[cdp]=$nresul;
  				?>
			  <script>
			  document.getElementById('cc').focus();
			   document.getElementById('cc').select();</script>
			  <?php
			  }
			 else
			 {
			  $_POST[cdp]="";
			  ?>
			  <script>
				 alert("Registro Presupuestal Incorrecto");
				 document.form2.rp.select();
		  		//document.form2.rp.focus();	
			  </script>
			  <?php
			  }
			 }
			?>
	  </div>
    </div>
	<div class="tab">
       <input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?>>
       <label for="tab-2">Retenciones</label>
       <div class="content"> 
		
         <table class="inicio" style="overflow:scroll">
        <tr><td class="titulos">Descuento</td><td class="titulos">%</td><td class="titulos">Valor</td><td class="titulos2"><img src="imagenes/del.png" ><input type='hidden' name='eliminad' id='eliminad'></td></tr>
      	<?php
		$totaldes=0;
		$sqlr="select *from tesoordenpago_retenciones where id_orden=".$_POST[idcomp];
		$res=mysql_query($sqlr,$linkbd);
		while ($row=mysql_fetch_row($res))
		 {		 
		 $sqlr="select *from tesoretenciones where id='$row[0]'";
		$res2=mysql_query($sqlr,$linkbd);
		$row2 =mysql_fetch_row($res2);
		
		 echo "<tr><td class='saludo2'><input name='dndescuentos[]' value='".$row2[2]."' type='text' size='100' readonly><input name='ddescuentos[]' value='".$row[0]."' type='hidden'></td>";
		 echo "<td class='saludo2'><input name='dporcentajes[]' value='".$row[2]."' type='text' size='5' readonly></td>";
		 echo "<td class='saludo2'><input name='ddesvalores[]' value='".$row[3]."' type='text' size='15' readonly></td><td class='saludo2'><a href='#'><img src='imagenes/del.png'></a></td></tr>";
// 		 echo "<td class='saludo2'><input name='ddesvalores[]' value='".$_POST[ddesvalores][$x]."' type='text' size='15'></td><td class='saludo2'><a href='#' onclick='eliminard($x)'><img src='imagenes/del.png'></a></td></tr>";
		 $totaldes=$totaldes+$row[3];
		 }		 
		?>
        <script>
        document.form2.totaldes.value=<?php echo $totaldes;?>;		
	calcularpago();
//       document.form2.valorretencion.value=<?php echo $totaldes;?>;
        </script>
        </table>
      
      </table>
	   </div>
   </div>
   
    <div class="tab">
       <input type="radio" id="tab-3" name="tabgroup1" value="3" <?php echo $check3;?>>
       <label for="tab-3">Cuenta por Pagar</label>
       <div class="content"> 
	   <table class="inicio" align="center" >
	   <tr><td colspan="6" class="titulos">Cheque</td><td width="108" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td></tr>
<tr>
	  <td class="saludo1">Cuenta Contable:</td>
	  <td >
	    <input name="cuentapagar" type="text" value="<?php echo $_POST[cuentapagar]?>" size="25"  readonly> 
		<input name="cb" type="hidden" value="<?php echo $_POST[cb]?>" ><input type="hidden" id="ter" name="ter" value="<?php echo $_POST[ter]?>" ></td>
			
	  </tr> 
	  <tr>
	  <td class="saludo1">Valor Orden de Pago:</td><td><input type="text" id="valoregreso" name="valoregreso" value="<?php echo $_POST[valoregreso]?>" size="20" onKeyUp="return tabular(event,this)" readonly></td><td class="saludo1">Valor Retenciones:</td><td><input type="text" id="valorretencion" name="valorretencion" value="<?php echo $_POST[valorretencion]?>" size="20" onKeyUp="return tabular(event,this)" readonly></td><td class="saludo1">Valor Cta Pagar:</td><td><input type="text" id="valorcheque" name="valorcheque" value="<?php echo $_POST[valorcheque]?>" size="20" onKeyUp="return tabular(event,this)" readonly></td></tr>	
      </table>
	   </div>
	 </div>
	 
</div>
	  <div class="subpantallac4">
      <?php
	  //*** busca contenido del rp
	  $_POST[dcuentas]=array();
  	  $_POST[dncuentas]=array();
	  $_POST[dvalores]=array();
	  $sqlr="select *from tesoordenpago_det where id_orden=$_POST[idcomp]";
	  //echo $sqlr;
	  $res=mysql_query($sqlr,$linkbd);
	while($r=mysql_fetch_row($res))
	 {
	  $consec=$r[0];	  
	  $_POST[dcuentas][]=$r[2];
	  $_POST[dvalores][]=$r[4];
	   $_POST[dncuentas][]=buscacuentapres($r[2],2);
	 }
	  ?>
	   <table class="inicio">
	   <tr><td colspan="8" class="titulos">Detalle Orden de Pago</td></tr>                  
		<tr><td class="titulos2">Cuenta</td><td class="titulos2">Nombre Cuenta</td><td class="titulos2">Recurso</td><td class="titulos2">Valor</td><td class="titulos2"><img src="imagenes/del.png" ><input type='hidden' name='elimina' id='elimina'  ></td></tr>
		  <?php
		  $_POST[totalc]=0;
		
		 for ($x=0;$x<count($_POST[dcuentas]);$x++)
		 {		 
		
		 echo "<tr><td class='saludo2'><input name='dcuentas[]' value='".$_POST[dcuentas][$x]."' type='text' size='40' readonly></td><td class='saludo2'><input name='dncuentas[]' value='".$_POST[dncuentas][$x]."' type='text' size='80' readonly></td><td class='saludo2'><input name='drecursos[]' value='".$_POST[drecursos][$x]."' type='text' readonly></td><td class='saludo2'><input name='dvalores[]' value='".$_POST[dvalores][$x]."' type='text' size='20'  readonly></td><td class='saludo2'><a href='#' onclick='eliminar($x)'><img src='imagenes/del.png'></a></td></tr>";
		 $_POST[totalc]=$_POST[totalc]+$_POST[dvalores][$x];
		 $_POST[totalcf]=number_format($_POST[totalc],2,".",",");
		 }
		$resultado = convertir($_POST[totalc]);
		$_POST[letras]=$resultado." PESOS M/CTE";
	    echo "<tr><td colspan='2'></td><td class='saludo2'>Total</td><td class='saludo2'><input name='totalcf' type='text' value='$_POST[totalcf]' readonly><input name='totalc' type='hidden' value='$_POST[totalc]'></td></tr><tr><td  class='saludo1'>Son:</td> <td colspan='5' class='saludo1'><input name='letras' type='text' value='$_POST[letras]' size='90'></td></tr>";
		?>
        <script>
        document.form2.valor.value=<?php echo $_POST[totalc];?>;
		//calcularpago();
        </script>
	   </table></div>
	  <?php
if($_POST[oculto]=='2')
{
 	if($_POST[causacion]=='2')
	{$_POST[detallegreso]="ESTE DOCUMENTO NO REQUIERE CAUSACION CONTABLE - ".$_POST[detallegreso];}
	$consec=$_POST[idcomp];
	$linkbd=conectar_bd();
 	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	$sqlr="update tesoordenpago set fecha='$fechaf', tercero='$_POST[tercero]', conceptorden='$_POST[detallegreso]', CC='$_POST[cc]' where id_orden=$_POST[idcomp]";	
if (!mysql_query($sqlr,$linkbd))
		{
			 echo "<table class='inicio'><tr><td class='saludo1'><center>No Se ha Actualizado la Orden de Pago con Exito <img src='imagenes\alert.png'></center></td></tr></table>";
		}
		else
		{
//	$sqlr="update comprobante_cab set fecha='$fechaf',concepto='$_POST[detallegreso]' where id_comp=$_POST[compcont]";
	if($_POST[estado]=='N')
	{
	$sqlr="update comprobante_cab  set estado=0 where numerotipo=$_POST[idcomp] and tipo_comp=11";
	mysql_query($sqlr,$linkbd);
	echo $sqlr;
	}
	else
	{
	$sqlr="delete from comprobante_cab  where numerotipo=$_POST[idcomp] and tipo_comp=11";
	mysql_query($sqlr,$linkbd);
//	$sqlr="update comprobante_det set tercero='$_POST[tercero]' where id_comp='11 $_POST[idcomp]'";
	$sqlr="delete from comprobante_det where id_comp='11 $_POST[idcomp]'";
	mysql_query($sqlr,$linkbd);
	 echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha Actualizado la Orden de Pago con Exito <img src='imagenes\confirm.png'></center></td></tr></table>";
				
		//***cabecera comprobante CXP LIQUIDADA
	 $sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ( $consec,11,'$fechaf','$_POST[detallegreso]',0,0,0,0,'1')";
	mysql_query($sqlr,$linkbd);
	//echo "<br>$sqlr ";
	$idcomp=mysql_insert_id();
//	$_POST[idcomp]=$idcomp;
	//echo "<input type='hidden' name='ncomp' value='$idcomp'>";
	//******************* DETALLE DEL COMPROBANTE CONTABLE  *********************
if($_POST[causacion]!='2')
	{
	for($x=0;$x<count($_POST[dcuentas]);$x++)
	 {
		 //***BUSCAR CUENTA PPTAL ***************
		 $sqlr="select codconcepago,codconcecausa,nomina from pptocuentas where cuenta='".$_POST[dcuentas][$x]."' and (vigencia=".$vigusu." or vigenciaf=$vigusu)";
		 $resp=mysql_query($sqlr,$linkbd);
		 	//echo "<br>$sqlr ";
			//******ACTUALIZACION DE CUENTA PPTAL CUENTAS X PAGAR ************
			
		 while($row=mysql_fetch_row($resp))
		   {
		  	if($row[2]=='N')
			{ 		   
		   $concepto=$row[0];
		   $concepto2=$row[1];
	   	   //CONCEPTO DE CAUSACION******
		   $cuentas=concepto_cuentas($concepto,'P',3,$_POST[cc]);    
			$tam=count($cuentas);
			for($cta=0;$cta<$tam;$cta++)
			{   
				$ctacon=$cuentas[$cta][0];
				//echo "<br>ctaG:".$ctacon;
			  	if ($cuentas[$cta][1]=='N' && $cuentas[$cta][2]=='S')
 			    	{
				  $ncuent=buscacuenta($ctacon);								  
						  if ($_POST[dvalores][$x]>0 && $ncuent!='')
							   {
			$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('11 $consec','".$ctacon."','".$_POST[tercero]."','".$_POST[cc]."','Causacion ".$_POST[dncuentas][$x]."','',0,".$_POST[dvalores][$x].",'1','".$vigusu."')";
							mysql_query($sqlr,$linkbd);
							//echo "<br>ctaG3:".$sqlr;
								}
					}		
					if ($cuentas[$cta][1]=='N' && $cuentas[$cta][3]=='S')
					{
						  	  $ncuent=buscacuenta($ctacon);								  
							  if ($_POST[dvalores][$x]>0 && $ncuent!='')
							   {					
						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('11 $consec','".$ctacon."','".$_POST[tercero]."','".$_POST[cc]."','Causacion ".$_POST[dncuentas][$x]."','',".$_POST[dvalores][$x].",0,'1','".$vigusu."')";
						mysql_query($sqlr,$linkbd);
						//echo "<br>ctaG2:".$sqlr;
							   }
					}	
			 }
		  //CONCEPTO DE PAGO******
		  $cuentas=array();
		   $cuentas=concepto_cuentas($concepto2,'C',3,$_POST[cc]);    			
			$tam=count($cuentas);
			for($cta=0;$cta<$tam;$cta++)
			{   
				$ctacon=$cuentas[$cta][0];
				//echo "<br>ctaP:".$ctacon;
			  	if ($cuentas[$cta][1]=='N' && $cuentas[$cta][3]=='S')
 			    	{
				  $ncuent=buscacuenta($ctacon);								  
						  if ($_POST[dvalores][$x]>0 && $ncuent!='')
							   {
			$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('11 $consec','".$ctacon."','".$_POST[tercero]."','".$_POST[cc]."','Causacion ".$_POST[dncuentas][$x]."','',0,".$_POST[dvalores][$x].",'1','".$vigusu."')";
							mysql_query($sqlr,$linkbd);
							//echo "<br>ctaP2:".$sqlr;
								}
					}		
					if ($cuentas[$cta][1]=='N' && $cuentas[$cta][2]=='S')
					{
						  	  $ncuent=buscacuenta($ctacon);								  
							  if ($_POST[dvalores][$x]>0 && $ncuent!='')
							   {					
						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('11 $consec','".$ctacon."','".$_POST[tercero]."','".$_POST[cc]."','Causacion ".$_POST[dncuentas][$x]."','',".$_POST[dvalores][$x].",0,'1','".$vigusu."')";
						mysql_query($sqlr,$linkbd);
						//echo "<br>ctaP3:".$sqlr;
							   }
					}	
			 }
		  
//***********FIN		  
		  }
		  }
	 }
	}	
  }
	//**************FIN DE CONTABILIDAD	
}
//************CREACION DEL COMPROBANTE CONTABLE ************************
//***busca el consecutivo del comprobante contable
}//************ FIN DE IF OCULTO************
?>	
</form>
 </td></tr>  
</table>
</body>
</html>	 