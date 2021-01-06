<?php //V 1000 12/12/16 ?> 
<?php
require "comun.inc";
require "funciones.inc";
require "conversor.php";
session_start();
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
function buscater(e)
 {
if (document.form2.tercero.value!="")
{
 document.form2.bt.value='1';
 document.form2.submit();
 }
 }
</script>
<script>
function agregardetalle()
{
if(document.form2.codingreso.value!="" &&  document.form2.valor.value>0  )
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
//************* genera reporte ************
//***************************************
function guardar()
{
ingresos2=document.getElementsByName('dcoding[]');
if (document.form2.fecha.value!='' && ingresos2.length>0)
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
function pdf()
{
document.form2.action="teso-pdfssf.php";
document.form2.target="_BLANK";
document.form2.submit(); 
document.form2.action="";
document.form2.target="";
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
<script>
function buscaing(e)
 {
if (document.form2.codingreso.value!="")
{
 document.form2.bin.value='1';
 document.form2.submit();
 }
 }
</script>
<script language="JavaScript1.2">
function adelante()
{
   //alert("adelante"+document.form2.ncomp.value);
//document.form2.oculto.value=2;
if(parseFloat(document.form2.ncomp.value)<parseFloat(document.form2.maximo.value))
 {
document.form2.oculto.value=1;
//document.form2.agregadet.value='';
//document.form2.elimina.value='';
document.form2.ncomp.value=parseFloat(document.form2.ncomp.value)+1;
document.form2.idcomp.value=parseFloat(document.form2.idcomp.value)+1;
document.form2.action="teso-editasinsituacionppto.php";
document.form2.submit();
}
}
</script>
<script language="JavaScript1.2">
function atrasc()
{
	   //alert("atras"+document.form2.ncomp.value);
//document.form2.oculto.value=2;
if(document.form2.ncomp.value>1)
 {
document.form2.oculto.value=1;
//document.form2.agregadet.value='';
//document.form2.elimina.value='';
document.form2.ncomp.value=document.form2.ncomp.value-1;
document.form2.idcomp.value=document.form2.idcomp.value-1;
document.form2.action="teso-editasinsituacionppto.php";
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
document.form2.action="teso-editasinsituacionppto.php";
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
  <td colspan="3" class="cinta"><a href="#" ><img src="imagenes/add.png" alt="Nuevo"  border="0" /></a> <a href="#" onClick="guardar()"><img src="imagenes/guarda.png"  alt="Guardar" /></a><a href="#"> <img src="imagenes/busca.png"  alt="Buscar" /></a> <a href="#" onClick="mypop=window.open('teso-principal.php','','');mypop.focus();"><img src="imagenes/nv.png" alt="nueva ventana"></a> <a href="#" <?php if($_POST[oculto]==2) { ?> onClick="pdf()"  <?php } ?>> <img src="imagenes/print.png"  alt="Buscar" /></a> <a href="teso-actualizardocs.php"><img src="imagenes/iratras.png" alt="nueva ventana"></a></td>
</tr>		  
</table>
<tr>
<td colspan="3" class="tablaprin" align="center"> 
<?php
//$vigencia=date(Y);
$linkbd=conectar_bd();
$vigusu=vigencia_usuarios($_SESSION[cedulausu]);
 ?>	
<?php
	  //*********** 11050501	CAJA PRINCIPAL esta es la cuenta que va a credito en todas las consignacones
if(!$_POST[oculto])
{
	
	$sqlr="select * from tesossfingreso_cab";
	$res=mysql_query($sqlr,$linkbd);
	$consec=0;
	while($r=mysql_fetch_row($res))
	 {
  	 $_POST[maximo]=$r[0];
	 $_POST[ncomp]=$r[0];
	 $_POST[idcomp]=$r[0];
	 $_POST[idrecaudo]=$r[1];	 
	 }
}
		 $_POST[dcoding]= array(); 		 
		 $_POST[dncoding]= array(); 		 
		 $_POST[dvalores]= array(); 	
	 $sqlr="select * from tesossfingreso_cab WHERE ID_RECAUDO='$_POST[idcomp]'";
	$res=mysql_query($sqlr,$linkbd);

	while($row=mysql_fetch_row($res))
	 {
	 $_POST[idcomp]=$row[0];
	 $_POST[fecha]=$row[2];
	 $_POST[vigencia]=$row[3];
	 $_POST[concepto]=$row[4];			 
	 $_POST[tercero]=$row[5];	
	 $_POST[ntercero]=buscatercero($row[5]);		 
	 $_POST[cc]=$row[6];			 	 	 
	 $_POST[valortotal]=$row[7];			
	// $_POST[estado]=$row[8];			 	 	 	  	 	 	 
	 if($row[8]=='S')
	 {
	 $_POST[estado]="ACTIVO";
	 $_POST[estadoc]="1";			 	 	 	  	 	 	 
	 }
	 if($row[8]=='N')
	 {
	 $_POST[estado]="ANULADO";
	 $_POST[estadoc]="0";	 
	 }
	 }
	 $sqlr="select * from tesossfingreso_det WHERE ID_RECAUDO='$_POST[idcomp]'";
	$res=mysql_query($sqlr,$linkbd);
	while($r=mysql_fetch_row($res))
	{
	 $_POST[dcoding][]=$r[2];
	 $_POST[dncoding][]=buscaingresossf($r[2]);			 		
	 $_POST[dvalores][]=$r[3];
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
 //***** busca tercero
			 if($_POST[bt]=='1')
			 {
			  $nresul=buscatercero($_POST[tercero]);
			  if($nresul!='')
			   {
			  $_POST[ntercero]=$nresul;
  	
			  }
			 else
			 {
			  $_POST[ntercero]="";
			  }
			 }
//******** busca ingreso *****
//***** busca tercero
			 if($_POST[bin]=='1')
			 {
			  $nresul=buscaingresossf($_POST[codingreso]);
			  if($nresul!='')
			   {
			  $_POST[ningreso]=$nresul;
  	
			  }
			 else
			 {
			  $_POST[ningreso]="";
			  }
			 }
			 
 ?>
 

    <table class="inicio" align="center" >
      <tr >
        <td class="titulos" colspan="9"> Ingresos Sin Situacion de Fondos - SSF</td>
        <td width="70" class="cerrar" ><a href="teso-principal.php">Cerrar</a></td>
      </tr>
      <tr  >
        <td   class="saludo1" >Numero Ingreso:</td>
        <td  ><a href="#" onClick="atrasc()"><img src="imagenes/back.png" alt="anterior" align="absmiddle"></a> <input name="idcomp" type="text" size="5" value="<?php echo $_POST[idcomp]?>" onKeyUp="return tabular(event,this) "   onBlur="validar2()" ><input name="ncomp" type="hidden" value="<?php echo $_POST[ncomp]?>"><a href="#" onClick="adelante()"><img src="imagenes/next.png" alt="siguiente" align="absmiddle"></a> <input type="hidden" value="a" name="atras" ><input type="hidden" value="s" name="siguiente" ><input type="hidden" value="<?php echo $_POST[maximo]?>" name="maximo"></td>
	  <td    class="saludo1">Fecha:</td>
        <td  ><input name="fecha" type="date" size="10" value="<?php echo $_POST[fecha]; ?>" onKeyUp="return tabular(event,this) "  maxlength="10" readonly> </td>
         <td class="saludo1">Vigencia:</td>
		  <td ><input type="text" id="vigencia" name="vigencia" size="8" onKeyPress="javascript:return solonumeros(event)" 
		  onKeyUp="return tabular(event,this)"  value="<?php echo $_POST[vigencia]?>" onClick="document.getElementById('tipocta').focus();document.getElementById('tipocta').select();" readonly> <input name="estado" value="<?php echo $_POST[estado]?>" readonly> <input type="hidden" name="estadoc" value="<?php echo $_POST[estadoc]?>" readonly>     
        </tr>       
      <tr>
        <td  class="saludo1">Concepto Ingreso:</td>
        <td colspan="5" ><input name="concepto" type="text" value="<?php echo $_POST[concepto]?>" size="169"  onKeyUp="return tabular(event,this)"></td></tr>  
      <tr>
        <td  class="saludo1">NIT: </td>
        <td ><input name="tercero" type="text" value="<?php echo $_POST[tercero]?>" size="20" onKeyUp="return tabular(event,this)" onBlur="buscater(event)">
          <a href="#" onClick="mypop=window.open('terceros-ventana.php?ti=1','','menubar=0,scrollbars=yes, toolbar=no, location=no, width=700px,height=500px');mypop.focus();"><img src="imagenes/buscarep.png" align="absmiddle" border="0"></a></td>
			  <td class="saludo1">Contribuyente:</td>
	  <td colspan="3"  ><input type="text" id="ntercero" name="ntercero" value="<?php echo $_POST[ntercero]?>" size="80" onKeyUp="return tabular(event,this) "  readonly><input type="hidden" value="0" name="bt"><input type="hidden" id="cb" name="cb" value="<?php echo $_POST[cb]?>" ><input type="hidden" id="ct" name="ct" value="<?php echo $_POST[ct]?>" >
	  
	    <input type="hidden" value="1" name="oculto"></td>
	 
       </tr>
	  <tr><td class="saludo1">Centro Costo:</td>
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
	 </td></tr>
      </table>
       <?php
           //***** busca tercero
			 if($_POST[bt]=='1')
			 {
			  $nresul=buscatercero($_POST[tercero]);
			  if($nresul!='')
			   {
			  $_POST[ntercero]=$nresul;
  				?>
<script>
			  document.getElementById('codingreso').focus();document.getElementById('codingreso').select();</script>
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
			 //*** ingreso
			 if($_POST[bin]=='1')
			 {
			  $nresul=buscaingresossf($_POST[codingreso]);
			  if($nresul!='')
			   {
			  $_POST[ningreso]=$nresul;
  			  ?>
			  <script>
			  document.getElementById('valor').focus();document.getElementById('valor').select();</script>
			  <?php
			  }
			 else
			 {
			  $_POST[codingreso]="";
			  ?>
			  <script>alert("Codigo Ingresos Incorrecto");document.form2.codingreso.focus();</script>
			  <?php
			  }
			 }
			 ?>
      
     <div class="subpantalla">
	   <table class="inicio">
	   	   <tr>
   	      <td colspan="4" class="titulos">Detalle  Ingresos Sin Situacion de Fondos</td></tr>                  
		<tr><td class="titulos2">Codigo</td><td class="titulos2">Ingreso</td><td class="titulos2">Valor</td><td class="titulos2"><img src="imagenes/del.png" ><input type='hidden' name='elimina' id='elimina'></td></tr>
		<?php 		
		if ($_POST[elimina]!='')
		 { 
		 //echo "<TR><TD>ENTROS :".$_POST[elimina]."</TD></TR>";
		 $posi=$_POST[elimina];
		  
 		 unset($_POST[dcoding][$posi]);	
 		 unset($_POST[dncoding][$posi]);			 
		 unset($_POST[dvalores][$posi]);			  		 
		 $_POST[dcoding]= array_values($_POST[dcoding]); 		 
		 $_POST[dncoding]= array_values($_POST[dncoding]); 		 		 
		 $_POST[dvalores]= array_values($_POST[dvalores]); 		 		 		 		 		 
		 }	 
		 if ($_POST[agregadet]=='1')
		 {
		 $_POST[dcoding][]=$_POST[codingreso];
		 $_POST[dncoding][]=$_POST[ningreso];			 		
		  $_POST[dvalores][]=$_POST[valor];
		 $_POST[agregadet]=0;
		  ?>
		 <script>
		  		//document.form2.cuenta.focus();	
				document.form2.codingreso.value="";
				document.form2.valor.value="";	
				document.form2.ningreso.value="";				
				document.form2.codingreso.select();
		  		document.form2.codingreso.focus();	
		 </script>
         
         
		  <?php
		  }
		  $_POST[totalc]=0;
		 for ($x=0;$x<count($_POST[dcoding]);$x++)
		 {		 
		 echo "<tr><td class='saludo1'><input name='dcoding[]' value='".$_POST[dcoding][$x]."' type='text' size='4' readonly></td><td class='saludo1'><input name='dncoding[]' value='".$_POST[dncoding][$x]."' type='text' size='90'  readonly></td><td class='saludo1'><input name='dvalores[]' value='".$_POST[dvalores][$x]."' type='text' size='15'  readonly></td><td class='saludo1'><a href='#' onclick='eliminar($x)'><img src='imagenes/del.png'></a></td></tr>";
		 $_POST[totalc]=$_POST[totalc]+$_POST[dvalores][$x];
		 $_POST[totalcf]=number_format($_POST[totalc],2);
		 }
 			$resultado = convertir($_POST[totalc]);
			$_POST[letras]=$resultado." Pesos";
		 echo "<tr><td></td><td class='saludo2'>Total</td><td class='saludo1'><input name='totalcf' type='text' value='$_POST[totalcf]'><input name='totalc' type='hidden' value='$_POST[totalc]'></td></tr><tr><td class='saludo1'>Son:</td><td colspan='5' ><input name='letras' type='text' value='$_POST[letras]' size='90'></td></tr>";
		?> 
	   </table></div>
	  <?php
if($_POST[oculto]=='2')
{
	$fechaf=$_POST[fecha];
	//*********************CREACION DEL COMPROBANTE CONTABLE ***************************
//***busca el consecutivo del comprobante contable
	$consec=$_POST[idcomp];
	 $sqlr="delete from pptocomprobante_cab where numerotipo=$_POST[idcomp] and tipo_comp='21'";
	  mysql_query($sqlr,$linkbd);
	    $sqlr="delete from pptocomprobante_det where  numerotipo=$_POST[idcomp] and tipo_comp='21'";
		//echo $sqlr;
		mysql_query($sqlr,$linkbd);		
	$sqlr="delete from pptoingssf where idrecibo=$_POST[idcomp]";	
  	mysql_query($sqlr,$linkbd);
//***cabecera comprobante
	  $sqlr="insert into  pptocomprobante_cab (numerotipo,tipo_comp,fecha,concepto,vigencia,total_debito,total_credito,diferencia,estado) values($_POST[idcomp],21,'$fechaf','INGRESOS SSF $_POST[concepto]',$_POST[vigencia],0,0,0,'$_POST[estadoc]')";
	  if(mysql_query($sqlr,$linkbd))
	  {
		  echo "<table class='inicio'><tr><td class='saludo1'><center>Se ha Actualizado el Ingreso SSF con Exito <img src='imagenes/confirm.png'><script></script></center></td></tr></table>"; 
	//******************* DETALLE DEL COMPROBANTE CONTABLE *********************
	for($x=0;$x<count($_POST[dcoding]);$x++)
	 {
		 //***** BUSQUEDA INGRESO ********
		$sqlri="Select * from tesoingresossf_det where codigo='".$_POST[dcoding][$x]."' and vigencia=$_POST[vigencia]";
	 	$res2=mysql_query($sqlri,$linkbd);
		//	echo "$sqlri <br>";	    
	  while($row2=mysql_fetch_row($res2))
	  {
		$vi= $_POST[dvalores][$x];
	    //**** busqueda concepto contable*****
		if($row2[5]!="" && $vi>0)
		{		
	 	$sqlr="insert into  pptocomprobante_det (cuenta,tercero,detalle,valdebito,valcredito,estado,vigencia,tipo_comp,numerotipo) values('".$row2[5]."','".$_POST[tercero]."','INGRESOS SSF',".$vi.",0,'$_POST[estadoc]','$_POST[vigencia]',21,$_POST[idcomp])";
	 	mysql_query($sqlr,$linkbd); 			  
		}
	  }	
	}	
   }
   else
   {
  echo "<table class='inicio'><tr><td class='saludo1'><center>No se ha Actualizado el Ingreso SSF <img src='imagenes/alert.png'><script></script></center></td></tr></table>"; 
	   
	}
}
?>	
</form>
 </td></tr>
</table>
</body>
</html>