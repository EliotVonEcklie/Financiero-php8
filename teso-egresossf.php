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
	valorp=document.form2.valor.value;
	//valorpa=document.form2.sumarbase.value;
	valorpa=document.getElementById('sumarbase').value;
//	alert("pa:"+valorpa);
	document.form2.base.value=parseFloat(valorp)+parseFloat(valorpa)-document.form2.iva.value;
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
<script >
function sumapagosant() 
{ 

 cali=document.getElementsByName('pagos[]');
 valrubro=document.getElementsByName('pvalores[]');
 sumar=0;
// document.form2.todos.checked=chkbox.checked;
for (var i=0;i < cali.length;i++) 
{ 
	if (cali.item(i).checked == true) 
	{
//		 alert('si'+i+' '+cali.item(i).value);
//	cali.item(i).checked = true;
	sumar=parseFloat(sumar)+parseFloat(valrubro.item(i).value);	
	
//		alert("cabio"+habdesv.item(i).value);
	}
//		alert("cabio"+habdesv.item(i).value);
} 
//  		alert("cam");
	document.form2.sumarbase.value=sumar;	
	document.getElementById('sumarbase').value=sumar;
	//alert('fjfjfjfjfjf'+sumar );
	 resumar();
} 
</script>
<script >
function resumar() 
{ 
 cali=document.getElementsByName('rubros[]');
 valrubro=document.getElementsByName('dvalores[]');
 sumar=0;
// document.form2.todos.checked=chkbox.checked;
for (var i=0;i < cali.length;i++) 
{ 
	if (cali.item(i).checked == true) 
	{
//		 alert('si'+i+' '+cali.item(i).value);
//	cali.item(i).checked = true;
	sumar=parseFloat(sumar)+parseFloat(valrubro.item(i).value);	
//		alert("cabio"+habdesv.item(i).value);
	}
//		alert("cabio"+habdesv.item(i).value);
} 
//  		alert("cam");
			if(document.form2.regimen.value==1)
			 document.form2.iva.value=Math.round(sumar-sumar/(1.16));	
			 else
			 document.form2.iva.value=0;	
			document.form2.base.value=sumar-document.form2.iva.value+parseFloat(document.form2.sumarbase.value);	
document.form2.totalc.value=sumar;
document.form2.valor.value=sumar;
document.form2.valoregreso.value=sumar;
document.form2.valorcheque.value=document.form2.valor.value-document.form2.valorretencion.value;	
document.form2.submit();	
} 
</script>
<script>
function checktodos()
{
 cali=document.getElementsByName('rubros[]');
 valrubro=document.getElementsByName('dvalores[]');
 for (var i=0;i < cali.length;i++) 
 { 
	if (document.getElementById("todos").checked == true) 
	{
	 cali.item(i).checked = true;
 	 document.getElementById("todos").value=1;	 
	}
	else
	{
	cali.item(i).checked = false;
    document.getElementById("todos").value=0;
	}
 }	
 resumar() ;
}
</script>
<script>
function buscater(e)
 {
if (document.form2.tercero.value!="")
{
 document.form2.bt.value='1';
 document.form2.submit();
 }
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
<tr class="cinta">
  <td colspan="3" class="cinta"><a href="teso-egreso.php" accesskey="n" ><img src="imagenes/add.png" alt="Nuevo"  border="0" /></a> <a href="#"  onClick="guardar()"><img src="imagenes/guarda.png"  alt="Guardar" /></a><a href="teso-buscaegreso.php" accesskey="b" > <img src="imagenes/busca.png"  alt="Buscar" border="0" /></a> <a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" alt="nueva ventana"></a>  <a href="#" onClick="pdf()"> <img src="imagenes/print.png"  alt="Buscar" /></a>	  
</td></tr>
</table>
<tr><td colspan="3" class="tablaprin" align="center"> 
<?php
$vigencia=date(Y);
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
		$check1="checked";
 		 $fec=date("d/m/Y");
		 $_POST[fecha]=$fec; 		 		  			 
		//$_POST[valor]=0;
		//$_POST[valorcheque]=0;
		//$_POST[valorretencion]=0;
		//$_POST[valoregreso]=0;
		//$_POST[totaldes]=0;
		 $_POST[vigencia]=$_SESSION[vigencia]; 		
		 $sqlr="select max(numerotipo) from comprobante_cab where tipo_comp='11' and EXTRACT(YEAR FROM fecha)=".$_SESSION["vigencia"];
		$res=mysql_query($sqlr,$linkbd);
		$consec=0;
		while($r=mysql_fetch_row($res))
		 {
		  $consec=$r[0];	  
	 	}
	 	$consec+=1;
	 	$_POST[idcomp]=$consec;	
		
		$sqlr="select max(id_orden) from tesoordenpago";
		$res=mysql_query($sqlr,$linkbd);
		$consec=0;
		while($r=mysql_fetch_row($res))
		 {
		  $consec=$r[0];	  
	 	}
	 	$consec+=1;
	 	$_POST[idcomp]=$consec;		 
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
break;
case 4:
$check4='checked';
break;
}
if($_POST[anticipo]=='S')
 {
	 $chkant=' checked ';
 }
?>
 <form name="form2" method="post" action=""> 
 <?php
 if($_POST[brp]=='1')
			 {
			  $nresul=buscaregistro($_POST[rp],$_POST[vigencia]);
			  if($nresul!='')
			   {
			  $_POST[cdp]=$nresul;
			  //*** busca detalle cdp
			  $linkbd=conectar_bd();
  				$sqlr="select pptorp.vigencia,pptorp.consvigencia,pptocdp.objeto,pptorp.estado,pptocdp.consvigencia,pptorp.valor,pptorp.saldo,pptorp.tercero, pptocdp.objeto from pptorp,pptocdp where pptorp.estado='S' and pptocdp.consvigencia=$_POST[cdp] and pptorp.idcdp=pptocdp.consvigencia and pptorp.consvigencia=".$_POST[rp]." and pptorp.vigencia=$_POST[vigencia] order by pptorp.vigencia,pptorp.consvigencia,pptocdp.objeto,pptorp.estado";
				//echo $sqlr;
				$resp = mysql_query($sqlr,$linkbd);
				$row =mysql_fetch_row($resp);
				$_POST[detallecdp]=$row[2];
				$_POST[tercero]=$row[7];
				$_POST[ntercero]=buscatercero($_POST[tercero]);
				$_POST[regimen]=buscaregimen($_POST[tercero]);			
				$_POST[valorrp]=$row[5];
				$_POST[saldorp]=$row[6];
				$_POST[valor]=$row[6];
				if($_POST[regimen]==1)
				 $_POST[iva]=round($_POST[valor]-$_POST[valor]/(1.16),1);	
				 else
				 $_POST[iva]=0;			
				 $_POST[base]=$_POST[valor]-$_POST[iva];				 
				$_POST[detallegreso]=$row[8];
				$_POST[valoregreso]=$_POST[valor];
				$_POST[valorretencion]=$_POST[totaldes];
				$_POST[valorcheque]=$_POST[valoregreso]-$_POST[valorretencion];
				$_POST[valorcheque]=number_format($_POST[valorcheque],2);				
			  }
			 else
			 {
			  $_POST[cdp]="";
			  $_POST[detallecdp]="";
			  $_POST[tercero]="";
			  $_POST[ntercero]="";
			  }
			 }
 //***** busca tercero
			 if($_POST[bt]=='1')
			 {
			  $nresul=buscatercero($_POST[tercero]);
			  $_POST[regimen]=buscaregimen($_POST[tercero]);	
			  if($nresul!='')
			   {
			  $_POST[ntercero]=$nresul;
  				if($_POST[regimen]==1)
				 $_POST[iva]=round($_POST[valor]-$_POST[valor]/(1.16),1);	
				 else
				 $_POST[iva]=0;	
				 $_POST[base]=$_POST[valor]-$_POST[iva];				 
			  }
			 else
			 {
			  $_POST[ntercero]="";
			  }
			 }
 
 ?>
 <div class="tabs">
   <div class="tab">
       <input type="radio" id="tab-1" name="tabgroup1" value="1" <?php echo $check1;?> >
	   <label for="tab-1">Liquidacion CxP</label>
	   <div class="content">
    <table class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="12">Liquidacion CxP</td><td width="118" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
      </tr>
      <tr >
		        <td width="108" class="saludo1" >Numero CxP:</td>
        <td ><input name="idcomp" type="text" size="5" value="<?php echo $_POST[idcomp]?>" readonly> <div class="saludo1" style="width:50%; float:right; vertical-align:text-top">Anticipo: <input type="checkbox" name="anticipo" value="S" <?php echo $chkant; ?>></div></td>

	  <td class="saludo1">Fecha: </td>
        <td ><input name="fecha" type="text" value="<?php echo $_POST[fecha]?>" maxlength="10" size="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)"  id="fc_1198971545" onKeyDown="mascara(this,'/',patron,true)" title="DD/MM/YYYY">   <a href="#" onClick="displayCalendarFor('fc_1198971545');"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>     </td>
	  <td width="85"  class="saludo1">Vigencia: </td>
        <td width="244" ><input name="vigencia" type="text" value="<?php echo $_POST[vigencia]?>" maxlength="2" size="10" onKeyPress="javascript:return solonumeros(event)" onKeyUp="return tabular(event,this)" readonly> </td></tr>
        <tr>
        <td  class="saludo1">Registro:
        </td>
        <td><input name="rp" type="text" value="<?php echo $_POST[rp]?>" size="10" onKeyUp="return tabular(event,this)" onBlur="buscarp(event)" ><input type="hidden" value="0" name="brp">
            <a href="#" onClick="mypop=window.open('registro-ventana.php?vigencia=<?php echo $_POST[vigencia]?>','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=900,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>        </td>
	  <td class="saludo1">CDP:</td>
	  <td>
<input type="text" id="cdp" name="cdp" value="<?php echo $_POST[cdp]?>" size="10" readonly></td>
	  <td class="saludo1">Detalle RP:</td>
	  <td colspan="9">
<input type="text" id="detallecdp" name="detallecdp" value="<?php echo $_POST[detallecdp]?>" size="80" readonly></td>

	  </tr> 
	  <tr>
	  <td class="saludo1">Centro Costo:</td>
	  <td>
	<select name="cc"  onChange="validar()" onKeyUp="return tabular(event,this)">
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
          <td  ><input id="tercero" type="text" name="tercero" size="10" onKeyUp="return tabular(event,this)" onBlur="buscater(event)" value="<?php echo $_POST[tercero]?>" ><input type="hidden" value="0" name="bt"><a href="#" onClick="mypop=window.open('terceros-ventana.php','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=900,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a>
           </td>
          <td colspan="6"><input  id="ntercero"  name="ntercero" type="text" value="<?php echo $_POST[ntercero]?>" size="70" readonly></td></tr>
          <tr><td class="saludo1">Detalle Orden de Pago:</td><td colspan="8">
<input type="text" id="detallegreso" name="detallegreso" value="<?php echo $_POST[detallegreso]?>" size="158" ></td></tr>
	  <tr><td class="saludo1">Valor RP:</td><td><input type="text" id="valorrp" name="valorrp" value="<?php echo $_POST[valorrp]?>" size="15" onKeyUp="return tabular(event,this)" readonly></td><td class="saludo1">Saldo:</td><td><input type="text" id="saldorp" name="saldorp"  value="<?php echo $_POST[saldorp]?>" size="15" onKeyUp="return tabular(event,this)" readonly></td>
	  <td class="saludo1" >Valor a Pagar:</td><td><input type="text" id="valor" name="valor" value="<?php echo $_POST[valor]?>" size="15" readonly> <input type="hidden" value="1" name="oculto"></td><td class="saludo1" >Base:</td><td><input type="text" id="base" name="base" value="<?php echo $_POST[base]?>" size="15" onKeyUp="return tabular(event,this)" onChange='calcularpago()' readonly> </td><td class="saludo1" >Iva:</td><td><input type="text" id="iva" name="iva" value="<?php echo $_POST[iva]?>" size="15" onKeyUp="return tabular(event,this)" onChange='calcularpago()' onBlur="calcularpago()" > <input type="hidden" id="regimen" name="regimen" value="<?php echo $_POST[regimen]?>" ></td></tr>
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
			  $nresul=buscaregistro($_POST[rp],$_POST[vigencia]);
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
			 
			  if($_POST[bt]=='1')
			 {
			  $nresul=buscatercero($_POST[tercero]);
			  $_POST[regimen]=buscaregimen($_POST[tercero]);	
			  if($nresul!='')
			   {
			  $_POST[ntercero]=$nresul;
			  if($_POST[regimen]==1)
				 $_POST[iva]=round($_POST[valor]-$_POST[valor]/(1.16),1);	
				 else
				 $_POST[iva]=0;	
				 $_POST[base]=$_POST[valor]-$_POST[iva];
  				?>
			  <script>
			  document.getElementById('detallegreso').focus();document.getElementById('detallegreso').select();</script>
			  <?php
			  }
			 else
			 {
			  $_POST[ntercero]="";
			  ?>
			  <script>
				alert("Tercero Incorrecto o no Existe")				   		  	
		  		document.form2.tercero.focus();	
			  </script>
			  <?php
			  }
			 }
			?>
	  </div>
    </div>
	<div class="tab">
       <input type="radio" id="tab-2" name="tabgroup1" value="2" <?php echo $check2;?> >
       <label for="tab-2">Retenciones</label>
       <div class="content"> 
	   <table class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="8">Retenciones</td><td width="108" class="cerrar" ><a href="teso-principal.php">X Cerrar</a></td>
      </tr>
		<tr><td class="saludo1">Retencion y Descuento:</td>
		<td>
		<select name="retencion"  onChange="validar()" onKeyUp="return tabular(event,this)">
		<option value="">Seleccione ...</option>
	<?php
	$linkbd=conectar_bd();
	$sqlr="select *from tesoretenciones where estado='S'";
	$res=mysql_query($sqlr,$linkbd);
	while ($row =mysql_fetch_row($res)) 
				    {
					echo "<option value=$row[0] ";
					$i=$row[0];	
					 if($i==$_POST[retencion])
			 			{
						 echo "SELECTED";
						  $_POST[porcentaje]=$row[5];
						  $_POST[nretencion]=$row[1]." - ".$row[2];
						  if($_POST[porcentaje]>0)
						   {
						  if($row[7]!='1')
						   {
						  $_POST[vporcentaje]=round(($_POST[base]*$_POST[porcentaje])/100);						  
						   }
						   else
						   {
   						  $_POST[vporcentaje]=round(($_POST[iva]*$_POST[porcentaje])/100);
							 }
						   }
							else
							{
							 $ro='';
						  if($_POST[vporcentaje]==0)
							 $ro='';
							 else
							 $ro='readonly';	
						     } 
							 					
						 }
					  echo ">".$row[1]." - ".$row[2]."</option>";	 	 
					}	 	
	?>
   </select><input type="hidden" value="<?php echo $_POST[nretencion]?>" name="nretencion">
		
		</td><td class="saludo1">%</td><td><input id="porcentaje" name="porcentaje" type="text" size="5" value="<?php echo $_POST[porcentaje]?>" readonly> %</td>
		<td class="saludo1">Valor:</td><td><input id="vporcentaje" name="vporcentaje" type="text" size="10" value="<?php echo $_POST[vporcentaje]?>" <?php echo $ro; ?>>
        </td><td class="saludo1">Total Descuentos:</td><td><input id="totaldes" name="totaldes" type="text" size="10" value="<?php echo $_POST[totaldes]?>" readonly>
        <input type="button" name="agregard" id="agregard" value="   Agregar   " onClick="agregardetalled()" ><input type="hidden" value="0" name="agregadetdes"></td>
		</tr>
        <?php 	
		$_POST[valoregreso]=$_POST[valor];
		$_POST[valorretencion]=$_POST[totaldes];
		$_POST[valorcheque]=$_POST[valoregreso]-$_POST[valorretencion];
		if ($_POST[eliminad]!='')
		 { 
		 //echo "<TR><TD>ENTROS :".$_POST[elimina]."</TD></TR>";
		 $posi=$_POST[eliminad];
		 unset($_POST[ddescuentos][$posi]);
		 unset($_POST[dndescuentos][$posi]);
		 unset($_POST[dporcentajes][$posi]);
		 unset($_POST[ddesvalores][$posi]);
		 $_POST[ddescuentos]= array_values($_POST[ddescuentos]); 
		 $_POST[dndescuentos]= array_values($_POST[dndescuentos]); 
		 $_POST[dporcentajes]= array_values($_POST[dporcentajes]); 
		 $_POST[ddesvalores]= array_values($_POST[ddesvalores]); 		 
		 }	 
		 if ($_POST[agregadetdes]=='1')
		 {
		 $_POST[ddescuentos][]=$_POST[retencion];
		 $_POST[dndescuentos][]=$_POST[nretencion];
		 $_POST[dporcentajes][]=$_POST[porcentaje];
		 $_POST[ddesvalores][]=$_POST[vporcentaje];
		 $_POST[agregadetdes]='0';
		 ?>
		 <script>
         document.form2.porcentaje.value=0;
        document.form2.vporcentaje.value=0;	
		document.form2.retencion.value='';	
        </script>
		<?php
		 }	
		  ?>
    
         <table class="inicio" style="overflow:scroll">
        <tr><td class="titulos">Descuento</td><td class="titulos">%</td><td class="titulos">Valor</td><td class="titulos2"><img src="imagenes/del.png" ><input type='hidden' name='eliminad' id='eliminad'></td></tr>
      	<?php
		$totaldes=0;
//		echo "v:".$_POST[valor];
		for ($x=0;$x<count($_POST[ddescuentos]);$x++)
		 {		 		 
		 echo "<tr><td class='saludo2'><input name='dndescuentos[]' value='".$_POST[dndescuentos][$x]."' type='text' size='100' readonly><input name='ddescuentos[]' value='".$_POST[ddescuentos][$x]."' type='hidden'></td>";
		 echo "<td class='saludo2'><input name='dporcentajes[]' value='".$_POST[dporcentajes][$x]."' type='text' size='5' readonly></td>";
		 echo "<td class='saludo2'><input name='ddesvalores[]' value='".($_POST[ddesvalores][$x])."' type='text' size='15' readonly></td><td class='saludo2'><a href='#' onclick='eliminard($x)'><img src='imagenes/del.png'></a></td></tr>";
// 		 echo "<td class='saludo2'><input name='ddesvalores[]' value='".$_POST[ddesvalores][$x]."' type='text' size='15'></td><td class='saludo2'><a href='#' onclick='eliminard($x)'><img src='imagenes/del.png'></a></td></tr>";
		 $totaldes=$totaldes+($_POST[ddesvalores][$x])	;
		 }		 
		$_POST[valorretencion]=$totaldes;

		?>
        <script>
        document.form2.totaldes.value=<?php echo $totaldes;?>;		
//	calcularpago();
       document.form2.valorretencion.value=<?php echo $totaldes;?>;
        </script>
        <?php
		$_POST[valorcheque]=$_POST[valoregreso]-$_POST[valorretencion];
		?>
        </table>
      
      </table>
	   </div>
   </div>
   
    <div class="tab">
       <input type="radio" id="tab-3" name="tabgroup1" value="3" <?php echo $check3;?>>
       <label for="tab-3">Cuenta por Pagar</label>
       <div class="content"> 
	   <table class="inicio" align="center" >
	   <tr><td colspan="6" class="titulos">Cheque</td><td width="108" class="cerrar" ><a href="teso-principal.php">X Cerrar</a></td></tr>
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
	  <div class="subpantallac6">
      <?php
	  if($_POST[brp]=='1')
	  {
		  $_POST[brp]=0;
	  //*** busca contenido del rp
	  $_POST[dcuentas]=array();
  	  $_POST[dncuentas]=array();
	  $_POST[dvalores]=array();
	  $_POST[drecursos]=array();
	  $_POST[dnrecursos]=array();	  	  
	  $_POST[rubros]=array();	  	  	  
	  $sqlr="select *from pptorp_detalle where pptorp_detalle.consvigencia=(select pptorp.consvigencia from pptorp where consvigencia=".$_POST[rp]." and pptorp.vigencia=$_POST[vigencia] ) and pptorp_detalle.vigencia=$_POST[vigencia]";
	  //echo $sqlr;
	  $res=mysql_query($sqlr,$linkbd);
	while($r=mysql_fetch_row($res))
	 {
	  $consec=$r[0];	  
	  $_POST[dcuentas][]=$r[3];
	  $_POST[dvalores][]=$r[7]-$r[8];
	   $_POST[dncuentas][]=buscacuentapres($r[3],2);	   
	   $_POST[rubros][]=$r[3];	   
	   $ind=substr($r[3],0,1);
//	   echo "i".$ind;
			if($ind=='R' || $ind=='r')
					 {						
					$ind=substr($r[3],1,1);						  
					 }	
			  if ($ind=='2')
			  $sqlr="select pptocuentas.futfuentefunc,pptocuentaspptoinicial.saldoscdprp,pptofutfuentefunc.nombre from pptocuentas,pptocuentaspptoinicial,pptofutfuentefunc where pptocuentas.cuenta='$r[3]' and pptocuentas.cuenta=pptocuentaspptoinicial.cuenta and pptocuentas.futfuentefunc=pptofutfuentefunc.codigo";
			  if ($ind=='3' || $ind=='4')
			  $sqlr="select pptocuentas.futfuenteinv,pptocuentaspptoinicial.saldoscdprp,pptofutfuenteinv.nombre from pptocuentas,pptocuentaspptoinicial,pptofutfuenteinv where pptocuentas.cuenta='$r[3]' and pptocuentas.cuenta=pptocuentaspptoinicial.cuenta and pptofutfuenteinv.codigo=pptocuentas.futfuenteinv";
			  //echo $sqlr;
			  $res2=mysql_query($sqlr,$linkbd);
			  $row=mysql_fetch_row($res2);
    if($row[1]!='' || $row[1]!=0)
			     {
				  $_POST[drecursos][]=$row[0];
				  $_POST[dnrecursos][]=$row[2];
				//  $_POST[valor]=$row[1];			  
				 }
				 else
				  {
				  $_POST[drecurso][]="";
				  $_POST[dnrecurso][]="";
				  }	 
		 }
	  }
	  ?>
	   <table class="inicio">
	   <tr><td colspan="8" class="titulos">Detalle Orden de Pago</td></tr>                  
       <?php
	   if($_POST[todos]==1)
	    $checkt='checked';
		else
	    $checkt='';
	   ?>
		<tr><td class="titulos2">Cuenta</td><td class="titulos2">Nombre Cuenta</td><td class="titulos2">Recurso</td><td class="titulos2">Valor</td><td class="titulos2"><input type="checkbox" id="todos" name="todos" onClick="checktodos()" value="<?php echo $_POST[todos]?>" <?php echo $checkt ?>><input type='hidden' name='elimina' id='elimina'  ></td></tr>
<?php
		  $_POST[totalc]=0;
		 for ($x=0;$x<count($_POST[dcuentas]);$x++)
		 {		
		 $chk=''; 
		$ch=esta_en_array($_POST[rubros],$_POST[dcuentas][$x]);
			if($ch=='1')
			 {
			 $chk="checked";
			 //echo "ch:$x".$chk;
			 $_POST[totalc]=$_POST[totalc]+$_POST[dvalores][$x];
			// $_POST[totalcf]=number_format($_POST[totalc],2,".",",");
			 }
			
		 echo "<tr><td class='saludo2'><input name='dcuentas[]' value='".$_POST[dcuentas][$x]."' type='text' size='40' readonly></td><td class='saludo2'><input name='dncuentas[]' value='".$_POST[dncuentas][$x]."' type='text' size='80' readonly></td><td class='saludo2'><input name='drecursos[]' value='".$_POST[drecursos][$x]."' type='hidden' ><input name='dnrecursos[]' value='".$_POST[dnrecursos][$x]."' type='text' size='40' readonly></td><td class='saludo2'><input name='dvalores[]' value='".$_POST[dvalores][$x]."' type='text' size='20' onDblClick='llamarventanaegre(this,$x);' readonly></td><td class='saludo2'><input type='checkbox' name='rubros[]' value='".$_POST[dcuentas][$x]."' onClick='resumar()' $chk></td></tr>";
		 }
		$resultado = convertir($_POST[totalc]);
		$_POST[letras]=$resultado." PESOS M/CTE";
		 $_POST[totalcf]=number_format($_POST[totalc],2,".",",");
	    echo "<tr><td colspan='2'></td><td class='saludo2'>Total</td><td class='saludo2'><input name='totalcf' type='text' value='$_POST[totalcf]' readonly><input name='totalc' type='hidden' value='$_POST[totalc]'></td></tr><tr><td  class='saludo1'>Son:</td> <td colspan='5' class='saludo1'><input name='letras' type='text' value='$_POST[letras]' size='90'></td></tr>";
		?>
        <script>
        document.form2.valor.value=<?php echo $_POST[totalc];?>;
        document.form2.valoregreso.value=<?php echo $_POST[totalc];?>;		
        document.form2.valorcheque.value=document.form2.valor.value-document.form2.valorretencion.value;		
		//calcularpago();
        </script>
	   </table></div>
	  <?php
if($_POST[oculto]=='2')
{
	$linkbd=conectar_bd();
	 	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_POST[fecha],$fecha);
	$fechaf=$fecha[3]."-".$fecha[2]."-".$fecha[1];
	$bloq=bloqueos($_SESSION[cedulausu],$fechaf);	
	if($bloq>=1)
	{
	 $sqlr="select count(*) from tesoordenpago where id_orden=$_POST[idcomp] ";
		$res=mysql_query($sqlr,$linkbd);
		//echo $sqlr;
		while($r=mysql_fetch_row($res))
		 {
			$numerorecaudos=$r[0];
		 }
	  if($numerorecaudos==0)
	   { 	
//************CREACION DEL COMPROBANTE CONTABLE ************************
//***busca el consecutivo del comprobante contable
	$consec=0;
	$sqlr="select max(id_orden) from  tesoordenpago ";
	//echo $sqlr;
	$res=mysql_query($sqlr,$linkbd);
	while($r=mysql_fetch_row($res))
	 {
	  $consec=$r[0];	  
	 }
	 $consec+=1;
//***cabecera comprobante CXP LIQUIDADA
	 $sqlr="insert into comprobante_cab (numerotipo,tipo_comp,fecha,concepto,total,total_debito,total_credito,diferencia,estado) values ($consec,11,'$fechaf','$_POST[detallegreso]',0,$_POST[totalc],$_POST[totalc],0,'1')";
	mysql_query($sqlr,$linkbd);
	//echo "<br>$sqlr ";
	$idcomp=mysql_insert_id();
	$_POST[idcomp]=$idcomp;
	echo "<input type='hidden' name='ncomp' value='$idcomp'>";
	//******************* DETALLE DEL COMPROBANTE CONTABLE  *********************
 for ($y=0;$y<count($_POST[rubros]);$y++)
	  {
	for($x=0;$x<count($_POST[dcuentas]);$x++)
	 {
	  if($_POST[dcuentas][$x]==$_POST[rubros][$y])  
		  {
		 //***BUSCAR CUENTA PPTAL ***************
		 $sqlr="select codconcepago,codconcecausa,nomina from pptocuentas where cuenta=".$_POST[dcuentas][$x]." and vigencia=".$_SESSION[vigencia];
		 $resp=mysql_query($sqlr,$linkbd);
		 //	echo "<br>$sqlr ";
			//******ACTUALIZACION DE CUENTA PPTAL CUENTAS X PAGAR ************
			
		 while($row=mysql_fetch_row($resp))
		   {
			 $sqlrc="Select * from conceptoscontables_det where estado='S' and modulo='3' AND codigo=".$row[0]." and tipo='P'";
		 	$resc=mysql_query($sqlrc,$linkbd);   
			//echo "<br>$rowc[5]   -   $sqlrc ";
			while($rowc=mysql_fetch_row($resc))
		   {	   
		   		//	echo "<br>$rowc[5]";
		 //******buscar CONCEPTO CONTABLE DE PAGO
	    //**** CUENTA COntables*****
				if ($rowc[5]==$_POST[cc])
				 {
					  if ($rowc[3]=='N')
					   {
						  //****no es  NOMINA
						   $ncuent=buscacuenta($row[1]);	
						   if($row[2]=='N' && $ncuent!='')
						    {
						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('11 $consec','".$rowc[4]."','".$_POST[tercero]."','".$_POST[cc]."','Causacion ".$_POST[dncuentas][$x]."','',0,".$_POST[dvalores][$x].",'1','".$_SESSION[vigencia]."')";
					//	echo "<br>".$sqlr;
						mysql_query($sqlr,$linkbd);
						$sqlr="insert into comprobante_det (id_comp,cuenta,tercero,centrocosto,detalle,cheque,valdebito,valcredito,estado,vigencia) values ('11 $consec','".$row[1]."','".$_POST[tercero]."','".$_POST[cc]."','Causacion ".$_POST[dncuentas][$x]."','',".$_POST[dvalores][$x].",0,'1','".$_SESSION[vigencia]."')";
						mysql_query($sqlr,$linkbd);
						//echo "<br>".$sqlr;
							}
						    //***causacion
						   //***cxp						
					   }

					//	echo " <br>$sqlr";
				 }

		   }
		  }
		}
	  }
	}	
	//**************FIN DE CONTABILIDAD	


	//**************PPTO AFECTAR LAS CUENTAS PPTALES CAMPO CxP
		 for ($y=0;$y<count($_POST[rubros]);$y++)
		  {
		for($x=0;$x<count($_POST[dcuentas]);$x++)
		 {	
		  if($_POST[dcuentas][$x]==$_POST[rubros][$y])
			  {
			$sqlr="update pptocuentaspptoinicial set cxp=cxp+".$_POST[dvalores][$x]." where cuenta=".$_POST[dcuentas][$x]." ";
			$res=mysql_query($sqlr,$linkbd); 
			$sqlr2="update pptorp_detalle set saldo=saldo-".$_POST[dvalores][$x]." where cuenta='".$_POST[dcuentas][$x]."' and consvigencia=".$_POST[rp]." and vigencia=".$vigusu;
			$res2=mysql_query($sqlr2,$linkbd); 
			//echo "<br>$sqlr2";
			  }
		   }
		 }
		 //***ACTUALIZACION  DEL REGISTRO
		 $sqlr="update pptorp set saldo=saldo-".$_POST[valoregreso]." where consvigencia=".$_POST[rp]." and vigencia=".$_SESSION[vigencia];
			$res=mysql_query($sqlr,$linkbd); 
		 //*****
	///*******INCIO DE TABLAS DE TESORERIA **************
	//**** ENCABEZADO ORDEN DE PAGO
	//****** DETALLE ORDEN DE PAGO
	//****** ORDEN PAGO BASES RETENCION ****
	   }
	     }
  else
   {
    echo "<div class='inicio'><img src='imagenes\alert.png'> No Tiene los Permisos para Modificar este Documento</div>";
   }
  //****fin if bloqueo  
}//************ FIN DE IF OCULTO************
?>	
</form>
 </td></tr>  
</table>
</body>
</html>	 